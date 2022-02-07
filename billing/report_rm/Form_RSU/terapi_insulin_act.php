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
$tanggal = $_REQUEST['tanggal'];
$jam = $_REQUEST['jam'];
$jenis = $_REQUEST['jenis'];
$dosis = $_REQUEST['dosis'];
$gula = $_REQUEST['gula'];
$reduksi = $_REQUEST['reduksi'];
$ket = $_REQUEST['ket'];
$nama = $_REQUEST['nama'];

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
?>