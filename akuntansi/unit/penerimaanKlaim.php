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
$th=explode("-",$tgl);
$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
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
                    <td class="jdltable" height="29" colspan="2">Transaksi Penerimaan Klaim KSO</td>
                </tr>
                <!--tr>
                    <td style="padding-right:20px; text-align:right;" width="40%" height="25">Nama KSO</td>
                    <td width="60%">:&nbsp;<select id="cmbKso" name="cmbKso" class="txtinput" onChange="kirim()">
                        <?php
                            $qkso = mysql_query("SELECT $dbbilling.b_ms_kso.id, $dbbilling.b_ms_kso.nama FROM $dbbilling.b_ms_kso");
                            $flag=0;
                            while($wKso = mysql_fetch_array($qkso)){
                                $flag++;
                                if($kso=="" && $flag==1) $kso=$wKso['id'];
                        ?>
                        <option style="text-transform:uppercase" value="<?php echo $wKso['id'];?>" <?php if($kso==$wKso['id']){ echo "selected"; $nKso=$wKso['nama'];} ?>><?php echo $wKso['nama'];?></option>
                        <?php
                            }
                        ?>
                    </select></td>
                </tr>
                <tr>
                    <td style="padding-right:20px; text-align:right;" height="25">Tempat Layanan</td>
                    <td>:&nbsp;<select id="cmbTmp" name="cmbTmp" class="txtinput" onChange="kirim()">
                        <option value="0">SEMUA</option>
                        <?php
                            $qTmp = mysql_query("SELECT $dbbilling.b_ms_unit.id, $dbbilling.b_ms_unit.nama FROM $dbbilling.b_ms_unit WHERE $dbbilling.b_ms_unit.level=1 AND $dbbilling.b_ms_unit.kategori=2");
                            while($wTmp = mysql_fetch_array($qTmp)){
                        ?>
                        <option value="<?php echo $wTmp['id'];?>" <?php if($tempat==$wTmp['id']){ echo "selected";}?>><?php echo $wTmp['nama'];?></option>
                        <?php	}	?>
                    </select></td>
                </tr-->
                <tr>
                    <td width="420" height="25" align="right"><span class="txtinput">Bulan </span></td>
                    <td height="25" align="left">:
                      <select name="bulan" id="bulan" class="txtinput" onChange="kirim()">
                        <option value="1" class="txtinput"<?php if ($bulan=="1") echo "selected";?>>Januari</option>
                        <option value="2" class="txtinput"<?php if ($bulan=="2") echo "selected";?>>Pebruari</option>
                        <option value="3" class="txtinput"<?php if ($bulan=="3") echo "selected";?>>Maret</option>
                        <option value="4" class="txtinput"<?php if ($bulan=="4") echo "selected";?>>April</option>
                        <option value="5" class="txtinput"<?php if ($bulan=="5") echo "selected";?>>Mei</option>
                        <option value="6" class="txtinput"<?php if ($bulan=="6") echo "selected";?>>Juni</option>
                        <option value="7" class="txtinput"<?php if ($bulan=="7") echo "selected";?>>Juli</option>
                        <option value="8" class="txtinput"<?php if ($bulan=="8") echo "selected";?>>Agustus</option>
                        <option value="9" class="txtinput"<?php if ($bulan=="9") echo "selected";?>>September</option>
                        <option value="10" class="txtinput"<?php if ($bulan=="10") echo "selected";?>>Oktober</option>
                        <option value="11" class="txtinput"<?php if ($bulan=="11") echo "selected";?>>Nopember</option>
                        <option value="12" class="txtinput"<?php if ($bulan=="12") echo "selected";?>>Desember</option>
                      </select>
                      <span class="txtinput">Tahun : </span>
                      <select name="ta" id="ta" class="txtinput" onChange="kirim()">
                        <?php for ($i=($th[2]-5);$i<($th[2]+1);$i++){ ?>
                        <option value="<?php echo $i; ?>" class="txtinput"<?php if ($i==$ta) echo "selected";?>><?php echo $i;?></option>
                        <? }?>
                  </select></td>
                </tr>
                <!--tr>
                  <td height="25" align="right">Ket / No Slip</td>
                  <td height="25" align="left">:&nbsp;<input id="noSlip" name="noSlip" size="30" class="txtleft" type="text" value="" /></td>
                </tr-->
                <tr>
                    <td height="30" style="padding-left:60px;"><select id="cmbPost" name="cmbPost" class="txtinput" style="background-color:#FFFFCC; color:#990000;" onChange="change()">
                        <option value="0">BELUM POSTING</option>
                        <option value="1">SUDAH POSTING</option>
                    </select>                    </td>
                    <td height="30" align="right" style="padding-right:65px;">
                    <BUTTON type="button" disabled="disabled" id="btnKwitansi" onClick="CetakKwitansi();" style="cursor:pointer"><IMG SRC="../icon/contact-us.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Kwitansi BKM/BBM</BUTTON>
                    <BUTTON type="button" id="btnPosting" onClick="PostingJurnal();"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Posting >> Jurnal</BUTTON></td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <div id="gridbox" style="width:900px; height:300px; background-color:white; overflow:hidden;"></div>
                        <div id="paging" style="width:900px;"></div>                    </td>
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
	a1.setHeader("DATA PENERIMAAN KLAIM KSO");
	a1.setColHeader("NO,TGL TERIMA,NO BUKTI TERIMA,NO BUKTI KLAIM,KSO,NILAI,POSTING<BR><input type='checkbox' name='chkAll' id='chkAll' onClick='chkKlik(this.checked);'>&nbsp;&nbsp;&nbsp;&nbsp;");
	a1.setIDColHeader(",nama,,,,");
	a1.setColWidth("50,80,120,120,280,100,75");
	a1.setCellAlign("center,center,center,center,left,right,center");
	a1.setCellType("txt,txt,txt,txt,txt,txt,chk");
	a1.setCellHeight(20);
	a1.setImgPath("../icon");
	a1.setIDPaging("paging");
	a1.onLoaded(konfirmasi);
	//a.attachEvent("onRowClick");
	a1.baseURL("../unit/penerimaanKlaim_utils.php?grd=KlaimKSO&bulan="+document.getElementById('bulan').value+"&tahun="+document.getElementById('ta').value+"&posting="+document.getElementById('cmbPost').value);
	a1.Init();

	function konfirmasi(key,val){
		//alert(val+'-'+key);
		document.getElementById('chkAll').checked=false;
		if(key=='Error'){
			if(val=='postingKlaimKSO'){
				alert('Terjadi Error dlm Proses Posting !');
			}
		}else{
			if(val=='postingKlaimKSO'){
				alert('Proses Posting Berhasil !');
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
			url="../unit/penerimaanKlaim_utils.php?grd=KlaimKSO&bulan="+document.getElementById('bulan').value+"&tahun="+document.getElementById('ta').value+"&posting="+document.getElementById('cmbPost').value+"&filter="+a1.getFilter()+"&sorting="+a1.getSorting()+"&page="+a1.getPage();
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
		url="../unit/penerimaanKlaim_utils.php?grd=KlaimKSO&bulan="+document.getElementById('bulan').value+"&tahun="+document.getElementById('ta').value+"&posting="+document.getElementById('cmbPost').value;
		//alert(url);
		a1.loadURL(url,"","GET");
	}
	
	function PostingJurnal(){
	var tmp='',tmp2='',idata='';
	var url;
		url="../unit/penerimaanKlaim_utils.php?grd=KlaimKSO&bulan="+document.getElementById('bulan').value+"&tahun="+document.getElementById('ta').value+"&posting="+document.getElementById('cmbPost').value+"&idUser=<?php echo $iduser; ?>";
		
		for (var i=0;i<a1.getMaxRow();i++){
			if (a1.obj.childNodes[0].childNodes[i].childNodes[6].childNodes[0].checked){
				//alert(a1.getRowId(i+1));
				idata=a1.getRowId(i+1).split("|");
				tmp+=idata[0]+String.fromCharCode(5)+ValidasiText(a1.cellsGetValue(i+1,3))+String.fromCharCode(5)+ValidasiText(a1.cellsGetValue(i+1,4))+String.fromCharCode(5)+ValidasiText(a1.cellsGetValue(i+1,6))+String.fromCharCode(5)+idata[1]+String.fromCharCode(5)+idata[2]+String.fromCharCode(5)+idata[3]+String.fromCharCode(6);
				tmp2+=idata[0]+"|"+ValidasiText(a1.cellsGetValue(i+1,3))+"|"+ValidasiText(a1.cellsGetValue(i+1,4))+"|"+ValidasiText(a1.cellsGetValue(i+1,6))+"|"+idata[1]+"|"+idata[2]+"|"+idata[3];
			}
		}
		if (tmp!=""){
			tmp=tmp.substr(0,(tmp.length-1));
			//alert(tmp.length);
			if (tmp.length>1024){
				alert("Data Yg Mau diPosting Terlalu Banyak !");
			}else{
				url+="&act=postingKlaimKSO&fdata="+tmp;
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
		var tgl = sisip[1];
		//var tgl = tgl1[2]+'-'+tgl1[1]+'-'+tgl1[0];
		if(tgl=='')
		{
			alert('Pilih baris yang akan dicetak');
		}
		else
		{
			window.open('../kwitansi/bukti.php?kw='+no_bukti+'&tipe=3&tgl='+tgl);
			clear();
		}
	}
</script>
</body>
</html>