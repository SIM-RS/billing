<?php
require_once '../autoload.php';

$konek = new Connection();

function tanggal($tgl){
	$tanggal = explode('-', $tgl);
	return $tanggal[2] . '-' . $tanggal[1] . '-' . $tanggal[0];
}

//Id
$id = htmlspecialchars($_REQUEST['id']);
$id_pasien = $_REQUEST['id_pasien'];
$id_kunjungan = $_REQUEST['id_kunjungan'];
$userId = $_REQUEST['user_id'];
$no_rm = htmlspecialchars($_REQUEST['no_rm']);
$id_dokter = $_REQUEST['id_dokter'];
//data
$tanggal = $_REQUEST['tanggal'];
$tanggal_pemeriksaan = $_REQUEST['tanggal'];
$tanggal_operasi = $_REQUEST['tanggal'];
$tanggal_salah = $_REQUEST['tanggal_salah'];
$tanggal_lapor = $_REQUEST['tanggal_lapor'];
$tanggal_pembatalan = $_REQUEST['tanggal_pembatalan'];
$tanggal_dilayani = $_REQUEST['tanggal_dilayani'];
$tanggal_infeksi = $_REQUEST['tanggal_infeksi'];
$tanggal_pulang = $_REQUEST['tanggal_pulang'];
$pilihan = $_REQUEST['pilihan'];
$ruangan = $_REQUEST['ruangan'];
$jenis_operasi = $_REQUEST['jenis_operasi'];
$jam_dilayani = $_REQUEST['jam_dilayani'];
$jam_selesai = $_REQUEST['jam_selesai'];
$tgl_kejadian = $_REQUEST['jam_selesai'];
$jam_selesai = $_REQUEST['jam_selesai'];

$tgl_kejadian = $_REQUEST['tgl_kejadian'];
$jenis_kejadian = $_REQUEST['jenis_kejadian'];
$jam = $_REQUEST['jam'];
$area = $_REQUEST['area'];
$tindak = $_REQUEST['tindak'];
$ya = $_REQUEST['ya'];
$tidak = $_REQUEST['tidak'];
//action
$act = $_REQUEST['act'];
$namaTable = $_REQUEST['nama_table'];

switch ($act) {
	// simpan-evaluasi-cuci-tangan
	case 'edit-evaluasi-cuci-tangan':
		$data = $konek->rawQuery("UPDATE ppi_evaluasi_cuci_tangan SET id_ruangan = '{$ruangan}', id_petugas = '{$id_dokter}', tgl_survey = '{$tgl_kejadian}', ya = '{$ya}', tidak = '{$tidak}' WHERE id = '{$id}'");
		if($data) echo json_encode(['status'=>200]);
		else echo json_encode(['status'=>500]);
	break;
	case 'tampil-evaluasi-cuci-tangan':
		$data = $konek->rawQuery("SELECT 
		ppi_ruangan.nama_ruangan AS ruangan, ppi_evaluasi_cuci_tangan.* 
		FROM ppi_evaluasi_cuci_tangan 
		LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
		WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_dokter}'
		 AND MONTH(ppi_evaluasi_cuci_tangan.tgl_survey) = {$_REQUEST['bulan']} 
		 AND YEAR(ppi_evaluasi_cuci_tangan.tgl_survey) = {$_REQUEST['tahun']} 
		 ORDER BY ppi_evaluasi_cuci_tangan.tgl_survey");
		$no = 0;
			while($rows = $data->fetch_assoc()){
				$valEdit = $rows['id'] .'|'. $rows['id_ruangan'] . '|' . $rows['id_petugas'] . '|' . $rows['tgl_survey'] . '|'. $rows['ya'] . '|'. $rows['tidak'];
				echo '<tr>';
				echo '<td>' . ++$no . '</td>';
				echo '<td>' . $rows['tgl_survey'] . '</td>';
				echo '<td>' . $rows['ruangan'] . '</td>';
				echo '<td>';
					echo '<button class="btn btn-sm btn-warning" value="'.$valEdit.'" onclick="editData(this.value)">Edit</button>';
					echo ' <button class="btn btn-sm btn-danger" value="'.$rows['id'].'" onclick="deleteDataPmkp(this.value)">Delete</button>';
				echo '</td>';
				echo '</tr>';
			}
	break;
	case 'simpan-evaluasi-cuci-tangan':
		$data = $konek->rawQuery("INSERT INTO ppi_evaluasi_cuci_tangan(id, id_ruangan, 	id_petugas, tgl_survey, ya, tidak,  tgl_act)VALUES('', '{$ruangan}','{$id_dokter}','{$tgl_kejadian}','{$ya}','{$tidak}',now())");
		if($data) echo json_encode(['status' => 200]);
		else echo json_encode(['status' => 500]);
	break;

	// simpan-laporan-tertusuk-jarum
	case 'cari-petugas-tertusuk-jarum':
		$data = $konek->rawQuery("SELECT id,nama FROM rspelindo_billing.b_ms_pegawai WHERE id = '{$no_rm}'");
			while($rows = $data->fetch_assoc()){
				echo '<tr>';
				echo '<td>' . $rows['nama'] . '</td>';
				echo '<td><button class="btn btn-success btn-sm" value="' . $rows['id'] . '|'. $rows['nama'] .'" onclick="pilihPasien(this.value)">Pilih</button></td>';
				echo '</tr>';
			}
	break;
	case 'edit-laporan-tertusuk-jarum':
		$data = $konek->rawQuery("UPDATE ppi_laporan_tertusuk_jarum SET id_ruangan = '{$ruangan}', tgl_kejadian = '{$tgl_kejadian}',jam_kejadian = '{$jam}', id_petugas = '{$id_dokter}', jenis_kejadian = '{$jenis_kejadian}', area_tertusuk = '{$area}', tindak_lanjut = '{$tindak}' WHERE id = '{$id}'");
		if($data) echo json_encode(['status'=>200]);
		else echo json_encode(['status'=>500]);
	break;
	case 'simpan-laporan-tertusuk-jarum':
		$data = $konek->rawQuery("INSERT INTO ppi_laporan_tertusuk_jarum(id, id_ruangan, tgl_kejadian, jam_kejadian, id_petugas, jenis_kejadian, area_tertusuk, tindak_lanjut, tgl_act)VALUES('', '{$ruangan}','{$tgl_kejadian}','{$jam}','{$id_dokter}','{$jenis_kejadian}','{$area}','{$tindak}',now())");
		if($data) echo json_encode(['status' => 200]);
		else echo json_encode(['status' => 500]);
	break;
	case 'tampil-data-tertusuk-jarum':
		$data = $konek->rawQuery("SELECT ppi_ruangan.nama_ruangan AS ruangan, ppi_laporan_tertusuk_jarum.* FROM ppi_laporan_tertusuk_jarum LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_laporan_tertusuk_jarum.id_ruangan WHERE ppi_laporan_tertusuk_jarum.id_petugas = '{$id_dokter}' AND MONTH(ppi_laporan_tertusuk_jarum.tgl_kejadian) = {$_REQUEST['bulan']} AND YEAR(ppi_laporan_tertusuk_jarum.tgl_kejadian) = {$_REQUEST['tahun']} ORDER BY ppi_laporan_tertusuk_jarum.tgl_kejadian");
		$no = 0;
			while($rows = $data->fetch_assoc()){
				$valEdit = $rows['id'] .'|'. $rows['id_ruangan'] . '|' . $rows['tgl_kejadian'] . '|' . $rows['jam_kejadian'] . '|'. $rows['id_petugas'] . '|'. $rows['jenis_kejadian'] . '|'. $rows['area_tertusuk']. '|'. $rows['tindak_lanjut'];
				echo '<tr>';
				echo '<td>' . ++$no . '</td>';
				echo '<td>' . $rows['tgl_kejadian'] . '</td>';
				echo '<td>' . $rows['area_tertusuk'] . '</td>';
				echo '<td>' . $rows['ruangan'] . '</td>';
				echo '<td>' . $rows['tindak_lanjut'] . '</td>';
				echo '<td>';
					echo '<button class="btn btn-sm btn-warning" value="'.$valEdit.'" onclick="editData(this.value)">Edit</button>';
					echo ' <button class="btn btn-sm btn-danger" value="'.$rows['id'].'" onclick="deleteDataPmkp(this.value)">Delete</button>';
				echo '</td>';
				echo '</tr>';
			}
	break;
	case 'cari_pasien':
        $data = $konek->rawQuery("SELECT p.id,k.id as id_kunjungan,p.nama,k.tgl,k.pulang FROM rspelindo_billing.b_ms_pasien p LEFT JOIN rspelindo_billing.b_kunjungan k ON k.pasien_id = p.id WHERE p.no_rm = '{$no_rm}' AND p.cabang_id = 1");
        while($rows = $data->fetch_assoc()){
            echo '<tr>';
            echo '<td>' . $rows['nama'] . '</td>';
            echo '<td>' . tanggal($rows['tgl']) . '</td>';
            echo '<td>'.($rows['pulang'] == 1 ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Tidak Aktif</span>').'</td>';
            echo '<td><button class="btn btn-success btn-sm" value="' . $rows['id'].'|'.$rows['id_kunjungan'].'|'.$rows['nama'] . '" onclick="pilihPasien(this.value)">Pilih</button></td>';
            echo '</tr>';
        }
	break;
	//pasien asesmen
	case 'tampil_data_pasien_asesmen':
		$data = $konek->rawQuery("SELECT 
				p.nama,
				r.nama_ruangan,
				i.* 
			FROM 
				{$namaTable} i 
				LEFT JOIN rspelindo_billing.b_ms_pasien p ON p.id = i.id_pasien 
				LEFT JOIN ppi_ruangan r ON r.id = i.id_ruangan
				WHERE i.id_pasien = {$_REQUEST['id_pasien']} AND i.id_kunjungan = {$id_kunjungan} AND MONTH(i.tanggal_pemantauan) = {$_REQUEST['bulan']} AND YEAR(i.tanggal_pemantauan) = {$_REQUEST['tahun']} ORDER BY i.tanggal_pemantauan");
		$no = 0;
		while($rows = $data->fetch_assoc()){
			$valEdit = $rows['id'] .'|'. $rows['id_ruangan'] . '|' . $rows['tanggal_pemantauan'] . '|' . $rows['pilihan'] . '|'. $rows['id_dokter'];
			echo '<tr>';
				echo '<td>' . ++$no . '</td>';
				echo '<td>' . $rows['nama'] . '</td>';
				echo '<td>' . $rows['tanggal_pemantauan'] . '</td>';
				echo '<td>' . $rows['pilihan'] . '</td>';
				echo '<td>';
					echo '<button class="btn btn-sm btn-warning" value="'.$valEdit.'" onclick="editData(this.value)">Edit</button>';
					echo ' <button class="btn btn-sm btn-danger" value="'.$rows['id'].'" onclick="deleteDataPmkp(this.value)">Delete</button>';
				echo '</td>';
			echo '</tr>';
		}
	break;
	case 'simpan-pasien-asesmen':
		$data = $konek->rawQuery("INSERT INTO ppi_pasien_asesmen(id_ruangan, id_pasien, id_kunjungan, tanggal_pemantauan, pilihan, user_id, tanggal_act,id_dokter)VALUES({$ruangan},{$id_pasien},{$id_kunjungan},'{$tanggal}','{$pilihan}',{$userId},now(),{$id_dokter})");
		if($data) echo json_encode(['status' => 200]);
		else echo json_encode(['status' => 500]);
	break;
	case 'edit-pasien-asesmen':
		$data = $konek->rawQuery("UPDATE ppi_pasien_asesmen SET id_ruangan = {$ruangan}, tanggal_pemantauan = '{$tanggal}',pilihan = '{$pilihan}', id_dokter = {$id_dokter} WHERE id = {$id}");
		if($data) echo json_encode(['status'=>200]);
		else echo json_encode(['status'=>500]);
	break;
	//kelengkapan asesmen
	case 'tampil_data_kelengkapan_asesmen':
		$data = $konek->rawQuery("SELECT 
				p.nama,
				r.nama_ruangan,
				i.* 
			FROM 
				{$namaTable} i 
				LEFT JOIN rspelindo_billing.b_ms_pasien p ON p.id = i.id_pasien 
				LEFT JOIN ppi_ruangan r ON r.id = i.id_ruangan
				WHERE i.id_pasien = {$_REQUEST['id_pasien']} AND i.id_kunjungan = {$id_kunjungan} AND MONTH(i.tanggal_pemantauan) = {$_REQUEST['bulan']} AND YEAR(i.tanggal_pemantauan) = {$_REQUEST['tahun']} ORDER BY i.tanggal_pemantauan");
		$no = 0;
		while($rows = $data->fetch_assoc()){
			$valEdit = $rows['id'] .'|'. $rows['id_ruangan'] . '|' . $rows['tanggal_pemantauan'] . '|' . $rows['pilihan'] . '|'. $rows['id_dokter'];
			echo '<tr>';
				echo '<td>' . ++$no . '</td>';
				echo '<td>' . $rows['nama'] . '</td>';
				echo '<td style="text-transform:capitalize;">' . $rows['tanggal_pemantauan'] . '</td>';
				echo '<td>' . $rows['pilihan'] . '</td>';
				echo '<td>';
					echo '<button class="btn btn-sm btn-warning" value="'.$valEdit.'" onclick="editData(this.value)">Edit</button>';
					echo ' <button class="btn btn-sm btn-danger" value="'.$rows['id'].'" onclick="deleteDataPmkp(this.value)">Delete</button>';
				echo '</td>';
			echo '</tr>';
		}
	break;
	case 'simpan-kelengkapan-asesmen':
		$data = $konek->rawQuery("INSERT INTO ppi_kelengkapan_asesmen(id_ruangan, id_pasien, id_kunjungan, tanggal_pemantauan, pilihan, user_id, tanggal_act,id_dokter)VALUES({$ruangan},{$id_pasien},{$id_kunjungan},'{$tanggal}','{$pilihan}',{$userId},now(),{$id_dokter})");
		if($data) echo json_encode(['status' => 200]);
		else echo json_encode(['status' => 500]);
	break;
	case 'edit-kelengkapan-asesmen':
		$data = $konek->rawQuery("UPDATE ppi_kelengkapan_asesmen SET id_ruangan = {$ruangan}, tanggal_pemantauan = '{$tanggal}',pilihan = '{$pilihan}', id_dokter = {$id_dokter} WHERE id = {$id}");
		if($data) echo json_encode(['status'=>200]);
		else echo json_encode(['status'=>500]);
	break;
	//angka kesalahan input
	case 'tampil_data_angka_kesalahan_input':
		$data = $konek->rawQuery("SELECT 
				p.nama,
				r.nama_ruangan,
				i.* 
			FROM 
				{$namaTable} i 
				LEFT JOIN rspelindo_billing.b_ms_pasien p ON p.id = i.id_pasien 
				LEFT JOIN ppi_ruangan r ON r.id = i.id_ruangan
				WHERE i.id_pasien = {$_REQUEST['id_pasien']} AND i.id_kunjungan = {$id_kunjungan} AND MONTH(i.tanggal_pemantauan) = {$_REQUEST['bulan']} AND YEAR(i.tanggal_pemantauan) = {$_REQUEST['tahun']} ORDER BY i.tanggal_pemantauan");
		$no = 0;
		while($rows = $data->fetch_assoc()){
			$valEdit = $rows['id'] .'|'. $rows['id_ruangan'] . '|' . $rows['tanggal_pemeriksaan'] . '|' . $rows['tanggal_pemantauan'] . '|' . $rows['pilihan'] . '|'. $rows['id_dokter'];
			echo '<tr>';
				echo '<td>' . ++$no . '</td>';
				echo '<td>' . $rows['nama'] . '</td>';
				echo '<td style="text-transform:capitalize;">' . tanggal($rows['tanggal_pemeriksaan']) . '</td>';
				echo '<td style="text-transform:capitalize;">' . tanggal($rows['tanggal_pemantauan']) . '</td>';
				echo '<td>' . $rows['pilihan'] . '</td>';
				echo '<td>';
					echo '<button class="btn btn-sm btn-warning" value="'.$valEdit.'" onclick="editData(this.value)">Edit</button>';
					echo ' <button class="btn btn-sm btn-danger" value="'.$rows['id'].'" onclick="deleteDataPmkp(this.value)">Delete</button>';
				echo '</td>';
			echo '</tr>';
		}
	break;
	case 'simpan-angka-kesalahan-input':
		$data = $konek->rawQuery("INSERT INTO ppi_angka_kesalahan_input(id_ruangan, id_pasien, id_kunjungan, tanggal_pemantauan, pilihan, user_id, tanggal_act,id_dokter,tanggal_pemeriksaan)VALUES({$ruangan},{$id_pasien},{$id_kunjungan},'{$tanggal_salah}','{$pilihan}',{$userId},now(),{$id_dokter},'{$tanggal_pemeriksaan}')");
		if($data) echo json_encode(['status' => 200]);
		else echo json_encode(['status' => 500]);
	break;
	case 'edit-angka-kesalahan-input':
		$data = $konek->rawQuery("UPDATE ppi_angka_kesalahan_input SET id_ruangan = {$ruangan}, tanggal_pemantauan = '{$tanggal_salah}',pilihan = '{$pilihan}', id_dokter = {$id_dokter},tanggal_pemeriksaan = '{$tanggal_pemeriksaan}' WHERE id = {$id}");
		if($data) echo json_encode(['status'=>200]);
		else echo json_encode(['status'=>500]);
	break;
	//angka kesalahan input
	case 'tampil_data_ketepatan_waktu_lapor':
		$data = $konek->rawQuery("SELECT 
				p.nama,
				r.nama_ruangan,
				i.* 
			FROM 
				{$namaTable} i 
				LEFT JOIN rspelindo_billing.b_ms_pasien p ON p.id = i.id_pasien 
				LEFT JOIN ppi_ruangan r ON r.id = i.id_ruangan
				WHERE i.id_pasien = {$_REQUEST['id_pasien']} AND i.id_kunjungan = {$id_kunjungan} AND MONTH(i.tanggal_pemantauan) = {$_REQUEST['bulan']} AND YEAR(i.tanggal_pemantauan) = {$_REQUEST['tahun']} ORDER BY i.tanggal_pemantauan");
		$no = 0;
		while($rows = $data->fetch_assoc()){
			$valEdit = $rows['id'] .'|'. $rows['id_ruangan'] . '|' . $rows['tanggal_pemeriksaan'] . '|' . $rows['tanggal_pemantauan'] . '|' . $rows['pilihan'] . '|'. $rows['id_dokter'];
			echo '<tr>';
				echo '<td>' . ++$no . '</td>';
				echo '<td>' . $rows['nama'] . '</td>';
				echo '<td style="text-transform:capitalize;">' . tanggal($rows['tanggal_pemeriksaan']) . '</td>';
				echo '<td style="text-transform:capitalize;">' . tanggal($rows['tanggal_pemantauan']) . '</td>';
				echo '<td>' . $rows['pilihan'] . '</td>';
				echo '<td>';
					echo '<button class="btn btn-sm btn-warning" value="'.$valEdit.'" onclick="editData(this.value)">Edit</button>';
					echo ' <button class="btn btn-sm btn-danger" value="'.$rows['id'].'" onclick="deleteDataPmkp(this.value)">Delete</button>';
				echo '</td>';
			echo '</tr>';
		}
	break;
	case 'simpan-ketepatan-waktu-lapor':
		$data = $konek->rawQuery("INSERT INTO ppi_ketepatan_waktu_lapor(id_ruangan, id_pasien, id_kunjungan, tanggal_pemantauan, pilihan, user_id, tanggal_act,id_dokter,tanggal_pemeriksaan)VALUES({$ruangan},{$id_pasien},{$id_kunjungan},'{$tanggal_lapor}','{$pilihan}',{$userId},now(),{$id_dokter},'{$tanggal_pemeriksaan}')");
		if($data) echo json_encode(['status' => 200]);
		else echo json_encode(['status' => 500]);
	break;
	case 'edit-ketepatan-waktu-lapor':
		$data = $konek->rawQuery("UPDATE ppi_ketepatan_waktu_lapor SET id_ruangan = {$ruangan}, tanggal_pemantauan = '{$tanggal_lapor}',pilihan = '{$pilihan}', id_dokter = {$id_dokter},tanggal_pemeriksaan = '{$tanggal_pemeriksaan}' WHERE id = {$id}");
		if($data) echo json_encode(['status'=>200]);
		else echo json_encode(['status'=>500]);
	break;

	//Pembatalan Operasi
	case 'tampil_data_pembatalan_operasi':
		$data = $konek->rawQuery("SELECT 
				p.nama,
				r.nama_ruangan,
				i.* 
			FROM 
				{$namaTable} i 
				LEFT JOIN rspelindo_billing.b_ms_pasien p ON p.id = i.id_pasien 
				LEFT JOIN ppi_ruangan r ON r.id = i.id_ruangan
				WHERE i.id_pasien = {$_REQUEST['id_pasien']} AND i.id_kunjungan = {$id_kunjungan} AND MONTH(i.tanggal_pemantauan) = {$_REQUEST['bulan']} AND YEAR(i.tanggal_pemantauan) = {$_REQUEST['tahun']} ORDER BY i.tanggal_pemantauan");
		$no = 0;
		while($rows = $data->fetch_assoc()){
			$valEdit = $rows['id'] .'|'. $rows['id_ruangan'] . '|' . $rows['tanggal_operasi'] . '|' .$rows['jenis_operasi']. '|' . $rows['tanggal_pemantauan'] . '|' . $rows['pilihan'] . '|'. $rows['id_dokter'];
			echo '<tr>';
				echo '<td>' . ++$no . '</td>';
				echo '<td>' . $rows['nama'] . '</td>';
				echo '<td style="text-transform:capitalize;">' . tanggal($rows['tanggal_operasi']) . '</td>';
				echo '<td>' . $rows['jenis_operasi'] . '</td>';
				echo '<td>' . $rows['pilihan'] . '</td>';
				echo '<td style="text-transform:capitalize;">' . tanggal($rows['tanggal_pemantauan']) . '</td>';
				echo '<td>';
					echo '<button class="btn btn-sm btn-warning" value="'.$valEdit.'" onclick="editData(this.value)">Edit</button>';
					echo ' <button class="btn btn-sm btn-danger" value="'.$rows['id'].'" onclick="deleteDataPmkp(this.value)">Delete</button>';
				echo '</td>';
			echo '</tr>';
		}
	break;
	case 'simpan-pembatalan-operasi':
		$data = $konek->rawQuery("INSERT INTO ppi_pembatalan_operasi(id_pasien, id_kunjungan, tanggal_pemantauan, pilihan, user_id, tanggal_act,id_dokter,tanggal_operasi,jenis_operasi)VALUES({$id_pasien},{$id_kunjungan},'{$tanggal_pembatalan}','{$pilihan}',{$userId},now(),{$id_dokter},'{$tanggal_operasi}','{$jenis_operasi}')");
		if($data) echo json_encode(['status' => 200]);
		else echo json_encode(['status' => 500]);
	break;
	case 'edit-pembatalan-operasi':
		$data = $konek->rawQuery("UPDATE ppi_pembatalan_operasi SET tanggal_pemantauan = '{$tanggal_pembatalan}',pilihan = '{$pilihan}', id_dokter = {$id_dokter},tanggal_operasi = '{$tanggal_operasi}', jenis_operasi = '{$jenis_operasi}' WHERE id = {$id}");
		if($data) echo json_encode(['status'=>200]);
		else echo json_encode(['status'=>500]);
	break;
	//Infeksi Operasi
	case 'tampil_data_infeksi_operasi':
		$data = $konek->rawQuery("SELECT 
				p.nama,
				r.nama_ruangan,
				i.* 
			FROM 
				{$namaTable} i 
				LEFT JOIN rspelindo_billing.b_ms_pasien p ON p.id = i.id_pasien 
				LEFT JOIN ppi_ruangan r ON r.id = i.id_ruangan
				WHERE i.id_pasien = {$_REQUEST['id_pasien']} AND i.id_kunjungan = {$id_kunjungan} AND MONTH(i.tanggal_pemantauan) = {$_REQUEST['bulan']} AND YEAR(i.tanggal_pemantauan) = {$_REQUEST['tahun']} ORDER BY i.tanggal_pemantauan");
		$no = 0;
		while($rows = $data->fetch_assoc()){
			$valEdit = $rows['id'] .'|'. $rows['id_ruangan'] . '|' . $rows['tanggal_operasi'] . '|' .$rows['jenis_operasi']. '|' . $rows['tanggal_pemantauan'] . '|' . $rows['pilihan'] . '|'. $rows['id_dokter'];
			echo '<tr>';
				echo '<td>' . ++$no . '</td>';
				echo '<td>' . $rows['nama'] . '</td>';
				echo '<td style="text-transform:capitalize;">' . tanggal($rows['tanggal_operasi']) . '</td>';
				echo '<td>' . $rows['jenis_operasi'] . '</td>';
				echo '<td>' . $rows['pilihan'] . '</td>';
				echo '<td style="text-transform:capitalize;">' . tanggal($rows['tanggal_pemantauan']) . '</td>';
				echo '<td>';
					echo '<button class="btn btn-sm btn-warning" value="'.$valEdit.'" onclick="editData(this.value)">Edit</button>';
					echo ' <button class="btn btn-sm btn-danger" value="'.$rows['id'].'" onclick="deleteDataPmkp(this.value)">Delete</button>';
				echo '</td>';
			echo '</tr>';
		}
	break;
	case 'simpan-infeksi-operasi':
		$data = $konek->rawQuery("INSERT INTO ppi_infeksi_operasi_pmkp(id_ruangan,id_pasien, id_kunjungan, tanggal_pemantauan, pilihan, user_id, tanggal_act,id_dokter,tanggal_operasi,jenis_operasi)VALUES({$ruangan},{$id_pasien},{$id_kunjungan},'{$tanggal_infeksi}','{$pilihan}',{$userId},now(),{$id_dokter},'{$tanggal}','{$jenis_operasi}')");
		if($data) echo json_encode(['status' => 200]);
		else echo json_encode(['status' => 500]);
	break;
	case 'edit-infeksi-operasi':
		$data = $konek->rawQuery("UPDATE ppi_infeksi_operasi_pmkp SET id_ruangan = {$ruangan},tanggal_pemantauan = '{$tanggal_infeksi}',pilihan = '{$pilihan}', id_dokter = {$id_dokter},tanggal_operasi = '{$tanggal}', jenis_operasi = '{$jenis_operasi}' WHERE id = {$id}");
		if($data) echo json_encode(['status'=>200]);
		else echo json_encode(['status'=>500]);
	break;

	//presentase sc
	case 'tampil_data_presentase_sc':
		$data = $konek->rawQuery("SELECT 
				p.nama,
				r.nama_ruangan,
				i.* 
			FROM 
				{$namaTable} i 
				LEFT JOIN rspelindo_billing.b_ms_pasien p ON p.id = i.id_pasien 
				LEFT JOIN ppi_ruangan r ON r.id = i.id_ruangan
				WHERE i.id_pasien = {$_REQUEST['id_pasien']} AND i.id_kunjungan = {$id_kunjungan} AND MONTH(i.tanggal_pemantauan) = {$_REQUEST['bulan']} AND YEAR(i.tanggal_pemantauan) = {$_REQUEST['tahun']} ORDER BY i.tanggal_pemantauan");
		$no = 0;
		while($rows = $data->fetch_assoc()){
			$valEdit = $rows['id'] .'|'. $rows['id_ruangan'] . '|' . $rows['tanggal_pemantauan'] . '|' . $rows['pilihan'] . '|'. $rows['id_dokter'];
			echo '<tr>';
				echo '<td>' . ++$no . '</td>';
				echo '<td>' . $rows['nama'] . '</td>';
				echo '<td>' . $rows['tanggal_pemantauan'] . '</td>';
				echo '<td>' . $rows['pilihan'] . '</td>';
				echo '<td>';
					echo '<button class="btn btn-sm btn-warning" value="'.$valEdit.'" onclick="editData(this.value)">Edit</button>';
					echo ' <button class="btn btn-sm btn-danger" value="'.$rows['id'].'" onclick="deleteDataPmkp(this.value)">Delete</button>';
				echo '</td>';
			echo '</tr>';
		}
	break;
	case 'simpan-presentase-sc':
		$data = $konek->rawQuery("INSERT INTO ppi_presentase_sc(id_pasien, id_kunjungan, tanggal_pemantauan, pilihan, user_id, tanggal_act,id_dokter)VALUES({$id_pasien},{$id_kunjungan},'{$tanggal}','{$pilihan}',{$userId},now(),{$id_dokter})");
		if($data) echo json_encode(['status' => 200]);
		else echo json_encode(['status' => 500]);
	break;
	case 'edit-presentase-sc':
		$data = $konek->rawQuery("UPDATE ppi_presentase_sc SET tanggal_pemantauan = '{$tanggal}',pilihan = '{$pilihan}', id_dokter = {$id_dokter} WHERE id = {$id}");
		if($data) echo json_encode(['status'=>200]);
		else echo json_encode(['status'=>500]);
	break;

	//obat sesuai formalium
	case 'simpan-obat-sesuai-formalium':
		$data = $konek->rawQuery("INSERT INTO ppi_obat_sesuai_formalium(id_pasien, id_kunjungan, tanggal_pemantauan, pilihan, user_id, tanggal_act,id_dokter)VALUES({$id_pasien},{$id_kunjungan},'{$tanggal}','{$pilihan}',{$userId},now(),{$id_dokter})");
		if($data) echo json_encode(['status' => 200]);
		else echo json_encode(['status' => 500]);
	break;
	case 'edit-obat-sesuai-formalium':
		$data = $konek->rawQuery("UPDATE ppi_obat_sesuai_formalium SET tanggal_pemantauan = '{$tanggal}',pilihan = '{$pilihan}', id_dokter = {$id_dokter} WHERE id = {$id}");
		if($data) echo json_encode(['status'=>200]);
		else echo json_encode(['status'=>500]);
	break;

	//Pemberian Sesuai Resep
	case 'simpan-pemberian-obat-sesuai-resep':
		$data = $konek->rawQuery("INSERT INTO ppi_pemberian_obat_sesuai_resep(id_pasien, id_kunjungan, tanggal_pemantauan, pilihan, user_id, tanggal_act,id_dokter)VALUES({$id_pasien},{$id_kunjungan},'{$tanggal}','{$pilihan}',{$userId},now(),{$id_dokter})");
		if($data) echo json_encode(['status' => 200]);
		else echo json_encode(['status' => 500]);
	break;
	case 'edit-pemberian-obat-sesuai-resep':
		$data = $konek->rawQuery("UPDATE ppi_pemberian_obat_sesuai_resep SET tanggal_pemantauan = '{$tanggal}',pilihan = '{$pilihan}', id_dokter = {$id_dokter} WHERE id = {$id}");
		if($data) echo json_encode(['status'=>200]);
		else echo json_encode(['status' => 500]);
	break;

	//Pemberian Sesuai Resep
	case 'simpan-kelengkapan-resep-obat':
		$data = $konek->rawQuery("INSERT INTO ppi_kelengkapan_resep_obat(id_pasien, id_kunjungan, tanggal_pemantauan, pilihan, user_id, tanggal_act,id_dokter)VALUES({$id_pasien},{$id_kunjungan},'{$tanggal}','{$pilihan}',{$userId},now(),{$id_dokter})");
		if($data) echo json_encode(['status' => 200]);
		else echo json_encode(['status' => 500]);
	break;
	case 'edit-kelengkapan-resep-obat':
		$data = $konek->rawQuery("UPDATE ppi_kelengkapan_resep_obat SET tanggal_pemantauan = '{$tanggal}',pilihan = '{$pilihan}', id_dokter = {$id_dokter} WHERE id = {$id}");
		if($data) echo json_encode(['status'=>200]);
		else echo json_encode(['status' => 500]);
	break;

	//Kepatuhan Visite
	case 'tampil_data_kepatuhan_jam_visite_dokter':
		$data = $konek->rawQuery("SELECT 
				p.nama,
				r.nama_ruangan,
				i.* 
			FROM 
				{$namaTable} i 
				LEFT JOIN rspelindo_billing.b_ms_pegawai p ON p.id = i.id_dokter
				LEFT JOIN ppi_ruangan r ON r.id = i.id_ruangan
				WHERE MONTH(i.tanggal_pemantauan) = {$_REQUEST['bulan']} AND YEAR(i.tanggal_pemantauan) = {$_REQUEST['tahun']} ORDER BY i.tanggal_pemantauan");
		$no = 0;
		while($rows = $data->fetch_assoc()){
			$valEdit = $rows['id'] .'|'. $rows['id_ruangan'] . '|' . $rows['tanggal_pemantauan'] . '|' . $rows['pilihan'] . '|'. $rows['id_dokter'];
			echo '<tr>';
				echo '<td>' . ++$no . '</td>';
				echo '<td>' . $rows['nama'] . '</td>';
				echo '<td>' . $rows['nama_ruangan'] . '</td>';
				echo '<td>' . $rows['tanggal_pemantauan'] . '</td>';
				echo '<td>' . $rows['pilihan'] . '</td>';
				echo '<td>';
					echo '<button class="btn btn-sm btn-warning" value="'.$valEdit.'" onclick="editData(this.value)">Edit</button>';
					echo ' <button class="btn btn-sm btn-danger" value="'.$rows['id'].'" onclick="deleteDataPmkp(this.value)">Delete</button>';
				echo '</td>';
			echo '</tr>';
		}
	break;
	case 'simpan-kepatuhan-jam-visite-dokter':
		$data = $konek->rawQuery("INSERT INTO ppi_kepatuhan_jam_visite_dokter(id_ruangan,tanggal_pemantauan, pilihan, user_id, tanggal_act,id_dokter)VALUES({$ruangan},'{$tanggal}','{$pilihan}',{$userId},now(),{$id_dokter})");
		if($data) echo json_encode(['status' => 200]);
		else echo json_encode(['status' => 500]);
	break;
	case 'edit-kepatuhan-jam-visite-dokter':
		$data = $konek->rawQuery("UPDATE ppi_kepatuhan_jam_visite_dokter SET tanggal_pemantauan = '{$tanggal}',pilihan = '{$pilihan}', id_dokter = {$id_dokter}, id_ruangan = {$ruangan} WHERE id = {$id}");
		if($data) echo json_encode(['status'=>200]);
		else echo json_encode(['status' => 500]);
	break;

	//Waktu Tunggu Rawat Jalan
	case 'tampil_data_waktu_tunggu_rawat_jalan':
		$data = $konek->rawQuery("SELECT 
				p.nama,
				r.nama_ruangan,
				k.tgl_act,
				i.* 
			FROM 
				{$namaTable} i 
				LEFT JOIN rspelindo_billing.b_ms_pasien p ON p.id = i.id_pasien 
				LEFT JOIN ppi_ruangan r ON r.id = i.id_ruangan
				LEFT JOIN rspelindo_billing.b_kunjungan k ON k.id = i.id_kunjungan
				WHERE i.id_pasien = {$_REQUEST['id_pasien']} AND i.id_kunjungan = {$id_kunjungan} AND MONTH(i.tanggal_pemantauan) = {$_REQUEST['bulan']} AND YEAR(i.tanggal_pemantauan) = {$_REQUEST['tahun']} ORDER BY i.tanggal_pemantauan");
		$no = 0;
		while($rows = $data->fetch_assoc()){
			$valEdit = $rows['id'].'|' .$rows['jam_dilayani']. '|' . $rows['tanggal_pemantauan'] . '|' . $rows['pilihan'] . '|'. $rows['id_dokter'];
			echo '<tr>';
				echo '<td>' . ++$no . '</td>';
				echo '<td>' . $rows['nama'] . '</td>';
				echo '<td>' . $rows['tgl_act'] . '</td>';
				echo '<td>' . $rows['tanggal_pemantauan']." ".$rows['jam_dilayani'] . '</td>';
				echo '<td>' . $rows['pilihan'] . '</td>';
				echo '<td>';
					echo '<button class="btn btn-sm btn-warning" value="'.$valEdit.'" onclick="editData(this.value)">Edit</button>';
					echo ' <button class="btn btn-sm btn-danger" value="'.$rows['id'].'" onclick="deleteDataPmkp(this.value)">Delete</button>';
				echo '</td>';
			echo '</tr>';
		}
	break;
	case 'simpan-waktu-tunggu-rawat-jalan':
		$data = $konek->rawQuery("INSERT INTO ppi_waktu_rawat_jalan(id_pasien, id_kunjungan, tanggal_pemantauan, pilihan, user_id, tanggal_act,id_dokter,jam_dilayani)VALUES({$id_pasien},{$id_kunjungan},'{$tanggal}','{$pilihan}',{$userId},now(),{$id_dokter},'{$jam_dilayani}')");
		if($data) echo json_encode(['status' => 200]);
		else echo json_encode(['status' => 500]);
	break;
	case 'edit-waktu-tunggu-rawat-jalan':
		$data = $konek->rawQuery("UPDATE ppi_waktu_rawat_jalan SET tanggal_pemantauan = '{$tanggal}',pilihan = '{$pilihan}', id_dokter = {$id_dokter}, jam_dilayani = '{$jam_dilayani}' WHERE id = {$id}");
		if($data) echo json_encode(['status'=>200]);
		else echo json_encode(['status'=>500]);
	break;

	//Waktu Tanggap Gawat Darurat
	case 'tampil_data_waktu_tanggap_gawat_darurat':
		$data = $konek->rawQuery("SELECT 
				p.nama,
				r.nama_ruangan,
				k.tgl_act,
				i.* 
			FROM 
				{$namaTable} i 
				LEFT JOIN rspelindo_billing.b_ms_pasien p ON p.id = i.id_pasien 
				LEFT JOIN ppi_ruangan r ON r.id = i.id_ruangan
				LEFT JOIN rspelindo_billing.b_kunjungan k ON k.id = i.id_kunjungan
				WHERE i.id_pasien = {$_REQUEST['id_pasien']} AND i.id_kunjungan = {$id_kunjungan} AND MONTH(i.tanggal_pemantauan) = {$_REQUEST['bulan']} AND YEAR(i.tanggal_pemantauan) = {$_REQUEST['tahun']} ORDER BY i.tanggal_pemantauan");
		$no = 0;
		while($rows = $data->fetch_assoc()){
			$valEdit = $rows['id'].'|' .$rows['jam_dilayani']. '|' . $rows['tanggal_pemantauan'] . '|' . $rows['pilihan'] . '|'. $rows['id_dokter'];
			echo '<tr>';
				echo '<td>' . ++$no . '</td>';
				echo '<td>' . $rows['nama'] . '</td>';
				echo '<td>' . $rows['tgl_act'] . '</td>';
				echo '<td>' . $rows['tanggal_pemantauan']." ".$rows['jam_dilayani'] . '</td>';
				echo '<td>' . $rows['pilihan'] . '</td>';
				echo '<td>';
					echo '<button class="btn btn-sm btn-warning" value="'.$valEdit.'" onclick="editData(this.value)">Edit</button>';
					echo ' <button class="btn btn-sm btn-danger" value="'.$rows['id'].'" onclick="deleteDataPmkp(this.value)">Delete</button>';
				echo '</td>';
			echo '</tr>';
		}
	break;
	case 'simpan-waktu-tanggap-gawat-darurat':
		$data = $konek->rawQuery("INSERT INTO ppi_waktu_tanggap_gawat_darurat(id_pasien, id_kunjungan, tanggal_pemantauan, pilihan, user_id, tanggal_act,id_dokter,jam_dilayani)VALUES({$id_pasien},{$id_kunjungan},'{$tanggal}','{$pilihan}',{$userId},now(),{$id_dokter},'{$jam_dilayani}')");
		if($data) echo json_encode(['status' => 200]);
		else echo json_encode(['status' => 500]);
	break;
	case 'edit-waktu-tanggap-gawat-darurat':
		$data = $konek->rawQuery("UPDATE ppi_waktu_tanggap_gawat_darurat SET tanggal_pemantauan = '{$tanggal}',pilihan = '{$pilihan}', id_dokter = {$id_dokter}, jam_dilayani = '{$jam_dilayani}' WHERE id = {$id}");
		if($data) echo json_encode(['status'=>200]);
		else echo json_encode(['status'=>500]);
	break;

	//Waktu Tunggu Hasil Radiologi
	case 'tampil_data_waktu_tunggu_hasil_radiologi':
		$data = $konek->rawQuery("SELECT 
				p.nama,
				r.nama_ruangan,
				k.tgl_act,
				i.* 
			FROM 
				{$namaTable} i 
				LEFT JOIN rspelindo_billing.b_ms_pasien p ON p.id = i.id_pasien 
				LEFT JOIN ppi_ruangan r ON r.id = i.id_ruangan
				LEFT JOIN rspelindo_billing.b_kunjungan k ON k.id = i.id_kunjungan
				WHERE i.id_pasien = {$_REQUEST['id_pasien']} AND i.id_kunjungan = {$id_kunjungan} AND MONTH(i.tanggal_pemantauan) = {$_REQUEST['bulan']} AND YEAR(i.tanggal_pemantauan) = {$_REQUEST['tahun']} ORDER BY i.tanggal_pemantauan");
		$no = 0;
		while($rows = $data->fetch_assoc()){
			$valEdit = $rows['id'].'|' .$rows['jam_dilayani']. '|' . $rows['tanggal_pemantauan'] . '|' . $rows['pilihan'] . '|'. $rows['id_dokter'] . '|'. $rows['jam_selesai'];
			echo '<tr>';
				echo '<td>' . ++$no . '</td>';
				echo '<td>' . $rows['nama'] . '</td>';
				echo '<td>' . $rows['tgl_act'] . '</td>';
				echo '<td>' . $rows['tanggal_pemantauan']." ".$rows['jam_dilayani'] . '</td>';
				echo '<td>' . $rows['pilihan'] . '</td>';
				echo '<td>';
					echo '<button class="btn btn-sm btn-warning" value="'.$valEdit.'" onclick="editData(this.value)">Edit</button>';
					echo ' <button class="btn btn-sm btn-danger" value="'.$rows['id'].'" onclick="deleteDataPmkp(this.value)">Delete</button>';
				echo '</td>';
			echo '</tr>';
		}
	break;
	case 'simpan-waktu-tunggu-hasil-radiologi':
		$data = $konek->rawQuery("INSERT INTO ppi_waktu_tunggu_hasil_radiologi(id_pasien, id_kunjungan, tanggal_pemantauan, pilihan, user_id, tanggal_act,id_dokter,jam_dilayani,jam_selesai)VALUES({$id_pasien},{$id_kunjungan},'{$tanggal}','{$pilihan}',{$userId},now(),{$id_dokter},'{$jam_dilayani}','{$jam_selesai}')");
		if($data) echo json_encode(['status' => 200]);
		else echo json_encode(['status' => 500]);
	break;
	case 'edit-waktu-tunggu-hasil-radiologi':
		$data = $konek->rawQuery("UPDATE ppi_waktu_tunggu_hasil_radiologi SET tanggal_pemantauan = '{$tanggal}',pilihan = '{$pilihan}', id_dokter = {$id_dokter}, jam_dilayani = '{$jam_dilayani}', jam_selesai = '{$jam_selesai}' WHERE id = {$id}");
		if($data) echo json_encode(['status'=>200]);
		else echo json_encode(['status'=>500]);
	break;

	//Kepuasan pasien dan keluarga
	case 'tampil_kepuasan_pasien':
		$data = $konek->rawQuery("SELECT 
				p.nama,
				r.nama_ruangan,
				k.tgl_act,
				i.* 
			FROM 
				{$namaTable} i 
				LEFT JOIN rspelindo_billing.b_ms_pasien p ON p.id = i.id_pasien 
				LEFT JOIN ppi_ruangan r ON r.id = i.id_ruangan
				LEFT JOIN rspelindo_billing.b_kunjungan k ON k.id = i.id_kunjungan
				WHERE i.id_pasien = {$_REQUEST['id_pasien']} AND i.id_kunjungan = {$id_kunjungan} AND MONTH(i.tanggal_pemantauan) = {$_REQUEST['bulan']} AND YEAR(i.tanggal_pemantauan) = {$_REQUEST['tahun']} ORDER BY i.tanggal_pemantauan");
		$no = 0;
		while($rows = $data->fetch_assoc()){
			$valEdit = $rows['id'].'|' .$rows['jam_dilayani']. '|' . $rows['tanggal_pemantauan'] . '|' . $rows['pilihan'] . '|'. $rows['id_dokter']. '|'. $rows['tanggal_pulang'];
			echo '<tr>';
				echo '<td>' . ++$no . '</td>';
				echo '<td>' . $rows['nama'] . '</td>';
				echo '<td>' . $rows['tgl_act'] . '</td>';
				echo '<td>' . $rows['tanggal_pemantauan']." ".$rows['jam_dilayani'] . '</td>';
				echo '<td>' . $rows['pilihan'] . '</td>';
				echo '<td>';
					echo '<button class="btn btn-sm btn-warning" value="'.$valEdit.'" onclick="editData(this.value)">Edit</button>';
					echo ' <button class="btn btn-sm btn-danger" value="'.$rows['id'].'" onclick="deleteDataPmkp(this.value)">Delete</button>';
				echo '</td>';
			echo '</tr>';
		}
	break;
	case 'simpan-kepuasan-pasien':
		$data = $konek->rawQuery("INSERT INTO ppi_kepuasan_pasien(id_pasien, id_kunjungan, tanggal_pemantauan, pilihan, user_id, tanggal_act,id_dokter,jam_dilayani,tanggal_pulang)VALUES({$id_pasien},{$id_kunjungan},'{$tanggal}','{$pilihan}',{$userId},now(),{$id_dokter},'{$jam_dilayani}','{$tanggal_pulang}')");
		if($data) echo json_encode(['status' => 200]);
		else echo json_encode(['status' => 500]);
	break;
	case 'edit-kepuasan-pasien':
		$data = $konek->rawQuery("UPDATE ppi_kepuasan_pasien SET tanggal_pemantauan = '{$tanggal}',pilihan = '{$pilihan}', id_dokter = {$id_dokter}, jam_dilayani = '{$jam_dilayani}', tanggal_pulang = '{$tanggal_pulang}' WHERE id = {$id}");
		if($data) echo json_encode(['status'=>200]);
		else echo json_encode(['status'=>500]);
	break;

	//Kepuasan pasien dan keluarga
	case 'tampil_komunikasi_efektif':
		$data = $konek->rawQuery("SELECT 
				p.nama,
				r.nama_ruangan,
				k.tgl_act,
				i.* 
			FROM 
				{$namaTable} i 
				LEFT JOIN rspelindo_billing.b_ms_pasien p ON p.id = i.id_pasien 
				LEFT JOIN ppi_ruangan r ON r.id = i.id_ruangan
				LEFT JOIN rspelindo_billing.b_kunjungan k ON k.id = i.id_kunjungan
				WHERE i.id_pasien = {$_REQUEST['id_pasien']} AND i.id_kunjungan = {$id_kunjungan} AND MONTH(i.tanggal_pemantauan) = {$_REQUEST['bulan']} AND YEAR(i.tanggal_pemantauan) = {$_REQUEST['tahun']} ORDER BY i.tanggal_pemantauan");
		$no = 0;
		while($rows = $data->fetch_assoc()){
			$valEdit = $rows['id'].'|' .$rows['jam_dilayani']. '|' . $rows['tanggal_pemantauan'] . '|' . $rows['pilihan'] . '|'. $rows['id_dokter'];
			echo '<tr>';
				echo '<td>' . ++$no . '</td>';
				echo '<td>' . $rows['nama'] . '</td>';
				echo '<td>' . $rows['tgl_act'] . '</td>';
				echo '<td>' . $rows['tanggal_pemantauan']." ".$rows['jam_dilayani'] . '</td>';
				echo '<td>' . $rows['pilihan'] . '</td>';
				echo '<td>';
					echo '<button class="btn btn-sm btn-warning" value="'.$valEdit.'" onclick="editData(this.value)">Edit</button>';
					echo ' <button class="btn btn-sm btn-danger" value="'.$rows['id'].'" onclick="deleteDataPmkp(this.value)">Delete</button>';
				echo '</td>';
			echo '</tr>';
		}
	break;
	case 'simpan-komunikasi-efektif':
		$data = $konek->rawQuery("INSERT INTO ppi_komunikasi_efektif(id_pasien, id_kunjungan, tanggal_pemantauan, pilihan, user_id, tanggal_act,id_dokter,jam_dilayani)VALUES({$id_pasien},{$id_kunjungan},'{$tanggal}','{$pilihan}',{$userId},now(),{$id_dokter},'{$jam_dilayani}')");
		if($data) echo json_encode(['status' => 200]);
		else echo json_encode(['status' => 500]);
	break;
	case 'edit-komunikasi-efektif':
		$data = $konek->rawQuery("UPDATE ppi_komunikasi_efektif SET tanggal_pemantauan = '{$tanggal}',pilihan = '{$pilihan}', id_dokter = {$id_dokter}, jam_dilayani = '{$jam_dilayani}' WHERE id = {$id}");
		if($data) echo json_encode(['status'=>200]);
		else echo json_encode(['status'=>500]);
	break;
	
	//Penanganan obat
	case 'tampil_penanganan_obat':
		$data = $konek->rawQuery("SELECT 
				p.nama,
				r.nama_ruangan,
				k.tgl_act,
				i.* 
			FROM 
				{$namaTable} i 
				LEFT JOIN rspelindo_billing.b_ms_pasien p ON p.id = i.id_pasien 
				LEFT JOIN ppi_ruangan r ON r.id = i.id_ruangan
				LEFT JOIN rspelindo_billing.b_kunjungan k ON k.id = i.id_kunjungan
				WHERE i.id_pasien = {$_REQUEST['id_pasien']} AND i.id_kunjungan = {$id_kunjungan} AND MONTH(i.tanggal_pemantauan) = {$_REQUEST['bulan']} AND YEAR(i.tanggal_pemantauan) = {$_REQUEST['tahun']} ORDER BY i.tanggal_pemantauan");
		$no = 0;
		while($rows = $data->fetch_assoc()){
			$valEdit = $rows['id'].'|' .$rows['jam_dilayani']. '|' . $rows['tanggal_pemantauan'] . '|' . $rows['pilihan'] . '|'. $rows['id_dokter'];
			echo '<tr>';
				echo '<td>' . ++$no . '</td>';
				echo '<td>' . $rows['nama'] . '</td>';
				echo '<td>' . $rows['tgl_act'] . '</td>';
				echo '<td>' . $rows['tanggal_pemantauan']." ".$rows['jam_dilayani'] . '</td>';
				echo '<td>' . $rows['pilihan'] . '</td>';
				echo '<td>';
					echo '<button class="btn btn-sm btn-warning" value="'.$valEdit.'" onclick="editData(this.value)">Edit</button>';
					echo ' <button class="btn btn-sm btn-danger" value="'.$rows['id'].'" onclick="deleteDataPmkp(this.value)">Delete</button>';
				echo '</td>';
			echo '</tr>';
		}
	break;
	case 'simpan-penanganan-obat':
		$data = $konek->rawQuery("INSERT INTO ppi_penanganan_obat(id_pasien, id_kunjungan, tanggal_pemantauan, pilihan, user_id, tanggal_act,id_dokter,jam_dilayani)VALUES({$id_pasien},{$id_kunjungan},'{$tanggal}','{$pilihan}',{$userId},now(),{$id_dokter},'{$jam_dilayani}')");
		if($data) echo json_encode(['status' => 200]);
		else echo json_encode(['status' => 500]);
	break;
	case 'edit-penanganan-obat':
		$data = $konek->rawQuery("UPDATE ppi_penanganan_obat SET tanggal_pemantauan = '{$tanggal}',pilihan = '{$pilihan}', id_dokter = {$id_dokter}, jam_dilayani = '{$jam_dilayani}' WHERE id = {$id}");
		if($data) echo json_encode(['status'=>200]);
		else echo json_encode(['status'=>500]);
	break;

	//Assesment Pasien Jatuh
	case 'tampil_assesment_pasien_jatuh':
		$data = $konek->rawQuery("SELECT 
				p.nama,
				r.nama_ruangan,
				k.tgl_act,
				i.* 
			FROM 
				{$namaTable} i 
				LEFT JOIN rspelindo_billing.b_ms_pasien p ON p.id = i.id_pasien 
				LEFT JOIN ppi_ruangan r ON r.id = i.id_ruangan
				LEFT JOIN rspelindo_billing.b_kunjungan k ON k.id = i.id_kunjungan
				WHERE i.id_pasien = {$_REQUEST['id_pasien']} AND i.id_kunjungan = {$id_kunjungan} AND MONTH(i.tanggal_pemantauan) = {$_REQUEST['bulan']} AND YEAR(i.tanggal_pemantauan) = {$_REQUEST['tahun']} ORDER BY i.tanggal_pemantauan");
		$no = 0;
		while($rows = $data->fetch_assoc()){
			$valEdit = $rows['id'].'|' .$rows['jam_dilayani']. '|' . $rows['tanggal_pemantauan'] . '|' . $rows['pilihan'] . '|'. $rows['id_dokter']. '|'. $rows['id_ruangan'];
			echo '<tr>';
				echo '<td>' . ++$no . '</td>';
				echo '<td>' . $rows['nama'] . '</td>';
				echo '<td>' . $rows['tgl_act'] . '</td>';
				echo '<td>' . $rows['tanggal_pemantauan']." ".$rows['jam_dilayani'] . '</td>';
				echo '<td>' . $rows['pilihan'] . '</td>';
				echo '<td>';
					echo '<button class="btn btn-sm btn-warning" value="'.$valEdit.'" onclick="editData(this.value)">Edit</button>';
					echo ' <button class="btn btn-sm btn-danger" value="'.$rows['id'].'" onclick="deleteDataPmkp(this.value)">Delete</button>';
				echo '</td>';
			echo '</tr>';
		}
	break;
	case 'simpan-assesment-pasien-jatuh':
		$data = $konek->rawQuery("INSERT INTO ppi_assesment_pasien_jatuh(id_pasien,id_ruangan, id_kunjungan, tanggal_pemantauan, pilihan, user_id, tanggal_act,id_dokter,jam_dilayani)VALUES({$id_pasien},{$ruangan},{$id_kunjungan},'{$tanggal}','{$pilihan}',{$userId},now(),{$id_dokter},'{$jam_dilayani}')");
		if($data) echo json_encode(['status' => 200]);
		else echo json_encode(['status' => 500]);
	break;
	case 'edit-assesment-pasien-jatuh':
		$data = $konek->rawQuery("UPDATE ppi_assesment_pasien_jatuh SET tanggal_pemantauan = '{$tanggal}',pilihan = '{$pilihan}', id_dokter = {$id_dokter}, jam_dilayani = '{$jam_dilayani}' WHERE id = {$id}");
		if($data) echo json_encode(['status'=>200]);
		else echo json_encode(['status'=>500]);
	break;

	//CHECKLIST KESELAMATAN PASIEN OPERASI
	case 'tampil_keselamatan_pasien_operasi':
		$data = $konek->rawQuery("SELECT 
				p.nama,
				r.nama_ruangan,
				i.* 
			FROM 
				{$namaTable} i 
				LEFT JOIN rspelindo_billing.b_ms_pasien p ON p.id = i.id_pasien 
				LEFT JOIN ppi_ruangan r ON r.id = i.id_ruangan
				WHERE i.id_pasien = {$_REQUEST['id_pasien']} AND i.id_kunjungan = {$id_kunjungan} AND MONTH(i.tanggal_pemantauan) = {$_REQUEST['bulan']} AND YEAR(i.tanggal_pemantauan) = {$_REQUEST['tahun']} ORDER BY i.tanggal_pemantauan");
		$no = 0;
		while($rows = $data->fetch_assoc()){
			$valEdit = $rows['id'] .'|'. $rows['id_ruangan'] . '|' . $rows['tanggal_operasi'] . '|' .$rows['jenis_operasi']. '|' . $rows['tanggal_pemantauan'] . '|' . $rows['pilihan'] . '|'. $rows['id_dokter'];
			echo '<tr>';
				echo '<td>' . ++$no . '</td>';
				echo '<td>' . $rows['nama'] . '</td>';
				echo '<td style="text-transform:capitalize;">' . tanggal($rows['tanggal_operasi']) . '</td>';
				echo '<td>' . $rows['jenis_operasi'] . '</td>';
				echo '<td>' . $rows['pilihan'] . '</td>';
				echo '<td style="text-transform:capitalize;">' . tanggal($rows['tanggal_pemantauan']) . '</td>';
				echo '<td>';
					echo '<button class="btn btn-sm btn-warning" value="'.$valEdit.'" onclick="editData(this.value)">Edit</button>';
					echo ' <button class="btn btn-sm btn-danger" value="'.$rows['id'].'" onclick="deleteDataPmkp(this.value)">Delete</button>';
				echo '</td>';
			echo '</tr>';
		}
	break;
	case 'simpan-keselamatan-pasien-operasi':
		$data = $konek->rawQuery("INSERT INTO ppi_checklist_keselamatan_pasien_operasi(id_pasien, id_kunjungan, tanggal_pemantauan, pilihan, user_id, tanggal_act,id_dokter,tanggal_operasi,jenis_operasi)VALUES({$id_pasien},{$id_kunjungan},'{$tanggal_dilayani}','{$pilihan}',{$userId},now(),{$id_dokter},'{$tanggal_operasi}','{$jenis_operasi}')");
		if($data) echo json_encode(['status' => 200]);
		else echo json_encode(['status' => 500]);
	break;
	case 'edit-keselamatan-pasien-operasi':
		$data = $konek->rawQuery("UPDATE ppi_checklist_keselamatan_pasien_operasi SET tanggal_pemantauan = '{$tanggal_dilayani}',pilihan = '{$pilihan}', id_dokter = {$id_dokter},tanggal_operasi = '{$tanggal_operasi}', jenis_operasi = '{$jenis_operasi}' WHERE id = {$id}");
		if($data) echo json_encode(['status'=>200]);
		else echo json_encode(['status'=>500]);
	break;
	
	
	//delete to all pmkp
	case 'delete':
		$data = $konek->rawQuery("DELETE FROM {$namaTable} WHERE id = {$id}");
		if($data) echo json_encode(['status'=>200]);
		else echo json_encode(['status'=>500]);
	break;

	//master data
	case 'getRuangan':
        $data = $konek->rawQuery("SELECT * FROM ppi_ruangan");
        $arrData = [];
        while ($rows = $data->fetch_assoc()) {
            $arrData[] = [$rows['id'] => $rows['nama_ruangan']];
        }
        echo json_encode($arrData);
        break;
    case 'getIpcn':
        $data = $konek->rawQuery("SELECT * FROM ppi_ipcn");
        $arrData = [];
        while ($rows = $data->fetch_assoc()) {
            $arrData[] = [$rows['id'] => $rows['nama']];
        }
        echo json_encode($arrData);
		break;
	case 'getDokter':
		$data = $konek->rawQuery("SELECT id,nama FROM rspelindo_billing.b_ms_pegawai WHERE pegawai_jenis = 8");
		$arrData = [];
		while($rows = $data->fetch_assoc()) $arrData[] = [$rows['id'] => $rows['nama']];
		echo json_encode($arrData);
	break;
	default:
		// code...
		break;
}

?>