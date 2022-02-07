<?php
include '../koneksi/konek.php'; 
session_start();
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='/simrs/aset/';
                        </script>";
}
$type = $_SESSION["usertype"];
$viewProblem=$_REQUEST['e'];
?>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <title>.: Kode Barang :.</title>
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
            <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td align="center">
                        <table width="850" border="0" cellspacing="0" cellpadding="0" align="center" class="tabel">
                            <tr>
                                <td style="padding-left: 15px">KATEGORI
                                    <select id="tipe" name="tipe" class="txt" onChange="filter(this.value)">
                                        <option value="1" <?php echo ($_GET['tipe']=="1")? "selected" : "";?>>Aset Tetap</option>
                                        <option value="2" <?php echo ($_GET['tipe']=="2")? "selected" : "";?>>Aset Lancar</option>
                                    </select>
                                </td>
                                <td height="30" valign="bottom" align="right">
                                    <button type="button" onClick="PreviewTree();" style="cursor: pointer">
                                    <img alt="add" src="../icon/view_tree.gif" border="0" width="16" height="16" ALIGN="absmiddle" />
                            Tampilkan Dalam Tree
                                    </button>
									<span id="pa" style="visibility:<? if($type=="G") echo "hidden"; else echo "visible"; ?>">
                                    <input type="hidden" id="txtId" name="txtId" />
									<?php 
									if($viewProblem!=1){
									?>
                                    <img alt="tambah" style="cursor: pointer" src="../images/tambah.png" onClick="location='detailBrg.php?act=add&tipe='+document.getElementById('tipe').value" />&nbsp;&nbsp;
                                    <img alt="edit" style="cursor: pointer" src="../images/edit.gif" onClick="if(document.getElementById('txtId').value == '' || document.getElementById('txtId').value == null){alert('Pilih barang terlebih dahulu.');return;}location='detailBrg.php?act=edit&idbarang='+document.getElementById('txtId').value+'&tipe='+document.getElementById('tipe').value" />&nbsp;&nbsp;
                                    <img alt="hapus" style="cursor: pointer" src="../images/hapus.gif" id="btnHapus" name="btnHapus" onClick="hapus();" />&nbsp;
									<?php } ?>
                                </span>
								</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td align="center" colspan="2">
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
    </body>
    <script type="text/javascript" language="javascript">
        var tipe = document.getElementById("tipe").value;
        
        function ambilData()
        {
            var p="txtId*-*"+(brg.getRowId(brg.getSelRow()));
            fSetValue(window,p);
        }
        
        function PreviewTree()
        {
            location='treeBarang.php?tipe='+document.getElementById("tipe").value;
        }
        
        function hapus()
        {
            var rowid = document.getElementById("txtId").value;
            tipe = document.getElementById("tipe").value;

            if(confirm("Anda yakin menghapus Kode Barang "+brg.cellsGetValue(brg.getSelRow(),2)))
            {
                brg.loadURL("utils_utils.php?pilihan=grd&act=hapus_barang&tipe="+tipe+"&rowid="+rowid,"","GET");
            }
        }

        function goFilterAndSort(grd)
        {
            //alert(grd);
            tipe = document.getElementById("tipe").value;
            if (grd=="gridbox"){
                //alert("utils_utils.php?pilihan=grd&tipe="+tipe+"&filter="+brg.getFilter()+"&sorting="+brg.getSorting()+"&page="+brg.getPage());
                brg.loadURL("utils_utils.php?pilihan=grd&tipe="+tipe+"&filter="+brg.getFilter()+"&sorting="+brg.getSorting()+"&page="+brg.getPage(),"","GET");
            }
        }

        function filter(value){
            brg.loadURL("utils_utils.php?pilihan=grd&tipe="+value,"","GET");
        }

        var brg=new DSGridObject("gridbox");
        brg.setHeader(".: Data Kode Barang :.");
        brg.setColHeader("No,Kode Barang,Nama Barang,Satuan Kecil,Satuan Besar,Level,Aktif");
        brg.setIDColHeader(",kodebarang,namabarang,,,,");
        brg.setColWidth("50,150,300,100,100,50,50");
        brg.setCellAlign("center,left,left,center,center,center,center");
        brg.setCellHeight(20);
        brg.setImgPath("../icon");
        brg.setIDPaging("paging");
        brg.attachEvent("onRowClick","ambilData");
        brg.baseURL("utils_utils.php?pilihan=grd&tipe="+tipe);
        brg.Init();
    </script>
</html>
