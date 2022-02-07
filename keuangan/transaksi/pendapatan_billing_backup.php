<?php
include("../sesi.php");
include '../secured_sess.php';
$userId=$_SESSION['id'];
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
    <body bgcolor="#808080" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="changeType(document.getElementById('cmbPend'))">
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
                    <td height="50">&nbsp;</td>
                </tr>
                <tr>
                    <td valign="top" align="center">
                        <table width="750" border="0" cellpadding="2" cellspacing="2" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold">
                            <tr height="30">
                                <td width="50%" style="padding-left:150px;" height="30">Jenis Pendapatan</td>
                                <td width="50%">:&nbsp;
                                    <input type="hidden" id="txtId" name="txtId" />
                                    <select id="cmbPend" name="cmbPend" onchange="changeType(this)" class="txtinput">
                                        <?php
                                        $qPend = "SELECT id, nama
									FROM k_ms_transaksi WHERE tipe = 1";
                                        $rsPend = mysql_query($qPend);
                                        while($rwPend = mysql_fetch_array($rsPend)) {
                                            ?>
                                        <option value="<?php echo $rwPend['id']?>"><?php echo $rwPend['nama']?></option>
                                            <?php } ?>
                                    </select>
                                    <button id="btnMsTrans" name="btnMsTrans" class="txtinput">+</button>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-left:150px;">Tanggal</td>
                                <td>:&nbsp;
                                    <input id="txtTgl" name="txtTgl" readonly size="11" class="txtcenter" type="text" value="<?php echo $tgl; ?>" />&nbsp;
                                    <input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="txtcenter" onclick="gfPop.fPopCalendar(document.getElementById('txtTgl'),depRange);"/>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-left:150px;">No Bukti</td>
                                <td>:&nbsp;
                                    <input id="txtNoBu" name="txtNoBu" size="11" class="txtcenter" type="text" />
                                </td>
                            </tr>                            
                            <tr height="30" id="trKSO">
                                <td style="padding-left:150px;">Nama KSO</td>
                                <td>:&nbsp;
                                    <select id="cmbKso" name="cmbKso" onchange="filter()" class="txtinputreg"></select>
                                </td>
                            </tr>
                            <tr id="trForm">
                                <td style="padding-left:150px;">Nilai</td>
                                <td>:&nbsp;
                                    <input type="text" id="nilai" name="nilai" class="txtright"/></td>
                            </tr>
                            <tr>
                                <td valign="top" style="padding-left:150px;">
                                    Keterangan
                                </td>
                                <td valign="top"><span style="vertical-align:top">:</span>&nbsp;
                                    <textarea cols="36" id="txtArea" name="txtArea" class="txtinputreg"></textarea>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>               

                <tr id="trDiv">
                    <td valign="top" align="center">
                        <fieldset style="width:900px; background-color:#032358;">
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
                            <legend style="text-align:center; font-weight:bold; font-size:10px; background-color:#032358; color:#ffffff;">Daftar Pembayaran Pasien</legend>
                            <div>
                                <table width="900" border="1" cellpadding="0" cellspacing="0" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;" id="tbl">
                                    <tr style="text-align:center; font-weight:bold; font-size:10px; background-color:#032358; color:#ffffff;" height="30">
                                        <td width="5%">NO</td>
                                        <td width="10%">TGL KUNJUNGAN</td>
                                        <td width="30%">NAMA</td>
                                        <td width="35%">TEMPAT LAYANAN</td>
                                        <td width="10%">TAGIHAN KSO</td>
                                        <td width="10%">PEMBAYARAN</td>
                                    </tr>
                                </table>
                            </div>
                            <div id="divKso" align="center" style="width:900px; height:250px; overflow:scroll;">
                            </div>
                        </fieldset>
                    </td>
                </tr>		                
                <tr id="trPenControl">
                    <td align="center" height="50" valign="middle">
                        <button id="btnPenSimpan" name="btnPenSimpan" class="tblTambah" value="tambah" onclick="simpanPen()">Simpan</button>
                        <button id="btnPenHapus" name="btnPenHapus" class="tblHapus" disabled="true" value="hapus" onclick="hapusPen()">Hapus</button>
                        <button id="btnPenBatal" name="btnPenBatal" class="tblBatal" onclick="batalPen()">Batal</button>
                    </td>
                </tr>
                <tr id="trPen">
                    <td align="center" >
                        <fieldset style="width:900px">
                            <legend>
                                <select id="blnPend" name="blnPend" onchange="goFilterAndSort('gridbox')" class="txtinputreg">
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
                                <select id="thnPend" name="thnPend" onchange="goFilterAndSort('gridbox')" class="txtinputreg">
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
        changeType(document.getElementById('cmbPend').value);
        function changeType(par){
            //alert(par.value);
            document.getElementById('trKSO').style.display = 'none';	     
            //document.getElementById('trPenControl').style.display = 'table-row';
            document.getElementById('trForm').style.display = 'table-row';
            switch(par.value){
                case '1'://pembayaran kso
                    document.getElementById('trKSO').style.display = 'table-row';		    		    
                    document.getElementById('trForm').style.display = 'none';
                    //document.getElementById('trPenControl').style.display = 'none';
                    break;
                case '2'://farmasi                    
                case '5'://cssd                    
                case '3'://kamar jenazah
                case '4'://kantin
                case '6'://jasa parkir
                case '7'://sewa iklan                    
                    goFilterAndSort('gridboxPen');
                    break;
                default :
                    //filter();
                    break;
            }
            filter();
        }

        function filter(){
            var bln = document.getElementById('bln').value;
            var thn = document.getElementById('thn').value;
            var tipe = document.getElementById('cmbPend').value;
            var url = 'kso.php?type='+tipe+'&bln='+bln+'&thn='+thn;
            switch(tipe){
                case '1'://pembayaran kso
                    var kso = document.getElementById('cmbKso').value;
                    url += '&kso='+kso;
                    break;
                case '2'://farmasi
                case '3'://kamar jenazah
                case '4'://kantin
                case '5'://cssd
                case '6'://jasa parkir
                case '7'://sewa iklan
                    break;
                default :
                    break;
            }
            Request(url,'divKso','','GET',cekDiv);
        }

        function cekDiv(){//alert(document.getElementById('divKso').innerHTML=='kosong'?'kosong':'aneh');
            if((document.getElementById('divKso').innerHTML*1) == 1){
                document.getElementById('trDiv').style.display = 'none';
                //document.getElementById('trPen').style.display = 'table-row';
            }
            else{
                var tmp = document.getElementById('divKso').innerHTML.split(String.fromCharCode(3));
                document.getElementById('divKso').innerHTML = tmp[0];
                if(tmp[1] < 150){
                    document.getElementById('divKso').style.height = tmp[1]*1+36+'px';
                    document.getElementById('divKso').style.overflow = 'auto';
                }
                else{
                    document.getElementById('divKso').style.height = '170px';
                    document.getElementById('divKso').style.overflow = 'scroll';
                }
                document.getElementById('trDiv').style.display = 'table-row';
                //document.getElementById('trPen').style.display = 'none';
            }
        }       

        function ambilData(){
            var sisipan = a.getRowId(a.getSelRow()).split("|");
            var isian = "txtId*-*"+sisipan[0]
                +"*|*btnPenHapus*-*hapus*|*txtTgl*-*"+a.cellsGetValue(a.getSelRow(),2)
                +"*|*txtNoBu*-*"+a.cellsGetValue(a.getSelRow(),3)
                +"*|*cmbPend*-*"+sisipan[1]
                +"*|*nilai*-*"+a.cellsGetValue(a.getSelRow(),5);
            fSetValue(window,isian);
            document.getElementById("txtArea").value=a.cellsGetValue(a.getSelRow(),6);
            document.getElementById("btnPenHapus").disabled=false;
            document.getElementById("btnPenSimpan").value="simpan";
            changeType(document.getElementById('cmbPend').value);
        }

        function simpanPen(){
            document.getElementById("btnPenSimpan").disabled=true;
            var cmbPend = document.getElementById("cmbPend").value;
            var userId = "<?php echo $userId;?>";
            if(cmbPend!="1"){
                if(ValidateForm('cmbPend,txtTgl,txtNoBu,nilai,txtArea','ind')){
                    var id = document.getElementById("txtId").value;
                    var act = document.getElementById("btnPenSimpan").value;
                    var txtTgl = document.getElementById("txtTgl").value;
                    var txtNoBu = document.getElementById("txtNoBu").value;
                    var nilai = document.getElementById("nilai").value;
                    var txtArea = document.getElementById("txtArea").value;
                    var bln = document.getElementById('blnPend').value;
                    var thn = document.getElementById('thnPend').value;
                    var param ="&rowid="+encodeURIComponent(id)
                        +"&cmbPend="+encodeURIComponent(cmbPend)
                        +"&txtTgl="+encodeURIComponent(txtTgl)
                        +"&txtNoBu="+encodeURIComponent(txtNoBu)
                        +"&nilai="+encodeURIComponent(nilai)
                        +"&txtArea="+encodeURIComponent(txtArea)
                        +"&thn="+encodeURIComponent(thn)
                        +"&bln="+encodeURIComponent(bln)
                        +"&userId="+encodeURIComponent(userId)
                    ;
                    var available = false;
                    if(act=='simpan'){
                        if(confirm("Anda yakin ingin mengubah data ini?")){
                            available = true;
                        }
                    }else{
                        available = true;
                    }
                    if(available){
                        //alert("pendapatan_utils.php?act="+act+param+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
                        a.loadURL("pendapatan_utils.php?act="+act+param+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
                        batalPen();
                    }
                }
            }
            else{
                var id = document.getElementById("txtId").value;
                var act = document.getElementById("btnPenSimpan").value;
                var txtTgl = document.getElementById("txtTgl").value;
                var txtNoBu = document.getElementById("txtNoBu").value;
                var txtArea = document.getElementById("txtArea").value;
                var bln = document.getElementById('blnPend').value;
                var thn = document.getElementById('thnPend').value;
                var jml = document.getElementById("txtJml").value;
                var ksoId = document.getElementById("cmbKso").value;
                var txtBayar = '';
                var txtTin = '';
                var kunjId = '';
                for(var i=1;i<=jml;i++){
                    if(document.getElementById("txtBayar_"+i).value!=''){
                        txtBayar +=document.getElementById("txtBayar_"+i).value+"|";
                        txtTin +=document.getElementById("txtTin_"+i).value+"*";
                        kunjId +=document.getElementById("kunjId_"+i).value+"|";
                    }
                }
                var param ="&rowid="+encodeURIComponent(id)
                    +"&cmbPend="+encodeURIComponent(cmbPend)
                    +"&ksoId="+encodeURIComponent(ksoId)
                    +"&txtTgl="+encodeURIComponent(txtTgl)
                    +"&txtNoBu="+encodeURIComponent(txtNoBu)
                    +"&txtBayar="+encodeURIComponent(txtBayar)
                    +"&txtTin="+encodeURIComponent(txtTin)
                    +"&kunjId="+encodeURIComponent(kunjId)
                    +"&txtArea="+encodeURIComponent(txtArea)
                    +"&thn="+encodeURIComponent(thn)
                    +"&bln="+encodeURIComponent(bln)
                    +"&userId="+encodeURIComponent(userId)
                ;
                //alert("pendapatan_utils.php?act="+act+param+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
                a.loadURL("pendapatan_utils.php?act="+act+param+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
            }
        }
        
        function hapusPen(){
            document.getElementById("btnPenHapus").disabled=true;
            var rowid = document.getElementById("txtId").value;
            var act = document.getElementById("btnPenHapus").value;
            var bln = document.getElementById('blnPend').value;
            var thn = document.getElementById('thnPend').value;
            if(confirm("Anda yakin menghapus data Tanggal "+a.cellsGetValue(a.getSelRow(),2))){
                a.loadURL("pendapatan_utils.php?bln="+bln+"&thn="+thn+"&act="+act+"&rowid="+rowid,"","GET");
            }
            batalPen();
        }

        function batalPen(){
            var isian = "txtId*-**|*txtTgl*-*<?php echo $tgl;?>*|*txtNoBu*-**|*nilai*-*";
            fSetValue(window,isian);
            document.getElementById("txtArea").value="";
            document.getElementById("btnPenSimpan").value="tambah";
            document.getElementById("btnPenHapus").disabled=true;
        }

        function konfirmasi(key,val){
            //alert(val);
            if(val != undefined){
                var tangkap=val.split("*|*");
                var proses=tangkap[0];
                var alasan=tangkap[1];
                if(key=='Error'){
                    if(proses=='hapus'){
                        alert('Tidak bisa menambah data karena '+alasan+'!');
                    }

                }
                else{
                    if(proses=='tambah'){
                        alert('Tambah Berhasil');
                        document.getElementById("btnPenSimpan").disabled=false;
                    }
                    else if(proses=='simpan'){
                        alert('Simpan Berhasil');
                        document.getElementById("btnPenSimpan").disabled=false;
                    }
                    else if(proses=='hapus'){
                        alert('Hapus Berhasil');
                        document.getElementById("btnPenHapus").disabled=true;
                    }
                }
            }

        }

        function goFilterAndSort(grd){
            var bln = document.getElementById('blnPend').value;
            var thn = document.getElementById('thnPend').value;
            //alert("pendapatan_utils.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
            a.loadURL("pendapatan_utils.php?bln="+bln+"&thn="+thn+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
        }
        var bln = document.getElementById('blnPend').value;
        var thn = document.getElementById('thnPend').value;
        var a=new DSGridObject("gridbox");
        a.setHeader("PENDAPATAN");
        a.setColHeader("NO,TANGGAL,NO BUKTI,JENIS PENDAPATAN,NILAI,KET");
        a.setIDColHeader(",tgl,no_bukti,jenis_pendapatan,nilai,");
        a.setColWidth("50,80,100,250,80,200");
        a.setCellAlign("center,center,left,left,right,left");
        a.setCellHeight(20);
        a.setImgPath("../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        a.onLoaded(konfirmasi);
        a.baseURL("pendapatan_utils.php?bln="+bln+"&thn="+thn);
        a.Init();
        var th_skr = "<?php echo $date_skr[2];?>";
        var bl_skr = "<?php echo $date_skr[1];?>";
    </script>
    <script src="../report_form.js" type="text/javascript" language="javascript"></script>
</html>