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
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
	$targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];
	
	// Validate the file type
	$fileTypes = array('jpg', 'jpeg', 'gif', 'png'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	
	if (in_array($fileParts['extension'], $fileTypes)) {
		//the $file_string can now be saved in a longblob in an sqldatabase
		//$file_string = addslashes(fread(fopen($_FILES['Filedata']['tmp_name'], "r"), $_FILES['Filedata']['size']));
		
		$id_kunj = $_POST['id_kunj'];
		$pelayanan_id = $_POST['pelayanan_id'];
		//$hasil = $_POST['hasil'];
		$pasien_id = $_POST['pasien_id'];
		$user_id = $_POST['user_id'];
		$nama_file = $_FILES['Filedata']['name'];
		$type_file = $_FILES['Filedata']['type'];
		$ukuran_file = $_FILES['Filedata']['size'];
		$fcontent = addslashes(fread(fopen($_FILES['Filedata']['tmp_name'], "r"), $_FILES['Filedata']['size']));
		$user_act = '1';
		
		if($_POST['action']=='Tambah'){
			echo $query="insert into b_upload_rm (tgl_act,id_pelayanan,id_kunjungan,fcontent,id_pasien,user_act) values (now(),'$pelayanan_id','$id_kunj','$fcontent','$pasien_id','$user_id')";
			$result = mysql_query ($query);
			mysql_free_result($result);
		}
		else if($_POST['action']=='Simpan'){
			$queri="update b_upload_rm set hasil='$hasil',user_id='$dokter',nama_file='$nama_file',fcontent='$fcontent',tgl_act=now(),user_act='$user_id' where id='$id'";
			$result = mysql_query ($queri);
			mysql_free_result($result);
		}
	} else {
		echo 'Invalid file type.';
	}
}

?>