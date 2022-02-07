<?php
include '../../koneksi/konek.php';
function getValue($a,$b){
	switch($a){
		case 'ADMIN': $n = 9;
		break;
		case 'RUANG': $n = 16;
		break;
	}
	for($i=1;$i<=$n;$i++){
		if($b[$i] == 1){
			if($i != $n){
				$result .= $b[$i].",";
			} else {
				$result .= $b[$i];
			}
		} else {
			if($i != $n){
				$result .= "0,";
			} else {
				$result .= "0";
			}
		}
	}
	return $result;
}
$act = $_REQUEST['actCheckList'];
$admin = getValue('ADMIN',$_REQUEST['ADMIN']);
$ruang = getValue('RUANG',$_REQUEST['RUANG']);
$ketListPulang = $_REQUEST['ketListPulang'];
$pelayanan_id = $_REQUEST['idPelCheckList'];
$kunjungan_id = $_REQUEST['idKunjCheckList'];
$user_act = $_REQUEST['idUserCheckList'];
$pulang_id = $_REQUEST['pulang_id'];

switch($act){
	case 'save':
		$sqlCheck = "SELECT * FROM b_list_pasien_pulang WHERE pelayanan_id = '{$pelayanan_id}' AND kunjungan_id = '{$kunjungan_id}' ";
		$hasilCheck = mysql_fetch_array(mysql_query($sqlCheck));		
		if($hasilCheck['pelayanan_id'] == $pelayanan_id && $hasilCheck['kunjungan_id'] == $kunjungan_id){
			$sqlUpdate = "UPDATE b_list_pasien_pulang 
						  SET administrasi = '{$admin}', fasilitas = '{$ruang}', keterangan = '{$ketListPulang}', tgl_act = NOW()
						  WHERE list_pulang_id = '".$hasilCheck['list_pulang_id']."' ";
			$hasil = mysql_query($sqlUpdate);		
		}else{
			$sqlInsert = "INSERT INTO b_list_pasien_pulang(administrasi,fasilitas,keterangan,pelayanan_id,kunjungan_id,tgl_act,user_act) 
						  VALUES ('{$admin}','{$ruang}','{$ketListPulang}','{$pelayanan_id}','{$kunjungan_id}',NOW(),'{$user_act}') ";
			$hasil = mysql_query($sqlInsert);		
		}		
	break;
	case 'edit':
		$sqlCheck = "SELECT * FROM b_list_pasien_pulang WHERE pelayanan_id = '{$pelayanan_id}' AND kunjungan_id = '{$kunjungan_id}' ";
		$hasilCheck = mysql_fetch_array(mysql_query($sqlCheck));
		$sqlUpdate = "UPDATE b_list_pasien_pulang 
					  SET administrasi = '{$admin}', fasilitas = '{$ruang}', keterangan = '{$ketListPulang}', tgl_act = NOW()
					  WHERE list_pulang_id = '".$hasilCheck['list_pulang_id']."' ";
		$hasil = mysql_query($sqlUpdate);		
	break;
}
if($hasil){
	echo "sukses";
}else{
	echo "gagal";
}
?>