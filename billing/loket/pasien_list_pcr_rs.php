<?php 

include '../koneksi/konek.php';


$nama = mysql_real_escape_string($_REQUEST['nama']);
$nik = mysql_real_escape_string($_REQUEST['nik']);

if($nik != '-') {
	$sql = "SELECT * FROM b_ms_pasien WHERE no_ktp = '{$nik}' AND cabang_id = 1";
	$queryNik = mysql_query($sql);
	if(mysql_num_rows($queryNik) > 0){
		$query = mysql_query($sql);
	}else{
		$sql = "SELECT * FROM b_ms_pasien WHERE nama LIKE '{$nama}%' AND cabang_id = 1";
		$query = mysql_query($sql);
	}
}else{
	$sql = "SELECT * FROM b_ms_pasien WHERE nama LIKE '{$nama}%' AND cabang_id = 1";
	$query = mysql_query($sql);	
}



?>

<table class="table table-bordered table-sm">
	<tr>
		<th>No Rm</th>
		<th>Nik</th>
		<th>Nama Pasien</th>
		<th>Tgl Lahir</th>
		<th>Alamat</th>
		<th>Action</th>
	</tr>
	<?php while($rows = mysql_fetch_assoc($query)){  ?>
		<tr>
			<td><?= $rows['no_rm'] ?></td>
			<td><?= $rows['nik'] ?></td>
			<td><?= $rows['nama'] ?></td>
			<td><?= $rows['tgl_lahir'] ?></td>
			<td><?= $rows['alamat'] ?></td>
			<td><button class="btn btn-success btn-sm" value="<?= $rows['no_rm'].'|'.$_REQUEST['idPasien'].'|'.$_REQUEST['idKunj'].'|'.$_REQUEST['idPel'] ?>" onclick="pilihPasienPcr(this.value)">Pilih</button></td>
		</tr>
	<?php } ?>
</table>