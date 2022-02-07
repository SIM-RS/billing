<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$id=$_REQUEST['id'];
	$idPel=$_REQUEST['idPel'];
	$idUsr=$_REQUEST['idUsr'];
	$list_perawatan=$_REQUEST['list_1'].','.$_REQUEST['list_2'].','.$_REQUEST['list_3'].','.$_REQUEST['list_4'].','.$_REQUEST['list_5'].','.$_REQUEST['list_6'].','.$_REQUEST['list_7'].','.$_REQUEST['list_8'];
	//$tgl_lahir=tglSQL($_REQUEST['tgl_lahir']);
	$list_dokter_bedah=$_REQUEST['cek_1'].','.$_REQUEST['cek_2'].','.$_REQUEST['cek_3'];
	$komplikasi_kamar=addslashes($_REQUEST['komplikasi_kamar']);
	$kehilangan_darah=addslashes($_REQUEST['kehilangan_darah']);
	$r_pemindahan_pasien=addslashes($_REQUEST['r_pemindahan_pasien']);
	$antibiotik=addslashes($_REQUEST['antibiotik']);
	$alergi=addslashes($_REQUEST['alergi']);
	$pemindahan_pasien=addslashes($_REQUEST['pemindahan_pasien']);
	$komplikasi_sebelum=addslashes($_REQUEST['komplikasi_sebelum']);
	//$bab=addslashes($_REQUEST['bab']);
	//$bak=addslashes($_REQUEST['bak']);
	//$keterangan=addslashes($_REQUEST['keterangan']);

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
$sql="INSERT INTO b_timeout_checklist (id,pelayanan_id,user_act,tgl_act,list_perawatan,list_dokter_bedah,komplikasi_kamar,kehilangan_darah,r_pemindahan_pasien,antibiotik,alergi,pemindahan_pasien,komplikasi_sebelum) VALUES ('$id','$idPel','$idUsr',CURDATE(),'$list_perawatan','$list_dokter_bedah','$komplikasi_kamar','$kehilangan_darah','$r_pemindahan_pasien','$antibiotik','$alergi','$pemindahan_pasien','$komplikasi_sebelum')";
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
		$sql="UPDATE b_timeout_checklist SET pelayanan_id='$idPel', list_perawatan='$list_perawatan', list_dokter_bedah='$list_dokter_bedah',komplikasi_kamar='$komplikasi_kamar',kehilangan_darah='$kehilangan_darah',r_pemindahan_pasien='$r_pemindahan_pasien',antibiotik='$antibiotik',alergi='$alergi',pemindahan_pasien='$pemindahan_pasien',komplikasi_sebelum='$komplikasi_sebelum',tgl_act=CURDATE(),user_act='$idUsr' WHERE id='$id' ";
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
		$sql="DELETE FROM b_timeout_checklist WHERE id='$id'";
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