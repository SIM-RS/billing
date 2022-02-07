<?php 
session_start();
include("../koneksi/konek.php");

$username = $_SESSION['akun_username'];
$password = $_SESSION['akun_password'];
$idunit = $_SESSION['akun_ses_idunit'];
$iduser = $_SESSION['akun_iduser'];
$kategori = $_SESSION['akun_kategori'];

$hdrFrm="Transaksi Pembelian Obat";
$tipe = $_REQUEST["tipe"];
if ($tipe==2) $hdrFrm="Transaksi Penerimaan Hibah Obat";

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
document.getElementById("logout").innerHTML='<a class="a1" href="../index.php">Logout</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
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
                    <td class="jdltable" height="29" colspan="2"><?php echo $hdrFrm; ?></td>
                </tr>
                <!--tr>
                    <td style="padding-right:20px; text-align:right;" width="40%" height="25">Nama KSO</td>
                    <td width="60%">:&nbsp;<select id="cmbKso" name="cmbKso" class="txtinput" onChange="kirim()">
                        <!--?php
                            $qkso = mysql_query("SELECT billing.b_ms_kso.id, billing.b_ms_kso.nama FROM billing.b_ms_kso");
                            $flag=0;
                            while($wKso = mysql_fetch_array($qkso)){
                                $flag++;
                                if($kso=="" && $flag==1) $kso=$wKso['id'];
                        ?>
                        <option style="text-transform:uppercase" value="<!?php echo $wKso['id'];?>" <!?php if($kso==$wKso['id']){ echo "selected"; $nKso=$wKso['nama'];} ?>><!?php echo $wKso['nama'];?></option>
                        <!?php
                            }
                        ?>
                    </select></td>
                </tr-->
                <!--tr>
                    <td style="padding-right:20px; text-align:right;" height="25">Tempat Layanan</td>
                    <td>:&nbsp;<select id="cmbTmp" name="cmbTmp" class="txtinput" onchange="kirim()">
                        <option value="0">SEMUA</option>
                        <!?php
                            $qTmp = mysql_query("SELECT billing.b_ms_unit.id, billing.b_ms_unit.nama FROM billing.b_ms_unit WHERE billing.b_ms_unit.level=1 AND billing.b_ms_unit.kategori=2");
                            while($wTmp = mysql_fetch_array($qTmp)){
                        ?>
                        <option value="<!?php echo $wTmp['id'];?>" <!?php if($tempat==$wTmp['id']){ echo "selected";}?>><!?php echo $wTmp['nama'];?></option>
                        <!?php	}	?>
                    </select></td>
                </tr-->
                <tr>
                    <td style="padding-right:20px; text-align:right;" height="25" width="35%">Tanggal</td>
                    <td width="65%" style="font-weight:bold;">:&nbsp;<input id="tglAwal" name="tglAwal" readonly size="11" class="txtcenter" type="text" value="<?php echo $tglAwal; ?>" />&nbsp;<input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onClick="gfPop.fPopCalendar(document.getElementById('tglAwal'),depRange);"/> s.d. <input id="tglAkhir" name="tglAkhir" readonly size="11" class="txtcenter" type="text" value="<?php echo $tglAkhir; ?>" />&nbsp;<input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onClick="gfPop.fPopCalendar(document.getElementById('tglAkhir'),depRange);"/><button type="button" onClick="kirim()"><img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; Lihat</button></td>
                </tr>
                <tr>
                    <td height="30" style="padding-left:5px;"><select id="cmbPost" name="cmbPost" class="txtinput" style="background-color:#FFFFCC; color:#990000;" onChange="changePost(this.value);kirim()">
                        <option value="0">BELUM POSTING</option>
                        <option value="1">SUDAH POSTING</option>
                    </select></td>
                    <td height="30" align="right" style="padding-right:5px;"><BUTTON id="btnPost" type="button" onClick="PostingJurnal()"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Posting >> Jurnal</BUTTON></td>
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
</div>
<script>
 	function kirim(){
	var url;
		url="../unit/utils.php?grd=pembelianObat&tipe=<?php echo $tipe; ?>&tglAwal="+document.getElementById('tglAwal').value+"&tglAkhir="+document.getElementById('tglAkhir').value+"&posting="+document.getElementById('cmbPost').value;
		//alert(url);
		aGrid.loadURL(url,"","GET");
	} 
	
	function changePost(p){
		if (p==1){
			document.getElementById('btnPost').disabled=true;
		}else{
			document.getElementById('btnPost').disabled=false;
		}
	}
	
	function chkKlik(p){
	var cekbox=(p==true)?1:0;
		//alert(p);
		for (var i=0;i<aGrid.getMaxRow();i++){
			aGrid.cellsSetValue(i+1,9,cekbox);
		}
	}
	
	function PostingJurnal(){
	var tmp='';
	var url;
		url="../unit/utils.php?grd=pembelianObat&tipe=<?php echo $tipe; ?>&tglAwal="+document.getElementById('tglAwal').value+"&tglAkhir="+document.getElementById('tglAkhir').value+"&posting="+document.getElementById('cmbPost').value+"&idUser=<?php echo $iduser; ?>";
		
		for (var i=0;i<aGrid.getMaxRow();i++){
			if (aGrid.obj.childNodes[0].childNodes[i].childNodes[9].childNodes[0].checked){
				//alert(aGrid.cellsGetValue(i+1,3));
				tmp+=aGrid.getRowId(i+1)+String.fromCharCode(6);				
			}
		}
		//alert(tmp);
		if (tmp!=""){
			tmp=tmp.substr(0,(tmp.length-1));
			//alert(tmp.length);
			url+="&act=postingBeliObat&fdata="+tmp;
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

	function konfirmasi(key,val){
	var tmp;
		//alert(val+'-'+key);
		if (val!=undefined){
			tmp=val.split(String.fromCharCode(3));
			aGrid.cellSubTotalSetValue(7,tmp[1]);
			aGrid.cellSubTotalSetValue(8,tmp[2]);
			aGrid.cellSubTotalSetValue(9,tmp[3]);
			if(key=='Error'){
				if(tmp[0]=='postingBeliObat'){
					alert('Terjadi Error dlm Proses Posting !');
				}
			}else{
				if(tmp[0]=='postingBeliObat'){
					alert('Proses Posting Berhasil !');
				}
			}
		}
	}
	
	function goFilterAndSort(grd){
	var url;
		//alert(grd);
		if (grd=="gridbox"){		
			url="../unit/utils.php?grd=pembelianObat&tipe=<?php echo $tipe; ?>&tglAwal="+document.getElementById('tglAwal').value+"&tglAkhir="+document.getElementById('tglAkhir').value+"&posting="+document.getElementById('cmbPost').value+"&filter="+aGrid.getFilter()+"&sorting="+aGrid.getSorting()+"&page="+aGrid.getPage();
			//alert(url);
			aGrid.loadURL(url,"","GET");
		}
	}
	
	var aGrid = new DSGridObject("gridbox");
	aGrid.setHeader("DATA TRANSAKSI PEMBELIAN OBAT");
	aGrid.setColHeader("NO,TANGGAL,NO GUDANG,NO FAKTUR,NO SPK,PBF,DPP,PPN,DPP + PPN,POSTING<BR><input type='checkbox' name='chkAll' id='chkAll' onClick='chkKlik(this.checked);'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
	aGrid.setSubTotal(",,,,,SubTotal :&nbsp;&nbsp;&nbsp;,0,0,0,");
	aGrid.setIDColHeader(",tgl1,noterima,no_faktur,no_spk,pbf_nama,,,,");
	aGrid.setColWidth("30,75,140,130,150,200,100,100,100,75");
	aGrid.setCellAlign("center,center,center,center,center,left,right,right,right,center");
	aGrid.setSubTotalAlign("center,center,center,center,center,right,right,right,right,center");
	aGrid.setCellType("txt,txt,txt,txt,txt,txt,txt,txt,txt,chk");
	aGrid.setCellHeight(20);
	aGrid.setImgPath("../icon");
	aGrid.setIDPaging("paging");
	aGrid.onLoaded(konfirmasi);
	//a.attachEvent("onRowClick");
	//alert("../unit/utils.php?grd=pembelianObat&tglAwal="+document.getElementById('tglAwal').value+"&tglAkhir="+document.getElementById('tglAkhir').value);
	aGrid.baseURL("../unit/utils.php?grd=pembelianObat&tipe=<?php echo $tipe; ?>&tglAwal="+document.getElementById('tglAwal').value+"&tglAkhir="+document.getElementById('tglAkhir').value);
	aGrid.Init();
</script>
</body>
</html>