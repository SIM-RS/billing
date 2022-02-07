<?php
session_start();
include("../sesi.php");
?>
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
  	<td height="20">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">Jenis Makanan :&nbsp;<input type="text" id="txtJnsMak" name="txtJnsMak" size="30" class="txtinput"/>
    <input type="hidden" id="txtIdJnsMak" name="txtIdJnsMak" size="30" class="txtinput"/>
    <label><input type="checkbox" id="chkAktifJnsMak" name="chkAktifJnsMak" class="txtinput" checked="checked"/>Aktif</label>
    </td>
  </tr> 
  <!-- <tr>
    <td align="center">Flag :&nbsp; -->
    <input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="30" tabindex="3" value="<?php echo
$flag; ?>"/>
<!-- </td>
  </tr>  -->
  <tr>
  	<td height="30" align="center">
		<input type="button" id="btnSimpanJnsMak" name="btnSimpanJnsMak" value="Tambah" onclick="simpan(this.value,this.id);" class="tblTambah"/>
		<input type="button" id="btnHapusJnsMak" name="btnHapusJnsMak" value="Hapus" onclick="hapus(this.value,this.id);" disabled="disabled" class="tblHapus"/>
		<input type="button" id="btnBatalJnsMak" name="btnBatalJnsMak" value="Batal" onclick="batal()" class="tblBatal"/>
	</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">
		<div id="gridboxtab2" style="width:600px; height:300px; background-color:white; overflow:hidden;"></div>
		<div id="pagingtab2" style="width:600px;"></div>
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>