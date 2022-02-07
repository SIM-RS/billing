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
                <form name="form1" id="form1" action="form_RL2_act.php">
                <input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    			<input type="hidden" name="txtId" id="txtId"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
				<!-- mulai sini -->

<table width="900" border="0" style="border-collapse:collapse; font:12px arial; border:1px solid #000000">
  <tr>
    <td><table width="100%" border="0" style="border-collapse:collapse">
      <tr>
        <td width="9%" rowspan="2" style="border-bottom:2px solid #000000;"><center><img src="logo-bakti-husada.jpg" width="55" height="60" /></center></td>
        <td width="50%" height="31"><span class="style1">Formulir RL 2 </span></td>
        <td width="32%" rowspan="2" style="border-bottom:2px solid #000000"><center><img src="pojok.png" /></center></td>
      </tr>
      <tr>
        <td height="50%" style="border-bottom:2px solid #000000"><strong>KETENAGAAN</strong></td>
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
        <td rowspan="2" width="10%"><div align="center"><strong>NO</strong></div></td>
        <td rowspan="2" width="30%"><div align="center"><strong>JENIS PELAYANAN </strong></div></td>
        <td colspan="2" width="20%"><strong><center>KEADAAN</center></strong></td>
        <td colspan="2" width="20%"><strong><center>KEBUTUHAN</center></strong></td>
        <td colspan="2" width="20%"><strong><center>KEKURANGAN</center></strong></td>
        </tr>
      <tr>
        <td width="20%"><center><strong>LAKI - LAKI</strong></center></td>
        <td width="10%"><center><strong>PEREMPUAN</strong></center></td>
        <td width="20%"><center><strong>LAKI - LAKI</strong></center></td>
        <td width="10%"><center><strong>PEREMPUAN</strong></center></td>
        <td width="20%"><center><strong>LAKI - LAKI</strong></center></td>
        <td width="10%"><center><strong>PEREMPUAN</strong></center></td>
      </tr>
      <tr>
        <td height="25"><div align="center"><strong>1</strong></div></td>
        <td colspan="7" ><strong>TENAGA MEDIS </strong></td>
        </tr>
      <tr>
        <td><div align="center"><strong>1 1</strong></div></td>
        <td><strong>Dokter Umum</strong></td>
        <td><center>
          <input type="text" name="isi_txt[0]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[1]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[2]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[3]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[4]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[5]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        </tr>
      <tr>
        <td><div align="center"><strong>1 2</strong></div></td>
        <td><strong>Dokter PPDS *)</strong></td>
        <td><center>
          <input type="text" name="isi_txt[6]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[7]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[8]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[9]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[10]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[11]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        </tr>
      <tr>
        <td><div align="center"><strong>1 3</strong></div></td>
        <td><strong>Dokter Spes Bedah</strong></td>
        <td><center>
          <input type="text" name="isi_txt[12]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[13]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
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
        </tr>
      <tr>
        <td><div align="center"><strong>1 4</strong></div></td>
        <td><strong>Dokter Spes Penyakit Dalam</strong></td>
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
        </tr>
      <tr>
        <td><div align="center"><strong>1 5</strong></div></td>
        <td><strong>Dokter Spes Kes. Anak</strong></td>
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
        <td><center>
          <input type="text" name="isi_txt[28]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[29]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        </tr>
      <tr>
        <td><div align="center"><strong>1 6</strong></div></td>
        <td><strong>Dokter Spes Obgin</strong></td>
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
        </tr>
      <tr>
        <td><div align="center"><strong>1 7</strong></div></td>
        <td><strong>Dokter Spes Radiologi</strong></td>
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
        <td><div align="center"><strong>1 8</strong></div></td>
        <td><strong>Dokter Spes Onkologi Radiasi</strong></td>
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
        </tr>
      <tr>
        <td><div align="center"><strong>1 9</strong></div></td>
        <td><strong>Dokter Spes Kedokteran Nuklir</strong></td>
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
        </tr>
      <tr>
        <td><div align="center"><strong>1 10</strong></div></td>
        <td><strong>Dokter Spes Anesthesi</strong></td>
        <td><center>
          <input type="text" name="isi_txt[54]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[55]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
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
        </tr>
      <tr>
        <td><div align="center"><strong>1 11</strong></div></td>
        <td><strong>Dokter Spes Patologi Klinik</strong></td>
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
        </tr>
      <tr>
        <td><div align="center"><strong>1 12</strong></div></td>
        <td><strong>Dokter Spes Jiwa</strong></td>
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
        <td><center>
          <input type="text" name="isi_txt[70]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[71]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        </tr>
      <tr>
        <td><div align="center"><strong>1 13</strong></div></td>
        <td><strong>Dokter Spes Mata</strong></td>
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
        </tr>
      <tr>
        <td><div align="center"><strong>1 14</strong></div></td>
        <td><strong>Dokter Spes THT</strong></td>
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
        <td><div align="center"><strong>1 15</strong></div></td>
        <td><strong>Dokter Spes Kulit &amp; Kelamin</strong></td>
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
        </tr>
      <tr>
        <td><div align="center"><strong>1 16</strong></div></td>
        <td><strong>Dokter Spes Kardiologi</strong></td>
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
        </tr>
      <tr>
        <td><div align="center"><strong>1 17</strong></div></td>
        <td><strong>Dokter Spes Paru</strong></td>
        <td><center>
          <input type="text" name="isi_txt[96]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[97]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
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
        </tr>
      <tr>
        <td><div align="center"><strong>1 18</strong></div></td>
        <td><strong>Dokter Spes Saraf</strong></td>
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
        </tr>
      <tr>
        <td><div align="center"><strong>1 19</strong></div></td>
        <td><strong>Dokter Spes Bedah Saraf</strong></td>
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
        <td><center>
          <input type="text" name="isi_txt[112]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[113]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        </tr>
      <tr>
        <td><div align="center"><strong>1 20</strong></div></td>
        <td><strong>Dokter Spes Bedah Orthopedi</strong></td>
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
        </tr>
      <tr>
        <td><div align="center"><strong>1 21</strong></div></td>
        <td><strong>Dokter Spes Urologi</strong></td>
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
        <td><div align="center"><strong>1 22</strong></div></td>
        <td><strong>Dokter Spes Patologi Anatomi</strong></td>
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
        </tr>
      <tr>
        <td><div align="center"><strong>1 23</strong></div></td>
        <td><strong>Dokter Spes Patologi Forensik</strong></td>
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
        </tr>
      <tr>
        <td><div align="center"><strong>1 24</strong></div></td>
        <td><strong>Dokter Spes Rehabilitasi Medik</strong></td>
        <td><center>
          <input type="text" name="isi_txt[138]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[139]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
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
        </tr>
      <tr>
        <td><div align="center"><strong>1 25</strong></div></td>
        <td><strong>Dokter Spes Bedah Plastik</strong></td>
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
        </tr>
      <tr>
        <td><div align="center"><strong>1 26</strong></div></td>
        <td><strong>Dokter Spes Ked. Olah Raga</strong></td>
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
        <td><center>
          <input type="text" name="isi_txt[154]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
          <input type="text" name="isi_txt[155]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        </tr>
      <tr>
        <td><div align="center"><strong>1 27</strong></div></td>
        <td><strong>Dokter Spes Mikrobiologi Klinik</strong></td>
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
        </tr>
      <tr>
        <td><div align="center"><strong>1 28</strong></div></td>
        <td><strong>Dokter Spes Parasitologi Klinik</strong></td>
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
        <td><div align="center"><strong>1 29</strong></div></td>
        <td><strong>Dokter Spes Gizi Medik</strong></td>
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
        </tr>
      <tr>
        <td><div align="center"><strong>1 30</strong></div></td>
        <td><strong>Dokter Spes Farma Klinik</strong></td>
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
        </tr>
      <tr>
        <td><div align="center"><strong>1 31</strong></div></td>
        <td><strong>Dokter Spes Lainnya</strong></td>
        <td><center>
            <input type="text" name="isi_txt[180]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[181]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
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
      </tr>
      <tr>
        <td><div align="center"><strong>1 32</strong></div></td>
        <td><strong>Dokter Sub Spesialis Lainnya</strong></td>
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
      </tr>
      <tr>
        <td><div align="center"><strong>1 33</strong></div></td>
        <td><strong>Dokter Gigi</strong></td>
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
        <td><center>
            <input type="text" name="isi_txt[196]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[197]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 34</strong></div></td>
        <td><strong>Dokter Gigi Spesialis</strong></td>
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
      </tr>
      <tr>
        <td><div align="center"><strong>1 66</strong></div></td>
        <td><strong>Dokter/Dokter Gigi MHA/MARS **)</strong></td>
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
      </tr>
      <tr>
        <td><div align="center"><strong>1 77</strong></div></td>
        <td><strong>Dokter Gigi S2/S3 Kes Masy **)</strong></td>
        <td><center>
            <input type="text" name="isi_txt[209]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
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
      </tr>
      <tr>
        <td><div align="center"><strong>1 88</strong></div></td>
        <td><strong>S3 (Dokter Konsultan) ***)</strong></td>
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
      </tr>
      <tr>
        <td height="25" colspan="8">&nbsp;</td>
        </tr>
      <tr>
        <td height="25"><div align="center"><strong>2</strong></div></td>
        <td colspan="7"><strong>TENAGA KEPERAWATAN</strong></td>
        </tr>
      <tr>
        <td><div align="center"><strong>2 1</strong></div></td>
        <td><strong>S3 Keperawatan</strong></td>
        <td><center>
            <input type="text" name="isi_txt[221]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[222]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[223]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[224]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[225]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[226]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>2 2</strong></div></td>
        <td><strong>S2 Keperawatan</strong></td>
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
      </tr>
      <tr>
        <td><div align="center"><strong>2 3</strong></div></td>
        <td><strong>S1 Keperawatan</strong></td>
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
        <td><center>
            <input type="text" name="isi_txt[238]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>2 4</strong></div></td>
        <td><strong>D4 Keperawatan</strong></td>
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
      </tr>
      <tr>
        <td><div align="center"><strong>2 5</strong></div></td>
        <td><strong>Perawat Vokasional</strong></td>
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
      </tr>
      <tr>
        <td><div align="center"><strong>2 6</strong></div></td>
        <td><strong>Perawat Spesialis</strong></td>
        <td><center>
            <input type="text" name="isi_txt[251]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
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
            <input type="text" name="isi_txt[257]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>2 7</strong></div></td>
        <td><strong>Pembantu Keperawatan</strong></td>
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
      </tr>
      <tr>
        <td><div align="center"><strong>2 8</strong></div></td>
        <td><strong>S3 Kebidanan</strong></td>
        <td><center>
            <input type="text" name="isi_txt[264]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[265]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
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
      </tr>
      <tr>
        <td><div align="center"><strong>2 9</strong></div></td>
        <td><strong>S2 Kebidanan</strong></td>
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
      </tr>
      <tr>
        <td><div align="center"><strong>2 10</strong></div></td>
        <td><strong>S1 Kebidanan</strong></td>
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
        <td><center>
            <input type="text" name="isi_txt[280]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[281]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>2 11</strong></div></td>
        <td><strong>D3 Kebidanan</strong></td>
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
      </tr>
      <tr>
        <td><div align="center"><strong>2 88</strong></div></td>
        <td><strong>Tenaga Keperawatan Lainnya</strong></td>
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
        <td height="25" colspan="8">&nbsp;</td>
        </tr>
      <tr>
        <td height="25"><div align="center"><strong>3</strong></div></td>
        <td colspan="7"><strong>KEFARMASIAN</strong></td>
        </tr>
      <tr>
        <td><div align="center"><strong>3 1</strong></div></td>
        <td><strong>S3 Farmasi / Apoteker</strong></td>
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
      </tr>
      <tr>
        <td><div align="center"><strong>3 2</strong></div></td>
        <td><strong>S2 Farmasi / Apoteker</strong></td>
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
      </tr>
      <tr>
        <td><div align="center"><strong>3 3</strong></div></td>
        <td><strong>Apoteker</strong></td>
        <td><center>
            <input type="text" name="isi_txt[306]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[307]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
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
      </tr>
      <tr>
        <td><div align="center"><strong>3 4</strong></div></td>
        <td><strong>S1 Farmasi / Farmakologi Kimia</strong></td>
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
      </tr>
      <tr>
        <td><div align="center"><strong>3 5</strong></div></td>
        <td><strong>AKAFARMA *)</strong></td>
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
        <td><center>
            <input type="text" name="isi_txt[322]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[323]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>3 6</strong></div></td>
        <td><strong>AKFAR **)</strong></td>
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
      </tr>
      <tr>
        <td><div align="center"><strong>3 7</strong></div></td>
        <td><strong>Analis Farmasi</strong></td>
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
        <td><div align="center"><strong>3 8</strong></div></td>
        <td><strong>Asisten Apoteker / SMF</strong></td>
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
      </tr>
      <tr>
        <td><div align="center"><strong>3 9</strong></div></td>
        <td><strong>ST Lab Kimia Farmasi</strong></td>
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
      </tr>
      <tr>
        <td><div align="center"><strong>3 88</strong></div></td>
        <td><strong>Tenaga Kefarmasian Lainnya</strong></td>
        <td><center>
            <input type="text" name="isi_txt[348]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[349]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
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
      </tr>
      <tr>
        <td height="25" colspan="8"><span class="style2"></span><span class="style2"></span><span class="style2"></span><span class="style2"></span><span class="style2"></span><span class="style2"></span></td>
        </tr>
      <tr>
        <td height="25"><div align="center"><strong>4</strong></div></td>
        <td colspan="7"><strong>KESEHATAN MASYARAKAT</strong></td>
        </tr>
      <tr>
        <td><div align="center"><strong>4 1</strong></div></td>
        <td><strong>S3 - Kesehatan Masyarakat</strong></td>
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
      </tr>
      <tr>
        <td><div align="center"><strong>4 2</strong></div></td>
        <td><strong>S3 - Epidemiologi</strong></td>
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
        <td><center>
            <input type="text" name="isi_txt[364]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[365]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>4 3</strong></div></td>
        <td><strong>S3 - Psikologi</strong></td>
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
      </tr>
      <tr>
        <td><div align="center"><strong>4 4</strong></div></td>
        <td><strong>S2 - Kesehatan Masyarakat</strong></td>
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
        <td><div align="center"><strong>4 5</strong></div></td>
        <td><strong>S2 - Epidemiologi</strong></td>
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
      </tr>
      <tr>
        <td><div align="center"><strong>4 6</strong></div></td>
        <td><strong>S2 - Biomedik</strong></td>
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
      </tr>
      <tr>
        <td><div align="center"><strong>4 7</strong></div></td>
        <td><strong>S2 - Psikologi</strong></td>
        <td><center>
            <input type="text" name="isi_txt[390]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[391]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
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
      </tr>
      <tr>
        <td><div align="center"><strong>4 8</strong></div></td>
        <td><strong>S1 - Kesehatan Masyarakat</strong></td>
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
      </tr>
      <tr>
        <td><div align="center"><strong>4 9</strong></div></td>
        <td><strong>S1 - Psikologi</strong></td>
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
        <td><center>
            <input type="text" name="isi_txt[406]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[407]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>4 10</strong></div></td>
        <td><strong>D3 - Kesehatan Masyarakat</strong></td>
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
      </tr>
      <tr>
        <td><div align="center"><strong>4 11</strong></div></td>
        <td><strong>D3 - Sanitarian</strong></td>
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
        <td><div align="center"><strong>4 12</strong></div></td>
        <td><strong>D1 - Sanitarian</strong></td>
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
      </tr>
      <tr>
        <td><div align="center"><strong>4 88</strong></div></td>
        <td><strong>Tenaga Kesehatan Masy. Lainnya</strong></td>
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
      </tr>
      <tr>
        <td height="25" colspan="8">&nbsp;</td>
        </tr>
      <tr>
        <td height="25"><div align="center"><strong>5</strong></div></td>
        <td colspan="7"><strong>Gizi</strong></td>
        </tr>
      <tr>
        <td><div align="center"><strong>5 1</strong></div></td>
        <td><strong>S3 - Gizi / Dietisien</strong></td>
        <td><center>
            <input type="text" name="isi_txt[432]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[433]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
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
      </tr>
      <tr>
        <td><div align="center"><strong>5 2</strong></div></td>
        <td><strong>S2 - Gizi / Dietisien</strong></td>
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
      </tr>
      <tr>
        <td><div align="center"><strong>5 3</strong></div></td>
        <td><strong>S1 - Gizi / Dietisien</strong></td>
        <td><center>
            <input type="text" name="isi_txt[444]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[445]" id="isi_txt[]" value="" size="5px"/>
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
        <td><center>
            <input type="text" name="isi_txt[448]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>5 4</strong></div></td>
        <td><strong>D4 - Gizi / Dietisien</strong></td>
        <td><center>
            <input type="text" name="isi_txt[449]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[450]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[451]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[452]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[453]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[454]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>5 5</strong></div></td>
        <td><strong>Akademi / D3 - Gizi / Dietisien</strong></td>
        <td><center>
            <input type="text" name="isi_txt[455]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[456]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[457]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[458]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[459]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[460]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>5 6</strong></div></td>
        <td><strong>D1 - Gizi / Dietisien</strong></td>
        <td><center>
            <input type="text" name="isi_txt[461]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[462]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[463]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[464]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[465]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[466]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>5 88</strong></div></td>
        <td><strong>Tenaga Gizi Lainnya</strong></td>
        <td><center>
            <input type="text" name="isi_txt[467]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[468]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[469]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>

            <input type="text" name="isi_txt[470]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[471]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[472]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td height="25" colspan="8">&nbsp;</td>
        </tr>
      <tr>
        <td height="25"><div align="center"><strong>6</strong></div></td>
        <td colspan="7"><strong>KETERAPIAN FISIK</strong></td>
        </tr>
      <tr>
        <td><div align="center"><strong>6 1</strong></div></td>
        <td><strong>S1 Fisio Terapis</strong></td>
        <td><center>
            <input type="text" name="isi_txt[473]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[474]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[475]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[476]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[477]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[478]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>6 2</strong></div></td>
        <td><strong>D3 Fisio Terapis</strong></td>
        <td><center>
            <input type="text" name="isi_txt[479]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[480]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[481]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[482]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[483]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[484]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>6 3</strong></div></td>
        <td><strong>D3 Okupasi Terapis</strong></td>
        <td><center>
            <input type="text" name="isi_txt[485]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[486]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[487]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[488]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[489]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[490]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>6 4</strong></div></td>
        <td><strong>D3 Terapi wicara</strong></td>
        <td><center>
            <input type="text" name="isi_txt[491]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[491]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[492]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[493]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[494]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[495]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>6 5</strong></div></td>
        <td><strong>D3 Orthopedi</strong></td>
        <td><center>
            <input type="text" name="isi_txt[496]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[497]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[498]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[499]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[500]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[501]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>6 6</strong></div></td>
        <td><strong>D3 Akupuntur</strong></td>
        <td><center>
            <input type="text" name="isi_txt[502]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[503]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[504]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[505]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[506]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[507]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>6 88</strong></div></td>
        <td><strong>Tenaga Keterapian Fisik Lainnya</strong></td>
        <td><center>
            <input type="text" name="isi_txt[508]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[509]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[510]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[511]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[512]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[513]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td height="25" colspan="8">&nbsp;</td>
        </tr>
      <tr>
        <td height="25"><div align="center"><strong>7</strong></div></td>
        <td colspan="7"><strong>KETEKNISIAN MEDIS</strong></td>
        </tr>
      <tr>
        <td><div align="center"><strong>7 1</strong></div></td>
        <td><strong>S3 Opto Elektronika &amp; Apl Laser</strong></td>
        <td><center>
            <input type="text" name="isi_txt[514]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[515]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[516]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[517]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[518]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[519]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 2</strong></div></td>
        <td><strong>S2 Opto Elektronika &amp; Apl Laser</strong></td>
        <td><center>
            <input type="text" name="isi_txt[520]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[521]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[522]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[523]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[524]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[525]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 3</strong></div></td>
        <td><strong>Radiografer</strong></td>
        <td><center>
            <input type="text" name="isi_txt[526]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[527]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[528]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[529]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[530]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[531]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 4</strong></div></td>
        <td><strong>Radioterapis (Non Dokter)</strong></td>
        <td><center>
            <input type="text" name="isi_txt[532]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[533]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[534]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[535]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[536]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[537]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 5</strong></div></td>
        <td><strong>D4 Fisika Medik</strong></td>
        <td><center>
            <input type="text" name="isi_txt[538]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[539]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[540]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[541]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[542]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[543]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 6</strong></div></td>
        <td><strong>D3 Teknik Gigi</strong></td>
        <td><center>
            <input type="text" name="isi_txt[544]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[545]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[546]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[547]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[548]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[549]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 7</strong></div></td>
        <td><strong>D3 Teknik Radiologi &amp; Radioterapi</strong></td>
        <td><center>
            <input type="text" name="isi_txt[550]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[551]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[552]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[553]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[554]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[555]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 8</strong></div></td>
        <td><strong>D3 Refraksionis Optisien</strong></td>
        <td><center>
            <input type="text" name="isi_txt[556]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[557]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[558]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[559]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[560]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[561]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 9</strong></div></td>
        <td><strong>D3 Perekam Medis</strong></td>
        <td><center>
            <input type="text" name="isi_txt[562]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[563]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[564]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[565]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[566]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[567]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 10</strong></div></td>
        <td><strong>D3 Teknik Elektromedik</strong></td>
        <td><center>
            <input type="text" name="isi_txt[568]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[569]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[570]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[571]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[572]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[573]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 11</strong></div></td>
        <td><strong>D3 Analis Kesehatan</strong></td>
        <td><center>
            <input type="text" name="isi_txt[574]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[575]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[576]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[577]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[578]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[579]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 12</strong></div></td>
        <td><strong>D3 Informasi Kesehatan</strong></td>
        <td><center>
            <input type="text" name="isi_txt[580]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[581]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[582]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[583]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[584]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[585]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 13</strong></div></td>
        <td><strong>D3 Kardiovaskular</strong></td>
        <td><center>
            <input type="text" name="isi_txt[586]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[587]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[588]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[589]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[590]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[591]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 14</strong></div></td>
        <td><strong>D3 Orthotik Prostetik</strong></td>
        <td><center>
            <input type="text" name="isi_txt[592]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[593]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[594]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[595]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[596]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[597]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 15</strong></div></td>
        <td><strong>D1 Teknik Tranfusi</strong></td>
        <td><center>
            <input type="text" name="isi_txt[598]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[599]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[600]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[601]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[601]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[602]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 16</strong></div></td>
        <td><strong>Teknisi Gigi</strong></td>
        <td><center>
            <input type="text" name="isi_txt[603]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[604]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[605]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[606]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[607]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[608]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 17</strong></div></td>
        <td><strong>Tenaga IT dengan Teknologi Nano</strong></td>
        <td><center>
            <input type="text" name="isi_txt[609]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[610]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[611]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[612]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[613]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[614]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 18</strong></div></td>
        <td><strong>Teknisi Patologi Anatomi</strong></td>
        <td><center>
            <input type="text" name="isi_txt[615]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[616]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[617]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[618]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[619]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[620]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 19</strong></div></td>
        <td><strong>Teknisi Kardiovaskuler</strong></td>
        <td><center>
            <input type="text" name="isi_txt[621]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[622]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[623]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[624]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[625]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[626]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 20</strong></div></td>
        <td><strong>Teknisi Elektromedis</strong></td>
        <td><center>
            <input type="text" name="isi_txt[627]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[628]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[629]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[630]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[631]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[632]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 21</strong></div></td>
        <td><strong>Akupuntur Terapi</strong></td>
        <td><center>
            <input type="text" name="isi_txt[633]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[634]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[635]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[636]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[637]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[638]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 22</strong></div></td>
        <td><strong>Analis Kesehatan</strong></td>
        <td><center>
            <input type="text" name="isi_txt[639]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[640]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[641]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[642]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[643]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[644]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 88</strong></div></td>
        <td><strong>Tenaga Keterapian fisik Lainnya</strong></td>
        <td><center>
            <input type="text" name="isi_txt[645]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[646]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[647]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[648]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[649]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[650]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td height="25" colspan="8">&nbsp;</td>
        </tr>
      <tr>
        <td height="25"><div align="center"><strong>II</strong></div></td>
        <td colspan="7"><strong>TENAGA NON KESEHATAN</strong></td>
        </tr>
      <tr>
        <td height="25"><div align="center"><strong>8</strong></div></td>
        <td colspan="7"><strong>DOKTORAL</strong></td>
        </tr>
      <tr>
        <td><div align="center"><strong>8 1</strong></div></td>
        <td><strong>S3 Biologi</strong></td>
        <td><center>
            <input type="text" name="isi_txt[651]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[652]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[653]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[654]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[655]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[656]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>8 2</strong></div></td>
        <td><strong>S3 Kimia</strong></td>
        <td><center>
            <input type="text" name="isi_txt[657]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[658]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[659]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[660]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[661]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[662]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>8 3</strong></div></td>
        <td><strong>S3 Ekonomi / Akuntansi</strong></td>
        <td><center>
            <input type="text" name="isi_txt[663]" id="isi_txt[]" value="" size="5px"/>

        </center></td>
        <td><center>
            <input type="text" name="isi_txt[664]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[665]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[666]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[667]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[668]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>8 4</strong></div></td>
        <td><strong>S3 Administrasi</strong></td>
        <td><center>
            <input type="text" name="isi_txt[669]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[670]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[671]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[672]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[673]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[674]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>8 5</strong></div></td>
        <td><strong>S3 Hukum</strong></td>
        <td><center>
            <input type="text" name="isi_txt[675]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[676]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[677]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[678]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[679]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[680]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>8 6</strong></div></td>
        <td><strong>S3 Tehnik</strong></td>
        <td><center>
            <input type="text" name="isi_txt[681]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[682]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[683]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[684]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[685]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[686]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>8 7</strong></div></td>
        <td><strong>S3 Kes. Sosial</strong></td>
        <td><center>
            <input type="text" name="isi_txt[687]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[688]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[689]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[690]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[691]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[692]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>8 8</strong></div></td>
        <td><strong>S3 Fisika</strong></td>
        <td><center>
            <input type="text" name="isi_txt[693]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[694]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[695]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[696]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[697]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[698]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>8 9</strong></div></td>
        <td><strong>S3 Komputer</strong></td>
        <td><center>
            <input type="text" name="isi_txt[699]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[700]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[701]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[702]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[703]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[704]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>8 10</strong></div></td>
        <td><strong>S3 Statistik</strong></td>
        <td><center>
            <input type="text" name="isi_txt[705]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[706]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[707]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[708]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[709]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[810]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>8 88</strong></div></td>
        <td><strong>Doktoral Lainnya (S3)</strong></td>
        <td><center>
            <input type="text" name="isi_txt[711]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[712]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[713]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[714]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[715]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[716]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td height="25" colspan="8">&nbsp;</td>
        </tr>
      <tr>
        <td height="25"><div align="center"><strong>9</strong></div></td>
        <td colspan="7"><strong>PASCA SARJANA</strong></td>
        </tr>
      <tr>
        <td><div align="center"><strong>9 1</strong></div></td>
        <td><strong>S2 Biologi</strong></td>
        <td><center>
            <input type="text" name="isi_txt[717]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[718]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[719]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[720]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[721]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[722]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>9 2</strong></div></td>
        <td><strong>S2 Kimia</strong></td>
        <td><center>
            <input type="text" name="isi_txt[723]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[724]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[725]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[726]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[727]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[728]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>9 3</strong></div></td>
        <td><strong>S2 Ekonomi / Akuntansi</strong></td>
        <td><center>
            <input type="text" name="isi_txt[729]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[730]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[731]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[732]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[733]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[734]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>9 4</strong></div></td>
        <td><strong>S2 Administrasi</strong></td>
        <td><center>
            <input type="text" name="isi_txt[735]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[736]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[737]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[738]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[739]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[740]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>9 5</strong></div></td>
        <td><strong>S2 Hukum</strong></td>
        <td><center>
            <input type="text" name="isi_txt[741]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[742]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[743]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[744]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[745]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[746]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>9 6</strong></div></td>
        <td><strong>S2 Tehnik</strong></td>
        <td><center>
            <input type="text" name="isi_txt[747]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[748]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[749]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[750]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[751]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[752]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>9 7</strong></div></td>
        <td><strong>S2 Kesejahteraan Sosial</strong></td>
        <td><center>
            <input type="text" name="isi_txt[753]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[754]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[755]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[756]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[757]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[758]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>9 8</strong></div></td>
        <td><strong>S2 Fisika</strong></td>
        <td><center>
            <input type="text" name="isi_txt[759]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[760]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[761]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[762]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[763]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[764]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>9 9</strong></div></td>
        <td><strong>S2 Komputer</strong></td>
        <td><center>
            <input type="text" name="isi_txt[765]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[766]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[767]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[768]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[769]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[770]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>9 10</strong></div></td>
        <td><strong>S2 Statistik</strong></td>
        <td><center>
            <input type="text" name="isi_txt[771]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[772]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[773]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[774]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[775]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[776]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>9 11</strong></div></td>
        <td><strong>S2 Administrasi Kes. Masy</strong></td>
        <td><center>
            <input type="text" name="isi_txt[777]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[778]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[779]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[780]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[781]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[782]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>9 88</strong></div></td>
        <td><strong>Pasca Sarjana Lainnya (S2)</strong></td>
        <td><center>
            <input type="text" name="isi_txt[783]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[784]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[785]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[786]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[787]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[788]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td height="25" colspan="8">&nbsp;</td>
        </tr>
      <tr>
        <td height="25"><div align="center"><strong>10</strong></div></td>
        <td colspan="7"><strong>SARJANA</strong></td>
        </tr>
      <tr>
        <td><div align="center"><strong>10 1</strong></div></td>
        <td><strong>Sarjana Biologi</strong></td>
        <td><center>
            <input type="text" name="isi_txt[789]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[790]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[791]" id="isi_txt[]" value="" size="5px"/> <!-- disini!!!! -->
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[792]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[793]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[794]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>10 2</strong></div></td>
        <td><strong>Sarjana Kimia</strong></td>
        <td><center>
            <input type="text" name="isi_txt[795]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[796]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[797]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[798]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[799]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[800]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>10 3</strong></div></td>
        <td><strong>Sarjana Ekonomi / Akuntansi</strong></td>
        <td><center>
            <input type="text" name="isi_txt[801]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[802]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[803]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[804]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[805]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[806]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>10 4</strong></div></td>
        <td><strong>Sarjana Administrasi</strong></td>
        <td><center>
            <input type="text" name="isi_txt[807]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[808]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[809]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[810]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[811]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[812]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>10 5</strong></div></td>
        <td><strong>Sarjana Hukum</strong></td>
        <td><center>
            <input type="text" name="isi_txt[813]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[814]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[815]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[816]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[817]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[818]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>10 6</strong></div></td>
        <td><strong>Sarjana Tehnik</strong></td>
        <td><center>
            <input type="text" name="isi_txt[819]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[820]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[821]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[822]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[823]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[824]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>10 7</strong></div></td>
        <td><strong>Sarjana Kes. Sosial</strong></td>
        <td><center>
            <input type="text" name="isi_txt[825]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[826]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[827]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[828]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[829]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[830]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>10 8</strong></div></td>
        <td><strong>Sarjana Fisika</strong></td>
        <td><center>
            <input type="text" name="isi_txt[831]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[832]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[833]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[834]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[835]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[836]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>10 9</strong></div></td>
        <td><strong>Sarjana Komputer</strong></td>
        <td><center>
            <input type="text" name="isi_txt[837]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[838]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[839]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[840]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[841]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[842]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>10 10</strong></div></td>
        <td><strong>Sarjana Statistik</strong></td>
        <td><center>
            <input type="text" name="isi_txt[843]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[844]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[845]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[846]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[847]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[848]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>10 88</strong></div></td>
        <td><strong>Sarjana Lainnya (S1)</strong></td>
        <td><center>
            <input type="text" name="isi_txt[849]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[850]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[851]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[852]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[853]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[854]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td height="25"><div align="center"><strong>11</strong></div></td>
        <td colspan="7"><strong>SARJANA MUDA</strong></td>
        </tr>
      <tr>
        <td><div align="center"><strong>11 1</strong></div></td>
        <td><strong>Sarjana Muda Biologi</strong></td>
        <td><center>
            <input type="text" name="isi_txt[855]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[856]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[857]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[858]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[859]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[860]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>11 2</strong></div></td>
        <td><strong>ApotekSarjana Muda Kimia</strong></td>
        <td><center>
            <input type="text" name="isi_txt[861]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[862]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[863]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[864]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[865]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[866]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>11 3</strong></div></td>
        <td><strong>Sarjana Muda Ekonomi / Akuntansi</strong></td>
        <td><center>
            <input type="text" name="isi_txt[867]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[868]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[869]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[870]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[871]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[872]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>11 4</strong></div></td>
        <td><strong>Sarjana Muda Administrasi</strong></td>
        <td><center>
            <input type="text" name="isi_txt[873]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[874]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[875]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[876]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[877]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[878]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>11 5</strong></div></td>
        <td><strong>Sarjana Muda Hukum</strong></td>
        <td><center>
            <input type="text" name="isi_txt[879]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[880]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[881]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[882]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[883]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[884]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>11 6</strong></div></td>
        <td><strong>Sarjana Muda Tehnik</strong></td>
        <td><center>
            <input type="text" name="isi_txt[885]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[886]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[887]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[888]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[889]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[890]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>11 7</strong></div></td>
        <td><strong>Sarjana Muda Kes. Sosial</strong></td>
        <td><center>
            <input type="text" name="isi_txt[891]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[892]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[893]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[894]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[895]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[896]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>11 8</strong></div></td>
        <td><strong>Sarjana Muda Statistik</strong></td>
        <td><center>
            <input type="text" name="isi_txt[897]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[898]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[899]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[900]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[901]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[902]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>11 9</strong></div></td>
        <td><strong>Sarjana Muda Komputer</strong></td>
        <td><center>
            <input type="text" name="isi_txt[903]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[904]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[905]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[906]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[907]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[908]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>11 10</strong></div></td>
        <td><strong>Sarjana Muda Sekretaris</strong></td>
        <td><center>
            <input type="text" name="isi_txt[909]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[910]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[911]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[912]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[913]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[914]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>11 88</strong></div></td>
        <td><strong>Sarjana Muda / D3 Lainnya</strong></td>
        <td><center>
            <input type="text" name="isi_txt[915]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[916]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[917]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[918]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[919]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[920]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td height="25"><div align="center"><strong>12</strong></div></td>
        <td colspan="7"><strong>SMU SEDERAJAT DAN DIBAWAHNYA</strong></td>
        </tr>
      <tr>
        <td><div align="center"><strong>12 1</strong></div></td>
        <td><strong>SMA / SMU</strong></td>
        <td><center>
            <input type="text" name="isi_txt[921]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[922]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[923]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[924]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[925]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[926]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>12 2</strong></div></td>
        <td><strong>SMEA</strong></td>
        <td><center>
            <input type="text" name="isi_txt[927]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[928]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[929]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[930]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[931]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[932]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>12 3</strong></div></td>
        <td><strong>STM</strong></td>
        <td><center>
            <input type="text" name="isi_txt[933]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[934]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[935]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[936]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[937]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[938]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>12 4</strong></div></td>
        <td><strong>SMKK</strong></td>
        <td><center>
            <input type="text" name="isi_txt[939]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[940]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[941]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[942]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[943]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[944]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>12 5</strong></div></td>
        <td><strong>SPSA</strong></td>
        <td><center>
            <input type="text" name="isi_txt[945]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[946]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[947]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[948]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[949]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[950]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>12 6</strong></div></td>
        <td><strong>SMTP</strong></td>
        <td><center>
            <input type="text" name="isi_txt[951]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[952]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[953]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[954]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[955]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[956]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>12 7</strong></div></td>
        <td><strong>SD kebawah</strong></td>
        <td><center>
            <input type="text" name="isi_txt[957]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[958]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[959]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[960]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[961]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[962]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>12 88</strong></div></td>
        <td><strong>SMTA Lainnya</strong></td>
        <td><center>
            <input type="text" name="isi_txt[963]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[964]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[965]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[966]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[967]" id="isi_txt[]" value="" size="5px"/>
        </center></td>
        <td><center>
            <input type="text" name="isi_txt[968]" id="isi_txt[]" value="" size="5px"/>
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
            a.loadURL("form_RL2.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("DATA RL 2");
        a.setColHeader("NO,NO RM,NO FORMULIR,TGL INPUT,PENGGUNA");
        a.setIDColHeader(",no_rm,,,");
        a.setColWidth("100,150,100,150,200");
        a.setCellAlign("center,center,center,center,center");
        a.setCellHeight(20);
        a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("form_RL2_util.php");
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
		window.open("form_RL2.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUsr?>","_blank");
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
