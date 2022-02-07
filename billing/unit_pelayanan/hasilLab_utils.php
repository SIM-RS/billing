<?php 
include("../koneksi/konek.php");
$grd=$_REQUEST["grd"];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

switch(strtolower($_REQUEST['act']))
{
	
	case 'tambah':
		switch($_REQUEST["smpn"])
		{
			case 'btnSimpanHsl':
					$sqlTambah="insert into b_hasil_lab (id_pelayanan,id_kunjungan,id_tindakan,id_normal,hasil,ket,tgl_act,user_act) 
					values('".$_REQUEST['pelayanan_id']."','".$_REQUEST['kunjungan_id']."','".$_REQUEST['idTind']."','".$_REQUEST['normal']."','".$_REQUEST['hasil']."','".$_REQUEST['ket']."',now(),'".$_REQUEST['user_act']."')";
				break;
			case 'btnSimpanHslLabPa':
					$sqlTambah="insert into b_hasil_lab (id_pelayanan,id_kunjungan,id_tindakan,id_normal,tgl_act,user_act,makroskopik,mikroskopik,kesimpulan,anjuran) 
					values('".$_REQUEST['pelayanan_id']."','".$_REQUEST['kunjungan_id']."','0','0',now(),'".$_REQUEST['cmbDokLabPa']."','".$_REQUEST['txtMakros']."','".$_REQUEST['txtMikros']."','".$_REQUEST['txtKesimpulan']."','".$_REQUEST['txtAnjuran']."')";
				break;
			
		}
		$rs=mysql_query($sqlTambah);
		//echo mysql_error();
		break;
	
	case 'simpan':
		switch($_REQUEST["smpn"])
		{
			case 'btnSimpanHsl':
				$sqlUpdate="update b_hasil_lab set id_tindakan='".$_REQUEST['idTind']."',id_normal='".$_REQUEST['normal']."',hasil='".$_REQUEST['hasil']."',ket='".$_REQUEST['ket']."',user_act='".$_REQUEST['user_act']."' where id='".$_REQUEST['id']."'";
				break;
			case 'btnSimpanHslLabPa':
				$sqlUpdate="update b_hasil_lab set makroskopik='".$_REQUEST['txtMakros']."',mikroskopik='".$_REQUEST['txtMikros']."',kesimpulan='".$_REQUEST['txtKesimpulan']."',anjuran='".$_REQUEST['txtAnjuran']."',user_act='".$_REQUEST['cmbDokLabPa']."' where id='".$_REQUEST['id']."'";
				break;
		}
		$rs=mysql_query($sqlUpdate);
		break;
		
	case 'hapus':
		switch($_REQUEST["hps"])
		{
			case 'btnHapusHsl':
				$sqlHapus="delete from b_hasil_lab where id='".$_REQUEST['rowid']."'";
				break;
			case 'btnHapusHslLabPa':
				$sqlHapus="delete from b_hasil_lab where id='".$_REQUEST['rowid']."'";
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
	/*$sql = 'SELECT a.*,b.nama,CONCAT(a.hasil," ",d.nama_satuan) AS hasilc,CONCAT(CONCAT(c.normal1," - ",c.normal2)," ",d.nama_satuan) AS normal,g.nama as dok,a.ket 
			FROM b_hasil_lab a
			INNER JOIN b_ms_tindakan b ON b.id=a.id_tindakan
			INNER JOIN b_ms_normal_lab c ON c.id=a.id_normal
			INNER JOIN b_ms_satuan_lab d ON d.id=c.id_satuan
			INNER JOIN b_kunjungan e ON e.id=a.id_kunjungan
			INNER JOIN b_pelayanan f ON f.id=a.id_pelayanan 
			INNER JOIN b_ms_pegawai g ON g.id=a.user_act where 0=0 and f.id='.$_REQUEST['pelayanan_id']." ".$filter." order by ".$sorting;*/
	$sql="SELECT a.*,b.nama,CONCAT(a.hasil,' ',d.nama_satuan) AS hasilc,
		CONCAT(CONCAT(c.normal1,' - ',c.normal2),' ',d.nama_satuan) AS normal,
		g.nama AS dok,a.ket FROM b_hasil_lab a INNER JOIN b_ms_normal_lab c ON c.id=a.id_normal 
		INNER JOIN b_ms_satuan_lab d ON d.id=c.id_satuan INNER JOIN b_ms_pemeriksaan_lab b ON c.id_pemeriksaan_lab=b.id 
		INNER JOIN b_ms_pegawai g ON g.id=a.user_act 
		WHERE 0=0 AND a.id_pelayanan='".$_REQUEST['pelayanan_id']."' ".$filter." ORDER BY ".$sorting;
}elseif($grd == "LPA"){
	$sql="SELECT a.*,g.nama AS dok,a.ket FROM b_hasil_lab a 
		INNER JOIN b_ms_pegawai g ON g.id=a.user_act 
		WHERE 0=0 AND a.id_pelayanan='".$_REQUEST['pelayanan_id']."' ".$filter." ORDER BY ".$sorting;
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
		$dtx = $rows["id"]."|".$rows["nama"]."|".$rows["hasil"]."|".$rows["id_tindakan"]."|".$rows["id_normal"]."|".$rows["normal"]."|".$rows["user_act"]."|".$rows["ket"];
		$dt.=$dtx.chr(3).$i.chr(3).$rows["tgl_act"].chr(3).$rows["nama"].chr(3).$rows["hasilc"].chr(3).$rows["normal"].chr(3).$rows["ket"].chr(3).$rows["dok"].chr(6);
	}
}elseif($grd == "LPA"){
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dtx = $rows["id"]."|".$rows["makroskopik"]."|".$rows["mikroskopik"]."|".$rows["kesimpulan"]."|".$rows["anjuran"]."|".$rows["user_act"]."|".$rows["ket"];
		$dt.=$dtx.chr(3).$i.chr(3).$rows["tgl_act"].chr(3).$rows["makroskopik"].chr(3).$rows["mikroskopik"].chr(3).$rows["kesimpulan"].chr(3).$rows["dok"].chr(6);
	}
}



if ($dt!=$totpage.chr(5))
{
	$dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act'])."*|*".$_REQUEST["smpn"]."*|*".$_REQUEST["hps"]."*|*".$dt_temp;
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