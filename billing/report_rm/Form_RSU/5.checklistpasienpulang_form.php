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
<title>Check list Pasien Pulang</title>
</head>
<?
include "../../koneksi/konek.php";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUser=$_REQUEST['idUsr'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,IFNULL(pg.nama,'-') AS dr_rujuk,DATE_FORMAT(p.tgl_act, '%d %M %Y') as tgl_masuk
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
//include "setting.php";
?>
<style>
        .gb{
	border-bottom:1px solid #000000;
}
.inputan{
	width:40px;
	}
.textArea{ width:100%;}
body{background:#FFF;}
        .style1 {font-size: 18px}
</style>
<style>
.kotak{
border:1px solid #000000;
text-align:center;
}
</style>
<body>
<div id="form_input" align="center" style="display:block">
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
<form id="form1" name="form1" action="5.checklistpasienpulang_act.php">
<input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUser" value="<?=$idUser?>" />
    			<input type="hidden" name="id" id="id"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
<table width="800" border="0">
  <tr>
    <td style="font:bold 16px tahoma;"><div align="center">CHECK LIST PASIEN PULANG</div></td>
  </tr>
  <tr>
    <td><table cellspacing="0" cellpadding="0" style="font:12px tahoma; border:1px solid #000000">
      <col width="27" />
      <col width="35" />
      <col width="22" />
      <col width="20" />
      <col width="138" />
      <col width="20" />
      <col width="34" />
      <col width="58" />
      <col width="99" />
      <col width="13" />
      <col width="92" />
      <col width="49" />
      <col width="30" />
      <col width="80" />
      <col width="37" />
      <tr height="21">
        <td colspan="15" height="21"><div align="center"><strong>PASIEN PULANG</strong></div></td>
      </tr>
      <tr height="20">
        <td width="39" height="20">&nbsp;</td>
        <td colspan="4">ADMINISTRASI</td>
        <td width="22"></td>
        <td width="16"></td>
        <td width="28"></td>
        <td width="13"></td>
        <td width="4"></td>
        <td width="4"></td>
        <td width="67"></td>
        <td width="67"></td>
        <td width="67"></td>
        <td width="29"></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td width="36"></td>
        <td width="29"></td>
        <td width="348"></td>
        <td width="23"></td>
        <td></td>
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
        <td><input type="checkbox" name="c_chk[0]" id="c_chk[]2" value="1" />          <label for="checkbox"></label></td>
        <td></td>
        <td colspan="5">Ijin pulang dari dokter yang merawat</td>
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
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td><input type="checkbox" name="c_chk[1]" id="c_chk[]" value="2" />
          <label for="checkbox2"></label></td>
        <td></td>
        <td colspan="5">Input ke komputer: pasien rencana    pulang</td>
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
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td><input type="checkbox" name="c_chk[2]" id="c_chk[]" value="3" />
          <label for="checkbox3"></label></td>
        <td></td>
        <td colspan="2">Stock order diet</td>
        <td></td>
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
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td ><input type="checkbox" name="c_chk[3]" id="c_chk[]" value="4" />
          <label for="checkbox4"></label></td>
        <td></td>
        <td colspan="2">Reture obat jika ada</td>
        <td></td>
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
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td ><input type="checkbox" name="c_chk[4]" id="c_chk[]" value="5" />
          <label for="checkbox5"></label></td>
        <td></td>
        <td colspan="2">Menyiapkan obat pulang</td>
        <td></td>
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
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td ><input type="checkbox" name="c_chk[5]" id="c_chk[]" value="6" />
          <label for="checkbox6"></label></td>
        <td></td>
        <td colspan="2">Surat keterangan sakit</td>
        <td></td>
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
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td ><input type="checkbox" name="c_chk[6]" id="c_chk[]" value="7" />
          <label for="checkbox7"></label></td>
        <td></td>
        <td colspan="2">Resume pasien pulang</td>
        <td></td>
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
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td ><input type="checkbox" name="c_chk[7]" id="c_chk[]" value="8" />
          <label for="checkbox9"></label></td>
        <td></td>
        <td colspan="2">Kartu lunas pembayaran</td>
        <td></td>
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
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td><input type="checkbox" name="c_chk[8]" id="c_chk[]" value="9" />
          <label for="checkbox8"></label></td>
        <td></td>
        <td colspan="3">Mengantar pasien keluar RS</td>
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
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="5">PENGECEKAN FASILITAS RUANGAN :</td>
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
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td ><input type="checkbox" name="c_chk[9]" id="c_chk[]" value="10" />
          <label for="checkbox10"></label></td>
        <td></td>
        <td colspan="2">Bed</td>
        <td></td>
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
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td ><input name="c_chk[10]" id="c_chk[]" value="11" type="checkbox" />
          <label for="c_chk[1]"></label></td>
        <td></td>
        <td colspan="2">TV/VCD/ Remote</td>
        <td></td>
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
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td><input type="checkbox" name="c_chk[11]" id="c_chk[]" value="12" />
          <label for="c_chk[]"></label></td>
        <td></td>
        <td colspan="2">Nurse Call</td>
        <td></td>
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
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td><input type="checkbox" name="c_chk[12]" id="c_chk[]" value="13" />
          <label for="checkbox13"></label></td>
        <td></td>
        <td colspan="2">Telepon/internet</td>
        <td></td>
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
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td ><input type="checkbox" name="c_chk[13]" id="c_chk[]" value="14" />
          <label for="checkbox14"></label></td>
        <td></td>
        <td colspan="2">AC</td>
        <td></td>
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
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td><input type="checkbox" name="c_chk[14]" id="c_chk[]" value="15" />
          <label for="checkbox15"></label></td>
        <td></td>
        <td colspan="2">Kamar Mandi, WC</td>
        <td></td>
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
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td ><input type="checkbox" name="c_chk[15]" id="c_chk[]" value="16" />
          <label for="checkbox16"></label></td>
        <td></td>
        <td colspan="2">Kulkas</td>
        <td></td>
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
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td><input type="checkbox" name="c_chk[16]" id="c_chk[]" value="17" />
          <label for="checkbox17"></label></td>
        <td></td>
        <td colspan="2">Large sheet</td>
        <td></td>
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
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td><input type="checkbox" name="c_chk[17]" id="c_chk[]" value="18" />
          <label for="checkbox18"></label></td>
        <td></td>
        <td colspan="2">Rubber Sheet</td>
        <td></td>
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
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td><input type="checkbox" name="c_chk[18]" id="c_chk[]" value="19" />
          <label for="checkbox19"></label></td>
        <td></td>
        <td colspan="2">Draw Sheet</td>
        <td></td>
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
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td><input type="checkbox" name="c_chk[19]" id="c_chk[]" value="20" />
          <label for="checkbox20"></label></td>
        <td></td>
        <td colspan="2">Blanket Sheet</td>
        <td></td>
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
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td ><input type="checkbox" name="c_chk[20]" id="c_chk[]" value="21" />
          <label for="checkbox21"></label></td>
        <td></td>
        <td colspan="2">Blanket</td>
        <td></td>
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
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td><input type="checkbox" name="c_chk[21]" id="c_chk[]" value="22" />
          <label for="checkbox22"></label></td>
        <td></td>
        <td colspan="2">Pillow</td>
        <td></td>
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
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td><input type="checkbox" name="c_chk[22]" id="c_chk[]" value="23" />
          <label for="checkbox23"></label></td>
        <td></td>
        <td colspan="2">Pillowslip</td>
        <td></td>
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
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td><input type="checkbox" name="c_chk[23]" id="c_chk[]" value="24" />
          <label for="checkbox24"></label></td>
        <td></td>
        <td colspan="2">Pajama/Gown</td>
        <td></td>
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
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td><input type="checkbox" name="c_chk[24]" id="c_chk[]" value="25" />
          <label for="checkbox25"></label></td>
        <td></td>
        <td colspan="2">Sofa/Furniture</td>
        <td></td>
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
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="4">KETERANGAN:</td>
        <td></td>
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
        <td colspan="14"><label for="keterangan"></label>
          <textarea name="keterangan" cols="50" rows="5" id="keterangan"></textarea></td>
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
        <td colspan="2">Medan,</td>
        <td>&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="2">Perawat</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="4">Pasien/Penanggung jawab</td>
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
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="4">(&hellip;&hellip;&hellip;&hellip;&hellip;...&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.)</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="3">(&hellip;&hellip;&hellip;&hellip;&hellip;...&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.)</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="4">Nama dan tandatangan</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3">Nama dan tandatangan</td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="4">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20" colspan="15" align="center"><input type="button" name="bt_save" id="bt_save" class="tblTambah" value="Simpan" onclick="return simpan()" /> 
      &nbsp;<input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/></td>
        </tr>
    </table></td>
  </tr>
</table>
</form>
</div>
<div id="tampil_data">
<table width="972" border="0" align="center" cellpadding="2" cellspacing="0">
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
  <tr>
    <td width="5%">&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="tambah(this.value);" class="tblTambah"/>
      <input type="button" id="btnHapus" name="btnHapus" value="Edit" onclick="edit();" class="tblTambah"/>
      <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus();" class="tblHapus"/></td>
    <td width="6%"><button type="button" id="btnTree" name="btnTree" value="Tampilan Tree" onclick="cetak()" class="tblViewTree" >Cetak</button></td>
    <td width="20%">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="5" align="left"><div id="gridbox" style="width:1000px; height:300px; background-color:white; overflow:hidden;"></div>      
      <div id="paging" style="width:1000px;"></div></td>
    </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="15%">&nbsp;</td>
    <td width="54%">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
</body>
<script type="text/javascript">
        function simpan(action){
            if(ValidateForm('keterangan')){
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
        
        /*function isiCombo(id,val,defaultId,targetId,evloaded){
            if(targetId=='' || targetId==undefined){
                targetId=id;
            }
            Request('../combo_utils.php?all=1&id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'ok');
        }*/

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
			 var p="id*-*"+sisip[0]+"*|*penerima_kuasa*-*"+sisip[1]+"*|*alamat*-*"+sisip[2]+"*|*no_ktp*-*"+sisip[3]+"*|*tgl_r*-*"+sisip[4]+"*|*tgl_l*-*"+sisip[5]+"*|*tgl_ra*-*"+sisip[6]+"*|*hasil_lain*-*"+sisip[7]+"*|*hubungan*-*"+sisip[8]+"";
			 
			 $('#alamat').val(sisip[2]);
			 
			 
            fSetValue(window,p);
        }

        
		function tambah()
		{
			document.getElementById('form1').reset();
			$('#form_input').slideDown(1000,function(){
		//toggle();
		});
			//$('#tampil_data').slideUp(1000);
			$('#act').val('tambah');
		}
		
		function edit()
		{
            var id = document.getElementById("id").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(id=='')
				{
					alert("Pilih data terlebih dahulu untuk di update");
				}
				else
				{
					$('#act').val('edit');
					$('#form_input').slideDown(1000,function()
					{
						toggle();
					});
					
				}
        }
		
		function hapus()
		{
            var id = document.getElementById("id").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(id=='')
				{
					alert("Pilih data terlebih dahulu untuk dihapus");
				}
				else if(confirm("Anda yakin menghapus data ini ?"))
				{
					$('#act').val('hapus');
					$("#form1").ajaxSubmit(
							{
					  success:function(msg)
							{
						alert(msg);
						goFilterAndSort();
						
					  		},
						});
				}
				else
				{
					document.getElementById('id').value="";
				}
        }

        function batal()
		{
			$('#form_input').slideUp(1000,function(){
		toggle();
		});
			//$('#tampil_data').slideDown(1000);
			document.getElementById('id').value="";
			//$('#gridbox').reset();
        }
		
		/*function resetF(){
			$('#act').val('tambah');
            var p="txtId*-**|*j_spher*-**|*j_cyl*-**|*j_axis*-**|*j_prism*-**|*j_base*-**|*j_spher2*-**|*j_cyl2*-**|*j_axis2*-**|*j_prism2*-**|*j_base2*-**|*j_pupil*-**|*d_spher*-**|*d_cyl*-**|*d_axis*-**|*d_prism*-**|*d_base*-**|*d_spher2*-**|*d_cyl2*-**|*d_axis2*-**|*d_prism2*-**|*d_base2*-**|*d_pupil*-*";
            fSetValue(window,p);
	
			}*/


        /*function konfirmasi(key,val)
		{
            //alert(val);
            var tangkap=val.split("*|*");
            
            if(key=='Error')
			{
                if(proses=='hapus')
				{				
                    alert('Tidak bisa menambah data karena '+alasan+'!');
                }              

            }
            else
			{
                if(proses=='tambah')
				{
                    alert('Tambah Berhasil');
                }
                else if(proses=='simpan')
				{
                    alert('Simpan Berhasil');
                }
                else if(proses=='hapus')
				{
                    alert('Hapus Berhasil');
                }
            }

        }*/

        function goFilterAndSort(grd){
            //alert("tmpt_layanan_utils.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
            a.loadURL("22.suratkuasapemberianinformasimed_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&id=<?=$id?>&idPel=<?=$idPel?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Data Ceklist Pasie Pulang");
        a.setColHeader("NO,NAMA PENERIMA KUASA,ALAMAT,NO. KTP,HASIL RESUME MEDIS, HASIL LABORATORIUM,HASIL RADIOLOGI,HASIL LAIN-LAIN,HUBUNGAN PASIEN,PENGGUNA");
        a.setIDColHeader(",,,");
        a.setColWidth("20,150,250,130,100,100,100,100,90,100");
        a.setCellAlign("center,center,center,center,center,center,center,center,center,center");
        a.setCellHeight(20);
		a.setImgPath("../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("22.suratkuasapemberianinformasimed_util.php?id=<?=$id?>&idPel=<?=$idPel?>");
        a.Init();
		
		
		
		
		function cetak()
		{
			var id = document.getElementById("id").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(id=='')
			{
				alert("Pilih data terlebih dahulu untuk di cetak");
			}
			else
			{	
				window.open("22.suratkuasapemberianinformasimed.php?id="+id+"&idPel=<?=$idPel?>&idUser=<?=$idUsr?>","_blank");
				document.getElementById('id').value="";
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
	function toggle() {
    parent.alertsize(document.body.scrollHeight);
}

    </script>
</html>
