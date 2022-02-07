<?
include("../../sesi.php");
?>
<?php
    //session_start();
    $userId = $_SESSION['userId'];
    $date_now=gmdate('d-m-Y',mktime(date('H')+7));
    $date_skr=explode('-',$date_now);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link type="text/css" rel="stylesheet" href="../../theme/mod.css" />
    <script type="Text/JavaScript" language="JavaScript" src="../../theme/js/dsgrid.js"></script>
    
    <!--dibawah ini diperlukan untuk menampilkan popup-->
    <link rel="stylesheet" type="text/css" href="../../theme/popup.css" />
    <script type="text/javascript" src="../../theme/prototype.js"></script>
    <script type="text/javascript" src="../../theme/effects.js"></script>
    <script type="text/javascript" src="../../theme/popup.js"></script>
    <!--diatas ini diperlukan untuk menampilkan popup-->
    
    <!-- untuk ajax-->
    <script type="text/javascript" src="../../theme/js/ajax.js"></script>
    <!-- end untuk ajax-->
    
    <title>Laporan Kunjungan</title>
</head>

<body>
    <iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../../theme/popcjs.php" scrolling="no"
	frameborder="1"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
    </iframe>
    <div align="center">
	<?php
	    include("../../header1.php");
	    include("../../koneksi/konek.php");
	    include("report_form.php");
	    $date_now=gmdate('d-m-Y',mktime(date('H')+7));
	?>
	<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
	    <tr>
		<td height="30">&nbsp;LAPORAN REKAM MEDIS</td>
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
				<li><a href="javascript:void(0)" onclick="popupReport16();variabel=0;sts=1;tipe=5;pil=0;change()">Rekapitulasi Register Rawat Jalan</a></li>
				<li><a href="javascript:void(0)" onclick="popupReport1();variabel=1;sts=1;tipe=0;pil=0;change()">Kunjungan Pasien</a></li>
				<li><a href="javascript:void(0)" onclick="popupReport2();variabel=1;sts=1;tipe=0;pil=0;change()">Daftar Verifikasi Diagnosis PP</a></li>
				<li><a href="javascript:void(0)" onclick="popupReport3();variabel=1;sts=1;tipe=0;pil=0;change()">Asal Pasien Berdasarkan Tempat Layanan</a></li>
				<li><a href="javascript:void(0)" onclick="popupReport4();variabel=1;sts=1;tipe=0;pil=0;change()">Asal Rujukan Pasien Berdasarkan Tempat Layanan</a></li>
				<li><a href="javascript:void(0)" onclick="popupReport5();variabel=1;sts=1;tipe=0;pil=0;change()">Cara Bayar Pasien Berdasarkan Tempat Layanan</a></li>
				<li><a href="javascript:void(0)" onclick="popupReport6();variabel=1;sts=1;tipe=0;pil=0;change()">Kasus Penyakit Pasien Berdasarkan Tempat Layanan</a></li>
				<li><a href="javascript:void(0)" onclick="popupReport7();variabel=1;sts=1;tipe=0;pil=0;change()">Cara Keluar Pasien Berdasarkan Tempat Layanan</a></li>
				<li><a href="javascript:void(0)" onclick="popupReport8();variabel=1;sts=1;tipe=0;pil=0;change()">Penerimaan Konsul Tempat Layanan</a></li>
				<li><a href="javascript:void(0)" onclick="popupReport9();variabel=1;sts=1;tipe=0;pil=0;change()">Pengiriman Konsul Tempat Layanan</a></li>
				<li><a href="javascript:void(0)" onclick="popupReport10();variabel=1;sts=1;tipe=0;pil=0;change()">Rujukan Penunjang Medik</a></li>
				<li><a href="javascript:void(0)" onclick="popupReport11();variabel=1;sts=1;tipe=0;pil=0;change()">Diagnosis Pasien Berdasarkan Tempat Layanan</a></li>
				<li><a href="javascript:void(0)" onclick="popupReport30();variabel=1;sts=1;tipe=12;pil=0;change()">Diagnosis Pasien Per Diagnosa dan Tempat Layanan</a></li>
				<li><a href="javascript:void(0)" onclick="popupReport12();variabel=1;sts=1;tipe=2;pil=0;change()">15 Diagnosis Pasien Berdasarkan Tempat Layanan</a></li>
				<li><a href="javascript:void(0)" onclick="popupReport28();variabel=0;sts=1;tipe=10;pil=0;change()">10 Diagnosis Pasien Meninggal Berdasarkan Tempat Layanan</a></li>
				<!--li><a href="javascript:void(0)" onclick="popupReport13();variabel=0;change()">10 Diagnosis Terbanyak PP Pasien Berdasarkan Tempat Layanan</a></li-->
				<li><a href="javascript:void(0)" onclick="popupReport14();variabel=1;sts=2;tipe=9;pil=0;change()">Keadaan Morbiditas Pasien Berdasarkan Dinkes</a></li>
                <li><a href="javascript:void(0)" onclick="popupReport141();variabel=1;sts=1;tipe=8;pil=0;change()">Keadaan Morbiditas Pasien Berdasarkan Tempat Layanan</a></li>
				<li><a href="javascript:void(0)" onclick="popupReport15();variabel=1;sts=1;tipe=0;pil=0;change()">Kegiatan Pelayanan Tempat Layanan</a></li>
				<li><a href="javascript:void(0)" onclick="popupReport17();variabel=0;sts=0;tipe=1;pil=0;change()">Rekapitulasi Tindakan/Pemeriksaan Tempat Layanan Penunjang</a></li>
				<li><a href="javascript:void(0)" onclick="popupReport21();variabel=0;sts=1;tipe=3;pil=0;change()">Rekapitulasi Data Pasien Masuk</a></li>
				<li><a href="javascript:void(0)" onclick="popupReport22();variabel=0;sts=1;tipe=4;pil=0;change()">Rekapitulasi Data Pasien Keluar</a></li>
				<li><a href="javascript:void(0)" onclick="popupReport19();variabel=0;sts=1;tipe=1;pil=0;change()">Rekapitulasi Pendapatan & Jumlah Penderita Tempat Layanan Penunjang</a></li>
				<!--li><a href="javascript:void(0)" onclick="popupReport18();variabel=0;sts=0;tipe=0;change()">Rekapitulasi Tindakan/Pemeriksaan Tempat Layanan Asal Rawat Jalan</a></li-->
				<li><a href="javascript:void(0)" onclick="popupReport23();variabel=0;sts=1;tipe=6;pil=0;change()">Rekapitulasi Harian Pasien Rawat Inap</a></li>
				<!--li><a href="javascript:void(0)" onclick="popupReport21();variabel=0;sts=1;penunjang=0;change()">Rekapitulasi Pendapatan & Jumlah Penderita Tempat Layanan Asal Rawat Jalan</a></li-->
				<li><a href="javascript:void(0)" onclick="popupReport24();variabel=0;sts=2;tipe=7;pil=1;change()">Data Pasien Gangguan Mental dan Perilaku Akibat Penggunaan Napza</a></li>
				<li><a href="javascript:void(0)" onclick="popupReport25();variabel=0;sts=2;tipe=7;pil=0;change()">Rekapitulasi Data Kesakitan Program Kesehatan Jiwa</a></li>
				<li><a href="javascript:void(0)" onclick="popupReport27();variabel=0;sts=2;tipe=7;pil=1;change()">Rekapitulasi Kegiatan Kesehatan Jiwa</a></li>
				<li><a href="javascript:void(0)" onclick="popupReport29();variabel=1;sts=2;tipe=2;pil=0;change()">Rekapitulasi Komplikasi Akibat Penggunaan Napza</a></li>
				<li><a href="javascript:void(0)" onclick="popupReport26();variabel=1;sts=2;tipe=2;pil=1;change()">Rekapitulasi Jenis Obat Yang Dipergunakan Pada Pasien Gangguan Mental Dan Perilaku Akibat Penggunaan Napza Menurut Pekerjaannya</a></li>
				<li><a href="javascript:void(0)" onclick="popupReport20();variabel=1;sts=1;tipe=0;pil=0;change()">Cara Bayar Berdasarkan Tempat Layanan Inap</a></li>
                <li><a href="javascript:void(0)" onclick="popupReport31();variabel=1;sts=2;tipe=12;pil=0;change()">Rekapitulasi Data Pasien Keluar Pulang Paksa</a></li>
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
	    <tr>
		<td height="30">&nbsp;</td>
		<td>&nbsp;</td>
		<td align="right">&nbsp;</td>
	    </tr>
	</table>
    </div>
</body>
<script type="Text/JavaScript">
    var arrRange=depRange=[];
    isiCombo('JnsLayanan','','','',showTmpLay);
	isiCombo('JnsLayanan15','','','',showTmpLay);
    function showTmpLay(){
		isiCombo('TmpLayanan',document.getElementById('JnsLayanan').value);
		isiCombo('TmpLayananBukanInap',document.getElementById('JnsLayanan').value);
		isiCombo('TmpLayananPsi',document.getElementById('JnsLayanan').value);
		isiCombo1('TmpLayanan15',document.getElementById('JnsLayanan15').value);
    }
    isiCombo1('StatusPas');
    isiCombo('cmbJnsPenunjang','','','',showTmpLay2);
    function showTmpLay2(){
		isiCombo1('cmbTmpPenunjang',document.getElementById('cmbJnsPenunjang').value);
    }
    isiCombo1('cmbTempatLayanan',document.getElementById('cmbJenisLayanan').value);
    isiCombo('JnsLayananInapSaja','','','',showTmpLay3);
    function showTmpLay3(){
		isiCombo('TmpLayananInapSaja',document.getElementById('JnsLayananInapSaja').value);
    }
    
    function isiCombo(id,val,defaultId,targetId,evloaded){
	if(targetId=='' || targetId==undefined){
	    targetId=id;
	}
	//alert('../../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId);
	    Request('../../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,id,'','GET',evloaded);
    }
    
    function isiCombo1(id,val,defaultId,targetId,evloaded){
	if(targetId=='' || targetId==undefined){
	    targetId=id;
	}
	//alert('../../combo_utils.php?all=1&id='+id+'&value='+val+'&defaultId='+defaultId);
	Request('../../combo_utils.php?all=1&id='+id+'&value='+val+'&defaultId='+defaultId,id,'','GET',evloaded);
    }
	
	function fIsiCombo(id,val,defaultId,targetId,evloaded){
		if(targetId=='' || targetId==undefined){
			targetId=id;
		}
		//alert('../../combo_utils.php?all=1&id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded);
		Request('../../combo_utils.php?all=1&id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded);
	}
    
    function ubah(){
	if(document.getElementById('cmbWaktu').value=="Harian"){
	    document.getElementById('tglAwal').value = document.getElementById('tglAwal2').value;
	    document.getElementById('tglAkhir').value = document.getElementById('tglAwal2').value;
	}
    }
    
    function setBln(val){
	if(val=='Harian'){
	    document.getElementById('trBulan').style.display = "none";
	    document.getElementById('trPeriode').style.display = "none";
	    //document.getElementById('tglAwal').value = '<?=$date_now?>';
	    //document.getElementById('tglAkhir').value = '<?=$date_now?>';
	    document.getElementById('trHarian').style.display = "block";
	}else if(val=='Bulanan'){
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
	    for(thAwal;thAwal<thAkhir;thAwal++){
		document.getElementById('cmbThn').innerHTML =
		document.getElementById('cmbThn').innerHTML+'<option>'+thAwal+'</option>';
	    }
	    document.getElementById('cmbBln').value = '<?php echo $date_skr[1];?>';
	    document.getElementById('cmbThn').value = thSkr;
	}else if(val=='Rentang Waktu'){
	    document.getElementById('trPeriode').style.display = "block";
	    document.getElementById('trBulan').style.display = "none";
	    document.getElementById('trHarian').style.display = "none";
	}else{
	    document.getElementById('trPeriode').style.display = "none";
	    document.getElementById('trBulan').style.display = "none";
	    document.getElementById('trHarian').style.display = "none";
	}
    }
	    
    function bulanan(){
	var bulan = document.getElementById("cmbBln").value;
	var tahun = document.getElementById("cmbThn").value;
	var akhir;
	document.getElementById("tglAwal").value = '01-'+bulan+'-'+tahun;
	if(bulan == 2){
	    if((tahun%4 == 0) && (tahun%100 != 0)){
		akhir = 29;
	    }else{
		akhir = 28;
	    }
	}else if(bulan<=7){
	    if(bulan%2 == 0){
		akhir = 30;
	    }else{
		akhir = 31;
	    }
	}else if(bulan>7){
	    if(bulan%2 == 0){
		akhir = 31;
	    }else{
		akhir = 30;
	    }
	}
	document.getElementById("tglAkhir").value = akhir+'-'+bulan+'-'+tahun;
    }
		    
    var variabel;
    var sts;
    var tipe;
	var pil;
	
	function changeM(){
		//alert('asdasdas');
		isiCombo1('cmbTempatLayananM',document.getElementById('cmbJenisLayananM').value,'0','cmbTempatLayananM');   
	}
	
	function change15(){
		
		isiCombo1('TmpLayanan15',document.getElementById('JnsLayanan15').value,'0','TmpLayanan15');   
	}
	
    function change(){
	//alert(tipe);
	if(variabel==1){
	    //isiCombo1('TmpLayanan',document.getElementById('JnsLayanan').value);
	    isiCombo1('cmbTmpPenunjang',document.getElementById('cmbJnsPenunjang').value);
	    isiCombo1('cmbTempatLayanan',document.getElementById('cmbJenisLayanan').value);
		isiCombo1('cmbTmpInap',document.getElementById('cmbTmpInap').value);
		//fIsiCombo(id,val,defaultId,targetId,evloaded)
		fIsiCombo('TmpLayanan15',document.getElementById('JnsLayanan').value,'','TmpLayanan','NoLoad');
	}else{
	    isiCombo('TmpLayanan',document.getElementById('JnsLayanan').value);
	    isiCombo('TmpLayananPsi',document.getElementById('JnsLayanan').value);
	    isiCombo('cmbTmpPenunjang',document.getElementById('cmbJnsPenunjang').value);
	    isiCombo('TmpLayananInapSaja',document.getElementById('JnsLayananInapSaja').value);
	    isiCombo('TmpLayananBukanInap',document.getElementById('JnsLayanan').value);
	}
	
	if(sts==1){
	    isiCombo1('StatusPas');
		 document.getElementById('stsPas').style.display = "table-row";
	}else if(sts==0){
	    isiCombo('StatusPas');
		 document.getElementById('stsPas').style.display = "table-row";
	}else{
	    document.getElementById('stsPas').style.display = "none";
	}
	if(pil==0){
		document.getElementById('rwPilih').style.display = "table-row";
		document.getElementById('trTri').style.display = "none";
	}else{
		document.getElementById('rwPilih').style.display = "none";
		document.getElementById('trTri').style.display = "table-row";
	}
	if(tipe==1){
	    document.getElementById('rjri').style.display = 'table-row';
	    document.getElementById('trJns').style.display = 'none';
	    document.getElementById('trTmp').style.display = 'none';
	    document.getElementById('trTmpJln').style.display = 'none';
	    document.getElementById('trPenunjang').style.display = 'table-row';
	    document.getElementById('tdPenunjang').style.display = 'table-row';
	    document.getElementById('trJenis').style.display = 'none';
	    document.getElementById('trTempat').style.display = 'none';
	    document.getElementById('jnsInap').style.display = 'none';
	    document.getElementById('tmpInap').style.display = 'none';
	    document.getElementById('stsKunj').style.display = 'none';
	    document.getElementById('stsKunj2').style.display = 'none';
		document.getElementById('trKeadaanKeluar').style.display = 'none';
	    document.getElementById('trTmpPsi').style.display = 'none';
		document.getElementById('trD').style.display = 'none';
		document.getElementById('trLb').style.display = 'table-row';
		document.getElementById('trJenisM').style.display = 'none';
		document.getElementById('trTempatM').style.display = 'none';
		document.getElementById('trKecelakaan').style.display = 'none';
		document.getElementById('trJns15').style.display = 'none';
	    document.getElementById('trTmp15').style.display = 'none';
		document.getElementById('trJnsInap').style.display = 'none';
	    document.getElementById('trTmpInap').style.display = 'none';
	}else if(tipe==0){
	    document.getElementById('rjri').style.display = 'none';
	    document.getElementById('trJns').style.display = 'table-row';
	    document.getElementById('trTmp').style.display = 'table-row';
	    document.getElementById('trTmpJln').style.display = 'none';
	    document.getElementById('trPenunjang').style.display = 'none';
	    document.getElementById('tdPenunjang').style.display = 'none';
	    document.getElementById('trJenis').style.display = 'none';
	    document.getElementById('trTempat').style.display = 'none';
	    document.getElementById('jnsInap').style.display = 'none';
	    document.getElementById('tmpInap').style.display = 'none';
	    document.getElementById('stsKunj').style.display = 'none';
	    document.getElementById('stsKunj2').style.display = 'none';
		document.getElementById('trKeadaanKeluar').style.display = 'none';
	    document.getElementById('trTmpPsi').style.display = 'none';
		document.getElementById('trD').style.display = 'none';
		document.getElementById('trLb').style.display = 'none';
		document.getElementById('trJenisM').style.display = 'none';
		document.getElementById('trTempatM').style.display = 'none';
		document.getElementById('trKecelakaan').style.display = 'none';
		document.getElementById('trJns15').style.display = 'none';
	    document.getElementById('trTmp15').style.display = 'none';
		document.getElementById('trJnsInap').style.display = 'none';
	    document.getElementById('trTmpInap').style.display = 'none';
	}else if(tipe==2){
	    document.getElementById('rjri').style.display = 'none';
	    document.getElementById('trJns').style.display = 'none';
	    document.getElementById('trTmp').style.display = 'none';
	    document.getElementById('trTmpJln').style.display = 'none';
	    document.getElementById('trPenunjang').style.display = 'none';
	    document.getElementById('tdPenunjang').style.display = 'none';
	    document.getElementById('trJenis').style.display = 'table-row';
	    document.getElementById('trTempat').style.display = 'table-row';
	    document.getElementById('jnsInap').style.display = 'none';
	    document.getElementById('tmpInap').style.display = 'none';
	    document.getElementById('stsKunj').style.display = 'none';
	    document.getElementById('stsKunj2').style.display = 'none';
		document.getElementById('trKeadaanKeluar').style.display = 'none';
	    document.getElementById('trTmpPsi').style.display = 'none';
		document.getElementById('trD').style.display = 'none';
		document.getElementById('trLb').style.display = 'none';
		document.getElementById('trJenisM').style.display = 'none';
		document.getElementById('trTempatM').style.display = 'none';
		document.getElementById('trKecelakaan').style.display = 'none';
		document.getElementById('trJns15').style.display = 'none';
	    document.getElementById('trTmp15').style.display = 'none';
		document.getElementById('trJnsInap').style.display = 'none';
	    document.getElementById('trTmpInap').style.display = 'none';
	}else if(tipe==3){
	    document.getElementById('rjri').style.display = 'none';
	    document.getElementById('trJns').style.display = 'none';
	    document.getElementById('trTmp').style.display = 'none';
	    document.getElementById('trTmpJln').style.display = 'none';
	    document.getElementById('trPenunjang').style.display = 'none';
	    document.getElementById('tdPenunjang').style.display = 'none';
	    document.getElementById('trJenis').style.display = 'none';
	    document.getElementById('trTempat').style.display = 'none';
	    document.getElementById('jnsInap').style.display = 'none';
	    document.getElementById('tmpInap').style.display = 'none';
	    document.getElementById('stsKunj').style.display = 'table-row';
	    document.getElementById('stsKunj2').style.display = 'none';
		document.getElementById('trKeadaanKeluar').style.display = 'none';
	    document.getElementById('trTmpPsi').style.display = 'none';
		document.getElementById('trD').style.display = 'none';
		document.getElementById('trLb').style.display = 'none';
		
		document.getElementById('trJenisM').style.display = 'table-row';
		document.getElementById('trTempatM').style.display = 'table-row';
		
		//document.getElementById('trJenisM').style.display = 'none';
		//document.getElementById('trTempatM').style.display = 'none';
		document.getElementById('trKecelakaan').style.display = 'none';
		document.getElementById('trJns15').style.display = 'none';
	    document.getElementById('trTmp15').style.display = 'none';
		document.getElementById('trJnsInap').style.display = 'none';
	    document.getElementById('trTmpInap').style.display = 'none';
	}else if(tipe==4){
	    document.getElementById('rjri').style.display = 'none';
	    document.getElementById('trJns').style.display = 'none';
	    document.getElementById('trTmp').style.display = 'none';
	    document.getElementById('trTmpJln').style.display = 'none';
	    document.getElementById('trPenunjang').style.display = 'none';
	    document.getElementById('tdPenunjang').style.display = 'none';
	    document.getElementById('trJenis').style.display = 'none';
	    document.getElementById('trTempat').style.display = 'none';
	    document.getElementById('jnsInap').style.display = 'none';
	    document.getElementById('tmpInap').style.display = 'none';
	    document.getElementById('stsKunj').style.display = 'none';
	    document.getElementById('stsKunj2').style.display = 'table-row';
		document.getElementById('trKeadaanKeluar').style.display = 'table-row';
	    document.getElementById('trTmpPsi').style.display = 'none';
		document.getElementById('trD').style.display = 'none';
		document.getElementById('trLb').style.display = 'none';
		document.getElementById('trJenisM').style.display = 'table-row';
		document.getElementById('trTempatM').style.display = 'table-row';
		document.getElementById('trKecelakaan').style.display = 'none';
		document.getElementById('trJns15').style.display = 'none';
	    document.getElementById('trTmp15').style.display = 'none';
		document.getElementById('trJnsInap').style.display = 'none';
	    document.getElementById('trTmpInap').style.display = 'none';
	}else if(tipe==5){
	    document.getElementById('rjri').style.display = 'none';
	    document.getElementById('trJns').style.display = 'table-row';
	    document.getElementById('trTmp').style.display = 'none';
	    document.getElementById('trTmpJln').style.display = 'table-row';
	    document.getElementById('trPenunjang').style.display = 'none';
	    document.getElementById('tdPenunjang').style.display = 'none';
	    document.getElementById('trJenis').style.display = 'none';
	    document.getElementById('trTempat').style.display = 'none';
	    document.getElementById('jnsInap').style.display = 'none';
	    document.getElementById('tmpInap').style.display = 'none';
	    document.getElementById('stsKunj').style.display = 'none';
	    document.getElementById('stsKunj2').style.display = 'none';
		document.getElementById('trKeadaanKeluar').style.display = 'none';
	    document.getElementById('trTmpPsi').style.display = 'none';
		document.getElementById('trD').style.display = 'none';
		document.getElementById('trLb').style.display = 'none';
		document.getElementById('trJenisM').style.display = 'none';
		document.getElementById('trTempatM').style.display = 'none';
		document.getElementById('trKecelakaan').style.display = 'none';
		document.getElementById('trJns15').style.display = 'none';
	    document.getElementById('trTmp15').style.display = 'none';
		document.getElementById('trJnsInap').style.display = 'none';
	    document.getElementById('trTmpInap').style.display = 'none';
	}else if(tipe==6){
	    document.getElementById('rjri').style.display = 'none';
	    document.getElementById('trJns').style.display = 'none';
	    document.getElementById('trTmp').style.display = 'none';
	    document.getElementById('trTmpJln').style.display = 'none';
	    document.getElementById('trPenunjang').style.display = 'none';
	    document.getElementById('tdPenunjang').style.display = 'none';
	    document.getElementById('trJenis').style.display = 'none';
	    document.getElementById('trTempat').style.display = 'none';
	    document.getElementById('jnsInap').style.display = 'table-row';
	    document.getElementById('tmpInap').style.display = 'table-row';
	    document.getElementById('stsKunj').style.display = 'none';
	    document.getElementById('stsKunj2').style.display = 'none';
		document.getElementById('trKeadaanKeluar').style.display = 'none';
	    document.getElementById('trTmpPsi').style.display = 'none';
		document.getElementById('trD').style.display = 'none';
		document.getElementById('trLb').style.display = 'none';
		document.getElementById('trJenisM').style.display = 'none';
		document.getElementById('trTempatM').style.display = 'none';
		document.getElementById('trKecelakaan').style.display = 'none';
		document.getElementById('trJns15').style.display = 'none';
	    document.getElementById('trTmp15').style.display = 'none';
		document.getElementById('trJnsInap').style.display = 'none';
	    document.getElementById('trTmpInap').style.display = 'none';
	}else if(tipe==7){    
	    document.getElementById('rjri').style.display = 'none';
	    document.getElementById('trJns').style.display = 'table-row';
	    document.getElementById('trTmp').style.display = 'none';
	    document.getElementById('trTmpPsi').style.display = 'table-row';
	    document.getElementById('trTmpJln').style.display = 'none';
	    document.getElementById('trPenunjang').style.display = 'none';
	    document.getElementById('tdPenunjang').style.display = 'none';
	    document.getElementById('trJenis').style.display = 'none';
	    document.getElementById('trTempat').style.display = 'none';
	    document.getElementById('jnsInap').style.display = 'none';
	    document.getElementById('tmpInap').style.display = 'none';
	    document.getElementById('stsKunj').style.display = 'none';
	    document.getElementById('stsKunj2').style.display = 'none';
		document.getElementById('trKeadaanKeluar').style.display = 'none';
		document.getElementById('trD').style.display = 'none';
		document.getElementById('trLb').style.display = 'none';
		document.getElementById('trJenisM').style.display = 'none';
		document.getElementById('trTempatM').style.display = 'none';
		document.getElementById('trKecelakaan').style.display = 'none';
		document.getElementById('trJns15').style.display = 'none';
	    document.getElementById('trTmp15').style.display = 'none';
		document.getElementById('trJnsInap').style.display = 'none';
	    document.getElementById('trTmpInap').style.display = 'none';
	}else if(tipe==8){    
	    document.getElementById('rjri').style.display = 'none';
	    document.getElementById('trJns').style.display = 'none';
	    document.getElementById('trTmp').style.display = 'none';
	    document.getElementById('trTmpPsi').style.display = 'none';
	    document.getElementById('trTmpJln').style.display = 'none';
	    document.getElementById('trPenunjang').style.display = 'none';
	    document.getElementById('tdPenunjang').style.display = 'none';
	    document.getElementById('trJenis').style.display = 'none';
		document.getElementById('trJenisM').style.display = 'table-row';
		document.getElementById('trTempatM').style.display = 'table-row';
		document.getElementById('trKecelakaan').style.display = 'table-row';
	    document.getElementById('trTempat').style.display = 'none';
	    document.getElementById('jnsInap').style.display = 'none';
	    document.getElementById('tmpInap').style.display = 'none';
	    document.getElementById('stsKunj').style.display = 'none';
	    document.getElementById('stsKunj2').style.display = 'none';
		document.getElementById('trKeadaanKeluar').style.display = 'none';
		document.getElementById('trD').style.display = 'none';
		document.getElementById('trLb').style.display = 'none';
		document.getElementById('trJns15').style.display = 'none';
	    document.getElementById('trTmp15').style.display = 'none';
		document.getElementById('trJnsInap').style.display = 'none';
	    document.getElementById('trTmpInap').style.display = 'none';
	}else if(tipe==9){    
	    document.getElementById('rjri').style.display = 'none';
	    document.getElementById('trJns').style.display = 'none';
	    document.getElementById('trTmp').style.display = 'none';
	    document.getElementById('trTmpPsi').style.display = 'none';
	    document.getElementById('trTmpJln').style.display = 'none';
	    document.getElementById('trPenunjang').style.display = 'none';
	    document.getElementById('tdPenunjang').style.display = 'none';
	    document.getElementById('trJenis').style.display = 'none';
		document.getElementById('trJenisM').style.display = 'table-row';
		document.getElementById('trTempatM').style.display = 'table-row';
		document.getElementById('trKecelakaan').style.display = 'table-row';
	    document.getElementById('trTempat').style.display = 'none';
	    document.getElementById('jnsInap').style.display = 'none';
	    document.getElementById('tmpInap').style.display = 'none';
	    document.getElementById('stsKunj').style.display = 'none';
	    document.getElementById('stsKunj2').style.display = 'none';
		document.getElementById('trKeadaanKeluar').style.display = 'none';
		document.getElementById('trD').style.display = 'none';
		document.getElementById('trLb').style.display = 'none';
		document.getElementById('trJns15').style.display = 'none';
	    document.getElementById('trTmp15').style.display = 'none';
		document.getElementById('trJnsInap').style.display = 'none';
	    document.getElementById('trTmpInap').style.display = 'none';
	}else if(tipe==10){    
	    document.getElementById('rjri').style.display = 'none';
	    document.getElementById('trJns').style.display = 'none';
	    document.getElementById('trTmp').style.display = 'none';
	    document.getElementById('trTmpPsi').style.display = 'none';
	    document.getElementById('trTmpJln').style.display = 'none';
	    document.getElementById('trPenunjang').style.display = 'none';
	    document.getElementById('tdPenunjang').style.display = 'none';
	    document.getElementById('trJenis').style.display = 'none';
		document.getElementById('trJenisM').style.display = 'none';
		document.getElementById('trTempatM').style.display = 'none';
		document.getElementById('trKecelakaan').style.display = 'none';
	    document.getElementById('trTempat').style.display = 'none';
	    document.getElementById('jnsInap').style.display = 'none';
	    document.getElementById('tmpInap').style.display = 'none';
	    document.getElementById('stsKunj').style.display = 'none';
	    document.getElementById('stsKunj2').style.display = 'none';
		document.getElementById('trKeadaanKeluar').style.display = 'none';
		document.getElementById('trD').style.display = 'none';
		document.getElementById('trLb').style.display = 'none';
		document.getElementById('trJns15').style.display = 'table-row';
	    document.getElementById('trTmp15').style.display = 'table-row';
		document.getElementById('trJnsInap').style.display = 'none';
	    document.getElementById('trTmpInap').style.display = 'none';
	}else if(tipe==11){    
	    document.getElementById('rjri').style.display = 'none';
	    document.getElementById('trJns').style.display = 'none';
	    document.getElementById('trTmp').style.display = 'none';
	    document.getElementById('trTmpPsi').style.display = 'none';
	    document.getElementById('trTmpJln').style.display = 'none';
	    document.getElementById('trPenunjang').style.display = 'none';
	    document.getElementById('tdPenunjang').style.display = 'none';
	    document.getElementById('trJenis').style.display = 'none';
	    document.getElementById('trTempat').style.display = 'none';
	    document.getElementById('jnsInap').style.display = 'none';
	    document.getElementById('tmpInap').style.display = 'none';
	    document.getElementById('stsKunj').style.display = 'none';
	    document.getElementById('stsKunj2').style.display = 'none';
		document.getElementById('trKeadaanKeluar').style.display = 'none';
		document.getElementById('trD').style.display = 'none';
		document.getElementById('trLb').style.display = 'none';
		document.getElementById('trJenisM').style.display = 'none';
		document.getElementById('trTempatM').style.display = 'none';
		document.getElementById('trKecelakaan').style.display = 'none';
		document.getElementById('trJns15').style.display = 'none';
	    document.getElementById('trTmp15').style.display = 'none';
		document.getElementById('trJnsInap').style.display = 'table-row';
	    document.getElementById('trTmpInap').style.display = 'table-row';
	}
	else if(tipe==12){    
	    document.getElementById('rjri').style.display = 'none';
	    document.getElementById('trJns').style.display = 'none';
	    document.getElementById('trTmp').style.display = 'none';
	    document.getElementById('trTmpPsi').style.display = 'none';
	    document.getElementById('trTmpJln').style.display = 'none';
	    document.getElementById('trPenunjang').style.display = 'none';
	    document.getElementById('tdPenunjang').style.display = 'none';
	    document.getElementById('trJenis').style.display = 'none';
		document.getElementById('trJenisM').style.display = 'table-row';
		document.getElementById('trTempatM').style.display = 'table-row';
		document.getElementById('trKecelakaan').style.display = 'none';
	    document.getElementById('trTempat').style.display = 'none';
	    document.getElementById('jnsInap').style.display = 'none';
	    document.getElementById('tmpInap').style.display = 'none';
	    document.getElementById('stsKunj').style.display = 'none';
	    document.getElementById('stsKunj2').style.display = 'none';
		document.getElementById('trKeadaanKeluar').style.display = 'none';
		document.getElementById('trD').style.display = 'none';
		document.getElementById('trLb').style.display = 'none';
		document.getElementById('trJns15').style.display = 'none';
	    document.getElementById('trTmp15').style.display = 'none';
		document.getElementById('trJnsInap').style.display = 'none';
	    document.getElementById('trTmpInap').style.display = 'none';
	}
	else{    
	    document.getElementById('rjri').style.display = 'none';
		document.getElementById('trD').style.display = 'table-row';
	    document.getElementById('trJns').style.display = 'table-row';
	    document.getElementById('trTmp').style.display = 'table-row';
	    document.getElementById('trTmpJln').style.display = 'none';
	    document.getElementById('trPenunjang').style.display = 'none';
	    document.getElementById('tdPenunjang').style.display = 'none';
	    document.getElementById('trJenis').style.display = 'none';
	    document.getElementById('trTempat').style.display = 'none';
	    document.getElementById('jnsInap').style.display = 'none';
	    document.getElementById('tmpInap').style.display = 'none';
	    document.getElementById('stsKunj').style.display = 'none';
	    document.getElementById('stsKunj2').style.display = 'none';
		document.getElementById('trKeadaanKeluar').style.display = 'none';
	    document.getElementById('trTmpPsi').style.display = 'none';
		document.getElementById('trLb').style.display = 'none';
		document.getElementById('trJenisM').style.display = 'none';
		document.getElementById('trTempatM').style.display = 'none';
		document.getElementById('trKecelakaan').style.display = 'none';
		document.getElementById('trJns15').style.display = 'none';
	    document.getElementById('trTmp15').style.display = 'none';
		document.getElementById('trJnsInap').style.display = 'none';
	    document.getElementById('trTmpInap').style.display = 'none';
	}
    }
    
    function popupReport1(){
	document.getElementById('cmbWaktu').value= '';
	setBln();
	new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
	$('popup_div1').popup.show();
	document.getElementById('form1').action='kunjungan_pasien.php';
    }
    
    function popupReport2(){
	document.getElementById('cmbWaktu').value= '';
	setBln();
	new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
	$('popup_div1').popup.show();
	document.getElementById('form1').action='dftr_verifikasi.php';
    }
    
    function popupReport3(){
	document.getElementById('cmbWaktu').value= '';
	setBln();
	new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
	$('popup_div1').popup.show();
	document.getElementById('form1').action='AsalPasTmptLay.php';
    }
    
    function popupReport4(){
	document.getElementById('cmbWaktu').value= '';
	setBln();
	new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
	$('popup_div1').popup.show();
	document.getElementById('form1').action='AsalRujTmptLay.php';
    }
    
    function popupReport5(){
	document.getElementById('cmbWaktu').value= '';
	setBln();
	new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
	$('popup_div1').popup.show();
	//document.getElementById('form1').action='CaraBayarTmptLay.php';
	document.getElementById('form1').action='../tempatlayanan/CaraBayar.php';
    }
    
    function popupReport6(){
	document.getElementById('cmbWaktu').value= '';
	setBln();
	new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
	$('popup_div1').popup.show();
	document.getElementById('form1').action='KasusPenyakitTmptLay.php';
    }
    
    function popupReport7(){
	document.getElementById('cmbWaktu').value= '';
	setBln();
	new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
	$('popup_div1').popup.show();
	document.getElementById('form1').action='CaraKeluarTmptLay.php';
    }
    
    function popupReport8(){
	document.getElementById('cmbWaktu').value= '';
	setBln();
	new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
	$('popup_div1').popup.show();
	document.getElementById('form1').action='PenerimaanKonsul.php';
    }
    
    function popupReport9(){
	document.getElementById('cmbWaktu').value= '';
	setBln();
	new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
	$('popup_div1').popup.show();
	document.getElementById('form1').action='PengirimKonsul.php';
    }
    
    function popupReport10(){
	document.getElementById('cmbWaktu').value= '';
	setBln();
	new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
	$('popup_div1').popup.show();
	document.getElementById('form1').action='RujukanPenunjangMedik.php';
    }
    
    function popupReport11(){
	document.getElementById('cmbWaktu').value= '';
	setBln();
	new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
	$('popup_div1').popup.show();
	document.getElementById('form1').action='DiagnosisPasien.php';
    }
    
    function popupReport12(){
	document.getElementById('cmbWaktu').value= '';
	setBln();
	new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
	$('popup_div1').popup.show();
	document.getElementById('form1').action='10DiagnosisTerbanyak.php';
    }
    
    /*function popupReport13()
    {
    document.getElementById('cmbWaktu').value= '';
    setBln();
    new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
    $('popup_div1').popup.show();
    document.getElementById('form1').action='10DiagnosisPP.php';
    }*/
    
    function popupReport14(){
	document.getElementById('cmbWaktu').value= '';
	setBln();
	new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
	$('popup_div1').popup.show();
	document.getElementById('form1').action='rl4a.php';
	document.getElementById('laporan').value = 'morbiditas';
	changeM();
	document.getElementById('chkKecelakaan').checked = '';
    }
	
	function popupReport141(){
	document.getElementById('cmbWaktu').value= '';
	setBln();
	new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
	$('popup_div1').popup.show();
	changeM();
	document.getElementById('laporan').value = 'morbiditasTL';
	document.getElementById('form1').action='Morbiditas.php';
	document.getElementById('chkKecelakaan').checked = '';
    }
    
    function popupReport15(){
	document.getElementById('cmbWaktu').value= '';
	setBln();
	new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
	$('popup_div1').popup.show();
	document.getElementById('form1').action='kegiatanPelayanan.php';
    }
    
    function popupReport16(){
	document.getElementById('cmbWaktu').value= '';
	setBln();
	new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
	$('popup_div1').popup.show();
	document.getElementById('form1').action='rekapitulasi_register.php';
    }
    
    function popupReport17(){
	document.getElementById('cmbWaktu').value= '';
	setBln();
	new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
	$('popup_div1').popup.show();
	document.getElementById('form1').action='RekapTindakanPenunjang.php';
    }
    
    /* function popupReport18()
    {
    document.getElementById('cmbWaktu').value= '';
    setBln();
    new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
    $('popup_div1').popup.show();
    document.getElementById('form1').action='RekapTindakanJalan.php';
    } */
    
    function popupReport19(){
	document.getElementById('cmbWaktu').value= '';
	setBln();
	new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
	$('popup_div1').popup.show();
	document.getElementById('form1').action='RekapPendapatanPenunjang.php';
    }
    
    function popupReport20(){
	document.getElementById('cmbWaktu').value= '';
	setBln();
	new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
	$('popup_div1').popup.show();
	document.getElementById('form1').action='CaraBayarInap.php';
    }
    
    function popupReport21(){
	document.getElementById('cmbWaktu').value= '';
	setBln();
	document.getElementById('laporan').value = 'RekapPasienMasuk';
	changeM();
	new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
	$('popup_div1').popup.show();
	document.getElementById('form1').action='masukJalan.php';
    } 
    
    function popupReport22(){
	document.getElementById('cmbWaktu').value= '';
	setBln();
	document.getElementById('laporan').value = 'RekapPasienKeluar';
	changeM();
	new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
	$('popup_div1').popup.show();
	$('popup_div1').scrollTo();
	document.getElementById('form1').action='keluarInap.php';
    } 
    
    function popupReport23(){
	document.getElementById('cmbWaktu').value= '';
	setBln();
	new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
	$('popup_div1').popup.show();
	document.getElementById('form1').action='rekapHarian.php';
    }
    
    function popupReport24(){
	document.getElementById('cmbWaktu').value= '';
	setBln();
	new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
	$('popup_div1').popup.show();
	document.getElementById('form1').action='mental.php';
    }
    
    function popupReport25(){
	document.getElementById('cmbWaktu').value= '';
	setBln();
	new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
	$('popup_div1').popup.show();
	document.getElementById('form1').action='data_kesakitan.php';
    }
    
    function popupReport26(){
	document.getElementById('cmbWaktu').value= '';
	setBln();
	new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
	$('popup_div1').popup.show();
	document.getElementById('form1').action='jns_obat.php';
    } 
    
    function popupReport27(){
	document.getElementById('cmbWaktu').value= '';
	setBln();
	new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
	$('popup_div1').popup.show();
	document.getElementById('form1').action='lap_jiwa.php';
    } 
    
    function popupReport28(){
	document.getElementById('cmbWaktu').value= '';
	setBln();
	new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
	$('popup_div1').popup.show();
	document.getElementById('form1').action='10DiagnosisTerbanyak_mati.php';
	//change15();
    } 
    
    function popupReport29(){
	document.getElementById('cmbWaktu').value= '';
	setBln();
	new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
	$('popup_div1').popup.show();
	document.getElementById('form1').action='komplikasi_napza.php';
    } 
	
	function popupReport30(){
	document.getElementById('cmbWaktu').value= '';
	setBln();
	changeM();
	new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
	$('popup_div1').popup.show();
	document.getElementById('form1').action='diagnosaPer.php';
    } 
	
	function popupReport31(){
	document.getElementById('cmbWaktu').value= '';
	setBln();
	changeM();
	new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
	$('popup_div1').popup.show();
	document.getElementById('form1').action='pulpak.php';
    } 
    </script>
</html>