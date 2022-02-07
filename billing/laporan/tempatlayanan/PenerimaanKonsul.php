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
<title>Penerimaan Konsul</title>
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
	$waktu = " b_pelayanan.tgl = '$tglAwal2' ";
	$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
}
else if($waktu == 'Bulanan'){
	$bln = $_POST['cmbBln'];
	$thn = $_POST['cmbThn'];
	$waktu = " month(b_pelayanan.tgl) = '$bln' and year(b_pelayanan.tgl) = '$thn' ";
	$Periode = "Bulan $arrBln[$bln] Tahun $thn";
}
else{
	$tglAwal = explode('-',$_REQUEST['tglAwal']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	//echo $arrBln[$tglAwal[1]];
	$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
	$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
	$waktu = " b_pelayanan.tgl between '$tglAwal2' and '$tglAkhir2' ";
	
	$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
}
	
	$sqlJnsLay = "SELECT nama FROM b_ms_unit WHERE id = '".$_REQUEST['JnsLayanan']."'";
	$rsJnsLay = mysql_query($sqlJnsLay);
	$rwJnsLay = mysql_fetch_array($rsJnsLay);
	
if($_REQUEST['TmpLayanan']!=0){
	$sqlTmpLay = "SELECT nama FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayanan']."'";
	$rsTmpLay = mysql_query($sqlTmpLay);
	$rwTmpLay = mysql_fetch_array($rsTmpLay);mysql_free_result($rsTmpLay);
	$fUnit = " AND b_pelayanan.unit_id=".$_REQUEST['TmpLayanan'];
}else
	$fUnit = " AND b_ms_unit.parent_id=".$_REQUEST['JnsLayanan'];
	

$stsPas=$_REQUEST['StatusPas'];
if($stsPas != 0) {
    $fKso = " AND b_kunjungan.kso_id = $stsPas ";
    $qJnsLay=mysql_query("select nama from b_ms_kso where id=".$stsPas);
    $rwJnsLay=mysql_fetch_array($qJnsLay);
}

$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
$rsPeg = mysql_query($sqlPeg);
$rwPeg = mysql_fetch_array($rsPeg);
?>
<table width="800" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td colspan="7"><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
  </tr>
  <tr>
    <td colspan="7" align="center" height="70" valign="top" style="font-size:14px; text-transform:uppercase"><b>Laporan Penerimaan Konsul <?php echo $rwTmpLay['nama']."<br/>".$Periode ?><br />
    </b></td>
  </tr>
  <tr height="30">
 	<td colspan="4">&nbsp;<b>Penjamin Pasien : <?php if($stsPas==0) echo 'Semua'; else echo $rwJnsLay['nama'];?></b></td>
    <td colspan="3" style="text-align:right">Yang Mencetak :&nbsp;<b><?php echo $rwPeg['nama'];?></b>&nbsp;</td>
  </tr>
  <tr height="30">
    <td width="5%" align="center" style="border-top:1px solid; border-bottom:1px solid; font-weight:bold;">&nbsp;No.</td>
    <td width="15%" align="center" style="border-top:1px solid; border-bottom:1px solid; font-weight:bold;">&nbsp;Tgl. Konsul</td>
    <td width="20%" align="center" style="border-top:1px solid; border-bottom:1px solid; font-weight:bold;">&nbsp;Asal Tempat Layanan</td>
    <td width="10%" align="center" style="border-top:1px solid; border-bottom:1px solid; font-weight:bold;">&nbsp;No. RM</td>
    <td width="30%" align="center" style="border-top:1px solid; border-bottom:1px solid; font-weight:bold;">&nbsp;Nama</td>
    <td width="10%" align="center" style="border-top:1px solid; border-bottom:1px solid; font-weight:bold;">&nbsp;JK</td>
    <td width="10%" align="center" style="border-top:1px solid; border-bottom:1px solid; font-weight:bold;">&nbsp;Umur</td>
  </tr>
  <?php
  		$qUnit = "SELECT b_ms_unit.id, b_ms_unit.nama FROM b_kunjungan 
			INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
			INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id WHERE $waktu $fUnit
			GROUP BY b_ms_unit.id";
		$rsUnit = mysql_query($qUnit);
		while($rwUnit = mysql_fetch_array($rsUnit))
		{
  ?>
  <tr>
  	<td colspan="7" height="30" valign="bottom">&nbsp;<b><?php echo $rwUnit['nama'];?></b></td>
  </tr>
  <?php
  	$sqlKonsul = "SELECT DATE_FORMAT(b_pelayanan.tgl_act,'%d-%m-%Y %H:%i:%s') tgl,b_ms_unit.nama,b_ms_pasien.no_rm,b_ms_pasien.nama nmPasien,b_ms_pasien.sex,b_kunjungan.umur_thn,b_kunjungan.umur_hr,b_kunjungan.umur_bln FROM b_kunjungan INNER JOIN b_pelayanan ON b_kunjungan.id=b_pelayanan.kunjungan_id INNER JOIN b_ms_pasien ON b_kunjungan.pasien_id=b_ms_pasien.id INNER JOIN b_ms_unit ON b_pelayanan.unit_id_asal=b_ms_unit.id INNER JOIN b_ms_unit u ON u.id = b_pelayanan.unit_id_asal WHERE $waktu AND b_pelayanan.unit_id = '".$rwUnit['id']."' AND u.parent_id <> '76' $fKso ORDER BY b_ms_unit.nama,b_pelayanan.tgl_act";
	$rsKonsul = mysql_query($sqlKonsul);
	$no = 1;
  	$aSex = array('L'=>'Laki-Laki','P'=>'Perempuan');
	while($rwKonsul = mysql_fetch_array($rsKonsul))
 	{
  ?>
  <tr>
	<td align="center"><?php echo $no;?></td>
	<td align="center"><?php echo $rwKonsul['tgl']?>&nbsp;</td>
	<td style="text-transform:uppercase">&nbsp;<?php echo $rwKonsul['nama']?></td>
	<td align="center"><?php echo $rwKonsul['no_rm']?>&nbsp;</td>
	<td style="text-transform:uppercase">&nbsp;<?php echo $rwKonsul['nmPasien']?></td>
	<td align="center"><?php echo $aSex[$rwKonsul['sex']]?></td>
	<td align="center"><?php echo $rwKonsul['umur_thn']." th ".$rwKonsul['umur_bln']." bln".$rwKonsul['umur_hr']." hr"?>&nbsp;</td>
  </tr>
  <?php
  		 $no++;
	}mysql_free_result($rsKonsul);
	}mysql_free_result($rsUnit);
  ?>
  <tr><td colspan="7" height="30">&nbsp;</td></tr>
  <tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td colspan="3" align="right">Tgl Cetak:&nbsp;<?php echo $date_now.'&nbsp;Jam:&nbsp;'.$jam;?></td>
  </tr>
  <tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td colspan="2" align="right">Yang Mencetak</td>
  </tr>
  <tr>
  	<td colspan="7" height="50">&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td colspan="2" align="right"><b><?php echo $rwPeg['nama'];?></b></td>
  </tr>
  <tr id="trTombol">
  	<td colspan="5" align="center" class="noline">
		<?php 
        if($_POST['export']!='excel'){
        ?>
		<input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
        <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>	</td>
		<?php 
        }
        ?>
  </tr>
</table>
</body>
<?php
	mysql_free_result($rsJnsLay);
	mysql_free_result($rsPeg);
	mysql_close($konek);?>
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
</html>
