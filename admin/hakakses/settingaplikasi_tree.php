<style>
.betul{
	font-size:14px;
	color:#00FF00;
	font-family:Tahoma, Geneva, sans-serif;
}
.salah{
	font-size:14px;
	color:#FF0000;
	font-family:Tahoma, Geneva, sans-serif;
}
</style>
<?php
include("../inc/koneksi.php");

$act = $_REQUEST['act'];
$pars='txtId*txtKode*txtNama*txtUrl*txtLevel*txtParentId*txtParentKode*txtParentNama';
$par=explode("*",$pars);
  
$modul = $_REQUEST['modul'];
?>
<div id="divtreeview">
<table border=1 cellspacing=0 width=98% height="100%">
				<tr bgcolor="whitesmoke">
					<td>
						<?php	
						  // Detail Data Parameters
						  if (isset($_REQUEST["p"])) {
							  $p = $_REQUEST["p"];
						  }
						  else
						  {
							  if ($_SESSION['itemtree.filter'])
							  $p = $_SESSION['itemtree.filter'];
						  }
						  
						  $PATH_INFO ='http://'.$_SERVER['HTTP_HOST'].'/simrs-pelindo/admin/hakakses/settingaplikasi_tree.php?modul='.$modul;
						
						  $canRead = true;
						  $include_del = 1;
						  $maxlevel=0;
						  $cnt=0;
						  $target='divtreeview';
						  $strSQL = "select * from ms_menu where modul_id=$modul and aktif=1 order by kode";
						  $rs = mysql_query($strSQL);
						  while ($rows=mysql_fetch_array($rs)){
								 $c_level = $rows["level"] + 1;
								 $pkode=trim($rows['parent_kode']);
								 $mkode=trim($rows['kode']);
								 
								 $inap=($rows['inap']==1)?'true':'false';
								 $chkAktif=($rows['aktif']==1)?'true':'false';
								 if($rows['parent_id']==''){
								 	$parid = 0;
								 }
								 else{
								 	$parid = $rows['parent_id'];
								 }
								 $sql="select * from ms_menu where id=".$parid;
								 $rs1=mysql_query($sql);
								 if ($rows1=mysql_fetch_array($rs1)) $c_mainduk=$rows1["nama"]; else $c_mainduk="";
								 $tree[$cnt][0]= $c_level;
								 $tree[$cnt][1]= $rows["kode"]." - ".($mpkode==""?"":$mpkode." - ").$rows["nama"];			
								 $arfvalue=$par[0]."*-*".$rows['id']."*|*".$par[1]."*-*".$mkode."*|*".$par[2]."*-*".$rows['nama']."*|*".$par[3]."*-*".$rows['url']."*|*".$par[4]."*-*".($rows['level']+1)."*|*".$par[5]."*-*".$rows['parent_id']."*|*".$par[6]."*-*".$rows['parent_kode']."*|*".$par[7]."*-*".$c_mainduk;
								 if ($c_level>0)
									 $tree[$cnt][2]= "javascript:fSetValue(window,'".$arfvalue."');aksi();";
								 else
									 $tree[$cnt][2] = null;
						
								 $tree[$cnt][3]= "";
								 $tree[$cnt][4]= 0;
								 $tree[$cnt][7]="act*-*hapus*|*txtId*-*".$rows['id']."*|*txtParentKode*-*".$rows['parent_kode']."*|*txtParentId*-*".$rows['parent_id'];
								 if ($tree[$cnt][0] > $maxlevel) 
									$maxlevel=$tree[$cnt][0];    
								 $cnt++;
							}
							mysql_free_result($rs);
							
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

</script>
</div>