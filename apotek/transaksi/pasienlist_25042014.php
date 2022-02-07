<?php 
//include("../sesi.php");
include("../koneksi/konekBilling.php");
$sql="SELECT CURRENT_DATE sekarang,DATE_SUB(CURRENT_DATE,INTERVAL 1 DAY) kemarin,DATE_SUB(CURRENT_DATE,INTERVAL 2 DAY) lusa";
$rs=mysqli_query($konek,$sql);
$rw=mysqli_fetch_array($rs);
$sekarang=$rw["sekarang"];
$kemarin=$rw["kemarin"];
$lusa=$rw["lusa"];
?>
    <table id="tblPasien" border="0" cellpadding="1" cellspacing="0">
      <?php 
	  $aKeyword=$_REQUEST["aKeyword"];
	  $aPar=$_REQUEST["aPar"];
	  if ($aPar=="")
		/*$sql="SELECT DISTINCT NoRM,Nama,Alamat,Kode,KodePenjamin,Penjamin, 
dokter,KodePoli,Poli FROM (SELECT DISTINCT mp.no_rm NoRM,mp.nama Nama,mp.alamat Alamat,k.no_billing Kode,
kso.kode KodePenjamin,kso.nama Penjamin, IFNULL(bmp.nama,'-') dokter,mu.kode KodePoli,
mu.nama Poli,t.tgl,mu.inap,k.pulang FROM b_kunjungan k 
INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id 
INNER JOIN b_ms_kso kso ON k.kso_id=kso.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
LEFT JOIN b_tindakan t ON p.id=t.pelayanan_id LEFT JOIN b_ms_pegawai bmp ON t.user_id=bmp.id 
WHERE mp.nama LIKE '$aKeyword%' AND (t.tgl>='".$lusa."' OR t.tgl IS NULL OR (k.pulang=0 AND mu.inap=1)) AND ((bmp.spesialisasi_id<>129 AND bmp.spesialisasi_id<>182 AND bmp.spesialisasi_id<>71) OR bmp.spesialisasi_id IS NULL)) t1 WHERE ((t1.inap=0) OR (t1.inap=1 AND (t1.tgl>='".$kemarin."' OR t1.tgl IS NULL OR t1.pulang=0)))";*/
		$sql="SELECT DISTINCT mp.no_rm NoRM,mp.nama Nama,mp.alamat Alamat,p.id Kode, kso.kode KodePenjamin,
kso.nama Penjamin, IFNULL(bmp.nama,'-') dokter,mu.kode KodePoli, mu.nama Poli
FROM b_kunjungan k INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id
INNER JOIN b_ms_kso kso ON k.kso_id=kso.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
LEFT JOIN b_tindakan t ON p.id=t.pelayanan_id LEFT JOIN b_ms_pegawai bmp ON t.user_id=bmp.id
WHERE mp.nama like '$aKeyword%' AND ((bmp.spesialisasi_id<>129 AND bmp.spesialisasi_id<>182 AND bmp.spesialisasi_id<>71) OR bmp.spesialisasi_id IS NULL) 
ORDER BY k.id DESC,p.id DESC,t.id DESC LIMIT 50";
	  else
		$sql="SELECT DISTINCT mp.no_rm NoRM,mp.nama Nama,mp.alamat Alamat,p.id Kode, kso.kode KodePenjamin,
kso.nama Penjamin, IFNULL(bmp.nama,'-') dokter,mu.kode KodePoli, mu.nama Poli
FROM b_kunjungan k INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id
INNER JOIN b_ms_kso kso ON k.kso_id=kso.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
LEFT JOIN b_tindakan t ON p.id=t.pelayanan_id LEFT JOIN b_ms_pegawai bmp ON t.user_id=bmp.id
WHERE mp.no_rm='$aKeyword' AND ((bmp.spesialisasi_id<>129 AND bmp.spesialisasi_id<>182 AND bmp.spesialisasi_id<>71) OR bmp.spesialisasi_id IS NULL) 
ORDER BY k.id DESC,p.id DESC,t.id DESC LIMIT 30";
	  //echo $sql;
	  $rs=mysqli_query($konek,$sql);
	  $arfvalue="";
	  $i=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
		$cno_rm=$rows['NoRM'];
		$arfvalue=$rows['NoRM']."*|*".$rows['Nama']."*|*".$rows['Kode']."*|*".$rows['KodePenjamin']."*|*".$rows['dokter']."*|*".$rows['KodePoli']."*|*".$rows['Poli']."*|*".$rows['Alamat'];
	  	$arfvalue=str_replace('"',chr(3),$arfvalue);
		$arfvalue=str_replace("'",chr(5),$arfvalue);
	  ?>
      <tr id="<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="fSetPasien(this.lang,1);">
        <td class="tdisikiri" width="80" align="center"><?php echo $rows['NoRM']; ?></td>
		<td class="tdisi" align="left"><?php echo $rows['Nama']; ?></td>
		<td class="tdisi" align="left"><?php echo $rows['Penjamin']; ?></td>
		<td class="tdisi" align="left"><?php echo $rows['Alamat']; ?></td>
		<td class="tdisi" align="left"><?php echo $rows['Poli']; ?></td>
		<td class="tdisi" align="left"><?php echo $rows['dokter']; ?></td>
      </tr>
		<?php
		}
		mysqli_free_result($rs);
		?>	
	</table>
<?php 
mysqli_close($konek2);
?>
