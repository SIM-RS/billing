<?php
	session_start();
	include "../sesi.php";
	$userId = $_SESSION['userId'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css">
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

<title>EKSEKUTIF SUMMARY</title>
</head>

<body>
    
<script>
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
	include("report_form.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
    $date_skr=explode('-',$date_now);
?>
<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
	<tr>
		<td height="30">&nbsp;EKSEKUTIF SUMMARY</td>
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
						 	<li><a href="javascript:void(0)" onclick="popupReport1();variabel=1;tipe=0;change()">REKAPITULASI DATA KUNJUNGAN PASIEN</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport2();variabel=1;tipe=0;change()">REKAPITULASI DATA PASKA KUNJUNGAN PASIEN</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport6();variabel=1;tipe=0;change()">REKAPITULASI DATA KUNJUNGAN PASIEN LAMA BARU</a></li>
							<!--li><a href="javascript:void(0)" onclick="popupReport4();variabel=1;tipe=0;change()">REKAPITULASI DATA KEGIATAN BERDASAR CARA BAYAR</a></li-->
							<li><a href="javascript:void(0)" onclick="popupReport5();variabel=1;tipe=1;change()">POLA 10 BESAR PENYAKIT</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport11();variabel=1;tipe=2;change()">KINERJA INSTALASI RAWAT INAP [PASIEN MENINGGAL]</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport7();variabel=1;tipe=0;change()">REKAPITULASI DATA KUNJUNGAN PASIEN BERSADARKAN TEMPAT LAYANAN</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport3();variabel=1;tipe=0;change()">REKAPITULASI DATA KUNJUNGAN PASIEN BERDASARKAN JENIS PEMBAYARAN</a></li>
							<!--li><a href="javascript:void(0)" onclick="popupReport8();variabel=1;tipe=0;change()">POLA PENYAKIT 10 BESAR</a></li-->
							<!--li><a href="javascript:void(0)" onclick="popupReport9();variabel=1;tipe=1;change()">Kegiatan Rawat Inap</a></li-->
							<!--li><a href="javascript:void(0)" onclick="popupReport10();variabel=1;tipe=1;change()">POLA PENYAKIT TERBANYAK BERDASARKAN PENJAMIN PASIEN</a></li-->
							<!--li><a href="javascript:void(0)" onclick="popupReport12();variabel=1;tipe=2;change()">KINERJA INSTALASI RAWAT INAP BERDASAR CARA BAYAR</a></li-->
							<!--li><a href="javascript:void(0)" onclick="popupReport13();variabel=0;tipe=3;change()">Kinerja Instalasi Bedah Sentral Pasien Rawat Inap Non Pavilyun Berdasar Dokter Operator</a></li-->
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
	<td>&nbsp;</td>
  </tr>
</table>
</div>
</body>
<script>
	isiCombo('JnsLayanan','','','',showTmpLay);
	function showTmpLay(){
		isiCombo1('TmpLayanan',document.getElementById('JnsLayanan').value);
	}
	isiCombo('JnsLayananInapSaja','','','',showTmpInap);
	function showTmpInap(){
		isiCombo1('TmpLayananInapSaja',document.getElementById('JnsLayananInapSaja').value);
	}
	isiCombo('cmbJnsPenunjang','','','',showTmpTunjang);
	function showTmpTunjang(){
		isiCombo('cmbTmpPenunjang',document.getElementById('cmbJnsPenunjang').value);
	}
	isiCombo1('StatusPas');
	
	function isiCombo(id,val,defaultId,targetId,evloaded)
	{
		if(targetId=='' || targetId==undefined)
		{
			targetId=id;
		}
			Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,id,'','GET',evloaded);
	}
	
	function isiCombo1(id,val,defaultId,targetId,evloaded)
	{
		if(targetId=='' || targetId==undefined)
		{
			targetId=id;
		}
			Request('../combo_utils.php?id='+id+'&value='+val+'&all=1&defaultId='+defaultId,id,'','GET',evloaded);
	}
	
	function ubah()
	{
		if(document.getElementById('cmbWaktu').value=="Harian")
		{
			document.getElementById('tglAwal').value = document.getElementById('tglAwal2').value;
			document.getElementById('tglAkhir').value = document.getElementById('tglAwal2').value;
		}
	}
	
	function setBln(val)
	{
		var thSkr='<?php echo $date_skr[2];?>';
		var thAwal=thSkr*1-5;
		var thAkhir=thSkr*1+6;
		for(thAwal;thAwal<thAkhir;thAwal++)
		{				
			document.getElementById('cmbThn').innerHTML = 
			document.getElementById('cmbThn').innerHTML+'<option>'+thAwal+'</option>';
		}
		document.getElementById('cmbBln').value = '<?php echo $date_skr[1];?>';
		document.getElementById('cmbThn').value = thSkr;
		if(val=='Harian')
		{
			document.getElementById('trBulan').style.display = "none";
            document.getElementById('trTahunan').style.display = "none";
			document.getElementById('trPeriode').style.display = "none";
			document.getElementById('trHarian').style.display = "block";
		}
		else if(val=='Bulanan')
		{
			document.getElementById('trBulan').style.display = "none";
            document.getElementById('trTahunan').style.display = "block";
			document.getElementById('cmbBln').disabled= false;
			document.getElementById('trPeriode').style.display = "none";
			document.getElementById('trHarian').style.display = "none";
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
			
		}
		else if(val=='Rentang Waktu')
		{
			document.getElementById('trPeriode').style.display = "block";
			document.getElementById('trBulan').style.display = "none";
			document.getElementById('trHarian').style.display = "none";
            document.getElementById('trTahunan').style.display = "none";
		}
        else if(val=='Tahunan')
		{
			document.getElementById('trPeriode').style.display = "none";
			document.getElementById('trBulan').style.display = "none";
            document.getElementById('cmbBln').disabled= true;
			document.getElementById('trHarian').style.display = "none";
            document.getElementById('trTahunan').style.display = "block";
		}
		else
		{
			document.getElementById('trPeriode').style.display = "none";
			document.getElementById('trBulan').style.display = "none";
			document.getElementById('cmbBln').disabled= true;
			document.getElementById('trHarian').style.display = "none";
            document.getElementById('trTahunan').style.display = "none";
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
	
	var variabel;
	function change()
	{
		if(variabel==1){
			isiCombo1('TmpLayanan',document.getElementById('JnsLayanan').value);
			isiCombo1('TmpLayananInapSaja',document.getElementById('JnsLayananInapSaja').value);
			isiCombo1('cmbTmpPenunjang',document.getElementById('cmbJnsPenunjang').value);
		}else{
			isiCombo('TmpLayanan',document.getElementById('JnsLayanan').value);
			isiCombo('TmpLayananInapSaja',document.getElementById('JnsLayananInapSaja').value);
			isiCombo('cmbTmpPenunjang',document.getElementById('cmbJnsPenunjang').value);
		}
		if(tipe==0){
			document.getElementById('trJnsLay').style.display = 'table-row';
			document.getElementById('rwTmpLay').style.display = 'table-row';
			document.getElementById('trKso').style.display = 'none';
			document.getElementById('trJnsInap').style.display = 'none';
			document.getElementById('rwTmpInap').style.display = 'none';
			document.getElementById('trJnsTunjang').style.display = 'none';
			document.getElementById('rwTmpTunjang').style.display = 'none';
		}else if(tipe==1){
			document.getElementById('trJnsLay').style.display = 'table-row';
			document.getElementById('rwTmpLay').style.display = 'table-row';
			document.getElementById('trKso').style.display = 'table-row';
			document.getElementById('trJnsInap').style.display = 'none';
			document.getElementById('rwTmpInap').style.display = 'none';
			document.getElementById('trJnsTunjang').style.display = 'none';
			document.getElementById('rwTmpTunjang').style.display = 'none';
		}
		else{
			document.getElementById('trJnsLay').style.display = 'none';
			document.getElementById('rwTmpLay').style.display = 'none';
			document.getElementById('trKso').style.display = 'none';
			document.getElementById('trJnsInap').style.display = 'table-row';
			document.getElementById('rwTmpInap').style.display = 'table-row';
			document.getElementById('trJnsTunjang').style.display = 'none';
			document.getElementById('rwTmpTunjang').style.display = 'none';
		}/* 
		else{
			document.getElementById('trJnsLay').style.display = 'none';
			document.getElementById('rwTmpLay').style.display = 'none';
			document.getElementById('trKso').style.display = 'none';
			document.getElementById('trJnsInap').style.display = 'none';
			document.getElementById('rwTmpInap').style.display = 'none';
			document.getElementById('trJnsTunjang').style.display = 'table-row';
			document.getElementById('trTmpTunjang').style.display = 'table-row';
		}
		 */
	}
	
	function popupReport1()
	{
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='kunjungan.php';
	}
	
	function popupReport2()
	{
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='data_paska.php';
	}
	
	function popupReport3()
	{
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='kunjungan_jnsbayar.php';
	}
	
	function popupReport4()
	{
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='kunjungan_carabayar.php';
	}
		
	function popupReport5()
	{
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='10besarpenyakit.php';
	}
	
	function popupReport6()
	{
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='kunjungan_lamabaru.php';
	}
	
	function popupReport7()
	{
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='kunjungan_tmplay.php';
	}
	
	function popupReport8()
	{
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='pola_penyakit.php';
	}
	
	function popupReport9()
	{
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='kegiatan.php';
	}
	
	function popupReport10()
	{
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='penyakit_kso.php';
	}
	
	function popupReport11()
	{
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='kinerja_inap.php';
	}
	
	function popupReport12()
	{
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='kinerja_inapbayar.php';
	}
	
	function popupReport13()
	{
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='kinerja_ok.php';
	}
</script>
</html>