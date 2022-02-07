<?php
session_start();
include("../sesi.php");
include("../koneksi/konek.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUsr'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit, kk.no_reg as no_reg2,
k.cara_keluar
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_pasien_keluar k ON k.pelayanan_id=pl.id
LEFT JOIN b_kunjungan kk ON kk.id=pl.kunjungan_id
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
$sqlKm="SELECT tk.tgl_in,tk.tgl_out FROM b_tindakan_kamar tk 
LEFT JOIN b_pelayanan p ON p.id=tk.pelayanan_id
WHERE tk.pelayanan_id='$idPel';";
$dK=mysql_fetch_array(mysql_query($sqlKm));
$usr=mysql_fetch_array(mysql_query("select * from b_ms_pegawai where id='$idUsr'"));

include "setting.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <!-- untuk ajax-->
        <script type="text/javascript" src="../theme/js/ajax.js"></script>
        <script type="text/javascript" src="../jquery.js"></script>
        <script type="text/javascript" src="../jquery.form.js"></script>
        <!-- end untuk ajax-->
        <script type="text/javascript" src="js/jquery.timeentry.js"></script>
        <script type="text/javascript">
$(function () 
{
	$('#jam_tiba').timeEntry({show24Hours: true, showSeconds: true});
	$('#jam_kaji').timeEntry({show24Hours: true, showSeconds: true});
});
</script>
        <title>CHECK LIST PENGKAJIAN KEPERAWATAN</title>
        <style>
        .gb{
	border-bottom:1px solid #000000;
}
.input150{
	width:90px;
	}
.input80{
	width:40px;
	}
.textArea{ width:97%;}
body{background:#FFF;}
        </style>
          <script type="text/JavaScript">
            var arrRange = depRange = [];
        </script>
</head>
    <body>
        <div align="center">
            <?php
           // include("../../header1.php");
            ?>
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
          <!--  <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
                <tr>
                    <td height="30">&nbsp;FORM RESUM MEDIS</td>
                </tr>
            </table>-->
            <table width="1000" border="0" cellspacing="0" cellpadding="2" align="center" >
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="3" align="center"><div id="form_in" style="display:none;">
                <form name="form1" id="form1" action="13. checklist_pengkajian_kep_act.php">
                <input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    			<input type="hidden" name="txtId" id="txtId"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
                
                <table width="1087" border="0" cellpadding="4" style="font:12px tahoma">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4" rowspan="6"><table width="390" border="0" cellpadding="4" style="border:1px solid #000000;">
        <tr>
          <td width="102">Nama Pasien </td>
          <td width="5">:</td>
          <td width="249"> <?=$nama;?> (<?=$sex;?>)</td>
        </tr>
        <tr>
          <td>Tanggal Lahir </td>
          <td>:</td>
          <td> <?=$tgl;?> /Usia : <?=$umur;?> th </td>
        </tr>
        <tr>
          <td>No. RM </td>
          <td>:</td>
          <td><?=$noRM;?>             No. Registrasi :
            <?=$dP['no_reg2']?></td>
        </tr>
        <tr>
          <td>Ruang rawat/Kelas </td>
          <td>:</td>
          <td><?=$kamar;?> / <?=$kelas;?></td>
        </tr>
        <tr>
          <td height="22">Alamat</td>
          <td>:</td>
          <td><?=$alamat;?></td>
        </tr>
            </table></td>
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
    <td><strong>CHECK LIST </strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><p><strong>PENGKAJIAN KEPERAWATAN</strong></p>    </td>
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
    <td width="182">Tiba diruangan </td>
    <td width="6">:</td>
    <td colspan="2">Tanggal : 
      <label for="tgl_tiba"></label>
      <input type="text" name="tgl_tiba" id="tgl_tiba" onclick="gfPop.fPopCalendar(document.getElementById('tgl_tiba'),depRange);" value="<?=date('d-m-Y')?>" /></td>
    <td colspan="2">Jam : 
      <input name="jam_tiba" type="text" class="input150" id="jam_tiba" value="<?=date('H:i:s')?>" /></td>
    <td width="82">&nbsp;</td>
    <td width="98">&nbsp;</td>
    <td width="99">&nbsp;</td>
    <td width="94">&nbsp;</td>
  </tr>
  <tr>
    <td>Pengkajian tanggal </td>
    <td>:</td>
    <td colspan="2">Tanggal : 
      <input type="text" name="tgl_kaji" id="tgl_kaji" onclick="gfPop.fPopCalendar(document.getElementById('tgl_kaji'),depRange);" value="<?=date('d-m-Y')?>" /></td>
    <td colspan="2">Jam : 
      <input name="jam_kaji" type="text" class="input150" id="jam_kaji" value="<?=date('H:i:s')?>"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>Masuk Melalui </td>
    <td>:</td>
    <td width="96"><input type="radio" name="radio[0]" value="1" id="radio[]" />
    UGD</td>
    <td width="127"><input type="radio" name="radio[0]" value="2" id="radio[]"/>
    Admission</td>
    <td width="103"><input type="radio" name="radio[0]" value="3" id="radio[]"/>
    Lain-lain</td>
    <td width="105">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Menggunakan</td>
    <td>:</td>
    <td><input type="radio" name="radio[1]" value="1" id="radio[]"/>
      Brankard</td>
    <td><input type="radio" name="radio[1]" value="2" id="radio[]"/>
      Kursi Roda </td>
    <td><input type="radio" name="radio[1]" value="3" id="radio[]"/>
      Jalan</td>
    <td colspan="5">Diantar Oleh <input type="text" name="txt_diantar" id="txt_diantar" /></td>
  </tr>
  <tr>
    <td height="38">Alat protase yang dipakai </td>
    <td>:</td>
    <td><input type="radio" name="radio[2]" value="1" id="radio[]"/>
      Kacamata </td>
    <td><input type="radio" name="radio[2]" value="2" id="radio[]"/>
      Gigi palsu </td>
    <td><input type="radio" name="radio[2]" value="3" id="radio[]"/>
      Tongkat</td>
    <td colspan="5">Lain-lain <input type="text" name="txt_protase" id="txt_protase" /></td>
  </tr>
  <tr>
    <td>Gelang identitas </td>
    <td>:</td>
    <td><input type="radio" name="radio[3]" value="1" id="radio[]"/>
      Terpasang</td>
    <td><input type="radio" name="radio[3]" value="2" id="radio[]"/>
      Belum Terpasang </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Diagnosa medis </td>
    <td>:</td>
    <td colspan="8"><input type="text" name="txt_diagnosa" id="txt_diagnosa" style="width:
    60%" /></td>
  </tr>
  <tr>
    <td>Riwayat penyakit saat ini </td>
    <td>:</td>
    <td colspan="8"><input type="text" name="txt_penyakit" id="txt_penyakit" style="width:
    60%"/></td>
  </tr>
  <tr>
    <td>Riwayat dirawat </td>
    <td>:</td>
    <td><input type="radio" name="radio[4]" value="2" id="radio[]"/>
      Tidak</td>
    <td><input type="radio" name="radio[4]" value="1" id="radio[]"/>
      Ya</td>
    <td colspan="2">Kapan <input type="text" name="txt_rawatKpn" id="txt_rawatKpn" /></td>
    <td colspan="2">Dimana <input type="text" name="txt_dirawatDmn" id="txt_dirawatDmn" /></td>
    <td colspan="2">Sakit Apa 
      <input type="text" name="txt_sakitApa" id="txt_sakitApa" /></td>
  </tr>
  <tr>
    <td>Riwayat pengobatan dirumah </td>
    <td>:</td>
    <td colspan="8"><input type="text" name="txt_pengobatan" id="txt_pengobatan" style="width:
    60%"/></td>
  </tr>
  <tr>
    <td>Riwayat alergi</td>
    <td>:</td>
    <td><input type="radio" name="radio[5]" value="2" id="radio[]"/>
      Tidak</td>
    <td><input type="radio" name="radio[5]" value="1" id="radio[]"/>
      Ya</td>
    <td colspan="2">Jenis <input type="text" name="txt_alergiJns" id="txt_alergiJns" /></td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Riwayat Tranfusi </td>
    <td>:</td>
    <td><input type="radio" name="radio[6]" value="2" id="radio[]"/>
      Tidak</td>
    <td><input type="radio" name="radio[6]" value="1" id="radio[]"/>
      Ya</td>
    <td>Reaksi Alergi </td>
    <td colspan="2"><input type="radio" name="radio[7]" value="1" id="radio[]"/>
      Ada</td>
    <td><input type="radio" name="radio[7]" value="2" id="radio[]"/>
    Tidak</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Riwayat Penyakit Keluarga </td>
    <td>:</td>
    <td><input type="radio" name="radio[8]" value="2" id="radio[]"/>
    Tidak</td>
    <td><input type="radio" name="radio[8]" value="1" id="radio[]"/>
    Ya</td>
    <td><input type="checkbox" name="c_chk[0]" value="jantung" id="c_chk[]" />
    Jantung</td>
    <td><input type="checkbox" name="c_chk[1]" value="diabetes" id="c_chk[]" />
    Diabetes</td>
    <td><input type="checkbox" name="c_chk[2]" value="cancer" id="c_chk[]" />
    Cancer</td>
    <td><input type="checkbox" name="c_chk[3]" value="hipertensi" id="c_chk[]" />
    Hipertensi</td>
    <td><input type="checkbox" name="c_chk[4]" value="tbc" id="c_chk[]" />
    TBC</td>
    <td><input type="checkbox" name="c_chk[5]" value="anemia" id="c_chk[]" />
    Anemia</td>
  </tr>
  <tr>
    <td>Status Perkawinan </td>
    <td>:</td>
    <td><input type="radio" name="radio[15]" value="1" id="radio[]"/>
      Menikah</td>
    <td><input type="radio" name="radio[15]" value="2" id="radio[]"/>
      Belum Menikah </td>
    <td><input type="radio" name="radio[15]" value="3" id="radio[]"/>
      Janda/duda</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="1052" colspan="10"><table width="1082" border="0" style="border-collapse:collapse" cellpadding="3">
      <tr>
        <td colspan="8" style="border:1px solid #000000"><div align="center">DATA</div></td>
        <td colspan="3"style="border:1px solid #000000"><div align="center">MASALAH</div></td>
        <td style="border:1px solid #000000"><div align="center">TGL DITEMUKAN </div></td>
      </tr>
      <tr>
        <td width="12" style="border-left:1px solid #000000">1</td>
        <td width="112"><strong>GCS</strong></td>
        <td width="141">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td width="145">&nbsp;</td>
        <td width="73">&nbsp;</td>
        <td width="72" style="border-right:1px solid #000000">&nbsp;</td>
        <td width="11">&nbsp;</td>
        <td width="22">&nbsp;</td>
        <td width="174" style="border-right:1px solid #000000">&nbsp;</td>
        <td width="91" style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Motorik</td>
        <td><input type="radio" name="radio[9]" value="1" id="radio[]"/>
          Kuat</td>
        <td colspan="2"><input type="radio" name="radio[9]" value="2" id="radio[]"/>
          Lemah</td>
        <td><input type="radio" name="radio[9]" value="3" id="radio[]"/>
          Hemiparese</td>
        <td><input type="radio" name="radio[9]" value="4" id="radio[]"/>
          Kanan</td>
        <td  style="border-right:1px solid #000000"><input type="radio" name="radio[9]" value="5" id="radio[]"/>
          Kiri</td>
        <td>&nbsp;</td>
        <td colspan="2" style="border-right:1px solid #000000"><input type="checkbox" name="c_chk[6]" value="1" id="c_chk[]" />
          Gangguan Fungsi cerebral</td>
        <td align="center" style="border-right:1px solid #000000"><input name="tgl_cerebal" type="text" class="input150" id="tgl_cerebal"  onclick="gfPop.fPopCalendar(document.getElementById('tgl_cerebal'),depRange);"  /></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Berbicara</td>
        <td><input type="radio" name="radio[10]" value="1" id="radio[]"/>
          Normal</td>
        <td colspan="2"><input type="radio" name="radio[10]" value="2" id="radio[]"/>
          Apasia</td>
        <td><input type="radio" name="radio[10]" value="3" id="radio[]"/>
          Gagap</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td colspan="3" style="border-right:1px solid #000000">&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Penglihatan</td>
        <td><input type="radio" name="radio[11]" value="1" id="radio[]"/>
          Tidak Jelas </td>
        <td colspan="2"><input type="radio" name="radio[11]" value="2" id="radio[]"/>
          Jelas</td>
        <td><input type="radio" name="radio[11]" value="3" id="radio[]"/>
          Kanan</td>
        <td><input type="radio" name="radio[11]" value="4" id="radio[]"/>
          Kiri</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td colspan="3" style="border-right:1px solid #000000">&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Pendengaran</td>
        <td><input type="radio" name="radio[12]" value="2" id="radio[]"/>
          Tidak jelas </td>
        <td colspan="2"><input type="radio" name="radio[12]" value="1" id="radio[]"/>
          Jelas</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td colspan="3" style="border-right:1px solid #000000">&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Tinggi Badan </td>
        <td colspan="2"><input name="txt_tingBdn" type="text" class="input80" id="txt_tingBdn" /> 
          cm</td>
        <td colspan="3">Berat badan
          <input name="txt_brtBdn" type="text" class="input80" id="txt_brtBdn" />
          kg </td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td colspan="3" style="border-right:1px solid #000000">&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>TD</td>
        <td colspan="6" style="border-right:1px solid #000000"><input name="txt_TD" type="text" class="input80" id="txt_TD" /> 
          mmHg &nbsp;&nbsp;&nbsp;HR 
          <input name="txt_HR" type="text" class="input80" id="txt_HR" /> 
          x/menit &nbsp;&nbsp;&nbsp;RR 
          <input name="txt_RR" type="text" class="input80" id="txt_RR" /> 
          x/menit &nbsp; &nbsp;&nbsp;Suhu <input name="txt_Suhu" type="text" class="input80" id="txt_Suhu" /> 
                    &deg;C</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Suara Nafas </td>
        <td><input type="radio" name="radio[13]" value="1" id="radio[]"/>
          Vesikuler</td>
        <td colspan="2"><input type="radio" name="radio[13]" value="2" id="radio[]"/>
          Ronchi</td>
        <td><input type="radio" name="radio[13]" value="3" id="radio[]"/>
          Wheezing</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" style="border-right:1px solid #000000"><input type="checkbox" name="c_chk[7]" value="1" id="c_chk[]" />
          Gangguan Pertukaran gas </td>
        <td align="center" style="border-right:1px solid #000000"><input name="tgl_gas" type="text" class="input150" id="tgl_gas"  onclick="gfPop.fPopCalendar(document.getElementById('tgl_gas'),depRange);"  /></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Sputum</td>
        <td><input type="radio" name="radio[14]" value="1" id="radio[]"/>
          Tidak ada </td>
        <td colspan="2"><input type="radio" name="radio[14]" value="2" id="radio[]"/>
          Ada</td>
        <td><input type="radio" name="radio[14]" value="3" id="radio[]"/>
          Kental</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" style="border-right:1px solid #000000"><input type="checkbox" name="c_chk[8]" value="1" id="c_chk[]" />
          Bersihan Jalan Nafas Tidak Efektif </td>
        <td align="center" style="border-right:1px solid #000000"><input name="tgl_BJNTE" type="text" class="input150" id="tgl_BJNTE"  onclick="gfPop.fPopCalendar(document.getElementById('tgl_BJNTE'),depRange);" /></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td><input type="radio" name="radio[14]" value="4" id="radio[]"/>
          Putih</td>
        <td colspan="2"><input type="radio" name="radio[14]" value="5" id="radio[]"/>
          Kuning</td>
        <td><input type="radio" name="radio[14]" value="6" id="radio[]"/>
          Kemerahan </td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" style="border-right:1px solid #000000"><input type="checkbox" name="c_chk[9]" value="1" id="c_chk[]" />
          Gangguan termoregulasi</td>
        <td align="center"  style="border-right:1px solid #000000"><input name="tgl_termogulasi" type="text" class="input150" id="tgl_termogulasi"  onclick="gfPop.fPopCalendar(document.getElementById('tgl_termogulasi'),depRange);"  /></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Makan</td>
        <td><input type="radio" name="radio[16]" value="1" id="radio[]"/>
          Nafsu</td>
        <td colspan="2"><input type="radio" name="radio[16]" value="2" id="radio[]"/>
          Kurang</td>
        <td><input type="radio" name="radio[16]" value="3" id="radio[]"/>
          Tidak ada </td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000"><input type="radio" name="radio[34]" value="1" id="radio[]"/>
          Hypotermi</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td><input type="radio" name="radio[16]" value="4" id="radio[]"/>
          Mual</td>
        <td colspan="2"><input type="radio" name="radio[16]" value="5" id="radio[]"/>
          Muntah</td>
        <td><input type="radio" name="radio[16]" value="6" id="radio[]"/>
          Sukar Menelan </td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000"><input type="radio" name="radio[34]" value="2" id="radio[]"/>
          Hypotermia</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td height="16" style="border-left:1px solid #000000">&nbsp;</td>
        <td>Frekuensi Minum </td>
        <td colspan="3">
          <input name="txt_minumX" type="text" class="input80" id="txt_minumX" />
         x/hari &nbsp; 
        <input name="txt_minumCC" type="text" class="input80" id="txt_minumCC" />
         cc/hari </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" style="border-right:1px solid #000000"><input type="checkbox" name="c_chk[10]" value="1" id="c_chk[]" />
          Gangguan Kebutuhan Nutrisi </td>
        <td align="center" style="border-right:1px solid #000000"><input name="tgl_kebNutrisi" type="text" class="input150" id="tgl_kebNutrisi"  onclick="gfPop.fPopCalendar(document.getElementById('tgl_kebNutrisi'),depRange);" /></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>BAK</td>
        <td colspan="6" style="border-right:1px solid #000000">Jumlah 
          <input name="txt_BAK" type="text" class="input80" id="txt_BAK" /> 
          cc/hari&nbsp;&nbsp;&nbsp;&nbsp; warna
          <input name="txt_BAKwarna" type="text" class="input80" id="txt_BAKwarna" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000"><input type="radio" name="radio[35]" value="1" id="radio[]"/>
          Kekurangan Nutrisi </td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td height="16" style="border-left:1px solid #000000">&nbsp;</td>
        <td>Bila Muntah </td>
        <td colspan="6" style="border-right:1px solid #000000">Frekuensi 
          <input name="txt_muntahX" type="text" class="input80" id="txt_muntahX" />
          x/hari&nbsp;&nbsp;&nbsp;&nbsp; warna 
          <input name="txt_muntahWarna" type="text" class="input80" id="txt_muntahWarna" />&nbsp;&nbsp;&nbsp;&nbsp; isi 
          <input name="txt_muntahIsi" type="text" class="input80" id="txt_muntahIsi" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000"><input type="radio" name="radio[35]" value="2" id="radio[]"/>
          Kelebihan Nutrisi </td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td height="16" style="border-left:1px solid #000000">&nbsp;</td>
        <td>Bila hematemeis </td>
        <td>
          <input name="txt_hematX" type="text" class="input80" id="txt_hematX" />
         x/hari</td>
        <td colspan="2" >jumlah 
          <input name="txt_hematJml" type="text" class="input80" id="txt_hematJml" />
       x/hari </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td colspan="3" style="border-right:1px solid #000000">&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Asites</td>
        <td><input type="radio" name="radio[17]" value="1" id="radio[]"/>
          Ya</td>
        <td colspan="2"><input type="radio" name="radio[17]" value="2" id="radio[]"/>
          Tidak</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" style="border-right:1px solid #000000"><input type="checkbox" name="c_chk[11]" value="1" id="c_chk[]" />
          Gangguan Volume cairan </td>
        <td align="center" style="border-right:1px solid #000000"><input name="tgl_volCairan" type="text" class="input150" id="tgl_volCairan"  onclick="gfPop.fPopCalendar(document.getElementById('tgl_volCairan'),depRange);"  /></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Turgor </td>
        <td><input type="radio" name="radio[18]" value="1" id="radio[]"/>
          Elastis</td>
        <td colspan="2"><input type="radio" name="radio[18]" value="2" id="radio[]"/>
          Tidak Elastis </td>
        <td>Lokasi 
          <input name="txt_tugor" type="text" class="input150" id="txt_tugor"  />
        </td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000"><input type="radio" name="radio[36]" value="1" id="radio[]"/>
          Kelebihan</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Edema</td>
        <td><input type="radio" name="radio[19]" value="1" id="radio[]"/>
          Ya</td>
        <td colspan="2"><input type="radio" name="radio[19]" value="2" id="radio[]"/>
          Tidak</td>
        <td>Lokasi
          <input name="txt_edema" type="text" class="input150" id="txt_edema"  /></td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000"><input type="radio" name="radio[36]" value="2" id="radio[]"/>
          Kekurangan</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>BAB</td>
        <td><input type="radio" name="radio[20]" value="1" id="radio[]"/>
          Padat</td>
        <td colspan="2"><input type="radio" name="radio[20]" value="2" id="radio[]"/>
          Cair</td>
        <td>Frekuensi 
          <input name="txt_BAB" type="text" class="input80" id="txt_BAB" />
        /hari</td>
        <td colspan="2" style="border-right:1px solid #000000">Jumlah 
          <input name="txt_BABcc" type="text" class="input80" id="txt_BABcc" />
          cc/hari</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Peristaltik</td>
        <td><input type="radio" name="radio[21]" value="1" id="radio[]"/>
          Lemah</td>
        <td colspan="2"><input type="radio" name="radio[21]" value="2" id="radio[]"/>
          Aktif</td>
        <td><input type="radio" name="radio[21]" value="3" id="radio[]"/>
          Hiperaktif</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" style="border-right:1px solid #000000"><input type="checkbox" name="c_chk[12]" value="1" id="c_chk[]" />
          Gangguan Pola Eliminasi Urine </td>
        <td align="center" style="border-right:1px solid #000000"><input name="tgl_GPEU" type="text" class="input150" id="tgl_GPEU"  onclick="gfPop.fPopCalendar(document.getElementById('tgl_GPEU'),depRange);" /></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Bila melena </td>
        <td>
          <input name="txt_melena" type="text" class="input80" id="txt_melena" />
         x/hari</td>
        <td colspan="2">Jumlah 
          <input name="txt_melenaJml" type="text" class="input80" id="txt_melenaJml" />
         /hari</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000"><input type="radio" name="radio[37]" value="1" id="radio[]"/>
          Ratensio Urine </td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Masalah tidur </td>
        <td><input type="radio" name="radio[22]" value="1" id="radio[]"/>
          Ada</td>
        <td colspan="2"><input type="radio" name="radio[22]" value="2" id="radio[]"/>
          Tidak ada </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000"><input type="radio" name="radio[37]" value="2" id="radio[]"/>
          Inkontinesia</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Bila Fraktur </td>
        <td>Lokasi <input name="txt_fraktur" type="text" class="input150" id="txt_fraktur"  /></td>
        <td colspan="2">Terpasang traksi </td>
        <td><input type="radio" name="radio[23]" value="1" id="radio[]"/>
          Ya</td>
        <td><input type="radio" name="radio[23]" value="2" id="radio[]"/>
          Tidak</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">Terpasang gibs </td>
        <td><input type="radio" name="radio[24]" value="1" id="radio[]"/>
          Ya</td>
        <td><input type="radio" name="radio[24]" value="2" id="radio[]"/>
          Tidak</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" style="border-right:1px solid #000000"><input type="checkbox" name="c_chk[13]" value="1" id="c_chk[]" />
          Gangguan Pola Eliminasi Alvi </td>
        <td align="center" style="border-right:1px solid #000000"><input name="tgl_GPEA" type="text" class="input150" id="tgl_GPEA"  onclick="gfPop.fPopCalendar(document.getElementById('tgl_GPEA'),depRange);" /></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Resiko jatuh </td>
        <td>score 
          <input name="txt_score" type="text" class="input80" id="txt_score" />
        </td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000"><input type="radio" name="radio[38]" value="1" id="radio[]"/>
          Konstipasi</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Terpasang alat invasif </td>
        <td><input type="radio" name="radio[25]" value="1" id="radio[]" />
          Infus</td>
        <td colspan="2"><input type="radio" name="radio[25]" value="2"  id="radio[]"/>
          NGT</td>
        <td><input type="radio" name="radio[25]" value="3"  id="radio[]"/>
          Cateter</td>
        <td><input type="radio" name="radio[25]" value="4" id="radio[]" />
          CVP</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000"><input type="radio" name="radio[38]" value="2" id="radio[]" />
          Diare</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td><input type="radio" name="radio[25]" value="5" id="radio[]" />
          Drain</td>
        <td colspan="2"><input type="radio" name="radio[25]" value="6" id="radio[]" />
          ETT</td>
        <td>Lain-lain <input name="txt_invasif" type="text" class="input150" id="txt_invasif"  /></td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td colspan="3" style="border-right:1px solid #000000">&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Bila terpasang infus </td>
        <td>Lokasi <input name="txt_infus" type="text" class="input150" id="txt_infus"  /></td>
        <td width="38">Plebitis</td>
        <td width="93"><input type="radio" name="radio[40]" value="1"  id="radio[]"/>
          Ya</td>
        <td><input type="radio" name="radio[40]" value="2" id="radio[]" />
          Tidak</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" style="border-right:1px solid #000000"><input type="checkbox" name="c_chk[14]" value="1" id="c_chk[]" />
          Gangguan Mobilitas Fisik </td>
        <td align="center" style="border-right:1px solid #000000"><input name="tgl_mobFisik" type="text" class="input150" id="tgl_mobFisik"  onclick="gfPop.fPopCalendar(document.getElementById('tgl_mobFisik'),depRange);" /></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td>Plebitis grade 
          <input name="txt_plebitis" type="text" class="input80" id="txt_plebitis" /></td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td colspan="3" style="border-right:1px solid #000000">&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Kebersihan Mulut </td>
        <td><input type="radio" name="radio[26]" value="1" id="radio[]" />
          Caries</td>
        <td colspan="2"><input type="radio" name="radio[26]" value="2"  id="radio[]"/>
          Bau</td>
        <td><input type="radio" name="radio[26]" value="3" id="radio[]" /> Tidak berbau </td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td colspan="3" style="border-right:1px solid #000000">&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Gigi palsu </td>
        <td><input type="radio" name="radio[27]" value="1"  id="radio[]"/>
          Ada</td>
        <td colspan="2"><input type="radio" name="radio[27]" value="2" id="radio[]" />
          Tidak ada </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td colspan="3" style="border-right:1px solid #000000">&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Kulit</td>
        <td><input type="radio" name="radio[28]" value="1" id="radio[]" />
          Bersih</td>
        <td colspan="2"><input type="radio" name="radio[28]" value="2" id="radio[]" />
          Kotor</td>
        <td><input type="radio" name="radio[28]" value="3" id="radio[]" />
          Ikterik</td>
        <td><input type="radio" name="radio[28]" value="4" id="radio[]" />
          Luka</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" style="border-right:1px solid #000000"><input type="checkbox" name="c_chk[15]" value="1" id="c_chk[]" />
          Gangguan Integritas Kulit </td>
        <td align="center" style="border-right:1px solid #000000"><input name="tgl_integritas" type="text" class="input150" id="tgl_integritas"  onclick="gfPop.fPopCalendar(document.getElementById('tgl_integritas'),depRange);"  /></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td>Lokasi <input name="txt_kulitLok" type="text" class="input150" id="txt_kulitLok"  /></td>
        <td colspan="2">Grade <input name="txt_kulitGrade" type="text" class="input150" id="txt_kulitGrade"  /></td>
        <td>Ukuran <input name="txt_kulitUkr" type="text" class="input150" id="txt_kulitUkr"  /></td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td colspan="3" style="border-right:1px solid #000000">&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Turgor</td>
        <td><input type="radio" name="radio[29]" value="1"  id="radio[]"/>
          Elastis</td>
        <td colspan="2"><input type="radio" name="radio[29]" value="2" id="radio[]" />
          Tidak elastis </td>
        <td>Lokasi <input name="txt_tugorLok" type="text" class="input150" id="txt_tugorLok"  /></td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td colspan="3" style="border-right:1px solid #000000">&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Edema</td>
        <td><input type="radio" name="radio[30]" value="2"  id="radio[]"/>
          Tidak</td>
        <td colspan="2"><input type="radio" name="radio[30]" value="1"  id="radio[]"/>
          Ya</td>
        <td>Lokasi <input name="txt_edemaLok" type="text" class="input150" id="txt_edemaLok"  /></td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td colspan="3" style="border-right:1px solid #000000">&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Rambut</td>
        <td><input type="radio" name="radio[31]" value="1" id="radio[]" />
          Bersih</td>
        <td colspan="2"><input type="radio" name="radio[31]" value="2" id="radio[]" />
          Kotor</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" style="border-right:1px solid #000000"><input type="checkbox" name="c_chk[16]" value="1" id="c_chk[]" />
          Ketidakmampuan merawat diri </td>
        <td align="center" style="border-right:1px solid #000000"><input name="tgl_rawatDiri" type="text" class="input150" id="tgl_rawatDiri"  onclick="gfPop.fPopCalendar(document.getElementById('tgl_rawatDiri'),depRange);" /></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Kebiasaan</td>
        <td><input type="radio" name="radio[32]" value="1" id="radio[]" />
          Merokok</td>
        <td colspan="2"><input type="radio" name="radio[32]" value="2"  id="radio[]"/>
          Kopi</td>
        <td><input type="radio" name="radio[32]" value="3"  id="radio[]"/>
          Obat-obatan</td>
        <td colspan="2" style="border-right:1px solid #000000">Nama obat 
          <input name="txt_nmObat" type="text" class="input150" id="txt_nmObat"  /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Ekspresi emosi </td>
        <td><input type="radio" name="radio[33]" value="1" id="radio[]" />
          Tenang</td>
        <td colspan="2"><input type="radio" name="radio[33]" value="2" id="radio[]" />
          Cemas</td>
        <td><input type="radio" name="radio[33]" value="3" id="radio[]" />
          Marah</td>
        <td><input type="radio" name="radio[33]" value="4"  id="radio[]"/>
          Sedih</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" style="border-right:1px solid #000000"><input type="checkbox" name="c_chk[17]" value="1" id="c_chk[]" />
          Gangguan Psikiatrik </td>
        <td align="center" style="border-right:1px solid #000000"><input name="tgl_psikiatrik" type="text" class="input150" id="tgl_psikiatrik"  onclick="gfPop.fPopCalendar(document.getElementById('tgl_psikiatrik'),depRange);" /></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td><input type="radio" name="radio[33]" value="5"  id="radio[]"/>
          Takut</td>
        <td colspan="2"><input type="radio" name="radio[33]" value="6" id="radio[]" />
          Senang</td>
        <td><input type="radio" name="radio[33]" value="7" id="radio[]" />
          Menyendiri</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000"><input type="radio" name="radio[39]" value="1" id="radio[]" />
          Cemas</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td><input type="radio" name="radio[33]" value="8" id="radio[]" />
          Agitasi/merusak</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000"><input type="radio" name="radio[39]" value="2" id="radio[]" />
          Depresi</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000"><input type="radio" name="radio[39]" value="3" id="radio[]" />
          Perilaku Bunuh Diri </td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">2</td>
        <td colspan="7" style="border-right:1px solid #000000">Skala Intensitas Nyeri Numerik 0-10 Lokasi 
          <input name="txt_intensitas" type="text" class="input80" id="txt_intensitas" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="8" style="border-left:1px solid #000000;border-bottom:1px solid #000000;border-right:1px solid #000000;">&nbsp;</td>
        <td style="border-bottom:1px solid #000000">&nbsp;</td>
        <td colspan="2" style="border-bottom:1px solid #000000;border-right:1px solid #000000"><input type="checkbox" name="c_chk[]" value="1" />
          Gangguan rasa nyaman nyeri </td>
        <td align="center" style="border-bottom:1px solid #000000;border-right:1px solid #000000">
          <input name="tgl_nyeri" type="text" class="input150" id="tgl_nyeri"  onclick="gfPop.fPopCalendar(document.getElementById('tgl_nyeri'),depRange);" />
       </td>
      </tr>
    </table></td>
  </tr>
</table>
             </form>   
             <div align="center"><input type="button" name="bt_save" id="bt_save" class="tblTambah" value="Simpan" onclick="return simpan()" />&nbsp;
  <input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/></div>
                </div></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="45%"><?php
                    if($_REQUEST['report']!=1){
					?>
                        <input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="tambah(this.value);" class="tblTambah"/>
                      <input type="button" id="btnHapus" name="btnHapus" value="Edit" onclick="edit();" class="tblTambah"/>
                        <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus();" class="tblHapus"/><?php }?>
                  </td>
                    <td width="20%"><button type="button" id="btnTree" name="btnTree" value="Tampilan Tree" onclick="cetak()" class="tblViewTree" >Cetak</button></td>
                    <td width="5%">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="center" colspan="3">
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
  <!--    <table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
                <tr>
                    <td height="30">&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;"/></td>
                    <td></td>
                    <td align="right">
                        <a href="<?=$host?>/simrs-tangerang/billing/index.php">
                            <input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;"/>
                        </a>&nbsp;
                    </td>
        </tr>
          </table>-->
        </div>
    </body>
<script type="text/javascript">

		function toggle() {
    parent.alertsize(document.body.scrollHeight);
}


        function simpan(action){
            if(ValidateForm('tgl_tiba,txt_diagnosa','ind')){
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
			
			$('#txtId').val(sisip[0]);
			$('#tgl_tiba').val(a.cellsGetValue(a.getSelRow(),3));
			$('#jam_tiba').val(a.cellsGetValue(a.getSelRow(),4));
			$('#txt_diagnosa').val(a.cellsGetValue(a.getSelRow(),5));
			$('#act').val('edit');
			centang(sisip[1]);
			 var p="tgl_kaji*-*"+sisip[2]
			 +"*|*jam_kaji*-*"+sisip[3]
			 +"*|*txt_diantar*-*"+sisip[4]
			 +"*|*txt_protase*-*"+sisip[5]
			 +"*|*txt_penyakit*-*"+sisip[6]
			 +"*|*txt_rawatKpn*-*"+sisip[7]
			 +"*|*txt_dirawatDmn*-*"+sisip[8]
			 +"*|*txt_sakitApa*-*"+sisip[9]
			 +"*|*txt_pengobatan*-*"+sisip[10]
			 +"*|*txt_alergiJns*-*"+sisip[11]
			 +"*|*txt_tingBdn*-*"+sisip[12]
			 +"*|*txt_brtBdn*-*"+sisip[13]+
			 "*|*txt_TD*-*"+sisip[14]			 
			 +"*|*txt_HR*-*"+sisip[15]
			 +"*|*txt_RR*-*"+sisip[16]
			 +"*|*txt_Suhu*-*"+sisip[17]
			 +"*|*txt_minumX*-*"+sisip[18]
			 +"*|*txt_minumCC*-*"+sisip[19]
			 +"*|*txt_BAK*-*"+sisip[20]
			 +"*|*txt_BAKwarna*-*"+sisip[21]
			 +"*|*txt_muntahX*-*"+sisip[22]
			 +"*|*txt_muntahWarna*-*"+sisip[23]
			 +"*|*txt_muntahIsi*-*"+sisip[24]
			 +"*|*txt_hematX*-*"+sisip[25]
			 +"*|*txt_hematJml*-*"+sisip[26]
			 +"*|*txt_tugor*-*"+sisip[27]
			 +"*|*txt_edema*-*"+sisip[28]
			 +"*|*txt_BAB*-*"+sisip[29]
			 +"*|*txt_BABcc*-*"+sisip[30]
			 +"*|*txt_melena*-*"+sisip[31]
			 +"*|*txt_melenaJml*-*"+sisip[32]
			 +"*|*txt_fraktur*-*"+sisip[33]
			 +"*|*txt_score*-*"+sisip[34]
			 +"*|*txt_invasif*-*"+sisip[35]
			 +"*|*txt_infus*-*"+sisip[36]
			 +"*|*txt_plebitis*-*"+sisip[37]
			 +"*|*txt_kulitLok*-*"+sisip[38]
			 +"*|*txt_kulitGrade*-*"+sisip[39]
			 +"*|*txt_kulitUkr*-*"+sisip[40]
			 +"*|*txt_tugorLok*-*"+sisip[41]
			 +"*|*txt_edemaLok*-*"+sisip[42]
			 +"*|*txt_nmObat*-*"+sisip[43]
			 +"*|*txt_intensitas*-*"+sisip[44]
			 +"*|*tgl_cerebal*-*"+sisip[45]
			 +"*|*tgl_gas*-*"+sisip[46]
			 +"*|*tgl_BJNTE*-*"+sisip[47]
			 +"*|*tgl_termogulasi*-*"+sisip[48]
			 +"*|*tgl_kebNutrisi*-*"+sisip[49]
			 +"*|*tgl_volCairan*-*"+sisip[50]
			 +"*|*tgl_GPEU*-*"+sisip[51]
			 +"*|*tgl_GPEA*-*"+sisip[52]
			 +"*|*tgl_mobFisik*-*"+sisip[53]
			 +"*|*tgl_integritas*-*"+sisip[54]
			 +"*|*tgl_rawatDiri*-*"+sisip[55]
			 +"*|*tgl_psikiatrik*-*"+sisip[56]
			 +"*|*tgl_nyeri*-*"+sisip[57]
			 +"";
			 
			 
            fSetValue(window,p);
        }

        function hapus(){
            var rowid = document.getElementById("txtId").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(rowid==''){
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
            var rowid = document.getElementById("txtId").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(rowid==''){
					alert("Pilih data terlebih dahulu");
				}else{
					$('#act').val('edit');
					$('#form_in').slideDown(1000,function(){
	toggle();
		});
				}

        }

        function batal(){
			resetF();
			$('#form_in').slideUp(1000,function(){
		toggle();
		});
        }
		
		function resetF(){
			$('#act').val('tambah');
			$('#txtId').val('');
			document.form1.reset();
           
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
            a.loadURL("13. checklist_pengkajian_kep_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Data Check List Pengkajian Perawat");
        a.setColHeader("NO,NO RM,TGL Tiba,Jam Tiba,Diagnosa,TGL INPUT,PENGGUNA");
        a.setIDColHeader(",no_rm,,,,,");
        a.setColWidth("50,100,100,100,300,100,100");
        a.setCellAlign("center,center,center,center,left,center,center");
        a.setCellHeight(20);
        a.setImgPath("../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("13. checklist_pengkajian_kep_util.php?idPel=<?=$idPel?>");
        a.Init();
		
		function tambah(){
			resetF();
			$('#form_in').slideDown(1000,function(){
		toggle();
		});
			
			}
		
		function cetak(){
		 var rowid = document.getElementById("txtId").value;
		 if(rowid==""){
				var rowidx =a.getRowId(a.getSelRow()).split('|');
				rowid=rowidx[0];
			 }
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			//if(rowid==''){
//					alert("Pilih data terlebih dahulu");
//				}else{	
		window.open("13. checklist_pengkajian_kep.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUsr?>","_blank");
				//}
		}
		
function centang(tes){
		var list=tes.split('*=*');
		var list1 = document.form1.elements['radio[]'];
		var list2 = document.form1.elements['c_chk[]'];
				 
		if ( list1.length > 0 )
		{
		 for (i = 0; i < 41; i++)
			{
			var val=list[0].split(',');	
			var listx = document.form1.elements['radio['+i+']'];
					//alert('radio['+i+']');
			for (j = 0; j < listx.length; j++)
			{
				if (listx[j].value==val[i])
			  	{
			   		listx[j].checked = true;
			  	}else{
					listx[j].checked = false;
					}	
			}
		  }
		}
		
		if ( list2.length > 0 )
		{
		 for (i = 0; i < list2.length; i++)
			{
			var val=list[1].split(',');
			  if (list2[i].value==val[i])
			  {
			   list2[i].checked = true;
			  }else{
					list2[i].checked = false;
					}
		  }
		}
	}
    </script>
    
</html>
