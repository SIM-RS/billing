<?php
	include("../koneksi/konek.php");
	  $act = $_REQUEST['act'];    
      $pars=$_REQUEST['par'];
	  convert_var($act,$pars);
	  
      $par=explode("*",$pars);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css">
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" type="text/css" href="../theme/tab-view.css" />
<script type="text/javascript" src="../theme/js/tab-view.js"></script>
<script type="text/javascript" src="../theme/js/ajax.js"></script>
<title>Form Setting Pengguna</title>
</head>

<body>
<div id="divtreeview">
<table border=1 cellspacing=0 width=98%>
				<tr bgcolor="whitesmoke">
					<td>
						<?php	
						  // Detail Data Parameters
						  if (isset($_REQUEST["p"])) {
							  //$_SESSION['itemtree.filter'] = $_REQUEST["p"];
							  //$p = $_SESSION['itemtree.filter'];	
							  $p = $_REQUEST["p"];
						  }
						  else
						  {
							  if ($_SESSION['itemtree.filter'])
							  $p = $_SESSION['itemtree.filter'];
						  }
						  
						  $PATH_INFO ='http://'.$_SERVER['HTTP_HOST'].$base_addr.'/apotek/setting/settingaplikasi_treeview.php';
						
						  $canRead = true;
						  $include_del = 1;
						  $maxlevel=0;
						  $cnt=0;
						  $target='divtreeview';
						  $strSQL = "select * from a_menu order by mn_kode";
						  $rs = mysqli_query($konek,$strSQL);
						  while ($rows=mysqli_fetch_array($rs)){
								 $c_level = $rows["mn_level"] + 1;
								 //$pkode=trim($rows['parent_kode']);
								 $mkode=trim($rows['mn_kode']);
								 $kiri=explode(".",$rows['mn_kode']);
								 //$inap=($rows['inap']==1)?'true':'false';
								 //$chkAktif=($rows['aktif']==1)?'true':'false';
								 /*if ($pkode!=""){
								 //	if (substr($mkode,0,strlen($pkode))==$pkode) 
										$mkode=substr($mkode,strlen($pkode),strlen($mkode)-(strlen($pkode)));
									//else
									//	$mkode=substr($mkode,strlen($pkode),strlen($mkode)-(strlen($pkode)));
								 }*/
								 $sql="select * from a_menu where mn_kode like '".$kiri[0]."%'";
								 $rs1=mysqli_query($konek,$sql);
								 if ($rows1=mysqli_fetch_array($rs1)) $c_mainduk=$rows1["mn_menu"]; else $c_mainduk="";
								 $tree[$cnt][0]= $c_level;
								 $tree[$cnt][1]= $rows["mn_kode"]." - ".($mpkode==""?"":$mpkode." - ").$rows["mn_menu"];			
								 $arfvalue=$par[0]."*-*".$rows['id']."*|*".$par[1]."*-*".$mkode."*|*".$par[2]."*-*".$rows['mn_level']."*|*".$par[3]."*-*".($rows['mn_level']+1);
								 if ($c_level>0)
									 $tree[$cnt][2]= "javascript:fSetValue(window.opener,'".$arfvalue."');window.close();";
									 //$tree[$cnt][2]= null;
								 else
									 $tree[$cnt][2] = null;
						
								 $tree[$cnt][3]= "";
								 $tree[$cnt][4]= 0;
								 //$tree[$cnt][5]=($rows['islast']==1)?$rows['id']:0;
								 //$tree[$cnt][5]="act*-*delete*|*idma*-*".$rows['MA_ID']."*|*parent*-*".$rows['MA_PARENT'];
								 //$tree[$cnt][6]=$rows['aktif'];
								 $tree[$cnt][7]="act*-*hapus*|*txtId*-*".$rows['id'];
								 if ($tree[$cnt][0] > $maxlevel) 
									$maxlevel=$tree[$cnt][0];    
								 $cnt++;
							}
							mysqli_free_result($rs);
							
						$tree_img_path="../images";
						include("../theme/treemenu_ajax.inc.php");
						?>
					</td>
				</tr>
			</table>
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="5">&nbsp;</td>
	</tr>
</table>
<script>
function loadtree(p,act,par)
	{
		
		//alert(p);
		var a=p.split("*-*");
		//alert(a[0]+'act='+act+'&par='+par+'&gid='+document.getElementById(a[2]).value);
		Request ( a[0]+'act='+act+'&par='+par+a[3] , a[1], '', 'GET');
		//isiCombo('cmbGroup','','','cmbGroup');
	}
</script>
</div>
</body>