<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>TERAPI INSULIN</title>
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

<table cellspacing="0" cellpadding="0">
  <col width="65" />
  <col width="105" />
  <col width="385" />
  <col width="190" />
  <col width="105" span="2" />
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
  <tr height="28">
    <td height="28" colspan="3"><span class="judul1">PEMERINTAH    KOTA MEDAN</span></td>
    <td colspan="2" rowspan="5"><table width="100%" border="1" cellspacing="0" cellpadding="0">
      <tr>
        <td width="167" height="100" class="judul1"><div align="center">TERAPI INSULIN</div></td>
      </tr>
    </table></td>
    <td></td>
  </tr>
  <tr height="28">
    <td height="28" colspan="3" class="judul1">RUMAH    SAKIT PELINDO I</td>
    <td></td>
  </tr>
  <tr height="20">
    <td height="20"></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="20">
    <td height="20"></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="21">
    <td height="21" class="judul2">Nama Pasien</td>
    <td colspan="2" class="judul2">:&nbsp;&nbsp;&nbsp;<?php echo $pasien['nama'].' '.$pasien['sex']; ?></td>
    <td></td>
  </tr>
  <tr height="21">
    <td height="21" class="judul2">Dokter (DPJP)</td>
    <td height="21" colspan="2" class="judul2">:&nbsp;&nbsp;&nbsp;<?php echo $pasien['dokter']; ?></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="15">
    <td width="115" height="15"></td>
    <td width="23"></td>
    <td width="200"></td>
    <td width="99"></td>
    <td width="53"></td>
    <td width="61"></td>
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
        <td height="77" width="100"><div align="center">TGL</div></td>
        <td width="95"><div align="center">JAM</div></td>
        <td width="330"><div align="center">JENIS INSULIN</div></td>
        <td width="80"><div align="center">DOSIS</div></td>
        <td width="90"><div align="center">GULA DARAH</div></td>
        <td width="85"><div align="center">REDUKSI</div></td>
        <td width="230"><div align="center">KET</div></td>
        <td width="125"><div align="center">NAMA & TT</div></td>
      </tr>
      </thead>
      <tbody class="pemberian_edukasi">
		<?php
		$sql = "select * 
			from b_ms_terapi_insulin 
			where pelayanan_id = {$idPel}
			order by id asc";
		$query = mysql_query($sql);
		while($rows = mysql_fetch_assoc($query)){
			?>
			<tr height="35" class="item">
				<td height="35" align="center"><?php echo date('d-m-Y', strtotime($rows['tanggal_jam'])); ?></td>
				<td align="center"><?php echo date('H:i:s', strtotime($rows['tanggal_jam'])); ?></td>
				<td align="center"><?php echo $rows['jenis']; ?></td>
				<td align="center"><?php echo $rows['dosis']; ?></td>
				<td align="center"><?php echo $rows['gula']; ?></td>
				<td align="center"><?php echo $rows['reduksi']; ?></td>
				<td align="center"><?php echo $rows['ket']; ?></td>
				<td align="center"><?php echo $rows['nama']; ?></td>
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
  <tr id="trTombol">
  <td align="center" colspan="6"><button onclick="cetak(document.getElementById('trTombol'));" type="button">Cetak</button></td>
  </tr>
</table>
</body>
</html>
<script>
    function cetak(tombol){
        tombol.style.visibility='collapse';
        if(tombol.style.visibility=='collapse'){
            if(confirm('Anda yakin mau mencetak ?')){
                setTimeout('window.print()','1000');
                setTimeout('window.close()','2000');
            }
            else{
                tombol.style.visibility='visible';
            }

        }
    }
</script>
