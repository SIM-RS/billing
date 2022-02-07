<?php
include("../koneksi/konek.php"); 
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
    header("Content-type: application/xhtml+xml");
}else {
    header("Content-type: text/xml");
}

function tanggal($tgl){
	$tanggal = explode('-', $tgl);
	return $tanggal[2] . '-' . $tanggal[1] . '-' . $tanggal[0];
}
$grd = $_REQUEST['grd'];

$sortDefault = "ORDER BY b.no_kwitansi ASC";
$page = $_REQUEST["page"];
$sorting = "";

if($_REQUEST['sorting'] != ''){
	$sorting = "ORDER BY " . $_REQUEST['sorting'];
}

$filterSql = "";
$page=$_REQUEST["page"];
$filter = "";
$tahun = "WHERE YEAR(b.tgl) = {$_REQUEST['tahun']}";
if($_REQUEST['filter'] != ''){
$filter = explode('|', mysql_real_escape_string($_REQUEST['filter']));
$filterSql = " WHERE {$filter[0]} LIKE '%{$filter[1]}%'";
$tahun = " AND YEAR(b.tgl) = {$_REQUEST['tahun']}";
}
$sql = "SELECT b.id,b.no_kwitansi,b.tgl,b.nilai,p.nama FROM b_bayar b LEFT JOIN b_kunjungan k ON k.id = b.kunjungan_id LEFT JOIN b_ms_pasien p ON p.id = k.pasien_id {$filterSql} {$tahun}";

//paginatiaon
$query = mysql_query($sql);
$jumlahData = mysql_num_rows($query);

if($page == "" || $page == 0) $page = 1;

$totalPage = ($page - 1) * $perpage;

if($jumlahData % $perpage > 0) $totalpage = floor($jumlahData / $perpage) + 1;
else $totalpage = floor($jumlahData / $perpage);

if($page > 1) $bpage = $page - 1; else $bpage = 1;
if($page < $totalpage) $npage = $page + 1; else $npage = $totalpage;

$sql = $sql . " LIMIT $totalPage,$perpage";
$query = mysql_query($sql);
$i = ($page - 1) * $perpage;

$data = $totalpage.chr(5);
 
while($rows = mysql_fetch_assoc($query)){
	$i++;
	$dataBalik = $rows['no_kwitansi'].chr(3).$rows['nama'].chr(3).tanggal($rows['tgl']).chr(3).$rows['nilai'].chr(3);

	$dataBalik .= '<button type="button" onclick="deleteData(this.value)" value="'.$rows['id'].'|'.$rows['no_kwitansi'].'"><img src="../icon/del.gif" width="16" height="16">Hapus</button>';
	
	$data .= $rows['id'].chr(3).$dataBalik.chr(6);
}

if ($data != $totalpage . chr(5)) {
	$data = substr($data, 0, strlen($data) - 1);
	// $data = str_replace('"','\"',$data);
}

echo $data;
