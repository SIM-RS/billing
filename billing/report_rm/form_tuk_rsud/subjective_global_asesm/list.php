<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Subjective Global Asesm</title>

<link href="styles.css" rel="stylesheet" type="text/css" />

<style>

	.form-row td {
		border-right:.5pt solid windowtext;
	}
	
	.form-row td:first-child {
		border-right: none;
		border-left:.5pt solid windowtext;
	}
	
	.form-row.separator td {
		border-top:.5pt solid windowtext;
	}
	
	.form-row.last td {
		border-bottom:.5pt solid windowtext;
	}
	
	input {
		width: 60px;
	}

</style>

</head>

<body>

<table width="800" border="0" cellspacing="0" cellpadding="0" class="container">
	<col width="26">
	<col width="225">
	<col width="72">
	<col width="473">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" rowspan="4" align="right">
		<table border="0" cellspacing="0" cellpadding="0" width="450" class="sticker">
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
  <tr>
    <td height="21" colspan="2" class="title">PEMERINTAH KOTA MEDAN</td>
  </tr>
  <tr>
    <td height="21" colspan="2" class="title">RUMAH SAKIT PELINDO I</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="title">SUBJECTIVE GLOBAL ASESSMENT</td>
    <td>&nbsp;</td>
  </tr>
</table>

</body>
</html>
