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
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_serah_terima_pasien_pre_operasi WHERE id = '{$_REQUEST['cetak']}'"));
    $BB = $data['BB']; $TB = $data['TB']; $IMT = $data['IMT']; $TL = $data['tinggi_lutut']; $LLA = $data['LLA'];

	$arr_data = [];
  $all = $data['data'];
	$str = "";

	for ($r=0; $r < strlen($all); $r++) { 
		if ($all[$r] != "|") {
			$str .= $all[$r];
		} else {
			array_push($arr_data, $str);
			$str = "";
		}
	}

  }

  if (isset($_REQUEST['pdf'])) {
    $print_mode = true;
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_serah_terima_pasien_pre_operasi WHERE id = '{$_REQUEST['pdf']}'"));
    $BB = $data['BB']; $TB = $data['TB']; $IMT = $data['IMT']; $TL = $data['tinggi_lutut']; $LLA = $data['LLA'];

	$arr_data = [];
  $all = $data['data'];
	$str = "";

	for ($r=0; $r < strlen($all); $r++) { 
		if ($all[$r] != "|") {
			$str .= $all[$r];
		} else {
			array_push($arr_data, $str);
			$str = "";
		}
	}

  }

  if (isset($_REQUEST['id'])) {
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_serah_terima_pasien_pre_operasi WHERE id = '{$_REQUEST['id']}'"));
    $arr_data = [];
    $all = $data['data'];
	  $str = "";
    
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

      $hasil = mysql_query("UPDATE rm_serah_terima_pasien_pre_operasi 
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
	</style>
  <script src="../html2pdf/ppdf.js"></script>
  <script src="../html2pdf/ppdf.js"></script>
</head>

<body id="pdf-area">


	<div class="bg-white" style="padding: 10px">
		<div class="row">

				<div class="col-6 text-center"><br><br><br><br>
				<img src="../logors1.png">
			</div>
			<div class="col-6" style="padding:40px">
				<div style="float: right">RM 21.3 / PHCM</div>
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
		<h4 class="text-center">CHECK LIST SERAH TERIMA PASIEN PRE OPERASI</h4><br>


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

		<b>I. PREOPERASI</b><br>
		Hari, tanggal : <?=input($arr_data[$i-1], "data_{$i}", "date", "", "");$i++;?>&emsp;
		Jam datang : <?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?><br>

		<b>RUANG PENERIMAAN PASIEN</b><br>
		<b>A. Informasi Umum</b><br>
		<div class="row">
			<div class="col-6">
				<div class="row">
					<div class="col-3">Asal Pasien</div>
					<div class="col-9"><?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?></div>
					<div class="col-3">Penjamin</div>
					<div class="col-9"><?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?></div>
					<div class="col-3">Bag / Sub Bag</div>
					<div class="col-9"><?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?></div>
				</div>
			</div>
			<div class="col-6">
				<div class="row">
					<div class="col-12">Ruang / Poli <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>	&emsp;Kelas : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>
					</div>
					<div class="col-4">
						1. <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Umum <br>
						2. <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> BPJS <br>

					</div>
					<div class="col-8">
						3. <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> PT / Perusahaan <br>
						4. <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-Lain <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>
					</div>
					<div class="col-12">
						1. <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bedah obstetry gynecology <br>
						2. <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />	Bedah
					</div>
				</div>
			</div>
		</div>

		Diagnosa Medis : <?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?> <br>
		Rencana operasi : <?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?> <br>
		Tindakan terlaksana : <?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?> <br>

		<b>Kelengkapan Administrasi</b><br>
		<table width="100%" border="1px">
			<tr class="text-center">
				<th rowspan="2">HASIL PEMERIKSAAN</th>
				<th colspan="2">PETUGAS</th>
				<th rowspan="2">Keterangan</th>
			</tr>
			<tr class="text-center">
				<th>PERAWAT RUANGAN</th>
				<th>PERAWAT KAMAR BEDAH</th>
			</tr>
			<tr>
				<td>Buku Status</td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
			</tr>
			<tr>
				<td>KIM</td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
			</tr>
			<tr>
				<td><i>Informed concent</i></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
			</tr>
			<tr>
				<td> Surat izin pembiusan (ditandatangani pasien/keluarga)</td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
			</tr>
			<tr>
				<td>Surat izin tindakan pembedahan (ditandatangani pasien/keluarga)</td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
			</tr>
			<tr>
				<td>Marking site</td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
			</tr>
			<tr>
				<td>X-Ray Photo </td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td>Jumlah <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px");$i++;?> Lbr</td>
			</tr>
			<tr>
				<td>Echo</td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td>Jumlah <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px");$i++;?> Lbr</td>
			</tr>
			<tr>
				<td>ECG</td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td>Jumlah <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px");$i++;?> Lbr</td>
			</tr>
			<tr>
				<td>USG</td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td>Jumlah <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px");$i++;?> Lbr</td>
			</tr>
			<tr>
				<td>CT SCAN</td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td>Jumlah <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px");$i++;?> Lbr</td>
			</tr>
			<tr class="text-center"><td></td><td></td><td></td><th height="50px">Keterangan</th></tr>
			<tr>
				<td>Gigi palsu</td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
			</tr>
			<tr>
				<td>Lensa kontak</td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
			</tr>
			<tr>
				<td>NGT</td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
			</tr>
			<tr>
				<td>Kateter urin</td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
			</tr>

			<tr>
				<td>Infus</td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td>Area : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?></td>
			</tr>
			<tr>
				<td>Drain / selang irigasi</td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td>Area : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?></td>
			</tr>
			<tr>
				<td>Traksi</td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td>Area : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?></td>
			</tr>
			<tr>
				<td>Protesa lain</td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td>Area : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?></td>
			</tr>
			<tr class="text-center"><td></td><td></td><td></td><th height="50px">Keterangan</th></tr>
			<tr>
				<td>Pencukuran</td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
			</tr>
			<tr>
				<td>Lavement</td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
			</tr>
			<tr>
				<td>Puasa</td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td>Mulai Pukul <?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?> WIB</td>
			</tr>
			<tr>
				<td>Cross match /Gol. Darah </td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> A / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> B / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> AB / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> O</td>
			</tr>
			<tr>
				<td>Jenis transfusi</td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> LP / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> WB / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> PRC / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> WRC <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> LP / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> CRYO / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TROMBOSIT</td>
			</tr>
			<tr>
				<td>Jumlah</td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "number", "", "");$i++;?> cc</td>
			</tr>
		</table>

		Keterangan : Bila ada atau terpasang diberi tanda centang : √, Bila tidak ada atau tidak terpasang beri tanda - <br>
		Riwayat alergi : <?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?> <br>
		<b>C. Penyebab Penundaan Operasi</b><br>
		<div class="row">
			<div class="col-6">
				1. <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Keadaan umum pasien / alasan medis <br>
				2. <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Alat penunjang operasi di IBS <br>
				3. <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pemeriksaan penunjang / konsul bagian lain <br>
				4. <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak tersedianya ruangan Postops (ICU, NICU, PICU.........) <br>
				5. <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Dokter pembedah
			</div>
			<div class="col-6">
				6. <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Dokter anestesi <br>
				7. <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak cukup waktu <br>
				8. <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Persiapan implant/ BMHP dari Depo Farmasi <br>
				9. <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Persiapan <br>
				10. <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Lain-lain <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> <br>
			</div>
		</div>
<b>D. Serah terima barang pribadi pasien, diberikan kepada :</b><br>
<div class="row">
	<div class="col-6">
		<div class="row">
			<div class="col-6">
				Nama lengkap <br>
				Jenis barang / jumlah barang
			</div>
			<div class="col-6">
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?> <br>
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?>
			</div>
		</div>
	</div>
	<div class="col-6">Hubungan dg pasien : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?></div>
</div>
<br><br>
<div class="row">
	<div class="col-3"></div>
	<div class="col-3">
		<b>Petugas yang menyerahkan</b><br><br><br><br><br><br>
		(<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?>)
	</div>
	<div class="col-3">
		<b>Petugas yang menerima</b><br><br><br><br><br><br>
		(<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?>)
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
<div style="text-align: right"><img style="width: 350px" class="text-right" src="../../images/alamat.jpg"></div>

	<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery-1.9.1.js"></script>
	<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery.form.js"></script>
    <script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>
    <script type="text/javascript" src="../../theme/js/ajax.js"></script>
	<script src="../../theme/bs/bootstrap.min.js"></script>
	<script>
		<?php if(isset($_REQUEST["pdf"])): ?>
			const pdf = document.getElementById("pdf-area");
			var opt = {
				margin: 0,
				filename: "RM 21.3 <?=$dataPasien["nama"]?>.pdf",
				image: { type: "JPEG", quality: 1 },
				html2canvas: { scale: 1 },
				jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
			};
			html2pdf().from(pdf).set(opt).save();
		<?php endif; ?>
	</script>
</body>

</html>