<?php
$username="muflih";
$password="muflih_test";
$database="192.10.10.114:1521/siakdb"; 
$koneksi=oci_connect($username,$password,$database);

?>
<html>
<head>
<title>KARTU KELUARGA</title>
</head>
<body>
<?php
if(isset($_REQUEST['cek'])){
	$nik=$_POST['nik'];
	$sql_status = oci_parse($koneksi,'SELECT * FROM DATA_KELUARGA WHERE NIK_KK='.$nik);
	oci_execute($sql_status);
	$row = oci_fetch_array($sql_status, OCI_BOTH);
	//print_r($row);
	if(isset($row['NO_KK'])){
		$nokk = $row['NO_KK'];
		$namakk = $row['NAMA_KEP'];
		
		$sql_kk = oci_parse($koneksi,'SELECT * FROM BIODATA_WNI WHERE NO_KK='.$nokk);
		oci_execute($sql_kk);
		
		echo "NO. KARTU KELUARGA : ".$nokk."<br />";
		while (($row = oci_fetch_array($sql_kk, OCI_BOTH))) {
			echo "NIK : ".$row['NIK']." - NAMA : ".$row['NAMA_LGKP']."<br />";
		}
	}else{
		$sql_x = oci_parse($koneksi,'SELECT * FROM BIODATA_WNI WHERE NIK='.$nik);
		oci_execute($sql_x);
		$row_x = oci_fetch_array($sql_x, OCI_BOTH);
		echo "NIK : ".$row_x['NIK']." - NAMA : ".$row_x['NAMA_LGKP']."<br />";
		$nokk_x = $row_x['NO_KK'];
		
		$sql_y = oci_parse($koneksi,'SELECT * FROM BIODATA_WNI WHERE NO_KK='.$nokk_x);
		oci_execute($sql_y);
		echo "NO. KARTU KELUARGA : ".$nokk_x."<br />";
		while (($row_y = oci_fetch_array($sql_y, OCI_BOTH))) {
			echo "NIK : ".$row_y['NIK']." - NAMA : ".$row_y['NAMA_LGKP']."<br />";
		}
	}
oci_close($koneksi);
}
?>
<form method="post" action="">
<table border="0">
<tr>
	<td>NIK</td>
	<td>:</td>
	<td><input type="text" size="30" name="nik"></td>
</tr>
<tr>
	<td colspan="3"><input type="submit" name="cek" value="OK"></td>
</tr>
</body>
</html>