<?php 
session_start();
$iduser=$_SESSION["ses_iduser"];
if ($iduser==""){
	header("Location: ../index.php");
	exit();
}

$file=$_GET["f"];
if ((strpos($file,".php")<=0)&&($file!="")) $file .=".php";
?>
<html>
<head>
<title>Sistem Informasi Akuntansi</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<!--script src="../theme/js/noklik.js" type="text/javascript"></script-->
<link rel="stylesheet" href="../theme/simkeu.css" type="text/css" />
</head>
<body>
<div align="center">
<?php
$wktnow=gmdate('H:i:s',mktime(date('H')+7));
$wkttgl=gmdate('d/m/Y',mktime(date('H')+7));
$url=split("/",$_SERVER['REQUEST_URI']);
$imgpath="/".$url[1]."/images";
$iunit=$_SESSION['ses_usrname'];
?>
<style type="text/css">
<!--
.style1 {font-family: Verdana, Arial, Helvetica, sans-serif}
-->
</style>

<table width="1000" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="4"><img src="../images/kop.gif" width="1000" height="127" border="0" /></td>
  </tr>
  <tr class="H" >
  	  <td height="25"  id="dateformat">&nbsp;&nbsp;<?php echo $wkttgl; ?>&nbsp;&nbsp;User 
        &nbsp;&nbsp;&nbsp;&nbsp;:<?php echo $iunit; ?></td>
	  <td height="25" colspan="3" align="right" id="logout">&nbsp;&nbsp;</td>
  </tr>
</table>

<script>
document.getElementById("logout").innerHTML='<a class="a1" href="../index.php">Logout</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
</script>
<table width="1000" border="0" cellspacing="0" cellpadding="0" class="tblbody">
<tr align="center" valign="top">
    <td width="160" height="430" class="bodykiri"><?php include("menua.php");?></td>
	<td width="5">&nbsp;</td>
	<td align="left"><?php if ($file!="") include($file); else echo "&nbsp;"; ?></td>
</tr>
</table>
</div>
</body>
</html>
