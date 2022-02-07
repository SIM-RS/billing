<?php

include '../../koneksi/konek.php';
include '../function/form.php';

    date_default_timezone_set("Asia/Jakarta");
    $id_kunj = (int)$_REQUEST["id_kunjungan"];
    $sql = mysql_fetch_assoc(mysql_query("SELECT pasien_id FROM b_kunjungan WHERE id = '$id_kunj'"));
    $str_slide_1 = "";
    $count_2 = $_REQUEST['count_slide_2']; $str_slide_2 = "";

    for ($o=1; $o < 11; $o++) { 
        $myData = $_REQUEST["slide_{$o}"];

        if ($myData == "") {
            $str_slide_1 .= "0";
            $str_slide_1 .= "|";
        } else {
            $str_slide_1 .= $myData;
            $str_slide_1 .= "|";
        }
    
    }

    for ($i=1; $i < $count_2; $i++) { 
        $myData = $_REQUEST["slide_2_{$i}"];

        if ($myData == "") {
            $str_slide_2 .= "0";
            $str_slide_2 .= "|";
        } else {
            $str_slide_2 .= $myData;
            $str_slide_2 .= "|";
        }
    
    }

    $data = [
        'id_pasien' => $sql['pasien_id'],
        'id_kunjungan' => mysql_real_escape_string($_REQUEST['id_kunjungan']),
        'id_pelayanan' => mysql_real_escape_string($_REQUEST['id_pelayanan']),
        'tgl_act' => date('Y-m-d H:i:s'),
        'id_user' => mysql_real_escape_string($_REQUEST["id_user"]),
        'slide_1' => $str_slide_1,
        'slide_2' => $str_slide_2
    ];

    $hasil = save($data, 'rm_18_pemeriksaan_radiologi');

    if($hasil[0]){
        alertMessage("Berhasil memasukan data rekam medis!","index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['id_user']."&tmpLay=".$_REQUEST['tmpLay']);
    }else{
        alertMessage("Gagal memasukan data rekam medis! " . $hasil[1],"index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['idUser']."&tmpLay=".$_REQUEST['tmpLay']);
    }