<?php 
include("koneksi/konek.php");
 $username=$_POST[username];
 $password=$_POST[password];
 $strSQL = "select * from user_master where username='$username' and password=password('$password')";
 //echo $strSQL."<br>";
 $rs = mysql_query($strSQL);
 
if($rows=mysql_fetch_array($rs))
{
	session_start();
	
		$q = "select * from $dbbilling.b_profil"; 
		$s = mysql_query($q);
		$d = mysql_fetch_array($s);
		$_SESSION['namaP'] = $d['nama']; 
		$_SESSION['alamatP'] = $d['alamat']; 
		$_SESSION['kode_posP'] = $d['kode_pos']; 
		$_SESSION['tlpP'] = $d['no_tlp']; 
		$_SESSION['faxP'] = $d['fax']; 
		$_SESSION['emailP'] = $d['email']; 
		$_SESSION['pemkabP'] = $d['pemkab']; 
		$_SESSION['kotaP'] = $d['kota']; 
		$_SESSION['tipe_kotaP'] = $d['tipe_kota']; 
		$_SESSION['propinsiP'] = $d['propinsi'];
	
	$_SESSION['akun_username']=$username;
	$_SESSION['akun_password']=$password;
	$_SESSION['akun_iduser']=$rows['kode_user'];
	$_SESSION['akun_kategori']=$rows['kategori'];
	$_SESSION['akun_ses_idunit']="1";

		if ($rows[kategori]==1 OR $rows[kategori]==2)
    	{header("location:unit/main.php");}
		else
    	{ header("location:../../index.php");}
}
else
{
header("location:../index.php");
}

/*
$logas=$_REQUEST['logas'];
$page="index.php";
switch ($usr){
	case "spp":
		$page="bauk/main.php";
		$ses_usrname="Unit Layanan SPP";
		$ses_idunit="6";
		break;
	case "spi":
		$page="bauk/main.php";
		$ses_usrname="Unit Layanan SPI";
		$ses_idunit="7";
		break;
	case "ikoma":
		$page="bauk/main.php";
		$ses_usrname="Unit Layanan Ikoma";
		$ses_idunit="10";
		break;
	case "amu":
		$page="bauk/main.php";
		$ses_usrname="Unit Layanan Aset Manajemen Unit";
		$ses_idunit="12";
		break;
	case "spj":
		$page="bauk/main.php";
		$ses_usrname="Unit Layanan SPJ";
		$ses_idunit="14";
		break;
	case "lpm":
		$page="bauk/main.php";
		$ses_usrname="Unit Layanan LPM/MMT";
		$ses_idunit="11";
		break;
	case "ku":
		$page="bauk_keu/main.php";
		$ses_usrname="Biro Akuntansi";
		$ses_idunit="18";
		break;
	case "unit":
		$page="unit/main.php";
		$ses_usrname="Unit";
		$ses_idunit="1";
		break;
	case "fakultas":
		$page="fakultas/main.php";
		$ses_usrname="Fakultas";
		$ses_idunit="4";
		break;
	case "bapsi":
		$page="bapsi/main.php";
		$ses_usrname="BAPSI";
		$ses_idunit="17";
		break;
	case "admin":
		$page="admin/main.php";
		$ses_usrname="Administrator";
		$ses_idunit="18";
		break;
	default:
		$page="index.php";
		break;
}
$iduser=$ses_idunit;
$_SESSION["ses_usrname"]=$username;
$_SESSION["ses_iduser"]=$username;
$_SESSION['akun_ses_idunit']=$ses_idunit;
header("Location: $page");
*/
?>