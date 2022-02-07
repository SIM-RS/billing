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
    <title>Tree Lokasi</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
    <link rel="stylesheet" href="../theme/mod.css" type="text/css" />
    
    <body style="border-width:0px;" bgcolor="#CCCCCC" topmargin="0" leftmargin="0" onLoad="javascript:if (window.focus) window.focus();">
        <div align="center">
            <table border=1 cellspacing=0 width="98%">
                <tr>
                    <td class=GreenBG align=center>
                        <font size=1><b>
                                .: Data Lokasi :.
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
									$cnt=0;
                           $strSQL = "select * from as_lokasi order by kodelokasi";
                            $rs = mysql_query($strSQL);
                            while ($rows=mysql_fetch_array($rs)) {
                                $mpkode=trim($rows['kodelokasi']);
                                $level = explode('.',$rows['kodelokasi']);
                                $lvl = count($level);
                                $tree[$cnt][0]= $lvl;
                                $islast = $rows["islast"];
                 
                                $tree[$cnt][1]= $rows["kodelokasi"]." - ".$rows["namalokasi"];
											                              
                                if ($lvl > 0)
                                    $tree[$cnt][2]= "javascript:fSetValue(window.opener,'".$par[0]."*-*".$rows['idlokasi']."*|*".$par[1]."*-*".$rows['kodelokasi']."*|*".$par[2]."*-*".$rows['namalokasi']."');window.close();";
                               
                                else
                                    $tree[$cnt][2] = null;

                                $tree[$cnt][3]= "";
                                $tree[$cnt][4]= 0;
                                if ($tree[$cnt][0] > $maxlevel)
                                    $maxlevel=$tree[$cnt][0];
												$cnt++;                                			
                            }
                     
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