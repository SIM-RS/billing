<?php 
include("../koneksi/konek.php");
$pasienId = $_REQUEST['pasienId'];
$kelasId = $_REQUEST['kelasId'];
$unitId = $_REQUEST['unitId'];
$idunit=$_REQUEST["idapotek"];

	
	$aKeyword=$_REQUEST["aKeyword"];
	$id_unit=$_REQUEST["id_unit"];
	
	$q = "SELECT au.UNIT_ID,au.UNIT_NAME,au.kdunitfar FROM $dbapotek.a_unit AS au
	INNER JOIN $dbbilling.b_ms_unit AS bu ON bu.kode=au.kdunitfar WHERE bu.id='$id_unit'";
	$s = mysql_query($q);
	if($s === FALSE) { 
		die(mysql_error()); // TODO: better error handling
	}
	$d = mysql_fetch_array($s);
	$UNIT_ID = $d['UNIT_ID'];
	
	$sql = "SELECT 
	ap.ID,
	ap.OBAT_ID,
	ap.UNIT_ID_TERIMA,
	ao.OBAT_KODE,
	ao.OBAT_NAMA,
	ao.OBAT_SATUAN_KECIL,
	ak.ID as KEPEMILIKAN_ID,ak.NAMA,
	SUM(ap.QTY_STOK) AS STOK,
	ap.HARGA_BELI_SATUAN
	FROM $dbapotek.a_penerimaan AS ap 
	INNER JOIN $dbapotek.a_obat ao ON ap.OBAT_ID=ao.OBAT_ID
	INNER JOIN $dbapotek.a_kepemilikan AS ak ON ap.KEPEMILIKAN_ID=ak.ID
	WHERE ap.UNIT_ID_TERIMA='$UNIT_ID' AND ap.QTY_STOK>0 AND ap.STATUS=1 AND ao.OBAT_NAMA LIKE '%$aKeyword%' GROUP BY ap.OBAT_ID ORDER BY ao.OBAT_NAMA";
	$query = mysql_query($sql);
	$jum = mysql_num_rows($query);
	if($jum==0)
	{
		 echo "Tidak Ada Data";
	}
	else
	{ //echo $sql;
?>    
    <table id="tblObat" border="0" cellpadding="1" cellspacing="0">
		<tr class="headtable">
		<td width="100" class="tblheaderkiri"> KODE </td>
		<td width="100" class="tblheader"> NAMA OBAT </td>
		<td width="125" class="tblheader"> KEPEMILIKAN </td>
        <td width="70" class="tblheader"> SATUAN </td>
		<td width="66" class="tblheader"> STOK </td>
		<!-- 19/02/19 - Hafiz / Untuk Pemakaian BHP, Menambahkan Field Harga dan Stok -->
		<td width="66" class="tblheader"> HARGA BELI SATUAN </td>
	</tr>
      <?
	  		$i=1;
			while($rows = mysql_fetch_array($query))
			{
			  $arfvalue=$no."*|*".$rows['ID']."*|*".$rows['OBAT_ID']."*|*".$rows['UNIT_ID_TERIMA']."*|*".$rows['OBAT_NAMA']."*|*".$rows['OBAT_KODE']."*|*".$rows['OBAT_NAMA']."*|*".$rows['NAMA']."*|*".$rows['STOK']."*|*".$rows['HARGA_BELI_SATUAN']."*|*".$rows['UNIT_ID_TERIMA']."*|*".$rows['KEPEMILIKAN_ID'];
	  ?>
      <tr id="<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="fSetObat_bhp(this.lang);">
	  <td class="tdisikiri" width="60" align="center"><?php echo $rows['OBAT_KODE']; ?></td>
		<td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
		<td class="tdisi" width="125"><?php echo $rows['NAMA']; ?></td>
        <td class="tdisi" width="70"><?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
        <td class="tdisi" width="66" align="right"><?php echo $rows['STOK']; ?></td>
				<!-- 19/02/19 - Hafiz / Untuk Pemakaian BHP, Menambahkan Field Harga dan Stok -->
        <td class="tdisi" width="66" align="right"><?php echo $rows['HARGA_BELI_SATUAN']; ?></td>
      </tr>		
		<?php
		$i++;
		}
		
		?>
	</table>
<?php
}
mysql_close($konek);
?>