<?php
include "../koneksi/konek.php";
$kunjunganId=$_REQUEST['idKunj'];
$pelayananId=$_REQUEST['idPel'];
$userId=$_REQUEST['idUser'];
$sqlP="SELECT 
			pl.unit_id AS unitId
		FROM b_pelayanan pl 
			LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
			LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
			LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
		WHERE pl.id='{$pelayananId}';";
$pasien=mysql_fetch_array(mysql_query($sqlP));

$sqlC="SELECT * FROM lap_inform_konsen WHERE pelayanan_id='$pelayananId'";
$sqlcek=mysql_num_rows(mysql_query($sqlC));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Inform Konsen</title>

<link type="text/css" rel="stylesheet" href="../theme/mod.css" />
<link rel="stylesheet" type="text/css" href="../theme/popup.css" />

<style>
body{ background:#FFF;}
</style>
</head>

<body>

<div id="popupInformKonsen" style="display:none; width: 900px;">
	<form id="formInformKonsen">
	<fieldset>
		<legend style="font-size: 14px; font-weight: bold;">Form Inform Konsen</legend>
		<input type="hidden" name="informKonsen[pelayanan_id]" class="inputInformKonsen do-not-clean" value="<?php echo $pelayananId; ?>" />
		<input type="hidden" name="informKonsen[kunjungan_id]" class="inputInformKonsen do-not-clean" value="<?php echo $kunjunganId; ?>" />
		<input type="hidden" name="informKonsen[user_id]" class="inputInformKonsen do-not-clean" value="<?php echo $userId; ?>" />
		<input type="hidden" id="informKonsen_id" name="informKonsen[id]" class="inputInformKonsen" value="<?php echo $userId; ?>" />
        <input type="hidden" id="cek" name="informKonsen[cek]" value="<?=$sqlcek?>" />
		<table width="850" border="0" cellpadding="0" cellspacing="0" align="center">
			<tr>
				<td width="2%">&nbsp;</td>
				<td width="20%">&nbsp;</td>
				<td width="80%">&nbsp;</td>
				<td width="5%">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="4">
					<fieldset>
						<legend style="font-size: 14px; font-weight: bold;">Kuasa</legend>

						<table width="850" border="0" cellpadding="0" cellspacing="0" align="center">
							<tr>
								<td width="2%">&nbsp;</td>
								<td width="20%" align="right">Nama&nbsp;</td>
								<td width="80%">&nbsp;<input type="text" id="informKonsen_nama" name="informKonsen[nama]" class="inputInformKonsen" /></td>
								<td width="5%">&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td align="right">Umur&nbsp;</td>
								<td>&nbsp;<input type="text" id="informKonsen_umur" name="informKonsen[umur]" class="inputInformKonsen" /></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td align="right">Jenis Kelamin&nbsp;</td>
								<td>&nbsp;<label><input type="radio" id="informKonsen_jenis_kelamin_L" name="informKonsen[jenis_kelamin]" value="L" />Pria</label><label><input type="radio" id="informKonsen_jenis_kelamin_P" name="informKonsen[jenis_kelamin]" value="P" />Wanita</label></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td align="right">Alamat&nbsp;</td>
								<td>&nbsp;<textarea id="informKonsen_alamat" name="informKonsen[alamat]" class="inputInformKonsen"></textarea></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td align="right">Status Hubungan dengan Pasien&nbsp;</td>
								<td>
									&nbsp;<select id="informKonsen_hubungan" name="informKonsen[hubungan]" class="inputInformKonsen">
										<option value="0">Diri saya sendiri</option>
										<option value="1">Istri</option>
										<option value="2">Suami</option>
										<option value="3">Anak</option>
										<option value="4">Ayah</option>
										<option value="5">Ibu</option>
									</select>
								</td>
								<td>&nbsp;</td>
							</tr>
						</table>
					</fieldset>
				</td>
			</tr>
			<tr>
				<td colspan="4">&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td align="right">Dokter&nbsp;</td>
				<td>
					&nbsp;<select id="informKonsen_dokter_id" name="informKonsen[dokter_id]" class="txtinput inputInformKonsen">
						<option value="">-Dokter-</option>
					</select>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td align="right">Tindakan&nbsp;</td>
				<td>
					&nbsp;<input type="text" id="informKonsen_tindakan" name="informKonsen[tindakan]" class="inputInformKonsen" />
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td align="right">Persetujuan&nbsp;</td>
				<td>
					&nbsp;<label><input type="radio" id="informKonsen_status_persetujuan_T" name="informKonsen[status_persetujuan]" value="1" />SETUJU</label><label><input type="radio" name="informKonsen[status_persetujuan]" id="informKonsen_status_persetujuan_F" value="0" />MENOLAK</label>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td align="right">Tindakan Alternatif&nbsp;</td>
				<td colspan="2">
					<table>
						<tr>
							<td>1</td>
							<td><input type="text" id="informKonsen_tindakan_alternatif_1" name="informKonsen[tindakan_alternatif][1]" class="inputInformKonsen" /></td>
						</tr>
						<tr>
							<td>2</td>
							<td><input type="text" id="informKonsen_tindakan_alternatif_2" name="informKonsen[tindakan_alternatif][2]" class="inputInformKonsen" /></td>
						</tr>
						<tr>
							<td>3</td>
							<td><input type="text" id="informKonsen_tindakan_alternatif_3" name="informKonsen[tindakan_alternatif][3]" class="inputInformKonsen" /></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="4">&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td align="right">Saksi&nbsp;</td>
				<td colspan="2">
					<table>
						<tr>
							<td>1</td>
							<td><input type="text" id="informKonsen_saksi_1" name="informKonsen[saksi][1]" class="inputInformKonsen" /></td>
						</tr>
						<tr>
							<td>2</td>
							<td><input type="text" id="informKonsen_saksi_2" name="informKonsen[saksi][2]" class="inputInformKonsen" /></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td style="padding:10px;">
					&nbsp;
					<input type="button" id="btnSimpan" value="Simpan" onclick="simpanKonsen()" class="tblTambah"/> 
                    <input type="button" id="btnSimpan" value="Batal" onclick="batalKonsen()" class="tblBatal"/>
				<td>&nbsp;</td>
			</tr>
		</table>
		
	</fieldset>
	</form>
</div>

<table width="850" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="right">
			<button id="btnTmbh" name="btnTmbh" onclick="showFormKonsen()" type="button"><img src="../icon/add.gif" width="16" height="16" />&nbsp;Tambah</button>
			<button id="btnEdit" name="btnEdit" onclick="editKonsen()" type="button"><img src="../icon/edit.gif" width="16" height="16" />&nbsp;Ubah</button>
			<button id="btnHapus" name="btnHapus" onclick="hapusKonsen()" type="button"><img src="../icon/edit.gif" width="16" height="16" />&nbsp;Hapus</button>
			<button id="btnCetak" name="btnCetak" onclick="cetakKonsen()" type="button"><img src="../icon/edit.gif" width="16" height="16" />&nbsp;Cetak</button>
		</td>
	</tr>
	<tr>
		<td>
			<div id="gridInformKonsen" style="width:850px; height:300px; background-color:white;"></div>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>

<!-- ================= SCRIPT ================== -->
<script type="text/JavaScript" language="JavaScript" src="../theme/jquery-ui/js/jquery-1.8.3.js"></script>
<script type="text/JavaScript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
<script type="text/javascript" src="../theme/prototype.js"></script>
<script type="text/javascript" src="../theme/effects.js"></script>
<script type="text/javascript" src="../theme/popup.js"></script>
<script type="text/javascript" src="../theme/js/ajax.js"></script>
<script type="text/javascript" src="jquery.blockUI.js"></script>

<script type="text/javascript">

var loadingMessage = '<h1><img src="busy.gif" /> Just a moment...</h1>';

var gridInformKonsen = new DSGridObject("gridInformKonsen");
gridInformKonsen.setHeader("DATA INFORM KONSEN");
gridInformKonsen.setColHeader("NO,TINDAKAN,PEMBERI KUASA,KONSEN");
//gridInformKonsen.setIDColHeader(",tanggal,nama,,,,,,dokter,");
gridInformKonsen.setColWidth("80,380,240,140");
gridInformKonsen.setCellAlign("center,left,center,center");
gridInformKonsen.setCellHeight(20);
gridInformKonsen.setImgPath("../icon");
gridInformKonsen.baseURL('1.inform_konsen_util.php?idKunj=<?php echo $kunjunganId; ?>&idPel=<?php echo $pelayananId; ?>&act=grid');
gridInformKonsen.Init();

(function($) {

function isiCombo(id,val,defaultId,targetId,evloaded){

    if(targetId=='' || targetId==undefined){
        targetId=id;
    }
    if(document.getElementById(targetId)==undefined){
        alert('Elemen target dengan id: \''+targetId+'\' tidak ditemukan!');
    }else{
        Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded);
    }
}

$(function () {
	isiCombo('cmbDok','<?php echo $pasien['unitId']; ?>','<?php echo $userId; ?>','informKonsen_dokter_id',null);

	window.showFormKonsen = function() {
		$('#popupInformKonsen').show(500,function(){
		toggle();
		});
		//new Popup('popupInformKonsen',null,{modal:true,position:'center',duration:1});
		//document.getElementById('popupInformKonsen').popup.show();
		$('.inputInformKonsen:not(.do-not-clean)').each(function() {
			$(this).val('');
		});

		return false;
	}

	window.batalKonsen = function(){
	$('#popupInformKonsen').slideUp(500,function(){
		toggle();
		});
	}
	
	window.simpanKonsen = function() {
		var data = $('#formInformKonsen').serialize();
		data += '&act=save';

		$('#popupInformKonsen').block({ message: loadingMessage });
		$.post('1.inform_konsen_util.php', data, function() {
			$('#popupInformKonsen').unblock();
			batalKonsen();
		});
		gridInformKonsen.Init();

		return false;
	}

	window.editKonsen = function() {
		var selectedRow = gridInformKonsen.getSelRow();
		var id = gridInformKonsen.getRowId(selectedRow);

		$.blockUI({ message: loadingMessage });
		$.get('1.inform_konsen_util.php', {
			id: id,
			act: 'get'
		}, function(result) {
			if(result == 'false') {
				alert('Invalid ID!'); return false;
			}

			$.unblockUI();
			showFormKonsen();
			$.each(result, function(key, value) {
				$('#informKonsen_'+key).val(value);
			});
			if(result.jenis_kelamin == 'L') {
				$('#informKonsen_jenis_kelamin_L').prop('checked', true);
			} else {
				$('#informKonsen_jenis_kelamin_P').prop('checked', true);
			}
			if(result.status_persetujuan == false) {
				$('#informKonsen_status_persetujuan_F').prop('checked', true);
			} else {
				$('#informKonsen_status_persetujuan_T').prop('checked', true);
			}
		}, 'json');
	}

	window.hapusKonsen = function() {
		var selectedRow = gridInformKonsen.getSelRow();
		var id = gridInformKonsen.getRowId(selectedRow);

		$.blockUI({ message: loadingMessage });
		$.post('1.inform_konsen_util.php', {
			id: id,
			act: 'delete'
		}, function(result) {
			$.unblockUI();
			gridInformKonsen.Init();
		}, 'json');
	}

	window.cetakKonsen = function () {
		var selectedRow = gridInformKonsen.getSelRow();
		var id = gridInformKonsen.getRowId(selectedRow);

		window.open('1.inform_konsen_print.php?idKunj=<?php echo $kunjunganId; ?>&idPel=<?php echo $pelayananId; ?>&id='+id);
	}
});

})(jQuery);

function toggle() {
    parent.alertsize(document.body.scrollHeight);
}

</script>

</body>
</html>
