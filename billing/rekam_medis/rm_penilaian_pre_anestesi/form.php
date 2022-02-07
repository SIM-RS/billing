<?php
	use yii\helpers\Html;
	include '../function/form.php';
	include '../../koneksi/konek.php';
	include 'funct.php';
	$dataPasien = getIndetitasPasien($_REQUEST['idKunj']);
	$i = 1;
$sql = "SELECT
            pa.*,
            agama.agama as agama,
            ped.nama as pendidikam,
            pk.nama as pekerjaan,
            kw.nama as kewarganegaraan 
        FROM
            b_ms_pasien pa 
            LEFT JOIN b_ms_pendidikan ped ON ped.id = pa.pendidikan_id
            LEFT JOIN b_ms_agama as agama ON agama.id = pa.agama
            LEFT JOIN b_ms_pekerjaan as pk ON pk.id = pa.pekerjaan_id
            LEFT JOIN b_ms_kewarganegaraan as kw ON kw.id = pa.id_kw
        WHERE
			pa.id = {$dataPasien['id']}";
			
		$dataP = mysql_fetch_assoc(mysql_query($sql));

	if (isset($_REQUEST['id'])) {
		$data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_penilaian_pre_anestesi WHERE id = '{$_REQUEST['id']}'"));
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

      $hasil = mysql_query("UPDATE rm_penilaian_pre_anestesi 
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
		.tde {
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
	<?php 
		if (isset($_REQUEST['cetak'])) {
				$print_mode = true;
				echo "<script>window.print();</script>";
				$data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_penilaian_pre_anestesi WHERE id = '{$_REQUEST['cetak']}'"));
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

			if (isset($_REQUEST['pdf'])) {
				$print_mode = true;
				$data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_penilaian_pre_anestesi WHERE id = '{$_REQUEST['pdf']}'"));
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
</head>

<body id="pdf-area">
	<div class="bg-white" style="padding:25px">
		<div class="row">
			<div class="col-6 text-center"><br><br>
				<img src="../logors1.png">
			</div>
			<div class="col-6" style="padding:15px">
					
				<div style="float: right">RM 21.4 / PHCM</div>
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
		<center><h2>FORMULIR  PENILAIAN  PRE – ANESTESI / SEDASI</h4></center>

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
			TB: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> &emsp;
			BB: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> &emsp;
			BMI: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> &emsp;
			Tanggal tindakan <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>
		</td>
	</tr>
	<tr>
		<td>
			Riwayat operasi : <br><?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada
		</td>
		<td>
			Riwayat Obat-obatan : <br><?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada
		</td>
		<td>
			Alergi/reaksi obat dan makanan : <br><?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada
		</td>
	</tr>
</table>
<table width="100%" border="1px">
	<tr>
		<th class="bg-secondary text-center" colspan="4">SISTEM ORGAN</th>
	</tr>
	<tr>
		<td width="2%" class="text-center">√</td>
		<td width="48%">Apakah pernah atau sedang mengalami:</td>
		<td width="2%" class="text-center">√</td>
		<td width="48%">Apakah pernah atau sedang mengalami:</td>
	</tr>
	<tr>
		<td class="text-center" rowspan="2"><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			<br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
		</td>
		<td rowspan="2">
			<b>Penyakit Kardiovaskular <br></b>
			Nyeri dada / Serangan jantung <br>
			Irama jantung irreguler <br>
			Pacu jantung / Defibrilator Merk: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?> <br>
			Masalah sirkulasi <br>
			Penyumbatan pembuluh darah tungkai atau paru <br>
			Hipertensi <br>
			<b>Tidak ada</b>
		</td>
		<td class="text-center"><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
		</td>
		<td>
			<b>Kelainan Darah<br></b>
			Risiko perdarahan atau mendapat pengencer darah <br>
			Mengalami atau keturunan sickle cell disease <br>
			Riwayat transfusi darah <br>
			HIV positif/AIDS <br>
			Tidak ada <br>
		</td>
	</tr>
	<tr>
		<td class="text-center">
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
		</td>
		<td>
			<b>Penyakit  Mata/ Glaukoma/ Ablasio Retina</b><br>
			Tidak ada
		</td>
	</tr>
	<tr>
		<td class="text-center" rowspan="2"><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
		</td>
		<td rowspan="2">
			<b>Penyakit Respirasi<br></b>
			Merokok <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px;height:20px", "");$i++;?> bks/hari; 
			&emsp;Berhenti <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?> <br>
			Asma <br>
			Emfisema/ bronkitis <br>
			Sesak saat istirahat <br>
			Infeksi saluran napas atas dalam 2 minggu <br>
			Sleep apnea &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Menggunakan CPAP <br>
			Tidak ada
		</td>
		<td class="text-center">
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
		</td>
		<td>
			<b>Penyakit Telinga/ Berdenging/ Tuli</b><br>
			Tidak ada
		</td>
	</tr>
	<tr>
		<td class="text-center">
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
		</td>
		<td>
			<b>Kanker/ Kemoterapi/ Radioterapi<br></b>
			Jika ya, uraikan 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?> <br>
			 Tidak ada
		</td>
	</tr>
	<tr>
		<td class="text-center" rowspan="3"><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<div style="width: 100%;border:1px solid black;"></div>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
		</td>
		<td rowspan="3">
			<b>Penyakit Neurologis<br></b>
			Stroke atau stroke ringan IT.I.A.) <br>
			Kejang <br>
			Masalah punggung atau leher <br>
			Keterbatasan fisik <br>
			Pelupa, hilang ingatan, bingung <br>
			Sklerosis multipel/distrofi otot <br>
			Cedera saraf/spinal <br>
			Neuropati <br>
			Tidak ada <br>
			<div style="width: 100%;border:1px solid black;"></div>
			<b>Diabetes</b>   <br>
			Tidak ada
		</td>
		<td class="text-center">
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
		</td>
		<td>
			<b>Kelainan psikiatri<br></b>
			Jika ya, uraikan 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?> <br>
			Tidak ada
		</td>
	</tr>
	<tr>
		<td class="text-center">
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
		</td>
		<td>
			<b>Penyakit atau Kelainan Lain<br></b>
			Jika ya, uraikan 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?> <br>
			Tidak ada
		</td>
	</tr>
	<tr>
		<td class="text-center"><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
		</td>
		<td>
			<b>Untuk Wanita<br></b>
			Apakah mungkin Anda hamil? <br>
			Hari pertama menstruasi 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?> <br>
			Paskamenopause / histerektomi <br>
			Tidak ada / not applicable
		</td>
	</tr>
	<tr>
		<td class="text-center">
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
		</td>
		<td>
			<b>Masalah Tiroid<br></b>
			Tidak ada
		</td>
		<td class="text-center" rowspan="2"><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
		</td>
		<td rowspan="2">
			<b>Riwayat Anestesi/Sedasi<br></b>
			Anestesi dalam 1 tahun terakhir <br>
			Riwayat intubasi sulit <br>
			Penolakan/keberatan  terhadap anestesi spinal/epidural <br>
			Efek samping anestesi/sedasi <br>
			Malignant hyperthermia <br>
			PONV (Mual muntah paska anestesi) <br>
			Mengetahui risiko makan atau minum pada hari saat dianestesi <br>
			Tidak ada <br>
		</td>
	</tr>
	<tr>
		<td class="text-center">
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
		</td>
		<td>
			<b>Masalah Ginjal/Buli/Prostat<br></b>
			Jika ya, uraikan <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?> <br>
			Tidak bisa BAK setelah anestesi <br>
			Dialisis, Jadwal <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?> <br>
			Tidak ada <br>
		</td>
	</tr>
	<tr>
		<td class="text-center">
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
		</td>
		<td>
			<b>Masalah Gastro-Intestinal<br></b>
			Penyakit hati (ikterus, hepatitis) <br>
			Hiatal hernia/reflux/heartburn <br>
			Lain-lain <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?> <br>
			Tidak ada
		</td>
		<td class="text-center"><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
		</td>
		<td>
			<b>Karena obat-obatan dapat berinteraksi dengan obat anestesi, apakah:<br></b>
			Riwayat konsumsi alkohol rutin atau dalam waktu 24 jam <br>
			Konsumsi steroid/kortison dalam waktu satu tahun <br>
			Konsumsi obat yang dijual di pasar dalam waktu 30 hari <br>
			Tidak ada
		</td>
	</tr>
</table>
<table width="100%" border="1px">
	<tr>
		<th class="bg-secondary text-center">PSIKOLOGIS DAN KULTURAL</th>
	</tr>
	<tr>
		<td>
			Keadaan psikologis: &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tenang               &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Cemas/gelisah               &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bingung                &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak kooperatif   <br><br>
			<div class="row">
				<div class="col-1">Kultural:</div>
				<div class="col-11">
			   		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Penolakan/keberatan terhadap transfusi darah <br>
			   		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Lain-lain 
			   		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?><br>
			   		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Tidak ada <br>
				</div>
			</div><br>
			<div class="row">
				<div class="col-5" style="padding-right: :0!important;margin-right: 0!important;border:1px solid black;border-left: 0!important;border-top: 0!important;border-bottom: 0!important">
					Tanda vital: <br>
					Kesadaran 
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?> <br>
					TD 
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?> &emsp;T 
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?> <br>
					N 
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?> &emsp;RR 
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?> <br>
					SpO2 
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?>
					<div class="bg-secondary text-center" style="border: 1px solid black;width: 100%"><b>EVALUASI JALAN NAFAS</b></div>
					Gigi: <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lengkap    &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ompong      &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Goyah      &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Overbite       &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Protrusi <br><br>

					Buka mulut 3 jari: <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya          &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak <br><br>

					Jarak thyro-mental 3 jari: <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya          &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak <br><br>

					Malampati: <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> I      &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> II      &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> III      &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> IV <br>
					&emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak dapat/sulit dinilai (tidak kooperatif) <br><br>

					ROM leher: <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Baik          &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Terbatas <br><br>

					Kelainan jalan nafas lain: <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Jika ya, uraikan <br><?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?> <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak ada 
				</div>
				
				<div class="col-7" style="padding-left:0!important;">
					<div class="bg-secondary text-center" style="border: 1px solid black;"><b>PEMERIKSAAN PENUNJANG</b></div>
					Laboratorium:  Tanggal 
					<?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?> <br>
					Hb 
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100px;height:20px", "");$i++;?> &emsp;Ht 
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100px;height:20px", "");$i++;?> &emsp;Leu 
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100px;height:20px", "");$i++;?> &emsp;Trb 
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100px;height:20px", "");$i++;?> <br>
					Na 
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100px;height:20px", "");$i++;?> &emsp;K 
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100px;height:20px", "");$i++;?> &emsp;Cl 
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100px;height:20px", "");$i++;?> &emsp;Ca 
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100px;height:20px", "");$i++;?>  <br>
					Glukosa 
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100px;height:20px", "");$i++;?> &emsp;Ureum 
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100px;height:20px", "");$i++;?> &emsp;Kreatinin 
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100px;height:20px", "");$i++;?> <br>
					INR 
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100px;height:20px", "");$i++;?> &emsp;PT 
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100px;height:20px", "");$i++;?> &emsp;PTT 
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:100px;height:20px", "");$i++;?> <br>
					Lain-lain 
					<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?> <br>

					Ro Thoraks: Tanggal 
					<?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?> <br>
					
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:400px;height:20px", "");$i++;?> <br>

					EKG: Tanggal 
					<?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?> <br>
					
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:400px;height:20px", "");$i++;?> <br>

					Echo: Tanggal 
					<?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?> <br>
					
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:400px;height:20px", "");$i++;?> <br>

					Lain-lain:  <br>
					<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>
				</div>
				</div>
			</div>
			<table width="100%" border="1px">
				<tr>
					<td width="519px">
					<div style="border:1px solid black" class="bg-secondary text-center"><b>PARU</b></div>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bunyi napas tambahan: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?> <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Normal <br><br>
					<div class="bg-secondary text-center" style="border: 1px solid black;"><b>JANTUNG</b></div>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Irama ireguler&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Murmur&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Gallop <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Normal
					</td>
					<td>
						Diagnosa: <?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>

					Tindakan: <?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>

					Status fisik:  ASA &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 1&emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  2&emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 3&emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  4&emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  5&emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> E
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			 Risiko, keuntungan, dan alternatif pilihan teknik anestesi/sedasi telah didiskusikan. <br><br>
			Rencana Anestesi/sedasi:  <br>
			Anestesi:&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> GA&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Regional&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Combined&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Monitoring Anesthesia Care&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			Sedasi:&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Moderat&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Dalam <br><br>
			Tanggal 
			<?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>  &emsp;Jam 
			<?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?>  <br><br>


			Dokter  
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> &emsp;Tanda tangan 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>



			Asisten  
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> &emsp;Tanda tangan 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>
		</td>
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
			const pdf = document.getElementById("pdf-area");
			var opt = {
				margin: 0,
				filename: "RM 21.4 <?=$dataPasien["nama"]?>.pdf",
				image: { type: "JPEG", quality: 1 },
				html2canvas: { scale: 1 },
				jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
			};
			html2pdf().from(pdf).set(opt).save();
    	<?php endif; ?>
	</script>
</body>

</html>