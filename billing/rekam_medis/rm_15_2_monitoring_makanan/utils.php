<?php

include '../../koneksi/konek.php';
include '../function/form.php';

    date_default_timezone_set("Asia/Jakarta");
    $id_kunj = (int)$_REQUEST["id_kunjungan"];
    $sql = mysql_fetch_assoc(mysql_query("SELECT pasien_id FROM b_kunjungan WHERE id = '$id_kunj'"));
    $count = mysql_real_escape_string($_REQUEST["count"]);
    $str_data = "";

    for ($index = 1; $index < $count; $index++) {
        $data = mysql_real_escape_string($_REQUEST["slide1_{$index}"]);
        if ($data != "") {
            $str_data .= $data;
            $str_data .= "|";
        } else {
            $str_data .= "#";
            $str_data .= "|";
        }
    }

    $data = [
        'id_pasien' => $sql['pasien_id'],
        'id_kunjungan' => mysql_real_escape_string($_REQUEST['id_kunjungan']),
        'id_pelayanan' => mysql_real_escape_string($_REQUEST['id_pelayanan']),
        'tgl_act' => date('Y-m-d H:i:s'),
        'id_user' => mysql_real_escape_string($_REQUEST["cmbDokSemua"]),
        'data' => $str_data,
        'tgl_msk' => mysql_real_escape_string($_REQUEST["tgl_msk"]),
        'diagnosa' => mysql_real_escape_string($_REQUEST["diagnosa"]),
        'diet' => mysql_real_escape_string($_REQUEST["diet"]),
    ];

    $hasil = save($data, 'rm_15_2_monitoring_makanan');

    if($hasil[0]){
        alertMessage("Berhasil memasukan data rekam medis!","index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['id_user']."&tmpLay=".$_REQUEST['tmpLay']);
    }else{
        alertMessage("Gagal memasukan data rekam medis! " . $hasil[1],"index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['idUser']."&tmpLay=".$_REQUEST['tmpLay']);
    }