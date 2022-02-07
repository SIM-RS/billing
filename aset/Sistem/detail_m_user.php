<?php
include '../sesi.php';
include '../koneksi/konek.php';
if(isset($_SESSION['userid']) && $_SESSION['userid'] != '') {
    $query = "select usertype from as_ms_user where userid = '".$_SESSION['userid']."' and usertype = 'A'";
    $rs = mysql_query($query);
    $res = mysql_affected_rows();
    if($res > 0) {
        $permit = 1;
    }
    else {
        echo "<script>alert('Anda tidak berhak mengakses halaman ini.');
                window.location='/simrs-tangerang/aset/Sistem/m_user.php';
                </script>";
    }
}
else {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='/simrs-tangerang/';
                        </script>";
}
if(isset($_POST['act']) && $_POST['act'] != '') {
    $userid = $_POST['userid'];
    $passwd = $_POST['passwd'];
    $username = $_POST['username'];
    $usertype = $_POST['usertype'];
    $status = $_POST['status'];
    $unit = $_POST['unit'];
    $address = $_POST['address'];
    $telp = $_POST['telp'];
    $email = $_POST['email'];

    $act = $_POST['act'];
    if($act == 'add') {
        $query = "select * from as_ms_user where userid = '$userid'";
        $rs = mysql_query($query);
        if(mysql_affected_rows() > 0) {
            echo "<script>alert('User Id yang anda minta sudah ada di database, ganti dengan yang lain.');</script>";
        }
        else {
			$sqlIns="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Insert User','insert into as_ms_user (userid,passwd,username,usertype,address,telp,email,status,refidunit) values (".$userid.",password($passwd),".$username.",".$usertype.",".$address.",".$telp.",".$email.",".$status.",".$unit.")','".$_SERVER['REMOTE_ADDR']."')";
					mysql_query($sqlIns);
            $query = "insert into as_ms_user (userid,passwd,username,usertype,address,telp,email,status,refidunit) values ('$userid',password('$passwd'),'$username','$usertype','$address','$telp','$email','$status','$unit')";
            $rs = mysql_query($query);
            $res = mysql_affected_rows();
            if($res > 0) {
              echo "<script>alert('Insert user berhasil');window.location = 'm_user.php';</script>";
            }
            else {
                echo "<script>alert('Insert user gagal, periksa kembali input anda.');</script>";
            }
        }
    }
    else {
	 $sqlUp="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Update User','update as_ms_user set username =".$username.",address=".$address.",usertype=".$usertype.",telp = ".$telp.",email = ".$email.", refidunit = ".$unit.", status = ".$status."
                        where userid = ".$userid."','".$_SERVER['REMOTE_ADDR']."')";
					mysql_query($sqlUp); 
        $query = "update as_ms_user set username = '$username',address = '$address',usertype = '$usertype',telp = '$telp',email = '$email', refidunit = '$unit', status = '$status' where userid = '$userid'";
        mysql_query($query);
        $res = mysql_affected_rows();
        if($res > 0) {
            $change = "berhasil diubah.";
            echo "<script>window.location='m_user.php'</script>";
        }
        else if($res == 0) {
            $change = "tidak ada yang berubah.";
        }
        else {
            $change = "gagal diubah, periksa kembali input.";
        }
        echo "<script>alert('Data $change');</script>";
    }
}
?>
<?php include("../header.php");?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <title>Detail User</title>
    </head>
    <body>
        <div align="center">
            <?php
            
            $act = $_GET['act'];
            $par = "act=$act";
            if($act == 'edit') {
                $iduser = $_GET['iduser'];
                $par .= "&iduser=$iduser";
                $query = "SELECT a.userid, a.username, a.usertype, a.refidunit, b.namaunit, a.address, a.telp, a.email, a.status
                            FROM as_ms_user a left join as_ms_unit b on a.refidunit=b.idunit
                            WHERE a.id='$iduser'";
                $rs = mysql_query($query);
                $rows = mysql_fetch_array($rs);

                $userid = $rows['userid'];
                $username = $rows['username'];
                $usertype = $rows['usertype'];
                $status = $rows['status'];
                $unit = $rows['refidunit'];
                $address = $rows['address'];
                $telp = $rows['telp'];
                $email = $rows['email'];

                $disp = "none";
            }
            else {
                $disp = "''";
            }
            ?>
            <div>
                <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center">
                            <table width="600" cellpadding="4" cellspacing="0" align="center">
                                <tr>
                                    <td height="30" colspan="4" valign="bottom" align="right">
                                        <button class="Enabledbutton" id="backbutton" onClick="location='m_user.php'" title="Back" style="cursor:pointer">
                                            <img alt="back" src="../images/backsmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                            Back to List
                                        </button>
                                        <button type="submit" class="Enabledbutton" id="btnSimpan" name="btnSimpan" onclick="save()" title="Save" style="cursor:pointer">
                                            <img alt="save" src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                            Save Record
                                        </button>
                                        <button class="Disabledbutton" id="undobutton" onClick="location='detail_m_user.php?<?php echo $par;?>'" title="Cancel / Refresh" style="cursor:pointer">
                                            <img alt="undo/refresh" src="../images/undosmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                            Undo/Refresh
                                        </button>
                                    </td>
                                </tr>
                            </table>
                            <form id="form1" name="form1" action="" method="post" onsubmit="return ValidateForm('userid,username,refidunit,email','Ind');">
                                <table cellspacing=0 cellpadding="4" bgcolor="#EDF1FE">
                                    <tr>
                                        <td height="25" colspan="2" align="center" class="header">
                                            .: Data User :.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="148" class="label">User ID </td>
                                        <td width="442" class="content">
                                            <input name="userid"  type="text" class="<?php if($act == 'add') {
                                                echo 'txtmustfilled';
                                            }else {
                                                echo 'txtunedited';
                                                   }?>" id="userid" value="<?php echo $userid; ?>" size="20" maxlength="10" />
                                        </td>
                                    </tr>
                                    <tr style="display: <?php echo $disp;?>">
                                        <td width="148" class="label">Password </td>
                                        <td width="442" class="content">
                                            <input name="passwd"  type="password" class="txtmustfilled" id="passwd" size="20" maxlength="10" />
                                        </td>
                                    </tr>
                                    <tr style="display: <?php echo $disp;?>">
                                        <td width="148" class="label">Konfirmasi Password </td>
                                        <td width="442" class="content">
                                            <input name="conf_passwd"  type="password" class="txtmustfilled" id="conf_passwd" size="20" maxlength="10" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label">Nama User </td>
                                        <td class="content">
                                            <input name="username" type="text" class="txtmustfilled" id="username" value="<?php echo $username; ?>" size="30" maxlength="50"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label">Tipe</td>
                                        <td class="content">
                                            <select name="usertype" class="txt" id="usertype">
                                                <option value="R" <?php if ($usertype=="P") echo "selected" ?>>RTP</option>
                                                <option value="G" <?php if ($usertype=="F") echo "selected" ?>>Gudang</option>
                                                <option value="A" <?php if ($usertype=="A") echo "selected" ?>>Admin</option>
                                                <option value="U" <?php if ($usertype=="M") echo "selected" ?>>UPB</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label">Status</td>
                                        <td class="content">
                                            <select name="status" class="txt" id="status">
                                                <option value="1" <?php if ($status==1) echo "selected" ?>>Aktif</option>
                                                <option value="0" <?php if ($status==0) echo "selected" ?>>Non Aktif</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="header2">Satuan / Unit Kerja </td>
                                    </tr>
                                    <tr>
                                        <td class="label">Unit Kerja </td>
                                        <td class="content">
                                            <select id='unit' name='unit' class='txtmustfilled'>
                                                <option value='0'></option>
                                                <?php
                                                $qUnit = "select idunit,namaunit from as_ms_unit";
                                                $rsUnit = mysql_query($qUnit);
                                                while($rowUnit = mysql_fetch_array($rsUnit)) {
                                                    echo "<option value='".$rowUnit['idunit']."' ";
                                                    if($rowUnit['idunit'] == $unit) {
                                                        echo "selected ";
                                                    }
                                                    echo ">".$rowUnit['namaunit']."</option>";
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="header2">Biodata &amp; Kontak</td>
                                    </tr>
                                    <tr>
                                        <td class="label">Alamat</td>
                                        <td class="content">
                                            <input name="address" type="text" class="txt" id="address" value="<?php echo $address; ?>" size="60" maxlength="60"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label">Telp</td>
                                        <td class="content">
                                            <input name="telp" type="text" class="txt" id="telp" value="<?php echo $telp; ?>" size="20" maxlength="30"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="23" class="label">Email</td>
                                        <td class="content">
                                            <input name="email" type="text" class="txtmustfilled" id="email" value="<?php echo $email; ?>" size="50" maxlength="50"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="25" colspan="2" class="footer">&nbsp;</td>
                                    </tr>
                                </table>
                                <input type="hidden" name="act" value="<?php echo $act;?>"/>
                            </form>
                            <?php
                            include '../footer.php';
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
    <script type="text/javascript" language="javascript">
        function save()
		{
			var unitx = document.getElementById('unit').value;
			var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/; 
			var emailaddress = document.getElementById('email').value;
			
            if(ValidateForm('userid,username,unit,email','Ind') == true)
			{
				if(unitx==0)
				{
					alert('Pilih Unit Kerja');
				}
				else if(!emailReg.test(emailaddress))
				{
					alert("Masukkan email yang valid");
				}
				else
				{
					if('<?php echo $act;?>' == 'add')
					{
						if(ValidateForm('passwd,conf_passwd', 'Ind'))
						{
							if(document.getElementById('passwd').value == document.getElementById('conf_passwd').value)
							{
								document.form1.submit();
							}
							else
							{
								alert('Password anda tidak sama dengan konfirmasi passwordnya.');
							}
						}
					}
					else
					{
						document.form1.submit();
					}
				}
            }
        }
    </script>
</html>
