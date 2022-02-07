<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//QueryString===============================================
$unit_id = $_REQUEST['unit_id'];
$tgl_awal = explode('-',$_REQUEST['tgl_awal']);
$tgl_awal = $tgl_awal[2].'-'.$tgl_awal[1].'-'.$tgl_awal[0];
$tgl_akhir = explode('-',$_REQUEST['tgl_akhir']);
$tgl_akhir = $tgl_akhir[2].'-'.$tgl_akhir[1].'-'.$tgl_akhir[0];
//=====================================

//CRUD=============================================================================
if($_REQUEST['act'] == 'generate'){
	function days_diff($endDate, $beginDate){
	   $date_parts1=explode("-", $beginDate);
	   $date_parts2=explode("-", $endDate);
	   $start_date=gregoriantojd($date_parts1[1], $date_parts1[2], $date_parts1[0]);
	   $end_date=gregoriantojd($date_parts2[1], $date_parts2[2], $date_parts2[0]);
	   return $end_date - $start_date;
	}
	
	$tomorrow = date('Y-m-d', strtotime(date('Y-m-d') . " +1 day"));
	if(days_diff($tomorrow, $tgl_awal) > 0)
		$tgl_awal = $tomorrow;
	
	$days = days_diff($tgl_akhir,$tgl_awal);
	$date = strtotime($tgl_awal);
	for($i=0; $i <= $days; $i++){
		if($i > 0)
			$date = date('Y-m-d',strtotime(date("Y-m-d", strtotime($date)) . " +1 day"));
		else
			$date = date('Y-m-d',$date);
			
		$sql = "delete from b_jadwal_dokter where tgl = '{$date}' and unit_id = {$unit_id}";
		mysql_query($sql);
		
		$sql = "select 
			  mjd.dokter_id,
			  mjd.mulai,
			  mjd.selesai,
			  jd.id
			from
			  b_ms_jadwal_dokter mjd 
			  left join b_jadwal_dokter jd 
				on mjd.dokter_id = jd.dokter_id 
				and mjd.unit_id = jd.unit_id 
				and mjd.mulai = jd.mulai
				and mjd.selesai = jd.selesai 
				and jd.tgl = '{$date}'
			where mjd.hari = ".date('N',strtotime($date))." 
			  and mjd.unit_id = {$unit_id}";
		$query = mysql_query($sql);
		
		while($rows = mysql_fetch_assoc($query)){
			$sql = "insert into b_jadwal_dokter (unit_id, dokter_id, tgl, mulai, selesai)
				values ({$unit_id}, {$rows['dokter_id']}, '{$date}', '{$rows['mulai']}', '{$rows['selesai']}')";
			mysql_query($sql);
		}
	}
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

$sql="select 
	  jd.id,
	  jd.dokter_id,
	  jd.tgl,
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
	$i++;
	$dt.=$rows["id"].'||'.$rows['dokter_id'].'||'.$rows['mulai'].'||'.$rows['selesai'].chr(3).$i.chr(3).date('d-m-Y',strtotime($rows["tgl"])).chr(3).$rows["mulai"].' - '.$rows["selesai"].chr(3).$rows["nama"].chr(3).$rows["nip"].chr(6);
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
