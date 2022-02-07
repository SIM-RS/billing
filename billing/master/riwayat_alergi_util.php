<?php
include("../koneksi/konek.php");
//====================================================================

$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
$txtRiwayatAlergi=$_REQUEST['txtRiwayatAlergi'];
$idpasien=$_REQUEST['idpasien'];
$userId=$_REQUEST['userId'];
$id_riwayat_alergi=$_REQUEST['id_riwayat_alergi'];
$klasifikasi=$_REQUEST['klasifikasi'];
$kode=$_REQUEST['kode'];
$nama=$_REQUEST['nama'];
$isAktif=$_REQUEST['isAktif'];

$statusProses='';
switch(strtolower($_REQUEST['act'])) {
	case 'view_last':
		$sql="select group_concat(riwayat_alergi SEPARATOR ', ') as riwayat_alergi from (select riwayat_alergi from b_riwayat_alergi where pasien_id='".$idpasien."' order by id desc) a ";
		$queri=mysql_query($sql);
		$rwRA=mysql_fetch_array($queri);
		echo $rwRA['riwayat_alergi'];
		return;
		break;
    case 'tambah':
		$sql="insert into b_ms_kelompok_tindakan(ms_klasifikasi_id,kode,nama,aktif) values ('".$klasifikasi."','".$kode."','".$nama."','".$isAktif."')";
		mysql_query($sql);
	   	break;
	case 'simpan':
		$sql="update b_riwayat_alergi set riwayat_alergi='".$txtRiwayatAlergi."', user_act='".$userId."', tgl_act=now() where id='".$id_riwayat_alergi."'";
		mysql_query($sql);
	   	break;
	case 'hapus':
		$sql="delete from b_riwayat_alergi where id='".$id_riwayat_alergi."'";
		mysql_query($sql);
	   	break;
}

    
   
if($statusProses=='Error') {
    $dt="0".chr(5).chr(4).chr(5).strtolower($_REQUEST['act'])."*|*".$_REQUEST["smpn"]."*|*".$_REQUEST["hps"]."*|*".$msg;
}
else {
    if ($filter!="") {
        $filter=explode("|",$filter);
        $filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
    }
	
    if ($sorting=="") {
        $sorting='id';
    }

	$sql="SELECT a.*, b.nama AS nm_klas
FROM b_ms_kelompok_tindakan a INNER JOIN b_ms_klasifikasi b ON a.ms_klasifikasi_id = b.id";   

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

    while ($rows=mysql_fetch_array($rs)) {
		$i++;
		$dt.=$rows["id"]."|".$rows["id"].chr(3).number_format($i,0,",","").chr(3).$rows['nm_klas'].chr(3).$rows["kode"].chr(3).$rows["nama"].chr(3).$rows["aktif"].chr(6);
    }

    if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act'])."*|*".$_REQUEST["smpn"]."*|*".$_REQUEST["hps"]."*|*".$dt_temp."*|*".$id_tindakan_radiologi."*|*".$tgl_resep;
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
