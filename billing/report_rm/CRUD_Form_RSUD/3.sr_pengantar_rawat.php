<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Surat Pengantar Rawat</title>
<link rel="stylesheet" type="text/css" href="setting.css" />
<link type="text/css" rel="stylesheet" href="../../theme/mod.css">
<script src="js/jquery-1.8.3.js"></script>
<script src="js/jquery.form.js"></script>
<script language="JavaScript" src="../../theme/js/mod.js"></script>
<script language="JavaScript" src="../../theme/js/dsgrid.js"></script>
<script language="JavaScript" src="../../unit_pelayanan/iframe.js"></script>
<style>
textarea{
font:12px tahoma;
}
input[type='text']{
font:12px tahoma;
}
</style>
<style type="text/css">
<!--
.style1 {font-size: 36px}
.style3 {font-size: 24px}
-->
</style>
</head>
<?php
	include "setting.php";
?>
<body id="body">
<div id="formx" style="margin:auto; width:1000px; display:none;">
<form id="form_pengantar" method="post" action="3.sr_pengantar_rawat_act.php">
<table width="900" border="0" style="font:12px tahoma">
  <tr>
    <td colspan="8"><table width="900" border="0" style="border-collapse:collapse">
      <tr>
        <td width="526" height="59" rowspan="2"><div align="center"><span class="style1">RS PELINDO I</span> </div></td>
        <td width="52" rowspan="2">&nbsp;</td>
        <td width="307" height="32" style="border-top:1px solid #000000; border-left:1px solid #000000; border-right:1px solid #000000"><div align="center"><span class="style3">SURAT PENGANTAR </span></div></td>
      </tr>
      <tr>
        <td height="35" style="border-bottom:1px solid #000000; border-left:1px solid #000000; border-right:1px solid #000000"><div align="center"><span class="style3">RAWAT</span></div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="7">
	<input type="hidden" name="id" id="id" size="5" />
	<input type="hidden" name="act" id="act" size="5" />
	<input type="hidden" name="kunjungan_id" id="kunjungan_id" value="<?php echo $_REQUEST['idKunj']; ?>" />
	<input type="hidden" name="pelayanan_id" id="pelayanan_id" value="<?php echo $_REQUEST['idPel']; ?>" /></td>
    <td width="1">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="8">Dengan Hormat, </td>
  </tr>
  <tr>
    <td colspan="8">Mohon diberikan perwatan dan atau disiapkan untuk : </td>
  </tr>
  <tr>
    <td width="83">&nbsp;</td>
    <td width="99">&nbsp;</td>
    <td width="59">&nbsp;</td>
    <td width="137">&nbsp;</td>
    <td width="22">&nbsp;</td>
    <td width="260">&nbsp;</td>
    <td width="212">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="right">
      <input type="checkbox" name="perawatan0" id="perawatan0" value="Operasi" />
    </div></td>
    <td>Operasi</td>
    <td><div align="right">
      <input type="checkbox" name="perawatan1" id="perawatan1" value="One Day Care" />
    </div></td>
    <td>One Day Care (ODC) </td>
    <td><div align="right">
      <input type="checkbox" name="perawatan2" id="perawatan2" value="Rawat Inap" />
    </div></td>
    <td>Rawat Inap </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">Nama Pasien </td>
    <td colspan="3">: <?=$nama?></td>
    <td><span style="padding:0px 2px 0px 2px; border:1px #000 solid;"><?php if($sex=='L'){?>&#10004;<?php }else{?>&#10006;<?php }?></span>  Laki - Laki / <span style="padding:0px 2px 0px 2px; border:1px #000 solid;"><?php if($sex=='P'){?>&#10004;<?php }else{?>&#10006;<?php }?></span> Perempuan</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="28">&nbsp;</td>
    <td colspan="2">No. MR </td>
    <td colspan="4"><table width="300" border="0" style="border-collapse:collapse">
  <tr>
	<td height="21">:
	  <?=$noRM?></td>
    </tr>
</table></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Umur</td>
    <td>&nbsp;</td>
    <td>: <?=$umur?> Tahun</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Diagnosis</td>
    <td>&nbsp;</td>
    <td colspan="3"> : <?=$diag?></td>
    <td><input type="checkbox" name="infeksi0" id="infeksi0" value="Infeksi" />
Infeksi &nbsp;&nbsp;
<input type="checkbox" name="infeksi1" id="infeksi1" value="Non infeksi" />
Non infeksi </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">Dokter yang merawat </td>
    <td colspan="4">: <?=$dokter?> </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">Jenis Tindakan/ Operasi  </td>
    <td colspan="4">: <?=$tindakan?> </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">Golongan Tindakan/Operasi </td>
    <td colspan="3">: <?=$klasifikasi?> </td>
    <td><input type="checkbox" name="cito0" id="cito0" value="Cito" />
      Cito &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="checkbox" name="cito1" id="cito1" value="Non Cito" />
Non Cito </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7">Terapi Sementara : </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Diet</td>
    <td colspan="5">: <input type="text" name="diet" id="diet" size="50" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Infus</td>
    <td colspan="5">: 
      <input type="text" name="infus" id="infus" size="50" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Obat</td>
    <td colspan="5">: <textarea name="obat" id="obat" cols="30"></textarea></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7">Persiapan : </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Sedia darah  </td>
    <td colspan="5">: 
      <input type="text" name="sedia_drh" id="sedia_drh" size="50" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Konsul</td>
    <td colspan="5">: 
      <input type="text" name="konsul" id="konsul" size="50" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Lain-lain</td>
    <td colspan="5">: 
      <input type="text" name="lain_lain" id="lain_lain" size="70" /></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">Pemeriksaan yang telah dilakukan </td>
    <td colspan="5">: <textarea name="pemeriksaan" id="pemeriksaan" cols="40"></textarea></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">Ruangan yang dituju: </td>
    <td colspan="5">
	<input type="checkbox" name="ruangan0" id="ruangan0" value="ICU" />ICU &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="checkbox" name="ruangan1" id="ruangan1" value="HCU" />HCU &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="checkbox" name="ruangan2" id="ruangan2" value="NICU" />NICU </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="5">	
	<input type="checkbox" name="ruangan3" id="ruangan3" value="Perina" />
	Perina &nbsp;&nbsp;&nbsp;&nbsp;
	<input type="checkbox" name="ruangan4" id="ruangan4" value="Biasa" />Biasa &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	<input type="checkbox" name="ruangan5" id="ruangan5" value="Isolasi" />Isolasi </td>
</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="5"><input type="checkbox" name="ruangan6" id="ruangan6" value="ODC" />
ODC &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 <input type="checkbox" name="ruangan7" id="ruangan7" value="Lain" />
Lain <input type="text" name="lain_lain_ket" id="lain_lain_ket" size="30" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="7"><table width="900" border="0">
      <tr>
        <td width="240">&nbsp;</td>
        <td width="356">&nbsp;</td>
        <td width="290">Medan, <?php echo tgl_ina(date("Y-m-d"))?> </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><div align="center">Dokter Periksa</div></td>
      </tr>
      <tr>
        <td height="73">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><div align="center">(___________________________)</div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><div align="center">Nama dan Tanda Tangan </div></td>
      </tr>
    </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7">      Beri tanda <img src="centang.png" width="14" height="19" /> pada jawaban yang dipilih </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7"><div align="center">
	<button type="button" onclick="proses()">Simpan</button>
	<button type="button" onclick="hide_form()">Batal</button></div></td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
</div>


<div id="gridx">
<table width="950" border="0" align="center">
  <tr>
    <td align="right">
	<img src="../../icon/printer.png" width="36" height="37" onclick="cetak()" style="cursor:pointer;" />&nbsp;&nbsp;
	<?php
                    if($_REQUEST['report']!=1){
					?><img src="../../images/plus.jpg" width="36" height="37" onclick="tambah()" style="cursor:pointer;" />&nbsp;&nbsp;
	<img src="../../images/edit.jpg" width="39" height="35" onclick="edit()" style="cursor:pointer;" />&nbsp;&nbsp;
	<img src="../../images/del.jpg" width="40" height="36" onclick="hapus()" style="cursor:pointer;" /><?php }?></td>
  </tr>
  <tr>
    <td>
	<div class="TabView" id="gridbox" style="width: 940px; height: 500px;"></div>
	<div id="paging" style="width:925px;"></div>
	</td>
  </tr>
</table>
</div>


</body>
</html>
<script>
function goFilterAndSort()
{
	//alert("tmpt_layanan_utils.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
	a.loadURL("3.sr_pengantar_rawat_util.php?pelayanan_id=<?php echo $_REQUEST['idPel']; ?>&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
}

var a=new DSGridObject("gridbox");
	a.setHeader("SURAT PENGANTAR RAWAT");
	a.setColHeader("NO,PERAWATAN,DIAGNOSIS,GOLONGAN TINDAKAN,DIET,INFUS,OBAT,SEDIA DARAH,KONSUL,LAIN LAIN,PEMERIKSAAN YG DILAKUKAN,RUANGAN YG DITUJU,KETERANGAN");
	a.setIDColHeader(",set_perawatan,set_infeksi,set_cito,diet,infus,obat,sedia_drh,konsul,lain_lain,pemeriksaan,set_ruangan,lain_lain_ket");
	a.setColWidth("50,150,75,125,75,75,75,75,75,75,75,75,100");
	a.setCellAlign("center,left,left,center,center,left,center,left,left,left,left,left,left");
	a.setCellHeight(20);
	a.setImgPath("../../icon");
	a.setIDPaging("paging");
	a.attachEvent("onRowClick","ambilData");
	a.baseURL("3.sr_pengantar_rawat_util.php?pelayanan_id=<?php echo $_REQUEST['idPel']; ?>");
	//a.baseURL("../../billing/master/wilayah_utils.php?grd=true");
	a.Init();

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
function show_form()
{
	$('#formx').slideDown(500,function(){
		toggle();	
	});
	//$('#gridx').slideUp(500);
}
function hide_form()
{
	//$('#gridx').slideDown(500);
	$('#formx').slideUp(500,function(){
		toggle();	
	});
}
function tambah()
{
	clear_text('id,diet,infus,obat,sedia_drh,konsul,lain_lain,pemeriksaan,lain_lain_ket');
	clear_check('perawatan0,perawatan1,perawatan2,infeksi0,infeksi1,cito0,cito1,ruangan0,ruangan1,ruangan2,ruangan3,ruangan4,ruangan5,ruangan6,ruangan7');
	show_form();
	$('#act').val('tambah');
}
function edit()
{
	var id = $('#id').val();
	if(id=='')
	{
		alert('Pilih data yang akan edit');
	}
	else
	{
		show_form();
		$('#act').val('edit');
	}
}
function hapus()
{
	var id = $('#id').val();
	if(id=='')
	{
		alert('Pilih data yang akan dihapus');
	}
	else
	{
		if(confirm('Yakin menghapus data tersebut?'))
		{
			$('#act').val('hapus');
			proses();
		}
	}
	
}
function cetak()
		{
			var rowid = document.getElementById("id").value;
			if(rowid==""){
				var rowidx =a.getRowId(a.getSelRow()).split('|');
				rowid=rowidx[0];
			 }
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			//if(id=='')
//			{
//				alert("Pilih data terlebih dahulu untuk di cetak");
//			}
//			else
//			{	
				window.open('3.sr_pengantar_rawat_view.php?idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idUser=<?=$idUser?>&idPasien=<?=$idPasien?>&id='+rowid,"_blank");
		//		document.getElementById('id').value="";
//			}
			//idKunj=11&idPel=20&idUser=732&inap=1&kelas_id=3
		}
function proses()
{
	var act = $('#act').val();
	$("#form_pengantar").ajaxSubmit
	({
	  //target: "#pesan",
	  success:function(msg)
		{
			//alert(msg);
			/*if(msg=='sukses')
			{*/
				goFilterAndSort("gridbox");
				alert('Data sukses di '+act);
				hide_form();
			/*}
			else
			{
				alert('Data gagal di '+act);
				hide_form();
			}*/
		},
	  //resetForm:true
	});
	return false;
}
function ambilData()
{
	var id = a.getRowId(a.getSelRow()); //alert(id)
	//===================================================
	var set_perawatan = a.cellsGetValue(a.getSelRow(),2);
	var data_per = set_perawatan.split(',');
	var jum_per = set_perawatan.split(',').length; //alert(jum_per);
	var x='';
	for(x=0;x<jum_per;x++)
	{
		//$('#perawatan'+x).val(data_per[x]);
		if(data_per[x]!=''){$('#perawatan'+x).attr('checked','checked')}
	}
	//===================================================
	var set_infeksi = a.cellsGetValue(a.getSelRow(),3);
	var data_inf = set_infeksi.split(',');
	var jum_inf = set_infeksi.split(',').length; //alert(jum_per);
	var y='';
	for(y=0;y<jum_inf;y++)
	{
		//$('#perawatan'+y).val(data_inf[y]);
		if(data_inf[y]!=''){$('#infeksi'+y).attr('checked','checked')}
	}
	//===================================================
	var set_cito = a.cellsGetValue(a.getSelRow(),4);
	var data_cit = set_cito.split(',');
	var jum_cit = set_cito.split(',').length; //alert(jum_per);
	var y='';
	for(y=0;y<jum_cit;y++)
	{
		//$('#perawatan'+y).val(data_cit[y]);
		if(data_cit[y]!=''){$('#cito'+y).attr('checked','checked')}
	}
	//===================================================
	var diet = a.cellsGetValue(a.getSelRow(),5);
	var infus = a.cellsGetValue(a.getSelRow(),6);
	var obat = a.cellsGetValue(a.getSelRow(),7);
	var sedia_drh = a.cellsGetValue(a.getSelRow(),8);
	var konsul = a.cellsGetValue(a.getSelRow(),9);
	var lain_lain = a.cellsGetValue(a.getSelRow(),10);
	
	var pemeriksaan = a.cellsGetValue(a.getSelRow(),11);
	//====================================================
	var set_ruangan = a.cellsGetValue(a.getSelRow(),12);
	var data_ruangan = set_ruangan.split(',');
	var jum_ruangan = set_ruangan.split(',').length; //alert(jum_per);
	var z='';
	for(z=0;z<jum_ruangan;z++)
	{
		//$('#ruangan'+z).val(data_ruangan[z]);
		if(data_ruangan[z]!=''){$('#ruangan'+z).attr('checked','checked')}
	}
	var lain_lain_ket = a.cellsGetValue(a.getSelRow(),13);
	
	
	$('#id').val(id);
	$('#diet').val(diet);
	$('#infus').val(infus);
	$('#obat').val(obat);
	$('#sedia_drh').val(sedia_drh);
	
	$('#konsul').val(konsul);
	$('#lain_lain').val(lain_lain);
	$('#pemeriksaan').val(pemeriksaan);
	$('#lain_lain_ket').val(lain_lain_ket);

	
}
</script>