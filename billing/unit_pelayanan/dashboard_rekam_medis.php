<?php
include '../koneksi/konek.php';
include '../sesi.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="../theme/tab-view.css" />
	<script type="text/javascript" src="../theme/js/tab-view.js"></script>
	<link type="text/css" rel="stylesheet" href="../theme/mod.css" />
	<script type="text/JavaScript" language="JavaScript" src="../include/jquery/jquery-1.9.1.js"></script>
	<script type="text/JavaScript" language="JavaScript" src="../include/jquery/jquery.form.js"></script>
	<script type="text/JavaScript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
	<script type="text/JavaScript" language="JavaScript" src="../theme/js/mod.js"></script>
	<script type="text/javascript" language="javascript" src="../loket/jquery.maskedinput.js"></script>
	<!--script src="../theme/dhtmlxcalendar.js" type="text/javascript"></script-->
	<script type="text/javascript" src="../theme/js/ajax.js"></script>
	<!--dibawah ini diperlukan untuk menampilkan menu dropdown-->
	<script language="JavaScript" src="../theme/js/mm_menu.js"></script>
	<!--<script language="JavaScript" src="../theme/js/dropdown.js"></script>-->
	<?php include("dropdown.php"); ?>

	<link rel="stylesheet" type="text/css" href="jquery_multiselect/jquery.multiselect.css" />
	<link rel="stylesheet" type="text/css" href="jquery_multiselect/style.css" />
	<link rel="stylesheet" type="text/css" href="../theme/bs/bootstrap.min.css" />

	<link rel="stylesheet" type="text/css" href="jquery_multiselect/jquery-ui.css" />
	<!--<script type="text/javascript" src="jquery_multiselect/jquery.js"></script>-->
	<script type="text/javascript" src="jquery_multiselect/jquery-ui.min.js"></script>
	<script type="text/javascript" src="jquery_multiselect/src/jquery.multiselect.js"></script>

	<!--dibawah ini diperlukan untuk menampilkan popup-->
	<link rel="stylesheet" type="text/css" href="../theme/popup.css" />
	<script type="text/javascript" src="../theme/prototype.js"></script>
	<script type="text/javascript" src="../theme/effects.js"></script>
	<script type="text/javascript" src="../theme/popup.js"></script>
	<script src="../theme/bs/bootstrap.min.js"></script>
</head>

<body>
	<div align="center">
		<?php include("../header1.php"); ?>
		<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
			<tr>
				<td height="30">&nbsp;LIST REKAM MEDIS</td>
			</tr>
		</table>
		<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center" class="tabel">
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td colspan="3" align="center">
					<div class="container">
						<table class="table table-sm table-bordered">
							<thead>
								<tr>
									<th>NAMA RM</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>RM 1 Identitas Pasien</td>
									<td>
										<a href="../rekam_medis/rm_identitas_pasien/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary" class="btn btn-sm btn-primary" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 1.1 Lembar Skrining Rawat Jalan</td>
									<td>
										<a href="../rekam_medis/rm_1_1_lembar_skrining_rj/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 2 General Consest</td>
									<td>
                                    <a href="../rekam_medis/rm_general_consent/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 2.1 Pengkajian Awal Keperawatan Pasien Rawat Jalan</td>
									<td>
										<a href="../rekam_medis/rm_pengkajian_awal_pasien_rj/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary" class="btn btn-sm btn-primary" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 2.2 P. Dalam</td>
									<td>
										<a href="../rekam_medis/rm_2_2_p_dalam/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 2.3 P. Anak</td>
									<td>
										<a href="../rekam_medis/rm_2_3_p_anak/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 2.4 P. OBGIN</td>
									<td>
										<a href="../rekam_medis/rm_p_obgin/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 2.5 P. Paru</td>
									<td>
										<a href="../rekam_medis/rm_poli_paru/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 2.6 P. THT</td>
									<td>
										<a href="../rekam_medis/rm_poli_tht/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 2.7 P. Bedah</td>
									<td>
										<a href="../rekam_medis/rm_2_7_p_bedah/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 2.8 P. Gigi</td>
									<td>
										<a href="../rekam_medis/rm_poli_gigi/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 3 Surat Pernyataan Umum & BPJS</td>
									<td>
									<a href="../rekam_medis/rm_surat_pernyataan_umum_bpjs/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 3.1 Resume Rawat Jalan</td>
									<td>
										<a href="../rekam_medis/rm_resume_rawat_jalan/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 4 Triase Pasien Gawat Darurat</td>
									<td>
										<a href="../rekam_medis/rm_triase_pasien_gd/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 5 Pengkajian Awal Pasien Rawat Inap</td>
									<td>
										<a href="../rekam_medis/rm_pengkajian_awal_pasien_rawat_inap/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>
										RM 5.1 Asesmen Awak Kebidanan RWI(Ante,Intra dan Post Partum)
									</td>
									<td>
										<a href="../rekam_medis/rm_asesmen_awak_kebidanan/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 5.2 Asesmen Awal Neonatus</td>
									<td>
										<a href="../rekam_medis/rm_asesmen_awal_neonatus/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 5.2.2 & RM 5.2.3  LEMBAR  MONITORING DAN EVALUASI  PENCEGAHAN PASIEN JATUH</td>
									<td>
										<a href="../rekam_medis/rm_monitoring_dan_evaluasi_jatuh/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 6 EDUKASI TERINTEGRASI</td>
									<td>
										<a href="../rekam_medis/rm_edukasi_terintegrasi/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 7 Transfer Pasien Antar Ruangan Instalasi RS</td>
									<td>
										<a href="../rekam_medis/rm_7_transfer_pasien/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 7.1 Form Transfer External - tandai</td>
									<td>
										<a href="../rekam_medis/rm_transfer_external/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 8 Catatan Pekembangan Pasien Terintegrasi</td>
									<td>
										<a href="../rekam_medis/rm_catatan_pasien_terintegrasi/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 11 DAFTAR DPJP</td>
									<td>
										<a href="../rekam_medis/rm_daftar_dpjp/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 12 Asesmen Lanjutan Nyeri dan Intervensi</td>
									<td>
										<a href="../rekam_medis/rm_nyeri_intervensi/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 12.1 Asesmen Resiko Jatuh Anak</td>
									<td>
										<a href="../rekam_medis/rm_12_1_asesmen_resiko_jatuh_anak/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 12.2 Asesmen Resiko Jatuh Geriatri</td>
									<td>
										<a href="../rekam_medis/rm_12_2_asesmen_resiko_jatuh_geriatri/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 12.3 Asesmen Resiko Jatuh Morse Fall Scale</td>
									<td>
										<a href="../rekam_medis/rm_12_3_asesmen_resiko_jatuh_morse_fall_scale/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 12.4 Assesmen Nyeri Farmakologi</td>
									<td>
										<a href="../rekam_medis/rm_assesmen_nyeri_farmakologi/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 12.4 Assesmen Nyeri Non Farmakologi</td>
									<td>
										<a href="../rekam_medis/rm_assesmen_nyeri_non_farmakologi/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 13 Pemberian Obat Tepat Waktu</td>
									<td>
										<a href="../rekam_medis/rm_13_pemberian_obat_tepat_waktu/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 14 REKONSILIASI OBAT</td>
									<td>
										<a href="../rekam_medis/rm_rekonsilasi_obat/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 15 Asuhan Gizi Dewasa</td>
									<td>
										<a href="../rekam_medis/rm_15_asuhan_gizi_dewasa/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 15.1 Asuhan Gizi Anak</td>
									<td>
										<a href="../rekam_medis/rm_15_1_asuhan_gizi_anak/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 15.2 Monitoring Makanan</td>
									<td>
										<a href="../rekam_medis/rm_15_2_monitoring_makanan/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 15.3 Form Pesanan Menu Harian</td>
									<td>
										<a href="../rekam_medis/rm_pesanan_menu_harian/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 15.4 Bon Perubahan Makanan</td>
									<td>
										<a href="../rekam_medis/rm_bon_perubahan_makanan/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 15.5 Skrining Gizi (MST)</td>
									<td>
										<a href="../rekam_medis/rm_skrining_gizi_mst/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 15.6 Skrining Gizi Lanjut</td>
									<td>
										<a href="../rekam_medis/rm_skrining_gizi_lanjut/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 16 Pasien Pulang</td>
									<td>
										<a href="../rekam_medis/rm_16_pasien_pulang/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
                                </tr>
                                <tr>
									<td>RM 16.1 Resume keluar Pasien UGD</td>
									<td>
										<a href="../rekam_medis/rm_resume_keluar_pasien_ugd/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
                                </tr>
                                <tr>
									<td>RM 17 Formulir Permintaan Laboratorium</td>
									<td>
										<a href="../rekam_medis/rm_permintaan_laboratorium/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 17.1 HASIL PEMERIKSAAN LABORATORIUM PATOLOGI</td>
									<td>
										<a href="../rekam_medis/rm_labotarium_patologi/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 18 Surat Pemeriksaan Radiologi</td>
									<td>
										<a href="../rekam_medis/rm_18_surat_pemeriksaan_radiologi/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 20 Pulang Atas Permintaan Pasien</td>
									<td>
										<a href="../rekam_medis/rm_pulang_atas_permintaan_pasien/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 21 PERSETUJUAN TINDAKAN KEDOKTERAN OPERASI</td>
									<td>
										<a href="../rekam_medis/rm_persetujuan_tindakan_kedokteran_operasi/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 21.1 PENOLAKAN TINDAKAN KEDOKTERAN </td>
									<td>
										<a href="../rekam_medis/rm_penolakan_tindakan_kedokteran/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
                                <tr>
									<td>RM 21.2 Penandaan Lokasi Operasi (SITE MARKING)</td>
									<td>
										<a href="../rekam_medis/rm_lokasi_penandaan_operasi/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
                              <tr>
									<td>RM 21.3 CHECK LIST SERAH TERIMA PASIEN PRE OPERASI</td>
									<td>
										<a href="../rekam_medis/rm_serah_terima_pasien_pra_operasi/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 21.4 FORMULIR  PENILAIAN  PRE – ANESTESI/SEDASI</td>
									<td>
										<a href="../rekam_medis/rm_penilaian_pre_anestesi/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
                                <tr>
									<td>RM 21.7_PEMANTAUAN_ANESTESI_LOKAL</td>
									<td>
										<a href="../rekam_medis/rm_pemantauan_anestesi_lokal/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 21.8 EDUKASI TINDAKAN ANESTESI SEDASI</td>
									<td>
										<a href="../rekam_medis/rm_edukasi_tindakan_anestesi_sedasi/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 21.9 CHECK LIST KESIAPAN TINDAKAN SEDASI</td>
									<td>
										<a href="../rekam_medis/rm_edukasi_tindakan_anestesi_sedasi/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
                                </tr>
                                <tr>
									<td>RM 21.10 ASSESMEN PRA SEDASI / ANASTESI</td>
									<td>
										<a href="../rekam_medis/rm_asesmen_pra_sedasi_anestesi/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
                                </tr>
                                <tr>
									<td>RM 21.11 Check List Kesiapan Anastesi - tandai</td>
									<td>
										<a href="../rekam_medis/rm_checklist_kesiapan_anestesi/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 21.12 LEMBAR PENCATATAN SEDASI</td>
									<td>
										<a href="../rekam_medis/rm_lembar_pencatatan_sedasi/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 21.13 LAPORAN ANESTESI</td>
									<td>
										<a href="../rekam_medis/rm_laporan_anestesi/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 21.14 Laporan Operasi</td>
									<td>
										<a href="../rekam_medis/rm_laporan_operasi/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
                                </tr>
                                <tr>
									<td>RM 21.15 Check List Kesiapan Bedah</td>
									<td>
										<a href="../rekam_medis/rm_list_kesiapan_bedah/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
                                </tr>
                                <tr>
									<td>RM 21.16 Asesmen Pra Operasi</td>
									<td>
										<a href="../rekam_medis/rm_asesmen_pra_opreasi/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
                                </tr>
                                <tr>
									<td>RM 21.17 Check List Serah Terima Pasien Post Operasi - tandai</td>
									<td>
										<a href="../rekam_medis/rm_serah_terima_pasien_post_operasi/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
                                </tr>
								
								<tr>
									<td>RM 21.18  Lembar Dokumen Pelayanan Kamar (Transfer Pasien OK-RR-RUANG RAWAT)</td>
									<td>
										<a href="../rekam_medis/rm_dokumen_pelayanan_kamar/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
                                </tr>
                                <tr>
									<td>RM 21.19 ASUHAN KEPERAWATAN PREOPERATIF</td>
									<td>
										<a href="../rekam_medis/rm_asuhan_keperawatan_properatif/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
                                </tr>
								<!-- <tr>
									<td>RM 21.20 Cheklis Kesiapan Operasi</td>
									<td>
										<a href="../rekam_medis/rm_checklist_kesiapan_operasi/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
                                </tr> -->
                                <tr>
									<td>RM 21.20 CEKLIS KESELAMATAN OPERASI</td>
									<td>
										<a href="../rekam_medis/rm_checklist_kesiapan_operasi/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
                                </tr>
                                <tr>
									<td>RM 22 Rencana Asuhan Keperawatan (RAK) Nursing Care Plan</td>
									<td>
										<a href="../rekam_medis/rm_rencana_asuhan_keperawatan_rak/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
                                <tr>
									<td>RM 22.1 PLAN OF CARE</td>
									<td>
										<a href="../rekam_medis/rm_asuhan_keperawatan/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 23 PENGKAJIAN PASIEN TAHAP TERMINAL</td>
									<td>
										<a href="../rekam_medis/rm_pengkajian_pasien_terminal/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 24 Pemberian Transfusi Darah</td>
									<td>
										<a href="../rekam_medis/rm_pemberian_transfusi_darah/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
                                </tr>
                                <tr>
									<td>RM 24.1 PERSETUJUAN PENOLAKAN TINDAKAN TRANSFUSI</td>
									<td>
										<a href="../rekam_medis/rm_persetujuan_penolakan_tindakan_transfusi/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 24.2 MONITORING TRANSFUSI DARAH</td>
									<td>
										<a href="../rekam_medis/rm_monitoring_transfusi_darah/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
                                <tr>
									<td>RM 24.3 DUGAAN REAKSI TRANSFUSI</td>
									<td>
										<a href="../rekam_medis/rm_dugaan_reaksi_transfusi/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
                                </tr>
                                <tr>
									<td>RM 25 Formulir Komplain RM 25.1 Penyelesaian Komplain</td>
									<td>
										<a href="../rekam_medis/rm_pasien_komplain/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
                                </tr>
                                <tr>
									<td>RM 26 Formulir Do Not Rescuitace</td>
									<td>
										<a href="../rekam_medis/rm_resusitasi/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
                                </tr>
                                <tr>
									<td>RM 27 Pernyataan Permintaan Pendapat Lain (Second Opinion)</td>
									<td>
										<a href="../rekam_medis/rm_pernyataan_permintaan_pendapat/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 28 Discharge Planning</td>
									<td>
										<a href="../rekam_medis/rm_checklist_rencana_pulang/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 29 PERMINTAAN PELAYANAN KEGIATAN ROHANI</td>
									<td>
										<a href="../rekam_medis/rm_pelayanan_kegiatan_rohani/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								<tr>
									<td>RM 30 Asesmen Khusus Restrain</td>
									<td>
										<a href="../rekam_medis/rm_asesmen_khusus_restrain/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
								
								<tr>
									<td>RM 31 Formulir Penyimpanan Barang Berharga Milik Pasien</td>
									<td>
										<a href="../rekam_medis/rm_penyimpanan_barang_pasien/index.php?idKunj=<?= $_GET['idKunj'] ?>&idPel=<?= $_GET['idPel'] ?>&idPasien=<?= $_GET['idPasien'] ?>&idUser=<?= $_GET['idUser'] ?>&tmpLay=<?= $_REQUEST['tmpLay'] ?>" class="btn btn-sm btn-primary active" target="_blank">View</a>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</table>
	</div>
</body>

</html>