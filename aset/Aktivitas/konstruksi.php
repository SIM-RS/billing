<?php
include '../sesi.php';
include '../koneksi/konek.php'; 
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>
        alert('Session anda habis atau anda belum login, silakan login ulang.');
        window.location = '/simrs-tangerang/aset/';
        </script>";
}
?>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <title>.: KIB Konstruksi :.</title>
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
            include 'popup_mutasi.php';
            include("../header.php");
            ?>
            <div>
                <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center">
                            <table width="850" border="0" cellspacing="0" cellpadding="0" align="center" class="tabel">
                                <tr>
                                    <td height="30" valign="bottom" align="right">
									<button type="button" id="ctkxls" name="ctkxls" onClick="ctkKIB_Tnhxls()" style="cursor:pointer"><img src="../icon/excel_logo.png" width="23" height="23" style="vertical-align:middle">&nbsp;Export Ke Excel</button>&nbsp;
                                        <input type="hidden" id="txtId" name="txtId" />
                                        <img alt="edit" title="Edit Data Barang" src="../images/edit.gif" onClick="if(document.getElementById('txtId').value == '' || document.getElementById('txtId').value == null){alert('Pilih barang terlebih dahulu.');return;}location='detailKonstruksi.php?act=view&id_kib='+document.getElementById('txtId').value" />&nbsp;&nbsp;
                                        <img alt="Mutasi Barang" title="Mutasi Barang" src="../icon/mutasi.gif" id="btnHapusTanah" name="btnHapus" onClick="if(document.getElementById('txtId').value == '' || document.getElementById('txtId').value == null){alert('Pilih barang terlebih dahulu.');return;}todo('mutasi','div_popup','konstruksi');" />&nbsp;
                                        <img alt="Penghapusan Barang" title="Penghapusan Barang" src="../images/hapus.gif" id="btnHapusKonstruksi" name="btnHapus" onClick="if(document.getElementById('txtId').value == '' || document.getElementById('txtId').value == null){alert('Pilih barang terlebih dahulu.');return;}todo('hapus','div_popup','konstruksi');" />&nbsp;

                                        <!--img alt="edit" src="../images/edit.gif" onclick="if(document.getElementById('txtId').value == '' || document.getElementById('txtId').value == null){alert('Pilih barang terlebih dahulu.');return;}location='detailKonstruksi.php?act=view&id_kib='+document.getElementById('txtId').value" />&nbsp;&nbsp;
                                        <img alt="Penghapusan Barang" title="Penghapusan Barang" src="../images/hapus.gif" id="btnHapusKonstruksi" name="btnHapus" onclick="if(document.getElementById('txtId').value == '' || document.getElementById('txtId').value == null){alert('Pilih barang terlebih dahulu.');return;}hapus();" />&nbsp;-->
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <div id="gridbox" style="width:835px; height:200px; background-color:white; overflow:hidden;"></div>
                                        <div id="paging" style="width:835px;"></div>
                                    </td>
                                </tr>
                            </table>
                            <?php
                            include '../footer.php';
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
    <script type="text/javascript" language="javascript">
        var tmp;
        function ambilData()
        {
            tmp = grid.getRowId(grid.getSelRow()).split('<?php echo chr(36);?>');
            var p = "txtId*-*"+(tmp[0]);
            fSetValue(window,p);
        }

        /*function hapus(id)
        {
            var rowid = document.getElementById("txtId").value;
            if(confirm("Anda yakin menghapus KIB Konstruksi "+grid.cellsGetValue(grid.getSelRow(),4)))
            {
                grid.loadURL("utils_seri.php?pilihan=konstruksi&act=hapus_konstruksi&rowid="+rowid,"","GET");
            }
        }*/

        function goFilterAndSort(konstruksi)
        {
            //alert(grd);
            if (konstruksi=="gridbox"){
                alert("utils_seri.php?grd1=true&filter="+grid.getFilter()+"&sorting="+grid.getSorting()+"&page="+grid.getPage());
                grid.loadURL("utils_seri.php?pilihan=konstruksi&filter="+grid.getFilter()+"&sorting="+grid.getSorting()+"&page="+grid.getPage(),"","GET");
            }
        }

        var grid=new DSGridObject("gridbox");
        grid.setHeader(".: Kartu Inventaris Barang - Konstruksi Dalam Pengerjaan :.");
        grid.setColHeader("Kode Unit,Kode Brg,No Seri,Nama Barang,Bangunan (P SP D),Luas (m2),Tgl Bangun,Status Tanah");
        grid.setIDColHeader("kodeunit,kodebarang,,namabarang,,,,,");
        grid.setColWidth("75,75,50,150,85,75,75,75");
        grid.setCellAlign("center,center,center,left,center,center,center,center");
        grid.setCellHeight(20);
        grid.setImgPath("../icon");
        grid.setIDPaging("paging");
        grid.attachEvent("onRowClick","ambilData");
        grid.baseURL("utils_seri.php?pilihan=konstruksi");
        grid.Init();
    </script>
</html>