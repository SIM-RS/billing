<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Surat Kenal Lahir</title>
<style type="text/css">
<!--
.style1 {
	font-size: 30px;
	font-weight: bold;
}
-->
</style>
<?
include "setting.php";
$dt=mysql_fetch_array(mysql_query("SELECT a.*, DATE_FORMAT(a.`tgl_kelahiran`, '%W') hari, DATE_FORMAT(a.`tgl_kelahiran`, '%d %M %Y') tanggal, DATE_FORMAT(a.`tgl_kelahiran`, '%H:%i:%s') jam FROM srt_kenal_lahir a where id='$_GET[id]'"));

if (!function_exists('kekata')) {
function kekata($x) {
  $x = abs($x);
  $angka = array("", "satu", "dua", "tiga", "empat", "lima",
  "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
  $temp = "";
  if ($x <12) {
	  $temp = " ". $angka[$x];
  } else if ($x <20) {
	  $temp = kekata($x - 10). " belas";
  } else if ($x <100) {
	  $temp = kekata($x/10)." puluh". kekata($x % 10);
  } else if ($x <200) {
	  $temp = " seratus" . kekata($x - 100);
  } else if ($x <1000) {
	  $temp = kekata($x/100) . " ratus" . kekata($x % 100);
  } else if ($x <2000) {
	  $temp = " seribu" . kekata($x - 1000);
  } else if ($x <1000000) {
	  $temp = kekata($x/1000) . " ribu" . kekata($x % 1000);
  } else if ($x <1000000000) {
	  $temp = kekata($x/1000000) . " juta" . kekata($x % 1000000);
  } else if ($x <1000000000000) {
	  $temp = kekata($x/1000000000) . " milyar" . kekata(fmod($x,1000000000));
  } else if ($x <1000000000000000) {
	  $temp = kekata($x/1000000000000) . " trilyun" . kekata(fmod($x,1000000000000));
  }      
	  return $temp;
}
}
?>
</head>

<body>
<table width="894" border="0" cellpadding="4" style="font:12px tahoma;">
  <tr>
    <td colspan="6">RS PELINDO I </td>
  </tr>
  
  
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6"><div align="center" class="style1">SURAT KENAL LAHIR </div></td>
  </tr>
  <tr>
    <td colspan="6"><div align="center">No.&nbsp;<?=$dt["nomor"]?></div></td>
  </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6">Yang bertanda tangan dibawah ini : </td>
  </tr>
  <tr>
    <td width="48">&nbsp;</td>
    <td colspan="2">Nama</td>
    <td width="5">:</td>
    <td colspan="2">&nbsp;<?=$dt["nama"]?></td>
  </tr>
  <tr>
    <td colspan="6">Menerangkan bahwa kami telah tolong/rawat* bayi : </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">Nama Bayi </td>
    <td>:</td>
    <td colspan="2">&nbsp;<?=$dt["nama_bayi"]?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">Jenis Kelamin </td>
    <td>:</td>
    <td colspan="2"><span <?php if($dt['jenis_kel']==0){echo 'style="text-decoration:line-through"';}?>>Pria</span>&nbsp;&nbsp;/&nbsp;&nbsp;<span <?php if($dt['jenis_kel']==1){echo 'style="text-decoration:line-through"';}?>>Wanita</span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">Anak dari :</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="21">&nbsp;</td>
    <td width="141">Ibu</td>
    <td>:</td>
    <td colspan="2">&nbsp;<?=$nama?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>No. Kartu Identitas </td>
    <td>:</td>
    <td colspan="2">&nbsp;<?=$noKTP?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Ayah</td>
    <td>:</td>
    <td colspan="2">&nbsp;<?=$nama_suami_istri?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>No. Kartu Identitas </td>
    <td>:</td>
    <td colspan="2">&nbsp;<? ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Alamat Rumah </td>
    <td>:</td>
    <td colspan="2">&nbsp;<?=$alamat?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Pekerjaan</td>
    <td>:</td>
    <td colspan="2">&nbsp;<?=$pekerjaan?></td>
  </tr>
  <tr>
    <td colspan="3">Nomor Registrasi pasien/ibu </td>
    <td>:</td>
    <td colspan="2">&nbsp;<?=$noRM?></td>
  </tr>
  
  <tr>
    <td colspan="3">Kelahiran ditolong pada </td>
    <td>:</td>
    <td width="74">a. Hari</td>
    <td width="579">:&nbsp;<?php
    $namahari =$dt["hari"];
	if ($namahari == "Sunday") $namahari = "Minggu";
else if ($namahari == "Monday") $namahari = "Senin";
else if ($namahari == "Tuesday") $namahari = "Selasa";
else if ($namahari == "Wednesday") $namahari = "Rabu";
else if ($namahari == "Thursday") $namahari = "Kamis";
else if ($namahari == "Friday") $namahari = "Jumat";
else if ($namahari == "Saturday") $namahari = "Sabtu";
	echo $namahari;
	?></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
    <td>b. Tanggal </td>
    <td>:&nbsp;<?=tgl_ina($dt["tgl_kelahiran"]);?></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
    <td>c. Jam </td>
    <td>:&nbsp;<?=$dt["jam"]?></td>
  </tr>
  <tr>
    <td colspan="3">Proses Persalinan </td>
    <td>:</td>
    <td> Normal </td>
    <td>:&nbsp;<?=$dt["salin_normal"]?></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
    <td>Tindakan</td>
    <td>:&nbsp;<?=$dt["salin_tindakan"]?></td>
  </tr>
  <tr>
    <td colspan="3">Anak ke </td>
    <td>:</td>
    <td colspan="2">&nbsp;<?=$dt["anak_ke"]?>&nbsp;(<?=kekata($dt["anak_ke"])?> )</td>
  </tr>
  <tr>
    <td colspan="3">Kembar</td>
    <td>:</td>
    <td colspan="2">&nbsp;<?=$dt["kembar"]?>&nbsp;(<?=kekata($dt["kembar"])?> )</td>
  </tr>
  <tr>
    <td colspan="3">Panjang</td>
    <td>:</td>
    <td colspan="2">&nbsp;<?=$dt["panjang"]?>&nbsp;cm</td>
  </tr>
  <tr>
    <td colspan="3">Berat badan </td>
    <td>:</td>
    <td colspan="2">&nbsp;<?=$dt["berat"]?>&nbsp;gram</td>
  </tr>
  <tr>
    <td colspan="3">Lingkar Kepala </td>
    <td>:</td>
    <td colspan="2">&nbsp;<?=$dt["lingkar"]?>&nbsp;cm</td>
  </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6"><table width="886" border="0">
      <tr>
        <td width="517">&nbsp;</td>
        <td width="359"><div align="center">Nama dan Tanda Tangan </div></td>
      </tr>
      <tr>
        <td height="48">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><div align="center">(<b><u><?=$dt["nama"]?></u></b>)</div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><div align="center">Yang Menolong </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6">Sidik Telapak Kaki Bayi : </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5"><table width="484" height="281" border="1" bordercolor="#000000" style="border-collapse:collapse;">
      <tr>
        <td width="236" height="277">&nbsp;</td>
        <td width="238">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6">Sidik Jari Tangan Ibu : </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5"><table width="482" height="266" border="1" bordercolor="#000000" style="border-collapse:collapse;">
      <tr>
        <td height="262">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  
  
  <tr>
    <td colspan="6"><table width="893" border="0">
      <tr>
        <td width="339"><div align="center">TTD Saksi </div></td>
        <td width="210">&nbsp;</td>
        <td width="330">Medan, <?php echo tgl_ina(date("Y-m-d"))?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><div align="left">RS PELINDO I </div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><div align="left">Yang memeriksa, </div></td>
      </tr>
      <tr>
        <td height="69">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><div align="center">(_______________________________)</div></td>
        <td>&nbsp;</td>
        <td><div align="left">(<b><u><?=$usr["nama"]?></u></b>)</div></td>
      </tr>
      <tr>
        <td><div align="center">Hubungan Keluarga:___________________ </div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
</table>
<br />
<table width="714" border="0">
  <tr>
    </tr><tr id="trTombol">
        <td class="noline" colspan="5" align="right"><div align="center">
          <input name="button" type="button" id="btnPrint" onclick="cetak(document.getElementById('trTombol'));" value="Print"/>
          <input name="button2" type="button" id="btnTutup" onclick="window.close();" value="Tutup"/>
        </div></td>
      </tr></table>
<table width="714" border="0"><tr>
  <td width="708" align="center">&nbsp;</td>
</tr>
</table>
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
    </script></body>


</html>
