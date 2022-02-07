<?php
session_start();
include "../sesi.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css">
<script type="text/JavaScript" language="JavaScript" src="../include/jquery/jquery-1.9.1.js"></script>
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
<script language="JavaScript" src="../theme/js/ajax.js"></script>
<script language="JavaScript" src="../theme/js/mod.js"></script>
<title>Informasi Kunjungan</title>
</head>

<body>
<script>
	var arrRange=depRange=[];
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
	frameborder="1"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>
<div align="center">
<?php
	include("../koneksi/konek.php");
	include("../header1.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$exTgl=explode('-',$date_now);
	$tglAwl="01-".$exTgl[1]."-".$exTgl[2];
?>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/dsgrid_sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
	<tr>
		<td height="30">&nbsp;INFORMASI KUNJUNGAN</td>
	</tr>
</table>
<table width="1000" border="0" cellspacing="0" cellpadding="0" class="tabel" align="center">
  
  
  <tr>
    <td>&nbsp;</td>
    <td colspan="6" align="center" style="font-size:14px; font-weight:bold">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td colspan="6" align="center" style="font-size:14px; font-weight:bold">INFROMASI KUNJUNGAN AKTIF </td>
    <td width="2%">&nbsp;</td>
  </tr>
  <tr>
  <td>&nbsp;</td>
    <td width="12%">&nbsp;</td>
    <td width="31%">&nbsp;</td>
    <td width="31%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="7%">&nbsp;</td>
    <td width="37%">&nbsp;</td>
  <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="8" style="padding-left:10px; padding-right:10px;">
		<div id="gridbox" style="width:970px; height:350px; background-color:white; overflow:hidden;"></div>
		<div id="paging" style="width:970px;"></div>	</td>
  </tr>
  <tr><td colspan="8">&nbsp;</td></tr>
  
  <tr>
  	<td colspan="8">&nbsp;<div id="load1"></div><div id="load2" style="display:none;"></div></td>
	<div id="divHid" style="display:none"></div>
  </tr>
  </table>

</div>
</body>
<script>	
	var a=new DSGridObject("gridbox");
	var isLoaded=0;
	
	loadGrid();
	function loadGrid(){
		showTabel();
		if (isLoaded==0){
			a.setHeader("DATA PASIEN");
			a.setColHeader("NO,TGL KUNJUNGAN,NO RM,UNIT ASAL,UNIT,NAMA PASIEN,ALAMAT,STATUS PASIEN");
			a.setIDColHeader(",,no_rm,unit_asal,unit_sekarang,nama,alamat,kso");
			a.setColWidth("30,80,70,100,100,130,150,80");
			a.setCellAlign("center,center,center,center,center,left,left,center");
			a.setCellHeight(20);
			a.setImgPath("../icon");
			a.baseURL("tabel_utils.php?grdKunjAktif=true"+"&filter="+a.getFilter()+"&sorting="+a.getSorting());
			a.Init();
			isLoaded=1;
		}else{
			goFilterAndSort("gridbox");
		}
	}
	

	
	function goFilterAndSort(grd){
		if (grd=="gridbox"){
			
			a.setHeader("DATA PASIEN");
			a.setColHeader("NO,TGL KUNJUNGAN,NO RM,UNIT ASAL,UNIT,NAMA PASIEN,ALAMAT,STATUS PASIEN");
			a.setIDColHeader(",,no_rm,unit_asal,unit_sekarang,nama,alamat,kso");
			a.setColWidth("30,80,70,100,100,130,150,80");
			a.setCellAlign("center,center,center,center,center,left,left,center");
			a.setCellHeight(20);
			a.setImgPath("../icon");
			a.setIDPaging("paging");
			a.baseURL("tabel_utils.php?grdKunjAktif=true"+"&filter="+a.getFilter()+"&sorting="+a.getSorting(),"","GET");
			a.Init();
			isLoaded=1;
			
		
		}
	}
	

	function loadGrid12(){
		setTimeout('showTabel()',"5000");
	}

	function showTabel(){
		
		a.loadURL("tabel_utils.php?grdKunjAktif=true","","GET");

		
	}
	
	loadGrid12();
</script>
</html>
