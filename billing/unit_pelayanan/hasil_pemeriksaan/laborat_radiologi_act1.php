<script>
function suggestHsl(e,par){
	var keywords=par.value;//alert(keywords);
	if(keywords=="" || keywords.length<3){
		document.getElementById('divtindakanHsl').style.display='none';
	}else{
		var key;
		if(window.event) {
			key = window.event.keyCode;
		}
		else if(e.which) {
			key = e.which;
		}
		//alert(key);
		if (key==38 || key==40){
			var tblRow=document.getElementById('tblTindakanHsl').rows.length;
			if (tblRow>0){
				//alert(RowIdx1);
				if (key==38 && RowIdx1>0){
					RowIdx1=RowIdx1-1;
					document.getElementById('lstTindHsl'+(RowIdx1+1)).className='itemtableReq';
					if (RowIdx1>0) document.getElementById('lstTindHsl'+RowIdx1).className='itemtableMOverReq';
				}
				else if (key == 40 && RowIdx1 < tblRow){
					RowIdx1=RowIdx1+1;
					if (RowIdx1>1) document.getElementById('lstTindHsl'+(RowIdx1-1)).className='itemtableReq';
					document.getElementById('lstTindHsl'+RowIdx1).className='itemtableMOverReq';
				}
			}
		}else if (key==13){
			//alert('masuk tindakan');
			if (RowIdx1>0){
				if (fKeyEnt1==false){
					fSetHsl(document.getElementById('lstTindHsl'+RowIdx1).lang);
				}
				else{
					fKeyEnt1=false;
				}
			}
		}else if (key!=27 && key!=37 && key!=39){
			RowIdx1=0;
			fKeyEnt1=false;
			var all=0;
			if(key==123){
				all=1;
			}
			
			Request("hasil_pemeriksaan/tindakanlist_lab.php?aKeyword="+keywords+"&pasienId="+getIdPasien+"&pelayananId="+getIdPel+"&lp="+document.getElementById('txtSex').value, 'divtindakanHsl', '', 'GET');
			if (document.getElementById('divtindakanHsl').style.display=='none')
				fSetPosisi(document.getElementById('divtindakanHsl'),par);
			document.getElementById('divtindakanHsl').style.display='block';
		}
	}
}

function fSetHsl(par){
	var cdata=par.split("|");
	document.getElementById("idNormal").value=cdata[0];
	document.getElementById("tindakan_id_hsl").value=cdata[8];
	document.getElementById("txtTind_hsl").value=cdata[2];
	document.getElementById("normal").innerHTML=cdata[3];
	document.getElementById('divtindakanHsl').style.display='none';
	
}

function cetakHslLabRad(){
	if (document.getElementById('ctkLabRadPerKonsul').value=="HASIL LAB"){
		cetakHsl();
	}else if (document.getElementById('ctkLabRadPerKonsul').value=="HASIL RAD"){
		cetakHasilRadAll();
	}
}

function cetakHsl(){
	window.open('hasil_pemeriksaan/hasil_laborat.php?idKunj='+getIdKunj+'&idPel='+getIdPel,'_blank');
}

function cetakHslRad(){
	if(document.getElementById("id_hasil_rad").value==''){
		alert('Pilih data yang mau dicetak');
		return false;
	}
	//var url = 'hasil_pemeriksaan/hasil_radiologi.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&id='+document.getElementById("id_hasil_rad").value;
	var url = 'hasil_pemeriksaan/hasil_radiologi_pdf.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&id='+document.getElementById("id_hasil_rad").value;
	//alert (url);
	window.open(url,'_blank');
}

function cetakHasilLabAll(){
	window.open('hasil_pemeriksaan/hasil_laborat_all.php?idKunj='+getIdKunj+'&idPel='+getIdPel,'_blank');
}

function cetakHasilRadAll(){
	window.open('hasil_pemeriksaan/hasil_radiologi_all.php?idKunj='+getIdKunj+'&idPel='+getIdPel,'_blank');
}

function hapus_foto_radiologi(a,b){
	if(b==1){ // 1=insert lagi
		Request('hasil_pemeriksaan/act_radiologi.php?act=delete&id='+a,'temp_rad','','GET',insertRadLagi(a),'noload');
	}
	else{
		Request('hasil_pemeriksaan/act_radiologi.php?act=delete&id='+a,'temp_rad','','GET');
	}
}

function insertRadLagi(a){
	var userId='<?php echo $_SESSION['userId']?>';
	tambahRadiologi = true;
	document.getElementById('frameRad').contentWindow.aplod('add',a,userId);
}

function afterRad(str){
	//alert(str);
	document.getElementById("id_hasil_rad").value="";
	document.getElementById("txtHslRad").value="";
	document.getElementById("cmbDokHslRad").selectedIndex="";
	document.getElementById("btnSimpanHslRad").value="Tambah";
	var p= "btnHapusHslRad*-*true";
	fSetValue(window,p);
	rad.loadURL("hasil_pemeriksaan/hasilRad_utils.php?grd=true&pelayanan_id="+getIdPel,"","GET");
}

function simpan_tanpa_gambar(act){
	var userId='<?php echo $_SESSION['userId']?>';		
	var id = document.getElementById("id_hasil_rad").value;
	var txtHslRad = document.getElementById("txtHslRad").value;
	var cmbDokHsl = document.getElementById("cmbDokHslRad").value;
						
	rad.loadURL("hasil_pemeriksaan/hasilRad_utils.php?grd=true&smpn=btnSimpanHslRad&pelayanan_id="+getIdPel+"&act="+act+"&id="+id+"&txtHslRad="+txtHslRad+"&cmbDokHsl="+cmbDokHsl+"&userId="+userId,"","GET");
}

function batalHsl(){
	var idTindHsl = document.getElementById("idTindHsl").value="";
	var tindakan_id_hsl = document.getElementById("tindakan_id_hsl").value="";
	var txtHsl = document.getElementById("txtHsl").value="";
	var txtKetHsl = document.getElementById("txtKetHsl").value="";
	var cmbDokHsl = document.getElementById("cmbDokHsl").selectedIndex="";
	var normal = document.getElementById("idNormal").value="";
	document.getElementById("normal").innerHTML="";
	document.getElementById("txtTind_hsl").value="";
	document.getElementById("btnSimpanHsl").value="Tambah";
	//document.getElementById("btnHapusHsl").style.disabled=false;
	var p= "btnHapusHsl*-*true";
	fSetValue(window,p);
}

function ambilDataHsl()
{
	var sisip = lab.getRowId(lab.getSelRow()).split("|");
	//alert(sisip);
	batalHsl();
	document.getElementById("idTindHsl").value=sisip[0];
	document.getElementById("tindakan_id_hsl").value=sisip[3];
	document.getElementById("txtHsl").value=sisip[2];
	document.getElementById("txtKetHsl").value=sisip[7];
	document.getElementById("cmbDokHsl").value=sisip[6];
	document.getElementById("idNormal").value=sisip[4];
	document.getElementById("normal").innerHTML=sisip[5];
	document.getElementById("txtTind_hsl").value=sisip[1];
	//btnSimpanTind*-*Simpan*|*btnHapusTind*-*false;
	document.getElementById("btnSimpanHsl").value="Simpan";
	//document.getElementById("btnHapusHsl").style.disabled=false;
	var p= "btnHapusHsl*-*false";
	fSetValue(window,p);
}

function lihatPemeriksaan(id){
	//alert('test');
	var tmpJnsLay = jQuery('#cmbJnsLay').val();
	var leg = "";
	var url = "";
	var view = "";
	if(tmpJnsLay == 60){
		//leg = "DATA PEMERIKSAAN RAD";
		//url = "hasil_pemeriksaan/tindak.php?cek=1&idPel="+id;
		Request('hasil_pemeriksaan/tindak.php?cek=1&idPel='+id , 'divtind', '', 'GET',function(){
			isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'','cmbDokHslD');
		});
		//jQuery("#tindak1").load("hasil_pemeriksaan/tindak.php?cek=1&idPel="+id);
	}else if(tmpJnsLay == 57){
		//leg = "DATA PEMERIKSAAN LAB";
		//url = "hasil_pemeriksaan/tindak.php?cek=2&idPel="+id;
		Request('hasil_pemeriksaan/tindak.php?cek=2&idPel='+id , 'divtind', '', 'GET',function(){
			isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'','cmbDokHslD');
		});
		//jQuery("#tindak1").load("hasil_pemeriksaan/tindak.php?cek=2&idPel="+id);
	}		
	new Popup('div_popup_tind',null,{modal:true,position:'top',duration:1});
	document.getElementById('div_popup_tind').popup.show();
	//load_popup_iframe_Tindak(leg,url,view);
}

function lihatPemeriksaan2(){
	//alert('test');
	var tmpJnsLay = jQuery('#cmbJnsLay').val();
	var idLabRad = getIdPel;
	if(tmpJnsLay == 60 || tmpJnsLay == 57){
		lihatPemeriksaan(idLabRad);
	}
}

function ambilLabAll()
{
	if(document.getElementById("LPemIDAll").checked==true)
	{
		jQuery(".LPemID").each(function(){
			jQuery(this).prop('checked', true);
		});
	}else{
		jQuery(".LPemID").each(function(){
			jQuery(this).prop('checked', false);
		});
	}
}

function ambilLab()
{
	tmpPilLab="";
	jQuery(".LPemID").each(function(){
		if(this.checked)
		{
			if(tmpPilLab=="")
			{
				tmpPilLab=jQuery(this).val();
			}else{
				tmpPilLab+="|"+jQuery(this).val();
			}
		}
	});
	
	var tmpPilLab1= tmpPilLab.split('|');
	tmpPilLab2 = tmpPilLab1.join();
	//alert(tmpPilLab2);
}

function LabRadAmbil(){
	var tmpJnsLay = jQuery('#cmbJnsLay').val();
	var cmbDokHsl = document.getElementById("cmbDokHsl").value;
	var Jkel = document.getElementById("txtSex").value;
	var cmbDokHslD = document.getElementById("cmbDokHslD").value;
	
	ambilLab();
	//return false;
	if(tmpJnsLay == 57){
		url = "hasil_pemeriksaan/hasilLab_utils.php?grd=true&act=tambah&smpn=btnSimpanHslLab&pelayanan_id="+getIdPel+"&kunjungan_id="+getIdKunj+"&jk="+Jkel+"&user_act=<?php echo $userId; ?>&idSimpan="+tmpPilLab2+"&user_actD="+cmbDokHslD;
		//alert(url);
		lab.loadURL(url,"","GET");
		menutup();
		document.getElementById('terima_labrad').disabled = true;
		//getLabRad=1;
	}else if(tmpJnsLay == 60){
		url = "hasil_pemeriksaan/hasilRad_utils.php?grd=true&act=tambah&smpn=btnSimpanHslRad&pelayanan_id="+getIdPel+"&kunjungan_id="+getIdKunj+"&jk="+Jkel+"&user_act=<?php echo $userId; ?>&idSimpan="+tmpPilLab2+"&user_actD="+cmbDokHslD;
		//alert(url);
		rad.loadURL(url,"","GET");
		menutup();
		document.getElementById('terima_labrad').disabled = true;
		//getLabRad=1;
	}
}

function SimpanValidasiLab()
{
	var acc = 0;
	if(document.getElementById("app1").checked == true)
	{
		if(confirm("Apakah Anda Yakin Ingin Approve Hasil Pemeriksaan?")){
			acc = 1;
			//alert("hasil_pemeriksaan/verif_hasil_utils.php?id_pelayanan="+getIdPel+"&acc="+acc+"&isAcc=true");
			jQuery("#btnIsiDataRM18").load("hasil_pemeriksaan/verif_hasil_utils.php?id_pelayanan="+getIdPel+"&acc="+acc+"&isAcc=true&userId=<?php echo $userId; ?>");
		}else{
			document.getElementById("app1").checked = false;
		}
	}else{
		if(confirm("Apakah Anda Yakin Ingin Batal Approve Hasil Pemeriksaan?")){
			acc = 0;
			//alert("hasil_pemeriksaan/verif_hasil_utils.php?id_pelayanan="+getIdPel+"&acc="+acc+"&isAcc=true");
			jQuery("#btnIsiDataRM18").load("hasil_pemeriksaan/verif_hasil_utils.php?id_pelayanan="+getIdPel+"&acc="+acc+"&isAcc=true&userId=<?php echo $userId; ?>");
		}else{
			document.getElementById("app1").checked = true;
		}
	}

}

function menutup(){
	document.getElementById('div_popup_tind').popup.hide();
	document.getElementById('divobat').style.display='none';	
}

//Edit Tmpt Rad Bagus
function pTemplateRad(){
	Request('../master/radiologi_template_utils.php?grd=1&act=view&txtId='+document.getElementById("cmbTmpRad").value , 'tmpContent', '', 'GET',fSetContent,'NoLoad');
}

function fSetContent(){
	//alert(document.getElementById('tmpContent').innerHTML);
	tinyMCE.get("txtHslRad").setContent(document.getElementById('tmpContent').innerHTML);
}
//Edit Tmpt Rad Bagus ->>
function fSimpanHsl(action,id,cek){
	var userId='<?php echo $userId; ?>';
	var idTindHsl = document.getElementById("idTindHsl").value;
	var tindakan_id_hsl = document.getElementById("tindakan_id_hsl").value;
	var txtHsl = document.getElementById("txtHsl").value;
	var txtKetHsl = document.getElementById("txtKetHsl").value;
	var cmbDokHsl = document.getElementById("cmbDokHsl").value;
	var normal = document.getElementById("idNormal").value;
	if (action=="Simpan"){
		var cTglTind=lab.cellsGetValue(lab.getSelRow(),2);
		cTglTind=cTglTind.split(" ");
		cTglTind=cTglTind[0].split("-");
		cTglTind=cTglTind[2]+"-"+cTglTind[1]+"-"+cTglTind[0];
		
	}
	
	if(ValidateForm("txtTind_hsl",'ind')){
		url = "hasil_pemeriksaan/hasilLab_utils.php?grd=true&act="+action+"&smpn="+id+"&pelayanan_id="+getIdPel+"&kunjungan_id="+getIdKunj
		+"&idTind="+tindakan_id_hsl+"&id="+idTindHsl+"&user_act="+userId+"&user_actD="+cmbDokHsl+"&ket="+txtKetHsl+"&hasil="+txtHsl+"&normal="+normal;
		//alert(url);
		lab.loadURL(url,"","GET");
		batalHsl();
	}
}

function fSimpanHslRad(action,id,cek){
	var userId='<?php echo $userId; ?>';
	var id_hasil_rad = document.getElementById("id_hasil_rad").value;
	var id_tind_rad = document.getElementById("id_tind_rad").value
	var txtHslRad = tinyMCE.get("txtHslRad").getContent();
	var txtKesimpulan = document.getElementById("txtKesimpulan").value;
	var cmbDokHsl = document.getElementById("cmbDokHslRad").value;
	var judul = document.getElementById("txtJudul").value;
	var ket_klinis = document.getElementById("txtKet_klinis").value;
	var isDokPengganti = 0;
	
	/*if(document.getElementById("chkDokterPenggantiHslRad").checked == true){
		isDokPengganti = 1;
	}*/
	
	jQuery.ajax({
		type: "POST",
		url: "hasil_pemeriksaan/hasilRad_utils.php?grd=true&act="+action+"&smpn="+id+"&pelayanan_id="+getIdPel+"&id="+id_hasil_rad+"&id_tind_rad="+id_tind_rad+"&isDokPengganti="+isDokPengganti+"&cmbDokHsl="+cmbDokHsl+"&judul="+encodeURIComponent(judul)+"&ket_klinis="+encodeURIComponent(ket_klinis)+"&userId="+userId,
		data: "txtKesimpulan="+encodeURIComponent(txtKesimpulan)+"&txtHslRad="+encodeURIComponent(txtHslRad),
		complete: function(){
			rad.loadURL("hasil_pemeriksaan/hasilRad_utils.php?grd=true&pelayanan_id="+getIdPel,"","GET");
			fBatalHslRad('btnSimpanHslRad');
			alert('Simpan Berhasil !');
		},
		dataType: "String"
	});
}

function fHapusHsl(id){
	var sisip=lab.getRowId(lab.getSelRow()).split("|");
	var rowHsl = document.getElementById("idTindHsl").value;
	var cTglNow="<?php echo $pTglSkrg; ?>";
	var cTglTind=lab.cellsGetValue(lab.getSelRow(),2);
	//alert(cTglTind);
	cTglTind=cTglTind.split(" ");
	//cTglTind=cTglTind[0].split("-");
	//cTglTind=cTglTind[2]+"-"+cTglTind[1]+"-"+cTglTind[0];
	//alert(cTglTind);
	if (cTglNow>cTglTind[0]){
		alert("Data Hasil Pemeriksaan Yang Dientry Sudah Lebih Dari 24 Jam, Jadi Tidak Boleh Dihapus !");
	}else{
		if(confirm("Anda Yakin Ingin Menghapus Hasil laboratorium "+lab.cellsGetValue(lab.getSelRow(),3))){
			document.getElementById(id).disabled = true;
			//alert("hasil_pemeriksaan/hasilLab_utils.php?grd=true&act=hapus&hps="+id+"&id="+sisip[0]+"&pelayanan_id="+getIdPel);
			lab.loadURL("hasil_pemeriksaan/hasilLab_utils.php?grd=true&act=hapus&hps="+id+"&rowid="+sisip[0]+"&pelayanan_id="+getIdPel,'',"GET");
			batalHsl();
		}
	}
}

function fHapusHslRad(id){
	var sisip=rad.getRowId(rad.getSelRow()).split("|");
	var cTglTind=sisip[3];
	var cTglNow="<?php echo $pTglSkrg; ?>";
	//cTglTind=cTglTind.split(" ");
	//cTglTind=cTglTind[0].split("-");
	//cTglTind=cTglTind[2]+"-"+cTglTind[1]+"-"+cTglTind[0];
	//alert(cTglTind);
	if (cTglNow>cTglTind){
		alert("Data Yang Dientry Sudah Lebih Dari 24 Jam, Jadi Tidak Boleh Dihapus !");
	}else{
		if(confirm("Anda Yakin Ingin Menghapus Hasil Radiologi ini ?")){
			document.getElementById(id).disabled = true;
			//alert("hasil_pemeriksaan/hasilLab_utils.php?grd=true&act=hapus&hps="+id+"&id="+sisip[0]+"&pelayanan_id="+getIdPel);
			rad.loadURL("hasil_pemeriksaan/hasilRad_utils.php?grd=true&act=hapus&hps="+id+"&rowid="+sisip[0]+"&pelayanan_id="+getIdPel,'',"GET");
		}
	}
}

function ambilDataHslRad()
{
	var sisip = rad.getRowId(rad.getSelRow()).split("|");
	document.getElementById("id_hasil_rad").value=sisip[0];
	document.getElementById("id_tind_rad").value=sisip[1];
	document.getElementById('spnTindRad').innerHTML=sisip[6];
	//document.getElementById("txtHslRad").value=sisip[2];
	Request("hasil_pemeriksaan/hasilRad_utils.php?act=ambil_hasil&hasil_id="+sisip[0], "spnHasilRad", "", "GET",function(){
		tinyMCE.get("txtHslRad").setContent(document.getElementById('spnHasilRad').innerHTML);	
	},"");
	document.getElementById("txtKesimpulan").value=sisip[3];
	document.getElementById("txtJudul").value=sisip[7];
	document.getElementById("txtKet_klinis").value=sisip[8];
	document.getElementById("btnSimpanHslRad").value="Simpan";
	document.getElementById('btnSimpanHslRad').disabled='';
	var p= "btnHapusHslRad*-*false";
	fSetValue(window,p);
	
	/*if(sisip[4] == 0){
		isiCombo('cmbDok',unitId,sisip[5],'cmbDokHslRad');
		document.getElementById('chkDokterPenggantiHslRad').checked = false;
	}
	else{
		isiCombo('cmbDokPengganti',unitId,sisip[5],'cmbDokHslRad');
		document.getElementById('chkDokterPenggantiHslRad').checked = true;
	}*/
	document.getElementById("cmbDokHslRad").value = sisip[5];
}

function batalHslRad(){
	document.getElementById("id_hasil_rad").value="";
	document.getElementById("txtHslRad").value="";
	document.getElementById("cmbDokHslRad").selectedIndex="";
	document.getElementById("btnSimpanHslRad").value="Tambah";
	var p= "btnHapusHslRad*-*true";
	fSetValue(window,p);
	document.getElementById('frameRad').contentWindow.kensel();
}

function fBatalHslRad(id){
	document.getElementById("id_hasil_rad").value="";
	document.getElementById("id_tind_rad").value="";
	document.getElementById('spnTindRad').innerHTML="";
	//document.getElementById("txtHslRad").value="";
	tinyMCE.get("txtHslRad").setContent('');
	document.getElementById("txtKesimpulan").value="";			
	document.getElementById("txtJudul").value="";
	document.getElementById("txtKet_klinis").value="";
	document.getElementById("btnSimpanHslRad").value="Tambah";
	document.getElementById('btnSimpanHslRad').disabled=false;
	var p= "btnHapusHslRad*-*true";
	fSetValue(window,p);
}

function konfirmasiLabRad(key,val){
	var tangkap,proses,tombolSimpan,tombolHapus,msg,id_tindakan_radiologi,pesan;
	//alert(val+'-'+key);
	if (val!=undefined){
		tangkap=val.split("*|*");
		proses=tangkap[0];
		tombolSimpan=tangkap[1];
		tombolHapus=tangkap[2];
		msg=tangkap[3];
		id_tindakan_radiologi=tangkap[4];
	}
	//alert(proses+'-'+key);
	if(key=='Error'){
		if(proses=='tambah'){
			if(tombolSimpan=='btnSimpanHsl'){
				alert('Data sudah ada. !');
			}
			else{
				alert("Gagal Memasukan Data ke Database.");
			}
		}
		else if(proses=='simpan'){
			alert('Simpan Gagal');
		}
		else if(proses=='hapus'){
			alert('Hapus Gagal.');
		}
	}
	else{
		if(proses=='tambah'){
			alert('Simpan Berhasil');
			if(tombolSimpan=='btnSimpanHslLab'){
				//grdTind.loadURL("tindiag_utils.php?grd=true&pelayanan_id="+getIdPel,"","GET");
				grdTind.loadURL("tindakan/tindakan_utils.php?grd=true&pelayanan_id="+getIdPel,"","GET");
			}
			else if(tombolSimpan=='btnSimpanHslRad'){
				//grdTind.loadURL("tindiag_utils.php?grd=true&pelayanan_id="+getIdPel,"","GET");
				grdTind.loadURL("tindakan/tindakan_utils.php?grd=true&pelayanan_id="+getIdPel,"","GET");
			}
		}
		else if(proses=='simpan'){
			alert('Simpan Berhasil');
			/*if(document.getElementById('cmbJnsLay').value==60){
				rad.loadURL("hasil_pemeriksaan/hasilRad_utils.php?grd=true&pelayanan_id="+getIdPel,"","GET");	
			}
			else{
				lab.loadURL("hasil_pemeriksaan/hasilLab_utils.php?grd=true&pelayanan_id="+getIdPel,"","GET");
			}*/
		}
		else if(proses=='hapus'){
			alert('Hapus Berhasil');
			/*if(document.getElementById('cmbJnsLay').value==60){
				rad.loadURL("hasil_pemeriksaan/hasilRad_utils.php?grd=true&pelayanan_id="+getIdPel,"","GET");	
			}
			else{
				lab.loadURL("hasil_pemeriksaan/hasilLab_utils.php?grd=true&pelayanan_id="+getIdPel,"","GET");
			}*/
		}
	}
	
	if(document.getElementById('cmbJnsLay').value==60){
		fBatalHslRad();
	}
	else{
		batalHsl();
	}
}
</script>