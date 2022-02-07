<?php
//session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUsr'];
$id=$_REQUEST['id'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,
k.cara_keluar, a.bb as bb2, a.tb as tb2, IFNULL(pg.nama,'-') AS dr_rujuk, a.TENSI as tekanan_darah, a.suhu as suhu2,kk.no_reg as no_reg2
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_pasien_keluar k ON k.pelayanan_id=pl.id
LEFT JOIN anamnese a ON a.KUNJ_ID=pl.kunjungan_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
LEFT JOIN b_kunjungan kk ON kk.id=pl.kunjungan_id
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
$sqlKm="SELECT tk.tgl_in,tk.tgl_out FROM b_tindakan_kamar tk 
LEFT JOIN b_pelayanan p ON p.id=tk.pelayanan_id
WHERE tk.pelayanan_id='$idPel';";
$dK=mysql_fetch_array(mysql_query($sqlKm));
$usr=mysql_fetch_array(mysql_query("select * from b_ms_pegawai where id='$idUsr'"));
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../../theme/mod.css" />
<link type="text/css" rel="stylesheet" href="../js/jquery.timeentry.css" />
<link href="css/Site.css" rel="stylesheet"/>
<link type="text/css" href="jquery/jquery.appendGrid-1.2.0.css" rel="stylesheet" />
<link href="css/jquery-ui-1.10.2.custom.css" rel="stylesheet"/>
<link href="css/shCore.css" rel="stylesheet"/>
<link href="css/shThemeDefault.css" rel="stylesheet"/>
        <script type="text/javascript" language="JavaScript" src="../../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../../theme/js/dsgrid.js"></script>
        <!-- untuk ajax-->
        <script type="text/javascript" src="../../theme/js/ajax.js"></script>
        <script type="text/javascript" src="../../jquery.js"></script>
        <script type="text/javascript" src="../../jquery.form.js"></script>
        <script type="text/javascript" src="../js/jquery.timeentry.js"></script>
        <script type="text/javascript" src="../js/jquery.timeentry.min.js"></script>
        <script src="js/jquery-1.9.1.min.js"></script>

        <script type="text/javascript">

</script>

        <!-- end untuk ajax-->
        <title>PENGKAJIAN KHUSUS PASIEN ANAK</title>
       <style>
        .gb{
	border-bottom:1px solid #000000;
}
.inputan{
	width:80px;
	}
.textArea{ width:97%;}
body{background:#FFF;}
        </style>
<title>resume kep</title><link rel="stylesheet" type="text/css" href="../css/jquery-ui-1.8.4.custom.css" />
<link rel="stylesheet" type="text/css" href="../css/form.css" />
<!--<link rel="stylesheet" type="text/css" href="../include/jquery/jquery-ui-timepicker-addon.css" />
<script src="../js/jquery-1.8.3.js"></script>-->
<script src="../../include/jquery/ui/jquery.ui.core.js"></script>
<script src="../../include/jquery/ui/jquery.ui.widget.js"></script>
<script src="../../include/jquery/ui/jquery.ui.datepicker.js"></script>
<script src="../../include/jquery/jquery-ui-timepicker-addon.js"></script>
<script src="../../include/jquery/external/jquery.bgiframe-2.1.2.js"></script>

<script src="js/jquery-ui-1.10.2.custom.min.js"></script>
<script type="text/javascript" src="jquery/jquery.appendGrid-1.2.0.js"></script>
<script type="text/javascript" src="jquery/jquery.appendGrid-1.2.0.min.js"></script>
<script src="/js/shCore.js"></script>
<script src="/js/shBrushJScript.js"></script>
<script src="/js/shBrushXml.js"></script>
<script src="/js/jquery.validate.min.js"></script>


<?
//include "setting.php";
?>

<script type="text/JavaScript">
            var arrRange = depRange = [];
function tanggalan(){			
	$(function() {
		$( ".tgl" ).datepicker({
			changeMonth: true,
			changeYear: true,
			showOn: "button",
			buttonImage: "../images/cal.gif",
			buttonImageOnly: true
		});	
	});
}

function jam(){			
	$(function () {
	$('.jam').timeEntry({show24Hours: true, showSeconds: true});
});
}
</script>
</head>

<body onload="tanggalan();jam();enable_text(false);enable_text2(false);enable_text3(false);enable_text4(false);enable_text5(false);enable_text6(false);">
<iframe height="72" width="130" name="sort"
                    id="sort"
                    src="../../theme/dsgrid_sort.php" scrolling="no"
                    frameborder="0"
                    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
            </iframe>
             <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js" src="../../theme/popcjs.php" scrolling="no" frameborder="1"
                style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
        </iframe> 
<div id="tampil_input" align="center" style="display:block">
<form name="form1" id="form1" action="pengkajian_khusus_anak_act.php">
<input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    			<input type="hidden" name="id" id="id"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>

<table width="1014" border="0" cellpadding="4" style="font:12px tahoma;">
  <tr>
    <td>&nbsp;</td>
    <td width="575" rowspan="5" align="right" valign="bottom"><table width="496" border="0" align="right" cellpadding="4" bordercolor="#000000" style="border-collapse:collapse; border:1px solid #000000;">
      <tr>
        <td width="124">NRM</td>
        <td width="173">:          
          <?=$dP['no_rm'];?></td>
        <td width="75">&nbsp;</td>
        <td width="104">&nbsp;</td>
        </tr>
      <tr>
        <td>Nama Lengkap</td>
        <td>:          
          <?=$dP['nama'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>Tanggal Lahir</td>
        <td>:          
          <?=tglSQL($dP['tgl_lahir']);?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>Jenis Kelamin</td>
        <td>:          <span <?php if($dP['sex']=='L'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>L</span> / <span <?php if($dP['sex']=='P'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>P</span></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td colspan="4" align="center">(Tempelkan Sticker Identitas Pasien)</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>RS PELINDO I</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">Ruang Rawat / Unit Kerja : 
      <?=$dP['nm_unit'];?>
/
<?=$dP['nm_kls'];?></td>
    </tr>
  <tr>
    <td colspan="3" align="center"><span style="font:bold 15px tahoma;; font-family: tahoma; font-size: 15px">CATATAN PERKEMBANGAN PASIEN TERINTEGRASI</span></td>
  </tr>
  </table>
  
  <table width="1000" style="border:1px solid #000000;">
  <tr>
    <td colspan="31"><table width="994" style="font:12px tahoma;">
      <tr>
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
      <tr>
        <td>&nbsp;</td>
        <td colspan="36">
        <table align="center" id="tblAppendGrid"></table>
        </td>
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
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td width="11">&nbsp;</td>
        <td width="17">&nbsp;</td>
        <td width="38">&nbsp;</td>
        <td width="22">&nbsp;</td>
        <td width="22">&nbsp;</td>
        <td width="15">&nbsp;</td>
        <td width="29">&nbsp;</td>
        <td width="22">&nbsp;</td>
        <td width="22">&nbsp;</td>
        <td width="22">&nbsp;</td>
        <td width="22">&nbsp;</td>
        <td width="12">&nbsp;</td>
        <td width="32">&nbsp;</td>
        <td width="22">&nbsp;</td>
        <td width="8">&nbsp;</td>
        <td width="36">&nbsp;</td>
        <td width="22">&nbsp;</td>
        <td width="22">&nbsp;</td>
        <td width="22">&nbsp;</td>
        <td width="22">&nbsp;</td>
        <td width="22">&nbsp;</td>
        <td width="22">&nbsp;</td>
        <td width="11">&nbsp;</td>
        <td width="33">&nbsp;</td>
        <td width="22">&nbsp;</td>
        <td width="22">&nbsp;</td>
        <td width="22">&nbsp;</td>
        <td width="22">&nbsp;</td>
        <td width="22">&nbsp;</td>
        <td width="22">&nbsp;</td>
        <td width="22">&nbsp;</td>
        <td width="22">&nbsp;</td>
        <td width="22">&nbsp;</td>
        <td width="22">&nbsp;</td>
        <td width="22">&nbsp;</td>
        <td width="22">&nbsp;</td>
        <td width="22">&nbsp;</td>
        <td width="24">&nbsp;</td>
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
        <td>&nbsp;</td>
        <td>&nbsp;</td>
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
        <td>&nbsp;</td>
        <td>&nbsp;</td>
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
        <td>&nbsp;</td>
        <td>&nbsp;</td>
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
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      </table>
      </td>
  </tr>
  <tr>
    <td width="5">&nbsp;</td>
    <td width="1">&nbsp;</td>
    <td width="3">&nbsp;</td>
    <td width="73">&nbsp;</td>
    <td width="3">&nbsp;</td>
    <td width="3">&nbsp;</td>
    <td width="19">&nbsp;</td>
    <td width="14">&nbsp;</td>
    <td width="68">&nbsp;</td>
    <td width="29">&nbsp;</td>
    <td width="6">&nbsp;</td>
    <td width="4">&nbsp;</td>
    <td width="12">&nbsp;</td>
    <td width="8">&nbsp;</td>
    <td width="81">&nbsp;</td>
    <td width="4">&nbsp;</td>
    <td width="213">&nbsp;</td>
    <td width="3">&nbsp;</td>
    <td width="3">&nbsp;</td>
    <td width="3">&nbsp;</td>
    <td width="3">&nbsp;</td>
    <td width="3">&nbsp;</td>
    <td width="3">&nbsp;</td>
    <td width="3">&nbsp;</td>
    <td width="3">&nbsp;</td>
    <td width="3">&nbsp;</td>
    <td width="3">&nbsp;</td>
    <td width="3">&nbsp;</td>
    <td width="3">&nbsp;</td>
    <td width="3">&nbsp;</td>
    <td width="289">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="31" align="center"><input type="button" name="bt_save" id="bt_save" class="tblTambah" value="Simpan" onclick="return simpan()" />&nbsp;
      <input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/></td>
  </tr>
</table>
</form>
</div>
<div id="tampil_data" align="center">
<table width="755" border="0" cellpadding="4" style="font:12px tahoma;">
<td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td colspan="2"><?php
                    if($_REQUEST['report']!=1){
					?>
                      <input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="tambah(this.value);" class="tblTambah"/>
                      <input type="button" id="btnHapus" name="btnHapus" value="Edit" onclick="edit();" class="tblTambah"/>
                      <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus();" class="tblHapus"/>                    <?php }?></td>
                    <td width="20%" align="right"><button type="button" id="btnTree" name="btnTree" value="Tampilan Tree" onclick="cetak()" class="tblViewTree" >Cetak</button></td>
                    <td width="5%">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="45%">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="left" colspan="3">
                        <div id="gridbox" style="width:900px; height:300px; background-color:white; overflow:hidden;"></div>
                        <div id="paging" style="width:900px;"></div></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="5">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
</table>
</div>
</body>
<script type="text/javascript">

		function toggle() {
    //parent.alertsize(document.body.scrollHeight);
}


        function simpan(action){
            if(ValidateForm('tgl,agama')){
				$("#form1").ajaxSubmit({
					  success:function(msg)
					  {
						alert(msg);
						batal();
						goFilterAndSort();
					  },
					});
			
            }
        }
        
        function isiCombo(id,val,defaultId,targetId,evloaded){
            if(targetId=='' || targetId==undefined){
                targetId=id;
            }
            Request('../combo_utils.php?all=1&id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'ok');
        }

        //isiCombo('cakupan','','','cakupan','');

        function setCakupan(val){
            if(val == 4){
                document.getElementById('tr_cakupan').style.display = 'table-row';
            }
            else{
                document.getElementById('tr_cakupan').style.display = 'none';
            }
        }

        function ambilData(){		
			var sisip = a.getRowId(a.getSelRow()).split('|');
			//$('#txt_anjuran').val(a.cellsGetValue(a.getSelRow(),3));
			$('#id').val(sisip[0]);
			$('#tgl').val(sisip[1]);
			$('#diperoleh').val(sisip[2]);
			$('#jam').val(sisip[3]);
			$('#dikirim').val(sisip[4]);
			$('#nama_ibu').val(sisip[5]);
			$('#umur_ibu').val(sisip[6]);
			$('#nama_ayah').val(sisip[7]);
			$('#umur_ayah').val(sisip[8]);
			$('#agama').val(sisip[9]);
			centang(sisip[10]);
			//$('#status').val(sisip[10]);
			$('#pekerjaan').val(sisip[11]);
			$('#pendidikan').val(sisip[12]);
			$('#alamat').val(sisip[13]);
			cek(sisip[14]);
			//$('#penyakit').val(sisip[14]);
			$('#isi').val(sisip[15]);
			var x=sisip[15];
			//alert (x);
			if($('#isi').val()!='')
			{
				document.getElementById('isi').disabled=false;
			}
			else
			{	
				document.getElementById('isi').disabled=true;
			}
			$('#suhu').val(sisip[16]);
			$('#tensi').val(sisip[17]);
			$('#nadi').val(sisip[18]);
			$('#teratur').val(sisip[19]);
			$('#pulsasi').val(sisip[20]);
			$('#rr').val(sisip[21]);
			$('#teratur2').val(sisip[22]);
			$('#pernafasan').val(sisip[23]);
			$('#akral').val(sisip[24]);
			$('#bb').val(sisip[25]);
			$('#tb').val(sisip[26]);
			$('#ld').val(sisip[27]);
			$('#kesadaran').val(sisip[28]);
			$('#lk').val(sisip[29]);
			$('#lp').val(sisip[30]);
			$('#nilai').val(sisip[31]);
			$('#warna').val(sisip[32]);
			$('#trugor').val(sisip[33]);
			$('#alasan').val(sisip[34]);
			$('#inObat').load("tabel_alat_kesehatan.php?type=ESO&id="+sisip[0]);
			$('#inObat2').load("tabel_pemeriksaan_radiologi.php?type=ESO2&id="+sisip[0]);
			centang2(sisip[35]);
			//$('#alergi').val(sisip[35]);
			$('#sebut_alergi').val(sisip[36]);
			var xx=sisip[36];
			//alert (x);
			if($('#sebut_alergi').val()!='')
			{
				document.getElementById('sebut_alergi').disabled=false;
			}
			else
			{	
				document.getElementById('sebut_alergi').disabled=true;
			}
			centang3(sisip[37]);
			//$('#operasi').val(sisip[37]);
			$('#sebut_operasi').val(sisip[38]);
			var xxx=sisip[38];
			//alert (x);
			if($('#sebut_operasi').val()!='')
			{
				document.getElementById('sebut_operasi').disabled=false;
			}
			else
			{	
				document.getElementById('sebut_operasi').disabled=true;
			}
			$('#status1').val(sisip[39]);
			$('#tgl1').val(sisip[40]);
			$('#status2').val(sisip[41]);
			$('#tgl2').val(sisip[42]);
			$('#status3').val(sisip[43]);
			$('#tgl3').val(sisip[44]);
			$('#status4').val(sisip[45]);
			$('#tgl4').val(sisip[46]);
			$('#status5').val(sisip[47]);
			$('#tgl5').val(sisip[48]);
			$('#status6').val(sisip[49]);
			$('#tgl6').val(sisip[50]);
			$('#status7').val(sisip[51]);
			$('#tgl7').val(sisip[52]);
			$('#status8').val(sisip[53]);
			$('#tgl8').val(sisip[54]);
			$('#status9').val(sisip[55]);
			$('#tgl9').val(sisip[56]);
			$('#status10').val(sisip[57]);
			$('#tgl10').val(sisip[58]);
			$('#status11').val(sisip[59]);
			$('#tgl11').val(sisip[60]);
			$('#status12').val(sisip[61]);
			$('#tgl12').val(sisip[62]);
			$('#lama').val(sisip[63]);
			$('#partus').val(sisip[64]);
			centang4(sisip[65]);
			//$('#komplikasi').val(sisip[65]);
			$('#sebut_kom').val(sisip[66]);
			var xxxx=sisip[66];
			//alert (x);
			if($('#sebut_kom').val()!='')
			{
				document.getElementById('sebut_kom').disabled=false;
			}
			else
			{	
				document.getElementById('sebut_kom').disabled=true;
			}
			centang5(sisip[67]);
			//$('#neonatus').val(sisip[67]);
			$('#sebut_neo').val(sisip[68]);
			var xxxxx=sisip[68];
			//alert (x);
			if($('#sebut_neo').val()!='')
			{
				document.getElementById('sebut_neo').disabled=false;
			}
			else
			{	
				document.getElementById('sebut_neo').disabled=true;
			}
			centang6(sisip[69]);
			//$('#maternal').val(sisip[69]);
			$('#sebut_mate').val(sisip[70]);
			var xxxxxx=sisip[70];
			//alert (x);
			if($('#sebut_mate').val()!='')
			{
				document.getElementById('sebut_mate').disabled=false;
			}
			else
			{	
				document.getElementById('sebut_mate').disabled=true;
			}
			$('#berat').val(sisip[71]);
			$('#panjang').val(sisip[72]);
			$('#asi').val(sisip[73]);
			$('#formula').val(sisip[74]);
			$('#susu').val(sisip[75]);
			$('#cincang').val(sisip[76]);
			$('#tim').val(sisip[77]);
			$('#nasi').val(sisip[78]);
			$('#bicara').val(sisip[79]);
			$('#makanan').val(sisip[80]);
			$('#porsi').val(sisip[81]);
			$('#frekuensi').val(sisip[82]);
			$('#tengurap').val(sisip[83]);
			$('#duduk').val(sisip[84]);
			$('#merangkak').val(sisip[85]);
			$('#berdiri').val(sisip[86]);
			$('#jalan').val(sisip[87]);
			$('#penglihatan').val(sisip[88]);
			$('#alat_bantu').val(sisip[89]);
			$('#pendengaran').val(sisip[90]);
			
			//cek(sisip[4]);
			$('#act').val('edit');
        
            fSetValue(window,p);
			
        }

        function hapus(){
            var id = document.getElementById("id").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(id==''){
					alert("Pilih data terlebih dahulu");
				}else if(confirm("Anda yakin menghapus data ini ?")){
					$('#act').val('hapus');
					$("#form1").ajaxSubmit({
					  success:function(msg)
					  {
						alert(msg);
						resetF();
						goFilterAndSort();
					  },
					});
				}

        }
		
		function edit(){
            var rowid = document.getElementById("id").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(rowid==''){
					alert("Pilih data terlebih dahulu");
				}else{
					$('#act').val('edit');
					$('#tampil_input').slideDown(1000,function(){
		toggle();
		});
				}

        }

        function batal(){
			resetF();
			$('#tampil_input').slideUp(1000,function(){
		toggle();
		});
        }
		
		function resetF(){
			$('#act').val('tambah');
			document.getElementById('form1').reset();
			//$('#id').val('');
			//$('#txt_anjuran').val('');
            $('#inObat').load("tabel_alat_kesehatan.php");
			$('#inObat2').load("tabel_pemeriksaan_radiologi.php");
			//centang(1,'L')
			}


        function konfirmasi(key,val){
            //alert(val);
            /*var tangkap=val.split("*|*");
            var proses=tangkap[0];
            var alasan=tangkap[1];
            if(key=='Error'){
                if(proses=='hapus'){				
                    alert('Tidak bisa menambah data karena '+alasan+'!');
                }              

            }
            else{
                if(proses=='tambah'){
                    alert('Tambah Berhasil');
                }
                else if(proses=='simpan'){
                    alert('Simpan Berhasil');
                }
                else if(proses=='hapus'){
                    alert('Hapus Berhasil');
                }
            }*/

        }

        function goFilterAndSort(grd){
            //alert("tmpt_layanan_utils.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
            a.loadURL("pengkajian_khusus_anak_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Data Pengkajian Khusus Pasien Anak");
        a.setColHeader("NO,NO RM,TANGGAL,PUKUL,TGL INPUT,PENGGUNA");
        a.setIDColHeader(",no_rm,,,");
        a.setColWidth("20,80,150,150,50,120");
        a.setCellAlign("center,center,center,center,center,center");
        a.setCellHeight(20);
        a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("pengkajian_khusus_anak_util.php?idPel=<?=$idPel?>");
        a.Init();
		
		function tambah(){
			resetF();
			$('#tampil_input').slideDown(1000,function(){
		toggle();
		});
		document.getElementById('isi').disabled=true;
		document.getElementById('sebut_alergi').disabled=true;
		document.getElementById('sebut_operasi').disabled=true;
		document.getElementById('sebut_kom').disabled=true;
		document.getElementById('sebut_neo').disabled=true;
		document.getElementById('sebut_mate').disabled=true;	
			}
		
		
		function cetak(){
		 var id = document.getElementById("id").value;
		 if(id==""){
				var idx =a.getRowId(a.getSelRow()).split('|');
				id=idx[0];
			 }
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			//if(rowid==''){
//					alert("Pilih data terlebih dahulu");
//				}else{	
		window.open("pengkajian_khusus_anak_cetak.php?id="+id+"&idKunj=<?=$idKunj?>&idPel=<?=$idPel?>&idUsr=<?=$idUsr?>","_blank");
		document.getElementById('id').value="";
				//}
		}
		
function centang(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['radio[0]'];
		var list2 = document.form1.elements['radio[0]'];
		var list3 = document.form1.elements['radio[0]'];
		
		
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			  if (list1[i].value==list[0])
			  {
			   list1[i].checked = true;
			  }
		  }
		}
		if ( list2.length > 1 )
		{
		 for (i = 1; i < list2.length; i++)
			{
			  if (list2[i].value==list[1])
			  {
			   list2[i].checked = true;
			  }
		  }
		}
		if ( list3.length > 2 )
		{
		 for (i = 2; i < list3.length; i++)
			{
			  if (list3[i].value==list[2])
			  {
			   list3[i].checked = true;
			  }
		  }
		}
	}

function centang2(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['radio[1]'];
		var list2 = document.form1.elements['radio[1]'];
		
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			  if (list1[i].value==list[0])
			  {
			   list1[i].checked = true;
			  }
		  }
		}
		if ( list2.length > 1 )
		{
		 for (i = 1; i < list2.length; i++)
			{
			  if (list2[i].value==list[1])
			  {
			   list2[i].checked = true;
			  }
		  }
		}
	}
	
	function centang3(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['radio[2]'];
		var list2 = document.form1.elements['radio[2]'];
	
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			  if (list1[i].value==list[0])
			  {
			   list1[i].checked = true;
			  }
		  }
		}
		if ( list2.length > 1 )
		{
		 for (i = 1; i < list2.length; i++)
			{
			  if (list2[i].value==list[1])
			  {
			   list2[i].checked = true;
			  }
		  }
		}
	}
	
	function centang4(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['radio[3]'];
		var list2 = document.form1.elements['radio[3]'];
	
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			  if (list1[i].value==list[0])
			  {
			   list1[i].checked = true;
			  }
		  }
		}
		if ( list2.length > 1 )
		{
		 for (i = 1; i < list2.length; i++)
			{
			  if (list2[i].value==list[1])
			  {
			   list2[i].checked = true;
			  }
		  }
		}
	}
	
	function centang5(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['radio[4]'];
		var list2 = document.form1.elements['radio[4]'];
		
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			  if (list1[i].value==list[0])
			  {
			   list1[i].checked = true;
			  }
		  }
		}
		if ( list2.length > 1 )
		{
		 for (i = 1; i < list2.length; i++)
			{
			  if (list2[i].value==list[1])
			  {
			   list2[i].checked = true;
			  }
		  }
		}
	}
	
	function centang6(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['radio[5]'];
		var list2 = document.form1.elements['radio[5]'];
	
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			  if (list1[i].value==list[0])
			  {
			   list1[i].checked = true;
			  }
		  }
		}
		if ( list2.length > 1 )
		{
		 for (i = 1; i < list2.length; i++)
			{
			  if (list2[i].value==list[1])
			  {
			   list2[i].checked = true;
			  }
		  }
		}
	}
		
	function cek(tes){
		var val=tes.split(',');
		var list1 = document.form1.elements['c_chk[]'];
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			
			  if (list1[i].value==val[i])
			  {
			   list1[i].checked = true;
			  }else{
					list1[i].checked = false;
					}
		  }
		}
		}

/*function centang(tes,tes2){
		 var checkbox = document.form1.elements['rad_thd'];
		 var checkboxlp = document.form1.elements['rad_lp'];
		 
		 if ( checkbox.length > 0 )
		{
		 for (i = 0; i < checkbox.length; i++)
			{
			  if (checkbox[i].value==tes)
			  {
			   checkbox[i].checked = true;
			  }
		  }
		}
		if ( checkboxlp.length > 0 )
		{
		 for (i = 0; i < checkboxlp.length; i++)
			{
			  if (checkboxlp[i].value==tes2)
			  {
			   checkboxlp[i].checked = true;
			  }
		  }
		}
	}*/
	
	
	
 function addRowToTable()
        {
            //use browser sniffing to determine if IE or Opera (ugly, but required)
            var isIE = false;
            if(navigator.userAgent.indexOf('MSIE')>0){
                isIE = true;
            }
            //	alert(navigator.userAgent);
            //	alert(isIE);
            var tbl = document.getElementById('tblObat');
            var lastRow = tbl.rows.length;
            // if there's no header row in the table, then iteration = lastRow + 1
            var iteration = lastRow;
            var row = tbl.insertRow(lastRow);
            //row.id = 'row'+(iteration-1);
            row.className = 'itemtableA';
            //row.setAttribute('class', 'itemtable');
            row.onmouseover = function(){this.className='itemtableAMOver';};
            row.onmouseout = function(){this.className='itemtableA';};
            //row.setAttribute('onMouseOver', "this.className='itemtableMOver'");
            //row.setAttribute('onMouseOut', "this.className='itemtable'");

           /* // left cell
            var cellLeft = row.insertCell(0);
            var textNode = document.createTextNode(iteration-2);
            cellLeft.className = 'tdisikiri';
            cellLeft.appendChild(textNode);

            // right cell
            cellLeft = row.insertCell(1);
            textNode = document.createTextNode('-');
            cellLeft.className = 'tdisi';
            cellLeft.appendChild(textNode);*/

            // right cell
            var cellRight = row.insertCell(0);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'jenis[]';
                el.id = 'jenis[]';
				
            }else{
                el = document.createElement('<input name="jenis[]"/>');
            }
            el.type = 'text';
            el.size = 15;
            el.value = '';
			

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

            if("<?php echo $edit;?>" == true){
                //generate id
                if(!isIE){
                    el = document.createElement('input');
                    el.name = 'id';
                    el.id = 'id';
                }else{
                    el = document.createElement('<input name="id" id="id" />');
                }
                el.type = 'text';
                cellRight.className = 'tdisi';
                cellRight.appendChild(el);
            }

 // right cell
            var cellRight = row.insertCell(1);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'keterangan1[]';
                el.id = 'keterangan1[]';
            }else{
                el = document.createElement('<input name="keterangan1[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 25;
            

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(2);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'jenis2[]';
                el.id = 'jenis2[]';
            }else{
                el = document.createElement('<input name="jenis2[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 15;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(3);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'keterangan2[]';
                el.id = 'keterangan2[]';
            }else{
                el = document.createElement('<input name="keterangan2[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 25;
            

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
 // right cell
                cellRight = row.insertCell(4);
                if(!isIE){
                    el = document.createElement('img');
                    el.setAttribute('onClick','if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);setDisable("del")}');
                }else{
                    el = document.createElement('<img name="img" onClick="if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);}"/>');
                }
                el.src = 'del.png';
                el.border = "0";
                el.width = "16";
                el.height = "16";
                el.className = 'proses';
                el.align = "absmiddle";
                el.title = "Klik Untuk Menghapus";

                //  cellRight.setAttribute('class', 'tdisi');
                cellRight.className = 'tdisi';
                cellRight.appendChild(el);

                //document.forms[0].txt_obat[iteration-3].focus();

                /*  // select cell
  var cellRightSel = row.insertCell(2);
  var sel = document.createElement('select');
  sel.name = 'satuan';
  sel.className = "txtinput";
  //sel.id = 'selRow'+iteration;
<?php
//echo $sel;
?>
//  sel.options[0] = new Option('text zero', 'value0');
//  sel.options[1] = new Option('text one', 'value1');
  cellRightSel.appendChild(sel);
                 */
        //document.getElementById('btnSimpan').disabled = true;
    }
function removeRowFromTable(cRow)
	{
        var tbl = document.getElementById('tblObat');
        var jmlRow = tbl.rows.length;
        if (jmlRow > 1)
		{
            var i=cRow.parentNode.parentNode.rowIndex;
            //if (i>2){
            tbl.deleteRow(i);
            var lastRow = tbl.rows.length;
            for (var i=2;i<lastRow;i++)
			{
                var tds = tbl.rows[i].getElementsByTagName('id');
                //tds[0].innerHTML=i-2;
            }
        }
    }
	
	function addRowToTable2()
        {
            //use browser sniffing to determine if IE or Opera (ugly, but required)
            var isIE = false;
            if(navigator.userAgent.indexOf('MSIE')>0){
                isIE = true;
            }
            //	alert(navigator.userAgent);
            //	alert(isIE);
            var tbl = document.getElementById('tblObat2');
            var lastRow = tbl.rows.length;
            // if there's no header row in the table, then iteration = lastRow + 1
            var iteration = lastRow;
            var row = tbl.insertRow(lastRow);
            //row.id = 'row'+(iteration-1);
            row.className = 'itemtableA';
            //row.setAttribute('class', 'itemtable');
            row.onmouseover = function(){this.className='itemtableAMOver';};
            row.onmouseout = function(){this.className='itemtableA';};
            //row.setAttribute('onMouseOver', "this.className='itemtableMOver'");
            //row.setAttribute('onMouseOut', "this.className='itemtable'");

           /* // left cell
            var cellLeft = row.insertCell(0);
            var textNode = document.createTextNode(iteration-2);
            cellLeft.className = 'tdisikiri';
            cellLeft.appendChild(textNode);

            // right cell
            cellLeft = row.insertCell(1);
            textNode = document.createTextNode('-');
            cellLeft.className = 'tdisi';
            cellLeft.appendChild(textNode);*/

            // right cell
            var cellRight = row.insertCell(0);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'jenis_pemeriksaan[]';
                el.id = 'jenis_pemeriksaan[]';
				
            }else{
                el = document.createElement('<input name="jenis_pemeriksaan[]"/>');
            }
            el.type = 'text';
            el.size = 15;
            el.value = '';
			

            cellRight.className = 'tdisi2';
            cellRight.appendChild(el);

            if("<?php echo $edit;?>" == true){
                //generate id
                if(!isIE){
                    el = document.createElement('input');
                    el.name = 'id';
                    el.id = 'id';
                }else{
                    el = document.createElement('<input name="id" id="id" />');
                }
                el.type = 'text';
                cellRight.className = 'tdisi2';
                cellRight.appendChild(el);
            }

 // right cell
            var cellRight = row.insertCell(1);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'bagian[]';
                el.id = 'bagian[]';
            }else{
                el = document.createElement('<input name="bagian[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 25;
            

            cellRight.className = 'tdisi2';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(2);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'lembar[]';
                el.id = 'lembar[]';
            }else{
                el = document.createElement('<input name="lembar[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 15;

            cellRight.className = 'tdisi2';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(3);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'keterangan[]';
                el.id = 'keterangan[]';
            }else{
                el = document.createElement('<input name="keterangan[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 25;
            

            cellRight.className = 'tdisi2';
            cellRight.appendChild(el);
			
 // right cell
                cellRight = row.insertCell(4);
                if(!isIE){
                    el = document.createElement('img');
                    el.setAttribute('onClick','if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable2(this);setDisable("del")}');
                }else{
                    el = document.createElement('<img name="img" onClick="if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable2(this);}"/>');
                }
                el.src = 'del.png';
                el.border = "0";
                el.width = "16";
                el.height = "16";
                el.className = 'proses';
                el.align = "absmiddle";
                el.title = "Klik Untuk Menghapus";

                //  cellRight.setAttribute('class', 'tdisi');
                cellRight.className = 'tdisi2';
                cellRight.appendChild(el);

                //document.forms[0].txt_obat[iteration-3].focus();

                /*  // select cell
  var cellRightSel = row.insertCell(2);
  var sel = document.createElement('select');
  sel.name = 'satuan';
  sel.className = "txtinput";
  //sel.id = 'selRow'+iteration;
<?php
//echo $sel;
?>
//  sel.options[0] = new Option('text zero', 'value0');
//  sel.options[1] = new Option('text one', 'value1');
  cellRightSel.appendChild(sel);
                 */
        //document.getElementById('btnSimpan').disabled = true;
    }
function removeRowFromTable2(cRow)
	{
        var tbl = document.getElementById('tblObat2');
        var jmlRow = tbl.rows.length;
        if (jmlRow > 1)
		{
            var i=cRow.parentNode.parentNode.rowIndex;
            //if (i>2){
            tbl.deleteRow(i);
            var lastRow = tbl.rows.length;
            for (var i=2;i<lastRow;i++)
			{
                var tds = tbl.rows[i].getElementsByTagName('id');
                //tds[0].innerHTML=i-2;
            }
        }
    }

/*tampil = function(cek) 
{
  if (cek.checked) 
  {
    $('#status').slideDown(600);
  } 
  else 
  {
    $('#status').slideUp(600);
  }
}*/
/*var appended = $('<div />').text("You're appendin'!");
appended.id = 'appended';*/

/*function kejadian()
		{
			var nutrisi = document.getElementById('nutrisi').value;
			if(nutrisi=="Diet Khusus")
			{
				$('#status').slideDown(600);
				
			}
			else
			{
				$('#status').slideUp(600);
				$('#status').checked(false);
				document.getElementById('nutrisi').value="";
			}
			//document.getElementById('act').value = "edit";
			
		}
*/

    </script>
    <script>
    var idrow = 3;

function tambahrow(){
    var x=document.getElementById('datatable').insertRow(idrow);
	var idx2 = $('.tanggal tr').length;
	var idx = idx2-3;
    var td1=x.insertCell(0);
    var td2=x.insertCell(1);
    var td3=x.insertCell(2);
    var td4=x.insertCell(3);
	var td5=x.insertCell(4);
	
	
    td1.innerHTML="<input type='text' class='tgl' name='tgl[]' id='tgl"+idx+"'>";tanggalan();
	td2.innerHTML="<select id='hari' name='hari[]'><option>Senin</option><option>Selasa</option><option>Rabu</option><option>Kamis</option><option>Jumat</option><option>Sabtu</option><option>Minggu</option></select>";
    td3.innerHTML="<input type='text' class='jam' name='jam[]' id='jam"+idx+"'>";jam();
    td4.innerHTML="<input type='text' id='dokter' name='dokter[]'>";
	//url='tes.php';	
	td5.innerHTML="<input type='button' value='Delete' onclick='del()' />";
    idrow++;
}

function del(){
    if(idrow>3){
		//alert(idrow);
        var x=document.getElementById('datatable').deleteRow(idrow-1);
        idrow--;
    }
}

/*$('.tanggal').on('click', '.hapus',function(){
		if(confirm('Apakah anda yakin?')){
			var id = $(this).parents('tr.item').find('td:eq(0) input:eq(0)').val();
			var elm = $(this).parents('tr.item');
			$.ajax({
				type: 'post',
				data: 'type=delete&id='+id,
				url: '14.resume_kep_act.php',
				success: function(){
					elm.remove();
				}
			});
		}
	});*/
	
function enable_text(status)
{
status=!status;
document.form1.isi.disabled = status;
$('#isi').val('');
}


$('input:radio[name="radio[1]"]').change(
    function enable_text2(status){
	if ($(this).val() == 1) {
            document.form1.sebut_alergi.disabled = status;
			$('#sebut_alergi').val('');
        }
        else if ($(this).val() == 2) {
			status=!status;
			document.form1.sebut_alergi.disabled = status;
			$('#sebut_alergi').val('');
        }
    });
	
$('input:radio[name="radio[2]"]').change(
    function enable_text3(status){
	if ($(this).val() == 1) {
            document.form1.sebut_operasi.disabled = status;
			$('#sebut_operasi').val('');
        }
        else if ($(this).val() == 2) {
			status=!status;
			document.form1.sebut_operasi.disabled = status;
			$('#sebut_operasi').val('');
        }
    });
	
	$('input:radio[name="radio[3]"]').change(
    function enable_text4(status){
	if ($(this).val() == 1) {
            document.form1.sebut_kom.disabled = status;
			$('#sebut_kom').val('');
        }
        else if ($(this).val() == 2) {
			status=!status;
			document.form1.sebut_kom.disabled = status;
			$('#sebut_kom').val('');
        }
    });
	
	$('input:radio[name="radio[4]"]').change(
    function enable_text5(status){
	if ($(this).val() == 1) {
            document.form1.sebut_neo.disabled = status;
			$('#sebut_neo').val('');
        }
        else if ($(this).val() == 2) {
			status=!status;
			document.form1.sebut_neo.disabled = status;
			$('#sebut_neo').val('');
        }
    });
	
	$('input:radio[name="radio[5]"]').change(
    function enable_text6(status){
	if ($(this).val() == 1) {
            document.form1.sebut_mate.disabled = status;
			$('#sebut_mate').val('');
        }
        else if ($(this).val() == 2) {
			status=!status;
			document.form1.sebut_mate.disabled = status;
			$('#sebut_mate').val('');
        }
    });
</script>
<script type="text/javascript">
$(function () {
    // Initialize appendGrid
  $('#tblAppendGrid').appendGrid('init', {
  caption: 'Contoh',
  initRows: 1,
  columns: [
    { name: 'Album', display: 'Nama', type: 'ui-datepicker', ctrlAttr: { maxlength: 100 }, ctrlCss: { width: '160px'} },
    { name: 'Artist', display: 'Artist', type: 'text', ctrlAttr: { maxlength: 100, title: 'Please fill in the Artist name!!' }, ctrlCss: { width: '100px' }, uiTooltip: { show: true} },
	{ name: 'Year', display: 'Tahun', type: 'ui-spinner', ctrlAttr: { maxlength: 4 }, ctrlCss: { width: '40px' }, uiOption: { min: 2000, max: new Date().getFullYear()} },
	{ name: 'Origin', display: 'Origin', type: 'ui-autocomplete', uiOption: { source: ['Hong Kong', 'Taiwan', 'Japan', 'Korea', 'US', 'Others','Indonesia']} },
	{ name: 'StockIn', display: 'Stock In', type: 'ui-datepicker', ctrlAttr: { maxlength: 10 }, ctrlCss: { width: '80px' }, uiOption: { dateFormat: 'yy/mm/dd'} },
	{ name: 'Price', display: 'Price', type: 'text', ctrlAttr: { maxlength: 10 }, ctrlCss: { width: '50px', 'text-align': 'right' }, value: 0 }
],
initData: [
	{ 'Album': 'Dearest', 'Artist': 'Theresa Fu', 'Year': '2009', 'Origin': 'Hong Kong', 'StockIn': '2011/01/30', 'Price': 168.9 },
	{ 'Album': 'To be Free', 'Artist': 'Arashi', 'Year': '2010', 'Origin': 'Japan', 'StockIn': '2011/02/26', 'Price': 152.6 },
	{ 'Album': 'Count On Me', 'Artist': 'Show Luo', 'Year': '2012', 'Origin': 'Taiwan', 'StockIn': '2011/09/18', 'Price': 306.8 },
	{ 'Album': 'Wonder Party', 'Artist': 'Wonder Girls', 'Year': '2012', 'Origin': 'Korea', 'StockIn': '2013/01/14', 'Price': 108.6 },
	{ 'Album': 'Reflection', 'Artist': 'Kelly Chen', 'Year': '2013', 'Origin': 'Hong Kong', 'StockIn': '2013/02/16', 'Price': 138.2 }
            ]
    });
});
</script>
    
</html>
