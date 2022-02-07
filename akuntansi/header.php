<?php
$wktnow=gmdate('H:i:s',mktime(date('H')+7));
$wkttgl=gmdate('d/m/Y',mktime(date('H')+7));
$url=split("/",$_SERVER['REQUEST_URI']);//echo $_SERVER['REQUEST_URI']."<br>";
$imgpath="/".$url[1]."/".$url[2]."/images";
//$imgpath="/".$url[1]."/images";
$iunit=$_SESSION['ses_usrname'];
?>
<style type="text/css">
<!--
.style1 {font-family: Verdana, Arial, Helvetica, sans-serif}
-->
</style>

<table width="1000" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="4"><img src="<?php echo $imgpath; ?>/kop3.png" width="1000" height="100" border="0" /></td>
  </tr>
  <tr class="H">
  	<td id="dateformat" colspan="4" height="10">&nbsp;</td>
  </tr>
</table>
