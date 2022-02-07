<?php
	use yii\helpers\Html;
	include '../function/form.php';
	include '../../koneksi/konek.php';
	include 'funct.php';
	$dataPasien = getIndetitasPasien($_REQUEST['idKunj']);
	$i = 1;

	if (isset($_REQUEST['id'])) {
		$data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_triase_pasien_gd WHERE id = '{$_REQUEST['id']}'"));
		$all = $data['data']; $str = ""; $arr_data = [];

		for ($r=0; $r < strlen($all); $r++) { 
			if ($all[$r] != "|") {
				$str .= $all[$r];
			} else {
				array_push($arr_data, $str);
				$str = "";
			}
		}

	}

	if (isset($_REQUEST['cetak'])) {
		$print_mode = true;
		echo "<script>window.print();</script>";
		$data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_triase_pasien_gd WHERE id = '{$_REQUEST['cetak']}'"));
		$all = $data['data']; $str = ""; $arr_data = [];
		for ($r=0; $r < strlen($all); $r++) { 
			if ($all[$r] != "|") {
				$str .= $all[$r];
			} else {
				array_push($arr_data, $str);
				$str = "";
			}
		}
	}

  if (isset($_REQUEST['idx'])) {
	date_default_timezone_set("Asia/Jakarta");
	$tgl_act = date('Y-m-d H:i:s');
	$str = ""; 
    $q = mysql_real_escape_string($_REQUEST['i']);

    for ($e=1; $e < $q; $e++) {
        $data = mysql_real_escape_string($_REQUEST["data_{$e}"]);
        if ($data != "") {
            $str .= $data;
            $str .= "|";
        } else {
            $str .= "#";
            $str .= "|";
		}
	}

      $data = [
          'id_kunjungan' => mysql_real_escape_string($_REQUEST['id_kunjungan']),
          'id_pelayanan' => mysql_real_escape_string($_REQUEST['id_pelayanan']),
          'tgl_act' => date('Y-m-d H:i:s'),
          'id_user' => mysql_real_escape_string($_REQUEST["id_user"]),
          'data' => $str
	  ];

      $hasil = mysql_query("UPDATE rm_triase_pasien_gd 
            SET
            id_kunjungan = '{$data['id_kunjungan']}',
            id_pelayanan = '{$data['id_pelayanan']}',
            tgl_act = '{$data['tgl_act']}',
            id_user = '{$data['id_user']}',
			data = '{$data['data']}'
            WHERE 
            id = {$_REQUEST['idx']}");
      
      echo "<script>window.location.href='index.php?idKunj=".$_REQUEST['idKunj']."&idPel=".$_REQUEST['idPel']."&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['idUser']."&tmpLay=".$_REQUEST['tmpLay']."'</script>";
  }

  if (isset($_REQUEST['pdf'])) {
    echo '';
    $print_mode = true;
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_triase_pasien_gd WHERE id = '{$_REQUEST['pdf']}'"));
	
    $all = $data['data']; $str = ""; $arr_data = [];
        for ($r=0; $r < strlen($all); $r++) {
            if ($all[$r] != "|") {
                $str .= $all[$r];
            } else {
                array_push($arr_data, $str);
                $str = "";
            }
        }

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
		.bordered{
			border: 1px solid black;
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
					
				<div style="float: right">RM 4 / rev01 / PHCM</div>
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
		<center><h2>TRIASE PASIEN GAWAT DARURAT</h4></center>

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

<div style="border:2px solid black"></div>
<table width="100%" border="1px">
	<tr>
		<td width="30%">
			Cara Datang: <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	Sendiri <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	Klinik <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	Puskesmas <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	Rumah Sakit <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	Lainnya 
		</td>
		<td width="30%">
			Macam Kasus : <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	Trauma <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	Kebidanan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	Non Trauma <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	D O A <br><br>
		</td>
		<td>
			Jam Datang : <?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?> <br>
			Jam Registrasi : <?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?> <br><br><br><br>
		</td>
	</tr>
	<tr>
		<td colspan="3">
			Keluhan Utama : <br>
			<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?> <br><br>

			Keluhan Tambahan : <br>
			<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?> <br><br>

			<div class="row">
				<div class="col-9">
					KEPALA DAN LEHER: <br>
					<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>
				</div>
				<div class="col-3">
					<img src="../../images/leher.png" width="100%">
				</div>
			</div><br>

			<div class="row">
				<div class="col-9">
					THORAKS       : <br>
					<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>
				</div>
				<div class="col-3">
					<img src="../../images/dada.png" width="100%">
				</div>
			</div><br>

			<div class="row">
				<div class="col-9">
					ABDOMEN       : <br>
					<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>
				</div>
				<div class="col-3">
					<img src="../../images/perut.png" width="100%">
				</div>
			</div><br>
			EKSTREMITAS       : <br>
			<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>
		</td>
	</tr>
	<tr>
		<td style="padding: 20px" colspan="3">
			<div class="row">
				<div class="col-6">
					<b>PENILAIAN NYERI (VAS)</b><br>
					<img src="../../images/numericScale2.png" width="100%">
				</div>
				<div class="col-6">
					<div style="border: 1px solid black;padding: 20px"><br>
						<div class="row">
							<div class="col-4">
								Nyeri <br><br> Skala nyeri <br><br> Karakteristik <br><br> Lokasi <br><br> Durasi <br><br> Frekuensi
							</div>
							<div class="col-8">
								: 
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak&emsp;
								<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> ya <br><br>
								: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?> <br><br>
								: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?> <br><br>
								: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?> <br><br>
								: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?> <br><br>
								: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?>
							</div>
						</div>

					</div>
				</div>
			</div>
		</td>
	</tr>
	
</table>
<table width="100%" border="1px">
	<tr>
		<th class="text-center">PEMERIKSAAN</th>
		<th class="bg-danger text-center">URGENT</th>
		<th class="bg-warning text-center">SEMI URGENT</th>
		<th class="bg-success text-center">NON URGENT</th>
	</tr>
	<tr>
		<th class="text-center">JALAN NAFAS</th>
		<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	Sumbatan Total</td>
		<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	Bebas</td>
		<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	Bebas</td>
	</tr>
	<tr>
		<th class="text-center">PERNAFASAN DEWASA</th>
		<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 	Henti Nafas <br>
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Frekuensi Nafas< 10x/menit
</td>
		<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />		Frekuensi nafas 24-40x/menit</td>
		<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />		Frekuensi nafas 21-23x/menit</td>
	</tr>
	<tr>
		<th rowspan="2" class="text-center">PERNAFASAN ANAK</th>
		<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />		Henti Nafas</td>
		<td rowspan="2"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	Retraksi Ringan</td>
		<td rowspan="2"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	Tidak ada retraksi</td>
	</tr>
	<tr>
		<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	Retraksi berat, Sianosis</td>
	</tr>
	<tr>
		<th rowspan="2" class="text-center">SIRKULASI DEWASA</th>
		<td rowspan="2"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />		Nadi Karotis Tidak Teraba</td>
		<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	Nadi 121 –150x/menit <br>
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	Sistolik 160-200 mmHg <br>
( <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> )
</td>
		<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	Nadi 81 –120x/menit <br>
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	Sistolik 120-159 mmHg <br>
( <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> )
</td>
	</tr>
	<tr>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> AkralHangat
		</td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> AkralHangat
		</td>
	</tr>
	<tr>
		<th class="text-center" rowspan="4">SIRKULASI ANAK</th>
		<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Nadi Karotis Tidak Teraba</td>
		<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 	Nadi perifer teraba</td>
		<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 	Nadi perifer teraba</td>
	</tr>
	<tr>
		<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pucat</td>
		<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 	Pucat</td>
		<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 	Merah muda</td>
	</tr>
	<tr>
		<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Akral dingin</td>
		<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 	Hangat</td>
		<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 	Hangat</td>
	</tr>
	<tr>
		<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 	CRT > 4 detik</td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<th class="text-center">MENTAL STATUS</th>
		<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	Tidak respon (GCS < 8)</td>
		<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	Respon terhadap verbal (GCS 13 – 14)</td>
		<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	Sadar penuh (GCS 15)</td>
	</tr>
	<tr>
		<th class="text-center">SKOR NYERI</th>
		<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />		Nyeri jantung VAS 10</td>
		<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />		o	Nyeri jantung VAS 1-6 <br>
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	Nyeri Selain Jantung VAS 7 - 10
</td>
<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	Nyeri Selain Jantung VAS 1-6</td>
	</tr>
	<tr>
		<th class="text-center">ASSESMENT TRIASE</th>
		<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	Immediate / Segera</td>
		<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 	Urgent / Mendesak</td>
		<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 	Semi Urgent / Kurang Mendesak</td>
	</tr>
	<tr>
		<th class="text-center" rowspan="2">PLAN</th>
		<td class="text-center bg-danger">ZONA MERAH</td>
		<td rowspan="2" class="text-center bg-warning"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 		ZONA KUNING</td>
		<td rowspan="2" class="text-center bg-success"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 		ZONA HIJAU</td>
	</tr>
	<tr>
		<td class="bg-danger"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	Ruang Resusitasi</td>
	</tr>
</table>
<table width="100%" border="1px">
	<tr>
		<td width="50%">
			<b>STATUS PSIKOLOGI</b><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	Marah <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	Takut <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	Cemas <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	Depresi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	Kecenderungan bunuh diri <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	Gelisah <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	Lain-lain <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	Tidak ada masalah <br><br>
			<b>PEMERIKSAAN <br>
			1. LABORATORIUM :</b>		<br>	
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	Darah Lengkap <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	KGD <br><br>
			<b>2. EKG :</b><br>
			<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?><br>
			<i>(Beri tanda pemeriksaan yang sudah dilakukan)</i><br><br>
			<b>DIAGNOSA  :</b><br>
			<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?><br><br>
			<b>DIAGNOSA BANDING </b> <br>
			<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?><br><br>
			<b>Tim Resusitasi : </b> <br>
			<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>
			
		</td>
		<td width="50%">
			<b>Risiko Jatuh</b>  <br>
Cara Berjalan Pasien (salah satu atau lebih)<br><br>
1. Tidak seimbang / sempoyongan/limbung <br>
2. Jalan dengan menggunakan alat bantu (kruk, tripot, kursi roda,   
    orang lain : <br>
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	Ya <br>
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	Tidak       <br>
<br><br><br><br><br><br><br><br><br><br><br>
<b>
	RENCANA TINDAK LANJUT : <br><br>
&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	PULANG BEROBAT JALAN <br><br>
&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	RUJUK <br><br>
&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	PULANG ATAS PERMINTAAN SENDIRI :  <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>
&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	MENINGGAL <br><br>
&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	DISERAHKAN KE DOKTER JAGA  :  <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?><br><br>
&emsp;TGL    :   <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>                 <br><br>
&emsp;Jam     :   <?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?>            WIB <br><br><br><br><br>

</b>

		</td>
	</tr>
</table>
<div style="border:2px solid black"></div>
<table width="100%" border="1px">
	<tr>
		<th>SERAH TERIMA TIM JAGA</th>
		<td></td>
	</tr>
	<tr>
		<th>
			Nama dan T Tangan Dokter Triase : <br>
			<br><br><br><br><br><br>
		</th>
		<th>
			Nama dan T Tangan Dokter Jaga : <br>
			<br><br><br><br><br><br>
		</th>
	</tr>
	<tr>
		<th>
			Nama Perawat Triase : <br>
			<br><br><br><br><br><br>
		</th>
		<th>
			Nama Perawat jaga :  <br>
			<br><br><br><br><br><br>
		</th>
	</tr>
	<tr>
		<th colspan="2">
			Pemberian edukasi kepada pasien/keluaga oleh petugas tentang  : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?><br><br>
			<div class="row">
				<div class="col-4"><center>
					Petugas Yang Memberikan Informasi 
					<br><br><br><br><br><br> ( <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> )</center>
					
				</div>
				<div class="col-4"></div>
				<div class="col-4"><center>
					Yang Menerima Edukasi Pasien/Keluarga
					<br><br><br><br><br><br> ( <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> )</center>
				</div>
			</div>
		</th>
	</tr>
</table>
<div style="width: 100%"><img style="float: right;transform: scale(0.5);margin-right: -200px" src="../../images/alamat.jpg"></div> 
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

	<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery-1.9.1.js"></script>
	<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery.form.js"></script>
    <script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>
    <script type="text/javascript" src="../../theme/js/ajax.js"></script>
	<script src="../../theme/bs/bootstrap.min.js"></script>
	<script>
		<?php if (isset($_REQUEST["pdf"])): ?>
			let identifier = '<?=$dataPasien["nama"]?>';
			printPDF('RM 4 '+identifier);
		<?php endif; ?>
	</script>
</body>

</html>