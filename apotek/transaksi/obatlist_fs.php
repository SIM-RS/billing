<?php 
include("../sesi.php");
include("../koneksi/konek.php");
?>
    <table id="tblObat" border="0" cellpadding="1" cellspacing="0">
      <?php 
	  $aKepemilikan=$_REQUEST["aKepemilikan"];
	  $aKeyword=trim($_REQUEST["aKeyword"]);
	  $idunit=$_REQUEST["idunit"];
	  $no=$_REQUEST["no"];
	  //echo $no."<br>";
	  //$sql="select ao.*,(ah.HARGA_BELI_SATUAN*ah.PROFIT/100)+ah.HARGA_BELI_SATUAN as harga_jual from a_obat ao left join a_pabrik ap on ao.PABRIK_ID=ap.PABRIK_ID inner join a_harga ah on ao.OBAT_ID=ah.OBAT_ID where ah.KEPEMILIKAN_ID=$aKepemilikan and ao.OBAT_ISAKTIF=1 and ao.OBAT_NAMA like '$aKeyword%' ORDER BY ao.OBAT_KODE";
	  if ($aKepemilikan=="0"){
	  	$sql="select t1.*,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ak.NAMA from (select ap.OBAT_ID,ap.KEPEMILIKAN_ID,sum(ap.QTY_STOK) as stok from a_penerimaan ap where ap.UNIT_ID_TERIMA=$idunit and ap.QTY_STOK>0 and ap.STATUS=1 group by ap.OBAT_ID,ap.KEPEMILIKAN_ID) as t1 inner join a_obat ao on t1.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on t1.KEPEMILIKAN_ID=ak.ID where ao.OBAT_NAMA like '$aKeyword%' order by ao.OBAT_NAMA";
	  }else{
	  	$sql="select t1.*,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ak.NAMA from (select ap.OBAT_ID,ap.KEPEMILIKAN_ID,sum(ap.QTY_STOK) as stok from a_penerimaan ap where ap.UNIT_ID_TERIMA=$idunit and ap.QTY_STOK>0 and ap.KEPEMILIKAN_ID=1 and ap.STATUS=1 group by ap.OBAT_ID,ap.KEPEMILIKAN_ID) as t1 inner join a_obat ao on t1.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on t1.KEPEMILIKAN_ID=ak.ID where ao.OBAT_NAMA like '$aKeyword%' order by ao.OBAT_NAMA";
	  }
	  //echo $sql;
	  $rs=mysqli_query($konek,$sql);
	  $arfvalue="";
	  $i=0;
	  while ($rows=mysqli_fetch_array($rs)){
		$obat=$rows['OBAT_NAMA']." [ ".$rows['OBAT_KODE']." ]";
		$cidobat=$rows['OBAT_ID'];
		$ckp_id=$rows['KEPEMILIKAN_ID'];
		$harga_jual=0;
		$harga_beli=0;
		//$sql="select (HARGA_BELI_SATUAN+(PROFIT*HARGA_BELI_SATUAN/100)) as harga_jual from a_harga where OBAT_ID=$cidobat and KEPEMILIKAN_ID=$ckp_id";
		$sql="select max(HARGA_BELI_SATUAN) HARGA_BELI_SATUAN,FLOOR(max(HARGA_BELI_SATUAN)+(PROFIT*max(HARGA_BELI_SATUAN)/100)) as harga_jual from a_harga where OBAT_ID=$cidobat and KEPEMILIKAN_ID=$ckp_id";
		//echo $sql."<br>";
		$rs1=mysqli_query($konek,$sql);
		if ($rows1=mysqli_fetch_array($rs1)){
			$harga_jual=$rows1['harga_jual'];
			$harga_beli=$rows1['HARGA_BELI_SATUAN'];
		}
		
		//harga rata2
		$hrg = "select rata2 from a_stok where unit_id=$idunit AND obat_id=$cidobat ";
		//echo $hrg."<br>";
		$hrg1 = mysqli_query($konek,$hrg);
		$hrg2 = mysqli_fetch_array($hrg1);
		$rata2 = $hrg2['rata2'];
		
		
		
		if ($aKepemilikan=="0"){
			$arfvalue=$no."*|*".$rows['OBAT_ID']."*|*".$rows['OBAT_NAMA']."*|*".$rows['OBAT_SATUAN_KECIL']."*|*0*|*".$rows['stok']."*|*".$rows['OBAT_KODE']."*|*".$rows['KEPEMILIKAN_ID']."*|*".$rows['NAMA']."*|*".$harga_jual;
		}else{
			$arfvalue=$no."*|*".$rows['OBAT_ID']."*|*".$rows['OBAT_NAMA']."*|*".$rows['OBAT_SATUAN_KECIL']."*|*0*|*".$rows['stok']."*|*".$rows['OBAT_KODE']."*|*".$rows['KEPEMILIKAN_ID']."*|*".$rows['NAMA']."*|*".$harga_jual;
		}
		
		
		
		
		
		if ($harga_jual>0){
	  	$i++;
	  ?>
      <tr id="<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="fSetObat(this.lang);">
        <td class="tdisikiri" width="300" align="left"><?php echo $obat; ?></td>
        <td class="tdisi" width="80"><?php echo $rows['NAMA']; ?></td>
        <td class="tdisi" width="80"><?php echo "Stok = ".$rows['stok']; ?></td>
      </tr>
		<?php 
		}
		}
		if ($i==0) echo "Tidak Ada Data";
		?>	
	</table>
<?php 
mysqli_close($konek);
?>