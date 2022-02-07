<?php
	include '../secured_sess.php';
	include("../koneksi/konek.php");
	$tgl=gmdate('d-m-Y',mktime(date('H')+7));
	$userId=$_SESSION['id'];
	$tipe = $_REQUEST['tipe'];
    $th=explode("-",$tgl);
	$pLegend = "Verifikasi Data -> Penerimaan Diklit";
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>.: Penerimaan Diklit :.</title>
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
	<style type="text/css">
		.tbl
		{ font-family:Arial, Helvetica, sans-serif; 
		  font-size:12px;}
	</style>
	<script type="text/JavaScript">
		var arrRange = depRange = [];
	</script>
</head>
<body bgcolor="#808080" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
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
							<td class="jdltable" height="29" colspan="2">Transaksi Penerimaan Diklit</td>
						</tr>
						<!--tr>
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
						</tr-->
						<tr style="display:none;">
							<td style="padding-right:20px; text-align:right;" height="25">Tgl Penerimaan</td>
							<td>:&nbsp;<input id="tgl" name="tgl" readonly size="11" class="txtcenter" type="text" value="<?php //echo $tgl; ?>" />&nbsp;<input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onClick="gfPop.fPopCalendar(document.getElementById('tgl'),depRange,LoadCmbKasir);"/></td>
						</tr>
						<tr>
							<td style="padding-right:20px; text-align:right;" height="25">Tgl Bayar</td>
							<td>:&nbsp;<input id="tgl_slip" name="tgl_slip" readonly size="11" class="txtcenter" type="text" value="<?php //echo $tgl; ?>" />&nbsp;<input type="button" name="btnTgl_slip" value="&nbsp;V&nbsp;" class="tblBtn" onClick="gfPop.fPopCalendar(document.getElementById('tgl_slip'),depRange);"/></td>
						</tr>
						<tr style="visibility:visible;">
						  <td style="padding-right:20px; text-align:right;" height="25">No Kwitansi</td>
						  <td>:&nbsp;<input id="noSlip" name="noSlip" size="30" class="txtinput"  type="text" value="" /></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><button type="button" id="lihatFilter" name="lihatFilter" onClick="kirim()" >Tampilkan Data</button></td>
						</tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td height="30" style="padding-left:40px;"><select id="cmbPost" name="cmbPost" class="txtinput" style="background-color:#FFFFCC; color:#990000;" onChange="gantiPosting(this.value)">
								<option value="0">BELUM VERIFIKASI</option>
								<option value="1">SUDAH VERIFIKASI</option>
							</select>                    </td>
							<td height="30" align="right" style="padding-right:40px;"><BUTTON type="button" id="btnVerifikasi" onClick="VerifikasiJurnal();"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle"><span id="spnBtnVer">&nbsp;Verifikasi</span></BUTTON></td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								<div id="gridbox" style="width:980px; height:300px; background-color:white;"></div>
								<div id="paging" style="width:980px;"></div>                    </td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr><td><?php include("../footer.php");?></td></tr>
		</table>
	</div>
	<div style="display:none" id="hasilAjax"></div>
	<?php include("../laporan/report_form.php");?>
</body>
<script type="text/javascript">
	var a1 = new DSGridObject("gridbox");
	a1.setHeader("DATA PENERIMAAN DIKLIT");
	a1.setColHeader("No,Tanggal<br />Penerimaan,No Induk,Nama,No  Kwitansi,Jenis Bayar,Periode Bayar,Nilai,Pendanaan,Penerima,VERIF<br/><input type='checkbox' name='chkAll' id='chkAll' onClick='chkKlik(this.checked);'>");
	a1.setCellType("txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,chk");
	a1.setIDColHeader(",byr_tgl,siswa_npm,siswa_nama,byr_kode,byrjns,byr_thn,nilai,sbdana,usr,");
	a1.setColWidth("30,80,100,150,120,100,100,100,100,100,50");
	a1.setCellAlign("center,center,center,left,center,center,center,right,right,left,center");
	a1.setCellHeight(20);
	a1.setImgPath("../icon");
	a1.setIDPaging("paging");
	a1.attachEvent("onRowDblClick","ambilData");
	a1.baseURL("penerimaan_diklit_utils.php?grd=penerimaanDiklit&tanggal="+document.getElementById('tgl').value+"&tanggalSlip="+document.getElementById('tgl_slip').value+"&posting="+document.getElementById('cmbPost').value+"&no_slip="+document.getElementById('noSlip').value); //+"&kasir="+document.getElementById('cmbKasir').value
	a1.Init();
	
	function goFilterAndSort(grd){
	var url;
		if (grd=="gridbox"){
			url="penerimaan_diklit_utils.php?grd=penerimaanDiklit&tanggal="+document.getElementById('tgl').value+"&tanggalSlip="+document.getElementById('tgl_slip').value+"&posting="+document.getElementById('cmbPost').value+"&filter="+a1.getFilter()+"&sorting="+a1.getSorting()+"&page="+a1.getPage()+"&no_slip="+document.getElementById('noSlip').value; //+"&kasir="+document.getElementById('cmbKasir').value
			//alert(url);
			a1.loadURL(url,"","GET");
		}
	}
	
	function VerifikasiJurnal(){
		document.getElementById('btnVerifikasi').disabled=true;
		
		var tmp = "";
		//var v;
		for (var i=0;i<a1.getMaxRow();i++){
			if (a1.obj.childNodes[0].childNodes[i].childNodes[10].childNodes[0].checked)
			{
				idata=a1.getRowId(i+1).split("|");
				//alert(a1.getRowId(i+1));
/* 				if (idata[3]=="1"){
					alert("Data Pembayaran Pasien No KW : "+idata[4]+" Sudah Diposting ke Jurnal Akuntansi\r\nJadi Tidak Boleh DiUnverifikasi");
					document.getElementById('btnVerifikasi').disabled=false;
					return false;
				} */
				tmp+=idata[0]+String.fromCharCode(5)+idata[1]+String.fromCharCode(6);
			}
		}
		
		if (tmp!=""){
			tmp=tmp.substr(0,(tmp.length-1));
			//alert(tmp);
			if (tmp.length>1024)
			{
				alert("Data Yg Mau diPosting Terlalu Banyak !");
				document.getElementById('btnVerifikasi').disabled=false;
			}
			else
			{
				url = "penerimaan_diklit_utils.php?act=verifikasi&idUser=<?php echo $userId; ?>"+"&posting="+document.getElementById('cmbPost').value+"&fdata="+tmp;
				//alert(url);
				Request(url,'hasilAjax',"","GET",function(v){
					//v = document.getElementById('hasilAjax').innerHTML;
					//alert(v);
					if(v == 'sukses'){
						alert('Proses Verifikasi Data Berhasil!');
					} else {
						alert('Proses Verifikasi Data Gagal!');
					}
					kirim();
					document.getElementById('btnVerifikasi').disabled=false;
				},'noload');
			}
		} else {
			alert("Pilih Data Yg Mau diVerifikasi Terlebih Dahulu !");
			document.getElementById('btnVerifikasi').disabled=false;
		}
	}
	
	function ambilData(){
		/* var tmp = a1.getRowId(a1.getSelRow()).split('|');
		bayar_id = tmp[0];
		var url = "penerimaan_diklit_utils.php?grd=penerimaanBillingKasirDetail&bayar_id="+bayar_id;
		//alert(url)
		b.loadURL(url,'','GET');
		new Popup('divPop',null,{modal:true,position:'center',duration:0.5})
		$('divPop').popup.show(); */
	}
	
	function gantiPosting(par){
		//document.getElementById('btnVerifikasi').disabled=false;
		if(par==0){
			document.getElementById('spnBtnVer').innerHTML='&nbsp;Verifikasi';
			document.getElementById('chkAll').disabled = false;
			document.getElementById('btnVerifikasi').disabled = false;
		}else{
			document.getElementById('spnBtnVer').innerHTML='&nbsp;UnVerifikasi';
			document.getElementById('chkAll').disabled = true;
			document.getElementById('btnVerifikasi').disabled = true;
		}
		kirim();
	}
	
	function chkKlik(p){
		var cekbox=(p==true)?1:0;
		//alert(p);
		for (var i=0;i<a1.getMaxRow();i++){
			a1.cellsSetValue(i+1,11,cekbox);
		}
	}
	
	function kirim(){
		var url;
		var cmbPost = document.getElementById('cmbPost').value;

		url="penerimaan_diklit_utils.php?grd=penerimaanDiklit&tanggal="+document.getElementById('tgl').value+"&tanggalSlip="+document.getElementById('tgl_slip').value+"&posting="+cmbPost+"&no_slip="+document.getElementById('noSlip').value; //+"&kasir="+document.getElementById('cmbKasir').value
		//alert(url);
		a1.loadURL(url,"","GET"); 
	}
	
	var th_skr = "<?php echo $date_skr[2];?>";
	var bl_skr = "<?php echo ($date_skr[1]<10)?substr($date_skr[1],1,1):$date_skr[1];?>";
	var fromHome=<?php echo $fromHome ?>;
</script>
<script src="../report_form.js" type="text/javascript" language="javascript"></script>
</html>