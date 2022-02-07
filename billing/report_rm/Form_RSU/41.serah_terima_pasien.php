<?
//include('../../koneksi/konek.php');
$id_kunjungan=$_REQUEST['idKunj'];
$id_pelayanan=$_REQUEST['idPel'];
$idUser=$_REQUEST['idUser'];
include "setting.php";

$q = "select * from b_form_serahterima where id_kunjungan='$id_kunjungan' and id_pelayanan='$id_pelayanan'"; //echo $q;
$s = mysql_query($q);
$j = mysql_num_rows($s); //echo "$j";
if($j==0)
{
	$start = 0;
}
else
{
	$start = $j-1;
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Formulir Serah Terima Pasien Pindah Ruang</title>
<link type="text/css" rel="stylesheet" href="../../theme/mod.css" />
        <script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../../theme/js/dsgrid.js"></script>

        <!-- untuk ajax-->
        <script type="text/javascript" src="../../theme/js/ajax.js"></script>
        <script type="text/javascript" src="../../jquery.js"></script>
        <script type="text/javascript" src="../../jquery.form.js"></script>
		<script src='js/jquery.table.addrow.js'></script>
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

	//$(".jam_ct").timeEntry({show24Hours: true, showSeconds: false});
	$(".tanggal").datepicker({
		changeMonth: true,
		changeYear: true,
		showOn: "button",
		buttonImage: "../../images/cal.gif",
		buttonImageOnly: true
	});
	
});
</script>
</head>
<style>
body{background:#FFFFFF;
}
div.baris{
font:12px tahoma;
width:1000px;
margin:auto;
margin-bottom:5px;
min-height:50px;
}
.ui-datepicker{
font:12px Arial, Helvetica, sans-serif;
}
.ui-datepicker-trigger{
margin-left: 3px;
margin-top: 0;
position: absolute;
cursor:pointer;
}
input[type=text],select{
border:1px solid #6699CC;
padding:2px 3px;
font:12px tahoma;
border-radius:2px;
}
</style>

<body>
<iframe height="72" width="130" name="sort"
    id="sort"
    src="../../theme/dsgrid_sort.php" scrolling="no"
    frameborder="0"
    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<table width="1010" border="0" align="center" style="font:12px tahoma;">
  <tr>
    <td width="700" style="font:bold 18px tahoma;">Rumah Sakit Pelindo I Kota Medan </td>
    <td width="300"><table width="300" border="0">
      <tr>
        <td width="140">Nama Pasien </td>
        <td width="150">: <?=$nama;?></td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
        </tr>
      <tr>
        <td>No MR </td>
        <td>: <?=$noRM;?></td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2" style="font:bold 14px tahoma;">FORMULIR SERAH TERIMA PASIEN PINDAH RUANG</td>
  </tr>
</table>

<div id="formx" style="width:1000px; margin:auto; border:1px solid #6699CC; padding:5px; border-radius:5px; background:#ECF9FF; display:none;">
<form id="form_serah" method="post" action="41.serah_terima_pasien_act.php">
<div class="baris"><table width="1000" border="0">
  <tr>
    <td width="149">Tanggal rawat </td>
    <td width="192"> : 
      <input type="text" name="tgl_rawat" id="tgl_rawat" class="tanggal textr" size="12" /></td>
    <td width="175">Tanggal Pindah Ruang </td>
    <td width="466">: 
      <input type="text" name="tgl_pindah" id="tgl_pindah" class="tanggal textr" size="12" />
	  <input type="text" name="id_kunjungan" id="id_kunjungan" size="5" style="text-align:right;" value="<?=$_REQUEST['idKunj'];?>" />
	  <input type="text" name="id_pelayanan" id="id_pelayanan" size="5" value="<?=$_REQUEST['idPel'];?>" />
	  <input type="text" name="idx" id="idx" size="5" class="textr" />
	  <input type="text" name="act" id="act" size="5" class="textr" />
	</td>
  </tr>
  <tr>
    <td>Dokter DPJP </td>
    <td>: 
      <!--<input type="text" name="dokter1" id="dokter1" />-->
		<select name="dokter1" id="dokter1">
		<?
		$q = "select id,nama from b_ms_pegawai where pegawai_jenis=8 AND spesialisasi_id<>0 ";
		$s = mysql_query($q);
		while($d = mysql_fetch_array($s))
		{
			echo "<option value='$d[id]'>$d[nama]</option>";
		}
		?>
		</select>
	</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Dokter konsulen </td>
    <td>:
      <!--<input type="text" name="dokter2" id="dokter2" />-->
	  <select name="dokter2" id="dokter2">
		<?
		$q = "select id,nama from b_ms_pegawai where pegawai_jenis=8 AND spesialisasi_id<>0 ";
		$s = mysql_query($q);
		while($d = mysql_fetch_array($s))
		{
			echo "<option value='$d[id]'>$d[nama]</option>";
		}
		?>
		</select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Indikasi Saat Pindah </td>
    <td>: <input type="radio" name="indikasi" id="indikasi1" value="1" class="cek" /> Dengan ijin Dokter</td>
    <td><input type="radio" name="indikasi" id="indikasi2" value="2" class="cek" /> Atas permintaan keluarga</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">Keadaan Umum Pasien Saat Pindah Ruang </td>
    </tr>
  <tr>
    <td>Kesadaran</td>
    <td>: 
      <input type="text" name="kesadaran" id="kesadaran" class="textr" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Diagnosa Medis </td>
    <td>: 
      <input type="text" name="diagnosa" id="diagnosa" class="textr" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Tekanan Darah </td>
    <td>: <input type="text" name="tekanan" id="tekanan" size="15" class="textr" /> 
      MmHg </td>
    <td>Pernafasan</td>
    <td>:
      <input type="text" name="pernafasan" id="pernafasan" size="15" class="textr" />
x/menit </td>
  </tr>
  <tr>
    <td>Nadi</td>
    <td>:
      <input type="text" name="nadi" id="nadi" size="15" class="textr" />
x/menit </td>
    <td>Suhu</td>
    <td>:
      <input type="text" name="suhu" id="suhu" size="15" class="textr" /> &deg; C</td>
  </tr>
  <tr>
    <td>Berat Badan </td>
    <td>:
      <input type="text" name="berat_badan" id="berat_badan" size="15" class="textr" />
Kg </td>
    <td>Tinggi Badan </td>
    <td>:
      <input type="text" name="tinggi_badan" id="tinggi_badan" size="15" class="textr" /> 
      Cm</td>
  </tr>
  
  <tr>
    <td colspan="4">Alat Bantu Yang masih terpasang saat pindah ruang </td>
    </tr>
  <tr>
    <td><input type="checkbox" name="alat0" id="alat0" value="Tidak ada" class="cek" /> Tidak ada</td>
    <td><input type="checkbox" name="alat1" id="alat1" value="NGT" class="cek" /> NGT</td>
    <td><input type="checkbox" name="alat2" id="alat2" value="Karakter" class="cek" /> Karakter</td>
    <td><input type="checkbox" name="alat3" id="alat3" value="Oksigen" class="cek" /> Oksigen</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="alat4" id="alat4" value="ETT" class="cek" /> ETT</td>
    <td colspan="2"><input type="checkbox" name="alat5" id="alat5" value="Lain-lain" class="cek" /> Lain-lain <input type="text" name="alat_bantu_ket" id="alat_bantu_ket" class="textr" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Tindakan Operasi </td>
    <td>: <input type="radio" name="tindakan_operasi" id="tindakan_operasi1" class="tindakan_operasi cek" value="1" /> Ya </td>
    <td><input type="radio" name="tindakan_operasi" id="tindakan_operasi0" class="tindakan_operasi cek" value="0" /> Tidak </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">Kemampuan Mobilisasi pasien saat pindah </td>
    <td><input type="checkbox" name="kemampuan0" id="kemampuan0" value="Bedrest" class="cek" /> Bedrest</td>
    <td><input type="checkbox" name="kemampuan1" id="kemampuan1" value="Kursi Roda" class="cek" /> Kursi Roda</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="checkbox" name="kemampuan2" id="kemampuan2" value="Tongkat" class="cek" /> Tongkat</td>
    <td><input type="checkbox" name="kemampuan3" id="kemampuan3" value="Lain-lain" class="cek" /> Lain-lain <input type="text" name="kemampuan_ket" id="kemampuan_ket" class="textr" /></td>
  </tr>
  <tr>
    <td>Tingkat ketergantungan </td>
    <td><input type="checkbox" name="tingkat0" id="tingkat0" value="Selfcare" class="cek" /> Selfcare </td>
    <td><input type="checkbox" name="tingkat1" id="tingkat1" value="PartialCare" class="cek" /> PartialCare </td>
    <td><input type="checkbox" name="tingkat2" id="tingkat2" value="TotalCare" class="cek" />TotalCare </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">Obat-obatan yang masih dlanjutkan </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
<div class="baris" id="tabel1">
<? include "41.serah_terima_pasien_tabel1.php";?>
</div>
<div class="baris">
<table width="1000" border="0">
  <tr>
    <td width="152">&nbsp;</td>
    <td width="281">&nbsp;</td>
    <td width="196">&nbsp;</td>
    <td width="353">&nbsp;</td>
  </tr>
  <tr>
    <td>Berkas Yang disertakan </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="radiologi" id="radiologi" value="Radiologi" class="cek" /> Radiologi</td>
    <td>: <input type="checkbox" name="thorax" id="thorax" value="Thorax" class="cek" />Thorax, &nbsp;&nbsp;Jml <input type="text" name="thorax_jum" id="thorax_jum" size="5" class="textr" /> Lembar</td>
    <td>Diagnostik</td>
    <td><input type="checkbox" name="echo" id="echo" value="Echo" class="cek" /> Echo, Jml <input type="text" name="echo_jum" id="echo_jum" size="5" class="textr" /> Lembar</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp; <input type="checkbox" name="ct" id="ct" value="CT Scan" class="cek" /> CT Scan, Jml <input type="text" name="ct_jum" id="ct_jum" size="5" class="textr" /> Lembar</td>
    <td>&nbsp;</td>
    <td><input type="checkbox" name="eeg" id="eeg" value="EEG" class="cek" /> EEG, &nbsp; Jml <input type="text" name="eeg_jum" id="eeg_jum" size="5" class="textr" />
        Lembar </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp; <input type="checkbox" name="lain" id="lain" value="Lain-lain" class="cek" /> Lain-lain  <input type="text" name="lain_ket" id="lain_ket" class="textr" /></td>
    <td>&nbsp;</td>
    <td><input type="checkbox" name="usg" id="usg" value="USG" class="cek" /> USG, &nbsp;Jml  <input type="text" name="usg_jum" id="usg_jum" size="5" class="textr" /> Lembar </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="lab" id="lab" value="Laboratorium"  class="cek"/> Laboratorium </td>
    <td>: Jml <input type="text" name="lab_jum" id="lab_jum" size="5" class="textr" />
Lembar</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">Barang pribadi milik pasien yang disertakan </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="barang0" id="barang0" value="Gigi palsu" class="cek" /> Gigi palsu </td>
    <td><input type="checkbox" name="barang1" id="barang1" value="Lain-lain" class="cek" /> Lain-lain </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">Tanda bukti pasien pindah ruang </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="tanda0" id="tanda0" value="Ada" class="cek" /> Ada</td>
    <td><input type="checkbox" name="tanda1" id="tanda1" value="Tidak ada" class="cek" /> Tidak Ada</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><input type="checkbox" name="tanda2" id="tanda2" value="Lain-lain" class="cek" /> Lain-lain  <input type="text" name="tanda_bukti_ket" id="tanda_bukti_ket" class="textr" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">Catatan Khusus / rencana tindakan kep. </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

</div>
<div class="baris" id="tabel2">
<? include "41.serah_terima_pasien_tabel2.php";?>
</div>
<div class="baris">
<table width="1000" border="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="308">&nbsp;</td>
    <td width="380">&nbsp;</td>
    <td width="298" align="center">Medan, <?=date("d-m-Y");?></td>
  </tr>
  <tr align="center">
    <td>Perawat yang menerima </td>
    <td>PJ Shift </td>
    <td>Perawat yang meyerahkan, </td>
  </tr>
  <tr>
    <td height="76">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr align="center">
    <td><input type="text" name="perawat_terima" id="perawat_terima" class="textr" /></td>
    <td><input type="text" name="pj_shift" id="pj_shift" class="textr" /></td>
    <td><input type="text" name="perawat_serah" id="perawat_serah" class="textr" /></td>
  </tr>
  <tr align="center">
    <td>Nama &amp; Tanda Tangan </td>
    <td>Nama &amp; Tanda Tangan </td>
    <td>Nama &amp; Tanda Tangan </td>
  </tr>
</table>
</div>


<div style="width:1000px; margin:auto; text-align:center; margin-top:15px;">
<button type="button" onclick="proses()">Simpan</button> 
<button type="button" onclick="batal()">Batal</button>
</div>
</form>
</div>

<div style="width:1000px; margin:auto; text-align:center; margin-top:15px;">
<div id="gridx" style="margin-top:20px;">
<table width="900" border="0" align="center">
  <tr>
    <td align="right">
	<img src="../../images/plus.jpg" width="30" height="30" onclick="tambah()" style="cursor:pointer;" />&nbsp;&nbsp;
	<img src="../../images/edit.jpg" width="30" height="30" onclick="edit()" style="cursor:pointer;" />&nbsp;&nbsp;
	<img src="../../images/del.jpg" width="30" height="30" onclick="hapus()" style="cursor:pointer;" /></td>
  </tr>
  <tr>
    <td>
	<div class="TabView" id="gridbox" style="width: 1000px; height: 350px;"></div>
	<div id="paging" style="width:1000px;"></div>
	</td>
  </tr>
</table>
</div>
</div>
</body>
</html>
<script>
function goFilterAndSort()
{
	//alert("tmpt_layanan_utils.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
	var url = "41.serah_terima_pasien_util.php?id_pelayanan=<?php echo $_REQUEST['idPel']; ?>&id_kunjungan=<?php echo $_REQUEST['idKunj']; ?>&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage();
	a.loadURL(url,"","GET");
}
function ambilData()
{
	var row = a.getRowId(a.getSelRow());
	var data = row.split("|"); //alert(data)
	$("#idx").val(data[0]);
	$("#tgl_rawat").val(data[1]);
	$("#tgl_pindah").val(data[2]);
	
	$("#dokter1").val(data[3]);
	$("#dokter2").val(data[4]);
	
	$("#indikasi"+data[5]).attr('checked', true);
	
	$("#kesadaran").val(data[6]);
	$("#diagnosa").val(data[7]);
	$("#tekanan").val(data[8]);
	$("#pernafasan").val(data[9]);
	$("#nadi").val(data[10]);
	$("#suhu").val(data[11]);
	$("#berat_badan").val(data[12]);
	$("#tinggi_badan").val(data[13]);
	
	var pch = data[14].split(",");
	var x = pch.length;
	for(i=0;i<x;i++)
	{
		var isi = $("#alat"+i).val();
		if(isi=="")
		{
			$("#alat"+i).attr('checked', false);
		}
		else
		{
			$("#alat"+i).attr('checked', true);
		}
	}
	
	$("#alat_bantu_ket").val(data[15]);
	$("#tindakan_operasi"+data[16]).attr('checked', true);
	
	var aa = data[17].split(",");
	var bb = pch.length;
	for(j=0;j<bb;j++)
	{
		var isi = $("#kemampuan"+j).val();
		if(isi=="")
		{
			$("#kemampuan"+j).attr('checked', false);
		}
		else
		{
			$("#kemampuan"+j).attr('checked', true);
		}
	}
	
	$("#kemampuan_ket").val(data[18]);
	
	var cc = data[17].split(",");
	var dd = pch.length;
	for(k=0;k<dd;k++)
	{
		var isi = $("#tingkat"+k).val();
		if(isi=="")
		{
			$("#tingkat"+k).attr('checked', false);
		}
		else
		{
			$("#tingkat"+k).attr('checked', true);
		}
	}
	$("#tabel1").load("41.serah_terima_pasien_tabel1.php?id="+$("#idx").val());
	$("#tabel2").load("41.serah_terima_pasien_tabel2.php?id="+$("#idx").val());
	
}
var a=new DSGridObject("gridbox");
	a.setHeader("DATA SERAH TERIMA PASIEN");
	a.setColHeader("NO,TANGGAL RAWAT,TGL PINDAH,DOKTER DPJP,DOKTER KONSULEN,INDIKASI SAAT PINDAH");
	a.setIDColHeader(",tgl_rawat,tgl_pindah,nama_dokter1,nama_dokter2,indikasi");
	a.setColWidth("50,100,100,200,200,200");
	a.setCellAlign("center,center,left,left,left,left");
	a.setCellHeight(20);
	a.setImgPath("../../icon");
	a.setIDPaging("paging");
	a.attachEvent("onRowClick","ambilData");
	a.baseURL("41.serah_terima_pasien_util.php?id_pelayanan=<?php echo $_REQUEST['idPel']; ?>&id_kunjungan=<?php echo $_REQUEST['idKunj']; ?>");
	//a.baseURL("../../billing/master/wilayah_utils.php?grd=true");
	a.Init();
	
/*function clear_text(textfield)
{
	var data = textfield.split(",");
	var jum = textfield.split(",").length;
	var i;
	for(i=0;i<jum;i++)
	{
		$('#'+data[i]).val('');
	}
	
}*/
function clear_text_new()
{
	$('.textr').val('');
	
}
/*function clear_check(textfield)
{
	var data = textfield.split(",");
	var jum = textfield.split(",").length;
	var i;
	for(i=0;i<jum;i++)
	{
		$('#'+data[i]).removeAttr('checked');
	}
	
}*/
function clear_check_new()
{
	$('.cek').removeAttr('checked');
}
function show_form()
{
	$('#gridx').slideUp(500,function(){
		$('#formx').slideDown(500);
		});
	
}
function hide_form()
{
	$('#formx').slideUp(500,function(){
		$('#gridx').slideDown(500);
		});
	
}
function tambah()
{
	clear_text_new();
	clear_check_new();
	$("#act").val('add');
	$("#tabel1").load("41.serah_terima_pasien_tabel1.php");
	$("#tabel2").load("41.serah_terima_pasien_tabel2.php");
	show_form();
}
function edit()
{
	var idx = $("#idx").val();
	if(idx=="")
	{
		alert('Pilih baris yang akan diedit');
	}
	else
	{
		$("#act").val('edit');
		show_form();
	}
}

function batal()
{
	hide_form();
}

function proses()
{
	//var act = $('#act_mati').val();
	$("#form_serah").ajaxSubmit
	({
	  //target: "#pesan",
	  success:function(msg)
		{
			//alert('');
			goFilterAndSort();
			/*if(msg=='sukses')
			{
				alert('Data sukses disimpan');
				$("#list_hapus").val('');
				//reload_data();
			}
			else
			{
				alert('Data gagal di simpan');
			}*/
		},
	  //resetForm:true
	});
	return false;
}

/*function total(x)
{
	var a = $("#dosis"+x).val();
	var b = $("#jumlah"+x).val();
	var c = a*b;
	$("#obat_sisa"+x).val(c);
	
}*/
</script>