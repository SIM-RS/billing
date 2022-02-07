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
$type = $_SESSION["usertype"];
?>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <title>.: Unit Kerja :.</title>
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
            include("../header.php");
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
                                    <button type="button" onClick="PreviewTree();" style="cursor: pointer">
                                    <img alt="add" src="../icon/view_tree.gif" border="0" width="16" height="16" ALIGN="absmiddle" />
                            Tampilkan Unit Dalam Tree
                                    </button>
                                    <span style="visibility:<? if($type=="G") echo "hidden"; else echo "visible"; ?>">
                                    <input type="hidden" id="txtId" name="txtId" />
                                    <img alt="tambah" style="cursor: pointer" src="../images/tambah.png" onClick="location='detailUnit.php?act=add'" />&nbsp;&nbsp;
                                    <img alt="edit" style="cursor: pointer" src="../images/edit.gif" onClick="if(document.getElementById('txtId').value == '' || document.getElementById('txtId').value == null){alert('Pilih barang terlebih dahulu.');return;}location='detailUnit.php?act=edit&idunit='+document.getElementById('txtId').value" />&nbsp;&nbsp;
                                    <img alt="hapus" style="cursor: pointer" src="../images/hapus.gif" id="btnHapusUnit" name="btnHapusUnit" onClick="if(document.getElementById('txtId').value == '' || document.getElementById('txtId').value == null){alert('Pilih barang terlebih dahulu.');return;}hapus();" />&nbsp;
                                </span></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <div id="gridboxUnit" style="width:823px; height:300px; background-color:white; overflow:hidden;"></div>
                                    <div id="pagingUnit" style="width:823px;"></div>
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
    </body>
    <script type="text/javascript" language="javascript">
        function PreviewTree()
        {
            location='treeUnit.php';
        }
        function ambilDataUnit()
        {
            var p="txtId*-*"+(unt.getRowId(unt.getSelRow()));
            fSetValue(window,p);
        }

        function hapus(id)
        {
            var rowidUnit = document.getElementById("txtId").value;

            if(confirm("Anda yakin menghapus Unit Kerja "+unt.cellsGetValue(unt.getSelRow(),2)))
            {
                unt.loadURL("utils_utils.php?pilihan=grdUnit&act=hapus_unit&rowid="+rowidUnit,"","GET");
            }
        }

        function goFilterAndSort(grdUnit)
        {
            if (grdUnit=="gridboxUnit")
            {
				//alert(utils_utils.php?pilihan=grdUnit&filter="+unt.getFilter()+"&sorting="+unt.getSorting()+"&page="+unt.getPage());
                unt.loadURL("utils_utils.php?pilihan=grdUnit&filter="+unt.getFilter()+"&sorting="+unt.getSorting()+"&page="+unt.getPage(),"","GET");
				alert("utils_utils.php?pilihan=grdUnit&filter="+unt.getFilter()+"&sorting="+unt.getSorting()+"&page="+unt.getPage());
            }
        }

        var unt=new DSGridObject("gridboxUnit");
        unt.setHeader(".: Data Unit / Satuan Kerja :.");
        unt.setColHeader("No,Kode Unit,Nama,Nama Panjang,Level,Aktif");
        unt.setIDColHeader(",kodeunit,namaunit,namapanjang,");
        unt.setColWidth("50,130,250,270,50,50");
        unt.setCellAlign("center,left,left,left,center,center");
        unt.setCellHeight(20);
        unt.setImgPath("../icon");
        unt.setIDPaging("pagingUnit");
        unt.attachEvent("onRowClick","ambilDataUnit");
        unt.baseURL("utils_utils.php?pilihan=grdUnit");
        unt.Init();
    </script>
</html>
