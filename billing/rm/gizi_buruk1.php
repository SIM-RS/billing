<?php 
include("../koneksi/konek.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body>
<table width="45%" align="center" cellpadding="0" cellspacing="0">
<tr>
	<td align="center">
	<fieldset>
		<legend align="left"><b>Form Input Gizi Buruk</b></legend>
	<table width="88%" align="center" cellpadding="3" cellspacing="0">
	<tr>
		<td width="64%">Berat Badan</td>
		<td width="36%"><input type="text" id="bb" name="bb" size="14"/></td>
        <input type="hidden" id="txtId" name="txtId" size="14" value=""/>
	</tr>
	<tr>
		<td>Tinggi Badan</td>
		<td width="36%"><input type="text" id="tb" name="tb" size="14"/>
	</tr>
	<tr>
		<td>Status Gizi</td>
		<td>
		<select id="statusGizi" name="statusGizi">
		<?php 
		$q=mysql_query("SELECT id,status_gizi FROM b_ms_status_gizi ORDER BY id");
		while($d=mysql_fetch_array($q)){
		?>
			<option value="<?php echo $d['id'] ?>"><?php echo $d['status_gizi'] ?></option>
		<?php } ?>
		</select>
		</td>
	</tr>
	<tr>
		<td>Tidakan</td>
		<td><textarea id="tindakan" name="tindakan"></textarea></td>
	</tr>
    <tr>
		<td>Hasil Tindakan</td>
		<td>
		<select id="hasilTindakan" name="hasilTindakan">
		<?php 
		$q=mysql_query("SELECT id,hasil FROM b_ms_hasil_tindakan ORDER BY id");
		while($d=mysql_fetch_array($q)){
		?>
			<option value="<?php echo $d['id'] ?>"><?php echo $d['hasil'] ?></option>
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
