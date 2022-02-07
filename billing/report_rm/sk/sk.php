<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Surat Keterangan :.</title>
<link type="text/css" rel="stylesheet" href="../../theme/mod.css">
<link type="text/css" rel="stylesheet" href="js/jquery.timeentry.css">
<script src="js/jquery-1.8.3.js"></script>
<script src="js/jquery.form.js"></script>
<script language="JavaScript" src="../../theme/js/mod.js"></script>
<script language="JavaScript" src="../../theme/js/dsgrid.js"></script>
<script src="../../theme/dhtmlxcalendar.js" type="text/javascript"></script>

<script type="text/javascript" src="js/jquery.timeentry.js"></script>
<script>
var arrRange=depRange=[];
$(function () 
{
	$('#sk_jam_mati').timeEntry({show24Hours: true, showSeconds: true});
	
});
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
		id="gToday:normal:agenda.js"
		src="../../theme/popcjs.php" scrolling="no"
		frameborder="1"
		style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>
<iframe height="72" width="130" name="sort"
		id="sort"
		src="../../theme/dsgrid_sort.php" scrolling="no"
		frameborder="0"
		style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
</head>

<body>
<? 
include "setting.php";?>
<div id="formx" style="margin:auto; margin-bottom:20px; width:800px; display:none;">
<form id="form_sk" method="post" action="sk_act.php">
<table width="790" border="0" style="font:12px Verdana, Arial, Helvetica, sans-serif; border:1px solid #B1DCFE; background: #F4FCFF; padding:10px; margin-top:10px;">
  <tr>
    <td width="132">&nbsp;</td>
    <td width="439">&nbsp;</td>
    <td width="205">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center" style="font:bold 16px Verdana, Arial, Helvetica, sans-serif;">SURAT KETERANGAN </td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">Dengan ini menerangkan bahwa, </td>
    </tr>
  <tr>
    <td>&nbsp;<input type="text" name="id_mati" id="id_mati" size="5" /><input type="text" name="act_mati" id="act_mati" size="5" /></td>
    <td>&nbsp; 
	<input type="hidden" name="id_knjngn_mati" id="id_knjngn_mati" size="5" value="<?=$idKunj;?>" />
	<input type="hidden" name="id_plynn_mati" id="id_plynn_mati" size="5" value="<?=$idPel;?>" />
	</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Nama</td>
    <td>: <span id="nama_simati"><?=$nama;?></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>No.Rekam Medis </td>
    <td>: <span id="no_simati"><?=$noRM;?></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>TTL</td>
    <td>: <span id="ttl_simati"><?=$tgl;?></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Umur</td>
    <td>: <span id="umur_simati"><?=$umur;?></span> Tahun </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Jenis Kelamin </td>
    <td>: <span id="sex_simati"><?=$sex;?></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Alamat</td>
    <td>: <span id="alamat_simati"><?=$alamat;?></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">Tiba di Unit Gawat Darurat Rumah Sakit Pelindo I dalam keadaan sudah meninggal dunia. </td>
    </tr>
  <tr>
    <td>Pada Tanggal </td>
    <td>: <input type="text" name="sk_tgl_mati" id="sk_tgl_mati" size="10" /> <!--<img src="cal.jpg" width="24" height="24" style="display: inline; cursor:pointer" onclick="gfPop.fPopCalendar(document.getElementById('sk_tgl_mati'),depRange);"/>-->
      <input type="button" id="btn_tgl_mati" name="btn_tgl_mati" value=" V " tabindex="28" onclick="gfPop.fPopCalendar(document.getElementById('sk_tgl_mati'),depRange);" style="padding:1px 2px; cursor:pointer;  border:1px solid #999;" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Pukul</td>
    <td>: <label for="sk_jam_mati"></label><input type="text" name="sk_jam_mati" id="sk_jam_mati" size="6"  value="<?=date('H:i:s')?>" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">Demikian Surat Keterangan ini dibuat, dan dipergunakan seperlunya. </td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Medan, <? //echo date('d-m-Y');?>
	<input type="text" name="sk_tgl_periksa" id="sk_tgl_periksa" size="10" value="<? echo date('d-m-Y');?>" /> <!--<img src="cal.jpg" width="24" height="24" style="display: inline; cursor:pointer" onclick="gfPop.fPopCalendar(document.getElementById('sk_tgl_mati'),depRange);"/>-->
    <input type="button" id="btn_tgl_periksa" name="btn_tgl_periksa" value=" V " tabindex="28" onclick="gfPop.fPopCalendar(document.getElementById('sk_tgl_periksa'),depRange);" style="padding:1px 2px; cursor:pointer;  border:1px solid #999;" />
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Dokter Pemeriksa, </td>
  </tr>
  <tr>
    <td height="83">&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="bottom"><u><?=$namaUser;?></u><input type="hidden" name="idUsr_mati" id="idUsr_mati" size="5" value="<?=$idUser;?>" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(Nama Jelas)</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">Lembar 1 : Keluarga Pasien </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">Lembar 2 : Medical Record </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center">
	<div id="btn_mati_no_print">
	<input type="button" name="button_mati_save" id="button_mati_save" class="tblTambah" value="Simpan" onclick="proses()" style="border:1px solid #999999; cursor:pointer;" />&nbsp;
  	<input type="button" name="button_mati_batal" id="button_mati_batal" value="Batal" onclick="hide_form()" class="tblBatal" style="border:1px solid #999999; cursor:pointer;"/>
	</div>
	</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
</div>

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
	<div class="TabView" id="gridbox" style="width: 900px; height: 350px;"></div>
	<div id="paging" style="width:900px;"></div>
	</td>
  </tr>
</table>
</div>
</body>
</html>
<script>
var row;
var a=new DSGridObject("gridbox");
	a.setHeader("SURAT KETERANGAN");
	a.setColHeader("NO,NAMA,NO.RM,TTL,UMUR(THN),TGL MENINGGAL,JAM MENINGGAL,TGL PERIKSA,DOKTER PEMERIKSA");
	a.setIDColHeader(",nama,no_rm,,,tgl_mati,jam_mati,tgl_periksa,pemeriksa");
	a.setColWidth("50,200,100,150,50,100,100,100,100");
	a.setCellAlign("center,left,left,center,center,center,center,center,left");
	a.setCellHeight(20);
	a.setImgPath("../../icon");
	a.setIDPaging("paging");
	a.onLoaded(cek_row);
	a.attachEvent("onRowClick","ambilData");
	a.baseURL("sk_util.php?user_act="+$("#idUsr_mati").val());
	//a.baseURL("../../billing/master/wilayah_utils.php?grd=true");
	a.Init();

function goFilterAndSort()
{
	//alert("tmpt_layanan_utils.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
	a.loadURL("sk_util.php?user_act="+$("#idUsr_mati").val()+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
}
function cek_row()
{
	row = a.getRowId(a.getSelRow());
}
function ambilData()
{
	var erei = a.getRowId(a.getSelRow());
	var data = erei.split('|');
	$('#id_mati').val(data[0]);
	$('#sk_tgl_mati').val(data[1]);
	$('#sk_jam_mati').val(data[2]);
	$('#sk_tgl_periksa').val(data[3]);
}
function show_form()
{
	$('#formx').slideDown(500);
	$('#gridx').slideUp(500);
}
function hide_form()
{
	$('#gridx').slideDown(500);
	$('#formx').slideUp(500);
}
function tambah()
{
	if(row!="")
	{
		alert('Data pasien tsb sudah diinput');
	}
	else
	{
		clear_text('id_mati,sk_tgl_mati,sk_jam_mati,sk_tgl_periksa');
		$('#sk_tgl_periksa').val('<?=date('d-m-Y');?>');
		//clear_check('istirahat_chk,ijin_chk,cuti_chk,rawat_chk');
		show_form();
		$('#act_mati').val('tambah');
	}
}
function edit()
{
	var id = $('#id_mati').val();
	if(id=='')
	{
		alert('Pilih data yang akan edit');
	}
	else
	{
		show_form();
		$('#act_mati').val('edit');
	}
}
function hapus()
{
	var id = $('#id_mati').val();
	if(id=='')
	{
		alert('Pilih data yang akan dihapus');
	}
	else
	{
		if(confirm('Yakin menghapus data tersebut?'))
		{
			$('#act_mati').val('hapus');
			proses();
		}
	}
}
function proses()
{
	var act = $('#act_mati').val();
	$("#form_sk").ajaxSubmit
	({
	  //target: "#pesan",
	  success:function(msg)
		{
			alert(msg);
			if(msg=='sukses')
			{
				goFilterAndSort("gridbox");
				alert('Data sukses di '+act);
				hide_form();
			}
			else
			{
				alert('Data gagal di '+act);
				hide_form();
			}
		},
	  //resetForm:true
	});
	return false;
}
function clear_text(textfield)
{
	var data = textfield.split(",");
	var jum = textfield.split(",").length;
	var i;
	for(i=0;i<jum;i++)
	{
		$('#'+data[i]).val('');
	}
	
}
function clear_check(textfield)
{
	var data = textfield.split(",");
	var jum = textfield.split(",").length;
	var i;
	for(i=0;i<jum;i++)
	{
		$('#'+data[i]).removeAttr('checked');
	}
	
}
</script>