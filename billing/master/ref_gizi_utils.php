<?php 
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="nama";
$grd=$_REQUEST['grd'];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$level = ($_REQUEST['level']=='')?1:$_REQUEST['level'];
//===============================

switch(strtolower($_REQUEST['act'])){	
	case 'tambah':
		switch($_REQUEST['tombol']){
			case 'btnSimpanWkt':
				$sqlTambah="insert into b_ms_reference (nama,stref,aktif,flag)
					values('".$_REQUEST['wkt']."',13,'".$_REQUEST['aktif']."','".$_REQUEST['flag']."')";
				$rs=mysql_query($sqlTambah);
				break;
			case 'btnSimpanJnsMak':
				$sqlTambah="insert into b_ms_reference (nama,stref,aktif,flag)
					values('".$_REQUEST['jnsMak']."',14,'".$_REQUEST['aktif']."','".$_REQUEST['flag']."')";
				$rs=mysql_query($sqlTambah);
				break;
			case 'btnSimpanJnsDiet':
				$sqlTambah="insert into b_ms_referencedistmakanan (nama,kode_jenis_makanan,flag)
					values('".$_REQUEST['jnsDiet']."','".$_REQUEST['jnsMak']."','".$_REQUEST['flag']."')";
				$rs=mysql_query($sqlTambah);
				break;
		}
		break;
	case 'hapus':
		switch($_REQUEST['tombol']){
			case 'btnHapusWkt':
				$sqlHapus="delete from b_ms_reference where id='".$_REQUEST['id']."'";
				mysql_query($sqlHapus);
				break;
			case 'btnHapusJnsMak':
				$sqlHapus="delete from b_ms_reference where id='".$_REQUEST['id']."'";
				mysql_query($sqlHapus);
				break;
			case 'btnHapusJnsDiet':
				$sqlHapus="delete from b_ms_referencedistmakanan where id='".$_REQUEST['id']."'";
				mysql_query($sqlHapus);
				break;
		}
		break;
	case 'simpan':
		switch($_REQUEST['tombol']){
			case 'btnSimpanWkt':
				$sqlSimpan="update b_ms_reference set nama='".$_REQUEST['wkt']."',aktif='".$_REQUEST['aktif']."',flag='".$_REQUEST['flag']."' where id='".$_REQUEST['id']."'";		
				$rs=mysql_query($sqlSimpan);
				break;
			case 'btnSimpanJnsMak':
				$sqlSimpan="update b_ms_reference set nama='".$_REQUEST['jnsMak']."',aktif='".$_REQUEST['aktif']."',flag='".$_REQUEST['flag']."' where id='".$_REQUEST['id']."'";		
				$rs=mysql_query($sqlSimpan);
				break;
			case 'btnSimpanJnsDiet':
				$sqlSimpan="update b_ms_referencedistmakanan set nama='".$_REQUEST['jnsDiet']."', kode_jenis_makanan='".$_REQUEST['jnsMak']."',flag='".$_REQUEST['flag']."' where id='".$_REQUEST['id']."'";
				$rs=mysql_query($sqlSimpan);
				break;
		}		
		break;
}

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){
	$sorting=$defaultsort;
}

switch($grd){
	case '1':
		$sql="select * from (SELECT id,nama,if(aktif=1,'Aktif','Tidak') as aktif FROM b_ms_reference where stref=13) as gab ".$filter." order by ".$sorting;
		break;
	case '2':
		$sql="select * from (SELECT id,nama,if(aktif=1,'Aktif','Tidak') as aktif FROM b_ms_reference where stref=14) as gab ".$filter." order by ".$sorting;
		break;
	case '3':
		$sql="select * from (SELECT id,nama,kode_jenis_makanan FROM b_ms_referencedistmakanan ) as gab ".$filter." order by ".$sorting;
		break;
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

switch($grd){
	case '1':
		while ($rows=mysql_fetch_array($rs)){
			$i++;
			$dt.=$rows["id"].chr(3).number_format($i,0,",","").chr(3).$rows["nama"].chr(3).$rows["aktif"].chr(6);
		}
		break;
	case '2':
		while ($rows=mysql_fetch_array($rs)){
			$i++;
			$dt.=$rows["id"].chr(3).number_format($i,0,",","").chr(3).$rows["nama"].chr(3).$rows["aktif"].chr(6);
		}
		break;
	case '3':
		while ($rows=mysql_fetch_array($rs)){
			$i++;
			$dt.=$rows["id"].chr(3).number_format($i,0,",","").chr(3).$rows["kode_jenis_makanan"].chr(3).$rows["nama"].chr(6);
		}
		break;
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