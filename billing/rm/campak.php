<?php 
include("../koneksi/konek.php");
$date_now=gmdate('d-m-Y',mktime(date('H')+7));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<link rel="stylesheet" type="text/css" href="theme/popup.css"/>
<script type="text/javascript" src="theme/prototype.js"></script>
<script type="text/javascript" src="theme/effects.js"></script>
<script type="text/javascript" src="theme/popup.js"></script>
<body>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="theme/popcjs.php" scrolling="no"
	frameborder="1"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>
<table width="45%" align="center" cellpadding="0" cellspacing="0">
<tr>
	<td align="center">
	<fieldset>
		<legend align="left"><b>Form Input Campak</b></legend>
	<table width="88%" align="center" cellpadding="3" cellspacing="0">
	<tr>
		<td width="64%">Dosis</td>
		<td width="36%"><input type="text" id="dosis" name="dosis" size="17"/></td>
        <input type="hidden" id="txtId" name="txtId" size="14" value=""/>
	</tr>
	<tr>
		<td>Vaksinasi Terakhir</td>
		<td>
		<select id="vaks" name="vaks">
		<?php 
		$q=mysql_query("SELECT id,vaks_terakhir FROM b_ms_vaks_terakhir ORDER BY id");
		while($d=mysql_fetch_array($q)){
		?>
			<option value="<?php echo $d['id'] ?>"><?php echo $d['vaks_terakhir'] ?></option>
		<?php } ?>
		</select>
		</td>
	</tr>
	<tr>
		<td>Tgl Demam</td>
		<td><input size="10" value="<?php echo $date_now;?>" id="tglDemam" name="tglDemam" readonly="readonly"/>&nbsp;<input type="button" class="btninput" id="btnTglDemam" name="btnTglDemam" value=" V " onClick="gfPop.fPopCalendar(document.getElementById('tglDemam'),depRange);"/>
        </td>
	</tr>
    <tr>
		<td>Tgl Rash</td>
		<td><input size="10" value="<?php echo $date_now;?>" id="tglRash" name="tglRash" readonly="readonly"/>&nbsp;<input type="button" class="btninput" id="btnTglRash" name="btnTglRash" value=" V " onClick="gfPop.fPopCalendar(document.getElementById('tglRash'),depRange);"/></td>
	</tr>
    <tr>
		<td>Vitamin A</td>
		<td>
        <select id="vita" name="vita">
        	<option value="1">Ya</option>
            <option value="2">Tidak</option>
        </select> 
        </td>
	</tr>
    <tr>
		<td>Keadaan Sekarang</td>
		<td>
        <select id="keadaan" name="keadaan">
        	<option value="1">Hidup</option>
            <option value="2">Mati</option>
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
