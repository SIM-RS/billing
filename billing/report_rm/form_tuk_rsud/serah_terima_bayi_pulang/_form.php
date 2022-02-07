<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Serah Terima Bayi Pulang</title>

<link href="styles.css" rel="stylesheet" type="text/css" />
<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery-1.9.1.js"></script>

<style>
	.sticker input {
		width: 100%;
	}
</style>

</head>
<body>

<form method="post">

<table cellspacing="0" cellpadding="0" class="container">
  <col width="38" />
  <col width="87" />
  <col width="80" />
  <col width="17" />
  <col width="89" />
  <col width="87" />
  <col width="72" />
  <col width="64" span="3" />
  <tr height="20">
    <td height="20" width="38">&nbsp;</td>
    <td width="87">&nbsp;</td>
    <td width="80">&nbsp;</td>
    <td width="17">&nbsp;</td>
    <td width="89">&nbsp;</td>
    <td colspan="5" rowspan="3"><p align="center" class="title">SERAH  TERIMA BAYI SAAT PULANG</p></td>
  </tr>
  <tr height="21">
    <td height="21" colspan="5" class="title">PEMERINTAH    KOTA MEDAN</td>
  </tr>
  <tr height="21">
    <td height="21" colspan="5" class="title">RUMAH SAKIT PELINDO I KOTA MEDAN</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20" colspan="5" class="sticker">
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tr>
			  <td style="width: 120px;">Nama Ibu </td>
			  <td style="width: 10px;">:</td>
			  <td><input id="nama_ibu" name="serahTerima[nama_ibu]" type="text" value="<?php echo $serahTerima['nama_ibu']; ?>" /></td>
			</tr>
			<tr>
			  <td height="12">Nama Ayah </td>
			  <td height="12">:</td>
			  <td height="12"><input id="nama_ayah" name="serahTerima[nama_ayah]" type="text" value="<?php echo $serahTerima['nama_ayah']; ?>" /></td>
			</tr>
			<tr>
			  <td>Alamat</td>
			  <td>:</td>
			  <td><input id="alamat1" name="serahTerima[alamat1]" type="text" value="<?php echo $serahTerima['alamat1']; ?>" /></td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td></td>
			  <td><input id="alamat2" name="serahTerima[alamat2]" type="text" value="<?php echo $serahTerima['alamat2']; ?>" /></td>
			</tr>
			<tr>
			  <td>Jam Kelahiran </td>
			  <td>:</td>
			  <td><input id="jam_kelahiran" name="serahTerima[jam_kelahiran]" type="text" value="<?php echo $serahTerima['jam_kelahiran']; ?>" /></td>
			</tr>
			<tr>
			  <td>Berat Badan/Panjang </td>
			  <td>:</td>
			  <td><input id="berat_badan" name="serahTerima[berat_badan]" type="text" style="width: 50px;" value="<?php echo $serahTerima['berat_badan']; ?>" /> gram  <input id="panjang" name="serahTerima[panjang]" type="text" style="width: 40px;" value="<?php echo $serahTerima['panjang']; ?>" /> cm</td>
			</tr>
		  </table>	</td>
    <td colspan="5" class="sticker">
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
		  <tr>
			<td width="100">Nama Pasien </td>
			<td width="10">:</td>
			<td width="25" style="width: 175px;"><?php echo $pasien['nama']; ?>&nbsp;&nbsp;&nbsp;&nbsp; L/P</td>
		  </tr>
		  <tr>
			<td>Tanggal Lahir </td>
			<td>:</td>
			<td><?php echo tglSQL($pasien['tgl_lahir']); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/ Usia : <?php echo $pasien['usia']; ?> Th</td>
		  </tr>
		  <tr>
			<td>No. R.M </td>
			<td>:</td>
			<td><?php echo $pasien['no_rm']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No  Registrasi : _______</td>
		  </tr>
		  <tr>
			<td>Ruang Rawat / Kelas </td>
			<td>:</td>
			<td><?php echo $pasien['nm_unit']; ?> / <?php echo $pasien['nm_kls']; ?></td>
		  </tr>
		  <tr>
			<td>Alamat</td>
			<td>:</td>
			<td><?php echo $pasien['alamat']; ?></td>
		  </tr>
		  <tr>
			<td colspan="3"><p align="center">(Tempelkan  Sticker Identitas Pasien)</p></td>
			</tr>
		</table>	</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr height="24">
    <td height="24" colspan="3">Diserahkan    Kepada :</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr height="24">
    <td height="24">&nbsp;</td>
    <td>Nama</td>
    <td></td>
    <td>:</td>
    <td colspan="6"><input id="penerima_nama" name="serahTerima[penerima_nama]" type="text" value="<?php echo $serahTerima['penerima_nama']; ?>" /></td>
  </tr>
  <tr height="24">
    <td height="24">&nbsp;</td>
    <td>Alamat</td>
    <td></td>
    <td>:</td>
    <td colspan="6"><input id="penerima_alamat1" name="serahTerima[penerima_alamat1]" type="text" value="<?php echo $serahTerima['penerima_alamat1']; ?>" /></td>
  </tr>
  <tr height="24">
    <td height="24">&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td colspan="6"><input id="penerima_alamat2" name="serahTerima[penerima_alamat2]" type="text" value="<?php echo $serahTerima['penerima_alamat2']; ?>" /></td>
  </tr>
  <tr height="24">
    <td height="24">&nbsp;</td>
    <td>Telepon</td>
    <td></td>
    <td>:</td>
    <td colspan="6"><input id="penerima_telepon" name="serahTerima[penerima_telepon]" type="text" value="<?php echo $serahTerima['penerima_telepon']; ?>" /></td>
  </tr>
  <tr height="24">
    <td height="24">&nbsp;</td>
    <td colspan="2">Kartu Identitas</td>
    <td>:</td>
    <td colspan="6"><input id="penerima_kartu_identitas" name="serahTerima[penerima_kartu_identitas]" type="text" value="<?php echo $serahTerima['penerima_kartu_identitas']; ?>" /></td>
  </tr>
  <tr height="24">
    <td height="24">&nbsp;</td>
    <td colspan="2">Hubungan Keluarga</td>
    <td>:</td>
    <td colspan="6"><input id="penerima_hubungan_keluarga" name="serahTerima[penerima_hubungan_keluarga]" type="text" value="<?php echo $serahTerima['penerima_hubungan_keluarga']; ?>" /></td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td colspan="2">Saksi (Keluarga Pasien) </td>
    <td>:</td>
    <td colspan="6"><input id="saksi" name="serahTerima[saksi]" type="text" value="<?php echo $serahTerima['saksi']; ?>" /></td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20" colspan="10" align="center">
		<?php
                    if($_REQUEST['report']!=1){
					?><button>Simpan</button><?php }?>
	</td>
  </tr>
</table>

</form>

</body>
<?php if($_REQUEST['report']==1){?>
<script> 
	jQuery('#nama_ibu').attr("disabled", "true");
	jQuery('#nama_ayah').attr("disabled", "true");
	jQuery('#alamat1').attr("disabled", "true");
	jQuery('#alamat2').attr("disabled", "true");
	jQuery('#jam_kelahiran').attr("disabled", "true");
	jQuery('#berat_badan').attr("disabled", "true");
	jQuery('#panjang').attr("disabled", "true");
	jQuery('#penerima_nama').attr("disabled", "true");
	jQuery('#penerima_alamat1').attr("disabled", "true");
	jQuery('#penerima_alamat2').attr("disabled", "true");
	jQuery('#penerima_telepon').attr("disabled", "true");
	jQuery('#penerima_kartu_identitas').attr("disabled", "true");
	jQuery('#penerima_hubungan_keluarga').attr("disabled", "true");
	jQuery('#saksi').attr("disabled", "true");
</script>
<?php }?>
</html>