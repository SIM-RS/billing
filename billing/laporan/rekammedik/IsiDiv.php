<?php
//session_start();
//include("../../sesi.php");
?>
<?php
include("../../koneksi/konek.php");
$JenisLayanan = $_REQUEST['jnsLay'];
$TempatLayanan = $_REQUEST['tmptLay'];
$StatusPasien = $_REQUEST['stsPas'];
$sqlDiv = "SELECT (SELECT nama FROM b_ms_unit WHERE id = '".$JenisLayanan."') AS Jenis, 
			(SELECT nama FROM b_ms_unit WHERE id = '".$TempatLayanan."') AS Tempat,
			(SELECT nama FROM b_ms_kso WHERE id = '".$StatusPasien."') AS statuspasien
			FROM b_kunjungan k
			INNER JOIN b_ms_unit u ON u.id = k.unit_id
			INNER JOIN b_ms_kso kso ON kso.id = k.kso_id
			GROUP BY kso.nama";
$rsDiv = mysql_query($sqlDiv);
$rwDiv = mysql_fetch_array($rsDiv);
?>
<img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" onClick="document.getElementById('div_laporan').popup.hide()">
	<fieldset>
		<legend>Laporan Rekam Medik</legend>
<table width="100%" align="center" style="font-size:12px">
	<tr>
		<td onclick="rekam1()" class="report" height="20">Kunjungan Pasien</td>
		<td onclick="rekam9()" class="report">Daftar Verifikasi Diagnosis PP</td>
	</tr>
	<tr>
		<td onclick="rekam2()" class="report">Asal Pasien Berdasarkan Tempat Layanan</td>
		<td onclick="rekam12()" class="report">Asal Rujukan Pasien Berdasarkan Tempat Layanan</td>
	</tr>
	<tr>
		<td onclick="rekam3()" class="report">Cara Bayar Pasien Berdasarkan Tempat Layanan</td>
		<td><a href="Rekam Medik/KasusPenyakitTmptLay.php" target="_blank">Kasus Penyakit Pasien Berdasarkan Tempat Layanan</a></td>
	</tr>
	<tr>
		<td ><a href="Rekam Medik/CaraKeluarTmptLay.php" target="_blank">Cara Keluar Pasien Berdasarkan Tempat Layanan</a></td>
		<td><a href="Rekam Medik/PenerimaanKonsul.php" target="_blank">Penerimaan Konsul Tempat Layanan</a></td>
	</tr>
	<tr>
		<td ><a href="Rekam Medik/PengirimKonsul.php" target="_blank">Pengiriman Konsul Tempat Layanan</a></td>
		<td onclick="rekam11()" class="report">Rujukan Penunjang Medik</td>
	</tr>
	<tr>
		<td  onclick="rekam7()" class="report">Kunjungan <?php echo $rwDiv['Jenis'];?> - <?php echo $rwDiv['Tempat'];?></td>
		<td onclick="rekam4()" class="report">Asal Pasien <?php echo $rwDiv['Jenis'];?> - <?php echo $rwDiv['Tempat'];?></td>
	</tr>
	<tr>
		<td ><a href="Rekam Medik/Kasus.php" target="_blank">Kasus <?php echo $rwDiv['Jenis'];?> - <?php echo $rwDiv['Tempat'];?></a></td>
		<td><a href="Rekam Medik/CaraKeluar.php" target="_blank">Cara Keluar <?php echo $rwDiv['Jenis'];?> - <?php echo $rwDiv['Tempat'];?></a></td>
	</tr>
	<tr>
		<td onclick="rekam6()" class="report">Diagnosis Pasien <?php echo $rwDiv['Jenis'];?> - <?php echo $rwDiv['Tempat'];?></td>
		<td onclick="rekam5()" class="report">10 Diagnosis Terbanyak Pasien <?php echo $rwDiv['Jenis'];?> - <?php echo $rwDiv['Tempat'];?></td>
	</tr>
	<tr>
		<td  onclick="rekam8()" class="report">10 Diagnosis Terbanyak PP <?php echo $rwDiv['Jenis'];?> - <?php echo $rwDiv['Tempat'];?></td>
		<td><a href="" target="_blank">Grafik 10 Diagnosis Terbanyak <?php echo $rwDiv['Jenis'];?> - <?php echo $rwDiv['Tempat'];?></a></td>
	</tr>
	<tr>
		<td ><a href="Rekam Medik/10DiagnosisBiayaTinggi.php" target="_blank">10 Penyakit Terbanyak Dengan Biaya Tertinggi PP <?php echo $rwDiv['Jenis'];?> - <?php echo $rwDiv['Tempat'];?></a></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td onclick="rekam10()" class="report">Keadaan Morbiditas Pasien <?php echo $rwDiv['Jenis'];?> - <?php echo $rwDiv['Tempat'];?></td>
		<td ><a href="" target="_blank">Kegiatan Pelayanan Tempat Layanan</a></td>
	</tr>
	<tr>
		<td ><a href="" target="_blank">Keadaan Morbiditas Surveilans Terpadu <?php echo $rwDiv['Jenis'];?> - <?php echo $rwDiv['Tempat'];?></a></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td ><a href="" target="_blank">Tindakan Operasi</a></td>
		<td><a href="" target="_blank">10 Tindakan Operasi Terbanyak</a></td>
	</tr>
	<tr>
		<td ><a href="" target="_blank">10 Tindakan Operasi Terbanyak Berdasarkan Penjamin Pasien</a></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td ><a href="" target="_blank">10 Tindakan Operasi Terbanyak dengan Biaya Tertinggi dan Berdasarkan Penjamin Pasien</a></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td ><a href="" target="_blank">Kunjungan Berdasarkan Pendidikan</a></td>
		<td><a href="" target="_blank">Kunjungan Berdasarkan Pekerjaan</a></td>
	</tr>
	<tr>
		<td ><a href="" target="_blank">Index Penyakit</a></td>
		<td><a href="" target="_blank">Index Operasi</a></td>
	</tr>
	<tr>
		<td ><a href="" target="_blank">Kunjungan Berdasarkan Wilayah</a></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td ><a href="" target="_blank">10 Diagnosis Terbanyak Penyebab Kematian</a></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td ><a href="" target="_blank">Kunjungan Tempat Layanan Berdasarkan Penjamin Pasien</a></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td ><a href="" target="_blank">Kunjungan Utama Tempat Layanan Berdasarkan Penjamin Pasien</a></td>
		<td>&nbsp;</td>
	</tr>
</table>
<!--table width="725" align="center" style="font-size:12px">
	<tr>
		<td width="50%" onclick="rekam1()" style="cursor:pointer;" height="20">Kunjungan Pasien</td>
		<td width="50%" onclick="rekam9()" style="cursor:pointer;">Daftar Verifikasi Diagnosis PP</td>
	</tr>
	<tr>
		<td height="20" onclick="rekam2()" style="cursor:pointer;">Asal Pasien Berdasarkan Tempat Layanan</td>
		<td height="20" onclick="rekam12()" style="cursor:pointer">Asal Rujukan Pasien Berdasarkan Tempat Layanan</td>
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
		<td onclick="rekam11()" style="cursor:pointer">Rujukan Penunjang Medik</td>
	</tr>
	<tr>
		<td height="20" onclick="rekam7()" style="cursor:pointer">Kunjungan <?php echo $rwDiv['Jenis'];?> - <?php echo $rwDiv['Tempat'];?></td>
		<td onclick="rekam4()" style="cursor:pointer;">Asal Pasien <?php echo $rwDiv['Jenis'];?> - <?php echo $rwDiv['Tempat'];?></td>
	</tr>
	<tr>
		<td height="20"><a href="Rekam Medik/Kasus.php" target="_blank">Kasus <?php echo $rwDiv['Jenis'];?> - <?php echo $rwDiv['Tempat'];?></a></td>
		<td><a href="Rekam Medik/CaraKeluar.php" target="_blank">Cara Keluar <?php echo $rwDiv['Jenis'];?> - <?php echo $rwDiv['Tempat'];?></a></td>
	</tr>
	<tr>
		<td height="20" onclick="rekam6()" style="cursor:pointer;">Diagnosis Pasien <?php echo $rwDiv['Jenis'];?> - <?php echo $rwDiv['Tempat'];?></td>
		<td onclick="rekam5()" style="cursor:pointer;">10 Diagnosis Terbanyak Pasien <?php echo $rwDiv['Jenis'];?> - <?php echo $rwDiv['Tempat'];?></td>
	</tr>
	<tr>
		<td height="20" onclick="rekam8()" style="cursor:pointer">10 Diagnosis Terbanyak PP <?php echo $rwDiv['Jenis'];?> - <?php echo $rwDiv['Tempat'];?></td>
		<td><a href="" target="_blank">Grafik 10 Diagnosis Terbanyak <?php echo $rwDiv['Jenis'];?> - <?php echo $rwDiv['Tempat'];?></a></td>
	</tr>
	<tr>
		<td colspan="2" height="20"><a href="Rekam Medik/10DiagnosisBiayaTinggi.php" target="_blank">10 Penyakit Terbanyak Dengan Biaya Tertinggi PP <?php echo $rwDiv['Jenis'];?> - <?php echo $rwDiv['Tempat'];?></a></td>
	</tr>
	<tr>
		<td height="20" onclick="rekam10()" style="cursor:pointer">Keadaan Morbiditas Pasien <?php echo $rwDiv['Jenis'];?> - <?php echo $rwDiv['Tempat'];?></td>
		<td height="20"><a href="" target="_blank">Kegiatan Pelayanan Tempat Layanan</a></td>
	</tr>
	<tr>
		<td colspan="2" height="20"><a href="" target="_blank">Keadaan Morbiditas Surveilans Terpadu <?php echo $rwDiv['Jenis'];?> - <?php echo $rwDiv['Tempat'];?></a></td>
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
</table-->
</fieldset>