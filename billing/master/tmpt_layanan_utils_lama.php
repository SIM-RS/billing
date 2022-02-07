<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="kode";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$level = ($_REQUEST['level']=='')?1:$_REQUEST['level'];
$kodeAk=$_REQUEST["kodeAk"];
$nama = $_REQUEST['nama'];
$nama = str_replace(chr(5),'&',$nama);
if($_GET['ktgr'] == 4){
    $cakupan = $_GET['cakupan'];
}
else{
    $cakupan = 0;
}
//===============================
$statusProses='';
$alasan='';
switch(strtolower($_REQUEST['act'])){
	case 'tambah':
		mysql_query("select * from b_ms_unit where kode='".$_REQUEST['parentKode'].$_REQUEST['kode']."'");
		if(mysql_affected_rows()==0){
			$sqlTambah="insert into b_ms_unit (kode,kode_ak,nama,level,parent_id,parent_kode,ket,kategori,jenis_layanan,inap,aktif)
				values('".$_REQUEST['parentKode'].$_REQUEST['kode']."','$kodeAk','$nama','".$level."','".$_REQUEST['parentId']."','".$_REQUEST['parentKode']."','".$_REQUEST['ket']."','".$_REQUEST['ktgr']."','$cakupan','".$_REQUEST['inap']."','".$_REQUEST['aktif']."')";
			//echo $sqlTambah."<br/>";
			$rs=mysql_query($sqlTambah);
			
			$cekLast="select islast from b_ms_unit where id='".$_REQUEST['parentId']."'";
			$rsLast=mysql_query($cekLast);
			$rwLast=mysql_fetch_array($rsLast);
			if($rwLast['islast']=='1'){
				$updtLast="update b_ms_unit set islast=0 where id='".$_REQUEST['parentId']."'";
				mysql_query($updtLast);
			}
		}
		break;
	case 'hapus':
		$sqlAnak="select id from b_ms_unit where parent_id='".$_REQUEST['rowid']."'";
		$rsAnak=mysql_query($sqlAnak);
		if(mysql_num_rows($rsAnak)>0){
			$statusProses='Error';
			$alasan="masih memiliki anak";
		}else{		
			$sqlParent="select parent_id from b_ms_unit where id='".$_REQUEST['rowid']."'";
			$rsParent=mysql_query($sqlParent);
			$rwParent=mysql_fetch_array($rsParent);
			
			$sqlHapus="delete from b_ms_unit where id='".$_REQUEST['rowid']."'";
			mysql_query($sqlHapus);
			
			$cekLast="select islast from b_ms_unit where parent_id='".$rwParent['parent_id']."'";
			$rsLast=mysql_query($cekLast);
			if(mysql_num_rows($rsLast)==0){
				$updtLast="update b_ms_unit set islast=1 where id='".$rwParent['parent_id']."'";
				mysql_query($updtLast);
			}
		}
		break;
	case 'simpan':
		$sqlParent="select parent_id from b_ms_unit where id='".$_REQUEST['id']."'";
		$rsParent=mysql_query($sqlParent);
		$rwParent=mysql_fetch_array($rsParent);
		if($rwParent['parent_id']==$_REQUEST['parentId']){
			$sqlSimpan="update b_ms_unit set kode='".$_REQUEST['parentKode'].$_REQUEST['kode']."',kode_ak='$kodeAk',nama='$nama',level='".$level."',
                                parent_kode='".$_REQUEST['parentKode']."',ket='".$_REQUEST['ket']."',kategori='".$_REQUEST['ktgr']."',inap='".$_REQUEST['inap']."'
                                ,aktif='".$_REQUEST['aktif']."', jenis_layanan='$cakupan' where id='".$_REQUEST['id']."'";
		}else{
			$sqlSimpan="update b_ms_unit set kode='".$_REQUEST['parentKode'].$_REQUEST['kode']."',kode_ak='$kodeAk',nama='$nama',level='".$level."',
                                parent_id='".$_REQUEST['parentId']."', parent_kode='".$_REQUEST['parentKode']."',ket='".$_REQUEST['ket']."',kategori='".$_REQUEST['ktgr']."'
                                ,inap='".$_REQUEST['inap']."',aktif='".$_REQUEST['aktif']."',jenis_layanan='$cakupan' where id='".$_REQUEST['id']."'";
			
			$cekLast="select islast from b_ms_unit where parent_id='".$_REQUEST['parentId']."'";
			$rsLast=mysql_query($cekLast);
			$rwLast=mysql_fetch_array($rsLast);
			if($rwLast['islast']=='1'){
				$updtLast="update b_ms_unit set islast=0 where id='".$_REQUEST['parentId']."'";
				mysql_query($updtLast);
			}
			
			$cekLastParentLama="select * from b_ms_unit where parent_id='".$rwParent['parent_id']."'";
			$rsLastParentLama=mysql_query($cekLastParentLama);
			if(mysql_num_rows($rsLastParentLama)<=0){
				$updtLast="update b_ms_unit set islast=1 where id='".$rwParent['parent_id']."'";
				mysql_query($updtLast);
			}
		}
		
		$rs=mysql_query($sqlSimpan);
		break;
}

if($statusProses=='Error'){	
	$dt="0".chr(5).chr(4).chr(5).strtolower($_REQUEST['act'])."*|*".$alasan;
}
else{

	if ($filter!=""){
		$filter=explode("|",$filter);
		$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
	}
	
	if ($sorting==""){
		$sorting=$defaultsort;
	}
	
	$sql="SELECT id,kode,kode_ak,nama,level,jenis_layanan,parent_id,parent_kode,ket,if(kategori=1,'Loket',if(kategori=2,'Pelayanan',if(kategori=3,'Administrasi',if(kategori=4,'Kasir',null)))) as kategori,islast,if(inap=1,'Ya','Tidak') as inap,if(aktif=1,'Aktif','Tidak') as aktif FROM b_ms_unit ".$filter." order by ".$sorting;
	
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
	
	while ($rows=mysql_fetch_array($rs)){
		$i++;
		$dt.=$rows["id"].'|'.$rows['jenis_layanan'].'|'.$rows['parent_id'].'|'.$rows['kode_ak'].chr(3).number_format($i,0,",","").chr(3).$rows["kode"].chr(3).$rows["nama"].chr(3).$rows["level"].chr(3).$rows["parent_kode"].chr(3).$rows["ket"].chr(3).$rows["kategori"].chr(3).$rows["inap"].chr(3).$rows["aktif"].chr(6);
	}
	
	if ($dt!=$totpage.chr(5)){
		$dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act']);
		$dt=str_replace('"','\"',$dt);
	}
	mysql_free_result($rs);
}
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