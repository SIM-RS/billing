<?php

require_once '../../include/php/koneksi.php';

$id = $_GET['id'];

/* $sql = "SELECT dt.id,dt.transaksi_id,
  dt.no_bukti,
  ma_sak.MA_KODE AS account_code, 
  ma_sak.MA_NAMA as account_name, 
  dt.uraian AS description,
  dt.dk,
  u.namaunit,
  kso.nama as nama_kso,
  dt.nominal,
  dt.no_item,
  t.status
FROM rssh_finance.transaksi_detail AS dt
INNER JOIN transaksi as t on t.id=dt.transaksi_id
LEFT JOIN rssh_finance.ma_sak AS ma_sak ON dt.ma_sak_id = ma_sak.MA_ID
LEFT join rssh_admin.ms_unit u on u.idunit=dt.unit_id
LEFT join rssh_admin.ms_kso kso on kso.id=dt.kso_id
WHERE dt.transaksi_id = {$id}"; */

//penyesuaian dengan form create
$sql = "SELECT 
  dt.id,dt.transaksi_id,
  dt.no_bukti,
  ma_sak.MA_KODE AS account_code, 
  ma_sak.MA_NAMA as account_name, 
  dt.uraian AS description,
  dt.dk,
  u.namaunit,
  kso.nama as nama_kso,
  dt.nominal,
  dt.no_item,
  t.status
FROM rssh_finance.transaksi_detail AS dt
INNER JOIN transaksi as t on t.id=dt.transaksi_id
LEFT JOIN rssh_finance.ma_sak AS ma_sak ON dt.ma_sak_id = ma_sak.MA_ID
LEFT join rssh_admin.ms_unit u on u.idunit=dt.unit_id
LEFT join rssh_admin.ms_kso kso on kso.id=dt.kso_id
WHERE dt.transaksi_id = {$id} AND dt.ma_sak_id NOT IN(170,59)";

//echo $sql;
$result = mysql_query($sql);
echo mysql_error();
$i = 0;
while($row = mysql_fetch_assoc($result)) {
	$no = $i+1;
	if($row['account_name']==""){ $nama_akun = "<span style='padding:3px 15px; background:#F00'> &nbsp;</span>"; }else {$nama_akun = $row['account_name'];}
    $response->rows[$i]['cell'] = array(
		$no.".",
		$row['no_bukti'],
        $row['account_code'],
        $nama_akun,
        $row['description'],
		$row['namaunit'],
		$row['nama_kso'],
        /*($row['dk'] == 'd' ? number_format($row['nominal'], 2, ',', '.') : ''),
        ($row['dk'] == 'k' ? number_format($row['nominal'], 2, ',', '.') : ''),*/
		($row['dk'] == 'd' ? currency2($row['nominal']) : ''),
        ($row['dk'] == 'k' ? currency2($row['nominal']) : ''),
		//$button_del
    );
            
    $i++;
}

echo json_encode($response);
?>
