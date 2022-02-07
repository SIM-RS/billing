function prosesTransfusi(){
	var act = jQuery('#act').val();
	if(act == 'save' || act == 'simpan'){ act2 = "Simpan" }else if(act == 'edit'){ act2 = "Ubah"}
	jQuery("#persetujuan_transfusi").ajaxSubmit
	({
		success:function(msg)
		{
			if(msg=='sukses')
			{
				alert('Data berhasil di '+act2);
				resetForm();
				a1.loadURL("utils.php","","GET");
			}
			else
			{
				alert('Data gagal di '+act2);
				resetForm();
				a1.loadURL("utils.php","","GET");
			}
		},
	});
	return false;
}

function resetForm(){
	jQuery('#setuju').prop('checked', true);
	jQuery('#saksi_satu').val('');
	jQuery('#saksi_dua').val('');
	jQuery('#act').val('save');
	jQuery('#act2').val('save');
	jQuery('#transfusi_id').val('');
	jQuery('#btnTambah').val('Tambah');
}

function editData(id){
	jQuery.ajax({
		type: 'post',
		data: 'type=edit&transfusi_id='+id,
		url: 'action.php',
		success: function(msg){
			jQuery('#btnTambah').val('Simpan');
			jQuery('#act').val('edit');
			var data = msg.split("|");
			jQuery('#transfusi_id').val(data[0]);
			jQuery('#saksi_satu').val(data[1]);
			jQuery('#saksi_dua').val(data[2]);
			if(data[3] == 1){
				jQuery('#setuju').prop('checked', true);
			}else{
				jQuery('#tidaksetuju').prop('checked', true);
			}
		}
	});
}

function deleteData(id){
	if(confirm('Anda yakin ingin menghapus data ini ?')){
		jQuery.ajax({
			type: 'post',
			data: 'type=delete&transfusi_id='+id,
			url: 'action.php',
			success: function(msg){
				alert("Data Berhasil Di Hapus");
				a1.loadURL("utils.php","","GET");				
			}
		});
	}
}

function cetakData(id){
	var idKunj = jQuery('#idKunj').val();
	var idPel = jQuery('#idPel').val();
	var idUsr = jQuery('#idUsr').val();
	if(confirm('Cetak Laporan ?')){
		window.open('../12.persetujuan_transfusi.php?transfusi_id='+id+'&idKunj='+idKunj+'&idPel='+idPel+'&idUser='+idUsr);
	}
}

function goFilterAndSort(grd){
	if (grd=="gridbox"){
		a1.loadURL("utils.php?"+a1.getFilter()+"&sorting="+a1.getSorting()+"&page="+a1.getPage(),"","GET");
	}
}
var a1=new DSGridObject("gridbox");
a1.setHeader("DATA PERSETUJUAN TRANSFUSI");
a1.setColHeader("NO,SAKSI PERTAMA,SAKSI KEDUA,STATUS,ACTION");
a1.setIDColHeader(",saksi_satu,saksi_dua,,");
a1.setColWidth("30,200,200,100,150");
a1.setCellAlign("center,left,left,center,center");
a1.setCellHeight(20);
a1.setImgPath("../../icon");
a1.setIDPaging("paging");
//a1.attachEvent("onRowClick","ambilData");
a1.baseURL("utils.php");
a1.Init();