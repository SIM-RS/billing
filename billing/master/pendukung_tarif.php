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
<title>Pendukung Tarif</title>
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
		<td height="30">&nbsp;FORM PENDUKUNG TARIF</td>
	</tr>
</table>
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center" class="tabel">  
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
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
    	<td width="20%">&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;"/></td>
		<td width="50%">&nbsp;</td>
		<td width="30%" align="right"><a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;"/></a>&nbsp;</td>
  </tr>
</table>
</div>
</body>
<script>
var mTab=new TabView("TabView");
mTab.setTabCaption("KELAS LAYANAN,KOMPONEN TARIF");
mTab.setTabCaptionWidth("450,475");
mTab.onLoaded(showgrid);
mTab.setTabPage("pend_tab1.php,pend_tab2.php");
//tabview_width("TabView","60,90,60");
var tab1;
var tab2;
var tab3a;

function goFilterAndSort(grd){		
	if(grd=="gridboxtab1"){
		//alert("tarif_tempat_layanan_utils.php?grd=1&unitId="+document.getElementById('cmbUnit').value+"&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage());
		tab1.loadURL("pendTarif_utils.php?grd=true&filter="+tab1.getFilter()+"&sorting="+tab1.getSorting()+"&page="+tab1.getPage(),"","GET");
	}
	else if(grd=="gridboxtab2"){
		//alert("tarif_tempat_layanan_utils.php?grd=1&unitId="+document.getElementById('cmbUnit').value+"&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage());
		tab2.loadURL("pendTarif_utils.php?grd1=true&filter="+tab2.getFilter()+"&sorting="+tab2.getSorting()+"&page="+tab2.getPage(),"","GET");
	}
}


function showgrid()
{
	tab1=new DSGridObject("gridboxtab1");
	tab1.setHeader("PENDUKUNG TARIF");	
	tab1.setColHeader("KODE,KELAS LAYANAN,STATUS AKTIf");
	tab1.setIDColHeader("kode,nama,");
	tab1.setColWidth("75,200,75");
	tab1.setCellAlign("center,left,center");
	tab1.setCellHeight(20);
	tab1.setImgPath("../icon");
	tab1.setIDPaging("pagingtab1");
	tab1.attachEvent("onRowClick","ambilData");
	tab1.baseURL("pendTarif_utils.php?grd=true");
	tab1.Init();
	
	tab2=new DSGridObject("gridboxtab2");
	tab2.setHeader("KOMPONEN TARIF");	
	tab2.setColHeader("KODE,KOMPONEN TARIF,TARIF,STATUS AKTIF");
	tab2.setIDColHeader("kode,nama,,");
	tab2.setColWidth("100,150,100,75");
	tab2.setCellAlign("left,left,center,center");
	tab2.setCellHeight(20);
	tab2.setImgPath("../icon");
	tab2.setIDPaging("pagingtab2");
	tab2.attachEvent("onRowClick","ambilDataTrf");
	tab2.baseURL("pendTarif_utils.php?grd1=true");
	tab2.Init();
	
	
	/*tab3a=new DSGridObject("gridboxtab3a");
	tab3a.setHeader("KOMPONEN");	
	tab3a.setColHeader("KOMPONEN");
	//a.setIDColHeader(",,NoRM,Kode,Nama,Alamat,Penjamin,dokter,Poli");
	tab3a.setColWidth("250");
	tab3a.setCellAlign("left");
	tab3a.setCellHeight(20);
	tab3a.setImgPath("../icon");
	tab3a.setIDPaging("pagingtab3a");
	//tab3a.attachEvent("onRowDblClick","tes1");
	tab3a.baseURL("pendTarif_utils.php?grd2=true");
	tab3a.Init();
		
	tab3b=new DSGridObject("gridboxtab3b");
	tab3b.setHeader("KOMPONEN");	
	tab3b.setColHeader("KOMPONEN");
	//a.setIDColHeader(",,NoRM,Kode,Nama,Alamat,Penjamin,dokter,Poli");
	tab3b.setColWidth("250");
	tab3b.setCellAlign("center");
	tab3b.setCellHeight(20);
	tab3b.setImgPath("../icon");
	tab3b.setIDPaging("pagingtab3b");
	//tab3b.attachEvent("onRowDblClick","tes1");
	tab3b.baseURL("pendTarif_utils.php?grd3=true");
	tab3b.Init();*/
}

	function simpan(action,id,cek)
	{
		if(ValidateForm(cek,'ind'))
		{
			var idKls = document.getElementById("id_kls").value;
			var kode = document.getElementById("kode").value;
			var kls = document.getElementById("kls").value;
			var flag = document.getElementById("flag").value;
			
			var idTrf = document.getElementById("id_komp").value;
			var kodeKomp = document.getElementById("kodeKomp").value;
			var nama = document.getElementById("txtkomp").value;
			var tarif = document.getElementById("txttarif").value;
			
			var aktifkls = 0;
			if(document.getElementById('isAktifKls').checked==true)
			{
				aktifkls = 1;
			}
			
			var aktiftrf = 0;
			if(document.getElementById('isAktifTarif').checked==true)
			{
				aktiftrf = 1;
			}
			
			switch(id)
			{
				case 'btnSimpan':
				tab1.loadURL("pendTarif_utils.php?grd=true&act="+action+"&smpn="+id+"&id="+idKls+"&kode="+kode+"&kls="+kls+"&flag="+flag+"&aktif="+aktifkls,"","GET");
				document.getElementById("kode").value = '';
				document.getElementById("kls").value = '';
				document.getElementById('isAktifKls').checked = false;
				//batal();
				break;
				
				case 'btnSimpanTrf':
				tab2.loadURL("pendTarif_utils.php?grd1=true&act="+action+"&smpn="+id+"&id="+idTrf+"&kode="+kodeKomp+"&nama="+nama+"&tarif="+tarif+"&flag="+flag+"&aktif="+aktiftrf,"","GET");
				document.getElementById("kodeKomp").value = '';
				document.getElementById("txtkomp").value = '';
				document.getElementById("txttarif").value = '';
				document.getElementById('isAktifTarif').checked = false;
				//batal();
				break;
			}
		}
	}

	function ambilData()
	{
		var p="id_kls*-*"+(tab1.getRowId(tab1.getSelRow()))+"*|*kode*-*"+tab1.cellsGetValue(tab1.getSelRow(),1)+"*|*kls*-*"+tab1.cellsGetValue(tab1.getSelRow(),2)+"*|*isAktifKls*-*"+((tab1.cellsGetValue(tab1.getSelRow(),3)=='Aktif')?'true':'false')+"*|*btnSimpan*-*Simpan*|*btnHapus*-*false";
		fSetValue(window,p);
	}
	
	function ambilDataTrf()
	{
		var p="id_komp*-*"+(tab2.getRowId(tab2.getSelRow()))+"*|*kodeKomp*-*"+tab2.cellsGetValue(tab2.getSelRow(),1)+"*|*txtkomp*-*"+tab2.cellsGetValue(tab2.getSelRow(),2)+"*|*txttarif*-*"+tab2.cellsGetValue(tab2.getSelRow(),3)+"*|*isAktifTarif*-*"+((tab2.cellsGetValue(tab2.getSelRow(),4)=='Aktif')?'true':'false')+"*|*btnSimpanTrf*-*Simpan*|*btnHapusTrf*-*false";
		fSetValue(window,p);
	}
	
	function hapus(id)
	{
		var rowid = document.getElementById("id_kls").value;
		var rowidTrf = document.getElementById("id_komp").value; 
		
		switch(id)
		{
			case 'btnHapus':
			if(confirm("Anda yakin menghapus Kelas "+tab1.cellsGetValue(tab1.getSelRow(),2)))
			{
				tab1.loadURL("pendTarif_utils.php?grd=true&act=hapus&hps="+id+"&rowid="+rowid,"","GET");
			}
				document.getElementById("kode").value = '';
				document.getElementById("kls").value = '';
				document.getElementById('isAktifKls').checked = false;
				batal('btnBatal');
				break;
			
			case 'btnHapusTrf':
			if(confirm("Anda yakin menghapus Kelas "+tab2.cellsGetValue(tab2.getSelRow(),2)))
			{
				tab2.loadURL("pendTarif_utils.php?grd1=true&act=hapus&hps="+id+"&rowid="+rowidTrf,"","GET");
			}
				document.getElementById("kodeKomp").value = '';
				document.getElementById("txtkomp").value = '';
				document.getElementById("txttarif").value = '';
				document.getElementById('isAktifTarif').checked = false;
				batal('btnBatalTrf');			
				break;
		}
	}
	
	function batal(id)
	{
		switch(id)
		{
			case 'btnBatal':
			var p="id_kls*-**|*kode*-**|*kls*-**|*isAktifKls*-*false*|*btnSimpan*-*Tambah*|*btnHapus*-*true";
			fSetValue(window,p);
			break;
			
			case 'btnBatalTrf':
			var p="id_komp*-**|*kodeKomp*-**|*txtkomp*-**|*txttarif*-**|*isAktifTarif*-*false*|*btnSimpanTrf*-*Tambah*|*btnHapusTrf*-*true";
			fSetValue(window,p);	
			break;
		}	
	}
	
</script>

</html>
