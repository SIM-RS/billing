<?php 
include("../sesi.php");

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
<script src="../theme/js/noklik.js" type="text/javascript"></script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
</head>
<body>
<div align="center">
<?php
$wktnow=gmdate('H:i:s',mktime(date('H')+7));
$wkttgl=gmdate('d/m/Y',mktime(date('H')+7));
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
	<table width="637" border="0" align="center" id="menuatas">
      <tr style="border-right:#FFFFFF">
        <td width="321" align="right"><a class="navText" href="?f=list_minta_obat.php">B1. Permintaan Obat &laquo;</a></td>
        <td width="19" rowspan="4" align="center" id style="border-right:1px solid #FFFFFF; border-left:1px solid #FFFFFF">&nbsp;</td>
        <td width="283" align="left"><a class="navText" href="?f=list_penerimaan.php">&raquo; B2. Penerimaan dari Gudang </a></td>
      </tr>
      <tr>
        <td height="15" align="right"><a class="navText" href="?f=../transaksi/penjualan.php">B3. Penjualan Online &laquo;</a></td>
        <td id="link2" align="left" style="cursor:pointer;" onMouseOver="MM_showMenu(window.mm_menu_0814123211_1,125,0,null,'link2');" onMouseOut="MM_startTimeout();"><a class="navText">&raquo; B4. Pinjam Obat</a></td>
      </tr>
      <tr><td align="right"><a class="navText" href="?f=../transaksi/retur_penjualan.php"> B5. Retur Penjualan/Resep &laquo;</a></td>
        <td  id="link3" width="300" align="left" style="cursor:pointer;" onMouseOver="MM_showMenu(window.mm_menu_0814123211_0,95,0,null,'link3');" onMouseOut="MM_startTimeout();"><a class="navText">&raquo; B6. Laporan </a></td>
      </tr>
      <tr><td align="right"><a class="navText" href="?f=../transaksi/copy of penjualan.php"> B7. Penjualan Offline &laquo;</a></td>
        
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
	<button type="button" onClick="if (confirm('Anda Yakin Ingin Logout?')){location='../index.php';}" style=" font:bold 11px Verdana;"><img src="../icon/logout.gif"> Logout</button>
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
</body>
</html>