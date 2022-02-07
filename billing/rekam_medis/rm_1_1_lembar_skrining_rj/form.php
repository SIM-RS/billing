<?php
	use yii\helpers\Html;
	include '../function/form.php';
	include '../../koneksi/konek.php';
	$dataPasien = getIndetitasPasien($_REQUEST['idKunj']);
	$i = 1;

	if (isset($_REQUEST['cetak'])) {
		$print_mode = true;
		echo "<script>window.print();</script>";
		$data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_1_1_lembar_skrining_rj WHERE id = '{$_REQUEST['cetak']}'"));
	}

	if (isset($_REQUEST['id'])) {
		$data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_1_1_lembar_skrining_rj WHERE id = '{$_REQUEST['id']}'"));
	}

	if (isset($_REQUEST['idx'])) {
		date_default_timezone_set("Asia/Jakarta");
	    $id_kunj = (int)$_REQUEST["id_kunjungan"];
	    $sql = mysql_fetch_assoc(mysql_query("SELECT pasien_id FROM b_kunjungan WHERE id = '$id_kunj'"));

	    $tgl_act = date('Y-m-d H:i:s');
	    $keputusan = $_REQUEST["keputusan"];

	    $data = [
	        'id_pasien' => $sql['pasien_id'],
	        'id_kunjungan' => mysql_real_escape_string($_REQUEST['id_kunjungan']),
	        'id_pelayanan' => mysql_real_escape_string($_REQUEST['id_pelayanan']),
	        'resiko_jatuh_a' => mysql_real_escape_string($_REQUEST["resikoJatuhA"]),
	        'resiko_jatuh_b' => mysql_real_escape_string($_REQUEST["resikoJatuhB"]),
	        'resiko_jatuh_c' => mysql_real_escape_string($_REQUEST["resikoJatuhC"]),
	        'keadaan_umum' => mysql_real_escape_string($_REQUEST["keadaanUmum"]),
	        'batuk_1' => mysql_real_escape_string($_REQUEST["batukA"]),
	        'batuk_2' => mysql_real_escape_string($_REQUEST["batukB"]),
	        'nyeri' => mysql_real_escape_string($_REQUEST["nyeri"]),
	        'numeric_scale' => mysql_real_escape_string($_REQUEST["numericScale"]),
	        'tgl_act' => date('Y-m-d H:i:s'),
	        'keputusan' => mysql_real_escape_string($_REQUEST["keputusan"]),
	        'id_user' => mysql_real_escape_string($_REQUEST["id_user"]),
	    ];

	    mysql_query("UPDATE rm_1_1_lembar_skrining_rj 
	    			SET 
			    	resiko_jatuh_a = '{$data['resiko_jatuh_a']}', 
			    	resiko_jatuh_b = '{$data['resiko_jatuh_b']}',
			    	resiko_jatuh_c = '{$data['resiko_jatuh_c']}',
			    	keadaan_umum = '{$data['keadaan_umum']}',
			    	batuk_1 = '{$data['batuk_1']}',
			    	batuk_2 = '{$data['batuk_2']}',
			    	nyeri = '{$data['nyeri']}',
			    	numeric_scale = '{$data['numeric_scale']}',
			    	keputusan = '{$data['keputusan']}',
			    	tgl_act = '{$data['tgl_act']}',
			    	id_kunjungan = '{$data['id_kunjungan']}',
			    	id_pelayanan = '{$data['id_pelayanan']}',
			    	id_pasien = '{$data['id_pasien']}',
			    	id_user = '{$data['id_user']}'
			    	WHERE 
			    	id = {$_REQUEST['idx']}");
	    
	    echo "<script>window.location.href='index.php?idKunj=".$_REQUEST['idKunj']."&idPel=".$_REQUEST['idPel']."&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['idUser']."&tmpLay=".$_REQUEST['tmpLay']."'</script>";
	}

	if (isset($_REQUEST['pdf'])) {
    	$data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_1_1_lembar_skrining_rj WHERE id = '{$_REQUEST['pdf']}'"));
	}

?>

<!DOCTYPE html>
<html lang="en">
 
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../../theme/bs/bootstrap.min.css">
	<title>Document</title>
	<style type="text/css">
		.li{
			margin-bottom : 10px;
		}
		.margsDown{
			margin: 10px;
			margin-bottom: 30px;
		}
		ul{
			list-style-type : none;
		}
		.inv {
			background-color: transparent;
			border :none;
			cursor :default;
		}
	</style>
	<script src="../html2pdf/ppdf.js"></script>
	<script src="../html2pdf/pdf.js"></script>
</head>

<body style="padding:30px" id="pdf-area">
	<div class="container bg-white" style="padding:25px">
		<div class="row">
			<div class="col-6 text-center"><br><br>
				<img src="../logors1.png">
			</div>
			<div class="col-6" style="padding:15px">
					
				<div style="float: right">RM 1.1 / PHCM</div>
				<br>
				<div id="box" class="row" style="border: 1px solid black;padding:15px">
					<div class="col-9">
						<table>
							<tr>
								<td>Nama</td>
								<td>:</td>
								<td><?= $dataPasien["nama"]; ?></td>
							</tr>
							<tr>
								<td>Tgl. Lahir</td>
								<td>:</td>
								<td><?= $dataPasien["tgl_lahir"]; ?></td>
							</tr>
							<tr>
								<td>No. RM</td>
								<td>:</td>
								<td><?= $dataPasien["no_rm"]; ?></td>
							</tr>
						</table>
					</div>

					<div class="col-3">
						<table>
							<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
							<tr>
								<td>
									<?php if($dataPasien["sex"] == "L"): ?>
										L
									<?php else: ?>
										P
									<?php endif; ?>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>

		<hr class="bg-dark" style="margin-top:-1px">
		<div style="height:5px;background-color:black;width:100%;margin-top:-12px;margin-bottom:10px"></div>
		<center><h2>Lembar Skrining Rawat Jalan</h2></center>
		<div class="container" style="border: 1px solid black;">

		<?php if($data["id"] == ""): ?>
			<?= formOpen('lembar_skrining_form', 'utils.php'); ?>
		<?php else: ?>
			<form action="" method="POST">
			<?= textInput('',['type'=>'hidden','name'=>'idx','value'=>$_REQUEST['id']]) ?>
		<?php endif; ?>
		<?= textInput('',['type'=>'hidden','name'=>'id_kunjungan','value'=>$_REQUEST['idKunj']]) ?>
		<?= textInput('',['type'=>'hidden','name'=>'id_pelayanan','value'=>$_REQUEST['idPel']]) ?>
		<?= textInput('',['type'=>'hidden','name'=>'id_user','value'=>$_REQUEST['idUser']]) ?>
		<?= textInput('',['type'=>'hidden','name'=>'tmpLay','value'=>$_REQUEST['tmpLay']]) ?>
		<div class="row">

			<div class="col-12">

				<span><?=$i;$i++?>. Resiko Jatuh : </span>
				<div class="row">

					<div class="col-6">
						<ul class="margsDown">
							<li class="li">a. Sempoyongan / Limbung</li>
							<li class="margsDown">
								<?php if ($data["resiko_jatuh_a"] == "Ya"):?>
									<?= inputField('radio', 'Ya', 'checked', 'resikoJatuhA') ?> Ya &emsp;
									<?= inputField('radio', 'Tidak', '', 'resikoJatuhA') ?> Tidak
								<?php elseif ($data["resiko_jatuh_a"] == "Tidak"):?>
									<?= inputField('radio', 'Ya', '', 'resikoJatuhA') ?> Ya &emsp;
									<?= inputField('radio', 'Tidak', 'checked', 'resikoJatuhA') ?> Tidak
								<?php else: ?>
									<?= inputField('radio', 'Ya', '', 'resikoJatuhA') ?> Ya &emsp;
									<?= inputField('radio', 'Tidak', '', 'resikoJatuhA') ?> Tidak
								<?php endif; ?>
								
							</span></li>
							<li>
								<?php if ($data["resiko_jatuh_c"] == "Tidak Beresiko"):?>
									<?= inputField('radio', 'Tidak Beresiko', 'checked', 'resikoJatuhC') ?> Tidak Beresiko (Tidak Ditemukan a / b)
								<?php else: ?>
									<?= inputField('radio', 'Tidak Beresiko', '', 'resikoJatuhC') ?> Tidak Beresiko (Tidak Ditemukan a / b)
								<?php endif; ?>
							</li>
							<li>
								<?php if ($data["resiko_jatuh_c"] == "Resiko Rendah"):?>
									<?= inputField('radio', 'Resiko Rendah', 'checked', 'resikoJatuhC') ?> Risiko Rendah (ditemukan a atau b)
								<?php else: ?>
									<?= inputField('radio', 'Resiko Rendah', '', 'resikoJatuhC') ?> Risiko Rendah (ditemukan a atau b)
								<?php endif; ?>
							</li>
						</ul>
					</div>

					<div class="col-6">
						<ul class="margsDown">
							<li class="li">b. Memegang Pinggiran Kursi / Meja</li>
							<li class="margsDown">
								<?php if ($data["resiko_jatuh_b"] == "Ya"):?>
									<?= inputField('radio', 'Ya', 'checked', 'resikoJatuhB') ?> Ya &emsp; 
									<?= inputField('radio', 'Tidak', '', 'resikoJatuhB') ?> Tidak
								<?php elseif ($data["resiko_jatuh_b"] == "Tidak"):?>
									<?= inputField('radio', 'Ya', '', 'resikoJatuhB') ?> Ya &emsp; 
									<?= inputField('radio', 'Tidak', 'checked', 'resikoJatuhB') ?> Tidak
								<?php else: ?>
									<?= inputField('radio', 'Ya', '', 'resikoJatuhB') ?> Ya &emsp; 
									<?= inputField('radio', 'Tidak', '', 'resikoJatuhB') ?> Tidak
								<?php endif; ?>
							</span></li>
							<li>
								<?php if($data["resiko_jatuh_c"] == "Resiko Tinggi"): ?>
									<?= inputField('radio', 'Resiko Tinggi', 'checked', 'resikoJatuhC') ?> Risiko Tinggi (a dan b   ditemukan)
								<?php else: ?>
									<?= inputField('radio', 'Resiko Tinggi', '', 'resikoJatuhC') ?> Risiko Tinggi (a dan b   ditemukan)
								<?php endif; ?>
							</li>
						</ul>
					</div>

				<div>
			</div>

				<div class="col-12">
					<span><?=$i;$i++;?>. Keadaan  Umum  : </span>
					<div class="row">

					<div class="col-6">
						<ul class="margsDown">
							<li>
								<?php if($data["keadaan_umum"] == "Sadar"):?>
									<?= inputField('radio', 'Sadar', 'checked', 'keadaanUmum') ?> Sadar Penuh
								<?php else: ?>
									<?= inputField('radio', 'Sadar', '', 'keadaanUmum') ?> Sadar Penuh
								<?php endif; ?>
							</li>
						</ul>
					</div>

					<div class="col-6">
						<ul class="margsDown">
							<li>
								<?php if($data["keadaan_umum"] == "Gelisah"):?>
									<?= inputField('radio', 'Gelisah', 'checked', 'keadaanUmum') ?> Tampak Mengantuk/Gelisah/Bicara Tidak Jelas
								<?php else: ?>
									<?= inputField('radio', 'Gelisah', '', 'keadaanUmum') ?> Tampak Mengantuk/Gelisah/Bicara Tidak Jelas
								<?php endif; ?>
							</li>
						</ul>
					</div>
				<div>
				</div>

				<div class="col-12">
					<span><?=$i;$i++;?>. Batuk  : </span>
					<div class="row">

					<div class="col-4">
						<ul class="margsDown">
							<li>
								<?php if($data["batuk_1"] == "Normal"):?>
									<?= inputField('radio', 'Normal', 'checked', 'batukA') ?> Normal
								<?php else: ?>
									<?= inputField('radio', 'Normal', '', 'batukA') ?> Normal
								<?php endif; ?>
							</li>
						</ul>
					</div>
					<div class="col-4">
						<ul class="margsDown">
							<li>
								<?php if($data["batuk_1"] == "Sesak"):?>
									<?= inputField('radio', 'Sesak', 'checked', 'batukA') ?> Tampak Sesak
								<?php else: ?>
									<?= inputField('radio', 'Sesak', '', 'batukA') ?> Tampak Sesak
								<?php endif; ?>
								
							</li>
						</ul>
					</div>
					<div class="col-4">
						<ul class="margsDown">
							<li>
								<?php if($data["batuk_1"] == "O2"):?>
									<?= inputField('radio', 'O2', 'checked', 'batukA') ?> Menggunakan O2
								<?php else: ?>
									<?= inputField('radio', 'O2', '', 'batukA') ?> Menggunakan O2
								<?php endif; ?>
								
							</li>
						</ul>
					</div>
				<div>
				</div>
			</div>
			</div>

				<div class="col-12">
					<span><?=$i;$i++;?>. Batuk  : </span>
					<div class="row">

					<div class="col-6">
						<ul class="margsDown">
							<li>
								<?php if($data["batuk_2"] == "2minggu"):?>
									<?= inputField('radio', '2minggu', 'checked', 'batukB') ?> Ya : ≥ 2 minggu
								<?php else: ?>
									<?= inputField('radio', '2minggu', '', 'batukB') ?> Ya : ≥ 2 minggu
								<?php endif; ?>
								
							</li>
						</ul>
					</div>

					<div class="col-6">
						<ul class="margsDown">
							<li>
								<?php if($data["batuk_2"] == "Tidak"):?>
									<?= inputField('radio', 'Tidak', 'checked', 'batukB') ?> Tidak
								<?php else: ?>
									<?= inputField('radio', 'Tidak', '', 'batukB') ?> Tidak
								<?php endif; ?>
								
							</li>
						</ul>
					</div>
				<div>
			</div>

			<div class="col-12">
					<span><?=$i;$i++;?>. Nyeri  : </span>
					<div class="row">

					<div class="col-6">
						<ul class="margsDown">
							<li>
								<?php if($data["nyeri"] == "Tidak"):?>
									<?= inputField('radio', 'Tidak', 'checked', 'nyeri') ?> Tidak ada
								<?php else: ?>
									<?= inputField('radio', 'Tidak', '', 'nyeri') ?> Tidak ada
								<?php endif; ?>
								
							</li>
						</ul>
					</div>

					<div class="col-6">
						<ul class="margsDown">
							<li>
								<?php if($data["nyeri"] == "Ada"):?>
									<?= inputField('radio', 'Ada', 'checked', 'nyeri') ?> Ada
								<?php else: ?>
									<?= inputField('radio', 'Ada', '', 'nyeri') ?> Ada
								<?php endif; ?>
								
							</li>
						</ul>
					</div>
				<div>
			</div>

			<div class="col-12" style="margin-bottom:25px">
				<center>
					<img style="width:60%" src="../../images/numericScale.jpg" alt="" srcset=""><br>
					<?php if(isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])): ?>
						<div><b><?=$data['numeric_scale']?></b></div>
					<?php else: ?>
						<input value="<?=$data['numeric_scale']?>" type="number" name="numericScale" max="10" min="0" id="">
					<?php endif; ?>
				</center>
			</div>

				<div class="col-12">
					<span><b>Keputusan  : </b></span>
					<div class="row">

					<div class="col-4">
						<ul class="margsDown">
							<li class="li">
								<?php if($data["keputusan"] == "Antrian"):?>
									<?= inputField('radio', 'Antrian', 'checked', 'keputusan') ?> Sesuai Antrian
								<?php else: ?>
									<?= inputField('radio', 'Antrian', '', 'keputusan') ?> Sesuai Antrian
								<?php endif; ?>
								
							</li>
							<li>
								<?php if($data["keputusan"] == "Umum"):?>
									<?= inputField('radio', 'Umum', 'checked', 'keputusan') ?> Poli Umum
								<?php else: ?>
									<?= inputField('radio', 'Umum', '', 'keputusan') ?> Poli Umum
								<?php endif; ?>
								
							</li>
						</ul>
					</div>
					<div class="col-4">
						<ul class="margsDown">
							<li class="li">
								<?php if($data["keputusan"] == "Jalur Cepat"):?>
									<?= inputField('radio', 'Jalur Cepat', 'checked', 'keputusan') ?> Jalur Cepat  / Fast track
								<?php else: ?>
									<?= inputField('radio', 'Jalur Cepat', '', 'keputusan') ?> Jalur Cepat  / Fast track
								<?php endif; ?>
								
							</li>
							<li>
								<?php if($data["keputusan"] == "Spesialis"):?>
									<?= inputField('radio', 'Spesialis', 'checked', 'keputusan') ?> Poli Spesialis
								<?php else: ?>
									<?= inputField('radio', 'Spesialis', '', 'keputusan') ?> Poli Spesialis
								<?php endif; ?>
								
							</li>
						</ul>
					</div>
					<div class="col-4">
						<ul class="margsDown">
							<li>
								<?php if($data["keputusan"] == "IGD"):?>
									<?= inputField('radio', 'IGD', 'checked', 'keputusan') ?> Transfer IGD
								<?php else: ?>
									<?= inputField('radio', 'IGD', '', 'keputusan') ?> Transfer IGD
								<?php endif; ?>
								
							</li>
						</ul>
					</div>
				<div>
				</div>

			<div class="col-12">
				<div>Pita <span class="bg-warning">&nbsp;Kuning&nbsp;</span> : Resiko Jatuh Tinggi</div>
				<div>Pita <span class="bg-danger">&nbsp;Merah&nbsp;</span>   : Jalur Cepat/ Fast track  (Ibu Hamil (8 bulan) , Lansia ( kondisi khusus), Cacat</div>
			</div>

			<div class="col-12" style="margin-top:25px">
				<?php if($data["id"] == "" && !isset($_REQUEST['pdf'])): ?>
					<?= submitButton('btn-save-lembar-skrining', 'btn btn-success', 'submit', 'Simpan') ?>
				<?php elseif(isset($_REQUEST["id"])): ?>
					<button class="btn btn-primary" type="submit">Ganti</button>
				<?php endif; ?>
			</div>

		<?= formClose(); ?>

		<?php if(isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])): ?>
		<div class="bg-black" style="width: 100%;position: relative;outline-color: black;border: 1px solid black"></div>
		<center style="width: 100%;margin-bottom: 120px"><div>Tanda Tangan Petugas Skrining</div></center>
		<center style="width: 100%"><div>............................................................................</div></center>
	</div>
	<div style="width: 100%"><img style="float: right;transform: scale(0.5);margin-right: -200px" src="../../images/alamat.jpg"></div>
		<?php endif; ?>
	<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery-1.9.1.js"></script>
	<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery.form.js"></script>
    <script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>
    <script type="text/javascript" src="../../theme/js/ajax.js"></script>
	<script src="../../theme/bs/bootstrap.min.js"></script>
	<script>
		<?php if (isset($_REQUEST["pdf"])): ?>
			let identifier = '<?=$dataPasien["nama"]?>';
			printPDF('RM 1.1 '+identifier);
		<?php endif; ?>
	</script>

</body>

</html>