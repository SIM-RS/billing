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
<title>Form Pengkajian Awal Medis</title>
<style type="text/css">
<!--
.style2 {
	font-size: 16px;
	font-weight: bold;
}
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
    <td colspan="2"><p align="center" class="style2">PENGKAJIAN AWAL MEDIS PASIEN</p>
      <p align="center" class="style2"> RAWAT INAP </p></td>
    </tr>
  <tr>
    <td colspan="2" style="font:12px tahoma;"><table width="800" border="1" style="border-collapse:collapse;">
      <tr>
        <td width="788"><table width="758" border="0">
            <tr>
              <td width="752">1. DATA IDENTITAS HARAP DITANYAKAN ULANG DENGAN MELIHAT IPRI </td>
            </tr>
            <tr>
              <td>2. DATA DASAR HARUS DIISI SELAMBAT-LAMBATNYA 24 JAM SETELAH PASIEN MASUK </td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="786" border="0">
            <tr>
              <td width="187" height="60">&nbsp;</td>
              <td width="124">Tanggal Pemeriksaam </td>
              <td colspan="2">:
                <?=$dG['tanggal'];?></td>
              <td width="99">Mulai Jam </td>
              <td width="183">:
                <?=$dG['jam'];?></td>
            </tr>
            <tr>
              <td>ANAMNESIS</td>
              <td><label>
                <input name="anamnesis" type="radio" value="0" <? if ($dG['anamnesis']=='0') { echo "checked='checked'";}?> disabled="disabled"/>
                Pasien sendiri / </label></td>
              <td width="124"><label>
                <input name="anamnesis" type="radio" value="1"<? if ($dG['anamnesis']=='1') { echo "checked='checked'";}?> disabled="disabled"/>
                Orang lain</label></td>
              <td colspan="3">hubungan : 
                <label>
                <?=$dG['hubungan'];?>
                </label></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td colspan="2">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>KELUHAN UTAMA : </td>
              <td colspan="3"><label>
                <?=$dG['keluhan_utama'];?>
              </label></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td colspan="2">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="27" colspan="6">RIWAYAT PENYAKIT SEKARANG : (termasuk keluhan tambahan, data pemeriksaan dan pengobatan yang digunakan) </td>
            </tr>
            <tr>
              <td height="81">&nbsp;</td>
              <td colspan="5"><label>
                <textarea name="riwayat_ps" cols="50" rows="4" id="riwayat_ps" disabled="disabled"><? echo $dG['riwayat_ps']; ?></textarea>
              </label></td>
            </tr>
            <tr>
              <td>ALERGI : </td>
              <td colspan="5"><textarea name="alergi" cols="50" rows="4" id="alergi" disabled="disabled"><? echo $dG['alergi']; ?></textarea></td>
            </tr>
            <tr>
              <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="6"><table width="539" border="1" align="center"  style="border-collapse:collapse;">
                  <tr>
                    <td width="260"><div align="center">
                        <p>RIWAYAT PENYAKIT DAHULU </p>
                      <p>thn :
                        <label>
                        <?=$dG['tahun'];?>
                        </label>
                        </p>
                    </div></td>
                    <td width="269"><div align="center">RIWAYAT PENGOBATAN </div></td>
                  </tr>
                  <tr>
                    <td><label>
                      <textarea name="riwayat_pd" cols="40" rows="3" id="riwayat_pd" disabled="disabled"> <? echo $dG['riwayat_pd']; ?></textarea>
                    </label></td>
                    <td><textarea name="riwayat_pengobatan" cols="40" rows="3" id="riwayat_pengobatan" disabled="disabled"><? echo $dG['riwayat_pengobatan']; ?></textarea>
                        <label></label></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="6">RIWAYAT PENYAKIT DALAM KELUARGA : (penyakit keturunan, penyakit menular dan penyakit kejiwaan) </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td colspan="5"><textarea name="riwayat_pdk" cols="50" rows="4" id="textarea2"disabled="disabled"><? echo $dG['riwayat_pdk']; ?> </textarea></td>
            </tr>
            <tr>
              <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="6">RIWAYAT PEKERJAAN, SOSIAL EKONOMI, KEJIWAAN DAN KEBIASAAN : (termasuk riwayat perkawinan, obstetri, imunisasi, tumbuh kembang) </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td colspan="5"><textarea name="riwayat_pekerjaan" cols="50" rows="4" id="textarea3" disabled="disabled"><? echo $dG['riwayat_pekerjaan']; ?></textarea></td>
            </tr>
            <tr>
              <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="6">&nbsp;</td>
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
        </tr><tr id="trTombol">
        <td class="noline" colspan="5" align="right"><div align="center">
          <input name="button" type="button" id="btnPrint" onclick="cetak(document.getElementById('trTombol'));" value="Print"/>
          <input name="button" type="button" id="btnTutup" onclick="window.close();" value="Tutup"/>
        </div></td>
      </tr><tr><td align="center"><div align="center"></div></td>
      </tr>
      </table></td>
  </tr>
</table>
</form>
</div>
<div id="tampil_data" align="center"></div>
</body>
<script type="text/JavaScript">

        function cetak(tombol){
            tombol.style.visibility='collapse';
            if(tombol.style.visibility=='collapse'){
                if(confirm('Anda Yakin Mau Mencetak ?')){
                    setTimeout('window.print()','1000');
                    setTimeout('window.close()','2000');
                }
                else{
                    tombol.style.visibility='visible';
                }

            }
        }
    </script>
<?php 
mysql_close($konek);
?>

</html>
