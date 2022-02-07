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
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_labotarium_patologi WHERE id = '{$_REQUEST['cetak']}'"));
	$arr_data = explode("|", $data['data']);

  }

  if (isset($_REQUEST['pdf'])) {
    $print_mode = true;
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_labotarium_patologi WHERE id = '{$_REQUEST['pdf']}'"));
    $arr_data = explode("|", $data['data']);
}


  if (isset($_REQUEST['id'])) {
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_labotarium_patologi WHERE id = '{$_REQUEST['id']}'"));
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

      $hasil = mysql_query("UPDATE rm_labotarium_patologi 
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
  <script src="../html2pdf/pdf.js"></script>
</head>

<body id="pdf-area">
	<div class="bg-white" style="padding:25px">
		<div class="row">
			<div class="col-6 text-center"><br><br>
				<img src="../logors1.png">
			</div>
			<div class="col-6" style="padding:15px">
					
				<div style="float: right">RM 17.1 / PHCM</div>
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
		<center><h2>LABORATORIUM PATOLOGI</h2></center>
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

<div class="row">
	<div class="col-8">
		Jam : <?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?>
	</div>
	<div class="col-4">
		Belawan, <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?> <br>
		Yth. Ts. <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?> <br>
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
</div>

<div class="text-center"><h3>HASIL PEMERIKSAAN</h3></div>
<br>

<div class="row">
	<div class="col-2 text-center" style="border-top: 1px solid black;border-bottom: 1px solid black;">
		<b>Jenis Pemeriksaan</b><br><br>
	</div>
	<div class="col-2 text-center" style="border-top: 1px solid black;border-bottom: 1px solid black;">
		<b>Hasil</b><br><br>
	</div>
	<div class="col-2 text-center" style="border-top: 1px solid black;border-bottom: 1px solid black;">
		<b>Nilai Normal</b><br><br>
	</div>
	<div class="col-2 text-center" style="border-top: 1px solid black;border-bottom: 1px solid black;border-left: 1px solid black">
		<b>Jenis Pemeriksaan</b><br><br>
	</div>
	<div class="col-2 text-center" style="border-top: 1px solid black;border-bottom: 1px solid black;">
		<b>Hasil</b><br><br>
	</div>
	<div class="col-2 text-center" style="border-top: 1px solid black;border-bottom: 1px solid black;">
		<b>Nilai Normal</b><br><br>
	</div>

	<div class="col-2">
		<u><b>FAAL  HATI</b></u><br>Bilirubin Serum <br>
		Total
	</div>
	<div class="col-2">
		<br><br>
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		<br><br>
		Lk 0,1-1,4/pr 0,1-0,9
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		<u><b>LIPID</b></u><br>Total lipid <br>
		Cholesterol
	</div>
	<div class="col-2">
		<br><br>
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		<br><br>
		< 200 mg%
	</div>

	<div class="col-2">
		Direk
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		0,01 – 0,25 mg%
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		Tryglycerida
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		< 200 mg%
	</div>

	<div class="col-2">
		SGOT
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		10-50 mU/mL
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		HDL
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		>55 mg%
	</div>

	<div class="col-2">
		SGPT
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		10-50 mU/mL
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		LDL
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		< 110 mg %
	</div>

	<div class="col-2">
		Alkali Phospatase
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		15-130 mU/mL
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		&nbsp;
	</div>
	<div class="col-2">
		&nbsp;
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>

	<div class="col-2">
		Total protein
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		6,3 – 8,3 gr%
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		Myocard infact
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>

	<div class="col-2">
		Albumin
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		3,2- 5,2 gr%
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		CPK
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		0 – 80 mU/ml
	</div>

	<div class="col-2">
		Globulin
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		1,9 – 3,2 gr%
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		LDH
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		80 – 240 U/l
	</div>

	<div class="col-2">
		HbsAg
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		Negatif
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		&nbsp;
	</div>
	<div class="col-2">
		&nbsp;
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>

	<div class="col-2">
		<br>
		<u><b>FAAL GINJAL</b></u>
	</div>
	<div class="col-2">
		&nbsp;
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		<br>
		<u><b>THYROID</b></u>
	</div>
	<div class="col-2">
		&nbsp;
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>

	<div class="col-2">
		&nbsp;
	</div>
	<div class="col-2">
		&nbsp;
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		&nbsp;
	</div>
	<div class="col-2">
		&nbsp;
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>

	<div class="col-2">
		Ureum Darah
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		< 71 mg%
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		T3
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		0,58–1,59 ng/ml
	</div>

	<div class="col-2">
		Creatinin darah
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		0,5 – 1,2 mg%
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		T4
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		4,87– 11,7 ng/dl
	</div>

	<div class="col-2">
		Uric Acid
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		Lk 3,0 – 7,0 / pr 3,0-6,0 
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		TsHs
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		0,350--4,94 uIU/ml
	</div>

	<div class="col-2">
		ASTO
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		Negatif < 200
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		<b><u>GULA DARAH</u></b>
	</div>
	<div class="col-2">
		&nbsp;
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>

	<div class="col-2">
		&nbsp;
	</div>
	<div class="col-2">
		&nbsp;
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		&nbsp;
	</div>
	<div class="col-2">
		&nbsp;
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>

	<div class="col-2">
		RF
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		Negatif
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		Puasa 
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		50-120 mg%
	</div>

	<div class="col-2">
		&nbsp;
	</div>
	<div class="col-2">
		&nbsp;
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		2 Jam PP 
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		50-120 mg%
	</div>

	<div class="col-2">
		<b><u>ELEKTROLIT DARAH</u></b>
	</div>
	<div class="col-2">
		&nbsp;
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		Adrandom
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		< 160 mg %
	</div>

	<div class="col-2">
		Natrium 
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		136 – 155 MEq/l
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		HbA1C
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		< 6,5 %
	</div>

	<div class="col-2">
		Kalium 
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		3,5 – 5,5 MEq/l
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		Tubex
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		Negatif
	</div>

	<div class="col-2">
		Chlorida  
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		95 – 103 MEq/l
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		&nbsp;
	</div>
	<div class="col-2">
		&nbsp;
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>

	<div class="col-2">
		VDRL 
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		Non Reaktif
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		HIV
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		Negatif
	</div>

	<div class="col-1" style="border-top: 1px solid black;border-bottom: 1px solid black">
		Kesan : 
	</div>

	<div class="col-11" style="border-top: 1px solid black;border-bottom: 1px solid black">
		<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>
	</div>
	<div class="col-12"><br><br></div>

	<div class="col-4 text-center">
		Penanggung Jawab
		<br><br><br><br><br><br>
		( dr. Muzahar Sp.PK )
	</div>

	<div class="col-4 text-center">
		Dokter DPJP
		<br><br><br><br><br><br>
		( <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?> )
	</div>

	<div class="col-4 text-center">
		Pemeriksa
		<br><br><br><br><br><br>
		( <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?> )
	</div>

</div>
<div class="foot" style="text-align: right"><img style="width: 350px" class="text-right" src="../../images/alamat.jpg"></div>

<br>

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
		<center><h2>LABORATORIUM PATOLOGI</h2></center>

<div class="row">
	<div class="col-8">
		Jam : <?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?>
	</div>
	<div class="col-4">
		Belawan, <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?> <br>
		Yth. Ts. <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?> <br>
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
</div>

<div class="text-center"><h3>HASIL PEMERIKSAAN</h3></div>
<br>

<div class="row">

	<div class="col-2 text-center" style="border-top: 1px solid black;border-bottom: 1px solid black;">
		<b>Jenis Pemeriksaan</b><br><br>
	</div>
	<div class="col-2 text-center" style="border-top: 1px solid black;border-bottom: 1px solid black;">
		<b>Hasil</b><br><br>
	</div>
	<div class="col-2 text-center" style="border-top: 1px solid black;border-bottom: 1px solid black;">
		<b>Nilai Normal</b><br><br>
	</div>
	<div class="col-2 text-center" style="border-top: 1px solid black;border-bottom: 1px solid black;border-left: 1px solid black">
		<b>Jenis Pemeriksaan</b><br><br>
	</div>
	<div class="col-2 text-center" style="border-top: 1px solid black;border-bottom: 1px solid black;">
		<b>Hasil</b><br><br>
	</div>
	<div class="col-2 text-center" style="border-top: 1px solid black;border-bottom: 1px solid black;">
		<b>Nilai Normal</b><br><br>
	</div>

	<div class="col-2" >
		<b><u>DARAH RUTIN</u></b>
	</div>
	<div class="col-2" >
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		<b><u>URINE RUTIN</u></b>
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>

	<div class="col-2" >
		&nbsp;
	</div>
	<div class="col-2" >
		&nbsp;
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		&nbsp;
	</div>
	<div class="col-2">
		&nbsp;
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>

	<div class="col-2" >
		Haemoglobin
	</div>
	<div class="col-2" >
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		Lk. 14-18 / pr.12-16 gr%
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		Warna 
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>

	<div class="col-2" >
		LED Westergen 
	</div>
	<div class="col-2" >
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		Lk. 10 / pr. 15
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		Reaksi pH
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		4,8 – 7,8 
	</div>

	<div class="col-2" >
		Leukosit
	</div>
	<div class="col-2" >
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		4.000-10.000
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		Protein Kualitatif
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		Negatif
	</div>

	<div class="col-2" >
		Erytrosit
	</div>
	<div class="col-2" >
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		Lk. 4,5 – 5 jt / pr. 4 -5 jt
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		Reduiksi
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		Negatif
	</div>

	<div class="col-2" >
		Thrombosit
	</div>
	<div class="col-2" >
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		100.000 – 300.000
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		Bilirubin
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		Negatif
	</div>

	<div class="col-2" >
		Hitung Jenis
	</div>
	<div class="col-2" >
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		Nitrit
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		Negatif
	</div>

	<div class="col-2" >
		&emsp;Eosinophil
	</div>
	<div class="col-2" >
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		1 – 6 %
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		Urobilinogen
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		Negatif
	</div>

	<div class="col-2" >
		&emsp;Basophil
	</div>
	<div class="col-2" >
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		0 – 1 %
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		Sedimen
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>

	<div class="col-2" >
		&emsp;Neurophil 
	</div>
	<div class="col-2" >
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		0 – 2 %
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		Erytrosit
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		0 – 2 / lpb
	</div>

	<div class="col-2" >
		&emsp;Batang 
	</div>
	<div class="col-2" >
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		&nbsp;
	</div>
	<div class="col-2">
		&nbsp;
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>

	<div class="col-2" >
		&emsp;Neutrophil  
	</div>
	<div class="col-2" >
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		20 – 60 %
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		Leukosit
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		0 – 5  / lpb
	</div>

	<div class="col-2" >
		&emsp;Segmen  
	</div>
	<div class="col-2" >
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		&nbsp;
	</div>
	<div class="col-2">
		&nbsp;
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>

	<div class="col-2" >
		&emsp;Limfosit  
	</div>
	<div class="col-2" >
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		20 – 40 %
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		Epitel
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>

	<div class="col-2" >
		&emsp;Monosit  
	</div>
	<div class="col-2" >
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		2 – 6 %
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		Kristal
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>

	<div class="col-2" >
		Hematokrit
	</div>
	<div class="col-2" >
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		<b><u>SYLINDER</u></b>
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>

	<div class="col-2" >
		Malaria
	</div>
	<div class="col-2" >
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		Negatif
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		Planotest
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>

	<div class="col-2" >
		Golongan darah
	</div>
	<div class="col-2" >
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		Diplococcus
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>

	<div class="col-2" >
		Morfologi
	</div>
	<div class="col-2" >
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		Lain-lain
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>

	<div class="col-2" >
		&emsp;Erytrosit
	</div>
	<div class="col-2" >
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		&nbsp;
	</div>
	<div class="col-2">
		&nbsp;
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>

	<div class="col-2" >
		&emsp;Leukosit
	</div>
	<div class="col-2" >
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		<b><u>FAECES RUTIN</u></b>
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>

	<div class="col-2" >
		&emsp;Thrombosit
	</div>
	<div class="col-2" >
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		Mikroskopis 
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>

	<div class="col-2" >
		<b><u>Serum Iron</u></b>
	</div>
	<div class="col-2" >
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		37 --158   Pg%
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		Erytrosit  
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>

	<div class="col-2" >
		TIBC
	</div>
	<div class="col-2" >
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		300 – 400 pg %
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		Leukosit  
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>

	<div class="col-2" >
		Bleeding Time
	</div>
	<div class="col-2" >
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		Egg: Asc  
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>

	<div class="col-2" >
		Cloting time
	</div>
	<div class="col-2" >
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		&emsp;Anky
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>

	<div class="col-2" >
		&nbsp;
	</div>
	<div class="col-2" >
		&nbsp;
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		&emsp;T.T.
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>

	<div class="col-2" >
		WIDAL  Thpy o
	</div>
	<div class="col-2" >
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		Amoeba
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>

	<div class="col-2" >
		&emsp;&emsp;&emsp;&nbsp;Thpy h
	</div>
	<div class="col-2" >
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		Sputum
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		&nbsp;
	</div>

	<div class="col-2" >
		Adrandom
	</div>
	<div class="col-2" >
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		Mg %
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		HbA1C
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		< 6,5 %
	</div>

	<div class="col-2" >
		Tubex
	</div>
	<div class="col-2" >
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		Negatif
	</div>
	<div class="col-2" style="border-left: 1px solid black">
		&emsp;Narkoba
	</div>
	<div class="col-2">
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?>
	</div>
	<div class="col-2 text-center">
		Negatif
	</div>

	<div class="col-1" style="border-top: 1px solid black;border-bottom: 1px solid black">
		Kesan : 
	</div>

	<div class="col-11" style="border-top: 1px solid black;border-bottom: 1px solid black">
		<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?>
	</div>
	<div class="col-12"><br><br></div>

	<div class="col-4 text-center">
		Penanggung Jawab
		<br><br><br><br><br><br>
		( dr. Muzahar Sp.PK )
	</div>

	<div class="col-4 text-center">
		Dokter DPJP
		<br><br><br><br><br><br>
		( <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?> )
	</div>

	<div class="col-4 text-center">
		Pemeriksa
		<br><br><br><br><br><br>
		( <?=input($arr_data[$i-1], "data_{$i}", "text", "", "height:20px;", "");$i++;?> )
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
<div style="text-align: right"><img style="width: 350px" class="text-right" src="../../images/alamat.jpg"></div>

	<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery-1.9.1.js"></script>
	<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery.form.js"></script>
    <script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>
    <script type="text/javascript" src="../../theme/js/ajax.js"></script>
	<script src="../../theme/bs/bootstrap.min.js"></script>	
	<script>
		<?php if (isset($_REQUEST["pdf"])): ?>
			let identifier = '<?=$dataPasien['nama']?>';
			printPDF('RM 17.1 '+identifier);
		<?php endif; ?>
	</script>
</body>

</html>