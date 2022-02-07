<?php
session_start();
include("../sesi.php");
?>
<?php
//session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css">
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" type="text/css" href="../theme/tab-view.css" />
<script type="text/javascript" src="../theme/js/tab-view.js"></script>
<script type="text/javascript" src="../theme/js/ajax.js"></script>
<title>Pendukung Laboratorium</title>
</head>

<body>
<div align="center">
<?php
	include("../koneksi/konek.php");
	include("../header1.php");
?>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/dsgrid_sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
	<tr>
		<td height="30">&nbsp;FORM PENDUKUNG LABORATORIUM</td>
	</tr>
</table>
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center" class="tabel">  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center"><div class="TabView" id="TabView" style="width: 925px; height: 550px;"></div></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </table>
  <table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
  <tr height="30">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
</body>
<script>
var mTab=new TabView("TabView");
mTab.setTabCaption("MASTER SATUAN LAB,MASTER KELOMPOK PEMERIKSAAN,TINDAKAN PEMERIKSAAN LAB,NORMAL HASIL LABORATORIUM,MAPPING TINDAKAN - PEMERIKSAAN"); //MASTER KATEGORI<br/>NORMAL LAB
mTab.setTabCaptionWidth("180,180,180,180,180");
mTab.onLoaded(showgrid);
mTab.setTabPage("lab_tab1.php,lab_tab3.php,lab_tab4.php,lab_tab2.php,lab_tab5.php");
//mTab.
var tab1;
var tab2;
var tab3a;

function isiCombo(id,val,defaultId,targetId,evloaded)
        {
            if(targetId=='' || targetId==undefined)
            {
                targetId=id;
            }
            Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,id,'','GET',evloaded);
        }

function goFilterAndSort(grd){		
	if(grd=="gridboxtab1"){
		//alert("tarif_tempat_layanan_utils.php?grd=1&unitId="+document.getElementById('cmbUnit').value+"&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage());
		tab1.loadURL("labSatuan_utils.php?grd=true&filter="+tab1.getFilter()+"&sorting="+tab1.getSorting()+"&page="+tab1.getPage(),"","GET");
	}
	else if(grd=="gridboxtab2"){
		//alert("tarif_tempat_layanan_utils.php?grd=1&unitId="+document.getElementById('cmbUnit').value+"&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage());
		tab2.loadURL("labSatuan_utils.php?grd1=true&filter="+tab2.getFilter()+"&sorting="+tab2.getSorting()+"&page="+tab2.getPage(),"","GET");
	}
	else if(grd=="gridboxtab3"){
		//alert("tarif_tempat_layanan_utils.php?grd=1&unitId="+document.getElementById('cmbUnit').value+"&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage());
		tab3.loadURL("labSatuan_utils.php?grd2=true&filter="+tab3.getFilter()+"&sorting="+tab3.getSorting()+"&page="+tab3.getPage(),"","GET");
	}
	else if(grd=="gridboxtab4"){
		//alert("tarif_tempat_layanan_utils.php?grd=1&unitId="+document.getElementById('cmbUnit').value+"&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage());
		tab4.loadURL("labSatuan_utils.php?grd1=true&filter="+tab4.getFilter()+"&sorting="+tab4.getSorting()+"&page="+tab4.getPage(),"","GET");
	}
	else if(grd=="gridboxtab5"){
		//alert("tarif_tempat_layanan_utils.php?grd=1&unitId="+document.getElementById('cmbUnit').value+"&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage());
		tab5.loadURL("labSatuan_utils.php?grd4=true&filter="+tab5.getFilter()+"&sorting="+tab5.getSorting()+"&page="+tab5.getPage(),"","GET");
	}
	else if(grd=="grdtab5a"){
		// alert("lab_tab5_utils.php?grd=1&unitId=58&tind_id="+document.getElementById("tind_id").value+"&filter="+ltab5a.getFilter()+"&sorting="+ltab5a.getSorting()+"&page="+ltab5a.getPage());
		ltab5a.loadURL("lab_tab5_utils.php?grd=1&unitId=58&tind_id="+document.getElementById("tind_id").value+"&filter="+ltab5a.getFilter()+"&sorting="+ltab5a.getSorting()+"&page="+ltab5a.getPage(),"","GET");
	}
	else if(grd=="grdtab6a"){
		// alert("lab_tab5_utils.php?grd=1&unitId=58&tind_id="+document.getElementById("tind_id").value+"&filter="+ltab5a.getFilter()+"&sorting="+ltab5a.getSorting()+"&page="+ltab5a.getPage());
		ltab5a.loadURL("lab_tab6_utils.php?grd=1&unitId=58&tind_id="+document.getElementById("kelompokLab").value+"&filter="+ltab5a.getFilter()+"&sorting="+ltab5a.getSorting()+"&page="+ltab5a.getPage(),"","GET");
	}
	/* else if(grd=="gridboxtab52"){
		//alert("tarif_tempat_layanan_utils.php?grd=1&unitId="+document.getElementById('cmbUnit').value+"&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage());
		tab52.loadURL("labSatuan_utils.php?grd52=true&filter="+tab52.getFilter()+"&sorting="+tab52.getSorting()+"&page="+tab52.getPage(),"","GET");
	} */
}


function showgrid()
{
	tab1=new DSGridObject("gridboxtab1");
	tab1.setHeader("MASTER SATUAN LABORATORIUM");	
	tab1.setColHeader("NO,NAMA SATUAN,STATUS AKTIF");
	tab1.setIDColHeader(",nama_satuan,");
	tab1.setColWidth("50,400,200");
	tab1.setCellAlign("center,left,center");
	tab1.setCellHeight(20);
	tab1.setImgPath("../icon");
	tab1.setIDPaging("pagingtab1");
	tab1.attachEvent("onRowClick","ambilData");
	tab1.baseURL("labSatuan_utils.php?grd=true");
	tab1.Init();
	
	tab2=new DSGridObject("gridboxtab2");
	tab2.setHeader("NORMAL HASIL LABORATORIUM");	
	tab2.setColHeader("NO,NAMA PEMERIKSAAN,KATEGORI,NORMAL,METODE");
	tab2.setIDColHeader(",nama,normal,satuan,metode");
	tab2.setColWidth("50,250,100,150,100");
	tab2.setCellAlign("center,left,center,center,left");
	tab2.setCellHeight(20);
	tab2.setImgPath("../icon");
	tab2.setIDPaging("pagingtab2");
	tab2.attachEvent("onRowClick","ambilDataTrf");
	tab2.baseURL("labSatuan_utils.php?grd1=true");
	tab2.Init();
	
	tab3=new DSGridObject("gridboxtab3");
	tab3.setHeader("MASTER KELOMPOK LABORATORIUM");	
	tab3.setColHeader("NO,KODE,NAMA KELOMPOK");
	tab3.setIDColHeader(",kode,nama");
	tab3.setColWidth("50,100,400");
	tab3.setCellAlign("center,center,left");
	tab3.setCellHeight(20);
	tab3.setImgPath("../icon");
	tab3.setIDPaging("pagingtab3");
	tab3.attachEvent("onRowClick","ambilDataKel");
	tab3.baseURL("labSatuan_utils.php?grd2=true");
	tab3.Init();
	
	
	tab4=new DSGridObject("gridboxtab4");
	tab4.setHeader("DATA PEMERIKSAAN LABORATORIUM");	
	tab4.setColHeader("NO,NAMA PEMERIKSAAN");
	tab4.setIDColHeader(",nama");
	tab4.setColWidth("50,400");
	tab4.setCellAlign("center,left");
	tab4.setCellHeight(20);
	tab4.setImgPath("../icon");
	tab4.setIDPaging("pagingtab4");
	tab4.attachEvent("onRowClick","ambilDataPem");
	tab4.baseURL("labSatuan_utils.php?grd3=true&kelId="+document.getElementById("kelIdlab").value);
	tab4.Init();
	
	isiCombo('kelIdlab','','','',fill);
	
	ltab5a=new DSGridObject("grdtab5a");
	ltab5a.setHeader("DATA PEMERIKSAAN LAB PK");
	ltab5a.setColHeader("<input type='checkbox' id='chk_b' onchange='cek_all(this)' />,Nama Pemeriksaan,Kelompok,Sub Kelompok");
	ltab5a.setIDColHeader(",pemeriksaan,kelompok,sub_kelompok");
	ltab5a.setColWidth("20,160,120,100");
	ltab5a.setCellAlign("center,left,center,center");
	ltab5a.setCellType("chk,txt,txt,txt");
	ltab5a.setCellHeight(20);
	ltab5a.setImgPath("../icon");
	ltab5a.setIDPaging("paging_grdtab5a");
	//b.attachEvent("onRowClick","ambilTindakanKelas");
	ltab5a.baseURL("lab_tab5_utils.php?grd=1&unitId=58&tind_id="+document.getElementById("tind_id").value);
	ltab5a.Init();
	
	ltab5b=new DSGridObject("grdtab5b");
	ltab5b.setHeader("DATA TINDAKAN PER UNIT");
	ltab5b.setColHeader("<input type='checkbox' id='chk_c' onchange='cek_all(this)' />,Nama Pemeriksaan,Kelompok,Sub Kelompok");
	ltab5b.setIDColHeader(",pemeriksaan,kelompok,sub_kelompok");
	ltab5b.setColWidth("20,160,120,100");
	ltab5b.setCellAlign("center,left,center,center");
	ltab5b.setCellType("chk,txt,txt,txt");
	ltab5b.setCellHeight(20);
	ltab5b.setImgPath("../icon");
	ltab5b.setIDPaging("paging_grdtab5b");
	ltab5b.onLoaded(loadgrd1);
	ltab5b.baseURL("lab_tab5_utils.php?grd=2&unitId=58&tind_id="+document.getElementById("tind_id").value);
	ltab5b.Init();
	
	/* ltab6a=new DSGridObject("grdtab6a");
	ltab6a.setHeader("DATA PEMERIKSAAN LAB PK");
	ltab6a.setColHeader("<input type='checkbox' id='chk_kel_b' onchange='cek_all(this)' />,Tindakan");
	ltab6a.setIDColHeader(",nama");
	ltab6a.setColWidth("40,200");
	ltab6a.setCellAlign("center,left");
	ltab6a.setCellType("chk,txt");
	ltab6a.setCellHeight(20);
	ltab6a.setImgPath("../icon");
	ltab6a.setIDPaging("paging_grdtab6a");
	//b.attachEvent("onRowClick","ambilTindakanKelas");
	ltab6a.baseURL("lab_tab6_utils.php?grd=1&unitId=58&tind_id="+document.getElementById("kelompokLab").value);
	ltab6a.Init();
	    
	ltab6b=new DSGridObject("grdtab6b");
	ltab6b.setHeader("DATA TINDAKAN PER UNIT");
	ltab6b.setColHeader("<input type='checkbox' id='chk_kel_c' onchange='cek_all(this)' />,Tindakan");
	ltab6b.setIDColHeader(",nama");
	ltab6b.setColWidth("20,200");
	ltab6b.setCellAlign("center,left");
	ltab6b.setCellType("chk,txt");
	ltab6b.setCellHeight(20);
	ltab6b.setImgPath("../icon");
	ltab6b.setIDPaging("paging_grdtab6b");
	ltab6b.onLoaded(loadgrdLab);
	ltab6b.baseURL("lab_tab6_utils.php?grd=2&unitId=58&tind_id="+document.getElementById("kelompokLab").value);
	ltab6b.Init(); */
	
}
	function loadgrd1(){
		//alert("lab_tab5_utils.php?grd=1&unitId=58&tind_id="+document.getElementById("tind_id").value);
		ltab5a.loadURL("lab_tab5_utils.php?grd=1&unitId=58&tind_id="+document.getElementById("tind_id").value,"","GET");
	}
	function loadgrdLab(){
		//alert("lab_tab5_utils.php?grd=1&unitId=58&tind_id="+document.getElementById("tind_id").value);
		ltab6a.loadURL("lab_tab6_utils.php?grd=1&unitId=58&tind_id="+document.getElementById("kelompokLab").value,"","GET");
	}
	
	function fTind_Change(obj){
		//alert("lab_tab5_utils.php?grd=2&unitId=58&tind_id="+document.getElementById("tind_id").value);
		if(obj.id != 'kelompokLab')
			ltab5b.loadURL("lab_tab5_utils.php?grd=2&unitId=58&tind_id="+document.getElementById("tind_id").value,"","GET");
		else
			ltab6b.loadURL("lab_tab6_utils.php?grd=2&unitId=58&tind_id="+document.getElementById("kelompokLab").value,"","GET");
	}
	
	function pindahKanan(){
		idTinUnit='';
		for(var i=0;i<ltab5a.obj.childNodes[0].rows.length;i++){
			if(ltab5a.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked){
				idTinUnit+=ltab5a.getRowId(parseInt(i)+1)+'|';
			}
		}
		//alert(idTinUnit);		
		if(idTinUnit==''){
			alert("Silakan pilih tindakan!");
		}
		else{
			ltab5b.loadURL("lab_tab5_utils.php?grd=2&act=tambah&fdata="+idTinUnit+"&unitId=58&tind_id="+document.getElementById("tind_id").value,"","GET");
		}
	}
	
	function pindahKiri(){
		idTinUnit='';	
		for(var i=0;i<ltab5b.obj.childNodes[0].rows.length;i++){
			if(ltab5b.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked){
				idTinUnit+=ltab5b.getRowId(parseInt(i)+1)+'|';	
			}
		}
		//alert(idTinUnit);		
		if(idTinUnit==''){
			alert("Silakan pilih tindakan unit!");
		}
		else{
			ltab5b.loadURL("lab_tab5_utils.php?grd=2&act=hapus&fdata="+idTinUnit+"&unitId=58&tind_id="+document.getElementById("tind_id").value,"","GET");
		}
	}
	
	function kelompokKanan(){
		idTinUnit='';
		for(var i=0;i<ltab6a.obj.childNodes[0].rows.length;i++){
			if(ltab6a.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked){
				idTinUnit+=ltab6a.getRowId(parseInt(i)+1)+'|';
			}
		}
		//alert(idTinUnit);		
		if(idTinUnit==''){
			alert("Silakan pilih tindakan!");
		}
		else{
			ltab6b.loadURL("lab_tab6_utils.php?grd=2&act=tambah&fdata="+idTinUnit+"&unitId=58&tind_id="+document.getElementById("kelompokLab").value,"","GET");
		}
	}
	
	function kelompokKiri(){
		idTinUnit='';	
		for(var i=0;i<ltab6b.obj.childNodes[0].rows.length;i++){
			if(ltab6b.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked){
				idTinUnit+=ltab6b.getRowId(parseInt(i)+1)+'|';	
			}
		}
		//alert(idTinUnit);		
		if(idTinUnit==''){
			alert("Silakan pilih tindakan unit!");
		}
		else{
			ltab6b.loadURL("lab_tab6_utils.php?grd=2&act=hapus&fdata="+idTinUnit+"&unitId=58&tind_id="+document.getElementById("kelompokLab").value,"","GET");
		}
	}
	
	function cek_all(a){
		//alert(a.id);
		if(a.id=='chk_b'){
			if(a.checked){
				for(var i=0;i<ltab5a.getMaxRow();i++){	
					ltab5a.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked = true;		
				}
			}
			else{
				for(var i=0;i<ltab5a.getMaxRow();i++){	
					ltab5b.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked = false;		
				}
			}
		}
		else if(a.id=='chk_c'){
			if(a.checked){
				for(var i=0;i<ltab5b.getMaxRow();i++){	
					ltab5b.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked = true;		
				}
			}
			else{
				for(var i=0;i<ltab5b.getMaxRow();i++){	
					ltab5a.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked = false;		
				}
			}
		} 
		else if(a.id=='chk_kel_b'){
			if(a.checked){
				for(var i=0;i<ltab6a.getMaxRow();i++){	
					ltab6a.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked = true;		
				}
			}
			else{
				for(var i=0;i<ltab6a.getMaxRow();i++){	
					ltab6b.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked = false;		
				}
			}
		}
		else if(a.id=='chk_kel_c'){
			if(a.checked){
				for(var i=0;i<ltab6b.getMaxRow();i++){	
					ltab6b.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked = true;		
				}
			}
			else{
				for(var i=0;i<ltab6b.getMaxRow();i++){	
					ltab6a.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked = false;		
				}
			}
		}
	}
	
	var actTree;
	function loadtree(p,act,par)
	{
		//alert(p);
		var a=p.split("*-*");
		if(act=='Tambah' || act=='Simpan' || act=='Hapus'){
			actTree=act;
			Request (a[0]+'act='+act+'&par='+par+a[3]+'&cnt='+a[4] , a[1], '', 'GET');
		}
		else{			
			Request (a[0]+'act='+act+'&par='+par+a[3]+'&cnt='+a[4] , a[1], '', 'GET');
		}
	}

	function simpan(action,id,cek)
	{
		//alert(document.getElementById('btntree').value);
		if(ValidateForm(cek,'ind'))
		{
			var idSatuan = document.getElementById("idSatuan").value;
			var namaSatuan = document.getElementById("satuan").value;
			
			// variable kategori normal lab
			/* var id_kat = document.getElementById("id_kat").value;
			var kode_kat = document.getElementById("kode_kat").value;
			var kategori = document.getElementById("kategori").value;
			var aktif_kat = document.getElementById("aktif_kat").value; */
			
			//var idPaket = document.getElementById("idPaket").value;
			//var paket = document.getElementById("paket").value;
			
			var idtind = document.getElementById("tindakan_id").value;
			var lp = document.getElementById("lp").value;
			var satuan = document.getElementById("satid").value;
			var nilai1 = document.getElementById('normal1').value.replace(/\r\n|\r|\n/g,"<br />"); //document.getElementById("normal1").value;
			var nilai2 = document.getElementById('normal2').value.replace(/\r\n|\r|\n/g,"<br />");
			var idnormal = document.getElementById("id_normal").value;
			var metode = document.getElementById("metode").value;
			
			var kel = document.getElementById("kel").value;
			var idKel = document.getElementById("idKel").value;
			var kode = document.getElementById("kode").value;
			var kode_kel = document.getElementById("kode_kel").value;
			var level = document.getElementById("level").value;
			var parent = document.getElementById("parent").value;
			var flag = document.getElementById("flag").value;
			
			var kelIdlab = document.getElementById("kelIdlab").value;
			var txtTindPem = document.getElementById("txtTindPem").value;
			var idPem = document.getElementById("idPem").value;
			
			var isDalam = 0;
			if(document.getElementById('chkAda').checked)
			{
				isDalam = 1;
			}
			
			
			var aktifSatuan = 0;
			//var aktifPaket = 0;
			if(document.getElementById('aktifSatuan').checked==true)
			{
				aktifSatuan = 1;
			}
			//if(document.getElementById('akTifPaket').checked==true)
			//{
			//	aktifPaket = 1;
			//}
			
			//alert(id);
			switch(id)
			{	
				case 'btnSimpanKel':
					//alert(document.getElementById('btntree').value);
					if (document.getElementById('btntree').value=='View Tree'){
						tab3.loadURL("labSatuan_utils.php?grd2=true&act="+action+"&smpn="+id+"&id="+idKel+"&kel="+kel+"&kode="+kode+"&kode_kel="+kode_kel+"&parent="+parent+"&flag="+flag+"&level="+level,"","GET");
					}else{
						tab3.loadURL("labSatuan_utils.php?grd2=true&act="+action+"&smpn="+id+"&id="+idKel+"&kel="+kel+"&kode="+kode+"&kode_kel="+kode_kel+"&parent="+parent+"&level="+level,"","GET");
						var par="&smpn="+id+"&id="+idKel+"&kel="+kel+"&kode="+kode+"&kode_kel="+kode_kel+"&parent="+parent+"&flag="+flag+"&level="+level;
						loadtree(document.getElementById('txtSusun').value,action,par);
						//alert ("a");
					}
					//var p="idKel*-**|*kel*-**|*btnSimpanKel*-*Tambah*|*btnHapusKel*-*true";
					//fSetValue(window,p);
					batal('btnBatalKel');
					isiCombo('kelIdlab');
					break;
				case 'btnSimpan':
				//alert("labSatuan_utils.php?grd=true&act="+action+"&smpn="+id+"&id="+idSatuan+"&nama="+namaSatuan+"&aktif="+aktifSatuan);
				tab1.loadURL("labSatuan_utils.php?grd=true&act="+action+"&smpn="+id+"&id="+idSatuan+"&nama="+namaSatuan+"&flag="+flag+"&aktif="+aktifSatuan,"","GET");
				var p="idSatuan*-**|*satuan*-**|*aktifSatuan*-*false*|*btnSimpan*-*Tambah*|*btnHapus*-*true";
				fSetValue(window,p);
				//batal();
				break;
				
				case 'btnSimpanPaket':
				//alert("labSatuan_utils.php?grd4=true&act="+action+"&smpn="+id+"&id="+idPaket+"&nama="+paket+"&aktif="+aktifPaket);
				tab5.loadURL("labSatuan_utils.php?grd4=true&act="+action+"&smpn="+id+"&id="+idPaket+"&nama="+paket+"&flag="+flag+"&aktif="+aktifPaket,"","GET");
				var p="idPaket*-**|*paket*-**|*aktifPaket*-*false*|*btnSimpanPaket*-*Tambah*|*btnHapusPaket*-*true";
				fSetValue(window,p);
				//batal();
				break;
				
				case 'btnSimpanTrf':
				//alert("labSatuan_utils.php?grd1=true&act="+action+"&smpn="+id+"&id="+idnormal+"&metode="+metode+"&tindakan="+idtind+"&satuan="+satuan+"&lp="+lp+"&nilai1="+nilai1+"&nilai2="+nilai2);
				tab2.loadURL("labSatuan_utils.php?grd1=true&act="+action+"&smpn="+id+"&id="+idnormal+"&metode="+metode+"&tindakan="+idtind+"&satuan="+satuan+"&lp="+lp+"&nilai1="+nilai1+"&nilai2="+nilai2+"&flag="+flag,"GET");
				var idtind = document.getElementById("tindakan_id").value="";
				var lp = document.getElementById("lp").selectedIndex=0;
				var satuan = document.getElementById("satid").selectedIndex=0;
				var nilai1 = document.getElementById("normal1").value="";
				var nilai2 = document.getElementById("normal2").value="";
				var idnormal = document.getElementById("id_normal").value="";
				document.getElementById("txtTind").value="";
				var metode = document.getElementById("metode").value="";
				var p="btnSimpanTrf*-*Tambah*|*btnHapusTrf*-*true";	
				fSetValue(window,p);
				//batal();
				break;
				
				case 'btnSimpanPem':
					//alert("labSatuan_utils.php?grd3=true&act="+action+"&smpn="+id+"&id="+idPem+"&kelId="+kelIdlab+"&txtTindPem="+txtTindPem);
					tab4.loadURL("labSatuan_utils.php?grd3=true&act="+action+"&smpn="+id+"&id="+idPem+"&kelId="+kelIdlab+"&txtTindPem="+txtTindPem+"&flag="+flag+"&isDalam="+isDalam,"","GET");
					var p="txtTindPem*-**|*idPem*-**|*btnSimpanPem*-*Tambah*|*btnHapusPem*-*true";
					document.getElementById('chkAda').checked = false;
					fSetValue(window,p);
				break;
				
				/* case 'btnSimpanKat':
					tab52.loadURL("labSatuan_utils.php?grd52=true&act="+action+"&smpn="+id+"&id_kat="+id_kat+"&kode_kat="+kode_kat+"&kategori="+kategori+"&aktif_kat="+aktif_kat,"","GET");
					document.getElementById("id_kat").value="";
					document.getElementById("kode_kat").value="";
					document.getElementById("kategori").value="";
					document.getElementById("aktif_kat").value="1";
					var p="btnSimpanKat*-*Tambah*|*btnHapusKat*-*true";	
					fSetValue(window,p);
				break; */
			}
		}
	}

	function ambilData()
	{
		var p="idSatuan*-*"+(tab1.getRowId(tab1.getSelRow()))+"*|*satuan*-*"+tab1.cellsGetValue(tab1.getSelRow(),2)+"*|*aktifSatuan*-*"+((tab1.cellsGetValue(tab1.getSelRow(),3)=='Aktif')?'true':'false')+"*|*btnSimpan*-*Simpan*|*btnHapus*-*false";
		fSetValue(window,p);
	}
	
	function ambilDataKel(){
		var sisip=tab3.getRowId(tab3.getSelRow()).split("|");
		var p = "idKel*-*"+sisip[0]+"*|*parent*-*"+sisip[1]+"*|*kode*-*"+sisip[2]+"*|*kode_kel*-*"+tab3.cellsGetValue(tab3.getSelRow(),2)+"*|*kel*-*"+tab3.cellsGetValue(tab3.getSelRow(),3)+"*|*btnSimpanKel*-*Simpan*|*btnHapusKel*-*false";
		fSetValue(window,p);
	}
	
	function ambilDataPem(){
		var idx = tab4.getRowId(tab4.getSelRow());
		//alert(idx);
		var sp = idx.split("|");
		var p = "idPem*-*"+sp[0]+"*|*txtTindPem*-*"+sp[1]+"*|*btnSimpanPem*-*Simpan*|*btnHapusPem*-*false";
		fSetValue(window,p);
		//alert(sp[3]);
		if(sp[3]==1)
		{
			document.getElementById('chkAda').checked = true;
		}else{
			document.getElementById('chkAda').checked = false;
		}
	}
	
	function ambilDataTrf()
	{
		var idx = tab2.getRowId(tab2.getSelRow());
		var sp = idx.split("|");
		var p="id_normal*-*"+sp[0]+"*|*tindakan_id*-*"+sp[1]+"*|*txtTind*-*"+sp[2]+"*|*lp*-*"+sp[3]+"*|*satid*-*"+sp[4]+"*|*normal1*-*"+sp[5]+"*|*normal2*-*"+sp[6]+"*|*metode*-*"+sp[7]+"*|*btnSimpanTrf*-*Simpan*|*btnHapusTrf*-*false";
		document.getElementById("normal1").value = sp[5];
		document.getElementById("normal2").value = sp[6];
		fSetValue(window,p);
	}
	
	/* function ambilDataKat()
	{
		var idx = tab52.getRowId(tab52.getSelRow());
		var sp = idx.split("|");
		var p="id_kat*-*"+sp[0]+"*|*kode_kat*-*"+sp[1]+"*|*kategori*-*"+sp[2]+"*|*aktif_kat*-*"+sp[3]+"*|*btnSimpanKat*-*Simpan*|*btnHapusKat*-*false";
		//alert(p);
		fSetValue(window,p);
	} */
	
	function hapus(id)
	{
		var rowid = document.getElementById("idSatuan").value;
		//var rowidPaket = document.getElementById("idPaket").value;
		var rowidTrf = document.getElementById("id_normal").value; 
		var rowidKel = document.getElementById("idKel").value;  
		var rowidPem = document.getElementById("idPem").value;  
		//var rowidKat = document.getElementById("id_kat").value; 
		
		switch(id)
		{
			case 'btnHapus':
			if(confirm("Anda yakin menghapus Satuan "+tab1.cellsGetValue(tab1.getSelRow(),2)))
			{
				tab1.loadURL("labSatuan_utils.php?grd=true&act=hapus&hps="+id+"&rowid="+rowid,"","GET");
			}
				document.getElementById("satuan").value = '';
				document.getElementById("idSatuan").value = '';
				document.getElementById('aktifSatuan').checked = false;
			var p="idSatuan*-**|*satuan*-**|*aktifSatuan*-*false*|*btnSimpan*-*Tambah*|*btnHapus*-*true";
			fSetValue(window,p);
				break;
			
			case 'btnHapusPaket':
			if(confirm("Anda yakin menghapus Paket "+tab5.cellsGetValue(tab5.getSelRow(),2)))
			{
				tab5.loadURL("labSatuan_utils.php?grd4=true&act=hapus&hps="+id+"&rowid="+rowidPaket,"","GET");
			}
				document.getElementById("paket").value = '';
				document.getElementById("idPaket").value = '';
				document.getElementById('aktifPaket').checked = false;
			var p="idPaket*-**|*paket*-**|*aktifPaket*-*false*|*btnSimpanPaket*-*Tambah*|*btnHapusPaket*-*true";
			fSetValue(window,p);
				break;
			
			case 'btnHapusTrf':
			if(confirm("Anda yakin menghapus Normal "+tab2.cellsGetValue(tab2.getSelRow(),2)))
			{
				tab2.loadURL("labSatuan_utils.php?grd1=true&act=hapus&hps="+id+"&rowid="+rowidTrf,"","GET");
			}
			var idtind = document.getElementById("tindakan_id").value="";
			var lp = document.getElementById("lp").selectedIndex=0;
			var satuan = document.getElementById("satid").selectedIndex=0;
			var nilai1 = document.getElementById("normal1").value="";
			var nilai2 = document.getElementById("normal2").value="";
			var idnormal = document.getElementById("id_normal").value="";
			var metode = document.getElementById("metode").value="";
			document.getElementById("txtTind").value="";
			var p="btnSimpanTrf*-*Tambah*|*btnHapusTrf*-*true";			
			break;
			
			case 'btnHapusKel':
				if(confirm("Anda yakin menghapus Kelompok "+tab3.cellsGetValue(tab3.getSelRow(),2)))
			{
				tab3.loadURL("labSatuan_utils.php?grd2=true&act=hapus&hps="+id+"&rowid="+rowidKel,"","GET");
			}
			var p="idKel*-**|*kel*-**|*kode_kel*-**|*kode*-**|*parent*-**|*btnSimpanKel*-*Tambah*|*btnHapusKel*-*true";
			fSetValue(window,p);
			isiCombo('kelIdlab');
			break;
			
			case 'btnHapusPem':
			if(confirm("Anda yakin menghapus data "+tab4.cellsGetValue(tab4.getSelRow(),2)))
			{
				tab4.loadURL("labSatuan_utils.php?grd3=true&act=hapus&hps="+id+"&rowid="+rowidPem+"&kelId="+document.getElementById("kelIdlab").value,"","GET");
			}
			batal('btnBatalPem');
			break;
			
			/* case 'btnHapusKat':
				if(confirm("Anda yakin menghapus Kategori Normal lab "+tab52.cellsGetValue(tab2.getSelRow(),2)))
				{
					tab52.loadURL("labSatuan_utils.php?grd52=true&act=hapus&hps="+id+"&rowid="+rowidKat,"","GET");
				}
				document.getElementById("id_kat").value="";
				document.getElementById("kode_kat").value="";
				document.getElementById("kategori").value="";
				document.getElementById("aktif_kat").value="1";
				var p="btnSimpanKat*-*Tambah*|*btnHapusKat*-*true";
				fSetValue(window,p);		
			break; */
		}
	}
	
	function fill(){
		var kelIdlab = document.getElementById("kelIdlab").value;
		tab4.loadURL("labSatuan_utils.php?grd3=true&kelId="+kelIdlab,"","GET");
		batal('btnBatalPem');
	}	
	
	function batal(id)
	{
		switch(id)
		{
			case 'btnBatal':
			var p="idSatuan*-**|*satuan*-**|*aktifSatuan*-*false*|*btnSimpan*-*Tambah*|*btnHapus*-*true";
			fSetValue(window,p);
			break;
			
			case 'btnBatalTrf':
				var idtind = document.getElementById("tindakan_id").value="";
				var lp = document.getElementById("lp").selectedIndex=0;
				var satuan = document.getElementById("satid").selectedIndex=0;
				var nilai1 = document.getElementById("normal1").value="";
				var nilai2 = document.getElementById("normal2").value="";
				var idnormal = document.getElementById("id_normal").value="";
				document.getElementById("txtTind").value="";
				document.getElementById("metode").value="";
				var p="btnSimpanTrf*-*Tambah*|*btnHapusTrf*-*true";
				fSetValue(window,p);
				break;
			case 'btnBatalKel':
				var p="idKel*-**|*kode_kel*-**|*kode*-**|*kel*-**|*level*-*0*|*btnSimpanKel*-*Tambah*|*btnHapusKel*-*true";
				fSetValue(window,p);
				break;
			case 'btnBatalPem':
				var p="txtTindPem*-**|*idPem*-**|*btnSimpanPem*-*Tambah*|*btnHapusPem*-*true";
				document.getElementById('chkAda').checked = false;
				fSetValue(window,p);
			break;
			case 'btnBatalKat':
				document.getElementById("id_kat").value="";
				document.getElementById("kode_kat").value="";
				document.getElementById("kategori").value="";
				document.getElementById("aktif_kat").value="1";
				var p="btnSimpanKat*-*Tambah*|*btnHapusKat*-*true";
				fSetValue(window,p);
			break;
			
		}	
	}
	
	var RowIdx1;
	var fKeyEnt1;
	function suggest1(e,par){
		var keywords=par.value;//alert(keywords);
		if(keywords=="" || keywords.length<2){
			document.getElementById('divtindakan').style.display='none';
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
				var tblRow=document.getElementById('tblTindakan').rows.length;
				if (tblRow>0){
					//alert(RowIdx1);
					if (key==38 && RowIdx1>0){
						RowIdx1=RowIdx1-1;
						document.getElementById('lstTind'+(RowIdx1+1)).className='itemtableReq';
						if (RowIdx1>0) document.getElementById('lstTind'+RowIdx1).className='itemtableMOverReq';
					}
					else if (key == 40 && RowIdx1 < tblRow){
						RowIdx1=RowIdx1+1;
						if (RowIdx1>1) document.getElementById('lstTind'+(RowIdx1-1)).className='itemtableReq';
						document.getElementById('lstTind'+RowIdx1).className='itemtableMOverReq';
					}
				}
			}else if (key==13){
				//alert('masuk tindakan');
				if (RowIdx1>0){
					if (fKeyEnt1==false){
						fSetTindakan(document.getElementById('lstTind'+RowIdx1).lang);
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
				//alert("tindakanlist.php?aKeyword="+keywords+"&pasienId="+getIdPasien+"&kelasId="+getIdKelas+"&unitId="+((document.getElementById('chkTind').checked==true)?document.getElementById('tmpLay').value:unitId));
				Request("tindakanlist.php?x=1&aKeyword="+keywords, 'divtindakan', '', 'GET');
				if (document.getElementById('divtindakan').style.display=='none')
					fSetPosisi(document.getElementById('divtindakan'),par);
				document.getElementById('divtindakan').style.display='block';
			}
		}
	}
	
	function suggest2(e,par){
		var keywords=par.value;//alert(keywords);
		if(keywords=="" || keywords.length<2){
			document.getElementById('divtindakan1').style.display='none';
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
				var tblRow=document.getElementById('tblTindakan').rows.length;
				if (tblRow>0){
					//alert(RowIdx1);
					if (key==38 && RowIdx1>0){
						RowIdx1=RowIdx1-1;
						document.getElementById('lstTind'+(RowIdx1+1)).className='itemtableReq';
						if (RowIdx1>0) document.getElementById('lstTind'+RowIdx1).className='itemtableMOverReq';
					}
					else if (key == 40 && RowIdx1 < tblRow){
						RowIdx1=RowIdx1+1;
						if (RowIdx1>1) document.getElementById('lstTind'+(RowIdx1-1)).className='itemtableReq';
						document.getElementById('lstTind'+RowIdx1).className='itemtableMOverReq';
					}
				}
			}else if (key==13){
				//alert('masuk tindakan');
				if (RowIdx1>0){
					if (fKeyEnt1==false){
						fSetTindakan(document.getElementById('lstTind'+RowIdx1).lang);
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
				//alert("tindakanlist.php?aKeyword="+keywords+"&pasienId="+getIdPasien+"&kelasId="+getIdKelas+"&unitId="+((document.getElementById('chkTind').checked==true)?document.getElementById('tmpLay').value:unitId));
				Request("tindakanlist.php?x=2&aKeyword="+keywords, 'divtindakan1', '', 'GET');
				if (document.getElementById('divtindakan1').style.display=='none')
					fSetPosisi(document.getElementById('divtindakan1'),par);
				document.getElementById('divtindakan1').style.display='block';
			}
		}
	}
	
	function fSetTindakan(value){
		var dt = value.split("|");
		document.getElementById("tindakan_id").value=dt[0];
		document.getElementById("txtTind").value=dt[1];
		document.getElementById("divtindakan").style.display="none";
	}
	function fSetTindakan1(value){
		var dt = value.split("|");
		document.getElementById("tindakan_idKel").value=dt[0];
		document.getElementById("txtTindKel").value=dt[1];
		document.getElementById("divtindakan1").style.display="none";
	}
	function tree12(a,id){
	if(a.value=="View Tree"){
		document.getElementById('gridboxtab3').style.display="none";
		document.getElementById('pagingtab3').style.display="none";
		document.getElementById('tree').style.display="block";
		a.value="View Table";
		//alert(id);
		//alert("tree");
		var idKel = document.getElementById("idKel").value;
		var kel = document.getElementById("kel").value;
		var kode = document.getElementById("kode").value;
		var kode_kel = document.getElementById("kode_kel").value;
		var level = document.getElementById("level").value;
		var parent = document.getElementById("parent").value;
		var par="&smpn="+id+"&id="+idKel+"&kel="+kel+"&kode="+kode+"&kode_kel="+kode_kel+"&parent="+parent+"&level="+level+"&tipe=1";
		var action="";
		loadtree(document.getElementById('txtSusun').value,action,par);
	}else{
		document.getElementById('gridboxtab3').style.display="block";
		document.getElementById('pagingtab3').style.display="block";
		document.getElementById('tree').style.display="none";
		a.value="View Tree";
	}
	}
	function upKode(){
		OpenWnd('kelLab_tree.php?tipe=1&par=kode*level*parent',800,500,'msma',true)
		//window.open("kelLab_tree.php?kode*level*parent");
	}
	function setValue(a){
		//alert(a);
		var x = a.split("|");
		document.getElementById("kode").value=x[0];
		document.getElementById("level").value=x[1];
		document.getElementById("parent").value=x[2];
	}
	
</script>

</html>
