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
$ruangan = $_REQUEST['ruangan'];
//action
$act = $_REQUEST['act'];
$namaTable = $_REQUEST['nama_table'];
$s = $_REQUEST['s'];
$o = $_REQUEST['o'];
$a = $_REQUEST['a'];
$p = $_REQUEST['p'];
$review_verifikasi_dpjp = $_REQUEST['review_verifikasi_dpjp'];
$instruksi_ppa = $_REQUEST['instruksi_ppa'];
$pemberi_asuhan = $_REQUEST['pemberi_asuhan'];

switch ($act) {
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
	case 'tampil_data_mirm':
		$data = $konek->rawQuery("SELECT * FROM ppi_perkembangan_pasien_terintegrasi WHERE id_pasien = {$id_pasien} AND id_kunjungan = {$id_kunjungan}");
		$no = 0;
			while($rows = $data->fetch_assoc()){
				$valEdit = $rows['id'] .'|'. $rows['id_ruangan'] . '|' . $rows['tanggal'] . '|' . $rows['s'] . '|'. $rows['o'] . '|'. $rows['a'] . '|'. $rows['p']. '|'. $rows['instruksi_ppa']. '|'. $rows['review_verifikasi_dpjp']. '|'. $rows['pemberi_asuhan']. '|'. $rows['id_dokter'];
				echo '<tr>';
				echo '<td>' . ++$no . '</td>';
				echo '<td>' . tanggal($rows['tanggal']) . '</td>';
				echo '<td>' . $rows['pemberi_asuhan'] . '</td>';
				echo '<td>S = ' . $rows['s'] . '<br>O = '.$rows['o']. '<br>A= ' . $rows['a'] . '<br>P = '.$rows['p'].'</td>';
				echo '<td>' . $rows['instruksi_ppa'] . '</td>';
				echo '<td>' . $rows['review_verifikasi_dpjp'] . '</td>';
				echo '<td>';
					echo '<button class="btn btn-sm btn-warning" value="'.$valEdit.'" onclick="editData(this.value)">Edit</button>';
					echo ' <button class="btn btn-sm btn-danger" value="'.$rows['id'].'" onclick="deleteDataMirm(this.value)">Delete</button>';
				echo '</td>';
				echo '</tr>';
			}
		break;
	case 'simpan-mirm':
		$sql = "INSERT INTO ppi_perkembangan_pasien_terintegrasi (
			id_ruangan,
			id_pasien,
			id_kunjungan,
			tanggal,
			s,
			o,
			a,
			p,
			instruksi_ppa,
			review_verifikasi_dpjp,
			user_id,
			tanggal_act,
			id_dokter,
			pemberi_asuhan)VALUES(
			{$ruangan},
			{$id_pasien},
			{$id_kunjungan},
			'{$tanggal}',
			'{$s}',
			'{$o}',
			'{$a}',
			'{$p}',
			'{$instruksi_ppa}',
			'{$review_verifikasi_dpjp}',
			{$userId},
			now(),
			{$id_dokter},
			'{$pemberi_asuhan}'
			)";
		$data = $konek->rawQuery($sql);
		if($data) echo json_encode(['status' => 200]);
		else echo json_encode(['status' => 500]);
		break;
	case 'edit-mirm':
		$sql = "UPDATE ppi_perkembangan_pasien_terintegrasi 
		SET id_ruangan = {$ruangan},
		tanggal = '{$tanggal}',
		s = '{$s}',
		o = '{$o}',
		a = '{$a}',
		p = '{$p}',
		instruksi_ppa = '{$instruksi_ppa}',
		review_verifikasi_dpjp = '{$review_verifikasi_dpjp}',
		user_id = {$userId},
		tanggal_act = now(),
		id_dokter = {$id_dokter},
		pemberi_asuhan = '{$pemberi_asuhan}' 
		WHERE
			id = {$id}";
		$data = $konek->rawQuery($sql);
		if($data) echo json_encode(['status' => 200]);
		else echo json_encode(['status' => 500]);
		break;
	case 'delete':
		$data = $konek->rawQuery("DELETE FROM {$namaTable} WHERE id = {$id}");
		if($data) echo json_encode(['status' => 200]);
		else echo json_encode(['status' => 500]);
		break;
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