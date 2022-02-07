<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Surat Balasan</title>
</head>
<?
//session_start();
include "../../koneksi/konek.php";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUser'];
/*$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,IFNULL(pg.nama,'-') AS dr_rujuk
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.dokter_id
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));*/
include "setting.php";
?>
<style>
.gb{
	border-bottom:1px solid #000000;
}
textarea{
font:12px tahoma;
width:100%;
height:100%;
}
input[type='text']{
font:12px tahoma;
}
</style>
<link rel="stylesheet" type="text/css" href="../CRUD_Form_RSUD/setting.css" />
<link type="text/css" rel="stylesheet" href="../../theme/mod.css">
<script src="../CRUD_Form_RSUD/js/jquery-1.8.3.js"></script>
<script src="../CRUD_Form_RSUD/js/jquery.form.js"></script>
<script language="JavaScript" src="../../theme/js/mod.js"></script>
<script language="JavaScript" src="../../theme/js/dsgrid.js"></script>
<script language="JavaScript" src="../../unit_pelayanan/iframe.js"></script>
<body id="body">
<div id="formx" style="margin:auto; width:1000px; display:none;">
<form id="from_balasan" method="post" action="3.suratbalasan_act.php">
<div align="center">
<table width="766" border="0" style="font:12px tahoma;">
  <tr>
    <td width="760" style="font:bold 15px tahoma;">SURAT BALASAN
    <div id="load1"></div>
    </td>
  </tr>
  <tr>
    <td style="font:bold 15px tahoma;">REFERRAL REPLAY</td>
  </tr>
  <tr>
    <td><table cellspacing="0" cellpadding="2" style="border:1px solid #000000;">
      <col width="27" />
      <col width="64" />
      <col width="20" />
      <col width="138" />
      <col width="20" />
      <col width="64" />
      <col width="51" />
      <col width="99" />
      <col width="13" />
      <col width="92" />
      <col width="49" />
      <col width="58" />
      <col width="54" />
      <col width="37" />
      <tr height="20">
        <td height="20" width="27">&nbsp;</td>
        <td width="64"></td>
        <td width="20"></td>
        <td width="138">
        <input type="hidden" name="id" id="id" size="5" />
		<input type="hidden" name="act" id="act" size="5" />
        <input type="hidden" name="kunjungan_id" id="kunjungan_id" size="5" value="<?php echo $_REQUEST['idKunj']; ?>" />
	<input type="hidden" name="pelayanan_id" id="pelayanan_id" size="5" value="<?php echo $_REQUEST['idPel']; ?>" />
    <input type="hidden" name="idUsr" id="idUsr" size="5" value="<?php echo $_REQUEST['idUser']; ?>" /></td>
        <td width="20"></td>
        <td width="64"></td>
        <td width="51"></td>
        <td width="99"></td>
        <td width="13"></td>
        <td width="92"></td>
        <td width="49"></td>
        <td width="58"></td>
        <td width="54"></td>
        <td width="37"></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>Kepada&nbsp;</td>
        <td></td>
        <td></td>
        <td>:</td>
        <td colspan="5" class="gb"><span id="kpd"><?=$dr_rujuk?></span></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>To</td>
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
      <tr height="20">
        <td height="20">&nbsp;</td>
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
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>Dari</td>
        <td></td>
        <td></td>
        <td>:</td>
        <td colspan="5" class="gb"><span id="dr"><?
		if($dokter=="-")
		{
			echo $namaUser;
		}else{
			echo $dokter;
		}
		?></span></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>From</td>
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
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="7">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="7">Dengan hormat, </td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="9">Sesuai  permohonan konsultasi, pada kasus ini dijumpai</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
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
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="3">Pemeriksaan</td>
        <td>:</td>
        <td colspan="8" rowspan="3" valign="top"><textarea name="pemeriksaan" id="pemeriksaan" /></textarea></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="3">Examination</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
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
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="3" rowspan="2">Diagnosa<br/>Diagnosis</td>
        <td rowspan="2" valign="top">:</td>
        <td colspan="8" rowspan="2" style="margin:0; padding:0;" valign="top" ><table width="100%" border="0">
        <?php $sqlD="SELECT md.nama FROM b_diagnosa d
LEFT JOIN b_ms_diagnosa md ON md.id=d.ms_diagnosa_id
LEFT JOIN b_kunjungan k ON k.id=d.kunjungan_id
WHERE k.id ='$idKunj' and md.nama is not null;";
$exD=mysql_query($sqlD);
while($dD=mysql_fetch_array($exD)){
?>
          <tr>
            <td class="gb"><?=$dD['nama']?></td>
          </tr>
        <?php }?>  
          <!--<tr>
            <td class="gb">&nbsp;</td>
          </tr>-->
        </table>
        <table width="100%" border="0">
        <?php $sqlD="SELECT d.diagnosa_manual FROM b_diagnosa d
LEFT JOIN b_kunjungan k ON k.id=d.kunjungan_id
WHERE k.id ='$idKunj' and d.diagnosa_manual is not null;";
$exD=mysql_query($sqlD);
while($dD=mysql_fetch_array($exD)){
?>
          <tr>
            <td class="gb"><?=$dD['diagnosa_manual']?></td>
          </tr>
        <?php }?>  
          <tr>
            <td class="gb">&nbsp;</td>
          </tr>
        </table>
        </td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
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
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="3">Saran Terapi</td>
        <td>:</td>
        <td colspan="8" rowspan="3" valign="top"><textarea name="terapi" id="terapi" /></textarea></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="3">Adviced Therapy</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
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
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="3" rowspan="2">Tindakan khusus<br/>Special Procedure</td>
        <td rowspan="2" valign="top">:</td>
        <td colspan="8" rowspan="2" style="margin:0; padding:0;" valign="top">
        <div id="load_tin">
        <table width="100%" border="0">
        <?php $sqlT="select * from
        (SELECT t.id, t.qty, t.biaya, t.qty * t.biaya as subtotal, t.kunjungan_id, t.ms_tindakan_kelas_id, t.pelayanan_id, t.ket, t.unit_act, tk.tarip, tin.nama
        , tin.kode,ifnull(p.nama,'-') as dokter,t.ms_tindakan_unit_id,t.user_id,k.nama as kelas, t.type_dokter,t.tgl_act as tanggal, tin.klasifikasi_id, peg.nama AS petugas
	FROM b_tindakan t
	INNER JOIN b_pelayanan pl ON pl.id = t.pelayanan_id
	INNER JOIN b_ms_tindakan_kelas tk ON tk.id = t.ms_tindakan_kelas_id
	INNER JOIN b_ms_kelas k ON tk.ms_kelas_id=k.id
	INNER JOIN b_ms_tindakan tin ON tin.id = tk.ms_tindakan_id
	LEFT JOIN b_ms_pegawai p ON p.id=t.user_id
	LEFT JOIN b_ms_pegawai peg ON peg.id=t.user_act
	WHERE t.pelayanan_id = '".$idPel."') as gab";
$exT=mysql_query($sqlT);
while($dT=mysql_fetch_array($exT)){
?>
          <tr>
            <td class="gb"><?=$dT['nama']?></td>
          </tr>
        <?php }?>  
          <tr>
            <td class="gb">&nbsp;</td>
          </tr>
        </table>
        </div></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
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
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="3">Terimakasih kerjasamanya</td>
        <td>&nbsp;</td>
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
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="3">Thank you for your    cooperation</td>
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

      <tr height="20">
        <td height="20">&nbsp;</td>
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
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>Tanggal/Date</td>
        <td>:</td>
        <td colspan="4" class="gb"><?php echo tgl_ina(date("Y-m-d"))?></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>Jam/Time</td>
        <td>:</td>
        <td colspan="4" class="gb"><?=date('h:i:s');?></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="6"><div align="center">Dokter yang merawat,</div></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="6"><div align="center">Attending Doctor,</div></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
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
      <tr height="20">
        <td height="20">&nbsp;</td>
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
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="6" align="center">
          (<u><b><span class="gb1"><? 
		  	//$dokter
			if($dokter=="-")
			{
				echo $namaUser;
			}else{
				echo $dokter;
			}
		  ?></span></b></u>)
        </td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="6"><div align="center">(Nama dan Tanda tangan)</div></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="6"><div align="center">Name and signature</div></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
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
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
  <td align="center">
  <button type="button" onclick="proses()">Simpan</button>
	<button type="button" onclick="hide_form()">Batal</button></td>
  </tr>
</table></div>
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
	a.loadURL("3.suratbalasan_util.php?pelayanan_id=<?php echo $_REQUEST['idPel']; ?>&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
}

var a=new DSGridObject("gridbox");
	a.setHeader("SURAT BALASAN");
	a.setColHeader("NO,KEPADA,DARI,PEMERIKSAAN,DIAGNOSA,TERAPI,TINDAKAN,PENGGUNA");
	a.setIDColHeader(",dr_rujuk,dokter,pemeriksaan,diag,terapi,tindakan,");
	a.setColWidth("50,100,100,120,120,120,120,100");
	a.setCellAlign("center,left,left,left,left,left,left,left");
	a.setCellHeight(20);
	a.setImgPath("../../icon");
	a.setIDPaging("paging");
	a.attachEvent("onRowClick","ambilData");
	a.baseURL("3.suratbalasan_util.php?pelayanan_id=<?php echo $_REQUEST['idPel']; ?>");
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
		//toggle();	
	});
	//$('#gridx').slideUp(500);
}
function hide_form()
{
	//$('#gridx').slideDown(500);
	$('#formx').slideUp(500,function(){
		//toggle();	
	});
}
function tambah()
{
	clear_text('id,act,pemeriksaan,terapi');
	show_form();
	$('#act').val('tambah');
	jQuery("#load_tin").load("show_tindakan.php?idPel=<?=$idPel?>&tipe=2&idKunj=<?=$_REQUEST['idKunj']?>");
	jQuery("#load1").load("update_in_out.php?idPel=<?=$idPel?>&idKunj=<?=$_REQUEST['idKunj']?>");
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
			//alert(idPilih1);
			if (typeof idPilih1 == "undefined")
			{
				alert("pilih data terlebih dahulu");
				return false;
			}
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
				window.open('3.suratbalasan_view.php?idPel='+idPilih1+'&idKunj=<?=$idKunj?>&idUser=<?=$idUser?>&idPasien=<?=$idPasien?>&id='+rowid,"_blank");
		//		document.getElementById('id').value="";
//			}
			//idKunj=11&idPel=20&idUser=732&inap=1&kelas_id=3
		}
function proses()
{
	var act = $('#act').val();
	$("#from_balasan").ajaxSubmit
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
var idPilih1;
function ambilData()
{
	var id = a.getRowId(a.getSelRow()).split("|"); //alert(id)
	var pemeriksaan = a.cellsGetValue(a.getSelRow(),4);
	var terapi = a.cellsGetValue(a.getSelRow(),6);
	jQuery("#load1").load("update_in_out.php?idPel="+id[1]+"&idKunj=<?=$_REQUEST['idKunj']?>");
	jQuery("#load_tin").load("show_tindakan.php?idPel="+id[1]+"&idKunj=<?=$_REQUEST['idKunj']?>");
	//jQuery("#load_tin").html("");
	//alert(id[1]);
	
	idPilih1 = id[1];
	$('#id').val(id[0]);
	$('#pemeriksaan').val(pemeriksaan);
	$('#terapi').val(terapi);
	
}
</script>