<?
include "../koneksi/konek.php";
$id=$_REQUEST['id'];
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUsr'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,IFNULL(pg.nama,'-') AS dr_rujuk
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
//include "setting.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css" />
<link type="text/css" rel="stylesheet" href="js/jquery.timeentry.css" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <!-- untuk ajax-->
        <script type="text/javascript" src="../theme/js/ajax.js"></script>
        <script type="text/javascript" src="../jquery.js"></script>
        <script type="text/javascript" src="../jquery.form.js"></script>
        <script type="text/javascript" src="js/jquery.timeentry.js"></script>
        <script type="text/javascript" src="js/jquery.timeentry.min.js"></script>
        <script type="text/javascript">

</script>

        <!-- end untuk ajax-->
        <title>RESUM KEPERAWATAN</title>
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
<title>resume kep</title>
<style type="text/css">
<!--
.style2 {font-size: 10px}
-->
</style>
<link rel="stylesheet" type="text/css" href="../css/jquery-ui-1.8.4.custom.css" />
<link rel="stylesheet" type="text/css" href="../css/form.css" />
<!--<link rel="stylesheet" type="text/css" href="../include/jquery/jquery-ui-timepicker-addon.css" />
<script src="../js/jquery-1.8.3.js"></script>-->
<script src="../include/jquery/ui/jquery.ui.core.js"></script>
<script src="../include/jquery/ui/jquery.ui.widget.js"></script>
<script src="../include/jquery/ui/jquery.ui.datepicker.js"></script>
<script src="../include/jquery/jquery-ui-timepicker-addon.js"></script>
<script src="../include/jquery/external/jquery.bgiframe-2.1.2.js"></script>


<?
include "setting.php";
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

<body onload="tanggalan();jam();">
<iframe height="72" width="130" name="sort"
                    id="sort"
                    src="../theme/dsgrid_sort.php" scrolling="no"
                    frameborder="0"
                    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
            </iframe>
             <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js" src="../theme/popcjs.php" scrolling="no" frameborder="1"
                style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
        </iframe>
<div id="tampil_input" align="center" style="display:none">
<form name="form1" id="form1" action="14.resume_kep_act.php">
<input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    			<input type="hidden" name="id" id="id"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
<table width="755" border="0" cellpadding="4" style="font:12px tahoma;">
  <tr>
    <td colspan="3" align="center" valign="middle"><img src="Form_RSU_2/lap_med_chckup_stat_bdh_wnta_clip_image003.png" alt="" width="350" height="105" /></td>
    <td colspan="2" rowspan="2" align="right" valign="bottom"><table width="383" border="0" cellpadding="4" style="border:1px solid #000000;">
      <tr>
        <td width="110">Nama Pasien </td>
        <td width="7">:</td>
        <td width="232"><?=$nama;?> (<?=$sex;?>)</td>
        </tr>
      <tr>
        <td>Tanggal Lahir </td>
        <td>:</td>
        <td><?=$tgl;?> /Usia : <?=$umur;?> th </td>
        </tr>
      <tr>
        <td>No. RM </td>
        <td>:</td>
        <td><?=$noRM;?> No. Registrasi : <?=$no_reg;?></td>
        </tr>
      <tr>
        <td>Ruang Rawat/Kelas </td>
        <td>:</td>
        <td><?=$kamar;?> / <?=$kelas;?></td>
        </tr>
      <tr>
        <td height="23">Alamat</td>
        <td>:</td>
        <td><?=$alamat;?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3"><strong>RESUME KEPERAWATAN<br/>SUMMARY LETTER<br/>DIISI OLEH PERAWAT / BIDAN</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td width="344">Keadaan saat pulang</td>
    <td width="6">:</td>
    <td colspan="3">
      <table>
        <tr>
          <td width="180">
            Tekanan darah
            <!--<input name="tekanan_darah" type="text" id="tekanan_darah" size="3" />--><?=$tensi?>
            mmHg </td>
          <td width="173">
            Pernafasan
            <input name="pernafasan" type="text" id="pernafasan" size="3" />
            X/menit </td>
          <td width="139">
            Nadi
            <!--<input name="nadi" type="text" id="nadi" size="3" />--><?=$nadi?>
            X/menit </td>
          <td width="111">
            Suhu
            <!--<input name="suhu" type="text" id="suhu" size="3" />--><?=$suhu?>     &deg;
            C
            </td>
          </tr>
        </table>
      </td>
  </tr>
  <tr>
    <td>Diet / Nutrisi</td>
    <td>:</td>
    <td colspan="3">
    <table width="625">
    <tr>
    <td width="77">
    <input id="radio[]" type="radio" name="radio[0]" value="1" />Oral
    </td>
    <td width="79">
    <input id="radio[]" name="radio[0]" type="radio" value="2" />NGT
    </td>
    <td width="308">
    <input name="radio[0]" type="radio" id="radio[]" onclick="tampil(this);" value="3" />Diet Khusus
    <div id="status" style="display: none">Jelaskan <input style="display:inline;" name="_diet" type="text" size="35" id="_diet"/>
    </div>
    <td width="141">
    <input id="radio[]" type="radio" name="radio[0]" onclick="tampil2(this);" value="4" />
    Batas Cairan
    <div id="status2" style="display: none"><input style="display:inline;" name="_batas" type="text" size="10" id="_batas"/></div></td>
    </tr>
     </table>
</td>
  </tr>
  <tr>
    <td>B.A.B.</td>
    <td>:</td>
    <td colspan="3">
    <table width="625">
    <tr>
    <td width="77"><input id="radio[]" type="radio" name="radio[1]" value="1" />Normal
    </td>
    <td width="152"><input id="radio[]" type="radio" name="radio[1]" value="2" />Ileostomy/coloctomy
    </td>
    <td width="169"><input id="radio[]" type="radio" name="radio[1]" value="3" />Inkontinensia Urine
    </td>
    <td width="207"><input id="radio[]" type="radio" name="radio[1]" value="4" />Inkontinensia Alvi
    </td>
    </tr>
    </table>
</td>
  </tr>
  <tr>
    <td>B.A.K.</td>
    <td>:</td>
    <td colspan="3">
    <table width="626">
    <tr>
    <td width="76">
    <input id="radio[]" type="radio" name="radio[2]" value="1" />Normal
    </td>
    <td width="538">
    <input id="radio[]" type="radio" name="radio[2]" value="2" onclick="tampil3(this);" />
    Katerer
    <div id="status3" style="display: none">Tgl pemasangan terakhir<input name="_tgl" type="text" size="10" id="_tgl" onclick="gfPop.fPopCalendar(document.getElementById('_tgl'),depRange);" /></div>

    </td>
    </tr>
    </table>
</td>
  </tr>
  <tr>
    <td><em>DIISI OLEH BIDAN</em></td>
    <td>&nbsp;</td>
    <td width="34">&nbsp;</td>
    <td width="367">&nbsp;</td>
    <td width="248">&nbsp;</td>
  </tr>
  <tr>
    <td>Kontraksi Uterus</td>
    <td>:</td>
    <td colspan="3">
    <table width="626">
    <tr>
    <td width="76">
    <input id="radio[]" type="radio" name="radio[3]" value="1" />Tidak
    </td>
    <td width="97">
    <input id="radio[]" type="radio" name="radio[3]" value="2" />Baik
    </td>
    <td width="437">
    Tinggi Fundus Uteri
      <label for="hasil2"></label>
      <input type="text" name="_tinggi" id="_tinggi" /></td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td>Vulva</td>
    <td>:</td>
    <td colspan="3">
    <table width="628">
    <tr>
    <td width="76">
    <input id="radio[]" type="radio" name="radio[4]" value="1" />Bersih
    </td>
    <td width="91">
    <input id="radio[]" type="radio" name="radio[4]" value="2" />Kotor
    </td>
    <td width="85">
    <input id="radio[]" type="radio" name="radio[4]" value="3" />Bengkak
    </td>
    <td width="129">
    <input id="radio[]" type="radio" name="radio[4]" value="4" />Luka Perineum
    </td>
    <td width="108">
    <input id="radio[]" type="radio" name="radio[4]" value="5" />Kering
    </td>
    <td width="109">
    <input id="radio[]" type="radio" name="radio[4]" value="6" />Basah
    </td>
    </tr>
    </table>
</td>
  </tr>
  <tr>
    <td>Lochea</td>
    <td>:</td>
    <td colspan="3">
      <table>
        <tr>
          <td width="77">
            <input id="radio[]" type="radio" name="radio[5]" value="1" />Banyak
            </td>
          <td width="111">
            <input id="radio[]" type="radio" name="radio[5]" value="2" />Sedikit
            </td>
          <td width="213">
            Warna :
            <label for="hasil3"></label>
            <input type="text" name="_warna" id="_warna" /></td>
          <td width="205">
            Bau :
            <label for="hasil4"></label>
            <input type="text" name="_bau" id="_bau" /></td>
          </tr>
        </table>
  </td>
  </tr>
  <tr>
    <td>Luka-luka Operasi</td>
    <td>:</td>
    <td colspan="3">
      <table>
        <tr>
          <td width="86">
            <input id="radio[]"type="radio" name="radio[6]" value="1" />Bersih
            </td>
          <td width="141">
            <input id="radio[]" type="radio" name="radio[6]" value="2" />Kering
            </td>
          <td width="385">
            <input id="radio[]" type="radio" name="radio[6]" onclick="tampil4(this);" value="3" />
            Ada cairan dari lika
            <div id="status4" style="display: none"><label for="_cairan">Jelaskan</label><input style="display:inline;" name="_cairan" type="text" id="_cairan"/></div>
            
            <!--<input type="text" name="textfield11" id="textfield11" />--></td>
          </tr>
        </table>
      </td>
  </tr>
  <tr>
    <td>Transfer &amp; Mobilisasi</td>
    <td>:</td>
    <td colspan="3">
    <table>
    <tr>
    <td width="85">
    <input id="radio[]" type="radio" name="radio[7]" value="1" />Mandiri
    </td>
    <td width="142">
    <input id="radio[]" type="radio" name="radio[7]" value="2" />Dibantu Sebagian
    </td>
    <td width="384">
    <input id="radio[]" type="radio" name="radio[7]" value="3" />Dibantu Penuh
    </td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td>Alat bantu</td>
    <td>:</td>
    <td colspan="3">
    <table>
    <tr>
    <td width="85">
    <input id="radio[]" type="radio" name="radio[8]" value="1" />Tongkat
    </td>
    <td width="142">
    <input id="radio[]" type="radio" name="radio[8]" value="2" />Kursi Roda
    </td>
    <td width="161">
    <input id="radio[]" type="radio" name="radio[8]" value="3" />Troley/Kereta Dorong
    </td>
    <td width="220">
    <input id="radio[]" type="radio" name="radio[8]" value="4" onclick="tampil5(this);" />    
    Lain-Lain
    <div id="status5" style="display: none"><input style="display:inline;" name="_lain" type="text" id="_lain"/></div>
    </td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td colspan="5">EDUKASI/ PENYULUHAN KESEHATAN YANG SUDAH DIBERIKAN </td>
  </tr>
  <tr>
    <td colspan="5">
    <table>
    <tr><td width="15"></td>
    <td width="189"><input id="c_chk[]" type="checkbox" name="c_chk[0]" value="Penyakit dan pengobatan" />
      Penyakit dan pengobatan    
    </td>
    <td width="189"><input id="c_chk[]" type="checkbox" name="c_chk[1]" value="Perawatan dirumah" />
      Perawatan dirumah    
    </td>
    <td width="194"><input id="c_chk[]" type="checkbox" name="c_chk[2]" value="Perawatan ibu dan bayi" />
      Perawatan ibu dan bayi
    </td>
    <td width="226"><input id="c_chk[]" type="checkbox" name="c_chk[3]" value="Mengatasi Nyeri" />
      Mengatasi Nyeri
    </td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td colspan="5">
    <table>
    <tr><td width="14"></td>
    <td width="191"><input id="c_chk[]" type="checkbox" name="c_chk[4]" value="Perawatan Luka" />
      Perawatan Luka
    </td>
    <td width="389"><input id="c_chk[]" type="checkbox" name="c_chk[5]" value="Persiapan lingkungan dan fasilitas untuk perawatan di rumah" />
      Persiapan lingkungan dan fasilitas untuk perawatan di rumah
    </td>
    <td width="223"><input id="c_chk[]" type="checkbox" name="c_chk[6]" value="Nasehat Keluarga Berencana" />
      Nasehat Keluarga Berencana
    </td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td colspan="5">DIAGNOSA KEPERAWATAN SELAMA DIRAWAT</td>
  </tr>
  <tr>
    <td colspan="5">
    <table>
    <tr>
    <td width="411">
    1.
      <label for="anjuran1"></label>
      <input name="diagnosa1" type="text" id="diagnosa1" size="50" /></td>
    <td width="414">
    2.
      <label for="diagnosa2"></label>
      <input name="diagnosa2" type="text" id="diagnosa2" size="50" /></td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td colspan="5">ANJURAN</td>
  </tr>
  <tr>
    <td colspan="5">
    <table>
    <tr>
    <td width="412">
    1.
      <label for="textfield"></label>
      <input name="anjuran1" type="text" id="anjuran1" size="50" /></td>
    <td width="413">
    3.
      <input name="anjuran3" type="text" id="anjuran3" size="50" /></td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td colspan="5">
    <table>
    <tr>
    <td width="412">
    2.
      <input name="anjuran2" type="text" id="anjuran2" size="50" /></td>
    <td width="413">
    4.
      <input name="anjuran4" type="text" id="anjuran4" size="50" /></td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td colspan="5">BARANG DAN HASIL PEMERIKSAAN YANG DISERAHKAN KEPADA KELUARGA</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">
    <table>
    <tr>
    <td width="27">1</td>
    <td width="153">Hasil Lab</td>
    <td width="9">:</td>
    <td width="100"><label for="lab"></label>
      <input name="lab" type="text" id="lab" size="3" />
      Lembar</td>
    <td width="26">5</td>
    <td width="150">Surat Asuransi</td>
    <td width="12">:</td>
    <td width="117"><label for="surat_a"></label>
      <select name="surat_a" id="surat_a">
        <option value="">Pilih</option>
        <option>Ada</option>
        <option>Tidak</option>
      </select></td>
    <td width="206">Hasil Pemeriksaan diluar RS</td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td colspan="5">
    <table>
    <tr>
    <td width="30">&nbsp;</td>
    <td width="150">Foto Rontgen</td>
    <td width="11">:</td>
    <td width="105"><input name="foto" type="text" id="foto" size="3" />
      Lembar</td>
    <td width="19">&nbsp;</td>
    <td width="149">Summary pasien pulang</td>
    <td width="13">:</td>
    <td width="119"><select name="summary" id="summary">
      <option value="">Pilih</option>
      <option>Ada</option>
      <option>Tidak</option>
    </select></td>
    <td width="204">1.
      <label for="hasil1"></label>
      <input type="text" name="hasil1" id="hasil1" /></td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td colspan="5">
    <table>
    <tr>
    <td width="31">&nbsp;</td>
    <td width="149">CT Scan</td>
    <td width="10">:</td>
    <td width="106"><input name="scan" type="text" id="scan" size="3" />
      Lembar</td>
    <td width="20">&nbsp;</td>
    <td width="148">Buku Bayi</td>
    <td width="13">:</td>
    <td width="120"><select name="buku" id="buku">
      <option value="">Pilih</option>
      <option>Ada</option>
      <option>Tidak</option>
    </select></td>
    <td width="203">2.
      <input type="text" name="hasil2" id="hasil2" /></td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td colspan="5">
    <table>
    <tr>
    <td width="31">&nbsp;</td>
    <td width="149">MRI/MRA</td>
    <td width="9">:</td>
    <td width="107"><input name="mri" type="text" id="mri" size="3" />
      Lembar</td>
    <td width="19">&nbsp;</td>
    <td width="150">Kartu Golongan Darah Bayi</td>
    <td width="12">:</td>
    <td width="120"><select name="kartu" id="kartu">
      <option value="">Pilih</option>
      <option>Ada</option>
      <option>Tidak</option>
    </select></td>
    <td width="203">3.
      <input type="text" name="hasil3" id="hasil3" /></td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td colspan="5">
    <table>
    <tr>
    <td width="29">&nbsp;</td>
    <td width="151">Hasil USG</td>
    <td width="9">:</td>
    <td width="107"><input name="usg" type="text" id="usg" size="3" />
      Lembar</td>
    <td width="18">&nbsp;</td>
    <td width="151">Surat keterangan Lahir</td>
    <td width="12">:</td>
    <td width="119"><select name="skl" id="skl">
      <option value="">Pilih</option>
      <option>Ada</option>
      <option>Tidak</option>
    </select></td>
    <td width="204">4.
      <input type="text" name="hasil4" id="hasil4" /></td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td colspan="5">
    <table>
    <tr>
    <td width="27">&nbsp;</td>
    <td width="155">Surat Keterangan Sakit</td>
    <td width="9">:</td>
    <td width="89"><select name="surat" id="surat">
      <option value="">Pilih</option>
      <option>Ada</option>
      <option>Tidak</option>
    </select></td>
    <td width="37">&nbsp;</td>
    <td width="148">Bayi diserahkan oleh</td>
    <td width="12">:</td>
    <td width="119"><input name="serah" type="text" id="serah" size="15" /></td>
    <td width="204">5.
      <input type="text" name="hasil5" id="hasil5" /></td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td colspan="5">
    <table>
    <tr>
    <td width="5">&nbsp;</td>
    <td width="5">&nbsp;</td>
    <td width="5">&nbsp;</td>
    <td width="5">&nbsp;</td>
    <td width="297">&nbsp;</td>
    <td width="149">Lain-lain</td>
    <td width="11">:</td>
    <td width="122"><input name="lain" type="text" id="lain" size="15" /></td>
    <td width="201">&nbsp;</td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td>TERAPI PULANG</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">
    <div id="inObat">
    <table align="center" width="781" border="1" id="tblObat" cellpadding="2" style="border-collapse:collapse;">
       <tr>
        <td colspan="13" align="right"><input type="button" name="button" id="button" value="Tambah" onClick="addRowToTable();return false;"/></td>
        </tr>
      <tr>
        <td rowspan="2" align="center">Nama Obat</td>
        <td rowspan="2" align="center">Jumlah</td>
        <td rowspan="2" align="center">Dosis</td>
        <td rowspan="2" align="center">Frekuensi</td>
        <td rowspan="2" align="center">Cara Pemberian</td>
        <td colspan="6" align="center">Jam Pemberian</td>
        <td rowspan="2" align="center">Petunjuk Khusus</td>
        <td rowspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        </tr>
      <tr>
        <td align="center"><label for="txt_obat[]"></label>
          <input name="txt_obat[]" type="text" class="inputan" id="txt_obat[]" /></td>
        <td align="center"><input name="txt_jumlah[]" type="text" id="txt_jumlah[]" size="5" /></td>
        <td align="center"><input name="txt_dosis[]" type="text" id="txt_dosis[]" size="5" /></td>
        <td align="center"><input name="txt_frek[]" type="text" id="txt_frek[]" size="5" /></td>
        <td align="center"><input name="txt_beri[]" type="text" class="inputan" id="txt_beri[]" /></td>
        <td align="center"><input name="txt_jam1[]" type="text" id="txt_jam1[]" size="5" /></td>
        <td align="center"><input name="txt_jam2[]" type="text" id="txt_jam2[]" size="5" /></td>
        <td align="center"><input name="txt_jam3[]" type="text" id="txt_jam3[]" size="5" /></td>
        <td align="center"><input name="txt_jam4[]" type="text" id="txt_jam4[]" size="5" /></td>
        <td align="center"><input name="txt_jam5[]" type="text" id="txt_jam5[]" size="5" /></td>
        <td align="center"><input name="txt_jam6[]" type="text" id="txt_jam6[]" size="5" /></td>
        <td align="center"><input name="txt_petunjuk[]" type="text" class="inputan" id="txt_petunjuk[]" /></td>
        <td align="center" valign="middle"><img alt="del" src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);setDisable('del')}"></td>
      </tr>
    </table>
    </div>
    </td>
  </tr>
  <tr>
    <td>KONTROL KEMBALI TANGGAL</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">
    <div id="inObat2">
    
    <table border=1 align="center" class="tanggal" id="datatable" style="border-collapse:collapse">
<tr bgcolor=#ababab>
  <td colspan="5" align="right" valign="middle" bgcolor="#FFFFFF"><input type="button" value="Tambah" onclick="tambahrow()" /></td>
  </tr>
<tr bgcolor=#ababab>
<td align="center" bgcolor="#FFFFFF">Tanggal</td>
<td align="center" bgcolor="#FFFFFF">Hari</td>
<td align="center" bgcolor="#FFFFFF">Jam</td>
<td align="center" bgcolor="#FFFFFF">Nama Dokter</td>
<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
</tr>
<tr>
<td><input type='text' class="tgl" name='tgl[]' id='tgl0'></td>
<td><select id="hari" name='hari[]'><option>Senin</option><option>Selasa</option><option>Rabu</option><option>Kamis</option><option>Jumat</option><option>Sabtu</option><option>Minggu</option></select></td>
<td><input type='text' class="jam" name="jam[]" id="jam0"></td>
<td><!--<input type="text" id="dokter" name='dokter[]'>--><select id="dokter" name='dokter[]'><?php
          $sql="select * from b_ms_pegawai where spesialisasi_id<>0";
          $query = mysql_query ($sql);
          while($data = mysql_fetch_array($query)){
		  ?>
          <option value="<?php echo $data['id'];?>" ><?php echo $data['nama']?></option>
          <?php
    	  }
	      ?></select></td>

<td><!--<input type='button' value='Delete' onclick='del(this)' />--><img alt="del" src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onclick=del(this) /></td>
</tr>
</table>
    <br>

      <!--<table align="center" width="666" border="1" id="tgl" cellpadding="2" style="border-collapse:collapse;">
        <tr>
          <td colspan="5" align="right"><input type="button" name="button" id="button" value="Tambah" onClick="tambah();return false;"/></td>
          </tr>
        <tr>
          <td align="center">Tanggal</td>
          <td align="center">Hari</td>
          <td align="center">Jam</td>
          <td align="center">Nama Dokter</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td align="center"><label for="tgl[]"></label>
            <input name="tgl[]" type="text" id="tgl[]" class="tgl" size="15" /></td>
          <td align="center"><label for="hari"></label>
            <select name="hari[]" id="hari[]">
              <option>Senin</option>
              <option>Selasa</option>
              <option>Rabu</option>
              <option>Kamis</option>
              <option>Jumat</option>
              <option>Sabtu</option>
              <option>Minggu</option>
            </select></td>
          <td align="center"><input name="jam[]" type="text" id="jam[]" size="15" /></td>
          <td align="center"><input name="dokter[]" type="text" id="dokter[]" size="30" /></td>
          <td align="center" valign="middle"><img alt="del" src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable2(this);setDisable('del')}"></td>
          </tr>
        </table>-->
        </div>
    </td>
    </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
    <td></td>
  </tr>
  <tr>
    <td colspan="5">
      <table>
        <tr>
          <td width="65"></td>
          <td width="345">
            Perawat Yang Menyerahkan
          </td>
          <td width="362">
            Dokter yang merawat/ ruangan
          </td>
          <td width="225">
            Yang Menerima,
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td height="76" colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">
      <table>
        <tr>
          <td width="68"></td>
          <td width="353">
            Nama Jelas & tanda tangan
          </td>
          <td width="326"><strong><u><?=$dokter;?></u></strong></td>
          <td width="250">
            Nama Jelas & tanda tangan
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="center"><input type="button" name="bt_save" id="bt_save" class="tblTambah" value="Simpan" onclick="return simpan()" />&nbsp;
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
    parent.alertsize(document.body.scrollHeight);
}


        function simpan(action){
            if(ValidateForm('surat,surat_a,summary,buku,kartu,skl')){
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
            //var sisip = a.getRowId(a.getSelRow()).split('|');
			//$('diagnosa1').val(a.cellsGetValue(a.getSelRow(),3));
			//$('#id').val(sisip[0]);
			//$('#inObat').load("form_input_obat.php?id="+sisip[0]);
			//$('#act').val('edit');
			
					
            var sisip = a.getRowId(a.getSelRow()).split('|');
			 var p="id*-*"+sisip[0]+"*|*tekanan_darah*-*"+sisip[1]+"*|*pernafasan*-*"+sisip[2]+"*|*nadi*-*"+sisip[3]+"*|*suhu*-*"+sisip[4]+"*|*_diet*-*"+sisip[6]+"*|*_batas*-*"+sisip[7]+"*|*_tgl*-*"+sisip[10]+"*|*_tinggi*-*"+sisip[12]+"*|*_warna*-*"+sisip[15]+"*|*_bau*-*"+sisip[16]+"*|*_cairan*-*"+sisip[18]+"*|*_lain*-*"+sisip[21]+"*|*diagnosa1*-*"+sisip[23]+"*|*diagnosa2*-*"+sisip[24]+"*|*anjuran1*-*"+sisip[25]+"*|*anjuran2*-*"+sisip[26]+"*|*anjuran3*-*"+sisip[27]+"*|*anjuran4*-*"+sisip[28]+"*|*lab*-*"+sisip[29]+"*|*foto*-*"+sisip[30]+"*|*scan*-*"+sisip[31]+"*|*mri*-*"+sisip[32]+"*|*usg*-*"+sisip[33]+"*|*surat*-*"+sisip[34]+"*|*surat_a*-*"+sisip[35]+"*|*summary*-*"+sisip[36]+"*|*buku*-*"+sisip[37]+"*|*kartu*-*"+sisip[38]+"*|*skl*-*"+sisip[39]+"*|*serah*-*"+sisip[40]+"*|*lain*-*"+sisip[41]+"*|*hasil1*-*"+sisip[42]+"*|*hasil2*-*"+sisip[43]+"*|*hasil3*-*"+sisip[44]+"*|*hasil4*-*"+sisip[45]+"*|*hasil5*-*"+sisip[46]+"";
			 centang(sisip[5]);
			 centang2(sisip[8]);
			 centang3(sisip[9]);
			 centang4(sisip[11]);
			 centang5(sisip[13]);
			 centang6(sisip[14]);
			 centang7(sisip[17]);
			 centang8(sisip[19]);
			 centang9(sisip[20]);
			 cek(sisip[22]);
			 
			 $('#inObat').load("14.form_terapi_pulang.php?type=ESO&id="+sisip[0]);
			 $('#inObat2').load("14.form_kembali_kontrol.php?type=ESO&id="+sisip[0]);
			 $('#act').val('edit');
			 
			 
			 //$('#kronologis').val(sisip[2]);
			 //$('#tindakan').val(sisip[13]);
			 
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
            var id = document.getElementById("id").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(id==''){
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
            $('#inObat').load("14.form_terapi_pulang.php");
			$('#inObat2').load("14.form_kembali_kontrol.php");
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
            a.loadURL("14.resume_kep_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Data Resume Keperawatan");
        a.setColHeader("NO,NO RM,DIAGNOSA 1,DIAGNOSA 2,TGL INPUT,PENGGUNA");
        a.setIDColHeader(",no_rm,,,");
        a.setColWidth("20,80,150,150,50,120");
        a.setCellAlign("center,center,center,center,center,center");
        a.setCellHeight(20);
        a.setImgPath("../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("14.resume_kep_util.php?idPel=<?=$idPel?>");
        a.Init();
		
		function tambah(){
			resetF();
			$('#tampil_input').slideDown(1000,function(){
		toggle();
		});
			
			}
		
		
		/*function cetak()
		{
			var id = document.getElementById("id").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(id=='')
			{
				alert("Pilih data terlebih dahulu untuk di cetak");
			}
			else
			{	
				window.open("14.resume_kep.php?id="+id+"&idKunj=<?=$idKunj?>&idPel=<?=$idPel?>&idUser=<?=$idUser?>","_blank");
				document.getElementById('id').value="";
			}
			
		}*/
		
		function cetak(){
		 var rowid = document.getElementById("id").value;
		 if(rowid==""){
				var rowidx =a.getRowId(a.getSelRow()).split('|');
				rowid=rowidx[0];
			 }
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			//if(rowid==''){
//					alert("Pilih data terlebih dahulu");
//				}else{	
		window.open("14.resume_kep.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUsr=<?=$idUsr?>","_blank");
				//}
		}
		
function centang(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['radio[0]'];
		var list2 = document.form1.elements['radio[0]'];
		var list3 = document.form1.elements['radio[0]'];
		var list4 = document.form1.elements['radio[0]'];
		
		
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
		if ( list4.length > 3 )
		{
		 for (i = 3; i < list4.length; i++)
			{
			  if (list4[i].value==list[3])
			  {
			   list4[i].checked = true;
			  }
		  }
		}
	}

function centang2(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['radio[1]'];
		var list2 = document.form1.elements['radio[1]'];
		var list3 = document.form1.elements['radio[1]'];
		var list4 = document.form1.elements['radio[1]'];
		
		
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
		if ( list4.length > 3 )
		{
		 for (i = 3; i < list4.length; i++)
			{
			  if (list4[i].value==list[3])
			  {
			   list4[i].checked = true;
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
		var list3 = document.form1.elements['radio[4]'];
		var list4 = document.form1.elements['radio[4]'];
		var list5 = document.form1.elements['radio[4]'];
		var list6 = document.form1.elements['radio[4]'];
		
		
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
		if ( list4.length > 3 )
		{
		 for (i = 3; i < list4.length; i++)
			{
			  if (list4[i].value==list[3])
			  {
			   list4[i].checked = true;
			  }
		  }
		}
		if ( list5.length > 4 )
		{
		 for (i = 4; i < list5.length; i++)
			{
			  if (list5[i].value==list[4])
			  {
			   list5[i].checked = true;
			  }
		  }
		}
		if ( list6.length > 5 )
		{
		 for (i = 5; i < list6.length; i++)
			{
			  if (list6[i].value==list[5])
			  {
			   list6[i].checked = true;
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
	
	function centang7(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['radio[6]'];
		var list2 = document.form1.elements['radio[6]'];
		var list3 = document.form1.elements['radio[6]'];
	
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
	
	function centang8(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['radio[7]'];
		var list2 = document.form1.elements['radio[7]'];
		var list3 = document.form1.elements['radio[7]'];
	
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
	
	function centang9(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['radio[8]'];
		var list2 = document.form1.elements['radio[8]'];
		var list3 = document.form1.elements['radio[8]'];
		var list4 = document.form1.elements['radio[8]'];
	
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
		if ( list4.length > 3 )
		{
		 for (i = 3; i < list4.length; i++)
			{
			  if (list4[i].value==list[3])
			  {
			   list4[i].checked = true;
			  }
		  }
		}
	}
	
	function cek(tes){
		var list=tes.split('*=*');
		var list1 = document.form1.elements['c_chk[]'];
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			var val=list[0].split(',');
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
                el.name = 'txt_obat[]';
                el.id = 'txt_obat[]';
            }else{
                el = document.createElement('<input name="txt_obat[]"/>');
            }
            el.type = 'text';
            el.className = 'inputan';
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
                el.name = 'txt_jumlah[]';
                el.id = 'txt_jumlah[]';
            }else{
                el = document.createElement('<input name="txt_jumlah[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;
            

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(2);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_dosis[]';
                el.id = 'txt_dosis[]';
            }else{
                el = document.createElement('<input name="txt_dosis[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(3);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_frek[]';
                el.id = 'txt_frek[]';
            }else{
                el = document.createElement('<input name="txt_frek[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;
            

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(4);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_beri[]';
                el.id = 'txt_beri[]';
            }else{
                el = document.createElement('<input name="txt_beri[]"/>');
            }
            el.type = 'text';
            el.value = '';
            el.className = 'inputan';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

// right cell
            var cellRight = row.insertCell(5);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_jam1[]';
                el.id = 'txt_jam1[]';
            }else{
                el = document.createElement('<input name="txt_jam1[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

// right cell
            var cellRight = row.insertCell(6);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_jam2[]';
                el.id = 'txt_jam2[]';
            }else{
                el = document.createElement('<input name="txt_jam2[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(7);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_jam3[]';
                el.id = 'txt_jam3[]';
            }else{
                el = document.createElement('<input name="txt_jam3[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(8);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_jam4[]';
                el.id = 'txt_jam4[]';
            }else{
                el = document.createElement('<input name="txt_jam4[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

// right cell
            var cellRight = row.insertCell(9);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_jam5[]';
                el.id = 'txt_jam5[]';
            }else{
                el = document.createElement('<input name="txt_jam5[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(10);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_jam6[]';
                el.id = 'txt_jam6[]';
            }else{
                el = document.createElement('<input name="txt_jam6[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

// right cell
            var cellRight = row.insertCell(11);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_petunjuk[]';
                el.id = 'txt_petunjuk[]';
            }else{
                el = document.createElement('<input name="txt_petunjuk[]"/>');
            }
            el.type = 'text';
            el.value = '';
            el.className = 'inputan';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
 // right cell
                cellRight = row.insertCell(12);
                if(!isIE){
                    el = document.createElement('img');
                    el.setAttribute('onClick','if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);setDisable("del")}');
                }else{
                    el = document.createElement('<img name="img" onClick="if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);}"/>');
                }
                el.src = '../icon/del.gif';
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
        if (jmlRow > 4)
		{
            var i=cRow.parentNode.parentNode.rowIndex;
            //if (i>2){
            tbl.deleteRow(i);
            var lastRow = tbl.rows.length;
            for (var i=3;i<lastRow;i++)
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
            var tbl = document.getElementById('tgl');
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
                el.name = 'tgl[]';
                el.id = 'tgl[]';
				
            }else{
                el = document.createElement('<input name="tgl[]"/>');
            }
            el.type = 'text';
            el.className = 'tgl';
            el.value = '';
			el.size = '15';
			//el.onclick = 'gfPop.fPopCalendar(document.getElementById("tgl2"),depRange)';
			

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
			//var td3=x.insertCell(1);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'hari[]';
                el.id = 'hari[]';
            }else{
                //el = document.createElement('<select name="hari[]"> <option>Laki-laki</option><option>Perempuan</option></select>');
				el = document.createElement('<input name="hari[]"/>');
            }
            el.type = 'select';
            el.value = '';
			el.size = 15;
			el.select('<select name="hari[]"> <option>Laki-laki</option><option>Perempuan</option></select>');
			
            

            cellRight.className = 'tdisi2';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(2);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'jam[]';
                el.id = 'jam[]';
            }else{
                el = document.createElement('<input name="jam[]"/>');
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
                el.name = 'dokter[]';
                el.id = 'dokter[]';
            }else{
                el = document.createElement('<input name="dokter[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 30;
            

            cellRight.className = 'tdisi2';
            cellRight.appendChild(el);
			
// right cell
            

// right cell
            

// right cell
            
			
// right cell
            
			
// right cell
            

// right cell
            
			
// right cell
            

// right cell
            
			
 // right cell
                cellRight = row.insertCell(4);
                if(!isIE){
                    el = document.createElement('img');
                    el.setAttribute('onClick','if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable2(this);setDisable("del")}');
                }else{
                    el = document.createElement('<img name="img" onClick="if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable2(this);}"/>');
                }
                el.src = '../icon/del.gif';
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
   tanggalan();
    }
function removeRowFromTable2(cRow)
	{
        var tbl = document.getElementById('tgl');
        var jmlRow = tbl.rows.length;
        if (jmlRow > 3)
		{
            var i=cRow.parentNode.parentNode.rowIndex;
            //if (i>2){
            tbl.deleteRow(i);
            var lastRow = tbl.rows.length;
            for (var i=3;i<lastRow;i++)
			{
                var tds = tbl.rows[i].getElementsByTagName('td');
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
$('input:radio[name="radio[0]"]').change(
    function tampil(){
        if ($(this).val() == 3) {
            $('#status').slideDown(600);
        }
        else {
            $('#status').slideUp(600);
			//$('#status').checked(false);
			document.getElementById('_diet').value="";
        }
		
    });
	
$('input:radio[name="radio[0]"]').change(
    function tampil2(){
        if ($(this).val() == 4) {
            $('#status2').slideDown(600);
        }
        else {
            $('#status2').slideUp(600);
			document.getElementById('_batas').value="";
        }
    });
	
$('input:radio[name="radio[2]"]').change(
    function tampil3(){
        if ($(this).val() == '2') {
            $('#status3').slideDown(600);
        }
        else {
            $('#status3').slideUp(600);
        }
    });
	
$('input:radio[name="radio[6]"]').change(
    function tampil4(){
        if ($(this).val() == '3') {
            $('#status4').slideDown(600);
        }
        else {
            $('#status4').slideUp(600);
        }
    });
	
$('input:radio[name="radio[8]"]').change(
    function tampil5(){
        if ($(this).val() == '4') {
            $('#status5').slideDown(600);
        }
        else {
            $('#status5').slideUp(600);
        }
    });

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
function tambahrow(){
	var idx2 = $('#datatable tr').length;
	var idx = idx2-1;

    var x=document.getElementById('datatable').insertRow(idx+1);
    var td1=x.insertCell(0);
    var td2=x.insertCell(1);
    var td3=x.insertCell(2);
    var td4=x.insertCell(3);
	var td5=x.insertCell(4);
	
	
    td1.innerHTML="<input type='text' class='tgl' name='tgl[]' id='tgl"+idx+"'>";tanggalan();
	td2.innerHTML="<select id='hari' name='hari[]'><option>Senin</option><option>Selasa</option><option>Rabu</option><option>Kamis</option><option>Jumat</option><option>Sabtu</option><option>Minggu</option></select>";
    td3.innerHTML="<input type='text' class='jam' name='jam[]' id='jam"+idx+"'>";jam();
    td4.innerHTML='<select id="dokter" name="dokter[]"><?php $sql="select * from b_ms_pegawai where spesialisasi_id<>0";  $query = mysql_query ($sql); while($data = mysql_fetch_array($query)){ ?> <option value="<?php echo $data['id'];?>" ><?php echo $data['nama']?></option> <?php } ?></select>';
	//url='tes.php';	
	td5.innerHTML='<img alt="del" src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onclick=del(this) />';
}

function del(elm){
	var idx = $(elm).parents('#datatable tr').prevAll().length;
		//alert(idrow);
	var x=document.getElementById('datatable').deleteRow(idx);
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
</script>
    
	
	
	
</html>
