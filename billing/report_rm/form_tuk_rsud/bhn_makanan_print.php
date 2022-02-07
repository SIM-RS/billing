<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PERMINTAAN BAHAN MAKANAN KERING</title>
<style type="text/css">
<!--
body {
	font-family: Tahoma;
	font-size: 12px;
}
.judul1 {
	font-size: 17px;
	font-weight: bold;
}
.judul2 {
	font-size: 15px;
	font-weight: bold;
}

.sticker {
	line-height:20px;
	padding: 8px;
	border: 1px solid;
	font-size:9px;
	position:absolute;
	left: 608px;
	top: 17px;
}
-->
</style>
</head>

<body>
<?php include('serah_terima_bayi_pulang_utils.php'); ?>

<div class="sticker">
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="167">Nama Pasien </td>
    <td width="10">:</td>
    <td width="25" style="width: 175px;"><?php echo $pasien['nama'].' '.$pasien['sex']; ?></td>
  </tr>
  <tr>
    <td>Tanggal Lahir </td>
    <td>:</td>
    <td><?php echo date('d-m-Y',strtotime($pasien['tgl_lahir'])); ?>  /Usia : <?php echo $pasien['usia']; ?> Th</td>
  </tr>
  <tr>
    <td>No. R.M </td>
    <td>:</td>
    <td><?php echo $pasien['no_rm']; ?> No  Registrasi : <?php echo $pasien['no_reg2']; ?></td>
  </tr>
  <tr>
    <td>Ruang Rawat / Kelas </td>
    <td>:</td>
    <td><?php echo $pasien['nm_unit']; ?></td>
  </tr>
  <tr>
    <td>Alamat</td>
    <td>:</td>
    <td><?php echo $pasien['alamat_']; ?></td>
  </tr>
  <tr>
    <td colspan="3"><p align="center">(Tempelkan  Sticker Identitas Pasien)</p></td>
    </tr>
</table>

</div>

<table cellspacing="0" cellpadding="0">
  <col width="65" />
  <col width="105" />
  <col width="385" />
  <col width="190" />
  <col width="105" span="2" />
  <tr height="20">
    <td height="20" width="105"></td>
    <td width="105"></td>
    <td width="385"></td>
    <td width="190"></td>
    <td width="105"></td>
    <td width="105"></td>
  </tr>
  <tr height="20">
    <td height="20"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="28">
    <td height="28" colspan="3"><span class="judul1">PEMERINTAH    KOTA MEDAN</span></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="28">
    <td height="28" colspan="3" class="judul1">RUMAH    SAKIT PELINDO I</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="20">
    <td height="20"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="20">
    <td height="20"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="27">
    <td height="27" colspan="4"><span class="judul2">FORM PERMINTAAN BAHAN MAKANAN KERING</span></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="27">
    <td height="27" colspan="4" class="judul2">INSTALANSI GIZI RS PELINDO I</td>
    <td></td>
    <td></td>
  </tr>
  <tr height="15">
    <td height="15"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="35">
    <td colspan="6"><table border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
      <col width="65" />
      <col width="105" />
      <col width="385" />
      <col width="190" />
      <col width="105" span="2" />
	  <thead>
      <tr height="35">
        <td rowspan="2" height="77" width="37"><div align="center">NO</div></td>
        <td rowspan="2" width="309"><div align="center">BAHAN MAKANAN</div></td>
        <td rowspan="2" width="166"><div align="center">UKURAN</div></td>
        <td rowspan="2" width="168"><div align="center">SATUAN</div></td>
        <td colspan="2"><div align="center">KESESUAIAN SPESIFIKASI</div></td>
      </tr>
      <tr height="42">
        <td height="42" width="122"><div align="center">ya</div></td>
        <td width="123"><div align="center">tidak</div></td>
      </tr>
	  </thead>
      <tbody class="pemberian_edukasi">
		<?php
		$sql = "select * 
			from b_ms_bhn_makan 
			where pelayanan_id = {$idPel}
			order by id asc";
		$query = mysql_query($sql);
		$z=1;
		while($rows = mysql_fetch_assoc($query)){
			?>
			<tr height="35" class="item">
				<td height="35" align="center"><?php echo $z; ?>
				<td align="center"><?php echo $rows['bahan']; ?></td>
				<td align="center"><?php echo $rows['ukuran']; ?></td>
				<td align="center"><?php echo $rows['satuan']; ?></td>
				<td align="center"><?php echo $rows['ya']; ?></td>
				<td align="center"><?php echo $rows['tidak']; ?></td>
			</tr>
		  <?php
		$z++;}
		?>
	  </tbody>
    </table></td>
  </tr>
  <tr>
  <td align="center" colspan="6">&nbsp;</td>
  </tr>
  <tr>
  <td align="center" colspan="6"><button onclick="window.print()" type="button">Cetak</button></td>
  </tr>
</table>
</body>
</html>
