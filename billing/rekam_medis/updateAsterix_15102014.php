<body bgcolor="transparance">
<?
include("../koneksi/konek.php");
$in = $_REQUEST['in'];
$cp = $_REQUEST['cp'];
$id = $_REQUEST['id'];
$catatan = $_REQUEST['catatan'];
$id_degger = $_REQUEST['id_degger'];
$user_act = $_REQUEST['user_act'];

if($in=="true")
{
$que="INSERT INTO b_diagnosa_rm_act
(diagnosa_rm_id,catatan,tgl_act,user_act,ms_diagnosa_id_lama,diagnosa_id,degger_id,hapus)
SELECT '".$id_degger."','".$catatan."',NOW(),'".$user_act."',ms_diagnosa_id AS ms_diagnosa_id_lama,diagnosa_id,degger_id,'1' FROM b_diagnosa_rm WHERE id = '".$id."';";
	mysql_query($que);

$query = "DELETE FROM b_diagnosa_rm WHERE id='".$id."'";
	mysql_query($query);
}

if($cp=="true"){
if($id_degger!=""){
$que="INSERT INTO b_diagnosa_rm_act
(diagnosa_rm_id,catatan,tgl_act,user_act,ms_diagnosa_id_lama,diagnosa_id,degger_id,hapus)
/*SELECT '".$id_degger."','".$catatan."',NOW(),'".$user_act."',ms_diagnosa_id AS ms_diagnosa_id_lama,diagnosa_id,degger_id,'1' FROM b_diagnosa_rm WHERE id = '".$id."'*/
SELECT '".$id_degger."','Perubahan Pada Degger Sehingga Menghapus Asterix',NOW(),'".$user_act."',ms_diagnosa_id AS ms_diagnosa_id_lama,diagnosa_id,degger_id,'1' FROM b_diagnosa_rm WHERE degger_id = '".$id_degger."'";
	mysql_query($que);

$query = "DELETE FROM b_diagnosa_rm WHERE degger_id='".$id_degger."'";
	mysql_query($query);
}
}
?>
</body>