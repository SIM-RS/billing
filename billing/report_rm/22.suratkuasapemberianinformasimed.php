<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Surat Kuasa Pemberian Informasi Medik</title>
</head>
<?
include "../../koneksi/konek.php";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUser'];
$id=$_REQUEST['id'];
$idHub=$_REQUEST['idHub'];
$id = $_GET['id'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,IFNULL(pg.nama,'-') AS dr_rujuk,DATE_FORMAT(p.tgl_act, '%d %M %Y') AS tgl_masuk,l.nama AS nama2,l.alamat AS alamat2,l.ktp AS ktp2,l.hubungan,h.nama_hubungan as hubungan2
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
LEFT JOIN lap_inform_konsen l ON l.pelayanan_id=pl.id
LEFT JOIN b_ms_hubungan h ON h.id=l.hubungan
WHERE pl.id='$idPel'";
$dP=mysql_fetch_array(mysql_query($sqlP));
//include "setting.php";
$sql2="SELECT * FROM b_surat_kuasa_medis where pelayanan_id='$idPel'";
$dP2=mysql_fetch_array(mysql_query($sql2));
?>
<style>
.gb{
	border-bottom:1px solid #000000;
}
</style>
<body>
<table width="800" border="0" style="font:12px tahoma;">
  <tr>
    <td><table width="316" border="0" style="border:1px solid #000000;" align="right">
      <tr>
        <td style="font:bold 16px tahoma;"><div align="center">SURAT KUASA PEMBERIAN</div></td>
      </tr>
      <tr>
        <td style="font:bold 16px tahoma;"><div align="center">INFORMASI MEDIS</div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="800" border="0" style="border:1px solid #000000">
      <tr>
        <td><table cellspacing="0" cellpadding="0">
          <col width="15" />
          <col width="18" />
          <col width="26" />
          <col width="30" />
          <col width="133" />
          <col width="13" />
          <col width="23" span="2" />
          <col width="13" />
          <col width="23" span="2" />
          <col width="35" />
          <col width="89" />
          <col width="49" />
          <col width="25" />
          <col width="28" />
          <col width="23" />
          <col width="17" />
          <col width="25" span="2" />
          <col width="130" />
          <col width="26" />
          <tr height="12">
            <td height="12" width="15">&nbsp;</td>
            <td width="18">&nbsp;</td>
            <td width="26">&nbsp;</td>
            <td width="30">&nbsp;</td>
            <td width="133">&nbsp;</td>
            <td width="13">&nbsp;</td>
            <td width="23">&nbsp;</td>
            <td width="23">&nbsp;</td>
            <td width="13">&nbsp;</td>
            <td width="23">&nbsp;</td>
            <td width="23">&nbsp;</td>
            <td width="35">&nbsp;</td>
            <td width="89">&nbsp;</td>
            <td width="49">&nbsp;</td>
            <td width="25">&nbsp;</td>
            <td width="28">&nbsp;</td>
            <td width="23">&nbsp;</td>
            <td width="17">&nbsp;</td>
            <td width="25">&nbsp;</td>
            <td width="25">&nbsp;</td>
            <td width="130">&nbsp;</td>
            <td width="26">&nbsp;</td>
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
            <td colspan="8">No. Permintaan Informasi Medis: <?=$dP2['no_permintaan']?></td>
            <td>&nbsp;</td>
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
            <td colspan="5">Yang bertandatangan    dibawah ini:</td>
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
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="2">Nama</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="12">: 
              <?=$dP['nama2'];?>            </td>
            <td>&nbsp;</td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="3">Alamat</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="12">: 
              <?=$dP['alamat2'];?>           	</td>
            <td>&nbsp;</td>
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
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="3">No. KTP</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="12">: 
              <?=$dP['ktp2'];?></td>
            <td>&nbsp;</td>
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
            <td colspan="18">Selaku: 
			<?php echo ($dP['hubungan'] == 1 ? 'Pasien' : '<strike>Pasien</strike>' ) ?> /
			<?php echo ($dP['hubungan'] == 3 ? 'Suami' : '<strike>Suami</strike>' ) ?> /
			<?php echo ($dP['hubungan'] == 2 ? 'Istri' : '<strike>Istri</strike>' ) ?> /
			<?php echo ($dP['hubungan'] == 5 ? 'Orang Tua' : '<strike>Orang Tua</strike>' ) ?> /
			<?php echo ($dP['hubungan'] == 7 ? 'Ayah' : '<strike>Ayah</strike>' ) ?> /
            <?php echo ($dP['hubungan'] == 6 ? 'Ibu' : '<strike>Ibu</strike>' ) ?> /
            <?php echo ($dP['hubungan'] == 8 ? 'Wali' : '<strike>Wali</strike>' ) ?> /
            <?php echo ($dP['hubungan'] == 4 ? 'Anak' : '<strike>Anak</strike>' ) ?> /
			<?php echo ($dP['hubungan'] == 0 ? 'Penanggung jawab' : '<strike>Penanggung jawab</strike>' ) ?>*) yang mendapat</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td></td>
            <td></td>
            <td colspan="2"> Ijin tertulis dari pasien.</td>
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
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="4">Nama pasien</td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="12">: 
              <?=$dP['nama'];?></td>
            <td>&nbsp;</td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="4">Nomor Rekam Medis</td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="12">: 
              <?=$dP['no_rm'];?></td>
            <td>&nbsp;</td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="4">Tanggal Rawat</td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="12">: 
              <?=tgl_ina($dP['tgl_act']);?></td>
            <td>&nbsp;</td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="4">Dokter yang Merawat</td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="12">: <?=$dP['dr_rujuk'];?></td>
            <td>&nbsp;</td>
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
            <td colspan="20">Selanjutnya pihak diatas    disebut Pemberi Kuasa, dengan    ini memberikan kuasa kepada: 
              <?=$dP['nama2'];?></td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="20">RS PELINDO I, beralamat di Kota Medan
             </td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="7">(selanjutnya disebut    Penerima Kuasa) :</td>
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
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr height="32">
            <td height="32" colspan="22">-------------------------------------------------------------------------------------------K&nbsp; H&nbsp; U&nbsp;    S&nbsp; U&nbsp; S-----------------------------------------------------------------------------------</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table cellspacing="2">
          <col width="15" />
          <col width="18" />
          <col width="26" />
          <col width="30" />
          <col width="133" />
          <col width="13" />
          <col width="23" span="2" />
          <col width="13" />
          <col width="23" span="2" />
          <col width="35" />
          <col width="89" />
          <col width="49" />
          <col width="25" />
          <col width="28" />
          <col width="23" />
          <col width="17" />
          <col width="25" span="2" />
          <col width="130" />
          <col width="26" />
          <tr height="20">
            <td height="20" width="15">&nbsp;</td>
            <td width="18"></td>
            <td width="26"></td>
            <td width="30"></td>
            <td width="133"></td>
            <td width="13"></td>
            <td width="23"></td>
            <td width="23"></td>
            <td width="13"></td>
            <td width="23"></td>
            <td width="23"></td>
            <td width="35"></td>
            <td width="89"></td>
            <td width="49"></td>
            <td width="25"></td>
            <td width="28"></td>
            <td width="23"></td>
            <td width="17"></td>
            <td width="25"></td>
            <td width="25"></td>
            <td width="130"></td>
            <td width="26"></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="20">Untuk memberikan    informasi medis mengenai 
			<?php echo ($dP2['mengenai'] == 'Diri Saya' ? 'Diri Saya' : '<strike>Diri Saya</strike>' ) ?> /
			<?php echo ($dP2['mengenai'] == 'Pasien' ? 'Pasien' : '<strike>Pasien</strike>' ) ?> tersebut diatas*), baik secara    lisan maupun&nbsp;</td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="16">tertulis, sesuai dengan    kebijakan yang berlaku di lingkungan&nbsp; RS PELINDO I kepada</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="6">
			<?php echo ($dP2['kepada'] == 'Perorangan' ? 'Perorangan' : '<strike>Perorangan</strike>' ) ?> /
            <?php echo ($dP2['kepada'] == 'Perusahaan' ? 'Perusahaan' : '<strike>Perusahaan</strike>' ) ?> /
			<?php echo ($dP2['kepada'] == 'Asuransi' ? 'Asuransi' : '<strike>Asuransi</strike>' ) ?> *)</td>
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
            <td></td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="7">Fotocopy hasil    pemeriksaan yang diminta :</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td align="right">1</td>
            <td colspan="3">Hasil Resume Medis    tanggal</td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="13">: 
              <?=tgl_ina($dP2['tgl_r']);?></td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td align="right">2</td>
            <td colspan="3">Hasil laboratorium    tanggal</td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="13">: 
              <?=tgl_ina($dP2['tgl_l']);?></td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td align="right">3</td>
            <td colspan="3">Hasil Radiologi tanggal</td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="13">: 
              <?=tgl_ina($dP2['tgl_ra']);?></td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td align="right">4</td>
            <td colspan="3">Hasil Lain-lain</td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="14">: 
              <?=$dP2['hasil_lain'];?></td>
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
            <td colspan="20">Sehubungan dengan urusan    tersebut diatas, maka dengan ini Pemberi Kuasa membebaskan Penerima Kuasa</td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="20">dari segala tuntutan    atau konsekuensi hukum dari pihak ketiga, yang mungkin timbul sebagai akibat    pelepasan</td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="5">informasi medis pasien    tersebut.</td>
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
            <td colspan="8">Medan, <?=tgl_ina(date('Y-m-d'))?></td>
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
            <td colspan="4">Jam: <?php echo date("H:i:s")?></td>
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
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="4">Pemberi Kuasa,</td>
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
            <td colspan="5">(
              <strong><u><?=$dP['nama'];?></u></strong>
              )</td>
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
            <td height="20" colspan="22">--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table cellspacing="0" cellpadding="0">
          <col width="15" />
          <col width="18" />
          <col width="26" />
          <col width="30" />
          <col width="133" />
          <col width="13" />
          <col width="23" span="2" />
          <col width="13" />
          <col width="23" span="2" />
          <col width="35" />
          <col width="89" />
          <col width="49" />
          <col width="25" />
          <col width="28" />
          <col width="23" />
          <col width="17" />
          <col width="25" span="2" />
          <col width="130" />
          <col width="26" />
          <tr height="20">
            <td height="20" width="15">&nbsp;</td>
            <td width="18"></td>
            <td width="26"></td>
            <td width="30"></td>
            <td width="133"></td>
            <td width="13"></td>
            <td width="23"></td>
            <td width="23"></td>
            <td width="13"></td>
            <td width="23"></td>
            <td width="23"></td>
            <td width="35"></td>
            <td width="89"></td>
            <td width="49"></td>
            <td width="25"></td>
            <td width="28"></td>
            <td width="23"></td>
            <td width="17"></td>
            <td width="25"></td>
            <td width="25"></td>
            <td width="130"></td>
            <td width="26"></td>
          </tr>
          <tr height="20">
            <td colspan="22" height="20"><div align="center"><strong>BUKTI PENERIMAAN    INFORMASI MEDIS</strong></div></td>
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
            <td colspan="9">No. Permintaan Informasi Medis: <?=$dP2['no_permintaan']?></td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="5">Saya bertanda tangan di    bawah ini :</td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
            <td colspan="12">&nbsp;</td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="2">Nama</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="13">: 
              <?=$dP['nama2'];?></td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="3">Alamat</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="13">: 
              <?=$dP['alamat2'];?></td>
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
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="4">Hubungan dengan pasien</td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="13">: 
              <?=$dP['hubungan2'];?></td>
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
            <td colspan="15">Menerima dari RS PELINDO I informasi medis    dari pasien yang tersebut di atas</td>
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
            <td colspan="6">Medan, <?=tgl_ina(date('Y-m-d'))?></td>
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
            <td></td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="4"><div align="center">Yang menerima,</div></td>
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
            <td colspan="4">Yang memberi,</td>
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
            <td></td>
            <td></td>
            <td></td>
            <td colspan="4"><div align="center">Petugas Rekam Medis</div></td>
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
            <td colspan="4" align="center"><strong><u><?=$dP['nama2'];?></u></strong></td>
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
            <td colspan="4" align="center"><strong><u><?=$dP['dr_rujuk'];?></u></strong></td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="4"><div align="center">Nama &amp; Tanda tangan</div></td>
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
            <td colspan="4"><div align="center">Nama &amp; Tanda tangan</div></td>
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
            <td>*)</td>
            <td colspan="3">Coret yang tidak perlu</td>
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
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <table>
            <td colspan="2" align="right"><tr id="trTombol">
        <td class="noline" align="center"><input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));" />
        <input id="btnTutup" type="button" value="Tutup" onClick="tutup();"/>
                </td>
               
        </tr></td>
        </table>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
<script type="text/JavaScript">

            function cetak(tombol){
                tombol.style.visibility='collapse';
                if(tombol.style.visibility=='collapse'){
                    if(confirm('Anda Yakin Mau Mencetak ?')){
                        setTimeout('window.print()','1000');
                        setTimeout('window.close()','2000');
                    }
                    else{
                        tombol.style.visibility='visible';
                    }

                }
            }
			
function tutup(){
	window.close();
	}
        </script>
</html>
