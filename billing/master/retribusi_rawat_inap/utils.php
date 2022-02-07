<?php
include '../../koneksi/konek.php';

$id = $_REQUEST['id'];
$act = $_REQUEST['act'];

$idTempatLayanan = $_REQUEST['idTempatLayanan'];
$tipe = $_REQUEST['tipe'];
$tarif = $_REQUEST['tarif'];
$active = $_REQUEST['active'];
$user_act = $_REQUEST['userAct'];

$tableName = 'b_ms_retribusi_rawat_inap';

$grd = $_REQUEST['grd'];

$page=$_REQUEST["page"];

switch($act){
    case "tambah" :
        $sqlManipulation = "INSERT INTO b_ms_retribusi_rawat_inap(tipe,tempat_layanan,nilai,aktif,user_act,tgl_act)VALUES({$tipe},{$idTempatLayanan},{$tarif},{$active},{$user_act},now())";
        $cek = mysql_query("SELECT * FROM b_ms_retribusi_rawat_inap WHERE tipe = {$tipe} AND tempat_layanan = {$idTempatLayanan} AND nilai = {$tarif}");
        if(mysql_num_rows($cek) == 0){
            mysql_query($sqlManipulation);
        }
        break;
    case "updater" :
        $sqlManipulation = "UPDATE {$tableName} SET tipe = {$tipe}, tempat_layanan = {$idTempatLayanan}, nilai = {$tarif}, aktif = {$active}, user_act = {$user_act}, tgl_act = now() WHERE id = {$id}";
        mysql_query($sqlManipulation);
        break;
    case "delete":
        $sqlManipulation = "DELETE FROM {$tableName} WHERE id = {$id}";
        mysql_query($sqlManipulation);
        break;
}

switch($grd){
    case "getData":
        $sql = "SELECT rri.*, u.nama as nama_tempat_layanan FROM {$tableName} as rri LEFT JOIN b_ms_unit u ON u.id = rri.tempat_layanan";
        break;
}

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

switch($grd){
    case "getData":
        $i = 0;
        while($rows = mysql_fetch_assoc($query)){
            if($rows['tipe'] == 1) $tipeRetribusi = "Tarif Umum";
            elseif($rows['tipe'] == 2) $tipeRetribusi = "Tarif BPJS KESEHATAN";
            else $tipeRetribusi = "Tarif Manual Pelindo";
            
            if($rows['aktif'] == 1) $aktif = "Aktif";
            else $aktif = "Tidak Aktif";

            $data .= $rows['id'] .chr(3).++$i.chr(3).$tipeRetribusi.chr(3).$rows['nama_tempat_layanan'].chr(3).$rows['nilai'].chr(3).$aktif.chr(6);
        }
        break;
}

if ($data != $totalpage.chr(5))
{
	$data = substr($data,0,strlen($data)-1);
	$data = str_replace('"','\"',$data);
}

echo $data;

?>