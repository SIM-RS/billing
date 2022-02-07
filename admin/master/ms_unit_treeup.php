<?php
session_start();
include '../inc/koneksi.php';
//if (isset($_SESSION["PATH_MS_MA"]))
//	$PATH_INFO=$_SESSION["PATH_MS_MA"];
//else{
$PATH_INFO="?".$_SERVER['QUERY_STRING'];
$_SESSION["PATH_MS_MA"]=$PATH_INFO;
//}
$par=$_REQUEST['par'];

$par=explode("*",$par);
$act = $_REQUEST['act'];
$kode_parent_awal = $_REQUEST['kode_parent_awal'];
$kode_unit_awal = $_REQUEST['kode_unit_awal'];
?>
<html>
    <title>Tree Unit</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
    <link rel="stylesheet" href="../theme/mod.css" type="text/css" />
    
    <body style="border-width:0px;" bgcolor="#CCCCCC" topmargin="0" leftmargin="0" onLoad="javascript:if (window.focus) window.focus();" >
        <div align="center">
            <table border=1 cellspacing=0 width="98%">
                <tr>
                    <td class=GreenBG align=center>
                        <font size=1><b>
                                .: Data Unit :.
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
                           $strSQL = "select * from ms_unit order by kodeunit";
                            $rs = mysql_query($strSQL);
                            while ($rows=mysql_fetch_array($rs)) {
                                $mpkode=trim($rows['kodeunit']);
                                $level = explode('.',$rows['kodeunit']);
                                $lvl = count($level);
                                $tree[$cnt][0]= $lvl;
                               // $islast = $rows["islast"];
                 
                                $tree[$cnt][1]= $rows["kodeunit"]." - ".$rows["namaunit"];
								$allval = $rows['idunit']."*|*".$rows['kodeunit']."*|*".$rows['namaunit'];
                               if ($lvl>0)
							   {
							   		$level_anak = $lvl+1;
									$kode_parent = $rows['kodeunit'];
									$billing_level = $rows['billing_level'];
									if($act=='add')
									{
										$tree[$cnt][2]= "javascript:fSetValue(window.opener,'".$par[0]."*-*".$rows['idunit']."*|*".$par[1]."*-*".$rows['kodeunit']."*|*".$par[2]."*-*".$rows['namaunit']."*|*".$par[3]."*-*".$level_anak."');window.opener.get_kode_anak('$act','$kode_parent',$level_anak);window.close();";
									}
									else
									{
										$tree[$cnt][2]= "javascript:fSetValue(window.opener,'".$par[0]."*-*".$rows['idunit']."*|*".$par[1]."*-*".$rows['kodeunit']."*|*".$par[2]."*-*".$rows['namaunit']."*|*".$par[3]."*-*".$level_anak."');window.opener.get_kode_anak('$act','$kode_parent',$level_anak);window.close();";
									
									}                              	
                             }
							 else
                                $tree[$cnt][2] = null;

                                $tree[$cnt][3]= "";
                                $tree[$cnt][4]= 0;
                                if ($tree[$cnt][0] > $maxlevel)
                                    $maxlevel=$tree[$cnt][0];
												$cnt++;                                			
                            }
                            mysql_free_result($rs);
							//$PATH_INFO=
                            $tree_img_path="../images";
                            include("../theme/treemenu.inc.php");
                        
                           /* if ($c_level>0){
                               if($act=='add'){
                               	$tree[$cnt][2]= "javascript:fSetValue(window.opener,'".$par[0]."*-*".$rows['idunit']."*|*".$par[1]."*-*".$rows['kodeunit']."*|*".$par[2]."*-*".$rows['namaunit']."*|*".$par[3]."*-*".($c_level+1)."*|*".$par[4]."*-*".$rows['kodeunit'].".');
                               window.close();window.opener.document.getElementById('kodeunit').focus();";
                              }else{
										$tree[$cnt][2]= "javascript:fSetValue(window.opener,'".$par[0]."*-*".$rows['idunit']."*|*".$par[1]."*-*".$rows['kodeunit']."*|*".$par[2]."*-*".$rows['namaunit']."*|*".$par[3]."*-*".($c_level+1)."');
                               window.close();";
                          
										}                              	
                             }else
                                $tree[$cnt][2] = null;*/

                            

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
