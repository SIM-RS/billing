<?php 
include("../sesi.php");
include("../koneksi/konek.php");
$par=$_REQUEST['par'];
$par=explode("*",$par);

?>
<html>
<title>Tree Rekening</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
<style>
BODY, TD {font-family:Verdana; font-size:7pt}
.NormalBG 
{
	background-color : #FFFFFF;
}

.AlternateBG { 
	background-color : #EDF1FE;
}
.MOverBG { 
	background-color : #FFCC66;
}

</style>
<body style="border-width:0px;" bgcolor="#CCCCCC" topmargin="0" leftmargin="0" onLoad="javascript:if (window.focus) window.focus();">
<div align="center">
<table border=1 cellspacing=0 width="98%" style="border-collapse:collapse">
<tr>
  <td colspan="3" class=GreenBG align=center><font size=1><b>
.: Data KSO :.
</b></font></td>
</tr>
<tr>
	<td width="40" align="center"><b>No</b></td>
    <td width="100" align="center"><b>Kode KSO</b></td>
    <td align="center"><b>Nama KSO</b></td>
</tr>
<?php 
$sql="SELECT * FROM $dbbilling.b_ms_kso WHERE aktif=1 ORDER BY nama";
$rs=mysqli_query($konek,$sql);
$i=1;
while ($rw=mysqli_fetch_array($rs)){
	if (($i%2)==0) $classtr="AlternateBG"; else $classtr="NormalBG";
	$arfvalue=str_replace('"',chr(3),$par[0]."*-*".$rw["kode"]."*|*".$par[1]."*-*".$rw["nama"]);
	$arfvalue=str_replace("'",chr(5),$arfvalue);
?>
<tr class="<?php echo $classtr; ?>" style="cursor:pointer" onMouseOver="className='MOverBG'" onMouseOut="className='<?php echo $classtr; ?>'" onClick="goEdit('<?php echo $arfvalue; ?>');">
	<td align="center"><?php echo $i++; ?></td>
    <td align="center"><?php echo $rw["kode"]; ?></td>
    <td><?php echo $rw["nama"]; ?></td>
</tr>
<?php
}
?>
</table>
</div>
</body>
<script language="javascript">
function goEdit(par) {
	fSetValue(window.opener,par);
  	window.close();
}


</script>
</html>
<?php 
mysqli_close($konek);
?>