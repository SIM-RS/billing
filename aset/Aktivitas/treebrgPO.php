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
$cmb = $_GET['cmb'];
$no = $_REQUEST["i"];
$cek = explode("**",$_REQUEST["cek"]);
if($cmb==''){
		$cmb=1;	
	}
//echo $par[0];
?>
<html>
    <title>Tree Barang</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
    <link rel="stylesheet" href="../theme/mod.css" type="text/css" />
    
    <body style="border-width:0px;" bgcolor="#CCCCCC" topmargin="0" leftmargin="0" onLoad="javascript:if (window.focus) window.focus();" onBlur="window.close();">
        <div align="center">
            <table border=1 cellspacing=0 width="98%">
                <tr>
                    <td class=GreenBG align=center>
                        <font size=4><b>
                                .: Data Barang :.
                            </b></font>
                    </td>
                </tr>
                <tr>
                <td>
						<select id="cmbfilter" name="cmbfilter" onChange="window.location='treebrgPO.php?i=<?=$no;?>&cmb='+this.value+'&cek=<?=$_REQUEST["cek"];?>'">
													<option value="1" <?php if($cmb==1) echo "selected"; ?>>Inventaris</option>
													<option value="2" <?php if($cmb==2) echo "selected"; ?>>Pakai Habis</option>
													</select>                
                </td></tr>
                
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
                      $strSQL =  $sql="SELECT DISTINCT level,idbarang,kodebarang,namabarang,idsatuan,T2.jml_sisa,islast
		FROM as_ms_barang br LEFT JOIN 
		(SELECT * FROM (SELECT stok_id,barang_id,jml_sisa FROM as_kstok ORDER BY STOK_ID DESC) T1
		GROUP BY T1.barang_id) AS T2
		ON br.idbarang=T2.barang_id
		WHERE tipe=$cmb ORDER BY kodebarang";
                        $rs = mysql_query($strSQL);
                        while ($rows=mysql_fetch_array($rs)) {
                            $c_level = $rows["level"];
                            $mpkode=trim($rows['kodebarang']);
							$islast = $rows["islast"];
                            $tree[$cnt][0]= $c_level;
                            $arfvalue ="*|*".$rows['idbarang']."*|*".$rows['kodebarang']."*|*".$rows['namabarang']."*|*".$rows['idsatuan'];
							if($islast>0){
							for($d=0;$d<count($cek);$d++){
								if($rows['idbarang']==$cek[$d]){
								$cekbok="<input type='checkbox' id='chk' checked disabled name='chk' value='$arfvalue' onchange='ganti(this)'> ";
								break;
								}else{
								$cekbok="<input type='checkbox' id='chk' name='chk' value='$arfvalue' onchange='ganti(this)'> ";
								}
							}
								
                            $tree[$cnt][1]=$cekbok.($mpkode==""?"":$mpkode." - ").$rows["namabarang"];
							}else{
								$tree[$cnt][1]=($mpkode==""?"":$mpkode." - ").$rows["namabarang"];
							}
							
                            if ($islast>0)
                              // $tree[$cnt][2]= "javascript:window.opener.fSetObat('".$arfvalue."');";
                            //."*|*".$par[2]."*-*".$rows['level']."*|*".$par[3]."*-*".($rows['level']+1)
									//	$tree[$cnt][2]= "javascript:window.opener.document.getElementById('idunit').value = 1;alert(window.opener.document.getElementById('idunit').value);"; 
									 $arfvalue = $no."*|*".$rows['idbarang']."*|*".$rows['kodebarang']."*|*".$rows['namabarang']."*|*".$rows['idsatuan'];                           
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
			<table width="98%" cellpadding="0" cellspacing="0">
			<tr>
				<td><input type="button" id="ambil" onClick="jupuen()" value="Pilih Barang"></td>
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
		
		function jupuen(){
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
		
	/*	
		function jupuen(){
			var e = temp.split("||");
			//alert(temp);
			var baris = parseInt('<?=$_REQUEST['i'];?>');
			var t=0;
			for(var x=0;x<lupingan;x++){
				
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
				for(var x=0;x<lupingan;x++){
				
					if(x>0){
					t = baris+x;
					//alert(t+" - "+window.opener.document.form1.idbarang[2]);
					window.opener.fSetObat(t+e[x]);
					}
					
				}
				
			
			window.close();
			/*var nyeplit=temp.split("||");
			//alert(temp)
			var row=parseInt('<?=$_REQUEST['i'];?>');
			var w=0;
			for(var o=0; o<lupingan; o++){
				if(o>0){
					window.opener.addRowToTable();
				}else{
					w = row+o;
					window.opener.fSetObat(w+nyeplit[o]);
					
				}
                 //alert(row)
			}
			 var row=parseInt('<?=$_REQUEST['i'];?>');
			 w = 0;
			 for(var o=0;o<lupingan;o++){
				
					if(o>0){
					w = row+o;
					//alert(w+nyeplit[o]);
					window.opener.fSetObat(w+nyeplit[o]);
					}
					
				} 
			window.close();
		}
		
		var temp='';
		var lupingan=0;
		function pilih(a){
		  //alert(lupingan)
		if(a.checked){
			if(lupingan==0){
			temp = a.value;
			}else{
			temp +='||'+a.value;
			}
			lupingan++;
			}else{
			var nyeplit = temp.split("||");
			var dtemp='';
			for(var f=0;f<nyeplit.length;f++){
				if(nyeplit[f]!=a.value){
					if(f==0){
					dtemp = nyeplit[f];
					}else{
					dtemp +='||'+nyeplit[f];
					}
				}
			}
			temp=dtemp;
			lupingan--;
			}
		}
		*/
    </script>
</html>
<?php
mysql_close($konek);
?>