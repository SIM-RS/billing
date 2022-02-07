<?php
session_start();
include "../sesi.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
            <script language="JavaScript" src="../theme/js/dsgrid.js"></script>

            <!--dibawah ini diperlukan untuk menampilkan popup-->
            <link rel="stylesheet" type="text/css" href="../theme/popup.css" />
            <script type="text/javascript" src="../theme/prototype.js"></script>
            <script type="text/javascript" src="../theme/effects.js"></script>
            <script type="text/javascript" src="../theme/popup.js"></script>
            <!--diatas ini diperlukan untuk menampilkan popup-->

            <!-- untuk ajax-->
            <script type="text/javascript" src="../theme/js/ajax.js"></script>
            <!-- end untuk ajax-->

            <title>Laporan Pelaksana Layanan</title>
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
			include("../koneksi/konek.php");
            include("../header1.php");
            $date_now=gmdate('d-m-Y',mktime(date('H')+7));
            $date_skr=explode('-',$date_now);
            ?>
            <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
                <tr>
                    <td height="30">&nbsp;LAPORAN PELAKSANA LAYANAN</td>
                </tr>
            </table>
            <table width="1000" border="0" cellspacing="0" cellpadding="0" class="txtinput" align="center">
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table width="750" align="center">
                            <tr>
                                <td>
                                    <fieldset>
                                        <legend>Kriteria Laporan</legend>
                                        <table width="500" align="center">
                                            <tr>
                                                <td colspan="2" align="center"><select id="cmbWaktu" name="cmbWaktu" class="txtinput" onchange="setBln(this.value)">
                                                        <option value=""></option>
                                                        <option value="Harian">Harian</option>
                                                        <option value="Bulanan">Bulanan</option>
                                                        <option value="Rentang Waktu">Rentang Waktu</option>
                                                    </select></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" align="center">
                                                    <div id="trBulan" style="display:none">
                                                        <select class="txtinput" id="cmbBln" name="cmbBln" onchange="bulanan()"><option></option></select>&nbsp;<select class="txtinput" id="cmbThn" name="cmbThn" onchange="bulanan()"><option></option></select>
                                                    </div></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" align="center">
                                                    <div id="trPeriode" style="display:none">
					Periode : <input size="10" value="<?php echo $date_now;?>" class="txtcenter" id="tglAwal" name="tglAwal" readonly="readonly"/>&nbsp;<input type="button" class="btninput" id="btnTglAwal" name="btnTgl" value=" V " onClick="gfPop.fPopCalendar(document.getElementById('tglAwal'),depRange);" />&nbsp;s.d.&nbsp;<input size="10" value="<?=$date_now;?>" class="txtcenter" id="tglAkhir" name="tglAkhir" />&nbsp;<input type="button" class="btninput" id="btnTglAkhir" name="btnTgl" value=" V " onClick="gfPop.fPopCalendar(document.getElementById('tglAkhir'),depRange);" />
                                                    </div></td>
                                            </tr>
                                            <tr>
                                                <td width="40%" align="right">Jenis Layanan</td>
                                                <td width="60%">&nbsp;<select name="JnsLayanan" id="JnsLayanan" tabindex="26" class="txtinput" onchange="isiCombo('TmpLayanan',this.value)"></select></td>
                                            </tr>
                                            <tr>
                                                <td width="40%" height="25" align="right">Tempat Layanan</td>
                                                <td width="60%">&nbsp;<select name="TmpLayanan" id="TmpLayanan" tabindex="27" class="txtinput"></select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="40%" align="right">Status Pasien</td>
                                                <td width="60%">&nbsp;<select name="StatusPas" id="StatusPas" tabindex="22" class="txtinput"></select></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Klasifikasi Tarif</td>
                                                <td>&nbsp;<select name="cmbKlasi" id="cmbKlasi" tabindex="26" class="txtinput" onchange="isiCombo('cmbKelTin',this.value)"></select></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Kelompok Layanan</td>
                                                <td>&nbsp;<select id="cmbKelTin" name="cmbKelTin" class="txtinput"><option></option></select></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Uraian Layanan</td>
                                                <td>&nbsp;<select id="cmbUrLay" name="cmbUrLay" class="txtinput"><option></option></select></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Komponen</td>
                                                <td>&nbsp;<select id="cmbKom" name="cmbKom" class="txtinput"><option</option></select></td>
                                            </tr>
                                        </table>
                                    </fieldset>		</td>
                            </tr>
                        </table>	</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><input value="&nbsp;&nbsp;&nbsp;Laporan&nbsp;&nbsp;&nbsp;" type="button" onclick="getLap()"/></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
            <table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
                <tr height="30">
                    <td>&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" /></td>
                    <td align="right"><a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" /></a>&nbsp;</td>
                </tr>
            </table>
        </div>
        <div id="div_laporan" style="display:none;width:500px; height:400px" class="popup">
            <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" />
            <fieldset>
                <legend>Laporan Pelaksana Layanan</legend>
                <table align="center" border="0">
                    <tr>
                        <td><a href="" target="_blank">Pendapatan Berdasarkan Klasifikasi Layanan</a></td>
                    </tr>
                    <tr>
                        <td><a href="" target="_blank">Distribusi Pendapatan Berdasarkan Uraian Layanan</a></td>
                    </tr>
                    <tr>
                        <td><a href="" target="_blank">Distribusi Penerimaan</a></td>
                    </tr>
                    <tr>
                        <td style="border-top:2px solid;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><a href="" target="_blank">Distribusi Pendapatan Berdasarkan Uraian Layanan</a></td>
                    </tr>
                    <tr>
                        <td><a href="" target="_blank">Distribusi Penerimaan</a></td>
                    </tr>
                    <tr>
                        <td><a href="" target="_blank">Distribusi Penerimaan Berdasarkan Uraian Layanan</a></td>
                    </tr>
                    <tr>
                        <td><a href="" target="_blank">Rekapitulasi Distribusi Penerimaan</a></td>
                    </tr>
                    <tr>
                        <td><a href="" target="_blank">Distribusi Klaim Jaminan Berdasarkan Uraian Layanan</a></td>
                    </tr>
                    <tr>
                        <td style="border-top:2px solid;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><a href="" target="_blank">Distribusi Pendapatan Berdasarkan Kelompok Layanan</a></td>
                    </tr>
                    <tr>
                        <td><a href="" target="_blank">Distribusi Penerimaan Berdasarkan Kelompok Layanan</a></td>
                    </tr>
                    <tr>
                        <td><a href="" target="_blank">Distribusi Klaim Jaminan Berdasarkan Kelompok Layanan</a></td>
                    </tr>
                    <tr>
                        <td style="border-top:2px solid;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><a href="" target="_blank">Distribusi Pendapatan Berdasarkan Klasifikasi Layanan</a></td>
                    </tr>
                    <tr>
                        <td><a href="" target="_blank">Distribusi Penerimaan Berdasarkan Klasifikasi Layanan</a></td>
                    </tr>
                    <tr>
                        <td><a href="" target="_blank">Distribusi Klaim Jaminan Berdasarkan Klasifikasi Layanan</a></td>
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
        isiCombo('StatusPas');
        isiCombo('cmbKlasi','','','',showKlasi);
        function showKlasi(){
            isiCombo('cmbKelTin',document.getElementById('cmbKlasi').value);
        }
        isiCombo('cmbKom');

        function isiCombo(id,val,defaultId,targetId,evloaded)
        {
            if(targetId=='' || targetId==undefined)
            {
                targetId=id;
            }
            Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,id,'','GET',evloaded);
        }

        function setBln(val)
        {
            if(val=='Harian')
            {
                document.getElementById('trBulan').style.display = "none";
                document.getElementById('trPeriode').style.display = "none";
                document.getElementById('tglAwal').value = '<?=$date_now?>';
                document.getElementById('tglAkhir').value = '<?=$date_now?>';
            }
            else if(val=='Bulanan')
            {
                document.getElementById('trBulan').style.display = "block";
                document.getElementById('trPeriode').style.display = "none";
                document.getElementById('cmbBln').innerHTML =
                    '<option value="01">Januari</option>'+
                    '<option value="02">Februari</option>'+
                    '<option value="03">Maret</option>'+
                    '<option value="04">April</option>'+
                    '<option value="05">Mei</option>'+
                    '<option value="06">Juni</option>'+
                    '<option value="07">Juli</option>'+
                    '<option value="08">Agustus</option>'+
                    '<option value="09">September</option>'+
                    '<option value="10">Oktober</option>'+
                    '<option value="11">Nopember</option>'+
                    '<option value="12">Desember</option>';
                var thSkr='<?php echo $date_skr[2];?>';
                var thAwal=thSkr*1-5;
                var thAkhir=thSkr*1+6;
                for(thAwal;thAwal<thAkhir;thAwal++)
                {
                    document.getElementById('cmbThn').innerHTML =
                        document.getElementById('cmbThn').innerHTML+'<option>'+thAwal+'</option>';
                }
            }
            else if(val=='Rentang Waktu')
            {
                document.getElementById('trPeriode').style.display = "block";
                document.getElementById('trBulan').style.display = "none";
            }
            else
            {
                document.getElementById('trPeriode').style.display = "none";
                document.getElementById('trBulan').style.display = "none";
            }
        }

        function bulanan()
        {
            var bulan = document.getElementById("cmbBln").value;
            var tahun = document.getElementById("cmbThn").value;
            var akhir;
            document.getElementById("tglAwal").value = '01-'+bulan+'-'+tahun;
            if(bulan == 2)
            {
                if((tahun%4 == 0) && (tahun%100 != 0))
                {
                    akhir = 29;
                }
                else
                {
                    akhir = 28;
                }
            }
            else if(bulan<=7)
            {
                if(bulan%2 == 0)
                {
                    akhir = 30;
                }
                else
                {
                    akhir = 31;
                }
            }
            else if(bulan>7)
            {
                if(bulan%2 == 0)
                {
                    akhir = 31;
                }
                else
                {
                    akhir = 30;
                }
            }
            document.getElementById("tglAkhir").value = akhir+'-'+bulan+'-'+tahun;
        }

        function getLap()
        {
            new Popup('div_laporan',null,{modal:true,position:'center',duration:1});
            document.getElementById('div_laporan').popup.show();
        }

    </script>
</html>
<?php 
mysql_close($konek);
?>