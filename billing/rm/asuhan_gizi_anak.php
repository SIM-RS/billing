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
		<legend align="left"><b>Asuhan Gizi Anak</b></legend>
	<table width="88%" align="center" cellpadding="3" cellspacing="0">
	<tr>
		<td width="44%">Berat Badan</td>
		<td width="56%"><input type="text" id="txtbb" name="txtbb" size="14"/>&nbsp;Kg</td>
        <input type="hidden" id="txtId_asuhan_gizi_anak" name="txtId_asuhan_gizi_anak" value=""/>
	</tr>
	<tr>
		<td>Tinggi Badan</td>
		<td width="56%"><input type="text" id="txttb" name="txttb" size="14"/>&nbsp;Cm</td>
	</tr>
	<tr>
		<td>BB / TB</td>
		<td width="56%"><input type="text" id="txtbbtb" name="txtbbtb" size="14"/>&nbsp;(Z-Zcore)</td>
	</tr>
	<tr>
		<td>Asupan Makanan Sebelum MRS</td>
		<td><textarea id="txtAsupanMakan" name="txtAsupanMakan"></textarea></td>
	</tr>
    <tr>
		<td>Kesan</td>
		<td>
		<select id="txtKesan" name="txtKesan">
			<option value="Tidak Beresiko Malnutrisi">Tidak Beresiko Malnutrisi</option>
            <option value="Beresiko Malnutrisi">Beresiko Malnutrisi</option>
            <option value="Malnutrisi">Malnutrisi</option>
		</select>
		</td>
	</tr>
    <tr>
		<td>Perlu/Tidak Asuhan Gizi Lanjut</td>
		<td><textarea id="txtAsuhanGiziLanjut" name="txtAsuhanGiziLanjut"></textarea></td>
	</tr>
    <tr>
		<td>Diagnosa Penyakit</td>
		<td><textarea id="txtDiagPeny" name="txtDiagPeny"></textarea></td>
	</tr>
    <tr>
		<td>Diit Dokter</td>
		<td><textarea id="txtDiitDokter" name="txtDiitDokter"></textarea></td>
	</tr>
	</table>
	</fieldset>
	</td>
</tr>
</table>
</body>
</html>
