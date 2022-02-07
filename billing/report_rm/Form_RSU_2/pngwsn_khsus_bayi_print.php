<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PENGAWASAN KHUSUS BAYI</title>
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
	$( "#tgl_jam"+i ).datetimepicker({
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

<?php 
include('pengawasan_util.php');
 ?>
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
					'<input type="text" id="tgl_jam'+idx+'" style="width:120px;"/>' +
				'</td>' +
				'<td align="center"><input type="text" id="ku" style="width:200px;"/></td>' +
				'<td align="center"><input type="text" id="suhu" style="width:80px;"/></td>' +
				'<td align="center"><input type="text" id="nadi" style="width:120px;"/></td>' +
				'<td align="center"><input type="text" id="pernafasan" style="width:90px;"/></td>' +
				'<td align="center"><input type="text" id="minun" style="width:150px;"/></td>' +
				'<td align="center"><input type="text" id="infus" style="width:100px;"/></td>' +
				'<td align="center"><input type="text" id="mt" style="width:100px;"/></td>' +
				'<td align="center"><input type="text" id="bab" style="width:100px;"/></td>' +
				'<td align="center"><input type="text" id="bak" style="width:100px;"/></td>' +
				'<td align="center"><input type="text" id="keterangan" style="width:100px;"/></td>' +
				'<td align="center">' +
					'<button class="simpan"> > </button> ' +
					'<button class="hapus"> - </button>' +
				'</td>' +
			'</tr>');
			
	$('.terapi_insulin tr:eq('+idx+') #tgl_jam'+idx).datetimepicker({
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
				url: 'pngwsn_khsus_bayi_utils.php',
				success: function(){
					elm.remove();
				}
			});
		}
	});
	
	$('.terapi_insulin').on('click', '.simpan',function(){
		var id = $(this).parents('tr.item').find('td:eq(0) input:eq(0)').val();
		var elm_id = $(this).parents('tr.item').find('td:eq(0) input:eq(0)');
		var tgl_jam = $(this).parents('tr.item').find('td:eq(0) input:eq(1)').val();
		var ku = $(this).parents('tr.item').find('td:eq(1) input').val();
		var suhu = $(this).parents('tr.item').find('td:eq(2) input').val();
		var nadi = $(this).parents('tr.item').find('td:eq(3) input').val();
		var pernafasan = $(this).parents('tr.item').find('td:eq(4) input').val();
		var minum = $(this).parents('tr.item').find('td:eq(5) input').val();
		var infus = $(this).parents('tr.item').find('td:eq(6) input').val();
		var mt = $(this).parents('tr.item').find('td:eq(7) input').val();
		var bab = $(this).parents('tr.item').find('td:eq(8) input').val();
		var bak = $(this).parents('tr.item').find('td:eq(9) input').val();
		var keterangan = $(this).parents('tr.item').find('td:eq(10) input').val();
		$.ajax({
			type: 'post',
			data: 'type=save&id='+id
				+'&kunjungan_id='+kunjungan_id+'&pelayanan_id='+pelayanan_id
				+'&user_id='+user_id+'&tgl_jam='+tgl_jam+'&ku='+ku
				+'&suhu='+suhu+'&nadi='+nadi
				+'&pernafasan='+pernafasan+'&minum='+minum+'&infus='+infus
				+'&mt='+mt+'&bab='+bab
				+'&bak='+bak+'&keterangan='+keterangan,
			url: 'pngwsn_khsus_bayi_utils.php',
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

<table width="949" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #000000">
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
  
  
  <tr height="21">
    <td height="21" class="judul2">&nbsp;</td>
    <td colspan="2" class="judul2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td></td>
  </tr>
  <tr height="21">
    <td height="21" colspan="6" align="center" class="judul2"><table cellspacing="0" cellpadding="0" width="200">
      <col width="24" span="10" />
      <col width="30" />
      <col width="24" />
      <col width="30" />
      <col width="24" span="13" />
      <col width="31" />
      <tr>
        <td width="24" align="center" valign="top"><img src="pngwsn_khsus_bayi_clip_image002.png" alt="" width="317" height="61" />
            <table cellpadding="0" cellspacing="0">
              <tr>
                <td width="24"></td>
              </tr>
          </table></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="30"></td>
        <td width="24"></td>
        <td width="30"></td>
        <td width="24" align="center" valign="top"><img src="pngwsn_khsus_bayi_clip_image004.png" alt="" width="345" height="51" />
            <table cellpadding="0" cellspacing="0">
              <tr>
                <td width="24"></td>
              </tr>
          </table></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="24"></td>
        <td width="31"></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    </table></td>
  </tr>
  <tr height="21">
    <td height="21" class="judul2">&nbsp;</td>
    <td height="21" colspan="2" class="judul2">&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="15">
    <td colspan="6"><table width="660" align="center" class="tabel" style="border:1px solid #000; font:12px tahoma;">
      <tr>
        <td width="92" style="border-bottom:.5pt solid black;">NAMA BAYI</td>
          <td width="194" style="border-bottom:.5pt solid black;">:
              
            <?php echo $pasien['nama']; ?>        </td>
          <td width="154" style="border-bottom:.5pt solid black;">NAMA IBU</td>
          <td width="200" style="border-bottom:.5pt solid black;">:
            <?php echo $pasien['ortu']; ?></td>
        </tr>
      <tr>
        <td style="border-bottom:.5pt solid black;">TGL LAHIR</td>
          <td style="border-bottom:.5pt solid black;">:
          <?php echo $pasien['tgl_lhr']; ?></td>
          <td style="border-bottom:.5pt solid black;">NO. REGISTRASI</td>
          <td style="border-bottom:.5pt solid black;">:
          <?php echo $pasien['no_reg']; ?>        </td>
        </tr>
      <tr>
        <td>RUANGAN</td>
          <td>:
          <?php echo $pasien['unit2']; ?></td>
          <td>NO. REKAM MEDIS</td>
          <td>:
          <?php echo $pasien['no_rm']; ?></td>
        </tr>
    </table></td>
  </tr>
  
  <tr height="15">
    <td height="15"></td>
    <td></td>
    <td></td>
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
  <tr height="15">
    <td height="15" colspan="6"><table width="854" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
      <tr>
        <td width="30" align="center"><strong>NO</strong></td>
        <td width="94" align="center"><strong> TANGGAL </strong></td>
        <td width="50" align="center"><strong>JAM</strong></td>
        <td width="30" align="center"><strong>KU</strong></td>
        <td width="56" align="center"><strong>SUHU</strong></td>
        <td width="48" align="center"><strong>NADI</strong></td>
        <td width="108" align="center"><strong>PERNAFASAN</strong></td>
        <td width="95" align="center"><strong>MINUM</strong></td>
        <td width="52" align="center"><strong>INFUS</strong></td>
        <td width="36" align="center"><strong>MT</strong></td>
        <td width="43" align="center"><strong>BAB</strong></td>
        <td width="43" align="center"><strong>BAK</strong></td>
        <td width="141" align="center"><strong>KETERANGAN</strong></td>
      </tr>
	  <?php
	  $no=1;
	  $sql="select * from b_ms_pengawasan_khusus_bayi where pelayanan_id='$idPel'";
	  $query=mysql_query($sql);
	  while($data=mysql_fetch_array($query)){
	  if ($no%2!=0)
	  {
	  	$bg='#FFF';
	  }
	  else
	  {
	  	$bg='#EEE';
	  }
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$no?></td>
		<td align="center"><? echo date('d-m-Y', strtotime($data['tgl_jam']));?></td>
        <td align="center"><? echo date('H:i:s', strtotime($data['tgl_jam']));?></td>
        <td align="center"><?=$data['ku']?></td>
        <td align="center"><?=$data['suhu']?></td>
        <td align="center"><?=$data['nadi']?></td>
        <td align="center"><?=$data['pernafasan']?></td>
        <td align="center"><?=$data['minum']?></td>
        <td align="center"><?=$data['infus']?></td>
        <td align="center"><?=$data['mt']?></td>
        <td align="center"><?=$data['bab']?></td>
        <td align="center"><?=$data['bak']?></td>
        <td align="center"><?=$data['keterangan']?></td>
      </tr>
	  <?php
	  $no++;
	  }
	  ?>
    </table></td>
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
    <td colspan="6">&nbsp;</td>
  </tr>
  
  <tr height="35">
    <td colspan="6">
	<tr id="trTombol">
  <td align="center" colspan="6"><button onclick="cetak(document.getElementById('trTombol'));" type="button">Cetak</button>
  <button onclick="window.close();" type="button">Tutup</button></td>
  </tr></td>
  </tr>
</table>
<br/><br/>

</body>
<script>
    function cetak(tombol){
        tombol.style.visibility='collapse';
        if(tombol.style.visibility=='collapse'){
            if(confirm('Anda yakin mau mencetak ?')){
                setTimeout('window.print()','1000');
                setTimeout('window.close()','2000');
            }
            else{
                tombol.style.visibility='visible';
            }

        }
    }
</script>
</html>
