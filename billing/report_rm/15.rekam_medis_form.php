<?php
session_start();
include("../sesi.php");
include("../koneksi/konek.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUsr'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,
k.cara_keluar
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_pasien_keluar k ON k.pelayanan_id=pl.id
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
$sqlKm="SELECT tk.tgl_in,tk.tgl_out FROM b_tindakan_kamar tk 
LEFT JOIN b_pelayanan p ON p.id=tk.pelayanan_id
WHERE tk.pelayanan_id='$idPel';";
$dK=mysql_fetch_array(mysql_query($sqlKm));
$usr=mysql_fetch_array(mysql_query("select * from b_ms_pegawai where id='$idUsr'"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css" />

        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <!-- untuk ajax-->
        <script type="text/javascript" src="../theme/js/ajax.js"></script>
        <script type="text/javascript" src="../jquery.js"></script>
        <script type="text/javascript" src="../jquery.form.js"></script>
        <script type="text/javascript" src="js/jquery.timeentry.js"></script>
         <script type="text/javascript">
$(function () 
{
	$('#jam_mulai').timeEntry({show24Hours: true, showSeconds: true});
	$('#jam_selesai').timeEntry({show24Hours: true, showSeconds: true});
});
</script>
<script>
function jam(){			
	$(function () {
	$('.jam').timeEntry({show24Hours: true, showSeconds: true});
});
}
</script>
<script>
function jam2(){			
	$(function () {
	$('.jam2').timeEntry({show24Hours: true, showSeconds: true});
});
}
</script>
<title>rekam medis</title>
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
</head>
<?
include "setting.php";
?>
<script type="text/JavaScript">
            var arrRange = depRange = [];
</script>
<body onload="jam();jam2();">
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
<form name="form1" id="form1" action="15.rekam_medis_act.php">
<input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    			<input type="hidden" name="id" id="id"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
<table width="800" border="0" style="font:12px tahoma;">
  <tr>
    <td><table width="528" border="1" align="right" cellpadding="4" bordercolor="#000000" style="border-collapse:collapse;">
      <tr>
        <td height="100" align="center" valign="middle"><span style="font:bold 20px tahoma;">REKAM MEDIS HEMODIALISA</span></td>
        </tr>
      
    </table></td>
  </tr>
</table>
<br />
<table width="799" border="0" cellpadding="4" style="font:12px tahoma;">
  <tr>
    <td width="146">Nama</td>
    <td width="181">: <?=$nama;?> </td>
    <td width="106">Tanggal</td>
    <td colspan="3">: <input name="tgl" type="text" size="10" id="tgl" value="<?=date('d-m-Y')?>" onclick="gfPop.fPopCalendar(document.getElementById('tgl'),depRange);" /></td>
    </tr>
  <tr>
    <td>Umur</td>
    <td>: <?=$umur;?> Th </td>
    <td>HD ke </td>
    <td colspan="2">:  
      <label for="hd_ke"></label>
      <input type="text" name="hd_ke" id="hd_ke" /></td>
    <td width="107">&nbsp;</td>
  </tr>
  <tr>
    <td>No.Rekam Medis </td>
    <td>: <?=$noRM;?> </td>
    <td>Mesin</td>
    <td colspan="3">: 
      <label for="mesin"></label>
      <input type="text" name="mesin" id="mesin" /></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Dialiser Type </td>
    <td colspan="2">:  
      <label for="type"></label>
      <input type="text" name="type" id="type" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Pemeriksaan Pre HD</td>
    <td>&nbsp;</td>
    <td>Jenis HD </td>
    <td width="124">: 
    <input type="radio" name="radio[0]" value="1" id="radio[]" />
    Single use </td>
    <td width="73">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;
      <input type="radio" name="radio[0]" value="2" id="radio[]" />
    Reuse ke </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>TD Tidur</td>
    <td>: 
      <label for="td_tidur"></label>
      <input name="td_tidur" type="text" id="td_tidur" size="10" onkeyup="text0()" />
mmHg</td>
    <td>Heparinasi</td>
    <td>&nbsp;
      <input type="radio" name="radio[0]" value="3" id="radio[]" />
    Kontinue &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
    <td>Dosis Awal </td>
    <td>: 
      <label for="dosis_awal1"></label>
      <input name="dosis_awal1" type="text" id="dosis_awal1" size="5" />
u </td>
  </tr>
  <tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;Duduk</td>
    <td>:  
      <input name="duduk" type="text" id="duduk" size="10" onkeyup="text1()" />
      mmHg</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Dosis Lanjut </td>
    <td>: 
      <input name="dosis_lanjut" type="text" id="dosis_lanjut" size="5" />
u /jam </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Dosis Awal </td>
    <td>: 
      <input name="dosis_awal2" type="text" id="dosis_awal2" size="5" />
      u </td>
  </tr>
  <tr>
    <td>Nadi</td>
    <td>: 
      <input name="nadi" type="text" id="nadi" size="10" onkeyup="text2()" />
x/mnt </td>
    <td>Lama HD </td>
    <td>: 
      <input name="lama_hd" type="text" id="lama_hd" size="10" />
Jam </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Respirasi</td>
    <td>: 
      <input name="respirasi" type="text" id="respirasi" size="10" onkeyup="text3()" />
x/mnt </td>
    <td>Mulai jam </td>
    <td>: <input name="jam_mulai" type="text" id="jam_mulai" size="8"/></td>
    <td>Selesai Jam :</td>
    <td><input name="jam_selesai" type="text" id="jam_selesai" size="8"/></td>
    </tr>
  <tr>
    <td>Suhu</td>
    <td>: 
      <input name="suhu" type="text" id="suhu" size="10" onkeyup="text4()" />&deg; C </td>
    <td>Priming Volume</td>
    <td>: 
      <input name="p_volume" type="text" id="p_volume" size="10" />
      ml </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Priming Keluar</td>
    <td>: 
      <input name="p_keluar" type="text" id="p_keluar" size="10" />
      ml </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Keluhan</td>
    <td colspan="5">: <label for="keluhan"></label>
      <input name="keluhan" type="text" id="keluhan" value="" size="80" onkeyup="text5()" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>BB Standart (Dry Wight)</td>
    <td>:  
      <input name="bbs" type="text" id="bbs" size="10" />
      kg </td>
    <td>Lain-lain</td>
    <td colspan="2">: 
      <input name="lain" type="text" id="lain" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>BB Pre HD</td>
    <td>: 
      <input name="bbpre" type="text" id="bbpre" size="10" />
kg </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>BB Post HD yang lalu</td>
    <td>: 
      <input name="bbpo" type="text" id="bbpo" size="10" />
kg </td>
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
  </tr>
  <tr>
    <td>Sarana Hubungan Sirkulasi</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="radio" name="radio[1]" id="radio[]" value="1" />
    Cimino</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="radio" name="radio[1]" id="radio[]" value="2" />
  Double / Triple Lumen </td>
    <td>&nbsp;</td>
    <td>Perawat I </td>
    <td colspan="3">: 
      <input name="perawat1" type="text" id="perawat1" size="40" onkeyup="text6()" /></td>
    </tr>
  <tr>
    <td><input type="radio" name="radio[1]" id="radio[]" value="3" />
Tunnel</td>
    <td>&nbsp;</td>
    <td>Perawat II </td>
    <td colspan="3">: 
      <input name="perawat2" type="text" id="perawat2" size="40" onkeyup="text7()" /></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6"><div id="inObat">
      <table align="center" width="781" border="1" id="datatable" cellpadding="2" style="border-collapse:collapse;">
        <tr>
          <td colspan="13" align="right"><input type="button" name="button" id="button" value="Tambah" onclick="tambahrow();return false;"/></td>
          </tr>
        <tr>
          <td width="158" align="center">Jam</td>
          <td width="38" align="center">TD</td>
          <td width="61" align="center">Nadi</td>
          <td width="54" align="center">Respirasi</td>
          <td width="30" align="center"> Suhu</td>
          <td width="46" align="center">Heparin</td>
          <td width="33" align="center">TMP</td>
          <td width="39" align="center">AP/VP</td>
          <td width="33" align="center">QB</td>
          <td width="33" align="center">UFR</td>
          <td width="33" align="center">UFG</td>
          <td width="89" align="center">Keterangan</td>
          <td width="26">&nbsp;</td>
          </tr>
        <tr>
          <td>
          <input name="jam[]" type="text" class="jam" id="jam[]" size="10"/></td>
          <td align="center"><input name="tdd[]" type="text" id="tdd[]" size="5" /></td>
          <td align="center"><input name="nadi_t1[]" type="text" id="nadi_t1[]" size="5" /></td>
          <td align="center"><input name="respirasi_t1[]" type="text" id="respirasi_t1[]" size="5" /></td>
          <td align="center"><input name="suhu_t1[]" type="text" id="suhu_t1[]" size="5" /></td>
          <td align="center"><input name="heparin[]" type="text" id="heparin[]" size="5" /></td>
          <td align="center"><input name="tmp[]" type="text" id="tmp[]" size="5" /></td>
          <td align="center"><input name="ap[]" type="text" id="ap[]" size="5" /></td>
          <td align="center"><input name="qb[]" type="text" id="qb[]" size="5" /></td>
          <td align="center"><input name="ufr[]" type="text" id="ufr[]" size="5" /></td>
          <td align="center"><input name="ufg[]" type="text" id="ufg[]" size="5" /></td>
          <td align="center"><input name="keterangan[]" type="text" class="inputan" id="keterangan[]" /></td>
          <td align="center" valign="middle"><img alt="del" src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onclick="hilang(this);" /></td>
          </tr>
        </table>
      </div></td>
  </tr>
  <tr>
    <td colspan="6">INSTRUKSI DOKTER</td>
  </tr>
  <tr>
    <td colspan="6"><table width="800" border="0" cellpadding="4">
      <tr>
        <td colspan="6"><div id="inObat2"><table width="781" border="1" align="center" cellpadding="2" id="datatable2" style="border-collapse:collapse;">
          <tr>
            <td colspan="4" align="right"><input type="button" name="button2" id="button2" value="Tambah" onclick="tambahrow2();return false;"/></td>
            </tr>
          <tr>
            <td width="63" align="center">Jam</td>
            <td width="471" align="center">Saran Dokter</td>
            <td width="178" align="center">TTD/Nama Perawat</td>
            <td width="33">&nbsp;</td>
            </tr>
          <tr>
            <td valign="middle"><input name="jam2[]" type="text" class="jam2" id="jam2[]" size="10"/></td>
            <td align="center"><textarea name="saran[]" cols="70" rows="3" id="saran[]"></textarea></td>
            <td align="center">&nbsp;</td>
            <td align="center" valign="middle"><img alt="del" src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onclick="hilang2(this);" /></td>
            </tr>
          </table></div></td>
        </tr>
      <tr>
        <td colspan="2">Pemeriksaan Post HD :</td>
        <td colspan="2">Intake Cairan</td>
        <td colspan="2">Output Cairan</td>
        </tr>
      <tr>
        <td width="114">TD Tidur</td>
        <td width="199">: 
          <input name="td_tidur2" type="text" id="td_tidur2" size="10"/>
          mmHg</td>
        <td width="97">Sisa Priming</td>
        <td width="91">: 
          <input name="sisa" type="text" id="sisa" size="5" rel="Ajumlah"/>
          ml</td>
        <td width="107">Urine</td>
        <td width="129">: 
          <input name="urine" type="text" id="urine" size="5" rel="Bjumlah" />
          ml</td>
        </tr>
      <tr>
        <td>TD Duduk</td>
        <td>: 
          <input name="duduk2" type="text" id="duduk2" size="10" />
          mmHg</td>
        <td>Infus</td>
        <td>: 
          <input name="infus" type="text" id="infus" size="5" rel="Ajumlah"/>
          ml</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>Nadi</td>
        <td>: 
          <input name="nadi2" type="text" id="nadi2" size="10" />
          x/menit</td>
        <td>Transfusi</td>
        <td>: 
          <input name="tran" type="text" id="tran" size="5" rel="Ajumlah" />
          ml</td>
        <td>Muntah</td>
        <td>: 
          <input name="muntah" type="text" id="muntah" size="5" rel="Bjumlah" />
          ml</td>
        </tr>
      <tr>
        <td>Respirasi</td>
        <td>: 
          <input name="respirasi2" type="text" id="respirasi2" size="10" />
          x/menit</td>
        <td>Bilas</td>
        <td>: 
          <input name="bilas" type="text" id="bilas" size="5" rel="Ajumlah" />
          ml</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>Suhu</td>
        <td>: 
          <input name="suhu2" type="text" id="suhu2" size="10" />          &deg;c</td>
        <td style="border-bottom:1px solid #000000;">Minum</td>
        <td style="border-bottom:1px solid #000000;">: 
          <input name="minum" type="text" id="minum" size="5" rel="Ajumlah" />
          ml</td>
        <td style="border-bottom:1px solid #000000;">UF</td>
        <td style="border-bottom:1px solid #000000;">: 
          <input name="uf" type="text" id="uf" size="5" rel="Bjumlah" />
          ml</td>
        </tr>
      <tr>
        <td>Keluhan</td>
        <td>: 
          <input name="keluhan2" type="text" id="keluhan2" value="" size="25" /></td>
        <td>Jumlah</td>
        <td>: 
          <input name="jumlah" type="text" id="jumlah" size="5" readonly="readonly" />
          ml</td>
        <td>Jumlah</td>
        <td>: 
          <input name="jumlah2" type="text" id="jumlah2" size="5" readonly="readonly" />
          ml</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Total Balance </td>
        <td>: 
          <input name="total" type="text" id="total" size="8" readonly="readonly" />
ml</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>BB Pulang</td>
        <td>: 
          <label for="bb_pulang"></label>
          <input type="text" name="bb_pulang" id="bb_pulang" />
Kg </td>
        <td>Perawat I </td>
        <td colspan="3">: 
          <input name="perawat11" type="text" id="perawat11" size="40" /></td>
        </tr>
      <tr>
        <td>Penekanan</td>
        <td>: 
          <label for="penekanan"></label>
          <input type="text" name="penekanan" id="penekanan" />
Menit </td>
        <td>Perawat II</td>
        <td colspan="3">: 
          <input name="perawat22" type="text" id="perawat22" size="40" /></td>
        </tr>
      <tr>
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
        </tr>
      <tr>
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
    <td colspan="6">&nbsp;</td>
  </tr>
</table>
<br />
<table width="1358" border="0" cellpadding="4" style="font:12px tahoma;">
  <tr>
    <td colspan="2">PENGKAJIAN</td>
    <td width="101">&nbsp;</td>
    <td width="106">&nbsp;</td>
    <td colspan="2">DIAGNOSA KEPERAWATAN </td>
    <td width="353">RENCANA DAN IMPLEMENTASI KEPERAWATAN</td>
    <td colspan="2">EVALUASI</td>
  </tr>
  <tr>
    <td width="21">A.</td>
    <td width="166">Respiratori</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="124">(
      <input type="checkbox" name="checkbox[0]" value="1" id="checkbox[]" />
      <label for="checkbox"></label>) Aktual</td>
    <td width="134">(      
      <input type="checkbox" name="checkbox[1]" value="2" id="checkbox[]" />
      <label for="checkbox2"></label>      ) Resiko </td>
    <td>(
      <input type="checkbox" name="checkbox[2]" value="3" id="checkbox[]" />
      <label for="checkbox36"></label>
      ) Hitung Frekuensi dan irama pernafasan</td>
    <td width="7">&nbsp;</td>
    <td width="254">(
      <input type="checkbox" name="checkbox[3]" value="4" id="checkbox[]" />
      <label for="checkbox74"></label>
      ) Pernafasan &plusmn; 20 x/m setelah </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>1. Tingkat Kesadaran </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[4]" value="5" id="checkbox[]" />
      <label for="checkbox37"></label>
      ) Beri posisi semi fowler jika tidak ada kontra indikasi</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;HD &le; 2 jam</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>(CM)</td>
    <td>(Apatis)</td>
    <td>&nbsp;</td>
    <td colspan="2">(
      <input type="checkbox" name="checkbox[5]" value="6" id="checkbox[]" />
      <label for="checkbox3"></label>) Gangguan pola nafas yang tidak efektif</td>
    <td>(
      <input type="checkbox" name="checkbox[6]" value="7" id="checkbox[]" />
      <label for="checkbox38"></label>
      ) Berikan O2 sesuai kebutuhan</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[7]" value="8" id="checkbox[]" />
      <label for="checkbox75"></label>
      ) Therapy O2, stop jam ke <input name="stop_jam" type="text" id="stop_jam" size="5" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>(Somnolen)</td>
    <td>(Comateus)</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[8]" value="9" id="checkbox[]" />
      <label for="checkbox39"></label>
      ) Anjurkan nafas dalam teratur dan batuk efektif</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[9]" value="10" id="checkbox[]" />
      <label for="checkbox76"></label>
      ) Tekanan darah post HD</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">Keterangan = 
      <input name="ket_res" type="text" id="ket_res" size="40" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[10]" value="11" id="checkbox[]" />
      <label for="checkbox40"></label>
      ) Program HD sesuai kebutuhan pasien</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp; TD :
      <input name="td2" type="text" id="td2" size="3" />
      mmHg&nbsp;&nbsp; N :
      <input name="n2" type="text" id="n2" size="3" />
      mmHg</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>TD : 
      <label for="td"></label>
      <input name="td" type="text" id="td" size="3" />      
      mmHg</td>
    <td colspan="2">N :
      <input name="n" type="text" id="n" size="3" />
      x/mnt</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[11]" value="12" id="checkbox[]" />
      <label for="checkbox41"></label>
      ) Lakukan ultrafiltrasi lebih banyak di jam pertama</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp; P &nbsp;&nbsp;:
      <input name="p2" type="text" id="p2" size="3" />
      x/m&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;S :
      <input name="s2" type="text" id="s2" size="3" />      &deg;c</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>P &nbsp;&nbsp;: 
      <input name="p" type="text" id="p" size="3" />      
        x/mnt</td>
    <td colspan="2">S : 
      <input name="s" type="text" id="s" size="3" />
      &deg;c</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[12]" value="13" id="checkbox[]" />
      <label for="checkbox42"></label>
      ) Observasi vital sign ( on HD )</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[13]" value="14" id="checkbox[]" />
      <label for="checkbox77"></label>
      ) Kolaborasi dengan dokter</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" height="30">Keterangan = 
      <input name="ket_res2" type="text" id="ket_res2" size="40" /></td>
    <td height="30">&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[14]" value="15" id="checkbox[]" />
      <label for="checkbox43"></label>
      ) Kolaborasi dengan dokter</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>2. Edema </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[15]" value="16" id="checkbox[]" />
      <label for="checkbox44"></label>
      ) Lakukan pemeriksaan AGD, SE, &amp; ureum, creatinin</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[16]" value="17" id="checkbox[]" />
      <label for="checkbox4"></label>
      ) Tidak Ada </td>
    <td>(
      <input type="checkbox" name="checkbox[17]" value="18" id="checkbox[]" />
      <label for="checkbox6"></label>
      ) Anasarka </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[18]" value="19" id="checkbox[]" />
      <label for="checkbox45"></label>
      ) Therapy &nbsp;&nbsp;: 1. 
      <label for="textfield15"></label>
      <input type="text" name="therapy" id="therapy" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[19]" value="20" id="checkbox[]" />
      <label for="checkbox5"></label>
      ) Extrimitas</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. 
      <label for="textfield16"></label>
       <input type="text" name="therapy2" id="therapy2" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" height="30">Keterangan = 
      <input name="ket_res3" type="text" id="ket_res3" size="40" /></td>
    <td height="30">&nbsp;</td>
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
  </tr>
  <tr>
    <td>B.</td>
    <td>Makan dan Minum </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[20]" value="21" id="checkbox[]" />
      <label for="checkbox21"></label>
      ) Aktual</td>
    <td>(
      <input type="checkbox" name="checkbox[21]" value="22" id="checkbox[]" />
      <label for="checkbox22"></label>
      ) Resiko </td>
    <td>(
      <input type="checkbox" name="checkbox[22]" value="23" id="checkbox[]" />
      <label for="checkbox46"></label>
      ) Timbang BB ( Pre dan Post HD )</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[23]" value="24" id="checkbox[]" />
      <label for="checkbox78"></label>
      ) Cairan yang masuk selama HD</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>1. Diit</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[24]" value="25" id="checkbox[]" />
      <label for="checkbox47"></label>
      ) Batasi intake cairan selama on HD</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp; (
      <input type="checkbox" name="checkbox[25]" value="26" id="checkbox[]" />
      <label for="checkbox79"></label>
      ) &lt;500 ml &nbsp;&nbsp;&nbsp;&nbsp; (
      <input type="checkbox" name="checkbox[26]" value="27" id="checkbox[]" />
      <label for="checkbox80"></label>
      ) 500-1000 ml </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>2. Cairan </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">(
      <input type="checkbox" name="checkbox[27]" value="28" id="checkbox[]" />
      <label for="checkbox23"></label>
      ) Kelebihan volume cairan dalam tubuh</td>
    <td>(
      <input type="checkbox" name="checkbox[28]" value="29" id="checkbox[]" />
      <label for="checkbox48"></label>
      ) Anjurkan batasi intake cairan ( 24 jam )</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[29]" value="30" id="checkbox[]" />
      <label for="checkbox81"></label>
      ) Program HD</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">(
      <input type="checkbox" name="checkbox[30]" value="31" id="checkbox[]" />
      <label for="checkbox7"></label>
      ) 500 s/d 1000 cc / 24 jam</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[31]" value="32" id="checkbox[]" />
      <label for="checkbox49"></label>
      ) Program HD sesuai kebutuhan pasien</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp; 1 waktu  &nbsp;&nbsp;&nbsp;&nbsp; (
      <input type="checkbox" name="checkbox[32]" value="33" id="checkbox[]" />
      <label for="checkbox82"></label>
      ) 2-4 jam</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" height="30">Keterangan = 
      <input name="ket_manmin" type="text" id="ket_manmin" size="40" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[33]" value="34" id="checkbox[]" />
      <label for="checkbox50"></label>
      ) Kolaborasi dengan dokter</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (
      <input type="checkbox" name="checkbox[34]" value="35" id="checkbox[]" />
      <label for="checkbox83"></label>
      ) 4-5 jam</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>3. Nafsu Makan </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td> (
      <input type="checkbox" name="checkbox[35]" value="36" id="checkbox[]" />
      <label for="checkbox51"></label>
      ) Lakukan pemeriksaan laboratorium ( albumin dan Hb )</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (
      <input type="checkbox" name="checkbox[36]" value="37" id="checkbox[]" />
      <label for="checkbox84"></label>
      ) &le; 3 liter</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[37]" value="38" id="checkbox[]" />
      <label for="checkbox8"></label>
      ) Baik </td>
    <td>(
      <input type="checkbox" name="checkbox[38]" value="39" id="checkbox[]" />
      <label for="checkbox9"></label>
      ) Kurang </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td> (
      <input type="checkbox" name="checkbox[39]" value="40" id="checkbox[]" />
      <label for="checkbox52"></label>
      ) Therapy  &nbsp;&nbsp;: 1. 
      <input type="text" name="therapy3" id="therapy3" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (
      <input type="checkbox" name="checkbox[40]" value="41" id="checkbox[]" />
      <label for="checkbox85"></label>
      ) 3-5 liter</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" height="30">Keterangan = 
      <input name="ket_manmin2" type="text" id="ket_manmin2" size="40" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. 
      <input type="text" name="therapy4" id="therapy4" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (
      <input type="checkbox" name="checkbox[41]" value="42" id="checkbox[]" />
      <label for="checkbox86"></label>
      ) &le; 200 m</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>4. Perdarahan </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">(
      <input type="checkbox" name="checkbox[42]" value="43" id="checkbox[]" />
      <label for="checkbox24"></label>
      ) Resiko perubahan hemodinamik</td>
    <td>(
      <input type="checkbox" name="checkbox[43]" value="44" id="checkbox[]" />
      <label for="checkbox53"></label>
      ) Observasi vital sign</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (
      <input type="checkbox" name="checkbox[44]" value="45" id="checkbox[]" />
      <label for="checkbox87"></label>
      ) 200-250 ml/m</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[45]" value="46" id="checkbox[]" />
      <label for="checkbox10"></label>
      ) Gusi </td>
    <td>(
      <input type="checkbox" name="checkbox[46]" value="47" id="checkbox[]" />
      <label for="checkbox11"></label>
      ) Menstruasi </td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;&nbsp;&nbsp; &nbsp;dan kardiovaskuler</td>
    <td>(
      <input type="checkbox" name="checkbox[47]" value="48" id="checkbox[]" />
      <label for="checkbox54"></label>
      ) Drip NaCl 0.9 % sesuai kebutuhan</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[48]" value="49" id="checkbox[]" />
      <label for="checkbox88"></label>
      ) Kolaborasi dengan dokter</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" height="30">Keterangan = 
      <input name="ket_manmin3" type="text" id="ket_manmin3" size="40" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[49]" value="50" id="checkbox[]" />
      <label for="checkbox55"></label>
      ) Atur posisi datar / tidur tanpa bantal</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;.................................................</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">(
      <input type="checkbox" name="checkbox[50]" value="51" id="checkbox[]" />
      <label for="checkbox25"></label>
      ) Resiko perdarahan</td>
    <td>(
      <input type="checkbox" name="checkbox[51]" value="52" id="checkbox[]" />
      <label for="checkbox56"></label>
      ) Kolaborasi dengan dokter</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;.................................................</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[52]" value="53" id="checkbox[]" />
      <label for="checkbox57"></label>
      ) Therapy  &nbsp;&nbsp;: 1. 
      <input type="text" name="therapy5" id="therapy5" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;.................................................</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. 
      <input type="text" name="therapy6" id="therapy6" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;.................................................</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[53]" value="54" id="checkbox[]" />
      <label for="checkbox58"></label>
      ) Pembenan heparin minimal</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[54]" value="55" id="checkbox[]" />
      <label for="checkbox94"></label>
      ) Tidak ada perdarahan </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" height="30">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[55]" value="56" id="checkbox[]" />
      <label for="checkbox59"></label>
      ) Jika HD tanpa heparin, bilas dengan NaCl 0.9 %</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[56]" value="57" id="checkbox[]" />
      <label for="checkbox93"></label>
      ) Ada perdarahan </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[57]" value="58" id="checkbox[]" />
      <label for="checkbox60"></label>
      ) Observasi keluhan pasien on HD</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(
      <input type="checkbox" name="checkbox[58]" value="59" id="checkbox[]" />
      <label for="checkbox92"></label>
      ) Kolaborasi dengan dokter</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[59]" value="60" id="checkbox[]" />
      <label for="checkbox61"></label>
      ) Kolaborasi dengan dokter</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;th/.......................................</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td> (
      <input type="checkbox" name="checkbox[60]" value="61" id="checkbox[]" />
      <label for="checkbox62"></label>
      ) Therapy  &nbsp;&nbsp;: 1. 
      <input type="text" name="therapy7" id="therapy7" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;...........................................</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. 
      <input type="text" name="therapy8" id="therapy8" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;...........................................</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" height="30">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>C.</td>
    <td>Kulit / Turgor </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[61]" value="62" id="checkbox[]" />
      <label for="checkbox26"></label>
      ) Aktual</td>
    <td>(
      <input type="checkbox" name="checkbox[62]" value="63" id="checkbox[]" />
      <label for="checkbox27"></label>
      ) Resiko </td>
    <td>(
      <input type="checkbox" name="checkbox[63]" value="64" id="checkbox[]" />
      <label for="checkbox63"></label>
      ) Jelaskan tentang gangguan integritas kulit</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[64]" value="65" id="checkbox[]" />
      <label for="checkbox91"></label>
      ) Pasien mengerti setelah dijelaskan </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[65]" value="66" id="checkbox[]" />
      <label for="checkbox12"></label>
      ) Elastis </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[66]" value="67" id="checkbox[]" />
      <label for="checkbox64"></label>
      ) Anjurkan HD rutin sesuai dengan instruksi dokter</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;tentang gangguan kulit</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[67]" value="68" id="checkbox[]" />
      <label for="checkbox13"></label>
      ) Tidak Elastis </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">(
      <input type="checkbox" name="checkbox[68]" value="69" id="checkbox[]" />
      <label for="checkbox28"></label>
      ) Gangguan Integritas kulit</td>
    <td>(
      <input type="checkbox" name="checkbox[69]" value="70" id="checkbox[]" />
      <label for="checkbox65"></label>
      ) Kolaborasi dengan dokter</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" height="30">Keterangan =
      <input name="ket_kulit" type="text" id="ket_kulit" size="40" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td> (
      <input type="checkbox" name="checkbox[70]" value="71" id="checkbox[]" />
      <label for="checkbox66"></label>
      ) Therapy  &nbsp;&nbsp;: 1. 
      <input type="text" name="therapy9" id="therapy9" /></td>
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
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. 
      <input type="text" name="therapy10" id="therapy10" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>D.</td>
    <td>Eliminasi</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[71]" value="72" id="checkbox[]" />
      <label for="checkbox30"></label>
      ) Aktual</td>
    <td>(
      <input type="checkbox" name="checkbox[72]" value="73" id="checkbox[]" />
      <label for="checkbox29"></label>
      ) Resiko </td>
    <td>(
      <input type="checkbox" name="checkbox[73]" value="74" id="checkbox[]" />
      <label for="checkbox67"></label>
      ) Berikan penjelasan tentang perubahan eliminasi ( BAK / BAB) </td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[74]" value="75" id="checkbox[]" />
      <label for="checkbox90"></label>
      ) Pasien mengerti setelah dijelaskan </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>1. BAK </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp; pada pasien</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;tentang perubahan BAK / BAB</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[75]" value="76" id="checkbox[]" />
      <label for="checkbox14"></label>
      ) Anuri </td>
    <td>(
      <input type="checkbox" name="checkbox[76]" value="77" id="checkbox[]" />
      <label for="checkbox15"></label>
      ) Oliguri </td>
    <td>&nbsp;</td>
    <td colspan="2">(
      <input type="checkbox" name="checkbox[77]" value="78" id="checkbox[]" />
      <label for="checkbox31"></label>
      ) Perubahan eliminasi BAK</td>
    <td>(
      <input type="checkbox" name="checkbox[78]" value="79" id="checkbox[]" />
      <label for="checkbox68"></label>
      ) Anjurkan makan tinggi serat</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" height="30">Keterangan =
      <input name="ket_eli" type="text" id="ket_eli" size="40" /></td>
    <td colspan="2">(
      <input type="checkbox" name="checkbox[79]" value="80" id="checkbox[]" />
      <label for="checkbox32"></label>
      ) Perubahan eliminasi BAB</td>
    <td>(
      <input type="checkbox" name="checkbox[80]" value="81" id="checkbox[]" />
      <label for="checkbox69"></label>
      ) Anjurkan kepada pasien mobilisasi aktif semampunya</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>2. BAB</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[81]" value="82" id="checkbox[]" />
      <label for="checkbox70"></label>
      ) Kolaborasi dengan dokter</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[82]" value="83" id="checkbox[]" />
      <label for="checkbox16"></label>
      ) Normal </td>
    <td>(
      <input type="checkbox" name="checkbox[83]" value="84" id="checkbox[]" />
      <label for="checkbox17"></label>
      ) Kostipasi </td>
    <td>(
      <input type="checkbox" name="checkbox[84]" value="85" id="checkbox[]" />
      <label for="checkbox18"></label>
      ) Diare </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td> (
      <input type="checkbox" name="checkbox[85]" value="86" id="checkbox[]" />
      <label for="checkbox66"></label>
      ) Therapy  &nbsp;&nbsp;: 1.
  <input type="text" name="therapy11" id="therapy11" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" height="30">Keterangan =
      <input name="ket_eli2" type="text" id="ket_eli2" size="40" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.
      <input type="text" name="therapy12" id="therapy12" /></td>
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
  </tr>
  <tr>
    <td>E.</td>
    <td>Tidur dan Istirahat </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[86]" value="87" id="checkbox[]" />
      <label for="checkbox33"></label>
      ) Aktual</td>
    <td>(
      <input type="checkbox" name="checkbox[87]" value="88" id="checkbox[]" />
      <label for="checkbox34"></label>
      ) Resiko </td>
    <td>(
      <input type="checkbox" name="checkbox[88]" value="89" id="checkbox[]" />
      <label for="checkbox71"></label>
      ) Berikan penjelasan tentang gangguan istirahat ( tidur ) </td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[89]" value="90" id="checkbox[]" />
      <label for="checkbox89"></label>
      ) Pasien mengerti setelah dijelaskan </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[90]" value="91" id="checkbox[]" />
      <label for="checkbox19"></label>
      ) Normal </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp; pada pasien</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;tentang gangguan tidur</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[91]" value="92" id="checkbox[]" />
      <label for="checkbox20"></label>
      ) Sulit tidur </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">(
      <input type="checkbox" name="checkbox[92]" value="93" id="checkbox[]" />
      <label for="checkbox35"></label>
      ) Gangguan istirahat tidur</td>
    <td>(
      <input type="checkbox" name="checkbox[93]" value="94" id="checkbox[]" />
      <label for="checkbox72"></label>
      ) Kaji pola istirahat ( tidur ) pasien</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">Keterangan =
      <input name="ket_tdristrht" type="text" id="ket_tdristrht" size="40" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[94]" value="95" id="checkbox[]" />
      <label for="checkbox73"></label>
      ) Kolaborasi dengan dokter</td>
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
    <td> (
      <input type="checkbox" name="checkbox[95]" value="96" id="checkbox[]" />
      <label for="checkbox66"></label>
      ) Therapy  &nbsp;&nbsp;: 1.
  <input type="text" name="therapy13" id="therapy13" /></td>
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
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.
      <input type="text" name="therapy14" id="therapy14" /></td>
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
  </tr>
  <tr>
    <td colspan="9" align="center"><input type="button" name="bt_save" id="bt_save" class="tblTambah" value="Simpan" onclick="return simpan()" />&nbsp;
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
                    <td colspan="2">
                    <?php
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
                        <div id="gridbox" style="width:750; height:300px; background-color:white; overflow:hidden;"></div>
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
            if(ValidateForm('tgl')){
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
			 //var p="id*-*"+sisip[0]+"*|*tekanan_darah*-*"+sisip[1]+"*|*pernafasan*-*"+sisip[2]+"*|*nadi*-*"+sisip[3]+"*|*suhu*-*"+sisip[4]+"*|*_diet*-*"+sisip[6]+"*|*_batas*-*"+sisip[7]+"*|*_tgl*-*"+sisip[10]+"*|*_tinggi*-*"+sisip[12]+"*|*_warna*-*"+sisip[15]+"*|*_bau*-*"+sisip[16]+"*|*_cairan*-*"+sisip[18]+"*|*_lain*-*"+sisip[21]+"*|*diagnosa1*-*"+sisip[23]+"*|*diagnosa2*-*"+sisip[24]+"*|*anjuran1*-*"+sisip[25]+"*|*anjuran2*-*"+sisip[26]+"*|*anjuran3*-*"+sisip[27]+"*|*anjuran4*-*"+sisip[28]+"*|*lab*-*"+sisip[29]+"*|*foto*-*"+sisip[30]+"*|*scan*-*"+sisip[31]+"*|*mri*-*"+sisip[32]+"*|*usg*-*"+sisip[33]+"*|*surat*-*"+sisip[34]+"*|*surat_a*-*"+sisip[35]+"*|*summary*-*"+sisip[36]+"*|*buku*-*"+sisip[37]+"*|*kartu*-*"+sisip[38]+"*|*skl*-*"+sisip[39]+"*|*serah*-*"+sisip[40]+"*|*lain*-*"+sisip[41]+"*|*hasil1*-*"+sisip[42]+"*|*hasil2*-*"+sisip[43]+"*|*hasil3*-*"+sisip[44]+"*|*hasil4*-*"+sisip[45]+"*|*hasil5*-*"+sisip[46]+"";
			 var p="id*-*"+sisip[0]+"*|*tgl*-*"+sisip[1]+"*|*hd_ke*-*"+sisip[2]+"*|*mesin*-*"+sisip[3]+"*|*type*-*"+sisip[4]+"*|*td_tidur*-*"+sisip[5]+"*|*duduk*-*"+sisip[6]+"*|*dosis_awal1*-*"+sisip[7]+"*|*dosis_lanjut*-*"+sisip[8]+"*|*dosis_awal2*-*"+sisip[9]+"*|*nadi*-*"+sisip[10]+"*|*respirasi*-*"+sisip[11]+"*|*suhu*-*"+sisip[12]+"*|*lama_hd*-*"+sisip[13]+"*|*jam_mulai*-*"+sisip[14]+"*|*jam_selesai*-*"+sisip[15]+"*|*p_volume*-*"+sisip[16]+"*|*p_keluar*-*"+sisip[17]+"*|*keluhan*-*"+sisip[18]+"*|*bbs*-*"+sisip[19]+"*|*bbpre*-*"+sisip[20]+"*|*bbpo*-*"+sisip[21]+"*|*lain*-*"+sisip[22]+"*|*perawat1*-*"+sisip[23]+"*|*perawat2*-*"+sisip[24]+"*|*td_tidur2*-*"+sisip[25]+"*|*duduk2*-*"+sisip[26]+"*|*nadi2*-*"+sisip[27]+"*|*respirasi2*-*"+sisip[28]+"*|*suhu2*-*"+sisip[29]+"*|*keluhan2*-*"+sisip[30]+"*|*sisa*-*"+sisip[31]+"*|*infus*-*"+sisip[32]+"*|*tran*-*"+sisip[33]+"*|*bilas*-*"+sisip[34]+"*|*minum*-*"+sisip[35]+"*|*urine*-*"+sisip[36]+"*|*muntah*-*"+sisip[37]+"*|*uf*-*"+sisip[38]+"*|*jumlah*-*"+sisip[39]+"*|*jumlah2*-*"+sisip[40]+"*|*total*-*"+sisip[41]+"*|*bb_pulang*-*"+sisip[42]+"*|*penekanan*-*"+sisip[43]+"*|*perawat11*-*"+sisip[44]+"*|*perawat22*-*"+sisip[45]+"*|*ket_res*-*"+sisip[46]+"*|*td*-*"+sisip[47]+"*|*n*-*"+sisip[48]+"*|*p*-*"+sisip[49]+"*|*s*-*"+sisip[50]+"*|*ket_res2*-*"+sisip[51]+"*|*ket_res3*-*"+sisip[52]+"*|*ket_manmin*-*"+sisip[53]+"*|*ket_manmin2*-*"+sisip[54]+"*|*ket_manmin3*-*"+sisip[55]+"*|*ket_kulit*-*"+sisip[56]+"*|*ket_eli*-*"+sisip[57]+"*|*ket_eli2*-*"+sisip[58]+"*|*ket_tdristrht*-*"+sisip[59]+"*|*therapy*-*"+sisip[60]+"*|*therapy2*-*"+sisip[61]+"*|*therapy3*-*"+sisip[62]+"*|*therapy4*-*"+sisip[63]+"*|*therapy5*-*"+sisip[64]+"*|*therapy6*-*"+sisip[65]+"*|*therapy7*-*"+sisip[66]+"*|*therapy8*-*"+sisip[67]+"*|*therapy9*-*"+sisip[68]+"*|*therapy10*-*"+sisip[69]+"*|*therapy11*-*"+sisip[70]+"*|*therapy12*-*"+sisip[71]+"*|*therapy13*-*"+sisip[72]+"*|*therapy14*-*"+sisip[73]+"*|*stop_jam*-*"+sisip[74]+"*|*td2*-*"+sisip[75]+"*|*p2*-*"+sisip[76]+"*|*n2*-*"+sisip[77]+"*|*s2*-*"+sisip[78]+"";
			 
			 checkbox(sisip[81]);
			 
			 centang(sisip[79]);
			 centang2(sisip[80]);
			 
			 //centang3(sisip[9]);
			 //centang4(sisip[11]);
			 //centang5(sisip[13]);
			 //centang6(sisip[14]);
			 //centang7(sisip[17]);
			 //centang8(sisip[19]);
			 //centang9(sisip[20]);
			 //cek(sisip[22]);
			 
			 $('#inObat').load("15tabelatas.php?type=ESO&id="+sisip[0]);
			 $('#inObat2').load("15tabelbawah.php?type=ESO&id="+sisip[0]);
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
            $('#inObat').load("15tabelatas.php");
			$('#inObat2').load("15tabelbawah.php");
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
            a.loadURL("15.rekam_medis_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Data Rekam Medis Hemodialisa");
        a.setColHeader("NO,NO RM,KELUHAN,TGL INPUT,PENGGUNA");
        a.setIDColHeader(",no_rm,,,");
        a.setColWidth("20,80,400,100,150");
        a.setCellAlign("center,center,center,center,center");
        a.setCellHeight(20);
        a.setImgPath("../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("15.rekam_medis_util.php?idPel=<?=$idPel?>");
        a.Init();
		
		function tambah(){
			resetF();
			$('#tampil_input').slideDown(1000,function(){
		toggle();
		});
			
			}
		
		
		function cetak()
		{
			var id = document.getElementById("id").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(id==""){
				var idx =a.getRowId(a.getSelRow()).split('|');
				id=idx[0];
			 }
			/*if(id=='')
			{
				alert("Pilih data terlebih dahulu untuk di cetak");
			}
			else
			{*/	
				window.open("15.rekam_medis.php?id="+id+"&idKunj=<?=$idKunj?>&idPel=<?=$idPel?>&idUser=<?=$idUser?>","_blank");
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
		var list3 = document.form1.elements['radio[1]'];
		
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
	
	
	function checkbox(tes){
		var list=tes.split('*=*');
		var list1 = document.form1.elements['checkbox[]'];
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
	var td6=x.insertCell(5);
	var td7=x.insertCell(6);
	var td8=x.insertCell(7);
	var td9=x.insertCell(8);
	var td10=x.insertCell(9);
	var td11=x.insertCell(10);
	var td12=x.insertCell(11);
	var td13=x.insertCell(12);
	
    td1.innerHTML="<input type='text' class='jam' size='10' name='jam[]' id='jam'>";jam();
	td2.innerHTML="<input type='text' id='tdd[]' name='tdd[]' size ='5'>";
    td3.innerHTML="<input type='text' id='nadi_t1[]' name='nadi_t1[]'  size='5'>";
    td4.innerHTML="<input type='text' id='respirasi_t1[]' name='respirasi_t1[]'  size='5'>";	
	td5.innerHTML="<input type='text' id='suhu_t1[]' name='suhu_t1[]'  size='5'>";
	td6.innerHTML="<input type='text' id='heparin[]' name='heparin[]'  size='5'>";
	td7.innerHTML="<input type='text' id='tmp[]' name='tmp[]'  size='5'>";
	td8.innerHTML="<input type='text' id='ap[]' name='ap[]'  size='5'>";
	td9.innerHTML="<input type='text' id='qb[]' name='qb[]'  size='5'>";
	td10.innerHTML="<input type='text' id='ufr[]' name='ufr[]'  size='5'>";
	td11.innerHTML="<input type='text' id='ufg[]' name='ufg[]'  size='5'>";
	td12.innerHTML="<input type='text' id='keterangan[]' name='keterangan[]'  size='10'>";
    td13.innerHTML="<img alt='del' src='../icon/del.gif' border='0' width='16' height='16' align='absmiddle' class='proses' title='Klik Untuk Menghapus' onclick='hilang(this);' />";
	idrow++;
}

function del(a){
	//idrow=a-3;
	//alert(a);
	//alert(idrow);
    if(idrow>3){
        var x=document.getElementById('datatable').deleteRow(idrow-1);
        idrow--;
    }
}

function hilang(ab){
	if (confirm('Yakin Ingin Menghapus Data?')){
		//del(ab);
		var d = ab.parentNode.parentNode.rowIndex;
      document.getElementById('datatable').deleteRow(d);
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
</script>
<script>
var idrow2 = 3;

function tambahrow2(){
    var x=document.getElementById('datatable2').insertRow(idrow2);
	var idx2 = $('.jam2 tr').length;
	var idx = idx2-3;
    var td1=x.insertCell(0);
    var td2=x.insertCell(1);
	var td3=x.insertCell(2);
	var td4=x.insertCell(3);
 
    td1.innerHTML="<input type='text' class='jam2' size='10' name='jam2[]' id='jam2'>";jam2();
	td2.innerHTML="<textarea id='saran[]' name='saran[]' rows ='3' cols='70'>";
	td3.innerHTML="";
	td4.innerHTML="<img alt='del' src='../icon/del.gif' border='0' width='16' height='16' align='absmiddle' class='proses' title='Klik Untuk Menghapus' onclick='hilang2(this);' />";
    idrow2++;
}

function del2(){
    if(idrow>3){
        var y=document.getElementById('datatable2').deleteRow(idrow-1);
        idrow--;
    }
}

function hilang2(bb){
	if (confirm('Yakin Ingin Menghapus Data?')){
		//del(ab);
		var db = bb.parentNode.parentNode.rowIndex;
      document.getElementById('datatable2').deleteRow(db);
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
</script>
<script type="text/javascript">
function text0() {
document.getElementById("td_tidur2").value = "" + "" + document.getElementById("td_tidur").value + "\n" }
function text1() {
document.getElementById("duduk2").value = "" + "" + document.getElementById("duduk").value + "\n" }
function text2() {
document.getElementById("nadi2").value = "" + "" + document.getElementById("nadi").value + "\n" }
function text3() {
document.getElementById("respirasi2").value = "" + "" + document.getElementById("respirasi").value + "\n" }
function text4() {
document.getElementById("suhu2").value = "" + "" + document.getElementById("suhu").value + "\n" }
function text5() {
document.getElementById("keluhan2").value = "" + "" + document.getElementById("keluhan").value + "\n" }
function text6() {
document.getElementById("perawat11").value = "" + "" + document.getElementById("perawat1").value + "\n" }
function text7() {
document.getElementById("perawat22").value = "" + "" + document.getElementById("perawat2").value + "\n" }
</script>

<script>
$(document).ready(function(){
    var inpA = "input[rel=Ajumlah]";
    var inpB = "input[rel=Bjumlah]";
    
    $(inpA).bind('keyup',function() {
        var avalA=0;
        var bVal = parseInt($('#jumlah2').val(),10);
        $(inpA).each(function() {
            if(this.value !='') avalA += parseInt(this.value,10);
        });
        $('#jumlah').val(avalA);
        $('#total').val(avalA - bVal);
        console.log('Value avalA: ' + avalA);
    });
    
    $(inpB).bind('keyup',function() {
        var avalB=0;
        var aVal = parseInt($('#jumlah').val(),10);
        $(inpB).each(function() {
            if(this.value !='') avalB += parseInt(this.value,10);
        });
        $('#jumlah2').val(avalB);
        $('#total').val(aVal - avalB);
        console.log('Value avalB: ' + avalB);
    });
});
</script>

</html>
