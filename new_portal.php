<?php
	session_start();
	include("billing/koneksi/konek.php");
	if($_SESSION['logon'] != 1){
		session_destroy();
		header("location:index1.php");
	}
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title></title>
</head>
<body>
	<?php
		foreach($_SESSION['modul'] as $val){
			switch($val){
				case '1':
					echo '<a href="billing/">Modul Billing</a><br />';
					break;
				case '2':
					echo '<a href="apotek/main/main.php">Modul Apotek</a><br />';
					break;
				case '3':
					echo '<a href="keuangan/home.php">Modul Keuangan</a><br />';
					break;
				case '4':
					echo '<a href="akuntansi/unit/main.php">Modul Akuntansi</a><br />';
					break;
			}
		}
		/* $sModul = "SELECT modul_id FROM b_ms_pegawai_modul WHERE pegawai_id = ".$_SESSION['userId'];
		$qModul = mysql_query($sModul);
		if($qModul)
			while($dModul = mysql_fetch_array($qModul))
			{
				switch($dModul['modul_id'])
				{
					case '1':
						echo '<a href="billing/">Modul Billing</a><br />';
						break;
					case '2':
						echo '<a href="apotek/main/main.php">Modul Apotek</a><br />';
						break;
				}
			} */
	?>
	<a href="new_logout.php">Log Out</a>
</body>
</html>