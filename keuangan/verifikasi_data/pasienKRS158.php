<?php
//include("../sesi.php");
include '../secured_sess.php';
$userId=$_SESSION['id'];
$tipe = $_REQUEST['tipe'];
$caption = ($tipe==1)?'RAWAT JALAN':(($tipe==2)?'RAWAT INAP':(($tipe==3)?'IGD':'PER UNIT'));

$pLegend = "Verifikasi Data -> Pasien KRS";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <title>.: Pendapatan / Piutang :.</title>
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
                <tr>
                    <td valign="top" align="center">
                        <table border="0" cellpadding="2" cellspacing="2" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold">
                            <tr height="30">
                              <td colspan="2" align="center">Pendapatan / Piutang Billing</td>
                            </tr>
                            <tr height="30" id="trKSO" style="display:none">
                                <td width="110" style="padding-left:50px;">Status Px</td>
                                <td>:&nbsp;
                                    <select id="cmbKso" name="cmbKso" onchange="kirim()" class="txtinputreg"></select>                                </td>
                            </tr>
                            <tr style="display:none">
                                <td style="padding-left:150px">Waktu</td>
                                <td>:&nbsp;
                                    <select id="cmbTime" onchange="viewTime(this)" class="txtinputreg">
                                        <option value="harian">Harian</option>
                                        <option value="bulan">Bulanan</option>
                                        <option value="periode" selected>Periode</option>
                                    </select>                                </td>
                            </tr>
                            <tr id="trDay" style="display:none;">
                                <td style="padding-left:50px;">TGL KRS</td>
                                <td>:&nbsp;
									<input id="txtTgl" name="txtTgl" readonly size="11" class="txtcenter" type="text" value="<?php echo $tgl; ?>" />&nbsp;
									<input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('txtTgl'),depRange,kirim);"/>								</td>
                            </tr>
							
							 <tr id="trDay">
							   <td style="padding-left:50px;">Kasir</td>
							   <td>:&nbsp;
							   <select id="cmbKasir" name="cmbKasir" class="txtinput" onChange="kirim()">
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
							 <tr id="trDay">
                                <td style="padding-left:50px;">TGL Pulang </td>
                                <td>:&nbsp;
                                  <input id="txtTglSlip" name="txtTglSlip" readonly size="11" class="txtcenter" type="text" value="<?php echo $tgl; ?>" />
                                  &nbsp;
									<input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('txtTglSlip'),depRange,kirim);"/>							   </td>
                            </tr>
							
                             <tr id="">
                               <td style="padding-left:50px">No Bukti </td>
                               <td>:&nbsp;
							   <input id="noSlip" name="noSlip" size="30" class="txtinput"  type="text" value="" />&nbsp;</td>
                             </tr>
                            <tr id="trPer" style="display:none">
                                <td style="padding-left:50px">Periode</td>
                                <td>:&nbsp;
                                    <input id="tglFirst" name="tglFirst" readonly size="11" class="txtcenter" type="text" value="<?php echo $tgl; ?>" />&nbsp;
                                    <input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('tglFirst'),depRange,kirim);"/>
                                    s.d.
                                    <input id="tglLast" name="tglLast" readonly size="11" class="txtcenter" type="text" value="<?php echo $tgl; ?>" />&nbsp;
                                    <input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('tglLast'),depRange,kirim);"/>                                </td>
                            </tr>
                            <tr id="trBln" style="display:none">
                                <td style="padding-left:50px">
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
                                    <select id="thn" name="thn" onchange="filter()" class="txtinputreg">goFilterAndSort('gridbox')
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
                                <td style="padding-left:50px">
                                    Jenis Layanan                                </td>
                                <td>:&nbsp;
                                    <select id="cmbJnsLay" class="txtinput" onchange="fill_unit()" >
                                    </select>                                </td>
                            </tr>
                            <tr id="tr_unit" style="display:none">
                                <td style="padding-left:50px">
                                    Unit Layanan                                </td>
                                <td>:&nbsp;
                                    <select id="cmbTmpLay" class="txtinput" lang="" onchange="filter();">
                                    </select>                                </td>
                            </tr>
                        </table>
                  </td>
                </tr>
                <tr id="trPen">
                    <td align="center" >
                        <table width="950px" border="0" cellpadding="0" cellspacing="0">
                        	<tr>
                            	<td style="padding-left:10px;"><select id="cmbPost" name="cmbPost" class="txtinput" style="background-color:#FFFFCC; color:#990000;" onChange="if(this.value==0){document.getElementById('spnBtnVer').innerHTML='&nbsp;Verifikasi';}else{document.getElementById('spnBtnVer').innerHTML='&nbsp;UnVerifikasi';};kirim();">
                                    <option value="0">BELUM VERIFIKASI</option>
                                    <option value="1">SUDAH VERIFIKASI</option>
                                </select></td>
                                <td align="right" style="padding-right:10px;"><!--button id="btnRincian" name="btnRincian" type="button" onclick="RincianTindakan();">Rincian Tindakan</button-->&nbsp;&nbsp;<BUTTON type="button" id="btnVerifikasi" onClick="VerifikasiJurnal();"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle"><span id="spnBtnVer">&nbsp;Verifikasi</span></BUTTON></td>
                            </tr>
                        </table>
                    </td>
                </tr>
				<tr>
					<td>
						 <fieldset style="width:900px">
                            <div id="gridboxRkp" style="width:970px; height:200px; background-color:white;"></div>
                            <!--div id="pagingRkp" style="width:950px;"></div-->
							
                        </fieldset>
					</td>
				</tr>
				<tr>
					<td>
					<br />
					</td>
				</tr>
                <tr id="trPenDetail">
                    <td align="center" >
                        <table width="950px" border="0" cellpadding="0" cellspacing="0">
                        	<tr>
                            	<td style="padding-left:10px;">&nbsp;</td>
                                <td align="right" style="padding-right:10px;"><button id="btnRincian" name="btnRincian" type="button" onclick="RincianTindakan();">Rincian Tindakan</button></td>
                            </tr>
                        </table>
                    </td>
                </tr>
				<tr>
					<td>
						<fieldset style="width:900px">
                            <div id="gridbox" style="width:970px; height:250px; background-color:white;"></div>
                             <div id="paging" style="width:970px;"></div>
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
        <div id="divPopLoading" class="popup" style="width:32px;height:32px;display:none;">
                <legend style="float:right">
                    <div style="float:right; cursor:pointer" class="popup_closebox"></div>
                </legend>
            <img src="../images/ajax.gif" />
        </div>
        <?php include("../laporan/report_form.php");?>
    </body>
    <script type="text/JavaScript" language="JavaScript">
		function ExportExcell(p){
		var url;
			url='../laporan/rpt_pendapatan_excell.php?tgl_d='+document.getElementById('txtTgl').value+'&tipe=<?php echo $tipe; ?>&tipePend=0&kso='+document.getElementById('cmbKso').value+'&kson='+document.getElementById('cmbKso').options[document.getElementById('cmbKso').options.selectedIndex].label;
			OpenWnd(url,600,450,'childwnd',true);
		}
        
		function RincianTindakan(){
			var sisip = a.getRowId(a.getSelRow()).split('|');
			//window.open("../../billing/informasi/riwayat_pelayanan.php?idKunj="+sisip[0],'_blank');
			window.open("../../billing/unit_pelayanan/RincianTindakanAllPel.php?idKunj="+sisip[0]+"&tipe=2",'_blank');
		}
		
		function isiCombo(id,val,defaultId,targetId,evloaded){
            if(targetId=='' || targetId==undefined){
                targetId=id;
            }
            Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'ok');
            //alert('combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId);
        }
		
        isiCombo('cmbKso');

		var isShow=0;
		function ShowLoadImg(){
			isShow=1;
            new Popup('divPopLoading',null,{modal:true,position:'center',duration:0.5})
            $('divPopLoading').popup.show();			
		}

		function HideLoadImg(){
			isShow=0;
            $('divPopLoading').popup.hide();			
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

    /*    function goFilterAndSort(grd){
		
		
            timeFil = document.getElementById('cmbTime').value;
            kso = document.getElementById('cmbKso').value;
            var url = "pasienKRS_utils_joker_tes.php?grid=1&tipe=<?php echo $tipe;?>&tipePend=0&kso="+kso+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage();
            var tglA,tglZ;
            switch(timeFil){
                case 'harian':
                    tglA = document.getElementById('txtTgl').value;
                    url += "&waktu="+timeFil+"&txtTgl="+tglA;
                    break;
                case 'periode':
                    tglA = document.getElementById('tglFirst').value;
                    tglZ = document.getElementById('tglLast').value;
                    url += "&waktu="+timeFil+"&txtTgl="+tglA+"&txtTgl2="+tglZ;
                    break;
                case 'bulan':
                    bln = document.getElementById('bln').value;
                    thn = document.getElementById('thn').value;
                    url += "&waktu="+timeFil+"&bln="+bln+"&thn="+thn;
                    break;
            }
            //alert(url);
            a.loadURL(url,"","GET");
			
			
        }*/
		
	function goFilterAndSort(grd){
	var url,tmp;
		//alert(grd);
		if (grd=="gridboxRkp")
		{		
			 timeFil = document.getElementById('cmbTime').value;
            kso = document.getElementById('cmbKso').value;
            var url = "pasienKRS_utils_joker_tes.php?grid=1Rkp&tipe=<?php echo $tipe;?>&tipePend=0&kso="+kso+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage();
            var tglA,tglZ;
            a.loadURL(url,"","GET");
		}else if (grd=="gridbox"){
			timeFil = document.getElementById('cmbTime').value;
            kso = document.getElementById('cmbKso').value;
            var url = "pasienKRS_utils_joker_tes.php?grid=piutangDetail&tipe=<?php echo $tipe;?>&tipePend=0&kso="+kso+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage();
            var tglA,tglZ;
            a.loadURL(url,"","GET")
		}

	}
	

        function filter(par){
            if(par==undefined) par = "1";
			//if(par==undefined) par = 1;
            timeFil = document.getElementById('cmbTime').value;
            kso = document.getElementById('cmbKso').value;
            var url = "pasienKRS_utils_joker_tes.php?grid="+par;
            if(par == "1Rkp"){
                url += "&kso="+kso;
            }
            else if(par == "1"){
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
                    url += "&waktu="+timeFil+"&txtTgl="+tglA+"&txtTgl2="+tglZ;
                    break;
                case 'bulan':
                    bln = document.getElementById('bln').value;
                    thn = document.getElementById('thn').value;
                    url += "&waktu="+timeFil+"&bln="+bln+"&thn="+thn;
                    break;
            }
            //alert(url)
            if(par == "1Rkp"){
                aRkp.loadURL(url,"","GET");
            }
            else if(par == "1"){
				a.loadURL(url,"","GET");
            }
            else{
                b.loadURL(url,'','GET');
            }
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
        
        function ambilDataRkp(){
            kunjungan_id = aRkp.getRowId(aRkp.getSelRow()).split('|');
            filter(2);
            new Popup('divPop',null,{modal:true,position:'center',duration:0.5})
            $('divPop').popup.show();
        }
		
		function ambilDataDetail(){
			var tmp = aRkp.getRowId(aRkp.getSelRow()).split('|');
            var url;
			var cmbPost = document.getElementById('cmbPost').value;
			//var kso = document.getElementById('cmbKso').value;
			var kso = tmp[10];
			var TglA = document.getElementById('tglFirst').value;
			var TglB = document.getElementById('tglLast').value;
			var tglslip = document.getElementById('txtTglSlip').value;
			var tmpTglA = TglA.split("-");
			var tmpTglB = TglB.split("-");
			tmpTglA=tmpTglA[2]+'-'+tmpTglA[1]+'-'+tmpTglA[0];
			tmpTglB=tmpTglB[2]+'-'+tmpTglB[1]+'-'+tmpTglB[0];
				
			url="pasienKRS_utils_joker_tes.php?grid=piutangDetail&txtTgl="+TglA+"&txtTgl2="+TglB+"&kso="+kso+"&posting="+cmbPost+"&tglslip="+tglslip+"&kasir="+tmp[8]+"&slipke="+tmp[9];
			//alert(url);
			a.loadURL(url,'','GET');
	}
		
		

        function konfirmasi(key,val){
			//alert(key+"====="+val);
            if (val!=undefined){
                var tmp36 = val.split(String.fromCharCode(3));
				if (tmp36[6]=="1Rkp"){
					ambilDataDetail();
					aRkp.cellSubTotalSetValue(5,tmp36[4]);
				}else{
					a.cellSubTotalSetValue(8,tmp36[0]);
					a.cellSubTotalSetValue(9,tmp36[1]);
					a.cellSubTotalSetValue(10,tmp36[2]);
					a.cellSubTotalSetValue(11,tmp36[3]);
					a.cellSubTotalSetValue(12,tmp36[4]);
					document.getElementById('btnVerifikasi').disabled=false;
					document.getElementById('btnRincian').disabled=false;
					if (tmp36[5]!=""){
						//alert(tmp36[5]);
					}
				}
            }else{
				a.cellSubTotalSetValue(8,0);
				a.cellSubTotalSetValue(9,0);
				a.cellSubTotalSetValue(10,0);
				a.cellSubTotalSetValue(11,0);
				a.cellSubTotalSetValue(12,0);
				document.getElementById('btnVerifikasi').disabled=true;
				document.getElementById('btnRincian').disabled=true;
			}
			document.getElementById('chkAll').checked=false;
			
			if (isShow==1){
				HideLoadImg();
			}
        }
	
		function chkKlik(p){
		var cekbox=(p==true)?1:0;
			//alert(p);
			for (var i=0;i<aRkp.getMaxRow();i++){
			//for (var i=0;i<a.getMaxRow();i++){
				aRkp.cellsSetValue(i+1,6,cekbox);
				//a.cellsSetValue(i+1,13,cekbox);
			}
		}

		function kirim(){
			var url;
			var cmbPost = document.getElementById('cmbPost').value;
			var kso = document.getElementById('cmbKso').value;
			var TglA = document.getElementById('tglFirst').value;
			var TglB = document.getElementById('tglLast').value;
			var tglslip = document.getElementById('txtTglSlip').value;
			var tmpTglA = TglA.split("-");
			var tmpTglB = TglB.split("-");
			tmpTglA=tmpTglA[2]+'-'+tmpTglA[1]+'-'+tmpTglA[0];
			tmpTglB=tmpTglB[2]+'-'+tmpTglB[1]+'-'+tmpTglB[0];
			
			
			url="pasienKRS_utils_joker_tes.php?grid=1Rkp&txtTgl="+TglA+"&txtTgl2="+TglB+"&kso="+kso+"&posting="+cmbPost+"&tglslip="+tglslip;
			//alert(url);
			//if (tmpTglB>=tmpTglA){
				document.getElementById('btnVerifikasi').disabled=true;
				ShowLoadImg();
				aRkp.loadURL(url,"","GET");
				//a.loadURL(url,"","GET");
			//}
			//ambilDataDetail();
		}
		//=========================================
		function VerifikasiJurnal(){
		var no_slip = document.getElementById('noSlip').value;
		//var tglSlip = document.getElementById('tgl_slip').value;
		var kso = document.getElementById('cmbKso').value;
		var txtTglA = document.getElementById('tglFirst').value;
		var txtTglB = document.getElementById('tglLast').value;
		var tglslip = document.getElementById('txtTglSlip').value;
		var tmp='',idata='';
		var url;
		//var url2;
			if (no_slip=="" && document.getElementById('cmbPost').value=="0"){
				alert("No Bukti Setor Harus Diisi !");
				document.getElementById('noSlip').focus();
				return false;
			}
			
			//alert(url);
			document.getElementById('btnVerifikasi').disabled=true;
			for (var i=0;i<aRkp.getMaxRow();i++){
			//for (var i=0;i<a.getMaxRow();i++){
				if (aRkp.obj.childNodes[0].childNodes[i].childNodes[5].childNodes[0].checked){
				//if (a.obj.childNodes[0].childNodes[i].childNodes[12].childNodes[0].checked){
					//alert(a1.cellsGetValue(i+1,2));
					//nilai = nilai.replace(/\./g,'');
					idata=aRkp.getRowId(i+1);//alert(idata);
					tmp+=idata+String.fromCharCode(5);
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
					url="pasienKRS_utils_joker_tes.php?grid=1Rkp&act=verifikasi&userId=<?php echo $userId; ?>&txtTgl="+txtTglA+"&txtTgl2="+txtTglB+"&kso="+kso+"&posting="+document.getElementById('cmbPost').value+"&tglslip="+tglslip+"&fdata="+tmp+"&no_slip="+no_slip;
					
					alert(url);
					//aRkp.loadURL(url,"","GET");
				}
			}
			else
			{
				alert("Pilih Data Yg Mau diVerifikasi Terlebih Dahulu !");
				document.getElementById('btnVerifikasi').disabled=false;
			}
			//document.getElementById('btnVerifikasi').disabled=false;
		}
        
		//var jenis_layanan = unit_id = inap = '089';
		var tmpLoadProcess = '<img src="../images/w3.gif" border="0" />';
        var bln = document.getElementById('bln').value;
		var tglslip = document.getElementById('txtTglSlip').value;
        var thn = document.getElementById('thn').value;
        var timeFil = document.getElementById('cmbTime').value;
		var tglslip = document.getElementById('txtTglSlip').value;
        var kso = document.getElementById('cmbKso').value;
        var aRkp=new DSGridObject("gridboxRkp");
        aRkp.setHeader("PENDAPATAN / PIUTANG BILLING");
		aRkp.setColHeader("NO,TANGGAL PULANG,NAMA KASIR,KSO,NILAI,VERIFIKASI<BR><input type='checkbox' name='chkAll' id='chkAll' onClick='chkKlik(this.checked);'>&nbsp;&nbsp;&nbsp;&nbsp;");
		aRkp.setCellType("txt,txt,txt,txt,txt,chk");
		aRkp.setSubTotal(",,,SubTotal :&nbsp;,0,");
		aRkp.setIDColHeader(",,mp.nama,,,");
		aRkp.setColWidth("35,100,450,120,80,60");//35,80,65,100,480,100,70
		aRkp.setCellAlign("center,center,center,center,right,center");
		aRkp.setSubTotalAlign("center,center,center,center,center,center");
        aRkp.setCellHeight(20);
        aRkp.setImgPath("../icon");
        //aRkp.setIDPaging("paging");
        aRkp.attachEvent("onRowClick","ambilDataDetail");
        aRkp.onLoaded(konfirmasi);
		aRkp.baseURL("pasienKRS_utils_joker_tes.php?grid=1Rkp&tipe=<?php echo $tipe;?>&tipePend=0&kso="+kso+"&waktu="+timeFil+"&bln="+bln+"&thn="+thn+"&tglslip="+tglslip+"&posting="+document.getElementById('cmbPost').value);
        aRkp.Init();

        var a=new DSGridObject("gridbox");
        a.setHeader("PENDAPATAN / PIUTANG BILLING (DETAIL)");
		a.setColHeader("NO,TANGGAL KUNJUNGAN,TANGGAL PULANG,NO RM,NAMA,KSO,KUNJUNGAN AWAL,TARIF RS,BIAYA PASIEN,BIAYA KSO,BAYAR PASIEN,PIUTANG PASIEN");
		a.setCellType("txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,txt");
		a.setSubTotal(",,,,,,SubTotal :&nbsp;,,,0,,");
		a.setIDColHeader(",,,mp.no_rm,mp.nama,kso.nama,mu.nama,,,,,");
		a.setColWidth("30,70,70,60,170,100,140,70,70,70,70,70");
		a.setCellAlign("center,center,center,center,left,center,center,right,right,right,right,right");
		a.setSubTotalAlign("center,center,center,center,center,center,right,right,right,right,right,right");
        a.setCellHeight(20);
        a.setImgPath("../icon");
        a.setIDPaging("paging");
        //a.attachEvent("onRowDblClick","ambilData");
        a.onLoaded(konfirmasi);
		a.baseURL("pasienKRS_utils_joker_tes.php?grid=piutangDetail&tipe=<?php echo $tipe;?>&tipePend=0&kso="+kso+"&waktu="+timeFil+"&bln="+bln+"&thn="+thn+"&tglslip="+tglslip+"&posting="+document.getElementById('cmbPost').value);
		//alert("pasienKRS_utils_joker_tes.php?grid=1&tipe=<?php echo $tipe;?>&kso="+kso+"&waktu="+timeFil+"&bln="+bln+"&thn="+thn);
        a.Init();

    /*    var b=new DSGridObject("gridbox_pop");
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
        b.baseURL("pasienKRS_utils_joker_tes.php?grid=2&tipe=<?php echo $tipe;?>&tipePend=0&kunjungan_id=0&waktu=");
        b.Init();*/
		
        var th_skr = "<?php echo $date_skr[2];?>";
        var bl_skr = "<?php echo ($date_skr[1]<10)?substr($date_skr[1],1,1):$date_skr[1];?>";
		var fromHome=<?php echo $fromHome ?>;
    </script>
    <script src="../report_form.js" type="text/javascript" language="javascript"></script>
</html>