<?php
	use yii\helpers\Html;
	include '../function/form.php';
	include '../../koneksi/konek.php';
	include 'funct.php';
	$dataPasien = getIndetitasPasien($_REQUEST['idKunj']);
	$i = 1;
	


  if (isset($_REQUEST['id'])) {
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_asuhan_rak WHERE id = '{$_REQUEST['id']}'"));
    $arr_data = explode("|", $data['data']);
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

      $hasil = mysql_query("UPDATE rm_asuhan_rak 
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
	<script src="../html2pdf/ppdf.js"></script>
	<?php 
if (isset($_REQUEST['cetak'])) {
    $print_mode = true;
    echo "<script>window.print();</script>";
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_asuhan_rak WHERE id = '{$_REQUEST['cetak']}'"));

	$arr_data = explode("|", $data['data']);

  }

  if (isset($_REQUEST['pdf'])) {
    $print_mode = true;
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_asuhan_rak WHERE id = '{$_REQUEST['pdf']}'"));

	$arr_data = explode("|", $data['data']);

  }
	 ?>
</head>

<body id="pdf-area">
	<div class="bg-white" style="padding:25px">
		<div class="row">
			<div class="col-6 text-center"><br><br>
				<img src="../logors1.png">
			</div>
			<div class="col-6" style="padding:15px">
					
				<div style="float: right">RM 22 / PHCM</div>
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
		<center><h2>RENCANA ASUHAN KEPERAWATAN / NURSING CARE PLAN</h2></center>
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

<table class="align-text-top" width="100%" border="1" style="font-size:11px">
	<tr>
		<th class="text-center">TGL</th>
		<th class="text-center">NO</th>
		<th class="text-center">DIAGNOSA KEPERAWATAN</th>
		<th class="text-center">TUJUAN</th>
		<th class="text-center">RENCANA TINDAKAN KEPERAWATAN</th>
		<th class="text-center">TGL/JAM TERATASI</th>
		<th class="text-center">PARAF</th>
	</tr>
	<tr>
		<td valign="top"><?=input($arr_data[$i-1], "data_{$i}", "date", "form-control", "", "");$i++;?></td>
		<td valign="top"><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "", "");$i++;?></td>
		<td valign="top">
			Gangguan perfusi jaringan serebral berhubungan dengan: <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Gangguan aliran darah; Oklusi, Perdarahan, Vasospasme serebral, Edema serebral <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Proses peradangan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Peningkatan TIK <br><br>
			<b> Data Subjektif :<br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>
			<b>Data Objektif :</b>  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Kesadaran 
			 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 GCS 
			 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Vital Sign : 
			TD <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> mmHg, 
			&emsp;RR <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> x/mm, 
    		&emsp;HR <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> x/mm, 
    		&emsp;S <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> &deg;C <br>
    		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
    		 Penurunan fungsi sensorik  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Penurunan fungsi motorik <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Penurunan fungsi memori <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Kerusakan pada nervus cranial <?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "", "");$i++;?> <br>
			 <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			   Nyeri kepala <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Mual, muntah <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Kejang <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Pupil <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Pola nafas <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Refleks patologis <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Pandangan kabur <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  CT Scan <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>
		</td>
		<td valign="top">
			Perfusi jaringan serebral adequat setelah dilakukan tindakan keperawatan selama 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<b>Kriteria hasil : </b> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Pasien dapat mempertahankan tingkat kesadaran, fungsi kognitif, sensorik dan motorik, orientasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Tanda-tanda vital stabil, peningkatan TIK tidak ada <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Tidak terjadi deficit neurologis
		</td>
		<td valign="top">
			<b>Mandiri<br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Kaji dan monitor status neurologis <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Kaji tingkat kesadaran /GCS <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Kaji pupil; ukuran, respon terhadap cahaya, gerakan        mata <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Kaji reflek kornea dan reflek gag <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  evaluasi keadaan motorik dan sensorik pasien <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Monitor tanda-tanda vital secara kontinu <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Hitung irama denyut nadi, auskultasi adanya murmur <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Pertahankan pasien bed rest, berikan lingkungan tenang, batasi pengunjung, atur waktu istirahat dan aktifitas <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Pertahankan kepala TT 30 - 45º hindari fleksi leher <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Kurangi aktifitas yang dapat menimbulkan  peningkatan TIK dan minimalkan valsava maneuver <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Pertahankan kepatenan jalan nafas dan lakukan suction dengan benar <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Observasi adanya edema periorbita, ekomosis <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Pertahankan suhu tubuh dalam batas normal <br><br>
			  <b>Kolaborasi :<br></b> 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Berikan oksigen sesuai indikasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Berikan obat : <br>
			<div class="newline">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				 Antikoagulan <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				 Antihipertensi <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				 Antifibrolitik <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				 Antibiotik <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				 Steroid <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				 Diuretik osmotik <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				 Pelunak feses
			</div>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Periksa lab <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Test diagnostic  <br>
			<div class="newline">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				 CT Scan
			</div>
		</td>
		<td valign="top">
			<?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?> / 
			<?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?>
		</td>
		<td valign="top">
			<?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "", "");$i++;?>
		</td>
	</tr>
</table>
<br><br><br>

<table class="align-text-top" width="100%" border="1">
	<tr>
		<th class="text-center">TGL</th>
		<th class="text-center">NO</th>
		<th class="text-center">DIAGNOSA KEPERAWATAN</th>
		<th class="text-center">TUJUAN</th>
		<th class="text-center">RENCANA TINDAKAN KEPERAWATAN</th>
		<th class="text-center">TANGGAL TERATASI</th>
		<th class="text-center">PARAF</th>
	</tr>
	<tr>
		<td valign="top"><?=input($arr_data[$i-1], "data_{$i}", "date", "form-control", "", "");$i++;?></td>
		<td valign="top"><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "", "");$i++;?></td>
		<td valign="top">
			Gangguan mobilitas fisik b/d gangguan neuromuskuler : <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Kelemahan umum <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Defisit neurologis <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Parestesia <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Paralisis <br><br>
			<b> Data Subjektif :<br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Pasien mengatakan tidak bisa menggerakkan/lemah ekstremitas sebelah 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>
			 <b> Data objektif :<br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Pasien tidak mampu menggerakkan :
			<div class="newline">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				 Tangan kanan/kiri <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				 Kaki kanan/kanan
			</div>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Pasien tidak mampu memenuhi kebutuhan ADL <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Therapy bed rest <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Adanya paraplegi/paraparese <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Adanya hemiplegic/hemiparese <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Adanya tremor <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Pergerakan/ambulasi dibantu <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Tonus otot kurang <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Kekuatan otot <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Atropi/kontraktur <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 EMG <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>
		</td>
		<td valign="top">
			Mobilitas fisik adequat setelah perawatan selama  
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<b> Kriteria hasil :<br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Mempertahankan keutuhan tubuh secara optimal; 
			<div class="newline">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				 Tidak ada kontraktur <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				 Tidak ada atropi <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				 Tidak ada foot drop <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				 Kekuatan sendi maksimal
			</div>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Mempertahankan kekuatan /fungsi tubuh secara optimal <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Mendemonstrasikan tekhnik/prilaku melakukan aktifitas <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Mempertahankan integritas kulit <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Kebutuhan ADL terpenuhi

		</td>
		<td valign="top">
			<b> Mandiri<br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Kaji kemampuan mobilisasi/ motorik, Fungsional  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Monitor fungsi motorik dan sensorik setiap hari <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Ajarkan untuk alih posisi, bantu bila pasien tidak mampu <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Ajarkan pasien untuk melakukan ROM bantu bila pasien tidak mampu <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Monitor tanda-tanda tromboemboli dan konstipasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Lakukan tindakan untuk meluruskan postur tubuh, bila pasien ditempat tidur
			<div class="newline">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				 Gunakan papan kaki/food board <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				 Ubah posisi sendi bahu secara kontinu <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				 Sanggah tangan dan pergelangan pada posisi anatomi
			</div>
				
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Observasi daerah yang tertekan; 
			<div class="newline">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				  Warna kemerahan <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				  Edema, lecet
			</div>
				
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Lakukan masase pada daerah yang tertekan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Gunakan alpa bed (matras anti dekubitus) <br><br>

			<b>Kolaborasi <br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Lakukan fisiotherapy; berikan stimulasi elektrik

		</td>
		<td valign="top">
			<?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>
		</td>
		<td valign="top">
			<?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "", "");$i++;?>
		</td>
	</tr>
</table>
<br><br><br>

<table class="align-text-top" width="100%" border="1">
	<tr>
		<th class="text-center">TGL</th>
		<th class="text-center">NO</th>
		<th class="text-center">DIAGNOSA KEPERAWATAN</th>
		<th class="text-center">TUJUAN</th>
		<th class="text-center">RENCANA TINDAKAN KEPERAWATAN</th>
		<th class="text-center">TANGGAL TERATASI</th>
		<th class="text-center">PARAF</th>
	</tr>
	<tr>
		<td valign="top"><?=input($arr_data[$i-1], "data_{$i}", "date", "form-control", "", "");$i++;?></td>
		<td valign="top"><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "", "");$i++;?></td>
		<td valign="top">
			Gangguan komunikasi verbal/non verbal berhubungan dengan : <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Gangguan sirkulasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Gangguan neuromuskuler <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Kelemahan umum <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Kerusakan pada area wernick <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Kerusakan pada area broca <br><br>

			<b>Data Subjektif</b>  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>

			<b> Data Objektif :</b> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Pasien tidak mampu berkomunikasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Tanda-tanda frustasi krn tidak mampu berkomunikasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Disartria, aphasia <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Kelemahan otot wajah <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Kelemahan otot lidah <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 CT Scan 
			 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>
		</td>
		<td valign="top">
			Komunikasi verbal / non verbal efektif setelah dirawat selama 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>
			<b>Kriteria hasil :<br></b> 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Mampu menggunakan metode komunikasi yang efektif baik verbal maupun non verbal  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Terhindar dari tanda-tanda frustasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Mampu mengkomunikasikan kebtuhan dasa <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Mampu mengekspresikan diri dan memahami orang lain
		</td>
		<td valign="top">
			<b> Mandiri	<br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Kaji kemampuan komunikasi ; gangguan bahasa dan bicara <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Pertahankan kontak mata dengan pasien saat berkomunikasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Ciptakan lingkungan penerimaan dan privasi : <br>
			<div class="newline">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				 Jangan terburu-buru <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				 Bicara dengan perlahan dan intonasi normal <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				 Kurangi bising lingkungan <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				 Jangan paksa pasien untuk berkomunikasi <br>
			</div>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Gunakan kata-kata sederhana secara bertahap dan dengan bahasa tubuh <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Ajarkan tekhnik untuk memperbaiki bicara : <br>
			<div class="newline">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				 Instruksikan pasien untuk bicara lambat dan dalam kalimat pendek <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				 Pada awal pertanyaan gunakan pertanyaan dengan ajawaban ‘ya’ atau ‘tidak” <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				 Dorong pasien untuk berbagi perasaan dan keprihatinannya
			</div>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Berikan respon terhadap prilaku non verbal <br><br>
			<b>Kolaborasi</b><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Lakukan fisiotherapy; berikan therapy wicara
		</td>
		<td valign="top">
			<?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>
		</td>
		<td valign="top">
			<?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "", "");$i++;?>
		</td>
	</tr>
</table>

<br><br><br>

<table class="align-text-top" width="100%" border="1">
	<tr>
		<th class="text-center">TGL</th>
		<th class="text-center">NO</th>
		<th class="text-center">DIAGNOSA KEPERAWATAN</th>
		<th class="text-center">TUJUAN</th>
		<th class="text-center">RENCANA TINDAKAN KEPERAWATAN</th>
		<th class="text-center">TANGGAL TERATASI</th>
		<th class="text-center">PARAF</th>
	</tr>
	<tr>
		<td valign="top"><?=input($arr_data[$i-1], "data_{$i}", "date", "form-control", "", "");$i++;?></td>
		<td valign="top"><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "", "");$i++;?></td>
		<td valign="top">
			Gangguan konsep diri : Harga diri rendah. <br><br>

			<b>Data Subjektif :</b>  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>

			<b>Data Objektif :</b>  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Diplopia <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Pandangan kabur <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Aphasia sensorik <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Penurunan tingkat kesadaran <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Disorientasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Perubahan pola komunikasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Ketidakmampuan menilai
		</td>
		<td valign="top">
			Gangguan persepsi dapat diminimalisasi/tidak terjadi setelah dilakukan tindakan keperawatan  selama <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>
			Kriteria hasil : <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Mempertahankan tingkat kesadaran dan fungsi persepsi  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Merndemonstrasikan tingkah laku untuk mengkompensasikan kekurangan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Memori baik, dapast mengenal lingkungan, waktu, orang <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Kemampuan kognitif meningkat seperti 
			<div class="newline">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				 mampu menghitung kembali dengan tepat <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				 kemampuan berfikir logis <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				 mampu memecahkan masakah dan pengambilan keputusan dengan benar
			</div>
		</td>
		<td valign="top">
			<b> Mandiri<br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Kaji kemampuan persepsi pasien dan penerimaan sensorik <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Gunakan alat untuk membantu meningkatkan memori pasien <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Ciptakan lingkungan yang sederhana dan pindahkan alat-alat yang berbahaya <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Tempatkan barang-barang pada tempatnya semula <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Orientasikan pasien pada lingklungan , staf dan prosedur tindakan. <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Buatkan jadwal kegiatan sehari-hari <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Bantu pasien dalam aktifitas dan mobilitas untuk mencegah injury <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Perkenalkan foto orang-orang terdekat pasien <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Lakukan latihan memori yang sederhana <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Dokumentasikan kemampuan memori pasien <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Panggil pasien dengan nama kesukaannya <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Perkenalkan diri sebelum berinteraksi dengan pasien
		</td>
		<td valign="top">
			<?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>
		</td>
		<td valign="top">
			<?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "", "");$i++;?>
		</td>
	</tr>
</table>
<br><br><br>

<table class="align-text-top" width="100%" border="1">
	<tr>
		<th class="text-center">TGL</th>
		<th class="text-center">NO</th>
		<th class="text-center">DIAGNOSA KEPERAWATAN</th>
		<th class="text-center">TUJUAN</th>
		<th class="text-center">RENCANA TINDAKAN KEPERAWATAN</th>
		<th class="text-center">TANGGAL TERATASI</th>
		<th class="text-center">PARAF</th>
	</tr>
	<tr>
		<td valign="top"><?=input($arr_data[$i-1], "data_{$i}", "date", "form-control", "", "");$i++;?></td>
		<td valign="top"><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "", "");$i++;?></td>
		<td valign="top">
			Gangguan perawatan diri; ADL b/d deficit neuromuskuler; <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Menurunnya kekuatan otot dan daya tahan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Kahilangan kontrol otot <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Gangguan kognitif <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Gangguan sensori <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Kerusakan memori <br><br>

			<b>Data Subjektif </b><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br> <br>

			<b>Data Objektif : </b><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Adanya penurunan kesadaran <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Kelemahan fisik (hemiparese) <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Atropi otot <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Kontraktur otot <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Ketidakmampuan melakukan ADL sendiri <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Ganggfuan motorik dan sensorik <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Kerusakan kognitif <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Adanya disorientasi
		</td>
		<td valign="top">
			Perawatan diri; ADL pasien terpenuhi setelah dirawat selama <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br> <br>

			<b>Kriteria hasil : </b><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Mendemonmstrasikan perubahan dalam merawat diri; mandi, BAB, BAK, berpakaian, makan  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Menampilkan aktifitas perawatan secara mandiri
		</td>
		<td valign="top">
			<b>Mandiri </b><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Kaji kemampuan ADL pasien <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Anjurkan pasien untuk melakukan sendiri perawatan dirinya jika mampu <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Berikan umpan balik positif atas usaha pasien <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Bantu pasien secara bertahap kebutuhan perawatan diri <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Pertahankan dukungan, sikap tegas, beri cukup waktu untuk menyelesaikan perwatan diri <br> <br>


			 <b>Kolaborasi</b><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Lakukan fisiotherapy: occupasi therapy
		</td>
		<td valign="top">
			<?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>
		</td>
		<td valign="top">
			<?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "", "");$i++;?>
		</td>
	</tr>
</table>
<br><br><br>

<table class="align-text-top" width="100%" border="1">
	<tr>
		<th class="text-center">TGL</th>
		<th class="text-center">NO</th>
		<th class="text-center">DIAGNOSA KEPERAWATAN</th>
		<th class="text-center">TUJUAN</th>
		<th class="text-center">RENCANA TINDAKAN KEPERAWATAN</th>
		<th class="text-center">TANGGAL TERATASI</th>
		<th class="text-center">PARAF</th>
	</tr>
	<tr>
		<td valign="top"><?=input($arr_data[$i-1], "data_{$i}", "date", "form-control", "", "");$i++;?></td>
		<td valign="top"><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "", "");$i++;?></td>
		<td valign="top">
			Gangguan eliminasi urine; inkontinensia sehubungan dengan; <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Menurunnya sensasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Disfungsi kognitif <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Kerusakan komunikasi <br> <br>

			 <b>Data Subjektif</b> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Pasien mengatakan tidak mampu mengontrol BAK <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br> <br>

			 <b>Data Objektif :</b> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Inkontinensia <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Blader penuh <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Distensi Blader
		</td>
		<td valign="top">
			Eliminasi urine tidak terganggu  setelah dirawat selama <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>

			<b>Kriteria hasil :<br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Pola BAK normal  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Pasien dapat berkomunikasi sebelum BAK <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Kulit bersih dan kering <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Terhindar dari infeksi saluran kemih
		</td>
		<td valign="top">
			<b>Mandiri</b> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Kaji kembali tipe inkontinensia dan polanya <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Buatkan jadwal untuk BAK <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Palpasi blader terhadap adanya distensi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Berikan minum yang cukup 1500 -2000 ml jika tidak ada kontra indikasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Lakukan perawatan kateter setiap hari <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Monitor hasil urinalisa dan karakteristik urine <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Jaga privasi pasien saat BAK <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Hindari pasien minum sebelum tidur <br> <br>

			<b>Kolaborasi</b><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Lakukan pemeriksaan RFT dan urinalisa
		</td>
		<td valign="top">
			<?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>
		</td>
		<td valign="top">
			<?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "", "");$i++;?>
		</td>
	</tr>
</table>

<br><br><br>

<table class="align-text-top" width="100%" border="1">
	<tr>
		<th class="text-center">TGL</th>
		<th class="text-center">NO</th>
		<th class="text-center">DIAGNOSA KEPERAWATAN</th>
		<th class="text-center">TUJUAN</th>
		<th class="text-center">RENCANA TINDAKAN KEPERAWATAN</th>
		<th class="text-center">TANGGAL TERATASI</th>
		<th class="text-center">PARAF</th>
	</tr>
	<tr>
		<td valign="top"><?=input($arr_data[$i-1], "data_{$i}", "date", "form-control", "", "");$i++;?></td>
		<td valign="top"><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "", "");$i++;?></td>
		<td valign="top">
			Gangguan eliminasi bowel; konstipasi, diare sehubungan dengan; <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Menurunnya control volunter <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Perubahan peristaltik <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Kerusakan komunikasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Immobilisasi <br><br>

			<b>Data Subjektif </b><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Pasien mengatakan tidak bisa BAB/BAB lebih dari 3X sehari <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>

			<b>Data Objektif :</b><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Feses keras/encer <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Bising usus lambat/cepat <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Keadaan immobilisasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Penurunan kesadaran
		</td>
		<td valign="top">
			Eliminasi bowel tidak terganggu  setelah dirawat selama <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>

			 <b>Kriteria hasil :</b><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Pola BAB normal, feses lunak <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Pasien menyatakan secara verbal/non verbal kebutuhan-kebutuhan defekasi
		</td>
		<td valign="top">
			 <b>Mandiri</b><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Kaji pola BAB pasien <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Lakukan pemeriksaan peristaltik <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Palpasi blader terhadap adanya distensi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Lakukan mobilisasi dan aktifitas  sesuai kemampuan pasien <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Kaji status nutrisi dan berikan diet tinggi serat <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Berikan minum ekstra <br><br>

			  <b>Kolaborasi</b><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Berikan obat : 
			 <div class="newline">
			 	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Laksatif <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Suppositoria <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Enema
			 </div>
			
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Lakukan pemeriksaan RFT dan urinalisa
		</td>
		<td valign="top">
			<?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>
		</td>
		<td valign="top">
			<?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "", "");$i++;?>
		</td>
	</tr>
</table>

<br><br><br>

<table class="align-text-top" width="100%" border="1">
	<tr>
		<th class="text-center">TGL</th>
		<th class="text-center">NO</th>
		<th class="text-center">DIAGNOSA KEPERAWATAN</th>
		<th class="text-center">TUJUAN</th>
		<th class="text-center">RENCANA TINDAKAN KEPERAWATAN</th>
		<th class="text-center">TANGGAL TERATASI</th>
		<th class="text-center">PARAF</th>
	</tr>
	<tr>
		<td valign="top"><?=input($arr_data[$i-1], "data_{$i}", "date", "form-control", "", "");$i++;?></td>
		<td valign="top"><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "", "");$i++;?></td>
		<td valign="top">
			Resiko injury; jatuh berhubungan dengan; <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Aktifitas kejang <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Penurunan kesadaran <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Penurunan status mental <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Kerusakan persepsi sensori <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Gelisah <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Gangguan fungsi motorik <br><br>

			<b>Data Subjektif </b><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>

			<b>Data Objektif : </b><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Penurunan kesadaran;  
			<div class="newline">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kesadaran <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> GCS <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>
			</div>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Aktifitas kejang:
			<div class="newline">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tonik <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Klonik <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tonik klonik <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Durasi <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> 
			</div>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Perubahan status mental <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Kerusakan persepsi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Orientasi kurang <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Gangguan fungsi motorik
		</td>
		<td valign="top">
			Injury tidak terjadi  setelah dilakukan tindakan keperawatan  selama 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>  <br><br>

			<b>Kriteria hasil : <br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Mempertahankan tingkat kesadaran dan orientasi  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kejang tidak terjadi/dapat diantisipasi/dapat dikontrol <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Injury tidak terjadi
		</td>
		<td valign="top">
			<b>Mandiri</b><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kaji status neurologi secara berkesinambungan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pertahankan keamanan pasien;
			<div class="newline">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Gunakan penghalang tempat tidur <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kunci roda tempat tidur <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Siapkan suction <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Siapkan spatel <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Siapkan oksigen
			</div>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Catat aktifitas kejang dan tunggui pasien selama kejang <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kaji status neurologis dan tanda-tanda vital setelah kejang <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Orientasikan pasien kelingkungan sekitar  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Jaga kenyamanan lingkungan <br><br>

			<b>Kolaborasi</b><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Berikan obat anti kejang
		</td>
		<td valign="top">
			<?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>
		</td>
		<td valign="top">
			<?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "", "");$i++;?>
		</td>
	</tr>
</table>

<br><br><br>

<table class="align-text-top" width="100%" border="1">
	<tr>
		<th class="text-center">TGL</th>
		<th class="text-center">NO</th>
		<th class="text-center">DIAGNOSA KEPERAWATAN</th>
		<th class="text-center">TUJUAN</th>
		<th class="text-center">RENCANA TINDAKAN KEPERAWATAN</th>
		<th class="text-center">TGL / JAM TERATASI</th>
		<th class="text-center">PARAF</th>
	</tr>
	<tr>
		<td valign="top"><?=input($arr_data[$i-1], "data_{$i}", "date", "form-control", "", "");$i++;?></td>
		<td valign="top"><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "", "");$i++;?></td>
		<td valign="top">
			Gangguan rasa nyaman; peningkatan suhu tubuh berhubungan dengan proses infeksi/peradangan <br><br>

			<b>Data Subjektif </b><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Pasien mengatakan badannya terasa panas  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pasien mengatakan haus <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>

			<b>Data Objektif : </b><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Suhu tubuh pasien <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> &deg;C <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Vital Sign : 
			TD <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:80px", "");$i++;?> mmHg, 
			&emsp;RR <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:80px", "");$i++;?> x/mm, 
			&emsp;HR <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:80px", "");$i++;?> x/mm <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Kulit kering <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Turgor <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>. <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Urine : 
			jumlah <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> cc/jam, 
			&emsp;warna <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hasil darah rutin :
			<div class="newline">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hb <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ht <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Leukosit <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Trombosit <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>
			</div>
		</td>
		<td valign="top">
			Rasa nyaman terpenuhi, suhu tubuh kembali normal  setelah dilakukan tindakan keperawatan  selama <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>

			<b>Kriteria hasil : </b><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Suhu tubuh normal 36,5 – 37, 5 &deg;C   <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Tanda-tanda vital dalam batas normal <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Turgor baik <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Urine jernih, jumlah cukup
		</td>
		<td valign="top">
			<b>Mandiri <br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Monitor suhu tubuh  sebelum dan setelah dilakukan tindakan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Observasi tanda-tanda dehidrasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Catat intake dan output cairan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Observasi jumlah dan warna urine <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Berikan minum ekstra ± 2000 cc/h <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Monitor tanda-tanda kejang <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Monitor hasil pemeriksaan laboratorium  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Berikan kompres <br><br>
			<b>Kolaborasi <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br></b>

			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Berikan obat anti piretik <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Berikan/tingkatkan pemberian cairan intra vena
		</td>
		<td valign="top">
			<?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?> / 
			<?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?>
		</td>
		<td valign="top">
			<?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "", "");$i++;?>
		</td>
	</tr>
</table>
<br><br><br>

<table class="align-text-top" width="100%" border="1">
	<tr>
		<th class="text-center">TGL</th>
		<th class="text-center">NO</th>
		<th class="text-center">DIAGNOSA KEPERAWATAN</th>
		<th class="text-center">TUJUAN</th>
		<th class="text-center">RENCANA TINDAKAN KEPERAWATAN</th>
		<th class="text-center">TGL / JAM TERATASI</th>
		<th class="text-center">PARAF</th>
	</tr>
	<tr>
		<td valign="top"><?=input($arr_data[$i-1], "data_{$i}", "date", "form-control", "", "");$i++;?></td>
		<td valign="top"><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "", "");$i++;?></td>
		<td valign="top">
			Defisit (resiko) volume  cairan berhubungan dengan  :  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Intake tidak aderkuat <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kehilangan cairan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Terapi diuretik <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pembatasan cairan <br><br>

			<b>Data Subjektif </b><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pasien mengeluhkan haus <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>

			<b>Data Objektif : </b><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Pembatasan cairan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Penggunaan obat-obat diuretic <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Intake 
			<?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:70px", "");$i++;?> cc &emsp;
			Out put <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:70px", "");$i++;?> cc <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Dijumpai tyanda- tanda kekurangan cairan
			<div class="newline">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Mukosa kering <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Turgor <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Mata cekung <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kulit kering <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Suhu tubuh pasien <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:80px", "");$i++;?> &deg;C
			</div>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Vital Sign : 
			TD<?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:80px", "");$i++;?> mmHg, 
			&emsp;RR <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:80px", "");$i++;?> x/mm, 
			&emsp;HR <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:80px", "");$i++;?> x/mm <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Urine : 
			jumlah <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:80px", "");$i++;?> cc/jam, 
			&emsp;warna <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hasil darah rutin : <br><br>
			<div class="newline">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hb <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ht <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Leukosit <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Trombosit <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>			
			</div>

		</td>
		<td valign="top">
			Defisi volume cairan tidak terjadi/dapat diatasi setelah dilakukan tindakan keperawatan selama <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>
			<b>Kriteria hasil : </b><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> pasien dapat mempertahankan fungsi hemodinamik
			<div class="newline">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TD dalam batas normal <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Denyut jantung teratur
			</div>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Cairan dan elektrolit seimbang secara proporsional <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Intake dan out put seimbang <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak dijumpai tanda-tanda dehidrasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Urine jernih, jumlah cukup
		</td>
		<td valign="top">
			<b>Mandiri <br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Monitor intake dan output cairan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Observasi tanda-tanda dehidrasi
			<div class="newline">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Rasa haus <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kulit kering <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Turgor kurang <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kelemahan <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Penurunan BB
			</div>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Observasi jumlah dan warna urine <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Berikan minum ekstra ± 2000 cc/h <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Monitor tanda-tanda kejang <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Monitor hasil pemeriksaan laboratorium 
			<div class="newline">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Elektrolit <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hematokrit
			</div>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Berikan kompres <br><br>

			<b>Kolaborasi </b><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Berikan obat anti piretik <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Berikan/tingkatkan pemberian cairan intra vena <br>
		</td>
		<td valign="top">
			<?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?> / 
			<?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?>
		</td>
		<td valign="top">
			<?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "", "");$i++;?>
		</td>
	</tr>
</table>

<br><br><br>

<table class="align-text-top" width="100%" border="1">
	<tr>
		<th class="text-center">TGL</th>
		<th class="text-center">NO</th>
		<th class="text-center">DIAGNOSA KEPERAWATAN</th>
		<th class="text-center">TUJUAN</th>
		<th class="text-center">RENCANA TINDAKAN KEPERAWATAN</th>
		<th class="text-center">TGL / JAM TERATASI</th>
		<th class="text-center">PARAF</th>
	</tr>
	<tr>
		<td valign="top"><?=input($arr_data[$i-1], "data_{$i}", "date", "form-control", "", "");$i++;?></td>
		<td valign="top"><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "", "");$i++;?></td>
		<td valign="top">
			Perubahan nutrisi kurang dari kebutuhan tubuh berhubungan dengan anoreksia, kelemahan, mual dan muintah, intake yang tidak adekuat <br><br>

			<b>Data Subjektif <br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Pasien mengatakan tidak nafsu makan, mual dan muntah <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>


			<b>Data Objektif :</b><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Makanan yang disediakan tidak habis <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Penuruinan BB, 
			<div class="newline">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> BB  sebelum sakit <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> Kg, <br>  
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> BB saat ini <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> Kg
			</div>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  Adanya tanda-tanda kekurangan nutrisi 
			<div class="newline">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Anemis <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Cepat lelah
			</div>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 TD <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> mmHg <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Hasil lab :
			<div class="newline">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> HB <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> mg % <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Albumin <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100px", "");$i++;?>
			</div>
		</td>
		<td valign="top">
			Pemenuhhan kebutuhan nutrisi adekuat setrelah dilakukan tindakan keperawatan selama <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>

			Kriteria hasil : <b></b><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Nafsu makan pasien baik  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Pasien dapat menghabiskan makanan yang disediakan oleh RS <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Terjadi peningkatan BB secara bertahap. <br>
			Kenaikan BB <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> Kg/<?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 tidak ditemukan tanda-tanda kekurangan nutrisi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Hb <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Albumin <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>
		</td>
		<td valign="top">
			<b>Mandiri <br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kaji makanan kesukaan pasien <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Berikan makanan pasien dalam porsi yang kecil tapi sering <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Usahan berbaring lebih dari satu jam setelah makan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Timbang BB setiap hari <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kurangi minum sebelum makan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hindari keadaan yang dapat mengganggu selera makan :
			<div class="newline">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lingkungan yang kotor dan bau <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tempat makan yang kurang bersih <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Suasana ruangan yang gaduh
			</div>
			
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sajikan makanan dalam keadaan hangat, hygiene dan menarik <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lakukan perawatan muluit <br><br>


			<b>Kolaborasi <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Berikan obat anti emetik <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lakukan pemeriksaan Hb dan albumin secara berkala
		</td>
		<td valign="top">
			<?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?> / 
			<?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?>
		</td>
		<td valign="top">
			<?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "", "");$i++;?>
		</td>
	</tr>
</table>

<br><br><br>

<table class="align-text-top" width="100%" border="1">
	<tr>
		<th class="text-center">TGL</th>
		<th class="text-center">NO</th>
		<th class="text-center">DIAGNOSA KEPERAWATAN</th>
		<th class="text-center">TUJUAN</th>
		<th class="text-center">RENCANA TINDAKAN KEPERAWATAN</th>
		<th class="text-center">TGL / JAM TERATASI</th>
		<th class="text-center">PARAF</th>
	</tr>
	<tr>
		<td valign="top"><?=input($arr_data[$i-1], "data_{$i}", "date", "form-control", "", "");$i++;?></td>
		<td valign="top"><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "", "");$i++;?></td>
		<td valign="top">
			Tidak efektif pola nafas berhubungan dengan : <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kerusakan neuromuskuler <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Paralisis otot pernafasan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kontrol mekanisme ventilasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Komplikasi pada paru-paru <br><br>

			<b>Data Subjektif <br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pasien mengeluh sulit bernafas <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>


			<b>Data Objektif : <br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  pola nafas <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Pernafasan cuping hidung <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Penggunaan otot bantu nafas <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Trauma pada cervical <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  vital sign : 
			<div class="newline">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TD <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> mmHg <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> HR <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> X/m <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> RR <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> x/m <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> S <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> &deg;C
			</div>
			
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Nilai AGD :
			<div class="newline">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ph <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> PaO2 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> PCO2 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> H2CO3 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> BE <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> SaO2 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			</div>
			
		</td>
		<td valign="top">
			Pola nafas adekuat setelah dilakukan tindakan keperawatan selama <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>


			<b>Kriteria hasil :</b><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Pasien menunjukkan pola nafas yang efektif  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 RR 16 – 20 x/m
		</td>
		<td valign="top">
			<b>Mandiri <br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kaji frekuensi, kedalaman, irama nafas <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Auskultasi bunyi nafas <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pertahankan kebersihan jalan nafas, suction bila perlu <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Berikan posisi semi fowler <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Monitor tanda-tanda vital <br><br>

			<b>Kolaborasi <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Berikan oksigen sesuai kebutuhan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Cek AGD <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hindari penggunaan obat sedative jika mungkin

		</td>
		<td valign="top">
			<?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?> / 
			<?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?>
		</td>
		<td valign="top">
			<?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "", "");$i++;?>
		</td>
	</tr>
</table>

<br><br><br>

<table class="align-text-top" width="100%" border="1">
	<tr>
		<th class="text-center">TGL</th>
		<th class="text-center">NO</th>
		<th class="text-center">DIAGNOSA KEPERAWATAN</th>
		<th class="text-center">TUJUAN</th>
		<th class="text-center">RENCANA TINDAKAN KEPERAWATAN</th>
		<th class="text-center">TGL / JAM TERATASI</th>
		<th class="text-center">PARAF</th>
	</tr>
	<tr>
		<td valign="top"><?=input($arr_data[$i-1], "data_{$i}", "date", "form-control", "", "");$i++;?></td>
		<td valign="top"><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "", "");$i++;?></td>
		<td valign="top">
			Tidak efektif bersihan jalan nafas berhubungan dengan tidak efektifnya reflek batuk, immobilisasi <br>

			<b>Data Subjektif <br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>


			<b>Data Objektif : <br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Kemampuan batuk kurang atau tidak ada  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Suara nafas stridor <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Takhipnea <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Nilai AGD :
			<div class="newline">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ph <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> PO2 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> PCO2  <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bicnat  <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> BE <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> SaO2 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			</div>
			
		</td>
		<td valign="top">
			Bersihan jalan nafas efektif setelah dilakukan tindakan keperawatan selama  <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>


			<b>Kriteria hasil :</b><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Batuk efektif   <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Pasien mampu mengeluarkan secret <br>
			 <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Suara nafas normal  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Tanda-tanda vital dalam batas normal <br>
			 <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Nilai AGD dalam batas normal <br>
		</td>
		<td valign="top">
			<b>Mandiri <br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kaji kemampuan batuk dan produksi sekret <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pertahankan kepatenan jalan nafas; 
			<div class="newline">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hindari fleksi leher <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bersihkan sekret

			</div>
			Monitor warna, jumlah dan konsistensi sekret <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lakukan suction  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Auskultasi bunyi nafas <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lakukan latihan nafas <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Berikan minum hangat jika ada kontra indikasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Monitor tanda-tanda vital  <br><br>

			<b>Kolaborasi <br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lakukan kultur sputum <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Cek AGD <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Berikan oksigen sesuai kebutuhan

		</td>
		<td valign="top">
			<?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?> / 
			<?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?>
		</td>
		<td valign="top">
			<?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "", "");$i++;?>
		</td>
	</tr>
</table>

<br><br><br>

<table class="align-text-top" width="100%" border="1">
	<tr>
		<th class="text-center">TGL</th>
		<th class="text-center">NO</th>
		<th class="text-center">DIAGNOSA KEPERAWATAN</th>
		<th class="text-center">TUJUAN</th>
		<th class="text-center">RENCANA TINDAKAN KEPERAWATAN</th>
		<th class="text-center">TGL / JAM TERATASI</th>
		<th class="text-center">PARAF</th>
	</tr>
	<tr>
		<td valign="top"><?=input($arr_data[$i-1], "data_{$i}", "date", "form-control", "", "");$i++;?></td>
		<td valign="top"><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "", "");$i++;?></td>
		<td valign="top">
			Nyeri berhubungan derngan nyeri kepala, kaku kuduk, iritasi meningeal <br><br>

			<b>Data Subjektif <br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pasien mengeluh nyeri kepala, kaku pada leher dan merasa tidak nyaman <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>


			<b>Data Objektif : <br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Ekspresi wajah  <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Sikap tubuh <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Kaku kuduk positif <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  vital sign :
			<div class="newline">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TD <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> mmHg <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> HR <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> X/m <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> RR <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> x/m <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> S <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> &deg;C
			</div>
			
		</td>
		<td valign="top">
			Nyeri hilang/berkurang/dapat ditoleransi setelah dilakukan tindakan keperawatan selama   <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>


			<b>Kriteria hasil :</b><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Pasien menyampaikan nyeri berkurang /hilang    <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Ekspresi wajah biasa, tidak menunjukkan rasa nyeri <br>
			 <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Sikap tubuh tenang, tidak menunjukan rasa nyeri  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Tanda-tanda vital dalam batas normal <br>
			 <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Tanda-tanda vital dalam batas normal <br>
		</td>
		<td valign="top">
			<b>Mandiri <br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kaji tingkat nyeri pasien <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> kaji gfaktor yang dapat meringankan atau memperberat nyeri <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lakukan perubahan posisi untuk meningkatkan rasa nyaman <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Jaga lingkungan untuk tetap nyaman 
			<div class="newline">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Mengurangi cahaya <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Mengurangi kebisingan
			</div>

			</div>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lakukan masase pada daerah yang nyeri , berikan kompres hangat<br><br>

			<b>Kolaborasi <br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Berikan obat analgetik<br>

		</td>
		<td valign="top">
			<?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?> / 
			<?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?>
		</td>
		<td valign="top">
			<?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "", "");$i++;?>
		</td>
	</tr>
</table>

<br><br><br>

<table class="align-text-top" width="100%" border="1">
	<tr>
		<th class="text-center">TGL</th>
		<th class="text-center">NO</th>
		<th class="text-center">DIAGNOSA KEPERAWATAN</th>
		<th class="text-center">TUJUAN</th>
		<th class="text-center">RENCANA TINDAKAN KEPERAWATAN</th>
		<th class="text-center">TGL / JAM TERATASI</th>
		<th class="text-center">PARAF</th>
	</tr>
	<tr>
		<td valign="top"><?=input($arr_data[$i-1], "data_{$i}", "date", "form-control", "", "");$i++;?></td>
		<td valign="top"><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "", "");$i++;?></td>
		<td valign="top">
			Tidak efektif pola nafas berhubungan dengan : <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kerusakan neuromuskuler <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Paralisis otot pernafasan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kontrol mekanisme ventilasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Komplikasi pada paru-paru <br><br>


			<b>Data Objektif : <br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Pasien mengeluh sulit bernafas<br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>

			<b>Data Objektif : <br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  pola nafas <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Pernafasan cuping hidung <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Penggunaan otot bantu nafas <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Trauma pada cervical <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  vital sign :
			<div class="newline">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TD <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> mmHg <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> HR <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> X/m <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> RR <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> x/m <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> S <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> &deg;C
			</div>
			
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Nilai AGD :
			<div class="newline">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ph <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> PaO2 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> PCO2 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> H2CO3 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> BE <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> SaO2 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>
			</div>
		</td>
		<td valign="top">
			Pola nafas adekuat setelah dilakukan tindakan keperawatan selama <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>


			<b>Kriteria hasil :</b><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Pasien menunjukkan pola nafas yang efektif <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 RR 16 – 20 x/m<br>
		</td>
		<td valign="top">
			<b>Mandiri <br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kaji frekuensi, kedalaman, irama nafas<br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Auskultasi bunyi nafas <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pertahankan kebersihan jalan nafas, suction bila perlu <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Berikan posisi semi fowler <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Monitor tanda-tanda vital<br><br>

			<b>Kolaborasi <br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Berikan oksigen sesuai kebutuhan<br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Cek AGD<br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hindari penggunaan obat sedative jika mungkin<br>	

		</td>
		<td valign="top">
			<?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?> / 
			<?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?>
		</td>
		<td valign="top">
			<?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "", "");$i++;?>
		</td>
	</tr>
</table>

<br><br><br>

<table class="align-text-top" width="100%" border="1">
	<tr>
		<th class="text-center">TGL</th>
		<th class="text-center">NO</th>
		<th class="text-center">DIAGNOSA KEPERAWATAN</th>
		<th class="text-center">TUJUAN</th>
		<th class="text-center">RENCANA TINDAKAN KEPERAWATAN</th>
		<th class="text-center">TGL / JAM TERATASI</th>
		<th class="text-center">PARAF</th>
	</tr>
	<tr>
		<td valign="top"><?=input($arr_data[$i-1], "data_{$i}", "date", "form-control", "", "");$i++;?></td>
		<td valign="top"><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "", "");$i++;?></td>
		<td valign="top">
			Penurunan curah jantung b/d hilangnya tonus vasomotor (syok neurologi) <br><br>


			<b>Data Objektif : <br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>

			<b>Data Objektif : <br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Kesadaran menurun <br>
			<div class="newline">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Kesadaran  <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> CGS <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			</div>
			
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Keringat dingin <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Penurunan produksi urine <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> vital sign : <div class="newline">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TD <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> mmHg <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> HR <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> X/m <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> RR <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> x/m <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> S <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> &deg;C
			</div>
		</td>
		<td valign="top">
			Curah jantung adekuat setelah dilakukan tindakan keperawatan selama <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>


			<b>Kriteria hasil :</b><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Tanda-tanda vital dalam batas  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Hemodinamik stabil<br>
		</td>
		<td valign="top">
			<b>Mandiri <br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kaji frekuensi, kedalaman, irama nafas<br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Auskultasi bunyi nafas <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pertahankan kebersihan jalan nafas, suction bila perlu <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Berikan posisi semi fowler <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Monitor tanda-tanda vital<br><br>

			<b>Kolaborasi <br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lakukan perubahan posisi secara perlahan<br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kaji fungsi kardiovaskuler dan cegah spinal shock
			<div class="newline">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TD <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Nadi Suhu <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Temperatur kulit <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Status hidrasi
			</div>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Monitor secara berkala : <br>
			<div class="newline">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Postural hipotensi <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bradikardi <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Disritmia <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Urine out put <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TD
			</div>	
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lakukan ROM aktif / pasif <br><br>

			<b>Kolaborasi <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Berikan atropin
		</td>
		<td valign="top">
			<?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?> / 
			<?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?>
		</td>
		<td valign="top">
			<?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "", "");$i++;?>
		</td>
	</tr>
</table>

<br><br><br>

<table class="align-text-top" width="100%" border="1">
	<tr>
		<th class="text-center">TGL</th>
		<th class="text-center">NO</th>
		<th class="text-center">DIAGNOSA KEPERAWATAN</th>
		<th class="text-center">TUJUAN</th>
		<th class="text-center">RENCANA TINDAKAN KEPERAWATAN</th>
		<th class="text-center">TGL / JAM TERATASI</th>
		<th class="text-center">PARAF</th>
	</tr>
	<tr>
		<td valign="top"><?=input($arr_data[$i-1], "data_{$i}", "date", "form-control", "", "");$i++;?></td>
		<td valign="top"><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "", "");$i++;?></td>
		<td valign="top">
			Gangguan perfusdi jaringan medulla spinalis berhubungan dengan : <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kompresi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kontusio <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Edema <br><br>

			<b>Data Subjektif </b><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pasien mengeluh nyeri pada <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>

			<b>Data Objektif : </b><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />   <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Keringat dingin <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Penurunan produksi urine <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  vital sign : 
			<div class="newline">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TD <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> mmHg <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> HR <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> X/m <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> RR <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> x/m <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> S <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> &deg;C
			</div>
			
		</td>
		<td valign="top">
			Curah jantung adekuat setelah dilakukan tindakan keperawatan selama <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>


			<b>Kriteria hasil :</b><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Tanda-tanda vital dalam batas  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Hemodinamik stabil<br>
		</td>
		<td valign="top">
			<b>Mandiri <br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kaji frekuensi, kedalaman, irama nafas<br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Auskultasi bunyi nafas <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pertahankan kebersihan jalan nafas, suction bila perlu <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Berikan posisi semi fowler <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Monitor tanda-tanda vital<br><br>

			<b>Kolaborasi <br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lakukan perubahan posisi secara perlahan<br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kaji fungsi kardiovaskuler dan cegah spinal shock
			<div class="newline">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TD <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Nadi Suhu <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Temperatur kulit <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Status hidrasi
			</div>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Monitor secara berkala : <br>
			<div class="newline">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Postural hipotensi <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bradikardi <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Disritmia <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Urine out put <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TD
			</div>	
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lakukan ROM aktif / pasif <br><br>

			<b>Kolaborasi <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Berikan atropin
		</td>
		<td valign="top">
			<?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?> / 
			<?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?>
		</td>
		<td valign="top">
			<?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "", "");$i++;?>
		</td>
	</tr>
</table>

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
<div style="text-align: right"><img style="width: 350px" class="text-right" src="../../images/alamat.jpg"></div>

	<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery-1.9.1.js"></script>
	<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery.form.js"></script>
    <script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>
    <script type="text/javascript" src="../../theme/js/ajax.js"></script>
	<script src="../../theme/bs/bootstrap.min.js"></script>
	<script type="text/javascript">
		function openPrintDialogue(){
			  $('<iframe>', {
			    name: 'myiframe',
			    class: 'printFrame'
			  })
			  .appendTo('body')
			  .contents().find('body')

			  window.frames['myiframe'].focus();
			  window.frames['myiframe'].print();

			  setTimeout(() => { $(".printFrame").remove(); }, 1000);
			};

			<?php if(isset($_REQUEST["pdf"])): ?>
				const pdf = document.getElementById("pdf-area");
				var opt = {
					margin: 0,
					filename: "RM 22 <?=$dataPasien["nama"]?>.pdf",
					image: { type: "JPEG", quality: 1 },
					html2canvas: { scale: 1 },
					jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
				};
				html2pdf().from(pdf).set(opt).save();
			<?php endif; ?>
	</script>
</body>

</html>