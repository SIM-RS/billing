<?php
session_start();
include("../sesi.php");
include("../koneksi/konek.php");
$prop_id = $_REQUEST['prop_id'];
$arr_wilayah = array('','Propinsi','Kabupaten / Kota','Kecamatan','Kelurahan / Desa');
?>    
<table id="tblautocomplete_kab" border="0" cellpadding="1" cellspacing="0">
	<tr class="headtable">
		<td width="350" class="tblheader"><?php echo $arr_wilayah[2]; ?></td>
	</tr>
	<?php 
	$aKeyword = $_REQUEST["aKeyword"];
	$sql="select * from b_ms_wilayah where level = 2 and parent_id='$prop_id' and nama like '%{$aKeyword}%'";
	$rs=mysql_query($sql);
	$i=0;
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$arfvalue=$rows['id']."|".$rows['nama'];
		$lang2 = "fset_kab(this.lang);";
		if($_REQUEST['x']==2)
		{
			$lang2 = "fset_kab(this.lang);";
		}
	?>
	<tr id="list_kab<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="<?=$lang2;?>">
		<td class="tdisi" width="350" align="left">&nbsp;<?php echo $rows['nama']; ?></td>
	</tr>
	<?php
	}
	mysql_free_result($rs);
	?>	
</table>
<?php 
mysql_close($konek);
?>
