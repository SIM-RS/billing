
<?php
session_start();
include("../sesi.php");
?>
<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
  	<td height="20" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" width="30%">Jenis Makanan : </td>
	<td width="70%"><select id="cmbJnsMak" name="cmbJnsMak" class="txtinput"></select></td>
  </tr>
  <tr>
    <td align="right">Jenis Diet : </td>
	<td><input id="txtJnsDiet" name="txtJnsDiet" size="24" class="txtinput"/>
	<input type="hidden" id="txtIdJnsDiet" name="txtIdJnsDiet" /></td>
  </tr>
  <!-- <tr>
    <td align="right">Flag : </td>
	<td> -->
  <input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="24" tabindex="3" value="<?php echo
$flag; ?>"/>
<!-- </td>
  </tr> -->
   <tr>
	<td>&nbsp;</td>
  	<td align="left">
		<input type="button" id="btnSimpanJnsDiet" name="btnSimpanJnsDiet" value="Tambah" onclick="simpan(this.value,this.id);" class="tblTambah"/>
		<input type="button" id="btnHapusJnsDiet" name="btnHapusJnsDiet" value="Hapus" onclick="hapus(this.value,this.id);" disabled="disabled" class="tblHapus"/>
		<input type="button" id="btnBatalJnsDiet" name="btnBatalJnsDiet" value="Batal" onclick="batal()" class="tblBatal"/>
	</td>
  </tr>
  <tr>
  	<td height="20" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center">
		<div id="gridboxtab3" style="width:500px; height:300px; background-color:white; overflow:hidden;"></div>
		<div id="pagingtab3" style="width:500px;"></div>				
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>  
</table>
