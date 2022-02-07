<?php 
include '../sesi.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>
        alert('Session anda habis atau anda belum login, silakan login ulang.');
        window.location = '/simrs-tangerang/aset/';
        </script>";
}
include '../koneksi/konek.php'; 
include '../header.php';
$id=$_REQUEST['id'];
if($_REQUEST['act']=="hapus"){
	$sqlIns2="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Delete Aset Tak Terkpitalisais','delete from as_kapitalisasi where id=".$id."','".$_SERVER['REMOTE_ADDR']."')";
	mysql_query($sqlIns2);
	$sqlDel="delete from as_kapitalisasi where id='".$id."'";
	mysql_query($sqlDel);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
<script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
<link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
<link type="text/css" rel="stylesheet" href="../default.css"/>
<title>Batasan Nilai Inventaris Tak Terkapitalisasi</title>
</head>

<body>
<iframe height="72" width="130" name="sort"
		id="sort"
		src="../theme/dsgrid_sort.php" scrolling="no"
		frameborder="0"
		style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div align="center">
<table width="1000" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td align="center">
		<table width="500" align="center" cellpadding="3" cellspacing="0">
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td align="center" style="font:large bold">.: Batasan Nilai Inventaris Tak Terkapitalisasi :.</td>
		</tr>
		<tr>
			<td align="right">
			<form action="" method="post" name="form1" id="form1" >
			<input type="hidden" id="id" name="id"  />
			<input type="hidden" id="act" name="act" value="hapus" />
			</form>
			<img src="../icon/taggly.png" style="cursor:pointer" onclick="location='tak_terkapitalisasi_act.php'" />&nbsp;&nbsp;<img src="../icon/edit.gif" style="cursor:pointer" onclick="edit()" />&nbsp;&nbsp;<img src="../icon/hapus.gif" style="cursor:pointer" onclick="hapus()" /></td>
		</tr>
		<tr>
		
			<td>
				 <div id="gridbox" style="width:832px; height:265px; background-color:white; overflow:hidden;"></div>
                 <div id="paging" style="width:831px;"></div>
			</td>
		</tr>
		</table>
 	</td>
</tr>
<tr>
	<td align="center">  
		<?php
		include '../footer.php';
		?>  
	</td>
</tr>
</table>
</div>
</body>
<script language="javascript">
function ambilData1(){
	var ambil=rek.getRowId(rek.getSelRow()).split("|");
	document.getElementById('id').value=ambil[0]
}
function edit(){
	var id=document.getElementById('id').value;
	if(document.getElementById('id').value=='' || document.getElementById('id').value==null){
		alert('Pilih dulu data yang akan di edit !');
	}else{
		
		window.location='tak_terkapitalisasi_act.php?act=edit&id='+id;
	}
}
function hapus(){
	if(document.getElementById('id').value == '' || document.getElementById('id').value == null) {
		alert('Pilih Data Yang Akan Dihapus');
	}else{
		if (confirm('Apakah Anda yakin Ingin Menghapus Data ?'))
			document.forms[0].submit();
	}
} 
function goFilterAndSort(abc){
	if (abc=="gridbox"){
		rek.loadURL("tak_terkapitalisasi_util.php?kode=true&filter="+rek.getFilter()+"&sorting="+rek.getSorting()+"&page="+rek.getPage(),"","GET");
	}
} 
var rek=new DSGridObject("gridbox");
rek.setHeader(".: Batasan Nilai Inventaris Tak Terkapitalisasi :.");
rek.setColHeader("No,Kode,Barang, Nilai, Tgl Diberlakukan");
rek.setIDColHeader(",kode,namabarang,nilai,tgl_berlaku");
rek.setColWidth("50,100,359,150,150");
rek.setCellAlign("center,center,left,right,center");
rek.setCellHeight(20);
rek.setImgPath("../icon");
rek.setIDPaging("paging");
rek.attachEvent("onRowClick","ambilData1");
rek.baseURL("tak_terkapitalisasi_util.php?kode=true&saring=");
rek.Init();
//alert("tak_terkapitalisasi_util.php?kode=true&saring=");
</script>
</html>
