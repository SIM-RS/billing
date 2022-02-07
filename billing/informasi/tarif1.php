<?php
include "../sesi.php";
?>
<?php
//session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css">
<script language="JavaScript" src="../theme/js/ajax.js"></script>
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
<script language="JavaScript" src="../theme/js/mod.js"></script>
<title>Informasi Tarif</title>
</head>

<body>
<div align="center">
<?php
	include("../header1.php");
	include("../koneksi/konek.php")
?>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/dsgrid_sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
	<tr>
		<td height="30">&nbsp;INFORMASI TARIF</td>
	</tr>
</table>
<table width="1000" border="0" cellspacing="0" cellpadding="0" class="tabel" align="center">
  <tr>
    <td colspan="7">&nbsp;</td>
  </tr>
  <tr>
  	<td width="5%">&nbsp;</td>
    <td width="15%" align="right">Jenis Layanan</td>
    <td width="25%">&nbsp;<select id="JnsLayanan" name="JnsLayanan" onchange="isiCombo('TmpLayanan',this.value);loadGrid();" class="txtinput"></select></td>
    <td width="10%">&nbsp;</td>
    <td width="20%" align="right">Klasifikasi Tarif</td>
    <td width="20%">&nbsp;<select id="cmbKlasi" name="cmbKlasi" class="txtinput"></select></td>
  	<td width="5%">&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td align="right">Tempat Layanan</td>
    <td>&nbsp;<select id="TmpLayanan" name="TmpLayanan" class="txtinput">
	</select></td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td colspan="5">
		<div id="gridbox" style="width:925px; height:350px; background-color:white; overflow:hidden;"></div>
		<div id="paging" style="width:925px;"></div>
		</td>
  	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td colspan="7">&nbsp;</td>
    </tr>
  <tr>
  	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" align="right"><b>Terdapat 10 Tarif Layanan</b></td>
  	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td colspan="7">&nbsp;</td>
    </tr>
	<tr>
  	<td colspan="7">&nbsp;</td>
    </tr>
	<tr>
  	<td colspan="7">&nbsp;</td>
    </tr>
  </table>
  <table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
  <tr height="30">
    <td><input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><input type="button" value="&nbsp;&nbsp;&nbsp;Cetak&nbsp;&nbsp;&nbsp;" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" /></a></td>
  </tr>
</table>
</div>
</body>
<script>
	isiCombo('JnsLayanan','','','',showTmpLay);
	function showTmpLay(){
		isiCombo('TmpLayanan',document.getElementById('JnsLayanan').value,'','',showTabel);
	}
	isiCombo('cmbKlasi');
	function isiCombo(id,val,defaultId,targetId,evloaded){
		//alert('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET');
		if(targetId=='' || targetId==undefined){
			targetId=id;
		}
		Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded);
	}
	function loadGrid(){
		setTimeout('showTabel()',100);
	}
	function showTabel(){
		//alert("tabel_utils.php?grd1=true&jns="+document.getElementById('JnsLayanan').value+"&tmp="+document.getElementById('TmpLayanan').value+"&sts="+document.getElementById('StatusPas').value+"&tglMsk="+document.getElementById('tglMsk').value+"&tglSls="+document.getElementById('tglSelesai').value+"&stsPul="+document.getElementById('statusPul').value+"&byTgl="+document.getElementById('byTgl').value,"","GET");
		a.loadURL("tabel_utils.php?grd3=true&jns="+document.getElementById('JnsLayanan').value+"&tmp="+document.getElementById('TmpLayanan').value+"&cmbKlasi="+document.getElementById('cmbKlasi').value,"","GET");
	}
	function goFilterAndSort(grd){
		//alert(grd);
		if (grd=="gridbox"){
			alert("tabel_utils.php?grd3=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
			a.loadURL("tabel_utils.php?grd3=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
		}/*else if (grd=="gridbox1"){
			//alert("tabel_utils.php?grd2=true&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage());
			b.loadURL("tabel_utils.php?grd2=true&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage(),"","GET");
		}*/
	}
	var a=new DSGridObject("gridbox");
	a.setHeader("DATA PASIEN");
	a.setColHeader("KODE PANGGIL,KELOMPOK,NAMA LAYANAN,KELAS,TARIF");
	//a.setIDColHeader(",,NoRM,Kode,Nama,Alamat,Penjamin,dokter,Poli");
	a.setColWidth("100,150,150,75,75");
	a.setCellAlign("center,center,center,center,left,left,center,center,center,center");
	a.setCellHeight(20);
	a.setImgPath("../icon");
	a.setIDPaging("paging");
	a.attachEvent("onRowDblClick","tes1");
	a.baseURL("tabel_utils.php?grd3=true");
	a.Init();
</script>
</html>
