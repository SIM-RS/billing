<?php 
include("../koneksi/konek.php");
$unitId = $_REQUEST['unitId'];
?>    
<table id="tblTindakanINACBG" border="0" cellpadding="1" cellspacing="0">
	<tr class="headtable">
		<td width="100" class="tblheaderkiri"> Kode </td>
		<td width="100" class="tblheader"> Tindakan </td>
	</tr>
<?php 
	$aKeyword=$_REQUEST["aKeyword"];
	
	//$sql = "select CODE, STR from mrconso where (CODE like '%{$aKeyword}%' or STR like '%{$aKeyword}%') and TTY = 'PT' limit 10";
	$sql = "SELECT m.AUI, m.CODE, m.STR
			 FROM mrconso m
			   INNER JOIN b_ms_tindakan_icd9_unit c
				  ON c.ms_icd9 = m.AUI
			 WHERE (m.CODE LIKE '%{$aKeyword}%' OR m.STR LIKE '%{$aKeyword}%')
			 AND m.TTY = 'PT' AND m.SAB = 'ICD9CM_2005'
			 AND c.ms_unit_id = '{$unitId}'
			 LIMIT 10";
	$rs=mysql_query($sql);

	$i=0;
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$arfvalue=$rows['CODE']."*|*".$rows['STR'];
?>
	<tr id="lstTind<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="fSetTindakanINACBG(this.lang);">
		<td class="tdisikiri" width="100" align="center">&nbsp;<?php echo $rows['CODE']; ?></td>
		<td class="tdisi" width="350" align="left">&nbsp;<?php echo $rows['STR']; ?></td>
	</tr>
	<?php
	}
	mysql_free_result($rs);
	?>	
</table>
<?php 
mysql_close($konek);
?>
