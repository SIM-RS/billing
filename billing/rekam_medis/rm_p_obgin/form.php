<?php
include '../function/form.php';
include '../../koneksi/konek.php';
$dataPasien = getIndetitasPasien($_REQUEST['idKunj']);

$sql = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_2_4_p_obgin WHERE id = '{$_REQUEST['id']}'"));
$riwayat_menstruasi = explode("|", $sql['riwayat_menstruasi']);
$riwayat_perkawinan = explode("|", $sql['riwayat_perkawinan']);
$riwayat_pemakaian_alat_kontrasepsi = explode("|", $sql['riwayat_pemakaian_alat_kontrasepsi']);
$riwayat_hamil_ini = explode("|", $sql['riwayat_hamil_ini']);
$riwayat_penyakit_yang_lalu = explode("|", $sql['riwayat_penyakit_yang_lalu']);
$mata = explode("|", $sql['mata']);
$extermitas = explode("|", $sql['extermitas']);
$mamae = explode("|", $sql['mamae']);
$inspeksi = explode("|", $sql['inspeksi']);
$palpasi = explode("|", $sql['palpasi']);
$inspeksi_anogenital = explode("|", $sql['inspeksi_anogenital']);
$auskultasi = explode("|", $sql['auskultasi']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../../theme/bs/bootstrap.min.css">
	<title>Document</title>
</head>

<body>
	<div class="container">
		<div class="row">
			<div class="col-6">
				<?= textInput('No RM',['value'=>$dataPasien['no_rm'],'readonly'=>true,'class'=>'form-control']) ?>
				<?= textInput('Nama Pasien',['value'=>$dataPasien['nama'],'readonly'=>true,'class'=>'form-control']) ?>
			</div>
			<div class="col-6">
				<?= textInput('Tanggal Lahir',['value'=>$dataPasien['tgl_lahir'],'readonly'=>true,'class'=>'form-control']) ?>
				<?= textInput('Tanggal Lahir',['value'=>$dataPasien['alamat'],'readonly'=>true,'class'=>'form-control']) ?>
			</div>
		</div>

		<?php
			if (isset($_REQUEST['id'])) {
				echo formOpen('penyakit_dalam_form', 'utils.php');
				echo "<input type='hidden' name='id' value='{$_REQUEST['id']}'>";
			} else {
				echo formOpen('penyakit_dalam_form', 'utils.php');
			}
		?> 
		<input type="hidden" name="id_user" value="<?= $_REQUEST['idUser']; ?>">
		<input type="hidden" name="tmpLay" value="<?= $_REQUEST['tmpLay']; ?>">
		<?= textInput('',['type'=>'hidden','name'=>'id_kunjungan','value'=>$_REQUEST['idKunj']]) ?>
		<?= textInput('',['type'=>'hidden','name'=>'id_pelayanan','value'=>$_REQUEST['idPel']]) ?>

		<?= textInput('Anamnesa', ['name' => 'anamnesa', 'class' => 'form-control', 'id' => 'anamnesa', 'required' => true, 'value' => $sql['anamnesa']]) ?>
		<div class="row">
			<div class="col-6">
				<?= textInput('Tanggal Anamnesa', ['name' => 'tanggal_anamnesa', 'class' => 'form-control', 'id' => 'tanggal_anamnesa', 'required' => true,'type'=>'date', 'value' => $sql['tanggal_anamnesa']]) ?>
			</div>
			<div class="col-6">
				<?= textInput('Jam',['type'=>'time','name'=>'jam_anamnesa','class'=>'form-control','required'=>true, 'value' => $sql['jam_anamnesa']]) ?>
			</div>
		</div>
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-6">
					<div class="form-group">
						<label for="">Petugas</label>
						<select name="cmbDokSemua" class="form-control" id="cmbDokSemua"></select>
					</div>			
					</div>
					<div class="col-6">
						<?= textInput(
								'Alergi',
								[
									'class'=>'form-control',
									'name'=>'alergi_terhadap_keterangan',
									'id'=>'alergi_terhadap_keterangan',
									'value' => $sql['alergi_terhadap']
								]) ?>	
					</div>
				</div>
			</div>
		</div>	
		<div class="row">	
			<div class="col-4">	
				<?= textArea('Keluhan Utama',[
					'name'=>'keluhan_utama',
					'class'=>'form-control',
					'id'=>'keluhan_utama',
					'required'=>true
				]) ?>
			</div>
			<div class="col-4">
				<?= textArea('Riwayat Penyakit Sekarang',[
					'name'=>'riwayat_penyakit_sekarang',
					'class'=>'form-control',
					'id'=>'riwayat_penyakit_sekarang',
					'required'=>true,
				]) ?>
			</div>
			<div class="col-4">
				<b>Riwayat Menstruasi</b>
				<?= textInput('Umur',['placeholder' => 'Tahun','type' => 'number', 'name'=>'umur_menstruasi','id' => 'umur_menstruasi','class'=>'form-control','required'=>true]) ?>
				<?= textInput('Siklus',['placeholder' => 'Hari','id' => 'siklus','type' => 'number','name'=>'siklus','class'=>'form-control','required'=>true]) ?>

				<?= select('',[
					'Teratur' => 'Teratur',
					'Tidak Teratur' => 'Tidak Teratur'
				],['class'=>'form-control','id'=>'teratur_siklus','name'=>'teratur_siklus']) ?>

				<?= textInput('Lama',['placeholder' => 'Hari','type' => 'number','id'=>'lama_menstruasi','name'=>'lama_menstruasi','class'=>'form-control','required'=>true]) ?>
				<?= textInput('Volume',['placeholder' => 'CC','type' => 'number','id' => 'volume_menstruasi','name'=>'volume_menstruasi','class'=>'form-control','required'=>true]) ?>
				<?= textArea('Keluhan Saat Haid',[
					'name'=>'keluhan_haid',
					'class'=>'form-control',
					'id'=>'keluhan_haid',
				]) ?>
				
			</div>
			<div class="col-4">
				<b>Riwayat Perkawinan</b>
				<?= textInput('Status Kawin',['placeholder' => 'Cerai, Kawin, Belum Kawin','name'=>'status_kawin','id' => 'status_kawin','class'=>'form-control','required'=>true]) ?>
				<?= textInput('Umur Waktu Pertama Kawin',['placeholder' => 'Tahun','name'=>'umur_kawin','class'=>'form-control', 'type' => 'number','id' => 'umur_kawin']) ?>
				
			</div>
			<div class="col-4">
				<b>Riwayat Pemakaian Alat Kontrasepsi</b><br>
				<?= select('',[
					'Menggunakan' => 'Menggunakan',
					'Tidak Menggunakan' => 'Tidak Menggunakan'
				],['class'=>'form-control','id'=>'riwayat_pemakaian_kontrasepsi','name'=>'riwayat_pemakaian_kontrasepsi']) ?>
				<?= textInput('Jenis',['id' => 'jenis_kontrasepsi','name'=>'jenis_kontrasepsi','class'=>'form-control']) ?>
				<?= textInput('Lama Pemakaian',['id'=>'lama_pemakaian','name'=>'lama_pemakaian','class'=>'form-control']) ?>
			</div>
		</div>
		<div class="row">
			<div class="col-6">
				<b>Riwayat Hamil Ini</b><br>
				<?= textInput('Hari pertama haid terakhir',['id'=>'hari_pertama_terakhir','name'=>'hari_pertama_terakhir','class'=>'form-control','required'=>true]) ?>
				<?= textInput('Tafsiran partus',['id'=>'tafsiran_partus','name'=>'tafsiran_partus','class'=>'form-control','required'=>true]) ?>
				<?= textInput('Ante Natal Care',['id'=>'ante_natal_care','name'=>'ante_natal_care','class'=>'form-control','required'=>true]) ?>
				<?= select('Frekuensi',[
					'1x' => '1x',
					'2x' => '2x',
					'3x' => '3x',
					'>3x' => '>3x',
				],['class'=>'form-control','id'=>'frekuensi','name'=>'frekuensi']) ?>
				<?= select('Imunisasi TT',[
					'Ya' => 'Ya',
					'Tidak' => 'Tidak'
				],['class'=>'form-control','id'=>'imunisasi_tt','name'=>'imunisasi_tt']) ?>
				<?= textArea('Keluhan Saat Hamil',[
					'name'=>'keluhan_hamil',
					'class'=>'form-control',
					'id'=>'keluhan_hamil',
					'placeholder' => 'Mual, Muntah, Pendarahan, Pusing, Sakit Kepala, .....'
				]) ?>
			</div>
			<div class="col-6">	
				<b>Riwayat penyakit yang lalu / operasi</b><br>
				<?= textArea('',[
					'name'=>'riwayat_penyakit_lalu',
					'class'=>'form-control',
					'id'=>'riwayat_penyakit_lalu',
					'required'=>true,
					'placeholder' => 'Hipertensi, Jantung, Asthma, Jiwa, Hepatitis, Tumor Di, .....'
				]) ?>
				<?= select('Pernah Dirawat',[
					'Ya' => 'Ya',
					'Tidak' => 'Tidak'
				],['class'=>'form-control','id'=>'pernah_dirawat','name'=>'pernah_dirawat']) ?>
				<?= textInput('Alasan Dirawat',['id'=>'alasan_dirawat','name'=>'alasan_dirawat','class'=>'form-control']) ?>
				<?= textInput('Tanggal Dirawat',['name'=>'tanggal_dirawat','id'=>'tanggal_dirawat','class'=>'form-control', 'type' => 'date']) ?>
				<?= select('Pernah Dioperasi',[
					'Ya' => 'Ya',
					'Tidak' => 'Tidak'
				],['class'=>'form-control','id'=>'pernah_dioperasi','name'=>'pernah_dioperasi']) ?>
				<?= textInput('Jenis Operasi',['id'=>'jenis_operasi','name'=>'jenis_operasi','class'=>'form-control']) ?>
				<?= textInput('Tanggal',['id'=>'tanggal_operasi','name'=>'tanggal_operasi','class'=>'form-control', 'type' => 'date']) ?>
				<?= textInput('Di',['id'=>'di_operasi','name'=>'di_operasi','class'=>'form-control']) ?>
				<?= textArea('Penyakit Gynekologi',[
					'name'=>'penyakit_gykenologi',
					'class'=>'form-control',
					'id'=>'penyakit_gykenologi',
					'placeholder' => 'Tidak Ada, Infertilitas, Infeksi Virus, PMS, Cervisitis Kronis, Kanker, .....'
				]) ?>
				<?= textArea('Riwayat Penyakit Keluarga',[
					'name'=>'riwayat_penyakit_keluaraga',
					'class'=>'form-control',
					'id'=>'riwayat_penyakit_keluaraga',
					'placeholder' => 'Tidak Ada, Hipertensi, Jantung, TBC, Epilepsi, Kelainan Bawaan, .....'
				]) ?>
		</div>
			
	</div>
	<div class="card">
		<div class="card-header">
			Pemeriksaan Umum
		</div>
		<div class="card-body">
				<div class="row">
			<div class="col-6">
				<?= textInput('Tinggi Badan', ['placeholder' => 'CM', 'type' => 'number','name' => 'tinggi_badan', 'class' => 'form-control', 'id' => 'tinggi_badan', 'required' => true, 'value' => $sql['tinggi_badan']]) ?>
				<?= textInput('Berat Badan', ['placeholder' => 'KG', 'type' => 'number','name' => 'berat_badan', 'class' => 'form-control', 'id' => 'berat_badan', 'required' => true, 'value' => $sql['berat_badan']]) ?>
				<?= textInput('Pernapasan', ['placeholder' => 'x/Menit', 'type' => 'number','name' => 'pernapasan', 'class' => 'form-control', 'id' => 'pernapasan', 'required' => true, 'value' => $sql['pernapasan']]) ?>
				<?= textInput('Nadi', ['placeholder' => 'x/Menit', 'type' => 'number','name' => 'nadi', 'class' => 'form-control', 'id' => 'nadi', 'required' => true, 'value' => $sql['nadi']]) ?>
			</div> 
			<div class="col-6">
				<?= textInput('Kesadaran',['name'=>'kesadaran','class'=>'form-control','id'=>'kesadaran','required'=>true, 'value' => $sql['kesadaran']]) ?>
				<?= textInput('TD',['placeholder'=> '..... / .....','name'=>'td','class'=>'form-control','id'=>'td','required'=>true, 'value' => $sql['td']]) ?>
				<?= textInput('Suhu',['type'=>'number','placeholder'=> '&deg;C','name'=>'suhu','class'=>'form-control','id'=>'suhu','required'=>true, 'value' => $sql['suhu']]) ?>
			</div>
		</div>	
		</div>
	</div>
	
	
		<div class="card">
			<div class="card-header">
				Pemeriksaan Fisik
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-4">
						<b>Mata</b>
						<?= select('Konjuctiva :',[
							'Pucat' => 'Pucat',
							'Normal' => 'Normal',
						],['class'=>'form-control','id'=>'mata_konjuctiva','name'=>'mata_konjuctiva']) ?>
						<?= select('Sclera :',[
							'Putih' => 'Putih',
							'Kuning' => 'Kuning',
							'Merah' => 'Merah',
						],['class'=>'form-control','id'=>'mata_sclera','name'=>'mata_sclera']) ?>
						<b>Paru</b>
						<?= textArea('',[
							'name'=>'paru',
							'class'=>'form-control',
							'id'=>'paru',
							'required'=>true
						]) ?>
					</div>
					<div class="col-4">
						<b>Leher</b>
						<?= select('Tyroid :',[
							'Teraba' => 'Teraba',
							'Tidak Teraba' => 'Tidak Teraba',
						],['class'=>'form-control','id'=>'leher_tyroid','name'=>'leher_tyroid']) ?>
						<b>Dada</b>
						<?= textArea('Jantung',[
							'name'=>'jantung',
							'class'=>'form-control',
							'id'=>'jantung',
							'required'=>true
						]) ?>
						<b>Extermitas</b>
						<?= select('Tungkai :',[
							'Simetris' => 'Simetris',
							'Asimetris' => 'Asimetris',
						],['class'=>'form-control','id'=>'exter_tungkai','name'=>'exter_tungkai']) ?>
						<?= select('Refleks :',[
							'+' => '+',
							'-' => '-',
						],['class'=>'form-control','id'=>'refleks_exter','name'=>'refleks_exter']) ?>
						<?= textInput('Edema',['placeholder'=> '..... / .....','name'=>'edema','class'=>'form-control','id'=>'edema','required'=>true]) ?>
					</div>
					<div class="col-4">
						<b>Mamae</b>
						<?= select('Bentuk :',[
							'Simetris' => 'Simetris',
							'Asimetris' => 'Asimetris',
						],['class'=>'form-control','id'=>'bentuk_mamae','name'=>'bentuk_mamae']) ?>
						<?= select('Puting Susu :',[
							'Menonjol' => 'Menonjol',
							'Datar' => 'Datar',
							'Masuk' => 'Masuk',
						],['class'=>'form-control','id'=>'mamae_2','name'=>'mamae_2']) ?>
						<?= select('Pengeluaran :',[
							'Tidak Ada' => 'Tidak Ada',
							'Colostrum' => 'Colostrum',
							'ASI' => 'ASI',
							'Nanah' => 'Colostrum',
							'Darah' => 'Darah',
						],['class'=>'form-control','id'=>'mamae_pengeluaran','name'=>'mamae_pengeluaran']) ?>
						<?= select('Kebersihan :',[
							'Cukup' => 'Cukup',
							'Kurang' => 'Kurang',
						],['class'=>'form-control','id'=>'mamae_kebersihan','name'=>'mamae_kebersihan']) ?>
						<?= textArea('Kelainan',[
							'name'=>'kelainan_mamae',
							'class'=>'form-control',
							'id'=>'kelainan_mamae',
							'placeholder' => 'Lecet, Bengkak, .....'
						]) ?>
					</div>
				</div>
			</div>
		</div><br>

		<div class="card">
			<div class="card-header">
				Pemeriksaan Khusus
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-6">
							A. Abdomen <br>
							<b>*Inspeksi :</b>
							<?= select('Luka Bekas Operasi :',[
								'Tidak Ada' => 'Tidak Ada',
								'Ada' => 'Ada',
							],['class'=>'form-control','id'=>'luka_operasi','name'=>'luka_operasi']) ?>
							<?= select('Arah pembesaran :',[
								'Tidak Ada' => 'Tidak Ada',
								'Memanjang' => 'Memanjang',
								'Melebar' => 'Melebar',
							],['class'=>'form-control','id'=>'area_pembesaran','name'=>'area_pembesaran']) ?>
							<?= textArea('Kelainan',[
								'name'=>'kelainan_abdomen',
								'class'=>'form-control',
								'id'=>'kelainan_abdomen'
							]) ?>
							<b>*Palpasi :</b>
							<?= textInput('Tinggi Fundus Uteri',['placeholder'=> 'CM','name'=>'tinggi_fundus','type'=>'number','class'=>'form-control','id'=>'tinggi_fundus','required'=>true]) ?>
							<?= select('Letak Punggung :',[
								'Punggung Kanan' => 'Punggung Kanan',
								'Punggung Kiri' => 'Punggung Kiri',
							],['class'=>'form-control','id'=>'punggung_letak','name'=>'punggung_letak']) ?>
							<?= select('Persentasi :',[
								'Kepala' => 'Kepala',
								'Bokong' => 'Bokong',
								'Kosong' => 'Kosong',
							],['class'=>'form-control','id'=>'persentasi','name'=>'persentasi']) ?>
							<?= textInput('Bagian Terendah',['placeholder'=> '..... / ..... (Perlimaan)','name'=>'bagian_terendah','class'=>'form-control','id'=>'bagian_terendah','required'=>true]) ?>
							<?= select('Osborn Test :',[
								'+' => '+',
								'-' => '-',
							],['class'=>'form-control','id'=>'osborn_test','name'=>'osborn_test']) ?>
							<?= select('Konstraksi Uterus :',[
								'Tidak Ada' => 'Tidak Ada',
								'Baik' => 'Baik',
								'Lembek' => 'Lembek',
							],['class'=>'form-control','id'=>'konstraksi_uterus','name'=>'konstraksi_uterus']) ?>
							<?= textInput('His',['placeholder'=> 'Menit','name'=>'his','type'=>'number','class'=>'form-control','id'=>'his','required'=>true]) ?>
							<?= textInput('Lama',['placeholder'=> 'Detik','name'=>'lama_palpasi','type'=>'number','class'=>'form-control','id'=>'lama_palpasi','required'=>true]) ?>
							<?= select('Kelainan :',[
								'Nyeri Tekan' => 'Nyeri Tekan',
								'Blass Penuh' => 'Blass Penuh',
								'Cekungan Pada Perut' => 'Cekungan Pada Perut',
							],['class'=>'form-control','id'=>'kelainan_palpasi','name'=>'kelainan_palpasi']) ?>
							<?= select('Teraba Massa :',[
								'Tidak Ada' => 'Tidak Ada',
								'Solid' => 'Solid',
								'Kristik' => 'Kristik',
							],['class'=>'form-control','id'=>'teraba_massa','name'=>'teraba_massa']) ?>
							<?= textInput('Ukuran',['placeholder'=> '..... X ..... CM','name'=>'ukuran_palpasi','class'=>'form-control','id'=>'ukuran_palpasi','required'=>true]) ?>
							<?= textInput('Taksiran Berat Janin',['placeholder'=> 'Gram','name'=>'taksiran_berat','type'=>'number','class'=>'form-control','id'=>'taksiran_berat','required'=>true]) ?>
							<b>*Auskultasi :</b>
							<?= select('Bising Usus :',[
								'Tidak Ada' => 'Tidak Ada',
								'Ada' => 'Ada',
							],['class'=>'form-control','id'=>'bising_usus','name'=>'bising_usus']) ?>
							<?= textInput('DJJ :',['placeholder'=> 'Menit','type'=>'number','name'=>'aukultasi_djj','class'=>'form-control','id'=>'aukultasi_djj','required'=>true]) ?>
							<?= select('',[
								'Teratur' => 'Teratur',
								'Tidak Teratur' => 'Tidak Teratur',
							],['class'=>'form-control','id'=>'aukultasi_teratur','name'=>'aukultasi_teratur']) ?>
					</div>
					<div class="col-6">
						B. Anogenital <br>
							<b>*Inspeksi :</b>
							<?= select('Pengeluaran pervaginam :',[
								'Tidak Ada' => 'Tidak Ada',
								'Darah' => 'Darah',
								'Air Ketuban' => 'Air Ketuban',
								'Lendir' => 'Lendir',
								'Tali Pusat' => 'Tali Pusat',
								'Bagian Kecil Janin' => 'Bagian Kecil Janin',
								'Nanah' => 'Nanah',
							],['class'=>'form-control','id'=>'pengeluaran_pervaginam','name'=>'pengeluaran_pervaginam']) ?>
							<?= textArea('Lochea :',[
								'name'=>'lochea',
								'class'=>'form-control',
								'id'=>'lochea',
								'required'=>true
							]) ?>
							<?= textInput('Volume',['type'=>'number','placeholder'=> 'CC','name'=>'volume_anogenital','class'=>'form-control','id'=>'volume_anogenital','required'=>true]) ?>
							<?= select('Berbau :',[
								'Tidak' => 'Tidak',
								'Amis' => 'Amis',
								'Busuk' => 'Busuk',
							],['class'=>'form-control','id'=>'berbau_anogenital','name'=>'berbau_anogenital']) ?>
							<?= select('Perinium :',[
								'Utuh' => 'Utuh',
								'Laserasi' => 'Laserasi',
							],['class'=>'form-control','id'=>'perinium','name'=>'perinium']) ?>
							<?= textInput('Derajat',['name'=>'derajat_anogenital','class'=>'form-control','id'=>'derajat_anogenital','required'=>true]) ?>
							<?= select('Jahitan :',[
								'Baik' => 'Baik',
								'Hematom' => 'Laserasi',
								'Lepas' => 'Lepas',
								'Oedem' => 'Oedem',
								'Ekimosis' => 'Ekimosis',
								'Kemerahan' => 'Kemerahan',
							],['class'=>'form-control','id'=>'jahitan_anogenital','name'=>'jahitan_anogenital']) ?>
							<b>*Inspekulo Vagina :</b><br>
							<?= textArea('Kelainan :',[
								'name'=>'kelainan_inspekulo',
								'class'=>'form-control',
								'id'=>'kelainan_inspekulo',
								'placeholder' => 'Candiloma, Septum, Varises'
							]) ?>
							<?= textArea('Hymen :',[
								'name'=>'hymen_inspekulo',
								'class'=>'form-control',
								'id'=>'hymen_inspekulo',
								'required'=>true,
								'placeholder' => 'Utuh, Robek, Keadaan Sekitar Robekan'
							]) ?>
							<?= textArea('Portio :',[
								'name'=>'portio',
								'class'=>'form-control',
								'id'=>'portio',
								'required'=>true,
								'placeholder' => 'Utuh, Rapuh, .....'
							]) ?>
							<b>Vagina Toucher</b><br>
							<?= textInput('Oleh',['name'=>'toucher_oleh','class'=>'form-control','id'=>'toucher_oleh','required'=>true]) ?>
							<?= textInput('Tgl',['type' => 'date','name'=>'toucher_tgl','class'=>'form-control','id'=>'toucher_tgl','required'=>true]) ?>
							<?= textInput('Jam',['type' => 'time','name'=>'toucher_jam','class'=>'form-control','id'=>'toucher_jam','required'=>true]) ?>
							<?= textInput('Pembukaan',['name'=>'pembukaan','class'=>'form-control','id'=>'pembukaan','required'=>true]) ?>
							<?= textInput('Effacment',['name'=>'effactment','class'=>'form-control','id'=>'effactment','required'=>true]) ?>
							<?= textInput('Terbawah',['name'=>'terbawah','class'=>'form-control','id'=>'terbawah','required'=>true]) ?>
							<?= textArea('Cervix :',[
								'name'=>'cervix',
								'class'=>'form-control',
								'id'=>'cervix',
								'required'=>true,
							]) ?>
							<b>Pemeriksaan Panggul :</b><br>
							<?= textInput('Promont',['name'=>'panggul_promont','class'=>'form-control','id'=>'panggul_promont','required'=>true]) ?>
							<?= textInput('Line Innom',['name'=>'linea_innom','class'=>'form-control','id'=>'linea_innom','required'=>true]) ?>
							<?= textInput('Sacrum',['name'=>'sacrum','class'=>'form-control','id'=>'sacrum','required'=>true]) ?>
							<?= textInput('Spin Isch',['name'=>'spin','class'=>'form-control','id'=>'spin','required'=>true]) ?>
							<?= textArea('Kesan Panggul :',[
								'name'=>'kesan_panggul',
								'class'=>'form-control',
								'id'=>'kesan_panggul',
								'required'=>true,
							]) ?>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-6">
				<?= textArea('USG :',[
					'name'=>'usg',
					'class'=>'form-control',
					'id'=>'usg',
					'required'=>true,
				]) ?>
				<?= textArea('Labotarium :',[
					'name'=>'labotarium',
					'class'=>'form-control',
					'id'=>'labotarium',
					'required'=>true,
				]) ?>
			</div>
			<div class="col-6">
					<?= textArea('Terapi Tindakan :',[
					'name'=>'terapi',
					'class'=>'form-control',
					'id'=>'terapi',
					'required'=>true,
				]) ?>
				<?= textArea('Rencana Kerja :',[
					'name'=>'rencana_kerja',
					'class'=>'form-control',
					'id'=>'rencana_kerja',
					'required'=>true,
				]) ?>
			</div>
			<div class="col-6">
			<b>DISPOSISI</b><br>
				<?= textArea('Kontrol Poliklinik :',[
					'name'=>'kontrol',
					'class'=>'form-control',
					'id'=>'kontrol',
					'required'=>true,
				]) ?>
				<?= textInput('Dirawat Diruang',['name'=>'rawat_ruang','class'=>'form-control','id'=>'rawat_ruang','required'=>true]) ?>
			</div>
			<div class="col-6">
				<br>
				<?= textInput('Kelas',['name'=>'kelas','class'=>'form-control','id'=>'kelas','required'=>true]) ?>
				<?= textInput('Tanggal',['type'=>'date','name'=>'tanggal','class'=>'form-control','id'=>'tanggal','required'=>true]) ?>
			</div>
		</div>
		
		<?= submitButton('btn-save-p-dalam', 'btn btn-success', 'submit', 'Simpan') ?>
		<?php
		echo formClose();
		?>
	</div>
	<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery-1.9.1.js"></script>
	<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery.form.js"></script>
    <script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>
    <script type="text/javascript" src="../../theme/js/ajax.js"></script>

	<script src="../../theme/bs/bootstrap.min.js"></script>
	<script>
					
		$('#keluhan_utama').val('<?=$sql['keluhan_utama']?>');
		$('#riwayat_penyakit_sekarang').val('<?=$sql['riwayat_penyakit_sekarang']?>');
		$('#umur_menstruasi').val('<?=$riwayat_menstruasi[0]?>');
		$('#siklus').val('<?=$riwayat_menstruasi[1]?>');
		$('#teratur_siklus').val('<?=$riwayat_menstruasi[2]?>');
		$('#lama_menstruasi').val('<?=$riwayat_menstruasi[3]?>');
		$('#volume_menstruasi').val('<?=$riwayat_menstruasi[4]?>');
		$('#keluhan_haid').val('<?=$riwayat_menstruasi[5]?>');
		$('#status_kawin').val('<?=$riwayat_perkawinan[0]?>');
		$('#umur_kawin').val('<?=$riwayat_perkawinan[1]?>');
		$('#riwayat_pemakaian_kontrasepsi').val('<?=$riwayat_pemakaian_alat_kontrasepsi[0]?>');
		$('#jenis_kontrasepsi').val('<?=$riwayat_pemakaian_alat_kontrasepsi[1]?>');
		$('#lama_pemakaian').val('<?=$riwayat_pemakaian_alat_kontrasepsi[2]?>');
		$('#hari_pertama_terakhir').val('<?=$riwayat_hamil_ini[0]?>');
		$('#tafsiran_partus').val('<?=$riwayat_hamil_ini[1]?>');
		$('#ante_natal_care').val('<?=$riwayat_hamil_ini[2]?>');
		$('#frekuensi').val('<?=$riwayat_hamil_ini[3]?>');
		$('#imunisasi_tt').val('<?=$riwayat_hamil_ini[4]?>');
		$('#keluhan_hamil').val('<?=$riwayat_hamil_ini[5]?>');
		$('#riwayat_penyakit_lalu').val('<?=$riwayat_penyakit_yang_lalu[0]?>');
		$('#pernah_dirawat').val('<?=$riwayat_penyakit_yang_lalu[1]?>');
		$('#alasan_dirawat').val('<?=$riwayat_penyakit_yang_lalu[2]?>');
		$('#tanggal_dirawat').val('<?=$riwayat_penyakit_yang_lalu[3]?>');
		$('#pernah_dioperasi').val('<?=$riwayat_penyakit_yang_lalu[4]?>');
		$('#jenis_operasi').val('<?=$riwayat_penyakit_yang_lalu[5]?>');
		$('#tanggal_operasi').val('<?=$riwayat_penyakit_yang_lalu[6]?>');
		$('#di_operasi').val('<?=$riwayat_penyakit_yang_lalu[7]?>');
		$('#penyakit_gykenologi').val('<?=$sql['riwayat_penyakit_gynekologi']?>');
		$('#riwayat_penyakit_keluaraga').val('<?=$sql['riwayat_penyakit_keluarga']?>');
		$('#mata_konjuctiva').val('<?=$mata[0]?>');
		$('#mata_sclera').val('<?=$mata[1]?>');
		$('#paru').val('<?=$sql['paru']?>');
		$('#leher_tyroid').val('<?=$sql['leher']?>');
		$('#jantung').val('<?=$sql['dada']?>');
		$('#exter_tungkai').val('<?=$extermitas[0]?>');
		$('#refleks_enter').val('<?=$extermitas[1]?>');
		$('#edema').val('<?=$extermitas[2]?>');
		$('#bentuk_mamae').val('<?=$mamae[0]?>');
		$('#mamae_2').val('<?=$mamae[1]?>');
		$('#mamae_pengeluaran').val('<?=$mamae[2]?>');
		$('#mamae_kebersihan').val('<?=$mamae[3]?>');
		$('#kelainan_mamae').val('<?=$mamae[4]?>');
		$('#luka_operasi').val('<?=$inspeksi[0]?>');
		$('#area_pembesaran').val('<?=$inspeksi[1]?>');
		$('#kelainan_abdomen').val('<?=$inspeksi[2]?>');
		$('#tinggi_fundus').val('<?=$palpasi[0]?>');
		$('#punggung_letak').val('<?=$palpasi[1]?>');
		$('#persentasi').val('<?=$palpasi[2]?>');
		$('#bagian_terendah').val('<?=$palpasi[3]?>');
		$('#osborn_test').val('<?=$palpasi[4]?>');
		$('#konstraksi_uterus').val('<?=$palpasi[5]?>');
		$('#his').val('<?=$palpasi[6]?>');
		$('#lama_palpasi').val('<?=$palpasi[7]?>');
		$('#kelainan_palpasi').val('<?=$palpasi[8]?>');
		$('#teraba_massa').val('<?=$palpasi[9]?>');
		$('#ukuran_palpasi').val('<?=$palpasi[10]?>');
		$('#taksiran_berat').val('<?=$palpasi[11]?>');
		$('#bising_usus').val('<?=$auskultasi[0]?>');
		$('#aukultasi_djj').val('<?=$auskultasi[1]?>');
		$('#aukultasi_teratur').val('<?=$auskultasi[2]?>');
		$('#pengeluaran_pervaginam').val('<?=$inspeksi_anogenital[0]?>');
		$('#lochea').val('<?=$inspeksi_anogenital[1]?>');
		$('#volume_anogenital').val('<?=$inspeksi_anogenital[2]?>');
		$('#berbau_anogenital').val('<?=$inspeksi_anogenital[3]?>');
		$('#perinium').val('<?=$inspeksi_anogenital[4]?>');
		$('#derajat_anogenital').val('<?=$inspeksi_anogenital[5]?>');
		$('#jahitan_anogenital').val('<?=$inspeksi_anogenital[6]?>');
		$('#kelainan_inspekulo').val('<?=$inspeksi_anogenital[7]?>');
		$('#hymen_inspekulo').val('<?=$inspeksi_anogenital[8]?>');
		$('#portio').val('<?=$inspeksi_anogenital[9]?>');
		$('#toucher_oleh').val('<?=$inspeksi_anogenital[10]?>');
		$('#toucher_tgl').val('<?=$inspeksi_anogenital[11]?>');
		$('#toucher_jam').val('<?=$inspeksi_anogenital[12]?>');
		$('#pembukaan').val('<?=$inspeksi_anogenital[13]?>');
		$('#effactment').val('<?=$inspeksi_anogenital[14]?>');
		$('#terbawah').val('<?=$inspeksi_anogenital[15]?>');
		$('#cervix').val('<?=$inspeksi_anogenital[16]?>');
		$('#panggul_promont').val('<?=$inspeksi_anogenital[17]?>');
		$('#linea_innom').val('<?=$inspeksi_anogenital[18]?>');
		$('#sacrum').val('<?=$inspeksi_anogenital[19]?>');
		$('#spin').val('<?=$inspeksi_anogenital[20]?>');
		$('#kesan_panggul').val('<?=$inspeksi_anogenital[21]?>');
		$('#usg').val('<?=$sql['usg']?>');
		$('#terapi').val('<?=$sql['terapi_tindakan']?>');
		$('#labotarium').val('<?=$sql['laboratorium']?>');
		$('#kontrol').val('<?=$sql['kontrol_poliklinik']?>');
		$('#kelas').val('<?=$sql['kelas']?>');
		$('#rawat_ruang').val('<?=$sql['dirawat_ruang']?>');
		$('#kelas').val('<?=$sql['kelas']?>');
		$('#tanggal').val('<?=$sql['tanggal']?>');
		$('#rencana_kerja').val('<?=$sql['rencana_kerja']?>');

		<?php if(isset($_REQUEST['id'])): ?>
			isiCombo('cmbDokSemua',2,<?=$sql['petugas_anamnesa']?>,'');
		<?php else: ?>
			isiCombo('cmbDokSemua',2,732,'');
		<?php endif; ?>

	function gantiDokter(comboDokter,statusCek,disabel){
		if(statusCek==true){
			isiCombo('cmbDokPengganti',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokTind',refreshDok);
			isiCombo('cmbDokPengganti',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokRujukUnit,cmbDokRujukDokter,cmbDokRujukRS,cmbDokDiag,cmbDokResep,cmbDokAnamnesa,cmbDokSOAPIER,cmbDokRad');
		}
		else{
			isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokTind',refreshDok);
			isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokRujukUnit,cmbDokRujukDokter,cmbDokRujukRS,cmbDokDiag,cmbDokResep,cmbDokAnamnesa,cmbDokSOAPIER,cmbDokRad');
		}
	}

	function isiCombo(id,val,defaultId,targetId,evloaded){
            if(targetId=='' || targetId==undefined){
                targetId=id;
            }
			var idArr = targetId.split(',');
			var longArr = idArr.length;
			if(longArr > 1){
				for(var nr = 0; nr < longArr; nr++)
					if(document.getElementById(idArr[nr])==undefined){
						alert('Elemen target dengan id: \''+idArr[nr]+'\' tidak ditemukan!');
						return false;
					}
			}
			else{
				if(document.getElementById(targetId)==undefined){
					alert('Elemen target dengan id: \''+targetId+'\' tidak ditemukan!');
					return false;
				}
			}
			
			if(targetId=='cmbDokterUnit')
			{
				Request('../../combo_utils.php?all=1&id='+id+'&value='+val+'&defaultId='+defaultId+"&cabang=1",targetId,'','GET',evloaded);
			}else{
				Request('../../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId+"&cabang=1",targetId,'','GET',evloaded);
			}
     }

		// Example starter JavaScript for disabling form submissions if there are invalid fields
		(function() {
			'use strict';
			window.addEventListener('load', function() {
				// Fetch all the forms we want to apply custom Bootstrap validation styles to
				var forms = document.getElementsByClassName('needs-validation');
				// Loop over them and prevent submission
				var validation = Array.prototype.filter.call(forms, function(form) {
					form.addEventListener('submit', function(event) {
						if (form.checkValidity() === false) {
							event.preventDefault();
							event.stopPropagation();
						}
						form.classList.add('was-validated');
					}, false);
				});
			}, false);
		})();
	</script>
	</script>
	<script>
	
</script>
</body>

</html>