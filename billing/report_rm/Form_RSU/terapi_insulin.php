<?
include('../../koneksi/konek.php');
$id_kunjungan=$_REQUEST['idKunj'];
$id_pelayanan=$_REQUEST['idPel'];
$idUser=$_REQUEST['idUser'];

include "setting.php";

$q = "select * from b_form_terapi_insulin where id_kunjungan='$id_kunjungan' and id_pelayanan='$id_pelayanan'"; //echo $q;
$s = mysql_query($q);
$j = mysql_num_rows($s); //echo "$j";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Terapi Insulin</title>
		<link type="text/css" rel="stylesheet" href="../../theme/mod.css" />
        <script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../../theme/js/dsgrid.js"></script>

        <!-- untuk ajax-->
        <script type="text/javascript" src="../../theme/js/ajax.js"></script>
        <script type="text/javascript" src="../../jquery.js"></script>
        <script type="text/javascript" src="../../jquery.form.js"></script>
		
		<script src="js/jquery.table.addrow.js"></script>
		<script type="text/javascript" src="../js/jquery.timeentry.js"></script>
		
		<link rel="stylesheet" type="text/css" href="../../include/jquery/themes/base/ui.all.css" />
		<link rel="stylesheet" type="text/css" href="../../include/jquery/jquery-ui-timepicker-addon.css" />
		<script src="../../include/jquery/ui/jquery.ui.core.js"></script>
		<script src="../../include/jquery/ui/jquery.ui.widget.js"></script>
		<script src="../../include/jquery/ui/jquery.ui.datepicker.js"></script>
		<script src="../../include/jquery/jquery-ui-timepicker-addon.js"></script>
		<script src="../../include/jquery/external/jquery.bgiframe-2.1.2.js"></script>
		
		<script>

$("document").ready(function(){
$(".delRow").live("click", function () {

        if(confirm('Yakin data dihapus?'))
		{
			return true;
		}
		else
		{
			return false;
		}

});
$('.jam').timeEntry({show24Hours: true, showSeconds: true});
	<?
	if($j==0)
	{
		$start = 0;
	?>
	$(".tanggal").val('');
	<?
	}
	else
	{
		$start = $j-1;
	}
	?>
	
	var x = <?=$start;?>;
	$(".alternativeRow").btnAddRow({oddRowCSS:"oddRow",evenRowCSS:"evenRow",rowNumColumn: 'no'},function(barisBaru){
		x++;
		$(barisBaru).find(".tanggal").attr("id","tanggal_"+x);
		$(barisBaru).find(".jam").attr("id","jam_"+x);
		$(barisBaru).find(".jenis").attr("id","jenis_"+x);
		$(barisBaru).find(".dosis").attr("id","dosis_"+x);
		$(barisBaru).find(".gula").attr("id","gula_"+x);
		$(barisBaru).find(".reduksi").attr("id","reduksi_"+x);
		$(barisBaru).find(".ket").attr("id","ket_"+x);
		$(barisBaru).find(".nama").attr("id","nama_"+x);
		
		$(barisBaru).find(".hasDatepicker").removeClass('hasDatepicker');
		$(barisBaru).find(".tanggal").datepicker
		({
			changeMonth: true,
			changeYear: true,
			//showOn: "button",
			//buttonImage: "../../images/cal.gif",
			//buttonImageOnly: true
		});
		$(barisBaru).find(".hasTimeEntry").removeClass('hasTimeEntry');
		$(barisBaru).find(".jam").timeEntry({show24Hours: true, showSeconds: true});
		
		
	});
	
	
	//$(".jam_ct").timeEntry({show24Hours: true, showSeconds: false});
	$(".tanggal").datepicker({
		changeMonth: true,
		changeYear: true,
		//showOn: "button",
		//buttonImage: "../../images/cal.gif",
		//buttonImageOnly: true
	});
	
	$(".delRow").btnDelRow();
	
});


	

</script>
</head>
<style>
body{background:#FFF;
}
table{
font:12px tahoma;
}
.ui-datepicker{
font:12px Arial, Helvetica, sans-serif;
}
input[type=text]{
border:1px solid #6699CC;
padding:2px;
font:12px tahoma;
border-radius:3px;
}
</style>
<body>
<table width="1080" border="0" align="center">
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td align="left"><div style="font:bold 18px tahoma;" align="left">Rumah Sakit Pelindo I Kota Medan </div></td>
    <td align="right"><div style="width:200px; padding:20px 50px; border:1px solid #000000; font:bold 18px tahoma;" align="center">Terapi Insulin</div></td>
  </tr>
</table>
<br />
<div style="width:1100px;; margin:auto; border:1px solid #336699; border-radius:5px; background: #E6F1FF">
<table width="1080" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
    <td>
	<input type="hidden" name="id_kunjungan" id="id_kunjungan" size="5" value="<?=$_REQUEST['idKunj'];?>" />
    <input type="hidden" name="id_pelayanan" id="id_pelayanan" size="5" value="<?=$_REQUEST['idPel'];?>" />
	<input type="hidden" name="list_hapus" id="list_hapus" />
	</td>
  </tr>
  <tr>
    <td width="119"><b>Nama Pasien</b> </td>
    <td width="871">:
      <?=$nama;?></td>
  </tr>
  <tr>
    <td><b>Dokter (DPJP)</b> </td>
    <td>: <?=$dokter;?></td>
  </tr>
</table>
<br />
<form id="form_terapi" method="post" action="terapi_insulin_act.php">
<div id="datax">
<table width="1086" border="1" bordercolor="#336699" align="center" style="border-collapse:collapse;">
  <tr align="center" style="background:#6699CC; color:#FFFFFF;">
    <td width="108" height="22">TANGGAL</td>
    <td width="203">JAM</td>
    <td width="75">JENIS INSULIN </td>
    <td width="120">DOSIS</td>
    <td width="120">GULA DARAH </td>
    <td width="120">REDUKSI</td>
    <td width="120">KET</td>
    <td width="120">NAMA &amp; TT  </td>
    <td width="42"> <img src="add3.png" width="25" height="25" class="alternativeRow" value="Add" style="cursor:pointer; padding:2px 3px;"/></td>
  </tr>
	<?
		if($j==0)
		{
	?>
  <tr align="center">
    <td><input type="text" name="tanggal[]" class="tanggal" id="tanggal_0" size="10" /></td>
    <td><input type="text" name="jam[]" class="jam" id="jam_0" size="8" align="left" /> </td>
    <td><input type="text" name="jenis[]" class="jenis" id="jenis_0" size="15" /></td>
    <td><input type="text" name="dosis[]" class="dosis" id="dosis_0" size="15"/></td>
    <td><input type="text" name="gula[]" class="gula" id="gula_0" /></td>
    <td><input type="text" name="reduksi[]" class="reduksi" id="reduksi_0" /></td>
    <td><input type="text" name="ket[]" class="ket" id="ket_0" /></td>
    <td><input type="text" name="nama[]" class="nama" id="nama_0" /></td>
    <td><img src="hapus.png" width="20" height="20" class="delRow" border="0" style="cursor:pointer;"></td>
  </tr>
	<?
		}
		else
		{
		  $urutan = 0;
		  while($d = mysql_fetch_array($s))
		  {
	?>
	<tr align="center">
    <td>
	<input type="text" name="id[]" id="id_<?=$urutan;?>" class="id" size="5"  style="font:10px Verdana, Arial, Helvetica, sans-serif;" value="<?=$d['id'];?>"/>
	<input type="text" name="user_act[]" id="user_act_<?=$urutan;?>" class="user_act" size="5"  style="font:10px Verdana, Arial, Helvetica, sans-serif;" value="<?=$d['user_act'];?>"/>
	<input type="text" name="tanggal[]" class="tanggal" id="tanggal_<?=$urutan;?>" size="10" /></td>
    <td><input type="text" name="jam[]" class="jam" id="jam_<?=$urutan;?>" size="8" align="left" /> </td>
    <td><input type="text" name="jenis[]" class="jenis" id="jenis_<?=$urutan;?>" size="15" /></td>
    <td><input type="text" name="dosis[]" class="dosis" id="dosis_<?=$urutan;?>" size="15"/></td>
    <td><input type="text" name="gula[]" class="gula" id="gula_<?=$urutan;?>" /></td>
    <td><input type="text" name="reduksi[]" class="reduksi" id="reduksi_<?=$urutan;?>" /></td>
    <td><input type="text" name="ket[]" class="ket" id="ket_<?=$urutan;?>" /></td>
    <td><input type="text" name="nama[]" class="nama" id="nama_<?=$urutan;?>" /></td>
    <td><img src="hapus.png" width="20" height="20" class="delRow" border="0" style="cursor:pointer;"></td>
  </tr>
   <?
	 	$urutan++;
	 	}
	 }
	 ?>
</table>
</div>
</form>
<br />
<table width="1080" border="0" align="center">
  <tr align="center">
    <td>
	<input type="button" name="simpan" id="simpan" value="Simpan" onclick="proses()" style="border:1px solid #336699; cursor:pointer; background:#6699CC; padding:3px; color:#FFFFFF; border-radius:3px;" />
	&nbsp;
	<input type="button" name="batal" id="batal" value="Batal" onclick="batal()" style="border:1px solid #336699; cursor:pointer; background:#6699CC; padding:3px; color:#FFFFFF; border-radius:3px;" />
	</td>
  </tr>
</table>
</div>
<p>&nbsp;</p>
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
	$("#form_terapi").ajaxSubmit
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