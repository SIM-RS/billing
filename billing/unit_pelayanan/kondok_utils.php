<?php 
session_start();
$userId=$_SESSION['userId'];
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="tgl desc";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];

$kunjungan_id=$_REQUEST['kunjungan_id'];
$pelayanan_id=$_REQUEST['pelayanan_id'];

$kondokId=$_REQUEST['kondokId'];
$txtKetKondok=$_REQUEST['txtKetKondok'];
$cmbDokKonDok=$_REQUEST['cmbDokKonDok'];
$idDokRujukDokter=$_REQUEST['idDokRujukDokter'];
$isDokPengganti=$_REQUEST['isDokPengganti'];
//===============================
switch(strtolower($_REQUEST['act'])){
	case 'tambah':
	$sql1="INSERT INTO b_konsul (tgl,pelayanan_id,dokter_id,ket,dokter_perujuk,type_dokter_perujuk,tgl_act,user_act) VALUES (NOW(),'$pelayanan_id','$cmbDokKonDok','$txtKetKondok','$idDokRujukDokter','$isDokPengganti',NOW(),'$userId')";
		mysql_query($sql1);
		break;
	case 'hapus':
		$sql3="DELETE FROM b_konsul WHERE id='$kondokId'";
		mysql_query($sql3);
		break;
}
if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){
	$sorting=$defaultsort;
}
$cmbDokter=$_REQUEST['cmbDokter'];
if($cmbDokter!=''){
	$cmbDokter="AND user_id='$cmbDokter'";
}else{
	$cmbDokter="AND user_id='0'";
}

$sql="SELECT
k.id,
DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tgl,
pg.nama AS dokter,
k.ket
FROM b_konsul k
INNER JOIN b_pelayanan p ON p.id=k.pelayanan_id
INNER JOIN b_ms_pegawai pg ON pg.id=k.dokter_id
WHERE k.pelayanan_id='".$_REQUEST['pelayanan_id']."'";

//echo $sql."<br>";
$perpage=100;
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


while ($rows=mysql_fetch_array($rs)){
	$id=$rows['id']."|".$rows['ket'];
	$i++;
	$dt.=$id.chr(3).$i.chr(3).$rows["tgl"].chr(3).$rows["dokter"].chr(3).$rows["ket"].chr(6);
}

if ($dt!=$totpage.chr(5)) {
	$dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act'])."*|*".$_REQUEST["smpn"]."*|*".$_REQUEST["hps"];
	$dt=str_replace('"','\"',$dt);
}
else{
	$dt="0".chr(5).chr(5).strtolower($_REQUEST['act'])."*|*".$_REQUEST["smpn"]."*|*".$_REQUEST["hps"];	
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