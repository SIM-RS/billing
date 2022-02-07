<?php
	
	include("../sesi.php");

?>
<table width="725" border="0" cellspacing="3" cellpadding="3" align="center">
  <tr>
  	<td height="30"  colspan="3">&nbsp;</td>
  </tr>
  <!--tr>
    <td align="right">Stref</td>
    <td>
	<input type="text" id="txtKode" name="txtKode" size="10" class="txtinput"/>
    </td>
  </tr-->
  <tr>
    <td align="right">Spesialisasi:</td>
    <td>
	<input type="hidden" id="txtId" name="txtId" size="10"/>
	<input type="text" id="txtSpe" name="txtSpe" size="45" class="txtinput"/>	
    </td>    
  </tr>
  <!-- <tr> -->
    <!-- <td align="right">Flag :&nbsp;</td> -->
    <!-- <td colspan="3"> -->
    <input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="45" tabindex="3" value="<?php echo $flag; ?>"/>
    <!-- </td> -->
   <!-- </tr> -->
  <tr>
    <td align="right">Status</td>
	<td>
		<label><input type="checkbox" id="chAktif" name="chAktif" value="1" checked="checked">aktif</label>
	</td>
  </tr>
  <tr>
    <td></td>
    <td>
		<input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="simpan(this.value,'tab1');" class="tblTambah"/>
		<input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus('tab1');" disabled="disabled" class="tblHapus"/>
		<input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal('tab1')" class="tblBatal"/>
	</td>
  </tr>
  <tr>
    <td align="center" colspan="2">
		<div id="gridboxtab1" style="width:750px; height:200px; background-color:white; overflow:hidden;"></div>
		<div id="pagingtab1" style="width:750px;"></div>
	</td>
  </tr>  
</table>