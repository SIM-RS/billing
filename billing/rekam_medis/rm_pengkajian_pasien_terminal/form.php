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
		$data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_pengkajian_pasien_terminal WHERE id = '{$_REQUEST['id']}'"));
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

	if (isset($_REQUEST['cetak'])) {
		$print_mode = true;
		echo "<script>window.print();</script>";
		$data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_pengkajian_pasien_terminal WHERE id = '{$_REQUEST['cetak']}'"));
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
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_pengkajian_pasien_terminal WHERE id = '{$_REQUEST['pdf']}'"));
    $all = $data['data'];
    $str = "";
    $arr_data = [];
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

      $hasil = mysql_query("UPDATE rm_pengkajian_pasien_terminal 
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
		.bordered{
			border: 1px solid black;
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
					
				<div style="float: right">RM 23 / PHCM</div>
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
		<center><h2>ASESMEN AWAL PASIEN TAHAP TERMINAL DAN KELUARGANYA</h4></center>

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


<b>I.	ASESMEN MEDIS (diisi oleh dokter)</b><br>
<div class="newline">
	<b>Beri tanda ( √ ) pada kolom yang sesuai pengkajian</b><br>
	Tanggal  asesmen <?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>&emsp;pukul 
	<?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?>&emsp;oleh 
	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
	Diperoleh dari 
	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>&emsp;hubungan  keluarga 
	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?><br>

	<b>A.	Anamnesis</b><?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?><br><br>
	<b>B.	Pemeriksaan Umum / Fisik 	</b><br>
	Pemeriksaan secara head to toe 	 <br>
	Keadaan umum       :  &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Sakit ringan	   &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Sakit sedang     &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Sakit berat	 <br>
	Kesadaran               :  &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Apatis   	   &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Somnolen  	     &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Sopor        &emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Soporokoma    	&emsp;
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Koma	 <br>
	Tanda-tanda Vital : TD : 
	<?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> mmHg,&emsp;Nadi : 
	<?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> x/menit, &emsp;Suhu: 
	<?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> &deg;C,&emsp; Saturasi O₂: 
	<?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> %, &emsp;GCS : 
	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
	Pernapasan          : 
	<?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> x/mnt,  &emsp;NCH : 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> ada / 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak,  &emsp;Retraksi : 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> ada / 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak, &emsp;Alat bantu nafas : 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> ya / 
	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak <br>
	<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?> <br><br>

	<b>C.	Diagnosis</b><br>
	Diagnosis Kerja 		: <?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?><br>
	Diagnosis Banding 	:  <?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?><br><br>

	<b>D.	Penatalaksanaan / perencanaan pelayanan :   (Terapi, tindakan, konsultasi, pemeriksaan penunjang lanjutan, edukasi, gizi dll )</b><br><?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?><br><br>

</div>

<b>II.	ASESMEN KEPERAWATAN (diisi oleh perawat)</b><br>
<div class="newline">
	<b>Beri tanda ( √) pada kolom yang sesuai atau diisi sesuai asesmen </b><br>
	Asesmen awal tanggal 
	<?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>,&emsp; pukul 
	<?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?> &emsp;oleh 
	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> &emsp;Diperoleh dari 
	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> &emsp;
	<br> hubungan  keluarga 
	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?><br>
	<b>Asesmen pasien tahap terminal  <br></b>
	<div class="newline">
		<b>1.	Pemahaman Pasien / Keluarga </b> <br>
		<div class="newline">
			<b><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Close Awareness :</b> pasien & keluarga percaya bahwa pasien akan sembuh  <br>
			<b><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Mutual Pretense :</b> Keluarga mengetahui kondisi terminal pasien & tidak membicarakannya <br>
			<b><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Open Awareness:</b> keluarga mengetahui tentang proses kematian & merasa tidak keberatan untuk memperbincangkan walaupun sulit & sakit, disampaikan isu seperti donasi organ, autopsy <br>
		</div><br>

		<b>2.	Kegawatan Pernapasan( Breath) :</b> <br>
		<div class="newline">
		
		
&emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pernafasan teratur / 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak 
<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> x/ mnt&emsp;&emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sesak  nafas 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada / 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak      <br>
&emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada suara nafas tambahan seperti ronki, stridor, wheezing, crakles dll <br>
&emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ada  batuk / 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak, bila ada 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> produktif / 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak&emsp;&emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> SpO2 
<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>                             <br>                                    
&emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sputum 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> ada / 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak , jika ada jml: 
<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:13%", "");$i++;?>, &emsp;Warna 
<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:13%", "");$i++;?>, &emsp;Bau
<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:13%", "");$i++;?>, &emsp;jenis 
<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:13%", "");$i++;?>   <br>                     
&emsp;
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Memakai ventilasi mekanik( ventilator ) 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> ya / 
<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak  <br>
		</div><br>

		<b>3.	Kardiovaskuler ( Blood ) <br></b>
		<div class="newline">
			&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Irama jantung regular/ ireguler&emsp;&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Akral hangat / 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> kering / 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> merah / 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> dingin / 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> basah/pucat <br>
			&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pulsasi kuat / 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> lemah / 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> hilang timbul / 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak teraba &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> perdarahan 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak / 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> ada , lokasi 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
			&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> CVC 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak / 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> ada ukuran 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> CmH2O       &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TD 
			<?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> mmHg, &emsp;MAP 
			<?=input($arr_data[$i-1], "data_{$i}", "number", "", "width:100px", "");$i++;?> mmHg  <br>
			&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain- lain 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
		</div><br>

		<b>4.	Persyarafan ( Barin ) <br></b>
		<div class="newline">
			&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> GCS: E 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:200px", "");$i++;?>, &emsp;M 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:200px", "");$i++;?> &emsp;V 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:200px", "");$i++;?> , &emsp;Kesadaran : 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:200px", "");$i++;?> <br>
			&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> TIK tidak / 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> ada , nyeri kepala , muntah proyektil  &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> konjungtiva  anemis / 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> kemerahan  <br>
			&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
		</div><br>

		<b>5.	Perkemihan ( Blader ) <br></b>
		<div class="newline">
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Area genital tidak / 
			 <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> bersih        <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 cara berkemih spontan / 
			 <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> bantuan dower cathether , &emsp;jml 
			 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:150px", "");$i++;?> , &emsp;warna 
			 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:150px", "");$i++;?> , &emsp;bau 
			 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:150px", "");$i++;?>  <br>
		</div><br>

		<b>6.	Pencernaan ( Bowel ) <br></b>
		<div class="newline">
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Napsu makan baik / 
			 <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> menurun , &emsp;porsi makan habis / 
			 <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak 
			 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:150px", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Minum 
			 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:150px", "");$i++;?> cc / 
			 <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> hari, &emsp;jenis cairan 
			 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:150px", "");$i++;?>, &emsp;
			 <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> cara  oral / 
			 <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> NGT  <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 Mulut bersih / 
			 <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> kotor / 
			 <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> berbau , &emsp;muntah 
			 <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak / 
			 <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> ada 
			 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:150px", "");$i++;?> <br>
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
			 BAB 
			 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:150px", "");$i++;?> X/hari, &emsp;
			 <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> teratur / 
			 <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak, &emsp;konsistensi 
			 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:150px", "");$i++;?>, &emsp;warna 
			 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:150px", "");$i++;?>, &emsp;bau 
			 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:150px", "");$i++;?> <br>

		</div><br>

		<b>7.	Muskuloskeletal ( Integumen) <br></b>
		<div class="newline">
			&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Penurunan pergerakan sendi bebas / 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> terbatas       &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sulit berbicara    &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sulit menelan       <br>
			&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Warna kulit : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> ikterik / 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> sianotik / 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> kemerahan / 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> pucat / 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> hiperpigmentasi <br>
			&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Odema 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak / 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> ada lokasi 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:150px", "");$i++;?>     &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Decubitus 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak / 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> ada 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:150px", "");$i++;?> <br>
			&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> luka 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak / 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> ada lokasi  
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:150px", "");$i++;?>        &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kontraktur 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak / 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> ada 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:150px", "");$i++;?> <br>
			&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Fraktur 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak / 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> ada lokasi 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:150px", "");$i++;?>, &emsp;jenis 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:150px", "");$i++;?>    &emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Jalur infuse 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tidak / 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> ada 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:150px", "");$i++;?> <br>
			&emsp;
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kehilangan reflex di 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> kaki / 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> tangan         <br>
		</div><br>

		<b>8.	Nyeri :<br></b>
		<div class="newline">
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Tidak   &emsp; 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />  Ada ,&emsp;skor nyeri : 
			<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:150px", "");$i++;?> ,&emsp; Skala nyeri : 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> BPS
		</div><br>
			
		<b>9.	Kultur psikososial : Penerimaan/Tahap Berduka (Pasien/Keluarga) Menurut Dr. Elisabeth Kublerr-Ross <br></b>
	<div class="newline">
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Denial / pengingkaran&emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bargaining ( tawar menawar)&emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Anger ( marah)  <br>            

		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Depression( kesedihan mendalam&emsp;
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Acceptance ( menerima )  
	</div><br>

	<b>10. Faktor  Spiritual Pasien Dan Keluarga <br></b>
	<div class="newline">
		<b>Apakah perlu pelayanan kerohanian ? 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak 
		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya, oleh 
		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "width:150px", "");$i++;?></b>
	</div><br>


       <b>11. Status Psikososial Pasien Dan Keluarga  <br></b>
	<div class="newline">
		<b>a. Apakah ada yang ingin dihubungi saat ini ? 
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak </b><br>
			<div class="newline">
	    	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
	     	Ya , Siapa 
	     	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> &emsp;Hubungan dengan pasien sebagai 
	     	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> <br>
	        Dimana 
	        <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?> &emsp;No. Telp./ HP 
	         <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>
         </div>
         <b>b. Bagaimana rencana perawatan selanjutnya? </b><br>
         <div class="newline">
         	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
         	 Tetap dirawat di rumah sakit  <br>
    		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />
    		 Dirawat dirumah  <br>
        	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> />Apakah lingkungan rumah sudah disiapkan ?    
        	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya  &emsp;
        	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak  <br>
        	Jika 
         	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya , apakah ada yang mampu merawat pasien dirumah?, oleh 
         	 <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>  <br>
        	Jika  
        	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak , apakah perlu difasilitasi oleh rumah sakit? 
        	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya &emsp;
        	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak
         </div>
         
    	

	</div><br>

		<b>12. Kebutuhan dukungan/ kelonggaran pelayanan bagi pasien, keluarga dan pemberi pelayanan lain: <br></b>
    	<div class="newline">
    		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pasien perlu didampingi keluarga             &emsp;
    		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ruang tersendiri / terpisah &emsp;
    		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Perawatan dirumah <br>
       		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Keluarga / sahabat dapat mengunjungi pasien diluar waktu berkunjung. &emsp;
       		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain 
       		<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>
    	</div><br>

    	<b>13. Apakah ada kebutuhan akan alternative atau tingkat pelayanan lain : <br></b>
    	<div class="newline">
    		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Tidak&emsp;
    		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ya: (Donasi organ / Autopsi / lain-lain <?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>
    	</div><br>
    	
    	<b>14. Faktor risiko bagi keluarga yang ditinggalkan : Asesmen informasi <br></b>
		<div class="newline">
		    <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Marah      &emsp;
		    <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Depresi      &emsp;
		    <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Rasa bersalah    &emsp;
		    <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Letih/ lelah    &emsp;
		    <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Gangguan tidur    &emsp;
		    <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Sedih menangis <br>
		    <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Perubahan kebiasaan pola komunikasi       &emsp;
		    <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Penurunan konsentrasi <br>
		 	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ketidakmampuan memenuhi peran yang diharapkan
		</div><br>

		<b>15. Masalah keperawatan <br></b>
		<div class="newline">
			<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Mual&emsp;
	        <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Pola napas tidak efektif&emsp;
	        <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Bersihan jalan napas tidak efektif <br>
	        <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Perubahan persepsi sensori&emsp;
	        <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Konstipasi&emsp;
	        <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Defisit perawatan diri<br>
	   		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Kultur psikososial/ penerimaan&emsp;
	   		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Distres spiritual&emsp;
	   		<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Ketidak pahaman proses tahap terminal <br>
	     	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Koping individu tidak efektif&emsp;
	     	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Perubahan proses keluarga&emsp;
	     	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Gangguan persyarafan <br>
	      	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Gangguan perkemihan&emsp;
	      	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Gangguan pencernaan&emsp;
	      	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Gangguan musculoskeletal/ integumen <br>
	      	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Nyeri&emsp;
	      	<input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> /> Lain-lain 
	      	<?=input($arr_data[$i-1], "data_{$i}", "text", "", "", "");$i++;?>
		</div><br>
        
		<b>16. Rencana Asuhan Dan Tindakan Keperawatan Terlampir SAK Pasien Tahap Terminal  <br></b>
		<table width="100%" border="1px">
			<tr class="text-center">
				<th>Dokter Yang Melakukan Pengkajian </th>
				<th>Perawat / Bidan Yang Melakukan Pengkajian</th>
				<th>Saksi / Pihak Keluarga</th>
			</tr>
			<tr>
				<td>Tanggal	 : 
					<?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>&emsp;Pkl: 
				<?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?> Selesai</td>
				<td>Tanggal	 : 
					<?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>&emsp;Pkl: 
				<?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?> Selesai</td>
				<td>Tanggal	 : 
					<?=input($arr_data[$i-1], "data_{$i}", "date", "", "", "");$i++;?>&emsp;Pkl: 
				<?=input($arr_data[$i-1], "data_{$i}", "time", "", "", "");$i++;?> Selesai</td>
			</tr>
			<tr>
				<td><br><br><br><br><br><br><br><br></td>
				<td><br><br><br><br><br><br><br><br></td>
				<td><br><br><br><br><br><br><br><br></td>
			</tr>
			<tr class="text-center">
				<td>Tanda Tangan dan Nama Jelas</td>
				<td>Tanda Tangan dan Nama Jelas</td>
				<td>Tanda Tangan dan Nama Jelas</td>
			</tr>
		</table>
		<b>*Minimal Asesmen Dilakukan Oleh Dua Orang Petugas </b>
		
	</div><br>

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
		printPDF('RM 23 '+identifier);
	<?php endif; ?>
	</script>
</body>

</html>