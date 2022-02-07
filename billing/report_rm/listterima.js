function checkAllterima(FormName, CheckValue){
 	if(CheckValue==true){
		//document.getElementById('uncheckall').checked = false;
		document.getElementById('checkall').disabled = true;
		//document.getElementById('uncheckall').disabled = false;
	} else {
		document.getElementById('checkall').checked = false;
		document.getElementById('checkall').disabled = false;
		//document.getElementById('uncheckall').disabled = true;
	}
	
	var objCheckBoxes = new Array();
	//alert(FormName);
	objCheckBoxes = document[FormName].getElementsByTagName('input');
	for(var i = 0; i < objCheckBoxes.length; i++){
		if(objCheckBoxes[i].type == 'checkbox'){
			objCheckBoxes[i].checked = CheckValue;
		}
	}
}

function cetakListTerima(){
	var idPel = document.getElementById('idPel').value;
	var idKunj = document.getElementById('idKunj').value;
	var idUser = document.getElementById('idUser').value;
	var idlist = document.getElementById('idlist').value;
	var inap = document.getElementById('inap').value;
	//alert('listterimapasien_cetak.php?idPel='+idPel+'&idKunj='+idKunj+'&idUser='+idUser+'&idlist='+idlist+'&inap='+inap);
	window.open('../report_rm/listterimapasien_cetak.php?idPel='+idPel+'&idKunj='+idKunj+'&idUser='+idUser+'&idlist='+idlist+'&inap='+inap);
}
function prosesListTerima(){
	var act = jQuery('#act').val();
	var idPel = document.getElementById('idPel').value;
	var idKunj = document.getElementById('idKunj').value;
	var idUser = document.getElementById('idUser').value;
	var idlist = document.getElementById('idlist').value;
	
	if(act == 'Save'){ act = "Simpan" }else if(act == 'Update'){ act = "Ubah"}
	jQuery("#flistterima").ajaxSubmit
	({
		success:function(msg)
		{
			if(msg=='sukses')
			{
				alert('Data berhasil di '+act);
				jQuery('#divCheckListTerima').load('../report_rm/9.check_list_pnrmn.php?idKunj='+idKunj+'&idPel='+idPel+'&idUser='+idUser+'&idlist='+idlist);
			}
			else
			{
				alert('Data gagal di '+act);
			}
		},
	});
	return false;
}