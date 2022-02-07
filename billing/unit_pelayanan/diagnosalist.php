<?php 
include("../koneksi/konek.php");
?>    
<table width="906" id="tblDiagnosa" border="0" cellpadding="1" cellspacing="0">
	<tr class="headtable">
	  <td width="102" class="tblheader">KODE</td>
		<!--<td width="100" class="tblheaderkiri"> KODE </td>-->
		<td width="498" class="tblheader"> DIAGNOSA </td>
        <td width="300" class="tblheader"> DESC </td>
	</tr>
<?php 
	$aKeyword=$_REQUEST["aKeyword"];
	$findAll = $_REQUEST['findAll'];
	$unitId = $_REQUEST['unitId'];
	$PK = $_REQUEST['PK'];
	$filter = '';
	
	if($findAll != 'true'){
		if($PK==1){
			$filter = "AND (DG_KODE like '$aKeyword%' OR DG_NAMA like '%$aKeyword%')";
		}
		else{
			$filter = "AND (d.nama like '%$aKeyword%' OR d.kode like '$aKeyword%' OR d.nama_idn like '%$aKeyword%')";
		}
	}
	
	//if ($unitId=="73"){
	if($PK==1){
		$sql="SELECT DG_KODE as id,DG_KODE as kode,DG_NAMA as nama FROM b_ms_diagnosa_gol WHERE DG_TIPE=1 $filter ORDER BY DG_NAMA";	
	}
	else{
		/*$sql="SELECT d.* FROM b_ms_diagnosa d INNER JOIN b_ms_diagnosa_unit du ON d.id=du.ms_diagnosa_id 
WHERE d.AKTIF=1 $filter AND du.ms_unit_id='$unitId' AND LENGTH(d.kode)=3 ORDER BY d.id LIMIT 200";*/
		$sql="SELECT DISTINCT  d.* FROM b_ms_diagnosa d INNER JOIN b_ms_diagnosa_unit du ON d.id=du.ms_diagnosa_id 
WHERE d.AKTIF=1 $filter /*AND du.ms_unit_id='$unitId'*/ ORDER BY d.nama LIMIT 200";
	}
	//}else{
	//	$sql="select d.* from b_ms_diagnosa d where d.AKTIF=1 $filter ORDER BY d.id limit 200";
	//}
	//echo $sql;
	$rs=mysql_query($sql);
	//$arfvalue="";
	$i=0;
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$arfvalue=$rows['id']."*|*".$rows['nama']."*|*".$rows["kode"];
?>
	<tr id="lstDiag<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="fSetPenyakit(this.lang);">
	  <td class="tdisi" width="102" align="center"><?php echo $rows['kode']; ?></td>
		<!--<td class="tdisikiri" width="100" align="center">&nbsp;<?php echo $rows['kode']; ?></td>-->
		<td class="tdisi" width="498" align="left">&nbsp;<?php echo $rows['nama']; ?></td>
        <td class="tdisi" width="300" align="left">&nbsp;<?php echo $rows['nama_idn']; ?></td>
	</tr>
	<?php
	}
	mysql_free_result($rs);
	?>	
</table>
<?php 
mysql_close($konek);
?>