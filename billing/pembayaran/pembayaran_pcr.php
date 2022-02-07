<?php

include("../koneksi/konek.php");

$idPasien = mysql_real_escape_string($_REQUEST['id_pasien']);
$no_kwitansi = mysql_real_escape_string($_REQUEST['no_kwitansi']);
$total_pcr = mysql_real_escape_string($_REQUEST['total_pcr']);
$jumlah_uang_terima = mysql_real_escape_string($_REQUEST['jumlah_uang_terima']);
$jumlah_uang_kembali = mysql_real_escape_string($_REQUEST['jumlah_uang_kembali']);
$userId = mysql_real_escape_string($_REQUEST['user_id']);
$noUruKwitansi = mysql_real_escape_string($_REQUEST['no_urut_kwitansi']);
$id_pelayanan = mysql_real_escape_string($_REQUEST['id_pelayanan']);
$grd = $_REQUEST['grd'];
$id = mysql_real_escape_string($_REQUEST['id']);
$page = $_REQUEST["page"];
$defaultsort = "kode";
$sorting = $_REQUEST["sorting"];
$filter = $_REQUEST["filter"];

header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
    header("Content-type: application/xhtml+xml");
}else {
    header("Content-type: text/xml");
}

switch ($_REQUEST['act']) {
	case 'tambah':
		$sqlChek = mysql_query("SELECT id_pelayanan FROM b_total_biaya_pcr WHERE id_pelayanan = {$id_pelayanan}");
		if(mysql_num_rows($sqlChek) > 0){
			$dataBalik = [
				'status' => 3,
			];
			echo json_encode($dataBalik);
			return;
		}

		$sql = "INSERT INTO b_total_biaya_pcr(id_pasien,no_kwitansi,total_pcr,jumlah_uang_terima,jumlah_uang_kembali,tanggal_bayar,tanggal_act,user_id,no_urut_kwitansi,id_pelayanan,flag) VALUES({$idPasien},'{$no_kwitansi}',{$total_pcr},{$jumlah_uang_terima},{$jumlah_uang_kembali},now(),now(),{$userId},{$noUruKwitansi},{$id_pelayanan},1)";
		if(mysql_query($sql)){
			$dataBalik = [
				'status' => 1,
			];
			echo json_encode($dataBalik);
		}else{
			$dataBalik = [
				'status' => 0,
				'sql' => $sql,
			];
			echo json_encode($dataBalik);
		}
		break;
	case 'delete' :
		$sqlDelete = "DELETE FROM b_total_biaya_pcr WHERE id = ${id}";
		if(mysql_query($sqlDelete)){
			$dataBalik = [
				'status' => 1,
				'msg' => 'Berhasil menghapus data pembayaran',
			];
			echo json_encode($dataBalik);
		}else{
			$dataBalik = [
				'status' => 1,
				'msg' => 'Gagal menghapus data pembayaran',
				'sql' => $sqlDelete,
			];
			echo json_encode($dataBalik);
		}
		break;
	case 'getNoUrutKwitansi' :
		$sql = "SELECT MAX(no_urut_kwitansi) as no_kwi FROM b_total_biaya_pcr WHERE flag = 1";
		$query = mysql_query($sql);
		$sqlGetTahunAndIdTerakhir = "SELECT YEAR(tanggal_act) as tgl FROM b_total_biaya_pcr ORDER BY id desc";
		$fQ = mysql_fetch_assoc(mysql_query($sqlGetTahunAndIdTerakhir));
		if(mysql_num_rows($query) == 0){
			$dataBalik = [
				'status' => 1,
				'no_kwi' => 1,
			];
			echo json_encode($dataBalik);
		}else {
			$fetch = mysql_fetch_assoc($query);
			if($fQ['tgl'] == date('Y')){
				$dataBalik = [
					'status' => 1,
					'no_kwi' => $fetch['no_kwi'] + 1,
				];
			}else{
				$dataBalik = [
					'status' => 1,
					'no_kwi' => 1,
				];	
			}
			echo json_encode($dataBalik);
		}
		exit();
	default:
		// code...
		break;
}
//paginatiaon
$sqlGetData = "SELECT p.nama,tb.* FROM b_total_biaya_pcr tb INNER JOIN b_ms_pasien p ON p.id = tb.id_pasien WHERE tb.id_pasien = {$idPasien} AND tb.flag = 1";
$query = mysql_query($sqlGetData);
$jumlahData = mysql_num_rows($query);

if($page == "" || $page == 0) $page = 1;

$totalPage = ($page - 1) * $perpage;

if($jumlahData % $perpage > 0) $totalpage = floor($jumlahData / $perpage) + 1;
else $totalpage = floor($jumlahData / $perpage);

if($page > 1) $bpage = $page - 1; else $bpage = 1;
if($page < $totalpage) $npage = $page + 1; else $npage = $totalpage;

$sqlGetData = $sqlGetData . " LIMIT $totalPage,$perpage";
$query = mysql_query($sqlGetData);
$i = ($page - 1) * $perpage;

$data = $totalpage.chr(5);

switch ($grd) {
	case 'getData':
		while($rows = mysql_fetch_assoc($query)){
			var_dump($sqlGetData);
                $i++;
                $data .= $rows['id_pelayanan'].'|'.$rows['id'].'|'.$rows['user_id'].chr(3).$i.chr(3).$rows['nama'].chr(3).$rows['no_kwitansi'].chr(3).$rows['tanggal_bayar'].chr(3).$rows['total_pcr'].chr(3).$rows['jumlah_uang_terima'].chr(3).$rows['jumlah_uang_kembali'].chr(6);
        }

        if($data != $totalpage.chr(5)){
			$data = substr($data, 0,strlen($data) - 1);
			$data = str_replace('"', '\"', $data);
		}

		mysql_free_result($query);

		echo $data;
		break;
	
	default:
		// code...
		break;
}
?>