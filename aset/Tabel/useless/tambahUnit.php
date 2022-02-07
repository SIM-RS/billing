
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <title>Tambah Unit Kerja</title>
    </head>

    <body>
        <div align="center">
            <?php
            include("../header.php");
            include("../koneksi/konek.php");
            if($_REQUEST["act"]=="save") {
                $sql_insert="INSERT INTO as_ms_unit (kodeunit,namaunit,namapanjang,parentunit,level,kodeupb,nippetugas,namapetugas,jabatanpetugas,nippetugas2,namapetugas2,jabatanpetugas2) values ('".$_REQUEST["txtKdUnt"]."','".$_REQUEST["txtNm"]."','".$_REQUEST["txtNmPjg"]."','".$_REQUEST["cmbInduk"]."','".$_REQUEST["cmbLvl"]."','".$_REQUEST["txtKdUpb"]."','".$_REQUEST["txtNip"]."','".$_REQUEST["txtNama"]."','".$_REQUEST["txtJbtn"]."','".$_REQUEST["txtNip2"]."','".$_REQUEST["txtNama2"]."','".$_REQUEST["txtJbtn2"]."')";
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
                                        <button class="Enabledbutton" id="backbutton" onClick="location='unit.php'" title="Back" style="cursor:pointer">
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
                                        <button class="Enabledbutton" id="btnSimpan" name="btnSimpan" onclick="document.getElementById('act').value='save';form1.submit()" title="Save" style="cursor:pointer">
                                            <img alt="save" src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" />
                                            Save Record
                                        </button>
                                    </td>
                                    <td width="20%" align="left" nowrap>
                                        <button class="Disabledbutton" id="undobutton" disabled=true onClick="goUndo()" title="Cancel / Refresh" style="cursor:pointer">
                                            <img alt="refresh" src="../images/undosmall.gif" width="22" height="22" border="0" align="absmiddle" />
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
                            <form name="form1" id="form1" action="" method="post">
                                <input name="act" id="act" type="hidden" />
                                <table width="625" border="1" cellspacing="0" cellpadding="2" align="center">
                                    <tr>
                                        <td colspan="2" height="28" class="header">.: Data Unit / Satuan Kerja :. (Edit Mode)</td>
                                    </tr>
                                    <tr>
                                        <td width="40%" height="20" class="label">&nbsp;Kode Unit / Sat Ker</td>
                                        <td width="60%" class="content">&nbsp;<input id="txtKdUnt" name="txtKdUnt" size="24" style="background-color:#99FFFF;"/></td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Nama Singkat</td>
                                        <td class="content">&nbsp;<input id="txtNm" name="txtNm" size="32"/></td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Nama Panjang</td>
                                        <td class="content">&nbsp;<input id="txtNmPjg" name="txtNmPjg" size="32" /></td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Induk Unit</td>
                                        <td class="content">&nbsp;
                                            <select name="cmbInduk" id="cmbInduk">
                                                <?php
                                                $sqlInduk=mysql_query("SELECT idunit,kodeunit,namaunit FROM as_ms_unit ORDER BY kodeunit");
                                                while($showInduk=mysql_fetch_array($sqlInduk)) {
                                                    ?>
                                                <option value="<?=$showInduk['idunit'];?>"><?=$showInduk['kodeunit'];?> - <?=$showInduk['namaunit'];?></option>
                                                    <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Level</td>
                                        <td class="content">&nbsp;
                                            <select id="cmbLvl" name="cmbLvl">
                                                <option value="1">1 - Bidang</option>
                                                <option value="2">2 - Unit Bidang</option>
                                                <option value="3">3 - Sub Unit/Satuan Kerja</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Kode UPB / Lokasi</td>
                                        <td class="content">&nbsp;<input id="txtKdUpb" name="txtKdUpb" size="42" /></td>
                                    </tr>
                                    <tr>
                                        <td height="28" colspan="2" class="header2">&nbsp;Petugas Pengesahan 1</td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;NIP</td>
                                        <td class="content">&nbsp;<input id="txtNip" name="txtNip" size="24" /></td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Nama</td>
                                        <td class="content">&nbsp;<input id="txtNama" name="txtNama" size="42" /></td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Jabatan</td>
                                        <td class="content">&nbsp;<input id="txtJbtn" name="txtJbtn" size="42" /></td>
                                    </tr>
                                    <tr>
                                        <td height="28" colspan="2" class="header2">&nbsp;Petugas Pengesahan 2</td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;NIP</td>
                                        <td class="content">&nbsp;<input id="txtNip2" name="txtNip2" size="24" /></td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Nama</td>
                                        <td class="content">&nbsp;<input id="txtNama2" name="txtNama2" size="42" /></td>
                                    </tr>
                                    <tr>
                                        <td height="20" class="label">&nbsp;Jabatan</td>
                                        <td class="content">&nbsp;<input id="txtJbtn2" name="txtJbtn2" size="42" /></td>
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
                                                <b>Level</b>&nbsp;( 1 = Bidang | 2 = Unit Bidang | 3 = Sub Unit/Satuan Kerja )
                                            </fieldset>
                                        </td>
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
