<?
include '../sesi.php';
?>
<?php
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
                                <td colspan="2" class="header"><strong>Keterangan Menu - Tabel </strong></td>
                            </tr>
                            <tr>
                                <td width="135" class='label'>&nbsp;<strong>Master Barang </strong></td>
                                <td width="500" class="content">&nbsp;Menampikan daftar kodefikasi barang dalam bentuk tabular <br />
                                    &nbsp;<font color="#666666">(contoh : 01.00.00.00.00 - Golongan Tanah )</font>
                                </td>
                            </tr>
                            <tr>
                                <td class='label'>&nbsp;<strong>Master Barang (tree) </strong></td>
                                <td class="content">&nbsp;Menampilkan daftar kodefikasi barang dalam bentuk tree </td>
                            </tr>
                            <tr>
                                <td class='label'>&nbsp;<strong>Unit Kerja </strong></td>
                                <td class="content">&nbsp;Menampilkan daftar unit / satuan kerja yang ada dalam bentuk tabular <br />
                                    &nbsp;<font color="#666666">(contoh : UGD, Farmasi, Lab, dsb) </font>
                                </td>
                            </tr>
                            <tr>
                                <td class='label'>&nbsp;<strong>Unit Kerja (tree) </strong></td>
                                <td class="content">&nbsp;Menampilkan daftar unit / satuan kerja dalam bentuk tree</td>
                            </tr>
                            <tr>
                                <td class='label'>&nbsp;<strong>Gedung</strong></td>
                                <td class="content">&nbsp;Data gedung / bangunan yang di dalamnya terdapat ruang-ruang penyimpanan barang. </td>
                            </tr>
                            <tr>
                                <td class='label'>&nbsp;<strong>Sumber Dana </strong></td>
                                <td class="content">&nbsp;Data Jenis Sumber Dana yang digunakan untuk pengadaan barang <br />
                                    &nbsp;<font color="#666666">(seperti : APBN, APBD, dsb) </font></td>
                            </tr>
                            <tr>
                                <td class='label'>&nbsp;<strong>Ruangan</strong></td>
                                <td class="content">&nbsp;Daftar Ruangan yang berfungsi sebagai lokasi barang.<br />
                                    &nbsp;<font color="#666666">(contoh : IT.01, Gudang.01, dsb.)</font>
                                </td>
                            </tr>
                            <tr>
                                <td class='label'>&nbsp;<strong>Rekanan</strong></td>
                                <td class="content">&nbsp;Data Rekanan/supplier sebagai penyedia barang.</td>
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