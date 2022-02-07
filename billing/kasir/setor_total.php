<?php 
include("../koneksi/konek.php");
$grd = $_REQUEST["grd"];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="id";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$filter1=$_REQUEST["filter"];
//===============================
$tgl_a=tglSQL($_GET['tgl_a']);
$tgl_b=tglSQL($_GET['tgl_b']);
$kasir=$_GET['kasir'];
$user_act=$_GET['user_act'];
$tgl_setor=tglSQL($_GET['tgl_setor']);
$user_setor=$_GET['user_setor'];
$data=$_REQUEST['data'];
//===============================

if($tgl_a!='--'&&$tgl_b!='--'){
$tgl_d = "AND a.tgl BETWEEN '$tgl_a' AND '$tgl_b'";
}
if($kasir!=''){
$kasir_d = "and kasir_id = '$kasir'";
}
if($user_act!='0'){
$user_d = "and a.user_act = '$user_act'";
}
switch($grd){
	case "kiri":
	$sql="select sum(a.nilai) from b_bayar a 
inner join b_kunjungan b on b.id=a.kunjungan_id
inner join b_ms_pasien c on b.pasien_id=c.id 
WHERE ISNULL(a.disetor_tgl) $kasir_d $user_d $tgl_d";
	break;
	case "kanan":
	$sql="select sum(a.nilai) from b_bayar a 
inner join b_kunjungan b on b.id=a.kunjungan_id
inner join b_ms_pasien c on b.pasien_id=c.id 
inner join b_ms_pegawai d on d.id=a.disetor_oleh
WHERE a.disetor_tgl IS NOT NULL AND a.disetor_tgl='$tgl_setor'$kasir_d $user_d $tgl_d";
	break;
}
//echo $sql;
$rw = mysql_query($sql);
$sqlhasil=mysql_fetch_array($rw);
//echo mysql_error();
echo "<b>Total : ".number_format($sqlhasil[0],0,'.','.')."</b>";

?>