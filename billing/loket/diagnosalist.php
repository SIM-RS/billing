<?php 
include("../koneksi/konek.php");
?>    
<table id="tblDiagnosa" border="0" cellpadding="1" cellspacing="0">
	<tr class="headtable">
		<td width="100" class="tblheaderkiri"> KODE </td>
		<td width="300" class="tblheader"> DIAGNOSA </td>
	</tr>
<?php 
	$aKeyword = $_REQUEST["aKeyword"];
	$findAll = $_REQUEST['findAll'];
	$unitId = $_REQUEST['unitId'];
	$filter = '';
	
	if($findAll != 'true'){
		$filter = "AND (d.nama like '%$aKeyword%' OR d.kode like '%$aKeyword%')";
	}
	
	$sql = "SELECT d.* FROM b_ms_diagnosa d INNER JOIN b_ms_diagnosa_unit du ON d.id=du.ms_diagnosa_id 
			WHERE d.AKTIF=1 $filter AND du.ms_unit_id = '$unitId' ORDER BY d.id LIMIT 200";
	
	//echo $sql;
	$rs=mysql_query($sql);
	//$arfvalue="";
	$i=0;
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$arfvalue=$rows['id']."*|*".$rows['nama']."*|*".$rows["kode"];
?>
	<tr id="lstDiag<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="fSetPenyakit_sjp(this.lang);">
		<td class="tdisikiri" width="100" align="center">&nbsp;<?php echo $rows['kode']; ?></td>
		<td class="tdisi" width="300" align="left">&nbsp;<?php echo $rows['nama']; ?></td>
	</tr>
	<?php
	}
	mysql_free_result($rs);
	?>	
</table>
<?php 
mysql_close($konek);
?>