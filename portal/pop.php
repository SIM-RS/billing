<div id="popup_apotek" class="popup" style="width:500px;display:none;">
    <div style="float:right; cursor:pointer" class="popup_closebox">
        <img alt="cancel" src="billing
		/icon/cancel.gif" height="16" width="16" align="absmiddle"/>Tutup</div>
    <br>
    <form id="form1" name="form1" action="apotek/logproces.php.php" method="post">
        <fieldset>
            <legend style="font:bold 12px tahoma; color: #003366;">Login Modul Apotek</legend>
<table border="0" cellspacing="0" cellpadding="0" width="461" style="font:bold 12px tahoma;">
            <tr> 
              <td width="86" height="28" style="font-size:12px; font-weight:bold">&nbsp;Username</td>
              <td width="8">:</td>
              <td width="141"><input name="username" type="text" size="20" maxlength="20" onKeyUp="KeyEvent(event,this)" style="border:1px solid #999999; padding:3px;
			  border-radius:3px;"></td>
            </tr>
            <tr> 
              <td height="28" style="font-size:12px; font-weight:bold">&nbsp;Password</td>
              <td>:</td>
              <td><input name="password" type="password" size="20" maxlength="20" onKeyUp="KeyEvent(event,this);" autocomplete="off" style="border:1px solid #999999; padding:3px;
			  border-radius:3px;"></td>
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
              <td><input name="login" type="button" value="Login" onClick="GoSubmit();" style="border:1px solid #FF6600; background:#FFCC33; padding:3px 4px; cursor:pointer; color:#000000; font:bold 12px tahoma;"></td>
            </tr>
        </table>
      </fieldset>
    </form>
</div>
<script>
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