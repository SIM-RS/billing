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

.border {
	border:1px solid black;
}
.border-ab {
	border-top:1px solid black;
	border-bottom:1px solid black;
}
.border-abka {
	border-top:1px solid black;
	border-bottom:1px solid black;
	border-right:1px solid black;
}
.border-abki {
	border-top:1px solid black;
	border-bottom:1px solid black;
	border-left:1px solid black;
}
.border-bkaki {
	border-right:1px solid black;
	border-bottom:1px solid black;
	border-left:1px solid black;
}
.border-bki {
	border-bottom:1px solid black;
	border-left:1px solid black;
}
.border-b {
	border-bottom:1px solid black;
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
	$( "#tanggal_jam"+i ).datepicker({
		changeMonth: true,
		changeYear: true,
		showOn: "button",
		buttonImage: "../../images/cal.gif",
		buttonImageOnly: true
	});
	i++;}
});
</script>
<?php include('serah_terima_bayi_pulang_utils.php'); ?>
<script type="text/javascript">
$(function(){
	var kunjungan_id = '<?php echo $idKunj; ?>';
	var pelayanan_id = '<?php echo $idPel; ?>';
	var user_id = '<?php echo $idUsr; ?>';

	$('.tambah').click(function(){
		var idx = $('.resume_poli tr').length;
		var num = parseInt(idx)+1;
		$('.resume_poli').append('<tr height="40" class="item">' +
				'<td align="center">'+num+'</td>' +
				'<td height="40" align="center">' +
					'<input type="hidden" id="id"/>' +
					'<input type="text" id="tanggal_jam'+idx+'" style="width:70px;"/>' +
				'</td>' +
				'<td align="center"><input type="text" id="diagnosis" style="width:130px;"/></td>' +
				'<td align="center"><input type="text" id="icd" style="width:60px;"/></td>' +
				'<td align="center"><input type="text" id="obat" style="width:170px;"/></td>' +
				'<td align="center"><input type="text" id="riwayat" style="width:150px;"/></td>' +
				'<td align="center"><input type="text" id="prosedur" style="width:150px;"/></td>' +
				'<td align="center"><input type="text" id="nama" style="width:150px;"/></td>' +
				'<td align="center">' +
					'<button class="simpan"> > </button> ' +
					'<button class="hapus"> - </button>' +
				'</td>' +
			'</tr>');
			
	$('.resume_poli tr:eq('+idx+') #tanggal_jam'+idx).datepicker({
			changeMonth: true,
			changeYear: true,
			showOn: "button",
			buttonImage: "../../images/cal.gif",
			buttonImageOnly: true
		});		
			
	});
	
	
	$('.resume_poli').on('click', '.hapus',function(){
		if(confirm('Apakah anda yakin?')){
			var id = $(this).parents('tr.item').find('td:eq(0) input:eq(0)').val();
			var elm = $(this).parents('tr.item');
			$.ajax({
				type: 'post',
				data: 'type=delete&id='+id,
				url: 'resume_poli_utils.php',
				success: function(){
					elm.remove();
				}
			});
		}
	});
	
	$('.resume_poli').on('click', '.simpan',function(){
		var id = $(this).parents('tr.item').find('td:eq(1) input:eq(0)').val();
		var elm_id = $(this).parents('tr.item').find('td:eq(1) input:eq(0)');
		var id_resep = $(this).parents('tr.item').find('td:eq(1) input:eq(1)').val();
		var tanggal_jam = $(this).parents('tr.item').find('td:eq(1) input:eq(2)').val();
		var diagnosis = $(this).parents('tr.item').find('td:eq(2) input').val();
		var icd = $(this).parents('tr.item').find('td:eq(3) input').val();
		var obat = $(this).parents('tr.item').find('td:eq(4) input').val();
		var riwayat = $(this).parents('tr.item').find('td:eq(5) input').val();
		var prosedur = $(this).parents('tr.item').find('td:eq(6) input').val();
		var nama = $(this).parents('tr.item').find('td:eq(7) input').val();
		//alert(id_resep+"\n"+tanggal_jam);
		//return false;
		//alert("");
		$.ajax({
			type: 'post',
			data: 'type=save&id='+id
				+'&kunjungan_id='+kunjungan_id+'&pelayanan_id='+pelayanan_id
				+'&user_id='+user_id+'&nama='+nama
				+'&tanggal_jam='+tanggal_jam+'&diagnosis='+diagnosis
				+'&icd='+icd+'&obat='+obat
				+'&riwayat='+riwayat+'&prosedur='+prosedur+'&id_resep='+id_resep,
			url: 'resume_poli_utils.php',
			success: function(id){
				if(id)
					elm_id.val(id);
				alert('sukses');
			}
		});
	});
	
	$('.print').click(function(){
		window.open('resume_poli_print.php?idKunj='+kunjungan_id+'&idPel='+pelayanan_id+'&idUsr='+user_id);
	});
});
</script>
</head>

<body>
<table cellspacing="0" cellpadding="0">
  <col width="65" />
  <col width="105" />
  <col width="125" />
  <col width="125" />
  <col width="135" />
  <col width="190" />
  <col width="105" span="2" />
  <tr height="20">
    <td height="20" width="105"></td>
    <td width="105"></td>
    <td width="125"></td>
    <td width="125"></td>
    <td width="135"></td>
    <td width="190"></td>
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
    <td height="28" colspan="3" class="judul1">RUMAH SAKIT PELINDO I KOTA MEDAN</td>
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
    <td height="27" colspan="3" class="judul2">RESUME POLIKLINIK</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="27">
    <td height="27" colspan="5">&nbsp;</td>
    <td>NRM</td>
  </tr>
  <tr>
    <td colspan="2" class="border"><p>&nbsp;&nbsp;Nama Lengkap Pasien</p><p>&nbsp;&nbsp;<?=$pasien['nama'];?></p></td>
    <td class="border-ab"><p>&nbsp;&nbsp;Nama Tambahan</p><p>&nbsp;&nbsp;<?php ?></p></td>
    <td class="border"><p>&nbsp;&nbsp;Tgl Lahir</p><p>&nbsp;&nbsp;<?=$pasien['tgl_lhr']?></p></td>
    <td class="border-ab">&nbsp;&nbsp;Jenis Kelamin : <span <?php if($pasien['sex']=='L'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>L</span> / <span <?php if($pasien['sex']=='P'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>P</span></td>
    <td><table width="100%" height="70" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <tr>
        <td height="50"><?=substr($pasien['no_rm'],0,2);?></td>
        <td><?=substr($pasien['no_rm'],2,2);?></td>
        <td><?=substr($pasien['no_rm'],4,3);?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="5" class="border-bki">&nbsp;&nbsp;Alamat Lengkap&nbsp;:&nbsp;<?=$pasien['alamat']?> Kota : <?=$pasien['nm_kab']?> Kelurahan : <?=$pasien['nm_desa']?> Kecamatan : <?=$pasien['nm_kec']?> Rt : <?=$pasien['rt']?> Rw : <?=$pasien['rw']?></td>
	<td class="border-bkaki"><p>&nbsp;&nbsp;No. Telp</p><p>&nbsp;&nbsp;<?=$pasien['telp']?></p></td>
  </tr>
  <tr>
    <td class="border-bki"><p>&nbsp;&nbsp;Tempat Lahir</p><p>&nbsp;&nbsp;<?php ?></p></td>
    <td class="border-bki"><p>&nbsp;&nbsp;Agama</p><p>&nbsp;&nbsp;<?=$pasien['agamanya']?></p></td>
    <td colspan="4"><table width="100%" height="70" border="1" bordercolor="#000000" cellpadding="0" cellspacing="0">
      <tr>
        <td height="50"><p>&nbsp;&nbsp;Suku</p><p>&nbsp;&nbsp;<?php ?></p></td>
        <td><p>&nbsp;&nbsp;Kebangsaan</p><p>&nbsp;&nbsp;<?php ?></p></td>
		<td><p>&nbsp;&nbsp;pekerjaan</p><p>&nbsp;&nbsp;<?=$pasien['pekerjaan']?></p></td>
		<td><p>&nbsp;&nbsp;No. KTP/SIM/Paspor</p><p>&nbsp;&nbsp;<?=$pasien['no_ktp']?></p></td>
        <td align="center"><p>&nbsp;&nbsp;Status Perkawinan</p><p>&nbsp;&nbsp;<span <?php if($dP['sex']=='K'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>> K </span> / <span <?php if($dP['sex']=='TK'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>> TK </span>
		 / <span <?php if($dP['sex']=='C'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>> C </span>
		  / <span <?php if($dP['sex']=='J'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>> J </span>
		   / <span <?php if($dP['sex']=='D'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>> D </span></p></td>
		<td><p>&nbsp;&nbsp;Jenis Pembayaran</p><p>&nbsp;&nbsp;<?
		$query12 = "select nama from b_ms_kso where id = '$pasien[kso_id]'";
		$data12 = mysql_fetch_array(mysql_query($query12));
		echo $data12['nama'];
		 ?></p></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="6"><p>&nbsp;&nbsp;Alergi</p><p>&nbsp;&nbsp;<?php
	$dt12 = "";
	$queryPsn = "SELECT * FROM b_pelayanan where id = $idPel";
	$dqueryPsn = mysql_fetch_array(mysql_query($queryPsn));
	
	$query1  = "SELECT * FROM b_riwayat_alergi WHERE pasien_id = $dqueryPsn[pasien_id]";
	$exequery1 = mysql_query($query1);
	$jmlquery1 = mysql_num_rows($exequery1);
	$jji = 1;
	while($dquery1 = mysql_fetch_array($exequery1))
	{
		if($jji<$jmlquery1)
		{
			$dt12 .= $dquery1['riwayat_alergi'].",";
		}else{
			$dt12 .= $dquery1['riwayat_alergi'];
		}
		
		$jji++;
	}
		echo $dt12;
		
	 ?></p></td>
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
        <td height="77" width="139"><div align="center">No</div></td>
        <td width="112"><div align="center">Tanggal Berkunjung</div></td>
        <td width="112"><div align="center">Diagnosis</div></td>
        <td width="364"><div align="center">ICD</div></td>
        <td width="130"><div align="center">Obat-obatan/Jenis Pemeriksaan</div></td>
        <td width="105"><div align="center">Riwayat Rawat Inap Sejak Kunjungan Terakhir</div></td>
        <td width="105"><div align="center">Prosedur Bedah/Operasi Sejak Kunjungan Terakhir</div></td>
        <td width="105"><div align="center">Nama Jelas dan Tanda Tangan Petugas Kesehatan (dokter, dietisien, terapis)</div></td>
        <td width="200"><div align="center"><?php
                    if($_REQUEST['report']!=1){
					?><button class="tambah" style="display:none;"> + </button><?php }?></div></td>
      </tr>
      </thead>
      <tbody class="resume_poli">
		<?php
$sql = "SELECT a.*, DATE_FORMAT(bk.tgl, '%d-%m-%Y') tanggal_jam2, ab.nama AS nm_diagnosa, ab.kode, CONCAT(abd.OBAT_NAMA,' (',b.ket_dosis,')') AS obat_nama, b.id AS id_resep
FROM b_ms_resume_poli a RIGHT JOIN b_resep b ON a.id_resep = b.id
RIGHT JOIN b_diagnosa abc ON b.diagnosa_id = abc.diagnosa_id
RIGHT JOIN b_ms_diagnosa ab ON abc.ms_diagnosa_id = ab.id 
RIGHT JOIN {$dbapotek}.a_obat abd ON b.obat_id = abd.OBAT_ID
RIGHT JOIN b_kunjungan bk ON b.kunjungan_id = bk.id
where b.id_pelayanan = {$idPel}
ORDER BY ab.id ASC ";
			//echo $sql;
$cek = mysql_num_rows(mysql_query($sql));?>
        <input type="hidden" id="cek" value="<?php echo $cek; ?>"/>
        <?php
		$query = mysql_query($sql);
		$z=0;
		while($rows = mysql_fetch_assoc($query)){
			$w=$z+1;?>
			<tr height="35" class="item">
				<td height="35" align="center"><?php echo $w;?></td>
				<td align="center">
					<input type="hidden" id="id" value="<?php echo $rows['id']; ?>"/>
                    <input type="hidden" id="id_resep" value="<?php echo $rows['id_resep']; ?>"/>
					<input type="text" id="tanggal_jam<?php echo $z;?>" style="width:70px;" value="<?php echo $rows['tanggal_jam2']; ?>"/>
				</td>
				<td align="center"><input type="text" id="diagnosis" style="width:130px;" value="<?php echo $rows['nm_diagnosa']; ?>"/></td>
				<td align="center"><input type="text" id="icd" style="width:60px;" value="<?php echo $rows['kode']; ?>"/></td>
				<td align="center"><input type="text" id="obat" style="width:170px;" value="<?php echo $rows['obat_nama']; ?>"/></td>
				<td align="center"><input type="text" id="riwayat" style="width:150px;" value="<?php echo $rows['riwayat']; ?>"/></td>
				<td align="center"><input type="text" id="prosedur" style="width:150px;" value="<?php echo $rows['prosedur']; ?>"/></td>
				<td align="center"><input type="text" id="nama" style="width:150px;" value="<?php echo $rows['nama']; ?>"/></td>
				<td align="center"><?php
                    if($_REQUEST['report']!=1){
					?>
					<button class="simpan"> > </button> 
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
</body>
</html>
