<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../../theme/mod.css" />
        <script type="text/javascript" language="JavaScript" src="../../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../../theme/js/dsgrid.js"></script>
        <!-- untuk ajax-->
        <script type="text/javascript" src="../../theme/js/ajax.js"></script>
        <script type="text/javascript" src="../../jquery.js"></script>
        <script type="text/javascript" src="../../jquery.form.js"></script>
        <!-- end untuk ajax-->
        <script type="text/JavaScript">
            var arrRange = depRange = [];
        </script>
<title>Surat Kuasa Pemberian Informasi Medik</title>
</head>
<?
include "../../koneksi/konek.php";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUser=$_REQUEST['idUsr'];
$id=$_REQUEST['id'];
$idHub=$_REQUEST['idHub'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,IFNULL(pg.nama,'-') AS dr_rujuk,DATE_FORMAT(p.tgl_act, '%d %M %Y') AS tgl_masuk,l.nama AS nama2,l.alamat AS alamat2,l.ktp AS ktp2,h.nama_hubungan AS hubungan2,l.hubungan
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
LEFT JOIN lap_inform_konsen l ON l.pelayanan_id=pl.id
LEFT JOIN b_ms_hubungan h ON h.id=l.hubungan
WHERE pl.id='$idPel'";
$dP=mysql_fetch_array(mysql_query($sqlP));
//include "setting.php";
?>
<style>
        .gb{
	border-bottom:1px solid #000000;
}
.inputan{
	width:40px;
	}
.textArea{ width:100%;}
body{background:#FFF;}
        .style1 {font-size: 18px}
</style>
<body>
<div id="form_input" align="center" style="display:none">
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
<form id="form1" action="22.suratkuasapemberianinformasimed_act.php">
<table width="800" border="0" style="font:12px tahoma;">
  <tr>
    <td><table width="316" border="0" style="border:1px solid #000000;" align="right">
      <tr>
        <td style="font:bold 16px tahoma;"><div align="center">SURAT KUASA PEMBERIAN</div></td>
      </tr>
      <tr>
        <td style="font:bold 16px tahoma;"><div align="center">INFORMASI MEDIS</div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="800" border="0" style="border:1px solid #000000">
      <tr>
        <td><table cellspacing="0" cellpadding="0">
          <col width="15" />
          <col width="18" />
          <col width="26" />
          <col width="30" />
          <col width="133" />
          <col width="13" />
          <col width="23" span="2" />
          <col width="13" />
          <col width="23" span="2" />
          <col width="35" />
          <col width="89" />
          <col width="49" />
          <col width="25" />
          <col width="28" />
          <col width="23" />
          <col width="17" />
          <col width="25" span="2" />
          <col width="130" />
          <col width="26" />
          <tr height="12">
            <td height="12" width="15">&nbsp;</td>
            <td width="18">&nbsp;</td>
            <td width="26">&nbsp;</td>
            <td width="30">&nbsp;</td>
            <td width="133">&nbsp;</td>
            <td width="13">&nbsp;</td>
            <td width="23">&nbsp;</td>
            <td width="23">&nbsp;</td>
            <td width="13">&nbsp;</td>
            <td width="23">&nbsp;</td>
            <td width="23">&nbsp;</td>
            <td width="35">&nbsp;</td>
            <td width="89">&nbsp;</td>
            <td width="49">&nbsp;</td>
            <td width="25">&nbsp;</td>
            <td width="28">&nbsp;</td>
            <td width="23">&nbsp;</td>
            <td width="17">&nbsp;</td>
            <td width="25">&nbsp;</td>
            <td width="25">&nbsp;</td>
            <td width="130">&nbsp;</td>
            <td width="26">&nbsp;</td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="4">No. Permintaan Informasi Medis:</td>
            <td colspan="5"><label for="textfield"></label>
              <input type="text" name="no_permintaan" id="no_permintaan" /></td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
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
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="5">Yang bertandatangan    dibawah ini:</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
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
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="2">Nama</td>
            <td></td>
            <td></td>
            <td>:</td>
            <td colspan="15"><label>
              	<input type="hidden" size="2" name="act" id="act" value="tambah" />
            	<input type="hidden" name="id" id="id" value="" />
            	<input type="hidden" name="idPel" id="idPel" value="<?php echo $idPel; ?>" />
                <input type="hidden" name="idUser" id="idUser" value="<?php echo $idUser; ?>" />
      			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
      			<input type="hidden" name="idPasien" value="<?=$idPasien?>" />
                <input type="hidden" name="idHub" id="idHub" value="<?php echo $idHub; ?>" />
              	<?=$dP['nama2']?>
              </label></td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
            <td colspan="12">&nbsp;</td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="3" valign="top">Alamat</td>
            <td></td>
            <td valign="top">:</td>
            <td colspan="15"><label>
              <textarea disabled="disabled" name="alamat" cols="40" rows="3" id="alamat"><?=$dP['alamat2']?></textarea>
              </label></td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
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
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="3">No. KTP</td>
            <td></td>
            <td>:</td>
            <td colspan="15"><label>
              <?=$dP['ktp2']?>
            </label></td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
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
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="18">Selaku:
            <?php echo ($dP['hubungan'] == 1 ? 'Pasien' : '<strike>Pasien</strike>' ) ?> /
			<?php echo ($dP['hubungan'] == 3 ? 'Suami' : '<strike>Suami</strike>' ) ?> /
			<?php echo ($dP['hubungan'] == 2 ? 'Istri' : '<strike>Istri</strike>' ) ?> /
			<?php echo ($dP['hubungan'] == 5 ? 'Orang Tua' : '<strike>Orang Tua</strike>' ) ?> /
			<?php echo ($dP['hubungan'] == 7 ? 'Ayah' : '<strike>Ayah</strike>' ) ?> /
            <?php echo ($dP['hubungan'] == 6 ? 'Ibu' : '<strike>Ibu</strike>' ) ?> /
            <?php echo ($dP['hubungan'] == 8 ? 'Wali' : '<strike>Wali</strike>' ) ?> /
            <?php echo ($dP['hubungan'] == 4 ? 'Anak' : '<strike>Anak</strike>' ) ?> /
			<?php echo ($dP['hubungan'] == 0 ? 'Penanggung jawab' : '<strike>Penanggung jawab</strike>' ) ?>*) yang mendapat
            </td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td></td>
            <td></td>
            <td colspan="2">Ijin tertulis dari pasien.</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
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
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="4">Nama pasien</td>
            <td></td>
            <td></td>
            <td></td>
            <td>:</td>
            <td colspan="11"><?=$dP['nama'];?></td>
            <td>&nbsp;</td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="4">Nomor Rekam Medis</td>
            <td></td>
            <td></td>
            <td></td>
            <td>:</td>
            <td colspan="11"><?=$dP['no_rm'];?></td>
            <td>&nbsp;</td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="4">Tanggal Rawat</td>
            <td></td>
            <td></td>
            <td></td>
            <td>:</td>
            <td colspan="11"><?=$dP['tgl_masuk'];?></td>
            <td>&nbsp;</td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="4">Dokter yang Merawat</td>
            <td></td>
            <td></td>
            <td></td>
            <td>:</td>
            <td colspan="12"><?=$dP['dr_rujuk'];?></td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
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
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="21">Selanjutnya pihak diatas    disebut Pemberi Kuasa, dengan    ini memberikan kuasa kepada:              </td>
            </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="20">RS PELINDO I,    beralamat di Kota Medan</td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="7">(selanjutnya disebut    Penerima Kuasa) :</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
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
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
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
          <tr height="32">
            <td height="32" colspan="22">-------------------------------------------------------------------------------------------K&nbsp; H&nbsp; U&nbsp;    S&nbsp; U&nbsp; S-----------------------------------------------------------------------------------</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table cellspacing="2">
          <col width="15" />
          <col width="18" />
          <col width="26" />
          <col width="30" />
          <col width="133" />
          <col width="13" />
          <col width="23" span="2" />
          <col width="13" />
          <col width="23" span="2" />
          <col width="35" />
          <col width="89" />
          <col width="49" />
          <col width="25" />
          <col width="28" />
          <col width="23" />
          <col width="17" />
          <col width="25" span="2" />
          <col width="130" />
          <col width="26" />
          <tr height="20">
            <td height="20" width="15">&nbsp;</td>
            <td width="18"></td>
            <td width="26"></td>
            <td width="30"></td>
            <td width="133"></td>
            <td width="13"></td>
            <td width="23"></td>
            <td width="23"></td>
            <td width="13"></td>
            <td width="23"></td>
            <td width="23"></td>
            <td width="35"></td>
            <td width="89"></td>
            <td width="49"></td>
            <td width="25"></td>
            <td width="28"></td>
            <td width="23"></td>
            <td width="17"></td>
            <td width="25"></td>
            <td width="25"></td>
            <td width="130"></td>
            <td width="26"></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="20">Untuk memberikan    informasi medis mengenai 
              <label for="select2"></label>
              <select name="mengenai" id="mengenai">
              <option value="">Pilih</option>
                <option>Diri Saya</option>
                <option>Pasien</option>
              </select>
tersebut diatas*), baik secara    lisan maupun&nbsp;</td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="16">tertulis, sesuai dengan    kebijakan yang berlaku di lingkungan&nbsp; RS PELINDO I kepada</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="6"><label for="select"></label>
              <select name="kepada" id="kepada">
              <option value="">Pilih</option>
                <option>Perorangan</option>
                <option>Perusahaan</option>
                <option>Asuransi</option>
              </select>
              *)</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
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
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="7">Fotocopy hasil    pemeriksaan yang diminta :</td>
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
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td align="right">1</td>
            <td colspan="3">Hasil Resume Medis    tanggal</td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="10">: <input type="text" name="tgl_r" id="tgl_r" onclick="gfPop.fPopCalendar(document.getElementById('tgl_r'),depRange);" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
          </tr>
          
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td align="right">2</td>
            <td colspan="3">Hasil laboratorium    tanggal</td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="10">: <input type="text" name="tgl_l" id="tgl_l" onclick="gfPop.fPopCalendar(document.getElementById('tgl_l'),depRange);" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td align="right">3</td>
            <td colspan="3">Hasil Radiologi tanggal</td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="10">: <input type="text" name="tgl_ra" id="tgl_ra" onclick="gfPop.fPopCalendar(document.getElementById('tgl_ra'),depRange);" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td align="right">4</td>
            <td colspan="3">Hasil Lain-lain</td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="13">: <input name="hasil_lain" type="text" id="hasil_lain" size="40"/></td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
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
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="20">Sehubungan dengan urusan    tersebut diatas, maka dengan ini Pemberi Kuasa membebaskan Penerima Kuasa</td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="20">dari segala tuntutan    atau konsekuensi hukum dari pihak ketiga, yang mungkin timbul sebagai akibat    pelepasan</td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="5">informasi medis pasien    tersebut.</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
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
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
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
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="8">Medan, <?=tgl_ina(date('Y-m-d'))?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
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
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="5">Jam: <?php echo date("H:i:s")?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
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
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="4">Pemberi Kuasa,</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
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
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
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
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
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
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
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
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="5">(
              <?=$dP['nama'];?>
              )</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
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
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
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
          <tr height="20">
            <td height="20" colspan="22">--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table cellspacing="0" cellpadding="0">
          <col width="15" />
          <col width="18" />
          <col width="26" />
          <col width="30" />
          <col width="133" />
          <col width="13" />
          <col width="23" span="2" />
          <col width="13" />
          <col width="23" span="2" />
          <col width="35" />
          <col width="89" />
          <col width="49" />
          <col width="25" />
          <col width="28" />
          <col width="23" />
          <col width="17" />
          <col width="25" span="2" />
          <col width="130" />
          <col width="26" />
          <tr height="20">
            <td height="20" width="15">&nbsp;</td>
            <td width="18"></td>
            <td width="26"></td>
            <td width="30"></td>
            <td width="133"></td>
            <td width="13"></td>
            <td width="23"></td>
            <td width="23"></td>
            <td width="13"></td>
            <td width="23"></td>
            <td width="23"></td>
            <td width="35"></td>
            <td width="89"></td>
            <td width="49"></td>
            <td width="25"></td>
            <td width="28"></td>
            <td width="23"></td>
            <td width="17"></td>
            <td width="25"></td>
            <td width="25"></td>
            <td width="130"></td>
            <td width="26"></td>
          </tr>
          <tr height="20">
            <td colspan="22" height="20"><div align="center"><strong>BUKTI PENERIMAAN    INFORMASI MEDIS</strong></div></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
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
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="9">No. Permintaan Informasi Medis:_______________________________</td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="5">Saya bertanda tangan di    bawah ini :</td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
            <td colspan="12"></td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="2">Nama</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>:</td>
            <td colspan="12"><?=$dP['nama2']?>
            </td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="3">Alamat</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>:</td>
            <td colspan="12"><?=$dP['alamat2']?></td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
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
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="4">Hubungan dengan pasien</td>
            <td></td>
            <td></td>
            <td></td>
            <td>:</td>
            <td colspan="12"><label>
              <?=$dP['hubungan2']?>
            </label></td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
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
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="15">Menerima dari RS PELINDO I informasi medis    dari pasien yang tersebut di atas</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
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
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="7">Medan, <?=tgl_ina(date('Y-m-d'))?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
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
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="4"><div align="center">Yang menerima,</div></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="4">Yang memberi,</td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="4"><div align="center">Petugas Rekam Medis</div></td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
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
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
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
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
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
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="4" align="center">(
              <?=$dP['nama2']?>
              )</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td align="center" colspan="4">(<?=$dP['dr_rujuk'];?>)</td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="4"><div align="center">Nama &amp; Tanda tangan</div></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="4"><div align="center">Nama &amp; Tanda tangan</div></td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
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
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
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
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td>*)</td>
            <td colspan="3">Coret yang tidak perlu</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
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
          <tr height="20">
            <td height="20" colspan="22" align="center"><input type="button" name="bt_save" id="bt_save" class="tblTambah" value="Simpan" onclick="return simpan()" />
      <input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</div>
<div id="tampil_data">
<table width="972" border="0" align="center" cellpadding="2" cellspacing="0">
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
  <tr>
    <td width="5%">&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php
                    if($_REQUEST['report']!=1){
					?><input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="tambah(this.value);" class="tblTambah"/>
      <input type="button" id="btnHapus" name="btnHapus" value="Edit" onclick="edit();" class="tblTambah"/>
      <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus();" class="tblHapus"/><?php }?></td>
    <td width="6%"><button type="button" id="btnTree" name="btnTree" value="Tampilan Tree" onclick="cetak()" class="tblViewTree" >Cetak</button></td>
    <td width="20%">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="5" align="left"><div id="gridbox" style="width:1000px; height:300px; background-color:white; overflow:hidden;"></div>      
      <div id="paging" style="width:1000px;"></div></td>
    </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="15%">&nbsp;</td>
    <td width="54%">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
</body>
<script type="text/javascript">
        function simpan(action){
            if(ValidateForm('no_permintaan,mengenai,kepada,tgl_r,tgl_l,tgl_ra,hasil_lain')){
				$("#form1").ajaxSubmit({
					  success:function(msg)
					  {
						alert(msg);
						batal();
						goFilterAndSort();
						
					   },
					});
			
            }
        }
        
        /*function isiCombo(id,val,defaultId,targetId,evloaded){
            if(targetId=='' || targetId==undefined){
                targetId=id;
            }
            Request('../combo_utils.php?all=1&id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'ok');
        }*/

        //isiCombo('cakupan','','','cakupan','');

        /*function setCakupan(val){
            if(val == 4){
                document.getElementById('tr_cakupan').style.display = 'table-row';
            }
            else{
                document.getElementById('tr_cakupan').style.display = 'none';
            }
        }*/

        function ambilData(){		
            var sisip = a.getRowId(a.getSelRow()).split('|');
			 var p="id*-*"+sisip[0]+"*|*no_permintaan*-*"+sisip[1]+"*|*mengenai*-*"+sisip[2]+"*|*kepada*-*"+sisip[3]+"*|*tgl_r*-*"+sisip[4]+"*|*tgl_l*-*"+sisip[5]+"*|*tgl_ra*-*"+sisip[6]+"*|*hasil_lain*-*"+sisip[7]+"";
			 
			 //$('#alamat').val(sisip[2]);
			 
			 
            fSetValue(window,p);
        }

        
		function tambah()
		{
			document.getElementById('form1').reset();
			$('#form_input').slideDown(1000,function(){
		toggle();
		});
			//$('#tampil_data').slideUp(1000);
			$('#act').val('tambah');
		}
		
		function edit()
		{
            var id = document.getElementById("id").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(id=='')
				{
					alert("Pilih data terlebih dahulu untuk di update");
				}
				else
				{
					$('#act').val('edit');
					$('#form_input').slideDown(1000,function()
					{
						toggle();
					});
					
				}
        }
		
		function hapus()
		{
            var id = document.getElementById("id").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(id=='')
				{
					alert("Pilih data terlebih dahulu untuk dihapus");
				}
				else if(confirm("Anda yakin menghapus data ini ?"))
				{
					$('#act').val('hapus');
					$("#form1").ajaxSubmit(
							{
					  success:function(msg)
							{
						alert(msg);
						goFilterAndSort();
						
					  		},
						});
				}
				else
				{
					document.getElementById('id').value="";
				}
        }

        function batal()
		{
			$('#form_input').slideUp(1000,function(){
		//toggle();
		});
			//$('#tampil_data').slideDown(1000);
			document.getElementById('id').value="";
			//$('#gridbox').reset();
        }
		
		/*function resetF(){
			$('#act').val('tambah');
            var p="txtId*-**|*j_spher*-**|*j_cyl*-**|*j_axis*-**|*j_prism*-**|*j_base*-**|*j_spher2*-**|*j_cyl2*-**|*j_axis2*-**|*j_prism2*-**|*j_base2*-**|*j_pupil*-**|*d_spher*-**|*d_cyl*-**|*d_axis*-**|*d_prism*-**|*d_base*-**|*d_spher2*-**|*d_cyl2*-**|*d_axis2*-**|*d_prism2*-**|*d_base2*-**|*d_pupil*-*";
            fSetValue(window,p);
	
			}*/


        /*function konfirmasi(key,val)
		{
            //alert(val);
            var tangkap=val.split("*|*");
            
            if(key=='Error')
			{
                if(proses=='hapus')
				{				
                    alert('Tidak bisa menambah data karena '+alasan+'!');
                }              

            }
            else
			{
                if(proses=='tambah')
				{
                    alert('Tambah Berhasil');
                }
                else if(proses=='simpan')
				{
                    alert('Simpan Berhasil');
                }
                else if(proses=='hapus')
				{
                    alert('Hapus Berhasil');
                }
            }

        }*/

        function goFilterAndSort(grd){
            //alert("tmpt_layanan_utils.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
            a.loadURL("22.suratkuasapemberianinformasimed_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&id=<?=$id?>&idPel=<?=$idPel?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Data Surat Kuasa");
        a.setColHeader("NO,NO PERMINTAAN,HASIL RESUME MEDIS, HASIL LABORATORIUM,HASIL RADIOLOGI,HASIL LAIN-LAIN,TANGGAL INPUT PASIEN,PENGGUNA");
        a.setIDColHeader(",,,");
        a.setColWidth("20,100,100,100,100,100,90,100");
        a.setCellAlign("center,center,center,center,center,center,center,center");
        a.setCellHeight(20);
		a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("22.suratkuasapemberianinformasimed_util.php?id=<?=$id?>&idPel=<?=$idPel?>");
        a.Init();
		
		
		
		
		function cetak()
		{
			var id = document.getElementById("id").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(id==""){
				var rowidx =a.getRowId(a.getSelRow()).split('|');
				rowid=rowidx[0];
			 }	
				window.open("22.suratkuasapemberianinformasimed.php?id="+id+"&idPel=<?=$idPel?>&idUser=<?=$idUsr?>","_blank");
				document.getElementById('id').value="";			
		}
		
	/*function centang(tes,tes2){
		 var checkbox = document.form1.elements['rad_thd'];
		 var checkboxlp = document.form1.elements['rad_lp'];
		 
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
		if ( checkboxlp.length > 0 )
		{
		 for (i = 0; i < checkboxlp.length; i++)
			{
			  if (checkboxlp[i].value==tes2)
			  {
			   checkboxlp[i].checked = true;
			  }
		  }
		}
	}*/
	function toggle() {
    parent.alertsize(document.body.scrollHeight);
}

    </script>
</html>
