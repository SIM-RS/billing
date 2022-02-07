<?php 
include("../sesi.php");
include("../koneksi/konek.php");
?>
    <table id="tblObat" border="0" cellpadding="1" cellspacing="0">
      <?php 
	  $aKepemilikan=$_REQUEST["aKepemilikan"];
	  $aKeyword=$_REQUEST["aKeyword"];
	  $no=$_REQUEST["no"];
	  //echo $no."<br>";
	  if ($aKepemilikan=="0")
	  	$sql="select distinct ao.OBAT_ID,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ak.ID,ak.NAMA,ah.HARGA_BELI_SATUAN from a_obat ao inner join a_harga ah on ao.OBAT_ID=ah.OBAT_ID inner join a_kepemilikan ak on ah.KEPEMILIKAN_ID=ak.ID where ao.OBAT_ISAKTIF=1 and ak.AKTIF=1 and trim(ao.OBAT_NAMA) like '$aKeyword%' ORDER BY ao.OBAT_NAMA,ak.NAMA";
	  else
	  	$sql="select distinct ao.OBAT_ID,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ak.ID,ak.NAMA,ah.HARGA_BELI_SATUAN from a_obat ao inner join a_harga ah on ao.OBAT_ID=ah.OBAT_ID inner join a_kepemilikan ak on ah.KEPEMILIKAN_ID=ak.ID where ak.ID=$aKepemilikan and ao.OBAT_ISAKTIF=1 and ak.AKTIF=1 and trim(ao.OBAT_NAMA) like '$aKeyword%' ORDER BY ao.OBAT_NAMA,ak.NAMA";
	  //echo $sql;
	  $rs=mysqli_query($konek,$sql);
	  $arfvalue="";
	  $i=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
		$arfvalue=$no."*|*".$rows['OBAT_ID']."*|*".$rows['OBAT_NAMA']."*|*".$rows['OBAT_SATUAN_KECIL']."*|*".$rows['OBAT_KODE']."*|*".$rows['ID']."*|*".$rows['NAMA']."*|*".$rows['HARGA_BELI_SATUAN'];
	  ?>
      <tr id="<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="fSetObat1(this.lang);">
        <td class="tdisikiri" width="80" align="left"><?php echo $rows['OBAT_KODE']; ?></td>
        <td align="left" class="tdisi"><?php echo $rows['OBAT_NAMA']; ?></td>
        <td align="left" class="tdisi"><?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
        <td align="left" class="tdisi"><?php echo $rows['NAMA']; ?></td>
      </tr>
		<?php 
		}
		?>	
	</table>
<?php 
mysqli_close($konek);
?>