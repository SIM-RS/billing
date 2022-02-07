<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>TERAPI INSULIN</title>
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
<?php if($_REQUEST['report']!=1){?>
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
<?php }?>
</script>
<?php include('serah_terima_bayi_pulang_utils.php'); ?>
<script type="text/javascript">
$(function(){
	var kunjungan_id = '<?php echo $idKunj; ?>';
	var pelayanan_id = '<?php echo $idPel; ?>';
	var pasien_id = '<?php echo $idPsn; ?>';
	var user_id = '<?php echo $idUsr; ?>';

	$('.tambah').click(function(){
		var idx = $('.terapi_insulin tr').length;
		$('.terapi_insulin').append('<tr height="40" class="item">' +
				'<td height="40" align="center">' +
					'<input type="hidden" id="id"/>' +
					'<input type="text" id="tanggal_jam'+idx+'" style="width:120px;"/>' +
				'</td>' +
				'<td align="center"><input type="text" id="jenis" style="width:200px;"/></td>' +
				'<td align="center"><input type="text" id="dosis" style="width:80px;"/></td>' +
				'<td align="center"><input type="text" id="gula" style="width:120px;"/></td>' +
				'<td align="center"><input type="text" id="reduksi" style="width:90px;"/></td>' +
				'<td align="center"><input type="text" id="ket" style="width:150px;"/></td>' +
				'<td align="center"><input type="text" id="nama" style="width:100px;"/></td>' +
				'<td align="center">' +
					'<button class="simpan"> > </button> ' +
					'<button class="hapus"> - </button>' +
				'</td>' +
			'</tr>');
			
	$('.terapi_insulin tr:eq('+idx+') #tanggal_jam'+idx).datetimepicker({
			changeMonth: true,
			changeYear: true,
			showOn: "button",
			buttonImage: "../../images/cal.gif",
			buttonImageOnly: true
		});		
			
	});
	
	
	$('.terapi_insulin').on('click', '.hapus',function(){
		if(confirm('Apakah anda yakin?')){
			var id = $(this).parents('tr.item').find('td:eq(0) input:eq(0)').val();
			var elm = $(this).parents('tr.item');
			$.ajax({
				type: 'post',
				data: 'type=delete&id='+id,
				url: 'terapi_insulin_utils.php',
				success: function(){
					elm.remove();
				}
			});
		}
	});
	
	$('.terapi_insulin').on('click', '.simpan',function(){
		var id = $(this).parents('tr.item').find('td:eq(0) input:eq(0)').val();
		var elm_id = $(this).parents('tr.item').find('td:eq(0) input:eq(0)');
		var tanggal_jam = $(this).parents('tr.item').find('td:eq(0) input:eq(1)').val();
		var jenis = $(this).parents('tr.item').find('td:eq(1) input').val();
		var dosis = $(this).parents('tr.item').find('td:eq(2) input').val();
		var gula = $(this).parents('tr.item').find('td:eq(3) input').val();
		var reduksi = $(this).parents('tr.item').find('td:eq(4) input').val();
		var ket = $(this).parents('tr.item').find('td:eq(5) input').val();
		var nama = $(this).parents('tr.item').find('td:eq(6) input').val();
		$.ajax({
			type: 'post',
			data: 'type=save&id='+id
				+'&kunjungan_id='+kunjungan_id+'&pelayanan_id='+pelayanan_id
				+'&user_id='+user_id+'&tanggal_jam='+tanggal_jam+'&jenis='+jenis
				+'&dosis='+dosis+'&gula='+gula
				+'&reduksi='+reduksi+'&ket='+ket+'&nama='+nama,
			url: 'terapi_insulin_utils.php',
			success: function(id){
				if(id)
					elm_id.val(id);
				alert('sukses');
			}
		});
	});
	
	$('.print').click(function(){
		window.open('terapi_insulin_print.php?idKunj='+kunjungan_id+'&idPel='+pelayanan_id+'&idPasien='+pasien_id+'&idUsr='+user_id);
	});
});
</script>
</head>

<body>

<table cellspacing="0" cellpadding="0">
  <col width="65" />
  <col width="105" />
  <col width="385" />
  <col width="190" />
  <col width="105" span="2" />
  <tr height="20">
    <td height="20" width="117"></td>
    <td width="27"></td>
    <td width="273"></td>
    <td width="296"></td>
    <td width="95"></td>
    <td width="96"></td>
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
    <td colspan="2" rowspan="5">
    <table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="167" height="100" class="judul1"><div align="center">TERAPI INSULIN</div></td>
    </tr>
</table>
    </td>
    <td></td>
  </tr>
  <tr height="28">
    <td height="28" colspan="3" class="judul1">RUMAH    SAKIT PELINDO I</td>
    <td></td>
  </tr>
  <tr height="20">
    <td height="20"></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="20">
    <td height="20"></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="21">
    <td height="21" class="judul2">Nama Pasien</td>
    <td colspan="2" class="judul2">:&nbsp;&nbsp;&nbsp;<?php echo $pasien['nama'].' '.$pasien['sex']; ?></td>
    <td></td>
  </tr>
  <tr height="21">
    <td height="21" class="judul2">Dokter (DPJP)</td>
    <td height="21" colspan="2" class="judul2">:&nbsp;&nbsp;&nbsp;<?php echo $pasien['dokter']; ?></td>
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
        <td height="77" width="139"><div align="center">TANGGAL JAM</div></td>
        <td width="112"><div align="center">JENIS INSULIN</div></td>
        <td width="364"><div align="center">DOSIS</div></td>
        <td width="130"><div align="center">GULA DARAH</div></td>
        <td width="105"><div align="center">REDUKSI</div></td>
        <td width="105"><div align="center">KET</div></td>
        <td width="105"><div align="center">NAMA & TT</div></td>
        <td width="200"><div align="center"><?php
                    if($_REQUEST['report']!=1){
					?><button class="tambah"> + </button><?php }?></div></td>
      </tr>
      </thead>
      <tbody class="terapi_insulin">
		<?php
		$sql = "select a.*, DATE_FORMAT(a.tanggal_jam, '%d-%m-%Y %H:%i:%s') tanggal_jam2
			from b_ms_terapi_insulin a 
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
				<td align="center"><input type="text" id="jenis" style="width:200px;" value="<?php echo $rows['jenis']; ?>"/></td>
				<td align="center"><input type="text" id="dosis" style="width:80px;" value="<?php echo $rows['dosis']; ?>"/></td>
				<td align="center"><input type="text" id="gula" style="width:120px;" value="<?php echo $rows['gula']; ?>"/></td>
				<td align="center"><input type="text" id="reduksi" style="width:90px;" value="<?php echo $rows['reduksi']; ?>"/></td>
				<td align="center"><input type="text" id="ket" style="width:150px;" value="<?php echo $rows['ket']; ?>"/></td>
				<td align="center"><input type="text" id="nama" style="width:100px;" value="<?php echo $rows['nama']; ?>"/></td>
				<td align="center">
					<?php
                    if($_REQUEST['report']!=1){
					?><button class="simpan"> > </button> 
					<button class="hapus"> - </button><?php }?>
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
<script type="text/javascript">
<?php if($_REQUEST['report']==1){?>
	jQuery("#jenis").prop("readonly",true);
	jQuery("#dosis").prop("readonly",true);
	jQuery("#gula").prop("readonly",true);
	jQuery("#reduksi").prop("readonly",true);
	jQuery("#ket").prop("readonly",true);
	jQuery("#nama").prop("readonly",true);
<?php }?>
</script>
</body>
</html>
