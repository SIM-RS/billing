<table width="900" border="0" cellspacing="1" cellpadding="0" align="center">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
    <td align="right">Nama Penjamin&nbsp;</td>
    <td>&nbsp;<input size="32" id="txtPenjamin" name="txtPenjamin" class="txtinput" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
    <td align="right">Alamat&nbsp;</td>
    <td>&nbsp;<input size="32" id="txtAlmt" name="txtAlmt" class="txtinput" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
    <td align="right">Telepon&nbsp;</td>
    <td>&nbsp;<input id="txtTlp" name="txtTlp" size="24" class="txtinput" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
    <td align="right">Fax&nbsp;</td>
    <td>&nbsp;<input id="txtFax" name="txtFax" size="24" class="txtinput" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
    <td align="right">Kontak&nbsp;</td>
    <td>&nbsp;<input id="txtKontak" name="txtKontak" size="32" class="txtinput" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
	<td>&nbsp;<input id="txtId" type="hidden" name="txtId" /></td>
    <td height="30">
		<input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="simpan(this.value);" class="tblTambah"/>
		<input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus(this.title);" disabled="disabled" class="tblHapus"/>
		<input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/>
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
	<td width="5%">&nbsp;</td>
    <td colspan="3">
		<div id="gridbox" style="width:900px; height:200px; background-color:white;"></div>
		<div id="paging" style="width:900px;"></div>	</td>
    <td width="5%">&nbsp;</td>
  </tr>  
 
  </table>
  