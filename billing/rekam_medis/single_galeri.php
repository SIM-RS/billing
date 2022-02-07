<?php
include '../koneksi/konek.php';
$id = $_REQUEST['id'];
if($_REQUEST['cek']=='1'){
	$query = "DELETE FROM b_upload_rm where id='".$_REQUEST['id2']."'";
	//echo $query;
	mysql_query($query);
}else{
?>

<span class="image-wrapper current" style="opacity: 1;"><a href="#" rel="history" class="advance-link">&nbsp;<img style="width:900px; height:600px;" alt="Sample" src="<?='ms_galeri_ambil.php?id='.$id?>"></a></span>

<?php }?>