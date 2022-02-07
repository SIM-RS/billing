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
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_poli_tht WHERE id = '{$_REQUEST['cetak']}'"));
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
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_poli_tht WHERE id = '{$_REQUEST['id']}'"));
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

      $hasil = mysql_query("UPDATE rm_poli_tht 
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
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_poli_tht WHERE id = '{$_REQUEST['pdf']}'"));
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
					
				<div style="float: right">RM 2.6 / PHCM</div>
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
		<center><h2>PENGKAJIAN AWAL MEDIS</h2><h2>PENYAKIT THT</h2><h4>(Dilengkapi dalam waktu 2 jam pertama pasien masuk IRJ)</h4></center>
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
			<div class="col-4">
				<b>KELUHAN UTAMA</b>
			</div>
			<div class="col-1">
				:
			</div>
			<div class="col-7">
				<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>
			</div>
		</div><br>
		<div class="row">
			<div class="col-4">
				<b>RIWAYAT PENYAKIT SEKARANG</b>
			</div>
			<div class="col-1">
				:
			</div>
			<div class="col-7">
				<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>
			</div>
		</div><br>
		<div class="row">
			<div class="col-12">
				<b>RIWAYAT PENYAKIT DAHULU DAN RIWAYAT PENGOBATAN :</b>
			</div>
			<div class="col-12">
				<table width="100%" border="1px">
					<tr>
						<th>Riwayat Penyakit Dahulu <br>(tahun)</th>
						<th>Riwayat Pengobatan</th>
					</tr>
					<tr>
						<td><?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?></td>
						<td><?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?></td>
					</tr>
				</table>
			</div>
		</div>

	  </td>
	  </table>


<br><br>

<table border='1px' width='100%' style="font-size:13.5px">
	<tr>
		<td>
			<b>Riwayat Penyakit Keluarga:</b><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Hipertensi&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Kencing Manis&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Jantung&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Asthma&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Lain-lain 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?><br><br>
			<b>Riwayat Pekerjaan, sosial, ekonomi, psikologi dan kebiasan:</b><br>
			<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?><br>
			<h4><u>TANDA-TANDA VITAL</u></h4>
			<div class="row">
				<div class="col-6">
				Keadaan Umum: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Baik&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Sedang&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Lemah&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Jelek
				</div>
				<div class="col-6">
				Gizi: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Baik&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Kurang&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Buruk
				</div>
			</div>

			<div class="row">
				<div class="col-4">
					GCS: E <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:20%");$i++;?> 
					M <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:20%");$i++;?> 
					V <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:20%");$i++;?> <br><br>
					TB: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "");$i++;?> cm
				</div>
				<div class="col-4">
					Tindakan Resusitasi : 
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Ya 
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak 
				</div>
				<div class="col-4">
					BB: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "");$i++;?> Kg
				</div>
			</div>

			<div class="row">
				<div class="col-4">
					Tensi: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "");$i++;?> mmHg, <br><br>
					Respirasi: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "");$i++;?> x/mnt
				</div>
				<div class="col-8">
					Suhu Axila/Rectal: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:15%");$i++;?> &deg;C./ 
					<?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:15%");$i++;?> &deg;C
					Nadi: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "");$i++;?> x/mnt <br><br>
					Saturasi O2: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "");$i++;?> %  
					pada:  <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Suhu Ruangan&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Nasal Canule&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> NRB
				</div>
			</div>

			<div class="row">
				<div class="col-2">
					Riwayat operasi <br> Riwayat Tranfusi
				</div>
				<div class="col-1">
					: <br> :
				</div>
				<div class="col-9">
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak&emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Ya, jenis & kapan <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?><br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak             <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Ya
					&emsp;&emsp;&emsp;&emsp;&emsp;Reaksi Transfusi       : <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak&emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Ya, reaksi yang timbul <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>
				</div>
			</div>

			<div class="row">
				<div class="col-2">
					TELINGA <br> 
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Sekret <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tuli <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tumor <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tinitus <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Sakit <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Korpus Alienum <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Vertigo
				</div>
				<div class="col-1">
					Kanan <br> 
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?>
				</div>
				<div class="col-1">
					Kiri <br> 
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?>
				</div>
				<div class="col-2">
					Hidung <br> 
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Sekret <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tersumbat <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tumor <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Pilek <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Sakit <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Korpus Alienum <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Bersin
				</div>
				<div class="col-1">
					Kanan <br> 
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?>
				</div>
				<div class="col-1">
					Kiri <br> 
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?>
				</div>
				<div class="col-4">
					<div class="text-center">Tenggorok</div>
					<div class="row">
						<div class="col-6">
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Sekret <br>
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tersumbat <br>
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tumor <br>
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Pilek <br>
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Sakit <br>
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Korpus Alienum <br>
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Bersin
						</div>
						<div class="col-1">
							: <br> : <br> : <br> : <br> : <br> : <br> : 
						</div>
						<div class="col-4">
							<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
							<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
							<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
							<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
							<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
							<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
							<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?>
						</div>
					</div>
				</div>
			</div>

			<h4>PEMERIKSAAN FISIK</h4>
			<div class="row">
				<div class="col-1 text-center">
					1.
				</div>
				<div class="col-11">
					Status Internus <br> 
					Keadaan Umum : <?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?>
					Cor : <?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?>
					Pulmo : <?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?>
					hepar / Lien : <?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?>
				</div>
				<div class="col-1 text-center">
					2.
				</div>
				<div class="col-11">
					Status THT
				</div>
			</div>
			<div class="row">
				<div class="col-4">
					<b>TELINGA</b> <br> 
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Daun telinga <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Liang telinga <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Discharge <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Membrana Timpani <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tumor <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Mastoid <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tes pendengaran :
					<div style="margin-left:30px">
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Berbisik <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Weber <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Rinne <br><br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Schwabach <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> BOA <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tympanometri <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Audiometri : <br>
						<div style="margin-left:20px">
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Nada Murni : <br>
						</div>
					</div>
				</div>
				<div class="col-1 text-center">
					Kanan <br> 
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br><br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br><br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br><br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?>
				</div>
				<div class="col-1 text-center">
					Kiri <br> 
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br><br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br><br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br><br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?>
					
				</div>
				<div class="col-2">
					<b>HIDUNG</b> <br> 
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Hidung Luar <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Kavum nasi <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Septum <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Discharge <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Mukosa <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tumor <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Konka <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Sinus <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Koana <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Naso Endoskopi  <br><br>
					<b>TENGGOROK</b><br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Dispenu <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:80%;height:20px");$i++;?><br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Sianosis <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:80%;height:20px");$i++;?><br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Mucosa <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:80%;height:20px");$i++;?>

				</div>
				<div class="col-2 text-center">
					Kanan <br> 
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?>
					<br><br><br>
					<div class="text-left">
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Stridor <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:80%;height:20px");$i++;?><br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Suara <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:80%;height:20px");$i++;?><br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tonsil <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:80%;height:20px");$i++;?>
					</div>
				</div>
				<div class="col-2 text-center">
					Kiri <br> 
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?> <br>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?>
					
				</div>
			</div>
		</td>
	</tr>
</table>
<br>
<br><br>

<table width="100%" border="1px" style="font-size:13.5px">
	<tr>
		<td>
			<div class="row">
				<div class="col-4">
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> BERA <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> OAE <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tes Alat <br>
					Keseimbangan <br>
				</div>
				<div class="col-1">
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?>
				</div>
				<div class="col-1">
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?>
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?>
				</div>
				<div class="col-6">
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Dinding belakang: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?>
					<br><br><b>Laring :</b>
					<div class="row">
						<div class="col-6">
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Epiglotis : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?>
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Aritenoid: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?>
						</div>
						<div class="col-6">
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Plika Vokalis: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?>
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Rimaglotis    : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?>
						</div>
					</div>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Plika Ventrikuloris: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?><br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Endoskopi: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px");$i++;?>
				</div>
			</div>
			Kelenjar limpe leher : <?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?><br>
			<b>PEMERIKSAAN PENUNJANG (Laboratorium,EKG, X-Ray,  Lain-lain)</b><?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?><br>

			<div style="width:100%;border-top:1px solid black;"></div>
			<b>TERAPI/ TINDAKAN :</b><?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?><br>

			<div style="width:100%;border-top:1px solid black;"></div>
			<b>DIAGNOSA KERJA :</b><?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?><br>

			<b>DIAGNOSA BANDING :</b><?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?><br>

			<div style="width:100%;border-top:1px solid black;"></div>
			<b>RENCANA KERJA :</b><?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?><br><br><br><br>
			<u><b>DISPOSIS</b></u><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Boleh pulang Jam Keluar:
			<?=input($arr_data[$i-1], "data_{$i}", "time", "", "height:20px");$i++;?> Wib&emsp;
			Tanggal: <?=input($arr_data[$i-1], "data_{$i}", "date", "", "height:20px");$i++;?><br>
    		&emsp;&nbsp;Kontrol Poliklinik 	
			&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak 
			&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Ya 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?>&emsp;
			Tanggal: <?=input($arr_data[$i-1], "data_{$i}", "date", "", "height:20px");$i++;?><br><br>

			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Dirawat di ruang: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?>&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Kelas: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?>

			<div class="row">
				<div class="col-6"></div>
				<div class="col-6 text-center">
					Medan, <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?><br><br><br><br><br>
<br>					( <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px");$i++;?> )<br>
					Tanda tangan  dan nama DPJP
				</div>
			</div>

		</td>
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
			printPDF('RM 2.6 '+identifier);
		<?php endif; ?>
	</script>
</body>

</html>