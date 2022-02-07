<?php
include("../../koneksi/konek.php");
//====================================================================
$user_act = $_REQUEST['user_act'];

//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="a.id DESC";
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


	$sql="SELECT
a.id,
c.`nama`,
c.`no_rm`,
c.`tgl_lahir`,
YEAR(CURDATE()) - YEAR(c.tgl_lahir) AS umur,
c.`sex`,
c.`alamat`,
CONCAT((CONCAT((CONCAT((CONCAT(c.alamat,' RT.',c.rt)),' RW.',c.rw)),', Desa ',w.nama)),', Kecamatan ',wi.nama) alamat ,
a.user_act,
a.tgl_mati,
a.jam_mati,
a.tgl_periksa,
peg.`nama` AS pemeriksa FROM b_ms_sk AS a 
INNER JOIN b_pelayanan AS b ON b.`id`=a.id_pelayanan
INNER JOIN b_ms_pasien AS c ON c.`id`=b.`pasien_id`
LEFT JOIN b_ms_wilayah w ON c.desa_id = w.id
LEFT JOIN b_ms_wilayah wi ON c.kec_id = wi.id
LEFT JOIN b_ms_pegawai peg ON peg.id = a.user_act where a.user_act='$user_act' ".$filter." order by ".$sorting;



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
		$tgl_lahir = tglSQL($rows["tgl_lahir"]);
		$tgl_mati = tglSQL($rows['tgl_mati']);
		$tgl_periksa = tglSQL($rows["tgl_periksa"]);
		
		//$datanya = "$rows[id]|$rows[id_pelayanan]|$rows[id_kunjungan]|$rows[nama]|$rows[no_rm]|$tgl_lahir|$rows[umur]|$rows[sex]|$rows[alamat]|$tgl_mati|$rows[jam_mati]";
		$datanya = "$rows[id]|$tgl_mati|$rows[jam_mati]|$tgl_periksa";
		$dt.=$datanya.chr(3).number_format($i,0,",","").chr(3).$rows["nama"].chr(3).$rows["no_rm"].chr(3).$tgl_lahir.chr(3).$rows["umur"].chr(3).tglSQL($rows["tgl_mati"]).chr(3).$rows["jam_mati"].chr(3).$tgl_periksa.chr(3).$rows["pemeriksa"].chr(6);
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