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
$billing_id = $_REQUEST['billing_id'];
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
                           $strSQL = "select * from $rspelindo_db_billing.b_ms_unit order by kode"; //echo $strSQL;
                            $rs = mysql_query($strSQL);
                            while ($rows=mysql_fetch_array($rs)) {
                                /*$mpkode=trim($rows['kode']);
                                $level = explode('.',$rows['kode']); //echo $level[1];
                                $lvl = count($level);*/
								$lvl = $rows['level'];
                                $tree[$cnt][0]= $lvl;
                               // $islast = $rows["islast"];
							   
                 
                                $tree[$cnt][1]= $rows["kode"]." - ".$rows["nama"]; //echo $tree[$cnt][1];
								$allval = $rows['id']."*|*".$rows['kode']."*|*".$rows['nama']; //echo $allval;
                               if ($lvl>0)
							   {
							   		/*$set = $par[0]."*-*".$rows['id']."*|*".$par[1]."*-*".$rows['kode']; //echo $set;
							   		//$tree[$cnt][2]= "javascript:fSetValue(window.opener,'$set')";
							   		$level_anak = $lvl+1;
									$kode_parent = $rows['kode'];
									$billing_level = $rows['level'];*/
									if($act=='add')
									{
										//$tree[$cnt][2]= "javascript:fSetValue(window.opener,'".$par[0]."*-*".$rows['id']."*|*".$par[1]."*-*".$rows['kode']."*|*".$par[2]."*-*".$rows['nama']."');window.opener.get_id_billing();window.close();";
									}
									if($act=='edit' && $billing_id==0)
									{
										//$tree[$cnt][2]= "javascript:fSetValue(window.opener,'".$par[0]."*-*".$rows['id']."*|*".$par[1]."*-*".$rows['kode']."*|*".$par[2]."*-*".$rows['nama']."');window.opener.get_id_billing();window.close();";
									}
									else
									{
										//$tree[$cnt][2]= "javascript:fSetValue(window.opener,'".$par[0]."*-*".$rows['id']."*|*".$par[1]."*-*".$rows['kode']."*|*".$par[2]."*-*".$rows['nama']."');window.close();";
									
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
                        
                         

                            

                        ?>
                    </td>
                </tr>
            </table>
			<?
			$q = "select kode from $rspelindo_db_billing.b_ms_unit where level=1 order by kode desc limit 1";
			$s = mysql_query($q);
			$d = mysql_fetch_array($s);
			$get_kode = $d['kode']+1;
			$new_kode = sprintf('%02d', $get_kode);
			?>
			<!--<button type="button" onClick="set_parent('<?=$new_kode;?>');">Top Parent</button>-->
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
		
		function set_parent(a)
		{
			//alert(a);
			window.close();
			window.opener.document.form1.billing_parent_id.value = a;
		}
    </script>
</html>
