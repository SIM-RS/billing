<?php 
include("../koneksi/konek.php");
$grd = $_REQUEST["grd"];
$grd2 = $_REQUEST["grd2"];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="kode";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
		
if($grd=='true'){
	switch(strtolower($_REQUEST['act'])){
		case 'tambah':
			mysql_query("select * from b_ms_kamar where kode='".$_REQUEST['kode']."'");
			if(mysql_affected_rows()==0){			
				$sqlTambah="insert into b_ms_kamar (unit_id,kode,nama,jumlah_tt,jumlah_tt_b,aktif,lantai,flag)
					values('".$_REQUEST['unit']."','".$_REQUEST['kode']."','".$_REQUEST['nama']."','".$_REQUEST['jmlTT']."','".$_REQUEST['jmlTTB']."','".$_REQUEST['aktif']."','".$_REQUEST['lantai']."','".$_REQUEST['flag']."')";
					//echo $sqlTambah;
				$rs=mysql_query($sqlTambah);
			}
			break;
		case 'hapus':
			$sqlHapus="delete from b_ms_kamar where id='".$_REQUEST['rowid']."'";
			mysql_query($sqlHapus);
			break;
		case 'simpan':
			$sqlSimpan="update b_ms_kamar set unit_id='".$_REQUEST['unit']."',kode='".$_REQUEST['kode']."',nama='".$_REQUEST['nama']."',jumlah_tt='".$_REQUEST['jmlTT']."',jumlah_tt_b='".$_REQUEST['jmlTTB']."',aktif='".$_REQUEST['aktif']."',lantai='".$_REQUEST['lantai']."',flag='".$_REQUEST['flag']."' where id='".$_REQUEST['id']."'";		
			$rs=mysql_query($sqlSimpan);
			break;
	}
}else if($grd2=='true'){
	switch(strtolower($_REQUEST['act'])){
		case 'tambah':
			mysql_query("select id from b_ms_kamar_tarip where kamar_id='".$_REQUEST['idKamar']."' and kelas_id='".$_REQUEST['kelas']."' and unit_id = '".$_REQUEST['unit']."' and kso = {$_REQUEST['penjamin']}");
			if(mysql_affected_rows()==0){			
				$sqlTambah="insert into b_ms_kamar_tarip (kamar_id,unit_id,tarip,kelas_id,flag,kso) VALUES('".$_REQUEST['idKamar']."','".$_REQUEST['unit']."','".$_REQUEST['tarif']."','".$_REQUEST['kelas']."','".$_REQUEST['flag']."',".$_REQUEST['penjamin'].")";
				$rs=mysql_query($sqlTambah);
			}
			break;
		case 'hapus':
			$sqlHapus="delete from b_ms_kamar_tarip where id='".$_REQUEST['rowid']."'";
			mysql_query($sqlHapus);
			break;
		case 'simpan':
			$sqlSimpan="update b_ms_kamar_tarip set unit_id='".$_REQUEST['unit']."',kamar_id='".$_REQUEST['idKamar']."',tarip='".$_REQUEST['tarif']."',kelas_id='".$_REQUEST['kelas']."',flag='".$_REQUEST['flag']."',kso=".$_REQUEST['penjamin']." where id='".$_REQUEST['id']."'";		
			$rs=mysql_query($sqlSimpan);
			break;
	}
}

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){
	$sorting=$defaultsort;
	if($grd2=="true"){
		$sorting="unit";
	}
}

if($grd == "true")
{
	$sql="select * from (SELECT kmr.id,kmr.kode,kmr.nama,unit_id,jumlah_tt,jumlah_tt_b,IF(kmr.aktif=1,'Aktif','Tidak') AS aktif,unit.nama AS unit,kmr.lantai 
FROM b_ms_kamar kmr
INNER JOIN b_ms_unit unit ON unit.id=kmr.unit_id) as t1".$filter." order by ".$sorting;
}
elseif($grd2 == "true")
{
	$sql="select * from (SELECT t.id,t.kamar_id,t.tarip,t.unit_id,t.kelas_id,kls.nama AS kls,unit.nama AS unit ,kmr.nama AS kamar, kso as id_penjamin,kso.nama as penjamin
FROM b_ms_kamar_tarip t
INNER JOIN b_ms_unit unit ON unit.id=t.unit_id
INNER JOIN b_ms_kamar kmr ON kmr.id=t.kamar_id
LEFT JOIN b_ms_kso kso ON kso.id = t.kso
INNER JOIN b_ms_kelas kls ON kls.id=t.kelas_id where t.kamar_id='".$_REQUEST['idKamar']."') as t1".$filter." order by ".$sorting;
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
		$parent="select parent_id from b_ms_unit where id='".$rows["unit_id"]."'";
		$rsParent=mysql_query($parent);
		$rwParent=mysql_fetch_array($rsParent);
		$dt.=$rows["id"]."|".$rows["unit_id"]."|".$rwParent["parent_id"].chr(3).number_format($i,0,",","").chr(3).$rows["kode"].chr(3).$rows["nama"].chr(3).$rows["lantai"].chr(3).$rows["unit"].chr(3).$rows["jumlah_tt"].chr(3).$rows["jumlah_tt_b"].chr(3).$rows["aktif"].chr(6);
	}
}elseif($grd2 == "true")
{
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$parent="select parent_id from b_ms_unit where id='".$rows["unit_id"]."'";
		$rsParent=mysql_query($parent);
		$rwParent=mysql_fetch_array($rsParent);
		$dt.=$rows["id"]."|".$rows["kelas_id"]."|".$rows["kamar_id"]."|".$rows["unit_id"]."|".$rwParent["parent_id"]."|".$rows['id_penjamin'].chr(3).number_format($i,0,",","").chr(3).$rows["unit"].chr(3).$rows["kamar"].chr(3).$rows["kls"].chr(3).$rows["tarip"].chr(3).$rows['penjamin'].chr(6);
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