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
k.cara_keluar, a.bb as bb2, a.tb as tb2, IFNULL(pg.nama,'-') AS dr_rujuk, pg.id as kode
FROM b_pelayanan pl
INNER JOIN b_kunjungan bk ON pl.kunjungan_id=bk.id
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
<div align="center" id="form_in" style="display:none;">
<form name="form1" id="form1" action="permintaan_diagnostik_act.php">
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
        <td>: <?=$dP['no_reg'];?></td>
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
          <?=$dP['alamat'];?></td>
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
          <input type="text" name="formulir" id="formulir" /></td>
        <td width="37"></td>
        </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="9">Kode Konsultan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
          <label for="id_konsultan"></label>
          <input type="text" name="id_konsultan" id="id_konsultan" /></td>
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
        <td colspan="7">Permohonan yang diminta harap di coret:
          <input id="c_chk[]" type="checkbox" name="c_chk[0]" value="1" />
          <label for="checkbox">cito</label>
          <input id="c_chk[]" type="checkbox" name="c_chk[1]" value="2" />
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
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[2]" value="3" />
          <label for="checkbox2">Hasil Diserahkan ke Dokter</label></td>
        <td colspan="6"><input id="c_chk[]" type="checkbox" name="c_chk[3]" value="4" />
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
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[4]" value="5" />
          <label for="checkbox5">Gastroduodenoskopi</label></td>
        <td colspan="4"><input id="c_chk[]" type="checkbox" name="c_chk[5]" value="6" />
          <label for="checkbox8">Endosonografi</label></td>
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[6]" value="7" />
          <label for="checkbox11">ERCP + Papilotomi</label></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[7]" value="8" />
          <label for="checkbox6">Kolonoskopi</label></td>
        <td colspan="4"><input id="c_chk[]" type="checkbox" name="c_chk[8]" value="9" />
          <label for="checkbox9">Polipektomi</label></td>
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[9]" value="10" />
          <label for="checkbox12">Ligas hemorrhoid</label></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[10]" value="11" />
          <label for="checkbox7">Rektosigmoidoskopi</label></td>
        <td colspan="4"><input id="c_chk[]" type="checkbox" name="c_chk[11]" value="12" />
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
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[12]" value="13" />
          <label for="checkbox17">Kepala</label></td>
        <td colspan="4"><input id="c_chk[]" type="checkbox" name="c_chk[13]" value="14" />
          <label for="checkbox18">Muskuloskeletal (anak)</label></td>
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[14]" value="15" />
          <label for="checkbox19">Wrist Join&nbsp;&nbsp;&nbsp;ka/ki</label></td>
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[15]" value="16" />
          <label for="checkbox27">Guiding</label></td>
        </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[16]" value="17" />
          <label for="checkbox14">Thyroid</label></td>
        <td colspan="4"><input id="c_chk[]" type="checkbox" name="c_chk[17]" value="18" />
          <label for="checkbox15">Abdomen Bawah</label></td>
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[18]" value="19" />
          <label for="checkbox16"> Knee Joint&nbsp;&nbsp;&nbsp;ka/ki</label></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[19]" value="20" />
          <label for="checkbox12">Mammae</label></td>
        <td colspan="4"><input id="c_chk[]" type="checkbox" name="c_chk[20]" value="21" />
          Jantung</td>
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[21]" value="22" />
          <label for="checkbox26">Calcaneus&nbsp;&nbsp;&nbsp;ka/ki</label></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[22]" value="23" />
          <label for="checkbox20">Whole Abdomen</label></td>
        <td colspan="4"><input id="c_chk[]" type="checkbox" name="c_chk[23]" value="24" />
          <label for="checkbox23">Ginekologi-Obstetri/Genitalia</label></td>
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[24]" value="25" />
          <label for="checkbox28">Kepala (bayi)</label></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[25]" value="26" />
          <label for="checkbox21">Whole Abdomen Appendix</label></td>
        <td colspan="4"><input id="c_chk[]" type="checkbox" name="c_chk[26]" value="27" />
          <label for="checkbox24">Extremitas</label></td>
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[27]" value="28" />
          <label for="checkbox29">Abdomen (bayi)</label></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[28]" value="29" />
          <label for="checkbox22">Abdomen Atas</label></td>
        <td colspan="4"><input id="c_chk[]" type="checkbox" name="c_chk[29]" value="30" />
          <label for="checkbox25">Shoulder Join&nbsp;&nbsp;&nbsp;ka/ki</label></td>
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[30]" value="31" />
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
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[31]" value="32" />
          <label for="checkbox35">Carotis-Vertebralis (Leher)</label></td>
        <td colspan="4"><input id="c_chk[]" type="checkbox" name="c_chk[32]" value="33" />
          <label for="checkbox36">Mammae</label></td>
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[33]" value="34" />
          <label for="checkbox37">KGB</label></td>
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[34]" value="35" />
          <label for="checkbox39">TCD</label></td>
        </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[35]" value="36" />
          <label for="checkbox32">Hepar</label></td>
        <td colspan="4"><input id="c_chk[]" type="checkbox" name="c_chk[36]" value="37" />
          <label for="checkbox33">1. Extremitas (arteri)</label></td>
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[37]" value="38" />
          <label for="checkbox34">Soft Tissue</label></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[38]" value="39" />
          <label for="checkbox30">Ginjal</label></td>
        <td colspan="4"><input id="c_chk[]" type="checkbox" name="c_chk[39]" value="40" />
          <label for="checkbox31">2. Extremitas (vena)</label></td>
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[40]" value="41" />
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
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[41]" value="42" />
          <label for="checkbox45">Kebidanan Kehamilan</label></td>
        <td colspan="4"><input id="c_chk[]" type="checkbox" name="c_chk[42]" value="43" />
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
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[43]" value="44" />Faal Paru Rutin</td>
        <td colspan="4"><input id="c_chk[]" type="checkbox" name="c_chk[44]" value="45" />
          <label for="checkbox56">Bronkoskopi+Biopsi</label></td>
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[45]" value="46" />
          <label for="checkbox57">Punksi Pleura</label></td>
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[46]" value="47" />
          <label for="checkbox58">Tes Alergi</label></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[47]" value="48" />
          <label for="checkbox52">Faal Paru Lengkap</label></td>
        <td colspan="4"><input id="c_chk[]" type="checkbox" name="c_chk[48]" value="49" />
          Bronkoskopi+Biopsi+TV Guidance</td>
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[49]" value="50" />
          <label for="checkbox54">Biopsi Pleura</label></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3" valign="top"><input id="c_chk[]" type="checkbox" name="c_chk[50]" value="51" />
          <label for="checkbox49">Bronkoskopi</label></td>
        <td colspan="4">&nbsp;</td>
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[51]" value="52" />
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
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[52]" value="53" />
          <label for="checkbox66">E.E.G.</label></td>
        <td colspan="4"><input id="c_chk[]" type="checkbox" name="c_chk[53]" value="54" />
          <label for="checkbox67">Audiometri</label></td>
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[54]" value="55" />
          <label for="checkbox68">Treadmill test</label></td>
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[55]" value="56" />
          <label for="checkbox69">Echokardiografi +<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Doppler (Berwarna)</label></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[56]" value="57" />
          <label for="checkbox63">E.M.G</label></td>
        <td colspan="4"><input id="c_chk[]" type="checkbox" name="c_chk[57]" value="58" />
          <label for="checkbox64">ENG</label></td>
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[58]" value="59" />
          <label for="checkbox65"> E.K.G</label></td>
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[59]" value="60" />
          <label for="checkbox41">Echokardiografi +<br />
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Doppler</label></td>
        </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td colspan="4"><input id="c_chk[]" type="checkbox" name="c_chk[60]" value="61" />
          <label for="checkbox40">Impedans</label></td>
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[61]" value="62" />
          <label for="checkbox62">Hotel EKG</label></td>
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[62]" value="63" />
          <label for="checkbox42">EECP</label></td>
        </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td colspan="4">&nbsp;</td>
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[63]" value="64" />
          <label for="checkbox59">Hotel EKG</label></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td colspan="4">&nbsp;</td>
        <td colspan="3"><input id="c_chk[]" type="checkbox" name="c_chk[64]" value="65" />
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
        <td colspan="4">Tanggal :&nbsp;<?php echo tgl_ina(date("Y-m-d"))?></td>
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
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="4">Jam :&nbsp;
          <?=date('h:i:s');?></td>
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
        <td colspan="6"><div align="center">Dokter Pengirim,</div></td>
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
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="6"><div align="center">(<strong><u><?=$dP['dr_rujuk'];?></u></strong>)</div></td>
        <td></td>
        </tr>
      <tr height="">
        <td height="20">&nbsp;</td>
        <td height="20"></td>
        <td height="20"></td>
        <td height="20"></td>
        <td height="20"></td>
        <td height="20"></td>
        <td height="20"></td>
        <td colspan="6"><div align="center">Name and signature</div></td>
        <td height="20"></td>
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
            if(ValidateForm('id_konsultan')){
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
			$('#formulir').val(sisip[1]);
			$('#id_konsultan').val(sisip[2]);
			cek(sisip[3]);
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
            a.loadURL("permintaan_diagnostik_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Data Permintaan Pemeriksaan Diagnostik");
        a.setColHeader("NO,NO RM,NAMA,NO FORMULIR,KODE KONSULTAN,TGL INPUT,PENGGUNA");
        a.setIDColHeader(",no_rm,,,,,,");
        a.setColWidth("50,100,300,300,300,100,100");
        a.setCellAlign("center,center,left,left,left,center,center");
        a.setCellHeight(20);
        a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("permintaan_diagnostik_util.php?idPel=<?=$idPel?>");
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
		window.open("permintaan_diagnostik_cetak.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUsr?>","_blank");
				//}
		}
		
		
		function cek(tes){
		var val=tes.split(',');
		var list1 = document.form1.elements['c_chk[]'];
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			
			  if (list1[i].value==val[i])
			  {
			   list1[i].checked = true;
			  }else{
					list1[i].checked = false;
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
