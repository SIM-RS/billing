<?php 
include("../koneksi/konek.php");
?>
    <table id="tblObat" border="0" cellpadding="1" cellspacing="0">
      <?php 
	  $aKeyword=$_REQUEST["aKeyword"];
	  $no=$_REQUEST["no"];

	  $sql="select ao.* from $dbapotek.a_obat ao where ao.OBAT_ISAKTIF=1 and trim(ao.OBAT_NAMA) like '%$aKeyword%' ORDER BY ao.OBAT_NAMA";

	  $rs=mysql_query($sql);
	  $arfvalue="";
	  $i=0;
	  while ($rows=mysql_fetch_array($rs)){
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
mysql_close($konek);
?>