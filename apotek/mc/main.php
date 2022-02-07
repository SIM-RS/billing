<?php 
include("../sesi.php");
include("../koneksi/konek.php");

$username = $_SESSION["username"];
$password = $_SESSION["password"];
$idunit = $_SESSION["ses_idunit"];
$namaunit = $_SESSION["ses_namaunit"];
$kodeunit = $_SESSION["ses_kodeunit"];
$iduser = $_SESSION["iduser"];
$kategori = $_SESSION["kategori"];

//Jika Tidak login, maka lempar ke index utk login dulu =========
if (empty ($username) AND empty ($password)){
	header("Location: ../../index.php");
	exit();
}
//==============================================================
/*if ($kategori<>2){
	header("Location: ../../index.php");
	exit();
}*/
include("../session_unit.php");
$tipe=4;
if($_SESSION["ses_tipeunit_temp"]!=$tipe){
	$_SESSION["ses_idunit_temp"]='';	
}
$idunit=getSessionUnit($tipe,$iduser,'id');
$_SESSION["ses_idunit"]=getSessionUnit($tipe,$iduser,'id');
$namaunit=getSessionUnit($tipe,$iduser,'nama');
$kodeunit=getSessionUnit($tipe,$iduser,'kode');
$qUnit=getSessionUnit($tipe,$iduser,'combo');
$_SESSION["ses_tipeunit_temp"]=$tipe;
$unit_tipe=$tipe;
//
$file=$_GET["f"];
if ((strpos($file,".php")<=0)&&($file!="")) $file .=".php";

include("../sesi.php");
$wktnow=gmdate('H:i:s',mktime(date('H')+7));
$wkttgl=gmdate('d/m/Y',mktime(date('H')+7));
$url=split("/",$_SERVER['REQUEST_URI']);
$imgpath="/".$url[1]."/images";
$iunit=$_SESSION['username'];
?>
<html>
<head>
<title>Sistem Informasi Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script type="text/javascript" src="../jquery.js"></script>
<script type="text/javascript" src="../menu.js"></script>

<script language="JavaScript" src="../theme/js/mod.js"></script>
<!--script src="../theme/js/noklik.js" type="text/javascript"></script-->
<link rel="shortcut icon" href="../../billing/icon/favicon.ico" />
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
</head>
<body>
<div align="center">
<table width="1000" border="0" cellspacing="0" cellpadding="0">
  <tr class="H">
  	<td width="155">&nbsp;</td>
	<td align="right">
	<table width="637" border="0" align="center" id="menuatas" style="visibility:hidden">
      <tr style="border-right:#FFFFFF">
        <td align="right"><a class="navText" href="spph.php">C1. SPPH &laquo;</a></td>
        <td width="23" rowspan="4" align="center" id style="border-right:1px solid #FFFFFF; border-left:1px solid #FFFFFF">&nbsp;</td>
        <td align="left"><a class="navText" href="po.php">&raquo; C2. Purchase Order</a></td>
      </tr>
      <tr>
        <td align="right"><a class="navText" id="link2" width="300" style="cursor:pointer;" onMouseOver="MM_showMenu(window.mm_menu_0814123211_6,50,0,null,'link2');" onMouseOut="MM_startTimeout();"> C3. Laporan &laquo;</a></td>
        <td align="left"><a class="navText" href="sop.php">&raquo; C4. Master SOP</a></td>
      </tr>
      <tr>
        <td align="right">&nbsp;<!--a class="navText" href="#"> C5. Laporan &laquo;</a--></td>
        <td align="left">&nbsp;<!--a class="navText" href="list_hps_obat.php">&raquo; C6. Penghapusan Obat </a--></td>
      </tr>
      <tr>
        <td width="300">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
<table width="100%" border="0">
  <tr>
    <td width="100%" style="float:left; padding-left:10px; font:12px arial; color:#FFFF00"><i> Tanggal: <?php echo $wkttgl; ?></i>
	&nbsp;&nbsp;&nbsp;&nbsp;Login: <b><?=strtoupper($username); ?></b>
	&nbsp;&nbsp;&nbsp;&nbsp;
	Unit: <b><?php if(getNUnit($tipe,$iduser)==1){ echo strtoupper($namaunit); } else { ?><select onChange="location='?f=<?php echo $file; ?>&zxcvunit='+this.value">
    	<?php
		while($rwUnit=mysqli_fetch_array($qUnit)){
		?>
    	<option value="<?php echo $rwUnit['UNIT_ID']; ?>" <?php if($rwUnit['UNIT_ID']==$idunit) echo "selected"; ?>><?php echo $rwUnit['UNIT_NAME']; ?></option>
        <?php
		}
		?>
    </select><?php } ?></b>
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
<table width="1000" border="0" cellspacing="0" cellpadding="0" class="tblbody">
<tr align="center" valign="top">
      <!--td width="5" height="450">&nbsp;</td-->
	<td align="center" height="450"><?php if ($file!="" && cekAccessUnit($tipe,$iduser)) include($file); else echo "&nbsp;"; ?></td>
</tr>
</table>
</div>
<script language="JavaScript" src="../theme/js/mm_menu.js"></script>
<script language="JavaScript" src="../theme/js/dropdown.js"></script>
<script language="JavaScript1.2">mmLoadMenus();</script>
</body>
</html>
