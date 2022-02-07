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
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
<title>Form Tindakan Komponen</title>
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
		<td height="30">&nbsp;FORM TINDAKAN KOMPONEN</td>
	</tr>
</table>
<table width="1000" border="0" cellspacing="1" cellpadding="0" align="center" class="txtinput">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
    <td align="right">Tindakan Kelas&nbsp;</td>
    <td>&nbsp;<select id="cmbTind" name="cmbTind">
		<?php
			$rs = mysql_query("SELECT tk.ms_tindakan_id,t.nama
					FROM b_ms_tindakan_kelas tk
					INNER JOIN b_ms_tindakan t ON t.id=tk.ms_tindakan_id");
            	while($rows=mysql_fetch_array($rs)):
        ?>
			<option value="<?=$rows["ms_tindakan_id"]?>"><?=$rows["nama"]?></option>
             <?	endwhile;?>
                </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
    <td align="right">Komponen&nbsp;</td>
    <td>&nbsp;<select id="cmbKomp" name="cmbKomp">
		<?php
			$dt = mysql_query("SELECT * FROM b_ms_komponen");
            	while($rw=mysql_fetch_array($dt)):
        ?>
			<option value="<?=$rw["id"]?>"><?=$rw["nama"]?></option>
             <?	endwhile;?>
                </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
    <td align="right">Tarif&nbsp;</td>
    <td>&nbsp;<input id="txtTarif" name="txtTarif" size="16" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
	<td>&nbsp;<input id="txtId" type="hidden" name="txtId" /></td>
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
	<td width="5%">&nbsp;</td>
    <td colspan="3">
		<div id="gridbox" style="width:925px; height:200px; background-color:white; overflow:hidden;"></div>
		<div id="paging" style="width:925px;"></div>	</td>
    <td width="5%">&nbsp;</td>
  </tr>
  <tr>
	<td width="5%">&nbsp;</td>
    <td width="30%">&nbsp;</td>
    <td width="30%">&nbsp;</td>
    <td width="30%">&nbsp;</td>
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
		var tind = document.getElementById("cmbTind").value;
		var komp = document.getElementById("cmbKomp").value;
		var tarif = document.getElementById("txtTarif").value;
				
		a.loadURL("tindakan_komp_utils.php?grd=true&act="+action+"&id="+id+"&tind="+tind+"&komp="+komp+"&tarif="+tarif,"","GET");
		
		document.getElementById("cmbTind").value = '';
		document.getElementById("cmbKomp").value = '';
		document.getElementById("txtTarif").value = '';
	}
	
	function ambilData()
	{
		var p="txtId*-*"+(a.getRowId(a.getSelRow()))+"*|*cmbTind*-*"+a.cellsGetValue(a.getSelRow(),2)+"*|*cmbKomp*-*"+a.cellsGetValue(a.getSelRow(),3)+"*|*txtTarif*-*"+a.cellsGetValue(a.getSelRow(),4)+"*|*btnSimpan*-*Simpan*|*btnHapus*-*false";
		//alert(p);
		fSetValue(window,p);
	}
	
	function hapus()
	{
		var rowid = document.getElementById("txtId").value;
		//alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
		if(confirm("Anda yakin menghapus Tindakan Komponen "+a.cellsGetValue(a.getSelRow(),3)))
		{
			a.loadURL("tindakan_komp_utils.php?grd=true&act=hapus&rowid="+rowid,"","GET");
		}
		
		document.getElementById("cmbTind").value = '';
		document.getElementById("cmbKomp").value = '';
		document.getElementById("txtTarif").value = '';
	}
	
	function batal()
	{
		var p="txtId*-**|*cmbTind*-**|*cmbKomp*-**|*txtTarif*-**|*btnSimpan*-*Tambah*|*btnHapus*-*true";
		fSetValue(window,p);		
	}
	
	function goFilterAndSort(grd){
		//alert(grd);
		if (grd=="gridbox"){
			//alert("tabel_utils.php?grd1=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
			a.loadURL("tindakan_komp_utils.php?grd=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
		}/*else if (grd=="gridbox1"){
			//alert("tabel_utils.php?grd2=true&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage());
			b.loadURL("tabel_utils.php?grd2=true&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage(),"","GET");
		}*/
	}
	var a=new DSGridObject("gridbox");
	a.setHeader("DATA TINDAKAN KOMPONEN");	
	a.setColHeader("NO,TINDAKAN KELAS,KOMPONEN,TARIF");
	a.setIDColHeader(",tind,komp,");
	a.setColWidth("50,120,120,100");
	a.setCellAlign("center,left,left,left");
	a.setCellHeight(20);
	a.setImgPath("../icon");
	a.setIDPaging("paging");
	a.attachEvent("onRowClick","ambilData");
	a.baseURL("tindakan_komp_utils.php?grd=true");
	a.Init();
</script>
</html>
