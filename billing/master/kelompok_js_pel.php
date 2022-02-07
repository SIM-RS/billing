<?php
session_start();
include("../sesi.php");
?>
<?php
//session_start();
include("../koneksi/konek.php");
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
		<td height="30">&nbsp;FORM SETTING TARIF TINDAKAN JASA LAYANAN</td>
	</tr>
          </table>
         <table width="1000" border="0" cellspacing="1" cellpadding="0" align="center" class="tabel">
         <tr>
           <td width="5%">&nbsp;</td>
           <td width="40%">&nbsp;</td>
           <td width="10%">&nbsp;</td>
           <td width="40%">&nbsp;</td>
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
           <td>
		 <fieldset>
			<legend>Daftar Tindakan</legend>
			<div id="gridbox" style="width:400px; height:340px; background-color:white; overflow:hidden;"></div>
			<div id="paging" style="width:410px;"></div>
            </fieldset>
	     </td>
		<td align="center">         
			<input type="button" id="btnRight" value="" onclick="pindahKanan()" class="tblRight"/>
			<br>
			<input type="button" id="btnLeft" value="" onclick="pindahKiri()" class="tblLeft"/>
		</td>
           <td>
		<fieldset>
			<legend>Daftar Tindakan Tiap Kelompok Jasa Pelayanan</legend>
			<table>
			<tr>
				<td>
					
				</td>
				<td>Nama Remunerasi</td>
				<td>
                	<input type="hidden" id="txtIdremun" name="txtIdremun" />
					<input type="text" id="rm" name="rm" size="35" readonly="readonly" />&nbsp;&nbsp;<img src="../icon/view_tree.gif" style="cursor:pointer" align="absbottom" onclick="OpenWnd('ms_remunrasi_treeup.php?<?php echo 'par=txtIdremun*rm'; ?>',800,500,'msma',true)" />
				</td>
			</tr>
			
			</table>
			<div id="gridbox2" style="width:400px; height:300px; background-color:white; overflow:hidden;"></div>
			<div id="paging2" style="width:410px;"></div>
			
            </fieldset>
	     </td>
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
             <td align="right"><a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" class="btninput" /></a>&nbsp;</td>
         </tr>
       </table>
         </div>
      </body>
</html>
<script>
	
	/*function isiCombo(id,val,defaultId,targetId,evloaded){
		//alert('pasien_list.php?act=combo&id='+id+'&value='+val);
		if(targetId=='' || targetId==undefined){
			targetId=id;
		}
		Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded);
		
	}
	isiCombo('TmpLayanan',document.getElementById('cmbJnsLay').value,'','cmbUnit',ubahUnit);*/
	
	function ubahUnit(){
		b.loadURL("kelompok_js_pel_utils.php?grd=1","","GET");
		c.loadURL("kelompok_js_pel_utils.php?grd=2","GET");
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
		for(var i=0;i<b.obj.childNodes[0].rows.length;i++){
			if(b.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked){
				var getBaris=b.getRowId(parseInt(i)+1).split("|");
				var barisId=getBaris[0];
				idTin+=barisId+',';	
			}
		}
		//alert(idTin);		
		if(idTin==''){
			alert("Silakan pilih tindakan!");
		}else if(document.getElementById("txtIdremun").value==''){
			alert("Pilih nama remunerasi terlebih dahulu");
			document.getElementById("rm").focus();
			return false;
		}
		else{
			var sisip=b.getRowId(b.getSelRow()).split("|");
		c.loadURL("kelompok_js_pel_utils.php?grd=2&act=tambah&id="+idTin+"&idrm="+document.getElementById("txtIdremun").value,"","GET");
		b.loadURL("kelompok_js_pel_utils.php?grd=1","","GET");
		idTin='';
		}
	}
	function kirim(){
		goFilterAndSort("gridbox");
		c.loadURL("kelompok_js_pel_utils.php?grd=2&idrm="+document.getElementById("txtIdremun").value,"","GET")	
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
		c.loadURL("kelompok_js_pel_utils.php?grd=2&act=hapus&id="+idTinUnit,"","GET");
		c.loadURL("kelompok_js_pel_utils.php?grd=2&idrm="+document.getElementById("txtIdremun").value,"","GET")
		setTimeout('kirim()', 500);
		b.loadURL("kelompok_js_pel_utils.php?grd=1","","GET");
		idTin='';
		}
		
	}
	
	function goFilterAndSort(grd){		
            if(grd=="gridbox"){
			//alert("kelompok_js_pel_utils.php?grd=1&idrm="+document.getElementById("txtIdremun").value+"&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage());
			b.loadURL("kelompok_js_pel_utils.php?grd=1&idrm="+document.getElementById("txtIdremun").value+"&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage(),"","GET");
		}
		else if(grd=="gridbox2"){			
			c.loadURL("kelompok_js_pel_utils.php?grd=2&idrm="+document.getElementById("txtIdremun").value+"&filter="+c.getFilter()+"&sorting="+c.getSorting()+"&page="+c.getPage(),"","GET");
		}
      }

	b=new DSGridObject("gridbox");
	b.setHeader("DATA TINDAKAN");	
	b.setColHeader("<input type='checkbox' id='chk_b' onchange='cek_all(this.id)' />,Nama Tindakan,Kelas,Tarif,Kelompok,Klasifikasi");
	b.setIDColHeader(",tindakan,kelas,tarip,kelompok,klasifikasi");
	b.setColWidth("20,250,100,100,100,100");
	b.setCellAlign("left,left,center,right,center,center");
	b.setCellType("chk,txt,txt,txt,txt,txt");
	b.setCellHeight(20);
	b.setImgPath("../icon");
	b.setIDPaging("paging");
	//b.attachEvent("onRowClick","ambilTindakanKelas");	
	b.baseURL("kelompok_js_pel_utils.php?grd=1");
	b.Init();
	
	c=new DSGridObject("gridbox2");
	c.setHeader("DATA TINDAKAN PER UNIT");	
	c.setColHeader("<input type='checkbox' id='chk_c' onchange='cek_all(this.id)' />,Nama Tindakan,Kelas,Tarif,Kelompok,Klasifikasi");
	c.setIDColHeader(",tindakan,kelas,tarip,kelompok,klasifikasi");
	c.setColWidth("20,250,100,100,100,100");
	c.setCellAlign("left,left,center,right,center,center");
	c.setCellType("chk,txt,txt,txt,txt,txt");
	c.setCellHeight(20);
	c.setImgPath("../icon");
	c.setIDPaging("paging2");
	//c.attachEvent("onRowClick","ambilTindakanUnit");	
	c.baseURL("kelompok_js_pel_utils.php?grd=2&idrm="+document.getElementById('txtIdremun').value);
	c.Init();
	
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
		}
	}
</script>