<?php
	
	include("../sesi.php");
	$userId = $_SESSION['userId'];
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
<!-- untuk ajax-->

<title>Pelaksanan Layanan</title>
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
		<td height="30">&nbsp;FORM PELAKSANA LAYANAN</td>
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
<script>


var mTab=new TabView("TabView");
mTab.setTabCaption("SPESIALISASI PELAKSANA,PELAKSANA LAYANAN,SETTING PELAKSANA, SETTING GAJI DOKTER");
mTab.setTabCaptionWidth("310,310,320,310");
mTab.onLoaded(showgrid);
mTab.setTabPage("pel_tab1.php,pel_tab2.php,pel_tab3.php,gaji_dokter.php");
//tabview_width("TabView","60,90,60");

var tab1;
var tab2;
/*
gridPop=new DSGridObject("gridboxtab");
gridPop.setHeader("SPESIALISASI PELAKSANA");	
gridPop.setColHeader("NO,KODE,NAMA,AKTIF");
gridPop.setIDColHeader(",kode,nama,aktif");
gridPop.setColWidth("10,20,90,60");
gridPop.setCellAlign("center,left,left,center");
gridPop.setCellHeight(20);
gridPop.setImgPath("../icon");
gridPop.setIDPaging("pagingtab");
gridPop.attachEvent("onRowClick","ambilData(tab1)");
gridPop.baseURL("pelaksana_layanan_utils.php?grd=tab1");
gridPop.Init();
*/
function goFilterAndSort(grd)
{
	//alert(grd);
	if (grd=="gridboxtab1")
	{		
		tab1.loadURL("pelaksana_layanan_utils.php?grd=tab1&filter="+tab1.getFilter()+"&sorting="+tab1.getSorting()+"&page="+tab1.getPage(),"","GET");
	}
	else if (grd=="gridboxtab2")
	{		
		tab2.loadURL("pelaksana_layanan_utils.php?grd=tab2&filter="+tab2.getFilter()+"&sorting="+tab2.getSorting()+"&page="+tab2.getPage(),"","GET");
	}
	else if(grd=="gridboxtab3a"){
		tab3a.loadURL("pelaksana_layanan_utils.php?grd=tab3a&filter="+tab3a.getFilter()+"&unitId="+document.getElementById('TmpLayanan').value+"&sorting="+tab3a.getSorting()+"&page="+tab3a.getPage(),"","GET");
	}
	else if(grd=="gridboxtab3b"){
		tab3b.loadURL("pelaksana_layanan_utils.php?grd=tab3b&filter="+tab3b.getFilter()+"&unitId="+document.getElementById('TmpLayanan').value+"&sorting="+tab3b.getSorting()+"&page="+tab3b.getPage(),"","GET");
	}
}

function set(val)
{
	if(val=='2')
	{
		document.getElementById('trtxtUid').style.visibility = 'visible';
		document.getElementById('trtxtPass').style.visibility = 'visible';
		document.getElementById('trtxtConPass').style.visibility = 'visible';
	}
	else
	{
		document.getElementById('trtxtUid').style.visibility = 'collapse';
		document.getElementById('trtxtPass').style.visibility = 'collapse';
		document.getElementById('trtxtConPass').style.visibility = 'collapse';
	}
}
	
function showgrid()
{
	tab1=new DSGridObject("gridboxtab1");
	tab1.setHeader("SPESIALISASI PELAKSANA");	
	tab1.setColHeader("NO,NAMA,AKTIF");
	tab1.setIDColHeader(",nama,aktif");
	tab1.setColWidth("10,120,45");
	tab1.setCellAlign("center,left,center");
	tab1.setCellHeight(20);
	tab1.setImgPath("../icon");
	tab1.setIDPaging("pagingtab1");
	tab1.attachEvent("onRowClick","ambilDataTab1");
	tab1.baseURL("pelaksana_layanan_utils.php?grd=tab1");
	tab1.Init();
	
	tab2=new DSGridObject("gridboxtab2");
	tab2.setHeader("PELAKSANA LAYANAN");	
	tab2.setColHeader("NO,NIP,SIP,NAMA,SPESIALISASI");
	tab2.setIDColHeader(",nip,sip,nama,snama");
	tab2.setColWidth("20,60,60,100,60");
	tab2.setCellAlign("center,left,left,left,left");
	tab2.setCellHeight(20);
	tab2.setImgPath("../icon");
	tab2.setIDPaging("pagingtab2");
	tab2.attachEvent("onRowClick","ambilDataTab2");
	tab2.baseURL("pelaksana_layanan_utils.php?grd=tab2");
	tab2.Init();
	
	
	tab3a=new DSGridObject("gridboxtab3a");
	tab3a.setHeader("TEMPAT LAYANAN");	
	tab3a.setColHeader("<input type='checkbox' id='chk_tab3a' onchange='cek_all(this.id)' />,NAMA PELAKSANA");
	tab3a.setIDColHeader(",nama");
	tab3a.setColWidth("30,400");
	tab3a.setCellAlign("center,left");
	tab3a.setCellType("chk,txt");
	tab3a.setCellHeight(20);
	tab3a.setImgPath("../icon");
	tab3a.setIDPaging("pagingtab3a");
	//tab3a.attachEvent("onRowDblClick","tes1");
	tab3a.baseURL("pelaksana_layanan_utils.php?grd=tab3a");
	tab3a.Init();
	//alert("pelaksana_layanan_utils.php?grd=tab3a");
	
	tab3b=new DSGridObject("gridboxtab3b");
	tab3b.setHeader("TEMPAT LAYANAN");	
	tab3b.setColHeader("<input type='checkbox' id='chk_tab3b' onchange='cek_all(this.id)' />,NAMA");
	tab3b.setIDColHeader(",nama");
	tab3b.setColWidth("30,400");
	tab3b.setCellAlign("center,left");
	tab3b.setCellType("chk,txt");
	tab3b.setCellHeight(20);
	tab3b.setImgPath("../icon");
	tab3b.setIDPaging("pagingtab3b");
	tab3b.onLoaded(reloadTab3a);
	//tab3b.attachEvent("onRowDblClick","tes1");
	tab3b.baseURL("pelaksana_layanan_utils.php?grd=tab3b");
	tab3b.Init();
	
	isiCombo('JnsLayanan','','','cmbJnsLay',isiTmpLay);
	
}


function cek_all(a){
	if(a=='chk_tab3a'){
		if(document.getElementById(a).checked){
			for(var i=0;i<tab3a.obj.childNodes[0].rows.length;i++){	
				tab3a.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked = true;		
			}
		}
		else{
			for(var i=0;i<tab3a.obj.childNodes[0].rows.length;i++){	
				tab3a.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked = false;		
			}
		}
	}
	else if(a=='chk_tab3b'){
		if(document.getElementById(a).checked){
			for(var i=0;i<tab3b.obj.childNodes[0].rows.length;i++){	
				tab3b.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked = true;		
			}
		}
		else{
			for(var i=0;i<tab3b.obj.childNodes[0].rows.length;i++){	
				tab3b.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked = false;		
			}
		}
	}
}

function reloadTab3a(){
	tab3a.loadURL("pelaksana_layanan_utils.php?grd=tab3a&unitId="+document.getElementById('TmpLayanan').value,"","GET");	
}

function isiTmpLay(){
	//alert(document.getElementById('cmbJnsLay').value);
	isiCombo('TmpLayanan',document.getElementById('cmbJnsLay').value,'','',ubahUnit);
}
function ubahUnit(){
	//alert("pelaksana_layanan_utils.php?grd=tab3&unitId="+document.getElementById('TmpLayanan').value);
	tab3b.loadURL("pelaksana_layanan_utils.php?grd=tab3b&unitId="+document.getElementById('TmpLayanan').value,"","GET");
	tab3a.loadURL("pelaksana_layanan_utils.php?grd=tab3a&unitId="+document.getElementById('TmpLayanan').value,"","GET");
}
/*function goFilterAndSort(grd){
	//alert(grd);
	if (grd=="gridboxtab1"){
		//alert("pelaksana_layanan_utils.php?grd=1&filter="+tab1.getFilter()+"&sorting="+tab1.getSorting()+"&page="+tab1.getPage());
		tab1.loadURL("pelaksana_layanan_utils.php?grd=tab1&filter="+tab1.getFilter()+"&sorting="+tab1.getSorting()+"&page="+tab1.getPage(),"","GET");
	}
}*/

function simpan(action,tabName){
	if(tabName=='tab1'){
		if(ValidateForm("txtSpe")){
		var id=document.getElementById("txtId").value;
		//var kode=document.getElementById("txtKode").value;
		var spe=document.getElementById("txtSpe").value;
		var flag=document.getElementById("flag").value;		
		if(document.getElementById("chAktif").checked==true){
		var aktif=1;
		}
		else{
			var aktif=0;
		}
		
		//alert("pelaksana_layanan_utils.php?grd=tab1&act="+action+"&id="+id+"&kode="+kode+"&spe="+spe+"&aktif="+aktif);
		tab1.loadURL("pelaksana_layanan_utils.php?grd=tab1&act="+action+"&id="+id+"&spe="+spe+"&flag="+flag+"&aktif="+aktif,"","GET");
		}
	}
	else if(tabName=='tab2'){
		//var idUser=<?php echo $iduser;?>;
		var id=document.getElementById("txtId").value;		
		var nip=document.getElementById("txtNip").value;
		var sip=document.getElementById("txtSip").value;
		var flag=document.getElementById("flag").value;
		var nama=document.getElementById("txtNama").value;
		var tmpLhr=document.getElementById("txtTmpLhr").value;
		var tglLhr=document.getElementById("txtTglLhr").value;
		var alamat=document.getElementById("txtAlamat").value;
		var tlp=document.getElementById("txtTelp").value;
		var hp=document.getElementById("txtHp").value;
		var sex=document.getElementById("cmbSex").value;
		var agama=document.getElementById("cmbAgama").value;
		var cmbStatus=document.getElementById("cmbStatus").value;
		var peg=document.getElementById("cmbPeg").value;
		var peg2=document.getElementById("cmbPeg2").value;
		var spe=document.getElementById("cmbSpe").value;
		//var unitId=document.getElementById("cmbUnit").value;
		var uid=document.getElementById("txtUid").value;
		var pass=document.getElementById("txtPass").value;
		var conPass=document.getElementById("txtConPass").value;
		var aktif=0;
		if(document.getElementById("chAktif2").checked==true){
			aktif=1;
		}
		if(pass!=conPass){
			alert("Konfirmasi password tidak sama");
			return false;
		}
	//alert("pelaksana_layanan_utils.php?grd=tab2&act="+action+"&id="+id+"&nip="+nip+"&nama="+nama+"&tmpLhr="+tmpLhr+"&tglLhr="+tglLhr+"&alamat="+alamat+"&tlp="+tlp+"&hp="+hp+"&sex="+sex+"&agama="+agama+"&cmbStatus="+cmbStatus+"&peg="+peg+"&peg2="+peg2+"&spe="+spe+"&uid="+uid+"&pass="+pass+"&conPass="+conPass+"&chAktif="+aktif+"&idUser=<?php echo $userId;?>");
		tab2.loadURL("pelaksana_layanan_utils.php?grd=tab2&act="+action+"&id="+id+"&nip="+nip+"&sip="+sip+"&flag="+flag+"&nama="+nama+"&tmpLhr="+tmpLhr+"&tglLhr="+tglLhr+"&alamat="+alamat+"&tlp="+tlp+"&hp="+hp+"&sex="+sex+"&agama="+agama+"&cmbStatus="+cmbStatus+"&peg="+peg+"&peg2="+peg2+"&spe="+spe+"&uid="+uid+"&pass="+pass+"&conPass="+conPass+"&chAktif="+aktif+"&idUser=<?php echo $userId;?>","","GET");
	}
	batal(tabName);
}

function hapus(tabName){
	if(tabName=='tab1'){
		var rowid = document.getElementById("txtId").value;
		//alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
		if(confirm("Anda yakin menghapus "+tab1.cellsGetValue(tab1.getSelRow(),3))){
			tab1.loadURL("pelaksana_layanan_utils.php?grd=tab1&act=hapus&rowid="+rowid,"","GET");
		}
	}
	else if(tabName=='tab2'){
		var rowid = document.getElementById("txtId").value;
		//alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
		if(confirm("Anda yakin menghapus "+tab2.cellsGetValue(tab2.getSelRow(),3))){
			tab2.loadURL("pelaksana_layanan_utils.php?grd=tab2&act=hapus&rowid="+rowid,"","GET");
		}
	}
	batal(tabName);
}

function ambilDataTab1(){	
	var p="txtId*-*"+(tab1.getRowId(tab1.getSelRow()))+"*|*txtSpe*-*"+tab1.cellsGetValue(tab1.getSelRow(),2)+"*|*chAktif*-*"+((tab1.cellsGetValue(tab1.getSelRow(),3)=='Aktif')?'true':'false')+"*|*btnSimpan*-*Simpan*|*btnHapus*-*false"; //alert(p);
	fSetValue(window,p);
}
function ambilDataTab2(){
	var fromId=String(tab2.getRowId(tab2.getSelRow())).split("|");	
	var p="txtId*-*"+fromId[0]+"*|*txtNip*-*"+tab2.cellsGetValue(tab2.getSelRow(),2)+"*|*txtSip*-*"+tab2.cellsGetValue(tab2.getSelRow(),3)+"*|*txtNama*-*"+tab2.cellsGetValue(tab2.getSelRow(),4)+"*|*txtTmpLhr*-*"+fromId[4]+"*|*txtTglLhr*-*"+fromId[5]+"*|*txtAlamat*-*"+fromId[6]+"*|*txtTelp*-*"+fromId[7]+"*|*txtHp*-*"+fromId[8]+"*|*cmbSex*-*"+fromId[2]+"*|*cmbAgama*-*"+fromId[3]+"*|*cmbStatus*-*"+fromId[1]+"*|*cmbPeg*-*"+fromId[10]+"*|*cmbPeg2*-*"+fromId[14]+"*|*cmbSpe*-*"+fromId[9]+"*|*txtUid*-*"+fromId[13]+"*|*txtPass*-**|*txtConPass*-**|*chAktif2*-*"+fromId[12]+"*|*btnSimpan2*-*Simpan*|*btnHapus2*-*false";
	fSetValue(window,p);
	set(document.getElementById("cmbStatus").value);
	if (fromId[12]==1){
		document.getElementById("chAktif2").checked=true;
	}else{
		document.getElementById("chAktif2").checked=false;
	}
}

function batal(tabName){
	if(tabName=='tab1'){
		var p="txtId*-**|*txtSpe*-**|*chAktif*-*true*|*btnSimpan*-*Tambah*|*btnHapus*-*true";
	}
	else if(tabName=='tab2'){
		var p="txtId*-**|*txtNip*-**|*txtNama*-**|*txtTmpLhr*-**|*txtTglLhr*-**|*txtAlamat*-**|*txtTelp*-**|*txtHp*-**|*txtUid*-**|*txtPass*-**|*txtConPass*-**|*chAktif*-*true*|*btnSimpan2*-*Tambah*|*btnHapus2*-*true";
		document.getElementById("txtPass").value="";
		document.getElementById("txtConPass").value="";
	} 
	fSetValue(window,p);
}
function isiCombo(id,val,defaultId,targetId,evloaded){
	//alert('pasien_list.php?act=combo&id='+id+'&value='+val);
	if(targetId=='' || targetId==undefined){
		targetId=id;
	}
	Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded);
	
}
var idTin='';
function pindahKanan(){
	for(var i=0;i<tab3a.obj.childNodes[0].rows.length;i++){
		if(tab3a.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked){
			var barisId=tab3a.getRowId(parseInt(i)+1);			
			idTin+=barisId+',';	
		}
	}
	//alert(idTin);		
	if(idTin==''){
		alert("Silakan pilih pelaksana!");
	}
	else{
		//var sisip=tab3a.getRowId(tab3a.getSelRow()).split("|");
		//alert("pelaksana_layanan_utils.php?grd=tab3b&act=tambah&id="+idTin+"&unitId="+document.getElementById('TmpLayanan').value);
		tab3b.loadURL("pelaksana_layanan_utils.php?grd=tab3b&act=tambah&id="+idTin+"&unitId="+document.getElementById('TmpLayanan').value+"&flag="+document.getElementById('flag').value,"","GET");
		
		idTin='';
	}
}

var idTinUnit='';
function pindahKiri(){		
	for(var i=0;i<tab3b.obj.childNodes[0].rows.length;i++){
		if(tab3b.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked){
			var barisId=tab3b.getRowId(parseInt(i)+1);			
			idTinUnit+=barisId+',';	
		}
	}
	//alert(idTin);		
	if(idTinUnit==''){
		alert("Silakan pilih pelaksana unit!");
	}
	else{
		//var sisip=tab3b.getRowId(tab3b.getSelRow()).split("|");
		//alert("pelaksana_layanan_utils.php?grd=tab3b&act=hapus&id="+idTinUnit+"&unitId="+document.getElementById('TmpLayanan').value);
		tab3b.loadURL("pelaksana_layanan_utils.php?grd=tab3b&act=hapus&id="+idTinUnit+"&unitId="+document.getElementById('TmpLayanan').value+"&flag="+document.getElementById('flag').value,"","GET");
		idTinUnit='';
	}
}
</script>
</html>
