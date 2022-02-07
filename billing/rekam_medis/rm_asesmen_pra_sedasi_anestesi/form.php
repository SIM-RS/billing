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
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_asesmen_pra_sedasi_anestesi WHERE id = '{$_REQUEST['cetak']}'"));

	$arr_data = explode("|", $data['data']);

  }

  if (isset($_REQUEST['pdf'])) {
    $print_mode = true;
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_asesmen_pra_sedasi_anestesi WHERE id = '{$_REQUEST['pdf']}'"));

	$arr_data = explode("|", $data['data']);

  }

  if (isset($_REQUEST['id'])) {
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_asesmen_pra_sedasi_anestesi WHERE id = '{$_REQUEST['id']}'"));
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

      $hasil = mysql_query("UPDATE rm_asesmen_pra_sedasi_anestesi 
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
		@media print {
			.foot {page-break-after: always;}
		}
	</style>
  <script src="../html2pdf/ppdf.js"></script>
  <script src="../html2pdf/ppdf.js"></script>
</head>

<body id="pdf-area">
	<div class="bg-white" style="padding:25px">
		<div class="row">
			<div class="col-6 text-center"><br><br>
				<img src="../logors1.png">
			</div>
			<div class="col-6" style="padding:15px">
					
				<div style="float: right">RM 21.10 / PHCM</div>
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
		<center><h2>ASSESMEN PRA SEDASI/ANASTESI</h2></center>
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
		
	<div id="slide1" style="border:1px solid black;padding: 10px;">
		<div class="row">
			<div class="col-12"><b>DIISI : OLEH PASIEN</b></div>
			<div class="col-3">
				Umur <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?><br>
				Golongan Darah	: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:150px", "");$i++;?>
			</div>
			<div class="col-3">
				Jenis Kelamin     &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  L      &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  P	<br>
				Rh : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
			</div>
			<div class="col-3">
				Menikah	         :     &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Y      &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  T	<br>
				Hb : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
			</div>
			<div class="col-3">
				Pekerjaan : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?><br>
				Ht : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-12"><b>KEBIASAAN</b><br></div>
			<div class="col-3">
				Merokok  &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y      &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
				Alkohol:  &nbsp;&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y       &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T
			</div>

			<div class="col-3">
				Sebanyak: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
				Sebanyak: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
			</div>

			<div class="col-3">
				Kopi/teh/soda:	 &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y      &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
				Olahraga rutin:	 &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y      &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T
			</div>

			<div class="col-3">
				Sebanyak : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
				Sebanyak : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
			</div>
			<br>
		</div>
		<br>
		<div class="row">
			<div class="col-12"><b>PENGOBATAN:</b> Sebutkan dosis atau jumlah pil per hari<br></div>
			<div class="col-3">
					Obat resep	: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:160px", "");$i++;?> <br>
					Penggunaan Aspirin rutin		 <br>
					Obat Anti sakit			 <br>
					Injeksi steroid tahun-tahun terakhir  <br>
					Alergi obat			 <br>
					Alergi lateks. &emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y    &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T 
			</div>
			<div class="col-3">
				: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y    &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
					: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y    &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
					: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y    &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
					: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y    &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
					: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y    &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
					Alergi plester&emsp;
					 <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y     &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
			</div>

			<div class="col-6">
					Obat bebas (Vitamin, herbal) : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?> <br>
					Dosis dan frekuensi: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?> <br>
					Dosis dan frekuensi: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?> <br>
					Tanggal dan lokasi injeksi: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?> <br>
					Daftar obat dan tipe reaksi: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?> <br>
					Alergi makanan:    &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y     &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-12"><b>RIWAYAT KELUARGA:</b>Apakah keluarga mendapat permasalahan seperti di bawah ini</div>
			<div class="col-3">
					Perdarahan yang tidak normal	   <br>
					
					Pembekuan darah tidak normal	  <br>
					Permasalahan dalam pembiusan   <br>
					Operasi jantung koroner	   <br>
					Diabetes   <br>
			</div>

			<div class="col-3">
				: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y    &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
				: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y    &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
				: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y    &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
				: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y    &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
				: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y    &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
			</div>

			<div class="col-3">
					Serangan jantung		 <br>
					Hipertensi		 <br>
					Tuberkulosis		 <br>
					Penyakit berat lainnya	 <br>
			</div>
			<div class="col-3">
					: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y   &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
					: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y   &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
					: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y   &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
					: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y   &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
			</div>
			<div class="col-12">
				<u>Jelaskan penyakit keluarga apa bila dijawab “Ya"</u><br>
				<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-12">
				<b>KOMUNIKASI</b>
			</div>
			<div class="col-3">
				Bahasa <br>
				Gangguan Penglihatan/Buta 	    <br>
				Gangguan Pendengaran/Tuli	    <br>
				Gangguan Bicara 		    <br>
			</div>
			<div class="col-9">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
				Indonesia&emsp;Lainnya: 
				<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?> <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y   &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y   &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y   &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
			</div>
		</div>

		<br>
		<div class="row">
			<div class="col-12">
				<b>RIWAYAT  PENYAKIT  PASIEN:</b> Apakah pasien pernah menderita penyakit di bawah ini?
			</div>
			<div class="col-3">
				Perdarahan yang tidak normal	   <br>
				Pembekuan darah tidak normal	   <br>
				Sakit maag			   <br>
				Anemia				   <br>
				Sesak napas 			   <br>
				Asma				   <br>
				Diabetes				   <br>
				Pingsan				   <br>
			</div>
			<div class="col-3">
				: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y   &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T	<br>
				: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y   &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T	<br>
				: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y   &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T	<br>
				: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y   &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T	<br>
				: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y   &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T	<br>
				: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y   &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T	<br>
				: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y   &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T	<br>
				: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y   &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T	<br>
			</div>
			<div class="col-3">
				Serangan jantung/Nyeri dada	 <br>
				Hepatitis/sakit kuning		 <br>
				Hipertensi	   <br>
				Sumbatan jalan nafas saat	 <br>
				Tidur/Mengorok			   <br>
				Penyakit berat lainnya		   
			</div>
			<div class="col-3">
				: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y   &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T	<br>
				: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y   &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T	<br>
				: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y   &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T	<br><br>
				: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y   &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T	<br>
				: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y   &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T	<br>
			</div>
			<div class="col-12">
				<u>Jelaskan penyakit yang dijawab “Ya” :<br></u>
				<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-6">
				Apakah pasien pernah mendapatkan tranfusi darah? <br>
				Apakah pasien pernah diperiksa untuk diagnosis HIV?
			</div>
			<div class="col-6">
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y   
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T  &emsp;   Bila ya, tahun berapa? 
				<?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;", "");$i++;?> <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y   
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T  &emsp;   Bila ya, tahun berapa? 
				<?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;", "");$i++;?>
			</div>
			<div class="col-4">
				Hasil pemeriksaan HIV	<br>
				Apakah pasien memakai <br>
				Lensa kontak        
			</div>
			<div class="col-8">
				: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Positif   
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Negatif  &emsp;<br>
				: <br>
				: 
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y      &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T       &emsp;
				Kacamata: &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y     &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T         &emsp;
				Alat bantu dengar: &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Y     &emsp;
				 <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T            &emsp;
				Gigi palsu: &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y   &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T     
			</div>
			<div class="col-12">
				Riwayat operasi, tahun dan jenis operasi: <?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?><br>
				Jenis anestesi yang digunakan dan sebutkan komplikasi/reaksi yang dialami: <br>
				<ul>
					<li>Anestesia local-komplikasi/reaksi: 
						<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?></li>
					<li>Anestesia regional-komplikasi/reaksi: 
						<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?></li>
					<li>Anestesia umum-komplikasi/reaksi: 
						<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?></li>
				</ul>
			</div>
		</div>
		<br>
		Tanggal terakhir kali periksa kesehatan ke dokter: 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?> &emsp;dimana 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?> <br>
		Untuk penyakit gangguan apa: <br><br>
		<b>KHUSUS PASIEN PEREMPUAN:<br></b>
		<div class="row">
			<div class="col-3">Jumlah kehamilan: <?=input($arr_data[$i-1], "data_{$i}", "number", "form-control", "", "");$i++;?></div>
			<div class="col-3">Jumlah anak: <?=input($arr_data[$i-1], "data_{$i}", "number", "form-control", "", "");$i++;?></div>
			<div class="col-3">Menstruasi terakhir: <?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></div>
			<div class="col-3">Menyusui  &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y    &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T </div>

		</div><br>
<div style="text-align: right">
	Tanggal		: <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?> / Jam 
					<?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?> &emsp;&emsp;<br><br><br><br><br><br><br>
                (<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>) &emsp;&emsp;&emsp;&emsp;&emsp;

</div>

	</div><br>


<div style="border: 1px solid black;padding: 10px">
	<b>DIISI : OLEH DOKTER <br>
		KAJIAN SISTEM
	</b><br>
	<div class="row">
		<div class="col-3">
		Hilangnya gigi <br>	
		Masalah mobilisasi leher <br>
		Leher pendek <br>
		Batuk    <br>
		Sesak nafas <br>
		Baru saja menderita infeksi          <br>
		saluran nafas atas                         <br>
		Periode menstruasi tidak normal <br>
		Stroke     <br>
		</div>

		<div class="col-3">
			: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y    &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
			: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y    &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
			: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y    &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
			: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y    &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
			: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y    &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
			: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y    &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
			<br>
			: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y    &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
			: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y    &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T 
		</div>

		<div class="col-3">
			Sakit dada <br>
			Denyut jantung tidak normal  <br>
			Muntah <br>
			Susah kencing <br>
			Kejang <br>
			Sedang hamil <br>
			Pingsan <br> 
			Obesitas 
		</div>

		<div class="col-3">
			: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y &emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
			: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y &emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
			: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y &emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
			: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y &emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
			: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y &emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
			: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y &emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
			: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y &emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
			: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y &emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
		</div>
		<div class="col-12">
			<u>Keterangan</u><br>
			<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-12"><b>KESADARAN UMUM</b></div>
		<div class="col-3">
			Kesadaran: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>
		</div>

		<div class="col-3">
			Visus: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>
		</div>
		<div class="col-6">&nbsp;</div>
		<div class="col-12">
			Evaluasi Jalan Nafas
		</div>
		<div class="col-3">
			- Bebas <br>
			- Protusi Mandibula  <br>
			- Buka Mulut <br><br>
			- Jarak Mentohyoid       <br><br>
			- Jarak Hyothyroid <br><br>
			- Leher <br>
			- Mallampathy <br>
			- Gigi Palsu <br>
			- Sulit Ventilasi 	
		</div>
		<div class="col-3">
			: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y &emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
			: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y &emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
			: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Normal <br>
			&nbsp; <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak 
			<?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:150px", "");$i++;?><br>
			: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Normal <br>
			&nbsp; <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak 
			<?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:150px", "");$i++;?><br>
			: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Normal <br>
			&nbsp; <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak 
			<?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:150px", "");$i++;?><br>
			: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pendek &emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak <br>
			: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> I &emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> II &emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> III&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> IV<br>
			: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y &emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
			: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Y &emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> T <br>
		</div>
		<div class="col-12">
			<u>Keterangan</u><br>
			<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>
		</div>
	</div><br>

	<div class="row">
		<div class="col-12">
			<b>PEMERIKSAAN  FISIK</b><br>
			Tinggi Badan: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:150px", "");$i++;?> cm 	&emsp;
			Berat Badan <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:150px", "");$i++;?> kg	&emsp;
			TD: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:150px", "");$i++;?>	&emsp;
			Nadi: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:150px", "");$i++;?>	&emsp;
			Suhu: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:150px", "");$i++;?>
		</div>
		<div class="col-3">
			Paru-paru <br>
			Jantung <br>
			Abdomen <br>
			Ekstrimitas	<br>
			Neurologi (bila dapat diperiksa)
		</div>
		<div class="col-9">
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?> <br>
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?> <br>
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?> <br>
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?> <br>
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?> <br>
		</div>
		<div class="col-12">
			<u>Keterangan</u><br>
			<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>
		</div>
	</div>
	<br>

	<div class="row">
		<div class="col-12">
			<b>LABORATORIUM (bila tersedia)</b>
		</div>
		<div class="col-12">
			<table width="100%" border="1px">
				<tr>
					<th class="text-center">PEMERIKSAAN LABORATORIUM</th>
				</tr>
				<tr>
					<td>
						<div class="row">
							<div class="col-12 text-center" style="margin-bottom: 10px"><b>Hematologi</b></div>
							<div class="col-3">
								Hb : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?> <br>
								Ht : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?>
							</div>
							<div class="col-3">
								Leukosit    : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?> <br>
								Trombosit  : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?>
							</div>
							<div class="col-6">
								PTT    : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?><br>
								APTT : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="row">
							<div class="col-12 text-center" style="margin-bottom: 10px"><b>Serum Elektrolit</b></div>
							<div class="col-3">
								Na  : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?>
							</div>
							<div class="col-3">
								K  : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?>
							</div>
							<div class="col-3">
								Ca   : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?>
							</div>
							<div class="col-3">
								Cl  : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="row">
							<div class="col-12 text-center" style="margin-bottom: 10px"><b>Fungsi Hati</b></div>
							<div class="col-3">
								SGOT / SGPT   : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:150px", "");$i++;?> <br>
								Albumin : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:150px", "");$i++;?>
							</div>
							<div class="col-3">
								Bill Direct   : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:150px", "");$i++;?> <br>
								Bill Indirect : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:150px", "");$i++;?>
							</div>
							<div class="col-6">
								<br>
								HbsAg  :  <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:150px", "");$i++;?>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="row">
							<div class="col-12 text-center" style="margin-bottom: 10px"><b>Fungsi Ginjal</b></div>
							<div class="col-6">
								Ur : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:150px", "");$i++;?>
							</div>
							<div class="col-6">
								Cr  :  <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:150px", "");$i++;?>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="row">
							<div class="col-12 text-center" style="margin-bottom: 10px"><b>Endokrin</b></div>
							<div class="col-3">
								GDS : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:150px", "");$i++;?> <br>
								GDP : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:150px", "");$i++;?> <br>
								GD 2 Jam PP  : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:150px", "");$i++;?>
							</div>
							<div class="col-3">
								T3           : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:150px", "");$i++;?> <br>
								T4        : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:150px", "");$i++;?> <br>
								TSH         : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:150px", "");$i++;?>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="row">
							<div class="col-12 text-center" style="margin-bottom: 10px"><b>AGDA</b></div>
							<div class="col-3">
								PH  : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:150px", "");$i++;?> <br>
							</div>
							<div class="col-3">
								PCO2            : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:150px", "");$i++;?> <br>
							</div>
							<div class="col-3">
								PO2             : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:150px", "");$i++;?> <br>
							</div>
							<div class="col-3">
								BE               : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:80px", "");$i++;?> &emsp;
								SaO2 : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:80px", "");$i++;?>
							</div>
						</div>
					</td>
				</tr>
			</table>
			<br>
			<div style="border: 1px solid black;padding: 10px">
				<div class="text-center"><b>PEMERIKSAAN PENUNJANG</b></div>
				<div class="row">
					<div class="col-2">
						EKG	 <br>
						X-RAY	 <br>
						CT-SCAN	 <br>
						LAIN – LAIN 	 <br>
					</div>
					<div class="col-10">
						: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?> <br>
						: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?> <br>
						: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?> <br>
						: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?> <br>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="text-center"><b>KESIMPULAN ASSEMENT PRASEDASI / ANESTESI</b></div>
	<table width="100%">
		<tr>
			<th class="text-center">
				I.		
			</th>	
			<th>
				DIAGNOSIS :
			</th>	
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>
			</td>	
		</tr>
		<tr>
			<th class="text-center">
				II.		
			</th>	
			<td>
				<b>Klasifikasi berdasarkan ASA</b> (* lingkari salah satu) :
			</td>	
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				1.	ASA 1 Pasien normal yang sehat  
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
				2.	ASA 2 Pasien dengan penyakit sistemik ringan  
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
				3.	ASA 3 Pasien dengan penyakit sistemik berat  
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
				4.	ASA 4 Pasien dengan penyakit sistemik berat yang mengancam nyawa 
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			</td>	
		</tr>
		<tr>
			<th class="text-center">
				III.		
			</th>	
			<td>
				<b>Klasifikasi berdasarkan ASA</b> (* lingkari salah satu) :
			</td>	
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>
			</td>	
		</tr>
	</table><br>
	<div><b>RENCANA SEDASI / ANESTESI</b></div>
	<div><b>I.&emsp;Anastesi</b></div>

	<div class="row">
		<div class="col-3">
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Anestesi Umum  : <br><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Regional Anestesi :       <br><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Anestesi Umum + Regional Anestesi
		</div>
		<div class="col-3">
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Intravena 
			&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sungkup Muka <br><br>

			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Spinal Anestesi Blok&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Epidural      <br><br>
		</div>
		<div class="col-3">
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Laringeal Mask Airway	 <br><br>

			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Combinasi Spinal Epidural             <br><br>
		</div>
		<div class="col-3">
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pipa Endotrakeal Tube	 <br><br>

			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Peripheral Nerve Block             <br><br>
		</div>
	</div><br>
	<div><b>II.&emsp;Sedasi</b></div>
	<table width="100%">
		<tr>
			<td class="text-center">
				-TIVA
			</td>
			<td>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
				Propofol		&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ketamin 
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
				Lain-lain
			</td>
		</tr>
		<tr>
			<td class="text-center">
				-INHALASI
			</td>
			<td>
				<div class="row">
					<div class="col-2">
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
						Halothane <br>
						
					</div>
					<div class="col-10">
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Enfurane <br>
						
					</div>
				</div>
			</td>
		</tr>
		<tr>
		 	<td>&nbsp;</td>
			<td >
				<div class="row">
					<div class="col-2">
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
						Isaflurane <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
						Desflurane
					</div>
					<div class="col-10">
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
						Sevoflurane
					</div>
				</div>
			</td>
		</tr>
	</table><br>
	<table width="100%">
		<tr>
			<td width="200px">
				Puasa mulai
			</td>
			<td>
				: Jam <?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?>
			&emsp;Tanggal <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>
			</td>
		</tr>
		<tr>
			<td>
				Rencana tiba di OK
			</td>
			<td>
				: Jam <?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?>
			&emsp;Tanggal <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>
			</td>
		</tr>
		<tr>
			<td>
				Rencana operasii
			</td>
			<td>
				: Jam <?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?>
			&emsp;Tanggal <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>
			</td>
		</tr>
	</table><br>
	<div class="row">
		<div class="col-7"></div>
		<div class="col-5">
			<table>
			<tr>
				<td>
					Diperiksa Oleh
				</td>
				<td>
					:  <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>
				</td>
			</tr>
			<tr>
				<td>
					Tanggal / Jam
				</td>
				<td>
					:  <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?> / 
					<?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?>
				</td>
			</tr>
		</table>
		<br><br><br><br><br><br><br>
		&emsp;&emsp;&emsp;&emsp;
		(Dr.<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>)
		</div>
	</div>
		
	
</div>
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
<div class="foot" style="text-align: right"><img style="width: 350px" class="text-right" src="../../images/alamat.jpg"></div>

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
				filename: "RM 21.10 <?=$dataPasien["nama"]?>.pdf",
				image: { type: "JPEG", quality: 1 },
				html2canvas: { scale: 1 },
				jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
			};
			html2pdf().from(pdf).set(opt).save();
		<?php endif; ?>
	</script>
</body>

</html>