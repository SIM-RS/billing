<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>persetujuan_transfusi</title>
</head>
<?
include "setting.php";
$date_now = gmdate('d F Y',mktime(date('H')+7));
function pecahString($string, $n)
{
	$jumSub = ceil(strlen($string)/$n);
	
	$hasil = array();
	for ($i=0; $i<=$jumSub-1; $i++)
	{
		$hasil[$i] = substr($string, $i*$n, $n);
	}
	
	return $hasil;
}
$transfusi_id = $_REQUEST['transfusi_id'];
$sql = "SELECT * FROM b_persetujuan_transfusi WHERE transfusi_id = '{$transfusi_id}'";
$data = mysql_fetch_array(mysql_query($sql));
if($sex == 'L'){ 
	$jk = '&#10004;'; 
	$jp = '&nbsp;'; 
}else if($sex == 'P'){
	$jk = '&nbsp;'; 
	$jp = '&#10004;'; 
}
if($data['transfusi_status'] == 1){
	$status = "Setuju / <strike>Tidak setuju</strike>";
}else{
	$status = "<strike>Setuju</strike> / Tidak setuju";
}
?>
<body>
<table width="800" border="0" cellpadding="4" style="font:12px tahoma;">
  <tr>
    <td width="262">&nbsp;</td>
    <td width="528" rowspan="5"><table width="528" border="1" align="right" cellpadding="4" bordercolor="#000000" style="border-collapse:collapse;">
      <tr>
        <td width="120">Nama Pasien</td>
		<td width="5">:</td>
        <td width="173" colspan="4"><?=$nama;?></td>
      </tr>
      <tr>
        <td>Tanggal Lahir</td>
		<td>:</td>
        <td width="130"><?=$tgl;?></td>
        <td width="75">Usia</td>
		<td width="5">:</td>
        <td><?=$umur;?> Thn</td>
      </tr>
      <tr>
        <td>No. RM</td>
        <td>:</td>
		<td><?=$noRM;?></td>
        <td>No Registrasi</td>
		<td>:</td>
        <td>____________</td>
      </tr>
      <tr>
        <td>Ruang Rawat / Kelas</td>
		<td>:</td>
        <td colspan="4"><?=$kamar;?> / <?=$kelas;?></td>
      </tr>
      <tr>
        <td>Alamat</td>
		<td>:</td>
        <td colspan="4"><?=$alamat;?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>PERSETUJUAN TRANSFUSI DARAH/<br />
    PRODUK DARAH*</td>
  </tr>
</table>
<br />
<table width="800" border="0" cellpadding="4" style="border:1px solid #000000; font:12px tahoma;">
  <tr>
    <td width="31">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">Saya yang bertanda tangan dibawah ini :</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="22">&nbsp;</td>
    <td width="100">Nama</td>
	<td width="5">:</td>
    <td width="510"><?=$nama;?>&nbsp;
		<span style='border:.5pt solid windowtext;'>&nbsp;&nbsp;<?=$jk?>&nbsp;&nbsp;</span>
		Laki- laki &nbsp;&nbsp;&nbsp;
		<span style='border:.5pt solid windowtext;'>&nbsp;&nbsp;<?=$jp?>&nbsp;&nbsp;</span>
		Perempuan</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Umur</td>
	<td>:</td>
    <td><?=$umur;?> Tahun</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Alamat</td>
    <td>:</td>
	<td><?=$alamat;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Bukti diri/ KTP</td>
	<td>:</td>
    <td><?=$noKTP?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Dirawat di </td>
	<td>:</td>
    <td><?=$kamar;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>No. Rekam Medis</td>
	<td>:</td>
    <td><span style="display:inline-block;">
      <table border="1" bordercolor="#000000" style="border-collapse:collapse;">
        <tr>
		<? 
			$panjang = strlen($noRM);
			$pecah = pecahString($noRM,1);
			for($a = 0; $a < $panjang; $a++){
				echo '<td width="20" height="20" align="center">'.$pecah[$a].'</td>';
			}
			//echo $pecah[0].$pecah[1].$pecah[2].$pecah[3].$pecah[4].$pecah[5].$pecah[6];
		?>
        </tr>
      </table></span>
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4">Produk darah yang akan ditransfusikan : <?=$status?> untuk dilakukan re-screening</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4">yang tujuan, sifat dan perlunya tindakan medis tersebut diatas, serta resiko yang dapat ditimbulkannya</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4">telah cukup dijelaskan oleh dokter dan telah saya mengerti sepenuhnya.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4">Saya sudah berikan kesempatan bertanya dan tidak ada pertanyaan-pertanyaan lagi yang akan saya ajukan</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4">Saya puas dengan penjelasan yang telah diberikan oleh dokter</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4">Demikian pernyataan ini saya buat dengan penuh kesadaran dan tanpa paksaan </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4"><table width="743" border="0" cellpadding="4">
      <tr>
        <td width="224">&nbsp;</td>
        <td width="244">&nbsp;</td>
        <td width="243">&nbsp;</td>
      </tr>
      <tr>
        <td>Medan, <?=$date_now?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="center">Yang membuat pernyataan</td>
        <td>&nbsp;</td>
        <td align="center">Mengetahui Dokter</td>
      </tr>
      <tr>
        <td align="center">Tanda tangan/ Cap jari</td>
        <td>&nbsp;</td>
        <td align="center">Tanda tangan</td>
      </tr>
      <tr>
        <td height="83">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td style='text-align:center; font-weight:bold;'>( <u><?=$nama;?></u> )</td>
        <td>&nbsp;</td>
        <td style='text-align:center; font-weight:bold;'>( <u><?=$namaUser?></u> )</td>
      </tr>
      <tr>
        <td align="center">Nama Jelas</td>
        <td>&nbsp;</td>
        <td align="center">Nama Jelas</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="center">Saksi</td>
        <td>&nbsp;</td>
        <td align="center">Saksi II</td>
      </tr>
      <tr>
        <td align="center">Tanda tangan</td>
        <td>&nbsp;</td>
        <td align="center">Tanda tangan</td>
      </tr>
      <tr>
        <td height="81" valign="bottom" style='text-align:center; font-weight:bold;'>( <u><?=$data['saksi_satu']?></u> )</td>
        <td>&nbsp;</td>
        <td valign="bottom" style='text-align:center; font-weight:bold;'>( <u><?=$data['saksi_dua']?></u> )</td>
      </tr>
      <tr>
        <td align="center">Nama Jelas</td>
        <td>&nbsp;</td>
        <td align="center">Nama Jelas</td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>*Coret yang tidak perlu</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Beri tanda &radic; pada jawaban yang dipilih</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
</table>
</body>
</html>
