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
$par1=$_REQUEST['par'];
$r = $par;
$par=explode("*",$par1);
$cmb = $_GET['cmb'];
$no = $_REQUEST["no"];
if($cmb==''){
		$cmb=0;	
	}
//echo $par[0];
?>
<html>
    <title>Tree Program</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
    <link rel="stylesheet" href="../theme/mod.css" type="text/css" />
    
    <body style="border-width:0px;" bgcolor="#CCCCCC" topmargin="0" leftmargin="0" onLoad="javascript:if (window.focus) window.focus();" onBlur="window.close();">
        <div align="center">
            <table border=1 cellspacing=0 width="98%">
                <tr>
                    <td class=GreenBG align=center>
                        <font size=4><b>
                                .: Data Remunerasi :.
                            </b></font>
                    </td>
                </tr>
               
                
                <tr bgcolor="whitesmoke">
                    <td nowrap>
					<select id="cmb" name="cmb" onChange="ganti(this.value)">
					<option value="0" <? if($cmb==0) echo "selected"; ?>>Rumah Sakit</option>
					<option value="1" <? if($cmb==1) echo "selected"; ?>>Paviliun</option>
					</select>
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
                      $strSQL =  $sql="select * from dbpayroll.remunerasi_master where rmn_tipe='$cmb' order by rmn_kode";
					 // echo $strSQL;
                        $rs = mysql_query($strSQL);
                        while ($rows=mysql_fetch_array($rs)) {
                            $c_level = explode('.',$rows['rmn_kode']);
                            $c_level = count($c_level);
                            $mpkode=trim($rows['rmn_kode']);
							//$islast = $rows["islast"];
                            $tree[$cnt][0]= $c_level;
                            $tree[$cnt][1]= ($mpkode==""?"":$mpkode." - ").$rows["rmn_nama"]." (".$rows["rmn_persen"]."%)";
						
                        $arfvalue = $par[0]."*-*".$rows['rmn_id']."*|*".$par[1]."*-*".$rows['rmn_nama'];
                            if ($c_level>0)
                               $tree[$cnt][2]= "javascript:fSetValue(window.opener,'".$arfvalue."');window.close();window.opener.kirim()";
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
                <tr><td align="center"></td></tr>
            </table>
        </div>
    </body>
	<script>
	function ganti(a){
		location="?par=<?=$par1;?>&cmb="+a;
	}
	</script>
</html>
<?php
mysql_close($konek);
?>
