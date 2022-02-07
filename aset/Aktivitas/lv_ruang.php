<?php
include '../sesi.php';

$r_idunit = $_REQUEST['idunit'];
$r_namaunit = $_REQUEST['namaunit'];
include("../koneksi/konek.php");
$columnCount = 3;
$strSQL = "select idlokasi,kodelokasi,namalokasi from as_lokasi where idunit=$r_idunit order by kodelokasi";
$rs = mysql_query($strSQL);
?>

<html>
    <head>
        <title>Ruangan</title>
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
    <body bgcolor=#CCCCCC style="border-width:0px" onBlur="window.close();">
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
            if("<?php echo $r_idunit?>" == ''){
                var idlokun = rek.getRowId(rek.getSelRow()).split('|');
                window.opener.document.form1.idlokasi.value = idlokun[0];
                window.opener.document.form1.idunit.value = idlokun[1];
                window.opener.document.form1.kodelokasi.value = rek.cellsGetValue(rek.getSelRow(),1);
                window.opener.document.form1.namalokasi.value = rek.cellsGetValue(rek.getSelRow(),2);
            }
            else{
                window.opener.document.form1.idlokasi.value = rek.getRowId(rek.getSelRow());
                window.opener.document.form1.kodelokasi.value = rek.cellsGetValue(rek.getSelRow(),1);
                window.opener.document.form1.namalokasi.value = rek.cellsGetValue(rek.getSelRow(),2);
            }
            window.close();
        }

        var rek=new DSGridObject("gridbox");
        rek.setHeader(".: Daftar Ruangan Pada Unit Kerja : <?php echo $r_namaunit; ?> :.");
        rek.setColHeader("Kode,Nama Ruang,GD");
        //a.setIDColHeader(",kode,nama,aktif");
        rek.setColWidth("75,100,75");
        rek.setCellAlign("center,center,center");
        rek.setCellHeight(20);
        rek.setImgPath("../icon");
        rek.setIDPaging("paging");
        rek.attachEvent("onRowClick","goEdit");
        rek.baseURL("utils.php?pilihan=ruang_tree&idunit=<?php echo $r_idunit;?>");
        rek.Init();
    </script>
</html>
