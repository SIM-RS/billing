<?
include '../sesi.php';
?>
<?php
include '../koneksi/konek.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='/simrs-tangerang/aset/';
                        </script>";
}
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <title>.: Ruangan :.</title>
    </head>
    <iframe height="72" width="130" name="sort"
        id="sort"
        src="../theme/dsgrid_sort.php" scrolling="no"
        frameborder="0"
        style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
    </iframe>
    <body>
        <div align="center">
            <?php
            include '../header.php';
            ?>
            <div>
                <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center">
                            <table cellspacing=0 cellpadding="4" width="650" align="center"><tr>
                                    <td height="30" valign="bottom" align="right">
                                        <input type="hidden" id="txtId" name="txtId" />
                                        <img alt="Tambah" style="cursor: pointer" src="../images/tambah.png" onClick="location='detailRuangan.php?act=add'" />&nbsp;&nbsp;
                                        <img alt="Edit" style="cursor: pointer" src="../images/edit.gif" onClick="if(document.getElementById('txtId').value == '' || document.getElementById('txtId').value == null){alert('Pilih barang terlebih dahulu.');return;}location='detailRuangan.php?act=edit&idruangan='+document.getElementById('txtId').value" />&nbsp;&nbsp;
                                        <img alt="Hapus" style="cursor: pointer" src="../images/hapus.gif" id="btnHapus" name="btnHapus" onClick="hapus(this.title);" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <div id="gridbox" style="width:825px; height:300px; background-color:white; overflow:hidden;"></div>
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
    <script type="text/javascript" language="javascript">
        function ambilData(){
            var content = "txtId*-*"+(brg.getRowId(brg.getSelRow()));
            fSetValue(window,content);
        }
        function hapus()
        {
            var rowid = document.getElementById("txtId").value;
            if(confirm("Anda yakin menghapus Ruangan "+brg.cellsGetValue(brg.getSelRow(),2))){
                brg.loadURL("utils_utils.php?pilihan=ruangan&act=hapus_ruangan&idruangan="+rowid,"","GET");
            }
        }

        function goFilterAndSort(pilihan){
            if (pilihan=="gridbox")
            {
                brg.loadURL("utils_utils.php?pilihan=ruangan&filter="+brg.getFilter()+"&sorting="+brg.getSorting()+"&page="+brg.getPage(),"","GET");
            }
        }

        brg=new DSGridObject("gridbox");
        brg.setHeader(".: Data Ruang/Lokasi :.");
        brg.setColHeader("No,Nama Unit, Kode, Nama Ruang, Tipe, Lokasi/Gedung");
        brg.setIDColHeader(",namaunit,,namalokasi,,");
        brg.setColWidth("40,160,100,300,80,120");
        brg.setCellAlign("center,left,left,left,center,left");
        brg.setCellHeight(20);
        brg.setImgPath("../icon");
        brg.setIDPaging("paging");
        brg.attachEvent("onRowClick","ambilData");
        brg.baseURL("utils_utils.php?pilihan=ruangan");
        brg.Init();
    </script>
</html>