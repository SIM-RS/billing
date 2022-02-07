function checkAll(formname, checktoggle){
	if(checktoggle==true){
		//document.getElementById('uncheckall').checked = false;
		document.getElementById('checkall').disabled = true;
		//document.getElementById('uncheckall').disabled = false;
	} else {
		document.getElementById('checkall').checked = false;
		document.getElementById('checkall').disabled = false;
		//document.getElementById('uncheckall').disabled = true;
	}
	
	var checkboxes = new Array(); 
	checkboxes = document[formname].getElementsByTagName('input');
	for (var i=0; i<checkboxes.length; i++)  {
		if (checkboxes[i].type == 'checkbox')   {
			checkboxes[i].checked = checktoggle;
		}
	}
}

function prosesIndikatorMutu(){
	var act = document.getElementById('actMutu').value;
	var idPel = document.getElementById('idPelMutu').value;
	var idKunj = document.getElementById('idKunjMutu').value;
	var idUser = document.getElementById('idUserMutu').value;
	var idMutu = document.getElementById('idMutu').value;
	
	if(act == 'Save'){ act = "Simpan" }else if(act == 'Update'){ act = "Ubah"}
	jQuery("#indikatormutu").ajaxSubmit
	({
		success:function(msg)
		{
			if(msg=='sukses')
			{
				alert('Data berhasil di '+act);
			}
			else
			{
				alert('Data gagal di '+act);
			}
		},
	});
	return false;
}

function luka(a){
	if(a==1){
		document.getElementById('hlukadeku').style.display="table-row";
		document.getElementById('hlukadeku1').style.display="table-row";
		document.getElementById('hlukadeku2').style.display="table-row";
		document.getElementById('hlukadeku3').style.display="table-row";
	} else {
		document.getElementById('hlukadeku').style.display="none";
		document.getElementById('hlukadeku1').style.display="none";
		document.getElementById('hlukadeku2').style.display="none";
		document.getElementById('hlukadeku3').style.display="none";
	}
}