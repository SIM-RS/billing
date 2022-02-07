<?php
include "../../koneksi/konek.php";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUser'];
$inap=$_REQUEST['inap'];
$kelas_id=$_REQUEST['kelas_id'];
$id=$_REQUEST['id'];
if($_GET['tipe'] == 'save'){
	$kamar = $_GET['kamar'];
	$nmpasien = $_GET['nmpasien'];
	$diagnosmedis = $_GET['diagnosmedis'];
	$infuse = $_GET['infuse'];
	$rncanapagi = $_GET['rncanapagi'];
	$rncanasore = $_GET['rncanasore'];
	$rncanamlm = $_GET['rncanamlm'];
	$dinas = $_GET['dinas'];
	$pelayanan_id = $_GET['pelayanan_id'];
	$kunjungan_id = $_GET['kunjungan_id'];
	$user_id = $_GET['user_id'];
	$inp = $_GET['inp'];
	$kls_id = $_GET['kls_id'];
		
	if($id == ''){
		$sql = " INSERT INTO b_rencana_harian_perawat
					(kamar,
					nmpasien,
					diagnosmedis,
					infuse,
					rncanapagi,
					rncanasore,
					rncanamlm,
					dinas,
					pelayanan_id,
					kunjungan_id,
					user_id,
					inap,
					kelas_id,
					tgl_act)
				VALUES ('{$kamar}', 
						'{$nmpasien}', 
						'{$diagnosmedis}', 
						'{$infuse}',
						'{$rncanapagi}', 
						'{$rncanasore}',
						'{$rncanamlm}',
						'{$dinas}',
						'{$pelayanan_id}',
						'{$kunjungan_id}',
						'{$user_id}',
						'{$inp}',
						'{$kls_id}',
						NOW())";
		mysql_query($sql);
		mysql_insert_id();
	}else{
		//$id=$_REQUEST['id'];
		$sql = ("UPDATE b_rencana_harian_perawat
			SET kamar = '$kamar',
				nmpasien = '$nmpasien', 
				diagnosmedis = '$diagnosmedis', 
				infuse = '$infuse', 
				rncanapagi = '$rncanapagi', 
				rncanasore = '$rncanasore',
				rncanamlm = '$rncanamlm',
				dinas = '$dinas',
				pelayanan_id = '$pelayanan_id',
				kunjungan_id = '$kunjungan_id',
				user_id = '$user_id',
				inap = '$inp',
				kelas_id = '$kls_id',
				tgl_act = NOW()
			WHERE id = {$id}");
		mysql_query($sql);
	}
}else if ($_POST['tipe']== 'delete'){
			//$id=$_REQUEST['id'];
			$sql=("DELETE FROM b_rencana_harian_perawat WHERE id={$id}");
			mysql_query($sql);
		}
?>