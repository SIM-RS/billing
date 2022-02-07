jQuery(function(){
	var i = 1;
	var a = new Date();
	var tglS = a.getDate()+'-0'+(a.getMonth()+1)+'-'+a.getFullYear();
	jQuery('.addRowBalutan').click(function(){
		var idx = jQuery('.ProsPembedahan tr').length;
		jQuery('.ProsPembedahan').append('<tr class="item">' +
				'<td style="display:none;">'+
					'<input type="hidden" size="1" name="idSubBedah[]" id="idSubBedah" value=""/>' +
				'</td>'+
				'<td align="center">' +
					'<input type="hidden" size="1" name="idNo[]" id="idNo'+i+'" value="'+i+'"/>' +
					'<input type="text" id="tglBalutan'+i+'" name="tglBalutan['+i+']" size="8" readonly value="'+tglS+'"/>' +
					'<button onClick="gfPop.fPopCalendar(document.getElementById(' +
					"'tglBalutan"+i+"'"+'),depRange); return false;">V</button>' +
				'</td>' +
				'<td align="center"><input type="text" id="GantiBalutan" name="GantiBalutan['+i+']" style="width:100%;"/></td>' +
				'<td align="center"><input type="text" id="ketBalutan" name="ketBalutan['+i+']" style="width:100%;"/></td>' +
				'<td align="center"><input type="text" id="namaBalutan" name="namaBalutan['+i+']" style="width:100%;"/></td>' +
				'<td align="center"><input type="button" value="-" class="delRowBalutan" name="hapusRowBalutan" id="hapusRowBalutan"></td>' +
			'</tr>');
		i++;
	});

	jQuery('.ProsPembedahan').on('click', '.delRowBalutan',function(){
		if(confirm('Yakin ingin di hapus?')){
			var id = jQuery(this).parents('tr.item').find('td:eq(0) input:eq(0)').val();
			var elm = jQuery(this).parents('tr.item');
			var idDel = $('#idDel').val();
			if(id!=''){
				$('#idDel').val(idDel+id+',');
			}
			elm.remove();
			/* jQuery.ajax({
				type: 'post',
				data: 'type=delete&id='+id,
				url: 'catatan_pemberian_edukasi_utils.php',
				success: function(){
					
				}
			}); */
		}
	});
	var arrRange = depRange = [];
});

function prosesPembedahan(){
	var act = document.getElementById('actBedah').value;
	var idPel = document.getElementById('idPelBedah').value;
	var idKunj = document.getElementById('idKunjBedah').value;
	var idUser = document.getElementById('idUserBedah').value;
	var idBedah = document.getElementById('idBedah').value;
	
	if(act == 'save'){ act = "Simpan" }else if(act == 'update'){ act = "Ubah"}
	$("#fProsedurBedah").ajaxSubmit({
		success:function(msg)
		{
			if(msg=='sukses')
			{
				alert('Data berhasil di '+act);
				jQuery('.formstyle').load('form_pb.php?idKunj='+idKunj+'&idPel='+idPel+'&idUsr='+idUser+'&idBedah='+idBedah);
				PB1.loadURL("pb_utils.php","","GET");
			}
			else
			{
				alert('Data gagal di '+act);
			}
		},
	});
	return false;
}