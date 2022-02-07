<?
include '../sesi.php';
?>
<?php
include '../koneksi/konek.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='$def_loc';
                        </script>";
}
if(isset($_POST['act']) && $_POST['act'] != '') {
    if($_POST['act'] == 'edit') {
        $query = "update as_ms_gedung set
            kodegedung = '".$_POST['txt_kodegedung']."', namagedung = '".$_POST['txt_namagedung']."', tahunbangun = '".$_POST['txt_thnbangun']."', nourut = '".$_POST['txt_nourut']."'
            , t_userid = '".$_SESSION['userid']."', t_ipaddress = '".$_SERVER['REMOTE_ADDR']."' t_updatetime = now()
                where idgedung = '".$_GET['idgedung']."'";
    }
    else if($_POST['act'] == 'add') {
        $query = "insert into as_ms_gedung (kodegedung, namagedung, tahunbangun, nourut, t_userid, t_ipaddress, t_updatetime)
                values ('".$_POST['txt_kodegedung']."', '".$_POST['txt_namagedung']."', '".$_POST['txt_thnbangun']."', '".$_POST['txt_nourut']."', '".$_SESSION['userid']."', '".$_SERVER['REMOTE_ADDR']."', now())";
    }
    $rs = mysql_query($query);
    $res = mysql_affected_rows();
    if($res > 0) {
        if($_POST['act'] == 'add') {
            $act = "Penambahan data berhasil.";
        }
        else {
            $act = "Edit data berhasil.";
        }
        echo "<script>alert('$act');</script>";
        if($_POST['act'] == 'edit') {
            echo "<script>window.location = 'gedung.php';</script>";
        }
    }
    else {
        echo "<script>
            alert('Terdapat kesalahan input, coba periksa kembali.');
            </script>";
    }
}
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <title>Gedung</title>
    </head>
    <body>
        <div align="center">
            <?php
            include '../header.php';
            $act = $_GET['act'];
            $par = "act=$act";
            if($act == 'edit') {
                $idgedung = $_GET['idgedung'];
                $par .= "&idgedung=$idgedung";
                $query = "select idgedung,kodegedung,namagedung,tahunbangun,nourut,t_userid,t_updatetime,t_ipaddress from as_ms_gedung where idgedung = '".$_GET['idgedung']."'";
                $rs = mysql_query($query);
                $i = 0;
                $rows = mysql_fetch_array($rs);
                $kodeGedung = $rows["kodegedung"];
                $namaGedung = $rows["namagedung"];
                $tahunBangun = $rows['tahunbangun'];
                $nourut = $rows['nourut'];
            }
            ?>
            <div>
                <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center">
                            <table cellspacing=0 cellpadding="4" width="450" align="center">
                                <tr>
                                    <td height="30" colspan="2" valign="bottom" align="right">
                                        <button class="Enabledbutton" id="backbutton" onClick="location='gedung.php'" title="Back" style="cursor:pointer">
                                            <img alt="back" src="../images/backsmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                            Back to List
                                        </button>
                                        <!--button class="Disabledbutton" disabled=true id="editbutton" name="editbutton" onClick="goEdit()" title="Edit" style="cursor:pointer">
                                            <img alt="back" src="../images/editsmall.gif" width="22" height="22" border="0" align="absmiddle" />
      				Edit Record
                                        </button-->
                                        <button type="submit" class="Enabledbutton" id="btnSimpan" name="btnSimpan" onClick="save()" title="Save" style="cursor:pointer">
                                            <img alt="save" src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                            Save Record
                                        </button>
                                        <button class="Disabledbutton" id="undobutton" onClick="location='detailGedung.php?<?php echo $par;?>'" title="Cancel / Refresh" style="cursor:pointer">
                                            <img alt="undo/refresh" src="../images/undosmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                            Undo/Refresh
                                        </button>
                                        <!--button class="Enabledbutton" id="deletebutton" onClick="goDelete()" title="Delete" style="cursor:pointer;">
                                            <img alt="delete" src="../images/deletesmall.gif" width="22" height="22" border="0" align="absmiddle" />
      				Delete
                                        </button-->
                                    </td>
                                </tr>
                                <form action="" method="post" onSubmit="return ValidateForm('txt_kodegedung,txt_namagedung,txt_thnbangun,txt_nourut','Ind');" id="form_gedung" >
                                    <tr>
                                        <td colspan="2" class="header">
                                            .: Data Gedung/Bangunan :.
                                            <input type="hidden" id="act" name="act" value="<?php echo $act;?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width=200 height=20 align='left' class='label' style='cursor:pointer;' >
                                            Kode Gedung
                                        </td>
                                        <td width=250 class='contright' align='center'>
                                            <input type='text' name='txt_kodegedung' id='txt_kodegedung' size='45' class='txt' value='<?php echo $kodeGedung;?>'>
                                        </td>
                                    </tr>
                                    <tr >
                                        <td align='left' class='label' style='cursor:pointer;' >
                                            Nama
                                        </td>
                                        <td align='center' class='contright'>
                                            <input type='text' name='txt_namagedung' id='txt_namagedung' size='45' class='txt' value='<?php echo $namaGedung; ?>'>
                                        </td>
                                    </tr>
                                    <tr >
                                        <td align='left' class='label' style='cursor:pointer;' >
                                            Tahun
                                        </td>
                                        <td align='center' class='contright'>
                                            <input type='text' name='txt_thnbangun' id='txt_thnbangun' size='45' class='txt' value='<?php echo $tahunBangun; ?>'>
                                        </td>
                                    </tr>
                                    <tr >
                                        <td align='left' class='label' style='cursor:pointer;' >
                                            No Urut
                                        </td>
                                        <td align='center' class='contright'>
                                            <input type='text' name='txt_nourut' id='txt_nourut' size='45' class='txt' value='<?php echo $nourut; ?>'>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='header2' colspan='2'>&nbsp;</td>
                                    </tr>
                                    <?php
                                    //==================================END LOOP ========================================
                                    // end else
                                    if (mysql_affected_rows()==0 && $_GET['act'] == 'edit') {
                                        echo "<tr valign=center height=25><td align=center colspan=2><b>No record found.</b></td></tr>";
                                    }
                                    ?>
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
            if(ValidateForm('txt_kodegedung,txt_namagedung,txt_thnbangun,txt_nourut','Ind') == true){
                form_gedung.submit();
            }
        }
    </script>
</html>