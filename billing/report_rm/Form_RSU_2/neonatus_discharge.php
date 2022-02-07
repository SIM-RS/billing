<?php
include "../../koneksi/konek.php";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUser'];
$idx=$_REQUEST['id'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,kk.no_reg as no_reg2
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_kunjungan kk ON kk.id=pl.kunjungan_id
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
$dt=mysql_fetch_array(mysql_query("select * from b_fom_neonatus_discharge where id='$idx'"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>NEONATUS DISCHARGE</title>
<style>
.header{ font-weight:bold; background:#999; color:#000;}
.gb {	border-bottom:1px solid #000000;
}
.gb{
	border-bottom:1px solid #000000;
}
.inputan{
	width:200px;
	}
.gb1 {	border-bottom:1px solid #000000;
}
</style>
</head>

<body>
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
        <td colspan="10"><span class="gb">
          <?=$dt['nama']?>
        </span></td>
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
        <td width="19"><span class="gb">
          <?php if($dt['sex']=='L'){echo "&radic;";}?>
        </span></td>
        <td colspan="3">Laki-laki</td>
        <td width="19"></td>
        <td width="19"><span class="gb">
          <?php if($dt['sex']=='P'){echo "&radic;";}?>
        </span></td>
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
        <td colspan="10"><span class="gb">
          <?=$dt['gpa']?>
        </span></td>
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
        <td colspan="6"><span class="gb">
          <?=$dt['ditolong']?>
        </span></td>
        <td colspan="3" align="right">Tanggal</td>
        <td colspan="7" align="left">&nbsp;<span class="gb">
          <?=tglSQL($dt['tgl_ditolong'])?>
        </span></td>
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
        <td colspan="12"><span class="gb">
          <?=$dt['berat']?>
        </span></td>
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
        <td colspan="12"><span class="gb">
          <?=$dt['panjang']?>
        </span></td>
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
        <td colspan="12"><span class="gb">
          <?=$dt['lingkaran_kpl']?>
        </span></td>
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
        <td colspan="12"><span class="gb">
          <?=$dt['lingkar_dada']?>
        </span></td>
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
        <td colspan="12"><span class="gb">
          <?=$dt['apgar']?>
        </span></td>
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
        <td colspan="12"><span class="gb">
          <?=$dt['kuning']?>
        </span></td>
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
        <td colspan="12"><span class="gb">
          <?=$dt['data_lab']?>
        </span></td>
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
        <td colspan="12"><span class="gb">
          <?=$dt['gol_darah']?>
        </span></td>
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
        <td colspan="12"><span class="gb">
          <?=$dt['hg']?>
        </span></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td></td>
        <td colspan="8">- G6PD</td>
        <td>:</td>
        <td colspan="12"><span class="gb">
          <?=$dt['g6pd']?>
        </span></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td></td>
        <td colspan="8">- T4/TSH</td>
        <td>:</td>
        <td colspan="12"><span class="gb">
          <?=$dt['t4']?>
        </span></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td>b.</td>
        <td colspan="8">Pemeriksaan Radiologi</td>
        <td>:</td>
        <td colspan="12"><span class="gb">
          <?=$dt['xray']?>
        </span></td>
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
        <td colspan="20"><span class="gb">
          <?=$dt['terapi']?>
        </span></td>
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
        <td colspan="20"><span class="gb">
          <?=$dt['susu']?>
        </span></td>
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
        <td colspan="20"><span class="gb">
          <?=$dt['berat_pulang']?>
        </span></td>
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
        <td colspan="30"><span class="gb">
          <?=$dt['perawatan']?>
        </span></td>
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
        <td colspan="20" rowspan="2" valign="top"><span class="gb">
          <?=$dt['terapi_lanjut']?>
        </span></td>
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
        <td colspan="20" rowspan="2" valign="top"><span class="gb">
          <?=$dt['diagnosa']?>
        </span></td>
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
        <td valign="top">:</td>
        <td colspan="20" valign="top"><span class="gb">
          <?=tglSQL($dt['tgl_kembali'])?>
        </span></td>
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
        <td colspan="8">Medan,    
          <?php echo tgl_ina(date("Y-m-d"))?>
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
    <tr>
  <td align="center" colspan="3">
  <div align="center"><tr id="trTombol">
        <td class="noline" colspan="5" align="right"><input id="btnPrint" type="button" value="Print" onClick="cetak(document.getElementById('trTombol'));"/>
                <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/></td>
      </tr></div>
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
    </script>
<?php 
mysql_close($konek);
?>
</html>