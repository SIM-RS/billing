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
	$idUser=$_REQUEST['idUser'];


	if ($filter!=""){
		$filter=explode("|",$filter);
		$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
	}
	
	if ($sorting==""){
		$sorting=$defaultsort;
	}
	
	$sql="SELECT a.*, b.nama,pp.`nama` AS nama_user, b.`no_rm`,
		( a.volume_priming + a.cairan_keluar + a.sisa_priming + a.cairan_drip + a.darah + a.wash_out ) jml,
		( a.urine + a.muntah + a.ultra ) Ojml
	FROM `b_ms_hemodialisis` a
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
		$sisip=$rows['id'].'|'.$rows['checked'].'|'.tglSQL($rows['tanggal1']).'|'.$rows['pukul1'].'|'.$rows['riwayat'].'|'.$rows['bmi'].'|'.$rows['mata'].'|'.$rows['bb_pre_hd'].'|'.$rows['bb_post_hd'].'|'.$rows['iwg'].'|'.$rows['lama'].'|'.$rows['qb_program'].'|'.$rows['qd_program'].'|'.$rows['ufg_program'].'|'.$rows['dosis_awal'].'|'.$rows['maintenance'].'|'.$rows['mesin_no'].'|'.$rows['jenis_dialiser'].'|'.$rows['tipe_dialiser'].'|'.$rows['volume_priming'].'|'.$rows['cairan_keluar'].'|'.$rows['sisa_priming'].'|'.$rows['cairan_drip'].'|'.$rows['darah'].'|'.$rows['wash_out'].'|'.$rows['jumlah'].'|'.$rows['jenis_transfusi'].'|'.$rows['jumlah_transfusi'].'|'.$rows['no_seri1'].'|'.$rows['no_seri2'].'|'.$rows['no_seri3'].'|'.$rows['laboratorium'].'|'.$rows['foto_thorax'].'|'.$rows['ekg'].'|'.$rows['jam_pemberian'].'|'.$rows['kondisi_setelah'].'|'.$rows['jam_setelah'].'|'.$rows['td_setelah'].'|'.$rows['nadi_setelah'].'|'.$rows['suhu_setelah'].'|'.$rows['rr_setelah'].'|'.$rows['catatan_hemodialisis1'].'|'.$rows['catatan_hemodialisis2'].'|'.tglSQL($rows['tgl_selanjutnya']).'|'.$rows['jam_selanjutnya'].'|'.$rows['terapi'].'|'.$rows['hemodialisis_pertama'].'|'.$rows['hemodialisis_terakhir'].'|'.$rows['dializer'].'|'.$rows['jenis_dialisat'].'|'.$rows['lama_dialisis'].'|'.$rows['kecepatan_darah'].'|'.$rows['akses_vaskuler'].'|'.$rows['heparinisasi'].'|'.$rows['transfusi_terakhir'].'|'.$rows['lab_terakhir'].'|'.tglSQL($rows['tgl_traveling']).'|'.$rows['hb_traveling'].'|'.$rows['ureum_traveling'].'|'.$rows['hiv_traveling'].'|'.$rows['gds_traveling'].'|'.$rows['creatinin_traveling'].'|'.$rows['hbs_traveling'].'|'.$rows['hcv_traveling'].'|'.$rows['catatan'].'|'.$rows['urine'].'|'.$rows['muntah'].'|'.$rows['ultra'].'|'.$rows['jml'].'|'.$rows['Ojml'].'|'.$rows['bbkering'].'|'.$rows['minum'].'|'.$rows['dokter'].'|'.$rows['reuse'];
		$dt.=$sisip.chr(3).$i.chr(3).$rows["no_rm"].chr(3).$rows["nama"].chr(3).tglSQL($rows["tgl_act"]).chr(3).$rows["nama_user"].chr(6);
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