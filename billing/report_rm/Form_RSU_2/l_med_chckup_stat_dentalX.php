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
  mp.telp, k.no_reg
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

$sAnam = "SELECT * 
FROM anamnese a
WHERE a.KUNJ_ID = '".$idKunj."' ORDER BY a.anamnese_id DESC LIMIT 1";	
$qAnam = mysql_query($sAnam);
$rwAnam = mysql_fetch_array($qAnam);
$keluhan = $rwAnam['KU'];
//echo $rwAnam['KU'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" rel="stylesheet" href="../../theme/mod.css" />
        <script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../../theme/js/dsgrid.js"></script>

        <!-- untuk ajax-->
        <script type="text/javascript" src="../../theme/js/ajax.js"></script>
        <script type="text/javascript" src="../../jquery.js"></script>
        <script type="text/javascript" src="../../jquery.form.js"></script>
    <!-- untuk ajax-->

        <title>.: Laporan Medical Check Up Status Dental :.</title>
        <style>
        body{background:#FFF;}
        </style>
    </head>

    <body onload="isi();">
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

        <!-- div tindakan-->
        <div align="center" id="div_tindakan">
           <!-- <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
                <tr>
                    <td height="30">FORM MEDICAL CHECK UP STATUS UP (DENTAL)</td>
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
                    <form id="form1" name="form1" action="lap_med_chckup_stat_dental_utils.php" method="post">
    <input type="hidden" name="idPel" value="<?=$idPel?>" />
    <input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    <input type="hidden" name="idUser" value="<?=$idUser?>" />
    <input type="hidden" name="idPasien" value="<?=$idPasien?>" />
    <input name="keluhan" id="keluhan" type="hidden" value="<?=$keluhan?>" />
    <input type="hidden" name="txtId" id="txtId"/>
    <input type="hidden" name="act" id="act" value="tambah"/><table width="200" border="0">
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
    <td>
    <table cellspacing="0" cellpadding="0" style="font:12px tahoma; border:1px solid #000;">
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
        <td colspan="13">&nbsp;<? echo $rwAnam['KU']; ?></td>
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
        <td width="46" align="right"><input name="caries2" id="caries2" type="checkbox" value="1" onclick="enableDisable(this.checked, 'caries')"/></td>
        <td colspan="2">Caries</td>
        <td></td>
        <td colspan="13"><input class="inputan" name="caries" id="caries" type="text" disabled="disabled"/></td>
        <td ></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="46" align="right"><input name="filling2" id="filling2" type="checkbox" value="1" onclick="enableDisable(this.checked, 'filling')"/></td>
        <td colspan="2">Filling</td>
        <td></td>
        <td colspan="13"><input class="inputan" name="filling" id="filling" type="text"  disabled="disabled"/></td>
        <td ></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="46" align="right"><input name="root2" id="root2" type="checkbox"  value="1" onclick="enableDisable(this.checked, 'root')"/></td>
        <td colspan="3">Root / Radix</td>
        <td colspan="13"><input class="inputan" name="root" id="root" type="text"  disabled="disabled"/></td>
        <td ></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="46" align="right"><input name="missing2" id="missing2" type="checkbox" value="1"  onclick="enableDisable(this.checked, 'missing')"/></td>
        <td colspan="3">Missing Tooth</td>
        <td colspan="13"><input class="inputan" name="missing" id="missing" type="text" disabled="disabled" /></td>
        <td ></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="46" align="right"><input name="crown2" id="crown2" type="checkbox" value="1"  onclick="enableDisable(this.checked, 'crown')"/></td>
        <td colspan="3">Crown / Casting</td>
        <td colspan="13"><input class="inputan" name="crown" id="crown" type="text" disabled="disabled" /></td>
        <td ></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="46" align="right"><input name="bridge2" id="bridge2" type="checkbox" value="1"   onclick="enableDisable(this.checked, 'bridge')"/></td>
        <td colspan="3">Bridge Work </td>
        <td colspan="13"><input class="inputan" name="bridge" id="bridge" type="text" disabled="disabled" /></td>
        <td ></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="46" align="right"><input name="dentures2" id="dentures2" type="checkbox"  value="1" onclick="enableDisable(this.checked, 'dentures')"/></td>
        <td colspan="2">Dentures</td>
        <td></td>
        <td colspan="13"><input class="inputan" name="dentures" id="dentures" type="text" disabled="disabled" /></td>
        <td ></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="46" align="right"><input name="malloclusion2" id="malloclusion2" type="checkbox"  value="1"  onclick="enableDisable(this.checked, 'malloclusion')"/></td>
        <td colspan="3">Malloclusion</td>
        <td colspan="13"><input class="inputan" name="malloclusion" id="malloclusion" type="text"  disabled="disabled"/></td>
        <td ></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="46" align="right"><input name="lack2" id="lack2" type="checkbox"  value="1"  onclick="enableDisable(this.checked, 'lack')"/></td>
        <td colspan="3">Lack Of Contact</td>
        <td colspan="13"><input class="inputan" name="lack" id="lack" type="text"  disabled="disabled"/></td>
        <td ></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="46" align="right"><input name="calculus2" id="calculus2" type="checkbox" value="1"  onclick="enableDisable(this.checked, 'calculus')"/></td>
        <td colspan="2">Calculus</td>
        <td></td>
        <td colspan="13"><input class="inputan" name="calculus" id="calculus" type="text" disabled="disabled" /></td>
        <td></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="46" align="right"><input name="endontolous2" id="endontolous2" type="checkbox" value="1"  onclick="enableDisable(this.checked, 'endontolous')"/></td>
        <td colspan="3">Endontolous</td>
        <td colspan="13"><input class="inputan" name="endontolous" id="endontolous" type="text" disabled="disabled" /></td>
        <td ></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="46" align="right"><input name="mobility2" id="mobility2" type="checkbox" value="1"  onclick="enableDisable(this.checked, 'mobility')"/></td>
        <td colspan="2">Mobility</td>
        <td></td>
        <td colspan="13"><input class="inputan" name="mobility" id="mobility" type="text" disabled="disabled" /></td>
        <td ></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="46" align="right"><input name="others2" id="others2" type="checkbox"  value="1"  onclick="enableDisable(this.checked, 'others')"/></td>
        <td colspan="2">Others</td>
        <td></td>
        <td colspan="13"><input class="inputan" name="others" id="others" type="text"  disabled="disabled"/></td>
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
        <td colspan="14"><input class="inputan" name="anjuran" id="anjuran" type="text" /></td>
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
        <td colspan="8">Tanggal/Date&nbsp;:&nbsp;<?=tgl_ina(date('Y-m-d'));?></td>
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
        <td colspan="8">Pukul/Time&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<?=date('H:i:s');?></td>
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
                    <td height="30"><?php
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
                    <select id="cmbUnit" name="cmbUnit" class="txtinput" onchange="alert('lap_med_chckup_stat_dental_utils.php?grd=true&unit='+document.getElementById('cmbUnit').value);">
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
            if(ValidateForm('anjuran','ind'))
            {
                $("#form1").ajaxSubmit({
					  success:function(msg)
					  {
						alert(msg);
						
					  },
					});
					batal();
						a.loadURL("lap_med_chckup_stat_dental_utils.php?grd=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>"+"&idKunj=<?=$idKunj?>","","GET");
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
            var p="txtId*-*"+sisip[0]+"*|*keluhan*-*"+a.cellsGetValue(a.getSelRow(),2)+"*|*anjuran*-*"+a.cellsGetValue(a.getSelRow(),4)+"*|*caries*-*"+sisip[14]+"*|*filling*-*"+sisip[15]+"*|*root*-*"+sisip[16]+"*|*missing*-*"+sisip[17]+"*|*crown*-*"+sisip[18]+"*|*bridge*-*"+sisip[19]+"*|*dentures*-*"+sisip[20]+"*|*malloclusion*-*"+sisip[21]+"*|*lack*-*"+sisip[22]+"*|*calculus*-*"+sisip[23]+"*|*endontolous*-*"+sisip[24]+"*|*mobility*-*"+sisip[25]+"*|*others*-*"+sisip[26]+"";
            //alert(p);
            fSetValue(window,p);
            //isiCombo('cmbKlasi', '', sisip[2], 'cmbKlasi', '');
			//centang(sisip[1]);
			//alert(sisip[2]);
            if(sisip[1]==1) {$('#caries2').attr('checked', true);} else {$('#caries2').attr('checked', false);}
			if(sisip[2]==1) {$('#filling2').attr('checked', true);} else {$('#filling2').attr('checked', false);}
			if(sisip[3]==1) {$('#root2').attr('checked', true);} else {$('#root2').attr('checked', false);}
			if(sisip[4]==1) {$('#missing2').attr('checked', true);} else {$('#missing2').attr('checked', false);}
			if(sisip[5]==1) {$('#crown2').attr('checked', true);} else {$('#crown2').attr('checked', false);}
			if(sisip[6]==1) {$('#bridge2').attr('checked', true);} else {$('#bridge2').attr('checked', false);}
			if(sisip[7]==1) {$('#dentures2').attr('checked', true);} else {$('#dentures2').attr('checked', false);}
			if(sisip[8]==1) {$('#malloclusion2').attr('checked', true);} else {$('#malloclusion2').attr('checked', false);}
			if(sisip[9]==1) {$('#lack2').attr('checked', true);} else {$('#lack2').attr('checked', false);}
			if(sisip[10]==1) {$('#calculus2').attr('checked', true);} else {$('#calculus2').attr('checked', false);}
			if(sisip[11]==1) {$('#endontolous2').attr('checked', true);} else {$('#endontolous2').attr('checked', false);}
			if(sisip[12]==1) {$('#mobility2').attr('checked', true);} else {$('#mobility2').attr('checked', false);}
			if(sisip[13]==1) {$('#others2').attr('checked', true);} else {$('#others2').attr('checked', false);}
			
			if(document.getElementById("caries2").checked){document.getElementById("caries").disabled = false;}else{document.getElementById("caries").disabled = true;}
			if(document.getElementById("filling2").checked){document.getElementById("filling").disabled = false;}else{document.getElementById("filling").disabled = true;}
			if(document.getElementById("root2").checked){document.getElementById("root").disabled = false;}else{document.getElementById("root").disabled = true;}
			if(document.getElementById("missing2").checked){document.getElementById("missing").disabled = false;}else{document.getElementById("missing").disabled = true;}
			if(document.getElementById("crown2").checked){document.getElementById("crown").disabled = false;}else{document.getElementById("crown").disabled = true;}
			if(document.getElementById("bridge2").checked){document.getElementById("bridge").disabled = false;}else{document.getElementById("bridge").disabled = true;}
			if(document.getElementById("dentures2").checked){document.getElementById("dentures").disabled = false;}else{document.getElementById("dentures").disabled = true;}
			if(document.getElementById("malloclusion2").checked){document.getElementById("malloclusion").disabled = false;}else{document.getElementById("malloclusion").disabled = true;}
			if(document.getElementById("lack2").checked){document.getElementById("lack").disabled = false;}else{document.getElementById("lack").disabled = true;}
			if(document.getElementById("calculus2").checked){document.getElementById("calculus").disabled = false;}else{document.getElementById("calculus").disabled = true;}
			if(document.getElementById("endontolous2").checked){document.getElementById("endontolous").disabled = false;}else{document.getElementById("endontolous").disabled = true;}
			if(document.getElementById("mobility2").checked){document.getElementById("mobility").disabled = false;}else{document.getElementById("mobility").disabled = true;}
			if(document.getElementById("others2").checked){document.getElementById("others").disabled = false;}else{document.getElementById("others").disabled = true;}
        }
		
		function awal(){
			$('#act').val('tambah');
			var p="txtId*-**|*keluhan*-**|*anjuran*-**|*caries*-**|*filling*-**|*root*-**|*missing*-**|*crown*-**|*bridge*-**|*dentures*-**|*malloclusion*-**|*lack*-**|*calculus*-**|*endontolous*-**|*mobility*-**|*others*-*";
			fSetValue(window,p);
			//centang(1)
			$('#caries2').attr('checked', false);
			$('#filling2').attr('checked', false);
			$('#root2').attr('checked', false);
			$('#missing2').attr('checked', false);
			$('#crown2').attr('checked', false);
			$('#bridge2').attr('checked', false);
			$('#dentures2').attr('checked', false);
			$('#malloclusion2').attr('checked', false);
			$('#lack2').attr('checked', false);
			$('#calculus2').attr('checked', false);
			$('#endontolous2').attr('checked', false);
			$('#mobility2').attr('checked', false);
			$('#others2').attr('checked', false);
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
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(rowid==""){
				var rowidx =a.getRowId(a.getSelRow()).split('|');
				rowid=rowidx[0];
			 }
			//if(rowid==''){
//					alert("Pilih data terlebih dahulu");
//				}else{	
		window.open('lap_med_chckup_stat_dental.php?idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idUser=<?=$idUser?>&idPasien=<?=$idPasien?>&id='+rowid,"_blank");
			//	}
		}
        //////////////////////////////////////////////////////////////////

        function goFilterAndSort(grd){
            //alert(grd);
                a.loadURL("lap_med_chckup_stat_dental_utils.php?grd=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>"+"&idKunj=<?=$idKunj?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("DATA MEDICAL CHECK UP STATUS UP (DENTAL)");
        a.setColHeader("NO,KELUHAN,DIAGNOSA,ANJURAN");
        a.setIDColHeader(",,,");
        a.setColWidth("40,220,200,200");
        a.setCellAlign("center,left,left,left");
        a.setCellHeight(20);
        a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        a.baseURL("lap_med_chckup_stat_dental_utils.php?grd=true"+"&idPel=<?=$idPel?>"+"&idKunj=<?=$idKunj?>");
        a.Init();
		
		/*function centang(tes){
		 var checkbox = document.form1.elements["caries2"];
		 //var checkbox = document.form1.elements[0];
		 //var checkbox = document.form1.caries2;
		 //var checkbox = document.getElementById('caries2');
		 //var checkbox = document.getElementById('form1').caries2;
		 var checkbox2 = document.form1.elements['filling2'];
		 var checkbox3 = document.form1.elements['root2'];
		 var checkbox4 = document.form1.elements['missing2'];
		 var checkbox5 = document.form1.elements['crown2'];
		 var checkbox6 = document.form1.elements['bridge2'];
		 var checkbox7 = document.form1.elements['dentures2'];
		 var checkbox8 = document.form1.elements['malloclusion2'];
		 var checkbox9 = document.form1.elements['lack2'];
		 var checkbox10 = document.form1.elements['calculus2'];
		 var checkbox11 = document.form1.elements['endontolous2'];
		 var checkbox12 = document.form1.elements['mobility2'];
		 var checkbox13 = document.form1.elements['others2'];
		 
		 alert(checkbox);
		 if ( checkbox)
		{
		 for (i = 0; i < checkbox.length; i++)
			{
				alert(checkbox[i]);
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
		
	}*/
	       function toggle() {
    parent.alertsize(document.body.scrollHeight);
}

function isi()
{
	document.getElementById("keluhan").value = "<? echo $rwAnam['KU'];?>";
}

    </script>
</html>
