<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="b.id DESC";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================



if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){
	$sorting=$defaultsort;
}


	$sql="SELECT b.*,peg.nama as user_log FROM lap_riw_penyakit b
	LEFT JOIN b_ms_pegawai peg ON peg.id = b.user_act WHERE b.pelayanan_id='".$_REQUEST['pelayanan_id']."' ".$filter." order by ".$sorting;



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
		$dt.=$rows["id"].chr(3).number_format($i,0,",","").	chr(3).$rows["keluhan"].chr(3).$rows["perjalanan"].chr(3).$rows["penyakit_lain"].chr(3).$rows["penyakit_dahulu"].chr(3).$rows["keadaan_umum"].chr(3).$rows["kesadaran"].chr(3).$rows["bb"].chr(3).$rows["pernafasan"].chr(3).$rows["suhu"].chr(3).$rows["kepala"].chr(3).$rows["mata"].chr(3).$rows["tht"].chr(3).$rows["gigi_mulut"].chr(3).$rows["leher"].chr(3).$rows["paru_paru"].chr(3).$rows["jantung"].chr(3).$rows["abdomen"].chr(3).$rows["extremitas"].chr(3).$rows["diagnosis_kerja"].chr(3).$rows["diagnosis_diff"].chr(3).$rows["pengobatan"].chr(3).$rows["diit"].chr(3).$rows["lab"].chr(3).$rows["radiologi"].chr(3).$rows["ekg"].chr(3).$rows["dll"].chr(3).$rows["user_log"].chr(6);
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