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
k.cara_keluar, a.bb as bb2, a.tb as tb2, IFNULL(pg.nama,'-') AS dr_rujuk, a.TENSI as tekanan_darah, a.suhu as suhu2,
CONCAT((CONCAT((CONCAT((CONCAT(p.alamat,' RT.',p.rt)),' RW.',p.rw)),', Desa ',w.nama)),', Kecamatan ',wi.nama) alamat_,
ku.no_reg  as no_reg2
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_pasien_keluar k ON k.pelayanan_id=pl.id
LEFT JOIN anamnese a ON a.KUNJ_ID=pl.kunjungan_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
LEFT JOIN b_ms_wilayah w
		ON p.desa_id = w.id
	LEFT JOIN b_ms_wilayah wi
		ON p.kec_id = wi.id
LEFT JOIN b_kunjungan ku
    ON ku.id=pl.kunjungan_id
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
$sqlKm="SELECT tk.tgl_in,tk.tgl_out FROM b_tindakan_kamar tk 
LEFT JOIN b_pelayanan p ON p.id=tk.pelayanan_id
WHERE tk.pelayanan_id='$idPel';";
$dK=mysql_fetch_array(mysql_query($sqlKm));
$usr=mysql_fetch_array(mysql_query("select * from b_ms_pegawai where id='$idUsr'"));
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
<div align="center" id="form_in" style="display:none;">
<form name="form1" id="form1" action="catatan_pelaksanaan_transfusi_act.php">
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
    <td width="109" valign="top" >Hari/Tgl Transfusi : 
      <input name="tgl" type="hidden" id="tgl" size="10" onclick="gfPop.fPopCalendar(document.getElementById('tgl'),depRange);" /></td>
    <td width="134" valign="top" ><?php
	  echo getHari(date('l')).", ".date('j ').getBulan(date('m')).date(' Y');
	   //tglSQL($dG['tgl']);?></td>
    <td width="53" valign="top">Diagnosis:</td>
    <td colspan="4" ><table width="100%" border="0">
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
    <td width="23" >&nbsp;</td>
    <td width="363" valign="top">Nomor Formulir Permintaan Darah:
      <label for="alasan"></label>
      <input type="text" name="formulir" id="formulir" /></td>
    <td width="187" valign="top">Golongan Darah Pasien:
      <?=$dP['gol_darah'];?></td>
    <td width="16" >&nbsp;</td>
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
            <td style="border-right:1px solid #000;"><input name="jam1" type="text" id="jam1" size="12" /></td>
            <td style="border-right:1px solid #000;"><input name="jam2" type="text" id="jam2" size="12" /></td>
            <td style="border-right:1px solid #000;">Nama Jelas</td>
            <td style="border-right:1px solid #000;">Jam</td>
            <td width="48" style="border-right:1px solid #000;"></td>
            <td width="37" style="border-right:1px solid #000;"></td>
            <td style="border-right:1px solid #000;">&nbsp;</td>
            <td width="43"></td>
          </tr>
          <tr height="">
            <td colspan="3" style="border-right:3px solid #000""><input type="text" name="jenis_darah" id="jenis_darah" /></td>
            <td colspan="3" valign="top" style="border-right:1px solid #000"><input type="text" name="nomor1" id="nomor1" /></td>
            <td style="border-top:1px solid #000; border-right:1px solid #000">Identitas kantong:</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">Waktu Mulai:</td>
            <td style="border-buttom:1px solid #000;border-right:1px solid #000;"><label for="dpjp"></label>
              <label for="dpjp"></label>
              <input type="text" name="nama1" id="nama1" />
              <label for="dpjp"></label></td>
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
              <select name="utd1" id="utd1">
                <option value="" selected="selected">Pilih</option>
                <option>PMI DKI</option>
                <option>Non DKI</option>
              </select></td>
            <td style="border-right:1px solid #000"><label for="select7"></label>
              <select name="kantong1" id="kantong1">
                <option value="">Pilih</option>
                <option>Sesuai</option>
                <option>Tidak</option>
              </select></td>
            <td style="border-right:1px solid #000"><span>
              <input name="jam3" type="text" id="jam3" size="12" />
            </span></td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">Paraf</td>
            <td align="center" style="border-top:1px solid #000;border-right:1px solid #000;">N</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000">&nbsp;</td>
          </tr>
          <tr height="">
            <td colspan="3" style="border-right:3px solid #000""><span>
              <input type="text" name="alasan" id="alasan" />
            </span></td>
            <td colspan="3" valign="top" style="border-right:1px solid #000">Tanggal Kadaluarsa:
              <label for="dpjp"></label>
              <input name="tgl_k1" type="text" id="tgl_k1" size="10" onclick="gfPop.fPopCalendar(document.getElementById('tgl_k1'),depRange);" /></td>
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
              <input name="js_darah1" type="text" id="js_darah1" size="10" /></td>
            <td style="border-right:1px solid #000"><label for="select7"></label>
              <select name="pasien1" id="pasien1">
                <option value="">Pilih</option>
                <option>Sesuai</option>
                <option>Tidak</option>
              </select></td>
            <td style="border-right:1px solid #000"><span>
              <input name="jam4" type="text" id="jam4" size="12" />
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
              <input type="text" name="urutan1" id="urutan1" /></td>
            <td width="215" colspan="3" valign="top" style="border-right:1px solid #000">Golongan Darah Kantong:
              <label for="gol_darah1"></label>
              <input name="gol_darah1" type="text" id="gol_darah1" size="5" /></td>
            <td style="border-top:1px solid #000; border-right:1px solid #000">Keadaan Kantong:</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">Reaksi transfusi:</td>
            <td style="border-buttom:1px solid #000;border-right:1px solid #000;"><label for="dpjp"></label>
              <label for="dpjp"></label>
              <input type="text" name="nama2" id="nama2" />
              <label for="dpjp"></label></td>
            <td width="49" align="center" style="border-top:1px solid #000;border-right:1px solid #000;">Nyeri</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;">&nbsp;</td>
          </tr>
          <tr height="">
            <td align="center" style="border-right:1px solid #000">2</td>
            <td colspan="2" style="border-right:3px solid #000"><label for="textfield18"></label>
              <input type="text" name="urutan2" id="urutan2" /></td>
            <td colspan="3" valign="top" style="border-right:1px solid #000;">Volume:
              <label for="textfield25"></label>
              <input type="text" name="volume1" id="volume1" /></td>
            <td style="border-right:1px solid #000"><label for="select7"></label>
              <select name="k_kantong1" id="k_kantong1">
                <option value="">Pilih</option>
                <option>Baik</option>
                <option>Tidak Baik</option>
              </select></td>
            <td style="border-right:1px solid #000"><span>
              <select name="transfusi1" id="transfusi1">
                <option value="">Pilih</option>
                <option>Ada</option>
                <option>Tidak ada</option>
              </select>
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
              <input type="text" name="urutan3" id="urutan3" /></td>
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
              <input type="text" name="urutan4" id="urutan4" /></td>
            <td style="border-right:1px solid #000;" colspan="3"><span>Nomor Stok:
              <label for="textfield16"></label>
            </span></td>
            <td style="border-right:1px solid #000;"><input name="jam5" type="text" id="jam5" size="12" /></td>
            <td style="border-right:1px solid #000;"><input name="jam6" type="text" id="jam6" size="12" /></td>
            <td style="border-right:1px solid #000;">Nama Jelas</td>
            <td style="border-right:1px solid #000;">Jam</td>
            <td width="48" style="border-right:1px solid #000;"></td>
            <td width="37" style="border-right:1px solid #000;"></td>
            <td style="border-right:1px solid #000;">&nbsp;</td>
            <td width="43"></td>
            </tr>
          <tr height="">
            <td colspan="3" style="border-right:3px solid #000;border-top:1px solid #000"><span>Pemberian pre-medikasi:</span></td>
            <td colspan="3" valign="top" style="border-right:1px solid #000"><input type="text" name="nomor2" id="nomor2" /></td>
            <td style="border-top:1px solid #000; border-right:1px solid #000">Identitas kantong:</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">Waktu Mulai:</td>
            <td style="border-buttom:1px solid #000;border-right:1px solid #000;"><label for="dpjp"></label>
              <label for="dpjp"></label>
              <input type="text" name="nama3" id="nama3" />
              <label for="dpjp"></label></td>
            <td align="center" style="border-top:1px solid #000;border-right:1px solid #000;">T</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000">&nbsp;</td>
            </tr>
          <tr height="">
            <td colspan="3" rowspan="2" style="border-right:3px solid #000"><label for="volume1"></label>
              <textarea name="pre" id="pre"></textarea>              <label for="textfield18"></label></td>
            <td colspan="3" valign="top" style="border-right:1px solid #000">UTD:
              <label for="select6"></label>
              <select name="utd2" id="utd2">
                <option value="">Pilih</option>
                <option>PMI DKI</option>
                <option>Non DKI</option>
              </select></td>
            <td style="border-right:1px solid #000"><label for="select7"></label>
              <select name="kantong2" id="kantong2">
                <option value="">Pilih</option>
                <option>Sesuai</option>
                <option>Tidak</option>
              </select></td>
            <td style="border-right:1px solid #000"><span>
              <input name="jam7" type="text" id="jam7" size="12" />
            </span></td>
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
              <input name="tgl_k2" type="text" id="tgl_k2" size="10" onclick="gfPop.fPopCalendar(document.getElementById('tgl_k2'),depRange);" /></td>
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
              <input name="js_darah2" type="text" id="js_darah2" size="10" /></td>
            <td style="border-right:1px solid #000"><label for="select7"></label>
              <select name="pasien2" id="pasien2">
                <option value="">Pilih</option>
                <option>Sesuai</option>
                <option>Tidak</option>
              </select></td>
            <td style="border-right:1px solid #000"><span>
              <input name="jam8" type="text" id="jam8" size="12" />
            </span></td>
            <td style="border-right:1px solid #000;border-top:1px solid #000">Nama Jelas</td>
            <td align="center" style="border-top:1px solid #000;border-right:1px solid #000;">P</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000">&nbsp;</td>
            </tr>
          <tr height="">
            <td colspan="3" rowspan="2" style="border-right:3px solid #000"><label for="textfield18"></label>
              <textarea name="a_pemberian_pre" id="a_pemberian_pre"></textarea>
              <br />
              <label for="textfield20"></label></td>
            <td colspan="3" valign="top" style="border-right:1px solid #000">Golongan Darah Kantong:
              <label for="gol_darah1"></label>
              <input name="gol_darah2" type="text" id="gol_darah2" size="5" /></td>
            <td style="border-top:1px solid #000; border-right:1px solid #000">Keadaan Kantong:</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">Reaksi transfusi:</td>
            <td style="border-buttom:1px solid #000;border-right:1px solid #000;"><label for="dpjp"></label>
              <label for="dpjp"></label>
              <input type="text" name="nama4" id="nama4" />
              <label for="dpjp"></label></td>
            <td width="49" align="center" style="border-top:1px solid #000;border-right:1px solid #000;">Nyeri</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;">&nbsp;</td>
            </tr>
          <tr height="">
            <td colspan="3" valign="top" style="border-right:1px solid #000">Volume:
              <label for="textfield25"></label>
              <input type="text" name="volume2" id="volume2" /></td>
            <td style="border-right:1px solid #000"><label for="select7"></label>
              <select name="k_kantong2" id="k_kantong2">
                <option value="">Pilih</option>
                <option>Baik</option>
                <option>Tidak Baik</option>
              </select></td>
            <td style="border-right:1px solid #000"><span>
              <select name="transfusi2" id="transfusi2">
                <option value="">Pilih</option>
                <option>Ada</option>
                <option>Tidak ada</option>
                </select>
            </span></td>
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
            <td colspan="3" style="border-top:1px solid #000 ; border-right:3px solid #000""><input name="kecepatan" type="text" id="kecepatan" size="15" />               tetes/menit</td>
            <td style="border-right:1px solid #000;" colspan="3"><span>Nomor Stok:
              <label for="textfield16"></label>
            </span></td>
            <td style="border-right:1px solid #000;"><input name="jam9" type="text" id="jam9" size="12" /></td>
            <td style="border-right:1px solid #000;"><input name="jam10" type="text" id="jam10" size="12" /></td>
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
            <td colspan="3" valign="top" style="border-right:1px solid #000"><input type="text" name="nomor3" id="nomor3" /></td>
            <td style="border-top:1px solid #000; border-right:1px solid #000">Identitas kantong:</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">Waktu Mulai:</td>
            <td style="border-buttom:1px solid #000;border-right:1px solid #000;"><label for="dpjp"></label>
              <label for="dpjp"></label>
              <input type="text" name="nama5" id="nama5" />
              <label for="dpjp"></label></td>
            <td align="center" style="border-top:1px solid #000;border-right:1px solid #000;">T</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000">&nbsp;</td>
            </tr>
          <tr height="">
            <td colspan="3" rowspan="2" style="border-right:3px solid #000""><label for="textfield27"></label>
              <textarea name="target" id="target"></textarea></td>
            <td colspan="3" valign="top" style="border-right:1px solid #000">UTD:
              <label for="select6"></label>
              <select name="utd3" id="utd3">
                <option value="">Pilih</option>
                <option>PMI DKI</option>
                <option>Non DKI</option>
              </select></td>
            <td style="border-right:1px solid #000"><label for="select7"></label>
              <select name="kantong3" id="kantong3">
                <option value="">Pilih</option>
                <option>Sesuai</option>
                <option>Tidak</option>
              </select></td>
            <td style="border-right:1px solid #000"><span>
              <input name="jam11" type="text" id="jam11" size="12" />
            </span></td>
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
              <input name="tgl_k3" type="text" id="tgl_k3" size="10" onclick="gfPop.fPopCalendar(document.getElementById('tgl_k3'),depRange);" /></td>
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
              <input name="js_darah3" type="text" id="js_darah3" size="10" /></td>
            <td style="border-right:1px solid #000"><label for="select7"></label>
              <select name="pasien3" id="pasien3">
                <option value="">Pilih</option>
                <option>Sesuai</option>
                <option>Tidak</option>
              </select></td>
            <td style="border-right:1px solid #000"><span>
              <input name="jam12" type="text" id="jam12" size="12" />
            </span></td>
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
              <textarea name="pemeriksaan" id="pemeriksaan"></textarea>
<br />
              <label for="textfield20"></label></td>
            <td colspan="3" valign="top" style="border-right:1px solid #000">Golongan Darah Kantong:
              <label for="gol_darah1"></label>
              <input name="gol_darah3" type="text" id="gol_darah3" size="5" /></td>
            <td style="border-top:1px solid #000; border-right:1px solid #000">Keadaan Kantong:</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">Reaksi transfusi:</td>
            <td style="border-buttom:1px solid #000;border-right:1px solid #000;"><label for="dpjp"></label>
              <label for="dpjp"></label>
              <input type="text" name="nama6" id="nama6" />
              <label for="dpjp"></label></td>
            <td width="49" align="center" style="border-top:1px solid #000;border-right:1px solid #000;">Nyeri</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;">&nbsp;</td>
            </tr>
          <tr height="">
            <td colspan="3" valign="top" style="border-right:1px solid #000">Volume:
              <label for="textfield25"></label>
              <input type="text" name="volume3" id="volume3" /></td>
            <td style="border-right:1px solid #000"><label for="select7"></label>
              <select name="k_kantong3" id="k_kantong3">
                <option value="">Pilih</option>
                <option>Baik</option>
                <option>Tidak Baik</option>
              </select></td>
            <td style="border-right:1px solid #000"><span>
              <select name="transfusi3" id="select">
                <option value="">Pilih</option>
                <option>Ada</option>
                <option>Tidak ada</option>
                </select>
            </span></td>
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
              <textarea name="laporan" id="laporan"></textarea>
              <br />
              <label for="textfield20"></label></td>
            <td colspan="3" valign="top" style="border-right:1px solid #000">Nomor Stok:
              <label for="textfield5"></label>
              <input type="text" name="nomor4" id="nomor4" /></td>
            <td style="border-right:1px solid #000;"><input name="jam13" type="text" id="jam13" size="12" /></td>
            <td style="border-right:1px solid #000;"><input name="jam14" type="text" id="jam14" size="12" /></td>
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
              <select name="utd4" id="utd4">
                <option value="">Pilih</option>
                <option>PMI DKI</option>
                <option>Non DKI</option>
              </select></td>
            <td style="border-top:1px solid #000; border-right:1px solid #000">Identitas kantong:</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">Waktu Mulai:</td>
            <td style="border-buttom:1px solid #000;border-right:1px solid #000;"><label for="dpjp"></label>
              <label for="dpjp"></label>
              <input type="text" name="nama7" id="nama7" />
              <label for="dpjp"></label></td>
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
              <input name="tgl_k4" type="text" id="tgl_k4" size="10" onclick="gfPop.fPopCalendar(document.getElementById('tgl_k4'),depRange);" /> </td>
            <td style="border-right:1px solid #000"><label for="select7"></label>
              <select name="kantong4" id="kantong4">
                <option value="">Pilih</option>
                <option>Sesuai</option>
                <option>Tidak</option>
              </select></td>
            <td style="border-right:1px solid #000"><span>
              <input name="jam15" type="text" id="jam15" size="12" />
            </span></td>
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
              <input name="js_darah4" type="text" id="js_darah4" size="10" /></td>
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
              <input name="gol_darah4" type="text" id="gol_darah4" size="5" /></td>
            <td style="border-right:1px solid #000"><label for="select7"></label>
              <select name="pasien4" id="pasien4">
                <option value="">Pilih</option>
                <option>Sesuai</option>
                <option>Tidak</option>
              </select></td>
            <td style="border-right:1px solid #000"><span>
              <input name="jam16" type="text" id="jam16" size="12" />
            </span></td>
            <td style="border-right:1px solid #000;border-top:1px solid #000">Nama Jelas</td>
            <td align="center" style="border-top:1px solid #000;border-right:1px solid #000;">P</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000">&nbsp;</td>
            </tr>
          <tr height="">
            <td colspan="3" style="border-right:3px solid #000""><input type="text" name="dpjp" id="dpjp" /></td>
            <td colspan="3" rowspan="3" style="border-right:1px solid #000">Volume:
              <label for="textfield32"></label>
              <input type="text" name="volume4" id="volume4" /></td>
            <td style="border-top:1px solid #000; border-right:1px solid #000">Keadaan Kantong:</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">Reaksi transfusi:</td>
            <td style="border-buttom:1px solid #000;border-right:1px solid #000;"><label for="dpjp"></label>
              <label for="dpjp"></label>
              <input type="text" name="nama8" id="nama8" />
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
              <select name="k_kantong4" id="k_kantong4">
                <option value="">Pilih</option>
                <option>Baik</option>
                <option>Tidak Baik</option>
              </select></td>
            <td style="border-right:1px solid #000"><span>
              <select name="transfusi4" id="transfusi4">
                <option value="">Pilih</option>
                <option>Ada</option>
                <option>Tidak ada</option>
                </select>
            </span></td>
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
            <td style="border-bottom:1px solid #000;border-right:1px solid #000">&nbsp;</td>
            <td style="border-bottom:1px solid #000;border-right:1px solid #000">&nbsp;</td>
            <td style="border-bottom:1px solid #000;border-right:1px solid #000">&nbsp;</td>
            <td style="border-bottom:1px solid #000;border-right:1px solid #000">&nbsp;</td>
            <td style="border-bottom:1px solid #000;border-right:1px solid #000">&nbsp;</td>
            <td style="border-bottom:1px solid #000">&nbsp;</td>
          </tr>
          </table></td>
      </tr>
    </table>
      <div align="center"><input type="button" name="bt_save" id="bt_save" class="tblTambah" value="Simpan" onclick="return simpan()" />&nbsp;
        <input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/></div>
      
      </td>
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
                    <td colspan="2"><?php
                    if($_REQUEST['report']!=1){
					?>
                      <input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="tambah(this.value);" class="tblTambah"/>
                      <input type="button" id="btnHapus" name="btnHapus" value="Edit" onclick="edit();" class="tblTambah"/>
                      <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus();" class="tblHapus"/>                    <?php }?></td>
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
</div>
</body>
<script type="text/javascript">

		function toggle() {
    //parent.alertsize(document.body.scrollHeight);
}


        function simpan(action){
            //if(ValidateForm('tgl')){
				$("#form1").ajaxSubmit({
					  success:function(msg)
					  {
						alert(msg);
						batal();
						goFilterAndSort();
					  },
					});
			
            //}
        }
        
        function isiCombo(id,val,defaultId,targetId,evloaded){
            if(targetId=='' || targetId==undefined){
                targetId=id;
            }
            Request('../../combo_utils.php?all=1&id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'ok');
        }

        //isiCombo('cakupan','','','cakupan','');

        /*function setCakupan(val){
            if(val == 4){
                document.getElementById('tr_cakupan').style.display = 'table-row';
            }
            else{
                document.getElementById('tr_cakupan').style.display = 'none';
            }
        }*/

        function ambilData(){		
            var sisip = a.getRowId(a.getSelRow()).split('|');
			//$('#txt_anjuran').val(a.cellsGetValue(a.getSelRow(),3));
			$('#id').val(sisip[0]);
			$('#tgl').val(sisip[1]);
			$('#formulir').val(sisip[2]);
			$('#jenis_darah').val(sisip[3]);
			$('#alasan').val(sisip[4]);
			$('#urutan1').val(sisip[5]);
			$('#urutan2').val(sisip[6]);
			$('#urutan3').val(sisip[7]);
			$('#urutan4').val(sisip[8]);
			$('#pre').val(sisip[9]);
			$('#a_pemberian_pre').val(sisip[10]);
			$('#kecepatan').val(sisip[11]);
			$('#target').val(sisip[12]);
			$('#pemeriksaan').val(sisip[13]);
			$('#laporan').val(sisip[14]);
			$('#dpjp').val(sisip[15]);
			$('#nomor1').val(sisip[16]);
			$('#utd1').val(sisip[17]);
			$('#tgl_k1').val(sisip[18]);
			$('#js_darah1').val(sisip[19]);
			$('#gol_darah1').val(sisip[20]);
			$('#volume1').val(sisip[21]);
			$('#nomor2').val(sisip[22]);
			$('#utd2').val(sisip[23]);
			$('#tgl_k2').val(sisip[24]);
			$('#js_darah2').val(sisip[25]);
			$('#gol_darah2').val(sisip[26]);
			$('#volume2').val(sisip[27]);
			$('#nomor3').val(sisip[28]);
			$('#utd3').val(sisip[29]);
			$('#tgl_k3').val(sisip[30]);
			$('#js_darah3').val(sisip[31]);
			$('#gol_darah3').val(sisip[32]);
			$('#volume3').val(sisip[33]);
			$('#nomor4').val(sisip[34]);
			$('#utd4').val(sisip[35]);
			$('#tgl_k4').val(sisip[36]);
			$('#js_darah4').val(sisip[37]);
			$('#gol_darah4').val(sisip[38]);
			$('#volume4').val(sisip[39]);
			$('#jam1').val(sisip[40]);
			$('#jam2').val(sisip[41]);
			$('#jam3').val(sisip[42]);
			$('#jam4').val(sisip[43]);
			$('#kantong1').val(sisip[44]);
			$('#pasien1').val(sisip[45]);
			$('#k_kantong1').val(sisip[46]);
			$('#transfusi1').val(sisip[47]);
			$('#jam5').val(sisip[48]);
			$('#jam6').val(sisip[49]);
			$('#jam7').val(sisip[50]);
			$('#jam8').val(sisip[51]);
			$('#kantong2').val(sisip[52]);
			$('#pasien2').val(sisip[53]);
			$('#k_kantong2').val(sisip[54]);
			$('#transfusi2').val(sisip[55]);
			$('#jam9').val(sisip[56]);
			$('#jam10').val(sisip[57]);
			$('#jam11').val(sisip[58]);
			$('#jam12').val(sisip[59]);
			$('#kantong3').val(sisip[60]);
			$('#pasien3').val(sisip[61]);
			$('#k_kantong3').val(sisip[62]);
			$('#transfusi3').val(sisip[63]);
			$('#jam13').val(sisip[64]);
			$('#jam14').val(sisip[65]);
			$('#jam15').val(sisip[66]);
			$('#jam16').val(sisip[67]);
			$('#kantong4').val(sisip[68]);
			$('#pasien4').val(sisip[69]);
			$('#k_kantong4').val(sisip[70]);
			$('#transfusi4').val(sisip[71]);
			$('#nama1').val(sisip[72]);
			$('#nama2').val(sisip[73]);
			$('#nama3').val(sisip[74]);
			$('#nama4').val(sisip[75]);
			$('#nama5').val(sisip[76]);
			$('#nama6').val(sisip[77]);
			$('#nama7').val(sisip[78]);
			$('#nama8').val(sisip[79]);
			//centang(sisip[6]);
			//cek(sisip[4]);
			
			$('#act').val('edit');
        }

        function hapus(){
            var rowid = document.getElementById("id").value;
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
            var rowid = document.getElementById("id").value;
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
			//resetF();
			$('#form_in').slideUp(1000,function(){
		//toggle();
		});
        }
		
		function resetF(){
			$('#act').val('tambah');
			$('#id').val('');
			document.form1.reset();
           
			//centang(1,'L')
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
            a.loadURL("catatan_pelaksanaan_transfusi_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Data Catatan Pelaksanaan Transfusi");
        a.setColHeader("NO,NO RM,NAMA PASIEN,NOMOR FORMULIR,TGL INPUT,PENGGUNA");
        a.setIDColHeader(",no_rm,,,,,");
        a.setColWidth("50,100,300,300,100,100");
        a.setCellAlign("center,center,left,left,center,center");
        a.setCellHeight(20);
        a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("catatan_pelaksanaan_transfusi_util.php?idPel=<?=$idPel?>");
        a.Init();
		
		function tambah(){
			resetF();
			$('#form_in').slideDown(1000,function(){
		toggle();
		});
			
			}
		
		function cetak(){
		 var rowid = document.getElementById("id").value;
		 if(rowid==""){
				var rowidx =a.getRowId(a.getSelRow()).split('|');
				rowid=rowidx[0];
			 }
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			//if(rowid==''){
//					alert("Pilih data terlebih dahulu");
//				}else{	
		window.open("catatan_pelaksanaan_transfusi_cetak.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUsr?>","_blank");
				//}
		}
		
		
		function cek(tes){
		var list=tes.split('*=*');
		var list1 = document.form1.elements['c_chk[]'];
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			var val=list[0].split(',');
			  if (list1[i].value==val[i])
			  {
			   list1[i].checked = true;
			  }else{
					list1[i].checked = false;
					}
		  }
		}
		}
		
		function centang(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['radio[0]'];
		var list2 = document.form1.elements['radio[0]'];
		
		
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			  if (list1[i].value==list[0])
			  {
			   list1[i].checked = true;
			  }
		  }
		}
		if ( list2.length > 1 )
		{
		 for (i = 1; i < list2.length; i++)
			{
			  if (list2[i].value==list[1])
			  {
			   list2[i].checked = true;
			  }
		  }
		}
	}

function centang2(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['radio[1]'];
		var list2 = document.form1.elements['radio[1]'];
		var list3 = document.form1.elements['radio[1]'];
		
		
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			  if (list1[i].value==list[0])
			  {
			   list1[i].checked = true;
			  }
		  }
		}
		if ( list2.length > 1 )
		{
		 for (i = 1; i < list2.length; i++)
			{
			  if (list2[i].value==list[1])
			  {
			   list2[i].checked = true;
			  }
		  }
		}
		if ( list3.length > 2 )
		{
		 for (i = 2; i < list3.length; i++)
			{
			  if (list3[i].value==list[2])
			  {
			   list3[i].checked = true;
			  }
		  }
		}
	}
		
/*function centang(tes,tes2){
		 var checkbox = document.form1.elements['rad_thd'];
		 var checkboxlp = document.form1.elements['rad_lp'];
		 
		 if ( checkbox.length > 0 )
		{
		 for (i = 0; i < checkbox.length; i++)
			{
			  if (checkbox[i].value==tes)
			  {
			   checkbox[i].checked = true;
			  }
		  }
		}
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
	}*/
    </script>
</html>
