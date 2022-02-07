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
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_identitas_pasien WHERE id = '{$_REQUEST['cetak']}'"));

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
    echo '';
    $print_mode = true;
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_identitas_pasien WHERE id = '{$_REQUEST['pdf']}'"));
	
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
		.bordered{
			border: 1px solid black;
		}
		@media print {
			.prints {
				display:none;
			}
		}
	</style>
	<script src="../html2pdf/ppdf.js"></script>
	<script src="../html2pdf/pdf.js"></script>
	
</head>

<body style="padding:20px" id="pdf-area">

	<div class="bg-white" style="padding:25px">
		<div class="row">
			<div class="col-6 text-center"><br><br>
				<img src="../logors1.png">
			</div>
			<div class="col-6" style="padding:15px">
					
				<div style="float: right">RM 1 / PHCM</div>
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
									<?php if ($dataPasien["sex"] == "L"): ?>
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
		<center><h2>IDENTITAS PASIEN</h4></center>
		<div>
<?php if (isset($_REQUEST['id'])): ?>
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
		<td>
			NAMA	: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?><br><br>
			JENIS KELAMIN		: 	
										<input type="checkbox" checked="checked" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lk &emsp;
										<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pr<br><br>
			TANGGAL Lahir		: <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "id='tgl_lahir' onchange='getAge()'");$i++;?><br><br>
			UMUR			: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:60px", "id='umur'");$i++;?>	Thn<br><br>
			PEKERJAAN			: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?><br><br>
			STATUS PERKAWINAN <br>
			<div class="row">
				<div class="col-4">
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> KAWIN <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> JANDA
				</div>
				<div class="col-4">
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> BELUM                 <br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> DUDA    
				</div>
				<div class="col-4">
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TIDAK KAWIN
				</div>
			</div>
			<br><br>
			ALAMAT <br><?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?><br><br>
			KELURAHAN/DESA	: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?><br><br>
			PROVINSI	: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?><br><br>
			SUKU/BANGSA	:
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> WNI &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> WNA<br><br>
			RT/RW : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?><br><br>
			KODE POS : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>
			<br>
		</td>
		<td rowspan="2" align="top">
			NO.RM : <span class="bordered">&nbsp;<?=$dataPasien["no_rm"][0]?>&nbsp;</span>
					<span class="bordered">&nbsp;<?=$dataPasien["no_rm"][1]?>&nbsp;</span>
					<span class="bordered">&nbsp;<?=$dataPasien["no_rm"][2]?>&nbsp;</span>
					<span class="bordered">&nbsp;<?=$dataPasien["no_rm"][3]?>&nbsp;</span>
					<span class="bordered">&nbsp;<?=$dataPasien["no_rm"][4]?>&nbsp;</span>
					<span class="bordered">&nbsp;<?=$dataPasien["no_rm"][5]?>&nbsp;</span>
					<span class="bordered">&nbsp;<?=$dataPasien["no_rm"][6]?>&nbsp;</span>
					<span class="bordered">&nbsp;<?=$dataPasien["no_rm"][7]?>&nbsp;</span><br><br>

			AGAMA : <div class="row">
						<div class="col-4">
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> ISLAM <br>
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> HINDU
						</div>
						<div class="col-4">
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> PROSTESTAN         <br>
							<input <?php if ($arr_data[$i-1] == 'BUDDHA') {
                echo "checked";
            };?> type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> BUDDHA
						</div>
						<div class="col-4">
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> KATOLIK         <br>
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> LAIN-LAIN
						</div>
					</div><br><br>
			PENDIDIKAN : 

			<div class="row">
						<div class="col-4">
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> SD <br>
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> D3
						</div>
						<div class="col-4">
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> SMP         <br>
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> S1
						</div>
						<div class="col-4">
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> SMA/SMK         <br>
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> DLL
						</div>
					</div><br><br>

					JENIS JAMINAN : <div class="row">
						<div class="col-4">
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> UMUM          <br>
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> PENSIUNAN          
						</div>
						<div class="col-4">
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> BPJS                   <br>
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> DLL
						</div>
						<div class="col-4">
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />          ASTEK     
						</div>
					</div><br><br>

					TANGGAL MASUK : <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>&emsp;
					PUKUL : <?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?><br>
					KELAS / RUANGAN :   <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> / 
					<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?><br><br>
					CARA MASUK : <div class="row">
						<div class="col-6">
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> DATANG SENDIRI <br>
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> PUSKESMAS <br>
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> RUMAH SAKIT LAIN
						</div>
						<div class="col-6">
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> BIDAN <br>
							<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> DOKTER       
						</div>
					</div><br><br>
					TANGGAL KELUAR: <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>&emsp;
					PUKUL <?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?> <br><br>
					LAMA DIRAWAT : <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> HARI <br><br>
					Dokter yang menerima : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>
					Dokter yang merawat  : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>	
		</td>
	</tr>
	<tr>
		<td>
			NAMA PENANGGUNG JAWAB :	<br> <?=input($arr_data['$i-1'], "data_{$i}", "text", "form-control", "", "");$i++;?><br>
			PEKERJAAN : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?><br>
			ALAMAT : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?><br>
			NO.TELEPON  : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>
		</td>
	</tr>
	<tr>
		<td rowspan="2">
			DIAGNOSA MASUK <br><br><br><br><br><br><br>
		</td>
		<td>
			<div class="row">
				<div class="col-6">
					UTAMA : <?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?>
				</div>
				<div class="col-6">
					KODE ICD 10 :  <?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?>
				</div>
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<div class="row">
				<div class="col-6">
					SEKUNDER : <?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?>
				</div>
				<div class="col-6">
					KODE ICD 10 :  <?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?>
				</div>
			</div>
		</td>
	</tr>
	<tr>
		<td rowspan="2">
			DIAGNOSA AKHIR <br><br><br><br><br><br><br>
		</td>
		<td>
			<div class="row">
				<div class="col-6">
					UTAMA : <?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?>
				</div>
				<div class="col-6">
					KODE ICD 10 :  <?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?>
				</div>
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<div class="row">
				<div class="col-6">
					SEKUNDER : <?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?>
				</div>
				<div class="col-6">
					KODE ICD 10 :  <?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?>
				</div>
			</div>
		</td>
	</tr>
	<tr>
		<td>
			TINDAKAN /OPERASI <br><br><br><br><br><br><br>
		</td>
		<td>
			<div class="row">
				<div class="col-6">
					1. <?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?> <br>
					2. <?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?>
				</div>
				<div class="col-6">
					KODE ICD 9 :  <?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "", "");$i++;?>
				</div>
			</div>
		</td>
	</tr>
	</table>
			<b>
				<table border="1px" width="100%">
					<tr>
						<td>
							Keadaankeluar <br>
						1.	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sembuh <br>
						2.	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Belumsembuh <br>
						3.	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Cacat <br>
						4.	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Mati < 24 jam <br>
						5.	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Mati < 448 jam
						</td>
						<td>
							Cara keluar <br>
                        1. <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pulang atas perintah dokter <br>
                        2. <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pulang atas permintaan sendiri <br>
                        3. <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pindah RS lain <br>
                        4. <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kabur
						</td>
						<td>
							TRANSFUSI DARAH <br>
						1.	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> YA <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> CC <br>
						2.	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TIDAK <br><br><br><br>
						</td>
					</tr>
				</table>
			</b>                                                                    
<br>
<input type="hidden" name="i" value="<?=$i;?>">
<?php if (isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])): ?>
	&nbsp;
<?php elseif (isset($_REQUEST['id'])): ?>
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
	<script type="text/javascript">
	function getAge() {
	    var today = new Date();
	    var birthDate = new Date($('#tgl_lahir').val());
	    var age = today.getFullYear() - birthDate.getFullYear();
	    var m = today.getMonth() - birthDate.getMonth();
	    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
	        age--;
    	}
    	$('#umur').val(age);
	}
	<?php if(isset($_REQUEST["pdf"])): ?>
		let identifier = '<?=$dataPasien["nama"]?>';
		printPDF('RM 1 '+identifier);
	<?php endif; ?>

	</script>
</body>

</html>