<?
include("sesi.php");
?>
<?php
//$_SESSION['userId']='22';
include("koneksi/konek.php");
?>
<link type="text/css" rel="stylesheet" href="menuh.css">
<style type="text/css">
    #container{
        height: 36px;
        position: relative;
    }

    #container ul{
        padding: 0;
        margin: 0;
        list-style: none;
    }

    #container ul li{
        height: 36px;
        width: 150px;
        display: block;
        margin-right: 2px;
        float: left;
        text-align: center;
    }

    #container ul li a{
        font-size:14px;
        color:white;
        font-weight:bold;
        font-family:Arial, Helvetica, sans-serif;
        text-decoration: none;
        height:27px;
        padding-top:9px;
        display:block;
    }

    #container ul li ul li a{
        font-size:12px;
        color:white;
        font-weight:bold;
        font-family:Arial, Helvetica, sans-serif;
        text-decoration: none;
        height:27px;
        padding-top:9px;
        display:block;
    }

    #container ul li a.green{
        background:url('images/green.jpg') bottom left no-repeat;
        /*text-shadow:1px 1px #274400;*/
        height: 34px;
        margin-left: -0.5em;
        margin-top: -0.8em;
    }

    #container ul li a.green:hover{
        background:url('images/green.jpg') center left no-repeat;
    }

    #container ul li a.green:active{
        background:url('images/green.jpg') top left no-repeat;
    }
    .asd
    {
        text-decoration: none;
        font-family: arial, verdana, san-serif;
        font-size: 13px; color: #4234ff;
    }
    
    .txtinputan
    {
        background-color:#056604;
        color:#ffffff;
        border:2px inset #ffffff;
    }
    
    .btninputan
    {
        background-color:#056604;
        color:#ffffff;
        border:3px outset #ffffff;
    }

    #menuh ul li{float:left; width: 100%;}
    #menuh a{height:1%;font:bold 0.7em/1.4em arial, sans-serif;}
</style>

<table style="vertical-align: top" cellpadding=0 cellspacing=0 width=1000 border=0 align="center">
    <tr>
        <td colspan=2 style="background-color:transparent; ">
            <div id='container' align="left">
                <div align="left" style="float:left;" id='menuh'>
                  <?php
                  $sqlMenu="select id, kode,nama, url,level from b_ms_menu where level=0";
                  $rsMenu=mysql_query($sqlMenu);
                  while($menu=mysql_fetch_array($rsMenu)){
                  ?>
                    <ul style="margin-right: .3em; ">
                        <li class='top_parent'>                            
                            <a id="<?php echo $menu['id'];?>" href="<?php echo $menu['url'];?>" class="green"><?php echo $menu['nama'];?></a>                          
                              <?php
                              if(isset($_SESSION['userId']) && $_SESSION['userId']!=''){
                                 $sql="SELECT m.id,m.kode,m.nama,m.url,m.level,m.parent_id 
                                       FROM b_ms_group_petugas gp 
                                       inner join b_ms_group g on gp.ms_group_id=g.id 
                                       inner join b_ms_group_akses ga on g.id=ga.ms_group_id 
                                       inner join b_ms_menu m on ga.ms_menu_id=m.id 
                                       where gp.ms_pegawai_id='".$_SESSION['userId']."'
                                       and m.id<>".$menu['id']."
                                       and m.kode like '".$menu['kode']."%' order by kode";
                                 //echo $sql."<br>";
                                 $rs=mysql_query($sql);
                                 $tagDepan='<ul>';
                                 $tagBlkng='</ul>';
                                 $tagLiDpn='<li>';
                                 $tagLiBlk='</li>';
                                 $dtMenu='';
                                 $level=$menu['level']+1;
                                 $i=0;
                                 while($rw=mysql_fetch_array($rs)){
                                    $i++;
                                    if($rw['level']>$level){
                                       $dtMenu .=$tagDepan.$tagLiDpn.'<a class="asd" href="'.$rw['url'].'">'.$rw['nama'].'</a>';
                                       $level=$rw['level'];
                                    }
                                    else if($rw['level']<$level){
                                       $dtMenu .=$tagLiBlk.$tagBlkng.$tagLiDpn.'<a class="asd" href="'.$rw['url'].'">'.$rw['nama'].'</a></li>';
                                       $level=$rw['level'];
                                    }
                                    else{
                                       if($i==1){
                                          $dtMenu .='<a class="asd" href="'.$rw['url'].'">'.$rw['nama'].'</a>';
                                       }else{
                                          $dtMenu .=$tagLiBlk.$tagLiDpn.'<a class="asd" href="'.$rw['url'].'">'.$rw['nama'].'</a>';
                                       }
                                    }
                                 }
                                 
                                 $dtMenu=$tagDepan.$tagLiDpn.$dtMenu.$tagLiBlk.$tagBlkng;
                                 for($j=$menu['level']+1;$j<$level;$j++){
                                    $dtMenu.=$tagLiBlk.$tagBlkng;
                                 }
                                 echo $dtMenu;
                              }
                              ?>
                        </li>
                    </ul>
                    <?php
                  }
                    ?>                    
                    <div style="margin-left: 700px; margin-top: -18px">
                        <form id="formLogin" action="login_proc.php" method="post" onsubmit="return cekLogin();">
                        <table border="0">
                            <tr>
                                <td align="right">
                                 <fieldset style="padding-top: 0px; padding-bottom: 2px; padding-right: 2px; padding-left: 2px">
                                 <?php
                                    if(!isset($_SESSION['userId'])){
                                 ?>
                                    
                                        <legend style="color: #005500">Login</legend>                                        
                                        <input class="txtinputan" type="text" size="8" id="txtUser" name="txtUser" value="User ID" onfocus="if(this.value == 'User ID') this.value=''" onblur="if(this.value=='') this.value = 'User ID'" />
                                        <input class="txtinputan" type="text" size="8" id="txtPass" name="txtPass" value="Password" onfocus="if(this.value == 'Password'){ this.value=''; this.type='password';}" onblur="if(this.value=='') {this.type = 'text'; this.value = 'Password';}" />
                                        <input class="btninputan" type="submit" value="login" />
                                    
                                    <?php
                                    }
                                    else{
                                       ?>
                                       <legend style="color: #005500">Login</legend>                                           
                                       Selamat datang <?php echo $_SESSION['userName'];?>
                                       <a href="logout_proc.php" >(Logout)</a>
                                       <?php
                                    }
                                    ?>
                                    </fieldset>
                                </td>
                            </tr>
                        </table>
                        </form>
                        <script>
                            function cekLogin(){
                                if(document.getElementById('txtUser').value=='User ID' || document.getElementById('txtPass').value=='Password'){
                                    alert('Silakan isi username dan password!');
                                    return false;
                                }
                                else{
                                    return true;
                                }
                            }
                        </script>
                    </div>
                </div>
            </div>
        </td>
    </tr>
</table>
<!--ul style="margin-right: .3em; ">
   <li class='top_parent'>                            
       <a id="1" href="#" class="green">Data Master</a>                          
         <ul>
            <li><a class="asd" href="master/tmpt_layanan.php">Tempat Layanan</a></li>
            <li><a class="asd" href="master/pelaksana_layanan.php">Pelaksana Layanan</a></li>
            <li><a class="asd" href="#">Tarif</a>
               <ul><li><a class="asd" href="master/pendukung_tarif.php">Pendukung Tarif</a></li>
                  <li><a class="asd" href="master/kamar.php">Kamar</a></li>
               </ul>
   </li>
</ul-->