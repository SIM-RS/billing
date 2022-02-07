<?php
include '../sesi.php';
include '../koneksi/konek.php'; 
session_start();
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
        <title>.: KIB Gedung :.</title>
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
                                        <input type="hidden" id="txtId" name="txtId" />
                                        <img alt="edit" title="Edit Data Barang" src="../images/edit.gif" onClick="if(document.getElementById('txtId').value == '' || document.getElementById('txtId').value == null){alert('Pilih barang terlebih dahulu.');return;}location='detailGedung.php?act=view&id_kib='+document.getElementById('txtId').value" />&nbsp;&nbsp;
                                        <img alt="Mutasi Barang" title="Mutasi Barang" src="../icon/mutasi.gif" id="btnHapusTanah" name="btnHapus" onClick="if(document.getElementById('txtId').value == '' || document.getElementById('txtId').value == null){alert('Pilih barang terlebih dahulu.');return;}todo('mutasi','div_popup','gedung');" />&nbsp;
                                        <img alt="Penghapusan Barang" title="Penghapusan Barang" src="../images/hapus.gif" id="btnHapusGedung" name="btnHapus" onClick="if(document.getElementById('txtId').value == '' || document.getElementById('txtId').value == null){alert('Pilih barang terlebih dahulu.');return;}todo('hapus','div_popup','gedung');" />&nbsp;

                                        <!--img alt="edit" src="../images/edit.gif" onclick="if(document.getElementById('txtId').value == '' || document.getElementById('txtId').value == null){alert('Pilih barang terlebih dahulu.');return;}location='detailGedung.php?act=view&id_kib='+document.getElementById('txtId').value" />&nbsp;&nbsp;
                                        <img alt="Penghapusan Barang" title="Penghapusan Barang" src="../images/hapus.gif" id="btnHapusGedung" name="btnHapus" onclick="if(document.getElementById('txtId').value == '' || document.getElementById('txtId').value == null){alert('Pilih barang terlebih dahulu.');return;}hapus();" />&nbsp;-->
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
                            <?php
                            include '../footer.php';
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
    <script type="text/JavaScript">
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

            if(confirm("Anda yakin menghapus KIB Gedung "+grid.cellsGetValue(grid.getSelRow(),4)))
            {
                grid.loadURL("utils_seri.php?pilihan=gedung&act=hapus_gedung&rowid="+rowid,"","GET");
            }
        }*/

        function goFilterAndSort(gedung)
        {
            //alert(grd);
            if (gedung=="gridbox"){
                grid.loadURL("utils_seri.php?pilihan=gedung&filter="+grid.getFilter()+"&sorting="+grid.getSorting()+"&page="+grid.getPage(),"","GET");
            }
        }

        var grid=new DSGridObject("gridbox");
        grid.setHeader(".: KIB C - Gedung Dan Bangunan :.");
        grid.setColHeader("Kode Unit,Kode,Seri,Jenis/Nama Barang,Kondisi");
        //grid.setIDColHeader("kodeunit,kodebarang,,namabarang,,,,,,");
        //grid.setColWidth("75,75,50,150,75,75,75,75,75");
		grid.setColWidth("75,50,150,75,75");
        grid.setCellAlign("center,center,left,center,center");
        grid.setCellHeight(20);
        grid.setImgPath("../icon");
        grid.setIDPaging("paging");
        grid.attachEvent("onRowClick","ambilData");
        grid.baseURL("gedung_util.php");
        grid.Init();
    </script>
</html>