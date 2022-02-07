<?php
$url = explode('/',$_SERVER['REQUEST_URI']);//$_SERVER['REQUEST_URI'];
$margin = '';
if(isset($url[4]) && $url[4] != '' || isset($url[3]) && $url[3] != ''){
    $url = '../images/foot.gif';
    $margin = 'margin-top: 10px; ';
}
else{
    $url = 'images/foot.gif';
}

?>
<div style="<?php echo $margin;?>background-image: url('<?php echo $url;?>'); width: 1000px; height: 40px">
    <!--img alt="foot" src="../images/foot.gif" width="1000" height="45" /-->
</div>
