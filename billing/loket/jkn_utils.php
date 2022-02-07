<?php
include_once "../../api/koneksi.php";

$koneksi = new Koneksi;
$data = [];
if(isset($_REQUEST['no_antrian'])){

    $no_antrian = mysqli_escape_string($koneksi->koneksi, $_REQUEST['no_antrian']);
    $query = mysqli_query($koneksi->koneksi, "SELECT a.*, b.no_rm, c.parent_id 
        FROM auth_antrian a 
        LEFT JOIN rspelindo_billing.b_ms_pasien b ON a.nik = b.no_ktp 
        LEFT JOIN rspelindo_billing.b_ms_unit c ON a.unit_id = c.id
        WHERE CONCAT(a.kodepoli, LPAD(a.no_antrian, 4, '0')) = '{$no_antrian}' 
            AND a.tanggal_periksa = DATE(NOW())");
    if(mysqli_num_rows($query)){
        $data = mysqli_fetch_assoc($query);
        echo json_encode(["status" => 200] + $data);
    }else{
        echo json_encode(["status" => 401]);
    }
    return;
}
echo json_encode(["status" => 401]);
return;