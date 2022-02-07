<?php
session_start();
include("../sesi.php");
?>
<table width="800" border="0" cellspacing="1" cellpadding="0" align="center">
	<tr>
    	<td height="30" colspan="2">&nbsp;</td>
  	</tr>
	<tr>
		<td align="right">Kode&nbsp;</td>
		<td>&nbsp;<input id="kode" name="kode" size="12" class="txtinput" /></td>
	</tr>
	<tr>
    	<td align="right" width="40%">Kelas Layanan&nbsp;</td>
    	<td align="left" width="60%">&nbsp;<input id="kls" name="kls" size="32" class="txtinput" /></td>
  	</tr>
	  <tr>
    	<!-- <td align="right" width="40%">Flag&nbsp;</td> -->
    	<td align="left" width="60%">&nbsp;<input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="32" tabindex="3" value="<?php echo $flag; ?>"/></td>
  	</tr>

  	<tr>
		<td colspan="2">&nbsp;</td>
    	<!--td align="right">Jenjang&nbsp;</td>
    	<td>&nbsp;<select id="jenjang" name="jenjang">
				<option></option>
				<option>1</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
				<option>5</option>
				<option>6</option>
				<option>7</option>
				<option>8</option>
				<option>9</option>
				<option>10</option>
			</select></td-->
  	</tr>
	<tr>
		<td align="right">Status&nbsp;</td>
		<td>&nbsp;<label><input type="checkbox" id="isAktifKls" name="isAktifKls" class="txtinput" />Aktif</label></td>
	</tr>
	<tr height="30">
		<td colspan="2" align="center">
			<input type="hidden" name="id_kls" id="id_kls" />
			<input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="simpan(this.value,this.id,'kode');" class="tblTambah"/>
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
