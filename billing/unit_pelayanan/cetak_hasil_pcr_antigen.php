<?php
require_once '../koneksi/konek.php';
$id = mysql_real_escape_string($_REQUEST['id']);

$sql = "SELECT h.*,p.no_rm,p.nama,p.no_ktp,p.tgl_lahir,p.sex FROM b_hasil_pcr h INNER JOIN b_ms_pasien p ON h.id_pasien = p.id WHERE h.id = {$id}";
$query = mysql_query($sql);
$fetch = mysql_fetch_assoc($query);

function cnvTgl($date){
	$tanggal = explode('-', $date);
	$bulan = "";
	switch ($tanggal[1]) {
		case '01':
			$bulan = "Jan";
			break;
		case '02':
			$bulan = "Feb";
			break;
		case '03':
			$bulan = "Mar";
			break;
		case '04':
			$bulan = "April";
			break;
		case '05':
			$bulan = "May";
			break;
		case '06':
			$bulan = "Jun";
			break;
		case '07':
			$bulan = "Jul";
			break;
		case '08':
			$bulan = "Aug";
			break;
		case '09':
			$bulan = "Sep";
			break;
		case '10':
			$bulan = "Oct";
			break;
		case '11':
			$bulan = "Nov";
			break;
		case '12':
			$bulan = "Dec";
			break;
	}
	return $tanggal[2] . '-' . $bulan . '-' . $tanggal[0];
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
			LABORATORIUM<br>RUMAH SAKIT PRIMA HUSADA CIPTA MEDAN
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
			LAPORAN HASIL<br>SWAB ANTIGEN TEST SARS COV-2
		</div>
		<div class="row mt-1">
			<div class="col-6">
				<table style="padding: 0;">
					<tr>
						<td><span style="font-weight: 600;">No. Rekam Medis</span><br><i style="font-size: 14px;">Medical Record Number</i></td>
						<td valign="top">:</td>
						<td valign="top" style="padding-left: 10px;"><?= $fetch['no_rm'] ?></td>
					</tr>
					<tr>
						<td><span style="font-weight: 600;">No. Registrasi Lab</span><br><i style="font-size: 14px;">Lab Registration Number</i></td>
						<td valign="top">:</td>
						<td valign="top" style="padding-left: 10px;"><?= $fetch['no_registrasi_lab'] ?></td>
					</tr>
					<tr>
						<td><span style="font-weight: 600;">Nama Pasien</span><br><i style="font-size: 14px;">Patient's Name</i></td>
						<td valign="top">:</td>
						<td valign="top" style="padding-left: 10px;"><?= $fetch['nama'] ?></td>
					</tr>
					<tr>
						<td><span style="font-weight: 600;">No. Ident. Kependudukan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><br><i style="font-size: 14px;">Residence ID Number</i></td>
						<td valign="top">:</td>
						<td valign="top" style="padding-left: 10px;"><?= $fetch['no_ktp'] ?></td>
					</tr>
					<tr>
						<td><span style="font-weight: 600;">Tanggal Lahir</span><br><i style="font-size: 14px;">Date of Birth</i></td>
						<td valign="top">:</td>
						<td valign="top" style="padding-left: 10px;"><?= cnvTgl($fetch['tgl_lahir']) ?></td>
					</tr>
					<tr>
						<td><span style="font-weight: 600;">Jenis Kelamin</span><br><i style="font-size: 14px;">Sex</i></td>
						<td valign="top">:</td>
						<td valign="top" style="padding-left: 10px;"><?= $fetch['sex'] == 'L' ? 'Laki - laki / Man' : 'Perempuan / Woman' ?></td>
					</tr>
				</table>
			</div>
			<div class="col-6">
				<table class="">
					<tr>
						<td><span style="font-weight: 600;">Dokter Pengirim</span><br><i style="font-size: 14px;">Reffering Doctor</i></td>
						<td valign="top">:</td>
						<td valign="top" style="padding-left: 10px;"><?= $fetch['dokter_pengirim'] ?></td>
					</tr>
					<tr>
						<td><span style="font-weight: 600;">Tanggal Swab</span><br><i style="font-size: 14px;">Swab Date</i></td>
						<td valign="top">:</td>
						<td valign="top" style="padding-left: 10px;"><?= cnvTgl($fetch['tanggal_swab']) ?></td>
					</tr>
					<!-- <tr>
						<td><span style="font-weight: 600;">Tanggal Terima</span><br><i style="font-size: 14px;">Receiving Date</i></td>
						<td valign="top">:</td>
						<td valign="top" style="padding-left: 10px;"><?php //cnvTgl($fetch['tanggal_terima']) ?></td>
					</tr>
					<tr>
						<td><span style="font-weight: 600;">Validasi Hasil &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><br><i style="font-size: 14px;">Validation Date</i></td>
						<td valign="top">:</td>
						<td valign="top" style="padding-left: 10px;"><?php //cnvTgl($fetch['tanggal_validasi']) ?></td>
					</tr> -->
					<tr>
						<td><span style="font-weight: 600;">Cetak Hasil</span><br><i style="font-size: 14px;">Print Out Date</i></td>
						<td valign="top">:</td>
						<td valign="top" style="padding-left: 10px;"><?= date('d-M-Y') ?></td>
					</tr>
				</table>
			</div>
		</div>
	</div>

	<div style="width: 100%" class="mt-2">
		<table class="table table-sm table-bordered text-center border border-dark">
			<tr>
				<th>JENIS PEMERIKSAAN<br><i style="font-weight: 400;font-size: 14px;">Type of Examination</i></th>
				<th>HASIL<br><i style="font-weight: 400;font-size: 14px;">Result</i></th>
				<th>Keterangan<br><i style="font-weight: 400;font-size: 14px;">Other Information</i></th>
			</tr>
			<tr>
				<td style="
				text-transform: capitalize;"><?= $fetch['jenis_spesimen'] ?></td>
				<td><?= substr($fetch['status_cek_pcr'], 0,7) ?></td>
				<td><?= $fetch['keterangan'] ?></td>
			</tr>
		</table>
	</div>

	<div style="width: 100%;border: 1px solid; padding: 3px;font-size: 14px;">
		Interpretasi dan saran : <br>
		<ul>
			<li style="text-align: justify;">
				Korelasi dengan kritis dan hasil pemeriksaan penunjang relevan lain.
			</li>
			<li style="text-align: justify;">
				Hasil ini hanya berlaku pada hari saat pengambilan spesimen.
			</li>
		</ul>
		Hasil <b><i>Positif</i></b> tidak memastikan adanya infeksi SARS Cov-2. Tetap perlu di konfirmasi
		dengan pemeriksaan RT PCR SARS Cov-2.<br><br>
		Hasil <b><i>Negatif</i></b> tidak meyingkirkan kemungkinan infeksi SARS Cov-2 terutama jika disertai dengan gejala Covid 19.</br><br>
	</div>

	<div style="width: 100%;border: 1px solid; padding: 1px;font-size: 14px;" class="mt-1">
		<b>Edukasi</b> / Education
		<ul>
			<li>Patuhi protokol kesehatan yang berlaku / Always follow the health protocols</li>
			<li>Tetap berperilaku bersih dan sehat/ Keep a clean and healthy attitude</li>
			<li>Untuk konsultasi lebih lanjut dapat menghubungi 082286635168. Kami pada jam kerja / For further consultation, you can contact 082286635168. During working hours:
				<table>
					<tr>
						<td>- Selasa<br><i style="font-size: 12px"> Tuesday</i></td>
						<td valign="top">:<br>:</td>
						<td valign="top">11.00 WIB - 13.00 WIB<br>11.00 AM - 01.00 PM</td>
					</tr>
					<tr>
						<td>- Rabu<br><i style="font-size: 12px"> Wednesday</i></td>
						<td valign="top">:<br>:</td>
						<td valign="top">14.00 WIB - 16.00 WIB<br><i style="font-size: 12px">02.00 PM - 04.00 PM</i></td>
					</tr>
					<tr>
						<td>- Kamis<br><i style="font-size: 12px">Thursday</i></td>
						<td valign="top">:<br>:</td>
						<td valign="top">11.00 WIB - 13.00 WIB<br><i style="font-size: 12px">11.00 AM - 01.00 PM</i></td>
					</tr>
					<tr>
						<td>- Jum'at<br><i style="font-size: 12px">Friday</i></td>
						<td valign="top">:<br>:</td>
						<td valign="top">14.00 WIB - 16.00 WIB<br><i style="font-size: 12px">02.00 PM - 04.00 PM</i></td>
					</tr>

				</table>
			</li>
		</ul>
	</div>

	<div style="width: 100%;float: left;">
		<div style="float: right;" class="mt-2 mr-5">
			Dokter Penanggung Jawab,<br><i style="font-size: 11px;">Doctor in Charge</i>
			<br>
			<br>
			<br>
			<br>
			<b>Dr. MUZAHAR, DMM., SP. PK(K)</b>
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