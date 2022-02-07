<?php
include("../koneksi/konek.php");
$kode = $_REQUEST["kode"];
//============================================
//============================================	
$page=$_REQUEST["page"];
$defaultsort="idbarang";
$sort=$_REQUEST["sorting"];
$saring='';
$filter=$_REQUEST["filter"];

if ($filter != ''){
	$filter = explode('|',$filter);
	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
}

	if ($sort == ''){
	$sort = $defaultsort;
	}
if ($kode == "true"){
	$sql1="SELECT b.idbarang, b.kodebarang, b.namabarang FROM as_ms_barang b where left (kodebarang,2)=04 ".$filter." order by ".$sort."";
	}
	$perpage=100;
	$query=mysql_query($sql1);
	$jmldata=mysql_num_rows($query);
	if ($page=="" || $page=="0") $page=1;
	$tpage=($page-1)*$perpage;
	if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
	if ($page>1) $bpage=$page-1; else $bpage=1;
	if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
	$sql1=$sql1." limit $tpage,$perpage"; 
	$query=mysql_query($sql1);
	$i=($page-1)*$perpage;
    $data=$totpage.chr(5);
	if ($kode == "true"){
	while ($rows=mysql_fetch_array($query)){
	$id=$rows['idbarang']; 
	$i++;
	$data.=$id.chr(3).$i.chr(3).$rows['kodebarang'].chr(3).$rows['namabarang'].chr(6);
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