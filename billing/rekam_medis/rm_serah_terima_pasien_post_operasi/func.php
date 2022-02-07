<?php
require_once '../../koneksi/konek.php';
session_start();
date_default_timezone_set('Asia/Jakarta');

$idKunj=mysql_real_escape_string($_REQUEST['idKunj']);
$idPel=mysql_real_escape_string($_REQUEST['idPel']);


$sql = mysql_fetch_assoc(mysql_query("SELECT pasien_id FROM b_kunjungan WHERE id = '$idKunj'"));

$idPasien= $sql['pasien_id'];
$idUser=mysql_real_escape_string($_REQUEST['idUser']);

function GetAll($idKunj,$idPasien){
  

  $query = "SELECT * FROM rm_serah_terima_pasien_post_operasi WHERE id_kunjungan = '$idKunj' AND id_pasien ='$idPasien'";
  $exe = mysql_query($query);
  while($data = mysql_fetch_array($exe)){
    $datas[] = array('id' => $data['id'],
		'diagnosa' => $data['diagnosa'],
		'ruangan' => $data['ruangan'],
		'tgl_op' => $data['tgl_op'],
		'tindakan' => $data['tindakan'],
		'blagko_laporan_operasi_perawat_recoveryroom' => $data['blagko_laporan_operasi_perawat_recoveryroom'],
		'blagko_laporan_operasi_perawat_ruangan' => $data['blagko_laporan_operasi_perawat_ruangan'],
		'blagko_laporan_operasi_keterangan' => $data['blagko_laporan_operasi_keterangan'],
		'blagko_catatan_anestesi_perawat_recoveryroom' => $data['blagko_catatan_anestesi_perawat_recoveryroom'],
		'blagko_catatan_anestesi_perawat_ruangan' => $data['blagko_catatan_anestesi_perawat_ruangan'],
		'blagko_catatan_anestesi_keterangan' => $data['blagko_catatan_anestesi_keterangan'],
		'blagko_pemakaian_alat_perawat_recoveryroom' => $data['blagko_pemakaian_alat_perawat_recoveryroom'],
		'blagko_pemakaian_alat_perawat_ruangan' => $data['blagko_pemakaian_alat_perawat_ruangan'],
		'blagko_pemakaian_alat_keterangan' => $data['blagko_pemakaian_alat_keterangan'],
		'blangko_perawat_recoveryroom' => $data['blangko_perawat_recoveryroom'],
		'blangko_perawat_ruangan' => $data['blangko_perawat_ruangan'],
		'blangko_keterangan' => $data['blangko_keterangan'],
		'rontgen_thorax_perawat_recoveryroom' => $data['rontgen_thorax_perawat_recoveryroom'],
		'rontgen_thorax_perawat_ruangan' => $data['rontgen_thorax_perawat_ruangan'],
		'rontgen_thorax_keterangan' => $data['rontgen_thorax_keterangan'],
		'rontgen_ctscan_perawat_recoveryroom' => $data['rontgen_ctscan_perawat_recoveryroom'],
		'rontgen_ctscan_perawat_ruangan' => $data['rontgen_ctscan_perawat_ruangan'],
		'rontgen_ctscan_keterangan' => $data['rontgen_ctscan_keterangan'],
		'rontgen_usg_perawat_recoveryroom' => $data['rontgen_usg_perawat_recoveryroom'],
		'rontgen_usg_perawat_ruangan' => $data['rontgen_usg_perawat_ruangan'],
		'rontgen_usg_keterangan' => $data['rontgen_usg_keterangan'],
		'rontgen_fotolain_perawat_recoveryroom' => $data['rontgen_fotolain_perawat_recoveryroom'],
		'rontgen_fotolain_perawat_ruangan' => $data['rontgen_fotolain_perawat_ruangan'],
		'rontgen_fotolain_keterangan' => $data['rontgen_fotolain_keterangan'],
		'barang_milik_pasien_perawat_recoveryroom' => $data['barang_milik_pasien_perawat_recoveryroom'],
		'barang_milik_pasien_perawat_ruangan' => $data['barang_milik_pasien_perawat_ruangan'],
		'barang_milik_pasien_keterangan' => $data['barang_milik_pasien_keterangan'],
		'vital_sign_cek_terakhir_jam' => $data['vital_sign_cek_terakhir_jam'],
		'vital_sign_nadi' => $data['vital_sign_nadi'],
		'vital_sign_suhu' => $data['vital_sign_suhu'],
		'vital_sign_tensi_darah' => $data['vital_sign_tensi_darah'],
		'vital_sign_respirasi' => $data['vital_sign_respirasi'],
		'vital_sign_skala_nyeri' => $data['vital_sign_skala_nyeri'],
		'vital_sign_berat_badan' => $data['vital_sign_berat_badan'],
		'vital_sign_perawat_recoveryroom' => $data['vital_sign_perawat_recoveryroom'],
		'vital_sign_perawat_ruangan' => $data['vital_sign_perawat_ruangan'],
		'vital_sign_keterangan' => $data['vital_sign_keterangan'],
		'drain_opsi' => $data['drain_opsi'],
		'drain_perawat_recoveryroom' => $data['drain_perawat_recoveryroom'],
		'drain_perawat_ruangan' => $data['drain_perawat_ruangan'],
		'drain_keterangan' => $data['drain_keterangan'],
		'luka_opsi' => $data['luka_opsi'],
		'luka_perawat_recoveryroom' => $data['luka_perawat_recoveryroom'],
		'luka_perawat_ruangan' => $data['luka_perawat_ruangan'],
		'luka_keterangan' => $data['luka_keterangan'],
		'luka_operasi_ukuran' => $data['luka_operasi_ukuran'],
		'luka_operasi_lokasi' => $data['luka_operasi_lokasi'],
		'luka_bakar_ukuran' => $data['luka_bakar_ukuran'],
		'luka_bakar_lokasi' => $data['luka_bakar_lokasi'],
		'luka_bakar_kondisi' => $data['luka_bakar_kondisi'],
		'kulit_memerah_ukuran' => $data['kulit_memerah_ukuran'],
		'kulit_memerah_lokasi' => $data['kulit_memerah_lokasi'],
		'kulit_memerah_kondisi' => $data['kulit_memerah_kondisi'],
		'invasif_opsi' => $data['invasif_opsi'],
		'invasif_perawat_recoveryroom' => $data['invasif_perawat_recoveryroom'],
		'invasif_perawat_ruangan' => $data['invasif_perawat_ruangan'],
		'invasif_keterangan' => $data['invasif_keterangan'],
		'IV_line_tanggal' => $data['IV_line_tanggal'],
		'IV_line_posisi' => $data['IV_line_posisi'],
		'cvp_pic_tanggal' => $data['cvp_pic_tanggal'],
		'cvp_pic_posisi' => $data['cvp_pic_posisi'],
		'pemasangan_kateter_urine_nomor' => $data['pemasangan_kateter_urine_nomor'],
		'pemasangan_kateter_urine_tanggal' => $data['pemasangan_kateter_urine_tanggal'],
		'kateter_urine_perawat_recoveryroom' => $data['kateter_urine_perawat_recoveryroom'],
		'kateter_urine_perawat_ruangan' => $data['kateter_urine_perawat_ruangan'],
		'kateter_urine_keterangan' => $data['kateter_urine_keterangan'],
		'pemasangan_irigasi_tanggal' => $data['pemasangan_irigasi_tanggal'],
		'irigasi_perawat_recoveryroom' => $data['irigasi_perawat_recoveryroom'],
		'irigasi_perawat_ruangan' => $data['irigasi_perawat_ruangan'],
		'irigasi_keterangan' => $data['irigasi_keterangan'],
		'masalah_kamar_operasi_perawat_recoveryroom' => $data['masalah_kamar_operasi_perawat_recoveryroom'],
		'masalah_kamar_operasi_perawat_ruangan' => $data['masalah_kamar_operasi_perawat_ruangan'],
		'masalah_kamar_operasi_perawat_keterangan' => $data['masalah_kamar_operasi_perawat_keterangan'],
		'petugas_recovery_yang_menyerahkan' => $data['petugas_recovery_yang_menyerahkan'],
		'petugas_ruangan_yang_menerimah' => $data['petugas_ruangan_yang_menerimah'],
		'id_kunjungan' => $data['id_kunjungan'],
		'id_pelayanan' => $data['id_pelayanan'],
		'id_pasien' => $data['id_pasien'],
		'id_user' => $data['id_user'],
		
    );
  }
  return $datas;
}

function GetOne($id){
 
  $query = "SELECT * FROM  `rm_serah_terima_pasien_post_operasi` WHERE  `id` =  '$id'";
  $exe = mysql_query($query);
  while($data = mysql_fetch_array($exe)){
    $datas[] = array('id' => $data['id'], 
		'diagnosa' => $data['diagnosa'], 
		'ruangan' => $data['ruangan'], 
		'tgl_op' => $data['tgl_op'], 
		'tindakan' => $data['tindakan'], 
		'blagko_laporan_operasi_perawat_recoveryroom' => $data['blagko_laporan_operasi_perawat_recoveryroom'], 
		'blagko_laporan_operasi_perawat_ruangan' => $data['blagko_laporan_operasi_perawat_ruangan'], 
		'blagko_laporan_operasi_keterangan' => $data['blagko_laporan_operasi_keterangan'], 
		'blagko_catatan_anestesi_perawat_recoveryroom' => $data['blagko_catatan_anestesi_perawat_recoveryroom'], 
		'blagko_catatan_anestesi_perawat_ruangan' => $data['blagko_catatan_anestesi_perawat_ruangan'], 
		'blagko_catatan_anestesi_keterangan' => $data['blagko_catatan_anestesi_keterangan'], 
		'blagko_pemakaian_alat_perawat_recoveryroom' => $data['blagko_pemakaian_alat_perawat_recoveryroom'], 
		'blagko_pemakaian_alat_perawat_ruangan' => $data['blagko_pemakaian_alat_perawat_ruangan'], 
		'blagko_pemakaian_alat_keterangan' => $data['blagko_pemakaian_alat_keterangan'], 
		'blangko_perawat_recoveryroom' => $data['blangko_perawat_recoveryroom'], 
		'blangko_perawat_ruangan' => $data['blangko_perawat_ruangan'], 
		'blangko_keterangan' => $data['blangko_keterangan'], 
		'rontgen_thorax_perawat_recoveryroom' => $data['rontgen_thorax_perawat_recoveryroom'], 
		'rontgen_thorax_perawat_ruangan' => $data['rontgen_thorax_perawat_ruangan'], 
		'rontgen_thorax_keterangan' => $data['rontgen_thorax_keterangan'], 
		'rontgen_ctscan_perawat_recoveryroom' => $data['rontgen_ctscan_perawat_recoveryroom'], 
		'rontgen_ctscan_perawat_ruangan' => $data['rontgen_ctscan_perawat_ruangan'], 
		'rontgen_ctscan_keterangan' => $data['rontgen_ctscan_keterangan'], 
		'rontgen_usg_perawat_recoveryroom' => $data['rontgen_usg_perawat_recoveryroom'], 
		'rontgen_usg_perawat_ruangan' => $data['rontgen_usg_perawat_ruangan'], 
		'rontgen_usg_keterangan' => $data['rontgen_usg_keterangan'], 
		'rontgen_fotolain_perawat_recoveryroom' => $data['rontgen_fotolain_perawat_recoveryroom'], 
		'rontgen_fotolain_perawat_ruangan' => $data['rontgen_fotolain_perawat_ruangan'], 
		'rontgen_fotolain_keterangan' => $data['rontgen_fotolain_keterangan'], 
		'barang_milik_pasien_perawat_recoveryroom' => $data['barang_milik_pasien_perawat_recoveryroom'], 
		'barang_milik_pasien_perawat_ruangan' => $data['barang_milik_pasien_perawat_ruangan'], 
		'barang_milik_pasien_keterangan' => $data['barang_milik_pasien_keterangan'], 
		'vital_sign_cek_terakhir_jam' => $data['vital_sign_cek_terakhir_jam'], 
		'vital_sign_nadi' => $data['vital_sign_nadi'], 
		'vital_sign_suhu' => $data['vital_sign_suhu'], 
		'vital_sign_tensi_darah' => $data['vital_sign_tensi_darah'], 
		'vital_sign_respirasi' => $data['vital_sign_respirasi'], 
		'vital_sign_skala_nyeri' => $data['vital_sign_skala_nyeri'], 
		'vital_sign_berat_badan' => $data['vital_sign_berat_badan'], 
		'vital_sign_perawat_recoveryroom' => $data['vital_sign_perawat_recoveryroom'], 
		'vital_sign_perawat_ruangan' => $data['vital_sign_perawat_ruangan'], 
		'vital_sign_keterangan' => $data['vital_sign_keterangan'], 
		'drain_opsi' => $data['drain_opsi'], 
		'drain_perawat_recoveryroom' => $data['drain_perawat_recoveryroom'], 
		'drain_perawat_ruangan' => $data['drain_perawat_ruangan'], 
		'drain_keterangan' => $data['drain_keterangan'], 
		'luka_opsi' => $data['luka_opsi'], 
		'luka_perawat_recoveryroom' => $data['luka_perawat_recoveryroom'], 
		'luka_perawat_ruangan' => $data['luka_perawat_ruangan'], 
		'luka_keterangan' => $data['luka_keterangan'], 
		'luka_operasi_ukuran' => $data['luka_operasi_ukuran'], 
		'luka_operasi_lokasi' => $data['luka_operasi_lokasi'], 
		'luka_bakar_ukuran' => $data['luka_bakar_ukuran'], 
		'luka_bakar_lokasi' => $data['luka_bakar_lokasi'], 
		'luka_bakar_kondisi' => $data['luka_bakar_kondisi'], 
		'kulit_memerah_ukuran' => $data['kulit_memerah_ukuran'], 
		'kulit_memerah_lokasi' => $data['kulit_memerah_lokasi'], 
		'kulit_memerah_kondisi' => $data['kulit_memerah_kondisi'], 
		'invasif_opsi' => $data['invasif_opsi'], 
		'invasif_perawat_recoveryroom' => $data['invasif_perawat_recoveryroom'], 
		'invasif_perawat_ruangan' => $data['invasif_perawat_ruangan'], 
		'invasif_keterangan' => $data['invasif_keterangan'], 
		'IV_line_tanggal' => $data['IV_line_tanggal'], 
		'IV_line_posisi' => $data['IV_line_posisi'], 
		'cvp_pic_tanggal' => $data['cvp_pic_tanggal'], 
		'cvp_pic_posisi' => $data['cvp_pic_posisi'], 
		'pemasangan_kateter_urine_nomor' => $data['pemasangan_kateter_urine_nomor'], 
		'pemasangan_kateter_urine_tanggal' => $data['pemasangan_kateter_urine_tanggal'], 
		'kateter_urine_perawat_recoveryroom' => $data['kateter_urine_perawat_recoveryroom'], 
		'kateter_urine_perawat_ruangan' => $data['kateter_urine_perawat_ruangan'], 
		'kateter_urine_keterangan' => $data['kateter_urine_keterangan'], 
		'pemasangan_irigasi_tanggal' => $data['pemasangan_irigasi_tanggal'], 
		'irigasi_perawat_recoveryroom' => $data['irigasi_perawat_recoveryroom'], 
		'irigasi_perawat_ruangan' => $data['irigasi_perawat_ruangan'], 
		'irigasi_keterangan' => $data['irigasi_keterangan'], 
		'masalah_kamar_operasi_perawat_recoveryroom' => $data['masalah_kamar_operasi_perawat_recoveryroom'], 
		'masalah_kamar_operasi_perawat_ruangan' => $data['masalah_kamar_operasi_perawat_ruangan'], 
		'masalah_kamar_operasi_perawat_keterangan' => $data['masalah_kamar_operasi_perawat_keterangan'], 
		'petugas_recovery_yang_menyerahkan' => $data['petugas_recovery_yang_menyerahkan'], 
		'petugas_ruangan_yang_menerimah' => $data['petugas_ruangan_yang_menerimah'], 
		'id_kunjungan' => $data['id_kunjungan'], 
		'id_pelayanan' => $data['id_pelayanan'], 
		'id_pasien' => $data['id_pasien'], 
		'id_user' => $data['id_user'], 
		
    );
  }
return $datas;
}

function Insert(){
   

$idKunj=mysql_real_escape_string($_REQUEST['idKunj']);
$idPel=mysql_real_escape_string($_REQUEST['idPel']);
$idPasien=mysql_real_escape_string($_REQUEST['idPasien']);
$idUser=mysql_real_escape_string($_REQUEST['idUser']);
  $diagnosa= mysql_real_escape_string($_POST['diagnosa']); 
		$ruangan= mysql_real_escape_string($_POST['ruangan']); 
		$tgl_op= mysql_real_escape_string($_POST['tgl_op']); 
		$tindakan= mysql_real_escape_string($_POST['tindakan']); 
		$blagko_laporan_operasi_perawat_recoveryroom= mysql_real_escape_string($_POST['blagko_laporan_operasi_perawat_recoveryroom']); 
		$blagko_laporan_operasi_perawat_ruangan= mysql_real_escape_string($_POST['blagko_laporan_operasi_perawat_ruangan']); 
		$blagko_laporan_operasi_keterangan= mysql_real_escape_string($_POST['blagko_laporan_operasi_keterangan']); 
		$blagko_catatan_anestesi_perawat_recoveryroom= mysql_real_escape_string($_POST['blagko_catatan_anestesi_perawat_recoveryroom']); 
		$blagko_catatan_anestesi_perawat_ruangan= mysql_real_escape_string($_POST['blagko_catatan_anestesi_perawat_ruangan']); 
		$blagko_catatan_anestesi_keterangan= mysql_real_escape_string($_POST['blagko_catatan_anestesi_keterangan']); 
		$blagko_pemakaian_alat_perawat_recoveryroom= mysql_real_escape_string($_POST['blagko_pemakaian_alat_perawat_recoveryroom']); 
		$blagko_pemakaian_alat_perawat_ruangan= mysql_real_escape_string($_POST['blagko_pemakaian_alat_perawat_ruangan']); 
		$blagko_pemakaian_alat_keterangan= mysql_real_escape_string($_POST['blagko_pemakaian_alat_keterangan']); 
		$blangko_perawat_recoveryroom= mysql_real_escape_string($_POST['blangko_perawat_recoveryroom']); 
		$blangko_perawat_ruangan= mysql_real_escape_string($_POST['blangko_perawat_ruangan']); 
		$blangko_keterangan= mysql_real_escape_string($_POST['blangko_keterangan']); 
		$rontgen_thorax_perawat_recoveryroom= mysql_real_escape_string($_POST['rontgen_thorax_perawat_recoveryroom']); 
		$rontgen_thorax_perawat_ruangan= mysql_real_escape_string($_POST['rontgen_thorax_perawat_ruangan']); 
		$rontgen_thorax_keterangan= mysql_real_escape_string($_POST['rontgen_thorax_keterangan']); 
		$rontgen_ctscan_perawat_recoveryroom= mysql_real_escape_string($_POST['rontgen_ctscan_perawat_recoveryroom']); 
		$rontgen_ctscan_perawat_ruangan= mysql_real_escape_string($_POST['rontgen_ctscan_perawat_ruangan']); 
		$rontgen_ctscan_keterangan= mysql_real_escape_string($_POST['rontgen_ctscan_keterangan']); 
		$rontgen_usg_perawat_recoveryroom= mysql_real_escape_string($_POST['rontgen_usg_perawat_recoveryroom']); 
		$rontgen_usg_perawat_ruangan= mysql_real_escape_string($_POST['rontgen_usg_perawat_ruangan']); 
		$rontgen_usg_keterangan= mysql_real_escape_string($_POST['rontgen_usg_keterangan']); 
		$rontgen_fotolain_perawat_recoveryroom= mysql_real_escape_string($_POST['rontgen_fotolain_perawat_recoveryroom']); 
		$rontgen_fotolain_perawat_ruangan= mysql_real_escape_string($_POST['rontgen_fotolain_perawat_ruangan']); 
		$rontgen_fotolain_keterangan= mysql_real_escape_string($_POST['rontgen_fotolain_keterangan']); 
		$barang_milik_pasien_perawat_recoveryroom= mysql_real_escape_string($_POST['barang_milik_pasien_perawat_recoveryroom']); 
		$barang_milik_pasien_perawat_ruangan= mysql_real_escape_string($_POST['barang_milik_pasien_perawat_ruangan']); 
		$barang_milik_pasien_keterangan= mysql_real_escape_string($_POST['barang_milik_pasien_keterangan']); 
		$vital_sign_cek_terakhir_jam= mysql_real_escape_string($_POST['vital_sign_cek_terakhir_jam']); 
		$vital_sign_nadi= mysql_real_escape_string($_POST['vital_sign_nadi']); 
		$vital_sign_suhu= mysql_real_escape_string($_POST['vital_sign_suhu']); 
		$vital_sign_tensi_darah= mysql_real_escape_string($_POST['vital_sign_tensi_darah']); 
		$vital_sign_respirasi= mysql_real_escape_string($_POST['vital_sign_respirasi']); 
		$vital_sign_skala_nyeri= mysql_real_escape_string($_POST['vital_sign_skala_nyeri']); 
		$vital_sign_berat_badan= mysql_real_escape_string($_POST['vital_sign_berat_badan']); 
		$vital_sign_perawat_recoveryroom= mysql_real_escape_string($_POST['vital_sign_perawat_recoveryroom']); 
		$vital_sign_perawat_ruangan= mysql_real_escape_string($_POST['vital_sign_perawat_ruangan']); 
		$vital_sign_keterangan= mysql_real_escape_string($_POST['vital_sign_keterangan']); 
		$drain_opsi= mysql_real_escape_string($_POST['drain_opsi']); 
		$drain_perawat_recoveryroom= mysql_real_escape_string($_POST['drain_perawat_recoveryroom']); 
		$drain_perawat_ruangan= mysql_real_escape_string($_POST['drain_perawat_ruangan']); 
		$drain_keterangan= mysql_real_escape_string($_POST['drain_keterangan']); 
		$luka_opsi= mysql_real_escape_string($_POST['luka_opsi']); 
		$luka_perawat_recoveryroom= mysql_real_escape_string($_POST['luka_perawat_recoveryroom']); 
		$luka_perawat_ruangan= mysql_real_escape_string($_POST['luka_perawat_ruangan']); 
		$luka_keterangan= mysql_real_escape_string($_POST['luka_keterangan']); 
		$luka_operasi_ukuran= mysql_real_escape_string($_POST['luka_operasi_ukuran']); 
		$luka_operasi_lokasi= mysql_real_escape_string($_POST['luka_operasi_lokasi']); 
		$luka_bakar_ukuran= mysql_real_escape_string($_POST['luka_bakar_ukuran']); 
		$luka_bakar_lokasi= mysql_real_escape_string($_POST['luka_bakar_lokasi']); 
		$luka_bakar_kondisi= mysql_real_escape_string($_POST['luka_bakar_kondisi']); 
		$kulit_memerah_ukuran= mysql_real_escape_string($_POST['kulit_memerah_ukuran']); 
		$kulit_memerah_lokasi= mysql_real_escape_string($_POST['kulit_memerah_lokasi']); 
		$kulit_memerah_kondisi= mysql_real_escape_string($_POST['kulit_memerah_kondisi']); 
		$invasif_opsi= mysql_real_escape_string($_POST['invasif_opsi']); 
		$invasif_perawat_recoveryroom= mysql_real_escape_string($_POST['invasif_perawat_recoveryroom']); 
		$invasif_perawat_ruangan= mysql_real_escape_string($_POST['invasif_perawat_ruangan']); 
		$invasif_keterangan= mysql_real_escape_string($_POST['invasif_keterangan']); 
		$IV_line_tanggal= mysql_real_escape_string($_POST['IV_line_tanggal']); 
		$IV_line_posisi= mysql_real_escape_string($_POST['IV_line_posisi']); 
		$cvp_pic_tanggal= mysql_real_escape_string($_POST['cvp_pic_tanggal']); 
		$cvp_pic_posisi= mysql_real_escape_string($_POST['cvp_pic_posisi']); 
		$pemasangan_kateter_urine_nomor= mysql_real_escape_string($_POST['pemasangan_kateter_urine_nomor']); 
		$pemasangan_kateter_urine_tanggal= mysql_real_escape_string($_POST['pemasangan_kateter_urine_tanggal']); 
		$kateter_urine_perawat_recoveryroom= mysql_real_escape_string($_POST['kateter_urine_perawat_recoveryroom']); 
		$kateter_urine_perawat_ruangan= mysql_real_escape_string($_POST['kateter_urine_perawat_ruangan']); 
		$kateter_urine_keterangan= mysql_real_escape_string($_POST['kateter_urine_keterangan']); 
		$pemasangan_irigasi_tanggal= mysql_real_escape_string($_POST['pemasangan_irigasi_tanggal']); 
		$irigasi_perawat_recoveryroom= mysql_real_escape_string($_POST['irigasi_perawat_recoveryroom']); 
		$irigasi_perawat_ruangan= mysql_real_escape_string($_POST['irigasi_perawat_ruangan']); 
		$irigasi_keterangan= mysql_real_escape_string($_POST['irigasi_keterangan']); 
		$masalah_kamar_operasi_perawat_recoveryroom= mysql_real_escape_string($_POST['masalah_kamar_operasi_perawat_recoveryroom']); 
		$masalah_kamar_operasi_perawat_ruangan= mysql_real_escape_string($_POST['masalah_kamar_operasi_perawat_ruangan']); 
		$masalah_kamar_operasi_perawat_keterangan= mysql_real_escape_string($_POST['masalah_kamar_operasi_perawat_keterangan']); 
		$petugas_recovery_yang_menyerahkan= mysql_real_escape_string($_POST['petugas_recovery_yang_menyerahkan']); 
		$petugas_ruangan_yang_menerimah= mysql_real_escape_string($_POST['petugas_ruangan_yang_menerimah']); 
		$id_kunjungan= mysql_real_escape_string($_POST['id_kunjungan']); 
		$id_pelayanan= mysql_real_escape_string($_POST['id_pelayanan']); 
		$id_pasien= mysql_real_escape_string($_POST['id_pasien']); 
		$id_user= mysql_real_escape_string($_POST['id_user']); 
		
  $query = "INSERT INTO `rm_serah_terima_pasien_post_operasi` (`id`,`diagnosa`,`ruangan`,`tgl_op`,`tindakan`,`blagko_laporan_operasi_perawat_recoveryroom`,`blagko_laporan_operasi_perawat_ruangan`,`blagko_laporan_operasi_keterangan`,`blagko_catatan_anestesi_perawat_recoveryroom`,`blagko_catatan_anestesi_perawat_ruangan`,`blagko_catatan_anestesi_keterangan`,`blagko_pemakaian_alat_perawat_recoveryroom`,`blagko_pemakaian_alat_perawat_ruangan`,`blagko_pemakaian_alat_keterangan`,`blangko_perawat_recoveryroom`,`blangko_perawat_ruangan`,`blangko_keterangan`,`rontgen_thorax_perawat_recoveryroom`,`rontgen_thorax_perawat_ruangan`,`rontgen_thorax_keterangan`,`rontgen_ctscan_perawat_recoveryroom`,`rontgen_ctscan_perawat_ruangan`,`rontgen_ctscan_keterangan`,`rontgen_usg_perawat_recoveryroom`,`rontgen_usg_perawat_ruangan`,`rontgen_usg_keterangan`,`rontgen_fotolain_perawat_recoveryroom`,`rontgen_fotolain_perawat_ruangan`,`rontgen_fotolain_keterangan`,`barang_milik_pasien_perawat_recoveryroom`,`barang_milik_pasien_perawat_ruangan`,`barang_milik_pasien_keterangan`,`vital_sign_cek_terakhir_jam`,`vital_sign_nadi`,`vital_sign_suhu`,`vital_sign_tensi_darah`,`vital_sign_respirasi`,`vital_sign_skala_nyeri`,`vital_sign_berat_badan`,`vital_sign_perawat_recoveryroom`,`vital_sign_perawat_ruangan`,`vital_sign_keterangan`,`drain_opsi`,`drain_perawat_recoveryroom`,`drain_perawat_ruangan`,`drain_keterangan`,`luka_opsi`,`luka_perawat_recoveryroom`,`luka_perawat_ruangan`,`luka_keterangan`,`luka_operasi_ukuran`,`luka_operasi_lokasi`,`luka_bakar_ukuran`,`luka_bakar_lokasi`,`luka_bakar_kondisi`,`kulit_memerah_ukuran`,`kulit_memerah_lokasi`,`kulit_memerah_kondisi`,`invasif_opsi`,`invasif_perawat_recoveryroom`,`invasif_perawat_ruangan`,`invasif_keterangan`,`IV_line_tanggal`,`IV_line_posisi`,`cvp_pic_tanggal`,`cvp_pic_posisi`,`pemasangan_kateter_urine_nomor`,`pemasangan_kateter_urine_tanggal`,`kateter_urine_perawat_recoveryroom`,`kateter_urine_perawat_ruangan`,`kateter_urine_keterangan`,`pemasangan_irigasi_tanggal`,`irigasi_perawat_recoveryroom`,`irigasi_perawat_ruangan`,`irigasi_keterangan`,`masalah_kamar_operasi_perawat_recoveryroom`,`masalah_kamar_operasi_perawat_ruangan`,`masalah_kamar_operasi_perawat_keterangan`,`petugas_recovery_yang_menyerahkan`,`petugas_ruangan_yang_menerimah`,`id_kunjungan`,`id_pelayanan`,`id_pasien`,`id_user`, `tgl_act`)
VALUES (NULL,'$diagnosa','$ruangan','$tgl_op','$tindakan','$blagko_laporan_operasi_perawat_recoveryroom','$blagko_laporan_operasi_perawat_ruangan','$blagko_laporan_operasi_keterangan','$blagko_catatan_anestesi_perawat_recoveryroom','$blagko_catatan_anestesi_perawat_ruangan','$blagko_catatan_anestesi_keterangan','$blagko_pemakaian_alat_perawat_recoveryroom','$blagko_pemakaian_alat_perawat_ruangan','$blagko_pemakaian_alat_keterangan','$blangko_perawat_recoveryroom','$blangko_perawat_ruangan','$blangko_keterangan','$rontgen_thorax_perawat_recoveryroom','$rontgen_thorax_perawat_ruangan','$rontgen_thorax_keterangan','$rontgen_ctscan_perawat_recoveryroom','$rontgen_ctscan_perawat_ruangan','$rontgen_ctscan_keterangan','$rontgen_usg_perawat_recoveryroom','$rontgen_usg_perawat_ruangan','$rontgen_usg_keterangan','$rontgen_fotolain_perawat_recoveryroom','$rontgen_fotolain_perawat_ruangan','$rontgen_fotolain_keterangan','$barang_milik_pasien_perawat_recoveryroom','$barang_milik_pasien_perawat_ruangan','$barang_milik_pasien_keterangan','$vital_sign_cek_terakhir_jam','$vital_sign_nadi','$vital_sign_suhu','$vital_sign_tensi_darah','$vital_sign_respirasi','$vital_sign_skala_nyeri','$vital_sign_berat_badan','$vital_sign_perawat_recoveryroom','$vital_sign_perawat_ruangan','$vital_sign_keterangan','$drain_opsi','$drain_perawat_recoveryroom','$drain_perawat_ruangan','$drain_keterangan','$luka_opsi','$luka_perawat_recoveryroom','$luka_perawat_ruangan','$luka_keterangan','$luka_operasi_ukuran','$luka_operasi_lokasi','$luka_bakar_ukuran','$luka_bakar_lokasi','$luka_bakar_kondisi','$kulit_memerah_ukuran','$kulit_memerah_lokasi','$kulit_memerah_kondisi','$invasif_opsi','$invasif_perawat_recoveryroom','$invasif_perawat_ruangan','$invasif_keterangan','$IV_line_tanggal','$IV_line_posisi','$cvp_pic_tanggal','$cvp_pic_posisi','$pemasangan_kateter_urine_nomor','$pemasangan_kateter_urine_tanggal','$kateter_urine_perawat_recoveryroom','$kateter_urine_perawat_ruangan','$kateter_urine_keterangan','$pemasangan_irigasi_tanggal','$irigasi_perawat_recoveryroom','$irigasi_perawat_ruangan','$irigasi_keterangan','$masalah_kamar_operasi_perawat_recoveryroom','$masalah_kamar_operasi_perawat_ruangan','$masalah_kamar_operasi_perawat_keterangan','$petugas_recovery_yang_menyerahkan','$petugas_ruangan_yang_menerimah','$id_kunjungan','$id_pelayanan','$id_pasien','$id_user', NULL)";
$exe = mysql_query($query);
  if($exe){
    // kalau berhasil
    $_SESSION['message'] = " Data Telah disimpan ";
    $_SESSION['mType'] = "success ";
      
    header("Location: index.php?idKunj=$id_kunjungan&idPel=$id_pelayanan&idPasien=$id_pasien&idUser=$id_user");
  }
  else{
    $_SESSION['message'] = " Data Gagal disimpan ";
    $_SESSION['mType'] = "danger ";
    
  header("Location: index.php?idKunj=$id_kunjungan&idPel=$id_pelayanan&idPasien=$id_pasien&idUser=$id_user");
  }
}
function Update($id){
   

  $idKunj=mysql_real_escape_string($_REQUEST['idKunj']);
$idPel=mysql_real_escape_string($_REQUEST['idPel']);
$idPasien=mysql_real_escape_string($_REQUEST['idPasien']);
$idUser=mysql_real_escape_string($_REQUEST['idUser']);

  $diagnosa=mysql_real_escape_string($_POST['diagnosa']); 
		$ruangan=mysql_real_escape_string($_POST['ruangan']); 
		$tgl_op=mysql_real_escape_string($_POST['tgl_op']); 
		$tindakan=mysql_real_escape_string($_POST['tindakan']); 
		$blagko_laporan_operasi_perawat_recoveryroom=mysql_real_escape_string($_POST['blagko_laporan_operasi_perawat_recoveryroom']); 
		$blagko_laporan_operasi_perawat_ruangan=mysql_real_escape_string($_POST['blagko_laporan_operasi_perawat_ruangan']); 
		$blagko_laporan_operasi_keterangan=mysql_real_escape_string($_POST['blagko_laporan_operasi_keterangan']); 
		$blagko_catatan_anestesi_perawat_recoveryroom=mysql_real_escape_string($_POST['blagko_catatan_anestesi_perawat_recoveryroom']); 
		$blagko_catatan_anestesi_perawat_ruangan=mysql_real_escape_string($_POST['blagko_catatan_anestesi_perawat_ruangan']); 
		$blagko_catatan_anestesi_keterangan=mysql_real_escape_string($_POST['blagko_catatan_anestesi_keterangan']); 
		$blagko_pemakaian_alat_perawat_recoveryroom=mysql_real_escape_string($_POST['blagko_pemakaian_alat_perawat_recoveryroom']); 
		$blagko_pemakaian_alat_perawat_ruangan=mysql_real_escape_string($_POST['blagko_pemakaian_alat_perawat_ruangan']); 
		$blagko_pemakaian_alat_keterangan=mysql_real_escape_string($_POST['blagko_pemakaian_alat_keterangan']); 
		$blangko_perawat_recoveryroom=mysql_real_escape_string($_POST['blangko_perawat_recoveryroom']); 
		$blangko_perawat_ruangan=mysql_real_escape_string($_POST['blangko_perawat_ruangan']); 
		$blangko_keterangan=mysql_real_escape_string($_POST['blangko_keterangan']); 
		$rontgen_thorax_perawat_recoveryroom=mysql_real_escape_string($_POST['rontgen_thorax_perawat_recoveryroom']); 
		$rontgen_thorax_perawat_ruangan=mysql_real_escape_string($_POST['rontgen_thorax_perawat_ruangan']); 
		$rontgen_thorax_keterangan=mysql_real_escape_string($_POST['rontgen_thorax_keterangan']); 
		$rontgen_ctscan_perawat_recoveryroom=mysql_real_escape_string($_POST['rontgen_ctscan_perawat_recoveryroom']); 
		$rontgen_ctscan_perawat_ruangan=mysql_real_escape_string($_POST['rontgen_ctscan_perawat_ruangan']); 
		$rontgen_ctscan_keterangan=mysql_real_escape_string($_POST['rontgen_ctscan_keterangan']); 
		$rontgen_usg_perawat_recoveryroom=mysql_real_escape_string($_POST['rontgen_usg_perawat_recoveryroom']); 
		$rontgen_usg_perawat_ruangan=mysql_real_escape_string($_POST['rontgen_usg_perawat_ruangan']); 
		$rontgen_usg_keterangan=mysql_real_escape_string($_POST['rontgen_usg_keterangan']); 
		$rontgen_fotolain_perawat_recoveryroom=mysql_real_escape_string($_POST['rontgen_fotolain_perawat_recoveryroom']); 
		$rontgen_fotolain_perawat_ruangan=mysql_real_escape_string($_POST['rontgen_fotolain_perawat_ruangan']); 
		$rontgen_fotolain_keterangan=mysql_real_escape_string($_POST['rontgen_fotolain_keterangan']); 
		$barang_milik_pasien_perawat_recoveryroom=mysql_real_escape_string($_POST['barang_milik_pasien_perawat_recoveryroom']); 
		$barang_milik_pasien_perawat_ruangan=mysql_real_escape_string($_POST['barang_milik_pasien_perawat_ruangan']); 
		$barang_milik_pasien_keterangan=mysql_real_escape_string($_POST['barang_milik_pasien_keterangan']); 
		$vital_sign_cek_terakhir_jam=mysql_real_escape_string($_POST['vital_sign_cek_terakhir_jam']); 
		$vital_sign_nadi=mysql_real_escape_string($_POST['vital_sign_nadi']); 
		$vital_sign_suhu=mysql_real_escape_string($_POST['vital_sign_suhu']); 
		$vital_sign_tensi_darah=mysql_real_escape_string($_POST['vital_sign_tensi_darah']); 
		$vital_sign_respirasi=mysql_real_escape_string($_POST['vital_sign_respirasi']); 
		$vital_sign_skala_nyeri=mysql_real_escape_string($_POST['vital_sign_skala_nyeri']); 
		$vital_sign_berat_badan=mysql_real_escape_string($_POST['vital_sign_berat_badan']); 
		$vital_sign_perawat_recoveryroom=mysql_real_escape_string($_POST['vital_sign_perawat_recoveryroom']); 
		$vital_sign_perawat_ruangan=mysql_real_escape_string($_POST['vital_sign_perawat_ruangan']); 
		$vital_sign_keterangan=mysql_real_escape_string($_POST['vital_sign_keterangan']); 
		$drain_opsi=mysql_real_escape_string($_POST['drain_opsi']); 
		$drain_perawat_recoveryroom=mysql_real_escape_string($_POST['drain_perawat_recoveryroom']); 
		$drain_perawat_ruangan=mysql_real_escape_string($_POST['drain_perawat_ruangan']); 
		$drain_keterangan=mysql_real_escape_string($_POST['drain_keterangan']); 
		$luka_opsi=mysql_real_escape_string($_POST['luka_opsi']); 
		$luka_perawat_recoveryroom=mysql_real_escape_string($_POST['luka_perawat_recoveryroom']); 
		$luka_perawat_ruangan=mysql_real_escape_string($_POST['luka_perawat_ruangan']); 
		$luka_keterangan=mysql_real_escape_string($_POST['luka_keterangan']); 
		$luka_operasi_ukuran=mysql_real_escape_string($_POST['luka_operasi_ukuran']); 
		$luka_operasi_lokasi=mysql_real_escape_string($_POST['luka_operasi_lokasi']); 
		$luka_bakar_ukuran=mysql_real_escape_string($_POST['luka_bakar_ukuran']); 
		$luka_bakar_lokasi=mysql_real_escape_string($_POST['luka_bakar_lokasi']); 
		$luka_bakar_kondisi=mysql_real_escape_string($_POST['luka_bakar_kondisi']); 
		$kulit_memerah_ukuran=mysql_real_escape_string($_POST['kulit_memerah_ukuran']); 
		$kulit_memerah_lokasi=mysql_real_escape_string($_POST['kulit_memerah_lokasi']); 
		$kulit_memerah_kondisi=mysql_real_escape_string($_POST['kulit_memerah_kondisi']); 
		$invasif_opsi=mysql_real_escape_string($_POST['invasif_opsi']); 
		$invasif_perawat_recoveryroom=mysql_real_escape_string($_POST['invasif_perawat_recoveryroom']); 
		$invasif_perawat_ruangan=mysql_real_escape_string($_POST['invasif_perawat_ruangan']); 
		$invasif_keterangan=mysql_real_escape_string($_POST['invasif_keterangan']); 
		$IV_line_tanggal=mysql_real_escape_string($_POST['IV_line_tanggal']); 
		$IV_line_posisi=mysql_real_escape_string($_POST['IV_line_posisi']); 
		$cvp_pic_tanggal=mysql_real_escape_string($_POST['cvp_pic_tanggal']); 
		$cvp_pic_posisi=mysql_real_escape_string($_POST['cvp_pic_posisi']); 
		$pemasangan_kateter_urine_nomor=mysql_real_escape_string($_POST['pemasangan_kateter_urine_nomor']); 
		$pemasangan_kateter_urine_tanggal=mysql_real_escape_string($_POST['pemasangan_kateter_urine_tanggal']); 
		$kateter_urine_perawat_recoveryroom=mysql_real_escape_string($_POST['kateter_urine_perawat_recoveryroom']); 
		$kateter_urine_perawat_ruangan=mysql_real_escape_string($_POST['kateter_urine_perawat_ruangan']); 
		$kateter_urine_keterangan=mysql_real_escape_string($_POST['kateter_urine_keterangan']); 
		$pemasangan_irigasi_tanggal=mysql_real_escape_string($_POST['pemasangan_irigasi_tanggal']); 
		$irigasi_perawat_recoveryroom=mysql_real_escape_string($_POST['irigasi_perawat_recoveryroom']); 
		$irigasi_perawat_ruangan=mysql_real_escape_string($_POST['irigasi_perawat_ruangan']); 
		$irigasi_keterangan=mysql_real_escape_string($_POST['irigasi_keterangan']); 
		$masalah_kamar_operasi_perawat_recoveryroom=mysql_real_escape_string($_POST['masalah_kamar_operasi_perawat_recoveryroom']); 
		$masalah_kamar_operasi_perawat_ruangan=mysql_real_escape_string($_POST['masalah_kamar_operasi_perawat_ruangan']); 
		$masalah_kamar_operasi_perawat_keterangan=mysql_real_escape_string($_POST['masalah_kamar_operasi_perawat_keterangan']); 
		$petugas_recovery_yang_menyerahkan=mysql_real_escape_string($_POST['petugas_recovery_yang_menyerahkan']); 
		$petugas_ruangan_yang_menerimah=mysql_real_escape_string($_POST['petugas_ruangan_yang_menerimah']); 
		$id_kunjungan=mysql_real_escape_string($_POST['id_kunjungan']); 
		$id_pelayanan=mysql_real_escape_string($_POST['id_pelayanan']); 
		$id_pasien=mysql_real_escape_string($_POST['id_pasien']); 
		$id_user=mysql_real_escape_string($_POST['id_user']); 
		
  $query = "UPDATE `rm_serah_terima_pasien_post_operasi` SET `diagnosa` = '$diagnosa',`ruangan` = '$ruangan',`tgl_op` = '$tgl_op',`tindakan` = '$tindakan',`blagko_laporan_operasi_perawat_recoveryroom` = '$blagko_laporan_operasi_perawat_recoveryroom',`blagko_laporan_operasi_perawat_ruangan` = '$blagko_laporan_operasi_perawat_ruangan',`blagko_laporan_operasi_keterangan` = '$blagko_laporan_operasi_keterangan',`blagko_catatan_anestesi_perawat_recoveryroom` = '$blagko_catatan_anestesi_perawat_recoveryroom',`blagko_catatan_anestesi_perawat_ruangan` = '$blagko_catatan_anestesi_perawat_ruangan',`blagko_catatan_anestesi_keterangan` = '$blagko_catatan_anestesi_keterangan',`blagko_pemakaian_alat_perawat_recoveryroom` = '$blagko_pemakaian_alat_perawat_recoveryroom',`blagko_pemakaian_alat_perawat_ruangan` = '$blagko_pemakaian_alat_perawat_ruangan',`blagko_pemakaian_alat_keterangan` = '$blagko_pemakaian_alat_keterangan',`blangko_perawat_recoveryroom` = '$blangko_perawat_recoveryroom',`blangko_perawat_ruangan` = '$blangko_perawat_ruangan',`blangko_keterangan` = '$blangko_keterangan',`rontgen_thorax_perawat_recoveryroom` = '$rontgen_thorax_perawat_recoveryroom',`rontgen_thorax_perawat_ruangan` = '$rontgen_thorax_perawat_ruangan',`rontgen_thorax_keterangan` = '$rontgen_thorax_keterangan',`rontgen_ctscan_perawat_recoveryroom` = '$rontgen_ctscan_perawat_recoveryroom',`rontgen_ctscan_perawat_ruangan` = '$rontgen_ctscan_perawat_ruangan',`rontgen_ctscan_keterangan` = '$rontgen_ctscan_keterangan',`rontgen_usg_perawat_recoveryroom` = '$rontgen_usg_perawat_recoveryroom',`rontgen_usg_perawat_ruangan` = '$rontgen_usg_perawat_ruangan',`rontgen_usg_keterangan` = '$rontgen_usg_keterangan',`rontgen_fotolain_perawat_recoveryroom` = '$rontgen_fotolain_perawat_recoveryroom',`rontgen_fotolain_perawat_ruangan` = '$rontgen_fotolain_perawat_ruangan',`rontgen_fotolain_keterangan` = '$rontgen_fotolain_keterangan',`barang_milik_pasien_perawat_recoveryroom` = '$barang_milik_pasien_perawat_recoveryroom',`barang_milik_pasien_perawat_ruangan` = '$barang_milik_pasien_perawat_ruangan',`barang_milik_pasien_keterangan` = '$barang_milik_pasien_keterangan',`vital_sign_cek_terakhir_jam` = '$vital_sign_cek_terakhir_jam',`vital_sign_nadi` = '$vital_sign_nadi',`vital_sign_suhu` = '$vital_sign_suhu',`vital_sign_tensi_darah` = '$vital_sign_tensi_darah',`vital_sign_respirasi` = '$vital_sign_respirasi',`vital_sign_skala_nyeri` = '$vital_sign_skala_nyeri',`vital_sign_berat_badan` = '$vital_sign_berat_badan',`vital_sign_perawat_recoveryroom` = '$vital_sign_perawat_recoveryroom',`vital_sign_perawat_ruangan` = '$vital_sign_perawat_ruangan',`vital_sign_keterangan` = '$vital_sign_keterangan',`drain_opsi` = '$drain_opsi',`drain_perawat_recoveryroom` = '$drain_perawat_recoveryroom',`drain_perawat_ruangan` = '$drain_perawat_ruangan',`drain_keterangan` = '$drain_keterangan',`luka_opsi` = '$luka_opsi',`luka_perawat_recoveryroom` = '$luka_perawat_recoveryroom',`luka_perawat_ruangan` = '$luka_perawat_ruangan',`luka_keterangan` = '$luka_keterangan',`luka_operasi_ukuran` = '$luka_operasi_ukuran',`luka_operasi_lokasi` = '$luka_operasi_lokasi',`luka_bakar_ukuran` = '$luka_bakar_ukuran',`luka_bakar_lokasi` = '$luka_bakar_lokasi',`luka_bakar_kondisi` = '$luka_bakar_kondisi',`kulit_memerah_ukuran` = '$kulit_memerah_ukuran',`kulit_memerah_lokasi` = '$kulit_memerah_lokasi',`kulit_memerah_kondisi` = '$kulit_memerah_kondisi',`invasif_opsi` = '$invasif_opsi',`invasif_perawat_recoveryroom` = '$invasif_perawat_recoveryroom',`invasif_perawat_ruangan` = '$invasif_perawat_ruangan',`invasif_keterangan` = '$invasif_keterangan',`IV_line_tanggal` = '$IV_line_tanggal',`IV_line_posisi` = '$IV_line_posisi',`cvp_pic_tanggal` = '$cvp_pic_tanggal',`cvp_pic_posisi` = '$cvp_pic_posisi',`pemasangan_kateter_urine_nomor` = '$pemasangan_kateter_urine_nomor',`pemasangan_kateter_urine_tanggal` = '$pemasangan_kateter_urine_tanggal',`kateter_urine_perawat_recoveryroom` = '$kateter_urine_perawat_recoveryroom',`kateter_urine_perawat_ruangan` = '$kateter_urine_perawat_ruangan',`kateter_urine_keterangan` = '$kateter_urine_keterangan',`pemasangan_irigasi_tanggal` = '$pemasangan_irigasi_tanggal',`irigasi_perawat_recoveryroom` = '$irigasi_perawat_recoveryroom',`irigasi_perawat_ruangan` = '$irigasi_perawat_ruangan',`irigasi_keterangan` = '$irigasi_keterangan',`masalah_kamar_operasi_perawat_recoveryroom` = '$masalah_kamar_operasi_perawat_recoveryroom',`masalah_kamar_operasi_perawat_ruangan` = '$masalah_kamar_operasi_perawat_ruangan',`masalah_kamar_operasi_perawat_keterangan` = '$masalah_kamar_operasi_perawat_keterangan',`petugas_recovery_yang_menyerahkan` = '$petugas_recovery_yang_menyerahkan',`petugas_ruangan_yang_menerimah` = '$petugas_ruangan_yang_menerimah',`id_kunjungan` = '$id_kunjungan',`id_pelayanan` = '$id_pelayanan',`id_pasien` = '$id_pasien',`id_user` = '$id_user' WHERE  `id` =  '$id'";
$exe = mysql_query($query);
  if($exe){
    // kalau berhasil
    $_SESSION['message'] = " Data Telah diubah ";
    $_SESSION['mType'] = "success ";
    
   header("Location: index.php?idKunj=$id_kunjungan&idPel=$id_pelayanan&idPasien=$id_pasien&idUser=$id_user");
  }
  else{
    $_SESSION['message'] = " Data Gagal diubah ";
    $_SESSION['mType'] = "danger ";
    
   header("Location: index.php?idKunj=$id_kunjungan&idPel=$id_pelayanan&idPasien=$id_pasien&idUser=$id_user");
  }
}
function Delete($id){
   
 $idKunj=mysql_real_escape_string($_REQUEST['idKunj']);
$idPel=mysql_real_escape_string($_REQUEST['idPel']);
$idPasien=mysql_real_escape_string($_REQUEST['idPasien']);
$idUser=mysql_real_escape_string($_REQUEST['idUser']);

  $query = "DELETE FROM `rm_serah_terima_pasien_post_operasi` WHERE `id` = '$id'";
  $exe = mysql_query($query);
    if($exe){
      // kalau berhasil
      $_SESSION['message'] = " Data Telah dihapus ";
      $_SESSION['mType'] = "success ";
       
      header("Location: index.php?idKunj=$idKunj&idPel=$idPel&idPasien=$idPasien&idUser=$idUser");
    }
    else{
      $_SESSION['message'] = " Data Gagal dihapus ";
      $_SESSION['mType'] = "danger ";

      header("Location: index.php?idKunj=$idKunj&idPel=$idPel&idPasien=$idPasien&idUser=$idUser");
    }
}




function hari_ini(){
  $hari = date ("D");
 
  switch($hari){
    case 'Sun':
      $hari_ini = "Minggu";
    break;
 
    case 'Mon':     
      $hari_ini = "Senin";
    break;
 
    case 'Tue':
      $hari_ini = "Selasa";
    break;
 
    case 'Wed':
      $hari_ini = "Rabu";
    break;
 
    case 'Thu':
      $hari_ini = "Kamis";
    break;
 
    case 'Fri':
      $hari_ini = "Jumat";
    break;
 
    case 'Sat':
      $hari_ini = "Sabtu";
    break;
    
    default:
      $hari_ini = "Tidak di ketahui";   
    break;
  }
 
  return "" . $hari_ini . "";
 
}



if(isset($_POST['insert'])){
  Insert();
}
else if(isset($_POST['update'])){
  Update(mysql_real_escape_string($_POST['id']));
}
else if(isset($_POST['delete'])){
  Delete(mysql_real_escape_string($_POST['id']));
}
?>
