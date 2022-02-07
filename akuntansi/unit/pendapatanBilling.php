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
<script type="text/javascript" language="JavaScript" src="../theme/js/ajax.js"></script>
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
                    <td class="jdltable" height="29" colspan="2">Transaksi Pendapatan / Piutang Billing</td>
                </tr>
                <tr id="trKso" style="display:none;">
                    <td style="padding-right:20px; text-align:right;" height="25">Nama KSO</td>
                    <td>:&nbsp;<select id="cmbKso" name="cmbKso" class="txtinput" onChange="kirim()">
                        <?php
                            $qkso = mysql_query("SELECT $dbbilling.b_ms_kso.id, $dbbilling.b_ms_kso.nama FROM $dbbilling.b_ms_kso WHERE aktif=1");
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
                <!--tr id="trUnit">
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
                    <td style="padding-right:20px; text-align:right;" width="45%" height="25">Tanggal KRS</td>
                    <td>:&nbsp;<input id="tgl" name="tgl" readonly size="11" class="txtcenter" type="text" value="<?php echo $tanggal; ?>" />&nbsp;<input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onClick="gfPop.fPopCalendar(document.getElementById('tgl'),depRange,kirim);"/></td>
                </tr>
                <tr>
                    <td height="30" style="padding-left:5px;"><select id="cmbPost" name="cmbPost" class="txtinput" style="background-color:#FFFFCC; color:#990000;" onChange="change()">
                        <option value="0">BELUM POSTING</option>
                        <option value="1">SUDAH POSTING</option>
                    </select>
                    </td>
                    <td height="30" align="right" style="padding-right:5px;"><BUTTON type="button" disabled="disabled" id="btnKwitansi" onClick="CetakKwitansi();" style="cursor:pointer;"><IMG SRC="../icon/contact-us.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Kwitansi JRR</BUTTON>&nbsp;&nbsp;<BUTTON type="button" id="btnPosting" onClick="PostingJurnal();"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Posting >> Jurnal</BUTTON></td>
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
<div id="divPopProgressBar" class="popup" style="width:300px;height:130px;display:none;">
    <fieldset>
        <legend style="float:right; display:none;">
            <div style="float:right; cursor:pointer" class="popup_closebox">
                <img alt="close" src="../icon/cancel.gif" height="16" width="16" align="absmiddle"/>Tutup</div>
        </legend>
        <table>
            <tr>
                <td id="tdLblProgressVerif">Proses Posting :&nbsp;</td>
                <td>
                    <img src="../images/wait.gif" border="0" width="120" height="25" />
                </td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <BUTTON type="button" id="btnOkCancel" onClick="fProgressOkCancel();"><IMG id="imgOkCancel" SRC="../icon/del16.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;<span id="spnOkCancel">Batal</span>&nbsp;&nbsp;</BUTTON>
                </td>
            </tr>
        </table>
    </fieldset>
    <span id="spnProgress">Proses : 1 dari 70</span>
    <span id="hasilAjaxProgress" style="display:none;"></span>
</div>
</div>
<script>
	var a1 = new DSGridObject("gridbox");
	a1.setHeader("DATA PENDAPATAN / PIUTANG BILLING");
	a1.setColHeader("NO,TANGGAL PULANG,NAMA KASIR,KSO,TARIF RS,BIAYA PASIEN,BIAYA KSO,BAYAR PASIEN,PIUTANG PASIEN,VERIFIKASI<BR><input type='checkbox' name='chkAll' id='chkAll' onClick='chkKlik(this.checked);'>&nbsp;&nbsp;&nbsp;&nbsp;");
	a1.setCellType("txt,txt,txt,txt,txt,txt,txt,txt,txt,chk");
	a1.setSubTotal(",,,SubTotal :&nbsp;,0,0,0,0,0,");
	a1.setIDColHeader(",,mp.nama,,,,,,,");
	a1.setColWidth("30,70,140,160,70,70,70,70,70,50");
	a1.setCellAlign("center,center,center,center,right,right,right,right,right,center");
	a1.setSubTotalAlign("center,center,center,right,right,right,right,right,right,center");
	a1.setCellHeight(20);
	a1.setImgPath("../icon");
	a1.setIDPaging("paging");
	a1.onLoaded(konfirmasi);
	//a.attachEvent("onRowClick");
	a1.baseURL("../unit/pendapatanBilling_utils.php?grd=pendBilling&kso="+document.getElementById('cmbKso').value+"&tanggal="+document.getElementById('tgl').value+"&posting="+document.getElementById('cmbPost').value);
	a1.Init();

	/*var a1Detail = new DSGridObject("gridboxDetail");
	a1Detail.setHeader("DATA PENDAPATAN / PIUTANG BILLING");
	a1Detail.setColHeader("NO,TANGGAL KUNJUNGAN,TANGGAL PULANG,NO RM,NAMA,KSO,KUNJUNGAN AWAL,TARIF RS,BIAYA PASIEN,BIAYA KSO,BAYAR PASIEN,PIUTANG PASIEN,VERIFIKASI<BR><input type='checkbox' name='chkAll' id='chkAll' onClick='chkKlik(this.checked);'>&nbsp;&nbsp;&nbsp;&nbsp;");
	a1Detail.setCellType("txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,chk");
	a1Detail.setSubTotal(",,,,,,SubTotal :&nbsp;,0,0,0,0,0,");
	a1Detail.setIDColHeader(",,,pas.no_rm,pas.nama,kso.nama,mu.nama,,,,,,");
	a1Detail.setColWidth("30,70,70,60,170,100,140,70,70,70,70,70,50");
	a1Detail.setCellAlign("center,center,center,center,left,center,left,right,right,right,right,right,center");
	a1Detail.setSubTotalAlign("center,center,center,center,center,center,right,right,right,right,right,right,center");
	a1Detail.setCellHeight(20);
	a1Detail.setImgPath("../icon");
	a1Detail.setIDPaging("paging");
	a1Detail.onLoaded(konfirmasi);
	//a.attachEvent("onRowClick");
	a1Detail.baseURL("../unit/pendapatanBilling_utils.php?grd=pendBilling&kso="+document.getElementById('cmbKso').value+"&tanggal="+document.getElementById('tgl').value+"&posting="+document.getElementById('cmbPost').value);
	a1Detail.Init();*/

	function konfirmasi(key,val){
		//alert(val+'-'+key);
		document.getElementById('chkAll').checked=false;
		if (val!=undefined){
			var tmp36 = val.split(String.fromCharCode(3));
			a1.cellSubTotalSetValue(5,tmp36[0]);
			a1.cellSubTotalSetValue(6,tmp36[1]);
			a1.cellSubTotalSetValue(7,tmp36[2]);
			a1.cellSubTotalSetValue(8,tmp36[3]);
			a1.cellSubTotalSetValue(9,tmp36[4]);
			if (tmp36[5]!=""){
				alert(tmp36[5]);
			}
			/* if(key=='Error'){
				if(val=='postingBilling'){
					alert('Terjadi Error dlm Proses Posting !');
				}
			}else{
				if(val=='postingBilling'){
					alert('Proses Posting Berhasil !');
				}
			} */
			document.getElementById('btnPosting').disabled=false;
		}else{
			a1.cellSubTotalSetValue(5,0);
			a1.cellSubTotalSetValue(6,0);
			a1.cellSubTotalSetValue(7,0);
			a1.cellSubTotalSetValue(8,0);
			a1.cellSubTotalSetValue(9,0);
			document.getElementById('btnPosting').disabled=true;
		}
		
		if (a1.getMaxPage()>0){
			document.getElementById('btnPosting').disabled=false;
			if (cmbPost.value!=0){
				document.getElementById('btnKwitansi').disabled=false;
			}else{
				document.getElementById('btnKwitansi').disabled=true;
			}
		}else{
			document.getElementById('btnPosting').disabled=true;
			document.getElementById('btnKwitansi').disabled=true;
		}
	}
	
	function goFilterAndSort(grd){
	var url;
		//alert(grd);
		if (grd=="gridbox"){		
			url="../unit/pendapatanBilling_utils.php?grd=pendBilling&kso="+document.getElementById('cmbKso').value+"&tanggal="+document.getElementById('tgl').value+"&posting="+document.getElementById('cmbPost').value+"&filter="+a1.getFilter()+"&sorting="+a1.getSorting()+"&page="+a1.getPage();
			//alert(url);
			a1.loadURL(url,"","GET");
		}
	}
	
	function chkKlik(p){
		var cekbox=(p==true)?1:0;
			//alert(p);
			for (var i=0;i<a1.getMaxRow();i++){
				a1.cellsSetValue(i+1,10,cekbox);
			}
	}
	
	function kirim(){
	var url;
		document.getElementById('btnPosting').disabled=true;
		url="../unit/pendapatanBilling_utils.php?grd=pendBilling&kso="+document.getElementById('cmbKso').value+"&tanggal="+document.getElementById('tgl').value+"&posting="+document.getElementById('cmbPost').value;
		//alert(url);
		a1.loadURL(url,"","GET");
	}
	
	var pdata,iter,cancelP;
	
	function PostingJurnal(){
	var tmp='';
	var url;
		document.getElementById('btnPosting').disabled=true;
		url="../unit/pendapatanBilling_utils.php?grd=pendBilling&kso="+document.getElementById('cmbKso').value+"&tanggal="+document.getElementById('tgl').value+"&posting="+document.getElementById('cmbPost').value+"&idUser=<?php echo $iduser; ?>";
		
		for (var i=0;i<a1.getMaxRow();i++){
			if (a1.obj.childNodes[0].childNodes[i].childNodes[9].childNodes[0].checked){
				//alert(a1.cellsGetValue(i+1,2));
				tmp+=a1.getRowId(i+1)+String.fromCharCode(6);
			}
		}
		if (tmp!=""){
			tmp=tmp.substr(0,(tmp.length-1));
			//alert(tmp.length);
			/*if (tmp.length>1024){
				alert("Data Yg Mau diPosting Terlalu Banyak !");
				document.getElementById('btnPosting').disabled=false;
			}else{
				url+="&act=postingBilling&fdata="+tmp;
				//alert(url);
				a1.loadURL(url,"","GET");*/
				//====Tambahan u/ Progress Bar====
				document.getElementById('tdLblProgressVerif').innerHTML="Proses Verifikasi : ";
				if (document.getElementById('cmbPost').value=="1"){
					document.getElementById('tdLblProgressVerif').innerHTML="Proses UnVerifikasi : ";
				}
				new Popup('divPopProgressBar',null,{modal:true,position:'center',duration:0.5})
				$('divPopProgressBar').popup.show();
				pdata=tmp.split(String.fromCharCode(6));
				iter=1;
				cancelP=0;
				fProgressExecute();
			//}
		}else{
			alert("Pilih Data Yg Mau diPosting Terlebih Dahulu !");
			document.getElementById('btnPosting').disabled=false;
		}
	}
	
	function fProgressExecute(){
		var url;
		document.getElementById('spnProgress').innerHTML="Proses : "+iter+" dari "+pdata.length;
		url="../unit/pendapatanBilling_utils.php?grd=pendBilling&kso="+document.getElementById('cmbKso').value+"&tanggal="+document.getElementById('tgl').value+"&posting="+document.getElementById('cmbPost').value+"&idUser=<?php echo $iduser; ?>&act=postingBilling&fdata="+pdata[iter-1]+"&useProgress=1";
		//alert(url);
		Request(url,'hasilAjaxProgress',"","GET",function(v){
			iter++;
			if ((iter<=pdata.length) && (cancelP==0)){
				fProgressExecute();
			}else{
				kirim();
				document.getElementById('imgOkCancel').src="../icon/save.ico";
				document.getElementById('spnOkCancel').innerHTML="Tutup";
				if (cancelP==0){
					fProgressOkCancel();
				}
			}
		},'noload');
	}
	//-================================
	function fProgressOkCancel(){
		cancelP=1;
		document.getElementById('imgOkCancel').src="../icon/del16.gif";
		document.getElementById('spnOkCancel').innerHTML="Batal";
		$('divPopProgressBar').popup.hide();
		document.getElementById('btnPosting').disabled=false;
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
			document.getElementById('btnKwitansi').disabled=true;
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
		//var no_bukti = document.getElementById('no_bukti').value;
		//var tgl = document.getElementById('tgl2').value;
		//alert(a1.getRowId(a1.getSelRow()));
		var url;
		var sisip = a1.getRowId(a1.getSelRow()).split("|");
		// alert(sisip);
		var idPosting = sisip[12];
		/*if(tgl=='')
		{
			alert('Pilih baris yang akan dicetak');
		}
		else
		{*/
			//url='../kwitansi/bukti.php?kw='+no_bukti+'&tipe=3&tgl='+sisip[2]+'&no_post='+idPosting+"&terima="+terima;
			url='../../keuangan/laporan/jurnal/bukti_jurnal_rupa_rupa.php?id_posting='+idPosting;
			window.open(url);
			//clear();
		//}
	}
</script>
</body>
</html>