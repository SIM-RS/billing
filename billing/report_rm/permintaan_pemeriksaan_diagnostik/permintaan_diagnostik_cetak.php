<?php
//session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUser'];
$sqlP="SELECT p.*,bk.no_reg,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,
CONCAT((CONCAT((CONCAT((CONCAT(p.alamat,' RT.',p.rt)),' RW.',p.rw)),', Desa ',w.nama)),', Kecamatan ',wi.nama) alamat_,
k.cara_keluar, a.bb as bb2, a.tb as tb2, IFNULL(pg.nama,'-') AS dr_rujuk, pg.id as kode
FROM b_pelayanan pl
INNER JOIN b_kunjungan bk ON pl.kunjungan_id=bk.id 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_wilayah w
 ON p.desa_id = w.id
LEFT JOIN b_ms_wilayah wi
 ON p.kec_id = wi.id
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

$dG=mysql_fetch_array(mysql_query("select * from b_pemeriksaan_diagnostik where id='$_REQUEST[id]'"));
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
        <script type="text/JavaScript">
            var arrRange = depRange = [];
        </script>
<title>Permintaan Pemeriksaan Diagnostik</title>
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
<table width="766" border="0" style="font:12px tahoma;">
  <tr>
    <td width="379" valign="bottom"><span style="font:bold 15px tahoma;">PERMINTAAN PEMERIKSAAN DIAGNOSTIK</span></td>
    <td width="379"><table width="496" border="0" align="right" cellpadding="4" bordercolor="#000000" style="border-collapse:collapse; border:1px solid #000000;">
      <tr>
        <td width="124">Nama Pasien</td>
        <td width="173">:
          <?=$dP['nama'];?></td>
        <td width="75"><span <?php if($dP['sex']=='L'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>L</span> / <span <?php if($dP['sex']=='P'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>P</span></td>
        <td width="104">&nbsp;</td>
        </tr>
      <tr>
        <td>Tanggal Lahir</td>
        <td>:
          <?=tglSQL($dP['tgl_lahir']);?></td>
        <td>Usia</td>
        <td>:
          <?=$dP['usia'];?>
          &nbsp;Thn</td>
        </tr>
      <tr>
        <td>No. RM</td>
        <td>:
          <?=$dP['no_rm'];?></td>
        <td>No Registrasi </td>
        <td>:
          <?=$dP['no_reg'];?></td>
        </tr>
      <tr>
        <td>Ruang Rawat/Kelas</td>
        <td>:
          <?=$dP['nm_unit'];?>
          /
          <?=$dP['nm_kls'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>Alamat</td>
        <td>:
          <?=$dP['alamat_'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td colspan="4" align="center">(Tempelkan Sticker Identitas Pasien)</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td colspan="2"><table cellspacing="0" cellpadding="2" style="border:1px solid #000000;">
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
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td width="64"></td>
        <td width="20"></td>
        <td width="138"></td>
        <td width="20"></td>
        <td width="64"></td>
        <td width="51"></td>
        <td></td>
        <td></td>
        <td width="92"></td>
        <td width="49"></td>
        <td width="58"></td>
        <td width="54"></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20" width="27">&nbsp;</td>
        <td colspan="6">Kode Dokter Pengirim : 
          <?=$dP['kode'];?></td>
        <td width="99"></td>
        <td width="13"></td>
        <td style="border:1px solid #000" colspan="4">No. Formulir :
          <label for="textfield"></label>
          <?=$dG['formulir'];?></td>
        <td width="37"></td>
        </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="9">Kode Konsultan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
          <label for="id_konsultan"></label>
          <?=$dG['id_konsultan'];?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
        <td colspan="5">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <?php 
	  $isi=explode(",",$dG['cek']);
	  ?>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="7">Permohonan yang diminta harap di coret:
          <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[0]=='1') { echo "checked='checked'";}?> />
          <label for="checkbox">cito</label>
          <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[1]=='2') { echo "checked='checked'";}?> />
          <label for="checkbox4">biasa</label></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[2]=='3') { echo "checked='checked'";}?> />
          <label for="checkbox2">Hasil Diserahkan ke Dokter</label></td>
        <td colspan="6"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[3]=='4') { echo "checked='checked'";}?> />
          <label for="checkbox3">Hasil Diserahkan ke Pasien</label></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
        <td colspan="5">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3">Diagnosa / Keterangan Klinik:</td>
        <td>&nbsp;</td>
        <td colspan="5">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="12"><table width="100%" border="0">
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
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
        <td colspan="5">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><strong>ENDOSKOPI</strong></td>
        <td>&nbsp;</td>
        <td colspan="5">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[4]=='5') { echo "checked='checked'";}?> />
          <label for="checkbox5">Gastroduodenoskopi</label></td>
        <td colspan="4"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[5]=='6') { echo "checked='checked'";}?> />
          <label for="checkbox8">Endosonografi</label></td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[6]=='7') { echo "checked='checked'";}?> />
          <label for="checkbox11">ERCP + Papilotomi</label></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[7]=='8') { echo "checked='checked'";}?> />
          <label for="checkbox6">Kolonoskopi</label></td>
        <td colspan="4"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[8]=='9') { echo "checked='checked'";}?> />
          <label for="checkbox9">Polipektomi</label></td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[9]=='10') { echo "checked='checked'";}?> />
          <label for="checkbox12">Ligas hemorrhoid</label></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[10]=='11') { echo "checked='checked'";}?> />
          <label for="checkbox7">Rektosigmoidoskopi</label></td>
        <td colspan="4"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[11]=='12') { echo "checked='checked'";}?> />
          <label for="checkbox10">Sklero - terapi</label></td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
        <td colspan="5">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><strong>USG</strong></td>
        <td>&nbsp;</td>
        <td colspan="5">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[12]=='13') { echo "checked='checked'";}?> />
          <label for="checkbox17">Kepala</label></td>
        <td colspan="4"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[13]=='14') { echo "checked='checked'";}?> />
          <label for="checkbox18">Muskuloskeletal (anak)</label></td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[14]=='15') { echo "checked='checked'";}?> />
          <label for="checkbox19">Wrist Join&nbsp;&nbsp;&nbsp;ka/ki</label></td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[15]=='16') { echo "checked='checked'";}?> />
          <label for="checkbox27">Guiding</label></td>
        </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[16]=='17') { echo "checked='checked'";}?> />
          <label for="checkbox14">Thyroid</label></td>
        <td colspan="4"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[17]=='18') { echo "checked='checked'";}?> />
          <label for="checkbox15">Abdomen Bawah</label></td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[18]=='19') { echo "checked='checked'";}?> />
          <label for="checkbox16"> Knee Joint&nbsp;&nbsp;&nbsp;ka/ki</label></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[19]=='20') { echo "checked='checked'";}?> />
          <label for="checkbox12">Mammae</label></td>
        <td colspan="4"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[20]=='21') { echo "checked='checked'";}?> />
          Jantung</td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[21]=='22') { echo "checked='checked'";}?> />
          <label for="checkbox26">Calcaneus&nbsp;&nbsp;&nbsp;ka/ki</label></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[22]=='23') { echo "checked='checked'";}?> />
          <label for="checkbox20">Whole Abdomen</label></td>
        <td colspan="4"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[23]=='24') { echo "checked='checked'";}?> />
          <label for="checkbox23">Ginekologi-Obstetri/Genitalia</label></td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[24]=='25') { echo "checked='checked'";}?> />
          <label for="checkbox28">Kepala (bayi)</label></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[25]=='26') { echo "checked='checked'";}?> />
          <label for="checkbox21">Whole Abdomen Appendix</label></td>
        <td colspan="4"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[26]=='27') { echo "checked='checked'";}?> />
          <label for="checkbox24">Extremitas</label></td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[27]=='28') { echo "checked='checked'";}?> />
          <label for="checkbox29">Abdomen (bayi)</label></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[28]=='29') { echo "checked='checked'";}?> />
          <label for="checkbox22">Abdomen Atas</label></td>
        <td colspan="4"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[29]=='30') { echo "checked='checked'";}?> />
          <label for="checkbox25">Shoulder Join&nbsp;&nbsp;&nbsp;ka/ki</label></td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[30]=='31') { echo "checked='checked'";}?> />
          <label for="checkbox30">Hip Join (bayi)</label></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
        <td colspan="5">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><strong>USG DOPPLER</strong></td>
        <td>&nbsp;</td>
        <td colspan="5">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[31]=='32') { echo "checked='checked'";}?> />
          <label for="checkbox35">Carotis-Vertebralis (Leher)</label></td>
        <td colspan="4"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[32]=='33') { echo "checked='checked'";}?> />
          <label for="checkbox36">Mammae</label></td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[33]=='34') { echo "checked='checked'";}?> />
          <label for="checkbox37">KGB</label></td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[34]=='35') { echo "checked='checked'";}?> />
          <label for="checkbox39">TCD</label></td>
        </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[35]=='36') { echo "checked='checked'";}?> />
          <label for="checkbox32">Hepar</label></td>
        <td colspan="4"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[36]=='37') { echo "checked='checked'";}?> />
          <label for="checkbox33">1. Extremitas (arteri)</label></td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[37]=='38') { echo "checked='checked'";}?> />
          <label for="checkbox34">Soft Tissue</label></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[38]=='39') { echo "checked='checked'";}?> />
          <label for="checkbox30">Ginjal</label></td>
        <td colspan="4"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[39]=='40') { echo "checked='checked'";}?> />
          <label for="checkbox31">2. Extremitas (vena)</label></td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[40]=='41') { echo "checked='checked'";}?> />
          <label for="checkbox38">Scrotum</label></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
        <td colspan="5">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><strong>USG 3D - 4D</strong></td>
        <td>&nbsp;</td>
        <td colspan="5">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[41]=='42') { echo "checked='checked'";}?> />
          <label for="checkbox45">Kebidanan Kehamilan</label></td>
        <td colspan="4"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[42]=='43') { echo "checked='checked'";}?> />
          <label for="checkbox46">Kebidanan Ginekologi</label></td>
        <td colspan="3">&nbsp;</td>
        <td colspan="3">&nbsp;</td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
        <td colspan="5">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><strong>PULMONOLOGI</strong></td>
        <td>&nbsp;</td>
        <td colspan="5">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[43]=='44') { echo "checked='checked'";}?> />Faal Paru Rutin</td>
        <td colspan="4"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[44]=='45') { echo "checked='checked'";}?> />
          <label for="checkbox56">Bronkoskopi+Biopsi</label></td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[45]=='46') { echo "checked='checked'";}?> />
          <label for="checkbox57">Punksi Pleura</label></td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[46]=='47') { echo "checked='checked'";}?> />
          <label for="checkbox58">Tes Alergi</label></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[47]=='48') { echo "checked='checked'";}?> />
          <label for="checkbox52">Faal Paru Lengkap</label></td>
        <td colspan="4"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[48]=='49') { echo "checked='checked'";}?> />
          Bronkoskopi+Biopsi+TV Guidance</td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[49]=='50') { echo "checked='checked'";}?> />
          <label for="checkbox54">Biopsi Pleura</label></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3" valign="top"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[50]=='51') { echo "checked='checked'";}?> />
          <label for="checkbox49">Bronkoskopi</label></td>
        <td colspan="4">&nbsp;</td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[51]=='52') { echo "checked='checked'";}?> />
          <label for="checkbox51">Biopsi Aspirasi<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Transthhorakal</label></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
        <td colspan="5">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><strong>NEOROLOGI</strong></td>
        <td colspan="4"><strong>T.H.T.</strong></td>
        <td colspan="3"><strong>KARDIOLOGI</strong></td>
        <td colspan="3"></td>
        </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[52]=='53') { echo "checked='checked'";}?> />
          <label for="checkbox66">E.E.G.</label></td>
        <td colspan="4"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[53]=='54') { echo "checked='checked'";}?> />
          <label for="checkbox67">Audiometri</label></td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[54]=='55') { echo "checked='checked'";}?> />
          <label for="checkbox68">Treadmill test</label></td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[55]=='56') { echo "checked='checked'";}?> />
          <label for="checkbox69">Echokardiografi +<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Doppler (Berwarna)</label></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[56]=='57') { echo "checked='checked'";}?> />
          <label for="checkbox63">E.M.G</label></td>
        <td colspan="4"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[57]=='58') { echo "checked='checked'";}?> />
          <label for="checkbox64">ENG</label></td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[58]=='59') { echo "checked='checked'";}?> />
          <label for="checkbox65"> E.K.G</label></td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[59]=='60') { echo "checked='checked'";}?> />
          <label for="checkbox41">Echokardiografi +<br />
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Doppler</label></td>
        </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td colspan="4"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[60]=='61') { echo "checked='checked'";}?> />
          <label for="checkbox40">Impedans</label></td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[61]=='62') { echo "checked='checked'";}?> />
          <label for="checkbox62">Hotel EKG</label></td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[62]=='63') { echo "checked='checked'";}?> />
          <label for="checkbox42">EECP</label></td>
        </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td colspan="4">&nbsp;</td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[63]=='64') { echo "checked='checked'";}?> />
          <label for="checkbox59">Hotel EKG</label></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td colspan="4">&nbsp;</td>
        <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[64]=='65') { echo "checked='checked'";}?> />
          <label for="checkbox47">Katheterisasi Jantung</label></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td colspan="4">&nbsp;</td>
        <td colspan="3">&nbsp;</td>
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
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="4">Tanggal : <?php echo tgl_ina(date("Y-m-d"))?></td>
        </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="4">Jam : 
          <?=date('h:i:s');?></td>
        </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="4">Dokter Pengirim,</td>
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
        <td colspan="4">(<strong><u>
          <?=$dP['dr_rujuk'];?></u>
        </strong>)</td>
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
                /*setTimeout('window.print()','1000');
                setTimeout('window.close()','2000');*/
				window.print();
                window.close();
            }
            else{
                tombol.style.visibility='visible';
            }

        }
    }

</script>