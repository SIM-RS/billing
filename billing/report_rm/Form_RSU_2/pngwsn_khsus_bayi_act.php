<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$id=$_REQUEST['id'];
	$idPel=$_REQUEST['idPel'];
	$idUser=$_REQUEST['idUser'];
	$nama=$_REQUEST['nama'];
	$tgl_lahir=tglSQL($_REQUEST['tgl_lahir']);
	$tgl_jam=$_REQUEST['tgl_jam'];
	$ku=addslashes($_REQUEST['ku']);
	$suhu=addslashes($_REQUEST['suhu']);
	$nadi=addslashes($_REQUEST['nadi']);
	$pernafasan=addslashes($_REQUEST['pernafasan']);
	$minum=addslashes($_REQUEST['minum']);
	$infus=addslashes($_REQUEST['infus']);
	$mt=addslashes($_REQUEST['mt']);
	$bab=addslashes($_REQUEST['bab']);
	$bak=addslashes($_REQUEST['bak']);
	$keterangan=addslashes($_REQUEST['keterangan']);

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
$sql="INSERT INTO b_ms_pengawasan_khusus_bayi (id,pelayanan_id,user_act,tgl_act,nama,tgl_lahir,tgl_jam,ku,suhu,nadi,pernafasan,minum,infus,mt,bab,bak,keterangan) VALUES ('$id','$idPel','$idUser',CURDATE(),'$nama','$tgl_lahir','$tgl_jam','$ku','$suhu','$nadi','$pernafasan','$minum','$infus','$mt','$bab','$bak','$keterangan')";
//echo $sql;
$ex=mysql_query($sql);

		if($ex)
		{
			echo "Data berhasil disimpan !";
		}
		else
		{
			echo "Data gagal disimpan !";
		}

	break;
	case 'edit':
		$sql="UPDATE b_ms_pengawasan_khusus_bayi SET pelayanan_id='$idPel', nama='$nama', tgl_lahir='$tgl_lahir',tgl_jam='$tgl_jam',ku='$ku',suhu='$suhu',nadi='$nadi',pernafasan='$pernafasan',minum='$minum',infus='$infus',mt='$mt',bab='$bab',bak='$bak',keterangan='$keterangan' WHERE id='$id' ";
		//echo $sql;
		$ex=mysql_query($sql);
		if($ex)
		{
			echo "Data berhasil diupdate !";
		}
		else
		{
			echo "Data gagal diupdate !";
		}
	break;
	case 'hapus':
		$sql="DELETE FROM b_ms_pengawasan_khusus_bayi WHERE id='$id'";
		$ex=mysql_query($sql);
		if($ex)
		{
			echo "Data berhasil dihapus !";
		}
		else
		{
			echo "Data gagal dihapus !";
		}
	break;
		
}
?>