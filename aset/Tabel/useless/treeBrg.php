<?php
include("../koneksi/konek.php");
?>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <title>Kode Barang Tree</title>
    </head>

    <body>
        <div align="center">
            <?php
            include("../header.php");
            ?>
            <table width="550" border="1" cellspacing="0" cellpadding="2" align="center">
                <tr>
                    <td align="center" height="30">.: Data Kode Barang :.</td>
                </tr>
                <tr bgcolor="whitesmoke">
                    <td>
                        <?php
                        // Include Section
//include("dbconn.inc.php");
                        include("function.inc.php");

                        if (isset($_REQUEST["p"])) {
                            $_SESSION['itemtree.filter'] = $_REQUEST["p"];
                        }
                        else {
                            if ($_SESSION['itemtree.filter'])
                                $p = $_SESSION['itemtree.filter'];
                        }

                        $canRead = true;
                        $maxlevel=5;
                        $cnt=0;
                        $strSQL = "select idbarang, kodebarang, namabarang, tipebarang, level, mru, statuskode from as_ms_barang order by idbarang";
                        $rs = mysql_query($strSQL);
                        while ($rows = mysql_fetch_array($rs)) {
                            $c_idbarang = $rs->fields["kodebarang"] . " - " . $rs->fields["namabarang"];
                            $c_namabarang = $rs->fields["namabarang"];
                            $c_level = $rs->fields["level"];
                            $tree[$cnt][0]= $c_level;
                            $tree[$cnt][1]= $c_idbarang;
                            $tree[$cnt][2]= "detailBrg.php" . $rs->fields["idbarang"] . "&origin=tree";
                            $tree[$cnt][3]= "main";
                            $tree[$cnt][4]= 0;
                            //	 if ($tree[$cnt][0] > $maxlevel)
                            //		$maxlevel=$tree[$cnt][0];
                            $cnt++;
                            $rs->MoveNext();
                        }

                        include("../theme/treemenu.inc.php");

                        ?>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>
