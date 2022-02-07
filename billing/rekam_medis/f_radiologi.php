<!DOCTYPE HTML>
<html>
<head>
<title>Form Upload Radiologi</title>
<script src="../theme/uploadify/jquery.js" type="text/javascript"></script>
<script src="../theme/uploadify/jquery.uploadify.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="../theme/uploadify/uploadify1.css">
</style>
</head>

<body>
	<form>
		<input id="file_upload1" name="file_upload" type="file"><!--<input type="button" id="simpan" value="Simpan File" onClick="aplod('Tambah','1','1','1','1')">-->
        <div id="queue"></div>
	</form>
	<script type="text/javascript">
	var queueSize = 0;
		$(function() {
			$('#file_upload1').uploadify({
				'formData'     : {
					'action'	   	: 'x',
					'id_kunj'	   	: '0',
					'pelayanan_id' 	: '0',
					'pasien_id' 	: '0',
					'user_id'      	: '0'
				},
				'buttonText' : 'Cari Gambar',
				'swf'      : '../theme/uploadify/uploadify.swf',
				'uploader' : '../theme/uploadify/uploadify_rm.php',
				'onUploadSuccess' : function(){
            		respon('Upload Berhasil');
        		},				
				'onDialogClose'  : function(queueData) {
					queueSize = queueData.queueLength;
				}   					 
			});
		});
	</script>
</body>
</html>
<script>
function aplod(action,id,pelayanan_id,pasien_id,user_id){
	//alert(action+"\n"+id+"\n"+pelayanan_id+"\n"+pasien_id+"\n"+user_id);
	//return false;
	$('#file_upload1').uploadify('settings','formData',{'action' : action,'id_kunj' : id,'pelayanan_id' : pelayanan_id,'pasien_id' : pasien_id,'user_id' : user_id});
	//alert(action);
	if(action=='Tambah'){
		if(queueSize==0){
			//alert("1");
			if(confirm('Tidak ada gambar yang ingin diupload. Lanjut?')){
				simpan_tanpa_gambar('Tambah');	
			}
		}
		else{
			//alert("2");
			$('#file_upload1').uploadify('upload','*');
		}
	}
	else if(action=='Simpan'){
		if(queueSize==0){
			if(confirm('Tidak ada gambar yang ingin diupload. Lanjut?')){
				simpan_tanpa_gambar(action);	
			}
		}
		else{
			if(confirm('Update hasil radiologi dgn gambar yg ingin di upload?')){
				$('#file_upload1').uploadify('upload','*');
			}
		}
	}
	
}

function kensel(){
	queueSize=0;
	$('#file_upload1').uploadify('cancel','*');
}

function respon(zxc){
	window.top.afterRad(zxc);
}

function simpan_tanpa_gambar(act){
	window.top.simpan_tanpa_gambar(act);
}
</script>