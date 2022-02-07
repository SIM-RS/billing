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
mTab.setTabCaption("KELOMPOK PEMERIKSAAN, MAPPING KELOMPOK PEMERIKSAAN"); //MASTER KATEGORI<br/>NORMAL LAB
mTab.setTabCaptionWidth("200, 200");
mTab.onLoaded(showgrid);
mTab.setTabPage("lab_kelompok.php,lab_tab6.php");
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
	if(grd=="gridboxtab3"){
		//alert("tarif_tempat_layanan_utils.php?grd=1&unitId="+document.getElementById('cmbUnit').value+"&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage());
		tab3.loadURL("kellabSatuan_utils.php?grd2=true&filter="+tab3.getFilter()+"&sorting="+tab3.getSorting()+"&page="+tab3.getPage(),"","GET");
	}
	else if(grd=="grdtab6a"){
		// alert("lab_tab5_utils.php?grd=1&unitId=58&tind_id="+document.getElementById("tind_id").value+"&filter="+ltab5a.getFilter()+"&sorting="+ltab5a.getSorting()+"&page="+ltab5a.getPage());
		ltab6a.loadURL("lab_tab6_utils.php?grd=1&unitId=58&tind_id="+document.getElementById("kelompokLab").value+"&filter="+ltab6a.getFilter()+"&sorting="+ltab6a.getSorting()+"&page="+ltab6a.getPage(),"","GET");
	}
}


function showgrid()
{
	tab3=new DSGridObject("gridboxtab3");
	tab3.setHeader("MASTER KELOMPOK LABORATORIUM");	
	tab3.setColHeader("NO,KODE,NAMA KELOMPOK");
	tab3.setIDColHeader(",kode,nama_kelompok");
	tab3.setColWidth("50,100,400");
	tab3.setCellAlign("center,center,left");
	tab3.setCellHeight(20);
	tab3.setImgPath("../icon");
	tab3.setIDPaging("pagingtab3");
	tab3.attachEvent("onRowClick","ambilDataKel");
	tab3.baseURL("kellabSatuan_utils.php?grd2=true");
	tab3.Init();
	
	ltab6a=new DSGridObject("grdtab6a");
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
	ltab6b.Init();
	
	// isiCombo('kelIdlab','','','',fill);
	
}
	function loadgrdLab(){
		//alert("lab_tab5_utils.php?grd=1&unitId=58&tind_id="+document.getElementById("tind_id").value);
		ltab6a.loadURL("lab_tab6_utils.php?grd=1&unitId=58&tind_id="+document.getElementById("kelompokLab").value,"","GET");
	}
	
	function fTind_Change(obj){
		//alert("lab_tab5_utils.php?grd=2&unitId=58&tind_id="+document.getElementById("tind_id").value);
		/* if(obj.id != 'kelompokLab')
			ltab5b.loadURL("lab_tab5_utils.php?grd=2&unitId=58&tind_id="+document.getElementById("tind_id").value,"","GET");
		else */
			ltab6b.loadURL("lab_tab6_utils.php?grd=2&unitId=58&tind_id="+document.getElementById("kelompokLab").value,"","GET");
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
		if(a.id=='chk_kel_b'){
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
			var kel = document.getElementById("kel").value;
			var idKel = document.getElementById("idKel").value;
			var kode = document.getElementById("kode").value;
			var kode_kel = document.getElementById("kode_kel").value;
			var level = document.getElementById("level").value;
			var parent = document.getElementById("parent").value;
			var flag = document.getElementById("flag").value;
			
			//alert(id);
			switch(id)
			{	
				case 'btnSimpanKel':
					//alert(document.getElementById('btntree').value);
					if (document.getElementById('btntree').value=='View Tree'){
						tab3.loadURL("kellabSatuan_utils.php?grd2=true&act="+action+"&smpn="+id+"&id="+idKel+"&kel="+kel+"&kode="+kode+"&kode_kel="+kode_kel+"&parent="+parent+"&flag="+flag+"&level="+level,"","GET");
					}else{
						tab3.loadURL("kellabSatuan_utils.php?grd2=true&act="+action+"&smpn="+id+"&id="+idKel+"&kel="+kel+"&kode="+kode+"&kode_kel="+kode_kel+"&parent="+parent+"&level="+level,"","GET");
						var par="&smpn="+id+"&id="+idKel+"&kel="+kel+"&kode="+kode+"&kode_kel="+kode_kel+"&parent="+parent+"&flag="+flag+"&level="+level+"&type=2";
						loadtree(document.getElementById('txtSusun').value,action,par);
						//alert ("a");
					}
					//var p="idKel*-**|*kel*-**|*btnSimpanKel*-*Tambah*|*btnHapusKel*-*true";
					//fSetValue(window,p);
					batal('btnBatalKel');
					isiCombo('kelIdlab');
					break;
			}
		}
	}
	
	function ambilDataKel(){
		var sisip=tab3.getRowId(tab3.getSelRow()).split("|");
		var p = "idKel*-*"+sisip[0]+"*|*parent*-*"+sisip[1]+"*|*kode*-*"+sisip[2]+"*|*kode_kel*-*"+tab3.cellsGetValue(tab3.getSelRow(),2)+"*|*kel*-*"+tab3.cellsGetValue(tab3.getSelRow(),3)+"*|*btnSimpanKel*-*Simpan*|*btnHapusKel*-*false";
		fSetValue(window,p);
	}
	
	function hapus(id)
	{
		var rowidKel = document.getElementById("idKel").value;  		
		var kel = document.getElementById("kel").value;
		var kode = document.getElementById("kode").value;
		var kode_kel = document.getElementById("kode_kel").value;
		var level = document.getElementById("level").value;
		var parent = document.getElementById("parent").value;
		switch(id){			
			case 'btnHapusKel':
				if(confirm("Anda yakin menghapus Kelompok "+tab3.cellsGetValue(tab3.getSelRow(),2)))
			{
				tab3.loadURL("kellabSatuan_utils.php?grd2=true&act=hapus&hps="+id+"&rowid="+rowidKel,"","GET");
			}
			var p="idKel*-**|*kel*-**|*kode_kel*-**|*kode*-**|*parent*-**|*btnSimpanKel*-*Tambah*|*btnHapusKel*-*true";
			fSetValue(window,p);
			var par="&smpn="+id+"&id="+rowidKel+"&kel="+kel+"&kode="+kode+"&kode_kel="+kode_kel+"&parent="+parent+"&level="+level+"&type=2";
			loadtree(document.getElementById('txtSusun').value,'',par);
			// isiCombo('kelIdlab');
			break;
		}
	}
	
	function fill(){
		var kelIdlab = document.getElementById("kelIdlab").value;
		tab4.loadURL("kellabSatuan_utils.php?grd3=true&kelId="+kelIdlab,"","GET");
		batal('btnBatalPem');
	}	
	
	function batal(id)
	{
		switch(id)
		{
			case 'btnBatalKel':
				var p="idKel*-**|*kode_kel*-**|*kode*-**|*kel*-**|*level*-*0*|*btnSimpanKel*-*Tambah*|*btnHapusKel*-*true";
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
		var par="&smpn="+id+"&id="+idKel+"&kel="+kel+"&kode="+kode+"&kode_kel="+kode_kel+"&parent="+parent+"&level="+level+"&type=2";
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
		OpenWnd('kelLab_tree.php?tipe=2&par=kode*level*parent',800,500,'msma',true)
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
