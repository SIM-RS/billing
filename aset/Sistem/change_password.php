<?php
include '../sesi.php';
include '../koneksi/konek.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='$def_loc';
                        </script>";
}
if(isset($_POST['act']) && $_POST['act'] == 'change') {
    $query = "select * from as_ms_user where userid = '".$_SESSION['userid']."' and passwd = password('".$_POST['txt_oldPasswd']."')";
    mysql_query($query);
    $res = mysql_affected_rows();
    if($res > 0) {
		$sqlIns="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Update Password','update as_ms_user set passwd = password(".$_POST['txt_passwd'].") where userid = ".$_SESSION['userid']." and passwd = password(".$_POST['txt_oldPasswd'].")','".$_SERVER['REMOTE_ADDR']."')";
					mysql_query($sqlIns);
		
        $query = "update as_ms_user set passwd = password('".$_POST['txt_passwd']."')
                    where userid = '".$_SESSION['userid']."' and passwd = password('".$_POST['txt_oldPasswd']."')";
        mysql_query($query);
        $res = mysql_affected_rows();
        if($res > 0) {
            echo "<script>alert('Data password anda berhasil diubah.');</script>";
        }
        else if($res == 0) {
            echo "<script>alert('Data password anda tidak berubah.');</script>";
        }
        else {
            echo "<script>alert('Data password anda gagal diubah, periksa kembali input anda.');</script>";
        }
    }
    else {
        echo "<script>alert('Password anda salah.');</script>";
    }
}
$query = "SELECT userid,username,usertype,address,telp,email,status FROM as_ms_user where userid = '".$_SESSION['userid']."'";
$rs = mysql_query($query);
$row = mysql_fetch_array($rs);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <title>Info User</title>
    </head>

    <body>
        <div align="center">
            <?php
            include '../header.php';
            ?>
            <div>
                <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center">
                            <table width="500" cellpadding="0" border="0" cellspacing="0">
                                <tr>
                                    <td height="29" align="center" colspan="2" nowrap>
                                        <button class="Disabledbutton" id="savebutton" onClick="goSave()" title="Save" style="cursor:pointer">
                                            <img alt="save" src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                            Save Record
                                        </button>
                                        &nbsp;
                                        <button class="Disabledbutton" id="undobutton" onClick="location='change_password.php'" title="Cancel / Refresh" style="cursor:pointer">
                                            <img alt="undo" src="../images/undosmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                            Undo/Refresh
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="header" align="center" colspan="2">
                                <marquee>
                                    .: Please enter your old and new desired password :.
                                </marquee>
                        </td>
                    </tr>
                    <form id="form_passwd" action="" method="post" onSubmit="return ValidateForm('txt_oldPasswd,txt_passwd,txt_confPasswd','Ind');">
                        <tr>
                            <td class="label" width="150">
                                &nbsp;Old Password
                            </td>
                            <td class="content" width="350">
                                &nbsp;
                                <input type="hidden" name="act" id="act" />
                                <input type="password" id="txt_oldPasswd" name="txt_oldPasswd" class="txtmustfilled" size="50" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label">
                                &nbsp;New Password
                            </td>
                            <td class="content">
                                &nbsp;
                                <input type="password" id="txt_passwd" name="txt_passwd" class="txtmustfilled" size="50" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label">
                                &nbsp;Re-type New Password
                            </td>
                            <td class="content">
                                &nbsp;
                                <input type="password" id="txt_confPasswd" name="txt_confPasswd" class="txtmustfilled" size="50" />
                            </td>
                        </tr>
                    </form>
                    <tr>
                        <td class="header2" colspan="2">&nbsp;

                        </td>
                    </tr>
                </table>
                <?php
                include '../footer.php';
                ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
    <script type="text/javascript">

        function goSave(){
            if(ValidateForm('txt_oldPasswd,txt_passwd,txt_confPasswd','ind') == true){
                if(document.getElementById('txt_passwd').value == document.getElementById('txt_confPasswd').value){
                    document.getElementById('act').value = 'change';
                    form_passwd.submit();
                }
                else{
                    alert('Password baru anda tidak sama dengan konfirmasi password baru anda.');
                    document.getElementById('txt_oldPasswd').value = '';
                    document.getElementById('txt_confPasswd').value = '';
                    document.getElementById('txt_passwd').value = '';
                }
            }
        }
    </script>
</html>