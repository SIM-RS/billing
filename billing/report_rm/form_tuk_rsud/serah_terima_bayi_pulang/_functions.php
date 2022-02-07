<?php

function getSerahTerima($idPel)
{
	$sql = "SELECT 
			  * 
			FROM
			  lap_serah_terima_bayi_pulang lap 
			WHERE lap.pelayanan_id = {$idPel} ";
	$query = mysql_query($sql);
	if(mysql_num_rows($query) == 0) {
		return FALSE;
	}
	$serahTerima = mysql_fetch_assoc($query);
	
	$alamat = explode("\r\n", $serahTerima['alamat']);
	$serahTerima['alamat1'] = $alamat[0];
	$serahTerima['alamat2'] = $alamat[1];
	
	$alamat = explode("\r\n", $serahTerima['penerima_alamat']);
	$serahTerima['penerima_alamat1'] = $alamat[0];
	$serahTerima['penerima_alamat2'] = $alamat[1];
	
	return $serahTerima;
}

?>