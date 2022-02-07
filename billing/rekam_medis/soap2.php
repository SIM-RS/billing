<?php 
include("../koneksi/konek.php");
$IdPel=$_REQUEST['idPel'];
$sql="SELECT
  c.id,
  c.no_rm,
  c.nama,
  b.umur_thn,
  b.umur_bln,
  c.sex
FROM $dbbilling.b_pelayanan a
  INNER JOIN $dbbilling.b_kunjungan b
    ON a.kunjungan_id = b.id
  INNER JOIN $dbbilling.b_ms_pasien c
    ON b.pasien_id = c.id WHERE a.id='".$IdPel."' GROUP BY c.id";
	$q=mysql_query($sql);
	$r=mysql_fetch_array($q);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>S O A P I E R</title>
<link rel="stylesheet" href="style.css" type="text/css" />
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
$sTgl="SELECT DISTINCT DATE_FORMAT(tgl,'%Y-%m-%d') AS tgl FROM ask_soap WHERE pelayanan_id='".$_REQUEST['idPel']."' ORDER BY tgl DESC";
$qTgl=mysql_query($sTgl);
$rwTgl=mysql_fetch_array($qTgl);

$sql = "SELECT DISTINCT tgl FROM ask_soap WHERE pelayanan_id='".$_REQUEST['idPel']."' AND DATE(tgl)='".tglSQL($_REQUEST['tanggal'])."' ORDER BY tgl";
$qsql = mysql_query($sql);
while($rw=mysql_fetch_array($qsql)){
	$fTgl = " AND tgl='".$rw['tgl']."'";
?>
<table width="1000" align="center" cellpadding="0" cellspacing="0">
<tr>
	<td colspan="3" class="txt2Bold">Tanggal & Jam : <span class="txtKecil"> <?=$rw['tgl']; ?></span></td>
</tr>
<tr>
	<td width="147" align="center" class="isikiri" style="border-top:1px solid;"><strong class="textJdl1 style1">S</strong></td>
	<td width="429" class="isi" style="border-top:1px solid; vertical-align:top">
	<?php
	$i=1;
	$S="SELECT keterangan,user_id,jenis FROM ask_soap WHERE pelayanan_id='".$IdPel."' AND tipe=1 AND jenis='1' $fTgl";
	$qs=mysql_query($S);
	if(mysql_num_rows($qs)>0){
		echo "<b>Dokter</b><br>";
	}
	while($rS=mysql_fetch_array($qs)){
		echo $i.".&nbsp;".$rS[0]."<br />";
		$i++;
		if($rS['jenis']==1){
			$dok="SELECT nama FROM $dbbilling.b_ms_pegawai WHERE id='$rS[user_id]'";
			$q=mysql_query($dok);
			$dokter=mysql_fetch_array($q);
			echo "<font color='#666666'>( ".$dokter['nama']." )</font><br /><br />";
		}
	}
	?>
	</td>
    <td width="422" class="isi" style="border-top:1px solid; vertical-align:top">
    <?php
	$i=1;
	$S="SELECT keterangan,user_id,jenis,user_act FROM ask_soap WHERE pelayanan_id='".$IdPel."' AND tipe=1 AND jenis='0' $fTgl";
	$qs=mysql_query($S);
	if(mysql_num_rows($qs)>0){
		echo "<b>Perawat</b><br>";
	}
	while($rS=mysql_fetch_array($qs)){
	echo $i.".&nbsp;".$rS[0]."<br />";
	$i++;
	if($rS['jenis']==0){
		$dok="SELECT nama FROM $dbbilling.b_ms_pegawai WHERE id='$rS[user_id]'";
		$q=mysql_query($dok);
		$dokter=mysql_fetch_array($q);
		echo "<font color='#666666'>( ".$dokter['nama']." )</font><br /><br />";
	}
	}
	?>
    </td>
  </tr>	
<tr>
	<td align="center" class="isikiri"><strong class="textJdl1 style1">O</strong></td>
	<td class="isi" style="vertical-align:top">
	<?php
	$i=1;
	$S="SELECT keterangan,user_id,jenis FROM ask_soap WHERE pelayanan_id='".$IdPel."' AND tipe=2 AND jenis='1' $fTgl";
	$qs=mysql_query($S);
	if(mysql_num_rows($qs)>0){
		echo "<b>Dokter</b><br>";
	}
	while($rS=mysql_fetch_array($qs)){
	echo $i.".&nbsp;".$rS[0]."<br />";
	$i++;
	if($rS['jenis']==1){
		$dok="SELECT nama FROM $dbbilling.b_ms_pegawai WHERE id='$rS[user_id]'";
		$q=mysql_query($dok);
		$dokter=mysql_fetch_array($q);
		echo "<font color='#666666'>( ".$dokter['nama']." )</font><br /><br />";
	}
	}
	?></td>
    <td width="422" class="isi" style="border-top:0px solid; vertical-align:top">
    <?php
	$i=1;
	$S="SELECT keterangan,user_id,jenis,user_act FROM ask_soap WHERE pelayanan_id='".$IdPel."' AND tipe=2 AND jenis='0' $fTgl";
	$qs=mysql_query($S);
	if(mysql_num_rows($qs)>0){
		echo "<b>Perawat</b><br>";
	}
	while($rS=mysql_fetch_array($qs)){
	echo $i.".&nbsp;".$rS[0]."<br />";
	$i++;
	if($rS['jenis']==0){
		$dok="SELECT nama FROM $dbbilling.b_ms_pegawai WHERE id='$rS[user_id]'";
		$q=mysql_query($dok);
		$dokter=mysql_fetch_array($q);
		echo "<font color='#666666'>( ".$dokter['nama']." )</font><br /><br />";
	}
	}
	?>
    </td>
  </tr>	
<tr>
	<td align="center" class="isikiri"><strong class="textJdl1 style1">A</strong></td>
	<td class="isi" style="vertical-align:top">
	<?php
	$i=1;
	$S="SELECT keterangan,user_id,jenis FROM ask_soap WHERE pelayanan_id='".$IdPel."' AND tipe=3 AND jenis='1' $fTgl";
	$qs=mysql_query($S);
	if(mysql_num_rows($qs)>0){
		echo "<b>Dokter</b><br>";
	}
	while($rS=mysql_fetch_array($qs)){
	echo $i.".&nbsp;".$rS[0]."<br />";
	$i++;
	if($rS['jenis']==1){
		$dok="SELECT nama FROM $dbbilling.b_ms_pegawai WHERE id='$rS[user_id]'";
		$q=mysql_query($dok);
		$dokter=mysql_fetch_array($q);
		echo "<font color='#666666'>( ".$dokter['nama']." )</font><br /><br />";
	}
	}
	?></td>
	<td width="422" class="isi" style="border-top:0px solid; vertical-align:top">
    <?php
	$i=1;
	$S="SELECT keterangan,user_id,jenis,user_act FROM ask_soap WHERE pelayanan_id='".$IdPel."' AND tipe=3 AND jenis='0' $fTgl";
	$qs=mysql_query($S);
	if(mysql_num_rows($qs)>0){
		echo "<b>Perawat</b><br>";
	}
	while($rS=mysql_fetch_array($qs)){
	echo $i.".&nbsp;".$rS[0]."<br />";
	$i++;
	if($rS['jenis']==0){
		$dok="SELECT nama FROM $dbbilling.b_ms_pegawai WHERE id='$rS[user_id]'";
		$q=mysql_query($dok);
		$dokter=mysql_fetch_array($q);
		echo "<font color='#666666'>( ".$dokter['nama']." )</font><br /><br />";
	}
	}
	?>
    </td>
  </tr>	
<tr>
	<td align="center" class="isikiri"><strong class="textJdl1 style1">P</strong></td>
	<td class="isi" style="vertical-align:top">
	<?php
	$i=1;
	$S="SELECT keterangan,user_id,jenis FROM ask_soap WHERE pelayanan_id='".$IdPel."' AND tipe=4 AND jenis='1' $fTgl";
	$qs=mysql_query($S);
	if(mysql_num_rows($qs)>0){
		echo "<b>Dokter</b><br>";
	}
	while($rS=mysql_fetch_array($qs)){
	echo $i.".&nbsp;".$rS[0]."<br />";
	$i++;
	if($rS['jenis']==1){
		$dok="SELECT nama FROM $dbbilling.b_ms_pegawai WHERE id='$rS[user_id]'";
		$q=mysql_query($dok);
		$dokter=mysql_fetch_array($q);
		echo "<font color='#666666'>( ".$dokter['nama']." )</font><br /><br />";
	}
	}
	?></td>
    <td width="422" class="isi" style="border-top:0px solid; vertical-align:top">
    <?php
	$i=1;
	$S="SELECT keterangan,user_id,jenis,user_act FROM ask_soap WHERE pelayanan_id='".$IdPel."' AND tipe=4 AND jenis='0' $fTgl";
	$qs=mysql_query($S);
	if(mysql_num_rows($qs)>0){
		echo "<b>Perawat</b><br>";
	}
	while($rS=mysql_fetch_array($qs)){
	echo $i.".&nbsp;".$rS[0]."<br />";
	$i++;
	if($rS['jenis']==0){
		$dok="SELECT nama FROM $dbbilling.b_ms_pegawai WHERE id='$rS[user_id]'";
		$q=mysql_query($dok);
		$dokter=mysql_fetch_array($q);
		echo "<font color='#666666'>( ".$dokter['nama']." )</font><br /><br />";
	}
	}
	?>
    </td>
  </tr>
<tr>
	<td align="center" class="isikiri"><strong class="textJdl1 style1">I</strong></td>
	<td class="isi" style="vertical-align:top">
	<?php
	$i=1;
	$S="SELECT keterangan,user_id,jenis FROM ask_soap WHERE pelayanan_id='".$IdPel."' AND tipe=5 AND jenis='1' $fTgl";
	$qs=mysql_query($S);
	if(mysql_num_rows($qs)>0){
		echo "<b>Dokter</b><br>";
	}
	while($rS=mysql_fetch_array($qs)){
	echo $i.".&nbsp;".$rS[0]."<br />";
	$i++;
	if($rS['jenis']==1){
		$dok="SELECT nama FROM $dbbilling.b_ms_pegawai WHERE id='$rS[user_id]'";
		$q=mysql_query($dok);
		$dokter=mysql_fetch_array($q);
		echo "<font color='#666666'>( ".$dokter['nama']." )</font><br /><br />";
	}
	}
	?></td>
    <td width="422" class="isi" style="border-top:0px solid; vertical-align:top">
    <?php
	$i=1;
	$S="SELECT keterangan,user_id,jenis,user_act FROM ask_soap WHERE pelayanan_id='".$IdPel."' AND tipe=5 AND jenis='0' $fTgl";
	$qs=mysql_query($S);
	if(mysql_num_rows($qs)>0){
		echo "<b>Perawat</b><br>";
	}
	while($rS=mysql_fetch_array($qs)){
	echo $i.".&nbsp;".$rS[0]."<br />";
	$i++;
	if($rS['jenis']==0){
		$dok="SELECT nama FROM $dbbilling.b_ms_pegawai WHERE id='$rS[user_id]'";
		$q=mysql_query($dok);
		$dokter=mysql_fetch_array($q);
		echo "<font color='#666666'>( ".$dokter['nama']." )</font><br /><br />";
	}
	}
	?>
    </td>
  </tr>
<tr>
	<td align="center" class="isikiri"><strong class="textJdl1 style1">E</strong></td>
	<td class="isi" style="vertical-align:top">
	<?php
	$i=1;
	$S="SELECT keterangan,user_id,jenis FROM ask_soap WHERE pelayanan_id='".$IdPel."' AND tipe=6 AND jenis='1' $fTgl";
	$qs=mysql_query($S);
	if(mysql_num_rows($qs)>0){
		echo "<b>Dokter</b><br>";
	}
	while($rS=mysql_fetch_array($qs)){
	echo $i.".&nbsp;".$rS[0]."<br />";
	$i++;
	if($rS['jenis']==1){
		$dok="SELECT nama FROM $dbbilling.b_ms_pegawai WHERE id='$rS[user_id]'";
		$q=mysql_query($dok);
		$dokter=mysql_fetch_array($q);
		echo "<font color='#666666'>( ".$dokter['nama']." )</font><br /><br />";
	}
	}
	?></td>
    <td width="422" class="isi" style="border-top:0px solid; vertical-align:top">
    <?php
	$i=1;
	$S="SELECT keterangan,user_id,jenis,user_act FROM ask_soap WHERE pelayanan_id='".$IdPel."' AND tipe=6 AND jenis='0' $fTgl";
	$qs=mysql_query($S);
	if(mysql_num_rows($qs)>0){
		echo "<b>Perawat</b><br>";
	}
	while($rS=mysql_fetch_array($qs)){
	echo $i.".&nbsp;".$rS[0]."<br />";
	$i++;
	if($rS['jenis']==0){
		$dok="SELECT nama FROM $dbbilling.b_ms_pegawai WHERE id='$rS[user_id]'";
		$q=mysql_query($dok);
		$dokter=mysql_fetch_array($q);
		echo "<font color='#666666'>( ".$dokter['nama']." )</font><br /><br />";
	}
	}
	?>
    </td>
  </tr>
<tr>
	<td align="center" class="isikiri"><strong class="textJdl1 style1">R</strong></td>
	<td class="isi" style="vertical-align:top">
	<?php
	$i=1;
	$S="SELECT keterangan,user_id,jenis FROM ask_soap WHERE pelayanan_id='".$IdPel."' AND tipe=7 AND jenis='1' $fTgl";
	$qs=mysql_query($S);
	if(mysql_num_rows($qs)>0){
		echo "<b>Dokter</b><br>";
	}
	while($rS=mysql_fetch_array($qs)){
	echo $i.".&nbsp;".$rS[0]."<br />";
	$i++;
	if($rS['jenis']==1){
		$dok="SELECT nama FROM $dbbilling.b_ms_pegawai WHERE id='$rS[user_id]'";
		$q=mysql_query($dok);
		$dokter=mysql_fetch_array($q);
		echo "<font color='#666666'>( ".$dokter['nama']." )</font><br /><br />";
	}
	}
	?></td>
    <td width="422" class="isi" style="border-top:0px solid; vertical-align:top">
    <?php
	$i=1;
	$S="SELECT keterangan,user_id,jenis,user_act FROM ask_soap WHERE pelayanan_id='".$IdPel."' AND tipe=7 AND jenis='0' $fTgl";
	$qs=mysql_query($S);
	if(mysql_num_rows($qs)>0){
		echo "<b>Perawat</b><br>";
	}
	while($rS=mysql_fetch_array($qs)){
	echo $i.".&nbsp;".$rS[0]."<br />";
	$i++;
	if($rS['jenis']==0){
		$dok="SELECT nama FROM $dbbilling.b_ms_pegawai WHERE id='$rS[user_id]'";
		$q=mysql_query($dok);
		$dokter=mysql_fetch_array($q);
		echo "<font color='#666666'>( ".$dokter['nama']." )</font><br /><br />";
	}
	}
	?>
    </td>
  </tr>								
</table>
<br />
<br />
<?php
}
?>
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
