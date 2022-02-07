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
$dosis = $_REQUEST["dosis"];
$vaks = $_REQUEST["vaks"];
$tglDemam = tglSQL($_REQUEST["tglDemam"]);
$tglRash = tglSQL($_REQUEST["tglRash"]);
$vita = $_REQUEST["vita"];
$keadaan = $_REQUEST["keadaan"];
$tgl_act = gmdate('Y-m-d H:i:s');
$user_act = $_SESSION['userId'];

$statusProses='';
switch(strtolower($_REQUEST['act'])) {
    case 'tambah':
		$kueri="INSERT b_campak (kunjungan_id,pelayanan_id,dosis,vaks_terakhir_id,tgl_demam,tgl_rash,vitA,keadaan_pulang,tgl_act,user_act,flag) VALUES ('$kunjId','$idPel','$dosis','$vaks','$tglDemam','$tglRash','$vita','$keadaan','$tgl_act','$user_act','$flag')";
		$k=mysql_query($kueri);
		if($k){
			echo "<script>alert('Data Berhasil Ditambah...')</script>";
		}else{
			echo "<script>alert('Gagal !');</script>";
		}
    	break;
	case 'simpan':
		$qq="UPDATE b_campak SET dosis='$dosis',vaks_terakhir_id='$vaks',tgl_demam='$tglDemam',tgl_rash='$tglRash',vitA='$vita',keadaan_pulang='$keadaan',tgl_act='$tgl_act',user_act='$user_act',flag='$flag' WHERE id=".$id;
		$q=mysql_query($qq);
		if($q){
			echo "<script>alert('Data Berhasil Diubah...')</script>";
		}else{
			echo "<script>alert('Gagal !');</script>";
		}
		break;
	case 'hapus':
		$delet = "DELETE FROM b_campak WHERE id=".$id;
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
		$sql="SELECT c.id as idC,c.dosis,c.vaks_terakhir_id,v.vaks_terakhir,c.tgl_demam,c.tgl_rash,if(c.vitA=1,'Ya','Tidak')as vit,if(c.keadaan_pulang=1,'Hidup','Mati')as kead
FROM b_campak c
  INNER JOIN b_ms_vaks_terakhir v
    ON c.vaks_terakhir_id = v.id WHERE c.pelayanan_id=".$idPel;
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
            $sisip=$rows["idC"];
            $i++;
            $dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows["dosis"].chr(3).$rows["vaks_terakhir"].chr(3).tglSQL($rows["tgl_demam"]).chr(3).tglSQL($rows["tgl_rash"]).chr(3).$rows["vit"].chr(3).$rows["kead"].chr(6);
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
