<?php
include("../koneksi/konek.php");
//====================================================================

$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
$nama=$_REQUEST['txtRiwayatAlergi'];
$kode=$_REQUEST['kode_klasifikasi'];
$aktif=$_REQUEST['status'];
$id_klasifikasi=$_REQUEST['id_klasifikasi'];

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
		$sql="insert into b_ms_klasifikasi(kode,nama,aktif) values ('$kode','$nama','$aktif')";
		//echo $sql;
		mysql_query($sql);
	   	break;
	case 'simpan':
		$sql="update b_ms_klasifikasi set kode='".$kode."', nama='".$nama."', aktif='".$aktif."' where id='".$id_klasifikasi."'";
		mysql_query($sql);
	   	break;
	case 'hapus':
		$sql="delete from b_ms_klasifikasi where id='".$id_klasifikasi."'";
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

	$sql="SELECT * FROM b_ms_klasifikasi ".$filter." ORDER BY ".$sorting;   

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
	$pilih=array(1=>"Aktif",0=>"Tidak Aktif");

    while ($rows=mysql_fetch_array($rs)) {
		$i++;
		$dt.=$rows["id"]."|".$rows["nama"]."|".$rows["kode"]."|".$rows["aktif"].chr(3).number_format($i,0,",","").chr(3).$rows['kode'].chr(3).$rows['nama'].chr(3).$pilih[$rows["aktif"]].chr(6);
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
