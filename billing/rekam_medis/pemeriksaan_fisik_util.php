<?php
include("../koneksi/konek.php");
//====================================================================

$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
$txt_urut_fisik=$_REQUEST['txt_urut_fisik'];
$txt_nama_fisik=$_REQUEST['txt_nama_fisik'];
$idpasien=$_REQUEST['idpasien'];
$userId=$_REQUEST['userId'];
$tipex=$_REQUEST['tipex'];
$id=$_REQUEST['id_periksa_fisik'];

$statusProses='';
switch(strtolower($_REQUEST['act'])) {
    case 'tambah':
		$sql="insert into anamnese_pilih(urut,nama,tipe) values ('".$txt_urut_fisik."','".$txt_nama_fisik."','".$tipex."')";
		mysql_query($sql);
	   	break;
	case 'simpan':
		$sql="update anamnese_pilih set urut='".$txt_urut_fisik."', nama='".$txt_nama_fisik."', tipe='".$tipex."' where id='".$id."'";
		mysql_query($sql);
	   	break;
	case 'hapus':
		$sql="delete from anamnese_pilih where id='".$id."'";
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

	$sql="select * from anamnese_pilih where tipe='".$tipex."' order by urut asc";   

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
		$dt.=$rows["id"]."|".$rows['urut']."|".$rows['nama'].chr(3).number_format($i,0,",","").chr(3).$rows['urut'].chr(3).$rows["nama"].chr(6);
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
