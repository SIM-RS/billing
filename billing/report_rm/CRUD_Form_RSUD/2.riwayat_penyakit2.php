<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Riwayat Penyakit dan Pemeriksaan</title>
</head>
<style>
textarea{
font:12px tahoma;
}
input[type='text']{
font:12px tahoma;
}
</style>
<link rel="stylesheet" type="text/css" href="setting.css" />
<link type="text/css" rel="stylesheet" href="../../theme/mod.css">
<script src="js/jquery-1.8.3.js"></script>
<script src="js/jquery.form.js"></script>
<script language="JavaScript" src="../../theme/js/mod.js"></script>
<script language="JavaScript" src="../../theme/js/dsgrid.js"></script>
<script language="JavaScript" src="../../unit_pelayanan/iframe.js"></script>
<?php
	include "setting.php";
	$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUsr'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,IFNULL(pg.nama,'-') AS dr_rujuk,
IF(
    p.alamat <> '',
    CONCAT(
      p.alamat,
      ' RT. ',
      p.rt,
      ' RW. ',
      p.rw,
      ' Desa ',
      bw.nama,',',
      ' Kecamatan ',
      wi.nama, ',',' ', wil.nama
    ),
    '-'
  ) AS almt_lengkap,
kk.no_reg as no_reg2,l.saksi as saksi2,a.kesadaran as kesadaran2,a.bb as bb2,a.suhu as suhu2,a.leher as leher2,a.rpd as rpd2, a.ku as ku2,
a.abdomen as abdomen2, a.pulmo as pulmo2, a.cor as cor2, a.kl as kl2
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
LEFT JOIN lap_inform_konsen l ON l.pelayanan_id=pl.id
LEFT JOIN b_kunjungan kk ON kk.id=pl.kunjungan_id
LEFT JOIN b_ms_wilayah bw ON p.desa_id = bw.id 
LEFT JOIN b_ms_wilayah wi ON p.kec_id = wi.id 
LEFT JOIN b_ms_wilayah wil ON wil.id = p.kab_id
LEFT JOIN anamnese a ON a.KUNJ_ID=pl.kunjungan_id
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
?>
<body id="body">
<div id="formx" style="margin:auto; width:1000px; display:block">
<form id="from_riwayat" method="post" action="2.riwayat_penyakit_act.php">
<table width="832" border="0" align="center" cellpadding="2" cellspacing="2" style="font:12px tahoma;border:1px solid #999999; padding:5px; ">
  <tr>
    <td height="32" colspan="2" style="font:bold 16px tahoma; text-align:center;">&nbsp;</td>
  </tr>
  <tr>
    <td height="31" style="font:bold 14px tahoma;">Riwayat Penyakit dan Pemeriksaan Jasmani </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>ANAMNESIS</strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="340">Keluhan Utama </td>
    <td width="482">: 
	<input type="hidden" name="id" id="id" size="5" />
	<input type="hidden" name="act" id="act" size="5" />
	<label>
	<input name="keluhan" type="hidden" id="keluhan" />
	<?=$dP['ku2'];?>
	</label></td>
  </tr>
  <tr>
    <td>Perjalanan Penyakit</td>
    <td>: 
	<input type="hidden" name="kunjungan_id" id="kunjungan_id" size="5" value="<?php echo $_REQUEST['idKunj']; ?>" />
	<input type="hidden" name="pelayanan_id" id="pelayanan_id" size="5" value="<?php echo $_REQUEST['idPel']; ?>" />
    <input type="hidden" name="idUsr" id="idUsr" size="5" value="<?php echo $_REQUEST['idUsr']; ?>" />
    <textarea cols="40" name="perjalanan" id="perjalanan" /></textarea></td>
  </tr>
  <tr>
    <td>Penyakit Lain/Allergi Obat</td>
    <td>: 
    <textarea cols="40" name="penyakit_lain" id="penyakit_lain" /></textarea></td>
  </tr>
  <tr>
    <td>Penyakit-penyakit dahulu</td>
    <td>: 
      <label>
      <input name="penyakit_dahulu" type="hidden" id="penyakit_dahulu" size="40" /><?=$dP['rpd2'];?>
      </label>      </textarea></td>
  </tr>
  <tr>
    <td><strong>Pemeriksaan</strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Keadaan Umum</td>
    <td>: 
    <input type="text" name="keadaan_umum" id="keadaan_umum" size="50" /></td>
  </tr>
  <tr>
    <td>Kesadaran</td>
    <td>: 
    <input type="hidden" name="kesadaran" id="kesadaran" size="50" /><?=$dP['kesadaran2'];?></td>
  </tr>
  <tr>
    <td>BB</td>
    <td>: 
    <input type="hidden" name="bb" id="bb" size="50" /><?=$dP['bb2'];?></td>
  </tr>
  <tr>
    <td>Pernafasan</td>
    <td>: 
    <input type="text" name="pernafasan" id="pernafasan" size="50" /></td>
  </tr>
  <tr>
    <td>Suhu</td>
    <td>: 
    <input type="hidden" name="suhu" id="suhu" size="50" /><?=$dP['suhu2'];?></td>
  </tr>
  <tr>
    <td>Kepala</td>
    <td>: 
      <label>
      <input name="kepala" type="hidden" id="kepala" />
      </label>
      </textarea>
      <?=$dP['kl2'];?></td>
  </tr>
  <tr>
    <td>Mata</td>
    <td>: 
      <textarea cols="40" name="mata" id="mata" /></textarea></td>
  </tr>
  <tr>
    <td>THT</td>
    <td>: 
      <textarea cols="40" name="tht" id="tht" /></textarea></td>
  </tr>
  <tr>
    <td>Gigi mulut </td>
    <td>: 
      <textarea cols="40" name="gigi_mulut" id="gigi_mulut" /></textarea></td>
  </tr>
  <tr>
    <td>Leher</td>
    <td>: 
      <label>
      <input name="leher" type="hidden" id="leher" size="40" /><?=$dP['leher2'];?>
      </label>
      </textarea></td>
  </tr>
  <tr>
    <td>Paru-paru</td>
    <td>: 
      <label>
      <input name="paru_paru" type="hidden" id="paru_paru" />
      </label>
      </textarea>
      <?=$dP['pulmo2'];?></td>
  </tr>
  <tr>
    <td>Jantung</td>
    <td>: 
      <label>
      <input name="jantung" type="hidden" id="jantung" />
      </label>
      </textarea>
      <?=$dP['cor2'];?></td>
  </tr>
  <tr>
    <td>Abdomen</td>
    <td>:    
      <label>
      <input name="abdomen" type="hidden" id="abdomen" /><?=$dP['abdomen2'];?>
      </label>
      </textarea></td>
  </tr>
  <tr>
    <td>Extremitas </td>
    <td>: 
      <textarea cols="40" name="extremitas" id="extremitas" /></textarea></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>DIAGNOSIS KERJA </td>
    <td>:
      <textarea cols="40" name="diagnosis_kerja" id="diagnosis_kerja" /></textarea></td>
  </tr>
  <tr>
    <td>DIAGNOSIS DIFFERENSIAL </td>
    <td>:
      <textarea cols="40" name="diagnosis_diff" id="diagnosis_diff" /></textarea>
      </td>
  </tr>
  <tr>
    <td>PENGOBATAN</td>
    <td>:
      <textarea cols="40" name="pengobatan" id="pengobatan" /></textarea>
      </td>
  </tr>
  <tr>
    <td>DIIT</td>
    <td>:
      <textarea cols="40" name="diit" id="diit" /></textarea>
      </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>PEMERIKSAAN PENUNJANG </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>1. Laboratorium </td>
    <td>:
      <textarea cols="40" name="lab" id="lab" /></textarea>
      </td>
  </tr>
  <tr>
    <td>2. Radiologi </td>
    <td>:
      <textarea cols="40" name="radiologi" id="radiologi" /></textarea>
      </td>
  </tr>
  <tr>
    <td>3. EKG </td>
    <td>:
      <textarea cols="40" name="ekg" id="ekg" /></textarea>
     </td>
  </tr>
  <tr>
    <td>4. Dan Lain-lain </td>
    <td>:
      <textarea cols="40" name="dll" id="dll" /></textarea>
      </textarea>
      </textarea>
      </textarea></td>
  </tr>
  <tr>
    <td colspan="2" align="center">
	<button type="button" onclick="proses()">Simpan</button>
	<button type="button" onclick="hide_form()">Batal</button></td>
    </tr>
</table>
</form>
</div>
<br />
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
	a.loadURL("2.riwayat_penyakit_util.php?pelayanan_id=<?php echo $_REQUEST['idPel']; ?>&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
}

var a=new DSGridObject("gridbox");
	a.setHeader("RIWAYAT PENYAKIT DAN PEMERIKSAAN JASMANI");
	a.setColHeader("NO,PERJALANAN PNYKT,PNYKT LAIN/ALERGI OBAT,KEADAAN UMUM,KESADARAN,BB,PERNAFASAN,SUHU,KEPALA,MATA,THT,GIGI MULUT,LEHER,PARU-PARU,JANTUNG,ABDOMEN,EXTREMITAS,DIAGNOSIS KERJA,DIAGNOSIS DIFFERENSIAL,PENGOBATAN,DIIT,LABORATORIUM,RADIOLOGI,EKG,LAIN LAIN,PENGGUNA");
	a.setIDColHeader(",perjalanan,penyakit_lain,keadaan_umum,kesadaran,bb,pernafasan,suhu,kepala,mata,tht,gigi_mulut,leher,paru_paru,jantung,abdomen,extremitas,diagnosis_kerja,diagnosis_diff,pengobatan,diit,lab,radiologi,ekg,dll,user_log");
	a.setColWidth("50,75,125,75,75,75,75,75,75,75,75,75,75,75,75,75,75,75,75,75,75,75,75,75,75,75,100");
	a.setCellAlign("center,left,center,center,left,center,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left");
	a.setCellHeight(20);
	a.setImgPath("../../icon");
	a.setIDPaging("paging");
	a.attachEvent("onRowClick","ambilData");
	a.baseURL("2.riwayat_penyakit_util.php?pelayanan_id=<?php echo $_REQUEST['idPel']; ?>");
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
	clear_text('id,act,keluhan,perjalanan,penyakit_lain,penyakit_dahulu,keadaan_umum,kesadaran,bb,pernafasan,suhu,kepala,mata,tht,gigi_mulut,leher,paru_paru,jantung,abdomen,extremitas,diagnosis_kerja,diagnosis_diff,pengobatan,diit,lab,radiologi,ekg,dll');
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
				window.open('2.riwayat_penyakit_view.php?idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idUser=<?=$idUser?>&idPasien=<?=$idPasien?>&id='+rowid,"_blank");
		//		document.getElementById('id').value="";
//			}
			//idKunj=11&idPel=20&idUser=732&inap=1&kelas_id=3
		}
function proses()
{
	var act = $('#act').val();
	$("#from_riwayat").ajaxSubmit
	({
	  //target: "#pesan",
	  success:function(msg)
		{
			//alert(msg);
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
function ambilData()
{
	var id = a.getRowId(a.getSelRow()); //alert(id)
	var keluhan = a.cellsGetValue(a.getSelRow(),2);
	var perjalanan = a.cellsGetValue(a.getSelRow(),3);
	var penyakit_lain = a.cellsGetValue(a.getSelRow(),4);
	var penyakit_dahulu = a.cellsGetValue(a.getSelRow(),5);
	
	var keadaan_umum = a.cellsGetValue(a.getSelRow(),6);
	var kesadaran = a.cellsGetValue(a.getSelRow(),7);
	var bb = a.cellsGetValue(a.getSelRow(),8);
	var pernafasan = a.cellsGetValue(a.getSelRow(),9);
	var suhu = a.cellsGetValue(a.getSelRow(),10);
	
	var kepala = a.cellsGetValue(a.getSelRow(),11);
	var mata = a.cellsGetValue(a.getSelRow(),12);
	var tht = a.cellsGetValue(a.getSelRow(),13);
	var gigi_mulut = a.cellsGetValue(a.getSelRow(),14);
	var leher = a.cellsGetValue(a.getSelRow(),15);
	
	var paru_paru = a.cellsGetValue(a.getSelRow(),16);
	var jantung = a.cellsGetValue(a.getSelRow(),17);
	var abdomen = a.cellsGetValue(a.getSelRow(),18);
	var extremitas = a.cellsGetValue(a.getSelRow(),19);
	var diagnosis_kerja = a.cellsGetValue(a.getSelRow(),20);
	
	var diagnosis_diff = a.cellsGetValue(a.getSelRow(),21);
	var pengobatan = a.cellsGetValue(a.getSelRow(),22);
	var diit = a.cellsGetValue(a.getSelRow(),23);
	var lab = a.cellsGetValue(a.getSelRow(),24);
	var radiologi = a.cellsGetValue(a.getSelRow(),25);
	
	var ekg = a.cellsGetValue(a.getSelRow(),26);
	var dll = a.cellsGetValue(a.getSelRow(),27);
	/*var terapi1 = a.cellsGetValue(a.getSelRow(),28);
	var terapi2 = a.cellsGetValue(a.getSelRow(),29);
	var terapi3 = a.cellsGetValue(a.getSelRow(),30);
	
	var terapi4 = a.cellsGetValue(a.getSelRow(),31);
	var terapi5 = a.cellsGetValue(a.getSelRow(),32);*/
	
	$('#id').val(id);
	$('#keluhan').val(keluhan);
	$('#perjalanan').val(perjalanan);
	$('#penyakit_lain').val(penyakit_lain);
	$('#penyakit_dahulu').val(penyakit_dahulu);
	
	$('#keadaan_umum').val(keadaan_umum);
	$('#kesadaran').val(kesadaran);
	$('#bb').val(bb);
	$('#pernafasan').val(pernafasan);
	$('#suhu').val(suhu);
	
	$('#kepala').val(kepala);
	$('#mata').val(mata);
	$('#tht').val(tht);
	$('#gigi_mulut').val(gigi_mulut);
	$('#leher').val(leher);
	
	$('#paru_paru').val(paru_paru);
	$('#jantung').val(jantung);
	$('#abdomen').val(abdomen);
	$('#extremitas').val(extremitas);
	$('#diagnosis_kerja').val(diagnosis_kerja);
	
	$('#diagnosis_diff').val(diagnosis_diff);
	$('#pengobatan').val(pengobatan);
	$('#diit').val(diit);
	$('#lab').val(lab);
	$('#radiologi').val(radiologi);
	
	$('#ekg').val(ekg);
	$('#dll').val(dll);
	/*$('#terapi1').val(terapi1);
	$('#terapi2').val(terapi2);
	$('#terapi3').val(terapi3);
	
	$('#terapi4').val(terapi4);
	$('#terapi5').val(terapi5);*/
	
}
</script>