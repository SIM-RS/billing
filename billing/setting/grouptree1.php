<?
//include("../sesi.php");
?>
<?php
	include("../koneksi/konek.php");
	$act = $_REQUEST['act'];
	$par = $_REQUEST['par'];
      $gid=$_REQUEST['gid'];

?>
<fieldset><legend>Menu</legend>
   <table border=1 cellspacing=0 width=98% id="tabel3">
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
                       
                       $PATH_INFO = 'http://'.$_SERVER['HTTP_HOST'].$base_addr.'/billing/setting/grouptree.php';
                        $target='divtree3';
                       $canRead = true;
                       $include_del = 1;
                       $maxlevel=0;
                       $cnt=0;
                       $strSQL = "select * from b_ms_menu order by kode";
                       $rs = mysql_query($strSQL);
                       while ($rows=mysql_fetch_array($rs)){
                                  $c_level = $rows["level"] + 1;
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
                                  $ada='0';
                                  if(isset($_REQUEST['gid'])){
                                    $sqlAkses="select * from b_ms_group_akses where ms_group_id=".$gid." and ms_menu_id=".$rows['id'];
                                    //echo $sqlAkses."<br>";
                                    $rsAkses=mysql_query($sqlAkses);
                                    if(mysql_num_rows($rsAkses)>0){
                                       $ada='1';
                                    }
                                    
                                  }
                                  //echo $ada."<br>";
                                  $tree[$cnt][1]= "<input type='checkbox' ".(($ada=='1')?'checked=\'true\'':'')." value='".$rows['id']."' onclick='simpanAkses(document.getElementById(\"cmbGroup\").value,this.value)'/>".$rows["kode"]." - ".($mpkode==""?"":$mpkode." - ").$rows["nama"];			
                                  $arfvalue="txtId*-*".$rows['id']."*|*txtKode*-*".$mkode."*|*txtNama*-*".$rows['nama']."*|*txtParentLvl*-*".($rows['level']-1)."*|*txtLevel*-*".$rows['level']."*|*txtParentId*-*".$rows['parent_id']."*|*txtParentKode*-*".$rows['parent_kode']."*|*btnSimpan*-*Simpan";
                                  $arfvalue=str_replace('"',chr(3),$arfvalue);
                                  $arfvalue=str_replace("'",chr(5),$arfvalue);
                                  $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
                                  if ($c_level>0)
                                        //$tree[$cnt][2]= "javascript:fSetValue(window,'".$arfvalue."');";
                                        $tree[$cnt][2]= null;
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
</fieldset>
