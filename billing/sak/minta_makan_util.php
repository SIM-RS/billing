<?php 
session_start();
include("../koneksi/konek.php");
$userIdAskep=$_SESSION['userIdAskep'];
$grd = $_REQUEST["grd"];
$iduser = $_REQUEST["iduser"];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="kode";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
$idpas=$_REQUEST['idpas'];
if($idpas==0){
	$idPasien="0";
}else{
	$idPasien="$idpas";
}
$id=$_REQUEST['id'];
$id_pel=$_REQUEST['id_pel'];
$id_pas=$_REQUEST['id_pas'];
$id_kamar=$_REQUEST['id_kamar'];
$tgl=tglSQL($_REQUEST['tgl']);
$makanan=$_REQUEST['makanan'];
$ket=$_REQUEST['ket'];
$diterima=$_REQUEST['diterima'];

//===============================


//==============================
switch(strtolower($_REQUEST['act'])){
	case 'simpan':
		$sql1="INSERT INTO $dbgizi.gz_makan_harian (pelayanan_id,pasien_id,kamar_id,tgl,ms_menu_jenis_id,ket,diterima,user_act,tgl_act) VALUES ('$id_pel','$id_pas','$id_kamar','$tgl','$makanan','$ket','$diterima','$userIdAskep',now())";
		mysql_query($sql1);
		break;
	case 'update':
		$sql2="UPDATE $dbgizi.gz_makan_harian SET ms_menu_jenis_id='$makanan',ket='$ket', user_act='$userIdAskep',tgl_act=now() WHERE id='$id'";
		mysql_query($sql2);
		break;
	case 'hapus':
		$sql3="DELETE FROM $dbgizi.gz_makan_harian WHERE id='$id'";
		mysql_query($sql3);
		break;
}
if ($sorting==""){
	$sorting=$defaultsort;
}
if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}

$sql = "SELECT mh.id, mh.tgl, mj.id as id_makan, mj.nama, mh.ket
		FROM $dbgizi.gz_makan_harian mh
			INNER JOIN $dbgizi.gz_ms_menu_jenis mj ON mh.ms_menu_jenis_id = mj.id 
		WHERE pasien_id = $idPasien order by mh.tgl";

$perpage=100;
$rs=mysql_query($sql);
$jmldata=mysql_num_rows($rs);
if ($page=="" || $page=="0") $page=1;
$tpage=($page-1)*$perpage;
if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
if ($page>1) $bpage=$page-1; else $bpage=1;
if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
//$sql=$sql." limit $tpage,$perpage";
$rs=mysql_query($sql);
$i=($page-1)*$perpage;
$dt=$totpage.chr(5);

while ($rows=mysql_fetch_array($rs)){
	$id=$rows['id']."|".$rows['id_makan'];
	$i++;
	$dt.=$id.chr(3).$i.chr(3).tglSQL($rows["tgl"]).chr(3).$rows["nama"].chr(3).$rows['ket'].chr(6);
}

if ($dt!=$totpage.chr(5)){
	$dt=substr($dt,0,strlen($dt)-1);//.chr(5).strtolower($_REQUEST['act1'])."*|*".$msg;
	$dt=str_replace('"','\"',$dt);
}
mysql_free_result($rs);
mysql_close($konek);
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")){
	header("Content-type: application/xhtml+xml");
}else{
	header("Content-type: text/xml");
}
echo $dt;
?>