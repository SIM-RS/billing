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
	$idUsr=$_REQUEST['idUsr'];
	

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
				/*$sql="INSERT INTO b_fom_tolak_tind_medis(pelayanan_id,kunjungan_id,tindakan,terhadap,nama,umur,sex,alamat,no_tlp,no_ktp,dirawat,no_rm,resiko,tgl_act,user_act) VALUES('$idPel','$idKunj','$tind','$rad_thd','$txt_nama','$txt_umur','$rad_lp','$txt_alamat','$txt_tlp','$txt_ktp','$txt_rawat','$txt_rekam','$txt_resiko',CURDATE(),'$idUsr')";
		$ex=mysql_query($sql);*/
	break;
	case 'edit':
	break;
	case 'hapus':
	break;
		
}


	if ($filter!=""){
		$filter=explode("|",$filter);
		$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
	}
	
	if ($sorting==""){
		$sorting=$defaultsort;
	}
	
	$sql="SELECT b.*,bmp.no_rm,pp.nama AS nama_usr FROM 
	b_ms_pengkajian_pasien_anak b
LEFT JOIN b_pelayanan bp ON bp.id=b.pelayanan_id
LEFT JOIN b_ms_pasien bmp ON bmp.id=bp.pasien_id
LEFT JOIN b_ms_pegawai pp ON pp.id=b.user_act
WHERE b.pelayanan_id='$idPel' ".$filter." order by ".$sorting;

	
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
		$sisanya='|'.$rows["diperoleh"].'|'.$rows["jam"].'|'.$rows["dikirim"].'|'.$rows["nama_ibu"].'|'.$rows["umur_ibu"].'|'.$rows["nama_ayah"].'|'.$rows["umur_ayah"].'|'.$rows["agama"].'|'.$rows["status"].'|'.$rows["pekerjaan"].'|'.$rows["pendidikan"].'|'.$rows["alamat"].'|'.$rows["penyakit"].'|'.$rows["isi"].'|'.$rows["suhu"].'|'.$rows["tensi"].'|'.$rows["nadi"].'|'.$rows["teratur"].'|'.$rows["pulsasi"].'|'.$rows["rr"].'|'.$rows["teratur2"].'|'.$rows["pernafasan"].'|'.$rows["akral"].'|'.$rows["bb"].'|'.$rows["tb"].'|'.$rows["ld"].'|'.$rows["kesadaran"].'|'.$rows["lk"].'|'.$rows["lp"].'|'.$rows["nilai"].'|'.$rows["warna"].'|'.$rows["trugor"].'|'.$rows["alasan"].'|'.$rows["alergi"].'|'.$rows["sebut_alergi"].'|'.$rows["operasi"].'|'.$rows["sebut_operasi"].'|'.$rows["status1"].'|'.tglSQL($rows["tgl1"]).'|'.$rows["status2"].'|'.tglSQL($rows["tgl2"]).'|'.$rows["status3"].'|'.tglSQL($rows["tgl3"]).'|'.$rows["status4"].'|'.tglSQL($rows["tgl4"]).'|'.$rows["status5"].'|'.tglSQL($rows["tgl5"]).'|'.$rows["status6"].'|'.tglSQL($rows["tgl6"]).'|'.$rows["status7"].'|'.tglSQL($rows["tgl7"]).'|'.$rows["status8"].'|'.tglSQL($rows["tgl8"]).'|'.$rows["status9"].'|'.tglSQL($rows["tgl9"]).'|'.$rows["status10"].'|'.tglSQL($rows["tgl10"]).'|'.$rows["status11"].'|'.tglSQL($rows["tgl11"]).'|'.$rows["status12"].'|'.tglSQL($rows["tgl12"]).'|'.$rows["lama"].'|'.$rows["partus"].'|'.$rows["komplikasi"].'|'.$rows["sebut_kom"].'|'.$rows["neonatus"].'|'.$rows["sebut_neo"].'|'.$rows["maternal"].'|'.$rows["sebut_mate"].'|'.$rows["berat"].'|'.$rows["panjang"].'|'.$rows["asi"].'|'.$rows["formula"].'|'.$rows["susu"].'|'.$rows["cincang"].'|'.$rows["tim"].'|'.$rows["nasi"].'|'.$rows["bicara"].'|'.$rows["makanan"].'|'.$rows["porsi"].'|'.$rows["frekuensi"].'|'.$rows["tengurap"].'|'.$rows["duduk"].'|'.$rows["merangkak"].'|'.$rows["berdiri"].'|'.$rows["jalan"].'|'.$rows["penglihatan"].'|'.$rows["alat_bantu"].'|'.$rows["pendengaran"];
		$dt.=$rows["id"].'|'.tglSQL($rows['tgl']).$sisanya.chr(3).number_format($i,0,",","").chr(3).$rows["no_rm"].chr(3).tglSQL($rows["tgl"]).chr(3).$rows["jam"].chr(3).tglSQL($rows["tgl_act"]).chr(3).$rows["nama_usr"].chr(6);
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