<?php
session_start();
include("../koneksi/konek.php");
$PATH_INFO="?".$_SERVER['QUERY_STRING'];
$_SESSION["PATH_MS_MA"]=$PATH_INFO;
//}
$par="idbarang*kodebarang*namabarang";

$par=explode("*",$par);
if($_REQUEST['tipe']=='')
{
$tipe='1';
}
else{
$tipe=$_REQUEST['tipe'];
}
?>
<html>
    <title>Tree Barang</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
    <link rel="stylesheet" href="../theme/mod.css" type="text/css" />
   
    <body style="border-width:0px;" bgcolor="#CCCCCC" topmargin="0" leftmargin="0" onLoad="javascript:if (window.focus){ window.focus();}" onBlur="window.close();">
        <div align="center">
            <table border=1 cellspacing=0 width="98%">
                <tr>
                    <td class=GreenBG align=center>
                        <font size=1><b>
                                .: Data Barang :.
                            </b></font>                    </td>
                </tr>
                <tr bgcolor="whitesmoke"><input type="hidden" name="idbarang" id="idbarang" />
                  <td nowrap><form id="formTipe" name="formTipe" action="" method="get">
                  <p>Kategori Barang : <span style="padding-left: 15px">
                    <select id="tipe" name="tipe" class="txt" onChange="submit();">
                      <option value="1" <?php if($tipe=='1') echo "selected";?>>Aset Tetap</option>
                      <option value="2" <?php if($tipe=='2') echo "selected";?>>Aset Lancar</option>
                    </select>                    
                  </span>
                  </form>
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

                        $canRead = true;
                        $maxlevel=0;
                        $cnt=0;
                        
                            $strSQL = "select idbarang,kodebarang,namabarang,level,islast from as_ms_barang where tipe = ".$tipe." order by kodebarang";
                            $rs = mysql_query($strSQL);
                            while ($rows=mysql_fetch_array($rs)) {
                                $c_level = $rows["level"];
                                $mpkode=trim($rows['kodebarang']);
                                $tree[$cnt][0]= $c_level;
                                $islast = $rows["islast"];
                                $tree[$cnt][1]=($mpkode==""?"":$mpkode." - ").$rows["namabarang"];
                                if ($islast==1)
                                    $tree[$cnt][2]= "javascript:fSetValue(window.opener,'".$par[0]."*-*".$rows['idbarang']."*|*".$par[1]."*-*".$rows['kodebarang']."*|*".$par[2]."*-*".$rows['namabarang']."');window.close();";
                                
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

                        ?>                    </td>
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
		function tipe(nilai){
			
			var alamat=window.location;
			alamat=alamat.replace("&tipe=1","");
			alamat=alamat.replace("&tipe=2","");
			//alert(alamat);
			
			alamat+="&tipe="+nilai;
			window.location=alamat;
		}        
    </script>
</html>
<?php
mysql_close($konek);
?>