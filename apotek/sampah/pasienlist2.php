<?php 
include("../sesi.php");
include("../koneksi/konek.php");
?>
    <table id="tblPasien" border="0" cellpadding="1" cellspacing="0">
      <?php 
	  $aKeyword=$_REQUEST["aKeyword"];
	  $sql="select distinct no_rm,nama,alamat from a_pasien where no_rm like '%$aKeyword%'";
	  //echo $sql;
	  $rs=mysqli_query($konek,$sql);
	  $arfvalue="";
	  $i=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
		$cno_rm=$rows['no_rm'];
		$arfvalue=$rows['no_rm']."*|*".$rows['nama'];
	  ?>
      <tr id="<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="fSetPasien(this.lang);">
        <td class="tdisikiri" width="80" align="center"><?php echo $rows['no_rm']; ?></td>
		<td class="tdisi" align="left"><?php echo $rows['nama']; ?></td>
		<td class="tdisi" align="left"><?php echo $rows['alamat']; ?></td>
      </tr>
		<?php
		}
		?>	
	</table>
<?php 
mysqli_close($konek);
?>