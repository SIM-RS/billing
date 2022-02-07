function SetAllCheckBoxes(FormName, CheckValue)
{
	var objCheckBoxes = new Array();
	objCheckBoxes = document[FormName].getElementsByTagName('input');
	for(var i = 0; i < objCheckBoxes.length; i++){
		if(objCheckBoxes[i].type == 'checkbox'){
			objCheckBoxes[i].checked = CheckValue;
		}
	}
}
function prosesCheckList(){
	var idUserCheckList = jQuery('#idUserCheckList').val();
	var idKunjCheckList = jQuery('#idKunjCheckList').val();
	var idPelCheckList = jQuery('#idPelCheckList').val();
	var actCheckList = jQuery('#actCheckList').val();
	if(actCheckList == 'save'){ actCheckList = "Simpan" }else if(actCheckList == 'edit'){ actCheckList = "Ubah"}
	jQuery("#checkListPasien").ajaxSubmit
	({
		success:function(msg)
		{
			if(msg=='sukses')
			{
				alert('Data berhasil di '+actCheckList);
				jQuery('#divCheckList').load('list_pasien_pulang/form_list_pasien_pulang.php?idKunjCheckList='+idKunjCheckList+'&idPelCheckList='+idPelCheckList+'&idUserCheckList='+idUserCheckList);
			}
			else
			{
				alert('Data gagal di '+actCheckList);
			}
		},
	});
	return false;
}
function reportCheckList(){
	var idUserCheckList = jQuery('#idUserCheckList').val();
	var idKunjCheckList = jQuery('#idKunjCheckList').val();
	var idPelCheckList = jQuery('#idPelCheckList').val();
	window.open('../report_rm/Form_RSU/5.checklistpasienpulang.php?idKunjCheckList='+idKunjCheckList+'&idPelCheckList='+idPelCheckList+'&idUserCheckList='+idUserCheckList+'&idPasCheckList='+getIdPasien);
}