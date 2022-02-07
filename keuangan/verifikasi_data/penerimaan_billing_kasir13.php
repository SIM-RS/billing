<?php
//include("../sesi.php");
include '../secured_sess.php';
$userId=$_SESSION['id'];
$tipe = $_REQUEST['tipe'];
if ($tipe==1){
	$caption = 'PENERIMAAN TUNAI PASIEN UMUM';
	$trUmumstyle="visible";
	$trKSOstyle="collapse";
}else{
	$caption = 'PENERIMAAN TUNAI PASIEN KSO';
	$trUmumstyle="collapse";
	$trKSOstyle="visible";
}

$pLegend = "Verifikasi Data -> Penerimaan Kasir -> Penerimaan Kasir Billing";

$tgl=gmdate('d-m-Y',mktime(date('H')+7));
//$kso=$_REQUEST['kso'];
//$tempat=$_REQUEST['tempat'];
if($_REQUEST['tanggal']==""){
	$tanggal = $tgl;
}else{
	$tanggal = $_REQUEST['tanggal'];
}
$tang = explode('-',$tanggal);
$tanggalan = $tang[2].'-'.$tang[1].'-'.$tang[0];//echo $tanggalan."<br>";
$waktu = "t.tgl='$tanggalan'";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <title>.: Penerimaan :.</title>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
        <link type="text/css" href="../menu.css" rel="stylesheet" />
        <script type="text/javascript" src="../jquery.js"></script>
        <script type="text/javascript" src="../menu.js"></script>
        <!--link type="text/css" rel="stylesheet" href="../theme/mod.css"-->
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/ajax.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <link rel="stylesheet" type="text/css" href="../theme/popup.css" />
        <script type="text/javascript" src="../theme/prototype.js"></script>
        <script type="text/javascript" src="../theme/effects.js"></script>
        <script type="text/javascript" src="../theme/popup.js"></script>
    </head>
    <?php
    include("../koneksi/konek.php");
    $tgl=gmdate('d-m-Y',mktime(date('H')+7));
    $th=explode("-",$tgl);
    ?>
    <body bgcolor="#808080" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"><!-- onload="viewTime()"-->
        <style type="text/css">
            .tbl
            { font-family:Arial, Helvetica, sans-serif; 
              font-size:12px;}
            </style>
            <script type="text/JavaScript">
                var arrRange = depRange = [];
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
        <div align="center"><?php include("../header.php");?></div>
        <div align="center">
            <table width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#EAEFF3">
                <tr>
                    <td valign="top" style="color:#006699;font-size:11px;"><?php echo $pLegend; ?></td>
                </tr>
                <tr id="trPen">
                    <td align="center" >
                        <table border="0" cellpadding="0" cellspacing="0">
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
                                <td width="130" style="padding-right:20px; text-align:right;" height="25">Kasir</td>
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
                            <tr style="display:none;">
                                <td style="padding-right:20px; text-align:right;" height="25">Tgl Penerimaan</td>
                                <td>:&nbsp;<input id="tgl" name="tgl" readonly size="11" class="txtcenter" type="text" value="<?php echo $tanggal; ?>" />&nbsp;<input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onClick="gfPop.fPopCalendar(document.getElementById('tgl'),depRange,LoadCmbKasir);"/></td>
                            </tr>
                            <tr>
                                <td style="padding-right:20px; text-align:right;" height="25">Tgl Setor / Slip</td>
                                <td>:&nbsp;<input id="tgl_slip" name="tgl_slip" readonly size="11" class="txtcenter" type="text" value="<?php echo $tanggal; ?>" />&nbsp;<input type="button" name="btnTgl_slip" value="&nbsp;V&nbsp;" class="tblBtn" onClick="gfPop.fPopCalendar(document.getElementById('tgl_slip'),depRange,Nothing);"/></td>
                            </tr>
                            <tr style="visibility:visible;">
                              <td style="padding-right:20px; text-align:right;" height="25">No Bukti</td>
                              <td>:&nbsp;<input id="noSlip" name="noSlip" size="30" class="txtinput"  type="text" value="" /></td>
                            </tr>
                        </table>
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td height="30" style="padding-left:5px;"><select id="cmbPost" name="cmbPost" class="txtinput" style="background-color:#FFFFCC; color:#990000;" onChange="cmbPostChange(this);">
                                    <option value="0">BELUM VERIFIKASI</option>
                                    <option value="1">SUDAH VERIFIKASI</option>
                                </select>                    </td>
                                <td height="30" align="right" style="padding-right:5px;"><BUTTON type="button" id="btnKoreksi" onClick="KoreksiDistribusi();" style="display:none;"><IMG SRC="../icon/calculator_red.png" border="0" width="16" height="16" ALIGN="absmiddle"><span id="spnBtnKor">&nbsp;Koreksi Distribusi</span></BUTTON>&nbsp;<BUTTON type="button" disabled="disabled" id="btnKwitansi" onClick="CetakKwitansi();" style="cursor:pointer;"><IMG SRC="../icon/contact-us.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Kwitansi BKM/BBM</BUTTON>&nbsp;<BUTTON type="button" id="btnVerifikasi" onClick="VerifikasiJurnal();"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle"><span id="spnBtnVer">&nbsp;Verifikasi</span></BUTTON></td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                    <div id="gridboxRekap" style="width:980px; height:200px; background-color:white;"></div>
                                    <!--div id="pagingRekap" style="width:980px;"></div>                    </td-->
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                        <table border="0" cellpadding="0" cellspacing="0">
                            <!--tr>
                                <td height="30" style="padding-left:5px;"></td>
                                <td height="30" align="right" style="padding-right:5px;"></td>
                            </tr-->
                            <tr>
                                <td colspan="2" align="center">
                                    <div id="gridbox" style="width:980px; height:250px; background-color:white;"></div>
                                    <div id="paging" style="width:980px;"></div>                    </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        <?php include("../footer.php");?>
                    </td>
                </tr>
            </table>
        </div>
        <span id="spn_respon" style="display:none;"></span>
        <div id="divPop" class="popup" style="width:960px;height:340px;display:none;">
            <fieldset>
                <legend style="float:right">
                    <div style="float:right; cursor:pointer" class="popup_closebox">
                        <img alt="close" src="../icon/cancel.gif" height="16" width="16" align="absmiddle"/>Tutup</div>
                </legend>
                <table>
                    <tr>
                        <td>
                            <div id="gridbox_pop" style="width:950px; height:310px; background-color:white;"></div>
                            <!--br/><br/>
                            <div id="paging_pop" style="width:900px;"></div-->
                        </td>
                    </tr>
                </table>
            </fieldset>
        </div>
        <div id="divPopProgressBar" class="popup" style="width:300px;height:100px;display:none;">
            <fieldset>
                <legend style="float:right; display:none;">
                    <div style="float:right; cursor:pointer" class="popup_closebox">
                        <img alt="close" src="../icon/cancel.gif" height="16" width="16" align="absmiddle"/>Tutup</div>
                </legend>
                <table>
                    <tr>
                    	<td id="tdLblProgressVerif">Proses Verifikasi :&nbsp;</td>
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
        <?php include("../laporan/report_form.php");?>
    </body>
<script>
	var bayar_id = '';
	//alert(fromHome);
	var aRkp = new DSGridObject("gridboxRekap");
	aRkp.setHeader("DATA PENERIMAAN BILLING OLEH KASIR");
	aRkp.setColHeader("NO,TGL PENERIMAAN,SLIP SETOR,NO BUKTI,NAMA KASIR,NILAI,VERIF&nbsp;&nbsp;&nbsp;&nbsp;<BR><input type='checkbox' name='chkAll' id='chkAll' onClick='chkKlik(this.checked);'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
	aRkp.setCellType("txt,txt,txt,txt,txt,txt,txt");
	aRkp.setSubTotal(",,,,SubTotal :&nbsp;,0,");
	aRkp.setIDColHeader(",,slip_ke,no_slip,,,");
	aRkp.setColWidth("35,80,65,100,480,100,70");
	aRkp.setCellAlign("center,center,center,center,left,right,center");
	aRkp.setSubTotalAlign("center,center,center,center,right,right,left");
	aRkp.setCellHeight(20);
	aRkp.setImgPath("../icon");
	//aRkp.setIDPaging("pagingRekap");
	aRkp.attachEvent("onRowClick","ambilDataDetail");
	aRkp.onLoaded(konfirmasi);
	aRkp.baseURL("penerimaan_billing_kasir_utils.php?grd=penerimaanBillingKasirRkp&tanggal="+document.getElementById('tgl').value+"&tanggalSlip="+document.getElementById('tgl_slip').value+"&kasir="+document.getElementById('cmbKasir').value+"&posting="+document.getElementById('cmbPost').value);
	aRkp.Init();

	var a1 = new DSGridObject("gridbox");
	a1.setHeader("DATA PENERIMAAN BILLING OLEH KASIR (DETAIL)");
	a1.setColHeader("NO,TGL PENERIMAAN,NO KW, SLIP SETOR,NO BUKTI,NO RM,NAMA PASIEN,JENIS PEMBAYARAN,NAMA KASIR,NILAI,VERIF<BR>&nbsp;&nbsp;<input type='checkbox' name='chkDetAll' id='chkDetAll' onClick='chkDetKlik(this.checked);'>&nbsp;&nbsp;,JENIS KASIR");
	a1.setCellType("txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,txt");
	a1.setSubTotal(",,,,,,,,SubTotal :&nbsp;,0,,");
	a1.setIDColHeader(",,no_kwitansi,slip_ke,no_slip,no_rm,nama,jbayar,petugas,,,kasir");
	a1.setColWidth("30,75,90,60,100,60,160,100,120,80,50,145");
	a1.setCellAlign("center,center,center,center,center,center,left,center,left,right,center,left");
	a1.setSubTotalAlign("center,center,center,center,center,center,right,right,right,right,left,left");
	a1.setCellHeight(20);
	a1.setImgPath("../icon");
	a1.setIDPaging("paging");
	//a1.attachEvent("onRowDblClick","ambilData");
	a1.onLoaded(konfirmasi);
	//a1.baseURL("penerimaan_billing_kasir_utils.php?grd=penerimaanBillingKasir&tanggal="+document.getElementById('tgl').value+"&tanggalSlip="+document.getElementById('tgl_slip').value+"&kasir="+document.getElementById('cmbKasir').value+"&posting="+document.getElementById('cmbPost').value);
	a1.baseURL("penerimaan_billing_kasir_utils.php?grd=penerimaanBillingKasir&tanggal="+document.getElementById('tgl').value+"&tanggalSlip="+document.getElementById('tgl_slip').value+"&Slip_ke=0&kasir="+document.getElementById('cmbKasir').value+"&posting="+document.getElementById('cmbPost').value);
	a1.Init();

	var b=new DSGridObject("gridbox_pop");
	b.setHeader("DETAIL PENERIMAAN");
	b.setColHeader("NO,TGL TINDAKAN,TEMPAT LAYANAN,PENJAMIN,TINDAKAN,PELAKSANA,KET,NILAI PEMBAYARAN");
	b.setSubTotal(",,,,,,SubTotal :&nbsp;,0");
	b.setIDColHeader(",,,,,,,");
	b.setColWidth("30,70,100,90,240,170,110,70");
	b.setCellAlign("center,center,left,center,left,left,center,right");
	b.setSubTotalAlign("center,center,center,center,right,right,right,right");
	b.setCellHeight(20);
	b.setImgPath("../icon");
	//b.setIDPaging("paging_pop");
	b.onLoaded(konfirmasi);
	b.baseURL("penerimaan_billing_kasir_utils.php?grd=penerimaanBillingKasirDetail&bayar_id=0");
	b.Init();
    
	function ambilDataDetail(){
		var tmp = aRkp.getRowId(aRkp.getSelRow()).split('|');
		var url = "penerimaan_billing_kasir_utils.php?grd=penerimaanBillingKasir&tanggal="+document.getElementById('tgl').value+"&tanggalSlip="+document.getElementById('tgl_slip').value+"&Slip_ke="+tmp[3]+"&kasir="+tmp[2]+"&posting="+document.getElementById('cmbPost').value;
		//alert(url)
		a1.loadURL(url,'','GET');
		//new Popup('divPop',null,{modal:true,position:'center',duration:0.5})
		//$('divPop').popup.show();
	}
    
	function ambilData(){
		var tmp = a1.getRowId(a1.getSelRow()).split('|');
		bayar_id = tmp[0];
		var url = "penerimaan_billing_kasir_utils.php?grd=penerimaanBillingKasirDetail&bayar_id="+bayar_id;
		//alert(url)
		b.loadURL(url,'','GET');
		new Popup('divPop',null,{modal:true,position:'center',duration:0.5})
		$('divPop').popup.show();
	}

	function konfirmasi(key,val){
	var tmp;
		//alert(val+'-'+key);
		if (document.getElementById('chkAll')){
			document.getElementById('chkAll').checked=false;
		}
		if (val!=undefined){
			tmp=val.split("|");
			//alert(tmp[1]);
			if(tmp[1]=='penerimaanBillingKasirRkp'){
				aRkp.cellSubTotalSetValue(6,tmp[2]);
				if (aRkp.getMaxPage()>0){
					document.getElementById('btnKwitansi').disabled=false;
				}else{
					document.getElementById('btnKwitansi').disabled=true;
				}
				ambilDataDetail();
			}else if(tmp[1]=='penerimaanBillingKasir'){
				a1.cellSubTotalSetValue(10,tmp[2]);
			}else if(tmp[1]=='penerimaanBillingKasirDetail'){
				b.cellSubTotalSetValue(8,tmp[2]);
			}
			if(key=='Error'){
				if (tmp[0]=='verifikasi'){
					/*if (tmp[3]=='0'){
						alert("Proses Verifikasi Gagal !");
					}else{
						alert("Proses UnVerifikasi Gagal !");
					}*/
					alert(tmp[1]);
				}
			}else{
				if (tmp[0]=='verifikasi'){
					if (tmp[3]=='0'){
						alert("Proses Verifikasi Berhasil !");
					}else{
						alert("Proses UnVerifikasi Berhasil !");
					}
				}
			}
		}
		document.getElementById('btnVerifikasi').disabled=false;
		document.getElementById('btnKoreksi').disabled=false;
		//setSubTotal();
	}
	
	function goFilterAndSort(grd){
	var url,tmp;
		//alert(grd);
		if (grd=="gridboxRekap")
		{		
			//url="../transaksi/utils.php?grd=penerimaanBillingKasir&tanggal="+document.getElementById('tgl').value+"&kasir="+document.getElementById('cmbKasir').value+"&posting="+document.getElementById('cmbPost').value+"&filter="+aRkp.getFilter()+"&sorting="+aRkp.getSorting()+"&page="+aRkp.getPage();
			url="penerimaan_billing_kasir_utils.php?grd=penerimaanBillingKasirRkp&tanggal="+document.getElementById('tgl').value+"&tanggalSlip="+document.getElementById('tgl_slip').value+"&kasir="+document.getElementById('cmbKasir').value+"&posting="+document.getElementById('cmbPost').value+"&filter="+aRkp.getFilter()+"&sorting="+aRkp.getSorting()+"&page="+aRkp.getPage();
			//alert(url);
			aRkp.loadURL(url,"","GET");
		}else if (grd=="gridbox"){
			tmp = aRkp.getRowId(aRkp.getSelRow()).split('|');
//url="../transaksi/utils.php?grd=penerimaanBillingKasir&tanggal="+document.getElementById('tgl').value+"&kasir="+document.getElementById('cmbKasir').value+"&posting="+document.getElementById('cmbPost').value+"&filter="+a1.getFilter()+"&sorting="+a1.getSorting()+"&page="+a1.getPage();
			url="penerimaan_billing_kasir_utils.php?grd=penerimaanBillingKasir&tanggal="+document.getElementById('tgl').value+"&tanggalSlip="+document.getElementById('tgl_slip').value+"&Slip_ke="+tmp[3]+"&kasir="+tmp[2]+"&posting="+document.getElementById('cmbPost').value+"&filter="+a1.getFilter()+"&sorting="+a1.getSorting()+"&page="+a1.getPage();
			//alert(url);
			a1.loadURL(url,"","GET");
		}
		/*var x = document.getElementById('cmbPost').value;
		if(x=='1')
		{
			setTimeout("setSubTotal3()",600);
			setTimeout("setSubTotal4()",600);
		}
		else
		{
			setTimeout("setSubTotal()",600);
			setTimeout("setSubTotal2()",600);
			
		}*/
	}
	
	function CetakKwitansi()
	{
		//var no_bukti = document.getElementById('no_bukti').value;
		//var tgl = document.getElementById('tgl2').value;
		//alert(a1.getRowId(a1.getSelRow()));
		var url;
		var sisip = aRkp.getRowId(aRkp.getSelRow()).split("|");
		// alert(sisip);
		var idPosting = sisip[7];
		var cmbPost = document.getElementById('cmbPost').value;
		if(cmbPost=='0')
		{
			alert('Data Harus DiVerifikasi Terlebih Dahulu !');
		}
		else
		{
			//url='../kwitansi/bukti.php?kw='+no_bukti+'&tipe=3&tgl='+sisip[2]+'&no_post='+idPosting+"&terima="+terima;
			url='../../keuangan/laporan/jurnal/bukti_penerimaan_kas_bank.php?id_posting='+idPosting;
			window.open(url);
			//clear();
		}
	}
	
	function test(){
		alert('hai');
	}
	
	function chkKlik(p){
		var cekbox=(p==true)?1:0;
		//alert(p);
		for (var i=0;i<aRkp.getMaxRow();i++){
			//a1.cellsSetValue(i+1,10,cekbox);
			//alert(document.getElementById('chkKasir_'+(i+1)).disabled);
			if (document.getElementById('chkKasir_'+(i+1)).value=="1"){
				document.getElementById('chkKasir_'+(i+1)).checked=p;
			}
		}
	}
	
	function chkDetKlik(p){
		var cekbox=(p==true)?1:0;
		//alert(p);
		for (var i=0;i<a1.getMaxRow();i++){
			//a1.cellsSetValue(i+1,10,cekbox);
			//alert(document.getElementById('chkKasir_'+(i+1)).disabled);
			if (document.getElementById('chkKasirDet_'+(i+1)).value=="1"){
				document.getElementById('chkKasirDet_'+(i+1)).checked=p;
			}
		}
	}
	
	function Nothing(){
		LoadCmbKasir();
	}
	
	function LoadCmbKasir(){
	var url;
		//document.getElementById('tgl_slip').value=document.getElementById('tgl').value;
		//url="../transaksi/utils.php?grd=loadkasir&tanggal="+document.getElementById('tgl').value+"&kasir="+document.getElementById('cmbKasir').value+"&posting="+document.getElementById('cmbPost').value;
		url="penerimaan_billing_kasir_utils.php?grd=loadkasir&tanggal="+document.getElementById('tgl').value+"&tanggalSlip="+document.getElementById('tgl_slip').value+"&kasir="+document.getElementById('cmbKasir').value+"&posting="+document.getElementById('cmbPost').value;
		//alert(url);
		Request(url,'cmbKasir',"","GET",kirim,'noload');
	}
	
	function kirim(){
		var url;
		var cmbPost = document.getElementById('cmbPost').value;
		url="penerimaan_billing_kasir_utils.php?grd=penerimaanBillingKasirRkp&tanggal="+document.getElementById('tgl').value+"&tanggalSlip="+document.getElementById('tgl_slip').value+"&kasir="+document.getElementById('cmbKasir').value+"&posting="+cmbPost;
		//alert(url);
		//a1.loadURL(url,"","GET");
		aRkp.loadURL(url,"","GET"); 
	}
	
	function cmbPostChange(obj){
		if(obj.value==0){
			document.getElementById('spnBtnVer').innerHTML='&nbsp;Verifikasi';
			document.getElementById('btnKoreksi').disabled=false;
		}else{
			document.getElementById('spnBtnVer').innerHTML='&nbsp;UnVerifikasi';
			document.getElementById('btnKoreksi').disabled=true;
		}
		kirim();
	}
	//=========================================
	function fJBayarChange(obj){
		var cbyrId=obj.id.substr(4,obj.id.length-4);
		var cjbyr=obj.lang;
		//alert(obj.id+'|'+obj.lang+'-'+cbyrId);
		if (confirm("Yakin Ingin Mengubah Jenis Pembayaran ?")){
			//alert('ok');
			var url="penerimaan_billing_kasir_utils.php?act=ubah_jenis_bayar&cbyrId="+cbyrId+"&cjbyr="+cjbyr;
			Request( url , "spn_respon", "", "GET",function(p){
				//alert(p);
				var tmp=p.split("|");
				if (tmp[0]=="OK"){
					document.getElementById('spn_'+tmp[1]).lang=tmp[2];
					document.getElementById('spn_'+tmp[1]).style.color=tmp[3];
					document.getElementById('spn_'+tmp[1]).innerHTML=tmp[4];
					alert("Berhasil Mengubah Jenis Pembayaran !");
				}else{
					alert("Gagal Mengubah Jenis Pembayaran !");
				}
			},'');
		}
	}
	
	function KoreksiDistribusi(){
		var tglSlip = document.getElementById('tgl_slip').value;
		var j=0;
		var tmp=idata="";
		//alert(a1.getMaxPage());
		if (a1.getMaxPage()>0){
			document.getElementById('btnKoreksi').disabled=true;
			for (var i=0;i<a1.getMaxRow();i++)
			{
				if (a1.obj.childNodes[0].childNodes[i].childNodes[10].childNodes[0].checked)
				{
					j++;
					//alert(document.getElementById('chkKasir_'+(i+1)).value);
					if (document.getElementById('chkKasir_'+(i+1)).value=="0"){
						idata=a1.getRowId(i+1).split("|");
						tmp+=idata[0]+String.fromCharCode(5)+idata[1]+String.fromCharCode(5)+idata[2]+String.fromCharCode(6);
					}
				}
			}
			if (tmp!="")
			{
				tmp=tmp.substr(0,(tmp.length-1));
				//alert(tmp);
				if (tmp.length>1024)
				{
					alert("Data Yg Mau diKoreksi Terlalu Banyak !");
					document.getElementById('btnKoreksi').disabled=false;
				}
				else
				{
					url="penerimaan_billing_kasir_utils.php?grd=penerimaanBillingKasir&act=koreksi_distribusi&idUser=<?php echo $userId; ?>&tanggal="+document.getElementById('tgl').value+"&tanggalSlip="+tglSlip+"&kasir="+document.getElementById('cmbKasir').value+"&posting="+document.getElementById('cmbPost').value+"&fdata="+tmp+"&filter="+a1.getFilter()+"&sorting="+a1.getSorting()+"&page="+a1.getPage();
					//alert(url);
					a1.loadURL(url,"","GET");
				}
			}
			else
			{
				if (j>0){
					alert("Data Pembayaran Yang Mau Dikoreksi : Distribusi Pembayarannya Sudah Sesuai !");
				}else{
					alert("Pilih Data Yg Mau diKoreksi Terlebih Dahulu !");
				}
				document.getElementById('btnKoreksi').disabled=false;
			}
		}else{
			alert("Tidak Ada Data !");
		}
	}
	
	var pdata,iter,cancelP;
	
	function VerifikasiJurnal(){
	var no_slip = document.getElementById('noSlip').value;
	var tglSlip = document.getElementById('tgl_slip').value;
	var x = document.getElementById('tgl').value.split("-");
	var tglx = x[2]+'-'+x[1]+'-'+x[0];
	
	var tmp='',idata='';
	var url;
	var url2;
	var j=0;
	var nilai='';
		
		//alert(url);
		//if (a1.getMaxPage()>0){
		if (aRkp.getMaxPage()>0){
			if (no_slip=="" && document.getElementById('cmbPost').value=="0"){
				alert("No Bukti Setor Harus Diisi !");
				document.getElementById('noSlip').focus();
				return false;
			}
			
			document.getElementById('btnVerifikasi').disabled=true;
			for (var i=0;i<aRkp.getMaxRow();i++)
			{
				//alert(a1.obj.childNodes[0].childNodes[i].childNodes[10].childNodes[0].checked);
				//if (a1.obj.childNodes[0].childNodes[i].childNodes[10].childNodes[0].checked)
				//if (aRkp.obj.childNodes[0].childNodes[i].childNodes[10].childNodes[0].checked)
				if (document.getElementById('chkKasir_'+(i+1)).checked)
				{
					j++;
					//if (document.getElementById('chkKasir_'+(i+1)).value=="1"){
					if (document.getElementById('chkKasir_'+(i+1)).value=="1"){
						//idata=a1.getRowId(i+1).split("|");
						idata=aRkp.getRowId(i+1).split("|");
						if (idata[5]=="1"){
							//alert("Data Pembayaran Pasien No KW : "+idata[4]+" Sudah Diposting ke Jurnal Akuntansi\r\nJadi Tidak Boleh DiUnverifikasi");
							alert("Data Penerimaan Kasir Ini Sudah Diposting ke Jurnal Akuntansi\r\nJadi Tidak Boleh DiUnverifikasi");
							document.getElementById('btnVerifikasi').disabled=false;
							return false;
						}
						tmp+=idata[0]+String.fromCharCode(5)+idata[1]+String.fromCharCode(5)+idata[2]+String.fromCharCode(5)+idata[3]+String.fromCharCode(5)+idata[4]+String.fromCharCode(5)+idata[5]+String.fromCharCode(5)+idata[6]+String.fromCharCode(6);
					}
				}
			}
			//alert(tmp);
			if (tmp!="")
			{
				tmp=tmp.substr(0,(tmp.length-1));
				//alert(tmp);
				/*if (tmp.length>1024)
				{
					alert("Data Yg Mau diPosting Terlalu Banyak !");
					document.getElementById('btnVerifikasi').disabled=false;
				}
				else
				{*/
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
					//url="penerimaan_billing_kasir_utils.php?grd=penerimaanBillingKasir&act=verifikasi&idUser=<?php echo $userId; ?>&tanggal="+document.getElementById('tgl').value+"&tanggalSlip="+tglSlip+"&no_slip="+no_slip+"&kasir="+document.getElementById('cmbKasir').value+"&posting="+document.getElementById('cmbPost').value+"&fdata="+tmp;
					//alert(url);
					//a1.loadURL(url,"","GET");
				//}
			}
			else
			{
				if (j>0){
					alert("Data Pembayaran Yang Mau Diverifikasi : Distribusi Pembayarannya Belum Sesuai !");
				}else{
					alert("Pilih Data Yg Mau diVerifikasi Terlebih Dahulu !");
				}
				document.getElementById('btnVerifikasi').disabled=false;
			}
		}else{
			alert("Tidak Ada Data !");
		}
	}
	
	function fProgressExecute(){
		var no_slip = document.getElementById('noSlip').value;
		var tglSlip = document.getElementById('tgl_slip').value;
		var url;
		document.getElementById('spnProgress').innerHTML="Proses : "+iter+" dari "+pdata.length;
		url="penerimaan_billing_kasir_utils.php?grd=penerimaanBillingKasirRkp&act=verifikasi&idUser=<?php echo $userId; ?>&tanggal="+document.getElementById('tgl').value+"&tanggalSlip="+tglSlip+"&no_slip="+no_slip+"&kasir="+document.getElementById('cmbKasir').value+"&posting="+document.getElementById('cmbPost').value+"&fdata="+pdata[iter-1];
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
		document.getElementById('btnVerifikasi').disabled=false;
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
	
	function zxc(par){
		var r=par.value;
		while (r.indexOf(".")>-1){
			r=r.replace(".","");
		}
		var nilai=FormatNumberFloor(parseInt(r),".");
		if(nilai=='NaN'){
			par.value = '';
		}
		else{
			par.value = nilai;
		}	
	}	
	
var th_skr = "<?php echo $date_skr[2];?>";
var bl_skr = "<?php echo ($date_skr[1]<10)?substr($date_skr[1],1,1):$date_skr[1];?>";
var fromHome=<?php echo $fromHome ?>;
</script>
<script src="../report_form.js" type="text/javascript" language="javascript"></script>
</html>