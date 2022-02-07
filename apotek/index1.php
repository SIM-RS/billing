<?php 
session_start();
session_destroy();
//$iunit='1';
?>
<html>
<head>
<title>SISTEM INFORMASI APOTIK <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="theme/apotik.css" type="text/css" />
</head>
<body>
<div align="center"> 
<?php include("header.php");?>
<table width="1000" border="0" cellspacing="0" cellpadding="0" class="tblbody">
 <tr>
    <td width="198" height="430" valign="top" class="bodykiri" align="center"></br>
	<form action="logproces.php" method="post">
        <table border="0" cellspacing="0" cellpadding="0" width="185" class="login">
        <tr>
			<td height="28" style="font-size:12px; font-weight:bold">&nbsp;Username</td>
			<td>:</td>
			<td><input name="username" type="text" size="10" maxlength="10"></td>
		</tr>
        <tr>
			<td height="28" style="font-size:12px; font-weight:bold">&nbsp;Password</td>
			<td>:</td>
			<td><input name="password" type="password" size="10" maxlength="10"></td>
		</tr>
        <tr valign="bottom">
			<td height="28"><div align="right"><img src="icon/login-welcome.gif" alt="unlock" width="48" height="48"></div></td>
			<td>&nbsp;</td>
			<td><input name="login" type="submit" value="Login"></td>
		</tr>
      </table>
	  </form>
	  <div></div>
	  </td>
	  
    <td width="50">&nbsp;</td>
    <td colspan="2" valign="top"><img src="images/mm_spacer.gif" alt="" width="305" height="8" border="0" /><br />
	&nbsp;<br />
	&nbsp;<br />
	<table border="0" cellspacing="0" cellpadding="0" width="374">
        <tr>
          <td width="374" class="pageName">Sistem Informasi Apotik </td>
		</tr>

		<tr>
          <td class="bodyText"><p>Sistem ini digunakan untuk membantu pencatatan 
              transaksi apotik di lingkungan Rumah Sakit Daerah Kota Tangerang.</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p></td>
        </tr>
      </table>
     <p>&nbsp;</p>
     <p><br />	  
    </p></td>
    <td width="72">&nbsp;</td>
  </tr>
</table>
</div> 
</body>
<script>
/*
function fOnLoad(){
	document.getElementById('dateformat').innerHTML='';
	document.forms[0].usr.focus();
}
function GoSubmit(){
	if (document.forms[0].usr.value=="" || document.forms[0].pwd.value==""){
		alert("Isikan Username dan Password dengan lengkap !");
		return false;
	}
}
*/
</script>
</html>