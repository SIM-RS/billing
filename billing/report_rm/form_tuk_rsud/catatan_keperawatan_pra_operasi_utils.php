<?php
include('../../koneksi/konek.php');

$ctt_keperawatan_pra_operasi = $_POST['ctt_keperawatan_pra_operasi'];
$fields = array('kunjungan_id','pelayanan_id','pasien_id','user_id');
$values = array($_POST['kunjungan_id'],$_POST['pelayanan_id'],$_POST['pasien_id'],$_POST['user_id']);
$id = $ctt_keperawatan_pra_operasi['id'];

foreach($ctt_keperawatan_pra_operasi as $key => $val){
	if($key != 'id' && !in_array($val,array('lain', 'ada'))){
		$fields[] = $key;
		$values[] = "'{$val}'";
	}
}

if($id == ''){
	$sql = 'insert into lap_ctt_keperawatan_pra_operasi
		('.implode(',',$fields).') 
		values ('.implode(',',$values).')';
	mysql_query($sql);
	echo mysql_insert_id();
}else{
	$sets = array();
	foreach($fields as $key => $val){
		if(!in_array($val,array('kunjungan_id', 'pelayanan_id', 'pasien_id', 'user_id'))){
			$sets[] = "{$val}={$values[$key]}";
		}
	}
	echo $sql = "update lap_ctt_keperawatan_pra_operasi
		set ".implode(',',$sets)."
		where id={$id}";
	mysql_query($sql);
}
?>