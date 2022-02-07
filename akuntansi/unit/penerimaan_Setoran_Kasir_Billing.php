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

if($_REQUEST['tanggal']==""){
	$tanggal = $tgl;
}else{
	$tanggal = $_REQUEST['tanggal'];
}
$tang = explode('-',$tanggal);
$tanggalan = $tang[2].'-'.$tang[1].'-'.$tang[0];//echo $tanggalan."<br>";
$waktu = "t.tgl='$tanggalan'";

?>
<html>
<head>
<title>Sistem Informasi Akuntansi</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script type="text/JavaScript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
<script type="text/JavaScript" language="JavaScript" src="../theme/js/ajax.js"></script>
<!--script src="../theme/js/noklik.js" type="text/javascript"></script-->
<link rel="stylesheet" href="../theme/simkeu.css" type="text/css" />
</head>
<body>
<div align="center">
<?php
$wktnow=gmdate('H:i:s',mktime(date('H')+7));
$wkttgl=gmdate('d/m/Y',mktime(date('H')+7));
$url=explode("/",$_SERVER['REQUEST_URI']);
$imgpath="/".$url[1]."/images";
$iunit=$_SESSION['akun_username'];
?>
<style type="text/css">
/* .style1 {font-family: Verdana, Arial, Helvetica, sans-serif} */
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
            <table width="900" border="0" cellpadding="0" cellspacing="0" class="txtinput">
                <tr>
                    <td class="jdltable" height="29" colspan="2">Transaksi Penerimaan Kasir Billing</td>
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
                </tr-->
                <tr>
                    <td width="40%" style="padding-right:20px; text-align:right;" height="25">Kasir</td>
                    <td>:&nbsp;<select id="cmbKasir" name="cmbKasir" class="txtinput" onChange="kirim()">
                        <option value="0">SEMUA</option>
                        <?php
                            $qTmp = mysql_query("SELECT mp.id,mp.nama FROM (SELECT DISTINCT user_act FROM $dbbilling.b_bayar b WHERE b.tgl='$tanggalan') AS bb 
INNER JOIN $dbbilling.b_ms_pegawai mp ON bb.user_act=mp.id ORDER BY mp.nama");
                            while($wTmp = mysql_fetch_array($qTmp)){
                        ?>
                        <option value="<?php echo $wTmp['id'];?>"><?php echo $wTmp['nama'];?></option>
                        <?php	}	?>
                    </select></td>
                </tr>
                <tr>
                  <td style="padding-right:20px; text-align:right;" height="25">Ket / No Bukti</td>
                  <td>:&nbsp;<input id="noSlip" name="noSlip" size="30" class="txtleft" type="text" value="" /><input id="no_bukti" type="hidden"/><input id="tgl2" type="hidden"/></td>
                </tr>
                <tr>
                    <td style="padding-right:20px; text-align:right;" height="25">Tgl Setor</td>
                    <td>:&nbsp;<input id="tgl" name="tgl" readonly size="11" class="txtcenter" type="text" value="<?php echo $tanggal; ?>" />&nbsp;<input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onClick="gfPop.fPopCalendar(document.getElementById('tgl'),depRange,LoadCmbKasir);"/></td>
                </tr>
                <tr>
                    <td height="30" style="padding-left:15px;"><select id="cmbPost" name="cmbPost" class="txtinput" style="background-color:#FFFFCC; color:#990000;" onChange="disable(this.value);change();">
                        <option value="0">BELUM POSTING</option>
                        <option value="1">SUDAH POSTING</option>
                    </select></td>
                    <td height="30" align="right" style="padding-right:15px;">
					<BUTTON type="button" disabled="disabled" id="btnKwitansi" onClick="CetakKwitansi();" style="cursor:pointer;"><IMG SRC="../icon/contact-us.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Kwitansi BKM/BBM</BUTTON>
					<BUTTON type="button" id="btnPosting" onClick="PostingJurnal();" style="cursor:pointer"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Posting >> Jurnal</BUTTON></td>
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
	a1.setColHeader("NO,TGL SETOR,NO SLIP,KASIR,NILAI,PILIH<BR><input type='checkbox' name='chkAll' id='chkAll' onClick='chkKlik(this.checked);'>&nbsp;&nbsp;&nbsp;&nbsp;");
	//a1.setCellType("txt,txt,txt,txt,txt,txt,txt,chk")
	a1.setSubTotal(",,,SubTotal :&nbsp;,0,");
	a1.setIDColHeader(",,no_bukti,nama,,");
	a1.setColWidth("40,80,120,470,90,40");
	a1.setCellAlign("center,center,center,left,right,center");
	a1.setSubTotalAlign("center,center,center,right,right,left");
	a1.setCellType("txt,txt,txt,txt,txt,chk");
	a1.setCellHeight(20);
	a1.setImgPath("../icon");
	a1.setIDPaging("paging");
	a1.attachEvent("onRowClick","ambil");
	a1.onLoaded(konfirmasi);
	//a.attachEvent("onRowClick");
	//alert("../unit/penerimaan_Setoran_Kasir_Billing_Utils.php?grd=penerimaanBillingKasir&tanggal="+document.getElementById('tgl').value+"&kasir="+document.getElementById('cmbKasir').value+"&posting="+document.getElementById('cmbPost').value);
	a1.baseURL("../unit/penerimaan_Setoran_Kasir_Billing_Utils.php?grd=penerimaanBillingKasir&tanggal="+document.getElementById('tgl').value+"&kasir="+document.getElementById('cmbKasir').value+"&posting="+document.getElementById('cmbPost').value);
	a1.Init();
	
	function ambil(val){
		var data = a1.getRowId(a1.getSelRow()).split("|");
		document.getElementById('no_bukti').value = data[5];
		document.getElementById('tgl2').value = data[6];
	}

	
	function konfirmasi(key,val){
		var tmp;
		//alert(val);
		tmp=val.split(String.fromCharCode(3));
		document.getElementById('chkAll').checked=false;
		if (val!=undefined){
			
			//alert(tmp[1]+" "+tmp[2]);
			if(key=='Error'){
				if(tmp[0]=='posting'){
					alert('Terjadi Error dlm Proses Posting !');
				}
				else if(tmp[0]=='Unposting'){
					alert('Terjadi Error dlm Proses Unposting !');
				}
			}else{
				if(tmp[0]=='posting'){
					alert('Proses Posting Berhasil !');
				}
				else if(tmp[0]=='Unposting'){
					alert('Proses Unposting Berhasil !');
				}
			}
		}
		
		setSubTotal(tmp[1],tmp[2]);
		
		if (a1.getMaxPage()>0){
			document.getElementById('btnPosting').disabled=false;
			document.getElementById('btnKwitansi').disabled=false;
		}else{
			document.getElementById('btnPosting').disabled=true;
			document.getElementById('btnKwitansi').disabled=true;
		}
	}
	
	function goFilterAndSort(grd){
	var url;
		//alert(grd);
		if (grd=="gridbox"){		
			url="../unit/penerimaan_Setoran_Kasir_Billing_Utils.php?grd=penerimaanBillingKasir&tanggal="+document.getElementById('tgl').value+"&kasir="+document.getElementById('cmbKasir').value+"&posting="+document.getElementById('cmbPost').value+"&filter="+a1.getFilter()+"&sorting="+a1.getSorting()+"&page="+a1.getPage();
			//alert(url);
			a1.loadURL(url,"","GET");
		}
	}
	
	function chkKlik(p){
	var cekbox=(p==true)?1:0;
		//alert(p);
		for (var i=0;i<a1.getMaxRow();i++){
			a1.cellsSetValue(i+1,6,cekbox);
		}
	}
	
	function LoadCmbKasir(){
	var url;
		url="../unit/penerimaan_Setoran_Kasir_Billing_Utils.php?grd=loadkasir&tanggal="+document.getElementById('tgl').value;
		//alert(url);
		Request(url,'cmbKasir',"","GET",kirim,'noload');
	}
	
	function disable(tombol){
		if(tombol=='0')
		{
			//document.getElementById('btnKwitansi').disabled=true;
			//document.getElementById('btnPosting').disabled=false;
		}
		else
		{
			//document.getElementById('btnKwitansi').disabled=false;
			//document.getElementById('btnPosting').disabled=true;
		}
	
	}
	
	function kirim(){
		var x = document.getElementById('cmbPost').value;
		//x = 0;
		/*if(x=='1')
		{	
			document.getElementById('no_bukti').value ='';
			a1.setColHeader("NO,TGL SLIP,UNIT PELAYANAN,KSO,KASIR,NILAI,NILAI SLIP,POSTING");
			a1.setColWidth("40,80,170,170,170,100,100,60");
			a1.setCellAlign("center,center,left,left,left,right,right,center");
			a1.setIDColHeader(",,unit,kso,nama,,,");
			
		}
		else
		{
			a1.setColHeader("NO,TGL SLIP,UNIT PELAYANAN,KSO,KASIR,NILAI,NILAI SLIP,PILIH<BR><input type='checkbox' name='chkAll' id='chkAll' onClick='chkKlik(this.checked);'>&nbsp;&nbsp;&nbsp;&nbsp;");
			//a1.setColWidth("40,180,180,140,90,90,50");
			a1.setColWidth("40,80,170,170,170,100,100,60");
			a1.setCellType("txt,txt,txt,txt,txt,txt,txt,chk");
			a1.setCellAlign("center,center,left,left,left,right,right,center");
			a1.setIDColHeader(",,unit,kso,nama,,,");
			
		}*/
		var url;

		url="../unit/penerimaan_Setoran_Kasir_Billing_Utils.php?grd=penerimaanBillingKasir&tanggal="+document.getElementById('tgl').value+"&kasir="+document.getElementById('cmbKasir').value+"&posting="+document.getElementById('cmbPost').value;
		//alert(url);		
		a1.loadURL(url,"","GET");
		clear();
	}

	function PostingJurnal(){
	var no_bukti = document.getElementById('noSlip').value; //alert(no_bukti);
	//var no_bukti = document.getElementById('no_bukti').value; //alert(no_bukti);
	var x = document.getElementById('tgl').value.split("-");
	var tglx = x[2]+'-'+x[1]+'-'+x[0];
	
	var tmp='',idata='';
	//var tmp2='';
	var url;
	//var url2;
		
		//alert(url);
		document.getElementById('btnPosting').disabled=true;
		for (var i=0;i<a1.getMaxRow();i++)
		{
			if (a1.obj.childNodes[0].childNodes[i].childNodes[5].childNodes[0].checked)
			{
				//alert(a1.cellsGetValue(i+1,2));
				//idata=a1.getRowId(i+1).split("|"); //alert(idata);
				idata=a1.getRowId(i+1);
				tmp+=idata+String.fromCharCode(6);
				//tmp+=idata[0]+String.fromCharCode(5)+idata[1]+String.fromCharCode(5)+idata[2]+String.fromCharCode(5)+idata[4]+String.fromCharCode(5)+tglx+String.fromCharCode(5)+no_bukti+String.fromCharCode(5)+idata[5]+String.fromCharCode(5)+<?=$iduser;?>+String.fromCharCode(5)+idata[7]+String.fromCharCode(5)+idata[8]+String.fromCharCode(6);
				
				//tmp2+=idata[0]+"|"+idata[1]+"|"+idata[2]+"|"+idata[4]+"|"+tglx+"|"+no_bukti+"|"+idata[5]+"|"+<?=$iduser;?>+"|"+idata[7]+"|"+idata[8];
			}
			//alert(a1.getRowId(i+1));
		}
		if (tmp!="")
		{
			tmp=tmp.substr(0,(tmp.length-1));
			//alert(tmp);
			if (tmp.length>1024)
			{
				alert("Data Yg Mau diPosting Terlalu Banyak !");
				document.getElementById('btnPosting').disabled=false;
			}
			else
			{
				url="../unit/penerimaan_Setoran_Kasir_Billing_Utils.php?act=posting&grd=penerimaanBillingKasir&idUser=<?php echo $iduser; ?>&tanggal="+document.getElementById('tgl').value+"&kasir="+document.getElementById('cmbKasir').value+"&posting="+document.getElementById('cmbPost').value+"&no_bukti="+no_bukti+"&fdata="+tmp;
				//alert(url);
				a1.loadURL(url,"","GET");
			}
		}
		else
		{
			alert("Pilih Data Yg Mau diPosting Terlebih Dahulu !");
			document.getElementById('btnPosting').disabled=false;
		}
		clear();
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
	
	function setSubTotal(sim,slip){
		//a1.cellSubTotalSetValue(5,sim);
		a1.cellSubTotalSetValue(5,slip);
	}
	
	function CetakKwitansi()
	{
		//var no_bukti = document.getElementById('no_bukti').value;
		//var tgl = document.getElementById('tgl2').value;
		//alert(a1.getRowId(a1.getSelRow()));
		var url;
		var sisip = a1.getRowId(a1.getSelRow()).split("|");
		// alert(sisip);
		var idPosting = sisip[3];
		/*if(tgl=='')
		{
			alert('Pilih baris yang akan dicetak');
		}
		else
		{*/
			//url='../kwitansi/bukti.php?kw='+no_bukti+'&tipe=3&tgl='+sisip[2]+'&no_post='+idPosting+"&terima="+terima;
			url='../../keuangan/laporan/jurnal/bukti_penerimaan_kas_bank.php?id_posting='+idPosting;
			window.open(url);
			clear();
		//}
	}
	
	function clear()
	{
		document.getElementById('no_bukti').value = '';
		document.getElementById('tgl2').value = '';
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
</script>
</body>
</html>