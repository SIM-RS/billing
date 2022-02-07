<?php

require_once '../../include/php/koneksi.php';

$id = $_GET['id'];

$sql = "SELECT dt.id,
  dt.transaksi_id,
  dt.no_bukti,
  ma_sak.MA_ID,
  ma_sak.MA_KODE as account_code, 
  ma_sak.MA_NAMA as account_name,
  ma_sak.MA_ISLAST,
  ma_sak.CC_RV_KSO_PBF_UMUM,
  dt.uraian AS description,
  dt.dk,
  u.idunit AS unit_id,
  u.namaunit,
  u.inap,
  kso.id AS kso_id,
  kso.nama as nama_kso,
  rk.idrekanan,
  rk.namarekanan,
  pu.idrekanan as per_um_id,
  pu.namarekanan as per_um,
  p.PEGAWAI_ID as id_sdm,
  p.NAMA as nama_sdm,
  dt.nominal,
  dt.no_item,
  t.status,
  dt.kelas_id
FROM rssh_finance.transaksi_detail AS dt
INNER JOIN transaksi as t on t.id=dt.transaksi_id
LEFT JOIN rssh_finance.ma_sak AS ma_sak ON dt.ma_sak_id = ma_sak.MA_ID
LEFT JOIN rssh_admin.ms_unit u on u.idunit=dt.unit_id
LEFT JOIN rssh_admin.ms_kso kso on kso.id=dt.kso_id
LEFT JOIN rssh_admin.ms_rekanan rk on rk.idrekanan=dt.pabrik_id
LEFT JOIN rssh_admin.ms_rekanan pu on pu.idrekanan=dt.pbf_umum_id
LEFT JOIN rssh_hcr.pegawai as p on p.PEGAWAI_ID=dt.sdm_id
WHERE dt.transaksi_id = {$id}";
//echo $sql;
$result = mysql_query($sql);
$i = 0;
while($row = mysql_fetch_assoc($result)) {
	$deskripsi = replace_single_quote($row['description']);
	if($row['account_name']=="")
	{ 
		$nama_akun = "<span style='padding:3px 15px; background:#F00'> &nbsp;</span>"; 
	}
	else 
	{
		if($row['MA_ISLAST']=="0")
		{
			$nama_akun = "<span style='padding:3px 15px; background:#F90'>".$row['account_name']."</span>";
		}
		else
		{
			$nama_akun = $row['account_name'];
		}
	}
	$no = $i+1;
    $response->rows[$i]['cell'] = array(
		$no.".",
		$row['no_bukti'],
        "<button type='button' lang='$row[id]|$row[account_name]|$row[account_code]|$row[MA_ID]|$deskripsi|$row[kso_id]|$row[nama_kso]|$row[unit_id]|$row[namaunit]|$row[idrekanan]|$row[namarekanan]|$row[id_sdm]|$row[nama_sdm]|$row[kelas_id]|$row[CC_RV_KSO_PBF_UMUM]|$row[inap]|$row[per_um_id]|$row[per_um]' style='font:10px;' onclick='ganti_akun(this.lang)'>v</button> ".$row['account_code']."",
        $nama_akun,
        $row['description'],
		($row['dk'] == 'd' ? currency2($row['nominal']) : ''),
        ($row['dk'] == 'k' ? currency2($row['nominal']) : ''),
		$row['namaunit'],
		$row['nama_kso'],
		($row['namarekanan']!="") ? $row['namarekanan'] : $row['per_um'],
		$row['nama_sdm'],
    );
            
    $i++;
}

echo json_encode($response);

?>
