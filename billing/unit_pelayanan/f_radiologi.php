<!DOCTYPE HTML>
<html>

<head>
	<title>Form Upload Radiologi</title>
	<script src="../theme/uploadify/jquery.js" type="text/javascript"></script>
	<script src="../theme/uploadify/jquery.uploadify.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="../theme/uploadify/uploadify.css">
	<style>
		.uploadify-progress {
			display: none;
		}

		.uploadify-progress-bar {
			display: none;
		}
	</style>
</head>

<body>
	<form id="radUpload">
		<div id="queue" style=""></div>
		<input id="file_upload" name="file_upload" type="file" onClick="tes12();">
	</form>
	<script type="text/javascript">
		var queueSize = 0;
		$(function() {
			$('#file_upload').uploadify({
				'formData': {
					'action': action,
					'id': id,
					'pelayanan_id': pelayanan_id,
					'hasil': hasil,
					'dokter': dokter,
					'user_id': user_id,
					'norm': norm,
					'pacsId': pacsId
				},
				'uploader': '../theme/uploadify/uploadify.swf',
				'script': '../theme/uploadify/uploadify.php',
				'folder': 'wehehe',
				'onUploadSuccess': function() {
					respon('Upload Berhasil');
				},
				'onDialogClose': function(queueData) {
					queueSize = queueData.queueLength;
				}
			});
		});
	</script>
</body>

</html>
<script>
	var queueSize = 0;

	function aplod(action, id, pelayanan_id, hasil, dokter, user_id, norm, pacsId) {
		var formData = new FormData();
		var fileUpload = jQuery('#file_upload')[0].files;
		if(fileUpload.length > 0){
			formData.append('action',action);
			formData.append('id',id);
			formData.append('pelayanan_id',pelayanan_id);
			formData.append('hasil',hasil);
			formData.append('dokter',dokter);
			formData.append('user_id',user_id);
			formData.append('norm',norm);
			formData.append('pacsId',pacsId);
			formData.append('Filedata',fileUpload[0]);
			formData.append('folder','rad-upload');
			
			jQuery.ajax({
				url: '../theme/uploadify/uploadify.php',
				type : 'POST',
				data : formData,
				contentType : false,
				processData : false,
				success:function(data){
					document.getElementById('radUpload').reset();
					window.top.rad.loadURL("hasilRad_utils.php?grd=true&pelayanan_id="+pelayanan_id,"","GET");
				}
			});
		}else{
			if(confirm('Simpan hasil radiologi tanpa gambar')){
				simpan_tanpa_gambar("Tambah");
			}
		}
	}

	function kensel() {
		queueSize = 0;
		$('#file_upload').uploadify('cancel', '*');
	}

	function respon(zxc) {
		window.top.afterRad(zxc);
	}

	function simpan_tanpa_gambar(act) {
		window.top.simpan_tanpa_gambar(act);
	}
</script>