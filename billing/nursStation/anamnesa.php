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
      <td colspan="4">
      	<table width="818">
        	<tr>
            	<td width="129">Nama Pasien
                </td>
                <td width="20">:
                </td>
                <td width="653"><label id="nmPA" class="nmPA"></label>
                </td>
            </tr>
        	<tr>
        	  <td>No RM</td>
        	  <td>:</td>
        	  <td><label id="nmRM" class="nmRM"></label></td>
      	  </tr>
        	<tr>
        	  <td>Umur</td>
        	  <td>:</td>
        	  <td> <label id="umrPA" class="umrPA"></label></td>
      	  </tr>
        	<tr>
        	  <td>Alamat</td>
        	  <td>:</td>
        	  <td><label id="almt" class="almt"></label></td>
      	  </tr>
          <tr>
        	  <td>Pelaksana</td>
        	  <td>:</td>
        	  <td> <select id="cmbDokAnamnesa" name="cmbDokAnamnesa">
                    <option>-</option>
                </select>
                <label>
                    <input type="checkbox" id="chkDokterPenggantiAnamnesa" value="1" onchange="gantiDokter('cmbDokAnamnesa',this.checked);"/>Dokter Pengganti
                </label></td>
      	  </tr>
 
        </table>
      </td>
    </tr>

    
      
        <tr style="display:none">
            <td colspan="4" style="padding-top:5px; text-decoration:underline;">I. ANAMNESA</td>
        </tr>
        <tr style="display:none">
            <td>Keluhan Utama</td>
            <td>Riwayat Penyakit Sekarang</td>
            <td>Riwayat Penyakit Dahulu</td>
            <td></td>
        </tr>
        <tr style="display:none">
            <td><textarea id="txtKU" name="txtKU" cols="35"></textarea></td>
            <td><textarea id="txtRPS" name="txtRPS" cols="35"></textarea></td>
            <td><textarea id="txtRPD" name="txtRPD" cols="35"></textarea></td>
            <td></td>
        </tr>
        <tr style="display:none">
            <td style="padding-top:5px;">Riwayat Penyakit Keluarga</td>
            <td style="padding-top:5px;">Anamnese Sosial</td>
            <td style="padding-top:5px;">&nbsp;</td>
            <td style="padding-top:5px;"></td>
        </tr>
        <tr style="display:none">
            <td><textarea id="txtRPK" name="txtRPK" cols="35"></textarea></td>
            <td><textarea id="txtAS" name="txtAS" cols="35"></textarea></td>
            <td>&nbsp;</td>
            <td></td>
        </tr>
        <td>
            <td colspan="4" style="padding-bottom:5px;"></td>
        </td>
        <tr style="display:none">
            <td colspan="4" style="border-top:1px solid black; padding-top:5px; text-decoration:underline;">II. PEMERIKSAAN FISIK</td>
        </tr>
        <tr>
            <td colspan="4">
                <table width="100%">
                    <tr>
                        <td width="30%">
                            <table width="100%" id="gen">
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
                        <td width="70%">
                            <table width="50%">
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
                                                <td width="35">Tensi diastolik</td>
                                                <td width="55" align="center"><input type="text" size="5" id="txtTensi1" name="txtTensi1" /></td>
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
                                            <tr style="display:none">
                                                <td width="35">RR</td>
                                                <td width="55" align="center"><input type="text" size="5" id="txtRR" name="txtRR" /></td>
                                                <td width="55">mmHg</td>
                                                <td width="100"></td>
                                                <td width="35">NPS</td>
                                                <td width="55" align="center"><input type="text" size="5" id="txtNPS" name="txtNPS" /></td>
                                                <td width="55">&nbsp;</td>
                                                <td width="100"></td>
                                                <td width="35">&nbsp;</td>
                                                <td width="55" align="center">&nbsp;</td>
                                                <td width="55">&nbsp;</td>
                                            </tr>
                                        </table>
                                        <table width="100%">
                                <tr id="gen" style="display:none">
                                    <td>Kepala</td>
                                    <td>&nbsp;<textarea id="cmbKepalaLeher" name="cmbKepalaLeher" cols="35"></textarea>
                                    </td>
                                    <td>Leher</td>
                                    <td>&nbsp;<textarea id="txtLeher" name="txtLeher" cols="35"></textarea>
                                    </td>                                 
                                </tr>
                                <tr id="gen" style="display:none">
                                    <td>Thorax</td>
                                    <td>&nbsp;<textarea id="txtThorax" name="txtThorax" cols="35"></textarea>
                                        <input type="hidden" size="20" id="cmbAuskultasi" name="cmbAuskultasi" />
                                    </td>
                                    <td>Pulmo</td>
                                    <td>&nbsp;<textarea id="cmbPulmo" name="cmbPulmo" cols="35"></textarea>
                                    </td>                             
                                </tr>
                                <tr id="gen" style="display:none">
                                	<td>Cor</td>
                                    <td>&nbsp;<textarea id="cmbCor" name="cmbCor" cols="35"></textarea>
                                    </td>
                                    <td id="ab">Abdomen</td>
                                    <td id="ab">&nbsp;<textarea id="txtAbdomen" name="txtAbdomen" cols="35"></textarea>
                                    </td>                                            
                                </tr>
                                <tr id="gen" style="display:none">
                                	<td>Genitalia</td>
                                    <td>&nbsp;<textarea id="txtGen" name="txtGen" cols="35"></textarea>
                                    </td> 
                                    <td>Ekstremitas</td>
                                    <td>&nbsp;<textarea id="cmbEkstremitas" name="cmbEkstremitas" cols="35"></textarea>
                                    </td>                                                            
                                </tr>
                                <tr id="gen" style="display:none">
                                	<td>Pemeriksaan Penunjang</td>
                                    <td>&nbsp;<textarea id="txtPenunjangN" name="txtPenunjangN" cols="35"></textarea>
                                    </td> 
                                    <td>Prognosis</td>
                                    <td>&nbsp;<textarea id="txtprognososN" name="txtprognososN" cols="35"></textarea>
                                    </td>                                                            
                                </tr>
                                <tr id="gen" style="display:none">
                                	<td>Status Mentalis</td>
                                    <td>&nbsp;<textarea id="sMentalis" name="sMentalis" cols="35"></textarea>
                                    </td> 
                                    <td>&nbsp;Lingkar Kepala *</td>
                                    <td>&nbsp;<textarea id="lKepala" name="lKepala" cols="35"></textarea>
                                    </td>                                                            
                                </tr>
                                <tr id="gen" style="display:none">
                                	<td>&nbsp;Status Gizi *</td>
                                    <td>&nbsp;
                                    <select id="sGiziI" class="sGiziI">
                                    	<option value="buruk">Buruk</option>
                                        <option value="kurang">Kurang</option>
                                        <option value="cukup">Cukup</option>
                                        <option value="lebih">Lebih</option>
                                    </select>
                                    </td> 
                                    <td>&nbsp;Telinga *</td>
                                    <td>&nbsp;<textarea id="kTelinga" name="kTelinga" cols="35"></textarea>
                                    </td>                                                            
                                </tr>
                                <tr id="gen" style="display:none">
                                	<td>&nbsp;Hidung *</td>
                                    <td>&nbsp;
                                    <textarea id="kHidung" name="kHidung" cols="35"></textarea>
                                    </td> 
                                    <td>&nbsp;Tenggorok *</td>
                                    <td>&nbsp;<textarea id="kTenggorokan" name="kTenggorokan" cols="35"></textarea>
                                    </td>                                                            
                                </tr>
                                <tr id="gen" style="display:none">
                                	<td>&nbsp;Usul Tindakan Lanjut / Anjuran *</td>
                                    <td>&nbsp;
                                    <textarea id="uTinLanjut" name="uTinLanjut" cols="35"></textarea>
                                    </td> 
                                    <td>&nbsp;</td>
                                    <td>&nbsp;
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
                            <table width="100%">
                        </td>
                    </tr>
                    <tr>
                    	<td colspan="2">
                        	<!--<table width="100%">
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
                                <tr id="gen">
                                	<td>Pemeriksaan Penunjang</td>
                                    <td>&nbsp;<textarea id="txtPenunjangN" name="txtPenunjangN" cols="35"></textarea>
                                    </td> 
                                    <td>Prognosis</td>
                                    <td>&nbsp;<textarea id="txtprognososN" name="txtprognososN" cols="35"></textarea>
                                    </td>                                                            
                                </tr>
                                <tr id="gen">
                                	<td>Status Mentalis</td>
                                    <td>&nbsp;<textarea id="sMentalis" name="sMentalis" cols="35"></textarea>
                                    </td> 
                                    <td>&nbsp;Lingkar Kepala *</td>
                                    <td>&nbsp;<textarea id="lKepala" name="lKepala" cols="35"></textarea>
                                    </td>                                                            
                                </tr>
                                <tr id="gen">
                                	<td>&nbsp;Status Gizi *</td>
                                    <td>&nbsp;
                                    <select id="sGiziI" class="sGiziI">
                                    	<option value="buruk">Buruk</option>
                                        <option value="kurang">Kurang</option>
                                        <option value="cukup">Cukup</option>
                                        <option value="lebih">Lebih</option>
                                    </select>
                                    </td> 
                                    <td>&nbsp;Telinga *</td>
                                    <td>&nbsp;<textarea id="kTelinga" name="kTelinga" cols="35"></textarea>
                                    </td>                                                            
                                </tr>
                                <tr id="gen">
                                	<td>&nbsp;Hidung *</td>
                                    <td>&nbsp;
                                    <textarea id="kHidung" name="kHidung" cols="35"></textarea>
                                    </td> 
                                    <td>&nbsp;Tenggorok *</td>
                                    <td>&nbsp;<textarea id="kTenggorokan" name="kTenggorokan" cols="35"></textarea>
                                    </td>                                                            
                                </tr>
                                <tr id="gen">
                                	<td>&nbsp;Usul Tindakan Lanjut / Anjuran *</td>
                                    <td>&nbsp;
                                    <textarea id="uTinLanjut" name="uTinLanjut" cols="35"></textarea>
                                    </td> 
                                    <td>&nbsp;</td>
                                    <td>&nbsp;
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
                            <table width="100%">-->
                            <tr style="display:none">
                                <td>
                                	<fieldset>
    									<legend id="lgnIsiDataRM">III. Pemeriksaan Neurologi
                            <input type="button" size="3" id="btnShowKunjDown" value="&or;" style="display:inline;cursor:pointer;" onClick="document.getElementById('pNeurologi').style.height='400px';this.style.display='none';document.getElementById('btnShowKunjUp').style.display='inline';"/>
                            <input type="button" size="3" id="btnShowKunjUp" value="&and;" style="display:none;cursor:pointer;" onClick="document.getElementById('pNeurologi').style.height='0px';this.style.display='none';document.getElementById('btnShowKunjDown').style.display='inline';"/>
                            </legend>
                             <div id="pNeurologi" align="center" style="overflow:auto;height:0px;">
                        		<table width="100%">
                                    <tr>
                                        <td>Pupil</td>
                                        <td>&nbsp;<input type="radio" id="pup1" class="pup1" name="pupil1" onclick="cekR(pup2)" /> Dbn<br />
                                        	&nbsp;<input type="radio" id="pup2" class="pup2" name="pupil1" onclick="cekR(pup2)" /> Bentuk
                                             <input type="text" id="bentukP" class="bentukP" value="" disabled="disabled" /> <br />
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ukuran 
                                            <input type="text" id="ukuranP" class="ukuranP" value="" disabled="disabled" /> <br />
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Reflek Cahaya 
                                            <input type="text" id="cahayaP" class="cahayaP" value="" disabled="disabled" />
                                        </td>
                                        <td id="ab">Tanda Rangsang Meningeal</td>
                                        <td id="ab">&nbsp;<input type="radio" id="pup3" class="pup3" name="pupil2" onclick="cekR(pup3)" />Dbn <br />
                                        			&nbsp;<input type="radio" id="pup4" class="pup4" name="pupil2" onclick="cekR(pup4)" />Kaku Kuduk <input type="text" id="kakuP" class="kakuP" value="" disabled="disabled" /><br />
                                                    &nbsp;<input type="radio" id="pup5" class="pup5" name="pupil2" onclick="cekR(pup5)" />Laseque <input type="text" id="lasequeP" class="lasequeP" value="" disabled="disabled" /> <br />
                                                    &nbsp;<input type="radio" id="pup6" class="pup6" name="pupil2" onclick="cekR(pup6)" />Kerning <input type="text" id="karningP" class="karningP" value="" disabled="disabled" /> <br />
                                        </td>                                            
                                    </tr>
                                    <tr>
                                        <td>Nervi Cranialis</td>
                                        <td>&nbsp;<input type="radio" id="pup7" class="pup7" name="pupil3" onclick="cekR(pup8)" /> Dbn<br />
                                        	&nbsp;<input type="radio" id="pup8" class="pup8" name="pupil3" onclick="cekR(pup8)" /> Paresis <input type="text" id="persisP" class="persisP" value="" disabled="disabled" />
                                        </td>
                                        <td id="ab">Motorik</td>
                                        <td id="ab">
                                         <table width="100%">
                                            	<tr>
                                                	<td style="border-bottom:1px solid #000; border-right:1px solid #000;"><input type="text" id="mkiriatasP" class="mkiriatasP" value="" /></td>
                                                    <td style="border-bottom:1px solid #000;"><input type="text" id="mkananatasP" class="mkananatasP" value="" /></td>
                                                </tr>
                                                <tr>
                                                	<td style="border-right:1px solid #000;"><input type="text" id="mkiribawahP" class="mkiribawahP" value="" /></td>
                                                    <td style=""><input type="text" id="mkananbawahP" class="mkananbawahP" value="" /></td>
                                                </tr>
                                            </table>
                                        </td>                                            
                                    </tr>
                                    <tr>
                                        <td>Reflek Fisiologis</td>
                                        <td>
                                        <table width="100%">
                                            	<tr>
                                                	<td style="border-bottom:1px solid #000; border-right:1px solid #000;"><input type="text" id="rkiriatasP" class="rkiriatasP" value="" /></td>
                                                    <td style="border-bottom:1px solid #000;"><input type="text" id="rkananatasP" class="rkananatasP" value="" /></td>
                                                </tr>
                                                <tr>
                                                	<td style="border-right:1px solid #000;"><input type="text" id="rkiribawahP" class="rkiribawahP" value="" /></td>
                                                    <td style=""><input type="text" id="rkananbawahP" class="rkananbawahP" value="" /></td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td id="ab">Reflek Patologis</td>
                                        <td id="ab">&nbsp;<textarea id="cmbPatologis" name="cmbPatologis" cols="35"></textarea>
                                        </td>                                            
                                    </tr>
                                    <tr>
                                        <td>Sensorik</td>
                                        <td>
                                        &nbsp;<input type="radio" id="pup9" class="pup9" name="pupil4" onclick="cekR(pup10)" /> Dbn<br />
                                        	&nbsp;<input type="radio" id="pup10" class="pup10" name="pupil4" onclick="cekR(pup10)" /> <input type="text" id="sensorikP" class="sensorikP" value="" disabled="disabled" />
                                        </td>
                                        <td id="ab">Otonom</td>
                                        <td id="ab">
                                        &nbsp;<textarea id="cmbOtonom" name="cmbOtonom" cols="35"></textarea> 
                                        </td>                                            
                                    </tr>
                                    <tr>
                                        <td>Pemeriksaan Khusus</td>
                                        <td>
                                        &nbsp;<textarea id="cmbPKhusus" name="cmbPKhusus" cols="35"></textarea>
                                        </td>
                                        <td id="ab"></td>
                                        <td id="ab"></td>   
                                    </tr>
                                </table>
                            </div>      
                                    </fieldset>
                                </td>
                            </tr>
                            </table>
                            <table width="100%">
                            <tr style="display:none">
                                <td>
                                	<fieldset>
    									<legend id="lgnIsiDataRM">IV. Pemeriksaan Anak *
                            <input type="button" size="3" id="btnShowKunjDown1" value="&or;" style="display:inline;cursor:pointer;" onClick="document.getElementById('pAnak').style.height='150px';this.style.display='none';document.getElementById('btnShowKunjUp1').style.display='inline';"/>
                            <input type="button" size="3" id="btnShowKunjUp1" value="&and;" style="display:none;cursor:pointer;" onClick="document.getElementById('pAnak').style.height='0px';this.style.display='none';document.getElementById('btnShowKunjDown1').style.display='inline';"/>
                            </legend>
                             <div id="pAnak" align="center" style="overflow:auto;height:0px;">
                        		<table width="100%">
                                    <tr>
                                        <td>Riwayat Kelahiran</td>
                                        <td>&nbsp;<textarea id="rKelahiran" name="rKelahiran" cols="35"></textarea>
                                        </td>
                                        <td id="ab">Riwayat Imunisasi</td>
                                        <td id="ab">&nbsp;<textarea id="rImunisasi" name="rImunisasi" cols="35"></textarea>
                                        </td>                                            
                                    </tr>
                                    <tr>
                                        <td>Riwayat Nutrisi</td>
                                        <td>&nbsp;<textarea id="rNutrisi" name="rNutrisi" cols="35"></textarea>
                                        </td>
                                        <td id="ab">Riwayat Tumbuh Kembang</td>
                                        <td id="ab">
                                         &nbsp;<textarea id="rTumbuhKembang" name="rTumbuhKembang" cols="35"></textarea>
                                        </td>                                            
                                    </tr>
                                    <!--<tr>
                                        <td>&nbsp;</td>
                                      <td>&nbsp;</td>
                                        <td id="ab">&nbsp;</td>
                                        <td id="ab">&nbsp; </td>                                            
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td><br /></td>
                                        <td id="ab">&nbsp;</td>
                                        <td id="ab">
                                        &nbsp; </td>                                            
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>
                                        &nbsp; </td>
                                        <td id="ab"></td>
                                        <td id="ab"></td>   
                                    </tr>-->
                                </table>
                            </div>      
                                    </fieldset>
                                </td>
                            </tr>
                            </table>
                            <table width="100%">
                            <tr style="display:none">
                                <td>
                                	<fieldset>
    									<legend id="lgnIsiDataRM">IV. Pemeriksaan Paru *
                            <input type="button" size="3" id="btnShowKunjDown2" value="&or;" style="display:inline;cursor:pointer;" onClick="document.getElementById('pParu').style.height='150px';this.style.display='none';document.getElementById('btnShowKunjUp2').style.display='inline';"/>
                            <input type="button" size="3" id="btnShowKunjUp2" value="&and;" style="display:none;cursor:pointer;" onClick="document.getElementById('pParu').style.height='0px';this.style.display='none';document.getElementById('btnShowKunjDown2').style.display='inline';"/>
                            </legend>
                             <div id="pParu" align="center" style="overflow:auto;height:0px;">
                        		<table width="100%">
                                    <tr>
                                        <td>Riwayat OAT</td>
                                        <td>&nbsp;<textarea id="rOAT" name="rOAT" cols="35"></textarea>
                                        </td>
                                        <td id="ab">Riwayat Asma</td>
                                        <td id="ab">&nbsp;<textarea id="rAsma" name="rAsma" cols="35"></textarea>
                                        </td>                                            
                                    </tr>
                                    <tr>
                                        <td>Riwayat Merokok</td>
                                        <td>&nbsp;<textarea id="rMerokok" name="rMerokok" cols="35"></textarea>
                                        </td>
                                        <td id="ab">&nbsp;</td>
                                        <td id="ab">&nbsp;
                                         </td>                                            
                                    </tr>
                                    <!--<tr>
                                        <td>&nbsp;</td>
                                      <td>&nbsp;</td>
                                        <td id="ab">&nbsp;</td>
                                        <td id="ab">&nbsp; </td>                                            
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td><br /></td>
                                        <td id="ab">&nbsp;</td>
                                        <td id="ab">
                                        &nbsp; </td>                                            
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>
                                        &nbsp; </td>
                                        <td id="ab"></td>
                                        <td id="ab"></td>   
                                    </tr>-->
                                </table>
                            </div>      
                                    </fieldset>
                                </td>
                            </tr>
                            </table>
                            <table width="100%">
                            <tr style="display:none">
                                <td>
                                	<fieldset>
    									<legend id="lgnIsiDataRM">V. Pemeriksaan THT *
                            <input type="button" size="3" id="btnShowKunjDown3" value="&or;" style="display:inline;cursor:pointer;" onClick="document.getElementById('pTht').style.height='120px';this.style.display='none';document.getElementById('btnShowKunjUp3').style.display='inline';"/>
                            <input type="button" size="3" id="btnShowKunjUp3" value="&and;" style="display:none;cursor:pointer;" onClick="document.getElementById('pTht').style.height='0px';this.style.display='none';document.getElementById('btnShowKunjDown3').style.display='inline';"/>
                            </legend>
                             <div id="pTht" align="center" style="overflow:auto;height:0px;">
                        		<table width="100%">
                                    <tr>
                                        <td>KU</td>
                                        <td>&nbsp;<textarea id="rKU" name="rKU" cols="35"></textarea>
                                        </td> 
                                        <td id="ab">RPS< RPD</td>
                                        <td id="ab">&nbsp;<textarea id="rpsd" name="rpsd" cols="35"></textarea>
                                        </td>                                            
                                    </tr>
                                    <!--<tr>
                                        <td>&nbsp;</td>
                                      <td>&nbsp;</td>
                                        <td id="ab">&nbsp;</td>
                                        <td id="ab">&nbsp; </td>                                            
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td><br /></td>
                                        <td id="ab">&nbsp;</td>
                                        <td id="ab">
                                        &nbsp; </td>                                            
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>
                                        &nbsp; </td>
                                        <td id="ab"></td>
                                        <td id="ab"></td>   
                                    </tr>-->
                                </table>
                            </div>      
                                    </fieldset>
                                </td>
                            </tr>
                            </table>
                            <table width="100%">
                            <tr style="display:none">
                                <td>
                                	<fieldset>
    									<legend id="lgnIsiDataRM">V. Pemeriksaan Obgyn *
                            <input type="button" size="3" id="btnShowKunjDown4" value="&or;" style="display:inline;cursor:pointer;" onClick="document.getElementById('pObgyn').style.height='120px';this.style.display='none';document.getElementById('btnShowKunjUp4').style.display='inline';"/>
                            <input type="button" size="3" id="btnShowKunjUp4" value="&and;" style="display:none;cursor:pointer;" onClick="document.getElementById('pObgyn').style.height='0px';this.style.display='none';document.getElementById('btnShowKunjDown4').style.display='inline';"/>
                            </legend>
                             <div id="pObgyn" align="center" style="overflow:auto;height:0px;">
                        		<table width="100%">
                                    <tr>
                                        <td>GPA</td>
                                        <td>&nbsp;<textarea id="rGPA" name="rGPA" cols="35"></textarea>
                                        </td> 
                                        <td id="ab">&nbsp;</td>
                                        <td id="ab">&nbsp;
                                        </td>                                            
                                    </tr>
                                    <!--<tr>
                                        <td>&nbsp;</td>
                                      <td>&nbsp;</td>
                                        <td id="ab">&nbsp;</td>
                                        <td id="ab">&nbsp; </td>                                            
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td><br /></td>
                                        <td id="ab">&nbsp;</td>
                                        <td id="ab">
                                        &nbsp; </td>                                            
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>
                                        &nbsp; </td>
                                        <td id="ab"></td>
                                        <td id="ab"></td>   
                                    </tr>-->
                                </table>
                            </div>      
                                    </fieldset>
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