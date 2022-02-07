<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Riwayat Penyakit dan Pemeriksaan</title>
</head>
<style>
textarea{
font:12px tahoma;
}
input[type='text']{
font:12px tahoma;
}
</style>
<link rel="stylesheet" type="text/css" href="setting.css" />
<link type="text/css" rel="stylesheet" href="../../theme/mod.css">
<script src="js/jquery-1.8.3.js"></script>
<script src="js/jquery.form.js"></script>
<script language="JavaScript" src="../../theme/js/mod.js"></script>
<script language="JavaScript" src="../../theme/js/dsgrid.js"></script>
<script language="JavaScript" src="../../unit_pelayanan/iframe.js"></script>
<?php
	include "setting.php";
	$query="select b.* FROM
  lap_riw_penyakit b where b.id='".$_REQUEST['id']."'";
	$is=mysql_fetch_array(mysql_query($query));
?>
<body id="body">
<form id="from_riwayat" method="post" action="2.riwayat_penyakit_act.php">
<table width="832" border="0" align="center" cellpadding="2" cellspacing="2" style="font:12px tahoma;border:1px solid #999999; padding:5px; ">
  <tr>
    <td height="31" style="font:bold 14px tahoma;" valign="bottom">Riwayat Penyakit dan Pemeriksaan Jasmani </td>
    <td colspan="2"><table width="406" border="0" style="font:12px tahoma; border:1px solid #000;">
          <tr>
            <td width="116">Nama Pasien</td>
            <td width="10">:</td>
            <td width="264"><span class="gb"><?=$nama?></span>&nbsp;&nbsp;<span <?php if($sex=='L'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>L</span> / <span <?php if($sex=='P'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>P</span></td>
          </tr>
          <tr>
            <td>Tanggal Lahir</td>
            <td>:</td>
            <td><span class="gb"><?=$lahir?></span> /Usia: <span class="gb"><?=$umur?></span> Th</td>
          </tr>
          <tr>
            <td>No. R.M.</td>
            <td>:</td>
            <td><span class="gb"><?=$noRM?></span>&nbsp;No.Registrasi:<?=$no_reg?></td>
          </tr>
          <tr>
            <td>Ruang Rawat / Kelas</td>
            <td>:</td>
            <td><span class="gb"><?=$kamar?>/
          <?=$kelas?></span></td>
          </tr>
          <tr>
            <td>Alamat</td>
            <td>:</td>
            <td><span class="gb"><?=$alamat?></span></td>
          </tr>
        </table></td>
  </tr>
  <tr>
    <td><strong>ANAMNESIS</strong></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="336">Keluhan Utama </td>
    <td colspan="2">: 
	<input type="hidden" name="id" id="id" size="5" />
	<input type="hidden" name="act" id="act" size="5" />
    <?=$is['keluhan']?></textarea></td>
  </tr>
  <tr>
    <td>Perjalanan Penyakit</td>
    <td colspan="2">: 
	<input type="hidden" name="kunjungan_id" id="kunjungan_id" size="5" value="<?php echo $_REQUEST['idKunj']; ?>" />
	<input type="hidden" name="pelayanan_id" id="pelayanan_id" size="5" value="<?php echo $_REQUEST['idPel']; ?>" />
    <input type="hidden" name="idUsr" id="idUsr" size="5" value="<?php echo $_REQUEST['idUsr']; ?>" />
    <?=$is['perjalanan']?></td>
  </tr>
  <tr>
    <td>Penyakit Lain/Allergi Obat</td>
    <td colspan="2">: 
    <?=$is['penyakit_lain']?></td>
  </tr>
  <tr>
    <td>Penyakit-penyakit dahulu</td>
    <td colspan="2">: <?=$is['penyakit_dahulu']?></td>
  </tr>
  <tr>
    <td><strong>Pemeriksaan</strong></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Keadaan Umum</td>
    <td colspan="2">: 
    <?=$is['keadaan_umum']?></td>
  </tr>
  <tr>
    <td>Kesadaran</td>
    <td colspan="2">: 
    <?=$is['kesadaran']?></td>
  </tr>
  <tr>
    <td>BB</td>
    <td colspan="2">: 
    <?=$is['bb']?></td>
  </tr>
  <tr>
    <td>Pernafasan</td>
    <td colspan="2">: 
    <?=$is['pernafasan']?></td>
  </tr>
  <tr>
    <td>Suhu</td>
    <td colspan="2">: 
    <?=$is['suhu']?></td>
  </tr>
  <tr>
    <td>Kepala</td>
    <td colspan="2">: 
      <?=$is['kepala']?></td>
  </tr>
  <tr>
    <td>Mata</td>
    <td colspan="2">: 
      <?=$is['mata']?></td>
  </tr>
  <tr>
    <td>THT</td>
    <td colspan="2">: 
      <?=$is['tht']?></td>
  </tr>
  <tr>
    <td>Gigi mulut </td>
    <td colspan="2">: 
      <?=$is['gigi_mulut']?></td>
  </tr>
  <tr>
    <td>Leher</td>
    <td colspan="2">: 
      <?=$is['leher']?></td>
  </tr>
  <tr>
    <td>Paru-paru</td>
    <td colspan="2">: 
      <?=$is['paru_paru']?></td>
  </tr>
  <tr>
    <td>Jantung</td>
    <td colspan="2">: 
      <?=$is['jantung']?></td>
  </tr>
  <tr>
    <td>Abdomen</td>
    <td colspan="2">:    
      <?=$is['abdomen']?></td>
  </tr>
  <tr>
    <td>Extremitas </td>
    <td colspan="2">: 
      <?=$is['extremitas']?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>DIAGNOSIS KERJA </td>
    <td colspan="2">:
      <?=$is['diagnosis_kerja']?></td>
  </tr>
  <tr>
    <td>DIAGNOSIS DIFFERENSIAL </td>
    <td colspan="2">:
      <?=$is['diagnosis_diff']?>
      </td>
  </tr>
  <tr>
    <td>PENGOBATAN</td>
    <td colspan="2">:
      <?=$is['pengobatan']?>
      </td>
  </tr>
  <tr>
    <td>DIIT</td>
    <td colspan="2">:
      <?=$is['diit']?>
      </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>PEMERIKSAAN PENUNJANG </td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>1. Laboratorium </td>
    <td colspan="2">:
      <?=$is['lab']?>
      </td>
  </tr>
  <tr>
    <td>2. Radiologi </td>
    <td colspan="2">:
      <?=$is['radiologi']?>
      </td>
  </tr>
  <tr>
    <td>3. EKG </td>
    <td colspan="2">:
      <?=$is['ekg']?>
     </td>
  </tr>
  <tr>
    <td>4. Dan Lain-lain </td>
    <td colspan="2">:
      <?=$is['dll']?></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">Medan, <?php echo tgl_ina(date("Y-m-d"))?></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">Pukul : <?=date('H:i:s')?></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">Dokter Pemeriksa</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">(<b><u><?=$usr['nama']?></u></b>)</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td width="236" align="center">&nbsp;</td>
    <td width="238" align="center">Nama &amp; Tanda Tangan</td>
    </tr>
  <tr>
    <td colspan="3" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center">
	<div align="center"><tr id="trTombol">
        <td class="noline" colspan="5" align="right"><input id="btnPrint" type="button" value="Print" onClick="cetak(document.getElementById('trTombol'));"/>
                <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/></td>
      </tr></div></td>
    </tr>
</table>
</form>



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