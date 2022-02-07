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

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <title>Sumber Dana</title>
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
            ?>
            <div>
                <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center">
                            <table width="450" align="center" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td height="30" align="right">
                                        <input type="hidden" id="txtId" name="txtId" />
                                        <img alt="tambah" style="cursor: pointer" src="../images/tambah.png" onClick="location='detailDana.php?act=add'" />&nbsp;&nbsp;
                                        <img alt="edit" style="cursor: pointer" src="../images/edit.gif" onClick="if(document.getElementById('txtId').value == '' || document.getElementById('txtId').value == null){alert('Pilih barang terlebih dahulu.');return;}location='detailDana.php?act=edit&idsumberdana='+document.getElementById('txtId').value" />&nbsp;&nbsp;
                                        <img alt="hapus" style="cursor: pointer" src="../images/hapus.gif" id="btnHapusDana" name="btnHapusDana" onClick="if(document.getElementById('txtId').value == '' || document.getElementById('txtId').value == null){alert('Pilih barang terlebih dahulu.');return;}hapus();" />&nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center"><div id="gridbox" style="width:725px; height:275px; background-color:white; overflow:hidden;"></div>
                                        <div id="paging" style="width:725px;"></div>
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
        function ambilData()
        {
            var p="txtId*-*"+(dana.getRowId(dana.getSelRow()));
            fSetValue(window,p);
        }

        function hapus()
        {
            var rowid = document.getElementById("txtId").value;

            if(confirm("Anda yakin menghapus Sumber Dana "+dana.cellsGetValue(dana.getSelRow(),1)))
            {
                dana.loadURL("utils_utils.php?pilihan=grdDana&act=hapus_dana&rowid="+rowid,"","GET");
            }
        }

        function goFilterAndSort(grdDana)
        {
            if (grdDana=="gridbox"){
                //alert("tabel_utils.php?grd1=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
                dana.loadURL("utils_utils.php?pilihan=grdDana&filter="+dana.getFilter()+"&sorting="+dana.getSorting()+"&page="+dana.getPage(),"","GET");
            }
        }

        var dana=new DSGridObject("gridbox");
        dana.setHeader(".: Data Sumber Dana :.");
        dana.setColHeader("No,Sumber Dana");
        dana.setIDColHeader("nourut,keterangan");
        dana.setColWidth("100,600");
        dana.setCellAlign("center,left");
        dana.setCellHeight(20);
        dana.setImgPath("../icon");
        dana.setIDPaging("paging");
        dana.attachEvent("onRowClick","ambilData");
        dana.baseURL("utils_utils.php?pilihan=grdDana");
		//alert("utils_utils.php?pilihan=grdDana")
        dana.Init();
    </script>
</html>
