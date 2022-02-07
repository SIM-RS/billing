<?php
include("../sesi.php");
include '../secured_sess.php';
$userId=$_SESSION['id'];
        ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <title>.: Pendapatan Farmasi :.</title>
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
    <body bgcolor="#808080" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="viewTime()">
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
                    <td valign="top" align="center">
                        <table width="750" border="0" cellpadding="2" cellspacing="2" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold">
                            <tr height="30" id="trKSO">
                                <td style="padding-left:150px;">Nama KSO</td>
                                <td>:&nbsp;
                                    <select id="cmbKso" name="cmbKso" onchange="filter()" class="txtinputreg"></select>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-left:150px">Waktu</td>
                                <td>:&nbsp;
                                    <select id="cmbTime" onchange="viewTime(this)" class="txtinputreg">
                                        <option value="harian">Harian</option>
                                        <option value="bulan">Bulanan</option>
                                        <option value="periode">Periode</option>
                                    </select>
                                </td>
                            </tr>
                            <tr id="trDay">
                                <td style="padding-left:150px;">Tanggal</td>
                                <td>:&nbsp;
                                    <input id="txtTgl" name="txtTgl" readonly size="11" class="txtcenter" type="text" value="<?php echo $tgl; ?>" />&nbsp;
                                    <input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('txtTgl'),depRange,filter);"/>
                                </td>
                            </tr>
                            <tr id="trPer">
                                <td style="padding-left:150px">Periode</td>
                                <td>:&nbsp;
                                    <input id="tglFirst" name="tglFirst" readonly size="11" class="txtcenter" type="text" value="<?php echo $tgl; ?>" />&nbsp;
                                    <input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('tglFirst'),depRange,filter);"/>
                                    s.d.
                                    <input id="tglLast" name="tglLast" readonly size="11" class="txtcenter" type="text" value="<?php echo $tgl; ?>" />&nbsp;
                                    <input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('tglLast'),depRange,filter);"/>
                                </td>
                            </tr>
                            <tr id="trBln">
                                <td style="padding-left:150px">
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
                                    <select id="thn" name="thn" onchange="filter()" class="txtinputreg">goFilterAndSort('gridbox')
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
                    <td align="center" >
                        <fieldset style="width:900px">
                            <div id="gridbox" style="width:900px; height:300px; background-color:white; overflow:hidden;"></div>
                            <div id="paging" style="width:900px;"></div>
                            <div align="center" style="padding-right:100px;">
                                <table>
                                    <tr>
                                        <td>
                                            Total Jual
                                        </td>
                                        <td>
                                            : <span id="span_tot1" style="margin-left:20px;float:right;">&nbsp;</span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
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
        <div id="divPop" class="popup" style="width:560px;height:270px;display:none;">
            <fieldset>
                <legend style="float:right">
                    <div style="float:right; cursor:pointer" class="popup_closebox">
                        <img alt="close" src="../icon/cancel.gif" height="16" width="16" align="absmiddle"/>Tutup</div>
                </legend>
                <table>
                    <tr>
                        <td>
                            <div id="gridbox_pop" style="width:550px; height:180px; background-color:white; "></div>
                            <br/><br/>
                            <div id="paging_pop" style="width:550px;"></div>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </div>

        <?php include("../laporan/report_form.php");?>
    </body>
    <script type="text/JavaScript" language="JavaScript">
        function isiCombo(id,val,defaultId,targetId,evloaded){
            if(targetId=='' || targetId==undefined){
                targetId=id;
            }
            Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'ok');
            //alert('combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId);
        }
        isiCombo('cmbKsoAll_f','','2','cmbKso');

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
            var url = "pf_utils.php?tipe=<?php echo $_REQUEST['tipe'];?>";
            if(grd == 'gridbox'){
                url += "&grid=1&kso="+kso+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage();
            }
            else if(grd == 'gridbox_pop'){
                url += "&grid=2&filter="+b.getFilter()+"&no_penjualan="+kunjungan_id[1]+"&unit_id="+kunjungan_id[2]+"&sorting="+b.getSorting()+"&page="+b.getPage();
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
            if(grd == 'gridbox'){
                a.loadURL(url,"","GET");
            }
            else if(grd == 'gridbox_pop'){
                b.loadURL(url,"","GET");
            }
        }

        function filter(par){
            if(par==undefined) par = 1;
            timeFil = document.getElementById('cmbTime').value;
            kso = document.getElementById('cmbKso').value;
            var url = "pf_utils.php?tipe=<?php echo $_REQUEST['tipe'];?>";
            if(par == 1){
                url += "&kso="+kso+"&grid=1";
            }
            else{
                url += "&no_penjualan="+kunjungan_id[1]+"&unit_id="+kunjungan_id[2]+"&grid=2";
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
			//alert(url);
            if(par == 1){
                a.loadURL(url,"","GET");
            }
            else{
                b.loadURL(url,'','GET');
            }
        }
        
        var kunjungan_id = '';
        function ambilData(){
            kunjungan_id = a.getRowId(a.getSelRow()).split('|');
            filter(2);
            new Popup('divPop',null,{modal:true,position:'center',duration:0.5})
            $('divPop').popup.show();
        }
        
        function count_tot(key,val){
            if (val!=undefined){
				//alert(val);
                var tmp36 = val.split(String.fromCharCode(3));
                document.getElementById('span_tot1').innerHTML = tmp36[0];
                //document.getElementById('span_tot2').innerHTML = tmp36[1];
                //document.getElementById('span_tot3').innerHTML = tmp36[2];
            }
            if(a.getRowId(a.getSelRow())!=''){
                /*var tot1 = document.getElementById('span_tot1').innerHTML;
                var tot2 = document.getElementById('span_tot2').innerHTML;
                var tot3 = document.getElementById('span_tot3').innerHTML;
                while (tot1.indexOf('.')>0){
                    tot1=tot1.replace('.','');
                    tot2=tot2.replace('.','');
                    tot3=tot3.replace('.','');
                }
                document.getElementById('span_sel').innerHTML = FormatNumberFloor(tot1*1-(tot2*1+tot3*1),'.');*/
            }
            else{
                document.getElementById('span_tot1').innerHTML = 0;
            }
        }

        var bln = document.getElementById('bln').value;
        var thn = document.getElementById('thn').value;
        var timeFil = document.getElementById('cmbTime').value;
        var kso = document.getElementById('cmbKso').value;
        var a=new DSGridObject("gridbox");
        a.setHeader("PENDAPATAN FARMASI");
        a.setColHeader("NO,UNIT,No KW,No RM,NAMA,TEMPAT LAYANAN,DOKTER,JUAL");
        a.setIDColHeader(",unit_name,no_penjualan,no_pasien,nama_pasien,unit,dokter,");
        a.setColWidth("30,100,80,80,200,200,150,70");
        a.setCellAlign("center,left,center,center,left,left,left,right");
        a.setCellHeight(20);
        a.setImgPath("../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowDblClick","ambilData");
        a.onLoaded(count_tot);
        a.baseURL("pf_utils.php?grid=1&kso="+kso+"&waktu="+timeFil+"&bln="+bln+"&thn="+thn);
        a.Init();


        var b=new DSGridObject("gridbox_pop");
        b.setHeader("DETAIL PENDAPATAN FARMASI");
        b.setColHeader("NO,NAMA OBAT,QTY,NILAI,SUB TOTAL");
        b.setIDColHeader(",obat_nama,,,");
        b.setColWidth("30,200,30,80,80");
        b.setCellAlign("center,LEFT,center,80,right");
        b.setCellHeight(20);
        b.setImgPath("../icon");
        b.setIDPaging("paging_pop");
        //b.attachEvent("onRowDblClick","ambilData");
        //b.onLoaded(konfirmasi);
        b.baseURL("pf_utils.php?grid=2&tipe=<?php echo $_REQUEST['tipe'];?>&kunjungan_id=0&waktu=");
        b.Init();
		
        var th_skr = "<?php echo $date_skr[2];?>";
        var bl_skr = "<?php echo ($date_skr[1]<10)?substr($date_skr[1],1,1):$date_skr[1];?>";
		var fromHome=<?php echo $fromHome ?>;
    </script>
    <script src="../report_form.js" type="text/javascript" language="javascript"></script>
</html>