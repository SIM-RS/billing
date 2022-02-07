<?php
session_start();
include("../sesi.php");
?>
<?php
include("../koneksi/konek.php");
//session_start();
$user_id=$_SESSION['userId'];
$unit_id=$_SESSION['unitId'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>

<!--dibawah ini diperlukan untuk menampilkan popup-->
<link rel="stylesheet" type="text/css" href="../theme/popup.css" />
<script type="text/javascript" src="../theme/prototype.js"></script>
<script type="text/javascript" src="../theme/effects.js"></script>
<script type="text/javascript" src="../theme/popup.js"></script>
<!--diatas ini diperlukan untuk menampilkan popup-->

<!-- untuk ajax-->
<script type="text/javascript" src="../theme/js/ajax.js"></script>
<!-- untuk ajax-->

<!-- Tab View -->
<link rel="stylesheet" type="text/css" href="../theme/tab-view.css" />
<script type="text/javascript" src="../theme/js/tab-view.js"></script>
<!-- End Tab View -->

<title>Setting Tarif Tempat Layanan</title>
</head>

<body>
	<div align="center">
<?php
	include("../header1.php");
?>
</div>
      <div align="center" id="div_tindakan">
		<iframe height="72" width="130" name="sort"
                    id="sort"
                    src="../theme/dsgrid_sort.php" scrolling="no"
                    frameborder="0"
                    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
            </iframe>
		
    <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
		<tr>
			<td height="30">&nbsp;FORM SETTING TARIF TEMPAT LAYANAN</td>
			<input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="40" tabindex="3" value="<?php echo $flag; ?>"/>
		</tr>
	</table>
	<table width="1000" border="0" cellspacing="1" cellpadding="0" align="center" class="tabel">
		<tr>
			<td colspan="5">
				<div class="TabView" id="TabView" style="width: 925px; height: 500px;"></div>
			</td>
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
             <td align="right"><a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" class="btninput" /></a>&nbsp;</td>
         </tr>
    </table>
         </div>
      </body>
</html>
<script>
	var mTab=new TabView("TabView");
	mTab.setTabCaption("TARIF TEMPAT LAYANAN,TEMPAT LAYANAN ICD 9 CM");
	mTab.setTabCaptionWidth("450,475");
	mTab.onLoaded(showgrid);
	mTab.setTabPage("tindakan_rs.php,tindakan_icd9.php");
	//tabview_width("TabView","60,90,60");

function showgrid(){
	b=new DSGridObject("gridbox");
	b.setHeader("DATA TINDAKAN");	
	b.setColHeader("<input type='checkbox' id='chk_b' onchange='cek_all(this.id)' />,Nama Tindakan,Nama Penjamin,Kelas,Tarif,Kelompok,Klasifikasi");
	b.setIDColHeader(",tindakan,nama_penjamin,kelas,tarip,kelompok,klasifikasi");
	b.setColWidth("20,250,150,100,100,100,100");
	b.setCellAlign("left,left,left,center,right,center,center");
	b.setCellType("chk,txt,txt,txt,txt,txt,txt");
	b.setCellHeight(20);
	b.setImgPath("../icon");
	b.setIDPaging("paging");
	//b.attachEvent("onRowClick","ambilTindakanKelas");	
	b.baseURL("tarif_tempat_layanan_utils.php?grd=1&unitId="+document.getElementById('cmbUnit').value);
	b.Init();
	
	//alert(document.getElementById('cmbUnit').value);
	isiCombo('TmpLayanan',document.getElementById('cmbJnsLay').value,'','cmbUnit',ubahUnit);
	
	c=new DSGridObject("gridbox2");
	c.setHeader("DATA TINDAKAN PER UNIT");	
	c.setColHeader("<input type='checkbox' id='chk_c' onchange='cek_all(this.id)' />,Nama Tindakan,Nama Penjamin,Kelas,Tarif,Kelompok,Klasifikasi");
	c.setIDColHeader(",tindakan,nama_penjamin,kelas,tarip,kelompok,klasifikasi");
	c.setColWidth("20,250,150,100,100,100,100");
	c.setCellAlign("left,left,left,center,right,center,center");
	c.setCellType("chk,txt,txt,txt,txt,txt,txt");
	c.setCellHeight(20);
	c.setImgPath("../icon");
	c.setIDPaging("paging2");
	//c.attachEvent("onRowClick","ambilTindakanUnit");	
	c.baseURL("tarif_tempat_layanan_utils.php?grd=2&unitId="+document.getElementById('cmbUnit').value);
	c.Init();
	
	
	//alert(document.getElementById('cmbUnit').value);
	isiCombo('TmpLayanan',document.getElementById('cmbJnsLay2').value,'','cmbUnit2',ubahUnit);
	
	d=new DSGridObject("gridbox3");
	d.setHeader("DATA TINDAKAN ICD 9 CM");	
	d.setColHeader("<input type='checkbox' id='chk_d' onchange='cek_all(this.id)' />,Kode,Nama Tindakan");
	d.setIDColHeader(",CODE,STR");
	d.setColWidth("20,80,250");
	d.setCellAlign("center,left,left");
	d.setCellType("chk,txt,txt");
	d.setCellHeight(20);
	d.setImgPath("../icon");
	d.setIDPaging("paging3");
	//b.attachEvent("onRowClick","ambilTindakanKelas");	
	d.baseURL("tarif_tempat_layanan_utils.php?grd=3&unitId="+document.getElementById('cmbUnit2').value);
	d.Init();
	
	e=new DSGridObject("gridbox4");
	e.setHeader("DATA TINDAKAN ICD 9 CM PER UNIT");	
	e.setColHeader("<input type='checkbox' id='chk_e' onchange='cek_all(this.id)' />,Kode,Nama Tindakan");
	e.setIDColHeader(",CODE,STR");
	e.setColWidth("20,80,250");
	e.setCellAlign("center,left,left");
	e.setCellType("chk,txt,txt");
	e.setCellHeight(20);
	e.setImgPath("../icon");
	e.setIDPaging("paging4");
	//c.attachEvent("onRowClick","ambilTindakanUnit");	
	e.baseURL("tarif_tempat_layanan_utils.php?grd=4&unitId="+document.getElementById('cmbUnit2').value);
	e.Init();
}
	
	function isiCombo(id,val,defaultId,targetId,evloaded){
		//alert('pasien_list.php?act=combo&id='+id+'&value='+val);
		if(targetId=='' || targetId==undefined){
			targetId=id;
		}
		Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded);
		
	}
	//isiCombo('TmpLayanan',document.getElementById('cmbJnsLay').value,'','cmbUnit',ubahUnit);
	
	function ubahUnit(){
		b.loadURL("tarif_tempat_layanan_utils.php?grd=1&unitId="+document.getElementById('cmbUnit').value,"","GET");
		c.loadURL("tarif_tempat_layanan_utils.php?grd=2&unitId="+document.getElementById('cmbUnit').value,"","GET");
		d.loadURL("tarif_tempat_layanan_utils.php?grd=3&unitId="+document.getElementById('cmbUnit2').value,"","GET");
		e.loadURL("tarif_tempat_layanan_utils.php?grd=4&unitId="+document.getElementById('cmbUnit2').value,"","GET");
	}
	
	function ambilTindakanKelas(){
		if(b.obj.childNodes[0].childNodes[b.getSelRow()-1].childNodes[0].childNodes[0].checked)
			b.obj.childNodes[0].childNodes[b.getSelRow()-1].childNodes[0].childNodes[0].checked=false;
		else
			b.obj.childNodes[0].childNodes[b.getSelRow()-1].childNodes[0].childNodes[0].checked=true;
	}
	
	function ambilTindakanUnit(){
		if(c.obj.childNodes[0].childNodes[c.getSelRow()-1].childNodes[0].childNodes[0].checked)
			c.obj.childNodes[0].childNodes[c.getSelRow()-1].childNodes[0].childNodes[0].checked=false;
		else
			c.obj.childNodes[0].childNodes[c.getSelRow()-1].childNodes[0].childNodes[0].checked=true;
	}
	
	var idTin='';
	function pindahKanan(){
		idTin='';	
		for(var i=0;i<b.obj.childNodes[0].rows.length;i++){
			//alert(b.obj.childNodes[0].rows.length)
			if(b.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked){
				var getBaris=b.getRowId(parseInt(i)+1).split("|");
				var barisId=getBaris[0];
				//if(i != (b.obj.childNodes[0].rows.length-1)){
					idTin+=barisId+',';	
				//} else {
				//	idTin+=barisId;	
				//}
			}
		}
		//alert(idTin);		
		if(idTin==''){
			alert("Silakan pilih tindakan!");
		}
		else{
			var sisip=b.getRowId(b.getSelRow()).split("|");
			//alert("tarif_tempat_layanan_utils.php?grd=2&act=tambah&id="+idTin+"&unitId="+document.getElementById('cmbUnit').value+"&kode_tindakan="+sisip[2]);
			c.loadURL("tarif_tempat_layanan_utils.php?grd=2&act=tambah&id="+idTin+"&unitId="+document.getElementById('cmbUnit').value+"&kode_tindakan="+sisip[2]+"&flag="+document.getElementById('flag').value, "", "GET");
			b.loadURL("tarif_tempat_layanan_utils.php?grd=1&unitId="+document.getElementById('cmbUnit').value+"&flag="+document.getElementById('flag').value,"","GET");
			idTin='';
		}
	}
	
	var idTin='';
	function pindahKanan2(){
		idTin='';
		for(var i=0;i<d.obj.childNodes[0].rows.length;i++){
			//alert(d.obj.childNodes[0].rows.length)
			if(d.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked){
				var getBaris=d.getRowId(parseInt(i)+1).split("|");
				var barisId=getBaris[0];
				//if(i != (d.obj.childNodes[0].rows.length-1)){
					idTin+=barisId+',';	
				//} else {
				//	idTin+=barisId+',';	
				//}
			}
		}
		//alert(idTin);		
		if(idTin==''){
			alert("Silakan pilih tindakan!");
		}
		else{
			var sisip=d.getRowId(d.getSelRow()).split("|");
			//alert("tarif_tempat_layanan_utils.php?grd=2&act=tambah&id="+idTin+"&unitId="+document.getElementById('cmbUnit').value+"&kode_tindakan="+sisip[2]);
			e.loadURL("tarif_tempat_layanan_utils.php?grd=4&act=tambah&id="+idTin+"&unitId="+document.getElementById('cmbUnit2').value+"&flag="+document.getElementById('flag').value, "", "GET");
			d.loadURL("tarif_tempat_layanan_utils.php?grd=3&unitId="+document.getElementById('cmbUnit2').value+"&filter="+d.getFilter()+"&sorting="+d.getSorting()+"&page="+d.getPage()+"&flag="+document.getElementById('flag').value,"","GET");
			idTin='';
		}
	}
	
	var idTinUnit='';
	function pindahKiri(){		
		for(var i=0;i<c.obj.childNodes[0].rows.length;i++){
			if(c.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked){
				var getBaris=c.getRowId(parseInt(i)+1).split("|");
				var barisId=getBaris[0];
				idTinUnit+=barisId+',';	
			}
		}
		//alert(idTin);		
		if(idTinUnit==''){
			alert("Silakan pilih tindakan unit!");
		}
		else{
			var sisip=c.getRowId(c.getSelRow()).split("|");
		c.loadURL("tarif_tempat_layanan_utils.php?grd=2&act=hapus&id="+idTinUnit+"&unitId="+document.getElementById('cmbUnit2').value+"&flag="+document.getElementById('flag').value,"","GET");
		b.loadURL("tarif_tempat_layanan_utils.php?grd=1&unitId="+document.getElementById('cmbUnit2').value+"&flag="+document.getElementById('flag').value,"","GET");
		idTinUnit='';
		}
	}
	
	var idTinUnit='';
	function pindahKiri2(){		
		for(var i=0;i<e.obj.childNodes[0].rows.length;i++){
			if(e.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked){
				var getBaris=e.getRowId(parseInt(i)+1).split("|");
				var barisId=getBaris[0];
				idTinUnit+=barisId+',';	
			}
		}
		//alert(idTin);		
		if(idTinUnit==''){
			alert("Silakan pilih tindakan unit!");
		}
		else{
			var sisip=e.getRowId(e.getSelRow()).split("|");
		e.loadURL("tarif_tempat_layanan_utils.php?grd=4&act=hapus&id="+idTinUnit+"&unitId="+document.getElementById('cmbUnit2').value+"&kode_tindakan="+sisip[2]+"&flag="+document.getElementById('flag').value,"","GET");
		d.loadURL("tarif_tempat_layanan_utils.php?grd=3&unitId="+document.getElementById('cmbUnit2').value+"&filter="+d.getFilter()+"&sorting="+d.getSorting()+"&page="+d.getPage()+"&flag="+document.getElementById('flag').value,"","GET");
		idTinUnit='';
		}
	}
	
	function goFilterAndSort(grd){		
        if(grd=="gridbox"){
//alert("tarif_tempat_layanan_utils.php?grd=1&unitId="+document.getElementById('cmbUnit').value+"&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage());
			b.loadURL("tarif_tempat_layanan_utils.php?grd=1&unitId="+document.getElementById('cmbUnit').value+"&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage(),"","GET");
		}
		else if(grd=="gridbox2"){			
			c.loadURL("tarif_tempat_layanan_utils.php?grd=2&unitId="+document.getElementById('cmbUnit').value+"&filter="+c.getFilter()+"&sorting="+c.getSorting()+"&page="+c.getPage(),"","GET");
		}
		else if(grd=="gridbox3"){
//alert("tarif_tempat_layanan_utils.php?grd=1&unitId="+document.getElementById('cmbUnit').value+"&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage());
			d.loadURL("tarif_tempat_layanan_utils.php?grd=3&unitId="+document.getElementById('cmbUnit2').value+"&filter="+d.getFilter()+"&sorting="+d.getSorting()+"&page="+d.getPage(),"","GET");
		}
		else if(grd=="gridbox4"){			
			e.loadURL("tarif_tempat_layanan_utils.php?grd=4&unitId="+document.getElementById('cmbUnit2').value+"&filter="+e.getFilter()+"&sorting="+e.getSorting()+"&page="+e.getPage(),"","GET");
		}
    }
	
	function cek_all(a){
		if(a=='chk_b'){
			if(document.getElementById(a).checked){
				for(var i=0;i<b.obj.childNodes[0].rows.length;i++){	
					b.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked = true;		
				}
			}
			else{
				for(var i=0;i<b.obj.childNodes[0].rows.length;i++){	
					b.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked = false;		
				}
			}
		}
		else if(a=='chk_c'){
			if(document.getElementById(a).checked){
				for(var i=0;i<c.obj.childNodes[0].rows.length;i++){	
					c.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked = true;		
				}
			}
			else{
				for(var i=0;i<c.obj.childNodes[0].rows.length;i++){	
					c.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked = false;		
				}
			}
		} else if(a=='chk_d'){
			if(document.getElementById(a).checked){
				for(var i=0;i<d.obj.childNodes[0].rows.length;i++){	
					d.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked = true;		
				}
			}
			else{
				for(var i=0;i<d.obj.childNodes[0].rows.length;i++){	
					d.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked = false;		
				}
			}
		}
		else if(a=='chk_e'){
			if(document.getElementById(a).checked){
				for(var i=0;i<e.obj.childNodes[0].rows.length;i++){	
					e.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked = true;		
				}
			}
			else{
				for(var i=0;i<e.obj.childNodes[0].rows.length;i++){	
					e.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked = false;		
				}
			}
		}
	}
</script>