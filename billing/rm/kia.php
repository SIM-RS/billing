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
		<legend align="left"><b>Form Input KIA</b></legend>
	<table width="100%" align="center" cellpadding="3" cellspacing="0">
	<tr>
		<td>Jenis Pelayanan</td>
		<td>
        <input type="hidden" name="txtId" id="txtId">
		<select id="kia_jenis" name="kia_jenis" onchange="lihatDetail(this.id,this.value);">
		<?php
		$q = "SELECT id,jenis FROM b_ms_kia";
		$qq = mysql_query($q);
		while($jns=mysql_fetch_array($qq)){
		?>
        	<option value="<?php echo $jns['id']; ?>"><?php echo $jns['jenis']; ?></option>
        <?php
		}
		?>
		</select>
		</td>
	</tr>
    <tr id="kiadetail" style="display:none">
		<td>Pelayanan Detail</td>
		<td><select id="kia_detail" name="kia_detail"></select>
		</td>
	</tr>
	</table>
	</fieldset>
	</td>
</tr>
</table>
</body>
</html>
