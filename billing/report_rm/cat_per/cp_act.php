<?php
include("../../koneksi/konek.php");

$list_hapus = $_REQUEST['list_hapus'];
if($list_hapus!="")
{
	$list = explode(",",$list_hapus);
	$tot = count($list);
	for($i=1;$i<$tot;$i++)
	{
		mysql_query("delete from b_ms_cp where id='$list[$i]'");
	}
}


$id_kunjungan = $_REQUEST['id_kunjungan'];
$id_pelayanan = $_REQUEST['id_pelayanan'];
$tgl_ctx = $_REQUEST['tgl_ct'];
$prof_ct = $_REQUEST['prof_ct'];
$hasil_ct = $_REQUEST['hasil_ct'];
$instruksi_ct = $_REQUEST['instruksi_ct'];
$veri_ct = $_REQUEST['veri_ct'];


if(isset($_REQUEST['id_ct']))
{
	$id = $_REQUEST['id_ct']; //mencatat idnya
	$user_act = $_REQUEST['user_ct']; //mencatat user_act sebelumnya
}



$total = count($_REQUEST['tgl_ct']);
for($i=0;$i<$total;$i++)
{
	if(isset($id[$i]) && $id[$i]!="")
	{
		$user_act = $_REQUEST['user_ct'];
		$tgl_ct = tglJamSQL($tgl_ctx[$i]);
				
		$query = "update b_ms_cp set id_kunjungan='$id_kunjungan', id_pelayanan='$id_pelayanan', tgl_ct='$tgl_ct', prof_ct='$prof_ct[$i]', hasil_ct='$hasil_ct[$i]',instruksi_ct='$instruksi_ct[$i]', veri_ct='$veri_ct[$i]', user_act='$user_act[$i]' where id='$id[$i]'";
		mysql_query($query);
	}
	else
	{
		$user_act = $_REQUEST['idUsr_ct'];
		$tgl_ct = tglJamSQL($tgl_ctx[$i]);
		
		$query = "insert into b_ms_cp (id_kunjungan,id_pelayanan,tgl_ct,prof_ct,hasil_ct,instruksi_ct,veri_ct, user_act) values ('$id_kunjungan','$id_pelayanan','$tgl_ct','$prof_ct[$i]','$hasil_ct[$i]','$instruksi_ct[$i]','$veri_ct[$i]', '$user_act')"; //
		mysql_query($query);
	}
	//echo $query;
}

echo "sukses";
/*if($act=='tambah')
{
	$q = "insert into b_ms_sk(id_pelayanan,id_kunjungan,tgl_mati,jam_mati,tgl_periksa,user_act) values('$id_pelayanan','$id_kunjungan','$tgl_mati','$jam_mati','$tgl_periksa','$user_act')";
	$s = mysql_query($q);
	//echo $q;
}	
else if($act=='edit')
{
	$id = $_REQUEST['id_mati'];
	$q = "update b_ms_sk set tgl_mati='$tgl_mati',jam_mati='$jam_mati',tgl_periksa='$tgl_periksa' where id='$id'";
	$s = mysql_query($q);
	
}
else if($act=='hapus')
{
	$id = $_REQUEST['id_mati'];
	$q = "delete from b_ms_sk where id='$id'";
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
}*/
?>
