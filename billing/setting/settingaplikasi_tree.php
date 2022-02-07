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
	$PATH_INFO ='http://'.$_SERVER['HTTP_HOST'].$base_addr.'/billing/setting/settingaplikasi_tree.php';
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
            
           
		mysql_query("select * from b_ms_menu where kode='".$kode."' and aktif=1");
		if(mysql_affected_rows()>0){
			echo "Data Sudah Ada!";
		}
		else{
			$sqlTambah="insert into b_ms_menu (kode,nama,level,parent_id,parent_kode,url,islast)
				values('".$kode."','".$_REQUEST['nama']."','".$_REQUEST['level']."','".$_REQUEST['parentId']."','".$_REQUEST['parentKode']."','".$_REQUEST['url']."','1')";
			$rs=mysql_query($sqlTambah);
                  //echo $sqlTambah."<br/>";
                  //echo mysql_error();
			if ($parentId>0){
				$sql="update b_ms_menu set islast=0 where id=$parentId";
				//echo $sql;
				$rs=mysql_query($sql);
			}
			//echo "ok";
		}
		break;
	case 'hapus':
		mysql_query("select * from b_ms_menu where parent_id='".$_REQUEST['id']."'");
		if(mysql_affected_rows()>0){
			echo "Data merupakan induk! ".$_REQUEST['id'];
		}
		else{
			$sql="delete from b_ms_menu where id='".$_REQUEST['id']."'";
			//echo $sql."<br>";
			$rs=mysql_query($sql);
			
                  $sql1="select * from b_ms_menu where parent_id=".$parentId;
			//echo $sql1."<br>";
			$rs2=mysql_query($sql1);
			if (mysql_num_rows($rs2)<=0){
				$sql2="update b_ms_menu set islast=1 where id=".$parentId;
				//echo $sql2."<br>";
				$rs3=mysql_query($sql2);
			}
                  
			//echo "ok";
		}		
		break;
	case 'simpan':           
		$sql="select * from b_ms_menu where kode='$kode' and nama='".$_REQUEST['nama']."' and level=$lvl and parent_id=$parentId and parent_kode='$ParentKode' and url='".$_REQUEST['url']."'";
		//echo $sql."<br>";
		$rs1=mysql_query($sql);
		if (mysql_num_rows($rs1)>0){
			echo "Data Sudah Ada!";
		}else{
			$sql="select * from b_ms_menu where id='".$_REQUEST['id']."'";
			//echo $sql."<br>";
			$rs=mysql_query($sql);
			if ($rows=mysql_fetch_array($rs)){
				$cparent=$rows["parent_id"];
				$clvl=($rows["level"]-1);
				$cmkode=$rows["kode"];
				$cislast=$rows["islast"];	
			}
			//echo "cparent=".$cparent.",clvl=".$clvl.",cmkode=".$cmkode.",cislast=".$cislast."<br>";
			if ($cparent!=$parentId){
				$cur_lvl=$lvl-$clvl;
				if ($cur_lvl>0) $cur_lvl="+".$cur_lvl;
				$sql="update b_ms_menu set islast=0 where id=".$parentId;
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				$sql="update b_ms_menu set kode='$kode',nama='".$_REQUEST['nama']."',level=$lvl,parent_id=$parentId,parent_kode='$ParentKode',url='".$_REQUEST['url']."' where id='".$_REQUEST['id']."'";
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				if ($cislast==0){
					$sql="update b_ms_menu set kode=CONCAT('$kode',right(kode,length(kode)-length('$cmkode'))),parent_kode=CONCAT('$kode',right(parent_kode,length(parent_kode)-length('$cmkode'))),level=".$cur_lvl." where left(kode,length('$cmkode'))='$cmkode'";
					//echo $sql."<br>";
					$rs=mysql_query($sql);
				}
				
                        $sql="select * from b_ms_menu where parent_id=$cparent";
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				if (mysql_num_rows($rs)<=0){
					$sql="update b_ms_menu set islast=1 where id=".$cparent;
					//echo $sql."<br>";
					$rs1=mysql_query($sql);
				}
                        
			}else{	
				$sql="update b_ms_menu set kode='$kode',nama='".$_REQUEST['nama']."',level=$lvl,parent_id=$parentId,parent_kode='$ParentKode',url='".$_REQUEST['url']."' where id='".$_REQUEST['id']."'";
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				if (($kode_ma!=$cmkode) && ($cislast==0)){
					$sql="update b_ms_menu set kode=CONCAT('$kode',right(kode,length(kode)-length('$cmkode'))),parent_kode=CONCAT('$kode',right(parent_kode,length(parent_kode)-length('$cmkode'))) where left(kode,length('$cmkode'))='$cmkode'";
					//echo $sql."<br>";
					$rs=mysql_query($sql);
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
                    
                    $strSQL = "select * from b_ms_menu where aktif=1 order by kode";
                    $rs = mysql_query($strSQL);
                    while ($rows=mysql_fetch_array($rs)){
                               $c_level = $rows["level"]+1;
                               $pkode=trim($rows['parent_kode']);
                               $mkode=trim($rows['kode']);
                               
                               $inap=($rows['inap']==1)?'true':'false';
                               $chkAktif=($rows['aktif']==1)?'true':'false';
                               if ($pkode!=""){
                               //	if (substr($mkode,0,strlen($pkode))==$pkode) 
                                          $mkode=substr($mkode,strlen($pkode),strlen($mkode)-(strlen($pkode)));
                                    //else
                                    //	$mkode=substr($mkode,strlen($pkode),strlen($mkode)-(strlen($pkode)));
                               }
                               $sql="select * from b_ms_menu where id=".$rows['parent_id'];
                               $rs1=mysql_query($sql);
                               if ($rows1=mysql_fetch_array($rs1)) $c_mainduk=$rows1["nama"]; else $c_mainduk="";
                               $tree[$cnt][0]= $c_level;
                               $tree[$cnt][1]= $rows["kode"]." - ".($mpkode==""?"":$mpkode." - ").$rows["nama"];			
                               $arfvalue="txtId*-*".$rows['id']."*|*txtKode*-*".$mkode."*|*txtUrl*-*".$rows['url']."*|*txtNama*-*".$rows['nama']."*|*txtParentLvl*-*".($rows['level']-1)."*|*txtLevel*-*".$rows['level']."*|*txtParentId*-*".$rows['parent_id']."*|*txtParentKode*-*".(($rows['parent_kode']=='0')?'':$rows['parent_kode'])."*|*btnSimpanSetting*-*Simpan"."*|*btnBatalSetting*-*false"."*|*btnHapusSetting*-*false";
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
							   $swt="select * from b_ms_menu where id='".$rows['parent_kode']."'";
							   $ini=mysql_fetch_array(mysql_query($swt));
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
<input type="hidden" id="txtSusun" value="<?php echo $susun;?>"/>