<?php
session_start();
include("../../sesi.php");
$idUser = $_SESSION['userId'];
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
        <script type="text/javascript" src="jquery.maskedinput.js"></script>
        <script type="text/javascript" src="jquery.numeric.js"></script>
<style>
        .gb{
	border-bottom:1px solid #000000;
}
.inputan{
	width:80px;
	}
.textArea{ width:97%;}
body{background:#FFF;}
<!--
.style2 {font-size: 10px}
-->
.kotak{
border:1px solid #000000;
}
.kotak2{
border:1px solid #000000;
width:20px;
height:20px;
}
</style>
<title>Data Dasar Rumah Sakit</title>
</head>
<script type="text/JavaScript">
            var arrRange = depRange = [];
</script>
<body>
<?php
include ("../../koneksi/konek.php");
//====================================

//    $jnsLay = $_REQUEST['cmbJenisLayanan'];
//    $tmpLay = $_REQUEST['cmbTempatLayanan'];

/*    $sqlUnit = "SELECT id,nama FROM b_ms_unit WHERE id = '".$tmpLay."'";
    $rsUnit = mysql_query($sqlUnit);
    $rwUnit = mysql_fetch_array($rsUnit);
*/
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	
$tgl=date('d');
$bln=date('m');
$thn=date('Y');

$query="SELECT
kode_rs, tgl_registrasi, jenis_rs, kelas_rs, direktur_rs, penyelenggara_rs, humas_rs, website, tanah, bangunan, nomor, tgl_penetapan,
oleh, sifat, tahun, status_peny_swas, pentahapan, status, tgl_akreditasi, ruang_operasi,d_sub_spes, d_spes_lain, farmasi, t_kes_lain,t_non_kes, kode_b_profil, tgl_act, user_act
FROM b_profil_detail ORDER BY profil_detail_id DESC";
  $hasilx = mysql_query($query);
  $isi = mysql_fetch_array($hasilx);
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
<div id="tampil_input" align="center" style="display:none">
<form id="form1" name="form1" action="data_dasar_act.php">
<input type="hidden" name="idUser" value="<?=$idUser?>" />
<input type="hidden" name="id" id="id"/>
<input type="hidden" name="act" id="act" value="tambah"/>
<table width="750" border="0" cellpadding="0" cellspacing="0" style="font:12px tahoma">
  <tr>
    <td width="9%" height="20" style="border-bottom:2px solid #000000"><img src="logo-bakti-husada.jpg" width="55" height="60" /></td>
    <td width="39%" height="20" style="border-bottom:2px solid #000000"align="center"><strong>DATA DASAR RUMAH SAKIT</strong></td>
    <td width="52%" height="20" style="border-bottom:2px solid #000000"><table width="100%" border="0" style="border-collapse:collapse">
      <tr>
        <td colspan="4">&nbsp;</td>
        </tr>
      <tr>
	    <td width="23%">&nbsp;</td>
        <td width="77%" colspan="3" style="border-left:1px solid #000000; border-top:1px solid #000000; border-right:1px solid #000000;"><i> Ditjen Bina Upaya Kesehatan</i></td>
        </tr>
      <tr>
	  	<td>&nbsp;</td>
        <td colspan="3" style="border-left:1px solid #000000; border-bottom:1px solid #000000; border-right:1px solid #000000;"><i> Kementrian Kesehatan RI</i></td>
        </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><strong>Tanggal :</strong><strong>
      <?=$tgl.' '.$arrBln[$bln].' '.$thn?>
    </strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">
 <table width="100%" style="border:1px solid #000000">
   <tr>
    <td width="5%"><strong>1</strong></td>
    <td width="35%"><strong>Nomor Kode RS</strong></td>
    <td width="60%"><strong>:</strong>&nbsp;<input value="<?=$isi['kode_rs']?>" type="text" name="kode_rs" id="kode_rs"/></td>
  </tr>
  <tr>
    <td><strong>2</strong></td>
    <td><strong>Tanggal Registrasi </strong></td>
    <td><strong>:</strong>&nbsp;<input value="<?=tglSQL($isi['tgl_registrasi'])?>" type="text" name="tgl_registrasi" id="tgl_registrasi"/>&nbsp;
      <input id="ButtonTglReg" type="button" onclick="gfPop.fPopCalendar(document.getElementById('tgl_registrasi'),depRange);" tabindex="10" value=" V " name="ButtonTglReg"/></td>
  </tr>
  <tr>
    <td><strong>3</strong></td>
    <td><strong>Nama Rumah Sakit (Huruf Kapital) </strong></td>
    <td><strong>: 
      <?= strtoupper($namaRS)?>
    </strong></td>
  </tr>
  <tr>
    <td><strong>4</strong></td>
    <td><strong>Jenis Rumah Sakit</strong></td>
    <td><strong>:</strong>&nbsp;<input value="<?=$isi['jenis_rs']?>" type="text" name="jenis_rs" id="jenis_rs"/></td>
  </tr>
  <tr>
    <td><strong>5</strong></td>
    <td><strong>Kelas Rumah Sakit</strong></td>
    <td><strong>:</strong>&nbsp;<input value="<?=$isi['kelas_rs']?>" type="text" name="kelas_rs" id="kelas_rs"/></td>
  </tr>
  <tr>
    <td><strong>6</strong></td>
    <td><strong>Nama Direktur RS</strong></td>
    <td><strong>:</strong>&nbsp;<input value="<?=$isi['direktur_rs']?>" type="text" size="35" name="direktur_rs" id="direktur_rs"/></td>
  </tr>
  <tr>
    <td><strong>7</strong></td>
    <td><strong>Nama Penyelenggara RS</strong></td>
    <td><strong>:</strong>&nbsp;<input value="<?=$isi['penyelenggara_rs']?>" type="text" size="35" name="penyelenggara_rs" id="penyelenggara_rs"/></td>
  </tr>
  <tr>
    <td><strong>8</strong></td>
    <td><strong>Alamat / Lokasi RS</strong></td>
    <td width="50"><strong>: <?=$alamatRS;?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>8.1 Kab/Kota</strong></td>
    <td><strong>: 
      <?=$kotaRS;?>
    </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>8.2 Kode Pos </strong></td>
    <td><strong>: 
      <?=$kode_posRS;?>
    </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>8.3 Telepon </strong></td>
    <td><strong>: 
      <?=$tlpRS;?>
    </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>8.4 Fax </strong></td>
    <td><strong>: 
      <?=$faxRS;?>
    </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>8.5 Email </strong></td>
    <td><strong>: 
      <?=$emailRS;?>
    </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>8.6 Nomor Telp Bag. Umum/Humas RS </strong></td>
    <td><strong>:</strong>&nbsp;<input value="<?=$isi['humas_rs']?>" type="text" size="35" name="humas_rs" id="humas_rs"/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>8.7 Website </strong></td>
    <td><strong>:</strong>&nbsp;<input value="<?=$isi['website']?>" type="text" size="35" name="website" id="website"/></td>
  </tr>
  <tr>
    <td><strong>9</strong></td>
    <td><strong>Luas Rumah Sakit </strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>9.1 Tanah </strong></td>
    <td><strong>: 
      <input value="<?=$isi['tanah']?>" type="text" name="tanah" id="tanah"/>
    m2</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>9.2 Bangunan </strong></td>
    <td><strong>: 
      <input value="<?=$isi['bangunan']?>" type="text" name="bangunan" id="bangunan"/> m2 </strong></td>
  </tr><tr>
    <td><strong>10</strong></td>
    <td><strong>Surat Izin/Penetapan </strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>10.1 Nomor </strong></td>
    <td><strong>: 
      <input value="<?=$isi['nomor']?>" type="text" name="nomor" id="nomor"/>
    </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>10.2 Tanggal </strong></td>
    <td><strong>: 
      <input value="<?=tglSQL($isi['tgl_penetapan'])?>" type="text" name="tgl_penetapan" id="tgl_penetapan"/></strong>&nbsp;
      <input id="ButtonTglPen" type="button" onclick="gfPop.fPopCalendar(document.getElementById('tgl_penetapan'),depRange);" tabindex="10" value=" V " name="ButtonTglPen"/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>10.3 Oleh </strong></td>
    <td><strong>: 
      <input value="<?=$isi['oleh']?>" type="text" name="oleh" id="oleh"/>
    </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>10.4 Sifat </strong></td>
    <td><strong>: 
      <input value="<?=$isi['sifat']?>" type="text" name="sifat" id="sifat"/>
    </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>10.5 Masa Berlaku s/d thn </strong></td>
    <td><strong>: <input value="<?=$isi['tahun']?>" type="text" name="tahun" id="tahun"/></strong></td>
  </tr>
  <tr>
    <td><strong>11</strong></td>
    <td><strong>Status Penyelenggara Swasta </strong></td>
    <td><strong>: 
      <input value="<?=$isi['status_peny_swas']?>" type="text" name="status_peny_swas" id="status_peny_swas"/>
    </strong></td>
  </tr>
  <tr>
    <td><strong>12</strong></td>
    <td><strong>Akreditasi RS </strong></td>
    <td>&nbsp;</td>
  </tr><tr>
    <td>&nbsp;</td>
    <td><strong>12.1 Pentahapan </strong></td>
    <td><strong>: 
      <input value="<?=$isi['pentahapan']?>" type="text" name="pentahapan" id="pentahapan"/>
    </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>12.2 Status </strong></td>
    <td><strong>: 
      <input value="<?=$isi['status']?>" type="text" name="status" id="status"/>
    </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>12.3 Tanggal </strong></td>
    <td><strong>: 
      <input value="<?=tglSQL($isi['tgl_akreditasi'])?>" type="text" name="tgl_akreditasi" id="tgl_akreditasi" /></strong>&nbsp;
      <input id="ButtonTglAkredi" type="button" onclick="gfPop.fPopCalendar(document.getElementById('tgl_akreditasi'),depRange);" tabindex="10" value=" V " name="ButtonTglAkredi"/></td>
  </tr><tr>
    <td><strong>13</strong></td>
    <td><strong>Jumlah Tempat Tidur </strong></td>
    <td><strong> </strong></td>
  </tr>
  <?php
  /*$sql2="SELECT 
SUM(IF(b_ms_kelas.nama = 3,1,0)) kelas3,
SUM(IF(b_ms_kelas.nama = 2,1,0)) kelas2,
SUM(IF(b_ms_kelas.nama = 1,1,0)) kelas1,
SUM(IF(b_ms_kelas.nama = 'UTAMA',1,0)) vvip,
SUM(IF(b_ms_kelas.nama = 'VIP',1,0)) vip,
SUM(IF(b_ms_kelas.nama = 'ICU',1,0)) icu,
SUM(IF(b_ms_unit.nama = 'PICU',1,0)) picu,
SUM(IF(b_ms_unit.nama = 'ICCU',1,0)) iccu,
SUM(IF(b_ms_unit.nama = 'IGD',1,0)) igd,
SUM(IF(b_ms_unit.nama = '%NICU%',1,0)) nicu,
SUM(IF(b_ms_unit.nama = '%BERSALIN%',1,0)) bersalin
-- group_concat(b_ms_unit.nama),
-- GROUP_CONCAT(b_ms_kamar.nama)
FROM b_ms_kamar 
  INNER JOIN b_ms_kamar_tarip
    ON b_ms_kamar_tarip.kamar_id=b_ms_kamar.id
  INNER JOIN b_ms_kelas
    ON b_ms_kelas.id=b_ms_kamar_tarip.kelas_id
  INNER JOIN b_ms_unit 
    ON b_ms_kamar_tarip.unit_id = b_ms_unit.id
  WHERE b_ms_unit.aktif=1";*/
  $sql2="SELECT 
SUM(IF(b_ms_kelas.nama = 3,1,0)) kelas3,
SUM(IF(b_ms_kelas.nama = 2,1,0)) kelas2,
SUM(IF(b_ms_kelas.nama = 1,1,0)) kelas1,
SUM(IF(b_ms_kelas.nama LIKE '%UTAMA%',1,0)) vvip,
SUM(IF(b_ms_kelas.nama LIKE '%VIP%',1,0)) vip,
SUM(IF(b_ms_unit.nama LIKE '%ICU%',1,0)) icu,
SUM(IF(b_ms_unit.nama LIKE '%HCU%',1,0)) hcu,
SUM(IF(b_ms_unit.nama LIKE '%PICU%',1,0)) picu,
SUM(IF(b_ms_unit.nama LIKE '%ICCU%',1,0)) iccu,
SUM(IF(b_ms_unit.nama LIKE '%IGD%',1,0)) igd,
SUM(IF(b_ms_unit.nama LIKE '%NICU%',1,0)) nicu,
SUM(IF(b_ms_unit.nama LIKE '%BERSALIN%',1,0)) bersalin,
SUM(IF(b_ms_unit.nama LIKE '%ISOLASI%',1,0)) isolasi
-- group_concat(b_ms_unit.nama),
-- GROUP_CONCAT(b_ms_kamar.nama)
FROM b_ms_kamar 
  INNER JOIN b_ms_kamar_tarip
    ON b_ms_kamar_tarip.kamar_id=b_ms_kamar.id
  INNER JOIN b_ms_kelas
    ON b_ms_kelas.id=b_ms_kamar_tarip.kelas_id
  INNER JOIN b_ms_unit 
    ON b_ms_kamar_tarip.unit_id = b_ms_unit.id
  WHERE b_ms_unit.aktif=1";
  $hasil2 = mysql_query($sql2);
  $kamar = mysql_fetch_array($hasil2);  
  ?>
  <tr>
    <td>&nbsp;</td>
    <td><strong>13.1 Perinatalogi </strong></td>
    <td><strong>: <?= $kamar['nicu'];?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>13.2 Kelas VVIP </strong></td>
    <td><strong>: <?=$kamar['vvip']?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>13.3 Kelas VIP </strong></td>
    <td><strong>: <?=$kamar['vip'];?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>13.4 Kelas I </strong></td>
    <td><strong>: <?=$kamar['kelas1'];?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>13.5 Kelas II </strong></td>
    <td><strong>: <?=$kamar['kelas2'];?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>13.6 Kelas III </strong></td>
    <td><strong>: <?=$kamar['kelas3'];?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>13.7 ICU </strong></td>
    <td><strong>: <?=$kamar['icu'];?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>13.8 PICU </strong></td>
    <td><strong>: <?=$kamar['picu'];?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>13.9 NICU </strong></td>
    <td><strong>: <?=$kamar['nicu'];?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>13.10 HCU </strong></td>
    <td><strong>: <?=$kamar['hcu'];?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>13.11 ICCU </strong></td>
    <td><strong>:  <?=$kamar['icu'];?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>13.12 Ruang Isolasi </strong></td>
    <td><strong>:  <?=$kamar['isolasi'];?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>13.13 Ruang UGD </strong></td>
    <td><strong>:  <?=$kamar['igd'];?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>13.14 Ruang Bersalin </strong></td>
    <td><strong>: <?=$kamar['bersalin']?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>13.15 Ruang Operasi </strong></td>
    <td><strong>: <input value="<?=$isi['ruang_operasi']?>" type="text" name="ruang_operasi" id="ruang_operasi"/></strong></td>
  </tr>
  <tr>
    <td><strong>14</strong></td>
    <td><strong>Jumlah Tenaga Medis </strong></td>
    <td><strong></strong></td>
  </tr>
<?php
$sql="SELECT
SUM(IF(b_ms_pegawai.nama LIKE '%sp.A',1,0)) spA,
SUM(IF(b_ms_pegawai.nama LIKE '%sp.OG',1,0)) spOG,
SUM(IF(b_ms_pegawai.nama LIKE '%sp.PD',1,0)) spPD,
SUM(IF(b_ms_pegawai.nama LIKE '%sp.B',1,0)) spB,
SUM(IF(b_ms_pegawai.nama LIKE '%sp.Rad',1,0)) spRad,
SUM(IF(b_ms_pegawai.nama LIKE '%sp.RM',1,0)) spRM,
SUM(IF(b_ms_pegawai.nama LIKE '%sp.A%',1,0)) spAn,
SUM(IF(b_ms_pegawai.nama LIKE '%sp.JP',1,0)) spJP,
SUM(IF(b_ms_pegawai.nama LIKE '%sp.M',1,0)) spM,
SUM(IF(b_ms_pegawai.nama LIKE '%sp.THT%',1,0)) spTHT,
SUM(IF(b_ms_pegawai.nama LIKE '%sp.KJ',1,0)) spKJ,
SUM(IF(b_ms_pegawai.nama LIKE '%sp.P%',1,0)) spP,
SUM(IF(b_ms_pegawai.nama LIKE '%sp.PK%',1,0)) spPK,
SUM(IF(b_ms_pegawai.nama LIKE '%sp.S',1,0)) spS,
SUM(IF(b_ms_pegawai.spesialisasi_id = 62,1,0)) umum,
SUM(IF(b_ms_pegawai.spesialisasi_id = 8,1,0)) gigi,
SUM(IF(b_ms_pegawai.spesialisasi_id IN (35,36,37),1,0)) gigiSP,
SUM(IF(b_ms_pegawai.spesialisasi_id = 129,1,0)) perawat,
SUM(IF(b_ms_pegawai.spesialisasi_id IN (21,22),1,0)) bidan
FROM b_ms_pegawai
INNER JOIN b_ms_reference ON b_ms_reference.id=b_ms_pegawai.spesialisasi_id";
$hasil = mysql_query($sql);
$dok = mysql_fetch_array($hasil);
?>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.1 Dokkter Sp.A </strong></td>
    <td><strong>: <?= $dok['spA'];?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.2 Dokkter Sp.OG</strong></td>
    <td><strong>: <?=$dok['spOG'];?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.3 Dokter Sp.Pd </strong></td>
    <td><strong>: <?=$dok['spPD'];?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.4 Dokter Sp.B</strong></td>
    <td><strong>: <?=$dok['spB'];?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.5 Dokter Sp.Rad </strong></td>
    <td><strong>: <?=$dok['spRad'];?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.6 Dokter Sp.RM </strong></td>
    <td><strong>: <?=$dok['spRM'];?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.7 Dokter Sp.An </strong></td>
    <td><strong>: <?=$dok['spAn'];?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.8 Dokter Sp.JP </strong></td>
    <td><strong>: <?=$dok['spJP'];?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.9 Dokter Sp.M </strong></td>
    <td><strong>: <?=$dok['spM'];?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.10 Dokter Sp.THT </strong></td>
    <td><strong>: <?=$dok['spTHT'];?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.11 Dokter Sp.KJ </strong></td>
    <td><strong>: <?=$dok['spKJ'];?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.12 Dokter Sp.P </strong></td>
    <td><strong>: <?=$dok['spP'];?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.13 Dokter Sp.PK </strong></td>
    <td><strong>: <?=$dok['spPK'];?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.14 Dokter Sp.PD </strong></td>
    <td><strong>: <?=$dok['spPD'];?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.15 Dokter Sp.S </strong></td>
    <td><strong>: <?=$dok['spS'];?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.16 Dokter Sub Spesialis</strong></td>
    <td><strong>: <input value="<?=$isi['d_sub_spes']?>" type="text" name="d_sub_spes" id="d_sub_spes"/></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.17 Dokter Spesialis Lain </strong></td>
    <td><strong>: <input value="<?=$isi['d_spes_lain']?>" type="text" name="d_spes_lain" id="d_spes_lain"/></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.18 Dokter Umum </strong></td>
    <td><strong>: <?=$dok['umum'];?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.19 Dokter Gigi </strong></td>
    <td><strong>: <?=$dok['gigi'];?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.20 Dokter Gigi Spesialis </strong></td>
    <td><strong>: <?=$dok['gigiSP'];?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.21 Perawat </strong></td>
    <td><strong>: <?=$dok['perawat'];?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.22 Bidan </strong></td>
    <td><strong>: <?=$dok['bidan'];?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.23 Farmasi </strong></td>
    <td><strong>: <input value="<?=$isi['farmasi']?>" type="text" name="farmasi" id="farmasi"/></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.24 Tenaga Kesehatan Lainnya </strong></td>
    <td><strong>: <input value="<?=$isi['t_kes_lain']?>" type="text" name="t_kes_lain" id="t_kes_lain"/></strong></td>
  </tr>
  <tr>
    <td><strong>15</strong></td>
    <td><strong>Jumlah Tenaga Non Kesehatan </strong></td>
    <td><strong>: <input value="<?=$isi['t_non_kes']?>" type="text" name="t_non_kes" id="t_non_kes"/></strong></td>
  </tr>
  </table>
	</td>
  </tr>


     <tr id="trTombol">
                <td colspan="3" class="noline" align="center"><input type="button" name="bt_save" id="bt_save" class="tblTambah" value="Simpan" onclick="return simpan()" /> 
      &nbsp;<input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/></td>
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
                      <input type="button" id="btnHapus" name="btnHapus" value="Edit" onclick="edit();" class="tblTambah"/>
                      <!--<input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus();" class="tblHapus"/>-->                    </td>
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
                        <div id="gridbox" style="width:750; height:300px; background-color:white; overflow:hidden;"></div>
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
<script type="text/JavaScript">

		function toggle() {
    parent.alertsize(document.body.scrollHeight);
}

        function simpan(action){
			if(ValidateForm('kode_rs')){
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
        
        function ambilData(){		
            var sisip = a.getRowId(a.getSelRow()).split('|');
			//var rows = $('#gridbox').DSGridObject('getSelections');
			 //var p="id*-*"+sisip[0]+"*|*hari*-*"+sisip[1]+"*|*tgl*-*"+sisip[2]+"*|*istirahat*-*"+sisip[3]+"*|*tgl_mulai*-*"+sisip[4]+"*|*tgl_akhir*-*"+sisip[5]+"*|*inap*-*"+sisip[6]+"*|*tgl_mulai2*-*"+sisip[7]+"*|*tgl_akhir2*-*"+sisip[8]+"*|*tgl_per*-*"+sisip[9]+"*|*note*-*"+sisip[10]+"";
			var p ="id*-*"+sisip[0]+"*|*kode_rs*-*"+sisip[1]+"*|*tgl_registrasi*-*"+sisip[2]
				+"*|*jenis_rs*-*"+sisip[3]+"*|*kelas_rs*-*"+sisip[4]+"*|*direktur_rs*-*"+sisip[5]
				+"*|*penyelenggara_rs*-*"+sisip[6]+"*|*humas_rs*-*"+sisip[7]+"*|*website*-*"+sisip[8]
				+"*|*tanah*-*"+sisip[9]+"*|*bangunan*-*"+sisip[10]+"*|*nomor*-*"+sisip[11]
				+"*|*tgl_penetapan*-*"+sisip[12]+"*|*oleh*-*"+sisip[13]+"*|*sifat*-*"+sisip[14]
				+"*|*tahun*-*"+sisip[15]+"*|*status_peny_swas*-*"+sisip[16]+"*|*pentahapan*-*"+sisip[17]
				+"*|*status*-*"+sisip[18]+"*|*tgl_akreditasi*-*"+sisip[19]+"*|*ruang_operasi*-*"+sisip[20]
				+"*|*d_sub_spes*-*"+sisip[21]+"*|*d_spes_lain*-*"+sisip[22]+"*|*farmasi*-*"+sisip[23]
				+"*|*t_kes_lain*-*"+sisip[24]+"*|*t_non_kes*-*"+sisip[25]+"";
			 $('#act').val('edit'); 
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
			resetF();
			$('#tampil_input').slideUp(1000,function(){
			//toggle();
			});
        }
		
		function resetF(){
			$('#act').val('tambah');
			document.getElementById('form1').reset();
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
            a.loadURL("data_dasar_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>","","GET");
        }
		
        var a = new DSGridObject("gridbox");
        a.setHeader("DATA DASAR RUMAH SAKIT");
        a.setColHeader("NO,NAMA RUMAH SAKIT,TGL INPUT,PENGGUNA");
        a.setIDColHeader(",nama,tgl_act,pengguna");
        a.setColWidth("20,300,100,150");
        a.setCellAlign("center,left,center,left");
        a.setCellHeight(20);
        a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        a.onLoaded(ambilData);
        a.baseURL("data_dasar_util.php");
        a.Init();
		
		function tambah(){
			resetF();
			document.getElementById('kode_rs').value="";
			document.getElementById('tgl_registrasi').value="";
			document.getElementById('jenis_rs').value="";
			document.getElementById('kelas_rs').value="";
			document.getElementById('direktur_rs').value="";
			document.getElementById('penyelenggara_rs').value="";
			document.getElementById('humas_rs').value="";
			document.getElementById('website').value="";
			document.getElementById('tanah').value="";
			document.getElementById('bangunan').value="";
			document.getElementById('nomor').value="";
			document.getElementById('tgl_penetapan').value="";
			document.getElementById('oleh').value="";
			document.getElementById('sifat').value="";
			document.getElementById('tahun').value="";
			document.getElementById('status_peny_swas').value="";
			document.getElementById('pentahapan').value="";
			document.getElementById('status').value="";
			document.getElementById('tgl_akreditasi').value="";
			document.getElementById('ruang_operasi').value="";
			document.getElementById('d_sub_spes').value="";
			document.getElementById('d_spes_lain').value="";
			document.getElementById('farmasi').value="";
			document.getElementById('t_kes_lain').value="";
			document.getElementById('t_non_kes').value="";
			$('#tampil_input').slideDown(1000,function(){
		//toggle();
		});
			
			}
		
		function cetak()
		{
			var id = document.getElementById('id').value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(id=='')
			{
				alert("Pilih data terlebih dahulu untuk di cetak");
			}
			
			else
			{	
				window.open("form_data_dasar_rsv2.php?id="+id);
				//window.open("form_data_dasar_rsv2.php?id="+id,"_blank");
				//document.getElementById('id').value;
			}
		}
		
		jQuery(document).ready(function(){
			goFilterAndSort();
			jQuery("#tgl_registrasi").mask("99-99-9999");
			jQuery("#tgl_penetapan").mask("99-99-9999");
			jQuery("#tgl_akreditasi").mask("99-99-9999");
			jQuery("#tahun").mask("9999");
			jQuery("#tanah").numeric();
			jQuery("#bangunan").numeric();
			jQuery("#kode_rs").numeric();
			jQuery("#humas_rs").numeric();
			jQuery("#nomor").numeric();
			jQuery("#ruang_operasi").numeric();
			jQuery("#d_sub_spes").numeric();
			jQuery("#d_spes_lain").numeric();
			jQuery("#farmasi").numeric();
			jQuery("#t_kes_lain").numeric();
			jQuery("#t_non_kes").numeric();
		});

</script>
</html>