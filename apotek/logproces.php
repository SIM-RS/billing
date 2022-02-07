<?php 
session_start();
 include("koneksi/konek.php");
// $username=$_POST["username"];
 $username=mysqli_real_escape_string($konek,$_POST["username"]);
// $password=$_POST["password"];
 $password=mysqli_real_escape_string($konek,$_POST["password"]);
// $shift=$_POST["shift"];
 $shift=mysqli_real_escape_string($konek,$_POST["shift"]);
 $strEvent = "SET GLOBAL event_scheduler=1";
 //echo $strSQL."<BR>";
 $rsEvent = mysqli_query($konek,$strEvent);
 //echo "USER=$username,PWD=$password,SHIFT=$shift"."<BR>";
 $strSQL = "select * from a_user left join a_unit on unit=UNIT_ID where username='$username' and password=password('$password')";
 //echo $strSQL."<BR>";
 $rs = mysqli_query($konek,$strSQL);
 //echo "tes";
if($rows=mysqli_fetch_array($rs)){
	//echo "ada";
	$sql="select * from a_unit where UNIT_TIPE=1 and UNIT_ISAKTIF=1";
	$rs1=mysqli_query($konek,$sql);
	if ($rows1=mysqli_fetch_array($rs1)) $id_gudang=$rows1["UNIT_ID"];
	//echo "shift=".$shift."<br>";
	$_SESSION["username"]=$username;
	$_SESSION["password"]=$password;
	$_SESSION["shift"]=$shift;
	$_SESSION["iduser"]=$rows['kode_user'];
	$_SESSION["kategori"]=$rows['kategori'];
	$_SESSION["ses_unit_tipe"]=$rows['UNIT_TIPE'];
	$_SESSION["ses_idunit"]=$rows['unit'];
	$_SESSION["ses_namaunit"]=$rows['UNIT_NAME'];
	$_SESSION["ses_kodeunit"]=$rows['UNIT_KODE'];
	$_SESSION["ses_id_gudang"]=$id_gudang;
	
	 $q = "select * from $dbbilling.b_profil"; 
	  $s = mysqli_query($konek,$q);
	  $d = mysqli_fetch_array($s);
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
	
	 /* $d = mysqli_fetch_array(mysqli_query($konek,"select * from b_profil"));
	  $_SESSION['namaP'] = $d['nama']; $namaRS = $_SESSION['namaP'];
	  $_SESSION['alamatP'] = $d['alamat']; $alamatRS = $_SESSION['alamatP'];
	  $_SESSION['tlpP'] = $d['no_tlp']; $tlpRS = $_SESSION['tlpP'];
	  $_SESSION['emailP'] = $d['email']; $emailRS = $_SESSION['emailP'];*/
	  
	
	//echo $rows['UNIT_TIPE']."<br>";
	/*
	if ($rows['UNIT_TIPE']==1)
    { header("location:gudang/main.php"); }
	elseif ($rows['UNIT_TIPE']==2){
		//echo "shift=".$shift."<br>";
		if ($shift=="0"){
			header("location:../index.php?err=Pilih Shift Kerja Anda Terlebih Dahulu !");
		}else{
			header("location:apotik/main.php");
		}
	}elseif ($rows['UNIT_TIPE']==3)
	{ header("location:poli/main.php"); }
	elseif ($rows['UNIT_TIPE']==4)
	{ header("location:mc/main.php"); }
	elseif ($rows['UNIT_TIPE']==5)
	{ header("location:floorstock/main.php"); }
	elseif ($rows['UNIT_TIPE']==6)
	{ header("location:produksi/main.php"); }
	elseif ($rows['UNIT_TIPE']==7)
	{ header("location:kft/main.php"); }
	elseif ($rows['UNIT_TIPE']==8)
	{ header("location:admin/main.php"); }
	else{ 
		header("location:../index.php");
	}
	*/
	
	$cShift="SELECT a.UNIT_ID 
			FROM
			a_unit a
			INNER JOIN a_user_unit b ON a.UNIT_ID=b.unit_id
			WHERE b.user_id = '".$rows['kode_user']."' AND a.UNIT_ISAKTIF=1 AND a.UNIT_TIPE=2";
	$qShift=mysqli_query($konek,$cShift);
	if((mysqli_num_rows($qShift)>0) && $shift=='0'){
		header("location:../index.php?err=Pilih Shift Kerja Anda Terlebih Dahulu !");
	}
	else{
		header("location:main/main.php");
	}
	
}else{
	//echo "gak dpt login";
	header("location:../index.php?err=Login Gagal, Silahkan Ulangi Lagi Dengan Username dan Password Yang Benar");
}
?>