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
		<legend align="left"><b>Form Input Maternal / Perinatal</b></legend>
	<table width="88%" align="center" cellpadding="3" cellspacing="0">
	<tr>
		<td>Jenis Kesakitan</td>
		<td>
        <input type="hidden" name="txtId" id="txtId">
		<select id="kesakitan" name="kesakitan" onchange="CmbChange2(this.id,this.value);">
			<option value="1">Maternal</option>
            <option value="2">Perinatal</option>
		</select>
		</td>
	</tr>
    <tr>
		<td>Jenis Kasus</td>
		<td>
		<select id="jeniskasus" name="jeniskasus">
        <?php 
		$sql="SELECT id,kasus as nama FROM b_ms_maternal_perinatal WHERE tipe=1";
		$rs=mysql_query($sql);
		while ($rw=mysql_fetch_array($rs)){
		?>
        	<option value="<?php echo $rw['id']; ?>"><?php echo $rw['nama']; ?></option>
		<?php
		}
		?>
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
