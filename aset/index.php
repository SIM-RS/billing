<?php
session_start();
include("koneksi/konek.php");
$sqlIns="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Finish Login','','".$_SERVER['REMOTE_ADDR']."')";
mysql_query($sqlIns);
echo mysql_error();


if(isset($_SESSION['userid']) && $_SESSION['userid'] != '') {
    session_destroy();
}
	//include '../koneksi/konek.php';
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="theme/js/mod.js"></script>
        <link type="text/css" rel="stylesheet" href="theme/mod.css"/>
        <script type="text/javascript" language="JavaScript" src="theme/js/dsgrid.js"></script>
        <link type="text/css" href="menu.css" rel="stylesheet" />
        <script type="text/javascript" src="jquery.js"></script>
        <script type="text/javascript" src="menu.js"></script>
        <title>.: ASET :.</title>
    </head>
    <body>
        <!-- ImageReady Slices (apotek2.psd) -->
        <div align="center">
            <?php
            
            $file=$_GET["f"];
            if ((strpos($file,".php")<=0)&&($file!="")) $file .=".php";
            ?>
            <table align="center" id="Table_01" width="1000" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="1000" height="158" align="center">
                        <img src="images/aset_01.png" width="1000" height="158" alt=""></td>
                </tr>
                <tr valign="top">
                    <td align="center" valign="top">
                        <?php include ("menu_awal.php");?>
                        <div>
                        <?php
                        include "login.php";
                        include 'footer.php';
                        ?>
                        </div>
                    </td>
                </tr>
                <!--tr>
                        <td width="1000" valign="top"><?php //include("main.php");?></td>
          </tr>
                <tr>
                        <td valign="top"><img src="images/aset_05.gif" width="999" height="65" alt=""></td>
          </tr-->
            </table>
        </div>
        <!-- End ImageReady Slices -->
    </body>
</html>