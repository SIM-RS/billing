<?php
//include("../sesi.php");
include '../secured_sess.php';
$userId=$_SESSION['id'];
$tipe = $_REQUEST['tipe'];
$caption = ($tipe==1)?'RAWAT JALAN':(($tipe==2)?'RAWAT INAP':(($tipe==3)?'IGD':'PER UNIT'));

$pLegend = "Klaim KSO/Piutang -> Pengajuan Klaim";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
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
                              <td colspan="2" style="font-size:16px" align="center">Pengajuan Klaim KSO</td>
                            </tr>
                            <tr>
                                <td align="center">
                                    Tahun                                </td>
                                <td align="center">:&nbsp;
                                    <select id="thn" name="thn" onchange="fShowMainKlaim()" class="txtinputreg">
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
                                <td align="right" style="padding-right:10px;"><BUTTON type="button" id="btnBuatKlaim" onClick="fBuatKlaim();"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle"><span id="spnBtnBuatKlaim">&nbsp;Buat Klaim Baru</span></BUTTON>&nbsp;&nbsp;<!--button id="btnRincian" name="btnRincian" type="button" onclick="">Edit Klaim</button--></td>
                            </tr>
                        </table>
                        <fieldset style="width:990px">
                            <div id="gridKlaim" style="width:990px; height:370px; background-color:white; overflow:hidden;"></div>
                            <div id="pagingKlaim" style="width:990px;"></div>
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
                    <div style="float:right; cursor:pointer" class="popup_closebox" onclick="fShowMainKlaim();">
                        <img alt="close" src="../icon/cancel.gif" height="16" width="16" align="absmiddle"/>Tutup</div>
                </legend>
                <table id="tblPopBuatKlaim" width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#EAEFF3" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold"><span id="spnBuatKlaim" style="display:none"></span>
                    <tr height="30">
                      <td colspan="2" style="font-size:16px" align="center">Pengajuan Klaim KSO</td>
                    </tr>
                    <tr height="30">
                        <td align="right" width="300" style="padding-right:30px;">Nama KSO</td>
                        <td align="left">:&nbsp;
                            <select id="cmbKsoBuatKlaim" name="cmbKsoBuatKlaim" class="txtinputreg" onchange="cmbKsoBuatKlaimChange()"></select></td>
                    </tr>
                    <tr height="30">
                        <td align="right" style="padding-right:30px;">Tanggal Pengajuan</td>
                        <td align="left">:&nbsp;
                            <input id="txtTglPengajuan" name="txtTglPengajuan" readonly size="11" class="txtcenter" type="text" value="<?php echo $tgl; ?>" />&nbsp;
                            <input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('txtTglPengajuan'),depRange);"/>                                </td>
                    </tr>
                    <tr height="30">
                        <td align="right" style="padding-right:30px;">No Bukti</td>
                        <td align="left">:&nbsp;
                            <input id="txtNo_bukti" name="txtNo_bukti" size="30" class="txtleft" type="text" value="" />                                </td>
                    </tr>
                    <tr>
                    	<td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left" height="50" valign="middle" colspan="2" style="padding-left:300px;">
                        <!--input type="hidden" id="id" name="id" /-->
                            <button id="btnSimpan" name="btnSimpan" class="tblBtn" onclick="fSimpanKlaim()">Simpan</button>
                            <!--button id="btnHapus" name="btnHapus" type="submit" class="tblBtn" onclick="hapus()">Hapus</button-->
                            <button class="tblBtn" onclick="fBatalKlaim()">&nbsp;&nbsp;Batal&nbsp;&nbsp;</button>
                        </td>
                    </tr>
                </table>
                <table id="tblPopPx" style="display:none" width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#EAEFF3">
                    <tr>
                        <td valign="top" align="center">
                            <table border="0" cellpadding="2" cellspacing="2" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold">
                                <tr height="30">
                                  <td colspan="2" style="font-size:16px" align="center">Pengajuan Klaim KSO</td>
                                </tr>
                                <tr height="30" id="trKSO" style="display:none">
                                    <td width="110" style="padding-left:50px;">Nama KSO</td>
                                    <td>:&nbsp;
                                        <select id="cmbKso" name="cmbKso" class="txtinputreg" onchange="kirim()"></select>                                </td>
                                </tr>
                                <tr height="30" id="trTxtKSO">
                                    <td width="110" style="padding-left:50px;">Nama KSO</td>
                                    <td>:&nbsp;
                                        <input id="txtKso" name="txtKso" size="40" class="txtleft" type="text" value="" readonly="readonly" />                                </td>
                                </tr>
                                <tr style="display:none">
                                    <td style="padding-left:150px">Waktu</td>
                                    <td>:&nbsp;
                                        <select id="cmbTime" onchange="viewTime(this)" class="txtinputreg">
                                            <option value="harian" selected>Harian</option>
                                            <option value="bulan">Bulanan</option>
                                            <option value="periode">Periode</option>
                                        </select>                                </td>
                                </tr>
                                <tr id="trDay">
                                    <td style="padding-left:50px;">Tanggal KRS</td>
                                    <td>:&nbsp;
                                        <input id="txtTgl" name="txtTgl" readonly size="11" class="txtcenter" type="text" value="<?php echo $tgl; ?>" />&nbsp;
                                        <input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('txtTgl'),depRange,kirim);"/>
                                        s.d.
                                        <input id="txtTgl2" name="txtTgl2" readonly size="11" class="txtcenter" type="text" value="<?php echo $tgl; ?>" />&nbsp;
                                        <input type="button" name="btnTgl2" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('txtTgl2'),depRange,kirim);"/>                                </td>
                                </tr>
                                <tr id="trPer" style="display:none">
                                    <td style="padding-left:150px">Periode</td>
                                    <td>:&nbsp;
                                        <input id="tglFirst" name="tglFirst" readonly size="11" class="txtcenter" type="text" value="<?php echo $tgl; ?>" />&nbsp;
                                        <input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('tglFirst'),depRange,filter);"/>
                                        s.d.
                                        <input id="tglLast" name="tglLast" readonly size="11" class="txtcenter" type="text" value="<?php echo $tgl; ?>" />&nbsp;
                                        <input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('tglLast'),depRange,filter);"/>                                </td>
                                </tr>
                                <tr id="trBln" style="display:none">
                                    <td style="padding-left:150px">
                                        Bulan                                </td>
                                    <td>:&nbsp;
                                        <select id="bln" name="bln" onchange="filter()" class="txtinputreg">
                                            <option value="1" <?php echo $th[1]==1?'selected="selected"':'';?>>Januari</option>
                                            <option value="2" <?php echo $th[1]==2?'selected="selected"':'';?>>Februari</option>
                                            <option value="3" <?php echo $th[1]==3?'selected="selected"':'';?>>Maret</option>
                                            <option value="4" <?php echo $th[1]==4?'selected="selected"':'';?>>April</option>
                                            <option value="5" <?php echo $th[1]==5?'selected="selected"':'';?>>Mei</option>
                                            <option value="6" <?php echo $th[1]==6?'selected="selected"':'';?>>Juni</option>
                                            <option value="7" <?php echo $th[1]==7?'selected="selected"':'';?>>Juli</option>
                                            <option value="8" <?php echo $th[1]==8?'selected="selected"':'';?>>Agustus</option>
                                            <option value="9" <?php echo $th[1]==9?'selected="selected"':'';?>>September</option>
                                            <option value="10" <?php echo $th[1]==10?'selected="selected"':'';?>>Oktober</option>
                                            <option value="11" <?php echo $th[1]==11?'selected="selected"':'';?>>Nopember</option>
                                            <option value="12" <?php echo $th[1]==12?'selected="selected"':'';?>>Desember</option>
                                        </select>
                                        <select id="thn" name="thn" onchange="filter()" class="txtinputreg">
                                            <?php
                                            for ($i=($th[2]-5);$i<($th[2]+1);$i++) {
                                                ?>
                                            <option value="<?php echo $i; ?>" class="txtinput"<?php if ($i==$th[2]) echo "selected";?>><?php echo $i;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>                                </td>
                                </tr>
                                <tr id="tr_jenis" style="display:none">
                                    <td style="padding-left:150px">
                                        Jenis Layanan                                </td>
                                    <td>:&nbsp;
                                        <select id="cmbJnsLay" class="txtinput" onchange="fill_unit()" >
                                        </select>                                </td>
                                </tr>
                                <tr id="tr_unit" style="display:none">
                                    <td style="padding-left:150px">
                                        Unit Layanan                                </td>
                                    <td>:&nbsp;
                                        <select id="cmbTmpLay" class="txtinput" lang="" onchange="filter();">
                                        </select>                                </td>
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
                    <tr id="trPen">
                        <td align="center" >
                            <table width="1000px" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding-left:10px;">
										<select id="cmbPost" name="cmbPost" class="txtinput" style="background-color:#FFFFCC; color:#990000;" onChange="fcmbPostChange(this);">
											<option value="0">BELUM PENGAJUAN</option>
											<option value="1">PROSES PENGAJUAN</option>
											<option value="2">BELUM PENGAJUAN FILE IMPORT&nbsp;</option>
										</select>
										<button id="cetakImport" style="display:none;" onclick="cetakImp();"><img src="../icon/printer.png" width='16px' align='absmiddle' alt="Cetak Import" />&nbsp;Cetak</button>
									</td>
                                    <td align="right" style="padding-right:10px;"><BUTTON type="button" id="btnVerifikasi" onClick="VerifikasiJurnal();"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle"><span id="spnBtnVer">&nbsp;Masukkan --> Proses Pengajuan</span></BUTTON>
									<button id="hapusImport" style="display:none;" onclick="hapusImport();"><img src="../icon/printer.png" width='16px' align='absmiddle' alt="Cetak Import" />&nbsp;Hapus Import</button>
									</td>
                                </tr>
                            </table>
                            <fieldset style="width:1000px">
                                <div id="gridbox" style="width:990px; height:440px; background-color:white; overflow:hidden;"></div>
                                <div id="paging" style="width:990px;"></div>
                                </fieldset>
                        </td>
                    </tr>
                </table>
            </fieldset>
            </div>
        </div>
        <div id="divPop" class="popup" style="width:910px;height:270px;display:none;">
            <fieldset>
                <legend style="float:right">
                    <div style="float:right; cursor:pointer" class="popup_closebox">
                        <img alt="close" src="../icon/cancel.gif" height="16" width="16" align="absmiddle"/>Tutup</div>
                </legend>
                <table>
                    <tr>
                        <td>
                            <div id="gridbox_pop" style="width:900px; height:180px; background-color:white; "></div>
                            <br/><br/>
                            <div id="paging_pop" style="width:900px;"></div>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </div>
		<div id="divPopKunj" class="popup" style="width:910px;height:300px;display:none;">
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
                            <div id="gridbox_kunj" style="width:900px; height:180px; background-color:white; "></div>
                            <br/><br/>
                            <div id="paging_kunj" style="width:900px;"></div>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </div>
        <?php include("../laporan/report_form.php");?>
    </body>
    <script type="text/JavaScript" language="JavaScript">
		
		var klaim_id =  kso_id = 0;
		function fBuatKlaim(){
			var obj=document.getElementById('cmbKso');
			var sisip = grdKlaim.getRowId(grdKlaim.getSelRow()).split('|');
            klaim_id = sisip[0];
			document.getElementById('txtNo_bukti').value='';
			document.getElementById('tblPopBuatKlaim').style.display='block';
			document.getElementById('tblPopPx').style.display='none';
			document.getElementById('txtKso').value=obj.options[obj.options.selectedIndex].lang;
			document.getElementById('divPopPx').style.height='auto';
            new Popup('divPopPx',null,{modal:true,position:'center',duration:0.5})
            $('divPopPx').popup.show();
			document.getElementById('divPopPx').style.height='200px';
		}
		
 		function fEditKlaim(rowId){
			var obj=document.getElementById('cmbKso');
			//var sisip = grdKlaim.getRowId(grdKlaim.getSelRow()).split('|');
			var sisip = grdKlaim.getRowId(rowId).split('|');
            klaim_id = sisip[0];
			kso_id = sisip[1];
			obj.value=sisip[1];
			document.getElementById("upload").disabled = true;
			document.getElementById("fileU").disabled = true;
			document.getElementById('tblPopBuatKlaim').style.display='none';
			document.getElementById('tblPopPx').style.display='block';
			document.getElementById('txtKso').value=obj.options[obj.options.selectedIndex].lang;
			document.getElementById('divPopPx').style.height='auto';
            new Popup('divPopPx',null,{modal:true,position:'center',duration:0.5})
            $('divPopPx').popup.show();
			var url;
			var cmbPost = document.getElementById('cmbPost').value;
			var TglA = document.getElementById('txtTgl').value;
			var TglZ = document.getElementById('txtTgl2').value;
			url="pengajuan_Klaim_utils.php?grid=1&klaim_id="+klaim_id+"&txtTgl="+TglA+"&txtTgl2="+TglZ+"&kso="+kso_id+"&posting="+cmbPost;
			//alert(url);
			a.loadURL(url,"","GET");
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
			if(file){
				_("upload").disabled = true;
				_("fileU").disabled = true;
				var formdata = new FormData();
				formdata.append("fileU", file);
				formdata.append("user_id", user_id);
				formdata.append("tipe_imp", "pengajuan");
				formdata.append("klaim_id", klaim_id);
				formdata.append("kso_id", kso_id);
				var ajax = new XMLHttpRequest();
				ajax.upload.addEventListener("progress", progressHandler, false);
				ajax.addEventListener("load", completeHandler, false);
				ajax.addEventListener("error", errorHandler, false);
				ajax.addEventListener("abort", abortHandler, false);
				ajax.open("POST", "upload.php");
				ajax.send(formdata);
			} else {
				alert("Masukkan file yang ingin diimport!");
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
			//alert(sisip);
            var klaim_detail_id = sisip[0];
			var norm = sisip[1];
			var tglmsk = sisip[2];
			var sep = sisip[3];
			var tglmskTMP = tglmsk.split('-');
			document.getElementById('txtTglImp').value = tglmskTMP[2]+"-"+tglmskTMP[1]+"-"+tglmskTMP[0];
			document.getElementById('txtTglImp2').value = tglmskTMP[2]+"-"+tglmskTMP[1]+"-"+tglmskTMP[0];
			//var namapas = sisip[4];
			//document.getElementById('namaPasien').value = namapas;
			new Popup('divPopKunj',null,{modal:true,position:'center',duration:0.5})
			$('divPopKunj').popup.show();
			url = "pengajuan_Klaim_utils.php?grid=3&norm="+norm+"&tglmsk="+tglmsk+"&sep="+sep+"&klaim_detail_id="+klaim_detail_id+"&kso="+kso_id+"&load=0";
			c.loadURL(url,"","GET");
		}
		
		function loadKunjungan(){
			var rowId = document.getElementById('rowId').value;
			var sisip = a.getRowId(rowId).split('|');
			//alert(sisip);
            var klaim_detail_id = sisip[0];
			var norm = sisip[1];
			var tglmsk = '-';
			var sep = sisip[3];
			var tgl_a = document.getElementById('txtTglImp').value;
			var tgl_b = document.getElementById('txtTglImp2').value;
			
			url = "pengajuan_Klaim_utils.php?grid=3&norm="+norm+"&tglmsk="+tglmsk+"&sep="+sep+"&klaim_detail_id="+klaim_detail_id+"&kso="+kso_id+"&tgl_a="+tgl_a+"&tgl_b="+tgl_b+"&load=1";
			c.loadURL(url,"","GET");
		}
		
		function setKunjungan(rowId){
			var cmbpost=document.getElementById('cmbPost').value;
			var sisip = c.getRowId(rowId).split('|');
			//alert(sisip);
			var kunjungan_id = sisip[0];
			var kso_id = sisip[2];
			var klaim_detail_id = sisip[3];
			if(confirm("Yakin ingin memilih kunjungan ini?")){
				url="pengajuan_Klaim_utils.php?grid=1&klaim_id="+klaim_id+"&posting="+cmbpost+"&act=setkunjungan&kunjungan_id="+kunjungan_id+"&kso="+kso_id+"&klaim_detail_id="+klaim_detail_id+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage();
				a.loadURL(url,"","GET");
				$('divPopKunj').popup.hide();
			}
		}
		// End function of selecting kunjungan pasien
		
		// Start function of printing import data
		function cetakImp(){
			var cmbpost=document.getElementById('cmbPost').value;
			url = "cetakImport.php?klaim_id="+klaim_id+"&posting="+cmbpost+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&tipe=2"; //+"&page="+a.getPage();
			OpenWnd(url,1200,600,'childwnd',true);
		}
		// End function of printing import data
		
		// START Function of Deleting Import Data
		function hapusImport(){
			var tmp = idata = "";
			var kso = document.getElementById('cmbKso').value;
			var txtTglA = document.getElementById('txtTgl').value;
			
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
					url="pengajuan_Klaim_utils.php?grid=1&act=hapusimport&klaim_id="+klaim_id+"&userId=<?php echo $userId; ?>&txtTgl="+txtTglA+"&kso="+kso+"&posting="+document.getElementById('cmbPost').value+"&fdata="+tmp;
					//alert(url);
					a.loadURL(url,"","GET");
				}
			} else {
				alert("Pilih Data Yg Mau di Hapus Terlebih Dahulu !");
			}
		}
		// END Function of Deleting Import Data
		
		function fSimpanKlaim(){
			var url;
			var kso=document.getElementById('cmbKso').value;
			var tglKlaim=document.getElementById('txtTglPengajuan').value;
			var noBukti=document.getElementById('txtNo_bukti').value;
			/*document.getElementById('tblPopBuatKlaim').style.display='none';
			document.getElementById('tblPopPx').style.display='block';
			document.getElementById('divPopPx').style.height='500px';*/
			url="pengajuan_Klaim_utils.php?grid=klaim&thn="+thn+"&act=buat_klaim&tglKlaim="+tglKlaim+"&kso="+kso+"&no_bukti="+noBukti+"&userId=<?php echo $userId; ?>";
			//alert(url);
			//grdKlaim.loadURL(url,"","GET");
			Request(url ,"spnBuatKlaim", "", "GET",fSimpanKlaimComplete,"noload")
		}
		
		function fSimpanKlaimComplete(){
			var tmpResp=document.getElementById('spnBuatKlaim').innerHTML;
			if (tmpResp!="0"){
				klaim_id=tmpResp;
				document.getElementById('tblPopBuatKlaim').style.display='none';
				document.getElementById('tblPopPx').style.display='block';
				document.getElementById('divPopPx').style.height='auto';
			}else{
				alert("Buat Pengajuan Klaim Gagal !");
			}
		}
		
		function fHapusKlaim(rowId){
			var url;
			//var sisip = grdKlaim.getRowId(grdKlaim.getSelRow()).split('|');
			var sisip = grdKlaim.getRowId(rowId).split('|');
			if (sisip[2]=="0"){
				if (sisip[3]=="0"){
					if (confirm('Yakin Ingin Menghapus Data ?')){
						url="pengajuan_Klaim_utils.php?grid=klaim&thn="+thn+"&act=hapus_klaim&klaim_id="+sisip[0]+"&userId=<?php echo $userId; ?>";
						//alert(url);
						grdKlaim.loadURL(url,"","GET");
					}
				}else{
					alert("Data Pengajuan Klaim Sudah Ada Data Pasiennya, Kosongkan Dulu Jika Ingin Menghapus !");
				}
			}else{
				alert("Data Pengajuan Klaim Sudah Diverifikasi, Jadi Tidak Boleh Dihapus !");
			}
		}
		
		function fVerifKlaim(a,b){
			var url;
			url="pengajuan_Klaim_utils.php?grid=klaim&thn="+thn+"&act=verif_klaim&klaim_id="+a+"&tipeVerif="+b+"&userId=<?php echo $userId; ?>";
			if (b=="0"){
				if (confirm('Yakin Ingin Verifikasi / Approve Data Pengajuan Klaim ?')){
					//alert(url);
					grdKlaim.loadURL(url,"","GET");
				}
			}else{
				if (confirm('Yakin Ingin Membatalkan Verifikasi / Approve Data Pengajuan Klaim ?')){
					//alert(url);
					grdKlaim.loadURL(url,"","GET");
				}
			}
		}
		
		function fBatalKlaim(){
			$('divPopPx').popup.hide();
		}
		
		function fShowMainKlaim(){
			//alert('tutup');
			thn=document.getElementById('thn').value;
			grdKlaim.loadURL("pengajuan_Klaim_utils.php?grid=klaim&thn="+thn,"","GET");
			//fBatalKlaim();
			document.getElementById("upload").disabled = true;
			document.getElementById("fileU").disabled = true;
			document.getElementById("impo").checked = false;
			document.getElementById("hasilTxt").innerHTML = '';
			document.getElementById("cmbPost").value = '0';
			fcmbPostChange(0);
		}
		
		function ExportExcell(p){
		var url;
			url='../laporan/rpt_pendapatan_excell.php?tgl_d='+document.getElementById('txtTgl').value+'&tipe=<?php echo $tipe; ?>&tipePend=0&kso='+document.getElementById('cmbKso').value+'&kson='+document.getElementById('cmbKso').options[document.getElementById('cmbKso').options.selectedIndex].label;
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
		
		isiCombo('cmbKsoNonUmum','','','cmbKsoBuatKlaim');
        isiCombo('cmbKsoNonUmum','','','cmbKso');
		
		function cmbKsoBuatKlaimChange(){
			var obj=document.getElementById('cmbKso');
			document.getElementById('cmbKso').value=document.getElementById('cmbKsoBuatKlaim').value;
			//alert(obj.options[obj.options.selectedIndex].lang);
			document.getElementById('txtKso').value=obj.options[obj.options.selectedIndex].lang;
			kirim();
		}
		
        function viewTime(par){
            if(par == undefined) par = document.getElementById('cmbTime');
            switch(par.value){
                case 'harian':
                    document.getElementById('trPer').style.display = 'none';
                    document.getElementById('trBln').style.display = 'none';
                    document.getElementById('trDay').style.display = 'table-row';
                    break;
                case 'periode':
                    document.getElementById('trPer').style.display = 'table-row';
                    document.getElementById('trBln').style.display = 'none';
                    document.getElementById('trDay').style.display = 'none';
                    break;
                case 'bulan':
                    document.getElementById('trPer').style.display = 'none';
                    document.getElementById('trBln').style.display = 'table-row';
                    document.getElementById('trDay').style.display = 'none';
                    break;
            }
            filter();
        }

        function goFilterAndSort(grd){
            timeFil = document.getElementById('cmbTime').value;
            kso = document.getElementById('cmbKso').value;
			var cmbpost=document.getElementById('cmbPost').value;
			
			//if(cmbpost != 2){
				var url = "pengajuan_Klaim_utils.php?grid=1&tipe=<?php echo $tipe;?>&tipePend=0&kso="+kso+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&posting="+cmbpost+"&klaim_id="+klaim_id;
				var tglA,tglZ;
				switch(timeFil){
					case 'harian':
						tglA = document.getElementById('txtTgl').value;
						url += "&waktu="+timeFil+"&txtTgl="+tglA;
						break;
					case 'periode':
						tglA = document.getElementById('tglFirst').value;
						tglZ = document.getElementById('tglLast').value;
						url += "&waktu="+timeFil+"&tglAwal="+tglA+"&tglAkhir="+tglZ;
						break;
					case 'bulan':
						bln = document.getElementById('bln').value;
						thn = document.getElementById('thn').value;
						url += "&waktu="+timeFil+"&bln="+bln+"&thn="+thn;
						break;
				}
				//alert(url);
				a.loadURL(url,"","GET");
			/* } else {
				url = "penerimaan_Klaim_utils.php?grid=3&norm="+norm+"&tglmsk="+tglmsk+"&sep="+sep+"&klaim_detail_id="+klaim_detail_id+"&kso_id="+kso_id+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage();
				c.loadURL(url,"","GET");
			} */
        }

        function filter(par){
            /*if(par==undefined) par = 1;
            timeFil = document.getElementById('cmbTime').value;
            kso = document.getElementById('cmbKso').value;
            var url = "pengajuan_Klaim_utils.php?grid="+par;
            if(par == 1){
                url += "&kso="+kso;
            }
            else{
                url += "&kso="+kso+"&kunjungan_id="+kunjungan_id[0]+"&pelayanan_id="+kunjungan_id[1];
            }
            var tglA,tglZ;
            switch(timeFil){
                case 'harian':
                    tglA = document.getElementById('txtTgl').value;
                    url += "&waktu="+timeFil+"&txtTgl="+tglA;
                    break;
                case 'periode':
                    tglA = document.getElementById('tglFirst').value;
                    tglZ = document.getElementById('tglLast').value;
                    url += "&waktu="+timeFil+"&tglAwal="+tglA+"&tglAkhir="+tglZ;
                    break;
                case 'bulan':
                    bln = document.getElementById('bln').value;
                    thn = document.getElementById('thn').value;
                    url += "&waktu="+timeFil+"&bln="+bln+"&thn="+thn;
                    break;
            }
            //alert(url)
            if(par == 1){
                a.loadURL(url,"","GET");
            }
            else{
                b.loadURL(url,'','GET');
            }*/
			thn=document.getElementById('thn').value;
        }
        
        var first_time = true;
        function fill_unit(){
            isiCombo('cmbTemLayWLang',document.getElementById('cmbJnsLay').value,'','cmbTmpLay',first_time==true?viewTime:filter);
            if(first_time==true) first_time=false;
        }
        
        var kunjungan_id = '';
        function ambilData(){
            kunjungan_id = a.getRowId(a.getSelRow()).split('|');
            filter(2);
            new Popup('divPop',null,{modal:true,position:'center',duration:0.5})
            $('divPop').popup.show();
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
				if (tmp36[5]!=""){
					alert(tmp36[5]);
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
		}
	
		function fcmbPostChange(par){
			if(par.value==0 || par.value == 2){
					document.getElementById('spnBtnVer').innerHTML="&nbsp; Masukkan --> Proses Pengajuan";
			}else{
				document.getElementById('spnBtnVer').innerHTML='&nbsp;Proses Pengajuan --> Keluarkan';
			}
			kirim();
			if(par.value == "2"){
				document.getElementById('cetakImport').style.display = 'inline-block';
				document.getElementById('hapusImport').style.display = 'inline-block';
			} else {
				document.getElementById('cetakImport').style.display = 'none';
				document.getElementById('hapusImport').style.display = 'none';
			}
		}
	
		function chkKlik(p){
		var cekbox=(p==true)?1:0;
			//alert(p);
			for (var i=0;i<a.getMaxRow();i++){
				a.cellsSetValue(i+1,12,cekbox);
			}
		}

		function kirim(){
			var url;
			var cmbPost = document.getElementById('cmbPost').value;
			var kso = document.getElementById('cmbKso').value;
			var TglA = document.getElementById('txtTgl').value;
			var TglZ = document.getElementById('txtTgl2').value;
			document.getElementById('btnVerifikasi').disabled=true;
			url="pengajuan_Klaim_utils.php?grid=1&klaim_id="+klaim_id+"&txtTgl="+TglA+"&txtTgl2="+TglZ+"&kso="+kso+"&posting="+cmbPost;
			//alert(url);
			a.loadURL(url,"","GET");
		}
		//=========================================
		function VerifikasiJurnal(){
		//var no_slip = document.getElementById('noSlip').value;
		//var tglSlip = document.getElementById('tgl_slip').value;
		var kso = document.getElementById('cmbKso').value;
		var txtTglA = document.getElementById('txtTgl').value;
		
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
					if (document.getElementById('cmbPost').value==0 || document.getElementById('cmbPost').value==2){
						nilai = document.getElementById('nilai_'+(i+1)).value;
						//alert(nilai);
					
						/* if (nilai=="") { //Validasi jika nilai slip kosong
							alert("Nilai Slip Tidak Boleh kosong ! ");
							return false;
						} */
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
					document.getElementById('btnVerifikasi').disabled=false;
				}
				else
				{
					url="pengajuan_Klaim_utils.php?grid=1&act=verifikasi&klaim_id="+klaim_id+"&userId=<?php echo $userId; ?>&txtTgl="+txtTglA+"&kso="+kso+"&posting="+document.getElementById('cmbPost').value+"&fdata="+tmp;
					//alert(url);
					a.loadURL(url,"","GET");
				}
			}
			else
			{
				alert("Pilih Data Yg Mau diVerifikasi Terlebih Dahulu !");
				document.getElementById('btnVerifikasi').disabled=false;
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
        var bln = document.getElementById('bln').value;
        var thn = document.getElementById('thn').value;
        var timeFil = document.getElementById('cmbTime').value;
        var kso = document.getElementById('cmbKso').value;
		
        var grdKlaim=new DSGridObject("gridKlaim");
        grdKlaim.setHeader("DATA PENGAJUAN KLAIM PIUTANG KSO");
		grdKlaim.setColHeader("NO,TGL PENGAJUAN,NO BUKTI PENGAJUAN,KSO,NILAI PENGAJUAN,STATUS,PROSES");
		grdKlaim.setCellType("txt,txt,txt,txt,txt,txt,txt");
		//grdKlaim.setSubTotal(",,,SubTotal :&nbsp;,0,");
		grdKlaim.setIDColHeader(",,no_bukti,kso.nama,,,");
		grdKlaim.setColWidth("40,90,140,200,110,150,100");
		grdKlaim.setCellAlign("center,center,center,center,right,center,center");
		//grdKlaim.setSubTotalAlign("center,center,center,right,right,center");
        grdKlaim.setCellHeight(20);
        grdKlaim.setImgPath("../icon");
        grdKlaim.setIDPaging("pagingKlaim");
        //a.attachEvent("onRowDblClick","ambilData");
        //grdKlaim.onLoaded(konfirmasi);
		grdKlaim.baseURL("pengajuan_Klaim_utils.php?grid=klaim&thn="+thn);
		//alert("pengajuan_Klaim_utils.php?grid=klaim&thn="+thn);
        grdKlaim.Init();

        var a=new DSGridObject("gridbox");
        a.setHeader("DATA KUNJUNGAN PASIEN");
		a.setColHeader("NO,TANGGAL KUNJUNGAN,TANGGAL PULANG,NO RM,NAMA,KSO,KUNJUNGAN AWAL,TARIF RS,BIAYA PASIEN,BIAYA KSO (SIMRS),BIAYA KSO (VERIF KLAIM),VERIFIKASI<BR><input type='checkbox' name='chkAll' id='chkAll' onClick='chkKlik(this.checked);'>&nbsp;&nbsp;&nbsp;&nbsp;");
		a.setCellType("txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,chk");
		a.setSubTotal(",,,,,,SubTotal :&nbsp;,0,0,0,,");
		a.setIDColHeader(",,,mp.no_rm,mp.nama,kso.nama,mu.nama,,,,,");
		a.setColWidth("30,70,70,60,130,100,110,70,70,70,80,50");
		a.setCellAlign("center,center,center,center,left,center,left,right,right,right,right,center");
		a.setSubTotalAlign("center,center,center,center,center,center,right,right,right,right,right,center");
        a.setCellHeight(20);
        a.setImgPath("../icon");
        a.setIDPaging("paging");
        //a.attachEvent("onRowDblClick","ambilData");
        a.onLoaded(konfirmasi);
		a.baseURL("pengajuan_Klaim_utils.php?grid=1&tipe=<?php echo $tipe;?>&tipePend=0&kso="+kso+"&waktu="+timeFil+"&bln="+bln+"&thn="+thn);
		//alert("pengajuan_Klaim_utils.php?grid=1&tipe=<?php echo $tipe;?>&kso="+kso+"&waktu="+timeFil+"&bln="+bln+"&thn="+thn);
        a.Init();

        var b=new DSGridObject("gridbox_pop");
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
        b.baseURL("pengajuan_Klaim_utils.php?grid=2&tipe=<?php echo $tipe;?>&tipePend=0&kunjungan_id=0&waktu=");
        b.Init();
		
		var c=new DSGridObject("gridbox_kunj");
        c.setHeader("Daftar Kunjungan Pasien");
		c.setColHeader("NO,TGL MASUK, NORM, NAMA PASIEN, PENJAMIN, TEMPAT LAYANAN, SEP, ACTION");
		c.setIDColHeader(",tgl,norm,nama,kso,unit,sep,");
		c.setColWidth("30,80,70,170,100,120,130,50");
		c.setCellAlign("center,center,center,left,left,left,left,center");
        c.setCellHeight(20);
        c.setImgPath("../icon");
        c.setIDPaging("paging_kunj");
        //c.attachEvent("onRowDblClick","ambilData");
        //c.onLoaded(konfirmasi);
        c.baseURL("pengajuan_Klaim_utils.php?grid=3");
        c.Init();
		
        var th_skr = "<?php echo $date_skr[2];?>";
        var bl_skr = "<?php echo ($date_skr[1]<10)?substr($date_skr[1],1,1):$date_skr[1];?>";
		var fromHome=<?php echo $fromHome ?>;
    </script>
    <script src="../report_form.js" type="text/javascript" language="javascript"></script>
</html>