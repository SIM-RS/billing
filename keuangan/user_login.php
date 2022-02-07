<?php
session_start();
include "koneksi/konek.php";
$user = $_POST['username'];
$pass = $_POST['password'];
$sql = "select * from k_ms_user where username = '$user' and pwd = password('$pass')";
$rs = mysql_query($sql);
$res = mysql_num_rows($rs);
if($res > 0){
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
	
    $row = mysql_fetch_array($rs);
    $_SESSION['user'] = $row['username'];
    $_SESSION['id'] = $row['id'];
    $_SESSION['hak'] = $row['hak_akses'];
    header("location:home.php");
}
else{
    //header("location:../index.php");
?>
      <script>
         alert('Username atau password salah!');
         window.location='../index.php';
      </script>
<?php
}
?>