<?php
session_start();
include("../inc/koneksi.php");
//if (isset($_SESSION["PATH_MS_MA"]))
//	$PATH_INFO=$_SESSION["PATH_MS_MA"];
//else{
$PATH_INFO="?".$_SERVER['QUERY_STRING'];
$_SESSION["PATH_MS_MA"]=$PATH_INFO;
//}
$modul_id=$_REQUEST['modul_id'];
$par=$_REQUEST['par'];
$r = $par;
$par=explode("*",$par);
$cmb = $_GET['cmb'];
$no = $_REQUEST["no"];
if($cmb==''){
		$cmb=1;	
	}
//echo $par[0];
?>
<html>
    <title>Tree Program</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <script type="text/javascript" language="JavaScript" src="../../sdm/theme/js/mod.js"></script>
    <link rel="stylesheet" href="../../sdm/theme/mod.css" type="text/css" />
    
    <body style="border-width:0px;" bgcolor="#CCCCCC" topmargin="0" leftmargin="0" onLoad="javascript:if (window.focus) window.focus();" onBlur="window.close();">
        <div align="center">
            <table border=1 cellspacing=0 width="98%">
                <tr>
                    <td class=GreenBG align=center>
                        <font size=4><b>
                                .: Data Menu :.
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
						
                      $strSQL =  $sql="select * from ms_menu where aktif='1' and modul_id='$modul_id' order by kode";
					 // echo $strSQL;
                        $rs = mysql_query($strSQL);
                        while ($rows=mysql_fetch_array($rs)) {
                            $c_level = explode('.',$rows['kode']);
                            $c_level = count($c_level);
                            $mpkode=trim($rows['kode']);
							//$islast = $rows["islast"];
                            $tree[$cnt][0]= $c_level;
                            $tree[$cnt][1]= ($mpkode==""?"":$mpkode." - ").$rows["nama"];
							
							$sq="select kode from ms_menu where parent_id='".$rows['id']."' and aktif='1' and modul_id='$modul_id' order by kode desc limit 1 ";
							//echo $sq;
							$query=mysql_query($sq);
							$bnyk=mysql_fetch_array($query);
							$ex=explode(".",$bnyk[0]);
							$min=count($ex)-1;
							
							$tr = ".".str_pad(($ex[$min]+1),1,0,STR_PAD_LEFT);
							
                        //$arfvalue = $par[0]."*-*".$rows['nama']."*|*".$par[1]."*-*".$rows['kode']."*|*".$par[2]."*-*".$rows['kode'].$tr."*|*".$par[4]."*-*
//						".$rows['id']."*|*".$par[3]."*-*".$rows['level'];
						
						$q = mysql_query("SELECT kode FROM ms_menu WHERE parent_id='".$rows['id']."' ORDER BY kode DESC LIMIT 0,1");
						$abc = mysql_fetch_array($q);
						$xx = explode(".",$abc);
						$j = count($xx)-1;
						$last_kode = $abc;
						
						$arfvalue = $par[0]."*-*".$rows['kode']."*|*".$par[1]."*-*".$rows['id']."*|*".$par[2]."*-*".($rows['level']+1)."*|*".$par[3]."*-*".$xx[1];
						
                            //if ($rows['islast']<1)
                               $tree[$cnt][2]= "javascript:fSetValue(window.opener,'".$arfvalue."');window.close();";
                         

                            $tree[$cnt][3]= "";
                            $tree[$cnt][4]= 0;
                            if ($tree[$cnt][0] > $maxlevel)
                                $maxlevel=$tree[$cnt][0];
                            $cnt++;
                        }
                        mysql_free_result($rs);

                        $tree_img_path="../images";
                        include("../../sdm/theme/treemenu_menu.php");

                        ?>
                    </td>
                </tr>
				<?php 
				$sq="select kode from ms_menu where parent_id='".$rows['parent_id']."' and aktif='1' and modul_id='$modul_id' order by kode desc limit 1";
				$tt=mysql_query($sq);
				$oiu=mysql_fetch_array($tt);
				$dta=explode(".",$oiu[0]);
				$gg=str_pad(($dta[count($dta)-1]+1),1,0,STR_PAD_LEFT);
				//$gg=0;		
               ?>
                <tr><td align="center"><input type="button" value="Top Parent" onClick="<?php echo "javascript:fSetValue(window.opener,'".$par[2]."*-*".$rows['kode'].$gg."*|*".$par[1]."*-*0*|*".$par[3]."*-*0*|*".$par[4]."*-*0');"?>window.close();window.opener.belur()" /></td></tr>
            </table>
        </div>
    </body>
</html>
<?php
//mysql_close($konek);
?>