<?php include("../koneksi/konek.php") ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="theme/popcjs.php" scrolling="no"
	frameborder="1"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>
<table width="100%" align="center" cellpadding="0" cellspacing="0">
<tr>
	<td>
		<table width="60%" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td>
			<fieldset>
			<legend><b>Kekerasan Perempuan & Anak</b></legend>
			<table width="100%" align="center" cellpadding="3" cellspacing="0">
			<tr>
				<td width="35%">Pelaku</td>
				<td width="65%">
				<select id="pelaku" name="pelaku">
				<?php 
				$sqlPel=mysql_query("SELECT id,pelaku FROM b_ms_pelaku_kekerasan ORDER BY pelaku DESC");
				while($dt=mysql_fetch_array($sqlPel)){
				?>
					<option value="<?php echo $dt[0] ?>"><?php echo $dt[1] ?></option>
				<?php } ?>
				</select></td>
			</tr>
			<tr>
				<td>Waktu</td>
				<td>Tanggal&nbsp;<input type="text" id="tgl" name="tgl" size="10" onClick="gfPop.fPopCalendar(document.getElementById('tgl'),depRange);" />&nbsp;Jam&nbsp;<input type="text" id="jam" name="jam" size="5" maxlength="5" />
				  &nbsp;<font color="#FF0000" size="-2"><i>HH:MM</i></font>&nbsp;</td>
			</tr>
			<tr>
				<td>Tempat Kejadian</td>
				<td><input type="text" id="tmpt" name="tmpt" size="41" /></td>
			</tr>
			<tr>
				<td>Kekerasan Yang Dialamai</td>
				<td><textarea id="kekerasan" name="kekerasan" rows="2" cols="31"></textarea></td>
			</tr>
			<tr>
				<td>Korban Kekerasan</td>
				<td>
				<select id="tipe" name="tipe">
					<option value="1">Perempuan</option>
					<option value="2">Anak</option>
				</select>
				</td>
			</tr>
			</table>
			</fieldset>
			</td>
		</tr>
	 	</table>
	</td>
</tr>
<input type="hidden" id="idKekerasan" name="idKekerasan" />
</table>
</body>
</html>
