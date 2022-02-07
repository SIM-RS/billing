<?php
	use yii\helpers\Html;
	include '../function/form.php';
	include '../../koneksi/konek.php';
	include 'funct.php';
	$dataPasien = getIndetitasPasien($_REQUEST['idKunj']);
	$i = 1;


  if (isset($_REQUEST['id'])) {
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_21_13_laporan_anestesi WHERE id = '{$_REQUEST['id']}'"));
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

      $hasil = mysql_query("UPDATE rm_21_13_laporan_anestesi 
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
		.checkGraph {
			display: none;
		}
		.graphC {
			display: none;
			background-color: black;
			border-radius: 50px;
			width: 10px;
			height: 10px;
		}
		@media print {
			#fv {
				font-size: 13px;
			}
		}
	</style>
  <script src="../html2pdf/ppdf.js"></script>
	<?php 
if (isset($_REQUEST['cetak'])) {
    $print_mode = true;
    echo "<script>window.print();</script>";
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_21_13_laporan_anestesi WHERE id = '{$_REQUEST['cetak']}'"));
	$arr_data = explode("|", $data['data']);

  }

  if (isset($_REQUEST['pdf'])) {
    $print_mode = true;
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_21_13_laporan_anestesi WHERE id = '{$_REQUEST['pdf']}'"));
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
					
				<div style="float: right">RM 21.13 / PHCM</div>
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
		<center><h2>LAPORAN ANESTESI</h2></center>
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
		<td width="60%">
			Tanggal operasi : <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?><br>
			Diagnosa : <?=area($arr_data[$i-1], "data_{$i}", "", "", "");$i++;?><br>
			Jenis Pembedahan : <?=area($arr_data[$i-1], "data_{$i}", "", "", "");$i++;?>
		</td>
		<td>
			Dokter Bedah : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?><br>
			Asisten Bedah : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?><br><br>
			Dokter Anestesi : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?><br>
			Asisten Anestesi : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?><br>
		</td>
	</tr>
</table><br>

<b>A. RENCANA ANESTESI</b><br>

<table width="100%" border="1">
	<tr>
		<td>
			<b>PREMEDIKASI :</b> <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Oral / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> IM / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> IV / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Rektal / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak diberikan <br>
			Obat : <?=area($arr_data[$i-1], "data_{$i}", "", "", "");$i++;?>
		</td>
	</tr>
	<tr>
		<td>
			<b>JENIS ANESTESI :</b> <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> umum / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> regional / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> combined / <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>
		</td>
	</tr>
	<tr>
		<td>
			Perhitungan cairan : <?=area($arr_data[$i-1], "data_{$i}", "", "", "");$i++;?> <br>
			EBV:  <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> &emsp; EBL: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?><br>
			Persiapan Darah : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>
		</td>
	</tr>
	<tr>
		<td>
			<b>MONITORING</b><br>
			<table width="100%">
				<tr>
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> EKG Lead</td>
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> SpO2</td>
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> ETCO2</td>
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> NIBP &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Artery line</td>
				</tr>
				<tr>
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Temp</td>
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Stetoskop</td>
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> CVP</td>
					<td>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> PA catheter &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Urine catheter &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> NGT No. <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:80px", "");$i++;?> &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:80px", "");$i++;?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<b>MANAJEMEN POSTOPERATIF</b><br>
			Analgetika: Obat <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>
			&emsp;
			Dosis <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Oral / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> IM / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> IV / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Rektal / <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?><br>
			Lain-lain : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:70%", "");$i++;?>
		</td>
	</tr>
</table><br>
<b>B. EVALUASI PRE INDUKSI</b>&emsp;(Pukul : <?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?>)<br>
<table width="100%" border="1">
	<tr>
		<td>
			Kesadaran: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> &emsp; GCS : <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> E   <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> M   <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> V  <br><br>
			Respirasi: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> spontan / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> assisted / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> controlled, RR : <?=input($arr_data[$i-1], "data_{$i}", "number", "", "", "");$i++;?> x/mnt, <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Udara bebas / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> kanul nasal / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> simple mask / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> rebreathing mask / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> non-rebreathing mask / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> terintubasi, O2 <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> L/mnt, SpO2 : <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> % <br><br>
			Tekanan Darah: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> mmHg&emsp;Nadi: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> x/mnt, <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> reg / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> ireg / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> adekuat / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> inadekuat <br>
			Support : <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Tidak ada&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada <?=area($arr_data[$i-1], "data_{$i}", "", "", "");$i++;?><br>
			Status Fisik ASA: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> I / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> II / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> III / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> IV / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> V / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> E
		</td>
	</tr>
	<tr>
		<td><?=area($arr_data[$i-1], "data_{$i}", "", "", "");$i++;?></td>
	</tr>
</table><br>
<b>C. PREMEDIKASI<br></b>
<table width="100%" border="1">
	<tr>
		<td>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Oral / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> IM / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> IV / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Rektal / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak diberikan <br>
			Jam : <?=input($arr_data[$i-1], "data_{$i}", "time", "", "width:100px", "");$i++;?> &emsp;Obat : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:300px", "");$i++;?> &emsp;Dosis:<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:300px", "");$i++;?> <br>
			Hasil : Ramsay sedation score  <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> I / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> II / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> III / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> IV 
		</td>
	</tr>
</table><br>
<b>D. TEKNIK ANESTESI <br></b>
<table width="100%" border="1">
	<tr>
		<td colspan="2">
			Perubahan Teknik:  <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Tidak ada&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada <br>
			Jika ada, alasan : <?=area($arr_data[$i-1], "data_{$i}", "", "", "");$i++;?><br>
		</td>
	</tr>
	<tr>
		<td width="50%" valign="top">
			<b>ANESTESI UMUM<br></b>
			Induksi : <?=area($arr_data[$i-1], "data_{$i}", "", "", "");$i++;?><br><br>
			Teknik: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> semi open / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> semi closed / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> closed <br><br>
			Pengaturan nafas: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> spontan / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> assisted / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> controlled <br><br>
			Teknik khusus: <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Hipotermi / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> hipotensi / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> bypass / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> ventilasi satu paru / <?=area($arr_data[$i-1], "data_{$i}", "", "", "");$i++;?>

		</td>
		<td width="50%" valign="top">
			<b>BLOKADE REGIONAL<br></b>
			Teknik : <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> caudal / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Saddle’s block / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> intravenous regional / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> epidural / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> blokade saraf tepi / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> spinal / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> topikal / <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:300px", "");$i++;?> <br><br>
			Lokasi tusukan: <?=area($arr_data[$i-1], "data_{$i}", "", "", "");$i++;?><br><br>
			Analgesi setinggi segmen: <?=area($arr_data[$i-1], "data_{$i}", "", "", "");$i++;?><br><br>
			Anestesi lokal: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100px", "");$i++;?> &emsp;
			konsentrasi: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:80px", "");$i++;?> %  &emsp;
			jumlah: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> mL <br><br>
			Obat tambahan: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			dosis: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<b>MONITORING<br></b>
			<table width="100%">
				<tr>
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> EKG Lead</td>
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> SpO2</td>
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> ETCO2</td>
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> NIBP &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Artery line</td>
				</tr>
				<tr>
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Temp</td>
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Stetoskop</td>
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> CVP</td>
					<td>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> PA catheter &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Urine catheter &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> NGT No. <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:80px", "");$i++;?> &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:80px", "");$i++;?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table><br>

<b>E. KEADAAN SELAMA OPERASI<br></b>
<table width="100%" border="1">
	<tr>
		<td valign="top" width="50%">
			Posisi penderita: <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> supine / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> prone / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> litotomi / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> semi sitting / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Fowler / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> lateral dekubitus (R / L)/ <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> trendelenburg / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> knee – chest / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> jack – knife / <?=area($arr_data[$i-1], "data_{$i}", "", "", "");$i++;?>
		</td>
		<td valign="top" width="50%">
			Ventilasi: <br>
			Airway : <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> face mask / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> LMA / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> single lumen ETT / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> single lumen spiral ETT / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> double lumen ETT (R / L).Ukuran : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:80px", "");$i++;?>  <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Balon / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tanpa balon <br><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Udara bebas / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> kanul nasal / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> simple mask / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> rebreathing mask / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> non-rebreathing mask,  O2 <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:80px", "");$i++;?> L/mnt
		</td>
	</tr>
</table><br>
<b>F. PASKABEDAH <br></b>
<table width="100%" border="1">
	<tr>
		<td>Status awal pasien sebelum transfer</td>
		<td colspan="3">
			Kesadaran: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:80px", "");$i++;?> 
			&emsp; TD: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:80px", "");$i++;?> mmHg  
			&emsp; HR: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:80px", "");$i++;?> x/m  
			&emsp; RR: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:80px", "");$i++;?> x/m  
			&emsp; SpO2: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:80px", "");$i++;?> %
		</td>
	</tr>
	<tr>
		<td>Status awal pasien setelah transfer</td>
		<td colspan="3">
			Kesadaran: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:80px", "");$i++;?> 
			&emsp; TD: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:80px", "");$i++;?> mmHg  
			&emsp; HR: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:80px", "");$i++;?> x/m  
			&emsp; RR: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:80px", "");$i++;?> x/m  
			&emsp; SpO2: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:80px", "");$i++;?> %
		</td>
	</tr>
	<tr>
		<td colspan="3">
			Catatan tambahan: <br>
			<?=area($arr_data[$i-1], "data_{$i}", "", "", "");$i++;?>
		</td>
	</tr>
	<tr>
		<th colspan="3" class="text-center">
			SERAH TERIMA PASIEN DI RUANG PULIH
		</th>
	</tr>
	<tr>
		<th rowspan="2" width="50%">
			S : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:90%", "");$i++;?><br>
			B : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:90%", "");$i++;?><br><br>

			A : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:90%", "");$i++;?><br><br>
			R : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:90%", "");$i++;?><br><br>
		</th>
		<td colspan="2">
			Waktu Serah Terima : <br>
			Tanggal :<?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>&emsp;Jam : <?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?>
		</td>
	</tr>
	<tr>
		<td class="text-center">
			Petugas yang Menyerahkan <br><br><br><br><br><br>
		</td>
		<td class="text-center">
			Petugas yang Menerima <br><br><br><br><br><br>
		</td>
	</tr>
</table><br>

<div class="text-center"><b>MONITORING PASKABEDAH</b></div>

<table width="100%" border="1">
	<tr>
		<td width="120px">Pukul</td>
		<?php for($qa=0;$qa<12;$qa++):  ?>
			<td width="81px"><?=input($arr_data[$i-1], "data_{$i}", "time", "", "width:70px", "");$i++;?></td>
		<?php endfor;  ?>
		<td width=""><?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%", "");$i++;?></td>
	</tr>
</table>
<table border="1" width="100%">
	<tr>
		<td class="text-center" width="40px">T</td>
		<td class="text-center" width="40px">RR</td>
		<td class="text-center" width="40px">N</td>
		<td class="text-center" width="40px">TD</td>
		<?php for($qa=0;$qa<36;$qa++):  ?>
			<td width="27px" class="graph"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> class="checkGraph" /><div class="graphC">&nbsp;</div></td>
		<?php endfor;  ?>
		<td><?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%", "");$i++;?></td>
	</tr>
</table>
<?php $t=42;$rr=55;$n=180;$td=240; for($qs=1;$qs<14;$qs++): ?>
	<table border="1" width="100%">
		<tr>
			<?php if($qs>6 && $qs<12): ?>
				<td class="text-center" width="40px"><?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%", "value='{$t}'");$i++;?><?php $t=$t-2;?></td>
			<?php else: ?>
				<td class="text-center" width="40px"><?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%", "");$i++;?></td>
			<?php endif; ?>

			<?php if($qs<11): ?>
				<td class="text-center" width="40px"><?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%", "value='{$rr}'");$i++;?><?php $rr=$rr-5;?></td>
			<?php else: ?>
				<td class="text-center" width="40px"><?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%", "");$i++;?></td>
			<?php endif; ?>

			<?php if($qs>5 && $qs<13): ?>
				<td class="text-center" width="40px"><?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%", "value='{$n}'");$i++;?><?php $n=$n-20;?></td>
			<?php else: ?>
				<td class="text-center" width="40px"><?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%", "");$i++;?></td>
			<?php endif; ?>

			<td class="text-center" width="40px"><?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%", "value='{$td}'");$i++;?><?php $td=$td-20;?></td>
			<?php for($qa=0;$qa<36;$qa++):  ?>
				<td width="27px" class="graph"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> class="checkGraph" /><div class="graphC">&nbsp;</div></td>
			<?php endfor;  ?>
			<td><?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%", "");$i++;?></td>
		</tr>
	</table>
<?php endfor; ?>
<table border="1" width="100%">
	<tr>
		<td width="160px">Saturasi O2</td>
		<?php for($qe=0;$qe<12;$qe++): ?>
			<td width="81px"><?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%", "");$i++;?></td>
		<?php endfor;  ?>
		<td><?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%", "");$i++;?></td>
	</tr>
</table>
<table border="1" width="100%">
	<tr>
		<td valign="top" width="160px" rowspan="5">
			<div style="margin-bottom: 20px"> Skor Pemulihan: </div>
			<div style="margin-bottom: 15px"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Aldrete (0-10)</div>
			<div style="margin-bottom: 15px"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Bromage (0-3) </div>
			<div style="margin-bottom: 15px"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Steward (0-6) </div>
			<div><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 PADDS (1-10)
		</td>
		<td valign="top" width="972px" colspan="12"><?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;", "");$i++;?></td>
		<td valign="top"><?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;", "");$i++;?></td>
	</tr>
	
	<?php for($qq=0;$qq<4;$qq++): ?>
		<tr>
			<?php for($qx=0;$qx<12;$qx++): ?>
				<td width="81px"><?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px", "");$i++;?></td>
			<?php endfor; ?>
			<td><?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px", "");$i++;?></td>
		</tr>
	<?php endfor; ?>
	</table>
	<table border="1" width="100%">
	<tr>
		<td valign="top" width="160px" rowspan="5">
			<div style="margin-bottom: 20px"> Skala nyeri: </div>
			<div style="margin-bottom: 15px"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 NRS (0-10):</div>
			<div style="margin-bottom: 15px"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 NIPS (0-7):</div>
			<div style="margin-bottom: 15px"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 FLACC (0-10):</div>
			<div><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 BPS (3-12):
		</td>
		<td valign="top" width="972px" colspan="12"><?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;", "");$i++;?></td>
		<td valign="top"><?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;", "");$i++;?></td>
	</tr>
	
	<?php for($qq=0;$qq<4;$qq++): ?>
		<tr>
			<?php for($qx=0;$qx<12;$qx++): ?>
				<td width="81px"><?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px", "");$i++;?></td>
			<?php endfor; ?>
			<td><?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px", "");$i++;?></td>
		</tr>
	<?php endfor; ?>
	</table>
		<table border="1" width="100%">
	<tr>
		<td valign="top" width="160px">Obat / cairan:</td>
		<td valign="top" width="972px" colspan="12"><?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;", "");$i++;?></td>
		<td valign="top"><?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;", "");$i++;?></td>
	</tr>
	
	<?php for($qq=0;$qq<4;$qq++): ?>
		<tr>
			<td><?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px", "");$i++;?></td>
			<?php for($qx=0;$qx<12;$qx++): ?>
				<td width="81px"><?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px", "");$i++;?></td>
			<?php endfor; ?>
			<td><?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100%;height:20px", "");$i++;?></td>
		</tr>
	<?php endfor; ?>
	</table><br>


Komplikasi: <br>
<table width="100%">
	<tr>
		<td width="5px"><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
		<td width="80px">Tidak ada</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
		<td>Ada</td>
		<td>: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:90%;", "");$i++;?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>Tindakan</td>
		<td>: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:90%;", "");$i++;?></td>
	</tr>
</table><br>
Keterangan Skor Pemulihan <br>
<table width="100%" border="1">
	<tr>
		<td valign="top" width="25%">
			<b>Modified Aldrete's Scoring System<br></b>
			1. Aktivitas <br>
			2 = dapat menggerakkan  4 ekstremitas <br>
			1 = dapat menggerakkan  2 ekstremitas <br>
			0 = tidak ada gerakan <br>
			2. Pernafasan <br>
			&emsp;2 = nafas dalam dan batuk <br>
			&emsp;1 = Dypnea/ nafas dangkal <br>
			&emsp;0 = Apnea <br>
			3.  Sirkulasi <br>
			2 = TD + 20 mmHg dari preoperatif <br>
			1 = TD + 20-50 mmHg dari preoperatif <br>
			0 = TD + 50 mmHg dari preoperatif <br>
			4. Kesadaran <br>
			2 = sadar penuh, mudah dipanggil <br>
			1 = bangun jika dipanggil <br>
			0 = tidak ada respon <br>
			5. Warna kulit <br>
			2 = kemerahan/normal <br>
			1 = pucat <br>
			0 = sianosis <br>
			(Total skor> 9 untuk pemulangan)
		</td>
		<td valign="top" width="25%">
			<b>Bromage Score (Neuraxial)<br></b>
			0 =tidak ada blok motorik <br>
			1 = tidak dapat mengangkat tungkai bawah tetapi dapat menekuk lutut dan dapat menggerakkan kaki <br>
			2 = tidak dapat mengangkat tungkai bawah dan menekuk lutut tetapi dapat menggerakkan kaki <br>
			3 = tidak dapat menggerakkan kaki <br>
			(Skor<2 untuk pemulangan)
		</td>
		<td valign="top" width="25%">
			<b>Steward Score (Pediatri)<br></b>
			1. Kesadaran <br>
			&emsp;2 = bangun <br>
			&emsp;1 = respon terhadap stimulus <br>
			&emsp;0 = tidak respon terhadap stimulus <br>
			2. Jalan nafas <br>
			&emsp;2 = aktif menangis / batuk <br>
			&emsp;1 = dapat menjaga patensi jalan nafas <br>
			&emsp;0 = perlu bantuan  nafas <br>
			3.  Gerakan <br>
			&emsp;2 = gerak bertujuan <br>
			&emsp;1 = gerak tanpa tujuan <br>
			0 = tidak bergerak <br>
			(Total skor> 5 untuk pemulangan)
		</td>
		<td valign="top" width="25%">
			<b>PADSS score (Rawat Jalan)<br></b>
			1. Tanda vital <br>
			&emsp;2 = TD + nadi 20% dari preoperatif <br>
			&emsp;1 = TD + nadi 20-40% dari preoperatif <br>
			&emsp;0 = TD + nadi >40% mmHg dari preoperatif <br>
			2. Aktivitas <br>
			&emsp;2 = berjalan stabil, tidak pusing atau  <br>
			sama saatpreoperatif <br>
			&emsp;1 = memerlukan bantuan <br>
			&emsp;0 = tidak dapat berjalan <br>
			3. Mual dan muntah <br>
			&emsp;2 = minimal/teratasi dengan obat oral <br>
			&emsp;1 = sedang/teratasi dengan obat parenteral <br>
			&emsp;0 = berat/terus menerus walaupun dengan terapi <br>
			4. Nyeri <br>
			&emsp;Terkontrol dengan analgetik oral dan dapat diterima pasien
			&emsp;2 = ya <br>
			&emsp;1 = tidak <br>
			5. Perdarahan pembedahan <br>
			&emsp;2 = minimal <br>
			&emsp;1 = sedang <br>
			&emsp;0 = berat <br>
			(Total skor> 9 untuk pemulangan)
		</td>
	</tr>
</table><br>
<b>G.KEADAAN KELUAR RUANG PEMULIHAN/ KAMAR OPERASI <br></b>

<table width="100%" border="1">
	<tr>
		<td valign="top" width="50%">
			Kesadaran: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>
			 &emsp;GCS : <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  E&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  M&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			  V
			<br><br>
			Skala nyeri: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 NRS (0-10): <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 NIPS (0-7): <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 FLACC (0-10): <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 BPS (3-12): <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>
		</td>
		<td>
			Respirasi :  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 spontan, RR : <?=input($arr_data[$i-1], "data_{$i}", "number", "", "", "");$i++;?> x/mnt,  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> kanul nasal / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> simple mask / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> rebreathing mask / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> non-rebreathing mask,   O2 <?=input($arr_data[$i-1], "data_{$i}", "number", "", "", "");$i++;?> L/mnt, SpO2 : <?=input($arr_data[$i-1], "data_{$i}", "number", "", "", "");$i++;?> % <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 assist <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 kontrol : <br>
			Ventilator mode: <?=area($arr_data[$i-1], "data_{$i}", "", "", "");$i++;?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			Tekanan Darah : <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> mmHg&emsp;Nadi : <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> x/mnt, <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> reg / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> ireg / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> adekuat / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> inadekuat <br>
			Support : <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Tidak ada&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada <br>
			<?=area($arr_data[$i-1], "data_{$i}", "", "", "");$i++;?>

		</td>
	</tr>
</table><br>
Pasien pindah ke:  <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> ICU / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> PICU / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> HCU / <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bangsal / <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
Pukul: <?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?><br>

<b>INSTRUKSI POST OPERASI / PASKA ANESTESI :</b>
<?=area($arr_data[$i-1], "data_{$i}", "", "", "");$i++;?><br><br>

<div class="row">
	<div class="col-6 text-center">
		Dokter <br><br><br><br><br>
		(<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>)
	</div>
	<div class="col-6 text-center">
		Perawat Penanggung Jawab RR <br><br><br><br><br>
		(<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>)
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
	<script type="text/javascript">
		let graph = document.getElementsByClassName("graph");
		let Cgraph = document.getElementsByClassName("checkGraph");
		let graphC = document.getElementsByClassName("graphC");

		for (var i = 0; i < graph.length; i++) {
			let a = i;
			if(Cgraph[a].checked == false) {
			        graphC[a].style.display = 'none';
			    }
			    else {
			        if(Cgraph[a].checked == true) {
			        	graphC[a].style.display = 'block';
			        	

			         }   
			    }
			graph[i].addEventListener("click", () => {
				if(Cgraph[a].checked == false) {
			        Cgraph[a].checked = true; 
			        graphC[a].style.display = 'block';
			    }
			    else {
			        if(Cgraph[a].checked == true) {
			            Cgraph[a].checked = false; 
			        	graphC[a].style.display = 'none';
			        	

			         }   
			    }
			
			});
		}

		<?php if (isset($_REQUEST["pdf"])): ?>
			const pdf = document.getElementById("pdf-area");
			var opt = {
				margin: 0,
				filename:"RM 21.13 <?=$dataPasien["nama"]?>.pdf",
				image: { type: "JPEG", quality: 1 },
				html2canvas: { scale: 1 },
				jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
			};
			html2pdf().from(pdf).set(opt).save();
	<?php endif; ?>
	</script>
</body>

</html>