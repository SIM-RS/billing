<?php
include("../../sesi.php");
$userId = $_SESSION['userId'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="../../theme/mod.css" />
        <script type="text/JavaScript" language="JavaScript" src="../../theme/js/dsgrid.js"></script>
		<script type="text/javascript" src="../../include/jquery/jquery-1.9.1.js"></script>
        <script type="text/javascript" src="../../include/jquery/jquery.mask.min.js"></script>
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
                        <table width="100%" border="0" cellpadding="2" cellspacing="5" align="center" style="border:solid 5px #339900;background-color:#D3EFBA;font-size:14px">
                            <tr>
                                <td style="line-height:30px;">
                                    <ol>
										
                                        <li><a href="javascript:void(0)" onclick="popupReport22()">Laporan Penerimaan Kasir Berdasarkan Nama Kasir</a></li>
                                        <li><a href="javascript:void(0)" onclick="popupReport1()">Laporan Penerimaan Kasir Berdasarkan Tempat Layanan</a></li>
                                        <li><a href="javascript:void(0)" onclick="popupReport6()">Rekapitulasi Penerimaan Kasir Berdasarkan Kunjungan Pasien</a></li>    
										<li><a href="javascript:void(0)" onclick="popupReport23()">Laporan Setoran Penerimaan Kasir Berdasarkan Nama Kasir</a></li>
										<li><a href="javascript:void(0)" onclick="popupReport27()">Laporan Penerimaan Kasir Berdasarkan Pos Pendapatan</a></li>
										<li><a href="javascript:void(0)" onclick="popupReport27b()">Laporan Penerimaan Kasir Berdasarkan Pos Pendapatan (Belum Setor)</a></li>
										 
										<li><a href="javascript:void(0)" onclick="popupReport27a()">Laporan Setoran Penerimaan Kasir / Pendapatan (Detail)</a>
                                        </br>
                               			<span><a href="javascript:void(0)" onclick="popupReport28()">Laporan Pendapatan Non Tunai (Detail)</a></span>
										</br>
                               			<span><a href="javascript:void(0)" onclick="popupReport29()">Laporan Pendapatan Tunai + Non Tunai (Detail)</a></span>
										</li>
										<li><a href="javascript:void(0)" onclick="popupReport30()">Laporan Setoran Penerimaan Kasir / Pendapatan (Rekap)</a>
										</br>
                               			<span><a href="javascript:void(0)" onclick="popupReport31()">Laporan Pendapatan Non Tunai (Rekap)</a></span>
										</br>
										<span> <a href="javascript:void(0)" onclick="popupReport32()">Laporan Pendapatan Tunai + Non Tunai (Rekap)</a></span>
										</li>
										<li><a href="javascript:void(0)" onclick="popupReport33()">Laporan Kwitansi Sementara Pcr</a></li>  
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
		isiCombo1('StatusPasNonUmum');
        isiCombo1('cmbKsr');
        isiCombo('cmbKasir2','','','',showNmKsr);
		isiCombo1('nmKsrAll','','','cmbKsrAll');
		function showNmKsr(){
			isiCombo1('nmKsr',document.getElementById('cmbKasir2').value);
		}
		
		function showTime(t){
			if(t==1){
				jQuery("#txtJam1").show();
				jQuery("#txtJam2").show();
				jQuery("#txtJam1").val('00:00');
				jQuery("#txtJam2").val('23:59');
			}
			else{
				jQuery("#txtJam1").hide();
				jQuery("#txtJam2").hide();
			}
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
			//alert('../../combo_utils.php?all=1&id='+id+'&value='+val+'&defaultId='+defaultId);
            Request('../../combo_utils.php?all=1&id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded);
        }
		
		function fSubmitKlik(){
			document.getElementById('cmbKasir2').disabled=false;
			document.getElementById('form1').submit();
			if (document.getElementById('form1').target == 'rekapitulasi_penerimaan_kasir_rawat_inap'){
				document.getElementById('cmbKasir2').disabled=true;
			}
			//alert('submit');
		}

        function popupReport1()
        {
			showTime(1);
			isiCombo1('TmpLayanan',document.getElementById('JnsLayanan').value);
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'table-row';
            document.getElementById('rwTmpLay').style.display = 'table-row';
            document.getElementById('rwStatusPas').style.display = 'table-row';
			document.getElementById('rwStatusPasNonUmum').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'none';
			document.getElementById('rwKasirAll').style.display = 'none';
            document.getElementById('rwNamaKasir').style.display = 'none';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'penerimaanPasien';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5});
            $('popup_div1').popup.show();
            document.getElementById('form1').action='PenerimaanPasien.php';
        }

        function popupReport2()
        {
			showTime(0);
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'table-row';
            document.getElementById('rwTmpLay').style.display = 'table-row';
            document.getElementById('rwStatusPas').style.display = 'table-row';
			document.getElementById('rwStatusPasNonUmum').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'none';
			document.getElementById('rwKasirAll').style.display = 'none';
            document.getElementById('rwNamaKasir').style.display = 'none';
            document.getElementById('rwKasir2').style.display = 'table-row';
            document.getElementById('form1').target = 'jmlPenerimaanPasien';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5});
            $('popup_div1').popup.show();
            document.getElementById('form1').action='JmlPenerimaanPasien.php';
        }

        function popupReport3()
        {
			showTime(0);
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            document.getElementById('rwStatusPas').style.display = 'none';
			document.getElementById('rwStatusPasNonUmum').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'table-row';
			document.getElementById('rwKasirAll').style.display = 'none';
			document.getElementById('cmbKasir2').disabled=false;
            document.getElementById('rwNamaKasir').style.display = 'table-row';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'rekapPenerimaanNamaKasir';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5});
            $('popup_div1').popup.show();
            document.getElementById('form1').action='RekapPenerimaanNamaKasir.php';
        }
		
        function popupReport4()
        {
			showTime(1);
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            document.getElementById('rwStatusPas').style.display = 'none';
			document.getElementById('rwStatusPasNonUmum').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'table-row';
			document.getElementById('rwKasirAll').style.display = 'none';
			document.getElementById('cmbKasir2').disabled=false;
            document.getElementById('rwNamaKasir').style.display = 'table-row';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'PenerimaanKasir';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5});
            $('popup_div1').popup.show();
            document.getElementById('form1').action='PenerimaanKasir.php';
        }
		
        function popupReport5()
        {
			showTime(0);
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'table-row';
			document.getElementById('rwKasirAll').style.display = 'none';
			document.getElementById('cmbKasir2').disabled=false;
            document.getElementById('rwNamaKasir').style.display = 'table-row';
            document.getElementById('rwStatusPas').style.display = 'none';
			document.getElementById('rwStatusPasNonUmum').style.display = 'none';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'PenerimaanKasir_Kunjungan';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5});
            $('popup_div1').popup.show();
            document.getElementById('form1').action='PenerimaanKasir_Kunjungan.php';
        }
		
        function popupReport6()
        {
			showTime(0);
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'table-row';
			document.getElementById('rwKasirAll').style.display = 'none';
			document.getElementById('cmbKasir2').disabled=false;
            document.getElementById('rwNamaKasir').style.display = 'table-row';
            document.getElementById('rwStatusPas').style.display = 'none';
			document.getElementById('rwStatusPasNonUmum').style.display = 'none';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'PenerimaanKasir_KunjunganRekap';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5});
            $('popup_div1').popup.show();
            document.getElementById('form1').action='PenerimaanKasir_KunjunganRekap.php';
        }
		
		function popupReport7()
        {
			showTime(0);
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'none';
			document.getElementById('rwKasirAll').style.display = 'none';
            document.getElementById('rwNamaKasir').style.display = 'none';
            document.getElementById('rwStatusPas').style.display = 'none';
			document.getElementById('rwStatusPasNonUmum').style.display = 'none';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'penerimaan_kasir_pendaftaran';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5});
            $('popup_div1').popup.show();
            document.getElementById('form1').action='penerimaan_kasir_pendaftaran.php';
        }
		
		function popupReport8()
        {
			showTime(0);
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            //document.getElementById('rwKasir').style.display = 'table-row';
			document.getElementById('rwKasir').style.display = 'none';
			document.getElementById('rwKasirAll').style.display = 'none';
			document.getElementById('cmbKasir2').value=<?php echo $idKasirRJ; ?>;
			isiCombo1('nmKsr',document.getElementById('cmbKasir2').value);
            document.getElementById('rwNamaKasir').style.display = 'table-row';
            document.getElementById('rwStatusPas').style.display = 'none';
			document.getElementById('rwStatusPasNonUmum').style.display = 'none';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'penerimaan_kasir_pendaftaran _rawat_jalan';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5});
            $('popup_div1').popup.show();
            document.getElementById('form1').action='rekap_penerimaan_kasir_rj.php';
        }
		
		function popupReport9()
        {
			showTime(0);
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
			document.getElementById('JnsLayanan').value=1;
			isiCombo('TmpLayanan',document.getElementById('JnsLayanan').value);
            document.getElementById('rwTmpLay').style.display = 'table-row';
            document.getElementById('rwStatusPas').style.display = 'none';
			document.getElementById('rwStatusPasNonUmum').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'none';
			document.getElementById('rwKasirAll').style.display = 'none';
            document.getElementById('rwNamaKasir').style.display = 'none';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'penerimaan_rawat_jalan';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5});
            $('popup_div1').popup.show();
            document.getElementById('form1').action='penerimaan_rawat_jalan.php';
        }
		
		function popupReport10()
        {
			showTime(0);
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            //document.getElementById('rwKasir').style.display = 'table-row';
			document.getElementById('rwKasir').style.display = 'none';
			document.getElementById('rwKasirAll').style.display = 'none';
			document.getElementById('cmbKasir2').value=<?php echo $idKasirRJ; ?>;
			isiCombo1('nmKsr',document.getElementById('cmbKasir2').value);
            document.getElementById('rwNamaKasir').style.display = 'table-row';
            document.getElementById('rwStatusPas').style.display = 'none';
			document.getElementById('rwStatusPasNonUmum').style.display = 'none';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'penerimaan_kasir_rawat_jalan_periode';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5});
            $('popup_div1').popup.show();
            document.getElementById('form1').action='penerimaan_kasir_rawat_jalan_periode.php';
        }
		
		function popupReport11(p)
        {
			showTime(0);
			//var pil;
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
			/*if (p==1){
				pil=1;
			}else if (p==2){
				pil=44;
			}else if (p==3){
				pil=27;
			}*/
			document.getElementById('JnsLayanan').value=1;
			//isiCombo1('TmpLayanan',document.getElementById('JnsLayanan').value);
			isiCombo1('TmpLayananRJ_RD_RI',p,'','TmpLayanan');
            document.getElementById('rwTmpLay').style.display = 'table-row';
            document.getElementById('rwKasir').style.display = 'none';
			document.getElementById('rwKasirAll').style.display = 'none';
            document.getElementById('rwNamaKasir').style.display = 'none';
            document.getElementById('rwStatusPas').style.display = 'none';
			document.getElementById('rwStatusPasNonUmum').style.display = 'none';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'penerimaan_rawat_jalan_keseluruhan';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5});
            $('popup_div1').popup.show();
            document.getElementById('form1').action='penerimaan_rawat_jalan_keseluruhan.php?tipe='+p;
        }
		function popupReport12()
        {
			showTime(0);
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            //document.getElementById('rwKasir').style.display = 'none';
            //document.getElementById('rwNamaKasir').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'table-row';
			document.getElementById('rwKasirAll').style.display = 'none';
			document.getElementById('cmbKasir2').value="<?php echo $idKasirRI; ?>";
			document.getElementById('cmbKasir2').disabled=true;
			isiCombo1('nmKsr',document.getElementById('cmbKasir2').value);
            document.getElementById('rwNamaKasir').style.display = 'table-row';
            document.getElementById('rwStatusPas').style.display = 'none';
			document.getElementById('rwStatusPasNonUmum').style.display = 'none';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'rekapitulasi_penerimaan_kasir_rawat_inap';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5});
            $('popup_div1').popup.show();
            document.getElementById('form1').action='Rekapitulasi_Penerimaan_Kasir_Rawat_Inap.php';
        }
		function popupReport13()
        {
			showTime(0);
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'none';
			document.getElementById('rwKasirAll').style.display = 'none';
            document.getElementById('rwNamaKasir').style.display = 'none';
            document.getElementById('rwStatusPas').style.display = 'none';
			document.getElementById('rwStatusPasNonUmum').style.display = 'none';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'rincian_penerimaan_kasir_rawat_inap_berdasarkan_akhir_layanan';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5});
            $('popup_div1').popup.show();
            document.getElementById('form1').action='Rincian_Penerimaan_Kasir_Rawat_Inap_Berdasarkan_Akhir_Layanan.php';
        }
		function popupReport14()
		{
			showTime(0);
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
			document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'none';
			document.getElementById('rwKasirAll').style.display = 'none';
            document.getElementById('rwNamaKasir').style.display = 'none';
            document.getElementById('rwStatusPas').style.display = 'none';
			document.getElementById('rwStatusPasNonUmum').style.display = 'none';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'rincian_per_nama_pasien_penerimaan_rawat_inap_umum';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5});
            $('popup_div1').popup.show();
            document.getElementById('form1').action='Rincian_Per_Nama_Pasien_Penerimaan_Rawat_Inap_Umum.php';
		}
		function popupReport15()
		{
			showTime(0);
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
			document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'none';
			document.getElementById('rwKasirAll').style.display = 'none';
            document.getElementById('rwNamaKasir').style.display = 'none';
            document.getElementById('rwStatusPas').style.display = 'none';
			document.getElementById('rwStatusPasNonUmum').style.display = 'none';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'oyi';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5});
            $('popup_div1').popup.show();
            document.getElementById('form1').action='oyi.php';
		}
		function popupReport16()
        {
			showTime(0);
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'none';
			document.getElementById('rwKasirAll').style.display = 'none';
            document.getElementById('rwNamaKasir').style.display = 'none';
            document.getElementById('rwStatusPas').style.display = 'none';
			document.getElementById('rwStatusPasNonUmum').style.display = 'none';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'rincian_per_nama_pasien_penerimaan_rawat_inap';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5});
            $('popup_div1').popup.show();
            document.getElementById('form1').action='Rincian_Per_Nama_Pasien_Penerimaan_Rawat_Inap3.php';
        }
		function popupReport17()
        {
			showTime(0);
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            //document.getElementById('rwKasir').style.display = 'none';
            //document.getElementById('rwNamaKasir').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'table-row';
			document.getElementById('rwKasirAll').style.display = 'none';
			document.getElementById('cmbKasir2').value="<?php echo $idKasirRI; ?>";
			document.getElementById('cmbKasir2').disabled=true;
			isiCombo1('nmKsr',document.getElementById('cmbKasir2').value);
            document.getElementById('rwNamaKasir').style.display = 'table-row';
            document.getElementById('rwStatusPas').style.display = 'none';
			document.getElementById('rwStatusPasNonUmum').style.display = 'none';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'rekapitulasi_penerimaan_kasir_rawat_inap';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5});
            $('popup_div1').popup.show();
            document.getElementById('form1').action='Rekapitulasi_Penerimaan_Kasir_Rawat_Inap_KSO.php';
        }
		function popupReport18(p)
		{
			showTime(0);
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
			document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'none';
			document.getElementById('rwKasirAll').style.display = 'none';
            document.getElementById('rwNamaKasir').style.display = 'none';
            document.getElementById('rwStatusPas').style.display = 'none';
			document.getElementById('rwStatusPasNonUmum').style.display = 'none';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'Rekapitulasi_Penerimaan_RSUD_PAV';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5});
            $('popup_div1').popup.show();
            document.getElementById('form1').action='Rekapitulasi_Penerimaan_RSUD_PAV.php?tipe='+p;
		}
		function popupReport19()
        {
			showTime(0);
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'table-row';
			document.getElementById('rwKasirAll').style.display = 'none';
            document.getElementById('rwNamaKasir').style.display = 'table-row';
            document.getElementById('rwStatusPas').style.display = 'none';
			document.getElementById('rwStatusPasNonUmum').style.display = 'none';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'setoran_PenerimaanKasir';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5});
            $('popup_div1').popup.show();
            document.getElementById('form1').action='setoran_PenerimaanKasir.php';
        }
		
		function popupReport20()
        {
			showTime(0);
			isiCombo1('TmpLayanan',document.getElementById('JnsLayanan').value);
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'table-row';
            document.getElementById('rwTmpLay').style.display = 'table-row';
            document.getElementById('rwStatusPas').style.display = 'none';
			document.getElementById('rwStatusPasNonUmum').style.display = 'table-row';
            document.getElementById('rwKasir').style.display = 'none';
			document.getElementById('rwKasirAll').style.display = 'none';
            document.getElementById('rwNamaKasir').style.display = 'none';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'lap_penerimaan_iur';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5});
            $('popup_div1').popup.show();
            $('popup_div1').scrollTo();
            document.getElementById('form1').action='lap_penerimaan_iur.php';
        }
		
		function popupReport21()
        {
			showTime(0);
			isiCombo1('TmpLayanan',document.getElementById('JnsLayanan').value);
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'table-row';
            document.getElementById('rwTmpLay').style.display = 'table-row';
            document.getElementById('rwStatusPas').style.display = 'table-row';
			document.getElementById('rwStatusPasNonUmum').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'none';
			document.getElementById('rwKasirAll').style.display = 'none';
            document.getElementById('rwNamaKasir').style.display = 'none';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'lap_piutang';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5});
            $('popup_div1').popup.show();
			$('popup_div1').scrollTo();
            document.getElementById('form1').action='lap_piutang.php';
        }
		
		function popupReport22()
        {
			showTime(1);
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            document.getElementById('rwStatusPas').style.display = 'none';
			document.getElementById('rwStatusPasNonUmum').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'table-row';
			document.getElementById('rwKasirAll').style.display = 'none';
			document.getElementById('cmbKasir2').disabled=false;
            document.getElementById('rwNamaKasir').style.display = 'table-row';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'PenerimaanKasir';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5});
            $('popup_div1').popup.show();
            document.getElementById('form1').action='PenerimaanKasir_new.php';
        }
		
		function popupReport23()
        {
			showTime(1);
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            document.getElementById('rwStatusPas').style.display = 'none';
			document.getElementById('rwStatusPasNonUmum').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'table-row';
			document.getElementById('rwKasirAll').style.display = 'none';
			document.getElementById('cmbKasir2').disabled=false;
            document.getElementById('rwNamaKasir').style.display = 'table-row';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'SetoranPenerimaanKasir';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5});
            $('popup_div1').popup.show();
            document.getElementById('form1').action='SetoranPenerimaanKasir_new.php';
        }
		
		function popupReport24()
        {
			showTime(1);
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            document.getElementById('rwStatusPas').style.display = 'table-row';
			document.getElementById('rwStatusPasNonUmum').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'none';
			document.getElementById('rwKasirAll').style.display = 'table-row';
			document.getElementById('cmbKasir2').disabled=false;
            document.getElementById('rwNamaKasir').style.display = 'none';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'pasien_krs';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5});
            $('popup_div1').popup.show();
            document.getElementById('form1').action='pasien_krs.php';
        }
		
		function popupReport25()
        {
			showTime(1);
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            document.getElementById('rwStatusPas').style.display = 'table-row';
			document.getElementById('rwStatusPasNonUmum').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'none';
			document.getElementById('rwKasirAll').style.display = 'table-row';
			document.getElementById('cmbKasir2').disabled=false;
            document.getElementById('rwNamaKasir').style.display = 'none';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'pasien_krs2';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5});
            $('popup_div1').popup.show();
            document.getElementById('form1').action='pasien_krs2.php';
        }
		
		function popupReport26()
        {
			showTime(1);
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            document.getElementById('rwStatusPas').style.display = 'table-row';
			document.getElementById('rwStatusPasNonUmum').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'none';
			document.getElementById('rwKasirAll').style.display = 'none';
			document.getElementById('cmbKasir2').disabled=false;
            document.getElementById('rwNamaKasir').style.display = 'none';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'pasien_stlhkrs';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5});
            $('popup_div1').popup.show();
            document.getElementById('form1').action='pasien_stlhkrs.php';
        }
		
		function popupReport27()
        {
			showTime(1);
			document.getElementById('st_setor').value = '0';
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            document.getElementById('rwStatusPas').style.display = 'table-row';
			document.getElementById('rwStatusPasNonUmum').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'table-row';
			document.getElementById('rwKasirAll').style.display = 'none';
			document.getElementById('cmbKasir2').disabled=false;
            document.getElementById('rwNamaKasir').style.display = 'table-row';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'PenerimaanKasirAk';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5});
            $('popup_div1').popup.show();
            document.getElementById('form1').action='PenerimaanKasir_new_ak.php';
        }
		
		function popupReport27a()
        {
			showTime(1);
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            document.getElementById('rwStatusPas').style.display = 'table-row';
			document.getElementById('rwStatusPasNonUmum').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'table-row';
			document.getElementById('rwKasirAll').style.display = 'none';
			document.getElementById('cmbKasir2').disabled=false;
            document.getElementById('rwNamaKasir').style.display = 'table-row';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'PenerimaanKasirAk';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5});
            $('popup_div1').popup.show();
            document.getElementById('form1').action='PenerimaanKasir_new_ak_setoran.php';
        }
		
		function popupReport27b()
        {
			showTime(1);
			document.getElementById('st_setor').value = '1';
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            document.getElementById('rwStatusPas').style.display = 'table-row';
			document.getElementById('rwStatusPasNonUmum').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'table-row';
			document.getElementById('rwKasirAll').style.display = 'none';
			document.getElementById('cmbKasir2').disabled=false;
            document.getElementById('rwNamaKasir').style.display = 'table-row';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'PenerimaanKasirAk';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5});
            $('popup_div1').popup.show();
            document.getElementById('form1').action='PenerimaanKasir_new_ak.php';
        }
		
		function popupReport28()
        {
			showTime(1);
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            document.getElementById('rwStatusPas').style.display = 'table-row';
			document.getElementById('rwStatusPasNonUmum').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'table-row';
			document.getElementById('rwKasirAll').style.display = 'none';
			document.getElementById('cmbKasir2').disabled=false;
            document.getElementById('rwNamaKasir').style.display = 'table-row';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'PendapatanNonTunaiKasirAk';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5});
            $('popup_div1').popup.show();
            document.getElementById('form1').action='PendapatanKasir_NonTunai_new_ak.php';
        }
		function popupReport29()
        {
			showTime(1);
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            document.getElementById('rwStatusPas').style.display = 'table-row';
			document.getElementById('rwStatusPasNonUmum').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'table-row';
			document.getElementById('rwKasirAll').style.display = 'none';
			document.getElementById('cmbKasir2').disabled=false;
            document.getElementById('rwNamaKasir').style.display = 'table-row';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'PendapatanTunaiNonTunaiKasirAk';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5});
            $('popup_div1').popup.show();
            document.getElementById('form1').action='PenerimaanKasir_Tunai_NonTunai_new_ak.php';
        }
		
		function popupReport30()
        {
			showTime(1);
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            document.getElementById('rwStatusPas').style.display = 'table-row';
			document.getElementById('rwStatusPasNonUmum').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'table-row';
			document.getElementById('rwKasirAll').style.display = 'none';
			document.getElementById('cmbKasir2').disabled=false;
            document.getElementById('rwNamaKasir').style.display = 'table-row';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'PenerimaanKasirAk';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5});
            $('popup_div1').popup.show();
            document.getElementById('form1').action='PenerimaanKasir_new_ak_rekap.php';
			document.getElementById('trInstansi').style.display = 'table-row';
        }
		
		function popupReport31()
        {
			showTime(1);
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            document.getElementById('rwStatusPas').style.display = 'table-row';
			document.getElementById('rwStatusPasNonUmum').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'table-row';
			document.getElementById('rwKasirAll').style.display = 'none';
			document.getElementById('cmbKasir2').disabled=false;
            document.getElementById('rwNamaKasir').style.display = 'table-row';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'PendapatanNonTunaiKasirAk';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5});
            $('popup_div1').popup.show();
            document.getElementById('form1').action='PendapatanKasir_NonTunai_new_ak_rekap.php';
			document.getElementById('trInstansi').style.display = 'table-row';
        }
		function popupReport32()
        {
			showTime(1);
			document.getElementById('rwJnsLayInap').style.display = 'none';
			document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            document.getElementById('rwStatusPas').style.display = 'table-row';
			document.getElementById('rwStatusPasNonUmum').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'table-row';
			document.getElementById('rwKasirAll').style.display = 'none';
			document.getElementById('cmbKasir2').disabled=false;
            document.getElementById('rwNamaKasir').style.display = 'table-row';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'PendapatanTunaiNonTunaiKasirAk';
			document.getElementById('trInstansi').style.display = 'table-row';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5});
            $('popup_div1').popup.show();
            document.getElementById('form1').action='PenerimaanKasir_Tunai_NonTunai_new_ak_rekap.php';
        }

        function popupReport33()
        {
            showTime(0);
            document.getElementById('rwJnsLayInap').style.display = 'none';
            document.getElementById('rwTmpLayInap').style.display = 'none';
            document.getElementById('rwJnsLay').style.display = 'none';
            document.getElementById('rwTmpLay').style.display = 'none';
            document.getElementById('rwKasir').style.display = 'table-row';
            document.getElementById('rwKasirAll').style.display = 'none';
            document.getElementById('cmbKasir2').disabled=false;
            document.getElementById('rwNamaKasir').style.display = 'table-row';
            document.getElementById('rwStatusPas').style.display = 'none';
            document.getElementById('rwStatusPasNonUmum').style.display = 'none';
            document.getElementById('rwKasir2').style.display = 'none';
            document.getElementById('form1').target = 'LaporanKwitansiSementaraPcr';
            new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5});
            $('popup_div1').popup.show();
            document.getElementById('form1').action='LaporanKwitansiSementaraPcr.php';
        }
    </script>
</html>
<script>
jQuery(document).ready(function(){
	jQuery("#txtJam1").mask("00:00");
	jQuery("#txtJam2").mask("00:00");
});
</script>