<?
include '../sesi.php';
?>
<?php
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='/simrs-tangerang/aset/';
                        </script>";
}
include '../koneksi/konek.php';
if(isset($_POST['act']) && $_POST['act'] != '') {
    $query = "select * from as_setting where idsetting = '".$_POST['idsetting']."'";
    $rs = mysql_query($query);
    $res = mysql_affected_rows();
    if($res > 0) {
        $query = "update as_setting set kodedepartemen = '".$_POST['kodedepartemen']."', kodepropinsi = '".$_POST['kodepropinsi']."'
            , kodekota = '".$_POST['kodekota']."', namadepartemen = '".$_POST['namadepartemen']."', namapropinsi = '".$_POST['namapropinsi']."'
            , namakota = '".$_POST['namakota']."', keterangan = '".$_POST['keterangan']."'
            where idsetting = '".$_POST['idsetting']."'";
        $rs = mysql_query($query);
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
    else {
        $query = "insert into as_setting (idsetting, kodedepartemen, kodepropinsi, kodekota, namadepartemen, namapropinsi, namakota, keterangan) values
                    ('".$_POST['kodedepartemen']."','".$_POST['kodepropinsi']."','".$_POST['kodekota']."','".$_POST['namadepartemen']."'
                        ,'".$_POST['namapropinsi']."','".$_POST['namakota']."','".$_POST['keterangan']."')";
        $rs = mysql_query($query);
    }
}
$query = "SELECT idsetting, kodedepartemen, namadepartemen, namapropinsi, namakota, keterangan FROM as_setting";
$rs = mysql_query($query);
$rows = mysql_fetch_array($rs);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" href="../default.css" rel="stylesheet" />
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <title>.: Setting Global :.</title>
    </head>

    <body>
	
        <div id="editForm" align="center">
            
            <div>
			<?php
            include '../header.php';
            ?>
                <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center">
                            <table width="600" cellpadding="4" cellspacing="0">
                                <tr>
                                    <td height="30" colspan="4" valign="bottom" align="right">
                                        <!--button class="Enabledbutton" id="backbutton" onClick="location='perolehan.php'" title="Back" style="cursor:pointer">
                                            <img alt="back" src="../images/backsmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                            Back to List
                                        </button>
                                        <button class="Disabledbutton" disabled=true id="editbutton" name="editbutton" onClick="goEdit()" title="Edit" style="cursor:pointer">
                                            <img alt="back" src="../images/editsmall.gif" width="22" height="22" border="0" align="absmiddle" />
      				Edit Record
                                        </button-->
                                        <button type="submit" class="Enabledbutton" id="btnSimpan" name="btnSimpan" onclick="save()" title="Save" style="cursor:pointer">
                                            <img alt="save" src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" />
      				Save Record
                                        </button>
                                        <button class="Disabledbutton" id="undobutton" onClick="location=''" title="Cancel / Refresh" style="cursor:pointer">
                                            <img alt="undo/refresh" src="../images/undosmall.gif" width="22" height="22" border="0" align="absmiddle" />
      				Undo/Refresh
                                        </button>
                                        <!--button class="Enabledbutton" id="deletebutton" onClick="goDelete()" title="Delete" style="cursor:pointer;">
                                            <img alt="delete" src="../images/deletesmall.gif" width="22" height="22" border="0" align="absmiddle" />
      				Delete
                                        </button-->
                                    </td>
                                </tr>
                            </table>
                            <table width="600" border=0 cellspacing=0 cellpadding="4" bgcolor="#EDF1FE">
                                <form id="form1" name="form1" action="" method="post">
                                    <tr>
                                        <td height="25" colspan="2" align="center" class="header">
                                            .: Setting Global :.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="148" class="label">ID Setting </td>
                                        <td width="442" class='content'>
                                            <input name="idsetting" type="text" class="txtunedited" readonly id="idsetting" value="<?php echo $rows["idsetting"]; ?>" size="20" maxlength="10" <?php echo ($r_userid!="") ? "readonly style='background-color:#D5FDFD;'" : "" ?> />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label">Kode Departemen </td>
                                        <td class='content'>
                                            <input name="kodedepartemen" type="text" class="txt" id="kodedepartemen" value="<?php echo $rows["kodedepartemen"]; ?>" size="10" maxlength="3" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label">Nama Departemen </td>
                                        <td class='content'>
                                            <input name="namadepartemen" type="text" class="txt" id="kodedepartemen4" value="<?php echo $rows["namadepartemen"]; ?>" size="60" maxlength="50" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label">Kode Propinsi </td>
                                        <td class='content'>
                                            <input name="kodepropinsi" type="text" class="txt" id="kodepropinsi" value="<?php echo $rows["kodepropinsi"]; ?>" size="10" maxlength="3" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label">Nama Propinsi </td>
                                        <td class='content'>
                                            <input name="namapropinsi" type="text" class="txt" id="namadepartemen" value="<?php echo $rows["namapropinsi"]; ?>" size="60" maxlength="50" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label">Kode Kota </td>
                                        <td class='content'>
                                            <input name="kodekota" type="text" class="txt" id="kodekota" value="<?php echo $rows["kodekota"]; ?>" size="10" maxlength="3" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label">Nama Kota </td>
                                        <td class='content'>
                                            <input name="namakota" type="text" class="txt" id="namapropinsi" value="<?php echo $rows["namakota"]; ?>" size="60" maxlength="50" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="header2">Keterangan</td>
                                    </tr>
                                    <tr>
                                        <td class="label">Keterangan</td>
                                        <td class='content'>
                                            <textarea name="keterangan" cols="60" rows="3" class="txt" id="keterangan"><?php echo $rows["keterangan"]; ?>
                                            </textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="25" colspan="2" class="footer">&nbsp;</td>
                                    </tr>
                                    <input type="hidden" name="act" value="simpan"/>
                                </form>
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
    <script type="text/javascript" language="javascript">
        function save(){
            //if(ValidateForm('kodeunit,tgltransaksi,tglpembukuan,idbarang,namabarang','Ind') == true){
            //,idjenistrans,qtytransaksi,hargasatuan,nilaikurs
            document.form1.submit();
            //}
        }
    </script>
</html>
