<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>CATATAN PEMBERIAN EDUKSI / INFORMASI TERINTEGRASI</title>
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
    <td><?php echo $pasien['no_rm']; ?> No  Registrasi :&nbsp;<?=$pasien['no_reg'];?></td>
  </tr>
  <tr>
    <td>Ruang Rawat / Kelas </td>
    <td>:</td>
    <td><?php echo $pasien['nm_unit']; ?></td>
  </tr>
  <tr>
    <td>Alamat</td>
    <td>:</td>
    <td><?php echo $pasien['alamat']; ?></td>
  </tr>
  <tr>
    <td colspan="3"><p align="center">(Tempelkan  Sticker Identitas Pasien)</p></td>
    </tr>
</table>

</div>

<table align="center" cellpadding="0" cellspacing="0">
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
  <tr height="12">
    <td height="12"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="27">
    <td height="27" colspan="3" class="judul2">CATATAN    PEMBERIAN EDUKSI / INFORMASI TERINTEGRASI</td>
    <td></td>
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
    <td colspan="6"><table border="1" cellpadding="0" cellspacing="0">
      <col width="65" />
      <col width="105" />
      <col width="385" />
      <col width="190" />
      <col width="105" span="2" />
	  <thead>
      <tr height="35">
        <td rowspan="2" height="77" width="125"><div align="center">Tanggal    Jam</div></td>
        <td rowspan="2" width="105"><div align="center">Profesi / Bagian</div></td>
        <td rowspan="2" width="385"><div align="center">Informasi / Edukasi    yang diberikan</div></td>
        <td rowspan="2" width="100"><div align="center">Nama dan Tanda Tangan    Pemberi informasi / Edukasi</div></td>
        <td colspan="2" width="210"><div align="center">Penerima    Informasi / Edukasi</div></td>
      </tr>
      <tr height="42">
        <td height="42" width="105"><div align="center">Nama dan Tanda Tangan</div></td>
        <td width="105"><div align="center">Hubungan    dengan Pasien</div></td>
      </tr>
	  </thead>
      <tbody class="pemberian_edukasi">
		<?php
		$sql = "select * 
			from lap_pemberian_edukasi 
			where pelayanan_id = {$idPel}
			order by id asc";
		$query = mysql_query($sql);
		while($rows = mysql_fetch_assoc($query)){
			?>
			<tr height="35" class="item">
				<td height="35" align="center"><?php echo date('d-m-Y H:i:s', strtotime($rows['tanggal_jam'])); ?>
				<td align="center"><?php echo $rows['bagian']; ?></td>
				<td align="center"><?php echo $rows['informasi']; ?></td>
				<td align="center"><?php echo $rows['petugas']; ?></td>
				<td align="center"><?php echo $rows['penerima']; ?></td>
				<td align="center"><?php echo $rows['hubungan_pasien']; ?></td>
			</tr>
		  <?php
		}
		?>
	  </tbody>
    </table></td>
  </tr>
  <tr>
  <td align="center" colspan="6">&nbsp;</td>
  </tr>
  <tr>
    </tr><tr id="trTombol">
        <td class="noline" colspan="5" align="right"><div align="center">
          <input name="button" type="button" id="btnPrint" onclick="cetak(document.getElementById('trTombol'));" value="Print"/>
          <input name="button2" type="button" id="btnTutup" onclick="window.close();" value="Tutup"/>
        </div></td>
      </tr><tr><td align="center" colspan="6"><div align="center"></div></td>
  </tr>
</table>
</body>
<script type="text/JavaScript">

        function cetak(tombol){
            tombol.style.visibility='collapse';
            if(tombol.style.visibility=='collapse'){
                if(confirm('Anda Yakin Mau Mencetak ?')){
                    setTimeout('window.print()','1000');
                    setTimeout('window.close()','2000');
                }
                else{
                    tombol.style.visibility='visible';
                }

            }
        }
    </script>
<?php 
mysql_close($konek);
?>
</html>
