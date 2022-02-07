<?php
session_start();
include '../inc/koneksi.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='/simrs-pelindo/';
                        </script>";
}
$id=$_REQUEST['txtId'];
if($_REQUEST['act']=='hapus'){
	$sqlDel="delete from ms_user where id='".$id."'";
	mysql_query($sqlDel);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ADMINISTRATOR -- Sistem Informasi Manajemen Rumah Sakit</title>
                
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

            	
                <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                    <td align="center" height="30" style="font-size:large;font-family:Verdana, Arial, Helcetica, sans-serif; font-weight:bold" valign="top">.: Manajemen User :.
                    </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <table width="900" border="0" cellspacing="0" cellpadding="0" align="center" class="tabel">
                                <tr>
                                  <td height="30" valign="bottom" align="right">
										<form action="" method="post" name="forms1" id="forms1">
                                        <input type="hidden" id="txtId" name="txtId" />
										<input type="hidden" id="act" name="act" value="hapus" />
										</form>
                                        <div align="left"><img alt="tambah" style="cursor: pointer" src="/simrs-pelindo/sdm/images/tambah.png" onclick="location='user_act.php'" width="20" height="20" />&nbsp;&nbsp;
                                          <img alt="edit" style="cursor: pointer" src="/simrs-pelindo/sdm/images/edit.gif" onclick="jupuk()" width="20" height="20" />&nbsp;&nbsp;
                                          <img alt="hapus" style="cursor: pointer" src="/simrs-pelindo/sdm/images/hapus.gif" id="btnHapus" name="btnHapus" onclick="hapus();" width="20" height="20" />&nbsp;                                    </div></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center">
                                       <div id="gridboxext" align="left"></div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>

					</tr>
                </table>
           
			    </center>   
            </div>
            
            <div id="footer">
               	<?php include("../inc/footer.php"); ?>
            </div>
            
        </div>
</body>
</html>
    <script language="javascript">
 Ext.onReady(function (){
 function ambilid(){  
	var z = ri.getSelRowId();
	var data=z.split('||');
	document.getElementById('txtId').value=data[0];
}

ri = new extGrid("gridboxext");        
ri.setTitle(".: Daftar Master User :.");
ri.setHeader("<center>No</center>,<center>User Name</center>,<center>Nama</center>,<center>Tipe</center>,<center>Nama Unit</center>,<center>Status</center>");
ri.setColId("NO,username,nama,tipe_nama,namaunit,aktif");
ri.setColType("string,string,string,string,string,string,");
ri.setColWidth("10,100,190,100,200,200");
ri.setColAlign("center,left,left,left,left,center")
ri.setWidthHeight(800,300);
ri.setClickEvent(ambilid);
ri.baseURL("user_util.php?kode=true&saring=true&sharing=");                                    
ri.init(); 

});	
	function goFilterAndSort(abc){
	if (abc=="gridboxext"){
		ri.loadURL("m_user_util.php?kode=true&filter="+ri.getFilter()+"&sorting="+rek.getSorting()+"&page="+ri.getPage(),"","GET");
	}
}
function jupuk(){
	if(document.getElementById('txtId').value=='' || document.getElementById('txtId').value==null){
		alert('Pilih dulu yang akan di edit !');
	}else{
		window.location="user_act.php?act=edit&id="+document.getElementById('txtId').value;
	}
}
function hapus(){
	if(document.getElementById('txtId').value == '' || document.getElementById('txtId').value == null) {
		alert('Pilih Data Yang Akan Dihapus');
	}else{
		if (confirm('Apakah Anda yakin Ingin Menghapus Data ??'))
			document.forms[0].submit();
	}
} 
</script>
</html>
