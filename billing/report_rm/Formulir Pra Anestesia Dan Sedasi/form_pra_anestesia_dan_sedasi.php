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
LEFT JOIN  
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
//include "setting.php";
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
	$('#jam1').timeEntry({show24Hours: true, showSeconds: true});
	$('#jam2').timeEntry({show24Hours: true, showSeconds: true});
	$('#jam3').timeEntry({show24Hours: true, showSeconds: true});
	$('#jam4').timeEntry({show24Hours: true, showSeconds: true});
});
</script>
        <script type="text/JavaScript">
            var arrRange = depRange = [];
        </script>
<title>Form Pra Anestesia & Sedasi</title>
<style type="text/css">
<!--
.style3 {font-size: 10px}
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
.style1 {
	font-size: 14px;
	font-weight: bold;
}
.style2 {font-size: 16px}
.style4 {font-size: 16px; font-weight: bold; }
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
<div id="tampil_input" align="center" style="display:block">
<form id="form1" name="form1" action="form_pra_anestesia_dan_sedasi_act.php">

<input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    			<input type="hidden" name="id" id="id"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
<table width="856" border="0" style="font:12px tahoma;">
  <tr>
    <td width="453"><img src="../catatan_pelaksanaan_transfusi/lambang.png" width="278" height="30" /></td>
    <td width="393"><table width="310" align="right" cellpadding="0" cellspacing="0" style="border:1px solid #000000; font:12px tahoma;">
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
        <td>Nama Lengkap </td>
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
    <td colspan="2"><div align="center" class="style1">
      <p class="style2">FORMULIR PRA ANESTESIA &amp; SEDASI </p>
      </div></td>
    </tr>
  <tr>
    <td colspan="2" style="font:12px tahoma;"><table width="849" border="1" style="border-collapse:collapse;">
      
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
                    <input name="r_men" type="radio" value="1" />
                    Y</label></td>
                  <td width="52"><label>
                    <input name="r_men" type="radio" value="0" />
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
                  <input name="r_mer" type="radio" value="1" />
                  Y</label></td>
                <td width="48"><label>
                  <input name="r_mer" type="radio" value="0" />
                  T</label></td>
                <td width="181">Sebanyak
                  <input name="mer_s" type="text" id="mer_s" size="15" /></td>
                <td width="96">Kopi/Teh/Cola </td>
                <td width="38"><label>
                  <input name="r_kop" type="radio" value="1" />
                  Y</label></td>
                <td width="44"><label>
                  <input name="r_kop" type="radio" value="0" />
                  T</label></td>
                <td width="221">Sebanyak
                  <input name="kop_s" type="text" id="kop_s" size="15" /></td>
              </tr>
              <tr>
                <td>Alkohol</td>
                <td>:</td>
                <td><label>
                  <input name="r_alk" type="radio" value="0" />
                  Y</label></td>
                <td><label>
                  <input name="r_alk" type="radio" value="1" />
                  T</label></td>
                <td>Sebanyak
                  <input name="alk_s" type="text" id="alk_s" size="15" /></td>
                <td>olahraga rutin </td>
                <td><label>
                  <input name="r_ola" type="radio" value="1" />
                  Y</label></td>
                <td><label>
                  <input name="r_ola" type="radio" value="0" />
                  T</label></td>
                <td>Sebanyak
                  <input name="ola_s" type="text" id="ola_s" size="15" /></td>
              </tr>
            </table></td>
            </tr>
          <tr>
            <td colspan="14"><strong>PENGOBATAN </strong>(Sebutkan dosis perhari dan lama konsumsi) </td>
          </tr>
          <tr>
            <td width="84">Obat resep : </td>
            <td colspan="4"><label>
              <textarea name="oba_res" id="oba_res"></textarea>
            </label></td>
            <td width="199">Obat bebas (Vitamin ; Herbal) </td>
            <td width="189"><textarea name="oba_beb" id="oba_beb"></textarea></td>
            <td width="104">&nbsp;</td>
            <td colspan="4">&nbsp;</td>
            </tr>
          <tr>
            <td colspan="14"><table width="667" height="97" border="0">
              <tr>
                <td width="119">Aspirin/Plavix rutin </td>
                <td width="49"><label>
                  <input name="r_asp" type="radio" value="1" />
                  Y</label></td>
                <td width="73"><label>
                  <input name="r_asp" type="radio" value="0" />
                  T</label></td>
                <td width="408">Dosis dan frekuensi :
                  <label>
                    <input name="dosis1" type="text" id="dosis1" />
                  </label></td>
              </tr>
              <tr>
                <td>Obat anti sakit</td>
                <td><label>
                  <input name="oba_ant" type="radio" value="1" />
                  Y</label></td>
                <td><label>
                  <input name="oba_ant" type="radio" value="0" />
                  T</label></td>
                <td>Dosis dan frekuensi :
                  <label>
                    <input name="dosis2" type="text" id="dosis2" />
                  </label></td>
              </tr>
              <tr>
                <td>Alergi obat </td>
                <td><label>
                  <input name="aler" type="radio" value="radiobutton" />
                  Y</label></td>
                <td><label>
                  <input name="radiobutton" type="radio" value="radiobutton" />
                  T</label></td>
                <td>Dosis dan frekuensi :
                  <label>
                    <input name="dosis3" type="text" id="dosis3" />
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
                    <textarea name="tipe_reaksi" id="tipe_reaksi"></textarea>
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
                  <input name="rk_perdarahan" type="radio" value="1" />
                  Y</label></td>
                <td width="42"><label>
                  <input name="rk_perdarahan" type="radio" value="1" />
                  T</label></td>
                <td width="53">&nbsp;</td>
                <td width="170">Serangan Jantung </td>
                <td width="47"><label>
                  <input name="rk_serangan" type="radio" value="1" />
                  Y</label></td>
                <td width="70"><label>
                  <input name="rk_serangan" type="radio" value="0" />
                  T</label></td>
              </tr>
              <tr>
                <td>Pembekuan darah yang tidak normal </td>
                <td><label>
                  <input name="rk_pembekuan" type="radio" value="1" />
                  Y</label></td>
                <td><label>
                  <input name="rk_pembekuan" type="radio" value="0" />
                  T</label></td>
                <td>&nbsp;</td>
                <td>Gangguan irama jantung </td>
                <td><label>
                  <input name="rk_gangguan" type="radio" value="1" />
                  Y</label></td>
                <td><label>
                  <input name="rk_gangguan" type="radio" value="0" />
                  T</label></td>
              </tr>
              <tr>
                <td>Permasalahan dalam pembiusan </td>
                <td><label>
                  <input name="rk_permasalahan" type="radio" value="1" />
                  Y</label></td>
                <td><label>
                  <input name="rk_permasalahan" type="radio" value="0" />
                  T</label></td>
                <td>&nbsp;</td>
                <td>Hipertensis</td>
                <td><label>
                  <input name="rk_hiper" type="radio" value="1" />
                  Y</label></td>
                <td><label>
                  <input name="rk_hiper" type="radio" value="0" />
                  T</label></td>
              </tr>
              <tr>
                <td>Demam tinggi paska operasi </td>
                <td><label>
                  <input name="rk_demam" type="radio" value="1" />
                  Y</label></td>
                <td><label>
                  <input name="rk_demam" type="radio" value="0" />
                  T</label></td>
                <td>&nbsp;</td>
                <td>Tuberkulosis</td>
                <td><label>
                  <input name="rk_tuberkulosis" type="radio" value="1" />
                  Y</label></td>
                <td><label>
                  <input name="rk_tuberkulosis" type="radio" value="0" />
                  T</label></td>
              </tr>
              <tr>
                <td>Diabetes (kencing Manis) </td>
                <td><label>
                  <input name="rk_diabet" type="radio" value="1" />
                  Y</label></td>
                <td><label>
                  <input name="rk_diabet" type="radio" value="0" />
                  T</label></td>
                <td>&nbsp;</td>
                <td>Penyakit berat lainnya </td>
                <td><label>
                  <input name="rk_penyakit" type="radio" value="1" />
                  Y</label></td>
                <td><label>
                  <input name="rk_penyakit" type="radio" value="0" />
                  T</label></td>
              </tr>
              <tr>
                <td>Jelaskan penyakit keluarga apabila di jawab &quot;Ya&quot; </td>
                <td colspan="6"><textarea name="rk_ya" cols="40" id="rk_ya"></textarea></td>
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
                  <input name="r_perdarahan" type="radio" value="1" />
                  Y</label></td>
                <td width="42"><label>
                  <input name="r_perdarahan" type="radio" value="0" />
                  T</label></td>
                <td width="38">&nbsp;</td>
                <td width="157">Mengorok</td>
                <td width="49"><label>
                  <input name="r_merokok2" type="radio" value="1" />
                  Y</label></td>
                <td width="71"><label>
                  <input name="r_merokok2" type="radio" value="0" />
                  T</label></td>
              </tr>
              <tr>
                <td>Pembekuan darah yang tidak normal </td>
                <td><label>
                  <input name="r_pembekuan" type="radio" value="1" />
                  Y</label></td>
                <td><label>
                  <input name="r_pembekuan" type="radio" value="0" />
                  T</label></td>
                <td>&nbsp;</td>
                <td>Hepatitis / sakit kuning </td>
                <td><label>
                  <input name="r_hepatitis" type="radio" value="1" />
                  Y</label></td>
                <td><label>
                  <input name="r_hepatitis" type="radio" value="0" />
                  T</label></td>
              </tr>
              <tr>
                <td>Sakit maag </td>
                <td><label>
                  <input name="r_sakitmaag" type="radio" value="1" />
                  Y</label></td>
                <td><label>
                  <input name="r_sakitmaag" type="radio" value="0" />
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
                  <input name="r_anemia" type="radio" value="1" />
                  Y</label></td>
                <td><label>
                  <input name="r_anemia" type="radio" value="0" />
                  T</label></td>
                <td>&nbsp;</td>
                <td>Penyakit berat lainnya </td>
                <td><label>
                  <input name="r_penyakit_berat" type="radio" value="1" />
                  Y</label></td>
                <td><label>
                  <input name="r_penyakit_berat" type="radio" value="0" />
                  T</label></td>
              </tr>
              <tr>
                <td>Serangan jantung/nyeri dada </td>
                <td><label>
                  <input name="r_serangan" type="radio" value="1" />
                  Y</label></td>
                <td><label>
                  <input name="r_serangan" type="radio" value="0" />
                  T</label></td>
                <td>&nbsp;</td>
                <td colspan="3">(<em>Khusus pasien anak</em>) </td>
                </tr>
              <tr>
                <td>Asma</td>
                <td><label>
                  <input name="r_asma" type="radio" value="1" />
                  Y</label></td>
                <td><label>
                  <input name="r_asma" type="radio" value="0" />
                  T</label></td>
                <td>&nbsp;</td>
                <td>Kejang</td>
                <td><label>
                  <input name="r_kejang" type="radio" value="1" />
                  Y</label></td>
                <td><label>
                  <input name="r_kejang" type="radio" value="0" />
                  T</label></td>
              </tr>
              <tr>
                <td>Diabetes (kencing Manis) </td>
                <td><label>
                  <input name="r_diabetes" type="radio" value="1" />
                  Y</label></td>
                <td><label>
                  <input name="r_diabetes" type="radio" value="0" />
                  T</label></td>
                <td>&nbsp;</td>
                <td>Penyakit bawaan lahir </td>
                <td><label>
                  <input name="r_penyakit_bawaan" type="radio" value="1" />
                  Y</label></td>
                <td><label>
                  <input name="r_penyakit_bawaan" type="radio" value="0" />
                  T</label></td>
              </tr>
              <tr>
                <td>Pingsan</td>
                <td><label>
                  <input name="r_pingsan" type="radio" value="1" />
                  Y</label></td>
                <td><label>
                  <input name="r_pingsan" type="radio" value="0" />
                  T</label></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>

              <tr>
                <td>Jelaskan penyakit keluarga apabila di jawab &quot;Ya&quot; </td>
                <td colspan="6"><textarea name="penyakit_keluarga_y" cols="40" id="penyakit_keluarga_y"></textarea></td>
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
                    <input name="r_transfusi_darah" type="radio" value="1" />
                    Y</label></td>
                  <td width="60"><label>
                    <input name="r_transfusi_darah" type="radio" value="0" />
                    T</label></td>
                  <td width="149">Bila Ya, tahun berapa ?</td>
                  <td colspan="2"><input name="transfusi_darah_y" type="text" id="transfusi_darah_y" /></td>
                </tr>
                <tr>
                  <td>Apakah pasien pernah dipaksa untuk diagnisis HIV ? </td>
                  <td><label>
                    <input name="r_hvi" type="radio" value="0" />
                    Y</label></td>
                  <td><label>
                    <input name="r_hvi" type="radio" value="0" />
                    T</label></td>
                  <td>Bila Ya, tahun berapa ?</td>
                  <td colspan="2"><input name="hiv_y" type="text" id="hiv_y" /></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>Hasil pemeriksaan HIV ? </td>
                  <td width="67"><label>
                    <input name="r_hiv_p" type="radio" value="1" />
                    Positif</label></td>
                  <td width="93"><label>
                    <input name="r_hiv_p" type="radio" value="0" />
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
              <input name="pasien_memakai[0]" type="checkbox" id="pasien_memakai[0]" value="0" />
              Lensa kontak</label></td>
          </tr>
          <tr>
            <td colspan="14"><label>
              <input name="pasien_memakai[1]" type="checkbox" id="pasien_memakai[1]" value="1" />
              Kacamata</label></td>
          </tr>
          <tr>
            <td colspan="14"><label>
              <input name="pasien_memakai[2]" type="checkbox" id="pasien_memakai[2]" value="2" />
              Alat bantu dengar</label></td>
          </tr>
          <tr>
            <td colspan="14"><label>
              <input name="pasien_memakai[3]" type="checkbox" id="pasien_memakai[3]" value="3" />
              Gigi palsu</label></td>
          </tr>
          <tr>
            <td height="25"><label>
              <input name="pasien_memakai[4]" type="checkbox" id="pasien_memakai[4]" value="4" />
              lain - lain </label></td>
            <td height="25" colspan="13"><label>
              <textarea name="pasien_memakai_l" cols="40" id="pasien_memakai_l"></textarea>
            </label></td>
            </tr>
          <tr>
            <td colspan="14">&nbsp;</td>
          </tr>
          <tr>
            <td height="44" colspan="14">Riwaat operasi tahun dan jenis operasi : 
              <textarea name="riwayat_op" cols="40" id="riwayat_op"></textarea></td>
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
                    <input name="lokal" type="text" id="lokal" />
/
<input name="lokal_reaksi" type="text" id="lokal_reaksi" />
                    </label></td>
                </tr>
                <tr>
                  <td>Anestesia regional - keluhan/reaksi</td>
                  <td>:
                    <label>
                    <input name="regional" type="text" id="regional" />
/
<input name="regional_reaksi" type="text" id="regional_reaksi" />
                    </label></td>
                </tr>
                <tr>
                  <td>Anestesia umum/sedasi - keluhan/reaksi</td>
                  <td>:
                    <label>
                    <input name="umum" type="text" id="umum" />
/
<input name="umum_reaksi" type="text" id="umum_reaksi" />
                    </label></td>
                </tr>
                <tr>
                  <td>Tanggal terakhir kali periksa ke dokter</td>
                  <td>:
                    <label>
                    <input name="tgl5" type="text" id="tgl5" />
                    </label></td>
                </tr>
                <tr>
                  <td>untuk penyakit / gangguan apa</td>
                  <td>:
                    <label>
                    <input name="untuk_penyakit" type="text" id="untuk_penyakit" />
/
<input name="gangguan_apa" type="text" id="gangguan_apa" />
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
                      <input name="jumlah_kehamilan" type="text" id="jumlah_kehamilan" size="5" />
                    </label></td>
                  <td width="168">Jumlah anak
                    <input name="jumlah_anak" type="text" id="jumlah_anak" size="5" /></td>
                  <td width="208">menstruasi terakhir
                    <input name="menst" type="text" id="menst" size="5" /></td>
                  <td width="65">menyusui</td>
                  <td width="49"><label>
                    <input name="r_menyusui" type="radio" value="1" />
                    Y</label></td>
                  <td width="56"><label>
                    <input name="r_menyusui" type="radio" value="0" />
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
            <td colspan="14"><div align="center"><span class="style4">FORMULIR PRA-ANESTESIA &amp; SEDASI </span></div></td>
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
                  <input name="r_hilangnya_gigi" type="radio" value="1" />
                  Y</label></td>
                <td width="86"><label>
                  <input name="r_hilangnya_gigi" type="radio" value="0" />
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
                  <input name="r_masalah_mob" type="radio" value="1" />
                  Y</label></td>
                <td><label>
                  <input name="r_masalah_mob" type="radio" value="0" />
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
                  <input name="r_leher_pendek" type="radio" value="1" />
                  Y</label></td>
                <td><label>
                  <input name="r_leher_pendek" type="radio" value="0" />
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
                  <input name="r_batuk" type="radio" value="1" />
                  Y</label></td>
                <td><label>
                  <input name="r_batuk" type="radio" value="0" />
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
                  <input name="r_sesak_napas" type="radio" value="1" />
                  Y</label></td>
                <td><label>
                  <input name="r_sesak_napas" type="radio" value="0" />
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
                <td height="32"><p>Baru saja menderita infeksi Saluran napas atas </p>                  </td>
                <td><label>
                  <input name="r_infeksi_saluran" type="radio" value="1" />
                  Y</label></td>
                <td><label>
                  <input name="r_infeksi_saluran" type="radio" value="0" />
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
                  <input name="r_sakit_dada" type="radio" value="1" />
                  Y</label></td>
                <td><label>
                  <input name="r_sakit_dada" type="radio" value="0" />
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
                  <textarea name="ket_kajian_sistem" cols="40" id="ket_kajian_sistem"></textarea>
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
              <?=$dP['no_rm'];?>&nbsp;&nbsp;&nbsp;&nbsp; Berat : 
              <?=$dP['no_rm'];?> &nbsp;&nbsp;&nbsp;&nbsp;Tekanan darah : 
              <?=$dP['no_rm'];?> &nbsp;&nbsp;&nbsp;&nbsp;Nadi : 
              <?=$dP['no_rm'];?> &nbsp;&nbsp;&nbsp;&nbsp;Suhu : 
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
                <td width="295"><input name="skor_mallempati" type="text" id="skor_mallempati" /></td>
                <td width="65">Gigi palsu </td>
                <td width="154"><input name="gigi_palsu" type="text" id="gigi_palsu" /></td>
              </tr>
              <tr>
                <td>Jantung </td>
                <td>:</td>
                <td><input name="jantung" type="text" id="jantung" /></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>Paru - paru </td>
                <td>:</td>
                <td><input name="paru-paru" type="text" id="paru-paru" /></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>Abdomen </td>
                <td>:</td>
                <td><input name="abdomen" type="text" id="abdomen" /></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>Tulang Belakang </td>
                <td>:</td>
                <td><input name="tulang_belakang" type="text" id="tulang_belakang" /></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>Ekstremitas </td>
                <td>:</td>
                <td><input name="ekstremitas" type="text" id="ekstremitas" /></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>Neurologi (bila dapat diperiksa) </td>
                <td>:</td>
                <td><input name="neurologi" type="text" id="neurologi" /></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>Keterangan</td>
                <td>:</td>
                <td><textarea name="ket_keadaan_umum" cols="40" id="ket_keadaan_umum"></textarea></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>              <label></label></td>
            </tr>
          
          <tr>
            <td colspan="14"><strong>LABORATORIUM</strong> (bila tersedia) </td>
          </tr>
          <tr>
            <td colspan="14"><table width="723" border="0" align="center">
              <tr>
                <td width="121">Hb/Ht</td>
                <td width="194">:
                  <input name="hb" type="text" id="hb" /></td>
                <td width="146">Leukosit</td>
                <td width="244">:
                  <input name="leukosit" type="text" id="leukosit" /></td>
              </tr>
              <tr>
                <td>PT</td>
                <td>:
                  <input name="pt" type="text" id="pt" /></td>
                <td>Trombosit</td>
                <td>:
                  <input name="trombosit" type="text" id="trombosit" /></td>
              </tr>
              <tr>
                <td>Glukosa darah </td>
                <td>:
                  <input name="glukosa_darah" type="text" id="glukosa_darah" /></td>
                <td>Rontgen dada </td>
                <td>:
                  <input name="rotgen_dada" type="text" id="rotgen_dada" /></td>
              </tr>
              <tr>
                <td>Tes Kehamilan </td>
                <td>:
                  <input name="tes_kehamilan" type="text" id="tes_kehamilan" /></td>
                <td>EKG (40 tahun keatas) </td>
                <td>:
                  <input name="ekg" type="text" id="ekg" /></td>
              </tr>
              <tr>
                <td height="20">Kalium</td>
                <td>:
                  <input name="kalium" type="text" id="kalium" /></td>
                <td>Na/CI</td>
                <td>:
                  <input name="na" type="text" id="na" /></td>
              </tr>
              <tr>
                <td>Ureum</td>
                <td>:
                  <input name="ureum" type="text" id="ureum" /></td>
                <td>kreatinin</td>
                <td>:
                  <input name="kreatinin" type="text" id="kreatinin" /></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td colspan="3">Keterangan Lain </td>
            <td colspan="11"> : 
              <textarea name="ket_lab" cols="40" id="ket_lab"></textarea></td>
            </tr>
          <tr>
            <td colspan="14">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="14"><table width="755" height="128" border="0" align="left">
              <tr>
                <td colspan="2"><strong>DIAGNOSIS (ICD X) </strong></td>
                <td width="427"><strong>ASA CLASSIFICATION  </strong></td>
              </tr>
              <tr>
                <td width="18" rowspan="2">1.</td>
                <td width="296" rowspan="2"><label>
                  <textarea name="diagnosis_1" cols="40" id="diagnosis_1"></textarea>
                  </label></td>
                <td><label>
                  <input name="cek_asa[0]" type="checkbox" id="cek_asa[0]" value="0" />
                  ASA 1 Pasien normal yang sehat</label></td>
              </tr>
              <tr>
                <td><label>
                  <input name="cek_asa[1]" type="checkbox" id="cek_asa[1]" value="1" />
                  ASA 2 Pasien dengan penyakit sismetik ringan</label></td>
              </tr>
              <tr>
                <td rowspan="2">2.</td>
                <td rowspan="2"><p>
                  <textarea name="diagnosis_2" cols="40" id="diagnosis_2"></textarea>
                </p>                  </td>
                <td><input name="cek_asa[2]" type="checkbox" id="cek_asa[2]" value="2" />
ASA 3 Pasien dengan penyakit sismetik berat </td>
              </tr>
              <tr>
                <td height="35"><input name="cek_asa[3]" type="checkbox" id="cek_asa[3]" value="3" />
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
              <input name="penyulit_1" type="text" id="penyulit_1" size="40" /></td>
            </tr>
          <tr>
            <td><label></label></td>
            <td colspan="2">&nbsp;</td>
            <td width="78">&nbsp;</td>
            <td colspan="10">2.
              <input name="penyulit_2" type="text" id="penyulit_2" size="40" /></td>
            </tr>
          <tr>
            <td colspan="14">&nbsp;</td>
          </tr>
          
          <tr>
            <td colspan="4"><strong>CATATAN TINDAK LANJUT </strong></td>
            <td colspan="10">:
              <label>
              <textarea name="catatan" cols="40" id="catatan"></textarea>
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
                  <input name="sedasi" type="text" id="sedasi" size="40" />
                </label></td>
                </tr>
              <tr>
                <td>GA</td>
                <td>:</td>
                <td colspan="4"><input name="ga" type="text" id="ga" size="40" /></td>
                </tr>
              <tr>
                <td>Regional</td>
                <td>:</td>
                <td width="103"><label>
                  <input name="regoinal" type="radio" value="0" />
                  Spinal</label></td>
                <td width="112"><label>
                  <input name="regional" type="radio" value="1" />
                  Epidural</label></td>
                <td width="96"><label>
                  <input name="regional" type="radio" value="2" />
                  Kaudal</label></td>
                <td width="289"><label>
                  <input name="regional" type="radio" value="3" />
                  Blok Perifer</label></td>
              </tr>
              <tr>
                <td>Lain-lain</td>
                <td>:</td>
                <td colspan="4"><input name="lain_sedasi" type="text" id="lain_sedasi" size="40" /></td>
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
                  <input name="t_husus" type="radio" value="0" />
                  Hipotensi</label></td>
                <td width="150"><label>
                  <input name="t_husus" type="radio" value="1" />
                  Ventilasi satu paru</label></td>
                <td width="69"><label>
                  <input name="t_husus" type="radio" value="2" />
                  TCI</label></td>
                <td width="81"><label>
                  <input name="t_husus" type="radio" value="3" />
                  Lain-lain</label></td>
                <td width="321"><label>
                  <input name="lain_t_husus" type="text" id="lain_t_husus" />
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
                  <input name="monitoring[0]" type="checkbox" id="monitoring[0]" value="0" />
                  EKG Lead </label></td>
                <td width="145"><input name="ekg" type="text" id="ekg" size="20" /></td>
                <td width="86"><label>
                  <input name="monitoring[1]" type="checkbox" id="monitoring[1]" value="1" />
                  SpO2</label></td>
                <td width="131"><input name="monitoring[2]" type="checkbox" id="monitoring[2]" value="2" />
Temp</td>
                <td width="87"><label>
                <input name="monitoring[6]" type="checkbox" id="monitoring[6]" value="6" />
Lain-lain</label></td>
                <td colspan="2"><label></label>                  <input name="monit_lain" type="text" id="monit_lain" size="20" /></td>
                </tr>
              <tr>
                <td><label>
                  <input name="monitoring[3]" type="checkbox" id="monitoring[3]" value="3" />
                  CVP</label></td>
                <td><input name="cvp" type="text" id="cvp" size="20" /></td>
                <td><label>
                  <input name="monitoring[4]" type="checkbox" id="monitoring[4]" value="4" />
                  Arteri line</label></td>
                <td><input name="arteri" type="text" id="arteri" size="20" /></td>
                <td><label>
                  <input name="monitoring[5]" type="checkbox" id="monitoring[5]" value="5" />
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
                  <input name="alk[0]" type="checkbox" id="alk[0]" value="0" />
                  Bronchoscopy</label></td>
                <td width="616">&nbsp;</td>
              </tr>
              <tr>
                <td><label>
                  <input name="alk[1]" type="checkbox" id="alk[1]" value="1" />
                  Glidescope</label></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><label>
                  <input name="alk[2]" type="checkbox" id="alk[2]" value="2" />
                  USG</label></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><label>
                  <input name="alk[0]" type="checkbox" id="alk[0]" value="3" />
                  Lain-lain</label></td>
                <td><label>: 
                  <input name="alk_lain" type="text" id="alk_lain" size="40" />
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
                  <input name="perawatan[0]" type="radio" value="0" />
                  Rawat Inap</label></td>
                <td colspan="6">&nbsp;</td>
              </tr>
              <tr>
                <td><label>
                  <input name="perawatan[1]" type="radio" value="1" />
                  Rawat Jalan</label></td>
                <td colspan="6">&nbsp;</td>
              </tr>
              <tr>
                <td><label>
                  <input name="perawatan[2]" type="radio" value="2" />
                  Rawat Khusus : </label></td>
                <td width="67"><label>
                  <input name="rk" type="radio" value="0" />
                  ICU</label></td>
                <td width="79"><label>
                  <input name="rk" type="radio" value="1" />
                  ICCU</label></td>
                <td width="74"><label>
                  <input name="rk" type="radio" value="2" />
                  HCU</label></td>
                <td width="85"><label>
                  <input name="rk" type="radio" value="3" />
                  PACU</label></td>
                <td width="76"><label>
                  <input name="rk" type="radio" value="5" />
                  Lain-lain</label></td>
                <td width="215"><input name="rk_lain" type="text" id="rk_lain" size="20" /></td>
                </tr>
              <tr>
                <td><label>
                  <input name="perawatan[3]" type="radio" value="3" />
                  APS</label></td>
                <td colspan="6"><label>:
                  <input name="asp_lain" type="text" id="asp_lain" size="40" />
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
                <td width="183"><input name="jam1" type="text" id="jam1" size="17" /></td>
                <td width="54">Tanggal</td>
                <td width="241"><input name="tgl1" type="text" id="tgl1" onclick="gfPop.fPopCalendar(document.getElementById('tgl1'),depRange);" size="20"/></td>
              </tr>
              <tr>
                <td>Pre medikasi </td>
                <td>:</td>
                <td>Jam</td>
                <td><input name="jam2" type="text" id="jam2" size="17" /></td>
                <td>Tanggal</td>
                <td><input name="tgl2" type="text" id="tgl2" onclick="gfPop.fPopCalendar(document.getElementById('tgl2'),depRange);" size="20"/></td>
              </tr>
              <tr>
                <td>Transportasi ke Kammar Bedah </td>
                <td>:</td>
                <td>Jam</td>
                <td><input name="jam3" type="text" id="jam3" size="17" /></td>
                <td>Tanggal</td>
                <td><input name="tgl3" type="text" id="tgl3" onclick="gfPop.fPopCalendar(document.getElementById('tgl3'),depRange);" size="20"/></td>
              </tr>
              <tr>
                <td>Rencana Operasi </td>
                <td>:</td>
                <td>Jam</td>
                <td><input name="jam4" type="text" id="jam4" size="17" /></td>
                <td>Tanggal</td>
                <td><input name="tgl4" type="text" id="tgl4" onclick="gfPop.fPopCalendar(document.getElementById('tgl4'),depRange);" size="20"/></td>
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
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2"><table width="800" border="0" align="center">
      <tr>
        <td width="790"></td>
      </tr>
      <tr>
        <td align="center"><input type="button" name="bt_save" id="bt_save" class="tblTambah" value="Simpan" onclick="return simpan()" /> 
          &nbsp;<input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/></td>
      </tr>
      </table></td>
  </tr>
</table>
</form>
</div>
<div id="tampil_data" align="center">
<table width="755" border="0" cellpadding="4" style="font:12px tahoma;">
<td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td colspan="2">
                      <input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="tambah(this.value);" class="tblTambah"/>
                      <input type="button" id="btnEdit" name="btnEdit" value="Edit" onclick="edit();" class="tblTambah"/>
                      <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus();" class="tblHapus"/>                    </td>
                    <td width="20%" align="right"><button type="button" id="btnTree" name="btnTree" value="Tampilan Tree" onclick="cetak()" class="tblViewTree" >Cetak</button></td>
                    <td width="5%">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="45%">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="left" colspan="3">
                        <div id="gridbox" style="width:900px; height:300px; background-color:white; overflow:hidden;"></div>
                        <div id="paging" style="width:900px;"></div></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="5">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
</table>
</div>
</body>
<script type="text/javascript">

		function toggle() {
    parent.alertsize(document.body.scrollHeight);
}


        function simpan(action){
            if(ValidateForm('nama')){
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
        
        function isiCombo(id,val,defaultId,targetId,evloaded){
            if(targetId=='' || targetId==undefined){
                targetId=id;
            }
            Request('../combo_utils.php?all=1&id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'ok');
        }

        //isiCombo('cakupan','','','cakupan','');

        function setCakupan(val){
            if(val == 4){
                document.getElementById('tr_cakupan').style.display = 'table-row';
            }
            else{
                document.getElementById('tr_cakupan').style.display = 'none';
            }
        }

        function ambilData(){		
            //var sisip = a.getRowId(a.getSelRow()).split('|');
			//$('diagnosa1').val(a.cellsGetValue(a.getSelRow(),3));
			//$('#id').val(sisip[0]);
			//$('#inObat').load("form_input_obat.php?id="+sisip[0]);
			//$('#act').val('edit');
			
					
            var sisip = a.getRowId(a.getSelRow()).split('|');
			 

			$('#id').val(sisip[0]);
			$('#tanggal').val(sisip[1]);
			$('#jam').val(sisip[2]);
			$('#anamnesis').val(sisip[3]);
			$('#hubungan').val(sisip[4]);
			$('#keluhan_utama').val(sisip[5]);
			$('#riwayat_ps').val(sisip[6]);
			$('#alergi').val(sisip[7]);
			$('#tahun').val(sisip[8]);
			$('#riwayat_pd').val(sisip[9]);
			$('#riwayat_pengobatan').val(sisip[10]);
			$('#riwayat_pdk').val(sisip[11]);
			$('#riwayat_pekerjaan').val(sisip[12]);
			
			


			
			//var p="id*-*"+sisip[0]+"*|*identitas*-*"+sisip[1]+"";
			 //$('#note').val(sisip[10]);
			 //cek(sisip[2]);
			 /*centang(sisip[5]);
			 centang2(sisip[8]);
			 centang3(sisip[9]);
			 centang4(sisip[11]);
			 centang5(sisip[13]);
			 centang6(sisip[14]);
			 centang7(sisip[17]);
			 centang8(sisip[19]);
			 centang9(sisip[20]);
			 cek(sisip[22]);*/
			 
			 /*$('#inObat').load("14.form_terapi_pulang.php?type=ESO&id="+sisip[0]);
			 $('#inObat2').load("14.form_kembali_kontrol.php?type=ESO&id="+sisip[0]);*/
			 $('#act').val('edit');
			 
			 
			 //$('#kronologis').val(sisip[2]);
			 //$('#tindakan').val(sisip[13]);
			 
            fSetValue(window,p);
			
        }

        function hapus(){
            var id = document.getElementById("id").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(id==''){
					alert("Pilih data terlebih dahulu");
				}else if(confirm("Anda yakin menghapus data ini ?")){
					$('#act').val('hapus');
					$("#form1").ajaxSubmit({
					  success:function(msg)
					  {
						alert(msg);
						resetF();
						goFilterAndSort();
					  },
					});
				}

        }
		
		function edit(){
            var id = document.getElementById("id").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(id==''){
					alert("Pilih data terlebih dahulu");
				}else{
					$('#act').val('edit');
					$('#tampil_input').slideDown(1000,function(){
		//toggle();
		});
				}

        }

        function batal(){
			//resetF();
			$('#tampil_input').slideUp(1000,function(){
		//toggle();
		});
        }
		
		function resetF(){
			$('#act').val('tambah');
			document.getElementById('form1').reset();
			//$('#id').val('');
			//$('#txt_anjuran').val('');
            $('#inObat').load("14.form_terapi_pulang.php");
			//centang(1,'L')
			}


        function konfirmasi(key,val){
            //alert(val);
            /*var tangkap=val.split("*|*");
            var proses=tangkap[0];
            var alasan=tangkap[1];
            if(key=='Error'){
                if(proses=='hapus'){				
                    alert('Tidak bisa menambah data karena '+alasan+'!');
                }              

            }
            else{
                if(proses=='tambah'){
                    alert('Tambah Berhasil');
                }
                else if(proses=='simpan'){
                    alert('Simpan Berhasil');
                }
                else if(proses=='hapus'){
                    alert('Hapus Berhasil');
                }
            }*/

        }

        function goFilterAndSort(grd){
            //alert("tmpt_layanan_utils.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
            a.loadURL("form_pra_anestesia_dan_sedasi_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Data Formulir Pra Anestesia & Sedasi");
        a.setColHeader("NO,NAMA PASIEN,TGL INPUT,PENGGUNA");
        a.setIDColHeader(",nama,,,");
        a.setColWidth("20,300,150,120");
        a.setCellAlign("center,center,center,center");
        a.setCellHeight(20);
        a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("form_pra_anestesia_dan_sedasi_util.php?idPel=<?=$idPel?>");
        a.Init();
		
		function tambah(){
			resetF();
			$('#tampil_input').slideDown(1000,function(){
		//toggle();
		});
			
			}
		
		
		/*function cetak()
		{
			var id = document.getElementById("id").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(id=='')
			{
				alert("Pilih data terlebih dahulu untuk di cetak");
			}
			
			else
			{	
				window.open("14.checklisttrasfusi.php?id="+id+"&idKunj=<?=$idKunj?>&idPel=<?=$idPel?>&idUser=<?=$idUser?>","_blank");
				document.getElementById('id').value="";
			}
			
		}*/
		function cetak(){
		 var id = document.getElementById("id").value;
		 if(id==""){
				var idx =a.getRowId(a.getSelRow()).split('|');
				id=idx[0];
			 }
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			//if(rowid==''){
//					alert("Pilih data terlebih dahulu");
//				}else{	
		window.open("form_pra_anestesia_dan_sedasi.php?id="+id+"&idKunj=<?=$idKunj?>&idPel=<?=$idPel?>&idUsr=<?=$idUsr?>","_blank");
		document.getElementById('id').value="";
				//}
		}
		function cek(tes){
		var val=tes.split(',');
		var list1 = document.form1.elements['c_chk[]'];
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			
			  if (list1[i].value==val[i])
			  {
			   list1[i].checked = true;
			  }else{
					list1[i].checked = false;
					}
		  }
		}
		}
		

 function addRowToTable()
        {
            //use browser sniffing to determine if IE or Opera (ugly, but required)
            var isIE = false;
            if(navigator.userAgent.indexOf('MSIE')>0){
                isIE = true;
            }
            //	alert(navigator.userAgent);
            //	alert(isIE);
            var tbl = document.getElementById('tblObat');
            var lastRow = tbl.rows.length;
            // if there's no header row in the table, then iteration = lastRow + 1
            var iteration = lastRow;
            var row = tbl.insertRow(lastRow);
            //row.id = 'row'+(iteration-1);
            row.className = 'itemtableA';
            //row.setAttribute('class', 'itemtable');
            row.onmouseover = function(){this.className='itemtableAMOver';};
            row.onmouseout = function(){this.className='itemtableA';};
            //row.setAttribute('onMouseOver', "this.className='itemtableMOver'");
            //row.setAttribute('onMouseOut', "this.className='itemtable'");

           /* // left cell
            var cellLeft = row.insertCell(0);
            var textNode = document.createTextNode(iteration-2);
            cellLeft.className = 'tdisikiri';
            cellLeft.appendChild(textNode);

            // right cell
            cellLeft = row.insertCell(1);
            textNode = document.createTextNode('-');
            cellLeft.className = 'tdisi';
            cellLeft.appendChild(textNode);*/

            // right cell
            var cellRight = row.insertCell(0);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'jam[]';
                el.id = 'jam[]';
            }else{
                el = document.createElement('<input name="jam[]"/>');
				jam();
            }
            el.type = 'text';
            el.className = 'jam';
			el.size = 10;
            el.value = '<?=date('H:i:s')?>';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

            if("<?php echo $edit;?>" == true){
                //generate id
                if(!isIE){
                    el = document.createElement('input');
                    el.name = 'id';
                    el.id = 'id';
                }else{
                    el = document.createElement('<input name="id" id="id" />');
                }
                el.type = 'text';
                cellRight.className = 'tdisi';
                cellRight.appendChild(el);
            }

 // right cell
            var cellRight = row.insertCell(1);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'td[]';
                el.id = 'td[]';
            }else{
                el = document.createElement('<input name="td[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;
            

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(2);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'nadi_t1[]';
                el.id = 'nadi_t1[]';
            }else{
                el = document.createElement('<input name="nadi_t1[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(3);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'respirasi_t1[]';
                el.id = 'respirasi_t1[]';
            }else{
                el = document.createElement('<input name="respirasi_t1[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;
            

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(4);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'suhu_t1[]';
                el.id = 'suhu_t1[]';
            }else{
                el = document.createElement('<input name="suhu_t1[]"/>');
            }
            el.type = 'text';
            el.value = '';
            el.className = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

// right cell
            var cellRight = row.insertCell(5);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'heparin[]';
                el.id = 'heparin[]';
            }else{
                el = document.createElement('<input name="heparin[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

// right cell
            var cellRight = row.insertCell(6);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'tmp[]';
                el.id = 'tmp[]';
            }else{
                el = document.createElement('<input name="tmp[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(7);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'ap[]';
                el.id = 'ap[]';
            }else{
                el = document.createElement('<input name="ap[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(8);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'qb[]';
                el.id = 'qb[]';
            }else{
                el = document.createElement('<input name="qb[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

// right cell
            var cellRight = row.insertCell(9);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'ufr[]';
                el.id = 'ufr[]';
            }else{
                el = document.createElement('<input name="ufr[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(10);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'ufg[]';
                el.id = 'ufg[]';
            }else{
                el = document.createElement('<input name="ufg[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

// right cell
            var cellRight = row.insertCell(11);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'keterangan[]';
                el.id = 'keterangan[]';
            }else{
                el = document.createElement('<input name="keterangan[]"/>');
            }
            el.type = 'text';
            el.value = '';
            el.className = 'inputan';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
 // right cell
                cellRight = row.insertCell(12);
                if(!isIE){
                    el = document.createElement('img');
                    el.setAttribute('onClick','if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);setDisable("del")}');
                }else{
                    el = document.createElement('<img name="img" onClick="if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);}"/>');
                }
                el.src = '../icon/del.gif';
                el.border = "0";
                el.width = "16";
                el.height = "16";
                el.className = 'proses';
                el.align = "absmiddle";
                el.title = "Klik Untuk Menghapus";

                //  cellRight.setAttribute('class', 'tdisi');
                cellRight.className = 'tdisi';
                cellRight.appendChild(el);

                //document.forms[0].txt_obat[iteration-3].focus();

                /*  // select cell
  var cellRightSel = row.insertCell(2);
  var sel = document.createElement('select');
  sel.name = 'satuan';
  sel.className = "txtinput";
  //sel.id = 'selRow'+iteration;
<?php
//echo $sel;
?>
//  sel.options[0] = new Option('text zero', 'value0');
//  sel.options[1] = new Option('text one', 'value1');
  cellRightSel.appendChild(sel);
                 */
        //document.getElementById('btnSimpan').disabled = true;
    }
function removeRowFromTable(cRow)
	{
        var tbl = document.getElementById('tblObat');
        var jmlRow = tbl.rows.length;
        if (jmlRow > 4)
		{
            var i=cRow.parentNode.parentNode.rowIndex;
            //if (i>2){
            tbl.deleteRow(i);
            var lastRow = tbl.rows.length;
            for (var i=3;i<lastRow;i++)
			{
                var tds = tbl.rows[i].getElementsByTagName('id');
                //tds[0].innerHTML=i-2;
            }
        }
    }

function addRowToTable2()
        {
            //use browser sniffing to determine if IE or Opera (ugly, but required)
            var isIE = false;
            if(navigator.userAgent.indexOf('MSIE')>0){
                isIE = true;
            }
            //	alert(navigator.userAgent);
            //	alert(isIE);
            var tbl = document.getElementById('tgl');
            var lastRow = tbl.rows.length;
            // if there's no header row in the table, then iteration = lastRow + 1
            var iteration = lastRow;
            var row = tbl.insertRow(lastRow);
            //row.id = 'row'+(iteration-1);
            row.className = 'itemtableA';
            //row.setAttribute('class', 'itemtable');
            row.onmouseover = function(){this.className='itemtableAMOver';};
            row.onmouseout = function(){this.className='itemtableA';};
            //row.setAttribute('onMouseOver', "this.className='itemtableMOver'");
            //row.setAttribute('onMouseOut', "this.className='itemtable'");

           /* // left cell
            var cellLeft = row.insertCell(0);
            var textNode = document.createTextNode(iteration-2);
            cellLeft.className = 'tdisikiri';
            cellLeft.appendChild(textNode);

            // right cell
            cellLeft = row.insertCell(1);
            textNode = document.createTextNode('-');
            cellLeft.className = 'tdisi';
            cellLeft.appendChild(textNode);*/

            // right cell
            var cellRight = row.insertCell(0);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'tgl[]';
                el.id = 'tgl[]';
				
            }else{
                el = document.createElement('<input name="tgl[]"/>');
            }
            el.type = 'text';
            el.className = 'tgl';
            el.value = '';
			el.size = '15';
			//el.onclick = 'gfPop.fPopCalendar(document.getElementById("tgl2"),depRange)';
			

            cellRight.className = 'tdisi2';
            cellRight.appendChild(el);

            if("<?php echo $edit;?>" == true){
                //generate id
                if(!isIE){
                    el = document.createElement('input');
                    el.name = 'id';
                    el.id = 'id';
                }else{
                    el = document.createElement('<input name="id" id="id" />');
                }
                el.type = 'text';
                cellRight.className = 'tdisi2';
                cellRight.appendChild(el);
            }

 // right cell
            var cellRight = row.insertCell(1);
			//var td3=x.insertCell(1);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'hari[]';
                el.id = 'hari[]';
            }else{
                //el = document.createElement('<select name="hari[]"> <option>Laki-laki</option><option>Perempuan</option></select>');
				el = document.createElement('<input name="hari[]"/>');
            }
            el.type = 'select';
            el.value = '';
			el.size = 15;
			el.select('<select name="hari[]"> <option>Laki-laki</option><option>Perempuan</option></select>');
			
            

            cellRight.className = 'tdisi2';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(2);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'jam[]';
                el.id = 'jam[]';
            }else{
                el = document.createElement('<input name="jam[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 15;

            cellRight.className = 'tdisi2';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(3);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'dokter[]';
                el.id = 'dokter[]';
            }else{
                el = document.createElement('<input name="dokter[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 30;
            

            cellRight.className = 'tdisi2';
            cellRight.appendChild(el);
			
// right cell
            

// right cell
            

// right cell
            
			
// right cell
            
			
// right cell
            

// right cell
            
			
// right cell
            

// right cell
            
			
 // right cell
                cellRight = row.insertCell(4);
                if(!isIE){
                    el = document.createElement('img');
                    el.setAttribute('onClick','if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable2(this);setDisable("del")}');
                }else{
                    el = document.createElement('<img name="img" onClick="if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable2(this);}"/>');
                }
                el.src = '../icon/del.gif';
                el.border = "0";
                el.width = "16";
                el.height = "16";
                el.className = 'proses';
                el.align = "absmiddle";
                el.title = "Klik Untuk Menghapus";

                //  cellRight.setAttribute('class', 'tdisi');
                cellRight.className = 'tdisi2';
                cellRight.appendChild(el);

                //document.forms[0].txt_obat[iteration-3].focus();

                /*  // select cell
  var cellRightSel = row.insertCell(2);
  var sel = document.createElement('select');
  sel.name = 'satuan';
  sel.className = "txtinput";
  //sel.id = 'selRow'+iteration;
<?php
//echo $sel;
?>
//  sel.options[0] = new Option('text zero', 'value0');
//  sel.options[1] = new Option('text one', 'value1');
  cellRightSel.appendChild(sel);
                 */
        //document.getElementById('btnSimpan').disabled = true;
   tanggalan();
    }
function removeRowFromTable2(cRow)
	{
        var tbl = document.getElementById('tgl');
        var jmlRow = tbl.rows.length;
        if (jmlRow > 3)
		{
            var i=cRow.parentNode.parentNode.rowIndex;
            //if (i>2){
            tbl.deleteRow(i);
            var lastRow = tbl.rows.length;
            for (var i=3;i<lastRow;i++)
			{
                var tds = tbl.rows[i].getElementsByTagName('td');
                //tds[0].innerHTML=i-2;
            }
        }
    }

/*tampil = function(cek) 
{
  if (cek.checked) 
  {
    $('#status').slideDown(600);
  } 
  else 
  {
    $('#status').slideUp(600);
  }
}*/
/*var appended = $('<div />').text("You're appendin'!");
appended.id = 'appended';*/
$('input:radio[name="radio[0]"]').change(
    function tampil(){
        if ($(this).val() == 3) {
            $('#status').slideDown(600);
        }
        else {
            $('#status').slideUp(600);
			//$('#status').checked(false);
			document.getElementById('_diet').value="";
        }
		
    });
	
$('input:radio[name="radio[0]"]').change(
    function tampil2(){
        if ($(this).val() == 4) {
            $('#status2').slideDown(600);
        }
        else {
            $('#status2').slideUp(600);
			document.getElementById('_batas').value="";
        }
    });
	
$('input:radio[name="radio[2]"]').change(
    function tampil3(){
        if ($(this).val() == '2') {
            $('#status3').slideDown(600);
        }
        else {
            $('#status3').slideUp(600);
        }
    });
	
$('input:radio[name="radio[6]"]').change(
    function tampil4(){
        if ($(this).val() == '3') {
            $('#status4').slideDown(600);
        }
        else {
            $('#status4').slideUp(600);
        }
    });
	
$('input:radio[name="radio[8]"]').change(
    function tampil5(){
        if ($(this).val() == '4') {
            $('#status5').slideDown(600);
        }
        else {
            $('#status5').slideUp(600);
        }
    });

/*function kejadian()
		{
			var nutrisi = document.getElementById('nutrisi').value;
			if(nutrisi=="Diet Khusus")
			{
				$('#status').slideDown(600);
				
			}
			else
			{
				$('#status').slideUp(600);
				$('#status').checked(false);
				document.getElementById('nutrisi').value="";
			}
			//document.getElementById('act').value = "edit";
			
		}
*/

    </script>
    <script>
var idrow = 3;

function tambahrow(){
    var x=document.getElementById('datatable').insertRow(idrow);
	var idx2 = $('.tanggal tr').length;
	var idx = idx2-3;
    var td1=x.insertCell(0);
    var td2=x.insertCell(1);
    var td3=x.insertCell(2);
    var td4=x.insertCell(3);
	var td5=x.insertCell(4);
	var td6=x.insertCell(5);
	var td7=x.insertCell(6);
	var td8=x.insertCell(7);
	var td9=x.insertCell(8);
	var td10=x.insertCell(9);
	var td11=x.insertCell(10);
	var td12=x.insertCell(11);
	
	
    td1.innerHTML="<input type='text' class='jam' size='10' name='jam[]' id='jam"+idx+"'>";jam();
	td2.innerHTML="<input type='text' id='td[]' name='td[]' size ='5'>";
    td3.innerHTML="<input type='text' id='nadi_t1[]' name='nadi_t1[]'  size='5'>";
    td4.innerHTML="<input type='text' id='respirasi_t1[]' name='respirasi_t1[]'  size='5'>";	
	td5.innerHTML="<input type='text' id='suhu_t1[]' name='suhu_t1[]'  size='5'>";
	td6.innerHTML="<input type='text' id='heparin[]' name='heparin[]'  size='5'>";
	td7.innerHTML="<input type='text' id='tmp[]' name='tmp[]'  size='5'>";
	td8.innerHTML="<input type='text' id='ap[]' name='ap[]'  size='5'>";
	td9.innerHTML="<input type='text' id='qb[]' name='qb[]'  size='5'>";
	td10.innerHTML="<input type='text' id='ufr[]' name='ufr[]'  size='5'>";
	td11.innerHTML="<input type='text' id='ufg[]' name='ufg[]'  size='5'>";
	td12.innerHTML="<input type='text' id='keterangan[]' name='keterangan[]'  size='10'>";
    idrow++;
}

function del(){
    if(idrow>3){
        var x=document.getElementById('datatable').deleteRow(idrow-1);
        idrow--;
    }
}

/*$('.tanggal').on('click', '.hapus',function(){
		if(confirm('Apakah anda yakin?')){
			var id = $(this).parents('tr.item').find('td:eq(0) input:eq(0)').val();
			var elm = $(this).parents('tr.item');
			$.ajax({
				type: 'post',
				data: 'type=delete&id='+id,
				url: '14.resume_kep_act.php',
				success: function(){
					elm.remove();
				}
			});
		}
	});*/
</script>
<script>
var idrow2 = 3;

function tambahrow2(){
    var x=document.getElementById('datatable2').insertRow(idrow2);
	var idx2 = $('.jam2 tr').length;
	var idx = idx2-3;
    var td1=x.insertCell(0);
    var td2=x.insertCell(1);
	var td3=x.insertCell(2);
 
    td1.innerHTML="<input type='text' class='jam2' size='10' name='jam2[]' id='jam2"+idx+"'>";jam2();
	td2.innerHTML="<textarea id='saran[]' name='saran[]' rows ='3' cols='70'>";
	td3.innerHTML="";
    idrow2++;
}

function del(){
    if(idrow>3){
        var y=document.getElementById('datatable2').deleteRow(idrow-1);
        idrow--;
    }
}

/*$('.tanggal').on('click', '.hapus',function(){
		if(confirm('Apakah anda yakin?')){
			var id = $(this).parents('tr.item').find('td:eq(0) input:eq(0)').val();
			var elm = $(this).parents('tr.item');
			$.ajax({
				type: 'post',
				data: 'type=delete&id='+id,
				url: '14.resume_kep_act.php',
				success: function(){
					elm.remove();
				}
			});
		}
	});*/
</script>
<script type="text/javascript">
function text0() {
document.getElementById("td_tidur2").value = "" + "" + document.getElementById("td_tidur").value + "\n" }
function text1() {
document.getElementById("duduk2").value = "" + "" + document.getElementById("duduk").value + "\n" }
function text2() {
document.getElementById("nadi2").value = "" + "" + document.getElementById("nadi").value + "\n" }
function text3() {
document.getElementById("respirasi2").value = "" + "" + document.getElementById("respirasi").value + "\n" }
function text4() {
document.getElementById("suhu2").value = "" + "" + document.getElementById("suhu").value + "\n" }
function text5() {
document.getElementById("keluhan2").value = "" + "" + document.getElementById("keluhan").value + "\n" }
function text6() {
document.getElementById("perawat11").value = "" + "" + document.getElementById("perawat1").value + "\n" }
function text7() {
document.getElementById("perawat22").value = "" + "" + document.getElementById("perawat2").value + "\n" }
</script>

<script>
$(document).ready(function(){
    var inpA = "input[rel=Ajumlah]";
    var inpB = "input[rel=Bjumlah]";
    
    $(inpA).bind('keyup',function() {
        var avalA=0;
        var bVal = parseInt($('#jumlah2').val(),10);
        $(inpA).each(function() {
            if(this.value !='') avalA += parseInt(this.value,10);
        });
        $('#jumlah').val(avalA);
        $('#total').val(avalA - bVal);
        console.log('Value avalA: ' + avalA);
    });
    
    $(inpB).bind('keyup',function() {
        var avalB=0;
        var aVal = parseInt($('#jumlah').val(),10);
        $(inpB).each(function() {
            if(this.value !='') avalB += parseInt(this.value,10);
        });
        $('#jumlah2').val(avalB);
        $('#total').val(aVal - avalB);
        console.log('Value avalB: ' + avalB);
    });
});

function enable_text(status)
{
status=!status;
document.form1.istirahat.disabled = status;
document.form1.tgl_mulai.disabled = status;
document.form1.tgl_akhir.disabled = status;
}
function enable_text2(status)
{
status=!status;
document.form1.inap.disabled = status;
document.form1.tgl_mulai2.disabled = status;
document.form1.tgl_akhir2.disabled = status;
}
function enable_text3(status)
{
status=!status;
document.form1.tgl_per.disabled = status;
}

function gantiUmur(){
            var val=document.getElementById('TglLahir').value;
            var dDate = new Date('<?php echo gmdate('Y,m,d',mktime(date('H')+7));?>');

            var tgl = val.split("-");
            var tahun = tgl[2];
            var bulan = tgl[1];
            var tanggal = tgl[0];
            //alert(tahun+", "+bulan+", "+tanggal);
            var Y = dDate.getFullYear();
            var M = dDate.getMonth()+1;
            var D = dDate.getDate();
            //alert(Y+", "+M+", "+D);
            Y = Y - tahun;
            M = M - bulan;
            D = D - tanggal;
            //M = pad(M+1,2,'0',1);
            //D = pad(D,2,'0',1);
            //alert(Y+", "+M+", "+D);
            if(D < 0){
                M -= 1;
                D = 30+D;
            }
            if(M < 0){
                Y -= 1;
                M = 12+M;
            }
            document.getElementById("th").value = Y;
            document.getElementById("Bln").value = M;
            document.getElementById("hari").value = D;
            //$("txtHari").value = D;
        }

        function gantiTgl()
        {
            var dDate = new Date('<?php echo gmdate('Y,m,d',mktime(date('H')+7));?>');
            var thn=(document.getElementById("th").value=='')?0:parseInt(document.getElementById("th").value);
            var bln=(document.getElementById("Bln").value=='')?0:parseInt(document.getElementById("Bln").value);
			var hari=(document.getElementById("hari").value=='')?0:parseInt(document.getElementById("hari").value);
			
			if(bln>11){
                var tmp = parseInt(bln/12);
                if(thn == ''){
                    thn = tmp;
                }
                else{
                    thn = thn+tmp;
                }
                document.getElementById('th').value = thn;
                tmp = bln%12;
                bln = tmp;
                document.getElementById('Bln').value = bln;
            }
            if(bln == ''){
                document.getElementById('Bln').value = 0;
            }
			
			if(hari == ''){
				document.getElementById('hari').value = 0;
			}

            var Y = dDate.getFullYear()-thn;
            var M = dDate.getMonth()-bln+1;
            var D = dDate.getDate()-hari;
            //alert(D+"-"+M+"-"+Y);
            
			
			var bulan = '';
			if((D-hari)>0){
				bulan = M;
			}
			else{
				bulan = M-1;	
			}
			
			var jD = '';
			if(bulan==1 || bulan==3 || bulan==5 || bulan==7 || bulan==8 || bulan==10 || bulan==12){
				jD = 31;
			}else if(bulan==2){
				if((thn%4==0) && (thn%100!=0)){
					jD = 29;
				}else{
					jD = 28;
				}
			}else{
				jD = 30;
			}
			
			if(D < 0){
                M -= 1;
                D = jD+D;
            }
            if(M < 0){
                Y -= 1;
                M = 12+M;
            }
			
            var nDate = new Date(M+"/"+D+"/"+Y);
            Y = nDate.getFullYear();
            M = nDate.getMonth()+1;
            D = nDate.getDate();
			
		
			if(hari>(jD-1)){
				var tmp = parseInt(hari/jD);
				if(bln == 0){
                    M = tmp;
                }
                else{
                    M = M+tmp;
                }
                document.getElementById('Bln').value = M;
                tmp = hari%jD;
                hari = tmp;
                document.getElementById('hari').value = hari;
			}
			
            nDate = D + "-" + M + "-" + Y;
			if (D<10){
				document.getElementById("TglLahir").value = "0" + D + "-" + M + "-" + Y;
			}else{
            	document.getElementById("TglLahir").value = nDate;
			}
        }

</script>
</html>
