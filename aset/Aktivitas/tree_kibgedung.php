<?php
include '../sesi.php';
include("../koneksi/konek.php");
//if (isset($_SESSION["PATH_MS_MA"]))
//	$PATH_INFO=$_SESSION["PATH_MS_MA"];
//else{
$PATH_INFO="?".$_SERVER['QUERY_STRING'];
$_SESSION["PATH_MS_MA"]=$PATH_INFO;
//}
$par=$_REQUEST['par'];
$par=explode("*",$par);

?>
<html>
    <title>Tree Barang</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
    <link rel="stylesheet" href="../theme/mod.css" type="text/css" />
    <style type="text/javascript">
        BODY, TD {font-family:Verdana; font-size:7pt}
        .NormalBG
        {
            background-color : #FFFFFF;
        }

        .AlternateBG {
            background-color : #FFFFFF;
        }

    </style>
    <body style="border-width:0px;" bgcolor="#CCCCCC" topmargin="0" leftmargin="0" onLoad="javascript:if (window.focus) window.focus();">
        <div align="center">
            <table border=1 cellspacing=0 width="98%">
                <tr>
                    <td class=GreenBG align=center>
                        <font size=1><b>
                                .: Data Barang :.
                            </b></font>
                    </td>
                </tr>
                <tr bgcolor="whitesmoke">
                    <td nowrap>
                        <?php
                        // Detail Data Parameters
                        if (isset($_REQUEST["p"])) {
                            $_SESSION['itemtree.filter'] = $_REQUEST["p"];
                            $p = $_SESSION['itemtree.filter'];
                        }
                        else {
                            if ($_SESSION['itemtree.filter'])
                                $p = $_SESSION['itemtree.filter'];
                        }

                        /*********************************************/
                        /*  Read text file with tree structure       */
                        /*********************************************/

                        /*********************************************/
                        /* read file to $tree array                  */
                        /* tree[x][0] -> tree level                  */
                        /* tree[x][1] -> item text                   */
                        /* tree[x][2] -> item link                   */
                        /* tree[x][3] -> link target                 */
                        /* tree[x][4] -> last item in subtree        */
                        /*********************************************/
                        //$tree=array();
                        $canRead = true;
                        $maxlevel=0;
                        $cnt=0;
                        /*if(isset($_GET['idunit']) && $_GET['idunit'] != ''){
                            $strSQL = "select b.* from as_ms_barang b left join 
                                    (select * from as_transaksi t left join as_seri s on t.idtransaksi = s.idtransaksi 
                                    inner join as_kib k on k.idtransaksi = t.idtransaksi and b.
                                    where idunit = 6) t on b.idbarang = t.idbarang";
                            "select b.*
                                    from as_transaksi t right join as_ms_barang b on t.idbarang = b.idbarang
                                    left join as_seri s on t.idtransaksi = s.idtransaksi
                                    inner join as_kib k on t.idtransaksi = k.idtransaksi
                                    where idunit = '".$_GET['idunit']."'";
                            $rs = mysql_query($strSQL);
                            while ($rows=mysql_fetch_array($rs)) {
                                $c_level = $rows["level"];
                                $mpkode=trim($rows['kodebarang']);
                                $tree[$cnt][0]= $c_level;
                                $tree[$cnt][1]= $rows["kodebarang"]." - ".($mpkode==""?"":$mpkode." - ").$rows["namabarang"];
                                if ($c_level>0)
                                    $tree[$cnt][2]= "javascript:fSetValue(window.opener,'".$par[0]."*-*".$rows['idbarang']."*|*".$par[1]."*-*".$rows['kodebarang']."*|*".$par[2]."*-*".$rows['namabarang']."');window.close();";
                                //."*|*".$par[3]."*-*".($rows['level']+1)
                                else
                                    $tree[$cnt][2] = null;

                                $tree[$cnt][3]= "";
                                $tree[$cnt][4]= 0;
                                if ($tree[$cnt][0] > $maxlevel)
                                    $maxlevel=$tree[$cnt][0];
                                $cnt++;
                            }
                        }
                        else{*/
                            $strSQL = "select * from as_ms_barang where tipe = 1 and kodebarang like '03%' order by kodebarang";
                            $rs = mysql_query($strSQL);
                            while ($rows=mysql_fetch_array($rs)) {
                                $c_level = $rows["level"];
                                $mpkode=trim($rows['kodebarang']);
                                $tree[$cnt][0]= $c_level;
                                $tree[$cnt][1]= $rows["kodebarang"]." - ".($mpkode==""?"":$mpkode." - ").$rows["namabarang"];
                                if ($c_level>0)
                                    $tree[$cnt][2]= "javascript:fSetValue(window.opener,'".$par[0]."*-*".$rows['idbarang']."*|*".$par[1]."*-*".$rows['kodebarang']."*|*".$par[2]."*-*".$rows['namabarang']."');window.close();";
                                //."*|*".$par[3]."*-*".($rows['level']+1)
                                else
                                    $tree[$cnt][2] = null;

                                $tree[$cnt][3]= "";
                                $tree[$cnt][4]= 0;
                                if ($tree[$cnt][0] > $maxlevel)
                                    $maxlevel=$tree[$cnt][0];
                                $cnt++;
                            }
                        //}
                        mysql_free_result($rs);

                        $tree_img_path="../images";
                        include("../theme/treemenu.inc.php");

                        ?>
                    </td>
                </tr>
            </table>
        </div>
    </body>
    <script type="text/javascript" language="javascript">
        function goEdit(pid,pkode,pnama,plvl) {
            window.opener.document.form1.idbarang.value = pid;
            window.opener.document.form1.namabarang.value = pnamabarang;
            window.opener.document.form1.idbarang.value = pidbarang;
            window.opener.document.form1.namabarang.value = pnamabarang;
            window.close();
        }
    </script>
</html>
<?php
mysql_close($konek);
?>