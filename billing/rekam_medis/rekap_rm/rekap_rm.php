<?php

include "funct.php";

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="../../theme/bs/bootstrap.min.css">
	<title>Rekap RM <?=$dataPasien["nama"]?></title>
</head>
<body class="container pt-5">
	<h1 class="text-center">Rekap RM <?=$dataPasien["nama"]?></h1>
	<hr>
	<table class="mt-5 text-center table table-bordered table-striped">
		<thead class="bg-info text-white">
			<tr>
				<th>Tanggal / Waktu</th>
				<th>Nama RM</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_identitas_pasien", "tgl_act", "rm_identitas_pasien", "form.php", "RM 1 Identitas Pasien", "cetak", "edit.php", "id"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_1_1_lembar_skrining_rj", "tgl_act", "rm_1_1_lembar_skrining_rj", "form.php", "RM 1.1 Lembar Skrining Rawat Jalan", "cetak", "form.php", "id"); ?>

			<?= getData("noPDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_general_consent", "tgl_act", "rm_general_consent", "print.php", "RM 2 General Consent", "id", "edit.php", "id"); ?>
		
			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_pengkajian_awal_pasien_rj", "tgl_act", "rm_pengkajian_awal_pasien_rj", "form.php", "RM 2.1 Pengkajian Awal Pasien Rawat Jalan", "cetak", "form.php", "id"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tanggal_act, id", "rm_2_2_p_dalam", "tanggal_act", "rm_2_2_p_dalam", "cetak.php", "RM 2.2 Poli Penyakit Dalam", "id", "form.php", "id"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tanggal_act, id", "rm_2_3_p_anak", "tanggal_act", "rm_2_3_p_anak", "cetak.php", "RM 2.3 Poli Anak", "id", "form.php", "id"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tanggal_act, id", "rm_2_4_p_obgin", "tanggal_act", "rm_p_obgin", "cetak.php", "RM 2.4 Poli Obgin", "id", "form.php", "id"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_poli_paru", "tgl_act", "rm_poli_paru", "form.php", "RM 2.5 Poli Paru", "cetak", "form.php", "id"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_poli_tht", "tgl_act", "rm_poli_tht", "form.php", "RM 2.6 Poli THT", "cetak", "form.php", "id"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tanggal_act, id", "rm_2_7_p_bedah", "tanggal_act", "rm_2_7_p_bedah", "cetak.php", "RM 2.7 Poli Bedah", "id", "form.php", "id"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_poli_gigi", "tgl_act", "rm_poli_gigi", "form.php", "RM 2.8 Poli Gigi", "cetak", "form.php", "id"); ?>

			<?= getData("noPDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_surat_pernyataan_umum_bpjs", "tgl_act", "rm_surat_pernyataan_umum_bpjs", "print.php", "RM 3 Surat Pernyataan Umum BPJS", "id", "edit.php", "id"); ?>

			<?= getData("noPDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_resume, id", "rm_resume_rawat_jalan", "tgl_resume", "rm_resume_rawat_jalan", "print.php", "RM 3.1 Resume Rawat Jalan", "id", "edit.php", "id"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_triase_pasien_gd", "tgl_act", "rm_triase_pasien_gd", "form.php", "RM 4 Triase Pasien Gawat Darurat", "cetak", "form.php", "id"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_pengkajian_awal_pasien_ri", "tgl_act", "rm_pengkajian_awal_pasien_rawat_inap", "form.php", "RM 5 Pengkajian Awal Pasien Rawat Inap", "cetak", "form.php", "id"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_asesmen_awak_kebidanan", "tgl_act", "rm_asesmen_awak_kebidanan", "form.php", "RM 5.1 Asesmen Awal Kebidanan", "cetak", "form.php", "id"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_asesmen_neonatus", "tgl_act", "rm_asesmen_awal_neonatus", "form.php", "RM 5.2 Asesmen Neonatus", "cetak", "form.php", "id"); ?>
			
			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_monitoring_dan_evaluasi_jatuh", "tgl_act", "rm_monitoring_dan_evaluasi_jatuh", "form.php", "RM 5.2.2 & RM 5.2.3 Monitoring Dan Evaluasi Jatuh", "cetak", "form.php", "id"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_edukasi_terintegrasi", "tgl_act", "rm_edukasi_terintegrasi", "form.php", "RM 6 Edukasi Terintegrasi", "cetak", "form.php", "id"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_7_transfer_pasien", "tgl_act", "rm_7_transfer_pasien", "form.php", "RM 7 Transfer Pasien", "cetak", "form.php", "id"); ?>

			<?= getData("noPDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_transfer_external", "tgl_act", "rm_transfer_external", "print.php", "RM 7.1 Transfer Ekternal", "id", "edit.php", "id"); ?>

			<?= getRm8($_REQUEST['idKunj'], "noPDF", "rm_catatan_pasien_terintegrasi", "cetak_catatan_pasien_terintegrasi.php", "RM 8 Catatan Pasien Terintegrasi", "id", "index.php") ?>

			<?= getData("noPDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_dpjp", "tgl_act", "rm_daftar_dpjp", "cetak_dpjp.php", "RM 11 DPJP", "id", "index.php", "modalUpdate"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_nyeri_intervensi", "tgl_act", "rm_nyeri_intervensi", "form.php", "RM 12 Nyeri Intervensi", "cetak", "form.php", "id"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_12_1_resiko_jatuh_anak", "tgl_act", "rm_12_1_asesmen_resiko_jatuh_anak", "form.php", "RM 12.1 Resiko Jatuh Anak", "cetak", "form.php", "id"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_12_2_resiko_jatuh_geriatri", "tgl_act", "rm_12_2_asesmen_resiko_jatuh_geriatri", "form.php", "RM 12.2 Resiko Jatuh Geriatri", "cetak", "form.php", "id"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_12_2_resiko_jatuh_morse_fall_scale", "tgl_act", "rm_12_3_asesmen_resiko_jatuh_morse_fall_scale", "form.php", "RM 12.3 Asesmen Resiko Jatuh Morse Fall Scale", "cetak", "form.php", "id"); ?>

			<?= getData("noPDF", "id_kunjungan = " . $_REQUEST['idKunj'], "hari_tanggal, id", "rm_assesmen_nyeri_farmakologi", "hari_tanggal", "rm_assesmen_nyeri_farmakologi", "print_one.php", "RM 12.4 Nyeri Farmakologi", "id", "edit.php", "id"); ?>

			<?= getData("noPDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_jam, id", "rm_assesmen_nyeri_non_farmakologi", "tgl_jam", "rm_assesmen_nyeri_non_farmakologi", "edit.php", "RM 12.4 Nyeri Non Farmakologi", "id", "edit.php", "id"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_13_pemberian_obat_tepat_waktu", "tgl_act", "rm_13_pemberian_obat_tepat_waktu", "form.php", "RM 13 Pemberian Obat Tepat Waktu", "cetak", "form.php", "id"); ?>

			<?= getData("noPDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_rekonsilasi_obat", "tgl_act", "rm_rekonsilasi_obat", "cetak_rekonsilasi_obat.php", "RM 14 Rekonsiliasi Obat", "id", "index.php", "modalUpdate"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_15_asuhan_gizi_dewasa", "tgl_act", "rm_15_asuhan_gizi_dewasa", "form.php", "RM 15 Asuhan Gizi Dewasa", "cetak", "form.php", "id"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_15_1_asuhan_gizi_anak", "tgl_act", "rm_15_1_asuhan_gizi_anak", "form.php", "RM 15.1 Asuhan Gizi Anak", "cetak", "form.php", "id"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_15_2_monitoring_makanan", "tgl_act", "rm_15_2_monitoring_makanan", "form.php", "RM 15.2 Monitoring Makanan", "cetak", "form.php", "id"); ?>

			<?= getData("noPDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_pesanan_menu_harian", "tgl_act", "rm_pesanan_menu_harian", "cetakPesanan_menu_harian.php", "RM 15.3 Pesanan Menu Harian", "id", "index.php", "modalUpdate"); ?>

			<?= getData("noPDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_bon_perubahan_makanan", "tgl_act", "rm_bon_perubahan_makanan", "cetak_bon_perubahan_makanan.php", "RM 15.4 Bon Perubahan Makanan", "id", "index.php", "modalUpdate"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_15_6_skrining_gizi_mst", "tgl_act", "rm_skrining_gizi_mst", "form.php", "RM 15.5 Skrining Gizi MST", "cetak", "form.php", "id"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_15_6_skrining_gizi_lanjut", "tgl_act", "rm_skrining_gizi_lanjut", "form.php", "RM 15.6 Skrining Gizi Lanjut", "cetak", "form.php", "id"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_16_pasien_pulang", "tgl_act", "rm_16_pasien_pulang", "form.php", "RM 16 Pasien Pulang", "cetak", "form.php", "id"); ?>

			<?= getData("noPDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_resume_keluar_pasien_ugd", "tgl_act", "rm_resume_keluar_pasien_ugd", "print.php", "RM 16.1 Resume Keluar Pasien UGD", "id", "edit.php", "id"); ?>

			<?= getData("noPDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_permintaan_laboratorium", "tgl_act", "rm_permintaan_laboratorium", "print.php", "RM 17 Permintaan Laboratorium", "id", "edit.php", "id"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_labotarium_patologi", "tgl_act", "rm_labotarium_patologi", "form.php", "RM 17.1 Laboratorium Patologi", "cetak", "form.php", "id"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_18_pemeriksaan_radiologi", "tgl_act", "rm_18_surat_pemeriksaan_radiologi", "form.php", "RM 18 Pemeriksaaan Radiologi", "cetak", "form.php", "id"); ?>

			<?= getData("noPDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_pasien_pulang", "tgl_act", "rm_pulang_atas_permintaan_pasien", "cetak_pasien_pulang.php", "RM 20 Pasien Pulang", "id", "index.php", "modalUpdate"); ?>

			<?= getData("noPDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_persetujuan_tindakan_kedokteran_operasi", "tgl_act", "rm_persetujuan_tindakan_kedokteran_operasi", "print.php", "RM 21 Persetujuan Tindakan Kedokteran Operasi", "id", "edit.php", "id"); ?>

			<?= getData("noPDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_penolakan_tindakan_kedokteran", "tgl_act", "rm_penolakan_tindakan_kedokteran", "print.php", "RM 21.1 Penolakan Tindakan Kedokteran", "id", "edit.php", "id"); ?>

			<?= getData("noPDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tanggal_prosedur, id", "rm_lokasi_penandaan_operasi", "tanggal_prosedur", "rm_lokasi_penandaan_operasi", "print.php", "RM 21.2 Lokasi Penandaaan Operasi", "id", "edit.php", "id"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_serah_terima_pasien_pre_operasi", "tgl_act", "rm_serah_terima_pasien_pra_operasi", "form.php", "RM 21.3 Serah Terima Pasien Pra Operasi", "cetak", "form.php", "id"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_penilaian_pre_anestesi", "tgl_act", "rm_penilaian_pre_anestesi", "form.php", "RM 21.4 Penilaian Pre Anestesi", "cetak", "form.php", "id"); ?>

			<?= getData("noPDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_pemantauan_anestesi_lokal", "tgl_act", "rm_pemantauan_anestesi_lokal", "print.php", "RM 21.7 Pemantauan Anestesi Lokal", "id", "edit.php", "id"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_edukasi_tindakan_anestesi_sedasi", "tgl_act", "rm_edukasi_tindakan_anestesi_sedasi", "print.php", "RM 21.8 & RM 21.9 Edukasi Tindakan Anestsei Sedasi", "cetak", "form.php", "id"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_asesmen_pra_sedasi_anestesi", "tgl_act", "rm_asesmen_pra_sedasi_anestesi", "form.php", "RM 21.10 Asesmen Pra Sedasi Anestesi", "cetak", "form.php", "id"); ?>

			<?= getData("noPDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_checklist_kesiapan_anestesi", "tgl_act", "rm_checklist_kesiapan_anestesi", "print.php", "RM 21.11 Checklist Kesiapan Anestesi", "id", "edit.php", "id"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_lembar_p_sedasi", "tgl_act", "rm_lembar_pencatatan_sedasi", "form.php", "RM 21.12 Lembar Pemauntauan Sedasi", "cetak", "form.php", "id"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_21_13_laporan_anestesi", "tgl_act", "rm_laporan_anestesi", "form.php", "RM 21.13 Laporan Anestesi", "cetak", "form.php", "id"); ?>

			<?= getData("noPDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_laporan_operasi", "tgl_act", "rm_laporan_operasi", "print.php", "RM 21.14 Laporan Operasi", "id", "edit.php", "id"); ?>

			<?= getData("noPDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_serah_terima_pasien_post_operasi", "tgl_act", "rm_serah_terima_pasien_post_operasi", "print.php", "RM 21.17 Serah Terima Pasien Post Operasi", "id", "edit.php", "id"); ?>

			<?= getData("noPDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_dokumen_pelayanan_kamar", "tgl_act", "rm_dokumen_pelayanan_kamar", "print.php", "RM 21.18 Dokumen Pelayanan Kamar", "id", "edit.php", "id"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_asuhan_keperawatan_properatif", "tgl_act", "rm_asuhan_keperawatan_properatif", "form.php", "RM 21.19 Asuhan Keperawatan Preoperatif", "cetak", "form.php", "id"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_checklist_kesiapan_operasi", "tgl_act", "rm_checklist_kesiapan_operasi", "form.php", "RM 21.20 Cheklist Kesiapan Operasi", "cetak", "form.php", "id"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_asuhan_rak", "tgl_act", "rm_rencana_asuhan_keperawatan_rak", "form.php", "RM 22 Asuhan RAK", "cetak", "form.php", "id"); ?>

			<?= getData("noPDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_asuhan_keperawatan", "tgl_act", "rm_asuhan_keperawatan", "print.php", "RM 22.1 Asuhan Keperawatan", "id", "edit.php", "id"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_pengkajian_pasien_terminal", "tgl_act", "rm_pengkajian_pasien_terminal", "form.php", "RM 23 Pengkajian Pasien Terminal", "cetak", "form.php", "id"); ?>

			<?= getData("noPDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_pemberian_transfusi_darah", "tgl_act", "rm_pemberian_transfusi_darah", "print.php", "RM 24 Pemberian Trasnfusi Darah", "id", "edit.php", "id"); ?>

			<?= getData("noPDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_persetujuan_penolakan_tindakan_transfusi", "tgl_act", "rm_persetujuan_penolakan_tindakan_transfusi", "print.php", "RM 24.1 Persetujuan Penolakan Tindakan Transfusi", "id", "edit.php", "id"); ?>

			<?= getData("PDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_monitoring_transfusi_darah", "tgl_act", "rm_monitoring_transfusi_darah", "form.php", "RM 24.2 Monitoring Transfusi Darah", "cetak", "form.php", "id"); ?>

			<?= getData("noPDF", "id_kunjungan = " . $_REQUEST['idKunj'], "hari_tanggal_jam_transfusi, id", "rm_dugaan_reaksi_transfusi", "hari_tanggal_jam_transfusi", "rm_dugaan_reaksi_transfusi", "print.php", "RM 24.3 Dugaan Reaksi Transfusi", "id", "edit.php", "id"); ?>

			<?= getData("noPDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_pasien_komplain", "tgl_act", "rm_pasien_komplain", "cetak_pasien_komplain.php", "RM 25 & RM 25.1 Pasien Komplain", "id", "index.php", "modalUpdate"); ?>

			<?= getData("noPDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_resusitasi", "tgl_act", "rm_resusitasi", "cetak_resusitasi.php", "RM 26 Resuitasi", "id", "index.php", "modalUpdate"); ?>

			<?= getData("noPDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_pernyataan_permintaan_pendapat", "tgl_act", "rm_pernyataan_permintaan_pendapat", "cetak_pasien_pulang.php", "RM 27 Pernyataan Permintaan Pendapat", "id", "index.php", "modalUpdate"); ?>

			<?= getData("noPDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_checklist_rencana_pulang", "tgl_act", "rm_checklist_rencana_pulang", "print.php", "RM 28 Checklist Rencana Pulang", "id", "edit.php", "id"); ?>

			<?= getData("noPDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_pelayanan_kegiatan_rohani", "tgl_act", "rm_pelayanan_kegiatan_rohani", "cetak_pelayanan_kegiatan_rohani.php", "RM 29 Pelayanan Kegiatan Rohani", "id", "index.php", "modalUpdate"); ?>

			<?= getData("noPDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_asesmen_khusus_restrain", "tgl_act", "rm_asesmen_khusus_restrain", "print.php", "RM 30 Asesmen Khusus Restrain", "id", "edit.php", "id"); ?>

			<?= getData("noPDF", "id_kunjungan = " . $_REQUEST['idKunj'], "tgl_act, id", "rm_barang_pasien", "tgl_act", "rm_penyimpanan_barang_pasien", "cetakBarang_pasien.php", "RM 31 Barang Pasien", "id", "index.php", "modalUpdate"); ?>
		</tbody>

</table>

<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery-1.9.1.js"></script>
<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery.form.js"></script>
    <script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>
    <script type="text/javascript" src="../../theme/js/ajax.js"></script>
<script src="../../theme/bs/bootstrap.min.js"></script>
</body>
</html>