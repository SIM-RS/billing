<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//QueryString===============================================
$id = $_REQUEST['id'];
$unit_id = $_REQUEST['unit_id'];
$tanggal = explode('-',$_REQUEST['tanggal']);
$tanggal = $tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0];

$sampai = explode('-',$_REQUEST['sampai']);
$sampai = $sampai[2].'-'.$sampai[1].'-'.$sampai[0];
//=====================================

if ($filter!=""){
	$filter=explode("|",$filter);
	if($filter[0] == 'jam')
		$filter = "and mulai like '%".$filter[1]."%' or selesai like '%{$filter[1]}%'";
	else
		$filter = " and ".$filter[0]." like '%".$filter[1]."%'";
}
if ($sorting=="")
	$sorting="mulai";

$sql="select *
		from (select jd.id, DATE_FORMAT(jd.tgl,'%d-%m-%Y') tgl, time_format(jd.mulai,'%H:%i') mulai, 
			  time_format(jd.selesai,'%H:%i') selesai, p.nip, p.nama 
			from b_jadwal_dokter jd 
			  inner join b_ms_unit u on jd.unit_id = u.id 
			  inner join b_ms_pegawai p on jd.dokter_id = p.id 
			where u.aktif = 1 
			  and p.aktif = 1 
			  and p.spesialisasi_id != 0
			  and jd.unit_id = {$unit_id}
			  and jd.tgl between '{$tanggal}' and '{$sampai}') t1
	where 0=0 {$filter}
	order by ".$sorting;
// echo $sql;
$rs=mysql_query($sql);
$jmldata=mysql_num_rows($rs);
if ($page=="" || $page=="0") $page=1;
$tpage=($page-1)*$perpage;
if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
if ($page>1) $bpage=$page-1; else $bpage=1;
if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
$sql=$sql." limit $tpage,$perpage";

$rs=mysql_query($sql);
$i=($page-1)*$perpage;
$dt=$totpage.chr(5);


while ($rows=mysql_fetch_array($rs)){
	$i++;
	$dt.=$rows["id"].chr(3).$i.chr(3).$rows["tgl"].chr(3).$rows["mulai"]." - ".$rows["selesai"].chr(3).$rows["nama"].chr(3).$rows["nip"].chr(6);
}

if ($dt!=$totpage.chr(5)){
		$dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act']);
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
