<?php
session_start();
include '../inc/koneksi.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='../../index.php';
                        </script>";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ADMINISTRATOR -- Sistem Informasi Manajemen Rumah Sakit</title>
<link type="text/css" href="../inc/menu/menu.css" rel="stylesheet" />
<script type="text/javascript" src="../js/jquery-1.7.2.js"></script>
<script type="text/javascript" src="../inc/menu/menu.js"></script> 
</head>

<body>
	
<div id="wrapper">
        <div id="header">
			<?php include("../inc/header.php");?>
        </div>
            
		<div id="topmenu">
            <?php include("../inc/menu/menu.php"); ?>
        </div>
            
<div id="content">
			
<center>
<iframe height="72" width="130" name="sort" id="sort"
src="../theme/dsgrid_sort.php" scrolling="no"
frameborder="0"
style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<style>
input[type='text'],select,textarea{
padding:3px 4px;
border:1px solid #999999;
}
</style>
		
<table width="1000" align="center" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td align="center" style="font-size:large">.: Master Unit :.</td>
</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
        <tr>
        <td align="center">
        <table width="600" border="0" cellspacing="0" cellpadding="0" align="center" class="tabel">
        <tr>
       		<td height="30" valign="bottom" align="right">
            	<button type="button" onClick="PreviewTree();" style="cursor: pointer">
                <img alt="add" src="../icon/view_tree.gif" border="0" width="16" height="16" ALIGN="absmiddle" />
                Tampilkan Master Unit Dalam Tree
                </button>
				<button type="button" onClick="PreviewTreeBilling();" style="cursor: pointer">
                <img alt="add" src="../icon/view_tree.gif" border="0" width="16" height="16" ALIGN="absmiddle" />
                Unit Billing Dalam Tree
                </button>
                                    
                <input type="hidden" id="txtId" name="txtId" />
                <img alt="tambah" style="cursor: pointer" src="../images/tambah.png" onClick="location='ms_unit_detail.php?act=add'" />&nbsp;&nbsp;
                <img alt="edit" style="cursor: pointer" src="../images/edit.png" onClick="ubah();" />&nbsp;&nbsp;
                <img alt="hapus" style="cursor: pointer" src="../images/hapus.png" id="btnHapusUnit" name="btnHapusUnit" onClick="if(document.getElementById('txtId').value == '' || document.getElementById('txtId').value == null){alert('Pilih Master Unit terlebih dahulu.');return;}hapus();" />&nbsp;
              </td>
        </tr>
        <tr>
        <td>&nbsp;</td>                    
        </tr>
		<tr>
			<td align="center"><div id="gridboxext" style="width:100%"></div></td>
		</tr>
		
<tr><td>&nbsp;</td></tr>
</table>
</td>
</tr>
<tr>
	<td height="28" background="../images/main-bg.png" style="background-repeat:repeat-x;">&nbsp;</td>
</tr>
</table>
</div>
	<div id="footer">
		<?php
			$query = mysql_query("SELECT pegawai.pegawai_id, pegawai.nama,
				pgw_jabatan.id, pgw_jabatan.jbt_id,
				ms_jabatan_pegawai.id, ms_jabatan_pegawai.nama_jabatan
				FROM rspelindo_hcr.pegawai
				INNER JOIN rspelindo_hcr.pgw_jabatan ON pgw_jabatan.pegawai_id = pegawai.pegawai_id
				LEFT JOIN rspelindo_hcr.ms_jabatan_pegawai ON ms_jabatan_pegawai.id = pgw_jabatan.jbt_id
				WHERE pegawai.pegawai_id=".$_SESSION['user_id']);
			$i=0;
			$pegawai='';
			$jabatan='';
			while($row = mysql_fetch_array($query)){
				if($i==0)
					$pegawai = $row['nama'];
				if($i>0)
					$jabatan .= ", ";
				$jabatan .= $row['nama_jabatan'];	
				$i++; 
			}
		?>
		<div style="float:left;">Nama: <span style="color:yellow"><?php echo $pegawai;?></span></div>
		<div style="float:right;"> <span style="color:yellow;"><?=$jabatan?></span> : Jabatan</div>
	</div>    
</div>
<div id="tempor" style="display:none"></div>
</body>
</html>
<script language="javascript">
Ext.onReady(function (){
 function ambilid(){  	
	var z = ri.getSelRowId();
    document.getElementById('txtId').value=z;
}
ri = new extGrid("gridboxext");        
ri.setTitle(".: Daftar Unit :.");
ri.setHeader("No,Kode Unit,Nama Unit,Nick,Level,Aktif");
ri.setColId("NO,kodeunit,namaunit,nickunit,level,aktif");
ri.setColType("string,string,string,string,string,string");
ri.setColWidth("50,150,300,200,70,100");
ri.setColAlign("center,left,left,center,center");
ri.setWidthHeight(900,300);
ri.setClickEvent(ambilid);
ri.baseURL("ms_unit_utils.php?kode=true&saring=true&sharing=");                                    
ri.init(); 

});	
	/* function goFilterAndSort(abc){
	if (abc=="gridboxext"){
		ri.loadURL("master_eselon_utils.php.php?kode=true&filter="+ri.getFilter()+"&sorting="+rek.getSorting()+"&page="+ri.getPage(),"","GET");
	}
} */

function ubah(){
	if(document.getElementById('txtId').value=='' || document.getElementById('txtId').value==null){ 
		alert ('Pilih data Unit terlebih dahulu..!'); return;
	}
	location='ms_unit_detail.php?act=edit&id='+document.getElementById('txtId').value;			
}

function PreviewTree()
{
	location='ms_unit_tree.php';
}
function PreviewTreeBilling()
{
	OpenWnd('ms_unit_billing_full_treeup.php?act=<?=$act; ?>&billing_id=<?=$data['billing_id'];?>&par=billing_parent_id*billing_parent_kode*billing_parent_nama',800,500,'msma',true);
}

		
function hapus(id){
	var z = ri.getSelRowId();
	var rowidUnit =  document.getElementById('txtId').value=z;

	if(confirm("Anda yakin menghapus"+ri.getCellValue(ri.getSelRowIndex(),3)+"?")){
		ri.loadURL("ms_unit_utils.php?act=hapus&id="+rowidUnit,"","GET");
	}
}
function seger(){
location="master_unit.php";
}
</script>

