<?
$date_now=gmdate('d-m-Y',mktime(date('H')+7));
include("../sesi.php");
?>
<form id="form_diag" name="form_diag" ><table id="tbl_tab_diag" width="850" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr class="diag1">
		<td width="0%">&nbsp;</td>
		<td width="16%">&nbsp;</td>
		<td width="47%"><span style="vertical-align:middle;">&nbsp;
       <input type="checkbox" id="chkICD_manual" name="chkICD_manual" style="vertical-align:middle; cursor:pointer" onchange="cekICD_manual()"/> Diagnosa Manual</span></td>
		<td width="32%">&nbsp;</td>
		<td width="5%">&nbsp;</td>
	</tr>
    <tr class="tglJamDiag" id="tglJamDiag">
		<td>&nbsp;</td>
		<td align="left">Tgl Input&nbsp;</td>
		<td colspan="2">
        : 
        <input type="text" class="txtcenter" readonly name="TglDiagB" id="TglDiagB" size="11" value="<?php echo $date_now;?>"/>
                            <input type="button" id="btnDiagB" name="btnDiagB" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('TglDiagB'),depRange,fungsikosong);"  disabled="disabled"/>
        <input id="jamDiagB" name="jamDiagB" size="11" class="txtcenter" type="text" value="" />
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr class="diag1">
		<td>&nbsp;</td>
		<td align="left">Diagnosa&nbsp;</td>
		<td colspan="2">
		: 
		<input name="diagnosa_id" id="diagnosa_id" type="hidden">
		<input id="txtDiag" name="txtDiag" size="68" onKeyUp="suggest(event,this);" autocomplete="off" class="txtinput">
		<input type="button" value="cari" onclick="suggest('cariDiag',document.getElementById('txtDiag'))" class="txtinput" />
		<div id="divdiagnosa" align="left" style="position:absolute; z-index:1; height: 230px; width:720px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC;"></div>		<span style="vertical-align:middle;" id="pil_PK"><input type="checkbox" id="chkPenyebabKecelakaan" name="chkPenyebabKecelakaan" onchange="cekPenyebabKecelakaan()" style="vertical-align:middle"/> Penyebab Kecelakaan</span>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr id="trPenyebab" style="display:none">
		<td>&nbsp;</td>
		<td align="left">Penyebab&nbsp;</td>
		<td><!--label><input type="checkbox" id="chkUtama" name="chkUtama" checked="checked"/> Utama</label-->
        	: 
        	<select id="cmbPenyebab" name="cmbPenyebab" class="txtinput" style="width:400px;">
            	<option value="0">-Pilih-</option>
            </select>
        </td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
    <!--<tr id="trPrioritas" class="diag1">
		<td>&nbsp;</td>
		<td align="right">Prioritas :&nbsp;</td>
		<td><!--label><input type="checkbox" id="chkUtama" name="chkUtama" checked="checked"/> Utama</label-->
        	<!--<select id="cmbUtama" name="cmbUtama" class="txtinput">
            	<option value="1">Utama</option>
                <option value="0">Sekunder</option>
            </select>-->
       <!-- </td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>-->
    <tr id="trDiagnosaKlinis">
		<td>&nbsp;</td>
		<td align="left">Diagnosa Klinis&nbsp;</td>
		<td><label>: 
		    <input type="checkbox" id="chkKlinis" name="chkAkhir"/> Ya</label>
        </td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<!-- <tr>
		<td>&nbsp;</td>
		<td align="left">FLag&nbsp;</td>
		<td>:&nbsp; -->
		<input type="hidden" disabled class="txtinputreg" name="flag" id="flag" tabindex="3" value="<?php echo $flag; ?>"/>
        <!-- </td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr> -->
    <tr id="trPrioritas" class="diag1">
		<td>&nbsp;</td>
		<td align="left">Prioritas&nbsp;</td>
		<td><!--label><input type="checkbox" id="chkUtama" name="chkUtama" checked="checked"/> Utama</label-->
        	: 
        	<select id="cmbUtama" name="cmbUtama" class="txtinput">
            	<option value="1">Utama</option>
                <option value="0">Sekunder</option>
            </select>
        </td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
    <tr id="trDiagnosaBanding">
		<td>&nbsp;</td>
		<td align="left">Diagnosa Banding&nbsp;</td><!--jokerdiag-->
		<td colspan="3">: <!--label><input type="checkbox" id="chkBanding" name="chkBanding" onchange="fChkBanding(this);" /> Ya</label>
        <input id="txtDiagBanding" name="txtDiagBanding" size="48" autocomplete="off" class="txtinput" style="display:none">
        <input id="btnTambahDiagBanding" type="button" value="+" style="display:none" onclick="fTambahDiagBanding();" /-->
		  <input id="TotDiagBanding"name="TotDiagBanding" type="hidden" size="48" autocomplete="off" /><input id="idtxtDiagBanding"name="idtxtDiagBanding" type="hidden" size="48" autocomplete="off" class="txtinput idtxtDiagBanding2" /><input id="txtDiagBanding"name="txtDiagBanding" type="text" size="48" autocomplete="off" class="txtinput txtDiagBanding2" /><input id="txtDiagBandingCdgn"name="txtDiagBandingCdgn" type="hidden" size="48" autocomplete="off" class="txtinput txtDiagBanding2" />
        <img width="16" height="16" align="absmiddle" border="0" onclick="if (confirm('Yakin Ingin Menghapus Data?')){fHapusDiagBandingRst(this);}" title="Klik Untuk Menghapus" class="proses" src="../icon/del.gif"><input id="btnTambahDiagBanding" type="button" value="+" onclick="fTambahDiagBanding();" /><div id="loadHapusDiagnosa"></div></td>
		<!--td>&nbsp;</td>
		<td>&nbsp;</td-->
	</tr>
    <tr id="trDiagnosaAkhir" style="display:none" class="diag1">
		<td>&nbsp;</td>
		<td align="left">Diagnosa Akhir&nbsp;</td>
		<td><label>: 
		    <input type="checkbox" id="chkAkhir" name="chkAkhir"/> Ya</label></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
    <tr id="trDiagnosaMati">
		<td>&nbsp;</td>
		<td align="left">Penyebab Kematian&nbsp;</td>
		<td><label>:
		    <input type="checkbox" id="chkMati" name="chkMati"/> Ya</label></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr class="diag1">
		<td>&nbsp;</td>
		<td align="left">Dokter&nbsp;</td>
		<td>: 
			<select id="cmbDokDiag" name="cmbDokDiag" class="txtinput" onkeypress="setDok('btnSimpanDiag',event);" onchange="setSemDokter(this.value);">
		<option value="">-Dokter-</option>
		</select>
		<label><input type="checkbox" id="chkDokterPenggantiDiag" value="1" onchange="gantiDokter('cmbDokDiag',this.checked);"/>Dokter Pengganti</label>
		</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>	
	
	<tr class="diag1">
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td align="center" height="28">
			<input type="hidden" id="id_diag" name="id_diag" />
			<input type="button" id="btnSimpanDiag" name="btnSimpanDiag" value="Tambah" onclick="simpan(this.value,this.id,'txtDiag');" class="tblTambah"/>
			<input type="button" id="btnHapusDiag" name="btnHapusDiag" value="Hapus" onclick="hapus(this.id);" disabled="disabled" class="tblHapus"/>
			<input type="button" id="btnBatalDiag" name="btnBatalDiag" value="Batal" onclick="batal(this.id)" class="tblBatal"/></td>
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
		<td>&nbsp;</td>
		<td colspan="3">
			<div id="gridbox1" style="width:850px; height:180px; background-color:white; overflow:hidden;"></div>
			<div id="paging1" style="width:850px;"></div>		</td>
		<td>&nbsp;</td>
	</tr>	
</table></form>