<?
if(isset($_REQUEST["err_keuangan"]))
{
	$err_keuangan=$_REQUEST["err_keuangan"];
	echo "<script>alert('$err_keuangan');</script>";
}
?>
<div id="popup_akuntansi" class="popup" style="width:500px;display:none;">
    <div style="float:right; cursor:pointer" class="popup_closebox">
        <img alt="cancel" src="billing
		/icon/cancel.gif" height="16" width="16" align="absmiddle"/>Tutup</div>
    <br>
        <fieldset>
            <legend style="font:bold 12px tahoma; color: #003366;">Login Modul Akuntansi </legend>
           <form action="akuntansi/logproces.php" method="post" id="frmLogin" name="login" onSubmit="return GoSubmit4();">
<table width="354" border="0" style="margin:20px; font:bold 12px tahoma; color:#000000;">
	<tr>
		<td width="115">Login</td>
		<td width="227"><input name="username" id="username_ak" type="text" class="login_text" size="30"  />
<!-- onKeyUp="KeyEvent(event,this);"-->		</td>
	</tr>
	<tr>
		<td>Password</td>
		<td><input name="password" id="password_ak" type="password" class="login_text" size="30" />
<!-- onKeyUp="KeyEvent(event,this);"-->		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td align="left">
			<input type="submit" name="Submit" value="Login" class="login_btn tombolx" />		</td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td align="left">&nbsp;</td>
    </tr>
</table>
</form>
      </fieldset>
</div>
<script>
function GoSubmit4()
{
	if (document.getElementById("username_ak").value==""){
		alert("Isikan Username Anda Terlebih Dahulu !");
		document.getElementById("username_ak").focus();
		return false;
	}
	else if (document.getElementById("password_ak").value==""){
		alert("Isikan Password Anda Terlebih Dahulu !");
		document.getElementById("password").focus();
		return false;
	}
	else
	{
		return true;
	}
}
</script>