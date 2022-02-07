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
            <input id="txtTind_hsl" name="txtTind_hsl" size="75" onKeyUp="suggestHsl(event,this);" autocomplete="off" class="txtinput">
		  <!--input type="button" class="txtinput" value="cari" onclick="suggest1('cariTind',this);" /-->
            <div id="divtindakanHsl" align="left" style="position:absolute; z-index:1; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC;"></div>
	   &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" size="10" class="txtinput" value="Cetak Hasil" onClick="cetakHsl()" /></td>
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
        <td><input id="txtHsl" name="txtHsl" size="10" style="text-align:center" class="txtinput"/></td>
        <!--td colspan="2">&nbsp;</td-->
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="right">Keterangan :&nbsp;</td>
        <td><input id="txtKetHsl" name="txtKetHsl" size="50" class="txtinput"/></td>
        <!--td colspan="2">&nbsp;</td-->
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
            <input type="button" id="btnSimpanHsl" name="btnSimpanHsl" value="Tambah" onclick="simpan(this.value,this.id,'txtTind');" class="tblTambah"/>
            <input type="button" id="btnHapusHsl" name="btnHapusHsl" value="Hapus" onclick="hapus(this.id);" disabled="disabled" class="tblHapus"/>
            <input type="button" id="btnBatalHsl" name="btnBatalHsl" value="Batal" onclick="batalHsl()" class="tblBatal"/></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <!--tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
	</tr-->
    <tr>
        <td>&nbsp;</td>
        <td colspan="3">
            <div id="gridboxHsl" style="width:850px; height:170px; background-color:white;"></div>
            <br/>
            <div id="pagingHsl" style="width:850px;"></div>
        </td>
        <td>&nbsp;</td>
    </tr>
</table>
</div>
<div id="tab_radiologi">
<table width="850" border="0" cellpadding="0" cellspacing="1" align="center">
    <tr>
        <td width="5%">&nbsp;</td>
        <td width="10%">&nbsp;</td>
        <td width="45%">&nbsp;</td>
        <td width="35%" align="right">&nbsp;&nbsp;&nbsp;</td>
        <td width="5%">&nbsp;</td>
    </tr>
    <tr>
        <td width="5%">&nbsp;</td>
        <td width="10%" align="right">Ket. Rujuk :&nbsp;</td>
        <td width="45%"><span id="ketRujuk_rad"></span></td>
        <td width="35%" align="right">&nbsp;&nbsp;&nbsp;</td>
        <td width="5%">&nbsp;</td>
    </tr>
	<tr>
        <td>&nbsp;</td>
        <td align="right">Hasil :&nbsp;</td>
        <td rowspan="3"><input type="hidden" id="id_hasil_rad" name="id_hasil_rad" /><input type="hidden" id="txtHslRad2" name="txtHslRad2" class="txtinput" size="40"/><textarea id="txtHslRad" name="txtHslRad" class="txtinput" style="width:400px; height:60px"></textarea></td>
        <td colspan="2" rowspan="5" style="vertical-align:top">
        <div id="temp_rad" style="display:none"></div>
          <div style="margin-bottom:10px;" id="div_rad">
          <iframe id="frameRad" src="f_radiologi.php" style="border:none; height:100px; width:100%; overflow:hidden"></iframe>
          </div>
        </td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
        <td>&nbsp;</td>
    	
    </tr>
    <tr>
     	<td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="right">Dokter :&nbsp;</td>
        <td><select id="cmbDokHslRad" name="cmbDokHslRad" class="txtinput" onkeypress="setDok('btnSimpanHslRad',event);">
                <option value="">-Dokter-</option>
            </select>
	</td>
    </tr>
    <tr>
    	<td colspan="3">&nbsp;
        
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="center" height="28">
            <input type="hidden" id="idTindHslRad" name="idTindHslRad" />
            <input type="button" id="btnSimpanHslRad" name="btnSimpanHslRad" value="Tambah" onclick="simpan(this.value,this.id,'txtTind');" class="tblTambah"/>
            <input type="button" id="btnHapusHslRad" name="btnHapusHslRad" value="Hapus" onclick="hapus(this.id);" disabled="disabled" class="tblHapus"/>
            <input type="button" id="btnBatalHslRad" name="btnBatalHslRad" value="Batal" onclick="batal('btnSimpanHslRad')" class="tblBatal"/></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <!--tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
	</tr-->
    <tr>
        <td>&nbsp;</td>
        <td colspan="4">
            <div id="gridboxHslRad" style="width:850px; height:150px; background-color:white;"></div>
            <br/>
            <div id="pagingHslRad" style="width:850px;"></div>
        </td>
        <td>&nbsp;</td>
    </tr>
</table>
</div>