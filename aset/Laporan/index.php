<?php
session_start();
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='/simrs/aset/';
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
        <title>.: Tabel :.</title>
    </head>
    <body>
        <div align="center">
            <?php
            include '../header.php';
            ?>
            <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center" style="padding-top: 10px; background-color: white">
                        <table width="635" cellpadding="0" cellspacing="0">
                            <tr>
                                <td colspan="2" class="header"><strong>Keterangan Menu - Laporan </strong></td>
                            </tr>
                            <tr>
                                <td class="label">&nbsp;<strong>K I B </strong></td>
                                <td class="content">&nbsp;Laporan yang mencatat barang inventaris digolongkan sesuai dengan klasifikasi jenis barang</td>
                            </tr>
                            <tr>
                                <td class="label">&nbsp;<strong>Buku Inventaris </strong></td>
                                <td class="content">&nbsp;Laporan yang mencatat barang inventaris dari masing-masing unit / satuan kerja</td>
                            </tr>
                            <tr>
                                <td class="label">&nbsp;<strong>Mutasi Barang</strong></td>
                                <td class="content">&nbsp;Laporan perpindahan penempatan / lokasi dari barang inventaris</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="footer">&nbsp;</td>
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
</html>