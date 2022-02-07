<?php

//error_reporting(E_ALL);

include_once('koneksi.php');

$result = array();

$jenisId = $_GET['jenisId'];

$sql = "SQL
    SELECT account.MA_KODE, account.MA_NAMA, detil.id_detil_trans, account.MA_ID, detil.dk, detil.id_cc_rv_kso_pbf_umum, account.cc_rv_kso_pbf_umum, unit.kodeunit, unit.namaunit, unit.rc
    FROM dbkopega_finance.detil_transaksi AS detil
    INNER JOIN dbkopega_finance.ma_sak AS account ON detil.fk_ma_sak = account.MA_ID
    LEFT JOIN dbkopega_hcr.ms_unit AS unit ON detil.id_cc_rv_kso_pbf_umum = unit.idunit
    WHERE detil.fk_jenis_trans = {$jenisId}
    ORDER BY detil.dk";

$query = mysql_query($sql);
while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
    $result[] = array(
        'account' => $row['MA_NAMA'],
        'account_code' => $row['MA_KODE'],
        'detil_transaksi_id' => $row['id_detil_trans'],
        'ma_sak_id' => $row['MA_ID'],
        'dk' => $row['dk'],
        'cc' => $row['kodeunit'] . ' - ' . $row['namaunit'],
        'cc_id' => $row['id_cc_rv_kso_pbf_umum'],
        'rc' => $row['rc'],
        'tipe_rekening' => $row['cc_rv_kso_pbf_umum']
    );
}



//$result = array(
//    array(
//        "account" => "1010 - Pembayaran Gaji",
//        'detil_transaksi_id' => 10,
//        'ma_sak_id' => 5,
//        'dk' => 'Debet',
//        'cc' => '12 - Cost'
//    ),
//    array(
//        "account" => "1111 - Pembayaran PPh",
//        'detil_transaksi_id' => 12,
//        'ma_sak_id' => 2,
//        'dk' => 'Debet',
//        'cc' => '13 - Expense'
//    )
//);

echo json_encode($result);


?>
