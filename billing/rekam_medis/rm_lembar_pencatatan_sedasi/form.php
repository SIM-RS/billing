<?php
	use yii\helpers\Html;
	include '../function/form.php';
	include '../../koneksi/konek.php';
	include 'funct.php';
	$dataPasien = getIndetitasPasien($_REQUEST['idKunj']);
	$i = 1;


  if (isset($_REQUEST['id'])) {
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_lembar_p_sedasi WHERE id = '{$_REQUEST['id']}'"));
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

      $hasil = mysql_query("UPDATE rm_lembar_p_sedasi 
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
		.tble{
			width: 100%;
		}
	</style>
  <script src="../html2pdf/ppdf.js"></script>
	<?php 
if (isset($_REQUEST['cetak'])) {
    $print_mode = true;
    echo "<script>window.print();</script>";
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_lembar_p_sedasi WHERE id = '{$_REQUEST['cetak']}'"));
	$arr_data = explode("|", $data['data']);

  }

  if (isset($_REQUEST['pdf'])) {
    $print_mode = true;
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_lembar_p_sedasi WHERE id = '{$_REQUEST['pdf']}'"));
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
					
				<div style="float: right">RM 21.12 / PHCM</div>
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
		<center><h2>LEMBAR PENCATATAN SEDASI</h2></center>
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






<table class="tble" border="1">
	<tr>
		<td valign="top" width="50%">
			Diagnosa: <?=area($arr_data[$i-1], "data_{$i}", "", "", "");$i++;?><br>
			Tindakan: <?=area($arr_data[$i-1], "data_{$i}", "", "", "");$i++;?>
		</td>
		<td valign="top" width="50%">
			Ruang tindakan: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?><br>
			Dokter: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?><br>
			Asisten: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>
		</td>
	</tr>
</table><br><br>

<b>RENCANA SEDASI<br></b>
Tingkat sedasi: 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> moderat / 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> dalam <br>
Jenis sedasi: 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Oral / 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> IM / 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> IV / 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Rektal / <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:70%", "");$i++;?> <br>
Analgesia pasca sedasi: 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Oral / 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> IM / 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> IV / 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Rektal / 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak diberikan <br>
&emsp;Obat : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:80%", "");$i++;?><br><br>

<b>EVALUASI PRE SEDASI<br></b>
Kesadaran: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:70%", "");$i++;?> GCS : 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> E   &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> M   &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> V   <br>
Tekanan Darah: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> mmHg&emsp;Nadi: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> x/mnt, 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> reg / 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> ireg / 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> adekuat / 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> inadekuat <br>
Respirasi: spontan / assisted / controlled, RR : <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> x/mnt, <br> 

<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Udara bebas / 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> kanul nasal / 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> simple mask / 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> rebreathing mask / 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> non-rebreathing mask / 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> terintubasi, O2 <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> L/mnt, SpO2 : <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> % <br>
Support : 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Tidak ada&emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:70%", "");$i++;?> <br>
Status Fisik ASA: 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> I / 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> II / 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> III / 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> IV / 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> V / 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> E <br><br>

<table>
	<tr>
		<td valign="top">Akses intravena, tempat dan ukuran:</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "", "", "");$i++;?></td>
	</tr>
</table>
<br>
Obat dan Pemantauan Selama Prosedur dengan Sedasi: <br><br>

<!-- PEMANTAUAN SELAMA SEDASI -->

Hal penting yang terjadi selama prosedur sedasi (komplikasi/efek samping, intervensi jalan napas, pemberian antidotum, resusitasi, dll) : <br>
<?=area($arr_data[$i-1], "data_{$i}", "", "", "");$i++;?> <br>
<table class="tble">
	<tr>
		<td valign="top" width="50%">
			Kedalaman Sedasi: <br>
			<table class="tble">
				<tr>
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Tak tersedasi (typical response/ cooperation for this patient)</td>
				</tr>
				<tr>
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Ringan (anxiolysis)</td>
				</tr>
				<tr>
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Sedang (purposeful response to verbal commands/light tactile sensation) </td>
				</tr>
				<tr>
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Dalam (purposeful response after repeated verbal/painful stimulation) </td>
				</tr>
				<tr>
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Anestesi umum/not arausable)</td>
				</tr>
			</table>                     
		</td>
		<td valign="top" width="50%">
			Respon terhadap sedasi: <br>
			<table class="tble">
				<tr>
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Sangat baik: tenang dan kooperatif</td>
				</tr>
				<tr>
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Baik: keluhan ringan &/ or meringis tapi prosedur tidak terganggu    </td>
				</tr>
				<tr>
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Cukup: menangis/meringis dan prosedur terganggu minimal</td>
				</tr>
				<tr>
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Kurang: adanya gerakan yang mengganggu preosedur </td>
				</tr>
				<tr>
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Jelek: gerakan aktif, menangis/meringis; prosedure berhenti</td>
				</tr>
			</table><br>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			Efektifitas secara menyeluruh: &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Tidak efektif     &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Efektif     &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Sangat efektif       &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Sedasi berlebihan
		</td>
	</tr>
</table>
<br>

<b>Pemantauan Paska Sedasi:<br></b>
Jam Masuk Ruang Pulih: <?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?><br>

<!-- Table Pemantauan Paska Sedasi -->

<br>
<b>PASKA SEDASI<br></b>
Keadaan Sebelum Pemulangan: <?=area($arr_data[$i-1], "data_{$i}", "", "", "");$i++;?><br>
Tanda vital: Kesadaran: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> &emsp;
TD:<?=input($arr_data[$i-1], "data_{$i}", "number", "", "", "");$i++;?> mmHg  &emsp;
Nadi: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "", "");$i++;?> x/menit  &emsp;
Support:<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>

Resp: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:60px", "");$i++;?> x/menit, 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> udara bebas / 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> kanul nasal / 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> simple mask / 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> rebreathing mask / 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> non-rebreathing mask / 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> terintubasi, 
&emsp; O2 <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:60px", "");$i++;?> L/mnt, 
&emsp; SpO2 <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:60px", "");$i++;?> % <br>
Kriteria pemulangan:
<br><br>
<table class="tble" border="1">
	<tr>
		<td valign="top" width="33%">
			<b>Modified Aldrete’s Scoring System<br></b>
			1. Aktivitas  <br>
			&emsp;2 = dapat menggerakkan 4 ektremitas <br>
			&emsp;1 = dapat menggerakkan 2 ektremitas  <br>
			&emsp;0 = tidak ada gerakan  <br>
			2. Pernafasan  <br>
			&emsp;2 = nafas dalam dan batuk  <br>
			&emsp;1 = Dypsnea/ nafas dangkal  <br>
			&emsp;0 = apnea  <br>
			3. Sirkulasi <br>
			&emsp;2 = TD ± 20 mmHg dari preoperatif <br>
			&emsp;1 = TD ± 20-50 mmHg dari preoperatif  <br>
			&emsp;0 = TD ± 50 mmHg dari preopratif <br>
			4. Kesadaran <br>
			&emsp;2 = sadar penuh, mudah dipanggil <br>
			&emsp;1 = bangun jika dipanggil <br>
			&emsp;0 = tidak ada respon <br>
			<br><br>
			5. Warna kulit <br>
			&emsp;2 = kemerahan/ normal <br>
			&emsp;1 = pucat <br>
			&emsp;0 = sianosis <br>
			Total skor: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:80px", "");$i++;?> (≥ untuk pemulangan)
		</td>
		<td valign="top">
			<b>Steward Score (Pediatri)<br></b>
			1. Kesadaran <br>
			&emsp;2 = bangun <br>
			&emsp;1 = respon terhadap stimulus <br>
			&emsp;0 = tidak respon terhadap stimulus <br>
			2. Jalan nafas <br>
			&emsp;2 = aktif menangis/ batuk <br>
			&emsp;1 = dapat menjaga patensi jalan nafas <br>
			&emsp;0 = perlu bantuan nafas <br>
			3. Gerakan <br>
			&emsp;2 = gerakan bertujuan <br>
			&emsp;1 = gerak tanpa tujuan <br>
			&emsp;0 = tidak bergerak <br>
			Total skor:: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:80px", "");$i++;?> (≥ 5 untuk pemulangan)

		</td>
		<td valign="top" width="33%">
			<b>PADDS score (Rawat Jalan)<br></b>
			1. Tanda vital <br>
			&emsp;2 = TD + nadi 20% dari preoperatif <br>
			&emsp;1 = TD + nadi 20-40 % dari preoperatif <br>
			&emsp;0 = TD + nadi >40% mmHg dari preoperatif <br>
			2. Aktifitas <br>
			&emsp;2 = berjalan stabil, tidak pusing atau sama saat preoperatif <br>
			&emsp;1 = memerlukan bantuan  <br>
			&emsp;0 = tidak dapat berjalan <br>
			3. Mual muntah  <br>
			&emsp;2 = minimal/ teratasi dengan obat oral <br>
			&emsp;1 = sedang/ teratasi dengan obat parenteral <br>
			&emsp;0 = berat/ terus menerus walaupun dengan terapi <br>
			4. Nyeri <br>
			&emsp;Terkontrol dengan anagetik oral dan dapat diterima pasien <br>
			&emsp;2 = ya <br>
			&emsp;1 = tidak <br>
			5. Perdarahan pembedahan <br>
			&emsp;2 = minimal <br>
			&emsp;1 = sedang <br>
			&emsp;0 = berat  <br>
			Total skor: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:80px", "");$i++;?> (≥ 9 untuk pemulangan)
		</td>
	</tr>
</table><br>

Pasien pindah ke:  
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> ICU / 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> PICU / 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> HCU / 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bangsal / <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:80px", "");$i++;?>&emsp;
Pukul: <?=input($arr_data[$i-1], "data_{$i}", "time", "", "width:80px", "");$i++;?> <br>
Proses pemulangan: <br>
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />   Ruang perawatan inap    &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Pulang ke rumah  &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Lain-lain  <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>

<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />   Instruksi post prosedur sedasi: 
<div style="margin-left: 30px"><?=area($arr_data[$i-1], "data_{$i}", "", "", "");$i++;?></div><br><br>
Dokter <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>&emsp;
Tanda tangan <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
Asisten <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>&emsp;
Tanda tangan <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>



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
		<?php if(isset($_REQUEST["pdf"])): ?>
			const pdf = document.getElementById("pdf-area");
			var opt = {
				margin: 0,
				filename: "RM 21.12 <?=$dataPasien["nama"]?>.pdf",
				image: { type: "JPEG", quality: 1 },
				html2canvas: { scale: 1 },
				jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
			};
			html2pdf().from(pdf).set(opt).save();
	<?php endif; ?>
	</script>
</body>

</html>