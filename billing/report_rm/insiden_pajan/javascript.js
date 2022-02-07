var arrRange = depRange = [];
jQuery(document).ready(function(){	
	jQuery('#sumberlain').prop('checked', false);
	jQuery('#alatJenis').prop('checked', false);
	jQuery('#sumberTextLain').val('');
	jQuery('#textJenis').val('');
	jQuery('#bahanInfeksius').val('');
	jQuery('#textHIV').val('');
	jQuery('#textHbsag').val('');
	jQuery('#textHCV').val('');
});
jQuery('#sudahImun').click(function(){
	jQuery('#belumImun').prop('checked', false);
});
jQuery('#belumImun').click(function(){
	jQuery('#sudahImun').prop('checked', false);
});
jQuery('#tolongAda').click(function(){
	jQuery('#tolongTidak').prop('checked', false);
});
jQuery('#tolongTidak').click(function(){
	jQuery('#tolongAda').prop('checked', false);
});
jQuery('#alatDipakai').click(function(){
	jQuery('#alatTidak').prop('checked', false);
	jQuery('#alatJenis').prop('checked', false);
	jenisLain();
});
jQuery('#alatTidak').click(function(){
	jQuery('#alatDipakai').prop('checked', false);
	jQuery('#alatJenis').prop('checked', false);
	jenisLain();
});
jQuery('#alatJenis').click(function(){
	jQuery('#alatDipakai').prop('checked', false);
	jQuery('#alatTidak').prop('checked', false);
});
jQuery('#pasTahu').click(function(){
	//alert('Diketahui');
	jQuery('#bahanInfeksius').val(1);
	jQuery('#pasTidak').css('text-decoration', 'line-through');
	jQuery(this).css('text-decoration', 'none');
	return false;
});

jQuery('#pasTidak').click(function(){
	//alert('Diketahui');
	jQuery('#bahanInfeksius').val(0);
	jQuery('#pasTahu').css('text-decoration', 'line-through');
	jQuery(this).css('text-decoration', 'none');
	return false;
});

function showAntiHIV(){
	if(jQuery('#hiv').is(':checked')){
		jQuery('#antiHIV').html("( <a href='javascript:void(0)' id='positifOne' style='text-decoration:none;'>positif</a> / "+
								"<a href='javascript:void(0)' id='negatifOne' style='text-decoration:none;'>negative</a> *) ");
		jQuery('#positifOne').click(function(){
			jQuery('#textHIV').val(1);
			jQuery('#negatifOne').css('text-decoration', 'line-through');
			jQuery(this).css('text-decoration', 'none');
			return false;
		});
		jQuery('#negatifOne').click(function(){
			jQuery('#textHIV').val(0);
			jQuery('#positifOne').css('text-decoration', 'line-through');
			jQuery(this).css('text-decoration', 'none');
			return false;
		});
	}else{
		jQuery('#antiHIV').empty();
		jQuery('#textHIV').val('');
	}
}
function showHbsag(){
	if(jQuery('#hbsag').is(':checked')){
		jQuery('#antiHbsag').html("( <a href='javascript:void(0)' id='positifTwo' style='text-decoration:none;'>positif</a> / "+
								  "<a href='javascript:void(0)' id='negatifTwo' style='text-decoration:none;'>negative</a> *) ");
		jQuery('#positifTwo').click(function(){
			jQuery('#textHbsag').val(1);
			jQuery('#negatifTwo').css('text-decoration', 'line-through');
			jQuery(this).css('text-decoration', 'none');
			return false;
		});
		jQuery('#negatifTwo').click(function(){
			jQuery('#textHbsag').val(0);
			jQuery('#positifTwo').css('text-decoration', 'line-through');
			jQuery(this).css('text-decoration', 'none');
			return false;
		});
	}else{
		jQuery('#antiHbsag').empty();
		jQuery('#textHbsag').val('');
	}
}
function showAntiHCV(){
	if(jQuery('#hcv').is(':checked')){
		jQuery('#antiHCV').html("( <a href='javascript:void(0)' id='positifThree' style='text-decoration:none;'>positif</a> / "+
								"<a href='javascript:void(0)' id='negatifThree' style='text-decoration:none;'>negative</a> *) ");
		jQuery('#positifThree').click(function(){
			jQuery('#textHCV').val(1);
			jQuery('#negatifThree').css('text-decoration', 'line-through');
			jQuery(this).css('text-decoration', 'none');
			return false;
		});
		jQuery('#negatifThree').click(function(){
			jQuery('#textHCV').val(0);
			jQuery('#positifThree').css('text-decoration', 'line-through');
			jQuery(this).css('text-decoration', 'none');
			return false;
		});
	}else{
		jQuery('#antiHCV').empty();
		jQuery('#textHCV').val('');
	}
}
function showSumberLain(){
	if(jQuery('#sumberlain').is(':checked')){
		jQuery('#spanSLain').css('display', 'inline-block');
	}else{
		jQuery('#spanSLain').css('display', 'none');
		jQuery('#sumberTextLain').val('');
	}
}
function jenisLain(){
	if(jQuery('#alatJenis').is(':checked')){
		jQuery('#spanAlat').css('display', 'inline-block');
	}else{
		jQuery('#spanAlat').css('display', 'none');
		jQuery('#textJenis').val('');
	}
}
function prosesPajan(){
	var actPajan = jQuery('#actPajan').val();
	if(actPajan == 'save'){ actPajan = "Simpan" }else if(actPajan == 'edit'){ actPajan = "Ubah"}
	jQuery("#insiden_pajan").ajaxSubmit
	({
		success:function(msg)
		{
			if(msg=='sukses')
			{
				alert('Data berhasil di '+actPajan);				
			}
			else
			{
				alert('Data gagal di '+actPajan);
			}
		},
	});
	return false;
}
/* function cetakPindahRuang(){	
	var idKunj = jQuery('#idKunj').val();
	var idPel = jQuery('#idPel').val();
	var idUser = jQuery('#idUsr').val();
	var serah_terima_id = jQuery('#serah_terima_id').val();
	if(confirm('Cetak Laporan ?')){
		window.open('../Form_RSU/9.formserahtrmpasienpindahruang.php?serah_terima_id='+serah_terima_id+'&idKunj='+idKunj+'&idPel='+idPel+'&idUser='+idUser);
	}
} */