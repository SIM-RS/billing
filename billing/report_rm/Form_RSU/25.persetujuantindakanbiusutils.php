<?php
include("../../koneksi/konek.php");
$grd = $_REQUEST["grd"];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$unit=$_REQUEST['unit'];
$defaultsort="bius_id";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$idUser=$_REQUEST['idUser'];
	$alterI1=$_REQUEST['alterI1'];
	$alterI2=$_REQUEST['alterI2'];
	$alterE1=$_REQUEST['alterE1'];
	$alterE2=$_REQUEST['alterE2'];
	$alasan1=$_REQUEST['alasan1'];
	$saya=$_REQUEST['saya'];
		
switch(strtolower($_REQUEST['act'])){
	case 'tambah':
		$sqlTambah="INSERT INTO persetujuan_tind_bius 
(kunjungan_id, pelayanan_id, tgl_act, user_act, alterI1, alterI2, alterE1, alterE2, alasan1, saya) 
VALUES 
('$idKunj', '$idPel', CURDATE(), '$idUser', '$alterI1', '$alterI2', '$alterE1', '$alterE2', '$alasan1', '$saya')";
		$rs=mysql_query($sqlTambah);
		break;
	case 'hapus':
		$sqlHapus="delete from persetujuan_tind_bius where bius_id='".$_REQUEST['txtId']."'";
		mysql_query($sqlHapus);
		break;
	case 'edit':
		$sqlSimpan="update persetujuan_tind_bius set
kunjungan_id='$idKunj', 
pelayanan_id='$idPel', 
tgl_act=CURDATE(), 
user_act='$idUser',		
alterI1='$alterI1', 
alterI2='$alterI2', 
alterE1='$alterE1', 
alterE2='$alterE2', 
alasan1='$alasan1', 
saya='$saya'
where bius_id='".$_REQUEST['txtId']."'";
//echo $sqlSimpan."<br/>";		
		$rs=mysql_query($sqlSimpan);
		break;
}

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){
	$sorting=$defaultsort;
}

if($grd == "true")
{	
	$sql="SELECT DISTINCT 
  peg.nama AS dokter, z.*, peg2.nama AS user_log
FROM
  b_kunjungan k 
  INNER JOIN b_pelayanan p 
    ON k.id = p.kunjungan_id
  LEFT JOIN b_tindakan bmt 
    	ON k.id = bmt.kunjungan_id 
    	AND p.id = bmt.pelayanan_id 
  LEFT JOIN b_ms_pegawai peg 
    	ON peg.id = bmt.user_act
  INNER JOIN persetujuan_tind_bius z
  	ON z.pelayanan_id = p.id
  LEFT JOIN b_ms_pegawai peg2 
    	ON peg2.id = z.user_act
WHERE k.id='$idKunj' AND p.id='$idPel' $filter GROUP BY bius_id order by ".$sorting;
	
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
		$i++;
		$sisipan=$rows["bius_id"]."|".$rows["alterI1"]."|".$rows["alterI2"]."|".$rows["alterE1"]."|".$rows["alterE2"]."|".$rows["alasan1"]."|".$rows["saya"];
		$dt.=$sisipan.chr(3).number_format($i,0,",","").chr(3).$rows["dokter"].chr(3).$rows["alterI1"].chr(3).$rows["alterI2"].chr(3).$rows["alterE1"].chr(3).$rows["alterE2"].chr(3).$rows["alasan1"].chr(3).$rows["user_log"].chr(6);
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