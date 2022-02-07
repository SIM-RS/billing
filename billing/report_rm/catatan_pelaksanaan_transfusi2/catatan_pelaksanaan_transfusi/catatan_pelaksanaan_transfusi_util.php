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
	

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
				$sql="INSERT INTO b_fom_tolak_tind_medis(pelayanan_id,kunjungan_id,tindakan,terhadap,nama,umur,sex,alamat,no_tlp,no_ktp,dirawat,no_rm,resiko,tgl_act,user_act) VALUES('$idPel','$idKunj','$tind','$rad_thd','$txt_nama','$txt_umur','$rad_lp','$txt_alamat','$txt_tlp','$txt_ktp','$txt_rawat','$txt_rekam','$txt_resiko',CURDATE(),'$idUsr')";
		$ex=mysql_query($sql);
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
	
	$sql="SELECT b.*,bmp.nama,bmp.no_rm,bmp.nama,pp.nama AS nama_usr FROM b_ms_catatan_transfusi b
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
		$sisanya='|'.$rows['formulir'].'|'.$rows['jenis_darah'].'|'.$rows['alasan'].'|'.$rows['urutan1'].'|'.$rows['urutan2'].'|'.$rows['urutan3'].'|'.$rows['urutan4'].'|'.$rows['pre'].'|'.$rows['a_pemberian_pre'].'|'.$rows['kecepatan'].'|'.$rows['target'].'|'.$rows['pemeriksaan'].'|'.$rows['laporan'].'|'.$rows['dpjp'].'|'.$rows['nomor1'].'|'.$rows['utd1'].'|'.tglSQL($rows['tgl_k1']).'|'.$rows['js_darah1'].'|'.$rows['gol_darah1'].'|'.$rows['volume1'].'|'.$rows['nomor2'].'|'.$rows['utd2'].'|'.tglSQL($rows['tgl_k2']).'|'.$rows['js_darah2'].'|'.$rows['gol_darah2'].'|'.$rows['volume2'].'|'.$rows['nomor3'].'|'.$rows['utd3'].'|'.tglSQL($rows['tgl_k3']).'|'.$rows['js_darah3'].'|'.$rows['gol_darah3'].'|'.$rows['volume3'].'|'.$rows['nomor4'].'|'.$rows['utd4'].'|'.tglSQL($rows['tgl_k4']).'|'.$rows['js_darah4'].'|'.$rows['gol_darah4'].'|'.$rows['volume4'].'|'.$rows['jam1'].'|'.$rows['jam2'].'|'.$rows['jam3'].'|'.$rows['jam4'].'|'.$rows['kantong1'].'|'.$rows['pasien1'].'|'.$rows['k_kantong1'].'|'.$rows['transfusi1'].'|'.$rows['jam5'].'|'.$rows['jam6'].'|'.$rows['jam7'].'|'.$rows['jam8'].'|'.$rows['kantong2'].'|'.$rows['pasien2'].'|'.$rows['k_kantong2'].'|'.$rows['transfusi2'].'|'.$rows['jam9'].'|'.$rows['jam10'].'|'.$rows['jam11'].'|'.$rows['jam12'].'|'.$rows['kantong3'].'|'.$rows['pasien3'].'|'.$rows['k_kantong3'].'|'.$rows['transfusi3'].'|'.$rows['jam13'].'|'.$rows['jam14'].'|'.$rows['jam15'].'|'.$rows['jam16'].'|'.$rows['kantong4'].'|'.$rows['pasien4'].'|'.$rows['k_kantong4'].'|'.$rows['transfusi4'].'|'.$rows['nama1'].'|'.$rows['nama2'].'|'.$rows['nama3'].'|'.$rows['nama4'].'|'.$rows['nama5'].'|'.$rows['nama6'].'|'.$rows['nama7'].'|'.$rows['nama8'];
		$dt.=$rows["id"].'|'.tglSQL($rows['tgl']).$sisanya.chr(3).number_format($i,0,",","").chr(3).$rows["no_rm"].chr(3).$rows["nama"].chr(3).$rows["formulir"].chr(3).tglSQL($rows["tgl_act"]).chr(3).$rows["nama_usr"].chr(6);
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