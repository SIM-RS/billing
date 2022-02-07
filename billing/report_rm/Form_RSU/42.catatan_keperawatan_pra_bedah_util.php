<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="b.tgl_act";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$idPel=$_REQUEST['idPel'];
$idKunj=$_REQUEST['idKunj'];
$idUser=$_REQUEST['idUser'];

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){
	$sorting=$defaultsort;
}
	
	$sql="SELECT a.*, b.nama,pp.`nama` AS nama_user FROM `b_form_catatan_pra_bedah` a
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
		$sisip=$rows['id'].'*'.$rows['ruang'].'*'.$rows['tindakan'].'*'.$rows['jam_persiapan'].'*'.$rows['lapangan_operasi'].'*'.$rows['puasa'].'*'.$rows['ijin_operasi'].'*'.$rows['TD'].'*'.$rows['kateter'].'*'.$rows['infus'].'*'.$rows['huknah'].'*'.$rows['obat_pramedikasi'].'*'.$rows['barang_berharga'].'*'.$rows['tata_rias'].'*'.$rows['gigi_palsu'].'*'.$rows['hasil_ekg'].'*'.$rows['status_lengkap'].'*'.$rows['darah_dan_golongan'].'*'.$rows['konsul_anastesi'].'*'.$rows['konsul_kardiologi'].'*'.$rows['konsul_penyakit'].'*'.$rows['konsul_paru'].'*'.$rows['konsul_anak'].'*'.$rows['pemasangan_label'];
		
		$dt.=$sisip.chr(3).$i.chr(3).$rows["nama"].chr(3).tglSQL($rows["tgl_operasi"]).chr(3).$rows["perawat_kamar"].chr(3).$rows["perawat_ruangan"].chr(3).tglSQL($rows["tgl_act"]).chr(3).$rows["nama_user"].chr(6);
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