<?php
	include '../secured_sess.php';
	$userId = $_SESSION['userId'];
	include("../koneksi/konek.php");
	include("../header.php");
	include("report_form.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$date_skr=explode('-',$date_now);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <title>.: Laporan Keuangan :.</title>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
        <link type="text/css" href="../menu.css" rel="stylesheet" />
        <script type="text/javascript" src="../jquery.js"></script>
        <script type="text/javascript" src="../menu.js"></script>
        <!--link type="text/css" rel="stylesheet" href="../theme/mod.css"-->
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/ajax.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
	<link rel="stylesheet" type="text/css" href="../theme/popup.css" />
	<script type="text/javascript" src="../theme/prototype.js"></script>
	<script type="text/javascript" src="../theme/effects.js"></script>
	<script type="text/javascript" src="../theme/popup.js"></script>
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
<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
	<tr>
		<td height="30">&nbsp;LAPORAN KEUANGAN</td>
	</tr>
</table>
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center" height="450" bgcolor="#EAEFF3">
	<tr>
		<td width="15%" height="50">&nbsp;</td>
		<td width="70%">&nbsp;</td>
		<td width="15%">&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	  <td valign="top">
			<table width="100%" border="0" cellpadding="2" cellspacing="5" align="center" style="border:solid 5px #00FFFF;background-color:#CCFFFF;font-size:14px">
				<tr>
					<td style="line-height:30px; padding-left:30px;">
						 <ol>
							<li><a href="javascript:void(0)" onclick="popupReport1()">Laporan Pendapatan</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport2()">Laporan Pengeluaran</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport3()">Laporan Pendapatan Per Jenis Transaksi</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport4()">Laporan Rekapitulasi Pendapatan Harian</a></li>
							<li><a href="javascript:void(0)" onclick="popupReport5()">Laporan Rekapitulasi Pendapatan Bulanan</a></li>
						 </ol>
					</td>
				</tr>
			</table>
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
                    <td colspan="3">
                        <?php include("../footer.php");?>
                    </td>
                </tr>
</table>
</div>
</body>
<script>
	/*isiCombo('JnsLayNonInap','','','',showTmpLay);
	function showTmpLay(){
		isiCombo1('TmpLayananBukanInap',document.getElementById('JnsLayNonInap').value);
	}
	isiCombo('JnsLayananDenganInap','','','',showTmpLayInap);
	function showTmpLayInap(){
		isiCombo1('TmpLayananInapSaja',document.getElementById('JnsLayananDenganInap').value);
	}
	*/
	isiCombo('cmbJnsPend');
	
	function isiCombo(id,val,defaultId,targetId,evloaded)
	{
		if(targetId=='' || targetId==undefined)
		{
			targetId=id;
		}
			Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,id,'','GET',evloaded);
	}
	
	/*function isiCombo1(id,val,defaultId,targetId,evloaded)
	{
		if(targetId=='' || targetId==undefined)
		{
			targetId=id;
		}
			Request('../combo_utils.php?id='+id+'&value='+val+'&all=1&defaultId='+defaultId,id,'','GET',evloaded);
	}*/
	
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
		if(val=='Harian')
		{
			document.getElementById('trBulan').style.display = "none";
			document.getElementById('trPeriode').style.display = "none";
			//document.getElementById('tglAwal').value = '<?=$date_now?>';
			//document.getElementById('tglAkhir').value = '<?=$date_now?>';
			document.getElementById('trHarian').style.display = "block";
		}
		else if(val=='Bulanan')
		{
			document.getElementById('trBulan').style.display = "block";
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
			
		}
		else if(val=='Rentang Waktu')
		{
			document.getElementById('trPeriode').style.display = "block";
			document.getElementById('trBulan').style.display = "none";
			document.getElementById('trHarian').style.display = "none";
		}
		else
		{
			document.getElementById('trPeriode').style.display = "none";
			document.getElementById('trBulan').style.display = "none";
			document.getElementById('trHarian').style.display = "none";
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
	
	function popupReport1()
	{
		document.getElementById('rwJnsTransaksi').style.display = "none";
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='pendapatan.php';
	}
	
	function popupReport2()
	{
		document.getElementById('rwJnsTransaksi').style.display = "none";
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='pengeluaran.php';
	}
	
	function popupReport3()
	{
		document.getElementById('rwJnsTransaksi').style.display = "table-row";
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='pendJenis.php';
	}
	
	function popupReport4()
	{
		document.getElementById('rwJnsTransaksi').style.display = "table-row";
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='rekapPendHarian.php';
	}
	
	function popupReport5()
	{
		document.getElementById('rwJnsTransaksi').style.display = "table-row";
		new Popup('popup_div1',null,{modal:true,position:'center',duration:0.5})
		$('popup_div1').popup.show();
		document.getElementById('form1').action='rekapPendBulanan.php';
	}
</script>
</html>