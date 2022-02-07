<?php
require_once 'func.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		LEMBAR DOKUMENTASI PELAYANAN KAMAR OPERASI</title>
	<link rel="icon" href="../favicon.png">
	<link rel="stylesheet" href="../bootstrap-4.5.2-dist/css/bootstrap.min.css">
	<script src="../js/jquery-3.5.1.slim.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<script src="../js/bootstrap.min.js"></script>
	<link rel="icon" href="../favicon.png">
	<script src="../bootstrap-4.5.2-dist/js/jquery.min.js"></script>
	<script src="../bootstrap-4.5.2-dist/js/bootstrap.min.js"></script>
	<style type="text/css">
		@media print {
			#print {
				display: none;
			}
		}
	</style>
	<script src="../html2pdf/ppdf.js"></script>
</head>


<body>
	<div id="pdf-area" style=" width: 1000px;  margin: auto;">


		<?php

		$qPasien = "select p.no_rm,p.nama,p.tgl_lahir,p.sex,p.alamat,p.rt,p.rw,w.nama as desa,i.nama as kec,l.nama as kab,a.nama as prop
from b_ms_pasien p
left join b_ms_wilayah w on w.id=p.desa_id
left join b_ms_wilayah i on i.id=p.kec_id
left join b_ms_wilayah l on l.id=p.kab_id
left join b_ms_wilayah a on a.id=p.prop_id where p.id='" . $idPasien . "' ";
		$rsPasien = mysql_query($qPasien);
		$rwPasien = mysql_fetch_array($rsPasien);
		?>
		<img src="../logors1.png" style="width: 4,91 cm; height:1,97 cm; ">


		<div class="box-pasien" style="float: right; padding-right: 0px;">
			<p align='right' style="margin: 0px;">RM21.18/PHCM</p>
			<table style=" border: 1px solid black;  width: 7,07 cm; height:1,99 cm;" cellpadding="2">

				<tr>
					<td class="noline" style="font:12 sans-serif bolder;">
						<b> NAMA &nbsp;&nbsp;&nbsp;&nbsp;:<?php echo $rwPasien['nama']; ?></b>
					</td>
					<td class="noline"></td>
					<td class="noline">&nbsp;</td>
					<td class="noline">&nbsp;</td>
				</tr>
				<tr>
					<td class="noline" style="font:12 sans-serif bolder;">
						<b>Tgl.Lahir &nbsp;: <?php echo $rwPasien['tgl_lahir']; ?> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $rwPasien['sex']; ?> </b>
					</td>
					<td class="noline"></td>
					<td class="noline">&nbsp;</td>
					<td class="noline">&nbsp;</td>
				</tr>
				<tr>
					<td class="noline" style="font:12 sans-serif bolder;">
						<b> No.RM &nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $rwPasien['no_rm']; ?></b>
					</td>
					<td class="noline"></td>
					<td class="noline">&nbsp;</td>
					<td class="noline">&nbsp;</td>
				</tr>

			</table>
		</div>
		<br>

		<hr style=" margin:0px; padding:0px; margin-top:17px;">
		<hr style="border: 1px solid black; margin:0px; padding:0px; margin-top:2px;">
		<center>



			<div class='container'>

				<table cellspacing="0" border="0" align="center">
					<colgroup width="351"></colgroup>
					<colgroup width="80"></colgroup>
					<colgroup width="130"></colgroup>
					<colgroup width="146"></colgroup>
					<colgroup width="156"></colgroup>

					<tr>
						<td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan=5 height="29" align="center" valign=middle><b>
								<font face="Times New Roman" size=3 color="#000000"> LEMBAR DOKUMENTASI PELAYANAN KAMAR OPERASI </font>
							</b></td>
					</tr>
					<tr>
						<td style="border-top: 1px solid #000000; border-left: 2px solid #000000" height="22" align="center" valign=bottom bgcolor="#7F7F7F">
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td style="border-top: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#7F7F7F">
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=bottom><b>
								<font face="Times New Roman" size=3 color="#000000">PETUGAS </font>
							</b></td>
						<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign=bottom><b>
								<font face="Times New Roman" size=3 color="#000000">Keterangan</font>
							</b></td>
					</tr>
					<tr>
						<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000" height="42" align="center" valign=bottom bgcolor="#7F7F7F">
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#7F7F7F">
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom><b>
								<font face="Times New Roman" size=3 color="#000000">RUANG PEMULIHAN</font>
							</b></td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b>
								<font face="Times New Roman" size=3 color="#000000">RUANGAN</font>
							</b></td>
						<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign=bottom><b>
								<font face="Times New Roman" size=3 color="#000000"><br></font>
							</b></td>
					</tr>
					<tr>
						<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan=5 height="25" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"> Buku status :</font>
						</td>
					</tr>
					<tr>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000" height="30" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"> Laporan operasi</font>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td style="  border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font> <?php
																							$getone = GetOne($_REQUEST['id']);
																							if (isset($getone)) {
																								foreach ($getone as $data) {

																									echo $data['laporan_operasi_ruang_pemulihan'];
																								}
																							}
																							?>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font> <?php
																							$getone = GetOne($_REQUEST['id']);
																							if (isset($getone)) {
																								foreach ($getone as $data) {

																									echo $data['laporan_operasi_ruangan'];
																								}
																							}
																							?>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font> <?php
																							$getone = GetOne($_REQUEST['id']);
																							if (isset($getone)) {
																								foreach ($getone as $data) {

																									echo $data['laporan_operasi_keterangan'];
																								}
																							}
																							?>
						</td>
					</tr>
					<tr>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000" height="32" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"> Laporan anestesi</font>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>

						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['laporan_anestesi_ruang_pemulihan'];
								}
							}
							?>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['laporan_anestesi_ruangan'];
								}
							}
							?>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['laporan_operasi_keterangan'];
								}
							}
							?>
						</td>
					</tr>
					<tr>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000" height="30" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"> KIM</font>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>

						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['kim_ruang_pemulihan'];
								}
							}
							?>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['kim_ruangan'];
								}
							}
							?>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['kim_keterangan'];
								}
							}
							?>
						</td>
					</tr>
					<tr>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000" height="32" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"> Instruksi Obat</font>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['instruksi_obat_ruang_pemulihan'];
								}
							}
							?>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['instruksi_obat_ruangan'];
								}
							}
							?>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['instruksi_obat_keterangan'];
								}
							}
							?>
						</td>
					</tr>
					<tr>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000" height="29" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"> Instruksi Khusus (anestesi, diet dll)</font>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['instruksi_khusus_ruang_pemulihan'];
								}
							}
							?>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>

							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['instruksi_khusus_ruangan'];
								}
							}
							?>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['instruksi_khusus_keterangan'];
								}
							}
							?>
						</td>
					</tr>
					<tr>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000" height="36" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"> Instruksi Tranfusi</font>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>

						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['instruksi_transfusi_ruang_pemulihan'];
								}
							}
							?>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['instruksi_transfusi_ruangan'];
								}
							}
							?>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['instruksi_transfusi_keterangan'];
								}
							}
							?>
						</td>
					</tr>
					<tr>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000" height="30" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"> X-Ray Photo </font>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['x_ray_photo_ruang_pemulihan'];
								}
							}
							?>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['x_ray_photo_ruangan'];
								}
							}
							?>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000">Jumlah </font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['x_ray_photo_ruang_jumlah'];
								}
							}
							?>
							Lbr
						</td>
					</tr>
					<tr>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000" height="31" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"> EEG</font>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['eeg_ruang_pemulihan'];
								}
							}
							?>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['eeg_ruangan'];
								}
							}
							?>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000">Jumlah </font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['eeg_jumlah'];
								}
							}
							?>
							Lbr
						</td>
					</tr>
					<tr>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000" height="32" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"> ECG</font>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['ecg_ruang_pemulihan'];
								}
							}
							?>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['ecg_ruangan'];
								}
							}
							?>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000">Jumlah </font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['ecg_ruangan'];
								}
							}
							?>
							Lbr
						</td>
					</tr>
					<tr>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000" height="33" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"> USG </font>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['usg_ruang_pemulihan'];
								}
							}
							?>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['usg_ruangan'];
								}
							}
							?>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000">Jumlah </font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['usg_jumlah'];
								}
							}
							?>
							Lbr
						</td>
					</tr>
					<tr>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000" height="32" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"> CT Scan </font>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['ct_scan_ruang_pemulihan'];
								}
							}
							?>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['ct_scan_ruangan'];
								}
							}
							?>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000">Jumlah </font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['ct_scan_jumlah'];
								}
							}
							?>
							Lbr
						</td>
					</tr>
					<tr>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000" height="21" align="left" valign=bottom bgcolor="#7F7F7F">
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#7F7F7F">
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom><b>
								<font face="Times New Roman" size=3 color="#000000"><br></font>
							</b></td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom><b>
								<font face="Times New Roman" size=3 color="#000000"><br></font>
							</b></td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign=bottom><b>
								<font face="Times New Roman" size=3 color="#000000">Keterangan</font>
							</b></td>
					</tr>
					<tr>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000" height="31" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"> NGT</font>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['ngt_ruang_pemulihan'];
								}
							}
							?>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['ngt_ruangan'];
								}
							}
							?>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['ngt_keterangan'];
								}
							}
							?>
						</td>
					</tr>
					<tr>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000" height="32" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"> Kateter urin</font>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['kateter_urin_ruang_pemulihan'];
								}
							}
							?>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['kateter_urin_ruangan'];
								}
							}
							?>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['kateter_urin_keterangan'];
								}
							}
							?>
						</td>
					</tr>
					<tr>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000" height="33" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"> Infus</font>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['infus_ruang_pemulihan'];
								}
							}
							?>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['infus_ruangan'];
								}
							}
							?>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000">Area :</font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['infus_area'];
								}
							}
							?>
						</td>
					</tr>
					<tr>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000" height="34" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"> Drain / selang irigasi</font>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['drain_ruang_pemulihan'];
								}
							}
							?>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['drain_ruangan'];
								}
							}
							?>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000">Area :</font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['drain_area'];
								}
							}
							?>
						</td>
					</tr>
					<tr>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000" height="38" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"> Traksi</font>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['traksi_ruang_pemulihan'];
								}
							}
							?>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['traksi_ruangan'];
								}
							}
							?>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000">Area :</font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['traksi_area'];
								}
							}
							?>
						</td>
					</tr>
					<tr>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000" height="32" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"> Protesa lain : &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;. (tuliskan)</font>
						</td>
						<td>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['protesa_lain'];
								}
							}
							?>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border: 0px;" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000">Area :</font>
							<?php
							$getone = GetOne($_REQUEST['id']);
							if (isset($getone)) {
								foreach ($getone as $data) {

									echo $data['protesa_area'];
								}
							}
							?>
						</td>
					</tr>
					<tr>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000" height="21" align="left" valign=bottom bgcolor="#7F7F7F">
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#7F7F7F">
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom><b>
								<font face="Times New Roman" size=3 color="#000000"><br></font>
							</b></td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom><b>
								<font face="Times New Roman" size=3 color="#000000"><br></font>
							</b></td>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign=bottom><b>
								<font face="Times New Roman" size=3 color="#000000">Keterangan</font>
							</b></td>
					</tr>
					<tr>
						<td style="border-left: 2px solid #000000" height="21" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000">Keterangan : Bila ada atau terpasang diberi tanda centang : &radic; Bila tidak ada atau tidak terpasang beri tanda -</font>
						</td>
						<td align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td style="border-right: 2px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
					</tr>
					<tr>
						<td style="border-left: 2px solid #000000" height="21" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td style="border-right: 2px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
					</tr>
					<tr>
						<td style="border-left: 2px solid #000000" height="21" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td style="border-right: 2px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
					</tr>
					<tr>
						<td style="border-left: 2px solid #000000" height="21" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td style="border-right: 2px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
					</tr>
					<tr>
						<td style="border-left: 2px solid #000000" height="21" align="right" valign=bottom><b>
								<font face="Times New Roman" size=3 color="#000000">Petugas yang menyerahkan,</font>
							</b></td>
						<td align="center" valign=bottom><b>
								<font face="Times New Roman" size=3 color="#000000"><br></font>
							</b></td>
						<td align="right" valign=bottom><b>
								<font face="Times New Roman" size=3 color="#000000">Petugas yang menerima,</font>
							</b></td>
						<td align="left" valign=bottom><b>
								<font face="Times New Roman" size=3 color="#000000"><br></font>
							</b></td>
						<td style="border-right: 2px solid #000000" align="left" valign=bottom><b>
								<font face="Times New Roman" size=3 color="#000000"><br></font>
							</b></td>
					</tr>
					<tr>
						<td style="border-left: 2px solid #000000" height="21" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td align="center" valign=bottom><b>
								<font face="Times New Roman" size=3 color="#000000"><br></font>
							</b></td>
						<td align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td style="border-right: 2px solid #000000" align="center" valign=bottom><b>
								<font face="Times New Roman" size=3 color="#000000"><br></font>
							</b></td>
					</tr>
					<tr>
						<td style="border-left: 2px solid #000000" height="21" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td align="center" valign=bottom><b>
								<font face="Times New Roman" size=3 color="#000000"><br></font>
							</b></td>
						<td align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td style="border-right: 2px solid #000000" align="center" valign=bottom><b>
								<font face="Times New Roman" size=3 color="#000000"><br></font>
							</b></td>
					</tr>
					<tr>
						<td style="border-left: 2px solid #000000" height="21" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td style="border-right: 2px solid #000000" align="center" valign=bottom><b>
								<font face="Times New Roman" size=3 color="#000000"><br></font>
							</b></td>
					</tr>
					<tr>
						<td style="border-left: 2px solid #000000" height="21" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td style="border-right: 2px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
					</tr>
					<tr>
						<td style="border-left: 2px solid #000000" height="21" align="center" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000">(<?php
																					$getone = GetOne($_REQUEST['id']);
																					if (isset($getone)) {
																						foreach ($getone as $data) {

																							echo $data['petugas_yang_menyerahkan'];
																						}
																					}
																					?>)</font>
						</td>
						<td align="center" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td align="center" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000">(<?php
																					$getone = GetOne($_REQUEST['id']);
																					if (isset($getone)) {
																						foreach ($getone as $data) {

																							echo $data['petugas_yang_menerima'];
																						}
																					}
																					?>)</font>
						</td>
						<td align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td style="border-right: 2px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
					</tr>
					<tr>
						<td style="border-left: 2px solid #000000" height="21" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td style="border-right: 2px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
					</tr>
					<tr>
						<td style="border-bottom: 2px solid #000000; border-left: 2px solid #000000" height="22" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td style="border-bottom: 2px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td style="border-bottom: 2px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td style="border-bottom: 2px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
						<td style="border-bottom: 2px solid #000000; border-right: 2px solid #000000" align="left" valign=bottom>
							<font face="Times New Roman" size=3 color="#000000"><br></font>
						</td>
					</tr>
				</table>
			</div>
			</div>
			</div>


				<BR>
				<center>
					<div class='btn-group'>
					<button id='print' class='btn btn-info' onclick='javascript:pdf()'>Cetak PDF</button>
						<button id='print' class='btn btn-info' onclick='window.print()'>Cetak</button>
						<a id='print' href="javascript:history.back()" class="btn btn-primary " style="text-decoration: none; color: white;">Kembali</a>
					</div>
				</center>
			</div>

	<script>
    function pdf() {
        const pdf = document.getElementById("pdf-area");
        var opt = {
            margin: 0,
            filename: "RM 21.18 <?=$rwPasien['nama']?>.pdf",
            image: { type: "JPEG", quality: 1 },
            html2canvas: { scale: 1 },
            jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
        };
        html2pdf().from(pdf).set(opt).save();
    }
    </script>																			
</body>

</html>