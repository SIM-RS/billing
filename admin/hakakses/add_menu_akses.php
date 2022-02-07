
<form name="form1" method="post" action="settingaplikasi_utils.php" target="_SELF">
<input id="act" name="act" value="tambah" type="hidden"/>
<div  id="Table_01">

<table width="925" border="0" cellspacing="0" cellpadding="2" align="center">  
	<tr>
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>
		<td width="5%">&nbsp;</td>
		<td width="10%" align="right" class="font">Kode Induk</td>
		<td width="45%">
			<input id="txtParentKode"  name="txtParentKode" type="text" size="5" maxlength="20" style="text-align:center" value="" readonly="true" class="txtinput2">
            <img alt="tree" title='daftar menu' width=""  style="cursor:pointer" border=0 src="../images/view_tree.gif" align="absmiddle" onClick="forOpenTree();" />             
			<input type="hidden" id="txtLevel" title="level" name="txtLevel" size="5" />
			<input type="hidden" id="txtParentId" title="parent id" name="txtParentId" size="5" />
			<input type="hidden" id="txtParentLvl" name="txtParentLvl" size="6" />
		</td>
		<td width="20%">&nbsp;</td>
		<td width="5%">&nbsp;</td>
	</tr>  
	<tr>
		<td>&nbsp;</td>
		<td align="right" class="font">Kode</td>
		<td class="font">
			<input id="txtId" name="txtId" type="hidden" />
			<input id="txtKode" name="txtKode" size="10"  class="txtinput2"/>
			&nbsp;&nbsp;Nama&nbsp;<input id="txtNama" name="txtNama" size="22"  class="txtinput2"/>
		</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
		<tr>
		<td>&nbsp;</td>
		<td align="right" class="font">Url</td>
		<td>
			<input id="txtUrl" name="txtUrl" size="45" class="txtinput2"/>
		</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>  
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>
			<!--<input type="submit" id="btnSimpanSetting" name="btnSimpanSetting" value="Tambah"/>
			<input type="button" id="btnHapusSetting" name="btnHapusSetting" value="Hapus" onclick="delet();" disabled="disabled"/>
			<input type="button" id="btnBatalSetting" name="btnBatalSetting" value="Batal" onclick="batalSetting()"/>-->
            
            <button type="submit" id="btnSimpanSetting" name="btnSimpanSetting" value="Tambah" style="cursor:pointer"><img src="../icon/add.gif" align="absmiddle" width="20" />&nbsp;Tambah</button>&nbsp;&nbsp;
			<button type="button" id="btnBatalSetting" name="btnBatalSetting" value="Batal" onclick="batalSetting()" style="cursor:pointer"><img src="../icon/back.png" align="absmiddle" width="20" />&nbsp;Batal</button>&nbsp;&nbsp;
			<button type="button" id="btnHapusSetting" name="btnHapusSetting" value="Hapus" onclick="delet()" disabled="disabled" style="cursor:pointer"><img src="../icon/delete2.gif" align="absmiddle" width="20" />&nbsp;Hapus</button>
			<span id="spanProc"></span>
		</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td align="left" colspan="3">	
        <div style="border-color:#96CADE; height:350px">	
			<?php
			include('settingaplikasi_tree.php');
			?>
         </div>
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="5">&nbsp;</td>
	</tr>
</table>
</div>
</form>
<script>
function forOpenTree(){	
	var qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
	OpenWnd('tree.php?'+qstr_ma_sak,800,500,'msma',true);
}

function delet(){
	//alert('masuk');
	document.getElementById('act').value = 'hapus';
	document.forms[0].submit();
}
</script>