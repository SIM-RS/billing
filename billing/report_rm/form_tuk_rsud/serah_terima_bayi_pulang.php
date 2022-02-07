<?php

include "../../koneksi/konek.php";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUsr'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
WHERE pl.id='$idPel';";
$pasien=mysql_fetch_array(mysql_query($sqlP));

$sql = "SELECT p.nama FROM b_ms_pegawai p WHERE p.id = {$idUsr}";
$activeUser = mysql_fetch_array(mysql_query($sql));

$BASE_URL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$BASE_URL = preg_replace("/&act=.*/", "", $BASE_URL);

$action = isset($_GET['act']) ? $_GET['act'] : 'read';

require_once 'serah_terima_bayi_pulang/'.$action.'.php';

?>