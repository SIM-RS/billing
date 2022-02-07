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
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl);
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
                	<td>&nbsp;</td>
                </tr>
                <tr>
                    <td class="jdltable" height="29" colspan="2">KAS BANK</td>
                </tr>
                <tr>
                    <td width="400" style="padding-right:20px; text-align:right;" height="25">Bulan</td>
                    <td>:&nbsp;<select id="bln" name="bln" onChange="filter()" class="txtinputreg">
                                <option value="1" <?php echo $th[1]==1?'selected="selected"':'';?> >Januari</option>
                                <option value="2" <?php echo $th[1]==2?'selected="selected"':'';?> >Februari</option>
                                <option value="3" <?php echo $th[1]==3?'selected="selected"':'';?> >Maret</option>
                                <option value="4" <?php echo $th[1]==4?'selected="selected"':'';?> >April</option>
                                <option value="5" <?php echo $th[1]==5?'selected="selected"':'';?> >Mei</option>
                                <option value="6" <?php echo $th[1]==6?'selected="selected"':'';?> >Juni</option>
                                <option value="7" <?php echo $th[1]==7?'selected="selected"':'';?> >Juli</option>
                                <option value="8" <?php echo $th[1]==8?'selected="selected"':'';?> >Agustus</option>
                                <option value="9" <?php echo $th[1]==9?'selected="selected"':'';?> >September</option>
                                <option value="10" <?php echo $th[1]==10?'selected="selected"':'';?> >Oktober</option>
                                <option value="11" <?php echo $th[1]==11?'selected="selected"':'';?> >Nopember</option>
                                <option value="12" <?php echo $th[1]==12?'selected="selected"':'';?> >Desember</option>
                            </select>&nbsp;&nbsp;
                            <select id="thn" name="thn" onChange="filter()" class="txtinputreg">
                                <?php
                                for ($i=($th[2]-5);$i<($th[2]+1);$i++) {
                                    ?>
                                <option value="<?php echo $i; ?>" class="txtinput" <?php if ($i==$th[2]) echo "selected";?>><?php echo $i;?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <button type="button" onClick="kirim()"><img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; Lihat</button></td>
                </tr>
                <tr>
                    <td height="30" style="padding-left:45px;"><select id="cmbPost" name="cmbPost" class="txtinput" style="background-color:#FFFFCC; color:#990000;" onChange="change()">
                        <option value="0">BELUM POSTING</option>
                        <option value="1">SUDAH POSTING</option>
                    </select></td>
                    <td height="30" align="right" style="padding-right:45px;">
                    <BUTTON type="button" disabled="disabled" id="btnKwitansi" onClick="CetakKwitansi();" style="cursor:pointer;display:none;"><IMG SRC="../icon/contact-us.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Kwitansi Memorial</BUTTON>
                    <BUTTON type="button" id="btnPosting" onClick="PostingJurnal()"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Posting >> Jurnal</BUTTON></td>
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
	a1.setHeader("DATA KAS BANK");
	a1.setColHeader("NO,TGL TRANSAKSI,NO BUKTI,JENIS TRANSAKSI,NILAI,KETERANGAN,PILIH<BR><input type='checkbox' name='chkAll' id='chkAll' onClick='chkKlik(this.checked);'>&nbsp;&nbsp;&nbsp;&nbsp;");
	//a1.setIDColHeader(",nama,,");
	a1.setColWidth("40,50,70,200,70,150,30");
	a1.setCellAlign("center,center,center,left,center,left,center");
	
	
	
	a1.setCellType("txt,txt,txt,txt,txt,txt,chk");
	a1.setCellHeight(20);
	a1.setImgPath("../icon");
	a1.setIDPaging("paging");
	a1.onLoaded(konfirmasi);
	//a.attachEvent("onRowClick");
	//alert("../unit/utils.php?grd=ReturnPelayanan&kso="+document.getElementById('cmbKso').value+"&tanggal="+document.getElementById('tgl').value+"&tempat="+document.getElementById('cmbTmp').value);
	a1.baseURL("kas_bank_utils.php?bln="+document.getElementById('bln').value+"&thn="+document.getElementById('thn').value+"&posting="+document.getElementById('cmbPost').value);
	a1.Init();

	function konfirmasi(key,val){
		//alert(val);
		document.getElementById('chkAll').checked=false;
		if(key=='Error'){
			if(val=='postingKasBank'){
				alert('Terjadi Error dlm Proses Posting !');
			}
		}else{
			if(val=='postingKasBank'){
				alert('Proses Posting Berhasil !');
			}
			else if(val=='Unposting'){
				alert('Proses Unposting Berhasil !');
			}
		}
		
		if (a1.getMaxRow()>0 && document.getElementById('cmbPost').value==1){
			document.getElementById('btnKwitansi').disabled=false;
		}else{
			document.getElementById('btnKwitansi').disabled=true;
		}
	}
	
	function goFilterAndSort(grd){
	var url;
		//alert(grd);
		if (grd=="gridbox"){		
			url="kas_bank_utils.php?bln="+document.getElementById('bln').value+"&thn="+document.getElementById('thn').value+"&posting="+document.getElementById('cmbPost').value+"&filter="+a1.getFilter()+"&sorting="+a1.getSorting()+"&page="+a1.getPage();
			//alert(url);
			a1.loadURL(url,"","GET");
		}
	}
	
	function chkKlik(p){
	var cekbox=(p==true)?1:0;
		//alert(p);
		for (var i=0;i<a1.getMaxRow();i++){
			a1.cellsSetValue(i+1,7,cekbox);
		}
	}
	
	function kirim(){
	var url;
		url="kas_bank_utils.php?bln="+document.getElementById('bln').value+"&thn="+document.getElementById('thn').value+"&posting="+document.getElementById('cmbPost').value;
		//alert(url);
		a1.loadURL(url,"","GET");
	}
	
	function PostingJurnal(){
	var tmp='',idata='';
	var tmp2='';
	var url;
		url="kas_bank_utils.php?bln="+document.getElementById('bln').value+"&thn="+document.getElementById('thn').value+"&posting="+document.getElementById('cmbPost').value+"&idUser=<?php echo $iduser; ?>";
		
		for (var i=0;i<a1.getMaxRow();i++){
			if (a1.obj.childNodes[0].childNodes[i].childNodes[6].childNodes[0].checked){
				//alert(a1.cellsGetValue(i+1,2));
				idata=a1.getRowId(i+1).split("|");
				tmp+=idata[0]+String.fromCharCode(5)+idata[1]+String.fromCharCode(5)+idata[2]+String.fromCharCode(5)+idata[3]+String.fromCharCode(5)+idata[4]+String.fromCharCode(5)+idata[5]+String.fromCharCode(6);
				tmp2+=idata[0]+"|"+idata[1]+"|"+idata[2]+"|"+idata[3]+"|"+idata[4]+"|"+idata[5];
			}
		}
		if (tmp!=""){
			tmp=tmp.substr(0,(tmp.length-1));
			//alert(tmp.length);
			if (tmp.length>1024){
				alert("Data Yg Mau diPosting Terlalu Banyak !");
			}else{
				url+="&act=postingKasBank&fdata="+tmp;
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
			document.getElementById('btnPosting').innerHTML="<IMG SRC='../icon/save.gif' border='0' width='16' height='16' ALIGN='absmiddle'>&nbsp;Posting >> Jurnal";
		}else{
			document.getElementById('btnPosting').disabled=false;
			document.getElementById('btnPosting').innerHTML="<IMG SRC='../icon/hapus.gif' border='0' width='16' height='16' ALIGN='absmiddle'>&nbsp;Unposting";
		}
		kirim();
	}
	
	function CetakKwitansi()
	{
		//alert(a1.getRowId(a1.getSelRow()));
		var sisip = a1.getRowId(a1.getSelRow()).split("|");
		var no_bukti = sisip[3];
		var tgl1 = sisip[5].split("-");
		var tgl = tgl1[2]+'-'+tgl1[1]+'-'+tgl1[0];
		if(tgl=='')
		{
			alert('Pilih baris yang akan dicetak');
		}
		else
		{
			window.open('../kwitansi/bukti.php?kw='+no_bukti+'&tipe=5&tgl='+tgl);
			clear();
		}
	}
</script>
</body>
</html>