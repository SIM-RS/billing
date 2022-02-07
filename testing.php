<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body>
<?php 
echo "Start Koneksi Database = ".gmdate('d-m-Y H:i:s',mktime(date('H')+7))."<br>";
include("billing/koneksi/konek.php");
echo "Koneksi Database Sukses = ".gmdate('d-m-Y H:i:s',mktime(date('H')+7))."<br>";
echo "Start Query = ".gmdate('d-m-Y H:i:s',mktime(date('H')+7))."<br>";
$sql="SELECT mp.nama pasien,mp.alamat,mu.nama unit,peg.nama petugas,DATE_FORMAT(p.tgl_act,'%d-%m-%Y %H:%i:%s') tglp FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id 
INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
LEFT JOIN b_ms_pegawai peg ON p.user_act=peg.id WHERE k.tgl=CURDATE() ORDER BY k.id,p.id";
$rs=mysql_query($sql);
echo "End Query = ".gmdate('d-m-Y H:i:s',mktime(date('H')+7))."<br>";
echo "Jumlah Data = ".mysql_num_rows($rs)."<br>";
echo "Start Fetch Data = ".gmdate('d-m-Y H:i:s',mktime(date('H')+7))."<br>";
?>
<br />
<table cellpadding="0" cellspacing="0" border="1" style="border-collapse:collapse">
<tr>
	<td>Nama</td>
    <td>Alamat</td>
    <td>Unit</td>
    <td>Petugas Entry</td>
    <td>Waktu</td>
</tr>
<?php
while ($rw=mysql_fetch_array($rs)){
?>
<tr>
	<td><?php echo $rw["pasien"]; ?></td>
    <td><?php echo $rw["alamat"]; ?></td>
    <td><?php echo $rw["unit"]; ?></td>
    <td><?php echo $rw["petugas"]; ?></td>
    <td align="center"><?php echo $rw["tglp"]; ?></td>
</tr>
<?php
}
?>
</table><br />
<?php
echo "End Fetch Data = ".gmdate('d-m-Y H:i:s',mktime(date('H')+7))."<br>";
?>
</body>
</html>
