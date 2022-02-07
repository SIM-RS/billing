<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="STYLESHEET" type="text/css" href="theme/mod.css">
<script language="JavaScript" src="theme/js/dsgrid.js"></script>
</head>
<body bgcolor="#CCFF99">
<div align="center"><br />
<iframe height="72" width="130" name="sort"
	id="sort"
	src="theme/dsgrid_sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div id="gridbox" style="width:925px; height:350px; background-color:white; overflow:hidden;"></div>
<div id="paging" style="width:925px;"></div>
<button type="button" onclick="alert(document.getElementById('DivSort'));">tes</button>
</div>
</body>
<script>
	function tes(){
		//alert('clicked');
	}
	function tes1(){
		alert(a.cellsGetValue(a.getSelRow(),2)+'-'+a.cellsGetValue(a.getSelRow(),9));
	}
	function goFilterAndSort(grd){
		//alert(grd);
		if (grd=="gridbox"){
			//alert("tabel_utils.php?grd1=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
			a.loadURL("tabel_utils.php?grd1=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
		}/*else if (grd=="gridbox1"){
			//alert("tabel_utils.php?grd2=true&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage());
			b.loadURL("tabel_utils.php?grd2=true&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage(),"","GET");
		}*/
	}
	var a=new DSGridObject("gridbox");
	a.setHeader("Data Pasien");
	a.setColHeader("No,Tgl,No RM,Kode Kunjungan,Nama Pasien,Alamat,KSO,Dokter,Poli/Ruang");
	a.setIDColHeader(",,NoRM,Kode,Nama,Alamat,Penjamin,dokter,Poli");
	a.setColWidth("40,80,70,120,170,200,130,140,120");
	a.setCellAlign("center,center,center,center,left,left,center,center,center");
	//a.setCellType("txt,txt,txt,txt,txt,txt,txt,txt,chkbox");
	a.setCellHeight(20);
	a.setImgPath("icon");
	a.setIDPaging("paging");
	//a.attachEvent("onRowClick","tes");
	a.attachEvent("onRowDblClick","tes1");
	a.baseURL("tabel_utils.php?grd1=true");
	a.Init();
/*	var b=new DSGridObject("gridbox1");
	b.setHeader("Data Pasien");
	b.setColHeader("No,Tgl,No RM,Kode Kunjungan,Nama Pasien,Alamat,KSO,Dokter,Poli/Ruang");
	b.setIDColHeader(",,NoRM1,Kode1,Nama1,Alamat1,Penjamin1,dokter1,Poli1");
	b.setColWidth("40,80,70,120,170,200,130,140,120");
	b.setCellAlign("center,center,center,center,left,left,center,left,left");
	b.setCellHeight(20);
	b.loadURL("tabel_utils.php?grd2=true","","GET");
	document.getElementById("mpage1").innerHTML=a.getMaxPage();
	document.getElementById("mpage2").innerHTML=b.getMaxPage();
	//a.loadData("123*-*1*-*ds2333*-*4333*-*43333*-*sdddd*-*fsff*-*swd*-*fff*-*dfff");
	//a.attachEvent("ev", tes);
	//a.ev();*/
</script>
</html>