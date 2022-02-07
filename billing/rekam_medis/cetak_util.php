<?
include("../koneksi/konek.php");
$idKunj = strtolower($_REQUEST["idKunj"]);
$idPel = strtolower($_REQUEST["idPel"]);
$status = strtolower($_REQUEST["status"]);
$idUser = strtolower($_REQUEST["idUser"]);

//echo $idKunj."&nbsp;".$idPel."&nbsp;".$status."&nbsp;".$idUser;

if($status=="rescetak")
{
	$query12="select * from b_print_res_rm where id_pelayanan='$idPel' and id_kunjungan='$idKunj'";
	$execQuery12=mysql_query($query12);
	$jmlQuery12=mysql_num_rows($execQuery12);
	
	if($jmlQuery12 > 0)
	{
		$query12="update b_print_res_rm set jml=jml+1, tgl_act=now(), user_act='$idUser' where id_pelayanan='$idPel' and id_kunjungan='$idKunj'";
	}else{
		$query12="insert into b_print_res_rm(id_pelayanan,id_kunjungan,user_act,tgl_act,jml) VALUES ('$idPel','$idKunj','$idUser',now(),1)";
	}
		echo $query12;
		$execQuery12=mysql_query($query12);
}
?>