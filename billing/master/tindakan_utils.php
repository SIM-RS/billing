<?php
include("../koneksi/konek.php");
$grd = $_REQUEST["grd"];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$flag=$_REQUEST["flag"];
$unit=$_REQUEST['unit'];
$defaultsort="kode";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
		
switch(strtolower($_REQUEST['act'])){
	case 'tambah':
		//mysql_query("select * from b_ms_tindakan where kode='".$_REQUEST['kode']."'");
		$sqlTambah="insert into b_ms_tindakan (kode_icd9cm,unit_id,kode,nama,kode_askes,nama_askes,aktif,kel_tindakan_id,klasifikasi_id,flag)
				values('".$_REQUEST['icd9cm']."','".$_REQUEST['unit']."','".$_REQUEST['kode']."','".$_REQUEST['nama']."','".$_REQUEST['kodeAskes']."','".$_REQUEST['namaAskes']."','".$_REQUEST['aktif']."','".$_REQUEST['kelTinId']."','".$_REQUEST['klasId']."','".$_REQUEST['flag']."')";
			$rs=mysql_query($sqlTambah);
		if($sqlTambah == FALSE){
			echo mysql_error();
		}
		echo $sqlTambah;
		//if(mysql_affected_rows()==0){			
		
			
		//	echo $sqlTambah;
		//}
		break;
	case 'hapus':
		$sqlHapus="delete from b_ms_tindakan where id='".$_REQUEST['rowid']."'";
		mysql_query($sqlHapus);
		$sqlGet1="select * from b_ms_tindakan_kelas where ms_tindakan_id='".$_REQUEST['rowid']."'";
		$rsGet1=mysql_query($sqlGet1);
		//echo $sqlGet1."<br/>";
		while($rwGet1=mysql_fetch_array($rsGet1)){
			$sqlHapus3="delete from b_ms_tindakan_komponen where ms_tindakan_kelas_id='".$rwGet1['id']."'";
			mysql_query($sqlHapus3);
		}
		$sqlHapus2="delete from b_ms_tindakan_kelas where ms_tindakan_id='".$_REQUEST['rowid']."'";
		mysql_query($sqlHapus2);
		
		break;
	case 'simpan':
		$sqlSimpan="update b_ms_tindakan set kode_icd9cm='".$_REQUEST['icd9cm']."', unit_id='".$_REQUEST['unit']."',kode='".$_REQUEST['kode']."',nama='".$_REQUEST['nama']."',kode_askes='".$_REQUEST['kodeAskes']."',nama_askes='".$_REQUEST['namaAskes']."',aktif='".$_REQUEST['aktif']."',kel_tindakan_id='".$_REQUEST['kelTinId']."',klasifikasi_id='".$_REQUEST['klasId']."',flag='".$_REQUEST['flag']."' where id='".$_REQUEST['id']."'";		
		$rs=mysql_query($sqlSimpan);
		break;
}

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){
	$sorting=$defaultsort;
}

if($grd == "true")
{	
	$sql="select * from (SELECT kmr.id,kmr.kode_icd9cm,kmr.kode,kmr.nama,kmr.kode_askes,kmr.nama_askes,kmr.kel_tindakan_id,kmr.klasifikasi_id,kt.nama as kelompok, mk.nama as klasifikasi,IF(kmr.aktif=1,'Aktif','Tidak') AS aktif
FROM b_ms_tindakan kmr 
INNER JOIN b_ms_kelompok_tindakan kt ON kmr.kel_tindakan_id=kt.id
INNER JOIN b_ms_klasifikasi mk ON kmr.klasifikasi_id=mk.id) as t1 ".$filter." order by ".$sorting;
	
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
		$sisipan=$rows["id"]."|".$rows["kel_tindakan_id"]."|".$rows["klasifikasi_id"]."|".$rows["kode_askes"]."|".$rows["nama_askes"]."|".$rows["kode_icd9cm"];
		$dt.=$sisipan.chr(3).number_format($i,0,",","").chr(3).$rows["kode"].chr(3).$rows["nama"].chr(3).$rows['klasifikasi'].chr(3).$rows['kelompok'].chr(3).$rows["aktif"].chr(3).$rows["kode_icd9cm"].chr(6);
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