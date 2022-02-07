<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="tgl_act";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$level = ($_REQUEST['level']=='')?1:$_REQUEST['level'];
$kodeAk=$_REQUEST["kodeAk"];
$nama = $_REQUEST['nama'];
$nama = str_replace(chr(5),'&',$nama);
if($_GET['ktgr'] == 4){
    $cakupan = $_GET['cakupan'];
}
else{
    $cakupan = 0;
}
//===============================
$statusProses='';
$alasan='';
	$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$tind=$_REQUEST['txt_tind'];
	$rad_thd=$_REQUEST['rad_thd'];
	$txt_nama=$_REQUEST['txt_nama'];
	$txt_umur=$_REQUEST['txt_umur'];
	$rad_lp=$_REQUEST['rad_lp'];
	$txt_alamat=$_REQUEST['txt_alamat'];
	$txt_tlp=$_REQUEST['txt_tlp'];
	$txt_ktp=$_REQUEST['txt_ktp'];
	$txt_rawat=$_REQUEST['txt_rawat'];
	$txt_rekam=$_REQUEST['txt_rekam'];
	$txt_resiko=$_REQUEST['txt_resiko'];
	$idUsr=$_REQUEST['idUsr'];
	



	if ($filter!=""){
		$filter=explode("|",$filter);
		$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
	}
	
	if ($sorting==""){
		$sorting=$defaultsort;
	}
	
	$sql="SELECT b.*,bp.nama FROM b_fom_resep_kcmata b 
LEFT JOIN b_ms_pegawai bp ON bp.id=b.user_act WHERE b.pelayanan_id='$idPel' ".$filter." order by ".$sorting;
	
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
	$thd=array(1=>'Sendiri',2=>'Suami',3=>'Istri',4=>'Ortu',5=>'Ayah',6=>'Ibu',7=>'Wali',8=>'Anak Saya');
	$rs=mysql_query($sql);
	$i=($page-1)*$perpage;
	$dt=$totpage.chr(5);
	
	while ($rows=mysql_fetch_array($rs)){
		$i++;
		$spher=explode(',',$rows['spher']);
		$cyl=explode(',',$rows['cyl']);
		$axis=explode(',',$rows['axis']);
		$prism=explode(',',$rows['prism']);
		$base=explode(',',$rows['base']);
		$spher2=explode(',',$rows['spher_2']);
		$cyl2=explode(',',$rows['cyl_2']);
		$axis2=explode(',',$rows['axis_2']);
		$prism2=explode(',',$rows['prism_2']);
		$base2=explode(',',$rows['base_2']);
		$jpupil=explode(',',$rows['jarak_pupil']);
		$dtx=$spher[0].'|'.$cyl[0].'|'.$axis[0].'|'.$prism[0].'|'.$base[0].'|'.$spher2[0].'|'.$cyl2[0].'|'.$axis2[0].'|'.$prism2[0].'|'.$base2[0]
		.'|'.$jpupil[0].'|'.$spher[1].'|'.$cyl[1].'|'.$axis[1].'|'.$prism[1].'|'.$base[1].'|'.$spher2[1].'|'.$cyl2[1].'|'.$axis2[1].'|'.$prism2[1].'|'.
		$base2[1].'|'.$jpupil[1];
		$dt.=$rows["id"].'|'.$dtx.$rows['terhadap'].chr(3).number_format($i,0,",","").chr(3)."RESEP KACAMATA".chr(3).$rows["nama"].chr(3).tglSQL($rows["tgl_act"]).chr(6);
	}
	
	if ($dt!=$totpage.chr(5)){
		$dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act']);
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