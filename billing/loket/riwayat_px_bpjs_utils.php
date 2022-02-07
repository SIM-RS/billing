<?php 
include("../koneksi/konek.php");

//====================================================================
//Paging,Sorting dan Filter======
$page = $_REQUEST["page"];
//$defaultsort = "id";
$sorting = $_REQUEST["sorting"];
$filter = $_REQUEST["filter"];
$tglact = gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$pasien_id = $_REQUEST['pasien_id'];
//===============================

	if ($filter != ""){
		$filter = explode("|",$filter);
		if($filter[0] == 'stt'){
			$filter[0] = "IF(aktif=1,'Aktif','Tidak Aktif')";
		}
		$filter = "AND ".$filter[0]." like '%".$filter[1]."%'";
	}
	
	if ($sorting == ""){
		$sorting = $defaultsort;
	}
	
	
	$sql = "SELECT 
			  k.id,
			  DATE_FORMAT(k.tgl, '%d-%m-%Y') AS tgl_kunj,
			  k.no_sjp,
			  u.nama AS poli,
			  CONCAT('[ ',d.kode,' ] - ',d.nama) AS diag
			FROM
			  b_kunjungan k 
			  INNER JOIN b_ms_unit u 
				ON u.id = k.unit_id 
			  INNER JOIN b_ms_diagnosa d 
				ON d.id = k.diag_awal 
			  WHERE k.pasien_id = '{$pasien_id}'
			  ORDER BY k.id DESC
			  LIMIT 5";
	
	//echo $sql."<br>";
	$rs = mysql_query($sql);
	$jmldata = mysql_num_rows($rs);
	if ($page == "" || $page == "0") $page = 1;
	$tpage = ($page-1)*$perpage;
	if (($jmldata%$perpage)>0) $totpage = floor($jmldata/$perpage)+1; else $totpage = floor($jmldata/$perpage);
	if ($page>1) $bpage = $page-1; else $bpage=1;
	if ($page<$totpage) $npage = $page+1; else $npage=$totpage;
	//$sql = $sql." limit $tpage,$perpage";
	//echo $sql;
	
	$rs = mysql_query($sql);
	$i = ($page-1)*$perpage;
	$dt = $totpage.chr(5);
	
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dt.=$rows['id'].chr(3).number_format($i,0,",","").chr(3).$rows['tgl_kunj'].chr(3).$rows['no_sjp'].chr(3).$rows['poli'].chr(3).$rows['diag'].chr(6);
	}
	
	if ($dt!=$totpage.chr(5)){
		$dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act']);
		$dt=str_replace('"','\"',$dt);
	}else{
		$dt.=chr(5).strtolower($_REQUEST['act']);
	}
	
mysql_free_result($rs);
mysql_close($konek);
if($act != ""){

}else{
	header("Cache-Control: no-cache, must-revalidate" );
	header("Pragma: no-cache" );
	if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")){
		header("Content-type: application/xhtml+xml");
	}else{
		header("Content-type: text/xml");
	}
	echo $dt;
}
?>