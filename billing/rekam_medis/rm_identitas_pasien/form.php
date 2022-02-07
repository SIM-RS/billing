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
				kun.tgl as tgl_msk,
				kun.tgl_pulang as tgl_klr,
				pk.nama as pekerjaan,
				kso.nama as jamin,
				kmr.nama as kmr,
				klss.nama as kelas,
				kw.nama as kewarganegaraan 
			FROM
				b_ms_pasien pa 
				LEFT JOIN b_kunjungan as kun ON kun.id = " . $_REQUEST['idKunj'] . "
				LEFT JOIN b_ms_agama as agama ON agama.id = pa.agama
				LEFT JOIN b_ms_kso AS kso ON kso.id = kun.kso_id
				LEFT JOIN b_ms_kso_kelas AS kls ON kls.id = kun.kso_kelas_id
				LEFT JOIN b_ms_kelas AS klss ON klss.id = kls.b_ms_kelas_id
				LEFT JOIN b_ms_pekerjaan as pk ON pk.id = pa.pekerjaan_id
				LEFT JOIN b_ms_kewarganegaraan as kw ON kw.id = pa.id_kw
				LEFT JOIN b_tindakan_kamar as tkmr ON tkmr.pelayanan_id = ".$_REQUEST['idPel']."
				LEFT JOIN b_ms_kamar as kmr ON kmr.id = tkmr.kamar_id
			WHERE
				pa.id = {$dataPasien['id']}";
			
		$dataP = mysql_fetch_assoc(mysql_query($sql));
	
        
		function queryHome($id) {
            return mysql_fetch_assoc(mysql_query("SELECT nama FROM b_ms_wilayah WHERE id = '$id'"));
		}

		$jam_klr = explode(" ", $dataP["tgl_klr"]);

		$datetime1 = new DateTime($dataP["tgl_klr"]);
		$datetime2 = new DateTime($dataP["tgl_msk"]);
		$difference = $datetime1->diff($datetime2);

		// var_dump($dataP["kelas"]);

if (isset($_REQUEST['cetak'])) {
	header("Location:print.php?cetak=" . $_REQUEST['cetak'] . "&idKunj=" . $_REQUEST['idKunj']);
}

if (isset($_REQUEST['pdf'])) {
	header("Location:print.php?pdf=" . $_REQUEST['pdf'] . "&idKunj=" . $_REQUEST['idKunj']);
}

  if (isset($_REQUEST['id'])) {
    echo "<script>window.location.href='edit.php?id=".$_REQUEST['id']."&idKunj=".$_REQUEST['idKunj']."&idPel=".$_REQUEST['idPel']."&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['idUser']."&tmpLay=".$_REQUEST['tmpLay']."'</script>";
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

      $hasil = mysql_query("UPDATE rm_identitas_pasien 
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
  $dataMsk = explode(" ", $dataP['tgl_act']);
  $tgl_msk = $dataMsk[0];
  $pkl_msk = $dataMsk[1];
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
	</style>
</head>

<body style="padding:20px">
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
		<center><h2>IDENTITAS PASIEN</h4></center>
		<div>
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
		<td>
			NAMA	: <?=input($dataP['nama'], "data_{$i}", "text", "", "", "");$i++;?><br><br>
			JENIS KELAMIN		: 	<?php if($dataP['sex'] == 'L'): ?>
										<input type="checkbox" checked="checked" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lk &emsp;
										<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pr
									<?php else: ?>
										<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lk&emsp;
										<input checked="checked" type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pr
									<?php endif; ?><br><br>
			TANGGAL Lahir		: <?=input($dataP['tgl_lahir'], "data_{$i}", "date", "", "", "id='tgl_lahir' onchange='getAge()'");$i++;?><br><br>
			UMUR			: <?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:60px", "id='umur'");$i++;?>	Thn<br><br>
			PEKERJAAN			: <?=input($dataP['pekerjaan'], "data_{$i}", "text", "", "", "");$i++;?><br><br>
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
			ALAMAT <br><?=area($dataP['alamat'], "data_{$i}", "form-control");$i++;?><br><br>
			KELURAHAN/DESA	: <?=input(queryHome($dataP['desa_id'])["nama"], "data_{$i}", "text", "", "", "");$i++;?><br><br>
			PROVINSI	: <?=input(queryHome($dataP['prop_id'])["nama"], "data_{$i}", "text", "", "", "");$i++;?><br><br>
			SUKU/BANGSA	: <?php if($dataP['kewarganegaraan'] == 'INDONESIA'): ?>
					<input checked="checked" type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> WNI &emsp;
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> WNA
					<?php else: ?>
						<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> WNI &emsp;
					<input checked="checked" type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> WNA
						<?php endif; ?><br><br>
			RT/RW : <?=input($dataP['rt'] ." / ". $dataP['rw'], "data_{$i}", "text", "", "", "");$i++;?><br><br>
			KODE POS : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>
			<br>
		</td>
		<td rowspan="2">
			NO.RM : <span class="bordered">&nbsp;<?=$dataP['no_rm'][0]?>&nbsp;</span>
					<span class="bordered">&nbsp;<?=$dataP['no_rm'][1]?>&nbsp;</span>
					<span class="bordered">&nbsp;<?=$dataP['no_rm'][2]?>&nbsp;</span>
					<span class="bordered">&nbsp;<?=$dataP['no_rm'][3]?>&nbsp;</span>
					<span class="bordered">&nbsp;<?=$dataP['no_rm'][4]?>&nbsp;</span>
					<span class="bordered">&nbsp;<?=$dataP['no_rm'][5]?>&nbsp;</span>
					<span class="bordered">&nbsp;<?=$dataP['no_rm'][6]?>&nbsp;</span>
					<span class="bordered">&nbsp;<?=$dataP['no_rm'][7]?>&nbsp;</span><br><br>

			AGAMA : <div class="row">
						<div class="col-4">
							<input <?php if($dataP['agama'] == 'ISLAM'){echo "checked";};?> type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> ISLAM <br>
							<input <?php if($dataP['agama'] == 'HINDU'){echo "checked";};?> type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> HINDU
						</div>
						<div class="col-4">
							<input <?php if($dataP['agama'] == 'PROSTESTAN'){echo "checked";};?> type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> PROSTESTAN         <br>
							<input <?php if($dataP['agama'] == 'BUDDHA'){echo "checked";};?> type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> BUDDHA
						</div>
						<div class="col-4">
							<input <?php if($dataP['agama'] == 'KATOLIK'){echo "checked";};?> type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> KATOLIK         <br>
							<input <?php if($dataP['agama'] != 'ISLAM' && 'HINDU' && 'PROSTESTAN' && 'BUDDHA' && 'KATOLIK'){echo "checked";};?> type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> LAIN-LAIN
						</div>
					</div><br><br>
			PENDIDIKAN : 

			<div class="row">
				<div class="col-4">
							<input <?php if($dataP['pendidikan_id'] == '2'){echo "checked";};?> type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> SD <br>
							<input <?php if($dataP['pendidikan_id'] == '7'){echo "checked";};?> type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> D3
						</div>
						<div class="col-4">
							<input <?php if($dataP['pendidikan_id'] == '4'){echo "checked";};?> type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> SMP         <br>
							<input <?php if($dataP['pendidikan_id'] == '8'){echo "checked";};?> type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> S1
						</div>
						<div class="col-4">
							<input <?php if($dataP['pendidikan_id'] == '5'){echo "checked";};?> type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> SMA/SMK         <br>
							<input <?php if($dataP['pendidikan_id'] != '2' && $dataP['pendidikan_id'] != '7' && $dataP['pendidikan_id'] != '4' && $dataP['pendidikan_id'] != '8' && $dataP['pendidikan_id'] != '5'){echo "checked";};?> type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> DLL
				</div>
						
					</div><br><br>

					JENIS JAMINAN : <div class="row">
						<div class="col-4">
							<input <?php if($dataP['jamin'] == '1'){echo "checked";};?> type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> UMUM          <br>
							<input <?php if($dataP['jamin'] == '14'){echo "checked";};?> type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> PENSIUNAN          
						</div>
						<div class="col-4">
							<input <?php if($dataP['jamin'] == '6' && $dataP['jamin'] == '26'){echo "checked";};?> type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> BPJS                   <br>
							<input <?php if($dataP['jamin'] != '1' && $dataP['jamin'] != '14' && $dataP['jamin'] != '6' && $dataP['jamin'] != '13'){echo "checked";};?> type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> DLL
						</div>
						<div class="col-4">
							<input <?php if($dataP['jamin'] == '13'){echo "checked";};?> type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />          ASTEK     
						</div>
					</div><br><br>

					TANGGAL MASUK : <?=input($tgl_msk, "data_{$i}", "date", "", "", "");$i++;?>&emsp;
					PUKUL : <?=input($pkl_msk, "data_{$i}", "time", "", "", "");$i++;?><br>
					KELAS / RUANGAN :   <?=input($dataP["kelas"], "data_{$i}", "text", "", "", "");$i++;?> / 
					<?=input($dataP["kmr"], "data_{$i}", "text", "", "", "");$i++;?><br><br>
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
					TANGGAL KELUAR: <?=input($jam_klr[0], "data_{$i}", "date", "", "", "");$i++;?>&emsp;
					PUKUL <?=input($jam_klr[1], "data_{$i}", "time", "", "", "");$i++;?> <br><br>
					LAMA DIRAWAT : <?=input($difference->days, "data_{$i}", "number", "", "width:100px", "");$i++;?> HARI <br><br>
					Dokter yang menerima : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>
					Dokter yang merawat  : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>	<br><br><br><br><br><br>
		</td>
	</tr>
	<tr>
		<td>
			NAMA PENANGGUNG JAWAB :	<br> <?=input($dataP['penanggung_jawab'], "data_{$i}", "text", "form-control", "", "");$i++;?><br>
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
<?php if(isset($_REQUEST['cetak'])): ?>
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
	<script type="text/javascript">
	getAge()
	
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

	</script>
</body>

</html>