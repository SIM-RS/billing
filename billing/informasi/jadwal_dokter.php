<?php
	session_start();
	include("../sesi.php");
	$userId = $_SESSION['userId'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
<link rel="stylesheet" type="text/css" href="../theme/tab-view.css" />
<script type="text/javascript" src="../theme/js/tab-view.js"></script>

<!--dibawah ini diperlukan untuk menampilkan popup-->
<link rel="stylesheet" type="text/css" href="../theme/popup.css" />
<script type="text/javascript" src="../theme/prototype.js"></script>
<script type="text/javascript" src="../theme/effects.js"></script>
<script type="text/javascript" src="../theme/popup.js"></script>
<!--diatas ini diperlukan untuk menampilkan popup-->

<!-- untuk ajax-->
<script type="text/javascript" src="../theme/js/ajax.js"></script>
<script type="text/javascript" src="../include/jquery/jquery-1.9.1.js"></script>
<!-- untuk ajax-->

<title>Jadwal Dokter</title>
</head>

<body>
	
<div align="center">
<?php
	include("../koneksi/konek.php");
	include("../header1.php");
?>
<script>
var arrRange=depRange=[];
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
	frameborder="1"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/dsgrid_sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
	<tr>
		<td height="30">&nbsp;INFORMASI JADWAL DOKTER</td>
	</tr>
</table>
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center" class="tabel">  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center">
	
		<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="tabel" align="center">
		  <tr>
			<td colspan="7" align="center">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="5%">&nbsp;</td>
			<td width="15%" align="right">Jenis Layanan</td>
			<td width="25%">&nbsp;
				<select id="cmbJnsLay" class="txtinput" onchange="isiTmpLay();"></select>
			</td>
			<td width="10%">&nbsp;</td>
			<td width="20%" align="right"></td>
			<td width="20%">&nbsp;</td>
			<td width="5%">&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td align='right'>Tempat Layanan</td>
			<td>&nbsp;
				<select id="TmpLayanan" class="txtinput" onchange="ubahUnit();"></select>
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td align="right">Tanggal</td>
			<td colspan="5">&nbsp;
				<input type="text" class="txtcenterreg" id="tanggal" size="11" tabindex="22" value="<?php echo date('d-m-Y');?>"/>
				<input type="button" id="buttontglAwal" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('tanggal'),depRange,ubahUnit);" />
				s/d
				<input type="text" class="txtcenterreg" id="sampai" size="11" tabindex="22" value="<?php echo date('d-m-Y');?>"/>
				<input type="button" id="buttontglAwal" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('sampai'),depRange,ubahUnit);" />
			</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
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
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td colspan="5">
				<div id="gridbox" style="width:900px; height:350px; background-color:white; overflow:hidden;"></div>
				<div id="paging" style="width:900px;"></div>
				</td>
			<td>&nbsp;</td>
		  </tr>
		  </table>
	
	</td>
  </tr>
   <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  </table>
  <table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
  <tr height="30">
   	<td width="20%">&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" /></td>
	<td width="30%" align="right"><a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;"/></a>&nbsp;</td>
  </tr>
</table>

</div>

</body>
<script>
function goFilterAndSort(){
	var unit_id = document.getElementById('TmpLayanan').value;
	var tanggal = document.getElementById('tanggal').value;
	var sampai = document.getElementById('sampai').value;
	grd.loadURL("jadwal_dokter_utils.php?unit_id="+unit_id+'&tanggal='+tanggal+"&sampai="+sampai+"&filter="+grd.getFilter()+"&sorting="+grd.getSorting()+"&page="+grd.getPage(),"","GET");
}

isiCombo('JnsLayanan','','','cmbJnsLay',isiTmpLay);

grd=new DSGridObject("gridbox");
grd.setHeader("JADWAL DOKTER");	
grd.setColHeader("NO,TANGGAL,WAKTU,NAMA,NIP");
grd.setIDColHeader(",,jam,nama,nip");
grd.setColWidth("30,140,140,500,230");
grd.setCellAlign("center,center,center,left,center");
grd.setCellHeight(20);
grd.setImgPath("../icon");
grd.setIDPaging("paging");
// grd.attachEvent("onRowClick","ubah");
grd.baseURL("jadwal_dokter_utils.php");
grd.Init();



function isiTmpLay(){
	isiCombo('TmpLayanan',document.getElementById('cmbJnsLay').value,'','TmpLayanan',ubahUnit);
}

function ubahUnit(){
	var unit_id = document.getElementById('TmpLayanan').value;
	var tanggal = document.getElementById('tanggal').value;
	var sampai = document.getElementById('sampai').value;
	grd.loadURL("jadwal_dokter_utils.php?unit_id="+unit_id+'&tanggal='+tanggal+"&sampai="+sampai,"","GET");
}

function isiCombo(id,val,defaultId,targetId,evloaded){
	if(targetId=='' || targetId==undefined){
		targetId=id;
	}
	Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded);
}
</script>
</html>
