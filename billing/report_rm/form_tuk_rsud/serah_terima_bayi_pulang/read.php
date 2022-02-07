<?php

require_once '_functions.php';

$serahTerima = getSerahTerima($idPel);
if($serahTerima === FALSE) {
	header('Location: '.$BASE_URL.'&act=create');
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Serah Terima Bayi Pulang</title>

<link href="styles.css" rel="stylesheet" type="text/css" />

<style>
	input {
		border: none;
	}
</style>

<style media="print">
	body {
		padding: 10px;
	}
	
	#buttons { display:none; }
</style>

</head>
<body>

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
		<table border="0" cellspacing="0" cellpadding="0">
			<tr>
			  <td style="width: 120px;">Nama Ibu </td>
			  <td style="width: 10px;">:</td>
			  <td><input type="text" value="<?php echo $serahTerima['nama_ibu']; ?>" /></td>
			</tr>
			<tr>
			  <td height="12">Nama Ayah </td>
			  <td height="12">:</td>
			  <td height="12"><input type="text" value="<?php echo $serahTerima['nama_ayah']; ?>" /></td>
			</tr>
			<tr>
			  <td>Alamat</td>
			  <td>:</td>
			  <td><input type="text" value="<?php echo $serahTerima['alamat1']; ?>" /></td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td></td>
			  <td><input type="text" value="<?php echo $serahTerima['alamat2']; ?>" /></td>
			</tr>
			<tr>
			  <td>Jam Kelahiran </td>
			  <td>:</td>
			  <td><input type="text" value="<?php echo $serahTerima['jam_kelahiran']; ?>" /></td>
			</tr>
			<tr>
			  <td>Berat Badan/Panjang </td>
			  <td>:</td>
			  <td><input type="text" style="width: 50px;" value="<?php echo $serahTerima['berat_badan']; ?>" /> gram  <input type="text" style="width: 40px;" value="<?php echo $serahTerima['panjang']; ?>" /> cm</td>
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
    <td colspan="6"><input type="text" value="<?php echo $serahTerima['penerima_nama']; ?>" /></td>
  </tr>
  <tr height="24">
    <td height="24">&nbsp;</td>
    <td>Alamat</td>
    <td></td>
    <td>:</td>
    <td colspan="6"><input type="text" value="<?php echo $serahTerima['penerima_alamat1']; ?>" /></td>
  </tr>
  <tr height="24">
    <td height="24">&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td colspan="6"><input type="text" value="<?php echo $serahTerima['penerima_alamat2']; ?>" /></td>
  </tr>
  <tr height="24">
    <td height="24">&nbsp;</td>
    <td>Telepon</td>
    <td></td>
    <td>:</td>
    <td colspan="6"><input type="text" value="<?php echo $serahTerima['penerima_telepon']; ?>" /></td>
  </tr>
  <tr height="24">
    <td height="24">&nbsp;</td>
    <td colspan="2">Kartu Identitas</td>
    <td>:</td>
    <td colspan="6"><input type="text" value="<?php echo $serahTerima['penerima_kartu_identitas']; ?>" /></td>
  </tr>
  <tr height="24">
    <td height="24">&nbsp;</td>
    <td colspan="2">Hubungan Keluarga</td>
    <td>:</td>
    <td colspan="6"><input type="text" value="<?php echo $serahTerima['penerima_hubungan_keluarga']; ?>" /></td>
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
    <td height="20">&nbsp;</td>
    <td colspan="2"><div align="center">Bidan / Perawat</div></td>
    <td></td>
    <td colspan="2"><div align="center">Saksi (Keluarga Pasien)</div></td>
    <td></td>
    <td colspan="2"><div align="center">Orang tua Bayi</div></td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td colspan="2"><div align="center">yang menyerahkan,</div></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td colspan="2"><div align="center">Yang Menerima,</div></td>
    <td>&nbsp;</td>
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
    <td height="20">&nbsp;</td>
    <td colspan="2"><div align="center">(<?php echo $activeUser['nama']; ?>)</div></td>
    <td></td>
    <td colspan="2"><div align="center">( <?php echo $serahTerima['saksi']; ?> )</div></td>
    <td></td>
    <td colspan="2"><div align="center">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</div></td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<div style="text-align:center" id="buttons">
	<a href="<?php echo $BASE_URL.'&act=edit'; ?>">Ubah</a>
	<a href="#" onclick="window.print()">Print</a>
</div>

</body>
</html>
