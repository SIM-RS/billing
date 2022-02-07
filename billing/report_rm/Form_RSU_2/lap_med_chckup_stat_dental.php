<?php
session_start();
include '../../koneksi/konek.php';
$idPel=$_REQUEST['idPel'];
$idKunj=$_REQUEST['idKunj'];
$idUser=$_REQUEST['idUser'];
$idPasien=$_REQUEST['idPasien'];
$id=$_REQUEST['id'];

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
  k.id,
  p.id,
  DATE_FORMAT(CURDATE(), '%d %M %Y') AS tgl1,
  bpek.nama AS kerjaan,
  DATE_FORMAT(p.tgl_act, '%d %M %Y') tglawal,
  DATE_FORMAT(p.tgl_act, '%H:%i') jamawal,
  DATE_FORMAT(bkel.tgl_act, '%d %M %Y') tglmati,
  DATE_FORMAT(bkel.tgl_act, '%H:%i') jammati,
  peg3.nama dktrmati,
  bagm.agama,
  bmk.nama kelas,
  mp.no_ktp,
  mp.telp,
  z.*, k.no_reg
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
  LEFT JOIN b_lap_med_cekup_stat_dental z
    ON z.pelayanan_id = p.id
WHERE z.dental_id='$id' AND k.id='$idKunj' AND p.id='$idPel'";

//echo $sqlPas."<br>";
$rs1 = mysql_query($sqlPas);
//echo mysql_error();
$isi = mysql_fetch_array($rs1);

if(isset($_POST['idPel'])){
	$idPel=$_POST['idPel'];
	$idKunj=$_POST['idKunj'];
	$idUser=$_POST['idUser'];
	
	
		$sql="";
		$ex=mysql_query($sql);
		$idx=mysql_insert_id();
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Laporan Medical Check Up Status Dental :.</title>
</head>
<style>

.bwh{
	border-bottom:1px solid #000000;
}


</style>
<body>
<table width="200" border="0">
  <tr>
    <td><table cellspacing="0" cellpadding="0">
      <col width="72" />
      <col width="46" />
      <col width="126" />
      <col width="17" />
      <col width="64" span="5" />
      <col width="79" />
      <tr>
        <td width="72" align="left" valign="top"><img src="lap_med_chckup_stat_bdh_wnta_clip_image003.png" alt="" width="350" height="105" />
          <table cellpadding="0" cellspacing="0">
            <tr>
              <td width="72"></td>
            </tr>
          </table></td>
        <td colspan="9"><table width="316" border="0" style="font:12px tahoma; border:1px solid #000;">
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
            <td><?php echo $isi['no_rm'];?>&nbsp;No.Registrasi:&nbsp;<?php echo $isi['no_reg'];?></td>
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
        <td></td>
        <td width="46"></td>
        <td width="126"></td>
        <td width="17"></td>
        <td width="64"></td>
        <td width="64"></td>
        <td width="64"></td>
        <td width="64"></td>
        <td width="64"></td>
        <td width="79"></td>
      </tr>
      <tr>
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
      <tr>
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
      <tr>
        <td colspan="6"><b>LAPORAN MEDICAL CHECK UP STATUS DENTAL</b></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
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
    </table></td>
  </tr>
  <tr>
    <td><table cellspacing="0" cellpadding="0" style="font:12px tahoma; border:1px solid #000;">
      <col width="22" />
      <col width="37" span="18" />
      <tr>
        <td width="29">&nbsp;</td>
        <td colspan="3">ANAMNESA</td>
        <td width="40"></td>
        <td width="32"></td>
        <td width="32"></td>
        <td width="32"></td>
        <td width="32"></td>
        <td width="32"></td>
        <td width="33"></td>
        <td width="33"></td>
        <td width="33"></td>
        <td width="33"></td>
        <td width="33"></td>
        <td width="33"></td>
        <td width="32"></td>
        <td width="32"></td>
        <td width="46">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">Keluhan</td>
        <td width="40"></td>
        <td align="right">:</td>
        <td colspan="13" class="bwh"><?=$isi['keluhan']?></td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <td width="43"></td>
        <td></td>
        <td></td>
        <td colspan="13">&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">PEMERIKSAAN</td>
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
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
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
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr align="center">
        <td>&nbsp;</td>
        <td>8</td>
        <td>7</td>
        <td>6</td>
        <td>5</td>
        <td>4</td>
        <td>3</td>
        <td>2</td>
        <td>1</td>
        <td></td>
        <td>1</td>
        <td>2</td>
        <td>3</td>
        <td>4</td>
        <td>5</td>
        <td>6</td>
        <td>7</td>
        <td>8</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
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
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr align="center">
        <td rowspan="2" width="29">R</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>V</td>
        <td>IV</td>
        <td>III</td>
        <td>II</td>
        <td>I</td>
        <td></td>
        <td>I</td>
        <td>II</td>
        <td>III</td>
        <td>IV</td>
        <td>V</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td rowspan="2" width="46">L</td>
      </tr>
      <tr align="center">
        <td style="border-top:.5pt solid black;"></td>
        <td style="border-top:.5pt solid black;"></td>
        <td style="border-top:.5pt solid black;"></td>
        <td style="border-top:.5pt solid black;">V</td>
        <td style="border-top:.5pt solid black;">IV</td>
        <td style="border-top:.5pt solid black;">III</td>
        <td style="border-top:.5pt solid black;">II</td>
        <td style="border-top:.5pt solid black;">I</td>
        <td></td>
        <td style="border-top:.5pt solid black;">I</td>
        <td style="border-top:.5pt solid black;">II</td>
        <td style="border-top:.5pt solid black;">III</td>
        <td style="border-top:.5pt solid black;">IV</td>
        <td style="border-top:.5pt solid black;">V</td>
        <td style="border-top:.5pt solid black;"></td>
        <td style="border-top:.5pt solid black;"></td>
        <td style="border-top:.5pt solid black;"></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
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
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr align="center">
        <td>&nbsp;</td>
        <td>8</td>
        <td>7</td>
        <td>6</td>
        <td>5</td>
        <td>4</td>
        <td>3</td>
        <td>2</td>
        <td>1</td>
        <td></td>
        <td>1</td>
        <td>2</td>
        <td>3</td>
        <td>4</td>
        <td>5</td>
        <td>6</td>
        <td>7</td>
        <td>8</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
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
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="46" align="right"><div style="padding:1px; border:1px #000 solid; width:19px; height:21px; vertical-align:middle; text-align:center;"><?php if($isi['caries1']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td colspan="2">Caries</td>
        <td></td>
        <td colspan="13" class="bwh"><?=$isi['caries']?></td>
        <td ></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="46" align="right"><div style="padding:1px; border:1px #000 solid; width:19px; height:21px; vertical-align:middle; text-align:center;"><?php if($isi['filling1']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td colspan="2">Filling</td>
        <td></td>
        <td colspan="13" class="bwh"><?=$isi['filling']?></td>
        <td ></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="46" align="right"><div style="padding:1px; border:1px #000 solid; width:19px; height:21px; vertical-align:middle; text-align:center;"><?php if($isi['root1']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td colspan="3">Root / Radix</td>
        <td colspan="13" class="bwh"><?=$isi['root']?></td>
        <td ></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="46" align="right"><div style="padding:1px; border:1px #000 solid; width:19px; height:21px; vertical-align:middle; text-align:center;"><?php if($isi['missing1']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td colspan="3">Missing Tooth</td>
        <td colspan="13" class="bwh"><?=$isi['missing']?></td>
        <td ></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="46" align="right"><div style="padding:1px; border:1px #000 solid; width:19px; height:21px; vertical-align:middle; text-align:center;"><?php if($isi['crown1']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td colspan="3">Crown / Casting</td>
        <td colspan="13" class="bwh"><?=$isi['crown']?></td>
        <td ></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="46" align="right"><div style="padding:1px; border:1px #000 solid; width:19px; height:21px; vertical-align:middle; text-align:center;"><?php if($isi['bridge1']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td colspan="3">Bridge Work </td>
        <td colspan="13" class="bwh"><?=$isi['bridge']?></td>
        <td ></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="46" align="right"><div style="padding:1px; border:1px #000 solid; width:19px; height:21px; vertical-align:middle; text-align:center;"><?php if($isi['dentures1']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td colspan="2">Dentures</td>
        <td></td>
        <td colspan="13" class="bwh"><?=$isi['dentures']?></td>
        <td ></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="46" align="right"><div style="padding:1px; border:1px #000 solid; width:19px; height:21px; vertical-align:middle; text-align:center;"><?php if($isi['malloclusion1']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td colspan="3">Malloclusion</td>
        <td colspan="13" class="bwh"><?=$isi['malloclusion']?></td>
        <td ></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="46" align="right"><div style="padding:1px; border:1px #000 solid; width:19px; height:21px; vertical-align:middle; text-align:center;"><?php if($isi['lack1']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td colspan="3">Lack Of Contact</td>
        <td colspan="13" class="bwh"><?=$isi['lack']?></td>
        <td ></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="46" align="right"><div style="padding:1px; border:1px #000 solid; width:19px; height:21px; vertical-align:middle; text-align:center;"><?php if($isi['calculus1']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td colspan="2">Calculus</td>
        <td></td>
        <td colspan="13" class="bwh"><?=$isi['calculus']?></td>
        <td></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="46" align="right"><div style="padding:1px; border:1px #000 solid; width:19px; height:21px; vertical-align:middle; text-align:center;"><?php if($isi['endontolous1']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td colspan="3">Endontolous</td>
        <td colspan="13" class="bwh"><?=$isi['endontolous']?></td>
        <td ></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="46" align="right"><div style="padding:1px; border:1px #000 solid; width:19px; height:21px; vertical-align:middle; text-align:center;"><?php if($isi['mobility1']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td colspan="2">Mobility</td>
        <td></td>
        <td colspan="13" class="bwh"><?=$isi['mobility']?></td>
        <td ></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="46" align="right"><div style="padding:1px; border:1px #000 solid; width:19px; height:21px; vertical-align:middle; text-align:center;"><?php if($isi['others1']=='1'){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td colspan="2">Others</td>
        <td></td>
        <td colspan="13" class="bwh"><?=$isi['others']?></td>
        <td></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
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
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">DIAGNOSA</td>
        <td>:</td>
        <td colspan="14" class="bwh"><?php 
		$sqlD="SELECT GROUP_CONCAT(md.nama) diagnosa FROM b_diagnosa d
LEFT JOIN b_ms_diagnosa md ON md.id=d.ms_diagnosa_id
LEFT JOIN b_kunjungan k ON k.id=d.kunjungan_id
WHERE d.pelayanan_id='$idPel';";
$exD=mysql_fetch_array(mysql_query($sqlD));
		echo $exD['diagnosa'];?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">ANJURAN</td>
        <td>:</td>
        <td colspan="14" class="bwh"><?=$isi['anjuran']?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
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
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
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
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="8">Tanggal/Date  :<?=tgl_ina(date('Y-m-d'));?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="8">Pukul/Time     : <?=date('H:i:s');?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5">Dokter yang memeriksa,</td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
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
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
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
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
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
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
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
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="6">(<strong><u><?php echo $usr['nama'];?></u></strong>)</td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5">Nama &amp; Tanda Tangan</td>
        <td></td>
        <td></td>
        <td></td>
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
    </table></td>
  </tr>
  <tr id="trTombol">
        <td class="noline" align="center">
                    
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
                    if(confirm('Anda Yakin Mau Mencetak Laporan Medical Check Up Status Dental ?')){
                        setTimeout('window.print()','1000');
                        setTimeout('window.close()','2000');
                    }
                    else{
                        tombol.style.visibility='visible';
                    }

                }
            }
			
function tutup(){
	window.close();
	}
        </script>
</html>