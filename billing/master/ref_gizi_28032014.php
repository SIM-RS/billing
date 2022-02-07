<?php
session_start();
include("../sesi.php");
?>
<?php
//session_start();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Referensi Gizi</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../theme/tab-view.css" />
<script type="text/javascript" src="../theme/js/tab-view.js"></script>
<link type="text/css" rel="stylesheet" href="../theme/mod.css">
<script type="text/JavaScript" language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
<script type="text/javascript" src="../theme/js/ajax.js"></script>
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
		<td height="30">&nbsp;FORM REFERENSI GIZI</td>
	</tr>
</table>
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center" class="tabel">  
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" align="center">
		<div class="TabView" id="TabView" style="width: 925px; height: 500px;"></div>
		</td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
  </table>
  <table border="0" cellpadding="0" cellspacing="0" class="hd2"width="1000">
  <tr height="30">
		<td width="20%">&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" /></td>
		<td width="50%">&nbsp;</td>
		<td width="30%" align="right"><a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" /></a>&nbsp;</td>
	</tr>

<!--input type="button" value="Tes" onclick="alert(document.getElementById('page_TabView_0').innerHTML);" /-->
</table>
</div>
</body>
<script>
var mTab=new TabView("TabView");
mTab.setTabCaption("WAKTU,JENIS MAKANAN,JENIS DIET");
mTab.setTabCaptionWidth("300,300,325");
mTab.onLoaded(showgrid);
mTab.setTabPage("gizi_tab1.php,gizi_tab2.php,gizi_tab3.php");
//tabview_width("TabView","60,90,60");

function isiCombo(id,val,defaultId,targetId,evloaded){	
	if(targetId=='' || targetId==undefined){
		targetId=id;
	}	
	Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded);
	
}



function simpan(action,tombol){
	switch(tombol){
		case 'btnSimpanWkt':
			if(ValidateForm('txtWaktu,chkAktifWkt','ind')){
				var wkt=document.getElementById("txtWaktu").value;
				var id=document.getElementById("txtIdWkt").value;	    
				
				if(document.getElementById("chkAktifWkt").checked==true){
				    var aktif=1;
				}
				else{
				    var aktif=0;
				}				
				a.loadURL("ref_gizi_utils.php?grd=1&act="+action+"&tombol="+tombol+"&id="+id+"&wkt="+wkt+"&aktif="+aktif,"","GET");
				batal();
			  }
			break;
		case 'btnSimpanJnsMak':
			if(ValidateForm('txtJnsMak,chkAktifJnsMak','ind')){
				var jnsMak=document.getElementById("txtJnsMak").value;
				var id=document.getElementById("txtIdJnsMak").value;	    
				
				if(document.getElementById("chkAktifJnsMak").checked==true){
				    var aktif=1;
				}
				else{
				    var aktif=0;
				}				
				b.loadURL("ref_gizi_utils.php?grd=2&act="+action+"&tombol="+tombol+"&id="+id+"&jnsMak="+jnsMak+"&aktif="+aktif,"","GET");
				batal();				
			  }
			break;
		case 'btnSimpanJnsDiet':
			if(ValidateForm('txtJnsDiet,cmbJnsMak','ind')){
				var jnsDiet=document.getElementById("txtJnsDiet").value;
				var jnsMak=document.getElementById("cmbJnsMak").value;	    
				var id=document.getElementById("txtIdJnsDiet").value;	    
				c.loadURL("ref_gizi_utils.php?grd=3&act="+action+"&tombol="+tombol+"&id="+id+"&jnsDiet="+jnsDiet+"&jnsMak="+jnsMak,"","GET");
				batal();				
			  }
			break;
	}
	
}

function ambilDataWaktu(){	
	var p="txtIdWkt*-*"+(a.getRowId(a.getSelRow()))+"*|*txtWaktu*-*"+a.cellsGetValue(a.getSelRow(),2)+"*|*chkAktifWkt*-*"+((a.cellsGetValue(a.getSelRow(),3)=='Aktif')?'true':'false')+"*|*btnSimpanWkt*-*Simpan*|*btnHapusWkt*-*false";
	fSetValue(window,p);
}

function ambilDataJnsMak(){	
	var p="txtIdJnsMak*-*"+(b.getRowId(b.getSelRow()))+"*|*txtJnsMak*-*"+b.cellsGetValue(b.getSelRow(),2)+"*|*chkAktifJnsMak*-*"+((b.cellsGetValue(b.getSelRow(),3)=='Aktif')?'true':'false')+"*|*btnSimpanJnsMak*-*Simpan*|*btnHapusJnsMak*-*false";
	fSetValue(window,p);	
}

function ambilDataJnsDiet(){	
	var p="txtIdJnsDiet*-*"+(c.getRowId(c.getSelRow()))+"*|*cmbJnsMak*-*"+c.cellsGetValue(c.getSelRow(),2)+"*|*txtJnsDiet*-*"+c.cellsGetValue(c.getSelRow(),3)+"*|*btnSimpanJnsDiet*-*Simpan*|*btnHapusJnsDiet*-*false";
	fSetValue(window,p);	
}

function hapus(action,tombol){
	switch(tombol){
		case 'btnHapusWkt':
			var idWkt = document.getElementById("txtIdWkt").value;	
			if(confirm("Anda yakin menghapus waktu "+a.cellsGetValue(a.getSelRow(),2))){
			    a.loadURL("ref_gizi_utils.php?grd=1&act="+action+"&tombol="+tombol+"&id="+idWkt,"","GET");
			    batal();
			}
			break;
		case 'btnHapusJnsMak':
			var idJnsMak = document.getElementById("txtIdJnsMak").value;	
			if(confirm("Anda yakin menghapus jenis makanan "+b.cellsGetValue(b.getSelRow(),2))){
			    b.loadURL("ref_gizi_utils.php?grd=2&act="+action+"&tombol="+tombol+"&id="+idJnsMak,"","GET");
			    batal();
			}
			break;
		case 'btnHapusJnsDiet':
			var idJnsMak = document.getElementById("txtIdJnsDiet").value;	
			if(confirm("Anda yakin menghapus jenis makanan diet "+c.cellsGetValue(c.getSelRow(),2)+" "+c.cellsGetValue(c.getSelRow(),3))){
			    c.loadURL("ref_gizi_utils.php?grd=3&act="+action+"&tombol="+tombol+"&id="+idJnsMak,"","GET");
			    batal();
			}
			break;
	}
}

function batal(){
	var p="txtIdWkt*-**|*txtWaktu*-**|*chkAktifWkt*-*true*|*btnSimpanWkt*-*Tambah*|*btnHapusWkt*-*true";
	fSetValue(window,p);
	
	var q="txtIdJnsMak*-**|*txtJnsMak*-**|*chkAktifJnsMak*-*true*|*btnSimpanJnsMak*-*Tambah*|*btnHapusJnsMak*-*true";
	fSetValue(window,q);
	
	var p="txtIdJnsDiet*-**|*txtJnsDiet*-**|*btnSimpanJnsDiet*-*Tambah*|*btnHapusJnsDiet*-*true";
	fSetValue(window,p);
	isiCombo('cmbJnsMak');
}

function goFilterAndSort(namaGrid){
	switch(namaGrid){
		case 'gridboxtab1':
			a.loadURL("ref_gizi_utils.php?grd=1&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
			break;
		case 'gridboxtab2':
			b.loadURL("ref_gizi_utils.php?grd=2&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage(),"","GET");
			break;
		case 'gridboxtab3':
			c.loadURL("ref_gizi_utils.php?grd=3&filter="+c.getFilter()+"&sorting="+c.getSorting()+"&page="+c.getPage(),"","GET");
			break;
	}
	
}
var a,b,c;
function showgrid()
{
	a=new DSGridObject("gridboxtab1");
	a.setHeader("WAKTU");	
	a.setColHeader("No,Nama,Aktif");
	a.setIDColHeader(",nama,");
	a.setColWidth("20,450,30");
	a.setCellAlign("center,left,center");
	a.setCellHeight(20);
	a.setImgPath("../icon");
	a.setIDPaging("pagingtab1");
	a.attachEvent("onRowClick","ambilDataWaktu");	
	a.baseURL("ref_gizi_utils.php?grd=1");
	a.Init();
	
	b=new DSGridObject("gridboxtab2");
	b.setHeader("JENIS MAKANAN");	
	b.setColHeader("No,Nama,Aktif");
	b.setIDColHeader(",nama,");
	b.setColWidth("20,450,30");
	b.setCellAlign("center,left,center");
	b.setCellHeight(20);
	b.setImgPath("../icon");
	b.setIDPaging("pagingtab2");
	b.attachEvent("onRowClick","ambilDataJnsMak");	
	b.baseURL("ref_gizi_utils.php?grd=2");
	b.Init();
	
	c=new DSGridObject("gridboxtab3");
	c.setHeader("JENIS DIET");	
	c.setColHeader("NO,JENIS MAKANAN,JENIS DIET");
	c.setIDColHeader(",kode_jenis_makanan,nama");
	c.setColWidth("30,200,200");
	c.setCellAlign("center,left,left");
	c.setCellHeight(20);
	c.setImgPath("../icon");
	c.setIDPaging("pagingtab3");
	c.attachEvent("onRowClick","ambilDataJnsDiet");
	c.baseURL("ref_gizi_utils.php?grd=3");
	c.Init();
	isiCombo('cmbJnsMak');
}
</script>
</html>
