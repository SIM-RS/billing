<?php 
include("../koneksi/konek.php");

$idunit=1;
$noumk=$_REQUEST['noumk'];if ($noumk=="") $noumk="0";
$idumk=$_REQUEST['idumk'];if ($idumk=="") $idumk="0";
$bauk=$_REQUEST['bauk'];if ($bauk=="") $bauk="0";

$sql="update umk set UMK_UNIT_BAUK=$bauk,UMK_STATUS=1 where UMK_ID=$idumk";
//echo $sql."<br>";
$rs=mysql_query($sql);
$msg="UMK dengan No : $noumk Telah Diajukan Ke BAUK";
?>
<html>
<head>
<title>Pengajuan Uang Muka</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" href="../theme/simkeu.css" type="text/css" />
</head>
<body>
<div align="center"><br><br>
	<span class="msg"><?php echo $msg; ?></span>
</div>
</body>
</html>
<?php 
mysql_close($konek);
?>