<?php
$img = addslashes($_GET['img']);
$d = isset($_GET['d']) ? $_GET['d'] : 01200090;
header("Content-Type:image/jpeg");
header("Content-disposition:inline; filename=\"$img\"");
$gambar_asli = imagecreatefromjpeg("imgslide/$img");
$w_asli = imagesx($gambar_asli);
$h_asli = imagesy($gambar_asli);

$w = substr($d,0,4);
$h = substr($d,4,4);
if($w_asli/$h_asli < $w/$h)
{
	$w_kecil = $w;
	$h_kecil = $h_asli * ($w_kecil/$w_asli);
	$x = 0;
	$y = ($h_kecil - $h)/2;
}
else
{
	$h_kecil = $h;
	$w_kecil = $w_asli * ($h_kecil/$h_asli);
	$x = ($w_kecil - $w)/2;
	$y = 0;
}
$gambar_kecil = imagecreatetruecolor($w, $h );
imagecopyresampled($gambar_kecil, $gambar_asli, 0, 0, $x, $y, $w_kecil, $h_kecil, $w_asli, $h_asli);
imagejpeg($gambar_kecil);
imagedestroy($gambar_kecil);
imagedestroy($gambar_asli);
?>