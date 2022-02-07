<?php
session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUsr'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,
k.cara_keluar
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_pasien_keluar k ON k.pelayanan_id=pl.id
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
$sqlKm="SELECT tk.tgl_in,tk.tgl_out FROM b_tindakan_kamar tk 
LEFT JOIN b_pelayanan p ON p.id=tk.pelayanan_id
WHERE tk.pelayanan_id='$idPel';";
$dK=mysql_fetch_array(mysql_query($sqlKm));
$usr=mysql_fetch_array(mysql_query("select * from b_ms_pegawai where id='$idUsr'"));

include "setting.php";

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
        <link rel="stylesheet" type="text/css" href="../../css/jquery-ui-1.8.4.custom.css" />
<link rel="stylesheet" type="text/css" href="../../css/form.css" />
<link rel="stylesheet" type="text/css" href="../../include/jquery/jquery-ui-timepicker-addon.css" />
<!--<script src="../../js/jquery-1.8.3.js"></script>-->
<script src="../../include/jquery/ui/jquery.ui.core.js"></script>
<script src="../../include/jquery/ui/jquery.ui.widget.js"></script>
<script src="../../include/jquery/ui/jquery.ui.datepicker.js"></script>
<script src="../../include/jquery/jquery-ui-timepicker-addon.js"></script>
<script src="../../include/jquery/external/jquery.bgiframe-2.1.2.js"></script>

<script>
$(function() {
	$( "#tgl_mulai1,#tgl_mulai1b,#tgl_mulai2,#tgl_mulai2b,#tgl_mulai3,#tgl_mulai3b,#tgl_ruang1,#tgl_ruang1b,#tgl_ruang2,#tgl_ruang2b,#tgl_ruang3,#tgl_ruang3b" ).datepicker({
		changeMonth: true,
		changeYear: true,
		showOn: "button",
		buttonImage: "../../images/cal.gif",
		buttonImageOnly: true
	});
});
</script>
        <title>CHECK LIST PENGKAJIAN KEPERAWATAN</title>
        <style>
        .gb{
	border-bottom:1px solid #000000;
}
.input150{
	width:90px;
	}
.input80{
	width:40px;
	}
.textArea{ width:97%;}
body{background:#FFF;}
        </style>
          <script type="text/JavaScript">
            var arrRange = depRange = [];
        </script>
</head>
    <body>
        <div align="center">
            <?php
           // include("../../../header1.php");
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
          <!--  <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
                <tr>
                    <td height="30">&nbsp;FORM RESUM MEDIS</td>
                </tr>
            </table>-->
            <table width="1000" border="0" cellspacing="0" cellpadding="2" align="center" >
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="3" align="center"><div id="form_in" style="display:none;">
                <form name="form1" id="form1" action="surveilan_infeksi_noso_act.php">
                <input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    			<input type="hidden" name="txtId" id="txtId"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
                
                <table border="0" style="font:12px tahoma;">
  <tr>
    <td width="614"><table width="750" cellspacing="0" cellpadding="0">
      <tr>
        <td width="22"></td>
        <td width="59"></td>
        <td width="33"></td>
        <td width="33"></td>
        <td width="7"></td>
        <td width="15"></td>
        <td width="71"></td>
        <td width="96" align="left" valign="top">
          <table cellpadding="0" cellspacing="0">
            <tr>
              <td width="110"></td>
              </tr>
          </table></td>
        <td width="42"></td>
        <td width="15"></td>
        <td width="90"></td>
        <td width="127"></td>
        </tr>
      <tr>
        <td colspan="7">PEMERINTAH    KOTA MEDAN</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        </tr>
      <tr>
        <td colspan="7">RUMAH    SAKIT PELINDO I</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        </tr>
      <tr>
        <td colspan="7">SURVEILAN    INFEKSI NOSOKOMIAL</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        </tr>
      <tr>
        <td>1.</td>
        <td colspan="3">Pemakaian antibiotik</td>
        <td>:</td>
        <td>&nbsp;</td>
        <td colspan="2"><input type="radio" name="antibiotik" id="antibiotik" value="1" />Ada / <input type="radio" name="antibiotik" id="antibiotik" value="2" />Tidak ada</td>
        <td>&nbsp;</td>
        <td colspan="3">Alasan    : <input type="radio" name="alasan" id="alasan" value="1" />Profilaksasi / <input type="radio" name="alasan" id="alasan" value="2" />Pengobatan</td>
        </tr>
      <tr>
        <td>2.</td>
        <td colspan="2">Nama / Jenis</td>
        <td></td>
        <td>:</td>
        <td>1.</td>
        <td colspan="2"><input type="text" id="jenis1" name="jenis1" style="width:90px;" value="<?php echo $rows['']; ?>"/></td>
        <td colspan="2">Mulai tgl</td>
        <td><input type="text" id="tgl_mulai1" name="tgl_mulai1" style="width:65px;" value="<?php echo $rows['']; ?>" readonly="readonly"/></td>
        <td>s/d <input type="text" id="tgl_mulai1b" name="tgl_mulai1b" style="width:65px;" value="<?php echo $rows['']; ?>" readonly="readonly"/></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>2.</td>
        <td colspan="2"><input type="text" id="jenis2" name="jenis2" style="width:90px;" value="<?php echo $rows['']; ?>"/></td>
        <td colspan="2">Mulai tgl</td>
        <td><input type="text" id="tgl_mulai2" name="tgl_mulai2" style="width:65px;" value="<?php echo $rows['']; ?>" readonly="readonly"/></td>
        <td>s/d <input type="text" id="tgl_mulai2b" name="tgl_mulai2b" style="width:65px;" value="<?php echo $rows['']; ?>" readonly="readonly"/></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>3.</td>
        <td colspan="2"><input type="text" id="jenis3" name="jenis3" style="width:90px;" value="<?php echo $rows['']; ?>"/></td>
        <td colspan="2">Mulai tgl</td>
        <td><input type="text" id="tgl_mulai3" name="tgl_mulai3" style="width:65px;" value="<?php echo $rows['']; ?>" readonly="readonly"/></td>
        <td>s/d <input type="text" id="tgl_mulai3b" name="tgl_mulai3b" style="width:65px;" value="<?php echo $rows['']; ?>" readonly="readonly"/></td>
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
        </tr>
      <tr>
        <td colspan="3">Tempat    dirawat :</td>
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
        <td>1.</td>
        <td colspan="5">Ruang : <input type="text" id="ruang1" name="ruang1" style="width:90px;" value="<?php echo $rows['']; ?>"/></td>
        <td colspan="5">tgl <input type="text" id="tgl_ruang1" name="tgl_ruang1" style="width:65px;" value="<?php echo $rows['']; ?>" readonly="readonly"/> s/d tgl <input type="text" id="tgl_ruang1b" name="tgl_ruang1b" style="width:65px;" value="<?php echo $rows['']; ?>" readonly="readonly"/></td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>2.</td>
        <td colspan="5">Ruang : <input type="text" id="ruang2" name="ruang2" style="width:90px;" value="<?php echo $rows['']; ?>"/></td>
        <td colspan="5">tgl <input type="text" id="tgl_ruang2" name="tgl_ruang2" style="width:65px;" value="<?php echo $rows['']; ?>" readonly="readonly"/> s/d tgl  <input type="text" id="tgl_ruang2b" name="tgl_ruang2b" style="width:65px;" value="<?php echo $rows['']; ?>" readonly="readonly"/></td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>3.</td>
        <td colspan="5">Ruang : <input type="text" id="ruang3" name="ruang3" style="width:90px;" value="<?php echo $rows['']; ?>"/></td>
        <td colspan="5">tgl <input type="text" id="tgl_ruang3" name="tgl_ruang3" style="width:65px;" value="<?php echo $rows['']; ?>" readonly="readonly"/> s/d tgl  <input type="text" id="tgl_ruang3b" name="tgl_ruang3b" style="width:65px;" value="<?php echo $rows['']; ?>" readonly="readonly"/></td>
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
        </tr>
      <tr>
        <td colspan="6">Tanggal    keluar / meninggal</td>
        <td colspan="3"> : <?=$tgl_keluar?></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td colspan="6">Sebab    keluar</td>
        <td colspan="3"> : <?=$cara_keluar?></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td colspan="6">Diagnosa    akhir</td>
        <td colspan="3"> : <?=$diag?></td>
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
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="750" height="167" border="1" cellpadding="0" cellspacing="0">
     <tr>
        <td colspan="2" style="text-align: center">Tindakan</td>
        <td width="50" style="text-align: center">P</td>
        <td width="50" style="text-align: center">L</td>
        <td colspan="3" style="text-align: center">Alasan</td>
        <td width="100" style="text-align: center">Nama Jelas</td>
        <td width="50" style="text-align: center">P</td>
        <td width="50" style="text-align: center">L</td>
        <td width="103" style="text-align: center">Alasan</td>
        <td width="103" style="text-align: center">Nama Jelas</td>
        </tr>
      <tr>
        <td colspan="2">IV    Catheter</td>
        <td><input type="text" id="catheter1" name="catheter1" style="width:30px;" value="<?php echo $rows['']; ?>"/></td>
        <td><input type="text" id="catheter2" name="catheter2" style="width:30px;" value="<?php echo $rows['']; ?>"/></td>
        <td colspan="3"><input type="text" id="catheter3" name="catheter3" style="width:85px;" value="<?php echo $rows['']; ?>"/></td>
        <td><input type="text" id="catheter4" name="catheter4" style="width:85px;" value="<?php echo $rows['']; ?>"/></td>
        <td><input type="text" id="catheter5" name="catheter5" style="width:30px;" value="<?php echo $rows['']; ?>"/></td>
        <td><input type="text" id="catheter6" name="catheter6" style="width:30px;" value="<?php echo $rows['']; ?>"/></td>
        <td><input type="text" id="catheter7" name="catheter7" style="width:85px;" value="<?php echo $rows['']; ?>"/></td>
        <td><input type="text" id="catheter8" name="catheter8" style="width:85px;" value="<?php echo $rows['']; ?>"/></td>
      </tr>
      <tr>
        <td colspan="2">Urine Catheter</td>
        <td><input type="text" id="urine_catheter1" name="urine_catheter1" style="width:30px;" value="<?php echo $rows['']; ?>"/></td>
        <td><input type="text" id="urine_catheter2" name="urine_catheter2" style="width:30px;" value="<?php echo $rows['']; ?>"/></td>
        <td colspan="3"><input type="text" id="urine_catheter3" name="urine_catheter3" style="width:85px;" value="<?php echo $rows['']; ?>"/></td>
        <td><input type="text" id="urine_catheter4" name="urine_catheter4" style="width:85px;" value="<?php echo $rows['']; ?>"/></td>
        <td><input type="text" id="urine_catheter5" name="urine_catheter5" style="width:30px;" value="<?php echo $rows['']; ?>"/></td>
        <td><input type="text" id="urine_catheter6" name="urine_catheter6" style="width:30px;" value="<?php echo $rows['']; ?>"/></td>
        <td><input type="text" id="urine_catheter7" name="urine_catheter7" style="width:85px;" value="<?php echo $rows['']; ?>"/></td>
        <td><input type="text" id="urine_catheter8" name="urine_catheter8" style="width:85px;" value="<?php echo $rows['']; ?>"/></td>
      </tr>
      <tr>
        <td width="73">NGT</td>
        <td width="42">&nbsp;</td>
        <td><input type="text" id="ngt1" name="ngt1" style="width:30px;" value="<?php echo $rows['']; ?>"/></td>
        <td><input type="text" id="ngt2" name="ngt2" style="width:30px;" value="<?php echo $rows['']; ?>"/></td>
        <td colspan="3"><input type="text" id="ngt3" name="ngt3" style="width:85px;" value="<?php echo $rows['']; ?>"/></td>
        <td><input type="text" id="ngt4" name="ngt4" style="width:85px;" value="<?php echo $rows['']; ?>"/></td>
        <td><input type="text" id="ngt5" name="ngt5" style="width:30px;" value="<?php echo $rows['']; ?>"/></td>
        <td><input type="text" id="ngt6" name="ngt6" style="width:30px;" value="<?php echo $rows['']; ?>"/></td>
        <td><input type="text" id="ngt7" name="ngt7" style="width:85px;" value="<?php echo $rows['']; ?>"/></td>
        <td><input type="text" id="ngt8" name="ngt8" style="width:85px;" value="<?php echo $rows['']; ?>"/></td>
        </tr>
      <tr>
        <td colspan="2">CVC</td>
        <td><input type="text" id="cvc1" name="cvc1" style="width:30px;" value="<?php echo $rows['']; ?>"/></td>
        <td><input type="text" id="cvc2" name="cvc2" style="width:30px;" value="<?php echo $rows['']; ?>"/></td>
        <td colspan="3"><input type="text" id="cvc3" name="cvc3" style="width:85px;" value="<?php echo $rows['']; ?>"/></td>
        <td><input type="text" id="cvc4" name="cvc4" style="width:85px;" value="<?php echo $rows['']; ?>"/></td>
        <td><input type="text" id="cvc5" name="cvc5" style="width:30px;" value="<?php echo $rows['']; ?>"/></td>
        <td><input type="text" id="cvc6" name="cvc6" style="width:30px;" value="<?php echo $rows['']; ?>"/></td>
        <td><input type="text" id="cvc7" name="cvc7" style="width:85px;" value="<?php echo $rows['']; ?>"/></td>
        <td><input type="text" id="cvc8" name="cvc8"style="width:85px;" value="<?php echo $rows['']; ?>"/></td>
        </tr>
      <tr>
        <td colspan="2">Ventilator / ETT</td>
        <td><input type="text" id="ett1" name="ett1" style="width:30px;" value="<?php echo $rows['']; ?>"/></td>
        <td><input type="text" id="ett2" name="ett2" style="width:30px;" value="<?php echo $rows['']; ?>"/></td>
        <td colspan="3"><input type="text" id="ett3" name="ett3" style="width:85px;" value="<?php echo $rows['']; ?>"/></td>
        <td><input type="text" id="ett4" name="ett4" style="width:85px;" value="<?php echo $rows['']; ?>"/></td>
        <td><input type="text" id="ett5" name="ett5" style="width:30px;" value="<?php echo $rows['']; ?>"/></td>
        <td><input type="text" id="ett6" name="ett6" style="width:30px;" value="<?php echo $rows['']; ?>"/></td>
        <td><input type="text" id="ett7" name="ett7" style="width:85px;" value="<?php echo $rows['']; ?>"/></td>
        <td><input type="text" id="ett8" name="ett8" style="width:85px;" value="<?php echo $rows['']; ?>"/></td>
        </tr>
      <tr>
        <td colspan="2">Lain - lain</td>
        <td><input type="text" id="lain1" name="lain1" style="width:30px;" value="<?php echo $rows['']; ?>"/></td>
        <td><input type="text" id="lain2" name="lain2" style="width:30px;" value="<?php echo $rows['']; ?>"/></td>
        <td colspan="3"><input type="text" id="lain3" name="lain3" style="width:85px;" value="<?php echo $rows['']; ?>"/></td>
        <td><input type="text" id="lain4" name="lain4" style="width:85px;" value="<?php echo $rows['']; ?>"/></td>
        <td><input type="text" id="lain5" name="lain5" style="width:30px;" value="<?php echo $rows['']; ?>"/></td>
        <td><input type="text" id="lain6" name="lain6" style="width:30px;" value="<?php echo $rows['']; ?>"/></td>
        <td><input type="text" id="lain7" name="lain7" style="width:85px;" value="<?php echo $rows['']; ?>"/></td>
        <td><input type="text" id="lain8" name="lain8" style="width:85px;" value="<?php echo $rows['']; ?>"/></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table cellspacing="0" cellpadding="0">
      <tr>
        <td width="28"></td>
        <td width="75"></td>
        <td width="50"></td>
        <td width="50"></td>
        <td width="12"></td>
        <td width="25"></td>
        <td width="78"></td>
        <td width="110"></td>
        <td width="50"></td>
        <td width="50"></td>
        <td width="113"></td>
        <td width="116"></td>
        </tr>
      <tr>
        <td colspan="7">Catatan    : IV catheter, lama pemasangan 3 hari</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td colspan="11">          Urine catheter, lama pemasangan 7    hari (sylicon 1 bulan)</td>
        </tr>
      <tr>
        <td></td>
        <td colspan="6">          NGT, lama pemasangan 14 hari</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td colspan="2">          P, pasang</td>
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
        <td colspan="2">          L, lepas</td>
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
        <td colspan="2">Kriteria    Plebitis</td>
        <td colspan="5">0 : Tidak ada tanda    plebitis</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td></td>
        <td colspan="5">1 : Merah atau sakit bila    ditekan</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td></td>
        <td colspan="6">2 : Merah, sakit bila    ditekan, oedema</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td></td>
        <td colspan="10">3 : Merah, sakit bila    ditekan, oedema dan vena mengeras</td>
        </tr>
      <tr>
        <td></td>
        <td></td>
        <td colspan="9">4 : Merah, sakit bila    ditekan, oedema, vena mengeras dan timbul pus</td>
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
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
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
                    <td align="center" colspan="3">
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
  <!--    <table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
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
            if(ValidateForm('catheter1','ind')){
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
			
			$('#txtId').val(sisip[0]);
			$('#act').val('edit');
			centang(sisip[1],sisip[2]);
			 var p="jenis1*-*"+sisip[3]
			 +"*|*tgl_mulai1*-*"+sisip[4]
			 +"*|*tgl_mulai1b*-*"+sisip[5]
			 +"*|*jenis2*-*"+sisip[6]
			 +"*|*tgl_mulai2*-*"+sisip[7]
			 +"*|*tgl_mulai2b*-*"+sisip[8]
			 +"*|*jenis3*-*"+sisip[9]
			 +"*|*tgl_mulai3*-*"+sisip[10]
			 +"*|*tgl_mulai3b*-*"+sisip[11]
			 +"*|*ruang1*-*"+sisip[12]
			 +"*|*tgl_ruang1*-*"+sisip[13]
			 +"*|*tgl_ruang1b*-*"+sisip[14]			 
			 +"*|*ruang2*-*"+sisip[15]
			 +"*|*tgl_ruang2*-*"+sisip[16]
			 +"*|*tgl_ruang2b*-*"+sisip[17]
			 +"*|*ruang3*-*"+sisip[18]
			 +"*|*tgl_ruang3*-*"+sisip[19]
			 +"*|*tgl_ruang3b*-*"+sisip[20]
			 +"*|*catheter1*-*"+sisip[21]
			 +"*|*catheter2*-*"+sisip[22]
			 +"*|*catheter3*-*"+sisip[23]
			 +"*|*catheter4*-*"+sisip[24]
			 +"*|*catheter5*-*"+sisip[25]
			 +"*|*catheter6*-*"+sisip[26]
			 +"*|*catheter7*-*"+sisip[27]
			 +"*|*catheter8*-*"+sisip[28]
			 +"*|*urine_catheter1*-*"+sisip[29]
			 +"*|*urine_catheter2*-*"+sisip[30]
			 +"*|*urine_catheter3*-*"+sisip[31]
			 +"*|*urine_catheter4*-*"+sisip[32]
			 +"*|*urine_catheter5*-*"+sisip[33]
			 +"*|*urine_catheter6*-*"+sisip[34]
			 +"*|*urine_catheter7*-*"+sisip[35]
			 +"*|*urine_catheter8*-*"+sisip[36]
			 +"*|*ngt1*-*"+sisip[37]
			 +"*|*ngt2*-*"+sisip[38]
			 +"*|*ngt3*-*"+sisip[39]
			 +"*|*ngt4*-*"+sisip[40]
			 +"*|*ngt5*-*"+sisip[41]
			 +"*|*ngt6*-*"+sisip[42]
			 +"*|*ngt7*-*"+sisip[43]
			 +"*|*ngt8*-*"+sisip[44]
			 +"*|*cvc1*-*"+sisip[45]
			 +"*|*cvc2*-*"+sisip[46]
			 +"*|*cvc3*-*"+sisip[47]
			 +"*|*cvc4*-*"+sisip[48]
			 +"*|*cvc5*-*"+sisip[49]
			 +"*|*cvc6*-*"+sisip[50]
			 +"*|*cvc7*-*"+sisip[51]
			 +"*|*cvc8*-*"+sisip[52]
			 +"*|*ett1*-*"+sisip[53]
			 +"*|*ett2*-*"+sisip[54]
			 +"*|*ett3*-*"+sisip[55]
			 +"*|*ett4*-*"+sisip[56]
			 +"*|*ett5*-*"+sisip[57]
			 +"*|*ett6*-*"+sisip[58]
			 +"*|*ett7*-*"+sisip[59]
			 +"*|*ett8*-*"+sisip[60]
			 +"*|*lain1*-*"+sisip[61]
			 +"*|*lain2*-*"+sisip[62]
			 +"*|*lain3*-*"+sisip[63]
			 +"*|*lain4*-*"+sisip[64]
			 +"*|*lain5*-*"+sisip[65]
			 +"*|*lain6*-*"+sisip[66]
			 +"*|*lain7*-*"+sisip[67]
			 +"*|*lain8*-*"+sisip[68]
			 +"";
			 
			 
            fSetValue(window,p);
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
			$('#txtId').val('');
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
            a.loadURL("surveilan_infeksi_noso_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Data Surveilan Infeksi Noso");
        a.setColHeader("NO,TGL Keluar,Sebab Keluar,Diagnosa Akhir,TGL INPUT,PENGGUNA");
        a.setIDColHeader(",,cara_keluar,,,");
        a.setColWidth("50,100,150,200,100,100");
        a.setCellAlign("center,center,left,left,center,center");
        a.setCellHeight(20);
        a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("surveilan_infeksi_noso_util.php?idPel=<?=$idPel?>");
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
		window.open("surveilan_infeksi_noso_print.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUsr?>","_blank");
				//}
		}
		
function centang(tes,tes2){
		var list1 = document.form1.elements['antibiotik'];
		var list2 = document.form1.elements['alasan'];
				 
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			if (list1[i].value==tes)
			  {
			   	list1[i].checked = true;
			  }else{
				list1[i].checked = false;
			  }
		  	}
		}
		
		if ( list2.length > 0 )
		{
		 for (i = 0; i < list2.length; i++)
			{
			if (list2[i].value==tes2)
			  {
			   	list2[i].checked = true;
			  }else{
				list2[i].checked = false;
			  }
		  	}
		}
	}
    </script>
    
</html>
