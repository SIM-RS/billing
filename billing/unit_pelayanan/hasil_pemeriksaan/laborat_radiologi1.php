<div id="tab_laborat">
<table width="850" border="0" cellpadding="0" cellspacing="1" align="center">
    <tr>
        <td width="5%">&nbsp;</td>
        <td width="10%">&nbsp;</td>
        <td width="45%">&nbsp;</td>
        <td width="35%" align="right">&nbsp;&nbsp;&nbsp;</td>
        <td width="5%">&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="right">Tindakan :&nbsp;</td>
        <td colspan="2">
            <input name="tindakan_id_hsl" id="tindakan_id_hsl" type="hidden">
            <input name="idNormal" id="idNormal" type="hidden">
            <input id="txtTind_hsl" name="txtTind_hsl" size="65" onKeyUp="suggestHsl(event,this);" autocomplete="off" class="txtinput">
            <div id="divtindakanHsl" align="left" style="position:absolute; z-index:1; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC;"></div>
	   &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" size="10" class="txtinput" value="Cetak Hasil" onClick="cetakHsl()" />&nbsp;<input type="button" onclick="lihatPemeriksaan2()" value="Lihat Permintaan" class="txtinput" size="10"></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="right">Normal :&nbsp;</td>
        <td><label id="normal" class="txtinput" style="border:none;">-</label></td>
        <td colspan="2" rowspan="4" valign="top">&nbsp;
	   </td>
    </tr>
	<tr>
        <td>&nbsp;</td>
        <td align="right">Hasil :&nbsp;</td>
        <td><input id="txtHsl" name="txtHsl" size="10" style="text-align:center" class="txtinput"/>
        	&nbsp;&nbsp;&nbsp;
        <label style="cursor:pointer" title="Klik Untuk Approve/Non Approve Hasil Pemeriksaan"><span id="tapp1"><input onclick="SimpanValidasiLab()" type="checkbox" id="app1" class="app1" value="1" /> &nbsp;Aprove Pemeriksaan</span></label>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="right">Keterangan :&nbsp;</td>
        <td><input id="txtKetHsl" name="txtKetHsl" size="50" class="txtinput"/></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="right">Dokter :&nbsp;</td>
        <td><select id="cmbDokHsl" name="cmbDokHsl" class="txtinput" onkeypress="setDok('btnSimpanHsl',event);">
                <option value="">-Dokter-</option>
            </select>
		</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="center" height="28">
            <input type="hidden" id="idTindHsl" name="idTindHsl" />
            <input type="button" id="btnSimpanHsl" name="btnSimpanHsl" value="Tambah" onclick="fSimpanHsl(this.value,this.id,'txtTind');" class="tblTambah"/>
            <input type="button" id="btnHapusHsl" name="btnHapusHsl" value="Hapus" onclick="fHapusHsl(this.id);" disabled="disabled" class="tblHapus"/>
            <input type="button" id="btnBatalHsl" name="btnBatalHsl" value="Batal" onclick="batalHsl()" class="tblBatal"/></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td colspan="3">
            <div id="gridboxHsl" style="width:850px; height:240px; background-color:white;"></div>
            <br/>
            <div id="pagingHsl" style="width:850px;"></div>
        </td>
        <td>&nbsp;</td>
    </tr>
</table>
</div>
<div id="tab_radiologi">
<table width="850" border="0" cellpadding="0" cellspacing="1" align="center" style="padding-top:10px">
	<tr>
    	<td>&nbsp;<span id="tmpContent" style="display:none"></span></td>
    </tr>
    <tr>
        <td align="right" colspan="2">Template Radiologi :&nbsp;</td>
        <td><select id="cmbTmpRad" name="cmbTmpRad" class="txtinput" onchange="pTemplateRad();">
                <option value="">-Template Radiologi-</option>
            </select>
            </select>
		</td>
        <td align="right"><input type="button" size="10" class="txtinput" value="Cetak Hasil" onClick="cetakHslRad()" />&nbsp;<input type="button" onclick="lihatPemeriksaan2()" value="Lihat Permintaan" class="txtinput" size="10"></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="right">Tindakan :&nbsp;</td>
        <td colspan="2"><span id="spnTindRad"></span></td>
        <td>&nbsp;</td>
    </tr>
    <tr style="display:none;">
        <td>&nbsp;</td>
        <td align="right">Judul :&nbsp;</td>
        <td colspan="2"><input class="txtinput" id="txtJudul" name="txtJudul" size="60" /></td>
        <td>&nbsp;</td>
    </tr>
    <tr style="display:none">
        <td>&nbsp;</td>
        <td align="right">Ket. Klinis :&nbsp;</td>
        <td colspan="2"><input class="txtinput" id="txtKet_klinis" name="txtKet_klinis" size="60" /></td>
        <td>&nbsp;</td>
    </tr>
	<tr>
        <td>&nbsp;</td>
        <td align="right" valign="top">Hasil :&nbsp;</td>
        <td rowspan="2" colspan="2"><input type="hidden" id="id_hasil_rad" name="id_hasil_rad" /><input type="hidden" id="id_tind_rad" name="id_tind_rad" /><textarea id="txtHslRad" name="txtHslRad" class="txtHslRad" style="width:600px; height:200px"></textarea><span id="spnHasilRad" style="display:none"></span></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
        <td>&nbsp;</td>
    	
    </tr>
     <tr style="display:none">
        <td>&nbsp;</td>
        <td align="right" valign="top">Kesan :&nbsp;</td>
        <td colspan="2"><textarea class="txtinput" id="txtKesimpulan" name="txtKesimpulan" rows="2" cols="108"></textarea></td>
    <tr>
        <td>&nbsp;</td>
        <td align="right">Dokter :&nbsp;</td>
        <td colspan="2"><select id="cmbDokHslRad" name="cmbDokHslRad" class="txtinput" onkeypress="setDok('btnSimpanHslRad',event);">
                <option value="">-Dokter-</option>
            </select>
            <label style="display:none;"><input type="checkbox" id="chkDokterPenggantiHslRad" value="1" onchange="gantiDokter('cmbDokHslRad',this.checked);"/>Dokter Pengganti</label>
	</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="center" height="28">
            <input type="hidden" id="idTindHslRad" name="idTindHslRad" />
            <input type="button" id="btnSimpanHslRad" name="btnSimpanHslRad" disabled="disabled" value="Tambah" onclick="fSimpanHslRad(this.value,this.id,'txtTind');" class="tblTambah"/>
            <input style="display:none" type="button" id="btnHapusHslRad" name="btnHapusHslRad" value="Hapus" onclick="fHapusHslRad(this.id);" disabled="disabled" class="tblHapus"/>
            <input type="button" id="btnBatalHslRad" name="btnBatalHslRad" value="Batal" onclick="fBatalHslRad('btnSimpanHslRad')" class="tblBatal"/></td>
        <td align="right">&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td colspan="4">
            <div id="gridboxHslRad" style="width:870px; height:115px; background-color:white;"></div>
            <br/>
            <div id="pagingHslRad" style="width:870px;"></div>
        </td>
        <td width="0%">&nbsp;</td>
    </tr>
</table>
</div>