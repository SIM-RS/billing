
<?php
include("../sesi.php");
include '../koneksi/konek.php';
$sqlDataTindakan = "SELECT
						* 
					FROM
						(
						SELECT
							* 
						FROM
							(
							SELECT
								mt.id,
								mt.unit_id,
								mt.kode,
								mt.nama,
								tk.ms_kelas_id,
								tk.tarip,
								tk.tarip_askes,
								tk.ms_tindakan_id,
								tk.id AS idtk,
								k.nama AS kelas,
								kl.nama AS kelompok,
								kla.nama AS klasifikasi,
								mt.ext_tind,
								mt.ak_ms_unit_id 
							FROM
								b_ms_tindakan mt
								INNER JOIN b_ms_tindakan_kelas tk ON tk.ms_tindakan_id = mt.id
								INNER JOIN b_ms_tindakan_unit tu ON tu.ms_tindakan_kelas_id = tk.id
								INNER JOIN b_ms_kelas k ON tk.ms_kelas_id = k.id
								INNER JOIN b_ms_kelompok_tindakan kl ON mt.kel_tindakan_id = kl.id
								INNER JOIN b_ms_klasifikasi kla ON kla.id = mt.klasifikasi_id 
							WHERE
								mt.aktif = 1 
								AND tu.ms_unit_id = '72' 
								AND mt.id IN (1917,1918) 
							ORDER BY
								mt.nama 
							) AS t1 
						) AS gab";
$qSqlDataTindakan = mysql_query($sqlDataTindakan);
?>
<style>
	    #tablep{
        border-collapse: collapse;
        width: 100%;
    }
    #tablep tr td{
        border:1px solid black;
        vertical-align: top;

    }
</style>
<img src="../icon/x.png" width="32" style="float: right; cursor:pointer;" alt="close" class="popup_closebox">
<div style="width: 100%;float: left;">
	<form action="" style="align-items: left;" id="sewa_form_input">
		<table style="width: 100%;text-align: left;">
			<tr>
				<th>Tanggal</th>
			</tr>
			<tr>
				<td>
					<input type="text" id="tgl_sewa_box" name="tgl_sewa_box" readonly="" class="txtinput" value="<?= date('d-m-Y') ?>">
					<input type="button" id="btnSewa" name="btnSewa" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('tgl_sewa_box'),depRange,fungsikosong);">
				</td>	
			</tr>
			<tr>
				<th>Pelayanan</th>
			</tr>
			<tr>
				<td>
					<select name="pelayanan_sewa" id="pelayanan_sewa" class="txtinput">
						<option value="">Pilih Tindakan</option>
						<?php while($d = mysql_fetch_assoc($qSqlDataTindakan)): ?>
							<option value="<?= $d['id'] ?>" data-idkelas = "<?= $d['idtk'] ?>" data-biaya="<?= $d['tarip'] ?>"><?= $d['nama'] . ' - ' . $d['kelas'] . ' - ' . $d['tarip'] ?></option>
						<?php endwhile; ?>
					</select>
				</td>
			</tr>
			<tr>
				<th>Biaya</th>
			</tr>
			<tr>
				<td>
					<input type="text" readonly="" name="biaya" id="biaya" class="txtinput">					
				</td>
			</tr>
			<tr>
				<td style="text-align: center;">
					<button type="button" id="aksi" style="width: 120px; height: 20px; border: none; border-radius: 3px; color: white; background-color: #5cb85c;" value="tambah" onclick="simpanSewa(this.value)">
						Save
					</button>
					<button type="reset" style="width: 120px; height: 20px; border: none; border-radius: 3px; color: white; background-color: #f0ad4e;" >
						Cancel
					</button>
				</td>
			</tr>
		</table>
	</form>	
</div>


<div id="gridDataPenyewaan" style="margin-top: 20px;float: left; width: 100%;">
	<table style="text-align: center;" border="1" id="tablep" style="width: 100%;">
		<thead>
			<tr>
				<th>No</th>
				<th>Nama</th>
				<th>Tanggal Masuk</th>
				<th>Tanggal Keluar</th>
				<th>Biaya</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody id="dataSewa">
			
		</tbody>
	</table>
</div>
<div id="pagingSewa" style="width:100%"></div>
<div id="selesaiSewa" style="display: none;">
	<input type="text" id="tgl_sewa_selesai_box" name="tgl_sewa_selesai_box" readonly="" class="txtinput" value="<?= date('d-m-Y') ?>">
	<input type="hidden" id="id_tindakan_sewa" value="">
	<input type="button" id="btnSewaBox" name="btnSewaBox" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('tgl_sewa_selesai_box'),depRange,fungsikosong);">
	<br>
	<button type="button" onclick="simpanTindakan()" style="width: 120px; height: 20px; border: none; border-radius: 3px; color: white; background-color: #f0ad4e;">
		Save
	</button>
	<button type="button" onclick="cancelTindakan()" style="width: 120px; height: 20px; border: none; border-radius: 3px; color: white; background-color: #f0ad4e;" >
		Cancel
	</button>
</div>
<script>
	
	console.log(document.getElementById("akUnit").value);
	function selesai(val){
		jQuery('#selesaiSewa').show();
		jQuery('#sewa_form_input').hide();
		jQuery('#id_tindakan_sewa').val(val);

	}

	function cancelTindakan(){
		jQuery('#selesaiSewa').hide();
		jQuery('#sewa_form_input').show();
	}

	getData();

	function getData(){
		jQuery.ajax({
			url : 'sewa_box_utils.php',
			method: 'post',
			data: {
				'pelayanan_id' : getIdPel,
				'kunjungan_id' : getIdKunj,
				'id_pasien' : getIdPasien,
				'grd' : 'true',
			},
			dataType:'json',
			success:function(data){
				jQuery('#dataSewa').empty();
				let tableRow = `<tr>`;
				console.log(data);
				for(let i = 0; i < data.length; i++){
					tableRow += `<td>${i+1}</td>`
					for(let j = 1; j <= data[i].length-3; j++){
						tableRow += `<td>${data[i][j] == null ? "-" : data[i][j]}</td>`
					}
					if(data[i][data[i].length - 1] == 1){
						tableRow += '<td>Sudah bayar</td>';
					}else{
						tableRow += `<td>
										<button value="${data[i][0]}" onclick="selesai(this.value)" type="button" data-id="${data[i][0]}">selesai</button>
										<button value="${data[i][data[i].length - 1]}|${data[i][4]}|${data[i][0]}" onClick="updateData(this.value)" type="button" data-id="${data[i][0]}">Edit</button>
										<button value="${data[i][0]}" onClick="document.getElementById('id_tindakan_sewa').value = this.value;deleteData(this.value);" type="button" data-id="${data[i][0]}">Hapus</button>
									 </td>`;
						tableRow += `</tr>`;	
					}
					jQuery('#dataSewa').append(tableRow);
					tableRow = `<tr>`;
				}
			}
		});
	}
	

    jQuery('#pelayanan_sewa').change(function(){
    	jQuery('#biaya').val(jQuery(this).find(':selected').data('biaya'));
    	console.log(jQuery('#pelayanan_sewa').data('biaya'));
    });

    function simpanSewa(val){
    	let userId = <?= $_SESSION['userId'] ?>;
		if(val == "tambah"){
			if(document.getElementById('pelayanan_sewa').value == '' || document.getElementById('biaya') == ''){
				alert('pilih tindakan terlebih dahulu');
			}else{
				jQuery.ajax({
					url: 'sewa_box_utils.php',
					method:'post',
					data : {
						'pelayanan_id' : getIdPel,
						'kunjungan_id' : getIdKunj,
						'id_pasien' : getIdPasien,
						'sewaId' : document.getElementById('pelayanan_sewa').value,
						'tgl_masuk' : document.getElementById('tgl_sewa_box').value,
						'kelas_id' : jQuery('#pelayanan_sewa option:selected').data('idkelas'),
						'user_id' : userId,
						'act' : 'tambah',
					},
					success:function(data){
						console.log(data);
						getData();
					},
					error:function(data){
						console.log('sepertinya terjadi kesalahan');
					}
				});	
			}
		}else{
			if(document.getElementById('pelayanan_sewa').value == '' || document.getElementById('biaya') == ''){
				alert('pilih tindakan terlebih dahulu');
			}else{
				jQuery.ajax({
					url: 'sewa_box_utils.php',
					method:'post',
					data : {
						'pelayanan_id' : getIdPel,
						'kunjungan_id' : getIdKunj,
						'id_pasien' : getIdPasien,
						'sewaId' : document.getElementById('pelayanan_sewa').value,
						'tgl_masuk' : document.getElementById('tgl_sewa_box').value,
						'kelas_id' : jQuery('#pelayanan_sewa option:selected').data('idkelas'),
						'user_id' : userId,
						'idTind' : document.getElementById('id_tindakan_sewa').value,
						'act' : val,
					},
					success:function(data){
						console.log(data);
						 jQuery('#pelayanan_sewa option[value=""]').attr('selected', true);
						 jQuery('#aksi').html('Save');
						 jQuery('#aksi').val('tambah');
						jQuery('#id_tindakan_sewa').val("");
						getData();
					},
					error:function(data){
						console.log('sepertinya terjadi kesalahan');
					}
				});	
			}
		}

  		document.getElementById('biaya').value = '';
  		jQuery('#pelayanan_sewa').find('option[value=""]').attr("selected",true);
    	document.getElementById('sewa_form_input').reset()
    }

    function simpanTindakan(){
    	let idUserInput = <?= $_SESSION['userId'] ?>;
		// var akUnit = document.getElementById("akUnit").value;
    	if(confirm('Ingin menyelesaikan tindakan ini ?')){
    		jQuery.ajax({
    			url:'sewa_box_utils.php',
    			method:'post',
    			data: {
    				'pelayanan_id' : getIdPel,
	    			'kunjungan_id' : getIdKunj,
	    			'id_pasien' : getIdPasien,
	    			'idTind' : document.getElementById('id_tindakan_sewa').value,
	    			'ksoId' : getKsoId,
	    			'ksoIdKelas' : getKsoKelasId,
	    			'unit_pelaksana' : getIdUnit,
	    			'b_dok' : 0,
	    			'unitId' : unitId,
	    			'akUnit' : '3',
	    			'kunjungan_kelas_id' : getIdKelasKunj,
	    			'inap': 1,
	    			'tgl_keluar' : document.getElementById('tgl_sewa_selesai_box').value,
	    			'user_id' : idUserInput,
	    			'kso_id': getKsoId,
	    			'act' : 'inTagihan',
    			},
    			success:function(data){
    				getData();
    				console.log(data);
    			},
    			error:function(data){
    				console.log(data)
    			}
    		});
    	}
    }

    function deleteData(val){
	    if(confirm('Ingin menghapus tindakan ini ?')){
	    		jQuery.ajax({
	    			url:'sewa_box_utils.php',
	    			method:'post',
	    			data: {
		    			'idTind' : document.getElementById('id_tindakan_sewa').value,
		    			'act' : 'hapus',
	    			},
	    			success:function(data){
	    				getData();
	    				console.log(data);
	    			},
	    			error:function(data){
	    				console.log(data)
	    			}
	    		});
	    	}
    }

	function updateData(val){
		let dataPecah = val.split('|');
		jQuery('#biaya').val(dataPecah[1]);
		jQuery('#aksi').html('Ubah');
		jQuery('#aksi').val('ubah');
		jQuery('#id_tindakan_sewa').val(dataPecah[2]);
		selectDropdown(dataPecah[0],'pelayanan_sewa');
	}

	function selectDropdown(data, nameDropdown) {
        jQuery('#' + nameDropdown + ' option[data-idkelas="' + data + '"]').attr('selected', true);
    }
</script>