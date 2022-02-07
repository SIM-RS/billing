<?
include("../../sesi.php");
?>
<title>.: Laporan Kegiatan Kesehatan Jiwa :.</title>
<?php
    include ("../../koneksi/konek.php");
    $date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$semester = $_POST['cmbTri'];
	$thn = $_POST['cmbThnTri'];
	if($_POST['cmbTri']=='1'){
		$bln = "TRIBULAN I : JANUARI - MARET";
		$waktu = "AND MONTH(b_diagnosa_rm.tgl) BETWEEN '01' AND '03'";
		$tahun = "AND YEAR(b_diagnosa_rm.tgl)='".$thn."'";
	}elseif($_POST['cmbTri']=='2'){
		$bln = "TRIBULAN II : APRIL - JUNI";
		$waktu = "AND MONTH(b_diagnosa_rm.tgl) BETWEEN '04' AND '06'";
		$tahun = "AND YEAR(b_diagnosa_rm.tgl)='".$thn."'";
	}elseif($_POST['cmbTri']=='3'){
		$bln = "TRIBULAN III : JULI - SEPTEMBER";
		$waktu = "AND MONTH(b_diagnosa_rm.tgl) BETWEEN '07' AND '09'";
		$tahun = "AND YEAR(b_diagnosa_rm.tgl)='".$thn."'";
	}else{
		$bln = "TRIBULAN IV : OKTOBER - DESEMBER";
		$waktu = "AND MONTH(b_diagnosa_rm.tgl) BETWEEN '10' AND '12'";
		$tahun = "AND YEAR(b_diagnosa_rm.tgl)='".$thn."'";
	} 
    
    $jnsLay = $_REQUEST['JnsLayanan'];
    $tmpLay = $_REQUEST['TmpLayananPsi'];
    
    
    $sqlUnit = "SELECT id,nama FROM b_ms_unit WHERE id = '".$tmpLay."'";
    $rsUnit = mysql_query($sqlUnit);
    $rwUnit = mysql_fetch_array($rsUnit);
?>
<style>
	.jdl{
		border-right:1px solid #FFFFFF;
		border-bottom:1px solid #FFFFFF;
		height:30;
		font-size:12px;
		text-transform:uppercase;
		text-align:center;
	}
</style>
<table width="800" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
  </tr>
  <tr>
    <td style="text-align:center; font-weight:bold; text-transform:uppercase; font-size:14px;" height="75" valign="top">laporan kegiatan kesehatan jiwa<br />tempat layanan <u><?php echo $rwUnit['nama'];?></u><br /><?php echo $bln.'&nbsp;'.$thn;?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">
      <tr style="background-color:#00FF00;">
        <td class="jdl">no</td>
        <td class="jdl">jenis kegiatan</td>
        <td class="jdl">jumlah</td>
      </tr>
      
      <tr>
        <td height="22" style="text-align:center; border-right:1px solid #00FF00; border-bottom:1px solid #999999;" bgcolor="#FFCCFF">1</td>
        <td style="border-right:1px solid #00FF00; border-bottom:1px solid #999999; text-align:center;" bgcolor="#FFCCFF">2</td>
        <td style="text-align:center; border-bottom:1px solid #999999;" bgcolor="#FFCCFF">3</td>
      </tr>
      <tr>
        <td height="22" width="5%" style="text-align:center; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">1</td>
        <td width="75%" style="padding-left:5px; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">Jumlah penderita baru psikosis yang ditemukan/diobati</td>
        <td width="20%" style="text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
      </tr>
      <tr>
        <td height="22" style="text-align:center; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">2</td>
        <td style="padding-left:5px; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">Jumlah penderita baru penyalahgunaan obat/narkotika yang ditemukan/diobati</td>
        <td style="text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
      </tr>
      <tr>
        <td height="22" style="text-align:center; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">3</td>
        <td style="padding-left:5px; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">Jumlah penderita baru retardasi mental yang ditemukan/diobati</td>
        <td style="text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
      </tr>
      <tr>
        <td height="22" style="text-align:center; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">4</td>
        <td style="padding-left:5px; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">Jumlah penderita baru epilepsi yang ditemukan/diobati</td>
        <td style="text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
      </tr>
      <tr>
        <td height="22" style="text-align:center; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">5</td>
        <td style="padding-left:5px; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">Jumlah penderita baru/diobati:</td>
        <td style="text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
      </tr>
      <tr>
        <td height="22" style="text-align:center; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">&nbsp;</td>
        <td style="padding-left:5px; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">-&nbsp;Gangguan jiwa lain</td>
        <td style="text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
      </tr>
      <tr>
        <td height="22" style="text-align:center; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">&nbsp;</td>
        <td style="padding-left:5px; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">-&nbsp;Geriatri dementia</td>
        <td style="text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
      </tr>
      <tr>
        <td height="22" style="text-align:center; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">6</td>
        <td style="padding-left:5px; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">Jumlah penderita lama psikosis/neorosis yang diobati</td>
        <td style="text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
      </tr>
      <tr>
        <td height="22" style="text-align:center; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">7</td>
        <td style="padding-left:5px; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">Jumlah penderita lama penyalahgunaan obat, narkotika</td>
        <td style="text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
      </tr>
      <tr>
        <td height="22" style="text-align:center; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">8</td>
        <td style="padding-left:5px; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">Jumlah penderita lama epilepsi/gangguan jiwa lain yang diobati</td>
        <td style="text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
      </tr>
      <tr>
        <td height="22" style="text-align:center; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">9</td>
        <td style="padding-left:5px; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">Jumlah kunjungan pusk dalam rangka tindak lanjut perawatan pembinaan penderita psikosis</td>
        <td style="text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
      </tr>
      <tr>
        <td height="22" style="text-align:center; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">10</td>
        <td style="padding-left:5px; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">Jumlah penderita psikosis yang dirujuk kerumah sakit jiwa</td>
        <td style="text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
      </tr>
      <tr>
        <td height="22" style="text-align:center; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">11</td>
        <td style="padding-left:5px; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">Jumlah pertemuan oordinasi penanganan penderita psikosis (lintas sektoral)</td>
        <td style="text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
      </tr>
      <tr>
        <td height="22" style="text-align:center; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">12</td>
        <td style="padding-left:5px; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">Jumlah penderita lama psikosis</td>
        <td style="text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
      </tr>
      <tr>
        <td height="22" style="text-align:center; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">13</td>
        <td style="padding-left:5px; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">Jumlah penderita lama neurosis/baru neurosis</td>
        <td style="text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
      </tr>
      <tr>
        <td height="22" style="text-align:center; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">14</td>
        <td style="padding-left:5px; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">Jumlah penderita lama penyalahgunaan obat/narkotik </td>
        <td style="text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
      </tr>
      <tr>
        <td height="22" style="text-align:center; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">15</td>
        <td style="padding-left:5px; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">Jumlah penderita lama epilepsi </td>
        <td style="text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
      </tr>
      <tr>
        <td height="22" style="text-align:center; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">16</td>
        <td style="padding-left:5px; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">Jumlah penderita lama yang ditemukan/diobati </td>
        <td style="text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
      </tr>
      <tr>
        <td height="22" style="text-align:center; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">&nbsp;</td>
        <td style="padding-left:5px; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">-&nbsp;Gangguan jiwa lain</td>
        <td style="text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
      </tr>
      <tr>
        <td height="22" style="text-align:center; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">&nbsp;</td>
        <td style="padding-left:5px; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">-&nbsp;Geriatri</td>
        <td style="text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
      </tr>
      <tr>
        <td height="22" style="text-align:center; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">17</td>
        <td style="padding-left:5px; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">Jumlah penderita lama retardasi mental </td>
        <td style="text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
      </tr>
      
    </table></td>
  </tr>
</table>
