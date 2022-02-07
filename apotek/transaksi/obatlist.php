<?php 
include("../sesi.php");
include("../koneksi/konek.php");
?>
    <table id="tblObat" border="0" cellpadding="1" cellspacing="0">
      <?php 
	//  $aKepemilikan=$_REQUEST["aKepemilikan"];
	  $aKepemilikan=mysqli_real_escape_string($konek,$_REQUEST['aKepemilikan']);
	//  $aKeyword=$_REQUEST["aKeyword"];
	  $aKeyword=mysqli_real_escape_string($konek,$_REQUEST['aKeyword']);
	 // $idunit=$_REQUEST["idunit"];
	  $idunit=mysqli_real_escape_string($konek,$_REQUEST['idunit']);
	 // $no=$_REQUEST["no"];
	  $no=mysqli_real_escape_string($konek,$_REQUEST['no']);
	  //echo $no."<br>";
	  //$sql="select ao.*,(ah.HARGA_BELI_SATUAN*ah.PROFIT/100)+ah.HARGA_BELI_SATUAN as harga_jual from a_obat ao left join a_pabrik ap on ao.PABRIK_ID=ap.PABRIK_ID inner join a_harga ah on ao.OBAT_ID=ah.OBAT_ID where ah.KEPEMILIKAN_ID=$aKepemilikan and ao.OBAT_ISAKTIF=1 and ao.OBAT_NAMA like '$aKeyword%' ORDER BY ao.OBAT_KODE";
	  if ($aKepemilikan=="0"){
	  	$sql="select ao.* from a_obat ao where ao.OBAT_ISAKTIF=1 and trim(ao.OBAT_NAMA) like '$aKeyword%' ORDER BY ao.OBAT_NAMA";
	  }else{
	  	$sql="select t1.*,if (t2.jml is null,0,t2.jml) as stok from (select ao.*,if ((ah.HARGA_BELI_SATUAN*ah.PROFIT/100)+ah.HARGA_BELI_SATUAN is null,0,(ah.HARGA_BELI_SATUAN*ah.PROFIT/100)+ah.HARGA_BELI_SATUAN) as harga_jual from a_obat ao left join a_pabrik ap on ao.PABRIK_ID=ap.PABRIK_ID left join a_harga ah on ao.OBAT_ID=ah.OBAT_ID where ao.KEPEMILIKAN_ID=$aKepemilikan and ao.OBAT_ISAKTIF=1 and trim(ao.OBAT_NAMA) like '$aKeyword%' ORDER BY ao.OBAT_NAMA) as t1 left join (select OBAT_ID,sum(QTY_STOK) as jml from a_penerimaan where UNIT_ID_TERIMA=$idunit and KEPEMILIKAN_ID=$aKepemilikan  and (STATUS=1 or STATUS=3) group by OBAT_ID) as t2 on t1.OBAT_ID=t2.OBAT_ID";
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
			$arfvalue=$no."*|*".$rows['OBAT_ID']."*|*".$rows['OBAT_NAMA']."*|*".$rows['OBAT_SATUAN_KECIL']."*|*".$rows['harga_jual']."*|*".$rows['stok']."*|*".$rows['OBAT_KODE']."*|*".$rows['KEPEMILIKAN_ID']."*|*".$rows['NAMA'];
		}
//		 $arfvalue=str_replace('"',chr(3),$arfvalue);
//		 $arfvalue=str_replace("'",chr(5),$arfvalue);
//		 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
		//if (isset($rows['PABRIK']))
	  	//	$obat=$rows['OBAT_NAMA']." [ ".$rows['OBAT_KODE']." - ".$rows['PABRIK']." ]";
		//else
		//if ($rows['stok']>0){
			$obat=$rows['OBAT_NAMA']." [ ".$rows['OBAT_KODE']." ]";
			//}
//		$arfhapus="act*-*delete*|*obat_id*-*".$rows['OBAT_ID'];
	  ?>
      <tr id="<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="fSetObat(this.lang);">
        <td class="tdisikiri" width="500" align="left"><?php echo $obat; ?></td>
      </tr>
		<?php
		}
		?>	
	</table>
<?php 
mysqli_close($konek);
?>