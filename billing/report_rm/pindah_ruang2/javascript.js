var arrRange = depRange = [];
function openRadiologi(){
	if(jQuery('#radiologi').is(':checked')){
		jQuery('#thorax').prop('disabled', false);
		jQuery('#ctscan').prop('disabled', false);
		jQuery('#check_lain3').prop('disabled', false);
	}else{
		jQuery('#thorax').prop('checked', false);
		jQuery('#thorax').prop('disabled', true);
		jQuery('#ctscan').prop('checked', false);
		jQuery('#ctscan').prop('disabled', true);
		jQuery('#check_lain3').prop('checked', false);
		jQuery('#check_lain3').prop('disabled', true);
		openThorax();
		openCTscan();
		showLain3();
	}
}
function openThorax(){
	if(jQuery('#thorax').is(':checked')){	
		jQuery('#thorax_input').prop('disabled', false);
	}else{
		jQuery('#thorax_input').val('');
		jQuery('#thorax_input').prop('disabled', true);
	}
}
function openCTscan(){	
	if(jQuery('#ctscan').is(':checked')){
		jQuery('#ctscan_input').prop('disabled', false);
	}else{
		jQuery('#ctscan_input').val('');
		jQuery('#ctscan_input').prop('disabled', true);
	}
}
function openDiagnosa(){
	if(jQuery('#diagnostik').is(':checked')){
		jQuery('#echo').prop('disabled', false);
		jQuery('#EEG').prop('disabled', false);
		jQuery('#USG').prop('disabled', false);
	}else{
		jQuery('#echo').prop('checked', false);
		jQuery('#echo').prop('disabled', true);
		jQuery('#EEG').prop('checked', false);
		jQuery('#EEG').prop('disabled', true);
		jQuery('#USG').prop('checked', false);
		jQuery('#USG').prop('disabled', true);
		openEcho();
		openEEG();
		openUSG();
	}
}
function openEcho(){
	if(jQuery('#echo').is(':checked')){
		jQuery('#echo_input').prop('disabled', false);
	}else{
		jQuery('#echo_input').val('');
		jQuery('#echo_input').prop('disabled', true);
	}
}
function openEEG(){
	if(jQuery('#EEG').is(':checked')){
		jQuery('#eeg_input').prop('disabled', false);
	}else{
		jQuery('#eeg_input').val('');
		jQuery('#eeg_input').prop('disabled', true);
	}
}
function openUSG(){
	if(jQuery('#USG').is(':checked')){
		jQuery('#usg_input').prop('disabled', false);
	}else{
		jQuery('#usg_input').val('');
		jQuery('#usg_input').prop('disabled', true);
	}
}
function openLab(){
	if(jQuery('#laboratorium').is(':checked')){
		jQuery('#lab_input').prop('disabled', false);
	}else{
		jQuery('#lab_input').val('');
		jQuery('#lab_input').prop('disabled', true);
	}
}
function tidakAda(){
	if(jQuery('#tidakada').is(':checked')){
		jQuery('#NGT').prop('checked', false);
		jQuery('#NGT').prop('disabled', true);
		jQuery('#karakter').prop('checked', false);
		jQuery('#karakter').prop('disabled', true);
		jQuery('#oksigen').prop('checked', false);
		jQuery('#oksigen').prop('disabled', true);
		jQuery('#ETT').prop('checked', false);
		jQuery('#ETT').prop('disabled', true);
		jQuery('#check_lain').prop('checked', false);
		jQuery('#check_lain').prop('disabled', true);
		showLain();
	}else{
		jQuery('#NGT').prop('disabled', false);
		jQuery('#karakter').prop('disabled', false);
		jQuery('#oksigen').prop('disabled', false);
		jQuery('#ETT').prop('disabled', false);
		jQuery('#check_lain').prop('disabled', false);
	}
}
function buktiTidakAda(){
	if(jQuery('#bukti_tidak_ada').is(':checked')){
		jQuery('#bukti_ada').prop('checked', false);
		jQuery('#bukti_ada').prop('disabled', true);
		jQuery('#check_lain5').prop('checked', false);		
		jQuery('#check_lain5').prop('disabled', true);
		showLain5();
	}else{
		jQuery('#bukti_ada').prop('disabled', false);
		jQuery('#check_lain5').prop('disabled', false);
	}
}
function showLain(){
	if(jQuery('#check_lain').is(':checked')){
		jQuery('#spLain').css('display', 'inline-block');
	}else{
		jQuery('#spLain').css('display', 'none');
		jQuery('#alat_bantu_lain').val('');
	}
}
function showLain2(){
	if(jQuery('#check_lain2').is(':checked')){
		jQuery('#spLain2').css('display', 'inline-block');
	}else{
		jQuery('#spLain2').css('display', 'none');
		jQuery('#mobilisasi_lain').val('');
	}
}
function showLain3(){
	if(jQuery('#check_lain3').is(':checked')){
		jQuery('#spLain3').css('display', 'inline-block');
	}else{
		jQuery('#spLain3').css('display', 'none');
		jQuery('#radiologi_lain').val('');
	}
}
function showLain4(){
	if(jQuery('#check_lain4').is(':checked')){
		jQuery('#spLain4').css('display', 'inline-block');
	}else{
		jQuery('#spLain4').css('display', 'none');
		jQuery('#barang_lain').val('');
	}
}
function showLain5(){
	if(jQuery('#check_lain5').is(':checked')){
		jQuery('#spLain5').css('display', 'inline-block');
	}else{
		jQuery('#spLain5').css('display', 'none');
		jQuery('#bukti_lain').val('');
	}
}
function prosesSerahTerima(){
	var actSerahTerima = jQuery('#actSerahTerima').val();
	if(actSerahTerima == 'save'){ actSerahTerima = "Simpan" }else if(actSerahTerima == 'edit'){ actSerahTerima = "Ubah"}
	jQuery("#serahterima").ajaxSubmit
	({
		success:function(msg)
		{
			if(msg=='sukses')
			{
				alert('Data berhasil di '+actSerahTerima);				
			}
			else
			{
				alert('Data gagal di '+actSerahTerima);
			}
		},
	});
	return false;
}
function cetakPindahRuang(){	
	var idKunj = jQuery('#idKunj').val();
	var idPel = jQuery('#idPel').val();
	var idUser = jQuery('#idUsr').val();
	var serah_terima_id = jQuery('#serah_terima_id').val();
	if(confirm('Cetak Laporan ?')){
		window.open('../Form_RSU/9.formserahtrmpasienpindahruang.php?serah_terima_id='+serah_terima_id+'&idKunj='+idKunj+'&idPel='+idPel+'&idUser='+idUser);
	}
}
/*              INPUT TABLE DINAMIS                 */
jQuery(function(){
	jQuery('.tambahRow2').click(function(){
		var idx = jQuery('.catatanRow2 tr').length;
		//alert(idx);
		jQuery('.catatanRow2').append('<tr class="itemRow">' +
				'<input type="hidden" id="rawID" name="rawID[]" value="1" />' +
				'<td width=40 height=20 align=center>&nbsp;'+idx+'</td>' +
				'<td width=240><input type="text" class="catatan" id="pesanan" name="pesanan[]" /></td>' +
				'<td width=240><input type="text" class="catatan" id="keterangan" name="keterangan[]" /></td>' +
				'<td width=240><input type="text" class="catatan" id="instruksi" name="instruksi[]" /></td>' +
				'<td width=50 align=center>' +
					'<img class="hapus" style="cursor:pointer;" src="../../icon/del.gif" border="0" width="16" height="16" align="absmiddle" title="Klik Untuk Menghapus" />' +
				'</td>' +
			'</tr>');
	});
	jQuery('.catatanRow').on('click', '.hapus',function(){
		if(confirm('Apakah anda yakin?')){
			var id = jQuery(this).parents('tr.itemRow').find('td:eq(0) input:eq(0)').val();
			var elm = jQuery(this).parents('tr.itemRow');
			//alert(id);
			var tmp = jQuery('#deleteCatatan').val();
			jQuery('#deleteCatatan').val(tmp+id+',');
			elm.remove();			
		}
	});
});