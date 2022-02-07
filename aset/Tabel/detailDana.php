<?
include '../sesi.php';
?>
<?php
include("../koneksi/konek.php");
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='$def_loc';
                        </script>";
}
$id = $_GET['idsumberdana'];
if(isset($_POST['act']) && $_POST['act'] != '') {
    $act = $_POST['act'];
    $sumberdana = $_POST["txtSmbrDana"];
    $urut = $_POST["txtNo"];
    if($act == "add") {
	$sqlIns="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Insert Master Sumber Dana','INSERT INTO as_ms_sumberdana (keterangan,nourut) values ($sumberdana,$urut)','".$_SERVER['REMOTE_ADDR']."')";
					mysql_query($sqlIns);
        $query = "INSERT INTO as_ms_sumberdana (keterangan,nourut) values ('$sumberdana','$urut')";
    }
    else if($act == 'edit') {
	$sqlIns="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Update Master Sumber Dana','update as_ms_sumberdana set keterangan = $sumberdana, nourut = $urut where idsumberdana = $id','".$_SERVER['REMOTE_ADDR']."')";
					mysql_query($sqlIns);
        $query = "update as_ms_sumberdana set keterangan = '$sumberdana', nourut = '$urut' where idsumberdana = $id";
    }
    $rs = mysql_query($query);
    $res = mysql_affected_rows();
    if($act == 'edit') {
        if($res > 0) {
            echo "<script>
                alert('Data berhasil diubah.');
                window.location = 'smbrDana.php';
                </script>";
        }
        else if($res == 0) {
            echo "<script>alert('Data tidak ada yang berubah.');</script>";
        }
        else {
            echo "<script>alert('Terdapat kesalahan pada input anda.$res');</script>";
        }
    }
    else if($act == 'add') {
        if($res > 0) {
            echo "<script>
                alert('Data Telah Berhasil Tersimpan..');
                </script>";
        }
        else if($res == 0) {
            echo "<script>alert('Data gagal dimasukan.');</script>";
        }
        else {
            echo "<script>alert('Terdapat kesalahan pada input anda.$res');</script>";
        }
    }
}
?>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <title>Sumber Dana</title>
    </head>

    <body>
        <div align="center">
            <?php
            include("../header.php");
            $act = $_GET['act'];
            $par = "act=$act";
            if($act == 'edit') {
                $par .= "&idsumberdana=$id";
                $query = "SELECT idsumberdana,keterangan,nourut FROM as_ms_sumberdana WHERE idsumberdana = '$id'";
                $rs = mysql_query($query);
                $i = 0;
                $rows = mysql_fetch_array($rs);
                $sumberdana = $rows["keterangan"];
                $urut = $rows["nourut"];
            }
            ?>
            <div>
                <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center">
                            <table width="625" border="0" cellspacing="0" cellpadding="2" align="center">
                                <tr>
                                    <td height="30" colspan="2" valign="bottom" align="right">
                                        <button class="Enabledbutton" id="backbutton" onClick="location='smbrDana.php'" title="Back" style="cursor:pointer">
                                            <img alt="back" src="../images/backsmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                            Back to List
                                        </button>
                                        <button type="button" class="Enabledbutton" id="btnSimpan" name="btnSimpan" onClick="save()" title="Save" style="cursor:pointer">
                                            <img alt="save" src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                            Save Record
                                        </button>
                                        <button class="Disabledbutton" id="undobutton" onClick="location='detailDana.php?<?php echo $par;?>'" title="Cancel / Refresh" style="cursor:pointer">
                                            <img alt="undo/refresh" src="../images/undosmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                            Undo/Refresh
                                        </button>
                                    </td>
                                </tr>
                                <form action="" method="post" id="form1" name="form1" onSubmit="return ValidateForm('txtSmbrDana,txtNo','Ind');">
                                    <tr>
                                        <td colspan="2" height="28" class="header">.: Data Sumber Dana :.</td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label" width="40%">&nbsp;Sumber Dana</td>
                                        <td class="content" width="60%">&nbsp;
                                            <input id="txtSmbrDana" class="txtmustfilled" name="txtSmbrDana" value="<?php echo $sumberdana; ?>" size="45" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;nourut</td>
                                        <td class="content">&nbsp;
                                            <input id="txtNo" name="txtNo" class="txtmustfilled" value="<?php echo $urut; ?>" size="24" />
                                            <input type="hidden" name="act" id="act" value="<?php echo $act;?>" />
                                        </td>
                                    </tr>
                                </form>
                                <tr>
                                    <td colspan="2" class="header2">&nbsp;</td>
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
    <script type="text/JavaScript" language="JavaScript">
        function save(){
            if(ValidateForm('txtSmbrDana,txtNo','Ind') == true){
                document.getElementById('form1').submit();
            }
        }
    </script>
</html>