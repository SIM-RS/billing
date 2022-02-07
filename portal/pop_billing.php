<?
if(isset($_REQUEST["err_billing"]))
{
	$err_billing=$_REQUEST["err_billing"];
	echo "<script>alert('$err_billing');</script>";
}
?>
<div id="popup_billing" class="popup" style="width:500px;display:none;">
    <div style="float:right; cursor:pointer" class="popup_closebox">
        <img alt="cancel" src="billing
		/icon/cancel.gif" height="16" width="16" align="absmiddle"/>Tutup</div>
    <br>
        <fieldset>
            <legend style="font:bold 12px tahoma; color: #003366;">Login Modul YanMed</legend>
<form id="formLogin" action="billing/login_proc.php" method="post" onSubmit="return cekLogin();">
<table width="356" height="120" border="0" cellpadding="2" cellspacing="0" style="font:bold 12px tahoma; color:#000000; background:url(images/login.png) no-repeat;">

  <tr>
    <td width="9">&nbsp;</td>
	<td width="102" height="27">Username</td>
	<td width="233">: 
	  <input class="txtinputan" type="text" tabindex="1" size="20" id="txtUser_billing" name="txtUser_billing" value="" onFocus="if(this.value == 'User ID') this.value='';" onBlur="if(this.value=='') this.value = 'User ID'" style="padding:3px;" /></td>
    </tr>
  <tr>
    <td width="9">&nbsp;</td>
	<td width="102" height="27">Password</td>
	<td>: 
	  <input class="txtinputan" tabindex="2" type="password" size="20" id="txtPass_billing" name="txtPass_billing" value=""  style="padding:3px;"/></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
	<td height="37">&nbsp;</td>
	<td>&nbsp; <input class="btninputan" tabindex="3" type="submit" value="Login" class="tombolx" /></td>
    </tr>
</table>
</form>
      </fieldset>
    
</div>
<script>
function cekLogin(){	
    if(document.getElementById('txtUser_billing').value=='')
	{
		document.getElementById('txtUser_billing').focus();
	  	alert('Silakan isi username!');
	  	return false;
    }
	else if(document.getElementById('txtPass_billing').value=='')
	{
		document.getElementById('txtPass_billing').focus();
	  	alert('Silakan isi password!');
	  	return false;
    }
    else{
	  return true;
    }
}
</script>