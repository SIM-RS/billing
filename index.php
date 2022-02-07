<?php
session_start();

include 'include/functions.php';

// if(isset($_SESSION['user_id']) || $_SESSION['user_id'] != '') {
  if(isset($_SESSION['logon'])){
if($_SESSION['logon'] == 1){
    echo "<script>window.location='".getUrl('portal.php')."';</script>";
}
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Login Aplikasi SIMRS PHCM :.</title>
<link rel="shortcut icon" href="billing/icon/favicon.ico" />
<link rel="stylesheet" type="text/css" href="home.css" />
<!--<script src="include/jquery/jquery-1.4.1.js"></script>-->
<script type="text/javascript" src="./inc/js/validasi.js"></script>
<script type="text/javascript" src="include/jquery-1.7.2.js"></script>
<style>
input[type='text'],input[type='password']
{
	border:1px solid #669900; 
	padding:8px;  
	width:200px;
	border-radius:5px;
}
input[type='submit'],input[type='reset']
{
	background: #66CC00; 
	color:#FFFFFF; font:bold 12px tahoma; 
	padding:5px; 
	border:1px solid #FFFFFF;
	border-radius:3px;
	cursor:pointer;
}
</style>
</head>

<body onload="fokuskan()">
<div id="atas" style="text-align:center;">
  <table width="1080" border="0" align="center">
    <tr>
      <td width="108" rowspan="2"><img src="inc/images/logo.png" width="88" height="81" /></td>
      <td width="926" align="left"><span style="font:bold 25px Geneva, Arial, Helvetica, sans-serif"> SIM Rumah Sakit Prima Husada Cipta Medan </span></td>
    </tr>
    <tr>
      <td align="left"><span style="font:12px Verdana, Arial, Helvetica, sans-serif">Sistem Informasi Manajemen Rumah Sakit Prima Husada Cipta Medan<br />&nbsp; </span></td>
    </tr>
  </table>
</div>

<!--<div id="judul_aplikasi">Form Login Aplikasi </div>-->
<div id="kotak">
<div id="judul">Slide show &amp; login form </div>
<div id="konten" style="height:auto;">
<table width="949" border="0">
  <tr>
    <td width="537">
	<?php
	include "slide.php"; 
	?>	</td>
    <td width="402" valign="top">
	<div style=" background: #DC182C; width:250px; margin:auto; margin-top:40px; border:1px solid #E1647A;">
<form id="formlogin" name="formlogin" method="post" action="new_login.php" onsubmit="return validateForm()">
	<table width="250" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="301" height="30" style="background: url(inc/images/judul.png) repeat-x; padding-left:10px;">LOGIN</td>
  </tr>
  
  <tr>
    <td height="28" style="padding-left:10px; color:#FFFFFF;">Username</td>
    </tr>
  <tr>
    <td  style="padding-left:10px; color:#FFFFFF;"><input type="text" name="username" id="username" autocomplete="off"/></td>
    </tr>
  
  <tr>
    <td height="26" style="padding-left:10px; color:#FFFFFF;">Password</td>
    </tr>
  <tr>
    <td style="padding-left:10px; color:#FFFFFF;"><input class="txtinput" type="password" name="key" id="key"/></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td style="padding-left:10px; color:#FFFFFF;">
	<input type="submit" name="login" id="login" value="Login" />
    <input type="reset" name="reset" id="reset" value="Reset"/>	</td>
  </tr>
  <tr>
    <td style="padding-left:10px; color:#FFFFFF;">&nbsp;</td>
  </tr>
</table>
</form>
	</div>
	</td>
  </tr>
</table>
</div>


</div>



</div>
</body>
</html>
<script>
function fokuskan()
{
	$("#username").focus();
}
</script>