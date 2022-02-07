<?php
	use yii\helpers\Html;
	include '../function/form.php';
	include '../../koneksi/konek.php';
	include 'funct.php';
	$dataPasien = getIndetitasPasien($_REQUEST['idKunj']);
	$i = 1;
$sql = "SELECT
            pa.*,
            agama.agama as agama,
            ped.nama as pendidikam,
            pk.nama as pekerjaan,
            kw.nama as kewarganegaraan 
        FROM
            b_ms_pasien pa 
            LEFT JOIN b_ms_pendidikan ped ON ped.id = pa.pendidikan_id
            LEFT JOIN b_ms_agama as agama ON agama.id = pa.agama
            LEFT JOIN b_ms_pekerjaan as pk ON pk.id = pa.pekerjaan_id
            LEFT JOIN b_ms_kewarganegaraan as kw ON kw.id = pa.id_kw
        WHERE
			pa.id = {$dataPasien['id']}";
			
		$dataP = mysql_fetch_assoc(mysql_query($sql));

if (isset($_REQUEST['cetak'])) {
	header("Location:print.php?cetak=" . $_REQUEST['cetak'] . "&idKunj=" . $_REQUEST['idKunj']);

  }

  if (isset($_REQUEST['pdf'])) {
	header("Location:print.php?pdf=" . $_REQUEST['pdf'] . "&idKunj=" . $_REQUEST['idKunj']);

  }

  if (isset($_REQUEST['id'])) {
    echo "<script>window.location.href='edit.php?id=".$_REQUEST['id']."&idKunj=".$_REQUEST['idKunj']."&idPel=".$_REQUEST['idPel']."&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['idUser']."&tmpLay=".$_REQUEST['tmpLay']."'</script>";
  }
  ?>

<!DOCTYPE html>
<html lang="en">
 
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../../theme/bs/bootstrap.min.css">
	<title>Document</title>
	<style type="text/css">
		.inv {
			background-color: transparent;
			border :none;
			cursor :default;
		}
		td {
			padding:5px;
		}
		.row {
			margin-bottom:8px;
		}
		.newline {
			margin-left: 30px;
		}
	</style>
</head>

<body style="padding:20px">
	<div class="bg-white" style="padding:25px">
		<div class="row">
			<div class="col-6 text-center"><br><br>
				<img src="../logors1.png">
			</div>
			<div class="col-6" style="padding:15px">
					
				<div style="float: right">RM 5 / PHCM</div>
				<br>
				<div id="box" class="row" style="border: 1px solid black;padding:15px">
					<div class="col-9">
						<table>
							<tr>
								<td>Nama</td>
								<td>:</td>
								<td><?= $dataPasien["nama"]; ?></td>
							</tr>
							<tr>
								<td>Tgl. Lahir</td>
								<td>:</td>
								<td><?= $dataPasien["tgl_lahir"]; ?></td>
							</tr>
							<tr>
								<td>No. RM</td>
								<td>:</td>
								<td><?= $dataPasien["no_rm"]; ?></td>
							</tr>
						</table>
					</div>

					<div class="col-3">
						<table>
							<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
							<tr>
								<td>
									<?php if($dataPasien["sex"] == "L"): ?>
										L
									<?php else: ?>
										P
									<?php endif; ?>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>

		<hr class="bg-dark" style="margin-top:-1px">
		<div style="height:5px;background-color:black;width:100%;margin-top:-12px;margin-bottom:10px"></div><br>
		<center><h2>PENGKAJIAN AWAL PASIEN TERINTEGRASI RAWAT INAP</h2><h4>(Dilengkapi dalam 24 jam pertama pasien masuk ruang rawat)</h4></center>
		<div>
<?php if(isset($_REQUEST['id'])): ?>
  <form action="" method="POST">
	<input type="hidden" name="idx" value="<?= $_REQUEST['id']; ?>">
<?php else:?>
  <form action="utils.php" method="POST">
<?php endif; ?>

	<input type="hidden" name="id_kunjungan" value="<?= $_REQUEST['idKunj']; ?>">
	<input type="hidden" name="id_pelayanan" value="<?= $_REQUEST['idPel']; ?>">
	<input type="hidden" name="id_user" value="<?= $_REQUEST['idUser']; ?>">
	<input type="hidden" name="tmpLay" value="<?= $_REQUEST['tmpLay']; ?>">
<br>

<div style="border:1px solid black">
	<table>
		<tr>
			<td colspan="2">Tanggal Masuk Ruang Rawat : <?=input($arr_slide1[$i-1], "data_{$i}", "date", "", "");$i++;?> (Perawat)</td>
		</tr>
		<tr>
			<td colspan="2">1.	Identitas</td>
		</tr>
		<tr>
			<td>Nama</td>
			<td>: <?=input($dataP['nama'], "data_{$i}", "text", "", "width:250px");$i++;?>  </td>
		</tr>
		<tr>
			<td>&emsp;No. RM </td>
			<td>: <?=input($dataP['no_rm'], "data_{$i}", "text", "", "width:250px");$i++;?>  </td>
		</tr>
		<tr>
			<td>&emsp;Tanggal Lahir</td>
			<td>: <?=input($dataP['tgl_lahir'], "data_{$i}", "date", "", "width:250px");$i++;?>  </td>
		</tr>
		<tr>
			<td>&emsp;Pendidikan</td>
			<td>: <?=input($dataP['pendidikam'], "data_{$i}", "text", "", "width:250px");$i++;?>  </td>
		</tr>
		<tr>
			<td>&emsp;Pekerjaan</td>
			<td>: <?=input($dataP['pekerjaan'], "data_{$i}", "text", "", "width:250px");$i++;?>  </td>
		</tr>
		<tr>
			<td>&emsp;Kewarganegaraan</td>
			<td>: <?=input($dataP['kewarganegaraan'], "data_{$i}", "text", "", "width:250px");$i++;?>  </td>
		</tr>
		<tr>
			<td>&emsp;Alamat </td>
			<td>: <?=input($dataP['alamat'], "data_{$i}", "text", "", "width:250px");$i++;?>  </td>
		</tr>
		<tr>
			<td>&emsp;Suku </td>
			<td>: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:250px");$i++;?>  </td>
		</tr>
		<tr>
			<td>&emsp;Pantangan</td>
			<td>: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:250px");$i++;?></td>
		</tr>
		<tr style="margin-bottom:20px">
			<td>&emsp;Nilai Kepercayaan<br><br><br></td>
			<td>: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:250px");$i++;?><br><br><br></td>
		</tr>
	</table>
</div><br><br>

<b>2. Risiko Cedera / Jatuh</b>(Perawat) <br>
    &emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak <br>
    &emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya (lihat dan isi form PENGKAJIAN JATUH MORSE/HUMPTY DUMPTY/terlampir)
<br><br>

<b>3. Skala Nyeri</b>(Perawat) <br>
<table width="100%" border="1px">
	<tr>
		<td>
			<img src="../../images/skalaNyeri1.png" width="100px">
			<img src="../../images/skalaNyeri2.png" width="100px">
			<img src="../../images/skalaNyeri3.png" width="100px"><br>
			<img src="../../images/numericScale.jpg" width="550px">
			<img src="../../images/skalaNyeri4.png" width="100px">
			<img src="../../images/skalaNyeri5.png" width="100px">
			<img src="../../images/skalaNyeri6.png" width="100px">
		</td>
		<td>
			Nyeri   :     
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak <br>
			Penyebab    : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?><br>
			Kualitas Nyeri  : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?><br>
			Lokasi           : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?><br>
			Skala Nyeri : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?><br>
			Durasi/Frekuensi : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?><br>
			Cara Mengatasi Nyeri : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Obat&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Istirahat            <br>  
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Relaksasi&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ubah Posisi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain lain <br>

		</td>
	</tr>
</table><br>

 <b>ASESMEN  MEDIS (diisi oleh dokter)</b><br>
Petunjuk : Beri tanda ( √ ) pada kolom yang di anggap sesuai <br>
Tiba diruangan tanggal: 
<?=input($arr_data[$i-1], "data_{$i}", "date", "", "");$i++;?>,&emsp;Pukul 
<?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?>,&emsp;Asesmen dimulai tanggal: 
<?=input($arr_data[$i-1], "data_{$i}", "date", "", "");$i++;?>,&emsp;Pkl 
<?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?> <br>

	<b>I.	Anamnesis</b><br>
	1.	Keluhan Utama ( lama, pencetus ) : <br>
	<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>

	2. Riwayat kehamilan  sekarang :<br>
	<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>

	3. Riwayat Penyakit Dahulu ( termasuk riwayat operasi ) : <br>
	<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>

	4. Riwayat Penyakit Keluarga : 
	&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada    &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada, sebutkan 
	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> <br>

	5. Riwayat pekerjaan : Apakah pekerjaan pasien berhubungan dengan zat-zat berbahaya ( misalnya : kimia, Gas dll )  <br>
	&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada  &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya , sebutkan 
	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?> <br>
	<div class="row">
		<div class="col-4">
			6. Riwayat Alergi : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />Tidak ada  &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada, yaitu : 
		</div>
		<div>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Makanan : 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?> <br>
																						
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Obat : 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?> <br>
																						
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain :  
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?> <br>
																			
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Reaksi berupa : 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?>
		</div></div>
	<br>
	<b>II.	Pemeriksaan Fisik </b><br>
	1.	Keadaan Umum : 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tampak tidak sakit  &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sakit ringan &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sakit sedang  &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sakit berat <br>
	2.	Kesadaran : 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Compos mentis       &emsp; 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Apatis       &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Somnolen    &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sopor  &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Sopor coma  &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Coma <br>
	3.	GCS : 
	E <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?>&emsp;
	M <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?>&emsp;
	V <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?> <br>
	4.	Tanda Vital	    : 
	TD : <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:10%");$i++;?> mmHg,  &emsp;
	Suhu : <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:10%");$i++;?> &deg;C, &emsp;
	Nadi : <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:10%");$i++;?> x/mnt, &emsp;
	Pernafasan : <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:10%");$i++;?> x/mnt <br><br>

	5.	Pemeriksaan :  Status generalis dan status lokalis (inspeksi, palpasi, perkusi dan auskultasi)<br>
	<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?> <br>

	<b>III.	Pemeriksaan Penunjang (Laboratorium, Radiologi, dll)</b> <br>
	<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>
	<br>
	<b>IV.	Diagnosis kerja: </b><br>
	<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>
	<br>
	<b>V.	Diagnosis banding	: </b><?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>
	<br>
	<b>VI.	Perencanaan Pelayanan Penatalaksanaan /Pengobatan </b><br>
	Penatalaksanaan / pengobatan : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:500px");$i++;?><br>
    (Terapi, tindakan, konsultasi, pemeriksaan penunjang lanjutan, edukasi, dsb) <br>
	<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?> <br>

	Rencana pulang : <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:10%");$i++;?> hari /
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak dapat diprediksi <br><br>
	<div class="row">
		<div class="col-2"></div>
		<div class="col-8">
			<table border="1px" width="100%">
				<tr>
					<th class="text-center">Dokter Yang Melakukan Pengkajian Medis</th>
					<th class="text-center">Verifikasi DPJP</th>
				</tr>
				<tr>
					<td>
						Tanggal : 
						<?=input($arr_data[$i-1], "data_{$i}", "date", "", "");$i++;?>, &emsp;Pkl
						<?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?> Selesai melakukan pengkajian
					</td>
					<td>
						Tanggal : 
						<?=input($arr_data[$i-1], "data_{$i}", "date", "", "");$i++;?>, &emsp;Pkl
						<?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?> Melakukan Verifikasi
					</td>
				</tr>
				<tr>
					<td><br><br><br><br><br><br><br></td>
					<td><br><br><br><br><br><br><br></td>
				</tr>
				<tr>
					<td class="text-center">Tanda Tangan dan Nama Jelas</td>
					<td class="text-center">Tanda Tangan dan Nama Jelas</td>
				</tr>
			</table>
		</div>
</div><br><br>

<center><b><h4>ASESMEN  KEPERAWATAN   (Diisi Oleh Tenaga Keperawatan)</h4></b></center><br>
Petunjuk : Beri tanda ( √ ) pada kolom yang anda anggap sesuai <br>
Asesmen dimulai : tanggal 
<?=input($arr_data[$i-1], "data_{$i}", "date", "", "");$i++;?>&emsp;pkl 
<?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?> <br>
Diperoleh dari : 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pasien   &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Keluarga    &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> OT pasien  &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> PJ pasien &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain 
<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> <br>
Cara masuk     : 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Jalan tanpa bantuan  &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Jalan dengan bantuan &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Dengan kursi roda &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Dengan stretcher <br>
Asal  pasien    : 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  IGD    &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Poliklinik    &emsp;    
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kamar bersalin   &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Kamar operasi   &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Rujukan <br><br>

&emsp;<b>I.	Status sosial , Ekonomi, Spiritual Suku/budaya, nilai kepercayaan</b><br>
<div style="margin-left:40px">
	1.	Pekerjaan pasien : 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> PNS/TNI/POLRI    &emsp; 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Swasta &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pensiun &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pelajar/ Mahasiswa &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain : 
	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?><br>

	&emsp;Pekerjaan penanggung jawab/ OT pasien : 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> PNS / TNI / POLRI&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Swasta&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pensiun&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain : 
	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>

	&emsp;Pendidikan pasien : 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> PNS / TNI / POLRI&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Swasta&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pensiun&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain : 
	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>

	&emsp;Pendidikan suami / Penanggung jawab / OT :
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TK&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> SD&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> SMP&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> SLTA&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Akademi / PT&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pasca sarjana &emsp; <br>
	&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain : 
	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>

	&emsp;Cara pembayaran : 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pribadi&emsp; 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Perusahaan&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Asuransi&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain 
	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>

	&emsp;Tinggal bersama : 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Keluarga&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Orang tua&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Anak&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Mertua &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Teman &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sendiri &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Panti Asuhan<br>
	&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Panti jompo   &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain 
	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>

	<b>2.	Spiritual </b>(Agama) : 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Islam&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Protestan&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Katholik&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hindu&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Budha&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Konghucu&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain –lain 
	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>

	&emsp;Mengungkapkan keprihatinan yang berhubungan dengan rawat inap : <br>
	<div class="row">&emsp;&emsp;
		<div>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak&emsp; 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya :
		</div>&emsp;
		<div>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ketidak mampuan untuk mempertahankan praktek spiritual seperti biasa.<br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Perasaan negatif tentang sistem kepercayaan terhadap spiritual <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Konflik antara kepercayaan spiritual dengan ketentuan sistem kesehatan. <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bimbingan Rohani<br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain – lain : 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
		</div>
	</div>

	<b>3.	Suku/ budaya   :</b>  <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
	<div class="row">
		<div class="">
	&emsp;<b>4.	Nilai-nilai kepercayaan pasien / keluarga : </b> 
		</div>&emsp;
		<div class="">
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada&emsp;      
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak mau dilakukan tranfusi&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak mau pulang dihari tertentu <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak mau di imunisasi&emsp; <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak boleh menyusui (ASI)<br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak memakan daging / ikan yang bersisik 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain – lain 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
		</div>
	</div>
	
	<div class="row">
		<div class="col-3">
			<b>5.	Kebutuhan privasi pasien :</b> 
		</div>
		<div class="col-9">
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak
		</div>
		<div class="col-3"></div>
		<div class="col-9">
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Keinginan waktu / tempat khusus saat wawancara & tindakan 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
	        <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kondisi penyakit/ Pengobatan <br>
            <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak menerima kunjungan, sebutkan jika ada 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak mau dirawat petugas laki-laki /perempuan <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?><br>
            <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Transportasi &emsp;
            <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> lain – lain 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
		</div>
		</div> 
	</div>

	&emsp;<b>II.	Anamnesis</b><br>
	<div style="margin-left:40px">
		1.	Diagnosa medis saat masuk :  <?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?> <br>
		2.	Keluhan Utama : <?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?> <br>
		3.	Riwayat Penyakit Sekarang	:<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?> <br>
		4.	Riwayat Penyakit Dahulu termasuk riwayat pembedahan :
		<div class="row">
			<div class="col-1">
				&emsp;a <br>
				&emsp;b <br><br>
				&emsp;c <br>
			</div>
			<div class="col-10">
				Pernah dirawat : 
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pernah, kapan 
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?>,&emsp;Diagnosis medis 
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
				Pernah operasi/ tindakan: 
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya, kapan 
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
				jenis operasi 
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
				Masalah operasi/ pembiusan : 
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya , sebutkan 
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?>
			</div>	
		</div>
			
		5.	Riwayat Penyakit Keluarga : 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada&emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Ada, sebutkan 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?><br>
		6.	Obat dari rumah : 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada&emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada, 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?>,&emsp;gunakan formulir rekonsiliasi obat  <br>

		7.	Apakah pernah mendapatkan obat pengencer darah ( aspirin, warfarin,plavix dll ) <br>
		&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak,&emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya, kapan 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
		8.	Riwayat Alergi:    
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada&emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada, sebutkan 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>

		9.	<b> Nyeri </b>        : 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada, Dengan skala nyeri : 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> VAS/NRS,&emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> FLACSS&emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Wong Baker  <br>
			&emsp;<b> Deskripsi </b>  : Provokes : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Benturan&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tindakan&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Proses penyakit,&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain, 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
			&emsp;<b> Quality </b>     : 
			&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Seperti tertusuk-tusuk benda tajam/tumpul&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Berdenyut&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Terbakar  <br>
			&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tertindih benda berat &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Diremas&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Terpelintir  &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Teriris <br>
			&emsp;<b> Region </b>     : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lokasi : 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Menyebar:     
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak  &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?>    <br>
			&emsp;<b> Severity </b>   : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> FLACSS, Score: 
			<?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:5%");$i++;?>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Wong Baker Faces, Score: 
			<?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:5%");$i++;?>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> VAS/NRS,Score : 
			<?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:5%");$i++;?>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> BPS,Score : 
			<?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:5%");$i++;?> <br>
			&emsp;<b> Time/ durasi nyeri </b>: 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:50%");$i++;?> <br>
			&emsp;<b> Jika ada keluhan nyeri lakukan asesmen lanjutan dan intervensi </b><br>                                                                                                                                                                                                                                                                 
			10.	Riwayat Tranfusi darah : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Tidak pernah 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />&emsp;Pernah, kapan 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:50%");$i++;?> <br>
			&emsp;&nbsp;&nbsp;Timbul reaksi  
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak / 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:50%");$i++;?> <br>
			11.	Golongan darah    / Rh        :  
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> A    &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> B    &emsp; 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> O    &emsp; 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> AB   &emsp;        Rh : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Positif  &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Negatif <br>

			12.	Khusus pasien dengan riwayat kemoterapi & radioterapi :
				<div class="row">
					<div class="col-1"></div>
					<div class="col-2">
						a.	
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak pernah <br>
						b.	Cara pemberian <br>
						c.	Riwayat radioterapi <br>
						d.	Efek samping
					</div>
					<div class="col-9">
						: 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pernah, kapan 
						<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:15%");$i++;?> &emsp;Sudah berapa kali 
						 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:15%");$i++;?>, &emsp;terakhir 
						<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:15%");$i++;?> <br>
			       		: 
			       		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Melalui Suntik&emsp;
			       		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Melalui infus&emsp;
			       		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Melalui oral / minum     <br>
						: 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak pernak&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pernah, kapan 
						<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?>,&emsp;berapa kali 
						<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
			           	: 
			           	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Mual &emsp;
			           	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Muntah&emsp;
			           	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Jantung berdebar&emsp;
			           	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pusing&emsp;
			           	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Rambut rontok  <br>
			            &nbsp;
			            <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain 
			            <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
					</div>
				</div>
			           
			13.	Riwayat merokok    : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya, jumlah / hari 
			<?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:10%");$i++;?>  Lamanya 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>

			14.	Riwayat minum minuman keras :  
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya, jenis 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> &emsp;Jumlah / hari 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
			15.	Riwayat penggunaan obat penenang : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya, jenis 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> &emsp;Jumlah / hari 
			<?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;");$i++;?> <br>
			16.	Riwayat Pernikahan : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Belum menikah &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Menikah, Lama menikah: 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> &emsp;Pernikahan keberapa: 
			<?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;");$i++;?> <br><br>

			<b>III.	Pemeriksaan Fisik </b><br>
			<div class="newline">
				1.	Keadaan Umum : 
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tampak tidak sakit  &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sakit ringan &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sakit sedang  &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sakit berat <br>
				2.	Kesadaran : 
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Compos mentis       &emsp; 
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Apatis       &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Somnolen    &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sopor  &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Sopor coma  &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Coma <br>
				3.	GCS : 
				E <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?>&emsp;
				M <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?>&emsp;
				V <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?> <br>
				4.	Tanda Vital	    : 
				TD : <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:10%");$i++;?> mmHg,  &emsp;
				Suhu : <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:10%");$i++;?> &deg;C, &emsp;
				Nadi : <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:10%");$i++;?> x/mnt, &emsp;
				Pernafasan : <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:10%");$i++;?> x/mnt <br>
				5.	Atropometri      : 
				BB <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:8%");$i++;?> kg, &emsp;
				TB <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:8%");$i++;?> cm, &emsp;
				LK <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:8%");$i++;?> cm, &emsp;
				LD <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:8%");$i++;?> cm,&emsp;
				LP : <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;");$i++;?> cm <br>
				<b>6.	Pengkajian Persistem dan pengkajian fungsi  :</b><br>
				<table width="100%" border="1px">
					<tr>
						<th>Pengkajian Persistem/ fungsi </th>
						<th>Hasil Pemeriksaan</th>
					</tr>
					<tr>
						<th>Sistem Susunan saraf pusat</th>
						<td>
							Kepala  : 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hydrocephalus &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hematoma &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Mikrocepalus &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain 
							<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
							Ubun – ubun  : 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Datar  &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Cekung &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Menonjol  &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain 
							<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
							Wajah: 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />TAK &emsp; 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Asimetris  
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bell’s Palsy &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kelainan kongenital : 
							<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
							Leher : 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK &emsp; 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Kaku Kuduk  &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Pembesaran Tiroid  &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Pembesaran KGB <br>&emsp;&emsp;&emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Keterbatasan gerak    &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Lain-lain 
							<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
							Kejang	          : 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak &emsp;  
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada, Tipe 
							<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
							Sensorik         : 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada kelainan      &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sakit nyeri      &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Rasa kebas <br>
							Motorik          : 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK  &emsp;   
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hemiparese  &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tetraparese
						</td>
					</tr>
					<tr>
						<th>Sistem Penglihatan/ Mata </th>
						<td>
							Gangguan penglihatan : 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK &emsp; 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Minus &emsp; 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Plus &emsp; 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Buta  <br>
							Posisi mata                     : 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Simetris &emsp; 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Asimetris     <br>  
							Pupil     	                           : 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Isokor    &emsp; 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Anisokor      <br>
							Kelopak Mata                 : 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK        &emsp; 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Edema &emsp; 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Cekung   &emsp; 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain 
							<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
							Konjungtiva    : 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK      &emsp; 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Anemis 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Konjungtivitis  &emsp; 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain 
							<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
							Sklera              : 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK      &emsp; 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ikterik    &emsp; 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Perdarahan &emsp; 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Lain-lain 
							<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
							Alat bantu penglihatan:  
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak     &emsp; 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya   
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Mata palsu  &emsp; 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kaca mata   <br>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lensa kontak
						</td>
					</tr>
					<tr>
						<th>Sistem Pendengaran</th>
						<td>
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Nyeri &emsp;
							 <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />Tuli &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Keluar cairan &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Berdengung &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
							Menggunakan alat bantu pendengaran :  
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak	&emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya
						</td>
					</tr>
					<tr>
						<th>Sistem Penciuman</th>
						<td>
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Asimetris &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pengeluaran cairan &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Polip &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sinusitis &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Epistaksis <br>
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Lain-lain <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?>
						</td>
					</tr>
					<tr>
						<th>Sistem Pernafasan</th>
						<td>
							Pola napas : 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Normal  &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bradipneu  &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tachipneu &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kusmaull &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Cheyne stokes  <br>&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;
                            <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Biot &emsp;
                            <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Apnea &emsp;
                            <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
							Retraksi                          : 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya, 
							<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
							NCH                                 : 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya <br>
							Jenis pernafasan          : 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Dada &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Perut &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Alat bantu napas, sebutkan <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
							Irama napas                  : 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Teratur           &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak teratur <br>
							Terpasang WSD            : 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya, Produksi <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
							Kesulitan bernapas      : 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya, jika ya : 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Dyspneu &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Orthopneu   <br>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
							Batuk dan sekresi        : 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak  &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya, jika ya: &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Produktif &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Non produktif <br>
							Warna sputum             : 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Putih &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kuning &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hijau &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Merah  <br>
							Suara napas                  : 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Vesikuler &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ronchi &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Wheezing &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kreckles <br>
							Perkusi                          : 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sonor  &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hiper sonor  &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Redup
						</td>
					</tr>
					<tr>
						<th>Sistem Kardiovaskuler/ jantung </th>
						<td>
							Warna kulit : 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Normal &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kemerahan &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> sianosis &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pucat &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
							Clubbing Finger            : 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak  &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya <br>
							Nyeri dada     
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak    &emsp; 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya , sebutkan <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
							Denyut nadi:  
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Teratur &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak teratur  <br>
							Sirkulasi  :       
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Akral hangat &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Akral dingin &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Rasa kebas &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Palpitasi    <br>&emsp;&emsp;&emsp;&emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Edema, lokasi <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
							Pulsasi    :        
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kuat	    &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lemah          &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
							CRT          :        
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> < 2 detik  &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> > 2 detik 	 <br>
							Bunyi jantung: 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Normal   &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Murmur &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Gallop
						</td>
					</tr>
					<tr>
						<th>Sistem Pencernaan</th>
						<td>							
							Mulut : &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK    &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Stomatitis &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Mukosa kering   &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain 
							<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
							Gigi   : &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK      &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Karies &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tambal &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Goyang &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Gigi palsu &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain 
							<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
							Lidah : &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bersih &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kotor    &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain 
							<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
							Tenggorokan :   &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK    &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hiperemis            &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pembesaran Tonsil &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sakit menelan   <br>           Abdomen       :   &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lembek &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Distensi &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kembung &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Asites &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> hepatomegali <br>&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;
							&emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Splenomegali   &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Nyeri tekan/lepas, lokasi 
							<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
							&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada benjolan/ massa, lokasi 
							<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?>     <br>    
							Peristaltik usus: &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada bising usus &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hiperperistaltik   <br>
							Anus : &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK      &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Atresia Ani  &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Haemoroid &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Fistula &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain – lain 
							<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
							BAB:  &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK       &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Konstipasi   &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Melena   &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Inkontinensia alvi  &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Colostomy  <br>
							&emsp;&emsp;&emsp;&nbsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Diare Frekuensi 
							<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:8%");$i++;?> /hari
						</td>
					</tr>
					<tr>
						<th>Sistem Genitourinaria</th>
						<td>
							Kebersihan  :     &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bersih      &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kotor          &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bau          &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain <br>
							Kelainan :           &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hipospadia &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hernia  &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hidrokel &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ambigous <br>              			
							&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Phimosis &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain-- <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
							BAK : &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK        &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Anuria     &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Disuria &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Poliuria &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Retensi urin <br>
							&emsp;&emsp;&emsp;&nbsp;&nbsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Inkontinensia urin &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hematuri &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Urostomy, Warna <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
							Palpasi          :     &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK, &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada kelainan, <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
							Perkusi         :      &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK, &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Nyeri ketok, lokasi : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?>
						</td>
					</tr>
					<tr>
						<th>Sistem Reproduksi</th>
						<td>
							<b>Wanita </b><br>
							Menarche : umur 
							<?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:8%");$i++;?> th, Siklus haid 
							<?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:8%");$i++;?> hari, Lama haid : 
							<?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:8%");$i++;?> hari, HPHT 
							<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
							Gangguan haid: &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Dismenorhe &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Metrorhagi &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Spotting &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain : 
							<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
							Penggunaan alat kontrasepsi: &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />   Tidak       &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Ya, sebutkan 
							<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
							Payudara : &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />TAK &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Benjolan &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tampak seperti kulit jeruk &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain 
							<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?>        <br> 
							&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
							Puting susu:      &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> menonjol / 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> lecet / 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> masuk kedalam,  <br>
							&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> ASI sudah keluar / 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> belum,            &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Keluar darah / 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> cairan <br>
							Tanda – tanda mastitis : &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bengkak  &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Nyeri   &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kemerahan     &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada  <br>
							Uterus     : TFU 
							<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> Kontraksi uterus : keras / lembek <br><br>
							<b> Laki-laki  </b><br>
							Sirkumsisi              :   &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak	&emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya <br>
							Gangguan prostat:   &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak	&emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya         Lain-lain  : 
							<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?>
						</td>
					</tr>
					<tr>
						<th>Sistem Integumen</th>
						<td>
							Turgor	   :   &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Baik, elastis      &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Sedang             &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Buruk   <br>
							Warna	   :   &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  TAK                    &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Ikterik              &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Pucat <br>
							Integritas :   &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Utuh                  &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Dekubitus        &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Rash/ruam      &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ptekiae <br>
							Kriteria risiko dekubitus : &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pasien immobilisasi &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Penurunan kesadaran  <br>
                            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;
                            <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Malnutrisi &emsp;
                            <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Inkontinensia uri/alvi &emsp;
                            <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kelumpuhan  <br>
                            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;
                            <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Penurunan persepsi sensori : &emsp;
                            <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> kebas  <br>
                            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;
                            <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Penurunan  respon nyeri <br>
                            <b>(Bila terdapat satu atau lebih kriteria di atas,lakukan pengkajian dengan menggunakan formulir pengkajian resiko dekubitus/ score Braden Scale)</b>
						</td>
					</tr>
					<tr>
						<th>Sistem Muskuloskletal</th>
						<td>
							Pergerakan sendi   : &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Bebas           &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Terbatas <br>
							Kekuatan otot        : &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Baik              &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Lemah            &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Tremor <br>
							Nyeri sendi	    : &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Tidak ada     &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Ada  lokasi 
							<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
							Oedema	    : &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Tidak ada     &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Ada  lokasi 
							<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
							Fraktur	                  : &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Tidak ada     &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Ada  lokasi 
							<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
							Parese	                  : &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />   Tidak ada    &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada lokasi 
							<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
							Postur tubuh         : &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Normal &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Skoliosis  &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lordosis  &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kyphosis
						</td>
					</tr>
					<tr>
						<th>Sistem Endokrin Metabolik</th>
						<td>
							Mata            : &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Exophtalmus   &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Endophtalmus <br>
							Leher           : &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK  &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pembesaran kelenjar tiroid <br>
							Ekstremitas : &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK  &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tremor           &emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Berkeringat
						</td>
					</tr>
				</table>
		</div>

		<b>IV.	Pengkajian fungsi kognitif dan motorik </b><br>
		<div class="newline">
			<b> 1.	Kognitif</b>  <br>&emsp;
             <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Orientasi penuh &emsp;
             <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pelupa &emsp;
             <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bingung  <br>
			<b>2.    Motorik  </b> <br>
			&emsp;a.	Aktifitas sehari-hari : &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Mandiri &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bantuan minimal &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bantuan sebagian &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ketergantungan total  <br>
			&emsp;b.	Berjalan : &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada kesulitan &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Perlu bantuan &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sering jatuh &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Kelumpuhan                                        <br>
			&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Paralisis &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Deformitas &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hilang keseimbangan  <br>
			&emsp;c.	Riwayat patah tulang: 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain – lain 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>

			&emsp;d.	Alat ambulan            : &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Walker       &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tongkat         &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kursi roda        &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak menggunakan  <br>
			&emsp;e.	Ekstremitas atas                     : &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada kesulitan	&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lemah <br>
			&emsp;f.	   Ekstremitas bawah     : &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK  &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Varises  &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Edema 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak simetris   &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain –lain 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
			&emsp;g.	Kemampuan menggenggam : &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada kesulitan &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada, sejak 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
			&emsp;h.	Kemampuan koordinasi         : &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada kelainan &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada masalah: 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
			&emsp;i.	  Kesimpulan gangguan fungs  : &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya (konsul DPJP ) dan asesmen fungsi oleh fisioterapi  <br>
			&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ( tdk perlu konsul DPJP )<br><br>

			<b>3.	Pengkajian risiko pasien jatuh </b><br>
			&emsp;a.	Risiko Jatuh Humpty Dumpty <br>
			     &emsp;&nbsp;&nbsp;&nbsp;
			     <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Risiko rendah 0 – 6      &emsp;
			     <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Risiko sedang  7 – 11       &emsp;
			     <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Risiko Tinggi  ≥ 12 <br>
			&emsp;b.	Risiko Jatuh Morse  (Pasien dewasa dan pasien yang dirawat di ruang non intensif) <br>
			     &emsp;&nbsp;&nbsp;&nbsp;
			     <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Risiko rendah 0 – 24     &emsp;
			     <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Risiko sedang  25 – 44    &emsp;
			     <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Risiko Tinggi  ≥ 45 <br>
			&emsp;c.	Risiko jatuh geriatri ( usia > 60 tahun ) Ontario Modified Stratify- Sydney Scoring)  <br>
			     &emsp;&nbsp;&nbsp;&nbsp;
			     <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 0-5 Risiko rendah          &emsp;
			     <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 6-16 Risiko sedang          &emsp;
			     <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> > 16 Risiko tinggi  <br>
				 <b>Keterangan : Gelang warna kuning dipasang pada asesmen risiko tinggi dan lakukan asesmen lanjutan</b> <br><br>

				<b> 4.	Proteksi  </b><br>
				<div class="newline">
					a.	Status Mental : &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Orientasi	&emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada respon   &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Agitasi	&emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Menyerang    &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kooperatif <br>
				    &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
				    <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Letargi         &emsp;
				    <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Disorientasi : &emsp;
				    <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Orang  &emsp;
				    <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />Tempat  &emsp;
				    <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Waktu	 <br>	
				    <div class="row">
				    	<div class="col-2">
				    		b.	Penggunaan restrain: 
				    	</div>
				    	<div>
				    		&emsp;
				    		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak <br>
				    		&emsp;
		                    <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya, alasan :&emsp;
		                    <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Membahayakan diri sendiri   &emsp;
		                    <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Membahayakan orang lain <br>
		                    &emsp;
		                    <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Merusak lingkungan /peralatan &emsp;
		                    <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Gaduh gelisah  <br>
							&emsp;
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pembatasan gerak  <br>
		                    &emsp;
		                    <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kesadaran menurun 
		                    &emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pasien geriatri dengan keterbatasan  <br>
				    	</div>
				    </div>
					
                    
					Jenis restraint : &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Mekanik   &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Farmakologi   &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Psikologi   &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Penghalang &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pengikatan &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain <br>
				</div>
				
				5.	Psikologis  <br>&emsp;
				Status psikologis : &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tenang &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Cemas &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sedih &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Depresi &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Marah &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hiperaktif &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Mengganggu sekitar  <br>
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain 
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>

				6.	Kebutuhan pendidikan / komunikasi dan pengajaran <br>
				<div class="newline">
				a.	Bicara	          : 
				&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Normal     
				&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Tidak gangguan bicara sejak 
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
				b.	Bahasa sehari-hari : 
				&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Indonesia 
				&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Daerah 
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?>
				&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Inggris  aktif/ pasif   
				&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain 
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
				c.	Penerjemah	          : 
				&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak         
				&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya, Bahasa : 
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> 
				&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> bahasa isyarat   
				&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya   
				&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak  <br>
				<div class="row">
					<div class="col-2">d.	Hambatan belajar  : </div>
					<div>
						&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak         
						&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya	
						&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bahasa  
						&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Cemas  
						&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kognitif   
						&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pendengaran  
						&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Emosi    <br> 
						&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hilang memori  
						&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Motivasi buruk   
						&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Masalah penglihatan 
						&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kesulitan bicara   <br>
						&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  lain-lain : 
						<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?>
					</div>
				</div>
				
				<div class="row">
					<div class="col-3">e.	Cara belajar yang disukai : </div>
					<div>
						&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Menulis 
						&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Diskusi  
						&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Mendengar  
						&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Demonstrasi  
						&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Membaca  <br>
						&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Audio/visual <br>
					</div>
				</div>
				
				f.	<b>Pasien atau keluarga menginginkan informasi / bersedia :</b>  &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bersedia     &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak <br>
				g.	<b>Pasien atau keluarga menginginkan informasi tentang :</b> &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Proses penyakit     &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Terapi atau obat  <br>
				&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Nutrisi &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Penggunaan alat medis  &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tindakan  &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Manajemen nyeri  &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pencegahan risiko jatuh  <br>
				&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain –lain 
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:50%");$i++;?> <br>
				h.	Perencanaan Edukasi : <?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?> <br>
				</div>
		</div>
	</div>
	<center>
		<h4><u>SKRINING GIZI OLEH PERAWAT</u></h4><br>
	</center>
	
	<b>Dewasa ( berdasarkan Nutritional Risk Screening / NRS – 2002 ) </b><br>
	<table width="100%" border="1px">
		<tr>
			<th  class="text-center" rowspan="2">No.</th>
			<th  class="text-center" rowspan="2">Kriteria</th>
			<th  class="text-center" colspan="4">Skor</th>
		</tr>
		<tr>
			<th class="text-center" >0</th>
			<th class="text-center" >1</th>
			<th class="text-center" >2</th>
			<th class="text-center" >3</th>	
		</tr>
		<tr>
			<td class="text-center">1</td>
			<td>Penurunan BB sebesar > 5% : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya , jika ya dalam kurun waktu : 3 bulan terakhir( skor 1) , 2 bulan ( skor 2 )  , 1 bln( skor 3 ) </td>
			<td class="text-center"><input type="checkbox" class="dewasa" value="0" onchange="dewasa()" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
			<td class="text-center"><input type="checkbox" class="dewasa" value="1" onchange="dewasa()" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
			<td class="text-center"><input type="checkbox" class="dewasa" value="2" onchange="dewasa()" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
			<td class="text-center"><input type="checkbox" class="dewasa" value="3" onchange="dewasa()" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
		</tr>
		<tr>
			<td class="text-center">2</td>
			<td>ATAU  ada penurunan asupan makan dari kebutuhan dalam seminggu terakhir : &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya, jika ya sebesar : penurunan 25% ( skor 1) , 50% ( skor 2 ),     
     75% ( skor 3) <br>
 Bila ada indikasi keduanya pilih skor tertinggi  
 </td>
			<td class="text-center"><input type="checkbox" class="dewasa" value="0" onchange="dewasa()" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
			<td class="text-center"><input type="checkbox" class="dewasa" value="1" onchange="dewasa()" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
			<td class="text-center"><input type="checkbox" class="dewasa" value="2" onchange="dewasa()" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
			<td class="text-center"><input type="checkbox" class="dewasa" value="3" onchange="dewasa()" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
		</tr>
		<tr>
			<td class="text-center">3</td>
			<td>Ada penyakit penyerta/ kebutuhan khusus : &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya ,  
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:40%");$i++;?></td>
			<td class="text-center"><input type="checkbox" class="dewasa" value="0" onchange="dewasa()" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
			<td class="text-center"><input type="checkbox" class="dewasa" value="1" onchange="dewasa()" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
			<td class="text-center"><input type="checkbox" class="dewasa" value="2" onchange="dewasa()" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
			<td class="text-center"><input type="checkbox" class="dewasa" value="3" onchange="dewasa()" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
		</tr>
		<tr>
			<td class="text-center">4</td>
			<td>Usia pasien < 70 tahun ( skor 0 ) ≥ 70 tahun ( skor 1 )  </td>
			<td class="text-center"><input type="checkbox" class="dewasa" value="0" onchange="dewasa()" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
			<td class="text-center"><input type="checkbox" class="dewasa" value="1" onchange="dewasa()" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
			<td class="text-center"><input type="checkbox" class="dewasa" value="2" onchange="dewasa()" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
			<td class="text-center"><input type="checkbox" class="dewasa" value="3" onchange="dewasa()" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
		</tr>
		<tr>
			<td></td>
			<td>Total skor : <b id="total"></b></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>

	</table><br>
	<b>Risiko Nutrisi :    &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak (Total skor 1-2)      &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya ( Total skor ≥ 3 ), lanjutkan asuhan gizi oleh ahli gizi  </b><br><br>

	<b>Anak ( Berdasarkan STRONG ) </b><br>
	<table width="100%" border="1px">
		<tr class="text-center">
			<th>No</th>
			<th>Aspek Yang Dinilai</th>
			<th>tidak</th>
			<th>Ya</th>
		</tr>
		<tr>
			<td>1</td>
			<td>Apakah pasien tampak kurus</td>
			<td width="100px" class="text-center"><input type="checkbox" class="anak" onchange="anak()" value="0" class="dewasa" value="3" onchange="dewasa()" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 0</td>
			<td width="100px" class="text-center"><input type="checkbox" class="anak" onchange="anak()" value="1" class="dewasa" value="3" onchange="dewasa()" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 1</td>
		</tr>
		<tr>
			<td>2</td>
			<td>Penurunan BB selama 1 bulan terakhir ?( berdasarkan penilaian obyektif data BB bila ada/ penilaian subyektif dari orangtua pasien atau untuk bayi ≤ 1 tahun BB tidak naik selama 3 bln terakhir)</td>
			<td width="100px" class="text-center"><input type="checkbox" class="anak" onchange="anak()" value="0" class="dewasa" value="3" onchange="dewasa()" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 0</td>
			<td width="100px" class="text-center"><input type="checkbox" class="anak" onchange="anak()" value="1" class="dewasa" value="3" onchange="dewasa()" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 1</td>
		</tr>
		<tr>
			<td>3</td>
			<td>Apakah terdapat kondisi salah satu diare ≥ 5 kali / hari, muntah ≥3 kali/ hari & asupan makan berkurang selama 1 minggu terakhir </td>
			<td width="100px" class="text-center"><input type="checkbox" class="anak" onchange="anak()" value="0" class="dewasa" value="3" onchange="dewasa()" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 0</td>
			<td width="100px" class="text-center"><input type="checkbox" class="anak" onchange="anak()" value="1" class="dewasa" value="3" onchange="dewasa()" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 1</td>
		</tr>
		<tr>
			<td>4</td>
			<td>Adakah penyakit / keadaan yang mengakibatkan pasien berisiko mengalami malnutrisi? </td>
			<td width="100px" class="text-center"><input type="checkbox" class="anak" onchange="anak()" value="0" class="dewasa" value="3" onchange="dewasa()" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 0</td>
			<td width="100px" class="text-center"><input type="checkbox" class="anak" onchange="anak()" value="2" class="dewasa" value="3" onchange="dewasa()" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 2</td>
		</tr>
		<tr>
			<td></td>
			<td>Total Skor : <b id="total2"></b></td>
			<td></td>
			<td></td>
		</tr>
	</table><br>

	<b>Risiko Nutrisi : &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Rendah ( Total skor 0 ) &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sedang ( Total skor 1-3 ) &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tinggi ( Total skor 4-5 ) , Risiko sedang dan tinggi lanjut asuhan gizi oleh ahli gizi </b> <br>
	<center>
		<h4><u>DAFTAR MASALAH KEPERAWATAN</u></h4><br>
	</center>
		<div class="row">
			<div class="col-3"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Nyeri</div>
			<div class="col-3"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Keselamatan pasien</div>
			<div class="col-3"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tumbuh kembang</div>
			<div class="col-3"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Nutrisi</div>

			<div class="col-3"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pola Tidur</div>
			<div class="col-3"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Suhu Tubuh</div>
			<div class="col-3"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Perfusi jaringan</div>
			<div class="col-3"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Eliminasi</div>

			<div class="col-3"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Mobilitas/aktifitas</div>
			<div class="col-3"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pengetahuan/komunikasi</div>
			<div class="col-3"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Jalan nafas/pertukaran gas</div>
			<div class="col-3"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Konflik peran</div>

			<div class="col-3"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Integritas kulit</div>
			<div class="col-3"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Perawatan diri</div>
			<div class="col-6"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Keseimbangan cairan dan elektrolit</div>

			<div class="col-3"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Infeksi</div>
			<div class="col-3"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pola nafas</div>
			<div class="col-6"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain – lain <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:40%");$i++;?></div>
		</div><br>

		<center><b>RENCANA KEPERAWATAN :</b><br></center>
		<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?> <br>

		<center><b>PERENCANAAN PERAWATAN INTERDISIPLIN/REFERAL</b></center><br>

		<div class="row">
			<div class="col-3">1.	Diet dan nutrisi : </div>
			<div class="col-9">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya : 
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:60%");$i++;?></div>

			<div class="col-3">2.	Rehabilitasi medik </div>
			<div class="col-9">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya : 
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:60%");$i++;?></div>

			<div class="col-3">3.	Farmasi	 </div>
			<div class="col-9">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya : 
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:60%");$i++;?></div>

			<div class="col-3">4.	Perawatan luka </div>
			<div class="col-9">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya : 
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:60%");$i++;?></div>

			<div class="col-3">5.	Manajemen nyeri</div>
			<div class="col-9">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya : 
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:60%");$i++;?></div>

			<div class="col-3">6.	Lain-lain  </div>
			<div class="col-9">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya : 
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:60%");$i++;?></div>
		</div><br>

		<center><b><h4>PERENCANAAN PULANG ( DISCHARGE PLANNING )</h4></b></center><br>
		Pasien dan keluarga dijelaskan tentang perencanaan pulang : &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya <br>
		Lama perawatan rata- rata     : 
		<?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:8%");$i++;?> hari,&emsp;tanggal rencana pulang : 
		 <?=input($arr_data[$i-1], "data_{$i}", "date", "", "");$i++;?><br><br>

		 Jika tidak masuk dalam kondisi <b>khusus edukasi</b> yang diberikan sebagai berikut :
		 <div class="row">
		 	<div class="col-4">
		 	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Perawatan diri/ personal hygiene</div>
		 	<div class="col-4">
		 	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Perawatan nifas/ post SC  </div>
		 	<div class="col-4"></div>

		 	<div class="col-4">
		 	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Perawatan luka</div>
		 	<div class="col-4">
		 	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Perawatan bayi  </div>
		 	<div class="col-4"></div>

		 	<div class="col-4">
		 	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pemantauan pemberian obat</div>
		 	<div class="col-4">
		 	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bantuan medis/ perawatan di rumah ( Home care )</div>
		 	<div class="col-4"></div>

		 	<div class="col-4">
		 	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Perawatan payudara</div>
		 	<div class="col-4">
		 	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> penanganan kejang/ demam / diare saat dirumah </div>
		 	<div class="col-4"></div>

		 	<div class="col-4">
		 	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pemantauan diet</div>
		 	<div class="col-4">
		 	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain – lain 
		 		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?></div>
		 	<div class="col-4"></div>
		 </div><br>

		 <b>Bila salah satu jawaban “ Ya “ dari kriteria perencanaan pulang dibawah ini, maka akan dilanjutkan dengan asesmen awal pasien pulang dalam kondisi khusus .</b>
		 <div class="row">
		 	<div class="col-5">
		 	1.	Geriatri</div>
		 	<div class="col-4">
		 	&emsp;
		 	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya    &emsp;
		 	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak</div>
		 	<div class="col-3"></div>

		 	<div class="col-5">
		 	2.	Umur > 65 tahun</div>
		 	<div class="col-4">
		 	&emsp;
		 	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya    &emsp;
		 	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak</div>
		 	<div class="col-3"></div>

		 	<div class="col-5">
		 	3.	Keterbatasan mobilitas</div>
		 	<div class="col-4">
		 	&emsp;
		 	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya    &emsp;
		 	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak</div>
		 	<div class="col-3"></div>

		 	<div class="col-5">
		 	4.	Perawatan lanjutan ( menggunakan alat, perawatan luka dll)</div>
		 	<div class="col-4">
		 	&emsp;
		 	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya    &emsp;
		 	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak</div>
		 	<div class="col-3"></div>

		 	<div class="col-5">
		 	5.	Pengobatan lanjutan ( DM, TBC,Jantung, kemoterapi dll )</div>
		 	<div class="col-4">
		 	&emsp;
		 	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya    &emsp;
		 	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak</div>
		 	<div class="col-3"></div>

		 	<div class="col-5">
		 	6.	Bantuan untuk melakukan aktifitas sehari-hari</div>
		 	<div class="col-4">
		 	&emsp;
		 	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya    &emsp;
		 	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak</div>
		 	<div class="col-3"></div>
		 </div>                 


		 <b>Asesmen transportasi</b><br>
		 <div class="row">
		 	<div class="col-3">
		 		1.	Transportasi pulang                  :
		 	</div>
		 	<div class="col-9">
		 		&emsp;
		 		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Mandiri □ Berjalan &emsp;
		 		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Dibantu sebagian   &emsp;
		 		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Dibantu keseluruhan 
		 	</div>

		 	<div class="col-3">
		 		2.	Transportasi yang digunakan  :
		 	</div>
		 	<div class="col-9">
		 		&emsp;
		 		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kendaraan pribadi ( mobil , beroda dua ) &emsp;
		 		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Mobil ambulance <br>
		 		&emsp;
		 		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kendaraan umum sebutkan <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?>
		 	</div>
		 </div><br><br>
			<div class="row">
				<div class="col-2"></div>
				<div class="col-8">
					<table width="100%" border="1px">
	       	<tr class="text-center">
	       		<th>Perawat / Bidan yang melakukan pengkajian</th>
	       		<th>Verifikasi DPJP/th>
	       	</tr>
	       	<tr>
	       		<th>Tanggal :
	       			<?=input($arr_data[$i-1], "data_{$i}", "date", "", "");$i++;?>,&emsp;Pkl 
	       		<?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?> Selesai</th>
	       		<th>Tanggal :
	       			<?=input($arr_data[$i-1], "data_{$i}", "date", "", "");$i++;?>,&emsp;Pkl 
	       		<?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?> Selesai</th>
	       	</tr>
	       	<tr>
	       		<td><br><br><br><br><br><br><br><br></td>
	       		<td><br><br><br><br><br><br><br><br></td>
	       	</tr>
	       	<tr class="text-center">
	       		<td>Tanda Tangan dan Nama Jelas</td>
	       		<td>Tanda Tangan dan Nama Jelas</td>
	       	</tr>
	       </table>
	       Rev. 5, Januari 2017
				</div>
	       
		</div>
       
       

                                                                                                
<br>
<input type="hidden" name="i" value="<?=$i;?>">
<?php if(isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])): ?>
	&nbsp;
<?php elseif(isset($_REQUEST['id'])): ?>
	<button type="submit" class="btn btn-primary">Ganti</button>
	</form>
<?php else:?>
	<button type="submit" class="btn btn-success">Simpan</button>
	</form>
<?php endif; ?>
<!-- <div style="text-align: right"><img style="width: 350px" class="text-right" src="../../images/alamat.jpg"></div> -->

	<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery-1.9.1.js"></script>
	<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery.form.js"></script>
    <script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>
    <script type="text/javascript" src="../../theme/js/ajax.js"></script>
	<script src="../../theme/bs/bootstrap.min.js"></script>
	<script type="text/javascript">
		$(document).ready(() => {
			dewasa();
			anak();
		});
		function dewasa() {
			let dNo = 0;
			let dewasa = document.getElementsByClassName('dewasa');;
			for(let i = 1; i < dewasa.length; i++) {
				if (dewasa[i].checked) {
					dNo += parseInt(dewasa[i].value);
				}
			}	
			$('#total').html(dNo);
		}
		function anak() {
			let aNo = 0;
			let anak = document.getElementsByClassName('anak');;
			for(let i = 1; i < anak.length; i++) {
				if (anak[i].checked) {
					aNo += parseInt(anak[i].value);
				}
			}	
			$('#total2').html(aNo);
		}
	</script>
</body>

</html>