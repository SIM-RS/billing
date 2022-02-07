<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="cek.profil_detail_id DESC";
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
	$idUser=$_REQUEST['idUser'];
	
switch(strtolower($_REQUEST['act'])){
	case 'tambah':
	break;
	case 'edit':
	break;
	case 'hapus':
	break;
		
}

	if ($filter!=""){
		$filter=explode("|",$filter);
		$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
	}
	
	if ($sorting==""){
		$sorting=$defaultsort;
	}
	
	$sql="SELECT * from (SELECT bp.*, mp.nama AS pengguna, pd.*
		  FROM b_profil_b bp 
		  INNER JOIN b_profil_detail pd ON pd.kode_b_profil = bp.kode
		  INNER JOIN b_ms_pegawai mp ON mp.id = pd.user_act) AS cek
		  ".$filter." order by ".$sorting;
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
	//$thd=array(1=>'Sendiri',2=>'Suami',3=>'Istri',4=>'Ortu',5=>'Ayah',6=>'Ibu',7=>'Wali',8=>'Anak Saya');
	$rs=mysql_query($sql);
	$i=($page-1)*$perpage;
	$dt=$totpage.chr(5);

	while ($rows=mysql_fetch_array($rs)){
		$i++;
		//$sisanya='|'.tglSQL($rows["tgl"]).'|'.$rows["istirahat"].'|'.tglSQL($rows["tgl_mulai"]).'|'.tglSQL($rows["tgl_akhir"]).'|'.$rows["inap"].'|'.tglSQL($rows["tgl_mulai2"]).'|'.tglSQL($rows["tgl_akhir2"]).'|'.tglSQL($rows["tgl_per"]).'|'.$rows["note"].'|'.$rows["pilihan"];
		$sisanya='|'.$rows["kode_rs"].'|'.tglSQL($rows["tgl_registrasi"]).'|'.$rows["jenis_rs"].'|'.$rows["kelas_rs"]
				.'|'.$rows["direktur_rs"].'|'.$rows["penyelenggara_rs"].'|'.$rows["humas_rs"].'|'.$rows["website"]
				.'|'.$rows["tanah"].'|'.$rows["bangunan"].'|'.$rows["nomor"].'|'.tglSQL($rows["tgl_penetapan"])
				.'|'.$rows["oleh"].'|'.$rows["sifat"].'|'.$rows["tahun"].'|'.$rows["status_peny_swas"]
				.'|'.$rows["pentahapan"].'|'.$rows["status"].'|'.tglSQL($rows["tgl_akreditasi"]).'|'.$rows["ruang_operasi"]
				.'|'.$rows["d_sub_spes"].'|'.$rows["d_spes_lain"].'|'.$rows["farmasi"].'|'.$rows["t_kes_lain"].'|'.$rows["t_non_kes"];
		
		$dt .= $rows["profil_detail_id"].$sisanya. chr(3)
			.number_format($i,0,",","").chr(3)
			.$rows["nama"]. chr(3)
			.tglSQL($rows["tgl_act"]). chr(3)
			.$rows["pengguna"]. chr(6);
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