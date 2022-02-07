<?php
	session_start();
	include("../koneksi/konek.php");
	$namaRS = $_SESSION["namaP"];
	$alamatRS = $_SESSION["alamatP"];
	$kotaRS = $_SESSION["kotaP"];
	$iduser = $_SESSION["iduser"];
	$tglact=gmdate('d/m/Y H:i:s',mktime(date('H')+7));
	$tglNow=gmdate('d-m-Y',mktime(date('H')+7));
	

	$no_bayar=$_GET['no_bayar'];

	
	function kekata($x) {
		$x = abs($x);
		$angka = array("", "satu", "dua", "tiga", "empat", "lima",
		"enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($x <12) {
		  $temp = " ". $angka[$x];
		} else if ($x <20) {
		  $temp = kekata($x - 10). " belas";
		} else if ($x <100) {
		  $temp = kekata($x/10)." puluh". kekata($x % 10);
		} else if ($x <200) {
		  $temp = " seratus" . kekata($x - 100);
		} else if ($x <1000) {
		  $temp = kekata($x/100) . " ratus" . kekata($x % 100);
		} else if ($x <2000) {
		  $temp = " seribu" . kekata($x - 1000);
		} else if ($x <1000000) {
		  $temp = kekata($x/1000) . " ribu" . kekata($x % 1000);
		} else if ($x <1000000000) {
		  $temp = kekata($x/1000000) . " juta" . kekata($x % 1000000);
		} else if ($x <1000000000000) {
		  $temp = kekata($x/1000000000) . " milyar" . kekata(fmod($x,1000000000));
		} else if ($x <1000000000000000) {
		  $temp = kekata($x/1000000000000) . " trilyun" . kekata(fmod($x,1000000000000));
		}      
		return $temp;
	}
	function terbilang($x, $style=4) {
		if($x<0) {
		  $hasil = "minus ". trim(kekata($x));
		} else {
		  $hasil = trim(kekata($x));
		}      
		switch ($style) {
		  case 1:
			  $hasil = strtoupper($hasil);
			  break;
		  case 2:
			  $hasil = strtolower($hasil);
			  break;
		  case 3:
			  $hasil = ucwords($hasil);
			  break;
		  default:
			  $hasil = ucfirst($hasil);
			  break;
		}      
		return $hasil;
	}
?>
<html>
<head>
	<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<script type="text/JavaScript">
		var applet = null;
		
		function jzebraReady() {}

		function jzebraDoneFinding() {}
		
		function jzebraDonePrinting() {
		   if (applet.getException() != null) {
			  return alert('Error:' + applet.getExceptionMessage());
		   }
		   window.close();
		}
		
		function deteksiPrinter() {	    
			 applet = document.jzebra;
			 if (applet != null) {           
				applet.findPrinter();
				applet.getPrinter();
				applet.setEncoding("UTF-8");
			 }
		}
		
			
	</script>
	<style type="text/css">
		#kott{
			border:1px solid #000;
			padding:5px;
			position:absolute;
			top:12px;
			right:5px;
		}
		#content{
			width:550px;
		}
		#head-content{
			width:100%;
			border-bottom:1px solid #000;
			margin-bottom:5px;
		}
		#head-content-detil{
			width:100%;
			margin-bottom:5px;
		}
		#head-content-left, #head-content-right{
			width:50%;
			max-width:50%;
			margin-bottom:5px;
		}
		#head-content-left{
			float:left;
		}
		#head-content-right{
			float:right;
			text-align:right;
		}
		.clear{
			clear:both;
		}
		#head-table{
			border-collapse:collapse;
			margin-bottom:5px;
			padding:0px;
			width:100%;
		}
		.border{
			border-top:1px solid #000;
			border-bottom:1px solid #000;
		}
		.border-top{
			border-top:1px solid #000;
		}
		.border-bottom{
			border-bottom:1px solid #000;
		}
		.border-dashed{
			border-bottom:1px dashed #000;
		}
	</style>
</head>
<body>
<!--body onLoad="deteksiPrinter()">
	<applet name="jzebra" code="jzebra.PrintApplet.class" archive="./jzebra.jar" width="0px" height="0px"></applet-->

<div id="idArea" style="display:block;">
		<?php				
			$sByrC = "SELECT ku.NO_BAYAR, DATE_FORMAT(ku.TGL_BAYAR, '%d-%m-%Y %H:%i:%s') TGL_BAYAR, ku.USER_ID,
						  IF(ku.IS_AKTIF = 1, u.username, peg.nama) username,ap.NAMA_PASIEN, ap.NO_PASIEN,ap.ALAMAT,
						  ku.`TOTAL_HARGA` total_harga,ku.`BAYAR` bayar, ku.`KEMBALI` kembali 
						FROM a_kredit_utang ku
						INNER JOIN a_penjualan ap
						   ON ap.NO_PENJUALAN = ku.FK_NO_PENJUALAN
						  AND ap.UNIT_ID = ku.UNIT_ID
						  AND ap.NO_KUNJUNGAN = ku.NO_PELAYANAN
						  AND ap.NO_PASIEN = ku.NORM
						LEFT JOIN a_user u 
						   ON u.kode_user = ku.USER_ID 
						LEFT JOIN bangil_billing.b_ms_pegawai peg 
						   ON peg.id = ku.USER_ID 
						WHERE ku.NO_BAYAR = '{$no_bayar}'
						GROUP BY ku.NO_BAYAR";
			//echo $sByrC;
			$qByrC = mysqli_query($konek,$sByrC);
			$dByrC = mysqli_fetch_array($qByrC);
		?>	
	<div id="content">
		<div id="head-content">
	
			<table id="head-table">
				<td><?php echo $namaRS; ?><br><?php echo $alamatRS;?> - <?php echo $kotaRS; ?></td>
				<td valign="bottom" align="right"><?php //echo $apname; ?></td>
			</table>
		</div>
		<div id="head-content-detil">
			<table id="head-table">
				<tr>
					<td width="168">No. Pembayaran</td>
					<td>:</td>
					<td><?php echo $dByrC['NO_BAYAR']; ?></td>
				</tr>
				<tr>
					<td width="168">Tgl. Pembayaran</td>
					<td>:</td>
					<td><?php echo $dByrC['TGL_BAYAR']." / ".$dByrC['username']; ?></td>
				</tr>
				<tr>
					<td>Pasien/No. RM</td>
					<td>:</td>
					<td><?php echo $dByrC['NAMA_PASIEN']." / ".$dByrC['NO_PASIEN']; ?></td>
				</tr>
				<tr>
					<td>Alamat</td>
					<td>:</td>
					<td><?php echo $dByrC['ALAMAT']; ?></td>
				</tr>
			
			</table>
			
			<table id="head-table">
				
			
				<tr align="right" class="border-top"> 
					<td colspan="3">Total Biaya Obat:</td>
					<td><?php echo number_format($dByrC['total_harga'],0,",","."); ?>&nbsp;&nbsp;</td>
				</tr>
			
				<tr align="right" class="border-top">
					<td colspan="3">Nilai Pembayaran :</td>
					<td><?php echo number_format($dByrC['bayar'],0,",","."); ?>&nbsp;&nbsp;</td>
				</tr>
				<tr align="right" class='border-bottom'>
					<td colspan="3">Kembali :</td>
					<td><?php echo number_format($dByrC['kembali'],0,",","."); ?>&nbsp;&nbsp;</td>
				</tr>
				
			</table>
			
		
	
		
			<table id="head-table">
		
				<tr>
					<td colspan="3">- Bukti Pembayaran Ini Juga Berlaku Sebagai Kwitansi</td>
				</tr>
			</table>
		</div>
	</div>	  
</div>
	<script type="text/javascript">
		function hapusP(){
			if (confirm('Yakin Ingin Menghapus Data Penjualan ?')){
				var alasan = prompt("Masukkan Alasan Hapus Penjualan?", "");
				if (alasan != null) {
					hapuss.disabled=true;
					location='../transaksi/hapus_penjualan.php?no_jual=<?php echo $njual; ?>&no_pasien=<?php echo $no_pasien; ?>&idunit=<?php echo $idunit; ?>&tgl=<?php echo $tgl; ?>&iduser=<?php echo $iduser; ?>&iduser_jual=<?php echo $iduser_jual; ?>&alasan='+alasan;
				}
			}
		}
	</script>
	<div id="btn">
	<br>
	<table width="550" align="left">
	<tr>
		<td width="50%" align="left">
			<BUTTON type="button" onClick="document.getElementById('btn').style.display='none';window.print();/*window.printZebra();*/window.close();"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">Cetak</BUTTON>
		</td>
		<td width="50%" align="right">
		
			
			
		</td>
	</tr>
	</table>
	</div>
</body>
</html>