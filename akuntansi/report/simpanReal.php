<?php
session_start();

include "../sesi.php";
include("../koneksi/konek.php");

$bulan= $_REQUEST['bulan'];
$ta=$_REQUEST['ta'];
$nilai=$_REQUEST['nilai'];




$sql = "select *from realisasi where BULAN = $bulan and TAHUN = $ta";

$rs=mysql_query($sql);
if($rws=mysql_fetch_array($rs))
{
	$id = $rws['ID'];
	
	 $sql="update realisasi set nilai= $nilai where id = $id";
	$rs=mysql_query($sql);
	
}
else
{ 
	 $sql="insert into realisasi (BULAN,TAHUN,NILAI)values($bulan,$ta,$nilai)";
	$rs=mysql_query($sql);
}

if(rs)
{
	echo "sukses";
}
else
{
	echo "gagal";
}


?>