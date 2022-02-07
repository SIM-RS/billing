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
<title>Untitled Document</title>
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
<script type="text/javascript" src="../../../include/javascript/jquery-1.9.1.js"></script>

<link rel="stylesheet" type="text/css" href="../../css/jquery-ui-1.8.4.custom.css" />
<link rel="stylesheet" type="text/css" href="../../css/form.css" />
<link rel="stylesheet" type="text/css" href="../../include/jquery/jquery-ui-timepicker-addon.css" />
<script src="../../js/jquery-1.8.3.js"></script>
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
</head>

<body>
<form method="post" >
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
        <td colspan="2"><input type="radio" name="antibiotik" id="antibiotik" value="1" <?=($ILO[0]=='1')?'checked':''?>/>Ada / <input type="radio" name="antibiotik" id="antibiotik" value="1"  <?=($ILO[0]=='1')?'checked':''?>/>Tidak ada</td>
        <td>&nbsp;</td>
        <td colspan="3">Alasan    : <input type="radio" name="alasan" id="alasan" value="1" <?=($ILO[0]=='1')?'checked':''?>/>Profilaksasi / <input type="radio" name="alasan" id="alasan" value="1" <?=($ILO[0]=='1')?'checked':''?>/>Pengobatan</td>
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
        <td colspan="3"> : </td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td colspan="6">Sebab    keluar</td>
        <td colspan="3"> : </td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td colspan="6">Diagnosa    akhir</td>
        <td colspan="3"> : </td>
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
  </tr>
  <tr align="center">
    <td><button>Simpan</button></td>
  </tr>
</table>
</form>
</body>
</html>