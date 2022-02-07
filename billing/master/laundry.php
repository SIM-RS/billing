<?php 
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>MASTER ALAT</title>
<script type="text/javascript" src="../theme/popup.js"></script>
<link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
<link type="text/css" rel="stylesheet" href="../default.css"/>
<link rel="stylesheet" type="text/css" href="../theme/tab-view.css" />
<link rel="STYLESHEET" type="text/css" href="../theme/codebase/dhtmlxtabbar.css">
<!-------------------------------------------------------------------->
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
<script language="JavaScript" src="../theme/js/ajax.js"></script>
<script type="text/javascript" src="../theme/js/tab-view.js"></script>
<script  src="../theme/codebase/dhtmlxcommon.js"></script>
<script  src="../theme/codebase/dhtmlxtabbar.js"></script>
<script type="text/javascript" src="../jquery.js"></script>
<!--<script type="text/javascript" src="../menu.js"></script>-->

</head>
<iframe height="72" width="130" name="sort"
id="sort"
src="../theme/dsgrid_sort.php" scrolling="no"
frameborder="0"
style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<body>
<?php 
include("../koneksi/konek.php");
include("../header1.php");
?>
<div align="center">
<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
                <tr>
                    <td height="30">&nbsp;MASTER BARANG LAUNDRY</td>
                </tr>
            </table>
<table width="1000" align="center" cellpadding="0" cellspacing="0" class="tabel">
<tr>
	<td align="center">
		<table width="900" align="center" cellpadding="0" cellspacing="0">
		<tr>
		<td>
			<fieldset>
			<table width="900" align="center" class="tbl">
			<tr valign="bottom">
				<td align="right" valign="bottom">
				</td>
			</tr>
			<tr>
				<td align="center">
					<fieldset>
                    	<legend>Master Barang
								                        
                        </legend>
						<table width="300" align="center">
						<tr>
							<td>
								<input type="hidden" id="tampung" name="tampung" />
								<input type="hidden" id="txtId1" name="txtId1" />
								<div id="grid1" style=" width:420px; height:400px"></div>
								<div id="paging1" style=" width:420px; display:block"></div>
							</td>
						</tr>
						</table>
					</fieldset>
				</td>
				<td align="center" valign="middle">
					<button type="button" id="kanan" name="kanan" style="cursor:pointer" onclick="kanan()">>></button><br/><br/>
					<button type="button" id="kiri" name="kiri" style="cursor:pointer" onclick="kiri()" ><<</button>
				</td>
				<td align="center" valign="top">
					<fieldset>
                    	<legend>Master Barang Laundry
                        					
						</legend>
						<table width="300" align="center">
						<tr>
							<td>
								<div id="grid2" style=" width:420px; height:400px"></div>
								<div id="paging2" style=" width:420px;"></div>
							</td>
						</tr>
						</table>
					</fieldset>
				</td>
			</tr>
			</table>
			</fieldset>
		</td>
	</tr>
	</table>
	</td>
</tr>
<tr>
		<td colspan="2" align="center" width="1024" height="50" class="h1" bgcolor="#FFFFFF"><img src="../images/home_03.png"></td>
  </tr>
</table>
</div>
<div id="temp_diag" style="display:none"></div>

</body>
</html>
<script language="javascript">

var gd_a = new DSGridObject("grid1");
gd_a.setHeader(" ",false);
gd_a.setColHeader("<input type='checkbox' id='chk_a' onchange='cek_all(this.id)' />,No,Kode,Nama Barang,Satuan");
gd_a.setIDColHeader(",,kodebarang,namabarang,idsatuan");
gd_a.setColWidth("30,40,130,300,100");
gd_a.setCellAlign("center,center,left,left,center");
gd_a.setCellType("txt,txt,txt,txt,txt");
gd_a.setCellHeight(20);
gd_a.setImgPath("../icon");
gd_a.setIDPaging("paging1");
//gd_a.onLoaded(selesai);
//gd_a.attachEvent("onRowClick","ambil1");
gd_a.baseURL("laundry_utils.php?grd=1");
gd_a.Init();


var gd_b = new DSGridObject("grid2");
gd_b.setHeader(" ",false);
gd_b.setColHeader("<input type='checkbox' id='chk_b' onchange='cek_all(this.id)' />,No,Kode,Nama Barang,Satuan");
gd_b.setIDColHeader(",,kodebarang,namabarang,idsatuan");
gd_b.setColWidth("30,40,130,300,100");
gd_b.setCellAlign("center,center,left,left,center");
gd_b.setCellType("txt,txt,txt,txt,txt");
gd_b.setCellHeight(20);
gd_b.setImgPath("../icon");
gd_b.setIDPaging("paging2");
//gd_b.onLoaded(selesai);
//gd_b.attachEvent("onRowClick","ambil2");
gd_b.baseURL("laundry_utils.php?grd=2");
gd_b.Init();

function cek_all(x){
	if(x=='chk_a'){
		if(document.getElementById(x).checked){
			for(var i=0;i<gd_a.obj.childNodes[0].rows.length;i++){	
				gd_a.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked = true;		
			}
		}
		else{
			for(var i=0;i<gd_a.obj.childNodes[0].rows.length;i++){	
				gd_a.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked = false;		
			}
		}	
	}
	else if(x=='chk_b'){
		if(document.getElementById(x).checked){
			for(var i=0;i<gd_b.obj.childNodes[0].rows.length;i++){	
				gd_b.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked = true;		
			}
		}
		else{
			for(var i=0;i<gd_b.obj.childNodes[0].rows.length;i++){	
				gd_b.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked = false;		
			}
		}	
	}
}

var data='';
function kirimkanan(){
data='';
	for(var r = 0; r<gd_a.getMaxRow();r++){
		var px = "cekbok"+r; 
		if(document.getElementById(px).checked){
			data += document.getElementById(px).value+"|";
		}
	}
}
function kirimkiri(){
data='';
	for(var r = 0; r<gd_b.getMaxRow();r++){
		var px = "ngecek"+r; 
		if(document.getElementById(px).checked){
			data += document.getElementById(px).value+"|";
		}
	}
}
function kanan(){
	kirimkanan();
	Request("laundry_utils.php?act=kanan"+"&data="+data,'temp_diag','','GET',load_grid2,'noload');
}

function kiri(){
	kirimkiri();
	Request("laundry_utils.php?act=kiri"+"&data="+data,'temp_diag','','GET',load_grid2,'noload');
}
function goFilterAndSort(abc){
	//alert(abc);
	if (abc=="grid1"){
		gd_a.loadURL("laundry_utils.php?grd=1"+"&filter="+gd_a.getFilter()+"&sorting="+gd_a.getSorting()+"&page="+gd_a.getPage(),"","GET");
	}
	if (abc=="grid2"){
		gd_b.loadURL("laundry_utils.php?grd=2"+"&filter="+gd_b.getFilter()+"&sorting="+gd_b.getSorting()+"&page="+gd_b.getPage(),"","GET");
	}
}
<!--======================act2==================================================-->

//( vUrl , vTarget, vForm, vMethod,evl,noload,targetWindow)
/*isiTmpLay();

function isiTmpLay(){
	Request("../combo_utils.php?id=cmbTmpLay&value=<?php //echo $_SESSION['userIdLaundry']; ?>,",'','','GET',load_grid2,'noload');
}*/

function load_grid2(){
	gd_a.loadURL("laundry_utils.php?grd=1","","GET");
	gd_b.loadURL("laundry_utils.php?grd=2","","GET");
}

/*function ambil1(){
	var sisipan=gd_a.getRowId(gd_a.getSelRow()).split("|");
	document.getElementById('id').value=sisipan[0];
	document.getElementById('kodebarang').value=gd_a.cellsGetValue(gd_a.getSelRow(),2);
	document.getElementById('namabarang').value=gd_a.cellsGetValue(gd_a.getSelRow(),3);
	document.getElementById('idsatuan').value=gd_a.cellsGetValue(gd_a.getSelRow(),4);
	document.getElementById('save').value='update';
	document.getElementById('save').innerHTML='<img src="../icon/edit.gif" width="25" height="25" align="absmiddle" />&nbsp;Ubah';
	document.getElementById('delete').innerHTML='<img src="../icon/delete.gif" width="25" height="25" align="absmiddle" />&nbsp;Hapus';
	document.getElementById('delete').disabled=false;
}

function ambil2(){
	var sisipan=gd_b.getRowId(gd_b.getSelRow()).split("|");
	document.getElementById('id').value=sisipan[0];
	document.getElementById('kodebarang').value=gd_b.cellsGetValue(gd_b.getSelRow(),2);
	document.getElementById('namabarang').value=gd_b.cellsGetValue(gd_b.getSelRow(),3);
	document.getElementById('idsatuan').value=gd_b.cellsGetValue(gd_b.getSelRow(),4);
	document.getElementById('save').value='update';
	document.getElementById('save').innerHTML='<img src="../icon/edit.gif" width="25" height="25" align="absmiddle" />&nbsp;Ubah';
	document.getElementById('delete').innerHTML='<img src="../icon/delete.gif" width="25" height="25" align="absmiddle" />&nbsp;Hapus';
	document.getElementById('delete').disabled=false;
}*/
</script>
