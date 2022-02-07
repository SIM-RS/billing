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
    
        <title>.: SERTIFIKAT MEDIS PENYEBAB KEMATIAN :.</title>
        <style>
        body{background:#FFF;}
.kotak{
border:1px solid #000000;
width:20px;
height:20px;
vertical-align:middle; 
text-align:center;
}
        </style>
    </head>
<?php
	include "setting.php";
?>
    <body>
        <div align="center">
            <?php
           // include("../../header1.php");
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
        <!--    <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
                <tr>
                    <td height="30">SURAT KETERANGAN PEMERIKSAAN MATA</td>
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
    <form id="form1" name="form1" action="21.sertifikatmedispenyebabkematianact.php" method="post">
    <input type="hidden" name="idPel" value="<?=$idPel?>" />
    <input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    <input type="hidden" name="idUsr" value="<?=$idUser?>" />
    <input type="hidden" name="idPasien" value="<?=$idPasien?>" />
    <input type="hidden" name="txtId" id="txtId"/>
    <input type="hidden" name="act" id="act" value="tambah"/>
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
        <td colspan="2">No&hellip;&hellip;&hellip;.</td>
        <td colspan="4">RT : <u><?=$rt?></u></td>
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
        <td><input name="statuspenduduk[0]" id="statuspenduduk[]" type="checkbox" value="1" /></td>
        <td></td>
        <td colspan="3">Penduduk</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><input name="statuspenduduk[1]" id="statuspenduduk[]" type="checkbox" value="2" /></td>
        <td></td>
        <td colspan="10">Bukan Penduduk</td>
        <td></td>
        <td></td>
        <td></td>
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
        <td><input name="hubungan[0]" id="hubungan[]" type="checkbox" value="1" /></td>
        <td></td>
        <td colspan="7">Kepala Rumah Tangga</td>
        <td><input name="hubungan[1]" id="hubungan[]" type="checkbox" value="2" /></td>
        <td></td>
        <td colspan="4">Suami/Istri</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><input name="hubungan[2]" id="hubungan[]" type="checkbox" value="3" /></td>
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
        <td><input name="kepala[0]" id="kepala[]" type="checkbox" value="1" /></td>
        <td></td>
        <td colspan="3">Menantu</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><input name="kepala[1]" id="kepala[]" type="checkbox" value="2" /></td>
        <td></td>
        <td colspan="2">Cucu</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><input name="kepala[2]" id="kepala[]" type="checkbox" value="3" /></td>
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
        <td><input name="kepala[3]" id="kepala[]" type="checkbox" value="4" /></td>
        <td></td>
        <td colspan="4">Famili lain</td>
        <td></td>
        <td></td>
        <td></td>
        <td><input name="kepala[4]" id="kepala[]" type="checkbox" value="5" /></td>
        <td></td>
        <td colspan="7">Pembantu Rumah Tangga</td>
        <td></td>
        <td></td>
        <td><input name="kepala[5]" id="kepala[]" type="checkbox" value="6" /></td>
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
        <td><input name="tempat[0]" id="tempat[]" type="checkbox" value="1" /></td>
        <td></td>
        <td colspan="4">Rumah Sakit</td>
        <td></td>
        <td></td>
        <td></td>
        <td><input name="tempat[1]" id="tempat[]" type="checkbox" value="2" /></td>
        <td></td>
        <td colspan="4">Puskesmas</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><input name="tempat[2]" id="tempat[]" type="checkbox" value="3" /></td>
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
        <td><input name="tempat[3]" id="tempat[]" type="checkbox" value="4" /></td>
        <td></td>
        <td colspan="7">Rumah Tempat Tinggal</td>
        <td><input name="tempat[4]" id="tempat[]" type="checkbox" value="5" /></td>
        <td></td>
        <td colspan="20">Lainnya (termasuk    meninggal di perjalanan/DOA)</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="16">
        <td height="16">&nbsp;</td>
        <td>II</td>
        <td colspan="15">Keterangan Khusus Kasus    Kematian di Rumah atau Lainnya</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        <td><input name="jenazah[0]" id="jenazah[]" type="checkbox" value="1" /></td>
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
        <td><input name="jenazah[1]" id="jenazah[]" type="checkbox" value="2" /></td>
        <td></td>
        <td colspan="11">Telah dimakamkan/Telah    dikremasi</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        <td colspan="8">pada tanggal <input name="tglstat" id="tglstat" type="text" value="<?=date('d')?>" style="width:17px;" />,</td>
        <td colspan="7">Bulan <input name="blnstat" id="blnstat" type="text" value="<?=date('m')?>" style="width:17px;" />,</td>
        <td colspan="8">Tahun <input name="thnstat" id="thnstat" type="text" value="<?=date('Y')?>" style="width:30px;" />.</td>
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
        <td colspan="27"><input name="namapemeriksa" id="namapemeriksa" type="text" style="width:250px;"/></td>
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
        <td><input name="kualifikasi[0]" id="kualifikasi[]" type="checkbox" value="1" /></td>
        <td></td>
        <td colspan="2">Medis</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><input name="kualifikasi[1]" id="kualifikasi[]" type="checkbox" value="2" /></td>
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
        <td colspan="10">Tanggal <input name="tglperiksa" id="tglperiksa" type="text" value="<?=date('d')?>" style="width:17px;" />,</td>
        <td colspan="7">Bulan <input name="blnperiksa" id="blnperiksa" type="text" value="<?=date('m')?>" style="width:17px;" />,</td>
        <td colspan="8">Tahun <input name="thnperiksa" id="thnperiksa" type="text" value="<?=date('Y')?>" style="width:30px;" />.</td>
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
        <td><input name="diagnosis[0]" id="diagnosis[]" type="checkbox" value="1" /></td>
        <td></td>
        <td colspan="4">Rekam Medis</td>
        <td></td>
        <td></td>
        <td></td>
        <td><input name="diagnosis[1]" id="diagnosis[]" type="checkbox" value="2" /></td>
        <td></td>
        <td colspan="11">Pemeriksaan Luar Jenazah</td>
        <td></td>
        <td></td>
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
        <td><input name="diagnosis[2]" id="diagnosis[]" type="checkbox" value="3" /></td>
        <td></td>
        <td colspan="5">Autopsi Forensik</td>
        <td></td>
        <td></td>
        <td><input name="diagnosis[3]" id="diagnosis[]" type="checkbox" value="4" /></td>
        <td></td>
        <td colspan="9">Autopsi Medis</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        <td><input name="diagnosis[4]" id="diagnosis[]" type="checkbox" value="5" /></td>
        <td></td>
        <td colspan="5">Autopsi Verbal</td>
        <td></td>
        <td></td>
        <td><input name="diagnosis[5]" id="diagnosis[]" type="checkbox" value="6" /></td>
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
        <td colspan="6">Kelompok Penyebab    Kematian</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        <td><input name="penyakit[0]" id="penyakit[]" type="checkbox" value="1" /></td>
        <td></td>
        <td>Penyakit Khusus*</td>
        <td></td>
        <td></td>
        <td><input name="gangguan[0]" id="gangguan[]" type="checkbox" value="1" /></td>
        <td></td>
        <td colspan="14">Gangguan Maternal    (kehamilan/persalinan/nifas)</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><input name="cedera[0]" id="cedera[]" type="checkbox" value="1" /></td>
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
        <td><input name="penyakit[1]" id="penyakit[]" type="checkbox" value="2" /></td>
        <td></td>
        <td>Penyakit Menular</td>
        <td></td>
        <td></td>
        <td><input name="gangguan[1]" id="gangguan[]" type="checkbox" value="2" /></td>
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
        <td><input name="cedera[1]" id="cedera[]" type="checkbox" value="2" /></td>
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
        <td><input name="penyakit[2]" id="penyakit[]" type="checkbox" value="3" /></td>
        <td></td>
        <td>Penyakit Tidak Menular</td>
        <td></td>
        <td></td>
        <td><input name="gangguan[2]" id="gangguan[]" type="checkbox" value="3" /></td>
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
        <td><input name="cedera[2]" id="cedera[]" type="checkbox" value="3" /></td>
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
        <td><input name="lain[0]" id="lain[]" type="checkbox" value="1" /></td>
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
        <td><input name="lain[1]" id="lain[]" type="checkbox" value="2" /></td>
        <td></td>
        <td colspan="4"><input name="lainnya" id="lainnya" type="text" style="width:150px;"/></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        <td colspan="6">Pihak yang menerima</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        <td colspan="14">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    )</td>
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
        <td colspan="8">Nama &amp; Tanda tangan&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        <td colspan="8">Hub. Dengan Almarhum/ah</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        <td colspan="11">Penyebab    Kematian Berdasarkan ICD-10</td>
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
        <td valign="top" colspan="17" rowspan="16" bordercolor="#000000" style="border:1px solid #000000; border-bottom:0px; border-right:0px; border-left:0px; border-top:0px;">
        <div id="inMati">
        <table border="1" style="width:100%;border-collapse:collapse;" id="tblMati">
  <tr>
    <td colspan="6" align="right"><input type="button" name="button2" id="button2" value="Tambah" onclick="addRowToTable();return false;"/></td>
    </tr>
  <tr>
    <td colspan="4" align="center">Selang waktu terjadinya penyakit sampai	meninggal</td>
    <td colspan="2" rowspan="2" align="center">ICD 10 (Diisi oleh petugas kode)</td>
    </tr>
  <tr>
    <td width="17%" align="center">Tahun</td>
    <td width="16%" align="center">Bulan</td>
    <td width="16%" align="center">Hari</td>
    <td width="20%" align="center">Jam</td>
    </tr>
  <tr>
    <td align="center"><input name="thnICD[]" type="text" class="inputan" id="thnICD[]" style="width:30px;" /></td>
    <td align="center"><input name="blnICD[]" type="text" class="inputan" id="blnICD[]" style="width:30px;"/></td>
    <td align="center"><input name="hariICD[]" type="text" class="inputan" id="hariICD[]" style="width:30px;"/></td>
    <td align="center"><input name="jamICD[]" type="text" class="inputan" id="jamICD[]" style="width:50px;"/></td>
    <td width="23%" align="center"><input name="ICD[]" type="text" class="inputan" id="ICD[]" style="width:50px;"/></td>
    <td width="8%" align="center"><img alt="del" src="../../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onclick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);}" /></td>
  </tr>
</table></div>
</td>
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
        <td colspan="9">Kematian umur 7 hari ke atas</td>
        <td></td>
        <td></td>
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
        <td>Penyebab langsung</td>
        <td></td>
        <td></td>
        <td>a)</td>
        <td>&nbsp;</td>
        <td colspan="13"><input name="kematianA" id="kematianA" type="text" style="width:250px;"/></td>
        <td>&nbsp;</td>
        </tr>
      <tr height="16">
        <td height="16"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>Penyebab antara</td>
        <td></td>
        <td></td>
        <td>b)</td>
        <td>&nbsp;</td>
        <td colspan="13"><input name="kematianB" id="kematianB" type="text" style="width:250px;"/></td>
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
        <td colspan="13"><input name="kematianC" id="kematianC" type="text" style="width:250px;"/></td>
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
        <td colspan="13"><input name="kematianD" id="kematianD" type="text" style="width:250px;"/></td>
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
        <td colspan="12"><input name="kondisi" id="kondisi" type="text" style="width:250px;"/></td>
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
        <td colspan="11">berkontribusitapi tidak terkait dengan    1a-d</td>
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
        <td colspan="11">Kematian umur 0-6 hari    termasuk lahir mati</td>
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
        <td>Penyebab Utama Bayi</td>
        <td></td>
        <td></td>
        <td>:</td>
        <td colspan="14"><input name="kematian2A" id="kematian2A" type="text" style="width:250px;"/></td>
        <td>&nbsp;</td>
        </tr>
      <tr height="16">
        <td height="16">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>Penyebab Lain Bayi</td>
        <td></td>
        <td></td>
        <td>:</td>
        <td colspan="14"><input name="kematian2B" id="kematian2B" type="text" style="width:250px;"/></td>
        <td>&nbsp;</td>
        </tr>
      <tr height="16">
        <td height="16">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td align="right">2</td>
        <td>Penyebab Utama Ibu</td>
        <td></td>
        <td></td>
        <td>:</td>
        <td colspan="14"><input name="kematian2C" id="kematian2C" type="text" style="width:250px;"/></td>
        <td>&nbsp;</td>
        </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>Penyebab Lain Ibu</td>
        <td></td>
        <td></td>
        <td>:</td>
        <td colspan="14"><input name="kematian2D" id="kematian2D" type="text" style="width:250px;"/></td>
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
        <td colspan="19">Lembar pertama (1)    diberikan kepada keluarga pasien</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        <td colspan="19">Lembar kedua (2) untuk    arsip Rumah Sakit</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        <td colspan="18">Jenazah memerlukan    bantuan khusus</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        <td colspan="22">Jika penyebab kematian    karena cedera, formulir SMPK diisi setelah prosedur baku selesai</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        <td colspan="22">Beri tanda &radic; pada jawaban yang dipilih</td>
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
</table>
</form>
<div align="center"><input type="button" name="bt_save" id="bt_save" class="tblTambah" value="Simpan" onclick="return simpan()" />&nbsp;
  <input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/></div>
                
                    </div><br/></td>
                    <td>&nbsp;</td>
              </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
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
                    <select id="cmbUnit" name="cmbUnit" class="txtinput" onchange="alert('25.persetujuantindakanbiusutils.php?grd=true&unit='+document.getElementById('cmbUnit').value);">
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
		function cetak(){
		 var rowid = document.getElementById("txtId").value;
		 if(rowid==""){
				var rowidx =a.getRowId(a.getSelRow()).split('|');
				rowid=rowidx[0];
			 }
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			//if(rowid==''){
//					alert("Pilih data terlebih dahulu");
//				}else{	
		//window.open("4.srt_kenal_lahir.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUsr?>","_blank");
		window.open('21.sertifikatmedispenyebabkematian.php?idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idUsr=<?=$idUser?>&idPasien=<?=$idPasien?>&id='+rowid,"_blank");
				//}
		}
		
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
            /*if(ValidateForm('alterI1,alterI2,alterE1,alterE2,alasan1','ind'))
            {*/
                $("#form1").ajaxSubmit({
					  success:function(msg)
					  {
						alert(msg);
						
					  },
					});
					batal();
						a.loadURL("21.sertifikatmedispenyebabkematianutils.php?grd=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>"+"&idKunj=<?=$idKunj?>","","GET");
						//goFilterAndSort();
            //}
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
            
			var sip1=sisip[12].split("-");
			var sip2=sisip[14].split("-");
			
			var p="txtId*-*"+sisip[0]+"*|*namapemeriksa*-*"+sisip[13]+"*|*lainnya*-*"+sisip[15]+"*|*kematianA*-*"+sisip[16]+"*|*kematianB*-*"+sisip[17]+"*|*kematianC*-*"+sisip[18]+"*|*kematianD*-*"+sisip[19]+"*|*kematian2A*-*"+sisip[20]+"*|*kematian2B*-*"+sisip[21]+"*|*kematian2C*-*"+sisip[22]+"*|*tglstat*-*"+sip1[2]+"*|*blnstat*-*"+sip1[1]+"*|*thnstat*-*"+sip1[0]+"*|*tglperiksa*-*"+sip2[2]+"*|*blnperiksa*-*"+sip2[1]+"*|*thnperiksa*-*"+sip2[0]+"*|*kondisi*-*"+sisip[24]+"*|*kematian2D*-*"+sisip[23]+"";
            
			//alert(p);
            fSetValue(window,p);
            //isiCombo('cmbKlasi', '', sisip[2], 'cmbKlasi', '');
            centang(sisip[1],sisip[2],sisip[3],sisip[4],sisip[5],sisip[6],sisip[7],sisip[8],sisip[9],sisip[10],sisip[11]);
			$('#inMati').load("form_mati.php?type=MATI&id="+sisip[0]);
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

		function awal(){
			$('#act').val('tambah');
			var p="txtId*-**|*namapemeriksa*-**|*lainnya*-**|*kematianA*-**|*kematianB*-**|*kematianC*-**|*kematianD*-**|*kematian2A*-**|*kematian2B*-**|*kematian2C*-**|*kondisi*-**|*kematian2D*-*";
			fSetValue(window,p);
			//centang(1);
			$('#inMati').load("form_mati.php?type=MATI");
			
		}
        //////////////////////////////////////////////////////////////////

        function goFilterAndSort(grd){
            //alert(grd);
                a.loadURL("21.sertifikatmedispenyebabkematianutils.php?grd=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>"+"&idKunj=<?=$idKunj?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader(".: SERTIFIKAT MEDIS PENYEBAB KEMATIAN :.");
        a.setColHeader("NO,NAMA JENAZAH,PENGGUNA");
        a.setIDColHeader(",,");
        a.setColWidth("30,150,200");
        a.setCellAlign("center,left,left");
        a.setCellHeight(20);
        a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        a.baseURL("21.sertifikatmedispenyebabkematianutils.php?grd=true"+"&idPel=<?=$idPel?>"+"&idKunj=<?=$idKunj?>");
        a.Init();
	
	function centang(tes,tes2,tes3,tes4,tes5,tes6,tes7,tes8,tes9,tes10,tes11){
		 var checkbox = document.form1.elements['statuspenduduk[]'];
		 var checkbox2 = document.form1.elements['hubungan[]'];
		 var checkbox3 = document.form1.elements['kepala[]'];
		 var checkbox4 = document.form1.elements['tempat[]'];
		 var checkbox5 = document.form1.elements['jenazah[]'];
		 var checkbox6 = document.form1.elements['kualifikasi[]'];
		 var checkbox7 = document.form1.elements['diagnosis[]'];
		 var checkbox8 = document.form1.elements['penyakit[]'];
		 var checkbox9 = document.form1.elements['gangguan[]'];
		 var checkbox10 = document.form1.elements['cedera[]'];
		 var checkbox11 = document.form1.elements['lain[]'];
		 
		 var tesx =tes.split(',');
		 if ( checkbox.length > 0 )
		{
		 for (i = 0; i < checkbox.length; i++)
			{
			  if (checkbox[i].value==tesx[i])
			  {
			   checkbox[i].checked = true;
			  }
		  }
		}
		
		var tes2x =tes2.split(',');
		 if ( checkbox2.length > 0 )
		{
		 for (i = 0; i < checkbox2.length; i++)
			{
			  if (checkbox2[i].value==tes2x[i])
			  {
			   checkbox2[i].checked = true;
			  }
		  }
		}
		
		var tes3x =tes3.split(',');
		 if ( checkbox3.length > 0 )
		{
		 for (i = 0; i < checkbox3.length; i++)
			{
			  if (checkbox3[i].value==tes3x[i])
			  {
			   checkbox3[i].checked = true;
			  }
		  }
		}
		
		var tes4x =tes4.split(',');
		 if ( checkbox4.length > 0 )
		{
		 for (i = 0; i < checkbox4.length; i++)
			{
			  if (checkbox4[i].value==tes4x[i])
			  {
			   checkbox4[i].checked = true;
			  }
		  }
		}
		
		var tes5x =tes5.split(',');
		 if ( checkbox5.length > 0 )
		{
		 for (i = 0; i < checkbox5.length; i++)
			{
			  if (checkbox5[i].value==tes5x[i])
			  {
			   checkbox5[i].checked = true;
			  }
		  }
		}
		
		var tes6x =tes6.split(',');
		 if ( checkbox6.length > 0 )
		{
		 for (i = 0; i < checkbox6.length; i++)
			{
			  if (checkbox6[i].value==tes6x[i])
			  {
			   checkbox6[i].checked = true;
			  }
		  }
		}
		
		var tes7x =tes7.split(',');
		 if ( checkbox7.length > 0 )
		{
		 for (i = 0; i < checkbox7.length; i++)
			{
			  if (checkbox7[i].value==tes7x[i])
			  {
			   checkbox7[i].checked = true;
			  }
		  }
		}
		
		var tes8x =tes8.split(',');
		 if ( checkbox8.length > 0 )
		{
		 for (i = 0; i < checkbox8.length; i++)
			{
			  if (checkbox8[i].value==tes8x[i])
			  {
			   checkbox8[i].checked = true;
			  }
		  }
		}
		
		var tes9x =tes9.split(',');
		 if ( checkbox9.length > 0 )
		{
		 for (i = 0; i < checkbox9.length; i++)
			{
			  if (checkbox9[i].value==tes9x[i])
			  {
			   checkbox9[i].checked = true;
			  }
		  }
		}
		
		var tes10x =tes10.split(',');
		 if ( checkbox10.length > 0 )
		{
		 for (i = 0; i < checkbox10.length; i++)
			{
			  if (checkbox10[i].value==tes10x[i])
			  {
			   checkbox10[i].checked = true;
			  }
		  }
		}
		
		var tes11x =tes11.split(',');
		 if ( checkbox11.length > 0 )
		{
		 for (i = 0; i < checkbox11.length; i++)
			{
			  if (checkbox11[i].value==tes11x[i])
			  {
			   checkbox11[i].checked = true;
			  }
		  }
		}
		
	}	
	
	function toggle() {
    parent.alertsize(document.body.scrollHeight);
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
            var tbl = document.getElementById('tblMati');
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
			/*var cellLeft = row.insertCell(0);
            var textNode = document.createTextNode(iteration-2);
            cellLeft.className = 'tdisikiri';
            cellLeft.appendChild(textNode);*/
			
            // right cell
            var cellRight = row.insertCell(0);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'thnICD[]';
                el.id = 'thnICD[]';
            }else{
                el = document.createElement('<input name="thnICD[]"/>');
            }
            el.type = 'text';
            el.className = 'inputan';
            el.value = '';
			el.style = 'width:30px';

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
                el.name = 'blnICD[]';
                el.id = 'blnICD[]';
            }else{
                el = document.createElement('<input name="blnICD[]"/>');
            }
            el.type = 'text';
            el.value = '';
            el.className = 'inputan';
			el.style = 'width:30px';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(2);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'hariICD[]';
                el.id = 'hariICD[]';
            }else{
                el = document.createElement('<input name="hariICD[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.className = 'inputan';
			el.style = 'width:30px';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(3);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'jamICD[]';
                el.id = 'jamICD[]';
            }else{
                el = document.createElement('<input name="jamICD[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.style = 'width:50px';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

// right cell
            var cellRight = row.insertCell(4);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'ICD[]';
                el.id = 'ICD[]';
            }else{
                el = document.createElement('<input name="ICD[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.style = 'width:50px';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

 // right cell
                cellRight = row.insertCell(5);
                if(!isIE){
                    el = document.createElement('img');
                    el.setAttribute('onClick','if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);setDisable("del")}');
                }else{
                    el = document.createElement('<img name="img" onClick="if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);}"/>');
                }
                el.src = '../../icon/del.gif';
                el.border = "0";
                el.width = "16";
                el.height = "16";
                el.className = 'proses';
                el.align = "absmiddle";
                el.title = "Klik Untuk Menghapus";

                //  cellRight.setAttribute('class', 'tdisi');
                cellRight.className = 'tdisi';
                cellRight.appendChild(el);
				
        //document.getElementById('btnSimpan').disabled = true;
    }
function removeRowFromTable(cRow)
	{
        var tbl = document.getElementById('tblMati');
        var jmlRow = tbl.rows.length;
        if (jmlRow > 4)
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
    </script>
</html>
