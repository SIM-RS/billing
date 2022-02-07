<?php 
//include("sesi.php");
include("../inc/koneksi.php");
?>

<div>
    <table width="1000">
        <div id="menu">
            <ul class="menu">
                <?php
               //$sqlMenu="select id, kode, nama, url,level from ms_menu where level=0 and aktif=1 and modul_id=5 order by kode";//
			   $sqlMenu="SELECT DISTINCT m.id,m.kode,m.nama,m.url,m.level,m.parent_id
                       FROM ms_group_petugas gp 
                       inner join ms_group g on gp.ms_group_id=g.id 
                       inner join ms_group_akses ga on g.id=ga.ms_group_id 
                       inner join ms_menu m on ga.ms_menu_id=m.id 
                       where gp.ms_pegawai_id='".$_SESSION['userId']."' and m.level=0 and m.aktif=1 and m.modul_id=5 order by kode"; 
					   
					//  echo $sqlMenu;
					  
                $rsMenu=mysql_query($sqlMenu);
                while($menu=mysql_fetch_array($rsMenu)) {
				
				
                    ?>
                <li><a id="<?php echo $menu['id'];?>" href="<?php echo "http://".$_SERVER['HTTP_HOST']."/simrs-pelindo/admin/".$menu['url'];?>" class="parent"><span><?php echo $menu['kode'].' '.$menu['nama'];?></span></a>
                        <?php
                        if(isset($_SESSION['userId']) && $_SESSION['userId']!='') {
                            ?>
                    <ul>
                                <?php
								
								$sql="SELECT DISTINCT m.id,m.kode,m.nama,m.url,m.level,m.parent_id
                       FROM ms_group_petugas gp 
                       inner join ms_group g on gp.ms_group_id=g.id 
                       inner join ms_group_akses ga on g.id=ga.ms_group_id 
                       inner join ms_menu m on ga.ms_menu_id=m.id 
                       where gp.ms_pegawai_id='".$_SESSION['userId']."'
                       and m.id<>".$menu['id']."
                       and m.kode like '".$menu['kode']."%' and m.aktif=1 and m.modul_id=5 order by kode"; 
                              //  echo $sql; 
								//echo mysql_error();
                                $rs=mysql_query($sql);
                                $tagDepan='<ul>';
                                $tagBlkng='</ul>';
                                $tagLiDpn='<li>';
                                $tagLiBlk='</li>';
                                $dtMenu='';
                                $level=$menu['level']+1;
                                $i=0;
                                $submenu="false";
                                while($rw=mysql_fetch_array($rs)) {
                                    $i++;
									if(empty($rw['url']) || $rw['url']=='' || $rw['url']==NULL){
											$rw['url']="inc/error.php";
									}
                                    if($rw['level']>$level) {
                                        $dtMenu = str_replace($dtMenuFix,$dtMenuTmp,$dtMenu);
                                        $dtMenuTmp='<ul><li><a href="http://'.$_SERVER['HTTP_HOST'].'/simrs-pelindo/admin/'.$rw['url'].'" class="parent"><span>'.$rw['kode'].' '.$rw['nama'].'</span></a>';
                                        $dtMenuFix='<ul><li><a href="http://'.$_SERVER['HTTP_HOST'].'/simrs-pelindo/admin/'.$rw['url'].'"><span>'.$rw['kode'].' '.$rw['nama'].'</span></a></li>';
                                        $dtMenu .=$dtMenuFix;
                                        $level=$rw['level'];
                                    }
                                    else if($rw['level']<$level) {
                                        $dtMenuTmp='</ul></li><li><a href="http://'.$_SERVER['HTTP_HOST'].'/simrs-pelindo/admin/'.$rw['url'].'" class="parent"><span>'.$rw['kode'].' '.$rw['nama'].'</span></a>';
                                        $dtMenuFix='</ul></li><li><a href="http://'.$_SERVER['HTTP_HOST'].'/simrs-pelindo/admin/'.$rw['url'].'"><span>'.$rw['kode'].' '.$rw['nama'].'</span></a></li>';
                                        $dtMenu .=$dtMenuFix;
                                        $level=$rw['level'];
                                    }
                                     else {
                                       /* if($i==1){
										  $dtMenuTmp='<a href="'.$rw['url'].'"><span>'.$rw['nama'].'</span></a>';
										  $dtMenu .=$dtMenuTmp;
									   }else{ */
                                        $dtMenuTmp='<li><a href="http://'.$_SERVER['HTTP_HOST'].'/simrs-pelindo/admin/'.$rw['url'].'" class="parent">'.'<span>'.$rw['kode'].' '.$rw['nama'].'</span>'.'</a>';
										$dtMenuFix='<li><a href="http://'.$_SERVER['HTTP_HOST'].'/simrs-pelindo/admin/'.$rw['url'].'">'.'<span>'.$rw['kode'].' '.$rw['nama'].'</span>'.'</a></li>';
                                        $dtMenu .=$dtMenuFix;
                                       //} style="width: 290px"
                                    } 
                                }

                                //$dtMenu=$tagDepan.$tagLiDpn.$dtMenu.$tagLiBlk.$tagBlkng;
                                for($j=$menu['level']+1;$j<$level;$j++) {
                                    $dtMenu.="</ul></li>";
                                }
                                echo $dtMenu;
                                ?>
                    </ul>
                            <?php
                        }
                        ?>
                </li>
                    <?php
                }
                ?>
            </ul>
        </div>
        <div id="copyright" style="display:none;">Copyright &copy; 2010 <a href="http://apycom.com/">Apycom jQuery Menus</a></div>
    </table>
</div>