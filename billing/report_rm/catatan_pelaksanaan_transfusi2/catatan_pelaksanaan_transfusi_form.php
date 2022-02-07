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



        <title>Keterangan Pemeriksaan Ulang Transfusi Darah</title>
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
<div align="center" id="form_in" style="display:block;">
<form name="form1" id="form1" action="ket_pemeriksaan_transfusi_darah_act.php">
                <input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    			<input type="hidden" name="id" id="id"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
<table width="1100" border="0" style="font:12px tahoma;">
  <tr>
    <td colspan="3" align="center">&nbsp;</td>
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
    <td colspan="3" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left"><span style="font:bold 15px tahoma;">RS PELINDO I</span></td>
  </tr>
  <tr>
    <td colspan="3" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="10" align="center" style="font:bold 15px tahoma;">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="10" align="center" style="font:bold 15px tahoma;">CATATAN PELAKSANAAN TRANSFUSI</td>
  </tr>
  <tr>
    <td width="229" >Hari / Tgl Transfusi: 
      <input name="tgl" type="text" id="tgl" size="10" onclick="gfPop.fPopCalendar(document.getElementById('tgl'),depRange);" /></td>
    <td width="61" >Diagnosis:</td>
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
    <td width="40" >&nbsp;</td>
    <td width="407" >Nomor Formulir Permintaan Darah:
      <label for="textfield3"></label>
      <input type="text" name="textfield2" id="textfield3" /></td>
    <td width="187" >Golongan Darah Pasien:
      <?=$dP['gol_darah'];?></td>
    <td width="16" >&nbsp;</td>
    </tr>
  <tr>
    <td colspan="10"><table cellspacing="0" cellpadding="2" >
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
              <label for="textfield14"></label></td>
            <td width="128" style="border-right:1px solid #000;">Jam diterima:
              <label for="textfield14"></label></td>
            <td style="border-right:1px solid #000; border-bottom:1px solid #000;"><strong>Petugas I</strong></td>
            <td style="border-bottom:1px solid #000;" colspan="5" align="center">Tanda Vital</td>
          </tr>
          <tr height="">
            <td colspan="3" style="border-right:3px solid #000" ><span>Jenis darah (volume) diminta:
              <label for="textfield15"></label>
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
            <td colspan="3" style="border-right:3px solid #000""><input type="text" name="textfield21" id="textfield12" /></td>
            <td colspan="3" valign="top" style="border-right:1px solid #000"><input type="text" name="textfield6" id="textfield5" /></td>
            <td style="border-top:1px solid #000; border-right:1px solid #000">Identitas kantong:</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">Waktu Mulai:</td>
            <td style="border-buttom:1px solid #000;border-right:1px solid #000;"><label for="textfield17"></label>
              <label for="textfield17"></label>
              <input type="text" name="textfield23" id="textfield17" />
              <label for="textfield17"></label></td>
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
              <select name="select3" id="select6">
                <option value="">Pilih</option>
                <option>PMI DKI</option>
                <option>Non DKI</option>
              </select></td>
            <td style="border-right:1px solid #000"><label for="select7"></label>
              <select name="select4" id="select7">
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
              <input type="text" name="textfield3" id="textfield15" />
            </span></td>
            <td colspan="3" valign="top" style="border-right:1px solid #000">Tanggal Kadaluarsa:
              <label for="textfield17"></label>
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
              <label for="textfield23"></label>
              <input name="textfield19" type="text" id="textfield23" size="10" /></td>
            <td style="border-right:1px solid #000"><label for="select7"></label>
              <select name="select4" id="select7">
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
              <input type="text" name="textfield4" id="textfield18" /></td>
            <td width="215" colspan="3" valign="top" style="border-right:1px solid #000">Golongan Darah Kantong:
              <label for="textfield24"></label>
              <input name="textfield24" type="text" id="textfield24" size="5" /></td>
            <td style="border-top:1px solid #000; border-right:1px solid #000">Keadaan Kantong:</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">Reaksi transfusi:</td>
            <td style="border-buttom:1px solid #000;border-right:1px solid #000;"><label for="textfield17"></label>
              <label for="textfield17"></label>
              <input type="text" name="textfield23" id="textfield17" />
              <label for="textfield17"></label></td>
            <td width="49" align="center" style="border-top:1px solid #000;border-right:1px solid #000;">Nyeri</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;">&nbsp;</td>
          </tr>
          <tr height="">
            <td align="center" style="border-right:1px solid #000">2</td>
            <td colspan="2" style="border-right:3px solid #000"><label for="textfield18"></label>
              <input type="text" name="textfield4" id="textfield18" /></td>
            <td colspan="3" valign="top" style="border-right:1px solid #000;">Volume:
              <label for="textfield25"></label>
              <input type="text" name="textfield26" id="textfield25" /></td>
            <td style="border-right:1px solid #000"><label for="select7"></label>
              <select name="select4" id="select7">
                <option value="">Pilih</option>
                <option>Baik</option>
                <option>Tidak Baik</option>
              </select></td>
            <td style="border-right:1px solid #000"><span>
              <select name="select5" id="select">
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
              <input type="text" name="textfield4" id="textfield18" /></td>
            <td style="border-right:1px solid #000;border-top:3px solid #000" colspan="3"><strong>Kantong darah II</strong></td>
            <td width="116" style="border-right:1px solid #000;border-top:3px solid #000;">Jam keluar:
              <label for="textfield14"></label></td>
            <td width="128" style="border-right:1px solid #000;border-top:3px solid #000;">Jam diterima:
              <label for="textfield14"></label></td>
            <td style="border-right:1px solid #000; border-bottom:1px solid #000;border-top:3px solid #000;"><strong>Petugas I</strong></td>
            <td style="border-bottom:1px solid #000;border-top:3px solid #000;" colspan="5" align="center">Tanda Vital</td>
            </tr>
          <tr height="">
            <td align="center" style="border-right:1px solid #000;">4</td>
            <td colspan="2" style="border-right:3px solid #000"><label for="textfield18"></label>
              <input type="text" name="textfield4" id="textfield18" /></td>
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
            <td colspan="3" valign="top" style="border-right:1px solid #000"><input type="text" name="textfield6" id="textfield5" /></td>
            <td style="border-top:1px solid #000; border-right:1px solid #000">Identitas kantong:</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">Waktu Mulai:</td>
            <td style="border-buttom:1px solid #000;border-right:1px solid #000;"><label for="textfield17"></label>
              <label for="textfield17"></label>
              <input type="text" name="textfield23" id="textfield17" />
              <label for="textfield17"></label></td>
            <td align="center" style="border-top:1px solid #000;border-right:1px solid #000;">T</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000">&nbsp;</td>
            </tr>
          <tr height="">
            <td colspan="3" rowspan="2" style="border-right:3px solid #000"><label for="textfield26"></label>
              <textarea name="textfield11" id="textfield26"></textarea>              <label for="textfield18"></label></td>
            <td colspan="3" valign="top" style="border-right:1px solid #000">UTD:
              <label for="select6"></label>
              <select name="select3" id="select6">
                <option value="">Pilih</option>
                <option>PMI DKI</option>
                <option>Non DKI</option>
              </select></td>
            <td style="border-right:1px solid #000"><label for="select7"></label>
              <select name="select4" id="select7">
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
              <label for="textfield17"></label>
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
            <td colspan="3" style="border-right:3px solid #000;border-top:1px solid #000"><label for="textfield26"></label>
              Alasan Pemberian pre-medikasi:              <label for="textfield18"></label></td>
            <td colspan="3" valign="top" style="border-right:1px solid #000">Jenis Darah:
              <label for="textfield23"></label>
              <input name="textfield19" type="text" id="textfield23" size="10" /></td>
            <td style="border-right:1px solid #000"><label for="select7"></label>
              <select name="select4" id="select7">
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
              <textarea name="textfield4" id="textfield18"></textarea>
              <br />
              <label for="textfield20"></label></td>
            <td colspan="3" valign="top" style="border-right:1px solid #000">Golongan Darah Kantong:
              <label for="textfield24"></label>
              <input name="textfield24" type="text" id="textfield24" size="5" /></td>
            <td style="border-top:1px solid #000; border-right:1px solid #000">Keadaan Kantong:</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">Reaksi transfusi:</td>
            <td style="border-buttom:1px solid #000;border-right:1px solid #000;"><label for="textfield17"></label>
              <label for="textfield17"></label>
              <input type="text" name="textfield23" id="textfield17" />
              <label for="textfield17"></label></td>
            <td width="49" align="center" style="border-top:1px solid #000;border-right:1px solid #000;">Nyeri</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;">&nbsp;</td>
            </tr>
          <tr height="">
            <td colspan="3" valign="top" style="border-right:1px solid #000">Volume:
              <label for="textfield25"></label>
              <input type="text" name="textfield26" id="textfield25" /></td>
            <td style="border-right:1px solid #000"><label for="select7"></label>
              <select name="select4" id="select7">
                <option value="">Pilih</option>
                <option>Baik</option>
                <option>Tidak Baik</option>
              </select></td>
            <td style="border-right:1px solid #000"><span>
              <select name="select5" id="select">
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
              <label for="textfield14"></label></td>
            <td width="128" style="border-right:1px solid #000;border-top:3px solid #000;">Jam diterima:
              <label for="textfield14"></label></td>
            <td style="border-right:1px solid #000; border-bottom:1px solid #000;border-top:3px solid #000;"><strong>Petugas I</strong></td>
            <td style="border-bottom:1px solid #000;border-top:3px solid #000;" colspan="5" align="center">Tanda Vital</td>
            </tr>
          <tr height="">
            <td colspan="3" style="border-top:1px solid #000 ; border-right:3px solid #000""><input name="textfield12" type="text" id="textfield3" size="15" />               tetes/menit</td>
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
            <td colspan="3" valign="top" style="border-right:1px solid #000"><input type="text" name="textfield6" id="textfield5" /></td>
            <td style="border-top:1px solid #000; border-right:1px solid #000">Identitas kantong:</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">Waktu Mulai:</td>
            <td style="border-buttom:1px solid #000;border-right:1px solid #000;"><label for="textfield17"></label>
              <label for="textfield17"></label>
              <input type="text" name="textfield23" id="textfield17" />
              <label for="textfield17"></label></td>
            <td align="center" style="border-top:1px solid #000;border-right:1px solid #000;">T</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000">&nbsp;</td>
            </tr>
          <tr height="">
            <td colspan="3" rowspan="2" style="border-right:3px solid #000""><label for="textfield27"></label>
              <textarea name="textfield13" id="textfield27"></textarea></td>
            <td colspan="3" valign="top" style="border-right:1px solid #000">UTD:
              <label for="select6"></label>
              <select name="select3" id="select6">
                <option value="">Pilih</option>
                <option>PMI DKI</option>
                <option>Non DKI</option>
              </select></td>
            <td style="border-right:1px solid #000"><label for="select7"></label>
              <select name="select4" id="select7">
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
              <label for="textfield17"></label>
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
              <label for="textfield23"></label>
              <input name="textfield19" type="text" id="textfield23" size="10" /></td>
            <td style="border-right:1px solid #000"><label for="select7"></label>
              <select name="select4" id="select7">
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
              <textarea name="textfield14" id="textfield28"></textarea>
<br />
              <label for="textfield20"></label></td>
            <td colspan="3" valign="top" style="border-right:1px solid #000">Golongan Darah Kantong:
              <label for="textfield24"></label>
              <input name="textfield24" type="text" id="textfield24" size="5" /></td>
            <td style="border-top:1px solid #000; border-right:1px solid #000">Keadaan Kantong:</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">Reaksi transfusi:</td>
            <td style="border-buttom:1px solid #000;border-right:1px solid #000;"><label for="textfield17"></label>
              <label for="textfield17"></label>
              <input type="text" name="textfield23" id="textfield17" />
              <label for="textfield17"></label></td>
            <td width="49" align="center" style="border-top:1px solid #000;border-right:1px solid #000;">Nyeri</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;">&nbsp;</td>
            </tr>
          <tr height="">
            <td colspan="3" valign="top" style="border-right:1px solid #000">Volume:
              <label for="textfield25"></label>
              <input type="text" name="textfield26" id="textfield25" /></td>
            <td style="border-right:1px solid #000"><label for="select7"></label>
              <select name="select4" id="select7">
                <option value="">Pilih</option>
                <option>Baik</option>
                <option>Tidak Baik</option>
              </select></td>
            <td style="border-right:1px solid #000"><span>
              <select name="select5" id="select">
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
              <label for="textfield14"></label></td>
            <td width="128" style="border-right:1px solid #000;border-top:3px solid #000;">Jam diterima:
              <label for="textfield14"></label></td>
            <td style="border-right:1px solid #000; border-bottom:1px solid #000;border-top:3px solid #000;"><strong>Petugas I</strong></td>
            <td style="border-bottom:1px solid #000;border-top:3px solid #000;" colspan="5" align="center">Tanda Vital</td>
            </tr>
          <tr height="">
            <td colspan="3" rowspan="2" style="border-right:3px solid #000""><label for="textfield29"></label>
              <textarea name="textfield15" id="textfield29"></textarea>
              <br />
              <label for="textfield20"></label></td>
            <td colspan="3" valign="top" style="border-right:1px solid #000">Nomor Stok:
              <label for="textfield5"></label>
              <input type="text" name="textfield6" id="textfield5" /></td>
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
              <select name="select2" id="select8">
                <option value="">Pilih</option>
                <option>PMI DKI</option>
                <option>Non DKI</option>
              </select></td>
            <td style="border-top:1px solid #000; border-right:1px solid #000">Identitas kantong:</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">Waktu Mulai:</td>
            <td style="border-buttom:1px solid #000;border-right:1px solid #000;"><label for="textfield17"></label>
              <label for="textfield17"></label>
              <input type="text" name="textfield23" id="textfield17" />
              <label for="textfield17"></label></td>
            <td align="center" style="border-top:1px solid #000;border-right:1px solid #000;">T</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000">&nbsp;</td>
            </tr>
          <tr height="">
            <td colspan="3" style="border-top:1px solid #000 ; border-right:3px solid #000"">Nama lengkap dokter:</td>
            <td colspan="3" valign="top" style="border-right:1px solid #000">Tanggal Kadaluarsa:
              <label for="textfield15"></label>
              <input name="tgl_k4" type="text" id="tgl_k4" size="10" onclick="gfPop.fPopCalendar(document.getElementById('tgl_k4'),depRange);" /> </td>
            <td style="border-right:1px solid #000"><label for="select7"></label>
              <select name="select4" id="select7">
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
              <input type="text" name="textfield16" id="textfield30" />
              <br />
              <label for="textfield20"></label></td>
            <td colspan="3" valign="top" style="border-right:1px solid #000">Jenis Darah:
              <label for="textfield16"></label>
              <input name="textfield8" type="text" id="textfield16" size="10" /></td>
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
              <input name="textfield9" type="text" id="textfield22" size="5" /></td>
            <td style="border-right:1px solid #000"><label for="select7"></label>
              <select name="select4" id="select7">
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
            <td colspan="3" style="border-right:3px solid #000""><input type="text" name="textfield17" id="textfield4" /></td>
            <td colspan="3" rowspan="3" style="border-right:1px solid #000">Volume:
              <label for="textfield32"></label>
              <input type="text" name="textfield10" id="textfield32" /></td>
            <td style="border-top:1px solid #000; border-right:1px solid #000">Keadaan Kantong:</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000">Reaksi transfusi:</td>
            <td style="border-buttom:1px solid #000;border-right:1px solid #000;"><label for="textfield17"></label>
              <label for="textfield17"></label>
              <input type="text" name="textfield23" id="textfield17" />
              <label for="textfield17"></label></td>
            <td width="49" align="center" style="border-top:1px solid #000;border-right:1px solid #000;">Nyeri</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
            <td style="border-top:1px solid #000;">&nbsp;</td>
            </tr>
          <tr height="">
            <td colspan="3" style="border-top:1px solid #000 ; border-right:3px solid #000"">Tanda Tangan</td>
            <td style="border-right:1px solid #000"><label for="select7"></label>
              <select name="select4" id="select7">
                <option value="">Pilih</option>
                <option>Baik</option>
                <option>Tidak Baik</option>
              </select></td>
            <td style="border-right:1px solid #000"><span>
              <select name="select5" id="select">
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
                    <td colspan="2">
                      <input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="tambah(this.value);" class="tblTambah"/>
                      <input type="button" id="btnHapus" name="btnHapus" value="Edit" onclick="edit();" class="tblTambah"/>
                      <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus();" class="tblHapus"/>                    </td>
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
            if(ValidateForm('name')){
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
			$('#nominal').val(sisip[1]);
			$('#nominal2').val(sisip[2]);
			$('#name').val(sisip[3]);
			$('#address').val(sisip[4]);
			$('#hubungan').val(sisip[5]);
			centang(sisip[6]);
			//cek(sisip[4]);
			/*$('#txt_biokimia_eval').val(sisip[4]);
			$('#txt_fisik').val(sisip[5]);
			$('#txt_fisik_eval').val(sisip[6]);
			$('#txt_gizi').val(sisip[7]);
			$('#txt_gizi_eval').val(sisip[8]);
			$('#txt_RwytPersonal').val(sisip[9]);
			$('#txt_RwytPersonal_eval').val(sisip[10]);
			$('#txt_diagnosa').val(a.cellsGetValue(a.getSelRow(),3));
			$('#txt_intervensi').val(a.cellsGetValue(a.getSelRow(),4));
			$('#txt_monev').val(a.cellsGetValue(a.getSelRow(),5));*/
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
            a.loadURL("ket_pemeriksaan_transfusi_darah_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Data Keterangan Pemeriksaan Ulang Transfusi Darah");
        a.setColHeader("NO,NO RM,NAMA PENANGGUNG JAWAB,ALAMAT,HUBUNGAN PASIEN,TGL INPUT,PENGGUNA");
        a.setIDColHeader(",no_rm,,,,,,");
        a.setColWidth("50,100,300,300,300,100,100");
        a.setCellAlign("center,center,left,left,left,center,center");
        a.setCellHeight(20);
        a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("ket_pemeriksaan_transfusi_darah_util.php?idPel=<?=$idPel?>");
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
		window.open("ket_pemeriksaan_transfusi_darah_cetak.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUsr?>","_blank");
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
