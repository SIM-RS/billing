<?
include("../sesi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
<title>Diagnosis</title>
</head>

<body>
<div align="center">
<?php
	include("../header1.php");
	include("../koneksi/konek.php");
	
	$parentId = $_REQUEST['id'];
	//$parentKode = $_REQUEST['kode'];
	
	$sql = "SELECT * FROM b_ms_diagnosa where id = $parentId";
	$rs = mysql_query($sql);
	$row = mysql_fetch_array($rs);
?>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/dsgrid_sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
	<tr>
		<td height="30">&nbsp;FORM DIAGNOSIS ICD</td>
	</tr>
</table>
<table width="1000" border="0" cellspacing="1" cellpadding="0" class="txtinput" align="center">
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td colspan="3" style="text-transform:uppercase;" height="30"><b>Diagnosis RS <?php echo $row["nama"]; ?></b></td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td colspan="3">Filter&nbsp;&nbsp;&nbsp;<input size="24" /></td>
	<td>&nbsp;</td>
  </tr> <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">Kode&nbsp;</td>
	<input id="txtId" type="hidden" name="txtId" />
    <td>&nbsp;<input size="24" id="txtKode" name="txtKode" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td align="right">Diagnosis RS&nbsp;</td>
    <td>&nbsp;<input size="50" id="txtDiagnosa" name="txtDiagnosa" /></td>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td align="right">Surveilance&nbsp;</td>
	<td>&nbsp;<select id="cmbSur" name="cmbSur">
		<option value="0">Tidak</option>
		<option value="1">Ya</option>
	</select></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td align="right">Status&nbsp;</td>
	<td>&nbsp;<input type="checkbox" id="isAktif" name="isAktif" />&nbsp;&nbsp;Aktif</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td height="30">
		<input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="simpan(this.value);" class="tblTambah"/>
		<input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus(this.title);" disabled="disabled" class="tblHapus"/>
		<input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/>
	</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td colspan="3">
		<div id="gridbox" style="width:925px; height:350px; background-color:white; overflow:hidden;"></div>
		<div id="paging" style="width:925px;"></div>
	</td>
	<td>&nbsp;</td>
  </tr>
<tr>
  	<td width="5%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="50%">&nbsp;</td>
    <td align="right" width="20%"><a href="diagnosis1.php"><input type="button" value="&nbsp;&nbsp;&nbsp;< 1&nbsp;&nbsp;&nbsp;"></a>&nbsp;<input type="button" disabled="disabled" value="&nbsp;&nbsp;&nbsp;> 2&nbsp;&nbsp;&nbsp;"></td>
	<td width="5%">&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  </table>
  <table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
  <tr height="30">
    <td>&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" /></td>
		<td>&nbsp;</td>
		<td align="right"><a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" /></a>&nbsp;</td>
  </tr>
</table>
</div>
</body>
<script>
	function simpan(action)
	{
		var id = document.getElementById("txtId").value;
		var kode = document.getElementById("txtKode").value;
		var nama = document.getElementById("txtDiagnosa").value;
		var sur = document.getElementById("cmbSur").value;
		if(document.getElementById("isAktif").checked == true)
		{
			var aktif = 1;
		}
		else
		{
			var aktif = 0;
		}
		
		//alert("diagnosa_utils.php?grd=true&act="+action+"&idInduk=<?php echo $parentId;?>&idAnak="+id+"&kode="+kode+"&kodeInduk=<?php echo $row["kode"];?>&nama="+nama+"&levelInduk=<?php echo $row["level"]; ?>&sur="+sur+"&aktif="+aktif);
		a.loadURL("diagnosa_utils.php?grd=true&act="+action+"&idInduk=<?php echo $parentId;?>&idAnak="+id+"&kode="+kode+"&kodeInduk=<?php echo $row["kode"];?>&nama="+nama+"&levelInduk=<?php echo $row["level"]; ?>&sur="+sur+"&aktif="+aktif,"","GET");
		
		document.getElementById("txtKode").value = '';
		document.getElementById("txtDiagnosa").value = '';
		document.getElementById("cmbSur").value = '';
		document.getElementById("isAktif").checked = false;
	}
	
	function ambilData()
	{
		var p="txtId*-*"+(a.getRowId(a.getSelRow()))+"*|*txtKode*-*"+a.cellsGetValue(a.getSelRow(),2)+"*|*txtDiagnosa*-*"+a.cellsGetValue(a.getSelRow(),3)+"*|*cmbSur*-*"+a.cellsGetValue(a.getSelRow(),7)+"*|*isAktif*-*"+((a.cellsGetValue(a.getSelRow(),9)=='Aktif')?'true':'false')+"*|*btnSimpan*-*Simpan*|*btnHapus*-*false";
		fSetValue(window,p);
	}
	
	function hapus()
	{
		var rowid = document.getElementById("txtId").value;
		//alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
		if(confirm("Anda yakin menghapus Diagnosis RS "+a.cellsGetValue(a.getSelRow(),3)))
		{
			a.loadURL("diagnosa_utils.php?grd=true&idInduk=<?php echo $parentId;?>&act=hapus&rowid="+rowid,"","GET");
		}
		
		document.getElementById("txtKode").value = '';
		document.getElementById("txtDiagnosa").value = '';
		document.getElementById("cmbSur").value = '';
		document.getElementById("isAktif").checked = false;
	}
	
	function batal()
	{
		var p="txtId*-**|*txtKode*-**|*txtDiagnosa*-**|*cmbSur*-**|*isAktif*-*false*|*btnSimpan*-*Tambah*|*btnHapus*-*true";
		fSetValue(window,p);		
	}
	
	function goFilterAndSort(grd){
		//alert(grd);
		if (grd=="gridbox"){
			//alert("tabel_utils.php?grd1=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
			a.loadURL("tabel_utils.php?grd=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
		}/*else if (grd=="gridbox1"){
			//alert("tabel_utils.php?grd2=true&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage());
			b.loadURL("tabel_utils.php?grd2=true&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage(),"","GET");
		}*/
	}
	var a=new DSGridObject("gridbox");
	a.setHeader("DIAGNOSIS");
	a.setColHeader("NO,KODE ICD,DIAGNOSIS ICD,LEVEL,PARENT ID,PARENT KODE,SURVEILANCE,ISLAST,STATUS AKTIF");
	a.setIDColHeader(",,kode,nama,level,,,,,");
	a.setColWidth("50,75,150,75,75,75,75,75,75");
	a.setCellAlign("center,left,left,center,center,center,center,center,center");
	a.setCellHeight(20);
	a.setImgPath("../icon");
	a.setIDPaging("paging");
	a.attachEvent("onRowClick","ambilData");
	a.baseURL("diagnosa_utils.php?grd=true&idInduk=<?php echo $parentId;?>");
	a.Init();
</script>
</html>
<?php 
mysql_close($konek);
?>