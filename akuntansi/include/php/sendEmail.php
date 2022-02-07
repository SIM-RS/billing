<?php

function sendEmail($subject, $mailmsg, $jabatanId) {
	$query = mysql_query("SELECT EMAIL, j.NAMA_JABATAN
		FROM dbkopega_hcr.pegawai p 
		INNER JOIN dbkopega_hcr.pgw_jabatan pj ON p.PEGAWAI_ID=pj.PEGAWAI_ID
		inner join dbkopega_hcr.ms_jabatan_pegawai j on pj.JBT_ID=j.ID
		WHERE pj.JBT_ID=".$jabatanId);
	$row = mysql_fetch_array($query);
	$to = $row['EMAIL'];

	chdir(dirname(__FILE__));
	include_once('../../../post_request.php');
	$post_data = array(
		'email' => $to,
		'subject' => $subject,
		'mailmsg' => urlencode($mailmsg)
	);
	post_request('http://kopega-priok.co.id/kirim_email.php', $post_data);
}

?>