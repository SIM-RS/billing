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
if($_REQUEST['tglAwal']=="" || $_REQUEST['tglAkhir']==""){
	$tglAwal = $tgl;
	$tglAkhir = $tgl;
}else{
	$tglAwal = $_REQUEST['tglAwal'];
	$tglAkhir = $_REQUEST['tglAkhir'];
}
$tang = explode('-',$tanggal);
$tanggalan = $tang[2].'-'.$tang[1].'-'.$tang[0];
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
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
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
		<td class="bodykiri"><?php include("menua.php");?></td>
	</tr>
<tr align="center" valign="top">
	<td align="left" height="430">
        <div align="center">
            <table width="980" border="0" cellpadding="0" cellspacing="0" class="txtinput">
                <tr>
                    <td class="jdltable" height="29" colspan="2">Transaksi Return Obat ke PBF</td>
                </tr>
                <tr>
                    <td style="padding-right:20px; text-align:right;" height="25" width="35%">Tanggal</td>
                    <td width="65%" style="font-weight:bold;">:&nbsp;<input id="tglAwal" name="tglAwal" readonly size="11" class="txtcenter" type="text" value="<?php echo $tglAwal; ?>" />&nbsp;<input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onClick="gfPop.fPopCalendar(document.getElementById('tglAwal'),depRange);"/> s.d. <input id="tglAkhir" name="tglAkhir" readonly size="11" class="txtcenter" type="text" value="<?php echo $tglAkhir; ?>" />&nbsp;<input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onClick="gfPop.fPopCalendar(document.getElementById('tglAkhir'),depRange);"/><button type="button" onClick="kirim()"><img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; Lihat</button></td>
                </tr>
                <tr valign="bottom">
                    <td height="50" style="padding-left:45px;"><select id="cmbPost" name="cmbPost" class="txtinput" style="background-color:#FFFFCC; color:#990000;" onChange="change()">
                        <option value="0">BELUM POSTING</option>
                        <option value="1">SUDAH POSTING</option>
                    </select></td>
                    <td height="30" align="right" style="padding-right:45px;"><BUTTON type="button" style="display:none" id="btnPosting1" onClick="PostingJurnal(0)"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Posting >> Jurnal<br>Blm Terbayar</BUTTON>&nbsp;<BUTTON type="button" id="btnPosting" onClick="PostingJurnal(1)"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Posting >> Jurnal</BUTTON></td>
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
	var a1 = new DSGridObject("gridbox");
	a1.setHeader("DATA TRANSAKSI RETURN PBF");
	a1.setColHeader("NO,PBF,TGL RETURN,NO RETURN,TGL FAKTUR,NO FAKTUR,OBAT,QTY,HARGA,TOTAL,KETERANGAN,POSTING<BR><input type='checkbox' name='chkAll' id='chkAll' onClick='chkKlik(this.checked);'>&nbsp;&nbsp;&nbsp;&nbsp;");
	a1.setIDColHeader(",nama,,,,,,,,,,");
	a1.setColWidth("30,180,75,150,75,150,200,40,70,90,150,75");
	a1.setCellAlign("center,left,center,left,center,left,left,center,right,right,left,center");
	a1.setCellType("txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,chk");
	a1.setCellHeight(20);
	a1.setImgPath("../icon");
	a1.setIDPaging("paging");
	//a.attachEvent("onRowClick");
	a1.baseURL("../unit/returPBF_utils.php?grd=ReturnPBF&tglAwal="+document.getElementById('tglAwal').value+"&tglAkhir="+document.getElementById('tglAkhir').value);
	a1.Init();

	function konfirmasi(key,val){
		//alert(val+'-'+key);
		document.getElementById('chkAll').checked=false;
		if(key=='Error'){
			if(val=='postingReturnPBF'){
				alert('Terjadi Error dlm Proses Posting !');
			}
		}else{
			if(val=='postingReturnPBF'){
				alert('Proses Posting Berhasil !');
			}
		}
	}
	
	function goFilterAndSort(grd){
	var url;
		//alert(grd);
		if (grd=="gridbox"){		
			url="../unit/returPBF_utils.php?grd=ReturnPBF&tglAwal="+document.getElementById('tglAwal').value+"&tglAkhir="+document.getElementById('tglAkhir').value+"&posting="+document.getElementById('cmbPost').value+"&filter="+a1.getFilter()+"&sorting="+a1.getSorting()+"&page="+a1.getPage();
			//alert(url);
			a1.loadURL(url,"","GET");
		}
	}
	
	function chkKlik(p){
	var cekbox=(p==true)?1:0;
		//alert(p);
		for (var i=0;i<a1.getMaxRow();i++){
			a1.cellsSetValue(i+1,12,cekbox);
		}
	}
	
 	function kirim(){
	var url;
		url="../unit/returPBF_utils.php?grd=ReturnPBF&tglAwal="+document.getElementById('tglAwal').value+"&tglAkhir="+document.getElementById('tglAkhir').value+"&posting="+document.getElementById('cmbPost').value;
		//alert(url);
		a1.loadURL(url,"","GET");
	} 

	function PostingJurnal(p){
	var tmp='',tmp2='',idata='';
	var url;
		url="../unit/returPBF_utils.php?grd=ReturnPBF&tglAwal="+document.getElementById('tglAwal').value+"&tglAkhir="+document.getElementById('tglAkhir').value+"&posting="+document.getElementById('cmbPost').value+"&idUser=<?php echo $iduser; ?>";
		
		for (var i=0;i<a1.getMaxRow();i++){
			if (a1.obj.childNodes[0].childNodes[i].childNodes[11].childNodes[0].checked){
				//alert(a1.cellsGetValue(i+1,2));
				idata=a1.getRowId(i+1).split("|");
				tmp+=idata[0]+String.fromCharCode(5)+idata[1]+String.fromCharCode(5)+p+String.fromCharCode(5)+ValidasiText(a1.cellsGetValue(i+1,4))+String.fromCharCode(5)+ValidasiText(a1.cellsGetValue(i+1,10))+String.fromCharCode(5)+idata[2]+String.fromCharCode(5)+idata[3]+String.fromCharCode(6);
				tmp2+=idata[0]+"|"+idata[1]+"|"+p+"|"+ValidasiText(a1.cellsGetValue(i+1,4))+"|"+ValidasiText(a1.cellsGetValue(i+1,10))+"|"+idata[2]+"|"+idata[3];
			}
		}
		if (tmp!=""){
			tmp=tmp.substr(0,(tmp.length-1));
			//alert(tmp.length);
			if (tmp.length>1024){
				alert("Data Yg Mau diPosting Terlalu Banyak !");
			}else{
				url+="&act=postingReturnPBF&fdata="+tmp;
				//alert(url);
				//alert(tmp2);
				a1.loadURL(url,"","GET");
			}
		}else{
			alert("Pilih Data Yg Mau diPosting Terlebih Dahulu !");
		}
	}
	
	function ValidasiText(p){
	var tmp=p;
		while (tmp.indexOf('.')>0){
			tmp=tmp.replace('.','');
		}
		while (tmp.indexOf(',')>0){
			tmp=tmp.replace(',','.');
		}
		return tmp;
	}
	
	function change(){
		if(cmbPost.value==0){
			document.getElementById('btnPosting').disabled=false;
			//document.getElementById('btnPosting').innerHTML="<IMG SRC='../icon/save.gif' border='0' width='16' height='16' ALIGN='absmiddle'>&nbsp;Posting >> Jurnal<br>Sdh Terbayar";
			document.getElementById('btnPosting').innerHTML="<IMG SRC='../icon/save.gif' border='0' width='16' height='16' ALIGN='absmiddle'>&nbsp;Posting >> Jurnal";
			document.getElementById('btnPosting1').style.display='table-row';
		}else{
			document.getElementById('btnPosting').disabled=false;
			document.getElementById('btnPosting').innerHTML="<IMG SRC='../icon/hapus.gif' border='0' width='16' height='16' ALIGN='absmiddle'>&nbsp;Unposting";
			document.getElementById('btnPosting1').style.display='none';
		}
		kirim();
	}
</script>
</body>
</html>