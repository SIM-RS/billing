<?php 
include("../koneksi/konek.php");
$grd = $_REQUEST["grd"];
$grd2 = $_REQUEST["grd2"];
if(empty($_REQUEST["idunit"])){
	$idunit = '122';
}else{
	$idunit = $_REQUEST["idunit"];
}
$bulan = $_REQUEST["bulan"];
$tahun = $_REQUEST["tahun"];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="ap.NOKIRIM desc";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
		
/* if($grd=='true'){
	switch(strtolower($_REQUEST['act'])){
		
	}
}else if($grd2=='true'){
	switch(strtolower($_REQUEST['act'])){
		
	}
} */

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){
	$sorting=$defaultsort;
}

if($grd == "true")
{
	$sql = "select distinct ap.id, date_format(ap.TANGGAL,'%d/%m/%Y') as tgl1, au.UNIT_NAME,ap.NOKIRIM 
			from $dbapotek.a_penerimaan ap 
			inner join $dbapotek.a_unit au on ap.UNIT_ID_TERIMA=au.UNIT_ID 
			where ap.UNIT_ID_KIRIM=$idunit AND TIPE_TRANS=3 and month(ap.TANGGAL)=$bulan and year(ap.TANGGAL)=$tahun $filter order by ".$sorting;
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

if($grd == "true")
{
	while ($rows=mysql_fetch_array($rs))
	{
		//$proses = '<img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Melihat Detail Peminjaman">';
		$no_kirim=$rows['NOKIRIM'];
		$proses = "<img src='../icon/edit.gif' width='16' height='16' onClick=btnProses('$no_kirim') />";		
		$sql="select distinct status from $dbapotek.a_penerimaan where NOKIRIM='$no_kirim' order by status desc";
		$rs1=mysql_query($sql);
		$jmlrec=mysql_num_rows($rs1);
		if ($rows1=mysql_fetch_array($rs1)){
			$istatus=$rows1['status'];
			switch ($istatus){
				case 0:
				$cstatus="Dikirim";
				break;
				case 1:
				$cstatus="Diterima";
				//if ($jmlrec>1) $cstatus="Diterima(-)"; else $cstatus="Diterima";
				break;
			}
		}
		$i++;
		$dt.=$rows["id"].chr(3).number_format($i,0,",","").chr(3).$rows['tgl1'].chr(3).$rows["NOKIRIM"].chr(3).$rows["UNIT_NAME"].chr(3).$cstatus.chr(3).$proses.chr(6);
	}
}/* elseif($grd2 == "true")
{
	
} */

if ($dt!=$totpage.chr(5)){
	$dt=substr($dt,0,strlen($dt)-1);
	$dt=str_replace('"','\"',$dt);
}
//mysql_free_result($rs);
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