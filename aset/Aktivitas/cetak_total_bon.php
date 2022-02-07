<?
include '../sesi.php';
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$defaultsort = ' k.tgl_gd desc,k.no_gd desc';

if ($filter!="") {
    $filter=explode("|",$filter);
    $filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting=="") {
    $sorting=$defaultsort;
}
$bln=gmdate('m',mktime(date('H')+7));
$thn=gmdate('Y',mktime(date('H')+7));

if($_REQUEST['bln'] and $_REQUEST['thn']<>'')$filter2=" where MONTH(k.tgl_gd)=".$_REQUEST['bln']." AND YEAR(k.tgl_gd)=".$_REQUEST['thn']; else $filter2=" where MONTH(k.tgl_gd)=$bln AND YEAR(k.tgl_gd)=$thn";


$q = "SELECT k.klr_id,k.tgl_gd AS tglkel,k.no_gd AS no_kel,k.tgl_transaksi AS tgl_transaksi,
        k.kode_transaksi AS kode_transaksi,k.nilai,l.namalokasi,u.namaunit, k.petugas_gudang, k.petugas_unit 
        FROM as_keluar k 
        INNER JOIN as_operasi o ON k.klr_id=o.klr_id 
        LEFT JOIN as_lokasi l ON l.idlokasi=k.lokasi_id 
        INNER JOIN as_ms_unit u ON u.idunit=k.unit_id
	$filter2 $filter GROUP BY k.tgl_gd,k.no_gd,k.lokasi_id ORDER BY $sorting"; //echo $q;

$s = mysql_query($q);
$total = 0;
while($d = mysql_fetch_array($s))
{
	$total+=$d['nilai'];
}
echo number_format($total,0,'.','.');
?>