<?php
session_start();
include("../sesi.php");
?>
<table width="100%" height="100%" border="0" cellspacing="1" cellpadding="0" align="center" class="tabel">
	<tr>
    	<td height="30" colspan="2">&nbsp;</td>
  	</tr>
	<tr>
    	<td align="right" width="40%">NAMA SATUAN&nbsp;</td>
    	<td align="left" width="60%">&nbsp;<input id="satuan" name="satuan" size="32" class="txtinput" /></td>
  	</tr>
	  <tr>
    	<!-- <td align="right" width="40%">Flag&nbsp;</td> -->
    	<td align="left" width="60%">&nbsp;<input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="32" tabindex="3" value="<?php echo $flag; ?>"/></td>
  	</tr>
  	<tr>
		<td colspan="2">&nbsp;</td>
  	</tr>
	<tr>
		<td align="right">STATUS&nbsp;</td>
		<td>&nbsp;<label><input type="checkbox" id="aktifSatuan" name="aktifSatuan" class="txtinput" />Aktif</label></td>
	</tr>
	<tr height="30">
		<td colspan="2" align="center">
			<input type="hidden" name="idSatuan" id="idSatuan" />
			<input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="simpan(this.value,this.id,'satuan');" class="tblTambah"/>
			<input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus(this.id);" disabled="disabled" class="tblHapus"/>
			<input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal(this.id)" class="tblBatal"/>
		</td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
  	<tr>
    	<td colspan="2" align="center">
			<div id="gridboxtab1" style="width:750px; height:300px; background-color:white; overflow:hidden;"></div>
			<div id="pagingtab1" style="width:750px;"></div>		</td>
  	</tr>
  	<tr>
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
  	</tr>
</table>
