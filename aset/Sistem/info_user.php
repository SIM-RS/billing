<?
include '../sesi.php';
?>
<?php
include '../koneksi/konek.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='/simrs-tangerang/aset/';
                        </script>";
}
if(isset($_POST['act']) && $_POST['act'] == 'save') {
	$sqlIns="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Update User','update as_ms_user set username = ".$_POST['txt_user_name'].",address = ".$_POST['txt_user_addr'].",telp = ".$_POST['txt_user_phone'].",email = ".$_POST['txt_user_mail']."
                where userid = ".$_POST['txt_user_id']."','".$_SERVER['REMOTE_ADDR']."')";
				mysql_query($sqlIns);
    $query = "update as_ms_user set username = '".$_POST['txt_user_name']."',address = '".$_POST['txt_user_addr']."',telp = '".$_POST['txt_user_phone']."',email = '".$_POST['txt_user_mail']."'
                where userid = '".$_POST['txt_user_id']."'";
    mysql_query($query);
    $res = mysql_affected_rows();
    if($res > 0) {
        $change = "berhasil diubah.";
    }
    else if($res == 0) {
        $change = "tidak ada yang berubah.";
    }
    else {
        $change = "gagal diubah, periksa kembali input.";
    }
    echo "<script>alert('Data $change');</script>";
}
 $query = "SELECT id,userid,username,usertype,address,telp,email,status,namaunit FROM as_ms_user LEFT JOIN as_ms_unit ON as_ms_unit.idunit=as_ms_user.refidunit where userid = '".$_SESSION['userid']."'";
$rs = mysql_query($query);
$row = mysql_fetch_array($rs);
$usertype = $row['usertype'];
if ($usertype=="P")
    $usertype = 'Petugas UPB';
else if ($usertype=="F")
    $usertype = 'Petugas PPBI';
else if ($usertype=="A")
    $usertype = 'Admin';
else if ($usertype=="M")
    $usertype = 'Manajemen';
?>
<!--html xmlns="http://www.w3.org/1999/xhtml"-->
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
                                <td height="29" align="left" colspan="2" nowrap>
                                    
                                    <button class="Enabledbutton" id="editbutton" name="editbutton" onClick="goEdit()" title="Edit" style="cursor:pointer">
                                        <img alt="edit" src="../images/editsmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                        Edit Record
                                    </button>
                                    &nbsp;
                                    <button class="Disabledbutton" id="savebutton" disabled=true onClick="goSave()" title="Save" style="cursor:pointer">
                                        <img alt="save" src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                        Save Record
                                    </button>
                                    &nbsp;
                                    <button class="Disabledbutton" id="undobutton" onClick="location='info_user.php'" title="Cancel / Refresh" style="cursor:pointer">
                                        <img alt="undo" src="../images/undosmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                        Undo/Refresh
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="header" align="center" colspan="2">
                                    .:Data User:.
                                </td>
                            </tr>
                            <form id="form_info" action="" method="post" onSubmit="return ValidateForm('txt_user_name','Ind');">
                                <tr>
                                    <td class="label" width="125">
                                        &nbsp;User ID
                                    </td>
                                    <td class="content" width="375">
                                        &nbsp;
                                        <input type="hidden" name="act" id="act" />
                                        <input type="text" id="txt_user_id" name="txt_user_id" class="txtunedited" readonly size="35" value="<?php echo $row['userid'];?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">
                                        &nbsp;Nama User
                                    </td>
                                    <td class="content">
                                        &nbsp;
                                        <input type="text" id="txt_user_name" name="txt_user_name" readonly class="txtmustfilled" size="35" value="<?php echo $row['username'];?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">
                                        &nbsp;Tipe
                                    </td>
                                    <td class="content">
                                        &nbsp;
                                        <?php
                                        echo $usertype;
                                        ?><!--Petugas Pusat (Admin)-->
                                    </td>
                                </tr>
                                <tr>
                                    <td class="header2" colspan="2">
                                        &nbsp;Satuan Unit / Kerja
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">
                                        &nbsp;Unit Kerja
                                    </td>
                                    <td class="content">
                                        &nbsp;<?php echo $row['namaunit'];?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="header2" colspan="2">
                                        &nbsp;Biodata & Kontak
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">
                                        &nbsp;Alamat
                                    </td>
                                    <td class="content">
                                        &nbsp;
                                        <input type="text" id="txt_user_addr" name="txt_user_addr" readonly class="txt" size="50" value="<?php echo $row['address'];?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">
                                        &nbsp;Telpon
                                    </td>
                                    <td class="content">
                                        &nbsp;
                                        <input type="text" id="txt_user_phone" name="txt_user_phone" readonly size="50" class="txt" value="<?php echo $row['telp'];?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">
                                        &nbsp;Email
                                    </td>
                                    <td class="content">
                                        &nbsp;
                                        <input type="text" id="txt_user_mail" name="txt_user_mail" size="50" readonly class="txt" value="<?php echo $row['email'];?>" />
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
    function goEdit(){
        var set = false
        if(document.getElementById('txt_user_id').readOnly == false){
            set = true;
        }
        //document.getElementById('txt_user_id').readOnly = set;
        document.getElementById('txt_user_name').readOnly = set;
        document.getElementById('txt_user_addr').readOnly = set;
        document.getElementById('txt_user_phone').readOnly = set;
        document.getElementById('txt_user_mail').readOnly = set;
        document.getElementById('editbutton').disabled = !set;
        document.getElementById('savebutton').disabled = set;
    }

    function goSave(){
        if(ValidateForm('txt_user_name','ind') == true){
            document.getElementById('act').value = 'save';
            form_info.submit();
        }
    }
</script>
<!--/html-->
