<?php
session_start();
include '../koneksi/konek.php';
$idPel=$_REQUEST['idPel'];
$idKunj=$_REQUEST['idKunj'];
$jml=$_REQUEST['jml'];
$jns1=$_REQUEST['jns1'];

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
    THEN 'Perempuan' 
    ELSE 'Laki - Laki' 
  END AS sex,
  mk.nama kelas,
  md.nama AS diag,
  peg.nama AS dokter,
  kso.nama nmKso,
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
  un.nama nmUnit,
  p.no_lab,
  mp.tgl_lahir,
  peg1.nama AS dok_rujuk,
  k.umur_thn,
  k.id,
  p.id,
  DATE_FORMAT(CURDATE(), '%d %M %Y') AS tgl1,
  DATE_FORMAT(
    DATE_ADD(CURDATE(), INTERVAL $jml DAY),
    '%d %M %Y'
  ) AS tgl2 
FROM
  b_kunjungan k 
  INNER JOIN b_ms_pasien mp 
    ON k.pasien_id = mp.id 
  INNER JOIN b_pelayanan p 
    ON k.id = p.kunjungan_id 
  INNER JOIN b_tindakan bmt 
    ON k.id = bmt.kunjungan_id 
    AND p.id = bmt.pelayanan_id 
  LEFT JOIN b_ms_kelas mk 
    ON k.kso_kelas_id = mk.id 
  INNER JOIN b_ms_kso kso 
    ON k.kso_id = kso.id 
  LEFT JOIN b_ms_unit un 
    ON un.id = p.unit_id 
  LEFT JOIN b_diagnosa diag 
    ON diag.kunjungan_id = k.id 
  LEFT JOIN b_ms_diagnosa md 
    ON md.id = diag.ms_diagnosa_id 
  LEFT JOIN b_ms_pegawai peg 
    ON peg.id = bmt.user_act 
  LEFT JOIN b_ms_pegawai peg1 
    ON bmt.user_id = peg1.id 
WHERE k.id='$idKunj' AND p.id='$idPel'";
//echo $sqlPas."<br>";
$rs1 = mysql_query($sqlPas);
//echo mysql_error();
$rw = mysql_fetch_array($rs1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Surat Keterangan Sakit :.</title>
</head>
<style>
.kotak{
border:1px solid #000000;
}
.kotak2{
border:1px solid #000000;
width:20px;
height:20px;
}
</style>
<body>
<table width="800" border="0" style="font:12px tahoma;">
  <tr>
    <td><table class="kotak" cellspacing="0" cellpadding="0">
      <col width="29" />
      <col width="27" />
      <col width="35" />
      <col width="21" />
      <col width="34" />
      <col width="64" span="8" />
      <tr height="21">
        <td style="font:24px bold tahoma" colspan="8" rowspan="3" height="128" width="338">RS PELINDO I</td>
        <td colspan="5" width="320">&nbsp;</td>
      </tr>
      <tr height="86">
        <td style="font:22px bold tahoma" class="kotak" colspan="5" height="86">SURAT KETERANGAN SAKIT</td>
      </tr>
      <tr height="21">
        <td colspan="5" height="21">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table cellspacing="0" cellpadding="0">
      <col width="29" />
      <col width="27" />
      <col width="35" />
      <col width="21" />
      <col width="34" />
      <col width="64" span="10" />
      <tr height="21">
        <td height="21" width="29"></td>
        <td colspan="12" width="629">yang    bertandatangan di bawah ini, Dokter RS PELINDO I, menerangkan bahwa:</td>
        <td width="64"></td>
        <td width="64"></td>
      </tr>
      <tr height="21">
        <td height="21"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="26">
        <td height="26"></td>
        <td colspan="2">Nama&nbsp;</td>
        <td>:</td>
        <td colspan="11"><?php echo $rw['nmPas'];?></td>
      </tr>
      <tr height="26">
        <td height="26"></td>
        <td colspan="2">Alamat</td>
        <td>:</td>
        <td colspan="11"><?php echo $rw['alamat'];?>&nbsp;RT <?php echo $rw['rt'];?> / RW <?php echo $rw['rw'];?>, Desa <?php echo $rw['nmDesa'];?>, Kecamatan <?php echo $rw['nmKec'];?></td>
      </tr>
      <tr height="26">
        <td height="26"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="33">
        <td height="33"></td>
        <td><div class="kotak2">&nbsp;&radic;</div></td>
        <td></td>
        <td colspan="12">Berhubung sakit    memerlukan istirahat selama: (<strong><? echo $jml;?></strong>) hari terhitung</td>
      </tr>
      <tr height="33">
        <td height="33"></td>
        <td></td>
        <td></td>
        <td colspan="12">tanggal : <strong><?php echo $rw['tgl1'];?></strong>  s/d <strong><?php echo $rw['tgl2'];?></strong></td>
      </tr>
      <tr height="24">
        <td height="24"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="33">
        <td height="33"></td>
        <td><div class="kotak2">&nbsp;</div></td>
        <td></td>
        <td colspan="12">Memerlukan ijin tanggal    &hellip;&hellip;&hellip;&hellip;.&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.untuk datang ke RS PELINDO I</td>
      </tr>
      <tr height="26">
        <td height="26"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="33">
        <td height="33"></td>
        <td><div class="kotak2">&nbsp;</div></td>
        <td></td>
        <td colspan="12">Cuti Hamil sesuai    Peraturan yang berlaku selama&hellip;&hellip;&hellip;.&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;..Bulan,perhitungan perkiraan</td>
      </tr>
      <tr height="33">
        <td height="33"></td>
        <td></td>
        <td></td>
        <td colspan="12">Persalinan Tanggal    &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;..</td>
      </tr>
      <tr height="27">
        <td height="27"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="33">
        <td height="33"></td>
        <td><div class="kotak2">&nbsp;</div></td>
        <td></td>
        <td colspan="12">Di rawat di RS Pelindo I selama &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.(&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;..&hellip;)hari terhitung</td>
      </tr>
      <tr height="33">
        <td height="33"></td>
        <td></td>
        <td></td>
        <td colspan="12">tanggal :    &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;..&hellip;&hellip;&hellip;..s/d&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;...&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;dan istirahat tambahan selama</td>
      </tr>
      <tr height="33">
        <td height="33"></td>
        <td></td>
        <td></td>
        <td colspan="8">(&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.)hari    setelah dipulangkan</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="33">
        <td height="33"></td>
        <td></td>
        <td></td>
        <td colspan="5">Harap yang berkepentingan    maklum.</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="33">
        <td height="33"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="33">
        <td height="33"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5">Medan, <?php echo gmdate('d F Y',mktime(date('H')+7));?></td>
      </tr>
      <tr height="33">
        <td height="33"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5">Dokter,</td>
      </tr>
      <tr height="21">
        <td height="21"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="21">
        <td height="21"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="21">
        <td height="21"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="21">
      <?php
			$sqlPet = "select nama from b_ms_pegawai where id = $_REQUEST[idUser]";
			//echo $sqlPet;
			$dt = mysql_query($sqlPet);
			$rt = mysql_fetch_array($dt);
			//echo $pegawai;
			?>
        <td height="21"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5" style="font-weight:bold;font-size:12px">(<?php echo $rt['nama'];?>)</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
