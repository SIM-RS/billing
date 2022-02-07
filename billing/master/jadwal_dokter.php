<?php
	session_start();
	include("../sesi.php");
	$userId = $_SESSION['userId'];
	$spesialis = $_SESSION['spesialis'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
<link rel="stylesheet" type="text/css" href="../theme/tab-view.css" />
<script type="text/javascript" src="../theme/js/tab-view.js"></script>

<!--dibawah ini diperlukan untuk menampilkan popup-->
<link rel="stylesheet" type="text/css" href="../theme/popup.css" />
<script type="text/javascript" src="../theme/prototype.js"></script>
<script type="text/javascript" src="../theme/effects.js"></script>
<script type="text/javascript" src="../theme/popup.js"></script>
<!--diatas ini diperlukan untuk menampilkan popup-->

<!-- untuk ajax-->
<script type="text/javascript" src="../theme/js/ajax.js"></script>
<script type="text/javascript" src="../include/jquery/jquery-1.9.1.js"></script>
<script type="text/javascript" src="../report_rm/js/jquery.timeentry.js"></script>
<!-- untuk ajax-->

<title>Jadwal Dokter</title>
</head>

<body>
	
<div align="center">
<?php
	include("../koneksi/konek.php");
	include("../header1.php");
?>
<script>
var arrRange=depRange=[];
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
	frameborder="1"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/dsgrid_sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
	<tr>
		<td height="30">&nbsp;FORM JADWAL DOKTER</td>
	</tr>
</table>
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center" class="tabel">  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center"><div class="TabView" id="TabView" style="width: 940px; height: 500px;"></div></td>
  </tr>
   <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  </table>
  <table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
  <tr height="30">
   	<td width="20%">&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" /></td>
	<td width="30%" align="right"><a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;"/></a>&nbsp;</td>
  </tr>
</table>

</div>

</body>
<script type="text/javascript">


var mTab=new TabView("TabView");
mTab.setTabCaption("MASTER JADWAL DOKTER,JADWAL DOKTER,PERUBAHAN JADWAL DOKTER");
mTab.setTabCaptionWidth("333,333,333");
mTab.onLoaded(showgrid);
mTab.setTabPage("jadwal_dokter_master.php,jadwal_dokter_generate.php,jadwal_dokter_ubah.php");

var tab1;
var tab2;
var tab3;

function goFilterAndSort(grd){
	if (grd=="gridboxtab1"){		
		tab1.loadURL("jadwal_dokter_master_utils.php?unit_id="+document.getElementById('TmpLayanan').value+"&filter="+tab1.getFilter()+"&sorting="+tab1.getSorting()+"&page="+tab1.getPage(),"","GET");
	}
	else if (grd=="gridboxtab2"){		
		var unit_id = document.getElementById('TmpLayanan2').value;
		var tglAwal = document.getElementById('tglAwal').value;
		var tglAkhir = document.getElementById('tglAkhir').value;
		tab2.loadURL("jadwal_dokter_generate_utils.php?act=generate&unit_id="+unit_id+'&tgl_awal='+tglAwal+'&tgl_akhir='+tglAkhir+"&filter="+tab2.getFilter()+"&sorting="+tab2.getSorting()+"&page="+tab2.getPage(),"","GET");
	}
	else if (grd=="gridboxtab3"){		
		//tab3.loadURL("jadwal_dokter_ubah_utils.php?unit_id="+document.getElementById('TmpLayanan').value+"&filter="+tab1.getFilter()+"&sorting="+tab1.getSorting()+"&page="+tab1.getPage(),"","GET");
		var unit_id = document.getElementById('TmpLayanan3').value;
		var tglAwal = document.getElementById('tglAwal2').value;
		var tglAkhir = document.getElementById('tglAkhir2').value;
		tab3.loadURL("jadwal_dokter_ubah_utils.php?unit_id="+unit_id+'&tgl_awal='+tglAwal+'&tgl_akhir='+tglAkhir+"&filter="+tab3.getFilter()+"&sorting="+tab3.getSorting()+"&page="+tab3.getPage(),"","GET");
	}
}
	
function showgrid(){
	isiCombo('JnsLayanan','','','cmbJnsLay',isiTmpLay);
	isiCombo('JnsLayanan','','','cmbJnsLay2',isiTmpLay2);
	isiCombo('JnsLayanan','','','cmbJnsLay3',isiTmpLay3);
	
	tab1=new DSGridObject("gridboxtab1");
	tab1.setHeader("MASTER JADWAL DOKTER");	
	tab1.setColHeader("NO,NAMA,NIP,HARI,WAKTU");
	tab1.setIDColHeader(",p.nama,nip,hari,jam");
	tab1.setColWidth("30,400,150,170,150");
	tab1.setCellAlign("center,left,center,left,center");
	tab1.setCellHeight(20);
	tab1.setImgPath("../icon");
	tab1.setIDPaging("pagingtab1");
	tab1.attachEvent("onRowClick","ubah");
	tab1.baseURL("jadwal_dokter_master_utils.php");
	tab1.Init();
	
	tab2=new DSGridObject("gridboxtab2");
	tab2.setHeader("JADWAL DOKTER");	
	tab2.setColHeader("NO,TANGGAL,WAKTU,NAMA,NIP");
	tab2.setIDColHeader(",tgl,jam,p.nama,nip");
	tab2.setColWidth("30,150,120,400,200");
	tab2.setCellAlign("center,center,center,left,center");
	tab2.setCellHeight(20);
	tab2.setImgPath("../icon");
	tab2.setIDPaging("pagingtab2");
	tab2.baseURL("jadwal_dokter_generate_utils.php");
	tab2.Init();
	
	tab3=new DSGridObject("gridboxtab3");
	tab3.setHeader("PERUBAHAN JADWAL DOKTER");	
	tab3.setColHeader("NO,NAMA,NIP,TANGGAL,HARI,WAKTU");
	tab3.setIDColHeader(",p.nama,nip,,hari,jam");
	tab3.setColWidth("30,300,150,120,120,150");
	tab3.setCellAlign("center,left,center,left,left,center");
	tab3.setCellHeight(20);
	tab3.setImgPath("../icon");
	tab3.setIDPaging("pagingtab3");
	tab3.attachEvent("onRowClick","ubah2");
	tab3.baseURL("jadwal_dokter_ubah_utils.php?unit_id="+document.getElementById('TmpLayanan3').value+"&tgl_awal="+document.getElementById('tglAwal2').value+"&tgl_akhir="+document.getElementById('tglAkhir2').value);
	tab3.Init();
	
	$('#mulai, #selesai').timeEntry({show24Hours: true});
	$('#mulai2, #selesai2').timeEntry({show24Hours: true});
}

function isiTmpLay(){
	isiCombo('TmpLayanan',document.getElementById('cmbJnsLay').value,'','TmpLayanan',ubahUnit);
}
function isiTmpLay2(){
	isiCombo('TmpLayanan',document.getElementById('cmbJnsLay2').value,'','TmpLayanan2',ubahUnit2);
}
function isiTmpLay3(){
	isiCombo('TmpLayanan',document.getElementById('cmbJnsLay3').value,'','TmpLayanan3',ubahUnit3);
}

function ubahUnit(){
	tab1.loadURL("jadwal_dokter_master_utils.php?unit_id="+document.getElementById('TmpLayanan').value,"","GET");
}
function ubahUnit2(){
	var unit_id = document.getElementById('TmpLayanan2').value;
	var tglAwal = document.getElementById('tglAwal').value;
	var tglAkhir = document.getElementById('tglAkhir').value;
	tab2.loadURL("jadwal_dokter_generate_utils.php?unit_id="+unit_id+'&tgl_awal='+tglAwal+'&tgl_akhir='+tglAkhir,"","GET");
}
function ubahUnit3(){
	//tab3.loadURL("jadwal_dokter_ubah_utils.php?unit_id="+document.getElementById('TmpLayanan3').value,"","GET");
	var unit_id = document.getElementById('TmpLayanan3').value;
	var tglAwal = document.getElementById('tglAwal2').value;
	var tglAkhir = document.getElementById('tglAkhir2').value;
	tab3.loadURL("jadwal_dokter_ubah_utils.php?unit_id="+unit_id+'&tgl_awal='+tglAwal+'&tgl_akhir='+tglAkhir,"","GET");
}

function isiCombo(id,val,defaultId,targetId,evloaded){
	if(targetId=='' || targetId==undefined){
		targetId=id;
	}
	Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded);
}

function simpan(){
	var id = document.getElementById('id').value;
	var unit_id = document.getElementById('TmpLayanan').value;
	var dokter_id = document.getElementById('dokter_id').value;
	var hari = document.getElementById('hari').value;
	var mulai = document.getElementById('mulai').value;
	var selesai = document.getElementById('selesai').value;
	var flag = document.getElementById('flag').value;
	
	if(mulai == '' || selesai == '')
		alert('Lengkapi semua form!');
	else{
		if(parseInt(jQuery.ajax({type:'get', async:false, url:'jadwal_dokter_master_utils.php?act=cek&unit_id='+unit_id+'&dokter_id='+dokter_id+'&hari='+hari+'&mulai='+mulai+'&flag='+flag+'&selesai='+selesai}).responseText) > 0)
			alert('Jadwal tersebut bertabrakan dengan jadwal yang sudah ada!');
		else{
			tab1.loadURL("jadwal_dokter_master_utils.php?act=simpan&id="+id+'&unit_id='+unit_id+'&dokter_id='+dokter_id+'&hari='+hari+'&flag='+flag+'&mulai='+mulai+'&selesai='+selesai,"","GET");
			batal();
		}
	}
}

function simpan2(){
	var id = document.getElementById('id2').value;
	var unit_id = document.getElementById('TmpLayanan3').value;
	var dokter_id = document.getElementById('dokter_id2').value;
	var mulai = document.getElementById('mulai2').value;
	var selesai = document.getElementById('selesai2').value;
	var flag = document.getElementById('flag').value;
	
	if(mulai == '' || selesai == '')
		alert('Lengkapi semua form!');
	else{
		if(parseInt(jQuery.ajax({type:'get', async:false, url:'jadwal_dokter_ubah_utils.php?act=cek&unit_id='+unit_id+'&dokter_id='+dokter_id+'&hari='+hari+'&flag='+flag+'&mulai='+mulai+'&selesai='+selesai}).responseText) > 0)
			alert('Jadwal tersebut bertabrakan dengan jadwal yang sudah ada!');
		else{
			tab3.loadURL("jadwal_dokter_ubah_utils.php?act=simpan&id="+id+"&unit_id="+unit_id+"&dokter_id="+dokter_id+"&hari="+hari+"&mulai="+mulai+"&flag="+flag+"&selesai="+selesai+"&tgl_awal="+document.getElementById('tglAwal2').value+"&tgl_akhir="+document.getElementById('tglAkhir2').value,"","GET");
			batal();
		}
	}
}

function batal(){
	document.getElementById('id').value = '';
	document.getElementById('dokter_id').getElementsByTagName('option')[0].selected = true;
	document.getElementById('hari').getElementsByTagName('option')[0].selected = true;
	document.getElementById('mulai').value = '';
	document.getElementById('selesai').value = '';
	document.getElementById('btnTambah').value = 'Tambah';
	document.getElementById('btnHapus').disabled = true;
}

function batal2(){
	document.getElementById('id2').value = '';
	document.getElementById('dokter_id2').getElementsByTagName('option')[0].selected = true;
	document.getElementById('mulai2').value = '';
	document.getElementById('selesai2').value = '';
	document.getElementById('btnTambah2').value = 'Simpan';
	document.getElementById('btnHapus2').disabled = true;
}

function ubah(){
	var ids = tab1.getRowId(tab1.getSelRow()).split('||');
	document.getElementById('id').value = ids[0];
	document.getElementById('dokter_id').value = ids[1];
	document.getElementById('hari').value = ids[2];
	document.getElementById('mulai').value = ids[3];
	document.getElementById('selesai').value = ids[4];
	document.getElementById('btnTambah').value = 'Simpan';
	document.getElementById('btnHapus').disabled = false;
}

function ubah2(){
	var ids = tab3.getRowId(tab3.getSelRow()).split('||');
	document.getElementById('id2').value = ids[0];
	document.getElementById('dokter_id2').value = ids[1];
	document.getElementById('mulai2').value = ids[2];
	document.getElementById('selesai2').value = ids[3];
	document.getElementById('btnTambah2').value = 'Simpan';
	document.getElementById('btnHapus2').disabled = false;
}

function hapus(){
	if(confirm('Apakah anda yakin?')){
		var id = document.getElementById('id').value;
		var unit_id = document.getElementById('TmpLayanan').value;
		tab1.loadURL("jadwal_dokter_master_utils.php?act=hapus&id="+id+'&unit_id='+unit_id,"","GET");
		batal();
	}
}

function hapus2(){
	if(confirm('Apakah anda yakin?')){
		var id = document.getElementById('id2').value;
		var unit_id = document.getElementById('TmpLayanan3').value;
		var tglAwal = document.getElementById('tglAwal2').value;
		var tglAkhir = document.getElementById('tglAkhir2').value;
		tab3.loadURL("jadwal_dokter_ubah_utils.php?act=hapus&id="+id+'&unit_id='+unit_id+'&tgl_awal='+tglAwal+'&tgl_akhir='+tglAkhir,"","GET");
		batal2();
	}
}

function generate(){
	var unit_id = document.getElementById('TmpLayanan2').value;
	var tglAwal = document.getElementById('tglAwal').value;
	var tglAkhir = document.getElementById('tglAkhir').value;
	tab2.loadURL("jadwal_dokter_generate_utils.php?act=generate&unit_id="+unit_id+'&tgl_awal='+tglAwal+'&tgl_akhir='+tglAkhir,"","GET");
}
</script>
</html>
