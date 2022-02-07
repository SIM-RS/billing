<?php
include '../sesi.php';
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
        <title>Perubahan Nilai Aset</title>
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
                                        <img alt="tambah" style="cursor: pointer" src="../images/tambah.png" onClick="location='nilai_detail.php?act=add'" />&nbsp;&nbsp;
                                        <img alt="edit" style="cursor: pointer" src="../images/edit.gif" onClick="if(document.getElementById('txtId').value == '' || document.getElementById('txtId').value == null){alert('Pilih barang terlebih dahulu.');return;}location='nilai_detail.php?act=edit&id='+document.getElementById('txtId').value" />&nbsp;&nbsp;
                                        <img alt="hapus" style="cursor: pointer" src="../images/hapus.gif" id="btnHapusRekanan" name="btnHapus" onClick="if(document.getElementById('txtId').value == '' || document.getElementById('txtId').value == null){alert('Pilih barang terlebih dahulu.');return;}hapus();" />&nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <div id="gridbox" style="width:875px; height:300px; background-color:white; overflow:hidden;"></div>
                                        <div id="paging" style="width:875px;"></div>
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
            var p="txtId*-*"+(rek.getRowId(rek.getSelRow()));
            fSetValue(window,p);
        }

        function hapus(id)
        {
            var rowid = document.getElementById("txtId").value;
				//alert(rowid);
            if(confirm("Anda yakin menghapus Data "+rek.cellsGetValue(rek.getSelRow(),2))){
                rek.loadURL("nilai_utils.php?pil=jo&pop=hps&id="+rowid,"","GET");
            }
        }

        function goFilterAndSort(grdRek)
        {
            //alert(grd);
            if (grdRek=="gridbox"){
                //alert("tabel_utils.php?grd1=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
                rek.loadURL("nilai_utils.php?pil=jo&filter="+rek.getFilter()+"&sorting="+rek.getSorting()+"&page="+rek.getPage(),"","GET");
            }
        }

        var rek=new DSGridObject("gridbox");
        rek.setHeader(".: Data Perubahan Data Aset :.");
        rek.setColHeader("No,Nama barang,Nilai Awal,Nilai Perubahan,Nilai Akhir,Tgl Perubahan,T / K,Jenis,Document,Keterangan ");
        rek.setIDColHeader(",namabarang,nilai_awal,nilai_perubahan,nilai_akhir,tgl_perubahan");
        rek.setColWidth("50,200,100,200,100,100,100,100,100,100");
        rek.setCellAlign("center,left,right,right,right,center,center");
        rek.setCellHeight(20);
        rek.setImgPath("../icon");
        rek.setIDPaging("paging");
        rek.attachEvent("onRowClick","ambilData");
        rek.baseURL("nilai_utils.php?pil=jo");
        rek.Init();
    </script>
</html>
