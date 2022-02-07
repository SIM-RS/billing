<?php
	session_start();
	include("../koneksi/konek.php");
	/* Parameter */
	$bln = $_REQUEST['bln'];
	$thn = $_REQUEST['thn'];
	$defaultsort = "t1.id";
	$sorting = $_REQUEST["sorting"];
	$filter = $_REQUEST["filter"];
	if ($filter!="") {
        $filter=explode("|",$filter);
        $filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
    }
    if ($sorting=="") {
        $sorting=$defaultsort;
    }
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$sql = "SELECT p.tgl, DATE_FORMAT(p.tgl_setor,'%d-%m-%Y') tgl_setor, DATE_FORMAT(p.tgl_setor,'%H:%i') jam_setor,
					   k.nama, p.no_bukti, p.nilai, p.shift
				FROM k_parkir p
				INNER JOIN k_ms_kendaraan k
				   ON k.id = p.ms_kendaraan_id
				ORDER BY p.tgl, p.shift ASC, p.tgl_setor ASC";
	$query = mysql_query($sql);
	$arr = array();
	while($data = mysql_fetch_array($query)){
		$arr[$data['shift']][] = $data['tgl']."|".$data['tgl_setor']."|".$data['jam_setor']."|".$data['nama']."|".$data['no_bukti']."|".$data['nilai']."|".$data['shift'];
	}
	print_r($arr);
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Laporan Penerimaan Parkir</title>
	<style type="text/css">
		#tabelIsi td, #tabelIsi th{
			border-collapse:collapse;
		}
	</style>
</head>
<body>
	<table id="tabelIsi">
		<tr>
			td*
		</tr>
	</table>
</body>
</html>