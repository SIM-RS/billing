<?php
include '../sesi.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='/simrs-tangerang/aset/';
                        </script>";
}
?>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <title>.: Pemakaian Barang :.</title>
    </head>

    <body>
        <div align="center">
            <iframe height="72" width="130" name="sort"
                    id="sort"
                    src="../theme/dsgrid_sort.php" scrolling="no"
                    frameborder="0"
                    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
            </iframe>
            <?php
            include "../header.php";
            $date_now=gmdate('d-m-Y',mktime(date('H')+7));
            $tgl=explode("-",$date_now);
            $tgl1=$tgl[2]."-".$tgl[1]."-".$tgl[0];
            ?>
            <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td align="center">
                        <table width="850" border="0" cellspacing="0" cellpadding="0" align="center" class="tabel">
                            <tr>
                                <td height="30" valign="bottom" align="right">
                                    <input type="hidden" id="id" name="id" />

                                    <button type="button" onClick="location='detailPemakaian.php?act=add'" style="cursor: pointer">
                                        <img alt="add" src="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle" />
                                        Penerimaan Baru
                                    </button>
                                    <!--button type="button" style="cursor: pointer" onClick="if(document.getElementById('nokirim').value == '' || document.getElementById('nokirim').value == null){alert('Pilih dulu Pemakaian yang akan diedit.');return;}location='detailPemakaian.php?act=edit&nokirim='+document.getElementById('nokirim').value;">
                                        <img alt="add" src="../icon/edit.gif" border="0" width="16" height="16" ALIGN="absmiddle" />
                                        Edit Penerimaan
                                    </button-->
                                    <button type="button" style="cursor: pointer" onClick="if(document.getElementById('id').value == '' || document.getElementById('id').value == null){alert('Pilih dulu data Penerimaan yang akan dihapus.');return;}hapus(document.getElementById('id').value);" >
                                        <img alt="hapus" style="cursor: pointer" src="../images/hapus.gif" id="btnHapusPO" name="btnHapus" onClick="hapus();" />
                                        Hapus Penerimaan
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Bulan&nbsp;:&nbsp;
                                    <select name="cmbBln" class="txt" id="cmbBln" onChange="filter()">
                                        <?php
                                        $arrBln=array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
                                        for($i=1;$i<=12;$i++) {?>
                                        <option value="<?php echo $i?>"<?php if($tgl[1]==$i) echo 'selected';?>><?php echo $arrBln[$i]?></option>
                                            <?php }?>
                                    </select>&nbsp;
                                    Tahun&nbsp;:&nbsp;
                                    <select name="cmbTh" class="txt" id="cmbTh" onChange="filter()">
                                        <?php for($i=($tgl[2]-5);$i<$tgl[2]+6;$i++) {?>
                                        <option value="<?php echo $i;?>"<?php if($tgl[2]==$i) echo 'selected';?>><?php echo $i;?></option>
                                            <?php }?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <div id="gridbox" style="width:825px; height:200px; background-color:white; overflow:hidden;"></div>
                                    <div id="paging" style="width:825px;"></div>
                                </td>
                            </tr>
                        </table>
                        <div><img alt="" src="../images/foot.gif" width="1000" height="45" /></div>
                    </td>
                </tr>
            </table>
        </div>
    </body>
    <script type="text/javascript" language="javascript">
        function ambilData()
        {
            var p="id*-*"+rek.getRowId(rek.getSelRow());
                //"nokirim*-*"+rek.cellsGetValue(rek.getSelRow(),3);
            fSetValue(window,p);
        }

        function hapus(id)
        {
            //var rowid = document.getElementById("txtId").value;
            if(confirm("Anda yakin menghapus Pemakaian "+rek.cellsGetValue(rek.getSelRow(),5))){
                //alert("utils.php?pilihan=pemakaian&bln="+document.getElementById('cmbBln').value+"&thn="+document.getElementById('cmbTh').value+"&act=hapus_pemakaian&id="+id);
                rek.loadURL("utils.php?pilihan=pemakaian&bln="+document.getElementById('cmbBln').value+"&thn="+document.getElementById('cmbTh').value+"&act=hapus_pemakaian&id="+id,"","GET");
            }
        }

        function filter(){
            rek.loadURL("utils.php?pilihan=pemakaian&bln="+document.getElementById('cmbBln').value+"&thn="+document.getElementById('cmbTh').value,"","GET");
        }

        function goFilterAndSort(pilihan){
            if (pilihan=="gridbox")
            {
                rek.loadURL("utils.php?pilihan=pemakaian&bln="+document.getElementById('cmbBln').value+"&thn="+document.getElementById('cmbTh').value+"&filter="+rek.getFilter()+"&sorting="+rek.getSorting()+"&page="+rek.getPage(),"","GET");
            }
        }

        var rek=new DSGridObject("gridbox");
        rek.setHeader(".: Data Pemakaian Barang :.");
        rek.setColHeader("No,Tanggal Kirim,No Kirim,Kode Barang,Nama Barang,Satuan,Unit Tujuan,Qty");
        //rek.setIDColHeader(",,nokirim,vendor_id,,");
        rek.setColWidth("50,80,120,100,150,60,120,60");
        rek.setCellAlign("center,center,center,center,left,center,left,center");
        rek.setCellHeight(20);
        rek.setImgPath("../icon");
        rek.setIDPaging("paging");
        rek.attachEvent("onRowClick","ambilData");
        rek.baseURL("utils.php?pilihan=pemakaian&bln="+document.getElementById('cmbBln').value+"&thn="+document.getElementById('cmbTh').value);
        rek.Init();
    </script>
</html>