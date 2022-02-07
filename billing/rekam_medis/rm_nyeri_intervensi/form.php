<?php
	use yii\helpers\Html;
	include '../function/form.php';
	include '../../koneksi/konek.php';
	include 'funct.php';
	$dataPasien = getIndetitasPasien($_REQUEST['idKunj']);
	$i = 1;
	


  if (isset($_REQUEST['id'])) {
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_nyeri_intervensi WHERE id = '{$_REQUEST['id']}'"));
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

      $hasil = mysql_query("UPDATE rm_nyeri_intervensi 
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
			margin-left: 30px;
		}
	</style>
	<script src="../html2pdf/ppdf.js"></script>
	<?php 
if (isset($_REQUEST['cetak'])) {
    $print_mode = true;
    echo "<script>window.print();</script>";
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_nyeri_intervensi WHERE id = '{$_REQUEST['cetak']}'"));

	$arr_data = explode("|", $data['data']);

  }

  if (isset($_REQUEST['pdf'])) {
    $print_mode = true;
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_nyeri_intervensi WHERE id = '{$_REQUEST['pdf']}'"));

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
					
				<div style="float: right">RM 12 / PHCM</div>
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
		<center><h2>ASESMEN NYERI DAN INTERVENSI</h2></center>
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
	<tr class="text-center">
		<th colspan="2">Skor Nyeri</th>
		<th colspan="8">Paser 0-Mc Caffery Opioid-Induced Sedation Scale</th>
		<th colspan="2">Intervensi Non Farmakologi</th>
		<th colspan="5">Pengkajian Ulang</th>
	</tr>
	<tr>
		<td valign="top" colspan="2">
			0       : Tidak ada nyeri   <br>
			1-3   : Nyeri ringan   <br>
			4-6    : Nyeri sedang  <br>
			7-10 : Nyeri berat  
		</td>
		<td valign="top" colspan="8">
			4: Somnolen, minimal/ tidak respon terhadap rangsangan fisik  <br>
			3: Sering mengantuk, bisa dibangunkan, mudah tertidur saat sedang
			     bicara  <br>
			2: Agak mengantuk, mudah dibangunkan  <br>
			1: Bangun dan sadar  <br>
			0: Tidur, mudah dibangunkan 
		</td>
		<td valign="top" colspan="2">
			1.	Kompres dingin / panas  <br>
			2.	Distraksi  <br>
			3.	Posisi  <br>
			4.	Pijat   <br>
			5.	TENS/ fisioterapi  <br>
			6.	Relaksasi & pernafasan
		</td>
		<td valign="top" colspan="5">
			1.	5 menit pengobatan jantung <br>
			2.	15-30 menit setelah intervensi obat injeksi  <br>
			3.	1 jam setelah intervensi obat oral/ lainnya  <br>
			4.	1 x/ shift bila skor nyeri 1-3  <br>
			5.	Setiap 3 jam bila skor nyeri  4-6  <br>
			6.	Setiap jam bila skor nyeri 7-10 <br>
			7.	Dihentikan bila skor nyeri 0  
		</td>
	</tr>
	<tr class="text-center">
		<th rowspan="2">Tgl / Pukul</th>
		<th rowspan="2">Skor Nyeri</th>
		<th rowspan="2">Skor Sedasi</th>
		<th rowspan="2">Tekanan Darah</th>
		<th rowspan="2">Nadi</th>
		<th rowspan="2">Suhu</th>
		<th rowspan="2">Pernapasan</th>
		<th colspan="2">Perawat/Bidan</th>
		<th rowspan="2">Tgl / Pukul</th>
		<th colspan="3">Intervensi Farmakologi</th>
		<th rowspan="2">Intervensi Non Farmakologi</th>
		<th colspan="2">Perawat/Bidan</th>
		<th rowspan="2">Waktu Kaji Ulang</th>
	</tr>
	<tr class="text-center">
		<th>Nama</th>
		<th>Paraf</th>
		<th>Nama Obat</th>
		<th>Dosis & Frekuensi</th>
		<th>Rute</th>
		<th>Nama</th>
		<th>Paraf</th>
	</tr>	
	
	<?php for($a=0;$a<5;$a++): ?>
	<tr>
		<td><?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>&emsp;<?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>&emsp;<?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
		<td><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?></td>
	</tr>
	<?php endfor; ?>

</table>
Keterangan : Bila formulir telah terisi penuh, dapat menggunakan formulir kedua sebagai lanjutan.
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
		function openPrintDialogue(){
			  $('<iframe>', {
			    name: 'myiframe',
			    class: 'printFrame'
			  })
			  .appendTo('body')
			  .contents().find('body')

			  window.frames['myiframe'].focus();
			  window.frames['myiframe'].print();

			  setTimeout(() => { $(".printFrame").remove(); }, 1000);
			};

			<?php if(isset($_REQUEST["pdf"])): ?>
				const pdf = document.getElementById("pdf-area");
				var opt = {
					margin: 0,
					filename:  "RM 12 <?= $dataPasien["nama"] ?> .pdf",
					image: { type: "png", quality: 1 },
					html2canvas: { scale: 1 },
					jsPDF: { unit: "in", format: "letter", orientation: "landscape" }
				};
				html2pdf().from(pdf).set(opt).save();
			<?php endif; ?>
	</script>
</body>

</html>