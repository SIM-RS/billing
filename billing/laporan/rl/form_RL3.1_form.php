<?php
session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
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
        <script type="text/javascript" src="../js/jquery.timeentry.js"></script>
                <script type="text/javascript">
$(function () 
{
	$('#txtJam').timeEntry({show24Hours: true, showSeconds: true});
	$('#txtJam1').timeEntry({show24Hours: true, showSeconds: true});
	$('#txtJam2').timeEntry({show24Hours: true, showSeconds: true});
});
  var arrRange = depRange = [];
</script>
        <title>KEGIATAN PELAYANAN RAWAT INAP</title>
        <style>
        .gb{
	border-bottom:1px solid #000000;
}
.inputan{
	width:80px;
	}
.textArea{ width:97%;}
body{background:#FFF;}
        .style1 {font-weight: bold}
        </style>
</head>
    <body>
        <div align="center">
            <?php
           // include("../../header1.php");
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
            <table width="1000" border="0" bordercolor="#FF0000" cellspacing="0" cellpadding="2" align="center" >
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="3" align="center"><div id="form_in" style="display:block;">
                <form name="form1" id="form1" action="form_RL3.1_act.php">
                <input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    			<input type="hidden" name="txtId" id="txtId"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
				<!-- mulai sini -->
				
				<table width="1200" border="0" style="border-collapse:collapse; font:12px arial; border:1px solid #000000">
  <tr>
    <td><table width="100%" border="0" style="border-collapse:collapse">
      <tr>
        <td width="9%" rowspan="2" style="border-bottom:2px solid #000000;"><center><img src="logo-bakti-husada.jpg" width="55" height="60" /></center></td>
        <td width="50%" height="31"><span class="style1">Formulir RL 3.1</span></td>
        <td width="32%" rowspan="2" style="border-bottom:2px solid #000000"><center><img src="pojok.png" /></center></td>
      </tr>
      <tr>
        <td height="50%" style="border-bottom:2px solid #000000"><strong>KEGIATAN PELAYANAN RAWAT INAP  </strong></td>
        </tr>
      
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="11%"><strong>Kode RS </strong></td>
        <td width="2%"><strong>:</strong></td>
        <td width="87%"><strong><?=$kodeRS?></strong></td>
      </tr>
      <tr>
        <td><strong>Nama RS </strong></td>
        <td><strong>:</strong></td>
        <td><strong><?=$namaRS?></strong></td>
      </tr>
      
      <tr>
        <td><strong>Tahun</strong></td>
        <td><strong>:</strong></td>
        <td><input type="text" name="txt_tahun" id="txt_tahun" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="1" style="border-collapse:collapse">
      <tr>
        <td rowspan="2" width="3%"><div align="center"><strong>NO</strong></div></td>
        <td rowspan="2" width="20%"><div align="center"><strong>JENIS PELAYANAN </strong></div></td>
        <td rowspan="2" width="5,5%"><strong><center>PASIEN AWAL TAHUN </center></strong></td>
        <td rowspan="2" width="5,5%"><div align="center"><strong>PASIEN MASUK </strong></div></td>
        <td rowspan="2" width="5,5%"><div align="center"><strong>PASIEN KELUAR HIDUP </strong></div></td>
        <td colspan="2" width="11%"><div align="center"><strong>PASIEN KELUAR MATI </strong></div></td>
        <td rowspan="2" width="5,5%"><div align="center"><strong>JUMLAH LAMA DIRAWAT </strong></div></td>
        <td rowspan="2" width="5,5%"><div align="center"><strong>PASIEN AKHIR TAHUN </strong></div></td>
        <td rowspan="2" width="5,5%"><div align="center"><strong>JUMLAH HARI PERAWATAN </strong></div></td>
        <td colspan="6"><div align="center"><strong>RINCIAN HARI PERAWATAN PER KELAS </strong></div></td>
      </tr>
      <tr>
        <td  width="5,5%"><div align="center"><strong>< 48 JAM </strong></div></td>
        <td  width="5,5%"><div align="center"><strong>>= 48 JAM </strong></div></td>
        <td  width="5,5%"><div align="center"><strong>VVIP</strong></div></td>
        <td  width="5,5%"><div align="center"><strong>VIP</strong></div></td>
        <td  width="5,5%"><div align="center"><strong>I</strong></div></td>
        <td  width="5,5%"><div align="center"><strong>II</strong></div></td>
        <td  width="5,5%"><div align="center"><strong>III</strong></div></td>
        <td  width="5,5%"><div align="center"><strong>KELAS KHUSUS </strong></div></td>
        </tr>
      <tr>
        <td><div align="center"><strong>1</strong></div></td>
        <td><strong>Penyakit Dalam</strong></td>
        <td><center><input type="text" name="isi_txt[0]" id="isi_txt[]" value="" size="5px"/></center></td>
        <td><center><input type="text" name="isi_txt[1]" id="isi_txt[]" value="" size="5px"/></center></td>
        <td><center><input type="text" name="isi_txt[2]" id="isi_txt[]" value="" size="5px"/></center></td>
        <td><center><input type="text" name="isi_txt[3]" id="isi_txt[]" value="" size="5px"/></center></td>
        <td><center><input type="text" name="isi_txt[4]" id="isi_txt[]" value="" size="5px"/></center></td>
        <td><center><input type="text" name="isi_txt[5]" id="isi_txt[]" value="" size="5px"/></center></td>
        <td><center><input type="text" name="isi_txt[6]" id="isi_txt[]" value="" size="5px"/></center></td>
        <td><center><input type="text" name="isi_txt[7]" id="isi_txt[]" value="" size="5px"/></center></td>
        <td><center><input type="text" name="isi_txt[8]" id="isi_txt[]" value="" size="5px"/></center></td>
        <td><center><input type="text" name="isi_txt[9]" id="isi_txt[]" value="" size="5px"/></center></td>
        <td><center><input type="text" name="isi_txt[10]" id="isi_txt[]" value="" size="5px"/></center></td>
        <td><center><input type="text" name="isi_txt[11]" id="isi_txt[]" value="" size="5px"/></center></td>
        <td><center><input type="text" name="isi_txt[12]" id="isi_txt[]" value="" size="5px"/></center></td>
        <td><center><input type="text" name="isi_txt[13]" id="isi_txt[]" value="" size="5px"/></center></td>
        </tr>
      <tr>
        <td><div align="center"><strong>2</strong></div></td>
        <td><strong>Kesehatan Anak</strong></td>
        <td><center>
          <input type="text" name="isi_txt[14]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[15]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[16]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[17]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[18]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[19]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[20]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[21]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[22]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[23]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[24]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[25]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[26]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[27]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>3</strong></div></td>
        <td><strong>Obstetri</strong></td>
        <td><center>
          <input type="text" name="isi_txt[28]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[29]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[30]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[31]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[32]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[33]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[34]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[35]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[36]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[37]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[38]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[39]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[40]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[41]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>4</strong></div></td>
        <td><strong>Ginekologi</strong></td>
        <td><center>
          <input type="text" name="isi_txt[42]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[43]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[44]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[45]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[46]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[47]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[48]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[49]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[50]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[51]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[52]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[53]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[54]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[55]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>5</strong></div></td>
        <td><strong>Bedah</strong></td>
        <td><center>
          <input type="text" name="isi_txt[56]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[57]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[58]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[59]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[60]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[61]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[62]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[63]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[64]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[65]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[66]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[67]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[68]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[69]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>6</strong></div></td>
        <td><strong>Bedah Orthopedi</strong></td>
        <td><center>
          <input type="text" name="isi_txt[70]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[71]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[72]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[73]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[74]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[75]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[76]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[77]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[78]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[79]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[80]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[81]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[82]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[83]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7</strong></div></td>
        <td><strong>Bedah Saraf</strong></td>
        <td><center>
          <input type="text" name="isi_txt[84]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[85]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[86]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[87]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[88]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[89]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[90]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[91]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[92]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[93]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[94]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[95]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[96]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[97]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>8</strong></div></td>
        <td><strong>Luka Bakar</strong></td>
        <td><center>
          <input type="text" name="isi_txt[98]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[99]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[100]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[101]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[102]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[103]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[104]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[105]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[106]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[107]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[108]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[109]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[110]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[111]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>9</strong></div></td>
        <td><strong>Saraf</strong></td>
        <td><center>
          <input type="text" name="isi_txt[112]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[113]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[114]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[115]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[116]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[117]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[118]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[119]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[120]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[121]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[122]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[123]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[124]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[125]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>10</strong></div></td>
        <td><strong>Jiwa</strong></td>
        <td><center>
          <input type="text" name="isi_txt[126]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[127]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[128]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[129]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[130]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[131]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[132]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[133]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[134]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[135]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[136]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[137]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[138]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[139]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>11</strong></div></td>
        <td><strong>Psikologi</strong></td>
        <td><center>
          <input type="text" name="isi_txt[140]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[141]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[142]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[143]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[144]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[145]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[146]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[147]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[148]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[149]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[150]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[151]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[152]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[153]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>12</strong></div></td>
        <td><strong>Penatalaksana Pnyguna. NAPZA</strong></td>
        <td><center>
          <input type="text" name="isi_txt[154]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[155]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[156]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[157]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[158]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[159]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[160]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[161]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[162]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[163]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[164]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[165]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[166]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[167]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>13</strong></div></td>
        <td><strong>THT</strong></td>
        <td><center>
          <input type="text" name="isi_txt[168]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[169]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[170]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[171]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[172]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[173]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[174]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[175]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[176]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[177]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[178]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[179]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[180]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[181]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>14</strong></div></td>
        <td><strong>Mata</strong></td>
        <td><center>
          <input type="text" name="isi_txt[182]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[183]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[184]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[185]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[186]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[187]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[188]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[189]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[190]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[191]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[192]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[193]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[194]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[195]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>15</strong></div></td>
        <td><strong>Kulit &amp; Kelamin</strong></td>
        <td><center>
          <input type="text" name="isi_txt[196]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[197]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[198]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[199]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[200]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[201]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[202]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[203]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[204]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[205]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[206]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[207]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[208]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[209]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>16</strong></div></td>
        <td><strong>Kardiologi</strong></td>
        <td><center>
          <input type="text" name="isi_txt[210]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[211]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[212]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[213]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[214]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[215]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[216]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[217]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[218]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[219]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[220]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[221]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[222]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[223]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>17</strong></div></td>
        <td><strong>Paru-paru</strong></td>
        <td><center>
          <input type="text" name="isi_txt[224]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[225]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[226]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[227]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[228]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[229]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[230]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[231]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[232]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[233]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[234]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[235]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[236]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[237]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>18</strong></div></td>
        <td><strong>Geriatri</strong></td>
        <td><center>
          <input type="text" name="isi_txt[238]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[239]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[240]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[241]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[242]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[243]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[244]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[245]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[246]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[247]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[248]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[249]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[250]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[251]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>19</strong></div></td>
        <td><strong>Radioterapi</strong></td>
        <td><center>
          <input type="text" name="isi_txt[252]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[253]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[254]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[255]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[256]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[257]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[258]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[259]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[260]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[261]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[262]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[263]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[264]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[265]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>20</strong></div></td>
        <td><strong>Kedokteran Nuklir</strong></td>
        <td><center>
          <input type="text" name="isi_txt[266]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[267]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[268]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[269]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[270]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[271]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[272]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[273]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[274]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[275]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[276]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[277]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[278]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[279]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>21</strong></div></td>
        <td><strong>K u s t a</strong></td>
        <td><center>
          <input type="text" name="isi_txt[280]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[281]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[282]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[283]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[284]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[285]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[286]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[287]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[288]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[289]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[290]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[291]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[292]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[293]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>22</strong></div></td>
        <td><strong>Rehabilitasi Medik</strong></td>
        <td><center>
          <input type="text" name="isi_txt[294]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[295]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[296]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[297]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[298]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[299]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[300]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[301]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[302]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[303]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[304]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[305]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[306]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[307]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>23</strong></div></td>
        <td><strong>Isolasi</strong></td>
        <td><center>
          <input type="text" name="isi_txt[308]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[309]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[310]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[311]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[312]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[313]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[314]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[315]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[316]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[317]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[318]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[319]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[320]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[321]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>24</strong></div></td>
        <td><strong>I C U</strong></td>
        <td><center>
          <input type="text" name="isi_txt[322]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[323]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[324]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[325]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[326]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[327]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[328]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[329]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[330]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[331]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[332]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[333]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[334]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[335]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>25</strong></div></td>
        <td><strong>I C C U</strong></td>
        <td><center>
          <input type="text" name="isi_txt[336]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[337]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[338]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[339]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[340]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[341]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[342]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[343]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[344]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[345]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[346]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[347]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[348]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[349]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>26</strong></div></td>
        <td><strong>NICU / PICU</strong></td>
        <td><center>
          <input type="text" name="isi_txt[350]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[351]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[352]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[353]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[354]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[355]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[356]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[357]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[358]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[359]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[360]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[361]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[362]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[363]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>27</strong></div></td>
        <td><strong>Umum</strong></td>
        <td><center>
          <input type="text" name="isi_txt[364]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[365]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[366]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[367]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[368]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[369]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[370]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[371]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[372]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[373]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[374]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[375]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[376]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[377]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>28</strong></div></td>
        <td><strong>Gigi &amp; Mulut</strong></td>
        <td><center>
          <input type="text" name="isi_txt[378]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[379]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[380]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[381]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[382]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[383]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[384]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[385]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[386]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[387]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[388]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[389]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[390]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[391]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>29</strong></div></td>
        <td><strong>Pelayanan Rawat Darurat</strong></td>
        <td><center>
          <input type="text" name="isi_txt[392]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[393]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[394]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[395]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[396]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[397]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[398]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[399]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[400]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[401]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[402]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[403]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[404]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[405]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>77</strong></div></td>
        <td><strong>SUB TOTAL</strong></td>
        <td><center>
          <input type="text" name="isi_txt[406]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[407]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[408]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[409]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[410]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[411]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[412]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[413]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[414]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[415]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[416]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[417]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[418]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[419]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>88</strong></div></td>
        <td><strong>Perinatologi</strong></td>
        <td><center>
          <input type="text" name="isi_txt[420]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[421]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[422]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[423]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[424]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[425]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[426]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[427]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[428]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[429]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[430]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[431]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[432]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[433]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>99</strong></div></td>
        <td><strong>T O T A L</strong></td>
        <td><center>
          <input type="text" name="isi_txt[434]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[435]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[436]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[437]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[438]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[439]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[440]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[441]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[442]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[443]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[444]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[445]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[446]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[447]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
    </table></td>
  </tr>
   
</table>
				<!-- sampe sini -->
				
                </form>   
             <div align="center"><input type="button" name="bt_save" id="bt_save" class="tblTambah" value="Simpan" onclick="return simpan()" />&nbsp;
  <input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/></div>
                </div></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="45%">
                        <input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="tambah(this.value);" class="tblTambah"/>
                      <input type="button" id="btnHapus" name="btnHapus" value="Edit" onclick="edit();" class="tblTambah"/>
                        <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus();" class="tblHapus"/>
                  </td>
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
                        <div id="gridbox" style="width:700px; height:300px; background-color:white; overflow:hidden;"></div>
                        <div id="paging" style="width:700px;"></div></td>
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
            if(ValidateForm('txt_tahun','ind')){
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
			//$('#txt_anjuran').val(a.cellsGetValue(a.getSelRow(),3));
			$('#txtId').val(sisip[0]);
			$('#txt_tahun').val(sisip[1]);
			$('#act').val('edit');
			centang(sisip[2]);
			//alert(tes);
/*			 var p="tgl_kaji*-*"+sisip[2]
			 +"*|*jam_kaji*-*"+sisip[3]
			 +"*|*txt_diantar*-*"+sisip[4]
			 +"*|*txt_protase*-*"+sisip[5]
			 +"*|*txt_penyakit*-*"+sisip[6]
			 +"*|*txt_rawatKpn*-*"+sisip[7]
			 +"*|*txt_dirawatDmn*-*"+sisip[8]
			 +"*|*txt_sakitApa*-*"+sisip[9]
			 +"*|*txt_pengobatan*-*"+sisip[10]
			 +"*|*txt_alergiJns*-*"+sisip[11]
			 +"*|*txt_tingBdn*-*"+sisip[12]
			 +"*|*txt_brtBdn*-*"+sisip[13]+
			 "*|*txt_TD*-*"+sisip[14]			 
			 +"*|*txt_HR*-*"+sisip[15]
			 +"*|*txt_RR*-*"+sisip[16]
			 +"*|*txt_Suhu*-*"+sisip[17]
			 +"*|*txt_minumX*-*"+sisip[18]
			 +"*|*txt_minumCC*-*"+sisip[19]
			 +"*|*txt_BAK*-*"+sisip[20]
			 +"*|*txt_BAKwarna*-*"+sisip[21]
			 +"*|*txt_muntahX*-*"+sisip[22]
			 +"*|*txt_muntahWarna*-*"+sisip[23]
			 +"*|*txt_muntahIsi*-*"+sisip[24]
			 +"*|*txt_hematX*-*"+sisip[25]
			 +"*|*txt_hematJml*-*"+sisip[26]
			 +"*|*txt_tugor*-*"+sisip[27]
			 +"*|*txt_edema*-*"+sisip[28]
			 +"*|*txt_BAB*-*"+sisip[29]
			 +"*|*txt_BABcc*-*"+sisip[30]
			 +"*|*txt_melena*-*"+sisip[31]
			 +"*|*txt_melenaJml*-*"+sisip[32]
			 +"*|*txt_fraktur*-*"+sisip[33]
			 +"*|*txt_score*-*"+sisip[34]
			 +"*|*txt_invasif*-*"+sisip[35]
			 +"*|*txt_infus*-*"+sisip[36]
			 +"*|*txt_plebitis*-*"+sisip[37]
			 +"*|*txt_kulitLok*-*"+sisip[38]
			 +"*|*txt_kulitGrade*-*"+sisip[39]
			 +"*|*txt_kulitUkr*-*"+sisip[40]
			 +"*|*txt_tugorLok*-*"+sisip[41]
			 +"*|*txt_edemaLok*-*"+sisip[42]
			 +"*|*txt_nmObat*-*"+sisip[43]
			 +"*|*txt_intensitas*-*"+sisip[44]
			 +"*|*tgl_cerebal*-*"+sisip[45]
			 +"*|*tgl_gas*-*"+sisip[46]
			 +"*|*tgl_BJNTE*-*"+sisip[47]
			 +"*|*tgl_termogulasi*-*"+sisip[48]
			 +"*|*tgl_kebNutrisi*-*"+sisip[49]
			 +"*|*tgl_volCairan*-*"+sisip[50]
			 +"*|*tgl_GPEU*-*"+sisip[51]
			 +"*|*tgl_GPEA*-*"+sisip[52]
			 +"*|*tgl_mobFisik*-*"+sisip[53]
			 +"*|*tgl_integritas*-*"+sisip[54]
			 +"*|*tgl_rawatDiri*-*"+sisip[55]
			 +"*|*tgl_psikiatrik*-*"+sisip[56]
			 +"*|*tgl_nyeri*-*"+sisip[57]
			 +"";			8*/
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
            a.loadURL("form_RL3.1.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("DATA RL 3.1");
        a.setColHeader("NO,NO RM,NO FORMULIR,TGL INPUT,PENGGUNA");
        a.setIDColHeader(",no_rm,,,");
        a.setColWidth("100,150,100,150,200");
        a.setCellAlign("center,center,center,center,center");
        a.setCellHeight(20);
        a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("form_RL3.1_util.php");
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
		window.open("form_RL3.1.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUsr?>","_blank");
				//}
		}
		
function centang(tes)
{
		//var list=tes.split('*=*');
//		var list1 = document.form1.elements['radio[]'];
		var list2 = document.form1.elements['isi_txt[]'];
				 
/*		if ( list1.length > 0 )
		{
		 for (i = 0; i < 41; i++)
			{
			var val=list[0].split(',');	
			var listx = document.form1.elements['radio['+i+']'];
					//alert('radio['+i+']');
			for (j = 0; j < listx.length; j++)
				{
				if (listx[j].value==val[i])
			  		{
			   			listx[j].checked = true;
			  		}
				else
					{
						listx[j].checked = false;
					}	
				}
		  }
		}*/
		
		if ( list2.length > 0 )
		{
		 for (i = 0; i < list2.length; i++)
			{
			var val=tes.split(',');
			//alert(list2[i].value);
			//alert(val[i]);
			  if (list2[i].value==val[i])
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
