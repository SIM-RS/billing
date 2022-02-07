<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
/*$page=$_REQUEST["page"];
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
	}*/
	$idPel=$_REQUEST['idPel'];
	$idUser=$_REQUEST['idUser'];
	$id=$_REQUEST['id'];
	$sql="SELECT a.*,peg.nama as nama2  
	FROM b_timeout_checklist a 
	LEFT JOIN b_ms_pegawai peg ON peg.id = a.user_act
	where pelayanan_id='$idPel'";
	//$sql="SELECT b.*,bp.nama as nm_usr FROM b_fom_neonatus_discharge b LEFT JOIN b_ms_pegawai bp ON bp.id=b.user_act WHERE b.pelayanan_id='$idPel' ".$filter." order by ".$sorting;
	
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
		$sisanya='|'.$rows["list_dokter_bedah"].'|'.$rows["komplikasi_kamar"].'|'.$rows["kehilangan_darah"].'|'.$rows["r_pemindahan_pasien"].'|'.$rows["antibiotik"].'|'.$rows["alergi"].'|'.$rows["pemindahan_pasien"].'|'.$rows["komplikasi_sebelum"];
		$dt.=$rows["id"].'|'.$rows['list_perawatan'].$sisanya.chr(3).number_format($i,0,",","").chr(3).$rows["komplikasi_kamar"].chr(3).$rows["kehilangan_darah"].chr(3).$rows["r_pemindahan_pasien"].chr(3).$rows["antibiotik"].chr(3).$rows["alergi"].chr(3).$rows["pemindahan_pasien"].chr(3).$rows["komplikasi_sebelum"].chr(3).tglSQL($rows["tgl_act"]).chr(3).$rows["nama2"].chr(6);
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