<?php
session_start();
//print_r($t);
/*$db = 'rencana';
$connection = mysql_connect('127.0.0.1', 'root', '');
mysql_select_db($db, $connection);*/
//$result = mysql_query("SELECT * FROM perawat");
//					echo mysql_error();

//$sql = ("select tanggal,dnspg,roompg,dnssr,roomsr,dnsmlm,roommlm
			//	from perawat");
			//$row = mysql_fetch_array($sql);
	/*		while($row = mysql_fetch_array($result)) 
                       {
                        $tanggal = $row['tanggal'];
                        $dnspg = $row['dnspg'];
						$roompg = $row['roompg'];
                        $dnssr = $row['dnssr'];
						$roomsr = $row['roomsr'];
						$dnsmlm = $row['dnsmlm'];
                        $roommlm = $row['roommlm'];
					   }
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>RENCANA HARIAN PERAWAT</title>
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
/*$(function() {
	var yes = $("#cek").val();
	//alert (yes);
	var i=0;
	while (i<yes){ 
	$( "#tanggal"+i ).datetimepicker({
		changeMonth: true,
		changeYear: true,
		showOn: "button",
		buttonImage: "../../images/cal.gif",
		buttonImageOnly: true,
		timeFormat: "HH:mm:ss"
	});
	i++;}
});*/
</script>
<?php include('rencana_pasien_utils.php'); ?>
<?php
$que="SELECT b.nama AS namakamar, c.nama AS namapasien, GROUP_CONCAT(md.nama) AS diagnosis FROM b_pelayanan a
INNER JOIN b_ms_unit b ON a.unit_id = b.id
INNER JOIN b_ms_pasien c ON a.pasien_id = c.id
LEFT JOIN b_diagnosa d ON a.id = d.pelayanan_id
LEFT JOIN b_ms_diagnosa md ON md.id = d.ms_diagnosa_id
WHERE a.id = '".$idPel."'";
$isi=mysql_fetch_array(mysql_query($que));
?>
<script type="text/javascript">
$(function(){
	var kunjungan_id = '<?php echo $idKunj; ?>';
	var pelayanan_id = '<?php echo $idPel; ?>';
	var pasien_id = '<?php echo $idPsn; ?>';
	var user_id = '<?php echo $idUsr; ?>';
	var inap = '<?php echo $inap; ?>';
	var kelas_id = '<?php echo $kelas_id; ?>';
	
	$('.tambah1').click(function(){
		var idx = $('.rncana_pasien tr').length;
		$('.rncana_pasien').append('<tr height="40" class="item">' +
				'<td height="40" align="center">' +
					'<input type="hidden" id="id"/>' +
					'<input type="hidden" id="kamar" value="<?php echo $isi['namakamar'];?>" style="width:120px;"/><?php echo $isi['namakamar'];?>' +
				'</td>' +
				'<td align="center"><input type="hidden" id="nmpasien" value="<?php echo $isi['namapasien'];?>" style="width:120px;"/><?php echo $isi['namapasien'];?></td>' +
				'<td align="center"><input type="hidden" id="diagnosmedis" value="<?php echo $isi['diagnosis'];?>" style="width:120px;"/><?php echo $isi['diagnosis'];?></td>' +
				'<td align="center"><input type="text" id="infuse" style="width:120px;"/></td>' +
				'<td align="center"><input type="text" id="renpag" style="width:120px;"/></td>' +
				'<td align="center"><input type="text" id="renso" style="width:120px;"/></td>' +
				'<td align="center"><input type="text" id="renma" style="width:120px;"/></td>' +
				'<td align="center">' +
					'<button class="simpan1"> > </button> ' +
					'<button class="hapus1"> - </button>' +
				'</td>' +
			'</tr>');
	});
	
	$('.rncana_pasien').on('click', '.hapus1',function(){
		if(confirm('Apakah anda yakin untuk menghapus?')){
			var id = $(this).parents('tr.item').find('td:eq(0) input:eq(0)').val();
			var elm = $(this).parents('tr.item');
			//alert ('type=delete&id='+id);
			$.ajax({
				type: 'post',
				data: 'tipe=delete&id='+id,
				url: 'rencana_pasien_utils.php',
				success: function(){
					elm.remove();
				}
			});
		}
	});
	
	$('.rncana_pasien').on('click', '.simpan1',function(){
		var id = $(this).parents('tr.item').find('td:eq(0) input:eq(0)').val();
		var elm_id = $(this).parents('tr.item').find('td:eq(0) input:eq(0)');
		var kamar = $(this).parents('tr.item').find('td:eq(0) input:eq(1)').val();
		var nmpasien = $(this).parents('tr.item').find('td:eq(1) input').val();
		var diagnosmedis = $(this).parents('tr.item').find('td:eq(2) input').val();
		var infuse = $(this).parents('tr.item').find('td:eq(3) input').val();
		var rncanapagi = $(this).parents('tr.item').find('td:eq(4) input').val();
		var rncanasore = $(this).parents('tr.item').find('td:eq(5) input').val();
		var rncanamlm = $(this).parents('tr.item').find('td:eq(6) input').val();
		//alert ($(this).parents('tr.item').find('td:eq(0) input:eq(0)').val());
		var dinas = $('#dinas').val(); 
		$.ajax({
			type: 'get',
			data: 'tipe=save&id='+id
				+'&kamar='+kamar+'&nmpasien='+nmpasien
				+'&diagnosmedis='+diagnosmedis+'&infuse='+infuse
				+'&rncanapagi='+rncanapagi+'&rncanasore='+rncanasore
				+'&rncanamlm='+rncanamlm+'&dinas='+dinas
				+'&pelayanan_id='+pelayanan_id+'&kunjungan_id='+kunjungan_id
				+'&user_id='+user_id+'&inp='+inap+'&kls_id='+kelas_id,
			url: 'rencana_pasien_utils.php',
			success: function(id){
				if(id)
					elm_id.val(id);
				alert('sukses');
			}
		});
	});
	
	$('.print').click(function(){
		window.open('rencana_perawat_print.php?idKunj=<?=$idKunj?>&idPel=<?=$idPel?>&idUser=<?=$idUsr?>&inap=<?=$inap?>&kelas_id=<?=$kelas_id?>');
	});
});
</script>
</head>

<body>
<table width="861" cellpadding="0" cellspacing="0">
  <col width="65" />
  <col width="105" />
  <col width="385" />
  <col width="190" />
  <col width="105" span="2" />
  <tr height="28">
    <td height="28" colspan="3"><span class="judul1">PEMERINTAH    KOTA MEDAN</span></td>
    <td colspan="2" rowspan="5">
    <table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="167" height="100" class="judul1"><div align="center">RENCANA HARIAN PERAWAT</div></td>
    </tr>
</table>
    </td>
    <td width="20"></td>
  </tr>
  <tr height="28">
    <td height="28" colspan="3" class="judul1">RUMAH    SAKIT PELINDO I </td>
    <td></td>
  </tr>
</table>
    <br />
    <br/>
<tr><td><table width="400px">
<tr>
<td width="90px"><strong>Tanggal</strong></td>
<td width="2px">:</td>
<td width="308px"><strong><?php echo date("d F Y");?></strong></td>
</tr>
<tr>
<td><strong>Nama Perawat</strong></td>
<td>:</td>
<td><strong><?php echo $_SESSION['nm_pegawai'];?></strong></td>
</tr>
<tr>
<td><strong>Dinas</strong></td>
<td>:</td>
<td><select id="dinas" name="dinas">
    <option value="1">Dinas Pagi</option>
    <option value="2">Dinas Sore</option>
    <option value="3">Dinas Malam</option>
  </select></td>
</tr>
<tr>
<td><strong>Room</strong></td>
<td>:</td>
<td><strong><?php
echo $isi['namakamar'];
?></strong></td>
</tr>
</table></td></tr><br />
  </tr>
</table>
<br />
    <table width="100%" border="1" cellspacing="0" cellpadding="0">
	<thead>
      <tr height="20">
        <td width="50" align="center" bgcolor="#0066FF">Kamar / TT</td>
        <td width="50" align="center" bgcolor="#0066FF">Nama Pasien</td>
        <td width="50" align="center" bgcolor="#0066FF">Diagnosa Medis / Diagnosa Inap</td>
        <td width="50" align="center" bgcolor="#0066FF">Infuse</td>
        <td width="50" align="center" bgcolor="#0066FF">Rencana Pagi</td>
        <td width="50" align="center" bgcolor="#0066FF">Rencana Sore</td>
        <td width="50" align="center" bgcolor="#0066FF">Rencana Malam</td>
        <?php if($_REQUEST['report']!=1){?><td width="50" bgcolor="#0066FF"><div align="center"><button class="tambah1"> + </button></div></td><?php }?>
      </tr>
  </thead>
  <tbody class="rncana_pasien">  
			<?php
				$sql = mysql_query("select * from b_rencana_harian_perawat")or die(mysql_error());
				//$s = mysql_fetch_array($sql);
				while($s = mysql_fetch_array($sql)) 
                     {
						$id = $s['id'];
                        $kamar = $s['kamar'];
                        $nmpasien = $s['nmpasien'];
						$diagnosmedis = $s['diagnosmedis'];
                        $infuse = $s['infuse'];
						$rncanapagi = $s['rncanapagi'];
						$rncanasore = $s['rncanasore'];
                        $rncanamlm = $s['rncanamlm'];
			?>
            <tr height="35" class="item" onclick="">
				<td height="35" align="center">
               		<input type="hidden" id="id" value="<?php echo $s['id']; ?>"/>
           	  		<input type="hidden" id="kamar" style="width:120px;" 
                    value="<?php if($s['id']!=NULL){echo $kamar;}else{echo $isi['namakamar'];}?>"/><?php if($kamar!=''){echo $kamar;}else{echo $isi['namakamar'];}?></td>
					<td align="center"><input type="hidden" id="nmpasien" 
                    style="width:120px;" value="<?php if($s['id']!=NULL){echo $nmpasien;}else{echo $isi['namapasien'];} ?>"/><?php if($s['id']!=NULL){echo $nmpasien;}else{echo $isi['namapasien'];} ?></td>
					<td align="center"><input type="hidden" id="diagnosmedis" 
                    style="width:120px;" value="<?php if($s['id']!=NULL){echo $diagnosmedis;}else{echo $isi['diagnosis'];} ?>"/><?php if($s['id']!=NULL){echo $diagnosmedis;}else{echo $isi['diagnosis'];} ?></td>
					<td align="center"><input type="text" id="infuse" 
                    style="width:120px;" value="<?php echo $s['infuse']; ?>"/></td>
					<td align="center"><input type="text" id="rncanapagi" style="width:120px;" 
                    value="<?php echo $s['rncanapagi']; ?>"/></td>
					<td align="center"><input type="text" id="rncanasore" style="width:120px;" 
                    value="<?php echo $s['rncanasore']; ?>"/></td>
					<td align="center"><input type="text" id="rncanamlm" style="width:120px;" 
                    value="<?php echo $s['rncanamlm']; ?>"/></td>
					<?php if($_REQUEST['report']!=1){?><td align="center">
					<button class="simpan1"> > </button> 
					<button class="hapus1"> - </button>
				</td><?php }?>
			</tr>
            <?php
					   }
			?>
  </tbody>
</table>
<br/><br/>
<button class="print">Print</button>
<script type="text/javascript">
<?php if($_REQUEST['report']==1){?>
	jQuery("#dinas").prop("disabled",true);
	jQuery("#infuse").prop("readonly",true);
	jQuery("#rncanapagi").prop("readonly",true);
	jQuery("#rncanasore").prop("readonly",true);
	jQuery("#rncanamlm").prop("readonly",true);
<?php }?>
</script>
</body>
</html>