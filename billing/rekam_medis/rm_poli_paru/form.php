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
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_poli_paru WHERE id = '{$_REQUEST['cetak']}'"));
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
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_poli_paru WHERE id = '{$_REQUEST['id']}'"));
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

      $hasil = mysql_query("UPDATE rm_poli_paru 
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
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_poli_paru WHERE id = '{$_REQUEST['pdf']}'"));
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
		@media print {
			.foot {page-break-after: always;}
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
					
				<div style="float: right">RM 2.5 / PHCM</div>
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
		<center><h2>PENGKAJIAN AWAL MEDIS</h2><h2>PENYAKIT PARU</h2><h4>(Dilengkapi dalam waktu 2 jam pertama pasien masuk IRJ)</h4></center>
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

<table width="100%" border="1px">
	<tr>
		<td colspan="3">
			<div class="row">
				<div class="col-6 text-center">
					<b>Tanggal : <?=input($arr_data[$i-1], "data_{$i}", "date", "", "");$i++;?> </b>
				</div>
				<div class="col-6 text-center">
					<b>Jam : <?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?> WIB</b>
				</div>
			</div>
		 
		</td>
	</tr>
    <tr>
      <td colspan="2">
		<div class="row">
			<div class="col-4">
				<u><b>ANAMNESA</b></u>
			</div>
			<div class="col-1">
				:
			</div>
			<div class="col-7">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Pasien&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Keluarga&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Teman&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Lainnya : 
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>
			</div>
		</div><br><b>IDENTITAS PASIEN</b>
	  	<div class="row">
			<div class="col-4">
				<b>Agama</b>
			</div>
			<div class="col-1">
				:
			</div>
			<div class="col-7">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Islam&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Protestan&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Katolik&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>>Budha&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Hindu&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>>  Lain-lain
			</div>
		</div>
		<div class="row">
			<div class="col-4">
				<b>Pendidikan</b>
			</div>
			<div class="col-1">
				:
			</div>
			<div class="col-7">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak Ada&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> SD&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> SMP&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> SMA&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> PT
			</div>
		</div>
		<div class="row">
			<div class="col-4">
				<b>Pekerjaan</b>
			</div>
			<div class="col-1">
				:
			</div>
			<div class="col-7">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak bekerja&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> PNS&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> TNI/Polri&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Swasta&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> lain-lain
			</div>
		</div>
		<div class="row">
			<div class="col-4">
				<b>Kewarganegaraan</b>
			</div>
			<div class="col-1">
				:
			</div>
			<div class="col-7">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> WNI&emsp;
      			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> WNA
			</div>
		</div>
		<div class="row">
			<div class="col-4">
				<b>Suku</b>
			</div>
			<div class="col-1">
				:
			</div>
			<div class="col-7">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Melayu&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Batak&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Jawa&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> lain lain : 
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>
			</div>
		</div>
		<div class="row">
			<div class="col-4">
				<b>Pantangan</b>
			</div>
			<div class="col-1">
				:
			</div>
			<div class="col-7">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> ada 
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> tidak ada 
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>
			</div>
		</div>
		<div class="row">
			<div class="col-4">
				<b>Nilai Kepercayaan</b>
			</div>
			<div class="col-1">
				:
			</div>
			<div class="col-7">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> ada 
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> tidak ada 
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>
			</div>
		</div><br>
		<div class="row" style="margin-top:20px">
			<div class="col-4">
				<b>ALERGI TERHADAP</b>
			</div>
			<div class="col-1">
				:
			</div>
			<div class="col-7">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> ada 
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> tidak ada
			</div>
		</div><br>
		<div class="row">
			<div class="col-12">
				<b>KELUHAN UTAMA :</b>
			</div>
			<div class="col-12">
				<div class="row">
					<div class="col-1"></div>
					<div class="col-3">
						a. Batuk :&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Ya&emsp;: <br><br><br>
						b. Batuk Darah  :&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> ya&emsp;: <br><br><br>
						c. Sesak Nafas  :&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> ya&emsp;: <br><br><br><br><br><br><br><br>
						d. Dahak :&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> ya&emsp;: <br><br><br>
						e Nyeri dada  :&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> ya&emsp;:
						
					</div>
					<div class="col-7">
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> sejak berapa lama : <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> < 3mg / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> >  3mg <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> intensitas : <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Ringan / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Berat <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Frekuersi : <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Jarang / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Sering <br>

						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> sejak berapa lama : <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> > 3mg/ <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> >  3mg <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> intensitas : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;font-size:13px;width:20%");$i++;?> <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> volume : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;font-size:13px;width:20%");$i++;?> <br>

						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> sejak berapa lama : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;font-size:13px;width:20%");$i++;?> <br>
						Sifat sesak : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;font-size:13px;width:20%");$i++;?> <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> intensitas : <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Ringan / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Berat <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Frekuersi : <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Jarang / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Sering <br>
    					&emsp;Mengi : <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Ya / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak <br>
  						&emsp;Bertambah dimalam hari    : <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Ya / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak <br>
						Faktor pencetus : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;font-size:13px;width:20%");$i++;?><br><br>

						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> sejak berapa lama: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> > 3mg/ <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> > 3mg <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> intensitas : <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Ringan / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Berat <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Frekuersi : <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Jarang / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Sering
						<br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> sejak berapa lama: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> > 3mg/ > <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> 3mg <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> intensitas : <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Ringan / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Berat <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Frekuersi : <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Jarang / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Sering


					</div>
				</div>
			</div>
		</div><br>
		<div class="row">
			<div class="col-12">
				KELUHAN TAMBAHAN :
			</div>
			<div class="col-12">
				<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>
			</div>
		</div>
	  </td>
	  </table>


<br><br>

<table border='1px' width='100%'>
	<tr>
		<td><br>
			<h4>RIWAYAT PENYAKIT DAHULU DAN RIWAYAT PENGOBATAN :</h4>
			<table border="1px" width="100%">
				<tr>
					<td>
						Riwayat Pengobatan: <br>
						Riwayat penyakit <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Hipertensi&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Diabetes&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Jantung&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Stroke&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Dialysis&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Asma&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Kejang&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Liver <br>

						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Cancer&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> TBC&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Glaukoma&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> STD&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Perdarahan&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Lainnya <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;font-size:13px;width:20%");$i++;?>. <br>

						Riwayat operasi : <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Ya, jenis & kapan 
						<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;font-size:13px;width:20%");$i++;?> <br><br>
						<div class="row">
							<div class="col-5">
								Riwayat Tranfusi : <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Ya
							</div>
							<div class="col-7">
								Reaksi Transfusi : <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>>Ya, reaksi yang timbul <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;font-size:13px;width:20%");$i++;?><br><br>
							</div>
						</div>
					</td>
				</tr>
			</table><br><br>
			<h4>Riwayat Penyakit Keluarga:</h4>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Hipertensi&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Diabetes militus&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Jantung&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Asma&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Lain-lain <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?><br><br>
						Anamnesa Keluarga: 
						<div class="row">
							<div class="col-2"></div>
							<div class="col-5">
								a. Penderita TB Paru : Tidak / Ya <br>
								b. Riwayat Asma : Tidak/ Ya
							</div>
							<div class="col-5">
								Siapa: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?><br>
						        Siapa: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?>
							</div>
						</div><br>
						<h4>Riwayat Pekerjaan, sosial, ekonomi, psikologi:</h4>
						<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>
						Kebiasaan: 
						<div class="row">
							<div class="col-2"></div>
							<div class="col-5">
								a.	Merokok : Lama <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>, <br>
								b.	Obat-obatan : Jenis <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?><br>
								c.	Alkohol : Jenis <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>
							</div>
							<div class="col-5">
								Banyak <?=input($arr_data[$i-1], "data_{$i}", "number", "", "");$i++;?> btg/hari<br>
								Lama <?=input($arr_data[$i-1], "data_{$i}", "number", "", "");$i++;?> th<br>
								Lama <?=input($arr_data[$i-1], "data_{$i}", "number", "", "");$i++;?> th
							</div>
						</div><br>
						<h4><u>TANDA-TANDA VITAL</u></h4>
						Keadaan Umum :   <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Baik&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Sedang&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Lemah&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Jelek&emsp;&emsp;&emsp;&emsp;&emsp;Gizi: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Baik&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Kurang&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Buruk<br>

						Tindakan Resusitasi : <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Ya&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak&emsp;&emsp;&emsp;&emsp;&emsp;
						BB: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "");$i++;?> Kg&emsp;&emsp;TB: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "");$i++;?> cm<br>

						Tensi: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "");$i++;?> mmHg,&emsp;&emsp;&emsp;&emsp;&emsp;
						Suhu Axila/Rectal: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "");$i++;?> &deg;C./ <?=input($arr_data[$i-1], "data_{$i}", "number", "", "");$i++;?> &deg;C<br>

						Nadi: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "");$i++;?> x/mnt&emsp;Respirasi: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "");$i++;?> x/mnt&emsp;Saturasi O2: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "");$i++;?> %  pada:  <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Suhu Ruangan  <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Nasal Canule  <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Lainnya <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?><br>

						Dispnoe                         :   <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Ya / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak<br>
						Orthopnoe                      : <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Ya / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak<br>
						Edema                            : <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Ya / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak<br><br>

						<h4><u>PEMERIKSAAN FISIK</u></h4>
						Kepala: Deformitas <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Ya / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak<br>

						Mata: &emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Anemis <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:14%");$i++;?> &emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> 
						Ikterus <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:14%");$i++;?> &emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> 
						Reflleks Pupil: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:14%");$i++;?> &emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> 
						Edema Palpebrae <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:14%");$i++;?> <br>

						Leher: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> TJP <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:14%");$i++;?>&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Pembesaran Kelenjar <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:14%");$i++;?>&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Kaku Kuduk. <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> + / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> -
						<br><br>
						<h4>Toraks:</h4>
						<div style="margin-left:50px">
							<b>-</b>&emsp;Inspeksi : <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Simetris / Asimetris <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:14%");$i++;?><br>
							<b>-</b>&emsp;Palpasi <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?><br>
							<b>-</b>&emsp;Perkusi <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>
						</div>

		</td>
	</tr>
</table>
<br>
<br><br>

<table width="100%" border="1px">
	<tr>
		<td>
			<div class="row">
				<div class="col-1"></div>
				<div class="col-2">
					<b>-</b> Auskultasi :<br><br><br><br>
					Gambar Paru <br>
					<b>-</b> Cor:
				</div>
				<div class="col-9">
					Suara napas : <br>
					Suara tambahan : <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> 
					Ronchi <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?>&emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> 
					Wheezing <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?><br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> 
					Lain-lain <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?><br><br><br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> 
						S1,S2 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?> 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> reguler / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Ireguler&emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> 
						Murmur <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?>  <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> 
						Lain-lain <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?>
				</div>
			</div>
   
			<div class="row">
				<div class="col-3">
					Abdomen :
				</div>
				<div class="col-9">
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Distensi : <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> + / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> -&emsp;&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Meteorismus : <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> + / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> -&emsp;&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Peristaltic : <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Normal&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Meningkat <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Menurun&emsp;&emsp;  <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Ascites : <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> + / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> -
				</div>
				    
			</div>

			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Nyeri tekan : <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> + / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> - &emsp;&emsp;Lokasi : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?>

			<div style="margin-left:50px">
				-&emsp;&emsp;Hepar : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:60%");$i++;?> <br>
              &emsp;&emsp;&nbsp;&nbsp;Lien : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:60%");$i++;?>

			</div>
			Lain-lain: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:60%");$i++;?> <br>
			Ekstremitas: 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Hangat / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Dingin&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Oedema <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Lain-lain: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> <br><br>
		</td>
	</tr>
	<tr>
		<td>
			Riwayat operasi : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak             
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Ya, jenis & kapan 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:60%");$i++;?> <br>
			Riwayat Tranfusi : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak             
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Ya&emsp;
			Reaksi Transfusi : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Ya, reaksi yang timbul 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:40%");$i++;?>
		</td>
	</tr>
	<tr>
		<td>
			<div class="row">
				<div class="col-9">
					<b>PEMERIKSAAN PENUNJANG</b> (Laboratorium, EKG, X-Ray, Lain-lain) 
					<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>
				</div>
				<div class="col-3 text-center">
					<img src="../../images/paru.png" alt="" srcset="">
				</div>
			</div>


		</td>
	</tr>
	<tr>
		<td>
			DIAGNOSA UTAMA : <br> <?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>
			DIAGNOSA DEFERENSIAL : <br> <?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>
			KOMPLIKASI <br> <?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>
		</td>
	</tr>
</table>

<br><br>

<table width="100%" border="1px">
	<tr>
		<td colspan='2'>
			<b>TERAPI / TINDAKAN</b><br>
			Non Farmakoterapi : <br> <?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>
			Farmakoterapi : <br> <?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>
			Ke gawat daruratan : <br> <?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>
		</td>
	</tr>
	<tr>
		<td rowspan="2" width="50%">
			
				<b>RENCANA KERJA</b><br><?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?><br><br><br>
				<div><u>TINDAKAN</u></div>

				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>>	Bronkoskopi diagnostik/terapeutik<br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>>	Proef  Punctie pleura<br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>>	Torakosentesis/Aspirasi pleura<br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>>	USG toraks<br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>>	Biopsi  jarum halus<br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>>	TTNA Blind<br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>>	Mantoux test
			</td>

			<td width="50%" class="text-left">
					<b><u>DISPOSISI</u></b><br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Boleh pulang&emsp;Jam Keluar: <?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?> Wib <br> 
					Tanggal: <?=input($arr_data[$i-1], "data_{$i}", "date", "", "");$i++;?> <br>
					&emsp;Kontrol Poliklinik 
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak 
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Ya 
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:25%");$i++;?> 
					Tanggal: <?=input($arr_data[$i-1], "data_{$i}", "date", "", "");$i++;?> <br>

					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Dirawat di ruang: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?><br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Kelas: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>
		</td>
		<tr>
			<td>
				<div class="text-left"><br>
					MEDAN, <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?><br><br><br><br>
					( <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> ) <br>
					Tanda tangan dan Nama DPJP 
				</div>
			</td>
		</tr>
	</tr>
</table>

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
<br><br>

	<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery-1.9.1.js"></script>
	<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery.form.js"></script>
    <script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>
    <script type="text/javascript" src="../../theme/js/ajax.js"></script>
	<script src="../../theme/bs/bootstrap.min.js"></script>
	<script>
		<?php if (isset($_REQUEST["pdf"])): ?>
			let identifier = '<?=$dataPasien["nama"]?>';
			printPDF('RM 2.5 '+identifier);
		<?php endif; ?>
	</script>
</body>

</html>