<?php
	use yii\helpers\Html;
	include '../function/form.php';
	include '../../koneksi/konek.php';
	include 'funct.php';
	$dataPasien = getIndetitasPasien($_REQUEST['idKunj']);
	$i = 1;
	
if (isset($_REQUEST['cetak'])) {
    $print_mode = true;
    echo "<script>window.print();</script>";
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_checklist_kesiapan_operasi WHERE id = '{$_REQUEST['cetak']}'"));

	$arr_data = []; $str_data = "";
    $signin_1 = $data['signin_opsi_pertama'];
    $signin_2 = $data['signin_opsi_kedua'];
    $signin_3 = $data['signin_opsi_ketiga'];
    $signin_4 = $data['signin_opsi_keempat'];
    $signin_5 = $data['signin_opsi_kelima'];
    $signin_6 = $data['signin_opsi_keenam'];
    $signin_7 = $data['signin_opsi_ketujuh'];
    $signin_8 = $data['signin_anastesi'];

    $timeout_1 = $data['timeout_operator'];
    $timeout_2 = $data['timeout_asisten'];
    $timeout_3 = $data['timeout_instrument'];
    $timeout_4 = $data['timeout_sirkuler'];
    $timeout_5 = $data['timeout_prosedur'];
    $timeout_6 = $data['timeout_lokasi_inisiasi'];
    $timeout_7 = $data['timeout_opsi_pertama'];
    $timeout_8 = $data['timeout_opsi_kedua'];
    $timeout_9 = $data['timeout_opsi_ketiga'];
    $timeout_10 = $data['timeout_opsi_keempat'];
    $timeout_11 = $data['timeout_opsi_kelima'];
    $timeout_12 = $data['timeout_opsi_keenam'];
    $timeout_13 = $data['timeout_perawat_sirkuaer'];

    $signout_1 = $data['signout_opsi_pertama'];
    $signout_2 = $data['signout_opsi_kedua'];

    for ($q=1; $q < 10; $q++) { 
    	$str_data .= ${"signin_" . $q};
    }

    for ($w=1; $w < 14; $w++) { 
    	$str_data .= ${"timeout_" . $w};
    }

    for ($e=1; $e < 13; $e++) { 
    	$str_data .= ${"signout_" . $e};
    }

    $arr_data = explode("|", $str_data);

  }

  if (isset($_REQUEST['pdf'])) {
    $print_mode = true;
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_checklist_kesiapan_operasi WHERE id = '{$_REQUEST['pdf']}'"));

    $arr_data = [];
    $str_data = "";
    $signin_1 = $data['signin_opsi_pertama'];
    $signin_2 = $data['signin_opsi_kedua'];
    $signin_3 = $data['signin_opsi_ketiga'];
    $signin_4 = $data['signin_opsi_keempat'];
    $signin_5 = $data['signin_opsi_kelima'];
    $signin_6 = $data['signin_opsi_keenam'];
    $signin_7 = $data['signin_opsi_ketujuh'];
    $signin_8 = $data['signin_anastesi'];

    $timeout_1 = $data['timeout_operator'];
    $timeout_2 = $data['timeout_asisten'];
    $timeout_3 = $data['timeout_instrument'];
    $timeout_4 = $data['timeout_sirkuler'];
    $timeout_5 = $data['timeout_prosedur'];
    $timeout_6 = $data['timeout_lokasi_inisiasi'];
    $timeout_7 = $data['timeout_opsi_pertama'];
    $timeout_8 = $data['timeout_opsi_kedua'];
    $timeout_9 = $data['timeout_opsi_ketiga'];
    $timeout_10 = $data['timeout_opsi_keempat'];
    $timeout_11 = $data['timeout_opsi_kelima'];
    $timeout_12 = $data['timeout_opsi_keenam'];
    $timeout_13 = $data['timeout_perawat_sirkuaer'];

    $signout_1 = $data['signout_opsi_pertama'];
    $signout_2 = $data['signout_opsi_kedua'];

    for ($q=1; $q < 10; $q++) {
        $str_data .= ${"signin_" . $q};
    }

    for ($w=1; $w < 14; $w++) {
        $str_data .= ${"timeout_" . $w};
    }

    for ($e=1; $e < 13; $e++) {
        $str_data .= ${"signout_" . $e};
    }

    $arr_data = explode("|", $str_data);
}


  if (isset($_REQUEST['id'])) {
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_checklist_kesiapan_operasi WHERE id = '{$_REQUEST['id']}'"));
    $arr_data = []; $str_data = "";
    $signin_1 = $data['signin_opsi_pertama'];
    $signin_2 = $data['signin_opsi_kedua'];
    $signin_3 = $data['signin_opsi_ketiga'];
    $signin_4 = $data['signin_opsi_keempat'];
    $signin_5 = $data['signin_opsi_kelima'];
    $signin_6 = $data['signin_opsi_keenam'];
    $signin_7 = $data['signin_opsi_ketujuh'];
    $signin_8 = $data['signin_anastesi'];

    $timeout_1 = $data['timeout_operator'];
    $timeout_2 = $data['timeout_asisten'];
    $timeout_3 = $data['timeout_instrument'];
    $timeout_4 = $data['timeout_sirkuler'];
    $timeout_5 = $data['timeout_prosedur'];
    $timeout_6 = $data['timeout_lokasi_inisiasi'];
    $timeout_7 = $data['timeout_opsi_pertama'];
    $timeout_8 = $data['timeout_opsi_kedua'];
    $timeout_9 = $data['timeout_opsi_ketiga'];
    $timeout_10 = $data['timeout_opsi_keempat'];
    $timeout_11 = $data['timeout_opsi_kelima'];
    $timeout_12 = $data['timeout_opsi_keenam'];
    $timeout_13 = $data['timeout_perawat_sirkuaer'];

    $signout_1 = $data['signout_opsi_pertama'];
    $signout_2 = $data['signout_opsi_kedua'];

    for ($q=1; $q < 10; $q++) { 
    	$str_data .= ${"signin_" . $q};
    }

    for ($w=1; $w < 14; $w++) { 
    	$str_data .= ${"timeout_" . $w};
    }

    for ($e=1; $e < 13; $e++) { 
    	$str_data .= ${"signout_" . $e};
    }

    $arr_data = explode("|", $str_data);

  }

  if (isset($_REQUEST['idx'])) {
	date_default_timezone_set("Asia/Jakarta");
	$tgl_act = date('Y-m-d H:i:s');
	$data = [
        'tgl_act' => date('Y-m-d H:i:s'),
        'id_user' => mysql_real_escape_string($_REQUEST["id_user"]),
        'signin_opsi_pertama' => mysql_real_escape_string($_REQUEST["data_1"]). "|",
        'signin_opsi_kedua' => mysql_real_escape_string($_REQUEST["data_2"]) . "|" . mysql_real_escape_string($_REQUEST["data_3"]) . "|",
        'signin_opsi_ketiga' => mysql_real_escape_string($_REQUEST["data_4"]) . "|",
        'signin_opsi_keempat' => mysql_real_escape_string($_REQUEST["data_5"]) . "|",
        'signin_opsi_kelima' => mysql_real_escape_string($_REQUEST["data_6"]) . "|" . mysql_real_escape_string($_REQUEST["data_7"]) . "|",
        'signin_opsi_keenam' => mysql_real_escape_string($_REQUEST["data_8"]) . "|" . mysql_real_escape_string($_REQUEST["data_9"]) . "|",
        'signin_opsi_ketujuh' => mysql_real_escape_string($_REQUEST["data_10"]) . "|" . mysql_real_escape_string($_REQUEST["data_11"]) . "|",
        'signin_anastesi' => mysql_real_escape_string($_REQUEST["data_12"]) . "|",
        'timeout_operator' => mysql_real_escape_string($_REQUEST["data_13"]) . "|",
        'timeout_asisten' => mysql_real_escape_string($_REQUEST["data_14"]) . "|",
        'timeout_instrument' => mysql_real_escape_string($_REQUEST["data_15"]) . "|",
        'timeout_sirkuler' => mysql_real_escape_string($_REQUEST["data_16"]) . "|",
        'timeout_prosedur' => mysql_real_escape_string($_REQUEST["data_17"]) . "|",    
        'timeout_lokasi_inisiasi' => mysql_real_escape_string($_REQUEST["data_18"]) . "|",
        'timeout_opsi_pertama' => mysql_real_escape_string($_REQUEST["data_19"]) . "|" . mysql_real_escape_string($_REQUEST["data_20"]) . "|",
        'timeout_opsi_kedua' => mysql_real_escape_string($_REQUEST["data_21"]) . "|" . mysql_real_escape_string($_REQUEST["data_22"]) . "|" . mysql_real_escape_string($_REQUEST["data_23"]) . "|",
        'timeout_opsi_ketiga' => mysql_real_escape_string($_REQUEST["data_24"]) . "|",
        'timeout_opsi_keempat' => mysql_real_escape_string($_REQUEST["data_25"]) . "|" . mysql_real_escape_string($_REQUEST["data_26"]) . "|",
        'timeout_opsi_kelima' => mysql_real_escape_string($_REQUEST["data_27"]) . "|" . mysql_real_escape_string($_REQUEST["data_28"]) . "|",
        'timeout_opsi_keenam' => mysql_real_escape_string($_REQUEST["data_29"]) . "|" . mysql_real_escape_string($_REQUEST["data_30"]) . "|",
        'timeout_perawat_sirkuaer' => mysql_real_escape_string($_REQUEST["data_31"]) . "|",
        'signout_opsi_pertama' => mysql_real_escape_string($_REQUEST["data_32"]) . "|" . mysql_real_escape_string($_REQUEST["data_33"]) . "|" . mysql_real_escape_string($_REQUEST["data_34"]) . "|" . mysql_real_escape_string($_REQUEST["data_35"]) . "|",
        'signout_opsi_kedua' => mysql_real_escape_string($_REQUEST["data_36"]) . "|" . mysql_real_escape_string($_REQUEST["data_37"])

    ];

      update("rm_checklist_kesiapan_operasi", $_REQUEST['idx'], $data);
      
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
	</style>
  <script src="../html2pdf/ppdf.js"></script>
</head>

<body id="pdf-area">

	<div class="bg-white" style="padding: 10px">
		<div class="row">

				<div class="col-6 text-center"><br><br><br><br>
				<img src="../logors1.png">
			</div>
			<div class="col-6" style="padding:40px">
				<div style="float: right">RM 21.20 / PHCM</div>
				<br>
				<div id="box" class="row" style="border: 1px solid black;padding:10px">
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

		<hr class="bg-dark" style="margin-top:-25px"><br>
		<div style="height:5px;background-color:black;width:100%;margin-bottom:10px;margin-top:-35px"></div><br>
		<h4 class="text-center">CEKLIS KESELAMATAN OPERASI</h4><br>
	
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
	
	
	

<div class="row">
	<div class="col-2">
		<div style="border: 2px solid black;border-radius: 5px;width: 100%;padding: 20px;height: 130px" class="text-center">
			SEBELUM  INDUKSI PASIEN
		</div>
	</div>
	<div class="col-3">
		<img height="120px" width="100%" src="../../images/arrow.png">
	</div>
	<div class="col-2">
		<div style="border: 2px solid black;border-radius: 5px;width: 100%;padding: 10px;height: 130px" class="text-center">
			SEBELUM INSISI KULIT
		</div>
	</div>
	<div class="col-3">
		<img height="120px" width="100%" src="../../images/arrow.png">
	</div>
	<div class="col-2">
		<div style="border: 2px solid black;border-radius: 5px;width: 100%;padding: 20px;height: 130px" class="text-center">
			SEBELUM SPASIEN MENINGGALKAN KAMAR OPERASI
		</div>
	</div>
</div>

<div class="row">
	<div class="col-4">
		<div class="text-center">(Dengan perawat dan anestesi)</div>
		<div style="border:1px solid black;width: 100%;height: 100%;position: relative;">
			<div class="text-center" style="border-bottom:1px solid black;">
				<b>SIGN IN</b>
			</div>
			<div style="padding: 10px;">
					Apakah pasien sudah dikonfirmasi identitas, lokasi, prosedur dan informent consent? <br>
					<table>
						<tr>
							<td valign="top"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
							<td valign="top">Ya</td>
						</tr>
					</table>
					  <br>
					Apakah tempat operasi sudah ditandai? <br>
					<table>
						<tr>
							<td valign="top"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
							<td valign="top">Ya</td>
						</tr>
						<tr>
							<td valign="top"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
							<td valign="top">Tidak diperlukan</td>
						</tr>
					</table>
					<br>
					Apakah mesin anastesi dan pramedikasi sudah diperiksa dan lengkap? <br>
					<table>
						<tr>
							<td valign="top"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
							<td valign="top">Ya</td>
						</tr>
					</table><br>
					Apakah pulse oksi metri sudah terpasang pada pasien dan berfungsi dengan baik? <br>
					<table>
						<tr>
							<td valign="top"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
							<td valign="top">Ya</td>
						</tr>
					</table><br>
					Apakah pasien memiliki riwayat alergi ? <br>
					<table>
						<tr>
							<td valign="top"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
							<td valign="top">Ya</td>
						</tr>
						<tr>
							<td valign="top"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
							<td valign="top">Tidak</td>
						</tr>
					</table><br>
					Apakah pasien memiliki kesulitan jalan nafas ataun resiko aspirasi? <br>
					<table>
						<tr>
							<td valign="top"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
							<td valign="top">Tidak</td>
						</tr>
						<tr>
							<td valign="top"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
							<td valign="top">Ya, dan tersedia perlatan dan bantuan</td>
						</tr>
					</table><br>
					Apakah pasien memiliki risiko hilangnya darah>50 ml (7 ml/kg pada anak-anak)? <br>
					<table>
						<tr>
							<td valign="top"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
							<td valign="top">Tidak</td>
						</tr>
						<tr>
							<td valign="top"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
							<td valign="top">Ya,sudah tersedia dua akses intrafena /sentral cairan</td>
						</tr>
					</table>
					

					<div style="right:0;bottom: 0;position: absolute;">
						Belawan,&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;2020 <br>
					    Anastesi &emsp;&emsp;&emsp;&emsp;<br><br><br><br>

					  (<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>)

					</div>
				</div>
		</div>
					
	</div>
	<div class="col-4">
		<div class="text-center">(dengan dokter bedah, anestesi, dan perawat)</div>
		<div style="border:1px solid black;width: 100%;height: 100%;position: relative;">
			<div class="text-center" style="border-bottom:1px solid black;">
				<b>TIME OUT</b>
			</div>
			<div style="padding: 10px;">
						Konfirmasi semua anggota tim sudah memperkenalkan nama dan peran <br>
						<table>
							<tr>
								<td>Operator</td>
								<td>: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?></td>
							</tr>
							<tr>
								<td>Asisten</td>
								<td>: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?></td>
							</tr>
							<tr>
								<td>Instrument</td>
								<td>: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?></td>
							</tr>
							<tr>
								<td>Sirkuler</td>
								<td>: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?></td>
							</tr>
						</table><br>
						 Konfirmasi nama pasien prosedur dan dimana insisi akan dilakukan 
						<table width="100%">
							<tr>
								<td>Nama pasien</td>
								<td>: <?= $dataPasien["nama"]; ?></td>
							</tr>
							<tr>
								<td>Prosedur</td>
								<td>: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?></td>
							</tr>
							<tr>
								<td>Lokasi insisi</td>
								<td>: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?></td>
							</tr>
						</table><br>

						Apakah antibiotik profilikasis sudah diberikan dalam 60 menit terakhir? <br>
						<table>
							<tr>
								<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
								<td>Ya</td>
							</tr>
							<tr>
								<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
								<td>Tidak</td>
							</tr>
						</table>
						  <br>

						<b>Antisipasi keadaan kritis</b><br>
						Untuk Dokter Bedah  <br>
						<table width="100%">
							<tr>
								<td valign="top"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
								<td>Apakah terdapat keadaan kritis atau langkah yang tidak rutin?</td>
							</tr>
							<tr>
								<td valign="top"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
								<td>Beberapa lama keadaan tersebut akan berlangsung ?</td>
							</tr>
							<tr>
								<td valign="top"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
								<td>Apakah yang di antisipasi terhadap kehilangan darah</td>
							</tr>
						</table>
					  <br>
						Untuk Anastesi <br>
						<table>
							<tr>
								<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
								<td>Apakah ada sesuatu yang pas terhadap pasien</td>
							</tr>
						</table>
						  <br>

						Untuk Tim Perawat <br>
						<table>
							<tr>
								<td valign="top"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
								<td>Apakah sterilitas telah dikonfirmasi (berdasarakanb indicator alat sterilisasi )?</td>
							</tr>
							<tr>
								<td valign="top"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
								<td>Apakah terhadap permasalahan alat atau perhatian lainnya?</td>
							</tr>
						</table>
						  <br>

						Apakah foto telah di tampilkan ? <br>
						<table>
							<tr>
								<td valign="top"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
								<td>Ya</td>
							</tr>
							<tr>
								<td valign="top"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
								<td>Tidak di perlukan</td>
							</tr>
						</table>
						  <br>

						Apakah imaging yang di perlukan sudah terpasang? <br>
						<table>
							<tr>
								<td valign="top"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
								<td>Ya</td>
							</tr>
							<tr>
								<td valign="top"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
								<td>Tidak di perlukan</td>
							</tr>
						</table> <br><br><br><br><br><br><br><br>

					<div style="right:0;bottom: 0;position: absolute;">
						Belawan,&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;2020 <br>
					    Perawat  sirkuaer &emsp;&emsp;&emsp;&emsp;<br><br><br><br>

					  (<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>)

					</div>
				</div>
		</div>
	</div>	

<div class="col-4">
		<div class="text-center">(dengan perawat, dokter bedah, dan anestesi)</div>
		<div style="border:1px solid black;width: 100%;height: 100%;position: relative;">
			<div class="text-center" style="border-bottom:1px solid black;">
				<b>SIGN OUT</b>
			</div>
			<div style="padding: 10px;">
					Perawat memastikan secara verbal : <br>
					<table width="100%">
						<tr>
							<td valign="top"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
							<td>Nama prosedur yang dilakukan</td>
						</tr>
						<tr>
							<td valign="top"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
							<td>Kelengkapan instrument, kassa dan jumlah jarum</td>
						</tr>
						<tr>
							<td valign="top"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
							<td>Pelabelan spesimen (baca label specimen dengan suara lantang , termasuk nama pasien)</td>
						</tr>
						<tr>
							<td valign="top"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
							<td>Apakah ada permasalahan alat-alat yang harus disampaikan?</td>
						</tr>
					</table><br>

 					<b>Untuk Dokter Bedah,Anastesi Perawat<br></b>
 					<table>
 						<tr>
 							<td valign="top"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
 							<td>Apa yang harus diperhatikan dalam recovery manajemen pasien</td>
 						</tr>
 					</table>
 					

 	
					<div style="right:0;bottom: 0;position: absolute;">
						Belawan,&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;2020 <br>
					    Operator &emsp;&emsp;&emsp;&emsp;<br><br><br><br>

					  (<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>)

					</div>
				</div>
		</div>
	</div>	

</div>
<br><br><br>
<br>
<input type="hidden" name="i" value="<?=$i;?>">

<?php if(isset($_REQUEST['cetak'])): ?>
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
	<script>
		<?php if (isset($_REQUEST["pdf"])): ?>
			const pdf = document.getElementById("pdf-area");
			var opt = {
				margin: 0,
				filename:"RM 21.20 <?=$dataPasien["nama"]?>.pdf",
				image: { type: "JPEG", quality: 1 },
				html2canvas: { scale: 1 },
				jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
			};
			html2pdf().from(pdf).set(opt).save();
		<?php endif; ?>
	</script>
</body>

</html>