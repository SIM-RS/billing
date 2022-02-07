<?php 
session_start();
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="OBAT_NAMA";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

$iduser = $_SESSION ['userId'];
$unit_id = $_REQUEST['unit_id'];
$bulan = $_REQUEST['bulan'];
$tahun = $_REQUEST['tahun'];	

$sUnit="select * from $dbapotek.a_unit where unit_billing='".$unit_id."'";
$qUnit=mysql_query($sUnit);
$unitId=0;
if(mysql_num_rows($qUnit)>0){
	$rwUnit=mysql_fetch_array($qUnit);
	$unitId=$rwUnit['UNIT_ID'];
}

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){
	$sorting=$defaultsort;
}

$sql = "select t1.*,ake.NAMA as NAMA1 from (select ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,$dbapotek.a_unit.UNIT_NAME,am.*,date_format(am.tgl,'%d/%m/%Y') as tgl1,NAMA from $dbapotek.a_pinjam_obat am inner join $dbapotek.a_obat ao on am.obat_id=ao.OBAT_ID inner join $dbapotek.a_kepemilikan ak on am.kepemilikan_id=ak.ID Inner Join $dbapotek.a_unit ON am.unit_tujuan = a_unit.UNIT_ID where am.unit_id=$unitId and month(am.tgl)=$bulan and year(am.tgl)=$tahun) as t1 inner join $dbapotek.a_kepemilikan ake on t1.kepemilikan_id_asal=ake.ID $filter order by $sorting";

//echo $sql."<br>";
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


while ($rows=mysql_fetch_array($rs))
{	
	$i++;
	$unit_name = str_replace(' ','%20',$rows['UNIT_NAME']);
	$proses = "<img src='../icon/lihat.gif' border='0' width='16' height='16' align='absmiddle' title='Klik Untuk Melihat Detail' onclick=lihatData('$rows[no_bukti]','$unit_name','$unit_id','$iduser')>";
	
	$dt.=$id.chr(3).number_format($i,0,",","").chr(3).$rows["tgl1"].chr(3).$rows["no_bukti"].chr(3).$rows["OBAT_KODE"].chr(3).$rows["OBAT_NAMA"].chr(3).$rows["UNIT_NAME"].chr(3).$rows["OBAT_SATUAN_KECIL"].chr(3).$rows["NAMA"].chr(3).$rows["NAMA1"].chr(3).$rows["qty"].chr(3).$rows["qty_terima"].chr(3).($rows['qty']-$rows['qty_terima']).chr(3).$cstatus.chr(3).$proses.chr(6);
}


if ($dt!=$totpage.chr(5)){
	$dt=substr($dt,0,strlen($dt)-1);
	$dt=str_replace('"','\"',$dt);
}
mysql_free_result($rs);
mysql_close($konek);

header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")){
	header("Content-type: application/xhtml+xml");
}else{
	header("Content-type: text/xml");
}
echo $dt;

?>
