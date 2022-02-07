<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Surat Pengantar Rawat</title>
<link rel="stylesheet" type="text/css" href="setting.css" />
<link type="text/css" rel="stylesheet" href="../../theme/mod.css">
<script src="js/jquery-1.8.3.js"></script>
<script src="js/jquery.form.js"></script>
<script language="JavaScript" src="../../theme/js/mod.js"></script>
<script language="JavaScript" src="../../theme/js/dsgrid.js"></script>
<script language="JavaScript" src="../../unit_pelayanan/iframe.js"></script>
<style>
textarea{
font:12px tahoma;
}
input[type='text']{
font:12px tahoma;
}
</style>
<style type="text/css">
<!--
.style1 {font-size: 36px}
.style3 {font-size: 24px}
-->
</style>
</head>
<?php
	include "setting.php";
	$query="select b.* FROM
  lap_srt_pengantar b where b.id='".$_REQUEST['id']."'";
	$is=mysql_fetch_array(mysql_query($query));
	
	$perawatan = explode(",", $is['set_perawatan']);
	$perawatan1 = $perawatan[0];
	$perawatan2 = $perawatan[1];
	$perawatan3 = $perawatan[2];
	
	$infeksi = explode(",", $is['set_infeksi']);
	$infeksi1 = $infeksi[0];
	$infeksi2 = $infeksi[1];
	
	$cito = explode(",", $is['set_cito']);
	$cito1 = $cito[0];
	$cito2 = $cito[1];
	
	$ruangan = explode(", ", $is['set_ruangan']);
	$ruangan1 = $ruangan[0];
	$ruangan2 = $ruangan[1];
	$ruangan3 = $ruangan[2];
	$ruangan4 = $ruangan[3];
	$ruangan5 = $ruangan[4];
	$ruangan6 = $ruangan[5];
	$ruangan7 = $ruangan[6];
	$ruangan8 = $ruangan[7];
?>
<body id="body">
<form id="form_pengantar" method="post" action="3.sr_pengantar_rawat_act.php">
<table width="900" border="0" style="font:12px tahoma">
  <tr>
    <td colspan="8"><table width="900" border="0" style="border-collapse:collapse">
      <tr>
        <td width="526" height="59" rowspan="2"><div align="center"><span class="style1">RS PELINDO I</span> </div></td>
        <td width="52" rowspan="2">&nbsp;</td>
        <td width="307" height="32" style="border-top:1px solid #000000; border-left:1px solid #000000; border-right:1px solid #000000"><div align="center"><span class="style3">SURAT PENGANTAR </span></div></td>
      </tr>
      <tr>
        <td height="35" style="border-bottom:1px solid #000000; border-left:1px solid #000000; border-right:1px solid #000000"><div align="center"><span class="style3">RAWAT</span></div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="7">
	<input type="hidden" name="id" id="id" size="5" />
	<input type="hidden" name="act" id="act" size="5" />
	<input type="hidden" name="kunjungan_id" id="kunjungan_id" value="<?php echo $_REQUEST['idKunj']; ?>" />
	<input type="hidden" name="pelayanan_id" id="pelayanan_id" value="<?php echo $_REQUEST['idPel']; ?>" /></td>
    <td width="1">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="8">Dengan Hormat, </td>
  </tr>
  <tr>
    <td colspan="8">Mohon diberikan perwatan dan atau disiapkan untuk : </td>
  </tr>
  <tr>
    <td width="83">&nbsp;</td>
    <td width="99">&nbsp;</td>
    <td width="59">&nbsp;</td>
    <td width="137">&nbsp;</td>
    <td width="22">&nbsp;</td>
    <td width="260">&nbsp;</td>
    <td width="212">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="right">
      <span style="padding:0px 2px 0px 2px; border:1px #000 solid;"><?php if($perawatan1=='Operasi'){?>&#10004;<?php }else{?>&#10006;<?php }?></span>
    </div></td>
    <td>Operasi</td>
    <td><div align="right">
      <span style="padding:0px 2px 0px 2px; border:1px #000 solid;"><?php if($perawatan2=='One Day Care'){?>&#10004;<?php }else{?>&#10006;<?php }?></span>
    </div></td>
    <td>One Day Care (ODC) </td>
    <td><div align="right">
      <span style="padding:0px 2px 0px 2px; border:1px #000 solid;"><?php if($perawatan3=='Rawat Inap'){?>&#10004;<?php }else{?>&#10006;<?php }?></span>
    </div></td>
    <td>Rawat Inap </td>
    <td>&nbsp;</td>
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
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">Nama Pasien </td>
    <td colspan="3">: <?=$nama?></td>
    <td><span style="padding:0px 2px 0px 2px; border:1px #000 solid;"><?php if($sex=='L'){?>&#10004;<?php }else{?>&#10006;<?php }?></span>  Laki - Laki / <span style="padding:0px 2px 0px 2px; border:1px #000 solid;"><?php if($sex=='P'){?>&#10004;<?php }else{?>&#10006;<?php }?></span> Perempuan</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="28">&nbsp;</td>
    <td colspan="2">No. MR </td>
    <td colspan="4"><table width="300" border="0" style="border-collapse:collapse">
  <tr>
	<td height="21">:
	  <?=$noRM?></td>
    </tr>
</table></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Umur</td>
    <td>&nbsp;</td>
    <td>: <?=$umur?> Tahun</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Diagnosis</td>
    <td>&nbsp;</td>
    <td colspan="3"> : <?=$diag?></td>
    <td><span style="padding:0px 2px 0px 2px; border:1px #000 solid;"><?php if($infeksi1=='Infeksi'){?>&#10004;<?php }else{?>&#10006;<?php }?></span>
Infeksi &nbsp;&nbsp;
<span style="padding:0px 2px 0px 2px; border:1px #000 solid;"><?php if($infeksi2=='Non infeksi'){?>&#10004;<?php }else{?>&#10006;<?php }?></span>
Non infeksi </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">Dokter yang merawat </td>
    <td colspan="4">: <?=$dokter?> </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">Jenis Tindakan/ Operasi  </td>
    <td colspan="4">: <?=$tindakan?> </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">Golongan Tindakan/Operasi </td>
    <td colspan="3">: <?=$klasifikasi?> </td>
    <td><span style="padding:0px 2px 0px 2px; border:1px #000 solid;"><?php if($cito1=='Cito'){?>&#10004;<?php }else{?>&#10006;<?php }?></span>
      Cito &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <span style="padding:0px 2px 0px 2px; border:1px #000 solid;"><?php if($cito2=='Non Cito'){?>&#10004;<?php }else{?>&#10006;<?php }?></span>
Non Cito </td>
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
  </tr>
  <tr>
    <td colspan="7">Terapi Sementara : </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Diet</td>
    <td colspan="5">: <?=$is['diet']?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Infus</td>
    <td colspan="5">: 
      <?=$is['infus']?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Obat</td>
    <td colspan="5">: <?=$is['obat']?></td>
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
  </tr>
  <tr>
    <td colspan="7">Persiapan : </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Sedia darah  </td>
    <td colspan="5">: 
      <?=$is['sedia_drh']?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Konsul</td>
    <td colspan="5">: 
      <?=$is['konsul']?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Lain-lain</td>
    <td colspan="5">: 
      <?=$is['lain_lain']?></td>
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
  </tr>
  <tr>
    <td colspan="2">Pemeriksaan yang telah dilakukan </td>
    <td colspan="5">: <?=$is['pemeriksaan']?></td>
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
  </tr>
  <tr>
    <td colspan="2">Ruangan yang dituju: </td>
    <td colspan="5">
	<span style="padding:0px 2px 0px 2px; border:1px #000 solid;"><?php if($ruangan1=='ICU'){?>&#10004;<?php }else{?>&#10006;<?php }?></span>ICU &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<span style="padding:0px 2px 0px 2px; border:1px #000 solid;"><?php if($ruangan2=='HCU'){?>&#10004;<?php }else{?>&#10006;<?php }?></span>HCU &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<span style="padding:0px 2px 0px 2px; border:1px #000 solid;"><?php if($ruangan3=='NICU'){?>&#10004;<?php }else{?>&#10006;<?php }?></span>NICU </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="5">	
	<span style="padding:0px 2px 0px 2px; border:1px #000 solid;"><?php if($ruangan4=='Perina'){?>&#10004;<?php }else{?>&#10006;<?php }?></span>
	Perina &nbsp;&nbsp;&nbsp;&nbsp;
	<span style="padding:0px 2px 0px 2px; border:1px #000 solid;"><?php if($ruangan5=='Biasa'){?>&#10004;<?php }else{?>&#10006;<?php }?></span>Biasa &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	<span style="padding:0px 2px 0px 2px; border:1px #000 solid;"><?php if($ruangan6=='Isolasi'){?>&#10004;<?php }else{?>&#10006;<?php }?></span>Isolasi </td>
</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="5"><span style="padding:0px 2px 0px 2px; border:1px #000 solid;"><?php if($ruangan7=='ODC'){?>&#10004;<?php }else{?>&#10006;<?php }?></span>
ODC &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 <span style="padding:0px 2px 0px 2px; border:1px #000 solid;"><?php if($ruangan8=='Lain'){?>&#10004;<?php }else{?>&#10006;<?php }?></span>
Lain <u><?=$is['lain_lain_ket']?></u></td>
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
  </tr>
  
  <tr>
    <td colspan="7"><table width="900" border="0">
      <tr>
        <td width="240">&nbsp;</td>
        <td width="356">&nbsp;</td>
        <td width="290" align="center">Medan, <?php echo tgl_ina(date("Y-m-d"))?> </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><div align="center">Dokter Periksa</div></td>
      </tr>
      <tr>
        <td height="73">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><div align="center">(<b><u><?=$usr['nama']?></u></b>)</div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><div align="center">Nama dan Tanda Tangan </div></td>
      </tr>
    </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7">      Beri tanda <img src="centang.png" width="14" height="19" /> pada jawaban yang dipilih </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7"><div align="center">
	<div align="center"><tr id="trTombol">
        <td class="noline" colspan="5" align="right"><input id="btnPrint" type="button" value="Print" onClick="cetak(document.getElementById('trTombol'));"/>
                <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/></td>
      </tr></div></td>
    <td>&nbsp;</td>
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