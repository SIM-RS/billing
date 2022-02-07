<?php
session_start();
include("../sesi.php");
?>
<?php
//session_start();
?>
<?php
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
<title>Referensi Wilayah</title>
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
            <td height="30">&nbsp;FORM WILAYAH</td>
        </tr>
    </table>
    <table width="1000" border="0" cellpadding="0" cellspacing="1" class="tabel" align="center">
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td colspan="3" style="color:#660000" height="30"><b>Data Wilayah (Propinsi)</b></td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td colspan="5">&nbsp;</td>
  </tr>
  <tr>
  	<td width="5%">&nbsp;</td>
	<td width="35%" align="right">Kode Wilayah&nbsp;&nbsp;&nbsp;</td>
    <td width="40%"><input id="txtId" type="hidden" name="txtId" /><input id="txtKode" name="txtKode" type="text" size="20" class="txtinput"/>
	</td>
    <td width="15%">&nbsp;</td>
	<td width="5%">&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td align="right">Nama Wilayah&nbsp;&nbsp;&nbsp;</td>
    <td><input id="txtNama" name="txtNama" size="32" class="txtinput"/></td>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
	<!-- <tr>
  	<td>&nbsp;</td>
    <td align="right">Flag&nbsp;&nbsp;&nbsp;</td>
    <td> -->
		<input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="32" tabindex="3" value="<?php echo $flag; ?>"/>
		<!-- </td>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr> -->
  <tr>
  	<td>&nbsp;</td>
	<td align="right">Level&nbsp;&nbsp;&nbsp;</td>
	<td><input id="txtLevel" name="txtLevel" size="5" class="txtinput"/>&nbsp;&nbsp;
		Parent Id&nbsp;<input id="txtParentId" name="txtParentId" size="5" class="txtinput"/>&nbsp;&nbsp;
		Parent Kode&nbsp;<input id="txtParentKode" name="txtParentKode" size="6" class="txtinput"/>&nbsp;
	<input type="button" class="txtcenter" id="btnParent" name="btnParent" value="..." title="Pilih Induk" onClick="OpenWnd('wilayah_tree_view.php?<?php echo $qstr_ma_sak; ?>',800,500,'msma',true)">    
		<input type="hidden" id="txtParentLvl" name="txtParentLvl" size="6" /></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td align="right">Status&nbsp;&nbsp;&nbsp;</td>
	<td>&nbsp;<input type="checkbox" id="isAktif" name="isAktif" class="txtinput"/>&nbsp;&nbsp;Aktif</td>
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
	<td><button type="button" id="btnTree" name="btnTree" value="Tampilan Tree" onclick="window.location='wilayah_tree.php'" class="tblViewTree">Tampilan Tree</button></td>
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
  <!--tr>
  	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><input type="button" id="prev" disabled="disabled" name="prev" value="&nbsp;Prev&nbsp;"/>&nbsp;&nbsp;&nbsp;<input type="button" id="next" name="next" value="&nbsp;Next&nbsp;" onclick="location='ref_wilayah_kota.php?id='+document.getElementById('txtId').value;"/></td>
	<td>&nbsp;</td>
  </tr-->
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
    <table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000" align="center">
		<tr height="30">
  	<td>&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" class="btninput"/></td>
	<td>&nbsp;</td>
	<td align="right"><a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" class="btninput" /></a>&nbsp;</td>
  </tr>
</table>
</div>
</body>
<script>
function simpan(action)
	{
		var id = document.getElementById("txtId").value;
		var kode = document.getElementById("txtKode").value;
		var nama = document.getElementById("txtNama").value;
		var level = document.getElementById("txtLevel").value;
		var parentId = document.getElementById("txtParentId").value;
		var parentKode = document.getElementById("txtParentKode").value;
		var flag = document.getElementById("flag").value;
		if(document.getElementById("isAktif").checked == true)
		{
			var aktif = 1;
		}
		else
		{
			var aktif = 0;
		}
		
		//alert("diag_utils.php?grd=true&act="+action+"&id="+id+"&kode="+kode+"&nama="+nama+"&level="+level+"&parentId="+parentId+"&parentKode="+parentKode+"&sur="+sur+"&aktif="+aktif);
		a.loadURL("wilayah_utils.php?grd=true&act="+action+"&id="+id+"&kode="+kode+"&nama="+nama+"&level="+level+"&parentId="+parentId+"&parentKode="+parentKode+"&flag="+flag+"&aktif="+aktif,"","GET");
		
		document.getElementById("txtKode").value = '';
		document.getElementById("txtNama").value = '';
		document.getElementById("txtLevel").value = '';
		document.getElementById("txtParentId").value = '';
		document.getElementById("txtParentKode").value = '';
		document.getElementById("isAktif").checked = false;
	}
	
	function ambilData()
	{
		var p="txtId*-*"+(a.getRowId(a.getSelRow()))+"*|*txtKode*-*"+a.cellsGetValue(a.getSelRow(),2)+"*|*txtNama*-*"+a.cellsGetValue(a.getSelRow(),3)+"*|*txtLevel*-*"+a.cellsGetValue(a.getSelRow(),4)+"*|*txtParentLvl*-**|*txtParentId*-*"+a.cellsGetValue(a.getSelRow(),5)+"*|*txtParentKode*-*"+a.cellsGetValue(a.getSelRow(),6)+"*|*isAktif*-*"+((a.cellsGetValue(a.getSelRow(),7)=='Aktif')?'true':'false')+"*|*btnSimpan*-*Simpan*|*btnHapus*-*false";
		fSetValue(window,p);
	}
	
	function hapus()
	{
		var rowid = document.getElementById("txtId").value;
		//alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
		if(confirm("Anda yakin menghapus Propinsi "+a.cellsGetValue(a.getSelRow(),3)))
		{
			a.loadURL("wilayah_utils.php?grd=true&act=hapus&rowid="+rowid,"","GET");
		}
		
		document.getElementById("txtKode").value = '';
		document.getElementById("txtNama").value = '';
		document.getElementById("txtLevel").value = '';
		document.getElementById("txtParentId").value = '';
		document.getElementById("txtParentKode").value = '';
		document.getElementById("isAktif").checked = false;
	}
	
	function batal()
	{
		var p="txtId*-**|*txtKode*-**|*txtNama*-**|*txtParentLvl*-**|*txtParentId*-**|*txtParentKode*-**|*txtLevel*-**|*isAktif*-*false*|*btnSimpan*-*Tambah*|*btnHapus*-*true";
		fSetValue(window,p);		
	}
	
	function goFilterAndSort(grd){
		//alert("tmpt_layanan_utils.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
		a.loadURL("wilayah_utils.php?grd=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
	}
	
	var a=new DSGridObject("gridbox");
	a.setHeader("DATA WILAYAH");
	a.setColHeader("NO,KODE,NAMA PROPINSI,LEVEL,PARENT ID,PARENT KODE,AKTIF");
	a.setIDColHeader(",kode,nama,level,,,");
	a.setColWidth("50,75,150,75,75,75,75");
	a.setCellAlign("center,left,left,center,center,left,center");
	a.setCellHeight(20);
	a.setImgPath("../icon");
	a.setIDPaging("paging");
	a.attachEvent("onRowClick","ambilData");
	a.baseURL("wilayah_utils.php?grd=true");
	a.Init();
</script>
</html>
