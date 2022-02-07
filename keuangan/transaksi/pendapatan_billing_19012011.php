<?php
include("../sesi.php");
include '../secured_sess.php';
$userId=$_SESSION['id'];
$tipe = $_REQUEST['tipe'];
$caption = ($tipe==1)?'RAWAT JALAN':(($tipe==2)?'RAWAT INAP':(($tipe==3)?'IGD':'PER UNIT'));
        ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <title>.: Pendapatan :.</title>
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
                    <td valign="top" align="center">
                        <table width="550" border="0" cellpadding="2" cellspacing="2" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold">
                            <tr height="30" id="trKSO">
                                <td style="padding-left:150px;">Nama KSO</td>
                                <td>:&nbsp;
                                    <select id="cmbKso" name="cmbKso" onchange="filter()" class="txtinputreg"></select>
                                </td>
                            </tr>
                            <tr style="display:none">
                                <td style="padding-left:150px">Waktu</td>
                                <td>:&nbsp;
                                    <select id="cmbTime" onchange="viewTime(this)" class="txtinputreg">
                                        <option value="harian" selected>Harian</option>
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
                            <tr id="trPeriode" style="display:none">
                                <td style="padding-left:150px">Periode</td>
                                <td>:&nbsp;
                                    <input id="tglFirst" name="tglFirst" readonly size="11" class="txtcenter" type="text" value="<?php echo $tgl; ?>" />&nbsp;
                                    <input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('tglFirst'),depRange,filter);"/>
                                    s.d.
                                    <input id="tglLast" name="tglLast" readonly size="11" class="txtcenter" type="text" value="<?php echo $tgl; ?>" />&nbsp;
                                    <input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('tglLast'),depRange,filter);"/>
                                </td>
                            </tr>
                            <tr id="trBln" style="display:none">
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
                            <tr id="tr_jenis" style="display:none">
                                <td style="padding-left:150px">
                                    Jenis Layanan
                                </td>
                                <td>:&nbsp;
                                    <select id="cmbJnsLay" class="txtinput" onchange="fill_unit()" >
                                    </select>
                                </td>
                            </tr>
                            <tr id="tr_unit" style="display:none">
                                <td style="padding-left:150px">
                                    Unit Layanan
                                </td>
                                <td>:&nbsp;
                                    <select id="cmbTmpLay" class="txtinput" lang="" onchange="filter();">
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
                            <div align="left" style="padding-right:100px;">
                                <table>
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
        isiCombo('cmbKso');

        function viewTime(par){
            if(par == undefined) par = document.getElementById('cmbTime');
            switch(par.value){
                case 'harian':
                    document.getElementById('trPeriode').style.display = 'none';
                    document.getElementById('trBln').style.display = 'none';
                    document.getElementById('trDay').style.display = 'table-row';
                    break;
                case 'periode':
                    document.getElementById('trPeriode').style.display = 'table-row';
                    document.getElementById('trBln').style.display = 'none';
                    document.getElementById('trDay').style.display = 'none';
                    break;
                case 'bulan':
                    document.getElementById('trPeriode').style.display = 'none';
                    document.getElementById('trBln').style.display = 'table-row';
                    document.getElementById('trDay').style.display = 'none';
                    break;
            }
            filter();
        }

        function goFilterAndSort(grd){
            timeFil = document.getElementById('cmbTime').value;
            kso = document.getElementById('cmbKso').value;
            var url = "pendapatan_utils.php?grid=1&tipe=<?php echo $tipe;?>&kso="+kso+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage();
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
            if('<?php echo $tipe;?>' == 4){
                var jenis_layanan = document.getElementById('cmbJnsLay').value;
                var unit_id = document.getElementById('cmbTmpLay').value;
                var inap = document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang;
                url += "&jenis_layanan="+jenis_layanan+"&unit_id="+unit_id+"&inap="+inap;
            }
            //alert(url);
            a.loadURL(url,"","GET");
        }

        function filter(par){
            if(par==undefined) par = 1;
            timeFil = document.getElementById('cmbTime').value;
            kso = document.getElementById('cmbKso').value;
            var url = "pendapatan_utils.php?grid="+par+"&tipe=<?php echo $tipe;?>";
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
            if('<?php echo $tipe;?>' == 4){
                var jenis_layanan = document.getElementById('cmbJnsLay').value;
                var unit_id = document.getElementById('cmbTmpLay').value;
                var inap = document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang;
                url += "&jenis_layanan="+jenis_layanan+"&unit_id="+unit_id+"&inap="+inap;
            }
            //alert(url)
            if(par == 1){
                a.loadURL(url,"","GET");
            }
            else{
                b.loadURL(url,'','GET');
            }
        }
        
        if('<?php echo $tipe;?>' == 4){
            isiCombo('cmbJnsLay','','','cmbJnsLay',fill_unit);
            isiCombo('cmbKsoAll','','','cmbKso');
            document.getElementById('tr_jenis').style.display = '';
            document.getElementById('tr_unit').style.display = '';
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
        
        function count_tot(key,val){
            if (val!=undefined){
                var tmp36 = val.split(String.fromCharCode(3));
                document.getElementById('span_tot1').innerHTML = tmp36[0];
                document.getElementById('span_tot2').innerHTML = tmp36[1];
                document.getElementById('span_tot3').innerHTML = tmp36[2];
            }
            if(a.getRowId(a.getSelRow())!=''){
                var tot1 = document.getElementById('span_tot1').innerHTML;
                var tot2 = document.getElementById('span_tot2').innerHTML;
                var tot3 = document.getElementById('span_tot3').innerHTML;
                while (tot1.indexOf('.')>0){
                    tot1=tot1.replace('.','');
                    tot2=tot2.replace('.','');
                    tot3=tot3.replace('.','');
                }
                document.getElementById('span_sel').innerHTML = tot1*1-(tot2*1+tot3*1);
            }
            else{
                document.getElementById('span_tot1').innerHTML = document.getElementById('span_tot2').innerHTML = document.getElementById('span_tot3').innerHTML = document.getElementById('span_sel').innerHTML = 0;
            }
        }
        
        var bln = document.getElementById('bln').value;
        var thn = document.getElementById('thn').value;
        var timeFil = document.getElementById('cmbTime').value;
        var kso = document.getElementById('cmbKso').value;
        var a=new DSGridObject("gridbox");
        a.setHeader("PENDAPATAN <?php echo $caption;?>");
        a.setColHeader("NO,TANGGAL KUNJUNGAN,NO RM,NAMA,TEMPAT LAYANAN,TARIF PERDA,TARIF KSO,IUR BAYAR,SELISIH,PENERIMAAN KSO,PENERIMAAN PASIEN");
        a.setIDColHeader(",no_rm,tgl,pasien,unit,,,,,,");
        a.setColWidth("30,80,70,200,270,70,70,70,70,70,70");
        a.setCellAlign("center,center,center,left,left,right,right,right,right,right,right");
        a.setCellHeight(20);
        a.setImgPath("../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowDblClick","ambilData");
        a.onLoaded(count_tot);
        a.baseURL("pendapatan_utils.php?grid=1&tipe=<?php echo $tipe;?>&kso="+kso+"&waktu="+timeFil+"&bln="+bln+"&thn="+thn);
        a.Init();

        var b=new DSGridObject("gridbox_pop");
        b.setHeader("PENDAPATAN <?php echo $caption;?>");
        b.setColHeader("NO,TGL TINDAKAN,TEMPAT LAYANAN,TINDAKAN,PELAKSANA,TARIF PERDA,TARIF KSO,IUR BAYAR,SELISIH,PENERIMAAN KSO,PENERIMAAN PASIEN");
        b.setIDColHeader(",tgl,nama,,,,,,,,,");
        b.setColWidth("30,80,150,200,150,70,70,70,70,70,70");
        b.setCellAlign("center,center,left,left,left,right,right,right,right,right,right");
        b.setCellHeight(20);
        b.setImgPath("../icon");
        b.setIDPaging("paging_pop");
        //b.attachEvent("onRowDblClick","ambilData");
        //b.onLoaded(konfirmasi);
        b.baseURL("pendapatan_utils.php?grid=2&tipe=<?php echo $tipe;?>&kunjungan_id=0&waktu=");
        b.Init();
        var th_skr = "<?php echo $date_skr[2];?>";
        var bl_skr = "<?php echo $date_skr[1];?>";
    </script>
    <script src="../report_form.js" type="text/javascript" language="javascript"></script>
</html>