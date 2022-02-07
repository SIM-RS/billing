<?php 
include("../koneksi/konek.php");
?>
    <table id="tblObat" border="0" cellpadding="1" cellspacing="0">
      <?php 
	  $aKepemilikan=$_REQUEST["aKepemilikan"];
	  $aHarga=$_REQUEST["aHarga"];
	  $aKeyword=$_REQUEST["aKeyword"];
	  $idunit=$_REQUEST["idapotek"];
	  $no=$_REQUEST["no"];
	  //echo $no."<br>";
	  if ($aKepemilikan=="0")
	  	$sql = "SELECT t1.*, $dbapotek.a_obat.OBAT_KODE, $dbapotek.a_obat.OBAT_SATUAN_KECIL, $dbapotek.a_obat.OBAT_NAMA, $dbapotek.a_kepemilikan.NAMA 
			FROM 
				(SELECT $dbapotek.a_penerimaan.OBAT_ID, SUM($dbapotek.a_penerimaan.QTY_STOK) AS stok, $dbapotek.a_penerimaan.KEPEMILIKAN_ID FROM $dbapotek.a_penerimaan WHERE $dbapotek.a_penerimaan.UNIT_ID_TERIMA = $idunit AND $dbapotek.a_penerimaan.QTY_STOK > 0 AND $dbapotek.a_penerimaan.STATUS = 1 GROUP BY $dbapotek.a_penerimaan.OBAT_ID, $dbapotek.a_penerimaan.KEPEMILIKAN_ID) AS t1 
			INNER JOIN $dbapotek.a_obat ON t1.OBAT_ID = $dbapotek.a_obat.OBAT_ID 
			INNER JOIN $dbapotek.a_kepemilikan ON t1.KEPEMILIKAN_ID = $dbapotek.a_kepemilikan.ID 
			WHERE $dbapotek.a_obat.OBAT_NAMA 
			LIKE '$aKeyword%' 
			ORDER BY $dbapotek.a_obat.OBAT_NAMA, $dbapotek.a_kepemilikan.ID";
	  else
	  	$sql = "SELECT t1.*, $dbapotek.a_obat.OBAT_KODE, $dbapotek.a_obat.OBAT_SATUAN_KECIL, $dbapotek.a_obat.OBAT_NAMA, $dbapotek.a_kepemilikan.NAMA 
				FROM 
					(SELECT $dbapotek.a_penerimaan.OBAT_ID, SUM($dbapotek.a_penerimaan.QTY_STOK) AS stok, $dbapotek.a_penerimaan.KEPEMILIKAN_ID FROM $dbapotek.a_penerimaan WHERE $dbapotek.a_penerimaan.UNIT_ID_TERIMA = $idunit AND $dbapotek.a_penerimaan.QTY_STOK > 0 AND ($dbapotek.a_penerimaan.KEPEMILIKAN_ID = $aKepemilikan OR $dbapotek.a_penerimaan.KEPEMILIKAN_ID = 5) AND $dbapotek.a_penerimaan.STATUS = 1 GROUP BY $dbapotek.a_penerimaan.OBAT_ID, $dbapotek.a_penerimaan.KEPEMILIKAN_ID) AS t1 
				INNER JOIN $dbapotek.a_obat ON t1.OBAT_ID = $dbapotek.a_obat.OBAT_ID 
				INNER JOIN $dbapotek.a_kepemilikan ON t1.KEPEMILIKAN_ID = $dbapotek.a_kepemilikan.ID 
				WHERE $dbapotek.a_obat.OBAT_NAMA 
				LIKE '$aKeyword%' 
				ORDER BY $dbapotek.a_obat.OBAT_NAMA, $dbapotek.a_kepemilikan.ID";
	  //echo $sql;
	  $rs=mysql_query($sql);
	  $arfvalue="";
	  $i=0;
	  while ($rows=mysql_fetch_array($rs)){
	  	$i++;
		$cidobat=$rows['OBAT_ID'];
		$ckp_id=$rows['KEPEMILIKAN_ID'];
		//$harga_jual=$rows['harga_jual'];
		$harga_jual=0;
		//$harga_beli=$rows['HARGA_BELI_SATUAN'];
		$harga_beli=0;
		$cstok=$rows['stok'];
/*		$cstok=0;
		$sql="SELECT OBAT_ID,SUM(QTY_STOK) AS stok,KEPEMILIKAN_ID FROM a_penerimaan WHERE UNIT_ID_TERIMA=$idunit AND OBAT_ID=$cidobat AND QTY_STOK>0 AND KEPEMILIKAN_ID=$ckp_id AND STATUS=1 GROUP BY OBAT_ID,KEPEMILIKAN_ID";
		//echo $sql."<br>";
		$rs1=mysql_query($sql);
		if ($rows1=mysql_fetch_array($rs1)){
			$cstok=$rows1['stok'];
		}
		if (($aKepemilikan=="0") && ($aHarga!=$ckp_id)){
			$sql2="select max(HARGA_BELI_SATUAN) HARGA_BELI_SATUAN,FLOOR(max(HARGA_BELI_SATUAN)+(PROFIT*max(HARGA_BELI_SATUAN)/100)) as harga_jual from a_harga where OBAT_ID=$cidobat and KEPEMILIKAN_ID=$aHarga";
			$rs1=mysql_query($sql2);
			if ($rows1=mysql_fetch_array($rs1)){
				$harga_jual=$rows1['harga_jual'];
				$harga_beli=$rows1['HARGA_BELI_SATUAN'];
			}			
		}*/
		$sql="select max(HARGA_BELI_SATUAN) HARGA_BELI_SATUAN,FLOOR(max(HARGA_BELI_SATUAN)+(PROFIT*max(HARGA_BELI_SATUAN)/100)) as harga_jual from a_harga where OBAT_ID=$cidobat and KEPEMILIKAN_ID=$aHarga";
		//echo $sql."<br>";
		$rs1=mysql_query($sql);
		if ($rows1=mysql_fetch_array($rs1)){
			$harga_jual=$rows1['harga_jual'];
			$harga_beli=$rows1['HARGA_BELI_SATUAN'];
		}
/*		if (($harga_jual==0)&&($aKepemilikan=="0")){
			$sql2="select max(HARGA_BELI_SATUAN) HARGA_BELI_SATUAN,FLOOR(max(HARGA_BELI_SATUAN)+(PROFIT*max(HARGA_BELI_SATUAN)/100)) as harga_jual from a_harga where OBAT_ID=$cidobat and KEPEMILIKAN_ID=$aHarga";
			$rs1=mysql_query($sql2);
			if ($rows1=mysql_fetch_array($rs1)){
				$harga_jual=$rows1['harga_jual'];
				$harga_beli=$rows1['HARGA_BELI_SATUAN'];
			}			
		}*/
		$arfvalue=$no."*|*".$rows['OBAT_ID']."*|*".$rows['OBAT_NAMA']."*|*".$rows['OBAT_SATUAN_KECIL']."*|*".$harga_jual."*|*".$cstok."*|*".$rows['OBAT_KODE']."*|*".$rows['KEPEMILIKAN_ID']."*|*".$rows['NAMA']."*|*".$harga_beli;
	  	$arfvalue=str_replace('"',chr(3),$arfvalue);
		$arfvalue=str_replace("'",chr(5),$arfvalue);	
		if ($harga_jual>0){
	  ?>
      <tr id="<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="fSetObat(this.lang);">
        <td class="tdisikiri" width="70" align="center"><?php echo $rows['OBAT_KODE']; ?></td>
		<td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
		<td class="tdisi" width="80" align="center"><?php echo $rows['NAMA']; ?></td>
		<td class="tdisi" width="50" align="center"><?php echo $cstok; ?></td>
        <td class="tdisi" width="70" align="center"><?php echo number_format($harga_jual,0,",","."); ?></td>
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