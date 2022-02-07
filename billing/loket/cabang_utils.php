<?php
	include('../koneksi/konek.php');
	$loket = $_REQUEST['loket'];
	$hasil['cabang'] = 1;
	if($loket > 0){
		$sql = "SELECT cabang_id from b_ms_unit where id = '{$loket}'";
		$query = mysql_query($sql);
		if(mysql_num_rows($query) > 0){
			$data = mysql_fetch_array($query);
			$hasil['cabang'] = $data['cabang_id'];
		}
		// $hasil['cabang'] = 1;
	}
	
	echo json_encode($hasil);