<?php
include '../function/form.php';
include '../../koneksi/konek.php';
$dataPasien = getIndetitasPasien($_REQUEST['idKunj']);

$id = $_REQUEST['id'];
$sql = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_2_2_p_dalam WHERE id = '{$id}'"));

$petugas = mysql_fetch_assoc(mysql_query("SELECT nama FROM b_ms_pegawai WHERE id = '{$sql['petugas_anamnesa']}'"));
$petugas_anamnesa = $petugas['nama'];

$riwayat_penyakit_keluarga = $sql['riwayat_penyakit_keluarga'];
$riwayat_penyakit_keluarga_data = [];

$suhuRectal = $sql['suhu'];
$suhuRect = [];

$str = "";
$str2 = "";

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

		<?= textInput('Anamnesa', ['value' => $asd,'name' => 'anamnesa', 'class' => 'form-control', 'id' => 'anamnesa', 'required' => true, 'value' => $sql['anamnesa']]) ?>
		<div class="row">
			<div class="col-6">
				<?= textInput('Tanggal Anamnesa', ['name' => 'tanggal_anamnesa', 'class' => 'form-control', 'id' => 'anamnesa', 'required' => true,'type'=>'date', 'value' => $sql['tanggal_anamnesa'] ]) ?>
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
		</div>
		<div class="row">
			<div class="col-6">
				<?= select('Riwayat Penyakit Keluarga',[
					'Hipertensi' => 'Hipertensi',
					'Kencing Manis' => 'Kencing Manis',
					'Jantung' => 'Jantung',
					'Asthma' => 'Asthma',
				],['class'=>'form-control','id'=>'riwayat_penyakit_keluarga','name'=>'riwayat_penyakit_keluarga[]','multiple'=>'multiple','required'=>true,'input'=>textArea('Riwayat Penyakit Keluarga Lainnya',['name'=>'riwayat_penyakit_keluarga_ll','class'=>'form-control','id'=>'riwayat_penyakit_keluarga_ll'])]) ?>
			</div>
			<div class="col-6">	
				<div class="row">	
					<div class="col-6">
						<?= textInput('Tinggi Badan (cm)', ['name' => 'tinggi_badan', 'class' => 'form-control', 'id' => 'tinggi_badan', 'required' => true, 'value' => $sql['tinggi_badan']]) ?>
						<?= textInput('Tensi (mmHg)', ['name' => 'tensi', 'class' => 'form-control', 'id' => 'tensi', 'required' => true, 'value' => $sql['tensi']]) ?>
					</div>
					<div class="col-6">
						<label for="">Suhu Axital / Rectal (c)</label>
						<div class="row">	
							<div class="col-6">	
								<?= textInput('', ['name' => 'suhu', 'class' => 'form-control', 'id' => 'suhu', 'required' => true, 'value' => $suhuRect[0] ]) ?>
							</div>
							<div class="col-6">
								
								<?=  textInput('', ['name' => 'rectal', 'class' => 'form-control', 'id' => 'rectal', 'required' => true, 'value' => $suhuRect[1] ]) ?>
							</div>
						</div>	
					</div>
				</div>	
			</div>	
		</div>	
		<div class="row">
			<div class="col-3">	
				<?= textArea('Kepala & Leher',[
					'name'=>'kepala_leher',
					'class'=>'form-control',
					'id'=>'kepala_leher',
					'required'=>true
				]) ?>
			</div>
			<div class="col-3">
				<?= textArea('Thoraks',[
					'name'=>'thoraks',
					'class'=>'form-control',
					'id'=>'thoraks',
					'required'=>true
				]) ?>
			</div>
			<div class="col-3">
				<?= textArea('Abdomen',[
					'name'=>'abdomen',
					'class'=>'form-control',
					'id'=>'abdomen',
					'required'=>true
				]) ?>
			</div>
			<div class="col-3">
				<?= textArea('Ekstermitas',[
					'name'=>'ekstermitas',
					'class'=>'form-control',
					'id'=>'ekstermitas',
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
				<?= textArea('Terapi / Tindakan',[
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
		$('#riwayat_penyakit_dahulu').val('<?=$sql['riwayat_penyakit_dahulu']?>');
		$('#riwayat_pengobatan').val('<?=$sql['riwayat_pengobatan']?>');

		$('#riwayat_penyakit_keluarga').val('<?=$riwayat_penyakit_keluarga_data[0]?>');
		$('#riwayat_penyakit_keluarga_ll').val('<?=$riwayat_penyakit_keluarga_data[1]?>');

		$('#kepala_leher').val('<?=$sql['kepala_leher']?>');
		$('#thoraks').val('<?=$sql['thoraks']?>');
		$('#abdomen').val('<?=$sql['abdomen']?>');
		$('#ekstermitas').val('<?=$sql['ekstermitas']?>');
		$('#diagnosa_kerja').val('<?=$sql['diagnosa_kerja']?>');
		$('#diagnosa_differential').val('<?=$sql['diagnosa_differential']?>');
		$('#terapi_tindakan').val('<?=$sql['terapi_tindakan']?>');
		$('#rencana_kerja').val('<?=$sql['rencana_kerja']?>');
		$('#cmbDokSemua').val('<?=$sql['petugas_anamnesa']?>');
	 
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
	<script>
	
</script>
</body>

</html>