<?php
session_start();
include ("../koneksi/konek.php");
$idKunj=$_REQUEST['idKunj'];
$jeniskasir=$_REQUEST['jenisKasir'];
$idPel=$_REQUEST['idPel'];
$inap=$_REQUEST['inap'];
$tipe=$_REQUEST['tipe'];
$for=$_REQUEST['for'];
$all = $_REQUEST['all'];
$idUser=$_REQUEST['idUser'];

$idUnitAmbulan=0;
$idUnitJenazah=0;
$sql="SELECT * FROM b_ms_reference WHERE stref=26";
$rsRef=mysql_query($sql);
if ($rwRef=mysql_fetch_array($rsRef)){
	$idUnitAmbulan=$rwRef["nama"];
}
$sql="SELECT * FROM b_ms_reference WHERE stref=27";
$rsRef=mysql_query($sql);
if ($rwRef=mysql_fetch_array($rsRef)){
	$idUnitJenazah=$rwRef["nama"];
}

$qUsr = mysql_query("SELECT nama,id FROM b_ms_pegawai WHERE id='".$_SESSION['userId']."'");
$rwUsr = mysql_fetch_array($qUsr);
//----------------------------------

$sqlPas="SELECT 
no_rm,
mp.nama nmPas,
mp.id as pasienId,
mp.alamat, 
mp.rt,
mp.rw,
mp.sex, 
(SELECT nama FROM b_ms_wilayah WHERE id=mp.kec_id) nmKec, 
(SELECT nama FROM b_ms_wilayah WHERE id=mp.desa_id) nmDesa,
DATE_FORMAT(k.tgl_sjp,'%d-%m-%Y') AS tgl_sjp
FROM b_kunjungan k 
INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id 
WHERE k.id=$idKunj";
//echo $sqlPas."<br>";
$qPas=mysql_query($sqlPas);
$rw=mysql_fetch_array($qPas);
$pasienId=$rw['pasienId'];
$tgl_sjp=$rw['tgl_sjp'];

/* ======================= TGL ====================== */

if ($tipe=="1") {
	$sTglIn="SELECT
			CONCAT(DATE_FORMAT(IFNULL(tk.tgl_in,p.tgl), '%d-%m-%Y'),' ',DATE_FORMAT(IFNULL(tk.tgl_in,p.tgl_act), '%H:%i')) tgl_in
			FROM b_pelayanan p 
			INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
			WHERE 
			p.kunjungan_id='$idKunj' 
			AND p.jenis_kunjungan=3
			ORDER BY tk.id LIMIT 1";
	
	$sTglOut="SELECT
			DATE_FORMAT(IF(k.pulang=1,k.tgl_pulang,tk.tgl_out), '%d-%m-%Y %H:%i') AS tgl_out
			FROM b_pelayanan p 
			INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
			INNER JOIN b_kunjungan k ON k.id=p.kunjungan_id
			WHERE 
			p.kunjungan_id='$idKunj' 
			AND p.jenis_kunjungan=3
			ORDER BY tk.id DESC LIMIT 1";
}
else if($tipe=="0"){
	$sTglIn="SELECT 
			CONCAT(DATE_FORMAT(IFNULL(p.tgl, k.tgl), '%d-%m-%Y'),' ',DATE_FORMAT(IFNULL(p.tgl_act, k.tgl_act), '%H:%i')) tgl_in
			FROM b_pelayanan p 
			INNER JOIN b_kunjungan k ON k.id=p.kunjungan_id
			WHERE 
			p.kunjungan_id='$idKunj' 
			AND p.jenis_kunjungan<>3
			ORDER BY p.id LIMIT 1";
	
	$sTglOut="SELECT 
			DATE_FORMAT(IFNULL(p.tgl_krs,''),'%d-%m-%Y %H:%i') tgl_out
			FROM b_pelayanan p 
			INNER JOIN b_kunjungan k ON k.id=p.kunjungan_id
			WHERE 
			p.kunjungan_id='$idKunj' 
			AND p.jenis_kunjungan<>3
			ORDER BY p.id DESC LIMIT 1";
}
else {
	$sTglIn="SELECT 
			CONCAT(DATE_FORMAT(IFNULL(p.tgl, k.tgl), '%d-%m-%Y'),' ',DATE_FORMAT(IFNULL(p.tgl_act, k.tgl_act), '%H:%i')) tgl_in
			FROM b_pelayanan p 
			INNER JOIN b_kunjungan k ON k.id=p.kunjungan_id
			WHERE 
			p.kunjungan_id='$idKunj'
			ORDER BY p.id LIMIT 1";
			
	$sTglOut="SELECT 
			DATE_FORMAT(IF(k.pulang=1,k.tgl_pulang,IF(p.sudah_krs=1,p.tgl_krs,'')), '%d-%m-%Y %H:%i') AS tgl_out
			FROM b_pelayanan p 
			INNER JOIN b_kunjungan k ON k.id=p.kunjungan_id
			WHERE 
			p.kunjungan_id='$idKunj'
			ORDER BY p.id DESC LIMIT 1";
}

//echo $sTglIn;
$qTglIn=mysql_query($sTglIn);
$rwTglIn=mysql_fetch_array($qTglIn);
$tglIn=$rwTglIn['tgl_in'];

//echo $sTglOut;
$qTglOut=mysql_query($sTglOut);
$rwTglOut=mysql_fetch_array($qTglOut);
$tglOut=$rwTglOut['tgl_out'];
/* =========================== END TGL ========================== */
//========================= Jika Inap & Ada b_tindakan_kamar yg tgl_out blm nutup --> Ditutup ===================
$sqlCekTglOut="SELECT
				  tk.*
				FROM b_tindakan_kamar tk
				  INNER JOIN b_pelayanan p
					ON tk.pelayanan_id = p.id
				WHERE p.kunjungan_id = '$idKunj'
					AND tk.tgl_out IS NULL";
$rsCekTglOut=mysql_query($sqlCekTglOut);
if (mysql_num_rows($rsCekTglOut)>1){
	$sqlCekTglOut="SELECT
					  tk.*,ifnull(tk.tgl_out,1) as blm_close
					FROM b_tindakan_kamar tk
					  INNER JOIN b_pelayanan p
						ON tk.pelayanan_id = p.id
					WHERE p.kunjungan_id = '$idKunj'
					ORDER BY tk.tgl_in DESC";
	$rsCekTglOut=mysql_query($sqlCekTglOut);
	$iNoTglOut=0;
	while ($rwCekTglOut=mysql_fetch_array($rsCekTglOut)){
		$iNoTglOut++;
		$idKmrTglOut=$rwCekTglOut["id"];
		if ($rwCekTglOut["blm_close"]==1 && $iNoTglOut>1){
			//======Tutup tgl_out
			$sqlUpdtTglOut="UPDATE b_tindakan_kamar SET tgl_out='$iTglIn' WHERE id='$idKmrTglOut' AND tgl_out IS NULL";
			$rsUpdtTglOut=mysql_query($sqlUpdtTglOut);
		}
		$iTglIn=$rwCekTglOut["tgl_in"];
	}
}

/* =========================== BPJS ============================= */

$sql="SELECT * FROM b_inacbg_grouper WHERE kunjungan_id_group='$idKunj'";
$rsJaminan=mysql_query($sql);
$kodeGrouper="";
if (mysql_num_rows($rsJaminan)>0){
	$rwJaminan=mysql_fetch_array($rsJaminan);
	$kodeGrouper=$rwJaminan["kode_grouper_inacbg"];
}

//=====tipe=2-->RJ+RI, tipe=1-->RI, tipe=0-->RJ======
if ($tipe=="2") {
	$skso="SELECT DISTINCT t.kso_id,mk.nama FROM b_pelayanan p
INNER JOIN b_ms_unit mu ON p.unit_id=mu.id INNER JOIN b_tindakan t ON p.id=t.pelayanan_id INNER JOIN b_ms_kso mk ON t.kso_id=mk.id
WHERE p.kunjungan_id='$idKunj'";
}elseif ($tipe=="1") {
	$skso="SELECT DISTINCT t.kso_id,mk.nama 
FROM b_pelayanan p INNER JOIN b_ms_unit mu ON p.unit_id=mu.id INNER JOIN b_tindakan t ON p.id=t.pelayanan_id INNER JOIN b_ms_kso mk ON t.kso_id=mk.id 
WHERE p.kunjungan_id='$idKunj' AND p.jenis_kunjungan=3";
}elseif ($tipe=="0") {
	$skso="SELECT DISTINCT t.kso_id,mk.nama 
FROM b_pelayanan p INNER JOIN b_ms_unit mu ON p.unit_id=mu.id INNER JOIN b_tindakan t ON p.id=t.pelayanan_id INNER JOIN b_ms_kso mk ON t.kso_id=mk.id 
WHERE p.kunjungan_id='$idKunj' AND p.jenis_kunjungan<>3";
}
//echo $skso."<br>";
$qKso=mysql_query($skso);
$status="";
$isBPJS=0;
$isUMUM=0;
$isKSO=0;
while ($rwKso=mysql_fetch_array($qKso)){
	$status .=$rwKso['nama'].", ";
	if ($rwKso['kso_id']==72){
		$isBPJS=1;
	}
	
	if ($rwKso['kso_id']==1){
		$isUMUM=1;
	}
	
	if ($rwKso['kso_id']<>1 && $rwKso['kso_id']<>72){
		$isKSO=1;
	}
}


$status=substr($status,0,strlen($status)-2);
if ($isBPJS==1) $status ="<b> [ ".$kodeGrouper." ]</b>";

if ($tipe=="2"){
	$fJenisKunjungan="";	
}elseif ($tipe=="1"){
	$fJenisKunjungan="AND p.jenis_kunjungan=3";				
}elseif ($tipe=="0"){
	$fJenisKunjungan="AND p.jenis_kunjungan<>3";
}
/* =========================== END BPJS ========================== */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="../theme/print.css" />
        <title>.: Rekap Tagihan Perawatan :.</title>
    </head>

    <body style="margin-top:0px">
        <table width="718" border="0" cellspacing="0" cellpadding="0" align="left" class="kwi">
            <tr class="kwi">
                <td height="30" colspan="2" align="center" style="font-weight:bold;font-size:13px;">
                    Form Konfirmasi Kepulangan (KRS)                </td>
            </tr>
            <tr class="kwi">
                <td colspan="2">
                    <table border="0" width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="19%" style="font-size:12px;padding-left:25px;">No RM</td>
                            <td width="3%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="40%" style="font-size:12px">&nbsp;<?php echo $rw['no_rm'];?></td>
                            <td width="12%" style="font-size:12px">Tgl Mulai</td>
                            <td width="2%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="24%" style="font-size:12px">&nbsp;<?php echo $tglIn;?></td>
                        </tr>
                        <tr>
                            <td width="19%" style="font-size:12px;padding-left:25px;">Nama Pasien </td>
                            <td width="3%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo strtolower($rw['nmPas']);?></td>
                            <td width="12%" style="font-size:12px">Tgl Selesai </td>
                            <td width="2%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="24%" style="font-size:12px">&nbsp;<?php echo $tglOut;?></td>
                        </tr>
                        <tr>
                            <td width="19%" style="font-size:12px;padding-left:25px;">Alamat</td>
                            <td width="3%" align="center" style="font-weight:bold;font-size:12px;">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo strtolower($rw['alamat']);?></td>
                            <td width="12%" style="font-size:12px">&nbsp;</td>
                            <td width="2%" align="center" style="font-weight:bold;font-size:12px">&nbsp;</td>
                            <td width="24%" style="font-size:12px">&nbsp;</td>
                        </tr>
                        <tr>
                            <td width="19%" style="font-size:12px;padding-left:25px;">Kel. / Desa</td>
                          	<td width="3%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo strtolower($rw['nmDesa']);?></td>
                          	<td width="12%" style="font-size:12px">&nbsp;</td>
                            <td width="2%" align="center" style="font-weight:bold;font-size:12px">&nbsp;</td>
                            <td width="24%"></td>
                        </tr>
              </table>	</td>
            </tr>
            <tr>
            	<td width="407">&nbsp;</td>
            </tr>
            <tr class="kwi">
                <td height="30" colspan="2">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr height="30">
                          <td width="26" align="left"  style="border-top:#000000 solid 1px; border-bottom:#000000 solid 1px; font-weight:bold;font-size:12px">&nbsp;</td>
                            <td align="left" width="230" style="padding-left:0px;border-top:#000000 solid 1px; border-bottom:#000000 solid 1px; font-weight:bold;font-size:12px">Uraian Layanan</td>
                            <td align="center" width="110" style="border-top:#000000 solid 1px; border-bottom:#000000 solid 1px; border-left:none; font-weight:bold;font-size:12px; text-transform:none">Hak Kelas</td>
							<td align="center" width="110" style="border-top:#000000 solid 1px; border-bottom:#000000 solid 1px; border-left:none; font-weight:bold;font-size:12px; text-transform:none">s/d Tanggal</td>
                            <td align="center" width="120" style="border-top:#000000 solid 1px; border-bottom:#000000 solid 1px; border-left:none; font-weight:bold;font-size:12px">Jumlah</td>
                            <td align="right" width="147" style="border-top:#000000 solid 1px; border-bottom:#000000 solid 1px; border-left:none; font-weight:bold;font-size:12px;">Biaya&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                        	<td>&nbsp;</td>
                        </tr>
						<?php
						$nTotal=0;
						if ($tipe=="2"){
                        	$sKSO="SELECT id,nama,urutan FROM (SELECT 
									DISTINCT 
									kso.id,
									kso.nama,
									t.id as urutan
									FROM b_pelayanan p
									INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
									INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
									INNER JOIN b_ms_kso kso ON kso.id=t.kso_id
									WHERE p.kunjungan_id='$idKunj' 
									/*AND mu.kategori<>5 
									AND p.unit_id<>$idUnitAmbulan 
									AND p.unit_id<>$idUnitJenazah*/
									UNION
									SELECT 
									DISTINCT 
									kso.id,
									kso.nama,
									tk.id as urutan
									FROM b_pelayanan p
									INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
									INNER JOIN b_ms_kso kso ON kso.id=tk.kso_id
									WHERE p.kunjungan_id='$idKunj') AS tblkso GROUP BY id ORDER BY urutan";
                        }elseif ($tipe=="1"){
                        	$sKSO="SELECT id,nama FROM (SELECT 
									DISTINCT 
									kso.id,
									kso.nama 
									FROM b_pelayanan p
									INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
									INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
									INNER JOIN b_ms_kso kso ON kso.id=t.kso_id
									WHERE p.kunjungan_id='$idKunj' 
									AND p.jenis_kunjungan=3
									/*AND mu.kategori<>5 
									AND p.unit_id<>$idUnitAmbulan 
									AND p.unit_id<>$idUnitJenazah*/
									UNION
									SELECT 
									DISTINCT 
									kso.id,
									kso.nama 
									FROM b_pelayanan p
									INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
									INNER JOIN b_ms_kso kso ON kso.id=tk.kso_id
									WHERE p.kunjungan_id='$idKunj') AS tblkso GROUP BY id ORDER BY nama";
                        }elseif ($tipe=="0"){
                        	$sKSO="SELECT id,nama FROM (SELECT 
									DISTINCT 
									kso.id,
									kso.nama 
									FROM b_pelayanan p
									INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
									INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
									INNER JOIN b_ms_kso kso ON kso.id=t.kso_id
									WHERE p.kunjungan_id='$idKunj' 
									AND p.jenis_kunjungan<>3
									/*AND mu.kategori<>5 
									AND p.unit_id<>$idUnitAmbulan 
									AND p.unit_id<>$idUnitJenazah*/
									) AS tblkso GROUP BY id ORDER BY nama";
                        }
						$qKSO=mysql_query($sKSO);
						
						$totBiaya=0;
						while($rwKSO=mysql_fetch_array($qKSO)){
						?>
						<tr>
                        	<td></td>
                            <td colspan="5" align="left" style="padding-left:0px;font-size:12px;font-weight:bold"><?php echo $rwKSO['nama']?></td>
                        </tr>
						
                        <?php
                        //=====tipe=2-->RJ+RI, tipe=1-->RI, tipe=0-->RJ======
						if ($tipe=="2"){
                        	$sUnit="SELECT * FROM (SELECT 
									DISTINCT 
									p.id,
									DATE_FORMAT(p.tgl,'%d-%m-%Y') as tgl,
									mu.nama nmUnit,
									mu.id idUnit,
									mu.inap,
									mu.penunjang
									FROM b_pelayanan p
									INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
									INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
									WHERE p.kunjungan_id='$idKunj' 
									/*AND mu.kategori<>5 
									AND p.unit_id<>$idUnitAmbulan 
									AND p.unit_id<>$idUnitJenazah*/
									AND t.kso_id='".$rwKSO['id']."' 
									UNION
									SELECT 
									DISTINCT 
									p.id,
									DATE_FORMAT(p.tgl,'%d-%m-%Y') as tgl,
									mu.nama nmUnit,
									mu.id idUnit,
									mu.inap,
									mu.penunjang
									FROM b_pelayanan p
									INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
									INNER JOIN b_ms_unit mu ON mu.id=p.unit_id
									WHERE p.kunjungan_id='$idKunj'
									AND tk.kso_id='".$rwKSO['id']."'
									) AS tblkso GROUP BY idUnit ORDER BY nmUnit";
                        }elseif ($tipe=="1"){
                        	$sUnit="SELECT * FROM (SELECT 
									DISTINCT 
									p.id,
									DATE_FORMAT(p.tgl,'%d-%m-%Y') as tgl,
									mu.nama nmUnit,
									mu.id idUnit,
									mu.inap
									FROM b_pelayanan p
									INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
									INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
									WHERE p.kunjungan_id='$idKunj' 
									AND p.jenis_kunjungan=3
									/*AND mu.kategori<>5 
									AND p.unit_id<>$idUnitAmbulan 
									AND p.unit_id<>$idUnitJenazah*/
									AND t.kso_id='".$rwKSO['id']."'
									UNION
									SELECT 
									DISTINCT 
									p.id,
									DATE_FORMAT(p.tgl,'%d-%m-%Y') as tgl,
									mu.nama nmUnit,
									mu.id idUnit,
									mu.inap
									FROM b_pelayanan p
									INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
									INNER JOIN b_ms_unit mu ON mu.id=p.unit_id
									WHERE p.kunjungan_id='$idKunj'
									AND tk.kso_id='".$rwKSO['id']."') AS tblkso GROUP BY id ORDER BY id";
                        }elseif ($tipe=="0"){
                        	$sUnit="SELECT * FROM (SELECT 
									DISTINCT 
									p.id,
									DATE_FORMAT(p.tgl,'%d-%m-%Y') as tgl,
									mu.nama nmUnit,
									mu.id idUnit,
									mu.inap
									FROM b_pelayanan p
									INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
									INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
									WHERE p.kunjungan_id='$idKunj' 
									AND p.jenis_kunjungan<>3
									/*AND mu.kategori<>5 
									AND p.unit_id<>$idUnitAmbulan 
									AND p.unit_id<>$idUnitJenazah*/
									AND t.kso_id='".$rwKSO['id']."'
									) AS tblkso GROUP BY id ORDER BY id";
                        }
                        //echo $sUnit."<br>";
                        $qUnit=mysql_query($sUnit);
						
						
						
						while($rwUnit=mysql_fetch_array($qUnit)) {
							$nBiaya=0;
							$nKmr=0;	
							
							if ($rwUnit["inap"]==1){
								$sKmr="SELECT 
								SUM(IF(tk.status_out=0,IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,1,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in))*(tk.tarip), 
								IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,0,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in))*(tk.tarip))) biaya
								,if(hk.id=1,'-',hk.nama) as hakkelas								
								FROM b_tindakan_kamar tk 
								INNER JOIN b_pelayanan p ON tk.pelayanan_id=p.id 
								LEFT JOIN b_ms_kamar mk ON tk.kamar_id=mk.id 
								LEFT JOIN b_ms_kelas mKls ON tk.kelas_id=mKls.id 
								INNER JOIN b_ms_kso kso ON tk.kso_id=kso.id
								LEFT JOIN b_ms_kelas hk ON hk.id=tk.kso_kelas_id 
								WHERE 
								p.kunjungan_id = '".$idKunj."'  
								AND p.unit_id='".$rwUnit['idUnit']."'
								AND tk.kso_id='".$rwKSO['id']."'
								AND tk.aktif=1
								ORDER BY tk.tgl_in";
								//echo $sKmr."<br><br>";
								$qKmr=mysql_query($sKmr);
								$rwKmr=mysql_fetch_array($qKmr);
								$nKmr=$rwKmr['biaya'];
								$hakKls=$rwKmr['hakkelas'];
							}
							
							$nTind=0;
							$sTind="SELECT 
									SUM(b_tindakan.qty*b_tindakan.biaya) as biaya
									,hk.nama as hakkelas
									FROM b_tindakan
									INNER JOIN b_pelayanan p ON p.id=b_tindakan.pelayanan_id
									INNER JOIN b_ms_kelas hk ON hk.id=b_tindakan.kso_kelas_id 
									WHERE
									p.kunjungan_id = '".$idKunj."'  
									AND p.unit_id='".$rwUnit['idUnit']."'
									AND b_tindakan.kso_id='".$rwKSO['id']."'";
							//echo $sTind."<br><br><br>";
							$qTind=mysql_query($sTind);
							$rwTind=mysql_fetch_array($qTind);
							$nTind=$rwTind['biaya'];
							$hakKls=$rwTind['hakkelas'];
							
							$nBiaya=$nKmr + $nTind;	
							
							$txtUnit="";
							$jum=0;
							$txt_tgl="";
							if($rwUnit['inap']==0){
								$txt_tgl=$rwUnit['tgl'];
								$sJum="SELECT
									COUNT(*) AS jml
									FROM
									(SELECT 
									p.*
									FROM b_tindakan
									INNER JOIN b_pelayanan p ON p.id=b_tindakan.pelayanan_id
									WHERE
									p.kunjungan_id = '".$idKunj."'
									AND p.unit_id='".$rwUnit['idUnit']."'  
									AND b_tindakan.kso_id='".$rwKSO['id']."' GROUP BY p.id) AS tbl";
								//echo $sJum."<br>";
								$qJum=mysql_query($sJum);
								$rwJum=mysql_fetch_array($qJum);
								$jum=$rwJum['jml'];
								$txtUnit=$jum." kunjungan";
							}
						?>
                        <tr>
                        	<td></td>
                            <td align="left" style="padding-left:25px;font-size:12px;"><?php echo $rwUnit['nmUnit'];?></td>
                            <td align="center"><?php echo $hakKls;?></td>
                            <td align="center"><?php echo $txt_tgl;?></td>
							<td align="center"><?php echo $txtUnit;?></td>
                            <td align="right"><?php echo number_format($nBiaya,0,',','.');?></td>
                        </tr>
                        <?php
							$nTotal+=$nBiaya;
                        } // END UNIT
						$sObat="SELECT 
								SUM((ap.QTY_JUAL-ap.QTY_RETUR) * ap.HARGA_SATUAN) AS SUBTOTAL 
							  FROM
								dbapotek.a_penjualan ap
								inner join b_pelayanan p on p.id=ap.NO_KUNJUNGAN
								inner join b_ms_kso kso on kso.id=p.kso_id
							  WHERE
							  p.kunjungan_id = '".$idKunj."'
							  AND kso.id='".$rwKSO['id']."'
							  AND ap.CARA_BAYAR=2
							  AND ap.KRONIS<>2";
						$qObat=mysql_query($sObat);
						$rwObat=mysql_fetch_array($qObat);
						$nObat=$rwObat['SUBTOTAL'];
						
						$sNObat="SELECT 
								COUNT(*) AS jml,
								DATE_FORMAT(TGL,'%d-%m-%Y') AS tgl
								FROM
								(SELECT 
									ap.*
								  FROM
									dbapotek.a_penjualan ap
									inner join b_pelayanan p on p.id=ap.NO_KUNJUNGAN
									inner join b_ms_kso kso on kso.id=p.kso_id
								  WHERE
								  p.kunjungan_id = '".$idKunj."'
								  AND kso.id='".$rwKSO['id']."'
								  AND ap.CARA_BAYAR=2
								  GROUP BY ap.NO_PENJUALAN,ap.DOKTER,ap.NO_PASIEN ORDER BY ap.TGL DESC) AS tbl";
						//echo $sNObat."<br></br>";
						$qNObat=mysql_query($sNObat);
						$rwNObat=mysql_fetch_array($qNObat);
						$jumResep=$rwNObat['jml'];
						
						if($nObat>0){
						?>
                        <tr>
                        	<td></td>
                            <td align="left" style="padding-left:25px;font-size:12px;"><?php echo "OBAT"; ?></td>
                            <td align="center"><?php echo "";//$rwNObat['tgl']?></td>
                            <td align="center"><?php echo $rwNObat['tgl']?></td>
							<td align="center"><?php echo $jumResep." Resep"?></td>
                            <td align="right"><?php echo number_format($nObat,0,',','.');?></td>
                        </tr>
                        <?php
							$nTotal+=$nObat;
						}
							
						} // END KSO
						?>
                        <tr height="10">
                            <td colspan="6" style="font-weight:bold; border-bottom:solid #000000 1px;"></td>
                        </tr>
                     </table>              </td>
            		</tr>
            <tr>
            	<td>&nbsp;</td>
                <td align="right">Total : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($nTotal,0,',','.');?></td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
            	<td></td>
            <td width="311" align="center" style="font-weight:bold; vertical-align:top">Sidoarjo, <?php echo gmdate('d-m-Y',mktime(date('H')+7));?><br/>
                    Yang Mencetak,<br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/>( <?php echo $rwUsr['nama']?> )              </td>
            </tr>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr id="trTombol">
                <td colspan="2" class="noline" align="center">
                    <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
                    <input id="btnExpExcl" type="button" value="Export --> Excell" onClick="window.open('RincianTindakanKSOExcell.php?idKunj=<?php echo $idKunj; ?>&idPel=<?php echo $idPel; ?>&idUser=<?php echo $idUser; ?>&inap=<?php echo $inap; ?>&tipe=<?php echo $tipe; ?>&for=<?php echo $for; ?>');"/>
                    <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>                </td>
            </tr>
        </table>
    <script type="text/JavaScript">

            function cetak(tombol){
                tombol.style.visibility='collapse';
                if(tombol.style.visibility=='collapse'){
                    if(confirm('Anda Yakin Mau Mencetak Rician Tagihan Pembayaran ?')){
                        setTimeout('window.print()','1000');
                        setTimeout('window.close()','2000');
                    }
                    else{
                        tombol.style.visibility='visible';
                    }

                }
            }
        </script>
    </body>
</html>
<?php 
mysql_close($konek);
?>