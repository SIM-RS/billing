<form action="logproces.php" method="post" onSubmit="return GoSubmit()">
<div align="center" style="margin:auto; width:1000px; background: #C4C4FF; min-height:300px;">
<br />
<div style="width:370px; margin:auto; border:1px solid #006633; border-radius:5px; background: #6699CC">
<table width="366" border="0" style="color:#FFFFFF;">
  <tr>
    <td width="93">&nbsp;</td>
    <td width="263">&nbsp;</td>
  </tr>
  <tr>
    <td>Username</td>
    <td>: <input id="txtUser" name="txtUser" size="32" tabindex="0" style="border:1px solid #666666; padding:4px 3px ;"></td>
  </tr>
  <tr>
    <td>Password</td>
    <td>: <input id="txtPass" name="txtPass" size="32" type="password" style="border:1px solid #666666; padding:4px 3px ;"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;
	<input type="submit" id="btnLogin" name="btnLogin" value="Login" style="border:1px solid #FFCC33; background: #FFFF33; padding:3px 4px; cursor:pointer;">
	<input type="reset" id="btnReset" name="btnReset" value="Reset" style="border:1px solid #FFCC33; background: #FFFF33; padding:3px 4px; cursor:pointer;">	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
</div>
</form>
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td bgcolor="#6699CC" height="28" align="center" style="color:#FFFFFF; font-size:15px;">.: Jangan lupa bila keluar tekan <span style="color:#FFFF99; font-size:16px;">LOGOUT</span> :.</td>
    </tr>
    <tr>
    <td bgcolor="#FFFFFF" height="20"></td>
    </tr>
</table>
<script type="text/javascript">
    function GoSubmit()
    {
        if (document.forms[0].txtUser.value=="" || document.forms[0].txtPass.value=="")
        {
            alert("Isikan Username dan Password dengan lengkap !");
            return false;
        }
    }
</script>
