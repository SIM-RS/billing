<?php
session_start();
include("../inc/koneksi.php");
//if (isset($_SESSION["PATH_MS_MA"]))
//	$PATH_INFO=$_SESSION["PATH_MS_MA"];
//else{
$PATH_INFO="?".$_SERVER['QUERY_STRING'];
$_SESSION["PATH_MS_MA"]=$PATH_INFO;
//}
$par=$_REQUEST['par'];

$par=explode("*",$par);
//echo $par[0];
?>
<html>
    <title>Tree Unit</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
    <link rel="stylesheet" href="../theme/mod.css" type="text/css" />
    <style type="text/javascript">
        BODY, TD {font-family:"Verdana"; font-size:7pt}
        .NormalBG
        {
            background-color : #FFFFFF;
        }

        .AlternateBG {
            background-color : #FFFFFF;
        }

    </style>
    <body style="border-width:0px;" bgcolor="#CCCCCC" topmargin="0" leftmargin="0" onLoad="javascript:if (window.focus) window.focus();" onBlur="window.close();">
        <div align="center">
            <table border=1 cellspacing=0 width="98%">
                <tr>
                    <td class=GreenBG align=center>
                        <font size=1><b>
                                .: Data Biaya :.
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
                        //$strSQL = "select * from dbaset.as_ms_unit order by kodeunit";
						//$strSQL = "SELECT MA_ID,MA_KODE,MA_NAMA FROM akuntansi.ma_sak WHERE ma_aktif=1 AND MA_KODE LIKE '5%' ORDER BY MA_KODE"; //echo $strSQL;
						$strSQL="SELECT MA_ID,MA_KODE,MA_NAMA, MA_LEVEL, MA_ISLAST FROM akuntansi.ma_sak 
WHERE ma_aktif=1 AND MA_KODE LIKE '5%' 
ORDER BY MA_KODE";
                        $rs = mysql_query($strSQL);
                        while ($rows=mysql_fetch_array($rs)) {
							$c_level = $rows["MA_LEVEL"];
                            $mpkode=trim($rows['MA_KODE']);
									 $islast = $rows["MA_ISLAST"];
                            $tree[$cnt][0]= $c_level;
                            $tree[$cnt][1]= ($mpkode==""?"":$mpkode." - ").$rows["MA_NAMA"];
                            if ($islast==1)
                               /*$tree[$cnt][2]= "javascript:fSetValue(window.opener,'".$par[0]."*-*".$rows['idunit']."*|*".$par[1]."*-*".$rows['kodeunit']."*|*".$par[2]."*-*".$rows['namaunit']."*|*".$par[3]."*-*".''."*|*".$par[4]."*-*".''."');window.close();";*/
							   
							     $tree[$cnt][2]= "javascript:window.opener.set_tree('$rows[MA_KODE]','$rows[MA_NAMA]');window.close();";
							   
                            //."*|*".$par[2]."*-*".$rows['level']."*|*".$par[3]."*-*".($rows['level']+1)
									//	$tree[$cnt][2]= "javascript:window.opener.document.getElementById('idunit').value = 1;alert(window.opener.document.getElementById('idunit').value);";                            
                            else
                                $tree[$cnt][2] = null;

                            $tree[$cnt][3]= "";
                            $tree[$cnt][4]= 0;
                            if ($tree[$cnt][0] > $maxlevel)
                                $maxlevel=$tree[$cnt][0];
                            $cnt++;
							
                                /*$mpkode=trim($rows['MA_KODE']);
                                $level = $rows['MA_KODE'];
                                $lvl = count($level);
                                $tree[$cnt][0]= $lvl;
                               // $islast = $rows["islast"];
                 
                                $tree[$cnt][1]= $rows["MA_KODE"]." - ".$rows["MA_NAMA"];
								$allval = $rows['MA_ID']."*|*".$rows['MA_KODE']."*|*".$rows['MA_NAMA'];
                                 

                                $tree[$cnt][3]= "";
                                $tree[$cnt][4]= 0;
                                if ($tree[$cnt][0] > $maxlevel)
                                    $maxlevel=$tree[$cnt][0];
									$cnt++;          */                      			
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
