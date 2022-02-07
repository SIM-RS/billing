<?php
session_start();
include "../sesi.php";
$userId = $_SESSION['userId'];
include("../koneksi/konek.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Laporan Kasir</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/dsgrid.js"></script>

        <!--dibawah ini diperlukan untuk menampilkan popup-->
        <link rel="stylesheet" type="text/css" href="../theme/popup.css" />
        <script type="text/javascript" src="../theme/prototype.js"></script>
        <script type="text/javascript" src="../theme/effects.js"></script>
        <script type="text/javascript" src="../theme/popup.js"></script>
        <!--diatas ini diperlukan untuk menampilkan popup-->

        <!-- untuk ajax-->
        <script type="text/javascript" src="../theme/js/ajax.js"></script>
        <!-- end untuk ajax-->

    </head>

    <body>
        <script type="text/JavaScript">
            var arrRange=depRange=[];
        </script>
        <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js"
                src="../theme/popcjs.php" scrolling="no"
                frameborder="1"
                style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
        </iframe>
        <div align="center">
            <?php
            include("../header1.php");
            $date_now=gmdate('d-m-Y',mktime(date('H')+7));
            ?>
            <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
                <tr>
                    <td height="30">&nbsp;LAPORAN KASIR</td>
                </tr>
            </table>
            <table width="1000" border="0" cellspacing="0" cellpadding="0" class="tabel" align="center">
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        <table width="750" align="center">
                            <tr>
                                <td>
                                    <fieldset>
                                        <legend>Kriteria Laporan</legend>
                                        <table width="500" align="center">
                                            <tr>
                                                <td align="center" colspan="2"><input size="10" value="<?php echo $date_now;?>" class="txtcenter" id="tglAwal" name="tglAwal" readonly="readonly"/>&nbsp;<input type="button" class="btninput" id="btnTglAwal" name="btnTgl" value=" V " onClick="gfPop.fPopCalendar(document.getElementById('tglAwal'),depRange);" />&nbsp;s.d.&nbsp;<input size="10" value="<?=$date_now;?>" class="txtcenter" id="tglAkhir" name="tglAkhir" />&nbsp;<input type="button" class="btninput" id="btnTglAkhir" name="btnTgl" value=" V " onClick="gfPop.fPopCalendar(document.getElementById('tglAkhir'),depRange);" /></td>
                                            </tr>
                                            <tr>
                                                <td align="right" width="50%">Jenis Layanan</td>
                                                <td>&nbsp;<select name="JnsLayanan" id="JnsLayanan" tabindex="26" class="txtinput" onchange="isiCombo('TmpLayanan',this.value)"></select></td>
                                            </tr>
                                            <tr>
                                                <td align="right" width="50%">Tempat Layanan</td>
                                                <td>&nbsp;<select name="TmpLayanan" id="TmpLayanan" tabindex="27" class="txtinput"></select></td>
                                            </tr>
                                            <tr>
                                                <td align="right" width="50%">Kasir</td>
                                                <td>&nbsp;<select id="cmbKasir" name="cmbKasir" class="txtinput"></select></td>
                                            </tr>
                                        </table>
                                    </fieldset>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td align="center"><input value="&nbsp;&nbsp;&nbsp;Laporan&nbsp;&nbsp;&nbsp;" type="button"  onclick="getLap()"/></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table>
            <table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
                <tr height="30">
                    <td align="right"><a href="../index.php"><input value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" type="button" class="btninput"/></a>&nbsp;</td>
                </tr>
            </table>
        </div>
        <div id="div_laporan" style="display:none;width:450px; height:250px" class="popup">
            <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" />
            <fieldset>
                <legend>Laporan Kasir</legend>
                <table align="center" border="0">
                    <tr>
                        <td onclick="kasir1()" style="cursor:pointer;">Penerimaan Pasien</td>
                    </tr>
                    <tr>
                        <td onclick="kasir2()" style="cursor:pointer;">Rekapitulasi Penerimaan Berdasarkan Nama Kasir</td>
                    </tr>
                    <tr>
                        <td style="border-top:2px solid;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><a href="" target="_blank">Penerimaan IGD Berdasarkan Pasien Pulang</a></td>
                    </tr>
                    <tr>
                        <td><a href="" target="_blank">Penerimaan Non Inap Berdasarkan Pasien Pulang</a></td>
                    </tr>
                    <tr>
                        <td><a href="" target="_blank">Penerimaan Inap Berdadarkan Pasien Pulang</a></td>
                    </tr>
                    <tr>
                        <td><a href="" target="_blank">Penerimaan Iur Bayar</a></td>
                    </tr>
                    <tr>
                        <td style="border-top:2px solid;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><a href="" target="_blank">Blanko Kelengkapan Berkas</a></td>
                    </tr>
                    <tr>
                        <td><a href="" target="_blank">Penerimaan Pasien Pulang Per Klasifikasi Layanan</a></td>
                    </tr>
                </table>
            </fieldset>
        </div>
    </body>
    <script type="text/JavaScript">
        isiCombo('JnsLayanan','','','',showTmpLay);
        function showTmpLay(){
            isiCombo('TmpLayanan',document.getElementById('JnsLayanan').value);
        }
        isiCombo('cmbKasir');

        function isiCombo(id,val,defaultId,targetId,evloaded)
        {
            if(targetId=='' || targetId==undefined)
            {
                targetId=id;
            }
            Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,id,'','GET',evloaded);
        }

        function getLap()
        {
            new Popup('div_laporan',null,{modal:true,position:'center',duration:1});
            document.getElementById('div_laporan').popup.show();
        }

        function kasir1()
        {
            var JnsLayanan = document.getElementById("JnsLayanan").value;
            var TmpLayanan = document.getElementById("TmpLayanan").value;
            var kasir = document.getElementById("cmbKasir").value;
            var tglAwal = document.getElementById("tglAwal").value;
            var tglAkhir = document.getElementById("tglAkhir").value;
            window.open('kasir/PenerimaanPasien.php?jnsLay='+JnsLayanan+'&tmptLay='+TmpLayanan+'&kasir='+kasir+'&tglAwal='+tglAwal+'&tglAkhir='+tglAkhir,'_blank');
        }

        function kasir2()
        {
            var JnsLayanan = document.getElementById("JnsLayanan").value;
            var TmpLayanan = document.getElementById("TmpLayanan").value;
            var kasir = document.getElementById("cmbKasir").value;
            var tglAwal = document.getElementById("tglAwal").value;
            var tglAkhir = document.getElementById("tglAkhir").value;
            window.open('kasir/RekapPenerimaanNamaKasir.php?jnsLay='+JnsLayanan+'&tmptLay='+TmpLayanan+'&kasir='+kasir+'&tglAwal='+tglAwal+'&tglAkhir='+tglAkhir,'_blank');
        }

    </script>
</html>
<?php 
mysql_close($konek);
?>