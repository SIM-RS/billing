<?php
	include("../koneksi/konek.php");
	$act = $_REQUEST['act'];
	$par = $_REQUEST['par'];
	$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
	
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
	//echo $p."<br>";
	$PATH_INFO ='http://'.$_SERVER['HTTP_HOST'].$base_addr.'/apotek/setting/settingaplikasi_tree.php';
	$target='divtab1';
	
	$susun=$PATH_INFO."?*-*".$target."*-*cmbGroup*-*&p=".$p."*-*".$_REQUEST['cnt']."#".$_REQUEST['cnt'];
	
$kode=$_REQUEST['parentKode'].$_REQUEST['kode'];
$ParentKode=trim($_REQUEST['parentKode']);
if($ParentKode==''){
	$parentId=0;
	$parentLevel=0;      
}
else{
	$parentId=$_REQUEST['parentId'];
	if($parentId=='') $parentId=0;
	$parentLevel=$_REQUEST['parentLvl'];
	if ($parentLevel=="") $parentLevel=0;      
	
}
$lvl=$_REQUEST['level'];

switch(strtolower($_REQUEST['act'])){
	case 'tambah':            
            
           
		mysqli_query($konek,"select * from a_menu where mn_kode='".$kode."'");
		if(mysqli_affected_rows($konek)>0){
			echo "Data Sudah Ada!";
		}
		else{
			$sqlTambah="insert into a_menu (mn_kode,mn_menu,mn_level,mn_url)
				values('".$kode."','".$_REQUEST['nama']."','".$_REQUEST['level']."','".$_REQUEST['url']."')";
			$rs=mysqli_query($konek,$sqlTambah);
                  //echo $sqlTambah."<br/>";
                  //echo mysqli_error($konek);
			if ($parentId>0){
				//$sql="update b_ms_menu set islast=0 where id=$parentId";
				//echo $sql;
				//$rs=mysqli_query($konek,$sql);
			}
			//echo "ok";
		}
		break;
	case 'hapus':
		$yes=mysqli_fetch_array(mysqli_query($konek,"select * from a_menu where id='".$_REQUEST['id']."'"));
		/*if(mysqli_affected_rows($konek)>0){
			echo "Data merupakan induk! ".$_REQUEST['id'];
		}
		else{
			$sql="delete from b_ms_menu where id='".$_REQUEST['id']."'";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
			
                  $sql1="select * from b_ms_menu where parent_id=".$parentId;
			//echo $sql1."<br>";
			$rs2=mysqli_query($konek,$sql1);
			if (mysqli_num_rows($rs2)<=0){
				$sql2="update b_ms_menu set islast=1 where id=".$parentId;
				//echo $sql2."<br>";
				$rs3=mysqli_query($konek,$sql2);
			}
                  
			//echo "ok";
		}*/	
		if($yes['mn_level']==0){
			echo "Data merupakan induk! ".$_REQUEST['id'];
		}
		else{
			$sql="delete from a_menu where id='".$_REQUEST['id']."'";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
			
                  /*$sql1="select * from a_menu where parent_id=".$parentId;
			//echo $sql1."<br>";
			$rs2=mysqli_query($konek,$sql1);
			if (mysqli_num_rows($rs2)<=0){
				$sql2="update b_ms_menu set islast=1 where id=".$parentId;
				//echo $sql2."<br>";
				$rs3=mysqli_query($konek,$sql2);
			}*/
                  
			//echo "ok";
		}	
		break;
	case 'simpan':           
		$sql="select * from a_menu where mn_kode='$kode' and mn_menu='".$_REQUEST['nama']."' and mn_level=$lvl and mn_url='".$_REQUEST['url']."'";
		//echo $sql."<br>";
		$rs1=mysqli_query($konek,$sql);
		if (mysqli_num_rows($rs1)>0){
			echo "Data Sudah Ada!";
		}else{
			$sql="select * from a_menu where id='".$_REQUEST['id']."'";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
			if ($rows=mysqli_fetch_array($rs)){
				//$cparent=$rows["parent_id"];
				$clvl=($rows["mn_level"]-1);
				$cmkode=$rows["mn_kode"];
				//$cislast=$rows["islast"];	
			}
			//echo "cparent=".$cparent.",clvl=".$clvl.",cmkode=".$cmkode.",cislast=".$cislast."<br>";
			if ($cparent!=$parentId){
				$cur_lvl=$lvl-$clvl;
				if ($cur_lvl>0) $cur_lvl="+".$cur_lvl;
				/*$sql="update b_ms_menu set islast=0 where id=".$parentId;
				//echo $sql."<br>";
				$rs=mysqli_query($konek,$sql);*/
				$sql="update a_menu set mn_kode='$kode',mn_menu='".$_REQUEST['nama']."',mn_level=$lvl,mn_url='".$_REQUEST['url']."' where id='".$_REQUEST['id']."'";
				//echo $sql."<br>";
				$rs=mysqli_query($konek,$sql);
				if ($cislast==0){
					$sql="update a_menu set mn_kode=CONCAT('$kode',right(kode,length(kode)-length('$cmkode'))),mn_level=".$cur_lvl." where left(kode,length('$cmkode'))='$cmkode'";
					//echo $sql."<br>";
					$rs=mysqli_query($konek,$sql);
				}
				
                        /*$sql="select * from b_ms_menu where parent_id=$cparent";
				//echo $sql."<br>";
				$rs=mysqli_query($konek,$sql);
				if (mysqli_num_rows($rs)<=0){
					$sql="update b_ms_menu set islast=1 where id=".$cparent;
					//echo $sql."<br>";
					$rs1=mysqli_query($konek,$sql);
				}*/
                        
			}else{	
				$sql="update a_menu set mn_kode='$kode',mn_menu='".$_REQUEST['nama']."',mn_level=$lvl,mn_url='".$_REQUEST['url']."' where id='".$_REQUEST['id']."'";
				//echo $sql."<br>";
				$rs=mysqli_query($konek,$sql);
				if (($kode_ma!=$cmkode) && ($cislast==0)){
					$sql="update a_menu set mn_kode=CONCAT('$kode',right(kode,length(kode)-length('$cmkode'))) where left(kode,length('$cmkode'))='$cmkode'";
					//echo $sql."<br>";
					$rs=mysqli_query($konek,$sql);
				}
			}
			//echo "ok";
		}
		break;
}
?>
<table id="tabelTree" border=1 cellspacing=0 width=98%>
      <tr bgcolor="whitesmoke">
            <td>
                  <?php	
                   
                    $canRead = true;
                    $include_del = 1;
                    $maxlevel=0;
                    $cnt=0;
                    
                    $strSQL = "select * from a_menu order by mn_kode";
                    $rs = mysqli_query($konek,$strSQL);
                    while ($rows=mysqli_fetch_array($rs)){
                               $c_level = $rows["mn_level"]+1;
                               //$pkode=trim($rows['parent_kode']);
                               $mkode=trim($rows['mn_kode']);
                               $kiri=explode(".",$rows['mn_kode']);
							   
							   $has=explode(".",$rows['mn_kode']);
							   if($rows['mn_level']==4){
							   	$what=$has[0].".".$has[1].".".$has[2].".".$has[3];
								$hah=".".$has[4];
							   }elseif($rows['mn_level']==3){
							   	$what=$has[0].".".$has[1].".".$has[2];
								$hah=".".$has[3];
							   }elseif($rows['mn_level']==2){
								$what=$has[0].".".$has[1];
								$hah=".".$has[2];   
							   }elseif($rows['mn_level']==1){
								$what=$has[0];
								$hah=".".$has[1];   
							   }elseif($rows['mn_level']==0){
								$what="";
								$hah=".".$has[0];   
							   }
							   
							   //$inap=($rows['inap']==1)?'true':'false';
                               //$chkAktif=($rows['aktif']==1)?'true':'false';
                               if ($pkode!=""){
                               //	if (substr($mkode,0,strlen($pkode))==$pkode) 
                                          //$mkode=substr($mkode,strlen($pkode),strlen($mkode)-(strlen($pkode)));
										  $mkode=substr($mkode,strlen($pkode),strlen($mkode)-(strlen($pkode)));
                                    //else
                                    //	$mkode=substr($mkode,strlen($pkode),strlen($mkode)-(strlen($pkode)));
                               }
                               $sql="select * from a_menu where mn_kode like '".$kiri[0]."%'";
                               $rs1=mysqli_query($konek,$sql);
                               if ($rows1=mysqli_fetch_array($rs1)) $c_mainduk=$rows1["mn_menu"]; else $c_mainduk="";
                               $tree[$cnt][0]= $c_level;
                               $tree[$cnt][1]= $rows["mn_kode"]." - ".($mpkode==""?"":$mpkode." - ").$rows["mn_menu"];			
                               $arfvalue="txtId*-*".$rows['id']."*|*txtKode*-*".$hah."*|*txtUrl*-*".$rows['mn_url']."*|*txtNama*-*".$rows['mn_menu']."*|*txtParentLvl*-*".($rows['mn_level']-1)."*|*txtLevel*-*".$rows['mn_level']."*|*txtParentKode*-*".$what."*|*btnSimpanSetting*-*Simpan"."*|*btnBatalSetting*-*false"."*|*btnHapusSetting*-*false";
                               $arfvalue=str_replace('"',chr(3),$arfvalue);
                               $arfvalue=str_replace("'",chr(5),$arfvalue);
                               $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
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
                               $tree[$cnt][7]="act*-*hapus*|*txtId*-*".$rows['id']."*|*txtParentKode*-*".$what;
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
<input type="hidden" id="txtSusun" value="<?php echo $susun;?>"/>