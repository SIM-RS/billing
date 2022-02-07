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

$styleTrSupplier='style="display:table-row"';
$jdl="Transaksi Pembayaran Hutang Supplier";
$tipe=$_REQUEST['tipe'];
if ($tipe==2){
	$jdl="Transaksi Pengeluaran Lain-Lain";
	$styleTrSupplier='style="display:none"';
}

if($_REQUEST['tglAwal']=="" || $_REQUEST['tglAkhir']==""){
	$tglAwal = "01-".substr($tgl,3,7);
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
<link rel="stylesheet" type="text/css" href="../theme/popup.css" />
<script type="text/javascript" src="../theme/prototype.js"></script>
<script type="text/javascript" src="../theme/effects.js"></script>
<script type="text/javascript" src="../theme/popup.js"></script>
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
		<td class="bodykiri"><?php include("menua.php");?></td>
	</tr>
<tr align="center" valign="top">
	<td align="left" height="430">
        <div align="center">
            <table width="980" border="0" cellpadding="0" cellspacing="0" class="txtinput">
                <tr>
                    <td class="jdltable" height="29" colspan="2"><?php echo $jdl; ?></td>
                </tr>
                <tr <?php echo $styleTrSupplier; ?>>
                    <td style="padding-right:20px; text-align:right;" height="25">Jenis Supplier</td>
                    <td>:&nbsp;<select id="cmbSupplier" name="cmbSupplier" class="txtinput" onChange="kirim()">
                        <option value="1">OBAT</option>
                        <option value="2">BARANG UMUM/HP</option>
                    </select></td>
                </tr>
                <tr>
                    <td style="padding-right:20px; text-align:right;" height="25" width="35%">Tanggal</td>
                    <td width="65%" style="font-weight:bold;">:&nbsp;<input id="tglAwal" name="tglAwal" readonly size="11" class="txtcenter" type="text" value="<?php echo $tglAwal; ?>" />&nbsp;<input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onClick="gfPop.fPopCalendar(document.getElementById('tglAwal'),depRange);"/> s.d. <input id="tglAkhir" name="tglAkhir" readonly size="11" class="txtcenter" type="text" value="<?php echo $tglAkhir; ?>" />&nbsp;<input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onClick="gfPop.fPopCalendar(document.getElementById('tglAkhir'),depRange);"/>&nbsp;&nbsp;&nbsp;<button type="button" onClick="kirim()"><img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; Lihat</button></td>
                </tr>
                <tr>
                    <td height="30" style="padding-left:5px;"><select id="cmbPost" name="cmbPost" class="txtinput" style="background-color:#FFFFCC; color:#990000;" onChange="changePost(this.value);kirim()">
                        <option value="0">BELUM VERIFIKASI</option>
                        <option value="1">SUDAH VERIFIKASI</option>
                        <option value="2">SUDAH BAYAR/POSTING</option>
                    </select></td>
                    <td height="30" align="right" style="padding-right:5px;">
                    <BUTTON type="button" disabled="disabled" id="btnKwitansi" onClick="CetakKwitansi();" style="cursor:pointer"><IMG SRC="../icon/contact-us.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Kwitansi BKK/BBK</BUTTON>
                    <BUTTON id="btnPost" type="button" onClick="Verifikasi()"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Verifikasi</BUTTON></td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <div id="gridbox" style="width:980px; height:300px; background-color:white; overflow:hidden;"></div>
                        <div id="paging" style="width:980px;"></div>
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
<div id="popLayanan" style="display:none; width:1000px" class="popup" align="center">
    <table width="409" align="center" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
        <td class="font">
            <div id="gd" align="center" style="width:1000px; height:500px; overflow:hidden; background-color:white;"></div>        </td>
    </tr>
    <tr>
        <td height="50" valign="bottom" align="center"><button type="button" id="batal" name="batal" class="popup_closebox" style="cursor:pointer">&nbsp;&nbsp;OK&nbsp;&nbsp;</button></td>
    </tr>
    </table>
</div>
</div>
<script>
 	function kirim(){
	var url;
		url="../unit/pengeluaranLain_utils.php?grd=pengeluaranLain&tipe=<?php echo $tipe ?>&cmbSupplier="+document.getElementById('cmbSupplier').value+"&tglAwal="+document.getElementById('tglAwal').value+"&tglAkhir="+document.getElementById('tglAkhir').value+"&posting="+document.getElementById('cmbPost').value;
		//alert(url);
		aGrid.loadURL(url,"","GET");
	}
	
	function changePost(p){
		if (p==0){
			document.getElementById('btnPost').disabled=false;
			document.getElementById('btnPost').innerHTML="<IMG SRC='../icon/save.gif' border='0' width='16' height='16' ALIGN='absmiddle'>&nbsp;Verifikasi";
		}
		else if(p==1){
			document.getElementById('btnPost').disabled=false;
			document.getElementById('btnPost').innerHTML="<IMG SRC='../icon/save.gif' border='0' width='16' height='16' ALIGN='absmiddle'>&nbsp;Unverifikasi";
		}
		else{
			document.getElementById('btnPost').disabled=false;
			document.getElementById('btnPost').innerHTML="<IMG SRC='../icon/hapus.gif' border='0' width='16' height='16' ALIGN='absmiddle'>&nbsp;Unposting";
		}
	}
	
	function chkKlik(p){
	var cekbox=(p==true)?1:0;
		//alert(p);
		for (var i=0;i<aGrid.getMaxRow();i++){
			aGrid.cellsSetValue(i+1,7,cekbox);
		}
	}
	
	function Verifikasi(){
	var tmp='',cid='';
	var url;
		url="../unit/pengeluaranLain_utils.php?grd=pengeluaranLain&tipe=<?php echo $tipe ?>&cmbSupplier="+document.getElementById('cmbSupplier').value+"&tglAwal="+document.getElementById('tglAwal').value+"&tglAkhir="+document.getElementById('tglAkhir').value+"&posting="+document.getElementById('cmbPost').value+"&idUser=<?php echo $iduser; ?>";
		
		for (var i=0;i<aGrid.getMaxRow();i++){
			if (aGrid.obj.childNodes[0].childNodes[i].childNodes[6].childNodes[0].checked){
				//alert(aGrid.cellsGetValue(i+1,3));
				cid=aGrid.getRowId(i+1).split('|');
				tmp+=cid[0]+String.fromCharCode(6);
			}
		}
		//alert(tmp);
		if (tmp!=""){
			tmp=tmp.substr(0,(tmp.length-1));
			//alert(tmp.length);
			url+="&act=VerifikasiPengeluaranLain&fdata="+tmp;
			//alert(url);
			aGrid.loadURL(url,"","GET");
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
	
	function CetakKwitansi()
	{
		var sisip = aGrid.getRowId(aGrid.getSelRow()).split("|");
		var no_bukti = sisip[4];
		var tgl1 = sisip[5].split("-");
		var tgl = tgl1[2]+'-'+tgl1[1]+'-'+tgl1[0];
		if(tgl=='')
		{
			alert('Pilih baris yang akan dicetak');
		}
		else
		{
			window.open('../kwitansi/bukti.php?kw='+no_bukti+'&tipe=4&tgl='+tgl);
			clear();
		}
	}

	function konfirmasi(key,val){
	var tmp;
		//alert(val+'-'+key);
		if (val!=undefined){
			tmp=val.split(String.fromCharCode(3));
			aGrid.cellSubTotalSetValue(5,tmp[1]);
			//aGrid.cellSubTotalSetValue(8,tmp[2]);
			//aGrid.cellSubTotalSetValue(9,tmp[3]);
			if(key=='Error'){
				if(tmp[0]=='VerifikasiPengeluaranLain'){
					alert('Terjadi Error dlm Proses Verifikasi !');
				}
			}else{
				if(tmp[0]=='VerifikasiPengeluaranLain'){
					alert('Proses Verifikasi Berhasil !');
				}
			}
		}
		document.getElementById('chkAll').checked=false;
		
		if (aGrid.getMaxRow()>0 && document.getElementById('cmbPost').value==2){
			document.getElementById('btnKwitansi').disabled=false;
		}else{
			document.getElementById('btnKwitansi').disabled=true;
		}
	}
	
	function goFilterAndSort(grd){
	var url;
		//alert(grd);
		if (grd=="gridbox"){
			url="../unit/pengeluaranLain_utils.php?grd=pengeluaranLain&tipe=<?php echo $tipe ?>&cmbSupplier="+document.getElementById('cmbSupplier').value+"&tglAwal="+document.getElementById('tglAwal').value+"&tglAkhir="+document.getElementById('tglAkhir').value+"&posting="+document.getElementById('cmbPost').value+"&filter="+aGrid.getFilter()+"&sorting="+aGrid.getSorting()+"&page="+aGrid.getPage();
			//alert(url);
			aGrid.loadURL(url,"","GET");
		}
	}
	
	var aGrid = new DSGridObject("gridbox");
	var tabelHeader="DATA TRANSAKSI PEMBAYARAN HUTANG SUPPLIER";
	<?php 
		if ($tipe==1){
	?>
	aGrid.setHeader("DATA TRANSAKSI PEMBAYARAN HUTANG SUPPLIER");
	<?php
		}else{
	?>
	aGrid.setHeader("DATA TRANSAKSI PENGELUARAN LAIN-LAIN");
	<?php
		}
	?>
	aGrid.setColHeader("NO,TANGGAL,NO BUKTI,JENIS TRANSAKSI,NILAI,KETERANGAN,VERIFIKASI<BR><input type='checkbox' name='chkAll' id='chkAll' onClick='chkKlik(this.checked);'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
	aGrid.setSubTotal(",,,SubTotal :&nbsp;&nbsp;&nbsp;,0,,");
	aGrid.setIDColHeader(",tgl1,no_bukti,nama_trans,,ket,");
	aGrid.setColWidth("30,75,150,200,120,280,75");
	aGrid.setCellAlign("center,center,center,left,right,left,center");
	aGrid.setSubTotalAlign("center,center,center,right,right,left,center");
	aGrid.setCellType("txt,txt,txt,txt,txt,txt,chk");
	aGrid.setCellHeight(20);
	aGrid.setImgPath("../icon");
	aGrid.setIDPaging("paging");
	aGrid.onLoaded(konfirmasi);
	aGrid.attachEvent("onRowClick","grid_act");
	aGrid.attachEvent("onRowDblClick","popup1");
	//alert("../unit/pengeluaranLain_utils.php?grd=pembelianObat&tglAwal="+document.getElementById('tglAwal').value+"&tglAkhir="+document.getElementById('tglAkhir').value);
	aGrid.baseURL("../unit/pengeluaranLain_utils.php?grd=pengeluaranLain&tipe=<?php echo $tipe ?>&cmbSupplier="+document.getElementById('cmbSupplier').value+"&posting="+document.getElementById('cmbPost').value+"&tglAwal="+document.getElementById('tglAwal').value+"&tglAkhir="+document.getElementById('tglAkhir').value);
	aGrid.Init();
	
	//****************************************************
	gb=new DSGridObject("gd");
	gb.setHeader("INPUT NILAI");
	gb.setColHeader("NO,JENIS LAYANAN,KODE,TEMPAT LAYANAN,NILAI");
	gb.setSubTotal(",,,SubTotal :&nbsp;,0");
	gb.setSubTotalAlign("center,center,center,right,right");
	gb.setIDColHeader(",tbl.parent,tbl.kode,tbl.nama,");
	gb.setColWidth("30,150,70,200,100");
	gb.setCellAlign("center,left,left,left,center");
	gb.setCellType("txt,txt,txt,txt,txt");
	gb.setCellHeight(20);
	gb.setImgPath("../icon");
	//gb.onLoaded(grid_loaded);
	//gb.attachEvent("onRowClick","grid_act");
	gb.baseURL("ngutils.php");
	gb.Init();
    
	function grid_act(){
		var sisip = aGrid.getRowId(aGrid.getSelRow()).split('|');
		if (sisip[2]!=""){
			//alert(sisip[2]);
			for(var i=1;i<=gb.getMaxRow();i++){
				var id = gb.getRowId(i);
				document.getElementById('nilai_'+id).value='';
			}
			
			var temp = sisip[2].split('#');
			for(var i=1;i<=temp.size()-1;i++){
				var data = temp[i].split('*');
				document.getElementById('nilai_'+data[0]).value = data[1];
				//mukti
			}
			gb.cellSubTotalSetValue(5,sisip[3]);
		}
	}
	
	function popup1(){
		var sisip = aGrid.getRowId(aGrid.getSelRow()).split('|');
		//alert(sisip[2]);
		if (sisip[2]!=""){
			new Popup('popLayanan',null,{modal:true,position:'center',duration:1});
			document.getElementById('popLayanan').popup.show();
			//document.getElementById('nilai_1').focus();
		}
	}
	
	function AutoRefresh(){
		goFilterAndSort("gridbox");
		setTimeout("AutoRefresh()", 180000);
	}
	
	setTimeout("AutoRefresh()", 180000);
</script>
</body>
</html>