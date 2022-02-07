<?php
include("../../koneksi/konek.php");
$grd = $_REQUEST["grd"];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$unit=$_REQUEST['unit'];
$defaultsort="dental_id";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$idUser=$_REQUEST['idUser'];
	$idPasien=$_REQUEST['idPasien'];
	$keluhan=$_REQUEST['keluhan'];
	$anjuran=$_REQUEST['anjuran'];
	$caries=$_REQUEST['caries'];
	$filling=$_REQUEST['filling'];
	$root=$_REQUEST['root'];
	$missing=$_REQUEST['missing'];
	$crown=$_REQUEST['crown'];
	$bridge=$_REQUEST['bridge'];
	$dentures=$_REQUEST['dentures'];
	$malloclusion=$_REQUEST['malloclusion'];
	$lack=$_REQUEST['lack'];
	$calculus=$_REQUEST['calculus'];
	$endontolous=$_REQUEST['endontolous'];
	$mobility=$_REQUEST['mobility'];
	$others=$_REQUEST['others'];
	$caries1=$_REQUEST['caries2'];
	$filling1=$_REQUEST['filling2'];
	$root1=$_REQUEST['root2'];
	$missing1=$_REQUEST['missing2'];
	$crown1=$_REQUEST['crown2'];
	$bridge1=$_REQUEST['bridge2'];
	$dentures1=$_REQUEST['dentures2'];
	$malloclusion1=$_REQUEST['malloclusion2'];
	$lack1=$_REQUEST['lack2'];
	$calculus1=$_REQUEST['calculus2'];
	$endontolous1=$_REQUEST['endontolous2'];
	$mobility1=$_REQUEST['mobility2'];
	$others1=$_REQUEST['others2'];
	
$sAnam = "SELECT * 
FROM anamnese a
WHERE a.KUNJ_ID = '".$idKunj."' ORDER BY a.anamnese_id DESC LIMIT 1";	
$qAnam = mysql_query($sAnam);
$rwAnam = mysql_fetch_array($qAnam);
$keluhan = $rwAnam['KU'];

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
		$sqlTambah="INSERT INTO b_lap_med_cekup_stat_dental 
(kunjungan_id, pelayanan_id, tgl_act, user_act, keluhan, anjuran, caries, filling, root, missing, crown, bridge, dentures, malloclusion, lack, calculus, endontolous, mobility, others, caries1, filling1, root1, missing1, crown1, bridge1, dentures1, malloclusion1, lack1, calculus1, endontolous1, mobility1, others1) 
VALUES 
('$idKunj', '$idPel', CURDATE(), '$idUser', '$keluhan', '$anjuran', '$caries', '$filling', '$root', '$missing', '$crown', '$bridge', '$dentures', '$malloclusion', '$lack', '$calculus', '$endontolous', '$mobility', '$others', '$caries1', '$filling1', '$root1', '$missing1', '$crown1', '$bridge1', '$dentures1', '$malloclusion1', '$lack1', '$calculus1', '$endontolous1', '$mobility1', '$others1')";
		//echo $sqlTambah;
		$rs=mysql_query($sqlTambah);
		break;
	case 'hapus':
		$sqlHapus="delete from b_lap_med_cekup_stat_dental where dental_id='".$_REQUEST['txtId']."'";
		mysql_query($sqlHapus);
		break;
	case 'edit':
		$sqlSimpan="update b_lap_med_cekup_stat_dental set
kunjungan_id='$idKunj', 
pelayanan_id='$idPel',  
tgl_act=CURDATE(), 
user_act='$idUser',
keluhan='$keluhan', 
anjuran='$anjuran',
caries='$caries',
filling='$filling',
root='$root',
missing='$missing',
crown='$crown',
bridge='$bridge',
dentures='$dentures',
malloclusion='$malloclusion', 
lack='$lack',
calculus='$calculus', 
endontolous='$endontolous',
mobility='$mobility',
others='$others',
caries1='$caries1',
filling1='$filling1',
root1='$root1',
missing1='$missing1',
crown1='$crown1',
bridge1='$bridge1',
dentures1='$dentures1',
malloclusion1='$malloclusion1', 
lack1='$lack1',
calculus1='$calculus1', 
endontolous1='$endontolous1',
mobility1='$mobility1',
others1='$others1'
where dental_id='".$_REQUEST['txtId']."'";
//echo $sqlSimpan;
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
	/*$sql="SELECT DISTINCT 
  GRUP_CONCAT(md.nama) AS diag,
  z.*
FROM
  b_kunjungan k 
  INNER JOIN b_ms_pasien mp 
    ON k.pasien_id = mp.id 
  INNER JOIN b_pelayanan p 
    ON k.id = p.kunjungan_id 
  LEFT JOIN b_tindakan bmt 
    p.id = bmt.pelayanan_id 
  LEFT JOIN b_diagnosa diag 
    ON diag.pelayanan_id = p.id 
  LEFT JOIN b_ms_diagnosa md 
    ON md.id = diag.ms_diagnosa_id 
  LEFT JOIN b_ms_pegawai peg 
    ON peg.id = bmt.user_act 
  INNER JOIN b_lap_med_cekup_stat_dental z
    ON z.pelayanan_id = p.id
WHERE k.id='$idKunj' AND p.id='$idPel' $filter GROUP BY dental_id order by ".$sorting;*/
	$sql="SELECT 
  b.*,
  GROUP_CONCAT(md.nama) AS diag 
FROM
  b_lap_med_cekup_stat_dental b 
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
WHERE k.id='$idPel' $filter GROUP BY dental_id order by ".$sorting;
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
		$sisipan=$rows["dental_id"]."|".$rows["caries1"]."|".$rows["filling1"]."|".$rows["root1"]."|".$rows["missing1"]."|".$rows["crown1"]."|".$rows["bridge1"]."|".$rows["dentures1"]."|".$rows["malloclusion1"]."|".$rows["lack1"]."|".$rows["calculus1"]."|".$rows["endontolous1"]."|".$rows["mobility1"]."|".$rows["others1"]."|".$rows["caries"]."|".$rows["filling"]."|".$rows["root"]."|".$rows["missing"]."|".$rows["crown"]."|".$rows["bridge"]."|".$rows["dentures"]."|".$rows["malloclusion"]."|".$rows["lack"]."|".$rows["calculus"]."|".$rows["endontolous"]."|".$rows["mobility"]."|".$rows["others"];
		$dt.=$sisipan.chr(3).number_format($i,0,",","").chr(3).$rows["keluhan"].chr(3).$rows["diag"].chr(3).$rows["anjuran"].chr(6);
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