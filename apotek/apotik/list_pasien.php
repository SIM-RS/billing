<?php 
include("../sesi.php"); 
include("../koneksi/konekBilling.php");

function tglSQL($tgl){
   $t=explode(" ",$tgl);
   $t=explode("-",$t[0]);
   $t=$t[2].'-'.$t[1].'-'.$t[0];
   return $t;
}

?>

    <table id="tblPasien" border="0" cellpadding="1" cellspacing="0">
      <tr style="font-size:12px; font-weight:bold; background-color:#4E98C8; color:#FFFF00">
      	<td width="40" style="border-left:1px solid; border-top:1px solid; border-bottom:1px solid;" align="center">Tgl Kunj.</td>
        <td width="100" style="border-left:1px solid; border-top:1px solid; border-bottom:1px solid;" align="center">Tempat Layanan</td>
        <td width="70" style="border-left:1px solid; border-top:1px solid; border-bottom:1px solid;" align="center">No RM</td>
        <td width="150" style="border-left:1px solid; border-top:1px solid; border-bottom:1px solid;" align="center">Nama Pasien</td>
        <td width="80" style="border-left:1px solid; border-top:1px solid; border-bottom:1px solid;" align="center">Penjamin</td>
        <td width="200" style="border-left:1px solid; border-top:1px solid; border-bottom:1px solid; border-right:1px solid;" align="center">Alamat</td>
      </tr>
	  <?php 
	  
	  $tgl1=tglSQL($_REQUEST["tgl_d"]);
	  $tgl2=tglSQL($_REQUEST["tgl_s"]);
	  $aKeyword=$_REQUEST["aKeyword"];
	  $pil=$_REQUEST["pil"];
	  
	  if($pil=='1'){
	  $sql = "SELECT DISTINCT 
  k.id kunjungan_id,
  DATE_FORMAT(k.tgl, '%d-%m-%Y') tgl,
  mp.no_rm,
  mp.nama nama,
  mp.alamat alamat,
  u.nama unit,
  kso.nama kso 
FROM
  b_kunjungan k 
  INNER JOIN b_ms_pasien mp 
    ON k.pasien_id = mp.id 
  INNER JOIN b_ms_unit u 
    ON u.id = k.unit_id 
  INNER JOIN b_ms_kso kso 
    ON kso.id = k.kso_id
WHERE DATE(k.tgl) BETWEEN '$tgl1' 
  AND '$tgl2' 
  AND mp.no_rm LIKE '$aKeyword%' 
ORDER BY k.tgl ASC 
LIMIT 30";
	  }
	  else{
	  $sql = "SELECT DISTINCT 
  k.id kunjungan_id,
  DATE_FORMAT(k.tgl, '%d-%m-%Y') tgl,
  mp.no_rm,
  mp.nama nama,
  mp.alamat alamat,
  u.nama unit,
  kso.nama kso 
FROM
  b_kunjungan k 
  INNER JOIN b_ms_pasien mp 
    ON k.pasien_id = mp.id 
  INNER JOIN b_ms_unit u 
    ON u.id = k.unit_id 
  INNER JOIN b_ms_kso kso 
    ON kso.id = k.kso_id 
WHERE DATE(k.tgl) BETWEEN '$tgl1' 
  AND '$tgl2' 
  AND mp.nama LIKE '%$aKeyword%' 
ORDER BY k.tgl ASC 
LIMIT 30";
		}
      //echo $sql;
	  $rs=mysqli_query($konek,$sql);
	  $arfvalue="";
	  $i=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
		$cno_rm=$rows['no_rm'];
		$arfvalue=$rows['no_rm']."*|*".$rows['nama']."*|*".$rows['kunjungan_id'];
	  	$arfvalue=str_replace('"',chr(3),$arfvalue);
		$arfvalue=str_replace("'",chr(5),$arfvalue);
	  
	  ?>
      <tr id="<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="fSetPasien(this.lang,1);">
        <td class="tdisikiri" width="80" align="center"><?php echo $rows['tgl']; ?></td>
		<td class="tdisi" align="left"><?php echo $rows['unit']; ?></td>
        <td class="tdisi" align="center"><?php echo $rows['no_rm']; ?></td>
		<td class="tdisi" align="left"><?php echo $rows['nama']; ?></td>
		<td class="tdisi" align="left"><?php echo $rows['kso']; ?></td>
		<td class="tdisi" align="left"><?php echo $rows['alamat']; ?></td>
      </tr>
		<?php
		}
		mysqli_free_result($rs);
		?>	
	</table>
<?php 
mysqli_close($konek2);
?>