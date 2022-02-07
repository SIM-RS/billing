<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$idUsr=$_REQUEST['idUsr'];
	
	$idUsr=$_REQUEST['idUsr'];
	$nomor=$_REQUEST['nomor'];
  	$nama=$_REQUEST['nama'];
  	$nama_bayi=$_REQUEST['nama_bayi'];
  	$jenis_kel=$_REQUEST['jenis_kel'];
  	$tgl_kelahiran2=$_REQUEST['tgl_kelahiran'];
	$pisah=explode(" ",$tgl_kelahiran2);
	$tgl_kelahiran=tglSQL($pisah[0])." ".$pisah[1];
  	$salin_normal=$_REQUEST['salin_normal'];
  	$salin_tindakan=$_REQUEST['salin_tindakan'];
  	$anak_ke=$_REQUEST['anak_ke'];
  	$kembar=$_REQUEST['kembar'];
  	$panjang=$_REQUEST['panjang'];
  	$berat=$_REQUEST['berat'];
  	$lingkar=$_REQUEST['lingkar'];

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
				$sql="INSERT INTO srt_kenal_lahir (
  pelayanan_id,
  kunjungan_id,
  user_id,
  user_act,
  nomor,
  nama,
  nama_bayi,
  jenis_kel,
  tgl_kelahiran,
  salin_normal,
  salin_tindakan,
  anak_ke,
  kembar,
  panjang,
  berat,
  lingkar
) 
VALUES
  (
    '$idPel',
    '$idKunj',
    '$idUsr',
    NOW(),
    '$nomor',
    '$nama',
    '$nama_bayi',
    '$jenis_kel',
    '$tgl_kelahiran',
    '$salin_normal',
    '$salin_tindakan',
    '$anak_ke',
    '$kembar',
    '$panjang',
    '$berat',
    '$lingkar'
  )";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil disimpan !";
			}else{
				echo "Data gagal disimpan !";
				}
	break;
	case 'edit':
		$sql="UPDATE srt_kenal_lahir SET pelayanan_id='$idPel',
		kunjungan_id='$idKunj',
		user_act=NOW(),
		user_id='$idUsr',
		nomor='$nomor',
		nama='$nama',
		nama_bayi='$nama_bayi',
		jenis_kel='$jenis_kel',
		tgl_kelahiran='$tgl_kelahiran',
		salin_normal='$salin_normal',
		salin_tindakan='$salin_tindakan',
		anak_ke='$anak_ke',
		kembar='$kembar',
		panjang='$panjang',
		berat='$berat',
		lingkar='$lingkar'
		WHERE id='".$_REQUEST['txtId']."'";
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
		$sql="DELETE FROM srt_kenal_lahir WHERE id='".$_REQUEST['txtId']."'";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil dihapus !";
			}else{
				echo "Data gagal dihapus !";
				}
	break;
		
}
?>