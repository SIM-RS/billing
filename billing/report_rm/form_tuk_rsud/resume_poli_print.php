<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>RESUME POLIKLINIK</title>
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
.border {
	border:1px solid black;
}
.border-kaki {
	border-right:1px solid black;
	border-left:1px solid black;
}
.border-ab {
	border-top:1px solid black;
	border-bottom:1px solid black;
}
.border-abka {
	border-top:1px solid black;
	border-bottom:1px solid black;
	border-right:1px solid black;
}
.border-abki {
	border-top:1px solid black;
	border-bottom:1px solid black;
	border-left:1px solid black;
}
.border-bkaki {
	border-right:1px solid black;
	border-bottom:1px solid black;
	border-left:1px solid black;
}
.border-bki {
	border-bottom:1px solid black;
	border-left:1px solid black;
}
.border-bka {
	border-bottom:1px solid black;
	border-right:1px solid black;
}
.border-b {
	border-bottom:1px solid black;
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
    <td><?php echo $pasien['no_rm']; ?> No  Registrasi : <?php echo $pasien['no_reg']; ?></td>
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
    <td width="125"></td>
    <td width="125"></td>
    <td width="135"></td>
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
    <td height="28" colspan="3" class="judul1">RUMAH SAKIT PELINDO I KOTA MEDAN</td>
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
    <td height="27" colspan="3" class="judul2">RESUME POLIKLINIK</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="27">
    <td height="27" colspan="5">&nbsp;</td>
    <td>NRM</td>
  </tr>
  <tr>
    <td colspan="2" class="border"><p>&nbsp;&nbsp;Nama Lengkap Pasien</p><p>&nbsp;&nbsp;<?=$pasien['nama'];?></p></td>
    <td class="border-ab"><p>&nbsp;&nbsp;Nama Tambahan</p><p>&nbsp;&nbsp;<?php ?></p></td>
    <td class="border"><p>&nbsp;&nbsp;Tgl Lahir</p><p>&nbsp;&nbsp;<?=$pasien['tgl_lhr']?></p></td>
    <td class="border-ab">&nbsp;&nbsp;Jenis Kelamin : <span <?php if($pasien['sex']=='L'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>L</span> / <span <?php if($pasien['sex']=='P'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>P</span></td>
    <td><table width="100%" height="70" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <tr>
        <td height="50"><?=substr($pasien['no_rm'],0,2);?></td>
        <td><?=substr($pasien['no_rm'],2,2);?></td>
        <td><?=substr($pasien['no_rm'],4,3);?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="4" class="border-bkaki">&nbsp;&nbsp;Alamat Lengkap&nbsp;:&nbsp;<?=$pasien['alamat']?> Kota : <?=$pasien['nm_kab']?> Kelurahan : <?=$pasien['nm_desa']?> Kecamatan : <?=$pasien['nm_kec']?> Rt : <?=$pasien['rt']?> Rw : <?=$pasien['rw']?></td>
	<td class="border-bka" colspan="2"><p>&nbsp;&nbsp;No. Telp</p><p>&nbsp;&nbsp;<?=$pasien['telp']?></p></td>
  </tr>
  <tr>
    <td class="border-bki"><p>&nbsp;&nbsp;Tempat Lahir</p><p>&nbsp;&nbsp;<?php ?></p></td>
    <td class="border-bki"><p>&nbsp;&nbsp;Agama</p><p>&nbsp;&nbsp;<?=$pasien['agamanya']?></p></td>
    <td colspan="4"><table width="100%" height="70" border="1" bordercolor="#000000" cellpadding="0" cellspacing="0">
      <tr>
        <td height="50"><p>&nbsp;&nbsp;Suku</p><p>&nbsp;&nbsp;<?php ?></p></td>
        <td><p>&nbsp;&nbsp;Kebangsaan</p><p>&nbsp;&nbsp;<?php ?></p></td>
		<td><p>&nbsp;&nbsp;pekerjaan</p><p>&nbsp;&nbsp;<?=$pasien['pekerjaan']?></p></td>
		<td><p>&nbsp;&nbsp;No. KTP/SIM/Paspor</p><p>&nbsp;&nbsp;<?=$pasien['no_ktp']?></p></td>
        <td align="center"><p>&nbsp;&nbsp;Status Perkawinan</p><p>&nbsp;&nbsp;<span <?php if($dP['sex']=='K'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>> K </span> / <span <?php if($dP['sex']=='TK'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>> TK </span>
		 / <span <?php if($dP['sex']=='C'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>> C </span>
		  / <span <?php if($dP['sex']=='J'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>> J </span>
		   / <span <?php if($dP['sex']=='D'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>> D </span></p></td>
		<td><p>&nbsp;&nbsp;Jenis Pembayaran</p><p>&nbsp;&nbsp;<?php ?></p></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="6" class="border-kaki"><p>&nbsp;&nbsp;Alergi</p><p>&nbsp;&nbsp;<?php 
	$dt12 = "";
	$queryPsn = "SELECT * FROM b_pelayanan where id = $idPel";
	$dqueryPsn = mysql_fetch_array(mysql_query($queryPsn));
	
	$query1  = "SELECT * FROM b_riwayat_alergi WHERE pasien_id = $dqueryPsn[pasien_id]";
	$exequery1 = mysql_query($query1);
	$jmlquery1 = mysql_num_rows($exequery1);
	$jji = 1;
	while($dquery1 = mysql_fetch_array($exequery1))
	{
		if($jji<$jmlquery1)
		{
			$dt12 .= $dquery1['riwayat_alergi'].",";
		}else{
			$dt12 .= $dquery1['riwayat_alergi'];
		}
		
		$jji++;
	}
		echo $dt12;
	?></p></td>
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
  <tr id="trTombol">
  <td align="center" colspan="6"><input type="submit" name="button" id="button" value="Cetak" onclick="cetak(document.getElementById('trTombol'));" />
   									<input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/></td>
  </tr>
</table>
</body>
</html>
<script>
    function cetak(tombol){
        tombol.style.visibility='collapse';
        if(tombol.style.visibility=='collapse'){
            if(confirm('Anda yakin mau mencetak ?')){
                /*setTimeout('window.print()','1000');
                setTimeout('window.close()','2000');*/
				window.print();
                window.close();
            }
            else{
                tombol.style.visibility='visible';
            }

        }
    }

</script>