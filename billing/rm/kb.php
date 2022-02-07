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
<input type="hidden" id="txtIdKB" name="txtIdKB" />
<table width="59%" align="center" cellpadding="0" cellspacing="0">
<tr>
	<td align="center">
	<fieldset>
		<legend align="left"><b>Form Input KB</b></legend>
	<table width="90%" align="center" cellpadding="3" cellspacing="0">
	<tr>
		<td width="53%">Jenis Kontrasepsi</td>
		<td width="47%">
		<select id="cmbKontrasepsi" name="cmbKontrasepsi">
		<?php 
		$trp="SELECT * FROM b_ms_kb WHERE aktif=1";
		$qtrp=mysql_query($trp);
		while($dt=mysql_fetch_array($qtrp)){
		?>
		<option value="<?php echo $dt['id'] ?>"><?php echo $dt['kb'] ?></option>
		<?php } ?>
		</select>
		</td>
	</tr>
	<tr>
		<td>Peserta</td>
		<td>
		<select id="cmbPeserta" name="cmbPeserta">
			<option value="0">Lama</option>
			<option value="1">Baru</option>
		</select>
		</td>
	</tr>
	<tr>
		<td>Akseptor Binaan</td>
		<td>
		<select id="cmbBinaan" name="cmbBinaan">
			<option value="0">Tidak</option>
			<option value="1">Ya</option>
		</select>
		</td>
	</tr>
	<tr>
		<td>Efek Samping</td>
		<td>
		<select id="cmbEfekSamping" name="cmbEfekSamping">
        	<option value="0">-</option>
		<?php 
		$napza=mysql_query("SELECT * FROM b_ms_kb_efeksamping_komplikasi WHERE tipe=1 AND aktif=1");
		while($d=mysql_fetch_array($napza)){
		?>
			<option value="<?php echo $d['id'] ?>"><?php echo $d['efeksamping_kompilkasi']; ?></option>
		<?php } ?>
		</select>
		</td>
	</tr>
	<tr>
		<td>Komplikasi</td>
		<td>
		<select id="cmbKomplikasi" name="cmbKomplikasi">
        	<option value="0">-</option>
		<?php 
		$usia=mysql_query("SELECT * FROM b_ms_kb_efeksamping_komplikasi WHERE tipe=2 AND aktif=1");
		while($r=mysql_fetch_array($usia)){
		?>
			<option value="<?php echo $r['id'] ?>"><?php echo $r['efeksamping_kompilkasi'] ?></option>
		<?php } ?>
		</select></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><label style="cursor:pointer"><input type="checkbox" id="chkKBGagal" />Peserta KB Gagal</label></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><label style="cursor:pointer" onclick="GantiKBClick(2)"><input type="checkbox" id="chkGantiKB" />Ganti Alat Kontrasepsi</label></td>
	</tr>
	<tr id="trKbLama" style="visibility:collapse">
		<td>Kontrasepsi Lama</td>
		<td>
		<select id="cmbKontrasepsiLama" name="cmbKontrasepsiLama">
		<?php 
		$akibat=mysql_query("SELECT * FROM b_ms_kb WHERE aktif=1");
		while($rows=mysql_fetch_array($akibat)){
		?>
		<option value="<?php echo $rows['id'] ?>"><?php echo $rows['kb'] ?></option>
		<?php } ?>
		</select>
		</td>
	</tr>
	<tr id="trKbBaru" style="visibility:collapse">
		<td>Kontrasepsi Baru</td>
		<td>
		<select id="cmbKontrasepsiBaru" name="cmbKontrasepsiBaru">
		<?php 
		$akibat=mysql_query("SELECT * FROM b_ms_kb WHERE aktif=1");
		while($rows=mysql_fetch_array($akibat)){
		?>
		<option value="<?php echo $rows['id'] ?>"><?php echo $rows['kb'] ?></option>
		<?php } ?>
		</select>
		</td>
	</tr>
	<tr>
		<td>Infertil</td>
		<td>
		<select id="cmbInfertil" name="cmbInfertil">
			<option value="0">-</option>
            <option value="1">Ditangani</option>
            <option value="2">Dirujuk</option>
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
