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
        <title>.: Edit Kode Barang :.</title>
    </head>

    <body>
        <div align="center">
            <?php
            include("../header.php");
            include("../koneksi/konek.php");
            $idbarang = $_REQUEST['idbarang'];
            if($_REQUEST["act"]=="save") {
                $sql_update="UPDATE as_ms_barang SET kodebarang='".$_REQUEST["txtKdBrg"]."',namabarang='".$_REQUEST["txtNmBrg"]."',idsatuan='".$_REQUEST["cmbSatuan"]."',tipebarang='".$_REQUEST["cmbTipeBrg"]."',level='".$_REQUEST["cmbLvl"]."',mru='".$_REQUEST["cmbShow"]."',statuskode='".$_REQUEST["cmbStsKd"]."',metodedepresiasi='".$_REQUEST["cmbMetode"]."',stddepamt='".$_REQUEST["txtPersen"]."',stddeppct='".$_REQUEST["txtNilaiDep"]."',lifetime='".$_REQUEST["txtLife"]."',nilairesidu='".$_REQUEST["txtNilaiResidu"]."',akunaset='".$_REQUEST["txtakunaset"]."',akundep='".$_REQUEST["txtakundep"]."',akunakdep='".$_REQUEST["txtakunakdep"]."',akundisloss='".$_REQUEST["txtakundisloss"]."',akundisgain='".$_REQUEST["txtakundisgain"]."',akunmaintenance='".$_REQUEST["txtakunmaintenance"]."',akunlease='".$_REQUEST["txtakunlease"]."' WHERE idbarang=$idbarang";
                $exe_update=mysql_query($sql_update);
                if($exe_update>0) {
                    echo "<script>alert('Data Telah Berhasil Tersimpan..');
			window.location= 'kode_brg.php';
			</script>";
                }
            }

            $idbarang = $_REQUEST['idbarang'];

            $sqBrg = "SELECT idbarang,kodebarang,namabarang,idsatuan,tipebarang,level,mru,statuskode,metodedepresiasi,stddepamt,stddeppct,lifetime,nilairesidu,akunaset,akundep,akunakdep,akundisloss,akundisgain,akunmaintenance,akunlease FROM as_ms_barang WHERE idbarang = '".$idbarang."'";
            $rsBrg = mysql_query($sqBrg);
            $rowBrg = mysql_fetch_array($rsBrg);

            ?>
            <form name="form1" id="form1" action="" method="post">
                <input name="act" id="act" type="hidden" />
                <div>
                    <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>&nbsp;</td>

                        </tr>
                        <tr>
                            <td align="center">
                                <table width="625"  border="0" cellspacing="0" cellpadding="2" align="center">
                                    <tr>
                                        <td height="30" colspan="2" valign="bottom" align="right">
                                            <button class="Enabledbutton" id="backbutton" type="button" onClick="location='kode_brg.php'" title="Back" style="cursor:pointer">
                                                <img alt="back" src="../images/backsmall.gif" width="22" height="22" border="0" align="absmiddle" />
                		Back to List
                                            </button>
                                            <button class="Enabledbutton" id="btnSimpan" name="btnSimpan" onClick="document.getElementById('act').value='save';form1.submit()" title="Save" style="cursor:pointer">
                                                <img alt="save" src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" />
      				Save Record
                                            </button>
                                            <button class="Disabledbutton" id="undobutton" disabled="true" onClick="location='editBrg.php'" title="Cancel / Refresh" style="cursor:pointer">
                                                <img alt="undo/refresh" src="../images/undosmall.gif" width="22" height="22" border="0" align="absmiddle" />
      					Undo/Refresh
                                            </button></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" height="28" class="header">.: Data Kode Barang :. (Edit Mode)</td>
                                    </tr>
                                    <tr>
                                        <td width="40%" height="20" class="label">&nbsp;Kode Barang</td>
                                        <td width="60%" class="content">&nbsp;<input id="txtKdBrg" name="txtKdBrg" value="<?php echo $rowBrg['kodebarang'];?>" size="24" style="background-color:#99FFFF;" />&nbsp;<i>(contoh 01.01.02.03.05)</i></td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Nama Barang</td>
                                        <td class="content">&nbsp;<input id="txtNmBrg" name="txtNmBrg" value="<?php echo $rowBrg['namabarang']; ?>" size="40" /></td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Satuan</td>
                                        <td class="content">&nbsp;<select name="cmbSatuan" id="cmbSatuan">
                                                <?php
                                                $sqlSatuan=mysql_query("SELECT idsatuan,nourut FROM as_ms_satuan");
                                                while($showSatuan=mysql_fetch_array($sqlSatuan)) {
                                                    ?>
                                                <option <?php if($rowBrg['idsatuan'] == $showSatuan['idsatuan']) echo 'selected';?> value="<?=$showSatuan['idsatuan'];?>"><?=$showSatuan['idsatuan'];?></option>
                                                    <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Tipe Barang</td>
                                        <td class="content">&nbsp;<select id="cmbTipeBrg" name="cmbTipeBrg">
                                                <option <?php if($rowBrg['tipebarang'] == 'TT') echo 'selected'; ?> value="TT">TT - Tetap</option>
                                                <option <?php if($rowBrg['tipebarang'] == 'BG') echo 'selected'; ?> value="BG">BG - Bergerak</option>
                                                <option <?php if($rowBrg['tipebarang'] == 'HP') echo 'selected'; ?> value="HP">HP - Habis Pakai</option>
                                                <option <?php if($rowBrg['tipebarang'] == 'IT') echo 'selected'; ?> value="IT">Intangible</option>
                                                <option <?php if($rowBrg['tipebarang'] == 'BH') echo 'selected'; ?> value="BH">BH - Hidup</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Level</td>
                                        <td class="content">&nbsp;<select id="cmbLvl" name="cmbLvl">
                                                <option <?php if($rowBrg['level'] == 1) echo 'selected'; ?> value="1">1 - Golongan</option>
                                                <option <?php if($rowBrg['level'] == 2) echo 'selected'; ?> value="2">2 - Bidang</option>
                                                <option <?php if($rowBrg['level'] == 3) echo 'selected'; ?> value="3">3 - Kelompok</option>
                                                <option <?php if($rowBrg['level'] == 4) echo 'selected'; ?> value="4">4 - Sub Kelompok</option>
                                                <option <?php if($rowBrg['level'] == 5) echo 'selected'; ?> value="5">5 - Sub Sub Kel</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Show on list</td>
                                        <td class="content">&nbsp;<select id="cmbShow" name="cmbShow">
                                                <option <?php if($rowBrg['mru'] == 1) echo 'selected'; ?> value="1">Show</option>
                                                <option <?php if($rowBrg['mru'] == 0) echo 'selected'; ?> value="0">Hide</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Status Kode</td>
                                        <td class="content">&nbsp;<select id="cmbStsKd" name="cmbStsKd">
                                                <option <?php if($rowBrg['statuskode'] == 'N') echo 'selected'; ?> value="N">Normal</option>
                                                <option <?php if($rowBrg['statuskode'] == 'B') echo 'selected'; ?> value="B">Baru</option>
                                                <option <?php if($rowBrg['statuskode'] == 'H') echo 'selected'; ?> value="H">Hapus</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="28" colspan="2" class="header2">&nbsp;Informasi Depresiasi / Penyusutan</td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Metode Depresiasi</td>
                                        <td class="content">&nbsp;<select id="cmbMetode" name="cmbMetode">
                                                <option <?php if($rowBrg['metodedepresiasi'] == 'NN') echo 'selected'; ?> value="NN">NN - Tidak Susut</option>
                                                <option <?php if($rowBrg['metodedepresiasi'] == 'SL') echo 'selected'; ?> value="SL">SL - Garis Lurus</option>
                                                <option <?php if($rowBrg['metodedepresiasi'] == 'RB') echo 'selected'; ?> value="RB">RB - Saldo Menurun</option>
                                                <option <?php if($rowBrg['metodedepresiasi'] == 'DD') echo 'selected'; ?> value="DD">DD - Double Declining</option>
                                                <option <?php if($rowBrg['metodedepresiasi'] == 'SY') echo 'selected'; ?> value="SY">SY - Sum Of Years</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;A. Prosentase Dep.</td>
                                        <td class="content">&nbsp;<input id="txtPersen" name="txtPersen" size="16" value="<?php echo $rowBrg['stddepamt'];?>" />&nbsp;%</td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;B. Nilai Dep.</td>
                                        <td class="content">&nbsp;<input id="txtNilaiDep" name="txtNilai" size="16" value="<?php echo $rowBrg['stddeppct'];?>" />&nbsp;Rp.</td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;C. Life Time</td>
                                        <td class="content">&nbsp;<input id="txtLife" name="txtLife" size="16" value="<?php echo $rowBrg['lifetime'];?>"/>&nbsp;bulan</td>
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
                                        <td class="content">&nbsp;<input id="txtakunaset" name="txtakunaset" size="50" value="<?php echo $rowBrg['akunaset'];?>" /></td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Akun. Penyusutan</td>
                                        <td class="content">&nbsp;<input id="txtakundep" name="txtakundep" size="50" value="<?php echo $rowBrg['akundep'];?>"/></td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Akun. Ak. Penyusutan</td>
                                        <td class="content">&nbsp;<input id="txtakunakdep" name="txtakunakdep" size="50" value="<?php echo $rowBrg['akunakdep'];?>"/></td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Akun. Disposal Loss</td>
                                        <td class="content">&nbsp;<input id="txtakundisloss" name="txtakundisloss" size="50" value="<?php echo $rowBrg['akundisloss'];?>"/></td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Akun. Disposal Gain</td>
                                        <td class="content">&nbsp;<input id="txtakundisgain" name="txtakundisgain" size="50" value="<?php echo $rowBrg['akundisgain'];?>"/></td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Akun. Maintenance</td>
                                        <td class="content">&nbsp;<input id="txtakunmaintenance" name="txtakunmaintenance" size="50" value="<?php echo $rowBrg['akunmaintenance'];?>"/></td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Akun. Lease</td>
                                        <td class="content">&nbsp;<input id="txtakunlease" name="txtakunlease" size="50" value="<?php echo $rowBrg['akunlease'];?>"/></td>
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
                </div>
            </form>
        </div>
    </body>
</html>
