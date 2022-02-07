<?php
session_start();
include '../koneksi/konek.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='$def_loc';
                        </script>";
}
$unit_opener="par=idunit*kodeunit*namaunit*idlokasi*kodelokasi";
?>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <title>.: Laporan Pengadaan Inventaris :.</title>
    </head>

    <body>
        <div align="center">
            <?php
            include '../header.php';
            ?>
            <table width="1000" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="padding-top: 10px;" align="center">
                        <?php
                        if ($_GET["par"]=="1") {
                            ?>
                        <form id="form1" name="form1" action="lap_ada_inv.php" method="post" target="Laporan Pengadaan Inventaris">
                            <table width="600" border="0" cellspacing="0" cellpadding="4">
                                <tr align="center">
                                    <td colspan="2" class="header">
                                        <strong><font size="2">Laporan Pengadaan Inventaris</font></strong>                                    </td>
                              </tr>
                                <!--tr>
                                    <td width="139" class="label"><strong>Perolehan</strong></td>
                                    <td width="439" class="content">
                                        <select name="cmbperolehan" class="txt" id="cmbperolehan" tabindex="2" onChange="if (this.value==1){document.getElementById('a').style.display='none';}else{document.getElementById('a').style.display='block';}">
                                            <option value="1">Semua</option>
                                            <option value="2">Periode</option>
                                        </select>
                                    </td>
                                </tr-->
                                <tr>
                                    <td class="label"><strong>Tanggal Perolehan</strong></td>
                                    <td class="content">
                                        <div id="a" style="display:block">
                                            <input name="tglawal" type="text" class="txt" id="tglawal" tabindex="4" value="<?php echo date('d-m-Y');?>" size="15" maxlength="15" readonly />
                                            <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tglawal'),depRange);" />
                                            <!--img alt="calender" name="imgtglawal" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onclick="javascript:show_calendar('form1.tglawal','dd-mm-yyyy',null,null,window.event);" /-->
                                            &nbsp;s/d&nbsp;
                                            <input name="tglakhir" type="text" class="txt" id="tglakhir" tabindex="4" value="<?php echo date('d-m-Y');?>" size="15" maxlength="15" readonly />
                                            <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tglakhir'),depRange);" />
                                            <!--img alt="calender" name="imgtglakhir" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onclick="javascript:show_calendar('form1.tglakhir','dd-mm-yyyy',null,null,window.event);" /-->
                                            <font size=1 color=gray><i>(dd-mm-yyyy)</i></font>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label"><strong>Format Laporan </strong></td>
                                    <td class="content"><select name="formatlap" class="txt" id="formatlap" tabindex="7">
                                            <option value="HTML">HTML</option>
                                            <option value="XLS">EXCEL</option>
                                            <option value="WORD">WORD</option>
                                        </select></td>
                                </tr>
                                <tr align="center">
                                    <td colspan="2" class="header2">
                                        <input name="submit" type="submit" id="submit" value="Tampilkan" />
                                    </td>
                                </tr>
                            </table>
                            <input name="idunit" type="hidden" id="idunit" value="" />
                            <input name="namaunit" type="hidden" id="namaunit" value="" />
                            <input name="idlokasi" type="hidden" id="idlokasi" value="" />
                            <input name="kodelokasi" type="hidden" id="kodelokasi" value="" />
                        </form>
                            <?php
                        }
                        else {
                            ?>
                        <form id="form1" name="form1" action="lap_luar_inv.php" method="post" target="Laporan Pengeluaran Inventaris">
                            <table width="600" border="0" cellspacing="0" cellpadding="4">
                                <tr align="center">
                                    <td colspan="2" class="header">
                                        <strong><font size="2">Laporan Pengeluaran Inventaris</font></strong>                                    </td>
                              </tr>
                                <!--tr>
                                    <td class="label"><strong>Unit / Satuan Kerja </strong></td>
                                    <td class="content">
                                        <input name="kodeunit" type="text" class="txt" id="kodeunit" size="20" maxlength="15" readonly style="text-align:left;background-color:#D5FDFD;" />
                                        <img alt="tree" title='daftar unit kerja'  style="cursor:pointer" border=0 src="../images/view_tree.gif" align="absbottom" onClick="OpenWnd('../Aktivitas/unit_tree.php?<?php echo $unit_opener; ?>',800,500,'msma',true)" />
                                        <input type="checkbox" name="chkall" value="checkbox" onClick="if (this.checked==true) {document.getElementById('idunit').value='0';document.getElementById('kodeunit').value='0';}else{document.getElementById('idunit').value='';document.getElementById('kodeunit').value='';}" />
                                        Semua Unit Kerja                                    </td>
                                </tr>
                                <tr>
                                    <td width="139" class="label"><strong>Perolehan</strong></td>
                                    <td width="439" class="content">
                                        <select name="cmbperolehan" class="txt" id="cmbperolehan" tabindex="2" onChange="if (this.value==1){document.getElementById('a').style.display='none';}else{document.getElementById('a').style.display='block';}">
                                            <option value="1">Semua</option>
                                            <option value="2">Periode</option>
                                        </select>                                    </td>
                                </tr-->
                                <tr>
                                    <td class="label"><strong>Tanggal Perolehan</strong></td>
                                    <td class="content">
                                        <div id="a" style="display:block">
                                            <input name="tglawal" type="text" class="txt" id="tglawal" tabindex="4" value="<?php echo date('d-m-Y');?>" size="15" maxlength="15" readonly />
                                            <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tglawal'),depRange);" />
                                            s/d
                                            <input name="tglakhir" type="text" class="txt" id="tglakhir" tabindex="4" value="<?php echo date('d-m-Y');?>" size="15" maxlength="15" readonly />
                                            <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tglakhir'),depRange);" />
                                            <font size=1 color=gray><i>(dd-mm-yyyy)</i></font>                                        </div>                                    </td>
                                </tr>
                                <tr>
                                    <td class="label"><strong>Format Laporan </strong></td>
                                    <td class="content">
                                        <select name="formatlap" class="txt" id="formatlap" tabindex="7">
                                            <option value="HTML">HTML</option>
                                            <option value="XLS">EXCEL</option>
                                            <option value="WORD">WORD</option>
                                        </select>                                    </td>
                                </tr>
                                <tr align="center">
                                    <td colspan="2" class="header2">
                                        <input name="submit" type="submit" id="submit" value="Tampilkan" onClick="" />                                    </td>
                                </tr>
                            </table>
                        <input name="idunit" type="hidden" id="idunit" value="" />
                            <input name="namaunit" type="hidden" id="namaunit" value="" />
                            <input name="idlokasi" type="hidden" id="idlokasi" value="" />
                            <input name="kodelokasi" type="hidden" id="kodelokasi" value="" />
                        </form>
                            <?php
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php
                        include '../footer.php';
                        ?>
                    </td>
                </tr>
            </table>
        </div>
        <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js"
                src="../theme/popcjs.php" scrolling="no"
                frameborder="1"
                style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
        </iframe>
    </body>
    <script type="text/JavaScript" language="JavaScript">
        var arrRange=depRange=[];

    </script>
</html>
