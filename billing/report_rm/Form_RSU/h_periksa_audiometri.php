<?php
//session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUser=$_REQUEST['idUser'];
/*$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,
k.cara_keluar, a.bb as bb2, a.tb as tb2, IFNULL(pg.nama,'-') AS dr_rujuk
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_pasien_keluar k ON k.pelayanan_id=pl.id
LEFT JOIN anamnese a ON a.KUNJ_ID=pl.kunjungan_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
WHERE pl.id='$idPel';";*/
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,
k.cara_keluar, a.bb as bb2, a.tb as tb2, IFNULL(pg.nama,'-') AS dr_rujuk, IFNULL(pg2.nama,'-') as drnya, Ifnull(pg2.spesialisasi,'-') spec, (GROUP_CONCAT(md.nama)) as diag
FROM b_pelayanan pl
INNER JOIN b_kunjungan ku ON pl.kunjungan_id=ku.id
LEFT JOIN b_diagnosa di ON di.kunjungan_id=ku.id
LEFT JOIN b_ms_diagnosa md ON md.id=di.ms_diagnosa_id 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_pasien_keluar k ON k.pelayanan_id=pl.id
LEFT JOIN anamnese a ON a.KUNJ_ID=pl.kunjungan_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
LEFT JOIN b_ms_pegawai pg2 ON pg2.id=pl.dokter_id
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
$sqlKm="SELECT tk.tgl_in,tk.tgl_out FROM b_tindakan_kamar tk 
LEFT JOIN b_pelayanan p ON p.id=tk.pelayanan_id
WHERE tk.pelayanan_id='$idPel';";
$dK=mysql_fetch_array(mysql_query($sqlKm));
$usr=mysql_fetch_array(mysql_query("select * from b_ms_pegawai where id='$idUser'"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Hasil Pemeriksaan Audiometri</title>
</head>
<?php
include "setting.php";
$dd="select fr.*,bp.nama as dokternyaloh from b_fom_hasil_audiometri fr inner join b_ms_pegawai bp on fr.dr_act=bp.id WHERE bp.spesialisasi_id<>0 and fr.id='$_REQUEST[id]'";
$assd=mysql_query($dd);
$dG=mysql_fetch_array($assd);
//echo $dd;
?>
<body>
<table width="800" border="0" style="font:12px tahoma;">
  <tr>
    <td><table width="508" border="0" align="right" cellpadding="4" bordercolor="#000000" style="border-collapse:collapse; border:1px solid #000000;">
      <tr>
        <td width="124">Nama Pasien</td>
        <td width="173">:
          <?=$dP['nama'];?></td>
        <td width="75">&nbsp;</td>
        <td width="102">&nbsp;</td>
      </tr>
      <tr>
        <td>Tanggal Lahir</td>
        <td>:
          <?=tglSQL($dP['tgl_lahir']);?></td>
        <td>Usia</td>
        <td>:
          <?=$dP['usia'];?>
          Thn</td>
      </tr>
      <tr>
        <td>No. RM</td>
        <td>:
          <?=$dP['no_rm'];?>
        </td>
        <td>No Registrasi </td>
        <td>:____________</td>
      </tr>
      <tr>
        <td>Ruang Rawat/Kelas</td>
        <td>:
          <?=$dP['nm_unit'];?>
          / <?=$dP['nm_kls'];?></td>
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
        <td colspan="4">(Tempelkan Sticker Identitas Pasien)</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr style="border:1px solid">
    <td colspan="13"><table cellspacing="0" cellpadding="2" style="border:1px solid #000000;">
      <col width="44" />
      <col width="40" />
      <col width="150" />
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
		<td height="20">&nbsp;</td>
        <td height="20" colspan="2">Dokter Pengirim</td>
        <td height="20">:</td>
		<td height="20" colspan="8"><?=$dP['drnya']?></td>
		<td height="20">&nbsp;</td>
      </tr>
      <tr height="20">
		<td height="20">&nbsp;</td>
        <td height="20" colspan="2">Diagnosa / Keterangan Klinik</td>
        <td height="20">:</td>
		<td height="20" colspan="9"><?=$dP['diag'];?></td>
      </tr>
	  <tr height="20">
		<td height="20">&nbsp;</td>
		<td height="20" colspan="11"><table height="200" width="99%" cellpadding="0" cellspacing="0"><tr><td valign="top"><?=$dG['ket_klinis']?></td></tr></table></td>
		<td height="20">&nbsp;</td>
      </tr>
	  <tr height="20">
		<td height="20">&nbsp;</td>
        <td height="20">Hasil</td>
        <td height="20" colspan="2" align="center">:</td>
		<td height="20" colspan="5">&nbsp;</td>
		<td height="20" colspan="3">AUDIOGRAM : </td>
		<td height="20">&nbsp;</td>
      </tr>
	  <tr height="20">
		<td height="20">&nbsp;</td>
		<td height="20" colspan="8" rowspan="3"><table height="230" width="99%" cellpadding="0" cellspacing="0"><tr><td valign="top"><?=$dG['hasil']?></td></tr></table></td>
		<td height="20" colspan="3"><table  height ="100" width="99%" cellpadding="0" cellspacing="0"><tr><td valign="top"><?=$dG['audio']?></td></tr></table></td>
		<td height="20">&nbsp;</td>
      </tr>
	  <tr height="20">
		<td height="20">&nbsp;</td>
		<td height="20" colspan="3">SPEECH TEST : </td>
		<td height="20">&nbsp;</td>
      </tr>
	  <tr height="20">
		<td height="20">&nbsp;</td>
		<td height="20" colspan="3"><table  height ="100" width="99%" cellpadding="0" cellspacing="0"><tr><td valign="top"><?=$dG['speech']?></td></tr></table></td>
		<td height="20">&nbsp;</td>
      </tr>
      <tr height="20">
		<td height="20">&nbsp;</td>
        <td height="20">Kesimpulan</td>
        <td height="20" align="center" colspan="2">:</td>
		<td height="20" align="center" colspan="5">&nbsp;</td>
		<td height="20" colspan="3">PEMERIKSAAN KHUSUS : </td>
		<td height="20">&nbsp;</td>
      </tr>
      <tr height="20">
		<td height="20">&nbsp;</td>
		<td height="20" colspan="8"><table  height ="100" width="99%" cellpadding="0" cellspacing="0"><tr><td valign="top"><?=$dG['kesimpulan']?></td></tr></table></td>
		<td height="20" colspan="3"><table  height ="100" width="99%" cellpadding="0" cellspacing="0"><tr><td valign="top"><?=$dG['periksa_k']?></td></tr></table></td>
		<td height="20">&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="2" align="right">Saran : <input disabled="disabled" type="radio" name="saran" id="saran" <?php if($dG['saran']=="1"){echo "checked='checked';";}?>/>HANTARAN TULANG</td>
        <td colspan="4"><input disabled="disabled" type="radio" name="kk" id="kk" <?php if($dG['kk']=="1"){echo "checked='checked';";}?>/>Kiri : Biru</td>
        <td colspan="5">&nbsp;</td>
		<td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="2" align="right"><input disabled="disabled" type="radio" name="saran" id="saran" <?php if($dG['saran']=="2"){echo "checked='checked';";}?>/>
        HANTARAN UDARA</td>
        <td colspan="4"><input disabled="disabled" type="radio" name="kk" id="kk" <?php if($dG['kk']=="2"){echo "checked='checked';";}?>/>Kanan : Merah</td>
        <td colspan="5">&nbsp;</td>
		<td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20" colspan="12">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="3"> Medan, <?php 
		$date = new DateTime($dG['tgl_act']);
		echo $date->format('d-m-Y');?></td>
		<td>&nbsp;</td>
        <td>&nbsp;</td>
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
        <td colspan="3">Pukul : <?php
		$date = new DateTime($dG['tgl_act']);
		echo $date->format('H:i:s');?></td>
		<td>&nbsp;</td>
        <td>&nbsp;</td>
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
        <td>&nbsp;</td>
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
        <td>&nbsp;</td>
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
        <td>&nbsp;</td>
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
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20" colspan="3"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="3"><center><strong>(<?=$dG['dokternyaloh'];?>)</strong></center></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td colspan="3" height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="3"><center>Nama dan Tanda Tangan</center></td>
        <td></td>
        <td>&nbsp;</td>
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
        <td>&nbsp;</td>
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
        <td>&nbsp;</td>
      </tr>
	  <tr>
    <td colspan="13" align="center"><input type="submit" name="button" id="button" value="Cetak" onclick="window.print() " /></td>
  </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
