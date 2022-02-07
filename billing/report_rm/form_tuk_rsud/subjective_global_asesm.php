<?php

include "../../koneksi/konek.php";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUsr'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit, a.BB, a.TB, bk.no_reg, IF(p.alamat <> '',CONCAT(p.alamat,' RT. ',p.rt,' RW. ',p.rw, ' Desa ',bw.nama, ' Kecamatan',wi.nama),'-') AS almt_lengkap
FROM b_pelayanan pl 
INNER JOIN b_kunjungan bk ON pl.kunjungan_id = bk.id 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
INNER JOIN b_ms_wilayah bw ON p.desa_id = bw.id
INNER JOIN b_ms_wilayah wi ON p.kec_id = wi.id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN anamnese a ON a.PEL_ID=pl.id
WHERE pl.id='$idPel'";
$pasien=mysql_fetch_array(mysql_query($sqlP));

$sql = "SELECT p.nama FROM b_ms_pegawai p WHERE p.id = {$idUsr}";
$activeUser = mysql_fetch_array(mysql_query($sql));

$BASE_URL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$BASE_URL = preg_replace("/&act=.*/", "", $BASE_URL);

$action = isset($_GET['act']) ? $_GET['act'] : 'read';

require_once 'subjective_global_asesm/'.$action.'.php';

?>