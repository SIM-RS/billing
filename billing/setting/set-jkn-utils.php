<?php
include_once "./../../api/koneksi.php";
$koneksi = new Koneksi;


$grd = $_REQUEST["grd"];
// Paging,Sorting dan Filter
$page = $_REQUEST["page"];
$defaultsort = "username";
$sorting = $_REQUEST["sorting"];
$filter = $_REQUEST["filter"];
$perpage = 10;
//===============================

switch (strtolower($_REQUEST['act'])) {
    case 'tambah':
        $sqlTambah = "INSERT INTO auth_user (username, password, expired, aktif) 
                    VALUES(
                        '" . $_REQUEST['username'] . "',
                        '" . $_REQUEST['password'] . "',
                        '" . $_REQUEST['expired'] . "',
                        '" . $_REQUEST['aktif'] . "')";
        $rs = mysqli_query($koneksi->koneksi, $sqlTambah);
        break;

    case 'simpan':
        $sqlUpdate = "UPDATE auth_user 
                    SET username = '" . $_REQUEST['username'] . "',
                        aktif = '" . $_REQUEST['aktif'] . "',
                        expired = '" . $_REQUEST['expired'] . "',
                        `password` = '" . $_REQUEST['password'] . "' 
                    WHERE id = '" . $_REQUEST['id'] . "'";
        $rs = mysqli_query($koneksi->koneksi, $sqlUpdate);
        break;

    case 'hapus':
        $sqlHapus = "DELETE FROM auth_user 
                    WHERE id = '" . $_REQUEST['rowid'] . "'";
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
    $sql = "SELECT id,
        username, `password`, expired,
        IF( aktif = 1, 'Aktif', 'Tidak') AS aktif 
        FROM auth_user " . $filter . " 
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
        $dt .= $rows["id"] . chr(3) . number_format($i, 0, ",", "") . chr(3) . $rows["username"] . chr(3) . $rows["password"] . chr(3) . $rows["expired"] . chr(3) . $rows["aktif"] . chr(6);
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
