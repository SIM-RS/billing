<?php 
include("../sesi.php"); 
?>
<?php 
header("content-type: text/html; charset=iso-8859-1");
ini_set("session.gc_maxlifetime", "18000");
include("../sesi.php"); 
$username = $_SESSION["username"];
$password = $_SESSION["password"];
$idunit = $_SESSION["ses_idunit"];
$namaunit = $_SESSION["ses_namaunit"];
$kodeunit = $_SESSION["ses_kodeunit"];
$iduser = $_SESSION["iduser"];
$unit_tipe = $_SESSION["ses_unit_tipe"];
$kategori = $_SESSION["kategori"];
$shift=$_SESSION["shift"];
$id_gudang=$_SESSION["ses_id_gudang"];

//Jika Tidak login, maka lempar ke index utk login dulu =========
if (empty ($username) AND empty ($password)){
	header("Location: ../../index.php");
	exit();
}
//==============================================================
if ($unit_tipe<>2){
	header("Location: ../../index.php");
	exit();
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
<!--script src="../theme/js/noklik.js" type="text/javascript"></script-->
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

<table width="1000" border="0" cellspacing="0" cellpadding="0">
  <tr class="H">
  	<td width="155" bgcolor="#4E98C8"><img src="../images/kopKiri.jpg" width="166" height="100"></td>
	<td align="right" bgcolor="#4E98C8">
	<table width="654" border="0" align="center" id="menuatas">
      <tr style="border-right:#FFFFFF">
        <td width="321" align="right"><a class="navText" href="?f=list_minta_obat.php">B1. Permintaan Obat &laquo;</a></td>
        <td width="19" rowspan="5" align="center" id style="border-right:1px solid #FFFFFF; border-left:1px solid #FFFFFF">&nbsp;</td>
        <td width="283" align="left"><a class="navText" href="?f=list_penerimaan.php">&raquo; B2. Penerimaan Obat</a></td>
      </tr>
      <tr>
        <td height="15" align="right"><a class="navText" href="?f=../transaksi/penjualan.php">B3. Penjualan &laquo;</a></td>
        <td align="left"><a class="navText" href="?f=../transaksi/retur_penjualan.php">&raquo; B4. Return Penjualan/Resep</a></td>
      </tr>
      <tr><td align="right"><a class="navText" href="?f=../gudang/list_permintaan.php"> B5. Permintaan Unit Lain &laquo;</a></td>
        <td width="283" align="left"><a class="navText" href="?f=../transaksi/list_retur_kegudang.php">&raquo; B6. Return Obat ke Gudang </a></td>
      </tr>
      <tr>
        <td width="283" align="right"><a class="navText" href="?f=../transaksi/stok.php"> B7. Stok Opname &laquo;</a></td>
		<td align="left"><a class="navText" id="link3" width="300" style="cursor:pointer;" onMouseOver="MM_showMenu(window.mm_menu_0814123211_0,95,0,null,'link3');" onMouseOut="MM_startTimeout();">&raquo; B8. Laporan </a></td>
      </tr>
      <tr>
        <td align="right">&nbsp;<a class="navText" href="?f=../transaksi/tutupbuku.php">B9 Close Month &laquo;</a></td>
        <td align="left">&nbsp;</td>
      </tr>
    </table>
<table width="100%" border="0">
  <tr>
    <td width="74%" style="float:left; padding-left:10px; font:12px arial; color:#FFFF00">
	<i>Tanggal: <?php echo $wkttgl; ?></i>&nbsp;&nbsp;&nbsp;&nbsp;
	Login: <b><?=strtoupper($username); ?></b>&nbsp;&nbsp;&nbsp;&nbsp;
	Unit: <b><?php echo strtoupper($namaunit); ?></b>
	</td>
    <td width="26%" align="right" style="padding-right:10px;">
	<button type="button" onClick="if (confirm('Anda Yakin Ingin Logout?')){location='../logout.php';}" style=" font:bold 11px Verdana;"><img src="../icon/logout.gif"> Logout</button>
	</td>
  </tr>
</table>
</td>
	<td width="167" bgcolor="#4E98C8"><img src="../images/kopKanan.jpg" width="166" height="100"></td>
  </tr>
  <tr class="H">
  	<td height="25" colspan="6" id="dateformat">
	<marquee scrolldelay="150" style="text-transform:uppercase">
	SISTEM FARMASI <?=$namaRS;?>
	</marquee>
	</td>
	</tr>
</table>
<!--script>
document.getElementById("logout").innerHTML='<a class="a1" href="../index.php">Logout</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
</script-->
<table width="1000" border="0" cellspacing="0" cellpadding="0" class="tblbody">
<tr align="center" valign="top">
      <!--td width="5" height="450">&nbsp;</td-->
	<td align="center" height="450"><?php if ($file!="") include($file); else echo "&nbsp;"; ?></td>
</tr>
</table>
</div>
<script language="JavaScript" src="../theme/js/mm_menu.js"></script>
<script language="JavaScript" src="../theme/js/dropdown.js"></script>
<script language="JavaScript1.2">mmLoadMenus();</script>
<script>
var reqCekXML = new Array();
setTimeout("ReqCheckMinta('../transaksi/cek_permintaan.php?idunit=<?php echo $idunit; ?>&bln=<?php echo $tglcek[1]; ?>&ta=<?php echo $tglcek[2]; ?>')", 300000);
setTimeout("ReqCheckMinta('../transaksi/cek_pengiriman.php?idunit=<?php echo $idunit; ?>&bln=<?php echo $tglcek[1]; ?>&ta=<?php echo $tglcek[2]; ?>')", 300000);
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
				}else{
					setTimeout("ReqCheckMinta('../transaksi/cek_pengiriman.php?idunit=<?php echo $idunit; ?>&bln=<?php echo $tglcek[1]; ?>&ta=<?php echo $tglcek[2]; ?>')", 300000);
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