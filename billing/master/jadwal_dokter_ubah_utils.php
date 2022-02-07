<?php
include("../koneksi/konek.php");
session_start();
$userId = $_SESSION['userId'];
$spesialis = $_SESSION['spesialis'];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//QueryString===============================================
$id = $_REQUEST['id'];
$unit_id = $_REQUEST['unit_id'];
$dokter_id = $_REQUEST['dokter_id'];
$hari = $_REQUEST['hari'];
$mulai = $_REQUEST['mulai'];
$selesai = $_REQUEST['selesai'];
$flag = $_REQUEST['flag'];
$tgl_awal = explode('-',$_REQUEST['tgl_awal']);
$tgl_awal = $tgl_awal[2].'-'.$tgl_awal[1].'-'.$tgl_awal[0];
$tgl_akhir = explode('-',$_REQUEST['tgl_akhir']);
$tgl_akhir = $tgl_akhir[2].'-'.$tgl_akhir[1].'-'.$tgl_akhir[0];

//=====================================

//CRUD=============================================================================
switch(strtolower($_REQUEST['act'])){
	case 'cek':
		/*$sql = "SELECT COUNT(id) cnt FROM b_ms_jadwal_dokter 
			WHERE unit_id = {$unit_id} AND dokter_id = {$dokter_id} AND hari = {$hari} 
			AND (
				('{$mulai}' >= mulai  AND '{$selesai}' <= selesai)
				OR ('{$mulai}' <= mulai AND '{$selesai}' >= selesai)
				OR ('{$mulai}' <= mulai AND ('{$selesai}' >= mulai AND '{$selesai}' <= selesai))
				OR (('{$mulai}' >= mulai AND '{$mulai}' <= selesai) AND '{$selesai}' >= selesai)
			)";
		$query = mysql_query($sql);
		$row = mysql_fetch_assoc($query);
		echo $row['cnt'];*/
		echo "0";
		exit();
		break;
	case 'simpan':
		if($id == ''){
			/*$sql = "insert into b_ms_jadwal_dokter (unit_id, dokter_id, hari, mulai, selesai)
				values({$unit_id}, {$dokter_id}, {$hari}, '{$mulai}', '{$selesai}')";	
			mysql_query($sql);*/
			/*echo "<script>alert('Anda hanya bisa mengubah data');</script>";*/					
		}else{
			$sql = "update b_jadwal_dokter set dokter_id = {$dokter_id}, mulai = '{$mulai}', selesai = '{$selesai}', flag = '{$flag}'
				where id = {$id}";
			mysql_query($sql);					
		}
		break;
	case 'hapus':
		$sql = "delete from b_jadwal_dokter where id = {$id}";
		mysql_query($sql);
		break;
}
//=======================================

if ($filter!=""){
	$filter=explode("|",$filter);
	if($filter[0] == 'jam')
		$filter="mulai like '%".$filter[1]."%' or selesai like '%{$filter[1]}%'";
	else
		$filter=$filter[0]." like '%".$filter[1]."%'";
}
if ($sorting=="")
	$sorting="tgl, mulai";

/*$sql="select 
	  jd.id,
	  jd.dokter_id,
	  jd.hari,
	  time_format(jd.mulai,'%H:%i') mulai,
	  time_format(jd.selesai,'%H:%i') selesai,
	  p.nip,
	  p.nama 
	from
	  b_ms_jadwal_dokter jd 
	  inner join b_ms_unit u 
		on jd.unit_id = u.id 
	  inner join b_ms_pegawai p 
		on jd.dokter_id = p.id 
	where u.aktif = 1 
	  and p.aktif = 1 
	  and p.spesialisasi_id != 0 
	  and jd.unit_id = {$unit_id}
	".(($filter!='')?"and $filter":"")." order by ".$sorting;*/
if($spesialis==0){
$sql="select 
	  jd.id,
	  jd.dokter_id,
	  jd.tgl,
	  DATE_FORMAT(jd.tgl, '%W') hari,
	  time_format(jd.mulai,'%H:%i') mulai,
	  time_format(jd.selesai,'%H:%i') selesai,
	  p.nip,
	  p.nama 
	from
	  b_jadwal_dokter jd 
	  inner join b_ms_unit u 
		on jd.unit_id = u.id 
	  inner join b_ms_pegawai p 
		on jd.dokter_id = p.id 
	where u.aktif = 1 
	  and p.aktif = 1 
	  and p.spesialisasi_id != 0
	  and jd.unit_id = {$unit_id}
	  and jd.tgl between '{$tgl_awal}' and '{$tgl_akhir}' 
	".(($filter!='')?"and $filter":"")." order by ".$sorting;
}else{
$sql="select 
	  jd.id,
	  jd.dokter_id,
	  jd.tgl,
	  DATE_FORMAT(jd.tgl, '%W') hari,
	  time_format(jd.mulai,'%H:%i') mulai,
	  time_format(jd.selesai,'%H:%i') selesai,
	  p.nip,
	  p.nama 
	from
	  b_jadwal_dokter jd 
	  inner join b_ms_unit u 
		on jd.unit_id = u.id 
	  inner join b_ms_pegawai p 
		on jd.dokter_id = p.id 
	where u.aktif = 1 
	  and p.aktif = 1 
	  and jd.dokter_id = {$userId}
	  and jd.unit_id = {$unit_id}
	  and jd.tgl between '{$tgl_awal}' and '{$tgl_akhir}' 
	".(($filter!='')?"and $filter":"")." order by ".$sorting;
}
//echo $sql."<br/>";
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

$arr_hari = array('','Senin','Selasa','Rabu','Kamis','Jum\'at','Sabtu','Minggu');

while ($rows=mysql_fetch_array($rs)){
	$i++;
	$dt.=($rows["id"].'||'.$rows['dokter_id'].'||'.$rows['mulai'].'||'.$rows['selesai']).chr(3).$i.chr(3).$rows["nama"].chr(3).$rows["nip"].chr(3).tglSQL($rows["tgl"]).chr(3).getHari($rows["hari"]).chr(3).$rows["mulai"].' - '.$rows['selesai'].chr(6);
}

if ($dt!=$totpage.chr(5)){
		$dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act']);
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
