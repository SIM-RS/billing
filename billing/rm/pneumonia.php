<?php include("../koneksi/konek.php") ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<table width="100%" align="center" cellpadding="0" cellspacing="0">
<tr>
	<td>
		<table width="33%" align="center" cellspacing="0" cellpadding="0">
		<tr>
			<td>
				<fieldset>
				<legend><b>Pneumonia</b></legend>
				<table width="97%" align="center" cellspacing="0" cellpadding="0">
				<tr>
					<td width="49%">Faktor Resiko</td>
					<td width="51%">
					<select id="resiko" name="resiko">
					<?php 
					$res=mysql_query("SELECT id,faktor_resiko FROM b_ms_pneumonia_faktor_resiko");
					while($dt=mysql_fetch_array($res)){
					?>
					<option value="<?php echo $dt[0] ?>"><?php echo $dt[1] ?></option>
					<?php } ?>
				  </select></td>
				</tr>
				</table>
				</fieldset>
			</td>
		</tr>
	  </table>
	</td>
</tr>
<input type="hidden" id="idResiko" name="idResikp" />
</table>
</body>
</html>
