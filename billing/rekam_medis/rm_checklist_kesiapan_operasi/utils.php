<?php
    include '../../koneksi/konek.php';
    include '../function/form.php';

    date_default_timezone_set("Asia/Jakarta");
    $id_kunj = (int)$_REQUEST["id_kunjungan"];
    $sql = mysql_fetch_assoc(mysql_query("SELECT pasien_id FROM b_kunjungan WHERE id = '$id_kunj'"));
    $iCount = mysql_real_escape_string($_REQUEST['i']);

    $data = [
        'id_pasien' => $sql['pasien_id'],
        'id_kunjungan' => mysql_real_escape_string($_REQUEST['id_kunjungan']),
        'id_pelayanan' => mysql_real_escape_string($_REQUEST['id_pelayanan']),
        'tgl_act' => date('Y-m-d H:i:s'),
        'id_user' => mysql_real_escape_string($_REQUEST["id_user"]),
        'signin_opsi_pertama' => mysql_real_escape_string($_REQUEST["data_1"]). "|",
        'signin_opsi_kedua' => mysql_real_escape_string($_REQUEST["data_2"]) . "|" . mysql_real_escape_string($_REQUEST["data_3"]) . "|",
        'signin_opsi_ketiga' => mysql_real_escape_string($_REQUEST["data_4"]) . "|",
        'signin_opsi_keempat' => mysql_real_escape_string($_REQUEST["data_5"]) . "|",
        'signin_opsi_kelima' => mysql_real_escape_string($_REQUEST["data_6"]) . "|" . mysql_real_escape_string($_REQUEST["data_7"]) . "|",
        'signin_opsi_keenam' => mysql_real_escape_string($_REQUEST["data_8"]) . "|" . mysql_real_escape_string($_REQUEST["data_9"]) . "|",
        'signin_opsi_ketujuh' => mysql_real_escape_string($_REQUEST["data_10"]) . "|" . mysql_real_escape_string($_REQUEST["data_11"]) . "|",
        'signin_anastesi' => mysql_real_escape_string($_REQUEST["data_12"]) . "|",
        'timeout_operator' => mysql_real_escape_string($_REQUEST["data_13"]) . "|",
        'timeout_asisten' => mysql_real_escape_string($_REQUEST["data_14"]) . "|",
        'timeout_instrument' => mysql_real_escape_string($_REQUEST["data_15"]) . "|",
        'timeout_sirkuler' => mysql_real_escape_string($_REQUEST["data_16"]) . "|",
        'timeout_prosedur' => mysql_real_escape_string($_REQUEST["data_17"]) . "|",    
        'timeout_lokasi_inisiasi' => mysql_real_escape_string($_REQUEST["data_18"]) . "|",
        'timeout_opsi_pertama' => mysql_real_escape_string($_REQUEST["data_19"]) . "|" . mysql_real_escape_string($_REQUEST["data_20"]) . "|",
        'timeout_opsi_kedua' => mysql_real_escape_string($_REQUEST["data_21"]) . "|" . mysql_real_escape_string($_REQUEST["data_22"]) . "|" . mysql_real_escape_string($_REQUEST["data_23"]) . "|",
        'timeout_opsi_ketiga' => mysql_real_escape_string($_REQUEST["data_24"]) . "|",
        'timeout_opsi_keempat' => mysql_real_escape_string($_REQUEST["data_25"]) . "|" . mysql_real_escape_string($_REQUEST["data_26"]) . "|",
        'timeout_opsi_kelima' => mysql_real_escape_string($_REQUEST["data_27"]) . "|" . mysql_real_escape_string($_REQUEST["data_28"]) . "|",
        'timeout_opsi_keenam' => mysql_real_escape_string($_REQUEST["data_29"]) . "|" . mysql_real_escape_string($_REQUEST["data_30"]) . "|",
        'timeout_perawat_sirkuaer' => mysql_real_escape_string($_REQUEST["data_31"]) . "|",
        'signout_opsi_pertama' => mysql_real_escape_string($_REQUEST["data_32"]) . "|" . mysql_real_escape_string($_REQUEST["data_33"]) . "|" . mysql_real_escape_string($_REQUEST["data_34"]) . "|" . mysql_real_escape_string($_REQUEST["data_35"]) . "|",
        'signout_opsi_kedua' => mysql_real_escape_string($_REQUEST["data_36"]) . "|" . mysql_real_escape_string($_REQUEST["data_37"])

    ];

    $hasil = save($data, 'rm_checklist_kesiapan_operasi');

    if($hasil[0]){
        alertMessage("Berhasil memasukan data rekam medis!","index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['id_user']."&tmpLay=".$_REQUEST['tmpLay']);
    }else{
        alertMessage("Gagal memasukan data rekam medis! " . $hasil[1],"index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['idUser']."&tmpLay=".$_REQUEST['tmpLay']);
    }