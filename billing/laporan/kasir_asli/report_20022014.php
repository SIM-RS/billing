
<?php
session_start();
include("../../sesi.php");
$userId = $_SESSION['userId'];
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

        <title>Laporan Kasir</title>
    </head>

    <body>
        <script type="text/JavaScript" language="JavaScript">
            var arrRange=depRange=[];
        </script>
        <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js"
                src="../../theme/popcjs.php" scrolling="no"
                frameborder="1"
                style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
        </iframe>
        <div align="center">
            <?php
			include("../../koneksi/konek.php");
            include("../../header1.php");
            include("report_form.php");
            $date_now=gmdate('d-m-Y',mktime(date('H')+7));
            $date_skr=explode('-',$date_now);
			$sql="SELECT * FROM b_ms_unit WHERE id=$idKasirPendaftaranRJ";
			$rs=mysql_query($sql);
			$rw=mysql_fetch_array($rs);
			$kasir=str_replace("rj","RJ",strtolower($rw['nama']));
            ?>
            <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
                <tr>
                    <td height="30">&nbsp;LAPORAN KASIR</td>
                </tr>
            </table>
            <table width="1000" border="0" cellspacing="0" cellpadding="0" class="txtinput" align="center" height="450">
                <tr>
                    <td width="15%" height="50">&nbsp;</td>
                    <td width="70%">&nbsp;</td>
                    <td width="15%">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td valign="top">
                        <table width="100%" border="0" cellpadding="2" cellspacing="5" align="center" class="list_laporan">
                            <tr>
                                <td style="line-height:30px;">
                                    <ol>
										<li><a href="javascript:void(0)" onclick="popupReport4()">Laporan Penerimaan Kasir Berdasarkan Nama Kasir</a></li>
                                        <li><a href="javascript:void(0)" onclick="popupReport1()">Laporan Penerimaan Kasir Berdasarkan Tempat Layanan</a></li>
                                        <li><a href="javascript:void(0)" onclick="popupReport5()">Detail Penerimaan Kasir Berdasarkan Kunjungan Pasien</a></li>
                                        <li><a href="javascript:void(0)" onclick="popupReport6()">Rekapitulasi Penerimaan Kasir Berdasarkan Kunjungan Pasien</a></li>
                                        <li><a href="javascript:void(0)" onclick="popupReport7()" style="text-transform:capitalize">Rekapitulasi Laporan Penerimaan <?php echo $kasir; ?></a></li>
                                        <li><a href="javascript:void(0)" onclick="popupReport9()">Laporan Penerimaan Rawat Jalan</a></li>
                                        <li><a href="javascript:void(0)" onclick="popupReport10()">Laporan Penerimaan Kasir Rawat Jalan</a></li>
                                      	<li><a href="javascript:void(0)" onclick="popupReport8()">Rekapitulasi Laporan Penerimaan Kasir Rawat Jalan</a></li>
                                        <li><a href="javascript:void(0)" onclick="popupReport11()">Laporan Penerimaan Rawat Jalan Secara Keseluruhan</a></li>
                                        <li><a href="javascript:void(0)" onclick="popupReport12()">Rekapitulasi Penerimaan Kasir Rawat Inap</a></li>
										<li><a href="javascript:void(0)" onclick="popupReport13()">Rincian Penerimaan Kasir Rawat Inap Berdasarkan Akhir Layanan</a></li>
										<li><a href="javascript:void(0)" onclick="popupReport14()">Rincian Per Nama Pasien Penerimaan Rawat Inap Umum</a></li>
                                        <!--li><a href="javascript:void(0)" onclick="popupReport3()">Rekapitulasi Penerimaan Berdasarkan Nama Kasir</a></li-->
										<li><a href="javascript:void(0)" onclick="popupReport15()">Rincian Per Nama Pasien Penerimaan Rawat Inap KSO</a></li>
										<!--li><a href="javascript:void(0)" onclick="popupReport16()">Rincian Per Nama Pasien Penerimaan Rawat Inap</a></li-->
                                    </ol>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3" height="50">&nbsp;</td>
                </tr>
            </table>
            <table border="0" cellpadding="0" cellspacing="0" width="1000" class="hd2">
                <tr height="30">
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="right">&nbsp;</td>
                </tr>
            </table>
        </div>
    </body>
    <script type="text/JavaScript">
        isiCombo('JnsLayanan','','','',showTmpLay);
        function showTmpLay(){
            isiCombo1('TmpLayanan',document.getElementById('JnsLayanan').value);
            isiCombo1('cmbKsr',document.getElementById('JnsLayanan').value);
        }
        isiCombo1('StatusPas');
        isiCombo1('cmbKsr');
        isiCombo('cmbKasir2','','','',showNmKsr);
		function showNmKsr(){
			isiCombo1('nmKsr',document.getElementById('cmbKasir2').value);
		}
       

        function isiCombo(id,val,defaultId,targetId,evloaded)
        {
            if(targetId=='' || targetId==undefined)
            {
                targetId=id;
            }
            Request('../../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,id,'','GET',evloaded);
        }

        function isiCombo1(id,val,defaultId,targetId,evloaded)
        {
            if(targetId=='' || targetId==undefined)
            {
                targetId=id;
            }
            Request('../../combo_utils.php?all=1&id='+id+'&value='+val+'&defaultId='+defaultId,id,'','GET',evloaded);
        }

        function popupReport1()
        {
			isiCombo1('TmpLayanan',document.getElementById('JnsLayanan').value);
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'table-row';
            document.getElementById('rwTmpLay').style.display = 'table-row';
            document.getElementById('rwStatusPas').style.display = 'table-row';
            document.getElementById('rwKasir').style.display = 'none';
            document.getElementById('rwNamaKasir').style.display = 'none';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'penerimaanPasien';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
            $('popup_div1').popup.show();
            document.getElementById('form1').action='PenerimaanPasien.php';
        }

        function popupReport2()
        {
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'table-row';
            document.getElementById('rwTmpLay').style.display = 'table-row';
            document.getElementById('rwStatusPas').style.display = 'table-row';
            document.getElementById('rwKasir').style.display = 'none';
            document.getElementById('rwNamaKasir').style.display = 'none';
            document.getElementById('rwKasir2').style.display = 'table-row';
            document.getElementById('form1').target = 'jmlPenerimaanPasien';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
            $('popup_div1').popup.show();
            document.getElementById('form1').action='JmlPenerimaanPasien.php';
        }

        function popupReport3()
        {
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            document.getElementById('rwStatusPas').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'table-row';
            document.getElementById('rwNamaKasir').style.display = 'table-row';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'rekapPenerimaanNamaKasir';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
            $('popup_div1').popup.show();
            document.getElementById('form1').action='RekapPenerimaanNamaKasir.php';
        }
		
        function popupReport4()
        {
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            document.getElementById('rwStatusPas').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'table-row';
            document.getElementById('rwNamaKasir').style.display = 'table-row';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'PenerimaanKasir';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
            $('popup_div1').popup.show();
            document.getElementById('form1').action='PenerimaanKasir.php';
        }
		
        function popupReport5()
        {
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'table-row';
            document.getElementById('rwNamaKasir').style.display = 'table-row';
            document.getElementById('rwStatusPas').style.display = 'none';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'PenerimaanKasir_Kunjungan';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
            $('popup_div1').popup.show();
            document.getElementById('form1').action='PenerimaanKasir_Kunjungan.php';
        }
		
        function popupReport6()
        {
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'table-row';
            document.getElementById('rwNamaKasir').style.display = 'table-row';
            document.getElementById('rwStatusPas').style.display = 'none';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'PenerimaanKasir_KunjunganRekap';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
            $('popup_div1').popup.show();
            document.getElementById('form1').action='PenerimaanKasir_KunjunganRekap.php';
        }
		
		function popupReport7()
        {
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'none';
            document.getElementById('rwNamaKasir').style.display = 'none';
            document.getElementById('rwStatusPas').style.display = 'none';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'penerimaan_kasir_pendaftaran';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
            $('popup_div1').popup.show();
            document.getElementById('form1').action='penerimaan_kasir_pendaftaran.php';
        }
		
		function popupReport8()
        {
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            //document.getElementById('rwKasir').style.display = 'table-row';
			document.getElementById('rwKasir').style.display = 'none';
			document.getElementById('cmbKasir2').value=<?php echo $idKasirRJ; ?>;
			isiCombo1('nmKsr',document.getElementById('cmbKasir2').value);
            document.getElementById('rwNamaKasir').style.display = 'table-row';
            document.getElementById('rwStatusPas').style.display = 'none';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'penerimaan_kasir_pendaftaran _rawat_jalan';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
            $('popup_div1').popup.show();
            document.getElementById('form1').action='rekap_penerimaan_kasir_rj.php';
        }
		
		function popupReport9()
        {
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
			document.getElementById('JnsLayanan').value=1;
			isiCombo('TmpLayanan',document.getElementById('JnsLayanan').value);
            document.getElementById('rwTmpLay').style.display = 'table-row';
            document.getElementById('rwStatusPas').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'none';
            document.getElementById('rwNamaKasir').style.display = 'none';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'penerimaan_rawat_jalan';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
            $('popup_div1').popup.show();
            document.getElementById('form1').action='penerimaan_rawat_jalan.php';
        }
		
		function popupReport10()
        {
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            //document.getElementById('rwKasir').style.display = 'table-row';
			document.getElementById('rwKasir').style.display = 'none';
			document.getElementById('cmbKasir2').value=<?php echo $idKasirRJ; ?>;
			isiCombo1('nmKsr',document.getElementById('cmbKasir2').value);
            document.getElementById('rwNamaKasir').style.display = 'table-row';
            document.getElementById('rwStatusPas').style.display = 'none';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'penerimaan_kasir_rawat_jalan_periode';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
            $('popup_div1').popup.show();
            document.getElementById('form1').action='penerimaan_kasir_rawat_jalan_periode.php';
        }
		
		function popupReport11()
        {
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
			document.getElementById('JnsLayanan').value=1;
			isiCombo1('TmpLayanan',document.getElementById('JnsLayanan').value);
            document.getElementById('rwTmpLay').style.display = 'table-row';
            document.getElementById('rwKasir').style.display = 'none';
            document.getElementById('rwNamaKasir').style.display = 'none';
            document.getElementById('rwStatusPas').style.display = 'none';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'penerimaan_rawat_jalan_keseluruhan';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
            $('popup_div1').popup.show();
            document.getElementById('form1').action='penerimaan_rawat_jalan_keseluruhan.php';
        }
		function popupReport12()
        {
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'none';
            document.getElementById('rwNamaKasir').style.display = 'none';
            document.getElementById('rwStatusPas').style.display = 'none';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'rekapitulasi_penerimaan_kasir_rawat_inap';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
            $('popup_div1').popup.show();
            document.getElementById('form1').action='Rekapitulasi_Penerimaan_Kasir_Rawat_Inap.php';
        }
		function popupReport13()
        {
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'none';
            document.getElementById('rwNamaKasir').style.display = 'none';
            document.getElementById('rwStatusPas').style.display = 'none';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'rincian_penerimaan_kasir_rawat_inap_berdasarkan_akhir_layanan';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
            $('popup_div1').popup.show();
            document.getElementById('form1').action='Rincian_Penerimaan_Kasir_Rawat_Inap_Berdasarkan_Akhir_Layanan.php';
        }
		function popupReport14()
		{
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
			document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'none';
            document.getElementById('rwNamaKasir').style.display = 'none';
            document.getElementById('rwStatusPas').style.display = 'none';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'rincian_per_nama_pasien_penerimaan_rawat_inap_umum';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
            $('popup_div1').popup.show();
            document.getElementById('form1').action='Rincian_Per_Nama_Pasien_Penerimaan_Rawat_Inap_Umum.php';
		}
		function popupReport15()
		{
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
			document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'none';
            document.getElementById('rwNamaKasir').style.display = 'none';
            document.getElementById('rwStatusPas').style.display = 'none';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'oyi';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
            $('popup_div1').popup.show();
            document.getElementById('form1').action='oyi.php';
		}
		function popupReport16()
        {
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'none';
            document.getElementById('rwNamaKasir').style.display = 'none';
            document.getElementById('rwStatusPas').style.display = 'none';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'rincian_per_nama_pasien_penerimaan_rawat_inap';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
            $('popup_div1').popup.show();
            document.getElementById('form1').action='Rincian_Per_Nama_Pasien_Penerimaan_Rawat_Inap3.php';
        }
    </script>
</html>