<?php
require '../autoload.php';

$konek = new Connection();

$no_rm = htmlspecialchars($_REQUEST['no_rm']);
$act = $_REQUEST['act'];

//INFUS
$ruangan = htmlspecialchars($_REQUEST['ruangan']);
$ipcn = htmlspecialchars($_REQUEST['ipcn']);
$pasien_id = htmlspecialchars($_REQUEST['pasien_id']);
$tanggal = htmlspecialchars($_REQUEST['tanggal']);
$jhi = htmlspecialchars($_REQUEST['jhi']);
$kp = htmlspecialchars($_REQUEST['kp']);
$jhb = htmlspecialchars($_REQUEST['jhb']);
$kd = htmlspecialchars($_REQUEST['kd']);
$operasi = htmlspecialchars($_REQUEST['operasi']);
$keterangan = htmlspecialchars($_REQUEST['keterangan']) == "" ? "-" : htmlspecialchars($_REQUEST['keterangan']);
$kateter = htmlspecialchars($_REQUEST['kateter']);
$jhc = $_REQUEST['jhc'];
$jhv = $_REQUEST['jhv'];
$angkaKejadianPlebitis = htmlspecialchars($_REQUEST['angkaKejadianPlebitis']);
$bulan = $_REQUEST['bulan'];
$tahun = $_REQUEST['tahun'];
$jenisOperasi = $_REQUEST['jenisOperasi'];
$infeksiOperasi = $_REQUEST['infeksiOperasi'];
$jumlahJenisOperasi = $_REQUEST['jumlah_jenis_operasi'];
$jumlahInfeksiOperasi = $_REQUEST['jumlah_infeksi_operasi'];
$userId = $_REQUEST['user_id'];
$irs = $_REQUEST['irs'];
$vap = $_REQUEST['vap'];
$vap_jumlah = $_REQUEST['vap_jumlah'];
$iadp = $_REQUEST['iadp'];
$jh = $_REQUEST['jh'];
$iadp_jumlah = $_REQUEST['iadp_jumlah'];
//graph form
$tahun = $_REQUEST['tahun'];
$bulanAwal = $_REQUEST['bulanAwal'];
$bulanAkhir = $_REQUEST['bulanAkhir'];
$bulan = $_REQUEST['bulan'];
$tipe = $_REQUEST['tipe'];
$kunjungan_id = $_REQUEST['id_kunjungan'];
$id = $_REQUEST['id'];
switch ($act) {
    case 'update-irs':
        $data = $konek->rawQuery("UPDATE ppi_pasien_irs SET ruangan = {$ruangan}, bulan = {$bulan}, tahun = {$tahun}, irs = {$irs} WHERE id = {$id}");
        if ($data) {
            echo json_encode(['status' => 200]);
        } else {
            echo json_encode(['status' => 500]);
        }
        break;
    case 'delete-irs':
        $data = $konek->rawQuery("DELETE FROM ppi_pasien_irs WHERE id = {$id}");
        if ($data) {
            echo json_encode(['status' => 200,'msg'=>'Berhasil hapus irs']);
        } else {
            echo json_encode(['status' => 500,'msg'=>'Gagal Hapus irs']);
        }
        break;
    case 'cari_pasien':
        $data = $konek->rawQuery("SELECT p.id,k.id as id_kunjungan,p.nama,k.tgl,k.pulang FROM rspelindo_billing.b_ms_pasien p LEFT JOIN rspelindo_billing.b_kunjungan k ON k.pasien_id = p.id WHERE p.no_rm = '{$no_rm}' AND p.cabang_id = 1");
        while($rows = $data->fetch_assoc()){
            echo '<tr>';
            echo '<td>' . $rows['nama'] . '</td>';
            echo '<td>' . tgl($rows['tgl']) . '</td>';
            echo '<td>'.($rows['pulang'] == 1 ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Tidak Aktif</span>').'</td>';
            echo '<td><button class="btn btn-success btn-sm" value="' . $rows['id'].'|'.$rows['id_kunjungan'].'|'.$rows['nama'] . '" onclick="pilihPasien(this.value)">Pilih</button></td>';
            echo '</tr>';
        }
        break;
        //Tampilkan data
    case 'tampil_pasien':
        $pasienInfus = $konek->rawQuery("SELECT p.nama,i.* FROM ppi_infus i LEFT JOIN rspelindo_billing.b_ms_pasien p ON p.id = i.pasien_id WHERE pasien_id = {$_REQUEST['id_pasien']} AND MONTH(tanggal) = {$_REQUEST['bulan']} AND YEAR(tanggal) = {$_REQUEST['tahun']} ORDER BY tanggal");
        echo '<table class="table table-sm table-striped mt-2">';
        echo '<tr>';
        echo '<th>Nama</th>';
        echo '<th>Tanggal</th>';
        echo '<th>JHI</th>';
        echo '<th>KP</th>';
        echo '<th>Action</th>';
        echo '</tr>';
        while ($rows = $pasienInfus->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $rows['nama'] . '</td>';
            echo '<td>' . tgl($rows['tanggal']) . '</td>';
            echo '<td>' . $rows['jhi'] . '</td>';
            echo '<td>' . $rows['kp'] . '</td>';
            echo '<td><button class="btn btn-warning btn-sm" value="' . $rows['id'].'|'.$rows['ruangan'].'|'.$rows['tanggal'].'|'.$rows['jhi'].'|'.$rows['kp'].'|'.$rows['angka_kejadian_plebitis'].'|'.$rows['diagnosa_ket_plg'] . '" onclick="editInfusData(this.value)"><i class="fa fa-pencil"></i> Edit</button> <button class="btn btn-danger btn-sm" value="' . $rows['id'] . '" onclick="deleteInfusData(this.value)"><i class="fa fa-trash"></i> Delete</button></td>';
            echo '</tr>';
        }
        echo '</table>';
        break;
    case 'tampil_pasien_bedres':
        $pasienInfus = $konek->rawQuery("SELECT p.nama,i.* FROM ppi_bedres i LEFT JOIN rspelindo_billing.b_ms_pasien p ON p.id = i.pasien_id WHERE pasien_id = {$_REQUEST['id_pasien']} AND MONTH(tanggal) = {$_REQUEST['bulan']} AND YEAR(tanggal) = {$_REQUEST['tahun']} ORDER BY tanggal");
        echo '<table class="table table-sm table-striped mt-2">';
        echo '<tr>';
        echo '<th>Nama</th>';
        echo '<th>Tanggal</th>';
        echo '<th>JHB</th>';
        echo '<th>KD</th>';
        echo '<th>Action</th>';
        echo '</tr>';
        while ($rows = $pasienInfus->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $rows['nama'] . '</td>';
            echo '<td>' . tgl($rows['tanggal']) . '</td>';
            echo '<td>' . $rows['jbr'] . '</td>';
            echo '<td>' . $rows['kd'] . '</td>';
            echo '<td><button class="btn btn-warning btn-sm" value="' . $rows['id'].'|'.$rows['ruangan'].'|'.$rows['tanggal'].'|'.$rows['jbr'].'|'.$rows['kd'].'|'.$rows['angka_kejadian_plebitis'].'|'.$rows['diagnosa_ket_plg'] . '" onclick="editInfusData(this.value)"><i class="fa fa-pencil"></i> Edit</button> <button class="btn btn-danger btn-sm" value="' . $rows['id'] . '" onclick="deleteInfusData(this.value)"><i class="fa fa-trash"></i> Delete</td>';
            echo '</tr>';
        }
        echo '</table>';
        break;
    case 'tampil_pasien_operasi':
        $pasienInfus = $konek->rawQuery("SELECT p.nama,i.* FROM ppi_operasi i LEFT JOIN rspelindo_billing.b_ms_pasien p ON p.id = i.pasien_id WHERE pasien_id = {$_REQUEST['id_pasien']} AND MONTH(tanggal) = {$_REQUEST['bulan']} AND YEAR(tanggal) = {$_REQUEST['tahun']} ORDER BY tanggal");
        echo '<table class="table table-sm table-striped mt-2">';
        echo '<tr>';
        echo '<th>Nama</th>';
        echo '<th>Tanggal</th>';
        echo '<th>Pemantauan Operasi</th>';
        echo '<th>Action</th>';
        echo '</tr>';
        while ($rows = $pasienInfus->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $rows['nama'] . '</td>';
            echo '<td>' . tgl($rows['tanggal']) . '</td>';
            echo '<td>' . $rows['operasi'] . '</td>';
            echo '<td><button class="btn btn-warning btn-sm" value="' . $rows['id'].'|'.$rows['ruangan'].'|'.$rows['tanggal'].'|'.$rows['operasi'].'|'.$rows['keterangan'].'" onclick="editInfusData(this.value)"><i class="fa fa-pencil"></i> Edit</button> <button class="btn btn-danger btn-sm" value="' . $rows['id'] . '" onclick="deleteInfusData(this.value)"><i class="fa fa-trash"></i> Delete</td>';
            echo '</tr>';
        }
        echo '</table>';
        break;
    case 'tampil_pasien_kateter':
        $pasienInfus = $konek->rawQuery("SELECT p.nama,i.* FROM ppi_kateter i LEFT JOIN rspelindo_billing.b_ms_pasien p ON p.id = i.pasien_id WHERE pasien_id = {$_REQUEST['id_pasien']} AND MONTH(tanggal) = {$_REQUEST['bulan']} AND YEAR(tanggal) = {$_REQUEST['tahun']} ORDER BY tanggal");
        echo '<table class="table table-sm table-striped mt-2">';
        echo '<tr>';
        echo '<th>Nama</th>';
        echo '<th>Tanggal</th>';
        echo '<th>Jumlah Hari Kateter</th>';
        echo '<th>ISK</th>';
        echo '<th>Action</th>';
        echo '</tr>';
        while ($rows = $pasienInfus->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $rows['nama'] . '</td>';
            echo '<td>' . tgl($rows['tanggal']) . '</td>';
            echo '<td>' . $rows['jhc'] . '</td>';
            echo '<td>' . $rows['kateter'] . '</td>';
            echo '<td><button class="btn btn-warning btn-sm" value="' . $rows['id'].'|'.$rows['ruangan'].'|'.$rows['tanggal'].'|'.$rows['kateter'].'|'.$rows['keterangan'].'|'.$rows['jhc'].'" onclick="editInfusData(this.value)"><i class="fa fa-pencil"></i> Edit</button> <button class="btn btn-danger btn-sm" value="' . $rows['id'] . '" onclick="deleteInfusData(this.value)"><i class="fa fa-trash"></i> Delete</td>';
            echo '</tr>';
        }
        echo '</table>';
        break;
    case 'tampil_pasien_vap':
        $pasienInfus = $konek->rawQuery("SELECT p.nama,i.* FROM ppi_vap i LEFT JOIN rspelindo_billing.b_ms_pasien p ON p.id = i.pasien_id WHERE pasien_id = {$_REQUEST['id_pasien']} AND MONTH(tanggal) = {$_REQUEST['bulan']} AND YEAR(tanggal) = {$_REQUEST['tahun']} ORDER BY tanggal");
        echo '<table class="table table-sm table-striped mt-2">';
        echo '<tr>';
        echo '<th>Nama</th>';
        echo '<th>Tanggal</th>';
        echo '<th>Jumlah Hari Vap</th>';
        echo '<th>Vap</th>';
        echo '<th>Action</th>';
        echo '</tr>';
        while ($rows = $pasienInfus->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $rows['nama'] . '</td>';
            echo '<td>' . tgl($rows['tanggal']) . '</td>';
            echo '<td>' . $rows['jhv'] . '</td>';
            echo '<td>' . $rows['vap'] . '</td>';
            echo '<td><button class="btn btn-warning btn-sm" value="' . $rows['id'].'|'.$rows['ruangan'].'|'.$rows['tanggal'].'|'.$rows['vap'].'|'.$rows['keterangan'].'|'.$rows['jhv'].'" onclick="editInfusData(this.value)"><i class="fa fa-pencil"></i> Edit</button> <button class="btn btn-danger btn-sm" value="' . $rows['id'] . '" onclick="deleteInfusData(this.value)"><i class="fa fa-trash"></i> Delete</td>';
            echo '</tr>';
        }
        echo '</table>';
        break;
    case 'tampil_pasien_iadp':
        $pasienInfus = $konek->rawQuery("SELECT p.nama,i.* FROM ppi_iadp i LEFT JOIN rspelindo_billing.b_ms_pasien p ON p.id = i.pasien_id WHERE pasien_id = {$_REQUEST['id_pasien']} AND MONTH(tanggal) = {$_REQUEST['bulan']} AND YEAR(tanggal) = {$_REQUEST['tahun']} ORDER BY tanggal");
        echo '<table class="table table-sm table-striped mt-2">';
        echo '<tr>';
        echo '<th>Nama</th>';
        echo '<th>Tanggal</th>';
        echo '<th>Jumlah Hari</th>';
        echo '<th>IADP</th>';
        echo '<th>Action</th>';
        echo '</tr>';
        while ($rows = $pasienInfus->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $rows['nama'] . '</td>';
            echo '<td>' . tgl($rows['tanggal']) . '</td>';
            echo '<td>' . $rows['jh'] . '</td>';
            echo '<td>' . $rows['iadp'] . '</td>';
            echo '<td><button class="btn btn-warning btn-sm" value="' . $rows['id'].'|'.$rows['ruangan'].'|'.$rows['tanggal'].'|'.$rows['iadp'].'|'.$rows['keterangan'].'|'.$rows['jh'].'" onclick="editInfusData(this.value)"><i class="fa fa-pencil"></i> Edit</button> <button class="btn btn-danger btn-sm" value="' . $rows['id'] . '" onclick="deleteInfusData(this.value)"><i class="fa fa-trash"></i> Delete</td>';
            echo '</tr>';
        }
        echo '</table>';
        break;
    case 'tampil_jenis_operasi':
        $pasienInfus = $konek->rawQuery("SELECT r.nama_ruangan,jp.* FROM ppi_jenis_operasi jp LEFT JOIN ppi_ruangan r ON jp.ruangan = r.id WHERE bulan = {$bulan} AND tahun = {$tahun}");
        echo '<table class="table table-sm table-striped mt-2">';
        echo '<tr>';
        echo '<th>Nama Ruangan</th>';
        echo '<th>Jenis Operasi</th>';
        echo '<th>Jumlah</th>';
        echo '<th>Bulan</th>';
        echo '<th>Tahun</th>';
        echo '<th>Action</th>';
        echo '</tr>';
        while ($rows = $pasienInfus->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $rows['nama_ruangan'] . '</td>';
            echo '<td>' . $rows['jenis_operasi'] . '</td>';
            echo '<td>' . $rows['jumlah_jenis_operasi'] . '</td>';
            echo '<td>' . $rows['bulan'] . '</td>';
            echo '<td>' . $rows['tahun'] . '</td>';
            echo '<td><button class="btn btn-danger btn-sm" value="' . $rows['id'] . '" onclick="deleteJenisData(this.value)"><i class="fa fa-trash"></i> Delete</td>';
            echo '</tr>';
        }
        echo '</table>';
        break;
    case 'tampil_infeksi_operasi':
        $pasienInfus = $konek->rawQuery("SELECT r.nama_ruangan,jp.* FROM ppi_infeksi_operasi jp LEFT JOIN ppi_ruangan r ON jp.ruangan = r.id WHERE bulan = {$bulan} AND tahun = {$tahun}");
        echo '<table class="table table-sm table-striped mt-2">';
        echo '<tr>';
        echo '<th>Nama Ruangan</th>';
        echo '<th>Infeksi Operasi</th>';
        echo '<th>Jumlah</th>';
        echo '<th>Bulan</th>';
        echo '<th>Tahun</th>';
        echo '<th>Action</th>';
        echo '</tr>';
        while ($rows = $pasienInfus->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $rows['nama_ruangan'] . '</td>';
            echo '<td>' . $rows['infeksi_operasi'] . '</td>';
            echo '<td>' . $rows['jumlah_infeksi_operasi'] . '</td>';
            echo '<td>' . $rows['bulan'] . '</td>';
            echo '<td>' . $rows['tahun'] . '</td>';
            echo '<td><button class="btn btn-danger btn-sm" value="' . $rows['id'] . '" onclick="deleteInfeksiData(this.value)"><i class="fa fa-trash"></i> Delete</td>';
            echo '</tr>';
        }
        echo '</table>';
        break;
    case 'tampil_jumlah_vap':
        $pasienInfus = $konek->rawQuery("SELECT r.nama_ruangan,jp.* FROM ppi_vap_jumlah jp LEFT JOIN ppi_ruangan r ON jp.ruangan = r.id WHERE bulan = {$bulan} AND tahun = {$tahun} AND jp.ruangan = {$ruangan}");
        echo '<table class="table table-sm table-striped mt-2">';
        echo '<tr>';
        echo '<th>Nama Ruangan</th>';
        echo '<th>Jumlah</th>';
        echo '<th>Bulan</th>';
        echo '<th>Tahun</th>';
        echo '<th>Action</th>';
        echo '</tr>';
        while ($rows = $pasienInfus->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $rows['nama_ruangan'] . '</td>';
            echo '<td>' . $rows['jumlah_vap'] . '</td>';
            echo '<td>' . $rows['bulan'] . '</td>';
            echo '<td>' . $rows['tahun'] . '</td>';
            echo '<td><button class="btn btn-danger btn-sm" value="' . $rows['id'] . '" onclick="deleteInfeksiData(this.value)"><i class="fa fa-trash"></i> Delete</td>';
            echo '</tr>';
        }
        echo '</table>';
        break;
    case 'tampil_jumlah_iadp':
        $pasienInfus = $konek->rawQuery("SELECT r.nama_ruangan,jp.* FROM ppi_pasien_irs_idp jp LEFT JOIN ppi_ruangan r ON jp.ruangan = r.id WHERE bulan = {$bulan} AND tahun = {$tahun} AND jp.ruangan = {$ruangan}");
        echo '<table class="table table-sm table-striped mt-2">';
        echo '<tr>';
        echo '<th>Nama Ruangan</th>';
        echo '<th>Jumlah</th>';
        echo '<th>Bulan</th>';
        echo '<th>Tahun</th>';
        echo '<th>Action</th>';
        echo '</tr>';
        while ($rows = $pasienInfus->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $rows['nama_ruangan'] . '</td>';
            echo '<td>' . $rows['irs'] . '</td>';
            echo '<td>' . $rows['bulan'] . '</td>';
            echo '<td>' . $rows['tahun'] . '</td>';
            echo '<td><button class="btn btn-danger btn-sm" value="' . $rows['id'] . '" onclick="deleteInfeksiData(this.value)"><i class="fa fa-trash"></i> Delete</td>';
            echo '</tr>';
        }
        echo '</table>';
        break;
    case 'tampil_jumlah_irs':
        $pasienIrs = $konek->rawQuery("SELECT id,irs,bulan,tahun FROM ppi_pasien_irs WHERE bulan = {$bulan} AND tahun = {$tahun} AND ruangan = {$ruangan}");
        while($rows = $pasienIrs->fetch_assoc()){
            $data = $rows['id'] . '|' . $rows['bulan'] . '|' . $rows['tahun'] . '|' . $rows['irs'];
            echo "<tr>";
                echo "<td>".$rows['bulan']."</td>";
                echo "<td>".$rows['tahun']."</td>";
                echo "<td>".$rows['irs']."</td>";
                echo "<td>";
                    echo "<button class='btn btn-sm btn-warning' onclick='editIrs(this.value)' value = '".$data."'>Edit</button>";
                    echo "<button class='btn btn-sm btn-danger' onclick='deleteIrs(this.value)' value = '".$rows['id']."'>Delete</button>";
                echo "<td>";
            echo "</tr>";
        }
        break;

        //Insert and update
    case 'simpan':
        $sql = "INSERT INTO ppi_infus(ruangan,ipcn,pasien_id,tanggal,jhi,kp,angka_kejadian_plebitis,diagnosa_ket_plg,user_id,tanggal_act,kunjungan_id) VALUES('{$ruangan}','{$ipcn}',{$pasien_id},'{$tanggal}',{$jhi},{$kp},'{$angkaKejadianPlebitis}','{$keterangan}',{$userId},now(),{$kunjungan_id})";
        $data = $konek->rawQuery($sql);
        if ($data) {
            echo json_encode(['status' => 200]);
        } else {
            echo json_encode(['status' => 500]);
        }
        break;
    case 'simpan-bedres':
        $sql = "INSERT INTO ppi_bedres(ruangan,ipcn,pasien_id,tanggal,jbr,kd,angka_kejadian_plebitis,diagnosa_ket_plg,user_id,tanggal_act,kunjungan_id) VALUES('{$ruangan}','{$ipcn}',{$pasien_id},'{$tanggal}',{$jhb},{$kd},'{$angkaKejadianPlebitis}','{$keterangan}',{$userId},now(),{$kunjungan_id})";
        $data = $konek->rawQuery($sql);
        if ($data) {
            echo json_encode(['status' => 200]);
        } else {
            echo json_encode(['status' => 500]);
        }
        break;
    case 'simpan-operasi':
        $sql = "INSERT INTO ppi_operasi(ruangan,pasien_id,tanggal,operasi,keterangan,user_id,tanggal_act,kunjungan_id) VALUES('{$ruangan}',{$pasien_id},'{$tanggal}',{$operasi},'{$keterangan}',{$userId},now(),{$kunjungan_id})";
        $data = $konek->rawQuery($sql);
        if ($data) {
            echo json_encode(['status' => 200]);
        } else {
            echo json_encode(['status' => 500]);
        }
        break;
    case 'simpan-kateter':
        $sql = "INSERT INTO ppi_kateter(ruangan,pasien_id,tanggal,jhc,kateter,keterangan,user_id,tanggal_act,kunjungan_id) VALUES('{$ruangan}',{$pasien_id},'{$tanggal}',{$jhc},{$kateter},'{$keterangan}',{$userId},now(),{$kunjungan_id})";
        $data = $konek->rawQuery($sql);
        if ($data) {
            echo json_encode(['status' => 200]);
        } else {
            echo json_encode(['status' => 500]);
        }
        break;
    case 'simpan-jenis-operasi':
        $sql = "INSERT INTO ppi_jenis_operasi(jumlah_jenis_operasi,jenis_operasi,bulan,tahun,user_id,tanggal_act,ruangan) VALUES({$jumlahJenisOperasi},'{$jenisOperasi}',{$bulan},{$tahun},{$userId},now(),{$ruangan})";
        $data = $konek->rawQuery($sql);
        if ($data) {
            echo json_encode(['status' => 200]);
        } else {
            echo json_encode(['status' => 500]);
        }
        break;
    case 'simpan-infeksi-operasi':
        $sql = "INSERT INTO ppi_infeksi_operasi(jumlah_infeksi_operasi,infeksi_operasi,bulan,tahun,user_id,tanggal_act,ruangan) VALUES({$jumlahInfeksiOperasi},'{$infeksiOperasi}',{$bulan},{$tahun},{$userId},now(),{$ruangan})";
        $data = $konek->rawQuery($sql);
        if ($data) {
            echo json_encode(['status' => 200]);
        } else {
            echo json_encode(['status' => 500]);
        }
        break;
    case 'simpan-irs' :
        $sql = "INSERT INTO ppi_pasien_irs(ruangan,irs,bulan,tahun,user_id,tanggal_act)VALUES({$ruangan},{$irs},{$bulan},{$tahun},{$userId},now())";
        if($konek->rawQuery($sql)) echo json_encode(['status'=> 200]);
        else echo json_encode(['status'=>500]);
        break;
    case 'simpan-irs-vap' :
        $sql = "INSERT INTO ppi_vap_jumlah(ruangan,jumlah_vap,bulan,tahun,user_id,tanggal_act)VALUES({$ruangan},{$vap_jumlah},{$bulan},{$tahun},{$userId},now())";
        if($konek->rawQuery($sql)) echo json_encode(['status'=> 200]);
        else echo json_encode(['status'=>500]);
        break;
    case 'simpan-irs-iadp' :
        $sql = "INSERT INTO ppi_pasien_irs_idp(ruangan,irs,bulan,tahun,user_id,tanggal_act)VALUES({$ruangan},{$iadp_jumlah},{$bulan},{$tahun},{$userId},now())";
        if($konek->rawQuery($sql)) echo json_encode(['status'=> 200]);
        else echo json_encode(['status'=>500]);
        break;
    case 'delete':
        $sql = "DELETE FROM ppi_infus WHERE id = {$_REQUEST['id']}";
        $data = $konek->rawQuery($sql);

        if ($data) {
            echo json_encode(['status' => 200]);
        } else {
            echo json_encode(['status' => 500]);
        }

        break;
    case 'simpan-vap':
        $sql = "INSERT INTO ppi_vap(ruangan,pasien_id,tanggal,jhv,vap,keterangan,user_id,tanggal_act,kunjungan_id) VALUES('{$ruangan}',{$pasien_id},'{$tanggal}',{$jhv},{$vap},'{$keterangan}',{$userId},now(),{$kunjungan_id})";
        $data = $konek->rawQuery($sql);
        if ($data) {
            echo json_encode(['status' => 200]);
        } else {
            echo json_encode(['status' => 500]);
        }
        break;
    case 'simpan-iadp':
        $sql = "INSERT INTO ppi_iadp(ruangan,pasien_id,tanggal,jh,iadp,keterangan,user_id,tanggal_act,kunjungan_id) VALUES('{$ruangan}',{$pasien_id},'{$tanggal}',{$jh},{$iadp},'{$keterangan}',{$userId},now(),{$kunjungan_id})";
        $data = $konek->rawQuery($sql);
        if ($data) {
            echo json_encode(['status' => 200]);
        } else {
            echo json_encode(['status' => 500]);
        }
        break;
    case 'delete-bedres':
        $sql = "DELETE FROM ppi_bedres WHERE id = {$_REQUEST['id']}";
        $data = $konek->rawQuery($sql);

        if ($data) {
            echo json_encode(['status' => 200]);
        } else {
            echo json_encode(['status' => 500]);
        }

        break;
    case 'delete-operasi':
        $sql = "DELETE FROM ppi_operasi WHERE id = {$_REQUEST['id']}";
        $data = $konek->rawQuery($sql);

        if ($data) {
            echo json_encode(['status' => 200]);
        } else {
            echo json_encode(['status' => 500]);
        }

        break;
    case 'delete-kateter':
        $sql = "DELETE FROM ppi_kateter WHERE id = {$_REQUEST['id']}";
        $data = $konek->rawQuery($sql);

        if ($data) {
            echo json_encode(['status' => 200]);
        } else {
            echo json_encode(['status' => 500]);
        }

        break;
    case 'delete-vap':
        $sql = "DELETE FROM ppi_vap WHERE id = {$_REQUEST['id']}";
        $data = $konek->rawQuery($sql);

        if ($data) {
            echo json_encode(['status' => 200]);
        } else {
            echo json_encode(['status' => 500]);
        }

        break;
    case 'delete-iadp':
        $sql = "DELETE FROM ppi_iadp WHERE id = {$_REQUEST['id']}";
        $data = $konek->rawQuery($sql);

        if ($data) {
            echo json_encode(['status' => 200]);
        } else {
            echo json_encode(['status' => 500]);
        }

        break;
    case 'delete-jenis-operasi':
        $sql = "DELETE FROM ppi_jenis_operasi WHERE id = {$_REQUEST['id']}";
        $data = $konek->rawQuery($sql);

        if ($data) {
            echo json_encode(['status' => 200]);
        } else {
            echo json_encode(['status' => 500]);
        }

        break;
    case 'delete-infeksi-operasi':
        $sql = "DELETE FROM ppi_infeksi_operasi WHERE id = {$_REQUEST['id']}";
        $data = $konek->rawQuery($sql);

        if ($data) {
            echo json_encode(['status' => 200]);
        } else {
            echo json_encode(['status' => 500]);
        }
        break;
    case 'delete-pasien-irs':
        $sql = "DELETE FROM ppi_pasien_irs WHERE id = {$_REQUEST['id']}";
        $data = $konek->rawQuery($sql);

        if($data) echo json_encode(['status'=>200]);
        else echo json_encode(['status'=>500]);
    break;
    case 'delete-jml-vap':
        $sql = "DELETE FROM ppi_vap_jumlah WHERE id = {$_REQUEST['id']}";
        $data = $konek->rawQuery($sql);

        if($data) echo json_encode(['status'=>200]);
        else echo json_encode(['status'=>500]);
    break;
    case 'delete-jml-iadp':
        $sql = "DELETE FROM ppi_pasien_irs_idp WHERE id = {$_REQUEST['id']}";
        $data = $konek->rawQuery($sql);

        if($data) echo json_encode(['status'=>200]);
        else echo json_encode(['status'=>500]);
    break;
    case 'update-plebitis':
        $sql = "UPDATE ppi_infus SET ruangan = '{$ruangan}',tanggal = '{$tanggal}',jhi = {$jhi},kp = {$kp},angka_kejadian_plebitis = '{$angkaKejadianPlebitis}',diagnosa_ket_plg = '{$keterangan}',user_id = {$userId},tanggal_act = now() WHERE id = {$_REQUEST['id']}";
        $data = $konek->rawQuery($sql);
        if ($data) {
            echo json_encode(['status' => 200]);
        } else {
            echo json_encode(['status' => 500]);
        }
    break;
    case 'update-bedres':
        $sql = "UPDATE ppi_bedres SET ruangan = '{$ruangan}',tanggal = '{$tanggal}',jbr = {$jhb},kd = {$kd},angka_kejadian_plebitis = '{$angkaKejadianPlebitis}',diagnosa_ket_plg = '{$keterangan}',user_id = {$userId},tanggal_act = now() WHERE id = {$_REQUEST['id']}";
        $data = $konek->rawQuery($sql);
        if ($data) {
            echo json_encode(['status' => 200]);
        } else {
            echo json_encode(['status' => 500]);
        }
    break;
    case 'update-kateter':
        $sql = "UPDATE ppi_kateter SET ruangan = '{$ruangan}', tanggal = '{$tanggal}', jhc = {$jhc},kateter = {$kateter}, keterangan = '{$keterangan}', user_id = {$userId}, tanggal_act = now() WHERE id = {$_REQUEST['id']}";
        $data = $konek->rawQuery($sql);
        if ($data) {
            echo json_encode(['status' => 200]);
        } else {
            echo json_encode(['status' => 500]);
        }
        break;
    case 'update-operasi':
        $sql = "UPDATE ppi_operasi SET ruangan = '{$ruangan}', tanggal = '{$tanggal}', operasi = {$operasi}, keterangan = '{$keterangan}', user_id = {$userId}, tanggal_act = now() WHERE id = {$_REQUEST['id']}";
        $data = $konek->rawQuery($sql);
        if ($data) {
            echo json_encode(['status' => 200]);
        } else {
            echo json_encode(['status' => 500]);
        }
        break;
    case 'update-vap':
        $sql = "UPDATE ppi_vap SET ruangan = '{$ruangan}', tanggal = '{$tanggal}', jhv = {$jhv},vap = {$vap}, keterangan = '{$keterangan}', user_id = {$userId}, tanggal_act = now() WHERE id = {$_REQUEST['id']}";
        $data = $konek->rawQuery($sql);
        if ($data) {
            echo json_encode(['status' => 200]);
        } else {
            echo json_encode(['status' => 500]);
        }
        break;
    case 'update-iadp':
        $sql = "UPDATE ppi_iadp SET ruangan = '{$ruangan}', tanggal = '{$tanggal}', jh = {$jh},iadp = {$iadp}, keterangan = '{$keterangan}', user_id = {$userId}, tanggal_act = now() WHERE id = {$_REQUEST['id']}";
        $data = $konek->rawQuery($sql);
        if ($data) {
            echo json_encode(['status' => 200]);
        } else {
            echo json_encode(['status' => 500]);
        }
        break;
        //grafik
    case 'graphBedres':
        if ($tipe == 1) {
            $field = "tanggal";
        } else {
            $field = "MONTH(tanggal) as tanggal";
        }
        $sql = "SELECT SUM(jbr) as jbr,SUM(kd) as kd,{$field} FROM ppi_bedres";
        if ($tipe == 1) {
            $sql .= " WHERE MONTH(tanggal) = {$bulan} AND YEAR(tanggal) = {$tahun}";
        } else if ($tipe == 2) {
            $sql .= " WHERE MONTH(tanggal) >= {$bulanAwal} AND MONTH(tanggal) <= {$bulanAkhir} AND YEAR(tanggal) = {$tahun}";
        } else if ($tipe == 3) {
            $sql .= " WHERE YEAR(tanggal) = {$tahun}";
        }
        $sql .= " GROUP BY tanggal";
        $label = [];
        $arrData = [];
        $arrData2 = [];
        $data = $konek->rawQuery($sql);
        while ($val = $data->fetch_assoc()) {
            if ($tipe == 1) {
                array_push($label, $konek->tgl($val['tanggal']));
            } else {
                array_push($label, $val['tanggal']);
            }
            array_push($arrData, $val['jbr']);
            array_push($arrData2, $val['kd']);
        }

        $arrDataBalik = ['label' => $label, 'data' => ['jbr' => $arrData, 'kd' => $arrData2], 'title' => 'JHB', 'title2' => 'KD'];

        echo json_encode($arrDataBalik);
        break;
    case 'graphInfus':
        if ($tipe == 1) {
            $field = "tanggal";
        } else {
            $field = "MONTH(tanggal) as tanggal";
        }
        $sql = "SELECT SUM(jhi) as jbr,SUM(kp) as kd,{$field} FROM ppi_infus";
        if ($tipe == 1) {
            $sql .= " WHERE MONTH(tanggal) = {$bulan} AND YEAR(tanggal) = {$tahun}";
        } else if ($tipe == 2) {
            $sql .= " WHERE MONTH(tanggal) >= {$bulanAwal} AND MONTH(tanggal) <= {$bulanAkhir} AND YEAR(tanggal) = {$tahun}";
        } else if ($tipe == 3) {
            $sql .= " WHERE YEAR(tanggal) = {$tahun}";
        }
        $sql .= " GROUP BY tanggal";
        $label = [];
        $arrData = [];
        $arrData2 = [];
        $data = $konek->rawQuery($sql);
        while ($val = $data->fetch_assoc()) {
            if ($tipe == 1) {
                array_push($label, $konek->tgl($val['tanggal']));
            } else {
                array_push($label, $val['tanggal']);
            }
            array_push($arrData, $val['jbr']);
            array_push($arrData2, $val['kd']);
        }

        $arrDataBalik = ['label' => $label, 'data' => ['jbr' => $arrData, 'kd' => $arrData2], 'title' => 'JHI', 'title2' => 'KP'];

        echo json_encode($arrDataBalik);
        break;
    case 'graphOperasi':
        if ($tipe == 1) {
            $field = "tanggal";
        } else {
            $field = "MONTH(tanggal) as tanggal";
        }
        $sql = "SELECT SUM(operasi) as operasi,{$field} FROM ppi_operasi";
        if ($tipe == 1) {
            $sql .= " WHERE MONTH(tanggal) = {$bulan} AND YEAR(tanggal) = {$tahun}";
        } else if ($tipe == 2) {
            $sql .= " WHERE MONTH(tanggal) >= {$bulanAwal} AND MONTH(tanggal) <= {$bulanAkhir} AND YEAR(tanggal) = {$tahun}";
        } else if ($tipe == 3) {
            $sql .= " WHERE YEAR(tanggal) = {$tahun}";
        }
        $sql .= " GROUP BY tanggal";
        $label = [];
        $arrData = [];
        $data = $konek->rawQuery($sql);
        while ($val = $data->fetch_assoc()) {
            if ($tipe == 1) {
                array_push($label, $konek->tgl($val['tanggal']));
            } else {
                array_push($label, $val['tanggal']);
            }
            array_push($arrData, $val['operasi']);
        }

        $arrDataBalik = ['label' => $label, 'data' => $arrData, 'title' => 'Operasi'];
        echo json_encode($arrDataBalik);
        break;
    case 'graphKateter':
        if ($tipe == 1) {
            $field = "tanggal";
        } else {
            $field = "MONTH(tanggal) as tanggal";
        }
        $sql = "SELECT SUM(kateter) as kateter,{$field} FROM ppi_kateter";
        if ($tipe == 1) {
            $sql .= " WHERE MONTH(tanggal) = {$bulan} AND YEAR(tanggal) = {$tahun}";
        } else if ($tipe == 2) {
            $sql .= " WHERE MONTH(tanggal) >= {$bulanAwal} AND MONTH(tanggal) <= {$bulanAkhir} AND YEAR(tanggal) = {$tahun}";
        } else if ($tipe == 3) {
            $sql .= " WHERE YEAR(tanggal) = {$tahun}";
        }
        $sql .= " GROUP BY tanggal";
        $label = [];
        $arrData = [];
        $data = $konek->rawQuery($sql);
        while ($val = $data->fetch_assoc()) {
            if ($tipe == 1) {
                array_push($label, $konek->tgl($val['tanggal']));
            } else {
                array_push($label, $val['tanggal']);
            }
            array_push($arrData, $val['kateter']);
        }

        $arrDataBalik = ['label' => $label, 'data' => $arrData, 'title' => 'Kateter'];
        echo json_encode($arrDataBalik);
        break;
    case 'graphVap':
        if ($tipe == 1) {
            $field = "tanggal";
        } else {
            $field = "MONTH(tanggal) as tanggal";
        }
        $sql = "SELECT SUM(vap) as vap,{$field} FROM ppi_vap";
        if ($tipe == 1) {
            $sql .= " WHERE MONTH(tanggal) = {$bulan} AND YEAR(tanggal) = {$tahun}";
        } else if ($tipe == 2) {
            $sql .= " WHERE MONTH(tanggal) >= {$bulanAwal} AND MONTH(tanggal) <= {$bulanAkhir} AND YEAR(tanggal) = {$tahun}";
        } else if ($tipe == 3) {
            $sql .= " WHERE YEAR(tanggal) = {$tahun}";
        }
        $sql .= " GROUP BY tanggal";
        $label = [];
        $arrData = [];
        $data = $konek->rawQuery($sql);
        while ($val = $data->fetch_assoc()) {
            if ($tipe == 1) {
                array_push($label, $konek->tgl($val['tanggal']));
            } else {
                array_push($label, $val['tanggal']);
            }
            array_push($arrData, $val['vap']);
        }

        $arrDataBalik = ['label' => $label, 'data' => $arrData, 'title' => 'VAP'];
        echo json_encode($arrDataBalik);
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
}

function tgl($tgl)
{
    $tanggal = explode('-', $tgl);
    return $tanggal[2] . '-' . $tanggal[1] . '-' . $tanggal[0];
}
