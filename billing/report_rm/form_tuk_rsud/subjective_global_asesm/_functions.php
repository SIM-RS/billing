<?php

function getSurat($idPelayanan)
{
	$sql = "SELECT 
			  * 
			FROM
			  lap_subjective_global_asesm lap 
			WHERE lap.pelayanan_id = {$idPelayanan} ";
	$query = mysql_query($sql);
	if(mysql_num_rows($query) == 0) {
		return FALSE;
	}
	$surat = mysql_fetch_assoc($query);
	
	return $surat;
}

?>