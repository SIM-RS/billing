<table width="850" border="0" cellpadding="0" cellspacing="1" align="center">
	<tr>
		<td width="5%">&nbsp;</td>
		<td width="20%">&nbsp;</td>
		<td width="40%">&nbsp;</td>
		<td width="30%">&nbsp;</td>
		<td width="5%">&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td align="right">Kode&nbsp;</td>
		<td>&nbsp;<input id="txtKodeg" name="txtKodeg" type="text" size="16" class="txtinput">		</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	<tr>
		<td>&nbsp;</td>
		<td align="right">Nama&nbsp;</td>
		<td>&nbsp;<input id="txtNm" name="txtNm" type="text" size="32" class="txtinput">		</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td align="right">Keterangan&nbsp;</td>
		<td colspan="2">&nbsp;<input id="txtKet" name="txtKet" size="50" class="txtinput">&nbsp;&nbsp;&nbsp;<input type="checkbox" id="chAktif" name="chAktif" checked="checked">&nbsp;Aktif</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td align="center" height="28">
			<input type="hidden" id="id_group" name="id_group" />
			<input type="button" id="btnSimpanGroup" name="btnSimpanGroup" value="Tambah" onclick="simpan(this.value,this.id);" class="tblTambah"/>
			<input type="button" id="btnHapusGroup" name="btnHapusGroup" value="Hapus" onclick="hapus(this.id);" disabled="disabled" class="tblHapus"/>
			<input type="button" id="btnBatalGroup" name="btnBatalGroup" value="Batal" onclick="batal(this.id)" class="tblBatal"/></td>
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
		<td colspan="3">
			<div id="gridboxtab2" style="width:750px; height:350px; background-color:white; overflow:hidden;"></div>
			<div id="pagingtab2" style="width:750px;"></div></td>
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
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
</table>
