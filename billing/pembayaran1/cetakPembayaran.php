<?php
	session_start();
	include '../koneksi/konek.php';
	include '../theme/numberConversion.php';
	//echo "aaaa";
	$_SESSION['nokwi'] += 1;
	
	$sKasirFarmasi="SELECT * FROM b_ms_reference WHERE stref=77";
	$qKasirFarmasi=mysql_query($sKasirFarmasi);
	$rwKasirFarmasi=mysql_fetch_array($qKasirFarmasi);
	$KasirFarmasi=$rwKasirFarmasi['aktif'];

	function currency($angka){
		$rupiah = number_format($angka,0,",",".");
		return $rupiah;
	}

	$kunjungan_id = $_GET['kunjungan_id'];
	$idbayar = $_GET['idbayar'];
	$userId = $_GET['idUser'];
	
	//to get officer's name
	$queryPetugas = "SELECT nama, DATE_FORMAT(NOW(), '%d-%m-%Y') AS tgl_now, TIME_FORMAT(NOW(), '%H:%i') AS time_now
						FROM b_ms_pegawai WHERE id = '{$userId}'";
	$rs = mysql_query($queryPetugas);
	$rowPetugas = mysql_fetch_array($rs);
	
	$query = "SELECT b.no_kwitansi, b.dibayaroleh, b.nilai, p.nama AS kasir, DATE_FORMAT(b.tgl,'%d %M %Y') AS tgl_bayar
				FROM b_bayar b 
				INNER JOIN b_ms_pegawai p ON p.id = b.user_act
			WHERE b.id = '{$idbayar}'";
    $rs = mysql_query($query);
	$row = mysql_fetch_array($rs);
	
	$sJdl = "SELECT ps.no_rm, ps.nama, kso.nama AS kso, ps.nama AS dibayaroleh,
					DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tgl,
					DATE_FORMAT(IFNULL(k.tgl_pulang, NOW()),'%d-%m-%Y') AS tgl_pulang 
				FROM b_kunjungan k 
				INNER JOIN b_ms_pasien ps ON ps.id = k.pasien_id
				INNER JOIN b_ms_kso kso ON kso.id = k.kso_id
			WHERE k.id = '{$kunjungan_id}'";
	$qJdl = mysql_query($sJdl);
	$rwJdl = mysql_fetch_array($qJdl);
	$no_kwitansi = $row['no_kwitansi'];
    $tgl = $rwJdl['tgl'];
    $tgl_pulang = $rwJdl['tgl_pulang'];
    $nama_pasien = $rwJdl['nama'];
	$nama_kso = $rwJdl['kso'];
	$no_rm = $rwJdl['no_rm'];
	if($row['dibayaroleh'] != ""){
		$dibayaroleh = $row['dibayaroleh'];
	} else {
		$dibayaroleh = $rwJdl['nama'];
	}
	
	$bayar = $row['nilai'];
	
	//=====Bilangan setelah koma=====
  	$sakKomane=explode(".",$bayar);
  	$koma=$sakKomane[1];
  	$koma=terbilang($koma,3);
  	if($sakKomane[1]<>"") $koma= "Koma ".$koma;
	$i=1;
?>
	<style type="text/css" media="all">
		.isi{  font-style:italic; }
		.turun{ word-wrap:break-word; white-space:pre-wrap; font-weight:bold; font-style:italic; width:80px; height:30px; }
		h2 { letter-spacing:10px; font-size:20px; font-weight:bold; text-align:center; margin-bottom:5px;}
		#tabel-isi td{ letter-spacing:1px; font-size:14px; }
		img{ float:left; width:80px; margin-right:10px; }
		.kiri{padding-left:10px;}
		.nama{  }
	</style>
	<title>BUKTI PEMBAYARAN</title>
	<table width="559" id="tabel-isi" style="border:1px dashed #000;">
		<tr>
			<td width="9" rowspan="14">&nbsp;</td>
			<td colspan="5" align="center"><h2>BUKTI PEMBAYARAN</h2></td>
		</tr>
		<tr id="heading-container">
			<td width="142" class="kiri">&nbsp;</td>
			<td width="10">&nbsp;</td>
			<td colspan="3">&nbsp;</td>
		</tr>
		<tr id="heading-container">
			<td width="142" class="kiri">No. Bukti</td>
			<td width="10">:</td>
			<td colspan="3" style="padding-left:10px; font-weight:bold;"><?=$no_kwitansi?></td>
		</tr>
		<tr>
			<td class="kiri" >Telah Terima Dari</td>
			<td>:</td>
			<td colspan="3" class="nama" style="padding-left:10px;"><?=$dibayaroleh?></td>
		</tr>
		<tr>
			<td class="kiri" >Uang Sebanyak</td>
			<td >:</td>
			<td colspan="3" class="isi" style="padding-left:10px;" >
				<?="# ".ucwords(terbilang($bayar)." ".$koma." Rupiah #")?>
			</td>
		</tr>
		<tr>
			<td class="kiri" >Untuk Pembayaran</td>
			<td>:</td>
			<td colspan="3" class="isi" style="padding-left:10px;"><?="Biaya Pelayanan Kesehatan"?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td width="92" class="isi" style="padding-left:10px; font-style:normal"><?="Nama Pasien"?></td>
            <td colspan="2" style="font-weight:bold;">: <?php echo $nama_pasien; ?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td class="isi" style="padding-left:10px; font-style:normal"><?="No RM"?></td>
            <td colspan="2" style="font-weight:bold;">: <?php echo $no_rm; ?></td>
		</tr>
		<tr>
			<td class="kiri" style=""></td>
			<td colspan="4">&nbsp;</td>
		</tr>
		<tr>
			<td height="25" colspan="2" class="kiri" style="font-weight:bold">Rp. <?=currency($bayar).",-&nbsp;&nbsp;&nbsp;";?></td>
            <td>&nbsp;</td>
            <td width="62">&nbsp;</td>
			<td width="216" align="center" ><?="Medan, ".$row['tgl_bayar']?></td>
		</tr>
        <tr>
			<td colspan="2"></td>
		  <td colspan="3" align="center" >&nbsp;</td>
		</tr>
        <tr>
			<td colspan="5" style="font-family:Helvetica; font-size:11px; letter-spacing:0px;">
				Yang Mencetak : <?php echo $rowPetugas['nama']; ?>
			</td>
			
		</tr>
		<tr>
			<td colspan="3" style="font-family:Helvetica; font-size:11px; letter-spacing:0px;">
				Tgl <?php echo $rowPetugas['tgl_now']; ?> Jam <?php echo $rowPetugas['time_now']; ?>
			</td>
            <td>&nbsp;</td>
			<td align="center"><?="( ".$row['kasir']." )"?></td>
		</tr>
	</table>
    <table width="619" id="tabel-isi" style="border:0px;">
    <tr id="trTombol">
       	<td colspan="3" class="noline" align="center">
		<input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
        <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
      	</td>
    </tr>
    </table>
<script>
function cetak(tombol){
	tombol.style.visibility='hidden';
	if(tombol.style.visibility=='hidden'){
	window.print();
	window.close();
	}
}
</script>