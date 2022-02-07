<?php
include("../../koneksi/konek.php");

$id_pas=$_REQUEST['id_pas'];
 
$sqlA="SELECT * from b_riwayat_alergi
WHERE pasien_id='$id_pas'";//$idPel
$exA=mysql_query($sqlA);
while($dA=mysql_fetch_array($exA)){
	$dA['riwayat_alergi'];
	$pantangan = $dA['riwayat_alergi'];
}

$id=$_GET['id'];
//$pantangan=$_GET['pantangan'];
$permintaan=$_GET['permintaan'];
$biasa=$_GET['text_biasa'];
$tim=$_GET['text_tim'];
$lunak=$_GET['text_lunak'];
$saring=$_GET['text_saring'];
$cair=$_GET['text_cair'];
$puasa=$_GET['text_puasa'];
$penunggu=$_GET['penunggu'];
$keterangan=$_GET['keterangan'];
$id_pelayanan=$_GET['id_pel'];
$id_user=$_REQUEST['id_user'];

$chk=$_REQUEST['chk'];
for($i=0;$i<=11;$i++){
	$permintaan.=$chk[$i].',';
}
	
switch(strtolower($_REQUEST['act'])){
	case 'tambah':
		$sql="INSERT INTO b_permintaan_pelayanan_gizi VALUES ('','$pantangan','$permintaan','$biasa','$tim','$lunak','$saring','$cair','$puasa','$penunggu','$keterangan','$id_pelayanan',NOW(),'$id_user')";
		$ex=mysql_query($sql);
		//echo $sql;
		if($ex){
			echo "Data berhasil disimpan !";
		}else{
			echo "Data gagal disimpan !";
		}
	break;
		
	case 'edit':
		$sql="UPDATE b_permintaan_pelayanan_gizi SET pantangan='$pantangan', permintaan='$permintaan',d_biasa='$biasa',d_tim='$tim',d_lunak='$lunak',d_saring='$saring',d_cair='$cair',d_puasa='$puasa',d_penunggu='$penunggu', keterangan ='$keterangan' WHERE id='$id'";
		//echo $sql;
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil disimpan !";
		}else{
			echo mysql_error();
			echo "Data gagal disimpan !";
		}
	break;
	
	case 'hapus':
		$sql="DELETE FROM b_permintaan_pelayanan_gizi where id='$id'";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil dihapus !";
			}else{
				echo "Data gagal dihapus !";
				}
	break;
		
}
?>