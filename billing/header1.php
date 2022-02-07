<?php
if(($_SESSION['userId']=='') && ($_SESSION['userName']=='') && ($_SESSION['unitId']=='') ){
	?>
		<script>
			window.location='http://<?php echo $_SERVER['HTTP_HOST'].$base_addr;?>/index.php';
		</script>
	<?php
}
?>
<link href="theme/tab-view.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="http://<?php echo $_SERVER['HTTP_HOST'].$base_addr;?>/billing/icon/favicon.ico"/>
<style type="text/css">
<!--
.style2 {font-size: 20px}
-->
</style>
<table width="1000" border="0" cellpadding="0" cellspacing="0" align="center" height="70">
    <tr class="hd1"><td width="16%">
                      &nbsp;
        <!--img src="http://< ?php echo $_SERVER['HTTP_HOST']?>/simrs-tangerang/billing/images/images/header_06.gif" align="middle" /-->
        </td>
    <td width="17%" class="hd1"></td>
	  <td width="47%" height="20" class="hd1">&nbsp;<span class="hd1">Sistem Informasi Manajemen Rumah Sakit</span></td>
          <td width="20%" height="20" class="hd1" align="right"><a id="aharef" href="http://<?php echo $_SERVER['HTTP_HOST'].$base_addr;?>/billing/"><img alt="close" src="http://<?php echo $_SERVER['HTTP_HOST'].$base_addr;?>/billing/icon/x.png" width="32"></a>&nbsp;</td>
  </tr>
</table>