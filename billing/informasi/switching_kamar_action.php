<?php 
    include("../koneksi/konek.php");
    include("../sesi.php");
    
    $idkamarpilihan = $_POST['id_kamar_pilihan'];
    $listKamarTujuan = $_POST['listKamarTujuan'];
    $jumlahbedpindah = $_POST['jumlahbedpindah'];

    $update1 = mysql_query("UPDATE b_ms_kamar SET jumlah_tt = (jumlah_tt - $jumlahbedpindah) WHERE id = $idkamarpilihan");
    $update2 = mysql_query("UPDATE b_ms_kamar SET jumlah_tt = (jumlah_tt + $jumlahbedpindah) WHERE id = $listKamarTujuan");

    // == insert history
    $getKamarSumber = mysql_fetch_array(mysql_query("SELECT kmr.nama, unit.nama as namaunit FROM b_ms_kamar kmr JOIN b_ms_unit unit ON unit.id = kmr.unit_id WHERE kmr.id = $idkamarpilihan"));
    $getKamarTujuan = mysql_fetch_array(mysql_query("SELECT kmr.nama, unit.nama as namaunit FROM b_ms_kamar kmr JOIN b_ms_unit unit ON unit.id = kmr.unit_id WHERE kmr.id = $listKamarTujuan"));
    $keterangan = $getKamarSumber['namaunit']." - ".$getKamarSumber['nama']." telah di pindahkan sebanyak ".$jumlahbedpindah." bed ke ".$getKamarTujuan['namaunit']." - ".$getKamarTujuan['nama'];
    $user_id = $_SESSION['user_id'];
    $tanggal = gmdate('Y-m-d H:i:s', mktime(date('H') + 7));

    mysql_query("INSERT INTO switching_history(keterangan, user_id, tanggal) VALUES('$keterangan', $user_id, '$tanggal')");

    if ($update1 && $update2) {
        header("location:switching_kamar.php?msg=success");
    } else {
        header("location:switching_kamar.php?msg=error");
    }
?>