<?
include '../sesi.php';
include("../koneksi/konek.php");
$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];

//===============================
$defaultsort = 'tgl_terima desc,no_gudang desc';
if ($filter!="") {
    $filter=explode("|",$filter);
    $filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting=="") {
    $sorting=$defaultsort;
}

$bln=gmdate('m',mktime(date('H')+7));
$thn=gmdate('Y',mktime(date('H')+7));

$filter2=" where MONTH(msk.tgl_terima)=".$_REQUEST['bln']." AND YEAR(msk.tgl_terima)=".$_REQUEST['thn'];

$q = "select SUM(msk.jml_msk * msk.harga_unit) AS nilai
	from as_masuk msk left join as_po po on msk.po_id=po.id left join as_ms_rekanan rek on rek.idrekanan=po.vendor_id
	$filter2 $filter group by msk.tgl_terima,msk.no_gudang ORDER BY $sorting"; //echo $q;

$s = mysql_query($q);
$total = 0;
while($d = mysql_fetch_array($s))
{
	$total+=$d['nilai'];
}
echo number_format($total,0,",",".");
?>
