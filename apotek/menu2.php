<?php
//$_SESSION['userId']='22';
include("koneksi/konek.php");
?>

<link type="text/css" href="../menu.css" rel="stylesheet" />
<script type="text/javascript" src="../jquery.js"></script>
<script type="text/javascript" src="../menu.js"></script>

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
                $sqlMenu="select id, mn_kode, mn_menu, mn_url, mn_level from a_menu where mn_level=0";
                $rsMenu=mysqli_query($konek,$sqlMenu);
                while($menu=mysqli_fetch_array($rsMenu)) {
                    ?>
                <li><a id="<?php echo $menu['id'];?>" href="<?php echo $menu['mn_url'];?>" class="parent"><span><?php echo $menu['mn_kode']." ".$menu['mn_menu'];?></span></a>
                        <?php
                        if(isset($_SESSION['iduser']) && $_SESSION['iduser'] != '') {
                            ?>
                    <ul>
                                <?php
                                $sql="SELECT DISTINCT a_menu.id, a_menu.mn_kode, a_menu.mn_level, a_menu.mn_menu, a_menu.mn_url 
									FROM a_menu INNER JOIN a_menu_akses ON a_menu_akses.menu_id=a_menu.id
									WHERE a_menu_akses.user_id='".$_SESSION['iduser']."' 
									AND a_menu.id<>'".$menu['id']."' AND a_menu.mn_kode LIKE '".$menu['mn_kode']."%' 
									ORDER BY a_menu.mn_kode";
                                // 	echo $sql."<br>";
                                $rs=mysqli_query($konek,$sql);
                                $tagDepan='<ul>';
                                $tagBlkng='</ul>';
                                $tagLiDpn='<li>';
                                $tagLiBlk='</li>';
                                $dtMenu='';
                                $level=$menu['mn_level']+1;
                                $i=0;
                                $submenu="false";
                                while($rw=mysqli_fetch_array($rs)) {
                                    $i++;
                                    if($rw['mn_level']>$level) {
                                        //$dtMenu .=$tagDepan.$tagLiDpn.'<a href="'.$rw['url'].'"><span>'.$rw['nama'].'</span></a>';
                                        $dtMenu = str_replace($dtMenuFix,$dtMenuTmp,$dtMenu);
                                        //$dtMenu .=$tagDepan.$tagLiDpn.'<a href="'.$rw['url'].'"><span>'.$rw['nama'].'</span></a>';
                                        $dtMenuTmp='<ul><li><a href="'.$rw['mn_url'].'" class="parent"><span>'.$rw['mn_kode'].' '.$rw['mn_menu'].'</span></a>';
                                        $dtMenuFix='<ul><li><a href="'.$rw['mn_url'].'"><span>'.$rw['mn_kode'].' '.$rw['mn_menu'].'</span></a></li>';
                                        $dtMenu .=$dtMenuFix;
                                        $level=$rw['mn_level'];
                                    }
                                    else if($rw['mn_level']<$level) {
                                        $dtMenuTmp='</ul></li><li><a href="'.$rw['mn_url'].'" class="parent"><span>'.$rw['mn_kode'].' '.$rw['mn_menu'].'</span></a>';
                                        $dtMenuFix='</ul></li><li><a href="'.$rw['mn_url'].'"><span>'.$rw['mn_kode'].' '.$rw['mn_menu'].'</span></a></li>';
                                        $dtMenu .=$dtMenuFix;
                                        $level=$rw['mn_level'];

                                    }
                                    else {
                                        /*if($i==1){
					   	  $dtMenuTmp='<a href="'.$rw['url'].'"><span>'.$rw['nama'].'</span></a>';
                          $dtMenu .=$dtMenuTmp;
                       }else{*/
                                        $dtMenuTmp='<li><a href="'.$rw['mn_url'].'" class="parent">'.'<span>'.$rw['mn_kode'].' '.$rw['mn_menu'].'</span>'.'</a>';
                                        $dtMenuFix='<li><a href="'.$rw['mn_url'].'">'.'<span>'.$rw['mn_kode'].' '.$rw['mn_menu'].'</span>'.'</a></li>';
                                        $dtMenu .=$dtMenuFix;
                                        //} style="width: 290px"
                                    }
                                }

                                //$dtMenu=$tagDepan.$tagLiDpn.$dtMenu.$tagLiBlk.$tagBlkng;
                                for($j=$menu['mn_level']+1;$j<$level;$j++) {
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