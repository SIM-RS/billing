<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	
	$kode_rs=$_REQUEST['kode_rs'];
	$tgl_registrasi=tglSQL($_REQUEST['tgl_registrasi']);
	$jenis_rs=$_REQUEST['jenis_rs'];
	$kelas_rs=$_REQUEST['kelas_rs'];
	$direktur_rs=$_REQUEST['direktur_rs'];
	$penyelenggara_rs=$_REQUEST['penyelenggara_rs'];
	$humas_rs=$_REQUEST['humas_rs'];
	$website=$_REQUEST['website'];
	$tanah=$_REQUEST['tanah'];
	$bangunan=$_REQUEST['bangunan'];
	$nomor=$_REQUEST['nomor'];
	$tgl_penetapan=tglSQL($_REQUEST['tgl_penetapan']);
	$oleh=$_REQUEST['oleh'];
	$sifat=$_REQUEST['sifat'];
	$tahun=$_REQUEST['tahun'];
	$status_peny_swas=$_REQUEST['status_peny_swas'];
	$pentahapan=$_REQUEST['pentahapan'];
	$status=$_REQUEST['status'];
	$tgl_akreditasi=tglSQL($_REQUEST['tgl_akreditasi']);
	$ruang_operasi=$_REQUEST['ruang_operasi'];
	$d_sub_spes=$_REQUEST['d_sub_spes'];
	$d_spes_lain=$_REQUEST['d_spes_lain'];
	$farmasi=$_REQUEST['farmasi'];
	$t_kes_lain=$_REQUEST['t_kes_lain'];
	$t_non_kes=$_REQUEST['t_non_kes'];
	$idUser=$_REQUEST['idUser'];

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
		$sql="INSERT INTO b_profil_detail
(kode_rs, tgl_registrasi, jenis_rs, kelas_rs, direktur_rs, penyelenggara_rs, humas_rs, website, tanah, bangunan, nomor, tgl_penetapan,
oleh, sifat, tahun, status_peny_swas, pentahapan, status, tgl_akreditasi, ruang_operasi,d_sub_spes, d_spes_lain, farmasi, t_kes_lain,t_non_kes, kode_b_profil, tgl_act, user_act) VALUES
('$kode_rs', '$tgl_registrasi', '$jenis_rs', '$kelas_rs', '$direktur_rs', '$penyelenggara_rs', '$humas_rs', '$website', '$tanah', '$bangunan', '$nomor', '$tgl_penetapan', 
'$oleh', '$sifat', '$tahun', '$status_peny_swas', '$pentahapan', '$status', '$tgl_akreditasi', '$ruang_operasi', '$d_sub_spes', '$d_spes_lain', '$farmasi', '$t_kes_lain', '$t_non_kes', '1',NOW(),'$idUser')";
		$ex=mysql_query($sql);
		if($ex){	
			echo "Data berhasil disimpan !";
		}else{
			echo "Data gagal disimpan !";
		}
	break;
	case 'edit':
		/*$sql="UPDATE b_profil_detail SET
kode_rs='$kode_rs',
tgl_registrasi='$tgl_registrasi',
jenis_rs='$jenis_rs',
kelas_rs='$kelas_rs',
direktur_rs='$direktur_rs',
penyelenggara_rs='$penyelenggara_rs',
humas_rs='$humas_rs',
website='$website',
tanah='$tanah',
bangunan='$bangunan',
nomor='$nomor',
tgl_penetapan='$tgl_penetapan',
oleh='$oleh',
sifat='$sifat',
tahun='$tahun',
status_peny_swas='$status_peny_swas',
pentahapan='$pentahapan',
status='$status',
tgl_akreditasi='$tgl_akreditasi',
ruang_operasi='$ruang_operasi',
d_sub_spes='$d_sub_spes',
d_spes_lain='$d_spes_lain',
farmasi='$farmasi',
t_kes_lain='$t_kes_lain',
t_non_kes='$t_non_kes',
tgl_act=CURDATE(),
user_act='$idUser'	
WHERE profil_detail_id='".$_REQUEST['id']."'";
		//echo $sql;
		$ex=mysql_query($sql);
		if($ex)
		{
			echo "Data berhasil diupdate !";
		}
		else
		{
			echo "Data gagal diupdate !";
		}*/
		
		$sql="INSERT INTO b_profil_detail
(kode_rs, tgl_registrasi, jenis_rs, kelas_rs, direktur_rs, penyelenggara_rs, humas_rs, website, tanah, bangunan, nomor, tgl_penetapan,
oleh, sifat, tahun, status_peny_swas, pentahapan, status, tgl_akreditasi, ruang_operasi,d_sub_spes, d_spes_lain, farmasi, t_kes_lain,t_non_kes, kode_b_profil, tgl_act, user_act) VALUES
('$kode_rs', '$tgl_registrasi', '$jenis_rs', '$kelas_rs', '$direktur_rs', '$penyelenggara_rs', '$humas_rs', '$website', '$tanah', '$bangunan', '$nomor', '$tgl_penetapan', 
'$oleh', '$sifat', '$tahun', '$status_peny_swas', '$pentahapan', '$status', '$tgl_akreditasi', '$ruang_operasi', '$d_sub_spes', '$d_spes_lain', '$farmasi', '$t_kes_lain', '$t_non_kes', '1',NOW(),'$idUser')";
		$ex=mysql_query($sql);
		if($ex){	
			echo "Data berhasil disimpan !";
		}else{
			echo "Data gagal disimpan !";
		}
	break;
	case 'hapus':
		//$sql="DELETE FROM b_profil_detail WHERE profil_detail_id='".$_REQUEST['id']."'";
		//$ex=mysql_query($sql);
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