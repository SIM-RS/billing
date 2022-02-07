<?php
	include("../inc/koneksi.php");
	$act = $_REQUEST['act'];
      
      //$pars='txtParentId*txtParentKode*txtParentLvl*txtLevel';
	  //$pars='txtId*txtKode*txtNama*txtUrl*txtLevel*txtParentId*txtParentKode';
	  $pars='parent_id*kode*namax*urlx*kode_parent*status*simpan*level';//*namax*urlx*status
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
							  //$_SESSION['itemtree.filter'] = $_REQUEST["p"];
							  //$p = $_SESSION['itemtree.filter'];	
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
						  $strSQL = "select * from ms_menu where aktif=1 and modul_id='".substr($_REQUEST['modul'],0,1)."' order by kode";
						  $rs = mysql_query($strSQL);
						  while ($rows=mysql_fetch_array($rs)){
								 $c_level = $rows["level"] + 1;
								 $pkode=trim($rows['parent_kode']);
								 $mkode=trim($rows['kode']);
								 
								 $inap=($rows['inap']==1)?'true':'false';
								 $chkAktif=($rows['aktif']==1)?'true':'false';
								 //if ($pkode!=""){
                                  //	if (substr($mkode,0,strlen($pkode))==$pkode) 
                                             //$mkode=substr($mkode,strlen($pkode),strlen($mkode)-(strlen($pkode)));
                                       //else
                                       //	$mkode=substr($mkode,strlen($pkode),strlen($mkode)-(strlen($pkode)));
                                 // }
								 /*if ($pkode!=""){
								 //	if (substr($mkode,0,strlen($pkode))==$pkode) 
										$mkode=substr($mkode,strlen($pkode),strlen($mkode)-(strlen($pkode)));
									//else
									//	$mkode=substr($mkode,strlen($pkode),strlen($mkode)-(strlen($pkode)));
								 }*/
								 $sql="select * from ms_menu where id=".$rows['parent_id'];
								 $rs1=mysql_query($sql);
								 if ($rows1=mysql_fetch_array($rs1)) $c_mainduk=$rows1["nama"]; else $c_mainduk="";
								 $tree[$cnt][0]= $c_level;
								 $tree[$cnt][1]= $rows["kode"]." - ".($mpkode==""?"":$mpkode." - ").$rows["nama"];			
								 $arfvalue=$par[0]."*-*".$rows['parent_id']."*|*".$par[1]."*-*".$rows['kode']."*|*".$par[2]."*-*".$rows["nama"]."*|*".$par[3]."*-*".$rows['url']."*|*".$par[4]."*-*".$rows['parent_kode']."*|*".$par[5]."*-*"."1"."*|*".$par[6]."*-*"."Update"."*|*".$par[7]."*-*".$rows["level"];
								 if ($c_level>0)
									 $tree[$cnt][2]= "javascript:fSetValue(window,'".$arfvalue."');";
									 //$tree[$cnt][2]= null;
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
	//alert('asdsadsa');
	var a=p.split("*-*");
	//alert(a[0]+'act='+act+'&par='+par+'&gid='+document.getElementById(a[2]).value);
	Request ( a[0]+'act='+act+'&par='+par+a[3] , a[1], '', 'GET');
	//isiCombo('cmbGroup','','','cmbGroup');
}

function aksi(){
	//alert(document.getElementById('txtId').value);
	//document.getElementById('btnSimpanSetting').value='Update';
	document.getElementById('act').value='update';
	document.getElementById('btnHapusSetting').disabled=false;
	document.getElementById('btnSimpanSetting').innerHTML='<img src="../icon/save.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Update';
    document.getElementById('btnHapusSetting').innerHTML='<img src="../icon/delete.gif" align="absmiddle" width="20"  />&nbsp;&nbsp;Hapus';
}

function batalSetting(){
	document.getElementById('txtParentKode').value='';
	document.getElementById('txtKode').value='';
	document.getElementById('txtNama').value='';
	document.getElementById('txtUrl').value='';
	document.getElementById('btnSimpanSetting').value='Tambah';
	document.getElementById('act').value='tambah';
	document.getElementById('btnHapusSetting').disabled=true;
	document.getElementById('btnSimpanSetting').innerHTML='<img src="../icon/add.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Tambah';
    document.getElementById('btnHapusSetting').innerHTML='<img src="../icon/delete2.gif" align="absmiddle" width="20"  />&nbsp;&nbsp;Hapus';
}
</script>
</div>