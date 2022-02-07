<?php
session_start();
include("../sesi.php");
include("../koneksi/konek.php");
$wilayah_tipe = $_REQUEST['wilayah_tipe'];
$arr_wilayah = array('','Propinsi','Kabupaten / Kota','Kecamatan','Kelurahan / Desa');
?>    
<table id="tblautocomplete" border="0" cellpadding="1" cellspacing="0">
	<tr class="headtable">
		<td width="350" class="tblheader"><?php echo $arr_wilayah[$wilayah_tipe]; ?></td>
	</tr>
	<?php 
	$aKeyword = $_REQUEST["aKeyword"];
	$sql="select * from b_ms_wilayah where level = {$wilayah_tipe} and nama like '%{$aKeyword}%'";
	$rs=mysql_query($sql);
	$i=0;
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$arfvalue=$rows['id']."|".$rows['nama'];
		$lang = "fset(this.lang);";
		if($_REQUEST['x']==2){
			$lang = "fset(this.lang);";
		}
	?>
	<tr id="lstTind<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="<?=$lang;?>">
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
