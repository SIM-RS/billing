<?php 
include("../koneksi/konek.php");
$IdPel=$_REQUEST['idPel'];
$IdSoapier=$_REQUEST['soapier_id'];
$sql="SELECT
  c.id,
  c.no_rm,
  c.nama,
  b.umur_thn,
  b.umur_bln,
  c.sex
FROM b_pelayanan a
  INNER JOIN b_kunjungan b
    ON a.kunjungan_id = b.id
  INNER JOIN b_ms_pasien c
    ON b.pasien_id = c.id WHERE a.id='".$IdPel."' GROUP BY c.id";
	$q=mysql_query($sql);
	$r=mysql_fetch_array($q);

	header("Location:../rekam_medis/rm_catatan_pasien_terintegrasi/cetak_catatan_pasien_terintegrasi.php?idPel=".$IdPel."&id=".$IdSoapier);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>S O A P I E R</title>
<link rel="stylesheet" href="soap_style.css" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 24px}
-->
</style>
</head>

<body>
<table width="1000" align="center" cellpadding="0" cellspacing="0">
<tr>
	<td class="textJdl1">LAPORAN SOAPIER</td>
</tr>
</table>
<br />
<table width="1000" align="center" cellpadding="0" cellspacing="0">
<tr>
	<td width="171" align="center" class="jdlkiri"><strong>Nama Pasien</strong></td>
	<td width="134" align="center" class="jdl"><strong>Umur</strong></td>
	<td width="144" align="center" class="jdl"><strong>Jenis Kelamin</strong></td>
    <td width="121" align="center" class="jdl"><strong>No.RM</strong></td>
</tr>
<tr>
	<td class="isikiri" align="center"><?php echo $r['nama'] ?></td>
	<td class="isi"><?php echo $r[3]." Thn&nbsp;".$r[4]." Bln" ?></td>
	<td class="isi"><input type="checkbox" <?php if($r[5]=="L") echo "checked" ?> disabled="disabled"> Laki laki <br><input type="checkbox" <?php if($r[5]=="P") echo "checked" ?> disabled="disabled"> Perempuan</td>
	<td class="isi" align="center"><?php echo $r[1] ?></td>
</tr>
</table>
<br />
<?php
$sql="SELECT
IF(s.jenis=0,'Perawat','Dokter') AS petugas, 
pg.nama,
DATE_FORMAT(s.tgl,'%d-%m-%Y %h:%i') AS tanggal,
DATE_FORMAT(s.tgl,'%d-%m-%Y') AS tgl_,
s.* 
FROM $dbaskep.ask_soap s
INNER JOIN b_ms_pegawai pg ON pg.id=s.user_id 
WHERE s.id='".$IdSoapier."' AND s.status_soap=1";
$queri=mysql_query($sql);
$row=mysql_fetch_array($queri);
?>
<table width="1000" align="center" cellpadding="0" cellspacing="0">
<tr>
	<td class="txt2Bold" colspan="3"><?=$row['petugas']; ?> : <span class="txtKecil"><?=$row['nama']; ?></span></td>
    <td class="txt2Bold" align="right">Tanggal & Jam : <span class="txtKecil"><?=$row['tanggal']; ?></span></td>
</tr>
<tr>
	<td width="47" align="center" class="isikiri" style="border-top:1px solid; font-weight:bold">No.</td>
    <td width="118" class="isi" style="border-top:1px solid; font-weight:bold" align="center">Tanggal</td>
	<td width="107" align="center" class="isi" style="border-top:1px solid; font-weight:bold">Kategori</td>
	<td width="726" class="isi" style="border-top:1px solid; vertical-align:top; padding-left:10px; font-weight:bold" align="center">Uraian</td>
  </tr>
<tr>
	<td width="47" align="center" class="isikiri">1.</td>
    <td width="118" class="isi" align="center"><?=$row['tgl_']; ?></td>
	<td width="107" align="center" class="isi" style=""><strong class="textJdl1 style1">S</strong></td>
	<td width="726" class="isi" style=" vertical-align:top; padding-left:10px;"><?=$row['ket_S']; ?></td>
  </tr>		
<tr>
	<td align="center" class="isikiri">2.</td>
    <td class="isi" align="center"><?=$row['tgl_']; ?></td>
	<td align="center" class="isi"><strong class="textJdl1 style1">O</strong></td>
	<td class="isi" style="vertical-align:top; padding-left:10px;"><?=$row['ket_O']; ?></td>
  </tr>	
<tr>
	<td align="center" class="isikiri">3.</td>
    <td class="isi" align="center"><?=$row['tgl_']; ?></td>
	<td align="center" class="isi"><strong class="textJdl1 style1">A</strong></td>
	<td class="isi" style="vertical-align:top; padding-left:10px;"><?=$row['ket_A']; ?></td>
  </tr>	
<tr>
	<td align="center" class="isikiri">4.</td>
    <td class="isi" align="center"><?=$row['tgl_']; ?></td>
	<td align="center" class="isi"><strong class="textJdl1 style1">P</strong></td>
	<td class="isi" style="vertical-align:top; padding-left:10px;"><?=$row['ket_P']; ?></td>
  </tr>
<tr style="display:none">
	<td align="center" class="isikiri">5.</td>
    <td class="isi" align="center"><?=$row['tgl_']; ?></td>
	<td align="center" class="isi"><strong class="textJdl1 style1">I</strong></td>
	<td class="isi" style="vertical-align:top; padding-left:10px;"><?=$row['ket_I']; ?></td>
  </tr>
<tr style="display:none">
	<td align="center" class="isikiri">6.</td>
    <td class="isi" align="center"><?=$row['tgl_']; ?></td>
	<td align="center" class="isi"><strong class="textJdl1 style1">E</strong></td>
	<td class="isi" style="vertical-align:top; padding-left:10px;"><?=$row['ket_E']; ?></td>
  </tr>	
 <tr style="display:none">
 	<td align="center" class="isikiri">7.</td>
    <td class="isi" align="center"><?=$row['tgl_']; ?></td>
	<td align="center" class="isi"><strong class="textJdl1 style1">R</strong></td>
	<td class="isi" style="vertical-align:top; padding-left:10px;"><?=$row['ket_R']; ?></td>
  </tr>								
</table>
<br />
<br />
<p>
<div id="divctk" align="center"><button id="ctk" name="ctk" style="cursor:pointer" onclick="cetak()"><img src="../icon/printer.png" width="20" align="absmiddle" />&nbsp;Cetak</button>&nbsp;&nbsp;<button id="tutup" name="tutup" style="cursor:pointer" onclick="window.close()"><img src="../icon/delete.gif" width="20" align="absmiddle" />&nbsp;Tutup</button></div>
</p>
</body>
</html>
<script>
function cetak(){
	document.getElementById('divctk').style.display='none';
	window.print();
	window.close();
}
</script>
