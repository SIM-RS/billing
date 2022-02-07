<?php
session_start();
include("../sesi.php");
?>
<?php
//session_start();
$userId = $_SESSION['userId'];
if(!isset($userId) || $userId == ''){
    header('location:../index.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        
        <link rel="stylesheet" type="text/css" href="../theme/tab-view.css" />
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
        <script type="text/javascript" src="../theme/js/tab-view.js"></script>

        <script type="text/JavaScript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" src="../theme/js/ajax.js"></script>
        
         <script language="JavaScript" src="../theme/js/mm_menu.js"></script>
		<?php include("dropdown.php"); ?>
        
        <link href="../theme/jquery-ui/css/ui-lightness/jquery-ui-1.9.2.custom.css" rel="stylesheet">
		<script src="../theme/jquery-ui/js/jquery-1.8.3.js"></script>
		<script src="../theme/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
        
        <!--dibawah ini diperlukan untuk menampilkan popup-->
        <link rel="stylesheet" type="text/css" href="../theme/popup.css" />
        <script type="text/javascript" src="../theme/prototype.js"></script>
        <script type="text/javascript" src="../theme/effects.js"></script>
        <script type="text/javascript" src="../theme/popup.js"></script>
        <!--diatas ini diperlukan untuk menampilkan popup-->
        
        
        
        <title>Form Rekam Medis</title>
    </head>

    <!--<body onload="setJam();loadUlang();cekSentPar();">-->
	<body onload="loadHeight();">
        <script type="text/JavaScript">
            var arrRange = depRange = [];
        </script>
        <iframe height="72" width="130" name="sort"
                id="sort"
                src="../theme/dsgrid_sort.php" scrolling="no"
                frameborder="0"
                style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
        </iframe>
        <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js" src="../theme/popcjs.php" scrolling="no" frameborder="1"
                style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
        </iframe>
       
    <div id="divKunj">          
        <div id="divPilihan" style="display:none; width:320px" class="popup">
                <fieldset>
                    <table border=0 width="300">
                        <tr>
                            <td width="120" align="right">Status Medik :</td>
                            <td >&nbsp;<select id="cmbPilihan">
                            <option value="1">Keluar</option>
                            <option value="2">Dipinjam</option>
                            <option value="3">Kembali / Masuk</option>
                            </select></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                                <input type="button" value="Simpan" style="cursor:pointer" onclick="simpan();document.getElementById('divPilihan').popup.hide();" />
                                <input type="button" value="Batal" style="cursor:pointer" class="popup_closebox" onclick="document.getElementById('txtFilter').select();"/>
                            </td>
                        </tr>
                    </table>
                </fieldset>
            </div>
            
            <input type="hidden" id="kunjungan_id" name="kunjungan_id" />
            <input type="hidden" id="status_medik" name="status_medik" />
            <input type="hidden" id="pelayanan_id" name="pelayanan_id" />
            <input type="hidden" id="formulir_id" name="formulir_id" />
            <input type="hidden" id="norm" name="norm" />
            <span id="spanSukRM" style="display:none"></span>
<?php
            include("../koneksi/konek.php");
            include("../header1.php");
            $date_now=gmdate('d-m-Y',mktime(date('H')+7));
            $time_now=gmdate('H:i:s',mktime(date('H')+7));
            $tglGet=$_REQUEST['tgl'];
            ?>
            <table width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#008484"  align="center" class="hd2">
              <tr>
                    <td height="30">&nbsp;FORM REKAM MEDIS</td>
					<td align="right">&nbsp;</td>
                </tr>
            </table>
            <table width="1000" border="0" cellpadding="0" cellspacing="0" align="center" class="tabel">
                <tr>
                    <td width="4%">&nbsp;</td>
                    <td width="46%">&nbsp;</td>
                    <td width="48%">&nbsp;</td>
                    <td width="2%">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <fieldset>
                            <table width="75%" align="center">
                                <tr id="trTgl">
                                    <td height="30">Tanggal</td>
                                    <td align="center">:</td>
                                    <td>
                                        <input id="txtTgl" name="txtTgl" readonly size="11" class="txtcenter" type="text" value="<?php if($tglGet=='') {
                                            echo $date_now;
                                        }
                                        else {
                                            echo $tglGet;
                                        }
                                        ?>"/>&nbsp;<input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="txtcenter" onclick="gfPop.fPopCalendar(document.getElementById('txtTgl'),depRange,saring);"/>
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                    </td>
                    <td align="center">
                        <div id="loadGambar"></div>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2">
                        <fieldset>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                                <tr id="trDilayani"> 
                            		<td align="left" colspan="2" width="100%"><span style="padding-left:20px">
                                        No. RM :
                                        <input id="txtFilter" name="txtFilter" size="10" class="txtinput" onkeyup="filterNoRM(event,this)"/>
                                        </span>&nbsp;<input type="checkbox" id="chkHistory" name="chkHistory" style="cursor:pointer; vertical-align:middle" onchange="viewHistory(this)" />&nbsp;Riwayat Kunjungan&nbsp;<button style="cursor:pointer; display:none" onclick="pilihStatusMedik();">Status Medik</button>
                                	</td>
                                </tr>
                                <tr>
                                    <td width="50%" style="vertical-align:top" align="left">
                                        <div id="gridbox" style="width:450px; height:270px; background-color:white; overflow:hidden;"></div>
                                        <div id="paging" style="width:450px;"></div>
                                    </td>
                                    <td width="50%" style="vertical-align:top" align="right">
                                        <div id="gridbox4" style="width:450px; height:270px; background-color:white; overflow:hidden;"></div>
                                        <div id="paging4" style="width:450px;"></div>
                                    </td>
                                </tr>
                                <tr>
                                	<td colspan="2">&nbsp;</td>
                                </tr>
                                <tr style="display:none">
                                	<td width="50%" style="vertical-align:top" align="left">
                                    	<div id="gridbox2" style="width:450px; height:270px; background-color:white; overflow:hidden;"></div>
                                        <div id="paging2" style="width:450px;"></div>
                                    </td>
                              		<td width="50%" style="vertical-align:top" align="right">
                                    	<div id="gridbox3" style="width:450px; height:270px; background-color:white; overflow:hidden;"></div>
                                        <div id="paging3" style="width:450px;"></div>
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                    <td colspan="2">
                    	<fieldset>
                    	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabel" align="center">
                            <tr>
                                <td colspan="5">&nbsp;</td>
                            </tr>
                            <tr style="display:none">
                                <td width="4%">&nbsp;</td>
                                <td width="92%">
                                    <fieldset>
                                        <table width="100%" align="center" border="0" cellpadding="1" cellspacing="1" class="tabel">
                                            <tr>
                                                <td width="7%">&nbsp;No RM</td>
                                                <td width="15%">:&nbsp;<input id="txtNo" name="txtNo" size="12" value="" class="txtinput" readonly="readonly" /></td>
                                                <td width="6%">&nbsp;Nama</td>
                                                <td width="30%">:&nbsp;<input id="txtNama" name="txtNama" size="28" value=""  class="txtinput" readonly="readonly" />&nbsp;</td>
                                                <td width="42%" >&nbsp;Tg Lhr&nbsp;: <input id="txtTglLhr" name="txtTglLhr" size="10" value="" class="txtinput"  readonly="readonly"/>&nbsp;Umur&nbsp;:&nbsp;<input id="txtUmur" name="txtUmur" size="12" value="" class="txtinput" />&nbsp;&nbsp;&nbsp;L/P&nbsp;:&nbsp;<input id="txtSex" name="txtSex" size="1" value="" readonly="readonly" class="txtinput" /></td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align:top">&nbsp;Ortu</td>
                                                <td style="vertical-align:top">: <input id="txtOrtu" name="txtOrtu" size="12" value=""  readonly="readonly" class="txtinput" />&nbsp;
                                                <br />
                                                <div id="loadGambar"></div>
                                                <div id="loadGambar1"></div>
                                                </td>
                                                <td style="vertical-align:top">&nbsp;Alamat</td>
                                                <td rowspan="2" style="vertical-align:top"><span style="vertical-align:top">:</span> <textarea id="txtAlmt" name="txtAlmt" cols="30" rows="2" readonly="readonly" class="txtinput" ></textarea></td>
                                                <td rowspan="2"  style="vertical-align:top">&nbsp;<span style="vertical-align:top">R. Alergi&nbsp;:</span>&nbsp;<textarea id="txtRA" name="txtRA" cols="33" rows="2" readonly="readonly" class="txtinput" ></textarea><span id="hsl_RA_terakhir" style="display:none"></span></td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" align="center" style="color:#203C42; font-weight:bold; font-size: 14px" id="tdStat"></td>
                                             </tr>
                                        </table>
                                    </fieldset>
                                </td>
                                <td width="4%">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                <input type="button" id="btnCtkFrm" name="btnCtkFrm" value="REPORT RM" style="cursor:pointer" onMouseOver="MM_showMenu(window.mm_menu_0814123211_4,0,20,null,'btnCtkFrm');" onMouseOut="MM_startTimeout();" class="tblBtn"/>
                                <input type="button" id="btnRekamMds" name="btnRekamMds" value="REKAM MEDIS" onclick="rekamMedis()" class="tblBtn"/>
                                <input type="button" id="btnResume" name="btnResume" value="RESUME MEDIS" onclick="resumeMedis()" class="tblBtn"/>
                                <input type="button" id="btnIsiDataRM15" name="btnIsiDataRM" value="PERLAKUAN KHUSUS" onclick="tampilPerlakuan();" class="tblBtn" />
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>   
                                <td colspan="3" align="center"><div class="TabView" id="TabView" style="width:900px; height:400px"></div></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                        </fieldset>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>

    </div>
    
	<div id="divDetil" align="center" style="display:none;">
       <div align="center">
          <table width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#008484"  class="hd2">
                    <tr>
                        <td height="30">&nbsp;</td>
                        <td>
                            <img alt="close" src="../icon/close.png" onClick="closeDetail();" border="0" style="cursor:pointer; float:right" />
                        </td>
                    </tr>
              </table>
                
            </div>
        </div>
        
        <div id="divICD10" style="display:none;width:600px" class="popup">
            <span id="spn_ICD_RM" style="display:none"></span>
            <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" onclick="batalICD_RM()" style="float:right; cursor: pointer" />
                <fieldset><legend id="lgn_icd">Kode ICD X</legend>
                    <table border=0 width="550">
                        <tr>
                            <td width="100" align="right"><span id="spn_icd">&nbsp;&nbsp;ICD X</span>&nbsp;:&nbsp;</td>
                            <td>
                            <input type="hidden" id="id_diagnosa_ICD_RM" name="id_diagnosa_ICD_RM" />
                            <input type="hidden" id="ms_diagnosa_ICD_RM" name="ms_diagnosa_ICD_RM" />
                            <input type="hidden" id="kode_diagnosa_ICD_RM" name="kode_diagnosa_ICD_RM" />
                            <input id="txtICD10" name="txtICD10" size="50" onKeyUp="suggest_ICD_RM(event,this);" autocomplete="off" class="txtinput">
                            <div id="divICD_RM" align="left" style="position:absolute; z-index:0; height: 230px; width:620px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC;"></div>
                            </td>
                        </tr>
                        <tr id="trCatatan" style="display:none;">
                        	<td align="right">Catatan&nbsp;:&nbsp;</td>
                            <td><input id="txtCatatan" name="txtCatatan" size="50" class="txtinput"></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center"><input type="button" value="Simpan" onclick="updateICD_RM();"/></td>
                        </tr>
                    </table>
                </fieldset>
         </div>
         
         <div id="divKasusICD10" style="display:none;width:400px" class="popup">
            <span id="spn_Kasus_ICD_RM" style="display:none"></span>
            <img alt="close" src="../icon/close.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" />
                <fieldset><legend>Kasus</legend>
                    <table border=0 width="350">
                        <tr>
                            <td width="200" align="right">Jenis Kasus&nbsp;:&nbsp;</td>
                            <td>
                            <select id="cmbKasusDiag">
                            	<option value="1" label="Baru">Baru</option>
                                <option value="0" label="Lama">Lama</option>
                            </select></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center"><input type="button" value="Simpan" onclick="updateKasusICD_RM();"/></td>
                        </tr>
                    </table>
                </fieldset>
         </div>
         
         <div id="div_popup_iframe" style="display:none;width:1200px" class="popup">
			<img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; display:none; cursor: pointer" />
			<img alt="close" src="../icon/x.png" width="32" onclick="document.getElementById('div_popup_iframe').popup.hide();resizeAwal();" style="float:right; cursor: pointer" />
			<fieldset>
				<legend id="legend_popup_iframe"></legend>
				<iframe id="popup_iframe" class="framex" src="" onload="javascript:resizeIframe(this);" style="width:100%; height:400px; border:none;" ></iframe>
			</fieldset>
		</div>
        
        <div id="pKhusus" style="display:none;width:500px" class="popup">
            <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" onclick="batal('btnBatalIsiDataRM')" style="float:right; cursor: pointer" />
             <fieldset>
             	<legend id="lgnIsiDataRM">Perlakuan Khusus&nbsp;</legend>
                <table border=0 align="center">
                	<tr>
                         <td align="left"><input type="checkbox" id="psnKomplain" name="psnKomplain"/>Pasien Potensi Komplain</td>
                    </tr>
                    <tr>
                         <td align="left"><input type="checkbox" id="psnPemilik" name="psnPemilik"/>Pasien Adalah Pemilik Rumah Sakit</td>
                    </tr>
                    <tr>
                         <td align="left"><input type="checkbox" id="psnPejabat" name="psnPejabat"/>Pasien Adalah Pejabat</td>
                    </tr>
                    <tr>
                         <td align="center"><input type="button" id="btnSimpanPerlakuan" name="btnSimpanPerlakuan" value="Tambah" onclick="simpanPerlakuan();" class="tblTambah"/></td>
                    </tr>
                </table>
             </fieldset>
        </div>
         
	</body>
</html>
<script type="text/JavaScript" language="JavaScript">
var getIdKunj,getIdPel,getIdPasien,getIdUnit,getJnsLay;

mTab=new TabView("TabView");
mTab.setTabCaption("ANAMNESA,DIAGNOSA,TINDAKAN,RESEP");
mTab.setTabCaptionWidth("225,225,225,225");
mTab.setTabDisplay("true,true,true,true,0");
mTab.onLoaded(showGrid);
mTab.setTabPage("anamnesia.php,diagnosa.php,tindakan.php,resep.php");

// ===============================================================================================================================
	
		function showGrid(){
            a1 = new DSGridObject("gridbox");
            a1.setHeader("DATA KUNJUNGAN PASIEN");
            a1.setColHeader("NO,TGL KUNJUNGAN,NO RM,NAMA,PENJAMIN,ALAMAT");
            a1.setIDColHeader(",tgl,no_rm,nama,penjamin,alamat");
            a1.setColWidth("30,80,70,200,100,300");
			a1.setCellType("txt,txt,txt,txt,txt,txt");
            a1.setCellAlign("center,center,center,left,left,left");
            a1.setCellHeight(20);
            a1.setImgPath("../icon");
            a1.setIDPaging("paging");
            a1.attachEvent("onRowClick","ambilDataPasien");
            a1.onLoaded(ambilDataPasien);
			a1.baseURL("RM_utils.php?grd=true&tgl="+document.getElementById('txtTgl').value);
            a1.Init();
			
			a4 = new DSGridObject("gridbox4");
            a4.setHeader("DATA PELAYANAN PASIEN");
            a4.setColHeader("NO,TGL,TEMPAT LAYANAN,DOKTER,ASAL KUNJUNGAN,STATUS KODING");
            a4.setIDColHeader(",,,,,");
            a4.setColWidth("30,80,100,200,150,100");
			a4.setCellType("txt,txt,txt,txt,txt,txt");
            a4.setCellAlign("center,center,left,left,left,center");
            a4.setCellHeight(20);
            a4.setImgPath("../icon");
            a4.setIDPaging("paging4");
			a4.attachEvent("onRowClick","loadDetail");
            a4.onLoaded(loadDetail);
			a4.baseURL("RM_utils.php?grd4=true&kunjungan_id="+document.getElementById('kunjungan_id').value);
            a4.Init();
			
			a2 = new DSGridObject("gridbox2");
            a2.setHeader("JENIS FORMULIR REPORT RM");
            a2.setColHeader("NO,NAMA");
            a2.setIDColHeader(",");
            a2.setColWidth("50,300");
			a2.setCellType("txt,txt");
            a2.setCellAlign("center,left");
            a2.setCellHeight(20);
            a2.setImgPath("../icon");
            a2.setIDPaging("paging2");
            a2.attachEvent("onRowClick","ambilDataReportRM");
            a2.onLoaded(ambilDataReportRM);
			a2.baseURL("RM_utils.php?grd2=true&pelayanan_id="+document.getElementById('pelayanan_id').value);
            a2.Init();
			
			a3 = new DSGridObject("gridbox3");
            a3.setHeader("DATA REPORT RM");
            a3.setColHeader("NO,CEKLIST,ANALISA,KODE,NAMA");
            a3.setIDColHeader(",,,,");
            a3.setColWidth("30,50,50,100,250");
			a3.setCellType("txt,chk,chk,txt,txt");
            a3.setCellAlign("center,center,center,center,left");
            a3.setCellHeight(20);
            a3.setImgPath("../icon");
            a3.setIDPaging("paging3");
            a3.attachEvent("onRowClick","cekZXC");
            a3.onLoaded(cekAnalisa);
			a3.baseURL("RM_utils.php?grd3=true&parent_id="+document.getElementById('formulir_id').value+'&pelayanan_id='+document.getElementById('pelayanan_id').value);
            a3.Init();
			
			anam1=new DSGridObject("gridbox1_1");
			anam1.setHeader("DATA ANAMNESA");
			anam1.setColHeader("NO,TANGGAL,DOKTER");
			anam1.setIDColHeader(",TGL,");
			anam1.setColWidth("30,100,350");
			anam1.setCellAlign("center,center,left");
			anam1.setCellHeight(20);
			anam1.setImgPath("../icon");
			anam1.setIDPaging("paging1_1");
			anam1.attachEvent("onRowClick","ambilDataAnamnesa1");
			anam1.baseURL("tindiag_utils.php?grdAnamnesa=true");
			anam1.Init();	
			
			subj1 = new DSGridObject("gridbox1_2");
			subj1.setHeader(" ",false);
			subj1.setColHeader("No,Tanggal,Nama Dokter/Perawat,S,O,A,P,I,E,R");
			subj1.setIDColHeader(",,nama,,,,,,,");
			subj1.setColWidth("40,70,255,100,100,100,100,100,100,100");
			subj1.setCellAlign("center,center,left,left,left,left,left,left,left,left");
			subj1.setCellType("txt,txt,txt,txt,txt,txt,txt,txt,txt,txt");
			subj1.setCellHeight(20);
			subj1.setImgPath("../icon");
			subj1.setIDPaging("paging1_2");
			subj1.attachEvent("onRowClick","ambilIdS1");
			subj1.baseURL("soap_utils.php?grd=1");
			subj1.Init();
			
			b=new DSGridObject("gridbox1");
			b.setHeader("DATA DIAGNOSA PASIEN");
			b.setColHeader("NO,DIAGNOSA,ICD-10 [RM],DOKTER,PRIORITAS,KASUS,AKHIR,KLINIS,BANDING,UNIT");
			b.setIDColHeader(",nama,icdrm,dokter,,,,,,");
			b.setColWidth("30,240,80,200,80,100,70,70,70,70");
			b.setCellAlign("center,left,center,left,center,center,,center,center,center,center");
			b.setCellHeight(20);
			b.setImgPath("../icon");
			b.setIDPaging("paging1");
			b.attachEvent("onRowClick","ambilDataDiag");
			b.baseURL("tindiag_utils.php?grd1=true");
			b.Init();
			
			f=new DSGridObject("gridboxTind");
			f.setHeader("DATA TINDAKAN PASIEN");
			f.setColHeader("NO,TANGGAL,TINDAKAN,ICD-9CM,KELAS,BIAYA,JUMLAH,SUBTOTAL,DOKTER,PETUGAS INPUT,KETERANGAN");
			f.setIDColHeader(",tanggal,nama,,,,,,,dokter,");
			f.setColWidth("30,100,250,75,75,75,75,75,200,175,150");
			f.setCellAlign("center,center,left,center,center,right,center,right,left,left,left");
			f.setCellHeight(20);
			f.setImgPath("../icon");
			f.setIDPaging("pagingTind");
			f.attachEvent("onRowDblClick","printReport");
			f.baseURL("tindiag_utils.php?grd=true");
			f.Init();
			
			aResep=new DSGridObject("gridboxResepAwal");
			aResep.setHeader("DATA RESEP");
			aResep.setColHeader("NO,NO RESEP,TANGGAL,APOTEK,STATUS");
			aResep.setIDColHeader(",,,,");
			aResep.setColWidth("50,100,100,150,100");
			aResep.setCellAlign("center,center,center,left,center");
			aResep.setCellType("txt,txt,txt,txt,txt,chk");
			aResep.setCellHeight(20);
			aResep.setImgPath("../icon");
			aResep.attachEvent("onRowClick","ambilDataResepDetail");
			aResep.onLoaded(ambilDataResepDetail);
			aResep.baseURL("tindiag_utils.php?grdRsp1=true");
			aResep.Init();
			
			aDet=new DSGridObject("gridboxResepDetail");
			aDet.setHeader("DATA OBAT DALAM RESEP");
			aDet.setColHeader("NO,NAMA OBAT,JUMLAH,RACIKAN,DOSIS,DOKTER,STOK");
			aDet.setIDColHeader(",OBAT_NAMA,,,,,");
			aDet.setColWidth("30,200,40,80,180,150,50");
			aDet.setCellAlign("center,left,center,center,left,left,center");
			aDet.setCellType("txt,txt,txt,txt,txt,txt,txt");
			aDet.setCellHeight(20);
			aDet.setImgPath("../icon");
			aDet.baseURL("tindiag_utils.php?grdRsp2=true");
			aDet.Init();
		}
		
		function cekZXC(){
			var idReport = a3.getRowId(parseInt(a3.getSelRow()-1)+1).split('|');
			//alert(idReport[2]);
		}
		
		function cekAnalisa(){
			var data='';
			for(var i=0;i<a3.getMaxRow();i++){
				data = a3.getRowId(i+1).split('|');
				
				
				if(data[1]=='0'){
					a3.obj.childNodes[0].childNodes[i].childNodes[2].childNodes[0].disabled=true;
				}
				else{
					a3.obj.childNodes[0].childNodes[i].childNodes[2].childNodes[0].disabled=false;
				}
				
				if(data[2]=='1'){
					a3.obj.childNodes[0].childNodes[i].childNodes[1].childNodes[0].disabled=true;
				}
				else{
					a3.obj.childNodes[0].childNodes[i].childNodes[1].childNodes[0].disabled=false;
				}
				
				
				a3.obj.childNodes[0].childNodes[i].childNodes[1].childNodes[0].lang=data[3];
				
				a3.obj.childNodes[0].childNodes[i].childNodes[1].childNodes[0].onchange=function(){cekList(1)};
				a3.obj.childNodes[0].childNodes[i].childNodes[2].childNodes[0].onchange=function(){cekList(2)};
				
				a3.obj.childNodes[0].childNodes[i].childNodes[1].childNodes[0].style.cursor='pointer';
				a3.obj.childNodes[0].childNodes[i].childNodes[2].childNodes[0].style.cursor='pointer';
			}
		}
		
		function cekList(x){
			var act,baris,id;
			var idPel = document.getElementById('pelayanan_id').value;
			var idReport = a3.getRowId(parseInt(a3.getSelRow()-1)+1).split('|');
			
			if(x==1){
				if(a3.obj.childNodes[0].childNodes[parseInt(a3.getSelRow())-1].childNodes[1].childNodes[0].checked){
					id = idReport[0]; 
					act = 'tambah';
					baris = parseInt(a3.getSelRow())-1;
				}
				else{
					id = idReport[0];
					act = 'hapus';
					baris = parseInt(a3.getSelRow())-1;
				}
			}
			else{			
				if(a3.obj.childNodes[0].childNodes[parseInt(a3.getSelRow())-1].childNodes[2].childNodes[0].checked){
					id = a3.obj.childNodes[0].childNodes[parseInt(a3.getSelRow())-1].childNodes[1].childNodes[0].lang;
					act = 'tambah_analisa';
					baris = parseInt(a3.getSelRow())-1;
				}
				else{
					id = a3.obj.childNodes[0].childNodes[parseInt(a3.getSelRow())-1].childNodes[1].childNodes[0].lang;
					act = 'hapus_analisa';
					baris = parseInt(a3.getSelRow())-1;
				}
			}
			
			Request('RM_utils.php?grd3=false&baris='+baris+'&act='+act+'&id='+id+'&pelayanan_id='+idPel+'&formulir_id='+document.getElementById('formulir_id').value+'&userId=<?php echo $userId; ?>','spanSukRM','','GET',hslCekList,'noLoad');
		}
		
		function hslCekList(){
			
			var hasil = document.getElementById('spanSukRM').innerHTML.split('|');
			var r = hasil[1];
			
			if(hasil[2]=='tambah' || hasil[2]=='hapus'){
				a3.obj.childNodes[0].childNodes[r].childNodes[1].childNodes[0].lang=hasil[3];
			}
			
			
			if(hasil[0]=='1'){
				if(a3.obj.childNodes[0].childNodes[r].childNodes[1].childNodes[0].checked){
					a3.obj.childNodes[0].childNodes[r].childNodes[2].childNodes[0].disabled=false;
				}
				else{
					a3.obj.childNodes[0].childNodes[r].childNodes[2].childNodes[0].disabled=true;
				}
				
				if(a3.obj.childNodes[0].childNodes[r].childNodes[2].childNodes[0].checked){
					a3.obj.childNodes[0].childNodes[r].childNodes[1].childNodes[0].disabled=true;
				}
				else{
					a3.obj.childNodes[0].childNodes[r].childNodes[1].childNodes[0].disabled=false;
				}
			}
			
		}
		
		function ambilDataReportRM(){
			var sisip = a2.getRowId(a2.getSelRow());
			document.getElementById('formulir_id').value=sisip;
			a3.loadURL("RM_utils.php?grd3=true&parent_id="+sisip+'&pelayanan_id='+document.getElementById('pelayanan_id').value,'','GET');
		}
		
		function ambilDataPasien(){
			var data = a1.getRowId(a1.getSelRow()).split('|');
			
			getIdKunj = data[0];
			getIdPasien = data[3];
			jQuery("#loadGambar").load("gambar1.php?id_pasien="+getIdPasien);
			
			document.getElementById('txtNo').value = data[2];
			document.getElementById('txtNama').value = data[7];
			document.getElementById('txtTglLhr').value = data[8];
			document.getElementById('txtUmur').value = data[5];
			document.getElementById('txtOrtu').value = data[6];
			document.getElementById('txtAlmt').value = data[4];
			document.getElementById('txtSex').value = data[9];
			Request('riwayat_alergi_util.php?act=view_last&idpasien='+getIdPasien,'hsl_RA_terakhir','','GET',loadRATerakhir,'noLoad');
			jQuery("#loadGambar").load("gambar1.php?id_pasien="+getIdPasien);
			
			document.getElementById('kunjungan_id').value=data[0];
			a4.loadURL("RM_utils.php?grd4=true&kunjungan_id="+document.getElementById('kunjungan_id').value,'','GET');
			document.getElementById('txtFilter').select();
		}
		
		function ambilDataDiag()
		{
			var sisip=b.getRowId(b.getSelRow()).split("|");
		}
		
		function loadRATerakhir(){
			//alert(document.getElementById('hsl_RA_terakhir').innerHTML);
			document.getElementById('txtRA').value = document.getElementById('hsl_RA_terakhir').innerHTML;	
		}
		
		function loadFormulirRM(){
			var data = a4.getRowId(a4.getSelRow()).split('|');
			
			getIdPel = data[0];
			getIdUnit = data[1];
			getJnsLay = data[2];
			
			document.getElementById('pelayanan_id').value=data[0];
			a2.loadURL("RM_utils.php?grd2=true&pelayanan_id="+document.getElementById('pelayanan_id').value,'','GET');
			
			loadData();
		}
		
		function loadDetail(){
			//alert(a4.getSelRow());
			detail(a4.getSelRow());
		}
		
		function detail(i){
			//jQuery("#divKunj").hide(500);
			//jQuery("#divDetil").slideToggle("slow");
			
			//document.getElementById('divKunj').style.display='none';
			//document.getElementById('divDetil').style.display='block';
			
			var data = a4.getRowId(i).split('|');
			if(getJnsLay!=data[2])
				cekTab(data[2]);
			
			getIdPel = data[0];
			getIdUnit = data[1];
			getJnsLay = data[2];
			
			document.getElementById('pelayanan_id').value=data[0];
			loadData();
		}
		
		function closeDetail(){
			//jQuery("#divDetil").hide(500);
			//jQuery("#divKunj").slideToggle("slow");
			
			//document.getElementById('divKunj').style.display='block';
			//document.getElementById('divDetil').style.display='none';
		}
		
		function loadData(){
			subj1.loadURL("soap_utils.php?grd=1&idPel="+getIdPel,'','GET');
			anam1.loadURL("tindiag_utils.php?grdAnamnesa=true&pasien_id="+getIdPasien,'','GET');
			b.loadURL("tindiag_utils.php?grd1=true&pelayanan_id="+getIdPel+"&kunjungan_id="+getIdKunj,"","GET");
			f.loadURL("tindiag_utils.php?grd=true&pelayanan_id="+getIdPel,"","GET");
			aResep.loadURL("tindiag_utils.php?grdRsp1=true&pelayanan_id="+getIdPel,"","GET");
		}
		
		function ambilDataResepDetail(){
			var sisip = aResep.getRowId(aResep.getSelRow()).split("|");
			aDet.loadURL("tindiag_utils.php?grdRsp2=true&pelayanan_id="+getIdPel+"&no_resep="+sisip[2]+"&apotek_id="+sisip[0]+"&tgl_resep="+sisip[1],"","GET");
		}
		
		function cekTab(a){
			if(a==57){
				mTab.setTabCaption2("ANAMNESIA,DIAGNOSA,TINDAKAN,RESEP");
				mTab.setTabDisplay("false,false,true,false,2");
				mTab.setTabCaptionWidth("0,0,900,0");
			}
			else if(a==60){
				mTab.setTabCaption2("ANAMNESIA,DIAGNOSA,TINDAKAN,RESEP");
				mTab.setTabDisplay("false,false,true,false,2");
				mTab.setTabCaptionWidth("0,0,900,0");
			}
			else{
				if(a != 44)
				{
					mTab.setTabCaption2("ANAMNESIA,DIAGNOSA,TINDAKAN,RESEP");
					mTab.setTabDisplay("true,true,true,true,0");
					mTab.setTabCaptionWidth("225,225,225,225");
					jQuery("#soap1").hide();
					jQuery("#anam").show();
				}else{
					mTab.setTabCaption2("SOAPIER,DIAGNOSA,TINDAKAN,RESEP");
					mTab.setTabDisplay("true,true,true,true,0");
					mTab.setTabCaptionWidth("225,225,225,225");
					jQuery("#soap1").show();
					jQuery("#anam").hide();
				}
			}	
		}
		
		function saring(){
			var tgl=document.getElementById('txtTgl').value;
			var no_rm=document.getElementById('txtFilter').value;
			var url='';
			
			if(document.getElementById('chkHistory').checked){
				url = "RM_utils.php?grdH=true&no_rm="+no_rm+"&filter="+a1.getFilter()+"&sorting="+a1.getSorting()+"&page="+a1.getPage();
			}
			else{
				url = "RM_utils.php?grd=true&tgl="+tgl+"&no_rm="+no_rm+"&filter="+a1.getFilter()+"&sorting="+a1.getSorting()+"&page="+a1.getPage();
			}
			a1.loadURL(url,"","GET");
		}
		
		function filterNoRM(ev,par){
			if(ev.which==13){
				if(isNaN(par.value) == true || par.value == ''){
					alert("Masukan Nomor Rekam Medis Dengan Benar !");
					//return;
				}
				
				var tgl=document.getElementById('txtTgl').value;
				var no_rm=document.getElementById('txtFilter').value;
				var url = "RM_utils.php?act=view&grd=true&tgl="+tgl+"&no_rm="+no_rm;
				a1.loadURL(url,"","GET");
			}
		}
		
		function pilihStatusMedik(){
			var data = a1.getRowId(a1.getSelRow()).split('|');
			document.getElementById('kunjungan_id').value=data[0];
			document.getElementById('norm').value=data[2];
			//alert(data[0]);
			if(document.getElementById('kunjungan_id').value==''){
				alert('Pilih pasien terlebih dahulu !');
				return false;
			}
			new Popup('divPilihan',null,{modal:true,position:'center',duration:1});
			document.getElementById('divPilihan').popup.show();	
		}
		
		function goFilterAndSort(grd){
			var tgl=document.getElementById('txtTgl').value;
			var no_rm=document.getElementById('txtFilter').value;
			var url = "RM_utils.php?grd=true&tgl="+tgl+"&no_rm="+no_rm;
			
			if (grd=="gridbox"){		
				url="RM_utils.php?grd=true&tgl="+tgl+"&filter="+a1.getFilter()+"&sorting="+a1.getSorting()+"&page="+a1.getPage();
				a1.loadURL(url,"","GET");
			}
		}

		function simpan(){
			if(confirm('Pasien dengan norm '+document.getElementById('norm').value+'. Apakah sudah benar ?')){			
				var cmbPilihan = document.getElementById('cmbPilihan').value;
				var tgl=document.getElementById('txtTgl').value;
				var no_rm=document.getElementById('txtFilter').value;
				
				var url = "RM_utils.php?act=save&grd=true&tgl="+tgl+"&no_rm="+no_rm+"&statusKeluar="+cmbPilihan+"&kunjungan_id="+document.getElementById('kunjungan_id').value+"&status_medik="+document.getElementById('status_medik').value;
				a1.loadURL(url,"","GET");
			}
		}
		
		function konfirmasi(key,val){
			
			if(key=='Error'){
				if(val=='transfer'){
					
				}
			}else{
				if(val=='view'){
				
				}
			}
			
		}
		

function fSetICD_RM(id){
	var zxc = b.cellsGetValue(b.getSelRow(),3);
	batalICD_RM();
	document.getElementById('lgn_icd').innerHTML="Kode ICD X";
	document.getElementById('spn_icd').innerHTML="&nbsp;&nbsp;ICD X";
	document.getElementById('id_diagnosa_ICD_RM').value=id;
	new Popup('divICD10',null,{modal:true,position:'rm',duration:1});
	//document.getElementById('divICD10').style.top='1000px';
	document.getElementById('divICD10').popup.show();
	document.getElementById('txtICD10').focus();
	
	if(document.getElementById('xxxicdrm_'+id).value=='1'){
		document.getElementById('trCatatan').style.display='table-row';
	}
	else{
		document.getElementById('trCatatan').style.display='none';
	}
}

function updateICD_RM(){
	var id_diagnosa_ICD_RM=document.getElementById('id_diagnosa_ICD_RM').value;
	var ms_diagnosa_ICD_RM=document.getElementById('ms_diagnosa_ICD_RM').value;
	var txtCatatan=document.getElementById('txtCatatan').value;
	var url;
	
	if (document.getElementById('lgn_icd').innerHTML=="Kode ICD X"){
		url = "ICD_RM_util.php?act=updateicdxrm&id_diagnosa_ICD_RM="+id_diagnosa_ICD_RM+"&ms_diagnosa_ICD_RM="+ms_diagnosa_ICD_RM+"&txtCatatan="+txtCatatan+"&user_act=<?php echo $userId; ?>";
	}else{
		url = "ICD_RM_util.php?act=updateicd9cm&id_diagnosa_ICD_RM="+id_diagnosa_ICD_RM+"&ms_diagnosa_ICD_RM="+ms_diagnosa_ICD_RM+"&txtCatatan="+txtCatatan+"&user_act=<?php echo $userId; ?>";
	}
	//alert(url);
	Request(url,'spn_ICD_RM','','GET',showICD_RM,'noload');
}
	
function showICD_RM(){
	var zxc;
	if(document.getElementById('spn_ICD_RM').innerHTML=='ok'){
		if (document.getElementById('lgn_icd').innerHTML=="Kode ICD X"){
			zxc = '<span style="color:#0000FF" title="Klik Untuk Mengubah ICD-10" onclick="fSetICD_RM('+document.getElementById('id_diagnosa_ICD_RM').value+');">'+document.getElementById('kode_diagnosa_ICD_RM').value+'</span>';
			b.cellsSetValue(b.getSelRow(),3,zxc);
			//document.getElementById('xxxicdrm_'+document.getElementById('id_diagnosa_ICD_RM').value).value='1';
			
		}else{
			zxc = '<span style="color:#0000FF" title="Klik Untuk Mengubah ICD-9CM" onclick="fSetICD_9CM('+document.getElementById('id_diagnosa_ICD_RM').value+');">'+document.getElementById('kode_diagnosa_ICD_RM').value+'</span>';
			f.cellsSetValue(f.getSelRow(),4,zxc);
			//document.getElementById('xxxicd9cm_'+document.getElementById('id_diagnosa_ICD_RM').value).value='1';
		}
		alert('simpan berhasil.');
		document.getElementById('divICD10').popup.hide();
	}
	else{
		alert('simpan gagal.');
	}
	batal('btnBatalDiag');
}

function suggest_ICD_RM(e,par){
	var keywords=par.value;//alert(keywords);
	if(e == 'cariDiag'){
		if(document.getElementById('divICD_RM').style.display == 'block'){
			document.getElementById('divICD_RM').style.display='none';
		}
		else{
			//alert(document.getElementById('lgn_icd').innerHTML);
			if (document.getElementById('lgn_icd').innerHTML=="Kode ICD X"){
				//alert('icd-x');
				Request('diagnosalist_ICD_RM.php?findAll=true&aKeyword='+keywords+'&unitId='+getIdUnit+'&PK=0' , 'divICD_RM', '', 'GET' );
			}else{
				//alert('icd-9cm');
				Request('diagnosalist_ICD_RM.php?findAll=true&aKeyword='+keywords+'&unitId='+getIdUnit+'&PK=0&is_icd9cm=1' , 'divICD_RM', '', 'GET' );
			}
			if (document.getElementById('divICD_RM').style.display=='none') fSetPosisi(document.getElementById('divICD_RM'),par);
			document.getElementById('divICD_RM').style.display='block';
		}
	}
	else{
		if(keywords==""){
			document.getElementById('divICD_RM').style.display='none';
		}else{
			var key;
			if(window.event) {
				key = window.event.keyCode;
			}
			else if(e.which) {
				key = e.which;
			}
			//alert(key);
			if (key==38 || key==40){
				var tblRow=document.getElementById('tblDiagnosa').rows.length;
				if (tblRow>0){
					//alert(RowIdx);
					if (key==38 && RowIdx>0){
						RowIdx=RowIdx-1;
						document.getElementById('lstDiag'+(RowIdx+1)).className='itemtableReq';
						if (RowIdx>0) document.getElementById('lstDiag'+RowIdx).className='itemtableMOverReq';
					}else if (key == 40 && RowIdx < tblRow){
						RowIdx=RowIdx+1;
						if (RowIdx>1) document.getElementById('lstDiag'+(RowIdx-1)).className='itemtableReq';
						document.getElementById('lstDiag'+RowIdx).className='itemtableMOverReq';
					}
				}
			}
			else if (key==13){
				if (RowIdx>0){
					if (fKeyEnt==false){
						fSetICDX_RM(document.getElementById('lstDiag'+RowIdx).lang);
					}else{
						fKeyEnt=false;
					}
				}
			}
			else if (key!=27 && key!=37 && key!=39){
				RowIdx=0;
				fKeyEnt=false;
				//alert(document.getElementById('lgn_icd').innerHTML);
				if (document.getElementById('lgn_icd').innerHTML=="Kode ICD X"){
					//alert('icd-x');
					Request('diagnosalist_ICD_RM.php?aKeyword='+keywords+'&unitId='+getIdUnit+'&PK=0', 'divICD_RM', '', 'GET' );
				}else{
					//alert('icd-9cm');
					Request('diagnosalist_ICD_RM.php?aKeyword='+keywords+'&unitId='+getIdUnit+'&PK=0&is_icd9cm=1', 'divICD_RM', '', 'GET' );
				}
				if (document.getElementById('divICD_RM').style.display=='none') fSetPosisi(document.getElementById('divICD_RM'),par);
				document.getElementById('divICD_RM').style.display='block';
			}
		}
	}
}

function fSetICDX_RM(par){
	var cdata=par.split("*|*");
	document.getElementById("ms_diagnosa_ICD_RM").value=cdata[0];
	document.getElementById("kode_diagnosa_ICD_RM").value=cdata[2];
	document.getElementById("txtICD10").value=cdata[2]+" - "+cdata[1];
	document.getElementById('divICD_RM').style.display='none';
}

function batalICD_RM(){
	document.getElementById('id_diagnosa_ICD_RM').value='';
	document.getElementById('ms_diagnosa_ICD_RM').value='';
	document.getElementById('kode_diagnosa_ICD_RM').value='';
	document.getElementById('txtICD10').value='';
	document.getElementById('txtCatatan').value='';
	document.getElementById('divICD_RM').style.display='none';
}

function fSetKasusICD_RM(id){
	document.getElementById('id_diagnosa_ICD_RM').value=id;
	new Popup('divKasusICD10',null,{modal:true,position:'rm',duration:1});
	document.getElementById('divKasusICD10').popup.show();
}

function updateKasusICD_RM(){
	var id_diagnosa_ICD_RM=document.getElementById('id_diagnosa_ICD_RM').value;
	var ms_diagnosa_ICD_RM=document.getElementById('ms_diagnosa_ICD_RM').value;
	var url;
	
	url = "ICD_RM_util.php?act=updatekasusicdxrm&kasus_baru="+document.getElementById('cmbKasusDiag').value+"&ms_diagnosa_ICD_RM="+ms_diagnosa_ICD_RM+"&id_diagnosa_ICD_RM="+id_diagnosa_ICD_RM+"&user_act=<?php echo $userId; ?>";
	
	Request(url,'spn_Kasus_ICD_RM','','GET',showKasusICD_RM,'noload');
}

function showKasusICD_RM(){
	if(document.getElementById('spn_Kasus_ICD_RM').innerHTML=='ok'){
		var labelKasusICD=document.getElementById('cmbKasusDiag').options[document.getElementById('cmbKasusDiag').options.selectedIndex].label;
		zxc = '<span style="color:#0000FF" title="Klik Untuk Mengubah Kasus ICD-10" onclick="fSetKasusICD_RM('+document.getElementById('id_diagnosa_ICD_RM').value+');">'+labelKasusICD+'</span>';
		b.cellsSetValue(b.getSelRow(),6,zxc);
		alert('simpan berhasil.');
		document.getElementById('divKasusICD10').popup.hide();
	}
	else{
		alert('simpan gagal.');
	}
	batal('btnBatalDiag');	
}

function batal(id){		
	if (id != undefined && id != ""){
		if (document.getElementById(id)) document.getElementById(id).disabled = false;
	}
	switch(id){
		case 'btnBatalDiag':
			var p="diagnosa_id*-**|*txtDiag*-**|*btnSimpanDiag*-*Tambah*|*btnSimpanDiag*-*false*|*btnHapusDiag*-*true";
			fSetValue(window,p);
			document.getElementById('chkPenyebabKecelakaan').checked='';
			document.getElementById('trPenyebab').style.display='none';
			document.getElementById('chkAkhir').checked='';
			break;
	}
}

function fSetICD_9CM(id){
	batalICD_RM();
	document.getElementById('lgn_icd').innerHTML="Kode ICD-9CM";
	document.getElementById('spn_icd').innerHTML="ICD-9CM";
	document.getElementById('id_diagnosa_ICD_RM').value=id;
	new Popup('divICD10',null,{modal:true,position:'rm',duration:1});
	document.getElementById('divICD10').popup.show();
	document.getElementById('txtICD10').focus();
	
	if(document.getElementById('xxxicd9cm_'+id).value=='1'){
		document.getElementById('trCatatan').style.display='table-row';
	}
	else{
		document.getElementById('trCatatan').style.display='none';
	}
}

function cetak_resume2()
{
	var id_anamnesia1 = anam1.getRowId(anam1.getSelRow()).split("|");
	window.open('../unit_pelayanan/resumemedis.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idPasien='+getIdPasien+'&id_anamnesa='+id_anamnesia1[0]+'&userId=<?php echo $userId; ?>&rm=1','_blank');
}

function viewHistory(c){
	var tgl=document.getElementById('txtTgl').value;
	var no_rm = document.getElementById('txtFilter').value;
	var url = '';
	
	if(c.checked){
		url = "RM_utils.php?grdH=true&no_rm="+no_rm+"&filter="+a1.getFilter()+"&sorting="+a1.getSorting()+"&page="+a1.getPage();
	}
	else{
		url = "RM_utils.php?act=view&grd=true&tgl="+tgl+"&no_rm="+no_rm+"&filter="+a1.getFilter()+"&sorting="+a1.getSorting()+"&page="+a1.getPage();
	}
	a1.loadURL(url,"","GET");
}

function load_popup_iframe(leg,url){
	//alert(leg+' '+url);
	window.scroll(0,0);
	jQuery('#legend_popup_iframe').html(leg);
	jQuery('#popup_iframe').attr('src',url+"&idKunj="+getIdKunj+"&idPel="+getIdPel+"&idUsr=<?=$userId?>");
	new Popup('div_popup_iframe',null,{modal:true,position:'top',duration:1});
	document.getElementById('div_popup_iframe').popup.show();
	//alert(document.getElementById('popup_iframe').src);
}

function resizeIframe(obj) {
	jQuery("#popup_iframe").height(450);
	var a = obj.contentWindow.document.body.scrollHeight
	obj.style.height = a + 'px';
	if(a<heightOvr){
		document.getElementById('popup_overlay').style.height=(heightOvr+100)+'px';
	}else if(a != 0){
		document.getElementById('popup_overlay').style.height=(a+100)+'px';
	}
}
	
var heightOvr=0;	
function loadHeight(){
	heightOvr=document.body.scrollHeight;
}

function alertsize(pixels){
    pixels+=10;
	jQuery(".framex").animate({height:pixels+"px"},'slow');
	if(pixels<heightOvr){
		window.scrollTo(0,0);
	}else{
		document.getElementById('popup_overlay').style.height=(pixels+100)+'px';		
	}
}

function resizeAwal() {
	jQuery("#div_popup_iframe").height();
	jQuery("#popup_iframe").height(430);
}

function rekamMedis(){
	window.open('../unit_pelayanan/rekamMedis.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idPasien='+getIdPasien,'rekam_medis');
}

function resumeMedis(){
	window.open('../unit_pelayanan/resumemedis.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idPasien='+getIdPasien,'_blank');
}

function tampilPerlakuan(){
	window.scroll(0,0);
	new Popup('pKhusus',null,{modal:true,position:'center',duration:1});
	document.getElementById('pKhusus').popup.show();
}

function simpanPerlakuan(){
	var kon1;
	
	if(document.getElementById('psnKomplain').checked){
		kon1 = "2";
	}else{
		kon1 = "0";
	}
	if(document.getElementById('psnPemilik').checked){
		kon1 += ",3";
	}else{
		kon1 += ",0";
	}
	if(document.getElementById('psnPejabat').checked){
		kon1 += ",10";
	}else{
		kon1 += ",0";
	}
	jQuery("#loadGambar1").load("../unit_pelayanan/update_in_out.php?getIdPasien="+getIdPasien+"&kh=true&kon1="+kon1,'',function(){
		alert("update status berhasil");
		jQuery("#loadGambar").load("../unit_pelayanan/gambar1.php?id_pasien="+getIdPasien);
	});
}

setInterval('saring()',15000);
</script>
<script language="JavaScript1.2">mmLoadMenus();</script>