<?php
include("../../koneksi/konek.php");
$grd = $_REQUEST["grd"];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$unit=$_REQUEST['unit'];
$defaultsort="periksa_id";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$idUser=$_REQUEST['idUser'];
	$tajamlihat=$_REQUEST['tajamlihat'];
	$mkanan=$_REQUEST['mkanan'];
	$tajam=$_REQUEST['tajam'];
	$mkiri=$_REQUEST['mkiri'];
	$tajam2=$_REQUEST['tajam2'];
	$anterior1=$_REQUEST['anterior1'];
	$anterior2=$_REQUEST['anterior2'];
	$posterior1=$_REQUEST['posterior1'];
	$posterior2=$_REQUEST['posterior2'];
	$wrn=$_REQUEST['wrn'];
	$catatan=$_REQUEST['catatan'];
		
switch(strtolower($_REQUEST['act'])){
	case 'tambah':
		$sqlTambah="INSERT INTO b_srt_ket_priksa_mata 
(kunjungan_id, pelayanan_id, tajamlihat, mata_kanan, kanan_kcmt, mata_kiri, kiri_kcmt, anterior_kanan, anterior_kiri, posterior_kanan, posterior_kiri, wrn_test, catatan, tgl_act, user_act) 
VALUES 
('$idKunj', '$idPel', '$tajamlihat', '$mkanan', '$tajam', '$mkiri', '$tajam2', '$anterior1', '$anterior2', '$posterior1', '$posterior2', '$wrn', '$catatan', CURDATE(), '$idUser')";
		$rs=mysql_query($sqlTambah);
		break;
	case 'hapus':
		$sqlHapus="delete from b_srt_ket_priksa_mata where periksa_id='".$_REQUEST['txtId']."'";
		mysql_query($sqlHapus);
		break;
	case 'edit':
		$sqlSimpan="update b_srt_ket_priksa_mata set
kunjungan_id='$idKunj', 
pelayanan_id='$idPel', 
tajamlihat='$tajamlihat', 
mata_kanan='$mkanan', 
kanan_kcmt='$tajam', 
mata_kiri='$mkiri', 
kiri_kcmt='$tajam2', 
anterior_kanan='$anterior1', 
anterior_kiri='$anterior2', 
posterior_kanan='$posterior1', 
posterior_kiri='$posterior2', 
wrn_test='$wrn', 
catatan='$catatan', 
tgl_act=CURDATE(), 
user_act='$idUser'		
where periksa_id='".$_REQUEST['txtId']."'";		
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
  md.nama AS diag,
  z.*
FROM
  b_kunjungan k 
  INNER JOIN b_ms_pasien mp 
    ON k.pasien_id = mp.id 
  INNER JOIN b_pelayanan p 
    ON k.id = p.kunjungan_id 
  LEFT JOIN b_tindakan bmt 
    ON k.id = bmt.kunjungan_id 
    AND p.id = bmt.pelayanan_id 
  LEFT JOIN b_diagnosa diag 
    ON diag.kunjungan_id = k.id 
  LEFT JOIN b_ms_diagnosa md 
    ON md.id = diag.ms_diagnosa_id 
  LEFT JOIN b_ms_pegawai peg 
    ON peg.id = bmt.user_act
  INNER JOIN b_srt_ket_priksa_mata z
  	ON z.pelayanan_id = p.id
WHERE k.id='$idKunj' AND p.id='$idPel' $filter GROUP BY periksa_id order by ".$sorting;
	
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
$info=array(1=>'dengan kacamata',2=>'tanpa kacamata',0=>'-');

if($grd == "true")
{
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		/*$sisipan=$rows["periksa_id"]."|".$rows["kunjungan_id"]."|".$rows["pelayanan_id"]."|".$rows["tajamlihat"]."|".$rows["mata_kanan"]."|".$rows["kanan_kcmt"]."|".$rows["mata_kiri"]."|".$rows["kiri_kcmt"]."|".$rows["anterior_kanan"]."|".$rows["anterior_kiri"]."|".$rows["posterior_kanan"]."|".$rows["posterior_kiri"]."|".$rows["wrn_test"]."|".$rows["catatan"];*/
		$sisipan=$rows["periksa_id"]."|".$rows["kanan_kcmt"]."|".$rows["kiri_kcmt"];
		$dt.=$sisipan.chr(3).number_format($i,0,",","").chr(3).$rows["tajamlihat"].chr(3).$rows["mata_kanan"].chr(3).$info[$rows["kanan_kcmt"]].chr(3).$rows["mata_kiri"].chr(3).$info[$rows["kiri_kcmt"]].chr(3).$rows["anterior_kanan"].chr(3).$rows["anterior_kiri"].chr(3).$rows["posterior_kanan"].chr(3).$rows['posterior_kiri'].chr(3).$rows['wrn_test'].chr(3).$rows["catatan"].chr(6);
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