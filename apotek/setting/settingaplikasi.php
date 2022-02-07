<div>
<!--form name="form1" method="post" action="" target="_SELF">
<input name="act" id="act" type="hidden" value="tambah"-->
<table width="925" border="0" cellspacing="0" cellpadding="2" align="center">  
	<tr>
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>
		<td width="5%">&nbsp;</td>
		<td width="10%" align="right">Kode Induk</td>
		<td width="45%">
			<input id="txtParentKode"  name="txtParentKode" type="text" size="20" maxlength="20" style="text-align:center" value="" readonly="true" class="txtcenter"> 
  			<input type="button" class="btninput" id="btnParent" name="btnParent" value="..." title="Pilih Induk" onClick="forOpenTree();">             
			<input type="hidden" id="txtLevel" title="level" name="txtLevel" size="5" />
			<input type="hidden" id="txtParentId" title="parent id" name="txtParentId" size="5" />
			<input type="hidden" id="txtParentLvl" name="txtParentLvl" size="6" />
		</td>
		<td width="20%">&nbsp;</td>
		<td width="5%">&nbsp;</td>
	</tr>  
	<tr>
		<td>&nbsp;</td>
		<td align="right">Kode</td>
		<td>
			<input id="txtId" name="txtId" type="hidden" />
			<input id="txtKode" name="txtKode" size="10"  class="txtinput"/>
			&nbsp;Nama&nbsp;<input id="txtNama" name="txtNama" size="20"  class="txtinput"/>
		</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
		<tr>
		<td>&nbsp;</td>
		<td align="right">Url</td>
		<td>
			<input id="txtUrl" name="txtUrl" size="40"  class="txtinput"/>
		</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>  
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>
			<input type="button" id="btnSimpanSetting" name="btnSimpanSetting" value="Tambah" onclick="forSimpan();" class="tblTambah"/>
			<input type="button" id="btnHapusSetting" name="btnHapusSetting" value="Hapus" onclick="forHapus();" disabled="disabled" class="tblHapus"/>
			<input type="button" id="btnBatalSetting" name="btnBatalSetting" value="Batal" onclick="batalSetting()" class="tblBatal"/>
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
		<td align="left" colspan="3"  id="divtab1">		
			<?php
			include('settingaplikasi_tree.php');
			?>
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="5">&nbsp;</td>
	</tr>
</table>
<!--/form-->

</div>