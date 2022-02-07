<?php 
session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
if($_POST['export']=='excel'){
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="PengirimanKonsul.xls"');
}
//session_start();
$userId = $_SESSION['userId'];
//==========Menangkap filter data====
$jam = date("G:i");
$date_now=gmdate('d-m-Y',mktime(date('H')+7));
$stsPas=$_REQUEST['StatusPas0'];
$stsVer=$_REQUEST['StatusVer'];
if(isset($stsVer) && $stsVer!=''){
	$filterVer=" AND b_tindakan.verifikasi='$stsVer'";
}else{
	$filterVer="";
}
//echo $filterVer;
$tmpLayanan=$_REQUEST['TmpLayananBukanInap'];
$user_act=$_REQUEST['user_act'];
$rsUser=mysql_query("SELECT nip,nama FROM b_ms_pegawai WHERE id=$user_act");
$rwUser=mysql_fetch_array($rsUser);
$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
$waktu = $_POST['cmbWaktu'];
if($waktu == 'Harian'){
	$tglAwal = explode('-',$_REQUEST['tglAwal2']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	$waktu = " AND b_pelayanan.tgl = '$tglAwal2' ";
	$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
}else if($waktu == 'Bulanan'){
	$bln = $_POST['cmbBln'];
	$thn = $_POST['cmbThn'];
	$waktu = " AND month(b_pelayanan.tgl) = '$bln' and year(b_pelayanan.tgl) = '$thn' ";
	$Periode = "Bulan $arrBln[$bln] Tahun $thn";
}else{
	$tglAwal = explode('-',$_REQUEST['tglAwal']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	//echo $arrBln[$tglAwal[1]];
	$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
	$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
	$waktu = " AND b_pelayanan.tgl between '$tglAwal2' and '$tglAkhir2' ";
	$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
}

	$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$tmpLayanan."'";
	//echo $sqlUnit2."<br>";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
	
	$sqlPenjamin = "SELECT nama FROM b_ms_kso WHERE id='".$stsPas."'";
	//echo $sqlPenjamin."<br>";
	$rsPenjamin = mysql_query($sqlPenjamin);
	$hsPenjamin = mysql_fetch_array($rsPenjamin);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Pengajuan Klaim Pasien :.</title>
</head>

<body>
<table align="left" width="800" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td><b><?=$pemkabRS?><br><?=$namaRS?><br><?=$alamatRS?><br>Telepon <?=$tlpRS?><br/></b>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" height="70" valign="top" style="font-weight:bold; font-size:14px; text-transform:uppercase">LAPORAN PENGAJUAN KLAIM PASIEN NON INAP ( <?php if($tmpLayanan=='0') echo 'SEMUA'; else echo $rwUnit2['nama']?> )<br/><?php echo $Periode;?>&nbsp;</td>
  </tr>
  <tr>
    <td height="30" style="font-weight:bold">Penjamin Pasien&nbsp;:&nbsp;<?php echo $hsPenjamin['nama'];?></td>
  </tr>
  <tr>
    <td>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td height="30" width="3%" style="border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold; text-align:center;">No</td>
			<td width="8%" style="border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold; text-align:center;">Tgl. Kunjungan</td>
			<td width="6%" style="border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold; text-align:center;">No.&nbsp;RM</td>
			<td width="20%" style="border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold; text-align:center;">Nama&nbsp;Pasien</td>
			<td style="border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold; text-align:center;">Retribusi</td>
			<td style="border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold; text-align:center;">Tindakan</td>
			<td style="border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold; text-align:center;">PA</td>
			<td style="border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold; text-align:center;">PK</td>
			<td style="border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold; text-align:center;">RAD</td>
			<td style="border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold; text-align:center;">HD</td>
			<td style="border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold; text-align:center; <?php echo $_REQUEST['TmpLayananBukanInap']==45?"display:none;":'';?>">OK</td>
			<td style="border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold; text-align:center;">Endoscopy</td>
			<td style="border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold; text-align:center;">Konsul Poli</td>
			<td style="border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold; text-align:center;">Obat</td>
			<td width="6%" style="border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold; text-align:center;">Total</td>
		<?php
		$retribusi_ver = 0;
		$tindakan_ver = 0;
		$pa_ver = 0;
		$pk_ver = 0;
		$rad_ver = 0;
		$hd_ver = 0;
		$ok_ver = 0;
		$end_ver = 0;
		$konsul_ver = 0;
		$obat_ver = 0;
		$total_ver = 0;
		$sVer="SELECT p.id ,g.nama AS grup FROM b_ms_group_petugas gp
			INNER JOIN b_ms_group g ON g.id=gp.ms_group_id
			INNER JOIN b_ms_pegawai p ON p.id=gp.ms_pegawai_id
			WHERE (g.nama LIKE '%VERIFIKATOR%' OR g.nama LIKE '%CIO%' OR g.ket LIKE '%VERIFIKATOR%')
			AND p.id='$userId'";
		$rsVer=mysql_query($sVer);
		$hidden="none";
		if(mysql_num_rows($rsVer)>0){
		    $rwVer=mysql_fetch_array($rsVer);				
		    $vid=$rwVer['id'];
		    $hidden="table-cell";
		}
		?>
			<td align="center" style="display:<?php echo $hidden;?>;border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold">Verifikasi</td>
			<td align="center" style="display:<?php echo $hidden;?>;border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold">Catatan</td>
		</tr>
		<?php
			if($tmpLayanan != 0){
				$fUnit = "b_ms_unit.id = '".$_REQUEST['TmpLayananBukanInap']."'";
			}else{
				$fUnit = "b_ms_unit.parent_id = '".$_REQUEST['JnsLayanan']."'";
			}
			
			if($stsPas == 0){ //Edited
				$fKSO = "";
			} else {
				$fKSO = "b_pelayanan.kso_id = '".$stsPas."' AND ";
			}
			
			$qUn = "SELECT b_ms_unit.id, b_ms_unit.nama, b_pelayanan.id AS pelayanan_id FROM b_kunjungan
				INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
				INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
				INNER JOIN b_ms_unit ON b_ms_unit.id = b_kunjungan.unit_id
				INNER JOIN b_ms_unit u ON u.id = b_pelayanan.unit_id_asal 
				WHERE $fKSO $fUnit $waktu 
				AND u.parent_id = '76' 
				AND b_pelayanan.batal <> 1
				GROUP BY b_ms_unit.id ORDER BY b_ms_unit.nama";
			//echo $qUn."<br>";
			$rsUn = mysql_query($qUn);			
			while($rwUn = mysql_fetch_array($rsUn))
			{
		?>
		<tr>
			<td colspan="17">&nbsp;<b><?php echo $rwUn['nama'];?></b></td>
		</tr>
		<?php 
		/*$Pas="SELECT b_ms_pasien.no_rm, b_ms_pasien.nama, b_kunjungan.id AS kunjungan_id, 
DATE_FORMAT(b_pelayanan.tgl,'%d/%m/%Y') AS tgl, b_pelayanan.id AS pelayanan_id, 
b_kunjungan.loket_id unit_id_asal, b_pelayanan.jenis_kunjungan AS jenis_kunjungan,b_tindakan.verifikasi 
FROM b_ms_pasien INNER JOIN b_kunjungan ON b_kunjungan.pasien_id = b_ms_pasien.id 
INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id 
INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
INNER JOIN b_ms_unit ON b_ms_unit.id = b_kunjungan.loket_id
WHERE b_kunjungan.kso_id = '".$stsPas."' AND b_kunjungan.unit_id = '".$rwUn['id']."' 
$waktu AND b_ms_unit.parent_id = '76' $filterVer
GROUP BY b_ms_pasien.id,b_kunjungan.id
ORDER BY b_kunjungan.tgl,b_ms_pasien.nama";*/
		$Pas="SELECT b_ms_pasien.no_rm, b_ms_pasien.nama, b_kunjungan.id AS kunjungan_id, 
DATE_FORMAT(b_pelayanan.tgl,'%d/%m/%Y') AS tgl,b_kunjungan.tgl as tglKunj, b_pelayanan.id AS pelayanan_id, 
b_kunjungan.loket_id unit_id_asal, b_pelayanan.jenis_kunjungan AS jenis_kunjungan,b_tindakan.verifikasi 
FROM b_ms_pasien INNER JOIN b_kunjungan ON b_kunjungan.pasien_id = b_ms_pasien.id 
INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id 
INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id_asal
WHERE $fKSO /* b_pelayanan.kso_id = '".$stsPas."' */ b_kunjungan.unit_id = '".$rwUn['id']."' 
$waktu AND b_ms_unit.parent_id = '76' $filterVer
AND b_pelayanan.batal <> 1
GROUP BY b_ms_pasien.id,b_kunjungan.id
ORDER BY b_kunjungan.tgl,b_ms_pasien.nama";
		//echo $Pas."<br>";
		$qPas=mysql_query($Pas);
		$no=0;
		$subtotal=0;
		$subtotTin=0;
		$subtotLab=0;
		$subtotRad=0;
		$subtotOk=0;
		$subtotEnd=0;
		$subtotObat=0;
		$jmlBelum=0;
		$jmlSudah=0;
		while($rwPas=mysql_fetch_array($qPas)){
		$i++;
		$no++;
		$tgl = $rwPas['tgl'];
		$tglKunj = $rwPas['tglKunj'];
		
		$sqlRet ="SELECT SUM(b_tindakan.biaya_pasien * b_tindakan.qty) AS retUm, SUM(b_tindakan.biaya_kso * b_tindakan.qty) AS retKso
		FROM b_pelayanan
		INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_tindakan_kelas 
	ON b_tindakan.ms_tindakan_kelas_id = b_ms_tindakan_kelas.id INNER JOIN b_ms_tindakan ON b_ms_tindakan.id = b_ms_tindakan_kelas.ms_tindakan_id  
	WHERE b_tindakan.kunjungan_id = '".$rwPas['kunjungan_id']."' AND b_ms_tindakan.id<>2363 
	AND b_ms_tindakan.klasifikasi_id = '11'";
		//if ($rwPas['no_rm']=="00013827"){
		//	echo $sqlRet."<br>";
		//}
		$rsRet = mysql_query($sqlRet);
		$rowRet = mysql_fetch_array($rsRet);
		
		/*$sqlTin = "SELECT SUM(b_tindakan.biaya_pasien * b_tindakan.qty) AS tindUm, SUM(b_tindakan.biaya_kso * b_tindakan.qty) AS tindKso 
			FROM b_tindakan
			INNER JOIN b_ms_tindakan_kelas ON b_tindakan.ms_tindakan_kelas_id = b_ms_tindakan_kelas.id
			INNER JOIN b_ms_tindakan ON b_ms_tindakan.id = b_ms_tindakan_kelas.ms_tindakan_id 
			INNER JOIN b_pelayanan ON b_tindakan.pelayanan_id = b_pelayanan.id 
			WHERE b_ms_tindakan.klasifikasi_id <> '11'
			AND b_tindakan.kunjungan_id = '".$rwPas['kunjungan_id']."' AND b_pelayanan.unit_id='".$rwUn['id']."'";*/
		$sqlTin = "SELECT SUM(b_tindakan.biaya_pasien * b_tindakan.qty) AS tindUm, SUM(b_tindakan.biaya_kso * b_tindakan.qty) AS tindKso 
			FROM b_tindakan
			INNER JOIN b_ms_tindakan_kelas ON b_tindakan.ms_tindakan_kelas_id = b_ms_tindakan_kelas.id
			INNER JOIN b_ms_tindakan ON b_ms_tindakan.id = b_ms_tindakan_kelas.ms_tindakan_id 
			INNER JOIN b_pelayanan ON b_tindakan.pelayanan_id = b_pelayanan.id 
			WHERE b_ms_tindakan.klasifikasi_id <> '11'
			AND b_tindakan.kunjungan_id = '".$rwPas['kunjungan_id']."' AND b_pelayanan.unit_id='".$rwUn['id']."'";
		//echo $sqlTin."<br>";
		$rsTin = mysql_query($sqlTin);
		$rowTin = mysql_fetch_array($rsTin);
		
		$sqlLabA = "SELECT IFNULL(SUM(b_tindakan.biaya_pasien * b_tindakan.qty),0) AS PAUm, IFNULL(SUM(b_tindakan.biaya_kso * b_tindakan.qty),0) AS PAKso
			FROM b_tindakan
			INNER JOIN b_pelayanan ON b_tindakan.pelayanan_id = b_pelayanan.id 
			WHERE b_pelayanan.unit_id = '59'
			AND b_pelayanan.unit_id_asal = '".$rwUn['id']."'
			AND b_tindakan.kunjungan_id = '".$rwPas['kunjungan_id']."'";
		//echo $sqlLabA."<br>";
		$rsLabA = mysql_query($sqlLabA);
		$rowLabA = mysql_fetch_array($rsLabA);
		
		$sqlLabK = "SELECT IFNULL(SUM(b_tindakan.biaya_pasien * b_tindakan.qty),0) AS PKUm, IFNULL(SUM(b_tindakan.biaya_kso * b_tindakan.qty),0) AS PKKso
			FROM b_tindakan
			INNER JOIN b_pelayanan ON b_tindakan.pelayanan_id = b_pelayanan.id 
			WHERE b_pelayanan.unit_id = '58'
			AND b_pelayanan.unit_id_asal = '".$rwUn['id']."'
			AND b_tindakan.kunjungan_id = '".$rwPas['kunjungan_id']."'";
		//echo $sqlLabA."<br>";
		$rsLabK = mysql_query($sqlLabK);
		$rowLabK = mysql_fetch_array($rsLabK);
		
		$sqlRad = "SELECT IFNULL(SUM(b_tindakan.biaya_pasien * b_tindakan.qty),0) AS radUm, IFNULL(SUM(b_tindakan.biaya_kso * b_tindakan.qty),0) AS radKso
			FROM b_tindakan
			INNER JOIN b_pelayanan ON b_tindakan.pelayanan_id = b_pelayanan.id 
			WHERE b_pelayanan.unit_id = '61'
			AND b_pelayanan.unit_id_asal = '".$rwUn['id']."'
			AND b_tindakan.kunjungan_id = '".$rwPas['kunjungan_id']."'";
		$rsRad = mysql_query($sqlRad);
		$rowRad = mysql_fetch_array($rsRad);
		
		$sqlHD = "SELECT IFNULL(SUM(b_tindakan.biaya_pasien * b_tindakan.qty),0) AS hdUm, IFNULL(SUM(b_tindakan.biaya_kso * b_tindakan.qty),0) AS hdKso
			FROM b_tindakan
			INNER JOIN b_pelayanan ON b_tindakan.pelayanan_id = b_pelayanan.id 
			WHERE b_pelayanan.unit_id = '65'
			AND b_pelayanan.unit_id_asal = '".$rwUn['id']."'
			AND b_tindakan.kunjungan_id = '".$rwPas['kunjungan_id']."'";
		$rsHD = mysql_query($sqlHD);
		$rowHD = mysql_fetch_array($rsHD);
		
		$sqlOk = "SELECT IFNULL(SUM(b_tindakan.biaya_pasien * b_tindakan.qty),0) AS okUm, IFNULL(SUM(b_tindakan.biaya_kso * b_tindakan.qty),0) AS okKso
			FROM b_tindakan
			INNER JOIN b_pelayanan ON b_tindakan.pelayanan_id = b_pelayanan.id 
			WHERE b_pelayanan.unit_id = '63'
			AND b_pelayanan.unit_id_asal = '".$rwUn['id']."'
			AND b_tindakan.kunjungan_id = '".$rwPas['kunjungan_id']."'";
		$rsOk = mysql_query($sqlOk);
		$rowOk = mysql_fetch_array($rsOk);
		
		$sqlEnd = "SELECT IFNULL(SUM(b_tindakan.biaya_pasien * b_tindakan.qty),0) AS endUm, IFNULL(SUM(b_tindakan.biaya_kso * b_tindakan.qty),0) AS endKso
			FROM b_tindakan
			INNER JOIN b_pelayanan ON b_tindakan.pelayanan_id = b_pelayanan.id 
			WHERE b_pelayanan.unit_id = '67'
			AND b_pelayanan.unit_id_asal = '".$rwUn['id']."'
			AND b_tindakan.kunjungan_id = '".$rwPas['kunjungan_id']."' ";
		$rsEnd = mysql_query($sqlEnd);
		$rowEnd = mysql_fetch_array($rsEnd);
		
		if($rwUn['id']=='45'){
			$fIgd = "AND p.jenis_kunjungan='2'";
		}else{
			$fIgd = "AND p.jenis_kunjungan='1'";
		}
		$qObat="SELECT SUM((ap.QTY_JUAL-ap.QTY_RETUR) * ap.HARGA_SATUAN) AS jml 
FROM (SELECT DISTINCT p.id FROM b_pelayanan p WHERE p.kunjungan_id='".$rwPas['kunjungan_id']."' $fIgd) AS t2 
INNER JOIN $dbapotek.a_penjualan ap ON t2.id=ap.NO_KUNJUNGAN 
WHERE ap.NO_PASIEN='".$rwPas['no_rm']."' AND ap.TGL>='$tglKunj'";
		//echo $qObat."<br>";
		 $rsObat = mysql_query($qObat);
		 $rwObat = mysql_fetch_array($rsObat);
		
		$sqlKon = "SELECT SUM(t.biaya_pasien * t.qty) AS jmlUm, SUM(t.biaya_kso * t.qty) AS jmlKso
FROM b_pelayanan p INNER JOIN b_tindakan t ON p.id=t.pelayanan_id 
WHERE p.kunjungan_id='".$rwPas['kunjungan_id']."' AND t.jenis_kunjungan='".$rwPas['jenis_kunjungan']."'";
		//echo $sqlKon."<br>";
		$rsKon = mysql_query($sqlKon);
		$rowKon = mysql_fetch_array($rsKon);
		
		if($stsPas==1){
			$ret = $rowRet['retUm'];
			$tind = $rowTin['tindUm'];
			$pa = $rowLabA['PAUm'];
			$pk = $rowLabK['PKUm'];
			$rad = $rowRad['radUm'];
			$hd = $rowHD['hdUm'];
			$ok = $rowOk['okUm'];
			$end = $rowEnd['endUm'];
			$kon = $rowKon['jmlUm'];
			$obat = $rwObat['jml'];
		}else{
			$ret = $rowRet['retKso'];
			$tind = $rowTin['tindKso'];
			$pa = $rowLabA['PAKso'];
			$pk = $rowLabK['PKKso'];
			$rad = $rowRad['radKso'];
			$hd = $rowHD['hdKso'];
			$ok = $rowOk['okKso'];
			$end = $rowEnd['endKso'];
			$kon = $rowKon['jmlKso'];
			$obat = $rwObat['jml'];
		}
		
		$sql_unit="select parent_id from b_ms_unit where id='".$rwUn['id']."'";
		$rs_unit=mysql_query($sql_unit);
		$rw_unit=mysql_fetch_array($rs_unit);
		if($rw_unit['parent_id']=='44'){
			$darurat_tidak= " n.parent_id <> 44 AND ";
			$daruratkah=" mu.parent_id <> 44 AND ";
		}else{
			$darurat_tidak= " n.parent_id = 44 AND ";
			$daruratkah=" mu.parent_id <> 44 AND ";
		}
		
		$sqlver = "SELECT p.id FROM b_pelayanan p INNER JOIN b_tindakan t ON t.pelayanan_id = p.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE (p.verifikasi = 0 OR t.verifikasi = 0) AND mu.inap=0 AND p.kunjungan_id='".$rwPas['kunjungan_id']."'";
		$rsver = mysql_query($sqlver);
		if(mysql_num_rows($rsver) > 0){
			$verifikasi = 0;
		}
		else{
			$verifikasi = 1;
		}
	    
	    $sqlCatatan="select note from b_catatan where kunjungan_id='".$rwPas['kunjungan_id']."' and jenis_rawat='0'";
	    $rsCatatan=mysql_query($sqlCatatan);
	    $rwCatatan=mysql_fetch_array($rsCatatan);
		?>
		<tr>
			<td align="center" valign="top"><?php echo $no;?></td>
			<td align="center" valign="top"><?php echo $rwPas['tgl'];?></td>
			<td align="center" valign="top" style="padding-right:5px" ><?php echo $rwPas['no_rm'];?></td>
			<td style="text-transform:uppercase" valign="top"><?php echo $rwPas['nama'];?></td>
			<td align="right" valign="top"><?php echo number_format($ret,0,",",".");?>&nbsp;</td>
			<td align="right" valign="top"><?php echo number_format($tind,0,",",".");?>&nbsp;</td>
			<td align="right" valign="top"><?php echo number_format($pa,0,",",".");?>&nbsp;</td>
			<td align="right" valign="top"><?php echo number_format($pk,0,",",".");?>&nbsp;</td>
			<td align="right" valign="top"><?php echo number_format($rad,0,",",".");?>&nbsp;</td>
			<td align="right" valign="top"><?php echo number_format($hd,0,",",".");?>&nbsp;</td>
			<td align="right" valign="top" style="<?php echo $_REQUEST['TmpLayananBukanInap']==45?"display:none;":'';?>"><?php echo number_format($ok,0,",",".");?>&nbsp;</td>
			<td align="right" valign="top"><?php echo number_format($end,0,",",".");?>&nbsp;</td>
			<?php
					/*$sqlCekInap1 = "SELECT b_pelayanan.id FROM b_pelayanan INNER JOIN b_ms_unit ON b_pelayanan.unit_id=b_ms_unit.id 
WHERE b_pelayanan.kunjungan_id='".$rwPas['kunjungan_id']."' AND b_ms_unit.inap=1 ORDER BY b_pelayanan.id LIMIT 1";
					$rsCekInap1 = mysql_query($sqlCekInap1);
					if(mysql_num_rows($rsCekInap1)>0){
						$konsul = $kon;
					}else{
						$jmlTind = $ret+$tind+$pa+$pk+$rad+$hd+$ok+$end;
						$konsul = $kon-$jmlTind;
					}*/
					$jmlTind = $ret+$tind+$pa+$pk+$rad+$hd+$ok+$end;
					$konsul = $kon-$jmlTind;
					$biayaTotal = $ret+$tind+$pa+$pk+$rad+$hd+$ok+$end+$konsul+$obat;
			?>
			<td align="right" valign="top"><?php echo number_format($konsul,0,",",".")?>&nbsp;</td>
			<td align="right" valign="top"><?php echo number_format($obat,0,",",".")?>&nbsp;</td>
			<td align="right" valign="top"><?php echo number_format($biayaTotal,0,",",".")?>&nbsp;</td>
			<td align="center" valign="top" style="display:<?php echo $hidden;?>;color:<?php echo ($verifikasi==0 || $verifikasi=='')?'#990000':'#000099';?>"><?php echo ($verifikasi==0 || $verifikasi=='')?'belum':'sudah';?>&nbsp;</td>
			<td align="left" valign="top" style="display:<?php echo $hidden;?>"><?php echo $rwCatatan['note'];?>&nbsp;</td>
		</tr>
		<?php
			if($verifikasi == 1){
				$retribusi_ver += $ret;
				$tindakan_ver += $tind;
				$pa_ver += $pa;
				$pk_ver += $pk;
				$rad_ver += $rad;
				$hd_ver += $hd;
				$ok_ver += $ok;
				$end_ver += $end;
				$konsul_ver += $konsul;
				$obat_ver += $obat;
				$total_ver += $biayaTotal;
			}
		
			$sRet+=$ret;
			$sTind+=$tind;
			$sPA+=$pa;
			$sPK+=$pk;
			$sRAD+=$rad;
			$sHD+=$hd;
			$sOk+=$ok;
			$sEnd+=$end;
			$sKonsul+=$konsul;
			$sObat+=$obat;
			$sTot+=$biayaTotal;
			}
			//mysql_free_result($qNilai);
			//mysql_free_result($qPas);
		}
		mysql_free_result($rsUn);
		?>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td style="display:<?php echo $hidden;?>">&nbsp;</td>
			<td style="display:<?php echo $hidden;?>">&nbsp;</td>
		</tr>
		<tr height="30">
			<td>&nbsp;</td>
			<td colspan="3" style="border-bottom:#000000 1px solid; border-top:#000000 1px solid; font-weight:bold">Jumlah Pasien&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $i?></td>
			<td align="right" style="border-bottom:#000000 1px solid; border-top:#000000 1px solid; font-weight:bold"><?php echo number_format($sRet,0,",",".")?>&nbsp;</td>
			<td align="right" style="border-bottom:#000000 1px solid; border-top:#000000 1px solid; font-weight:bold"><?php echo number_format($sTind,0,",",".")?>&nbsp;</td>
			<td align="right" style="border-bottom:#000000 1px solid; border-top:#000000 1px solid; font-weight:bold"><?php echo number_format($sPA,0,",",".")?>&nbsp;</td>
			<td align="right" style="border-bottom:#000000 1px solid; border-top:#000000 1px solid; font-weight:bold"><?php echo number_format($sPK,0,",",".")?>&nbsp;</td>
			<td align="right" style="border-bottom:#000000 1px solid; border-top:#000000 1px solid; font-weight:bold"><?php echo number_format($sRAD,0,",",".")?>&nbsp;</td>
			<td align="right" style="border-bottom:#000000 1px solid; border-top:#000000 1px solid; font-weight:bold"><?php echo number_format($sHD,0,",",".")?>&nbsp;</td>
			<td align="right" style="border-bottom:#000000 1px solid; border-top:#000000 1px solid; font-weight:bold; <?php echo $_REQUEST['TmpLayananBukanInap']==45?"display:none;":'';?>"><?php echo number_format($sOk,0,",",".")?>&nbsp;</td>
			<td align="right" style="border-bottom:#000000 1px solid; border-top:#000000 1px solid; font-weight:bold"><?php echo number_format($sEnd,0,",",".")?>&nbsp;</td>
			<td align="right" style="border-bottom:#000000 1px solid; border-top:#000000 1px solid; font-weight:bold"><?php echo number_format($sKonsul,0,",",".")?>&nbsp;</td>
			<td align="right" style="border-bottom:#000000 1px solid; border-top:#000000 1px solid; font-weight:bold"><?php echo number_format($sObat,0,",",".")?>&nbsp;</td>
			<td align="right" style="border-bottom:#000000 1px solid; border-top:#000000 1px solid; font-weight:bold">&nbsp;<?php echo number_format($sTot,0,",",".")?>&nbsp;</td>
			<td align="right" style="border-bottom:#000000 1px solid; border-top:#000000 1px solid; font-weight:bold;display:<?php echo $hidden;?>">&nbsp;</td>
			<td align="right" style="border-bottom:#000000 1px solid; border-top:#000000 1px solid; font-weight:bold;display:<?php echo $hidden;?>">&nbsp;</td>
		</tr>
		<tr>
		   <td height="20" colspan="4">&nbsp;
		   <span style="display:<?php echo $hidden;?>">Sudah Diverifikasi : <?php echo $jmlSudah;?></span>&nbsp;		   </td>
		   <td align="right" style="font-weight:bold;display:<?php echo $hidden;?>"><?php echo number_format($retribusi_ver,0,",",".")?>&nbsp;</td>
		   <td align="right" style="font-weight:bold;display:<?php echo $hidden;?>"><?php echo number_format($tindakan_ver,0,",",".")?>&nbsp;</td>
		   <td align="right" style="font-weight:bold;display:<?php echo $hidden;?>"><?php echo number_format($pa_ver,0,",",".")?>&nbsp;</td>
		   <td align="right" style="font-weight:bold;display:<?php echo $hidden;?>"><?php echo number_format($pk_ver,0,",",".")?>&nbsp;</td>
		   <td align="right" style="font-weight:bold;display:<?php echo $hidden;?>"><?php echo number_format($rad_ver,0,",",".")?>&nbsp;</td>
		   <td align="right" style="font-weight:bold;display:<?php echo $hidden;?>"><?php echo number_format($hd_ver,0,",",".")?>&nbsp;</td>
		   <td align="right" style="font-weight:bold;display:<?php echo $hidden;?>; <?php echo $_REQUEST['TmpLayananBukanInap']==45?"display:none;":'';?>"><?php echo number_format($ok_ver,0,",",".")?>&nbsp;</td>
		   <td align="right" style="font-weight:bold;display:<?php echo $hidden;?>"><?php echo number_format($end_ver,0,",",".")?>&nbsp;</td>
		   <td align="right" style="font-weight:bold;display:<?php echo $hidden;?>"><?php echo number_format($konsul_ver,0,",",".")?>&nbsp;</td>
		   <td align="right" style="font-weight:bold;display:<?php echo $hidden;?>"><?php echo number_format($obat_ver,0,",",".")?>&nbsp;</td>
		   <td align="right" style="font-weight:bold;display:<?php echo $hidden;?>"><?php echo number_format($total_ver,0,",",".")?>&nbsp;</td>
		   <td align="right" style="font-weight:bold;display:<?php echo $hidden;?>">&nbsp;</td>
		   <td align="right" style="font-weight:bold;display:<?php echo $hidden;?>">&nbsp;</td>
		</tr>
		<tr>
		   <td height="20" colspan="4">&nbsp;
		   <span style="display:<?php echo $hidden;?>">Belum Diverifikasi : <?php echo $jmlBelum;?></span>&nbsp;		   </td>
		   <td align="right" style="font-weight:bold;display:<?php echo $hidden;?>"><?php echo number_format($sRet-$retribusi_ver,0,",",".")?>&nbsp;</td>
		   <td align="right" style="font-weight:bold;display:<?php echo $hidden;?>"><?php echo number_format($sTind-$tindakan_ver,0,",",".")?>&nbsp;</td>
		   <td align="right" style="font-weight:bold;display:<?php echo $hidden;?>"><?php echo number_format($sPA-$pa_ver,0,",",".")?>&nbsp;</td>
		   <td align="right" style="font-weight:bold;display:<?php echo $hidden;?>"><?php echo number_format($sPK-$pk_ver,0,",",".")?>&nbsp;</td>
		   <td align="right" style="font-weight:bold;display:<?php echo $hidden;?>"><?php echo number_format($sRAD-$rad_ver,0,",",".")?>&nbsp;</td>
		   <td align="right" style="font-weight:bold;display:<?php echo $hidden;?>"><?php echo number_format($sHD-$hd_ver,0,",",".")?>&nbsp;</td>
		   <td align="right" style="font-weight:bold;display:<?php echo $hidden;?>; <?php echo $_REQUEST['TmpLayananBukanInap']==45?"display:none;":'';?>"><?php echo number_format($sOk-$ok_ver,0,",",".")?>&nbsp;</td>
		   <td align="right" style="font-weight:bold;display:<?php echo $hidden;?>"><?php echo number_format($sEnd-$end_ver,0,",",".")?>&nbsp;</td>
		   <td align="right" style="font-weight:bold;display:<?php echo $hidden;?>"><?php echo number_format($sKonsul-$konsul_ver,0,",",".")?>&nbsp;</td>
		   <td align="right" style="font-weight:bold;display:<?php echo $hidden;?>"><?php echo number_format($sObat-$obat_ver,0,",",".")?>&nbsp;</td>
		   <td align="right" style="font-weight:bold;display:<?php echo $hidden;?>"><?php echo number_format($sTot-$total_ver,0,",",".")?>&nbsp;</td>
		   <td align="right" style="font-weight:bold;display:<?php echo $hidden;?>">&nbsp;</td>
		   <td align="right" style="font-weight:bold;display:<?php echo $hidden;?>">&nbsp;</td>
		</tr>
		<tr>
		   <td height="30" colspan="4">&nbsp;
		   <span style="display:<?php echo $hidden;?>">Total Pasien : <?php echo $jmlSudah+$jmlBelum;?></span>		   </td>
		</tr>
	</table>
	</td>
  </tr>
  <tr>
    <td align="right" style="font-size:12px">Tgl Cetak: <?php echo $date_now;?>&nbsp;Jam: <?php echo $jam;?></td>
  </tr>
  <tr>
    <td align="right" style="font-size:12px">Yang Mencetak,&nbsp;<br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/><b><?php echo $rwUser['nama']?></b>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr id="trTombol">
        <td colspan="4" class="noline" align="center">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
        </td>
    </tr>
</table>
</body>
<?php
	//mysql_free_result($qPenjamin);
	//mysql_free_result($qUser);
	mysql_close($konek);
?>
</html>
<script type="text/JavaScript">

/* try{	
formatF4();
}catch(e){
window.location='../../addon/jsprintsetup.xpi';
} */
    function cetak(tombol){
        tombol.style.visibility='hidden';
        if(tombol.style.visibility=='hidden'){
		/* try{
			mulaiPrint();
		}
		catch(e){
			window.print();
		} */
		window.print();
		window.close();
        }
    }
</script>
