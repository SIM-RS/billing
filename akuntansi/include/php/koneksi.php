<?php

$baseDir = dirname(__FILE__);

require $baseDir.'/../../../inc/koneksi.php';


	// $server = "192.168.0.3";
	// $username = "root";
	// $password = "";
	$database_name = "rssh_finance";
	
	// $conn = mysql_connect($server,$username,$password) or die ("Username or Password require to open databases is not valid");
	mysql_select_db($database_name,$conn) or die ("Databases ".$database_name." was not found");
if (!function_exists('kekata')) {
function kekata($x) {
  $x = abs($x);
  $angka = array("", "satu", "dua", "tiga", "empat", "lima",
  "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
  $temp = "";
  if ($x <12) {
	  $temp = " ". $angka[$x];
  } else if ($x <20) {
	  $temp = kekata($x - 10). " belas";
  } else if ($x <100) {
	  $temp = kekata($x/10)." puluh". kekata($x % 10);
  } else if ($x <200) {
	  $temp = " seratus" . kekata($x - 100);
  } else if ($x <1000) {
	  $temp = kekata($x/100) . " ratus" . kekata($x % 100);
  } else if ($x <2000) {
	  $temp = " seribu" . kekata($x - 1000);
  } else if ($x <1000000) {
	  $temp = kekata($x/1000) . " ribu" . kekata($x % 1000);
  } else if ($x <1000000000) {
	  $temp = kekata($x/1000000) . " juta" . kekata($x % 1000000);
  } else if ($x <1000000000000) {
	  $temp = kekata($x/1000000000) . " milyar" . kekata(fmod($x,1000000000));
  } else if ($x <1000000000000000) {
	  $temp = kekata($x/1000000000000) . " trilyun" . kekata(fmod($x,1000000000000));
  }      
	  return $temp;
}
}

if (!function_exists('terbilang')) {
function terbilang($x, $style=4) {
  if($x<0) {
	  $hasil = "minus ". trim(kekata($x));
  } else {
	  $hasil = trim(kekata($x));
  }      
  switch ($style) {
	  case 1:
		  $hasil = strtoupper($hasil);
		  break;
	  case 2:
		  $hasil = strtolower($hasil);
		  break;
	  case 3:
		  $hasil = ucwords($hasil);
		  break;
	  default:
		  $hasil = ucfirst($hasil);
		  break;
  }      
  return $hasil;
}
}
	
if(!function_exists('currency2'))
{
	function currency2($angka)
	{
		$rupiah= number_format($angka,2,'.',',');
		return $rupiah;
	}
}
if (!function_exists('tglSQL')) 
{
	function tglSQL($tgl)
	{
	   $t=explode(" ",$tgl);
	   $t=explode("-",$t[0]);
	   $t=$t[2].'-'.$t[1].'-'.$t[0];
	   return $t;
	}
}

if (!function_exists('tglJamSQL')) 
{
	function tglJamSQL($tgl)
	{
	   $dateTime=explode(" ",$tgl);
	   $dateTime=tglSQL($dateTime[0])." ".$dateTime[1];
	   return $dateTime;
	}
}
function replace_single_quote($kata) 
{
	$kata = str_replace("'","&#39;",$kata);
	return $kata;
}

?>