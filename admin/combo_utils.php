<?php
include("../inc/koneksi.php");
$val=explode(",",$_REQUEST['value']);
$lang=false;
$all = '';
switch($_REQUEST['id']) {
	case 'cmbGroup':
		$lang2=true;
        $sql="SELECT id,nama FROM ms_group WHERE aktif = 1 and modul_id = ".$val[0]." ORDER BY nama";
        break;	
}
$rs=mysql_query($sql);
if($_REQUEST["all"]==1 || $all == 'true') {
    ?>
<option value="0">SEMUA</option>
    <?php
}
while($rw=mysql_fetch_array($rs)) {
	?>
<option value="<?php echo $rw['id'];?>" label="<?php echo $rw['nama'];?>" <?php if($rw['id']==$_REQUEST['defaultId']) echo "selected"?>><?php echo $rw['nama'];?></option>
    <?php
}

mysql_free_result($rs);
mysql_close($konek);
?>
