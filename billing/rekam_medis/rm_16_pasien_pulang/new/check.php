<?php  
include '../../function/form.php';
include '../../../koneksi/konek.php';
$check = mysql_fetch_assoc(mysql_query("SELECT id FROM rm_16_pasien_pulang WHERE id_kunjungan = {$_REQUEST['idKunj']}"));
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="../../../theme/bs/bootstrap.min.css">
	<style type="text/css">
	.lds-dual-ring {
	  display: inline-block;
	  width: 80px;
	  height: 80px;
	}
	.lds-dual-ring:after {
	  content: " ";
	  display: block;
	  width: 64px;
	  height: 64px;
	  margin: 8px;
	  border-radius: 50%;
	  border: 6px solid #000000;
	  border-color: #000000 transparent #000000 transparent;
	  animation: lds-dual-ring 1.2s linear infinite;
	}
	@keyframes lds-dual-ring {
	  0% {
	    transform: rotate(0deg);
	  }
	  100% {
	    transform: rotate(360deg);
	  }
	}

	</style>
	<title>Loading...</title>
</head>
<body class="text-center">
	<div style="padding-top: 20%" class="lds-dual-ring"></div>
	<br><br><br><br>
	Mohon Tunggu...
	<script type="text/JavaScript" language="JavaScript" src="../../../include/jquery/jquery-1.9.1.js"></script>
	<script type="text/javascript">

		function redir() {
			<?php  ?>
		}

		function addRM() {
			$.ajax({
				url : '../utils.php? <?= "id_kunjungan={$_REQUEST['idKunj']}&id_pelayanan={$_REQUEST['idPel']}&idPasien=&id_user={$_REQUEST['idUser']}&tmpLay=" ?>',
				success : () => {
					window.location.href = 'redir.php? <?= "idKunj={$_REQUEST['idKunj']}&idPel={$_REQUEST['idPel']}&idPasien=&idUser={$_REQUEST['idUser']}&tmpLay=" ?>';
				}
			});
		}
	</script>
</body>
</html>

<?php

if ($check['id'] == "") {
	echo '<script>addRM()</script>';
} else {
	header("Location:index.php?idKunj={$_REQUEST['idKunj']}&idPel={$_REQUEST['idPel']}&idPasien=&idUser={$_REQUEST['idUser']}&tmpLay=&id={$check['id']}");
}