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
	  
	  	$sql="select ao.OBAT_ID,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,IFNULL(asa.rata2,0) rata2 from a_obat ao 
		LEFT JOIN (SELECT *from a_stok where UNIT_ID = $idunit ) asa ON ao.OBAT_ID = asa.OBAT_ID
		where ao.OBAT_NAMA like '$aKeyword%' and OBAT_ISAKTIF=1 order by ao.OBAT_NAMA 
		
		";

	  $rs=mysqli_query($konek,$sql);
	  $arfvalue="";
	  $i=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
		//if ($aKepemilikan=="0"){
		//	$arfvalue=$no."*|*".$rows['OBAT_ID']."*|*".$rows['OBAT_NAMA']."*|*".$rows['OBAT_SATUAN_KECIL']."*|*".$rows['OBAT_KODE'];
		//}else{
			$arfvalue=$no."*|*".$rows['OBAT_ID']."*|*".$rows['OBAT_NAMA']."*|*".$rows['OBAT_SATUAN_KECIL']."*|*".$rows['OBAT_KODE']."*|*".$rows['NAMA']."*|*".$rows['KEPEMILIKAN_ID']."*|*".$rows['rata2'];
		//}
	  ?>
      <tr id="<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="fSetObat(this.lang);">
        <td class="tdisikiri" width="80"><?php echo $rows['OBAT_KODE']; ?></td>
        <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
        <td class="tdisi" width="80"><?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
       <td class="tdisi" width="90"><?php echo $rows['rata2']; ?></td>
        <!--<td class="tdisi" width="60"><?php //echo $rows['stok']; ?></td-->
      </tr>
		<?php 
		}
		?>	
	</table>
<?php 
mysqli_close($konek);
?>