<link rel="stylesheet" type="text/css" href="button.css">			    
					<input type="button" id="btnRujukUnit" name="btnRujukUnit" value="KONSUL" onclick="rujukUnit(this.value)" class="button"/>
					
                   <div  style="display:none;">
				   
				    <input type="button" id="btnKonDok" name="btnKonDok" value="KONSUL DOKTER" onclick="konsulDokter()" class="button"/>
					
					</div>
					
					<input type="button" id="btnRujukRS" name="btnRujukRS" value="KRS" onclick="rujukRS()" class="button"/>
				    
					<!--input type="button" id="btnRekamMds" name="btnRekamMds" value="REKAM MEDIS" onclick="rekamMedis()" class="button"/-->
					<input type="button" id="btnRekamMds" name="btnRekamMds" value="RIWAYAT PASIEN" onclick="rekamMedis()" class="button"/>
					<input type="button" id="btnSetKamar" name="btnSetKamar" value="PINDAH KAMAR" onclick="setKamar()" style="display:none;" class="button"/>
				   
				<!--	<input type="button" id="btnMutasi" name="btnMutasi" value="RUJUK"  onclick="konsulDokter();" class="button"/>-->
<!--                    <input type="button" id="btnMutasi" name="btnMutasi" value="MUTASI" onclick="setMutasi();" class="button"/>-->
					<input type="button" id="btnMRS" name="btnMRS" value="MRS" onclick="rujukUnit(this.value)" class="button"/>
				   
					<input type="button" id="btnResume" name="btnResume" value="RESUME MEDIS" onclick="resumeMedis()" class="button"/>
					<input type="button" id="btnVer" name="btnVer" value="VERIFIKASI INAP" class="button" onclick="window.open('verifikasiInap.php?idKunj='+getIdKunj+'&idUnit='+getIdUnit,'_blank')" style="display:none" />
				   
					<input type="button" id="btnCtkRincian" name="btnCtkRincian" value="RINCIAN TINDAKAN" style="cursor:pointer" onMouseOver="MM_showMenu(window.mm_menu_0814123211_0,0,20,null,'btnCtkRincian');" onMouseOut="MM_startTimeout();" class="button"/>
					<input type="button" id="btnLab" name="btnLab" value="NOMOR SPESIMEN" onclick="cetakLab();" class="button"/>
					<!--input type="button" id="btnLab2" name="btnLab2" value="NOMOR REGISTRASI" onclick="cetakLab2();" class="tblBtn"/-->
				    
                    <input type="button" id="btnIzin" name="btnIzin" value="SURAT KETERANGAN" onclick="cetakIzin();" class="button"/>
                    
					<input name="UpdStatusPx" id="UpdStatusPx" type="button" value="UBAH STATUS Px" class="button" onclick="PopUpdtStatus();" />
					<input name="ctkVis" id="ctkVis" type="button" value="CETAK VISITE" class="button" onclick="ctkVis();" />
					<input type="button" id="btnPasienPulang" name="btnPasienPulang" value="PASIEN PULANG" onclick="simpan(this.value,this.id);" class="button" style="display:none;"/>
                            
			    <input type="button" id="btnBatalPulang" name="btnBatalPulang" value="PASIEN BATAL PULANG" onclick="hapus(this.id);" class="button"/>
                <!--input type="button" id="btnIsiDataRM" name="btnIsiDataRM" value="ISI DATA RM" onclick="isiDataRM();" class="tblBtn"/-->
			    <input type="button" id="btnDarah" name="btnDarah" value="PERMINTAAN DARAH" class="button" onclick="isiMintaDarah()" style="display:none" />
                <input type="button" id="ctkLab" name="ctkLab" value="HASIL LAB" onclick="viewListKonsul(57);" class="button"/><!--cetakHasilLabAll()-->
				<input type="button" id="htrLab" name="htrLab" value="HISTORY HASIL LAB" onclick="viewListKonsul('history');" class="button"/>
                <input type="button" id="ctkRad" name="ctkLab" value="HASIL RADIOLOGI" onclick="cetakHasilRadAll();" class="button"/>
                <input type="button" id="ctkAmpRad" name="ctkLab" value="CETAK AMPLOP RADIOLOGI" onclick="cetakAmplopRad();" class="button"/><br/>
				<input type="button" id="btnCtkFrm" name="btnCtkFrm" value="REPORT RM" style="cursor:pointer" onMouseOver="MM_showMenu(window.mm_menu_0814123211_5,0,20,null,'btnCtkFrm');" onMouseOut="MM_startTimeout();" class="button"/>
                <div style="display:none"><input type="button" id="btnIsiDataRM12" name="btnIsiDataRM" value="ANAMNESA &amp; PEMERIKSAAN FISIK" onclick="isiAnamnesa();" class="button"/></div>
                <div style="display:none"><input type="button" id="btnIsiDataRM13" name="btnIsiDataRM" value="SOAPIER" onclick="isiSOAPIER();" class="button"/></div>
                <input type="button" style="display:none;" id="btnIsiDataRM14" name="btnIsiDataRM" value="LOCK TINDAKAN" onclick="keluar12();" class="button" />
                <input type="button" id="btnIsiDataRM15" name="btnIsiDataRM" value="PERLAKUAN KHUSUS" onclick="tampilPerlakuan();" class="button" />
                <input type="button" id="btnIsiDataRM16" name="btnIsiDataRM" value="TATA TERTIB RAWAT INAP" onclick="tatib();" class="button" />
                <input type="button" id="btnCekOut" name="btnCekOut" value="CHECK OUT" onclick="simpan(this.value,this.id);" class="button"/>
                <input type="button" id="btnCCekOut" name="btnCCekOut" value="CANCEL CHECK OUT" onclick="simpan(this.value,this.id);" class="button"/>
                <!--input type="button" id="btnIsiDataRM17" name="btnIsiDataRM" value="SURAT BALASAN KONSUL" onclick="balasan();" class="button" /-->
				<input type="button" id="btnIsiDataRM18" name="btnIsiDataRM" value="BATAL BERKUNJUNG" <?php echo $disableKunj; ?> onclick="kunjung();" class="button" />
                <input style="display:none;" type="button" id="btnIsiDataRM19" name="btnIsiDataRM" value="JADI BERKUNJUNG"  <?php echo $disableKunj; ?> onclick="kunjung1();" class="button" />
                <input type="button" id="sampel" name="sampel" value="PENGAMBILAN SAMPEL LAB" onclick="sampel();" class="button" />
                 <input type="button" id="sampel1" name="sampel1" value="PENGGUNAAN LIST PEMERIKSAAN" onclick="sListPemeriksaan();" class="button" />
                <input style="display:none;" type="button" id="validasi" name="validasi" value="VALIDASI PEMERIKSAAN LAB" onclick="validasi();" class="button" />
                <input type="button" id="workList" name="workList" value="MODALITY WORK LIST RADIOLOGI" onclick="workList();" class="button" style="display:none;" />
                <input type="button" id="rawatbersama" name="btnIsiDataRM" value="RAWAT BERSAMA" onclick="rawatbrg();" class="button" />