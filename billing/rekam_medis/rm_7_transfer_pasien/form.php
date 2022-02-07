<?php
	use yii\helpers\Html;
	include '../function/form.php';
	include '../../koneksi/konek.php';
	include 'funct.php';

	$dataPasien = getIndetitasPasien($_REQUEST['idKunj']);
	$i = 1;

	 if (isset($_REQUEST['idx'])) {
		date_default_timezone_set("Asia/Jakarta");
		$id_kunj = (int)$_REQUEST["id_kunjungan"];
    	$sql = mysql_fetch_assoc(mysql_query("SELECT pasien_id FROM b_kunjungan WHERE id = '$id_kunj'"));
		$iCount = mysql_real_escape_string($_REQUEST['i']);
    	$str = "";

		for ($q=1; $q < $iCount; $q++) { 
			$data = mysql_real_escape_string($_REQUEST["data_{$q}"]);
			if ($data == "") {
				$str .= "#";
				$str .= "|";
			} else {
				$str .= $data;
				$str .= "|";
			}
		}

		$data = [
			'id_pasien' => $sql['pasien_id'],
			'id_kunjungan' => mysql_real_escape_string($_REQUEST['id_kunjungan']),
			'id_pelayanan' => mysql_real_escape_string($_REQUEST['id_pelayanan']),
			'tgl_act' => date('Y-m-d H:i:s'),
			'id_user' => mysql_real_escape_string($_REQUEST["id_user"]),
			'data' => $str
		];

      		mysql_query("UPDATE rm_7_transfer_pasien 
            SET
            id_pasien = '{$dataPasien['id']}',
            id_kunjungan = '{$data['id_kunjungan']}',
            id_pelayanan = '{$data['id_pelayanan']}',
            tgl_act = '{$data['tgl_act']}',
			id_user = '{$data['id_user']}',
            data = '{$data['data']}'
            WHERE 
            id = {$_REQUEST['idx']}");
      

      echo "<script>window.location.href='index.php?idKunj=".$_REQUEST['idKunj']."&idPel=".$_REQUEST['idPel']."&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['idUser']."&tmpLay=".$_REQUEST['tmpLay']."'</script>";
  }

	if (isset($_REQUEST['id'])) {
		$data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_7_transfer_pasien WHERE id = '{$_REQUEST['id']}'"));
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
		$data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_7_transfer_pasien WHERE id = '{$_REQUEST['cetak']}'"));
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
		$data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_7_transfer_pasien WHERE id = '{$_REQUEST['pdf']}'"));
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

	$dataResep = mysql_query("SELECT
	bresep.*,
	obat.OBAT_NAMA AS nama
	FROM 
	b_resep AS bresep
	LEFT JOIN rspelindo_apotek.a_obat obat ON bresep.obat_id = obat.OBAT_ID
	WHERE bresep.id_pelayanan = '{$_REQUEST['idPel']}' OR bresep.kunjungan_id = '{$_REQUEST['idKunj']}'");

	$dataDiag = mysql_query("SELECT
	msdiag.nama AS nama,
	unit.nama AS namaUnit
	FROM 
	b_diagnosa AS bdiag
	LEFT JOIN b_ms_diagnosa msdiag ON bdiag.ms_diagnosa_id = msdiag.id
	LEFT JOIN b_pelayanan pel ON pel.id = bdiag.pelayanan_id
	LEFT JOIN b_ms_unit unit ON pel.unit_id = unit.id
	WHERE bdiag.pelayanan_id = '{$_REQUEST['idPel']}' OR bdiag.kunjungan_id = '{$_REQUEST['idKunj']}'");

	$dataAnam = mysql_fetch_assoc(mysql_query("SELECT
	*
	FROM 
	anamnese
	WHERE PEL_ID = '{$_REQUEST['idPel']}'"));

	$tgl_masuk_rs = mysql_fetch_assoc(mysql_query("SELECT tgl_masuk FROM b_pelayanan WHERE id = '{$_REQUEST['idPel']}'"));
	$tgL_rs = explode(" ", $tgl_masuk_rs['tgl_masuk']);
	

?>

<!DOCTYPE html>
<html lang="en">
 
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../../theme/bs/bootstrap.min.css">
	<title>Document</title>
	<style type="text/css">
		.inv{
			background-color: : transparent;
			outline-color: none;
			cursor: default;
			border: 0px;
			text-align: center;
		}
	</style>
	<script src="../html2pdf/ppdf.js"></script>
	<script src="../html2pdf/pdf.js"></script>
</head>

<body id="pdf-area">

	<div style="padding:10px;">
		<div class="row" style="padding:20px">
			<div class="col-6 text-center"><br><br>
				<img src="../logors1.png">
			</div>
			<div class="col-6" style="padding:10px">
				<div style="float: right">RM 7 / PHCM</div>
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

		<br>
		<hr class="bg-dark" style="margin-top:-25px"><br>
		<div style="height:5px;background-color:black;width:100%;margin-bottom:10px;margin-top:-35px"></div>
		<center><h2>Transfer Pasien Antar Ruangan Instalasi RS</h2></center>
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
		<table width="100%">
			<tr class="align-top">
				<td>Diagnosis</td>
				<td>:</td>
				<td>
				<?php while ($data = mysql_fetch_assoc($dataDiag)) : ?>
					<?php if ($data['nama'] == "" || $data['nama'] == null) : ?>
						~ <?=$data['diagnosa_manual'];?> Dari <?= $data['namaUnit'] ?><br>
					<?php else : ?>
						~ <?=$data['nama'];?> Dari <?= $data['namaUnit'] ?><br>
					<?php endif; ?>
					
					<?php $nom++; ?>
				<?php endwhile; ?>
				</td>
			</tr>
			<tr>
				<td>Tanggal Masuk RS</td>
				<td>:</td>
				<td><?=$tgL_rs[0];?> Pkl: <?=$tgL_rs[1];?></td>
			</tr>
			<tr>
				<td>Tanggal Pindah</td>
				<td>:</td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "date","inv", "background-color:transparent", "disabled");$i++;?> Pkl: <?=input($arr_data[$i-1], "data_{$i}", "time","inv", "background-color:transparent", "disabled");$i++;?>
				&emsp;Ke <?=input($arr_data[$i-1], "data_{$i}", "text", "inv", "background-color:transparent", "disabled");$i++;?>
				&emsp;Dari <?=input($arr_data[$i-1], "data_{$i}", "text", "inv", "background-color:transparent", "disabled");$i++;?>
				</td>
			</tr>
			<tr>
				<td>1.&emsp;Dari Ruang</td>
				<td>:</td>
				<td><?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> Ke Ruang: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> ICU</td>
			</tr>
			<tr>
				<td>2.&emsp;Dari IGD</td>
				<td>:</td>
				<td>Ke Ruang Perawatan <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> ICU</td>
			</tr>
			<tr>
				<td colspan="3">&emsp;&nbsp;&nbsp;&nbsp;LEVEL TRIAGE ( Untuk pasien dari IGD ) : <?=radio($arr_data[$i-1], "data_{$i}");$i++;?></td>
			</tr>
			<tr>
				<td colspan="3">3.&emsp;Dari ICU : Ke Ruang Perawatan <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?></td>
			</tr>
		</table><br><br>
		
		<div><b>INDIKASI MASUK  ICU PRIORITAS : Beri tanda checklist (√) dan lingkari alasan</b></div>

		<div class="row">
			<div class='col-1'><input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1"> 1</div>
			<div class="col-11">
				<input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1"> Kondisi sakit kritis&emsp;
				<input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1"> GCS ≤ 8&emsp;
				<input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1"> Hemodinamik tidak stabil&emsp;
				<input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1"> Memerlukan alat ventilasi&emsp;
				<input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1"> Penurunan kesadaran&emsp;
				<input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1"> Gangguan elekrolit berat&emsp;
				<input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1"> Syok Septik&emsp;
				<input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1"> Gagal Nafas&emsp;
				<input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1"> Syok Hypovolemik&emsp;
				<input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1"> DSS dll&emsp; 
			</div>
			<div class='col-1'><input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1"> 2</div>
			<div class="col-11">
				<input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1"> Perlu pemantauan ICU&emsp;
				<input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1"> DHF Grade III&emsp;
				<input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1"> Penyakit Jantung yang perlu pengawasan intensif&emsp;
				<input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1"> Penyakit  Paru yang berat&emsp;
				<input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1"> Gagal Ginjal Akut&emsp;
				<input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1"> Operasi dengan komplikasi perdarahan&emsp;
			</div>
			<div class='col-1'><input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1"> 3</div>
			<div class="col-11">
				<input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1"> Penyakit Primer yang berat / terminal&emsp;
				<input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1"> Komplikasi penyakit akut&emsp;
				<input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1"> Kritikal yang memerlukan pertolongan penyakit akutnya&emsp;
				<input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1"> Tidak memerlukan intubasi dan RJP&emsp;
			</div>
		</div><br>
		
		<div><b>INDIKASI KELUAR ICU, SKALA   :  
		<input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1"> 1 (SATU)&emsp;
		<input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1"> 2 (DUA)&emsp;
		<input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1"> 3 (TIGA)</b></div>
		<div><b>Catatan : Beri tanda checklist (√), sesuai kriteria skala indikasi keluar dari  ICU.</b></div><br>

		<div><b>RESUME KEADAAN PASIEN YANG AKAN DITRANSFER</b></div>
		<div class="row">
			<div class="col-1">1.</div>
			<div class="col-11">Ringkasan singkat penyakit dan pemeriksaan fisik:<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?></div>
			<div class="col-1">2.</div>
			<div class="col-11">Tindakan / terapi yang sudah dilakukan:<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?></div>
			<div class="col-1">3.</div>
			<div class="col-11">Rencana Tindakan / Terapi Selanjutnya:<br>
				<table class="text-center" border="1px" width="100%">
					<tr>
						<th>NO</th>
						<th>Nama Obat/ Cairan Infus</th>
						<th>Sediaan</th>
						<th>Tgl/ Pkl Mulai</th>
						<th>Dosis & Frekwensi</th>
						<th>Rute/Pemberian</th>
					</tr>
					<?php $nom=1; while($data = mysql_fetch_assoc($dataResep)) : ?>
						<tr>
							<td><?=$nom;?></td>
							<?php if($data['nama'] == "" || $data['nama'] == null) : ?>
								<td><?=$data['obat_manual'];?></td>
							<?php else : ?>
								<td><?=$data['nama'];?></td>
							<?php endif; ?>
							<td><?=$data['qty'];?></td>
							<td><?=$data['tgl'];?></td>
							<td><?=$data['ket_dosis'];?></td>
							<td><?=$data['jhobat'];?></td>
						</tr>
						<?php $nom++; ?>
					<?php endwhile; ?>
				</table>
			</div>
			<div class="col-1">4.</div>
			<div class="col-11">Masalah perawatan saat pindah:<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?></div>
			<div class="col-1">5.</div>
			<div class="col-11">Rencana keperawatan selanjutnya:<?=area($arr_data[$i-1], "data_{$i}", "form-control");$i++;?></div>
		</div>

		<div class="row">
			<div class="col-1">6.</div>
			<div class="col-11">Keadaan pasien saat pindah: Keadaan Umum:
			<?=$dataAnam['KUM']?>
			, GCS:<?=$dataAnam['CGS']?>
			, TD:<?=$dataAnam['TENSI_DIASTOLIK']?> mmhg, <br>
			Nadi:<?=$dataAnam['NADI']?> X/mnt
			, RR:<?=$dataAnam['RR']?> x/ mnt
			, Suhu:<?=$dataAnam['SUHU']?> °C <br>
			TFU:<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>
			, Kontraksi:<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>
			, DJA:<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>X/mnt
			, Perdarahan:<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?><b>(Khusus Pasien Kebidanan)</b>
			</div>
			<div class="col-1">7.</div>
			<div class="col-11">Diet:<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>,Mobilisasi: <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>
			</div>
			<div class="col-1">8.</div>
			<div class="col-11">Pesanan khusus Risiko : <input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1"> Decubitus&emsp;
			<input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1"> Nyeri&emsp;
			<input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1"> Jatuh&emsp;
			<input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1"> Alergi&emsp;
			<input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1"> Phlebitis&emsp;
			<input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1"> Lain-lain<?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>
			</div>
			<div class="col-1">9.</div>
			<div class="col-11">Penggunaan alat : <input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1"> NGT&emsp;
			<input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1"> Folley catheter&emsp;
			<input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1"> Chest Tube + WSD (Khusus Pasien Trauma)
			</div>
			<div class="col-1">10.</div>
			<div class="col-11">Dokumen-dokumen yang diserah terimakan:<br>
			<input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1">   Berkas Rekam Medis Pasien<br>
			<input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1">   Formulir transfer/ Pindah Ruangan<br>
			<input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1">   EKG : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>, Hasil Radiologi <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?><br>
			<input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1">	Hasil Laboratorium <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?><br>
			<input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1">   Hasil pemeriksaan lain  ( termasuk yang dibawa dari luar ) <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?><br>
			<input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1">   <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>
			</div>
 
			<div style="margin-top:45px" class="col-4 text-center">
			Dokter<br><br><br><br><br><br><?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?><br>Tanda Tangan & Nama Jelas
			</div>

			<div style="margin-top:45px" class="col-4 text-center">
			Perawat Yang Memindahkan<br><br><br><br><br><br><?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?><br>Tanda Tangan & Nama Jelas
			</div>

			<div style="margin-top:45px" class="col-4 text-center">
			Perawat  Yang Menerima<br><br><br><br><br><br><?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?><br>Tanda Tangan & Nama Jelas
			</div>

		</div>

<?php if(isset($_REQUEST['cetak'])): ?>
	&nbsp;
<?php elseif(isset($_REQUEST['id'])): ?>
	<input type="hidden" name="i" value="<?=$i;?>">
	<button type="submit" class="btn btn-primary">Ganti</button>
	</form>
<?php else:?>
	<input type="hidden" name="i" value="<?=$i;?>">
	<button type="submit" class="btn btn-success">Tambah</button>
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
			printPDF('RM 7 '+identifier);
		<?php endif; ?>
	</script>
</body>

</html>