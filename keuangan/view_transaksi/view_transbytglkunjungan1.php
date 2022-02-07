<?php
include '../secured_sess.php';
$userId=$_SESSION['id'];
$tipe = $_REQUEST['tipe'];
$pLegend = "View Transaksi -> Kunjungan Pasien -> Berdasarkan Tanggal Berkunjung";
$jdlPage="DATA TRANSAKSI PASIEN BERDASARKAN TANGGAL BERKUNJUNG";
$styleKso="block;";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <title>.: Data Transaksi Kunjungan Pasien :.</title>
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
	$jam=gmdate('H:i',mktime(date('H')+7));
    $th=explode("-",$tgl);
    ?>
    <body bgcolor="#808080" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="loadUlang();"><!-- onload="viewTime()"-->
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
                <tr>
                    <td valign="top" align="center">
                        <table border="0" cellpadding="2" cellspacing="2" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold">
                            <tr height="35">
                                <td colspan="2" align="center"><?php echo $jdlPage; ?></td>
                            </tr>
                            <tr height="25" id="trKSO">
                                <td>Nama KSO</td>
                                <td>:&nbsp;
                                    <select id="cmbKso" name="cmbKso" onchange="filter()" class="txtinput"></select>                                </td>
                            </tr>
							<tr>
                                <td>Waktu</td>
                                <td>:&nbsp;
                                    <select id="cmbTime" onchange="viewTime(this)" class="txtinput">
                                        <option value="harian" selected>HARIAN</option>
                                        <!--option value="bulan">Bulanan</option-->
                                        <option value="periode">PERIODE</option>
                                    </select>
                                </td>
                            </tr>
                            <tr id="trDay">
                                <td>Tanggal Kunjungan</td>
                                <td>:&nbsp;
                                    <input id="txtTgl" name="txtTgl" readonly size="11" class="txtcenter" type="text" value="<?php echo $tgl; ?>" />&nbsp;
                                    <input type="button" id="btnTgl" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('txtTgl'),depRange,filter);"/>
                                </td>
                            </tr>
							<tr id="trPer" style="display:none">
                                <td>Periode Kunjungan</td>
                                <td>:&nbsp;
                                    <input id="tglFirst" name="tglFirst" readonly size="11" class="txtcenter" type="text" value="<?php echo $tgl; ?>" />&nbsp;
                                    <input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('tglFirst'),depRange,filter);"/>
                                    s.d.
                                    <input id="tglLast" name="tglLast" readonly size="11" class="txtcenter" type="text" value="<?php echo $tgl; ?>" />&nbsp;
                                    <input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('tglLast'),depRange,filter);"/>
                                </td>
                            </tr>
                            <tr id="trBln" style="display:none">
                                <td>
                                    Bulan
                                </td>
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
                                    </select>
                                </td>
                            </tr>
                        </table>
                  </td>
                </tr>
                <tr id="trPen">
                    <td align="center" ><br>
                        <!--div align="right" style="padding-right:20px;">
                            <button id="btnSimpan" name="btnSimpan" type="button" class="tblBtn" onclick="fPopPxPulang();">Set Tgl Pulang</button>
                        </div-->
                        <fieldset style="width:980px">
                            <div id="gridbox" style="width:990px; height:330px; background-color:white; overflow:hidden;"></div>
                            <div id="paging" style="width:990px;"></div>
                            <!--div align="left" style="padding-right:100px;">
                                <table style="display:none">
                                    <tr>
                                        <td>
                                            Total Tarif Perda
                                        </td>
                                        <td>
                                            : <span id="span_tot1" style="margin-left:20px;float:right;">&nbsp;</span>
                                        </td>
                                        <td style="padding-left:20px;">
                                            Total Biaya Pasien 
                                        </td>
                                        <td>
                                            : <span id="span_tot3" style="margin-left:20px;float:right;">&nbsp;</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Total Jaminan KSO 
                                        </td>
                                        <td>
                                            : <span id="span_tot2" style="margin-left:20px;float:right;">&nbsp;</span>
                                        </td>
                                        <td style="padding-left:20px;">
                                            Selisih Biaya
                                        </td>
                                        <td>
                                            : <span id="span_sel" style="margin-left:20px;float:right;">&nbsp;</span>
                                        </td>
                                    </tr>
                                </table>
                            </div-->
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
        <div id="divPop" class="popup" style="width:1000px;height:400px;display:none;">
            <fieldset>
                <legend style="float:right">
                    <div style="float:right; cursor:pointer" class="popup_closebox">
                        <img alt="close" src="../icon/cancel.gif" height="16" width="16" align="absmiddle"/>Tutup</div>
                </legend>
                <table>
                    <tr>
                        <td>
                            <div id="gridbox_pop" style="width:990px; height:345px; background-color:white; "></div>
                            <div id="paging_pop" style="width:990px;"></div>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </div>
        <!--div id="divPopSetPxPulang" class="popup" style="width:300px;height:160px;display:none;">
            <fieldset>
                <legend style="float:right">
                    <div style="float:right; cursor:pointer" class="popup_closebox">
                        <img alt="close" src="../icon/cancel.gif" height="16" width="16" align="absmiddle"/>Tutup</div>
                </legend><br /><br /><span id="spnPxPlg" style="display:none;"></span>
                <table width="300px">
                    <tr>
                        <td>Tgl Pulang</td>
                        <td>:&nbsp;<input id="txtTglPlg" name="txtTglPlg" readonly size="11" class="txtcenter" type="text" value="" />&nbsp;
                                    <input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('txtTglPlg'),depRange,fSetTglPlg);"/>
                        </td>
                	</tr>
                    <tr>
                        <td>Jam Pulang</td>
                        <td>:&nbsp;<input id="txtJPulang" name="txtJPulang" size="5" class="txtcenter" type="text" value="<?php echo $jam; ?>" />                        </td>
                    </tr>
                    <tr>
                        <td>Tgl Pengakuan</td>
                        <td>:&nbsp;<input id="txtTglPlgP" name="txtTglPlgP" readonly size="11" class="txtcenter" type="text" value="" />&nbsp;
                                    <input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('txtTglPlgP'),depRange,fSetTglPlgP);"/>
                        </td>
                	</tr>
                    <tr>
                    	<td colspan="2" height="20">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td colspan="2" align="center"><button id="btnSimpanTglPlg" name="btnSimpanTglPlg" type="button" class="tblBtn" onclick="fSetPxPulang();">Simpan</button></td>
                    </tr>
                </table>
            </fieldset>
        </div-->
        <?php include("../laporan/report_form.php");?>
    </body>
    <script type="text/JavaScript" language="JavaScript">
		function ExportExcell(p){
		var url;
			OpenWnd(url,600,450,'childwnd',true);
		}
        
		function riwayat(){
			var sisip = a.getRowId(a.getSelRow()).split('|');
			window.open("../../billing/informasi/riwayat_pelayanan.php?idKunj="+sisip[0]+"&idPas="+sisip[2],'_blank');
		}
		
		function isiCombo(id,val,defaultId,targetId,evloaded){
            if(targetId=='' || targetId==undefined){
                targetId=id;
            }
            Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'ok');
            //alert('combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId);
        }
		
        //isiCombo('cmbKso');
		isiCombo('cmbKsoAll','','','cmbKso');

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
			var timeFil = document.getElementById('cmbTime').value;
			var kso = document.getElementById('cmbKso').value;
			var txtTgl = document.getElementById('txtTgl').value;
            // var url = "view_transbytglkunjungan_utils.php?grid=1&ksoId="+kso+"&txtTgl="+txtTgl+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage();
            var url = "view_transbytglkunjungan_utils.php?grid=1&ksoId="+kso+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage();
            //alert(url);
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
            a.loadURL(url,"","GET");
        }

		function loadUlang(){
			//alert(document.getElementById('divPop').style.display);
			filter(1);
			//alert('refresh');
			setTimeout("loadUlang()","60000");
		}

        function filter(par){
            var kso = document.getElementById('cmbKso').value;
			var txtTgl = document.getElementById('txtTgl').value;
			document.getElementById('btnTgl').disabled=true;
			var timeFil = document.getElementById('cmbTime').value;
            var url = "view_transbytglkunjungan_utils.php?grid=1&ksoId="+kso+"&txtTgl="+txtTgl;
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
			a.loadURL(url,"","GET");
        }
        
        var first_time = true;
        
        var kunj_id;
        function ambilData(){
            var sisip = a.getRowId(a.getSelRow()).split('|');
			var url;
			kunj_id = sisip[0];
			url = "view_transbytglkunjungan_utils.php?grid=2&kunj_id="+sisip[0]+"&ksoId="+sisip[1];
			//alert(url);
            b.loadURL(url,'','GET');
            new Popup('divPop',null,{modal:true,position:'center',duration:0.5})
            $('divPop').popup.show();
        }
        
        function count_tot(key,val){
            if (val!=undefined){
                var tmp36 = val.split(String.fromCharCode(3));
				a.cellSubTotalSetValue(7,tmp36[0]);
				a.cellSubTotalSetValue(8,tmp36[1]);
				a.cellSubTotalSetValue(9,tmp36[2]);
				a.cellSubTotalSetValue(10,tmp36[3]);
				a.cellSubTotalSetValue(11,tmp36[4]);
				a.cellSubTotalSetValue(12,tmp36[5]);
            }
            else if(a.getRowId(a.getSelRow())==''){
				a.cellSubTotalSetValue(7,0);
				a.cellSubTotalSetValue(8,0);
				a.cellSubTotalSetValue(9,0);
				a.cellSubTotalSetValue(10,0);
				a.cellSubTotalSetValue(11,0);
				a.cellSubTotalSetValue(12,0);
            }
			document.getElementById('btnTgl').disabled=false;
        }
        
        function count_tot_detail(key,val){
            if (val!=undefined){
                var tmp36 = val.split(String.fromCharCode(3));
				b.cellSubTotalSetValue(7,tmp36[0]);
				b.cellSubTotalSetValue(8,tmp36[1]);
				b.cellSubTotalSetValue(9,tmp36[2]);
				b.cellSubTotalSetValue(10,tmp36[3]);
				b.cellSubTotalSetValue(11,tmp36[4]);
				b.cellSubTotalSetValue(12,tmp36[5]);
            }
            else if(b.getRowId(b.getSelRow())==''){
				b.cellSubTotalSetValue(7,0);
				b.cellSubTotalSetValue(8,0);
				b.cellSubTotalSetValue(9,0);
				b.cellSubTotalSetValue(10,0);
				b.cellSubTotalSetValue(11,0);
				b.cellSubTotalSetValue(12,0);
            }
        }
        
		//var jenis_layanan = unit_id = inap = '089';
        var ksoId = document.getElementById('cmbKso').value;
		if ("<?php echo $tipeNotif ?>"=="1") ksoId = "0";
        var a=new DSGridObject("gridbox");
        a.setHeader("DATA TRANSAKSI KUNJUNGAN PASIEN");
		a.setColHeader("NO,TANGGAL KUNJUNGAN,NO RM,NAMA,KSO,UNIT AWAL MASUK,TARIF RS,BIAYA PASIEN,TARIF KSO,IUR BAYAR,BAYAR PASIEN,SELISIH");
		a.setSubTotal(",,,,,SubTotal :&nbsp;,0,0,0,0,0,0");
		a.setIDColHeader(",tgl,no_rm,nama,nmkso,unit_awal,,,,,,");
		a.setColWidth("30,70,60,150,120,120,70,70,70,70,70,70");
		a.setCellAlign("center,center,center,left,center,center,right,right,right,right,right,right");
		a.setSubTotalAlign("center,center,center,left,center,right,right,right,right,right,right,right");
        a.setCellHeight(20);
        a.setImgPath("../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowDblClick","ambilData");
        a.onLoaded(count_tot);
		//alert("view_transbytglkunjungan_utils.php?grid=1&ksoId="+ksoId+"&txtTgl="+document.getElementById('txtTgl').value);
		a.baseURL("view_transbytglkunjungan_utils.php?grid=1&ksoId="+ksoId+"&txtTgl="+document.getElementById('txtTgl').value);
        a.Init();

        var b=new DSGridObject("gridbox_pop");
        b.setHeader("DETAIL TRANSAKSI KUNJUNGAN PASIEN");
		b.setColHeader("NO,TGL TINDAKAN,TEMPAT LAYANAN,KSO,TINDAKAN / OBAT,PELAKSANA,TARIF RS,BIAYA PASIEN,TARIF KSO,IUR BAYAR,BAYAR PASIEN,SELISIH");
		b.setSubTotal(",,,,,SubTotal :&nbsp;,0,0,0,0,0,0");
		b.setIDColHeader(",tgl,unit,nmkso,nmTind,dokter,,,,,,");
		b.setColWidth("30,70,150,130,180,150,70,70,70,70,70,70");
		b.setCellAlign("center,center,left,center,left,left,right,right,right,right,right,right");
		b.setSubTotalAlign("center,center,center,center,left,right,right,right,right,right,right,right");
        b.setCellHeight(20);
        b.setImgPath("../icon");
        b.setIDPaging("paging_pop");
        b.onLoaded(count_tot_detail);
        b.baseURL("view_transbytglkunjungan_utils.php?grid=2&kunj_id=0&ksoId=0");
        b.Init();
		
        var th_skr = "<?php echo $date_skr[2];?>";
        var bl_skr = "<?php echo ($date_skr[1]<10)?substr($date_skr[1],1,1):$date_skr[1];?>";
		var fromHome=<?php echo $fromHome ?>;
    </script>
    <script src="../report_form.js" type="text/javascript" language="javascript"></script>
</html>