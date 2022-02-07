<?php
include("../koneksi/konek.php");
include("../sesi.php");
session_start();
//include '../loket/forAkun.php';
//====================================================================
//Paging,Sorting dan Filter======

$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

$grd = $_REQUEST["grd"];
$idPel = $_REQUEST["idPel"];
$kunj_id=$_GET['kunjId'];
$napTerapi=$_GET['napTerapi'];
$stt_nikah=$_GET['stt_nikah'];
$usia_pakai=$_GET['usia_pakai'];
$akibat=$_GET['akibat'];
$napza=$_GET['napza'];
$id=$_GET['id'];
$date=gmdate("Y-m-d H:i:s");
$id_user=$_SESSION['userId'];
$statusProses='';
switch(strtolower($_REQUEST['act'])) {
    case 'tambah':
		$ins="INSERT INTO b_napza (kunjungan_id,pelayanan_id,napza_terapi_id,status_nikah,ms_napza_id,usia_pakai_napza_id,napza_akibat_id,tgl_act,user_act,flag) VALUES ('$kunj_id','$idPel','$napTerapi','$stt_nikah','$napza','$usia_pakai','$akibat','$date','$id_user','$flag')";
		$r=mysql_query($ins);
    	break;
		case "update":
		$up="UPDATE  b_napza SET kunjungan_id='$kunj_id', pelayanan_id='$idPel', napza_terapi_id='$napTerapi', status_nikah='$stt_nikah', ms_napza_id='$napza', usia_pakai_napza_id='$usia_pakai', napza_akibat_id='$akibat', tgl_act='$date', user_act='$id_user', flag='$flag' WHERE id='$id'";
		mysql_query($up);
		break;
		case "hapus":
		$del="DELETE FROM b_napza WHERE id='$id'";
		mysql_query($del);
		break;
}

if($statusProses=='Error') {
    $dt="0".chr(5).chr(4).chr(5).strtolower($_REQUEST['act']);
}
else {
    if ($filter!="") {
        $filter=explode("|",$filter);
        $filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
    }
    if ($sorting=="") {
        $sorting='id_napza_master';
    }

    if($grd == "grdIsiDataRM"){
		$sql="SELECT
  a.id id_napza_master,
  a.status_nikah,
  b.id id_napza,
  b.napza,
  c.id id_akibat,
  c.akibat,
  d.id id_terapi,
  d.terapi,
  e.id id_usia,
  e.usia_pakai
FROM b_napza a
  INNER JOIN b_ms_napza b
    ON a.ms_napza_id = b.id
  INNER JOIN b_ms_napza_akibat c
    ON a.napza_akibat_id = c.id
  INNER JOIN b_ms_napza_terapi d
    ON a.napza_terapi_id = d.id
  INNER JOIN b_ms_napza_usia_pakai e
    ON a.usia_pakai_napza_id = e.id WHERE a.pelayanan_id='".$idPel."' $filter ORDER BY $sorting";
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
			$stt=array("1"=>"Kawin","2"=>"Belum Kawin","3"=>"Duda","4"=>"Janda");
            $sisip=$rows["id_napza_master"]."|".$rows["id_napza"]."|".$rows["id_akibat"]."|".$rows["id_terapi"]."|".$rows["id_usia"]."|".$rows["status_nikah"];
            $i++;
            $dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows["terapi"].chr(3).$stt[$rows["status_nikah"]].chr(3).$rows["napza"].chr(3).$rows["usia_pakai"].chr(3).$rows["akibat"].chr(6);
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
