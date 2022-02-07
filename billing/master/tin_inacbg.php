<?php
session_start();
include("../sesi.php");
?>
<table width="100%" height="100%" border="0" cellspacing="1" cellpadding="0" align="center" class="tabel">
	<tr>
    	<td height="30" colspan="2">&nbsp;</td>
  	</tr>
    <tr>
    	<td align="right" width="40%">Induk&nbsp;</td>
    	<td align="left" width="60%">&nbsp;<input id="par" name="par" size="32" class="txtinput" disabled="disabled" /><input type="button"  class="btninput" value="..." title="Pilih Induk" onClick="OpenWnd('inacbg_icd9cm1.php?par='+document.getElementById('txtICD9cm').value,850,550,'msma',true)"></td>
  	</tr>
    <tr>
    	<td align="right" width="40%">Kode&nbsp;</td>
    	<td align="left" width="60%">&nbsp;<input id="code" name="code" size="32" class="txtinput"/></td>
  	</tr>
    <tr>
    	<td align="right" width="40%">Nama Tindakan&nbsp;</td>
    	<td align="left" width="60%">&nbsp;<input id="nama" name="nama" size="32" class="txtinput"/></td>
  	</tr>
		<!-- <tr>
    	<td align="right" width="40%">Flag&nbsp;</td>
    	<td align="left" width="60%">&nbsp;<input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="32"
				tabindex="3" value="<?php echo $flag; ?>"/></td>
  	</tr> -->
	<!--<tr>
    	<td height="30" colspan="4">&nbsp;</td>
  	</tr>
    <tr>
    	<td align="right" width="40%">PARENT&nbsp;</td>
    	<td align="left" width="60%">&nbsp;<input id="par" name="par" size="32" class="txtinput" disabled="disabled" /><input type="button"  class="btninput" value="..." title="Pilih Induk" onClick="OpenWnd('inacbg_icd9cm1.php?par='+document.getElementById('txtICD9cm').value,850,550,'msma',true)"></td>
        <td align="right" width="40%" colspan="2">&nbsp;</td>
  	</tr>
	<tr>
    	<td align="right" width="40%">LAT&nbsp;</td>
    	<td align="left" width="60%">&nbsp;<input id="lat" name="lat" size="32" class="txtinput" /></td>
        <td align="right" width="40%">TS&nbsp;</td>
    	<td align="left" width="60%">&nbsp;<input id="ts" name="ts" size="32" class="txtinput" /></td>
  	</tr>
    <!--<tr>
    	<td align="right" width="40%">TS&nbsp;</td>
    	<td align="left" width="60%">&nbsp;<input id="ts" name="ts" size="32" class="txtinput" /></td>
  	</tr>-->
   <!-- <tr>
    	<td align="right" width="40%">LUI&nbsp;</td>
    	<td align="left" width="60%">&nbsp;<input id="lui" name="lui" size="32" class="txtinput" /></td>
        <td align="right" width="40%">STT&nbsp;</td>
    	<td align="left" width="60%">&nbsp;<input id="stt" name="stt" size="32" class="txtinput" /></td>
  	</tr>-->
    <!--<tr>
    	<td align="right" width="40%">STT&nbsp;</td>
    	<td align="left" width="60%">&nbsp;<input id="stt" name="stt" size="32" class="txtinput" /></td>
  	</tr>-->
    <!--<tr>
    	<td align="right" width="40%">SUI&nbsp;</td>
    	<td align="left" width="60%">&nbsp;<input id="sui" name="sui" size="32" class="txtinput" /></td>
        <td align="right" width="40%">ISPREF&nbsp;</td>
    	<td align="left" width="60%">&nbsp;<input type="checkbox" id="ispref" name="ispref" class="txtinput" checked="checked" /></td>
  	</tr>-->
    <!--<tr>
    	<td align="right" width="40%">ISPREF&nbsp;</td>
    	<td align="left" width="60%">&nbsp;<input type="checkbox" id="ispref" name="ispref" class="txtinput" /></td>
  	</tr>-->
   <!-- <tr>
    	<td align="right" width="40%">AUI&nbsp;</td>
    	<td align="left" width="60%">&nbsp;<input id="aui" name="aui" size="32" class="txtinput" /></td>
        <td align="right" width="40%">SAUI&nbsp;</td>
    	<td align="left" width="60%">&nbsp;<input id="saui" name="saui" size="32" class="txtinput" /></td>
  	</tr>-->
    <!--<tr>
    	<td align="right" width="40%">SAUI&nbsp;</td>
    	<td align="left" width="60%">&nbsp;<input id="saui" name="saui" size="32" class="txtinput" /></td>
  	</tr>-->
    <!--<tr>
    	<td align="right" width="40%">SCUI&nbsp;</td>
    	<td align="left" width="60%">&nbsp;<input id="scui" name="scui" size="32" class="txtinput" /></td>
        <td align="right" width="40%">SDUI&nbsp;</td>
    	<td align="left" width="60%">&nbsp;<input id="sdui" name="sdui" size="32" class="txtinput" /></td>
  	</tr>-->
    <!--<tr>
    	<td align="right" width="40%">SDUI&nbsp;</td>
    	<td align="left" width="60%">&nbsp;<input id="sdui" name="sdui" size="32" class="txtinput" /></td>
  	</tr>-->
    <!--<tr>
    	<td align="right" width="40%">SAB&nbsp;</td>
    	<td align="left" width="60%">&nbsp;<input id="sab" name="sab" size="32" class="txtinput" /></td>
        <td align="right" width="40%">CODE&nbsp;</td>
    	<td align="left" width="60%">&nbsp;<input id="code" name="code" size="32" class="txtinput" /></td>
  	</tr>-->
    <!--<tr>
    	<td align="right" width="40%">CODE&nbsp;</td>
    	<td align="left" width="60%">&nbsp;<input id="code" name="code" size="32" class="txtinput" /></td>
  	</tr>-->
    <!--<tr>
    	<td align="right" width="40%">STR&nbsp;</td>
    	<td align="left" width="60%">&nbsp;<input id="str" name="str" size="32" class="txtinput" /></td>
        <td align="right" width="40%">SRL&nbsp;</td>
    	<td align="left" width="60%">&nbsp;<input id="srl" name="srl" size="32" class="txtinput" /></td>
  	</tr>-->
    <!--<tr>
    	<td align="right" width="40%">SRL&nbsp;</td>
    	<td align="left" width="60%">&nbsp;<input id="srl" name="srl" size="32" class="txtinput" /></td>
  	</tr>-->
    <!--<tr>
    	<td align="right" width="40%">SUPPRESS&nbsp;</td>
    	<td align="left" width="60%">&nbsp;<input id="suppress" name="suppress" size="32" class="txtinput" /></td>
        <td align="right" width="40%">CVF&nbsp;</td>
    	<td align="left" width="60%">&nbsp;<input id="cvf" name="cvf" size="32" class="txtinput" /></td>
  	</tr>-->
    <!--<tr>
    	<td align="right" width="40%">CVF&nbsp;</td>
    	<td align="left" width="60%">&nbsp;<input id="cvf" name="cvf" size="32" class="txtinput" /></td>
  	</tr>-->
  	<!--<tr>
		<td colspan="2">&nbsp;</td>
  	</tr>-->
	<!--<tr>
		<td align="right">STATUS&nbsp;</td>
		<td>&nbsp;<label><input type="checkbox" id="aktifSatuan" name="aktifSatuan" class="txtinput" />Aktif</label></td>
	</tr>-->
	<tr height="30">
		<td colspan="2" align="center">
			<input type="hidden" name="idSatuan" id="idSatuan" />
			<input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="simpan1(this.value);" class="tblTambah"/>
			<input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus1(this.id);" disabled="disabled" class="tblHapus"/>
			<input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal1()" class="tblBatal"/>
		</td>
	</tr>
  	<tr>
    	<td colspan="2" align="center">
			<div id="gridboxtab1" style="width:750px; height:200px; background-color:white; overflow:hidden;"></div>
			<div id="pagingtab1" style="width:750px;"></div>		</td>
  	</tr>
  	<tr>
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
  	</tr>
</table>
