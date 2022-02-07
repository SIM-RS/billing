<?
include '../sesi.php';
?>
<?php
include("../koneksi/konek.php");
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='$def_loc';
                        </script>";
}
$type = $_SESSION["usertype"];
//if (isset($_SESSION["PATH_MS_MA"]))
//	$PATH_INFO=$_SESSION["PATH_MS_MA"];
//else{
$PATH_INFO="?".$_SERVER['QUERY_STRING'];
$_SESSION["PATH_MS_MA"]=$PATH_INFO;
//}
?>
<html>
    <title>Tree Unit</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
    <link rel="stylesheet" href="../theme/mod.css" type="text/css" />
    <link rel="stylesheet" href="../default.css" type="text/css" />
    
    <body style="border-width:0px;" bgcolor="#CCCCCC" onLoad="javascript:if (window.focus) window.focus();">
        <div align="center">
            <?php
            include '../header.php';
            ?>
            <table border=1 cellspacing=0 width="1000">
                <tr>
                    <td class=header align=center>
                        <font size=1><b>
                                .: Data Unit :.
                            </b></font>
                    </td>
                </tr>
                <tr bgcolor="whitesmoke">
                    <td style="padding: 10px">
                    <table width="100%">
<tr><td>&nbsp; </td><td align="right"><button value="Tambah data" onClick="location='detailUnit.php?origin=pindah&act=add'"
 style="visibility:<? if($type=="G") echo "hidden"; else echo "visible"; ?>"> Tambah Data <img alt="tambah" style="cursor: pointer" src="../images/tambah.png" />&nbsp;
                   </button></td></tr>
</table>
                       
                    </td>
                </tr>
                <form action="detailUnit.php" method="get" id="form1" name="form1">
                    <tr bgcolor="whitesmoke">
                        <td nowrap>
                            <input type="hidden" name="act" id="act" value="edit" />
                            <input type="hidden" name="idunit" id="idunit" />
                            <input type="hidden" name="origin" id="origin" value="treeUnit" />
                            <?php
                            // Detail Data Parameters
                            if (isset($_REQUEST["p"])) {
                                $_SESSION['itemtree.filter'] = $_REQUEST["p"];
                                $p = $_SESSION['itemtree.filter'];
                            }
                            else {
                                if (isset($_SESSION['itemtree.filter']))
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
                            $strSQL = "select * from as_ms_unit order by kodeunit";
                            $rs = mysql_query($strSQL);
                            while ($rows=mysql_fetch_array($rs)) {
                                $c_level = $rows["level"];
                                $mpkode=trim($rows['kodeunit']);
                                $tree[$cnt][0]= $c_level;
                                //$tree[$cnt][1]= $rows["kodeunit"]." - ".($mpkode==""?"":$mpkode." - ").$rows["namaunit"];
								$tree[$cnt][1]= ($mpkode==""?"":$mpkode." - ").$rows["namaunit"];
                                if ($c_level>0)
                                    $tree[$cnt][2]= "javascript:setValue36('idunit-|-'+".$rows['idunit'].");";
                                //"javascript:fSetValue(window.opener,'".$par[0]."*-*".$rows['idunit']."*|*".$par[1]."*-*".$rows['kodeunit']."*|*".$par[2]."*-*".$rows['namaunit']."*|*".$par[3]."*-*".''."*|*".$par[4]."*-*".''."');window.close();";

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
                </form>
				<tr>
					<td align="center" bgcolor="#FFFFFF">
						<button class="Enabledbutton" id="backbutton" onClick="location='unit.php'" title="Back" style="cursor:pointer">
								<img alt="back" src="../images/backsmall.gif" width="22" height="22" border="0" align="absmiddle" />
								Back to List
							</button></td>
				</tr>
                <tr>
                    <td class="footer">
                        <?php
                        include '../footer.php';
                        ?>
                    </td>
                </tr>
            </table>
        </div>
    </body>
    <script type="text/javascript" language="javascript">
        function setValue36(par){
            if(par != '' && par != null){
                var send = par.split('-|-');
                document.getElementById(send[0]).value = send[1];
                document.getElementById('form1').submit();
            }
        }
    </script>
</html>
<?php
mysql_close($konek);
?>