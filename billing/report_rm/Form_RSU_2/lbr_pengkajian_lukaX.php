<?php
session_start();
include '../../koneksi/konek.php';
$idPel=$_REQUEST['idPel'];
$idKunj=$_REQUEST['idKunj'];
$idUser=$_REQUEST['idUser'];
$idPasien=$_REQUEST['idPasien'];
$id=$_REQUEST['id'];

$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,kk.no_reg as no_reg2
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_kunjungan kk ON kk.id=pl.kunjungan_id
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));


if($_REQUEST['excel']=="yes"){
header("Content-type: application/vnd.ms-excel");
header("Content--Disposition:attachment; filename='hasilLab.xls'");
}
$usr=mysql_fetch_array(mysql_query("select nama from b_ms_pegawai where id='$idUser'"));
$sqlPas="SELECT DISTINCT 
  no_rm,
  mp.nama nmPas,
  mp.alamat,
  mp.rt,
  mp.rw,
  mp.sex,
  CASE
    mp.sex 
    WHEN 'P' 
    THEN 'Perempuan' 
    ELSE 'Laki - Laki' 
  END AS sex2,
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
  DATE_FORMAT(mp.tgl_lahir, '%d %M %Y') tgllahir,
  peg1.nama AS dok_rujuk,
  k.umur_thn,
  DATE_FORMAT(CURDATE(), '%d %M %Y') AS tgl1,
  bmk.nama kelas,
  z.*,
  DATE_FORMAT(z.tgllab, '%d %M %Y') AS tgl_lab
FROM
  b_kunjungan k 
  INNER JOIN b_ms_pasien mp 
    ON k.pasien_id = mp.id 
  LEFT JOIN b_ms_pekerjaan bpek 
    ON bpek.id = mp.pekerjaan_id
  LEFT JOIN b_ms_agama bagm
    ON bagm.id = mp.agama 
  INNER JOIN b_pelayanan p 
    ON k.id = p.kunjungan_id 
  LEFT JOIN b_tindakan bmt 
    ON k.id = bmt.kunjungan_id 
    AND p.id = bmt.pelayanan_id 
  LEFT JOIN b_ms_kelas mk 
    ON k.kso_kelas_id = mk.id 
  LEFT JOIN b_ms_kso kso 
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
  LEFT JOIN b_pasien_keluar bkel
    ON bkel.pelayanan_id = p.id
  LEFT JOIN b_ms_pegawai peg3
    ON peg3.id = bkel.dokter_id
  LEFT JOIN b_ms_kelas bmk
    ON bmk.id = p.kelas_id
  LEFT JOIN lbr_pngkajian_luka z
  	ON z.pelayanan_id = p.id
WHERE z.luka_id='$id' AND k.id='$idKunj' AND p.id='$idPel'";

//echo $sqlPas."<br>";
$rs1 = mysql_query($sqlPas);
//echo mysql_error();
$isi = mysql_fetch_array($rs1);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link type="text/css" rel="stylesheet" href="eksel.css" />
</head>

<body>
<table border="0">
  <tr>
    <td width="358"><table cellspacing="0" cellpadding="0" width="351">
      <tr>
        <td width="349"><img src="pngwsn_khsus_bayi_clip_image002.png" alt="" width="317" height="61" /></td>
      </tr>
      <tr>
        <td align="center"><b>LEMBAR PENGKAJIAN LUKA / LUKA TEKAN</b></td>
      </tr>
      <tr>
        <td align="center">Wound / Pressure Ulcer Assessment Tool</td>
      </tr>
    </table></td>
    <td width="391"><table width="316" border="0" style="font:12px tahoma; border:1px solid #000;">
          <tr>
            <td width="116">Nama Pasien</td>
            <td width="10">:</td>
            <td width="174"><?php echo $isi['nmPas'];?>&nbsp;/&nbsp;<?php echo $isi['sex'];?></td>
          </tr>
          <tr>
            <td>Tanggal Lahir</td>
            <td>:</td>
            <td><?php echo $isi['tgllahir'];?>&nbsp;/ Usia: <?php echo $isi['umur_thn'];?>&nbsp;Th</td>
          </tr>
          <tr>
            <td>No. R.M.</td>
            <td>:</td>
            <td><?php echo $isi['no_rm'];?>&nbsp;No.Registrasi:
            <?=$dP['no_reg2']?></td>
          </tr>
          <tr>
            <td>Ruang Rawat / Kelas</td>
            <td>:</td>
            <td><?php echo $isi['nmUnit'];?>&nbsp;/ <?php echo $isi['kelas'];?></td>
          </tr>
          <tr>
            <td valign="top">Alamat</td>
            <td valign="top">:</td>
            <td><?php echo $isi['alamat'];?>&nbsp;RT <?php echo $isi['rt'];?> / RW <?php echo $isi['rw'];?>, Desa <?php echo $isi['nmDesa'];?>, Kecamatan <?php echo $isi['nmKec'];?></td>
          </tr>
        </table></td>
  </tr>
  <tr>
    <td colspan="2">
<table cellspacing="0" cellpadding="0" class="excel1" style="border:1px solid #000;">
  <col width="26" span="7" style="width:20pt;" />
  <col width="28" style="width:21pt;" />
  <col width="26" span="14" style="width:20pt;" />
  <col width="44" style="width:33pt;" />
  <col width="26" span="2" style="width:20pt;" />
  <tr style="height:14.1pt;">
    <td class="excel2" colspan="4" width="670" style="height:14.1pt;width:80pt;">Tanggal<font class="font5"> ( date)</font></td>
    <td class="excel2" width="26" style="width:20pt;"></td>
    <td class="excel2" width="26" style="width:20pt;"></td>
    <td class="excel2" width="26" style="width:20pt;"></td>
    <td class="excel2" width="28" style="width:21pt;"></td>
    <td class="excel2" width="26" style="width:20pt;">:</td>
    <td colspan="15" class="excel3" style="width:20pt;"><?php echo tgl_ina(date("Y-m-d"))?></td>
    <td class="excel2" width="26" style="width:20pt;"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel2" colspan="3" style="height:14.1pt;">Diagnosa</td>
    <td class="excel2"></td>
    <td class="excel2"></td>
    <td class="excel2"></td>
    <td class="excel2"></td>
    <td class="excel2"></td>
    <td class="excel2">:</td>
    <td colspan="15" class="excel5" style="border-top:none;"><?php 
		$sqlD="SELECT GROUP_CONCAT(md.nama) diagnosa FROM b_diagnosa d
LEFT JOIN b_ms_diagnosa md ON md.id=d.ms_diagnosa_id
LEFT JOIN b_kunjungan k ON k.id=d.kunjungan_id
WHERE d.pelayanan_id='$idPel';";
$exD=mysql_fetch_array(mysql_query($sqlD));
		echo $exD['diagnosa'];?></td>
    <td class="excel2"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel2" colspan="7" style="height:14.1pt;">Nama    dokter yang merawat </td>
    <td class="excel2"></td>
    <td class="excel2">:</td>
    <td colspan="15" class="excel5" style="border-top:none;"><?php echo $isi['dokter'];?></td>
    <td class="excel2"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel2" colspan="8" style="height:14.1pt;">Riwayat    alergi dressing <font class="font5">(Dressing alert)</font></td>
    <td class="excel2">:</td>
    <td colspan="15" class="excel5" style="border-top:none;"><?=$isi['riwayat_alergi']?></td>
    <td class="excel2"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel2" style="height:14.1pt;">1.</td>
    <td class="excel2" colspan="6">Luka yang didapat di RS</td>
    <td class="excel2"></td>
    <td class="excel2" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['luka1']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel2" colspan="2">Ya <font class="font5">(Yes)</font></td>
    <td class="excel2"></td>
    <td class="excel2"></td>
    <td class="excel2" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['luka1']=='2'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel2" colspan="3">Tidak <font class="font5">(No)</font></td>
    <td class="excel2"></td>
    <td class="excel2" colspan="5">Stadium  <u><?=$isi['lukaisi']?></u></td>
    <td class="excel2"></td>
    <td class="excel2"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel2" style="height:14.1pt;"></td>
    <td class="excel2" colspan="7">Resiko luka tekan <font class="font5">(Braden Score)</font></td>
    <td class="excel2" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['luka2']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel2" colspan="2">15 - 16</td>
    <td class="excel2"></td>
    <td class="excel2"></td>
    <td class="excel2" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['luka2']=='2'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel4" colspan="2">12  - 14</td>
    <td class="excel2"></td>
    <td class="excel2"></td>
    <td class="excel2" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['luka2']=='3'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel4" colspan="4">11 atau kurang</td>
    <td class="excel2"></td>
    <td class="excel2"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel16" colspan="3" width="670" style="height:14.1pt;width:60pt;">SKETSA LUKA</td>
    <td class="excel7" width="26" style="width:20pt;"></td>
    <td class="excel7" width="26" style="width:20pt;"></td>
    <td class="excel7" width="26" style="width:20pt;"></td>
    <td class="excel7" width="26" style="width:20pt;"></td>
    <td class="excel7" width="28" style="width:21pt;"></td>
    <td class="excel7" width="26" style="width:20pt;"></td>
    <td class="excel7" width="26" style="width:20pt;"></td>
    <td class="excel7" width="26" style="width:20pt;"></td>
    <td class="excel7" width="26" style="width:20pt;"></td>
    <td class="excel7" colspan="11" width="356" style="width:233pt;">LOKASI    LUKA/LUKA TEKAN <font class="font5">(Wound/Pressure ulcer location)</font></td>
    <td class="excel7" width="26" style="width:20pt;"></td>
    <td class="excel7" width="26" style="width:20pt;"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel8" colspan="2" style="height:14.1pt;">p    x l x t</td>
    <td class="excel9">&nbsp;</td>
    <td class="excel9">&nbsp;</td>
    <td class="excel9">&nbsp;</td>
    <td class="excel9">&nbsp;</td>
    <td class="excel9">&nbsp;</td>
    <td class="excel9">&nbsp;</td>
    <td class="excel9">&nbsp;</td>
    <td class="excel9">&nbsp;</td>
    <td class="excel10">&nbsp;</td>
    <td class="excel7"></td>
    <td class="excel8">&nbsp;</td>
    <td class="excel9">&nbsp;</td>
    <td class="excel9">&nbsp;</td>
    <td class="excel9">&nbsp;</td>
    <td class="excel9">&nbsp;</td>
    <td class="excel9">&nbsp;</td>
    <td class="excel9">&nbsp;</td>
    <td class="excel9">&nbsp;</td>
    <td class="excel9">&nbsp;</td>
    <td class="excel9">&nbsp;</td>
    <td class="excel9">&nbsp;</td>
    <td class="excel10">&nbsp;</td>
    <td class="excel7"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel11" style="height:14.1pt;">&nbsp;</td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel12">&nbsp;</td>
    <td class="excel7"></td>
    <td class="excel11">&nbsp;</td>
    <td colspan="10" rowspan="3" class="excel18">GAMBAR TUBUH MANUSIA</td>
    <td class="excel12">&nbsp;</td>
    <td class="excel7"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel11" style="height:14.1pt;">&nbsp;</td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel12">&nbsp;</td>
    <td class="excel7"></td>
    <td class="excel11">&nbsp;</td>
    <td class="excel12">&nbsp;</td>
    <td class="excel7"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel11" style="height:14.1pt;">&nbsp;</td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel12">&nbsp;</td>
    <td class="excel7"></td>
    <td class="excel11">&nbsp;</td>
    <td class="excel12">&nbsp;</td>
    <td class="excel7"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel11" style="height:14.1pt;">&nbsp;</td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel12">&nbsp;</td>
    <td class="excel7"></td>
    <td class="excel11">&nbsp;</td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel12">&nbsp;</td>
    <td class="excel7"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel11" style="height:14.1pt;">&nbsp;</td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel12">&nbsp;</td>
    <td class="excel7"></td>
    <td class="excel11">&nbsp;</td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel12">&nbsp;</td>
    <td class="excel7"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel13" style="height:14.1pt;">&nbsp;</td>
    <td class="excel14">&nbsp;</td>
    <td class="excel14">&nbsp;</td>
    <td class="excel14">&nbsp;</td>
    <td class="excel14">&nbsp;</td>
    <td class="excel14">&nbsp;</td>
    <td class="excel14">&nbsp;</td>
    <td class="excel14">&nbsp;</td>
    <td class="excel14">&nbsp;</td>
    <td class="excel14">&nbsp;</td>
    <td class="excel15">&nbsp;</td>
    <td class="excel7"></td>
    <td class="excel13">&nbsp;</td>
    <td class="excel14">&nbsp;</td>
    <td class="excel14" colspan="2">Front</td>
    <td class="excel14">&nbsp;</td>
    <td class="excel14">&nbsp;</td>
    <td class="excel14">&nbsp;</td>
    <td class="excel14" colspan="2">Back</td>
    <td class="excel14">&nbsp;</td>
    <td class="excel14">&nbsp;</td>
    <td class="excel15">&nbsp;</td>
    <td class="excel7"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel7" style="height:14.1pt;"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
    <td class="excel7"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" width="670" style="height:14.1pt;width:20pt;">2. </td>
    <td class="excel19" colspan="7" width="184" style="width:141pt;">ETIOLOGI    LUKA <font class="font5">(Wound etiologi)</font></td>
    <td class="excel19" width="26" style="width:20pt;"></td>
    <td class="excel19" width="26" style="width:20pt;"></td>
    <td class="excel19" width="26" style="width:20pt;"></td>
    <td class="excel19" width="26" style="width:20pt;"></td>
    <td class="excel19" width="356" style="width:20pt;"></td>
    <td class="excel19" width="26" style="width:20pt;"></td>
    <td class="excel19" width="26" style="width:20pt;"></td>
    <td class="excel19" width="26" style="width:20pt;"></td>
    <td class="excel19" width="26" style="width:20pt;"></td>
    <td class="excel19" width="26" style="width:20pt;"></td>
    <td class="excel19" width="26" style="width:20pt;"></td>
    <td class="excel19" width="26" style="width:20pt;"></td>
    <td class="excel19" width="26" style="width:20pt;"></td>
    <td class="excel19" width="26" style="width:20pt;"></td>
    <td class="excel19" width="44" style="width:33pt;"></td>
    <td class="excel19" width="26" style="width:20pt;"></td>
    <td class="excel19" width="26" style="width:20pt;"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;"></td>
    <td class="excel19" width="184" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['etio']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="4">Bedah <font class="font5">(Surgery)</font></td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['etio']=='2'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="2">Trauma</td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19" width="356" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['etio']=='3'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="2">Tekanan</td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['etio']=='4'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="4">Lainnya <font class="font5">(Other)</font></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;"></td>
    <td class="excel19" colspan="2">Note  :</td>
    <td colspan="21" class="excel21"><?=$isi['etioisi']?></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;">3.</td>
    <td class="excel19" colspan="10">GAMBARAN KLINIS LUKA <font class="font5">(Clinical appearance)</font></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;"></td>
    <td class="excel19" width="184" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['klinis']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="4">Necrotic/hitam</td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['klinis']=='2'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="4">slough/Kuning</td>
    <td class="excel19"></td>
    <td class="excel19" width="356" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['klinis']=='3'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="4">Granulasi/merah</td>
    <td class="excel19"></td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['klinis']=='4'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="3">Ephitelisasi</td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;"></td>
    <td class="excel19" colspan="2">Note  :</td>
    <td colspan="21" class="excel21"><?=$isi['klinisisi']?></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;">4. </td>
    <td class="excel19" colspan="10">KEADAAN KULIT SEKITAR    LUKA <font class="font5">(Surrounding skin)</font></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;"></td>
    <td class="excel19" width="184" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['kulit']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="3">Baik <font class="font5">(intact)</font></td>
    <td class="excel19"></td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['kulit']=='2'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="5">Maserasi <font class="font5">(Maceration)</font></td>
    <td class="excel19" width="356" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['kulit']=='3'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="5">Denudasi <font class="font5">(denuded)</font></td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['kulit']=='4'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="5">Ekskoriasi <font class="font5">(Excoriation)</font></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;"></td>
    <td class="excel19" colspan="2">Note  :</td>
    <td colspan="21" class="excel21"><?=$isi['kulitisi']?></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;">5.</td>
    <td class="excel19" colspan="6">NYERI / Pain (Skala 0 -    10 )</td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;"></td>
    <td class="excel19" width="184" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['nyeri']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="2">Nilai</td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;"></td>
    <td class="excel19" colspan="2">Note  :</td>
    <td colspan="21" class="excel21"><?=$isi['nyeriisi']?></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;">6.</td>
    <td class="excel19" colspan="4">EKSUDAT <font class="font5">(Exudate)</font></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;"></td>
    <td class="excel19" width="184" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['eksudat']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="4">Tidak ada (None)</td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['eksudat']=='2'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="4">Sedikit (slight)</td>
    <td class="excel19"></td>
    <td class="excel19" width="356" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['eksudat']=='3'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="5">Sedang (Moderate)</td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['eksudat']=='4'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="4">Banyak (Heavy)</td>
    <td class="excel19"></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;">7.</td>
    <td class="excel19" colspan="7">TIPE EKSUDAT (Type of    exudate)</td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;"></td>
    <td class="excel19" width="184" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['tipeeksudat']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="2">Seruos</td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['tipeeksudat']=='2'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="3">Hemoserous</td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19" width="356" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['tipeeksudat']=='3'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="5">Darah ( Frank blood)</td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['tipeeksudat']=='4'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="4">Purulent (Pus)</td>
    <td class="excel19"></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;"></td>
    <td class="excel19" colspan="2">Note  :</td>
    <td colspan="21" class="excel21"><?=$isi['tipeeksudatisi']?></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;">8.</td>
    <td class="excel19" colspan="3">BAU (Odour)</td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;"></td>
    <td class="excel19" width="184" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['bau']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="3">Tidak  (None)</td>
    <td class="excel19"></td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['bau']=='2'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="4">Sedikit (some)</td>
    <td class="excel19"></td>
    <td class="excel19" width="356" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['bau']=='3'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="5">Sangat (Offensive)</td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;">9.</td>
    <td class="excel19" colspan="7">LABORATORIUM (Swap    Culture)</td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;"></td>
    <td class="excel19" width="184" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['lab']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="2">Ya (yes)</td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['lab']=='2'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="3">Tidak ( No )</td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19" colspan="5">Tanggal (date) <u><?=$isi['tgl_lab']?></u></td>
    <td class="excel19"></td>
    <td class="excel19" colspan="4">Hasil <u><?=$isi['hasillab']?></u></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;">10.</td>
    <td class="excel19" colspan="12">PENANGANAN LUKA    SEBELUMNYA <font class="font5">(Previos Management)</font></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;"></td>
    <td colspan="23" class="excel21"><?=$isi['penanganan']?></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;">11.</td>
    <td class="excel19" colspan="6">PENGGUNAAN ANALGESIK</td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;"></td>
    <td class="excel19" width="184" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['analgesik']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="2">Ya (yes)</td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['analgesik']=='2'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="3">Tidak ( No )</td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;">12.</td>
    <td class="excel19" colspan="11">JENIS DRESSING YANG    D)IGUNAKAN <font class="font5">(Type of Dressing)</font></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;"></td>
    <td class="excel19" width="184" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['gauze']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="2">Gauze</td>
    <td class="excel19"></td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['film']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="2">Film</td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['tullegrass']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="3">Tullegrass</td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['hydrogel']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="3">Hydrogel</td>
    <td class="excel19"></td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['silver']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="2">Silver</td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;"></td>
    <td class="excel19" width="184" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['hidrocoloid']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="3">Hidrocoloid</td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['hidrofiber']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="3">Hidrofiber</td>
    <td class="excel19"></td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['alginate']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="2">Alginate</td>
    <td class="excel19"></td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['foam']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="2">Foam</td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['lain1']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel19" colspan="4">Lain-lain  <u><?=$isi['dressingisi']?></u></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;"></td>
    <td class="excel19" colspan="2">Note :</td>
    <td colspan="21" class="excel21"><?=$isi['dressingisi2']?></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;">13.</td>
    <td class="excel19" colspan="17">TINDAKAN DAN RENCANA    PERAWATAN SELANJUTNYA <font class="font5">(Nursing intervention and plan)</font></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;"></td>
    <td colspan="23" class="excel21"><?=$isi['tindakan']?></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;"></td>
    <td class="excel20" style="border-top:none;">&nbsp;</td>
    <td class="excel20" style="border-top:none;">&nbsp;</td>
    <td class="excel20" style="border-top:none;">&nbsp;</td>
    <td class="excel20" style="border-top:none;">&nbsp;</td>
    <td class="excel20" style="border-top:none;">&nbsp;</td>
    <td class="excel20" style="border-top:none;">&nbsp;</td>
    <td class="excel20" style="border-top:none;">&nbsp;</td>
    <td class="excel20" style="border-top:none;">&nbsp;</td>
    <td class="excel20" style="border-top:none;">&nbsp;</td>
    <td class="excel20" style="border-top:none;">&nbsp;</td>
    <td class="excel20" style="border-top:none;">&nbsp;</td>
    <td class="excel20" style="border-top:none;">&nbsp;</td>
    <td class="excel20" style="border-top:none;">&nbsp;</td>
    <td class="excel20" style="border-top:none;">&nbsp;</td>
    <td class="excel20" style="border-top:none;">&nbsp;</td>
    <td class="excel20" style="border-top:none;">&nbsp;</td>
    <td class="excel20" style="border-top:none;">&nbsp;</td>
    <td class="excel20" colspan="5" style="border-top:none;">Nama &amp; TT Perawat</td>
    <td class="excel20" style="border-top:none;">&nbsp;</td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19" colspan="5">(                                    )</td>
    <td class="excel19"></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td colspan="25" class="excel38" width="670" style="height:14.1pt;width:514pt;">FORMULIR LAPORAN KEJADIAN DEKUBITUS</td>
  </tr>
  <tr style="height:14.1pt;">
    <td colspan="12" class="excel39" style="border-right:.5pt solid black;height:14.1pt;border-top:none;">IDENTITAS PASIEN</td>
    <td colspan="13" class="excel34" style="border-left:none;border-top:none;">TANGGAL</td>
  </tr>
  <tr style="height:14.1pt;">
    <td colspan="12" class="excel34" style="height:14.1pt;border-top:none;">&nbsp;</td>
    <td colspan="6" class="excel34" style="border-left:none;border-top:none;">MRS</td>
    <td colspan="7" class="excel34" style="border-left:none;border-top:none;">Kejadian</td>
  </tr>
  <tr style="height:14.1pt;">
    <td colspan="12" class="excel34" style="height:14.1pt;border-top:none;">&nbsp;</td>
    <td colspan="6" class="excel34" style="border-left:none;border-top:none;">&nbsp;</td>
    <td colspan="7" class="excel34" style="border-left:none;border-top:none;">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel24" style="height:14.1pt;"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel29">&nbsp;</td>
    <td colspan="6" class="excel34" style="border-left:none;border-top:none;">Diagnosa Medis</td>
    <td colspan="7" class="excel34" style="border-left:none;border-top:none;">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel24" style="height:14.1pt;"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel29">&nbsp;</td>
    <td class="excel24" colspan="4">Braden Score MRS</td>
    <td class="excel24"></td>
    <td class="excel24" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['braden']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel24">&gt; 18</td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['braden']=='3'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel33">12-14</td>
    <td class="excel24"></td>
    <td class="excel24"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel24" style="height:14.1pt;"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel29">&nbsp;</td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['braden']=='2'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel24" colspan="2">15-18</td>
    <td class="excel24"></td>
    <td class="excel24" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['braden']=='4'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel24">&lt;11</td>
    <td class="excel24"></td>
    <td class="excel24"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel24" style="height:14.1pt;"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel29">&nbsp;</td>
    <td colspan="7" class="excel35" style="border-left:none;border-bottom:none;">Braden Score Saat Ditemukan</td>
    <td class="excel31" colspan="6" style="border-bottom:none;">_________________________</td>
  </tr>
  <tr style="height:14.1pt;">
    <td colspan="19" class="excel34" style="height:14.1pt;">AREA DEKUBITUS</td>
    <td colspan="6" class="excel34" style="border-left:none;">STADIUM DEKUBITUS</td>
  </tr>
  <tr style="height:14.1pt;">
    <td style="height:14.1pt;" align="left" ><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['sacrum']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel26" colspan="2" style="border-top:none;">Sacrum</td>
    <td class="excel26" style="border-top:none;">&nbsp;</td>
    <td class="excel26" style="border-top:none;">&nbsp;</td>
    <td class="excel26" width="26" style="height:14.1pt;border-top:none;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['throchanter']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel26" colspan="5" style="border-top:none;">Throchanter Mayor (D)</td>
    <td class="excel26" style="border-top:none;">&nbsp;</td>
    <td class="excel26" width="356" style="height:14.1pt;border-top:none;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['auriculas']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel26" colspan="3" style="border-top:none;">Auricula (S)</td>
    <td class="excel26" style="border-top:none;">&nbsp;</td>
    <td class="excel26" style="border-top:none;">&nbsp;</td>
    <td class="excel26" style="border-top:none;">&nbsp;</td>
    <td class="excel26" width="26" style="height:14.1pt;border-top:none;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['stadium']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel26" colspan="3" style="border-top:none;">Stadium I</td>
    <td class="excel26" style="border-top:none;">&nbsp;</td>
    <td class="excel27" style="border-top:none;">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td style="height:14.1pt;" align="left" ><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['heeld']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel24" colspan="2">Heel (D)</td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['throchaler']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel24" colspan="5">Throchaler Mayor (S)</td>
    <td class="excel24"></td>
    <td class="excel24" width="356" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['malelolusd']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel24" colspan="4">Malelolus (D)</td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['stadium']=='2'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel24" colspan="3">Stadium II</td>
    <td class="excel24"></td>
    <td class="excel29">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td style="height:14.1pt;" align="left" ><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['heels']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel24" colspan="2">Heel (S)</td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['throchaterd']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel24" colspan="5">Throchater Minor (D)</td>
    <td class="excel24"></td>
    <td class="excel24" width="356" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['maleoluss']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel24" colspan="3">Maleolus (S)</td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['stadium']=='3'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel24" colspan="3">Stadium III</td>
    <td class="excel24"></td>
    <td class="excel29">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td style="height:14.1pt;" align="left" ><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['occipitalis']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel24" colspan="3">Occipitalis</td>
    <td class="excel24"></td>
    <td class="excel24" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['throchaters']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel24" colspan="5">Throchater Minor (S)</td>
    <td class="excel24"></td>
    <td class="excel24" width="356" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['lain2']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel24" colspan="4">Lain-lain <u><?=$isi['dekubitusisi']?></u></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['stadium']=='4'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel24" colspan="3">Stadium IV</td>
    <td class="excel24"></td>
    <td class="excel29">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel30" style="height:14.1pt;">&nbsp;</td>
    <td class="excel31">&nbsp;</td>
    <td class="excel31">&nbsp;</td>
    <td class="excel31">&nbsp;</td>
    <td class="excel31">&nbsp;</td>
    <td class="excel31" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['auriculad']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel31" colspan="3">Auricula (D)</td>
    <td class="excel31">&nbsp;</td>
    <td class="excel31">&nbsp;</td>
    <td class="excel31">&nbsp;</td>
    <td class="excel31">&nbsp;</td>
    <td class="excel31">&nbsp;</td>
    <td class="excel31">&nbsp;</td>
    <td class="excel31">&nbsp;</td>
    <td class="excel31">&nbsp;</td>
    <td class="excel31">&nbsp;</td>
    <td class="excel31">&nbsp;</td>
    <td class="excel31" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['stadium']=='5'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel31" colspan="5" style="border-right:.5pt solid black;">Stadium    tidak terukur</td>
  </tr>
  <tr style="height:14.1pt;">
    <td colspan="25" class="excel37" style="height:14.1pt;border-top:none;">FAKTOR PEMICU</td>
  </tr>
  <tr style="height:14.1pt;">
    <td colspan="12" class="excel34" style="height:14.1pt;border-top:none;">Persepsi Sensori</td>
    <td colspan="13" class="excel34" style="border-left:none;border-top:none;">Mobilitas</td>
  </tr>
  <tr style="height:14.1pt;">
    <td style="height:14.1pt;" align="left" valign="top"><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['persepsi']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel26" colspan="9" style="border-top:none;">Tidak memberi resppon    terhadap nyeri</td>
    <td class="excel26" style="border-top:none;">&nbsp;</td>
    <td class="excel27" style="border-top:none;">&nbsp;</td>
    <td class="excel25" width="356" style="height:14.1pt;border-top:none;border-left:none;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['mobilitas']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel26" colspan="5" style="border-top:none;">Tidak bisa bergerak</td>
    <td class="excel26" style="border-top:none;">&nbsp;</td>
    <td class="excel26" style="border-top:none;">&nbsp;</td>
    <td class="excel26" style="border-top:none;">&nbsp;</td>
    <td class="excel26" style="border-top:none;">&nbsp;</td>
    <td class="excel26" style="border-top:none;">&nbsp;</td>
    <td class="excel26" style="border-top:none;">&nbsp;</td>
    <td class="excel27" style="border-top:none;">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td style="height:14.1pt;" align="left" valign="top"><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['persepsi']=='2'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel24" colspan="8">Merespon dengan    merintih/gelisah</td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel29">&nbsp;</td>
    <td class="excel28" width="356" style="height:14.1pt;border-left:none;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['mobilitas']=='2'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel24" colspan="6">Pergerakan sangat    terbatas</td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel29">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td style="height:14.1pt;" align="left" valign="top"><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['persepsi']=='3'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel24" colspan="7">Mampu merespon secara    verbal</td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel29">&nbsp;</td>
    <td class="excel28" width="356" style="height:14.1pt;border-left:none;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['mobilitas']=='3'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel24" colspan="6">Pergerakan sedikit    terbatas</td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel29">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel30" style="height:14.1pt;" align="left" valign="top"><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['persepsi']=='4'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel31" colspan="7">Tidak ada gangguan    sensori</td>
    <td class="excel31">&nbsp;</td>
    <td class="excel31">&nbsp;</td>
    <td class="excel31">&nbsp;</td>
    <td class="excel32">&nbsp;</td>
    <td class="excel30" width="356" style="height:14.1pt;border-left:none;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['mobilitas']=='4'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel31" colspan="8">tidak ada batasan dalam    bergerak</td>
    <td class="excel31">&nbsp;</td>
    <td class="excel31">&nbsp;</td>
    <td class="excel31">&nbsp;</td>
    <td class="excel32">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td colspan="12" class="excel52" width="670" style="height:14.1pt;width:241pt;border-top:none;">Kelembaban</td>
    <td colspan="13" class="excel52" width="356" style="border-left:none;width:273pt;border-top:none;">Nutrisi</td>
  </tr>
  <tr style="height:14.1pt;">
    <td style="height:14.1pt;" align="left" valign="top"><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['kelembaban']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel42" colspan="4" style="border-top:none;">Selalu lembab</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel43" style="border-top:none;">&nbsp;</td>
    <td class="excel41" width="356" style="height:14.1pt;border-top:none;border-left:none;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['nutrisi']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel42" colspan="11" style="border-top:none;">Sangat buruk (makan    &lt;1/2 porsi, puasa / infus &gt; 5 hr)</td>
    <td class="excel43" style="border-top:none;">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td style="height:14.1pt;" align="left" valign="top"><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['kelembaban']=='2'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel40" colspan="4">Sering lembab</td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel45">&nbsp;</td>
    <td class="excel44" width="356" style="height:14.1pt;border-left:none;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['nutrisi']=='2'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel40" colspan="7">Tidak adekuat (makan 1/2    porsi)</td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel45">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td style="height:14.1pt;" align="left" valign="top"><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['kelembaban']=='3'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel40" colspan="5">Terkadang lembab</td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel45">&nbsp;</td>
    <td class="excel44" width="356" style="height:14.1pt;border-left:none;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['nutrisi']=='3'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel40" colspan="7">Adekuat (makan 3/4 porsi,    TPN)</td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel45">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel30" style="height:14.1pt;" align="left" valign="top"><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['kelembaban']=='4'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel47" colspan="4">Jarang lembab</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel48">&nbsp;</td>
    <td class="excel46" width="356" style="height:14.1pt;border-left:none;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['nutrisi']=='4'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel47" colspan="10">Baik (menghabiskan    makanan yang disajikan)</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel48">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td colspan="12" class="excel53" style="height:14.1pt;border-top:none;">Aktifitas</td>
    <td colspan="13" class="excel54" style="border-right:.5pt solid black;border-top:none;">Gesekan</td>
  </tr>
  <tr style="height:14.1pt;">
    <td style="height:14.1pt;" align="left" valign="top"><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['aktifitas']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel42" colspan="3" style="border-top:none;">Baring total</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel43" style="border-top:none;">&nbsp;</td>
    <td class="excel41" width="356" style="height:14.1pt;border-top:none;border-left:none;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['gesekan']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel42" colspan="6" style="border-top:none;">Gesekan terus menerus</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel43" style="border-top:none;">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td style="height:14.1pt;" align="left" valign="top"><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['aktifitas']=='2'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel40" colspan="11" style="border-right:.5pt solid black;">Mampu    duduk - perlu bantuan untuk menumpu</td>
    <td class="excel44" width="356" style="height:14.1pt;border-left:none;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['gesekan']=='2'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel40" colspan="6">Kadang terjadi gesekan</td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel45">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td style="height:14.1pt;" align="left" valign="top"><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['aktifitas']=='3'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel40" colspan="10">Kadang berjalan -    sebagai besar berbaring</td>
    <td class="excel45">&nbsp;</td>
    <td class="excel44" width="356" style="height:14.1pt;border-left:none;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['gesekan']=='3'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel40" colspan="7">Dapat bergerak/tanpa    gesekan</td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel45">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel30" style="height:14.1pt;" align="left" valign="top"><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['aktifitas']=='4'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel47" colspan="6">Berjalan secara berkala</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel48">&nbsp;</td>
    <td class="excel46" style="border-left:none;">&nbsp;</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel48">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td colspan="15" class="excel52" style="height:14.1pt;border-top:none;">TINDAKAN YANG SUDAH    DILAKUKAN</td>
    <td colspan="10" class="excel52" style="border-left:none;border-top:none;;">TINDAKAN LAIN</td>
  </tr>
  <tr style="height:14.1pt;">
    <td colspan="8" class="excel52" style="height:14.1pt;border-top:none;">Pengguna Penunjang</td>
    <td colspan="7" class="excel52" style="border-left:none;border-top:none;">Peralihan Posisi</td>
    <td colspan="10" class="excel52" style="border-left:none;border-top:none;">Memberitahu dokter yang    merawat</td>
  </tr>
  <tr style="height:14.1pt;">
    <td style="height:14.1pt;" align="left" valign="top"><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['mastatis']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel42" colspan="5" style="border-top:none;">Matras angin statis</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel43" style="border-top:none;">&nbsp;</td>
    <td class="excel41" width="26" style="height:14.1pt;border-top:none;border-left:none;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['posisi']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel42" colspan="3" style="border-top:none;">Setiap 2 jam</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel43" style="border-top:none;">&nbsp;</td>
    <td class="excel50" style="border-top:none;border-left:none;">&nbsp;</td>
    <td class="excel49" width="26" style="height:14.1pt;border-top:none;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['beritahu']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel49" style="border-top:none;">Ya</td>
    <td class="excel49" style="border-top:none;">&nbsp;</td>
    <td class="excel49" style="border-top:none;">&nbsp;</td>
    <td class="excel49" width="26" style="height:14.1pt;border-top:none;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['beritahu']=='2'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel49" colspan="2" style="border-top:none;">Tidak</td>
    <td class="excel49" style="border-top:none;">&nbsp;</td>
    <td class="excel51" style="border-top:none;">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td style="height:14.1pt;" align="left" valign="top"><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['madinamik']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel40" colspan="5">Matras angin dinamik</td>
    <td class="excel40"></td>
    <td class="excel45">&nbsp;</td>
    <td class="excel44" width="26" style="height:14.1pt;border-left:none;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['posisi']=='2'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel40" colspan="3">&gt; dari 2 jam</td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel45">&nbsp;</td>
    <td colspan="10" class="excel53" style="border-right:.5pt solid black;border-left:none;border-top:none;">Menghubungi Perawat Luka</td>
  </tr>
  <tr style="height:14.1pt;">
    <td style="height:14.1pt;" align="left" valign="top"><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['bantal']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel40" colspan="7" style="border-right:.5pt solid black;">Bantal    penopang tambahan</td>
    <td class="excel44" width="26" style="height:14.1pt;border-left:none;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['posisi']=='3'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel40" colspan="4">Tidak dilakukan</td>
    <td class="excel40"></td>
    <td class="excel45">&nbsp;</td>
    <td class="excel50" style="border-top:none;border-left:none;">&nbsp;</td>
    <td class="excel49" width="26" style="height:14.1pt;border-top:none;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['hubungi']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel49" style="border-top:none;">Ya</td>
    <td class="excel49" style="border-top:none;">&nbsp;</td>
    <td class="excel49" style="border-top:none;">&nbsp;</td>
    <td class="excel49" width="26" style="height:14.1pt;border-top:none;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['hubungi']=='2'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel49" colspan="2" style="border-top:none;">Tidak</td>
    <td class="excel49" style="border-top:none;">&nbsp;</td>
    <td class="excel51" style="border-top:none;">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td style="height:14.1pt;" align="left" valign="top"><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['lain3']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel40" colspan="4">Lain - lain <u><?=$isi['penunjangisi']?></u></td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel45">&nbsp;</td>
    <td class="excel44" style="border-left:none;">&nbsp;</td>
    <td class="excel40" colspan="4">Alasan <u><?=$isi['posisiisi']?></u></td>
    <td class="excel40"></td>
    <td class="excel45">&nbsp;</td>
    <td colspan="10" class="excel53" style="border-right:.5pt solid black;border-left:none;border-top:none;">Pengkajian oleh Perawat Luka</td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel46" style="height:14.1pt;">&nbsp;</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel48">&nbsp;</td>
    <td class="excel46" style="border-left:none;">&nbsp;</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel48">&nbsp;</td>
    <td class="excel50" style="border-top:none;border-left:none;">&nbsp;</td>
    <td class="excel49" width="26" style="height:14.1pt;border-top:none;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['kajian']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel49" style="border-top:none;">Ya</td>
    <td class="excel49" style="border-top:none;">&nbsp;</td>
    <td class="excel49" style="border-top:none;">&nbsp;</td>
    <td class="excel49" width="26" style="height:14.1pt;border-top:none;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:13px; vertical-align:middle; text-align:center;"><?php if($isi['kajian']=='2'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel49" colspan="2" style="border-top:none;">Tidak</td>
    <td class="excel49" style="border-top:none;">&nbsp;</td>
    <td class="excel51" style="border-top:none;">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td colspan="25" class="excel67" width="670" style="height:14.1pt;width:514pt;border-top:none;">HASIL PEMERIKSAAN</td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel56" style="height:14.1pt;"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel56" style="height:14.1pt;"></td>
    <td class="excel56" width="184" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['albumin']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel56" colspan="2">Albumin</td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['hb']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel56">Hb</td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['suhu']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel56" colspan="2">Suhu</td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['td']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel56">TD</td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56" width="26" style="height:14.1pt;width:20pt;"><div style="padding:1px; border:1px #000 solid; width:10px; height:10px; vertical-align:middle; text-align:center;"><?php if($isi['lain4']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
    <td class="excel56" colspan="2">Lain-lain</td>
    <td class="excel56"></td>
    <td class="excel56"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td colspan="25" class="excel67" style="height:14.1pt;">DESKRIPSI KEJADIAN</td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel60" style="height:14.1pt;border-top:none;border-bottom:none;">&nbsp;</td>
    <td colspan="23" class="excel60" style="border-top:none;"><?=$isi['deskripsi']?></td>
    <td class="excel60" style="border-top:none;border-bottom:none;">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel60" style="height:14.1pt;border-top:none;">&nbsp;</td>
    <td class="excel60" style="border-top:none;">&nbsp;</td>
    <td class="excel60" style="border-top:none;">&nbsp;</td>
    <td class="excel60" style="border-top:none;">&nbsp;</td>
    <td class="excel60" style="border-top:none;">&nbsp;</td>
    <td class="excel60" style="border-top:none;">&nbsp;</td>
    <td class="excel60" style="border-top:none;">&nbsp;</td>
    <td class="excel60" style="border-top:none;">&nbsp;</td>
    <td class="excel60" style="border-top:none;">&nbsp;</td>
    <td class="excel60" style="border-top:none;">&nbsp;</td>
    <td class="excel60" style="border-top:none;">&nbsp;</td>
    <td class="excel60" style="border-top:none;">&nbsp;</td>
    <td class="excel60" style="border-top:none;">&nbsp;</td>
    <td class="excel60" style="border-top:none;">&nbsp;</td>
    <td class="excel60" style="border-top:none;">&nbsp;</td>
    <td class="excel60" style="border-top:none;">&nbsp;</td>
    <td class="excel60" style="border-top:none;">&nbsp;</td>
    <td class="excel60" style="border-top:none;">&nbsp;</td>
    <td class="excel60" style="border-top:none;">&nbsp;</td>
    <td class="excel60" style="border-top:none;">&nbsp;</td>
    <td class="excel60" style="border-top:none;">&nbsp;</td>
    <td class="excel60" style="border-top:none;">&nbsp;</td>
    <td class="excel60" style="border-top:none;">&nbsp;</td>
    <td class="excel60" style="border-top:none;">&nbsp;</td>
    <td class="excel60" style="border-top:none;">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td colspan="12" class="excel68" style="border-right:.5pt solid black;height:14.1pt;border-top:none;">Pembuat Laporan</td>
    <td colspan="13" class="excel68" style="border-right:.5pt solid black;border-left:none;border-top:none;">Mengetahui,</td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel57" style="height:14.1pt;">&nbsp;</td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel58">&nbsp;</td>
    <td colspan="13" class="excel61" style="border-right:.5pt solid black;border-left:none;">Head Unit</td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel57" style="height:14.1pt;">&nbsp;</td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel58">&nbsp;</td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel58">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel57" style="height:14.1pt;">&nbsp;</td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel58">&nbsp;</td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel58">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td colspan="12" class="excel57" style="border-right:.5pt solid black;height:14.1pt;" align="center">(<strong><u><?php echo $usr['nama'];?></u></strong>)</td>
    <td colspan="13" class="excel56" style="border-right:.5pt solid black;height:14.1pt;" align="center">(<strong><u><?php echo $usr['nama'];?></u></strong>)</td>
    </tr>
  <tr style="height:14.1pt;">
    <td colspan="12" class="excel64" style="border-right:.5pt solid black;height:14.1pt;">( Nama &amp; Tanda tangan)</td>
    <td colspan="12" class="excel64" style="border-left:none;">( Nama &amp; Tanda tangan)</td>
    <td class="excel59">&nbsp;</td>
  </tr>
</table>
    </td>
  </tr>
  <tr id="trTombol">
        <td colspan="2" class="noline" align="center">
                    
                    <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));" />
              <input id="btnTutup" type="button" value="Tutup" onClick="tutup();"/>
                </td>
        </tr>
</table>
</body>
<script type="text/JavaScript">

            function cetak(tombol){
                tombol.style.visibility='collapse';
                if(tombol.style.visibility=='collapse'){
                    if(confirm('Anda Yakin Mau Laporan ini ?')){
                        setTimeout('window.print()','1000');
                        setTimeout('window.close()','2000');
                    }
                    else{
                        tombol.style.visibility='visible';
                    }

                }
            }
			
function liat(){
		window.open("surat_ket_periksa_mata_view.php?id=<?=$idx?>&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idUser=<?=$idUser?>","_blank");
	}
function tutup(){
	window.close();
	}
        </script>
</html>