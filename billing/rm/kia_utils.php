<?php
session_start();
include("../koneksi/konek.php");
include("../sesi.php");
//include '../loket/forAkun.php';
//====================================================================
//Paging,Sorting dan Filter======

$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
$id = $_REQUEST["id"];

$grd = $_REQUEST["grd"];
$idPel = $_REQUEST["idPel"];
$kunjId = $_REQUEST["kunjId"];
$idKia = $_REQUEST["idKia"];
$idKiaDetail = $_REQUEST["idKiaDetail"];
$tgl_act = gmdate('Y-m-d H:i:s');
$user_act = $_SESSION['userId'];

$statusProses='';
switch(strtolower($_REQUEST['act'])) {
    case 'tambah':
		$kueri="INSERT b_kia (kunjungan_id,pelayanan_id,ms_kia_id,ms_kia_detail_id,user_act,tgl_act,flag) VALUES ('$kunjId','$idPel','$idKia','$idKiaDetail','$user_act',now(),'$flag')";
		$k=mysql_query($kueri);
		if($k){
			echo "<script>alert('Data Berhasil Ditambah...')</script>";
		}else{
			echo "<script>alert('Gagal !');</script>";
		}
    	break;
	case 'simpan':
		echo $qq="UPDATE b_kia SET ms_kia_id='$idKia',ms_kia_detail_id='$idKiaDetail',tgl_act=now(),user_act='$user_act',flag='$flag' WHERE id=".$id;
		$q=mysql_query($qq);
		if($q){
			echo "<script>alert('Data Berhasil Diubah...')</script>";
		}else{
			echo "<script>alert('Gagal !');</script>";
		}
		break;
	case 'hapus':
		$delet = "DELETE FROM b_kia WHERE id=".$id;
		$d=mysql_query($delet);
		if($d){
			echo "<script>alert('Berhasil dihapus...')</script>";
		}else{
			echo "<script>alert('Gagal !');</script>";
		}
		break;
}

if($statusProses=='Error') {
    $dt="0".chr(5).chr(4).chr(5).strtolower($_REQUEST['act']);
}
else {
    if ($filter!="") {
        $filter=explode("|",$filter);
        $filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
    }
    if ($sorting=="") {
        $sorting='id';
    }

    if($grd == "grdIsiDataRM"){
		echo $sql="SELECT
  k.id,
  mk.id      AS id_kia,
  mk.jenis,
  mkd.id     AS id_detail,
  mkd.detail
FROM b_kia k
  INNER JOIN b_ms_kia mk
    ON k.ms_kia_id = mk.id
  LEFT JOIN b_ms_kia_detail mkd
    ON k.ms_kia_detail_id = mkd.id WHERE k.pelayanan_id=".$idPel;
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

    if($grd == "grdIsiDataRM") {
        while ($rows=mysql_fetch_array($rs)) {
            $sisip=$rows["id"]."|".$rows["id_kia"]."|".$rows["id_detail"];
            $i++;
            $dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows["jenis"].chr(3).$rows["detail"].chr(6);
        }
    }

    if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act']);
        $dt=str_replace('"','\"',$dt);
    }

    mysql_free_result($rs);
}
mysql_close($konek);
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
    header("Content-type: application/xhtml+xml");
}else {
    header("Content-type: text/xml");
}
echo $dt;
?>
