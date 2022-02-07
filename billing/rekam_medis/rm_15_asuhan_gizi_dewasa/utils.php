<?php

include '../../koneksi/konek.php';
include '../function/form.php';
 
    date_default_timezone_set("Asia/Jakarta");
    $id_kunj = (int)$_REQUEST["id_kunjungan"];
    $sql = mysql_fetch_assoc(mysql_query("SELECT pasien_id FROM b_kunjungan WHERE id = '$id_kunj'"));
    $tgl_act = date('Y-m-d H:i:s');
    $str_antro = "";
    $str_riwayat_gizi_b = "";

    for ($i=1; $i < 7; $i++) { 

        $data = mysql_real_escape_string($_REQUEST["antro_{$i}"]);

        if ($data == "") {
            $str_antro .= "n";
            $str_antro .= "|";        
        } else {
            $str_antro .= $data;
            $str_antro .= "|";
        }
    }

    for ($a=1; $a < 17; $a++) { 

        $data = mysql_real_escape_string($_REQUEST["riwayat_gizi_b_{$a}"]);

        if ($data == "") {
            $str_riwayat_gizi_b .= "n";
            $str_riwayat_gizi_b .= "|";        
        } else {
            $str_riwayat_gizi_b .= $data;
            $str_riwayat_gizi_b .= "|";
        }
    }

    $data = [
        'id_pasien' => $sql['pasien_id'],
        'id_kunjungan' => mysql_real_escape_string($_REQUEST['id_kunjungan']),
        'id_pelayanan' => mysql_real_escape_string($_REQUEST['id_pelayanan']),
        'tgl_act' => date('Y-m-d H:i:s'),
        'id_user' => mysql_real_escape_string($_REQUEST["id_user"]),
        'nama_ahli' => mysql_real_escape_string($_REQUEST["nama_ahli"]),
        'tgl' => mysql_real_escape_string($_REQUEST["tgl"]),
        'diagnosa_medis' => mysql_real_escape_string($_REQUEST["diagnosa"]),
        'antropometri' => $str_antro,
        'biokimia' => mysql_real_escape_string($_REQUEST["biokimia"]),
        'klinis' => mysql_real_escape_string($_REQUEST["klinis"]),
        'riwayat_gizi_a' => mysql_real_escape_string($_REQUEST["riwayat_gizi_a"]),
        'riwayat_gizi_b' => $str_riwayat_gizi_b,
        'riwayat_personil' => mysql_real_escape_string($_REQUEST["riwayat_personil"]),
        'diagnosis_masalah' => mysql_real_escape_string($_REQUEST["diagnosis_masalah"]),
        'intervensi_gizi' => mysql_real_escape_string($_REQUEST["intervensi_gizi"]),
        'evaluasi' => mysql_real_escape_string($_REQUEST["evaluasi"])
    ];

    $hasil = save($data, 'rm_15_asuhan_gizi_dewasa');

    if($hasil[0]){
        alertMessage("Berhasil memasukan data rekam medis!","index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['id_user']."&tmpLay=".$_REQUEST['tmpLay']);
    }else{
        alertMessage("Gagal memasukan data rekam medis! " . $hasil[1],"index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['idUser']."&tmpLay=".$_REQUEST['tmpLay']);
    }