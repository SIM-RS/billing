<?php
include '../function/form.php';
include '../../koneksi/konek.php';
$dataPasien = getIndetitasPasien($_REQUEST['idKunj']);

$id = $_REQUEST['id'];
$sql = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_2_7_p_bedah WHERE id = '{$id}'"));
$pemeriksaanFisik = explode("|", $sql['pemeriksaan_fisik']);

$arr_data_pf = [];
$arr_data_ket = [];
$yaTidak = [];

$z = 1;

	for($i = 0; $i < 14; $i++){
        $dataPemeriksaanFisik = explode('|', $pemeriksaanFisik[$z]);
		$data = explode(' ', $dataPemeriksaanFisik[0], 2);
		 if ($data[0] == "Normal") {
			array_push($arr_data_pf, "Tidak");
		} else {
			array_push($arr_data_pf, "Ya");
		}

		array_push($arr_data_ket, $data[1]);
		$z=$z+3;
	}
$suhuRectal = $sql['suhu'];
$str2 = "";
$suhuRect = [];
for ($a=0; $a < strlen($suhuRectal); $a++) {
	if ($suhuRectal[$a] != "|") {
		$str2 .= $suhuRectal[$a];
		if ($a == strlen($suhuRectal)-1) {
			array_push($suhuRect, $str2);
			$str2 = "";
		}
	} else {
		array_push($suhuRect, $str2);
		$str2 = "";
	}
}

$r_penyakit = $sql['riwayat_penyakit'];
$str_penyakit = "";
$arr_penyakit = [];
for ($w=0; $w < strlen($r_penyakit); $w++) {
	if ($r_penyakit[$w] != "|") {
		$str_penyakit .= $r_penyakit[$w];
		if ($w == strlen($r_penyakit)-1) {
			array_push($arr_penyakit, $str_penyakit);
			$str_penyakit = "";
		}
	} else {
		array_push($arr_penyakit, $str_penyakit);
		$str_penyakit = "";
	}
}

$r_operasi = $sql['riwayat_operasi'];
$str_operasi = "";
$arr_operasi = [];
for ($w=0; $w < strlen($r_operasi); $w++) {
	if ($r_operasi[$w] != "|") {
		$str_operasi .= $r_operasi[$w];
		if ($w == strlen($r_operasi)-1) {
			array_push($arr_operasi, $str_operasi);
			$str_operasi = "";
		}
	} else {
		array_push($arr_operasi, $str_operasi);
		$str_operasi = "";
	}
}

$riwayat_penyakit_keluarga = $sql['riwayat_penyakit_keluarga'];
$riwayat_penyakit_keluarga_data = [];
$str = "";
for ($i=0; $i < strlen($riwayat_penyakit_keluarga); $i++) {
	if ($riwayat_penyakit_keluarga[$i] != "|") {
		$str .= $riwayat_penyakit_keluarga[$i];
		if ($i == strlen($riwayat_penyakit_keluarga)-1) {
			array_push($riwayat_penyakit_keluarga_data, $str);
			$str = "";
		}
	} else {
		array_push($riwayat_penyakit_keluarga_data, $str);
		$str = "";
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
				<?= textInput('Tanggal Anamnesa', ['name' => 'tanggal_anamnesa', 'class' => 'form-control', 'id' => 'anamnesa', 'required' => true,'type'=>'date', 'value' => $sql['tanggal_anamnesa']]) ?>
			</div>
			<div class="col-6">
				<?= textInput('Jam',['name'=>'jam_anamnesa','class'=>'form-control','required'=>true, 'value' => $sql['jam_anamnesa']]) ?>
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
					'required'=>true

				]) ?>
			</div>
			<div class="col-4">
				<?= textArea('Riwayat Penyakit Dahulu',[
					'name'=>'riwayat_penyakit_dahulu',
					'class'=>'form-control',
					'id'=>'riwayat_penyakit_dahulu',
					'required'=>true
				]) ?>
			</div>
			<div class="col-4">
				<?= textArea('Riwayat Pengobatan',[
					'name'=>'riwayat_pengobatan',
					'class'=>'form-control',
					'id'=>'riwayat_pengobatan',
					'required'=>true

				]) ?>
			</div>
			<div class="col-4">
				<?= textArea('Riwayat Pekerjaan,sosial,ekonomi,psikologi dan kebiasaan',[
					'name'=>'riwayat_pekerjaan',
					'class'=>'form-control',
					'id'=>'riwayat_pekerjaan',
					'required'=>true

				]) ?>
			</div>
		</div>
		<div class="row">
			<div class="col-6">
				<?= select('Riwayat Penyakit Keluarga',[
					'Hipertensi' => 'Hipertensi',
					'Kencing Manis' => 'Kencing Manis',
					'Jantung' => 'Jantung',
					'Asthma' => 'Asthma',
				],['class'=>'form-control','id'=>'riwayat_penyakit_keluarga','name'=>'riwayat_penyakit_keluarga[]','multiple'=>'multiple','input'=>textArea('Riwayat Penyakit Keluarga Lainnya',['name'=>'riwayat_penyakit_keluarga_ll','class'=>'form-control','id'=>'riwayat_penyakit_keluarga_ll'])]) ?>
			</div>
			<div class="col-6">	
				<label for="" class="font-weight-bold">Tanda Tanda Vital</label>
				<div class="row">
					<div class="col-6">
						<?= select('Keadaan Umum',
						['Baik'=>'Baik','Sedang'=>'Sedang','Lemah'=>'Lemah','Jelek'=>'Jelek'],
						[
							'class'=>'form-control',
							'id'=>'keadaan_umum',
							'name'=>'keadaan_umum',
							'required'=>true
					]) ?>
					<?= textInput('GCS',['class'=>'form-control','name'=>'gcs','required'=>true,'id'=>'gcs']) ?>
					<?= textInput('BB',['class'=>'form-control','name'=>'berat_badan','required'=>true,'id'=>'berat_badan']) ?>
					<label for="">Suhu Axital / Rectal (c)</label>
						<div class="row">	
							<div class="col-6">	
								<?= textInput('', ['name' => 'suhu', 'class' => 'form-control', 'id' => 'suhu', 'required' => true]) ?>
							</div>
							<div class="col-6">
								
								<?=  textInput('', ['name' => 'rectal', 'class' => 'form-control', 'id' => 'rectal', 'required' => true]) ?>
							</div>
						</div>
					<?= textInput('Nadi (x/mnt)', ['name' => 'nadi', 'class' => 'form-control', 'id' => 'nadi', 'required' => true]) ?>
					<?= textInput('Saturasi O<sub>2</sub> (%)', ['name' => 'saturasi', 'class' => 'form-control', 'id' => 'saturasi', 'required' => true]) ?>	
					</div>
					<div class="col-6">
						<?= select('Gizi',
						['Baik'=>'Baik','Kurang'=>'Kurang','Buruk'=>'Buruk'],
						[
							'class'=>'form-control',
							'id'=>'gizi',
							'name'=>'gizi',
							'required'=>true
					]) ?>
					<?= yaTidak('Tindakan Resusitasi','Ya','Tidak','tindakan_resusitasi') ?>
					<?= textInput('Tinggi Badan (cm)', ['name' => 'tinggi_badan', 'class' => 'form-control', 'id' => 'tinggi_badan', 'required' => true]) ?>
					<?= textInput('Tensi (mmHg)', ['name' => 'tensi', 'class' => 'form-control', 'id' => 'tensi', 'required' => true]) ?>
					<?= textInput('Respirasi (x/mnt)', ['name' => 'respirasi', 'class' => 'form-control', 'id' => 'respirasi', 'required' => true]) ?>
					<?= textInput('Saturasi 0<sub>2</sub> Pada', ['name' => 'saturasi_pada', 'class' => 'form-control', 'id' => 'saturasi_pada', 'required' => true]) ?>
					</div>
				</div>
			</div>	
		</div>
		<div class="row">
			<div class="col-6">
				<?= select('Riwayat Penyakit',[
					'Hipertensi' => 'Hipertensi',
					'Kencing Manis' => 'Kencing Manis',
					'Jantung' => 'Jantung',
					'Asma' => 'Asma',
					'Stroke' => 'Stroke',
					'Dialysis' => 'Dialysis',
					'Kejang' => 'Kejang',
					'Liver' => 'Liver',
					'Cancer' => 'Cancer',
					'TBC' => 'TBC',
					'Glaukoma' => 'Glaukoma',
					'STD' => 'STD',
					'Perdarahan' => 'Perdarahan',
				],['class'=>'form-control','id'=>'riwayat_penyakit','name'=>'riwayat_penyakit[]','multiple'=>'multiple','input'=>textArea('Riwayat Penyakit Lainnya',['name'=>'riwayat_penyakit_ll','class'=>'form-control','id'=>'riwayat_penyakit_ll'])]) ?>
			</div>
			<div class="col-6">
				<?= yaTidak('Riwayat Operasi','Ya','Tidak','riwayat_operasi',$arr_operasi[0],textArea('Jenis & Kapan',[
					'name'=>'riwayat_operasi_keterangan','class'=>'form-control','id'=>'riwayat_operasi_keterangan'])) ?>	
			</div>
		</div>
		<div class="row">
			<div class="col-6">
				<?= yaTidak('Riwayat Transfusi','Ya','Tidak','riwayat_transfusi') ?>
			</div> 
			<div class="col-6">
				<?= textInput('Reaksi Transfusi',['name'=>'reaksi_transfusi','class'=>'form-control','id'=>'reaksi_transfusi','required'=>true]) ?>	
			</div>
		</div>		
		
		<div class="card">
			<div class="card-header">
				Pemeriksaan Fisik
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-4">
						<?= yaTidak('Kepala','Abnormal','Normal','kepala',$arr_data_pf[0],textArea('',[
						'name'=>'kepala_ket','class'=>'form-control','id'=>'kepala_ket'])) ?>
						<?= yaTidak('Mata','Abnormal','Normal','mata',$arr_data_pf[1],textArea('',[
						'name'=>'mata_ket','class'=>'form-control','id'=>'mata_ket'])) ?>
						<?= yaTidak('THT','Abnormal','Normal','tht',$arr_data_pf[2],textArea('',[
						'name'=>'tht_ket','class'=>'form-control','id'=>'tht_ket'])) ?>
						<?= yaTidak('Leher','Abnormal','Normal','leher',$arr_data_pf[3],textArea('',[
						'name'=>'leher_ket','class'=>'form-control','id'=>'leher_ket'])) ?>
					</div>
					<div class="col-4">
						<?= yaTidak('Dada','Abnormal','Normal','dada',$arr_data_pf[4],textArea('',[
						'name'=>'dada_ket','class'=>'form-control','id'=>'dada_ket'])) ?>
						<?= yaTidak('Jantung','Abnormal','Normal','jantung',$arr_data_pf[5],textArea('',[
						'name'=>'jantung_ket','class'=>'form-control','id'=>'jantung_ket'])) ?>
						<?= yaTidak('Paru','Abnormal','Normal','paru',$arr_data_pf[6],textArea('',[
						'name'=>'paru_ket','class'=>'form-control','id'=>'paru_ket'])) ?>
						<?= yaTidak('Perut','Abnormal','Normal','perut',$arr_data_pf[7],textArea('',[
						'name'=>'perut_ket','class'=>'form-control','id'=>'perut_ket'])) ?>
					</div>
					<div class="col-4">
						<?= yaTidak('Hepar','Abnormal','Normal','hepar',$arr_data_pf[8],textArea('',[
						'name'=>'hepar_ket','class'=>'form-control','id'=>'hepar_ket'])) ?>
						<?= yaTidak('Lien','Abnormal','Normal','lien',$arr_data_pf[9],textArea('',[
						'name'=>'lien_ket','class'=>'form-control','id'=>'lien_ket'])) ?>
						<?= yaTidak('Punggung','Abnormal','Normal','punggung',$arr_data_pf[10],textArea('',[
						'name'=>'punggung_ket','class'=>'form-control','id'=>'punggung_ket'])) ?>
						<?= yaTidak('Genital','Abnormal','Normal','genital',$arr_data_pf[11],textArea('',[
						'name'=>'genital_ket','class'=>'form-control','id'=>'genital_ket'])) ?>
					</div>
					<div class="col-4">
						<?= yaTidak('Ekstremitas','Abnormal','Normal','ekstremitas',$arr_data_pf[12],textArea('',[
						'name'=>'ekstremitas_ket','class'=>'form-control','id'=>'ekstremitas_ket'])) ?>
						<?= yaTidak('Rectal Toucher','Abnormal','Normal','rectal_toucher',$arr_data_pf[13],textArea('',[
						'name'=>'rectal_toucher_ket','class'=>'form-control','id'=>'rectal_toucher_ket'])) ?>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-4">
				<?= textArea('Status Lokalis',[
					'name'=>'status_lokalis',
					'class'=>'form-control',
					'id'=>'status_lokalis',
					'required'=>true

				]) ?>
			</div>
			<div class="col-4">
				<?= textArea('Skema',[
					'name'=>'skema',
					'class'=>'form-control',
					'id'=>'skema',
					'required'=>true

				]) ?>
			</div>
			<div class="col-4">
				<?= textArea('Pemeriksan Penunjang',[
					'name'=>'pemeriksaan_penunjang',
					'class'=>'form-control',
					'id'=>'pemeriksaan_penunjang',
					'required'=>true

				]) ?>
			</div>
		</div>
		<div class="row">
			<div class="col-3">	
				<?= textArea('Diagnosa Kerja',[
					'name'=>'diagnosa_kerja',
					'class'=>'form-control',
					'id'=>'diagnosa_kerja',
					'required'=>true

				]) ?>
			</div>
			<div class="col-3">
				<?= textArea('Diagnosa Differential',[
					'name'=>'diagnosa_differential',
					'class'=>'form-control',
					'id'=>'diagnosa_differential',
					'required'=>true

				]) ?>
			</div>
			<div class="col-3">
				<?= textArea('Terapi',[
					'name'=>'terapi_tindakan',
					'class'=>'form-control',
					'id'=>'terapi_tindakan',
					'required'=>true

				]) ?>
			</div>
			<div class="col-3">
				<?= textArea('Rencana Kerja',[
					'name'=>'rencana_kerja',
					'class'=>'form-control',
					'id'=>'rencana_kerja',
					'required'=>true

				]) ?>
			</div>
		</div>
		<div class="row">
			<div class="col-4">
				<?= textArea('Hasil Pembedahan',[
					'name'=>'hasil_pembedahan',
					'class'=>'form-control',
					'id'=>'hasil_pembedahan',
					'required'=>true
				]) ?>
			</div>
			<div class="col-4">
				<?= textArea('Rekomendasi (Saran)',[
					'name'=>'saran',
					'class'=>'form-control',
					'id'=>'saran',
					'required'=>true
				]) ?>
			</div>
			<div class="col-4">
				<?= textArea('Catatan Penting',[
					'name'=>'catatan_penting',
					'class'=>'form-control',
					'id'=>'catatan_penting',
					'required'=>true
				]) ?>
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

			$('#catatan_penting').val('<?=$sql['catatan_penting']?>');
			$('#keluhan_utama').val('<?=$sql['keluhan_utama']?>');
			$('#riwayat_penyakit_dahulu').val('<?=$sql['riwayat_penyakit_dahulu']?>');
			$('#riwayat_pengobatan').val('<?=$sql['riwayat_pengobatan']?>');
			$('#riwayat_penyakit_sekarang').val('<?=$sql['riwayat_penyakit_sekarang']?>');
			$('#riwayat_pekerjaan').val('<?=$sql['riwayat_pekerjaan']?>');
			$('#riwayat_penyakit_keluarga').val('<?=$riwayat_penyakit_keluarga_data[0]?>');
			$('#riwayat_penyakit_keluarga_ll').val('<?=$riwayat_penyakit_keluarga_data[1]?>');
			$('#riwayat_penyakit').val('<?=$arr_penyakit[0]?>');
			$('#riwayat_penyakit_ll').val('<?=$arr_penyakit[1]?>');
			$('#suhu').val('<?=$suhuRect[0]?>');
			$('#rectal').val('<?=$suhuRect[1]?>');
			$('#keadaan_umum').val('<?=$sql['keadaan_umum']?>');
			$('#gizi').val('<?=$sql['gizi']?>');
			$('#gcs').val('<?=$sql['gcs']?>');
			$('#berat_badan').val('<?=$sql['berat_badan']?>');
			$('#tinggi_badan').val('<?=$sql['tinggi_badan']?>');
			$('#tensi').val('<?=$sql['tensi']?>');
			$('#nadi').val('<?=$sql['nadi']?>');
			$('#respirasi').val('<?=$sql['respirasi']?>');
			$('#saturasi').val('<?=$sql['saturasi']?>');
			$('#saturasi_pada').val('<?=$sql['saturasi_pada']?>');
			$('#reaksi_transfusi').val('<?=$sql['reaksi_transfusi']?>');
			$('#status_lokalis').val('<?=$sql['status_lokasi']?>');
			$('#skema').val('<?=$sql['skema']?>');
			$('#diagnosa_kerja').val('<?=$sql['diagnosa_kerja']?>');
			$('#pemeriksaan_penunjang').val('<?=$sql['pemeriksaan_penunjang']?>');
			$('#diagnosa_differential').val('<?=$sql['diagnosa_differential']?>');
			$('#terapi_tindakan').val('<?=$sql['terapi_tindakan']?>');
			$('#rencana_kerja').val('<?=$sql['rencana_kerja']?>');
			$('#saran').val('<?=$sql['saran']?>');
			$('#hasil_pembedahan').val('<?=$sql['hasil_pembedahan']?>');

			$('#kepala_ket').val('<?=$arr_data_ket[0]?>');
			$('#mata_ket').val('<?=$arr_data_ket[1]?>');
			$('#tht_ket').val('<?=$arr_data_ket[2]?>');
			$('#leher_ket').val('<?=$arr_data_ket[3]?>');
			$('#dada_ket').val('<?=$arr_data_ket[4]?>');
			$('#jantung_ket').val('<?=$arr_data_ket[5]?>');
			$('#paru_ket').val('<?=$arr_data_ket[6]?>');
			$('#perut_ket').val('<?=$arr_data_ket[7]?>');
			$('#hepar_ket').val('<?=$arr_data_ket[8]?>');
			$('#lien_ket').val('<?=$arr_data_ket[9]?>');
			$('#punggung_ket').val('<?=$arr_data_ket[10]?>');
			$('#genital_ket').val('<?=$arr_data_ket[11]?>');
			$('#ekstremitas_ket').val('<?=$arr_data_ket[12]?>');
			$('#rectal_toucher_ket').val('<?=$arr_data_ket[13]?>');
			$('#riwayat_operasi_keterangan').val('<?=$arr_operasi[1]?>');
			
		let radio = $('input[type="radio"]');
		let radioData = 	['<?=$sql['tindakan_resusitasi'];?>',
							'<?=$arr_operasi[0];?>',
							'<?=$sql['riwayat_transfusi']?>',
							'<?=$arr_data_pf[0]?>',
							'<?=$arr_data_pf[1]?>',
							'<?=$arr_data_pf[2]?>',
							'<?=$arr_data_pf[3]?>',
							'<?=$arr_data_pf[4]?>',
							'<?=$arr_data_pf[5]?>',
							'<?=$arr_data_pf[6]?>',
							'<?=$arr_data_pf[7]?>',
							'<?=$arr_data_pf[8]?>',
							'<?=$arr_data_pf[9]?>',
							'<?=$arr_data_pf[10]?>',
							'<?=$arr_data_pf[11]?>',
							'<?=$arr_data_pf[12]?>',
							'<?=$arr_data_pf[13]?>',];

		let a = 0;
		for (let i = 0; i < radioData.length; i++) {
			if (radioData[i] == "Ya" || radioData[i] == "Abnormal") {
				radio[a].checked = true;
			} else {
				radio[a+1].checked = true;
			} 
			a=a+2;
		}
					
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