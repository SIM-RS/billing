<?php 
include("../koneksi/konek.php");
$pasienId = $_REQUEST['pasienId'];
$kelasId = $_REQUEST['kelasId'];
$unitId = $_REQUEST['unitId'];
$idunit=$_REQUEST["idapotek"];
?>    
    <table id="tblObat" border="0" cellpadding="1" cellspacing="0">
		<tr class="headtable">
		<td width="100" class="tblheaderkiri"> KODE </td>
		<td width="100" class="tblheader"> OBAT </td>
		<td width="80" class="tblheader"> STOK </td>
		<td width="80" class="tblheader"> HARGA JUAL </td>
	</tr>
      <?php 
		$aKepemilikan=$_REQUEST["aKepemilikan"]; 
		$aHarga=$_REQUEST["aHarga"];
		$aKeyword=$_REQUEST["aKeyword"];
		$idunit=$_REQUEST["idapotek"];
		$sql = "SELECT OBAT_ID, OBAT_KODE, OBAT_NAMA, OBAT_SATUAN_KECIL FROM $dbapotek.a_obat 
WHERE $dbapotek.a_obat.OBAT_NAMA LIKE '$aKeyword%' ORDER BY $dbapotek.a_obat.OBAT_NAMA";
		$rs=mysql_query($sql);
		$arfvalue="";
		$i=0;
		$ckp_id=$aKepemilikan;
		while($rows=mysql_fetch_array($rs)){
			$i++;
		  	$cidobat=$rows['OBAT_ID'];
			
			//$sql = "SELECT IFNULL(SUM(ap.QTY_STOK),0) QTY_STOK FROM $dbapotek.a_penerimaan ap WHERE ap.UNIT_ID_TERIMA=$idunit AND ap.OBAT_ID=$cidobat AND ap.KEPEMILIKAN_ID=$ckp_id AND ap.STATUS=1 AND ap.QTY_STOK>0";
			$sql="SELECT IFNULL(SUM(qty_stok),0) QTY_STOK FROM $dbapotek.a_stok WHERE unit_id=$idunit AND obat_id=$cidobat AND kepemilikan_id=$ckp_id";
			$rsSt = mysql_query($sql);
			$rwSt = mysql_fetch_array($rsSt);
			$cstok = $rwSt['QTY_STOK'];
			//echo $rwSt['stok'];
			$harga_jual=0;
			$harga_beli=0;
			$sql="SELECT FLOOR(MAX(harga.HARGA_BELI_SATUAN)) HARGA_BELI_SATUAN, 
					  FLOOR(MAX(harga.HARGA_BELI_SATUAN)+(harga.PROFIT*MAX(harga.HARGA_BELI_SATUAN)/100)) AS harga_jual 
					  FROM $dbapotek.a_harga harga
					  WHERE harga.OBAT_ID = $cidobat AND harga.KEPEMILIKAN_ID=$aHarga ";
			//echo $sql."<br>";
			$rs1=mysql_query($sql);
			if ($rows1=mysql_fetch_array($rs1)){
				$harga_jual=$rows1['harga_jual'];
				$harga_beli=$rows1['HARGA_BELI_SATUAN'];
			}
			
			$arfvalue=$no."*|*".$rows['OBAT_ID']."*|*".$rows['OBAT_NAMA']."*|*".$rows['OBAT_SATUAN_KECIL']."*|*".$harga_jual."*|*".$cstok."*|*".$rows['OBAT_KODE']."*|*".$harga_beli."*|*".$ckp_id;
			$arfvalue=str_replace('"',chr(3),$arfvalue);
			$arfvalue=str_replace("'",chr(5),$arfvalue);	
			if ($harga_jual>0){
	  ?>
      <tr id="<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="fSetObat2(this.lang);">
	  <td class="tdisikiri" width="70" align="center"><?php echo $rows['OBAT_KODE']; ?></td>
		<td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
		<td class="tdisi" width="50" align="right"><?php echo $cstok; ?>&nbsp;</td>
        <td class="tdisi" width="70" align="right"><?php echo number_format($harga_jual,0,",","."); ?>&nbsp;</td>
      </tr>		
		<?php
			}else{
				$i--;
			}
		}
		if ($i==0) echo "Tidak Ada Data";
	?>
	</table>
<?php 
mysql_close($konek);
?>