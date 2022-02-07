<?php
include '../sesi.php';
// is valid users
/*if (!isset($_SESSION['userid'])) {
    Header("Location: index.php");
    exit;
}

// check for user type
if (isset($_SESSION['SIA_AUTH_TYPE'])) {
    if ($_SESSION['SIA_AUTH_TYPE']!="A" and $_SESSION['SIA_AUTH_TYPE']!="P"  and $_SESSION['SIA_AUTH_TYPE']!="F" and $_SESSION['SIA_AUTH_TYPE']!="M") {
        Header("Location: login.html");
        exit;
    }
}*/
?>

<html>
    <head>
        <title>Daftar Barang</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <META http-equiv="Page-Enter" CONTENT="RevealTrans(Duration=0.1,Transition=12)">

        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <style type="text/css">
            BODY, TD {font-family:Verdana; font-size:7pt}
        </style>
    </head>
    <body bgcolor=#CCCCCC style="border-width:0px">
        <table border=0 cellspacing=0 cellpadding="2" class="GridStyle" width="300">
            <tr>
                <td>
                    <div id="gridbox" style="width:450px; height:200px; background-color:white; overflow:hidden;"></div>
                    <div id="paging" style="width:450px;"></div>
                </td>
            </tr>
        </table>
    </body>
    <script type="text/javascript">
        function goEdit(args){
            self.opener.document.form1.idbarang.value = rek.getRowId(rek.getSelRow());
            self.opener.document.form1.kodebarang.value = rek.getRowId(rek.getSelRow(),1);
            self.opener.document.form1.namabarang.value = rek.cellsGetValue(rek.getSelRow(),2);
            window.close();
        }

        function goFilterAndSort(grd)
        {
            if (grd=="gridbox"){
                //alert("tabel_utils.php?grd1=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
                rek.loadURL("utils.php?pilihan=barang_tree&filter="+rek.getFilter()+"&sorting="+rek.getSorting()+"&page="+rek.getPage(),"","GET");
            }
        }

        var rek=new DSGridObject("gridbox");
        rek.setHeader(".: Daftar Barang :.");
        rek.setColHeader("Kode,Nama Barang,Nomor Seri");
        rek.setIDColHeader("kodebarang,namabarang,noseri");
        rek.setColWidth("75,175,50");
        rek.setCellAlign("center,left,center");
        rek.setCellHeight(20);
        rek.setImgPath("../icon");
        rek.setIDPaging("paging");
        rek.attachEvent("onRowClick","goEdit");
        rek.baseURL("utils.php?pilihan=barang_tree&idunit=<?php echo $_GET['idunit'];?>");
        rek.Init();
        alert("utils.php?pilihan=barang_tree&idunit=<?php echo $_GET['idunit'];?>");
    </script>
</html>