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


	$sql="SELECT b.*,peg.nama as user_log, btt.nama tindakan, md.nama AS diag, IFNULL(peg.nama,'-') AS dokter, IFNULL(peg2.nama,'-') AS dr_rujuk 
	FROM lap_srt_balasan b
	LEFT JOIN b_pelayanan k 
    ON k.id = b.pelayanan_id 
  LEFT JOIN b_diagnosa diag 
    ON diag.pelayanan_id = k.id 
  LEFT JOIN b_ms_diagnosa md 
    ON md.id = diag.ms_diagnosa_id 
  LEFT JOIN b_tindakan bmt 
    ON k.id = bmt.pelayanan_id 
  LEFT JOIN b_ms_tindakan_kelas bmtk 
    ON bmtk.id = bmt.ms_tindakan_kelas_id 
  LEFT JOIN b_ms_tindakan btt 
    ON btt.id = bmtk.ms_tindakan_id 
  LEFT JOIN b_ms_pegawai peg 
    ON peg.id = b.user_act 
  LEFT JOIN b_ms_pegawai peg2 
    ON peg2.id = k.dokter_id 
	WHERE b.pelayanan_id='".$_REQUEST['pelayanan_id']."' OR k.pelayanan_id_asal = '".$_REQUEST['pelayanan_id']."' ".$filter." group by b.id order by ".$sorting;



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
		$dt.=$rows["id"]."|".$rows["pelayanan_id"].chr(3).number_format($i,0,",","").	chr(3).$rows["dr_rujuk"].chr(3).$rows["dokter"].chr(3).$rows["pemeriksaan"].chr(3).$rows["diag"].chr(3).$rows["terapi"].chr(3).$rows["tindakan"].chr(3).$rows["user_log"].chr(6);
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