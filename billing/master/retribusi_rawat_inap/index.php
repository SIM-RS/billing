<?php
session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
$user_id = $_SESSION['userId'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link type="text/css" rel="stylesheet" href="../../theme/mod.css">
    <script language="JavaScript" src="../../theme/js/dsgrid.js"></script>
    <script language="JavaScript" src="../../theme/js/mod.js"></script>
    <link rel="stylesheet" type="text/css" href="../../theme/tab-view.css" />
    <script type="text/javascript" src="../../theme/js/tab-view.js"></script>
    <script type="text/javascript" src="../../theme/js/ajax.js"></script>
    <script type="text/javascript" src="../../include/jquery/jquery-1.9.1.js"></script>

    <!--dibawah ini diperlukan untuk menampilkan popup-->
    <link rel="stylesheet" type="text/css" href="../../theme/popup.css" />
    <script type="text/javascript" src="../../theme/prototype.js"></script>
    <script type="text/javascript" src="../../theme/effects.js"></script>
    <script type="text/javascript" src="../../theme/popup.js"></script>
    <link rel="stylesheet" type="text/css" href="../../theme/bs/bootstrap.min.css">
    <script type="text/javascript" src="../../theme/bs/bootstrap.min.js"></script>
</head>

<body>
    <div align="center">
        <?php include("../../header1.php"); ?>
        <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
            <tr>
                <td height="30">&nbsp;TARIF RETRIBUSI ADMIN RAWAT INAP</td>
            </tr>
        </table>
        <table width="1000" border="0" cellspacing="0" cellpadding="0" align="center" class="tabel">
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td align="center">
                    <div style="width: 90%;margin-top:10px;padding: 10px;" id="kelompokMcu">
                        <form id="formKelompokMcu">
                            <table>
                                <tr>
                                    <td>Tipe Retribusi</td>
                                    <td>
                                        <select name="tipe_retribusi" id="tipe_retribusi">
                                            <option value="1">Tarif Umum</option>
                                            <option value="2">Tarif BPJS KESEHATAN</option>
                                            <option value="3">Tarif Manual Pelindo</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Jenis</td>
                                    <td>
                                        <select name="select" class="txtinput" id="cmbJnsLayKelMcu" onchange="panggilTmpLayanan()">
                                            <?php
                                            $sql = "SELECT distinct m.id,m.nama,m.inap FROM b_ms_unit m WHERE level=1 AND kategori=2 AND aktif=1 order by nama";
                                            $rs = mysql_query($sql);
                                            while ($rw = mysql_fetch_array($rs)) {
                                                ?>
                                                <option value="<?php echo $rw['id']; ?>" label="<?php /*echo $rw['inap'];*/ ?>" title="<?php echo $rw['id']; ?>">
                                                    <?php echo $rw['nama']; ?>
                                                </option>

                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Tempat
                                    </td>
                                    <td>
                                        <select id="cmbUnit" class="txtinput" lang=""></select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Tarif
                                    </td>
                                    <td>
                                        <input type="text" name="tarif" id="tarif">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="aktif" id="aktif"> aktif
                                        <input type="hidden" name="id_retribusi_rawat_inap" id="id_retribusi_rawat_inap">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <button type="button" name="simpan" id="simpan" value="tambah" onclick="saveData(this,this.value)">Tambah</button>
                                        <button type="button" name="delete" onclick="deleteData()" id="delete" disabled>Hapus</button>
                                        <button type="reset">Batal</button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <div id="gridbox" style="height: 300px;"></div>
                    <div id="paging"></div>
                </td>
            </tr>
        </table>
    </div>
    <script>
        rri = new DSGridObject("gridbox");
        rri.setHeader("DATA RETRIBUSI");
        rri.setColHeader("NO,TIPE,TEMPAT LAYANAN,TARIF,STATUS");
        rri.setIDColHeader(",,,,");
        rri.setColWidth("20,150,80,100,20");
        rri.setCellAlign("center,left,center,right,center");
        rri.setCellHeight(20);
        rri.setImgPath("../../icon");
        rri.setIDPaging("paging");
        rri.attachEvent("onRowClick", "ambilTindakan");
        rri.baseURL("utils.php?grd=getData");
        rri.Init();

        function ambilTindakan() {
            let id = rri.getRowId(rri.getSelRow()).split("|");
            jQuery('#id_retribusi_rawat_inap').val(id[0]);
            jQuery('#delete').attr('disabled',false);
        }

        function deleteData() {
            let id = jQuery('#id_retribusi_rawat_inap').val();
            if(confirm('Yakin ingin menghapus data ini ?')){
                jQuery.ajax({
                    url: 'utils.php',
                    method: 'post',
                    data: {
                        id: id,
                        act : 'delete'
                    },
                    success: function(data) {
                        rri.baseURL("utils.php?grd=getData");
                        rri.Init();
                        jQuery('#delete').attr('disabled',true);
                    }
                });
            }
        }

        function saveData(elm, val) {
            jQuery('#' + elm.id).attr('disabled', true);
            let id = jQuery('#id_retribusi_rawat_inap').val();
            let tipeRetribusi = jQuery('#tipe_retribusi').val();
            let idTempatLayanan = jQuery('#cmbUnit').val();
            let tarif = jQuery('#tarif').val();
            let active = document.getElementById('aktif').checked ? 1 : 0;
            jQuery.ajax({
                url: 'utils.php',
                method: 'post',
                data: {
                    id: id,
                    tipe: tipeRetribusi,
                    idTempatLayanan: idTempatLayanan,
                    tarif: tarif,
                    active: active,
                    userAct: <?= $user_id ?>,
                    act: val
                },
                success: function(data) {
                    rri.baseURL("utils.php?grd=getData");
                    rri.Init();
                    jQuery('#' + elm.id).attr('disabled', false);
                }
            });
        }

        function isiCombo(id, val, defaultId, targetId) {
            if (targetId == '' || targetId == undefined) {
                targetId = id;
            }
            Request('../../combo_utils.php?id=' + id + '&value=' + val + '&defaultId=' + defaultId, targetId, '', 'GET');
        }

        function panggilTmpLayanan() {
            isiCombo('TmpLayanan', document.getElementById('cmbJnsLayKelMcu').value, '', 'cmbUnit')
        }
        panggilTmpLayanan();
    </script>
</body>

</html>