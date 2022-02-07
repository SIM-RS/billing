<?php
session_start();
include("../sesi.php");
include("../koneksi/konek.php");
$kec_id = $_REQUEST['kec_id'];
$arr_wilayah = array('','Propinsi','Kabupaten / Kota','Kecamatan','Kelurahan / Desa');
?>    
<table id="tblautocomplete_des" border="0" cellpadding="1" cellspacing="0">
	<tr class="headtable">
		<td width="350" class="tblheader"><?php echo $arr_wilayah[4]; ?></td>
	</tr>
	<?php 
	$aKeyword = $_REQUEST["aKeyword"];
	$sql="select * from b_ms_wilayah where level = 4 and parent_id='$kec_id' and nama like '%{$aKeyword}%'";
	$rs=mysql_query($sql);
	$i=0;
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$arfvalue=$rows['id']."|".$rows['nama'];
		$lang4 = "fset_des(this.lang);";
		if($_REQUEST['x']==2)
		{
			$lang4 = "fset_des(this.lang);";
		}
	?>
	<tr id="list_des<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="<?=$lang4;?>">
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
