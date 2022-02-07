<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Travelling Patient Information</title>
</head>

<link rel="stylesheet" type="text/css" href="setting.css" />
<link type="text/css" rel="stylesheet" href="../../theme/mod.css">
<script src="js/jquery-1.8.3.js"></script>
<script src="js/jquery.form.js"></script>
<script language="JavaScript" src="../../theme/js/mod.js"></script>
<script language="JavaScript" src="../../theme/js/dsgrid.js"></script>
<script language="JavaScript" src="../../unit_pelayanan/iframe.js"></script>
<script type="text/JavaScript">
            var arrRange = depRange = [];
        </script>
<?php
	include "setting.php";
?>
<body id="body">
<iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js" src="../../theme/popcjs.php" scrolling="no" frameborder="1"
                style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
        </iframe>
<div id="formx" style="margin:auto; width:1000px; display:none;">
<form id="from_travelling" method="post" action="1.traveling_patient_informasi_act.php">
<table width="832" border="0" align="center" cellpadding="2" cellspacing="2" style="font:12px tahoma;border:1px solid #999999; padding:5px; ">
  <tr>
    <td height="32" colspan="2" style="font:bold 16px tahoma; text-align:center;">TRAVELLING PATIENT INFORMATION</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="340">Name /    Nama</td>
    <td width="482">:
	<input type="hidden" name="id" id="id" />
    <input type="hidden" name="dterapi" id="dterapi" />
	<input type="hidden" name="act" id="act" />
    <input type="hidden" name="nama" id="nama" /><?=$nama?></td>
  </tr>
  <tr>
    <td>Date of Birth / Tgl Lahir</td>
    <td>: 
	<input type="hidden" name="kunjungan_id" id="kunjungan_id" value="<?php echo $_REQUEST['idKunj']; ?>" />
	<input type="hidden" name="pelayanan_id" id="pelayanan_id" value="<?php echo $_REQUEST['idPel']; ?>" />
    <input type="hidden" name="user_id" id="user_id" value="<?php echo $_REQUEST['idUsr']; ?>" />
    <input type="hidden" name="tgl_lahir" id="tgl_lahir" /><?=$lahir?></td>
  </tr>
  <tr>
    <td>Home Address / Alamat </td>
    <td>: 
    <input type="hidden" name="alamat" id="alamat" size="50" /><?=$alamat?></td>
  </tr>
  <tr>
    <td>Diagnosis / Diagnosa</td>
    <td>: 
    <input type="hidden" name="diagnosa" id="diagnosa" value="<?=$diag?>" /><?=$diag?></td>
  </tr>
  <tr>
    <td>Dyalisis Treatment per week / Tindakan HD per Minggu </td>
    <td>: 
    <input type="text" name="tindakan_perminggu" id="tindakan_perminggu" /></td>
  </tr>
  <tr>
    <td>Duration Of Dyalisis / Lamanya HD</td>
    <td>: 
    <input type="text" name="lama_hd" id="lama_hd" /></td>
  </tr>
  <tr>
    <td>Dialisat Concentrate / Cairan Konsentrat</td>
    <td>: 
    <input type="text" name="cairan_konsentrat" id="cairan_konsentrat" /></td>
  </tr>
  <tr>
    <td>Dry Weight / BB Kering</td>
    <td>: 
    <input type="text" name="bb_kering" id="bb_kering" /></td>
  </tr>
  <tr>
    <td>Acces Vascular / Sarana Hubungan Sirkulasi</td>
    <td>: 
    <input type="text" name="sarana_hubungan" id="sarana_hubungan" /></td>
  </tr>
  <tr>
    <td>Average weight Gain Between Treatment / Kenaikan </td>
    <td>: 
    <input type="text" name="kenaikan" id="kenaikan" /></td>
  </tr>
  <tr>
    <td>Average Blood Pressure / Tekanan Darah Rata-Rata </td>
    <td>: Pre/Sebelum : 
      <input type="text" name="tkn_drh_sblm" id="tkn_drh_sblm" size="10" />
    post/sesudah : 
    <input type="text" name="tkn_drh_ssdh" id="tkn_drh_ssdh" size="10" /></td>
  </tr>
  <tr>
    <td>Dyaliser Type / Jenis Dialiser</td>
    <td>: 
    <input type="text" name="jns_dialiser" id="jns_dialiser" /></td>
  </tr>
  <tr>
    <td>Bood flow Pressure / Kecepatan Aliran Darah</td>
    <td>: 
    <input type="text" name="kec_aliran" id="kec_aliran" /></td>
  </tr>
  <tr>
    <td>Heparinitation / Heparinisasi</td>
    <td>: 
    <input type="text" name="heparinasi" id="heparinasi" /></td>
  </tr>
  <tr>
    <td>Loadind dose / Dosis Awal</td>
    <td>: 
    <input type="text" name="dosis_awal" id="dosis_awal" /></td>
  </tr>
  <tr>
    <td>Blood Group / Gol.Darah/ Rhesusu</td>
    <td>: 
    <input type="text" name="rhesusu" id="rhesusu" /></td>
  </tr>
  <tr>
    <td>Blood Tranfusion Result /Tranfusi darah terakhir </td>
    <td>:    
    <input type="text" name="trans_darah_trkhr" id="trans_darah_trkhr" /></td>
  </tr>
  <tr>
    <td>Date of Laboratorium Result / Tgl. Hasil Laboratorium Terakhir </td>
    <td>: 
    <input type="text" name="tgl_hasil_lab" id="tgl_hasil_lab" value="<?=date('d-m-Y')?>" onclick="gfPop.fPopCalendar(document.getElementById('tgl_hasil_lab'),depRange);"/></td>
  </tr>
  <tr>
    <td colspan="2">HB : <input type="text" name="hb" id="hb" style="width:120px"/>
  Ureum pre/post : 
    <input type="text" name="ureum" id="ureum" style="width:120px"/>
    Creatinin pre/post : 
    <input type="text" name="creatinin" id="creatinin" style="width:120px"/>
    Kalium : 
    <input type="text" name="kalium" id="kalium" style="width:120px"/></td>
  </tr>
  <tr>
    <td colspan="2">Phospor : 
    <input type="text" name="phospor" id="phospor" style="width:120px"/>      HbsAg : 
    <input type="text" name="hbsag" id="hbsag" style="width:120px"/> 
    Anti HCV : 
    <input type="text" name="anti_hcv" id="anti_hcv" style="width:120px"/> 
    Anti HIV : 
    <input type="text" name="anti_hiv" id="anti_hiv" style="width:120px"/></td>
  </tr>
  <tr>
    <td>Medication / Terapi Obat-obatan </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  	<td colspan="2"><div id="intable"><table width="850" border="1" align="center" class="tanggal" id="datatable" style="border-collapse:collapse">
    	<tbody id="isiDetil">
          <tr bgcolor="#ababab">
            <td colspan="2" align="right" valign="middle" bgcolor="#0099FF"><input type="button" value="Tambah" onclick="tambahrow()" /></td>
            </tr>
          <tr bgcolor="#0099FF">
            <td align="center" bgcolor="#33CCFF">Terapi</td>
            <td width="18" align="center" bgcolor="#33CCFF">&nbsp;</td>
            </tr>
          <tr>
            <td><input type="text" name="terapi[]" id="terapi0" size="130"></td>
            <td><!--<input type='button' value='Delete' onclick='del(this)' />-->
              <img alt="del" src="../../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onclick="del(this)" /></td>
            </tr>
            </tbody>
          </table></div>
    </td>
  </tr>
  <!--<tr style="display:none">
    <td colspan="2">1. 
      <input type="text" name="terapi1" id="terapi1" size="100" /></td>
    </tr>
  <tr style="display:none">
    <td colspan="2">2. 
      <input type="text" name="terapi2" id="terapi2" size="100" /></td>
    </tr>
  <tr style="display:none">
    <td colspan="2">3. 
      <input type="text" name="terapi3" id="terapi3" size="100" /></td>
    </tr>
  <tr style="display:none">
    <td colspan="2">4. 
      <input type="text" name="terapi4" id="terapi4" size="100" /></td>
    </tr>
  <tr style="display:none">
    <td colspan="2">5. 
      <input type="text" name="terapi5" id="terapi5" size="100" /></td>
    </tr>-->
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Problem During Dyalisis / Permasalahan selama HD</td>
    <td>:    
    <input type="text" name="problemduring" id="problemduring" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
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
	a.loadURL("1.traveling_patient_informasi_util.php?pelayanan_id=<?php echo $_REQUEST['idPel']; ?>&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
}

var a=new DSGridObject("gridbox");
	a.setHeader("DATA TRAVELLING PATIENT INFORMATION");
	a.setColHeader("NO,NAMA,TGL LAHIR,ALAMAT,DIAGNOSA,TINDAKAN HD/MINGGU,LAMANYA HD,CAIRAN KONSENTRAT,BB KERING,SARANA HUB SIRKULASI,KENAIKAN BB/TINDAKAN,TEKANAN DARAH RATA2 SBLM,TEKANAN DARAH RATA2 SSDH,DIALISER,KCPTN ALIRAN DARAH,HEPARINISASI,DOSIS AWAL,RHESUSU,TRNFS DRH TRKHR,HASIL LAB TRKHR,HB,UREUM,CREATININ,KALIUM,PHOSPOR,HBSAG,ANTI HCV,ANTI HIV,PROBLEM DURING,PENGGUNA");
	a.setIDColHeader(",nama,lahir,alamat,diag,tindakan_perminggu,lama_hd,cairan_konsentrat,bb_kering,sarana_hubungan,kenaikan,tkn_drh_sblm,tkn_drh_ssdh,jns_dialiser,kec_aliran,heparinasi,dosis_awal,rhesusu,trans_darah_trkhr,tgl_hasil_lab,hb,ureum,creatinin,kalium,phospor,hbsag,anti_hcv,anti_hiv,problemduring,penginput");
	a.setColWidth("50,150,75,125,125,75,75,75,75,75,75,75,75,75,75,75,75,75,75,75,75,75,75,75,75,75,75,75,75,150");
	a.setCellAlign("center,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left");
	a.setCellHeight(20);
	a.setImgPath("../../icon");
	a.setIDPaging("paging");
	a.attachEvent("onRowClick","ambilData");
	a.baseURL("1.traveling_patient_informasi_util.php?pelayanan_id=<?php echo $_REQUEST['idPel']; ?>");
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
	$('#gridx').slideUp(500);
}
function hide_form()
{
	$('#gridx').slideDown(500,function(){
		toggle();
		});
	$('#formx').slideUp(500);
}
function tambah()
{
	clear_text('id,act,tindakan_perminggu,lama_hd,cairan_konsentrat,bb_kering,sarana_hubungan,kenaikan,tkn_drh_sblm,tkn_drh_ssdh,jns_dialiser,kec_aliran,heparinasi,dosis_awal,rhesusu,trans_darah_trkhr,hb,ureum,creatinin,kalium,phospor,hbsag,anti_hcv,anti_hiv');
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
				window.open('1.traveling_patient_informasi_view.php?idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idUser=<?=$idUser?>&idPasien=<?=$idPasien?>&id='+rowid,"_blank");
		//		document.getElementById('id').value="";
//			}
			//idKunj=11&idPel=20&idUser=732&inap=1&kelas_id=3
		}
function proses()
{
	 $("input[id^='terapi']").each(function(){
    	document.getElementById("dterapi").value += $(this).val()+"||";
  	 });
	 
	// alert(document.getElementById("dterapi").value);
  
	var act = $('#act').val();
	$("#from_travelling").ajaxSubmit
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
	//var nama = a.cellsGetValue(a.getSelRow(),2);
	//var tgl_lahir = a.cellsGetValue(a.getSelRow(),3);
	//var alamat = a.cellsGetValue(a.getSelRow(),4);
	//var diagnosa = a.cellsGetValue(a.getSelRow(),5);

$('#intable').load("1.tabel_traveling_patien_informasi.php?type=cek&id="+id);
	
	var tindakan_perminggu = a.cellsGetValue(a.getSelRow(),6);
	var lama_hd = a.cellsGetValue(a.getSelRow(),7);
	var cairan_konsentrat = a.cellsGetValue(a.getSelRow(),8);
	var bb_kering = a.cellsGetValue(a.getSelRow(),9);
	var sarana_hubungan = a.cellsGetValue(a.getSelRow(),10);
	
	var kenaikan = a.cellsGetValue(a.getSelRow(),11);
	var tkn_drh_sblm = a.cellsGetValue(a.getSelRow(),12);
	var tkn_drh_ssdh = a.cellsGetValue(a.getSelRow(),13);
	var jns_dialiser = a.cellsGetValue(a.getSelRow(),14);
	var kec_aliran = a.cellsGetValue(a.getSelRow(),15);
	
	var heparinasi = a.cellsGetValue(a.getSelRow(),16);
	var dosis_awal = a.cellsGetValue(a.getSelRow(),17);
	var rhesusu = a.cellsGetValue(a.getSelRow(),18);
	var trans_darah_trkhr = a.cellsGetValue(a.getSelRow(),19);
	var tgl_hasil_lab = a.cellsGetValue(a.getSelRow(),20);
	
	var hb = a.cellsGetValue(a.getSelRow(),21);
	var ureum = a.cellsGetValue(a.getSelRow(),22);
	var creatinin = a.cellsGetValue(a.getSelRow(),23);
	var kalium = a.cellsGetValue(a.getSelRow(),24);
	var phospor = a.cellsGetValue(a.getSelRow(),25);
	var hbsag = a.cellsGetValue(a.getSelRow(),26);
	
	var anti_hcv = a.cellsGetValue(a.getSelRow(),27);
	var anti_hiv = a.cellsGetValue(a.getSelRow(),28);
	/*var terapi1 = a.cellsGetValue(a.getSelRow(),29);
	var terapi2 = a.cellsGetValue(a.getSelRow(),30);
	var terapi3 = a.cellsGetValue(a.getSelRow(),31);
	
	var terapi4 = a.cellsGetValue(a.getSelRow(),32);
	var terapi5 = a.cellsGetValue(a.getSelRow(),33);*/
	var problemduring = a.cellsGetValue(a.getSelRow(),29);
	
	$('#id').val(id);
	//$('#nama').val(nama);
	//$('#tgl_lahir').val(tgl_lahir);
	//$('#alamat').val(alamat);
	//$('#diagnosa').val(diagnosa);
	
	$('#tindakan_perminggu').val(tindakan_perminggu);
	$('#lama_hd').val(lama_hd);
	$('#cairan_konsentrat').val(cairan_konsentrat);
	$('#bb_kering').val(bb_kering);
	$('#sarana_hubungan').val(sarana_hubungan);
	
	$('#kenaikan').val(kenaikan);
	$('#tkn_drh_sblm').val(tkn_drh_sblm);
	$('#tkn_drh_ssdh').val(tkn_drh_ssdh);
	$('#jns_dialiser').val(jns_dialiser);
	$('#kec_aliran').val(kec_aliran);
	
	$('#heparinasi').val(heparinasi);
	$('#dosis_awal').val(dosis_awal);
	$('#rhesusu').val(rhesusu);
	$('#trans_darah_trkhr').val(trans_darah_trkhr);
	$('#tgl_hasil_lab').val(tgl_hasil_lab);
	
	$('#hb').val(hb);
	$('#ureum').val(ureum);
	$('#creatinin').val(creatinin);
	$('#kalium').val(kalium);
	$('#phospor').val(phospor);
	$('#hbsag').val(hbsag);
	
	$('#anti_hcv').val(anti_hcv);
	$('#anti_hiv').val(anti_hiv);
	/*$('#terapi1').val(terapi1);
	$('#terapi2').val(terapi2);
	$('#terapi3').val(terapi3);
	$('#terapi4').val(terapi4);
	$('#terapi5').val(terapi5);*/
	$('#problemduring').val(problemduring);
}
	function toggle() {
    parent.alertsize(document.body.scrollHeight);
}

function tambahrow(){
	var idx2 = $('#datatable tr').length;
	var idx = idx2-1;
    var x=document.getElementById('datatable').insertRow(idx+1);
    //var td1=x.insertCell(0);
	var td1=x.insertCell(0);
	var td2=x.insertCell(1);
 	
	var idxy = idx-1;
	
	//td1.innerHTML=idx;
	td1.innerHTML="<input type='text' name='terapi[]' id='terapi"+idxy+"' size='130'>";
	td2.innerHTML='<img alt="del" src="../../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onclick=del(this) />';
 
}

function del(elm){
	var idx = $(elm).parents('#datatable tr').prevAll().length;
		//alert(idrow);
	var x=document.getElementById('datatable').deleteRow(idx);
}
</script>