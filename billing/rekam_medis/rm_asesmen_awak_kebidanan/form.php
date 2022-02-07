<?php
	use yii\helpers\Html;
	include '../function/form.php';
	include '../../koneksi/konek.php';
	include 'funct.php';
	$dataPasien = getIndetitasPasien($_REQUEST['idKunj']);
    $query1 = mysql_query("SELECT * FROM tb_riwayat_persalinan WHERE id_pasien = {$dataPasien['id']}");
    $query3 = mysql_query("SELECT * FROM tb_kala WHERE id_pasien = '{$dataPasien['id']}' AND tipe = '2'");
    $query2 = mysql_query("SELECT * FROM tb_kala WHERE id_pasien = '{$dataPasien['id']}' AND tipe = '1'");

	$i = 1;
	$num = 1;
	if(isset($_REQUEST['cetak'])) {
		$print_mode = true;
		echo "<script>window.print();</script>";
		$data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_asesmen_awak_kebidanan WHERE id = '{$_REQUEST['cetak']}'"));
		$arr_data = explode("|", $data['data']);
	}

	if(isset($_REQUEST['id'])) {
		$data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_asesmen_awak_kebidanan WHERE id = '{$_REQUEST['id']}'"));
		$arr_data = explode("|", $data['data']);
	}

	if(isset($_REQUEST['idx'])) {
		date_default_timezone_set("Asia/Jakarta");
		$id_kunj = (int)$_REQUEST["id_kunjungan"];
		$sql = mysql_fetch_assoc(mysql_query("SELECT pasien_id FROM b_kunjungan WHERE id = '$id_kunj'"));
		$iCount = mysql_real_escape_string($_REQUEST['i']);
		$str = "";
		for ($i=1; $i < $iCount; $i++) { 
			$data = mysql_real_escape_string($_REQUEST["data_{$i}"]);
			if ($data == "") {
				$str .= "#";
				$str .= "|";
			} else {
				$str .= $data;
				$str .= "|";
			}
		}
	
		$data = [
			'id_pasien' => $sql['pasien_id'],
			'id_kunjungan' => mysql_real_escape_string($_REQUEST['id_kunjungan']),
			'id_pelayanan' => mysql_real_escape_string($_REQUEST['id_pelayanan']),
			'tgl_act' => date('Y-m-d H:i:s'),
			'id_user' => mysql_real_escape_string($_REQUEST["id_user"]),
			'data' => $str
		];
		update('rm_asesmen_awak_kebidanan', $_REQUEST['idx'], $data);
	    echo "<script>window.location.href='index.php?idKunj=".$_REQUEST['idKunj']."&idPel=".$_REQUEST['idPel']."&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['idUser']."&tmpLay=".$_REQUEST['tmpLay']."'</script>";

	}

	if (isset($_REQUEST['pdf'])) {
    $print_mode = true;
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_asesmen_awak_kebidanan WHERE id = '{$_REQUEST['pdf']}'"));
    $arr_data = explode("|", $data['data']);

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
	*{
		margin-bottom:3px;
		margin-top:3px;
	}
		.inv {
			background-color: transparent;
			border :none;
			cursor :default;
		}
		td, th {
			padding:5px;
		}
		.row {
			margin-bottom:8px;
		}
		.newline {
			margin-left:30px;
		}
	</style>
	<script src="../html2pdf/ppdf.js"></script>
	<script src="../html2pdf/pdf.js"></script>
</head>

<body style="padding:20px" id="pdf-area">
	<div class="bg-white" style="padding:25px">
		<div class="row">
			<div class="col-6 text-center"><br><br>
				<img src="../logors1.png">
			</div>
			<div class="col-6" style="padding:15px">
					
				<div style="float: right">RM 5.1 / PHCM</div>
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
		<center><h2>ASESMEN  AWAL  KEBIDANAN  RAWAT INAP (ANTE, INTRA,POST PARTUM)</h4></center>
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

<b>I. ASESMEN  MEDIS (diisi oleh dokter)</b><br>
<div class="newline">
	Petunjuk : Beri tanda ( √ ) pada kolom yang di anggap sesuai<br>
    Asesmen dimulai tanggal: 
	<?=input($arr_data[$i-1], "data_{$i}", "date", "", "");$i++;?>,&emsp;Pkl 
	<?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?>,&emsp;Masuk kamar bersalin tanggal 
	<?=input($arr_data[$i-1], "data_{$i}", "date", "", "");$i++;?>,&emsp;pukul 
	<?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?><br>
	<b>A.	Anamnesis</b><br>
	1.	Keluhan Utama ( lama, pencetus ) : <br>
	<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>

	2. Riwayat kehamilan  sekarang :<br>
	<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>

	3. Riwayat Penyakit Dahulu ( termasuk riwayat operasi ) : <br>
	<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>

	4. Riwayat Penyakit Keluarga : 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada    &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada, sebutkan 
	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> <br>

	5. Riwayat pekerjaan : Apakah pekerjaan pasien berhubungan dengan zat-zat berbahaya ( misalnya : <br> kimia, Gas dll )  
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />Tidak ada  &emsp;
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
		</div>
	</div>
	
	<b>B.	Pemeriksaan Fisik </b><br>
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

	5.	Pemeriksaan :  Status generalis dan status lokalis (inspeksi, palpasi, perkusi dan auskultasi) pemeriksaan obstetri  <br>
	<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?> <br>

	<b>C.	Pemeriksaan Penunjang (Laboratorium, Radiologi, dll)</b> <br>
	<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>
	<br>
	<b>D.	Diagnosis kerja: </b>
	G <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:10%");$i++;?> &emsp;
	P <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:10%");$i++;?> &emsp;
	A <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:10%");$i++;?> 
	Anak hidup <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:10%");$i++;?>, 
	<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>
	<br>
	<b>E.	Diagnosis banding	: </b><?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>
	<br>
	<b>F.	Perencanaan Pelayanan Penatalaksanaan /Pengobatan </b><br>
    (Terapi, tindakan, konsultasi, pemeriksaan penunjang lanjutan, edukasi, dsb) <br>
	<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?> <br>

	Rencana pulang : <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:10%");$i++;?> hari <br>
	<div class="row">
		<div class="col-3"></div>
		<div class="col-6">
			<table border="1px" class="text-center" width="100%">
				<tr>
					<td>Diisi Oleh DPJP</td>
				</tr>
				<tr>
					<td>
						Tanggal : 
						<?=input($arr_data[$i-1], "data_{$i}", "date", "", "");$i++;?>, &emsp;Pkl
						<?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?> Selesai
					</td>
				</tr>
				<tr>
					<td><br><br><br><br><br><br><br></td>
				</tr>
				<tr>
					<td>Tanda Tangan dan Nama Jelas</td>
				</tr>
			</table>
		</div>
</div>

<b>II.	ASSESMEN  KHUSUS KEBIDANAN / PERSALINAN ( dilakukan oleh bidan )</b><br>
<div class="newline">
	Petunjuk : beri tanda ( √ ) pada kolom yang di anggap sesuai <br>
	Masuk kamar bersalin&emsp;Tanggal : 
	<?=input($arr_data[$i-1], "data_{$i}", "date", "", "");$i++;?> Pukul 
	<?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?>,&emsp;Asesmen mulai tanggal 
	<?=input($arr_data[$i-1], "data_{$i}", "date", "", "");$i++;?>,&emsp;pukul 
	<?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?> <br>
	Diperoleh dari 
	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>,&emsp;Hubungan dengan pasien 
	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> <br>
	Asal pasien   : 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> IGD &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Poliklinik &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Perawatan &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Rujukan : dokter/ bidan/ klinik/ rumah sakit/ RB &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> lain-lain 
	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> <br>
	Cara masuk  : 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Jalan tanpa bantuan &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Jalan dengan bantuan   &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Dengan kursi roda &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Dengan strethcer <br>
	<b>A. Anamnesis  :</b><br>
	<div class="newline">
		1.	  Keluhan utama: <br>
		<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>
		2.	Tanda-tanda persalinan : mules/ kontraksi mulai tanggal 
		<?=input($arr_data[$i-1], "data_{$i}", "date", "", "");$i++;?>&emsp;pukul
		<?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?>, keluar darah lendir/<br>
		&emsp;darah/air ketuban : 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> ada / 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak , jika ada mulai tanggal  
		<?=input($arr_data[$i-1], "data_{$i}", "date", "", "");$i++;?>&emsp;pukul 
		<?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?> <br>
		3.	 HPHT :
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:10%");$i++;?> Taksiran Partus:
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:10%");$i++;?> ,&emsp;Haid sebelumnya : 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:10%");$i++;?> Perkawinan 
		<?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:10%");$i++;?> kali ,lamanya 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:10%");$i++;?><br>
		&emsp;Menarche usia : 
		<?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:10%");$i++;?> tahun,&emsp;haid teratur/ tidak , siklus 
		<?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:10%");$i++;?> hari <br>

		4.	 Pemeriksaan Antenatal : oleh 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> dokter / 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> bidan  &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Terdaftar &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak terdaftar  &emsp;  
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Teratur / tidak  
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
		<?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:10%");$i++;?> kali <br>
		5.	 Penyakit-penyakit selama kehamilan :   
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada / 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak  &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Anemi  &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Vitium cordis &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Diabetes &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hipertensi &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TBC  <br>
		&emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hepatitis  &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> ACA &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> ISK   &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Infeksi
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> pernah,&emsp;RI Diagnosa 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> <br>

		6.      Riwayat penyakit keluarga                : 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada , sebutkan 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?><br>
		7.      Riwayat operasi : 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada / 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak ,&emsp;jenis op 
		<?=input($arr_data[$i-1], "data_{$i}", "", "text", "");$i++;?> tahun 
		<?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:10%");$i++;?> tempat 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?><br>
		8.      Komplikasi kehamilan sebelumnya : 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada / 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak   &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> HAP   &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> HPP  &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> PEB / PER / Eklamsi   &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> lain-lain 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?><br>
		9.      Riwayat imunisasi                              : 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TT I             &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />TT II             &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TT III           &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak pernah <br>
		10.    Alergi obat, makanan                        : Obat : 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada , sebutkan 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?><br>
		&nbsp;&nbsp;&emsp;Makanan : 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada , sebutkan 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> <br>

		11.   Golongan darah ibu                          : 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> A    &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> B     &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> O     &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> AB&emsp;Rh : 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Positif  &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Negatif <br>
        &nbsp;&nbsp;&emsp;Golongan darah suami                      : 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> A    &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> B     &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> O     &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> AB&emsp;Rh : 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Positif  &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Negatif <br>
		12.   Pekerjaan pasien                               : 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> PNS/ TNI/ POLRI &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Swasta &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pensiun &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pelajar/Mahasiswa &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />Lain-lain:  <br>
		13.   Pekerjaan suami/penanggung jwb : 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> PNS/ TNI/ POLRI &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Swasta &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pensiun &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain : 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> <br>
		14.   Pendidikan pasien                              : 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> SD &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> SMP &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> SLTA &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Akademi/PT  &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pasca sarjana &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain : 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> <br>
		15.   Pendidikan suami/penanggung jwb: 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> SD &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> SMP &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> SLTA &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Akademi/ PT &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pasca sarjana &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain : 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> <br>

		16.   <b>Sosial , Spiritual, nilai kepercayaan, suku budaya : </b><br>
		<div class="newline">
			a.	Tinggal bersama : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Suami &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Orang tua/ mertua &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> <br>
			b.	Agama    : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Islam &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kristen &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Protestan &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Katholik &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hindu &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Budha &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Konghucu  <br>
			&emsp;Memerlukan pelayanan kerohanian :  
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak <br>
			c.	Nilai-nilai kepercayaan pasien / keluarga: 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada  &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada <br>
			&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak mau dilakukan tranfusi &emsp;
			&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak mau pulang dihari tertentu  <br>
			&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak mau imunisasi &emsp;
			&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak mau dirawat petugas laki-laki/ perempuan  <br>
			&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak memakan daging / ikan yang bersisik &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain – lain 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> <br>
			d.   Kebutuhan privasi pasien    :  
			&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak &emsp;
			&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya  <br>
			&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Keinginan waktu / tempat khusus saat wawancara & tindakan 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> <br>
			&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kondisi penyakit/ Pengobatan  <br>
			&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak menerima kunjungan, sebutkan jika ada 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> <br>
			&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Transportasi  &emsp;
			&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> lain – lain 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> <br>
			<b>e.</b> Suku/ budaya : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> <br>
		</div>
		17. <b>Riwayat kehamilan ,Persalinan dan nifas  :</b> 
		G <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:10%");$i++;?> &emsp;
		P <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:10%");$i++;?> &emsp;
		A <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:10%");$i++;?> &emsp;
		Anak hidup <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> <br>
		<table class="text-center" border="1px" width="100%">
			<tr>
				<td rowspan="2">No</td>
				<td rowspan="2">Tgl, Bln & Thn Persalinan</td>
				<td rowspan="2">Tempat Persalinan</td>
				<td rowspan="2">Usia Kehamilan</td>
				<td rowspan="2">Jenis Persalinan</td>
				<td rowspan="2">Penolong</td>
				<td rowspan="2">Penyulit Kehamilan Persalinan , Nifas</td>
				<td colspan="3">Anak</td>
			</tr>
			<tr>
				<td>Jenis Kel</td>
				<td>BB/PB</td>
				<td>Keadaan</td>
			</tr>
			<?php while($row = mysql_fetch_assoc($query1)): ?>
                <tr>
                    <td><?=$no;$no++;?></td>
                    <td><?=$row['tgl_persalinan'];?></td>
                    <td><?=$row['tempat'];?></td>
                    <td><?=$row['usia_kehamilan'];?></td>
                    <td><?=$row['jenis_persalinan'];?></td>
                    <td><?=$row['penolong'];?></td>
                    <td><?=$row['penyulit'];?></td>
                    <td><?=$row['jk'];?></td>
                    <td><?=$row['bb'];?></td>
                    <td><?=$row['keadaan'];?></td>
                </tr>
            <?php endwhile; ?>
		</table><br>
		18. Kebiasaan ibu waktu hamil :  
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Obat – obatan yang minum  &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Vitamin  &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain : 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?><br>
       &nbsp;&emsp;
	   <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Jamu – jamuan    &emsp;
	   <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya / Tidak &emsp;
	   <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Merokok	     &emsp;
	   <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya / Tidak  &emsp;
	   <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Lain-lain, sebutkan 
	   <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?><br>
      &nbsp;&emsp;Obat  yang dibawa dari rumah:    
	   <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada    &emsp;
	   <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada, lakukan rekonsiliasi ke farmasi  <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?><br>
		19. Kegiatan/ kursus yang diikuti  ibu hamil : Senam hamil : 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak,&emsp;Kursus pra persalinan    : 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak <br>
		&nbsp;&emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Konsul Laktasi &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya/Tidak <br>

		20. <b>Pemeriksaan fisik :</b> <br>
		<div class="newline">
			a.	Keadaan umum 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:10%");$i++;?>, kesadaran &emsp;
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:10%");$i++;?> TD &emsp;
			<?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:10%");$i++;?> mmHg , &emsp;Nadi 
			<?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:10%");$i++;?> x/mnt , &emsp;RR 
			<?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:10%");$i++;?> X/mnt,<br> 
			&emsp;Suhu 
			<?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:10%");$i++;?> C , &emsp;BB 
			<?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:10%");$i++;?> kg , &emsp;BB sebelum hamil: 
			<?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:10%");$i++;?> kg , &emsp;TB 
			<?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:10%");$i++;?> cm <br>
			b.	Rambut & kepala : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bersih &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kotor &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kusam &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Rontok <br>
			c.	Wajah         : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> normal  &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Edema &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hiperpigmentasi/ cloasma gravidarum <br>
			d.	Mata            : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Normal  &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sklera ikterik  &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Edema palpebrae &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Konjungtiva anemis <br>
			&emsp;Penglihatan : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Normal  &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Myopia 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:5%");$i++;?> &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> lensa kontak/ kaca mata &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Buta &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> lain-lain 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> <br>
			e.	Telinga / pendengaran : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Normal &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> gangguan pendengaran &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tuli &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Menggunakan alat bantu dengar <br>
			f.	Hidung        : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Normal    &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Terganggu, jelaskan 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?><br>
			g.	Mulut, gigi, lidah : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Normal  &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Terganggu, jelaskan 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> <br>
			h.	Leher           : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Normal    &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada benjolan, jelaskan 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> <br>
			i.	Payudara     : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada kelainan, &emsp;Puting susu :
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Datar &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Menonjol, Colostrum : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada <br>
			j.	Pernafasan  : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Normal     &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Dyspneu &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tacypneu &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bradypneu &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ronchi/ wheezing, jelaskan 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?><br>
			&emsp;Batuk            : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada  &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada, jelaskan 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?><br>
			k.	Abdomen    : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada kelainan, jelaskan 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> <br>
			l.	Ekstremitas atas :  
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK  &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada , jelaskan 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?><br>
			&emsp;Ektremitas bawah: 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK  &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada , jelaskan 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?><br>
			m.	Reflek lutut : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK     &emsp;       
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada kelainan , jelaskan 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?><br>
			n.	Kulit              : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Normal     &emsp; 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kering &emsp; 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kusam &emsp; 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pucat &emsp; 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Rash &emsp; 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Gatal – gatal , jelaskan 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?><br>
			o.	Genitalia      : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bersih       &emsp; 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Keputihan, warna 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>, &emsp; 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> gatal / 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak , &emsp; 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> berbau/ 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak , &emsp; 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> banyak/ 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> sedikit <br>
			&emsp;Anus              : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK        &emsp;  
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada haemoroid / fistula 
		</div>

		21. <b>Asesmen nyeri    :</b> 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada, Dengan skala nyeri NRS/ VAS, deskripsi <br>
			<div class="newline">
			<b>Provokes :</b> 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Benturan &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kehamilan / kontraksi  &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Proses persalinan, &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain, 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?> <br>
			<div class="row">
				<div class="col-1"><b>Quality :</b> </div>
				<div>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Seperti tertusuk-tusuk benda tajam/ tumpul &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Berdenyut &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Terbakar <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tertindih benda berat &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Diremas    &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Terplintir   &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Teriris – teriris &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain 
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?> <br>
				</div>
			</div>
			
			
			<b>Region     :</b> 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lokasi : 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?>  &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Menyebar: 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak    &emsp;    
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?>    <br>
			<b>Severity   :</b> 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> VAS/NRS,&emsp;Score : 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?>&emsp;Time/durasi nyeri : 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?> <br>
			<b>Lanjut asesmen lanjutan nyeri dan intervensi  sesuai kondisi / jika ada keluhan nyeri</b>
		</div>
		22. <b>Asesmen risiko jatuh menggunakan skala risiko jatuh Morse Fall Scale :</b><br>
      &emsp;&nbsp;
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Risiko rendah 0 – 24 &emsp;
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Risiko sedang 25 – 44  &emsp; 
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Risiko tinggi > 45 <br>
      &emsp;&nbsp;
      Risiko tinggi : lanjut asesmen lanjutan risiko jatuh     <br>      


      23. <b>Asesmen fungsi  kognitif dan motorik : </b> <br>
      &emsp;&nbsp;Pasien mengerti tentang kehamilannya : 
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya &emsp;
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak tahu, menginginkan informasi tentang  <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?> <br>
     &emsp;&nbsp;<b>Motorik : </b> <br>
     <ul>
     	<li>Aktifitas sehari-hari:  
     	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Mandiri &emsp;
     	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bantuan minimal &emsp;
     	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ketergantungan sebagian besar &emsp;
     	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ketergantungan total <br></li>
     	<li>
     		<div class="row">
     		<div class="col-1">Berjalan :</div>
     		<div>
     			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada kesulitan   &emsp;
		     	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Perlu bantuan &emsp;
		     	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sering jatuh &emsp;
		     	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kelumpuhan &emsp;
		     	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Paralisis <br>
		     	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Deformitas&emsp;
                <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hilang keseimbangan
     		</div>
     	</div>
     	</li>
     	<li>Riwayat patah tulang: 
     	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada &emsp;
     	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada Sebutkan, 
     	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?> </li>
     	<li>Alat ambulasi            : 
     	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Walker &emsp;
     	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tongkat &emsp;
     	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kursi roda &emsp;
     	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak menggunakan</li>
     	<li>Ekstremitas atas dan bawah    : 
     	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK &emsp;
     	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada sebutkan, 
     	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?></li>
     	<li>Kemampuan menggengam      : 
     	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK &emsp;
     	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada kesulitan sebutkan, 
     	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?></li>
     	<li>Kemampuan koordinasi           : 
     	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK &emsp;
     	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada masalah sebutkan , 
     	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?></li>
     	<li>Kesimpulan gangguan fungsi   : 
     	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya ( Konsul DPJP ) &emsp;
     	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ( Tidak perlu konsul DPJP))</li>
     </ul>

    24. <b>Status Psikologis :</b> 
    <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tenang &emsp;
    <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Marah &emsp;
    <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sedih  &emsp;
    <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Cemas &emsp;
    <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Depresi &emsp;
    <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hiperaktif &emsp;
    <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain 
    <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?><br>

    25. <b>Kebutuhan informasi, komunikasi dan edukasi : </b><br>
    <div class="newline">
	a.	Bicara  : 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Normal   &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada , jelaskan  
	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?><br>
	b.	Bahasa sehari-hari : 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Indonesia &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Daerah 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Inggris aktif/ pasif &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <br>
	c.	Perlu penterjemah : 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak    &emsp;   
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya, bahasa 
	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?>,  &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bahasa isyarat   &emsp; 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya  &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak  <br>
	<div class="row">
		<div class="col-2">
			d.	Hambatan belajar   :
		</div>
		<div>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bahasa &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kognitif  &emsp;     
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pendengaran &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Emosi &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Motivasi buruk  <br>
	         <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Masalah penglihatan 
	         <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kesulitan bicara   
	         <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain 
	         <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?>
		</div>
	</div>
	<div class="row">
		<div class="col-4">e.	Pasien menginginkan informasi tentang : </div>
		<div>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Proses persalinan &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> IMD &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> ASI Esklusif &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> nutrisi &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> obat  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tindakan 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Manajemen nyeri 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain–lain 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?>
		</div>
	</div>
	</div>
	26. <b>Asesmen gizi ibu hamil</b><br>
		<div class="newline">
	      Kenaikan BB selama hamil : 
	      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> < 10 kg  	&emsp;      
	      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 10 – 12 kg   &emsp;        
	      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 12 – 16 kg   &emsp;           
	      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> > 16kg <br>
	      Risiko Nutrisi	          : 
	      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> skor 0 (12-16kg)    &emsp;
	      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> skor 1 (10-12kg) &emsp;
	      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> skor 2 (<10 kg dab > 16 kg) <br>
	      <b>Penyakit Penyerta jika ada salah satu penyerta penyakit skor 2 </b><br>
	      
	      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> DM &emsp;
	      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hipertensi &emsp;
	      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Hepatitis  &emsp;
	      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TBC  &emsp;
	      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> PEB / Eklamsia &emsp; 
	      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Anemia <br>
	      <b>Risiko Nutrisi : </b>
	      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak jika skor < 2   &emsp;  
	      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya jika skor > 2 (jika ya lanjut asesmen dan asuhan gizi) <br>
      </div>

      27. <b>Pemeriksaan kebidanan</b><br>
      <div class="newline">
		 TFU 
		 <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:5%;height:20px");$i++;?> Cm,&emsp;TBJ 
		 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:10%;height:20px");$i++;?> &emsp; Letak 
		 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:10%;height:20px");$i++;?> &emsp; Presentasi 
		 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:10%;height:20px");$i++;?> &emsp; Penurunan 
		  <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:10%;height:20px");$i++;?>,&emsp; Kontraksi/HIS 
		 <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:5%;height:20px");$i++;?>.X/10’, <br>
		 Kekuatan 
		 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?> lamanya &emsp;
		 <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:5%;height:20px");$i++;?> detik.&emsp;Gerak janin 
		 <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:5%;height:20px");$i++;?> x/30 menit,&emsp;BJJ 
		 <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:5%;height:20px");$i++;?> /mnt  &emsp;
		 <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Teratur &emsp;     
		 <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak teratur   <br>
		 Tgl / jam 
		 <?=input($arr_data[$i-1], "data_{$i}", "date", "", "");$i++;?> / <?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?> &emsp; PD a/I 
		  <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:10%;height:20px");$i++;?>.&emsp;oleh 
		 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:10%;height:20px");$i++;?> &emsp; Portio 
		 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:10%;height:20px");$i++;?> &emsp;Pembukaan servik 
		 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:5%;height:20px");$i++;?> cm <br>
			Ketuban   
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?> kep / bok,&emsp;Hodge 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?>
	</div>

	28. <b>Pemeriksaan penunjang </b><br>
	<div class="newline">
      Inspekulo	   : 
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Dilakukan / 
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak, Hasil 
      <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:40%");$i++;?> <br>
      CTG/ USG 	   : 
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Dilakukan / 
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak, Hasil 
      <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:40%");$i++;?> <br>
      Laboratorium / Lakmus : 
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Dilakukan / 
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak,  Hasil 
      <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:40%");$i++;?> <br>
      Pemeriksaan panggul :  
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Luas    &emsp;  
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sedang   &emsp;     
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sempit   &emsp; 
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak dilakukan pemeriksaan  <br>
    </div>
		 <b> 
    		<div class="row">
    			<div class="col-2">29. Diagnosa:</div>
    			<div class="col-10">
    				Ibu  : G 
				    <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:5%");$i++;?> &emsp;P 
				    <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:5%");$i++;?> &emsp;A 
				    <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:5%");$i++;?> &emsp;Hamil 
				    <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:5%");$i++;?> mg, &emsp;
				    <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:5%");$i++;?> hr dengan 
				    <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:30%");$i++;?> <br>
				    Bayi : 
				    <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:50%");$i++;?> <br>
					Prognosa : &emsp;Ibu : 
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Baik &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Buruk,&emsp;Bayi : 
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Baik &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Buruk
    			</div>
			</div>
	   </b>

	   30. <b> Masalah kebidanan Ante partum : </b> <br>
	   <div class="newline">
		   <div class="row">
		   		<div class="col-3"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kontraksi/ Nyeri</div>
		   		<div class="col-3"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ketuban Pecah Dini</div>
		   		<div class="col-3"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Infeksi / sepsis</div>
		   		<div class="col-3"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Inersia uteri</div>

		   		<div class="col-3"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Placenta Previa Totalis</div>
		   		<div class="col-3"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Plasenta Previa Marginalis</div>
		   		<div class="col-3"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> IUFD</div>
		   		<div class="col-3"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kontraksi Hpertonik</div>

		   		<div class="col-3"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> PTM</div>
		   		<div class="col-3"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Gawat janin</div>
		   		<div class="col-6"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:60%");$i++;?></div>
		   </div>

      </div>


      31. <b>Tindakan kebidanan :</b><br>  <?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?> <br>

      32.  Perencanaan keperawatan interdisipliner :  <br>
      <div class="newline">
	      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Diet dan nutrisi tidak / ya  
	      <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:30%");$i++;?> &emsp;
	       <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Rehabilitasi medik tidak/ ya 
	       <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:30%");$i++;?> <br>
	       
	       <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Farmasi tidak / ya 
	       <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:30%");$i++;?>  &emsp;
	       <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Manajemen nyeri tidak/ ya 
	       <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:30%");$i++;?> <br><br>
       </div>

       <center><h4><u>CATATAN PERSALINAN</u></h4></center><br>
       Tgl : <?=input($arr_data[$i-1], "data_{$i}", "date", "", "");$i++;?>&emsp;
       Penolong persalinan : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:50%");$i++;?> <br><br>

       <b>KALA - l</b><br>
		Lama Kala-l : 
		<?=input($arr_data[$i-1], "data_{$i}", "date", "", "");$i++;?>&emsp;Pkl 
		<?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?>  Menit <br>
		Partogram melewati garis waspada : <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya&emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak <br>
		Penatalaksanaan yang dilakukan 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:30%");$i++;?>&emsp;Bagaimana hasilnya 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:30%");$i++;?> <br><br>

		<b>KALA - II</b><br>
		Cara persalinan       :
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Spontan  &emsp;  
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Forcep   &emsp;  
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Vakum    &emsp;  
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> SC    &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Indikasi 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:30%");$i++;?> <br>
		Lama kala-ll	      : Lama di pimpin meneran
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:30%");$i++;?> <br>
		Gawat Janin	      : 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Miring ibu kekiri	&emsp;         
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ibu diminta tarik nafas &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> O2 
		<?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:10%");$i++;?> Liter/ mnt  <br>
		Distosia bahu	      : 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Manuver MC Robert &emsp;  
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain –lain 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:30%");$i++;?> <br>
		<b>Bayi baru lahir</b><br>

		Jam 
		<?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?> Jenis kelamin : 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> L / 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> P,&emsp;   
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> A / 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> S 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:30%");$i++;?> &emsp;BB 
		<?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:30%");$i++;?> gr,&emsp;PB 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:30%");$i++;?> cm,&emsp;LK 
		 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:30%");$i++;?>,&emsp;LD 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:30%");$i++;?> cm,&emsp;LP 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:30%");$i++;?> cm <br>
		Anus  : 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada / 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak , Cacat bawaan :  
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada / 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak, jika ada 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:30%");$i++;?> <br>
		Resusitasi awal	
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Mengeringkan   &emsp;  
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Menghangatkan   &emsp;    
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bebaskan jalan nafas	&emsp;            
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Stimulasi/rangsang taktil <br>
		Penatalaksanaan yang dilakukan      
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> O2 
		<?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:5%");$i++;?> Lt/mnt   &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bagging     &emsp; 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Vit K, Injeksi &emsp;   
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Neopuff <br>
		Inisiasi Menyusu Dini (IMD)              
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya 	  &emsp;               
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak, alasan : 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:30%");$i++;?> <br>

		<b>KALA - lll : lamanya : 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:30%");$i++;?> menit , &emsp;jumlah perdarahan : 
		<?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:30%");$i++;?> ml</b> <br>
		a.	Pemberian oksitosin 10 u.i.m. 2 menit  
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak, alasan : 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:30%");$i++;?><br>
		b.	Peregangan tali pusat terkendali            
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak, alasan : 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:30%");$i++;?><br>
		c.	Massage uteri                                          
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak, alasan : 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:30%");$i++;?><br>
		<div class="row">
			<div class="col-3">
				d.	Plasenta lahir jam     : 
				<?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?> <br>
				&emsp;Plasenta tidak lahir > 30 menit	    : <br>
				&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kontraksi ireguler/antonia uteri        : <br>
				&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kompresi bimanual internal               : <br>
				&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Penatalaksanaan yang  dilakukan     : 
			</div>
			<div>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Spontan  &emsp;  
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Manual   &emsp;  
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lengkap / 
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak, jika tidak 
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:30%");$i++;?> <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya  &emsp;
        		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Manual     <br>
        		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Syntosinon drip &emsp;
        		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Metil ergometrin 0,2 mg i.m / iv  <br>
        		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain 
        		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:30%");$i++;?><br>
		        <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kuretase  &emsp;
        		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Explorasi 
			</div>
		</div>
		e.	Perineum  : 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Episiotomi  &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lacerasi tk 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:10%");$i++;?> 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Utuh &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hecting  &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kromik / vicril/plain,&emsp;
		Lain – lain 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:10%");$i++;?><br>
		<b>KALA - lV<br>
		Jam 1 : tiap 15 menit : </b> <br>
		<table class="text-center" width="100%" border="1px">
			<tr>
				<th>No</th>
				<th>Jam</th>
				<th>TENSI</th>
				<th>NADI</th>
				<th>SUHU</th>
				<th>RR</th>
				<th>TFU</th>
				<th>Konstraksi Uterus</th>
				<th>Pendarahan</th>
			</tr>
			<?php while($row = mysql_fetch_assoc($query2)): ?>
        <tr>
            <td><?=$no;$no++;?></td>
            <td><?=$row['jam'];?></td>
            <td><?=$row['tensi'];?></td>
            <td><?=$row['nadi'];?></td>
            <td><?=$row['suhu'];?></td>
            <td><?=$row['rr'];?></td>
            <td><?=$row['tfu'];?></td>
            <td><?=$row['konstraksi'];?></td>
            <td><?=$row['pendarahan'];?></td>
        </tr>
    <?php endwhile; ?>
		</table><br>
		<b>Jam 2 : TIAP 30 menit</b><br>
		<table class="text-center" width="100%" border="1px">
			<tr>
				<th>No</th>
				<th>Jam</th>
				<th>TENSI</th>
				<th>NADI</th>
				<th>SUHU</th>
				<th>RR</th>
				<th>TFU</th>
				<th>Konstraksi Uterus</th>
				<th>Pendarahan</th>
			</tr>
			<?php while($row = mysql_fetch_assoc($query3)): ?>
        <tr>
            <td><?=$no;$no++;?></td>
            <td><?=$row['jam'];?></td>
            <td><?=$row['tensi'];?></td>
            <td><?=$row['nadi'];?></td>
            <td><?=$row['suhu'];?></td>
            <td><?=$row['rr'];?></td>
            <td><?=$row['tfu'];?></td>
            <td><?=$row['konstraksi'];?></td>
            <td><?=$row['pendarahan'];?></td>
        </tr>
    <?php endwhile; ?>
		</table><br>
		<b>f.	Masalah pasca persalinan :</b>	 <br>
       	&emsp;
       	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> HPP  &emsp;
       	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Plasenta acreta &emsp;
       	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Retensio plasenta &emsp;
       	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ruptur total &emsp;
       	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Atonia uteri &emsp;
       	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain 
       	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:30%");$i++;?><br>

       	<b>g. Tindakan :</b><br>
		<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?><br>

		<b>Bidan yang melakukan pengkajian</b><br><br><br><br><br>

    	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:20%");$i++;?> <br>
    	Tanda Tangan Dan Nama Jelas <br><br>

	    <center><h4><u>PERENCANAAN PULANG ( DISCHARGE PLANNING )</u></h4></center><br>

		Pasien dan keluarga dijelaskan tentang rencana pulang : 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya  <br>
		Lama perawatan rata- rata     : 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:30%");$i++;?> hari, tanggal rencana pulang : 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:30%");$i++;?> <br>
		Jika tidak masuk dalam kondisi khusus edukasi yang diberikan sebagai berikut: <br>
		
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Perawatan diri/ personal hygiene     &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Perawatan post partum  &emsp;     
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Perawatan bayi      &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pemberian obat   <br>             
		
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Perawatan luka	&emsp;                      
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Perawatan post &emsp;op              
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Nutrisi/ diit  &emsp;          
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Perawatan payudara       <br>
		
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Bantuan medis/ perawatan di rumah ( Home care )  &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain – lain   
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:45%");$i++;?> <br><br>

		<b>Bila salah satu jawaban “ Ya “ dari kriteria perencanaan pulang dibawah ini, maka akan dilanjutkan dengan asesmen awal pasien pulang dalam kondisi khusus .</b><br>
		<div class="row">
			<div class="col-5">
				1.	Keterbatasan mobilitas <br>
				2.	Gangguan psikologi <br>
				3.	Pengobatan lanjutan <br>
				4.	Perawatan lanjutan (menggunakan alat, perawatan luka dll) <br>
				5.	Bantuan untuk melakukan aktifitas sehari-hari
			</div>
			<div>
				: 
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya &emsp;    
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak <br>
				: 
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya &emsp;    
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak <br>
				: 
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya &emsp;    
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak <br>
				: 
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya &emsp;    
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak <br>
				: 
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya &emsp;    
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak <br>
			</div>
		</div>

		<b> Asesmen Transportasi</b> <br>
		<div class="row">
			<div class="col-3">
				1.	Transportasi pulang <br>
				2.	Transportasi yang digunakan
			</div>
			<div>
				: 
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Mandiri &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Berjalan &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Dibantu sebagian  &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Dibantu keseluruhan <br>
				: 
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kendaraan pribadi ( mobil , beroda dua ) &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Mobil ambulance <br>

				&nbsp;&nbsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kendaraan umum sebutkan <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:45%");$i++;?>
			</div>
		</div><br>

        <center>
	        <table class="text-center" width="90%" border="1px">
	        	<tr>
	        		<th>Bidan Yang Melakukan Pengkajian</th>
	        		<th>Verifikasi DPJP</th>
	        	</tr>
	        	<tr>
	        		<th>Tanggal : 
	        			<?=input($arr_data[$i-1], "data_{$i}", "date", "", "");$i++;?>, &emsp;Pkl 
	        		<?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?> Selesai</th>
	        		<th>Tanggal : 
	        			<?=input($arr_data[$i-1], "data_{$i}", "date", "", "");$i++;?>, &emsp;Pkl 
	        		<?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?> Verifikasi</th>
	        	</tr>
	        	<tr>
	        		<td><br><br><br><br><br></td>
	        		<td><br><br><br><br><br></td>
	        	</tr>
	        	<tr>
	        		<td>Tanda Tangan dan Nama Jelas</td>
	        		<td>Tanda Tangan dan Nama Jelas</td>
	        	</tr>
	        </table>
        </center><br><br>

        <center><b>LAPORAN PERSALINAN</b><br>
        	<table width="100%" border="1px">
        		<tr>
        			<td>Nama penolong : <?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
        			<td>Nama Asisten Persalinan : <br> <?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?></td>
        			<td>
        				Nama Asisten Bayi: <br><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?><br>
						Dokter Anak: <?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?>
					</td>
        		</tr>
        		<tr>
        			<td colspan="2">
        				Jenis anestesi : 
        				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lokal  &emsp;
        				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Umum <br>
						Jenis obat : 
        			 	<?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
        			<td>
        				Dr. Anestesi <?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?>
					</td>
        		</tr>
        		<tr>
        			<td colspan="2">
        				Penyulit /Komplikasi : 
        			 	<?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
        			<td>
        				Perdarahan :  <?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?>
					</td>
        		</tr>
        		<tr>
        			<td colspan="3">
        				<b>Laporan Persalinan </b>  <br>
        			 	<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?> <br><br>
        			 	<b>Terapi Pasca Persalinan </b>  <br>
        			 	<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?> <br><br>
        			 	<div class="text-right">
        			 		Jakarta , <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:150px");$i++;?> <br><br><br>
        			 		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?><br>
        			 		Tanda Tangan & Nama Jelas
        			 	</div>
        			</td>
        		</tr>
        	</table>

        </center>
        Januari 2017 <br><br>
        PARTOGRAF <br>
        <?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>
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
	<script>
	changed();

    function changed() {
	let selects = document.querySelectorAll(".inputC");
	let total = 0
	for (var i = 0; i < selects.length; i++) {
      if (selects[i].checked) {
        total += parseInt(selects[i].value);
      }
	}
	$('#total').html(total);
	}

	<?php if(isset($_REQUEST["pdf"])): ?>
		let identifier = '<?=$dataPasien["nama"]?>';
		printPDF('RM 5.1 '+identifier);
	<?php endif; ?>

	</script>
</body>

</html>