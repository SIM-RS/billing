<?php 
include("../sesi.php");
include("../koneksi/konek.php");
?>
    <table id="tblObat" border="0" cellpadding="1" cellspacing="0">
      <?php 
	  $aKeyword=$_REQUEST["aKeyword"];
	  $idunit=$_REQUEST["idunit"];
	  $no=$_REQUEST["no"];
	  //$sql="select t1.*,ao.OBAT_KODE,ao.OBAT_SATUAN_KECIL,ao.OBAT_NAMA,ak.NAMA from (select OBAT_ID,sum(QTY_STOK) as stok,ID,KEPEMILIKAN_ID from a_penerimaan where UNIT_ID_TERIMA=$idunit and QTY_STOK>0 and STATUS=1 group by OBAT_ID) as t1 inner join a_obat ao on t1.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on t1.KEPEMILIKAN_ID=ak.ID";
	  $sql="Select a_penerimaan.*, a_obat.OBAT_KODE, a_obat.OBAT_NAMA, a_obat.OBAT_SATUAN_KECIL, a_kepemilikan.NAMA From a_penerimaan 
	  Inner Join a_obat ON a_penerimaan.OBAT_ID = a_obat.OBAT_ID
	  Inner Join a_kepemilikan ON a_penerimaan.KEPEMILIKAN_ID = a_kepemilikan.ID
	  Where a_penerimaan.USER_ID_TERIMA =$idunit AND a_penerimaan.QTY_STOK >0 AND a_penerimaan.STATUS =1";
	  //echo $sql;
	  $rs=mysqli_query($konek,$sql);
	  $arfvalue="";
	  $i=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
		$arfvalue=$no."*|*".$rows['OBAT_ID']."*|*".$rows['OBAT_NAMA']."*|*".$rows['NAMA']."*|*".$rows['OBAT_SATUAN_KECIL']."*|*".$rows['QTY_STOK']."*|*".$rows['ID'];
	  ?>
      <tr id="<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="fSetObat(this.lang);">
        <td class="tdisikiri" width="80" align="center"><?php echo $rows['OBAT_KODE']; ?></td>
		<td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
		<td class="tdisi" width="80" align="center"><?php echo $rows['NAMA']; ?></td>
		<td class="tdisi" width="70" align="center"><?php echo $rows['QTY_STOK']; ?></td>
      </tr>		
		<?php
		}
		?>	
	</table>
<?php 
mysqli_close($konek);
?>