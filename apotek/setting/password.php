<?php
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");

$userId = $iduser;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
<title>Form Setting Pengguna</title>
</head>
<body>
<div align="center">
<?php
	//include("../header1.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	
	//$sql = "SELECT RIGHT(MAX(kode),3) AS kode FROM b_ms_group";
	//$rs = mysqli_query($konek,$sql);
	//$rw = mysqli_fetch_array($rs);
	$kirim=$_POST['kirim'];
	$old_pass=$_POST['old_pass'];
	$new_pass=$_POST['new_pass'];
	convert_var($kirim,$old_pass,new_pass);
	
	if(isset($kirim) && $_POST['kirim'] == 'SIMPAN'){
		$query = "select * from a_user where kode_user = '$userId' and password = password('".$old_pass."')";
		$rs = mysqli_query($konek,$query);
		if(mysqli_num_rows($rs) > 0){
			$query = "update $dbbilling.b_ms_pegawai set pwd = password('".$new_pass."') where id = '$userId'";
			mysqli_query($konek,$query);
			echo "<script>alert('Update password anda berhasil, \nIngat baik-baik password anda.');</script>";
		}
		else{
			echo "<script>alert('Password lama anda salah, update password dibatalkan.');</script>";
		}
	}
?>
<form method="post">
<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
	<tr>
		<td height="30" align="center">GANTI PASSWORD</td>
	</tr>
</table>
<table align="center" class="tabel" width="500">
				<tr>
                	<td>&nbsp;</td>
                </tr>
					<tr>
						<td width="250" style="padding-left: 10px;">
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
                    	<td>&nbsp;</td>
                    </tr>
					<tr>
						<td colspan="2" align="center">
							<input type="submit" id="kirim" class="tblBtn" name="kirim" value="SIMPAN" />
							<input type="reset" class="tblBtn" value="BATAL" />
						</td>
					</tr>
				</table>
</form>
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
