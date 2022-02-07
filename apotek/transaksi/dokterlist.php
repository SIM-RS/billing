<?php 
include("../sesi.php");
include("../koneksi/konek.php");
?>
    <table id="tblPasien" border="0" cellpadding="1" cellspacing="0">
      <?php 
	  $aKeyword=$_REQUEST["aKeyword"];
	  //$sql="select distinct no_rm,nama,alamat from a_pasien where no_rm like '%$aKeyword%'";
	  //$sql="select * from a_pegawai where NAMA like '$aKeyword%' and KATEGORI=1 and ISAKTIF=1";
	  $sql="SELECT * FROM $dbbilling.b_ms_pegawai WHERE nama LIKE '$aKeyword%' AND spesialisasi_id NOT IN (0,129,182,71,10,65) AND aktif=1";
	  //echo $sql;
	  $rs=mysqli_query($konek,$sql);
	  $arfvalue="";
	  $i=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
		$arfvalue=$rows["nama"];
	  ?>
      <tr id="<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="fSetPasien(this.lang,2);">
        <td class="tdisikiri" width="30" align="center"><?php echo $i; ?></td>
		<td class="tdisi" align="left"><?php echo $arfvalue; ?></td>
      </tr>
		<?php
		}
		?>	
	</table>
<?php 
mysqli_close($konek);
?>