<div id="anam" class="anam">
<table width="850" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr class="diag1">
		<td width="0%">&nbsp;</td>
		<td width="15%">&nbsp;</td>
		<td width="51%">&nbsp;</td>
		<td width="34%">&nbsp;</td>
		<td width="0%">&nbsp;</td>
	</tr>
	<!--<tr class="diag1">
		<td>&nbsp;</td>
		<td align="right">Diagnosa :&nbsp;</td>
		<td colspan="2">
		<input name="diagnosa_id" id="diagnosa_id" type="hidden">
		<input id="txtDiag" name="txtDiag" size="68" onKeyUp="suggest(event,this);" autocomplete="off" class="txtinput">
		<input type="button" value="cari" onclick="suggest('cariDiag',document.getElementById('txtDiag'))" class="txtinput" />
		<div id="divdiagnosa" align="left" style="position:absolute; z-index:1; height: 230px; width:720px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC;"></div>		<span style="vertical-align:middle;" id="pil_PK"><input type="checkbox" id="chkPenyebabKecelakaan" name="chkPenyebabKecelakaan" onchange="cekPenyebabKecelakaan()" style="vertical-align:middle"/> Penyebab Kecelakaan</span></td>
		<td>&nbsp;</td>
	</tr>-->
	<!--<tr id="trPenyebab" style="display:none">
		<td>&nbsp;</td>
		<td align="right">Penyebab :&nbsp;</td>
		<td><!--label><input type="checkbox" id="chkUtama" name="chkUtama" checked="checked"/> Utama</label lama-->
        	<!--<select id="cmbPenyebab" name="cmbPenyebab" class="txtinput" style="width:400px;">
            	<option value="0">-Pilih-</option>
            </select>-->
       <!-- </td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>-->
    <!--<tr id="trPrioritas" class="diag1">
		<td>&nbsp;</td>
		<td align="right">Prioritas :&nbsp;</td>
		<td><!--label><input type="checkbox" id="chkUtama" name="chkUtama" checked="checked"/> Utama</label lama-->
        	<!--<select id="cmbUtama" name="cmbUtama" class="txtinput">
            	<option value="1">Utama</option>
                <option value="0">Sekunder</option>
            </select>-->
        <!-- </td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>-->
    <!--<tr id="trDiagnosaAkhir" style="display:none" class="diag1">
		<td>&nbsp;</td>
		<td align="right">Diagnosa Akhir :&nbsp;</td>
		<td><label><input type="checkbox" id="chkAkhir" name="chkAkhir"/> Ya</label>
        </td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr class="diag1">
		<td>&nbsp;</td>
		<td align="right">Dokter :&nbsp;</td>
		<td>
			<select id="cmbDokDiag" name="cmbDokDiag" class="txtinput" onkeypress="setDok('btnSimpanDiag',event);">
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
	</tr>-->
    <tr>
		<td colspan="4" align="right">
        <button id="btnTmbhAnam" name="btnTmbhAnam" type="button" onclick="isiAnamnesa()"><img src="../icon/add.gif" width="16" height="16" />&nbsp;Tambah</button>
        <button id="btnCtkAnam" name="btnCtkAnam" type="button" onclick="cetak_resume2()"><img src="../icon/printer.png" width="16" height="16" />&nbsp;Cetak</button>
        </td>
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
			<div id="gridbox1_1" style="width:850px; height:250px; background-color:white; overflow:hidden;"></div>
			<div id="paging1_1" style="width:850px;"></div>		</td>
		<td>&nbsp;</td>
	</tr>	
</table>
</div>
<div id="soap1" class="soap1" style="">
<table width="850" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr class="diag1">
		<td width="0%">&nbsp;</td>
		<td width="15%">&nbsp;</td>
		<td width="51%">&nbsp;</td>
		<td width="34%">&nbsp;</td>
		<td width="0%">&nbsp;</td>
	</tr>
	<!--<tr class="diag1">
		<td>&nbsp;</td>
		<td align="right">Diagnosa :&nbsp;</td>
		<td colspan="2">
		<input name="diagnosa_id" id="diagnosa_id" type="hidden">
		<input id="txtDiag" name="txtDiag" size="68" onKeyUp="suggest(event,this);" autocomplete="off" class="txtinput">
		<input type="button" value="cari" onclick="suggest('cariDiag',document.getElementById('txtDiag'))" class="txtinput" />
		<div id="divdiagnosa" align="left" style="position:absolute; z-index:1; height: 230px; width:720px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC;"></div>		<span style="vertical-align:middle;" id="pil_PK"><input type="checkbox" id="chkPenyebabKecelakaan" name="chkPenyebabKecelakaan" onchange="cekPenyebabKecelakaan()" style="vertical-align:middle"/> Penyebab Kecelakaan</span></td>
		<td>&nbsp;</td>
	</tr>-->
	<!--<tr id="trPenyebab" style="display:none">
		<td>&nbsp;</td>
		<td align="right">Penyebab :&nbsp;</td>
		<td><!--label><input type="checkbox" id="chkUtama" name="chkUtama" checked="checked"/> Utama</label lama-->
        	<!--<select id="cmbPenyebab" name="cmbPenyebab" class="txtinput" style="width:400px;">
            	<option value="0">-Pilih-</option>
            </select>-->
       <!-- </td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>-->
    <!--<tr id="trPrioritas" class="diag1">
		<td>&nbsp;</td>
		<td align="right">Prioritas :&nbsp;</td>
		<td><!--label><input type="checkbox" id="chkUtama" name="chkUtama" checked="checked"/> Utama</label lama-->
        	<!--<select id="cmbUtama" name="cmbUtama" class="txtinput">
            	<option value="1">Utama</option>
                <option value="0">Sekunder</option>
            </select>-->
        <!-- </td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>-->
    <!--<tr id="trDiagnosaAkhir" style="display:none" class="diag1">
		<td>&nbsp;</td>
		<td align="right">Diagnosa Akhir :&nbsp;</td>
		<td><label><input type="checkbox" id="chkAkhir" name="chkAkhir"/> Ya</label>
        </td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr class="diag1">
		<td>&nbsp;</td>
		<td align="right">Dokter :&nbsp;</td>
		<td>
			<select id="cmbDokDiag" name="cmbDokDiag" class="txtinput" onkeypress="setDok('btnSimpanDiag',event);">
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
	</tr>-->
    <tr>
		<td colspan="4" align="right">
        <button id="btnTmbhSoap" name="btnTmbhSoap" type="button" onclick="isiSOAPIER1()"><img src="../icon/add.gif" width="16" height="16" />&nbsp;Tambah</button>
        </td>
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
			<div id="gridbox1_2" style="width:850px; height:180px; background-color:white; overflow:hidden;"></div>
			<div id="paging1_2" style="width:850px;"></div>		</td>
		<td>&nbsp;</td>
	</tr>	
</table>
</div>
