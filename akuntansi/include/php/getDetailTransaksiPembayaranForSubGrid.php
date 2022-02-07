<?php

include_once('../../koneksi/konek.php');

$id = $_GET['id'];

$sql = "SELECT dt.transaksi_id,ma_sak.MA_KODE AS account_code, ma_sak.MA_NAMA as account_name, 

  dt.uraian AS description,
  dt.dk,
  dt.nominal
FROM rssh_finance.transaksi_detail AS dt
  INNER JOIN rssh_finance.ma_sak AS ma_sak
    ON dt.ma_sak_id = ma_sak.MA_ID
WHERE dt.transaksi_id = {$id}
ORDER BY dt.id";
//echo $sql;
$result = mysql_query($sql);
$i = 0;
while($row = mysql_fetch_assoc($result)) {
    $response->rows[$i]['cell'] = array(
        $row['account_code'],
        $row['account_name'],
        $row['description'],
       // number_format($row['nominal'], 2, ',', '.')
       ($row['dk'] == 'd' ? number_format($row['nominal'], 2, ',', '.') : ''),
        ($row['dk'] == 'k' ? number_format($row['nominal'], 2, ',', '.') : '')
    );
            
    $i++;
}

echo json_encode($response);

?>
