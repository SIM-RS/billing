<?php 
include("../koneksi/konek.php");
$page=$_REQUEST["page"];
$defaultsort="klr_id";
$sort=$_REQUEST["sorting"];
$saring='';
$filter=$_REQUEST["filter"];
//==========================================================
if($filter!=''){
$filter=explode("|",$filter);
$filter=" and " .$filter[0]." like '%".$filter[1]."%'";
} 
if($sort==''){
$sort=$defaultsort;
}
	
	$sql = "SELECT k.klr_id,  k.barang_id,  kodebarang,  namabarang,  jml_klr,  k.satuan,
   max(o.harga_satuan) as harga_satuan,sum(o.jml) as jml,sum(o.subtotal) as subtotal,  k.klr_uraian
FROM $dbaset.as_keluar k inner join $dbaset.as_operasi o on k.klr_id=o.klr_id
 INNER JOIN $dbaset.as_ms_barang b    ON k.barang_id = b.idbarang 
	WHERE tgl_transaksi='".$_REQUEST['tgl']."' AND no_gd='".$_REQUEST['no_gd']."' $filter GROUP BY k.barang_id order by $sort";
		
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
	//if ($kode == "true"){
	$total=0;
	while ($rows=mysql_fetch_array($query)){
	//$subttl=$rows['harga_satuan']*$rows['jumlah_keluar'];
	$subttl=$rows['subtotal'];
	$total = $total + $subttl;
	$id=$rows['klr_id']; 
	$i++;
	$data.=$id.chr(3).$i.chr(3).$rows['kodebarang'].chr(3).$rows['namabarang'].chr(3).$rows['satuan'].chr(3).number_format($rows['harga_satuan'],0,',','.').chr(3).$rows['jml'].chr(3).number_format($subttl,0,',','.').chr(6);
	}
	$data.=''.chr(3).''.chr(3).''.chr(3).''.chr(3).''.chr(3).''.chr(3).'Total '.chr(3).number_format($total,0,',','.').chr(6);
//}

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