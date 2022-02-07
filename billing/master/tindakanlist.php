<?php
session_start();
include("../sesi.php");
?>
<?php 
include("../koneksi/konek.php");
$unitId = 58;
?>    
<table id="tblTindakan" border="0" cellpadding="1" cellspacing="0">
	<tr class="headtable">
		<!--td width="100" class="tblheaderkiri"> kode </td-->
		<td width="350" class="tblheader">Nama Pemeriksaan</td>
		<td width="300" class="tblheader">Nama Kelompok</td>
	</tr>
<?php 
	$aKeyword=$_REQUEST["aKeyword"];
	$sql="SELECT a.*,b.nama_kelompok FROM b_ms_pemeriksaan_lab a INNER JOIN b_ms_kelompok_lab b ON a.kelompok_lab_id=b.id WHERE a.nama LIKE '%$aKeyword%'";
	//echo $sql;
	$rs=mysql_query($sql);
	//$arfvalue="";
	//echo $sql;
	$i=0;
	while ($rows=mysql_fetch_array($rs))
	{
	
	//echo $_REQUEST["cito"].$cit;
		$i++;
		$arfvalue=$rows['id']."|".$rows['nama'];
		$lang = "fSetTindakan(this.lang);";
		if($_REQUEST['x']==2){
			$lang = "fSetTindakan1(this.lang);";
		}
?>
	<tr id="lstTind<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="<?=$lang;?>">
		<!--td class="tdisikiri" width="100" align="center">&nbsp;<?php echo $rows['kode']; ?></td-->
		<td class="tdisi" width="350" align="left">&nbsp;<?php echo $rows['nama']; ?></td>
		<td class="tdisi" width="300" align="center">&nbsp;<?php echo $rows['nama_kelompok']; ?></td>
	</tr>
	<?php
	}
	mysql_free_result($rs);
	?>	
</table>
<?php 
mysql_close($konek);
?>
