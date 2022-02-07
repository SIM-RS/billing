//alert(th_skr);
function isi_Combo(id,val,defaultId,targetId,evloaded,fromHome)
{
	//alert(id);
	if(targetId=='' || targetId==undefined)
	{
		targetId=id;
	}
	//alert(fromHome);
	if (fromHome=="" || fromHome=="0" || fromHome==undefined){
		/*if (id=="cmbKasir2"){
			alert('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId);
		}*/
		Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded);
	}else{
		/*if (id=="cmbKasir2"){
			alert('combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId);
		}*/
		Request('combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded);
	}
}
var fromHome2 = window.fromHome;
//isi_Combo('cmbKso0','','','cmbKsoRep','',fromHome);
isi_Combo('cmbKso0','','','cmbKsoRep','',fromHome2);
//alert(fromHome2+' ----- ');

function ubah()
{
	if(document.getElementById('cmbWaktu').value=="Harian")
	{
		document.getElementById('tglAwal').value = document.getElementById('tglAwal2').value;
		document.getElementById('tglAkhir').value = document.getElementById('tglAwal2').value;
	}
}

function setBln(val)
{
	//alert(val);
	if(val=='Harian')
	{
		document.getElementById('trBulan').style.visibility = "collapse";
		document.getElementById('trPeriode').style.visibility = "collapse";
		document.getElementById('trHarian').style.visibility = "visible";
	}
	else if(val=='Bulanan')
	{
		document.getElementById('trBulan').style.visibility = "visible";
		document.getElementById('trPeriode').style.visibility = "collapse";
		document.getElementById('trHarian').style.visibility = "collapse";
		document.getElementById('cmbBln').innerHTML =
		'<option value="1">Januari</option>'+
		'<option value="2">Februari</option>'+
		'<option value="3">Maret</option>'+
		'<option value="4">April</option>'+
		'<option value="5">Mei</option>'+
		'<option value="6">Juni</option>'+
		'<option value="7">Juli</option>'+
		'<option value="8">Agustus</option>'+
		'<option value="9">September</option>'+
		'<option value="10">Oktober</option>'+
		'<option value="11">Nopember</option>'+
		'<option value="12">Desember</option>';
		
		var thAwal=th_skr*1-5;
		var thAkhir=th_skr*1;
		for(thAwal;thAwal<=thAkhir;thAwal++)
		{
			document.getElementById('cmbThn').innerHTML = 
			document.getElementById('cmbThn').innerHTML+'<option value="'+thAwal+'">'+thAwal+'</option>';
		}
		document.getElementById('cmbBln').value = bl_skr;
		document.getElementById('cmbThn').value = th_skr;
		
	}
	else if(val=='Rentang Waktu')
	{
		//alert('peri');
		document.getElementById('trPeriode').style.visibility = "visible";
		document.getElementById('trBulan').style.visibility = "collapse";
		document.getElementById('trHarian').style.visibility = "collapse";
		//alert(document.getElementById('trPeriode').style.visibility);
	}
	else
	{
		//alert('else');
		document.getElementById('trPeriode').style.visibility = "collapse";
		document.getElementById('trBulan').style.visibility = "collapse";
		document.getElementById('trHarian').style.visibility = "collapse";
	}
}

function bulanan()
{
	var bulan = document.getElementById("cmbBln").value;
	var tahun = document.getElementById("cmbThn").value;
	var akhir;
	document.getElementById("tglAwal").value = '01-'+bulan+'-'+tahun;
	if(bulan == 2)
	{
		if((tahun%4 == 0) && (tahun%100 != 0))
		{
			akhir = 29;
		}
		else
		{
			akhir = 28;
		}
	}
	else if(bulan<=7)
	{
		if(bulan%2 == 0)
		{
			akhir = 30;
		}
		else
		{
			akhir = 31;
		}
	}
	else if(bulan>7)
	{
		if(bulan%2 == 0)
		{
			akhir = 31;
		}
		else
		{
			akhir = 30;
		}
	}
	document.getElementById("tglAkhir").value = akhir+'-'+bulan+'-'+tahun;
}

function popupReport(p,q)
{
	//alert(p+' , '+q);
	document.getElementById('cmbKsoRep').disabled=false;
	switch (p){
		case 1:
			isi_Combo('cmbJnsPend',1,'','cmbJnsPend','',q);
			document.getElementById('rwJnsTransaksi').style.visibility = "visible";
			document.getElementById('rwKso').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
			document.getElementById('rwKasir').style.visibility = "collapse";
			document.getElementById('rwNamaKasir').style.visibility = "collapse";
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			if (q==1){
				document.form1.action='laporan/pendapatan.php';
			}else{
				document.form1.action='../laporan/pendapatan.php';
			}
			break;
		case 2:
			isi_Combo('cmbJnsPend',2,'0','cmbJnsPend','',q);
			document.getElementById('rwJnsTransaksi').style.visibility = "collapse";
			document.getElementById('rwKso').style.visibility = "collapse";
			document.getElementById('cmbWaktu').style.visibility = "visible";
			document.getElementById('trHarian').style.visibility = "collapse";
			document.getElementById('trPeriode').style.visibility = "collapse";
			document.getElementById('trBulan').style.visibility = "collapse";
			setBln('Harian');
			document.getElementById('rwTipeTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
			document.getElementById('rwKasir').style.visibility = "collapse";
			document.getElementById('rwNamaKasir').style.visibility = "collapse";
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			if (q==1){
				document.form1.action='laporan/pengeluaran.php';
			}else{
				document.form1.action='../laporan/pengeluaran.php';
			}
			break;
		case 3:
			document.getElementById('rwJnsTransaksi').style.visibility = "visible";
			document.getElementById('rwTipeTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
			document.getElementById('rwKasir').style.visibility = "collapse";
			document.getElementById('rwNamaKasir').style.visibility = "collapse";
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			if (q==1){
				document.form1.action='laporan/pendJenis.php';
			}else{
				document.form1.action='../laporan/pendJenis.php';
			}
			break;
		case 4:
			document.getElementById('rwJnsTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
			document.getElementById('rwKasir').style.visibility = "collapse";
			document.getElementById('rwNamaKasir').style.visibility = "collapse";
			document.getElementById('rwKso').style.visibility = "visible";
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			if (q==1){
				document.form1.action='laporan/rekapPendapatan.php';
			}else{
				document.form1.action='../laporan/rekapPendapatan.php';
			}
			break;
		case 5:
			document.getElementById('rwJnsTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
			document.getElementById('rwKso').style.visibility = "visible";
			document.getElementById('rwKasir').style.visibility = "collapse";
			document.getElementById('rwNamaKasir').style.visibility = "collapse";
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			if (q==1){
				document.form1.action='laporan/rekapPendapatanFarmasi.php';
			}else{
				document.form1.action='../laporan/rekapPendapatanFarmasi.php';
			}
			break;
		case 51:
			document.getElementById('rwJnsTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
			document.getElementById('rwKso').style.visibility = "visible";
			document.getElementById('rwKasir').style.visibility = "collapse";
			document.getElementById('rwNamaKasir').style.visibility = "collapse";
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			if (q==1){
				document.form1.action='laporan/rekapPendapatan.php?tipe=all';
			}else{
				document.form1.action='../laporan/rekapPendapatan.php?tipe=all';
			}
			break;
		case 6:
			document.getElementById('rwJnsTransaksi').style.visibility = "visible";
			document.getElementById('rwTipeTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
			document.getElementById('rwKasir').style.visibility = "collapse";
			document.getElementById('rwNamaKasir').style.visibility = "collapse";
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			if (q==1){
				document.form1.action='laporan/rekapPeng.php';
			}else{
				document.form1.action='../laporan/rekapPeng.php';
			}
			break;
		case 7:
			/*document.getElementById('rwJnsTransaksi').style.visibility = "collapse";
			document.getElementById('rwKso').style.visibility = "collapse";
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			if (q==1){
				document.getElementById('form1').action='laporan/rekapPenerimaanHarian.php';
			}else{
				document.getElementById('form1').action='../laporan/rekapPenerimaanHarian.php';
			}*/
			//alert('7');
			isi_Combo('cmbJnsPend',1,'','cmbJnsPend','',q);
			document.getElementById('rwJnsTransaksi').style.visibility = "visible";
			document.getElementById('rwTipeTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
			document.getElementById('rwKso').style.visibility = "collapse";
			document.getElementById('rwKasir').style.visibility = "collapse";
			document.getElementById('rwNamaKasir').style.visibility = "collapse";
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			if (q==1){
				document.form1.action='laporan/pendapatan.php?tipe=1';
			}else{
				document.form1.action='../laporan/pendapatan.php?tipe=1';
			}
			break;
		case 8:
			document.getElementById('rwJnsTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
			document.getElementById('rwKso').style.visibility = "visible";
			document.getElementById('rwKasir').style.visibility = "collapse";
			document.getElementById('rwNamaKasir').style.visibility = "collapse";
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			if (q==1){
				document.form1.action='laporan/rekapPenerimaan.php';
			}else{
				document.form1.action='../laporan/rekapPenerimaan.php';
			}
			break;
		case 81:
			document.getElementById('rwJnsTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
			document.getElementById('rwKso').style.visibility = "visible";
			document.getElementById('rwKasir').style.visibility = "collapse";
			document.getElementById('rwNamaKasir').style.visibility = "collapse";
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			if (q==1){
				document.form1.action='laporan/rekapPenerimaanFarmasi.php';
			}else{
				document.form1.action='../laporan/rekapPenerimaanFarmasi.php';
			}
			break;
		case 82:
			document.getElementById('rwJnsTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
			document.getElementById('rwKso').style.visibility = "visible";
			document.getElementById('rwKasir').style.visibility = "collapse";
			document.getElementById('rwNamaKasir').style.visibility = "collapse";
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			if (q==1){
				document.form1.action='laporan/rekapPenerimaan.php?tipe=all';
			}else{
				document.form1.action='../laporan/rekapPenerimaan.php?tipe=all';
			}
			break;
		case 9:
			document.getElementById('rwJnsTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
			document.getElementById('rwKso').style.visibility = "visible";
			document.getElementById('rwKasir').style.visibility = "collapse";
			document.getElementById('rwNamaKasir').style.visibility = "collapse";
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			if (q==1){
				document.form1.action='laporan/tagihanKso.php';
			}else{
				document.form1.action='../laporan/tagihanKso.php';
			}
			break;
		case 10:
			document.getElementById('rwJnsTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
			document.getElementById('rwKso').style.visibility = "visible";
			document.getElementById('rwKasir').style.visibility = "collapse";
			document.getElementById('rwNamaKasir').style.visibility = "collapse";
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			if (q==1){
				document.form1.action='laporan/klaim.php';
			}else{
				document.form1.action='../laporan/klaim.php';
			}
			break;
		case 11:
			isi_Combo('cmbJnsPend',1,'','cmbJnsPend','',q);
			document.getElementById('rwJnsTransaksi').style.visibility = "visible";
			document.getElementById('rwTipeTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
			document.getElementById('rwKso').style.visibility = "collapse";
			document.getElementById('rwKasir').style.visibility = "collapse";
			document.getElementById('rwNamaKasir').style.visibility = "collapse";
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			if (q==1){
				document.form1.action='laporan/pendapatan.php?tipe=1';
			}else{
				document.form1.action='../laporan/pendapatan.php?tipe=1';
			}
			break;
		case 12:
			document.getElementById('rwJnsTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
			document.getElementById('rwKso').style.visibility = "visible";
			document.getElementById('rwKasir').style.visibility = "collapse";
			document.getElementById('rwNamaKasir').style.visibility = "collapse";
			document.getElementById('cmbKsoRep').value=1;
			document.getElementById('cmbKsoRep').disabled=true;
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			if (q==1){
				document.form1.action='laporan/returnObat.php';
			}else{
				document.form1.action='../laporan/returnObat.php';
			}
			document.getElementById('form1').onsubmit=function(){document.getElementById('cmbKsoRep').disabled=false;}
			break;
		case 13:
			document.getElementById('rwJnsTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
			document.getElementById('rwKso').style.visibility = "visible";
			document.getElementById('rwKasir').style.visibility = "collapse";
			document.getElementById('rwNamaKasir').style.visibility = "collapse";
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			if (q==1){
				document.form1.action='laporan/pengurangPendapatan.php?bayar=0';
			}else{
				document.form1.action='../laporan/pengurangPendapatan.php?bayar=0';
			}
			break;
		case 98:
			//isi_Combo('cmbJnsPend',1,'','cmbJnsPend','',q);
			document.getElementById('rwJnsTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
			document.getElementById('rwKso').style.visibility = "visible";
			document.getElementById('rwKasir').style.visibility = "collapse";
			document.getElementById('rwNamaKasir').style.visibility = "collapse";
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			if (q==1){
				document.form1.action='laporan/return_obat.php';
			}else{
				document.form1.action='../laporan/return_obat.php';
			}
			break;
		case 99:
			//isi_Combo('cmbJnsPend',1,'','cmbJnsPend','',q);
			document.getElementById('rwJnsTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
			document.getElementById('rwKso').style.visibility = "visible";
			document.getElementById('rwKasir').style.visibility = "collapse";
			document.getElementById('rwNamaKasir').style.visibility = "collapse";
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			if (q==1){
				document.form1.action='laporan/return_pelayanan.php';
			}else{
				document.form1.action='../laporan/return_pelayanan.php';
			}
			break;
		case 131:
			document.getElementById('rwJnsTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
			document.getElementById('rwKso').style.visibility = "visible";
			document.getElementById('rwKasir').style.visibility = "collapse";
			document.getElementById('rwNamaKasir').style.visibility = "collapse";
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			if (q==1){
				document.form1.action='laporan/pengurangPendapatan.php?bayar=1';
			}else{
				document.form1.action='../laporan/pengurangPendapatan.php?bayar=1';
			}
			break;
		case 111:
			isi_Combo('cmbJnsPend',1,'','cmbJnsPend','',q);
			document.getElementById('rwJnsTransaksi').style.visibility = "visible";
			document.getElementById('rwTipeTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
			document.getElementById('rwKso').style.visibility = "collapse";
			document.getElementById('rwKasir').style.visibility = "collapse";
			document.getElementById('rwNamaKasir').style.visibility = "collapse";
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			if (q==1){
				document.form1.action='laporan/rekap_pendapatan.php';
			}else{
				document.form1.action='../laporan/rekap_pendapatan.php';
			}
			break;
		case 112:
			document.getElementById('trPeriode').style.visibility = "collapse";
			document.getElementById('rwJnsTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
			//document.getElementById('rwKso').style.visibility = "visible";
			document.getElementById('rwKso').style.visibility = "collapse";
			document.getElementById('cmbWaktu').style.visibility = "collapse";
			document.getElementById('trHarian').style.visibility = "collapse";
			document.getElementById('trPeriode').style.visibility = "visible";
			document.getElementById('rwTipeTransaksi').style.visibility = "visible";
			document.getElementById('trBulan').style.visibility = "collapse";
			document.getElementById('rwKasir').style.visibility = "collapse";
			document.getElementById('rwNamaKasir').style.visibility = "collapse";
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			if (q==1){
				document.form1.action='laporan/BKU.php';
			}else{
				document.form1.action='../laporan/BKU.php';
			}
			break;
			
		case 113:
			document.getElementById('rwJnsTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
			//document.getElementById('rwKso').style.visibility = "visible";
			document.getElementById('rwKso').style.visibility = "collapse";
			document.getElementById('cmbWaktu').style.visibility = "collapse";
			document.getElementById('trHarian').style.visibility = "collapse";
			document.getElementById('trPeriode').style.visibility = "collapse";
			document.getElementById('rwKasir').style.visibility = "collapse";
			document.getElementById('rwNamaKasir').style.visibility = "collapse";
			setBln('Bulanan');
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			if (q==1){
				document.form1.action='laporan/Re_Ang.php';
			}else{
				document.form1.action='../laporan/Re_Ang.php';
			}
			break;
		case 969:
			document.getElementById('trPeriode').style.visibility = "collapse";
			document.getElementById('rwJnsTransaksi').style.visibility = "collapse";
			//document.getElementById('rwKso').style.visibility = "visible";
			document.getElementById('rwKso').style.visibility = "collapse";
			document.getElementById('cmbWaktu').style.visibility = "collapse";
			document.getElementById('trWaktu').style.visibility = "collapse";
			document.getElementById('trHarian').style.visibility = "collapse";
			document.getElementById('trPeriode').style.visibility = "visible";
			document.getElementById('rwTipeTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "visible";
			document.getElementById('trBulan').style.visibility = "collapse";
			document.getElementById('rwKasir').style.visibility = "collapse";
			document.getElementById('rwNamaKasir').style.visibility = "collapse";
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			if (q==1){
				document.form1.action='laporan/pengembalian_uang.php';
			}else{
				document.form1.action='../laporan/pengembalian_uang.php';
			}
			break;
	}
}

var paramID = "";
function fJReportChange(p){
	if (p=="0"){
		document.getElementById('trKlaim').style.visibility = "collapse";
	}else{
		document.getElementById('trKlaim').style.visibility = "visible";
		//Isi cmbKlaim dgn Data sesuai kriteria waktu & penjamin
		var tglAwal2 = document.getElementById('tglAwal2').value;
		var tglAwal = document.getElementById('tglAwal').value;
		var tglAkhir = document.getElementById('tglAkhir').value;
		var cmbBln = document.getElementById('cmbBln').value;
		var cmbThn = document.getElementById('cmbThn').value;
		var cmbWaktu = document.getElementById('cmbWaktu').value;
		var waktu = cmbWaktu+"||"+tglAwal+"||"+tglAkhir+"||"+tglAwal2+"||"+cmbBln+"||"+cmbThn;
		var param = document.getElementById('cmbKsoRep').value+','+waktu+','+paramID;
		isi_Combo('cmbKlaim',param,'','cmbKlaim','','');
	}
}

function fKlaimChange(){
	if(document.getElementById('cmbJReport').value == 1){
		fJReportChange(1);
	}
}

function fSubmitReport(){
	document.getElementById('excell').value="1";
	document.getElementById('form1').submit();
	document.getElementById('excell').value="0";
}

function popupReportNew(p,q)
{
	//alert(p+' , '+q);
	document.getElementById('cmbKsoRep').disabled=false;
	switch (p){
		case 1:
		case 2:
		case 3:
		case 4:
		case 5:
		case 6:
		case 7:
		case 8:
		case 9:
			if (p==1){
				document.getElementById('isPavilyun').value="0";
				document.getElementById('isFarmasi').value="0";
			}else if (p==2){
				document.getElementById('isPavilyun').value="1";
				document.getElementById('isFarmasi').value="0";
			}else if (p==3){
				document.getElementById('isPavilyun').value="";
				document.getElementById('isFarmasi').value="0";
			}else if (p==4){
				document.getElementById('isPavilyun').value="0";
				document.getElementById('isFarmasi').value="1";
			}else if (p==5){
				document.getElementById('isPavilyun').value="1";
				document.getElementById('isFarmasi').value="1";
			}else if (p==6){
				document.getElementById('isPavilyun').value="";
				document.getElementById('isFarmasi').value="1";
			}else if (p==7){
				document.getElementById('isPavilyun').value="0";
				document.getElementById('isFarmasi').value="";
			}else if (p==8){
				document.getElementById('isPavilyun').value="1";
				document.getElementById('isFarmasi').value="";
			}else if (p==9){
				document.getElementById('isPavilyun').value="";
				document.getElementById('isFarmasi').value="";
			}
			document.getElementById('rwJnsTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
			document.getElementById('rwKso').style.visibility = "visible";
			document.getElementById('trJReport').style.visibility = "collapse";
			document.getElementById('trKlaim').style.visibility = "collapse";
			document.getElementById('rwKasir').style.visibility = "collapse";
			document.getElementById('rwNamaKasir').style.visibility = "collapse";
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			if (q==1){
				document.form1.action='laporan/rekapPendapatanNew.php';
			}else{
				document.form1.action='../laporan/rekapPendapatanNew.php';
			}
			break;
		case 10:
		case 11:
			var jenisPend = 4;
			if(p == 10){
				jenisPend = 3
			}
			
			document.getElementById('rwJnsTransaksi').style.visibility = "collapse";
			document.getElementById('rwKso').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
			document.getElementById('trJReport').style.visibility = "collapse";
			document.getElementById('trKlaim').style.visibility = "collapse";
			document.getElementById('rwKasir').style.visibility = "collapse";
			document.getElementById('rwNamaKasir').style.visibility = "collapse";
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			
			if (q==1){
				document.form1.action='laporan/lap_hibah_kerjasama.php?tipe=1&jenisPend='+jenisPend;
				if (p==10){
					paramID = 'laporanKerjasama';
				}else{
					paramID = 'laporanHibah';
				}
			}else{
				document.form1.action='../laporan/lap_hibah_kerjasama.php?tipe=1&jenisPend='+jenisPend;
				if (p==10){
					paramID = 'laporanKerjasama';
				}else{
					paramID = 'laporanHibah';
				}
			}
			break;
		case 12:
		case 24:
			var tipe=0;
			if (p==24) tipe=1;
			isi_Combo('cmbJnsPend',1,'','cmbJnsPend','',q);
			document.getElementById('rwJnsTransaksi').style.visibility = "visible";
			document.getElementById('rwKso').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
			document.getElementById('trJReport').style.visibility = "collapse";
			document.getElementById('trKlaim').style.visibility = "collapse";
			document.getElementById('rwKasir').style.visibility = "collapse";
			document.getElementById('rwNamaKasir').style.visibility = "collapse";
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			if (q==1){
				document.form1.action='laporan/pendapatan.php?tipe='+tipe;
			}else{
				document.form1.action='../laporan/pendapatan.php?tipe='+tipe;
			}
			break;
		case 13:
		case 14:
		case 15:
		case 16:
		case 17:
		case 18:
		case 19:
		case 20:
		case 21:
			if (p==13){
				document.getElementById('isPavilyun').value="0";
				document.getElementById('isFarmasi').value="0";
			}else if (p==14){
				document.getElementById('isPavilyun').value="1";
				document.getElementById('isFarmasi').value="0";
			}else if (p==15){
				document.getElementById('isPavilyun').value="";
				document.getElementById('isFarmasi').value="0";
			}else if (p==16){
				document.getElementById('isPavilyun').value="0";
				document.getElementById('isFarmasi').value="1";
			}else if (p==17){
				document.getElementById('isPavilyun').value="1";
				document.getElementById('isFarmasi').value="1";
			}else if (p==18){
				document.getElementById('isPavilyun').value="";
				document.getElementById('isFarmasi').value="1";
			}else if (p==19){
				document.getElementById('isPavilyun').value="0";
				document.getElementById('isFarmasi').value="";
			}else if (p==20){
				document.getElementById('isPavilyun').value="1";
				document.getElementById('isFarmasi').value="";
			}else if (p==21){
				document.getElementById('isPavilyun').value="";
				document.getElementById('isFarmasi').value="";
			}
			document.getElementById('rwJnsTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
			document.getElementById('rwKso').style.visibility = "visible";
			document.getElementById('trJReport').style.visibility = "collapse";
			document.getElementById('trKlaim').style.visibility = "collapse";
			document.getElementById('rwKasir').style.visibility = "collapse";
			document.getElementById('rwNamaKasir').style.visibility = "collapse";
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			if (q==1){
				document.form1.action='laporan/rekapPenerimaanNew.php';
			}else{
				document.form1.action='../laporan/rekapPenerimaanNew.php';
			}
			break;
		case 22:
		case 23:
			var jenisPend = 4;
			if(p == 22){
				jenisPend = 3
			}
			
			document.getElementById('rwJnsTransaksi').style.visibility = "collapse";
			document.getElementById('rwKso').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
			document.getElementById('trJReport').style.visibility = "collapse";
			document.getElementById('trKlaim').style.visibility = "collapse";
			document.getElementById('rwKasir').style.visibility = "collapse";
			document.getElementById('rwNamaKasir').style.visibility = "collapse";
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			
			if (q==1){
				document.form1.action='laporan/lap_hibah_kerjasama.php?tipe=2&jenisPend='+jenisPend;
				if (p==10){
					paramID = 'laporanKerjasama';
				}else{
					paramID = 'laporanHibah';
				}
			}else{
				document.form1.action='../laporan/lap_hibah_kerjasama.php?tipe=2&jenisPend='+jenisPend;
				if (p==10){
					paramID = 'laporanKerjasama';
				}else{
					paramID = 'laporanHibah';
				}
			}
			break;
		case 25:
		case 26:
			document.getElementById('rwJnsTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
			document.getElementById('rwKso').style.visibility = "visible";
			document.getElementById('trJReport').style.visibility = "visible";
			document.getElementById('trKlaim').style.visibility = "collapse";
			document.getElementById('rwKasir').style.visibility = "collapse";
			document.getElementById('rwNamaKasir').style.visibility = "collapse";
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			if (q==1){
				if (p==25){
					document.form1.action='laporan/pengajuanKlaim.php';
					paramID = 'pengajuanKlaim';
				}else{
					document.form1.action='laporan/penerimaanKlaim.php';
					paramID = 'penerimaanKlaim';
				}
			}else{
				if (p==25){
					document.form1.action='../laporan/pengajuanKlaim.php';
					paramID = 'pengajuanKlaim';
				}else{
					document.form1.action='../laporan/penerimaanKlaim.php';
					paramID = 'penerimaanKlaim';
				}
			}
			break;
		case 27:
		case 28:
			document.getElementById('trBulan').style.visibility = "visible";
			bulanTahun()
			
			document.getElementById('rwJnsTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
			/* document.getElementById('cmbWaktu').style.visibility = "collapse"; */
			document.getElementById('trWaktu').style.visibility = "collapse";
			document.getElementById('trHarian').style.visibility = "collapse";
			document.getElementById('rwKso').style.visibility = "collapse";
			document.getElementById('rwKasir').style.visibility = "collapse";
			document.getElementById('rwNamaKasir').style.visibility = "collapse";
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			if (q==1){
				if (p==27){
					document.form1.action='penerimaan/cetak_parkir.php?tipe=1';
					paramID = 'penerimaanParkir';
				}else{
					document.form1.action='penerimaan/cetak_ambulan.php?tipe=1';
					paramID = 'penerimaanAmbulan';
				}
			}else{
				if (p==27){
					document.form1.action='../penerimaan/cetak_parkir.php?tipe=1';
					paramID = 'penerimaanParkir';
				}else{
					document.form1.action='../penerimaan/cetak_ambulan.php?tipe=1';
					paramID = 'penerimaanAmbulan';
				}
			}
			break;
		case 29:
		case 30:
			var url='';
			if (p==29) {
				url = "laporan/rekap_pendapatan_new.php";
			} else {
				url = "laporan/rekap_penerimaan_new.php";
			}
			//isi_Combo('cmbJnsPend',1,'','cmbJnsPend','',q);
			document.getElementById('rwJnsTransaksi').style.visibility = "collapse";
			document.getElementById('rwKso').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
			document.getElementById('trJReport').style.visibility = "collapse";
			document.getElementById('trKlaim').style.visibility = "collapse";
			document.getElementById('rwKasir').style.visibility = "collapse";
			document.getElementById('rwNamaKasir').style.visibility = "collapse";
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			if (q==1){
				document.form1.action = url;
			}else{
				document.form1.action = '../'+url;
			}
			break;
		case 31:
			isi_Combo('cmbKasir2','','','cmbKasir2','',q);
			isi_Combo('nmKsr',81,'','nmKsr','',q);
			document.getElementById('rwJnsTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
			document.getElementById('trWaktu').style.visibility = "collapse";
			document.getElementById('trPeriode').style.visibility = "visible";
			document.getElementById('trHarian').style.visibility = "collapse";
			document.getElementById('rwKso').style.visibility = "collapse";
			document.getElementById('rwKasir').style.visibility = "visible";
			document.getElementById('rwNamaKasir').style.visibility = "visible";
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			if (q==1){
				document.form1.action='../billing/laporan/kasir/SetoranPenerimaanKasir_new.php?txtJam1=00:00&txtJam2=23:59';
			}else{
				document.form1.action='../../billing/laporan/kasir/SetoranPenerimaanKasir_new.php?txtJam1=00:00&txtJam2=23:59';
			}
			break;
		case 32:
		case 33:
			document.getElementById('rwJnsTransaksi').style.visibility = "collapse";
			document.getElementById('rwKso').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
			document.getElementById('trJReport').style.visibility = "collapse";
			document.getElementById('trKlaim').style.visibility = "collapse";
			document.getElementById('rwKasir').style.visibility = "collapse";
			document.getElementById('rwNamaKasir').style.visibility = "collapse";
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			
			if (q==1){
				if(p == 32){
					document.form1.action='laporan/return_pembayaran_billing.php';
					paramID = 'pengembalianBayar';
				} else {
					document.form1.action='laporan/return_tindakan_billing.php';
					paramID = 'pengembalianTindakan';
				}
			}else{
				if(p == 32){
					document.form1.action='../laporan/return_pembayaran_billing.php';
					paramID = 'pengembalianBayar';
				} else {
					document.form1.action='../laporan/return_tindakan_billing.php';
					paramID = 'pengembalianTindakan';
				}
			}
			break;
		case 34:
			document.getElementById('rwJnsTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
			document.getElementById('rwKso').style.visibility = "visible";
			document.getElementById('trJReport').style.visibility = "collapse";
			document.getElementById('trKlaim').style.visibility = "collapse";
			document.getElementById('rwKasir').style.visibility = "collapse";
			document.getElementById('rwNamaKasir').style.visibility = "collapse";
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			if (q==1){
				document.form1.action='laporan/pasien_krs.php';
			}else{
				document.form1.action='../laporan/pasien_krs.php';
			}
			break;
		case 35:
			document.getElementById('rwJnsTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
			document.getElementById('rwKso').style.visibility = "visible";
			document.getElementById('trJReport').style.visibility = "collapse";
			document.getElementById('trKlaim').style.visibility = "collapse";
			// document.getElementById('rwJnsLay').style.visibility = "collapse";
			document.getElementById('rwKasir').style.visibility = "collapse";
			document.getElementById('rwNamaKasir').style.visibility = "collapse";
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			paramID = "";
			if (q==1){
				document.form1.action='laporan/perawatan_piutang.php';
			}else{
				document.form1.action='../laporan/perawatan_piutang.php';
			}
			break;
		case 36:
			document.getElementById('rwJnsTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
			document.getElementById('rwKso').style.visibility = "visible";
			document.getElementById('trJReport').style.visibility = "collapse";
			document.getElementById('trKlaim').style.visibility = "collapse";
			// document.getElementById('rwJnsLay').style.visibility = "collapse";
			document.getElementById('rwKasir').style.visibility = "collapse";
			document.getElementById('rwNamaKasir').style.visibility = "collapse";
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			paramID = "";
			if (q==1){
				document.form1.action='laporan/rekap_perawatan_piutang.php';
			}else{
				document.form1.action='../laporan/rekap_perawatan_piutang.php';
			}
			break;
			
		case 37:
			isi_Combo('cmbKasir2','','','cmbKasir2','',q);
			isi_Combo('nmKsr',81,'','nmKsr','',q);
			document.getElementById('rwJnsTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
			document.getElementById('trWaktu').style.visibility = "collapse";
			document.getElementById('trPeriode').style.visibility = "visible";
			document.getElementById('rwKso').style.visibility = "collapse";
			document.getElementById('rwKasir').style.visibility = "visible";
			document.getElementById('rwNamaKasir').style.visibility = "visible";
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			if (q==1){
				document.form1.action='../laporan/PenerimaanKasir_deposit.php?txtJam1=00:00&txtJam2=23:59';
			}else{
				document.form1.action='../laporan/PenerimaanKasir_deposit.php?txtJam1=00:00&txtJam2=23:59';
			}
			break;
		case 38:
			document.getElementById('rwJnsTransaksi').style.visibility = "collapse";
			document.getElementById('rwKso').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi').style.visibility = "collapse";
			document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
			document.getElementById('trJReport').style.visibility = "collapse";
			document.getElementById('trKlaim').style.visibility = "collapse";
			document.getElementById('rwKasir').style.visibility = "collapse";
			document.getElementById('rwNamaKasir').style.visibility = "collapse";
			new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
			$('popup_div1').popup.show();
			
			if (q==1){
				document.form1.action='laporan/rekap_pengembalian.php';
			}else{
				document.form1.action='../laporan/rekap_pengembalian.php';
			}
			break;
			document.getElementById('trHarian').style.visibility = "collapse";
	}
}

function resetF(){
	document.getElementById('trBulan').style.visibility = "collapse";
	document.getElementById('cmbWaktu').style.visibility = "visible";
	document.getElementById('cmbWaktu').value = "Harian";
	document.getElementById('trWaktu').style.visibility = "visible";
	document.getElementById('trHarian').style.visibility = "visible";
	document.getElementById('trPeriode').style.visibility = "collapse";
	document.getElementById('cmbJReport').value = 0;
	document.getElementById('rwTipeTransaksi2').style.visibility = "collapse";
	document.getElementById('rwKasir').style.visibility = "collapse";
	document.getElementById('rwNamaKasir').style.visibility = "collapse";
	document.getElementById('excell').value="0";
}

function bulanTahun(){
	document.getElementById('cmbBln').innerHTML =
					'<option value="1">Januari</option>'+
					'<option value="2">Februari</option>'+
					'<option value="3">Maret</option>'+
					'<option value="4">April</option>'+
					'<option value="5">Mei</option>'+
					'<option value="6">Juni</option>'+
					'<option value="7">Juli</option>'+
					'<option value="8">Agustus</option>'+
					'<option value="9">September</option>'+
					'<option value="10">Oktober</option>'+
					'<option value="11">Nopember</option>'+
					'<option value="12">Desember</option>';
	
	var thAwal=th_skr*1-5;
	var thAkhir=th_skr*1;
	for(thAwal;thAwal<=thAkhir;thAwal++)
	{
		document.getElementById('cmbThn').innerHTML = 
		document.getElementById('cmbThn').innerHTML+'<option value="'+thAwal+'">'+thAwal+'</option>';
	}
	document.getElementById('cmbBln').value = bl_skr;
	document.getElementById('cmbThn').value = th_skr;
}