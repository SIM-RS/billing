<?php
session_start();
include("../../sesi.php");
?>
<?php
	//session_start();
	$userId = $_SESSION['userId'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../../theme/mod.css">
<script language="JavaScript" src="../../theme/js/dsgrid.js"></script>

<!--dibawah ini diperlukan untuk menampilkan popup-->
<link rel="stylesheet" type="text/css" href="../../theme/popup.css" />
<script type="text/javascript" src="../../theme/prototype.js"></script>
<script type="text/javascript" src="../../theme/effects.js"></script>
<script type="text/javascript" src="../../theme/popup.js"></script>
<!--diatas ini diperlukan untuk menampilkan popup-->

<!-- untuk ajax-->
<script type="text/javascript" src="../../theme/js/ajax.js"></script>
<!-- end untuk ajax-->

<title>Laporan Tempat Layanan</title>
</head>

<body>
<script>
	var arrRange=depRange=[];
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../../theme/popcjs.php" scrolling="no"
	frameborder="1"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>
<div align="center">
<?php
	include("../../koneksi/konek.php");
	include("../../header1.php");
	include("report_form.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$date_skr=explode('-',$date_now);
?>
<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
	<tr>
		<td height="30">&nbsp;LAPORAN TEMPAT LAYANAN</td>
	</tr>
</table>
<table width="1000" border="0" cellspacing="0" cellpadding="0" class="txtinput" align="center" height="450">
	<tr>
		<td width="15%" height="50">&nbsp;</td>
		<td width="70%">&nbsp;</td>
		<td width="15%">&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td valign="top">
			<table width="100%" border="0" cellpadding="2" cellspacing="5" align="center" class="list_laporan">
				<tr>
					<td style="line-height:30px;">
						 <ol>
						 	<li><a href="javascript:void(0)" onclick="popupReport1();variabel=1;tipe=0;sts=1;change()">Buku Register Pasien</a>&nbsp;/&nbsp;<a href="javascript:void(0)" onclick="popupReport33();variabel=1;tipe=6;sts=1;change()">Buku Register Penunjang Medik</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport2();variabel=1;tipe=0;sts=1;change()">Buku Diagnosis Pasien</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport3();variabel=1;tipe=0;sts=1;change()">Buku Tindakan Pasien</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport29();variabel=0;tipe=3;sts=0;change()">Buku Triage Pasien</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport30();variabel=1;tipe=4;sts=0;change()">Buku Pasien MRS</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport31();variabel=1;tipe=5;sts=1;change()">Rekapitulasi Data Pasien</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport7();variabel=1;tipe=0;sts=1;change()">Penerimaan Konsul</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport6();variabel=1;tipe=0;sts=1;change()">Pengiriman Konsul</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport4();variabel=1;tipe=0;sts=1;change()">Rujukan Penunjang Medik</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport8();variabel=1;tipe=0;sts=1;change()">Kegiatan Pelayanan</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport12();variabel=1;tipe=0;sts=1;change()">Kunjungan Tempat Layanan</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport20();variabel=1;tipe=0;sts=1;change()">Cara Masuk Pasien Berdasarkan Tempat Layanan</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport17();variabel=1;tipe=0;sts=1;change()">Cara Bayar Pasien Berdasarkan Tempat Layanan</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport18();variabel=1;tipe=0;sts=1;change()">Kasus Penyakit Pasien Berdasarkan Tempat Layanan</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport19();variabel=1;tipe=0;sts=1;change()">Cara Keluar Pasien Berdasarkan Tempat Layanan</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport13();variabel=1;tipe=0;sts=1;change()">Kunjungan Pasien Berdasarkan Penjamin Pasien</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport14();variabel=1;tipe=0;sts=1;change()">Asal Pasien Pasien Berdasarkan Penjamin Pasien</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport15();variabel=1;tipe=0;sts=1;change()">Kasus Penyakit Pasien Berdasarkan Penjamin Pasien</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport16();variabel=1;tipe=0;sts=1;change()">Cara Keluar Pasien Bersadarkan Penjamin Pasien</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport28();variabel=1;tipe=2;sts=1;change()">Rekapitulasi Pasien Keluar Tempat Layanan Rawat Inap</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport27();variabel=1;tipe=1;sts=1;change()">Rekapitulasi Kunjungan Pasien Berdasarkan Status Dilayani</a></li>
							<!--li><a href="javascript:void(0)" onclick="popupReport28();variabel=1;tipe=1;change()">Rekapitulasi Kunjungan Pasien Berdasarkan Status Dilayani Tempat Layanan Rawat Inap</a></li-->
							<li><a href="javascript:void(0)" onclick="popupReport21();variabel=1;tipe=0;sts=1;change()">Diagnosis Tempat Layanan</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport22();variabel=1;tipe=0;sts=1;change()">15 Diagnosis Terbanyak</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport23();variabel=1;tipe=0;sts=1;change()">Pendapatan Tempat Layanan</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport25();variabel=1;tipe=0;sts=1;change()">Penerimaan Tempat Layanan (Semua Pasien)</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport26();variabel=1;tipe=0;sts=1;change()">Klaim Jaminan Tempat Layanan</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport24();variabel=1;tipe=0;sts=1;change()">Blangko Kelengkapan Berkas</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport32();variabel=1;tipe=2;sts=0;change()">Rekapitulasi Tempat Tidur Rawat Inap</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport5();variabel=1;tipe=0;sts=1;change()">Pemeriksaan/Tindakan</a></li>
                            <li><a href="javascript:void(0)" onclick="popupReport5_new();variabel=1;tipe=0;sts=1;change()">Jumlah Pemeriksaan/Tindakan Perdokter</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport9();variabel=1;tipe=0;sts=1;change()">Kunjungan</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport10();variabel=1;tipe=0;sts=1;change()">Rekapitulasi Kunjungan</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport11();variabel=1;tipe=0;sts=1;change()">Buku Transaksi Tindakan</a></li>
                            <li><a href="javascript:void(0)" onclick="popupReport34();variabel=1;sts=2;tipe=12;pil=0;change()">Rekapitulasi Data Pasien Keluar Pulang Paksa</a></li>
                            <li><a href="javascript:void(0)" onclick="popupReport22_n();variabel=1;tipe=0;sts=1;change()">Pasien Batal Berkunjung</a></li>
                            <li><a href="javascript:void(0)" onclick="popupReport35();variabel=1;tipe=7;sts=1;change()">Laporan Laboratorium</a></li>
                            <li><a href="javascript:void(0)" onclick="popupReport36();variabel=1;tipe=0;sts=1;change()">Waktu Tunggu Pasien</a></li>
                            <li><a href="javascript:void(0)" onclick="variabel=1;tipe=13;sts=1;change();popupReport37();">Realisasi Produksi</a></li>
						 </ol>
					</td>
				</tr>
			</table>
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" height="50">&nbsp;</td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="1000" class="hd2">
	<tr height="30">
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td align="right">&nbsp;</td>
	</tr>
</table>
</div>
</body>
<script>
	isiCombo('JnsLayanan','','','',showTmpLay);
	//isiCombo2('JnsLayanan','','','',showTmpLay);
	function showTmpLay(){
		isiCombo('TmpLayanan',document.getElementById('JnsLayanan').value);
		isiCombo1('TmpLayananJalan',document.getElementById('JnsLayanan').value);
	}
	isiCombo('JnsLayananIgd','','','',showTmpLay2);
	function showTmpLay2(){
		isiCombo('TmpLayananIgd',document.getElementById('JnsLayananIgd').value);
	}
	isiCombo1('StatusPas');
	isiCombo1('cmbTempatLayanan',document.getElementById('cmbJenisLayanan').value);
	isiCombo('JnsLayananInapSaja','','','',showTmpLay3);
	function showTmpLay3(){
		isiCombo('TmpLayananInapSaja',document.getElementById('JnsLayananInapSaja').value);
	}
	isiCombo('JnsLayananInap','','','',showTmpLayInap);
	function showTmpLayInap(){
		isiCombo('TmpLayananInap',document.getElementById('JnsLayananInap').value);
	}
	
	isiCombo('TmpLayMedik','','','');
	
	function isiCombo(id,val,defaultId,targetId,evloaded)
	{
		if(targetId=='' || targetId==undefined)
		{
			targetId=id;
		}
			Request('../../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,id,'','GET',evloaded);
	}
	
	
		
	function isiCombo1(id,val,defaultId,targetId,evloaded)
	{
		if(targetId=='' || targetId==undefined)
		{
			targetId=id;
		}
			Request('../../combo_utils.php?id='+id+'&value='+val+'&all=1&defaultId='+defaultId,id,'','GET',evloaded);
	}
	
		
	function isiCombo2(id,val,defaultId,targetId,evloaded)
	{
		if(targetId=='' || targetId==undefined)
		{
			targetId=id;
		}
			Request('../../combo_utils.php?id='+id+'&value='+val+'&all=1&reg=1&defaultId='+defaultId,id,'','GET',evloaded);
	}
	
		
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
		if(val=='Harian')
		{
			document.getElementById('trBulan').style.display = "none";
			document.getElementById('trPeriode').style.display = "none";
			document.getElementById('trHarian').style.display = "block";
		}
		else if(val=='Bulanan')
		{
			document.getElementById('trBulan').style.display = "block";
			document.getElementById('trPeriode').style.display = "none";
			document.getElementById('trHarian').style.display = "none";
			document.getElementById('cmbBln').innerHTML =
			'<option value="01">Januari</option>'+
			'<option value="02">Februari</option>'+
			'<option value="03">Maret</option>'+
			'<option value="04">April</option>'+
			'<option value="05">Mei</option>'+
			'<option value="06">Juni</option>'+
			'<option value="07">Juli</option>'+
			'<option value="08">Agustus</option>'+
			'<option value="09">September</option>'+
			'<option value="10">Oktober</option>'+
			'<option value="11">Nopember</option>'+
			'<option value="12">Desember</option>';
			var thSkr='<?php echo $date_skr[2];?>';
			var thAwal=thSkr*1-5;
			var thAkhir=thSkr*1+6;
			for(thAwal;thAwal<thAkhir;thAwal++)
			{				
				document.getElementById('cmbThn').innerHTML = 
				document.getElementById('cmbThn').innerHTML+'<option>'+thAwal+'</option>';
			}
			document.getElementById('cmbBln').value = '<?php echo $date_skr[1];?>';
			document.getElementById('cmbThn').value = thSkr;
		}
		else if(val=='Rentang Waktu')
		{
			document.getElementById('trPeriode').style.display = "block";
			document.getElementById('btnTglAkhir').disabled=false;
			document.getElementById('trHarian').style.display = "none";
			document.getElementById('trBulan').style.display = "none";
		}
		else
		{
			document.getElementById('trPeriode').style.display = "none";
			document.getElementById('trBulan').style.display = "none";
			document.getElementById('trHarian').style.display = "none";
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
	
	var variabel;
	var tipe;
	var sts;
	
	function changeM(){
		isiCombo1('cmbTempatLayananM',document.getElementById('cmbJenisLayananM').value,'0','cmbTempatLayananM');   
	}
	
	function change()
	{
		document.getElementById('cmbWaktu').style.display='table-row';
		//alert(variabel);
		if(variabel==1){
			isiCombo1('TmpLayanan',document.getElementById('JnsLayanan').value);
			isiCombo1('TmpLayananIgd',document.getElementById('JnsLayananIgd').value);
			isiCombo1('TmpLayananInap',document.getElementById('JnsLayananInap').value);
			isiCombo1('cmbTempatLayanan',document.getElementById('cmbJenisLayanan').value);
			isiCombo1('TmpLayananInapSaja',document.getElementById('JnsLayananInapSaja').value);
			isiCombo1('TmpLayananJalan',document.getElementById('JnsLayanan').value);
		}else{
			isiCombo('TmpLayanan',document.getElementById('JnsLayanan').value);
			isiCombo('TmpLayananIgd',document.getElementById('JnsLayananIgd').value);
			isiCombo('TmpLayananInap',document.getElementById('JnsLayananInap').value);
			isiCombo('cmbTempatLayanan',document.getElementById('cmbJenisLayanan').value);
			isiCombo('TmpLayananInapSaja',document.getElementById('JnsLayananInapSaja').value);
			isiCombo('cmbTempatLayanan',document.getElementById('JnsLayanan').value);
		}
		
		if(sts==1){
			document.getElementById('trPenjamin').style.display='table-row';
		}else{
			document.getElementById('trPenjamin').style.display='none';
		}
		
		if(tipe==1){
			document.getElementById('trJns').style.display='none';
			document.getElementById('trTmp').style.display='none';
			document.getElementById('trJnsIgd').style.display='none';
			document.getElementById('trTmpIgd').style.display='none';
			document.getElementById('trJenis').style.display='table-row';
			document.getElementById('trTempat').style.display='table-row';
			document.getElementById('trDilayani').style.display='table-row';
			document.getElementById('jnsInap').style.display = 'none';
			document.getElementById('tmpInap').style.display = 'none';
			document.getElementById('jnsInap2').style.display = 'none';
			document.getElementById('tmpInap2').style.display = 'none';
			document.getElementById('trTmpJln').style.display = 'none';
			document.getElementById('trPMedik').style.display = 'none';
			document.getElementById('trJnsKunj').style.display = 'none';
			document.getElementById('trJenisM').style.display = 'none';
			document.getElementById('trTempatM').style.display = 'none';
		}else if(tipe==0){
			document.getElementById('trDilayani').style.display='none';
			document.getElementById('trJns').style.display='table-row';
			document.getElementById('trTmp').style.display='table-row';
			document.getElementById('trJnsIgd').style.display='none';
			document.getElementById('trTmpIgd').style.display='none';
			document.getElementById('trJenis').style.display='none';
			document.getElementById('trTempat').style.display='none';
			document.getElementById('jnsInap').style.display = 'none';
			document.getElementById('tmpInap').style.display = 'none';
			document.getElementById('jnsInap2').style.display = 'none';
			document.getElementById('tmpInap2').style.display = 'none';
			document.getElementById('trTmpJln').style.display = 'none';
			document.getElementById('trPMedik').style.display = 'none';
			document.getElementById('trJnsKunj').style.display = 'none';
			document.getElementById('trJenisM').style.display = 'none';
			document.getElementById('trTempatM').style.display = 'none';
		}else if(tipe==2){
			document.getElementById('trDilayani').style.display='none';
			document.getElementById('trJns').style.display='none';
			document.getElementById('trTmp').style.display='none';
			document.getElementById('trJnsIgd').style.display='none';
			document.getElementById('trTmpIgd').style.display='none';
			document.getElementById('trJenis').style.display='none';
			document.getElementById('trTempat').style.display='none';
			document.getElementById('jnsInap').style.display = 'table-row';
			document.getElementById('tmpInap').style.display = 'table-row';
			document.getElementById('jnsInap2').style.display = 'none';
			document.getElementById('tmpInap2').style.display = 'none';
			document.getElementById('trTmpJln').style.display = 'none';
			document.getElementById('trPMedik').style.display = 'none';
			document.getElementById('trJnsKunj').style.display = 'none';
			document.getElementById('trJenisM').style.display = 'none';
			document.getElementById('trTempatM').style.display = 'none';
		}else if(tipe==3){
			document.getElementById('trDilayani').style.display='none';
			document.getElementById('trJns').style.display='none';
			document.getElementById('trTmp').style.display='none';
			document.getElementById('trJnsIgd').style.display='table-row';
			document.getElementById('trTmpIgd').style.display='table-row';
			document.getElementById('trJenis').style.display='none';
			document.getElementById('trTempat').style.display='none';
			document.getElementById('jnsInap').style.display = 'none';
			document.getElementById('tmpInap').style.display = 'none';
			document.getElementById('jnsInap2').style.display = 'none';
			document.getElementById('tmpInap2').style.display = 'none';
			document.getElementById('trTmpJln').style.display = 'none';
			document.getElementById('trPMedik').style.display = 'none';
			document.getElementById('trJnsKunj').style.display = 'none';
			document.getElementById('trJenisM').style.display = 'none';
			document.getElementById('trTempatM').style.display = 'none';
		}else if(tipe==4){
			document.getElementById('trDilayani').style.display='none';
			document.getElementById('trJns').style.display='none';
			document.getElementById('trTmp').style.display='none';
			document.getElementById('trJnsIgd').style.display='none';
			document.getElementById('trTmpIgd').style.display='none';
			document.getElementById('trJenis').style.display='none';
			document.getElementById('trTempat').style.display='none';
			document.getElementById('jnsInap').style.display = 'none';
			document.getElementById('tmpInap').style.display = 'none';
			document.getElementById('jnsInap2').style.display = 'table-row';
			document.getElementById('tmpInap2').style.display = 'table-row';
			document.getElementById('trTmpJln').style.display = 'none';
			document.getElementById('trPMedik').style.display = 'none';
			document.getElementById('trJnsKunj').style.display = 'none';
			document.getElementById('trJenisM').style.display = 'none';
			document.getElementById('trTempatM').style.display = 'none';
		}else if(tipe==5){
			 document.getElementById('trDilayani').style.display='none';
			 document.getElementById('trJns').style.display='table-row';
			 document.getElementById('trTmp').style.display='none';
			 document.getElementById('trJnsIgd').style.display='none';
			 document.getElementById('trTmpIgd').style.display='none';
			 document.getElementById('trJenis').style.display='none';
			 document.getElementById('trTempat').style.display='none';
			 document.getElementById('jnsInap').style.display = 'none';
			 document.getElementById('tmpInap').style.display = 'none';
			 document.getElementById('jnsInap2').style.display = 'none';
			 document.getElementById('tmpInap2').style.display = 'none';
			 document.getElementById('trTmpJln').style.display = 'table-row';
			 document.getElementById('trPMedik').style.display = 'none';
			 document.getElementById('trJnsKunj').style.display = 'none';
			 document.getElementById('trJenisM').style.display = 'none';
			 document.getElementById('trTempatM').style.display = 'none';
		}else if(tipe==6){
			 document.getElementById('trDilayani').style.display='none';
			 document.getElementById('trJns').style.display='none';
			 document.getElementById('trTmp').style.display='none';
			 document.getElementById('trJnsIgd').style.display='none';
			 document.getElementById('trTmpIgd').style.display='none';
			 document.getElementById('trJenis').style.display='none';
			 document.getElementById('trTempat').style.display='none';
			 document.getElementById('jnsInap').style.display = 'none';
			 document.getElementById('tmpInap').style.display = 'none';
			 document.getElementById('jnsInap2').style.display = 'none';
			 document.getElementById('tmpInap2').style.display = 'none';
			 document.getElementById('trTmpJln').style.display = 'none';
			 document.getElementById('trPMedik').style.display = 'table-row';
			 document.getElementById('trJnsKunj').style.display = 'table-row';
			 document.getElementById('trJenisM').style.display = 'none';
			 document.getElementById('trTempatM').style.display = 'none';
		}else if(tipe==12){    
			 document.getElementById('trJenisM').style.display = 'table-row';
			 document.getElementById('trTempatM').style.display = 'table-row';
			 document.getElementById('trDilayani').style.display='none';
			 document.getElementById('trJns').style.display='none';
			 document.getElementById('trTmp').style.display='none';
			 document.getElementById('trJnsIgd').style.display='none';
			 document.getElementById('trTmpIgd').style.display='none';
			 document.getElementById('trJenis').style.display='none';
			 document.getElementById('trTempat').style.display='none';
			 document.getElementById('jnsInap').style.display = 'none';
			 document.getElementById('tmpInap').style.display = 'none';
			 document.getElementById('jnsInap2').style.display = 'none';
			 document.getElementById('tmpInap2').style.display = 'none';
			 document.getElementById('trTmpJln').style.display = 'none';
			 document.getElementById('trPMedik').style.display = 'none';
			 document.getElementById('trJnsKunj').style.display = 'none';
		}else if(tipe==13){    
			 document.getElementById('trJenisM').style.display = 'none';
			 document.getElementById('trTempatM').style.display = 'none';
			 document.getElementById('trDilayani').style.display='none';
			 document.getElementById('trJns').style.display='none';
			 document.getElementById('trTmp').style.display='none';
			 document.getElementById('trJnsIgd').style.display='none';
			 document.getElementById('trTmpIgd').style.display='none';
			 document.getElementById('trJenis').style.display='none';
			 document.getElementById('trTempat').style.display='none';
			 document.getElementById('jnsInap').style.display = 'none';
			 document.getElementById('tmpInap').style.display = 'none';
			 document.getElementById('jnsInap2').style.display = 'none';
			 document.getElementById('tmpInap2').style.display = 'none';
			 document.getElementById('trTmpJln').style.display = 'none';
			 document.getElementById('trPMedik').style.display = 'none';
			 document.getElementById('trJnsKunj').style.display = 'none';
			 document.getElementById('trPenjamin').style.display='none';
		}else if(tipe==7){
			document.getElementById('trDilayani').style.display='none';
			document.getElementById('trJns').style.display='none';
			document.getElementById('trTmp').style.display='none';
			document.getElementById('trJnsIgd').style.display='none';
			document.getElementById('trTmpIgd').style.display='none';
			document.getElementById('trJenis').style.display='none';
			document.getElementById('trTempat').style.display='none';
			document.getElementById('jnsInap').style.display = 'none';
			document.getElementById('tmpInap').style.display = 'none';
			document.getElementById('jnsInap2').style.display = 'none';
			document.getElementById('tmpInap2').style.display = 'none';
			document.getElementById('trTmpJln').style.display = 'none';
			document.getElementById('trPMedik').style.display = 'none';
			document.getElementById('trJnsKunj').style.display = 'none';
			document.getElementById('trJenisM').style.display = 'none';
			document.getElementById('trTempatM').style.display = 'none';
		}
	}
	
	function reset_default(){
	isiCombo('JnsLayanan','','','',showTmpLay);
	}
	
	function popupReport1(){
		isiCombo1('JnsLayanan','','','',showTmpLay);
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='BukuRegisterPasien.php';
	}
	
	function popupReport36(){
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='downtime.php';
	}
	
	function popupReport37(){
		document.getElementById('cmbWaktu').value='Bulanan';
		document.getElementById('cmbWaktu').style.display='none';
		setBln(document.getElementById('cmbWaktu').value);
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='RekapProduksi.php';
	}
	
	function popupReport2(){
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='BukuDiagPasien.php';
	}	
	function popupReport3(){
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='BukuTindPasien.php';
	}
	
	function popupReport4(){
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='RujukanPenunjangMedik.php';
	}
	
	function popupReport5(){
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='Pemeriksaan_baru.php';
	}
	
	function popupReport5_new(){
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='Pemeriksaan_baru_dokter.php';
	}
	
	function popupReport6(){
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='PengirimanKonsul.php';
	}
	
	function popupReport7(){
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='PenerimaanKonsul.php';
	}
	
	function popupReport8(){
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='KegLayananPasien.php';
	}
	
	function popupReport9(){
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='KunjPas.php';
	}
	
	function popupReport10(){
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='RekapKunj.php';
	}
	
	function popupReport11(){
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='BukuTransaksiTindakan.php';
	}
	
	function popupReport12(){
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='KunjTmpLay.php';
	}
	
	function popupReport13(){
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='KunjKso.php';
	}
	
	function popupReport14(){
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='AsalPasien.php';
	}
	
	function popupReport15(){
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='KasusPenyakit.php';
	}
	
	function popupReport16(){
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='CaraKeluar.php';
	}
	
	function popupReport17(){
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='CaraBayar.php';
	}
	
	function popupReport18(){
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='KasusPenyakitTmptLay.php';
	}
	
	function popupReport19(){
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='CaraKeluarTmpLay.php';
	}
	
	function popupReport20(){
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='CaraMasuk.php';
	}
	
	function popupReport21(){
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='Diagnosis.php';
	}
	
	function popupReport22(){
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='10Diagnosis.php';
	}
	
	function popupReport22_n(){
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='pasien_batal.php';
	}
	
	function popupReport23(){
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='Pendapatan.php';
	}
	
	function popupReport24(){
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='blangko.php';
	}
	
	function popupReport25(){
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='Penerimaan.php';
	}
	
	function popupReport26(){
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='KlaimJaminan.php';
	}
	
	function popupReport27(){
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='InformasiKunjungan.php';
	}
	
	function popupReport28(){
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='pasienKeluar.php';
	}
	
	function popupReport29(){
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='triage.php';
	}
	
	function popupReport30(){
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='pasienmrs.php';
	}
	
	function popupReport31(){
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='rekap_pasien.php';
	}
	
	function popupReport32(){
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='tt.php';
	}
	
	function popupReport33(){
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='BukuRegisterPMedik.php';
	}
	function popupReport34(){
		document.getElementById('cmbWaktu').value= '';
		setBln();
		changeM();
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='pulpak.php';
    } 
	function popupReport35(){
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='laplab.php';
    } 
</script>
</html>