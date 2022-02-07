<?php
//include("../sesi.php");
?>
<?php
session_start();
include("../sesi.php");
?>

<?php
//session_start();
?><table width="800" border="0" cellspacing="1" cellpadding="0" align="center">
	<tr>
    	<td height="30" colspan="2">&nbsp;</td>
  	</tr>
	<tr>
    	<td align="right" width="40%">INDUK&nbsp;</td>
    	<td align="left" width="60%">&nbsp;<input id="kode" name="kode" size="15" readonly="readonly" class="txtinput" />&nbsp;
		<input type="button" id="btntree2" name="btntree2" value="...." onclick="upKode()" class=""/></td>
  	</tr>
	<tr>
    	<td align="right" width="40%">KODE&nbsp;</td>
    	<td align="left" width="60%">&nbsp;<input id="kode_kel" name="kode_kel" size="15" class="txtinput" />&nbsp;</td>
  	</tr>
	<form name="form1" id="form1">
	<tr>
    	<td align="right" width="40%">NAMA KELOMPOK&nbsp;</td>
    	<td align="left" width="60%">&nbsp;<input id="kel" name="kel" size="32" class="txtinput" /></td>
  	</tr>
	  <tr>
    	<!-- <td align="right" width="40%">FLAG&nbsp;</td> -->
    	<td align="left" width="60%">&nbsp;<input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="32" tabindex="3" value="<?php echo $flag; ?>"/></td>
  	</tr>
  	<tr>
		<td colspan="2">&nbsp;</td>
  	</tr>
	<tr height="30">
		<td colspan="2" align="center">
			<input type="hidden" name="idKel" id="idKel" />
			<input type="hidden" name="level" id="level" value="0" />
			<input type="hidden" name="parent" id="parent" />
			<input type="button" id="btnSimpanKel" name="btnSimpanKel" value="Tambah" onclick="simpan(this.value,this.id,'kel');" class="tblTambah"/>
			<input type="button" id="btnHapusKel" name="btnHapusKel" value="Hapus" onclick="hapus(this.id);" disabled="disabled" class="tblHapus"/>
			<input type="button" id="btnBatalKel" name="btnBatalKel" value="Batal" onclick="batal(this.id)" class="tblBatal"/>
		</td>
	</tr>
	</form>
	<tr>
		<td colspan="2" align="right" style="padding-right:17px">&nbsp;<input type="button" id="btntree" name="btntree" value="View Tree" onclick="tree12(this,this.id)"/>&nbsp;</td>
	</tr>
  	<tr>
    	<td colspan="2" align="center">
            <div id="tree" style="display:none"><?php include('kelLab_tree_ajax.php');?> </div>
			<div id="gridboxtab3" style="width:750px; height:300px; background-color:white; overflow:hidden;"></div>
			<div id="pagingtab3" style="width:750px;"></div>
        </td>
  	</tr>
  	<tr>
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
  	</tr>
</table>
