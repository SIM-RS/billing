<?php 
//include("../sesi.php");
//include("../koneksi/konekBilling.php");
include("../koneksi/konek.php");
//mysqli_select_db($dbbilling,$konek);
$sql="SELECT CURRENT_DATE sekarang,DATE_SUB(CURRENT_DATE,INTERVAL 1 DAY) kemarin,DATE_SUB(CURRENT_DATE,INTERVAL 2 DAY) lusa";
$rs=mysqli_query($konek,$sql);
$rw=mysqli_fetch_array($rs);
$sekarang=$rw["sekarang"];
$kemarin=$rw["kemarin"];
$lusa=$rw["lusa"];
?>
	<style type="text/css">
		#tblPasien{
			border-collapse:collapse;
		}
		#tblPasien th{
			background:#EAF0F0;
			font-size:12px;
		}
		#tblPasien td, #tblPasien th{
			border:1px solid #000;
			padding:5px;
		}
	</style>
    <table id="tblPasien" border="0" cellpadding="1" cellspacing="0">
		<tr>
			<th>Tanggal</th>
			<th>NoRM</th>
			<th>Nama</th>
			<th>Penjamin</th>
			<th>Alamat</th>
			<th>Poli</th>
			<th>Dokter</th>
		</tr>
      <?php 
	  $aKeyword=$_REQUEST["aKeyword"];
	  $aPar=$_REQUEST["aPar"];
	  $unit_id = $_REQUEST["unit"];
	  if($unit_id==7){
	  $funit = " AND mp.cabang_id = 1";
	  }elseif($unit_id==8){
	  $funit = " AND mp.cabang_id = 2";
	  }else{
	  $funit = " AND mp.cabang_id = 3";
	  }
	  
	  
	  if ($aPar=="")
		
		$sql="SELECT DISTINCT mp.no_rm NoRM,mp.nama Nama,mp.alamat Alamat, DATE_FORMAT(p.tgl, '%d-%m-%Y') AS tgl, p.id Kode, kso.kode KodePenjamin,
			kso.nama Penjamin, IFNULL(bmp.nama,'-') dokter,mu.kode KodePoli, mu.nama Poli, p.jenis_kunjungan
			FROM $dbbilling.b_kunjungan k 
			INNER JOIN $dbbilling.b_ms_pasien mp ON k.pasien_id=mp.id 
			INNER JOIN $dbbilling.b_pelayanan p ON k.id=p.kunjungan_id
			INNER JOIN $dbbilling.b_ms_kso kso ON k.kso_id=kso.id 
			INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id=mu.id
			LEFT JOIN $dbbilling.b_tindakan t ON p.id=t.pelayanan_id 
			LEFT JOIN $dbbilling.b_ms_pegawai bmp ON t.user_id=bmp.id
			WHERE mp.nama like '$aKeyword%' /*AND ((bmp.spesialisasi_id<>129 AND bmp.spesialisasi_id<>182 AND bmp.spesialisasi_id<>71) OR bmp.spesialisasi_id IS NULL) */ 
			$funit ORDER BY k.id DESC,p.id DESC,t.id DESC LIMIT 50";
			
	  else
	  
		$sql="SELECT DISTINCT mp.no_rm NoRM,mp.nama Nama,mp.alamat Alamat, DATE_FORMAT(p.tgl, '%d-%m-%Y') AS tgl, p.id Kode, kso.kode KodePenjamin,
			kso.nama Penjamin, IFNULL(bmp.nama,'-') dokter,mu.kode KodePoli, mu.nama Poli, p.jenis_kunjungan
			FROM $dbbilling.b_kunjungan k 
			INNER JOIN $dbbilling.b_ms_pasien mp ON k.pasien_id=mp.id 
			INNER JOIN $dbbilling.b_pelayanan p ON k.id=p.kunjungan_id
			INNER JOIN $dbbilling.b_ms_kso kso ON k.kso_id=kso.id 
			INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id=mu.id
			LEFT JOIN $dbbilling.b_tindakan t ON p.id=t.pelayanan_id 
			LEFT JOIN $dbbilling.b_ms_pegawai bmp ON t.user_id=bmp.id
			WHERE mp.no_rm='$aKeyword'/* AND ((bmp.spesialisasi_id<>129 AND bmp.spesialisasi_id<>182 AND bmp.spesialisasi_id<>71) OR bmp.spesialisasi_id IS NULL)  */
			$funit ORDER BY k.id DESC,p.id DESC,t.id DESC LIMIT 30";
		//echo $sql;
	  $rs=mysqli_query($konek,$sql);
	  //die(mysqli_error($konek)." blabla");
	  $arfvalue="";
	  $i=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
		$cno_rm=$rows['NoRM'];
		$arfvalue=$rows['NoRM']."*|*".$rows['Nama']."*|*".$rows['Kode']."*|*".$rows['KodePenjamin']."*|*".$rows['dokter']."*|*".$rows['KodePoli']."*|*".$rows['Poli']."*|*".$rows['Alamat']."*|*".$rows['jenis_kunjungan'];
	  	$arfvalue=str_replace('"',chr(3),$arfvalue);
		$arfvalue=str_replace("'",chr(5),$arfvalue);
	  ?>
      <tr id="<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="fSetPasien(this.lang,1);">
        <td width="80" align="center"><?php echo $rows['tgl']; ?></td>
        <td width="80" align="center"><?php echo $rows['NoRM']; ?></td>
		<td align="left"><?php echo $rows['Nama']; ?></td>
		<td align="left"><?php echo $rows['Penjamin']; ?></td>
		<td align="left"><?php echo $rows['Alamat']; ?></td>
		<td align="left"><?php echo $rows['Poli']; ?></td>
		<td align="left"><?php echo $rows['dokter']; ?></td>
      </tr>
		<?php
		}
		mysqli_free_result($rs);
		?>	
	</table>
<?php 
mysqli_close($konek);
?>
