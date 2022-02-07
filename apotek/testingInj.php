<?php
	include("koneksi/konek_mysqli.php");
	
	$cid=mysqli_real_escape_string($konek,$_REQUEST["cid"]);
	//$cid=$_REQUEST["cid"];
	
	$sql="SELECT * FROM a_kepemilikan WHERE AKTIF = $cid";
	$result=mysqli_query($konek,$sql);
	echo "Records Count : ".mysqli_num_rows($result)."<br>";
	while ($row = mysqli_fetch_array($result))
	{
		echo $row[0]." - ".$row[1]."<br>";
	}
	
	mysqli_close($konek);
?>