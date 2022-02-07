<table width="850" border="0" cellpadding="0" cellspacing="1" align="center">
    <tr style="">
        <td width="0%">&nbsp;</td>
        <td width="14%">&nbsp;</td>
        <td width="49%">
            <label><input type="checkbox" id="chkTind" onclick="showUnit(this.checked)" class="chkinput"/>
		Pilih unit lainnya
            </label>
        </td>
        <td width="36%" align="right"><div id="divLab"><input id="nomorLab" name="nomorLab" size="10" class="txtinput" readonly="readonly"/></div>&nbsp;&nbsp;&nbsp;</td>
        <td width="1%">&nbsp;</td>
    </tr>
    <tr id="trUnit" style="visibility:collapse;">
        <td width="0%">&nbsp;</td>
        <td colspan="3">
            <table border=0>
                <tr>
                    <td width="162" align="right">Jenis Layanan :</td>
                    <td ><select name="jnsLay" id="jnsLay" tabindex="26" class="txtinput" onchange="isiCombo('TmpLayanan',this.value,'','tmpLay',setUnitLagi);"></select></td>
                </tr>
                <tr>			
                    <td align="right">Tempat Layanan :</td>
                    <td><select name="tmpLay" id="tmpLay" tabindex="27" class="txtinput" onchange="setUnit(this.value)"></select></td>
                </tr>
            </table>
        </td>
        <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="right">Tanggal :&nbsp;</td>
      <td colspan="2"><input id="tglTindak" name="tglTindak" readonly size="11" class="txtcenter" type="text" value="<?=date('d-m-Y')?>"/>&nbsp;<input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="txtcenter" onclick="gfPop.fPopCalendar(document.getElementById('tglTindak'),depRange,fungsikosong);"/>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="right">Tindakan :&nbsp;</td>
        <td colspan="2">
            <input name="tindakan_id" id="tindakan_id" type="hidden">
            <input name="mtId" id="mtId" type="hidden">
            <input id="txtTind" name="txtTind" size="80" onKeyUp="suggest1(event,this);" autocomplete="off" class="txtinput">
		  	<input type="button" class="txtinput" value="cari" onclick="suggest1('cariTind',this);" >
            <div id="divtindakan" align="left" style="position:absolute; z-index:1; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC;"></div>
	   </td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="right">Kelas :&nbsp;</td>
        <td><label id="tdKelas" class="txtinput" style="border:none;">non kelas</label></td>
        <td colspan="2" rowspan="5" valign="top">&nbsp;
		  <div id="div_an" style="display:none">
			 <form id="form_an" name="form_an">
				Dokter Anastesi:<br>
				<div id="dok_anastesi" style="overflow:auto;height:60px;width:350px;">
				</div>
			 </form>
		  </div>
	   </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="right">Biaya :&nbsp;</td>
        <td><input id="txtBiaya" name="txtBiaya" type="text" size="10" class="txtinput" readonly="readonly" />
            <input id="txtBiayaAskes" name="txtBiayaAskes" type="hidden" size="10" class="txtinput" readonly="readonly" />
	   &nbsp;&nbsp;&nbsp;
	   Jumlah : <input id="txtQty" name="txtQty" type="text" size="3" class="txtcenter"/>
	   </td>
        <!--td colspan="2">&nbsp;</td-->
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="right">Keterangan :&nbsp;</td>
        <td><input id="txtKet" name="txtKet" size="50" class="txtinput"/></td>
        <!--td colspan="2">&nbsp;</td-->
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="right" valign="top">Dokter :&nbsp;</td>
        <td colspan="2"><select id="cmbDokTind" name="cmbDokTind" class="txtinput" onkeypress="setDok('btnSimpanTind',event);" onchange="setSemDokter(this.value);">
                <option value="">-Dokter-</option>
            </select>
			<br />
	<label><input type="checkbox" id="chkDokterPenggantiTind" value="1" onchange="gantiDokter('cmbDokTind',this.checked);"/>Dokter Pengganti</label>
	</td>
    <!--tr id="trRujuk" style="visibility:collapse;">
            <td width="5%">&nbsp;</td>
            <td colspan="3">
			<fieldset><legend>Rujukan Poli</legend>
            <table border=0>
            <tr>
                    <td width="162" align="right">Jenis Layanan :</td>
                    <td ><select name="JnsLayanan" id="JnsLayanan" tabindex="26" class="txtinput" onchange="isiCombo('TmpLayanan',this.value);this.title=this.value;"></select></td>

		</tr>
            <tr>
                    <td align="right">Tempat Layanan :</td>
                    <td><select name="TmpLayanan" id="TmpLayanan" tabindex="27" class="txtinput" ></select></td>

		</tr>
            <tr>
                    <td align="right">Keterangan Rujuk:</td>
                    <td><input type="text" id="txtKetRujuk" name="txtKetRujuk" size="20" class="txtinput"/></td>
		</tr>
		</table>
		</fieldset>
		</td>
            <td></td>
	</tr-->
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="center" height="28">
            <input type="hidden" id="id_tind" name="id_tind" />
            <input type="button" id="btnSimpanTind" name="btnSimpanTind" value="Tambah" onclick="simpan(this.value,this.id,'txtTind');" class="tblTambah"/>
            <input type="button" id="btnHapusTind" name="btnHapusTind" value="Hapus" onclick="hapus(this.id);" disabled="disabled" class="tblHapus"/>
            <input type="button" id="btnBatalTind" name="btnBatalTind" value="Batal" onclick="batal(this.id)" class="tblBatal"/></td>
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
            <div id="gridboxTind" style="width:850px; height:150px; background-color:white;"></div>
            <br/>
            <div id="pagingTind" style="width:850px;"></div>
        </td>
        <td>&nbsp;</td>
    </tr>
</table>
