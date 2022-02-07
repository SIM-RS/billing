<?
include '../sesi.php';
?>

<head>
<script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
<script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
<link type="text/css" rel="stylesheet" href="../default.css"/>
<link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
</head>
<h3 align="center">DATA BARANG</h3>
 
 		<form name="form_tampilkanBarang" id="form_tampilkanBarang" method="post">
        <table border="0" cellspacing="0" cellpadding="0" width="100%" class="login">            
			<tr><td>						
			<div id="gridbox" style="width:500px; height:200px; background-color:white; overflow:hidden;"></div>
			<div id="paging" style="width:500px;"></div>
			</td></tr>
            <tr>
              <td style="font-size:12px; font-weight:bold">
			  <input type="hidden" id="txtId" name="txtId" />
			  <input type="hidden" id="brg" name="brg" />
			  <input type="button" name="cmdBatalBarang" id="cmdBatalBarang" value="Pilih" onClick="ambil()" >
			  <input type="button" name="cmdBatalBarang" id="cmdBatalBarang" value="Batal" onClick="batal()" >
			  </td>
            </tr>
        </table>
		</form>			  
<script language="javascript">
function ambilData(){
var sisipan=mygrid1.getRowId(mygrid1.getSelRow()).split("|");
document.getElementById('txtId').value=sisipan[0];
// window.location='data_anggota2.php?act=edit&agid='+id;
}
function ambil(){
var barang=document.getElementById('brg').value=mygrid1.cellsGetValue(mygrid1.getSelRow(),3);
window.opener.document.getElementById('brg').value=mygrid1.cellsGetValue(mygrid1.getSelRow(),3);
window.opener.document.getElementById('kodebrg').value=mygrid1.cellsGetValue(mygrid1.getSelRow(),2);
window.opener.document.getElementById('idbrg').value=mygrid1.getRowId(mygrid1.getSelRow());
window.close();
//location='datailTanah.php?brg='+barang;
}
function batal(){
window.close();
}
function goFilterAndSort(abc){
	if (abc=="gridbox"){
		mygrid1.loadURL("baranglist_jln_util.php?kode=true&filter="+mygrid1.getFilter()+"&sorting="+mygrid1.getSorting()+"&page="+mygrid1.getPage(),"","GET");
	}
} 
var mygrid1=new DSGridObject("gridbox");
mygrid1.setHeader(".: Master Barang :.");
mygrid1.setColHeader("No, Kode Barang, Nama Barang ");
//mygrid1.setIDColHeader(",kodebarang,namabarang");
mygrid1.setColWidth("40, 150, 450");
mygrid1.setCellAlign("center,left,left");
//mygrid1.setCellType("txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,chk");
mygrid1.setCellHeight(20);
mygrid1.setImgPath("../icon");
mygrid1.setIDPaging("paging");
mygrid1.attachEvent("onRowClick","ambilData");
mygrid1.baseURL("baranglist_jln_util.php?kode=true&saring=true&saring=");
mygrid1.Init();
		//alert("tnh_brg_util.php?kode=true&saring=true&saring=");
</script>