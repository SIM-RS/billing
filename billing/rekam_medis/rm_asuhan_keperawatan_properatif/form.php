<?php
	use yii\helpers\Html;
	include '../function/form.php';
	include '../../koneksi/konek.php';
	include 'funct.php';
	$dataPasien = getIndetitasPasien($_REQUEST['idKunj']);
	$i = 1;
	


  if (isset($_REQUEST['id'])) {
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_asuhan_keperawatan_properatif WHERE id = '{$_REQUEST['id']}'"));
    $arr_data_1 = "";
    $arr_data_1 .= $data['data_rm_21_19'];
    $arr_data_2 = explode("|", $arr_data_1);
    $d = explode("|", $data['data_rm_11_7']);
    array_pop($d);
    array_splice($arr_data_2, 124, 0, $d);
    $arr_data = $arr_data_2;
  }

  if (isset($_REQUEST['idx'])) {
	date_default_timezone_set("Asia/Jakarta");
	$tgl_act = date('Y-m-d H:i:s');
    $iCount = mysql_real_escape_string($_REQUEST['i']);

    $str_1 = "";
    $str_2 = "";
    for ($i=1; $i < $iCount; $i++) { 
        $data = mysql_real_escape_string($_REQUEST["data_{$i}"]);
        if ($i > 124 && $i < 323) {
            if ($data == "") {
                $str_2 .= "#";
                $str_2 .= "|";
            } else {
                $str_2 .= $data;
                $str_2 .= "|";
            }
        } else {
            if ($data == "") {
                $str_1 .= "#";
                $str_1 .= "|";
            } else {
                $str_1 .= $data;
                $str_1 .= "|";
            }
        }
        
    }

    $data = [
        'id_kunjungan' => mysql_real_escape_string($_REQUEST['id_kunjungan']),
        'id_pelayanan' => mysql_real_escape_string($_REQUEST['id_pelayanan']),
        'tgl_act' => date('Y-m-d H:i:s'),
        'id_user' => mysql_real_escape_string($_REQUEST["id_user"]),
        'data_rm_21_19' => $str_1,
        'data_rm_11_7' => $str_2
    ];

      $hasil = mysql_query("UPDATE rm_asuhan_keperawatan_properatif 
            SET
            id_kunjungan = '{$data['id_kunjungan']}',
            id_pelayanan = '{$data['id_pelayanan']}',
            tgl_act = '{$data['tgl_act']}',
            id_user = '{$data['id_user']}',
			data_rm_21_19 = '{$data['data_rm_21_19']}',
			data_rm_11_7 = '{$data['data_rm_11_7']}'
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
			padding-left: 20px;
		}
	</style>
	<script src="../html2pdf/ppdf.js"></script>
	<?php 
if (isset($_REQUEST['cetak'])) {
    $print_mode = true;
    echo "<script>window.print();</script>";
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_asuhan_keperawatan_properatif WHERE id = '{$_REQUEST['cetak']}'"));

	$arr_data_1 = "";
    $arr_data_1 .= $data['data_rm_21_19'];
    $arr_data_2 = explode("|", $arr_data_1);
    $d = explode("|", $data['data_rm_11_7']);
    array_pop($d);
    array_splice($arr_data_2, 124, 0, $d);
    $arr_data = $arr_data_2;

  }

  if (isset($_REQUEST['pdf'])) {
    $print_mode = true;
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_asuhan_keperawatan_properatif WHERE id = '{$_REQUEST['pdf']}'"));

	$arr_data_1 = "";
    $arr_data_1 .= $data['data_rm_21_19'];
    $arr_data_2 = explode("|", $arr_data_1);
    $d = explode("|", $data['data_rm_11_7']);
    array_pop($d);
    array_splice($arr_data_2, 124, 0, $d);
    $arr_data = $arr_data_2;

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
					
				<div style="float: right">RM 21.19 / PHCM</div>
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
		<center><h2>ASUHAN KEPERAWATAN PREOPERATIF</h2></center>
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
		<th class="text-center" colspan="5">PRE OPERATIF</th>
	</tr>
	<tr class="text-center">
		<th rowspan="2">Pengkajian</th>
		<th rowspan="2">Masalah </th>
		<th rowspan="2">Rencana tindakan </th>
		<th colspan="2">Tindakan keperawatan</th>
	</tr>
	<tr class="text-center">
		<th>Implementasi</th>
		<th>Evaluasi</th>
	</tr>
	<tr>
		<td width="20%" valign="top">
			<table width="100%">
				<tr>
					<td colspan="2"><b>JAM : <?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?></b></td>
				</tr>
				<tr>
					<td valign="top">1.</td>
					<td>
						Breathing <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
						Spontan <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
						Dibantu <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
						RR <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:80px", "");$i++;?> x/m <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
						SO2
					</td>
				</tr>
				<tr>
					<td valign="top">2.</td>
					<td>
						Blood <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TD : <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:80px", "");$i++;?> mmHg <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> N   : <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:80px", "");$i++;?> x/m <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Suhu : <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:80px", "");$i++;?><br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Canula IV
					</td>
				</tr>
				<tr>
					<td valign="top">3.</td>
					<td>
						Brain <br>
						Kesadaran <br>
						<div class="newline">
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Compos mentis <br>
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Apatis <br>
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Delirium <br>
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Somnolen <br>
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Stupor <br>
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Koma
						</div>
						Status Emosi <br>
						<div class="newline">
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Cemas <br>
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tenang 
						</div>
						Penilaian nyeri <br>
						<div class="newline">
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Akut <br>
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> kronis <br> 
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lokasi <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?><br><br>
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Derajat  <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?>
						</div>
					</td>
				</tr>
				<tr>
					<td valign="top">4.</td>
					<td>
						Bladder <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pakai dower kateter
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Jumlah Urine <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:80px;height:20px", "");$i++;?> cc <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lainnya : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?>
					</td>
				</tr>
				<tr>
					<td valign="top">5.</td>
					<td>
						Bowel <br>
						BB: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:80px;height:20px", "");$i++;?> Kg&emsp;TB: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:80px;height:20px", "");$i++;?> cm <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Puasa &emsp; <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Distensi <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Mual muntah <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sulit menelan 
					</td>
				</tr>
				<tr>
					<td valign="top">6.</td>
					<td>
						Bone <br>
						<table width="100%">
							<tr>
								<td valign="top">Integritas kulit :</td>
								<td>
									<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Utuh <br>
									<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Patah
								</td>
							</tr>
							<tr>
								<td valign="top">Tulang :</td>
								<td>
									<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Utuh <br>
									<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Patah
								</td>
							</tr>
						</table>
						 
					</td>
				</tr>
			</table>
		</td>
		<td width="20%" valign="top">
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Cemas  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Kurang pengetahuan  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Gangguan integritas kulit <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Penurunan kesadaran  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Resiko gangguan cairan  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Nyeri  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Resiko cedera  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?>
		</td>
		<td width="20%" valign="top">
			<table width="100%">
				<tr  valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Laksanakan Protap interaksi social </td>
				</tr>
				<tr  valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Cek kelengkapan dokumen pre op</td>
				</tr>
				<tr  valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Laksanakan orientasi pre op</td>
				</tr>
				<tr  valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Jelaskan prosedur tindakan </td>
				</tr>
				<tr  valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Observasi vital sing dan keadaan umum pasien </td>
				</tr>
				<tr  valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Kolaborasi pemasangan cairan intra vena </td>
				</tr>
				<tr  valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Berikan posisi nyaman </td>
				</tr>
				<tr  valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Siapkan mesin anesthesi</td>
				</tr>
				<tr  valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Siapkan alat dan obat anesthesi </td>
				</tr>
				<tr  valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Kolaborasi pemberian premedikasi</td>
				</tr>
				<tr  valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Monitor efek pemberian premedikasi</td>
				</tr>
				<tr  valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Siapkan alat dan obat sesuai pembedahan </td>
				</tr>
				<tr  valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Lakukan vital sign</td>
				</tr>
				<tr  valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Kolaborasi pemberian antibiotika</td>
				</tr>
				<tr  valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td> <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?></td>
				</tr>
				<tr  valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td> <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?></td>
				</tr>
			</table>

		</td>
		<td width="20%" valign="top">
			<table width="100%">
				<tr  valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Perkenalan diri petugas OK ke pasien </td>
				</tr>
				<tr  valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Operan pasien dan kelengkapan dokumen</td>
				</tr>
				<tr  valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Memberikan orientasi dan informasi lingkungan dan proses operasi </td>
				</tr>
				<tr  valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Mengobservasi vital sign dan keadaan umum paasien </td>
				</tr>
				<tr  valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Memasang akses intravena</td>
				</tr>
				<tr  valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Memberikan posisi yang nyaman </td>
				</tr>
				<tr  valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Menyiapkan mesin anesthesi </td>
				</tr>
				<tr  valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Menyiapkan alat dan obat anesthesi </td>
				</tr>
				<tr  valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Membantu pemberian premedikasi dan mengobservasi efeknya</td>
				</tr>
				<tr  valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Monitor efek pemberian premedikasi</td>
				</tr>
				<tr  valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Menyiapkan alat dan obat sesuai pembedahan</td>
				</tr>
				<tr  valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Melakukan sign in</td>
				</tr>
				<tr  valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Memberikan antibiotika sesuai instruksi dokter.</td>
				</tr>
				<tr  valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td><?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?></td>
				</tr>
				<tr  valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td><?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?></td>
				</tr>
			</table>
		</td>
		<td width="20%" valign="top">
			<table width="100%">
				<tr valign="top">
					<td>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak
					</td>
				</tr>
				<tr valign="top"><td>&nbsp;</td></tr>
				<tr valign="top">
					<td>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lengkap &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak 
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr valign="top">
					<td>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pasien mengerti &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak 
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr valign="top">
					<td> <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Stabil &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak 
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr valign="top">
					<td> <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lancar &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak 
					</td>
				</tr>
				<tr valign="top">
					<td>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Supline &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lateral 
					</td>
				</tr>
				<tr valign="top">
					<td>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Supline &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lateral  <br>
						<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?> <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Supline &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lateral 
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr valign="top">
					<td>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Siap &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak 
					</td>
				</tr>
				<tr valign="top">
					<td><br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak 
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr valign="top">
					<td>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pasien kooperatif
					</td>
				</tr>
				<tr valign="top">
					<td>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pasien gelisah
					</td>
				</tr>
				<tr valign="top">
					<td>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya &emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr valign="top">
					<td>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya &emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya, jenis <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?>&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Dosis <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?> <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr valign="top">
					<td>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?> <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<br><br>
<table width="100%" border="1">
	<tr>
		<th colspan="5">
			<div class="row">
				<div class="col-9">
					RUMAH SAKIT PRIMA HUSADA CIPTA MEDAN
				</div>
				<div class="col-3">
					RM 11.7/ PHCM
				</div>
			</div>
		</th>
	</tr>
	<tr>
		<th colspan="5">INTRA OPERATIF</th>
	</tr>
	<tr class="text-center">
		<th rowspan="2">Pengkajian</th>
		<th rowspan="2">Masalah</th>
		<th rowspan="2">Rencana tindakan</th>
		<th colspan="2">Tindakan keperawatan</th>
	</tr>
	<tr class="text-center">
		<th>Implementasi</th>
		<th>Evaluasi</th>
	</tr>
	<tr>
		<td valign="top" width="20%">
			Jam masuk OK : <?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?> <br>
			Jam keluar OK  : <?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?> <br>
			Anastesi mulai jam : <?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?> <br>
            Selesai jam : <?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?> 
            <div class="row">
            	<div class="col-6">
            		Jenis :
            	</div>
            	<div class="col-6">
            		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> GA &emsp;
            		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> RA <br>
            		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> LA <br>
            		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Blok fleksus
            	</div>
            </div>
            Nama tindakan operasi <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
            <br>
            Mulai jam : <?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?> <br>
			Selesai jam : <?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?> <br><br>
			<table width="100%">
				<tr>
					<td valign="top">1.</td>
					<td valign="top">
						Breathing <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Spontan <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Dibantu <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> RR <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:80px;height:20px", "");$i++;?> xx/mnt <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> SO2 <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:80px;height:20px", "");$i++;?> % <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>
					</td>
				</tr>
				<tr>
					<td valign="top">2.</td>
					<td valign="top">
						Blood <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TD : <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:80px;height:20px", "");$i++;?> mmHg<br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> N  : <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:80px;height:20px", "");$i++;?> x/mnt<br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> S  : <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:80px;height:20px", "");$i++;?> xx/mnt <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Canula IV <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Stabil &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak
					</td>
				</tr>
				<tr>
					<td valign="top">3.</td>
					<td valign="top">
						Brain <br>
						Kesadaran <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Composmentis <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
						Apatis     &emsp; <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
						delirium<br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
						Stupor          &emsp; 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
						koma <br>
						Status emocional <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
						Cemas&emsp; 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
						tenang<br>
						Penilaian nyeri<br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
						Akut&emsp; 
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
						kronis<br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
						Lokasi<br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
						Derajat<br><br><br>
					</td>
				</tr>
				<tr>
					<td valign="top">4.</td>
					<td valign="top">
						Bladder <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pakai dower kateter <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
						Jumlah urine <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:80px;height:20px", "");$i++;?> cc<br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
						Lainnya <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?>
					</td>
				</tr>
				<tr>
					<td valign="top">5.</td>
					<td valign="top">
						Bowel <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Mual / muntah<br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
						Distensic<br>
					</td>
				</tr>
				<tr>
					<td valign="top">6.</td>
					<td valign="top">
						Bone <br>
						Integritas kulit <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Utuh &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
						Tidak<br>
						Tulang <br>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Utuh &emsp;
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
						Tidak<br>
					</td>
				</tr>
			</table>
		</td>
		<td width="20%" valign="top">
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Resiko infeksi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Resiko injury <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Resiko hipotermy <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Cemas <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Gangguan integritas kulit <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kebersihan jalan nafas tidak efektif <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Resiko gangguan cairan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Nyerii  <br>
			<?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?>
		</td>
		<td width="20%" valign="top">
			<table width="100%">
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Siapkan lingkungan kamar operasi</td>
				</tr>
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Pasang alat penghangat</td>
				</tr>
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Siapkan pasien dimeja operasi</td>
				</tr>
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Observasi vital sign</td>
				</tr>
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Siapkan sinstrumen dan linen</td>
				</tr>
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Asistensi dokter anastesi untuk GA/RA</td>
				</tr>
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Posisikan pasien sesuaikan pembedahan</td>
				</tr>
			</table><br><br><br>
			<table width="100%">
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Laksanakan standar precaution pembedahan</td>
				</tr>
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Lakukan penghitungan awal instrumen,gas dan kelengkapannya</td>
				</tr>
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Observasi pemasangan packing di tenggorokan</td>
				</tr>
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Observasi pemasangan tourniquet</td>
				</tr>
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Pasang diatermy dan awasi kondisi kulit tempat pemasangan.</td>
				</tr>
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Lakukan skin preparation</td>
				</tr>
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Lakukan time out</td>
				</tr>
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Monitor intake out put</td>
				</tr>
			</table><br><br><br>
			<table width="100%">
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Cuci luka</td>
				</tr>
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Lakukan perhitungan akhir instrumen,gas dan kelengkapannya</td>
				</tr>
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Lakukan sign out</td>
				</tr>
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Rawat luka</td>
				</tr>
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Asistensi pengakhiran anastesi </td>
				</tr>
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Rapikan alat anastesi</td>
				</tr>
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Cek bahan specimen</td>
				</tr>
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td><?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?></td>
				</tr>
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td><?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?></td>
				</tr>
			</table>
		</td>
		<td valign="top" width="20%">
			<table width="100%">
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Menyiapkan lingkungan kamar operasi</td>
				</tr>
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Memasang alat penghangat</td>
				</tr>
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Menyiapkan pasien dimeja operasi</td>
				</tr>
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Memasang alat pantau vital sign</td>
				</tr>
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Menyiapkan instrument dan linen</td>
				</tr>
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Mengasistensi anasthesist untuk GA/RA</td>
				</tr>
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Memposisikan pasien</td>
				</tr>
			</table><br><br><br>
			<table width="100%">
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Melakukan standar precaution pembedahan (scrubing,gawning, gloving)</td>
				</tr>
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Melakukan perhitungan awal instrument,gas,dan kelengkapan lainnya</td>
				</tr>
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Mengobservasi pemakaian packing ditenggorokan.</td>
				</tr>
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Mengobservasi pemakaian tourniquet.</td>
				</tr>
			</table><br><br><br>
			<table width="100%">
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Pasang diatermy dan mengobservasinya,.</td>
				</tr>
			</table><br><br><br>
			<table width="100%">
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Melakukan skin preparation</td>
				</tr>
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Melakukan time out</td>
				</tr>
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Monitoring intake out put</td>
				</tr>
			</table><br><br><br>
			<table width="100%">
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Mencuci luka</td>
				</tr>
			</table><br><br>
			<table width="100%">
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Melakukan penghitungan akhir intrumen,gas dan kelengkapan lainnya</td>
				</tr>
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Melakukan sign out</td>
				</tr>
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Merawat luka</td>
				</tr>
			</table><br><br>
			<table width="100%">
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Mengasistensi pengakhiran anastesi</td>
				</tr>
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Merapikan peralatan anastesi</td>
				</tr>
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td>Mengecek bahan specimen</td>
				</tr>
				<tr valign="top">
					<td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /></td>
					<td><?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?></td>
				</tr>
			</table><br><br>
		</td>
		<td valign="top" width="20%">
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Siap&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak <br><br>
			<br><br>

			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak <br><br>
			<br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Siap&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak <br>

			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lengkap&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak <br>

			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TD: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:80px", "");$i++;?>       mmHg <br>

			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> N: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:50px", "");$i++;?> x/m&emsp;
			RR: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:50px", "");$i++;?> x/m <br>
			S: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:50px", "");$i++;?> c&emsp;SO2: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:50px", "");$i++;?> % <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak <br><br><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Terlentang <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lithotomi <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tengkurap <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lateral kiri <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lateral kanan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?> <br><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak <br><br><br><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lengkap&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya&emsp;<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak <br>
			Jam dikeluarkan : <br>
			Lokasi <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lengan kanan<br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lengan kiri<br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kaki kanan<br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kaki kiri<br>
			Jam mulai   : <?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?> <br>
			Jam selesai : <?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?> <br>
			Tekanan       <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?> <br>
			<br><br><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Monopolar&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> bipolar <br>
			Posisi diathermy <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lengan kanan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lengan kiri <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Paha kanan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Paha kiri <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lainnya <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?> <br>
			Kondisi kulit post pemasangan diathermy <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Utuh              tidak <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Providiae iodine <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Alkohol <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lainnya <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak <br>
			Intake <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kristaloid <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:100px", "");$i++;?> cc <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Koloid <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:100px", "");$i++;?> cc <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Darah <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:100px", "");$i++;?> cc <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lainnya <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:100px", "");$i++;?> cc <br>
			Out put <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Perdarahan <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:100px", "");$i++;?> cc <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Urine <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:100px", "");$i++;?> cc <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lainnya <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?> cc <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Normal saline <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Povidne iodine <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> lainnya <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> lengkap            tidak <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> X-Ray dilakukan <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Insiden report <br><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tulle grass <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Wound dress <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lainnya <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak <br><br><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak <br><br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak
		</td>
	</tr>
</table>
<b>PERHITUNGAN PENGGUNAAN KASA / ALAT TAMBAHAN</b><br>

<table border="1" width="100%">
	<tr class="text-center">
		<td>JENIS YANG DIHITUNG</td>
		<td>PERHITUNGAN AWAL</td>
		<td colspan="3">PENAMBAHAN SELAMA OPERASI</td>
		<td>TOTAL</td>
		<td>PERHITUNGAN KEDUA</td>
		<td colspan="3">PENAMBAHAN</td>
		<td>TOTAL</td>
		<td>PERHITUNGAN KEDUA</td>
	</tr>
	<tr>
		<td>Gausa Kecil</td>
		<?php for($a=0;$a<11;$a++): ?>
			<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<?php endfor; ?>
	</tr>
	<tr>
		<td>Gausa Besar</td>
		<?php for($a=0;$a<11;$a++): ?>
			<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<?php endfor; ?>
	</tr>
	<tr>
		<td>Kacang</td>
		<?php for($a=0;$a<11;$a++): ?>
			<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<?php endfor; ?>
	</tr>
	<tr>
		<td>Gausa raytec</td>
		<?php for($a=0;$a<11;$a++): ?>
			<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<?php endfor; ?>
	</tr>
	<tr>
		<td>Scalpet Blade</td>
		<?php for($a=0;$a<11;$a++): ?>
			<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<?php endfor; ?>
	</tr>
	<tr>
		<td>Needle Atraumatik</td>
		<?php for($a=0;$a<11;$a++): ?>
			<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<?php endfor; ?>
	</tr>
	<tr>
		<td>Needle ordinary</td>
		<?php for($a=0;$a<11;$a++): ?>
			<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<?php endfor; ?>
	</tr>
	<tr>
		<td>Siringe needle</td>
		<?php for($a=0;$a<11;$a++): ?>
			<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<?php endfor; ?>
	</tr>
	<tr>
		<td>Arteri Klem</td>
		<?php for($a=0;$a<11;$a++): ?>
			<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<?php endfor; ?>
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
  	<script>

		<?php if(isset($_REQUEST["pdf"])): ?>
			const pdf = document.getElementById("pdf-area");
			var opt = {
				margin: 0,
				filename: "RM 21.19 <?=$dataPasien["nama"]?>.pdf",
				image: { type: "JPEG", quality: 1 },
				html2canvas: { scale: 1 },
				jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
			};
		html2pdf().from(pdf).set(opt).save();
		<?php endif; ?>

</script>
</body>

</html>