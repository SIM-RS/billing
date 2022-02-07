<?php
include '../../koneksi/konek.php';
$transfusi_id = $_REQUEST['transfusi_id'];
$type = $_REQUEST['type'];
$act = $_REQUEST['act'];
$idKunj = $_REQUEST['idKunj'];
$idPel = $_REQUEST['idPel'];
$idUsr = $_REQUEST['idUsr'];
$status = $_REQUEST['status'];
$saksi_satu = $_REQUEST['saksi_satu'];
$saksi_dua = $_REQUEST['saksi_dua'];

switch ($type){
	case 'edit':
		$sqlEdit = "SELECT * FROM b_persetujuan_transfusi WHERE transfusi_id = '{$transfusi_id}'";
		$queryEdit = mysql_query($sqlEdit);
		$dataEdit = mysql_fetch_array($queryEdit);
		echo $dataEdit['transfusi_id']."|".$dataEdit['saksi_satu']."|".$dataEdit['saksi_dua']."|".$dataEdit['transfusi_status'];
	break;
	case 'delete':
		$sqlDelete = "DELETE FROM b_persetujuan_transfusi WHERE transfusi_id = '{$transfusi_id}'";
		$queryDelete = mysql_query($sqlDelete);
		if($queryDelete){ 
			echo "sukses"; 
		}else{ 
			echo "gagal"; 
		}
	break;
}

switch ($act){
	case 'save':
		$sqlInsert = "INSERT INTO b_persetujuan_transfusi (saksi_satu, saksi_dua, transfusi_status, pelayanan_id, kunjungan_id, tgl_act, user_act) 
					  VALUES ('{$saksi_satu}', '{$saksi_dua}', '{$status}', '{$idPel}', '{$idKunj}', NOW(), '{$idUsr}' )";
		$queryInsert = mysql_query($sqlInsert);
		if($queryInsert){ 
			echo "sukses"; 
		}else{ 
			echo "gagal"; 
		}
	break;
	case 'simpan':
		$sqlInsert = "INSERT INTO b_persetujuan_transfusi (saksi_satu, saksi_dua, transfusi_status, pelayanan_id, kunjungan_id, tgl_act, user_act) 
					  VALUES ('{$saksi_satu}', '{$saksi_dua}', '{$status}', '{$idPel}', '{$idKunj}', NOW(), '{$idUsr}' )";
		$queryInsert = mysql_query($sqlInsert);
		if($queryInsert){ 
			echo "sukses"; 
		}else{ 
			echo "gagal"; 
		}
	break;
	case 'edit':
		$sqlUpdate = "UPDATE b_persetujuan_transfusi 
					  SET saksi_satu = '{$saksi_satu}', saksi_dua = '{$saksi_dua}', transfusi_status = '{$status}', tgl_act = NOW() 
					  WHERE transfusi_id = '{$transfusi_id}' ";
		$queryUpdate = mysql_query($sqlUpdate);
		if($queryUpdate){ 
			echo "sukses"; 
		}else{ 
			echo "gagal"; 
		}
	break;
}
?>