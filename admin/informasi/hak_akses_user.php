<?php
session_start();
include '../inc/koneksi.php';
if(!isset($_SESSION['userId']) || $_SESSION['userId'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='../../index.php';
                        </script>";
}
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Informasi User</title>
	<link type="text/css" href="../inc/menu/menu.css" rel="stylesheet" />
	<script type="text/javascript" src="../js/jquery-1.7.2.js"></script>
	<script type="text/javascript" src="../inc/menu/menu.js"></script> 
	<style type="text/css">
		body{ font-size:12px !important; font-family:Tahoma !important; }
		#content{ padding:10px; }
		#userIframe{
			border:1px solid #DDDDDD; 
			width:100%; 
			height:320px; 
			margin-top:20px;
			overflow-x: scroll;
			overflow-y: hidden;
		}
	</style>
</head>
<body>
	<div id="wrapper">
        <div id="header">
			<?php include("../inc/header.php");?>
        </div>
            
        <div id="topmenu">
            <?php include("../inc/menu/menu.php"); ?>
        </div>
            
        <div id="content">
			<table id="filterForm" align="center" style="background:#6396C9; padding:10px; border-radius:10px; color:#fff; ">
				<tr>
					<td colspan="3" style="font-weight:bold; font-size:18px;">Filter By</td>
				</tr>
				<tr>
					<td width="80px" >Modul</td>
					<td>:</td>
					<td>&nbsp;
						<select name="modul" id="modul" onchange="setFilter()">
							<option value="0" selected >-- Semua --</option>
							<?php
								$query = mysql_query('SELECT * FROM ms_modul ORDER BY nama ASC');
								if($query && mysql_num_rows($query) > 0){
									while($modul = mysql_fetch_object($query))
										echo "<option value='".$modul->id."'>".$modul->nama."</option>";
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Nama</td>
					<td>:</td>
					<td>&nbsp;
						<input type="text" size="30" id="user" name="user" />
					</td>
				</tr>
			</table>
			<iframe name="userIframe" id="userIframe" src="hak_akses_utils.php?user=&modul=0" frameborder="0"></iframe>
		</div>
	</div>
	<script type="text/javascript">
		function setFilter(){
			var url = "hak_akses_utils.php?user="+jQuery('#user').val()+"&modul="+jQuery('#modul').val();
			jQuery("#userIframe").attr("src", url);
		}
		
		jQuery('#user').keypress(function(e) {
			if(e.which == 13) {
				setFilter();
			}
		});
	</script>
</body>
</html>