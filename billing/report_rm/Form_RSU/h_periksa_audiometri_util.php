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
	$ket_klinis=$_REQUEST['ket_klinis'];
	$hasil=$_REQUEST['hasil'];
	$audio=$_REQUEST['audio'];
	$speech=$_REQUEST['speech'];
	$kesimpulan=$_REQUEST['periksa_k'];
	$saran=$_REQUEST['saran'];
	$kk=$_REQUEST['kk'];
	$idUsr=$_REQUEST['idUsr'];
	

/*switch(strtolower($_REQUEST['act'])){
	case 'tambah':
				$sql="INSERT INTO b_fom_tolak_tind_medis(pelayanan_id,kunjungan_id,tindakan,terhadap,nama,umur,sex,alamat,no_tlp,no_ktp,dirawat,no_rm,resiko,tgl_act,user_act) VALUES('$idPel','$idKunj','$tind','$rad_thd','$txt_nama','$txt_umur','$rad_lp','$txt_alamat','$txt_tlp','$txt_ktp','$txt_rawat','$txt_rekam','$txt_resiko',CURDATE(),'$idUsr')";
		$ex=mysql_query($sql);
	break;
	case 'edit':
	break;
	case 'hapus':
	break;
		
}*/


	if ($filter!=""){
		$filter=explode("|",$filter);
		$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
	}
	
	if ($sorting==""){
		$sorting=$defaultsort;
	}
	
	$sql="SELECT b.*,bmp.nama AS nm_pasien,bmp.no_rm,pp.nama AS nama_usr FROM b_fom_hasil_audiometri b
LEFT JOIN b_pelayanan bp ON bp.id=b.pelayanan_id
LEFT JOIN b_ms_pasien bmp ON bmp.id=bp.pasien_id
LEFT JOIN b_ms_pegawai pp ON pp.id=b.user_act
WHERE b.pelayanan_id='$idPel' ".$filter." order by ".$sorting;
	
	$sql."<br>";
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
		$sisanya=$rows['ket_klinis'].'|'.$rows['hasil'].'|'.$rows["audio"].'|'.$rows['speech'].'|'.$rows['kesimpulan'].'|'.$rows['periksa_k'].'|'.$rows['saran'].'|'.$rows['kk'].'|'.$rows['dr_act'];
		$dt.=$rows["id"].'|'.$sisanya.chr(3).number_format($i,0,",","").chr(3).$rows["no_rm"].chr(3).$rows["nm_pasien"].chr(3).$rows["ket_klinis"].chr(3).$rows["hasil"].chr(3).$rows["audio"].chr(3).$rows["speech"].chr(3).$rows["kesimpulan"].chr(3).$rows["periksa_k"].chr(3).tglSQL($rows["tgl_act"]).chr(3).$rows["nama_usr"].chr(6);
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