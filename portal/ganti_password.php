<?
if(isset($_REQUEST["err"]))
{
	$err=$_REQUEST["err"];
	echo "<script>alert('$err');</script>";
}
?>
<div id="popup_gpassword" class="popup" style="width:500px;display:none;">
    <div style="float:right; cursor:pointer" class="popup_closebox">
        <img alt="cancel" src="billing
		/icon/cancel.gif" height="16" width="16" align="absmiddle"/>Tutup</div>
    <br>
    <form id="formgpass" name="formgpass" action="gantipass.php" method="post">
        <fieldset>
            <legend style="font:bold 12px tahoma; color: #003366;">Ganti Password</legend>
			<table border="0" cellspacing="0" cellpadding="0" width="470" style="font:bold 12px tahoma;">
				<tr> 
				  <td height="28" style="font-size:12px; font-weight:bold">&nbsp;Password Lama</td>
				  <td>:</td>
				  <td><input name="old" type="password" id="old"  size="20" maxlength="20" onKeyUp="KeyEventPass(event,this);" autocomplete="off" style="border:1px solid #999999; padding:3px; border-radius:1px;"></td>
				</tr>
				<tr> 
				  <td height="28" style="font-size:12px; font-weight:bold">&nbsp;Password Baru</td>
				  <td>:</td>
				  <td><input name="new" type="password" id="new"  size="20" maxlength="20" onKeyUp="KeyEventPass(event,this);" autocomplete="off" style="border:1px solid #999999; padding:3px; border-radius:1px;"></td>
				</tr>
				<tr valign="bottom"> 
				  <td height="28"><div align="right"></div></td>
				  <td>&nbsp;</td>
				  <td><input name="login" type="button" value="Submit" onClick="submitpass();" class="tombolx"></td>
				</tr>
			</table>
		</fieldset>
    </form>
</div>
<script>
function submitpass()
{
	if (document.getElementById("old").value==""){
		alert("Isikan Password Lama!");
		document.forms[0].shift.focus();
		return false;
	} else if(document.getElementById("new").value == ""){
		alert("Isikan Password Baru!");
		document.forms[0].shift.focus();
		return false;
	}
	document.getElementById("formgpass").submit();
}

function KeyEventPass(e,par){
var key;
	if(window.event) {
	  key = window.event.keyCode; 
	}
	else if(e.which) {
	  key = e.which;
	}
	//alert(key);
	if (key==13){
		if ((par.name=="old")&&(par.value!="")){
			document.forms[0].password.focus();
		}else if (par.name=="new" && par.value != ""){
			document.getElementById("formgpass").submit();
		} else {
			alert("Silahkan Lengkapi form isian!");
		}
	}
}
</script>