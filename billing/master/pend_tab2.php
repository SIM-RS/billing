<?php
session_start();
include("../sesi.php");
?>
<table width="800" border="0" cellspacing="1" cellpadding="0" align="center">
  <tr>
    <td width="40%">&nbsp;</td>
  	<td height="30" width="60%">&nbsp;</td>
  </tr>
  <tr>
  	<td align="right">Kode&nbsp;</td>
	<td>&nbsp;<input id="kodeKomp" name="kodeKomp" size="12"  class="txtinput" /></td>
  </tr>
  <tr>
    <td align="right">Komponen Tarif&nbsp;</td>
  	<td>&nbsp;<input id="txtkomp" name="txtkomp" size="24"  class="txtinput" /></td>
  </tr>
  <tr>
  	<td align="right">Tarif&nbsp;</td>
	<td>&nbsp;<input id="txttarif" name="txttarif" size="12"  class="txtinput" /></td>
  </tr>
  <tr>
  	<!-- <td align="right">Flag&nbsp;</td> -->
	<td>&nbsp;<input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="12" tabindex="3" value="<?php echo $flag; ?>"/></td>
  </tr>
  <tr>
  	<td align="right">Status&nbsp;</td>
	<td>&nbsp;<label><input type="checkbox" id="isAktifTarif" name="isAktifTarif"  class="txtinput" />Aktif</label></td>
  </tr>
  <tr>
    <td height="30" colspan="2" align="center">
		<input type="hidden" name="id_komp" id="id_komp" />
		<input type="button" id="btnSimpanTrf" name="btnSimpanTrf" value="Tambah" onclick="simpan(this.value,this.id,'kodeKomp');" class="tblTambah"/>
		<input type="button" id="btnHapusTrf" name="btnHapusTrf" value="Hapus" onclick="hapus(this.id);" disabled="disabled" class="tblHapus"/>
	<input type="button" id="btnBatalTrf" name="btnBatalTrf" value="Batal" onclick="batal(this.id)" class="tblBatal"/>	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  	<td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" colspan="2">
		<div id="gridboxtab2" style="width:750px; height:300px; background-color:white; overflow:hidden;"></div>
		<div id="pagingtab2" style="width:750px;"></div>	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
