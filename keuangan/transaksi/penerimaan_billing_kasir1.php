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
                    <td class="jdltable" height="29" colspan="2">Transaksi Penerimaan Billing Oleh Kasir</td>
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
                  <td style="padding-right:20px; text-align:right;" height="25">Ket / No Slip</td>
                  <td>:&nbsp;<input id="noSlip" name="noSlip" size="30" class="txtinput"  type="text" value="" /></td>
                </tr>
                <tr>
                    <td style="padding-right:20px; text-align:right;" height="25">Tanggal</td>
                    <td>:&nbsp;<input id="tgl" name="tgl" readonly size="11" class="txtcenter" type="text" value="<?php echo $tanggal; ?>" />&nbsp;<input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onClick="gfPop.fPopCalendar(document.getElementById('tgl'),depRange,LoadCmbKasir);"/></td>
                </tr>
                <tr>
                    <td height="30" style="padding-left:75px;"><select id="cmbPost" name="cmbPost" class="txtinput" style="background-color:#FFFFCC; color:#990000;" onChange="if(this.value==0){document.getElementById('btnVerifikasi').disabled=false;}else{document.getElementById('btnVerifikasi').disabled=true;};kirim();">
                        <option value="0">BELUM VERIFIKASI</option>
                        <option value="1">SUDAH VERIFIKASI</option>
                    </select>                    </td>
                    <td height="30" align="right" style="padding-right:75px;"><BUTTON type="button" id="btnVerifikasi" onClick="VerifikasiJurnal();"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Verifikasi</BUTTON></td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <div id="gridbox" style="width:850px; height:300px; background-color:white; overflow:hidden;"></div>
                        <div id="paging" style="width:850px;"></div>                    </td>
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

        <?php include("../laporan/report_form.php");?>
    </body>
<script>//alert("transaksi/utils.php?grd=penerimaanBillingKasir&tanggal="+document.getElementById('tgl').value+"&kasir="+document.getElementById('cmbKasir').value);

	var a1 = new DSGridObject("gridbox");
	a1.setHeader("DATA PENERIMAAN BILLING OLEH KASIR");
	a1.setColHeader("NO,UNIT PELAYANAN,KSO,KASIR,NILAI,VERIFIKASI<BR><input type='checkbox' name='chkAll' id='chkAll' onClick='chkKlik(this.checked);'>&nbsp;&nbsp;&nbsp;&nbsp;");
	//a1.setColHeader("NO,UNIT PELAYANAN,KSO,KASIR,NILAI,VERIFIKASI"+coba(););
	a1.setCellType("txt,txt,txt,txt,txt,chk");
	a1.setSubTotal(",,,SubTotal :&nbsp;,0,");
	a1.setIDColHeader(",unit,kso,,,");
	a1.setColWidth("50,220,220,160,100,50");
	a1.setCellAlign("center,left,left,left,right,center");
	a1.setSubTotalAlign("center,center,center,right,right,left");
	a1.setCellHeight(20);
	a1.setImgPath("../icon");
	a1.setIDPaging("paging");
	a1.onLoaded(konfirmasi);
	//a.attachEvent("onRowClick");
	//alert("../transaksi/utils.php?grd=penerimaanBillingKasir&tanggal="+document.getElementById('tgl').value+"&kasir="+document.getElementById('cmbKasir').value+"&posting="+document.getElementById('cmbPost').value);
	a1.baseURL("../transaksi/utils.php?grd=penerimaanBillingKasir&tanggal="+document.getElementById('tgl').value+"&kasir="+document.getElementById('cmbKasir').value+"&posting="+document.getElementById('cmbPost').value);
	a1.Init();

	function konfirmasi(key,val){
	var tmp;
		//alert(val+'-'+key);
		document.getElementById('chkAll').checked=false;
		if (val!=undefined){
			tmp=val.split(String.fromCharCode(3));
			a1.cellSubTotalSetValue(5,tmp[1]);
			if(key=='Error'){
				if(tmp[0]=='verifikasiPenerimaanBillingKasir'){
					alert('Terjadi Error dlm Proses Posting !');
				}
			}else{
				if(tmp[0]=='verifikasiPenerimaanBillingKasir'){
					alert('Proses Posting Berhasil !');
				}
			}
		}
		//setSubTotal();
	}
	
	function setSubTotal(){
		var brs = a1.getMaxRow();
		//alert(brs);
		var zxc,cxz;
		var jml=0;
		for(var i=1;i<=brs;i++){
			cxz = a1.getRowId(i);
			zxc = cxz.split('|');
			//alert(zxc[3]);
			jml = jml + parseInt(zxc[3]);
		}

		a1.cellSubTotalSetValue(5,jml);
	}
	
	function goFilterAndSort(grd){
	var url;
		//alert(grd);
		if (grd=="gridbox"){		
			url="../transaksi/utils.php?grd=penerimaanBillingKasir&tanggal="+document.getElementById('tgl').value+"&kasir="+document.getElementById('cmbKasir').value+"&posting="+document.getElementById('cmbPost').value+"&filter="+a1.getFilter()+"&sorting="+a1.getSorting()+"&page="+a1.getPage();
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
		url="../transaksi/utils.php?grd=loadkasir&tanggal="+document.getElementById('tgl').value+"&kasir="+document.getElementById('cmbKasir').value+"&posting="+document.getElementById('cmbPost').value;
		Request(url,'cmbKasir',"","GET",kirim,'noload');
		//alert(url);
	}
	
	function kirim(){
		var x = document.getElementById('cmbPost').value;
		//alert(x);
		if(x=='1')
		{
			a1.setColHeader("NO,UNIT PELAYANAN,KSO,KASIR,NILAI,VERIFIKASI");
			a1.setColWidth("50,220,220,160,100,50");
			a1.setCellTypeLagi("txt,txt,txt,txt,txt,txt");
		}
		else
		{
			a1.setColHeader("NO,UNIT PELAYANAN,KSO,KASIR,NILAI,VERIFIKASI<BR><input type='checkbox' name='chkAll' id='chkAll' onClick='chkKlik(this.checked);'>&nbsp;&nbsp;&nbsp;&nbsp;");
			a1.setColWidth("50,220,220,160,100,50");
			a1.setCellType("txt,txt,txt,txt,txt,chk");
		}
		
		
	var url;
		url="../transaksi/utils.php?grd=penerimaanBillingKasir&tanggal="+document.getElementById('tgl').value+"&kasir="+document.getElementById('cmbKasir').value+"&posting="+document.getElementById('cmbPost').value;
		a1.loadURL(url,"","GET");
		//alert(url);
		
		//setSubTotal();
		
	}
	
	function VerifikasiJurnal(){
	var no_slip = document.getElementById('noSlip').value;
	var x = document.getElementById('tgl').value.split("-");
	var tglx = x[2]+'-'+x[1]+'-'+x[0];
	
	var tmp='',idata='';
	var url;
		url="../transaksi/utils.php?grd=penerimaanBillingKasir&tanggal="+document.getElementById('tgl').value+"&kasir="+document.getElementById('cmbKasir').value+"&posting="+document.getElementById('cmbPost').value+"&idUser=<?php echo $iduser; ?>&noSlip="+document.getElementById('noSlip').value;
		
		for (var i=0;i<a1.getMaxRow();i++){
			if (a1.obj.childNodes[0].childNodes[i].childNodes[5].childNodes[0].checked){
				//alert(a1.cellsGetValue(i+1,2));
				idata=a1.getRowId(i+1).split("|");//alert(idata);
				tmp+=idata[0]+String.fromCharCode(5)+idata[1]+String.fromCharCode(5)+idata[2]+String.fromCharCode(5)+idata[3]+String.fromCharCode(5)+tglx+String.fromCharCode(5)+no_slip+String.fromCharCode(6);
				alert(tmp);
			}
		}
		if (tmp!=""){
			tmp=tmp.substr(0,(tmp.length-1));
			//alert(tmp.length);
			if (tmp.length>1024){
				alert("Data Yg Mau diPosting Terlalu Banyak !");
			}else{
				url+="&act=verifikasiPenerimaanBillingKasir&fdata="+tmp;
				alert(url);
				a1.loadURL(url,"","GET");
			}
		}else{
			alert("Pilih Data Yg Mau diVerifikasi Terlebih Dahulu !");
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
</script>

</html>