<?php
	session_start();
	include_once('../koneksi/konek.php');
	
	function currency($angka){
		$rupiah = number_format($angka,0,",",".");
		return $rupiah;
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
	
	$noKwitansi = $_REQUEST['noKwitansi'];
	$idunit = $_REQUEST['idunit'];
	$noJual = $_REQUEST['no_penjualan'];
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Cetak Kwitansi Pembayaran</title>
	<!--link rel="stylesheet" href="../theme/apotik.css" type="text/css" /-->
	<style type="text/css">
		body{
			font-family:Verdana,Arial,Helvetica,sans-serif;
		}
		.style1 { font-family: "Courier New", Courier, monospace; font-size:14px; }
		#kiri{
			width:90%;
			padding:10px;
			font-size:12px;
			text-align:center;
		}
		#kanan{
			width:40%;
		}
		#kanan table{
			font-size:12px;
			font-weight:bold;
		}
		#kanan table td{
			padding:3px;
		}
		#clear{
			clear:both;
		}
		.inputan{
			border:0px;
			background:#EAF0F0;
			font-weight:bold;
			letter-spacing:2px;
			text-align:right;
		}
		#kotak{
			border: 1px solid #000;
			padding:5px;
			font-weight:bold;
			display:inline-block;
			min-width:150px;
			text-align:right;
		}
	</style>
	<script type="text/javascript">
		function cetak(){
			document.getElementById('cetak').style.display = 'none';
			if(!window.print()){
				document.getElementById('cetak').style.display = 'inline-block';
			}
		}
	</script>
</head>
<body>
	<?php
		if($noKwitansi != ""){
			$sKwi = "SELECT 
					  ap.NO_PASIEN noRM, ap.NAMA_PASIEN, bp.NO_BAYAR no_bayar, ap.NO_PENJUALAN no_penjualan, 
					  IF(bp.BAYAR <> 0, bp.BAYAR, bp.BAYAR_UTANG) bayar,
					  bp.KEMBALI kembali, DATE_FORMAT( bp.TGL_BAYAR, '%d-%m-%Y / %H:%i:%s' ) tgl_byr, MONTH(bp.TGL_BAYAR) bulan,
					  DATE_FORMAT(bp.TGL_BAYAR, '%y') tahun, 
					  IFNULL(bp.TOTAL_HARGA,bp.BAYAR_UTANG) total_harga 
					FROM
					  a_kredit_utang bp 
					  INNER JOIN a_penjualan ap 
						ON ap.NO_PENJUALAN = bp.FK_NO_PENJUALAN 
						AND ap.UNIT_ID = bp.UNIT_ID
					WHERE bp.NO_BAYAR = '{$noKwitansi}'
					  AND bp.UNIT_ID = '{$idunit}'";
		} else {
			$sKwi = "SELECT 
					  ap.NO_PASIEN noRM, ap.NAMA_PASIEN, bp.NO_BAYAR no_bayar, ap.NO_PENJUALAN no_penjualan, 
					  IF(bp.BAYAR <> 0, bp.BAYAR, bp.BAYAR_UTANG) bayar,
					  bp.KEMBALI kembali, DATE_FORMAT( bp.TGL_BAYAR, '%d-%m-%Y / %H:%i:%s' ) tgl_byr, MONTH(bp.TGL_BAYAR) bulan,
					  DATE_FORMAT(bp.TGL_BAYAR, '%y') tahun, 
					  IFNULL(bp.TOTAL_HARGA,bp.BAYAR_UTANG) total_harga 
					FROM
					  a_kredit_utang bp 
					  INNER JOIN a_penjualan ap 
						ON ap.NO_PENJUALAN = bp.FK_NO_PENJUALAN 
						AND ap.UNIT_ID = bp.UNIT_ID 
					WHERE bp.FK_NO_PENJUALAN = '{$noJual}'
					  AND bp.UNIT_ID = '{$idunit}'";
			$noKwitansi = $noJual;
		}
		$qKwi = mysqli_query($konek,$sKwi);
		$dKwi = mysqli_fetch_array($qKwi);
		$tglCetakk=gmdate('d-m-Y H:i:s',mktime(date('H')+7));
	?>
	<table id="tblKwi" style="letter-spacing:1px; width:800px; padding:10px; background:#fff; font-size:12px;"><!-- border:1px dashed #000; -->
		<tr>
			<td colspan="5" align="right" style="font-style:italic; font-size:11px;"><?php echo $tglCetakk; ?></td>
		</tr>
		<tr>
			<th colspan="5" align="center" style="font-size:16px;" >Kwitansi Pembayaran Obat</th>
		</tr>
		<tr>
			<td colspan="5" align="right">&nbsp;</td>
		</tr>
		<tr>
			<td width="150px">No. Bukti</td>
			<td width="10px">:</td>
			<td colspan="3"><?php echo $noKwitansi; ?></td>
		</tr>
		<tr>
			<td width="150px">Tgl / Jam</td>
			<td width="10px">:</td>
			<td colspan="3"><?php echo $dKwi['tgl_byr']; ?></td>
		</tr>
		<tr>
			<td>No. RM</td>
			<td>:</td>
			<td colspan="3" ><?php echo $dKwi['noRM']; ?></td>
		</tr>
		<tr>
			<td>Terima dari</td>
			<td>:</td>
			<td colspan="3" ><?php echo $dKwi['NAMA_PASIEN']; ?></td>
		</tr>
		<tr>
			<td>Untuk Pembayaran</td>
			<td>:</td>
			<td colspan="3" >Pembelian Obat (<?php echo $dKwi['no_penjualan']; ?>)</td>
		</tr>
		<tr>
			<td>Terbilang</td>
			<td>:</td>
			<td colspan="3" style="font-style:italic;"><?php echo ucwords(terbilang($dKwi['total_harga'])); ?> Rupiah</td>
		</tr>
		<tr>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="5" align="left"><span id="kotak">Rp <?php echo currency($dKwi['total_harga']).",-"; ?></span></td>
			<!--td align="right" width="200px">Total Tagihan</td>
			<td>:</td>
			<td>Rp <?php echo currency($dKwi['total_harga']).",-"; ?></td-->
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td colspan="4">&nbsp;</td>
			<td align="center" width="250px" >Bangil, <?php $tglC = explode(" ",$tglCetakk); echo $tglC[0]; ?><br />Petugas
			<br />
			<br />
			<br />
			<br />
			( <?php echo $_SESSION['username']; ?> )
			</td>
		</tr>
		<!--tr>
			<td colspan="2"></td>
			<td align="right" >Bayar</td>
			<td>:</td>
			<td>Rp <?php echo currency($dKwi['bayar']).",-"; ?></td>
		</tr>
		<tr>
			<td colspan="2"></td>
			<td align="right" >Kembali</td>
			<td>:</td>
			<td>Rp <?php echo currency($dKwi['kembali']).",-"; ?></td>
		</tr-->
	</table>
	<button id="cetak" name="cetak" onClick="cetak()" ><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle"> Cetak Kwitansi</button>
</body>
</html>