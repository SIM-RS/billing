<?php 
session_start();
include("../koneksi/konek.php");

$username = $_SESSION['username'];
$password = $_SESSION['password'];
$idunit = $_SESSION['ses_idunit'];
$iduser = $_SESSION['iduser'];
$kategori = $_SESSION['kategori'];


$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$kso=$_REQUEST['kso'];
$tempat=$_REQUEST['tempat'];
if($_REQUEST['tanggals']==""){
	$tanggals = $tgl;
}else{
	$tanggals = $_REQUEST['tanggals'];
}
if($_REQUEST['tanggald']==""){
	$tanggal = $tgl;
}else{
	$tanggald = $_REQUEST['tanggald'];
}
$tang = explode('-',$tanggals);
$tanggalans = $tang[2].'-'.$tang[1].'-'.$tang[0];

$tangd = explode('-',$tanggald);
$tanggaland = $tangd[2].'-'.$tangd[1].'-'.$tangd[0];
$waktu = "t.tgl between '$tanggalans 00:00:00' AND '$tanggaland 23:59:59'";

$wktnow=gmdate('H:i:s',mktime(date('H')+7));
$wkttgl=gmdate('d/m/Y',mktime(date('H')+7));
$url=split("/",$_SERVER['REQUEST_URI']);
$imgpath="/".$url[1]."/images";
$iunit=$_SESSION['username'];
?>
<html>
<head>
	<title>Sistem Informasi Akuntansi</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link rel="stylesheet" href="../theme/simkeu1.css" type="text/css" />
	<!--link type="text/css" rel="stylesheet" href="../theme/mod.css" />
	<link type="text/css" href="../menu.css" rel="stylesheet" />
	<script type="text/JavaScript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
	<script type="text/javascript" language="JavaScript" src="../theme/js/ajax.js"></script>
	<script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
	<!--script src="../theme/js/noklik.js" type="text/javascript"></script->
	<script type="text/javascript" src="../jquery.js"></script>
	<script type="text/javascript" src="../menu.js"></script>
	<link rel="stylesheet" type="text/css" href="../theme/popup.css" />
	<script type="text/javascript" src="../theme/prototype.js"></script>
	<script type="text/javascript" src="../theme/effects.js"></script>
	<script type="text/javascript" src="../theme/popup.js"></script-->

		<link type="text/css" rel="stylesheet" href="../theme/mod.css" />
        <link type="text/css" href="../menu.css" rel="stylesheet" />
        <script type="text/javascript" src="../jquery.js"></script>
        <script type="text/javascript" src="../menu.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/ajax.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <link rel="stylesheet" type="text/css" href="../theme/popup.css" />
        <script type="text/javascript" src="../theme/prototype.js"></script>
        <script type="text/javascript" src="../theme/effects.js"></script>
        <script type="text/javascript" src="../theme/popup.js"></script>
</head>
<body>
<style type="text/css">
<!--
.style1 {font-family: Verdana, Arial, Helvetica, sans-serif}
-->
</style>
<script>
	var arrRange=depRange=[];
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
		id="gToday:normal:agenda.js" src="../theme/popcjs.php" scrolling="no" frameborder="1"
		style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
</iframe>
<iframe height="72" width="130" name="sort"
		id="sort"
		src="../theme/dsgrid_sort.php" scrolling="no"
		frameborder="0"
		style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div align="center">
<?php
include("../header.php");
?>
<table width="1000" border="0" cellspacing="0" cellpadding="0" class="tblbody">
	<tr align="center" valign="top">
		<td>&nbsp;</td>
	</tr>
<tr align="center" valign="top">
	<td align="left" height="430">
        <div align="center">
            <table width="980" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="jdltable" height="29" colspan="2">Transaksi Return Penjualan Obat</td>
                </tr>
				<tr>
					<td style="padding-right:20px; text-align:right;" width="40%" height="25">Unit Farmasi</td>
                    <td width="60%">:&nbsp;
						<select id="cmbFar" name="cmbFar" class="txtinput" onChange="kirim()">
							<option value="0">SEMUA</option>
                        <?php
							$sFar = "SELECT *
												FROM {$dbapotek}.a_unit u
												WHERE u.UNIT_TIPE = 2
												  AND u.UNIT_ISAKTIF = 1";
                            $qFar = mysql_query($sFar);
							//$flag=0;
                            while($wFar = mysql_fetch_array($qFar)){
                        ?>
							<option style="text-transform:uppercase" value="<?php echo $wFar['UNIT_ID'];?>"><?php echo $wFar['UNIT_NAME'];?></option>
                        <?php
                            }
                        ?>
						</select>
					</td>
				</tr>
                <tr>
                    <td style="padding-right:20px; text-align:right;" width="40%" height="25">Status Px</td>
                    <td width="60%">:&nbsp;
						<select id="cmbKso" name="cmbKso" class="txtinput" onChange="kirim()" style="width:210px;">
							<option value="0">SEMUA</option>
                        <?php
							$skso = "SELECT * FROM {$dbapotek}.a_mitra m WHERE m.AKTIF = 1 order by m.IDMITRA ASC";
                            $qkso = mysql_query($skso);
                            while($wKso = mysql_fetch_array($qkso)){
                        ?>
							<option style="text-transform:uppercase" value="<?php echo $wKso['IDMITRA'];?>"><?php echo $wKso['NAMA'];?></option>
                        <?php
                            }
                        ?>
						</select>
					</td>
                </tr>
                <tr>
                    <td style="padding-right:20px; text-align:right;" height="25">Tempat Layanan</td>
                    <td>:&nbsp;
						<select id="cmbTmp" name="cmbTmp" class="txtinput" onChange="kirim()">
							<option value="0">SEMUA</option>
                        <?php
							$sTmp = "SELECT * FROM {$dbapotek}.a_unit u WHERE u.UNIT_TIPE = 3 AND u.unit_billing <> 0";
                            $qTmp = mysql_query($sTmp);
                            while($wTmp = mysql_fetch_array($qTmp)){
                        ?>
							<option value="<?php echo $wTmp['UNIT_ID'];?>"><?php echo $wTmp['UNIT_NAME'];?></option>
                        <?php	}	?>
						</select>
					</td>
                </tr>
                <tr>
                    <td style="padding-right:20px; text-align:right;" height="25">Periode</td>
                    <td>:&nbsp;
						<input id="tgls" name="tgls" readonly size="11" class="txtcenter" type="text" value="<?php echo $tanggal; ?>" />&nbsp;<input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onClick="gfPop.fPopCalendar(document.getElementById('tgls'),depRange,kirim);"/>
						&nbsp;s/d&nbsp;
						<input id="tgld" name="tgld" readonly size="11" class="txtcenter" type="text" value="<?php echo $tanggal; ?>" />&nbsp;<input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onClick="gfPop.fPopCalendar(document.getElementById('tgld'),depRange,kirim);"/>
					</td>
                </tr>
                <!--tr>
                    <td height="30" style="padding-left:45px;"><select id="cmbPost" name="cmbPost" class="txtinput" style="background-color:#FFFFCC; color:#990000;" onChange="if(this.value==0){document.getElementById('btnPosting').disabled=false;}else{document.getElementById('btnPosting').disabled=true;};kirim()">
                        <option value="0">BELUM BAYAR</option>
                        <option value="1">SUDAH BAYAR</option>
                    </select></td>
                    <td height="30" align="right" style="padding-right:45px;"><BUTTON type="button" id="btnPosting" onClick="PostingJurnal()"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Bayar</BUTTON></td>
                </tr-->
				<tr>
					<td align='left'>
						<select id="cmbPost" name="cmbPost" class="txtinput" style="background-color:#FFFFCC; color:#990000;" onChange="if(this.value==0){document.getElementById('btnPosting').disabled=false;}else{document.getElementById('btnPosting').disabled=true;};kirim()">
							<option value="0">BELUM BAYAR</option>
							<option value="1">SUDAH BAYAR</option>
						</select>
					</td>
					<td align="right"><BUTTON type="button" id="btnPosting" onClick="PostingJurnal()"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Bayar</BUTTON></td>
				</tr>
                <tr>
                    <td colspan="2" align="center">
                        <div id="gridbox" style="width:100%; height:300px; background-color:white; overflow:hidden;"></div>
                        <div id="paging" style="width:100%;"></div>
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
<?php include("../laporan/report_form.php");?>
<script>
	var a1 = new DSGridObject("gridbox");
	a1.setHeader("DATA RETURN PENJUALAN OBAT");
	a1.setColHeader("NO,NO RETUR,TGL RETUR,NORM,NAMA PASIEN,NILAI RETURN,BAYAR<BR><input type='checkbox' name='chkAll' id='chkAll' onClick='chkKlik(this.checked);'>,UNIT FARMASI,TEMPAT LAYANAN,STATUS PX");
	a1.setIDColHeader(",no_retur,,NO_PASIEN,NAMA_PASIEN,,,farmasi,ruangan,statuspx");
	a1.setCellType("txt,txt,txt,txt,txt,txt,chk,txt,txt,txt,txt");
	a1.setSubTotal(",,,,SubTotal :&nbsp;,0,,,,");
	a1.setSubTotalAlign("center,center,center,center,right,right,right,right,right,right");
	a1.setColWidth("20,60,80,60,150,100,40,100,100,100");	
	a1.setCellAlign("center,center,center,center,left,right,center,center,center,center");
	a1.setCellHeight(20);
	a1.setImgPath("../icon");
	a1.setIDPaging("paging");
	a1.onLoaded(konfirmasi);
	a1.attachEvent("onRowClick","fHitungSubTotal");
	a1.baseURL("returnObat_util.php?kso="+document.getElementById('cmbKso').value+"&tanggals="+document.getElementById('tgls').value+"&tanggald="+document.getElementById('tgld').value+"&tempat="+document.getElementById('cmbTmp').value+"&farmasi="+document.getElementById('cmbFar').value+"&posting="+document.getElementById('cmbPost').value);
	a1.Init();
	
	function fHitungSubTotal(){
		var sTotal=0;
		var sisip;
		for (var i=0;i<a1.getMaxRow();i++){
			if (a1.obj.childNodes[0].childNodes[i].childNodes[6].childNodes[0].checked){
				sisip=a1.getRowId(i+1).split("|");
				sTotal +=sisip[2]*1;
			}
		}
		a1.cellSubTotalSetValue(6,FormatNumberFloor(sTotal,"."));
	}

	function konfirmasi(key,val){
		//alert(val+'-'+key);
		document.getElementById('chkAll').checked=false;
		if(key=='Error'){
			if(val=='postingReturnJual'){
				alert('Terjadi Error dlm Proses Posting !');
			}
		}else{
			if(val=='postingReturnJual'){
				alert('Proses Posting Berhasil !');
			}
		}
	}
	
	function goFilterAndSort(grd){
	var url;
		//alert(grd);
		if (grd=="gridbox"){					//url="../unit/utils.php?grd=ReturnJualObat&kso="+document.getElementById('cmbKso').value+"&tanggal="+document.getElementById('tgl').value+"&tempat="+document.getElementById('cmbTmp').value+"&posting="+document.getElementById('cmbPost').value+"&filter="+a1.getFilter()+"&sorting="+a1.getSorting()+"&page="+a1.getPage();
			//alert(url);
			url="returnObat_util.php?kso="+document.getElementById('cmbKso').value+"&tanggals="+document.getElementById('tgls').value+"&tanggald="+document.getElementById('tgld').value+"&tempat="+document.getElementById('cmbTmp').value+"&farmasi="+document.getElementById('cmbFar').value+"&posting="+document.getElementById('cmbPost').value+"&filter="+a1.getFilter()+"&sorting="+a1.getSorting()+"&page="+a1.getPage();
			a1.loadURL(url,"","GET");
		}
	}
	
	function chkKlik(p){
		var cekbox=(p==true)?1:0;
		var sTotal=0;
		var sisip;
		//alert(p);
		for (var i=0;i<a1.getMaxRow();i++){
			a1.cellsSetValue(i+1,7,cekbox);
			if (cekbox==1){
				sisip=a1.getRowId(i+1).split("|");
				sTotal +=sisip[2]*1;
			}
		}
		a1.cellSubTotalSetValue(6,FormatNumberFloor(sTotal,"."));
	}
	
	function kirim(){
	var url;
		url="returnObat_util.php?kso="+document.getElementById('cmbKso').value+"&tanggals="+document.getElementById('tgls').value+"&tanggald="+document.getElementById('tgld').value+"&tempat="+document.getElementById('cmbTmp').value+"&farmasi="+document.getElementById('cmbFar').value+"&posting="+document.getElementById('cmbPost').value;
		//alert(url);
		a1.loadURL(url,"","GET");
	}
	
	function PostingJurnal(){
	var tmp='',idata='';
	var url;
		url="returnObat_util.php?kso="+document.getElementById('cmbKso').value+"&tanggals="+document.getElementById('tgls').value+"&tanggald="+document.getElementById('tgld').value+"&tempat="+document.getElementById('cmbTmp').value+"&farmasi="+document.getElementById('cmbFar').value+"&posting="+document.getElementById('cmbPost').value+"&idUser=<?php echo $iduser; ?>";
		//alert(a1.getMaxRow());
		for (var i=0;i<a1.getMaxRow();i++){
			//alert(a1.obj.childNodes[0].childNodes[i].childNodes[6].childNodes[0].checked);
			if (a1.obj.childNodes[0].childNodes[i].childNodes[6].childNodes[0].checked){
				//alert(a1.cellsGetValue(i+1,2));
				//alert(a1.getRowId(i+1));
				//idata=a1.getRowId(i+1).split("|");
				//tmp+=idata[0]+String.fromCharCode(5)+idata[1]+String.fromCharCode(5)+ValidasiText(a1.cellsGetValue(i+1,3))+String.fromCharCode(5)+ValidasiText(a1.cellsGetValue(i+1,4))+String.fromCharCode(6);
				
				tmp += a1.getRowId(i+1)+"*||*";
			}
		}
		//alert(tmp);
		if (tmp!=""){
			tmp=tmp.substr(0,(tmp.length-2));
			//alert(tmp);
			url+="&act=bayar&fdata="+tmp;
			a1.loadURL(url,"","GET");
			//alert(url);
			//alert(tmp.length);
			/* if (tmp.length>1024){
				alert("Data Yg Mau diBayar Terlalu Banyak !");
			}else{
				url+="&act=bayar&fdata="+tmp;
				//alert(url);
				//a1.loadURL(url,"","GET");
			} */
		}else{
			alert("Pilih Data Yg Mau diBayar Terlebih Dahulu !");
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
	
var th_skr = "<?php echo $date_skr[2];?>";
var bl_skr = "<?php echo ($date_skr[1]<10)?substr($date_skr[1],1,1):$date_skr[1];?>";
var fromHome=<?php echo $fromHome ?>;
</script>
<script src="../report_form.js" type="text/javascript" language="javascript"></script>
</body>
</html>
