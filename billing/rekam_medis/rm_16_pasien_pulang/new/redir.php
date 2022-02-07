<?php  
include '../../function/form.php';
include '../../../koneksi/konek.php';
$checked = mysql_fetch_assoc(mysql_query("SELECT id FROM rm_16_pasien_pulang WHERE id_kunjungan = {$_REQUEST['idKunj']}"));

echo "Mohon Tunggu...";

header("Location:index.php?idKunj={$_REQUEST['idKunj']}&idPel={$_REQUEST['idPel']}&idPasien=&idUser={$_REQUEST['idUser']}&tmpLay=&id={$checked['id']}");
