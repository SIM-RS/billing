<?php
    include '../../koneksi/konek.php';
    include '../function/form.php';

    date_default_timezone_set("Asia/Jakarta");
    $id_kunj = (int)$_REQUEST["id_kunjungan"];
    $sql = mysql_fetch_assoc(mysql_query("SELECT pasien_id FROM b_kunjungan WHERE id = '$id_kunj'"));
    $iCount = mysql_real_escape_string($_REQUEST['i']);
    $str_1 = "";
    $str_2 = "";
    for ($i=1; $i < $iCount; $i++) { 
        $data = mysql_real_escape_string($_REQUEST["data_{$i}"]);
        if ($i > 124 && $i < 323) {
            if ($data == "") {
                $str_2 .= "#";
                $str_2 .= "|";
            } else {
                $str_2 .= $data;
                $str_2 .= "|";
            }
        } else {
            if ($data == "") {
                $str_1 .= "#";
                $str_1 .= "|";
            } else {
                $str_1 .= $data;
                $str_1 .= "|";
            }
        }
        
    }

    $data = [
        'id_pasien' => $sql['pasien_id'],
        'id_kunjungan' => mysql_real_escape_string($_REQUEST['id_kunjungan']),
        'id_pelayanan' => mysql_real_escape_string($_REQUEST['id_pelayanan']),
        'tgl_act' => date('Y-m-d H:i:s'),
        'id_user' => mysql_real_escape_string($_REQUEST["id_user"]),
        'data_rm_21_19' => $str_1,
        'data_rm_11_7' => $str_2
    ];

    $hasil = save($data, 'rm_asuhan_keperawatan_properatif');

    if($hasil[0]){
        alertMessage("Berhasil memasukan data rekam medis!","index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['id_user']."&tmpLay=".$_REQUEST['tmpLay']);
    }else{
        alertMessage("Gagal memasukan data rekam medis! " . $hasil[1],"index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['idUser']."&tmpLay=".$_REQUEST['tmpLay']);
    }