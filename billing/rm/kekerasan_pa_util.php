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
$pelaku=$_GET['pelaku'];
$tgl=tglSQL($_GET['tgl']);
$jam=$_GET['jam'];
$dateKekerasan=$tgl." ".$jam;
$tmpt=$_GET['tmpt'];
$kekerasan=$_GET['kekerasan'];
$id=$_GET['id'];
$tipe=$_GET['tipe'];
$date=gmdate("Y-m-d H:i:s");
$id_user=$_SESSION['userId'];
$statusProses='';
switch(strtolower($_REQUEST['act'])) {
    case 'tambah':
		$ins="INSERT INTO b_kekerasan_pa (kunjungan_id,pelayanan_id,tgl,tempat,pelaku_id,kekerasan,tipe_kekerasan,tgl_act,user_act,flag) VALUES ('$kunj_id','$idPel','$dateKekerasan','$tmpt','$pelaku','$kekerasan','$tipe','$date','$id_user','$flag')";
		$r=mysql_query($ins);
    	break;
		case "update":
		$up="UPDATE b_kekerasan_pa SET kunjungan_id='$kunj_id', pelayanan_id='$idPel',tgl='$dateKekerasan',tempat='$tmpt',pelaku_id='$pelaku',kekerasan='$kekerasan',tipe_kekerasan='$tipe',tgl_act='$date',user_act='$id_user',flag='$flag' WHERE id='$id='";
		mysql_query($up);
		break;
		case "hapus":
		$del="DELETE FROM b_kekerasan_pa WHERE id='$id'";
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
        $sorting='tgl';
    }

    if($grd == "grdIsiDataRM"){
		$sql="SELECT a.id,tgl,pelaku_id,kekerasan,tipe_kekerasan,a.tempat,b.pelaku FROM b_kekerasan_pa a INNER JOIN b_ms_pelaku_kekerasan b ON a.pelaku_id=b.id WHERE a.pelayanan_id='".$idPel."' $filter ORDER BY $sorting";
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
			$stt=array("1"=>"Perempuan","2"=>"Anak");
            $sisip=$rows["id"]."|".$rows["pelaku_id"];
            $i++;
            $dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows["pelaku"].chr(3).$rows["tgl"].chr(3).$rows["tempat"].chr(3).$rows["kekerasan"].chr(3).$stt[$rows["tipe_kekerasan"]].chr(6);
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
