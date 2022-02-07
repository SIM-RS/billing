<?php
	use yii\helpers\Html;
	include '../function/form.php';
	include '../../koneksi/konek.php';
	include 'funct.php';
	$dataPasien = getIndetitasPasien($_REQUEST['idKunj']);
	$i = 1;
	


  if (isset($_REQUEST['id'])) {
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_monitoring_dan_evaluasi_jatuh WHERE id = '{$_REQUEST['id']}'"));
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

      $hasil = mysql_query("UPDATE rm_monitoring_dan_evaluasi_jatuh 
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
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_monitoring_dan_evaluasi_jatuh WHERE id = '{$_REQUEST['cetak']}'"));

	$arr_data = explode("|", $data['data']);

  }

    if (isset($_REQUEST['pdf'])) {
      $print_mode = true;
      $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_monitoring_dan_evaluasi_jatuh WHERE id = '{$_REQUEST['pdf']}'"));
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
					
				<div style="float: right">RM 5.2.2 & RM 5.2.3 / PHCM</div>
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
		<center><h2> LEMBAR  MONITORING DAN EVALUASI  PENCEGAHAN PASIEN JATUH</h2></center>
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

<table width="100%" border="1" style="font-size: 12px">
	<tr>
		<td colspan="2"></td>
		<td colspan="2">Tanggal <?=input($arr_data[$i-1], "data_{$i}", "date", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "date", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "date", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "date", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "date", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "date", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "date", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "date", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "date", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "date", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "date", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "date", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "date", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "date", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "date", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "date", "form-control", "", "");$i++;?></td>
	</tr>
	<tr>
		<td colspan="2"></td>
		<td class="text-center">Kode</td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
	</tr>
	<tr>
		<td colspan="2">Beri tanda cek (√) pada tindakan yang dilakukan</td>
		<td class="text-center">
			&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
			<center>Jam</center>
			&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
		</td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "time", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "time", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "time", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "time", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "time", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "time", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "time", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "time", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "time", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "time", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "time", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "time", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "time", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "time", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "time", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "time", "form-control", "", "");$i++;?></td>
	</tr>
	<tr>
		<th class="text-center">TR</th>
		<th>INTERVENSI JATUH TIDAK RISIKO /STANDAR</th>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
	</tr>
	<tr>
		<td class="text-center">1</td>
		<td>Tingkatkan observasi bantuan yang sesuai saat ambulasi</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
	</tr>
	<tr>
		<td class="text-center">2</td>
		<td>Orientasikan pasien terhadap lingkungan dan rutinitas RS:</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
	</tr>
	<tr>
		<th></th>
		<td>a. Tunjukkan lokasi kamar mandi</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
	</tr>
	<tr>
		<th></th>
		<td>b. Biarkan pintu terbuka</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
	</tr>
	<tr>
		<th></th>
		<td>c. Instruksikan meminta bantuan perawat sebelum turun dari tempat tidur</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
	</tr>
	<tr>
		<td class="text-center">3</td>
		<td>Pagar pengaman tempat tidur dinaikkan</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
	</tr>
	<tr>
		<td class="text-center">4</td>
		<td>Tempat tidur dalam posisi rendah terkunci.</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
	</tr>
	<tr>
		<td class="text-center">5</td>
		<td>Edukasi perilaku yang lebih aman saat jatuh atau transfer</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
	</tr>
	<tr>
		<td class="text-center">6</td>
		<td>Monitor kebutuhan pasien secara berkala (minimalnya tiap 2 jam)</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
	</tr>
	<tr>
		<td class="text-center">7</td>
		<td>Anjurkan pasien tidak menggunakan kaus kaki atau sepatu yang licin</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
	</tr>
	<tr>
		<td class="text-center">8</td>
		<td>Lantai kamar mandi dengan karpet antislip, tidak licin</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
	</tr>
	<tr>
		<th class="text-center">RR</th>
		<th>INTERVENSI JATUH RISIKO RENDAH</th>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
	</tr>
	<tr>
		<td class="text-center">1</td>
		<td>Lakukan <b>SEMUA</b> intervensi jatuh tidak risiko/standar</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
	</tr>
	<tr>
		<td class="text-center">2</td>
		<td>Pakailah gelang risiko jatuh berwarna kuning</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
	</tr>
	<tr>
		<td class="text-center">3</td>
		<td>Pasang gambar risiko jatuh diatas tempat tidur pasien dan pada pintu kamar pasien</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
	</tr>
	<tr>
		<td class="text-center">4</td>
		<td>Tempatkan tanda risiko pasien jatuh pada daftar nama pasein (warna kuning)</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
	</tr>
	<tr>
		<td class="text-center">5</td>
		<td>Dorong partisipasi keluarga dalam keselamatan pasien</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
	</tr>
	<tr>
		<td class="text-center">5</td>
		<td>Dorong partisipasi keluarga dalam keselamatan pasien</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
	</tr>
	<tr>
		<th class="text-center">RT</th>
		<th>INTERVENSI JATUH RISIKO TINGGI</th>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
	</tr>
	<tr>
		<td class="text-center">1</td>
		<td>Lakukan SEMUA intervensi jatuh tidak risiko / standar dan risiko rendah</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
	</tr>
	<tr>
		<td class="text-center">2</td>
		<td>Jangan tinggalkan pasien saat di ruangan diagnostic atau tindakan</td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
	</tr>
	<tr>
		<td class="text-center">3</td>
		<td>Penempatan pasien dekat nurse station untuk memudahkan observasi (24-48 jam)  </td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
		<td><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
	</tr>
	<tr>
		<th class="text-right" colspan="2" rowspan="2">Nama Perawat <br> Paraf</th>
		<td colspan="17"><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
	</tr>
	<tr>
		<td colspan="17"><?=area($arr_data[$i-1], "data_{$i}", "form-control", "", "");$i++;?></td>
	</tr>
</table><br>
CATATAN <br>
1. <b>TR</b> ( Intervensi setiap pagi dan dinilai ulang tiap 3 hari) <br>
2. <b>RR</b> ( Intervensi setiap pagi dan dinilai ulang setiap 3 hari) <br>
3. <b>TR</b> (Intervensi setiap shif dan dinilai ulang setiap 2 hari) <br>



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
			// printPDF('RM 5.2.2 & 5.2.3 '+identifier);

			const pdf = document.getElementById("pdf-area");
			var opt = {
				margin: 0,
				filename: name + ".pdf",
				image: { type: "png", quality: 1 },
				html2canvas: { scale: 1 },
				jsPDF: { unit: "in", format: "letter", orientation: "landscape" }
			};
			html2pdf().from(pdf).set(opt).save();
	
		<?php endif; ?> 
	  </script>
</body>

</html>