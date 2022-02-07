<?php
session_start();
include("../sesi.php");
include("../koneksi/konek.php");
$kab_id = $_REQUEST['kab_id'];
$arr_wilayah = array('','Propinsi','Kabupaten / Kota','Kecamatan','Kelurahan / Desa');
?>    
<table id="tblautocomplete_kec" border="0" cellpadding="1" cellspacing="0">
	<tr class="headtable">
		<td width="350" class="tblheader"><?php echo $arr_wilayah[3]; ?></td>
	</tr>
	<?php 
	$aKeyword = $_REQUEST["aKeyword"];
	$sql="select * from b_ms_wilayah where level = 3 and parent_id='$kab_id' and nama like '%{$aKeyword}%'";
	$rs=mysql_query($sql);
	$i=0;
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$arfvalue=$rows['id']."|".$rows['nama'];
		$lang3 = "fset_kec(this.lang);";
		if($_REQUEST['x']==2)
		{
			$lang3 = "fset_kec(this.lang);";
		}
	?>
	<tr id="list_kec<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="<?=$lang3;?>">
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
