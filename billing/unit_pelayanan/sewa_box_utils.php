<?php
include("../koneksi/konek.php");
include("../sesi.php");


function convertTgl($tgl)
{
	$tglExplode = explode('-', $tgl);
	return $tglExplode[2] . '-' . $tglExplode[1] . '-' . $tglExplode[0];
}

/*
 @var
 */
$pelayanan_id = $_REQUEST['pelayanan_id'];
$kunjungan_id = $_REQUEST['kunjungan_id'];
$id_pasien = $_REQUEST['id_pasien'];
$user_id = $_REQUEST['user_id'];
$unit_id = $_REQUEST['unitId'];
$id_tindakan = $_REQUEST['id_tindakan'];
$tgl_tindakan = $_REQUEST['tgl_tindakan']; // tgl_keluar
$inap = $_REQUEST['inap'];
$tanggal_masuk = convertTgl($_REQUEST['tgl_masuk']);
$sewaId = $_REQUEST['sewaId'];
$kelas_id = $_REQUEST['kelas_id'];
//get aksi yang ingin dilakukan
$act = $_REQUEST['act'];
//untuk menampilkan data
$grd = $_REQUEST['grd'];
$biayaRs = $_REQUEST['biaya'];
$id_sewa = $_REQUEST['idTind'];
//tanggal kerluar untuk get qty
$tgl_keluar = date_create($_REQUEST['tgl_keluar']);
//tanggal kerluar update
$tanggal_keluar = convertTgl($_REQUEST['tgl_keluar']);
$biayaKso = 0;
$kso = $_REQUEST['kso_id'];
$statusProses = "";
switch ($act) {
	case 'tambah':
		$sqlTambahSewa = "INSERT INTO b_tindakan_sewa (
							id_pelayanan,
							id_pasien,
							id_kunjungan,
							id_sewa,
							kelas_sewa,
							tanggal_masuk,
							user_id,
							tanggal_act
						)
						VALUES(
							{$pelayanan_id},
							{$id_pasien},
							{$kunjungan_id},
							{$sewaId},
							{$kelas_id},
							'{$tanggal_masuk}',
							{$user_id},
							now()
						)";
		$qTambahSewa = mysql_query($sqlTambahSewa);
		$statusProses = 'Fine';
		break;
	case 'inTagihan':
		//get data b_tindakan_sewa
		$sqlGetData = "SELECT bts.*, bmtk.tarip,bmtk.ms_kelas_id FROM 
						b_tindakan_sewa as bts
						LEFT JOIN b_ms_tindakan_kelas as bmtk ON bts.kelas_sewa = bmtk.id 
					   WHERE 
					   	bts.id = {$id_sewa} ";
		$qGetData = mysql_query($sqlGetData);
		$fGetData = mysql_fetch_assoc($qGetData);

		//get beda hari dari tanggal masuk dan tanggal keluar
		$qty = date_diff(date_create($fGetData['tanggal_masuk']),$tgl_keluar);
		$qtyHasil = explode('+', $qty->format("%R%a"));
		$qty = (int)$qtyHasil[1] == 0 ? 1 : (int)$qtyHasil[1] + 1;

		$sql = "SELECT * FROM b_kunjungan WHERE id = {$kunjungan_id}";
		$queryCekPulangPasien = mysql_query($sql);
		$fetchQueryCekPulangPasien = mysql_fetch_assoc($queryCekPulangPasien);

		if($fetchQueryCekPulangPasien['pulang'] == 1){
			$stattusProses = 'Error';
			$message = 'Pasien sudah pulang, Tidak boleh memasukan tindakan lagi';
		}else{

			//cek apakah pelayanan nay sudah ada
			$cekDokter = "SELECT * FROM b_tindakan WHERE pelayanan_id = {$pelayanan_id} AND user_id = 0";
			$queryCekDokter = mysql_query($cekDokter);

			if(mysql_num_rows($queryCekDokter) > 0){
				$stattusProses = 'Error';
			}else{

				$sqlUnit = "SELECT * FROM b_ms_unit WHERE id = {$unit_id}";
				$querySqlUnit = mysql_query($sqlUnit);
				$fetchQuerySqlUnit = mysql_fetch_assoc($querySqlUnit);

				$idParent = $fetchQuerySqlUnit['parent_id'];


				$sqlCekStatusPasien = "SELECT
									k.kso_id,
									k.kso_kelas_id,
									k.jenis_layanan,
									p.unit_id_asal,
									p.jenis_kunjungan,
									mu.inap,
									mu.parent_id,
									mu.kategori 
								FROM
									b_kunjungan k
									INNER JOIN b_pelayanan p ON k.id = p.kunjungan_id
									LEFT JOIN b_ms_unit mu ON p.unit_id_asal = mu.id 
								WHERE
									k.id = '{$kunjungan_id}' 
									AND p.id = '{$pelayanan_id}'";

				$queryCekStatusPasien = mysql_query($sqlCekStatusPasien);
				$fetchQueryCekStatusPasien = mysql_fetch_assoc($queryCekStatusPasien);

				$unitAsalInap = $fetchQueryCekStatusPasien['inap'];
				$unitAsal = $fetchQueryCekStatusPasien['unit_id_asal'];
				$ksoIdPasien = $fetchQueryCekStatusPasien['kso_id'];
				$jenisLayananAwalKunjungan = $fetchQueryCekStatusPasien['jenis_layanan'];

				// echo $kso;
				if($ksoIdPasien == 1 ){
					$biaya_pasien = $fGetData['tarip'];
					$biaya_kso = 0;
				}else{
					$biaya_kso = $fGetData['tarip'];
					$biaya_pasien = 0;
				}

				$sqlPasienAktif = "SELECT
									*
								FROM
									b_tindakan_kamar
								WHERE
									pelayanan_id = {$pelayanan_id}
									AND aktif = 0";
				$querySqlPasienAktif = mysql_query($sqlPasienAktif);
				//cek apakah status pasien sudah aktif atau belum
				if(mysql_num_rows($querySqlPasienAktif) > 0){
					//jika ada uppdate status aktif
					$sqlUpdateStatusAktif = "UPDATE
												b_tindakan_kamar
											SET 
												aktif = 1
											WHERE
												pelayanan_id = {$pelayanan_id}
												AND aktif = 0";
					$querySqlUpdateStatusAktif = mysql_query($sqlUpdateStatusAktif);
				}

				//get kelas daripada tindakan
				$sqlKelasTindakan = "SELECT ms_kelas_id FROM b_ms_tindakan_kelas WHERE id = '" . $fGetData['kelas_sewa'] . "'";

				$querySqlKelasTindakan = mysql_query($sqlKelasTindakan);
				$fetchKelasTindakan = mysql_fetch_assoc($querySqlKelasTindakan);

				$id_kelas = $fetchKelasTindakan['ms_kelas_id'];

				$sqlTindakan = "INSERT INTO b_tindakan (
										ms_tindakan_kelas_id,
										ms_tindakan_unit_id,
										jenis_kunjungan,
										pelayanan_id,
										kunjungan_id,
										kunjungan_kelas_id,
										kso_id,
										kso_kelas_id,
										kelas_id,
										tgl,
										ket,
										qty,
										biaya,
										biaya_kso,
										biaya_pasien,
										tgl_act,
										user_act,
										user_id,
										type_dokter,
										unit_act,
										exprt,
										banyak_user_id,
										ak_ms_unit_id,
										flag 
									)
									VALUES
										(
										'" . $fGetData['kelas_sewa'] . "',
										'" . $_REQUEST['unitId'] . "',
										'" . $jenisLayananAwalKunjungan . "',
										'" . $pelayanan_id . "',
										'" . $kunjungan_id . "',
										'" . $_REQUEST['kunjungan_kelas_id'] . "',
										'" . $_REQUEST['ksoId'] . "',
										'" . $fGetData['ms_kelas_id'] . "',
										'" . $_REQUEST['ksoIdKelas'] . "',
										'" . $fGetData['tanggal_masuk'] . "',
										'" . $_REQUEST['ket'] . "',
										" . $qty . ",
										'" . $fGetData['tarip'] . "',
										'".$biaya_kso."',
										'".$biaya_pasien."',
										now(),
										{$user_id},
										{$user_id},
										'" . 0 . "',
										'" . $_REQUEST['unit_pelaksana'] . "',
										'',
										'" . $_REQUEST['b_dok'] . "',
										'" . $_REQUEST['akUnit'] . "',
										1
									)";
					if(mysql_query($sqlTindakan)){				
						$queryUpdateTindakanSewa = mysql_query(
							"UPDATE b_tindakan_sewa SET tanggal_keluar = '" . $tanggal_keluar . "',status = 1 WHERE id = {$id_sewa}"
						);
					}
					
					$id_tindakan_radiologi = mysql_insert_id();
					
					$getIdTind = "SELECT MAX(id) AS id FROM b_tindakan WHERE pelayanan_id='{$pelayanan_id}' AND kunjungan_id='{$kunjungan_id}' AND user_act={$user_id}";
					// echo $getIdTind;
					$rsIdTind = mysql_query($getIdTind);
					$rwIdTind = mysql_fetch_array($rsIdTind);

					$sqlCek = "SELECT nama FROM b_ms_reference b WHERE stref=22";
					$rsCek = mysql_query($sqlCek);
					$rwCek = mysql_fetch_array($rsCek);

					if ($rwCek['nama'] == '1') {
						$tarif = ",b.tarip_prosen*" . ($biayaRS / 100);
					} else {
						$tarif = ",b.tarip";
					}
					$sqlKomponen = "INSERT INTO b_tindakan_komponen ( tindakan_id, ms_komponen_id, nama, tarip, tarip_prosen ) SELECT
											'" . $rwIdTind['id'] . "',
											k.id,
											k.nama$tarif,
											b.tarip_prosen 
											FROM
												b_ms_tindakan_komponen b
												INNER JOIN b_ms_komponen k ON b.ms_komponen_id = k.id 
											WHERE
												b.ms_tindakan_kelas_id = '" . $_REQUEST['idTind'] . "'";
					//echo $sqlKomponen."<br/>";
					$rsKomponen = mysql_query($sqlKomponen);

					$sqlDilayani = "UPDATE b_pelayanan SET dilayani=1 WHERE id='" . $pelayanan_id . "' and dilayani=0";
					$rsDilayani = mysql_query($sqlDilayani);


					$statusProses = 'Fine';
			}

		}
		break;
	case "hapus" :
		$sqlDelete = "DELETE FROM b_tindakan_sewa WHERE id = {$_REQUEST['idTind']}";
		mysql_query($sqlDelete);
		break;
	case "ubah":
		$sqlUpdateSewa = "UPDATE 
							b_tindakan_sewa 
						  SET
							id_sewa = {$sewaId},
							kelas_sewa = {$kelas_id},
							tanggal_masuk = '{$tanggal_masuk}',
							user_id = {$user_id}
						  WHERE 
						  	id = {$id_sewa}";
		$qTambahSewa = mysql_query($sqlUpdateSewa);
		if ($qTindakanSewa) {
			echo "Berhasil memasukan data";
		} else {
			echo $sqlUpdateSewa;
		}
	default:
		// echo 'Tidak ada';
		break;
}


$dataStore = [];
if ($grd == 'true') {
	$getTindakanSewa = "SELECT 
							ts.id,
							e.nama,
							ts.tanggal_masuk,
							ts.tanggal_keluar,
							k.tarip,
							ts.status,
							ts.kelas_sewa,
							ts.id_sewa
						FROM 
							b_tindakan_sewa as ts
							LEFT JOIN b_ms_tindakan as e ON ts.id_sewa = e.id
							LEFT JOIN b_ms_tindakan_kelas as k ON ts.kelas_sewa = k.id
						WHERE 
							id_pelayanan = {$pelayanan_id}
							AND id_pasien = {$id_pasien}
							AND id_kunjungan = {$kunjungan_id}";
	$qTindakanSewa = mysql_query($getTindakanSewa);
	$i = 0;
	while ($row = mysql_fetch_assoc($qTindakanSewa)) {
		array_push($dataStore, ['id' => $row['id'], 'nama' => $row['nama'], 'tanggal_masuk'=> $row['tanggal_masuk'], 'tanggal_keluar' => $row['tanggal_keluar'], 'tarip' => $row['tarip'], 'status' => $row['status'],'kelas_sewa' => $row['kelas_sewa'], 'id_sewa' => $row['id_sewa']]);
	}

	$statusProses = 'grd';
}

mysql_close($konek);
if($statusProses == 'Fine'){
	$databalik = [
		'status' => 1,
		'message' => 'Berhasil memasukan data!',
	];
	echo json_encode($databalik);
}elseif($statusProses = 'grd'){
	echo json_encode($dataStore);
}
else{
	$databalik = [
		'status' => 0,
		'message' => 'Gagal memasukan data!',
	];
	echo json_encode($databalik);
}
