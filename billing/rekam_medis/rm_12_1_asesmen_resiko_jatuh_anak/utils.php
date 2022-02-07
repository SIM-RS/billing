<?php

include '../../koneksi/konek.php';
include '../function/form.php';

    date_default_timezone_set("Asia/Jakarta");
    $id_kunj = (int)$_REQUEST["id_kunjungan"];
    $sql = mysql_fetch_assoc(mysql_query("SELECT pasien_id FROM b_kunjungan WHERE id = '$id_kunj'"));
    $tgl_act = date('Y-m-d H:i:s');
    $str = ""; $all_tgl = "";
    $i = 1;
    $j = $_REQUEST['count'];

    while ($i <= $j) {
        $myData = mysql_real_escape_string($_REQUEST["check_{$i}"]);

        if ($myData == "") {
            $str .= "n";
            $str .= "|";
        } else {
            $str .= $myData;
            $str .= "|";
        }
        $i++;
    }

    for ($z=1; $z < 5; $z++) { 
        $myData = mysql_real_escape_string($_REQUEST["tgl_{$z}"]);

        if ($myData == "") {
            $all_tgl .= "n";
            $all_tgl .= "|";
        } else {
            $all_tgl .= $myData;
            $all_tgl .= "|";
        }

    }

    $data = [
        'id_pasien' => $sql['pasien_id'],
        'id_kunjungan' => mysql_real_escape_string($_REQUEST['id_kunjungan']),
        'id_pelayanan' => mysql_real_escape_string($_REQUEST['id_pelayanan']),
        'tgl_act' => date('Y-m-d H:i:s'),
        'id_user' => mysql_real_escape_string($_REQUEST["cmbDokSemua"]),
        'all_data' => $str,
        'all_tgl' => $all_tgl,

    ];

    $hasil = save($data, 'rm_12_1_resiko_jatuh_anak');

    if($hasil[0]){
        alertMessage("Berhasil memasukan data rekam medis!","index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['id_user']."&tmpLay=".$_REQUEST['tmpLay']);
    }else{
        alertMessage("Gagal memasukan data rekam medis! " . $hasil[1],"index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['idUser']."&tmpLay=".$_REQUEST['tmpLay']);
    }