<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sertifikat Medis Penyebab Kematian</title>
</head>
<?
include "setting.php";
$id=$_REQUEST['id'];
$pos="select * from sertifikat_kematian where pelayanan_id='$idPel' and kunjungan_id='$idKunj' and s_mati_id='".$_REQUEST['id']."'";
$isi=mysql_fetch_array(mysql_query($pos));
?>
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
<table width="800" border="0" style="font:12px tahoma;">
  <tr>
    <td><table width="316" border="0" style="border:1px solid #000000;" align="right">
      
      <tr>
        <td style="font:bold 16px tahoma;"><div align="center">SERTIFIKAT MEDIS PENYEBAB KEMATIAN</div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><strong>Rahasia</strong></td>
  </tr>
  <tr>
    <td><table cellspacing="0" cellpadding="2" style="border:1px solid #000000;">
      <col width="11" />
      <col width="20" />
      <col width="21" />
      <col width="20" />
      <col width="14" />
      <col width="148" />
      <col width="9" span="2" />
      <col width="20" span="11" />
      <col width="24" />
      <col width="20" span="5" />
      <col width="22" />
      <col width="20" span="13" />
      <col width="14" />
      <col width="11" />
      <tr height="16">
        <td height="16" width="11">&nbsp;</td>
        <td width="20"></td>
        <td width="21"></td>
        <td width="27"></td>
        <td width="20"></td>
        <td width="208"></td>
        <td width="9"></td>
        <td width="9"></td>
        <td width="24"></td>
        <td width="20"></td>
        <td width="28"></td>
        <td width="28"></td>
        <td width="28"></td>
        <td width="28"></td>
        <td width="28"></td>
        <td width="28"></td>
        <td width="28"></td>
        <td width="28"></td>
        <td width="20"></td>
        <td width="24"></td>
        <td width="20"></td>
        <td width="20"></td>
        <td width="20"></td>
        <td width="20"></td>
        <td width="20"></td>
        <td width="22"></td>
        <td width="20"></td>
        <td width="20"></td>
        <td width="34"></td>
        <td width="20"></td>
        <td width="20"></td>
        <td width="20"></td>
        <td width="20"></td>
        <td width="20"></td>
        <td width="20"></td>
        <td width="20"></td>
        <td width="20"></td>
        <td width="34"></td>
        <td width="20"></td>
        <td width="14"></td>
        <td width="110"></td>
      </tr>
      <tr height="16">
        <td height="16">&nbsp;</td>
        <td colspan="5">Bulan/Tahun</td>
        <td>:</td>
        <td></td>
        <td colspan="2"><div class="kotak"><? if(isset($isi[""])){echo $isi[""];}else{echo date('m');}?></div></td>
        <td>/</td>
        <td colspan="2"><div class="kotak" style="border:1px solid #000000;width:35px;height:20px;"><? if(isset($isi[""])){echo $isi[""];}else{echo date('Y');}?></div></td>
        <td></td>
        <td colspan="4">Nama RS :</td>
        <td colspan="11">RS PELINDO I</td>
        <td colspan="3">Kode RS:</td>
        <td><div class="kotak"></div></td>
        <td><div class="kotak"></div></td>
        <td><div class="kotak"></div></td>
        <td><div class="kotak"></div></td>
        <td><div class="kotak"></div></td>
        <td><div class="kotak"></div></td>
        <td><div class="kotak"></div></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="16">
        <td height="16">&nbsp;</td>
        <td colspan="5">No. Urut Pencatatan    Kematian</td>
        <td>:</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="6">No.Rekam Medis :</td>
        <td colspan="9"><?=$noRM?></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="16">
        <td height="16">&nbsp;</td>
        <td>I</td>
        <td colspan="4">Identitas Jenazah</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="16">
        <td height="16">&nbsp;</td>
        <td></td>
        <td>1</td>
        <td colspan="3">Nama lengkap</td>
        <td>:</td>
        <td></td>
        <td colspan="27"><u><?=strtoupper($nama)?></u></td>
        <td colspan="4">(Huruf cetak)</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="16">
        <td height="16">&nbsp;</td>
        <td></td>
        <td>2</td>
        <td colspan="3">No. Induk Kependudukan</td>
        <td>:</td>
        <td></td>
        <td colspan="7"><u><?=$ktp?></u></td>
        <td colspan="6">No. Kartu Keluarga:</td>
        <td colspan="18">&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="16">
        <td height="16">&nbsp;</td>
        <td></td>
        <td>3</td>
        <td colspan="3">Jenis Kelamin</td>
        <td>:</td>
        <td></td>
        <td><div class="kotak"><? if($sex=="L"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td colspan="3">Laki-laki</td>
        <td></td>
        <td><div class="kotak"><? if($sex=="P"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td colspan="4">Perempuan</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="16">
        <td height="16">&nbsp;</td>
        <td></td>
        <td>4</td>
        <td colspan="3">Tempat / Tanggal lahir</td>
        <td>:</td>
        <td></td>
        <td colspan="7"><u><?=$alamat2?></u></td>
        <td colspan="5">Tanggal <u><?=$tgllahir?></u>,</td>
        <td colspan="4">Bulan <u><?=$blnlahir?></u>,</td>
        <td colspan="5">Tahun <u><?=$thnlahir?></u>.</td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="16">
        <td height="16">&nbsp;</td>
        <td></td>
        <td>5</td>
        <td colspan="3">Agama</td>
        <td>:</td>
        <td></td>
        <td colspan="8"><u><?=$agama?></u></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="16">
        <td height="16">&nbsp;</td>
        <td></td>
        <td>6</td>
        <td colspan="3">Alamat</td>
        <td>:</td>
        <td></td>
        <td colspan="4">Jalan/Gang</td>
        <td></td>
        <td colspan="14"><u><?=$alamat2?></u></td>
        <td colspan="2">No&hellip;&hellip;&hellip;</td>
        <td colspan="2">RT :</td>
        <td colspan="2"><u><?=$rt?></u></td>
        <td colspan="6">RW : <u><?=$rw?></u></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="16">
        <td height="16">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5">Kelurahan/Desa</td>
        <td colspan="14"><u><?=$desa?></u>.</td>
        <td colspan="13">Kecamatan <u><?=$kec?></u>.</td>
        <td></td>
      </tr>
      <tr height="16">
        <td height="16">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5">Kota/Kabupaten</td>
        <td colspan="14"><u><?=$kota?></u>.</td>
        <td colspan="3">Kode Pos</td>
        <td colspan="10">&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;</td>
        <td></td>
      </tr>
      <tr height="16">
        <td height="16">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="3">Telepon</td>
        <td></td>
        <td></td>
        <td colspan="16"><u><?=$telp?></u></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="16">
        <td height="16">&nbsp;</td>
        <td></td>
        <td>7</td>
        <td colspan="3">Status Kependudukan</td>
        <td>:</td>
        <td></td>
        <td><div class="kotak"><? $t1=explode(",",$isi["statuspenduduk"]);?><? if($t1[0]=="1"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td colspan="3">Penduduk</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><div class="kotak"><? if($t1[1]=="2"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td colspan="5">Bukan Penduduk</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="8" style="display:none;">
        <td height="8">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="16" style="display:none;">
        <td height="16">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="3">Hubungan dengan</td>
        <td>:</td>
        <td></td>
        <td><div class="kotak"><? $t1=explode(",",$isi["hubungan"]);?><? if($t1[0]=="1"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td colspan="7">Kepala Rumah Tangga</td>
        <td><div class="kotak"><? if($t1[1]=="2"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td colspan="4">Suami/Istri</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><div class="kotak"><? if($t1[2]=="3"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td colspan="2">Anak</td>
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
      <tr height="8" style="display:none;">
        <td height="8">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="16" style="display:none;">
        <td height="16">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="3">Kepala Rumah Tangga</td>
        <td>:</td>
        <td></td>
        <td><div class="kotak"><? $t1=explode(",",$isi["kepala"]);?><? if($t1[0]=="1"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td colspan="3">Menantu</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><div class="kotak"><? if($t1[1]=="2"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td colspan="2">Cucu</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><div class="kotak"><? if($t1[2]=="3"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td colspan="6">Orang Tua/Mertua</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="7" style="display:none;">
        <td height="7">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="16" style="display:none;">
        <td height="16">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><div class="kotak"><? if($t1[3]=="4"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td colspan="4">Famili lain</td>
        <td></td>
        <td></td>
        <td></td>
        <td><div class="kotak"><? if($t1[4]=="5"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td colspan="7">Pembantu Rumah Tangga</td>
        <td></td>
        <td></td>
        <td><div class="kotak"><? if($t1[5]=="6"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td colspan="3">Lain-lain</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="16">
        <td height="16">&nbsp;</td>
        <td></td>
        <td>8</td>
        <td colspan="3">Waktu meninggal</td>
        <td>:</td>
        <td></td>
        <td colspan="10">Tanggal, <u><?=$tglmati?></u></td>
        <td colspan="7">Bulan, <u><?=$blnmati?></u></td>
        <td colspan="8">Tahun <u><?=$thnmati?></u></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="16">
        <td height="16">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="3">Umur saat meninggal</td>
        <td>:</td>
        <td></td>
        <td colspan="6"><u><?=$umurmati?></u> Tahun</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="16" style="display:none;">
        <td height="16">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="3">Tempat meninggal</td>
        <td>:</td>
        <td></td>
        <td><div class="kotak"><? $t1=explode(",",$isi["tempat"]);?><? if($t1[0]=="1"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td colspan="4">Rumah Sakit</td>
        <td></td>
        <td></td>
        <td></td>
        <td><div class="kotak"><? if($t1[1]=="2"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td colspan="4">Puskesmas</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><div class="kotak"><? if($t1[2]=="3"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td colspan="5">Rumah Bersalin</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="6" style="display:none;">
        <td height="6">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="16" style="display:none;">
        <td height="16">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><div class="kotak"><? if($t1[3]=="4"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td colspan="7">Rumah Tempat Tinggal</td>
        <td><div class="kotak"><? if($t1[4]=="5"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td colspan="14">Lainnya (termasuk    meninggal di perjalanan/DOA)</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="16">
        <td height="16">&nbsp;</td>
        <td>II</td>
        <td colspan="18">Keterangan Khusus Kasus    Kematian di Rumah atau Lainnya</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="16" style="display:none;">
        <td height="16">&nbsp;</td>
        <td></td>
        <td>1</td>
        <td colspan="3">Status Jenazah</td>
        <td>:</td>
        <td></td>
        <td><div class="kotak"><? $t1=explode(",",$isi["jenazah"]);?><? if($t1[0]=="1"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td colspan="11">Belum dimakamkan/ Belum    dikremasi</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="8" style="display:none;">
        <td height="8">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="16" style="display:none;">
        <td height="16">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><div class="kotak"><? if($t1[1]=="2"){echo "&radic;";}else{echo "&times;";}?></div></div></td>
        <td></td>
        <td colspan="10">Telah dimakamkan/Telah    dikremasi</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="16" style="display:none;">
        <td height="16">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="8">pada tanggal <? $t1=explode("-",$isi["tgl_stat_jnzh"]);?><u><?=$t1[2]?></u>,</td>
        <td colspan="7">Bulan <u><?=$t1[1]?></u>,</td>
        <td colspan="8">Tahun <u><?=$t1[0]?></u>.</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="16">
        <td height="16">&nbsp;</td>
        <td></td>
        <td>1</td>
        <td colspan="3">Nama Pemeriksa Jenazah</td>
        <td>:</td>
        <td></td>
        <td colspan="27"><u><?=$isi["namapemeriksa"]?></u></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="16">
        <td height="16">&nbsp;</td>
        <td></td>
        <td>2</td>
        <td colspan="3">Kualifikasi Pemeriksa</td>
        <td>:</td>
        <td></td>
        <td><div class="kotak"><? $t1=explode(",",$isi["kualifikasi"]);?><? if($t1[0]=="1"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td colspan="2">Medis</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><div class="kotak"><? if($t1[1]=="2"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td colspan="3">Paramedis</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="16">
        <td height="16">&nbsp;</td>
        <td></td>
        <td>3</td>
        <td colspan="3">Waktu Pemeriksaan Jenazah</td>
        <td>:</td>
        <td></td>
        <td colspan="10">Tanggal <? $t1=explode("-",$isi["tgl_priksa_jnzh"]);?><u><?=$t1[2]?></u>,</td>
        <td colspan="7">Bulan <u><?=$t1[1]?></u>,</td>
        <td colspan="8">Tahun <u><?=$t1[0]?></u>.</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="16">
        <td height="16">&nbsp;</td>
        <td>III</td>
        <td colspan="4">Penyebab Kematian</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="16">
        <td height="16">&nbsp;</td>
        <td></td>
        <td>1</td>
        <td colspan="3">Dasar Diagnosis</td>
        <td>:</td>
        <td></td>
        <td><div class="kotak"><? $t1=explode(",",$isi["diagnosis"]);?><? if($t1[0]=="1"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td colspan="4">Rekam Medis</td>
        <td></td>
        <td></td>
        <td></td>
        <td><div class="kotak"><? if($t1[1]=="2"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td colspan="8">Pemeriksaan Luar Jenazah</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="7">
        <td height="7">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="16">
        <td height="16">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><div class="kotak"><? if($t1[2]=="3"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td colspan="5">Autopsi Forensik</td>
        <td></td>
        <td></td>
        <td><div class="kotak"><? if($t1[3]=="4"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td colspan="4">Autopsi Medis</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="6">
        <td height="6">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="16">
        <td height="16"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><div class="kotak"><? if($t1[4]=="5"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td colspan="5">Autopsi Verbal</td>
        <td></td>
        <td></td>
        <td><div class="kotak"><? if($t1[5]=="6"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td colspan="2">Lainya</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="16">
        <td height="16"></td>
        <td></td>
        <td>2</td>
        <td colspan="7">Kelompok Penyebab    Kematian</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="16">
        <td height="16"></td>
        <td></td>
        <td></td>
        <td colspan="3">Penyakit</td>
        <td></td>
        <td></td>
        <td colspan="3">Gangguan</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="3">Cedera**</td>
        <td></td>
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
      <tr height="16">
        <td height="16"></td>
        <td></td>
        <td></td>
        <td><div class="kotak"><? $t1=explode(",",$isi["penyakit"]);?><? if($t1[0]=="1"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td>Penyakit Khusus*</td>
        <td></td>
        <td></td>
        <td><div class="kotak"><? $t2=explode(",",$isi["gangguan"]);?><? if($t2[0]=="1"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td colspan="14">Gangguan Maternal    (kehamilan/persalinan/nifas)</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><div class="kotak"><? $t3=explode(",",$isi["cedera"]);?><? if($t3[0]=="1"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td colspan="9">Cedera Kecelakaan Lalu    Lintas</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="6">
        <td height="6"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="16">
        <td height="16"></td>
        <td></td>
        <td></td>
        <td><div class="kotak"><? if($t1[1]=="2"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td>Penyakit Menular</td>
        <td></td>
        <td></td>
        <td><div class="kotak"><? if($t2[1]=="2"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td colspan="6">Gangguan Perinatal</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><div class="kotak"><? if($t3[1]=="2"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td colspan="7">Cedera Kecelakaan Kerja</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="7">
        <td height="7"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="16">
        <td height="16"></td>
        <td></td>
        <td></td>
        <td><div class="kotak"><? if($t1[2]=="3"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td>Penyakit Tidak Menular</td>
        <td></td>
        <td></td>
        <td><div class="kotak"><? if($t2[2]=="3"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td colspan="10">Gejala, Tanda dan    Kondisi lainnya</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><div class="kotak"><? if($t3[2]=="3"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td colspan="5">Cedera Lainnya</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="15">
        <td height="15"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="16">
        <td height="16"></td>
        <td></td>
        <td></td>
        <td colspan="3">Lain-lain</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="16">
        <td height="16"></td>
        <td></td>
        <td></td>
        <td><div class="kotak"><? $t1=explode(",",$isi["lain"]);?><? if($t1[0]=="1"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td>Tidak Diketahui</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="8">
        <td height="8"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="16">
        <td height="16"></td>
        <td></td>
        <td></td>
        <td><div class="kotak"><? if($t1[1]=="2"){echo "&radic;";}else{echo "&times;";}?></div></td>
        <td></td>
        <td colspan="2"><u><?=$isi["lainnya"]?></u></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="16">
        <td height="16"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="11">Medan, <?=tgl_ina(date('Y-m-d'))?></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="16">
        <td height="16"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="10">Pihak yang menerima</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="9">Dokter yang menerangkan</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="16">
        <td height="16"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="16">
        <td height="16"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="16">
        <td height="16"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="16">
        <td height="16"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="10">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    )</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="10">(<u><?=$dokter?></u>)</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="16">
        <td height="16"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="10">Nama &amp; Tanda tangan&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="16">
        <td height="16"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="10">Hub. Dengan Almarhum/ah</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="16">
        <td height="16">&nbsp;</td>
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
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr height="16">
        <td height="16" width="11"></td>
        <td width="20"></td>
        <td width="21">3</td>
        <td colspan="12">Penyebab    Kematian Berdasarkan ICD-10</td>
        <td width="28"></td>
        <td width="28"></td>
        <td width="28"></td>
        <td width="20"></td>
        <td width="24"></td>
        <td width="20"></td>
        <td width="20"></td>
        <td width="20"></td>
        <td width="20"></td>
        <td valign="top" colspan="17" rowspan="16" bordercolor="#000000" style="border:1px solid #000000; border-bottom:0px;border-left:0px;border-right:0px;border-top:0px;">
        <table border="1" style="width:100%;border-collapse:collapse;" id="tblMati">
  <tr>
    <td colspan="4" align="center">Selang waktu terjadinya penyakit sampai	meninggal</td>
    <td rowspan="2" align="center">ICD 10 (Diisi oleh petugas kode)</td>
    </tr>
  <tr>
    <td width="17%" align="center">Tahun</td>
    <td width="16%" align="center">Bulan</td>
    <td width="16%" align="center">Hari</td>
    <td width="20%" align="center">Jam</td>
    </tr>
    <?php
	$zz="SELECT * FROM sertifikat_kematian_detail WHERE s_mati_id='$id'";
		//echo $zz;
		$sql=mysql_query($zz);
	while($dt=mysql_fetch_array($sql)){ ?>
    <tr>
    <td align="center"><?=$dt["tahun"]?></td>
    <td align="center"><?=$dt["bulan"]?></td>
    <td align="center"><?=$dt["hari"]?></td>
    <td align="center"><?=$dt["jam"]?></td>
    <td align="center"><?=$dt["icd"]?></td>
    </tr>
    <?php
	} 
	?>
    </table></td>
        </tr>
      <tr height="16">
        <td height="16"></td>
        <td></td>
        <td></td>
        <td width="27"></td>
        <td width="20"></td>
        <td width="208"></td>
        <td width="9"></td>
        <td width="9"></td>
        <td width="24"></td>
        <td width="20"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="16">
        <td height="16"></td>
        <td></td>
        <td></td>
        <td>a</td>
        <td colspan="11">Kematian umur 7 hari ke    atas</td>
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
      <tr height="16">
        <td height="16"></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="right">1</td>
        <td colspan="3">Penyebab langsung</td>
        <td>a)</td>
        <td>&nbsp;</td>
        <td colspan="13"><u><?=$isi["kematianA"]?></u></td>
        <td>&nbsp;</td>
        </tr>
      <tr height="16">
        <td height="16"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="3">Penyebab antara</td>
        <td>b)</td>
        <td>&nbsp;</td>
        <td colspan="13"><u><?=$isi["kematianB"]?></u></td>
        <td>&nbsp;</td>
        </tr>
      <tr height="16">
        <td height="16"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>c)</td>
        <td>&nbsp;</td>
        <td colspan="13"><u><?=$isi["kematianC"]?></u></td>
        <td>&nbsp;</td>
        </tr>
      <tr height="16">
        <td height="16"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>Penyebab dasar</td>
        <td></td>
        <td></td>
        <td>d)</td>
        <td>&nbsp;</td>
        <td colspan="13"><u><?=$isi["kematianD"]?></u></td>
        <td>&nbsp;</td>
        </tr>
      <tr height="16">
        <td height="16"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="16">
        <td height="16"></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="right">2</td>
        <td colspan="3">Kondisi lain yang</td>
        <td>&nbsp;</td>
        <td colspan="14"><u><?=$isi["kondisi"]?></u></td>
        <td></td>
        </tr>
      <tr height="16">
        <td height="16"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="14">     berkontribusi tapi tidak terkait dengan    1a-d</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr height="16">
        <td height="16"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="16">
        <td height="16"></td>
        <td></td>
        <td></td>
        <td>b</td>
        <td colspan="13">Kematian umur 0-6 hari    termasuk lahir mati</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        </tr>
      <tr height="16">
        <td height="16"></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="right">1</td>
        <td colspan="3">Penyebab Utama Bayi</td>
        <td>:</td>
        <td colspan="14"><u><?=$isi["kematian2A"]?></u></td>
        <td>&nbsp;</td>
        </tr>
      <tr height="16">
        <td height="16">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="3">Penyebab Lain Bayi</td>
        <td>:</td>
        <td colspan="14"><u><?=$isi["kematian2B"]?></u></td>
        <td>&nbsp;</td>
        </tr>
      <tr height="16">
        <td height="16">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td align="right">2</td>
        <td colspan="3">Penyebab Utama Ibu</td>
        <td>:</td>
        <td colspan="14"><u><?=$isi["kematian2C"]?></u></td>
        <td>&nbsp;</td>
        </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="3">Penyebab Lain Ibu</td>
        <td>:</td>
        <td colspan="14"><u><?=$isi["kematian2D"]?></u></td>
        <td>&nbsp;</td>
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
        <td></td>
        <td></td>
        <td width="20"></td>
        <td width="22"></td>
        <td width="20"></td>
        <td width="20"></td>
        <td width="34"></td>
        <td width="20"></td>
        <td width="20"></td>
        <td width="20"></td>
        <td width="20"></td>
        <td width="20"></td>
        <td width="20"></td>
        <td width="20"></td>
        <td width="20"></td>
        <td width="34"></td>
        <td width="20"></td>
        <td width="14"></td>
        <td width="110"></td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="11">Medan, <?=tgl_ina(date('Y-m-d'))?></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="3">Keterangan:</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="9">Dokter yang menerangkan</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="15">Lembar pertama (1)    diberikan kepada keluarga pasien</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        <td colspan="15">Lembar kedua (2) untuk    arsip Rumah Sakit</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        <td>*</td>
        <td colspan="14">Jenazah memerlukan    bantuan khusus</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        <td>**</td>
        <td colspan="23">Jika penyebab kematian    karena cedera, formulir SMPK diisi setelah prosedur baku selesai</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        <td><div class="kotak"></div></td>
        <td colspan="14">Beri tanda &radic; pada jawaban yang dipilih</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="10">(<u><?=$namaUser?></u>)</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
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
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="10">Nama Tanda Tangan</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr id="trTombol">
        <td class="noline" align="center">
                    
                    <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));" />
              <input id="btnTutup" type="button" value="Tutup" onClick="tutup();"/>
                </td>
        </tr>
</table>
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
			
function tutup(){
	window.close();
	}
        </script>
</html>
