<?php
include("../koneksi/konek.php");

$id = mysql_real_escape_string($_REQUEST['id']);
$id_pasien = mysql_real_escape_string($_REQUEST['id_pasien']);
$user_id = mysql_real_escape_string($_REQUEST['user_id']);
$status_cek_pcr = mysql_real_escape_string($_REQUEST['status_cek_pcr']);
$kriteria_pasien = mysql_real_escape_string($_REQUEST['kriteria_pasien']);
$tanggal_validasi = mysql_real_escape_string($_REQUEST['tanggal_validasi']);
$tanggal_terima = mysql_real_escape_string($_REQUEST['tanggal_diterima']);
$keterangan = mysql_real_escape_string($_REQUEST['keterangan']);
$id_pelayanan = mysql_real_escape_string($_REQUEST['id_pelayanan']);
$id_kunjungan = mysql_real_escape_string($_REQUEST['id_kunjungan']);

switch ($_REQUEST['act']) {
    case "update":
            $sql = "UPDATE b_hasil_pcr SET status_cek_pcr = '{$status_cek_pcr}',user_id = {$user_id},kriteria_pasien = '{$kriteria_pasien}',tanggal_validasi = '{$tanggal_validasi}',tanggal_terima = '{$tanggal_terima}',keterangan = '{$keterangan}',tanggal_act = now() WHERE id_pasien = {$id_pasien} AND id = {$id}";
            if(mysql_query($sql)){
                $dataBalik = [
                    'status' => 1,
                    'sql' => $sql,
                ];
                echo json_encode($dataBalik);
            }else{
                $dataBalik = [
                    'status' => 0
                ];
                echo json_encode($dataBalik);
            }       
        break;
    case "cekCekOut" : 
        $sqlCekPelayanan = "SELECT checkout,sudah_krs FROM b_pelayanan WHERE id = {$id_pelayanan}";
        $queryf = mysql_fetch_assoc(mysql_query($sqlCekPelayanan));
        $sqlCekKunjungan = "SELECT pulang FROM b_kunjungan WHERE id = {$id_kunjungan}";
        $queryf2 = mysql_fetch_assoc(mysql_query($sqlCekKunjungan));
        if($queryf['checkout'] == 1 && $queryf['sudah_krs'] == 1 && $queryf2['pulang'] == 1){
            $dataBalik = [
                'status' => 0,
            ];
            echo json_encode($dataBalik);
        }else{
            $dataBalik = [
                'status' => 1,
            ];
            echo json_encode($dataBalik);
        }
    default:
        // code...
        break;
}
?>