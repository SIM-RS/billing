<?php 
include("../koneksi/konek.php");
?>    
<table width="700" id="tblDiagnosa" border="0" cellpadding="1" cellspacing="0">
	<tr class="headtable">
		<td width="100" class="tblheaderkiri"> KODE </td>
		<td width="300" class="tblheader"> DIAGNOSA </td>
        <td width="300" class="tblheader"> DESC </td>
	</tr>
<?php 
	$aKeyword=$_REQUEST["aKeyword"];
	$findAll = $_REQUEST['findAll'];
	$unitId = $_REQUEST['unitId'];
	$PK = $_REQUEST['PK'];
	$is_icd9cm = $_REQUEST['is_icd9cm'];
	$filter = '';
	if ($is_icd9cm=="1"){
		$filter = " AND (CODE like '%$aKeyword%' OR STR like '%$aKeyword%')";
		$sql="SELECT CODE id, CODE kode, STR nama,'' nama_idn FROM mrconso WHERE SAB = 'ICD9CM_2005' $filter ORDER BY CODE LIMIT 200";
	}else{
		if($findAll != 'true'){
			if($PK==1){
				$filter = "AND (DG_KODE like '%$aKeyword%' OR DG_NAMA like '%$aKeyword%')";
			}
			else{
				$filter = "AND (d.nama like '%$aKeyword%' OR d.kode like '%$aKeyword%' OR d.nama_idn like '%$aKeyword%')";
			}
		}
		
		//if ($unitId=="73"){
		if($PK==1){
			$sql="SELECT DG_KODE as id,DG_KODE as kode,DG_NAMA as nama FROM b_ms_diagnosa_gol WHERE DG_TIPE=1 $filter ORDER BY DG_KODE";	
		}
		else{
			/*$sql="SELECT d.* FROM b_ms_diagnosa d INNER JOIN b_ms_diagnosa_unit du ON d.id=du.ms_diagnosa_id 
	WHERE d.AKTIF=1 $filter AND du.ms_unit_id='$unitId' ORDER BY d.id LIMIT 200";*/
			$sql="SELECT d.* FROM b_ms_diagnosa d WHERE d.AKTIF=1 $filter ORDER BY d.id LIMIT 200";
		}
	}
	//echo $sql;
	$rs=mysql_query($sql);
	//$arfvalue="";
	$i=0;
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$arfvalue=$rows['id']."*|*".$rows['nama']."*|*".$rows["kode"]."*|*".$rows["degger"];
?>
	<tr id="lstDiag<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="fSetICDX_RM(this.lang);">
		<td class="tdisikiri" width="100" align="center">&nbsp;<?php echo $rows['kode']; ?></td>
		<td class="tdisi" width="300" align="left">&nbsp;<?php echo $rows['nama']; ?></td>
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