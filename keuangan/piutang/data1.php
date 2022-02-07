<?php
//include("../sesi.php");
include '../secured_sess.php';
$userId=$_SESSION['id'];
$tipe = $_REQUEST['tipe'];
$caption = ($tipe==1)?'RAWAT JALAN':(($tipe==2)?'RAWAT INAP':(($tipe==3)?'IGD':'PER UNIT'));

$pLegend = "Home -> Piutang";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <title>.: Piutang :.</title>
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
                              <td colspan="2" align="center">Piutang Pasien</td>
                            </tr>
                            <tr height="30" id="trKSO">
                                <td width="150" style="padding-left:50px;">Status Px</td>
                                <td>:&nbsp;
                                    <select id="cmbKso" name="cmbKso"  class="txtinputreg"></select>
								</td>
                            </tr>
							<tr>
								<td width="110" style="padding-left:50px;">Jenis Data</td>
                                <td>:&nbsp;
									<select name="cmbData" id="cmbData" class="txtinputreg" onChange="tipeData(this.value)">
										<option value="1">PIUTANG</option>
										<option value="2">PELUNASAN</option>
									</select>
								</td>
							</tr>
							<tr id='trPelunasan' style="display:none;">
								<td width="110" style="padding-left:50px;">Jenis Pelunasan</td>
                                <td>:&nbsp;
									<select name="cmbPelunasan" id="cmbPelunasan" class="txtinputreg">
										<option value="1">KSO/PENJAMIN</option>
										<option value="2">PASIEN</option>
									</select>
								</td>
							</tr>
							<tr>
                                <td width="110" style="padding-left:50px;"><div id="changeText">Tgl Pulang</div></td>
                                <td>:&nbsp;
                                    <select id="cmbTime" onchange="viewTime(this)" class="txtinputreg">
                                        <option value="periode" selected>PERIODE</option>
                                        <option value="harian">SAMPAI TANGGAL</option>
                                    </select>
								</td>
                            </tr>
                            <tr id="trDay" style="display:none;">
                                <td style="padding-left:50px;">Sampai Tgl</td>
                                <td>:&nbsp;
									<input id="txtTgl" name="txtTgl" readonly size="11" class="txtcenter" type="text" value="<?php echo $tgl; ?>" />&nbsp;
									<input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('txtTgl'),depRange);"/>
								</td>
                            </tr>
                            <tr id="trPer">
                                <td style="padding-left:50px">Periode</td>
                                <td>:&nbsp;
                                    <input id="tglFirst" name="tglFirst" readonly size="11" class="txtcenter" type="text" value="<?php echo $tgl; ?>" />&nbsp;
                                    <input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('tglFirst'),depRange);"/>
                                    s.d.
                                    <input id="tglLast" name="tglLast" readonly size="11" class="txtcenter" type="text" value="<?php echo $tgl; ?>" />&nbsp;
                                    <input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('tglLast'),depRange);"/>                                </td>
                            </tr>
                            <tr id="tr_jenis" style="display:none">
                                <td style="padding-left:50px">Jenis Layanan</td>
                                <td>:&nbsp;
                                    <select id="cmbJnsLay" class="txtinput" onchange="fill_unit()" >
                                    </select>
								</td>
                            </tr>
                            <tr id="tr_unit" style="display:none">
                                <td style="padding-left:50px">
                                    Unit Layanan                                </td>
                                <td>:&nbsp;
                                    <select id="cmbTmpLay" class="txtinput" lang="" onchange="filter();">
                                    </select>                                </td>
                            </tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;&nbsp;&nbsp;<button type='button' onclick="kirim()">Search</button></td>
							</tr>
                        </table>
                  </td>
                </tr>
                <tr id="trPen">
                    <td align="center" >
                        <!--table width="950px" border="0" cellpadding="0" cellspacing="0">
                        	<tr>
                            	<td style="padding-left:10px;"><select id="cmbPost" name="cmbPost" class="txtinput" style="background-color:#FFFFCC; color:#990000;" onChange="if(this.value==0){document.getElementById('spnBtnVer').innerHTML='&nbsp;Verifikasi';}else{document.getElementById('spnBtnVer').innerHTML='&nbsp;UnVerifikasi';};kirim();">
                                    <option value="0">BELUM VERIFIKASI</option>
                                    <option value="1">SUDAH VERIFIKASI</option>
                                </select></td>
                                <td align="right" style="padding-right:10px;"><button id="btnRincian" name="btnRincian" type="button" onclick="RincianTindakan();">Rincian Tindakan</button>&nbsp;&nbsp;<BUTTON type="button" id="btnVerifikasi" onClick="VerifikasiJurnal();"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle"><span id="spnBtnVer">&nbsp;Verifikasi</span></BUTTON></td>
                            </tr>
                        </table-->
						<br />
						<div style="display:block; float:right; padding-right:15px;">
							<button onclick="cetak();">Cetak</button>
							<button onclick="cetak('excel');">Export Excell</button>
						</div>
                        <fieldset style="width:900px">
                            <div id="gridbox" style="width:970px; height:300px; background-color:white; overflow:hidden;"></div>
                            <div id="paging" style="width:950px;"></div>
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
        <!--div id="divPop" class="popup" style="width:910px;height:270px;display:none;">
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
        </div-->
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
			window.open("../../billing/unit_pelayanan/RincianTindakanAll.php?idKunj="+sisip[0]+"&tipe=2",'_blank');
		}
		
		function isiCombo(id,val,defaultId,targetId,evloaded){
            if(targetId=='' || targetId==undefined){
                targetId=id;
            }
            Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'ok');
            //alert('combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId);
        }
		
        isiCombo('cmbKsoAll','','cmbKso','cmbKso');

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
                    document.getElementById('trDay').style.display = 'table-row';
                    break;
                case 'periode':
                    document.getElementById('trPer').style.display = 'table-row';
                    document.getElementById('trDay').style.display = 'none';
                    break;
            }
            // filter();
        }

        function goFilterAndSort(grd){
            var timeFil = document.getElementById('cmbTime').value;
            var kso = document.getElementById('cmbKso').value;
			var cmbPost = document.getElementById('cmbPost').value;
            var url = "piutang_utils.php?grid=1&tipe=<?php echo $tipe;?>&tipePend=0&kso="+kso+"&posting="+cmbPost+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage();
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
            }
            //alert(url);
            a.loadURL(url,"","GET");
        }

        function filter(par){
            if(par==undefined) par = 1;
            timeFil = document.getElementById('cmbTime').value;
            kso = document.getElementById('cmbKso').value;
            var url = "piutang_utils.php?grid="+par;
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
                    url += "&waktu="+timeFil+"&txtTgl="+tglA+"&txtTgl2="+tglZ;
                    break;
            }
            //alert(url)
            if(par == 1){
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
            /* filter(2);
            new Popup('divPop',null,{modal:true,position:'center',duration:0.5})
            $('divPop').popup.show(); */
        }
        
        function konfirmasi(key,val){
			//alert(val);
            if (val!=undefined){
                var tmp36 = val.split(String.fromCharCode(3));
				a.cellSubTotalSetValue(9,tmp36[0]);
				a.cellSubTotalSetValue(10,tmp36[1]);
				a.cellSubTotalSetValue(11,tmp36[2]);
				a.cellSubTotalSetValue(12,tmp36[3]);
				a.cellSubTotalSetValue(13,tmp36[4]);
				a.cellSubTotalSetValue(14,tmp36[5]);
				if (tmp36[5]!=""){
					//alert(tmp36[5]);
				}
            }else{
				a.cellSubTotalSetValue(9,0);
				a.cellSubTotalSetValue(10,0);
				a.cellSubTotalSetValue(11,0);
				a.cellSubTotalSetValue(12,0);
				a.cellSubTotalSetValue(13,0);
				a.cellSubTotalSetValue(14,0);
			}
			// document.getElementById('chkAll').checked=false;
			
			if (isShow==1){
				HideLoadImg();
			}
        }
	
		function chkKlik(p){
		var cekbox=(p==true)?1:0;
			//alert(p);
			for (var i=0;i<a.getMaxRow();i++){
				a.cellsSetValue(i+1,13,cekbox);
			}
		}

			/* var url;
			var cmbPost = document.getElementById('cmbPost').value;
			var kso = document.getElementById('cmbKso').value;
			var TglA = document.getElementById('tglFirst').value;
			var TglB = document.getElementById('tglLast').value;
			var tmpTglA = TglA.split("-");
			var tmpTglB = TglB.split("-");
			var tipeTime = document.getElementById('cmbTime').value;
			var tipeData = document.getElementById('cmbData').value;
			tmpTglA=tmpTglA[2]+'-'+tmpTglA[1]+'-'+tmpTglA[0];
			tmpTglB=tmpTglB[2]+'-'+tmpTglB[1]+'-'+tmpTglB[0];
			
			url="piutang_utils.php?grid=1&txtTgl="+TglA+"&txtTgl2="+TglB+"&kso="+kso+"&posting="+cmbPost+"&tipeData="+tipeData;
			//alert(url);
			document.getElementById('trPelunasan').style.display = 'none';
			if(tipeData == '2'){
				document.getElementById('trPelunasan').style.display = 'table-row';
			}
			if (tipeTime == 'periode' && tmpTglB>=tmpTglA){
				// document.getElementById('btnVerifikasi').disabled=true;
				ShowLoadImg();
				a.loadURL(url,"","GET"); 
			} else {
				ShowLoadImg();
				a.loadURL(url,"","GET");
			} */
			
		function tipeData(param){
			document.getElementById('trPelunasan').style.display = 'none';
			document.getElementById('changeText').innerHTML = 'Tgl Pulang';
			if(param == '2'){
				document.getElementById('trPelunasan').style.display = 'table-row';
				document.getElementById('changeText').innerHTML = "Tgl Pelunasan";
			}
		}
		function kirim(){
			var url;
			var kso = document.getElementById('cmbKso').value;
			var tipeTime = document.getElementById('cmbTime').value;
			var tipeData = document.getElementById('cmbData').value;		
			var tipePelunasan = document.getElementById('cmbPelunasan').value;
			
			url="piutang_utils.php?grid=1&kso="+kso+"&data="+tipeData+"&waktu="+tipeTime+"&tipePelunasan="+tipePelunasan;
			
			switch(tipeTime){
				case "periode":
					var TglA = document.getElementById('tglFirst').value;
					var TglB = document.getElementById('tglLast').value;
					var tmpTglA = TglA.split("-");
					var tmpTglB = TglB.split("-");
					tmpTglA = tmpTglA[2]+'-'+tmpTglA[1]+'-'+tmpTglA[0];
					tmpTglB = tmpTglB[2]+'-'+tmpTglB[1]+'-'+tmpTglB[0];
					
					url += "&txtTgl="+TglA+"&txtTgl2="+TglB;
					break;
				case "harian":
					var TglA = document.getElementById('txtTgl').value;
					url += "&txtTgl="+TglA
					break;
			}
			
			ShowLoadImg();
			a.loadURL(url,"","GET");
		}
		
		function cetak(param = 'html'){
			var url;
			var kso = document.getElementById('cmbKso').value;
			var tipeTime = document.getElementById('cmbTime').value;
			var tipeData = document.getElementById('cmbData').value;		
			var tipePelunasan = document.getElementById('cmbPelunasan').value;
			
			url="cetak_piutang.php?kso="+kso+"&data="+tipeData+"&waktu="+tipeTime+"&tipePelunasan="+tipePelunasan+"&file="+param+"&filter="+a.getFilter()+"&sorting="+a.getSorting();
			
			switch(tipeTime){
				case "periode":
					var TglA = document.getElementById('tglFirst').value;
					var TglB = document.getElementById('tglLast').value;
					var tmpTglA = TglA.split("-");
					var tmpTglB = TglB.split("-");
					tmpTglA = tmpTglA[2]+'-'+tmpTglA[1]+'-'+tmpTglA[0];
					tmpTglB = tmpTglB[2]+'-'+tmpTglB[1]+'-'+tmpTglB[0];
					
					url += "&txtTgl="+TglA+"&txtTgl2="+TglB;
					break;
				case "harian":
					var TglA = document.getElementById('txtTgl').value;
					url += "&txtTgl="+TglA
					break;
			}
			
			window.open(url, '_blank');
		}
		
		//=========================================
		function VerifikasiJurnal(){
		//var no_slip = document.getElementById('noSlip').value;
		//var tglSlip = document.getElementById('tgl_slip').value;
		var kso = document.getElementById('cmbKso').value;
		var txtTglA = document.getElementById('tglFirst').value;
		var txtTglB = document.getElementById('tglLast').value;
		
		var tmp='',idata='';
		var url;
		//var url2;
		//var nilai='';
			
			//alert(url);
			document.getElementById('btnVerifikasi').disabled=true;
			for (var i=0;i<a.getMaxRow();i++)
			{
				if (a.obj.childNodes[0].childNodes[i].childNodes[12].childNodes[0].checked)
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
					idata=a.getRowId(i+1);//alert(idata);
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
					url="piutang_utils.php?grid=1&act=verifikasi&userId=<?php echo $userId; ?>&txtTgl="+txtTglA+"&txtTgl2="+txtTglB+"&kso="+kso+"&posting="+document.getElementById('cmbPost').value+"&fdata="+tmp;
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
        
		//var jenis_layanan = unit_id = inap = '089';
		var tmpLoadProcess = '<img src="../images/w3.gif" border="0" />';
        var timeFil = document.getElementById('cmbTime').value;
        var kso = document.getElementById('cmbKso').value;
        var a=new DSGridObject("gridbox");
        a.setHeader("DATA PIUTANG / PELUNASAN");
		a.setColHeader("NO, TGL KUNJUNGAN, TGL PULANG, TGL LUNAS KSO, TGL LUNAS Px, NO RM, NAMA, KSO, BIAYA RS, BIAYA KSO, BIAYA KSO KLAIM, BIAYA PASIEN, BAYAR KSO, BAYAR PASIEN");
		a.setCellType("txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,txt");
		a.setSubTotal(",,,,,,,SubTotal :&nbsp;,0,0,0,0,0,0");
		a.setIDColHeader(",,,no_rm,nama,nama,,,,,,,");
		a.setColWidth("30,70,70,70,70,60,170,100,70,70,70,70,70,70");
		a.setCellAlign("center,center,center,center,center,center,left,center,right,right,right,right,right,right");
		a.setSubTotalAlign("center,center,center,center,center,center,center,center,right,right,right,right,right,right");
        a.setCellHeight(20);
        a.setImgPath("../icon");
        a.setIDPaging("paging");
        //a.attachEvent("onRowDblClick","ambilData");
        a.onLoaded(konfirmasi);
		a.baseURL("piutang_utils.php?grid=1&tipe=<?php echo $tipe;?>&tipePend=0&kso="+kso+"&waktu="+timeFil);
		//alert("piutang_utils.php?grid=1&tipe=<?php echo $tipe;?>&kso="+kso+"&waktu="+timeFil+"&bln="+bln+"&thn="+thn);
        a.Init();

        /* var b=new DSGridObject("gridbox_pop");
        b.setHeader("PENDAPATAN <?php echo $caption;?>");
		b.setColHeader("NO,TGL TINDAKAN,TEMPAT LAYANAN,TINDAKAN,PELAKSANA,TARIF PERDA,BIAYA PASIEN,TARIF KSO,IUR BAYAR,SELISIH");
		b.setIDColHeader(",tgl,nama,,,,,,,");
		b.setColWidth("30,80,150,200,150,70,70,70,70,70");
		b.setCellAlign("center,center,left,left,left,right,right,right,right,right");
        b.setCellHeight(20);
        b.setImgPath("../icon");
        b.setIDPaging("paging_pop");
        //b.attachEvent("onRowDblClick","ambilData");
        //b.onLoaded(konfirmasi);
        b.baseURL("piutang_utils.php?grid=2&tipe=<?php echo $tipe;?>&tipePend=0&kunjungan_id=0&waktu=");
        b.Init(); */
		
        var th_skr = "<?php echo $date_skr[2];?>";
        var bl_skr = "<?php echo ($date_skr[1]<10)?substr($date_skr[1],1,1):$date_skr[1];?>";
		var fromHome=<?php echo $fromHome ?>;
    </script>
    <script src="../report_form.js" type="text/javascript" language="javascript"></script>
</html>