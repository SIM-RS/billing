<?php 
header("content-type: text/html; charset=iso-8859-1");
ini_set("session.gc_maxlifetime", "18000");
include("../sesi.php");
include("../koneksi/konek.php");
$username = $_SESSION["username"];
$password = $_SESSION["password"];
$idunit = $_SESSION["ses_idunit"];
$namaunit = $_SESSION["ses_namaunit"];
$kodeunit = $_SESSION["ses_kodeunit"];
$iduser = $_SESSION["iduser"];
$unit_tipe = $_SESSION["ses_unit_tipe"];
$kategori = $_SESSION["kategori"];

//Jika Tidak login, maka lempar ke index utk login dulu =========
if (empty ($username) AND empty ($password)){
	header("Location: ../../index.php");
	exit();
}
//==============================================================
if ($unit_tipe<>8){
	//header("Location: ../../index.php");
	//exit();
}
//
$file=$_GET["f"];
if ((strpos($file,".php")<=0)&&($file!="")) $file .=".php";
?>
<html>
<head>
<title>Sistem Informasi Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script type="text/javascript" src="../jquery.js"></script>
<script type="text/javascript" src="../menu.js"></script>
<!--script src="../theme/js/noklik.js" type="text/javascript"></script-->
<!-- Script Pop Up Window -->
<link rel="shortcut icon" href="../../billing/icon/favicon.ico" />
<link rel="stylesheet" type="text/css" href="../theme/popup.css" />
<script type="text/javascript" src="../theme/js/prototype.js"></script>
<script type="text/javascript" src="../theme/js/effects.js"></script>
<script type="text/javascript" src="../theme/js/popup.js"></script>
<script language="javascript">
var win = null;
function NewWindow(mypage,myname,w,h,scroll){
LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
settings =
'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
win = window.open(mypage,myname,settings)
}
</script>
<!-- Script Pop Up Window Berakhir -->
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
</head>
<body>
<div align="center">
<?php
$wktnow=gmdate('H:i:s',mktime(date('H')+7));
$wkttgl=gmdate('d/m/Y',mktime(date('H')+7));
$tglcek=explode("/",$wkttgl);if (substr($tglcek[1],0,1)=="0") $tglcek[1]=substr($tglcek[1],1,1);
$url=split("/",$_SERVER['REQUEST_URI']);
$imgpath="/".$url[1]."/images";
$iunit=$_SESSION['username'];
?>
<style type="text/css">
<!--
.style1 {font-family: Verdana, Arial, Helvetica, sans-serif}
-->
</style>
<?php if ($file=="penerimaan_baru_non_pbf.php" && $_REQUEST["act"]!="save"){
	$cwidth=842;
}else{
	$cwidth=637;
}
?>
<table width="1000" border="0" cellspacing="0" cellpadding="0">
  <tr class="H">
  	<td width="155">&nbsp;</td>
	<td align="right">
	<table width="<?php echo $cwidth; ?>" border="0" align="center" id="menuatas" style="visibility:hidden">
      <tr style="border-right:#FFFFFF">
        <td id="link2" align="right"><a class="navText" width="300" style="cursor:pointer;" onMouseOver="MM_showMenu(window.mm_menu_0814123211_3,75,0,null,'link2');" onMouseOut="MM_startTimeout();"> A.1 Master &laquo;</a></td>
        <td width="23" rowspan="5" align="center" id style="border-right:1px solid #FFFFFF; border-left:1px solid #FFFFFF">&nbsp;</td>
        <td id="link22" align="left"><a class="navText" style="cursor:pointer;" onMouseOver="MM_showMenu(window.mm_menu_0814123212_3,160,0,null,'link22');" onMouseOut="MM_startTimeout();">&raquo; A.2 Penerimaan Obat</a></td>
      </tr>
      <tr>
        <td align="right">
		<a class="navText" href="?f=../gudang/list_permintaan.php"> A.3 Permintaan Unit &laquo;</a>
		<!--a class="navText" href="?f=../transaksi/mutasi.php"> A.3 Mutasi &laquo;</a--></td>
        <td><a class="navText" href="?f=../transaksi/stok.php">&raquo; A.4 Stok Opname</a></td>
      </tr>
      <tr>
        <td id="link10" align="right"><a class="navText" style="cursor:pointer" onMouseOver="MM_showMenu(window.mm_menu_0814123211_10,50,0,null,'link10');" onMouseOut="MM_startTimeout();"> A.5 Retur Obat &laquo;</a></td>
        <td><a class="navText" href="?f=list_pinjam_obat.php">&raquo; A.6 Pindah Kepemilikan</a></td>
      </tr>
      <tr>
        <td align="right">&nbsp;<a class="navText" href="?f=list_hps_obat.php">A.7 Rencana Penghapusan &laquo;</a></td>
		<td align="left"><a class="navText" id="link3" style="cursor:pointer;" onMouseOver="MM_showMenu(window.mm_menu_0814123211_2,100,0,null,'link3');" onMouseOut="MM_startTimeout();">&raquo; A.8 Laporan</a></td>
      </tr>
      <tr>
        <td align="right">&nbsp;<a class="navText" href="?f=../transaksi/tutupbuku.php">A.9 Close Month &laquo;</a></td>
        <td align="left"><a class="navText" href="?f=../master/sop.php">&raquo; A.10 View SOP</a></td>
      </tr>
      
      <!--tr>
        <td width="300"></td>
        <td>&nbsp;</td>
      </tr-->
    </table>
<table width="100%" border="0">
  <tr>
    <td width="100%" style="float:left; padding-left:10px; font:12px arial; color:#FFFF00">
	<i>Tanggal: <?php echo $wkttgl; ?></i>&nbsp;&nbsp;&nbsp;&nbsp;
	Login: <b><?php  echo strtoupper($username); ?></b>&nbsp;&nbsp;&nbsp;&nbsp;
	<!--Unit: <b><?php echo strtoupper($namaunit); ?></b>-->
	</td>
  </tr>
</table>
	</td>
	<td width="167">&nbsp;</td>
  </tr>
  <tr class="H">
  	<td height="25" colspan="6" id="dateformat">
	<? include "../menu.php";?>
	<!--<marquee scrolldelay="150" style="text-transform:uppercase">
	SISTEM FARMASI <?=$namaRS;?>
	</marquee>-->
	</td>
	</tr>
</table>
<!--script>
document.getElementById("logout").innerHTML='<a class="a1" href="../index.php">Logout</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
</script-->
<table width="1000" border="0" cellspacing="0" cellpadding="0" class="tblbody">
<tr align="center" valign="top">
      <!--td width="5" height="450">&nbsp;</td-->
	<td align="left" height="450"><?php if ($file!="") include($file); else echo "&nbsp;"; ?></td>
</tr>
</table>
</div>
<script language="JavaScript" src="../theme/js/mm_menu.js"></script>
<script language="JavaScript" src="../theme/js/dropdown.js"></script>
<script language="JavaScript1.2">mmLoadMenus();</script>
<script>
var reqCekXML = new Array();
setTimeout("ReqCheckMinta('../transaksi/cek_permintaan.php?idunit=<?php echo $idunit; ?>&bln=<?php echo $tglcek[1]; ?>&ta=<?php echo $tglcek[2]; ?>')", 300000);
setTimeout("ReqCheckMinta('../transaksi/cek_minmax.php?idunit=<?php echo $idunit; ?>')", 300000);

ReqCheckMinta = function(vUrl) {
  //alert("tes"); 
  var pos = -1;
  for (var i=0; i<reqCekXML.length; i++) {
    if (reqCekXML[i].available == 1) { 
      pos = i; 
      break; 
	}
  }

  if (pos == -1) { 
    pos = reqCekXML.length; 
    reqCekXML[pos] = new newRequestCekXML(1); 
  }

  if (reqCekXML[pos].xmlhttp) {
    reqCekXML[pos].available = 0;
    reqCekXML[pos].xmlhttp.open("GET" , vUrl, true);
	reqCekXML[pos].xmlhttp.onreadystatechange = function() {
	  if (typeof(reqCekXML[pos]) != 'undefined' && 
		reqCekXML[pos].available == 0 && 
		reqCekXML[pos].xmlhttp.readyState == 4) {
		  if (reqCekXML[pos].xmlhttp.status == 200 || reqCekXML[pos].xmlhttp.status == 304) {
		  		var xdc=reqCekXML[pos].xmlhttp.responseText.split(String.fromCharCode(3));
				if (xdc[1]!=""){
					alert(xdc[1]);
				}
				if (xdc[0]=="1"){
					setTimeout("ReqCheckMinta('../transaksi/cek_permintaan.php?idunit=<?php echo $idunit; ?>&bln=<?php echo $tglcek[1]; ?>&ta=<?php echo $tglcek[2]; ?>')", 300000);
				}else if (xdc[0]=="2"){
					setTimeout("ReqCheckMinta('../transaksi/cek_minmax.php?idunit=<?php echo $idunit; ?>')", 300000);
				}
		  } else {
				reqCekXML[pos].xmlhttp.abort();
		  }
		  reqCekXML[pos].available = 1;
	  }
	}
	
	if (window.XMLHttpRequest) {
	  reqCekXML[pos].xmlhttp.send(null);
	} else if (window.ActiveXObject) {
	  reqCekXML[pos].xmlhttp.send();
	}
  }
  return false;
}
function newRequestCekXML(available) {
	this.available = available;
	this.xmlhttp = false;
	
	if (window.XMLHttpRequest) { // Mozilla, Safari,...
		this.xmlhttp = new XMLHttpRequest();
		if (this.xmlhttp.overrideMimeType) {
			this.xmlhttp.overrideMimeType('text/html');
		}
	}
	else if (window.ActiveXObject) { // IE
		var MsXML = new Array('Msxml2.XMLHTTP.5.0','Msxml2.XMLHTTP.4.0','Msxml2.XMLHTTP.3.0','Msxml2.XMLHTTP','Microsoft.XMLHTTP');	
		for (var i = 0; i < MsXML.length; i++) {
			try {
				this.xmlhttp = new ActiveXObject(MsXML[i]);
			} catch (e) {}
		}
	}	
}
</script>
</body>
</html>
