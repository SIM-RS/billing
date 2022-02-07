<?php 
include("../sesi.php");
include("../koneksi/konek.php");
?>
    <table id="tblObat" border="0" cellpadding="1" cellspacing="0">
      <?php 
	  $aKepemilikan=$_REQUEST["aKepemilikan"];
	  $aHarga=$_REQUEST["aHarga"];
	  $aKeyword=$_REQUEST["aKeyword"];
	  $idunit=$_REQUEST["idunit"];
	  $no=$_REQUEST["no"];
	  //echo $no."<br>";
	  if ($aKepemilikan=="0")
	  	/*$sql="select t1.*,ao.OBAT_KODE,ao.OBAT_SATUAN_KECIL,ao.OBAT_NAMA,ak.NAMA from (select OBAT_ID,sum(QTY_STOK) as stok,KEPEMILIKAN_ID from a_penerimaan where UNIT_ID_TERIMA=$idunit and QTY_STOK>0 and STATUS=1 group by OBAT_ID,KEPEMILIKAN_ID) as t1 inner join a_obat ao on t1.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on t1.KEPEMILIKAN_ID=ak.ID where ao.OBAT_NAMA like '$aKeyword%' order by ao.OBAT_NAMA,ak.ID";*/
	  	$sql="select t1.*,ao.OBAT_KODE,ao.OBAT_SATUAN_KECIL,ao.OBAT_NAMA,ak.NAMA from (SELECT OBAT_ID,SUM(qty_stok) AS stok,KEPEMILIKAN_ID FROM a_stok WHERE unit_id=$idunit GROUP BY obat_id,kepemilikan_id) as t1 inner join a_obat ao on t1.obat_id=ao.OBAT_ID inner join a_kepemilikan ak on t1.kepemilikan_id=ak.ID where ao.OBAT_NAMA like '$aKeyword%' order by ao.OBAT_NAMA,ak.ID";
	  else
	  	/*$sql="select t1.*,ao.OBAT_KODE,ao.OBAT_SATUAN_KECIL,ao.OBAT_NAMA,ak.NAMA from (select OBAT_ID,sum(QTY_STOK) as stok,KEPEMILIKAN_ID from a_penerimaan where UNIT_ID_TERIMA=$idunit and QTY_STOK>0 and (KEPEMILIKAN_ID=$aKepemilikan or KEPEMILIKAN_ID=5) and STATUS=1 group by OBAT_ID,KEPEMILIKAN_ID) as t1 inner join a_obat ao on t1.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on t1.KEPEMILIKAN_ID=ak.ID where ao.OBAT_NAMA like '$aKeyword%' order by ao.OBAT_NAMA,ak.ID";*/
	  	$sql="select t1.*,ao.OBAT_KODE,ao.OBAT_SATUAN_KECIL,ao.OBAT_NAMA,ak.NAMA from (SELECT OBAT_ID,SUM(qty_stok) AS stok,KEPEMILIKAN_ID FROM a_stok WHERE unit_id=$idunit and (kepemilikan_id=$aKepemilikan or kepemilikan_id=5) GROUP BY obat_id,kepemilikan_id) as t1 inner join a_obat ao on t1.obat_id=ao.OBAT_ID inner join a_kepemilikan ak on t1.kepemilikan_id=ak.ID where ao.OBAT_NAMA like '$aKeyword%' order by ao.OBAT_NAMA,ak.ID";
	  //echo $sql;
	  $rs=mysqli_query($konek,$sql);
	  $arfvalue="";
	  $i=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
		$cidobat=$rows['OBAT_ID'];
		$ckp_id=$rows['KEPEMILIKAN_ID'];
		$harga_jual=0;
		$harga_beli=0;
		$cstok=$rows['stok'];
		$sql="select FLOOR(max(HARGA_BELI_SATUAN)) HARGA_BELI_SATUAN,FLOOR(max(HARGA_BELI_SATUAN)+(PROFIT*max(HARGA_BELI_SATUAN)/100)) as harga_jual from a_harga where OBAT_ID=$cidobat and KEPEMILIKAN_ID=$aHarga";
		//echo $sql."<br>";
		$rs1=mysqli_query($konek,$sql);
		if ($rows1=mysqli_fetch_array($rs1)){
			$harga_jual=$rows1['harga_jual'];
			$harga_beli=$rows1['HARGA_BELI_SATUAN'];
		}
		
		$arfvalue=$no."*|*".$rows['OBAT_ID']."*|*".$rows['OBAT_NAMA']."*|*".$rows['OBAT_SATUAN_KECIL']."*|*".$harga_jual."*|*".$cstok."*|*".$rows['OBAT_KODE']."*|*".$rows['KEPEMILIKAN_ID']."*|*".$rows['NAMA']."*|*".$harga_beli;
	  	$arfvalue=str_replace('"',chr(3),$arfvalue);
		$arfvalue=str_replace("'",chr(5),$arfvalue);	
		//if (($harga_jual>0) && ($cstok>0)){
		if ($cstok>0){
	  ?>
      <tr id="<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'">
        <td class="tdisikiri" width="70" align="center" onClick="fSetObat('<?php echo $arfvalue; ?>');"><?php echo $rows['OBAT_KODE']; ?></td>
		<td class="tdisi" align="left" onClick="fSetObat('<?php echo $arfvalue; ?>');"><?php echo $rows['OBAT_NAMA']; ?></td>
		<td class="tdisi" width="80" align="center" onClick="fSetObat('<?php echo $arfvalue; ?>');"><?php echo $rows['NAMA']; ?></td>
		<td class="tdisi" width="50" align="center" onClick="fSetObat('<?php echo $arfvalue; ?>');"><?php echo $cstok; ?></td>
        <td class="tdisi" width="70" align="right" onClick="fSetObat('<?php echo $arfvalue; ?>');"><?php echo number_format($harga_jual,0,",","."); ?></td>
        <?php 
		if ($aKepemilikan=="0"){
		?>
        <!--td class="tdisi" width="50" align="center"><input id="btnIur-<?php echo $i; ?>" lang="" type="button" value="..." title="Klik Untuk Memilih Obat Yang Dijamin" onclick="fPilihIur(this);" /></td-->
        <?php 
		}
		?>
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
mysqli_close($konek);
?>