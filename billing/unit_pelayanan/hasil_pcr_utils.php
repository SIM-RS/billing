<?php
require_once '../koneksi/konek.php';

$act = mysql_real_escape_string($_REQUEST['act']);
$id = mysql_real_escape_string($_REQUEST['id']);
$id_pasien =mysql_real_escape_string( $_REQUEST['id_pasien']);
$no_registrasi_lab =mysql_real_escape_string( $_REQUEST['no_registrasi_lab']);
$dokter_pengirim =mysql_real_escape_string( $_REQUEST['dokter_pengirim']);
$tanggal_swab = mysql_real_escape_string( $_REQUEST['tanggal_swab']);
$tanggal_terima = '-';
$tanggal_validasi = '-';
$dokter_penanggung_jawab = "";
$status_cek_pcr = '-';
$keterangan = '-';
$kriteria_pasien = '-';
$no_hp_dokter_pengirim = mysql_real_escape_string($_REQUEST['no_hp_dokter_pengirim']);
$petugas_kesehatan = mysql_real_escape_string($_REQUEST['petugas_kesehatan']);
$ktp_domisili = mysql_real_escape_string($_REQUEST['ktp_domisili']);
$status_hamil = mysql_real_escape_string($_REQUEST['status_hamil']);
$tanggal_pemeriksaan = mysql_real_escape_string($_REQUEST['tanggal_pemeriksaan']);
$id_kunjungan = mysql_real_escape_string($_REQUEST['id_kunjungan']);
$id_pelayanan = mysql_real_escape_string($_REQUEST['id_pelayanan']);
$no_urut = mysql_real_escape_string($_REQUEST['no_urut_reg_lab']);
$jenis_spesimen = mysql_real_escape_string($_REQUEST['jenis_spesimen']);
$alasan_pemeriksaan = mysql_real_escape_string($_REQUEST['alasan_pemeriksaan']);
$user_id = mysql_real_escape_string($_REQUEST['user_id']);
$kategori = mysql_real_escape_string($_REQUEST['kategori_swab']);
switch ($act) {
	case 'tambah':
		$sql = "INSERT INTO b_hasil_pcr(id_pasien,no_registrasi_lab,dokter_pengirim,tanggal_swab,tanggal_terima,tanggal_validasi,dokter_penanggung_jawab,status_cek_pcr,keterangan,kriteria_pasien,no_hp_dokter_pengirim,petugas_kesehatan,ktp_domisili,status_hamil,tanggal_pemeriksaan,id_kunjungan,id_pelayanan,tanggal_act,no_urut_reg_lab,alasan_pemeriksaan,jenis_spesimen,user_id,kategori) VALUES ({$id_pasien},'{$no_registrasi_lab}','{$dokter_pengirim}','{$tanggal_swab}','{$tanggal_terima}','{$tanggal_validasi}','{$dokter_penanggung_jawab}','{$status_cek_pcr}','{$keterangan}','{$kriteria_pasien}','{$no_hp_dokter_pengirim}','{$petugas_kesehatan}','{$ktp_domisili}','{$status_hamil}','{$tanggal_pemeriksaan}',{$id_kunjungan},{$id_pelayanan},now(),{$no_urut},'{$alasan_pemeriksaan}','{$jenis_spesimen}',{$user_id},{$kategori})";
		if(mysql_query($sql)){
			$databalik = [
				'status' => 1,
				'messages' => 'Berhasil memasukan hasil pcr',
			];
			echo json_encode($databalik);
		}else{
			$databalik = [
				'status' => 1,
				'messages' => 'Gagal memasukan hasil pcr',
			];
			echo json_encode($databalik);
		}
		break;
	case 'update' :
		$sql = "UPDATE b_hasil_pcr SET dokter_pengirim = '{$dokter_pengirim}',dokter_penanggung_jawab = '{$dokter_penanggung_jawab}', tanggal_swab = '{$tanggal_swab}',no_hp_dokter_pengirim = '{$no_hp_dokter_pengirim}',petugas_kesehatan = '{$petugas_kesehatan}',ktp_domisili = '{$ktp_domisili}',status_hamil = '{$status_hamil}',tanggal_pemeriksaan = '{$tanggal_pemeriksaan}',id_pelayanan = {$id_pelayanan},id_kunjungan = {$id_kunjungan},alasan_pemeriksaan = '{$alasan_pemeriksaan}',jenis_spesimen = '{$jenis_spesimen}', user_id = {$user_id}, kategori = {$kategori} WHERE id = {$id}";
		if(mysql_query($sql)){
			$databalik = [
				'status' => 1,
				'messages' => 'Berhasil ubah hasil pcr',
			];
			echo json_encode($databalik);
		}else{
			$databalik = [
				'status' => 1,
				'messages' => 'Gagal ubah hasil pcr',
				'sql' => $sql
			];
			echo json_encode($databalik);
		}
		break;
	case 'delete' :
		$sql = "DELETE FROM b_hasil_pcr WHERE id = {$id}";

		if(mysql_query($sql)){
			$databalik = [
				'status' => 1,
				'messages' => 'Berhasil delete hasil pcr',
			];
			echo json_encode($databalik);
		}else{
			$databalik = [
				'status' => 1,
				'messages' => 'Gagal delete hasil pcr',
			];
			echo json_encode($databalik);
		}
		break;
	case 'noUrut' :
		$sql = "SELECT MAX(no_urut_reg_lab) as no FROM b_hasil_pcr";
		$query = mysql_query($sql);
		$sqlGetTahunAndIdTerakhir = "SELECT YEAR(tanggal_act) as tgl FROM b_hasil_pcr ORDER BY id desc";
		$fQ = mysql_fetch_assoc(mysql_query($sqlGetTahunAndIdTerakhir));
		if(mysql_num_rows($query) > 0){
			$fetch = mysql_fetch_assoc($query);
			if($fQ['tgl'] == date('Y')){
				$databalik = [
					'no_urut' => $fetch['no'] + 1,

				];	
			}else{
				$databalik = [
					'no_urut' => 1,
				];
			}
			echo json_encode($databalik);
		}else{
			$databalik = [
				'no_urut' => 1,
			];
			echo json_encode($databalik);
		}
		break;

}
?>