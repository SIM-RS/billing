<?php
session_start();
include("../sesi.php");
?>
<?php 
//session_start();
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
    <title>Tree Kelompok Laboratorium</title>
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
                                .: Data Kelompok Laboratorium :.
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
						if($_REQUEST['tipe'] != 2) {
							$strSQL = "select * from b_ms_kelompok_lab order by kode";
							$plusLevel = 1;
						} else {
							$strSQL = "select id, kode, nama_kelompok, parent_id, (level-1) level, islast, aktif 
										from b_ms_kelompok_tindakan_pemeriksaan_lab where aktif = 1 order by kode";
							$plusLevel = 2;
						}
                        $rs = mysql_query($strSQL);
						// echo mysql_num_rows($rs);
                        while ($rows=mysql_fetch_array($rs)) {
                            $c_level = $rows["level"]+1;
                            $mpkode=trim($rows['kode']);
							/*
							$str = "select kode from b_ms_kelompok_lab where id=$rows[parent_id]";
							$d = mysql_query($str);
							$rd = mysql_fetch_array($d);
							*/
							//echo mysql_error();
							//$rds = "0".($rd['kode']+1);
							$kode = $rows['kode'];
                            $tree[$cnt][0]= $c_level;
                            $tree[$cnt][1]= ($mpkode==""?"":$mpkode." - ").$rows["nama_kelompok"];
                            if ($c_level>0)
                                $tree[$cnt][2]= "javascript:window.opener.setValue('".$rows['kode']."|".($rows['level']+$plusLevel)."|".$rows['id']."');window.close();";
                            else
                                $tree[$cnt][2] = null;

                            $tree[$cnt][3]= "";
                            $tree[$cnt][4]= 0;
                            if ($tree[$cnt][0] > $maxlevel)
                                $maxlevel=$tree[$cnt][0];
                            $cnt++;
                        }
						// print_r($tree);
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
        
    </script>
</html>
<?php 
mysql_close($konek);
?>