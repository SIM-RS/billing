<div id="hslAnamnesa" style="display:none"></div>
<div id="hsl_RA_terakhir" style="display:none"></div>
<div id="hsl_cmb_PF" style="display:none"></div>
<img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" />
<fieldset>
    <legend id="lgnIsiDataRM">ANAMNESA &amp; PEMERIKSAAN FISIK</legend>
    <div id=""></div>
    <form id="form_isi_anamnesa" name="form_isi_anamnesa">
    <table border="0" cellpadding="0" cellspacing="0" align="center" width="950">
        <tr>
            <td colspan="4">Pelaksana&nbsp;:&nbsp;
                <select id="cmbDokAnamnesa" name="cmbDokAnamnesa">
                    <option>-</option>
                </select>
                <label>
                    <input type="checkbox" id="chkDokterPenggantiAnamnesa" value="1" onchange="gantiDokter('cmbDokAnamnesa',this.checked);"/>Dokter Pengganti
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="padding-top:5px; text-decoration:underline;">I. ANAMNESA</td>
        </tr>
        <tr>
            <td>Keluhan Utama</td>
            <td>Riwayat Penyakit Sekarang</td>
            <td>Riwayat Penyakit Dahulu</td>
            <td></td>
        </tr>
        <tr>
            <td><textarea id="txtKU" name="txtKU" cols="35"></textarea></td>
            <td><textarea id="txtRPS" name="txtRPS" cols="35"></textarea></td>
            <td><textarea id="txtRPD" name="txtRPD" cols="35"></textarea></td>
            <td></td>
        </tr>
        <tr>
            <td style="padding-top:5px;">Riwayat Penyakit Keluarga</td>
            <td style="padding-top:5px;">Anamnese Sosial</td>
            <td style="padding-top:5px;">&nbsp;</td>
            <td style="padding-top:5px;"></td>
        </tr>
        <tr>
            <td><textarea id="txtRPK" name="txtRPK" cols="35"></textarea></td>
            <td><textarea id="txtAS" name="txtAS" cols="35"></textarea></td>
            <td>&nbsp;</td>
            <td></td>
        </tr>
        <td>
            <td colspan="4" style="padding-bottom:5px;"></td>
        </td>
        <tr>
            <td colspan="4" style="border-top:1px solid black; padding-top:5px; text-decoration:underline;">II. PEMERIKSAAN FISIK</td>
        </tr>
        <tr>
            <td colspan="4">
                <table width="100%">
                    <tr>
                        <td width="55%">
                            <table width="100%">
                                <tr>
                                    <td>Keadaan Umum</td>
                                    <td>:&nbsp;<input type="text" id="txtKUM" name="txtKUM" /></td>
                                    <td>GCS</td>
                                    <td>:&nbsp;<input type="text" id="txtGCS" name="txtGCS" /></td>
                                </tr>
                                <tr>
                                    <td>Kesadaran</td>
                                    <td>:&nbsp;<input type="text" size="20" id="cmbKesadaran" name="cmbKesadaran" />
                                    </td>
                                    <td>Status Gizi</td>
                                    <td>:&nbsp;<input type="text" size="20" id="cmbStatusGizi" name="cmbStatusGizi" />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td width="45%">
                            <table width="100%">
                                            <!--<tr>
                                                <td width="35">Tensi</td>
                                                <td width="55" align="center"><input type="text" size="5" id="txtTensi" name="txtTensi" /></td>
                                                <td width="55">mmHg</td>
                                                <td width="100"></td>
                                                <td width="35">Nadi</td>
                                                <td width="55" align="center"><input type="text" size="5" id="txtNadi" name="txtNadi" /></td>
                                                <td width="55">/Mnt</td>
                                                <td width="100"></td>
                                                <td width="35">BB</td>
                                                <td width="55" align="center"><input type="text" size="5" id="txtBB" name="txtBB" /></td>
                                                <td width="55">Kg</td>
                                            </tr>-->
                                            <tr>
                                                <td width="35">RR</td>
                                                <td width="55" align="center"><input type="text" size="5" id="txtRR" name="txtRR" /></td>
                                                <td width="55">/Mnt</td>
                                                <td width="100"></td>
                                                <td width="35">Suhu</td>
                                                <td width="55" align="center"><input type="text" size="5" id="txtSuhu" name="txtSuhu" /></td>
                                                <td width="55">°C</td>
                                                <td width="100"></td>
                                                <td width="35">TB</td>
                                                <td width="55" align="center"><input type="text" size="5" id="txtTB" name="txtTB" /></td>
                                                <td width="55">cm</td>
                                            </tr>
                                            <tr>
                                                <td width="35">Tensi sistolik</td>
                                                <td width="55" align="center"><input type="text" size="5" id="txtTensi" name="txtTensi" /></td>
                                                <td width="55">mmHg</td>
                                                <td width="100"></td>
                                                <td width="35">Nadi</td>
                                                <td width="55" align="center"><input type="text" size="5" id="txtNadi" name="txtNadi" /></td>
                                                <td width="55">/Mnt</td>
                                                <td width="100"></td>
                                                <td width="35">BB</td>
                                                <td width="55" align="center"><input type="text" size="5" id="txtBB" name="txtBB" /></td>
                                                <td width="55">Kg</td>
                                            </tr>
                                            <tr>
                                                <td width="35">Tensi diastolik</td>
                                                <td width="55" align="center"><input type="text" size="5" id="txtTensi1" name="txtTensi1" /></td>
                                                <td width="55">mmHg</td>
                                                <td width="100"></td>
                                                <td width="35">&nbsp;</td>
                                                <td width="55" align="center">&nbsp;</td>
                                                <td width="55">&nbsp;</td>
                                                <td width="100"></td>
                                                <td width="35">&nbsp;</td>
                                                <td width="55" align="center">&nbsp;</td>
                                                <td width="55">&nbsp;</td>
                                            </tr>
                                        </table>
                        </td>
                    </tr>
                    <tr>
                    	<td colspan="2">
                        	<table width="100%">
                                <tr id="KL">
                                    <td>Kepala</td>
                                    <td>&nbsp;<textarea id="cmbKepalaLeher" name="cmbKepalaLeher" cols="35"></textarea>
                                    </td>
                                    <td>Leher</td>
                                    <td>&nbsp;<textarea id="txtLeher" name="txtLeher" cols="35"></textarea>
                                    </td>                                 
                                </tr>
                                <tr>
                                    <td>Thorax</td>
                                    <td>&nbsp;<textarea id="txtThorax" name="txtThorax" cols="35"></textarea>
                                        <input type="hidden" size="20" id="cmbAuskultasi" name="cmbAuskultasi" />
                                    </td>
                                    <td>Pulmo</td>
                                    <td>&nbsp;<textarea id="cmbPulmo" name="cmbPulmo" cols="35"></textarea>
                                    </td>                             
                                </tr>
                                <tr>
                                	<td>Cor</td>
                                    <td>&nbsp;<textarea id="cmbCor" name="cmbCor" cols="35"></textarea>
                                    </td>
                                    <td id="ab">Abdomen</td>
                                    <td id="ab">&nbsp;<textarea id="txtAbdomen" name="txtAbdomen" cols="35"></textarea>
                                    </td>                                            
                                </tr>
                                <tr id="gen">
                                	<td>Genitalia</td>
                                    <td>&nbsp;<textarea id="txtGen" name="txtGen" cols="35"></textarea>
                                    </td> 
                                    <td>Ekstremitas</td>
                                    <td>&nbsp;<textarea id="cmbEkstremitas" name="cmbEkstremitas" cols="35"></textarea>
                                    </td>                                                            
                                </tr>
                                <tr style="display:none">
                                    <td>Perkusi</td>
                                    <td>:&nbsp;
                                        <input type="text" size="20" id="cmbPerkusi" name="cmbPerkusi" />
                                    </td>
                                    <td>Inspeksi</td>
                                    <td>:&nbsp;
                                        <input type="text" size="20" id="cmbInspeksi" name="cmbInspeksi" />
                                    </td>
                                </tr>
                                <tr style="display:none">
                                    <td>Palpasi</td>
                                    <td>:&nbsp;
                                        <input type="text" size="20" id="cmbPalpasi" name="cmbPalpasi" />
                                    </td>
                                    <td id="">&nbsp;</td>
                                    <td id="">&nbsp;
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>							
        </tr>
        <tr>                        	
            <td colspan="4" align="center" style="padding-bottom:10px;">
                <input type="hidden" id="id_anamnesa" name="id_anamnesa" />
                <button type="button" id="btnSimpanAnamnesa" name="btnSimpanAnamnesa" value="tambah" onClick="saveAnamnesa(this.value)" style="cursor:pointer">
                    <img src="../icon/edit_add.png" height="16" width="16" style="position:absolute;" />
                    <span style="margin-left:20px;">Add</span>
                </button>
                <button type="button" id="btnDeleteAnamnesa" name="btnDeleteAnamnesa" onClick="deleteAnamnesa()" style="cursor:pointer; display:none;">
                    <img src="../icon/del.gif" height="16" width="16" style="position:absolute;" />
                    <span style="margin-left:20px;">Delete</span>
                </button>
                <button type="button" id="btnBatalAnamnesa" name="btnBatalAnamnesa" onClick="batalAnamnesa()" style="cursor:pointer">
                    <img src="../icon/back.png" height="16" width="16" style="position:absolute;" />
                    <span style="margin-left:20px;">Cancel</span>
                </button>
                <input id="anamnesa" type="button" value="CETAK RESUME MEDIS" onclick="cetak_resume();" />
            </td>
        </tr>
        <tr>
            <td colspan="4" align="center">
                <div id="gridboxAnamnesa" style="width:850px; height:150px; padding-bottom:20px; background-color:white;"></div>
                <div id="pagingAnamnesa" style="width:850px;"></div>
            </td>
        </tr>
    </table>
    </form>
</fieldset>

<script>


</script>