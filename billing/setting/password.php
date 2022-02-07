<?php
session_start();
include("../sesi.php");
?>
<?php
	//session_start();
	$userId = $_SESSION['userId'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css">
<title>Form Setting Pengguna</title>
</head>
<body>
<div align="center">
<?php
	include("../koneksi/konek.php");
	include("../header1.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	
	$sql = "SELECT RIGHT(MAX(kode),3) AS kode FROM b_ms_group";
	$rs = mysql_query($sql);
	$rw = mysql_fetch_array($rs);
	
	if(isset($_POST['kirim']) && $_POST['kirim'] == 'SIMPAN'){
		$query = "select * from b_ms_pegawai where id = '$userId' and pwd = password('".$_POST['old_pass']."')";
		$rs = mysql_query($query);
		if(mysql_num_rows($rs) > 0){
			$query = "update b_ms_pegawai set pwd = password('".$_POST['new_pass']."') where id = '$userId'";
			mysql_query($query);
			echo "<script>alert('Update password anda berhasil, \nIngat baik-baik password anda.');</script>";
		}
		else{
			echo "<script>alert('Password lama anda salah, update password dibatalkan.');</script>";
		}
	}
?>
<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
	<tr>
		<td height="30">&nbsp;GANTI PASSWORD PENGGUNA</td>
	</tr>
</table>
<table align="center" width="1000" border="0" cellpadding="0" cellspacing="1" height="450" class="tabel" >
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
			<form action="" method="post" onsubmit="return submit36()">
				<table align="center" class="tabel">
					<tr>
						<td width="180" style="padding-left: 10px;">
							Password Lama
						</td>
						<td>
							: <input type="password" id="old_pass" name="old_pass" />
						</td>
					</tr>
					<tr>
						<td style="padding-left: 10px;">
							Password Baru
						</td>
						<td>
							: <input type="password" id="new_pass" name="new_pass" />
						</td>
					</tr>
					<tr>
						<td style="padding-left: 10px;">
							Konfirmasi Password Baru
						</td>
						<td>
							: <input type="password" id="konf_new" name="konf_new" />
						</td>
					</tr>
					<tr>
						<td colspan="2" align="right">
							<input type="submit" id="kirim" class="tblBtn" name="kirim" value="SIMPAN" />
							<input type="reset" class="tblBtn" value="BATAL" />
						</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
  <tr height="30">
  	<td>&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" class="btninput" /></td>
	<td>&nbsp;</td>
	<td align="right"><a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" class="btninput"/></a>&nbsp;</td>
  </tr>
</table>
</div>
</body>
<script>
function submit36(){
	if( document.getElementById('konf_new').value == '' || document.getElementById('new_pass').value == ''){
		alert('Password baru harus diisi!');
		return false;
	}
	else if(document.getElementById('new_pass').value != document.getElementById('konf_new').value){
		alert('Password baru dan konfirmasi password baru harus sama!');
		return false;
	}
	return true;
}
</script>
</html>
