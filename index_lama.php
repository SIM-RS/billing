<?php
	session_start();
	include('billing/koneksi/konek.php');
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

<body>
<style>
.tombolx
{
	font:bold 12px tahoma; 
	border:1px solid #090; 
	background: #390;
	color:#FFF;
	padding:3px 4px; 
	cursor:pointer;
}
</style>
<?
/* include "portal/pop_apotek.php";
include "portal/pop_aset.php";
include "portal/pop_billing.php";
include "portal/pop_keuangan.php";
include "portal/pop_akuntansi.php"; */
?>
<div id="sangkar_portal">

<div id="header">
	<div id="icon">
		<img src="portal/images/admin.png" alt="Logo Simrs" />
		&nbsp;
	</div>
	<div id="header-title">
		<h1>Portal Aplikasi</h1>
		<h2>Sistem Infomasi Manajemen Rumah Sakit <font color="#FFCC00">Pelabuhan Medan</font></h2>
        <br /> Jl. Stasiun No. 92 Belawan
	</div>
	<!--img src="portal/images/index-judul.jpg" /-->
</div>
<div id="markue"><marquee scrollamount="2" scrolldelay="2" direction="right" behavior="alternate" >Selamat Datang di Sistem Informasi Manajemen</marquee></div>
<div id="isi">

<!--<div id="list_modul">
<div id="modul" onclick="popup_apotek();"><img src="portal/images/apotek.png" /></div>
<div id="modul" onclick="popup_aset();"><img src="portal/images/aset.png" /></div>
<div id="modul" onclick="popup_billing();"><img src="portal/images/billing.png" /></div>
<div id="modul" onclick="popup_keuangan();"><img src="portal/images/keuangan.png" /></div>
<div id="modul" onclick="popup_akuntansi();"><img src="portal/images/akuntansi.png" /></div>
<div style="clear:both;"></div>
</div>-->
<div id="list_modul" style="width:50%; float:left">
<h2 style="padding-left:15px; color:#FFF">.: Pelayanan Medis :.</h2>
<div id="modul" onclick="popup_apotek();"><img src="portal/images/apotek.png" /></div>
<div id="modul" onclick="popup_billing();"><img src="portal/images/billing.png" /></div>
<div style="clear:both;"></div>
</div>

<div id="list_modul" style="width:50%; float:left">
<h2 style="padding-left:15px; color:#FFF">.: Finance :.</h2>
<div id="modul" onclick="popup_keuangan();"><img src="portal/images/keuangan.png" /></div>
<div id="modul" onclick="popup_akuntansi();"><img src="portal/images/akuntansi.png" /></div>
<div style="clear:both;"></div>
</div>

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
<div id="footer">Powered By : <a href="htpp://www.digital-sense.net">Majapahit Cipta Mandiri</a> </div>

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
