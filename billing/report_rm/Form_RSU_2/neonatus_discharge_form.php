<?php
session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUser'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,kk.no_reg as no_reg2
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_kunjungan kk ON kk.id=pl.kunjungan_id
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
$usr=mysql_fetch_array(mysql_query("select * from b_ms_pegawai where id='$idUsr'"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
        <title>NEONATUS DISCHARGE</title>
        <style>
        .gb{
	border-bottom:1px solid #000000;
}
.inputan{
	width:200px;
	}
.textArea{ width:100%;}
body{background:#FFF;}
        </style>
    </head>
    <body>
        <div align="center">
            <?php
           // include("../../header1.php");
            ?>
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
       <!--     <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
                <tr>
                    <td height="30">&nbsp;NEONATUS DISCHARGE</td>
                </tr>
            </table>-->
            <table width="1000" border="0" cellspacing="0" cellpadding="2" align="center" >
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="3" align="center"><div id="form_in" style="display:none;">
                <form name="form1" id="form1" action="neonatus_discharge_act.php">
                <input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    			<input type="hidden" name="txtId" id="txtId"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
                <table width="200" border="1" cellpadding="2" style="border-collapse:collapse; border:1px solid #000; font:12px tahoma;">
  <tr>
    <td width="320"><table cellspacing="0" cellpadding="0" width="320">
      <tr>
        <td><img src="pngwsn_khsus_bayi_clip_image002.png" alt="" width="317" height="61" /></td>
      </tr>
      <tr>
        <td align="center"><b>NEONATUS    DISCHARGE MEDICAL INFORMATION</b></td>
      </tr>
    </table></td>
    <td width="340">
    <table cellspacing="0" cellpadding="0" width="340" style="">
      <col width="10" />
      <col width="19" span="15" />
      <tr>
        <td width="10">&nbsp;</td>
        <td colspan="5">Nama    Pasien</td>
        <td width="19">:</td>
        <td colspan="9"><span class="gb"><?=$dP['nama']?></span>&nbsp;&nbsp;<span <?php if($dP['sex']=='L'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>L</span> / <span <?php if($dP['sex']=='P'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>P</span></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="5">Tanggal Lahir</td>
        <td>:</td>
        <td colspan="9"><span class="gb"><?=$dP['tgl_lahir']?></span> /Usia: <span class="gb"><?=$dP['usia']?></span> Th</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="5">No. R.M.</td>
        <td>:</td>
        <td colspan="2"><span class="gb"><?=$dP['no_rm']?></span>&nbsp;&nbsp;</td>
        <td colspan="4">No. Registrasi</td>
        <td colspan="3">: <?=$dP['no_reg2']?></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="5">Ruang Rawat / Kelas</td>
        <td>:</td>
        <td colspan="9"><span class="gb"><?=$dP['nm_unit'];?>/
          <?=$dP['nm_kls'];?></span></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="5">Alamat</td>
        <td>:</td>
        <td colspan="9"><span class="gb"><?=$dP['alamat']?></span></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="57"></td>
        <td></td>
        <td></td>
        <td width="19"></td>
        <td width="19"></td>
        <td></td>
        <td width="19"></td>
        <td width="19"></td>
        <td width="19"></td>
        <td width="19"></td>
        <td width="19"></td>
        <td width="19"></td>
        <td width="19"></td>
        <td width="19"></td>
        <td width="19">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="15" style="font:11px tahoma;" align="center">(Tempelkan Sticker    Identitas Pasien)</td>
        </tr>
    </table></td>
    <td width="55" rowspan="3" valign="top"><img src="untitled.jpg" alt="" width="55" height="1300" /></td>
  </tr>
  <tr>
    <td><table cellspacing="0" cellpadding="0" width="320">
      <col width="19" span="16" />
      <tr>
        <td colspan="5" width="95">No. Rek. Med.</td>
        <td width="19">:</td>
        <td colspan="10"><span class="gb"><?=$dP['no_rm']?></span></td>
        </tr>
      <tr>
        <td colspan="16">Med.    Rec. No</td>
        </tr>
      <tr>
        <td colspan="16">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="4">Nama  Bayi</td>
        <td></td>
        <td>:</td>
        <td colspan="10"><label for="txt_nama"></label>
          <input name="txt_nama" type="text" class="inputan" id="txt_nama" /></td>
        </tr>
      <tr>
        <td colspan="16">Baby's    Name</td>
        </tr>
      <tr>
        <td colspan="16">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="5">Jenis    Kelamin</td>
        <td>:</td>
        <td width="19"><input type="radio" name="rad_lp" id="rad_lp" value="L" /></td>
        <td colspan="3">Laki-laki</td>
        <td width="19"></td>
        <td width="19"><input type="radio" name="rad_lp" id="rad_lp" value="P" /></td>
        <td colspan="4">Perempuan</td>
      </tr>
      <tr>
        <td colspan="2">Sex</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2">Male</td>
        <td width="19"></td>
        <td></td>
        <td></td>
        <td colspan="3">Female</td>
        <td width="19">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="16">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="2">GPA</td>
        <td></td>
        <td></td>
        <td></td>
        <td>:</td>
        <td colspan="10"><input name="txt_gpa" type="text" class="inputan" id="txt_gpa" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td width="19">&nbsp;</td>
        <td width="19">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td width="19">&nbsp;</td>
        <td width="19">&nbsp;</td>
        <td width="19">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td valign="top"><table cellspacing="0" cellpadding="0" width="340">
      <col width="10" />
      <col width="19" span="15" />
      <tr>
        <td width="10">&nbsp;</td>
        <td colspan="4" width="76">Nama    Ibu</td>
        <td width="19">:</td>
        <td colspan="5"><span class="gb">
          <?=$dP['nama']?>
        </span></td>
        <td colspan="2" width="38">Umur</td>
        <td colspan="3"><span class="gb">
          <?=$dP['usia']?>
        </span> Th</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="5">Mother Name</td>
        <td width="19"></td>
        <td width="19"></td>
        <td width="19"></td>
        <td width="19"></td>
        <td width="19"></td>
        <td colspan="2">Age</td>
        <td width="19"></td>
        <td width="19"></td>
        <td width="19">&nbsp;</td>
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
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">Alamat </td>
        <td></td>
        <td>:</td>
        <td colspan="10"><span class="gb">
          <?=$dP['alamat']?>
        </span></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">Address</td>
        <td></td>
        <td></td>
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
        <td colspan="6"><b>(Tempel Stiker Ibu)</b></td>
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
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2"><table width="660" cellspacing="0" cellpadding="0">
      <col width="19" span="16" />
      <col width="10" />
      <col width="19" span="15" />
      <tr>
        <td colspan="24"></td>
        <td colspan="8" style="background-color:#000; color: #FFF;" align="center">Medical. Record Dept.</td>
        </tr>
      <tr>
        <td colspan="8">Kelahiran    ditolong pada </td>
        <td colspan="6"><input name="txt_ditolong" type="text" id="txt_ditolong" /></td>
        <td colspan="3" align="right">Tanggal</td>
        <td colspan="7" align="center"><input name="tgl_ditolong" type="text" id="tgl_ditolong" value="<?=date('d-m-Y');?>" onclick="gfPop.fPopCalendar(document.getElementById('tgl_ditolong'),depRange);" /></td>
        <td colspan="8" style="background-color:#000; color: #FFF;" align="center">Diagnostic/Procedural Codes</td>
        </tr>
      <tr>
        <td colspan="8">Delivered    on :</td>
        <td colspan="6"></td>
        <td colspan="3" align="right">Date</td>
        <td colspan="7"></td>
        <td colspan="8" rowspan="39" style="border:1px solid #000;">&nbsp;</td>
        </tr>
      <tr>
        <td width="18"></td>
        <td width="11"></td>
        <td width="0"></td>
        <td width="0"></td>
        <td width="0"></td>
        <td width="0"></td>
        <td width="0"></td>
        <td width="0"></td>
        <td width="0"></td>
        <td width="47"></td>
        <td width="7"></td>
        <td width="0"></td>
        <td width="23"></td>
        <td width="47"></td>
        <td width="18"></td>
        <td width="32"></td>
        <td width="0"></td>
        <td width="22"></td>
        <td width="22"></td>
        <td width="22"></td>
        <td width="25"></td>
        <td width="29"></td>
        <td></td>
        <td width="21"></td>
        </tr>
      <tr>
        <td colspan="24">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="24">Dengan    data-data</td>
        </tr>
      <tr>
        <td colspan="24">With    Following Data</td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        <td>&nbsp;</td>
        <td colspan="23">&nbsp;</td>
        </tr>
      <tr>
        <td>1.</td>
        <td colspan="23">Kelahiran    kurang/Cukup/Lebih bulan</td>
        </tr>
      <tr>
        <td></td>
        <td colspan="23">Preterm/Fullterm/Postmature</td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        <td>&nbsp;</td>
        <td colspan="23">&nbsp;</td>
        </tr>
      <tr>
        <td>2.</td>
        <td colspan="23">Persalinan    spontan/sunsang/Vakum ekstraksi/Operasi caesar</td>
        </tr>
      <tr>
        <td></td>
        <td colspan="23">Normal    spontaneous/Breech presentation/Extr.vac/Cesarean section delivery</td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        <td colspan="24">&nbsp;</td>
        </tr>
      <tr>
        <td>3.</td>
        <td>a.</td>
        <td colspan="8">Berat Lahir</td>
        <td>:</td>
        <td colspan="12"><input name="txt_berat" type="text" id="txt_berat" /></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td></td>
        <td colspan="8">Birth Weight</td>
        <td></td>
        <td colspan="12"></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td>b.</td>
        <td colspan="8">Panjang</td>
        <td>:</td>
        <td colspan="12"><input name="txt_panjang" type="text" id="txt_panjang" /></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td></td>
        <td colspan="8">Lenght</td>
        <td></td>
        <td colspan="12"></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td>c.</td>
        <td colspan="8">Lingkaran Kepala</td>
        <td>:</td>
        <td colspan="12"><input name="txt_kepala" type="text" id="txt_kepala" /></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td></td>
        <td colspan="8">Head Circumference</td>
        <td></td>
        <td colspan="12"></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td>d.</td>
        <td colspan="8">Lingkar Dada</td>
        <td>:</td>
        <td colspan="12"><input name="txt_dada" type="text" id="txt_dada" /></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td></td>
        <td colspan="8">Chest Circumference</td>
        <td></td>
        <td colspan="12"></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td>e.</td>
        <td colspan="8">Apgar Score</td>
        <td>:</td>
        <td colspan="12"><input name="txt_apgar" type="text" id="txt_apgar" /></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td></td>
        <td colspan="8">Apgar Score</td>
        <td></td>
        <td colspan="12"></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td>f.</td>
        <td colspan="8">Kuning</td>
        <td>:</td>
        <td colspan="12"><input name="txt_kuning" type="text" id="txt_kuning" /></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td></td>
        <td colspan="8">Jundice</td>
        <td></td>
        <td colspan="12"></td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        <td>&nbsp;</td>
        <td colspan="22">&nbsp;</td>
        <td></td>
      </tr>
      <tr>
        <td>4.</td>
        <td colspan="9">Data Laboratorium</td>
        <td>:</td>
        <td colspan="12"><input name="txt_lab" type="text" id="txt_lab" /></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td colspan="9">Laboratory Data</td>
        <td></td>
        <td colspan="12"></td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        <td>a. </td>
        <td colspan="8">- Golongan darah/Rhesus</td>
        <td>:</td>
        <td colspan="12"><input name="txt_golDarah" type="text" id="txt_golDarah" /></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td></td>
        <td colspan="8">   Blood group/Rhesus</td>
        <td></td>
        <td colspan="12"></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td></td>
        <td colspan="8">- Hg</td>
        <td>:</td>
        <td colspan="12"><input name="txt_hg" type="text" id="txt_hg" /></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td></td>
        <td colspan="8">- G6PD</td>
        <td>:</td>
        <td colspan="12"><input name="txt_g6pd" type="text" id="txt_g6pd" /></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td></td>
        <td colspan="8">- T4/TSH</td>
        <td>:</td>
        <td colspan="12"><input name="txt_t4" type="text" id="txt_t4" /></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td>b.</td>
        <td colspan="8">Pemeriksaan Radiologi</td>
        <td>:</td>
        <td colspan="12"><input name="txt_xray" type="text" id="txt_xray" /></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td></td>
        <td colspan="8">X ray</td>
        <td></td>
        <td colspan="12"></td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td width="47"></td>
        <td width="9"></td>
        <td width="9"></td>
        <td width="9"></td>
        <td width="9"></td>
        <td width="9"></td>
        <td width="18"></td>
        <td width="18"></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="23">&nbsp;</td>
        <td colspan="8">&nbsp;</td>
        </tr>
      <tr>
        <td>5.</td>
        <td colspan="9">Terapi</td>
        <td>:</td>
        <td colspan="20"><input name="txt_terapi" type="text" id="txt_terapi" /></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td colspan="9">Terapy</td>
        <td></td>
        <td colspan="20"></td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        <td>&nbsp;</td>
        <td colspan="30">&nbsp;</td>
        <td></td>
      </tr>
      <tr>
        <td>6.</td>
        <td colspan="9">Asi/Susu Kaleng</td>
        <td>:</td>
        <td colspan="20"><input name="txt_susu" type="text" id="txt_susu" /></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td colspan="9">Breastfed/Formula</td>
        <td></td>
        <td colspan="20"></td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        <td>&nbsp;</td>
        <td colspan="30">&nbsp;</td>
        <td></td>
      </tr>
      <tr>
        <td>7.</td>
        <td colspan="9">Berat badan waktu pulang</td>
        <td>:</td>
        <td colspan="20"><input name="txt_berat_plg" type="text" id="txt_berat_plg" /></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td colspan="9">Discharge weight</td>
        <td></td>
        <td colspan="20"></td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        <td colspan="30">Tali pusat    kering/basah/masih diberikan perawatan dengan:</td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td colspan="30">Umbilicus :    Dry/Wet/Treaed with</td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        <td>&nbsp;</td>
        <td colspan="30"><textarea name="txt_rawat" cols="45" rows="5" class="textArea" id="txt_rawat" ></textarea></td>
        <td></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="30">&nbsp;</td>
        <td></td>
      </tr>
      <tr>
        <td rowspan="2" valign="top">8.</td>
        <td colspan="9" rowspan="2" valign="top">Terapi yang masih harus dilakukan<br/>Treatment should be done</td>
        <td rowspan="2" valign="top">:</td>
        <td colspan="20" rowspan="2"><textarea name="txt_terapi_lanjut" cols="45" rows="5" class="textArea" id="txt_terapi_lanjut" ></textarea></td>
        <td></td>
        </tr>
      <tr>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        <td>&nbsp;</td>
        <td colspan="30">&nbsp;</td>
        <td></td>
      </tr>
      <tr>
        <td rowspan="2" valign="top">9.</td>
        <td colspan="9" rowspan="2" valign="top">Diagnosa terakhir<br/>Definite Diagnosis</td>
        <td rowspan="2" valign="top">:</td>
        <td colspan="20" rowspan="2"><textarea name="txt_diagnosa" cols="45" rows="5" class="textArea" id="txt_diagnosa" ></textarea>&nbsp;</td>
        <td></td>
        </tr>
      <tr>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        <td>&nbsp;</td>
        <td colspan="30">&nbsp;</td>
        <td></td>
      </tr>
      <tr>
        <td>10.</td>
        <td colspan="9">Kontrol kembali tanggal</td>
        <td>:</td>
        <td colspan="20"><input name="tgl_kontrol_kembali" type="text" id="tgl_kontrol_kembali" value="<?=date('d-m-Y');?>" onclick="gfPop.fPopCalendar(document.getElementById('tgl_kontrol_kembali'),depRange);"/></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td colspan="9">Recommended control on</td>
        <td></td>
        <td colspan="20">&nbsp;</td>
        <td></td>
        </tr>
      <tr>
        <td rowspan="7"></td>
        <td colspan="22" rowspan="7"></td>
        <td colspan="8">Medan, <?php echo tgl_ina(date("Y-m-d"))?>    
          <?=date('d-m-Y');?>
        </td>
        <td></td>
        </tr>
      <tr>
        <td colspan="8">Doctor</td>
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
        </tr>
      <tr>
        <td colspan="9">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="9">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="9">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="9">(...............................................)</td>
        </tr>
      <tr>
        <td></td>
        <td colspan="22"></td>
        <td colspan="9">&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td colspan="22"></td>
        <td colspan="9">&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td colspan="22"></td>
        <td colspan="9">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
                </form>
                <div align="center"><input type="button" name="bt_save" id="bt_save" class="tblTambah" value="Simpan" onclick="return simpan()" />&nbsp;
  <input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/></div>
                </div></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="45%"><?php
                    if($_REQUEST['report']!=1){
					?>
                        <input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="tambah(this.value);" class="tblTambah"/>
                      <input type="button" id="btnHapus" name="btnHapus" value="Edit" onclick="edit();" class="tblTambah"/>
                        <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus();" class="tblHapus"/>
                        <?php }?></td>
                    <td width="20%"><button type="button" id="btnTree" name="btnTree" value="Tampilan Tree" onclick="cetak()" class="tblViewTree" >Cetak</button></td>
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
<!--      <table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
                <tr>
                    <td height="30">&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;"/></td>
                    <td></td>
                    <td align="right">
                        <a href="<?=$host?>/simrs-tangerang/billing/index.php">
                            <input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;"/>
                        </a>&nbsp;
                    </td>
        </tr>
          </table>-->
        </div>
    </body>
    <script type="text/javascript">
	function toggle() {
    parent.alertsize(document.body.scrollHeight);
}


        function simpan(action){
            if(ValidateForm('txt_nama,txt_gpa,txt_ditolong,txt_berat,txt_diagnosa','ind')){
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
            var sisip = a.getRowId(a.getSelRow()).split('|');
			$('#txt_terapi_lanjut').val(sisip[14]);
			$('#txt_rawat').val(sisip[15]);
			$('#txt_diagnosa').val(sisip[16]);
            var p="txtId*-*"+sisip[0]+"*|*txt_nama*-*"+a.cellsGetValue(a.getSelRow(),2)+"*|*txt_gpa*-*"+sisip[2]+"*|*txt_ditolong*-*"+a.cellsGetValue(a.getSelRow(),4)+"*|*tgl_ditolong*-*"+a.cellsGetValue(a.getSelRow(),5)+"*|*txt_berat*-*"+a.cellsGetValue(a.getSelRow(),6)+"*|*txt_panjang*-*"+a.cellsGetValue(a.getSelRow(),7)+"*|*txt_kepala*-*"+a.cellsGetValue(a.getSelRow(),8)+"*|*txt_dada*-*"+a.cellsGetValue(a.getSelRow(),9)+"*|*txt_apgar*-*"+sisip[3]+"*|*txt_kuning*-*"+sisip[4]+"*|*txt_lab*-*"+sisip[5]+"*|*txt_golDarah*-*"+sisip[6]+"*|*txt_hg*-*"+sisip[7]+"*|*txt_g6pd*-*"+sisip[8]+"*|*txt_t4*-*"+sisip[9]+"*|*txt_xray*-*"+sisip[10]
			+"*|*txt_terapi*-*"+sisip[11]+"*|*txt_susu*-*"+sisip[12]+"*|*txt_berat_plg*-*"+sisip[13]+"*|*tgl_kontrol_kembali*-*"+sisip[17]+"";
            fSetValue(window,p);
			centang(sisip[1]);
        }

        function hapus(){
            var rowid = document.getElementById("txtId").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(rowid==''){
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
            var rowid = document.getElementById("txtId").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(rowid==''){
					alert("Pilih data terlebih dahulu");
				}else{
					$('#act').val('edit');
					$('#form_in').slideDown(1000,function(){
		toggle();
		});
				}

        }

        function batal(){
			resetF();
			$('#form_in').slideUp(1000,function(){
		toggle();
		});
        }
		
		function resetF(){
			$('#act').val('tambah');
			$('#txt_rawat').val('');
			$('#txt_terapi_lanjut').val('');
			$('#txt_diagnosa').val('');
           var p="txtId*-**|*txt_nama*-**|*txt_gpa*-**|*txt_ditolong*-**|*tgl_ditolong*-*<?=date('d-m-Y');?>*|*txt_berat*-**|*txt_panjang*-**|*txt_kepala*-**|*txt_dada*-**|*txt_apgar*-**|*txt_kuning*-**|*txt_lab*-**|*txt_golDarah*-**|*txt_hg*-**|*txt_g6pd*-**|*txt_t4*-**|*txt_xray*-**|*txt_terapi*-**|*txt_susu*-**|*txt_berat_plg*-**|*tgl_kontrol_kembali*-*<?=date('d-m-Y');?>";
            fSetValue(window,p);
			centang('L')
			}


        function konfirmasi(key,val){
            //alert(val);
           /* var tangkap=val.split("*|*");
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
            a.loadURL("neonatus_discharge_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("DATA NEONATUS DISCHARGE");
        a.setColHeader("NO,NAMA,JK,DITOLONG,TGL DITOLONG,BERAT,PANJANG,LKR.KEPALA,LKR.DADA,TGL INPUT,PENGINPUT");
        a.setIDColHeader(",tindakan,,nama,umur,,,,,,");
        a.setColWidth("50,250,80,80,100,80,80,80,80,80,150");
        a.setCellAlign("center,center,center,center,center,center,center,center,center,center,center");
        a.setCellHeight(20);
        a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        a.onLoaded(konfirmasi);
        a.baseURL("neonatus_discharge_util.php?idPel=<?=$idPel?>");
        a.Init();
		
		function tambah(){
			resetF();
			$('#form_in').slideDown(1000,function(){
		toggle();
		});
			
			}
		
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
		window.open("neonatus_discharge.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUsr?>","_blank");
				//}
		}
		
function centang(tes2){
		
		 var checkboxlp = document.form1.elements['rad_lp'];
		
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
	}
    </script>
    
</html>
