<?php
//session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUsr'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,
k.cara_keluar, a.bb as bb2, a.tb as tb2, IFNULL(pg.nama,'-') AS dr_rujuk, a.TENSI as tekanan_darah, a.suhu as suhu2
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_pasien_keluar k ON k.pelayanan_id=pl.id
LEFT JOIN anamnese a ON a.KUNJ_ID=pl.kunjungan_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
$sqlKm="SELECT tk.tgl_in,tk.tgl_out FROM b_tindakan_kamar tk 
LEFT JOIN b_pelayanan p ON p.id=tk.pelayanan_id
WHERE tk.pelayanan_id='$idPel';";
$dK=mysql_fetch_array(mysql_query($sqlKm));
$usr=mysql_fetch_array(mysql_query("select * from b_ms_pegawai where id='$idUsr'"));
?>
<?php

$dG=mysql_fetch_array(mysql_query("select * from b_ms_catatan_transfusi where id='$_REQUEST[id]'"));
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
	$('#jam5').timeEntry({show24Hours: true, showSeconds: true});
	$('#jam6').timeEntry({show24Hours: true, showSeconds: true});
	$('#jam7').timeEntry({show24Hours: true, showSeconds: true});
	$('#jam8').timeEntry({show24Hours: true, showSeconds: true});
	$('#jam9').timeEntry({show24Hours: true, showSeconds: true});
	$('#jam10').timeEntry({show24Hours: true, showSeconds: true});
	$('#jam11').timeEntry({show24Hours: true, showSeconds: true});
	$('#jam12').timeEntry({show24Hours: true, showSeconds: true});
	$('#jam13').timeEntry({show24Hours: true, showSeconds: true});
	$('#jam14').timeEntry({show24Hours: true, showSeconds: true});
	$('#jam15').timeEntry({show24Hours: true, showSeconds: true});
	$('#jam16').timeEntry({show24Hours: true, showSeconds: true});
});
</script>
        <script type="text/JavaScript">
            var arrRange = depRange = [];
        </script>	



        <title>Catatan Pelaksanaan Transfusi</title>
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
</head>
<?
//include "setting.php";
?>
<style>

.gb{
	border-bottom:1px solid #000000;
}
</style>
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
<div id="form_in" style="display:block;">
<form name="form1" id="form1">
                <input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    			<input type="hidden" name="id" id="id"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
<table width="1100" border="0" style="font:12px tahoma;">
  <tr>
    <td colspan="4" align="center">&nbsp;</td>
    <td colspan="6" rowspan="5" align="center"><table width="496" border="0" align="right" cellpadding="4" bordercolor="#000000" style="border-collapse:collapse; border:1px solid #000000;">
      <tr>
        <td width="124">NRM</td>
        <td width="173">:
          <?=$dP['no_rm'];?></td>
        <td width="75">&nbsp;</td>
        <td width="104">&nbsp;</td>
        </tr>
      <tr>
        <td>Nama Lengkap</td>
        <td>:
          <?=$dP['nama'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>Jenis Kelamin</td>
        <td>: <span <?php if($dP['sex']=='L'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>L</span> / <span <?php if($dP['sex']=='P'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>P</span></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>Tanggal Lahir</td>
        <td>:
          <?=tglSQL($dP['tgl_lahir']);?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td colspan="4" align="left">(Mohon diisi atau tempelkan stiker jika ada)</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td colspan="4" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="left"><span style="font:bold 15px tahoma;">RS PELINDO I</span></td>
  </tr>
  <tr>
    <td colspan="4" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="11" align="center" style="font:bold 15px tahoma;">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="11" align="center" style="font:bold 15px tahoma;">CATATAN PELAKSANAAN TRANSFUSI</td>
  </tr>
  <tr>
    <td width="104" valign="top" >Hari/Tgl Transfusi : </td>
    <td width="135" valign="top" ><?php
	  echo getHari(date('l')).", ".date('j ').getBulan(date('m')).date(' Y');
	   //tglSQL($dG['tgl']);?></td>
    <td width="57" valign="top" >Diagnosis:</td>
    <td colspan="4" valign="top"><table width="100%" border="0">
      <?php $sqlD="SELECT md.nama FROM b_diagnosa d
LEFT JOIN b_ms_diagnosa md ON md.id=d.ms_diagnosa_id
LEFT JOIN b_kunjungan k ON k.id=d.kunjungan_id
WHERE d.pelayanan_id='$idPel';";
$exD=mysql_query($sqlD);
while($dD=mysql_fetch_array($exD)){
?>
      <tr>
        <td ><?=$dD['nama']?></td>
        </tr>
      <?php }?>
      <tr>
        <td >&nbsp;</td>
        </tr>
    </table></td>
    <td width="69" >&nbsp;</td>
    <td width="266" valign="top" >Nomor Formulir Permintaan Darah:
      <label for="alasan"></label>
      <?=$dG['formulir'];?></td>
    <td width="187" valign="top" >Golongan Darah Pasien:
      <?=$dP['gol_darah'];?></td>
    <td width="16">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="11"><table cellspacing="0" cellpadding="2" >
      <tr height="">
        <td colspan="3" valign="top"><table cellspacing="0" cellpadding="2" style="border:3px solid #000000;">
          <col width="27" />
          <col width="64" />
          <col width="20" />
          <col width="138" />
          <col width="20" />
          <col width="64" />
          <col width="51" />
          <col width="99" />
          <col width="13" />
          <col width="92" />
          <col width="49" />
          <col width="58" />
          <col width="54" />
          <col width="37" />
          <tr height="">
            <td colspan="3" align="center" style="border-right:3px solid #000; border-bottom:1px solid #000;" ><strong>INSTRUKSI OLEH DOKTER</strong></td>
            <td style="border-right:1px solid #000;" colspan="3"><strong>Kantong darah I</strong></td>
            <td width="116" style="border-right:1px solid #000;">Jam keluar:
              <label for="pemeriksaan"></label></td>
            <td width="128" style="border-right:1px solid #000;">Jam diterima:
              <label for="pemeriksaan"></label></td>
            <td style="border-right:1px solid #000; border-bottom:1px solid #000;"><strong>Petugas I</strong></td>
            <td style="border-bottom:1px solid #000;" colspan="5" align="center">Tanda Vital</td>
          </tr>
          <tr height="">
            <td colspan="3" style="border-right:3px solid #000" ><span>Jenis darah (volume) diminta:
              <label for="laporan"></label>
            </span></td>
            <td style="border-right:1px solid #000;" colspan="3"><span>Nomor Stok:
              <label for="textfield16"></label>
            </span></td>
            <td style="border-right:1px solid #000;"><?=$dG['jam1'];?></td>
            <td style="border-right:1px solid #000;"><?=$dG['jam2'];?></td>
            <td style="border-right:1px solid #000;">Nama Jelas</td>
            <td style="border-right:1px solid #000;">Jam</td>
            <td width="48" style="border-right:1px solid #000;"></td>
            <td width="37" style="border-right:1px solid #000;"></td>
            <td style="border-right:1px solid #000;">&nbsp;</td>
            <td width="43"></td>
          </tr>
          <tr height="">
            <td colspan="3" style="border-right:3px solid #000""><?=$dG['jenis_darah'];?></td>
            <td colspan="3" valign="top" style="border-right:1px solid #000"><span>
              <?=$dG['nomor1'];?>
            </span></td>
            <td style="border-top:1px solid #000; border-right:1px solid #000">Identitas kantong:</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">Waktu Mulai:</td>
            <td style="border-buttom:1px solid #000;border-right:1px solid #000;"><label for="dpjp"></label>
              <label for="dpjp"></label>
              <span>
              <?=$dG['nama1'];?>
              </span>              <label for="dpjp"></label></td>
            <td align="center" style="border-top:1px solid #000;border-right:1px solid #000;">T</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000">&nbsp;</td>
          </tr>
          <tr height="">
            <td colspan="3" style="border-top:1px solid #000; border-right:3px solid #000""><span>Alasan Transfusi:</span></td>
            <td colspan="3" valign="top" style="border-right:1px solid #000">UTD:
              <label for="select6"></label>
              <span>
              <?=$dG['utd1'];?>
              </span></td>
            <td style="border-right:1px solid #000"><label for="select7"></label>
              <span>
              <?=$dG['kantong1'];?>
              </span></td>
            <td style="border-right:1px solid #000"><span>
              <?=$dG['jam3'];?>
            </span></td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">Paraf</td>
            <td align="center" style="border-top:1px solid #000;border-right:1px solid #000;">N</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000">&nbsp;</td>
          </tr>
          <tr height="">
            <td colspan="3" style="border-right:3px solid #000""><?=$dG['alasan'];?></td>
            <td colspan="3" valign="top" style="border-right:1px solid #000">Tanggal Kadaluarsa:
              <label for="dpjp"></label>
              <?=tglSQL($dG['tgl_k1']);?></td>
            <td style="border-top:1px solid #000; border-right:1px solid #000">Identitas pasien:</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">Waktu selesai:</td>
            <td style="border-right:1px solid #000;border-top:1px solid #000"><strong>Petugas II</strong></td>
            <td align="center" style="border-top:1px solid #000;border-right:1px solid #000;">S</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td width="39" style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000">&nbsp;</td>
          </tr>
          <tr height="">
            <td colspan="3" style="border-top:1px solid #000; border-right:3px solid #000""><span>Urutan &amp; rencana jam pemberian:</span></td>
            <td colspan="3" valign="top" style="border-right:1px solid #000">Jenis Darah:
              <label for="nama1"></label>
              <span>
              <?=$dG['js_darah1'];?>
              </span></td>
            <td style="border-right:1px solid #000"><label for="select7"></label>
              <span >
              <?=$dG['pasien1'];?>
              </span></td>
            <td style="border-right:1px solid #000"><span>
              <?=$dG['jam4'];?>
            </span></td>
            <td style="border-right:1px solid #000;border-top:1px solid #000">Nama Jelas</td>
            <td align="center" style="border-top:1px solid #000;border-right:1px solid #000;">P</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000">&nbsp;</td>
          </tr>
          <tr height="">
            <td align="center" style="border-bottom:1px solid #000; border-right:1px solid #000;border-top:1px solid #000">1</td>
            <td width="167" colspan="2" style="border-bottom:1px solid #000 ; border-right:3px solid #000;border-top:1px solid #000;"><label for="textfield18"></label>
              <?=$dG['urutan1'];?></td>
            <td width="215" colspan="3" valign="top" style="border-right:1px solid #000">Golongan Darah Kantong:
              <label for="gol_darah1"></label>
              <span>
              <?=$dG['gol_darah1'];?>
              </span></td>
            <td style="border-top:1px solid #000; border-right:1px solid #000">Keadaan Kantong:</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">Reaksi transfusi:</td>
            <td style="border-buttom:1px solid #000;border-right:1px solid #000;"><label for="dpjp"></label>
              <label for="dpjp"></label>
              <span>
              <?=$dG['nama2'];?>
              </span>              <label for="dpjp"></label></td>
            <td width="49" align="center" style="border-top:1px solid #000;border-right:1px solid #000;">Nyeri</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;">&nbsp;</td>
          </tr>
          <tr height="">
            <td align="center" style="border-right:1px solid #000">2</td>
            <td colspan="2" style="border-right:3px solid #000"><label for="textfield18"></label>
              <?=$dG['urutan2'];?></td>
            <td colspan="3" valign="top" style="border-right:1px solid #000;">Volume:
              <label for="textfield25"></label>
              <span>
              <?=$dG['volume1'];?>
              </span></td>
            <td style="border-right:1px solid #000"><label for="select7"></label>
              <span>
              <?=$dG['k_kantong1'];?>
              </span></td>
            <td style="border-right:1px solid #000"><span>
              <?=$dG['transfusi1'];?>
            </span></td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">Paraf</td>
            <td width="49" align="center" style="border-top:1px solid #000;border-right:1px solid #000">Paraf</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">&nbsp;</td>
            <td style="border-top:1px solid #000;">&nbsp;</td>
          </tr>
          <tr height="">
            <td align="center" style="border-bottom:1px solid #000; border-right:1px solid #000;border-top:1px solid #000">3</td>
            <td colspan="2" style="border-bottom:1px solid #000 ; border-right:3px solid #000;border-top:1px solid #000;"><label for="textfield18"></label>
              <?=$dG['urutan3'];?></td>
            <td style="border-right:1px solid #000;border-top:3px solid #000" colspan="3"><strong>Kantong darah II</strong></td>
            <td width="116" style="border-right:1px solid #000;border-top:3px solid #000;">Jam keluar:
              <label for="pemeriksaan"></label></td>
            <td width="128" style="border-right:1px solid #000;border-top:3px solid #000;">Jam diterima:
              <label for="pemeriksaan"></label></td>
            <td style="border-right:1px solid #000; border-bottom:1px solid #000;border-top:3px solid #000;"><strong>Petugas I</strong></td>
            <td style="border-bottom:1px solid #000;border-top:3px solid #000;" colspan="5" align="center">Tanda Vital</td>
            </tr>
          <tr height="">
            <td align="center" style="border-right:1px solid #000;">4</td>
            <td colspan="2" style="border-right:3px solid #000"><label for="textfield18"></label>
              <?=$dG['urutan4'];?></td>
            <td style="border-right:1px solid #000;" colspan="3"><span>Nomor Stok:
              <label for="textfield16"></label>
            </span></td>
            <td style="border-right:1px solid #000;"><?=$dG['jam5'];?></td>
            <td style="border-right:1px solid #000;"><?=$dG['jam6'];?></td>
            <td style="border-right:1px solid #000;">Nama Jelas</td>
            <td style="border-right:1px solid #000;">Jam</td>
            <td width="48" style="border-right:1px solid #000;"></td>
            <td width="37" style="border-right:1px solid #000;"></td>
            <td style="border-right:1px solid #000;">&nbsp;</td>
            <td width="43"></td>
            </tr>
          <tr height="">
            <td colspan="3" style="border-right:3px solid #000;border-top:1px solid #000"><span>Pemberian pre-medikasi:</span></td>
            <td colspan="3" valign="top" style="border-right:1px solid #000"><?=$dG['nomor2'];?></td>
            <td style="border-top:1px solid #000; border-right:1px solid #000">Identitas kantong:</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">Waktu Mulai:</td>
            <td style="border-buttom:1px solid #000;border-right:1px solid #000;"><label for="dpjp"></label>
              <label for="dpjp"></label>
              <span>
              <?=$dG['nama3'];?>
              </span>              <label for="dpjp"></label></td>
            <td align="center" style="border-top:1px solid #000;border-right:1px solid #000;">T</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000">&nbsp;</td>
            </tr>
          <tr height="">
            <td colspan="3" rowspan="2" style="border-right:3px solid #000"><label for="volume1"></label>
              <?=$dG['pre'];?>              <label for="textfield18"></label></td>
            <td colspan="3" valign="top" style="border-right:1px solid #000">UTD:
              <label for="select6"></label>
              <?=$dG['utd2'];?></td>
            <td style="border-right:1px solid #000"><label for="select7"></label>
              <?=$dG['kantong2'];?></td>
            <td style="border-right:1px solid #000"><?=$dG['jam7'];?></td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">Paraf</td>
            <td align="center" style="border-top:1px solid #000;border-right:1px solid #000;">N</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000">&nbsp;</td>
            </tr>
          <tr height="">
            <td colspan="3" valign="top" style="border-right:1px solid #000">Tanggal Kadaluarsa:
              <label for="dpjp"></label>
              <?=tglSQL($dG['tgl_k2']);?></td>
            <td style="border-top:1px solid #000; border-right:1px solid #000">Identitas pasien:</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">Waktu selesai:</td>
            <td style="border-right:1px solid #000;border-top:1px solid #000"><strong>Petugas II</strong></td>
            <td align="center" style="border-top:1px solid #000;border-right:1px solid #000;">S</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td width="39" style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000">&nbsp;</td>
            </tr>
          <tr height="">
            <td colspan="3" style="border-right:3px solid #000;border-top:1px solid #000"><label for="volume1"></label>
              Alasan Pemberian pre-medikasi:              <label for="textfield18"></label></td>
            <td colspan="3" valign="top" style="border-right:1px solid #000">Jenis Darah:
              <label for="nama1"></label>
              <?=$dG['js_darah2'];?></td>
            <td style="border-right:1px solid #000"><label for="select7"></label>
              <?=$dG['pasien2'];?></td>
            <td style="border-right:1px solid #000"><?=$dG['jam8'];?></td>
            <td style="border-right:1px solid #000;border-top:1px solid #000">Nama Jelas</td>
            <td align="center" style="border-top:1px solid #000;border-right:1px solid #000;">P</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000">&nbsp;</td>
            </tr>
          <tr height="">
            <td colspan="3" rowspan="2" style="border-right:3px solid #000"><label for="textfield18"></label>
              <?=$dG['a_pemberian_pre'];?>
              <br />
              <label for="textfield20"></label></td>
            <td colspan="3" valign="top" style="border-right:1px solid #000">Golongan Darah Kantong:
              <label for="gol_darah1"></label>
              <?=$dG['gol_darah2'];?></td>
            <td style="border-top:1px solid #000; border-right:1px solid #000">Keadaan Kantong:</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">Reaksi transfusi:</td>
            <td style="border-buttom:1px solid #000;border-right:1px solid #000;"><label for="dpjp"></label>
              <label for="dpjp"></label>
              <span>
              <?=$dG['nama4'];?>
              </span>              <label for="dpjp"></label></td>
            <td width="49" align="center" style="border-top:1px solid #000;border-right:1px solid #000;">Nyeri</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;">&nbsp;</td>
            </tr>
          <tr height="">
            <td colspan="3" valign="top" style="border-right:1px solid #000">Volume:
              <label for="textfield25"></label>
              <?=$dG['volume2'];?></td>
            <td style="border-right:1px solid #000"><label for="select7"></label>
              <?=$dG['k_kantong2'];?></td>
            <td style="border-right:1px solid #000"><?=$dG['transfusi2'];?></td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">Paraf</td>
            <td width="49" align="center" style="border-top:1px solid #000;border-right:1px solid #000">Paraf</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">&nbsp;</td>
            <td style="border-top:1px solid #000;">&nbsp;</td>
            </tr>
          <tr height="">
            <td colspan="3" style="border-top:1px solid #000 ; border-right:3px solid #000"">Kecepatan Pemberian:</td>
            <td style="border-right:1px solid #000;border-top:3px solid #000" colspan="3"><strong>Kantong darah III</strong></td>
            <td width="116" style="border-right:1px solid #000;border-top:3px solid #000;">Jam keluar:
              <label for="pemeriksaan"></label></td>
            <td width="128" style="border-right:1px solid #000;border-top:3px solid #000;">Jam diterima:
              <label for="pemeriksaan"></label></td>
            <td style="border-right:1px solid #000; border-bottom:1px solid #000;border-top:3px solid #000;"><strong>Petugas I</strong></td>
            <td style="border-bottom:1px solid #000;border-top:3px solid #000;" colspan="5" align="center">Tanda Vital</td>
            </tr>
          <tr height="">
            <td colspan="3" style="border-top:1px solid #000 ; border-right:3px solid #000""><span>
              <?=$dG['kecepatan'];?>
            </span>               tetes/menit</td>
            <td style="border-right:1px solid #000;" colspan="3"><span>Nomor Stok:
              <label for="textfield16"></label>
            </span></td>
            <td style="border-right:1px solid #000;"><?=$dG['jam9'];?></td>
            <td style="border-right:1px solid #000;"><?=$dG['jam10'];?></td>
            <td style="border-right:1px solid #000;">Nama Jelas</td>
            <td style="border-right:1px solid #000;">Jam</td>
            <td width="48" style="border-right:1px solid #000;"></td>
            <td width="37" style="border-right:1px solid #000;"></td>
            <td style="border-right:1px solid #000;">&nbsp;</td>
            <td width="43"></td>
            </tr>
          <tr height="">
            <td colspan="3" style="border-top:1px solid #000 ; border-right:3px solid #000">Target pemberian transfusi:<br />
              <label for="textfield20"></label></td>
            <td colspan="3" valign="top" style="border-right:1px solid #000"><?=$dG['nomor3'];?></td>
            <td style="border-top:1px solid #000; border-right:1px solid #000">Identitas kantong:</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">Waktu Mulai:</td>
            <td style="border-buttom:1px solid #000;border-right:1px solid #000;"><label for="dpjp"></label>
              <label for="dpjp"></label>
              <span>
              <?=$dG['nama5'];?>
              </span>              <label for="dpjp"></label></td>
            <td align="center" style="border-top:1px solid #000;border-right:1px solid #000;">T</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000">&nbsp;</td>
            </tr>
          <tr height="">
            <td colspan="3" rowspan="2" style="border-right:3px solid #000""><label for="textfield27"></label>
              <?=$dG['target'];?></td>
            <td colspan="3" valign="top" style="border-right:1px solid #000">UTD:
              <label for="select6"></label>
              <?=$dG['utd3'];?></td>
            <td style="border-right:1px solid #000"><label for="select7"></label>
              <?=$dG['kantong3'];?></td>
            <td style="border-right:1px solid #000"><?=$dG['jam11'];?></td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">Paraf</td>
            <td align="center" style="border-top:1px solid #000;border-right:1px solid #000;">N</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000">&nbsp;</td>
            </tr>
          <tr height="">
            <td colspan="3" valign="top" style="border-right:1px solid #000">Tanggal Kadaluarsa:
              <label for="dpjp"></label>
              <?=tglSQL($dG['tgl_k3']);?></td>
            <td style="border-top:1px solid #000; border-right:1px solid #000">Identitas pasien:</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">Waktu selesai:</td>
            <td style="border-right:1px solid #000;border-top:1px solid #000"><strong>Petugas II</strong></td>
            <td align="center" style="border-top:1px solid #000;border-right:1px solid #000;">S</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td width="39" style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000">&nbsp;</td>
            </tr>
          <tr height="">
            <td colspan="3" style="border-top:1px solid #000 ; border-right:3px solid #000"">Pemeriksaan untuk monitoring:<br />
              <label for="textfield20"></label></td>
            <td colspan="3" valign="top" style="border-right:1px solid #000">Jenis Darah:
              <label for="nama1"></label>
              <?=$dG['js_darah3'];?></td>
            <td style="border-right:1px solid #000"><label for="select7"></label>
              <?=$dG['pasien3'];?></td>
            <td style="border-right:1px solid #000"><?=$dG['jam12'];?></td>
            <td style="border-right:1px solid #000;border-top:1px solid #000">Nama Jelas</td>
            <td align="center" style="border-top:1px solid #000;border-right:1px solid #000;">P</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000">&nbsp;</td>
            </tr>
          <tr height="">
            <td colspan="3" rowspan="2" style="border-right:3px solid #000""><label for="textfield20"></label>
              <label for="textfield28"></label>
              <?=$dG['pemeriksaan'];?>
              <br />
              <label for="textfield20"></label></td>
            <td colspan="3" valign="top" style="border-right:1px solid #000">Golongan Darah Kantong:
              <label for="gol_darah1"></label>
              <?=$dG['gol_darah3'];?></td>
            <td style="border-top:1px solid #000; border-right:1px solid #000">Keadaan Kantong:</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">Reaksi transfusi:</td>
            <td style="border-buttom:1px solid #000;border-right:1px solid #000;"><label for="dpjp"></label>
              <label for="dpjp"></label>
              <?=$dG['nama6'];?>              <label for="dpjp"></label></td>
            <td width="49" align="center" style="border-top:1px solid #000;border-right:1px solid #000;">Nyeri</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;">&nbsp;</td>
            </tr>
          <tr height="">
            <td colspan="3" valign="top" style="border-right:1px solid #000">Volume:
              <label for="textfield25"></label>
              <?=$dG['volume3'];?></td>
            <td style="border-right:1px solid #000"><label for="select7"></label>
              <?=$dG['k_kantong3'];?></td>
            <td style="border-right:1px solid #000"><?=$dG['transfusi3'];?></td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">Paraf</td>
            <td width="49" align="center" style="border-top:1px solid #000;border-right:1px solid #000">Paraf</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">&nbsp;</td>
            <td style="border-top:1px solid #000;">&nbsp;</td>
            </tr>
          <tr height="">
            <td colspan="3" style="border-top:1px solid #000 ; border-right:3px solid #000"">Laporkan hasil dengan segera, bila:<br />
              <label for="textfield20"></label></td>
            <td style="border-top:3px solid #000;border-right:1px solid #000" colspan="3"><strong>Kantong darah IV</strong></td>
            <td width="116" style="border-right:1px solid #000;border-top:3px solid #000;">Jam keluar:
              <label for="pemeriksaan"></label></td>
            <td width="128" style="border-right:1px solid #000;border-top:3px solid #000;">Jam diterima:
              <label for="pemeriksaan"></label></td>
            <td style="border-right:1px solid #000; border-bottom:1px solid #000;border-top:3px solid #000;"><strong>Petugas I</strong></td>
            <td style="border-bottom:1px solid #000;border-top:3px solid #000;" colspan="5" align="center">Tanda Vital</td>
            </tr>
          <tr height="">
            <td colspan="3" rowspan="2" style="border-right:3px solid #000""><label for="textfield29"></label>
              <?=$dG['laporan'];?>
              <br />
              <label for="textfield20"></label></td>
            <td colspan="3" valign="top" style="border-right:1px solid #000">Nomor Stok:
              <label for="textfield5"></label>
              <?=$dG['nomor4'];?></td>
            <td style="border-right:1px solid #000;"><?=$dG['jam13'];?></td>
            <td style="border-right:1px solid #000;"><?=$dG['jam14'];?></td>
            <td style="border-right:1px solid #000;">Nama Jelas</td>
            <td style="border-right:1px solid #000;">Jam</td>
            <td width="48" style="border-right:1px solid #000;"></td>
            <td width="37" style="border-right:1px solid #000;"></td>
            <td style="border-right:1px solid #000;">&nbsp;</td>
            <td width="43"></td>
            </tr>
          <tr height="">
            <td colspan="3" valign="top" style="border-right:1px solid #000">UTD:
              <label for="select8"></label>
              <?=$dG['utd4'];?></td>
            <td style="border-top:1px solid #000; border-right:1px solid #000">Identitas kantong:</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">Waktu Mulai:</td>
            <td style="border-buttom:1px solid #000;border-right:1px solid #000;"><label for="dpjp"></label>
              <label for="dpjp"></label>
              <?=$dG['nama7'];?>              <label for="dpjp"></label></td>
            <td align="center" style="border-top:1px solid #000;border-right:1px solid #000;">T</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000">&nbsp;</td>
            </tr>
          <tr height="">
            <td colspan="3" style="border-top:1px solid #000 ; border-right:3px solid #000"">Nama lengkap dokter:</td>
            <td colspan="3" valign="top" style="border-right:1px solid #000">Tanggal Kadaluarsa:
              <label for="laporan"></label>
              <?=tglSQL($dG['tgl_k4']);?></td>
            <td style="border-right:1px solid #000"><label for="select7"></label>
              <?=$dG['kantong4'];?></td>
            <td style="border-right:1px solid #000"><?=$dG['jam15'];?></td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">Paraf</td>
            <td align="center" style="border-top:1px solid #000;border-right:1px solid #000;">N</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000">&nbsp;</td>
            </tr>
          <tr height="">
            <td colspan="3" style="border-right:3px solid #000""><label for="textfield30"></label>
              <?=$dP['dr_rujuk'];?>
<br />
              <label for="textfield20"></label></td>
            <td colspan="3" valign="top" style="border-right:1px solid #000">Jenis Darah:
              <label for="textfield16"></label>
              <?=$dG['js_darah4'];?></td>
            <td style="border-top:1px solid #000; border-right:1px solid #000">Identitas pasien:</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">Waktu selesai:</td>
            <td style="border-right:1px solid #000;border-top:1px solid #000"><strong>Petugas II</strong></td>
            <td align="center" style="border-top:1px solid #000;border-right:1px solid #000;">S</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td width="39" style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000">&nbsp;</td>
            </tr>
          <tr height="">
            <td colspan="3" style="border-top:1px solid #000 ; border-right:3px solid #000"">Nama Lengkap DPJP:<br />
              <label for="textfield20"></label></td>
            <td colspan="3" style="border-right:1px solid #000">Golongan Darah Kantong:
              <label for="textfield22"></label>
              <?=$dG['gol_darah4'];?></td>
            <td style="border-right:1px solid #000"><label for="select7"></label>
              <?=$dG['pasien4'];?></td>
            <td style="border-right:1px solid #000"><?=$dG['jam16'];?></td>
            <td style="border-right:1px solid #000;border-top:1px solid #000">Nama Jelas</td>
            <td align="center" style="border-top:1px solid #000;border-right:1px solid #000;">P</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000">&nbsp;</td>
            </tr>
          <tr height="">
            <td colspan="3" style="border-right:3px solid #000""><?=$dG['dpjp'];?></td>
            <td colspan="3" rowspan="3" style="border-right:1px solid #000">Volume:
              <label for="textfield32"></label>
              <?=$dG['volume4'];?></td>
            <td style="border-top:1px solid #000; border-right:1px solid #000">Keadaan Kantong:</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">Reaksi transfusi:</td>
            <td style="border-buttom:1px solid #000;border-right:1px solid #000;"><label for="dpjp"></label>
              <?=$dG['nama8'];?>
<label for="dpjp"></label>
              <label for="dpjp"></label></td>
            <td width="49" align="center" style="border-top:1px solid #000;border-right:1px solid #000;">Nyeri</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;">&nbsp;</td>
            </tr>
          <tr height="">
            <td colspan="3" style="border-top:1px solid #000 ; border-right:3px solid #000"">Tanda Tangan</td>
            <td style="border-right:1px solid #000"><label for="select7"></label>
              <?=$dG['k_kantong4'];?></td>
            <td style="border-right:1px solid #000"><?=$dG['transfusi4'];?></td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">Paraf</td>
            <td width="49" align="center" style="border-top:1px solid #000;border-right:1px solid #000">Paraf</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">&nbsp;</td>
            <td style="border-top:1px solid #000;">&nbsp;</td>
            </tr>
          <tr valign="top" height="">
            <td colspan="3" style="border-right:3px solid #000;border-bottom:1px solid #000"><label for="textfield20"></label></td>
            <td style="border-bottom:1px solid #000;border-right:1px solid #000">&nbsp;</td>
            <td style="border-bottom:1px solid #000;border-right:1px solid #000">&nbsp;</td>
            <td width="150" style="border-bottom:1px solid #000;border-right:1px solid #000"><span>
              
            </span></td>
            <td style="border-bottom:1px solid #000;border-right:1px solid #000">&nbsp;</td>
            <td style="border-bottom:1px solid #000;border-right:1px solid #000">&nbsp;</td>
            <td style="border-bottom:1px solid #000;border-right:1px solid #000">&nbsp;</td>
            <td style="border-bottom:1px solid #000;border-right:1px solid #000">&nbsp;</td>
            <td style="border-bottom:1px solid #000">&nbsp;</td>
          </tr>
          </table></td>
      </tr>
    </table>
      <div id="trTombol" align="center"><input type="submit" name="button" id="button" value="Cetak" onclick="cetak(document.getElementById('trTombol'));" />
   									<input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/></div>
      
      </td>
  </tr>
  
</table>
</form>
</div>

<div id="tampil_data" align="center"></div>
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