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
		$data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_pengkajian_awal_pasien_rj WHERE id = '{$_REQUEST['id']}'"));
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

      $hasil = mysql_query("UPDATE rm_pengkajian_awal_pasien_rj 
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

  if (isset($_REQUEST['pdf'])) {
    echo '';
    $print_mode = true;
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_pengkajian_awal_pasien_rj WHERE id = '{$_REQUEST['pdf']}'"));
    
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
	</style>
	<script src="../html2pdf/ppdf.js"></script>
	<script src="../html2pdf/pdf.js"></script>
	<?php 
	if (isset($_REQUEST['cetak'])) {
		$print_mode = true;
		echo "<script>window.print();</script>";
		$data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_pengkajian_awal_pasien_rj WHERE id = '{$_REQUEST['cetak']}'"));
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

<body style="padding:20px" id="pdf-area">
	<div class="bg-white" style="padding:25px">
		<div class="row">
			<div class="col-6 text-center"><br><br>
				<img src="../logors1.png">
			</div>
			<div class="col-6" style="padding:15px">
					
				<div style="float: right">RM 2.1 / PHCM</div>
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
		<center><h2>PENGKAJIAN AWAL KEPERAWATAN PASIEN RAWAT JALAN</h4></center>

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

Pengkajian		: Tanggal <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>
&emsp;Jam <?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?> WIB <br>
Keluhan Utama	: <?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?> <br>
<div style="border: 1px solid black;width: 100%"></div>
Pengkajian diperoleh dari : &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Pasien Sendiri   &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  
<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>, &emsp;hubungan dengan pasien 
<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>  <br>
<b> 1.	PEMERIKSAAN FISIK </b><br>
TD : 
<?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:70px", "");$i++;?> mmHg, &emsp;Suhu : 
<?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:70px", "");$i++;?> ºC, &emsp;P : 
<?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:70px", "");$i++;?> x/mt, &emsp;Nadi : 
<?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:70px", "");$i++;?> x/mnt, &emsp;BB : 
<?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:70px", "");$i++;?> Kg, &emsp;TB : 
<?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:70px", "");$i++;?> cm <br>
Kesadaran :	&emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  CM	&emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Apatis	&emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Somnolent	&emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Soporocoma	&emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Koma <br>

<table width="100%" border="1px">
	<tr>
		<td width="50%">
			<img src="../../images/numericScale.jpg" width="100%"><br>
			<img src="../../images/skalaNyeri1.png" width="16%" height="100px">
			<img src="../../images/skalaNyeri2.png" width="16%" height="100px">
			<img src="../../images/skalaNyeri3.png" width="16%" height="100px">
			<img src="../../images/skalaNyeri4.png" width="16%" height="100px">
			<img src="../../images/skalaNyeri5.png" width="16%" height="100px">
			<img src="../../images/skalaNyeri6.png" width="16%" height="100px">
		</td>
		<td width="50%">
			<b>Nyeri    :        &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> ya    &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  tidak</b> <br>
Penyebab         : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
Kualitas Nyeri  : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
Lokasi             : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
Skala nyeri       : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
Durasi /Frekuensi   : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
<b>Respon Emosional : </b><br>
&emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Mual      &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Cemas      &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Marah <br>
<b>Cara Mengatasi Nyeri </b><br>
&emsp; 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Obat&emsp; 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Istirahat <br>
&emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Relaksasi          &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ubah Posisi <br>
&emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain lain <br>

		</td>
	</tr>
</table>
<br>

<b>2.	RIWAYAT PSIKOSOSIAL DAN SPIRITUAL</b><br>
<b>Status Psikologis</b><br>
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Cemas		 &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Takut		  &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Marah	Sedih		 &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kecenderungan         &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bunuh  Diri     
<br>
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
Lain – lain, Sebutkan <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
<b>Status Mental</b><br>
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sadar dan Orientasi Baik <br>
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada Masalah Perilaku, Sebutkan <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Perilaku kekerasan yang dialami pasien sebelumnya <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
<b>Sosial</b><br>
Hubungan pasien dengan anggota keluarga        &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Baik	       &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak Baik <br>
Tempat Tinggal 	:  <br>

<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Rumah / 
 <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Apartemen / 
 <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Panti / 
 <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lainnya <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
Kerabat terdekat yang dapat dihubungi <br>
Nama		: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>&emsp;Hubungan	: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
Telepon		: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
<b>Status Spiritual / Nilai Kepercayaan</b><br>
Kegiatan keagamaan / Spritual yang biasa dilakukan : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
Nilai Kepercayaan :
<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>

<b>3.	RIWAYAT KESEHATAN<br></b>
Operasi yang pernah dialami : Jenis 
<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>&emsp;kapan 
<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>  <br>
komplikasi yang ada 
<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
Riwayat penyakit dalam keluarga saat ini 
<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
Ketergantungan terhadap : &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak 	&emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya <br>
Jika Ya : &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Obat – Obatan  	&emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Rokok 	&emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Alkohol ,  Jelaskan 
<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>	 <br> 

Riwayat pekerjaan ( apakah berhubungan dengan zat – zat berbahaya ) : &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak	 &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya <br>
<b>Riwayat alergi :<br></b>
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak 	&emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya, Jelaskan : 
<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?><br><br>

<b>4.	KEBUTUHAN KOMUNIKASI / PENDIDIKAN DAN PENGAJARAN <br></b>
Bicara : &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Normal 	&emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Gangguan Bicara,  Jelaskan  
<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?><br>
Perlu penterjemah	: 	&emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak	&emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya,  Bahasa 
<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> Bahasa Isyarat :	&emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak 	&emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya <br>
Hambatan belajar	: 	&emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak	&emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya, 
<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
Tingkat pendidikan	:	&emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TK &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> SD, &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> SMP &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> SMA  &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Akademi  &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sarjana &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pasca Sarjana <br><br>

<b>5.	STATUS EKONOMI & SOSIAL<br></b>
Status ekonomi 	: &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Biaya Sendiri     &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Asuransi      &emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Perusahaan 	&emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> 
<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
Status Sosial	: 
<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br><br>

<b>6.	DAFTAR MASALAH KEPERAWATAN :<br></b>
<table width="100%" border="1px">
	<tr class="text-center">
		<th>
			DIAGNOSA  KEPERAWATAN
		</th>
		<th>
			INTERVENSI KEPERAWATAN
		</th>
	</tr>
	<tr>
		<td width="50%">
			<div class="row">
				<div class="col-1">
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <br><br><br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <br><br><br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <br><br><br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <br><br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /><br><br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <br><br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <br><br><br><br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <br><br><br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <br><br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <br><br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <br><br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <br><br><br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
				</div>
				<div class="col-11">
					Ketidakefektifan pola nafas b.d nyeri, 
					cedera Pada spinal, kelelahan otot 
					pernafasan, kerusakan otot rangka <br><br>
					Gangguan pertukaran gas b.d perubahan 
					kapasitas darah membawa oksigen, 
					ketidakseimbangan membrane pertukaran 
					kapiler dan alveolus <br><br>
					Ketidakefektifan perfusi jaringan (cerebal, 
					cardiopulmonar, renal, gastrointestinal, 
					peripheral) b.d penurunan hipovolemia <br><br>
					Diare b.d penyalagunaan laxatif, proses<br> <br>
					Diare b.d penyalagunaan laxatif, proses 
					infeksi, Malabsorpsi Retensi urin b.d  <br> <br>
					obstruksi urinariusGangguan neurovas cular <br> <br>
					Nyeri akut, kronis b.d spasme otot dan
					 jaringan, trauma jaringanketidakmampu
					an fisik kronik
					Hipertermia b.d dehidrasi, peningkatan
					 kecepatan metabolisme trauma, proses 
					perjalanan penyakit <br><br>
					Kerusakan mobilitas fisik b.d kerusakan 
					muskuloskletal dan neuromuscular, 
					kehilangan integritas struktur tulang,
					 penurunan kekuatan dan ketahanan
					 tubuh <br><br>
					 Risiko infeksi b.d prosedur invasif, <br><br>
					 Kerusakan kulit dan jaringan
					trauma , imuno supresi <br><br>
					Konstipasi b.d diet, asupan cairan, tingkat
 					aktivitas, kebiasaan defek <br><br>
 					Risiko jatuh b.d penyakit, gangguan 
					keseimbangan, penurunan status mental, 
					penggunan obat,penggunaan alkphol <br><br>
					Resiko mencederai diri dan orang lain
					 berhubungan dengan  agresif
				</div>
			</div>

		</td>
		<td width="50%">
			<div class="row">
				<div class="col-1">
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <br><br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <br><br><br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <br><br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <br><br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <br><br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <br><br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <br><br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <br><br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <br><br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <br><br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <br><br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <br><br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <br><br>
					<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> <br><br>
				</div>
				<div class="col-11">
					Berikan O2 sesuai kebutuhan melalui nasal
				      canula, masker Monitor Sa O2 <br><br>
				      Monitor tanda tanda vital secara periodic
       kaji turgor kulit dan membranmukosa mulut <br><br>
       				Atasi nyeri, delegatif pemberian analgetika, 
       teknik distraksi, relaksasi <br><br>
       Lakukan perawat luka dengan teknik septic
 Aseptic <br><br>
Berikan kompres hangat <br><br>
Berikan posisi semifowler bila tidak ada  <br><br>
Kontraindikasi	 
Delegatif pemberian antipiretik <br><br>
Delegatif pemberian antipiretik <br><br>
Pasang pengaman, spalk, lakukan imobilasasi <br><br>
Kaji tanda-tanda kompartemen pada daerah
 distal dari fraktur <br><br>
 Pasang gelang kuning pada pasien sebagai 
penada pasien perpengawasan <br><br>
Lakukan pengikatan pasien, kolaborasi obat 
penenang <br><br>
Kolaborasi penangan trauma <br><br>
Edukasi diet, mobilisasi <br><br><br><br><br>

				</div>
			</div>
		</td>
	</tr>
</table><br>
<div class="row">
	<div class="col-8"></div>
	<div class="col-4">
		Tanggal, <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>, 
	&emsp;pukul <?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?> <br>
         <center>
         	Perawat yang mengkaji <br><br><br><br><br><br>

 ( <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>)
         </center> <br>
	</div>
</div>

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
		<?php if(isset($_REQUEST["pdf"])): ?>
			let identifier = '<?=$dataPasien["nama"]?>';
			printPDF('RM 2.1 '+identifier);
		<?php endif; ?>
	</script>
</body>

</html>