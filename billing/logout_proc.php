<?php
include('koneksi/konek.php');
session_start();
if(isset($_SESSION['userId'])){
   // $sqlLog = "insert into b_login_user_log(type,user_act,tgl_act,ip,pcname) values('0','".$_SESSION['userId']."',NOW(),'".$_SERVER['REMOTE_ADDR']."','".gethostbyaddr($_SERVER['REMOTE_ADDR'])."')";
   // $qLog = mysql_query($sqlLog);
   
   session_destroy();
   ?>    
    <script>
      alert('Anda telah logout');
      window.location='../';      
   </script>
   <?php
   
}
?>
 <script>
      alert('Anda belum login');
      window.location='../';
   </script>