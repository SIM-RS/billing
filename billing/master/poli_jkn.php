<?php
session_start();
include("../sesi.php");

include_once "../../api/koneksi.php";

$koneksi = new Koneksi;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link type="text/css" rel="stylesheet" href="../theme/mod.css">
    <script language="JavaScript" src="../theme/js/mod.js"></script>
    <script language="JavaScript" src="../theme/js/dsgrid.js"></script>
    <script type="text/JavaScript" language="JavaScript" src="../include/jquery/jquery-1.9.1.js"></script>
    <title>Set Poli JKN</title>
</head>

<body>
    <div align="center">
        <?php
        include("../koneksi/konek.php");
        include("../header1.php");

        $queryTempatPelayanan = mysqli_query($koneksi->koneksi, "SELECT id, nama, parent_id FROM rspelindo_billing.b_ms_unit WHERE parent_id IN(1, 57, 60)");
        ?>
        <script>
            var arrRange = depRange = [];

            /**
             * SIMPAN SETIAP TEMPAT PELAYANAN
             */
            var tempatPelayanan = <?= json_encode(mysqli_fetch_all($queryTempatPelayanan)); ?>;
        </script>
        <iframe height="72" width="130" name="sort" id="sort" src="../theme/dsgrid_sort.php" scrolling="no" frameborder="0" style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
        </iframe>
        <iframe height="193" width="168" name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../theme/popcjs.php" scrolling="no" frameborder="0" style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
        </iframe>
        <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
            <tr>
                <td height="30">&nbsp;FORM MASTER BRIDGING POLI JKN</td>
            </tr>
        </table>
        <table width="1000" border="0" cellpadding="0" cellspacing="0" class="tabel" align="center">
            <tr>
                <td height="18" colspan="4">&nbsp;</td>
            </tr>
            <tr>
                <td width="5%">
                <td width="15%">&nbsp;</td>
                <td width="75%">&nbsp;</td>
                <td width="5%">&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="2">
                    <div id="div_mcu" style="display:block">
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                            <tr height="30">
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td width="45%" valign="top">
                                                <form method="post">
                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                        <tr valign="top">
                                                            <td width="30%">Nama Poli JKN</td>
                                                            <td width="10%" align="center">:</td>
                                                            <td width="60%"><input size="32" id="namapoli" name="namapoli" class="txtinput" readonly /></td>
                                                        </tr>
                                                        <tr valign="top">
                                                            <td width="30%">Jenis Layanan RS</td>
                                                            <td width="10%" align="center">:</td>
                                                            <td width="60%">
                                                                <select name="jenis_layanan" id="jenis_layanan" class="txtinputreg">
                                                                    <?php $query = mysqli_query($koneksi->koneksi, "SELECT id, nama FROM rspelindo_billing.b_ms_unit WHERE parent_id = 0 AND kode IN (01, 05, 06)");
                                                                    while ($row = mysqli_fetch_assoc($query)) : ?>
                                                                        <option value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
                                                                    <?php endwhile; ?>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr valign="top">
                                                            <td width="30%">Tempat Pelayanan</td>
                                                            <td width="10%" align="center">:</td>
                                                            <td width="60%">
                                                                <select name="rspoli" id="rspoli" class="txtinputreg">
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr valign="top">
                                                            <td width="30%">Estimasi kunjungan per Pasien (menit)</td>
                                                            <td width="10%" align="center">:</td>
                                                            <td width="60%"><input size="32" id="estimasi" name="estimasi" class="txtinput" /></td>
                                                        </tr>
                                                        <tr valign="top">
                                                            <td width="30%">Keterangan Tindakan</td>
                                                            <td width="10%" align="center">:</td>
                                                            <td width="60%"><input size="32" id="tindakan" name="tindakan" class="txtinput" /></td>
                                                        </tr>
                                                        <tr valign="top">
                                                            <td width="30%">Termasuk Operasi</td>
                                                            <td width="10%" align="center">:</td>
                                                            <td width="60%">
                                                                <select name="is_operasi" id="is_operasi" class="txtinputreg">
                                                                    <option value="0">Tidak</option>
                                                                    <option value="1">Ya</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr valign="top">
                                                            <td width="30%">Lama Persiapan yang dibutuhkan (hari)</td>
                                                            <td width="10%" align="center">:</td>
                                                            <td width="60%"><input size="32" id="minim_hari" name="minim_hari" class="txtinput" /></td>
                                                        </tr>
                                                        <tr height="30">
                                                            <td>&nbsp;</td>
                                                            <td><input type="hidden" id="cmd" name="cmd" />
                                                                <input type="hidden" name="id" id="id" /></td>
                                                            <td>
                                                                <input type="button" id="btnSimpan" name="btnSimpan" value="Simpan" onclick="simpan(this.value,'rspoli');" class="tblTambah" disabled="disabled" />
                                                                <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus(this.title);" disabled="disabled" class="tblHapus" />
                                                                <input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal" />
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </form>
                                                </br></br>
                                                </br></br>
                                                </br></br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                            <div id="gridbox" style="width:100%; height:250px; background-color:white; overflow:hidden;"></div>
                                                <div id="paging" style="width:100%;"></div>

                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>

                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>

        </table>
        <table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000" align="center">
            <tr height="30">
                <td>&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" class="btninput" /></td>
                <td align="right"><a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" class="btninput" /></a>&nbsp;</td>
            </tr>
        </table>
    </div>

    <script>
        function getIdAndParentId(stringval){
            for(const val of tempatPelayanan){
                if(val[1] == stringval) {
                    $("#jenis_layanan").val(val[2]);
                    return val;
                }
            }
            return 0;
        }
        let id_induk = $("#jenis_layanan").val();
        tempatPelayanan.forEach(function (val, idx){
                if(val[2] == id_induk) $("#rspoli").append(`<option value="${val[0]}">${val[1]}</option>`);
            });

        $("#jenis_layanan").change(function(){
            $("#rspoli").empty();
            let id_induk = $("#jenis_layanan").val();
            tempatPelayanan.forEach(function (val, idx){
                    if(val[2] == id_induk) $("#rspoli").append(`<option value="${val[0]}">${val[1]}</option>`);
                });
        });

        function refreshTempatLayanan(stringval){
            let getId = getIdAndParentId(stringval);
            let id_rspoli = getId[0];
            let id_induk = getId[2];

            $('#rspoli').empty();

            // Compare dengan string
            tempatPelayanan.forEach(function (val, idx){
                if(val[2] == id_induk) $("#rspoli").append(`<option value="${val[0]}" ${val[0] == id_rspoli ? "selected" : ""}>${val[1]}</option>`);
            });

        }

        function simpan(action, cek) {
            var id = document.getElementById("id").value;
            var rspoli = document.getElementById("rspoli").value;
            var estimasi = document.getElementById("estimasi").value;
            var tindakan = document.getElementById("tindakan").value;
            var is_operasi = document.getElementById("is_operasi").value;
            var minim_hari = document.getElementById("minim_hari").value;

            if(rspoli == "" || estimasi == "" || tindakan == "") {
                alert("Lengkapi form terlebih dahulu.");
                return 0;
            }

            a.loadURL("poli_jkn_utils.php?grd=true&act=simpan&id=" + id + "&rspoli=" + rspoli + "&estimasi=" + estimasi + "&tindakan=" + tindakan + "&is_operasi=" + is_operasi + "&minim_hari=" + minim_hari, "", "GET");
            document.getElementById("id").value = '';
            document.getElementById("namapoli").value = '';
            document.getElementById("tindakan").value = '';
            batal();

        }

        function ambilData() {
            var p = "id*-*" + (a.getRowId(a.getSelRow())) + "*|*estimasi*-*" + a.cellsGetValue(a.getSelRow(), 5) + "*|*namapoli*-*" + a.cellsGetValue(a.getSelRow(), 3) + "*|*rspoli*-*" + a.cellsGetValue(a.getSelRow(), 4) + "*|*tindakan*-*" + a.cellsGetValue(a.getSelRow(), 6) + "*|*is_operasi*-*" + (a.cellsGetValue(a.getSelRow(), 7) == "Ya" ? "1" : "0") + "*|*minim_hari*-*" + a.cellsGetValue(a.getSelRow(), 8) + "*|*btnSimpan*-*Simpan*|*btnSimpan*-*false*|*btnHapus*-*false";
            
            if(a.cellsGetValue(a.getSelRow(), 4) != ""){
                refreshTempatLayanan(a.cellsGetValue(a.getSelRow(), 4));
            }

            fSetValue(window, p);
        }

        function hapus() {
            var id = document.getElementById("id").value;
            if (confirm("Anda yakin menghapus setup poli " + a.cellsGetValue(a.getSelRow(), 3))) {
                a.loadURL("poli_jkn_utils.php?grd=true&act=hapus&id=" + id, "", "GET");
            }
            batal();
        }

        function batal() {
            var p = "id*-**|*kodepoli*-**|*namapoli*-**|*nama*-**|*estimasi*-**|*tindakan*-**|*is_operasi*-**|*minim_hari*-**|*btnSimpan*-*true*|*btnHapus*-*true";
            fSetValue(window, p);
        }

        jQuery(function() {
            jQuery("#estimasi").keydown(function(e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if (jQuery.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                    // Allow: Ctrl+A
                    (e.keyCode == 65 && e.ctrlKey === true) ||
                    // Allow: home, end, left, right
                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                    // let it happen, don't do anything
                    return;
                } else {
                    // Ensure that it is a number and stop the keypress
                    if (e.shiftKey || (e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                }
            });
            jQuery("#minim_hari").keydown(function(e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if (jQuery.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                    // Allow: Ctrl+A
                    (e.keyCode == 65 && e.ctrlKey === true) ||
                    // Allow: home, end, left, right
                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                    // let it happen, don't do anything
                    return;
                } else {
                    // Ensure that it is a number and stop the keypress
                    if (e.shiftKey || (e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                }
            });
        });

        function goFilterAndSort(grd) {
            //alert(grd);		
            switch (grd) {
                case 'gridbox':
                    a.loadURL("poli_jkn_utils.php?grd=true&filter=" + a.getFilter() + "&sorting=" + a.getSorting() + "&page=" + a.getPage(), "", "GET");
                    break;
            }
        }
        var a = new DSGridObject("gridbox");
        a.setHeader("POLI JKN KE POLI RS");
        a.setColHeader("NO,KODE POLI JKN,NAMA POLI JKN,TEMPAT PELAYANAN,Estimasi,Ket. Tindakan,Is Operasi,Min. Persiapan");
        a.setIDColHeader(",kodepoli,namapoli,nama,estimasi,tindakan,is_operasi,minim_hari");
        a.setColWidth("40,,,,,,40,50");
        a.setCellAlign("center,left,center");
        a.setCellHeight(20);
        a.setImgPath("../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick", "ambilData");
        a.baseURL("poli_jkn_utils.php?grd=true");
        a.Init();
    </script>
</body>

</html>