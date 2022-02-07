<?php
include("../../sesi.php");
include("../../koneksi/konek.php");
// include

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Tarif Tindakan Kso</title>
    <link type="text/css" rel="stylesheet" href="../../theme/mod.css">
    <script language="JavaScript" src="../../theme/js/dsgrid.js"></script>
    <script language="JavaScript" src="../../theme/js/mod.js"></script>
    <link rel="stylesheet" type="text/css" href="../../theme/tab-view.css" />
    <script type="text/javascript" src="../../theme/js/tab-view.js"></script>
    <script type="text/javascript" src="../../theme/js/ajax.js"></script>

    <!--dibawah ini diperlukan untuk menampilkan popup-->
    <link rel="stylesheet" type="text/css" href="../../theme/popup.css" />
    <script type="text/javascript" src="../../theme/prototype.js"></script>
    <script type="text/javascript" src="../../theme/effects.js"></script>
    <script type="text/javascript" src="../../theme/popup.js"></script>
</head>

<body>
    <div align="center">
        <?php include("../../header1.php"); ?>
        <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
            <tr>
                <td height="30">&nbsp;UPDATE TARIF KSO EXCEL</td>
            </tr>
        </table>
        <table width="1000" border="0" cellspacing="0" cellpadding="0" align="center" class="tabel">
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td align="center">
                    <form method="post" enctype="multipart/form-data" action="utils_krakatau.php">
                        <table>
                            <tr>
                                <td>Pilih Excel</td>
                                <td>
                                    <input type="file" name="tindakanTarif" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <button type="submit">Update</button>
                                </td>
                            </tr>
                        </table>
                        
                    </form>
                    <div style="height: 500px;"></div>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>
    </div>
</body>

</html>