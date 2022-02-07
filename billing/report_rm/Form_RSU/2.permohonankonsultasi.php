<?php 
include "../../koneksi/konek.php";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idPel1=$_REQUEST['idPel1'];
$idUsr=$_REQUEST['idUser'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,pl.tgl_act tgl_konsul,mk.nama AS nm_kls,u.nama AS nm_unit, bk.no_reg, IF(p.alamat <> '',CONCAT(p.alamat,' RT. ',p.rt,' RW. ',p.rw, ' Kec. ',bw.nama, ' Kota ',bw1.nama),'-') AS almt_lengkap, IFNULL(bmp.nama,'-') AS nm_dokter, pl.ket
FROM b_pelayanan pl 
INNER JOIN b_kunjungan bk ON pl.kunjungan_id = bk.id 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
INNER JOIN b_ms_wilayah bw ON p.kec_id = bw.id
INNER JOIN b_ms_wilayah bw1 ON p.kab_id = bw1.id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_ms_pegawai bmp ON pl.dokter_tujuan_id = bmp.id
WHERE pl.id='$idPel'";
$dP=mysql_fetch_array(mysql_query($sqlP));

$sqlP1="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit, pl.ket
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
WHERE pl.id='$idPel1';";
$dP1=mysql_fetch_array(mysql_query($sqlP1));

$sAnam = "SELECT * 
					FROM anamnese a
					WHERE a.KUNJ_ID = '".$_REQUEST['idKunj']."' ORDER BY a.anamnese_id DESC LIMIT 1";
$qAnam = mysql_query($sAnam);
$rwAnam = mysql_fetch_array($qAnam);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Permohonan Konsultasi</title>
</head>
<?
//include "setting.php";
?>
<style>

.gb{
	border-bottom:1px solid #000000;
}
</style>
<body>
<table width="766" border="0" style="font:12px tahoma;">
  <tr>
    <td width="760"><table width="496" border="0" align="right" cellpadding="4" bordercolor="#000000" style="border-collapse:collapse; border:1px solid #000000;">
      <tr>
        <td width="124">Nama Pasien</td>
        <td width="173">:
          <?=$dP['nama'];?></td>
        <td width="75">&nbsp;</td>
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
        <td>:&nbsp;<?=$dP['no_reg'];?></td>
      </tr>
      <tr>
        <td>Ruang Rawat/Kelas</td>
        <td>:
          <?=$dP1['nm_unit'];?>/
          <?=$dP1['nm_kls'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Alamat</td>
        <td>:
          <?=$dP['almt_lengkap'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="center">(Tempelkan Sticker Identitas Pasien)</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td style="font:bold 15px tahoma;">PERMOHONAN KONSULTASI </td>
  </tr>
  <tr>
    <td style="font:bold 15px tahoma;">REFERRAL CONSULTATION</td>
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
        <td width="138"></td>
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
        <td colspan="5" class="gb"><? echo $dP['nm_dokter'];?></td>
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
        <td colspan="7">Dengan ini kami hadapkan pasien    untuk konsultasi dan tindak lanjut</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="9">Herewith, we would like    to refer the&nbsp; following patient for    your consultation and follow up</td>
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
        <td colspan="3">Keluhan Utama</td>
        <td>:</td>
        <td colspan="8" class="gb">&nbsp;<? echo $rwAnam['KU'];?></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="3">Chief Compliant</td>
        <td></td>
        <td colspan="8" class="gb">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="8" class="gb">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="8" class="gb">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="8" class="gb">&nbsp;</td>
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
        <td colspan="3"><u> Hasil pemeriksaan yang ditemukan </u><br /> Examination Result</td>
        <td>:</td>
        <td colspan="8">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="10%">&nbsp;RR</td>
            <td class="gb" width="50%">:&nbsp;<? echo $rwAnam['RR'];?>&nbsp;/Mnt</td>
        </tr>
        <tr>
            <td>Tensi Sistolik</td>
            <td class="gb">:&nbsp;<? echo $rwAnam['TENSI'];?>&nbsp;mmHg</td>
        </tr>
        <tr>
            <td>Tensi Diastolik</td>
            <td class="gb">:&nbsp;<? echo $rwAnam['TENSI_DIASTOLIK'];?>&nbsp;mmHg</td>
        </tr>
        <tr>
            <td>Suhu</td>
            <td class="gb">:&nbsp;<? echo $rwAnam['SUHU'];?>&nbsp;&deg;C</td>
        </tr>
        <tr>
            <td>Nadi</td>
            <td class="gb">:&nbsp;<? echo $rwAnam['NADI'];?>&nbsp;/Mnt</td>
        </tr>
        <tr>
            <td>TB</td>
            <td class="gb">:&nbsp;<? echo $rwAnam['TB'];?>&nbsp;Cm</td>
        </tr>
        <tr>
            <td>BB</td>
            <td class="gb">:&nbsp;<? echo $rwAnam['BB'];?>&nbsp;Kg</td>
        </tr>
        <tr>
            <td>Kepala</td>
            <td class="gb">:&nbsp;<? echo $rwAnam['KL'];?></td>
        </tr>
        <tr>
            <td>Leher</td>
            <td class="gb">:&nbsp;<? echo $rwAnam['LEHER'];?></td>
        </tr>
         <tr>
            <td>Thorax</td>
            <td class="gb">:&nbsp;<? echo $rwAnam['THORAX'];?></td>
        </tr>
        <tr>
            <td>Pulmo</td>
            <td class="gb">:&nbsp;<? echo $rwAnam['PULMO'];?></td>
        </tr>
        <tr>
            <td>Cor</td>
            <td class="gb">:&nbsp;<? echo $rwAnam['COR'];?></td>
        </tr>
        <tr>
            <td>Abdomen</td>
            <td class="gb">:&nbsp;<? echo $rwAnam['ABDOMEN'];?></td>
        </tr>
         <tr>
            <td>Genitalia</td>
            <td class="gb">:&nbsp;<? echo $rwAnam['GENITALIA'];?></td>
        </tr>
        <tr>
            <td>Ekstremitas</td>
            <td class="gb">:&nbsp;<? echo $rwAnam['EXT'];?></td>
        </tr>
        </table>
        </td>
        <td></td>
      </tr>
      <!--<tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="3">Examination Result</td>
        <td></td>
        <td colspan="8" class="gb">&nbsp;</td>
        <td></td>
      </tr>-->
      <!--<tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="8" class="gb">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="8" class="gb">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="8" class="gb">&nbsp;</td>
        <td></td>
      </tr>-->
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
        <td colspan="2" rowspan="2" valign="top">Diagnosa<br/>Diagnosis</td>
        <td rowspan="2"></td>
        <td rowspan="2" valign="top">:</td>
        <td colspan="8" rowspan="2" style="margin:0; padding:0;" valign="top">
        <table width="100%" border="0">
        <?php $sqlD="SELECT md.nama FROM b_diagnosa d
LEFT JOIN b_ms_diagnosa md ON md.id=d.ms_diagnosa_id
WHERE d.pelayanan_id='$idPel1' AND nama IS NOT NULL;";
$exD=mysql_query($sqlD);
while($dD=mysql_fetch_array($exD)){
?>
          <tr>
            <td class="gb"><?=$dD['nama']?></td>
          </tr>
        <?php }?>  
         <!-- <tr>
            <td class="gb">&nbsp;</td>
          </tr>-->
        </table>
         <table width="100%" border="0">
        <?php $sqlD="SELECT d.diagnosa_manual FROM b_diagnosa d WHERE d.pelayanan_id='$idPel1' AND diagnosa_manual IS NOT NULL;";
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
        </table></td>
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
        <td colspan="3" rowspan="2">Obat dan Tindakan yang    diberikan<br/>Performed medication    &amp; procedure</td>
        <td rowspan="2" valign="top">:</td>
         <td colspan="8" rowspan="2" style="margin:0; padding:0;" valign="top">
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
	WHERE t.pelayanan_id = '".$idPel1."') as gab";
$exT=mysql_query($sqlT);
while($dT=mysql_fetch_array($exT)){
?>
          <tr>
            <td class="gb"><?=$dT['nama'];?></td>
          </tr>
        <?php }?>  
<?php $sqlT="SELECT ab.OBAT_NAMA FROM b_resep a
INNER JOIN $dbapotek.a_obat ab ON a.obat_id = ab.OBAT_ID
WHERE id_pelayanan = $idPel1";
$exT=mysql_query($sqlT);
while($dT=mysql_fetch_array($exT)){
?>
          <tr>
            <td class="gb"><?=$dT['OBAT_NAMA'];?></td>
          </tr>
        <?php }?>  
          <tr>
            <td class="gb">&nbsp;</td>
          </tr>
        </table></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="3">Keterangan</td>
        <td>:</td>
        <td colspan="8" class="gb">&nbsp;<? echo $dP['ket']?></td>
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
        <td>:</td>
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
      <!--<tr height="20">
        <td height="20">&nbsp;</td>
        <td rowspan="2" style="border:1px solid #000000">&nbsp;</td>
        <td></td>
        <td colspan="2">Mohon konsul satu kali</td>
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
        <td colspan="3">Single Consultation    (only)</td>
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
        <td rowspan="2" style="border:1px solid #000000">&nbsp;</td>
        <td></td>
        <td colspan="3">Mohon untuk rawat bersama</td>
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
        <td>Join responsibility</td>
        <td></td>
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
        <td rowspan="2" style="border:1px solid #000000">&nbsp;</td>
        <td></td>
        <td colspan="2">Mohon untuk alih rawat</td>
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
        <td colspan="2">Transfer responsibility</td>
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
-->      <tr height="20">
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
      <?php 
	  $tglkonsul=explode(" ",$dP["tgl_konsul"]);
	  ?>
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
        <td colspan="4" class="gb">&nbsp;<?=tglSQL($tglkonsul[0]);?></td>
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
        <td colspan="4" class="gb">&nbsp;<?=$tglkonsul[1];?></td>
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
        <?php
		//$sDok="select * from b_ms_pegawai where id='".$idUsr."'";
		$sDok="SELECT mp.nama FROM b_pelayanan a INNER JOIN b_ms_pegawai mp ON a.dokter_id=mp.id WHERE a.id='".$_REQUEST['idPel']."'";
		$qDok=mysql_query($sDok);
		$rwDok=mysql_fetch_array($qDok);
		?>
        <td colspan="6"><div align="center">(<?php echo $rwDok['nama']; ?>)</div></td>
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
</table>
</body>
</html>
