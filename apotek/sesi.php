<?php
include("koneksi/konek.php");
session_start();
//$namaRS = $_SESSION['namaP'];
$namaRS = mysqli_real_escape_string($konek,$_SESSION['namaP']);
$namaAPOTEK = 'Apotek Prima Husada Cipta Medan';
//$alamatRS = $_SESSION['alamatP'];
$alamatRS=mysqli_real_escape_string($konek,$_SESSION['alamatP']);
//$kode_posRS = $_SESSION['kode_posP'];
$kode_posRS=mysqli_real_escape_string($konek,$_SESSION['kode_posP']);
//$tlpRS = $_SESSION['tlpP'];
$tlpRS=mysqli_real_escape_string($konek,$_SESSION['tlpP']);
//$faxRS = $_SESSION['faxP'];
$faxRS=mysqli_real_escape_string($konek,$_SESSION['faxP']);
//$emailRS = $_SESSION['emailP'];//echo mysqli_error($konek);
$emailRS=mysqli_real_escape_string($konek,$_SESSION['emailP']);
//$pemkabRS = $_SESSION['pemkabP'];
$pemkabRS=mysqli_real_escape_string($konek,$_SESSION['pemkabP']);
//$kotaRS = $_SESSION['kotaP'];
$kotaRS=mysqli_real_escape_string($konek,$_SESSION['kotaP']);
//$tipe_kotaRS = $_SESSION['tipe_kotaP'];
$tipe_kotaRS=mysqli_real_escape_string($konek,$_SESSION['tipe_kotaP']);
//$propinsiRS = $_SESSION['propinsiP'];
$propinsiRS=mysqli_real_escape_string($konek,$_SESSION['propinsiP']);
?>