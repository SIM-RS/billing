<?php 
include '../koneksi/konek.php';
$id=$_GET['id'];

    $s = mysql_query("SELECT * FROM b_upload_rm WHERE id='$id'");
	$d = mysql_fetch_array($s);
	
    // outputing HTTP headers
    // header('Content-Length: '.strlen($logo));
    header('Content-type: image/jpeg');

    // outputing image
    echo $d['fcontent'];
    exit();
?>