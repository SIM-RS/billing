<?php
include '../koneksi/konek.php';

$id = $_REQUEST['id'];
$no_kwitansi = mysql_real_escape_string($_REQUEST['no_kwitansi']);
$sql = "DELETE FROM b_bayar WHERE id = {$id} AND no_kwitansi = '{$no_kwitansi}'";
if(mysql_query($sql)) echo json_encode(['status'=>'1']);
else echo json_encode(['status'=>'0']);

?>