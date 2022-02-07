<?php
session_start();
/*if(!isset($_SESSION['user_id']) || $_SESSION['user_id'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='/simrs/pendidikan/';
                        </script>";
}*/
//$unit = $_SESSION['user_id'];
include '../koneksi/konek.php';
?>
<!--<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pengaturan Kelas</title>
</head>
<body onLoad="xxx();" >-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Galery</title>
</head>
<style>
.list_galeri{
display:inline-block;
margin:15px 7px 15px 7px;
border:2px solid #999999;
width:180px; 
height:150px; 
}
.tabel2{
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	text-align: left;
	vertical-align: middle;
	background-color:#D7E7FF;
}
</style>
<body>
<div align="center">
	<link href="css/popup.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="css/basic.css" type="text/css" />
	<link rel="stylesheet" href="css/galleriffic-2.css" type="text/css" />
	<script type="text/javascript">
		document.write('<style>.noscript { display: none; }</style>');
	</script>
	<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
	<script type="text/javascript" src="js/jquery.galleriffic.js"></script>
	<script type="text/javascript" src="js/jquery.opacityrollover.js"></script>
	
	<!-- popup list pegawai -->
	<a href="#x" class="overlay" id="login_form"></a>
	<div class="popup">
    <?php
$userId = $_SESSION['userId'];
$sql="SELECT * FROM b_ms_group_petugas WHERE ms_pegawai_id='$userId' AND ms_group_id in (15,49)"; //IN (10,45,46,15)
$rs=mysql_query($sql);
if ((mysql_num_rows($rs)>0)){ //&& ($backdate!="0")
	$disableKunj="";
	?>
    <a onclick="tes();" style="cursor:pointer;">Hapus</a>
<?php }?>
		<section class="slidess" style="display:none;" align="center">
		</section>
		<a class="close" href="#close"></a>
	</div>	
	<!-- end popup list pegawai -->
    <?php 
	$que = "SELECT nama,sex FROM b_ms_pasien WHERE id = '".$_REQUEST['idpasien']."'";
	$data=mysql_fetch_array(mysql_query($que)); 
	?>
<table width="1024" border="0" cellpadding="0" cellspacing="0" bgcolor="#4D89C3"  align="center">
              <tr>
                    <td height="30" style="text-align:center; font:bold 22px tahoma; padding-top:10px;">GALERY - <?=$data['nama'].' ('.$data['sex'].')'?></td>
					<td align="right"><a style="cursor:pointer;" onclick="tutup();" id="aharef"><img width="32" src="../icon/x.png" alt="close"></a></td>
                </tr>
            </table>

<table width="1024" height="500" align="center" cellpadding="3" cellspacing="0" class="tabel2">
	<tr>
		<td valign="top" style="text-align:center; padding-left:15px;"><input id="hilang" name="hilang" type="hidden"/>
		<?php
			$query = "SELECT id FROM b_upload_rm where id_pasien='".$_REQUEST['idpasien']."' ORDER BY tgl_act DESC";
			$q = mysql_query($query);
			$row = mysql_num_rows($q);
			/*if($row==0){echo "<script type='text/javascript'>alert('Data Tidak Ada'); window.close();</script>";}*/
			$no=1;
			while($data = mysql_fetch_array($q))
			{
				
		?>
				<a href="#login_form" id="login_pop" style="text-decoration:none;">
				<div onClick="glrs(<?=$data['id']?>)" class="list_galeri" style="float:left;background:url('ms_galeri_ambil.php?id=<?=$data['id'];?>'); background-size: 180px 150px; background-repeat:no-repeat;">
				<div style="margin-top:110px; width:170px; height:30px; padding:5px; background:#000000; opacity:0.7; border-radius:10px; font:bold 12px tahoma; color:#FFFFFF;">Gambar nomor <?=$no?></div>
                </div>
				</a>
                
		<?php
			$no++;}
		?>
		</td>
	<tr>
    <tr>
		<td height="28" background="../images/main-bg.png" style="background-repeat:repeat-x;">&nbsp;</td>
    </tr>
</table>
</div>

</body>
</html>
<script language="javascript">
function hide(a,b){
	$(a).slideUp(b);
}
function shows(a){
	hide(a,40);
	$(a).slideDown(300);
}
function tes(){
	var hlg = $('#hilang').val();
	//alert(hlg);
	hide('.slidess');
	$('.popup').css("display","none");
	var url = 'single_galeri.php?cek=1&id2='+hlg;
	$('.slidess').load(url);
	setTimeout(function(){
	window.location=('ms_galeri.php?idpasien=<?=$_REQUEST['idpasien']?>&idKunj=<?=$_REQUEST['idKunj']?>&idPel=<?=$_REQUEST['idPel']?>');
	},1000);
}
function glrs(id){
	$('.popup').css("display","block")
	shows('.slidess');
	$('#hilang').val(id);
	var url = 'single_galeri.php?id='+id;
	$('.slidess').load(url);
}
function tutup(){
window.close();	
}
</script>

