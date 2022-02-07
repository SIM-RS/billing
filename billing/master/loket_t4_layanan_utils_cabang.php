<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="kode";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$idunit = $_REQUEST['idunit'];
$ischecked = $_REQUEST['ischecked'];
$cabang = ($_REQUEST['cabang'] > 0) ? $_REQUEST['cabang'] : 1 ;
//===============================
$statusProses='';
$alasan='';
switch(strtolower($_REQUEST['act'])){
	case 'update':
		if ($ischecked=="true"){
			$rs=mysql_query("select * from b_ms_unit_loket where id_loket='".$_REQUEST['idloket']."' AND id_unit_layanan='".$idunit."' and cabang_id = '{$cabang}'");
			if(mysql_num_rows($rs)==0){
				$sqlTambah="insert into b_ms_unit_loket(id_loket,id_unit_layanan)
					values('".$_REQUEST['idloket']."','".$idunit."')";
				//echo $sqlTambah."<br/>";
				$rs=mysql_query($sqlTambah);
			}
		}else{
			$rs=mysql_query("DELETE FROM b_ms_unit_loket WHERE id_loket='".$_REQUEST['idloket']."' AND id_unit_layanan='".$idunit."'");
		}
		return;
		break;
}

if($statusProses=='Error'){	
	$dt="0".chr(5).chr(4).chr(5).strtolower($_REQUEST['act'])."*|*".$alasan;
}
else{

	if ($filter!=""){
		$filter=explode("|",$filter);
		$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
	}
	
	if ($sorting==""){
		$sorting=$defaultsort;
	}
	
	$sql="SELECT * FROM (SELECT mu.id,mu.kode,mu.nama,mu1.nama jenis_layanan,IF(mu.inap=1,'Ya','Tidak') AS inap 
FROM b_ms_unit mu INNER JOIN b_ms_unit mu1 ON mu.parent_id=mu1.id 
WHERE mu.kategori=2 AND mu.level=2 AND mu.aktif=1 AND mu.cabang_id = '{$cabang}') AS gab".$filter." ORDER BY ".$sorting;
	
	echo $sql."<br>";
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
	
	while ($rows=mysql_fetch_array($rs)){
		$i++;
		$stchecked="";
		$sql="SELECT * FROM b_ms_unit_loket WHERE id_loket=".$_REQUEST["idloket"]." AND id_unit_layanan=".$rows["id"];
		$rscheck=mysql_query($sql);
		if (mysql_num_rows($rscheck)>0){
			$stchecked="checked='checked'";
		}
		$dt.=$rows["id"].chr(3)."<input type='checkbox' ".$stchecked." value='$rows[id]' onclick='update(this)' />".chr(3).$rows["kode"].chr(3).$rows["nama"].chr(3).$rows["jenis_layanan"].chr(3).$rows["inap"].chr(6);
	}
	
	if ($dt!=$totpage.chr(5)){
		$dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act']);
		$dt=str_replace('"','\"',$dt);
	}
	mysql_free_result($rs);
}
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