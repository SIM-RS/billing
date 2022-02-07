<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="b.tgl_act";
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
	$idUser=$_REQUEST['idUser'];


	if ($filter!=""){
		$filter=explode("|",$filter);
		$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
	}
	
	if ($sorting==""){
		$sorting=$defaultsort;
	}
	
	$sql="SELECT a.*, b.nama,pp.`nama` AS nama_user FROM `b_form_catatan_penghitung` a
	LEFT JOIN b_pelayanan bp ON bp.`id`=a.`id_pelayanan`
	LEFT JOIN `b_ms_pasien` b ON b.id=bp.`pasien_id`
	LEFT JOIN b_ms_pegawai pp ON pp.id=b.`user_act`
	WHERE a.`id_pelayanan`='$idPel' ".$filter." order by ".$sorting;
	
	
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
	
	while ($rows=mysql_fetch_array($rs)){
		$i++;
		$sisip=$rows['id'].'|'.$rows['ahli_bedah'].'|'.$rows['perawat_instrumen'].'|'.$rows['perawat_sirkuler'].'|'.tglSQL($rows['tanggal']).'|'.$rows['jam_mulai'].'|'.$rows['jam_selesai'].'|'.$rows['jumlah_kasa'].'|'.$rows['jumlah_jarum'].'|'.$rows['jumlah_instrumen'].'|'.$rows['jumlah_pisau'].'|'.$rows['tgl_act'].'|'.$rows['user_act'];
		$dt.=$sisip.chr(3).$i.chr(3).$rows["nama"].chr(3).$rows["jenis_operasi"].chr(3).$rows["ruang_operasi"].chr(3).tglSQL($rows["tgl_act"]).chr(3).$rows["nama_user"].chr(6);
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