<?php
include '../../koneksi/konek.php';
$idKunj = $_REQUEST['idKunj'];
$idPel = $_REQUEST['idPel'];
$idUser = $_REQUEST['idUsr'];
$act = $_REQUEST['act'];
$key = explode(',',$_REQUEST['key']);

switch($act){
	/*case 'save':
		foreach($key as $val){
			//echo $val;
			$sql = "INSERT INTO b_tindakan_lab (pemeriksaan_id, pelayanan_id, kunjungan_id, tgl_act, user_act) 
					VALUES ('{$val}', '{$idPel}', '{$idKunj}', NOW(), '{$idUser}')";
			$hasil = mysql_query($sql);
		}
	break;*/
	case 'edit':
		$sCek = "SELECT pemeriksaan_id FROM b_tindakan_lab 
				 WHERE pelayanan_id = '{$idPel}' AND kunjungan_id = '{$idKunj}'";
		$qCek = mysql_query($sCek);
		while($dCek = mysql_fetch_array($qCek)){
			$abc[] = $dCek['pemeriksaan_id'];
		}
		$zxc = array_diff($key,$abc);
		//print_r($zxc);
		$del = implode(',',$key);
		$sqlDel = "DELETE FROM b_tindakan_lab WHERE pelayanan_id = '{$idPel}' AND pemeriksaan_id NOT IN({$del}) ";
		$hasil = mysql_query($sqlDel);
		if(count($zxc) > 0){
			foreach($zxc as $val){
				//echo $val;
				$sql = "INSERT INTO b_tindakan_lab (pemeriksaan_id, pelayanan_id, kunjungan_id, tgl_act, user_act) 
				VALUES ('{$val}', '{$idPel}', '{$idKunj}', NOW(), '{$idUser}')";
				$hasil = mysql_query($sql);
			}
		}
	break;
}
if($hasil){
	echo "sukses";
}else{
	echo "gagal";
}
?>