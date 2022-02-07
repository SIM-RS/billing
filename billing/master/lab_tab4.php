<?php
//include("../sesi.php");
include("../sesi.php");
?>
<?php
//session_start();
include '../koneksi/konek.php';
?><table width="800" border="0" cellspacing="1" cellpadding="0" align="center">
  <tr>
    <td width="40%">&nbsp;</td>
  	<td height="30" width="70%">&nbsp;</td>
  </tr>
  <tr>
  	<td align="right">Kelompok&nbsp;</td>
	<td>&nbsp;<select id="kelIdlab" class="txtinput" onchange="fill()">
	</select></td>
  </tr>
  <tr>
  	<td align="right">Nama Pemeriksaan&nbsp;</td>
	<td>&nbsp;<input id="txtTindPem" name="txtTindPem" size="50" class="txtinput" />
    &nbsp;&nbsp;<input type="checkbox" id="chkAda" name="chkAda" value="1" /> Ada di RSUD
    </td>
  </tr>
  <tr>
  	<!-- <td align="right">Flag&nbsp;</td> -->
	<td>&nbsp;<input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="40" tabindex="3" value="<?php echo $flag; ?>"/>
	</select></td>
  </tr>
  <tr>
    <td height="30" colspan="2" align="center">
		<input type="hidden" name="idPem" id="idPem" />
		<input type="button" id="btnSimpanPem" name="btnSimpanPem" value="Tambah" onclick="simpan(this.value,this.id,'kelIdlab');" class="tblTambah"/>
		<input type="button" id="btnHapusPem" name="btnHapusPem" value="Hapus" onclick="hapus(this.id);" disabled="disabled" class="tblHapus"/>
	<input type="button" id="btnBatalPem" name="btnBatalPem" value="Batal" onclick="batal(this.id)" class="tblBatal"/>	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  	<td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" colspan="2">
		<div id="gridboxtab4" style="width:750px; height:300px; background-color:white; overflow:hidden;"></div>
		<div id="pagingtab4" style="width:750px;"></div>	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
