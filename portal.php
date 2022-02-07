<?php
	
	include('billing/koneksi/konek.php');
	include_once('billing/sesi.php');
	

	if($_SESSION['logon'] != 1){
		session_destroy();
		header("location:index.php");
	}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />


<!--dibawah ini diperlukan untuk menampilkan popup-->
<script src="billing/theme/jquery-ui/js/jquery-1.8.3.js"></script>
<link rel="stylesheet" type="text/css" href="billing/theme/popup.css" />
<script type="text/javascript" src="billing/theme/prototype.js"></script>
<script type="text/javascript" src="billing/theme/effects.js"></script>
<script type="text/javascript" src="billing/theme/popup.js"></script>
<!--diatas ini diperlukan untuk menampilkan popup-->

<!-- untuk ajax-->
<script type="text/javascript" src="billing/theme/js/ajax.js"></script>


<link rel="shortcut icon" href="billing/icon/favicon.ico" />
<link rel="stylesheet" type="text/css" href="portal/css/index-css.css" /></head>
<title>Portal SIMRS</title>
</head>
<!-- test push git hafiz -->
<body>
<?
include "portal/new_pop_apotek.php";
include "portal/ganti_password.php";
/* include "portal/pop_aset.php";
include "portal/pop_billing.php";
include "portal/pop_keuangan.php";
include "portal/pop_akuntansi.php"; */
?>
<div id="headuser">
	<div class="dropdown" style="float:right;">
		<div class="iconuser">
			<?php $image = ($_SESSION['sex'] == "P")? "female-user.png" : "male-user.png"; ?>
			<img src="portal/images/<?php echo $image; ?>" style="vertical-align:middle" alt="User" width="32"/>
			<span style="margin:0px 10px;"><?php echo $_SESSION['pegawai_nama']; ?></span>
		</div>
		<div class="dropdown-content">
			<a href="javascript:popup_gpass();"><span>Ganti Password</span></a>
			<a href="new_logout.php">
				<img src="portal/images/logout.png" alt="logout" style="vertical-align:middle; width:16px; margin-right:5px;" /><span>Log Out</span>
			</a>
		</div>
	</div>
	<!--div id="adminuser"></div>
	<span id="menuuser">
		<div id="listmenu">
			<a href="javascript:popup_gpass();"><span>Ganti Password</span></a>
			<a href="new_logout.php"><span>Log Out</span></a>
		</div>
	</span-->
	<div style="clear:both;"></div>
</div>
<div id="sangkar_portal">
<div id="header">
	<div id="icon">
		<img src="portal/images/admin.png" alt="Logo Simrs" />
		&nbsp;
	</div>
	<div id="header-title">
		<h1>Portal Aplikasi</h1>
		<h2><font color = "FF0000">Sistem Infomasi Manajemen Rumah Sakit <font color="#000099">Prima Husada Cipta Medan</font></h2>
        <br /><font color = "333333"> Jl. Stasiun No. 92 Belawan
	</div>
	<!--img src="portal/images/index-judul.jpg" /-->
</div>
<div id="markue"><marquee scrollamount="2" scrolldelay="2" direction="right" behavior="alternate" >Selamat Datang di Sistem Informasi Manajemen
</marquee></div>
<div id="isi">



<!--<div id="list_modul">
<div id="modul" onclick="popup_apotek();"><img src="portal/images/apotek.png" /></div>
<div id="modul" onclick="popup_aset();"><img src="portal/images/aset.png" /></div>
<div id="modul" onclick="popup_billing();"><img src="portal/images/billing.png" /></div>
<div id="modul" onclick="popup_keuangan();"><img src="portal/images/keuangan.png" /></div>
<div id="modul" onclick="popup_akuntansi();"><img src="portal/images/akuntansi.png" /></div>
<div style="clear:both;"></div>
</div>-->
<?php 
if($_SESSION['modul'][0] != ""){ ?>
<div id="list_modul" style="width:50%; float:left">
<h3 style="padding:5px; color:#000; background:#FFFF66; border-bottom: 5px solid white; width:95%;  border-radius: 15px 50px; text-align:center;">.: Pelayanan Medis :.</h3>
<?php
	foreach($_SESSION['modul'] as $val){
		switch($val){
			case '1':
				echo '<a id="modul" href="billing/"><img src="portal/images/billing.png" /></a>';
				break;
			case '2':
				echo '<div id="modul" onclick="popup_apotek();"><img src="portal/images/apotek.png" /></div>';
				break;
		}
	}
?>
</div>

<div id="list_modul" style="width:50%; float:left;">
<h3 style="padding:5px; color:#000; background:#FFFF66; border-bottom: 5px solid white; width:95%;  border-radius: 15px 50px; text-align:center;">.: Finance :.</h3>
<?php
	foreach($_SESSION['modul'] as $val){
		switch($val){
			case '3':
				echo '<a id="modul" href="keuangan/home.php"><img src="portal/images/keuangan.png" /></a>';
				break;
			case '4':
				echo '<a id="modul" href="akuntansi/unit/main.php"><img src="portal/images/akuntansi.png" /></a>';
				break;
		}
	}
?>
</div>
<div style="clear:both;"></div>
<div id="list_modul" style="width:50%; float:left">
<h3 style="padding:5px; color:#000; background:#FFFF66; border-bottom: 5px solid white; width:95%;  border-radius: 15px 50px; text-align:center;">.: HCR :.</h3>
<?php
	foreach($_SESSION['modul'] as $val){
		switch($val){
			case '5':
				echo '<a id="modul" href="admin/index.php"><img src="portal/images/admin22.png" /></a>';
				echo '<a id="modul" href="informasi-publik/index.php"><img src="portal/images/informasi.png" /></a>';
				break;

		}
	}
?>
</div>
<div style="clear:both;"></div>
<div id="list_modul" style="width:50%; float:left">
<h3 style="padding:5px; color:#000; background:#FFFF66; border-bottom: 5px solid white; width:95%;  border-radius: 15px 50px; text-align:center;">.:  :.</h3>
<?php
	foreach($_SESSION['modul'] as $val){
		switch($val){
			case '5':
				echo '<a id="modul" href="dashboard/index.php"><img src="portal/images/dashboard.png" /></a>';
				break;
			case '1':
				echo '<a id="modul" href="ppm/index.php"><img src="portal/images/akreditasi.png" /></a>';
				break;
		}
	}
?>
</div>
<!-- <div id="list_modul" style="width:50%; float:left;">
<h3 style="padding:5px; color:#000; background:#FFFF66; border-bottom: 5px solid white; width:95%;  border-radius: 15px 50px; text-align:center;">.: Penunjang Gizi :.</h3>
<?php
/*	foreach($_SESSION['modul'] as $val){
		switch($val){
			case '5':
				echo '<a id="modul" href="gizi/"><img src="portal/images/gizi.png" /></a>';
				break;
		}
	} */
?>
</div> -->
<div style="clear:both;"></div>
<?php } ?>
<!--div id="list_modul">
<h2 style="padding-left:15px; color:#FFF">.: Supply Chain Management :.</h2>
<div id="modul" onclick="popup_aset();"><img src="portal/images/aset.png" /></div>
<div style="clear:both;"></div>
</div-->

<!--<div id="judul_list">Administrator</div>
<div id="list_modul">
<div id="modul" onclick="#"><img src="portal/images/admin.png" /></div>
<div style="clear:both;"></div>
</div>-->

</div>
<div id="footer"> <a href="htpp://www.digital-sense.net" style="color:#FFFF66; text-decoration:none;"></a> </div>

</div>

</body>
</html>
<script>
function buka(modul)
{
	window.location=modul+'/index.php';
}
function popup_apotek()
{
	new Popup('popup_apotek',null,{modal:true,position:'center',duration:0.5})
	$('popup_apotek').popup.show();
}

function popup_gpass()
{
	new Popup('popup_gpassword',null,{modal:true,position:'center',duration:0.5})
	$('popup_gpassword').popup.show();
}

function popup_aset()
{
	new Popup('popup_aset',null,{modal:true,position:'center',duration:0.5})
	$('popup_aset').popup.show();
}
function popup_billing()
{
	new Popup('popup_billing',null,{modal:true,position:'center',duration:0.5})
	$('popup_billing').popup.show();
}
function popup_keuangan()
{
	new Popup('popup_keuangan',null,{modal:true,position:'center',duration:0.5})
	$('popup_keuangan').popup.show();
}
function popup_akuntansi()
{
	new Popup('popup_akuntansi',null,{modal:true,position:'center',duration:0.5})
	$('popup_akuntansi').popup.show();
}
</script>
