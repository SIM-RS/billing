<?php
session_start();
include '../koneksi/konek.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='$def_loc';
                        </script>";
}

$reportFile = "lap_trw.php";
$tgl = gmdate('d-m-Y',mktime(date('H')+7));
?>
<html>
    <head>
        <title>Laporan Parameter</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <META http-equiv="Page-Enter" CONTENT="RevealTrans(Duration=0.1,Transition=12)">
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link href="../default.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div align="center">
            <?php
            include '../header.php';
            ?>
            <table width="1000" bgcolor="white" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center" style="padding-top: 10px">
                        <form id="form1" name="form1" action="<?php echo $reportFile ?>" method="post" target="Laporan Triwulan">
                            <table width="600" border="0" cellspacing="0" cellpadding="4">
                                <tr align="center">
                                    <td colspan="2" class="header"><strong><font size="2">Mutasi Barang</font></strong></td>
                                </tr>
                                <!--tr>
                                    <td class="label"><strong>Unit / Satuan Kerja </strong></td>
                                    <td class="content">
                                        <select id="idunit" name="idunit" class="txt" >
                                            <?php
                                            // List of Unit Kerja
                                            $strUnit = "SELECT namaunit,idunit from as_ms_unit where level<3 ";
                                            if ($_SESSION['usertype']!="A") {
                                                if ($_SESSION['usertype']=="P")
                                                    $strUnit .= " and idunit='" . $_SESSION["refidunit"] . "'";
                                                if ($_SESSION['usertype']=="F")
                                                    $strUnit .= " and (idunit='" . $_SESSION["refidunit"] . "' or idunit in (select idunit from $schema.ms_unit where parentunit='" . $_SESSION["refidunit"] . "'))";
                                            }
                                            $strUnit .= " order by idunit";

                                            $rsUnit = mysql_query($strUnit);
                                            while($rowUnit = mysql_fetch_array($rsUnit)) {
                                                ?>
                                            <option value="<?php echo $rowUnit['idunit'];?>"><?php echo $rowUnit['namaunit'];?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label"><strong>Jenis Laporan</strong></td>
                                    <td class="content">
                                        <select name="jlaporan" class="txt" id="jlaporan" tabindex="2" onChange="SetDivSemester(this.value)">
                                            <option value="1">Laporan Mutasi Barang</option>
                                            <option value="2">Daftar Mutasi Barang</option>
                                            <option value="3">Rekap Daftar Mutasi Barang</option>
                                        </select>
                                    </td>
                                </tr-->
                                <tr>
                                    <td class="label"><strong>Periode</strong></td>
                                    <td class="content">
                                        <input name="tglAwal" type="text" class="txtunedited" id="tglAwal" tabindex="4" value="<?php if(isset($tgl) && $tgl != '') echo $tgl;else echo date('d-m-Y'); ?>" size="15" maxlength="15" readonly>
                                        <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tglAwal'),depRange);">
                                        &nbsp; sampai &nbsp;
                                        <input name="tglAkhir" type="text" class="txtunedited" id="tglAkhir" tabindex="4" value="<?php if(isset($tgl) && $tgl != '') echo $tgl;else echo date('d-m-Y'); ?>" size="15" maxlength="15" readonly>
                                        <img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tglAkhir'),depRange);">
                                    </td>
                                </tr>
                                <!--tr>
                                    <td width="139" class="label"><strong>Tahun Anggaran</strong></td>
                                    <td width="439" class="content">
                                        <input name="tahun" type="text" class="txt" id="tahun" tabindex="4" size="15" maxlength="4" value="<?php echo date("Y"); ?>">
                                    </td>
                                </tr-->
                                <tr>
                                    <td class="label"><strong>Format Laporan </strong></td>
                                    <td class="content">
                                        <select name="formatlap" class="txt" id="formatlap" tabindex="7">
                                            <option value="HTML">HTML</option>
                                            <option value="XLS">EXCEL</option>
                                            <option value="WORD">WORD</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr align="center">
                                    <td colspan="2" class="footer">
                                        <input name="submit" type="submit" id="submit" value="Tampilkan">
                                    </td>
                                </tr>
                            </table>
                        </form>
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
    </body>
    <iframe height="193" width="168" name="gToday:normal:agenda.js"
            id="gToday:normal:agenda.js"
            src="../theme/popcjs.php" scrolling="no"
            frameborder="1"
            style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
    </iframe>
    <script type="text/JavaScript" language="JavaScript">
    var arrRange=depRange=[];
        function SetDivSemester(obj){
            if (obj=="1"){
                document.all.divsemester.style.display="block";
            }else{
                document.all.divsemester.style.display="none";
            }
        }
    </script>
</html>