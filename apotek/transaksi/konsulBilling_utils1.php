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
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort=" gab.id";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//$res;
//===============================

if($grdDet == "true"){
   switch(strtolower($_REQUEST['act']))
   {
      case 'tambah':
	    $sqlCek = "select * from $dbbilling.b_resep where id='".$_REQUEST['idRes']."'";
	    $rsCek = mysqli_query($konek,$sqlCek);
		$rwCek=mysqli_fetch_array($rsCek);
		$cstatus=$rwCek["status"];
	    if($cstatus==0)
	    {
		  $kepemilikan_id=$rwCek["kepemilikan_id"];
		  $kso_id=$rwCek["kso_id"];
		  $kso=0;
		  $cara_bayar=1;
		  if ($kso_id>1){
		  	$kso=1;
			$cara_bayar=2;
		  }
		  $no_kunj=0;
		  $no_penjualan="1";
		  $NoRM=$rwCek["no_rm"];
		  $NoResep=$rwCek["no_resep"];
		  $dokter=$rwCek["dokter_nama"];
		  $ruangan=$rwCek["dokter_nama"];
		  $biaya_retur=0;
		  $embalage=0;
		  $jasa_resep=0;
		  $nm_pasien=$rwCek["nama_pasien"];
		  
		  $sqlTambah = "UPDATE $dbbilling.b_resep SET status = '1' WHERE id = '".$_REQUEST['idRes']."'";
		  $rs=mysqli_query($konek,$sqlTambah);
		  $res = mysqli_affected_rows($konek);
	    }
      break;
		   
      case 'hapus':
      $sqlHapus="UPDATE $dbbilling.b_resep SET status = '0' WHERE id = '".$_REQUEST['idRes']."'";
      $rs=mysqli_query($konek,$sqlHapus);
      $res = mysqli_affected_rows($konek);
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
	$sql = "select * from (SELECT
  p.id,
  ps.no_rm,
  ps.nama     nama_pasien,
  u.nama      nama_unit,
  kp.NAMA     nama_kepemilikan,
  kso.nama    nama_kso,
  mp.nama	  dokter
FROM ".$dbbilling.".b_pelayanan p
  INNER JOIN ".$dbbilling.".b_ms_pasien ps
    ON p.pasien_id = ps.id
  INNER JOIN ".$dbbilling.".b_ms_kso kso
    ON kso.id = p.kso_id
  LEFT JOIN ".$dbapotek.".a_kepemilikan kp
    ON kso.kepemilikan_id = kp.ID
  INNER JOIN ".$dbbilling.".b_ms_unit u
    ON u.id = p.unit_id_asal
  INNER JOIN ".$dbbilling.".b_ms_pegawai mp
    ON mp.id = p.dokter_id
  INNER JOIN ".$dbbilling.".b_ms_unit mu
    ON mu.id = p.unit_id
WHERE mu.kategori = '5' AND p.tgl = '".$tgl2."'
    ".$fSta.") as gab".$filter." ORDER BY ".$sorting;
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
		$dt.=$rows["id"].chr(3).$i.chr(3).$rows["no_rm"].chr(3).$rows["nama_pasien"].chr(3).$rows["nama_unit"].chr(3).$rows["nama_kepemilikan"].chr(3).$rows["nama_kso"].chr(3).$rows["dokter"].chr(6);
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