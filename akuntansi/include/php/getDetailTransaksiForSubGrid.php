<?php

include_once('koneksi.php');

$id = $_GET['id'];

$sql = "SELECT
  CASE dt.cc_rv_kso_pbf_umum
	WHEN 1 THEN CONCAT(ma_sak.MA_KODE, ms_unit.rc)
	WHEN 4 THEN CONCAT(ma_sak.MA_KODE, ms_supplier.Supplier_KODE)
	ELSE ma_sak.MA_KODE
  END AS account_code,
  CASE dt.cc_rv_kso_pbf_umum
	WHEN 1 THEN CONCAT(ma_sak.MA_NAMA, ' - ', ms_unit.namaunit)
	WHEN 4 THEN CONCAT(ma_sak.MA_NAMA, ' - ', ms_supplier.Supplier_NAMA)
	ELSE ma_sak.MA_NAMA
  END AS account_name,
  dt.keterangan AS description,
  dt.dk,
  dt.nominal
FROM dbkopega_finance.transaksi_pengeluaran_detail AS dt
  INNER JOIN dbkopega_finance.ma_sak AS ma_sak
    ON dt.ma_sak_id = ma_sak.MA_ID
  LEFT JOIN dbkopega_hcr.ms_unit AS ms_unit
    ON dt.id_cc_rv_kso_pbf_umum = ms_unit.idunit
  LEFT JOIN dbkopega_scm.ms_supplier AS ms_supplier
    ON dt.id_cc_rv_kso_pbf_umum = ms_supplier.Supplier_ID
WHERE dt.transaksi_pengeluaran_id = {$id}
ORDER BY dt.dk";
//echo $sql;
$result = mysql_query($sql);
$i = 0;
while($row = mysql_fetch_assoc($result)) {
    $response->rows[$i]['cell'] = array(
        $row['account_code'],
        $row['account_name'],
        $row['description'],
        ($row['dk'] == 'D' ? number_format($row['nominal'], 2, ',', '.') : ''),
        ($row['dk'] == 'K' ? number_format($row['nominal'], 2, ',', '.') : '')
    );
            
    $i++;
}

echo json_encode($response);

?>
