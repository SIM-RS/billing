<?php 
include("../sesi.php");
include("../koneksi/konekMssql.php");
?>
    <table id="tblPasien" border="0" cellpadding="1" cellspacing="0">
      <?php 
	  $aKeyword=$_REQUEST["aKeyword"];
	  //$sql="select distinct no_rm,nama,alamat from a_pasien where no_rm like '%$aKeyword%'";
	  $sql="select t1.*,TMPersonel.Nama as dokter,TMTempatLayanan.Kode as KodePoli,TMTempatLayanan.Nama as Poli from (select TMPasien.NoRM,TMPasien.Nama,TMPasien.Alamat,max(TTKunjungan.Kode) as Kode,TTKunjungan.KodePenjamin from TTKunjungan inner join TMPasien on TTKunjungan.KodePasien=TMPasien.Kode where TMPasien.Nama like '$aKeyword%' and TTKunjungan.Pulang=0 group by TMPasien.NoRM,TMPasien.Nama,TMPasien.Alamat,TTKunjungan.KodePenjamin) as t1 inner join TTKunjunganTL on t1.Kode=TTKunjunganTL.KodeKunjungan inner join TMPersonel on TTKunjunganTL.KodePersonel=TMPersonel.Kode inner join TMTempatLayanan on TTKunjunganTL.KodeTempatLayanan=TMTempatLayanan.Kode";
	  //echo $sql;
	  $rs=mssql_query($sql);
	  $arfvalue="";
	  $i=0;
	  while ($rows=mssql_fetch_array($rs)){
	  	$i++;
		$cno_rm=$rows['NoRM'];
		$arfvalue=$rows['NoRM']."*|*".$rows['Nama']."*|*".$rows['Kode']."*|*".$rows['KodePenjamin']."*|*".$rows['dokter']."*|*".$rows['KodePoli']."*|*".$rows['Poli'];
	  ?>
      <tr id="<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="fSetPasien(this.lang);">
        <td class="tdisikiri" width="80" align="center"><?php echo $rows['NoRM']; ?></td>
		<td class="tdisi" align="left"><?php echo $rows['Nama']; ?></td>
		<td class="tdisi" align="left"><?php echo $rows['Alamat']; ?></td>
		<td class="tdisi" align="left"><?php echo $rows['Poli']; ?></td>
		<td class="tdisi" align="left"><?php echo $rows['dokter']; ?></td>
      </tr>
		<?php
		}
		?>	
	</table>
<?php 
mssql_close($konek2);
?>