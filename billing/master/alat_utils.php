<?php 
include("../koneksi/konek.php");
$grd = $_REQUEST["grd"];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="kodebarang";
$defaultsort1="kodebarang";
$sorting=$_REQUEST["sorting"];
$sorting1=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$filter1=$_REQUEST["filter"];
//===============================
$data=$_GET['data'];
//===============================
 switch(strtolower($_REQUEST['act'])){
	case 'kanan':
		$dt=explode("|",$data);
		for($i=0;$i<count($dt); $i++){
			if($dt[$i]!=''){
				$sql1="INSERT INTO $dbcssd.cssd_ms_alat (idbarang) VALUES ('".$dt[$i]."') ";
				mysql_query($sql1);
			}
		}
		break;
	case 'kiri':
		$dt=explode("|",$data);
		for($i=0;$i<count($dt); $i++){
			if($dt[$i]!=''){
				$sql2="DELETE FROM $dbcssd.cssd_ms_alat WHERE idbarang='".$dt[$i]."'";
				mysql_query($sql2);
			}
		}
		break;
}

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
}
if ($filter1!=""){
	$filter1=explode("|",$filter1);
	$filter1=" AND ".$filter1[0]." like '%".$filter1[1]."%'";
}

if ($sorting==""){
	$sorting=$defaultsort;
}
if ($sorting1==""){
	$sorting1=$defaultsort1;
}

switch($grd){
	case "1":
	/*$sql="SELECT mb.idbarang, mb.kodebarang, mb.namabarang, mb.idsatuan
FROM dbaset.as_ms_barang mb"; // $filter ORDER BY $sorting
	$sql="SELECT mb.idbarang, mb.kodebarang, mb.namabarang, mb.idsatuan
FROM dbaset.as_ms_barang mb";*/
	$sql="SELECT * FROM $dbaset.as_ms_barang mb WHERE (mb.level=6 or mb.level=5) AND (mb.kodebarang LIKE '02.08%' OR mb.kodebarang LIKE '02.09%' OR mb.kodebarang LIKE '00.01%') AND mb.idbarang NOT IN (SELECT idbarang FROM $dbcssd.cssd_ms_alat) $filter GROUP BY mb.namabarang ORDER BY $sorting";
	break;
	case "2":
	/*$sql="SELECT * from (SELECT mb.idbarang, mb.kodebarang, mb.namabarang, mb.idsatuan
FROM cssd_ms_alat ma
LEFT JOIN dbaset.as_ms_barang mb
ON mb.idbarang = ma.idbarang) as tbl2 $filter1 ORDER BY $sorting1";*/
	$sql="SELECT mb.idbarang, mb.kodebarang, mb.namabarang, mb.idsatuan
FROM $dbcssd.cssd_ms_alat ma
LEFT JOIN $dbaset.as_ms_barang mb
ON mb.idbarang = ma.idbarang where ma.tipe=0 $filter ORDER BY $sorting";
	break;
}
//echo $sql."<br>";
//$perpage=100;
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

switch($grd){
	case "1":
	while ($rows=mysql_fetch_array($rs)){
		$id=$rows['idbarang']."|";
		$chk1="<input type='checkbox' id='cekbok$i' name='cekbok$i' value='$rows[idbarang]' />";
		$i++;
		$dt.=$id.chr(3).$chk1.chr(3).$i.chr(3).$rows["kodebarang"].chr(3).$rows["namabarang"].chr(3).$rows["idsatuan"].chr(6);
	}
	break;
	case "2":
	while ($rows=mysql_fetch_array($rs)){
		$id=$rows['idbarang'];
		$chk2="<input type='checkbox' id='ngecek$i' name='ngecek$i' value='$rows[idbarang]' />";
		$i++;
		$dt.=$id.chr(3).$chk2.chr(3).$i.chr(3).$rows["kodebarang"].chr(3).$rows["namabarang"].chr(3).$rows["idsatuan"].chr(6);
	}
}

if ($dt!=$totpage.chr(5)){
	$dt=substr($dt,0,strlen($dt)-1);
	$dt=str_replace('"','\"',$dt);
}
mysql_free_result($rs);
echo mysql_error();
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