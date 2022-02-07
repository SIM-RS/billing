<?php
//session_start();
include("../../sesi.php");
?>
<?php
//session_start();
include("../../koneksi/konek.php");
$user_id=$_SESSION['userId'];
$unit_id=$_SESSION['unitId'];
$idPasien=$_REQUEST['idPasien'];
$idPel=$_REQUEST['idPel'];
$idKunj=$_REQUEST['idKunj'];
$idUser=$_REQUEST['idUsr'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,kk.no_reg as no_reg2
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_kunjungan kk ON kk.id=pl.kunjungan_id
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));


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
  bmk.nama kelas
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
WHERE k.id='$idKunj' AND p.id='$idPel'";

//echo $sqlPas."<br>";
$rs1 = mysql_query($sqlPas);
//echo mysql_error();
$isi = mysql_fetch_array($rs1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" rel="stylesheet" href="../../theme/mod.css" />
        <link type="text/css" rel="stylesheet" href="eksel.css" />
        <script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../../theme/js/dsgrid.js"></script>

        <!-- untuk ajax-->
        <script type="text/javascript" src="../../theme/js/ajax.js"></script>
        <script type="text/javascript" src="../../jquery.js"></script>
        <script type="text/javascript" src="../../jquery.form.js"></script>
    <!-- untuk ajax-->

		<script type="text/JavaScript">
            var arrRange = depRange = [];
        </script>

        <title>.: Laporan Medical Check Up Status Dental :.</title>
        <style>
.inputan{
	width:715px;
	font:10 tahoma;
	}
.textArea{ width:750px;}
body{background:#FFF;}
        </style>
    </head>

    <body>
        <div align="center">
            <?php
            //include("../../header1.php");
            ?>
        </div>

        <iframe height="72" width="130" name="sort"
                id="sort"
                src="../../theme/dsgrid_sort.php" scrolling="no"
                frameborder="0"
                style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
        </iframe>
        
        <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js" src="../../theme/popcjs.php" scrolling="no" frameborder="1"
                style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
        </iframe>

        <!-- div tindakan-->
        <div align="center" id="div_tindakan">
    <!--        <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
                <tr>
                    <td height="30">SURAT KETERANGAN PEMERIKSAAN MATA</td>
                </tr>
            </table>-->
            <table width="1000" border="0" cellspacing="1" cellpadding="0" align="center" >
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="3" align="center"><div id="metu" style="display:none;">
                    <form id="form1" name="form1" action="lbr_pengkajian_luka_utils.php" method="post">
    <input type="hidden" name="idPel" value="<?=$idPel?>" />
    <input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    <input type="hidden" name="idUser" value="<?=$idUser?>" />
    <input type="hidden" name="idPasien" value="<?=$idPasien?>" />
    <input type="hidden" name="txtId" id="txtId"/>
    <input type="hidden" name="act" id="act" value="tambah"/><table border="0">
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
    <td class="excel3" width="26" style="width:20pt;"><?php echo tgl_ina(date("Y-m-d"))?></td>
    <td class="excel3" width="26" style="width:20pt;">&nbsp;</td>
    <td class="excel3" width="26" style="width:20pt;">&nbsp;</td>
    <td class="excel3" width="356" style="width:20pt;">&nbsp;</td>
    <td class="excel3" width="26" style="width:20pt;">&nbsp;</td>
    <td class="excel3" width="26" style="width:20pt;">&nbsp;</td>
    <td class="excel3" width="26" style="width:20pt;">&nbsp;</td>
    <td class="excel3" width="26" style="width:20pt;">&nbsp;</td>
    <td class="excel3" width="26" style="width:20pt;">&nbsp;</td>
    <td class="excel3" width="26" style="width:20pt;">&nbsp;</td>
    <td class="excel3" width="26" style="width:20pt;">&nbsp;</td>
    <td class="excel3" width="26" style="width:20pt;">&nbsp;</td>
    <td class="excel3" width="26" style="width:20pt;">&nbsp;</td>
    <td class="excel3" width="44" style="width:33pt;">&nbsp;</td>
    <td class="excel3" width="26" style="width:20pt;">&nbsp;</td>
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
    <td class="excel5" style="border-top:none;"><?php 
		$sqlD="SELECT GROUP_CONCAT(md.nama) diagnosa FROM b_diagnosa d
LEFT JOIN b_ms_diagnosa md ON md.id=d.ms_diagnosa_id
LEFT JOIN b_kunjungan k ON k.id=d.kunjungan_id
WHERE d.pelayanan_id='$idPel';";
$exD=mysql_fetch_array(mysql_query($sqlD));
		echo $exD['diagnosa'];?></td>
    <td class="excel5" style="border-top:none;">&nbsp;</td>
    <td class="excel5" style="border-top:none;">&nbsp;</td>
    <td class="excel5" style="border-top:none;">&nbsp;</td>
    <td class="excel5" style="border-top:none;">&nbsp;</td>
    <td class="excel5" style="border-top:none;">&nbsp;</td>
    <td class="excel5" style="border-top:none;">&nbsp;</td>
    <td class="excel5" style="border-top:none;">&nbsp;</td>
    <td class="excel5" style="border-top:none;">&nbsp;</td>
    <td class="excel5" style="border-top:none;">&nbsp;</td>
    <td class="excel5" style="border-top:none;">&nbsp;</td>
    <td class="excel5" style="border-top:none;">&nbsp;</td>
    <td class="excel5" style="border-top:none;">&nbsp;</td>
    <td class="excel5" style="border-top:none;">&nbsp;</td>
    <td class="excel5" style="border-top:none;">&nbsp;</td>
    <td class="excel2"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel2" colspan="7" style="height:14.1pt;">Nama    dokter yang merawat </td>
    <td class="excel2"></td>
    <td class="excel2">:</td>
    <td class="excel5" style="border-top:none;"><?php echo $isi['dokter'];?></td>
    <td class="excel5" style="border-top:none;">&nbsp;</td>
    <td class="excel5" style="border-top:none;">&nbsp;</td>
    <td class="excel5" style="border-top:none;">&nbsp;</td>
    <td class="excel5" style="border-top:none;">&nbsp;</td>
    <td class="excel5" style="border-top:none;">&nbsp;</td>
    <td class="excel5" style="border-top:none;">&nbsp;</td>
    <td class="excel5" style="border-top:none;">&nbsp;</td>
    <td class="excel5" style="border-top:none;">&nbsp;</td>
    <td class="excel5" style="border-top:none;">&nbsp;</td>
    <td class="excel5" style="border-top:none;">&nbsp;</td>
    <td class="excel5" style="border-top:none;">&nbsp;</td>
    <td class="excel5" style="border-top:none;">&nbsp;</td>
    <td class="excel5" style="border-top:none;">&nbsp;</td>
    <td class="excel5" style="border-top:none;">&nbsp;</td>
    <td class="excel2"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel2" colspan="8" style="height:14.1pt;">Riwayat    alergi dressing <font class="font5">(Dressing alert)</font></td>
    <td class="excel2">:</td>
    <td colspan="15" class="excel5" style="border-top:none;"><input type="text" name="riwayat_alergi" id="riwayat_alergi" style="width:520px;"/></td>
    <td class="excel2"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel2" style="height:14.1pt;">1.</td>
    <td class="excel2" colspan="6">Luka yang didapat di RS</td>
    <td class="excel2"></td>
    <td class="excel2" width="26" style="height:14.1pt;width:20pt;"><input type="radio" name="luka1" id="luka1" value="1" />
      </td>
    <td class="excel2" colspan="2">Ya <font class="font5">(Yes)</font></td>
    <td class="excel2"></td>
    <td class="excel2"></td>
    <td class="excel2" width="26" style="height:14.1pt;width:20pt;"><input type="radio" name="luka1" id="luka1" value="2" /></td>
    <td class="excel2" colspan="3">Tidak <font class="font5">(No)</font></td>
    <td class="excel2"></td>
    <td class="excel2" colspan="5">Stadium
      <input type="text" name="lukaisi" id="lukaisi" /></td>
    <td class="excel2"></td>
    <td class="excel2"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel2" style="height:14.1pt;"></td>
    <td class="excel2" colspan="7">Resiko luka tekan <font class="font5">(Braden Score)</font></td>
    <td class="excel2" width="26" style="height:14.1pt;width:20pt;"><input type="radio" name="luka2" id="luka2" value="1" /></td>
    <td class="excel2" colspan="2">15 - 16</td>
    <td class="excel2"></td>
    <td class="excel2"></td>
    <td class="excel2" width="26" style="height:14.1pt;width:20pt;"><input type="radio" name="luka2" id="luka2" value="2" /></td>
    <td class="excel4" colspan="2">12  - 14</td>
    <td class="excel2"></td>
    <td class="excel2"></td>
    <td class="excel2" width="26" style="height:14.1pt;width:20pt;"><input type="radio" name="luka2" id="luka2" value="3" /></td>
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
    <td class="excel19" width="184" style="height:14.1pt;width:20pt;"><input type="radio" name="etio" id="etio" value="1" /></td>
    <td class="excel19" colspan="4">Bedah <font class="font5">(Surgery)</font></td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><input type="radio" name="etio" id="etio" value="2" /></td>
    <td class="excel19" colspan="2">Trauma</td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19" width="356" style="height:14.1pt;width:20pt;"><input type="radio" name="etio" id="etio" value="3" /></td>
    <td class="excel19" colspan="2">Tekanan</td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><input type="radio" name="etio" id="etio" value="4" /></td>
    <td class="excel19" colspan="4">Lainnya <font class="font5">(Other)</font></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;"></td>
    <td class="excel19" colspan="2">Note  :</td>
    <td colspan="21" class="excel21"><input class="inputan" type="text" name="etioisi" id="etioisi"/></td>
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
    <td class="excel19" width="184" style="height:14.1pt;width:20pt;"><input type="radio" name="klinis" id="klinis" value="1" /></td>
    <td class="excel19" colspan="4">Necrotic/hitam</td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><input type="radio" name="klinis" id="klinis" value="2" /></td>
    <td class="excel19" colspan="4">slough/Kuning</td>
    <td class="excel19"></td>
    <td class="excel19" width="356" style="height:14.1pt;width:20pt;"><input type="radio" name="klinis" id="klinis" value="3" /></td>
    <td class="excel19" colspan="4">Granulasi/merah</td>
    <td class="excel19"></td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><input type="radio" name="klinis" id="klinis" value="4" /></td>
    <td class="excel19" colspan="3">Ephitelisasi</td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;"></td>
    <td class="excel19" colspan="2">Note  :</td>
    <td colspan="21" class="excel21"><input class="inputan" type="text" name="klinisisi" id="klinisisi" /></td>
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
    <td class="excel19" width="184" style="height:14.1pt;width:20pt;"><input type="radio" name="kulit" id="kulit" value="1" /></td>
    <td class="excel19" colspan="3">Baik <font class="font5">(intact)</font></td>
    <td class="excel19"></td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><input type="radio" name="kulit" id="kulit" value="2" /></td>
    <td class="excel19" colspan="5">Maserasi <font class="font5">(Maceration)</font></td>
    <td class="excel19" width="356" style="height:14.1pt;width:20pt;"><input type="radio" name="kulit" id="kulit" value="3" /></td>
    <td class="excel19" colspan="5">Denudasi <font class="font5">(denuded)</font></td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><input type="radio" name="kulit" id="kulit" value="4" /></td>
    <td class="excel19" colspan="5">Ekskoriasi <font class="font5">(Excoriation)</font></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;"></td>
    <td class="excel19" colspan="2">Note  :</td>
    <td colspan="21" class="excel21"><input type="text" name="kulitisi" id="kulitisi" class="inputan" /></td>
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
    <td class="excel19" width="184" style="height:14.1pt;width:20pt;"><input type="radio" name="nyeri" id="nyeri" value="1" /></td>
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
    <td colspan="21" class="excel21"><input type="text" name="nyeriisi" id="nyeriisi" class="inputan" /></td>
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
    <td class="excel19" width="184" style="height:14.1pt;width:20pt;"><input type="radio" name="eksudat" id="eksudat" value="1" /></td>
    <td class="excel19" colspan="4">Tidak ada (None)</td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><input type="radio" name="eksudat" id="eksudat" value="2" /></td>
    <td class="excel19" colspan="4">Sedikit (slight)</td>
    <td class="excel19"></td>
    <td class="excel19" width="356" style="height:14.1pt;width:20pt;"><input type="radio" name="eksudat" id="eksudat" value="3" /></td>
    <td class="excel19" colspan="5">Sedang (Moderate)</td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><input type="radio" name="eksudat" id="eksudat" value="4" /></td>
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
    <td class="excel19" width="184" style="height:14.1pt;width:20pt;"><input type="radio" name="tipeeksudat" id="tipeeksudat" value="1" /></td>
    <td class="excel19" colspan="2">Seruos</td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><input type="radio" name="tipeeksudat" id="tipeeksudat" value="2" /></td>
    <td class="excel19" colspan="3">Hemoserous</td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19" width="356" style="height:14.1pt;width:20pt;"><input type="radio" name="tipeeksudat" id="tipeeksudat" value="3" /></td>
    <td class="excel19" colspan="5">Darah ( Frank blood)</td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><input type="radio" name="tipeeksudat" id="tipeeksudat" value="4" /></td>
    <td class="excel19" colspan="4">Purulent (Pus)</td>
    <td class="excel19"></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;"></td>
    <td class="excel19" colspan="2">Note  :</td>
    <td colspan="21" class="excel21"><input type="text" name="tipeeksudatisi" id="tipeeksudatisi" class="inputan" /></td>
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
    <td class="excel19" width="184" style="height:14.1pt;width:20pt;"><input type="radio" name="bau" id="bau" value="1" /></td>
    <td class="excel19" colspan="3">Tidak  (None)</td>
    <td class="excel19"></td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><input type="radio" name="bau" id="bau" value="2" /></td>
    <td class="excel19" colspan="4">Sedikit (some)</td>
    <td class="excel19"></td>
    <td class="excel19" width="356" style="height:14.1pt;width:20pt;"><input type="radio" name="bau" id="bau" value="3" /></td>
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
    <td class="excel19" width="184" style="height:14.1pt;width:20pt;"><input type="radio" name="lab" id="lab" value="1" /></td>
    <td class="excel19" colspan="2">Ya (yes)</td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><input type="radio" name="lab" id="lab" value="2" /></td>
    <td class="excel19" colspan="3">Tidak ( No )</td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19" colspan="6">Tanggal (date) <input type="text" name="tgllab" id="tgllab" size="7" value="<?=date('d-m-Y');?>" onclick="gfPop.fPopCalendar(document.getElementById('tgllab'),depRange);"/></td>
    <td class="excel19" colspan="6">Hasil  <input type="text" name="hasillab" id="hasillab" size="21" /></td>
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
    <td colspan="23" ><textarea name="penanganan" id="penanganan" cols="1" rows="3" class="textArea"></textarea></td>
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
    <td class="excel19" width="184" style="height:14.1pt;width:20pt;"><input type="radio" name="analgesik" id="analgesik" value="1" /></td>
    <td class="excel19" colspan="2">Ya (yes)</td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><input type="radio" name="analgesik" id="analgesik" value="2" /></td>
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
    <td class="excel19" width="184" style="height:14.1pt;width:20pt;"><input name="gauze" id="gauze" type="checkbox" value="1" /></td>
    <td class="excel19" colspan="2">Gauze</td>
    <td class="excel19"></td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><input name="film" id="film" type="checkbox" value="1" /></td>
    <td class="excel19" colspan="2">Film</td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><input name="tullegrass" id="tullegrass" type="checkbox" value="1" /></td>
    <td class="excel19" colspan="3">Tullegrass</td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><input name="hydrogel" id="hydrogel" type="checkbox" value="1" /></td>
    <td class="excel19" colspan="3">Hydrogel</td>
    <td class="excel19"></td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><input name="silver" id="silver" type="checkbox" value="1" /></td>
    <td class="excel19" colspan="2">Silver</td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;"></td>
    <td class="excel19" width="184" style="height:14.1pt;width:20pt;"><input name="hidrocoloid" id="hidrocoloid" type="checkbox" value="1" /></td>
    <td class="excel19" colspan="3">Hidrocoloid</td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><input name="hidrofiber" id="hidrofiber" type="checkbox" value="1" /></td>
    <td class="excel19" colspan="3">Hidrofiber</td>
    <td class="excel19"></td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><input name="alginate" id="alginate" type="checkbox" value="1" /></td>
    <td class="excel19" colspan="2">Alginate</td>
    <td class="excel19"></td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><input name="foam" id="foam" type="checkbox" value="1" /></td>
    <td class="excel19" colspan="2">Foam</td>
    <td class="excel19"></td>
    <td class="excel19"></td>
    <td class="excel19" width="26" style="height:14.1pt;width:20pt;"><input name="lain1" id="lain1" type="checkbox" value="1" onclick="enableDisable(this.checked, 'dressingisi')"/></td>
    <td class="excel19" colspan="4">Lain-lain <input name="dressingisi" id="dressingisi" type="text"  size="7" value="" disabled="disabled"/></td>
    <td class="excel19"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel19" style="height:14.1pt;"></td>
    <td class="excel19" colspan="2">Note :</td>
    <td colspan="21" class="excel21"><input type="text" name="dressingisi2" id="dressingisi2" class="inputan" /></td>
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
    <td colspan="23" ><textarea name="tindakan" id="tindakan" cols="1" rows="3" class="textArea">&nbsp;</textarea></td>
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
    <td class="excel24" width="26" style="height:14.1pt;width:20pt;"><input type="radio" name="braden" id="braden" value="1" /></td>
    <td class="excel24">&gt; 18</td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24" width="26" style="height:14.1pt;width:20pt;"><input type="radio" name="braden" id="braden" value="3" /></td>
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
    <td class="excel24" width="26" style="height:14.1pt;width:20pt;"><input type="radio" name="braden" id="braden" value="2" /></td>
    <td class="excel24" colspan="2">15-18</td>
    <td class="excel24"></td>
    <td class="excel24" width="26" style="height:14.1pt;width:20pt;"><input type="radio" name="braden" id="braden" value="4" /></td>
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
    <td style="height:14.1pt;" align="left" valign="top"><input name="sacrum" id="sacrum" type="checkbox" value="1" /></td>
    <td class="excel26" colspan="2" style="border-top:none;">Sacrum</td>
    <td class="excel26" style="border-top:none;">&nbsp;</td>
    <td class="excel26" style="border-top:none;">&nbsp;</td>
    <td class="excel26" width="26" style="height:14.1pt;border-top:none;width:20pt;"><input name="throchanter" id="throchanter" type="checkbox" value="1" /></td>
    <td class="excel26" colspan="5" style="border-top:none;">Throchanter Mayor (D)</td>
    <td class="excel26" style="border-top:none;">&nbsp;</td>
    <td class="excel26" width="356" style="height:14.1pt;border-top:none;width:20pt;"><input name="auriculas" id="auriculas" type="checkbox" value="1" /></td>
    <td class="excel26" colspan="3" style="border-top:none;">Auricula (S)</td>
    <td class="excel26" style="border-top:none;">&nbsp;</td>
    <td class="excel26" style="border-top:none;">&nbsp;</td>
    <td class="excel26" style="border-top:none;">&nbsp;</td>
    <td class="excel26" width="26" style="height:14.1pt;border-top:none;width:20pt;"><input type="radio" name="stadium" id="stadium" value="1" /></td>
    <td class="excel26" colspan="3" style="border-top:none;">Stadium I</td>
    <td class="excel26" style="border-top:none;">&nbsp;</td>
    <td class="excel27" style="border-top:none;">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td style="height:14.1pt;" align="left" valign="top"><input name="heeld" id="heeld" type="checkbox" value="1" /></td>
    <td class="excel24" colspan="2">Heel (D)</td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24" width="26" style="height:14.1pt;width:20pt;"><input name="throchaler" id="throchaler" type="checkbox" value="1" /></td>
    <td class="excel24" colspan="5">Throchaler Mayor (S)</td>
    <td class="excel24"></td>
    <td class="excel24" width="356" style="height:14.1pt;width:20pt;"><input name="malelolusd" id="malelolusd" type="checkbox" value="1" /></td>
    <td class="excel24" colspan="4">Malelolus (D)</td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24" width="26" style="height:14.1pt;width:20pt;"><input type="radio" name="stadium" id="stadium" value="2" /></td>
    <td class="excel24" colspan="3">Stadium II</td>
    <td class="excel24"></td>
    <td class="excel29">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td style="height:14.1pt;" align="left" valign="top"><input name="heels" id="heels" type="checkbox" value="1" /></td>
    <td class="excel24" colspan="2">Heel (S)</td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24" width="26" style="height:14.1pt;width:20pt;"><input name="throchaterd" id="throchaterd" type="checkbox" value="1" /></td>
    <td class="excel24" colspan="5">Throchater Minor (D)</td>
    <td class="excel24"></td>
    <td class="excel24" width="356" style="height:14.1pt;width:20pt;"><input name="maleoluss" id="maleoluss" type="checkbox" value="1" /></td>
    <td class="excel24" colspan="3">Maleolus (S)</td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24" width="26" style="height:14.1pt;width:20pt;"><input type="radio" name="stadium" id="stadium" value="3" /></td>
    <td class="excel24" colspan="3">Stadium III</td>
    <td class="excel24"></td>
    <td class="excel29">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td style="height:14.1pt;" align="left" valign="top"><input name="occipitalis" id="occipitalis" type="checkbox" value="1" /></td>
    <td class="excel24" colspan="3">Occipitalis</td>
    <td class="excel24"></td>
    <td class="excel24" width="26" style="height:14.1pt;width:20pt;"><input name="throchaters" id="throchaters" type="checkbox" value="1" /></td>
    <td class="excel24" colspan="5">Throchater Minor (S)</td>
    <td class="excel24"></td>
    <td class="excel24" width="356" style="height:14.1pt;width:20pt;"><input name="lain2" id="lain2" type="checkbox" value="1" onclick="enableDisable(this.checked, 'dekubitusisi')"/></td>
    <td class="excel24" colspan="4">Lain-lain <input name="dekubitusisi" id="dekubitusisi" size="7" type="text" value="" disabled="disabled"/></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24" width="26" style="height:14.1pt;width:20pt;"><input type="radio" name="stadium" id="stadium" value="4" /></td>
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
    <td class="excel31" width="26" style="height:14.1pt;width:20pt;"><input name="auriculad" id="auriculad" type="checkbox" value="1" /></td>
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
    <td class="excel31" width="26" style="height:14.1pt;width:20pt;"><input type="radio" name="stadium" id="stadium" value="5" /></td>
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
    <td style="height:14.1pt;" align="left" valign="top"><input type="radio" name="persepsi" id="persepsi" value="1" /></td>
    <td class="excel26" colspan="9" style="border-top:none;">Tidak memberi resppon    terhadap nyeri</td>
    <td class="excel26" style="border-top:none;">&nbsp;</td>
    <td class="excel27" style="border-top:none;">&nbsp;</td>
    <td class="excel25" width="356" style="height:14.1pt;border-top:none;border-left:none;width:20pt;"><input type="radio" name="mobilitas" id="mobilitas" value="1" /></td>
    <td class="excel26" colspan="12" style="border-top:none;">Tidak bisa bergerak</td>
    </tr>
  <tr style="height:14.1pt;">
    <td style="height:14.1pt;" align="left" valign="top"><input type="radio" name="persepsi" id="persepsi" value="2" /></td>
    <td class="excel24" colspan="8">Merespon dengan    merintih/gelisah</td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel29">&nbsp;</td>
    <td class="excel28" width="356" style="height:14.1pt;border-left:none;width:20pt;"><input type="radio" name="mobilitas" id="mobilitas" value="2" /></td>
    <td class="excel24" colspan="12">Pergerakan sangat    terbatas</td>
    </tr>
  <tr style="height:14.1pt;">
    <td style="height:14.1pt;" align="left" valign="top"><input type="radio" name="persepsi" id="persepsi" value="3" /></td>
    <td class="excel24" colspan="7">Mampu merespon secara    verbal</td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel24"></td>
    <td class="excel29">&nbsp;</td>
    <td class="excel28" width="356" style="height:14.1pt;border-left:none;width:20pt;"><input type="radio" name="mobilitas" id="mobilitas" value="3" /></td>
    <td class="excel24" colspan="12">Pergerakan sedikit    terbatas</td>
    </tr>
  <tr style="height:14.1pt;">
    <td style="height:14.1pt;" align="left" valign="top" class="excel47"><input type="radio" name="persepsi" id="persepsi" value="4" /></td>
    <td class="excel31" colspan="7">Tidak ada gangguan    sensori</td>
    <td class="excel31">&nbsp;</td>
    <td class="excel31">&nbsp;</td>
    <td class="excel31">&nbsp;</td>
    <td class="excel32">&nbsp;</td>
    <td class="excel30" width="356" style="height:14.1pt;border-left:none;width:20pt;"><input type="radio" name="mobilitas" id="mobilitas" value="4" /></td>
    <td class="excel31" colspan="8">tidak ada batasan dalam    bergerak</td>
    <td class="excel31">&nbsp;</td>
    <td class="excel31">&nbsp;</td>
    <td class="excel31">&nbsp;</td>
    <td class="excel31">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td colspan="12" class="excel52" width="670" style="height:14.1pt;width:241pt;border-top:none;">Kelembaban</td>
    <td colspan="13" class="excel52" width="356" style="border-left:none;width:273pt;border-top:none;">Nutrisi</td>
  </tr>
  <tr style="height:14.1pt;">
    <td style="height:14.1pt;" align="left" valign="top"><input type="radio" name="kelembaban" id="kelembaban" value="1" />
      </td>
    <td class="excel42" colspan="4" style="border-top:none;">Selalu lembab</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel43" style="border-top:none;">&nbsp;</td>
    <td class="excel41" width="356" style="height:14.1pt;border-top:none;border-left:none;width:20pt;"><input type="radio" name="nutrisi" id="nutrisi" value="1" /></td>
    <td class="excel42" colspan="11" style="border-top:none;">Sangat buruk (makan    &lt;1/2 porsi, puasa / infus &gt; 5 hr)</td>
    <td class="excel43" style="border-top:none;">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td style="height:14.1pt;" align="left" valign="top"><input type="radio" name="kelembaban" id="kelembaban" value="2" />
      </td>
    <td class="excel40" colspan="4">Sering lembab</td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel45">&nbsp;</td>
    <td class="excel44" width="356" style="height:14.1pt;border-left:none;width:20pt;"><input type="radio" name="nutrisi" id="nutrisi" value="2" /></td>
    <td class="excel40" colspan="7">Tidak adekuat (makan 1/2    porsi)</td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel45">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td style="height:14.1pt;" align="left" valign="top"><input type="radio" name="kelembaban" id="kelembaban" value="3" />
      </td>
    <td class="excel40" colspan="5">Terkadang lembab</td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel45">&nbsp;</td>
    <td class="excel44" width="356" style="height:14.1pt;border-left:none;width:20pt;"><input type="radio" name="nutrisi" id="nutrisi" value="3" /></td>
    <td class="excel40" colspan="7">Adekuat (makan 3/4 porsi,    TPN)</td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel45">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td style="height:14.1pt;" align="left" valign="top" class="excel47"><input type="radio" name="kelembaban" id="kelembaban" value="4" />
      </td>
    <td class="excel47" colspan="4">Jarang lembab</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel48">&nbsp;</td>
    <td class="excel46" width="356" style="height:14.1pt;border-left:none;width:20pt;"><input type="radio" name="nutrisi" id="nutrisi" value="4" /></td>
    <td class="excel47" colspan="10">Baik (menghabiskan    makanan yang disajikan)</td>
    <td class="excel47">&nbsp;</td>
    <td class="excel48">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td colspan="12" class="excel53" style="height:14.1pt;border-top:none;">Aktifitas</td>
    <td colspan="13" class="excel54" style="border-right:.5pt solid black;border-top:none;">Gesekan</td>
  </tr>
  <tr style="height:14.1pt;">
    <td style="height:14.1pt;" align="left" valign="top"><input type="radio" name="aktifitas" id="aktifitas" value="1" />
      </td>
    <td class="excel42" colspan="3" style="border-top:none;">Baring total</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel43" style="border-top:none;">&nbsp;</td>
    <td class="excel41" width="356" style="height:14.1pt;border-top:none;border-left:none;width:20pt;"><input type="radio" name="gesekan" id="gesekan" value="1" /></td>
    <td class="excel42" colspan="6" style="border-top:none;">Gesekan terus menerus</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel43" style="border-top:none;">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td style="height:14.1pt;" align="left" valign="top"><input type="radio" name="aktifitas" id="aktifitas" value="2" /></td>
    <td class="excel40" colspan="11" style="border-right:.5pt solid black;">Mampu    duduk - perlu bantuan untuk menumpu</td>
    <td class="excel44" width="356" style="height:14.1pt;border-left:none;width:20pt;"><input type="radio" name="gesekan" id="gesekan" value="2" /></td>
    <td class="excel40" colspan="6">Kadang terjadi gesekan</td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel45">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td style="height:14.1pt;" align="left" valign="top"><input type="radio" name="aktifitas" id="aktifitas" value="3" /></td>
    <td class="excel40" colspan="10">Kadang berjalan -    sebagai besar berbaring</td>
    <td class="excel45">&nbsp;</td>
    <td class="excel44" width="356" style="height:14.1pt;border-left:none;width:20pt;"><input type="radio" name="gesekan" id="gesekan" value="3" /></td>
    <td class="excel40" colspan="7">Dapat bergerak/tanpa    gesekan</td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel45">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel47" style="height:14.1pt;" align="left" valign="top"><input type="radio" name="aktifitas" id="aktifitas" value="4" /></td>
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
    <td style="height:14.1pt;" align="left" valign="top"><input name="mastatis" id="mastatis" type="checkbox" value="1" /></td>
    <td class="excel42" colspan="5" style="border-top:none;">Matras angin statis</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel43" style="border-top:none;">&nbsp;</td>
    <td class="excel41" width="26" style="height:14.1pt;border-top:none;border-left:none;width:20pt;"><input type="radio" name="posisi" id="posisi" value="1" /></td>
    <td class="excel42" colspan="3" style="border-top:none;">Setiap 2 jam</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel42" style="border-top:none;">&nbsp;</td>
    <td class="excel43" style="border-top:none;">&nbsp;</td>
    <td class="excel50" style="border-top:none;border-left:none;">&nbsp;</td>
    <td class="excel49" width="26" style="height:14.1pt;border-top:none;width:20pt;"><input type="radio" name="beritahu" id="beritahu" value="1" /></td>
    <td class="excel49" style="border-top:none;">Ya</td>
    <td class="excel49" style="border-top:none;">&nbsp;</td>
    <td class="excel49" style="border-top:none;">&nbsp;</td>
    <td class="excel49" width="26" style="height:14.1pt;border-top:none;width:20pt;"><input type="radio" name="beritahu" id="beritahu" value="2" /></td>
    <td class="excel49" colspan="2" style="border-top:none;">Tidak</td>
    <td class="excel49" style="border-top:none;">&nbsp;</td>
    <td class="excel51" style="border-top:none;">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td style="height:14.1pt;" align="left" valign="top"><input name="madinamik" id="madinamik" type="checkbox" value="1" /></td>
    <td class="excel40" colspan="5">Matras angin dinamik</td>
    <td class="excel40"></td>
    <td class="excel45">&nbsp;</td>
    <td class="excel44" width="26" style="height:14.1pt;border-left:none;width:20pt;"><input type="radio" name="posisi" id="posisi" value="2" /></td>
    <td class="excel40" colspan="3">&gt; dari 2 jam</td>
    <td class="excel40"></td>
    <td class="excel40"></td>
    <td class="excel45">&nbsp;</td>
    <td colspan="10" class="excel53" style="border-right:.5pt solid black;border-left:none;border-top:none;">Menghubungi Perawat Luka</td>
  </tr>
  <tr style="height:14.1pt;">
    <td style="height:14.1pt;" align="left" valign="top"><input name="bantal" id="bantal" type="checkbox" value="1" /></td>
    <td class="excel40" colspan="7" style="border-right:.5pt solid black;">Bantal    penopang tambahan</td>
    <td class="excel44" width="26" style="height:14.1pt;border-left:none;width:20pt;"><input type="radio" name="posisi" id="posisi" value="3" /></td>
    <td class="excel40" colspan="4">Tidak dilakukan</td>
    <td class="excel40"></td>
    <td class="excel45">&nbsp;</td>
    <td class="excel50" style="border-top:none;border-left:none;">&nbsp;</td>
    <td class="excel49" width="26" style="height:14.1pt;border-top:none;width:20pt;"><input type="radio" name="hubungi" id="hubungi" value="1" /></td>
    <td class="excel49" style="border-top:none;">Ya</td>
    <td class="excel49" style="border-top:none;">&nbsp;</td>
    <td class="excel49" style="border-top:none;">&nbsp;</td>
    <td class="excel49" width="26" style="height:14.1pt;border-top:none;width:20pt;"><input type="radio" name="hubungi" id="hubungi" value="2" /></td>
    <td class="excel49" colspan="2" style="border-top:none;">Tidak</td>
    <td class="excel49" style="border-top:none;">&nbsp;</td>
    <td class="excel51" style="border-top:none;">&nbsp;</td>
  </tr>
  <tr style="height:14.1pt;">
    <td style="height:14.1pt;" align="left" valign="top"><input name="lain3" id="lain3" type="checkbox" value="1" onclick="enableDisable(this.checked, 'penunjangisi')"/></td>
    <td class="excel40" colspan="6">Lain - lain <input type="text" name="penunjangisi" id="penunjangisi"  size="9" disabled="disabled"/></td>
    <td class="excel45">&nbsp;</td>
    <td class="excel44" style="border-left:none;">&nbsp;</td>
    <td class="excel40" colspan="5">Alasan <input type="text" name="posisiisi" id="posisiisi"  size="9"/></td>
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
    <td class="excel49" width="26" style="height:14.1pt;border-top:none;width:20pt;"><input type="radio" name="kajian" id="kajian" value="1" /></td>
    <td class="excel49" style="border-top:none;">Ya</td>
    <td class="excel49" style="border-top:none;">&nbsp;</td>
    <td class="excel49" style="border-top:none;">&nbsp;</td>
    <td class="excel49" width="26" style="height:14.1pt;border-top:none;width:20pt;"><input type="radio" name="kajian" id="kajian" value="2" /></td>
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
    <td class="excel56" width="184" style="height:14.1pt;width:20pt;"><input name="albumin" id="albumin" type="checkbox" value="1" /></td>
    <td class="excel56" colspan="2">Albumin</td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56" width="26" style="height:14.1pt;width:20pt;"><input name="hb" id="hb" type="checkbox" value="1" /></td>
    <td class="excel56">Hb</td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56" width="26" style="height:14.1pt;width:20pt;"><input name="suhu" id="suhu" type="checkbox" value="1" /></td>
    <td class="excel56" colspan="2">Suhu</td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56" width="26" style="height:14.1pt;width:20pt;"><input name="td" id="td" type="checkbox" value="1" /></td>
    <td class="excel56">TD</td>
    <td class="excel56"></td>
    <td class="excel56"></td>
    <td class="excel56" width="26" style="height:14.1pt;width:20pt;"><input name="lain4" id="lain4" type="checkbox" value="1" onclick="enableDisable(this.checked, 'hslpemeriksaanisi')"/></td>
    <td class="excel56" colspan="2">Lain-lain <input name="hslpemeriksaanisi" id="hslpemeriksaanisi" type="text" value="" size="5" disabled="disabled"/></td>
    <td class="excel56"></td>
    <td class="excel56"></td>
  </tr>
  <tr style="height:14.1pt;">
    <td colspan="25" class="excel67" style="height:14.1pt;">DESKRIPSI KEJADIAN</td>
  </tr>
  <tr style="height:14.1pt;">
    <td class="excel60" style="height:14.1pt;border-top:none;">&nbsp;</td>
    <td colspan="23" class="excel60" style="border-top:none;"><textarea name="deskripsi" id="deskripsi" cols="1" rows="7" class="textArea"></textarea></td>
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
        <td colspan="10" class="noline" align="center">
                    <input name="simpen" id="simpen" type="button" value="Simpan" onclick="simpan(this.value);" class="tblTambah"/>
                    <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));" <?php if(!isset($_POST['idPel'])){ echo 'style="display:none"';} ?>/>
                    <input id="liaten" type="button" value="View" onClick="return liat()" <?php if(!isset($_POST['idPel'])){ echo 'style="display:none"';} ?>/>
                    <input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/>
                </td>
        </tr>
</table></form></div></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td height="30">
                    <?php
                    if($_REQUEST['report']!=1){
					?>
                        <input type="button" id="btnTambah" name="btnTambah" value="Tambah" onclick="tambah(this.value);" class="tblTambah"/>
                        <input type="button" id="btnEdit" name="btnEdit" value="Edit" onclick="edit(this.value);" class="tblTambah"/>
                        <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus(this.title);" class="tblHapus"/>
                    <?php }?>    
                  </td>
                    <td><button type="button" id="btnTree" name="btnTree" value="Tampilan Tree" onclick="cetak()" class="tblViewTree">Cetak</button></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <!--Tindakan Unit:&nbsp;
                    <select id="cmbUnit" name="cmbUnit" class="txtinput" onchange="alert('lbr_pengkajian_luka_utils.php?grd=true&unit='+document.getElementById('cmbUnit').value);">
		<option value="">-ALL UNIT-</option>
                        <?php
                        /*	$rs = mysql_query("SELECT * FROM b_ms_unit unit WHERE unit.islast=1");
            	while($rows=mysql_fetch_array($rs)):
		?>
			<option value="<?=$rows["id"]?>" <?php if($rows["id"]==$unit_id) echo "selected";?>><?=$rows["nama"]?></option>
            <?	endwhile;
                        */
                        ?>
		</select>
                        -->
                    </td>
                    <td>&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td colspan="3">
                        <div id="gridbox" style="width:925px; height:200px; background-color:white; overflow:hidden;"></div>
                        <div id="paging" style="width:925px;"></div>	</td>
                    <td width="5%">&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td width="30%">&nbsp;</td>
                    <td width="30%">&nbsp;</td>
                    <td width="30%">&nbsp;</td>
                    <td width="5%">&nbsp;</td>
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
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
<!--            <table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
<tr height="30">
                    <td>&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" /></td>
                    <td>&nbsp;</td>
                    <td align="right"><a href="../../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" class="btninput" /></a>&nbsp;</td>
                </tr>
            </table>-->
        </div>
        <!-- end div tindakan-->

       
    </body>
    <script type="text/JavaScript" language="JavaScript">
        function toggle() {
    parent.alertsize(document.body.scrollHeight);
}

		function tambah(){
			/*$('#act').val('tambah');*/
			awal();
			$('#metu').slideDown(1000,function(){
		toggle();
		});
			}
        ///////////////////////////////////////////////////////////////////

        //////////////////fungsi untuk tindakan////////////////////////
        function simpan(action)
        {
            if(ValidateForm('riwayat_alergi,deskripsi','ind'))
            {
                $("#form1").ajaxSubmit({
					  success:function(msg)
					  {
						alert(msg);
						
					  },
					});
					batal();
						a.loadURL("lbr_pengkajian_luka_utils.php?grd=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>"+"&idKunj=<?=$idKunj?>","","GET");
						//goFilterAndSort();
            }
        }

		function edit(){
            var rowid = document.getElementById("txtId").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(rowid==''){
					alert("Pilih data terlebih dahulu");
				}else{
					$('#act').val('edit');
					$('#metu').slideDown(1000,function(){
		toggle();
		});
				}

        }
		
        function ambilData()
        {
			var sisip=a.getRowId(a.getSelRow()).split("|");
            var p="txtId*-*"+sisip[0]+"*|*riwayat_alergi*-*"+sisip[63]+"*|*lukaisi*-*"+sisip[64]+"*|*etioisi*-*"+sisip[65]+"*|*klinisisi*-*"+sisip[66]+"*|*kulitisi*-*"+sisip[67]+"*|*nyeriisi*-*"+sisip[68]+"*|*tipeeksudatisi*-*"+sisip[69]+"*|*hasillab*-*"+sisip[70]+"*|*posisiisi*-*"+sisip[71]+"*|*tgllab*-*"+sisip[26]+"*|*dressingisi*-*"+sisip[27]+"*|*dressingisi2*-*"+sisip[72]+"*|*dekubitusisi*-*"+sisip[28]+"*|*penunjangisi*-*"+sisip[29]+"*|*hslpemeriksaanisi*-*"+sisip[30]+"";
            //alert(sisip[63]);
            fSetValue(window,p);
			$('#penanganan').val(sisip[24]);
			$('#tindakan').val(sisip[25]);
			$('#deskripsi').val(a.cellsGetValue(a.getSelRow(),3));
            //isiCombo('cmbKlasi', '', sisip[2], 'cmbKlasi', '');
			centang(sisip[1],sisip[2],sisip[3],sisip[4],sisip[5],sisip[6],sisip[7],sisip[8],sisip[9],sisip[10],sisip[11],sisip[12],sisip[13],sisip[14],sisip[15],sisip[16],sisip[17],sisip[18],sisip[19],sisip[20],sisip[21],sisip[22],sisip[23]);
			
			//alert(sisip[2]);
			
			if(sisip[31]==1) {$('#gauze').attr('checked', true);} else {$('#gauze').attr('checked', false);}
			if(sisip[32]==1) {$('#film').attr('checked', true);} else {$('#film').attr('checked', false);}
			if(sisip[33]==1) {$('#tullegrass').attr('checked', true);} else {$('#tullegrass').attr('checked', false);}
			if(sisip[34]==1) {$('#hydrogel').attr('checked', true);} else {$('#hydrogel').attr('checked', false);}
			if(sisip[35]==1) {$('#silver').attr('checked', true);} else {$('#silver').attr('checked', false);}
			if(sisip[36]==1) {$('#hidrocoloid').attr('checked', true);} else {$('#hidrocoloid').attr('checked', false);}
			if(sisip[37]==1) {$('#hidrofiber').attr('checked', true);} else {$('#hidrofiber').attr('checked', false);}
			if(sisip[38]==1) {$('#alginate').attr('checked', true);} else {$('#alginate').attr('checked', false);}
			if(sisip[39]==1) {$('#foam').attr('checked', true);} else {$('#foam').attr('checked', false);}
			if(sisip[40]==1) {$('#lain1').attr('checked', true);} else {$('#lain1').attr('checked', false);}
            if(sisip[41]==1) {$('#sacrum').attr('checked', true);} else {$('#sacrum').attr('checked', false);}
			if(sisip[42]==1) {$('#throchanter').attr('checked', true);} else {$('#throchanter').attr('checked', false);}
			if(sisip[43]==1) {$('#auriculas').attr('checked', true);} else {$('#auriculas').attr('checked', false);}
			if(sisip[44]==1) {$('#heeld').attr('checked', true);} else {$('#heeld').attr('checked', false);}
			if(sisip[45]==1) {$('#throchaler').attr('checked', true);} else {$('#throchaler').attr('checked', false);}
			if(sisip[46]==1) {$('#malelolusd').attr('checked', true);} else {$('#malelolusd').attr('checked', false);}
			if(sisip[47]==1) {$('#heels').attr('checked', true);} else {$('#heels').attr('checked', false);}
			if(sisip[48]==1) {$('#throchaterd').attr('checked', true);} else {$('#throchaterd').attr('checked', false);}
			if(sisip[49]==1) {$('#maleoluss').attr('checked', true);} else {$('#maleoluss').attr('checked', false);}
			if(sisip[50]==1) {$('#occipitalis').attr('checked', true);} else {$('#occipitalis').attr('checked', false);}
			if(sisip[51]==1) {$('#throchaters').attr('checked', true);} else {$('#throchaters').attr('checked', false);}
			if(sisip[52]==1) {$('#lain2').attr('checked', true);} else {$('#lain2').attr('checked', false);}
			if(sisip[53]==1) {$('#auriculad').attr('checked', true);} else {$('#auriculad').attr('checked', false);}
			if(sisip[54]==1) {$('#mastatis').attr('checked', true);} else {$('#mastatis').attr('checked', false);}
			if(sisip[55]==1) {$('#madinamik').attr('checked', true);} else {$('#madinamik').attr('checked', false);}
			if(sisip[56]==1) {$('#bantal').attr('checked', true);} else {$('#bantal').attr('checked', false);}
			if(sisip[57]==1) {$('#lain3').attr('checked', true);} else {$('#lain3').attr('checked', false);}
			if(sisip[58]==1) {$('#albumin').attr('checked', true);} else {$('#albumin').attr('checked', false);}
			if(sisip[59]==1) {$('#hb').attr('checked', true);} else {$('#hb').attr('checked', false);}
			if(sisip[60]==1) {$('#suhu').attr('checked', true);} else {$('#suhu').attr('checked', false);}
			if(sisip[61]==1) {$('#td').attr('checked', true);} else {$('#td').attr('checked', false);}
			if(sisip[62]==1) {$('#lain4').attr('checked', true);} else {$('#lain4').attr('checked', false);}
			
			
			if(document.getElementById("lain1").checked){document.getElementById("dressingisi").disabled = false;}else{document.getElementById("dressingisi").disabled = true;}
			if(document.getElementById("lain2").checked){document.getElementById("dekubitusisi").disabled = false;}else{document.getElementById("dekubitusisi").disabled = true;}
			if(document.getElementById("lain3").checked){document.getElementById("penunjangisi").disabled = false;}else{document.getElementById("penunjangisi").disabled = true;}
			if(document.getElementById("lain4").checked){document.getElementById("hslpemeriksaanisi").disabled = false;}else{document.getElementById("hslpemeriksaanisi").disabled = true;}
        }
		
		function awal(){
			$('#act').val('tambah');
			$('#penanganan').val('');
			$('#tindakan').val('');
			$('#deskripsi').val('');
			$('#tgllab').val('<?=date('d-m-Y');?>');
			var p="txtId*-**|*riwayat_alergi*-**|*lukaisi*-**|*etioisi*-**|*klinisisi*-**|*kulitisi*-**|*nyeriisi*-**|*tipeeksudatisi*-**|*hasillab*-**|*dressingisi2*-**|*posisiisi*-*";
			fSetValue(window,p);
			centang(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0)
			$('#gauze').attr('checked', false);
			$('#film').attr('checked', false);
			$('#tullegrass').attr('checked', false);
			$('#hydrogel').attr('checked', false);
			$('#silver').attr('checked', false);
			$('#hidrocoloid').attr('checked', false);
			$('#hidrofiber').attr('checked', false);
			$('#alginate').attr('checked', false);
			$('#foam').attr('checked', false);
			$('#lain1').attr('checked', false);
			$('#sacrum').attr('checked', false);
			$('#throchanter').attr('checked', false);
			$('#auriculas').attr('checked', false);
			$('#heeld').attr('checked', false);
			$('#throchaler').attr('checked', false);
			$('#malelolusd').attr('checked', false);
			$('#heels').attr('checked', false);
			$('#throchaterd').attr('checked', false);
			$('#maleoluss').attr('checked', false);
			$('#occipitalis').attr('checked', false);
			$('#throchaters').attr('checked', false);
			$('#lain2').attr('checked', false);
			$('#auriculad').attr('checked', false);
			$('#mastatis').attr('checked', false);
			$('#madinamik').attr('checked', false);
			$('#bantal').attr('checked', false);
			$('#lain3').attr('checked', false);
			$('#albumin').attr('checked', false);
			$('#hb').attr('checked', false);
			$('#suhu').attr('checked', false);
			$('#td').attr('checked', false);
			$('#lain4').attr('checked', false);
		}
		
		function enableDisable(bEnable, textBoxID)
    	{
         document.getElementById(textBoxID).disabled = !bEnable;
		 document.getElementById(textBoxID).value = '';
    	}
		
        function hapus()
        {
            var rowid = document.getElementById("txtId").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
            if(confirm("Anda yakin menghapus data ini ?"))
            {
                $('#act').val('hapus');
					$("#form1").ajaxSubmit({
					  success:function(msg)
					  {
						alert(msg);
						
					  },
					});
					awal();
						goFilterAndSort();
            }
        }

        function batal(){
            awal();
			$('#metu').slideUp(1000,function(){
		toggle();
		});
        }
		
		function cetak(){
		 var rowid = document.getElementById("txtId").value;
		 if(rowid==""){
				var rowidx =a.getRowId(a.getSelRow()).split('|');
				rowid=rowidx[0];
			 }
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			//if(rowid==''){
//					alert("Pilih data terlebih dahulu");
//				}else{	
		window.open('lbr_pengkajian_luka.php?idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idUser=<?=$idUser?>&idPasien=<?=$idPasien?>&id='+rowid,"_blank");
				//}
		}
        //////////////////////////////////////////////////////////////////

        function goFilterAndSort(grd){
            //alert(grd);
                a.loadURL("lbr_pengkajian_luka_utils.php?grd=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>"+"&idKunj=<?=$idKunj?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("DATA LEMBAR PENGKAJIAN LUKA");
        a.setColHeader("NO,RIWAYAT ALERGI,DESKRIPSI");
        a.setIDColHeader(",,");
        a.setColWidth("40,220,400");
        a.setCellAlign("center,left,left");
        a.setCellHeight(20);
        a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        a.baseURL("lbr_pengkajian_luka_utils.php?grd=true"+"&idPel=<?=$idPel?>"+"&idKunj=<?=$idKunj?>");
        a.Init();
		
		function centang(tes,tes2,tes3,tes4,tes5,tes6,tes7,tes8,tes9,tes10,tes11,tes12,tes13,tes14,tes15,tes16,tes17,tes18,tes19,tes20,tes21,tes22,tes23){
		 
		 //var checkbox = document.form1.elements[0];
		 //var checkbox = document.form1.caries2;
		 //var checkbox = document.getElementById('caries2');
		 //var checkbox = document.getElementById('form1').caries2;
		 var checkbox = document.form1.elements['luka1'];
		 var checkbox2 = document.form1.elements['luka2'];
		 var checkbox3 = document.form1.elements['etio'];
		 var checkbox4 = document.form1.elements['klinis'];
		 var checkbox5 = document.form1.elements['kulit'];
		 var checkbox6 = document.form1.elements['nyeri'];
		 var checkbox7 = document.form1.elements['eksudat'];
		 var checkbox8 = document.form1.elements['tipeeksudat'];
		 var checkbox9 = document.form1.elements['bau'];
		 var checkbox10 = document.form1.elements['lab'];
		 var checkbox11 = document.form1.elements['analgesik'];
		 var checkbox12 = document.form1.elements['braden'];
		 var checkbox13 = document.form1.elements['stadium'];
		 var checkbox14 = document.form1.elements['persepsi'];
		 var checkbox15 = document.form1.elements['mobilitas'];
		 var checkbox16 = document.form1.elements['kelembaban'];
		 var checkbox17 = document.form1.elements['nutrisi'];
		 var checkbox18 = document.form1.elements['aktifitas'];
		 var checkbox19 = document.form1.elements['gesekan'];
		 var checkbox20 = document.form1.elements['posisi'];
		 var checkbox21 = document.form1.elements['beritahu'];
		 var checkbox22 = document.form1.elements['hubungi'];
		 var checkbox23 = document.form1.elements['kajian'];
		 
		 //alert(checkbox);
		 if ( checkbox.length > 0 )
		 {
		 for (i = 0; i < checkbox.length; i++)
			{
			  if (checkbox[i].value==tes)
			  {
			   checkbox[i].checked = true;
			  }
		  }
		}
		if ( checkbox2.length > 0 )
		{
		 for (i = 0; i < checkbox2.length; i++)
			{
			  if (checkbox2[i].value==tes2)
			  {
			   checkbox2[i].checked = true;
			  }
		  }
		}
		if ( checkbox3.length > 0 )
		{
		 for (i = 0; i < checkbox3.length; i++)
			{
			  if (checkbox3[i].value==tes3)
			  {
			   checkbox3[i].checked = true;
			  }
		  }
		}
		if ( checkbox4.length > 0 )
		{
		 for (i = 0; i < checkbox4.length; i++)
			{
			  if (checkbox4[i].value==tes4)
			  {
			   checkbox4[i].checked = true;
			  }
		  }
		}
		if ( checkbox5.length > 0 )
		{
		 for (i = 0; i < checkbox5.length; i++)
			{
			  if (checkbox5[i].value==tes5)
			  {
			   checkbox5[i].checked = true;
			  }
		  }
		}
		if ( checkbox6.length > 0 )
		{
		 for (i = 0; i < checkbox6.length; i++)
			{
			  if (checkbox6[i].value==tes6)
			  {
			   checkbox6[i].checked = true;
			  }
		  }
		}
		if ( checkbox7.length > 0 )
		{
		 for (i = 0; i < checkbox7.length; i++)
			{
			  if (checkbox7[i].value==tes7)
			  {
			   checkbox7[i].checked = true;
			  }
		  }
		}
		if ( checkbox8.length > 0 )
		{
		 for (i = 0; i < checkbox8.length; i++)
			{
			  if (checkbox8[i].value==tes8)
			  {
			   checkbox8[i].checked = true;
			  }
		  }
		}
		if ( checkbox9.length > 0 )
		{
		 for (i = 0; i < checkbox9.length; i++)
			{
			  if (checkbox9[i].value==tes9)
			  {
			   checkbox9[i].checked = true;
			  }
		  }
		}
		if ( checkbox10.length > 0 )
		{
		 for (i = 0; i < checkbox10.length; i++)
			{
			  if (checkbox10[i].value==tes10)
			  {
			   checkbox10[i].checked = true;
			  }
		  }
		}
		if ( checkbox11.length > 0 )
		{
		 for (i = 0; i < checkbox11.length; i++)
			{
			  if (checkbox11[i].value==tes11)
			  {
			   checkbox11[i].checked = true;
			  }
		  }
		}
		if ( checkbox12.length > 0 )
		{
		 for (i = 0; i < checkbox12.length; i++)
			{
			  if (checkbox12[i].value==tes12)
			  {
			   checkbox12[i].checked = true;
			  }
		  }
		}
		if ( checkbox13.length > 0 )
		{
		 for (i = 0; i < checkbox13.length; i++)
			{
			  if (checkbox13[i].value==tes13)
			  {
			   checkbox13[i].checked = true;
			  }
		  }
		}
		if ( checkbox14.length > 0 )
		 {
		 for (i = 0; i < checkbox14.length; i++)
			{
			  if (checkbox14[i].value==tes14)
			  {
			   checkbox14[i].checked = true;
			  }
		  }
		}
		if ( checkbox15.length > 0 )
		 {
		 for (i = 0; i < checkbox15.length; i++)
			{
			  if (checkbox15[i].value==tes15)
			  {
			   checkbox15[i].checked = true;
			  }
		  }
		}
		if ( checkbox16.length > 0 )
		 {
		 for (i = 0; i < checkbox16.length; i++)
			{
			  if (checkbox16[i].value==tes16)
			  {
			   checkbox16[i].checked = true;
			  }
		  }
		}
		if ( checkbox17.length > 0 )
		 {
		 for (i = 0; i < checkbox17.length; i++)
			{
			  if (checkbox17[i].value==tes17)
			  {
			   checkbox17[i].checked = true;
			  }
		  }
		}
		if ( checkbox18.length > 0 )
		 {
		 for (i = 0; i < checkbox18.length; i++)
			{
			  if (checkbox18[i].value==tes18)
			  {
			   checkbox18[i].checked = true;
			  }
		  }
		}
		if ( checkbox19.length > 0 )
		 {
		 for (i = 0; i < checkbox19.length; i++)
			{
			  if (checkbox19[i].value==tes19)
			  {
			   checkbox19[i].checked = true;
			  }
		  }
		}
		if ( checkbox20.length > 0 )
		 {
		 for (i = 0; i < checkbox20.length; i++)
			{
			  if (checkbox20[i].value==tes20)
			  {
			   checkbox20[i].checked = true;
			  }
		  }
		}
		if ( checkbox21.length > 0 )
		 {
		 for (i = 0; i < checkbox21.length; i++)
			{
			  if (checkbox21[i].value==tes21)
			  {
			   checkbox21[i].checked = true;
			  }
		  }
		}
		if ( checkbox22.length > 0 )
		 {
		 for (i = 0; i < checkbox22.length; i++)
			{
			  if (checkbox22[i].value==tes22)
			  {
			   checkbox22[i].checked = true;
			  }
		  }
		}
		if ( checkbox23.length > 0 )
		 {
		 for (i = 0; i < checkbox23.length; i++)
			{
			  if (checkbox23[i].value==tes23)
			  {
			   checkbox23[i].checked = true;
			  }
		  }
		}
		
	}
	
    </script>
</html>
