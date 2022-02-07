<?php
session_start();
$namaRS = $_SESSION['namaP'];
$alamatRS = $_SESSION['alamatP'];
$kode_posRS = $_SESSION['kode_posP'];
$tlpRS = $_SESSION['tlpP'];
$faxRS = $_SESSION['faxP'];
$emailRS = $_SESSION['emailP'];//echo mysql_error();
$pemkabRS = $_SESSION['pemkabP'];
$kotaRS = $_SESSION['kotaP'];
$tipe_kotaRS = $_SESSION['tipe_kotaP'];
$propinsiRS = $_SESSION['propinsiP'];

//tambahan
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>
        alert('Session anda habis atau anda belum login, silakan login ulang.');
        window.location = '/simrs-tangerang/';
        </script>";
}
?>