<?php
include '../sesi.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>
        alert('Session anda habis atau anda belum login, silakan login ulang.');
        window.location = '/simrs-tangerang/aset/';
        </script>";
}
include '../koneksi/konek.php'; 
$kode = $_REQUEST["kode"];
//======================================================================
$page=$_REQUEST["page"];
$defaultsort="kode";
$sort=$_REQUEST["sorting"];
$saring='';
$filter=$_REQUEST["filter"];
//============================================================================
if ($filter != ''){
	$filter = explode('|',$filter);
	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
}

	if ($sort == ''){
	$sort = $defaultsort;
	}
if ($kode == "true"){
 $sql="SELECT k.id,b.idbarang,b.namabarang,k.kode,k.nilai,DATE_FORMAT(k.tgl_berlaku,'%d-%m-%Y') tgl_berlaku FROM as_kapitalisasi k INNER JOIN as_ms_barang b ON k.kode=b.kodebarang  where tipe=1 $filter order by $sort ";
	}
	
	$perpage = 100;
	$query=mysql_query($sql);
    $jmldata=mysql_num_rows($query);
	if ($page=="" || $page=="0") $page=1;
	$tpage=($page-1)*$perpage;
	if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
	if ($page>1) $bpage=$page-1; else $bpage=1;
	if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
	$sql=$sql." limit $tpage,$perpage";
	$query=mysql_query($sql);
	$i=($page-1)*$perpage;
	$data=$totpage.chr(5);
	if ($kode == "true"){
	while ($rows=mysql_fetch_array($query)){
	$id=$rows['id']."|".$rows['idbarang']; 
	$i++;
	$data.=$id.chr(3).$i.chr(3).$rows['kode'].chr(3).$rows['namabarang'].chr(3).number_format($rows['nilai'],0,',','.').chr(3).$rows['tgl_berlaku'].chr(6);
	}
}

    if ($data!=$totpage.chr(5)) {
        $data=substr($data,0,strlen($data)-1).chr(5);
        $data=str_replace('"','\"',$data);
    }
	mysql_free_result($query);
mysql_close($konek);
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
    header("Content-type: application/xhtml+xml");
}else {
    header("Content-type: text/xml");
}
echo $data;
?>