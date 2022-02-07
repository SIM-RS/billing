<?php
include("../koneksi/konek.php");
$grd = $_REQUEST["grd"];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$unit=$_REQUEST['unit'];
$defaultsort="pesanan_id";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$idUser=$_REQUEST['idUser'];
	$tgl=tglSQL($_REQUEST['tgl']);
	$tgl2=tglSQL($_REQUEST['tgl2']);
	$jam=$_REQUEST['jam'];
	$jam2=$_REQUEST['jam2'];
	$jam3=$_REQUEST['jam3'];
	$jam4=$_REQUEST['jam4'];
	$jam5=$_REQUEST['jam5'];
	$jam6=$_REQUEST['jam6'];
	$jam7=$_REQUEST['jam7'];
	$jam8=$_REQUEST['jam8'];
	$jam9=$_REQUEST['jam9'];
	$jam10=$_REQUEST['jam10'];
	$tensi1=$_REQUEST['tensi1'];
	$tensi2=$_REQUEST['tensi2'];
	$tensi3=$_REQUEST['tensi3'];
	$tensi4=$_REQUEST['tensi4'];
	$nadi1=$_REQUEST['nadi1'];
	$nadi2=$_REQUEST['nadi2'];
	$nadi3=$_REQUEST['nadi3'];
	$nadi4=$_REQUEST['nadi4'];
	$suhu1=$_REQUEST['suhu1'];
	$suhu2=$_REQUEST['suhu2'];
	$suhu3=$_REQUEST['suhu3'];
	$suhu4=$_REQUEST['suhu4'];
	$rr1=$_REQUEST['rr1'];
	$rr2=$_REQUEST['rr2'];
	$rr3=$_REQUEST['rr3'];
	$rr4=$_REQUEST['rr4'];
	$infus=$_REQUEST['infus'];
	$oksigen=$_REQUEST['oksigen'];
	$obat1=$_REQUEST['obat1'];
	$obat2=$_REQUEST['obat2'];
	$obat3=$_REQUEST['obat3'];
	$obat4=$_REQUEST['obat4'];
		
switch(strtolower($_REQUEST['act'])){
	case 'tambah':
		$sqlTambah="INSERT INTO lap_pesanan_pos 
(kunjungan_id, pelayanan_id, tgl_act, user_act, tgl, tgl2, jam, jam2, jam3, jam4, jam5, jam6, jam7, jam8, jam9, jam10, tensi1, tensi2, tensi3, tensi4, nadi1, nadi2, nadi3, nadi4, suhu1, suhu2, suhu3, suhu4, rr1, rr2, rr3, rr4, infus, oksigen, obat1, obat2, obat3, obat4) 
VALUES 
('$idKunj', '$idPel', CURDATE(), '$idUser', '$tgl', '$tgl2', '$jam', '$jam2', '$jam3', '$jam4', '$jam5', '$jam6', '$jam7', '$jam8', '$jam9', '$jam10', '$tensi1', '$tensi2', '$tensi3', '$tensi4', '$nadi1', '$nadi2', '$nadi3', '$nadi4', '$suhu1', '$suhu2', '$suhu3', '$suhu4', '$rr1', '$rr2', '$rr3', '$rr4', '$infus', '$oksigen', '$obat1', '$obat2', '$obat3', '$obat4')";
		$rs=mysql_query($sqlTambah);
		break;
	case 'hapus':
		$sqlHapus="delete from lap_pesanan_pos where pesanan_id='".$_REQUEST['txtId']."'";
		mysql_query($sqlHapus);
		break;
	case 'edit':
		$sqlSimpan="update lap_pesanan_pos set
kunjungan_id='$idKunj', 
pelayanan_id='$idPel', 
tgl_act=CURDATE(), 
user_act='$idUser',		
tgl='$tgl', 
tgl2='$tgl2', 
jam='$jam', 
jam2='$jam2', 
jam3='$jam3', 
jam4='$jam4', 
jam5='$jam5', 
jam6='$jam6', 
jam7='$jam7', 
jam8='$jam8', 
jam9='$jam9', 
jam10='$jam10', 
tensi1='$tensi1', 
tensi2='$tensi2', 
tensi3='$tensi3', 
tensi4='$tensi4', 
nadi1='$nadi1', 
nadi2='$nadi2', 
nadi3='$nadi3', 
nadi4='$nadi4', 
suhu1='$suhu1', 
suhu2='$suhu2', 
suhu3='$suhu3', 
suhu4='$suhu4', 
rr1='$rr1', 
rr2='$rr2', 
rr3='$rr3', 
rr4='$rr4', 
infus='$infus', 
oksigen='$oksigen', 
obat1='$obat1', 
obat2='$obat2', 
obat3='$obat3', 
obat4='$obat4'
where pesanan_id='".$_REQUEST['txtId']."'";
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
	/*$sql="SELECT DISTINCT 
  md.nama AS diag, peg.nama AS dokter, z.*, DATE_FORMAT(z.tgl, '%d-%m-%Y') tanggal
FROM
  b_kunjungan k 
  INNER JOIN b_pelayanan p 
    ON k.id = p.kunjungan_id
  LEFT JOIN b_diagnosa diag 
    	ON diag.kunjungan_id = k.id 
  LEFT JOIN b_ms_diagnosa md 
    	ON md.id = diag.ms_diagnosa_id
  LEFT JOIN b_tindakan bmt 
    	ON k.id = bmt.kunjungan_id 
    	AND p.id = bmt.pelayanan_id 
  LEFT JOIN b_ms_pegawai peg 
    	ON peg.id = bmt.user_act 
  INNER JOIN lap_pesanan_pos z
  	ON z.pelayanan_id = p.id
WHERE k.id='$idKunj' AND p.id='$idPel' $filter GROUP BY pesanan_id order by ".$sorting;*/
	$sql="SELECT 
  b.*, DATE_FORMAT(b.tgl, '%d-%m-%Y') tanggal,
  peg.nama AS user_log,
  btt.nama tindakan,
  GROUP_CONCAT(md.nama) AS diag,
  IFNULL(peg.nama, '-') AS dokter,
  IFNULL(peg2.nama, '-') AS dr_rujuk 
FROM
  lap_pesanan_pos b 
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
WHERE b.pelayanan_id = '$idPel' $filter GROUP BY pesanan_id order by ".$sorting;
	
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
		$sisipan=$rows["pesanan_id"]."|".tglSQL($rows["tgl"])."|".tglSQL($rows["tgl2"])."|".$rows["jam"]."|".$rows["jam2"]."|".$rows["jam3"]."|".$rows["jam4"]."|".$rows["jam5"]."|".$rows["jam6"]."|".$rows["jam7"]."|".$rows["jam8"]."|".$rows["jam9"]."|".$rows["jam10"]."|".$rows["tensi1"]."|".$rows["tensi2"]."|".$rows["tensi3"]."|".$rows["tensi4"]."|".$rows["nadi1"]."|".$rows["nadi2"]."|".$rows["nadi3"]."|".$rows["nadi4"]."|".$rows["suhu1"]."|".$rows["suhu2"]."|".$rows["suhu3"]."|".$rows["suhu4"]."|".$rows["rr1"]."|".$rows["rr2"]."|".$rows["rr3"]."|".$rows["rr4"]."|".$rows["infus"]."|".$rows["oksigen"]."|".$rows["obat1"]."|".$rows["obat2"]."|".$rows["obat3"]."|".$rows["obat4"];
		$dt.=$sisipan.chr(3).number_format($i,0,",","").chr(3).$rows["tanggal"].chr(3).$rows["dokter"].chr(3).$rows["diag"].chr(6);
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