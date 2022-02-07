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
$par1=$_REQUEST['par'];
$i = $_REQUEST['i'];
$par=explode("*",$par);
$filter = $_REQUEST['cmb'];
$cmb = $_GET['cmb'];
$cek = explode("**",$_REQUEST["cek"]);
 $i = $_REQUEST["i"];
if($cmb==''){
		$cmb=1;	
		$filter=1;
	}
//echo $par[0];
?>
<html>
    <title>Tree Unit</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
    <link rel="stylesheet" href="../theme/mod.css" type="text/css" />
    
    <body style="border-width:0px;" bgcolor="#CCCCCC" topmargin="0" leftmargin="0" onLoad="javascript:if (window.focus) window.focus();" onBlur="window.close();">
        <div align="center">
            <table border=1 cellspacing=0 width="98%">
                <tr>
                    <td class=GreenBG align=center>
                        <font size=1><b>
                                .: Data Unit :.
                            </b></font>
                    </td>
                </tr>
                <tr>
                <td>	<select id="cmbfilter" name="cmbfilter" onChange="window.location='tree_barangBON.php?par=<?=$par1;?>&i=<?=$i;?>&cmb='+this.value+'&cek=<?=$_REQUEST["cek"];?>'">
													<option value="1" <?php if($cmb==1) echo "selected"; ?>>Inventaris</option>
													<option value="2" <?php if($cmb==2) echo "selected"; ?>>Pakai Habis</option>
													</select>                
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
                        $stok=0;
                        $strSQL = "SELECT idbarang,kodebarang,namabarang,idsatuan,level,islast,ifnull(sisa,0) as sisa FROM as_ms_barang left join (SELECT barang_id,SUM(sisa) AS sisa FROM as_masuk WHERE sisa>0 GROUP BY barang_id) t1 on t1.barang_id=idbarang WHERE tipe='$filter' order by kodebarang";
						//$strSQL = "SELECT a.*,b.* FROM as_ms_barang a left join as_kstok b on a.idbarang=b.barang_id WHERE a.tipe='$filter' GROUP BY a.kodebarang ORDER BY a.kodebarang";
                        $rs = mysql_query($strSQL);
                        while ($rows=mysql_fetch_array($rs)) {
							$stok=$rows['sisa'];
							/*$sql12="SELECT jml_sisa FROM as_kstok  WHERE barang_id='".$rows['idbarang']."' ORDER BY stok_id DESC limit 1";
																		$rs12=mysql_query($sql12);
																		$rows12=mysql_fetch_array($rs12);
																		$stok=$rows12['jml_sisa'];
																		if($stok=='') $stok = 0;*/
                            $c_level = $rows["level"];
                            $mpkode=trim($rows['kodebarang']);
							$islast = $rows["islast"];
                            $tree[$cnt][0]= $c_level;
							$arfvalue ="*|*".$rows['idbarang']."*|*".$rows['kodebarang']."*|*".$rows['namabarang']."*|*".$rows['idsatuan']."*|*".$stok;
                            if ($islast>0) 
							{
							//echo count($cek);
							for($d=0;$d<count($cek);$d++){
								if($rows['idbarang']==$cek[$d]){
								$input="<input type='checkbox' id='chk' checked disabled name='chk' value='$arfvalue' onchange='ganti(this)'> ";
								break;
								}else{
								$input="<input type='checkbox' id='chk' name='chk' value='$arfvalue' onchange='ganti(this)'> ";
								}
							}
							$tree[$cnt][1]= $input.($mpkode==""?"":$mpkode." - ").$rows["namabarang"].'('.$rows["idsatuan"].')';
							}
							else
							{
							$tree[$cnt][1]= ($mpkode==""?"":$mpkode." - ").$rows["namabarang"];
							}			
										 
                           
                            if ($islast>0){
                            /*	$sql12="SELECT jml_sisa FROM as_kstok  WHERE barang_id='".$rows['idbarang']."' ORDER BY stok_id DESC limit 1";
																		$rs12=mysql_query($sql12);
																		$rows12=mysql_fetch_array($rs12);
																		$stok=$rows12['jml_sisa'];
										*/								//$stok = $rows["stok"];
									 $arfvalue = $i."*|*".$rows['idbarang']."*|*".$rows['kodebarang']."*|*".$rows['namabarang']."*|*".$rows['idsatuan']."*|*".$stok;
                           
								 //  $tree[$cnt][2]= "javascript:window.opener.fSetObat('".$arfvalue."');window.close();";
                            }
                            //."*|*".$par[2]."*-*".$rows['level']."*|*".$par[3]."*-*".($rows['level']+1)
									//	$tree[$cnt][2]= "javascript:window.opener.document.getElementById('idunit').value = 1;alert(window.opener.document.getElementById('idunit').value);";                            
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
				<tr>
				<td align="center"><input type="button" value=" pilih barang " onClick="pilih()" /></td></tr>
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
		function pilih(){
			var e = temp.split("||");
			//alert(temp);
			var baris = parseInt('<?=$_REQUEST['i'];?>');
			var t=0;
			for(var x=0;x<lop;x++){
				
					if(x>0){
					
					window.opener.addRowToTable();
					}else{
					t = baris+x;
					window.opener.fSetObat(t+e[x]);
					}
					//alert(baris);
					
				}
				var baris = parseInt('<?=$_REQUEST['i'];?>');
				t = 0;
				for(var x=0;x<lop;x++){
				
					if(x>0){
					t = baris+x;
					//alert(t+" - "+window.opener.document.form1.idbarang[2]);
					window.opener.fSetObat(t+e[x]);
					}
					
				}
				
			
			window.close();
		}
		var temp='';
		var lop=0;
		function ganti(a){
		if(a.checked){
			//alert(lop);
			if(lop==0){
			temp = a.value;
			}else{
			temp +='||'+a.value;
			}
			lop++;
			}else{
			var e = temp.split("||");
			var dtemp='';
			for(var f=0;f<e.length;f++){
				if(e[f]!=a.value){
					if(f==0){
					dtemp = e[f];
					}else{
					dtemp +='||'+e[f];
					}
				}
			}
			temp=dtemp;
			lop--;
			}
		}
    </script>
</html>
<?php
mysql_close($konek);
?>