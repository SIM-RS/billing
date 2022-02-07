<?php
include_once "./../../api/koneksi.php";
$koneksi = new Koneksi;


$grd = $_REQUEST["grd"];
// Paging,Sorting dan Filter
$page = $_REQUEST["page"];
$defaultsort = "kodepoli";
$sorting = $_REQUEST["sorting"];
$filter = $_REQUEST["filter"];
$perpage = 10;
//===============================

switch (strtolower($_REQUEST['act'])) {

    case 'simpan':
        $sqlUpdate = "UPDATE jkn_poli 
                    SET unit_id = '" . $_REQUEST['rspoli'] . "', estimasi = '" . $_REQUEST['estimasi'] . "', ket_tindakan = '" . $_REQUEST['tindakan'] . "', is_operasi = '" . $_REQUEST['is_operasi'] . "',
                    minim_hari = '" . $_REQUEST['minim_hari'] . "'
                    WHERE id = '" . $_REQUEST['id'] . "'"; 
        $rs = mysqli_query($koneksi->koneksi, $sqlUpdate);
        break;

    case 'hapus':
        $sqlHapus = "UPDATE jkn_poli 
                    SET unit_id = NULL, estimasi = NULL, ket_tindakan = NULL, is_operasi = 0, minim_hari = 0
                    WHERE id = '" . $_REQUEST['id'] . "'";
        mysqli_query($koneksi->koneksi, $sqlHapus);
        break;    
}

if ($filter != "") {
    $filter = explode("|", $filter);
    $filter = "WHERE " . $filter[0] . " LIKE '%" . $filter[1] . "%'";
}
if ($sorting == "") {
    $sorting = $defaultsort;
}

if ($grd == "true") {
    $sql = "SELECT a.id, a.kodepoli, a.namapoli, b.nama, a.estimasi, a.ket_tindakan, a.is_operasi, a.minim_hari
        FROM jkn_poli a LEFT JOIN rspelindo_billing.b_ms_unit b ON a.unit_id = b.id " . $filter . " 
        ORDER BY " . $sorting;
}



//echo $sql."<br>";
$rs = mysqli_query($koneksi->koneksi, $sql);
$jmldata = mysqli_num_rows($rs);
if ($page == "" || $page == "0") $page = 1;
$tpage = ($page - 1) * $perpage;
if (($jmldata % $perpage) > 0) $totpage = floor($jmldata / $perpage) + 1;
else $totpage = floor($jmldata / $perpage);
if ($page > 1) $bpage = $page - 1;
else $bpage = 1;
if ($page < $totpage) $npage = $page + 1;
else $npage = $totpage;
$sql = $sql . " limit $tpage,$perpage";
//echo $sql;

$rs = mysqli_query($koneksi->koneksi, $sql);
$i = ($page - 1) * $perpage;
$dt = $totpage . chr(5);

if ($grd == "true") {
    while ($rows = mysqli_fetch_assoc($rs)) {
        $i++;
        $dt .= $rows["id"] . chr(3) . number_format($i, 0, ",", "") . chr(3) . $rows["kodepoli"] . chr(3) . $rows["namapoli"] . chr(3) . $rows["nama"] . chr(3) . $rows["estimasi"] . chr(3) . $rows["ket_tindakan"] . chr(3) . ($rows["is_operasi"] ? "Ya" : "Tidak") . chr(3) . $rows["minim_hari"] . chr(6);
    }
}



if ($dt != $totpage . chr(5)) {
    $dt = substr($dt, 0, strlen($dt) - 1);
    $dt = str_replace('"', '\"', $dt);
}
mysqli_free_result($rs);
mysqli_close($koneksi->koneksi);
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
if (stristr($_SERVER["HTTP_ACCEPT"], "application/xhtml+xml")) {
    header("Content-type: application/xhtml+xml");
} else {
    header("Content-type: text/xml");
}
echo $dt;