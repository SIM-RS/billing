<?php
session_start();
include '../../koneksi/konek.php';
$idPel=$_REQUEST['idPel'];
$idKunj=$_REQUEST['idKunj'];
$idUser=$_REQUEST['idUser'];

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
  mp.telp
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
  INNER JOIN b_pasien_keluar bkel
    ON bkel.pelayanan_id = p.id
  INNER JOIN b_ms_pegawai peg3
    ON peg3.id = bkel.dokter_id
  LEFT JOIN b_ms_kelas bmk
    ON bmk.id = p.kelas_id
WHERE k.id='$idKunj' AND p.id='$idPel'";

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
<title>Untitled Document</title>
</head>
<style>

.bwh{
	border-bottom:1px solid #000000;
}
.inputan{
	width:300px;
	}

</style>
<body>
<form id="form1" name="form1" action="" method="post">
    <input type="hidden" name="idPel" value="<?=$idPel?>" />
    <input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    <input type="hidden" name="idUser" value="<?=$idUser?>" />
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
            <td><?php echo $isi['no_rm'];?>&nbsp;No.Registrasi:</td>
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
        <td colspan="13"><input class="inputan" name="keluhan" id="keluhan" type="text" /></td>
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
        <td width="46" align="right"><input name="caries2" id="caries2" type="checkbox" value="1" /></td>
        <td colspan="2">Caries</td>
        <td></td>
        <td colspan="13"><input class="inputan" name="caries" id="caries" type="text" /></td>
        <td ></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="46" align="right"><input name="filling2" id="filling2" type="checkbox" value="" /></td>
        <td colspan="2">Filling</td>
        <td></td>
        <td colspan="13"><input class="inputan" name="filling" id="filling" type="text" /></td>
        <td ></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="46" align="right"><input name="root2" id="root2" type="checkbox" value="" /></td>
        <td colspan="3">Root / Radix</td>
        <td colspan="13"><input class="inputan" name="root" id="root" type="text" /></td>
        <td ></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="46" align="right"><input name="missing2" id="missing2" type="checkbox" value="" /></td>
        <td colspan="3">Missing Tooth</td>
        <td colspan="13"><input class="inputan" name="missing" id="missing" type="text" /></td>
        <td ></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="46" align="right"><input name="crown2" id="crown2" type="checkbox" value="" /></td>
        <td colspan="3">Crown / Casting</td>
        <td colspan="13"><input class="inputan" name="crown" id="crown" type="text" /></td>
        <td ></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="46" align="right"><input name="bridge2" id="bridge2" type="checkbox" value="" /></td>
        <td colspan="3">Bridge Work </td>
        <td colspan="13"><input class="inputan" name="bridge" id="bridge" type="text" /></td>
        <td ></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="46" align="right"><input name="dentures2" id="dentures2" type="checkbox" value="" /></td>
        <td colspan="2">Dentures</td>
        <td></td>
        <td colspan="13"><input class="inputan" name="dentures" id="dentures" type="text" /></td>
        <td ></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="46" align="right"><input name="malloclusion2" id="malloclusion2" type="checkbox" value="" /></td>
        <td colspan="3">Malloclusion</td>
        <td colspan="13"><input class="inputan" name="malloclusion" id="malloclusion" type="text" /></td>
        <td ></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="46" align="right"><input name="lack2" id="lack2" type="checkbox" value="" /></td>
        <td colspan="3">Lack Of Contact</td>
        <td colspan="13"><input class="inputan" name="lack" id="lack" type="text" /></td>
        <td ></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="46" align="right"><input name="calculus2" id="calculus2" type="checkbox" value="" /></td>
        <td colspan="2">Calculus</td>
        <td></td>
        <td colspan="13"><input class="inputan" name="calculus" id="calculus" type="text" /></td>
        <td></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="46" align="right"><input name="endontolous2" id="endontolous2" type="checkbox" value="" /></td>
        <td colspan="3">Endontolous</td>
        <td colspan="13"><input class="inputan" name="endontolous" id="endontolous" type="text" /></td>
        <td ></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="46" align="right"><input name="mobility2" id="mobility2" type="checkbox" value="" /></td>
        <td colspan="2">Mobility</td>
        <td></td>
        <td colspan="13"><input class="inputan" name="mobility" id="mobility" type="text" /></td>
        <td ></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="46" align="right"><input name="others2" id="others2" type="checkbox" value="" /></td>
        <td colspan="2">Others</td>
        <td></td>
        <td colspan="13"><input class="inputan" name="others" id="others" type="text" /></td>
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
        <td colspan="14" class="bwh"><?=$isi['diag']?></td>
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
        <td colspan="8">Tanggal/Date  : <?=date('d M Y');?></td>
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
                    <input name="simpen" id="simpen" type="submit" value="Simpan" />
                    <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));" <?php if(!isset($_POST['idPel'])){ echo 'style="display:none"';} ?>/>
                    <input id="liaten" type="button" value="View" onClick="return liat()" <?php if(!isset($_POST['idPel'])){ echo 'style="display:none"';} ?>/>
                    <input id="btnTutup" type="button" value="Tutup" onClick="window.close();" style="display:none"/>
                </td>
        </tr>
</table>
</form>
</body>
<script type="text/JavaScript">

            function cetak(tombol){
                tombol.style.visibility='collapse';
                if(tombol.style.visibility=='collapse'){
                    if(confirm('Anda Yakin Mau Mencetak Surat Keterangan Periksa Mata ?')){
                        setTimeout('window.print()','1000');
                        setTimeout('window.close()','2000');
                    }
                    else{
                        tombol.style.visibility='visible';
                    }

                }
            }
			
function liat(){
		window.open("lap_med_chckup_stat_dental.php?id=<?=$idx?>&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idUser=<?=$idUser?>","_blank");
	}
        </script>
</html>