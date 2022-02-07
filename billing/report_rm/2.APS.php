<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>APS</title>
</head>
<?
include "setting.php";
$sqlInform="SELECT * FROM lap_inform_konsen WHERE pelayanan_id = '".$idPel."' AND kunjungan_id = '".$idKunj."';";
$isiInform=mysql_fetch_array(mysql_query($sqlInform));
$sqlPlg="SELECT b.nama FROM b_pasien_keluar a
INNER JOIN b_ms_pegawai b
ON a.dokter_id = b.id
WHERE pelayanan_id = '".$idPel."' AND kunjungan_id = '".$idKunj."';";
$isiPlg=mysql_fetch_array(mysql_query($sqlPlg));
?>
<body>
<table width="728" border="0" cellpadding="4" style="font:12px tahoma;">
  <tr>
    <td colspan="10">SURAT PERNYATAAN PULANG RAWAT </td>
  </tr>
  <tr>
    <td colspan="10">ATAS PERMINTAAN SENDIRI (APS) </td>
  </tr>
  <tr>
    <td width="151">&nbsp;</td>
    <td width="16">&nbsp;</td>
    <td width="24">&nbsp;</td>
    <td width="71">&nbsp;</td>
    <td width="92">&nbsp;</td>
    <td width="22">&nbsp;</td>
    <td width="96">&nbsp;</td>
    <td width="1">&nbsp;</td>
    <td width="147">&nbsp;</td>
    <td width="66">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="10">Saya yang bertanda tangan dibawah ini: </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
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
  <tr>
    <td>Nama</td>
    <td colspan="8">: <?=$isiInform['nama']?></td>
    <td>(<?=$isiInform['jenis_kelamin']?>)*</td>
  </tr>
  <tr>
    <td>Umur</td>
    <td colspan="8">: <?=$isiInform['umur']?> Tahun </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>No. KTP </td>
    <td colspan="8">:_______________________________________________</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Alamat</td>
    <td colspan="8">:_______________________________________________</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="8"> &nbsp;_______________________________________________</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Telepon</td>
    <td colspan="8">: <?=$telp?></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
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
  <tr>
    <td colspan="10">Dalam hal ini bertindak atas nama atau untuk mewakili : Diri sediri/ suami/ istri/ anak/ </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
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
  <tr>
    <td>Nama Pasien </td>
    <td colspan="8">: <?=$nama;?></td>
    <td>(<?=$sex;?>)*</td>
  </tr>
  
  <tr>
    <td>No. MR </td>
    <td colspan="8">:
    <?=$noRM;?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Umur</td>
    <td colspan="9">: <?=$umur;?> Tahun </td>
  </tr>
  <tr>
    <td>Kelas/ Kamar </td>
    <td colspan="8">: <?=$kelas;?> / <?=$kamar;?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Dokter yang merawat </td>
    <td colspan="8">: <?=$isiPlg['nama']?> </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
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
  <tr>
    <td colspan="10">Atas permintaan sendiri pulang/ keluar dari perawatan rumah sakit umum kota tangerang.</td>
  </tr>
  <tr>
    <td colspan="10">Kami bertanggung jawab atas segala akibat yang mungkin terjadi atas kesehatan pasien tersebut diatas, oleh karena menurut dokter belum boleh pulang/ keluar dari perawatan di rumah sakit umum kota tangerang</td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="8">&nbsp; </td>
    <td colspan="2">Medan,</td>
  </tr>
  <tr>
    <td colspan="10"><table width="721" border="0">
      <tr>
        <td width="216"><div align="center">Mengetahui,</div></td>
        <td width="278">&nbsp;</td>
        <td width="213">Pukul : </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Yang Membuat Pernyataan. </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><div align="center">______________________</div></td>
        <td>&nbsp;</td>
        <td><div align="center">(______________________)</div></td>
      </tr>
      <tr>
        <td><div align="center">Nama dan Tanda Tangan </div></td>
        <td>&nbsp;</td>
        <td><div align="center">Nama dan Tanda Tangan </div></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
