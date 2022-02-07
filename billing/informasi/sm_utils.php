<?php 
include("../koneksi/konek.php");
$grd1=$_REQUEST["grd1"];
//====================================================================
//Paging,Sorting dan Filter======
$norm = $_REQUEST['norm'];
$nama = $_REQUEST['nama'];
$jns = $_REQUEST['jns'];
$tmp = $_REQUEST['tmp'];
$page=$_REQUEST["page"];
$id=$_REQUEST['id'];
$status_m = $_REQUEST['status_m'];
$status=$_REQUEST['status'];
$defaultsort="tgl";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

if ($filter!="") {
    $filter=explode("|",$filter);
    $filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}
if ($sorting=="") {
    if ($grd1=="true") {
        $sorting=$defaultsort;
    }
}
$res = '';
switch($_GET['act']){
    case 'update_stat_med':
	   $sql = "update b_kunjungan set status_medik = '$status' where id = '$id'";
	   $rs = mysql_query($sql);
	   $res = mysql_affected_rows();
	   if($res > 0){
		  $res = "Update Berhasil.";
	   }
	   else if($res == 0){
		  $res = "Data tidak berubah.";
	   }
	   else{
		  $res = "Update gagal.";
	   }
	   //return;
	   break;
    default:
	   break;
}

if ($grd1=="true") {
    $tglM=explode('-',$_REQUEST['tglMsk']);
    $tglM=$tglM[2]."-".$tglM[1]."-".$tglM[0];
    $tglS=explode('-',$_REQUEST['tglSls']);
    $tglS=$tglS[2]."-".$tglS[1]."-".$tglS[0];
    if($jns == 0){
	   $fUnit = '';
    }
    else{
	   if($tmp == 0){
		  $fUnit = " and k.jenis_layanan = ".$jns." ";
	   }
	   else{
		  $fUnit = " and k.unit_id = ".$tmp." ";
	   }
    }
    if($norm == ''){
	   $norm = '';
    }
    else{
	   $norm = " and p.no_rm = '$norm' ";
    }
    if($nama == ''){
	   $nama = '';
    }
    else{
	   $nama = " and p.nama like '%$nama%' ";
    }
    if($status_m == '2'){
	   $status_m = '';
    }
    else{
	   $status_m = " and k.status_medik = '$status_m'";
    }
	$sql = "select * from (select k.id, date_format(k.tgl_act,'%d-%m-%Y %H:%i:%s') as tgl, p.no_rm, p.nama, p.alamat, u.nama as poli, kso.nama as status, if(k.status_medik=1,true,false) as status_medik,pg.nama pgw
		  from b_kunjungan k
		  inner join b_ms_pasien p on k.pasien_id = p.id
		  inner join b_ms_unit u on k.unit_id = u.id
		  inner join b_ms_kso kso on k.kso_id = kso.id
		  inner join b_ms_pegawai pg on k.user_act = pg.id
		  where k.tgl between '$tglM' and '$tglS' $fUnit $norm $nama $status_m) t1 $filter order by $sorting";
}

$sql."<br>";
$rs=mysql_query($sql);
$jmldata=mysql_num_rows($rs);
if ($page=="" || $page=="0") $page=1;
$tpage=($page-1)*$perpage;
if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
if ($page>1) $bpage=$page-1; else $bpage=1;
if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
$sql=$sql." limit $tpage,$perpage";
//echo $sql;

$rs=mysql_query($sql);
$i=($page-1)*$perpage;
$dt=$totpage.chr(5);
if ($grd1=="true") {
    while ($rows=mysql_fetch_array($rs)) {
	   $sqlIn = "select distinct nama from b_ms_unit u inner join b_pelayanan p on u.id = p.unit_id where p.kunjungan_id = '".$rows['id']."'";
	   $rsIn = mysql_query($sqlIn);
	   $tmpx = '';
	   while($rowIn = mysql_fetch_array($rsIn)){
		  $tmpx .= $rowIn['nama'].', ';
	   }
	   $tmpx = substr($tmpx,0,strlen($tmpx)-2);
        $i++;
	   //k.id, p.no_rm, p.nama, p.alamat, u.nama as poli, kso.nama as status, k.status_medik
        $dt.=$rows["id"].chr(3).number_format($i,0,',','.').chr(3).$rows['tgl'].chr(3).$rows["status_medik"].chr(3).$rows['no_rm'].chr(3).$rows["nama"].chr(3).$rows["alamat"].chr(3).$tmpx.chr(3).$rows["status"].chr(3).$rows["pgw"].chr(6);
    }
}

    if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act']);
        $dt=str_replace('"','\"',$dt);
    }
/*if ($dt!=$totpage.chr(5)) {
    $dt=substr($dt,0,strlen($dt)-1);
    $dt=str_replace('"','\"',$dt);
}*/
$temporary = explode(chr(5),$dt);
if(count($temporary)>2){
    $dt = $dt.'*|*'.$res;
}
else{
    $dt = $dt.chr(5).'*|*'.$res;
}
mysql_free_result($rs);
mysql_close($konek);
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
    header("Content-type: application/xhtml+xml");
}else {
    header("Content-type: text/xml");
}
echo $dt;
?>