<?php
include("../../koneksi/konek.php");

$nama = mysql_real_escape_string($_REQUEST['nama']);
$link = mysql_real_escape_string($_REQUEST['link']);
$id_unit = $_REQUEST['id_unit'];
$id_rm = $_REQUEST['id_rm'];

$act = $_REQUEST['action'];
switch ($act) {
    case "tambah":
        $sql = "INSERT INTO b_ms_rekam_medis(nama_rm,link,active)VALUES('{$nama}','{$link}',1)";
        if (mysql_query($sql)) {
            $dataBalik = [
                'status' => 1,
                'msg' => 'Berhasil memasukan data',
            ];
            echo json_encode($dataBalik);
        } else {
            $dataBalik = [
                'status' => 0,
                'msg' => 'Gagal memasukan data',
            ];
            echo json_encode($dataBalik);
        }
        break;
    case "updateData":
        $sql = "UPDATE b_ms_rekam_medis set nama_rm = '{$nama}', link = '{$link}' WHERE id = {$id_rm}";
        if (mysql_query($sql)) {
            $dataBalik = [
                'status' => 1,
                'msg' => 'Berhasil update data',
            ];
            echo json_encode($dataBalik);
        } else {
            $dataBalik = [
                'status' => 0,
                'msg' => 'Gagal update data',
            ];
            echo json_encode($dataBalik);
        }
        break;
    case "deleteRm":
        $sql = "DELETE FROM b_ms_rekam_medis WHERE id = {$id_rm}";
        if (mysql_query($sql)) {
            $dataBalik = [
                'status' => 1,
                'msg' => 'Berhasil hapus data',
            ];
            echo json_encode($dataBalik);
        } else {
            $dataBalik = [
                'status' => 0,
                'msg' => 'Gagal hapus data',
            ];
            echo json_encode($dataBalik);
        }
        break;
    case "tambahRmUnit":
        $sql = "INSERT INTO b_ms_rm_unit(id_rm,id_unit)VALUES({$id_rm},{$id_unit})";
        if (mysql_query($sql)) {
            $dataBalik = [
                'status' => 1,
                'msg' => 'Berhasil memasukan data',
            ];
            echo json_encode($dataBalik);
        } else {
            $dataBalik = [
                'status' => 0,
                'msg' => 'Gagal memasukan data',
            ];
            echo json_encode($dataBalik);
        }
    break;
    case "deleteRmUnit":
        $sql = "DELETE FROM b_ms_rm_unit WHERE id_rm = {$id_rm} AND id_unit = {$id_unit}";
        if (mysql_query($sql)) {
            $dataBalik = [
                'status' => 1,
                'msg' => 'Berhasil remove data',
            ];
            echo json_encode($dataBalik);
        } else {
            $dataBalik = [
                'status' => 0,
                'msg' => 'Gagal remove data',
            ];
            echo json_encode($dataBalik);
        }
        break;
}
