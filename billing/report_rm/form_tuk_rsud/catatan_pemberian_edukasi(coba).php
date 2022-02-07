<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
body {
	font-family: Tahoma;
	font-size: 12px;
}
.judul1 {
	font-size: 17px;
	font-weight: bold;
}
.judul2 {
	font-size: 15px;
	font-weight: bold;
}

.sticker {
	line-height:20px;
	padding: 8px;
	border: 1px solid;
	font-size:9px;
	position:absolute;
	left: 608px;
	top: 17px;
}
-->
input[type=text] {
	font-family: tahoma;
	font-size: 12px;
}
</style>
<script type="text/javascript" src="../../../include/javascript/jquery-1.9.1.js"></script>

<link rel="stylesheet" type="text/css" href="../../css/jquery-ui-1.8.4.custom.css" />
<link rel="stylesheet" type="text/css" href="../../css/form.css" />
<link rel="stylesheet" type="text/css" href="../../include/jquery/jquery-ui-timepicker-addon.css" />
<script src="../../js/jquery-1.8.3.js"></script>
<script src="../../include/jquery/ui/jquery.ui.core.js"></script>
<script src="../../include/jquery/ui/jquery.ui.widget.js"></script>
<script src="../../include/jquery/ui/jquery.ui.datepicker.js"></script>
<script src="../../include/jquery/jquery-ui-timepicker-addon.js"></script>
<script src="../../include/jquery/external/jquery.bgiframe-2.1.2.js"></script>

<script>
$(function() {
	var yes = $("#cek").val();
	//alert (yes);
	var i=0;
	while (i<yes){ 
	$( "#tanggal_jam"+i ).datetimepicker({
		changeMonth: true,
		changeYear: true,
		showOn: "button",
		buttonImage: "../../images/cal.gif",
		buttonImageOnly: true,
		timeFormat: "HH:mm:ss"
	});
	i++;}
});
</script>
<?php include('serah_terima_bayi_pulang_utils.php'); ?>
<script type="text/javascript">
$(function(){
	var kunjungan_id = '<?php echo $idKunj; ?>';
	var pelayanan_id = '<?php echo $idPel; ?>';
	var pasien_id = '<?php echo $idPsn; ?>';
	var user_id = '<?php echo $idUsr; ?>';

	$('.tambah').click(function(){
		var idx = $('.pemberian_edukasi tr').length;
		$('.pemberian_edukasi').append('<tr height="40" class="item">' +
				'<td height="40" align="center">' +
					'<input type="hidden" id="id"/>' +
					'<input type="text" id="tanggal_jam'+idx+'" style="width:120px;"/>' +
				'</td>' +
				'<td align="center">' +
					'<select id="bagian" name="bagian"><option>Senin</option><option>Selasa</option><option>Rabu</option><option>Kamis</option><option>Jumat</option><option>Sabtu</option><option>Minggu</option></select>' +
				'</td>' +
				'<td align="center"><input type="text" id="informasi" style="width:330px;"/></td>' +
				'<td align="center"><input type="text" id="petugas" style="width:130px;"/></td>' +
				'<td align="center"><input type="text" id="penerima" style="width:90px;"/></td>' +
				'<td align="center"><input type="text" id="hubungan_pasien" style="width:90px;"/></td>' +
				'<td align="center">' +
					'<button class="simpan"> > </button> ' +
					'<button class="hapus"> - </button>' +
				'</td>' +
			'</tr>');
			
	$('.pemberian_edukasi tr:eq('+idx+') #tanggal_jam'+idx).datetimepicker({
			changeMonth: true,
			changeYear: true,
			showOn: "button",
			buttonImage: "../../images/cal.gif",
			buttonImageOnly: true,
			timeFormat: "HH:mm:ss"
		});		
			
	});
	
	
	$('.pemberian_edukasi').on('click', '.hapus',function(){
		if(confirm('Apakah anda yakin?')){
			var id = $(this).parents('tr.item').find('td:eq(0) input:eq(0)').val();
			var elm = $(this).parents('tr.item');
			$.ajax({
				type: 'post',
				data: 'type=delete&id='+id,
				url: 'catatan_pemberian_edukasi_utils.php',
				success: function(){
					elm.remove();
				}
			});
		}
	});
	
	$('.pemberian_edukasi').on('click', '.simpan',function(){
		var id = $(this).parents('tr.item').find('td:eq(0) input:eq(0)').val();
		var elm_id = $(this).parents('tr.item').find('td:eq(0) input:eq(0)');
		var tanggal_jam = $(this).parents('tr.item').find('td:eq(0) input:eq(1)').val();
		var bagian = $(this).parents('tr.item').find('td:eq(1) input').val();
		var informasi = $(this).parents('tr.item').find('td:eq(2) input').val();
		var petugas = $(this).parents('tr.item').find('td:eq(3) input').val();
		var penerima = $(this).parents('tr.item').find('td:eq(4) input').val();
		var hubungan_pasien = $(this).parents('tr.item').find('td:eq(5) input').val();
		$.ajax({
			type: 'post',
			data: 'type=save&id='+id
				+'&kunjungan_id='+kunjungan_id+'&pelayanan_id='+pelayanan_id
				+'&pasien_id='+pasien_id+'&user_id='+user_id
				+'&tanggal_jam='+tanggal_jam+'&bagian='+bagian
				+'&informasi='+informasi+'&petugas='+petugas
				+'&penerima='+penerima+'&hubungan_pasien='+hubungan_pasien,
			url: 'catatan_pemberian_edukasi_utils.php',
			success: function(id){
				if(id)
					elm_id.val(id);
				alert('sukses');
			}
		});
	});
	
	$('.print').click(function(){
		window.open('catatan_pemberian_edukasi_print.php?idKunj='+kunjungan_id+'&idPel='+pelayanan_id+'&idPasien='+pasien_id+'&idUsr='+user_id);
	});
});
</script>
</head>

<body>

<div class="sticker">
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="167">Nama Pasien </td>
    <td width="10">:</td>
    <td width="25" style="width: 175px;"><?php echo $pasien['nama'].' '.$pasien['sex']; ?></td>
  </tr>
  <tr>
    <td>Tanggal Lahir </td>
    <td>:</td>
    <td><?php echo date('d-m-Y',strtotime($pasien['tgl_lahir'])); ?>  /Usia : <?php echo $pasien['usia']; ?> Th</td>
  </tr>
  <tr>
    <td>No. R.M </td>
    <td>:</td>
    <td><?php echo $pasien['no_rm']; ?> No  Registrasi :_______</td>
  </tr>
  <tr>
    <td>Ruang Rawat / Kelas </td>
    <td>:</td>
    <td><?php echo $pasien['nm_unit']; ?></td>
  </tr>
  <tr>
    <td>Alamat</td>
    <td>:</td>
    <td><?php echo $pasien['alamat']; ?></td>
  </tr>
  <tr>
    <td colspan="3"><p align="center">(Tempelkan  Sticker Identitas Pasien)</p></td>
    </tr>
</table>

</div>

<table cellspacing="0" cellpadding="0">
  <col width="65" />
  <col width="105" />
  <col width="385" />
  <col width="190" />
  <col width="105" span="2" />
  <tr height="20">
    <td height="20" width="105"></td>
    <td width="105"></td>
    <td width="385"></td>
    <td width="190"></td>
    <td width="105"></td>
    <td width="105"></td>
  </tr>
  <tr height="20">
    <td height="20"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="28">
    <td height="28" colspan="3"><span class="judul1">PEMERINTAH    KOTA MEDAN</span></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="28">
    <td height="28" colspan="3" class="judul1">RUMAH    SAKIT PELINDO I</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="20">
    <td height="20"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="20">
    <td height="20"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="12">
    <td height="12"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="27">
    <td height="27" colspan="3" class="judul2">CATATAN    PEMBERIAN EDUKSI / INFORMASI TERINTEGRASI</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="15">
    <td height="15"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="35">
    <td colspan="6"><table border="1" cellpadding="0" cellspacing="0">
      <col width="65" />
      <col width="105" />
      <col width="385" />
      <col width="190" />
      <col width="105" span="2" />
	  <thead>
      <tr height="35">
        <td rowspan="2" height="77" width="139"><div align="center">Tanggal Jam</div></td>
        <td rowspan="2" width="112"><div align="center">Profesi / Bagian</div></td>
        <td rowspan="2" width="364"><div align="center">Informasi / Edukasi    yang diberikan</div></td>
        <td rowspan="2" width="130"><div align="center">Nama dan Tanda Tangan    Pemberi informasi / Edukasi</div></td>
        <td colspan="2"><div align="center">Penerima    Informasi / Edukasi</div></td>
		<td rowspan="2" width="200"><div align="center"><button class="tambah"> + </button></div></td>
      </tr>
      <tr height="42">
        <td height="42" width="105"><div align="center">Nama dan Tanda Tangan</div></td>
        <td width="105"><div align="center">Hubungan    dengan Pasien</div></td>
      </tr>
	  </thead>
      <tbody class="pemberian_edukasi">
		<?php
		$sql = "select a.*, DATE_FORMAT(a.tanggal_jam, '%d-%m-%Y %H:%i:%s') tanggal_jam2
			from lap_pemberian_edukasi a 
			where a.pelayanan_id = {$idPel}
			order by a.id asc";
			//echo $sql;
		$cek = mysql_num_rows(mysql_query($sql));?>
        <input type="hidden" id="cek" value="<?php echo $cek; ?>"/>
        <?php
		$query = mysql_query($sql);
		$z=0;
		while($rows = mysql_fetch_assoc($query)){
			?>
			<tr height="35" class="item">
				<td height="35" align="center">
					<input type="hidden" id="id" value="<?php echo $rows['id']; ?>"/>
					<input type="text" id="tanggal_jam<?php echo $z;?>" style="width:120px;" value="<?php echo $rows['tanggal_jam2']; ?>"/>
				</td>
				<td align="center"><select id="bagian" name="bagian">
              <option>Senin</option>
              <option>Selasa</option>
              <option>Rabu</option>
              <option>Kamis</option>
              <option>Jumat</option>
              <option>Sabtu</option>
              <option>Minggu</option>
            </select></td>
				<td align="center"><input type="text" id="informasi" style="width:330px;" value="<?php echo $rows['informasi']; ?>"/></td>
				<td align="center"><input type="text" id="petugas" style="width:130px;" value="<?php echo $rows['petugas']; ?>"/></td>
				<td align="center"><input type="text" id="penerima" style="width:90px;" value="<?php echo $rows['penerima']; ?>"/></td>
				<td align="center"><input type="text" id="hubungan_pasien" style="width:90px;" value="<?php echo $rows['hubungan_pasien']; ?>"/></td>
				<td align="center">
					<button class="simpan"> > </button> 
					<button class="hapus"> - </button>
				</td>
			</tr>
		  <?php
		$z++;}
		?>
	  </tbody>
    </table></td>
  </tr>
</table><br/><br/>
<button class="print">Print</button>
</body>
</html>
