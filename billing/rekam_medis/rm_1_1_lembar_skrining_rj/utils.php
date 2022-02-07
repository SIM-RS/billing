<?php

include '../../koneksi/konek.php';
include '../function/form.php';

    date_default_timezone_set("Asia/Jakarta");
    $id_kunj = (int)$_REQUEST["id_kunjungan"];
    $sql = mysql_fetch_assoc(mysql_query("SELECT pasien_id FROM b_kunjungan WHERE id = '$id_kunj'"));

    $tgl_act = date('Y-m-d H:i:s');

    $data = [
        'id_pasien' => $sql['pasien_id'],
        'id_kunjungan' => mysql_real_escape_string($_REQUEST['id_kunjungan']),
        'id_pelayanan' => mysql_real_escape_string($_REQUEST['id_pelayanan']),
        'resiko_jatuh_a' => mysql_real_escape_string($_REQUEST["resikoJatuhA"]),
        'resiko_jatuh_b' => mysql_real_escape_string($_REQUEST["resikoJatuhB"]),
        'resiko_jatuh_c' => mysql_real_escape_string($_REQUEST["resikoJatuhC"]),
        'keadaan_umum' => mysql_real_escape_string($_REQUEST["keadaanUmum"]),
        'batuk_1' => mysql_real_escape_string($_REQUEST["batukA"]),
        'batuk_2' => mysql_real_escape_string($_REQUEST["batukB"]),
        'nyeri' => mysql_real_escape_string($_REQUEST["nyeri"]),
        'numeric_scale' => mysql_real_escape_string($_REQUEST["numericScale"]),
        'tgl_act' => date('Y-m-d H:i:s'),
        'keputusan' => mysql_real_escape_string($_REQUEST["keputusan"]),
        'id_user' => mysql_real_escape_string($_REQUEST["id_user"]),
    ];

    $hasil = save($data, 'rm_1_1_lembar_skrining_rj');

    if($hasil[0]){
        alertMessage("Berhasil memasukan data rekam medis!","index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['id_user']."&tmpLay=".$_REQUEST['tmpLay']);
    }else{
        alertMessage("Gagal memasukan data rekam medis! " . $hasil[1],"index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['idUser']."&tmpLay=".$_REQUEST['tmpLay']);
    }