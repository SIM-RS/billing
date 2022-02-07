<?php 
	include("../../sesi.php");
	include '../../koneksi/konek.php';
	include '../function/form.php';
?>


<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="../../theme/bs/bootstrap.min.css">
	<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery-1.9.1.js"></script>
	<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery.form.js"></script>
    <script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>
    <script type="text/javascript" src="../../theme/js/ajax.js"></script>
	<script src="../../theme/bs/bootstrap.min.js"></script>
	<title>Rekap Rekam Medis</title>
</head>
<body>

	<div class="container">
		
		<div class="row">
			<div class="col col-2"></div>
			<div class="col col-8">
				<h1 class="mt-3">Menu Rekap RM</h1>
				<form method="POST">
					<input autocomplete="off" class="form-control mt-3" type="number" placeholder="Masukkan Nomor RM Pasien Terlebih Dahulu" name="data" />
					<button type="submit" class="btn btn-primary mt-2">Cari Pasien</button>
				</form>
			</div>
			<div class="col col-2"></div>
		</div>

		<hr>
			<div class="row">

			<?php
			
				if (isset($_POST['data'])) {
					$post = $_POST['data'];
					$query = mysql_query("SELECT id, nama FROM b_ms_pasien WHERE no_rm = '$post'");
					$dataPatient = mysql_fetch_assoc($query);
					$id = $dataPatient['id'];
					$queryKunj = mysql_query("SELECT id, tgl FROM b_kunjungan WHERE pasien_id = '$id'");
					
					$dataPelayanan = mysql_fetch_assoc(mysql_query("SELECT id FROM b_pelayanan WHERE kunjungan_id ='{$_REQUEST['idKunj']}'"));

					while ($dataKunj = mysql_fetch_assoc($queryKunj)) {
						$dataPelayanan = mysql_fetch_assoc(mysql_query("SELECT id, unit_id FROM b_pelayanan WHERE kunjungan_id ='${dataKunj['id']}'"));

						echo "<div class='col col-4 p-5 text-center'>";
							echo "<a target='_blank' href='rekap_rm.php?idKunj=${dataKunj['id']}&idPel=${dataPelayanan['id']}&idUser=732&tmpLay=${dataPelayanan['unit_id']}' class='btn btn-success'>";
                           		echo "Tanggal Kunjungan ${dataKunj['tgl']}";
							echo "</a>";
						echo "</div>";
					}
				}
			?>
				
			</div>
	</div>

	<div class="modal fade" id="search">

		<div class="modal-dialog">

			<div class="modal-content p-3">

				<h4 class="mb-5" id="name"></h4>

				<table class="table table-striped">
					<thead>
						<tr>
							<th>Tanggal Kunjungan</th>
							<th>Aksi</th>
						</tr>
					</thead>

					<tbody id="data"></tbody>
				</table>

			</div>

		</div>

	</div>

	<script type="text/javascript" src="ajax.js"></script>
</body>
</html>