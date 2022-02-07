<?php
include("../../koneksi/konek.php"); 
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

$sortDefault = "ORDER BY tindakan ASC";
$sorting = "";

if($_REQUEST['sorting'] != ''){
	$sorting = "ORDER BY " . $_REQUEST['sorting'];
}

$namaTable = $_REQUEST['namaTable'];
$idPasien = $_REQUEST['idPasien'];

$filterSql = "";
$page=$_REQUEST["page"];
$filter = "";
if($_REQUEST['filter'] != ''){
$filter = explode('|', mysql_real_escape_string($_REQUEST['filter']));
$filterSql = " WHERE {$filter[0]} LIKE '%{$filter[1]}%'";
}

$sql = "SELECT
	pd.*,
	k.tgl as tanggal_kunjungan,
	p.tgl as tanggal_pelayanan,
	u.nama as nama_tempat_layanan,
	peg.nama as nama_petugas,
	pd.tgl_act as tanggal_anamnesa
FROM
	{$namaTable} pd
	LEFT JOIN b_kunjungan k ON k.id = pd.id_kunjungan
	LEFT JOIN b_pelayanan p ON p.id = pd.id_pelayanan
	LEFT JOIN b_ms_unit u ON u.id = p.unit_id
	LEFT JOIN b_ms_pegawai peg ON peg.id = pd.id_user
WHERE
	pd.id_pasien = {$idPasien}";

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
	$editData = "";
	foreach ($rows as $key => $val) {
		$editData .= $key . '|'.$val . '||';
	}

	$editData = rtrim($editData,'||');

	$dataBalik = tanggal($rows['tanggal_kunjungan']).chr(3).tanggal($rows['tanggal_pelayanan']).chr(3).tanggal($rows['tanggal_anamnesa']).chr(3).$rows['nama_tempat_layanan'].chr(3).$rows['nama_petugas'].chr(3);

    $dataBalik .= '<a style="margin:3px" href="form.php?id='.$rows['id'].'&idKunj='.$_GET['idKunj'].'&idPel='.$_GET['idPel'].'&idPasien='.$_GET['idPasien'].'&idUser='.$_GET['idUser'].'&tmpLay='.$_REQUEST['tmpLay'].'">
    <button style="margin:3px" type="button">
    <img src="../../icon/edit.gif" width="16" height="16">Edit
    </button></a>';

	$dataBalik .= '<a onclick="deleteData('.$rows['id'].')" style="margin:3px"><button type="button"><img src="../../icon/del.gif" width="16" height="16">Hapus</button></a>';
	
	$dataBalik .= '<a target="_blank" style="margin:3px" href="form.php?cetak='.$rows['id'].'&idKunj='.$_GET['idKunj'].'&idPel='.$_GET['idPel'].'&idPasien='.$_GET['idPasien'].'&idUser='.$_GET['idUser'].'&tmpLay='.$_REQUEST['tmpLay'].'"><button type="button"><img src="../../icon/printer.png" width="16" height="16">Print</button></a>';
	
	$dataBalik .= '<a target="_blank" style="margin:3px" href="form.php?pdf='.$rows['id'].'&idKunj='.$_GET['idKunj'].'&idPel='.$_GET['idPel'].'&idPasien='.$_GET['idPasien'].'&idUser='.$_GET['idUser'].'&tmpLay='.$_REQUEST['tmpLay'].'"><button type="button"><img src="../../icon/printer.png" width="16" height="16"> PDF</button></a>';


	$data .= $rows['id'].chr(3).$i.chr(3).$dataBalik.chr(6);
}

if ($data != $totalpage . chr(5)) {
	$data = substr($data, 0, strlen($data) - 1);
	// $data = str_replace('"','\"',$data);
}

echo $data;

?>