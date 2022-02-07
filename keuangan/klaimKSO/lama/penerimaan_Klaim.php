<?php
//include("../sesi.php");
include '../secured_sess.php';
$userId=$_SESSION['id'];
$tipe = $_REQUEST['tipe'];
$caption = ($tipe==1)?'RAWAT JALAN':(($tipe==2)?'RAWAT INAP':(($tipe==3)?'IGD':'PER UNIT'));

$pLegend = "Klaim KSO/Piutang -> Penerimaan Klaim";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <title>.: Penerimaan Klaim :.</title>
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
        	<div>
            <table width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#EAEFF3">
                <tr>
                    <td valign="top" style="color:#006699;font-size:11px;"><?php echo $pLegend; ?></td>
                </tr>
                <tr>
                    <td valign="top" align="center">
                        <table border="0" cellpadding="2" cellspacing="2" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold">
                            <tr height="30">
                              <td colspan="2" style="font-size:16px" align="center">Penerimaan Klaim KSO</td>
                            </tr>
                            <tr>
                                <td align="center">
                                    Tahun                                </td>
                                <td align="center">:&nbsp;
                                    <select id="thn" name="thn" onchange="filter()" class="txtinputreg">
                                        <?php
                                        for ($i=($th[2]-4);$i<($th[2]+1);$i++) {
                                            ?>
                                        <option value="<?php echo $i; ?>" class="txtinput"<?php if ($i==$th[2]) echo "selected";?>><?php echo $i;?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>                                </td>
                            </tr>
                        </table>
                  </td>
                </tr>
                <tr>
                    <td align="center" >
                        <table width="990px" border="0" cellpadding="0" cellspacing="0">
                        	<tr>
                            	<td style="padding-left:10px;"><!--select id="cmbPost" name="cmbPost" class="txtinput" style="background-color:#FFFFCC; color:#990000;" onChange="if(this.value==0){document.getElementById('spnBtnVer').innerHTML='&nbsp;Verifikasi';}else{document.getElementById('spnBtnVer').innerHTML='&nbsp;UnVerifikasi';};kirim();">
                                    <option value="0">BELUM VERIFIKASI</option>
                                    <option value="1">SUDAH VERIFIKASI</option>
                                </select--></td>
                                <td align="right" style="padding-right:10px;"><BUTTON type="button" id="btnBuatKlaimTerima" onClick="fBuatKlaimTerima();"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle"><span id="spnBtnBuatKlaimTerima">&nbsp;Buat Penerimaan Klaim</span></BUTTON>&nbsp;&nbsp;<!--button id="btnRincian" name="btnRincian" type="button" onclick="">Edit Klaim</button--></td>
                            </tr>
                        </table>
                        <fieldset style="width:990px">
                            <div id="gridKlaimTerima" style="width:990px; height:370px; background-color:white; overflow:hidden;"></div>
                            <div id="pagingKlaimTerima" style="width:990px;"></div>
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
        	<div id="divPopPx" class="popup" style="width:1010px;height:auto;display:none;">
            <fieldset>
                <legend style="float:right">
                    <div style="float:right; cursor:pointer" class="popup_closebox" onclick="fShowMainKlaimTerima();">
                        <img alt="close" src="../icon/cancel.gif" height="16" width="16" align="absmiddle"/>Tutup</div>
                </legend>
                <table id="tblPopBuatKlaim" width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#EAEFF3" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold"><span id="spnBuatKlaim" style="display:none"></span>
                    <tr height="30">
                      <td colspan="2" style="font-size:16px" align="center">Penerimaan Klaim KSO</td>
                    </tr>
                    <tr height="30">
                        <td align="right" width="200" style="padding-right:30px;">Nama KSO</td>
                        <td align="left">:&nbsp;
                            <select id="cmbKsoBuatKlaimTerima" name="cmbKsoBuatKlaimTerima" class="txtinputreg" onchange="cmbKsoBuatKlaimTerimaChange()"></select></td>
                    </tr>
                    <tr height="30">
                        <td align="right" style="padding-right:30px;">Tanggal Penerimaan</td>
                        <td align="left">:&nbsp;
                            <input id="txtTglPenerimaan" name="txtTglPenerimaan" readonly size="11" class="txtcenter" type="text" value="<?php echo $tgl; ?>" />&nbsp;
                            <input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('txtTglPenerimaan'),depRange);"/>                                </td>
                    </tr>
                    <tr height="30">
                        <td align="right" style="padding-right:30px;">No Bukti Penerimaan</td>
                        <td align="left">:&nbsp;
                            <input id="txtNoBuktiPenerimaan" name="txtNoBuktiPenerimaan" size="30" class="txtleft" type="text" value="" />                                </td>
                    </tr>
                    <tr height="30">
                        <td align="right" style="padding-right:30px;">No Bukti Pengajuan
                        <div id="div_klaim" style="width:auto;height:auto;overflow:auto;display:none;position:absolute"></div></td>
                        <td align="left">:&nbsp;
                            <input id="txtNoBuktiPengajuan" name="txtNoBuktiPengajuan" size="30" class="txtleft" type="text" value="" readonly="readonly" />&nbsp;<input type="button" id="btnShowNo_Pengajuan" name="btnShowNo_Pengajuan" value="&nbsp;Pilih&nbsp;" class="tblBtn" onclick="fPilihNoPengajuan();"/></td>
                    </tr>
                    <tr>
                    	<td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left" height="50" valign="middle" colspan="2" style="padding-left:300px;">
                        <!--input type="hidden" id="id" name="id" /-->
                            <button id="btnSimpan" name="btnSimpan" class="tblBtn" onclick="fSimpanKlaimTerima()">Simpan</button>
                            <!--button id="btnHapus" name="btnHapus" type="submit" class="tblBtn" onclick="hapus()">Hapus</button-->
                            <button class="tblBtn" onclick="fBatalKlaimTerima()">&nbsp;&nbsp;Batal&nbsp;&nbsp;</button>
                        </td>
                    </tr>
                </table>
                <table id="tblPopPx" style="display:none" width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#EAEFF3">
                    <tr>
                        <td valign="top" align="center">
                            <table border="0" cellpadding="2" cellspacing="2" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold">
                                <tr height="30">
                                  <td colspan="2" style="font-size:16px" align="center">Penerimaan Klaim KSO</td>
                                </tr>
                                <tr id="trTxtKSO">
                                    <td width="150" style="padding-left:30px;">Nama KSO</td>
                                    <td>:&nbsp;
                                        <input id="txtKso" name="txtKso" size="35" class="txtleft" type="text" value="" readonly="readonly" /></td>
                                </tr>
                                <tr>
                                    <td style="padding-left:30px;">No Bukti Pengajuan</td>
                                    <td>:&nbsp;
                                        <input id="txtNoBuktiPengajuanLbl" name="txtNoBuktiPengajuanLbl" size="30" class="txtleft" type="text" value="" readonly="readonly" /></td>
                                </tr>
                                <tr>
                                    <td style="padding-left:30px;">No Bukti Penerimaan</td>
                                    <td>:&nbsp;
                                        <input id="txtNoBuktiPenerimaanLbl" name="txtNoBuktiPenerimaanLbl" size="30" class="txtleft" type="text" value="" readonly="readonly" /></td>
                                </tr>
								<tr>
									<td style="padding-left:30px;">
										<input type="checkbox" name="impo" id="impo" style="cursor:pointer;" onchange="cekImp(this.checked)"/>
										<label style="cursor:pointer;" for="impo">&nbsp;Import Data</label>
									</td>
									<td>
										<style type="text/css">
											#uploadForm {border-top:#F0F0F0 2px solid; background:#FAF8F8; padding:2px; border-right:2px solid #FAF8F8; margin-top:5px;}
											#uploadForm label {margin:2px; font-size:1em; font-weight:bold;}
											.demoInputBox{padding:2px; border:#F0F0F0 1px solid; border-radius:4px; background-color:#FFF;}
											#progress-bar {background-color: #0099FF; height:30px; width:0%; -webkit-transition: width .3s; -moz-transition: width .3s; transition: width .3s; position:absolute; max-width:100%; }
											#progress-status { color:#000; position:absolute; top:5px; width:100%; }
											.btnSubmit{background-color:#09f;border:0;padding:4px 15px;color:#FFF;border:#F0F0F0 1px solid; border-radius:4px; cursor:pointer; }
											.btnSubmit:disabled{ background:#EFEFEF; border:1px solid #D9D9D9; color: #797C80; padding:4px 15px; }
											#progress-div { text-align:center; position:relative; width:100%; border: 1px solid #0099FF;}
											#targetLayer{width:100%;text-align:center;}
										</style>
										<div id="div-form" style="text-align:center;">
											<form name="uploadForm" id="uploadForm" enctype="multipart/form-data" method="post">
												<input type="file" class="demoInputBox" name="fileU" id="fileU" accept="text/plain, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
												<input type="button" name="upload" class="btnSubmit" value="Import" id="upload" onclick="uploadFile()"/>
											</form>
											<div id="progress-div">
												<div id="progress-bar"></div>
												<div id="progress-status"></div>
											</div>
										</div>
									</td>
								</tr>
								<tr><td colspan="2" >&nbsp;</td></tr>
								<tr><td colspan="2" >&nbsp;</td></tr>
								<tr><td>&nbsp;</td><td id="hasilTxt" style="font-weight:normal;" >&nbsp;</td></tr>
                            </table>
                      </td>
                    </tr>
                    <tr>
                        <td valign="top" align="center">&nbsp;</td>
                    </tr>
                    <tr id="trPen">
                        <td align="center" >
                            <table width="1000px" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding-left:10px;">
										<select id="cmbPost" name="cmbPost" class="txtinput" style="background-color:#FFFFCC; color:#990000;" onChange="fcmbPostChange(this)">
											<option value="0">BELUM PENERIMAAN&nbsp;</option>
											<option value="1">SUDAH PENERIMAAN&nbsp;</option>
											<option value="2">BELUM PENERIMAAN FILE IMPORT&nbsp;</option>
										</select>
										<button id="cetakImport" style="display:none;" onclick="cetakImp();"><img src="../icon/printer.png" width='16px' align='absmiddle' alt="Cetak Import" />&nbsp;Cetak</button>
									</td>
                                    <td align="right" style="padding-right:10px;">
                                    	<span id="spnCmbProses">Status :&nbsp;
                                    	<select id="CmbProses">
                                        	<option value="1">Sudah Lunas&nbsp;</option>
                                            <option value="2">Belum Lunas&nbsp;</option>
                                            <option value="3">Disusulkan&nbsp;</option>
                                        </select>&nbsp;</span>
                                    	<BUTTON type="button" id="btnVerifikasi" onClick="VerifikasiJurnal();"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle"><span id="spnBtnVer">&nbsp;Verifikasi</span></BUTTON>
										<button id="hapusImport" style="display:none;" onclick="hapusImport();"><img src="../icon/printer.png" width='16px' align='absmiddle' alt="Cetak Import" />&nbsp;Hapus Import</button>
                                    </td>
                                </tr>
                            </table>
                            <fieldset style="max-width:100%;">
                                <div id="gridbox" style="width:990px; height:440px; background-color:white; overflow:hidden;"></div>
                                <div id="paging" style="width:990px;"></div>
                            </fieldset>
                        </td>
                    </tr>
                </table>
            </fieldset>
            </div>
        </div>
        <div id="divPop" class="popup" style="width:960px;height:auto;display:none;">
            <fieldset>
                <legend style="float:right">
                    <div style="float:right; cursor:pointer" class="popup_closebox">
                        <img alt="close" src="../icon/cancel.gif" height="16" width="16" align="absmiddle"/>Tutup</div>
                </legend>
                <table>
					<tr>
						<td align="center">
							Periode Kunjungan : <input id="txtTglImp" name="txtTglImp" readonly size="11" class="txtcenter" type="text" value="<?php echo $tgl; ?>" />&nbsp;
							<input type="button" name="btnTglImp" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('txtTglImp'),depRange,loadKunjungan);"/> s.d. 
							<input id="txtTglImp2" name="txtTglImp2" readonly size="11" class="txtcenter" type="text" value="<?php echo $tgl; ?>" />&nbsp;
							<input type="button" name="btnTglImp2" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('txtTglImp2'),depRange,loadKunjungan);"/>
							
							<input type="hidden" name='rowId' id='rowId' value=""/>
						</td>
					</tr>
                    <tr>
                        <td>
                            <div id="gridbox_pop" style="width:950px; height:180px; background-color:white; "></div>
                            <br/><br/>
                            <div id="paging_pop" style="width:950px;"></div>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </div>

        <?php include("../laporan/report_form.php");?>
    </body>
    <script type="text/JavaScript" language="JavaScript">
		
		var klaim_id = klaim_terima_id = kso_id = 0;
		function fBuatKlaimTerima(){
			var obj=document.getElementById('cmbKsoBuatKlaimTerima');
			klaim_id = klaim_terima_id = 0;
			document.getElementById('txtNoBuktiPenerimaan').value='';
			document.getElementById('txtNoBuktiPengajuan').value='';
			document.getElementById('tblPopBuatKlaim').style.display='block';
			document.getElementById('tblPopPx').style.display='none';
			document.getElementById('txtKso').value=obj.options[obj.options.selectedIndex].lang;
			document.getElementById('divPopPx').style.height='auto';
            new Popup('divPopPx',null,{modal:true,position:'center',duration:0.5})
            $('divPopPx').popup.show();
			document.getElementById('divPopPx').style.height='225px';
		}
		
 		function fEditKlaimTerima(rowId){
			var url;
			var obj=document.getElementById('cmbKsoBuatKlaimTerima');
			var cmbpost=document.getElementById('cmbPost').value;
			//var sisip = grdKlaim.getRowId(grdKlaim.getSelRow()).split('|');
			var sisip = grdKlaim.getRowId(rowId).split('|');
            klaim_terima_id = sisip[0];
			klaim_id = sisip[1];
			obj.value=sisip[2];
			kso_id=sisip[2];
			
			document.getElementById("upload").disabled = true;
			document.getElementById("fileU").disabled = true;
			
			document.getElementById('txtNoBuktiPenerimaanLbl').value=sisip[5];
			document.getElementById('txtNoBuktiPengajuanLbl').value=sisip[4];
			
			document.getElementById('tblPopBuatKlaim').style.display='none';
			document.getElementById('tblPopPx').style.display='block';
			document.getElementById('txtKso').value=obj.options[obj.options.selectedIndex].lang;
			document.getElementById('divPopPx').style.height='auto';
			url="penerimaan_Klaim_utils.php?grid=1&klaim_terima_id="+klaim_terima_id+"&klaim_id="+klaim_id+"&posting="+cmbpost;
			a.loadURL(url,"","GET");
            new Popup('divPopPx',null,{modal:true,position:'center',duration:0.5})
            $('divPopPx').popup.show();
		}
		
		// Start function import data
		function _(el){
			return document.getElementById(el);
		}
		function cekImp(par){
			if(par == true){
				_("upload").disabled = false;
				_("fileU").disabled = false;
			} else {
				_("upload").disabled = true;
				_("fileU").disabled = true;
			}
		}
		function uploadFile(){
			var file = _("fileU").files[0];
			var user_id = "<?php echo $userId; ?>";
			//alert(document.getElementById('cmbKsoBuatKlaimTerima').value);
			kso_id = document.getElementById('cmbKsoBuatKlaimTerima').value;
			if(file){
				_("upload").disabled = true;
				_("fileU").disabled = true;
				var formdata = new FormData();
				formdata.append("fileU", file);
				formdata.append("user_id", user_id);
				formdata.append("tipe_imp", "penerimaan");
				formdata.append("klaim_id", klaim_id);
				formdata.append("kso_id", kso_id);
				formdata.append("klaim_terima_id", klaim_terima_id);
				var ajax = new XMLHttpRequest();
				ajax.upload.addEventListener("progress", progressHandler, false);
				ajax.addEventListener("load", completeHandler, false);
				ajax.addEventListener("error", errorHandler, false);
				ajax.addEventListener("abort", abortHandler, false);
				ajax.open("POST", "upload.php");
				ajax.send(formdata);
			} else {
				alert("Masukkan file yang ingin di import!");
			}
		}
		function progressHandler(event){
			//alert(event.loaded);
			//_("hasilTxt").innerHTML = event.target.responseText;
			//_("loaded_n_total").innerHTML = "Uploaded "+event.loaded+" bytes of "+event.total;
			var percent = (event.loaded / event.total) * 100;
			_("progress-bar").style.width = Math.round(percent) + '%';
			_("progress-status").innerHTML = Math.round(percent)+"% Uploaded... Please Wait For Import &nbsp;"+
				"<img src='ajax-loader.gif' width='16px' alt='loading' />";
			if(Math.round(percent) >= 80){
				_("progress-status").style.color = '#fff';
			}
		}
		function completeHandler(event){
			_("hasilTxt").innerHTML = event.target.responseText;
			_("progress-status").innerHTML = "File 100% Imported.";
			_("fileU").value = "";
			_("upload").disabled = false;
			_("fileU").disabled = false;
			_("cmbPost").value = 2;
			document.getElementById('cetakImport').style.display = 'inline-block';
			document.getElementById('hapusImport').style.display = 'inline-block';
			fcmbPostChange(2);
			//_("progress-bar").value = 0;
		}
		function errorHandler(event){
			_("progress-status").innerHTML = "Upload Failed";
			_("upload").disabled = false;
			_("fileU").disabled = false;
		}
		function abortHandler(event){
			_("progress-status").innerHTML = "Upload Aborted";
			_("upload").disabled = false;
			_("fileU").disabled = false;
		}
		// End function import data
		
		// Start function of selecting kunjungan pasien
		function getKunjungan(rowId){
			var cmbpost=document.getElementById('cmbPost').value;
			document.getElementById('rowId').value = rowId;
			var sisip = a.getRowId(rowId).split('|');
            var klaim_terima_detail_id = sisip[0];
			var norm = sisip[1];
			var tglmsk = sisip[2];
			var sep = sisip[3];
			var tglmskTMP = tglmsk.split('-');
			document.getElementById('txtTglImp').value = tglmskTMP[2]+"-"+tglmskTMP[1]+"-"+tglmskTMP[0];
			document.getElementById('txtTglImp2').value = tglmskTMP[2]+"-"+tglmskTMP[1]+"-"+tglmskTMP[0];
			//var namapas = sisip[4];
			//document.getElementById('namaPasien').value = namapas;
			new Popup('divPop',null,{modal:true,position:'center',duration:0.5})
            $('divPop').popup.show();
			url = "penerimaan_Klaim_utils.php?grid=3&norm="+norm+"&tglmsk="+tglmsk+"&sep="+sep+"&klaim_terima_detail_id="+klaim_terima_detail_id+"&kso="+kso_id+"&load=0";
			//alert(url);
			b.loadURL(url,"","GET");
		}
		
		function loadKunjungan(){
			var rowId = document.getElementById('rowId').value;
			var sisip = a.getRowId(rowId).split('|');
			//alert(sisip);
            var klaim_terima_detail_id = sisip[0];
			var norm = sisip[1];
			var tglmsk = '-';
			var sep = sisip[3];
			var tgl_a = document.getElementById('txtTglImp').value;
			var tgl_b = document.getElementById('txtTglImp2').value;
			
			url = "penerimaan_Klaim_utils.php?grid=3&norm="+norm+"&tglmsk="+tglmsk+"&sep="+sep+"&klaim_terima_detail_id="+klaim_terima_detail_id+"&kso="+kso_id+"&tgl_a="+tgl_a+"&tgl_b="+tgl_b+"&load=1";
			b.loadURL(url,"","GET");
		}
		
		function setKunjungan(rowId){
			var cmbpost=document.getElementById('cmbPost').value;
			var sisip = b.getRowId(rowId).split('|');
			var kunjungan_id = sisip[0];
			var kso_id = sisip[2];
			var klaim_terima_detail_id = sisip[3];
			if(confirm("Yakin ingin memilih kunjungan ini?")){
				url="penerimaan_Klaim_utils.php?grid=1&klaim_terima_id="+klaim_terima_id+"&klaim_id="+klaim_id+"&posting="+cmbpost+"&act=setkunjungan&kunjungan_id="+kunjungan_id+"&kso_id="+kso_id+"&klaim_terima_detail_id="+klaim_terima_detail_id+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage();
				a.loadURL(url,"","GET");
				$('divPop').popup.hide();
			}
		}
		// End function of selecting kunjungan pasien
		
		// Start function of printing import data
		function cetakImp(){
			var cmbpost=document.getElementById('cmbPost').value;
			url = "cetakImport.php?klaim_terima_id="+klaim_terima_id+"&klaim_id="+klaim_id+"&posting="+cmbpost+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&tipe=1"; //+"&page="+a.getPage();
			OpenWnd(url,1200,600,'childwnd',true);
		}
		// End function of printing import data
		
		// START Function of Deleting Import Data
		function hapusImport(){
			var tmp = idata = "";
			for (var i=0;i<a.getMaxRow();i++)
			{
				if (a.obj.childNodes[0].childNodes[i].childNodes[11].childNodes[0].checked){
					//nilai = nilai.replace(/\./g,'');
					idata=a.getRowId(i+1).split('|'); //alert(idata);
					tmp+=idata[0]+String.fromCharCode(6);
					//alert(tmp);
				}
			}
			
			if (tmp!=""){
				tmp=tmp.substr(0,(tmp.length-1));
				//alert(tmp);
				if (tmp.length>1024){
					alert("Data Yg Mau di Hapus Terlalu Banyak !");
				} else {
					url="penerimaan_Klaim_utils.php?grid=1&act=hapusimport&klaim_terima_id="+klaim_terima_id+"&klaim_id="+klaim_id+"&userId=<?php echo $userId; ?>&posting="+document.getElementById('cmbPost').value+"&fdata="+tmp;
					//alert(url);
					a.loadURL(url,"","GET");
				}
			} else {
				alert("Pilih Data Yg Mau di Hapus Terlebih Dahulu !");
			}
		}
		// END Function of Deleting Import Data
		
		function fSimpanKlaimTerima(){
			var url;
			var kso=document.getElementById('cmbKsoBuatKlaimTerima').value;
			var tglKlaimTerima=document.getElementById('txtTglPenerimaan').value;
			var noBukti=document.getElementById('txtNoBuktiPenerimaan').value;
			if (noBukti==""){
				alert("No Bukti Penerimaan Harus Diisi!");
				document.getElementById('txtNoBuktiPenerimaan').focus();
				return;
			}
			//klaim_id=14;
			if (klaim_id==0){
				/* alert("No Bukti Pengajuan Harus Diisi!");
				return; */
			}
			/*document.getElementById('tblPopBuatKlaim').style.display='none';
			document.getElementById('tblPopPx').style.display='block';
			document.getElementById('divPopPx').style.height='600px';*/
			url="penerimaan_Klaim_utils.php?grid=klaimTerima&thn="+thn+"&act=buat_klaim_terima&tglKlaimTerima="+tglKlaimTerima+"&no_buktiTerima="+noBukti+"&klaim_id="+klaim_id+"&userId=<?php echo $userId; ?>&kso="+kso;
			//alert(url);
			//grdKlaim.loadURL(url,"","GET");
			Request(url ,"spnBuatKlaim", "", "GET",fSimpanKlaimTerimaComplete,"noload")
		}
		
		function fSimpanKlaimTerimaComplete(){
			var url;
			var tmpResp=document.getElementById('spnBuatKlaim').innerHTML;
			var cmbpost=document.getElementById('cmbPost').value;
			if (tmpResp!="0"){
				klaim_terima_id=tmpResp;
			
				document.getElementById('txtNoBuktiPenerimaanLbl').value=document.getElementById('txtNoBuktiPenerimaan').value;
				document.getElementById('txtNoBuktiPengajuanLbl').value=document.getElementById('txtNoBuktiPengajuan').value;

				document.getElementById('tblPopBuatKlaim').style.display='none';
				document.getElementById('tblPopPx').style.display='block';
				document.getElementById('divPopPx').style.height='auto';
				url="penerimaan_Klaim_utils.php?grid=1&klaim_terima_id="+klaim_terima_id+"&klaim_id="+klaim_id+"&posting="+cmbpost;
				a.loadURL(url,"","GET");
			}else{
				alert("Buat Pengajuan Klaim Gagal !");
			}
		}
		
		function fHapusKlaimTerima(rowId){
			var url;
			//var sisip = grdKlaim.getRowId(grdKlaim.getSelRow()).split('|');
			var sisip = grdKlaim.getRowId(rowId).split('|');
			if(sisip[8] == '0'){
				if (confirm('Yakin Ingin Menghapus Data ?')){
					url="penerimaan_Klaim_utils.php?grid=klaimTerima&thn="+thn+"&act=hapus_klaim_terima&klaim_terima_id="+sisip[0]+"&userId=<?php echo $userId; ?>";
					//alert(url);
					grdKlaim.loadURL(url,"","GET");
				}
			} else {
				alert('Klaim Terima tidak dapat dihapus dikarenakan terdapat pasien yang telah diverifikasi!');
			}
		}
		
		function fBatalKlaimTerima(){
			$('divPopPx').popup.hide();
		}
		
		function fShowMainKlaimTerima(){
			//alert('tutup');
			thn=document.getElementById('thn').value;
			grdKlaim.loadURL("penerimaan_Klaim_utils.php?grid=klaimTerima&thn="+thn,"","GET");
			//fBatalKlaim();
			document.getElementById("upload").disabled = true;
			document.getElementById("fileU").disabled = true;
			document.getElementById("impo").checked = false;
			document.getElementById("hasilTxt").innerHTML = '';
			document.getElementById("cmbPost").value = '0';
			fcmbPostChange(0);
		}
		
		function fPilihNoPengajuanKlik(obj){
			var tmp=obj.lang.split("|");
			klaim_id=tmp[0];
			document.getElementById('txtNoBuktiPengajuan').value=tmp[1];
			document.getElementById('div_klaim').style.display = 'none';
			document.getElementById('btnShowNo_Pengajuan').value=' Pilih ';
		}
		
		function fPilihNoPengajuan(){
			var kso=document.getElementById('cmbKsoBuatKlaimTerima').value;
			var url;
            if(document.getElementById('div_klaim').style.display == 'block'){
                document.getElementById('div_klaim').style.display = 'none';
				document.getElementById('btnShowNo_Pengajuan').value=' Pilih ';
            }
            else{
				url="klaim_list.php?kso="+kso;
				Request(url,'div_klaim','','GET');
                document.getElementById('div_klaim').style.display = 'block';
				document.getElementById('btnShowNo_Pengajuan').value=' Tutup ';
            }
		}
		
		function fVerifKlaimTerima(kid,verif){
			//alert(kid+' | '+verif);
			var url;
			url="penerimaan_Klaim_utils.php?grid=klaimTerima&thn="+thn+"&act=verif_klaim_terima&klaim_terima_id="+kid+"&tipeVerif="+verif+"&userId=<?php echo $userId; ?>";
			if (verif=="0"){
				if (confirm('Yakin Ingin Verifikasi / Approve Data Penerimaan Klaim ?')){
					//alert(url);
					grdKlaim.loadURL(url,"","GET");
				}
			}else{
				if (confirm('Yakin Ingin Membatalkan Verifikasi / Approve Data Penerimaan Klaim ?')){
					//alert(url);
					grdKlaim.loadURL(url,"","GET");
				}
			}
		}
		
		function ExportExcell(p){
		var url;
			url='../laporan/rpt_pendapatan_excell.php?tgl_d='+document.getElementById('txtTgl').value+'&tipe=<?php echo $tipe; ?>&tipePend=0&kso='+document.getElementById('cmbKsoBuatKlaimTerima').value+'&kson='+document.getElementById('cmbKsoBuatKlaimTerima').options[document.getElementById('cmbKsoBuatKlaimTerima').options.selectedIndex].label;
			OpenWnd(url,600,450,'childwnd',true);
		}
        
		function RincianTindakan(){
			var sisip = a.getRowId(a.getSelRow()).split('|');
			//window.open("../../billing/informasi/riwayat_pelayanan.php?idKunj="+sisip[0],'_blank');
			window.open("../../billing/unit_pelayanan/RincianTindakanObatKSO.php?idKunj="+sisip[0]+"&inap=0&tipe=2",'_blank');
		}
		
		function isiCombo(id,val,defaultId,targetId,evloaded){
            if(targetId=='' || targetId==undefined){
                targetId=id;
            }
            Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'ok');
            //alert('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId);
        }
		
		isiCombo('cmbKsoNonUmum','','','cmbKsoBuatKlaimTerima');
		
		function cmbKsoBuatKlaimTerimaChange(){
			var obj=document.getElementById('cmbKsoBuatKlaimTerima');
			//alert(obj.options[obj.options.selectedIndex].lang);
			document.getElementById('txtKso').value=obj.options[obj.options.selectedIndex].lang;
			//kirim();
		}

        function goFilterAndSort(grd){
            kso = document.getElementById('cmbKsoBuatKlaimTerima').value;
			var cmbpost=document.getElementById('cmbPost').value;
            var url = "penerimaan_Klaim_utils.php?grid=1&posting="+cmbpost+"&klaim_terima_id="+klaim_terima_id+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(); //&kso="+kso+"
            //alert(url);
            a.loadURL(url,"","GET");
        }

        function filter(){
			thn = document.getElementById('thn').value;
            var url = "penerimaan_Klaim_utils.php?grid=klaimTerima&thn="+thn;
            grdKlaim.loadURL(url,"","GET");
        }
        
        function konfirmasi(key,val){
			//alert(val);
            if (val!=undefined){
                var tmp36 = val.split(String.fromCharCode(3));
				a.cellSubTotalSetValue(8,tmp36[0]);
				a.cellSubTotalSetValue(9,tmp36[1]);
				a.cellSubTotalSetValue(10,tmp36[2]);
				a.cellSubTotalSetValue(11,tmp36[3]);
				//a.cellSubTotalSetValue(12,tmp36[4]);
				document.getElementById('btnVerifikasi').disabled=false;
				//document.getElementById('btnRincian').disabled=false;
				if (tmp36[4]!="" && tmp36[4]!=undefined){
					alert(tmp36[4]);
				}
            }else{
				a.cellSubTotalSetValue(8,0);
				a.cellSubTotalSetValue(9,0);
				a.cellSubTotalSetValue(10,0);
				a.cellSubTotalSetValue(11,0);
				//a.cellSubTotalSetValue(12,0);
				document.getElementById('btnVerifikasi').disabled=true;
				//document.getElementById('btnRincian').disabled=true;
			}
			document.getElementById('chkAll').checked=false;
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
			fHitungSubTotal();
		}
		
		function fcmbPostChange(p){
			if(p.value=="0" || p.value=="2"){
				document.getElementById('spnBtnVer').innerHTML='&nbsp;Verifikasi';
			}else{
				document.getElementById('spnBtnVer').innerHTML='&nbsp;UnVerifikasi';
			}
			kirim();
			if(p.value == "2"){
				document.getElementById('cetakImport').style.display = 'inline-block';
				document.getElementById('hapusImport').style.display = 'inline-block';
			} else {
				document.getElementById('cetakImport').style.display = 'none';
				document.getElementById('hapusImport').style.display = 'none';
			}
		}
	
		function chkKlik(p){
			var cekbox=(p==true)?1:0;
			var sTotal=0;
			var r;
			//alert(p);
			for (var i=0;i<a.getMaxRow();i++){
				a.cellsSetValue(i+1,12,cekbox);
				if (cekbox==1){
					r=document.getElementById('nilai_'+(i+1)).value;
					while (r.indexOf(".")>-1){
						r=r.replace(".","");
					}
					sTotal +=r*1;
				}
			}
			a.cellSubTotalSetValue(11,FormatNumberFloor(parseInt(sTotal),"."));
		}
	
		function chkInpKlik(){
			var sTotal=0;
			var r;
			//alert(p);
			for (var i=0;i<a.getMaxRow();i++){
				if (a.obj.childNodes[0].childNodes[i].childNodes[11].childNodes[0].checked){
					r=document.getElementById('nilai_'+(i+1)).value;
					while (r.indexOf(".")>-1){
						r=r.replace(".","");
					}
					sTotal +=r*1;
				}
			}
			a.cellSubTotalSetValue(11,FormatNumberFloor(parseInt(sTotal),"."));
		}
		
		function fHitungSubTotal(){
			chkInpKlik();
		}

		function kirim(){
			var url;
			var cmbpost = document.getElementById('cmbPost').value;
			document.getElementById('btnVerifikasi').disabled=true;
			url="penerimaan_Klaim_utils.php?grid=1&klaim_terima_id="+klaim_terima_id+"&klaim_id="+klaim_id+"&posting="+cmbpost;
			//alert(url);
			a.loadURL(url,"","GET"); 
		}
		//=========================================
		function VerifikasiJurnal(){
		//var no_slip = document.getElementById('noSlip').value;
		//var tglSlip = document.getElementById('tgl_slip').value;
		var kso = document.getElementById('cmbKsoBuatKlaimTerima').value;
		
		var tmp='',idata='';
		var url;
		//var url2;
		var nilai='';
			
			//alert(url);
			document.getElementById('btnVerifikasi').disabled=true;
			for (var i=0;i<a.getMaxRow();i++)
			{
				if (a.obj.childNodes[0].childNodes[i].childNodes[11].childNodes[0].checked)
				{
					if (document.getElementById('cmbPost').value==0){
						nilai = document.getElementById('nilai_'+(i+1)).value;
					}else{
						nilai='';
					}
					//nilai = nilai.replace(/\./g,'');
					idata=a.getRowId(i+1)+"|"+ValidasiText(nilai);//alert(idata);
					tmp+=idata+String.fromCharCode(6);
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
					url="penerimaan_Klaim_utils.php?grid=1&act=verifikasi&klaim_terima_id="+klaim_terima_id+"&klaim_id="+klaim_id+"&userId=<?php echo $userId; ?>&posting="+document.getElementById('cmbPost').value+"&fdata="+tmp;
					//alert(url);
					a.loadURL(url,"","GET");
				}
			}
			else
			{
				alert("Pilih Data Yg Mau diVerifikasi Terlebih Dahulu !");
			}
			//document.getElementById('btnVerifikasi').disabled=false;
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
       
		//var jenis_layanan = unit_id = inap = '089';
        //var bln = document.getElementById('bln').value;
        var thn = document.getElementById('thn').value;
        //var timeFil = document.getElementById('cmbTime').value;
        var kso = document.getElementById('cmbKsoBuatKlaimTerima').value;
		
        var grdKlaim=new DSGridObject("gridKlaimTerima");
        grdKlaim.setHeader("DATA PENERIMAAN KLAIM PIUTANG KSO");
		grdKlaim.setColHeader("NO,TGL PENERIMAAN,NO BUKTI PENERIMAAN,TGL PENGAJUAN,NO BUKTI PENGAJUAN,KSO,NILAI PENGAJUAN,NILAI PENERIMAAN,PROSES");
		grdKlaim.setCellType("txt,txt,txt,txt,txt,txt,txt,txt");
		//grdKlaim.setSubTotal(",,,SubTotal :&nbsp;,0,");
		grdKlaim.setIDColHeader(",,no_buktiTerima,no_buktiA,kso.nama,,,");
		grdKlaim.setColWidth("30,80,110,80,110,205,90,90,110");
		grdKlaim.setCellAlign("center,center,center,center,center,center,right,right,center");
		//grdKlaim.setSubTotalAlign("center,center,center,right,right,center");
        grdKlaim.setCellHeight(20);
        grdKlaim.setImgPath("../icon");
        grdKlaim.setIDPaging("pagingKlaimTerima");
        //a.attachEvent("onRowDblClick","ambilData");
        //grdKlaim.onLoaded(konfirmasi);
		grdKlaim.baseURL("penerimaan_Klaim_utils.php?grid=klaimTerima&thn="+thn);
		//alert("penerimaan_Klaim_utils.php?grid=klaim&thn="+thn);
        grdKlaim.Init();

        var a=new DSGridObject("gridbox");
        a.setHeader("DETAIL DATA PENERIMAAN KLAIM");
		a.setColHeader("NO,TANGGAL KUNJUNGAN,TANGGAL PULANG,NO RM,NAMA,KSO,KUNJUNGAN AWAL,TARIF REGULER,BIAYA PASIEN,NILAI PENGAJUAN,NILAI PENERIMAAN,VERIFIKASI<BR><input type='checkbox' name='chkAll' id='chkAll' onClick='chkKlik(this.checked);'>&nbsp;&nbsp;&nbsp;&nbsp;");
		a.setCellType("txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,chk");
		a.setSubTotal(",,,,,,SubTotal :&nbsp;,0,0,0,,");
		a.setIDColHeader(",,,no_rm,pasien,kso,unit,,,,,");
		a.setColWidth("30,70,70,60,130,100,110,70,70,70,80,50");
		a.setCellAlign("center,center,center,center,left,center,left,right,right,right,right,center");
		a.setSubTotalAlign("center,center,center,center,center,center,right,right,right,right,right,center");
        a.setCellHeight(20);
        a.setImgPath("../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","fHitungSubTotal");
        a.onLoaded(konfirmasi);
		a.baseURL("penerimaan_Klaim_utils.php?grid=1&kso="+kso);
		//alert("penerimaan_Klaim_utils.php?grid=1&tipe=<?php echo $tipe;?>&kso="+kso+"&waktu="+timeFil+"&bln="+bln+"&thn="+thn);
        a.Init();

        var b=new DSGridObject("gridbox_pop");
        b.setHeader("Daftar Kunjungan Pasien");
		b.setColHeader("NO,TGL MASUK, NORM, NAMA PASIEN, PENJAMIN, TEMPAT LAYANAN, SEP, ACTION");
		b.setIDColHeader(",tgl,norm,nama,kso,unit,sep,");
		b.setColWidth("30,80,70,170,100,120,130,50");
		b.setCellAlign("center,center,center,left,left,left,left,center");
        b.setCellHeight(20);
        b.setImgPath("../icon");
        b.setIDPaging("paging_pop");
        //b.attachEvent("onRowDblClick","ambilData");
        //b.onLoaded(konfirmasi);
        b.baseURL("penerimaan_Klaim_utils.php?grid=3");
        b.Init();
		
		/* var b=new DSGridObject("gridbox_pop");
        b.setHeader("PENDAPATAN <?php echo $caption;?>");
		b.setColHeader("NO,TGL TINDAKAN,TEMPAT LAYANAN,TINDAKAN,PELAKSANA,TARIF RS,BIAYA PASIEN,TARIF KSO,IUR BAYAR,SELISIH");
		b.setIDColHeader(",tgl,nama,,,,,,,");
		b.setColWidth("30,80,150,200,150,70,70,70,70,70");
		b.setCellAlign("center,center,left,left,left,right,right,right,right,right");
        b.setCellHeight(20);
        b.setImgPath("../icon");
        b.setIDPaging("paging_pop");
        //b.attachEvent("onRowDblClick","ambilData");
        //b.onLoaded(konfirmasi);
        b.baseURL("penerimaan_Klaim_utils.php?grid=2&tipe=<?php echo $tipe;?>&tipePend=0&kunjungan_id=0&waktu=");
        b.Init(); */
		
        var th_skr = "<?php echo $date_skr[2];?>";
        var bl_skr = "<?php echo ($date_skr[1]<10)?substr($date_skr[1],1,1):$date_skr[1];?>";
		var fromHome=<?php echo $fromHome ?>;
    </script>
    <script src="../report_form.js" type="text/javascript" language="javascript"></script>
</html>