<?php
include("../koneksi/konek.php");
session_start();
include("../sesi.php");
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
$resiko=$_GET['resiko'];
$id=$_GET['id'];
$date=gmdate("Y-m-d H:i:s");
$id_user=$_SESSION['userId'];
$statusProses='';
switch(strtolower($_REQUEST['act'])) {
    case 'tambah':
		$ins="INSERT INTO b_pneumonia (kunjungan_id,pelayanan_id,faktor_resiko_id,tgl_act,user_act,flag) VALUES ('$kunj_id','$idPel','$resiko','$date','$id_user','$flag')";
		$r=mysql_query($ins);
    	break;
		case "update":
		$up="UPDATE b_pneumonia SET kunjungan_id='$kunj_id', pelayanan_id='$idPel',faktor_resiko_id='$resiko',tgl_act='$date',user_act='$id_user',flag='$flag' WHERE id='$id='";
		mysql_query($up);
		break;
		case "hapus":
		$del="DELETE FROM b_pneumonia WHERE id='$id'";
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
        $sorting='id';
    }

    if($grd == "grdIsiDataRM"){
		$sql="SELECT a.id,faktor_resiko_id,faktor_resiko FROM b_pneumonia a INNER JOIN b_ms_pneumonia_faktor_resiko b ON a.faktor_resiko_id=b.id WHERE a.pelayanan_id='".$idPel."' $filter ORDER BY $sorting";
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
            $sisip=$rows["id"]."|".$rows["faktor_resiko_id"];
            $i++;
            $dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows["faktor_resiko"].chr(6);
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
