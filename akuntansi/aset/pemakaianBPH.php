<?php 
session_start();
include("../koneksi/konek.php");

$username = $_SESSION['akun_username'];
$password = $_SESSION['akun_password'];
$idunit = $_SESSION['akun_ses_idunit'];
$iduser = $_SESSION['akun_iduser'];
$kategori = $_SESSION['akun_kategori'];

if (empty ($username) AND empty ($password)){
	header("Location: ../index.php");
	exit();
}

$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$kso=$_REQUEST['kso'];
$tempat=$_REQUEST['tempat'];
if($_REQUEST['tanggal']==""){
	$tanggal = $tgl;
}else{
	$tanggal = $_REQUEST['tanggal'];
}
$tang = explode('-',$tanggal);
$tanggalan = $tang[2].'-'.$tang[1].'-'.$tang[0];
$waktu = "t.tgl='$tanggalan'";
?>
<html>
<head>
<title>Sistem Informasi Akuntansi</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script type="text/JavaScript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
<!--script src="../theme/js/noklik.js" type="text/javascript"></script-->
<link rel="stylesheet" href="../theme/simkeu.css" type="text/css" />
</head>
<body>
<div align="center">
<?php
$wktnow=gmdate('H:i:s',mktime(date('H')+7));
$wkttgl=gmdate('d/m/Y',mktime(date('H')+7));
$url=split("/",$_SERVER['REQUEST_URI']);
$imgpath="/".$url[1]."/images";
$iunit=$_SESSION['akun_username'];
?>
<style type="text/css">
<!--
.style1 {font-family: Verdana, Arial, Helvetica, sans-serif}
-->
</style>
<script>
	var arrRange=depRange=[];
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
	frameborder="0"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 500px; visibility: hidden">
</iframe>

<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/dsgrid_sort.php" scrolling="no"
	frameborder="1"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 500px; visibility: hidden">
</iframe>

<table width="1000" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="4"><img src="../images/kop3.png" width="1000" height="100" border="0" /></td>
  </tr>
  <tr class="H">
  	<td id="dateformat" height="25">&nbsp;&nbsp;<?php echo $wkttgl; ?>&nbsp;&nbsp;login &nbsp;&nbsp;&nbsp;&nbsp;: <?=strtoupper($username); ?></td>
	<td colspan="3" id="logout" height="25" align="right">&nbsp;&nbsp;</td>
  </tr>
</table>

<script>
document.getElementById("logout").innerHTML='<a class="a1" href="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs-pelindo/portal.php">Portal</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
</script>
<table width="1000" border="0" cellspacing="0" cellpadding="0" class="tblbody">
	<tr align="center" valign="top">
		<td class="bodykiri"><?php include("../unit/menua.php");?></td>
	</tr>
<tr align="center" valign="top">
	<td align="left" height="430">
        <div align="center">
            <table width="980" border="0" cellpadding="0" cellspacing="0" class="txtinput">
                <tr>
                    <td class="jdltable" height="29" colspan="2">Pemakaian BP Habis</td>
                </tr>
                <tr>
                    <td width="315" height="25" style="padding-right:20px; text-align:right;">Tanggal Periode</td>
                    <td width="665">:&nbsp;
                  <input id="tgl" name="tgl" readonly size="11" class="txtcenter" type="text" value="<?php echo $tanggal; ?>" />&nbsp;<input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onClick="gfPop.fPopCalendar(document.getElementById('tgl'),depRange,kirim);"/>&nbsp;&nbsp;s/d&nbsp;&nbsp;<input id="tgl2" name="tgl2" readonly size="11" class="txtcenter" type="text" value="<?php echo $tanggal; ?>" />&nbsp;<input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onClick="gfPop.fPopCalendar(document.getElementById('tgl2'),depRange,kirim);"/></td>
                </tr>
                <tr>
                    <td height="30" style="padding-left:45px;"><select id="cmbPost" name="cmbPost" class="txtinput" style="background-color:#FFFFCC; color:#990000;" onChange="kirim();">
                        <option value="0">BELUM POSTING</option>
                        <option value="1">SUDAH POSTING</option>
                    </select>
                    </td>
                    <td height="30" align="right" style="padding-right:45px;"><BUTTON type="button" id="pst" onClick="posting();"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Posting >> Jurnal</BUTTON></td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <div id="gridbox" style="width:900px; height:300px; background-color:white; overflow:hidden;"></div>
                        <div id="paging" style="width:900px;"></div>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </div>
	</td>
</tr>
</table>
</div>
<script>
function kirim(){
var tgl1=document.getElementById('tgl').value;
var tgl2=document.getElementById('tgl2').value;
var posting=document.getElementById('cmbPost').value;
if (posting==1){
	document.getElementById('pst').disabled=true;
}else{
	document.getElementById("pst").disabled = false;
}
Rizli.loadURL("bph_util.php?kode=true&tgl1="+tgl1+"&tgl2="+tgl2+"&posting="+posting,'','GET');
//alert("bph_util.php?kode=true&tgl1="+tgl1+"&tgl2="+tgl2+"&posting="+posting);
}
function goFilterAndSort(abc){
var tgl1=document.getElementById('tgl').value;
var tgl2=document.getElementById('tgl2').value;
	if (abc=="gridbox"){
		Rizli.loadURL("bph_util.php?kode=true&tgl1="+tgl1+"&tgl2="+tgl2+"&filter="+Rizli.getFilter()+"&sorting="+Rizli.getSorting()+"&page="+Rizli.getPage(),"","GET");
	}
} 
Rizli=new DSGridObject("gridbox");
Rizli.setHeader(".: DATA PEMAKAIAN BARANG PAKAI HABIS :.");
Rizli.setColHeader("No,Tgl,Kode Transaksi, Nama Unit, Kode Barang,Nama Barang, Nilai,Posting<BR><input type='checkbox' name='chkAll' id='chkAll' onClick='chkKlik(this.checked);'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
Rizli.setIDColHeader(",tgl_gd,no_gd,nama_unit,kodebarang,namabarang,nilai,");
Rizli.setColWidth("46,100,150,200,100,200,100,100");
Rizli.setCellAlign("center,center,center,left,center,left,right,center");
Rizli.setCellType("txt,txt,txt,txt,txt,txt,txt,chk");
Rizli.setCellHeight(20);
Rizli.setImgPath("../icon");
Rizli.setIDPaging("paging");
//Rizli.attachEvent("onRowClick","ambilData1");
Rizli.baseURL("bph_util.php?kode=true&tgl1="+document.getElementById('tgl').value+"&tgl2="+document.getElementById('tgl2').value);
Rizli.Init();
//alert("bph_util.php?kode=true&tgl1="+document.getElementById('tgl').value+"&tgl2="+document.getElementById('tgl2').value);
function chkKlik(p){
var cekbox=(p==true)?1:0;
	//alert(p);
	for (var i=0;i<Rizli.getMaxRow();i++){
		Rizli.cellsSetValue(i+1,8,cekbox);
	}
}
	
	function posting(){
		var tmp ='';
			for (var i=0;i<Rizli.getMaxRow();i++){
				//alert("a");
			if (Rizli.obj.childNodes[0].childNodes[i].childNodes[7].childNodes[0].checked){
				tmp += Rizli.getRowId(i+1)+"*";
			//	alert(tmp);
			}
		}
		var url = "bph_util.php?kode=true&cmb="+document.getElementById("cmbPost").value+"&tgl1="+document.getElementById('tgl').value+"&tgl2="+document.getElementById('tgl2').value+"&act=posting&data="+tmp;
		//alert(url);
		Rizli.loadURL(url,"","GET");		
	
        if (tmp!=""){
		tmp=tmp.substr(0,(tmp.length-1));
		//alert(tmp.length);
		if (tmp.length>1024){
			alert("Data Yg Mau diPosting Terlalu Banyak !");
		}else{
			url+="&act=postingHapus&fdata="+tmp;
			//alert(url);
			Rizli.loadURL(url,"","GET");
		}
	}else{
		alert("Pilih Data Yg Mau diPosting Terlebih Dahulu !");
	}
}
</script>
</body>
</html>