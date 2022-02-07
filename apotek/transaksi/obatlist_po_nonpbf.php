<?php 
include("../sesi.php");
include("../koneksi/konek.php");
?>
    <table id="tblObat" border="0" cellpadding="1" cellspacing="0">
      <?php 
	  $aKepemilikan=$_REQUEST["aKepemilikan"];
	  $aKeyword=$_REQUEST["aKeyword"];
	  $idunit=$_REQUEST["idunit"];
	  $no=$_REQUEST["no"];
	  //echo $no."<br>";
	  $sql="select ao.* from a_obat ao where ao.OBAT_ISAKTIF=1 and trim(ao.OBAT_NAMA) like '$aKeyword%' ORDER BY ao.OBAT_NAMA";
	  //echo $sql;
	  $rs=mysqli_query($konek,$sql);
	  $arfvalue="";
	  $i=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;	
		$arfvalue=$no."*|*".$rows['OBAT_ID']."*|*".$rows['OBAT_NAMA']."*|*".$rows['OBAT_SATUAN_KECIL']."*|*0*|*".$rows['stok']."*|*".$rows['OBAT_KODE']."*|*".$rows['KEPEMILIKAN_ID']."*|*".$rows['NAMA'];
			$obat=$rows['OBAT_NAMA']." [ ".$rows['OBAT_KODE']." ]";
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