<?php
session_start();
include '../koneksi/konek.php';
$idPel=$_REQUEST['idPel'];
$idKunj=$_REQUEST['idKunj'];
$idUser=$_REQUEST['idUser'];
$jml=$_REQUEST['jml'];
$jns1=$_REQUEST['jns1'];
$id=$_REQUEST['id'];

if($_REQUEST['excel']=="yes"){
header("Content-type: application/vnd.ms-excel");
header("Content--Disposition:attachment; filename='hasilLab.xls'");
}

$sqlPas="SELECT DISTINCT 
  no_rm,
  mp.nama nmPas,
  mp.alamat,
  mp.rt,
  mp.rw,
  CASE
    mp.sex 
    WHEN 'P' 
    THEN 'P' 
    ELSE 'L' 
  END AS sex,
  CONCAT(
    DATE_FORMAT(p.tgl, '%d-%m-%Y'),
    ' ',
    DATE_FORMAT(p.tgl_act, '%H:%i')
  ) tgljam,
  DATE_FORMAT(
    IFNULL(p.tgl_krs, NOW()),
    '%d-%m-%Y %H:%i'
  ) tglP,
  mp.desa_id,
  mp.kec_id,
  (SELECT 
    nama 
  FROM
    b_ms_wilayah 
  WHERE id = mp.kec_id) nmKec,
  (SELECT 
    nama 
  FROM
    b_ms_wilayah 
  WHERE id = mp.desa_id) nmDesa,
  k.kso_id,
  k.kso_kelas_id,
  p.kelas_id,
  p.no_lab,
  mp.tgl_lahir,
  k.umur_thn,
  k.id,
  p.id,
  dok.nama nama_dokter,
   dok.nip nip_dokter,
  peker.nama nama_pekerjaan,
  DATE_FORMAT(CURDATE(), '%d %M %Y') AS tgl1,
  DATE_FORMAT(
    DATE_ADD(CURDATE(), INTERVAL 2 DAY),
    '%d %M %Y'
  ) AS tgl2 
FROM
  b_kunjungan k 
  INNER JOIN b_ms_pasien mp 
    ON k.pasien_id = mp.id 
  INNER JOIN b_pelayanan p 
    ON k.id = p.kunjungan_id 
  LEFT JOIN b_ms_pegawai  dok on p.dokter_tujuan_id=dok.id
  LEFT JOIN b_ms_pekerjaan peker on peker.id=mp.pekerjaan_id
WHERE k.id='$idKunj' AND p.id='$idPel'";
//echo $sqlPas."<br>";
$rs1 = mysql_query($sqlPas);
//echo mysql_error();
$rw = mysql_fetch_array($rs1);
?>
<?
$sqlP="SELECT *, 
DATE_FORMAT(tgl, '%d-%m-%Y')tgl,
IF(tgl_mulai='0000-00-00','-',DATE_FORMAT(tgl_mulai, '%d-%m-%Y')) AS tgl_mulai,
IF(tgl_akhir='0000-00-00','-',DATE_FORMAT(tgl_akhir, '%d-%m-%Y')) AS tgl_akhir,
IF(tgl_mulai2='0000-00-00','-',DATE_FORMAT(tgl_mulai2, '%d-%m-%Y')) AS tgl_mulai2,
IF(tgl_akhir2='0000-00-00','-',DATE_FORMAT(tgl_akhir2, '%d-%m-%Y')) AS tgl_akhir2,
IF(tgl_per='0000-00-00','-',DATE_FORMAT(tgl_per, '%d-%m-%Y')) AS tgl_per,
DATE_FORMAT(tgl,'%W') AS nm_hari 
FROM b_surat_ket_dokter
WHERE id='$id';";
$dP=mysql_fetch_array(mysql_query($sqlP));
{

?>
<?
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Surat Keterangan sakit</title>
<style type="text/css">
<!--
.style2 {font-size: 10px}
-->
</style>
</head>
<style>
.kotak{
border:1px solid #000000;
}
a {
    border-bottom: 2px dotted;
}
.kotak2{
border:1px solid #000000;
width:20px;
height:20px;
}
</style>
<body>
<div>
<form id="form1" name="form1" action="sk_sakit_act.php">
<input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUser" value="<?=$idUser?>" />
    			<input type="hidden" name="id" id="id"/>
				
<table width="800" border="0" style="font:12px tahoma;">
  <tr>
    <td>
	
	<table width="100%" cellspacing="0" cellpadding="0" style="font:20px bold tahoma">

      <tr height="" align="left">
        <td   align="left">
		<div style="font:16px bold tahoma;">PT. PELABUHAN INDONESIA I (PERSERO) </br></div>
       <?php echo $_SESSION['namaP'];  ?> </br>
       <div style="font:12px tahoma;"><?php echo $_SESSION['alamatP'];  ?>  Telp. <?php echo $_SESSION['tlpP']; ?> <?php echo $_SESSION['kecP'] ?> </div>      </tr>
      <tr height="" align="center">
        <td  colspan="8" height="93" align="center"><u>SURAT KETERANGAN DOKTER</u> </td>
        </tr>
    </table>	</td>
  </tr>
  
  <tr>
    <td align="center"><table width="644" height="251">
      <tr>
        <td colspan="3">Yang bertanda tangan di bawah ini : </td>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td width="54">&nbsp;</td>
        <td width="101">Nama</td>
        <td width="24">:</td>
        <td colspan="2"><?php echo $rw['nama_dokter'];?></td>
      </tr>
      <tr>
        <td height="16">&nbsp;</td>
        <td colspan="4">Dokter Rumah Sakit Umum Belawan Bahagia </td>
      </tr>
      <tr>
        <td height="18">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td height="16" colspan="3">Menerangkan bahwa </td>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td height="16">&nbsp;</td>
        <td>Nama</td>
        <td>:</td>
        <td colspan="2"><?php echo $rw['nmPas'];?></td>
      </tr>
      <tr>
        <td height="16">&nbsp;</td>
        <td>Umur</td>
        <td>:</td>
        <td colspan="2"><?php echo $rw['umur_thn'];?>&nbsp;Thn</td>
      </tr>
      <tr>
        <td height="16">&nbsp;</td>
        <td>Pekerjan</td>
        <td>:</td>
        <td colspan="2"><?php echo $rw['nama_pekerjaan'];?></td>
      </tr>
      <tr>
        <td height="23">&nbsp;</td>
        <td>Alamat</td>
        <td>:</td>
        <td colspan="2"><?php echo $rw['alamat'];?>&nbsp;RT <?php echo $rw['rt'];?> / RW <?php echo $rw['rw'];?>, Desa <?php echo $rw['nmDesa'];?>, Kecamatan <?php echo $rw['nmKec'];?></td>
      </tr>
      <tr>
        <td height="16" colspan="5">Pada Pemeriksaan kami sehubungan dengan kesahatan / penyakitnya perlu istirahat / kerja ringan dari tanggal
          <?=$dP['tgl_mulai']?>
          s/d tanggal
          <?=$dP['tgl_akhir']?>.</td>
      </tr>
      <tr>
        <td height="16" colspan="5">Demikian untuk diketahui. </td>
      </tr>
      <tr align="center">
        <td height="16">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr align="center">
        <td height="16">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td width="113">&nbsp;</td>
        <td width="282">Belawan, <?php echo gmdate('d F Y',mktime(date('H')+7));?></td>
      </tr>
      <tr align="center">
        <td height="16">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Dokter yang memeriksa </td>
      </tr>
      <tr>
        <td height="16">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="16">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr align="center">
        <td height="16">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td >( <a><?php echo $rw['nama_dokter'];?> </a>)</td>
      </tr>
      <tr align="center">
        <td height="16">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>NIP/PN : <?php echo $rw['nip_dokter'];?></td>
      </tr>
      <tr>
        <td height="16">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2"></td>
      </tr>
    </table></td>
  </tr>
  <tr id="trCetak">
    <td align="center"><input type="button" name="bt_cetak" id="bt_cetak" value="Cetak" onclick="cetak()" /></td>
  </tr>
</table>
</form>
</div>
</body>
</html>
<script>
function cetak(){
	document.getElementById('trCetak').style.display="none";
	window.print();	
}
</script>