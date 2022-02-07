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
        <title>Tambah Rekanan</title>
    </head>

    <body>
        <div align="center">
            <?php
            include("../header.php");
            include("../koneksi/konek.php");
            if($_REQUEST["act"]=="save") {
                $sql_insert="INSERT INTO as_ms_rekanan (koderekanan,namarekanan,idtipesupplier,alamat,alamat2,telp,telp2,kodepos,kota,negara,hp,fax,email,contactperson,deskripsi,status,npwp,fp,siupp) values ('".$_REQUEST["txtkoderekanan"]."','".$_REQUEST["txtnamarekanan"]."','".$_REQUEST["cmbidtipesupplier"]."','".$_REQUEST["txtalamat"]."','".$_REQUEST["txtalamat2"]."','".$_REQUEST["txttelp"]."','".$_REQUEST["txttelp2"]."','".$_REQUEST["txtkodepos"]."','".$_REQUEST["txtkota"]."','".$_REQUEST["txtnegara"]."','".$_REQUEST["txthp"]."','".$_REQUEST["txtfax"]."','".$_REQUEST["txtemail"]."','".$_REQUEST["txtcontactperson"]."','".$_REQUEST["txtdeskripsi"]."','".$_REQUEST["cmbstatus"]."','".$_REQUEST["txtnpwp"]."','".$_REQUEST["txtfp"]."','".$_REQUEST["txtsiupp"]."')";
                $exe_insert=mysql_query($sql_insert);
                if($exe_insert>0) echo "<script>alert('Data Telah Berhasil Tersimpan..');</script>";
            }
            ?>
            <div>
                <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>&nbsp;</td>

                    </tr>
                    <tr>
                        <td align="center">
                            <table width="100" border=0 cellspacing=0 cellpadding="0" class="GridStyle" bgcolor="#999999">
                                <tr>
                                    <td width="20%" height="29" align="left" nowrap>
                                        <button class="Enabledbutton" id="backbutton" onClick="location='rekanan.php'" title="Back" style="cursor:pointer">
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
                                            <img alt="undo / refresh" src="../images/undosmall.gif" width="22" height="22" border="0" align="absmiddle" />
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
                                            <img alt="help" src="../images/help_book.gif" width="22" height="22" border="0" align="absmiddle" />
                                            ?
                                        </button>
                                    </td>
                                </tr>
                            </table>
                            <br />
                            <form name="form1" id="form1" action="" method="post">
                                <input name="act" id="act" type="hidden" />
                                <table width="625" border="1" cellspacing="0" cellpadding="2" align="center">
                                    <tr>
                                        <td colspan="2" height="28" class="header">.: Data Rekanan / Supplier :.</td>
                                    </tr>
                                    <tr>
                                        <td width="40%" height="20" class="label">&nbsp;ID Rekanan</td>
                                        <td width="60%" class="content">&nbsp;<input id="txtkoderekanan" name="txtkoderekanan" size="24"/></td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Nama Rekanan</td>
                                        <td class="content">&nbsp;<input id="txtnamarekanan" name="txtnamarekanan" size="50" /></td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Tipe Supplier</td>
                                        <td class="content">&nbsp;
                                            <select name="cmbidtipesupplier" id="cmbidtipesupplier">
                                                <?php
                                                $sqlSup=mysql_query("SELECT idtipesupplier,keterangan FROM as_tiperekanan");
                                                while($showSup=mysql_fetch_array($sqlSup)) {
                                                    ?>
                                                <option value="<?=$showSup['idtipesupplier'];?>"><?=$showSup['keterangan'];?></option>
                                                    <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Status</td>
                                        <td class="content">&nbsp;<select id="cmbstatus" name="cmbstatus">
                                                <option value="0">Non Aktif</option>
                                                <option value="1">Aktif</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="28" colspan="2" class="header2">&nbsp;Kontak</td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Alamat</td>
                                        <td class="content">&nbsp;<input id="txtalamat" name="txtalamat" size="55" /><br />&nbsp;<input id="txtalamat2" name="txtalamat2" size="55" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Telp</td>
                                        <td class="content">&nbsp;<input id="txttelp" name="txttelp" size="24" /><br />&nbsp;<input id="txttelp2" name="txttelp2" size="24" /></td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;HP</td>
                                        <td class="content">&nbsp;<input id="txthp" name="txthp" size="24" /></td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Email</td>
                                        <td class="content">&nbsp;<input id="txtemail" name="txtemail" size="45" /></td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Fax</td>
                                        <td class="content">&nbsp;<input id="txtfax" name="txtfax" size="24"/></td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Kode Pos</td>
                                        <td class="content">&nbsp;<input id="txtkodepos" name="txtkodepos" size="16" /></td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Kota, Negara</td>
                                        <td class="content">&nbsp;<input id="txtkota" name="txtkota" size="24" />&nbsp;,&nbsp;<input id="txtnegara" name="txtnegara" size="24" /></td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Contact Person</td>
                                        <td class="content">&nbsp;<input id="txtcontactperson" name="txtcontactperson" size="50" /></td>
                                    </tr>
                                    <tr>
                                        <td height="28" colspan="2" class="header2">&nbsp;Keterangan Tambahan</td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;N.P.W.P</td>
                                        <td class="content">&nbsp;<input id="txtnpwp" name="txtnpwp" size="50" /></td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;No Faktur Pajak</td>
                                        <td class="content">&nbsp;<input id="txtfp" name="txtfp" size="50" /></td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;S.I.U.P.P</td>
                                        <td class="content">&nbsp;<input id="txtsiupp" name="txtsiupp" size="50" /></td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Catatan Khusus</td>
                                        <td class="content">&nbsp;<textarea id="txtdeskripsi" name="txtdeskripsi" cols="50"></textarea></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="header2">&nbsp;</td>
                                    </tr>
                                </table>
                            </form>
                            <?php
                            include '../footer.php';
                            ?>
                        </td>

                    </tr>
                </table>
            </div>
        </div>
    </body>
</html>