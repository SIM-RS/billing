<?php
include '../sesi.php';
// is valid users
/*if (!isset($_SESSION['userid'])) {
    Header("Location: login.html");
    exit;
}

// check for user type
if (isset($_SESSION['SIA_AUTH_TYPE'])) {
    if ($_SESSION['SIA_AUTH_TYPE']!="A" and $_SESSION['SIA_AUTH_TYPE']!="P"  and $_SESSION['SIA_AUTH_TYPE']!="F" and $_SESSION['SIA_AUTH_TYPE']!="M") {
        Header("Location: login.html");
        exit;
    }
} */
?>
<html>
    <head>
        <title>Rekanan</title>
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
        <table border=0 cellspacing=0 cellpadding="2" class="GridStyle" width="600">
                <tr>
                    <td>
                        <div id="gridbox" style="width:600px; height:200px; background-color:white; overflow:hidden;"></div>
                        <div id="paging" style="width:600px;"></div>
                    </td>
                </tr>
            </table>
    </body>

    <script type="text/javascript" language="JavaScript">

        function goEdit(args){
            self.opener.document.form1.refidrekanan.value = rek.getRowId(rek.getSelRow());
            self.opener.document.form1.namarekanan.value = rek.cellsGetValue(rek.getSelRow(),2);
            window.close();
        }


        var rek=new DSGridObject("gridbox");
        rek.setHeader(".: Data Rekanan / Vendor :.");
        rek.setColHeader("Kode,Nama,Tipe,Kontak,C.Person,Status");
        //a.setIDColHeader(",kode,nama,aktif");
        rek.setColWidth("75,120,100,150,75,50");
        rek.setCellAlign("center,left,left,left,left,center");
        rek.setCellHeight(20);
        rek.setImgPath("../icon");
        rek.setIDPaging("paging");
        rek.attachEvent("onRowClick","goEdit");
        rek.baseURL("utils.php?pilihan=rekanan");
        rek.Init();
    </script>
</html>
