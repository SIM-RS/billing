<?php
session_start();
include("koneksi/konek.php");

$userId=$_REQUEST['txtUser_billing'];
$passwd=$_REQUEST['txtPass_billing'];
//if($userId!='' && $passwd!=''){
   $sql="select * from b_ms_pegawai where username='$userId' and pwd=password('$passwd')";
   //echo $sql."<br>";
   $rs=mysql_query($sql);
   $rw=mysql_fetch_array($rs);
   //print_r($rw);
   if(mysql_num_rows($rs)>0){
		//$sqlLog = "insert into b_login_user_log(type,user_act,tgl_act,ip,pcname) values('1','".$rw['id']."',NOW(),'".$_SERVER['REMOTE_ADDR']."','".gethostbyaddr($_SERVER['REMOTE_ADDR'])."')";
		//$qLog = mysql_query($sqlLog);

		$_SESSION['userId']=$rw['id'];
		$_SESSION['userName']=$rw['username'];
		$_SESSION['unitId']=$rw['unit_id'];
		$_SESSION['spesialis']=$rw['spesialisasi_id'];
		$_SESSION['user_id_inacbg']=$rw['user_id_inacbg'];
		$_SESSION['nm_pegawai']=$rw['nama'];

		$q = "select * from b_profil"; 
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
		$_SESSION['kecP'] = $d['kecamatan']; 
	  
		$sql1="SELECT * FROM b_ms_group_petugas WHERE ms_pegawai_id = $rw[id]";
  		 //echo $sql."<br>";
  		$rs1=mysql_query($sql1);
  	    $rw1=mysql_fetch_array($rs1);
	  	//echo ;
		$_SESSION['group']=$rw1['ms_group_id'];
		
		$sql2="SELECT * FROM b_ms_pegawai_unit WHERE ms_pegawai_id = $rw[id]";
	  	$rs2=mysql_query($sql2);
		$ii = 0;
		while($rw2=mysql_fetch_array($rs2))
		{
			$_SESSION['unit_tmp'][$ii] = $rw2['unit_id'];
			$ii++;
		}
		
		/*for($jj=0;$jj<=count($_SESSION['unit_tmp']);$jj++)
		{
			echo $_SESSION['unit_tmp'][$jj]."<br>";
		}*/
      ?>
      <a href="logout_proc.php">logout</a>
      <script>
         window.location='../billing/';
      </script>
      <?php
   }
   else{
      ?>
      <script>
         alert('Username atau password salah!');
         window.location='../index.php';
      </script>
      <?php

   }
/*}
else{
?>
  <script>
         alert('silakan login dahulu!');
         window.location='index.php';
      </script>
<?php
}
*/
mysql_close($konek);
?>
