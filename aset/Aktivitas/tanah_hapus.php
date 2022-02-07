<?php
include '../sesi.php';
include '../koneksi/konek.php'; 
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
        window.location='$def_loc';
        </script>";
}
$id=$_REQUEST['id'];
$tgl=$_POST['tglsert'];
$tgl=explode('-',$tgl);
$tgl=$tgl[2]."-".$tgl[1]."-".$tgl[0];
$alasan=$_POST['alasan'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link type="text/css" rel="stylesheet" href="../default.css"/>
<link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Hapus Data  :.</title>
</head>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
	frameborder="1"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>
<script language="javascript">
   var arrRange=depRange=[];
</script>
<body>
<form action="" method="post" id="form1">
<table align="center" width="650" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
<td align="center">
	<table width="500" align="center" cellpadding="0" cellspacing="0" class="login">
	<tr>
		<td colspan="2" class="header">.: Form Penghapusan Jalan,Irigasi &amp; jalan :.</td>
	</tr>
	<tr>
		<td colspan="2" class="label">&nbsp;</td>
	</tr>
	<tr>
		<td width="210" class="label">Tgl Hapus</td>
		<td width="288" class="content"><input type="text" id="tglsert" name="tglsert" class="txt" size="20" value="<?php echo date("d-m-Y"); ?>">
		<img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tglsert'),depRange);" />	
		<font color="#666666"><em>(dd-mm-yyyy)</em></font> </td>
	</tr>
	<tr>
		<td class="label">Alasan Hapus</td>
		<td class="content"><textarea rows="2" cols="40" id="alasan" name="alasan"></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="center" class="label"><input type="submit" id="hapus" name="hapus" value="Hapus" />&nbsp;&nbsp;&nbsp;<input type="button" id="batal" name="batal" value="Batal" onclick="window.close()" /></td>
	</tr>
	</table>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td><div><img src="../images/foot.gif" width="650" height="45"></div></td>
</tr>
</table>
</form>
</body>
</html>
<?php 
if(isset($_POST['hapus'])){
$sqlIns="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Hapus Kib Tanah','update as_seri2 set isaktif=0, tgl_hapus=$tgl, ket_hapus=$alasan where idseri=$id','".$_SERVER['REMOTE_ADDR']."')";
		mysql_query($sqlIns);
		
	$sqlupdate="update as_seri2 set isaktif='0', tgl_hapus='$tgl', ket_hapus='$alasan' where idseri='$id'";
	$rs=mysql_query($sqlupdate);
	if($rs!=mysql_error()){
        echo "<script>window.opener.rek.loadURL('jln_util.php?kode=true','','GET');</script>";
        echo "<script>alert('Data Berhasil Dihapus');</script>";
		echo"<script>window.close();</script>";
	}else{
		echo "<script>alert('Terdapat Kesalahan Dalam Menghapus Data Silahkan Ulangi Lagi');</script>";
	}
}
?>
