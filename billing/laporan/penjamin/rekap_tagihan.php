<?php
session_start();
include("../../sesi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="../../theme/mod.css" />
        <script type="text/JavaScript" language="JavaScript" src="../../theme/js/dsgrid.js"></script>

        <!--dibawah ini diperlukan untuk menampilkan popup-->
        <link rel="stylesheet" type="text/css" href="../../theme/popup.css" />
        <script type="text/javascript" src="../../theme/prototype.js"></script>
        <script type="text/javascript" src="../../theme/effects.js"></script>
        <script type="text/javascript" src="../../theme/popup.js"></script>
        <!--diatas ini diperlukan untuk menampilkan popup-->

        <!-- untuk ajax-->
        <script type="text/javascript" src="../../theme/js/ajax.js"></script>
        <!-- end untuk ajax-->

        <title>Laporan Penjamin</title>
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
			include("../../koneksi/konek.php");
            include("../../header1.php");
            $date_now=gmdate('d-m-Y',mktime(date('H')+7));
            $date_skr=explode('-',$date_now);
            ?>
            <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
                <tr>
                    <td height="30">&nbsp;LAPORAN PENJAMIN</td>
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
                                                <td width="40%" align="right">Penjamin</td>
                                                <td width="60%">&nbsp;<select name="StatusPas" id="StatusPas" tabindex="22" class="txtinput"><option value="0">Semua</option></select></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" align="center"><select id="cmbWaktu" name="cmbWaktu" class="txtinput" onchange="setBln(this.value)">
                                                        <option></option>
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
                    <td colspan="2" align="center"><input value="&nbsp;&nbsp;&nbsp;Laporan&nbsp;&nbsp;&nbsp;" type="button" onclick="getLap()" /></td>
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
                    <td align="right"><a href="../../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" /></a>&nbsp;</td>
                </tr>
            </table>
        </div>
        <!--div id="div_laporan" style="display:none;width:800px; height:400px" class="popup">
                <img src="../icon/x.png" width="32" class="popup_closebox" style="float:right;">
	<fieldset>
		<legend>Laporan Penjamin</legend>
                        <table border="0" width="775px" align="center">
                                <tr>
                                        <td width="50%"><a href="" target="_blank">Blangko Kelengkapan Berkas Klaim</a></td>
                                        <td width="50%"><a href="" target="_blank">Kunjungan Pasien Penjamin</a></td>
			</tr>
                                <tr>
                                        <td colspan="2"><a href="" target="_blank">Form Verifikasi & Kendali Pelayanan Pasien JAMKESMAS</a></td>
			</tr>
                                <tr>
                                        <td><a href="" target="_blank">Klaim Jaminan Inap</a></td>
                                        <td><a href="" target="_blank">Klaim Jaminan Non Inap</a></td>
			</tr>
                                <tr>
                                        <td><a href="" target="_blank">Klaim Jaminan Konsul/Penunjang Medik</a></td>
                                        <td><a href="" target="_blank">Klaim Jaminan Medik Operatif</a></td>
			</tr>
                                <tr>
                                        <td><a href="" target="_blank">Klaim Jaminan Medik Non Operatif</a></td>
                                        <td><a href="" target="_blank">Distribusi Klaim Jaminan Berdasarkan Pasien</a></td>
			</tr>
                                <tr>
                                        <td colspan="2"><a href="" target="_blank">Distribusi Klaim Jaminan Berdasarkan Tempat Layanan</a></td>
			</tr>
                                <tr>
                                        <td><a href="" target="_blank">Klaim Jaminan Berdasarkan Kelas Layanan</a></td>
                                        <td><a href="" target="_blank">Pendapatan Berdasarkan Tanggal</a></td>
			</tr>
                                <tr>
                                        <td><a href="" target="_blank">Penerimaan Berdasarkan Tanggal</a></td>
                                        <td><a href="" target="_blank">Klaim Jaminan Berdasarkan Tanggal</a></td>
			</tr>
                                <tr>
                                        <td><a href="" target="_blank">Pendapatan Berdasarkan Klasifikasi Layanan</a></td>
                                        <td><a href="" target="_blank">Penerimaan Berdasarkan Klasifikasi Layanan</a></td>
			</tr>
                                <tr>
                                        <td colspan="2"><a href="" target="_blank">Klaim Jaminan Berdasarkan Klasifikasi Layanan</a></td>
			</tr>
                                <tr>
                                        <td><a href="" target="_blank">Distribusi Jasa Pelaksana Layanan</a></td>
                                        <td><a href="" target="_blank">Perda Pasien Inap (Pasien Pulang)</a></td>
			</tr>
                                <tr>
                                        <td><a href="" target="_blank">Perda Pasien Non Inap (Pasien Pulang)</a></td>
                                        <td><a href="" target="_blank">Perda Konsul/Penunjang Medik (Pasien Pulang)</a></td>
			</tr>
                                <tr>
                                        <td><a href="" target="_blank">Rekap Klaim Jaminan Inap</a></td>
                                        <td><a href="" target="_blank">Rekap Klaim Jaminan Non Inap</a></td>
			</tr>
                                <tr>
                                        <td colspan="2"><a href="" target="_blank">Rekap Klaim Jaminan Konsul/Penunjang Medik</a></td>
			</tr>
                                <tr>
                                        <td><a href="" target="_blank">Perda Paisen Inap (Semua Pasien)</a></td>
                                        <td><a href="" target="_blank">Perda Pasien Non Inap (Semua Pasien)</a></td>
			</tr>
                                <tr>
                                        <td colspan="2"><a href="" target="_blank">Perda Konsul/Penunjang Medik (Semua Pasien)</a></td>
			</tr>
		</table>
	</fieldset>
        </div-->
    </body>
    <script type="text/JavaScript">
        isiCombo('StatusPas','','','',showTmpLay);
        function showTmpLay(){
            isiCombo('StatusPas',document.getElementById('StatusPas').value);
        }

        function isiCombo(id,val,defaultId,targetId,evloaded)
        {
            if(targetId=='' || targetId==undefined)
            {
                targetId=id;
            }
            Request('../combo_utils.php?id='+id+'&all=1&value='+val+'&defaultId='+defaultId,id,'','GET',evloaded);
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
            var StatusPas = document.getElementById("StatusPas").value;
            var tglAwal = document.getElementById("tglAwal").value;
            var tglAkhir = document.getElementById("tglAkhir").value;
            //window.open('tagihan_penjamin.php?stsPas='+StatusPas+'&tglAwal='+tglAwal+'&tglAkhir='+tglAkhir,'_blank');
            window.open('kunjLab.php?stsPas='+StatusPas+'&tglAwal='+tglAwal+'&tglAkhir='+tglAkhir,'_blank');
        }
    </script>
</html>
