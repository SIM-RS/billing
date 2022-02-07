<?php
session_start();
include "../sesi.php";
$userId = $_SESSION['userId'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <link rel="stylesheet" type="text/css" href="../theme/tab-view.css" />
        <script type="text/javascript" src="../theme/js/tab-view.js"></script>

        <!--dibawah ini diperlukan untuk menampilkan popup-->
        <link rel="stylesheet" type="text/css" href="../theme/popup.css" />
        <script type="text/javascript" src="../theme/prototype.js"></script>
        <script type="text/javascript" src="../theme/effects.js"></script>
        <script type="text/javascript" src="../theme/popup.js"></script>
        <!--diatas ini diperlukan untuk menampilkan popup-->

        <!-- untuk ajax-->
        <script type="text/javascript" src="../theme/js/ajax.js"></script>
        <!-- end untuk ajax-->

        <title>Laporan Rekam Medik</title>
    </head>

    <body>
        <div align="center">
            <?php
			include("../koneksi/konek.php");
            include("../header1.php");
            $date_now=gmdate('d-m-Y',mktime(date('H')+7));
            $date_skr=explode('-',$date_now);
            ?>
            <script type="text/JavaScript">
                var arrRange=depRange=[];
            </script>
            <iframe height="193" width="168" name="gToday:normal:agenda.js"
                    id="gToday:normal:agenda.js"
                    src="../theme/popcjs.php" scrolling="no"
                    frameborder="1"
                    style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
            </iframe>
            <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
                <tr>
                    <td height="30">&nbsp;LAPORAN REKAM MEDIK</td>
                </tr>
            </table>
            <table width="1000" border="0" cellspacing="0" cellpadding="0" class="txtinput" align="center">
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
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" align="center">
                                                    <div id="trPeriode" style="display:none">
				  Periode : <input size="10" value="<?php echo $date_now;?>" class="txtcenter" id="tglAwal" name="tglAwal" readonly="readonly"/>&nbsp;<input type="button" class="btninput" id="btnTglAwal" name="btnTgl" value=" V " onClick="gfPop.fPopCalendar(document.getElementById('tglAwal'),depRange);" />&nbsp;s.d.&nbsp;<input size="10" value="<?=$date_now;?>" class="txtcenter" id="tglAkhir" name="tglAkhir" />&nbsp;
                                                        <input type="button" class="btninput" id="btnTglAkhir" name="btnTgl2" value=" V " onclick="gfPop.fPopCalendar(document.getElementById('tglAkhir'),depRange);" />
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="40%" align="right">Jenis Layanan</td>
                                                <td width="60%">&nbsp;<select name="JnsLayanan" id="JnsLayanan" tabindex="26" class="txtinput" onchange="isiCombo('TmpLayanan',this.value)"></select></td>
                                            </tr>
                                            <tr>
                                                <td width="40%" height="25" align="right">Tempat Layanan</td>
                                                <td width="60%">&nbsp;<select name="TmpLayanan" id="TmpLayanan" tabindex="27" class="txtinput"></select></td>
                                            </tr>
                                            <tr>
                                                <td width="40%" align="right">Status Pasien</td>
                                                <td width="60%">&nbsp;<select name="StatusPas" id="StatusPas" tabindex="22" class="txtinput"></select>					</td>
                                            </tr>
                                            <tr>
                                                <td align="right">ICD X</td>
                                                <td><input size="16" id="txtIcdx" name="txticdx" class="txtinput"/></td>
                                            </tr>
                                            <tr>
                                                <td align="right">ICD IX</td>
                                                <td><input size="16" id="txtIcdix" name="txtIcdix" class="txtinput"/></td>
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
                    <td colspan="2" align="center"><input value="&nbsp;&nbsp;&nbsp;Laporan&nbsp;&nbsp;&nbsp;" type="button" class="btninput" onclick="getLap()" /></td>
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
                    <td>&nbsp;<input class="btninput" type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" /></td>
                    <td align="right"><a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" class="btninput" /></a>&nbsp;</td>
                </tr>
            </table>
        </div>

        <div id="div_laporan" style="display:none;width:70%; height:80%" class="popup">
            <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" />
            <!--fieldset>
		<legend>Laporan Rekam Medik</legend>
                    <table width="725" align="center" style="font-size:12px">
                            <tr>
                                    <td width="50%" onclick="rekam1()" style="cursor:pointer;" height="20">Kunjungan Pasien</td>
                                    <td width="50%" onclick="rekam9()" style="cursor:pointer;">Daftar Verifikasi Diagnosis PP</td>
			</tr>
                            <tr>
                                    <td height="20" onclick="rekam2()" style="cursor:pointer;">Asal Pasien Berdasarkan Tempat Layanan</td>
                                    <td><a href="Rekam Medik/AsalRujTmptLay.php" target="_blank">Asal Rujukan Pasien Berdasarkan Tempat Layanan</a></td>
			</tr>
                            <tr>
                                    <td height="20" onclick="rekam3()" style="cursor:pointer;">Cara Bayar Pasien Berdasarkan Tempat Layanan</td>
                                    <td><a href="Rekam Medik/KasusPenyakitTmptLay.php" target="_blank">Kasus Penyakit Pasien Berdasarkan Tempat Layanan</a></td>
			</tr>
                            <tr>
                                    <td height="20"><a href="Rekam Medik/CaraKeluarTmptLay.php" target="_blank">Cara Keluar Pasien Berdasarkan Tempat Layanan</a></td>
                                    <td><a href="Rekam Medik/PenerimaanKonsul.php" target="_blank">Penerimaan Konsul Tempat Layanan</a></td>
			</tr>
                            <tr>
                                    <td height="20"><a href="Rekam Medik/PengirimKonsul.php" target="_blank">Pengiriman Konsul Tempat Layanan</a></td>
                                    <td><a href="Rekam Medik/RujukanPenunjangMedik.php" target="_blank">Rujukan Penunjang Medik</a></td>
			</tr>
                            <tr>
                                    <td height="20" onclick="rekam7()" style="cursor:pointer">Kunjungan Rawat Jalan - P. ANAK</td>
                                    <td onclick="rekam4()" style="cursor:pointer;">Asal Pasien Rawat Jalan - <label id="lblLay"></label>P. ANAK</td>
			</tr>
                            <tr>
                                    <td height="20"><a href="Rekam Medik/Kasus.php" target="_blank">Kasus Rawat Jalan - P. ANAK</a></td>
                                    <td><a href="Rekam Medik/CaraKeluar.php" target="_blank">Cara Keluar Rawat Jalan - P. ANAK</a></td>
			</tr>
                            <tr>
                                    <td height="20" onclick="rekam6()" style="cursor:pointer;">Diagnosis Pasien Rawat Jalan - P. ANAK</td>
                                    <td onclick="rekam5()" style="cursor:pointer;">10 Diagnosis Terbanyak Pasien Rawat Jalan - P. ANAK</td>
			</tr>
                            <tr>
                                    <td height="20" onclick="rekam8()" style="cursor:pointer">10 Diagnosis Terbanyak PP Rawat Jalan - P. ANAK</td>
                                    <td><a href="" target="_blank">Grafik 10 Diagnosis Terbanyak Rawat Jalan - P. ANAK</a></td>
			</tr>
                            <tr>
                                    <td colspan="2" height="20"><a href="Rekam Medik/10DiagnosisBiayaTinggi.php" target="_blank">10 Penyakit Terbanyak Dengan Biaya Tertinggi PP Rawat Jalan - P. ANAK</a></td>
			</tr>
                            <tr>
                                    <td height="20" onclick="rekam10()" style="cursor:pointer">Keadaan Morbiditas Pasien Rawat Jalan - P. ANAK</td>
                                    <td height="20"><a href="" target="_blank">Kegiatan Pelayanan Tempat Layanan</a></td>
			</tr>
                            <tr>
                                    <td colspan="2" height="20"><a href="" target="_blank">Keadaan Morbiditas Surveilans Terpadu Rawat Jalan - P. ANAK</a></td>
			</tr>
                            <tr>
                                    <td height="20"><a href="" target="_blank">Tindakan Operasi</a></td>
                                    <td><a href="" target="_blank">10 Tindakan Operasi Terbanyak</a></td>
			</tr>
                            <tr>
                                    <td colspan="2" height="20"><a href="" target="_blank">10 Tindakan Operasi Terbanyak Berdasarkan Penjamin Pasien</a></td>
			</tr>
                            <tr>
                                    <td colspan="2" height="20"><a href="" target="_blank">10 Tindakan Operasi Terbanyak dengan Biaya Tertinggi dan Berdasarkan Penjamin Pasien</a></td>
			</tr>
                            <tr>
                                    <td height="20"><a href="" target="_blank">Kunjungan Berdasarkan Pendidikan</a></td>
                                    <td><a href="" target="_blank">Kunjungan Berdasarkan Pekerjaan</a></td>
			</tr>
                            <tr>
                                    <td height="20"><a href="" target="_blank">Index Penyakit</a></td>
                                    <td><a href="" target="_blank">Index Operasi</a></td>
			</tr>
                            <tr>
                                    <td colspan="2" height="20"><a href="" target="_blank">Kunjungan Berdasarkan Wilayah</a></td>
			</tr>
                            <tr>
                                    <td colspan="2" height="20"><a href="" target="_blank">10 Diagnosis Terbanyak Penyebab Kematian</a></td>
			</tr>
                            <tr>
                                    <td colspan="2" height="20"><a href="" target="_blank">Kunjungan Tempat Layanan Berdasarkan Penjamin Pasien</a></td>
			</tr>
                            <tr>
                                    <td colspan="2" height="20"><a href="" target="_blank">Kunjungan Utama Tempat Layanan Berdasarkan Penjamin Pasien</a></td>
			</tr>
		</table>
	</fieldset-->
        </div>

    </body>
    <script type="text/JavaScript">
        isiCombo('JnsLayanan','','','',showTmpLay);
        function showTmpLay(){
            isiCombo('TmpLayanan',document.getElementById('JnsLayanan').value);
        }
        isiCombo('StatusPas');

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
            var JnsLayanan = document.getElementById("JnsLayanan").value;
            var TmpLayanan = document.getElementById("TmpLayanan").value;
            var StatusPas = document.getElementById("StatusPas").value;
            var tglAwal = document.getElementById("tglAwal").value;
            var tglAkhir = document.getElementById("tglAkhir").value;
            new Popup('div_laporan',null,{modal:true,position:'center',duration:1});
            Request("Rekam Medik/IsiDiv.php?jnsLay="+JnsLayanan+"&tmptLay="+TmpLayanan+"&stsPas="+StatusPas+"&tglAwal="+tglAwal+"&tglAkhir="+tglAkhir, 'div_laporan', "", "GET");
            document.getElementById('div_laporan').popup.show();
        }

        function rekam1()
        {
            var JnsLayanan = document.getElementById("JnsLayanan").value;
            var TmpLayanan = document.getElementById("TmpLayanan").value;
            var StatusPas = document.getElementById("StatusPas").value;
            var tglAwal = document.getElementById("tglAwal").value;
            var tglAkhir = document.getElementById("tglAkhir").value;
            window.open('Rekam Medik/kunjungan_pasien.php?jnsLay='+JnsLayanan+'&tmptLay='+TmpLayanan+'&stsPas='+StatusPas+'&tglAwal='+tglAwal+'&tglAkhir='+tglAkhir+'&userId=<?php echo $userId;?>','_blank');
        }

        function rekam2()
        {
            var JnsLayanan = document.getElementById("JnsLayanan").value;
            var TmpLayanan = document.getElementById("TmpLayanan").value;
            var StatusPas = document.getElementById("StatusPas").value;
            var tglAwal = document.getElementById("tglAwal").value;
            var tglAkhir = document.getElementById("tglAkhir").value;
            window.open('Rekam Medik/AsalPasTmptLay.php?jnsLay='+JnsLayanan+'&tmptLay='+TmpLayanan+'&stsPas='+StatusPas+'&tglAwal='+tglAwal+'&tglAkhir='+tglAkhir+'&userId=<?php echo $userId;?>','_blank');
        }

        function rekam3()
        {
            var JnsLayanan = document.getElementById("JnsLayanan").value;
            var TmpLayanan = document.getElementById("TmpLayanan").value;
            var StatusPas = document.getElementById("StatusPas").value;
            var tglAwal = document.getElementById("tglAwal").value;
            var tglAkhir = document.getElementById("tglAkhir").value;
            window.open('Rekam Medik/CaraBayarTmptLay.php?jnsLay='+JnsLayanan+'&tmptLay='+TmpLayanan+'&stsPas='+StatusPas+'&tglAwal='+tglAwal+'&tglAkhir='+tglAkhir+'&userId=<?php echo $userId;?>','_blank');
        }

        function rekam4()
        {
            var JnsLayanan = document.getElementById("JnsLayanan").value;
            var TmpLayanan = document.getElementById("TmpLayanan").value;
            var StatusPas = document.getElementById("StatusPas").value;
            var tglAwal = document.getElementById("tglAwal").value;
            var tglAkhir = document.getElementById("tglAkhir").value;
            window.open('Rekam Medik/AsalPasien.php?jnsLay='+JnsLayanan+'&tmptLay='+TmpLayanan+'&stsPas='+StatusPas+'&tglAwal='+tglAwal+'&tglAkhir='+tglAkhir+'&userId=<?php echo $userId;?>','_blank');
        }

        function rekam5()
        {
            var JnsLayanan = document.getElementById("JnsLayanan").value;
            var TmpLayanan = document.getElementById("TmpLayanan").value;
            var StatusPas = document.getElementById("StatusPas").value;
            var tglAwal = document.getElementById("tglAwal").value;
            var tglAkhir = document.getElementById("tglAkhir").value;
            window.open('Rekam Medik/10Diagnosis.php?jnsLay='+JnsLayanan+'&tmptLay='+TmpLayanan+'&stsPas='+StatusPas+'&tglAwal='+tglAwal+'&tglAkhir='+tglAkhir+'&userId=<?php echo $userId;?>','_blank');
        }

        function rekam6()
        {
            var JnsLayanan = document.getElementById("JnsLayanan").value;
            var TmpLayanan = document.getElementById("TmpLayanan").value;
            var StatusPas = document.getElementById("StatusPas").value;
            var tglAwal = document.getElementById("tglAwal").value;
            var tglAkhir = document.getElementById("tglAkhir").value;
            window.open('Rekam Medik/DiagnosisPasien.php?jnsLay='+JnsLayanan+'&tmptLay='+TmpLayanan+'&stsPas='+StatusPas+'&tglAwal='+tglAwal+'&tglAkhir='+tglAkhir+'&userId=<?php echo $userId;?>','_blank');
        }

        function rekam7()
        {
            var JnsLayanan = document.getElementById("JnsLayanan").value;
            var TmpLayanan = document.getElementById("TmpLayanan").value;
            var StatusPas = document.getElementById("StatusPas").value;
            var tglAwal = document.getElementById("tglAwal").value;
            var tglAkhir = document.getElementById("tglAkhir").value;
            window.open('Rekam Medik/KunjunganRawatJalan.php?jnsLay='+JnsLayanan+'&tmptLay='+TmpLayanan+'&stsPas='+StatusPas+'&tglAwal='+tglAwal+'&tglAkhir='+tglAkhir+'&userId=<?php echo $userId;?>','_blank');
        }

        function rekam8()
        {
            var JnsLayanan = document.getElementById("JnsLayanan").value;
            var TmpLayanan = document.getElementById("TmpLayanan").value;
            var StatusPas = document.getElementById("StatusPas").value;
            var tglAwal = document.getElementById("tglAwal").value;
            var tglAkhir = document.getElementById("tglAkhir").value;
            window.open('Rekam Medik/10DiagnosisTrbanyak.php?jnsLay='+JnsLayanan+'&tmptLay='+TmpLayanan+'&stsPas='+StatusPas+'&tglAwal='+tglAwal+'&tglAkhir='+tglAkhir+'&userId=<?php echo $userId;?>','_blank');
        }

        function rekam9()
        {
            var JnsLayanan = document.getElementById("JnsLayanan").value;
            var TmpLayanan = document.getElementById("TmpLayanan").value;
            var StatusPas = document.getElementById("StatusPas").value;
            var tglAwal = document.getElementById("tglAwal").value;
            var tglAkhir = document.getElementById("tglAkhir").value;
            window.open('Rekam Medik/dftr_verifikasi.php?jnsLay='+JnsLayanan+'&tmptLay='+TmpLayanan+'&stsPas='+StatusPas+'&tglAwal='+tglAwal+'&tglAkhir='+tglAkhir+'&userId=<?php echo $userId;?>','_blank');
        }

        function rekam10()
        {
            var JnsLayanan = document.getElementById("JnsLayanan").value;
            var TmpLayanan = document.getElementById("TmpLayanan").value;
            var StatusPas = document.getElementById("StatusPas").value;
            var tglAwal = document.getElementById("tglAwal").value;
            var tglAkhir = document.getElementById("tglAkhir").value;
            window.open('Rekam Medik/Morbiditas.php?jnsLay='+JnsLayanan+'&tmptLay='+TmpLayanan+'&stsPas='+StatusPas+'&tglAwal='+tglAwal+'&tglAkhir='+tglAkhir+'&userId=<?php echo $userId;?>','_blank');
        }

        function rekam11()
        {
            var JnsLayanan = document.getElementById("JnsLayanan").value;
            var TmpLayanan = document.getElementById("TmpLayanan").value;
            var StatusPas = document.getElementById("StatusPas").value;
            var tglAwal = document.getElementById("tglAwal").value;
            var tglAkhir = document.getElementById("tglAkhir").value;
            window.open('Rekam Medik/RujukanPenunjangMedik.php?jnsLay='+JnsLayanan+'&tmptLay='+TmpLayanan+'&stsPas='+StatusPas+'&tglAwal='+tglAwal+'&tglAkhir='+tglAkhir+'&userId=<?php echo $userId;?>','_blank');
        }

        function rekam12()
        {
            var JnsLayanan = document.getElementById("JnsLayanan").value;
            var TmpLayanan = document.getElementById("TmpLayanan").value;
            var StatusPas = document.getElementById("StatusPas").value;
            var tglAwal = document.getElementById("tglAwal").value;
            var tglAkhir = document.getElementById("tglAkhir").value;
            window.open('Rekam Medik/AsalRujTmptLay.php?jnsLay='+JnsLayanan+'&tmptLay='+TmpLayanan+'&stsPas='+StatusPas+'&tglAwal='+tglAwal+'&tglAkhir='+tglAkhir+'&userId=<?php echo $userId;?>','_blank');
        }
    </script>
</html>
<?php 
mysql_close($konek);
?>