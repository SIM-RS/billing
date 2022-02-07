<?php
include '../sesi.php';
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
        <title>Perolehan</title>
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
                                        <img alt="tambah" style="cursor: pointer" src="../images/tambah.png" onClick="location='detailPerolehan.php?act=add'" />&nbsp;&nbsp;
                                        <img alt="edit" style="cursor: pointer" src="../images/edit.gif" onClick="goedit();" />&nbsp;&nbsp;
                                        <img alt="hapus" style="cursor: pointer" src="../images/hapus.gif" id="btnHapusPerolehan" name="btnHapus" onClick="hapus();" />&nbsp;
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
        </div>
    </body>
    <script type="text/javascript" language="javascript">
        function ambilData()
        {
            var p="txtId*-*"+(rek.getRowId(rek.getSelRow()));
            fSetValue(window,p);
        }

        function goedit(){
            if(document.getElementById('txtId').value != '' && document.getElementById('txtId').value != null){
                location='detailPerolehan.php?act=edit&idperolehan='+document.getElementById('txtId').value;
            }
            else{
                alert('Pilih dulu perolehan yang akan diedit.');
            }
        }

        function hapus()
        {
            var rowid = document.getElementById("txtId").value;
            if(confirm("Anda yakin menghapus Perolehan "+rek.cellsGetValue(rek.getSelRow(),2)+" no.Ref "+rek.cellsGetValue(rek.getSelRow(),8)+"?")){
                rek.loadURL("utils.php?pilihan=perolehan&act=hapus_perolehan&idperolehan="+rowid,"","GET");
            }
        }


        function goFilterAndSort(pilihan){
            if (pilihan=="gridbox")
            {
                rek.loadURL("utils.php?pilihan=perolehan&filter="+rek.getFilter()+"&sorting="+rek.getSorting()+"&page="+rek.getPage(),"","GET");
            }
        }

        var rek=new DSGridObject("gridbox");
        rek.setHeader(".: Data Perolehan / Supplier :.");
        rek.setColHeader("Kode Unit,Tgl,T/K,Jenis,Kode Barang,Nama Barang,Qty,No.Ref,Ruangan");
        rek.setIDColHeader("kodeunit,,,,kodebarang,namabarang,,,namalokasi");
        rek.setColWidth("75,100,75,50,75,150,50,50,50");
        rek.setCellAlign("center,center,center,center,center,left,center,center,center");
        rek.setCellHeight(20);
        rek.setImgPath("../icon");
        rek.setIDPaging("paging");
        rek.attachEvent("onRowClick","ambilData");
        rek.baseURL("utils.php?pilihan=perolehan");
        rek.Init();
    </script>
</html>