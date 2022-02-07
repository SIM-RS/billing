<?php
	use yii\helpers\Html;
	include '../function/form.php';
	include '../../koneksi/konek.php';
	include 'funct.php';
	$dataPasien = getIndetitasPasien($_REQUEST['idKunj']);
	$i = 1;

	if(isset($_REQUEST['cetak'])) {
		$print_mode = true;
		echo "<script>window.print();</script>";
		$data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_asesmen_neonatus WHERE id = '{$_REQUEST['cetak']}'"));
		$arr_data = explode("|", $data['data']);
	}

	if(isset($_REQUEST['id'])) {
		$data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_asesmen_neonatus WHERE id = '{$_REQUEST['id']}'"));
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
		update('rm_asesmen_neonatus', $_REQUEST['idx'], $data);
	    echo "<script>window.location.href='index.php?idKunj=".$_REQUEST['idKunj']."&idPel=".$_REQUEST['idPel']."&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['idUser']."&tmpLay=".$_REQUEST['tmpLay']."'</script>";

	}

	if (isset($_REQUEST['pdf'])) {
    $print_mode = true;
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_asesmen_neonatus WHERE id = '{$_REQUEST['pdf']}'"));
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
					
				<div style="float: right">RM 5.2 / PHCM</div>
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
		<center><h2>ASESMEN AWAL NEONATUS</h4></center>
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
Petunjuk : Beri tanda ( √ ) pada kolom yang di anggap sesuai <br>

<b>I. ASESMEN MEDIS ( Diisi oleh Dokter )</b><br>
&emsp;<b>A.	ANAMNESA</b> dimulai : Tanggal <?=input($arr_data[$i-1], "data_{$i}", "date", "", "");$i++;?>&emsp;Pkl <?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?> <br>

<div style="margin-left:40px">1. Keluhan Utama (mulai, lama, pencetus) :<br><?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?></div>
<div style="margin-left:40px">2. Riwayat penyakit sekarang  :<br><?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?></div>
<div style="margin-left:40px">3. Riwayat penyakit dahulu (termasuk riwayat operasi/ riwayat persalinan): <br><?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?></div>

<div style="margin-left:40px">
	<div class="row">
		<div class="col-3">
			4. Riwayat penyakit keluarga : <br><br>
			5. Riwayat alergi keluarga :
		</div>
		<div class="col-6">
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> DM&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> HIpertensi&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TBC&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Asthma&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hepatitis&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Jantung <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kelainan darah keluarga&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Lain-lain <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
			a. Obat&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak
			&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
			Ya Sebutkan : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?><br>
            b. Makanan <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak  
			&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
			Ya Sebutkan : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
			Lain – lain : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?>
		</div>
	</div>
</div>

&emsp;<b>B. PEMERIKSAAN UMUM / FISIK</b><br>
<div style="margin-left:40px">
<div class="row">
		<div class="col-3">
			1.	Keadaan umum : <br><br>
			2. Kesadaran : <br>
			3. GCS : <br>
			4. TTV : 
		</div>
		<div class="col-8">
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tampak tidak sakit &emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tampak sakit ringan &emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tampak sakit sedang &emsp;<br>
            <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tampak sakit berat <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kompos mentis&emsp;  
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Apatis&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Somnolen&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sopor&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Soporocoma&emsp;   
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Koma 
			<br>
			E : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?>&emsp;
			M : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?>&emsp;
			V : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?>
			<br>
			S <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:80px");$i++;?>&emsp;
			N <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:80px");$i++;?>&emsp;
			RR <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:80px");$i++;?>&emsp;
			SpO2 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:80px");$i++;?>&emsp;
			TD <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:80px");$i++;?>&emsp;
			Down Score <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:80px");$i++;?>
		</div>
</div>
</div>
<div style="margin-left:40px">5. Pemeriksaan : Status generalis & status lokalis ( inspeksi ,palpasi,perkusi,dan auskultasi ) : <br><?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?></div>

&emsp;<b>C.	PEMERIKSAAN PENUNJANG</b><br>
<div style="margin-left:40px">
		1.	Pemeriksaan penunjang sebelum rawat inap : 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Radiologi 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:80px");$i++;?>&emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lab 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:80px");$i++;?>&emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> USG 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:80px");$i++;?>&emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:80px");$i++;?> <br>
		2.	Pemeriksaan penunjang (Laboratorium, Radiologi  dll) <br><?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>
</div>

&emsp;<b>D.	DIAGNOSA KERJA : </b> 
<div style="margin-left:40px">
	<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>
</div>

&emsp;<b>E.	DIAGNOSA BANDING : </b> 
<div style="margin-left:40px">
	<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>
</div>

&emsp;<b>F. PENATALAKSANAAN / PERENCANAAN PELAYANAN :</b> (Terapi, tindakan, konsultasi, pemeriksaan penunjang lanjutan, edukasi, Perencanaan pulang dll)
<div style="margin-left:40px">
	<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?> <br>
	<b>Rencana Pulang <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:80px");$i++;?> </b> hari
</div>

<table width="100%" border="1px">
	<tr class="text-center">
		<th>Dokter Yang Melakukan Pengkajian Medis</th>
		<th>Verifikasi DPJP</th>
	</tr>
	<tr>
		<td>
			Tanggal	 : <?=input($arr_data[$i-1], "data_{$i}", "date", "", "");$i++;?>, 
			Pkl <?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?> <br>
			Selesai melakukan pengkajian
		</td>
		<td>
			Tanggal	 : <?=input($arr_data[$i-1], "data_{$i}", "date", "", "");$i++;?>, 
			Pkl <?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?> <br>
			Melakukan Verifikasi
		</td>
	</tr>
	<tr class="text-center">
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?></td>
	</tr>
	<tr>
		<td>Tanda Tangan dan Nama Jelas</td>
		<td>Tanda Tangan dan Nama Jelas</td>
	</tr>
</table><br>

<b>II.	ASSESMEN  KEPERAWATAN  ( Diisi oleh perawat ruangan )</b><br>
&emsp;<b>A.	Asesmen</b>
<div style="margin-left:40px">
	Tiba diruangan : tanggal <?=input($arr_data[$i-1], "data_{$i}", "date", "", "");$i++;?>, 
	Pukul <?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?>, 
	Asesmen dimulai tanggal: <?=input($arr_data[$i-1], "data_{$i}", "date", "", "");$i++;?>, 
	pukul <?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?> <br>

	Diperolah dari <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>, 
	Hubungan dengan pasien <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> <br>
	Cara masuk	  : 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Menggunakan inkubator&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Couve&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Infant Warmer&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Digendong&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Box bayi <br>
	Asal  pasien  : 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> IGD&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Poliklinik&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kamar bersalin&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Kamar operasi&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Rujukan <br>
	1. Diagnosis medis saat masuk : <?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?> <br>
	2. Keluhan utama  : <?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?> <br>
	3. Riwayat obstetrik : 
	G <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> &emsp;
	P <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> &emsp;
	A <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> &emsp;
	Usia  gestasi: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "");$i++;?> mg <br>
	4. Pernah dirawat : 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya / Tidak &emsp;  
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Indikasi rawat; 
	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:50%");$i++;?> <br>
	5. Status gizi ibu  : 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Baik&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Buruk&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain 
	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:50%");$i++;?>	<br>

	6. Obat- obatan yang dikonsumsi selama kehamilan : 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada, Jenis 
	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:50%");$i++;?>	<br>

	7. Kebiasaan ibu :
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Merokok&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Minum jamu&emsp; 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Minuman beralkohol&emsp; 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Dll&emsp; 
	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:50%");$i++;?>	<br>

	8. Riwayat persalinan :
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> SC&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Spontan Kepala / Bokong&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> VE&emsp; 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> FORCEP&emsp; <br>
	&emsp;Ketuban   : 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Jernih&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hijau encer/ kental&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Meconium&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Darah&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Putih keruh&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain- lain 
	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:20%");$i++;?> <br>
    &emsp;Volume    : 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Normal&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Oligohidramnion&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Polihidramnion,  APGAR SCORE : 
	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>

	9. Antropometri BBL :
	BB <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:10%");$i++;?> gram, &emsp;
	PB: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:10%");$i++;?> cm, &emsp;
	LK <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:10%");$i++;?> cm, &emsp;
	LD <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:10%");$i++;?> cm, &emsp;
	LP <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:10%");$i++;?> cm <br>

	10. Riwayat Penyakit ibu:
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Diabetes&emsp; 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kanker&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Asma&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hipertensi&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Jantung <br>
	&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain 
	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>

	11.	Riwayat alergi obat / makanan :
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada, sebutkan 
	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>

	12.	Riwayat Tranfusi darah :
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya, kapan ? 
	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?>, Timbul reaksi&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak / ya 
	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>

	13.	Riwayat imunisasi :
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya , sebutkan
	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>

</div><br>

&emsp;<b>B.	Status sosial , Ekonomi, Spiritual Suku/budaya, nilai kepercayaan</b><br>
<div style="margin-left:40px">
	1.	Pekerjaan penanggung jawab/ OT pasien : 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> PNS / TNI / POLRI&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Swasta&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pensiun&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain : 
	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>

	2.	Pendidikan suami / Penanggung jawab / OT :
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> SD&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> SMP&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> SLTA&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Akademi / PT&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pasca sarjana &emsp; <br>
	&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain : 
	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>

	3.	Cara pembayaran : 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pribadi&emsp; 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Perusahaan&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Asuransi&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain 
	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>

	4.	Tinggal bersama : 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Keluarga&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Orang tua&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Anak&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Panti asuhan <br>

	5.	Spiritual (Agama) : 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Islam&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Protestan&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Katholik&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hindu&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Budha&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Konghucu&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain –lain 
	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>

	6.	OT/ keluarga pasien mengungkapkan keprihatinan yang berhubungan dengan rawat inap : <br>
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

	7.	Suku/ budaya   : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
	<div class="row">
		<div class="">
	&emsp;8.	Nilai-nilai kepercayaan pasien / keluarga : 
		</div>&emsp;
		<div class="">
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada&emsp;      
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada  <br>		
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak mau dilakukan tranfusi<br> 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak mau pulang dihari tertentu <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak mau di imunisasi<br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain – lain 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
		</div>
	</div>
	
	<div class="row">
		<div class="col-3">
			9.	Kebutuhan privasi pasien :
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
            <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Transportasi <br>
            <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> lain – lain 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
		</div>
		</div> 
	</div>

	&emsp;<b>C.	Pemeriksaan Fisik</b><br>
	<div style="margin-left:40px">
			1.	Keadaan umum : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tampak tidak sakit &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sakit ringan &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> sakit sedang &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> sakit berat <br>

			2.	Kesadaran : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  compos mentis &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  apatis &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> somnolen &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> sopor &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  soporo coma &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  coma <br>

			3.	GCS : 
			E <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> &emsp;
			M <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> &emsp;
			V <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>

			4.	Tanda Vital : 
			S <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:10%;height:20px;");$i++;?> &emsp;
			N <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:10%;height:20px;");$i++;?> &emsp;
			RR <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:10%;height:20px;");$i++;?> &emsp;
			SpO2 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:10%;height:20px;");$i++;?>&emsp;
			TD <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:10%;height:20px;");$i++;?> &emsp;
			Down Score <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:10%;height:20px;");$i++;?><br>

			5.	Berat Badan       : 
			<?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:10%;");$i++;?> gr , &emsp;
			TB: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:10%;");$i++;?> cm, &emsp;
			LK: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:10%;");$i++;?> cm, &emsp;
			LD: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:10%;");$i++;?> cm , &emsp;
			LP :  <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:10%;");$i++;?> Cm  <br>
			
			6.	Gol Darah / Rh  ( Bayi  )  : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> A  
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> B 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> O  
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> AB 
			Rh : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Positif     
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Negatif <br>
            &emsp;Gol Darah / Rh (  ibu )     : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> A  
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> B 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> O  
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> AB 
			Rh : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Positif     
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Negatif <br>

            &emsp;Gol Darah / Rh (  Ayah )  : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> A  
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> B 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> O  
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> AB 
			Rh : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Positif     
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Negatif <br>

			<b>7.	Pengkajian Persistem : </b><br>
			<table width="100%" border="1px">
				<tr>
					<th>
						Sistem Susunan Syaraf Pusat
					</th>
					<td>
						Gerak bayi     : 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Aktif&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak aktif <br>
						UUB                : 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Datar &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Cekung &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tegang   &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Menonjol &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain- lain <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?><br>
						Kejang : 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Ada: 
						<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
						Refleks : 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Moro&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Menelan &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Hisap  &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Babinski &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Rooting &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> lain-lain <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
						Tangis bayi     : 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Kuat &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Melengking           &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain  <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?>
					</td>
				</tr>
				<tr>
					<th>
						Sistem Penglihatan
					</th>
					<td>
						Posisi mata     : 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Simetris&emsp;  
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Asimetris <br>
						Besar pupil     : 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Isokor&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Anisokor <br>
						Kelopak mata : 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK&emsp;          
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Edema &emsp;  
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Cekung &emsp;         
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain – lain 
						<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
						Konjungtiva    : 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Anemis&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Konjungtivitis&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain – lain 
						<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?><br>
						Sklera              : 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ikterik&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Perdarahan&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain –lain 
						<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?>
					</td>
				</tr>
				<tr>
					<th>
						Sistem Pendengaran 
					</th>
					<td>
						
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Asimetris&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Serumen&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Keluar cairan&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada lubang telinga
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain –lain 
						<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?>
					</td>
				</tr>
				<tr>
					<th>Sistem Penciuman </th>
					<td>
						
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TAK 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Asimetris   
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pengeluaran cairan 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain –lain 
						<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?>
					</td>
				</tr>
				<tr>
					<th>Sistem Kardio vaskuler</th>
					<td>
						Warna kulit : 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kemerahan&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sianosis
						<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?>&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pucat&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain 
						<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?><br>
						Denyut nadi: 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Teratur&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak teratur&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Frekwensi : 
						<?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;");$i++;?> X/mnt <br>
						Sirkulasi:        
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Akral hangat&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Akral dingin&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> CRT : 
						<?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;");$i++;?> detik  
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Palpitasi <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Edema, 
						lokasi <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
						Pulsasi : 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kuat&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lemah&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Mur- mur&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Lain-lain : 
						<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?>
					</td>
				</tr>
				<tr>
					<th>Sistem</th>
					<td>
						Pola napas   : 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Normal: 
						<?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:14%");$i++;?> X/mnt&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bradipneu: 
						<?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:14%");$i++;?> X/mnt &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tachipneu : 
						<?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:14%");$i++;?> X/mnt&emsp;
					</td>
				</tr>
				<tr>
					<th>Pernafasan</th>
					<td>
						<div class="row">
							<div class="col-2">Jenis pernafasan :&emsp;</div>
							<div>
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pernapasan dada 
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pernapasan perut <br>
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Alat bantu napas, sebutkan 
								<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?>
							</div>
						</div>
						Irama napas : 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Teratur&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak teratur<br>
						Retraksi : 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ringan&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sedang&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Berat <br>
						Air Entry        : 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Udara masuk&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Penurunan udara masuk&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada udara masuk <br>
						<div class="row">
							<div class="col-2">Merintih : </div>
							<div>
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada&emsp;
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Terdengar dengan stetoskop <br>
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Terdengar tanpa stetoskop
							</div>
						</div><br>
						Suara napas  : 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Vesikuler&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Wheezing&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ronchi&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Stridor
					</td>
				</tr>
				<tr>
					<th>Sistem Pencernaan </th>
					<td>
						<div class="row">
							<div class="col-1">Mulut : </div>
							<div>
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada kelainan&emsp;
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Simetris&emsp;
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Asimetris&emsp;
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Mucosa mulut kering  <br>
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bibir pucat&emsp;
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain 
								<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
							</div>
						</div>
						Lidah             :  
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada kelainan&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kotor&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Gerakan asimetris&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />Lain-lain 
						<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
						Oesofagus    :  
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada kelainan&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Lain- lain : 
						<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
						Abdomen     :  
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Supel&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Asites&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tegang&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Bising usus :  
						<?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;");$i++;?> X/mnt 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain2 
						<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
						Anus	        : 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Normal&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak normal <br>
						<div class="row">
							<div class="col-1">BAB : </div>
							<div>
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Normal&emsp;
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Konstipasi&emsp;
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Melena&emsp;
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Colostomy&emsp;
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Diare,Frek : 
								<?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;");$i++;?> / hari  <br>
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Meco pertama, tgl/ pkl 
								<?=input($arr_data[$i-1], "data_{$i}", "date", "", "");$i++;?> / 
								<?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?> <br>
							</div>
						</div>
						Warna          : 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kuning&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Dempul&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Coklat&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hijau&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain – Lain: 
						<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?>
					</td>
				</tr>
				<tr>
					<th>Sistem Genitourinaria</th>
					<td>
						BAK               : 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Normal&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hematuri&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Urin menetes&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sakit&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> oliguri <br>
						BAK pertama: tgl/pkl <?=input($arr_data[$i-1], "data_{$i}", "date", "", "");$i++;?> / 
						<?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?>&emsp;
						Warna : 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Jernih  &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kuning  &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kuning pekat &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
						<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?>
					</td>
				</tr>
				<tr>
					<th>Sistem Reproduksi </th>
					<td>
						Laki- laki : 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Normal &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hipospadia &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Epispadia  &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Fimosis &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hidrokel &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain2 
						<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
						Perempuan: 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Normal &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Keputihan &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Vagina skintag&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain2 
						<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?>
					</td>
				</tr>
				<tr>
					<th>Sistem Integument</th>
					<td>
						Vernic kaseosa : 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> lain- lain: 
						<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
						<div class="row">
							<div class="col-2">Lanugo : </div>
							<div>
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada &emsp;
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Banyak &emsp;
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />Tipis &emsp;
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bercak-bercak tanpa lanugo <br>
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Sebagian besar tanpa lanugo <br>
							</div>
						</div>
						Warna : 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pucat  &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ikterik &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sianosis  &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Normal   &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain 
						<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?><br>
						Turgor                : 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Baik    &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sedang  &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Buruk <br>
						Kulit  : 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Normal &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Rash/kemerahan &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lesi &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Luka &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Memar &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ptechie    &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bula<br>
						<div class="row">
							<div class="col-3">Kriteria resiko dekubitus : </div>
							<div>
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Jaringan / elastisitas kulit kurang
								&emsp;
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  immobilisasi <br> 
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Perawatan NICU  <br>
							</div>
						</div>
						<b>(Bila terdapat satu atau lebih kriteria di atas, lakukan pengkajian dengan menggunakan formulir pengkajian resiko dekubitus)</b>
					</td>
				</tr>
				<tr>
					<th>Sistem Muskulo-skeletal</th>
					<td>
						<div class="row">
							<div class="col-2">Lengan  : </div>
							<div>
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Fleksi  
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ekstensi  
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pergerakan aktif  
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Pergerakan tidak aktif <br>
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain2: 
								<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
							</div>
						</div>
						<div class="row">
							<div class="col-2">Tungkai : </div>
							<div>
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Fleksi   
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ekstensi  
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pergerakan aktif 
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pergerakan tidak aktif <br>
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain2: 
								<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?>
							</div>
						</div>
						Rekoil telinga      :  
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Rekoil lambat 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Rekoil cepat  
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Rekoil segera 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain2: _________ <br>
						<div class="row">
							<div class="col-2">Garis telapak kaki : </div>
							<div>
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tipis    
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Garis transversal anterior 
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Garis 2/3 anterior  <br>
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Seluruh telapak kaki
							</div>
						</div>
					</td>
				</tr>
			</table>
	</div>

</div>

&emsp;<b>D.	Status psikologis ( orang tua ) </b><br>
	<div style="margin-left:40px">
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tenang &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Cemas &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sedih &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Depresi &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Marah &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hiperaktif &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Mengganggu sekitar &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain- lain: 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> 
	</div>

	&emsp;<b>E.	Kenyamanan / pengkajian nyeri ( asesmen nyeri ) pada usia 0-1 bulan ( NIPS )</b><br>
	<div style="margin-left:40px">
		Nyeri          :  
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada&emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada < skala nyeri 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
        Frekwensi :  
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Jarang&emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hilang timbul&emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Terus menerus&emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lama nyeri 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br><br>
		<b>Penilaian skala nyeri NIPS ( Neonatus Infant Pain Scale ) ( 0-1 bulan )</b><br>
		<table border="1px" width="100%">
			<tr class="text-center">
				<th>Indikator</th>
				<th>Kategori</th>
				<th>Skor</th>
				<th>Hasil Skor</th>
			</tr>
			<tr>
				<td rowspan="2">Ekspresi wajah</td>
				<td>Santai </td>
				<th class="text-center">0</th>
				<td class="text-center"><input class="inputC" onchange="changed()" type="checkbox" value="0" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
			</tr>
			<tr>
				<td>Meringis</td>
				<th class="text-center">1</th>
				<td class="text-center"><input class="inputC" onchange="changed()" type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
			</tr>
			<tr>
				<td rowspan="3">Menangis</td>
				<td>Tidak menangis </td>
				<th class="text-center">0</th>
				<td class="text-center"><input class="inputC" onchange="changed()" type="checkbox" value="0" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
			</tr>
			<tr>
				<td>Merengek </td>
				<th class="text-center">1</th>
				<td class="text-center"><input class="inputC" onchange="changed()" type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
			</tr>
			<tr>
				<td>Menangis keras</td>
				<th class="text-center">2</th>
				<td class="text-center"><input class="inputC" onchange="changed()" type="checkbox" value="2" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
			</tr>
			<tr>
				<td rowspan="2">Pola nafas</td>
				<td>Rileks</td>
				<th class="text-center">0</th>
				<td class="text-center"><input class="inputC" onchange="changed()" type="checkbox" value="0" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
			</tr>
			<tr>
				<td>Perubahan pola nafas</td>
				<th class="text-center">1</th>
				<td class="text-center"><input class="inputC" onchange="changed()" type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
			</tr>
			<tr>
				<td rowspan="2">Lengan</td>
				<td>Tertahan / rileks</td>
				<th class="text-center">0</th>
				<td class="text-center"><input class="inputC" onchange="changed()" type="checkbox" value="0" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
			</tr>
			<tr>
				<td>Fleksi / ektensi</td>
				<th class="text-center">1</th>
				<td class="text-center"><input class="inputC" onchange="changed()" type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
			</tr>
			<tr>
				<td rowspan="2">Tungkai</td>
				<td>Tertahan / rileks</td>
				<th class="text-center">0</th>
				<td class="text-center"><input class="inputC" onchange="changed()" type="checkbox" value="0" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
			</tr>
			<tr>
				<td>Fleksi / ektensi</td>
				<th class="text-center">1</th>
				<td class="text-center"><input class="inputC" onchange="changed()" type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
			</tr>
			<tr>
				<td rowspan="2">Keadaan terangsang</td>
				<td>Tidur / bangun</td>
				<th class="text-center">0</th>
				<td class="text-center"><input class="inputC" onchange="changed()" type="checkbox" value="0" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
			</tr>
			<tr>
				<td>Rewel</td>
				<th class="text-center">1</th>
				<td class="text-center"><input class="inputC" onchange="changed()" type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
			</tr>
			<tr>
				<td></td>
				<td>Total skor</td>
				<td></td>
				<th class="text-center" id="total"></th>
			</tr>
		</table><br>
		<b>* keterangan skor:  0 bebas nyeri , 1-2 nyeri ringan s/d sedang  , 3-4 Nyeri sedang , > 4 Nyeri berat 
		Jika terdapat nyeri , lakukan observasi lanjutan dengan menggunakan formulir observasi pasien nyeri
		</b>
	</div><br>

	&emsp;<b>F.	Kebutuhan komunikasi / pendidikan dan pengajaran orang tua</b><br>
	<div style="margin-left:40px">
		1.	Bicara : 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Normal&emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Tidak gangguan  
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
		2.	Bahasa sehari-hari	   : 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
		3.	Penterjemah               : 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak&emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya, Bahasa : 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?>
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bahasa isyarat&emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya&emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak <br>
		4.	Masalah penglihatan : 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak&emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya , Sebutkan 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
		5.	Pendidikan Penanggung jawab : 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> SD &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> SMP  &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> SLTA &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Akademi/PT  &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pasca sarjana  &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?> <br>
		<div class="row">
			<div class="">&emsp;6. Pasien atau keluarga menginginkan informasi tentang : </div>&emsp;
			<div>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Proses penyakit &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Gizi / nutrisi <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Terapi atau obat &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Peralatan medis &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tindakan / pemeriksaan &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain –lain 
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?>
			</div>
		</div>
	</div><br><br>

	<div class="text-center"><h4><u>ASESMEN GIZI / SKRINING GIZI OLEH PERAWAT</u></h4></div>
	<div style="margin-left:40px">
				<div class="row">
					<div class="col-1">1. Minum:</div>
					<div>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> ASI&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> PASI&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Frekwensi 
						<?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;");$i++;?> X / 24 Jam &emsp;
						<?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;");$i++;?> cc/kali <br>
						Masalah           : 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada (skor 1)&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada (skor 0) <br>
					</div>
				</div>
				2.	Penurunan BB : 
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  ≤ 10 % dari BBL ( 0 )&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  ≥ 10 % Dari BBL ( 1 ) <br>
				3. Penyakit yang menyertai jika ada skornya 2 <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sepsis&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Jantung&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> BBLR&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hipoglikemi&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Diare&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain – lain 
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?><br>
				<b>Total skor</b> <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:5%");$i++;?> <br>
				<b>Jika skor < 2 :</b> Diet yang diberikan   
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> ASI&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> PASI&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Per Oral / NGT <br>
				<b>Jika skor ≥ 2 :</b> Asesmen lanjut oleh ahli gizi 
	</div><br>

<div class="text-center"><h4><u>DAFTAR MASALAH KEPERAWATAN</u></h4></div>
	<center>
	<table>
		<tr>
			<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Nyeri</td>
			<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Perfusi jaringan</td>
			<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pola</td>
		</tr>
		<tr>
			<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Nutrisi</td>
			<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Suhu Tubuh</td>
			<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Peningkatan billirubin</td>
		</tr>
		<tr>
			<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Mobilitas/aktifitas</td>
			<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Eliminasi</td>
			<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Integritas kulit</td>
		</tr>
		<tr>
			<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pengetahuan/komunikasi</td>
			<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Keseimbangan cairan & elektrolit</td>
			<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Jalan nafas/pertukaran gas</td>
		</tr>
		<tr>
			<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Infeksi</td>
			<td colspan="2">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain – lain 
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;");$i++;?>
			</td>
		</tr>
	</table>	
	</center>
	<br><br>
	<div class="text-center"><h4><u>RENCANA KEPERAWATAN</u></h4></div>
	<div style="margin-left:40px">
		1.	<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?> <br>
		2.	<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?> <br>
		3.	<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?> <br>
		4.	<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?> <br>
		5.	<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?> <br>
		6.	<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?> <br>
	</div>
	<br><br>

	<div class="text-center"><h4><u>PERENCANAAN PERAWATAN INTERDISIPLIN/REFERAL</u></h4></div>
	<div style="margin-left:40px">

		<table width="100%">
			<tr>
				<td>1.	Diet dan nutrisi</td>
				<td>: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak</td>
				<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya : </td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
			</tr>
			<tr>
				<td>1.	Diet dan nutrisi</td>
				<td>: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak</td>
				<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya : </td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
			</tr>
			<tr>
				<td>2.	Rehabilitasi medik</td>
				<td>: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak</td>
				<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya : </td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
			</tr>
			<tr>
				<td>3.	Farmasi	</td>
				<td>: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak	</td>
				<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya : </td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
			</tr>
			<tr>
				<td>4.	Perawatan luka	</td>
				<td>: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak	</td>
				<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya : </td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
			</tr>
			<tr>
				<td>5.	Manajemen nyeri</td>
				<td>: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak	</td>
				<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya : </td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
			</tr>
			<tr>
				<td>6.	Lain-lain</td>
				<td>: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak	</td>
				<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya : </td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
			</tr>
		</table>

	</div>
		<br><br>
	<div class="text-center"><h4><u>PERENCANAAN PULANG ( DISCHARGE PLANNING )</u></h4></div>
	<div style="margin-left:40px">
		Pasien dan keluarga diberikan informasi tentang perencanaan pulang ? 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak &emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya <br>
		Lama perawatan rata-rata		         : 
		<?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:90px;height:20px");$i++;?> hari <br>
		2.	 Tanggal perencanaan pulang	                       : 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?> <br>

		3.	 Perawatan lanjutan yang diberikan dirumah : <br>
		<div class="row">
			<div class="col-6">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Higiene  ( mandi , BAB/BAK ) <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Perawatan luka  <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Perawatan bayi <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pemberian obat <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain – lain  <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?> 	<br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?>  <br>
			</div>

			<div class="col-6">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pemberian minum NGT / Sendok / dot bayi  <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Nutrisi <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Latihan gerak / Exercise <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pemeriksaan laboratorium  lanjutan <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Penyakit  / diagnosa <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?> <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?>
			</div>
		</div>
		           
4.	Bayi tinggal bersama : 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> OT Kandung 	 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Keluarga, 
<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?> <br>
 
<div class="row">
	<div class="col-3">5.	Transportasi yang digunakan :</div>
	<div>
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kendaraan pribadi ( mobil , beroda dua dll) 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> kendaraan umum <br>
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Mobil ambulance  
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?> 
	</div>
</div>

6.	Jika ada kriteria masuk dalam pemulangan kondisi khusus dilanjutkan asesmen pemulangan kondisi khusus <br>
<table width="100%" border="1px">
	<tr class="text-center">
		<th>Perawat / Bidan Yang Melakukan Pengkajian</th>
		<th>Verifikasi DPJP</th>
	</tr>
	<tr>
		<td>
			Tanggal	 : <?=input($arr_data[$i-1], "data_{$i}", "date", "", "");$i++;?>, &emsp;
			Pkl <?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?>
			Selesai
		</td>
		<td>
			Tanggal	 : <?=input($arr_data[$i-1], "data_{$i}", "date", "", "");$i++;?>, &emsp;
			Pkl <?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?>
			Verifikasi
		</td>
	</tr>
	<tr class="text-center">
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?></td>
	</tr>
	<tr>
		<td>Tanda Tangan dan Nama Jelas</td>
		<td>Tanda Tangan dan Nama Jelas</td>
	</tr>
</table>
Januari, 2017
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
		printPDF('RM 5.2 '+identifier);
	<?php endif; ?>

	</script>
</body>

</html>