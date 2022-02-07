<?php
session_start();
include("../sesi.php");

include_once "../../api/koneksi.php";

$koneksi = new Koneksi;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link type="text/css" rel="stylesheet" href="../theme/mod.css">
    <script language="JavaScript" src="../theme/js/mod.js"></script>
    <script language="JavaScript" src="../theme/js/dsgrid.js"></script>
    <script type="text/JavaScript" language="JavaScript" src="../include/jquery/jquery-1.9.1.js"></script>
    <title>Set JKN auth user</title>
</head>

<body>
    <div align="center">
        <?php
        include("../koneksi/konek.php");
        include("../header1.php");
        ?>
        <script>
            var arrRange = depRange = [];
        </script>
        <iframe height="72" width="130" name="sort" id="sort" src="../theme/dsgrid_sort.php" scrolling="no" frameborder="0" style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
        </iframe>
        <iframe height="193" width="168" name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../theme/popcjs.php" scrolling="no" frameborder="0" style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
        </iframe>
        <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
            <tr>
                <td height="30">&nbsp;FORM SET AKSES JKN</td>
            </tr>
        </table>
        <table width="1000" border="0" cellpadding="0" cellspacing="0" class="tabel" align="center">
            <tr>
                <td height="18" colspan="4">&nbsp;</td>
            </tr>
            <tr>
                <td width="5%">
                <td width="15%">&nbsp;</td>
                <td width="75%">&nbsp;</td>
                <td width="5%">&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="2">
                    <div id="div_mcu" style="display:block">
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                            <tr height="30">
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td width="45%" valign="top">
                                                <form method="post">
                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                        <tr valign="top">
                                                            <td width="30%">Username</td>
                                                            <td width="10%" align="center">:</td>
                                                            <td width="60%"><input size="32" id="username" name="username" class="txtinput" /></td>
                                                        </tr>
                                                        <tr valign="top">
                                                            <td width="30%">Password</td>
                                                            <td width="10%" align="center">:</td>
                                                            <td width="60%"><input size="32" id="password" name="password" class="txtinput" /></td>
                                                        </tr>
                                                        <tr valign="top">
                                                            <td width="30%">Durasi Expired (detik)</td>
                                                            <td width="10%" align="center">:</td>
                                                            <td width="60%"><input size="32" id="expired" name="expired" class="txtinput" /></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Status</td>
                                                            <td align="center">:</td>
                                                            <td><input type="checkbox" id="isAktif" name="isAktif" value="1" class="txtinput" />&nbsp;&nbsp;&nbsp;Aktif</td>
                                                        </tr>
                                                        <tr height="30">
                                                            <td>&nbsp;</td>
                                                            <td><input type="hidden" id="cmd" name="cmd" />
                                                                <input type="hidden" name="id" id="id" /></td>
                                                            <td>
                                                                <input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="simpan(this.value,'username');" class="tblTambah" />
                                                                <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus(this.title);" disabled="disabled" class="tblHapus" />
                                                                <input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal" />
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </form>
                                            </td>
                                            <td width="5%">&nbsp;</td>
                                            <td width="50%" align="right">
                                                <div id="gridbox" style="width:450px; height:250px; background-color:white; overflow:hidden;"></div>
                                                <div id="paging" style="width:450px;"></div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>

                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>

        </table>
        <table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000" align="center">
            <tr height="30">
                <td>&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" class="btninput" /></td>
                <td align="right"><a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" class="btninput" /></a>&nbsp;</td>
            </tr>
        </table>
    </div>

    <script>
        function simpan(action, cek) {
            if (ValidateForm(cek, 'ind')) {
                var id = document.getElementById("id").value;
                var username = document.getElementById("username").value;
                var password = document.getElementById("password").value;
                var expired = document.getElementById("expired").value;
                var aktif = 0;
                if (document.getElementById('isAktif').checked == true) {
                    aktif = 1;
                }

                a.loadURL("set-jkn-utils.php?grd=true&act=" + action + "&id=" + id + "&username=" + username + "&password=" + password + "&expired=" + expired + "&aktif=" + aktif, "", "GET");
                document.getElementById("isAktif").checked = false;
                document.getElementById("username").value = '';
                document.getElementById("password").value = '';
                document.getElementById("expired").value = '';
                batal();
            }

        }

        function ambilData() {
            var p = "id*-*" + (a.getRowId(a.getSelRow())) + "*|*username*-*" + a.cellsGetValue(a.getSelRow(), 2) + "*|*password*-*" + a.cellsGetValue(a.getSelRow(), 3) + "*|*expired*-*" + a.cellsGetValue(a.getSelRow(), 4) + "*|*isAktif*-*" + ((a.cellsGetValue(a.getSelRow(), 5) == 'Aktif') ? 'true' : 'false') + "*|*btnSimpan*-*Simpan*|*btnHapus*-*false";
            fSetValue(window, p);
        }

        function hapus() {
            var rowid = document.getElementById("id").value;
            if (confirm("Anda yakin menghapus akses JKN ini " + a.cellsGetValue(a.getSelRow(), 2))) {
                a.loadURL("set-jkn-utils.php?grd=true&act=hapus&rowid=" + rowid, "", "GET");
            }
            batal();
        }

        function batal() {
            var p = "id*-**|*username*-**|*password*-**|*expired*-**|*isAktif*-*false*|*btnSimpan*-*Tambah*|*btnHapus*-*true";
            fSetValue(window, p);
        }

        function goFilterAndSort(grd) {
            //alert(grd);		
            switch (grd) {
                case 'gridbox':
                    a.loadURL("set-jkn-utils.php?grd=true&filter=" + a.getFilter() + "&sorting=" + a.getSorting() + "&page=" + a.getPage(), "", "GET");
                    break;
            }
        }

        jQuery(function() {
            jQuery("#expired").keydown(function(e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if (jQuery.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                    // Allow: Ctrl+A
                    (e.keyCode == 65 && e.ctrlKey === true) ||
                    // Allow: home, end, left, right
                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                    // let it happen, don't do anything
                    return;
                } else {
                    // Ensure that it is a number and stop the keypress
                    if (e.shiftKey || (e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                }
            });
        });

        var a = new DSGridObject("gridbox");
        a.setHeader("Akses JKN");
        a.setColHeader("NO,Username,Password,Durasi Expired,STATUS AKTIF");
        a.setIDColHeader(",username,password,expired,");
        a.setColWidth("50,,,,50");
        a.setCellAlign("center,left,center");
        a.setCellHeight(20);
        a.setImgPath("../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick", "ambilData");
        a.baseURL("set-jkn-utils.php?grd=true");
        a.Init();
    </script>
</body>

</html>