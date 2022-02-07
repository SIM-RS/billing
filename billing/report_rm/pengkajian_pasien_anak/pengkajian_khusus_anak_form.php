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
        <script type="text/javascript" language="JavaScript" src="../../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../../theme/js/dsgrid.js"></script>
        <!-- untuk ajax-->
        <script type="text/javascript" src="../../theme/js/ajax.js"></script>
        <script type="text/javascript" src="../../jquery.js"></script>
        <script type="text/javascript" src="../../jquery.form.js"></script>
        <script type="text/javascript" src="../js/jquery.timeentry.js"></script>
        <script type="text/javascript" src="../js/jquery.timeentry.min.js"></script>
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
<div id="tampil_input" align="center" style="display:none">
<form name="form1" id="form1" action="pengkajian_khusus_anak_act.php">
<input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    			<input type="hidden" name="id" id="id"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
<table width="1014" border="0" cellpadding="4" style="font:12px tahoma;">
  <tr>
    <td colspan="3" align="center" valign="middle">&nbsp;</td>
    <td width="575" colspan="2" rowspan="6" align="right" valign="bottom"><table width="496" border="0" align="right" cellpadding="4" bordercolor="#000000" style="border-collapse:collapse; border:1px solid #000000;">
      <tr>
        <td width="124">Nama Pasien</td>
        <td width="173">:
          <?=$dP['nama'];?></td>
        <td width="75"><span <?php if($dP['sex']=='L'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>L</span> / <span <?php if($dP['sex']=='P'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>P</span></td>
        <td width="104">&nbsp;</td>
      </tr>
      <tr>
        <td>Tanggal Lahir</td>
        <td>:
          <?=tglSQL($dP['tgl_lahir']);?></td>
        <td>Usia</td>
        <td>:
          <?=$dP['usia'];?>
          &nbsp;Thn</td>
      </tr>
      <tr>
        <td>No. RM</td>
        <td>:
          <?=$dP['no_rm'];?></td>
        <td>No Registrasi </td>
        <td>: <?=$dP['no_reg2'];?></td>
      </tr>
      <tr>
        <td>Ruang Rawat/Kelas</td>
        <td>:
          <?=$dP['nm_unit'];?>
          /
          <?=$dP['nm_kls'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Alamat</td>
        <td>:
          <?=$dP['alamat'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="center">(Tempelkan Sticker Identitas Pasien)</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">RS PELINDO I</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><span style="font:bold 15px tahoma;; font-family: tahoma; font-size: 15px">PENGKAJIAN KHUSUS PASIEN ANAK</span></td>
  </tr>
  </table>
  <table width="1000" style="border:1px solid #000000;">
  <tr>
    <td colspan="31"><table width="994" style="font:12px tahoma;">
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
        <td colspan="4">Tanggal</td>
        <td>:</td>
        <td colspan="7"><input name="tgl" type="text" id="tgl" onclick="gfPop.fPopCalendar(document.getElementById('tgl'),depRange);" size="10"/></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="4">Pukul</td>
        <td colspan="12">:
          <input name="jam" type="text" class="jam" id="jam" size="10" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="4">Diperoleh dari</td>
        <td>:</td>
        <td colspan="7"><input type="text" name="diperoleh" id="diperoleh" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="4">Pesan Dikirim</td>
        <td colspan="12">: 
          <select name="dikirim" id="dikirim">
            <option>Poliklinik</option>
            <option>IGD</option>
            <option>Dokter Praktek</option>
            </select></td>
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
        <td colspan="13"><strong>I. IDENTITAS ORANG TUA</strong></td>
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
        <td colspan="9">Nama Ibu</td>
        <td colspan="8">: 
          <label for="textfield5"></label>
          <input name="nama_ibu" type="text" id="nama_ibu" size="25" /></td>
        <td colspan="4">Nama Ayah</td>
        <td>&nbsp;</td>
        <td colspan="10">: 
          <input name="nama_ayah" type="text" id="nama_ayah" size="25" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="9">Umur</td>
        <td colspan="8">: 
          <label for="textfield6"></label>
          <input name="umur_ibu" type="text" id="umur_ibu" size="5" /> 
          Th</td>
        <td colspan="4">Umur</td>
        <td>&nbsp;</td>
        <td colspan="4">: 
          <input name="umur_ayah" type="text" id="umur_ayah" size="5" /> 
          Th</td>
        <td colspan="3">Agama</td>
        <td colspan="7">: 
          <label for="select2"></label>
          <select name="agama" id="agama">
            <option value="">Pilih</option>
            <?php
          $sql="select * from b_ms_agama";
          $query = mysql_query ($sql);
          while($data = mysql_fetch_array($query)){
		  ?>
            <option value="<?php echo $data['id'];?>" ><?php echo $data['agama']?></option>
            <?php
    	  }
	      ?>
            </select></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="9">Status Perkawinan</td>
        <td colspan="5">:
          <input id="radio[]" type="radio" name="radio[0]" value="1" />
          Menikah</td>
        <td colspan="4"><input id="radio[]"  type="radio" name="radio[0]" value="2" />
          Janda</td>
        <td colspan="4"><input id="radio[]"  type="radio" name="radio[0]" value="3" />
          Duda</td>
        <td colspan="7">Pekerjaan Orang Tua</td>
        <td colspan="7">: 
          <label for="textfield7"></label>
          <input type="text" name="pekerjaan" id="pekerjaan" /></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="9">Pendidikan Terakhir</td>
        <td colspan="7">: 
          <label for="textfield8"></label>
          <label for="select3"></label>
          <select name="pendidikan" id="pendidikan">
            <option value="">Pilih</option>
            <option>SD/Sederajat</option>
            <option>SMP/Sederajat</option>
            <option>SMA/Sederajat</option>
            <option>D1</option>
            <option>D2</option>
            <option>D3</option>
            <option>S1</option>
            <option>S2</option>
            <option>S3</option>
            <option>Lainnya</option>
            </select></td>
        <td>&nbsp;</td>
        <td colspan="5">Alamat Rumah</td>
        <td colspan="13">: 
          <label for="textfield9"></label>
          <input name="alamat" type="text" id="alamat" size="45" /></td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="9">Penyakit yang pernah diderita ibu</td>
        <td colspan="5">: 
          <input id="c_chk[]" type="checkbox" name="c_chk[0]" value="1" />
          Diabet</td>
        <td colspan="4"><input id="c_chk[]" type="checkbox" name="c_chk[1]" value="2" /> 
          Jantung</td>
        <td colspan="4"><input id="c_chk[]" type="checkbox" name="c_chk[2]" value="3" /> 
          Jantung</td>
        <td colspan="4"><input id="c_chk[]" type="checkbox" name="c_chk[3]" value="4" />
          Lues</td>
        <td><input id="c_chk[]" type="checkbox" name="c_chk[4]" value="5" onclick="enable_text(this.checked)" /></td>
        <td colspan="9">Lain-lain 
          <label for="textfield10"></label>
          <input type="text" name="isi" id="isi" /></td>
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
        <td colspan="13"><strong>II. RIWAYAT KESEHATAN SEKARANG</strong></td>
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
        <td colspan="9">Tanda-tanda vital</td>
        <td>: </td>
        <td colspan="2">Suhu </td>
        <td>:</td>
        <td colspan="4"><input name="suhu" type="text" id="suhu" size="5" />
          &deg;C</td>
        <td>&nbsp;</td>
        <td colspan="2">Tensi</td>
        <td>:</td>
        <td colspan="6"><input name="tensi" type="text" id="tensi" size="5" /> 
          mmHg</td>
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
        <td colspan="2"><label for="textfield14">Nadi</label></td>
        <td>:</td>
        <td colspan="4"><input name="nadi" type="text" id="nadi" size="5" /> 
          X/mt</td>
        <td>&nbsp;</td>
        <td colspan="5"><label for="select4"></label>
          <select name="teratur" id="teratur">
            <option>Teratur</option>
            <option>Tidak Teratur</option>
            </select></td>
        <td>&nbsp;</td>
        <td colspan="3">Pulsasi</td>
        <td colspan="7">: 
          <label for="select5"></label>
          <select name="pulsasi" id="pulsasi">
            <option>Kuat</option>
            <option>Lemah</option>
            <option>Tidak Teraba</option>
            </select></td>
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
        <td colspan="2">RR</td>
        <td>:</td>
        <td colspan="4"><input name="rr" type="text" id="rr" size="5" /> 
          x/mt</td>
        <td>&nbsp;</td>
        <td colspan="5"><select name="teratur2" id="teratur2">
          <option>Teratur</option>
          <option>Tidak Teratur</option>
          </select></td>
        <td>&nbsp;</td>
        <td colspan="6"><label for="select8"></label>
          <select name="pernafasan" id="pernafasan">
            <option>Pernafasan Dada</option>
            <option>Pernafasan Perut</option>
            </select></td>
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
        <td colspan="2">Akral</td>
        <td>:</td>
        <td colspan="4"><label for="select7"></label>
          <select name="akral" id="akral">
            <option>Hangat</option>
            <option>Dingin</option>
            <option>Retraksi Dada</option>
            <option>Hyperventilasi</option>
            </select></td>
        <td colspan="4">&nbsp;</td>
        <td colspan="4">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="5">&nbsp;</td>
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
        <td colspan="9">Berat Badan / Tinggi badan</td>
        <td>:</td>
        <td colspan="2"><input name="bb" type="text" id="bb" size="1" />
          kg</td>
        <td>/</td>
        <td colspan="2"><input name="tb" type="text" id="tb" size="1" />
          cm</td>
        <td>&nbsp;</td>
        <td colspan="4">Lingkar dada</td>
        <td>:</td>
        <td colspan="4"><input name="ld" type="text" id="ld" size="5" />
          Cm</td>
        <td colspan="3">Kesadaran</td>
        <td colspan="8">: 
          <label for="select9"></label>
          <select name="kesadaran" id="kesadaran">
            <option>Composmentis / Apatis</option>
            <option>Somnolen / sopporocoma</option>
            <option>Coma</option>
            </select></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="9">Lingkar Kepala</td>
        <td>:</td>
        <td colspan="5"><input name="lk" type="text" id="lk" size="5" /> 
          Cm</td>
        <td>&nbsp;</td>
        <td colspan="4">Lingkar perut</td>
        <td>:</td>
        <td colspan="4"><input name="lp" type="text" id="lp" size="5" />
          Cm</td>
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
        <td colspan="9">Nilai Afgar</td>
        <td>:</td>
        <td colspan="8"><label for="textfield17"></label>
          <input type="text" name="nilai" id="nilai" /></td>
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
        <td colspan="9">Tintegumen</td>
        <td>:</td>
        <td colspan="3">Warna Kulit</td>
        <td colspan="12">:
          <label for="select10"></label>
          <select name="warna" id="warna">
            <option>Normal</option>
            <option>Pucat</option>
            <option>Sianosis</option>
            <option>Ras</option>
            <option>Kemerahan</option>
            <option>Memar</option>
            <option>Bula</option>
            <option>Peterchie</option>
            </select></td>
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
        <td colspan="9">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3">Trugor Kulit</td>
        <td colspan="9">: 
          <label for="select11"></label>
          <select name="trugor" id="trugor">
            <option>Elastis</option>
            <option>Tidak Elastis</option>
            <option>Kemerahan</option>
            <option>Lecet</option>
            <option>Luka Sekitar Anus</option>
            </select></td>
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
        <td colspan="9">Alasan Masuk Rumah Sakit</td>
        <td>:</td>
        <td colspan="21" rowspan="4" valign="top"><label for="textfield18"></label>
          <textarea name="alasan" cols="50" rows="4" id="alasan"></textarea></td>
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
        <td colspan="9">Alat kesehatan yang terpasang</td>
        <td>:</td>
        <td colspan="25" rowspan="5" align="left">
        <div id="inObat">
        <table width="554" height="86" border="1" align="left" cellpadding="2" id="tblObat" style="border-collapse:collapse;">
          <tr>
            <td colspan="5" align="right"><input type="button" name="button2" id="button2" value="Tambah" onclick="addRowToTable();return false;"/></td>
          </tr>
          <tr>
            <td align="center">Jenis</td>
            <td align="center">Keterangan</td>
            <td align="center">Jenis</td>
            <td align="center">Keterangan</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="center"><input name="jenis[]" type="text" id="jenis[]" size="15" /></td>
            <td align="center"><input name="keterangan1[]" type="text" id="keterangan1[]" size="25" /></td>
            <td align="center"><input name="jenis2[]" type="text" id="jenis2[]" size="15" /></td>
            <td align="center"><input name="keterangan2[]" type="text" id="keterangan2[]" size="25" /></td>
            <td align="center" valign="middle"><img alt="del" src="del.png" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onclick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);setDisable('del')}" /></td>
          </tr>
        </table>
        </div>
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
        <td colspan="9">Pemeriksaan Radiologi</td>
        <td>:</td>
        <td colspan="25" rowspan="5">
        <div id="inObat2">
        <table width="554" height="86" border="1" align="left" cellpadding="2" id="tblObat2" style="border-collapse:collapse;">
          <tr>
            <td colspan="5" align="right"><input type="button" name="button3" id="button3" value="Tambah" onclick="addRowToTable2();return false;"/></td>
          </tr>
          <tr>
            <td align="center">Jenis Pemeriksaan</td>
            <td align="center">Bagian Yang Diperiksa</td>
            <td align="center"><p>&sum; Lembar</p></td>
            <td align="center">Keterangan</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="center"><label for="txt_obat[]"></label>
              <input name="jenis_pemeriksaan[]" type="text" id="jenis_pemeriksaan[]" size="15" /></td>
            <td align="center"><input name="bagian[]" type="text" id="bagian[]" size="25" /></td>
            <td align="center"><input name="lembar[]" type="text" id="lembar[]" size="15" /></td>
            <td align="center"><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
            <td align="center" valign="middle"><img alt="del" src="del.png" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onclick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable2(this);setDisable('del')}" /></td>
          </tr>
        </table>
        </div>
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
        <td colspan="9">Riwayat Alergi</td>
        <td>:</td>
        <td colspan="4"><input id="radio[]" type="radio" name="radio[1]" value="1" onclick="enable_text2(this)"/>
          Tidak</td>
        <td colspan="2"><input id="radio[]" type="radio" name="radio[1]" value="2" onclick="enable_text2(this)"  />
          <label for="radio">Ya,</label></td>
        <td colspan="4">Bila Ya Sebutkan</td>
        <td>:</td>
        <td colspan="14"><label for="textfield19"></label>
          <input name="sebut_alergi" type="text" id="sebut_alergi" size="30" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="9">Riwayat Operasi</td>
        <td>:</td>
        <td colspan="4"><input id="radio[]" type="radio" name="radio[2]" value="1" onclick="enable_text3(this)" />
          Tidak</td>
        <td colspan="2"><input id="radio[]" type="radio" name="radio[2]" value="2" onclick="enable_text3(this)" />
          <label for="radio2">Ya</label></td>
        <td colspan="4">Bila Ya Sebutkan</td>
        <td>:</td>
        <td colspan="14"><label for="textfield20"></label>
          <input name="sebut_operasi" type="text" id="sebut_operasi" size="30" /></td>
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
        <td colspan="16"><strong>III. IMUNISASI</strong></td>
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
        <td colspan="36" rowspan="8" align="center" valign="top"><table width="870" border="1" style="border-collapse:collapse">
          <tr>
            <td width="162" align="center"><strong>NAMA VAKSINASI</strong></td>
            <td width="83" align="center"><strong>YA / TIDAK</strong></td>
            <td width="120" align="center"><strong>BULAN / TAHUN</strong></td>
            <td width="259" align="center"><strong>NAMA VAKSINASI</strong></td>
            <td width="83" align="center"><strong>TA / TIDAK</strong></td>
            <td width="123" align="center"><strong>BULAN / TAHUN</strong></td>
          </tr>
          <tr>
            <td>BCG</td>
            <td align="center">
              <select name="status1" id="status1">
                <option>Ya</option>
                <option>Tidak</option>
              </select></td>
            <td align="center"><input name="tgl1" type="text" id="tgl1" onclick="gfPop.fPopCalendar(document.getElementById('tgl1'),depRange);" size="10"/></td>
            <td>Hib</td>
            <td align="center"><select name="status8" id="status8">
              <option>Ya</option>
              <option>Tidak</option>
            </select></td>
            <td align="center"><input name="tgl8" type="text" id="tgl8" onclick="gfPop.fPopCalendar(document.getElementById('tgl8'),depRange);" size="10"/></td>
          </tr>
          <tr>
            <td>POLIO</td>
            <td align="center"><select name="status2" id="status2">
              <option>Ya</option>
              <option>Tidak</option>
            </select></td>
            <td align="center"><input name="tgl2" type="text" id="tgl2" onclick="gfPop.fPopCalendar(document.getElementById('tgl2'),depRange);" size="10"/></td>
            <td>PNEUMOKOKUS (PCV) IPD</td>
            <td align="center"><select name="status9" id="status9">
              <option>Ya</option>
              <option>Tidak</option>
            </select></td>
            <td align="center"><input name="tgl9" type="text" id="tgl9" onclick="gfPop.fPopCalendar(document.getElementById('tgl9'),depRange);" size="10"/></td>
          </tr>
          <tr>
            <td>DPT</td>
            <td align="center"><select name="status3" id="status3">
              <option>Ya</option>
              <option>Tidak</option>
            </select></td>
            <td align="center"><input name="tgl3" type="text" id="tgl3" onclick="gfPop.fPopCalendar(document.getElementById('tgl3'),depRange);" size="10"/></td>
            <td>INFLUENZA</td>
            <td align="center"><select name="status10" id="status10">
              <option>Ya</option>
              <option>Tidak</option>
            </select></td>
            <td align="center"><input name="tgl10" type="text" id="tgl10" onclick="gfPop.fPopCalendar(document.getElementById('tgl10'),depRange);" size="10"/></td>
          </tr>
          <tr>
            <td>CAMPAK</td>
            <td align="center"><select name="status4" id="status4">
              <option>Ya</option>
              <option>Tidak</option>
            </select></td>
            <td align="center"><input name="tgl4" type="text" id="tgl4" onclick="gfPop.fPopCalendar(document.getElementById('tgl4'),depRange);" size="10"/></td>
            <td>MMR</td>
            <td align="center"><select name="status11" id="status11">
              <option>Ya</option>
              <option>Tidak</option>
            </select></td>
            <td align="center"><input name="tgl11" type="text" id="tgl11" onclick="gfPop.fPopCalendar(document.getElementById('tgl11'),depRange);" size="10"/></td>
          </tr>
          <tr>
            <td>HEPATITIS A</td>
            <td align="center"><select name="status5" id="status5">
              <option>Ya</option>
              <option>Tidak</option>
            </select></td>
            <td align="center"><input name="tgl5" type="text" id="tgl5" onclick="gfPop.fPopCalendar(document.getElementById('tgl5'),depRange);" size="10"/></td>
            <td>TYPOID</td>
            <td align="center"><select name="status12" id="status12">
              <option>Ya</option>
              <option>Tidak</option>
            </select></td>
            <td align="center"><input name="tgl12" type="text" id="tgl12" onclick="gfPop.fPopCalendar(document.getElementById('tgl12'),depRange);" size="10"/></td>
          </tr>
          <tr>
            <td>HEPATITIS B</td>
            <td align="center"><select name="status6" id="status6">
              <option>Ya</option>
              <option>Tidak</option>
            </select></td>
            <td align="center"><input name="tgl6" type="text" id="tgl6" onclick="gfPop.fPopCalendar(document.getElementById('tgl6'),depRange);" size="10"/></td>
            <td>&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td>VARICELLA</td>
            <td align="center"><select name="status7" id="status7">
              <option>Ya</option>
              <option>Tidak</option>
            </select></td>
            <td align="center"><input name="tgl7" type="text" id="tgl7" onclick="gfPop.fPopCalendar(document.getElementById('tgl7'),depRange);" size="10"/></td>
            <td>&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
        </table></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="25">Keterangan: * Coret yang tidak perlu</td>
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
        <td colspan="11"><strong>IV. Riwayat Prenatal Ibu</strong></td>
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
        <td colspan="9">Lama Kehamilan</td>
        <td>:</td>
        <td colspan="5"><input name="lama" type="text" id="lama" size="5" /> 
          Minggu</td>
        <td colspan="5">Riwayat Partus</td>
        <td>:</td>
        <td colspan="9"><label for="select24"></label>
          <select name="partus" id="partus">
            <option>Lahir Spontan</option>
            <option>Vacum / ILA / SC</option>
          </select></td>
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
        <td colspan="9">Komplikasi Kehamilan</td>
        <td>:</td>
        <td colspan="4"><input id="radio[]" type="radio" name="radio[3]" value="1" />
          <label for="radio3">Tidak</label></td>
        <td colspan="6"><input id="radio[]" type="radio" name="radio[3]" value="2" />
          <label for="radio4">Ada, Bila Ada Sebutkan</label></td>
        <td>:</td>
        <td colspan="12"><label for="textfield22"></label>
          <input name="sebut_kom" type="text" id="sebut_kom" size="35" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="9">Masalah Neonatus</td>
        <td>:</td>
        <td colspan="4"><input id="radio[]" type="radio" name="radio[4]" value="1" />
          <label for="radio3">Tidak</label></td>
        <td colspan="6"><input id="radio[]" type="radio" name="radio[4]" value="2" />
          <label for="radio4">Ada, Bila Ada Sebutkan</label></td>
        <td>:</td>
        <td colspan="12"><label for="textfield22"></label>
          <input name="sebut_neo" type="text" id="sebut_neo" size="35" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="9">Masalah Maternal</td>
        <td>:</td>
        <td colspan="4"><input id="radio[]" type="radio" name="radio[5]" value="1" />
          <label for="radio3">Tidak</label></td>
        <td colspan="6"><input id="radio[]" type="radio" name="radio[5]" value="2" />
          <label for="radio4">Ada, Bila Ada Sebutkan</label></td>
        <td>:</td>
        <td colspan="12"><label for="textfield22"></label>
          <input name="sebut_mate" type="text" id="sebut_mate" size="35" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="9">&nbsp;</td>
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
        <td colspan="23"><strong>V. Pola Makan &amp; Riwayat Tumbuh Kembang Anak</strong></td>
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
        <td colspan="9">Berat Badan Saat Lahir</td>
        <td>:</td>
        <td colspan="5"><input name="berat" type="text" id="berat" size="5" />
          Gramm</td>
        <td colspan="5">Makanan Pokok</td>
        <td>:</td>
        <td colspan="5"><label for="select26"></label>
          <select name="makanan" id="makanan">
            <option>Nasi</option>
            <option>Roti</option>
            <option>Kentang</option>
          </select></td>
        <td colspan="4">Tengurap</td>
        <td>:</td>
        <td colspan="5"><input name="tengurap" type="text" id="tengurap" size="5" />
Bln/Thn</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="9">Panjang Badan Saat Lahir</td>
        <td>:</td>
        <td colspan="5"><input name="panjang" type="text" id="panjang" size="5" /> 
          Cm</td>
        <td colspan="5">Porsi Makan</td>
        <td>:</td>
        <td colspan="5"><label for="select27"></label>
          <select name="porsi" id="porsi">
            <option>Besar</option>
            <option>Kecil</option>
          </select></td>
        <td colspan="4">Duduk</td>
        <td>:</td>
        <td colspan="5"><input name="duduk" type="text" id="duduk" size="5" />
Bln/Thn</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="9">Pemberian ASI Sampai</td>
        <td>:</td>
        <td colspan="5"><input name="asi" type="text" id="asi" size="5" /> 
          Bln/Thn</td>
        <td colspan="5">Frekuensi Makan</td>
        <td>:</td>
        <td colspan="5"><label for="select28"></label>
          <select name="frekuensi" id="frekuensi">
            <option>1x</option>
            <option>2x</option>
            <option>3x</option>
            <option>4x</option>
          </select></td>
        <td colspan="4">Merangkak</td>
        <td>:</td>
        <td colspan="5"><input name="merangkak" type="text" id="merangkak" size="5" />
Bln/Thn</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="9">Pemberian Susu Formula, Dimulai Umur</td>
        <td>:</td>
        <td colspan="5"><input name="formula" type="text" id="formula" size="5" />
Bln/Thn</td>
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
        <td colspan="4">Berdiri</td>
        <td>:</td>
        <td colspan="5"><input name="berdiri" type="text" id="berdiri" size="5" />
Bln/Thn</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="9">Makan Bubur Susu, Dimulai Umur</td>
        <td>:</td>
        <td colspan="5"><input name="susu" type="text" id="susu" size="5" />
Bln/Thn</td>
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
        <td colspan="4">Jalan</td>
        <td>:</td>
        <td colspan="5"><input name="jalan" type="text" id="jalan" size="5" />
Bln/Thn</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="9">Makan Bubur Cincang, Dimulai Umur</td>
        <td>:</td>
        <td colspan="5"><input name="cincang" type="text" id="cincang" size="5" />
Bln/Thn</td>
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
        <td colspan="9">Makan Nasi Tim, Dimulai Umur</td>
        <td>:</td>
        <td colspan="5"><input name="tim" type="text" id="tim" size="5" />
Bln/Thn</td>
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
        <td colspan="9">Makan Nasi, Mulai Umur</td>
        <td>:</td>
        <td colspan="5"><input name="nasi" type="text" id="nasi" size="5" />
Bln/Thn</td>
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
        <td colspan="9">Bicara</td>
        <td>:</td>
        <td colspan="10"><label for="select25"></label>
          <select name="bicara" id="bicara">
            <option>Normal</option>
            <option>Pelo</option>
            <option>Gagap</option>
            <option>Bisu</option>
            <option>Tidak Dipahami</option>
          </select></td>
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
        <td colspan="38" align="center"><strong><u>PEMERIKSAAN FISIK</u></strong></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="10"><strong>V. Panca Indra</strong></td>
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
        <td colspan="9">Penglihatan</td>
        <td>:</td>
        <td colspan="7"><label for="select29"></label>
          <select name="penglihatan" id="penglihatan">
            <option>Normal</option>
            <option>Pandangan Kabur</option>
            <option>Buta</option>
            <option>Pandangan Ganda</option>
            <option>Juling Kanan</option>
            <option>Juling Kiri</option>
          </select></td>
        <td colspan="3">&nbsp;</td>
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
        <td colspan="9">Alat Bantu</td>
        <td>:</td>
        <td colspan="5"><label for="select30"></label>
          <select name="alat_bantu" id="alat_bantu">
            <option>Kacamata</option>
            <option>Kontak Lensa</option>
          </select></td>
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
        <td colspan="9">Pendengaran</td>
        <td>:</td>
        <td colspan="17"><label for="select31"></label>
          <select name="pendengaran" id="pendengaran">
            <option>Normal</option>
            <option>OMA</option>
            <option>OMP</option>
            <option>Tuli</option>
            <option>Alat bantu pendengaran Kanan</option>
            <option>Alat bantu pendengaran Kiri</option>
          </select></td>
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
    
</html>
