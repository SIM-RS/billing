<?php
include("../sesi.php");
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
                  <td valign="top" align="center">&nbsp;</td>
                </tr>
                <tr id="trPen">
                    <td align="center" >
                        <table width="980" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="jdltable" height="29" colspan="2">Transaksi Penerimaan Kasir Billing / Yanmed</td>
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
                                <td style="padding-right:20px; text-align:right;" height="25">Tgl Penerimaan</td>
                                <td>:&nbsp;<input id="tgl" name="tgl" readonly size="11" class="txtcenter" type="text" value="<?php echo $tanggal; ?>" />&nbsp;<input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onClick="gfPop.fPopCalendar(document.getElementById('tgl'),depRange,LoadCmbKasir);"/></td>
                            </tr>
                            <tr>
                                <td style="padding-right:20px; text-align:right;" height="25">Tgl Setor / Slip</td>
                                <td>:&nbsp;<input id="tgl_slip" name="tgl_slip" readonly size="11" class="txtcenter" type="text" value="<?php echo $tanggal; ?>" />&nbsp;<input type="button" name="btnTgl_slip" value="&nbsp;V&nbsp;" class="tblBtn" onClick="gfPop.fPopCalendar(document.getElementById('tgl_slip'),depRange,Nothing);"/></td>
                            </tr>
                            <tr style="visibility:collapse;">
                              <td style="padding-right:20px; text-align:right;" height="25">Ket / No Slip</td>
                              <td>:&nbsp;<input id="noSlip" name="noSlip" size="30" class="txtinput"  type="text" value="" /></td>
                            </tr>
                            <tr>
                                <td height="30" style="padding-left:40px;"><select id="cmbPost" name="cmbPost" class="txtinput" style="background-color:#FFFFCC; color:#990000;" onChange="if(this.value==0){document.getElementById('spnBtnVer').innerHTML='&nbsp;Verifikasi';}else{document.getElementById('spnBtnVer').innerHTML='&nbsp;UnVerifikasi';};kirim();">
                                    <option value="0">BELUM VERIFIKASI</option>
                                    <option value="1">SUDAH VERIFIKASI</option>
                                </select>                    </td>
                                <td height="30" align="right" style="padding-right:40px;"><BUTTON type="button" id="btnVerifikasi" onClick="VerifikasiJurnal();"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle"><span id="spnBtnVer">&nbsp;Verifikasi</span></BUTTON></td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                    <div id="gridbox" style="width:950px; height:300px; background-color:white;"></div>
                                    <div id="paging" style="width:950px;"></div>                    </td>
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
        <div id="divPop" class="popup" style="width:960px;height:340px;display:none;">
            <fieldset>
                <legend style="float:right">
                    <div style="float:right; cursor:pointer" class="popup_closebox">
                        <img alt="close" src="../icon/cancel.gif" height="16" width="16" align="absmiddle"/>Tutup</div>
                </legend>
                <table>
                    <tr>
                        <td>
                            <div id="gridbox_pop" style="width:950px; height:310px; background-color:white; "></div>
                            <!--br/><br/>
                            <div id="paging_pop" style="width:900px;"></div-->
                        </td>
                    </tr>
                </table>
            </fieldset>
        </div>
        <?php include("../laporan/report_form.php");?>
    </body>
<script>
	var bayar_id = '';

	var a1 = new DSGridObject("gridbox");
	a1.setHeader("DATA PENERIMAAN BILLING OLEH KASIR");
	a1.setColHeader("NO,NO BILLING,NO RM,NAMA PASIEN,JENIS KASIR,NAMA KASIR,NILAI,VERIFIKASI<BR><input type='checkbox' name='chkAll' id='chkAll' onClick='chkKlik(this.checked);'>&nbsp;&nbsp;&nbsp;&nbsp;");
	a1.setCellType("txt,txt,txt,txt,txt,txt,txt,chk");
	a1.setSubTotal(",,,,,SubTotal :&nbsp;,0,");
	a1.setIDColHeader(",t2.unit,t2.kso,t2.nama,,,,");
	a1.setColWidth("40,90,90,220,150,160,90,50");
	a1.setCellAlign("center,center,center,left,left,left,right,center");
	a1.setSubTotalAlign("center,center,center,right,right,right,right,left");
	a1.setCellHeight(20);
	a1.setImgPath("../icon");
	a1.setIDPaging("paging");
	a1.attachEvent("onRowDblClick","ambilData");
	a1.onLoaded(konfirmasi);
	//a1.baseURL("../transaksi/utils.php?grd=penerimaanBillingKasir&tanggal="+document.getElementById('tgl').value+"&kasir="+document.getElementById('cmbKasir').value+"&posting="+document.getElementById('cmbPost').value);
	a1.baseURL("../transaksi/penerimaan_billing_kasir_utils.php?grd=penerimaanBillingKasir&tanggal="+document.getElementById('tgl').value+"&kasir="+document.getElementById('cmbKasir').value+"&posting="+document.getElementById('cmbPost').value);
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
			if(tmp[1]=='penerimaanBillingKasir'){
				a1.cellSubTotalSetValue(7,tmp[2]);
			}else if(tmp[1]=='penerimaanBillingKasirDetail'){
				b.cellSubTotalSetValue(8,tmp[2]);
			}
			if(key=='Error'){
				if (tmp[0]=='verifikasi'){
					if (tmp[3]=='0'){
						alert("Proses Verifikasi Gagal !");
					}else{
						alert("Proses UnVerifikasi Gagal !");
					}
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
		//setSubTotal();
	}
		
	function goFilterAndSort(grd){
	var url;
		//alert(grd);
		if (grd=="gridbox")
		{		
			url="../transaksi/utils.php?grd=penerimaanBillingKasir&tanggal="+document.getElementById('tgl').value+"&kasir="+document.getElementById('cmbKasir').value+"&posting="+document.getElementById('cmbPost').value+"&filter="+a1.getFilter()+"&sorting="+a1.getSorting()+"&page="+a1.getPage();
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
	
	function test(){
		alert('hai');
	}
	
	function chkKlik(p){
	var cekbox=(p==true)?1:0;
		//alert(p);
		for (var i=0;i<a1.getMaxRow();i++){
			a1.cellsSetValue(i+1,8,cekbox);
		}
	}
	
	function Nothing(){
	}
	
	function LoadCmbKasir(){
	var url;
		document.getElementById('tgl_slip').value=document.getElementById('tgl').value;
		url="../transaksi/utils.php?grd=loadkasir&tanggal="+document.getElementById('tgl').value+"&kasir="+document.getElementById('cmbKasir').value+"&posting="+document.getElementById('cmbPost').value;
		//alert(url);
		Request(url,'cmbKasir',"","GET",kirim,'noload');
	}
	
	function kirim(){
		var url;
		var cmbPost = document.getElementById('cmbPost').value;
		url="../transaksi/penerimaan_billing_kasir_utils.php?grd=penerimaanBillingKasir&tanggal="+document.getElementById('tgl').value+"&kasir="+document.getElementById('cmbKasir').value+"&posting="+cmbPost;
		//alert(url);
		a1.loadURL(url,"","GET"); 
	}
	//=========================================
	function VerifikasiJurnal(){
	var no_slip = document.getElementById('noSlip').value;
	var tglSlip = document.getElementById('tgl_slip').value;
	var x = document.getElementById('tgl').value.split("-");
	var tglx = x[2]+'-'+x[1]+'-'+x[0];
	
	var tmp='',idata='';
	var url;
	var url2;
	var nilai='';
		
		//alert(url);
		document.getElementById('btnVerifikasi').disabled=true;
		for (var i=0;i<a1.getMaxRow();i++)
		{
			if (a1.obj.childNodes[0].childNodes[i].childNodes[7].childNodes[0].checked)
			{
				//alert(a1.cellsGetValue(i+1,2));
				/*if (document.getElementById('cmbPost').value==0){
					nilai = document.getElementById('nilai_'+(i+1)).value;
					//alert(nilai);
				
					if (nilai=="") { //Validasi jika nilai slip kosong
						alert("Nilai Slip Tidak Boleh kosong ! ");
						return false;
					}
				}*/
				//nilai = nilai.replace(/\./g,'');
				idata=a1.getRowId(i+1).split("|");//alert(idata);
				tmp+=idata[0]+String.fromCharCode(5)+idata[1]+String.fromCharCode(5)+idata[2]+String.fromCharCode(6);
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
			}
			else
			{
				url="../transaksi/penerimaan_billing_kasir_utils.php?grd=penerimaanBillingKasir&act=verifikasi&idUser=<?php echo $userId; ?>&tanggal="+document.getElementById('tgl').value+"&tanggalSlip="+tglSlip+"&no_slip="+no_slip+"&kasir="+document.getElementById('cmbKasir').value+"&posting="+document.getElementById('cmbPost').value+"&fdata="+tmp;
				//alert(url);
				a1.loadURL(url,"","GET");
			}
		}
		else
		{
			alert("Pilih Data Yg Mau diVerifikasi Terlebih Dahulu !");
		}
		//document.getElementById('btnVerifikasi').disabled=false;
	}
	
	//-================================
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
</script>

</html>