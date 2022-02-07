<div id="divRujukRS" style="display:none;width:700px" class="popup">
    <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" />
  <fieldset><legend>Catatan KRS</legend>
        <table border=0 width="660">
            <tr>
                <td width="200" align="right">Cara Keluar :</td>
                <td>
                    <select id="cmbCaraKeluar" class="txtinput" onchange="caraKeluar(this.value);"></select>
                </td>
            </tr>
            <tr id="trKeadaanKeluar">
                <td align="right">Keadaan Keluar :</td>
                <td>
                    <select id="cmbKeadaanKeluar" class="txtinput" onchange="fKeadaanKeluarChange(this);">
                        <option value="Perlu kontrol kembali" lang="0">Perlu kontrol kembali</option>
                        <option value="Sembuh" lang="1">Sembuh</option>
                    </select>                            </td>
            </tr>
            <tr id="trTglKontrol" style="visibility:collapse">
                <td align="right">Tgl Kontrol :</td>
                <td>
                    <input type="text" class="txtcenter" readonly="readonly" name="TglKontrol" id="TglKontrol" size="11" value="<?php echo $date_now;?>"/>
                <input type="button" id="btnTglKontrol" name="btnTglKontrol" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('TglKontrol'),depRange);" />                            </td>
            </tr>
            <tr id="trPoliKontrol" style="visibility:collapse">
                <td align="right">Poli Kontrol :</td>
                <td>
                    <select id="cmbPoliKontrol" class="txtinput" onchange="">
                    </select>                            </td>
            </tr>
            <tr>
                <td align="right">Kasus :</td>
                <td>
                    <select id="cmbKasus" class="txtinput">
                        <option value="1">Baru</option>
                        <option value="0">Lama</option>
                    </select>                            </td>
            </tr>
            <tr id="trEmergency">
                <td align="right">Status Emergency :</td>
                <td>
                    <select id="cmbEmergency" class="txtinput"></select>                            </td>
            </tr>
            <tr id="trKondisiPasien">
                <td align="right">Kondisi Pasien :</td>
                <td>
                    <select id="cmbKondisiPasien" class="txtinput"></select>                            </td>
            </tr>
            <tr id="trkrs1" style="display:none">
                <td align="right">Tanggal KRS :</td>
                <td>
                <input type="text" class="txtcenter" readonly="readonly" name="TglKrs" id="TglKrs" size="11" value="<?php echo $date_now;?>"/>
                <input type="button" id="btnTglKrs" name="btnTglKrs" value=" V " class="txtcenter" disabled="disabled" onClick="gfPop.fPopCalendar(document.getElementById('TglKrs'),depRange);" />                            </td>
            </tr>
            <tr id="trkrs2" style="display:none">
                <td align="right">Jam Pulang :</td>
                <td>
                <input type="text" class="txtcenter" readonly="readonly" name="JamKrs" id="JamKrs" size="5" maxlength="5" value=""/>
                <label><input type="checkbox" id="chkManualKrs" name="chkManual" <?php echo $DisableBD; ?> onclick="setManual('krs')"/>set manual</label>                            </td>
            </tr>
            <tr id="trRujukRS" style="visibility:collapse">
                <td width="162" align="right">RS Rujukan :</td>
                <td >
                    <select name="cmbRS" id="cmbRS" tabindex="26" class="txtinput" onchange=""></select>                            </td>
            </tr>
            <tr id="trRujukRSKet" style="visibility:collapse">
                <td align="right">Keterangan Rujuk :</td>
                <td>
                    <textarea id="txtKetRujukRS" name="txtKetRujukRS"  cols="35" rows="2" class="txtinput"></textarea>                            </td>
            </tr>
            <tr>
                <td align="right">Dokter :</td>
                <td>
                    <select id="cmbDokRujukRS" name="cmbDokRujukRS" class="txtinput" onchange="setDok(this.value)">
                        <option value="">-Dokter-</option>
                    </select>
                    <label style="display:none"><input type="checkbox" id="chkDokterPenggantiRujukRS" value="1" onchange="gantiDokter('cmbDokRujukRS',this.checked);"/>Dokter Pengganti</label>                            </td>
            </tr>
        </table>
        <table>
            <tr>
                <td colspan="2" align="center">
                    <input type="hidden" id="idRujukRS" name="idRujukRS"/>
                    <input type="button" id="btnSimpanRujukRS" name="btnSimpanRujukRS" value="Tambah" onclick="fSimpanRujukRS(this.value,this.id);" class="tblTambah"/>
                    <input type="button" id="btnHapusRujukRS" name="btnHapusRujukRS" value="Hapus" onclick="fHapusRujukRS(this.id);" disabled="disabled" class="tblHapus"/>
                    <input type="button" id="btnBatalRujukRS" value="Batal" onclick="fBatalRujukRS(this.id)" class="tblBtn" />
                    <input type="button" id="btnCetakKRS" name="btnCetakKRS" value="Cetak KRS" onclick="cetakKRS()" class="tblBtn" style="display:none;"/>
                    <!--input type="button" id="btnSpInap" name="btnSpInap" value="SP Inap" class="tblBtn" onclick="window.open('krs.php','_blank')" /-->                            </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2">
                    <div id="gridboxRujukRS" style="width:650px; height:150px; padding-bottom:10px; background-color:white;"></div>
                    <div id="pagingRujukRS" style="width:650px;"></div>                            </td>
            </tr>
        </table>
  </fieldset>
</div>
<script>
function fSimpanRujukRS(action,id,cek){
	var privilege='<?php echo $privilege; ?>';
	var privilege_all='<?php echo $privilege_all; ?>';
	var userId='<?php echo $_SESSION['userId']; ?>';
	var idRS = document.getElementById("cmbRS").value;
	var ketRujukRS = document.getElementById("txtKetRujukRS").value;
	var idDokRujukRS = document.getElementById("cmbDokRujukRS").value;
	var idRujukRS = document.getElementById("idRujukRS").value;
	var caraKeluar = document.getElementById("cmbCaraKeluar").value;
	var keadaanKeluar = document.getElementById("cmbKeadaanKeluar").value;
	var kasus = document.getElementById("cmbKasus").value;
	var emergency = document.getElementById("cmbEmergency").value;
	var kondisiPasien = document.getElementById("cmbKondisiPasien").value;
	var tglKrs = document.getElementById('TglKrs').value;
	var jamKrs = document.getElementById("JamKrs").value.replace(' ','');
	var isManual = document.getElementById('chkManual').checked;
	var tgl_kontrol='NULL';
	var unitIdKontrol='0';
	if(grdKrs.getRowId(grdKrs.getSelRow())!=''){
		alert("Satu pasien hanya bisa di-KRS-kan satu kali.");
		return false;
	}
	if(document.getElementById('trRujukRS').style.visibility!='visible'){
		idRS=0;
	}
	if(document.getElementById('trTglKontrol').style.visibility=='visible'){
		//alert(document.getElementById('TglKontrol').value);
		tgl_kontrol=document.getElementById('TglKontrol').value;
		unitIdKontrol=document.getElementById('cmbPoliKontrol').value;
	}
	if(ValidateForm("JamKrs",'ind')){
		document.getElementById(id).disabled = true;
		var jamSplit=jamKrs.split(':');
		if(jamSplit.length!=2){
			alert('Format Jam Salah!');
			return false;
		}
		if(isNaN(jamSplit[0]) || isNaN(jamSplit[1]) || jamSplit[0]=='' || jamSplit[1]==''  || jamSplit[0].length!=2 || jamSplit[1].length!=2){
			alert('Format Jam Salah!');
			return false;
		}
		url = "krs/krs_utils.php?grd3=true&act="+action+"&smpn="+id+"&id="+idRujukRS+"&kunjungan_id="+getIdKunj+"&pelayanan_id="+getIdPel+"&isManual="+document.getElementById('chkManualKrs').checked+"&tglKrs="+tglKrs+"&jamKrs="+jamKrs+"&caraKeluar="+caraKeluar+"&keadaanKeluar="+keadaanKeluar+"&kasus="+kasus+"&emergency="+emergency+"&kondisi="+kondisiPasien+"&ket="+ketRujukRS+"&idDok="+idDokRujukRS+"&idRS="+idRS+"&tgl_kontrol="+tgl_kontrol+"&unitIdKontrol="+unitIdKontrol+"&userId="+userId;
		//alert(url);
		grdKrs.loadURL(url,"","GET");
		fSetValue(window,'btnHapusRujukRS*-*true');
		document.getElementById('txtKetRujukRS').value = '';
	}
}

function fHapusRujukRS(id){
	var rowidRujukRS = document.getElementById("idRujukRS").value;
	var userId='<?php echo $_SESSION['userId']?>';
	if(confirm("Anda yakin menghapus KRS ini?")){
		document.getElementById(id).disabled = true;
		//alert("krs/krs_utils.php?grd3=true&act=hapus&hps="+id+"&kunjungan_id="+getIdKunj+"&rowid="+rowidRujukRS+"&userId="+userId);
		grdKrs.loadURL("krs/krs_utils.php?grd3=true&act=hapus&hps="+id+"&kunjungan_id="+getIdKunj+"&pelayanan_id="+getIdPel+"&rowid="+rowidRujukRS+"&userId="+userId,"","GET");
		fSetValue(window,'btnHapusRujukRS*-*true');
		document.getElementById('txtKetRujukRS').value = '';
	}
}

function fBatalRujukRS(id){
	var p = "idRujukRS*-**|*btnSimpanRujukRS*-*Tambah*|*chkManualKrs*-*false*|*btnSimpanRujukRS*-*false*|*btnHapusRujukRS*-*true";
	fSetValue(window,p);
	document.getElementById('txtKetRujukRS').value = '';
}

function ambilDataRujukRS(){
	//alert(grdKrs.getRowId(grdKrs.getSelRow()));
	//cmbEmergency cmbKondisiPasien     chkDokterPenggantiRujukRS
	var sisipan=grdKrs.getRowId(grdKrs.getSelRow()).split("|");
	var waktu = grdKrs.cellsGetValue(grdKrs.getSelRow(),2).split(' ');
	waktu[1] = waktu[1].substr(0,5);
	document.getElementById('chkManualKrs').checked = true;
	caraKeluar(grdKrs.cellsGetValue(grdKrs.getSelRow(),3));
	var p ="idRujukRS*-*"+sisipan[0]+"*|*cmbRS*-*"+sisipan[1]+"*|*cmbDokRujukRS*-*"+sisipan[2]+"*|*cmbCaraKeluar*-*"+grdKrs.cellsGetValue(grdKrs.getSelRow(),3)+"*|*TglKrs*-*"+waktu[0]+"*|*JamKrs*-*"+waktu[1]+"*|*cmbKeadaanKeluar*-*"+sisipan[4]+"*|*cmbKasus*-*"+sisipan[5]+"*|*cmbRS*-*"+sisipan[1]+"*|*btnHapusRujukRS*-*false";
	fSetValue(window,p);
	//alert(sisipan[4]);
	if (sisipan[4]=="0"){
		document.getElementById('txtKetRujukRS').innerHTML = grdKrs.cellsGetValue(grdKrs.getSelRow(),10);
	}else{
		document.getElementById('txtKetRujukRS').innerHTML = "";
	}
}

function caraKeluar(val){
	document.getElementById('trKeadaanKeluar').style.visibility='visible';
	if(val=="Dirujuk"){ /*dirujuk ke RS*/
		//document.getElementById('tabel_rs').style.visibility='visible';
		document.getElementById('trRujukRS').style.visibility='visible';
		document.getElementById('trRujukRSKet').style.visibility='visible';
		document.getElementById('cmbKeadaanKeluar').innerHTML='<option value="dirujuk">dirujuk</option>';
		document.getElementById('btnCetakKRS').style.display='table-cell';
	}
	else if(val == "Meninggal"){/*meninggal*/
		//document.getElementById('tabel_rs').style.visibility='collapse';
		document.getElementById('trRujukRS').style.visibility='collapse';
		document.getElementById('trRujukRSKet').style.visibility='collapse';
		// <option value='Meninggal'>Meninggal</option>
		document.getElementById('cmbKeadaanKeluar').innerHTML="<option value='Meninggal < 48 jam'>Meninggal < 48 jam</option><option value='Meninggal > 48 jam'>Meninggal > 48 jam</option><option value='Meninggal sebelum dirawat'>Meninggal sebelum dirawat</option>";
		document.getElementById('btnCetakKRS').style.display='none';
	}
	else if(val == "Pulang Paksa"){/*Pulang Paksa*/
		//document.getElementById('tabel_rs').style.visibility='collapse';
		document.getElementById('trRujukRS').style.visibility='collapse';
		document.getElementById('trRujukRSKet').style.visibility='collapse';
		document.getElementById('cmbKeadaanKeluar').innerHTML="<option value='Karena Biaya'>Karena Biaya</option><option value='Karena Keluarga'>Karena Keluarga</option><option value='Karena Keadaan Pasien'>Karena Keadaan Pasien</option><option value='Karena Pelayanan'>Karena Pelayanan</option>";
		document.getElementById('btnCetakKRS').style.display='none';
	}
	else if(val == "MRS"){/*MRS*/
		document.getElementById('trRujukRS').style.visibility='collapse';
		document.getElementById('trRujukRSKet').style.visibility='collapse';
		document.getElementById('cmbKeadaanKeluar').innerHTML='<option value="Perlu perawatan lanjutan">Perlu perawatan lanjutan</option><option value="Perlu kontrol kembali">Perlu kontrol kembali</option><option value="Sembuh">Sembuh</option>';
		document.getElementById('btnCetakKRS').style.display='none';
	}
	else if(val == "Melarikan Diri"){/*Melarikan Diri*/
		document.getElementById('trRujukRS').style.visibility='collapse';
		document.getElementById('trRujukRSKet').style.visibility='collapse';
		document.getElementById('trKeadaanKeluar').style.visibility='collapse';
		document.getElementById('cmbKeadaanKeluar').innerHTML='<option value="Melarikan Diri">Melarikan Diri</option>';
		document.getElementById('btnCetakKRS').style.display='none';
	}
	else{
		document.getElementById('cmbKeadaanKeluar').innerHTML='<option value="Perlu kontrol kembali" lang="0">Perlu kontrol kembali</option><option value="Sembuh" lang="1">Sembuh</option>';
		//document.getElementById('tabel_rs').style.visibility='collapse';
		document.getElementById('trRujukRS').style.visibility='collapse';
		document.getElementById('trRujukRSKet').style.visibility='collapse';
		document.getElementById('btnCetakKRS').style.display='none';
	}
	fKeadaanKeluarChange(document.getElementById('cmbKeadaanKeluar'));
}

function fKeadaanKeluarChange(obj){
	var opt=obj.options[obj.options.selectedIndex].lang;
	//alert(opt);
	fKeadaanKeluarChangeOpt(opt);
}

function fKeadaanKeluarChangeOpt(opt){
	//alert(opt);
	if (opt=="0"){
		document.getElementById('trTglKontrol').style.visibility='visible';
		document.getElementById('trPoliKontrol').style.visibility='visible';
	}else{
		document.getElementById('trTglKontrol').style.visibility='collapse';
		document.getElementById('trPoliKontrol').style.visibility='collapse';
	}
}

function cetakKRS(){
	window.open('krs.php','_blank');
}

function konfirmasiKrs(key,val){
	var tangkap,proses,tombolSimpan,tombolHapus,msg,id_tindakan_radiologi,pesan;
	//alert(val+'-'+key);
	if (val!=undefined){
		tangkap=val.split("*|*");
		proses=tangkap[0];
		/*tombolSimpan=tangkap[1];
		tombolHapus=tangkap[2];
		msg=tangkap[3];*/
	}
	//alert(proses+'-'+key);
	if(key=='Error'){
		if(proses=='tambah'){
			alert("Gagal Memasukan Data ke Database.");
		}
		else if(proses=='simpan'){
			alert('Simpan Gagal');
		}
		else if(proses=='hapus'){
			alert('Hapus gagal.');
		}
	}
	else{
		if(proses=='tambah'){
			alert('Simpan Berhasil');
		}
		else if(proses=='simpan'){
			alert('Simpan Berhasil');
		}
		else if(proses=='hapus'){
			alert('Hapus Berhasil');
		}
	}
	fBatalRujukRS();
}
</script>