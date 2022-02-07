<?php
	include("../inc/koneksi.php");
	$act = $_REQUEST['act'];
      
      $pars=$_REQUEST['par'];
      $par=explode("*",$pars);
	  
	  $modul = $_REQUEST['modul'];
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
						  
						  $PATH_INFO ='http://'.$_SERVER['HTTP_HOST'].'/simrs-pelindo/admin/hakakses/settingaplikasi_treeview.php?modul='.$modul;
						
						  $canRead = true;
						  $include_del = 1;
						  $maxlevel=0;
						  $cnt=0;
						  $target='divtreeview';
						  
						  $cek = "select kode from ms_menu where modul_id=".substr($_REQUEST['modul'],0,1)." and aktif=1 and level=0 order by kode limit 1";
						  $kueri = mysql_query($cek);
						  $dat = mysql_fetch_array($kueri);
						  $digit =strlen($dat['kode']);;
						  
						  $strSQL = "select * from ms_menu where modul_id=".substr($_REQUEST['modul'],0,1)." and aktif=1 order by kode";
						  $rs = mysql_query($strSQL);
						  while ($rows=mysql_fetch_array($rs)){
								 $c_level = $rows["level"] + 1;
								 $pkode=trim($rows['parent_kode']);
								 $mkode=trim($rows['kode']);
								 
								 $inap=($rows['inap']==1)?'true':'false';
								 $chkAktif=($rows['aktif']==1)?'true':'false';
								
								 $tree[$cnt][0]= $c_level;
								 $tree[$cnt][1]= $rows["kode"]." - ".($mpkode==""?"":$mpkode." - ").$rows["nama"];	
								 
								 $skl="SELECT kode FROM ms_menu WHERE parent_id=$rows[0] and modul_id=".substr($_REQUEST['modul'],0,1)." ORDER BY kode DESC LIMIT 1";
								 $skl=mysql_query($skl);
								 $baris=mysql_num_rows($skl);
								 //if($baris==1){
									 $data3=mysql_fetch_array($skl);									 
									 $ex=explode(".",$data3[0]);
									 
									 if($digit==1){
									 	$kode = ".".($ex[count($ex)-1]+1);
									 }
									 else{ 
									 	$kode = ".".str_pad(($ex[count($ex)-1]+1),2,0,STR_PAD_LEFT);
									 }
									 //$kode++;
									// }
								// echo "$data3[0] <br>";
								//echo "$kode <br>";
								 $arfvalue=$par[0]."*-*".$rows['id']."*|*".$par[1]."*-*".$mkode."*|*".$par[2]."*-*".$rows['level']."*|*".$par[3]."*-*".($rows['level']+1)."*|*".$par[4]."*-*".$mkode.$kode."*|*".$par[5]."*-*".$rows['nama'];
								//echo "$arfvalue <br> ";
								// if ($c_level>0)
//									 $tree[$cnt][2]= "javascript:fSetValue(window.opener,'".$arfvalue."');window.close();";
//									 //$tree[$cnt][2]= null;
								if($c_level!==5)
								
								$tree[$cnt][2]= "javascript:fSetValue(window.opener,'".$arfvalue."');window.close();";
								
								 else
									 $tree[$cnt][2] = null;
						
								 $tree[$cnt][3]= "";
								 $tree[$cnt][4]= 0;
								 //$tree[$cnt][5]=($rows['islast']==1)?$rows['id']:0;
								 //$tree[$cnt][5]="act*-*delete*|*idma*-*".$rows['MA_ID']."*|*parent*-*".$rows['MA_PARENT'];
								 //$tree[$cnt][6]=$rows['aktif'];
								 $tree[$cnt][7]="act*-*hapus*|*txtId*-*".$rows['id']."*|*txtParentKode*-*".$rows['parent_kode']."*|*txtParentId*-*".$rows['parent_id'];
								 if ($tree[$cnt][0] > $maxlevel) 
									$maxlevel=$tree[$cnt][0];    
								 $cnt++;
							}
							mysql_free_result($rs);
							
						$tree_img_path="../images";
						include("../theme/treemenu_ajax.inc.php");
						?>					</td>
				</tr>
				<tr bgcolor="whitesmoke">
				<?
				$q = mysql_query("SELECT kode FROM ms_menu WHERE LEVEL='0' and modul_id=".substr($_REQUEST['modul'],0,1)." ORDER BY id DESC LIMIT 0,1");
				$r = mysql_fetch_array($q);
				$k = $r['kode']+1;
				if(strlen($k)==1)
				{		
				    if($digit==1){
						$k = $k;
					}
					else{
						$k = "0".$k;
					}
				}
				
				// txtParentId*txtParentKode*txtParentLvl*txtLevel*txtKode*txtParentNama&modul
				$top_parent = $par[0]."*-**|*".$par[1]."*-**|*".$par[2]."*-**|*".$par[3]."*-*0*|*".$par[4]."*-*".$k."*|*".$par[5]."*-*";
				?> 
				  <td align="center"><input type="button" style="cursor:pointer" value="Top Parent" onClick="<?php echo "javascript:fSetValue(window.opener,'".$top_parent."');"?>window.close();" /></td>
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