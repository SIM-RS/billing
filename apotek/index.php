<?php 
//session_start();
//session_destroy();
//$iunit='1';
$err=$_REQUEST["err"];
?>
<html>
<head>
<title>SISTEM INFORMASI APOTIK</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="theme/apotik.css" type="text/css" />
</head>
<body onLoad="fOnLoad('<?php echo $err; ?>');">
<div align="center"> 
<?php include("header.php");?>
<table width="1000" border="0" cellspacing="0" cellpadding="0" class="tblbody">
 <tr>
    <td width="261" height="500" valign="top" class="bodykiri" align="center"></br>
	<form action="logproces.php" method="post">
          <table border="0" cellspacing="0" cellpadding="0" width="241" class="login">
            <tr> 
              <td width="86" height="28" style="font-size:12px; font-weight:bold">&nbsp;Username</td>
              <td width="8">:</td>
              <td width="141"><input name="username" type="text" size="20" maxlength="20" onKeyUp="KeyEvent(event,this)" style="border:1px solid #999999; padding:3px;
			  border-radius:5px;"></td>
            </tr>
            <tr> 
              <td height="28" style="font-size:12px; font-weight:bold">&nbsp;Password</td>
              <td>:</td>
              <td><input name="password" type="password" size="20" maxlength="20" onKeyUp="KeyEvent(event,this);" autocomplete="off" style="border:1px solid #999999; padding:3px;
			  border-radius:5px;"></td>
            </tr>
            <tr>
              <td height="28" style="font-size:12px; font-weight:bold">&nbsp;Shift</td>
              <td>:</td>
              <td><select name="shift" id="shift" onKeyUp="KeyEvent(event,this);">
                  <option value="0">&nbsp;&nbsp;-</option>
                  <option value="1">Shift 1</option>
                  <option value="2">Shift 2</option>
                  <option value="3">Shift 3</option>
                </select></td>
            </tr>
            <tr valign="bottom"> 
              <td height="28"><div align="right"></div></td>
              <td>&nbsp;</td>
              <td><input name="login" type="button" value="Login" onClick="GoSubmit();" style="border:1px solid #6666CC; background:#3366FF; padding:3px 4px; cursor:pointer; color:#000000; font:bold 12px tahoma;"></td>
            </tr>
          </table>
	  </form>
	  <div></div>
	  </td>
	  
    <td width="12">&nbsp;</td>
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
            <p><a class="navText" href="petunjuk.doc" style="color:#0066FF; font-weight:bold">&raquo; Petunjuk Penggunaan</a> </p>
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
function fOnLoad(pesan){
	document.forms[0].username.focus();
	if (pesan!="") alert(pesan);
}

function GoSubmit(){
	if (document.forms[0].username.value==""){
		alert("Isikan Username Anda Terlebih Dahulu !");
		document.forms[0].username.focus();
		return false;
	}
	if (document.forms[0].password.value==""){
		alert("Isikan Password Anda Terlebih Dahulu !");
		document.forms[0].password.focus();
		return false;
	}
	document.forms[0].submit();
}

function KeyEvent(e,par){
var key;
	if(window.event) {
	  key = window.event.keyCode; 
	}
	else if(e.which) {
	  key = e.which;
	}
	//alert(key);
	if (key==13){
		if ((par.name=="username")&&(par.value!="")){
			document.forms[0].password.focus();
		}else if (par.name=="password"){
			document.forms[0].submit();
		}else if (par.name=="shift"){
			document.forms[0].submit();
		}
	}
}
</script>
</html>