<?php
include("../koneksi/konek.php");
$grd = $_REQUEST["grd"];
$grdDet = $_REQUEST['grdDet'];
$idunit = $_REQUEST['idunit'];
$idunitBilling = $_REQUEST['idunitBilling'];
$iduser = $_REQUEST['iduser'];
$shft = $_REQUEST['shift'];
$th=explode("-",$_REQUEST['tanggal']);
$tgl2="$th[2]-$th[1]-$th[0]";
$nama = $_REQUEST['nama'];
$kd_anak = $_REQUEST['kd_anak'];
$level = $_REQUEST['level'];
$id_induk = $_REQUEST['id_induk'];
$id_terapi = $_REQUEST['id_terapi'];
$id_inLama = $_REQUEST['id_inLama'];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort=" a.kls_kode";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//$res;
//===============================

if($grdDet == "true"){
   switch(strtolower($_REQUEST['act']))
   {
      case 'tambah':
	    $sqlsimpan = "insert into a_kelas(KLS_KODE,KLS_NAMA,KLS_LEVEL,KLS_INDUK,KLS_ISLAST) value('$kd_anak','$nama',$level,$id_induk,1)";
		$rsqlsimpan = mysqli_query($konek,$sqlsimpan);
		
		$query_ubah = "update a_kelas set KLS_ISLAST = 0 where KLS_ID = $id_induk";
		$rquery_ubah = mysqli_query($konek,$query_ubah);
		
      break;
	  
	  case 'simpan':
	  
	    $sqlsimpan = "update a_kelas set KLS_KODE = '$kd_anak',KLS_NAMA = '$nama',KLS_LEVEL = $level,KLS_INDUK = $id_induk where kls_id = $id_terapi";
		$rsqlsimpan = mysqli_query($konek,$sqlsimpan);
		
		$query_ubah = "update a_kelas set KLS_ISLAST = 0 where KLS_ID = $id_induk";
		$rquery_ubah = mysqli_query($konek,$query_ubah);
		
	  $sqlCek = "select * from a_kelas where KLS_INDUK = $id_inLama";
	  $rsqlCek = mysqli_query($konek,$sqlCek);
	  $jsqlCek = mysqli_num_rows($rsqlCek);
	  
	  if($jsqlCek < 1)
	  {
		echo $sqlHapus1="UPDATE a_kelas set KLS_ISLAST = 1 where KLS_ID = $id_inLama";
	    $rs1=mysqli_query($konek,$sqlHapus1);
	  }
		
      break;
		   
      case 'hapus':
	  
	  $sqlHapus="delete from a_kelas where kls_id = $id_terapi";
      $rs=mysqli_query($konek,$sqlHapus);
	  
	  $sqlCek = "select * from a_kelas where KLS_INDUK = $id_induk";
	  $rsqlCek = mysqli_query($konek,$sqlCek);
	  $jsqlCek = mysqli_num_rows($rsqlCek);
	  
	  $jsqlCek;
	  
	  if($jsqlCek < 1)
	  {
		$sqlHapus1="UPDATE a_kelas set KLS_ISLAST = 1 where KLS_ID = $id_induk";
	    $rs1=mysqli_query($konek,$sqlHapus1);
	  }
	  
      break;   
   }
   /**/if($res > 0){
      $res = "Update berhasil.";
   }
   else if($res == 0){
      //$res = "Data tidak berubah.";
   }
   else{
      $res = "Update gagal.";
   }
   
   echo $res;
}

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){
	$sorting=$defaultsort;
}
if($_REQUEST['status'] != "") {
	$fSta = " AND p.dilayani = ".$_REQUEST['status'];
}


if($grd == "true")
{
	$sql = "SELECT a.KLS_ID, a.kls_kode, IFNULL(b.KLS_LEVEL,'-') as lvl_induk, a.KLS_NAMA, IFNULL(b.KLS_KODE,'-') as kd_induk, IFNULL(b.KLS_ID,'-') as id_induk, IFNULL(b.KLS_NAMA,'-') AS nm_induk FROM a_kelas a LEFT JOIN a_kelas b ON a.KLS_INDUK = b.KLS_ID".$filter." ORDER BY ".$sorting;
}

//echo $sql."<br>";
$perpage = 100;
$rs=mysqli_query($konek,$sql);
$jmldata=mysqli_num_rows($rs);
if ($page=="" || $page=="0") $page=1;
$tpage=($page-1)*$perpage;
if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
if ($page>1) $bpage=$page-1; else $bpage=1;
if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
$sql=$sql." limit $tpage,$perpage";
//echo $sql;

$rs=mysqli_query($konek,$sql);
$i=($page-1)*$perpage;
$dt=$totpage.chr(5);

if($grd == "true")
{
	while ($rows=mysqli_fetch_array($rs))
	{
		$i++;
		$dt.=$rows["KLS_ID"]."|".$rows["kls_kode"]."|".$rows["KLS_NAMA"]."|".$rows["nm_induk"]."|".$rows["id_induk"]."|".$rows["kd_induk"]."|".$rows["lvl_induk"].chr(3).$i.chr(3).$rows["kls_kode"].chr(3).$rows["KLS_NAMA"].chr(3).$rows["nm_induk"].chr(6);
	}
}

if ($dt!=$totpage.chr(5)){
	$dt=substr($dt,0,strlen($dt)-1);
	//$dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act']);
	$dt=str_replace('"','\"',$dt);
}
mysqli_free_result($rs);
mysqli_close($konek);
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")){
	header("Content-type: application/xhtml+xml");
}else{
	header("Content-type: text/xml");
}
//if($res>0) $dt="";
echo $dt;
?>