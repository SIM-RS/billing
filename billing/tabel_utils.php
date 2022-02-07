<?php 
include("koneksi/konek1.php");
$grd1=$_REQUEST["grd1"];
$grd2=$_REQUEST["grd2"];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="Nama";
$defaultsort1="Nama1";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}
if ($sorting==""){
	if ($grd1=="true"){
		$sorting=$defaultsort;
	}elseif ($grd2=="true"){
		$sorting=$defaultsort1;
	}
}

if ($grd1=="true"){
	$sql="SELECT *,DATE_FORMAT(tgl,'%d/%m/%Y') AS tgl1 FROM pasien_billing".$filter." order by ".$sorting;
}elseif ($grd2=="true"){
	$sql="SELECT * FROM (SELECT NoRM NoRM1,Nama Nama1,Alamat Alamat1,Kode Kode1,KodePenjamin KodePenjamin1,Penjamin Penjamin1,dokter dokter1,KodePoli KodePoli1,Poli Poli1,DATE_FORMAT(tgl,'%d/%m/%Y') AS tgl1 FROM pasien_billing) AS t1".$filter." order by ".$sorting;
}
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
if ($grd1=="true"){
	while ($rows=mysql_fetch_array($rs)){
		$i++;
		$dt.=$rows["NoRM"].chr(3).$i.chr(3).$rows["tgl1"].chr(3).$rows["NoRM"].chr(3).$rows["Kode"].chr(3).$rows["Nama"].chr(3).$rows["Alamat"].chr(3).$rows["Penjamin"].chr(3).$rows["dokter"].chr(3).$rows["Poli"].chr(6);
	}
}elseif ($grd2=="true"){
	while ($rows=mysql_fetch_array($rs)){
		$i++;
		$dt.=$rows["NoRM1"].chr(3).number_format($i,0,",","").chr(3).$rows["tgl1"].chr(3).$rows["NoRM1"].chr(3).$rows["Kode1"].chr(3).$rows["Nama1"].chr(3).$rows["Alamat1"].chr(3).$rows["Penjamin1"].chr(3).$rows["dokter1"].chr(3).$rows["Poli1"].chr(6);
	}
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