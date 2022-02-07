<?php 
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
$id_gudang=$_SESSION["ses_id_gudang"];

//Jika Tidak login, maka lempar ke index utk login dulu =========
if (empty ($username) AND empty ($password)){
	header("Location: ../../index.php");
	exit();
}
//==============================================================
if ($unit_tipe<>1){
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
<!-- Script Pop Up Window -->
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
        <td id="link2" align="right"><a class="navText" width="300" style="cursor:pointer;" onMouseOver="MM_showMenu(window.mm_menu_0814123211_3,75,0,null,'link2');" onMouseOut="MM_startTimeout();"> A.1 Master &laquo;</a></td>
        <td width="23" rowspan="4" align="center" id style="border-right:1px solid #FFFFFF; border-left:1px solid #FFFFFF">&nbsp;</td>
        <td align="left"><a class="navText" href="?f=penerimaan.php">&raquo; A.2 Penerimaan PBF </a></td>
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
        <td align="right">&nbsp;<a class="navText" href="?f=list_hps_obat.php">A.7 Penghapusan Obat &laquo;</a></td>
		<td align="left"><a class="navText" id="link3" style="cursor:pointer;" onMouseOver="MM_showMenu(window.mm_menu_0814123211_2,100,0,null,'link3');" onMouseOut="MM_startTimeout();">&raquo; A.8 Laporan</a></td>
      </tr>
      <!--tr>
        <td width="300"></td>
        <td>&nbsp;</td>
      </tr-->
    </table>
<table width="100%" border="0">
  <tr>
    <td width="50%" style="float:left; padding-left:10px; font:12px arial; color:#FFFF00">
	<i>Tanggal: <?php echo $wkttgl; ?></i>&nbsp;&nbsp;&nbsp;&nbsp;
	Login: <b><?php  echo strtoupper($username); ?></b>&nbsp;&nbsp;&nbsp;&nbsp;
	Unit: <b><?php echo strtoupper($namaunit); ?></b>
	</td>
    <td width="50%" align="right" style="padding-right:10px;">
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
      <td width="5" height="450">&nbsp;</td>
	<td align="left"><?php if ($file!="") include($file); else echo "&nbsp;"; ?></td>
</tr>
</table>
</div>
<script language="JavaScript" src="../theme/js/mm_menu.js"></script>
<script language="JavaScript" src="../theme/js/dropdown.js"></script>
<script language="JavaScript1.2">mmLoadMenus();</script>
</body>
</html>
