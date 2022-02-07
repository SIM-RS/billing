<?php
session_start();
include '../inc/koneksi.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
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
<link type="text/css" href="inc/menu/menu2.css" rel="stylesheet" />
<script type="text/javascript" src="inc/menu/jquery.js"></script>
<script type="text/javascript" src="inc/menu/menu.js"></script>                
</head>

<body>
	
        <div id="wrapper">
            <div id="header">
				<?php include("./inc/header.php");?>
            </div>
			<div id="topmenu">
			     <?php include("./inc/menu/menu.php"); ?>
			</div>
			<div id="content">
				<center><table width="403" border="0">
  <tr>
    <td style="font:16px Verdana, Arial, Helvetica, sans-serif">&nbsp;</td>
  </tr>
  <tr>
    <td width="397" style="font:16px Verdana, Arial, Helvetica, sans-serif">Selamat Datang Dihalaman <b>Administrator</b></td>
  </tr>
  <tr>
    <td align="center"><img src="images/images.png" /></td>
  </tr>
</table>

				</center>   
			</div>
            <div id="footer">
				<?php
						$query = mysql_query("SELECT pegawai.id, pegawai.nama
						/*pgw_jabatan.id, pgw_jabatan.jbt_id,
						ms_jabatan_pegawai.id, ms_jabatan_pegawai.nama_jabatan*/
						FROM rspelindo_billing.b_ms_pegawai pegawai
						/*INNER JOIN rspelindo_hcr.pgw_jabatan ON pgw_jabatan.pegawai_id = pegawai.pegawai_id
						LEFT JOIN rspelindo_hcr.ms_jabatan_pegawai ON ms_jabatan_pegawai.id = pgw_jabatan.jbt_id*/
						WHERE pegawai.id=".$_SESSION['userId']);
						//echo $query;
				//	$i=0;
					//$pegawai='';
					//$jabatan='';
					while($row = mysql_fetch_array($query)){
						if($i==0)
							$pegawai = $row['nama'];
						if($i>0)
							//$jabatan .= ", ";
						//$jabatan .= $row['nama_jabatan'];	
						$pegawai = $row['nama'];
						//$i++; 
					}
				?>
               	<div style="float:left;">Nama: <span style="color:yellow"><?php echo $pegawai;?></span></div>
				<div style="float:right;"> <span style="color:yellow;"><!--<?=$jabatan?></span> : Jabatan--></div>
            </div>
            
        </div>
</body>
</html>