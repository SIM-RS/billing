<?php
include("sesi.php");
?>
<?php
//$_SESSION['userId']='22';
include("koneksi/konek.php");
?>

<!--link type="text/css" href="menu.css" rel="stylesheet" />
<script type="text/javascript" src="menu.js"></script>
<script type="text/javascript" src="jquery.js"></script-->

<style type="text/css">
    * { margin:0;
        padding:0;
    }
    div#menu { margin:5px auto; }
    div#copyright {
        font:11px 'Trebuchet MS';
        color:#fff;
        text-indent:30px;
        padding:40px 0 0 0;
    }
    div#menu { margin:0px auto; }
    div#copyright {
        font:11px 'Trebuchet MS';
        color:#222;
        text-indent:30px;
        padding:140px 0 0 0;
    }
    div#copyright a { color:#eee; }
    div#copyright a:hover { color:#222; }
</style>
<div>
<table height="60" bgcolor="#4a5155">
        <div id="menu">
            <ul class="menu">
                <?php
                $sqlMenu="select DISTINCT id, kode,nama, url,level from b_ms_menu where level=0 and aktif=1 order by kode";
                $rsMenu=mysql_query($sqlMenu);
                while($menu=mysql_fetch_array($rsMenu)) {
                    ?>
                <li><a id="<?php echo $menu['id'];?>" href="<?php echo $menu['url'];?>" class="parent"><span><?php echo $menu['kode'].' '.$menu['nama'];?></span></a>
                        <?php
                        if(isset($_SESSION['userId']) && $_SESSION['userId']!='') {
                            ?>
                    <ul>
                                <?php
                                $sql="SELECT DISTINCT m.id,m.kode,m.nama,m.url,m.level,m.parent_id
                       FROM b_ms_group_petugas gp 
                       inner join b_ms_group g on gp.ms_group_id=g.id 
                       inner join b_ms_group_akses ga on g.id=ga.ms_group_id 
                       inner join b_ms_menu m on ga.ms_menu_id=m.id 
                       where gp.ms_pegawai_id='".$_SESSION['userId']."'
                       and m.id<>".$menu['id']."
                       and m.kode like '".$menu['kode']."%' and m.aktif=1 order by kode";
                                //echo $sql."<br>";
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
                                    if($rw['level']>$level) {
                                        //$dtMenu .=$tagDepan.$tagLiDpn.'<a href="'.$rw['url'].'"><span>'.$rw['nama'].'</span></a>';
                                        $dtMenu = str_replace($dtMenuFix,$dtMenuTmp,$dtMenu);
                                        //$dtMenu .=$tagDepan.$tagLiDpn.'<a href="'.$rw['url'].'"><span>'.$rw['nama'].'</span></a>';
                                        $dtMenuTmp='<ul><li><a href="'.$rw['url'].'" class="parent"><span>'.$rw['kode'].' '.$rw['nama'].'</span></a>';
                                        $dtMenuFix='<ul><li><a href="'.$rw['url'].'"><span>'.$rw['kode'].' '.$rw['nama'].'</span></a></li>';
                                        $dtMenu .=$dtMenuFix;
                                        $level=$rw['level'];
                                    }
                                    else if($rw['level']<$level) {
                                        $dtMenuTmp='</ul></li><li><a href="'.$rw['url'].'" class="parent"><span>'.$rw['kode'].' '.$rw['nama'].'</span></a>';
                                        $dtMenuFix='</ul></li><li><a href="'.$rw['url'].'"><span>'.$rw['kode'].' '.$rw['nama'].'</span></a></li>';
                                        $dtMenu .=$dtMenuFix;
                                        $level=$rw['level'];
                                    }
                                    else {
                                        /*if($i==1){
					   	  $dtMenuTmp='<a href="'.$rw['url'].'"><span>'.$rw['nama'].'</span></a>';
                          $dtMenu .=$dtMenuTmp;
                       }else{*/
                                        $dtMenuTmp='<li><a href="'.$rw['url'].'" class="parent">'.'<span>'.$rw['kode'].' '.$rw['nama'].'</span>'.'</a>';
                                        $dtMenuFix='<li><a href="'.$rw['url'].'">'.'<span>'.$rw['kode'].' '.$rw['nama'].'</span>'.'</a></li>';
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
				<li><a href="../portal.php" class="parent" ><span>7 PORTAL</span></a></li>
            </ul>
        </div>
        <div id="copyright" style="display:none;">Copyright &copy; 2010 <a href="http://apycom.com/">Apycom jQuery Menus</a></div>
    </table>
</div>