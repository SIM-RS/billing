<?
include "../koneksi/konek.php";
$user_id = $_REQUEST['kode_user'];
$q = mysqli_query($konek,"DELETE FROM a_menu_akses WHERE user_id='$user_id'");

foreach($_POST['id_menu'] as $menu_id)
{
	$q = "insert into a_menu_akses (user_id,menu_id)values('$user_id','$menu_id')";
	mysqli_query($konek,$q);
}
//echo "$id_group";
?>