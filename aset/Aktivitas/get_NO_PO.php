<?php
include '../koneksi/konek.php';

$act = $_REQUEST['act'];
$jenis = $_REQUEST['jenis'];
//$tgl = gmdate('d-m-Y',mktime(date('H')+7));
$tgl = $_REQUEST['tgl']; //tgl_po
$xx = explode('-', $tgl);
$periode = $xx[2]."-".$xx[1];


if($act=='add')
{
	$q = "select * from as_po where no_po like '$jenis/$periode/%' order by id desc limit 1";
	$s = mysql_query($q);
	$d = mysql_fetch_array($s);
	$j = mysql_num_rows($s);
	if($j==0)
	{
		echo "$jenis/$periode/0001";
	}
	else
	{
		$bom = explode("/",$d['no_po']);
		$no = $bom[2]+1;
		$nox = sprintf("%04d",$no);
		echo "$jenis/$periode/".$nox;
	}
}
else if($act=='edit')
{
	$jenis_awal = $_REQUEST['jenis_awal'];
	$no_po = $_REQUEST['no_po'];
	$yy = explode('/', $no_po);

	if($periode==$yy[1] && $jenis==$jenis_awal)
	{
		echo $no_po;
	}
	else
	{
		$q = "select * from as_po where no_po like '$jenis/$periode/%' order by id desc limit 1"; //echo $q;
		$s = mysql_query($q);
		$d = mysql_fetch_array($s);
		//$j = mysql_num_rows($s);
	
		$bom = explode("/",$d['no_po']);
		$no = $bom[2]+1;
		$nox = sprintf("%04d",$no);
		echo "$jenis/$periode/".$nox;
	}
}
?>