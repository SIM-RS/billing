<?php
require_once '../koneksi/konek.php';
$id = mysql_real_escape_string($_REQUEST['id']);

$sql = "SELECT h.*,p.no_rm,p.nama,p.no_ktp,p.tgl_lahir,p.sex FROM b_hasil_pcr h INNER JOIN b_ms_pasien p ON h.id_pasien = p.id WHERE h.id = {$id}";
$query = mysql_query($sql);
$fetch = mysql_fetch_assoc($query);

function cnvTgl($date){
	$tanggal = explode('-', $date);
	return $tanggal[2] . '-' . $tanggal[1] . '-' . $tanggal[0];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="../theme/bs/bootstrap.min.css">
	<script>
		window.print();
	</script>
</head>
<body>

<div class="container">
	<div class="row">
		<div class="col-4">
			<img src="gambar/logo.png" style="width: 180px;height: 60px;" alt="">
			
		</div>
		<div class="col-4 text-center font-weight-bold" style="font-size: 16px;">
			LABORATORIUM BIOMOLEKULER RUMAH SAKIT PRIMA HUSADA CIPTA MEDAN
		</div>
		<div class="col-4">
		<img src="gambar/pertamidika.png" style="width: 106px;height: 35px;" alt="">
		<img src="gambar/ihc.png" class="ml-5" style="width: 91px;height:43px;" alt="">
		</div>
	</div>
	
	<div class="mt-3 mb-2" style="width: 100%">
		<img src="gambar/gambar_cetak.jpeg" style="width: 100%;height: 5px;" alt="">
	</div>

	<div style="width: 100%;">
		<div class="text-center font-weight-bold" style="width: 100%; font-size: 18px;">
			LAPORAN HASIL
		</div>
		<div class="row mt-1">
			<div class="col-6">
				<table class="table table-borderless">
					<tr>
						<td><span style="font-weight: 600;">No. Rekam Medis</span></td>
						<td valign="top">:</td>
						<td valign="top" style="padding-left: 10px;"><?= $fetch['no_rm'] ?></td>
					</tr>
					<tr>
						<td><span style="font-weight: 600;">No. Registrasi Lab</span>Lab Registration Number</i></td>
						<td valign="top">:</td>
						<td valign="top" style="padding-left: 10px;"><?= $fetch['no_registrasi_lab'] ?></td>
					</tr>
					<tr>
						<td><span style="font-weight: 600;">Nama Pasien</span></td>
						<td valign="top">:</td>
						<td valign="top" style="padding-left: 10px;"><?= $fetch['nama'] ?></td>
					</tr>
					<tr>
						<td><span style="font-weight: 600;">No. Ident. Kependudukan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
						<td valign="top">:</td>
						<td valign="top" style="padding-left: 10px;"><?= $fetch['no_ktp'] ?></td>
					</tr>
					<tr>
						<td><span style="font-weight: 600;">Tanggal Lahir</span></td>
						<td valign="top">:</td>
						<td valign="top" style="padding-left: 10px;"><?= cnvTgl($fetch['tgl_lahir']) ?></td>
					</tr>
					<tr>
						<td><span style="font-weight: 600;">Jenis Kelamin</span></td>
						<td valign="top">:</td>
						<td valign="top" style="padding-left: 10px;"><?= $fetch['sex'] == 'L' ? 'Laki - laki' : 'Perempuan' ?></td>
					</tr>
				</table>
			</div>
			<div class="col-6">
				<table class="table table-borderless">
					<tr>
						<td><span style="font-weight: 600;">Dokter Pengirim</span></td>
						<td valign="top">:</td>
						<td valign="top" style="padding-left: 10px;"><?= $fetch['dokter_pengirim'] ?></td>
					</tr>
					<tr>
						<td><span style="font-weight: 600;">Tanggal Swab</span></td>
						<td valign="top">:</td>
						<td valign="top" style="padding-left: 10px;"><?= cnvTgl($fetch['tanggal_swab']) ?></td>
					</tr>
					<tr>
						<td><span style="font-weight: 600;">Tanggal Terima</span></td>
						<td valign="top">:</td>
						<td valign="top" style="padding-left: 10px;"><?= cnvTgl($fetch['tanggal_terima']) ?></td>
					</tr>
					<tr>
						<td><span style="font-weight: 600;">Validasi Hasil &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
						<td valign="top">:</td>
						<td valign="top" style="padding-left: 10px;"><?= cnvTgl($fetch['tanggal_validasi']) ?></td>
					</tr>
					<tr>
						<td><span style="font-weight: 600;">Cetak Hasil</span></td>
						<td valign="top">:</td>
						<td valign="top" style="padding-left: 10px;"><?= date('d-m-Y') ?></td>
					</tr>
				</table>
			</div>
		</div>
	</div>

	<div style="width: 100%" class="mt-2">
		<table class="table table-sm table-bordered text-center border border-dark">
			<tr>
				<th>JENIS PEMERIKSAAN</th>
				<th>HASIL</th>
				<th>Keterangan</th>
			</tr>
			<tr>
				<td>SWAB NASOFARING</td>
				<td><?= $fetch['status_cek_pcr'] ?></td>
				<td><?= $fetch['keterangan'] ?></td>
			</tr>
		</table>
	</div>

	<div style="width: 100%;border: 1px solid; padding: 1px;font-size: 14px;">
		<b>Interpretasi Hasil</b> / <i>Result Interpretation</i>
		<ul>
			<li style="text-align: justify;">
				Hasil Positif atau Terdeteksi menunjukan bahwa pada spesimen terdeteksi material genetik SARS-CoV-2. Jika terdapat hasil positif,
				mohon untuk menghubungi layanan konsultasi kami dibawah ini untuk mendapatkan penjelasan mengenai jenis/tempat isolasi dan penatalaksanaan  yang sesuai klinis. Kecepatan penanganan sangat penting untuk keberhasilan pengobatan.<br>
			</li>
			<li style="text-align: justify;">
				Hasil Negatif atau Tidak Terdeteksi menunjukkan bahwa material genetik SARS-CoV-2 yang dimaksud tidak ditemukan di dalam spesimen atau kadar spesimen belum dapat terdeteksi oleh alat.<br>
			</li>
		</ul>
	</div>

	<div style="width: 100%;border: 1px solid; padding: 1px;font-size: 14px;" class="mt-1">
		<b>Edukasi</b> / Education
		<ul>
			<li>Patuhi protokol kesehatan yang berlaku / Always follow the health protocols2)</li>
			<li>Tetap berperilaku bersih dan sehat/ Keep a clean and healthy attitude</li>
			<li>Untuk konsultasi lebih lanjut dapat menghubungi 082286635168 atau dapat melalui layanan Telemedicine kami pada jam kerja:
				<table>
					<tr>
						<td>- Selasa</td>
						<td valign="top">:</td>
						<td valign="top">11.00 WIB - 13.00 WIB</td>
					</tr>
					<tr>
						<td>- Rabu</td>
						<td valign="top">:</td>
						<td valign="top">14.00 WIB - 16.00 WIB</td>
					</tr>
					<tr>
						<td>- Kamis</td>
						<td valign="top">:</td>
						<td valign="top">11.00 WIB - 13.00 WIB</td>
					</tr>
					<tr>
						<td>- Jum'at</td>
						<td valign="top">:<br>:</td>
						<td valign="top">14.00 WIB - 16.00 WIB</td>
					</tr>

				</table>
			</li>
		</ul>
	</div>

	<div style="width: 100%;float: left;">
		<div style="float: right;" class="mt-2 mr-5">
			Dokter Penanggung Jawab,
			<br>
			<br>
			<br>
			<br>
			<?= $fetch['dokter_penanggung_jawab'] ?>
		</div>	
	</div>
	
	<div style="width: 100%;float: left;text-align: center;justify-content: center;align-items: center;">
		<img class="text-center mr-auto ml-auto" src="gambar/cegah_penularan_covid.png" style="width: 80%;height:130px;" alt="">
	</div>

	<div style="float: right;font-size: 11px;" class="mt-2 text-right">
		RUMAH SAKIT PRIMA HUSADA CIPTA MEDAN<br>
		Jalan Statsiun No.92, Belawan, Medan, Sumut 20411<br>
		P : 0616941927<br>
		Email : rspelabuhan@pelindo1.co.id<br>
		Website : http:://rsphcm.com/
	</div>

</div>

<script type="text/JavaScript" language="JavaScript" src="../include/jquery/jquery-1.9.1.js"></script>
<script src="../theme/bs/bootstrap.min.js"></script>
</body>
</html>