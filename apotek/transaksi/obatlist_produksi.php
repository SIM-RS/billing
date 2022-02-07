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
	  $tipe=$_REQUEST["tipe"];
	  //echo $no."<br>";
	  //$sql="select ao.*,(ah.HARGA_BELI_SATUAN*ah.PROFIT/100)+ah.HARGA_BELI_SATUAN as harga_jual from a_obat ao left join a_pabrik ap on ao.PABRIK_ID=ap.PABRIK_ID inner join a_harga ah on ao.OBAT_ID=ah.OBAT_ID where ah.KEPEMILIKAN_ID=$aKepemilikan and ao.OBAT_ISAKTIF=1 and ao.OBAT_NAMA like '$aKeyword%' ORDER BY ao.OBAT_KODE";
	  if ($aKepemilikan=="0"){
	  	$sql="select t1.*,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ak.NAMA from (select ap.OBAT_ID,ap.KEPEMILIKAN_ID,sum(ap.QTY_STOK) as stok from a_penerimaan ap where ap.UNIT_ID_TERIMA=$idunit and ap.QTY_STOK>0 and ap.STATUS=1 group by ap.OBAT_ID,ap.KEPEMILIKAN_ID) as t1 inner join a_obat ao on t1.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on t1.KEPEMILIKAN_ID=ak.ID where ao.OBAT_NAMA like '$aKeyword%' order by ao.OBAT_NAMA";
	  }else{
	  	$sql="select t1.*,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ak.NAMA from (select ap.OBAT_ID,ap.KEPEMILIKAN_ID,sum(ap.QTY_STOK) as stok from a_penerimaan ap where ap.UNIT_ID_TERIMA=$idunit and ap.QTY_STOK>0 and ap.KEPEMILIKAN_ID=$aKepemilikan and ap.STATUS=1 group by ap.OBAT_ID,ap.KEPEMILIKAN_ID) as t1 inner join a_obat ao on t1.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on t1.KEPEMILIKAN_ID=ak.ID where ao.OBAT_NAMA like '$aKeyword%' order by ao.OBAT_NAMA";
	  }
	  //echo $sql;
	  $rs=mysqli_query($konek,$sql);
	  $arfvalue="";
	  $i=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
		if ($aKepemilikan=="0"){
			$arfvalue=$no."*|*".$rows['OBAT_ID']."*|*".$rows['OBAT_NAMA']."*|*".$rows['OBAT_SATUAN_KECIL']."*|*0*|*".$rows['stok']."*|*".$rows['OBAT_KODE']."*|*".$rows['KEPEMILIKAN_ID']."*|*".$rows['NAMA'];
		}else{
			$arfvalue=$no."*|*".$rows['OBAT_ID']."*|*".$rows['OBAT_NAMA']."*|*".$rows['OBAT_SATUAN_KECIL']."*|*0*|*".$rows['stok']."*|*".$rows['OBAT_KODE']."*|*".$rows['KEPEMILIKAN_ID']."*|*".$rows['NAMA'];
		}
//		 $arfvalue=str_replace('"',chr(3),$arfvalue);
//		 $arfvalue=str_replace("'",chr(5),$arfvalue);
//		 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
		//if (isset($rows['PABRIK']))
	  	//	$obat=$rows['OBAT_NAMA']." [ ".$rows['OBAT_KODE']." - ".$rows['PABRIK']." ]";
		//else
			$obat=$rows['OBAT_NAMA']." [ ".$rows['OBAT_KODE']." ]";
//		$arfhapus="act*-*delete*|*obat_id*-*".$rows['OBAT_ID'];
	  ?>
      <tr id="<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="<?php if ($tipe=="1"){?>fSetObat(this.lang);<?php }else{?>fSetObat1(this.lang);<?php }?>">
        <td class="tdisikiri" width="300" align="left"><?php echo $obat; ?></td>
        <td class="tdisi" width="80"><?php echo $rows['NAMA']; ?></td>
        <td class="tdisi" width="80"><?php echo "Stok = ".$rows['stok']; ?></td>
      </tr>
		<?php 
		}
		?>	
	</table>
<?php 
mysqli_close($konek);
?>