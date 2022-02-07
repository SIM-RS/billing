<?php
include("../koneksi/konek.php");
//====================================================================

$cmb=$_REQUEST["cmb"];
$tipex=$_REQUEST["tipex"];
$filter=$_REQUEST["filter"];

if($cmb=='anamnesa'){
	$sql="select * from anamnese_pilih where tipe='$tipex' order by urut";
	$ex=mysql_query($sql);
	while($dt=mysql_fetch_array($ex)){
?>
	<script>
jQuery("<option value='<? echo $dt['nama']; ?>'><? echo $dt['nama']; ?></option>").appendTo("#<?=$filter?>");
</script>

<?php 
	}
}?>