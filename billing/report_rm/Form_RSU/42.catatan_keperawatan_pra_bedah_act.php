<?php
include("../../koneksi/konek.php");

$id=$_REQUEST['txtId'];
$idUsr=$_REQUEST['idUsr'];	
$idPel=$_REQUEST['idPel'];
$idKunj=$_REQUEST['idKunj'];
$idPsn=$_REQUEST['idPsn'];
//$act=$_REQUEST['act'];
$ruang = $_REQUEST['ruang'];
$tgl_operasi = tglSQL($_REQUEST['tgl']);

$tindakan1 = $_REQUEST['kanan'];
$tindakan2 = $_REQUEST['kiri'];

$tindakan=$tindakan1.'|'.$tindakan2;

$status=$_REQUEST['status'];
$ruangan=$_REQUEST['ruangan'];
$anastesi = $_REQUEST['anastesi'];
$keterangan = $_REQUEST['keterangan'];

$tot = count($ruangan); 
//echo $tot;
for($i=0;$i<=$tot;$i++){
	$isi[$i] = $ruangan[$i].'|'.$status[$i].'|'.$anastesi[$i].'|'.$keterangan[$i];
} 

/*for($i=0;$i<=$tot;$i++){
	echo $isi[$i].'*';
} */


$jam_persiapan = $_REQUEST['jam'];
$perawat_kamar = $_REQUEST['perawat_kamar'];
$perawat_ruangan = $_REQUEST['perawat_ruangan'];

	
switch(strtolower($_REQUEST['act'])){
	case 'tambah':
				$sql="INSERT INTO b_form_catatan_pra_bedah values ('','$idPel','$idKunj','$idPsn','$ruang','$tgl_operasi','$tindakan','$isi[0]','$isi[1]','$isi[2]','$isi[3]','$isi[4]','$isi[5]','$isi[6]','$isi[7]','$isi[8]','$isi[9]','$isi[10]','$isi[11]','$isi[12]','$isi[13]','$isi[14]','$isi[15]','$isi[16]','$isi[17]','$isi[18]','$isi[19]','$jam_persiapan','$perawat_kamar','$perawat_ruangan','$idUsr',CURDATE())";
		$ex=mysql_query($sql);
		//echo $sql;
		if($ex){
			echo "Data berhasil disimpan !";
			}else{
				echo "Data gagal disimpan !";
				}
	break;
	
	case 'edit':
		$sql="UPDATE b_form_catatan_pra_bedah set id_pelayanan='$idPel', id_kunjungan='$idKunj', id_pasien='$idPsn', ruang='$ruang', tgl_operasi='$tgl_operasi', tindakan='$tindakan', lapangan_operasi='$isi[0]', puasa='$isi[1]', ijin_operasi='$isi[2]', TD='$isi[3]', kateter='$isi[4]', infus='$isi[5]', huknah='$isi[6]', obat_pramedikasi='$isi[7]', barang_berharga='$isi[8]', tata_rias='$isi[9]', gigi_palsu='$isi[10]', hasil_ekg='$isi[11]', status_lengkap='$isi[12]', darah_dan_golongan='$isi[13]', konsul_anastesi='$isi[14]', konsul_kardiologi='$isi[15]', konsul_penyakit='$isi[16]', konsul_paru='$isi[17]', konsul_anak='$isi[18]', pemasangan_label='$isi[19]', jam_persiapan='$jam_persiapan', perawat_kamar='$perawat_kamar', perawat_ruangan='$perawat_ruangan', user_act='$idUsr' where id='$id'";
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
		$sql="DELETE FROM b_form_catatan_pra_bedah WHERE id='$id'";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil dihapus !";
			}else{
				echo "Data gagal dihapus !";
				}
	break;
		
}
?>