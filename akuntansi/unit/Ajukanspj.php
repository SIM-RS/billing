<?php 
include("../koneksi/konek.php");

$idunit=1;
$id=$_REQUEST["id"];
$unit_bauk=$_REQUEST["unit_bauk"];
if ($id!=""){
	$sql="update spj set status=1,tgl_act=getdate(),fk_iduser=$iduser,fk_unit_bauk=$unit_bauk where spj_id=$id";
	$rs=mysql_query($sql);
	$sql="update jurnal set status=2 where fk_idspj=$id";
	$rs=mysql_query($sql);
	$msg="SPJ Telah Diajukan Ke BAUK";
}else{
	$msg="Pilih SPJ Terlebih Dahulu";
}
?>
<html>
<head>
<title>Pengajuan SPJ</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" href="../theme/simkeu.css" type="text/css" />
</head>
<body>
<div align="center">
<span class="msg"><?php echo $msg; ?></span>
</div>
</body>
</html>
<?php 
mysql_close($konek);
?>