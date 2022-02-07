<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>
<link rel="stylesheet" type="text/css" href="js/jquery.timeentry.css" />
<script src="js/jquery-1.8.3.js"></script>
<script src="js/jquery.form.js"></script>
<!--<script src="js/jquery.timeentry.js"></script>-->
<script src="jquery.table.addrow.js"></script>

<!--<link type="text/css" rel="stylesheet" href="../../theme/mod.css">
<script language="JavaScript" src="../../theme/js/mod.js"></script>
<script language="JavaScript" src="../../theme/js/dsgrid.js"></script>
<script src="../../theme/dhtmlxcalendar.js" type="text/javascript"></script>-->

<?
include "../../koneksi/konek.php";
$id_kunjungan = $_REQUEST['idKunj'];
$id_pelayanan = $_REQUEST['idPel'];
$q = "select * from b_ms_cp where id_kunjungan='$id_kunjungan' and id_pelayanan='$id_pelayanan'"; //echo $q;
$s = mysql_query($q);
$j = mysql_num_rows($s); //echo "$j";
?>
<link rel="stylesheet" type="text/css" href="../../include/jquery/themes/base/ui.all.css" />
<link rel="stylesheet" type="text/css" href="../../include/jquery/jquery-ui-timepicker-addon.css" />
<script src="../../include/jquery/ui/jquery.ui.core.js"></script>
<script src="../../include/jquery/ui/jquery.ui.widget.js"></script>
<script src="../../include/jquery/ui/jquery.ui.datepicker.js"></script>
<script src="../../include/jquery/jquery-ui-timepicker-addon.js"></script>
<script src="../../include/jquery/external/jquery.bgiframe-2.1.2.js"></script>
<script>

$("document").ready(function(){
	<?
	if($j==0)
	{
	?>
	$(".tgl_ct").val('');
	<?
	}
	?>
	
	var x = <?=$j-1;?>;
	$(".alternativeRow").btnAddRow({oddRowCSS:"oddRow",evenRowCSS:"evenRow",rowNumColumn: 'no'},function(barisBaru){
		x++;
		$(barisBaru).find(".tgl_ct").attr("id","tgl_ct"+x);
		$(barisBaru).find(".hasDatepicker").removeClass('hasDatepicker');
		$(barisBaru).find(".tgl_ct").datetimepicker
		({
			changeMonth: true,
			changeYear: true,
			//showOn: "button",
			//buttonImage: "../../images/cal.gif",
			//buttonImageOnly: true
		});
		
		
	});
	
	
	//$(".jam_ct").timeEntry({show24Hours: true, showSeconds: false});
	$(".tgl_ct").datetimepicker({
		changeMonth: true,
		changeYear: true,
		//showOn: "button",
		//buttonImage: "../../images/cal.gif",
		//buttonImageOnly: true
	});
	
	$(".delRow").btnDelRow();
	
});


	

</script>
<style>
/* This is the style for the trigger icon. The margin-bottom value causes the icon to shift down to center it. */
.ui-datepicker-trigger {
cursor:pointer;
margin-left:3px;
margin-top: 3px;
margin-bottom: -6px;
position:relative;
}
.ui-datepicker
{font:12px tahoma;
}
input[type=text]{
padding:3px;
border:1px solid #52D6ED;
}
</style>
<body>
<? include "setting.php"; //echo "$j kkk"; ?>
<div id="formx" style="margin:auto; margin-bottom:20px; width:1000px; display:block;">
<form id="form_cp" method="post" action="cp_act.php">
<table width="1000" border="0" align="center" style="font:12px Verdana, Arial, Helvetica, sans-serif;">
  <tr>
    <td width="566" valign="top">&nbsp;</td>
    <td width="430">
	<table width="407" border="0" cellpadding="4" style="border:1px solid #000000; font:10px Verdana, Arial, Helvetica, sans-serif">
      <tr>
        <td width="117">Nama Pasien </td>
        <td width="8">:</td>
        <td width="260"><?=$nama;?> (<?=$sex;?>)</td>
      </tr>
      <tr>
        <td>Tanggal Lahir </td>
        <td>:</td>
        <td><?=$tgl;?>  /Usia : <?=$umur;?> th </td>
      </tr>
      <tr>
        <td>No. RM </td>
        <td>:</td>
        <td><?=$noRM;?> No. Registrasi :_________ </td>
      </tr>
      <tr>
        <td>Ruang rawat/Kelas </td>
        <td>:</td>
        <td><?=$kamar;?> / <?=$kelas;?></td>
      </tr>
      <tr>
        <td height="23">Alamat</td>
        <td>:</td>
        <td><?=$alamat;?></td>
      </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">Ruang Rawat / Unit Kerja : <input type="text" name="ruang_ct" id="ruang_ct" class="ruang_ct" style="font:12px Verdana, Arial, Helvetica, sans-serif; padding:2px 3px; border:1px solid #333" size="35" value="<? echo $kamar."/".$kelas;?>" /></td>
  </tr>
  <tr>
    <td colspan="2" align="center" style="font:bold 14px tahoma;">
	<input type="hidden" name="id_kunjungan" id="id_kunjungan" size="5" value="<?=$_REQUEST['idKunj'];?>" />
    <input type="hidden" name="id_pelayanan" id="id_pelayanan" size="5" value="<?=$_REQUEST['idPel'];?>" />
	<input type="hidden" name="list_hapus" id="list_hapus" />
	</td>
  </tr>
  <tr>
    <td colspan="2" align="center" style="font:bold 14px tahoma;">CATATAN PERKEMBANGAN PASIEN TERINTEGRASI </td>
  </tr>
  <tr>
    <td colspan="2" align="right" style="font:bold 14px tahoma;"><input type="hidden" name="idUsr_ct" id="idUsr_ct" size="5" value="<?=$idUser;?>" /></td>
  </tr>
  <tr>
    <td colspan="2"><div id="datax">
	<table width="1000" border="1" style="border-collapse:collapse;" bgcolor="#E8F8FF" class="atable" id="tabelku">
      <tr align="center" bgcolor="#9AD8FC">
        <td width="170">Tanggal / Jam </td>
        <td width="124">Profesi / Bagian </td>
        <td width="293">HASIL PEMERIKSAAN, ANALISIS, RENCANA PENATALAKSANAAN PASIEN <br />
          <br />
          <span style="font:10px Verdana, Arial, Helvetica, sans-serif">(Dituliskan dengan format SOAP/ADIME, disertai dengan Target yang Terukur, Evaluasi Hasil Tatalaksana dituliskan dalam Assessment, Harap bubuhkan Stempel Nama, dan Paraf Pada Setiap Akhir Catatan)</span></td>
        <td width="187">Instruksi Tenaga Kesehatan Termasuk Pasca Bedah / Prosedur <br />
          <span style="font:10px Verdana, Arial, Helvetica, sans-serif">(Instruksi Ditulis dengan Rinci dan Jelas)</span></td>
        <td width="142">VERIFIKASI DPJP <span style="font:10px Verdana, Arial, Helvetica, sans-serif">(Bubuhkan Stempel, Nama, Paraf, Tgl, Jam) (DPJP harus membaca seluruh rencana perawatan)</span> </td>
        <td width="44" valign="bottom">
          <input name="button" type="button" class="alternativeRow" value="(+)" style="cursor:pointer; background:#FFFF66; border:1px solid #FFCC33; padding:2px 3px;"/>        </td>
      </tr>
	  <?
	  if($j==0)
	  {
	  ?>
      <tr>
        <td><input type="text" name="tgl_ct[]" id="tgl_ct0" class="tgl_ct" size="17"  style="font:10px Verdana, Arial, Helvetica, sans-serif;"/></td>
        <td><input type="text" name="prof_ct[]" id="prof_ct" class="prof_ct" style="font:10px Verdana, Arial, Helvetica, sans-serif;" size="15" /></td>
        <td align="center"><input type="text" name="hasil_ct[]" id="hasil_ct" class="hasil_ct" style="font:10px Verdana, Arial, Helvetica, sans-serif;" size="35" /></td>
        <td><input type="text" name="instruksi_ct[]" id="instruksi_ct" class="instruksi_ct" style="font:10px Verdana, Arial, Helvetica, sans-serif;" size="25" /></td>
        <td><input type="text" name="veri_ct[]" id="veri_ct" class="veri_ct" style="font:10px Verdana, Arial, Helvetica, sans-serif;" size="20" /></td>
        <td align="center"><img src="cross.png" class="delRow" border="0" style="cursor:pointer;" onclick="del('0')"></td>
      </tr>
	  <?
	  }
	  else
	  {
	  	  $urutan = 0;
		  while($d = mysql_fetch_array($s))
		  {
	  ?>
		  <tr>
			<td>
			<input type="hidden" name="id_ct[]" id="id_ct" class="id_ct" size="5"  style="font:10px Verdana, Arial, Helvetica, sans-serif;" value="<?=$d['id'];?>"/>
			<input type="hidden" name="user_ct[]" id="id_ct" class="id_ct" size="5"  style="font:10px Verdana, Arial, Helvetica, sans-serif;" value="<?=$d['user_act'];?>"/>
			<input type="text" name="tgl_ct[]" id="tgl_ct<?=$urutan;?>" class="tgl_ct" size="17"  style="font:10px Verdana, Arial, Helvetica, sans-serif;" value="<?=tglJamSQL($d['tgl_ct']);?>"/></td>
			<td><input type="text" name="prof_ct[]" id="prof_ct<?=$urutan;?>" class="prof_ct" style="font:10px Verdana, Arial, Helvetica, sans-serif;" size="15" value="<?=$d['prof_ct'];?>" /></td>
			<td align="center"><input type="text" name="hasil_ct[]" id="hasil_ct<?=$urutan;?>" class="hasil_ct" style="font:10px Verdana, Arial, Helvetica, sans-serif;" size="35" value="<?=$d['hasil_ct'];?>" /></td>
			<td><input type="text" name="instruksi_ct[]" id="instruksi_ct<?=$urutan;?>" class="instruksi_ct" style="font:10px Verdana, Arial, Helvetica, sans-serif;" size="25" value="<?=$d['instruksi_ct'];?>" /></td>
			<td><input type="text" name="veri_ct[]" id="veri_ct<?=$urutan;?>" class="veri_ct" style="font:10px Verdana, Arial, Helvetica, sans-serif;" size="20" value="<?=$d['veri_ct'];?>" /></td>
			<td align="center"><img src="cross.png" class="delRow" border="0" style="cursor:pointer;" onclick="del('<?=$d['id'];?>')"></td>
		  </tr>
	 <?
	 	$urutan++;
	 	}
	 }
	 ?>
    </table>
	</div>
	</td>
  </tr>
</table>
<br />
<table width="1000" border="0" align="center">
  <tr>
    <td align="center"><input type="button" name="button_cp" id="button_cp" value="Simpan" onclick="proses()" style="border:1px solid #999999; cursor:pointer; background:#CCCCCC; padding:3px;" />
	&nbsp;
	<input type="button" name="button_cp2" id="button_cp2" value="batal" onclick="batal()" style="border:1px solid #999999; cursor:pointer; background:#CCCCCC; padding:3px;" /></td>
  </tr>
</table>
</form>
</div>


<!--<div id="gridx" style="margin-top:20px;">
<table width="900" border="0" align="center">
  <tr>
    <td align="right">
	<img src="../../images/plus.jpg" width="30" height="30" onclick="tambah()" style="cursor:pointer;" />&nbsp;&nbsp;
	<img src="../../images/edit.jpg" width="30" height="30" onclick="edit()" style="cursor:pointer;" />&nbsp;&nbsp;
	<img src="../../images/del.jpg" width="30" height="30" onclick="hapus()" style="cursor:pointer;" /></td>
  </tr>
  <tr>
    <td>
	<div class="TabView" id="gridbox" style="width: 900px; height: 350px;"></div>
	<div id="paging" style="width:900px;"></div>
	</td>
  </tr>
</table>
</div>-->

</body>
</html>
<script>
function reload_data()
{
	var a = $("#id_kunjungan").val();
	var b = $("#id_pelayanan").val();
	$("#datax").load("cp_data.php?idKunj="+a+"&idPel="+b);
	
}
function del(id)
{
	var val = $("#list_hapus").val();
	var new_val = val+","+id;
	$("#list_hapus").val(new_val);
}
function proses()
{
	//var act = $('#act_mati').val();
	$("#form_cp").ajaxSubmit
	({
	  //target: "#pesan",
	  success:function(msg)
		{
			//alert(msg);
			if(msg=='sukses')
			{
				alert('Data sukses disimpan');
				$("#list_hapus").val('');
				//reload_data();
			}
			else
			{
				alert('Data gagal di simpan');
			}
		},
	  //resetForm:true
	});
	return false;
}
</script>