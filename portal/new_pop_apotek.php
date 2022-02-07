<?
if(isset($_REQUEST["err"]))
{
	$err=$_REQUEST["err"];
	echo "<script>alert('$err');</script>";
}
?>
<div id="popup_apotek" class="popup" style="width:500px;display:none;">
    <div style="float:right; cursor:pointer" class="popup_closebox">
        <img alt="cancel" src="billing
		/icon/cancel.gif" height="16" width="16" align="absmiddle"/>Tutup</div>
    <br>
    <form id="form1" name="form1" action="shiftproses.php" method="post">
        <fieldset>
            <legend style="font:bold 12px tahoma; color: #003366;">User Apotek Shift</legend>
			<table border="0" cellspacing="0" cellpadding="0" width="470" style="font:bold 12px tahoma;">
				<tr>
				  <td height="28" style="font-size:12px; font-weight:bold">&nbsp;Shift</td>
				  <td>:</td>
				  <td><select name="shift" id="shift" onKeyUp="KeyEvent(event,this);">
					  <option value="0">&nbsp;&nbsp;-</option>
					  <option value="1">Shift Pagi</option>
					  <option value="2">Shift Siang</option>
					  <option value="3">Shift Malam</option>
					</select></td>
				</tr>
				<tr valign="bottom"> 
				  <td height="28"><div align="right"></div></td>
				  <td>&nbsp;</td>
				  <td><input name="login" type="button" value="Login" onClick="GoSubmit();" class="tombolx"></td>
				</tr>
			</table>
		</fieldset>
    </form>
</div>
<script>
function GoSubmit()
{
	if (document.getElementById("shift").value=="0"){
		alert("Pilih Shift Terlebih Dahulu !");
		document.forms[0].shift.focus();
		return false;
	}
	document.getElementById("form1").submit();
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
			document.getElementById("form1").submit();
		}else if (par.name=="shift"){
			document.getElementById("form1").submit();
		}
	}
}
</script>