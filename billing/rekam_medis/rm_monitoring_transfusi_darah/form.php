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
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_monitoring_transfusi_darah WHERE id = '{$_REQUEST['cetak']}'"));

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
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_monitoring_transfusi_darah WHERE id = '{$_REQUEST['pdf']}'"));

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
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_monitoring_transfusi_darah WHERE id = '{$_REQUEST['id']}'"));
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

      $hasil = mysql_query("UPDATE rm_monitoring_transfusi_darah 
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
	<script src="../html2pdf/pdf.js"></script>
</head>

<body id="pdf-area">

	<div class="bg-white" style="padding: 10px">
		<div class="row">

				<div class="col-6 text-center"><br><br><br><br>
				<img src="../logors1.png">
			</div>
			<div class="col-6" style="padding:40px">
				<div style="float: right">RM 24.2 / PHCM</div>
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
		<h4 class="text-center">MONITORING TRANSFUSI DARAH / PRODUK DARAH</h4><br>
	
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
	
	<div class="row">
		<div class="col-6">
			<div class="row">
				<div class="col-6">Identitas pasien</div>
				<div class="col-6">: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:90%");$i++;?></div>

				<div class="col-6">Nomor kantong</div>
				<div class="col-6">: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "height:20px;width:90%");$i++;?></div>

				<div class="col-6">Golongan Darah</div>
				<div class="col-6">: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:90%");$i++;?></div>

				<div class="col-6">Jenis Darah/komponen</div>
				<div class="col-6">: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:90%");$i++;?></div>

				<div class="col-6">Tanggal Kadaluarsa</div>
				<div class="col-6">: <?=input($arr_data[$i-1], "data_{$i}", "date", "", "width:90%");$i++;?></div>
			</div>
		</div>
		<div class="col-6">
			<div class="row">
				<div class="col-12"><b><u>Petugas</u> Unit Pelayanan <u>Darah RS</u></b></div>
				<div class="col-6">Nama & tandatangan</div>
				<div class="col-6">: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:90%");$i++;?></div>

				<div class="col-6">Waktu penyerahan (tanggal & jam)</div>
				<div class="col-6">: <?=input($arr_data[$i-1], "data_{$i}", "date", "", "width:40%");$i++;?> & <?=input($arr_data[$i-1], "data_{$i}", "time", "", "width:40%");$i++;?></div>

				<div class="col-12"><b><u>Penerima Darah</u></b></div>
				<div class="col-6">Nama & tandatangan</div>
				<div class="col-6">: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;width:90%");$i++;?></div>

				<div class="col-6">Waktu penyerahan (tanggal & jam)</div>
				<div class="col-6">: <?=input($arr_data[$i-1], "data_{$i}", "date", "", "width:40%");$i++;?> & <?=input($arr_data[$i-1], "data_{$i}", "time", "", "width:40%");$i++;?></div>
			</div>
		</div>
	</div>

	<table border="1px" width="100%">
		<tr class="text-center">
			<th>KONDISI</th>
			<th width="20%">SEBELUM TRANSFUSI <br>(<?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?> WIB)</th>
			<th width="20%">15–30 menit TRANSFUSI <br>(<?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?> WIB)</th>
			<th width="20%">2 jam TRANSFUSI <br>(<?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?> WIB)</th>
			<th width="20%">PASCA TRANSFUSI <br>(<?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?> WIB)</th>
		</tr>
		<tr>
			<td>Keadaan umum <br> Suhu tubuh</td>
			<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?>
			<?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
			<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?>
			<?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
			<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?>
			<?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
			<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?>
			<?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
		</tr>
		<tr>
			<td>Nadi</td>
			<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
			<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
			<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
			<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
		</tr>
		<tr>
			<td>Tekanan darah</td>
			<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
			<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
			<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
			<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
		</tr>
		<tr>
			<td>Respiratory rate</td>
			<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
			<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
			<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
			<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
		</tr>
		<tr>
			<td>Volume & warna urin</td>
			<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
			<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
			<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
			<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
		</tr>
		<tr>
			<td rowspan="3">Gejala & tanda reaksi transfusi yang ditemukan *)</td>
			<td>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> urtikaria	&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> nyeri dada
			</td>
			<td>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> urtikaria	&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> nyeri dada
			</td>
			<td>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> urtikaria	&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> nyeri dada
			</td>
			<td>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> urtikaria	&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> nyeri dada
			</td>
		</tr>
		<tr>
			<td>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> demam	&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> nyeri kepala
			</td>
			<td>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> demam	&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> nyeri kepala
			</td>
			<td>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> demam	&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> nyeri kepala
			</td>
			<td>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> demam	&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> nyeri kepala
			</td>
		</tr>
		<tr>
			<td>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> gatal	&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Syok**
			</td>
			<td>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> gatal	&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Syok**
			</td>
			<td>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> gatal	&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Syok**
			</td>
			<td>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> gatal	&emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Syok**
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> takikardi &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> sesak napas** <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> hematuria/ Hemoglobinuria**
			</td>
			<td>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> takikardi &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> sesak napas** <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> hematuria/ Hemoglobinuria**
			</td>
			<td>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> takikardi &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> sesak napas** <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> hematuria/ Hemoglobinuria**
			</td>
			<td>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> takikardi &emsp;
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> sesak napas** <br>
				<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> hematuria/ Hemoglobinuria**
			</td>
		</tr>
	</table><br>

	<div class="row">
		<div class="col-4"><u>Nama Perawat yang melakukan transfusi </u>(double check) :</div>
		<div class="col-6">
			1. <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> 
			(<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>) <br>
			2. <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> 
			(<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>)
		</div>
	</div>

*) Lingkari gejala yg ditemukan.     <br>      
**)mengikuti SPO pelaporan reaksi transfusi
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
			printPDF('RM 24.2 '+identifier);
		<?php endif; ?>

	</script>
</body>

</html>