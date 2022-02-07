<?php
include("../koneksi/konek.php");
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
	

/*switch(strtolower($_REQUEST['act'])){
	case 'tambah':
				$sql="INSERT INTO b_fom_tolak_tind_medis(pelayanan_id,kunjungan_id,tindakan,terhadap,nama,umur,sex,alamat,no_tlp,no_ktp,dirawat,no_rm,resiko,tgl_act,user_act) VALUES('$idPel','$idKunj','$tind','$rad_thd','$txt_nama','$txt_umur','$rad_lp','$txt_alamat','$txt_tlp','$txt_ktp','$txt_rawat','$txt_rekam','$txt_resiko',CURDATE(),'$idUsr')";
		$ex=mysql_query($sql);
	break;
	case 'edit':
	break;
	case 'hapus':
	break;
		
}
*/

	if ($filter!=""){
		$filter=explode("|",$filter);
		$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
	}
	
	if ($sorting==""){
		$sorting=$defaultsort;
	}
	
	$sql="SELECT b.*,bmp.no_rm,pp.nama AS nama_usr FROM 
	b_fom_rekam_medis_hd b
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
		//$sisanya='|'.$rows["pernafasan"].'|'.$rows["nadi"].'|'.$rows["suhu"].'|'.$rows["nutrisi"].'|'.$rows["_diet"].'|'.$rows["_batas"].'|'.$rows["bab"].'|'.$rows["bak"].'|'.tglSQL($rows["_tgl"]).'|'.$rows["bab"].'|'.$rows["_tinggi"].'|'.$rows["vulva"].'|'.$rows["lochea"].'|'.$rows["_warna"].'|'.$rows["_bau"].'|'.$rows["luka"].'|'.$rows["_cairan"].'|'.$rows["transfer"].'|'.$rows["alat"].'|'.$rows["_lain"].'|'.$rows["edukasi"].'|'.$rows["diagnosa1"].'|'.$rows["diagnosa2"].'|'.$rows["anjuran1"].'|'.$rows["anjuran2"].'|'.$rows["anjuran3"].'|'.$rows["anjuran4"].'|'.$rows["lab"].'|'.$rows["foto"].'|'.$rows["scan"].'|'.$rows["mri"].'|'.$rows["usg"].'|'.$rows["surat"].'|'.$rows["surat_a"].'|'.$rows["summary"].'|'.$rows["buku"].'|'.$rows["kartu"].'|'.$rows["skl"].'|'.$rows["serah"].'|'.$rows["lain"].'|'.$rows["hasil1"].'|'.$rows["hasil2"].'|'.$rows["hasil3"].'|'.$rows["hasil4"].'|'.$rows["hasil5"];
		$sisanya='|'.tglSQL($rows["tgl"]).'|'.$rows["hd_ke"].'|'.$rows["mesin"].'|'.$rows["type"].'|'.$rows["td_tidur"].'|'.$rows["duduk"].'|'.$rows["dosis_awal1"].'|'.$rows["dosis_lanjut"].'|'.$rows["dosis_awal2"].'|'.$rows["nadi"].'|'.$rows["respirasi"].'|'.$rows["suhu"].'|'.$rows["lama_hd"].'|'.$rows["jam_mulai"].'|'.$rows["jam_selesai"].'|'.$rows["p_volume"].'|'.$rows["p_keluar"].'|'.$rows["keluhan"].'|'.$rows["bbs"].'|'.$rows["bbpre"].'|'.$rows["bbpo"].'|'.$rows["lain"].'|'.$rows["perawat1"].'|'.$rows["perawat2"].'|'.$rows["td_tidur2"].'|'.$rows["duduk2"].'|'.$rows["nadi2"].'|'.$rows["respirasi2"].'|'.$rows["suhu2"].'|'.$rows["keluhan2"].'|'.$rows["sisa"].'|'.$rows["infus"].'|'.$rows["tran"].'|'.$rows["bilas"].'|'.$rows["minum"].'|'.$rows["urine"].'|'.$rows["muntah"].'|'.$rows["uf"].'|'.$rows["jumlah"].'|'.$rows["jumlah2"].'|'.$rows["total"].'|'.$rows["bb_pulang"].'|'.$rows["penekanan"].'|'.$rows["perawat11"].'|'.$rows["perawat22"].'|'.$rows["ket_res"].'|'.$rows["td"].'|'.$rows["n"].'|'.$rows["p"].'|'.$rows["s"].'|'.$rows["ket_res2"].'|'.$rows["ket_res3"].'|'.$rows["ket_manmin"].'|'.$rows["ket_manmin2"].'|'.$rows["ket_manmin3"].'|'.$rows["ket_kulit"].'|'.$rows["ket_eli"].'|'.$rows["ket_eli2"].'|'.$rows["ket_tdristrht"].'|'.$rows["therapy"].'|'.$rows["therapy2"].'|'.$rows["therapy3"].'|'.$rows["therapy4"].'|'.$rows["therapy5"].'|'.$rows["therapy6"].'|'.$rows["therapy7"].'|'.$rows["therapy8"].'|'.$rows["therapy9"].'|'.$rows["therapy10"].'|'.$rows["therapy11"].'|'.$rows["therapy12"].'|'.$rows["therapy13"].'|'.$rows["therapy14"].'|'.$rows["stop_jam"].'|'.$rows["td2"].'|'.$rows["p2"].'|'.$rows["n2"].'|'.$rows["s2"].'|'.$rows["jenis_hd"].'|'.$rows["sarana"].'|'.$rows["isi"];
		$dt.=$rows["id"].$sisanya.chr(3).number_format($i,0,",","").chr(3).$rows["no_rm"].chr(3).$rows["keluhan"].chr(3).tglSQL($rows["tgl_act"]).chr(3).$rows["nama_usr"].chr(6);
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