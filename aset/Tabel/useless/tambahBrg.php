<?php
session_start();
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='/simrs-tangerang/aset/';
                        </script>";
}
?>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <title>Tambah Kode Barang</title>
    </head>

    <body>
        <div align="center">
            <?php
            include("../header.php");
            include("../koneksi/konek.php");
            if($_REQUEST["act"]=="save") {
                $sql_insert="INSERT INTO as_ms_barang (kodebarang,namabarang,idsatuan,tipebarang,level,mru,statuskode,metodedepresiasi,stddepamt,stddeppct,lifetime,nilairesidu,akunaset,akundep,akunakdep,akundisloss,akundisgain,akunmaintenance,akunlease) values ('".$_REQUEST["txtKdBrg"]."','".$_REQUEST["txtNmBrg"]."','".$_REQUEST["cmbSatuan"]."','".$_REQUEST["cmbTipeBrg"]."','".$_REQUEST["cmbLvl"]."','".$_REQUEST["cmbShow"]."','".$_REQUEST["cmbStsKd"]."','".$_REQUEST["cmbMetode"]."','".$_REQUEST["txtPersen"]."','".$_REQUEST["txtNilaiDep"]."','".$_REQUEST["txtLife"]."','".$_REQUEST["txtNilaiResidu"]."','".$_REQUEST["txtakunaset"]."','".$_REQUEST["txtakundep"]."','".$_REQUEST["txtakunakdep"]."','".$_REQUEST["txtakundisloss"]."','".$_REQUEST["txtakundisgain"]."','".$_REQUEST["txtakunmaintenance"]."','".$_REQUEST["txtakunlease"]."')";
                $exe_insert=mysql_query($sql_insert);
                if($exe_insert>0) echo "<script>alert('Data Telah Berhasil Tersimpan..');</script>";
            }
            ?>
            <div>
                <form name="form1" id="form1" action="" method="post">
                    <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>&nbsp;</td>

                        </tr>
                        <tr>
                            <td align="center">
                                <table width="100" border=0 cellspacing=0 cellpadding="0" class="GridStyle" bgcolor="#999999">
                                    <tr>
                                        <td width="20%" height="29" align="left" nowrap>
                                            <button class="Enabledbutton" id="backbutton" onClick="location='kode_brg.php'" title="Back" style="cursor:pointer">
                                                <img alt="back" src="../images/backsmall.gif" width="22" height="22" border="0" align="absmiddle" />
					Back to List
                                            </button>
                                        </td>
                                        <td width="20%" align="left" nowrap>
                                            <button class="Disabledbutton" disabled=true id="editbutton" name="editbutton" onClick="goEdit()" title="Edit" style="cursor:pointer">
                                                <img alt="edit" src="../images/editsmall.gif" width="22" height="22" border="0" align="absmiddle" />
      				Edit Record
                                            </button>
                                        </td>
                                        <td width="20%" align="left" nowrap>
                                            <button class="Enabledbutton" id="btnSimpan" name="btnSimpan" onClick="document.getElementById('act').value='save';form1.submit()" title="Save" style="cursor:pointer">
                                                <img alt="save" src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" />
      				Save Record
                                            </button>
                                        </td>
                                        <td width="20%" align="left" nowrap>
                                            <button class="Disabledbutton" id="undobutton" disabled=true onClick="goUndo()" title="Cancel / Refresh" style="cursor:pointer">
                                                <img alt="undo/refresh" src="../images/undosmall.gif" width="22" height="22" border="0" align="absmiddle" />
      				Undo/Refresh
                                            </button>
                                        </td>
                                        <td width="20%" align="left" nowrap>
                                            <button class="Disabledbutton" id="deletebutton" disabled=true onClick="goDelete()" title="Delete" style="cursor:pointer">
                                                <img alt="delete" src="../images/deletesmall.gif" width="22" height="22" border="0" align="absmiddle" />
      				Delete
                                            </button>
                                        </td>
                                        <td width="20%" align="left" nowrap>
                                            <button class="Enabledbutton" id="helpbutton" onClick="goHelp()" title="Help" style="cursor:pointer">
                                                <img alt="?" src="../images/help_book.gif" width="22" height="22" border="0" align="absmiddle" />
					?
                                            </button>
                                        </td>
                                    </tr>
                                </table>
                                <br />
                                <input name="act" id="act" type="hidden" />
                                <table width="625" border="1" cellspacing="0" cellpadding="2" align="center">
                                    <tr>
                                        <td colspan="2" height="28" class="header">.: Data Kode Barang :.</td>
                                    </tr>
                                    <tr>
                                        <td width="40%" height="20" class="label">&nbsp;Kode Barang</td>
                                        <td width="60%" class="content">&nbsp;<input id="txtKdBrg" name="txtKdBrg" size="24" style="background-color:#99FFFF;" />&nbsp;<i>(contoh 01.01.02.03.05)</i></td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Nama Barang</td>
                                        <td class="content">&nbsp;<input id="txtNmBrg" name="txtNmBrg" size="40" /></td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Satuan</td>
                                        <td class="content">&nbsp;
                                            <select name="cmbSatuan" id="cmbSatuan">
                                                <?php
                                                $sqlSatuan=mysql_query("SELECT idsatuan,nourut FROM as_ms_satuan");
                                                while($showSatuan=mysql_fetch_array($sqlSatuan)) {
                                                    ?>
                                                <option value="<?=$showSatuan['idsatuan'];?>"><?=$showSatuan['idsatuan'];?></option>
                                                    <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Tipe Barang</td>
                                        <td class="content">&nbsp;
                                            <select id="cmbTipeBrg" name="cmbTipeBrg">
                                                <option value="TT">TT - Tetap</option>
                                                <option value="BG">BG - Bergerak</option>
                                                <option value="HP">HP - Habis Pakai</option>
                                                <option value="IT">Intangible</option>
                                                <option value="BH">BH - Hidup</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Level</td>
                                        <td class="content">&nbsp;
                                            <select id="cmbLvl" name="cmbLvl">
                                                <option value="1">1 - Golongan</option>
                                                <option value="2">2 - Bidang</option>
                                                <option value="3">3 - Kelompok</option>
                                                <option value="4">4 - Sub Kelompok</option>
                                                <option value="5">5 - Sub Sub Kel</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Show on list</td>
                                        <td class="content">&nbsp;
                                            <select id="cmbShow" name="cmbShow">
                                                <option value="1">Show</option>
                                                <option value="0">Hide</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Status Kode</td>
                                        <td class="content">&nbsp;
                                            <select id="cmbStsKd" name="cmbStsKd">
                                                <option value="N">Normal</option>
                                                <option value="B">Baru</option>
                                                <option value="H">Hapus</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="28" colspan="2" class="header2">&nbsp;Informasi Depresiasi / Penyusutan</td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Metode Depresiasi</td>
                                        <td class="content">&nbsp;
                                            <select id="cmbMetode" name="cmbMetode">
                                                <option value="NN">NN - Tidak Susut</option>
                                                <option value="SL">SL - Garis Lurus</option>
                                                <option value="RB">RB - Saldo Menurun</option>
                                                <option value="DD">DD - Double Declining</option>
                                                <option value="SY">SY - Sum Of Years</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;A. Prosentase Dep.</td>
                                        <td class="content">&nbsp;<input id="txtPersen" name="txtPersen" size="16" />&nbsp;%</td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;B. Nilai Dep.</td>
                                        <td class="content">&nbsp;<input id="txtNilaiDep" name="txtNilai" size="16" />&nbsp;Rp.</td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;C. Life Time</td>
                                        <td class="content">&nbsp;<input id="txtLife" name="txtLife" size="16" />&nbsp;bulan</td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Nilai Residu</td>
                                        <td class="content">&nbsp;<input id="txtNilaiResidu" name="txtNilaiResidu" size="16" value="0.00" />&nbsp;Rp.</td>
                                    </tr>
                                    <tr>
                                        <td height="28" colspan="2" class="header2">&nbsp;Kode Rekening Keuangan</td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Akun. Aset</td>
                                        <td class="content">&nbsp;<input id="txtakunaset" name="txtakunaset" size="50" /></td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Akun. Penyusutan</td>
                                        <td class="content">&nbsp;<input id="txtakundep" name="txtakundep" size="50" /></td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Akun. Ak. Penyusutan</td>
                                        <td class="content">&nbsp;<input id="txtakunakdep" name="txtakunakdep" size="50" /></td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Akun. Disposal Loss</td>
                                        <td class="content">&nbsp;<input id="txtakundisloss" name="txtakundisloss" size="50" /></td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Akun. Disposal Gain</td>
                                        <td class="content">&nbsp;<input id="txtakundisgain" name="txtakundisgain" size="50" /></td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Akun. Maintenance</td>
                                        <td class="content">&nbsp;<input id="txtakunmaintenance" name="txtakunmaintenance" size="50" /></td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Akun. Lease</td>
                                        <td class="content">&nbsp;<input id="txtakunlease" name="txtakunlease" size="50" /></td>
                                    </tr>
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
                </form>
            </div>
        </div>
    </body>
</html>
