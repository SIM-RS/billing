<?
include "../../koneksi/konek.php";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUsr'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,IFNULL(pg.nama,'-') AS dr_rujuk, a.ku as ku2, a.kesadaran as kes2,
a.bb as bb2, a.tensi as tensi2, a.rr as rr2, a.suhu as suhu2, a.nadi as nadi2
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
LEFT JOIN anamnese a ON a.KUNJ_ID=pl.kunjungan_id
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
//include "setting.php";
?>
<?php

$dG=mysql_fetch_array(mysql_query("select * from b_ms_pengkajian_awal_medis where id='$_REQUEST[id]'"));
?>
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
        <script type="text/javascript" src="../js/jquery.timeentry.js"></script>
<script>
$(function () 
{
	$('#jam').timeEntry({show24Hours: true, showSeconds: true});
});
</script>
        <script type="text/JavaScript">
            var arrRange = depRange = [];
        </script>
<title>Form Pra Anestesia & Sedasi</title>
<style type="text/css">
<!--
.style2 {
	font-size: 16px;
	font-weight: bold;
}
.style3 {font-size: 10px}
.style4 {font-size: 16px}
-->
</style>
</head>
<style>
        .gb{
	border-bottom:1px solid #000000;
}
.inputan{
	width:80px;
	}
.textArea{ width:97%;}
body{background:#FFF;}
</style>
<title>resume kep</title>
<?
//include "setting2.php";
?>

<body>
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
<div id="tampil_input" style="display:block">
<form id="form1" name="form1" action="form_penolakan_pemberian_darah_act.php">

<input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    			<input type="hidden" name="id" id="id"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
<table width="800" border="0" align="center" style="font:12px tahoma;">
  <tr>
    <td width="336"><img src="../catatan_pelaksanaan_transfusi/lambang.png" width="278" height="30" /></td>
    <td width="515"><table width="310" align="right" cellpadding="0" cellspacing="0" style="border:1px solid #000000; font:12px tahoma;">
      <col width="64" />
      <col width="92" />
      <col width="9" />
      <col width="64" span="3" />
      <tr height="20">
        <td width="13" height="20"></td>
        <td width="143">NRM</td>
        <td width="9">:</td>
        <td colspan="3"><?=$dP['no_rm'];?></td>
        </tr>
      <tr height="20">
        <td height="20"></td>
        <td>Nama</td>
        <td>:</td>
        <td colspan="3"><?=$dP['nama'];?></td>
        </tr>
      <tr height="20">
        <td height="20"></td>
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td width="64"><span <?php if($dP['sex']=='L'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>L</span> / <span <?php if($dP['sex']=='P'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>P</span></td>
        <td width="64"></td>
        <td width="64"></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>Tanggal Lahir</td>
        <td>:</td>
        <td colspan="3"><?=tglSQL($dP['tgl_lahir']);?></td>
        </tr>
      <tr height="20">
        <td height="20"></td>
        <td colspan="5">(Mohon diisi atau tempelkan stiker jika ada)</td>
      </tr>
      </table></td>
  </tr>
  <tr>
    <td colspan="2"><p align="center" class="style2"><span class="style4">FORMULIR PRA ANESTESIA &amp; SEDASI</span></p>
      </td>
    </tr>
  <tr>
    <td colspan="2" style="font:12px tahoma;"><table width="849" border="1" align="center" style="border-collapse:collapse;">
      <tr>
        <td width="839"><table width="825" border="0" align="center">
            <tr>
              <td colspan="5"><strong>Diisi Oleh Pasien </strong>:
                <?=$dP['nama'];?></td>
              <td colspan="2">&nbsp;</td>
              <td colspan="2">&nbsp;</td>
              <td width="1" colspan="3">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4"><strong>SOSIAL</strong></td>
              <td width="91">&nbsp;</td>
              <td colspan="2">&nbsp;</td>
              <td colspan="2">&nbsp;</td>
              <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
              <td height="27" colspan="14"><table width="777" border="0">
                  <tr>
                    <td width="88">Umur :
                      <?=$dP['no_rm'];?></td>
                    <td width="151">Jenis Kelamin : <span <?php if($dP['sex']=='L'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>L</span> / <span <?php if($dP['sex']=='P'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>P</span></td>
                    <td width="61">Manikah</td>
                    <td width="44"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td width="52"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                    <td width="355">pekerjaan
                      <input name="textfield22" type="text" size="15" /></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td height="21" colspan="4"><strong>KEBIASAAN</strong></td>
              <td colspan="10"><label></label></td>
            </tr>
            <tr>
              <td colspan="14"><table width="777" border="0">
                  <tr>
                    <td width="65">Merokok</td>
                    <td width="10">:</td>
                    <td width="36"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td width="48"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                    <td width="181">Sebanyak
                      <input name="textfield222" type="text" size="15" /></td>
                    <td width="96">Kopi/Teh/Cola </td>
                    <td width="42"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td width="47"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                    <td width="214">Sebanyak
                      <input name="textfield2223" type="text" size="15" /></td>
                  </tr>
                  <tr>
                    <td>Alkohol</td>
                    <td>:</td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                    <td>Sebanyak
                      <input name="textfield2222" type="text" size="15" /></td>
                    <td>olahraga rutin </td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                    <td>Sebanyak
                      <input name="textfield2224" type="text" size="15" /></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="14"><strong>PENGOBATAN </strong>(Sebutkan dosis perhari dan lama konsumsi) </td>
            </tr>
            <tr>
              <td width="84">Obat resep : </td>
              <td colspan="4"><label>
                <textarea name="textarea"></textarea>
              </label></td>
              <td width="199">Obat bebas (Vitamin ; Herbal) </td>
              <td width="189"><textarea name="textarea2"></textarea></td>
              <td width="104">&nbsp;</td>
              <td colspan="4">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="14"><table width="667" height="97" border="0">
                  <tr>
                    <td width="119">Aspirin/Plavix rutin </td>
                    <td width="49"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td width="73"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                    <td width="408">Dosis dan frekuensi :
                      <label>
                        <input type="text" name="textfield33" />
                      </label></td>
                  </tr>
                  <tr>
                    <td>Obat anti sakit</td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                    <td>Dosis dan frekuensi :
                      <label>
                        <input type="text" name="textfield34" />
                      </label></td>
                  </tr>
                  <tr>
                    <td>Alergi obat </td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                    <td>Dosis dan frekuensi :
                      <label>
                        <input type="text" name="textfield35" />
                      </label></td>
                  </tr>
                  <tr>
                    <td>Alergi makanan </td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                    <td>Dafar obat dan tipe reaksi :
                      <label>
                        <textarea name="textarea14"></textarea>
                      </label></td>
                  </tr>
                </table>
                  <label></label>
                  <label></label></td>
            </tr>
            <tr>
              <td colspan="14">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="14"><strong>RIWAYAT KELUARGA</strong> : Apakah keluarga pernah mendapat permasalahan seperti di bawah ini ? </td>
            </tr>
            <tr>
              <td colspan="14"><table width="718" height="196" border="0" align="center">
                  <tr>
                    <td width="264" height="30">Perdarahan yang tidak normal </td>
                    <td width="42"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td width="42"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                    <td width="53">&nbsp;</td>
                    <td width="170">Serangan Jantung </td>
                    <td width="47"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td width="70"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                  </tr>
                  <tr>
                    <td>Pembekuan darah yang tidak normal </td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                    <td>&nbsp;</td>
                    <td>Gangguan irama jantung </td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                  </tr>
                  <tr>
                    <td>Permasalahan dalam pembiusan </td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                    <td>&nbsp;</td>
                    <td>Hipertensis</td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                  </tr>
                  <tr>
                    <td>Demam tinggi paska operasi </td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                    <td>&nbsp;</td>
                    <td>Tuberkulosis</td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                  </tr>
                  <tr>
                    <td>Diabetes (kencing Manis) </td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                    <td>&nbsp;</td>
                    <td>Penyakit berat lainnya </td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                  </tr>
                  <tr>
                    <td>Jelaskan penyakit keluarga apabila di jawab &quot;Ya&quot; </td>
                    <td colspan="6"><textarea name="textarea4" cols="40"></textarea></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="14"><strong>RIWAYAT PENYAKIT PASIEN :</strong> Apakah pasien pernah menderita penyakit di bawah ini ? </td>
            </tr>
            <tr>
              <td colspan="14"><table width="721" height="243" border="0" align="center">
                  <tr>
                    <td width="264" height="30">Perdarahan yang tidak normal </td>
                    <td width="42"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td width="42"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                    <td width="38">&nbsp;</td>
                    <td width="157">Mengorok</td>
                    <td width="49"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td width="71"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                  </tr>
                  <tr>
                    <td>Pembekuan darah yang tidak normal </td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                    <td>&nbsp;</td>
                    <td>Hepatitis / sakit kuning </td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                  </tr>
                  <tr>
                    <td>Sakit maag </td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                    <td>&nbsp;</td>
                    <td>Hipertensis</td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                  </tr>
                  <tr>
                    <td>Anemia</td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                    <td>&nbsp;</td>
                    <td>Penyakit berat lainnya </td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                  </tr>
                  <tr>
                    <td>Serangan jantung/nyeri dada </td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                    <td>&nbsp;</td>
                    <td colspan="3">(<em>Khusus pasien anak</em>) </td>
                  </tr>
                  <tr>
                    <td>Asma</td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                    <td>&nbsp;</td>
                    <td>Kejang</td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                  </tr>
                  <tr>
                    <td>Diabetes (kencing Manis) </td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                    <td>&nbsp;</td>
                    <td>Penyakit bawaan lahir </td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                  </tr>
                  <tr>
                    <td>Pingsan</td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>Jelaskan penyakit keluarga apabila di jawab &quot;Ya&quot; </td>
                    <td colspan="6"><textarea name="textarea5" cols="40"></textarea></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="14">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="14"><table width="717" height="132" border="0" align="center">
                  <tr>
                    <td width="285">Apakah pasien pernah mendapat transfusi darah ? </td>
                    <td width="37"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td width="60"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                    <td width="149">Bila Ya, tahun berapa ?</td>
                    <td colspan="2"><input type="text" name="textfield4" /></td>
                  </tr>
                  <tr>
                    <td>Apakah pasien pernah dipaksa untuk diagnisis HIV ? </td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                    <td>Bila Ya, tahun berapa ?</td>
                    <td colspan="2"><input type="text" name="textfield42" /></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>Hasil pemeriksaan HIV ? </td>
                    <td width="67"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Positif</label></td>
                    <td width="93"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Negatif</label></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="2">&nbsp;</td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="14">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="14">Apakah pasien pemakai : </td>
            </tr>
            <tr>
              <td colspan="14"><label>
                <input type="checkbox" name="checkbox" value="checkbox" />
                Lensa kontak</label></td>
            </tr>
            <tr>
              <td colspan="14"><label>
                <input type="checkbox" name="checkbox2" value="checkbox" />
                Kacamata</label></td>
            </tr>
            <tr>
              <td colspan="14"><label>
                <input type="checkbox" name="checkbox3" value="checkbox" />
                Alat bantu dengar</label></td>
            </tr>
            <tr>
              <td colspan="14"><label>
                <input type="checkbox" name="checkbox4" value="checkbox" />
                Gigi palsu</label></td>
            </tr>
            <tr>
              <td height="25"><label>
                <input type="checkbox" name="checkbox5" value="checkbox" />
                lain - lain </label></td>
              <td height="25" colspan="13"><label>
                <textarea name="textarea6" cols="40"></textarea>
              </label></td>
            </tr>
            <tr>
              <td colspan="14">&nbsp;</td>
            </tr>
            <tr>
              <td height="44" colspan="14">Riwaat operasi tahun dan jenis operasi :
                <textarea name="textarea7" cols="40"></textarea></td>
            </tr>
            <tr>
              <td colspan="14">Jenis Anestesia yang digunakan dan sebutkan Keluhan / reaksi yang dialami : </td>
            </tr>
            <tr>
              <td colspan="14"><label></label>
                  <table width="644" border="0">
                    <tr>
                      <td>Anestesia lokal - keluhan/reaksi</td>
                      <td>:
                        <label>
                          <input type="text" name="textfield5" />
                          /
                          <input type="text" name="textfield6" />
                        </label></td>
                    </tr>
                    <tr>
                      <td>Anestesia regional - keluhan/reaksi</td>
                      <td>:
                        <label>
                          <input type="text" name="textfield54" />
                          /
                          <input type="text" name="textfield64" />
                        </label></td>
                    </tr>
                    <tr>
                      <td>Anestesia umum/sedasi - keluhan/reaksi</td>
                      <td>:
                        <label>
                          <input type="text" name="textfield55" />
                          /
                          <input type="text" name="textfield65" />
                        </label></td>
                    </tr>
                    <tr>
                      <td>Tanggal terakhir kali periksa ke dokter</td>
                      <td>:
                        <label>
                          <input type="text" name="textfield56" />
                          /
                          <input type="text" name="textfield66" />
                        </label></td>
                    </tr>
                    <tr>
                      <td>untuk penyakit / gangguan apa</td>
                      <td>:
                        <label>
                          <input type="text" name="textfield57" />
                          /
                          <input type="text" name="textfield67" />
                        </label></td>
                    </tr>
                </table></td>
            </tr>
            <tr>
              <td colspan="14">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="14"><strong>KHUSUS PASIEN PEREMPUAN : </strong></td>
            </tr>
            <tr>
              <td colspan="14"><label></label>
                  <table width="711" height="24" border="0">
                    <tr>
                      <td width="161">Jumlah kehamilan
                        <label>
                          <input name="textfield10" type="text" size="5" />
                        </label></td>
                      <td width="168">Jumlah anak
                        <input name="textfield102" type="text" size="5" /></td>
                      <td width="208">menstruasi terakhir
                        <input name="textfield103" type="text" size="5" /></td>
                      <td width="65">menyusui</td>
                      <td width="49"><label>
                        <input name="radiobutton" type="radio" value="radiobutton" />
                        Y</label></td>
                      <td width="56"><label>
                        <input name="radiobutton" type="radio" value="radiobutton" />
                        T</label></td>
                    </tr>
                  </table>
                <label></label></td>
            </tr>
            <tr>
              <td colspan="14">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="14"><p>&nbsp; &nbsp;Tanda Tangan Pasien, </p>
                  <p>&nbsp;</p>
                <p>(___________________)</p></td>
            </tr>
            <tr>
              <td colspan="14"><span class="style3">*Nama Pasie Yang Mengisi Formulir </span></td>
            </tr>
            <tr>
              <td colspan="14">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="14"><span class="style3"><em>Catatan : Pasien wajib menandatangani Formulir Pra-Anestesi bila dalam pengisian formulir ini tidak didampingi perawat </em></span></td>
            </tr>
            <tr>
              <td colspan="14">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="14"><div align="center"><span class="style2">FORMULIR PRA-ANESTESIA &amp; SEDASI </span></div></td>
            </tr>
            <tr>
              <td colspan="14">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="14"><strong>Diisi oleh Dokter </strong></td>
            </tr>
            <tr>
              <td colspan="14"><strong>KAJIAN SISTEM </strong></td>
            </tr>
            <tr>
              <td colspan="14"><table width="661" border="0" align="center">
                  <tr>
                    <td width="159">Hilangnya gigi </td>
                    <td width="41"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td width="86"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                    <td width="33">&nbsp;</td>
                    <td width="142">Muntah</td>
                    <td width="54"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td width="116"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                  </tr>
                  <tr>
                    <td>Masalah mobilisasi leher </td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                    <td>&nbsp;</td>
                    <td>Pingsan</td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                  </tr>
                  <tr>
                    <td>Leher pendek </td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                    <td>&nbsp;</td>
                    <td>Stroke</td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                  </tr>
                  <tr>
                    <td>Batuk</td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                    <td>&nbsp;</td>
                    <td>Kejang</td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                  </tr>
                  <tr>
                    <td>Sesak napas </td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                    <td>&nbsp;</td>
                    <td>Sedang hamil </td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                  </tr>
                  <tr>
                    <td height="32"><p>Baru saja menderita infeksi Saluran napas atas </p></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                    <td>&nbsp;</td>
                    <td>Kelainan tulang belakang </td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                  </tr>
                  <tr>
                    <td>Sakit dada </td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                    <td>&nbsp;</td>
                    <td>obesitas</td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                  </tr>
                  <tr>
                    <td>Denyut jantung tidak normal </td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Y</label></td>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      T</label></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="7">Keterangan :
                      <label>
                        <textarea name="textarea8" cols="40"></textarea>
                      </label></td>
                  </tr>
                  <tr>
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
            <tr>
              <td colspan="14"><strong>PEMERIKSAAN FISIK </strong></td>
            </tr>
            <tr>
              <td colspan="14">Tinggi :
                <?=$dP['no_rm'];?>
                &nbsp;&nbsp;&nbsp;&nbsp; Berat :
                <?=$dP['no_rm'];?>
                &nbsp;&nbsp;&nbsp;&nbsp;Tekanan darah :
                <?=$dP['no_rm'];?>
                &nbsp;&nbsp;&nbsp;&nbsp;Nadi :
                <?=$dP['no_rm'];?>
                &nbsp;&nbsp;&nbsp;&nbsp;Suhu :
                <?=$dP['no_rm'];?></td>
            </tr>
            <tr>
              <td colspan="14"><strong>KEADAAN UMUM </strong></td>
            </tr>
            <tr>
              <td colspan="14"><table width="737" border="0">
                  <tr>
                    <td width="186">Skor Mallampati
                      <label></label></td>
                    <td width="15">:</td>
                    <td width="295"><input type="text" name="textfield1222614" /></td>
                    <td width="65">Gigi palsu </td>
                    <td width="154"><input type="text" name="textfield12226142" /></td>
                  </tr>
                  <tr>
                    <td>Jantung </td>
                    <td>:</td>
                    <td><input type="text" name="textfield1222615" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>Paru - paru </td>
                    <td>:</td>
                    <td><input type="text" name="textfield1222616" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>Abdomen </td>
                    <td>:</td>
                    <td><input type="text" name="textfield1222617" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>Tulang Belakang </td>
                    <td>:</td>
                    <td><input type="text" name="textfield1222618" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>Ekstremitas </td>
                    <td>:</td>
                    <td><input type="text" name="textfield1222619" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>Neurologi (bila dapat diperiksa) </td>
                    <td>:</td>
                    <td><input type="text" name="textfield1222620" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>Keterangan</td>
                    <td>:</td>
                    <td><textarea name="textarea3" cols="40"></textarea></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
                  <label></label></td>
            </tr>
            <tr>
              <td colspan="14"><strong>LABORATORIUM</strong> (bila tersedia) </td>
            </tr>
            <tr>
              <td colspan="14"><table width="723" border="0" align="center">
                  <tr>
                    <td width="121">Hb/Ht</td>
                    <td width="194">:
                      <input type="text" name="textfield122262" /></td>
                    <td width="146">Leukosit</td>
                    <td width="244">:
                      <input type="text" name="textfield122268" /></td>
                  </tr>
                  <tr>
                    <td>PT</td>
                    <td>:
                      <input type="text" name="textfield122263" /></td>
                    <td>Trombosit</td>
                    <td>:
                      <input type="text" name="textfield122269" /></td>
                  </tr>
                  <tr>
                    <td>Glukosa darah </td>
                    <td>:
                      <input type="text" name="textfield122264" /></td>
                    <td>Rontgen dada </td>
                    <td>:
                      <input type="text" name="textfield1222610" /></td>
                  </tr>
                  <tr>
                    <td>Tes Kehamilan </td>
                    <td>:
                      <input type="text" name="textfield122265" /></td>
                    <td>EKG (40 tahun keatas) </td>
                    <td>:
                      <input type="text" name="textfield1222611" /></td>
                  </tr>
                  <tr>
                    <td height="20">Kalium</td>
                    <td>:
                      <input type="text" name="textfield122266" /></td>
                    <td>Na/CI</td>
                    <td>:
                      <input type="text" name="textfield1222612" /></td>
                  </tr>
                  <tr>
                    <td>Ureum</td>
                    <td>:
                      <input type="text" name="textfield122267" /></td>
                    <td>kreatinin</td>
                    <td>:
                      <input type="text" name="textfield1222613" /></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="3">Keterangan Lain </td>
              <td colspan="11"> :
                <textarea name="textarea10" cols="40"></textarea></td>
            </tr>
            <tr>
              <td colspan="14">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="14"><table width="755" height="128" border="0" align="left">
                  <tr>
                    <td colspan="2"><strong>DIAGNOSIS (ICD X) </strong></td>
                    <td width="427"><strong>ASA CLASSIFICATION </strong></td>
                  </tr>
                  <tr>
                    <td width="18" rowspan="2">1.</td>
                    <td width="296" rowspan="2"><label>
                      <textarea name="textarea11" cols="40"></textarea>
                    </label></td>
                    <td><label>
                      <input type="checkbox" name="checkbox6" value="checkbox" />
                      ASA 1 Pasien normal yang sehat</label></td>
                  </tr>
                  <tr>
                    <td><label>
                      <input type="checkbox" name="checkbox7" value="checkbox" />
                      ASA 2 Pasien dengan penyakit sismetik ringan</label></td>
                  </tr>
                  <tr>
                    <td rowspan="2">2.</td>
                    <td rowspan="2"><p>
                        <textarea name="textarea12" cols="40"></textarea>
                    </p></td>
                    <td><input type="checkbox" name="checkbox72" value="checkbox" />
                      ASA 3 Pasien dengan penyakit sismetik berat </td>
                  </tr>
                  <tr>
                    <td height="35"><input type="checkbox" name="checkbox73" value="checkbox" />
                      ASA 4 Pasien dengan penyakit sismetik berat yang mengancam nyawa </td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="14">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4"><strong>PENYULIT ANESTESIA LAIN </strong></td>
              <td colspan="10">1.
                <input name="textfield8" type="text" size="40" /></td>
            </tr>
            <tr>
              <td><label></label></td>
              <td colspan="2">&nbsp;</td>
              <td width="78">&nbsp;</td>
              <td colspan="10">2.
                <input name="textfield82" type="text" size="40" /></td>
            </tr>
            <tr>
              <td colspan="14">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4"><strong>CATATAN TINDAK LANJUT </strong></td>
              <td colspan="10">:
                <label>
                  <textarea name="textarea13" cols="40"></textarea>
                </label></td>
            </tr>
            <tr>
              <td colspan="14">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="14"><strong>PERENCANAAN ANESTESIA &amp; SEDASI </strong></td>
            </tr>
            <tr>
              <td colspan="14">Teknik Anestesia &amp; Sedasi : </td>
            </tr>
            <tr>
              <td colspan="14"><table width="743" height="75" border="0" align="center">
                  <tr>
                    <td width="97">Sedasi</td>
                    <td width="20">:</td>
                    <td colspan="4"><label>
                      <input name="textfield7" type="text" size="40" />
                    </label></td>
                  </tr>
                  <tr>
                    <td>GA</td>
                    <td>:</td>
                    <td colspan="4"><input name="textfield72" type="text" size="40" /></td>
                  </tr>
                  <tr>
                    <td>Regional</td>
                    <td>:</td>
                    <td width="103"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Spinal</label></td>
                    <td width="112"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Epidural</label></td>
                    <td width="96"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Kaudal</label></td>
                    <td width="289"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Blok Perifer</label></td>
                  </tr>
                  <tr>
                    <td>Lain-lain</td>
                    <td>:</td>
                    <td colspan="4"><input name="textfield73" type="text" size="40" /></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="14">Teknik Khusus : </td>
            </tr>
            <tr>
              <td colspan="14"><table width="742" border="0" align="center">
                  <tr>
                    <td width="99"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Hipotensi</label></td>
                    <td width="150"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Ventilasi satu paru</label></td>
                    <td width="69"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      TCI</label></td>
                    <td width="81"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Lain-lain</label></td>
                    <td width="321"><label>
                      <input type="text" name="textfield9" />
                    </label></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="14">Monitoring</td>
            </tr>
            <tr>
              <td colspan="14"><table width="744" height="38" border="0" align="center">
                  <tr>
                    <td width="91"><label>
                      <input type="checkbox" name="checkbox8" value="checkbox" />
                      EKG Lead </label></td>
                    <td width="145"><input name="textfield92" type="text" size="20" /></td>
                    <td width="86"><label>
                      <input type="checkbox" name="checkbox10" value="checkbox" />
                      SpO2</label></td>
                    <td width="131"><input type="checkbox" name="checkbox12" value="checkbox" />
                      Temp</td>
                    <td width="87"><label>
                      <input type="checkbox" name="checkbox14" value="checkbox" />
                      Lain-lain</label></td>
                    <td colspan="2"><label></label>
                        <input name="textfield9322" type="text" size="20" /></td>
                  </tr>
                  <tr>
                    <td><label>
                      <input type="checkbox" name="checkbox9" value="checkbox" />
                      CVP</label></td>
                    <td><input name="textfield93" type="text" size="20" /></td>
                    <td><label>
                      <input type="checkbox" name="checkbox11" value="checkbox" />
                      Arteri line</label></td>
                    <td><input name="textfield932" type="text" size="20" /></td>
                    <td><label>
                      <input type="checkbox" name="checkbox13" value="checkbox" />
                      BIS</label></td>
                    <td width="48">&nbsp;</td>
                    <td width="126">&nbsp;</td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="14">Alat Khusus : </td>
            </tr>
            <tr>
              <td colspan="14"><table width="741" border="0" align="center">
                  <tr>
                    <td width="115" height="18"><label>
                      <input type="checkbox" name="checkbox15" value="checkbox" />
                      Bronchoscopy</label></td>
                    <td width="616">&nbsp;</td>
                  </tr>
                  <tr>
                    <td><label>
                      <input type="checkbox" name="checkbox16" value="checkbox" />
                      Glidescope</label></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><label>
                      <input type="checkbox" name="checkbox17" value="checkbox" />
                      USG</label></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><label>
                      <input type="checkbox" name="checkbox18" value="checkbox" />
                      Lain-lain</label></td>
                    <td><label>:
                      <input name="textfield11" type="text" size="40" />
                    </label></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="14">perawatan pasce anestesia : </td>
            </tr>
            <tr>
              <td colspan="14"><table width="741" border="0" align="center">
                  <tr>
                    <td width="115" height="18"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Rawat Inap</label></td>
                    <td colspan="6">&nbsp;</td>
                  </tr>
                  <tr>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Rawat Jalan</label></td>
                    <td colspan="6">&nbsp;</td>
                  </tr>
                  <tr>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Rawat Khusus : </label></td>
                    <td width="67"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      ICU</label></td>
                    <td width="79"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      ICCU</label></td>
                    <td width="74"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      HCU</label></td>
                    <td width="85"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      PACU</label></td>
                    <td width="76"><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      Lain-lain</label></td>
                    <td width="215"><input name="jam2" type="text" id="jam2" size="20" /></td>
                  </tr>
                  <tr>
                    <td><label>
                      <input name="radiobutton" type="radio" value="radiobutton" />
                      APS</label></td>
                    <td colspan="6"><label>:
                      <input name="textfield112" type="text" size="40" />
                    </label></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="14"><strong>PERSIAPAN PRA ANESTESIA </strong></td>
            </tr>
            <tr>
              <td colspan="14"><table width="750" border="0" align="left">
                  <tr>
                    <td width="167">Puasa mulai </td>
                    <td width="42">:</td>
                    <td width="37">Jam</td>
                    <td width="167"><input name="jam1" type="text" id="jam1" size="20" /></td>
                    <td width="70">Tanggal</td>
                    <td width="241"><input name="tgl1" type="text" id="tgl1" onclick="gfPop.fPopCalendar(document.getElementById('tgl'),depRange);" size="20"/></td>
                  </tr>
                  <tr>
                    <td>Pre medikasi </td>
                    <td>:</td>
                    <td>Jam</td>
                    <td><input name="jam2" type="text" id="jam2" size="20" /></td>
                    <td>Tanggal</td>
                    <td><input name="tgl2" type="text" id="tgl2" onclick="gfPop.fPopCalendar(document.getElementById('tgl'),depRange);" size="20"/></td>
                  </tr>
                  <tr>
                    <td>Transportasi ke Kammar Bedah </td>
                    <td>:</td>
                    <td>Jam</td>
                    <td><input name="jam3" type="text" id="jam3" size="20" /></td>
                    <td>Tanggal</td>
                    <td><input name="tgl3" type="text" id="tgl3" onclick="gfPop.fPopCalendar(document.getElementById('tgl'),depRange);" size="20"/></td>
                  </tr>
                  <tr>
                    <td>Rencana Operasi </td>
                    <td>:</td>
                    <td>Jam</td>
                    <td><input name="jam4" type="text" id="jam4" size="20" /></td>
                    <td>Tanggal</td>
                    <td><input name="tgl4" type="text" id="tgl4" onclick="gfPop.fPopCalendar(document.getElementById('tgl'),depRange);" size="20"/></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="14">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="14">&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      
    </table></td>
  </tr>
  <tr>
    <td colspan="2"><table width="800" border="0" align="center">
      <tr>
        <td width="790"></td>
      </tr>
      <tr>
        <td align="center"><button onclick="window.print()" type="button">Print</button> 
	<button onclick="window.close()" type="button">Close</button></td>
      </tr>
      </table></td>
  </tr>
</table>
</form>
</div>
<div id="tampil_data" align="center"></div>
</body>
</html>
