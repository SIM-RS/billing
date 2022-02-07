<?
if(isset($_REQUEST["err_aset"]))
{
	$err_aset=$_REQUEST["err_aset"];
	echo "<script>alert('$err_aset');</script>";
}
?>
<div id="popup_aset" class="popup" style="width:500px;display:none;">
    <div style="float:right; cursor:pointer" class="popup_closebox">
        <img alt="cancel" src="billing
		/icon/cancel.gif" height="16" width="16" align="absmiddle"/>Tutup</div>
    <br>

<fieldset>
<legend style="font:bold 12px tahoma; color: #003366;">Login Modul Inventory</legend>
<form action="aset/logproces.php" method="post" onSubmit="return GoSubmit2()">
<table width="366" border="0" style="color:#000000; font:bold 12px tahoma;">
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
	<input type="submit" id="btnLogin" name="btnLogin" value="Login" class="tombolx">
	<input type="reset" id="btnReset" name="btnReset" value="Reset" class="tombolx">	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
      </fieldset>

</div>
<script type="text/javascript">
    function GoSubmit2()
    {
        if (document.getElementById("txtUser").value=="" || document.getElementById("txtPass").value=="")
        {
            alert("Isikan Username dan Password dengan lengkap !");
            return false;
        }
    }
</script>