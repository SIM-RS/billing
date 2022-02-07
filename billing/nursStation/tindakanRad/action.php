<?php
include '../../koneksi/konek.php';
$idKunj = $_REQUEST['idKunj'];
$idPel = $_REQUEST['idPel'];
$idUser = $_REQUEST['idUsr'];
$act = $_REQUEST['act'];
$key = explode(',',$_REQUEST['key']);
$date_now = $_REQUEST['tgl'];
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
		$sTgl = "SELECT DATE_FORMAT(tgl_act, '%d-%m-%Y') AS tgl FROM b_tindakan_rad WHERE pelayanan_id = '{$idPel}' ORDER BY tgl_act DESC LIMIT 1";
		$qTgl = mysql_query($sTgl);
		$dTgl = mysql_fetch_array($qTgl);
		if($dTgl['tgl'] != $date_now){
			echo "warning";
		}else{
			$sCek = "SELECT pemeriksaan_id, status FROM b_tindakan_rad 
					 WHERE pelayanan_id = '{$idPel}'";
			$qCek = mysql_query($sCek);
			while($dCek = mysql_fetch_array($qCek)){
				$abc[] = $dCek['pemeriksaan_id'].'||'.$dCek['status'];
			}
			$zxc = array_diff($key,$abc);
			//print_r($zxc);
			$key2 = array();
			foreach($key as $val){
				$data = explode('||',$val);
				$key2[] = $data[0];
			}
			$del = implode(',',$key2);
			if($del == ""){
				$sqlDel = "DELETE FROM b_tindakan_rad WHERE pelayanan_id = '{$idPel}' ";
			}else{
				$sqlDel = "DELETE FROM b_tindakan_rad WHERE pelayanan_id = '{$idPel}' AND pemeriksaan_id NOT IN({$del}) ";
			}		
			$hasil = mysql_query($sqlDel);
			if(count($zxc) > 0){
				foreach($zxc as $val){
					//echo $val;
					$data2 = explode('||',$val);
					$sql = "INSERT INTO b_tindakan_rad (pemeriksaan_id, pelayanan_id, kunjungan_id, tgl_act, user_act, status) 
					VALUES ('".$data2[0]."', '{$idPel}', '{$idKunj}', NOW(), '{$idUser}', '".$data2[1]."')";
					$hasil = mysql_query($sql);
				}
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