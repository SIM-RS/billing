<?php 
include("../koneksi/konek.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script type="text/javascript" src="../theme/js/ajax.js"></script>
</head>
<body>
<input type="hidden" id="idMaster" name="idMaster" />
<table width="59%" align="center" cellpadding="0" cellspacing="0">
<tr>
	<td align="center">
	<fieldset>
		<legend align="left"><b>Form Input Napza</b></legend>
	<table width="90%" align="center" cellpadding="3" cellspacing="0">
	<tr>
		<td width="53%">Modalitas Terapi</td>
		<td width="47%">
		<select id="trapi" name="trapi">
		<?php 
		$trp="SELECT id,terapi FROM b_ms_napza_terapi ORDER BY terapi";
		$qtrp=mysql_query($trp);
		while($dt=mysql_fetch_array($qtrp)){
		?>
		<option value="<?php echo $dt[0] ?>"><?php echo $dt[1] ?></option>
		<?php } ?>
		</select>
		</td>
	</tr>
	<tr>
		<td>Status Perkawinan</td>
		<td>
		<select id="sttKwn" name="sttKwn">
			<option value="1">Kawin</option>
			<option value="2">Belum Kawin</option>
			<option value="3">Duda</option>
			<option value="4">Janda</option>
		</select>
		</td>
	</tr>
	<tr>
		<td>Napza Yang Digunakan</td>
		<td>
		<select id="napzaDigunakan" name="napzaDigunakan">
		<?php 
		$napza=mysql_query("SELECT id,napza FROM b_ms_napza ORDER BY napza");
		while($d=mysql_fetch_array($napza)){
		?>
			<option value="<?php echo $d[0] ?>"><?php echo $d[1] ?></option>
		<?php } ?>
		</select>
		</td>
	</tr>
	<tr>
		<td>Usia Pertama Kali Pakai Napza</td>
		<td>
		<select id="usia" name="usia">
		<?php 
		$usia=mysql_query("SELECT id,usia_pakai FROM b_ms_napza_usia_pakai ORDER BY usia_pakai");
		while($r=mysql_fetch_array($usia)){
		?>
			<option value="<?php echo $r[0] ?>"><?php echo $r[1] ?></option>
		<?php } ?>
		</select></td>
	</tr>
	<tr>
		<td>Diagnosa</td>
		<td>
		<select id="akibat" name="akibat">
		<?php 
		$akibat=mysql_query("SELECT id,akibat FROM b_ms_napza_akibat ORDER BY akibat");
		while($rows=mysql_fetch_array($akibat)){
		?>
		<option value="<?php echo $rows[0] ?>"><?php echo $rows[1] ?></option>
		<?php } ?>
		</select>
		</td>
	</tr>
	</table>
	</fieldset>
	</td>
</tr>
</table>
</body>
</html>
