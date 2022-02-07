<?php

include '../../koneksi/konek.php';
include '../function/form.php';

    date_default_timezone_set("Asia/Jakarta");
    $id_kunj = (int)$_REQUEST["id_kunjungan"];
    $sql = mysql_fetch_assoc(mysql_query("SELECT pasien_id FROM b_kunjungan WHERE id = '$id_kunj'"));
    $tgl_act = date('Y-m-d H:i:s');
    $str = ""; $str_tgl = "";
    $i = 1;
    $j = $_REQUEST['count'];

    while ($i <= $j) {

        $myData = mysql_real_escape_string($_REQUEST["check_{$i}"]);

        if ($myData == "") {
            $str .= "0";
            $str .= "|";
        } else {
            $str .= $myData;
            $str .= "|";
        }
        
        $i++;
    }

    for ($e=1; $e < 5; $e++) { 
        $myData = mysql_real_escape_string($_REQUEST["tgl_{$e}"]);

        if ($myData == "") {
            $str_tgl .= "0";
            $str_tgl .= "|";
        } else {
            $str_tgl .= $myData;
            $str_tgl .= "|";
        }
        
    }

    $data = [
        'id_pasien' => $sql['pasien_id'],
        'id_kunjungan' => mysql_real_escape_string($_REQUEST['id_kunjungan']),
        'id_pelayanan' => mysql_real_escape_string($_REQUEST['id_pelayanan']),
        'tgl_act' => date('Y-m-d H:i:s'),
        'id_user' => mysql_real_escape_string($_REQUEST["cmbDokSemua"]),
        'all_data' => $str,
        'tgl' => $str_tgl,
    ];

    $hasil = save($data, 'rm_12_2_resiko_jatuh_geriatri');

    if($hasil[0]){
        alertMessage("Berhasil memasukan data rekam medis!","index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['id_user']."&tmpLay=".$_REQUEST['tmpLay']);
    }else{
        alertMessage("Gagal memasukan data rekam medis! " . $hasil[1],"index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['idUser']."&tmpLay=".$_REQUEST['tmpLay']);
    }