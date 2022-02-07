<?php

include '../../koneksi/konek.php';
include '../function/form.php';

    date_default_timezone_set("Asia/Jakarta");
    $id_kunj = (int)$_REQUEST["id_kunjungan"];
    $sql = mysql_fetch_assoc(mysql_query("SELECT pasien_id FROM b_kunjungan WHERE id = '$id_kunj'"));
    $tgl_act = date('Y-m-d H:i:s');
    $str_antro = ""; $str_gizi_ket = ""; $str_asupan = ""; $str_2 = "";

    for ($i=1; $i < 12; $i++) { 
        $myData = mysql_real_escape_string($_REQUEST["antro_{$i}"]);
        $str_antro .= $myData;
        $str_antro .= "|";
    }

    for ($j=1; $j < 5; $j++) { 
        $myData = mysql_real_escape_string($_REQUEST["gizi_{$j}"]);
        $str_gizi_ket .= $myData;
        $str_gizi_ket .= "|";
    }

    for ($k=1; $k < 17; $k++) { 
        $myData = mysql_real_escape_string($_REQUEST["riwayat_gizi_b_{$k}"]);
        if ($myData == "") {
            $str_asupan .= "n";
            $str_asupan .= "|";  
        } else {
            $str_asupan .= $myData;
            $str_asupan .= "|";    
        }
        
    }

    for ($l=1; $l < 4; $l++) { 
        $myData = mysql_real_escape_string($_REQUEST["slide_{$l}"]);
        if ($myData == "") {
            $str_2 .= "n";
            $str_2 .= "|";  
        } else {
            $str_2 .= $myData;
            $str_2 .= "|";    
        }
    }

    $data = [
        'id_pasien' => $sql['pasien_id'],
        'id_kunjungan' => mysql_real_escape_string($_REQUEST['id_kunjungan']),
        'id_pelayanan' => mysql_real_escape_string($_REQUEST['id_pelayanan']),
        'tgl_act' => date('Y-m-d H:i:s'),
        'id_user' => mysql_real_escape_string($_REQUEST["id_user"]),
        'tgl' => mysql_real_escape_string($_REQUEST["tgl"]),
        'diagnosa_medis' => mysql_real_escape_string($_REQUEST["diagnosa"]),
        'antropometri' => $str_antro,
        'asesmen_gizi_ket' => $str_gizi_ket,
        'asupan' => $str_asupan,
        'slide_2_datas' => $str_2,
        'nama_ahli' => mysql_real_escape_string($_REQUEST["nama_ahli"])
    ];

    $hasil = save($data, 'rm_15_1_asuhan_gizi_anak');

    if($hasil[0]){
        alertMessage("Berhasil memasukan data rekam medis!","index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['id_user']."&tmpLay=".$_REQUEST['tmpLay']);
    }else{
        alertMessage("Gagal memasukan data rekam medis! " . $hasil[1],"index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['idUser']."&tmpLay=".$_REQUEST['tmpLay']);
    }