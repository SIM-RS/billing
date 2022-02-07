<?php 
include("../koneksi/konek.php");
$grd=$_REQUEST["grd"];
$grd1=$_REQUEST["grd1"];
$grd2=$_REQUEST["grd2"];
$grd3=$_REQUEST["grd3"];
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
			case 'btnSimpan':
				mysql_query("select * from b_ms_satuan_lab where nama_satuan='".$_REQUEST['nama']."'");
				if(mysql_affected_rows()==0)
				{	
					$sqlTambah="insert into b_ms_satuan_lab (nama_satuan,aktif) values('".$_REQUEST['nama']."','".$_REQUEST['aktif']."')";
					$rs=mysql_query($sqlTambah);
				}
				break;
			case 'btnSimpanPaket':
				mysql_query("select * from b_ms_paket_lab where nama_satuan='".$_REQUEST['nama']."'");
				if(mysql_affected_rows()==0)
				{	
					$sqlTambah="insert into b_ms_paket_lab (nama,aktif) values('".$_REQUEST['nama']."','".$_REQUEST['aktif']."')";
					$rs=mysql_query($sqlTambah);
				}
				break;
			
			case 'btnSimpanTrf':
				$sqlTambah="insert into b_ms_normal_lab (id_pemeriksaan_lab,id_satuan,lp,normal1,normal2,metode) values('".$_REQUEST['tindakan']."','".$_REQUEST['satuan']."','".$_REQUEST['lp']."','".$_REQUEST['nilai1']."','".$_REQUEST['nilai2']."','".$_REQUEST['metode']."')";
				$rs=mysql_query($sqlTambah);
				break;
			case 'btnSimpanKel':
				mysql_query("select * from b_ms_kelompok_lab where nama_kelompok='".$_REQUEST['kel']."'");
				if(mysql_affected_rows()==0)
				{	
					$sqlTambah="insert into b_ms_kelompok_lab (nama_kelompok,kode,level,parent_id) values('".$_REQUEST['kel']."','".$_REQUEST['kode_kel']."','".$_REQUEST['level']."','".$_REQUEST['parent']."')";
					$rs=mysql_query($sqlTambah);
					if (mysql_errno()==0){
						$sql="UPDATE b_ms_kelompok_lab SET islast=0 WHERE id='".$_REQUEST['parent']."'";
						$rs=mysql_query($sql);
					}
				}
			break;
			case 'btnSimpanPem':
				$sqlTambah="insert into b_ms_pemeriksaan_lab(kelompok_lab_id,nama,isDalam) values('".$_REQUEST['kelId']."','".$_REQUEST['txtTindPem']."',".$_REQUEST['isDalam'].")";
				$rs=mysql_query($sqlTambah);
				break;
		}
		break;
	
	case 'simpan':
		switch($_REQUEST["smpn"])
		{
			case 'btnSimpan':
				$sqlUpdate="update b_ms_satuan_lab set nama_satuan='".$_REQUEST['nama']."',aktif='".$_REQUEST['aktif']."' where id='".$_REQUEST['id']."'";
				$rs=mysql_query($sqlUpdate);
				break;
			case 'btnSimpanTrf':
				$sqlUpdate="update b_ms_normal_lab set id_pemeriksaan_lab='".$_REQUEST['tindakan']."',metode='".$_REQUEST['metode']."',id_satuan='".$_REQUEST['satuan']."',lp='".$_REQUEST['lp']."',normal1='".$_REQUEST['nilai1']."',normal2='".$_REQUEST['nilai2']."' where id='".$_REQUEST['id']."'";
				$rs=mysql_query($sqlUpdate);
				break;
			case 'btnSimpanKel':
				$sql="SELECT * FROM b_ms_kelompok_lab WHERE id=".$_REQUEST['id'];
				$rs=mysql_query($sql);
				$rw=mysql_fetch_array($rs);
				if ($rw["parent_id"]==$_REQUEST['parent']){
					$sqlUpdate="update b_ms_kelompok_lab set kode='".$_REQUEST['kode_kel']."',nama_kelompok='".$_REQUEST['kel']."' where id=".$_REQUEST['id'];
					$rs=mysql_query($sqlUpdate);
				}else{
					$sqlUpdate="update b_ms_kelompok_lab set kode='".$_REQUEST['kode_kel']."',nama_kelompok='".$_REQUEST['kel']."',parent_id='".$_REQUEST['parent']."' where id=".$_REQUEST['id'];
					$rs=mysql_query($sqlUpdate);
				}
				break;
			case 'btnSimpanPem':
				$sqlUpdate="update b_ms_pemeriksaan_lab set kelompok_lab_id='".$_REQUEST['kelId']."',nama='".$_REQUEST['txtTindPem']."',isDalam=".$_REQUEST['isDalam']." where id=".$_REQUEST['id'];
				$rs=mysql_query($sqlUpdate);
				break;
		}
		break;
		
	case 'hapus':
		switch($_REQUEST["hps"])
		{
			case 'btnHapus':
				$sqlHapus="delete from b_ms_satuan_lab where id='".$_REQUEST['rowid']."'";
				mysql_query($sqlHapus);
				break;
			case 'btnHapusTrf':
				$sqlHapus="delete from b_ms_normal_lab where id='".$_REQUEST['rowid']."'";
				mysql_query($sqlHapus);
				break;
			case 'btnHapusKel':
				$sql="SELECT * FROM b_ms_kelompok_lab WHERE id=".$_REQUEST['rowid'];
				$rs=mysql_query($sql);
				$rw=mysql_fetch_array($rs);
				$idParent=$rw["parent_id"];
				$sqlHapus="delete from b_ms_kelompok_lab where id='".$_REQUEST['rowid']."'";
				mysql_query($sqlHapus);
				if (mysql_errno()==0){
					$sql="SELECT * FROM b_ms_kelompok_lab WHERE parent_id=$idParent";
					$rs=mysql_query($sql);
					if (mysql_num_rows($rs)==0){
						$sql="UPDATE b_ms_kelompok_lab SET islast=1 WHERE id=$idParent";
						$rs=mysql_query($sql);
					}
				}
				break;
			case 'btnHapusPem':
				$sqlHapus="delete from b_ms_pemeriksaan_lab where id='".$_REQUEST['rowid']."'";
				mysql_query($sqlHapus);
				break;
		}
		break;
}

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
}
//echo $grd.'123';

if($grd == "true")
{
	if($sorting==''){	
		$defaultsort="id";
		$sorting=$defaultsort;
	}
	$sql = "SELECT id,nama_satuan,if(aktif=1,'Aktif','Tidak') as aktif FROM b_ms_satuan_lab where 0=0 ".$filter." order by ".$sorting;	
}
elseif($grd1 == "true")
{
	if($sorting==''){	
		$defaultsort="id";
		$sorting=$defaultsort;
	}
	$sql = "SELECT a.*,b.nama,c.nama_satuan,if(a.lp='l','Laki-laki','Perempuan') as jns,metode from b_ms_normal_lab a 
	inner join b_ms_pemeriksaan_lab b on a.id_pemeriksaan_lab=b.id
	inner join b_ms_satuan_lab c on a.id_satuan=c.id where 0=0 ".$filter." order by ".$sorting;
}
elseif($grd2=="true")
{
	if($sorting==''){	
		$sorting="kode";
	}
	//$sql = "select * from b_ms_kelompok_lab where 0=0 ".$filter." order by ".$sorting;
	$sql="SELECT *,(SELECT kode FROM b_ms_kelompok_lab WHERE id=a.parent_id) kode_parent FROM b_ms_kelompok_lab a WHERE 0=0 ".$filter." ORDER BY ".$sorting;
}
elseif($grd3=="true")
{
	if($sorting==''){	
		$defaultsort="id";
		$sorting=$defaultsort;
	}
	$sql = "SELECT b.id,c.id AS kelid,b.nama, b.isDalam 
FROM b_ms_pemeriksaan_lab b INNER JOIN b_ms_kelompok_lab c ON c.id=b.kelompok_lab_id 
where 0=0 and c.id='$_REQUEST[kelId]' ".$filter." order by ".$sorting;
}

$sql."<br>";
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
		$dt.=$rows["id"].chr(3).$i.chr(3).$rows["nama_satuan"].chr(3).$rows["aktif"].chr(6);
	}
}
elseif($grd1 == "true")
{
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$arv = $rows["id"]."|".$rows["id_pemeriksaan_lab"]."|".$rows["nama"]."|".$rows["lp"]."|".$rows["id_satuan"]."|".$rows["normal1"]."|".$rows["normal2"]."|".$rows["metode"];
		$dt.=$arv.chr(3).$i.chr(3).$rows["nama"].chr(3).$rows["jns"].chr(3).$rows["normal1"]." - ".$rows["normal2"]." ".$rows["nama_satuan"].chr(3).$rows["metode"].chr(6);
	}
	
}

elseif($grd2 == "true")
{
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		//$arv = $rows["id"]."|".$rows["tindid"]."|".$rows["nama"]."|".$rows["kelid"];
		$dt.=$rows["id"]."|".$rows["parent_id"]."|".$rows["kode_parent"].chr(3).$i.chr(3).$rows["kode"].chr(3).$rows["nama_kelompok"].chr(6);
	}
}
elseif($grd3 == "true")
{
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$arv = $rows["id"]."|".$rows["nama"]."|".$rows["kelid"]."|".$rows["isDalam"];
		$dt.=$arv.chr(3).$i.chr(3).$rows["nama"].chr(6);
	}
	
}

if ($dt!=$totpage.chr(5))
{
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