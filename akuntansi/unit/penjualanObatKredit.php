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
                    <td class="jdltable" height="29" colspan="2">Transaksi Penjualan Obat</td>
                </tr>
                <tr>
                    <td style="padding-right:20px; text-align:right;" width="40%" height="25">Nama KSO</td>
                    <td width="60%">:&nbsp;<select id="cmbKso" name="cmbKso" class="txtinput" onChange="kirim()">
                    	<option style="text-transform:uppercase" value="0">SEMUA</option>
                        <?php
							$qkso=mysql_query("SELECT $dbapotek.a_mitra.IDMITRA id, $dbapotek.a_mitra.NAMA nama FROM $dbapotek.a_mitra WHERE AKTIF=1");
                            //$flag=0;
                            while($wKso = mysql_fetch_array($qkso)){
                                //$flag++;
                                //if($kso=="" && $flag==1) $kso=$wKso['id'];
                        ?>
                        <option style="text-transform:uppercase" value="<?php echo $wKso['id'];?>"><?php echo $wKso['nama'];?></option>
                        <?php
                            }
                        ?>
                    </select></td>
                </tr>
                <tr style="visibility:collapse">
                    <td style="padding-right:20px; text-align:right;" height="25">Tempat Layanan</td>
                    <td>:&nbsp;<select id="cmbTmp" name="cmbTmp" class="txtinput" onChange="kirim()">
                    	<option value="0" <?php if($tempat==0){ echo "selected";}?>>SEMUA</option>
                        <?php
                            $qTmp = mysql_query("SELECT $dbbilling.b_ms_unit.id, $dbbilling.b_ms_unit.nama FROM $dbbilling.b_ms_unit WHERE $dbbilling.b_ms_unit.level=1 AND $dbbilling.b_ms_unit.kategori=2");
                            while($wTmp = mysql_fetch_array($qTmp)){
                        ?>
                        <option value="<?php echo $wTmp['id'];?>" <?php if($tempat==$wTmp['id']){ echo "selected";}?>><?php echo $wTmp['nama'];?></option>
                        <?php	}	?>
                    </select></td>
                </tr>
                <tr>
                    <td style="padding-right:20px; text-align:right;" height="25">Unit Farmasi</td>
                    <td>:&nbsp;<select id="cmbFarmasi" name="cmbFarmasi" class="txtinput" onChange="kirim()">
                        <?php
                            $qTmp = mysql_query("SELECT * FROM ".$dbapotek.".a_unit WHERE UNIT_TIPE=2 AND UNIT_ISAKTIF=1");
                            while($wTmp = mysql_fetch_array($qTmp)){
                        ?>
                        <option value="<?php echo $wTmp['UNIT_ID'];?>" <?php if($tempat==$wTmp['UNIT_ID']){ echo "selected";}?>><?php echo $wTmp['UNIT_NAME'];?></option>
                        <?php	}	?>
                    </select></td>
                </tr>
                <tr>
                  <td style="padding-right:20px; text-align:right;" height="25">Ket / No Slip</td>
                  <td>:&nbsp;<input id="noSlip" name="noSlip" size="30" class="txtleft" type="text" value="" /></td>
                </tr>
                <tr>
                    <td style="padding-right:20px; text-align:right;" height="25">Tanggal</td>
                    <td>:&nbsp;<input id="tgl" name="tgl" readonly size="11" class="txtcenter" type="text" value="<?php echo $tanggal; ?>" />&nbsp;<input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onClick="gfPop.fPopCalendar(document.getElementById('tgl'),depRange,kirim);"/></td>
                </tr>
                <tr>
                    <td height="30" style="padding-left:50px;"><select id="cmbPost" name="cmbPost" class="txtinput" style="background-color:#FFFFCC; color:#990000;" onChange="changePost(this.value);kirim();">
                        <option value="0">BELUM POSTING</option>
                        <option value="1">SUDAH POSTING</option>
                    </select></td>
                    <td height="30" align="right" style="padding-right:50px;"><BUTTON type="button" id="btnPosting" onClick="PostingJurnal()"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Posting >> Jurnal</BUTTON></td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <div id="gridbox" style="width:880px; height:300px; background-color:white; overflow:hidden;"></div>
                        <div id="paging" style="width:880px;"></div>                    </td>
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
	a1.setHeader("DATA TRANSAKSI PENJUALAN OBAT");
	a1.setColHeader("NO,TGL SLIP,NO SLIP,KSO,CARA BAYAR,UNIT PELAYANAN,SHIFT,NILAI JUAL,NILAI SLIP,NILAI HPP,POSTING<BR><input type='checkbox' name='chkAll' id='chkAll' onClick='chkKlik(this.checked);'>&nbsp;&nbsp;&nbsp;&nbsp;");
	a1.setSubTotal(",,,,,SubTotal :&nbsp;,,0,0,0,");
	a1.setIDColHeader(",,no_slip,KSO_NAMA,cara_bayar,nama,SHIFT,,,,");
	a1.setColWidth("30,80,120,170,90,180,50,90,90,90,50");
	a1.setCellAlign("center,center,center,left,center,left,center,right,right,right,center");
	a1.setSubTotalAlign("center,center,center,center,center,right,center,right,right,right,left");
	a1.setCellType("txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,chk");
	a1.setCellHeight(20);
	a1.setImgPath("../icon");
	a1.setIDPaging("paging");
	a1.onLoaded(konfirmasi);
	//a.attachEvent("onRowClick");
	//alert("../unit/penjualanObatKredit_utils.php?grd=penjualanObat&kso="+document.getElementById('cmbKso').value+"&tanggal="+document.getElementById('tgl').value+"&tempat="+document.getElementById('cmbTmp').value+"&posting="+document.getElementById('cmbPost').value+"&cmbFarmasi="+document.getElementById('cmbFarmasi').value);
	a1.baseURL("../unit/penjualanObatKredit_utils.php?grd=penjualanObat&kso="+document.getElementById('cmbKso').value+"&tanggal="+document.getElementById('tgl').value+"&tempat="+document.getElementById('cmbTmp').value+"&posting="+document.getElementById('cmbPost').value+"&cmbFarmasi="+document.getElementById('cmbFarmasi').value);
	a1.Init();

	function konfirmasi(key,val){
	var tmp;
		//alert(val+'-'+key);
		document.getElementById('chkAll').checked=false;
		if (val!=undefined){
			tmp=val.split(String.fromCharCode(3));
			a1.cellSubTotalSetValue(8,tmp[1]);
			a1.cellSubTotalSetValue(9,tmp[2]);
			a1.cellSubTotalSetValue(10,tmp[3]);
			if(key=='Error'){
				if(tmp[0]=='postingPenjObat'){
					alert('Terjadi Error dlm Proses Posting !');
				}
			}else{
				if(tmp[0]=='postingPenjObat'){
					alert('Proses Posting Berhasil !');
				}
				else if(tmp[0]=='Unposting'){
					alert('Proses Unposting Berhasil !');
				}
			}
		}
	}
	
	function goFilterAndSort(grd){
	var url;
		//alert(grd);
		if (grd=="gridbox"){		
			url="../unit/penjualanObatKredit_utils.php?grd=penjualanObat&kso="+document.getElementById('cmbKso').value+"&tanggal="+document.getElementById('tgl').value+"&tempat="+document.getElementById('cmbTmp').value+"&posting="+document.getElementById('cmbPost').value+"&cmbFarmasi="+document.getElementById('cmbFarmasi').value+"&filter="+a1.getFilter()+"&sorting="+a1.getSorting()+"&page="+a1.getPage();
			//alert(url);
			a1.loadURL(url,"","GET");
		}
	}
	
	function chkKlik(p){
	var cekbox=(p==true)?1:0;
		//alert(p);
		for (var i=0;i<a1.getMaxRow();i++){
			a1.cellsSetValue(i+1,11,cekbox);
		}
	}
	
	function changePost(p){
		if (p==1){
			document.getElementById('btnPosting').disabled=false;
			document.getElementById('btnPosting').innerHTML="<IMG SRC='../icon/hapus.gif' border='0' width='16' height='16' ALIGN='absmiddle'>&nbsp;Unposting";
		}else{
			document.getElementById('btnPosting').disabled=false;
			document.getElementById('btnPosting').innerHTML="<IMG SRC='../icon/save.gif' border='0' width='16' height='16' ALIGN='absmiddle'>&nbsp;Posting >> Jurnal";
		}
	}
	
	function kirim(){
	var url;
		url="../unit/penjualanObatKredit_utils.php?grd=penjualanObat&kso="+document.getElementById('cmbKso').value+"&tanggal="+document.getElementById('tgl').value+"&tempat="+document.getElementById('cmbTmp').value+"&posting="+document.getElementById('cmbPost').value+"&cmbFarmasi="+document.getElementById('cmbFarmasi').value;
		//alert(url);
		a1.loadURL(url,"","GET");
	}
	
	function PostingJurnal(){
	var tmp='',idata='';
	var tmp2='';
	var url;
		
		if ((document.getElementById('cmbPost').value==0) && (document.getElementById('noSlip').value=='')){
			alert("No Slip / No Bukti Harus Diisi !");
			return false;
		}
		
		url="../unit/penjualanObatKredit_utils.php?grd=penjualanObat&kso="+document.getElementById('cmbKso').value+"&tanggal="+document.getElementById('tgl').value+"&tempat="+document.getElementById('cmbTmp').value+"&posting="+document.getElementById('cmbPost').value+"&idUser=<?php echo $iduser; ?>"+"&cmbFarmasi="+document.getElementById('cmbFarmasi').value+"&noSlip="+document.getElementById('noSlip').value;
		
		for (var i=0;i<a1.getMaxRow();i++){
			if (a1.obj.childNodes[0].childNodes[i].childNodes[10].childNodes[0].checked){
				//alert(a1.cellsGetValue(i+1,2));
				idata=a1.getRowId(i+1).split("|");
				tmp+=idata[0]+String.fromCharCode(5)+idata[1]+String.fromCharCode(5)+idata[2]+String.fromCharCode(5)+idata[9]+String.fromCharCode(5)+idata[8]+String.fromCharCode(5)+idata[7]+String.fromCharCode(5)+idata[3]+String.fromCharCode(5)+idata[4]+String.fromCharCode(5)+idata[5]+String.fromCharCode(5)+idata[6]+String.fromCharCode(6);
				
				tmp2+=idata[0]+"|"+idata[1]+"|"+idata[2]+"|"+idata[9]+"|"+idata[8]+"|"+idata[7]+"|"+idata[3]+"|"+idata[4]+"|"+idata[5]+"|"+idata[6];
			}
		}
		if (tmp!=""){
			tmp=tmp.substr(0,(tmp.length-1));
			//alert(tmp.length);
			if ((tmp.length + url.length)>1024){
				if (document.getElementById('cmbPost').value==0){
					alert("Data Yg Mau diPosting Terlalu Banyak !");
				}else{
					alert("Data Yg Mau diUnposting Terlalu Banyak !");
				}
				return false;
			}else{
				url+="&act=postingPenjObat&fdata="+tmp;
				//alert(tmp2);
				//alert(url);
				a1.loadURL(url,"","GET");
			}
		}else{
			if (document.getElementById('cmbPost').value==0){
				alert("Pilih Data Yg Mau diPosting Terlebih Dahulu !");
			}else{
				alert("Pilih Data Yg Mau diUnposting Terlebih Dahulu !");
			}
			return false;
		}
		document.getElementById('noSlip').value='';
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
</script>
</body>
</html>