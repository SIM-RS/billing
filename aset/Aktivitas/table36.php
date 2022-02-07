<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/ajax.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <link type="text/css" rel="stylesheet" href="../default.css"/>
        <title>.: PO :.</title>
    </head>
    <body>
        <?php
			include '../sesi.php';
            include '../koneksi/konek.php';
        ?>
        <table id="tblJual" width="99%" height='1000' border="0" cellpadding="0" cellspacing="0" align="center">
            <tr>
                <td colspan="10" align="center" class="jdltable"><hr></td>
            </tr>
            <tr>
                <td colspan="9" align="center" class="jdltable">
                    PURCHASE ORDER</td>
                <td align="right" valign="bottom">
                    <input type="button" value="+" onClick="addRowToTable();" />
                </td>
            </tr>
            <tr class="headtable">
                <td width="25" height="25" class="tblheaderkiri">No</td>
                <td width="100" height="25" class="tblheader">Kode Barang</td>
                <td height="25" class="tblheader">Nama Barang</td>
                <td width="40" height="25" class="tblheader">Jml</td>
                <td width="90" height="25" class="tblheader">Satuan</td>
                <td class="tblheader">Harga Satuan</td>
                <td width="40" height="25" class="tblheader">Lain-lain</td>
                <td class="tblheader">Sub Total</td>
                <td width="40" height="25" class="tblheader">Total Harga</td>
                <td height="25" class="tblheader">Peruntukan</td>
                <td width="30" height="25" class="tblheader">Proses</td>
            </tr>
            <?php
            if($edit == true) {
                $sql = "select id,ms_barang_id,kodebarang,namabarang,vendor_id,namarekanan,no_po,date_format(tgl_po,'%d-%m-%Y') as tgl,kemasan,qty_kemasan,qty_perkemasan,qty_satuan,harga_kemasan
                        from as_po ap inner join as_ms_barang ab on ap.ms_barang_id = ab.idbarang left join as_ms_rekanan ar on ap.vendor_id = ar.idrekanan
                        where no_po = '$no_po' order by id asc";
                $rs1 = mysql_query($sql);
                $i = 0;
                while($rows1 = mysql_fetch_array($rs1)) {
                    ?>
            <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'">
                <td class="tdisikiri" width="25">
                <?php echo ++$i;?>
                </td>
                <td class="tdisi" align="center"><?php echo $rows1['kodebarang'];?></td>
                <td class="tdisi" align="left">
                    <input name="obatid" type="hidden" value="<?php echo $rows1['ms_barang_id'];?>">
                    <input type="text" name="txtObat" class="txtinput" size="40" value="<?php echo $rows1['namabarang'];?>" onKeyUp="suggest(event,this);" autocomplete="off" />
                    <input type="hidden" id="id" name="id" value="<?php echo $rows1['id'];?>" />
                </td>
                <td class="tdisi" width="30">
                    <input type="text" name="txtJml" id="txtJml" class="txtcenter" value="<?php echo $rows1['qty_kemasan'];?>" size="6" onKeyUp="AddRow(event,this,'txtJml')" autocomplete="off" />
                </td>
                <td class="tdisi">
                    <select id="kemasan" name="kemasan" class="txtinput">
                                <?php
                                $qry="select * from as_ms_satuan order by nourut";
                                $exe=mysql_query($qry);
                                while($show=mysql_fetch_array($exe)) {
                                    ?>
                        <option value="<?php echo $show['idsatuan']; ?>" class="txtinput" <?php if($rows1['kemasan'] == $show['idsatuan']) echo 'selected';?>><?php echo $show['idsatuan']; ?></option>
                                    <?php
                                }
                                ?>
                    </select>
                </td>
                <td class="tdisi" width="30">
                    <input name="txtNilai" type="text" class="txtright" id="txtNilai" value="<?php echo $rows1['harga_kemasan'];?>" onKeyUp="AddRow(event,this,'txtNilai')" size="10" autocomplete="off" />
                </td>
                <td class="tdisi" width="30">
                    <input type="text" name="txtLain2" id="txtLain2" class="txtcenter" value="<?php echo $rows1['qty_satuan'];?>" readonly size="6" autocomplete="off" /><!-- onKeyUp="AddRow(event,this,'txtLain2')"-->
                </td>
                <td class="tdisi" width="30">
                    <input name="txtSubTotal" id="txtSubTotal" type="text" class="txtright" value="<?php echo $rows1['qty_kemasan']*$rows1['harga_kemasan'];?>" size="12" readonly="true" />
                </td>
                <td class="tdisi" width="30">
                    <input type="text" name="txtTotal" id="txtTotal" class="txtcenter" value="<?php echo $rows1['qty_perkemasan'];?>" size="6" onKeyUp="AddRow(event,this,'txtTotal')" autocomplete="off" />
                </td>
                <td class="tdisi">
                    <select id="utk_unit_id" class="txt" name="utk_unit_id">
                        <?php
                        $query = "select idunit, namaunit from as_ms_unit";
                        $rs = mysql_query($query);
                        while($row = mysql_fetch_array($rs)) {
                            ?>
                        <option value="<?php echo $row['idunit'];?>" <?php if($rows1['idunit'] == $utk_unit_id) echo 'selected';?>><?php echo $row['namaunit'];?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
                <td class="tdisi">
                    <img alt="del" src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);}">
                </td>
            </tr>
                    <?php
                }
            }
            else {
                ?>
            <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'">
                <td class="tdisikiri" width="25">1
                </td>
                <td class="tdisi" align="center">-</td>
                <td class="tdisi" align="left">
                    <input name="obatid" type="hidden" value="">
                    <input type="text" name="txtObat" class="txtinput" size="40" onKeyUp="suggest(event,this);" autocomplete="off" />
                </td>
                <td class="tdisi" width="30">
                    <input type="text" name="txtJml" id="txtJml" class="txtcenter" size="6" onKeyUp="AddRow(event,this,'txtJml')" autocomplete="off" />
                </td>
                <td class="tdisi">
                    <select id="kemasan" name="kemasan" class="txtinput">
                            <?php
                            $qry="select * from as_ms_satuan order by nourut";
                            $exe=mysql_query($qry);
                            while($show=mysql_fetch_array($exe)) {
                                ?>
                        <option value="<?php echo $show['idsatuan']; ?>" class="txtinput"><?php echo $show['idsatuan']; ?></option>
                                <?php }?>
                    </select>
                </td>
                <td class="tdisi" width="30">
                    <input name="txtNilai" type="text" class="txtright" id="txtNilai" onKeyUp="AddRow(event,this,'txtNilai')" size="10" autocomplete="off" />
                </td>
                <td class="tdisi" width="30">
                    <input type="text" name="txtLain2" id="txtLain2" class="txtright" size="6" readonly="true" />
                </td>
                <td class="tdisi" width="30">
                    <input name="txtSubTotal" id="txtSubTotal" type="text" class="txtright" size="12" readonly="true" />
                </td>
                <td class="tdisi" width="30">
                    <input type="text" name="txtTotal" id="txtTotal" class="txtcenter" size="6" onKeyUp="AddRow(event,this,'txtTotal')" autocomplete="off" />
                </td>
                <td class="tdisi">
                    <select id="utk_unit_id" class="txt" name="utk_unit_id">
                        <?php
                        $query = "select idunit, namaunit from as_ms_unit";
                        $rs = mysql_query($query);
                        while($row = mysql_fetch_array($rs)) {
                            ?>
                        <option value="<?php echo $row['idunit'];?>" <?php if($rows1['idunit'] == $utk_unit_id) echo 'selected';?>><?php echo $row['namaunit'];?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
                <td class="tdisi">
                    <img alt="del" src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);}">
                </td>
            </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>