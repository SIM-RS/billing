<?php 
	include("../sesi.php");
	$excell = $_REQUEST['excell'];
	if ($excell=="1"){
		header("Content-type: application/vnd.ms-excel");
		header('Content-Disposition: attachment; filename="Lap Pengajuan Klaim.xls"');		
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Laporan Realisasi Anggaran</title>
</head>
<?

  include("../koneksi/konek.php");
  $mon = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Nopember","Desember");
  $mon2 = array("","01","02","03","04","05","06","07","08","09","10","11","12");
  $bln = $_REQUEST['cmbBln'];$bulan = $mon[$bln]; $bulan2 = $mon2[$bln];
  $thn = $_REQUEST['cmbThn'];
?>
<body>
<table width="1200" border="0" align="center" cellpadding="2" cellspacing="0" style="font:bold 12px tahoma; text-transform:uppercase;">
  <tr>
    <td><?=$pemkabRS;?> </td>
  </tr>
  <tr>
    <td>LAPORAN BEBAN PUSAT PELAYANAN RUMAH SAKIT</td>
  </tr>
  <tr>
    <td>BULAN <?=$bulan;?> <?=$thn;?></td>
  </tr>
</table>
<br />
<table width="1200" border="1" align="center" cellpadding="2" cellspacing="1" style="border:1px solid #000000; border-collapse:collapse; font:12px tahoma; padding:2px;">
  <tr align="center" style="font:bold 12px tahoma; background-color:#CCCCCC;">
    <td width="124" height="36">Kode Rekening Pelayanan</td>
    <td width="268">Uraian</td>
    <td width="231">Jumlah Beban Pelayanan</td>
  </tr>

  <tr align="center" style="font:12px tahoma; background-color:#DDDDDD;"> 
    <td>1</td>
    <td>2</td>
    <td>3</td>
  </tr>
  
  <?php 
    $db_hrd = "hrd";
    $sql = "SELECT kpp.*, (SELECT SUM(tms.`salary`) FROM $db_hrd.tbl_salary_payment tsp 
    INNER JOIN $db_hrd.tbl_employee_placement tep ON tsp.`employee_id` = tep.`employee_id`
    INNER JOIN $db_hrd.tbl_merit_salary tms ON tms.`id` = tep.`id_merit_salary`
    WHERE kpp.id = tsp.`id_kpp` AND MONTH(tsp.payment_date) = '$bln' AND YEAR(tsp.payment_date) = '$thn') AS Beban_Pelayanan 
    FROM $db_hrd.tbl_kode_pusat_pelayanan kpp
    ";
    $q = mysql_query($sql);
    while($d=mysql_fetch_array($q))
    {
  ?>
  <tr>
    <td><?=$d['kode'];?></td>
    <td><?=$d['nama'];?></td>
    <td><?=Rp. number_format( $d['Beban_Pelayanan'],2,",",".");?></td>
  </tr>
  <?
  }
  ?>
</table>
<br />
<table width="695" border="0" align="center" cellpadding="2" cellspacing="0">
  <tr>
    <td><div align="center"><button onclick="window.open('Re_Ang_excell.php?cmbBln=<?=$bln?>&cmbThn=<?=$thn;?>')"><img src="../icon/addcommentButton.jpg" width="17" height="17" align="left" />&nbsp;EXPORT ke EXCELL</button></div>
	</td>
  </tr>
</table>
</body>
</html>
