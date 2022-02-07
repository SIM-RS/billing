<?php 
include '../sesi.php';
include '../koneksi/konek.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>
        alert('Session anda habis atau anda belum login, silakan login ulang.');
        window.location = '/simrs-tangerang/aset/';
        </script>";
}
?>
<?php  include("../header.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
<script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
<link type="text/css" rel="stylesheet" href="../default.css"/>
<link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
<title>.: Jalan Irigasi :.</title>
</head>
<?php include('jln_mutasi.php'); ?>
<body>
<iframe height="72" width="130" name="sort"
		id="sort"
		src="../theme/dsgrid_sort.php" scrolling="no"
		frameborder="0"
		style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div align="center" id="tutup" style="display:block">
<table width="1000" align="center" bgcolor="#FFFFFF">
<tr>
	<td align="center">
		<table width="800" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td align="center" style="font-size:large">.: Data Jalan,Irigasi & Jaringan :.</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td align="right">
			
			<form method="post" action="">
			<input type="hidden" id="txtId" name="txtId" />
			<input type="hidden" id="kode" name="kode" />
			<input type="hidden" id="act" name="act" value="hapus" /> 
			<input type="hidden" id="idlokasi" name="idlokasi" /> 
			</form>
			<button type="button" id="ctkxls" name="ctkxls" onClick="ctkKIB_Tnhxls()" style="cursor:pointer"><img src="../icon/excel_logo.png" width="23" height="23" style="vertical-align:middle">&nbsp;Export Ke Excel</button>&nbsp;
			<button type="button" id="ctktnh" name="ctktnh" onClick="ctkKIB_Tnh()" style="cursor:pointer"><img src="../icon/article.gif">&nbsp;Cetak KIB Jalan</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <img alt="edit" src="../images/edit.gif" style="cursor: pointer" onclick="if(document.getElementById('txtId').value == '' || document.getElementById('txtId').value == null){alert('Pilih dulu yang akan diedit.');return;}edit();" />&nbsp;&nbsp;
		  <img alt="Mutasi Barang" title="Mutasi Barang" src="../icon/mutasi.gif" id="btnHapusTanah" name="btnHapus" onClick="if(document.getElementById('txtId').value == '' || document.getElementById('txtId').value == null){alert('Pilih barang terlebih dahulu.');return;} mutasi()";/>&nbsp;
          <img alt="hapus" src="../images/hapus.gif" style="cursor: pointer" id="btnHapusPO" name="btnHapus" onclick="if(document.getElementById('txtId').value == '' || document.getElementById('txtId').value == null){alert('Pilih barang terlebih dahulu.');return;}OpenWnd('jln_hapus.php?id='+txtId.value,650,280,'Daftar Ruangan',true);" />&nbsp;
			</td>
		</tr>
		<tr>
			<td>
			<div id="gridbox" style="width:891px; height:200px; background-color:white; overflow:hidden;"></div>
			<div id="paging" style="width:891px;"></div>
            </td>
		</tr>
		</table>
	</td>
</tr>
<tr><td><div><img src="../images/foot.gif" width="1000" height="45"></div></td></tr>
</table> 
</div>
</body>
<script language="javascript">	
function ctkKIB_Tnh(){
var sisipan=rek.getRowId(rek.getSelRow()).split("|");
var kode=document.getElementById('kode').value=sisipan[6];
window.open('jln_laporan.php?kode='+kode);
}
function ctkKIB_Tnhxls(){
		window.open('jln_laporan.php?jenislap=XLS');
	}

function ambilData(){
var sisipan=rek.getRowId(rek.getSelRow()).split("|");
document.getElementById('txtId').value=sisipan[0];
document.getElementById('kode').value=rek.cellsGetValue(rek.getSelRow(),2)
rek.Init();
}

function mutasi(){
document.getElementById('idmutasi').style.display='block';
document.getElementById('tutup').style.display='none';
 rek.Init();
var sisipan=rek.getRowId(rek.getSelRow()).split("|");
document.getElementById('idUnit').value=sisipan[2];
document.getElementById('txtId').value=sisipan[0];
document.getElementById('idUnit_lama').value=sisipan[4];
document.getElementById('kodeunitlama').value=rek.cellsGetValue(rek.getSelRow(),2);

//alert(sisipan[3]);

//location='jln_irigasi_data.php?unitlama='+unitlama+'&ruang='+ruanglama+'&idunit='+idunit+'&idseri='+idseri+'&Rizal=1';
}
function edit(){
			//alert("data_anggota2.php?id="+document.getElementById('txtId').value);
            window.location='jln_edit.php?id='+document.getElementById('txtId').value;
        }
function goFilterAndSort(abc){
	//var id = document.getElementById('id').value;
	if (abc=="gridbox"){
		//alert("util_anggota.php?kode=true"+"&agid="+id+"&filter="+rek.getFilter()+"&sorting="+rek.getSorting()+"&page="+rek.getPage());
		rek.loadURL("jln_util.php?kode=true&filter="+rek.getFilter()+"&sorting="+rek.getSorting()+"&page="+rek.getPage(),"","GET");
	}
}
 		var rek=new DSGridObject("gridbox");
        rek.setHeader(".: Kartu Inventaris Barang - Jalan, Irigasi Dan Jaringan :.");
        rek.setColHeader("No, Kode Unit, Kode Brg, No Seri, Nama Barang, Panjang (Km), Lebar (m), Kondisi (B/KB/RB)");
        rek.setIDColHeader(",kodeunit,kodebarang,,namabarang,,,,");
        rek.setColWidth("40, 150, 100, 75, 200, 100, 100, 100");
        rek.setCellAlign("center,center,center,center,left,center,center,center");
		//rek.setCellType("txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,chk");
        rek.setCellHeight(20);
        rek.setImgPath("../icon");
        rek.setIDPaging("paging");
        rek.attachEvent("onRowClick","ambilData");
        rek.baseURL("jln_util.php?kode=true&saring=true&saring=");
        rek.Init();
		//alert("jln_util.php?kode=true&saring=true&saring=");
  </script>
</html>
