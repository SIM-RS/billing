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
$bb = $_REQUEST["txtbb"];
$tb = $_REQUEST["txttb"];
$bb_tb = $_REQUEST["txtbbtb"];
$asupan_makanan = $_REQUEST["txtAsupanMakan"];
$kesan = $_REQUEST["txtKesan"];
$asuhan_gizi_lanjut = $_REQUEST["txtAsuhanGiziLanjut"];
$diagnosa_penyakit = $_REQUEST["txtDiagPeny"];
$diit_dokter = $_REQUEST["txtDiitDokter"];
$tgl_act = gmdate('Y-m-d H:i:s');
$user_act = $_SESSION['userId'];

$statusProses='';
switch(strtolower($_REQUEST['act'])) {
    case 'tambah':
		$kueri="INSERT b_asuhan_gizi_anak (kunjungan_id,pelayanan_id,bb,tb,bb_tb,asupan_makanan,kesan,asuhan_gizi_lanjut,diagnosa_penyakit,diit_dokter,tgl_act,user_act,flag) VALUES ('$kunjId','$idPel','$bb','$tb','$bb_tb','$asupan_makanan','$kesan','$asuhan_gizi_lanjut','$diagnosa_penyakit','$diit_dokter','$tgl_act','$user_act','$flag')";
		$k=mysql_query($kueri);
		if($k){
			echo "<script>alert('Data Berhasil Ditambah...')</script>";
		}else{
			echo "<script>alert('Gagal !');</script>";
		}
    	break;
	case 'simpan':
		$qq="UPDATE b_asuhan_gizi_anak SET bb='$bb',tb='$tb',bb_tb='$bb_tb',asupan_makanan='$asupan_makanan',kesan='$kesan',asuhan_gizi_lanjut='$asuhan_gizi_lanjut',diagnosa_penyakit='$diagnosa_penyakit',diit_dokter='$diit_dokter',tgl_act='$tgl_act',user_act='$user_act',flag='$flag' WHERE id=".$id;
		$q=mysql_query($qq);
		if($q){
			echo "<script>alert('Data Berhasil Diubah...')</script>";
		}else{
			echo "<script>alert('Gagal !');</script>";
		}
		break;
	case 'hapus':
		$delet = "DELETE FROM b_asuhan_gizi_anak WHERE id=".$id;
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
		$sql="select * from b_asuhan_gizi_anak where pelayanan_id=".$idPel;
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
            $sisip=$rows["id"];
            $i++;
            $dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows["bb"].chr(3).$rows["tb"].chr(3).$rows["bb_tb"].chr(3).$rows["asupan_makanan"].chr(3).$rows["kesan"].chr(3).$rows["asuhan_gizi_lanjut"].chr(3).$rows["diagnosa_penyakit"].chr(3).$rows["diit_dokter"].chr(6);
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
