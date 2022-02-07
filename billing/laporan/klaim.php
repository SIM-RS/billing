<?php
session_start();
include "../sesi.php";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script type="text/javascript" src="../theme/js/ajax.js"></script>


<!--dibawah ini diperlukan untuk menampilkan popup-->
<link rel="stylesheet" type="text/css" href="../theme/popup.css" />
<script type="text/javascript" src="../theme/prototype.js"></script>
<script type="text/javascript" src="../theme/effects.js"></script>
<script type="text/javascript" src="../theme/popup.js"></script>
<!--diatas ini diperlukan untuk menampilkan popup-->

<title>Laporan Pengajuan Klaim Pasien</title>
</head>
<body>
<script>
	var arrRange = depRange = [];
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js" src="../theme/popcjs.php" scrolling="no" frameborder="1" 
	style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
</iframe>
<div id="divKlaim" align="center" style="display:block;">
<?php	
	include("../koneksi/konek.php");
	include("../header1.php");	
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$time_now=gmdate('H:i:s',mktime(date('H')+7));
	$tglGet=$_REQUEST['tgl'];	
?>
<table width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#008484"  class="hd2">
      <tr>
            <td height="30">&nbsp;FORM LAPORAN PENGAJUAN KLAIM PASIEN</td>
      </tr>
</table>
	<table width="1000" border="0" cellpadding="0" cellspacing="0" align="center" class="tabel">
      <tr>
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
      </tr>
      <tr>
         <td width="10%">&nbsp;</td>
         <td width="30%" align="right">Jenis Layanan :</td>
         <td width="40%"><select id="cmbJnsLay" class="txtinput"></select></td>
         <td width="10%">&nbsp;</td>
      </tr>
      <tr>
         <td>&nbsp;</td>
         <td align="right">Tempat Layanan :</td>
         <td><select id="cmbTmpLay"  class="txtinput"></select></td>
         <td>&nbsp;</td>
      </tr>
      <tr>
         <td>&nbsp;</td>
         <td align="right">Periode :</td>
         <td>
            <input id="txtTglAwal" name="txtTglAwal" size="11" class="txtcenter" type="text" value="<?php echo $date_now;?>"/>
            &nbsp;<input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('txtTglAwal'),depRange);"/>
            &nbsp;
            Sampai
            &nbsp;
            <input id="txtTglAkhir" name="txtTglAkhir" size="11" class="txtcenter" type="text" value="<?php echo $date_now;?>" />
            &nbsp;
            <input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('txtTglAkhir'),depRange);"/>
         </td>
         <td>&nbsp;</td>
      </tr>
       <tr>
         <td>&nbsp;</td>
         <td align="right">Penjamin Pasien :</td>
         <td><select id="cmbPenjamin" class="txtinput"></select></td>
         <td>&nbsp;</td>
      </tr>
       <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td><input type="button" id="btnCetak" name="btnCetak" value="Cetak" onClick="cetakKlaim()"/></td>
         <td>&nbsp;</td>
      </tr>
      <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
      </tr>
   </table>
   <table border="0" cellpadding="0" cellspacing="0" width="1000" class="hd2">
      <tr height="30">
      <td>&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" class="btninput" /></td>
      <td>&nbsp;</td>
      <td align="right"><a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" class="btninput" /></a>&nbsp;</td>
      </tr>
   </table>
</div>
<script>
   function isiCombo(id,val,defaultId,targetId,evloaded){
      //alert('pasien_list.php?act=combo&id='+id+'&value='+val);
      if(targetId=='' || targetId==undefined){
            targetId=id;
      }
      Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded);		
   }
   isiCombo('JnsLayanan','','','cmbJnsLay',getUnit);
   
   function getUnit(){
      isiCombo('TmpLayanan',document.getElementById('cmbJnsLay').value,'','cmbTmpLay');
   }
   isiCombo('StatusPas','','','cmbPenjamin');
   
   function cetakKlaim(){
      var unit=document.getElementById('cmbTmpLay').value;
      var tglAwal=document.getElementById('txtTglAwal').value;
      var tglAkhir=document.getElementById('txtTglAkhir').value;
      var penjamin=document.getElementById('cmbPenjamin').value;
      window.open('klaim_lap.php?unit='+unit+'&tglAwal='+tglAwal+'&tglAkhir='+tglAkhir+'&penjamin='+penjamin,'_blank');
   }
</script>
</body>
</html>
<?php 
mysql_close($konek);
?>