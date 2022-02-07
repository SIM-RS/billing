<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="user_act";
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
	}
	
	$sql="SELECT 
  b.*,
  peg.nama AS user_log,
  GROUP_CONCAT(md.nama) AS diag,
  IFNULL(peg.nama, '-') AS dokter,
  IFNULL(peg2.nama, '-') AS dr_rujuk,
  bpk.cara_keluar,
  DATE_FORMAT(bpk.tgl_act, '%d-%m-%Y') tgl_keluar  
FROM
  lap_surveilan_infeksi_noso b 
  LEFT JOIN b_pelayanan k 
    ON k.id = b.pelayanan_id 
  LEFT JOIN b_diagnosa diag 
    ON diag.pelayanan_id = k.id 
  LEFT JOIN b_ms_diagnosa md 
    ON md.id = diag.ms_diagnosa_id  
  LEFT JOIN b_ms_pegawai peg 
    ON peg.id = b.user_id 
  LEFT JOIN b_ms_pegawai peg2 
    ON peg2.id = k.dokter_id
  LEFT JOIN b_pasien_keluar bpk
    ON bpk.pelayanan_id = k.id 
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
	$antib_alasan='';
	$antib_alasan='';
	$jenis1='';
	$jenis2='';
	$jenis3='';
	$ruang1='';
	$ruang2='';
	$ruang3='';
	$catheter='';
	$urine_catheter='';
	$ngt='';
	$cvc='';
	$ett='';
	$lain='';
		
	while ($rows=mysql_fetch_array($rs)){
		$i++;
		$antib_alasan=explode('*|-',$rows['antib_alasan']);
		$jenis1=explode('*|-',$rows['jenis1']);
		$jenis2=explode('*|-',$rows['jenis2']);
		$jenis3=explode('*|-',$rows['jenis3']);
		$ruang1=explode('*|-',$rows['ruang1']);
		$ruang2=explode('*|-',$rows['ruang2']);
		$ruang3=explode('*|-',$rows['ruang3']);
		$catheter=explode('*|-',$rows['catheter']);
		$urine_catheter=explode('*|-',$rows['urine_catheter']);
		$ngt=explode('*|-',$rows['ngt']);
		$cvc=explode('*|-',$rows['cvc']);
		$ett=explode('*|-',$rows['ett']);
		$lain=explode('*|-',$rows['lain']);
		
		$sisanya=$antib_alasan[0].'|'.
		$antib_alasan[1].'|'.
		$jenis1[0].'|'.
		$jenis1[1].'|'.
		$jenis1[2].'|'.
		$jenis2[0].'|'.
		$jenis2[1].'|'.
		$jenis2[2].'|'.
		$jenis3[0].'|'.
		$jenis3[1].'|'.
		$jenis3[2].'|'.
		$ruang1[0].'|'.
		$ruang1[1].'|'.
		$ruang1[2].'|'.
		$ruang2[0].'|'.
		$ruang2[1].'|'.
		$ruang2[2].'|'.
		$ruang3[0].'|'.
		$ruang3[1].'|'.
		$ruang3[2].'|'.
		$catheter[0].'|'.
		$catheter[1].'|'.
		$catheter[2].'|'.
		$catheter[3].'|'.
		$catheter[4].'|'.
		$catheter[5].'|'.
		$catheter[6].'|'.
		$catheter[7].'|'.
		$urine_catheter[0].'|'.
		$urine_catheter[1].'|'.
		$urine_catheter[2].'|'.
		$urine_catheter[3].'|'.
		$urine_catheter[4].'|'.
		$urine_catheter[5].'|'.
		$urine_catheter[6].'|'.
		$urine_catheter[7].'|'.
		$ngt[0].'|'.
		$ngt[1].'|'.
		$ngt[2].'|'.
		$ngt[3].'|'.
		$ngt[4].'|'.
		$ngt[5].'|'.
		$ngt[6].'|'.
		$ngt[7].'|'.
		$cvc[0].'|'.
		$cvc[1].'|'.
		$cvc[2].'|'.
		$cvc[3].'|'.
		$cvc[4].'|'.
		$cvc[5].'|'.
		$cvc[6].'|'.
		$cvc[7].'|'.
		$ett[0].'|'.
		$ett[1].'|'.
		$ett[2].'|'.
		$ett[3].'|'.
		$ett[4].'|'.
		$ett[5].'|'.
		$ett[6].'|'.
		$ett[7].'|'.
		$lain[0].'|'.
		$lain[1].'|'.
		$lain[2].'|'.
		$lain[3].'|'.
		$lain[4].'|'.
		$lain[5].'|'.
		$lain[6].'|'.
		$lain[7];
		
		$dt.=$rows["id"].'|'.$sisanya.chr(3).number_format($i,0,",","").chr(3).$rows["tgl_keluar"].chr(3).$rows["cara_keluar"].chr(3).$rows["diag"].chr(3).tglSQL($rows["user_act"]).chr(3).$rows["user_log"].chr(6);
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