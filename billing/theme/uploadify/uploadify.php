<?php
include("../../koneksi/konek.php");
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

/*
// Define a destination
$targetFolder = '/uploads'; // Relative to the root

$verifyToken = md5('unique_salt' . $_POST['timestamp']);

if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
	$targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];
	
	// Validate the file type
	$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	
	if (in_array($fileParts['extension'],$fileTypes)) {
		move_uploaded_file($tempFile,$targetFile);
		echo '1';
	} else {
		echo 'Invalid file type.';
	}
}
*/
if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_POST['folder'] . '/';
	$targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];
	
	$fileTypes = array('jpg', 'jpeg', 'gif', 'png'); // File extensions
	$fileParts = pathinfo(strtolower($_FILES['Filedata']['name']));
	if (in_array($fileParts['extension'], $fileTypes)) {
		
		
		$id = $_POST['id'];
		$pelayanan_id = $_POST['pelayanan_id'];
		$hasil = $_POST['hasil'];
		$dokter = $_POST['dokter'];
		$user_id = $_POST['user_id'];
		$nama_file = $_FILES['Filedata']['name'];
		$type_file = $_FILES['Filedata']['type'];
		$ukuran_file = $_FILES['Filedata']['size'];
		$fcontent = addslashes(fread(fopen($_FILES['Filedata']['tmp_name'], "r"), $_FILES['Filedata']['size']));
		$user_act = '1';
		$norm = $_POST['norm'];
		$pacsid = $_POST['pacsId'];

		if($_POST['action']=='Tambah'){
			$query="insert into b_hasil_rad (tgl,pelayanan_id,nama_file,fcontent,hasil,user_id,tgl_act,user_act,norm,pacsid) values (now(),'$pelayanan_id','$nama_file','$fcontent','$hasil','$dokter',now(),'$user_id','$norm','$pacsid')";
			$result = mysql_query ($query);
		}
		else if($_POST['action']=='Simpan'){
			if($pacsid != ""){
			$setPacs = ", norm = '$norm',
					pacsid = '$pacsid'";
			} else {
				$setPacs = "";
			}
			$queri="update b_hasil_rad set hasil='$hasil',user_id='$dokter',nama_file='$nama_file',fcontent='$fcontent',tgl_act=now(),user_act='$user_id', 
			norm = '$norm',
			pacsid = '$pacsid'
			where id='$id'";
			$result = mysql_query ($queri);
		}
	} else {
		echo 'Invalid file type.';
	}
}

?>