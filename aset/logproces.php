<?php 
session_start();
$iusr=$_POST["txtUser"];
$ipwd=$_POST["txtPass"];
include("koneksi/konek.php");
$sql="SELECT DISTINCT u.id, u.address, u.email, u.passwd, u.refidunit, u.status, u.telp, u.userid, u.username, u.usertype
FROM as_ms_user u  WHERE u.userid = '$iusr' AND u.passwd = PASSWORD('$ipwd') AND u.status=1";
// INNER JOIN as_ms_unit un ON un.t_userid = u.userid
$rs=mysql_query($sql);
if ($rows=mysql_fetch_array($rs)){
    $_SESSION['id_user'] = $rows['id'];
    $_SESSION['userid'] = $rows['userid'];
    $_SESSION['usertype'] = $rows['usertype'];
    $_SESSION['refidunit'] = $rows['refidunit'];
	$_SESSION['nmuser'] = $rows['username'];
	
	  $q = "select * from rspelindo_billing.b_profil"; 
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
	
	$page = "Sistem/info_user.php";//"Tabel/kode_brg.php";//"index.php?f=Tabel/menu.php";
	
	$t_userid = $_SESSION['id_user'];
    $t_ipaddress = $_SERVER['REMOTE_ADDR'];
	
	mysql_query("insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('$t_userid',now(),'Start Login','','$t_ipaddress')");
	
	mysql_free_result($rs);
	mysql_close($konek);
	//echo "$q";
	//echo $_SESSION['userid'];
	header("Location: $page");
}else{
	mysql_free_result($rs);
	mysql_close($konek);
	header("Location: ../index.php?err_aset=Login Gagal");
}
?>