<?
include "../../koneksi/konek.php";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUser'];
$sqlP="SELECT tk.tgl_in,tk.tgl_out FROM b_tindakan_kamar tk 
LEFT JOIN b_pelayanan p ON p.id=tk.pelayanan_id
WHERE tk.pelayanan_id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
//include "setting.php";

$sql="SELECT a.*, 
DATE_FORMAT(a.tgl_rawat, '%d-%m-%Y %H:%i:%s') tgl_rawat_,
DATE_FORMAT(a.tgl_pindah, '%d-%m-%Y %H:%i:%s') tgl_pindah_
FROM b_serah_terima_pindah_ruang a
WHERE pelayanan_id = {$idPel} AND kunjungan_id = {$idKunj} ORDER BY serah_terima_id DESC";
$rows=mysql_fetch_array(mysql_query($sql));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Form Serah Terima Pasien Pindah Ruang</title>
</head>
<style>
.kotak{
border:1px solid #000000;
width:20px;
height:20px;
vertical-align:middle;
text-align:center;
}
</style>
<body>
<table width="800" border="0">
  <tr>
    <td><div align="center" style="font:bold 16px tahoma;">FORMULIR SERAH TERIMA PASIEN PINDAH RUANG</div></td>
  </tr>
</table>

<br />
<table width="800" border="0" cellspacing="0" style="font:12px tahoma; border:1px solid #000000;">
  <tr>
    <td style="font:bold 16px tahoma;"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table cellspacing="2" cellpadding="0">
      <col width="25" />
      <col width="35" />
      <col width="22" />
      <col width="20" />
      <col width="133" />
      <col width="23" span="6" />
      <col width="15" />
      <col width="92" />
      <col width="49" />
      <col width="30" />
      <col width="76" />
      <col width="25" span="6" />
      <tr height="21">
        <td height="21" colspan="5">Tanggal rawat</td>
        <td width="5">:</td>
        <td colspan="6"><?=$rows['tgl_rawat_']?></td>
        <td width="101"></td>
        <td colspan="3">Tanggal    pindah ruang:</td>
        <td colspan="6"><?=$rows['tgl_pindah_']?></td>
        </tr>
      <tr height="21">
        <td height="21" colspan="5">Dokter    DPJP</td>
        <td>:</td>
        <td colspan="6"><?=$rows['dokter_dpjp']?></td>
        <td></td>
        <td width="1"></td>
        <td width="32"></td>
        <td width="88"></td>
        <td width="5"></td>
        <td width="40"></td>
        <td width="3"></td>
        <td width="45"></td>
        <td width="1"></td>
        <td width="129"></td>
      </tr>
      <tr height="21">
        <td height="21" colspan="5">Dokter    Konsulen</td>
        <td>:</td>
        <td colspan="6"><?=$rows['dokter_konsul']?></td>
        <td></td>
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
      <tr height="21">
        <td height="21" colspan="5">Indikasi    saat pindah</td>
        <td>:</td>
        <td width="32"><div class="kotak"><?php if($rows['indikasi']=='DID'){?>&radic;<?php }?></div></td>
        <td width="9"></td>
        <td colspan="5">Dengan ijin Dokter</td>
        <td></td>
        <td><div class="kotak"><?php if($rows['indikasi']=='APK'){?>&radic;<?php }?></div></td>
        <td colspan="7">&nbsp;Atas permintaan keluarga</td>
        </tr>
      <tr height="26">
        <td width="66" height="26">&nbsp;</td>
        <td width="48"></td>
        <td width="1"></td>
        <td width="1"></td>
        <td width="77"></td>
        <td></td>
        <td></td>
        <td></td>
        <td width="32"></td>
        <td width="2"></td>
        <td width="27"></td>
        <td width="1"></td>
        <td></td>
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
        <td height="20" colspan="6">Keadaan    umum pasien saat pindah ruang</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="21">
        <td height="21" colspan="3">Kesadaran</td>
        <td></td>
        <td></td>
        <td>:</td>
        <td colspan="6"><?=$rows['kesadaran']?></td>
        <td></td>
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
      <tr height="21">
        <td height="21" colspan="4">Diagnosa    medis</td>
        <td></td>
        <td>:</td>
        <td colspan="6"><?=$rows['diagnosa']?></td>
        <td></td>
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
      <tr height="21">
        <td height="21" colspan="4">Tekanan    darah</td>
        <td></td>
        <td>:</td>
        <td colspan="2"><?=$rows['tekdarah']?></td>
        <td colspan="2">MmHg</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2">Pernafasan</td>
        <td>:</td>
        <td colspan="2"><?=$rows['pernafasan']?></td>
        <td colspan="3">x/menit</td>
      </tr>
      <tr height="21">
        <td height="21" colspan="2">Nadi</td>
        <td></td>
        <td></td>
        <td></td>
        <td>:</td>
        <td colspan="2"><?=$rows['nadi']?></td>
        <td colspan="3">x/menit</td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2">Suhu</td>
        <td>:</td>
        <td colspan="2"><?=$rows['suhu']?></td>
        <td>&deg; C</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="21">
        <td height="21" colspan="3">Berat    Badan</td>
        <td></td>
        <td></td>
        <td>:</td>
        <td colspan="2"><?=$rows['beratbadan']?></td>
        <td>Kg</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2">Tinggi Badan</td>
        <td>:</td>
        <td colspan="2"><?=$rows['tinggibadan']?></td>
        <td>Cm</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20" colspan="9">Alat    bantu yang masih terpasang saat pindah ruang</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <?php 
	  $alatbantu=explode(",",$rows["alatbantu"]);
	  ?>
        <td height="20" align="right"><div class="kotak"><?php if($alatbantu[0]=='1'){?>&radic;<?php }?></div></td>
        <td colspan="3">Tidak ada</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><div class="kotak"><?php if($alatbantu[1]=='1'){?>&radic;<?php }?></div></td>
        <td></td>
        <td colspan="2">NGT</td>
        <td></td>
        <td></td>
        <td><div class="kotak"><?php if($alatbantu[2]=='1'){?>&radic;<?php }?></div></td>
        <td>Karakter</td>
        <td></td>
        <td><div class="kotak"><?php if($alatbantu[3]=='1'){?>&radic;<?php }?></div></td>
        <td></td>
        <td colspan="3">Oksigen</td>
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
        <td height="20" align="right"><div class="kotak"><?php if($alatbantu[4]=='1'){?>&radic;<?php }?></div></td>
        <td>ETT</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><div class="kotak"><?php if($alatbantu[5]=='1'){?>&radic;<?php }?></div></td>
        <td></td>
        <td colspan="6">Lain-lain <strong><u><?=$rows["alatbantu_lain"]?></u></strong>.</td>
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
        <td height="20" colspan="5">Tindakan    Operasi</td>
        <td></td>
        <td></td>
        <td></td>
        <td><div class="kotak"><?php if($rows['tindakan_operasi']=='ya'){?>&radic;<?php }?></div></td>
        <td></td>
        <td>Ya</td>
        <td></td>
        <td></td>
        <td></td>
        <td><div class="kotak"><?php if($rows['tindakan_operasi']=='tidak'){?>&radic;<?php }?></div></td>
        <td>Tidak</td>
        <td></td>
        <td><div class="kotak"><?php if($rows['tindakan_operasi']=='jenis'){?>&radic;<?php }?></div></td>
        <td></td>
        <td colspan="2">Jenis</td>
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
      <?php
	  $mobilisasi=explode(",",$rows['mobilisasi']);
	  ?>
        <td height="20" colspan="7">Kemampuan    Mobilisasi pasien saat pindah</td>
        <td></td>
        <td><div class="kotak"><?php if($mobilisasi[0]=='1'){?>&radic;<?php }?></div></td>
        <td></td>
        <td colspan="3">Bedrest</td>
        <td></td>
        <td><div class="kotak"><?php if($mobilisasi[1]=='1'){?>&radic;<?php }?></div></td>
        <td>Kursi Roda</td>
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
        <td><div class="kotak"><?php if($mobilisasi[2]=='1'){?>&radic;<?php }?></div></td>
        <td></td>
        <td colspan="3">Tongkat</td>
        <td></td>
        <td><div class="kotak"><?php if($mobilisasi[3]=='1'){?>&radic;<?php }?></div></td>
        <td colspan="6">lain-lain <strong><u><?=$rows["mobilisasi_lain"]?></u></strong></td>
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
        <td height="20" colspan="5">Tingkat    ketergantungan&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td><div class="kotak"><?php if($rows['tingkat_ketergantungan']=='selfcare'){?>&radic;<?php }?></div></td>
        <td></td>
        <td colspan="3">Selfcare</td>
        <td></td>
        <td><div class="kotak"><?php if($rows['tingkat_ketergantungan']=='partialcare'){?>&radic;<?php }?></div></td>
        <td>Partial Care</td>
        <td></td>
        <td><div class="kotak"><?php if($rows['tingkat_ketergantungan']=='totalcare'){?>&radic;<?php }?></div></td>
        <td></td>
        <td colspan="3">Total care</td>
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
        <td colspan="22">Obat-obatan    yang masih dilanjutkan</td>
        </tr>
      
    </table></td>
  </tr>
  <tr>
  	<td height="72"><table width="798" border="1" cellpadding="0" cellspacing="0" style=" border-collapse:collapse;">
      <col width="25" />
      <col width="35" />
      <col width="22" />
      <col width="20" />
      <col width="133" />
      <col width="23" span="6" />
      <col width="15" />
      <col width="92" />
      <col width="49" />
      <col width="30" />
      <col width="76" />
      <col width="25" span="6" />
      <tr height="20">
        <td height="20" width="25"><div align="center"><strong>No</strong></div></td>
        <td colspan="4" width="210"><div align="center"><strong>Nama    Obat&nbsp;</strong></div></td>
        <td colspan="5" width="115"><div align="center"><strong>Dosis</strong></div></td>
        <td colspan="3" width="130"><div align="center"><strong>Jumlah</strong></div></td>
        <td colspan="9" width="305"><div align="center"><strong>Obat-obat    sisa</strong></div></td>
      </tr>
      <?php
	  $sqlCatat2 = "SELECT * FROM b_obat_pindah_ruang WHERE serah_terima_id = '".$rows['serah_terima_id']."' ";
	  $queryCatat2 = mysql_query($sqlCatat2);
	  $x=1;
	  while($rsCatat2 = mysql_fetch_array($queryCatat2)){
	  ?>
      <tr height="20">
        <td height="20"><div align="center"><?=$x?></div></td>
        <td colspan="4"><?=$rsCatat2['nama_obat']?></td>
        <td colspan="5"><?=$rsCatat2['dosis']?></td>
        <td colspan="3" align="center"><?=$rsCatat2['jumlah_obat']?></td>
        <td colspan="9"><?=$rsCatat2['sisa_obat']?></td>
      </tr>
      <?php
	  $x++;}?>
    </table></td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
  </tr>
  <tr>
    <td><table cellspacing="2" cellpadding="0">
      <col width="25" />
      <col width="35" />
      <col width="22" />
      <col width="20" />
      <col width="133" />
      <col width="23" span="6" />
      <col width="15" />
      <col width="92" />
      <col width="49" />
      <col width="30" />
      <col width="76" />
      <col width="25" span="6" />
      <tr height="20">
        <td height="20" colspan="5">Berkas yang disertakan:</td>
        <td width="42"></td>
        <td width="33"></td>
        <td width="41"></td>
        <td width="52"></td>
        <td width="19"></td>
        <td width="19"></td>
        <td width="12"></td>
        <td width="51"></td>
        <td width="68"></td>
        <td width="23"></td>
        <td width="27" align="left" valign="top"><table cellpadding="0" cellspacing="0">
              <tr>
                <td height="20" width="76"></td>
              </tr>
          </table></td>
        <td width="17"></td>
        <td width="16"></td>
        <td width="17"></td>
        <td width="17"></td>
        <td width="17"></td>
        <td width="77"></td>
      </tr>
      <tr height="20">
      <?php
	  $radiologi=explode(",",$rows['radiologi']);
	  $diagnostik=explode(",",$rows['diagnostik']);
	  ?>
        <td width="27" height="20">&nbsp;</td>
        <td width="16">&nbsp;</td>
        <td width="22"><div class="kotak"><?php if($radiologi[0]=='1'){?>&radic;<?php }?></div></td>
        <td colspan="2">Radiologi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :</td>
        <td>&nbsp;</td>
        <td><div class="kotak"><?php if($radiologi[1]=='1'){?>&radic;<?php }?></div></td>
        <td colspan="3">Thorax</td>
        <td colspan="3">jml <strong><u><?=$rows["thorax"]?></u></strong> lembar</td>
        <td colspan="2"><div class="kotak"><?php if($diagnostik[0]=='1'){?>&radic;<?php }?></div>Diagnostik</td>
        <td><div class="kotak"><?php if($diagnostik[1]=='1'){?>&radic;<?php }?></div></td>
        <td colspan="2">Echo</td>
        <td colspan="4">Jml <strong><u><?=$rows["echo"]?></u></strong> lembar</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td width="24"></td>
        <td width="97"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        <td>&nbsp;</td>
        <td><div class="kotak"><?php if($radiologi[2]=='1'){?>&radic;<?php }?></div></td>
        <td colspan="3">CT Scan</td>
        <td colspan="3">jml <strong><u><?=$rows["ctscan"]?></u></strong> lembar</td>
        <td></td>
        <td></td>
        <td height="20" width="27"><div class="kotak"><?php if($diagnostik[2]=='1'){?>&radic;<?php }?></div></td>
        <td colspan="2">EEG</td>
        <td colspan="4">Jml <strong><u><?=$rows["eeg"]?></u></strong> lembar</td>
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
        <td height="20" width="27">&nbsp;</td>
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
        <td>&nbsp;</td>
        <td><div class="kotak"><?php if($radiologi[3]=='1'){?>&radic;<?php }?></div></td>
        <td colspan="3">Lain-lain <strong><u><?=$rows["radiologi_lain"]?></u></strong></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td height="20" width="27"><div class="kotak"><?php if($diagnostik[3]=='1'){?>&radic;<?php }?></div></td>
        <td colspan="2">USG</td>
        <td colspan="4">Jml <strong><u><?=$rows["usg"]?></u></strong> lembar</td>
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
        <td>&nbsp;</td>
        <td><div class="kotak"><?php if($rows['laboratorium']!=''){?>&radic;<?php }?></div></td>
        <td colspan="2">Laboratorium&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :</td>
        <td>Jml</td>
        <td colspan="2"><strong><u><?=$rows['laboratorium']?></u></strong></td>
        <td colspan="3">lembar</td>
        <td></td>
        <td></td>
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
        <td height="20" colspan="7">Barang    pribadi milik pasien yang disertakan</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <?php
	  $barang=explode(",",$rows['barang']);
	  ?>
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
        <td><div class="kotak"><?php if($barang[0]=='1'){?>&radic;<?php }?></div></td>
        <td colspan="2">Gigi palsu</td>
        <td></td>
        <td><div class="kotak"><?php if($barang[1]=='1'){?>&radic;<?php }?></div></td>
        <td></td>
        <td colspan="5">Lain-lain <strong><u><?=$rows['barang_lain']?></u></strong>.</td>
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
        <td height="20" colspan="5">Tanda    bukti pasien pindah ruang</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <?php
	  $bukti=explode(",",$rows['bukti']);
	  ?>
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
        <td><div class="kotak"><?php if($bukti[0]=='1'){?>&radic;<?php }?></div></td>
        <td colspan="2">Ada</td>
        <td></td>
        <td><div class="kotak"><?php if($bukti[1]=='1'){?>&radic;<?php }?></div></td>
        <td></td>
        <td colspan="3">Tidak ada</td>
        <td></td>
        <td></td>
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
        <td>&nbsp;</td>
        <td><div class="kotak"><?php if($bukti[2]=='1'){?>&radic;<?php }?></div></td>
        <td colspan="5">Lain-lain <strong><u><?=$rows['bukti_lain']?></u></strong>.</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        <td height="20" colspan="6">Catatan    Khusus/rencana tindakan kep.</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
    <td><table cellspacing="0" cellpadding="0" border="1" style="border-collapse:collapse;">
      <col width="25" />
      <col width="35" />
      <col width="22" />
      <col width="20" />
      <col width="133" />
      <col width="23" span="6" />
      <col width="15" />
      <col width="92" />
      <col width="49" />
      <col width="30" />
      <col width="76" />
      <col width="25" span="6" />
      <tr height="20">
        <td height="20" width="25"><div align="center"><strong>No</strong></div></td>
        <td colspan="6" width="256"><div align="center"><strong>Pesanan</strong></div></td>
        <td colspan="7" width="248"><div align="center"><strong>Keterangan</strong></div></td>
        <td colspan="8" width="256"><div align="center"><strong>Instruksi</strong></div></td>
      </tr>
      <?php
	  $sqlCatat = "SELECT * FROM b_catatan_pindah_ruang WHERE serah_terima_id = '".$rows['serah_terima_id']."' ";
	  $queryCatat = mysql_query($sqlCatat);
	  $z=1;
	  while($rsCatat = mysql_fetch_array($queryCatat)){
	  ?>
      <tr height="20">
        <td height="20" align="center"><?=$z?></td>
        <td colspan="6"><?=$rsCatat['pesanan']?></td>
        <td colspan="7"><?=$rsCatat['keterangan']?></td>
        <td colspan="8"><?=$rsCatat['instruksi']?></td>
      </tr>
      <?php
	  $z++;}
	  ?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table cellspacing="0" cellpadding="0">
      <col width="25" />
      <col width="35" />
      <col width="22" />
      <col width="20" />
      <col width="133" />
      <col width="23" span="6" />
      <col width="15" />
      <col width="92" />
      <col width="49" />
      <col width="30" />
      <col width="76" />
      <col width="25" span="6" />
      <tr height="20">
        <td height="20" width="25">&nbsp;</td>
        <td width="35"></td>
        <td width="22"></td>
        <td width="20"></td>
        <td width="133"></td>
        <td width="23"></td>
        <td width="23"></td>
        <td width="23"></td>
        <td width="23"></td>
        <td width="23"></td>
        <td width="23"></td>
        <td width="15"></td>
        <td width="92"></td>
        <td width="49"></td>
        <td colspan="5" width="181">Medan,&nbsp;<?=tgl_ina(date('Y-m-d'))?></td>
        <td width="25"></td>
        <td width="25"></td>
        <td width="25"></td>
      </tr>
      <tr height="20">
        <td colspan="5" height="20">Perawat yang    menerima</td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5">PJ. Shift</td>
        <td></td>
        <td colspan="5">Perawat yang menyerahkan</td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        <td colspan="5" height="20">(&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.)</td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5">(&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.)</td>
        <td></td>
        <td colspan="5">(&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.)</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td colspan="5" height="20">Nama dan tanda    tangan</td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5">Nama dan tanda tangan</td>
        <td></td>
        <td colspan="5">Nama dan tanda tangan</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    </table></td>
  </tr>
</table>
<div id="trTombol" align="center" style="width:100%"><input type="submit" name="button" id="button" value="Cetak" onclick="cetak(document.getElementById('trTombol'));" />
   									<input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/></div>
</body>
</html>
<script>
    function cetak(tombol){
        tombol.style.visibility='collapse';
        if(tombol.style.visibility=='collapse'){
            if(confirm('Anda yakin mau mencetak ?')){
                setTimeout('window.print()','1000');
                setTimeout('window.close()','2000');
            }
            else{
                tombol.style.visibility='visible';
            }

        }
    }

</script>