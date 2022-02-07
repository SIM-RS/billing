<?php
include '../function/form.php';
include '../../koneksi/konek.php';
$dataPasien = getIndetitasPasien($_REQUEST['idKunj']);

$id = $_REQUEST['id'];
$sql = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_2_3_p_anak WHERE id = '{$id}'"));

$riwayat_penyakit_keluarga = explode('|',$sql['riwayat_penyakit_keluarga']);
$riwayat_persalinan = explode('|',$sql['riwayat_persalinan']);
$riwayat_nutrisi = explode('|',$sql['riwayat_nutrisi']);
$mata = explode('|',$sql['mata']);
$tht = explode('|',$sql['tht']);
$leher = explode('|',$sql['leher']);
$dirawat_ruang = explode('|',$sql['dirawat_ruang']);

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
				<?= textInput('Jam',['name'=>'jam_anamnesa','class'=>'form-control','required'=>true,'type'=>'time', 'value' => $sql['jam_anamnesa']]) ?>
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
					'Diabetes' => 'Diabetes',
					'Stroke' => 'Stroke',
					'Ginjal' => 'Ginjal',
					'Kejang' => 'Kejang',
					'Hati' => 'Hati',
					'Kanker' => 'Kanker',
					'TB' => 'TB',
					'Glaukoma' => 'Glaukoma',
					'PMS' => 'PMS',
					'Pendarahan' => 'Pendarahan',
				],['class'=>'form-control','id'=>'riwayat_penyakit_keluarga','name'=>'riwayat_penyakit_keluarga[]','multiple'=>'multiple','input'=>textArea('Riwayat Penyakit Keluarga Lainnya',['name'=>'riwayat_penyakit_keluarga_ll','class'=>'form-control','id'=>'riwayat_penyakit_keluarga_ll'])]) ?>
			</div>
			<div class="col-6">	
				<label for="" class="font-weight-bold">Tanda Tanda Vital</label>
				<div class="row">
					<div class="col-6">
					<?= textInput('TB',['class'=>'form-control','name'=>'tinggi_badan','required'=>true,'id'=>'tinggi_badan','placeholder'=>'CM', 'value'=>$sql['tinggi_badan']]) ?>
					<?= textInput('LK',['class'=>'form-control','name'=>'lk','required'=>true,'id'=>'lk','placeholder'=>'CM', 'value'=>$sql['lingkar_kepala']]) ?>
					<?= textInput('Tensi',['class'=>'form-control','name'=>'tensi','required'=>true,'id'=>'tensi','placeholder'=>'mmHg', 'value'=>$sql['tensi']]) ?>
					
					</div>
					<div class="col-6">
					<?= textInput('Nadi', ['name' => 'nadi', 'class' => 'form-control', 'id' => 'nadi', 'required' => true,'placeholder'=>'CM','value'=>$sql['nadi']]) ?>	
					<?= textInput('Pernapasan', ['name' => 'pernapasan', 'class' => 'form-control', 'id' => 'pernapasan', 'required' => true,'placeholder'=>'x/l', 'value'=>$sql['pernapasan']]) ?>	
					<?= textInput('Temperatur', ['name' => 'temperatur', 'class' => 'form-control', 'id' => 'temperatur', 'required' => true,'placeholder'=>'x/i', 'value'=>$sql['temperatur']]) ?>	
					</div>
				</div>
			</div>	
		</div>
		<div class="row">
			<div class="col-6">
				<?= textArea('Riwayat Imunisasi',[
					'name'=>'riwayat_imunisasi',
					'class'=>'form-control',
					'id'=>'riwayat_imunisasi',
					'required'=>true,
					'placeholder'=>'BCG, Polio.....kali, Hepatitis B.....kali, DPT.....kali, Campak.....kali'
				]) ?>
			</div>
			<div class="col-6">
				<?= select('Riwayat Persalinan',[
					'Normal' => 'Normal',
					'Vacum' => 'Vacum',
					'Forceps' => 'Forceps',
					'SC' => 'SC',
				],['class'=>'form-control','id'=>'riwayat_persalinan','name'=>'riwayat_persalinan']) ?>
				<?= textArea('Ditolong Oleh :',[
					'name'=>'ditolong_oleh',
					'class'=>'form-control',
					'id'=>'ditolong_oleh',
					'required'=>true,
					'placeholder' => 'Dokter, Bidan, Lainnya'
				]) ?>
				<?= textInput('BB',['class'=>'form-control','name'=>'bb','required'=>true,'id'=>'bb','placeholder' => 'Gram']) ?>
				<?= textInput('PB',['class'=>'form-control','name'=>'pb','required'=>true,'id'=>'pb','placeholder' => 'CM']) ?>
				<?= textInput('LK',['class'=>'form-control','name'=>'lk_rp','required'=>true,'id'=>'lk_rp','placeholder' => 'CM']) ?>
				<?= select('Keadaan Saat Lahir',[
					'Segera Menangis' => 'Segera Menangis',
					'Tidak Segera Menangis' => 'Tidak Segera Menangis',
				],['class'=>'form-control','id'=>'keadaan_saat_lahir','name'=>'keadaan_saat_lahir']) ?>
			</div>
			<div class="col-6">
				<b>Riwayat Nutrisi</b>
				<?= textInput('ASI',['class'=>'form-control','name'=>'asi','placeholder'=>'Eksklusif.....bulan, Durasi.....bulan, Frekuensi.....hari','required'=>true,'id'=>'asi','value'=>$riwayat_nutrisi[0]]) ?>
				<?= textInput('Susu Formula',['class'=>'form-control','name'=>'susu_formula','placeholder'=>'Sejak Usia.....bulan, Frekuensi.....hari','required'=>true,'id'=>'susu_formula','value'=>$riwayat_nutrisi[1]]) ?>
				<?= textInput('Bubur Susu',['class'=>'form-control','name'=>'bubur_susu','placeholder'=>'Sejak Usia.....bulan, Frekuensi.....hari','required'=>true,'id'=>'bubur_susu','value'=>$riwayat_nutrisi[2]]) ?>
				<?= textInput('Nasi Tim',['class'=>'form-control','name'=>'nasi_tim','placeholder'=>'Sejak Usia.....bulan, Frekuensi.....hari','required'=>true,'id'=>'nasi_tim','value'=>$riwayat_nutrisi[3]]) ?>
				<?= textInput('Makanan Dewasa',['class'=>'form-control','name'=>'makanan_dewasa','placeholder'=>'Sejak Usia.....bulan, Frekuensi.....hari','required'=>true,'id'=>'makanan_dewasa','value'=>$riwayat_nutrisi[4]]) ?>
			</div>
			<div class="col-6">
				<?= textArea('Riwayat Tumbuh Kembang',[
					'name'=>'riwayat_tumbuh_kembang',
					'class'=>'form-control',
					'id'=>'riwayat_tumbuh_kembang',
					'required'=>true,
				]) ?>
			</div>
		</div>	
		
		<div class="card">
			<div class="card-header">
				Pemeriksaan Umum
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-4">
						<?= textInput('Kepala',['class'=>'form-control','name'=>'kepala','placeholder'=>'Normal, Mikrosefali, Makrosefali, Lainnya','required'=>true,'id'=>'kepala','value'=>$sql['kepala']]) ?>
						<b>Mata :</b>
						<?= select('Konjugtiva Pucat',[
							'Ya' => 'Ya',
							'Tidak' => 'Tidak',
						],['class'=>'form-control','id'=>'konjugtiva_pucat','name'=>'konjugtiva_pucat']) ?>
						<?= select('Hiperemi',[
							'Ya' => 'Ya',
							'Tidak' => 'Tidak',
						],['class'=>'form-control','id'=>'hiperemi','name'=>'hiperemi']) ?>
						<?= select('Sekret',[
							'Ya' => 'Ya',
							'Tidak' => 'Tidak',
						],['class'=>'form-control','id'=>'sekret','name'=>'sekret']) ?>
						<?= select('Sklera Ikterik',[
							'Ya' => 'Ya',
							'Tidak' => 'Tidak',
						],['class'=>'form-control','id'=>'sklera_ikterik','name'=>'sklera_ikterik']) ?>
						<?= select('Pupil isokor',[
							'Ya' => 'Ya',
							'Tidak' => 'Tidak',
						],['class'=>'form-control','id'=>'pupil_isokor','name'=>'pupil_isokor']) ?>
						<?= select('Reflek cahaya Oedema',[
							'Ya' => 'Ya',
							'Tidak' => 'Tidak',
						],['class'=>'form-control','id'=>'reflek_cahaya_oedema','name'=>'reflek_cahaya_oedema']) ?>
					</div>
					<div class="col-4">
						<b>THT :</b>
						<?= textInput('Telinga',['class'=>'form-control','name'=>'telinga','required'=>true,'id'=>'telinga','value'=>$tht[0]]) ?>
						<?= textInput('Tenggorokan',['class'=>'form-control','name'=>'tenggorokan','required'=>true,'id'=>'tenggorokan','value'=>$tht[1]]) ?>
						<?= textInput('Lidah',['class'=>'form-control','name'=>'lidah','required'=>true,'id'=>'lidah','value'=>$tht[2]]) ?>
						<?= textInput('Bibir',['class'=>'form-control','name'=>'bibir','required'=>true,'id'=>'bibir','value'=>$tht[3]]) ?>
						<?= textInput('Faring',['class'=>'form-control','name'=>'faring','required'=>true,'id'=>'faring','value'=>$tht[4]]) ?>
						<?= textInput('Tonsil',['class'=>'form-control','name'=>'tonsil','required'=>true,'id'=>'tonsil','value'=>$tht[5]]) ?>
						<?= textInput('Hidung',['class'=>'form-control','name'=>'hidung','required'=>true,'id'=>'hidung','value'=>$tht[6]]) ?>
					</div>
					<div class="col-4">
						<b>Leher :</b>
						<?= textInput('JVP',['class'=>'form-control','name'=>'jvp','required'=>true,'id'=>'jvp','value'=>$leher[0]]) ?>
						<?= select('Pembesaran Kelenjar',[
							'Ya' => 'Ya',
							'Tidak' => 'Tidak',
						],['class'=>'form-control','id'=>'pembesaran_kelenjar','name'=>'pembesaran_kelenjar']) ?>
						<?= textInput('Ukuran Kelenjar',['class'=>'form-control','name'=>'ukuran_kelenjar','required'=>true,'id'=>'ukuran_kelenjar','value'=>$leher[2]]) ?>
						<?= select('Thoraks :',[
							'Simetris' => 'Simetris',
							'Asimetris' => 'Asimetris',
						],['class'=>'form-control','id'=>'thoraks','name'=>'thoraks']) ?>
						<?= textArea('- Cor',[
							'name'=>'cor',
							'class'=>'form-control',
							'id'=>'cor',
							'required'=>true,
							'placeholder'=>'S1, S2.....reguler/Ireguler, Murmur....., Lain-lain.....'
						]) ?>
						<?= textArea('- Pulmo',[
							'name'=>'pulmo',
							'class'=>'form-control',
							'id'=>'pulmo',
							'required'=>true,
							'placeholder'=>'Suara napas....., Rales....., Wheezing....., Lain-lain.....'
						]) ?>
					</div>
					<div class="col-4">
						<?= textArea('Abdomen',[
							'name'=>'abdomen',
							'class'=>'form-control',
							'id'=>'abdomen',
							'required'=>true,
							'placeholder'=>'Distensi....., Nyeri tekan.....Lokasi....., Meteorismus....., Peristaltik....., Turgor....., Asites.....'
						]) ?>
						<?= textInput('- Hepar',['class'=>'form-control','name'=>'hepar','required'=>true,'id'=>'hepar','value'=>'hepar']) ?>
						<?= textInput('- Lien',['class'=>'form-control','name'=>'lien','required'=>true,'id'=>'lien','value'=>'lien']) ?>
						<?= textInput('- Massa',['class'=>'form-control','name'=>'massa','required'=>true,'id'=>'massa','value'=>'massa']) ?>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-4">
				<?= textArea('Extermitas',[
							'name'=>'extermitas',
							'class'=>'form-control',
							'id'=>'extermitas',
							'required'=>true,
							'placeholder'=>'Hangat/Dingin....., Odema....., CRT....., Lain-lain.....'
						]) ?>
						<?= textInput('Kulit',['class'=>'form-control','name'=>'kulit','required'=>true,'id'=>'kulit','value'=>$sql['kulit']]) ?>
						<?= textInput('Genitalia eksterna',['class'=>'form-control','name'=>'genetalie_eksterna','required'=>true,'id'=>'genetalie_eksterna','value'=>$sql['genitalia_eksterna']]) ?>
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
				<?= textArea('Diagnosa Banding',[
					'name'=>'diagnosa_banding',
					'class'=>'form-control',
					'id'=>'diagnosa_banding',
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
			<div class="col-3">
				<?= textInput('Jam Keluar',['class'=>'form-control','name'=>'jam_keluar','required'=>true,'id'=>'jam_keluar','type'=>'time','value'=>$sql['jam_keluar']]) ?>
				<?= textInput('Kontrol Poliklinik',['class'=>'form-control','name'=>'kontrol_poliklinik','required'=>true,'id'=>'kontrol_poliklinik', 'placeholder'=>'Ya.....Tanggal....., Tidak','value'=>$sql['kontrol_poliklinik']]) ?>
				<?= textInput('Dirawat Diruang',['class'=>'form-control','name'=>'ruangan','required'=>true,'id'=>'ruangan', 'placeholder'=>'Ruangan....., Kelas','value'=>$dirawat_ruang[0]]) ?>
				<?= textInput('Konsul',['class'=>'form-control','name'=>'konsul','id'=>'konsul','value'=>$dirawat_ruang[1]]) ?>
				<?= textInput('Devisi/Dept',['class'=>'form-control','name'=>'devisi','id'=>'devisi','value'=>$dirawat_ruang[2]]) ?>

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

		$("#keluhan_utama").val("<?= $sql['keluhan_utama'] ?>");
		$("#riwayat_penyakit_dahulu").val("<?= $sql['riwayat_penyakit_dahulu'] ?>");
		$("#riwayat_pengobatan").val("<?= $sql['riwayat_pengobatan'] ?>");
		$("#riwayat_penyakit_keluarga").val("<?= $riwayat_penyakit_keluarga[0] ?>");
		$("#riwayat_penyakit_keluarga_ll").val("<?= $riwayat_penyakit_keluarga[1] ?>");
		$("#riwayat_imunisasi").val("<?= $sql['riwayat_imunisasi'] ?>");
		$("#riwayat_persalinan").val("<?= $riwayat_persalinan[0] ?>");
		$("#ditolong_oleh").val("<?= $riwayat_persalinan[1] ?>");
		$("#bb").val("<?= $riwayat_persalinan[2] ?>");
		$("#pb").val("<?= $riwayat_persalinan[3] ?>");
		$("#lk_rp").val("<?= $riwayat_persalinan[4] ?>");
		$("#keadaan_saat_lahir").val("<?= $riwayat_persalinan[5] ?>");
		$("#riwayat_tumbuh_kembang").val("<?= $sql['riwayat_tumbuh_kembang'] ?>");
		$("#konjugtiva_pucat").val("<?= $mata[0] ?>");
		$("#hiperemi").val("<?= $mata[1] ?>");
		$("#sekret").val("<?= $mata[2] ?>");
		$("#sklera_ikterik	").val("<?= $mata[3] ?>");
		$("#pupil_isokor").val("<?= $mata[4] ?>");
		$("#reflek_cahaya_oedema").val("<?= $mata[5] ?>");
		$("#pembesaran_kelenjar").val("<?= $leher[1] ?>");
		$("#thoraks").val("<?= $sql['thoraks'] ?>");
		$("#cor").val("<?= $sql['cor'] ?>");
		$("#pulmo").val("<?= $sql['pulmo'] ?>");
		$("#abdomen").val("<?= $sql['abdomen'] ?>");
		$("#extermitas").val("<?= $sql['ekstremitas'] ?>");
		$("#diagnosa_kerja").val("<?= $sql['diagnosa_kerja'] ?>");
		$("#diagnosa_banding").val("<?= $sql['diagnosa_differential'] ?>");
		$("#terapi_tindakan").val("<?= $sql['terapi_tindakan'] ?>");
		$("#rencana_kerja").val("<?= $sql['rencana_kerja'] ?>");

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