<?php 
include("../sesi.php");
include("../koneksi/konek.php");
?>
    <table id="pasienlist_penj" border="0" cellpadding="1" cellspacing="0">
      <?php 
	  $aKeyword=$_REQUEST["aKeyword"];
	  $aOpt=$_REQUEST["aOpt"];
	  $idunit=$_REQUEST["idunit"];
	  $no=$_REQUEST["no"];
	  if ($aOpt=="1")
	  	$sql="select NO_PASIEN, NAMA_PASIEN from a_penjualan WHERE UNIT_ID=$idunit and NAMA_PASIEN like '$aKeyword%' group by NO_PASIEN,NAMA_PASIEN";
	  else
	  	$sql="select NO_PASIEN, NAMA_PASIEN from a_penjualan WHERE UNIT_ID=$idunit and NO_PASIEN = '$aKeyword' group by NO_PASIEN,NAMA_PASIEN";
	  //echo $sql;
	  $rs=mysqli_query($konek,$sql);
	  $arfvalue="";
	  $i=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
		$arfvalue=$no."*|*".$rows['NAMA_PASIEN']."*|*".$rows['NO_PASIEN'];
		 $arfvalue=str_replace('"',chr(3),$arfvalue);
		 $arfvalue=str_replace("'",chr(5),$arfvalue);
		$obat=$rows['NAMA_PASIEN'];
	  ?>
      <tr id="<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="fSetObat(this.lang);">
        <td class="tdisikiri" width="80" align="center">&nbsp;<?php echo $rows['NO_PASIEN']; ?></td>
        <td class="tdisi" width="500" align="left"><?php echo $obat; ?></td>
      </tr>
		<?php
		}
		?>	
	</table>
<?php 
mysqli_close($konek);
?>