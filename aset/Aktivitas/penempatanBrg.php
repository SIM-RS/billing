<?php
include '../sesi.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>
        alert('Session anda habis atau anda belum login, silakan login ulang.');
        window.location = '/simrs-tangerang/aset/';
        </script>";
}
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl);
?>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <title>.: Penerimaan PO :.</title>
    </head>

    <body>
        <div align="center">
            <?php
            include("../header.php");
            include("../koneksi/konek.php");
            ?>
            <table align="center" width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFBF0">
                <tr>
                    <td height="20" colspan="4">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="4" align="center" style="font-size:16px;">DAFTAR BARANG BELUM DITEMPATKAN </td>
                </tr>
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                  <td width="45%">&nbsp;</td>
                    <td width="45%" align="right">
                        <button type="button" style="cursor: pointer" onClick="if(document.getElementById('id').value == '' || document.getElementById('id').value == null){alert('Pilih dulu barang yang akan ditempatkan.');return;}location='detailPenempatanBrg.php?act=edit&id='+document.getElementById('id').value;">Set Lokasi</button>
                    </td>
                    <td width="5%">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="4" align="center">
                        <div id="gridbox" style="width:900px; height:350px; background-color:white; overflow:hidden;"></div>
                        <div id="paging" style="width:900px;"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                <?php
                include '../footer.php';
                ?>
                    </td>
                </tr>
            </table>
        </div>
    </body>
    <script type="text/javascript" language="javascript">
        function filter()
        {
            var bln = document.getElementById("bulan").value;
            var thn = document.getElementById("ta").value;
            //alert("utils.php?pilihan=penerimaanpo&bln="+bln+"&thn="+thn);
            po.loadURL("utils.php?pilihan=penerimaanpo&bln="+bln+"&thn="+thn,"","GET");
        }

        function goFilterAndSort(grd)
        {
            var bln = document.getElementById("bulan").value;
            var thn = document.getElementById("ta").value;
            if (grd=="gridbox"){
                po.loadURL("utils.php?pilihan=penerimaan_po&bln="+bln+"&thn="+thn+"&filter="+po.getFilter()+"&sorting="+po.getSorting()+"&page="+po.getPage(),"","GET");
            }
        }
        function ambilData()
        {
            var p="id*-*"+(po.cellsGetValue(po.getSelRow(),3)+'|'+po.cellsGetValue(po.getSelRow(),4));
            fSetValue(window,p);
        }

        var po=new DSGridObject("gridbox");
        po.setHeader(".: DAFTAR BARANG BELUM DITEMPATKAN :.");
        po.setColHeader("NO,TGL,KODE BARANG,NAMA BARANG,NO PO, JUDUL PO,JML,SATUAN,U/ UNIT");
        po.setColWidth("30,60,100,120,100,100,50,50,50");
        po.setCellAlign("center,center,center,center,center,center,center,center,center");
        po.setCellHeight(20);
        po.setImgPath("../icon");
        po.setIDPaging("paging");
        po.attachEvent("onRowClick","ambilData");
        //alert("utils.php?pilihan=penerimaanpo&bln="+document.getElementById("bulan").value+"&thn="+document.getElementById("ta").value);
        po.baseURL("utils.php?pilihan=penerimaan");
        po.Init();
    </script>
</html>
