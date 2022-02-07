<?php
session_start();
include("../../sesi.php");
?>
<?php 
if($_POST['export']=='excel'){
header("Content-type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="Lap Buku Register Pasien.xls"');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php 
if($_POST['export']!='excel'){
?>
<link type="text/css" rel="stylesheet" href="../../theme/print.css">
<?php 
}
?>
<script type="text/javascript" src="../../theme/js/ajax.js"></script>
<script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../../theme/js/formatPrint.js"></script>
<title>Buku Diagnosis Pasien</title>
</head>

<body>
<?php
	include("../../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$waktu = $_POST['cmbWaktu'];
	if($waktu == 'Harian'){
		$tglAwal = explode('-',$_REQUEST['tglAwal2']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$waktu = " and pl.tgl = '$tglAwal2' ";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
	}
	else if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];
		$thn = $_POST['cmbThn'];
		$waktu = " and month(pl.tgl) = '$bln' and year(pl.tgl) = '$thn' ";
		$Periode = "Bulan $arrBln[$bln] Tahun $thn";
	}
	else{
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		//echo $arrBln[$tglAwal[1]];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = " and pl.tgl between '$tglAwal2' and '$tglAkhir2' ";
		
		$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	}
	
	$sqlUnit1 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['JnsLayanan']."'";
	$rsUnit1 = mysql_query($sqlUnit1);
	$rwUnit1 = mysql_fetch_array($rsUnit1);
	
if($_REQUEST['TmpLayanan']!='0'){	
	$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayanan']."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
	$fUnit=" pl.unit_id=".$_REQUEST['TmpLayanan']." AND";
}else
	$fUnit=" u.parent_id=".$_REQUEST['JnsLayanan']." AND";
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);
	
	$stsPas=$_REQUEST['StatusPas'];
	if($stsPas != 0) {
    	$fKso = " AND b_kunjungan.kso_id = $stsPas ";
	}
?>
<table width="800" border="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;" cellpadding="0">
  <tr>
    <td colspan="13"><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
  </tr>
  <tr>
    <td colspan="13" align="center" height="70" valign="top" style="font-size:14px; font-weight:bold; text-transform:uppercase"><b>Buku Diagnosis Pasien <?php echo $rwUnit1['nama'] ?> - <?php if($_REQUEST['TmpLayanan']=='0') echo "SEMUA"; echo $rwUnit2['nama'] ?><br /><?php echo $Periode;?></b></td>
  </tr>
  <tr>
    <td colspan="7" height="30">&nbsp;<b>TEMPAT LAYANAN : &nbsp;<?php if($_REQUEST['TmpLayanan']=='0') echo "Semua"; echo $rwUnit2['nama'] ?></b></td>
    <td colspan="6" align="right">Yang Mencetak :&nbsp;<b><?php echo $rwPeg['nama'];?></b>&nbsp;</td>
  </tr>
  <tr>
  	<td colspan="13">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
			<tr>
				<td width="3%" style="text-align:center; border-top:1px solid;">No.</td>
				<td width="7%" style="text-align:center; border-top:1px solid;">Tgl Kunjungan</td>
				<td width="5%" style="text-align:center; border-top:1px solid;">No. RM</td>
				<td width="23%" style="border-top:1px solid;">&nbsp;Nama Pasien</td>
				<td width="3%" style="text-align:center; border-top:1px solid;">JK</td>
				<td width="4%" style="text-align:center; border-top:1px solid;">Umur</td>
				<td width="5%" style="text-align:center; border-top:1px solid;">Kunjungan</td>
				<td width="5%" style="border-top:1px solid;">&nbsp;</td>
				<td width="15%" style="border-top:1px solid;">&nbsp;</td>
				<td width="5%" style="border-top:1px solid;">&nbsp;</td>
				<td width="10%" style="border-top:1px solid;">&nbsp;</td>
				<td width="15%" style="border-top:1px solid;">&nbsp;</td>
			</tr>
			<tr>
				<td style="border-bottom:1px solid;">&nbsp;</td>
				<td style="border-bottom:1px solid;">&nbsp;</td>
				<td style="border-bottom:1px solid;">&nbsp;</td>
				<td colspan="4" style="border-bottom:1px solid;">ICD X&nbsp;&nbsp;Diagnosis</td>
				<td colspan="2" style="border-bottom:1px solid;">&nbsp;Dokter</td>
				<td style="text-align:center; border-bottom:1px solid;">Kasus</td>
				<td style="border-bottom:1px solid;">&nbsp;Cara Keluar</td>
				<td style="border-bottom:1px solid;">&nbsp;Keadaan KRS</td>
			</tr>
			 <?php
				$qK = "SELECT b_ms_kso.id, b_ms_kso.nama FROM b_ms_kso
					INNER JOIN b_kunjungan ON b_kunjungan.kso_id = b_ms_kso.id
					INNER JOIN b_pelayanan pl on pl.kunjungan_id = b_kunjungan.id										
					WHERE pl.unit_id = '".$_REQUEST['TmpLayanan']."' $fKso $waktu
					GROUP BY b_ms_kso.nama
					ORDER BY b_ms_kso.nama";
				$rsK = mysql_query($qK);
				while($rwK = mysql_fetch_array($rsK))
				{
			  ?>
			  <tr><td colspan="12">&nbsp;<b><?php echo $rwK['nama']?></b></td></tr>
			<?php
				$sql1 = "SELECT distinct pl.id, DATE_FORMAT(k.tgl, '%d/%m/%Y') AS tgl, p.no_rm, p.nama,
						p.sex, k.umur_thn, IF(k.isbaru=1,'Baru', 'Lama') AS kunjungan
						FROM b_ms_pasien p
						INNER JOIN b_kunjungan k ON k.pasien_id = p.id
						INNER JOIN b_pelayanan pl ON pl.kunjungan_id = k.id		
						WHERE pl.unit_id = '".$_REQUEST['TmpLayanan']."' 
						AND k.kso_id = '".$rwK['id']."' $waktu";
				$rs1 = mysql_query($sql1);
				$no = 1;
				while($rw1 = mysql_fetch_array($rs1))
				{
			?>
			<tr>
				<td style="text-align:center"><?php echo $no;?></td>
				<td style="text-align:center"><?php echo $rw1['tgl'];?></td>
				<td style="text-align:center"><?php echo $rw1['no_rm'];?></td>
				<td style="text-transform:uppercase">&nbsp;<?php echo $rw1['nama'];?></td>
				<td style="text-align:center"><?php echo $rw1['sex'];?></td>
				<td style="text-align:center"><?php echo $rw1['umur_thn'];?></td>
				<td style="text-align:center"><?php echo $rw1['kunjungan'];?></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<?php
					$sql2 = "SELECT pl.id, md.kode, md.nama AS diagnosa, 
							(SELECT nama FROM b_ms_pegawai WHERE id = d.user_id) AS dokter,
							IF(pk.kasus=1,'Lama','Baru') AS kasus, pk.cara_keluar, pk.keadaan_keluar
							FROM b_pelayanan pl 
							LEFT JOIN b_pasien_keluar pk ON pk.pelayanan_id = pl.id
							INNER JOIN b_diagnosa_rm d ON d.pelayanan_id = pl.id
							INNER JOIN b_ms_diagnosa md ON md.id = d.ms_diagnosa_id
							WHERE pl.id = '".$rw1['id']."' GROUP BY md.id";
					$rs2 = mysql_query($sql2);
					while($rw2 = mysql_fetch_array($rs2))
					{
			?>
			<tr style="font-size:10px" valign="top">
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan="4"><?php echo $rw2['kode'];?>&nbsp;&nbsp;<?php echo $rw2['diagnosa']?></td>
				<td colspan="2">&nbsp;<?php echo $rw2['dokter'];?></td>
				<td>&nbsp;<?php echo $rw2['kasus'];?></td>
				<td>&nbsp;<?php echo $rw2['cara_keluar'];?></td>
				<td>&nbsp;<?php echo $rw2['keadaan_keluar'];?></td>
			</tr>
			<?php
					}mysql_free_result($rs2);
					$no++;
					}mysql_free_result($rs1);
					}mysql_free_result($rsK);
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
			</tr>
		</table>
	</td>
  </tr>
  <tr><td colspan="13">&nbsp;</td></tr>
  <tr><td colspan="13">&nbsp;</td></tr>
  <tr><td colspan="13" style="text-align:right">Tgl Cetak:&nbsp;<?php echo $date_now.'&nbsp;Jam:&nbsp;'.$jam?>&nbsp;</td></tr>
  <tr><td colspan="13" height="50" valign="top" style="text-align:right">Yang Mencetak,&nbsp;</td></tr>
  <tr><td colspan="13" style="text-align:right"><b><?php echo $rwPeg['nama'];?></b>&nbsp;</td></tr>
  <tr id="trTombol">
        <td colspan="13" class="noline" align="center">
			<?php 
            if($_POST['export']!='excel'){
            ?>
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
			<?php 
            }
            ?>
        </td>
    </tr>
  <tr><td colspan="13" height="50">&nbsp;</td></tr>
</table>
</body>
<?php
	mysql_free_result($rsUnit1);
	mysql_free_result($rsUnit2);
	mysql_free_result($rsPeg);
	mysql_close($konek);
?>
<script type="text/JavaScript">

try{	
formatF4();
}catch(e){
window.location='../../addon/jsprintsetup.xpi';
}
    function cetak(tombol){
        tombol.style.visibility='hidden';
        if(tombol.style.visibility=='hidden'){
		try{
			mulaiPrint();
		}
		catch(e){
			window.print();
		}
		//window.print();
		window.close();
        }
    }
</script>
</html>
