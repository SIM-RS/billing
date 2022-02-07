<?
include '../sesi.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <title>Kode Barang</title>
    </head>

    <body>
        <div align="center">
            <?php
            include("../header.php");
            include("../koneksi/konek.php");
            $idbarang = $_REQUEST['idbarang'];

            $sqlBrg = "SELECT idbarang,kodebarang,namabarang,idsatuan,tipebarang,level,mru,statuskode,metodedepresiasi,stddepamt,stddeppct,lifetime,nilairesidu,akunaset,akundep,akunakdep,akundisloss,akundisgain,akunmaintenance,akunlease FROM as_ms_barang WHERE idbarang = '".$idbarang."'";
            $dtBrg = mysql_query($sqlBrg);
            $rwBrg = mysql_fetch_array($dtBrg);
            ?>
            <div>
                <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>&nbsp;</td>

                    </tr>
                    <tr>
                        <td align="center">
                            <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>&nbsp;</td>

                                </tr>
                                <tr>
                                    <td align="center">
                                        <table width="100" border=0 cellspacing=0 cellpadding="0" class="GridStyle" bgcolor="#999999">
                                            <tr>
                                                <td width="20%" height="29" align="left" nowrap>
                                                    <button class="EnabledButton" id="backButton" onClick="location='kode_brg.php'" title="Back" style="cursor:pointer">
                                                        <img  src="../images/backsmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                                            Back to List</button></td>
                                                <td width="20%" align="left" nowrap>
                                                    <button class="EnabledButton" id="editButton" name="editButton" onClick="location='editBrg.php?idbarang=<?php echo $idbarang;?>'" title="Edit" style="cursor:pointer">
                                                        <img src="../images/editsmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                                            Edit Record</button></td>
                                                <td width="20%" align="left" nowrap>
                                                    <button class="DisabledButton" id="saveButton" disabled=true onClick="goSave()" title="Save" style="cursor:pointer">
                                                        <img  src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                                        Save Record</button></td>
                                                <td width="20%" align="left" nowrap>
                                                    <button class="DisabledButton" id="undoButton" disabled=true onClick="goUndo()" title="Cancel / Refresh" style="cursor:pointer">
                                                        <img src="../images/undosmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                                        Undo/Refresh</button></td>
                                                <td width="20%" align="left" nowrap>
                                                    <button class="EnabledButton" id="deleteButton" onClick="goDelete()" title="Delete" style="cursor:pointer">
                                                        <img  src="../images/deletesmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                                        Delete</button></td>
                                                <td width="20%" align="left" nowrap>
                                                    <button class="EnabledButton" id="helpButton" onClick="goHelp()" title="Help" style="cursor:pointer">
                                                        <img  src="../images/help_book.gif" width="22" height="22" border="0" align="absmiddle" /> ?
                                                    </button></td>
                                            </tr>
                                        </table>
                                        <br />
                                        <table width="625" bordercolor="#000000" border="1" cellspacing="0" cellpadding="2" align="center">
                                            <tr>
                                                <td colspan="2" height="28" class="header">.: Data Kode Barang :.</td>
                                            </tr>
                                            <tr>
                                                <td width="40%" height="20" class="label">&nbsp;Kode Barang</td>
                                                <td width="60%" class="content">&nbsp;<?php echo $rwBrg['kodebarang']; ?></td>
                                            </tr>
                                            <tr>
                                                <td height="20" class="label">&nbsp;Nama Barang</td>
                                                <td class="content">&nbsp;<?php echo $rwBrg['namabarang']; ?></td>
                                            </tr>
                                            <tr>
                                                <td height="20" class="label">&nbsp;Satuan</td>
                                                <td class="content">&nbsp;<?php echo $rwBrg['idsatuan']; ?></td>
                                            </tr>
                                            <tr>
                                                <td height="20" class="label">&nbsp;Tipe Barang</td>
                                                <td class="content">&nbsp;<?php echo $rwBrg['tipebarang']; ?></td>
                                            </tr>
                                            <tr>
                                                <td height="20" class="label">&nbsp;Level</td>
                                                <td class="content">&nbsp;<?php echo $rwBrg['level']; ?></td>
                                            </tr>
                                            <tr>
                                                <td height="20" class="label">&nbsp;Show on list</td>
                                                <td class="content">&nbsp;<?php if($rwBrg['mru'] == '1') {
                                                        echo Show;
                                                    } elseif($rwBrg['mru'] == '0') {
                                                        echo Hide;
                                                    }?></td>
                                            </tr>
                                            <tr>
                                                <td height="20" class="label">&nbsp;Status Kode</td>
                                                <td class="content">&nbsp;<?php if($rwBrg['statuskode'] == 'N') {
                                                        echo Normal;
                                                    }
                                                    elseif($rwBrg['statuskode'] == 'B') {
                                                        echo Baru;
                                                    }
                                                    else {
                                                        echo Hapus;
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="28" colspan="2" class="header2">&nbsp;Informasi Depresiasi / Penyusutan</td>
                                            </tr>
                                            <tr>
                                                <td height="20" class="label">&nbsp;Metode Depresiasi</td>
                                                <td class="content">&nbsp;<?php echo $rwBrg['metodedepresiasi']; ?></td>
                                            </tr>
                                            <tr>
                                                <td height="20" class="label">&nbsp;A. Prosentase Dep.</td>
                                                <td class="content">&nbsp;<?php echo $rwBrg['stddepamt']; ?>&nbsp;%</td>
                                            </tr>
                                            <tr>
                                                <td height="20" class="label">&nbsp;B. Nilai Dep.</td>
                                                <td class="content">&nbsp;<?php echo $rwBrg['stddeppct']; ?></td>
                                            </tr>
                                            <tr>
                                                <td height="20" class="label">&nbsp;C. Life Time</td>
                                                <td class="content">&nbsp;<?php echo $rwBrg['lifetime']; ?>&nbsp;bulan</td>
                                            </tr>
                                            <tr>
                                                <td height="20" class="label">&nbsp;Nilai Residu</td>
                                                <td class="content">&nbsp;<?php echo $rwBrg['nilairesidu']; ?></td>
                                            </tr>
                                            <tr>
                                                <td height="28" colspan="2" class="header2">&nbsp;Kode Rekening Keuangan</td>
                                            </tr>
                                            <tr>
                                                <td height="20" class="label">&nbsp;Akun. Aset</td>
                                                <td class="content">&nbsp;<?php echo $rwBrg['akunaset']; ?></td>
                                            </tr>
                                            <tr>
                                                <td height="20" class="label">&nbsp;Akun. Penyusutan</td>
                                                <td class="content">&nbsp;<?php echo $rwBrg['akundep']; ?></td>
                                            </tr>
                                            <tr>
                                                <td height="20" class="label">&nbsp;Akun. Ak. Penyusutan</td>
                                                <td class="content">&nbsp;<?php echo $rwBrg['akunakdep']; ?></td>
                                            </tr>
                                            <tr>
                                                <td height="20" class="label">&nbsp;Akun. Disposal Loss</td>
                                                <td class="content">&nbsp;<?php echo $rwBrg['akundisloss']; ?></td>
                                            </tr>
                                            <tr>
                                                <td height="20" class="label">&nbsp;Akun. Disposal Gain</td>
                                                <td class="content">&nbsp;<?php echo $rwBrg['akundisgain']; ?></td>
                                            </tr>
                                            <tr>
                                                <td height="20" class="label">&nbsp;Akun. Maintenance</td>
                                                <td class="content">&nbsp;<?php echo $rwBrg['akunmaintenance']; ?></td>
                                            </tr>
                                            <tr>
                                                <td height="20" class="label">&nbsp;Akun. Lease</td>
                                                <td class="content">&nbsp;<?php echo $rwBrg['akunlease']; ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="header2">&nbsp;</td>
                                            </tr>
                                        </table>
                                        <table width="625" align="center">
                                            <tr>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td><fieldset style="background-color:#FFFFCC">
                                                        <b><u>Keterangan</u></b><br />
                                                        <b>Tipe Barang</b>&nbsp;( TT = Brg. Tetap | BG = Brg. Bergerak | HP = Brg. Habis Pakai | IT = Intangible Aset | BH = Benda Hidup )<br />
                                                        <b>Status</b>&nbsp;( N = Normal | B = Kode Baru | X = Kode Dihapus )<br />
                                                        <b>Show</b>&nbsp;( Kode Barang yang sering digunakan akan ditampilkan dalam daftar )
                                                    </fieldset></td>
                                            </tr>
                                        </table>
                                        <?php
                                        include '../footer.php';
                                        ?>
                                    </td>

                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
</html>