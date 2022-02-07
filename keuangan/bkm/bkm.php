<?php 
	include '../secured_sess.php';
	include("../koneksi/konek.php");
    $tgl=gmdate('d-m-Y',mktime(date('H')+7));
    $th=explode("-",$tgl);
	$userId=$_SESSION['id'];
	$tipe = $_REQUEST['tipe'];

	$pLegend = "BKM";
	$arrBln = array('1'=>'Januari','2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>.: Pengajuan Klaim :.</title>
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
<body>
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
		<div id="fhead">
			<table width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#EAEFF3">
				<tr>
					<td valign="top" style="color:#006699;font-size:11px;"><?php echo $pLegend; ?></td>
				</tr>
				<tr>
					<td valign="top" align="center">
						<table border="0" cellpadding="2" cellspacing="2" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold">
							<tr height="30">
							  <td colspan="2" style="font-size:16px" align="center">BKM</td>
							</tr>
							<tr>
								<td align="center">Bulan</td>
								<td align="left">:&nbsp;
									<select id="bln" name="bln" onChange="fShowMainKlaim()" class="txtinputreg">
										<?php
											foreach($arrBln as $key => $val){
												$selected = ($key == $th[1])?'selected':'';
												echo "<option value='{$key}' {$selected}>{$val}</option>";
											}
										?>
									</select>
								</td>
							</tr>
								<td align="center">Tahun</td>
								<td align="left">:&nbsp;
									<select id="thn" name="thn" onChange="fShowMainKlaim()" class="txtinputreg">
										<?php for ($i=($th[2]-4);$i<($th[2]+1);$i++) { ?>
										<option value="<?php echo $i; ?>" class="txtinput"<?php if ($i==$th[2]) echo "selected";?>><?php echo $i;?></option>
										<?php } ?>
									</select>
								</td>
							</tr>
						</table>
				  </td>
				</tr>
				<tr>
					<td align="center" >
						<table width="900px" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td style="padding-left:10px;">&nbsp;</td>
								<td align="right" style="padding-right:10px;"><BUTTON type="button" id="btnBuatKlaim" onClick="fBuatKlaim();"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle"><span id="spnBtnBuatKlaim">&nbsp;Buat BKM Baru</span></BUTTON>&nbsp;&nbsp;<!--button id="btnRincian" name="btnRincian" type="button" onclick="">Edit Klaim</button--></td>
							</tr>
						</table>
						<fieldset style="width:900px">
							<div id="gridKlaim" style="width:950px; height:370px; background-color:white; overflow:hidden;"></div>
							<div id="pagingKlaim" style="width:950px;"></div>
							</fieldset>
					</td>
				</tr>
				<tr>
					<td>
						<?php include("../footer.php");?>
					</td>
				</tr>
			</table>
		</div>
		<div id="divPopBKM" class="popup" style="width:1010px;height:auto;display:none;">
            <fieldset>
                <legend style="float:right">
                    <div style="float:right; cursor:pointer" class="popup_closebox" onClick="fShowMainKlaim();">
                        <img alt="close" src="../icon/cancel.gif" height="16" width="16" align="absmiddle"/>Tutup</div>
                </legend>
                <table id="tblPopBuatKlaim" width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#EAEFF3" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold"><span id="spnBuatKlaim" style="display:none"></span>
                    <tr height="30">
                      <td colspan="2" style="font-size:16px" align="center">Pembuatan BKM</td>
                    </tr>
                    <tr height="30">
                        <td align="right" width="300" style="padding-right:30px;">Rekening Bank</td>
                        <td align="left">:&nbsp;
                            <select id="cmbRekBank" name="cmbRekBank" class="txtinputreg">
								<?php 
									$sqlRek = "select * from k_ms_rek_bank rb where rb.aktif = 1";
									$qRek = mysql_query($sqlRek);
									while($dRek = mysql_fetch_array($qRek)){
										echo "<option value='".$dRek['id']."'>".$dRek['nama_bank']." - ".$dRek['nama']."</option>";
									}
								?>
							</select>
						</td>
                    </tr>
                    <tr height="30">
                        <td align="right" style="padding-right:30px;">Tanggal Pengajuan</td>
                        <td align="left">:&nbsp;
                            <input id="txtTglPengajuan" name="txtTglPengajuan" readonly size="11" class="txtcenter" type="text" value="<?php echo $tgl; ?>" />&nbsp;
                            <input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onClick="gfPop.fPopCalendar(document.getElementById('txtTglPengajuan'),depRange);"/>
						</td>
                    </tr>
                    <tr height="30">
                        <td align="right" style="padding-right:30px;">No Bukti</td>
                        <td align="left">:&nbsp;
                            <input id="txtNo_bukti" name="txtNo_bukti" size="30" class="txtinputreg" type="text" value="" />
						</td>
                    </tr>
					<tr height="30">
                        <td align="right" style="padding-right:30px;">Terima Dari</td>
                        <td align="left">:&nbsp;
                            <input id="txtTrimaDari" name="txtTrimaDari" class="txtinputreg" size="30" class="txtleft" type="text" value="" />
						</td>
                    </tr>
					<tr height="30">
                        <td align="right" style="padding-right:30px;">Uraian</td>
                        <td align="left">:&nbsp;
                            <input id="txtUraian" name="txtUraian" class="txtinputreg" size="30" class="txtleft" type="text" value="" />
						</td>
                    </tr>
                    <tr>
                    	<td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left" height="50" valign="middle" colspan="2" style="padding-left:300px;">
                        <!--input type="hidden" id="id" name="id" /-->
                            <button id="btnSimpan" name="btnSimpan" class="tblBtn" onClick="fSimpanKlaim()">Simpan</button>
                            <!--button id="btnHapus" name="btnHapus" type="submit" class="tblBtn" onclick="hapus()">Hapus</button-->
                            <button class="tblBtn" onClick="fBatalKlaim()">&nbsp;&nbsp;Batal&nbsp;&nbsp;</button>
                        </td>
                    </tr>
                </table>
				<table id="tblPopPx" style="display:none" width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#EAEFF3">
                    <tr>
                        <td valign="top" align="center">
                            <table border="0" cellpadding="2" cellspacing="2" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold">
                                <tr height="30">
                                  <td colspan="2" style="font-size:16px" align="center">Pembuatan BKM</td>
                                </tr>
								<tr height="30" id="trTxtKSO">
                                    <td width="110" style="padding-left:150px;">No Bukti</td>
                                    <td>:&nbsp;
										<input id="infonobukti" name="infonobukti" size="20" class="txtinputreg" type="text" value="" readonly="readonly" />
									</td>
                                </tr>
								<tr height="30" id="trTxtKSO">
                                    <td width="110" style="padding-left:150px;">Uraian</td>
                                    <td>:&nbsp;
										<input id="infouraian" name="infouraian" size="40" class="txtinputreg" type="text" value="" readonly="readonly" />
									</td>
                                </tr>
                                <tr height="30" id="trTxtKSO">
                                    <td width="110" style="padding-left:150px;">Nama Bank</td>
                                    <td>:&nbsp;
                                        <input id="txtBank" name="txtBank" size="40" class="txtinputreg" type="text" value="" readonly="readonly" />
										<input type="hidden" name="idBKM" id="idBKM"/>
									</td>
                                </tr>
                                <tr id="trPer">
                                    <td style="padding-left:150px">Periode</td>
                                    <td>:&nbsp;
                                        <input id="tglFirst" name="tglFirst" readonly size="11" class="txtcenter" type="text" value="<?php echo $tgl; ?>" />&nbsp;
                                        <input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onClick="gfPop.fPopCalendar(document.getElementById('tglFirst'),depRange,filter);"/>
                                        s.d.
                                        <input id="tglLast" name="tglLast" readonly size="11" class="txtcenter" type="text" value="<?php echo $tgl; ?>" />&nbsp;
                                        <input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onClick="gfPop.fPopCalendar(document.getElementById('tglLast'),depRange,filter);"/>                                </td>
                                </tr>
								<tr>
									<td style="padding-left:150px">Data Penerimaan</td>
									<td>:&nbsp;
										<select name="cmbData" id="cmbData" onChange="filter()" class="txtinputreg">
											<option value="0">-- SEMUA --</option>
											<option value="1">Penerimaan Billing</option>
											<option value="2">Penerimaan Farmasi</option>
											<option value="3">Penerimaan Parkir</option>
											<option value="4">Penerimaan Ambulan</option>
											<option value="5">Penerimaan Diklit</option>
											<option value="6">Penerimaan Lain-Lain</option>
										</select>
									</td>
								</tr>
                            </table>
                      </td>
                    </tr>
                    <tr id="trPen">
                        <td align="center" >
                            <table width="1000px" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding-left:10px;"><select id="cmbPost" name="cmbPost" class="txtinput" style="background-color:#FFFFCC; color:#990000;" onChange="if(this.value==0){document.getElementById('spnBtnVer').innerHTML='&nbsp;Verifikasi';}else{document.getElementById('spnBtnVer').innerHTML='&nbsp;UnVerifikasi';}kirim();">
                                        <option value="0">BELUM VERIFIKASI</option>
                                        <option value="1">PROSES VERIFIKASI</option>
                                    </select></td>
                                    <td align="right" style="padding-right:10px;"><BUTTON type="button" id="btnVerifikasi" onClick="VerifikasiJurnal();"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle"><span id="spnBtnVer">&nbsp;Verifikasi</span></BUTTON></td>
                                </tr>
                            </table>
                            <fieldset style="width:990px">
                                <div id="gridbox" style="width:990px; height:378px; background-color:white;"></div>
                                <div id="paging" style="width:990px; margin-top:30px"></div>
                            </fieldset>
                        </td>
                    </tr>
                </table>
			</fieldset>
		</div>
		
		<?php include("../laporan/report_form.php");?>
	</div>
	<script type="text/javascript">
		var klaim_id = 0;
		var thn = jQuery('#thn').val();
		var bln = jQuery('#bln').val();
		
		function fShowMainKlaim(){
			bln = jQuery('#bln').val();
			thn = jQuery('#thn').val();
			grdKlaim.loadURL("bkm_utils.php?grid=klaim&thn="+thn+"&bln="+bln,"","GET");
			//fBatalKlaim();
		}
		
		function fBuatKlaim(){
			/* var sisip = grdKlaim.getRowId(grdKlaim.getSelRow()).split('|');
            klaim_id = sisip[0]; */
			document.getElementById('txtNo_bukti').value='';
			document.getElementById('txtTrimaDari').value='';
			document.getElementById('txtUraian').value='';
			document.getElementById('tblPopBuatKlaim').style.display='block';
			document.getElementById('tblPopPx').style.display='none';
			document.getElementById('divPopBKM').style.height='auto';
            new Popup('divPopBKM',null,{modal:true,position:'center',duration:0.5})
            $('divPopBKM').popup.show();
			document.getElementById('divPopBKM').style.height='280px';
		}
		
		function fBatalKlaim(){
			$('divPopBKM').popup.hide();
		}
		
		function fSimpanKlaim(){
			var url;
			var rekBank=document.getElementById('cmbRekBank').value;
			var tglBKM=document.getElementById('txtTglPengajuan').value;
			var noBukti=document.getElementById('txtNo_bukti').value;
			var terimaDari=document.getElementById('txtTrimaDari').value;
			var uraian=document.getElementById('txtUraian').value;
			jQuery('#infonobukti').val(noBukti);
			jQuery('#infouraian').val(uraian);
			url="bkm_utils.php?grid=klaim&thn="+thn+"&bln="+bln+"&act=buat_klaim&tglBKM="+tglBKM+"&rekBank="+rekBank+"&no_bukti="+noBukti+"&userId=<?php echo $userId; ?>&terimaDari="+terimaDari+"&uraian="+uraian;
			Request(url ,"spnBuatKlaim", "", "GET",fSimpanKlaimComplete,"noload")
		}
		
		function fSimpanKlaimComplete(){
			var tmpResp=document.getElementById('spnBuatKlaim').innerHTML;
			if (tmpResp!="0"){
				klaim_id=tmpResp;
				jQuery('#idBKM').val(klaim_id);
				var txtBank = jQuery( "#cmbRekBank option:selected" ).text();
				jQuery('#txtBank').val(txtBank);
				document.getElementById('tblPopBuatKlaim').style.display='none';
				document.getElementById('tblPopPx').style.display='block';
				document.getElementById('divPopBKM').style.height='auto';
			}else{
				alert("Buat Pengajuan Klaim Gagal !");
			}
		}
		
		function fEditKlaim(numRow){
			//alert(grdKlaim.getSelRow());
			var sisip = grdKlaim.getRowId(numRow).split('|');
			//alert(sisip);
            klaim_id = sisip[0];
			jQuery('#idBKM').val(sisip[0]);
			jQuery('#cmbRekBank').val(sisip[1]);
			jQuery('#txtBank').val(sisip[4]);
			jQuery('#cmbPost').val(0);
			jQuery('#spnBtnVer').html("&nbsp;Verifikasi");
			jQuery('#infonobukti').val(sisip[3]);
			jQuery('#infouraian').val(sisip[6]);
			document.getElementById('btnVerifikasi').disabled=false;
			document.getElementById('tblPopBuatKlaim').style.display='none';
			document.getElementById('tblPopPx').style.display='block';
			document.getElementById('divPopBKM').style.height='auto';
            new Popup('divPopBKM',null,{modal:true,position:'center',duration:0.5})
            $('divPopBKM').popup.show();
			filter();
		}
		
		function filter(par){
			var tglF = jQuery('#tglFirst').val();
			var tglL = jQuery('#tglLast').val();
			var cmbData = jQuery('#cmbData').val();
			var cmbPost = document.getElementById('cmbPost').value;
			var url = "bkm_utils.php?grid=list&tipe=<?php echo $tipe;?>&tglF="+tglF+"&tglL="+tglL+"&posting="+cmbPost+"&data="+cmbData+"&klaim_id="+klaim_id;
			a.loadURL(url,"","GET");
		}
		
		function fHapusKlaim(id){
			var url;
			//var sisip = grdKlaim.getRowId(grdKlaim.getSelRow()).split('|');
			url="bkm_utils.php?grid=klaim&thn="+thn+"&bln="+bln+"&act=hapus_klaim&klaim_id="+id+"&userId=<?php echo $userId; ?>";
			//alert(url);
			if (confirm('Yakin Ingin Menghapus Data ?')){
				Request(url ,"spnBuatKlaim", "", "GET",function(h){
					alert(h);
					url="bkm_utils.php?grid=klaim&thn="+thn+"&bln="+bln;
					grdKlaim.loadURL(url,"","GET");
				},"noload");
			}
			/* if (sisip[5]=="0"){
				if (sisip[2]=="0"){
					if (confirm('Yakin Ingin Menghapus Data ?')){
						url="bkm_utils.php?grid=klaim&thn="+thn+"&act=hapus_klaim&klaim_id="+sisip[0]+"&userId=<?php echo $userId; ?>";
						//alert(url);
						Request(url ,"spnBuatKlaim", "", "GET",function(h){
							alert(h);
						},"noload")
						//grdKlaim.loadURL(url,"","GET");
					}
				}else{
					alert("Data Pengajuan Klaim Sudah Ada Data Pasiennya, Kosongkan Dulu Jika Ingin Menghapus !");
				}
			}else{
				alert("Data Pengajuan Klaim Sudah Diverifikasi, Jadi Tidak Boleh Dihapus !");
			} */
		}
		
		function chkKlik(p){
			var cekbox=(p==true)?1:0;
			//alert(p);
			for (var i=0;i<a.getMaxRow();i++){
				a.cellsSetValue(i+1,7,cekbox);
			}
		}
		
		function goFilterAndSort(grd){
			var tglF = jQuery('#tglFirst').val();
			var tglL = jQuery('#tglLast').val();
			var cmbPost = document.getElementById('cmbPost').value;
			var cmbData = jQuery('#cmbData').val();
			//alert(grd);
			if(grd == 'gridKlaim'){
				var thn = jQuery('#thn').val();
				var url = "bkm_utils.php?grid=klaim&thn="+thn+"&bln="+bln+"&filter="+grdKlaim.getFilter()+"&sorting="+grdKlaim.getSorting()+"&page="+grdKlaim.getPage();
				grdKlaim.loadURL(url,"","GET");
			} else {
				var url = "bkm_utils.php?grid=list&tipe=<?php echo $tipe;?>&tglF="+tglF+"&tglL="+tglL+"&posting="+cmbPost+"&data="+cmbData+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&klaim_id="+klaim_id;
				a.loadURL(url,"","GET");
			}
        }

		function VerifikasiJurnal(){
			var tglF = jQuery('#tglFirst').val();
			var tglL = jQuery('#tglLast').val();
			var nilai='';
			var tmp='',idata='';
			var url;
			document.getElementById('btnVerifikasi').disabled=true;
			
			for (var i=0;i<a.getMaxRow();i++){
				if (a.obj.childNodes[0].childNodes[i].childNodes[6].childNodes[0].checked){
					if (document.getElementById('cmbPost').value==0){
						//nilai = document.getElementById('nilai_'+(i+1)).value;
					}else{
						nilai='';
					}
					//nilai = nilai.replace(/\./g,'');
					idata=a.getRowId(i+1)+"|"+ValidasiText(nilai);//alert(idata);
					tmp+=idata+String.fromCharCode(6);
				}
				//alert(a1.getRowId(i+1));
			}
			//alert(tmp);
			if (tmp!=""){
				tmp=tmp.substr(0,(tmp.length-1));
				//alert(tmp);
				if (tmp.length>1024){
					alert("Data Yg Mau diPosting Terlalu Banyak !");
					document.getElementById('btnVerifikasi').disabled=false;
				} else {
					var cmbData = jQuery('#cmbData').val();
					url="../bkm/bkm_utils.php?grid=list&act=verifikasi&klaim_id="+klaim_id+"&userId=<?php echo $userId; ?>&tglF="+tglF+"&tglL="+tglL+"&posting="+jQuery('#cmbPost').val()+"&data="+cmbData+"&fdata="+tmp;
					//alert(url);
					a.loadURL(url,"","GET");
					document.getElementById('btnVerifikasi').disabled=false;
				}
			} else {
				alert("Pilih Data Yg Mau diVerifikasi Terlebih Dahulu !");
				document.getElementById('btnVerifikasi').disabled=false;
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
		
		function kirim(){
			var url;
			var cmbPost = document.getElementById('cmbPost').value;
			var tglF = jQuery('#tglFirst').val();
			var tglL = jQuery('#tglLast').val();
			var cmbData = jQuery('#cmbData').val();
			if(cmbPost == '0'){
				document.getElementById('btnVerifikasi').disabled=false;
				document.getElementById('chkAll').disabled=false;
				document.getElementById('chkAll').checked=false;
			} else {
				document.getElementById('btnVerifikasi').disabled=false;
				document.getElementById('chkAll').disabled=false;
				document.getElementById('chkAll').checked=false;
			}
			url="../bkm/bkm_utils.php?grid=list&klaim_id="+klaim_id+"&tglF="+tglF+"&tglL="+tglL+"&posting="+cmbPost+"&data="+cmbData;
			//alert(url);
			a.loadURL(url,"","GET"); 
		}
		
		function lapBKM(id){
			window.open("lap_bkm.php?id="+id, "", "scrollbars=yes, width=1200, height=600, left=0");
		}
		
		function konfirmasi(key,val){
			var tmp;
			//alert(val);
			if (val!=undefined){
				tmp=val.split("|");
				if(tmp[2] == 'klaim'){
					grdKlaim.cellSubTotalSetValue(5,tmp[0]);
				} else {
					a.cellSubTotalSetValue(5,tmp[0]);
				}
			}
		}
		
		var grdKlaim=new DSGridObject("gridKlaim");
        grdKlaim.setHeader("DATA PENGAJUAN BKM");
		grdKlaim.setColHeader("NO, TGL BKM, NO BKM, REKENING BANK, NILAI BKM, TERIMA DARI, URAIAN, PROSES, STATUS");
		grdKlaim.setCellType("txt,txt,txt,txt,txt,txt,txt,txt,txt");
		grdKlaim.setSubTotal(",,,SubTotal :&nbsp;,0,,,,");
		grdKlaim.setIDColHeader(",,no_bkm,nama_bank,,terima_dari,uraian,,");
		grdKlaim.setColWidth("40,90,100,100,100,150,150,100,100");
		grdKlaim.setCellAlign("center,center,center,center,right,left,left,center,center");
		grdKlaim.setSubTotalAlign("center,center,center,center,right,left,left,center,center");
        grdKlaim.setCellHeight(20);
        grdKlaim.setImgPath("../icon");
        grdKlaim.setIDPaging("pagingKlaim");	
        //a.attachEvent("onRowClick","ambilData");
        grdKlaim.onLoaded(konfirmasi);
		grdKlaim.baseURL("bkm_utils.php?grid=klaim&thn="+thn+"&bln="+bln);
		//alert("bkm_utils.php?grid=klaim&thn="+thn);
        grdKlaim.Init();
		
		var tglF = jQuery('#tglFirst').val();
		var tglL = jQuery('#tglLast').val();
		var cmbPost = document.getElementById('cmbPost').value;
		var cmbData = jQuery('#cmbData').val();
		var a=new DSGridObject("gridbox");
        a.setHeader("DATA KUNJUNGAN PASIEN");
		a.setColHeader("NO, PERIHAL, TGL SETOR, NO BUKTI, NILAI, KASIR/PETUGAS, VERIFIKASI<BR><input type='checkbox' name='chkAll' id='chkAll' onClick='chkKlik(this.checked);'>&nbsp;&nbsp;&nbsp;&nbsp;");
		a.setCellType("txt,txt,txt,txt,txt,txt,chk");
		a.setSubTotal(",,,SubTotal :&nbsp;,0,,");
		a.setIDColHeader(",,,no_bukti,,nama,");
		a.setColWidth("30,120,100,120,120,150,50");
		a.setCellAlign("center,center,center,center,right,center,center");
		a.setSubTotalAlign("center,center,center,center,right,center,center");
        a.setCellHeight(20);
        a.setImgPath("../icon");
        a.setIDPaging("paging");
        //a.attachEvent("onRowDblClick","ambilData");
        a.onLoaded(konfirmasi);
		a.baseURL("bkm_utils.php?grid=list&tipe=<?php echo $tipe;?>&tglF="+tglF+"&tglL="+tglL+"&posting="+cmbPost+"&data="+cmbData+"&klaim_id="+klaim_id);
		//alert("bkm_utils.php?grid=1&tipe=<?php echo $tipe;?>&kso="+kso+"&waktu="+timeFil+"&bln="+bln+"&thn="+thn);
        a.Init();
		
		var th_skr = "<?php echo $date_skr[2];?>";
        var bl_skr = "<?php echo ($date_skr[1]<10)?substr($date_skr[1],1,1):$date_skr[1];?>";
		var fromHome=<?php echo $fromHome ?>;
    </script>
    <script src="../report_form.js" type="text/javascript" language="javascript"></script>
</body>
</html>