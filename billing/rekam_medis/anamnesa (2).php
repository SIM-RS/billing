<div id="hslAnamnesa" style="display:none"></div>
<div id="hsl_RA_terakhir" style="display:none"></div>
<div id="hsl_cmb_PF" style="display:none"></div>
<img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" />
<fieldset>
    <legend id="lgnIsiDataRM">ANAMNESA &amp; PEMERIKSAAN FISIK</legend>
    <div id=""></div>
    <form id="form_isi_anamnesa" name="form_isi_anamnesa">
    <table border="0" cellpadding="0" cellspacing="0" align="center" width="950">
        <tr>
            <td colspan="4">Pelaksana&nbsp;:&nbsp;
                <select id="cmbDokAnamnesa" name="cmbDokAnamnesa">
                    <option>-</option>
                </select>
                <label>
                    <input type="checkbox" id="chkDokterPenggantiAnamnesa" value="1" onchange="gantiDokter('cmbDokAnamnesa',this.checked);"/>Dokter Pengganti
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="padding-top:5px; text-decoration:underline;">I. ANAMNESA</td>
        </tr>
        <tr>
            <td>Keluhan Utama</td>
            <td>Riwayat Penyakit Sekarang</td>
            <td>Riwayat Penyakit Dahulu</td>
            <td></td>
        </tr>
        <tr>
            <td><textarea id="txtKU" name="txtKU" cols="35"></textarea></td>
            <td><textarea id="txtRPS" name="txtRPS" cols="35"></textarea></td>
            <td><textarea id="txtRPD" name="txtRPD" cols="35"></textarea></td>
            <td></td>
        </tr>
        <tr>
            <td style="padding-top:5px;">Riwayat Penyakit Keluarga</td>
            <td style="padding-top:5px;">Anamnese Sosial</td>
            <td style="padding-top:5px;">&nbsp;</td>
            <td style="padding-top:5px;"></td>
        </tr>
        <tr>
            <td><textarea id="txtRPK" name="txtRPK" cols="35"></textarea></td>
            <td><textarea id="txtAS" name="txtAS" cols="35"></textarea></td>
            <td>&nbsp;</td>
            <td></td>
        </tr>
        <td>
            <td colspan="4" style="padding-bottom:5px;"></td>
        </td>
        <tr>
            <td colspan="4" style="border-top:1px solid black; padding-top:5px; text-decoration:underline;">II. PEMERIKSAAN FISIK</td>
        </tr>
        <tr>
            <td colspan="4">
                <table width="100%">
                    <tr>
                        <td width="45%">
                            <table width="100%">
                                <tr>
                                    <td>Keadaan Umum</td>
                                    <td>:&nbsp;<input type="text" id="txtKUM" name="txtKUM" /></td>
                                    <td>GCS</td>
                                    <td>:&nbsp;<input type="text" id="txtGCS" name="txtGCS" /></td>
                                </tr>
                                <tr>
                                    <td>Kesadaran</td>
                                    <td>:&nbsp;
                                        <select id="cmbKesadaran" name="cmbKesadaran">
                                            <?php
                                                $sKesadaran="select * from anamnese_pilih where tipe='Kesadaran'";
                                                $qKesadaran=mysql_query($sKesadaran);
                                                while($rwKes=mysql_fetch_array($qKesadaran)){
                                            ?>
                                                <option value="<?php echo $rwKes['nama']; ?>"><?php echo $rwKes['nama']; ?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </td>
                                    <td>Status Gizi</td>
                                    <td>:&nbsp;
                                        <select id="cmbStatusGizi" name="cmbStatusGizi">
                                            <?php
                                                $sGizi="select * from anamnese_pilih where tipe='Gizi'";
                                                $qGizi=mysql_query($sGizi);
                                                while($rwGizi=mysql_fetch_array($qGizi)){
                                            ?>
                                                <option value="<?php echo $rwGizi['nama']; ?>"><?php echo $rwGizi['nama']; ?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <table width="100%">
                                            <tr>
                                                <td width="35">Tensi</td>
                                                <td width="55" align="center"><input type="text" size="5" id="txtTensi" name="txtTensi" /></td>
                                                <td width="55">mmHg</td>
                                                <td width="100"></td>
                                                <td width="35">Nadi</td>
                                                <td width="55" align="center"><input type="text" size="5" id="txtNadi" name="txtNadi" /></td>
                                                <td width="55">/Mnt</td>
                                                <td width="100"></td>
                                                <td width="35">BB</td>
                                                <td width="55" align="center"><input type="text" size="5" id="txtBB" name="txtBB" /></td>
                                                <td width="55">Kg</td>
                                            </tr>
                                            <tr>
                                                <td width="35">RR</td>
                                                <td width="55" align="center"><input type="text" size="5" id="txtRR" name="txtRR" /></td>
                                                <td width="55">/Mnt</td>
                                                <td width="100"></td>
                                                <td width="35">Suhu</td>
                                                <td width="55" align="center"><input type="text" size="5" id="txtSuhu" name="txtSuhu" /></td>
                                                <td width="55">°C</td>
                                                <td width="100"></td>
                                                <td width="35"></td>
                                                <td width="55" align="center"></td>
                                                <td width="55"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td width="55%">
                            <table width="100%">
                                <tr>
                                    <td><a href="javascript:void(0)" onClick="detailPF('Kepala Leher','cmbKepalaLeher')" title="Klik untuk merubah data">Kepala Leher</a></td>
                                    <td>:&nbsp;
                                        <select id="cmbKepalaLeher" name="cmbKepalaLeher" multiple="multiple">
                                            <?php
                                                $s="select * from anamnese_pilih where tipe='Kepala Leher'";
                                                $q=mysql_query($s);
                                                while($rws=mysql_fetch_array($q)){
                                            ?>
                                                <option value="<?php echo $rws['nama']; ?>"><?php echo $rws['nama']; ?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </td>
                                    <td><a href="javascript:void(0)" onClick="detailPF('COR','cmbCor')" title="Klik untuk merubah data">Cor</a></td>
                                    <td>:&nbsp;
                                        <select id="cmbCor" name="cmbCor" multiple="multiple">
                                            <?php
                                                $s="select * from anamnese_pilih where tipe='COR'";
                                                $q=mysql_query($s);
                                                while($rws=mysql_fetch_array($q)){
                                            ?>
                                                <option value="<?php echo $rws['nama']; ?>"><?php echo $rws['nama']; ?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><a href="javascript:void(0)" onClick="detailPF('PULMO','cmbPulmo')" title="Klik untuk merubah data">Pulmo</a></td>
                                    <td>:&nbsp;
                                        <select id="cmbPulmo" name="cmbPulmo" multiple="multiple">
                                            <?php
                                                $s="select * from anamnese_pilih where tipe='PULMO'";
                                                $q=mysql_query($s);
                                                while($rws=mysql_fetch_array($q)){
                                            ?>
                                                <option value="<?php echo $rws['nama']; ?>"><?php echo $rws['nama']; ?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </td>
                                    <td><a href="javascript:void(0)" onClick="detailPF('Inspeksi','cmbInspeksi')" title="Klik untuk merubah data">Inspeksi</a></td>
                                    <td>:&nbsp;
                                        <select id="cmbInspeksi" name="cmbInspeksi" multiple="multiple">
                                        <?php
                                            $s="select * from anamnese_pilih where tipe='Inspeksi'";
                                            $q=mysql_query($s);
                                            while($rws=mysql_fetch_array($q)){
                                        ?>
                                            <option value="<?php echo $rws['nama']; ?>"><?php echo $rws['nama']; ?></option>
                                        <?php
                                            }
                                        ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><a href="javascript:void(0)" onClick="detailPF('Auskultasi','cmbAuskultasi')" title="Klik untuk merubah data">Auskultasi</a></td>
                                    <td>:&nbsp;
                                        <select id="cmbAuskultasi" name="cmbAuskultasi" multiple="multiple">
                                        <?php
                                            $s="select * from anamnese_pilih where tipe='Auskultasi'";
                                            $q=mysql_query($s);
                                            while($rws=mysql_fetch_array($q)){
                                        ?>
                                            <option value="<?php echo $rws['nama']; ?>"><?php echo $rws['nama']; ?></option>
                                        <?php
                                            }
                                        ?>
                                        </select>
                                    </td>
                                    <td><a href="javascript:void(0)" onClick="detailPF('Palpasi','cmbPalpasi')" title="Klik untuk merubah data">Palpasi</a></td>
                                    <td>:&nbsp;
                                        <select id="cmbPalpasi" name="cmbPalpasi" multiple="multiple">
                                        <?php
                                            $s="select * from anamnese_pilih where tipe='Palpasi'";
                                            $q=mysql_query($s);
                                            while($rws=mysql_fetch_array($q)){
                                        ?>
                                            <option value="<?php echo $rws['nama']; ?>"><?php echo $rws['nama']; ?></option>
                                        <?php
                                            }
                                        ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><a href="javascript:void(0)" onClick="detailPF('Perkusi','cmbPerkusi')" title="Klik untuk merubah data">Perkusi</a></td>
                                    <td>:&nbsp;
                                        <select id="cmbPerkusi" name="cmbPerkusi" multiple="multiple">
                                        <?php
                                            $s="select * from anamnese_pilih where tipe='Perkusi'";
                                            $q=mysql_query($s);
                                            while($rws=mysql_fetch_array($q)){
                                        ?>
                                            <option value="<?php echo $rws['nama']; ?>"><?php echo $rws['nama']; ?></option>
                                        <?php
                                            }
                                        ?>
                                        </select>
                                    </td>
                                    <td><a href="javascript:void(0)" onClick="detailPF('Ext','cmbEkstremitas')" title="Klik untuk merubah data">Ekstremitas</a></td>
                                    <td>:&nbsp;
                                        <select id="cmbEkstremitas" name="cmbEkstremitas" multiple="multiple">
                                        <?php
                                            $s="select * from anamnese_pilih where tipe='Ext'";
                                            $q=mysql_query($s);
                                            while($rws=mysql_fetch_array($q)){
                                        ?>
                                            <option value="<?php echo $rws['nama']; ?>"><?php echo $rws['nama']; ?></option>
                                        <?php
                                            }
                                        ?>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>							
        </tr>
        <tr>                        	
            <td colspan="4" align="center" style="padding-bottom:10px;">
                <input type="hidden" id="id_anamnesa" name="id_anamnesa" />
                <button type="button" id="btnSimpanAnamnesa" name="btnSimpanAnamnesa" value="tambah" onClick="saveAnamnesa(this.value)" style="cursor:pointer">
                    <img src="../icon/edit_add.png" height="16" width="16" style="position:absolute;" />
                    <span style="margin-left:20px;">Add</span>
                </button>
                <button type="button" id="btnDeleteAnamnesa" name="btnDeleteAnamnesa" onClick="deleteAnamnesa()" style="cursor:pointer">
                    <img src="../icon/del.gif" height="16" width="16" style="position:absolute;" />
                    <span style="margin-left:20px;">Delete</span>
                </button>
                <button type="button" id="btnBatalAnamnesa" name="btnBatalAnamnesa" onClick="batalAnamnesa()" style="cursor:pointer">
                    <img src="../icon/back.png" height="16" width="16" style="position:absolute;" />
                    <span style="margin-left:20px;">Cancel</span>
                </button>
            </td>
        </tr>
        <tr>
            <td colspan="4" align="center">
                <div id="gridboxAnamnesa" style="width:850px; height:150px; padding-bottom:20px; background-color:white;"></div>
                <div id="pagingAnamnesa" style="width:850px;"></div>
            </td>
        </tr>
    </table>
    </form>
</fieldset>

<script>


</script>