<?php
	use yii\helpers\Html;
	include '../function/form.php';
	include '../../koneksi/konek.php';
	include 'funct.php';
	$dataPasien = getIndetitasPasien($_REQUEST['idKunj']);
	$i = 1;
	


  if (isset($_REQUEST['id'])) {
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_edukasi_terintegrasi WHERE id = '{$_REQUEST['id']}'"));
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

      $hasil = mysql_query("UPDATE rm_edukasi_terintegrasi 
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
			padding-left: 30px;
		}
	</style>
	<script src="../html2pdf/ppdf.js"></script>
	<script src="../html2pdf/pdf.js"></script>
	<?php 
if (isset($_REQUEST['cetak'])) {
    $print_mode = true;
    echo "<script>window.print();</script>";
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_edukasi_terintegrasi WHERE id = '{$_REQUEST['cetak']}'"));
	$arr_data = explode("|", $data['data']);

  }

  if (isset($_REQUEST['pdf'])) {
    $print_mode = true;
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_edukasi_terintegrasi WHERE id = '{$_REQUEST['pdf']}'"));
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
					
				<div style="float: right">RM 6 / rev01 / PHCM</div>
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
		<center><h2>BUKTI PEMBERIAN INFORMASI & EDUKASI PASIEN DAN KELUARGA TERINTEGRASI</h2></center>
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


<table width="100%" border="1">
	<tr>
		<td colspan="2">INSTRUKSI : BERI TANDA CHECKLIST (√) PADA KOTAK YANG SESUAI DENGAN KEBUTUHAN PASIEN DAN KELUARGA</td>
	</tr>
	<tr>
		<td>Persiapan Edukasi/ Belajar</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
	</tr>
	<tr>
		<td>Keyakinan,Nilai-nilai dan keprcayaan </td>
		<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak Ada&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?></td>
	</tr>
	<tr>
		<td>Bahasa</td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Indonesia
			&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Inggris
			&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Daerah
		</td>
	</tr>
	<tr>
		<td>Kebutuhan Penterjemah</td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya
			&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak
		</td>
	</tr>
	<tr>
		<td>Pendidikan Pasien</td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> SD
			&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> SLTP
			&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> SLTA
			&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> D3
			&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> S1
			&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
		</td>
	</tr>
	<tr>
		<td>Baca Tulis </td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Baik
			&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kurang
		</td>
	</tr>
	<tr>
		<td>Pilihan Tipe Pembelajaran</td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Verbal
			&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tulisan
		</td>
	</tr>
	<tr>
		<td>Hambatan Edukasi</td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak Ada
			&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Penglihatan Terganggu
			&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bahasa
			&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kognitif Terbatas 
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Motivasi Kurang
			&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Budaya/ Agama/spiritual
			&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pendengaran Terganggu
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Emosional
			&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Gangguan bicara
			&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Fisik Lemah
			&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lainnya
		</td>
	</tr>
</table><br>

<table width="100%" border="1">
	<tr class="text-center">
		<th>Tgl Jam Durasi Waktu</th>
		<th>Status Rawat & lokasi</th>
		<th>Informasi / Edukasi Yang Diberikan</th>
		<th>Metode</th>
		<th>Pemberi KIE Nama & TT</th>
		<th>Penerima KIE Nama & TT  Ps/ Keluarga</th>
		<th>Evaluasi/ Verifikasi</th>
	</tr>
	<tr>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<b>DOKTER SPES/ DOKTER UMUM <br></b> 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Penjelasan penyakit <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Penyebab <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Tanda dan gejala <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Hasil Pemeriksaan Penunjang <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Tindakan / penatalaksanaan  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Perkiraan hari rawat <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Penjelasan komplikasi yang  mungkin terjadi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>	
		</td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Diskusi  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Ceramah <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Demonstrasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Praktik langsung <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Leaflet  
		</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Sudah  mengerti <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Mampu mendemontrasikan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re-Edukasi / Re-Demonstrasi   <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re tgl <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>	
		</td>
	</tr>
	<tr>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<b>HAK PASIEN DAN KELUARGA <br></b> 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Penjelasan tentang hak pasien dan keluarga <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Informasi tentang Profesional Pemberi Asuhan ( PPA) <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>	
		</td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Diskusi  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Ceramah <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Demonstrasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Praktik langsung <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Leaflet
		</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Sudah  mengerti <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Mampu mendemontrasikan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re-Edukasi / Re-Demonstrasi   <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re tgl <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>	
		</td>
	</tr>
	<tr>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<b>GELANG IDENTITAS/ GELANG RISIKO <br></b> 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Gelang identitas pasien <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Gelang risiko  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>	
		</td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Diskusi  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Ceramah <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Demonstrasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Praktik langsung <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Leaflet  
		</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Sudah  mengerti <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Mampu mendemontrasikan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re-Edukasi / Re-Demonstrasi   <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re tgl <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>	
		</td>
	</tr>
	<tr>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<b>NUTRISI<br></b> 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Status gizi dan pelayanan  makanan RS<br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Diet selama perawatan<br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
			Diet untuk di rumah 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>	<br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?><br>
		</td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Diskusi  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Ceramah <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Demonstrasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Praktik langsung <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Leaflet  
		</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Sudah  mengerti <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Mampu mendemontrasikan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re-Edukasi / Re-Demonstrasi   <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re tgl <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>	
		</td>
	</tr>
	<tr>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<b>MANAJEMEN NYERI<br></b> 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Farmakologi 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>	<br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
				Non-Farmakologi 
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?><br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?><br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?><br>
		</td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Diskusi  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Ceramah <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Demonstrasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Praktik langsung <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Leaflet  
		</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Sudah  mengerti <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Mampu mendemontrasikan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re-Edukasi / Re-Demonstrasi   <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re tgl <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>	
		</td>
	</tr>
	<tr>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<b>PELAYANAN KEROHANIAN <br></b> 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Bimbingan rohani	<br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
			Konseling rohani<br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?><br>
		</td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Diskusi  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Ceramah <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Demonstrasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Praktik langsung <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Leaflet  
		</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Sudah  mengerti <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Mampu mendemontrasikan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re-Edukasi / Re-Demonstrasi   <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re tgl <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>	
		</td>
	</tr>
	<tr>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<b>FARMASI<br></b> 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Nama obat dan kegunaannya <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
			Aturan pemakaian dan   dosis obat<br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
			Jumlah obat yang diberikan<br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
			Cara penyimpanan obat<br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
			Efek samping obat<br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
			Kontraindikasi obat<br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?> <br>
		</td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Diskusi  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Ceramah <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Demonstrasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Praktik langsung <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Leaflet  
		</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Sudah  mengerti <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Mampu mendemontrasikan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re-Edukasi / Re-Demonstrasi   <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re tgl <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>	
		</td>
	</tr>
	<tr>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<b>REHABILITASI MEDIK<br></b> 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Okupasi terapi<br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
			Fisioterapi<br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
			Terapi wicara <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
			Ortotik prostetik<br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
			Inhalasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
			Chest terapy <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
			Diatermi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
			US  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
			Tens   <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?>	  <br>
		</td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Diskusi  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Ceramah <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Demonstrasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Praktik langsung <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Leaflet  
		</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Sudah  mengerti <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Mampu mendemontrasikan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re-Edukasi / Re-Demonstrasi   <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re tgl <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>	
		</td>
	</tr>
	<tr>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<b>MANAJEMEN RISIKO JATUH<br></b> 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Informasi gelang risiko <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
			Pencegahan jatuh <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
			Tanda di TT <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
			Faktor-faktor risiko jatuh <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?>	  <br>
		</td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Diskusi  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Ceramah <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Demonstrasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Praktik langsung <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Leaflet  
		</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Sudah  mengerti <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Mampu mendemontrasikan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re-Edukasi / Re-Demonstrasi   <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re tgl <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>	
		</td>
	</tr>
	<tr>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<b>KEBERSIHAN TANGAN / CUCI TANGAN <br></b> 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Tujuan dan kapan harus cuci tangan  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
			Cara cuci tangan dengan sabun  dan langkah <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
			Cuci tangan berbasis alkohol<br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?>	  <br>
		</td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Diskusi  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Ceramah <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Demonstrasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Praktik langsung <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Leaflet  
		</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Sudah  mengerti <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Mampu mendemontrasikan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re-Edukasi / Re-Demonstrasi   <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re tgl <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>	
		</td>
	</tr>
	<tr>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<b>PENGGUNAAN ALAT KESEHATAN<br></b> 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Infus pump <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
			Syringe pump <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
			Ventilator <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
			Monitor <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
			Buble CPAP 	  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?>	  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?>	  <br>
		</td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Diskusi  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Ceramah <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Demonstrasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Praktik langsung <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Leaflet  
		</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Sudah  mengerti <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Mampu mendemontrasikan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re-Edukasi / Re-Demonstrasi   <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re tgl <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>	
		</td>
	</tr>
	<tr>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<b>EDUKASI KOLABORASI <br></b> 
			<?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?>
		</td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Diskusi  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Ceramah <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Demonstrasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Praktik langsung <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Leaflet  
		</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Sudah  mengerti <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Mampu mendemontrasikan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re-Edukasi / Re-Demonstrasi   <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re tgl <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>	
		</td>
	</tr>
	<tr>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<div style="color: red">
				Penundaan tindakan/ pelayanan  <br>
				1.	
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
				2.	Alasan 
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
				3.	Alternatif 
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>
			</div>
		</td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Diskusi  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Ceramah <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Demonstrasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Praktik langsung <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Leaflet  
		</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Sudah  mengerti <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Mampu mendemontrasikan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re-Edukasi / Re-Demonstrasi   <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re tgl <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>	
		</td>
	</tr>
	<tr>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?>
		</td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Diskusi  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Ceramah <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Demonstrasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Praktik langsung <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Leaflet  
		</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Sudah  mengerti <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Mampu mendemontrasikan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re-Edukasi / Re-Demonstrasi   <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re tgl <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>	
		</td>
	</tr>
	<tr>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?>
		</td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Diskusi  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Ceramah <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Demonstrasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Praktik langsung <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Leaflet  
		</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Sudah  mengerti <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Mampu mendemontrasikan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re-Edukasi / Re-Demonstrasi   <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re tgl <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>	
		</td>
	</tr>
	<tr>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?>
		</td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Diskusi  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Ceramah <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Demonstrasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Praktik langsung <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Leaflet  
		</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Sudah  mengerti <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Mampu mendemontrasikan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re-Edukasi / Re-Demonstrasi   <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re tgl <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>	
		</td>
	</tr>
	<tr>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?>
		</td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Diskusi  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Ceramah <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Demonstrasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Praktik langsung <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Leaflet  
		</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Sudah  mengerti <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Mampu mendemontrasikan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re-Edukasi / Re-Demonstrasi   <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re tgl <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>	
		</td>
	</tr>
	<tr>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?>
		</td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Diskusi  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Ceramah <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Demonstrasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Praktik langsung <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Leaflet  
		</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Sudah  mengerti <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Mampu mendemontrasikan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re-Edukasi / Re-Demonstrasi   <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re tgl <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>	
		</td>
	</tr>
	<tr>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?>
		</td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Diskusi  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Ceramah <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Demonstrasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Praktik langsung <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Leaflet  
		</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Sudah  mengerti <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Mampu mendemontrasikan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re-Edukasi / Re-Demonstrasi   <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re tgl <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>	
		</td>
	</tr>
	<tr>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?>
		</td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Diskusi  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Ceramah <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Demonstrasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Praktik langsung <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Leaflet  
		</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Sudah  mengerti <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Mampu mendemontrasikan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re-Edukasi / Re-Demonstrasi   <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re tgl <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>	
		</td>
	</tr>
	<tr>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?>
		</td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Diskusi  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Ceramah <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Demonstrasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Praktik langsung <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Leaflet  
		</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Sudah  mengerti <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Mampu mendemontrasikan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re-Edukasi / Re-Demonstrasi   <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re tgl <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>	
		</td>
	</tr>
	<tr>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?>
		</td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Diskusi  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Ceramah <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Demonstrasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Praktik langsung <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Leaflet  
		</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Sudah  mengerti <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Mampu mendemontrasikan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re-Edukasi / Re-Demonstrasi   <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re tgl <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>	
		</td>
	</tr>
	<tr>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?>
		</td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Diskusi  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Ceramah <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Demonstrasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Praktik langsung <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Leaflet  
		</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Sudah  mengerti <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Mampu mendemontrasikan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re-Edukasi / Re-Demonstrasi   <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re tgl <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>	
		</td>
	</tr>
	<tr>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?>
		</td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Diskusi  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Ceramah <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Demonstrasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Praktik langsung <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Leaflet  
		</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Sudah  mengerti <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Mampu mendemontrasikan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re-Edukasi / Re-Demonstrasi   <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re tgl <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>	
		</td>
	</tr>
	<tr>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?>
		</td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Diskusi  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Ceramah <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Demonstrasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Praktik langsung <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Leaflet  
		</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Sudah  mengerti <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Mampu mendemontrasikan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re-Edukasi / Re-Demonstrasi   <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re tgl <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>	
		</td>
	</tr>
	<tr>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?>
		</td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Diskusi  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Ceramah <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Demonstrasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Praktik langsung <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Leaflet  
		</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Sudah  mengerti <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Mampu mendemontrasikan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re-Edukasi / Re-Demonstrasi   <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re tgl <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>	
		</td>
	</tr>
	<tr>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?>
		</td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Diskusi  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Ceramah <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Demonstrasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Praktik langsung <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Leaflet  
		</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Sudah  mengerti <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Mampu mendemontrasikan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re-Edukasi / Re-Demonstrasi   <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re tgl <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>	
		</td>
	</tr>
	<tr>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?>
		</td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Diskusi  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Ceramah <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Demonstrasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Praktik langsung <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Leaflet  
		</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Sudah  mengerti <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Mampu mendemontrasikan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re-Edukasi / Re-Demonstrasi   <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re tgl <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>	
		</td>
	</tr>
	<tr>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<b>PERENCANAAN PULANG<br></b>
			<b> 1. Jadwal control ke dokter : </b> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				Hari/tgl/ jam : 
			<?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?> / 
			<?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				No pendaftaran : 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>

			<b> 2. Dokumen yang dibawa pulang :</b>   <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				Buku catatan medis pasien  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				Surat keterangan sakit <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				Resume medis  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				Hasil pemeriksaan penunjang: lab/ RO/USG , lain-lain 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				Rencana pemeriksaan penunjang lab/ Radiologi  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				Lain-lain 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>
			<b>3. Obat-obatan yang dibawa pulang dan cara penggunaan <br></b>
			a.	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			b.	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			c.	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			d.	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			e.	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>
			<b>4. Penkes untuk dirumah <br></b>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				Perawatan diri ( mandi, BAB,BAK)  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				Perawatan luka  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				Pemberian nutrisi dengan NGT <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				Pemantauan diet <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				Pemantauan pemberian obat  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				Perawatan payudara <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				Perawatan bayi dirumah  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				Latihan fisik lanjutan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				Pendampingan tenaga khusus di rumah  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				Penanganan dan perawatan dirumah : 
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				Rujukan ke komunitas 
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />

				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />

				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />

				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				Jika ada kegawatan hubungi RS No telp 
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>

		</td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Diskusi  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Ceramah <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Demonstrasi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Praktik langsung <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Leaflet  
		</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Sudah  mengerti <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Mampu mendemontrasikan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re-Edukasi / Re-Demonstrasi   <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			Re tgl <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>	
		</td>
	</tr>
</table>
<b>Keterangan pengisian : Status rawat diisi ( ODC/ RI/RJ ) Lokasi : Ruangan / bagian yang memberi penjelasan</b>
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
			let identifier = '<?=$dataPasien["nama"]?>';
			printPDF('RM 6 '+identifier);
		<?php endif; ?>
	</script>
</body>

</html>