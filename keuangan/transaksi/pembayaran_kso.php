<?php
include("../sesi.php");
include '../secured_sess.php';
$userId=$_SESSION['id'];
$tipe = $_REQUEST['tipe'];
$caption = ($tipe==1)?' KSO RAWAT JALAN':(($tipe==2)?' KSO RAWAT INAP':(($tipe==3)?' KSO IGD':' PASIEN UMUM'));
        ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <title>.: Pembayaran KSO :.</title>
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
                            <!--tr>
                                <td style="padding-left:150px;">No Bukti</td>
                                <td>:&nbsp;
                                    <input id="txtNoBu" name="txtNoBu" size="11" class="txtcenter" type="text" />
                                </td>
                            </tr-->
                            <tr style="display:none">
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
                                    <input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('txtTgl'),depRange);"/>
                                    <input type="button" onclick="simpan()" style="margin-left:50px" id="btnSimpan" class="tblBtn" value="SIMPAN" />
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
                                    <!--Bulan
                                </td>
                                <td>:&nbsp;
                                    <select id="bln" name="bln" onchange="filter()" class="txtinputreg">
                                        <option value="1" < ?php echo $th[1]==1?'selected="selected"':'';?>>Januari</option>
                                        <option value="2" < ?php echo $th[1]==2?'selected="selected"':'';?>>Februari</option>
                                        <option value="3" < ?php echo $th[1]==3?'selected="selected"':'';?>>Maret</option>
                                        <option value="4" < ?php echo $th[1]==4?'selected="selected"':'';?>>April</option>
                                        <option value="5" < ?php echo $th[1]==5?'selected="selected"':'';?>>Mei</option>
                                        <option value="6" < ?php echo $th[1]==6?'selected="selected"':'';?>>Juni</option>
                                        <option value="7" < ?php echo $th[1]==7?'selected="selected"':'';?>>Juli</option>
                                        <option value="8" < ?php echo $th[1]==8?'selected="selected"':'';?>>Agustus</option>
                                        <option value="9" < ?php echo $th[1]==9?'selected="selected"':'';?>>September</option>
                                        <option value="10" < ?php echo $th[1]==10?'selected="selected"':'';?>>Oktober</option>
                                        <option value="11" < ?php echo $th[1]==11?'selected="selected"':'';?>>Nopember</option>
                                        <option value="12" < ?php echo $th[1]==12?'selected="selected"':'';?>>Desember</option>
                                    </select>
                                    <select id="thn" name="thn" onchange="filter()" class="txtinputreg">goFilterAndSort('gridbox')
                                        < ?php
                                        for ($i=($th[2]-5);$i<($th[2]+1);$i++) {
                                            ?>
                                        <option value="< ?php echo $i; ?>" class="txtinput"< ?php if ($i==$th[2]) echo "selected";?>>< ?php echo $i;?></option>
                                            < ?php
                                        }
                                        ?>
                                    </select-->
                                </td>
                            </tr>
                            <tr id="trbuk">
                                <td style="padding-left:150px">
                                    No Bukti
                                </td>
                                <td>:&nbsp;
                                    <input type="text" id="nobukti" class="txtcenter" />
                                </td>
                            </tr>
                            <tr id="trjenis" style="display:none">
                                <td style="padding-left:150px">
                                    Jenis Layanan
                                </td>
                                <td>:&nbsp;
                                    <select id="cmbJnsLay" class="txtinput" onchange="fill_unit()" >
                                    </select>
                                </td>
                            </tr>
                            <tr id="trunit" style="display:none">
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
                    <td align="center" style="padding-top:20px;">
                        <fieldset style="width:900px;">
                            <legend>
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
                            </legend>
                            <div id="gridbox" style="width:900px; height:300px; background-color:white; overflow:hidden;"></div>
                            <div id="paging" style="width:900px;"></div>
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
        isiCombo('cmbKso0','','','cmbKso');
        var melakukan = '';
        function simpan(){
            var nobukti = document.getElementById('nobukti').value;
            if(nobukti == ''){
                alert('Nomor Bukti harus diisi.');
                return;
            }
            var maxItem = a.getMaxRow();
            var kunjungan_id = nilai = jenis_layanan = unit_id = '';// = new Array();
            var kso_id = document.getElementById('cmbKso').value;
            var tgl = document.getElementById('txtTgl').value
            bln = document.getElementById('bln').value;
            thn = document.getElementById('thn').value;
            var tmp = '';
            //$rows["id"].'|'.$rows['pelayanan_id'].'|'.$rows['jenis_layanan'].'|'.$rows['unit_id'].'|'.$rows['kso_id']
            for(var i=0; i<maxItem; i++){
                /*tindakan_id[i] = a.getRowId(i+1).split('|');
                tmp += tindakan_id[i]+',';*/
                if(i>0){
                    kunjungan_id += ',';
                    nilai += ',';
                    jenis_layanan += ',';
                    unit_id += ',';
                }
                tmp = a.getRowId(i+1).split('|');
                kunjungan_id += tmp[0];
                nilai += a.cellsGetValue(i+1,9);
                jenis_layanan += tmp[2];
                unit_id += tmp[3];
            }

            var url = "pk_utils.php?act=bayar_kso&kso="+kso_id+"&txtTgl="+tgl+"&kunjungan_id="+kunjungan_id+"&nilai="+nilai
                    +"&jenis_layanan="+jenis_layanan+"&unit_id="+unit_id+"&txtNoBu="+nobukti+"&userId=<?php echo $_SESSION['id'];?>"
                    +"&tipe=<?php echo $tipe;?>&bln="+bln+"&thn="+thn+"&grid=1";
            //alert(url);
            melakukan = 'simpan';
            //a.loadURL(url,'','GET');
        }
        
        var first_time = true;

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
            if(first_time == true){
                if('<?php echo $tipe;?>' == 4){
                    document.getElementById('trunit').style.display = '';
                    document.getElementById('trjenis').style.display = '';
                    document.getElementById('trbuk').style.display = 'none';
                    //document.getElementById('trKSO').style.display = 'none';
                    document.getElementById('trDay').style.display = 'none';
                    isiCombo('cmbJnsLay','','','cmbJnsLay',fill_unit);
                }
                else{
                    document.getElementById('trunit').style.display = 'none';
                    document.getElementById('trjenis').style.display = 'none';
                    document.getElementById('trbuk').style.display = '';
                    //document.getElementById('trKSO').style.display = '';
                    document.getElementById('trDay').style.display = '';
                }
                first_time = false;
            }
            filter();
        }
        
        function fill_unit(){
            isiCombo('cmbTemLayWLang',document.getElementById('cmbJnsLay').value,'','cmbTmpLay',filter);
        }

        function goFilterAndSort(grd){
            timeFil = document.getElementById('cmbTime').value;
            kso = document.getElementById('cmbKso').value;
            var url = "pk_utils.php?grid=1&tipe=<?php echo $_REQUEST['tipe'];?>&kso="+kso+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage();
            /*var tglA,tglZ;
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
            }*/
            bln = document.getElementById('bln').value;
            thn = document.getElementById('thn').value;
            url += "&bln="+bln+"&thn="+thn;
            if('<?php echo $tipe;?>' == 4){
                var jenis_layanan = document.getElementById('cmbJnsLay').value;
                var unit_id = document.getElementById('cmbTmpLay').value;
                var inap = document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang;
                url += "&jenis_layanan="+jenis_layanan+"&unit_id="+unit_id+"&inap="+inap;
            }
            //url += "&waktu="+timeFil+"&bln="+bln+"&thn="+thn;
            //alert(url);
            a.loadURL(url,"","GET");
        }

        function filter(par){
            if(par==undefined) par = 1;
            timeFil = document.getElementById('cmbTime').value;
            kso = document.getElementById('cmbKso').value;
            var url = "pk_utils.php?grid="+par+"&tipe=<?php echo $_REQUEST['tipe'];?>";
            if(par == 1){
                url += "&kso="+kso;
            }
            else{
                url += "&kunjungan_id="+kunjungan_id[0]+"&pelayanan_id="+kunjungan_id[1];
            }
            /*var tglA,tglZ;
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
            }*/
            bln = document.getElementById('bln').value;
            thn = document.getElementById('thn').value;
            url += "&bln="+bln+"&thn="+thn;
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
        var kunjungan_id = '';
        function ambilData(){
            kunjungan_id = a.getRowId(a.getSelRow()).split('|');
            filter(2);
            new Popup('divPop',null,{modal:true,position:'center',duration:0.5})
            $('divPop').popup.show();
        }
        
        function loaded(){
            if(melakukan == 'simpan'){
                alert("Data berhasil disimpan.");
                document.getElementById('nobukti').value = '';
            }
        }
        
        var bln = document.getElementById('bln').value;
        var thn = document.getElementById('thn').value;
        var timeFil = document.getElementById('cmbTime').value;
        var kso = document.getElementById('cmbKso').value;
        var a=new DSGridObject("gridbox");
        a.setHeader("PEMBAYARAN <?php echo $caption;?>");
        a.setColHeader("NO,TANGGAL KUNJUNGAN,TANGGAL PULANG,NO RM,NAMA,TEMPAT LAYANAN,SUDAH BAYAR,TARIF RS,TARIF KSO,IUR BAYAR,PENERIMAAN KSO,PENERIMAAN PASIEN");
        a.setIDColHeader(",tgl,tgl_p,no_rm,pasien,nama,sudah,,,,,");
        a.setColWidth("30,80,80,70,200,270,50,70,70,70,70,70");
        a.setCellAlign("center,center,center,center,left,left,center,right,right,right,right,right");
		a.setCellType("txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,txtbox,txt");
        a.setCellHeight(20);
        a.setImgPath("../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowDblClick","ambilData");
        a.onLoaded(loaded);
        a.baseURL("pk_utils.php?grid=1&tipe=<?php echo $_REQUEST['tipe'];?>&kso="+kso+"&bln="+bln+"&thn="+thn);
        a.Init();
        //+"&waktu="+timeFil

        var b=new DSGridObject("gridbox_pop");
        b.setHeader("DETAIL PEMBAYARAN <?php echo $caption;?>");
        b.setColHeader("NO,TGL TINDAKAN,TEMPAT LAYANAN,TINDAKAN,QTY,PELAKSANA,TARIF RS,TARIF KSO,IUR BAYAR,PENERIMAAN KSO,PENERIMAAN PASIEN");
        b.setIDColHeader(",tgl,nama,,,,,,,,,");
        b.setColWidth("30,80,150,200,50,150,70,70,70,70,70");
        b.setCellAlign("center,center,left,left,center,left,right,right,right,right,right");
        b.setCellHeight(20);
        b.setImgPath("../icon");
        b.setIDPaging("paging_pop");
        //b.attachEvent("onRowDblClick","ambilData");
        //b.onLoaded(konfirmasi);
        b.baseURL("pk_utils.php?grid=2&tipe=<?php echo $_REQUEST['tipe'];?>&kunjungan_id=0&waktu=");
        b.Init();
        var th_skr = "<?php echo $date_skr[2];?>";
        var bl_skr = "<?php echo $date_skr[1];?>";
    </script>
    <script src="../report_form.js" type="text/javascript" language="javascript"></script>

</html>