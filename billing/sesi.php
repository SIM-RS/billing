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
$flag = $_SESSION['flag'];

// START - cek flag jika bukan flag RS
// START - cek flag jika bukan flag RS
if ($flag !== '1') {
    switch ($flag) {
        case '0':
            $nilai_redirect = 'http://'.$_SERVER["SERVER_NAME"].'/simrs-pt';
            $pesan = 'Maaf, Anda tidak bisa masuk menggunakan akun PT..!';
            break;
        case '2':
            $nilai_redirect = 'http://'.$_SERVER["SERVER_NAME"].'/simrs-klinik-krakatau';
            $pesan = 'Maaf, Anda tidak bisa masuk menggunakan akun Klinik..!';
            break;
        case '3':
            $nilai_redirect = 'http://'.$_SERVER["SERVER_NAME"].'/simrs-apotek';
            $pesan = 'Maaf, Anda tidak bisa masuk menggunakan akun Apotek..!';
            break;
        
        default:
            # code...
            break;
    }
    echo "<script type='text/javascript'>
				alert('".$pesan."');
				window.location = '".$nilai_redirect."';
			</script>";
}
// END - cek flag jika bukan flag RS
// END - cek flag jika bukan flag RS
?>