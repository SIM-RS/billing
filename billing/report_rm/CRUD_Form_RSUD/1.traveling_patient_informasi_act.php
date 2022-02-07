<?php
include("../../koneksi/konek.php");

$act = $_REQUEST['act'];

$kunjungan_id = $_REQUEST['kunjungan_id'];
$pelayanan_id = $_REQUEST['pelayanan_id'];
$user_id = $_REQUEST['user_id'];

$diagnosa = $_REQUEST['diagnosa'];
$tindakan_perminggu = $_REQUEST['tindakan_perminggu'];
$lama_hd = $_REQUEST['lama_hd'];
$cairan_konsentrat = $_REQUEST['cairan_konsentrat'];
$bb_kering = $_REQUEST['bb_kering'];
$sarana_hubungan = $_REQUEST['sarana_hubungan'];
$kenaikan = $_REQUEST['kenaikan'];
$tkn_drh_sblm = $_REQUEST['tkn_drh_sblm'];
$tkn_drh_ssdh = $_REQUEST['tkn_drh_ssdh'];
$jns_dialiser = $_REQUEST['jns_dialiser'];
$kec_aliran = $_REQUEST['kec_aliran'];
$heparinasi = $_REQUEST['heparinasi'];
$dosis_awal = $_REQUEST['dosis_awal'];
$rhesusu = $_REQUEST['rhesusu'];
$trans_darah_trkhr = $_REQUEST['trans_darah_trkhr'];
$tgl_hasil_lab = tglSQL($_REQUEST['tgl_hasil_lab']);
$hb = $_REQUEST['hb'];
$ureum = $_REQUEST['ureum'];
$creatinin = $_REQUEST['creatinin'];
$phospor = $_REQUEST['phospor'];
$kalium = $_REQUEST['kalium'];
$hbsag = $_REQUEST['hbsag'];
$anti_hcv = $_REQUEST['anti_hcv'];
$anti_hiv = $_REQUEST['anti_hiv'];
$terapi1 = $_REQUEST['terapi1'];
$terapi2 = $_REQUEST['terapi2'];
$terapi3 = $_REQUEST['terapi3'];
$terapi4 = $_REQUEST['terapi4'];
$terapi5 = $_REQUEST['terapi5'];
$dterapi = $_REQUEST['dterapi'];

$dbaru = explode("||",$dterapi);
//echo count($dbaru);

if($act=='tambah')
{
	$q = "insert into lap_travelling(kunjungan_id,pelayanan_id,diagnosa,tindakan_perminggu,lama_hd,cairan_konsentrat,bb_kering,sarana_hubungan,kenaikan,tkn_drh_sblm,tkn_drh_ssdh,jns_dialiser,kec_aliran,heparinasi,dosis_awal,rhesusu,trans_darah_trkhr,tgl_hasil_lab,hb,ureum,creatinin,kalium,phospor,hbsag,anti_hcv,anti_hiv,terapi1,terapi2,terapi3,terapi4,terapi5,tgl_act,user_act) values('$kunjungan_id','$pelayanan_id','$diagnosa','$tindakan_perminggu','$lama_hd','$cairan_konsentrat','$bb_kering','$sarana_hubungan','$kenaikan','$tkn_drh_sblm','$tkn_drh_ssdh','$jns_dialiser','$kec_aliran','$heparinasi','$dosis_awal','$rhesusu','$trans_darah_trkhr','$tgl_hasil_lab','$hb','$ureum','$creatinin','$kalium','$phospor','$hbsag','$anti_hcv','$anti_hiv','$terapi1','$terapi2','$terapi3','$terapi4','$terapi5',CURDATE(),'$user_id')";
	$s = mysql_query($q);
	$nId = mysql_insert_id();
	
	for($ii=0;$ii<count($dbaru)-1;$ii++)
	{
		$qN="insert into b_detil_traveling(id_traveling,terapi) values($nId,'$dbaru[$ii]');";
		$execQN = mysql_query($qN);
	}
	
}	
else if($act=='edit')
{
	$id = $_REQUEST['id'];
	$q = "update lap_travelling set diagnosa='$diagnosa',tindakan_perminggu='$tindakan_perminggu',lama_hd='$lama_hd',cairan_konsentrat='$cairan_konsentrat',bb_kering='$bb_kering',sarana_hubungan='$sarana_hubungan',kenaikan='$kenaikan',tkn_drh_sblm='$tkn_drh_sblm',tkn_drh_ssdh='$tkn_drh_ssdh',jns_dialiser='$jns_dialiser',kec_aliran='$kec_aliran',heparinasi='$heparinasi',dosis_awal='$dosis_awal',rhesusu='$rhesusu',trans_darah_trkhr='$trans_darah_trkhr',tgl_hasil_lab='$tgl_hasil_lab',hb='$hb',ureum='$ureum',creatinin='$creatinin',kalium='$kalium',phospor='$phospor',hbsag='$hbsag',anti_hcv='$anti_hcv',anti_hiv='$anti_hiv',terapi1='$terapi1',terapi2='$terapi2',terapi3='$terapi3',terapi4='$terapi4',terapi5='$terapi5',tgl_act=CURDATE(),user_act='$user_id' where id='$id'";
	$s = mysql_query($q);
	
	$qdel = "delete from b_detil_traveling where id_traveling = '$id'";
	$execqdel = mysql_query($qdel);
	
	for($ii=0;$ii<=count($dbaru)-2;$ii++)
	{
		$qN="insert into b_detil_traveling(id_traveling,terapi) values($id,'$dbaru[$ii]');";
		$execQN = mysql_query($qN);
	}
	//echo $q;
}
else if($act=='hapus')
{
	$id = $_REQUEST['id'];
	$q = "delete from lap_travelling where id='$id'";
	$s = mysql_query($q);
}
//==========================================
if($s)
{
	echo "sukses";
}
else
{
	echo "gagal";
}
?>