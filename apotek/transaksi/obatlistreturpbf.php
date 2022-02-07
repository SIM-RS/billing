<?php 
include("../sesi.php");
include("../koneksi/konek.php");
?>
    <table id="tblObat" border="0" cellpadding="1" cellspacing="0">
      <tr class="headtable">
        <td class="tblheaderkiri" width="80" align="center">Tgl Terima</td>
        <td class="tblheader" width="120" align="center">No Faktur</td>
		<td class="tblheader" width="80" align="center">Kode Obat</td>
		<td class="tblheader" align="left">Nama Obt</td>
		<td class="tblheader" width="80" align="center">Satuan</td>
		<td class="tblheader" width="70" align="right">Harga Beli</td>
		<td class="tblheader" width="40" align="center">Diskon</td>
      </tr>		
      <?php 
	  $aPbf=$_REQUEST["aPbf"];
	  $aKeyword=$_REQUEST["aKeyword"];
	  $idunit=$_REQUEST["idunit"];
	  $no=$_REQUEST["no"];
	  //echo $no."<br>";
	  $sql="SELECT DATE_FORMAT(ap.TANGGAL,'%d/%m/%Y') AS tgl1,ap.ID,ap.NOBUKTI,ap.KEPEMILIKAN_ID,ap.OBAT_ID,ap.QTY_SATUAN,ap.QTY_RETUR,ap.HARGA_BELI_SATUAN,ap.DISKON,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ak.NAMA 
			FROM a_penerimaan ap INNER JOIN a_obat ao ON ap.OBAT_ID=ao.OBAT_ID INNER JOIN a_kepemilikan ak ON ap.KEPEMILIKAN_ID=ak.ID 
			WHERE ap.PBF_ID=$aPbf AND ap.UNIT_ID_KIRIM=0 AND ap.UNIT_ID_TERIMA=$idunit AND ap.TIPE_TRANS=0 AND ao.OBAT_NAMA LIKE '$aKeyword%' ORDER BY ap.ID DESC";
	  //echo $sql;
	  $rs=mysqli_query($konek,$sql);
	  $arfvalue="";
	  $i=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
		$ctgl=$rows['tgl1'];
		$cidp=$rows['ID'];
		$cidobat=$rows['OBAT_ID'];
		$ckp_id=$rows['KEPEMILIKAN_ID'];
		$cnamaobat=$rows['OBAT_NAMA'];
		$cnkdobat=$rows['OBAT_KODE'];
		$cnsatobat=$rows['OBAT_SATUAN_KECIL'];
		$ckp_nama=$rows['NAMA'];
		$cnfaktur=$rows['NOBUKTI'];
		$cqty=$rows['QTY_SATUAN'];
		$cqtyr=$rows['QTY_RETUR'];
		$cqtys=$cqty-$cqtyr;
		$hpp=$rows['HARGA_BELI_SATUAN'];
		$cdiskon=$rows['DISKON'];
		$arfvalue=$no."*|*".$cidp."*|*".$cidobat."*|*".$ckp_id."*|*".$ctgl."*|*".$cnamaobat."*|*".$ckp_nama."*|*".$cnfaktur."*|*".$cqty."*|*".$cqtyr."*|*".$hpp."*|*".$cdiskon."*|*".$cqtys;
	  ?>
      <tr id="<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="fSetObat(this.lang);">
        <td class="tdisikiri" width="80" align="center"><?php echo $ctgl; ?></td>
        <td class="tdisi" width="120" align="center"><?php echo $cnfaktur; ?></td>
		<td class="tdisi" width="80" align="center"><?php echo $cnkdobat; ?></td>
		<td class="tdisi" align="left">&nbsp;<?php echo $cnamaobat; ?>&nbsp;</td>
		<td class="tdisi" width="80" align="center"><?php echo $cnsatobat; ?></td>
		<td class="tdisi" width="70" align="right"><?php echo number_format($hpp,0,",","."); ?></td>
		<td class="tdisi" width="40" align="center"><?php echo $cdiskon."%"; ?></td>
      </tr>		
		<?php
		}
		?>	
	</table>
<?php 
mysqli_close($konek);
?>