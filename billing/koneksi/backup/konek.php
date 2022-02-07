<?php
$hostname_conn = "localhost";
//$hostname_conn = "192.168.0.3";
$database_conn = "rspelindo_billing";
//$database_conn = "billing_tangerang";
$username_conn = "userdb_rs";
$username_conn = "admindb_kadal";
//$password_conn = "root";
//$password_conn = "U8yyz5bM7CMqqTR";
$password_conn = "mysqlk4d4lt9rk0t4";

$dbbilling=$database_conn;
$dbapotek="rspelindo_apotek";
$dbgizi="rspelindo_gizi";
//$dbapotek="dbapotek_tangerang";
$dbbank_darah="rspelindo_bank_darah";
//$dbbank_darah="bank_darah_tangerang";
$dbaskep="rspelindo_askep";
$dbcssd="rspelindo_cssd_loundry";
$dbaset="rspelindo_asset";

$url_pacs="http://192.168.1.2:8080/ds-ris/View_Study?";
$remoteAE="DCM4CHEE@localhost:11112";

$idKasirPendaftaranRJ=127;
$idKasirRJ=81;

//$base_addr="/simrs-tangerang";
$base_addr="";

$konek=mysql_connect($hostname_conn,$username_conn,$password_conn);
mysql_select_db($database_conn,$konek);

$perpage=100;

function tglSQL($tgl){
   $t=explode(" ",$tgl);
   $t=explode("-",$t[0]);
   $t=$t[2].'-'.$t[1].'-'.$t[0];
   return $t;
}

function tglJamSQL($tgl){
   $dateTime=explode(" ",$tgl);
   $dateTime=tglSQL($dateTime[0])." ".$dateTime[1];
   return $dateTime;
}

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

$sql="SELECT * FROM b_ms_reference WHERE stref=24";
//echo $sql."<br>";
$rsBD=mysql_query($sql);
$rwBD=mysql_fetch_array($rsBD);
$backdate=$rwBD["nama"];
$DisableBD='';
if ($backdate=="0"){
	$DisableBD='disabled="disabled"';
}

$pTglSkrg=gmdate('Y-m-d',mktime(date('H')+7));

function ValidasiText($x) {
	$txt=str_replace("'","''",$x);
	return $txt;
}

$sql="SELECT * FROM b_ms_reference WHERE stref=32";
$rsICU_HCU=mysql_query($sql);
$rwICU_HCU=mysql_fetch_array($rsICU_HCU);
$UnitId_ICU_HCU=$rwICU_HCU["nama"];

$sql="SELECT * FROM b_ms_reference WHERE stref=33";
$rsKamarICU_HCU=mysql_query($sql);
$rwKamarICU_HCU=mysql_fetch_array($rsKamarICU_HCU);
$kamarIdHCU=$rwKamarICU_HCU["nama"];

if(!function_exists('tgl_ina')){
	function tgl_ina($tgl){
		$tanggal = substr($tgl,8,2);
		$bulan   = getBulan(substr($tgl,5,2));
		$tahun   = substr($tgl,0,4);
		return $tanggal.' '.$bulan.' '.$tahun;
	}
}

if(!function_exists('getBulan')){
	function getBulan($bln){
		switch ($bln){
		  case 1: 
		  return "Januari";
		  break;
		  case 2:
		  return "Februari";
		  break;
		  case 3:
		  return "Maret";
		  break;
		  case 4:
		  return "April";
		  break;
		  case 5:
		  return "Mei";
		  break;
		  case 6:
		  return "Juni";
		  break;
		  case 7:
		  return "Juli";
		  break;
		  case 8:
		  return "Agustus";
		  break;
		  case 9:
		  return "September";
		  break;
		  case 10:
		  return "Oktober";
		  break;
		  case 11:
		  return "November";
		  break;
		  case 12:
		  return "Desember";
		  break;
		}
	} 
}

if(!function_exists('getHari')){
	function getHari($bln){
		switch ($bln){
		  case "Monday": 
		  return "Senin";
		  break;
		  case "Tuesday":
		  return "Selasa";
		  break;
		  case "Wednesday":
		  return "Rabu";
		  break;
		  case "Thursday":
		  return "Kamis";
		  break;
		  case "Friday":
		  return "Jumat";
		  break;
		  case "Saturday":
		  return "Sabtu";
		  break;
		  case "Sunday":
		  return "Minggu";
		  break;
		}
	} 
}
?>
