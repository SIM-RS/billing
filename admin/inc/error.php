<?php
session_start();
include '../inc/koneksi.php';
if(!isset($_SESSION['userId']) || $_SESSION['userId'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='../index.php';
                        </script>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ADMINISTRATOR -- Sistem Informasi Manajemen Rumah Sakit</title>
			            
</head>

<body>
	
        <div id="wrapper">
            <div id="header">
			<?php include("./header.php");?>
            </div>
            
          <div id="topmenu">
                 <?php include("./menu/menu.php"); ?>
          </div>
            
            <div id="content">
                <center>
                <img src="../images/filenotfound.png"/>
			    </center>   
            </div>
            
            <div id="footer">
               	<?php include("./footer.php"); ?>
            </div>
            
        </div>
</body>
</html>