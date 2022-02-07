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

$pLegend = "Verifikasi Data -> Penerimaan Kasir -> Penerimaan Kasir Farmasi";

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
                                <td class="jdltable" height="29" colspan="2">Transaksi Penerimaan Kasir Farmasi</td>
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
                                <td width="120" style="padding-right:20px; text-align:right;" height="25">Nama KSO</td>
                                <td>:&nbsp;<select id="cmbKSO" name="cmbKSO" class="txtinput" onChange="kirim()">
                                    <option style="text-transform:uppercase" value="0">SEMUA</option>
                                    <?php
                                        $qkso=mysql_query("SELECT $dbapotek.a_mitra.IDMITRA id, $dbapotek.a_mitra.kso_id_billing, $dbapotek.a_mitra.NAMA nama FROM $dbapotek.a_mitra WHERE AKTIF=1");
                                        while($wKso = mysql_fetch_array($qkso)){
                                    ?>
                                    <option style="text-transform:uppercase" value="<?php echo $wKso['kso_id_billing'];?>" lang="<?php echo $wKso['id'];?>"><?php echo $wKso['nama'];?></option>
                                    <?php
                                        }
                                    ?>
                                </select></td>
                            </tr>
                            <tr>
                                <td width="40%" style="padding-right:20px; text-align:right;" height="25">Unit Farmasi</td>
                                <td>:&nbsp;<select id="cmbFarmasi" name="cmbFarmasi" class="txtinput" onChange="kirim()">
                                    <!--<option value="0" <?php if($tempat==0){ echo "selected";}?>>SEMUA</option>-->
                                    <?php
                                        $qTmp = mysql_query("SELECT * FROM ".$dbapotek.".a_unit WHERE UNIT_TIPE=2 AND UNIT_ISAKTIF=1");
                                        while($wTmp = mysql_fetch_array($qTmp)){
                                    ?>
                                    <option value="<?php echo $wTmp['UNIT_ID'];?>" <?php if($tempat==$wTmp['UNIT_ID']){ echo "selected";}?>><?php echo $wTmp['UNIT_NAME'];?></option>
                                    <?php	}	?>
                                </select></td>
                            </tr>
                            <tr>
                                <td width="40%" style="padding-right:20px; text-align:right;" height="25">Shift</td>
                                <td>:&nbsp;<select id="cmbShift" name="cmbShift" class="txtinput" onChange="kirim()">
                                    <option value="0">SEMUA&nbsp;</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select></td>
                            </tr>
                            <tr>
                                <td style="padding-right:20px; text-align:right;" height="25">Tgl Penerimaan</td>
                                <td>:&nbsp;<input id="tgl" name="tgl" readonly size="11" class="txtcenter" type="text" value="<?php echo $tanggal; ?>" />&nbsp;<input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onClick="gfPop.fPopCalendar(document.getElementById('tgl'),depRange,Loadkirim);"/></td>
                            </tr>
                            <tr>
                                <td style="padding-right:20px; text-align:right;" height="25">Tgl Setor</td>
                                <td>:&nbsp;<input id="tglSlip" name="tglSlip" readonly size="11" class="txtcenter" type="text" value="<?php echo $tanggal; ?>" />&nbsp;<input type="button" name="btnTglSlip" value="&nbsp;V&nbsp;" class="tblBtn" onClick="gfPop.fPopCalendar(document.getElementById('tglSlip'),depRange,Nothing);"/></td>
                            </tr>
                            <tr>
                              <td style="padding-right:20px; text-align:right;" height="25">Ket / No Slip</td>
                              <td>:&nbsp;<input id="noSlip" name="noSlip" size="30" class="txtinput"  type="text" value="" /></td>
                            </tr>
                        </table>
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td height="30" style="padding-left:20px;"><select id="cmbPost" name="cmbPost" class="txtinput" style="background-color:#FFFFCC; color:#990000;" onChange="if (this.value=='1'){document.getElementById('spnVerif').innerHTML='UnVerifikasi';}else{document.getElementById('spnVerif').innerHTML='Verifikasi';};kirim();">
                                    <option value="0">BELUM VERIFIKASI</option>
                                    <option value="1">SUDAH VERIFIKASI</option>
                                </select>                    </td>
                                <td height="30" align="right" style="padding-right:20px;"><BUTTON type="button" id="btnVerifikasi" onClick="VerifikasiJurnal();"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;<span id="spnVerif">Verifikasi</span></BUTTON></td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                    <div id="gridbox" style="width:990px; height:300px; background-color:white;"></div>
                                    <div id="paging" style="width:990px;"></div>                    </td>
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
        <div id="divPopProgressBar" class="popup" style="width:300px;height:100px;display:none;">
            <fieldset>
                <legend style="float:right; display:none;">
                    <div style="float:right; cursor:pointer" class="popup_closebox">
                        <img alt="close" src="../icon/cancel.gif" height="16" width="16" align="absmiddle"/>Tutup</div>
                </legend>
                <table>
                    <tr>
                    	<td>Proses Verifikasi :&nbsp;</td>
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
            <span id="hasilAjax" style="display:none;"></span>
        </div>
        <?php include("../laporan/report_form.php");?>
    </body>
<script>
	var a1 = new DSGridObject("gridbox");
	a1.setHeader("DATA TRANSAKSI PENERIMAAN KASIR FARMASI");
	a1.setColHeader("NO,NO KW,NO SLIP,NO RM,NAMA PASIEN,PENJAMIN,RUANGAN,SHIFT,NILAI,NILAI HPP,PILIH<BR><input type='checkbox' name='chkAll' id='chkAll' onClick='chkKlik(this.checked);'>&nbsp;&nbsp;");
	//a1.setColHeader("NO,UNIT PELAYANAN,KSO,KASIR,NILAI,VERIFIKASI"+coba(););
	a1.setCellType("txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,chk");
	a1.setSubTotal(",,,,,,SubTotal :&nbsp;,,0,0,");
	a1.setIDColHeader(",ap.NO_PENJUALAN,kt.no_bukti,ap.NO_PASIEN,ap.NAMA_PASIEN,am.NAMA,aunit.UNIT_NAME,ap.SHIFT,,,");
	a1.setColWidth("30,90,120,60,140,120,120,35,80,80,35");
	a1.setCellAlign("center,center,center,center,left,center,center,center,right,right,center");
	a1.setSubTotalAlign("center,center,center,center,center,right,right,right,right,right,left");
	a1.setCellHeight(20);
	a1.setImgPath("../icon");
	a1.setIDPaging("paging");
	a1.onLoaded(konfirmasi);
	//alert("penerimaan_penjualan_obat_utils.php?grd=penerimaanPenjualanObat&tanggal="+document.getElementById('tgl').value+"&kso="+document.getElementById('cmbKSO').value+"&cmbFarmasi="+document.getElementById('cmbFarmasi').value+"&posting="+document.getElementById('cmbPost').value);
	a1.baseURL("penerimaan_penjualan_obat_utils.php?grd=penerimaanPenjualanObat&tanggal="+document.getElementById('tgl').value+"&kso="+document.getElementById('cmbKSO').value+"&cmbFarmasi="+document.getElementById('cmbFarmasi').value+"&posting="+document.getElementById('cmbPost').value+"&shift="+document.getElementById('cmbShift').value);
	a1.Init();

	function konfirmasi(key,val){
	var tmp;
		//alert(val);
		if (document.getElementById('chkAll')){
			document.getElementById('chkAll').checked=false;
		}
		// alert(val);
		if (val!=undefined){
			tmp=val.split("|");
			//alert(tmp[1]+' '+tmp[2]+' '+tmp[3]);
			a1.cellSubTotalSetValue(9,tmp[2]);
			a1.cellSubTotalSetValue(10,tmp[3]);
			if(key=='Error'){
				if(tmp[0]=='Verif_Penerimaan_Kasir_Farmasi'){
					alert('Terjadi Error dlm Proses Verifikasi !');
				}
			}else{
				if(tmp[0]=='Verif_Penerimaan_Kasir_Farmasi'){
					//alert('Proses Verifikasi Berhasil !');
					alert(tmp[4]);
				}
				/*if(tmp[0]=='Verif_Penerimaan_Kasir_Farmasi' && document.getElementById('cmbPost').value=='0'){
					//alert('Proses Verifikasi Berhasil !');
					alert(tmp[4]);
				}
				else if(tmp[0]=='Verif_Penerimaan_Kasir_Farmasi' && document.getElementById('cmbPost').value=='1'){
					//alert('Proses unVerifikasi Gagal !. Transaksi sudah diposting, jadi tidak bisa unVerifikasi.');
					alert(tmp[4]);
				}*/
			}
		}
		document.getElementById('btnVerifikasi').disabled=false;
	}
		
	function goFilterAndSort(grd){
	var url;
		//alert(grd);
		if (grd=="gridbox")
		{		
			url="penerimaan_penjualan_obat_utils.php?grd=penerimaanPenjualanObat&tanggal="+document.getElementById('tgl').value+"&kso="+document.getElementById('cmbKSO').value+"&cmbFarmasi="+document.getElementById('cmbFarmasi').value+"&posting="+document.getElementById('cmbPost').value+"&shift="+document.getElementById('cmbShift').value+"&filter="+a1.getFilter()+"&sorting="+a1.getSorting()+"&page="+a1.getPage();
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
	
	function Nothing(){
	}
	
	function Loadkirim(){
		document.getElementById('tglSlip').value=document.getElementById('tgl').value;
		kirim();
	}
	
	function kirim(){
		var url;
		url="penerimaan_penjualan_obat_utils.php?grd=penerimaanPenjualanObat&tanggal="+document.getElementById('tgl').value+"&kso="+document.getElementById('cmbKSO').value+"&cmbFarmasi="+document.getElementById('cmbFarmasi').value+"&posting="+document.getElementById('cmbPost').value+"&shift="+document.getElementById('cmbShift').value;
		// alert(url);
		a1.loadURL(url,"","GET");
	}
	//=========================================
	var pdata,iter,cancelP;
	
	function VerifikasiJurnal(){
	var no_slip = document.getElementById('noSlip').value;
	var x = document.getElementById('tgl').value.split("-");
	var tglx = x[2]+'-'+x[1]+'-'+x[0];
	
	var tmp='',idata='';
	var tmp2='';
	var url;
	var url2;
	
		//alert(url);
		if ((document.getElementById('cmbPost').value==0) && (no_slip=='')){
			alert('No Bukti Slip Harus Diisi !');
			document.getElementById('noSlip').focus();
			return false;
		}
		
		document.getElementById('btnVerifikasi').disabled=true;
		
		for (var i=0;i<a1.getMaxRow();i++)
		{
			//alert(a1.obj.childNodes[0].childNodes[i].childNodes[11].childNodes[0].checked);
			if (a1.obj.childNodes[0].childNodes[i].childNodes[10].childNodes[0].checked)
			{
				//alert(a1.cellsGetValue(i+1,2));
				idata=a1.getRowId(i+1);//alert(idata);
				/*var nilai='';
				if(document.getElementById('cmbPost').value==0){
					nilai= document.getElementById('nilai_'+(i+1)).value;//alert(nilai);
					
					if (nilai=="") { //Validasi jika nilai slip kosong
						alert("Nilai Slip Tidak Boleh kosong ! ");
						return false;
					}
					nilai = nilai.replace(/\./g,'');
				}
				else{
					nilai = idata[6];
				}*/
				
				if (document.getElementById('cmbPost').value==0){
					tmp+=idata+String.fromCharCode(6);
				}else{
					tmp+=idata+String.fromCharCode(6);
				}
			}
		}
		if (tmp!="")
		{
			tmp=tmp.substr(0,(tmp.length-1));
			//alert(tmp);
			/*if (tmp.length>1024)
			{
				if (document.getElementById('cmbPost').value==0){
					alert("Data Yg Mau diVerifikasi Terlalu Banyak !");
				}else{
					alert("Data Yg Mau diUnVerifikasi Terlalu Banyak !");
				}
				document.getElementById('btnVerifikasi').disabled=false;
				return false;
			}
			else
			{*/
				//====tambahan u/ progress bar====
				new Popup('divPopProgressBar',null,{modal:true,position:'center',duration:0.5})
				$('divPopProgressBar').popup.show();
				pdata=tmp.split(String.fromCharCode(6));
				iter=1;
				cancelP=0;
				fProgressExecute();
				/*tmp=tmp.split(String.fromCharCode(6));
				for (var i=0;i<tmp.length;i++){
					url="penerimaan_penjualan_obat_utils.php?grd=penerimaanPenjualanObat&act=Verif_Penerimaan_Kasir_Farmasi&idUser=24&tanggal="+document.getElementById('tgl').value+"&kso="+document.getElementById('cmbKSO').value+"&cmbFarmasi="+document.getElementById('cmbFarmasi').value+"&posting="+document.getElementById('cmbPost').value+"&shift="+document.getElementById('cmbShift').value+"&tanggalSlip="+document.getElementById('tglSlip').value+"&no_slip="+no_slip+"&userId=<?php echo $userId; ?>"+"&fdata="+tmp;
					//alert(url);
					//a1.loadURL(url,"","GET");
					document.getElementById('spnProgress').innerHTML="Proses : "+(i+1)+" dari "+tmp.length;
				}*/
			//}
		}
		else
		{
			if (document.getElementById('cmbPost').value==0){
				alert("Pilih Data Yg Mau diVerifikasi Terlebih Dahulu !");
			}else{
				alert("Pilih Data Yg Mau diUnVerifikasi Terlebih Dahulu !");
			}
			document.getElementById('btnVerifikasi').disabled=false;
			return false;
		}
	}
	
	function fProgressExecute(){
		var no_slip = document.getElementById('noSlip').value;
		var url;
		document.getElementById('spnProgress').innerHTML="Proses : "+iter+" dari "+pdata.length;
		url="penerimaan_penjualan_obat_utils.php?act=Verif_Penerimaan_Kasir_Farmasi_progress&idUser=24&tanggal="+document.getElementById('tgl').value+"&kso="+document.getElementById('cmbKSO').value+"&cmbFarmasi="+document.getElementById('cmbFarmasi').value+"&posting="+document.getElementById('cmbPost').value+"&shift="+document.getElementById('cmbShift').value+"&tanggalSlip="+document.getElementById('tglSlip').value+"&no_slip="+no_slip+"&userId=<?php echo $userId; ?>"+"&fdata="+pdata[iter-1];
		Request(url,'hasilAjax',"","GET",function(v){
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
	
	var t=0;
	function setSubTotal()
	{
		var halaman = a1.getPage();
		var txtnilai;
		//alert(halaman);
		if(a1.getRowId(1)=="")
		{
			a1.cellSubTotalSetValue(6,0);
		}
		else
		{
		var tot = 0;
		for(var i=1;i<=a1.getMaxRow();i++){
			//var id = a1.getRowId(i);
			txtnilai = (halaman-1)*100+i;
			//alert(txtnilai);
			//alert(document.getElementById('nilai_'+((1-1)*100)+1).value);
			if(document.getElementById('nilai_'+txtnilai).value!=''){
				r=document.getElementById('nilai_'+txtnilai).value;
				while (r.indexOf(".")>-1){
					r=r.replace(".","");
				}
				tot = tot + parseFloat(r);
			}
		}
		
		t=FormatNumberFloor(tot,".");
		a1.cellSubTotalSetValue(6,t);
		}
		//document.getElementById('nilai').value = t;
	}
	
	function setSubTotal2()
	{
		if(a1.getRowId(1)=="")
		{
			a1.cellSubTotalSetValue(5,0);
		}
		else
		{
			var tot2 = 0;
			for(var i=1;i<=a1.getMaxRow();i++){
				var xx = a1.getRowId(i).split("|");
				if(xx[3]!=''){
					r2=xx[3];
					while (r2.indexOf(".")>-1){
						r2=r2.replace(".","");
					}
					tot2 = tot2 + parseFloat(r2);
				}
			}
			//alert(a1.getRowId(1));
			t2=FormatNumberFloor(tot2,".");//alert(t2);
			a1.cellSubTotalSetValue(5,t2);
		}	
	}
	function setSubTotal3()
	{
		if(a1.getRowId(1)=="")
		{
			a1.cellSubTotalSetValue(5,0);
		}
		else
		{
			var tot2 = 0;
			for(var i=1;i<=a1.getMaxRow();i++){
				var xx = a1.getRowId(i).split("|");
				if(xx[4]!=''){
					r2=xx[4];
					while (r2.indexOf(".")>-1){
						r2=r2.replace(".","");
					}
					tot2 = tot2 + parseFloat(r2);
				}
			}
			//alert(a1.getRowId(1));
			t2=FormatNumberFloor(tot2,".");//alert(t2);
			a1.cellSubTotalSetValue(5,t2);
		}
	}
	function setSubTotal4(){
		if(a1.getRowId(1)=="")
		{
			a1.cellSubTotalSetValue(6,0);
		}
		else
		{
		var tot2 = 0;
		for(var i=1;i<=a1.getMaxRow();i++){
			var xx = a1.getRowId(i).split("|");
			if(xx[3]!=''){
				r2=xx[3];
				while (r2.indexOf(".")>-1){
					r2=r2.replace(".","");
				}
				tot2 = tot2 + parseFloat(r2);
			}
		}
		//alert(a1.getRowId(1));
		t2=FormatNumberFloor(tot2,".");//alert(t2);
		a1.cellSubTotalSetValue(6,t2);
		}
	}
	
	
var th_skr = "<?php echo $date_skr[2];?>";
var bl_skr = "<?php echo ($date_skr[1]<10)?substr($date_skr[1],1,1):$date_skr[1];?>";
var fromHome=<?php echo $fromHome ?>;
</script>
<script src="../report_form.js" type="text/javascript" language="javascript"></script>
</html>