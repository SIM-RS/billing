<?php
require_once '../koneksi/konek.php';
$id = mysql_real_escape_string($_REQUEST['id']);

$sql = "SELECT h.*,p.no_rm,p.nama,p.no_ktp,p.tgl_lahir,p.sex FROM b_hasil_pcr h INNER JOIN b_ms_pasien p ON h.id_pasien = p.id WHERE h.id = {$id}";
$query = mysql_query($sql);
$fetch = mysql_fetch_assoc($query);

function cnvTgl($date){
	$tanggal = explode('-', $date);
	return $tanggal[1] . '/' . $tanggal[2] . '/' . $tanggal[0];
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
			Laboratory Result
		</div>
		<div class="row mt-1">
			<div class="col-6">
				<table class="table table-borderless">
					<tr>
						<td><span style="font-weight: 600;">Medical Record Number</td>
						<td valign="top">:</td>
						<td valign="top" style="padding-left: 10px;"><?= $fetch['no_rm'] ?></td>
					</tr>
					<tr>
						<td><span style="font-weight: 600;">Lab Registration Number</td>
						<td valign="top">:</td>
						<td valign="top" style="padding-left: 10px;"><?= $fetch['no_registrasi_lab'] ?></td>
					</tr>
					<tr>
						<td><span style="font-weight: 600;">Patient's Name</td>
						<td valign="top">:</td>
						<td valign="top" style="padding-left: 10px;"><?= $fetch['nama'] ?></td>
					</tr>
					<tr>
						<td><span style="font-weight: 600;">Residence ID Number</td>
						<td valign="top">:</td>
						<td valign="top" style="padding-left: 10px;"><?= $fetch['no_ktp'] ?></td>
					</tr>
					<tr>
						<td><span style="font-weight: 600;">Date of Birth</td>
						<td valign="top">:</td>
						<td valign="top" style="padding-left: 10px;"><?= cnvTgl($fetch['tgl_lahir']) ?></td>
					</tr>
					<tr>
						<td><span style="font-weight: 600;">Sex</td>
						<td valign="top">:</td>
						<td valign="top" style="padding-left: 10px;"><?= $fetch['sex'] == 'L' ? 'Laki - laki' : 'Perempuan' ?></td>
					</tr>
				</table>
			</div>
			<div class="col-6">
				<table class="table table-borderless">
					<tr>
						<td><span style="font-weight: 600;">Reffering Doctor</td>
						<td valign="top">:</td>
						<td valign="top" style="padding-left: 10px;"><?= $fetch['dokter_pengirim'] ?></td>
					</tr>
					<tr>
						<td><span style="font-weight: 600;">Swab Date</td>
						<td valign="top">:</td>
						<td valign="top" style="padding-left: 10px;"><?= cnvTgl($fetch['tanggal_swab']) ?></td>
					</tr>
					<tr>
						<td><span style="font-weight: 600;">Receiving Date</td>
						<td valign="top">:</td>
						<td valign="top" style="padding-left: 10px;"><?= cnvTgl($fetch['tanggal_terima']) ?></td>
					</tr>
					<tr>
						<td><span style="font-weight: 600;">Validation Date</td>
						<td valign="top">:</td>
						<td valign="top" style="padding-left: 10px;"><?= cnvTgl($fetch['tanggal_validasi']) ?></td>
					</tr>
					<tr>
						<td>Print Out Date</td>
						<td valign="top">:</td>
						<td valign="top" style="padding-left: 10px;"><?= date('m/d/Y') ?></td>
					</tr>
				</table>
			</div>
		</div>
	</div>

	<div style="width: 100%" class="mt-2">
		<table class="table table-sm table-bordered text-center border border-dark">
			<tr>
				<th>Type of Examination</th>
				<th>Result</th>
				<th>Other Information</th>
			</tr>
			<tr>
				<td>SWAB NASOFARING</td>
				<td><?= $fetch['status_cek_pcr'] ?></td>
				<td><?= $fetch['keterangan'] ?></td>
			</tr>
		</table>
	</div>

	<div style="width: 100%;border: 1px solid; padding: 1px;font-size: 14px;">
		Result Interpretation
		<ul>
			<li style="text-align: justify;">
				Positive or Defected results indicate that the SARS-CoV-2 genetic material was detected in the specimen. If there is a positive result, please contact our consultation service below for explanation about isolation and clinical management. Timing is very important for the success of treatment.
			</li>
			<li style="text-align: justify;">
				Negative or Undetectable Results indicate that the SARS-CoV-2 genetic material in question was not detected in the specimen or the specimen levels could not be detected by the instrument.
			</li>
		</ul>
	</div>

	<div style="width: 100%;border: 1px solid; padding: 1px;font-size: 14px;" class="mt-1">
		<b>Edukasi</b> / Education
		<ul>
			<li>Always follow the health protocols</li>
			<li>Keep a clean and healthy attitude</li>
			<li>For further consultation, you can contact 082286635168 or you can use our Telemedicine service. during working hours:
				<table>
					<tr>
						<td>- Tuesday</td>
						<td valign="top">:</td>
						<td valign="top">11.00 AM - 01.00 PM</td>
					</tr>
					<tr>
						<td>- Wednesday</td>
						<td valign="top">:</td>
						<td valign="top">02.00 PM - 04.00 PM</td>
					</tr>
					<tr>
						<td>- Thursday</td>
						<td valign="top">:</td>
						<td valign="top">11.00 AM - 01.00 PM</td>
					</tr>
					<tr>
						<td>- Friday</td>
						<td valign="top">:</td>
						<td valign="top">02.00 PM - 04.00 PM</td>
					</tr>

				</table>
			</li>
		</ul>
	</div>

	<div style="width: 100%;float: left;">
		<div style="float: right;" class="mt-2 mr-5">
			Doctor in Charge
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