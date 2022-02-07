<?php 
include("../koneksi/konek.php");
$grd=$_REQUEST["grd"];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

$pelayanan_id=$_REQUEST['pelayanan_id'];
$id=$_REQUEST['id'];
$txtHslRad=$_REQUEST['txtHslRad'];
$cmbDokHsl=$_REQUEST['cmbDokHsl'];
$userId=$_REQUEST['userId'];
$norm = $_REQUEST['norm'];
$pacsid = $_REQUEST['pacsid'];

switch(strtolower($_REQUEST['act']))
{	
	case 'tambah':
		$query="insert into b_hasil_rad (tgl,pelayanan_id,hasil,user_id,tgl_act,user_act,norm,pacsid) values (now(),'$pelayanan_id','$txtHslRad','$cmbDokHsl',now(),'$userId','$norm','$pacsid')";
		$result = mysql_query ($query);
		break;
	case 'simpan':
		if($pacsid != ""){
			$setPacs = ", norm = '$norm',
					pacsid = '$pacsid'";
		} else {
			$setPacs = "";
		}
		$queri="update b_hasil_rad 
				set hasil='$txtHslRad',
					user_id='$cmbDokHsl',
					tgl_act=now(),
					user_act='$userId'
					$setPacs
				where id='$id'";
		$result = mysql_query ($queri);
		break;
	case 'hapus':
		switch($_REQUEST["hps"])
		{
			case 'btnHapusHslRad':
				$sqlHapus="delete from b_hasil_rad where id='".$_REQUEST['rowid']."'";
				break;
		}
		mysql_query($sqlHapus);
		break;	
}

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
}

if($sorting==''){
	if($grd=="true" || $grd1=="true"){		
		$defaultsort="id";
	}
	else{
		$defaultsort="nama";
	}
	$sorting=$defaultsort;
}
//echo $grd.'123';

if($grd == "true")
{
	if($_REQUEST['pelayanan_id']==''){
		$_REQUEST['pelayanan_id']=0;
	}
	$sql2="SELECT a.*,b.nama,CONCAT(a.hasil,' ',d.nama_satuan) AS hasilc,
		CONCAT(CONCAT(c.normal1,' - ',c.normal2),' ',d.nama_satuan) AS normal,
		g.nama AS dok,a.ket FROM b_hasil_lab a INNER JOIN b_ms_normal_lab c ON c.id=a.id_normal 
		INNER JOIN b_ms_satuan_lab d ON d.id=c.id_satuan INNER JOIN b_ms_pemeriksaan_lab b ON c.id_pemeriksaan_lab=b.id 
		INNER JOIN b_ms_pegawai g ON g.id=a.user_act 
		WHERE 0=0 AND a.id_pelayanan='".$_REQUEST['pelayanan_id']."' ".$filter." ORDER BY ".$sorting;
	$sql="SELECT 
		  hr.id,
		  DATE_FORMAT(hr.tgl,'%d-%m-%Y') tgl,
		  hr.tgl tanggal,
		  hr.hasil,
		  hr.user_id,
		  mp.nama 
		FROM
		  b_hasil_rad hr 
		  INNER JOIN b_ms_pegawai mp 
			ON mp.id = hr.user_id WHERE hr.pelayanan_id='".$_REQUEST['pelayanan_id']."'";
}

//echo $sql."<br>";
$rs=mysql_query($sql);
//echo mysql_error();
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
		$dtx = $rows["id"]."|".$rows["hasil"]."|".$rows["user_id"]."|".$rows["tanggal"];
		$dt.=$dtx.chr(3).$i.chr(3).$rows["tgl"].chr(3).$rows["hasil"].chr(3).$rows["nama"].chr(6);
	}
}

if ($dt!=$totpage.chr(5)){
	$dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act'])."*|*".$_REQUEST["smpn"]."*|*".$_REQUEST["hps"]."*|*".$dt_temp;
	$dt=str_replace('"','\"',$dt);
}
else{
	$dt="0".chr(5).chr(5).strtolower($_REQUEST['act'])."*|*".$_REQUEST["smpn"]."*|*".$_REQUEST["hps"]."*|*".$dt_temp;	
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