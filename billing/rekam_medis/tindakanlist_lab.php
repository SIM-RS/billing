<?php 
include("../koneksi/konek.php");
$unitId = 58;
?>    
<table id="tblTindakanHsl" border="0" cellpadding="1" cellspacing="0">
	<tr class="headtable">
		<td width="200" class="tblheaderkiri">Nama Pemeriksaan</td>
		<td width="200" class="tblheader">Nama Kelompok</td>
		<td width="120" class="tblheader">Hasil Normal</td>
	</tr>
<?php 
	$aKeyword=$_REQUEST["aKeyword"];
	$lp = $_REQUEST["lp"];
	
	//unit laboratorium
	
	/*$sql="SELECT a.nama,a.kode,b.*,c.nama_satuan FROM b_ms_tindakan a
INNER JOIN b_ms_normal_lab b ON b.id_tindakan=a.id
INNER JOIN b_ms_satuan_lab c ON c.id=b.id_satuan
WHERE (a.nama LIKE '%$aKeyword%' OR a.kode LIKE '%$aKeyword%') AND lp = '$lp'";*/
	$sql="SELECT nlab.id,nlab.normal1,nlab.normal2,nlab.metode,mslab.nama_satuan,mplab.nama,kel.nama_kelompok 
FROM b_ms_normal_lab nlab INNER JOIN b_ms_pemeriksaan_lab mplab ON nlab.id_pemeriksaan_lab=mplab.id
INNER JOIN b_ms_kelompok_lab kel ON mplab.kelompok_lab_id=kel.id
INNER JOIN b_ms_kelompok_lab mklab ON mplab.kelompok_lab_id=mklab.id INNER JOIN b_ms_satuan_lab mslab ON nlab.id_satuan=mslab.id 
WHERE mplab.nama LIKE '%$aKeyword%' AND lp = '$lp'";
	//echo $sql."<br>";
	$rs = mysql_query($sql);
	
	$i=0;
	while ($rows=mysql_fetch_array($rs))
	{
	//echo $_REQUEST["cito"].$cit;
		$i++;
		 $arfvalue=$rows['id']."|".$rows['id_tindakan']."|".$rows['nama']."|".$rows['normal1']." - ".$rows['normal2']." ".$rows['nama_satuan'];
?>
	<tr id="lstTindHsl<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="fSetHsl(this.lang);">
		<td class="tdisikiri" width="100" align="center">&nbsp;<?php echo $rows['nama']; ?></td>
		<td class="tdisi" width="350" align="left">&nbsp;<?php echo $rows['nama_kelompok']; ?></td>
		<td class="tdisi" width="100" align="center">&nbsp;<?php echo $rows['normal1']." - ".$rows['normal2']." ".$rows['nama_satuan']; ?></td>
	</tr>
	<?php
	}
	mysql_free_result($rs);
	?>	
</table>
<?php 
mysql_close($konek);
?>
