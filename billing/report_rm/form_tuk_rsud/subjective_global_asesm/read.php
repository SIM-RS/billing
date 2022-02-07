<?php

require_once '_functions.php';

$surat = getSurat($idPel);
if($surat === FALSE) {
	header('Location: '.$BASE_URL.'&act=create');
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Subjective Global Asesm</title>
<script language="javascript">
function cetak1()
{
	document.getElementById("tombol").style.display = 'none';
	window.print();
	document.getElementById("tombol").style.display = 'table-row';
}
</script>

<link href="styles.css" rel="stylesheet" type="text/css" />

<style>
	body {
		padding: 5px;
	}
	.form-row td {
		border-right:.5pt solid windowtext;
	}
	
	.form-row td:first-child {
		border-right: none;
		border-left:.5pt solid windowtext;
	}
	
	.form-row.separator td {
		border-top:.5pt solid windowtext;
	}
	
	.form-row.last td {
		border-bottom:.5pt solid windowtext;
	}
	
	input {
		width: 60px;
		border:none;
	}

</style>
</head>

<body>

<table width="800" border="0" cellspacing="0" cellpadding="0" class="container">
	<col width="26">
	<col width="225">
	<col width="72">
	<col width="473">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" rowspan="4" align="right">
		<table border="0" cellspacing="0" cellpadding="0" width="450" class="sticker">
		  <tr>
			<td width="100">Nama Pasien </td>
			<td width="10">:</td>
			<td width="25" style="width: 175px;"><?php echo $pasien['nama']; ?>&nbsp;&nbsp;&nbsp;&nbsp; L/P</td>
		  </tr>
		  <tr>
			<td>Tanggal Lahir </td>
			<td>:</td>
			<td><?php echo tglSQL($pasien['tgl_lahir']); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/ Usia : <?php echo $pasien['usia']; ?> Th</td>
		  </tr>
		  <tr>
			<td>No. R.M </td>
			<td>:</td>
			<td><?php echo $pasien['no_rm']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No  Registrasi : <? echo $pasien['no_reg']?></td>
		  </tr>
		  <tr>
			<td>Ruang Rawat / Kelas </td>
			<td>:</td>
			<td><?php echo $pasien['nm_unit']; ?> / <?php echo $pasien['nm_kls']; ?></td>
		  </tr>
		  <tr>
			<td>Alamat</td>
			<td>:</td>
			<td><?php echo $pasien['almt_lengkap']; ?></td>
		  </tr>
		  <tr>
			<td colspan="3"><p align="center">(Tempelkan  Sticker Identitas Pasien)</p></td>
			</tr>
		</table>	</td>
  </tr>
  <tr>
    <td height="21" colspan="2" class="title">PEMERINTAH KOTA MEDAN</td>
  </tr>
  <tr>
    <td height="21" colspan="2" class="title">RUMAH SAKIT PELINDO I</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="title">SUBJECTIVE GLOBAL ASESSMENT</td>
    <td>&nbsp;</td>
  </tr>
  <tr height="37" style='mso-height-source:userset;height:27.75pt'  class="table-header">
		<td height="37" colspan="2" style='height:27.75pt'>DESKRIPSI</td>
		<td width="72" style='width:54pt'>NILAI SKOR</td>
		<td>KETERANGAN</td>
	</tr>
  <tr height="20" class="form-row">
		<td height="20"><strong>1.</strong></td>
		<td><strong>Antropometri</strong></td>
		<td>&nbsp;</td>
		<td><strong>Antropometri</strong></td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20">&nbsp;</td>
		<td>BB&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;
		<?
        	if($pasien['BB'] == "" || $pasien['BB']==0)
			{
				echo $surat['bb'];
			}else{
				echo $pasien['BB'];
			}
		?>
        <input type="hidden" name="surat[bb]" value="<?php echo $surat['bb']; ?>" readonly="readonly" />&nbsp;kg</td>
		<td>&nbsp;</td>
		<td><strong>IMT :</strong></td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20">&nbsp;</td>
		<td>TB&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;
		<?
        	if($pasien['TB']=="" || $pasien['TB']==0)
			{
				echo $surat['tb'];
			}else{
				echo $pasien['TB'];
			}
		?>
        <input type="hidden" name="surat[tb]" value="<?php echo $surat['tb']; ?>" readonly="readonly" />&nbsp;cm</td>
		<td>&nbsp;</td>
		<td><strong>Skor (0), &gt; 20 atau 30 (Obese)</strong></td>
	</tr>
	<tr height="23" class="form-row">
		<td height="23">&nbsp;</td>
		<td>IMT&nbsp;&nbsp;:&nbsp;&nbsp;<?php 
		$bb=$pasien['BB'];
		$tb=$pasien['TB'];
		if($tb == 0 || $tb=="")
		{
			$imt = $surat['imt'];
		}else{
			$tb=$tb/100;
			$imt = $bb / ($tb*$tb);	
		}
		echo round($imt, 2);
		?><input type="hidden" name="surat[imt]" value="<?php echo $surat['imt']; ?>" readonly="readonly" />&nbsp;&nbsp;&nbsp;kg/m<font class="font5403"><sup>2</sup></font></td>
		<td></td>
		<td><strong>Skor (1), 18,5 - 20</strong></td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20">&nbsp;</td>
		<td>Kehilangan BB dalam 6 Bulan</td>
		<td align="center"><input type="text" name="surat[skor_antropomerti_6]" value="<?php echo $surat['skor_antropomerti_6']; ?>" readonly="readonly" /></td>
		<td><strong>Skor (2), &lt; 18,5</strong></td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20">&nbsp;</td>
		<td>Perubahan BB dalam 2 minggu</td>
		<td align="center"><input type="text" name="surat[skor_antropomerti_12]" value="<?php echo $surat['skor_antropomerti_12']; ?>" readonly="readonly" /></td>
		<td>Penurunan Berat Badan :</td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20">&nbsp;</td>
		<td></td>
		<td>&nbsp;</td>
		<td><strong>Skor (0)</strong></td>
	</tr>
	<tr height="20"  class="form-row">
		<td height="20">&nbsp;</td>
		<td></td>
		<td>&nbsp;</td>
		<td>- Penurunan BB selama 6 bulan terakhir sebesar 0 - 5 %</td>
	</tr>
	<tr height="20"  class="form-row">
		<td height="20">&nbsp;</td>
		<td></td>
		<td>&nbsp;</td>
		<td>- Tidak ada perubahan BB selama 2 minggu terakhir</td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20">&nbsp;</td>
		<td></td>
		<td>&nbsp;</td>
		<td>- BB bertambah sampai dengan 5 %.</td>
	</tr>
	<tr height="20"  class="form-row">
		<td height="20">&nbsp;</td>
		<td></td>
		<td>&nbsp;</td>
		<td><strong>Skor (2)</strong></td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20">&nbsp;</td>
		<td></td>
		<td>&nbsp;</td>
		<td>- Penurunan BB selama 6 bulan terakhir sebesar 5 - 10 %</td>
	</tr>
	<tr height="25" class="form-row">
		<td height="25">&nbsp;</td>
		<td></td>
		<td>&nbsp;</td>
		<td rowspan="2" width="473">- BB selama 2 minggu terakhir bertambah 5 - 10 %; BB tidak berubah selama 2 minggu terakhir, namun masih kurang dari BB biasanya</td>
	</tr>
	<tr height="26" class="form-row">
		<td height="26">&nbsp;</td>
		<td></td>
		<td>&nbsp;</td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20">&nbsp;</td>
		<td></td>
		<td>&nbsp;</td>
		<td><strong>Skor (3)</strong></td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20">&nbsp;</td>
		<td></td>
		<td>&nbsp;</td>
		<td>- Penurunan BB selama 6 bulan sebesar &gt; 10 %</td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>- BB selama 2 minggu terakhir berkurang</td>
	</tr>
	
	<tr height="20" class="form-row separator">
		<td height="20">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><strong>Skor (0)</strong></td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>- Tidak berubah</td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20"><strong>2.</strong></td>
		<td><strong>Perubahan Intake Makan</strong></td>
		<td align="center"><input name="surat[skor_perubahan_intake_makan]" type="text" value="<?php echo $surat['skor_perubahan_intake_makan']; ?>" readonly="readonly" /></td>
		<td>- Berubah &lt; 2 mingggu / 14 hari</td>
	</tr>
	<tr height="23" class="form-row">
		<td height="23">&nbsp;</td>
		<td>&nbsp;</td>
		<td></td>
		<td><strong>Skor (2)</strong></td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>- Berubah</td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>- Intake berkurang &gt; 2minggu / 14 hari, dengan perubahan bentuk padat / cair namun masih sesuai dengan kebutuhan</td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20">&nbsp;</td>
		<td></td>
		<td>&nbsp;</td>
		<td><strong>Skor (3)</strong></td>
	</tr>
	<tr height="20"  class="form-row">
		<td height="20">&nbsp;</td>
		<td></td>
		<td>&nbsp;</td>
		<td>- Berubah, intake berkurang &gt; 2 minggu / 14 hari, dengan bentuk cair namun di bawah kebutuhan atau pasien puasa / tidak dapat makan</td>
	</tr>
	
	<tr height="20" class="form-row separator">
		<td height="20">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><strong>Skor (0)</strong></td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>- Tidak ada gejala gangguan saluran cerna</td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20"><strong>3.</strong></td>
		<td><strong>Perubahan Gastrointestinal</strong></td>
		<td align="center"><input name="surat[skor_perubahan_gastrointestinal]" type="text" value="<?php echo $surat['skor_perubahan_gastrointestinal']; ?>" readonly="readonly" /></td>
		<td>&nbsp;</td>
	</tr>
	<tr height="23" class="form-row">
		<td height="23">&nbsp;</td>
		<td>&nbsp;</td>
		<td></td>
		<td><strong>Skor (2)</strong></td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>- Ada &lt; dari 4 gejala gangguan saluran cerna, &lt; 2 minggu</td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20">&nbsp;</td>
		<td></td>
		<td>&nbsp;</td>
		<td><strong>Skor (3)</strong></td>
	</tr>
	<tr height="20"  class="form-row">
		<td height="20">&nbsp;</td>
		<td></td>
		<td>&nbsp;</td>
		<td>- Semua gejala gangguan saluran cerna ada, &gt; 2 minggu</td>
	</tr>
	
	<tr height="20" class="form-row separator">
		<td height="20">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><strong>Skor (0)</strong></td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>- Tidak ada perubahan kapasitas fungsional</td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20"><strong>4.</strong></td>
		<td><strong>Perubahan Kapasitas Fungsi</strong></td>
		<td align="center"><input name="surat[skor_perubahan_kapasitas_fungsi]" type="text" value="<?php echo $surat['skor_perubahan_kapasitas_fungsi']; ?>" readonly="readonly" /></td>
		<td>&nbsp;</td>
	</tr>
	<tr height="23" class="form-row">
		<td height="23">&nbsp;</td>
		<td>&nbsp;</td>
		<td></td>
		<td><strong>Skor (3)</strong></td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>- Berubah, tidak dapat maka melalui oral, working sub optimally atau ambulatory</td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20">&nbsp;</td>
		<td></td>
		<td>&nbsp;</td>
		<td><strong>Skor (2)</strong></td>
	</tr>
	<tr height="20"  class="form-row">
		<td height="20">&nbsp;</td>
		<td></td>
		<td>&nbsp;</td>
		<td>- Berubah, Kesulitan menelan, makan dengan bentuk saring / cair berbaring</td>
	</tr>
	
	<tr height="20" class="form-row separator">
		<td height="20">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><strong>Skor (0)</strong></td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>- Tidak ada stress</td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20" valign="top"><strong>5.</strong></td>
		<td rowspan="2" valign="top"><strong>Penyakit yang hubungannya dengan kebutuhan gizi, Stress</strong></td>
		<td align="center"><input name="surat[skor_penyakit_gizi]" type="text" value="<?php echo $surat['skor_penyakit_gizi']; ?>" readonly="readonly" /></td>
		<td><strong>Skor (1)</strong></td>
	</tr>
	<tr height="23" class="form-row">
		<td height="23">&nbsp;</td>
		<td></td>
		<td>- Sterss ringan, bedah minor, infeksi</td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><strong>Skor (2)</strong></td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>- Sterss sedang, penyakit kronik, bedah mayor, infeksi</td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20">&nbsp;</td>
		<td></td>
		<td>&nbsp;</td>
		<td><strong>Skor (3)</strong></td>
	</tr>
	<tr height="20"  class="form-row">
		<td height="20">&nbsp;</td>
		<td></td>
		<td>&nbsp;</td>
		<td>- Stress berat, Cedera berat, Sepsis, Cancer</td>
	</tr>
	
	<tr height="20" class="form-row separator">
		<td height="20">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><strong>Skor (A)</strong></td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>- Kehilangan lemak subkutan tidak ada / tidak berubah</td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20" valign="top"><strong>6.</strong></td>
		<td valign="top"><strong>Penilaian Fisik</strong></td>
		<td align="center"><input name="surat[skor_penilaian_fisik]" type="text" value="<?php echo $surat['skor_penilaian_fisik']; ?>" readonly="readonly" /></td>
		<td>- Kehilangan masa otot tidak ada / tidak berubah</td>
	</tr>
	<tr height="23" class="form-row">
		<td height="23">&nbsp;</td>
		<td valign="top">&nbsp;</td>
		<td></td>
		<td>- Tidak Oedema</td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>- Tidak ascites</td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20">&nbsp;</td>
		<td></td>
		<td>&nbsp;</td>
		<td><strong>Skor (B)</strong></td>
	</tr>
	<tr height="20"  class="form-row">
		<td height="20">&nbsp;</td>
		<td></td>
		<td>&nbsp;</td>
		<td>- Kehilangan lemak subkutan sedikit, disatu / kedua tempat</td>
	</tr>
	<tr height="20"  class="form-row">
	  <td height="20">&nbsp;</td>
	  <td></td>
	  <td>&nbsp;</td>
	  <td>- Kehilangan masa otot sedikit, dibeberapa tempat</td>
  </tr>
	<tr height="20"  class="form-row">
	  <td height="20">&nbsp;</td>
	  <td></td>
	  <td>&nbsp;</td>
	  <td>- Oedema ringan</td>
  </tr>
	<tr height="20"  class="form-row">
	  <td height="20">&nbsp;</td>
	  <td></td>
	  <td>&nbsp;</td>
	  <td>- Ascites ringan</td>
  </tr>
	<tr height="20"  class="form-row">
	  <td height="20">&nbsp;</td>
	  <td></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
  </tr>
	<tr height="20"  class="form-row">
	  <td height="20">&nbsp;</td>
	  <td></td>
	  <td>&nbsp;</td>
	  <td><strong>Skor ( C )</strong></td>
  </tr>
	<tr height="20"  class="form-row">
	  <td height="20">&nbsp;</td>
	  <td></td>
	  <td>&nbsp;</td>
	  <td>- Banyak kehilangan lemak subkutan di kedua tempat</td>
  </tr>
	<tr height="20"  class="form-row">
	  <td height="20">&nbsp;</td>
	  <td></td>
	  <td>&nbsp;</td>
	  <td>- Banyak kehilangan lemak subkutan di kedua tempat</td>
  </tr>
	<tr height="20"  class="form-row">
	  <td height="20">&nbsp;</td>
	  <td></td>
	  <td>&nbsp;</td>
	  <td>- Oedema ringan</td>
  </tr>
	<tr height="20"  class="form-row">
	  <td height="20">&nbsp;</td>
	  <td></td>
	  <td>&nbsp;</td>
	  <td>- Ascites ringan</td>
  </tr>
  
  <tr height="20" class="form-row separator">
		<td height="20">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><strong>Skor 0 - 3 memerlukan tindakan :</strong></td>
  </tr>
	<tr height="20" class="form-row">
		<td height="20">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>-  Tidak ada penanganan khusus</td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20" valign="top">&nbsp;</td>
		<td valign="top"><strong>TOTAL SCORE</strong></td>
		<td align="center"><input name="surat[skor_total]" type="text" value="<?php echo $surat['skor_total']; ?>" readonly="readonly" /></td>
		<td>- Cek Berat Badan tiap minggu</td>
	</tr>
	<tr height="23" class="form-row">
		<td height="23">&nbsp;</td>
		<td valign="top"><strong>0 - 3 Resiko Rendah</strong></td>
		<td></td>
		<td>&nbsp;</td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20">&nbsp;</td>
		<td><strong>4 - 5 Membutuhkan  Monitoring</strong></td>
		<td>&nbsp;</td>
		<td><strong>Skor 4 - 5 memerlukan tindakan :</strong></td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20">&nbsp;</td>
		<td><strong>6 - 15 Resiko Berat</strong></td>
		<td>&nbsp;</td>
		<td>- Cek Berat Badan tiap minggu</td>
	</tr>
	<tr height="20" class="form-row">
		<td height="20">&nbsp;</td>
		<td></td>
		<td>&nbsp;</td>
		<td>- Memberikan motivasi untuk makan dan minum</td>
	</tr>
	<tr height="20"  class="form-row">
		<td height="20">&nbsp;</td>
		<td></td>
		<td>&nbsp;</td>
		<td>- Membuat rencana makanan</td>
	</tr>
	<tr height="20"  class="form-row">
	  <td height="20">&nbsp;</td>
	  <td></td>
	  <td>&nbsp;</td>
	  <td>- Melakukan evaluasi nilai setelah 3 hari</td>
  </tr>
	<tr height="20"  class="form-row">
	  <td height="20">&nbsp;</td>
	  <td></td>
	  <td>&nbsp;</td>
	  <td>- Kirim ke Ahli Gizi</td>
  </tr>
	<tr height="20"  class="form-row">
	  <td height="20">&nbsp;</td>
	  <td></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
  </tr>
	<tr height="20"  class="form-row">
	  <td height="20">&nbsp;</td>
	  <td></td>
	  <td>&nbsp;</td>
	  <td><strong>Skor 5 - 15 memerlukan tindakan :</strong></td>
  </tr>
	<tr height="20"  class="form-row">
	  <td height="20">&nbsp;</td>
	  <td></td>
	  <td>&nbsp;</td>
	  <td>- Cek Berat Badan</td>
  </tr>
	<tr height="20"  class="form-row">
	  <td height="20">&nbsp;</td>
	  <td></td>
	  <td>&nbsp;</td>
	  <td>- Membuat rencana makanan</td>
  </tr>
	<tr height="20"  class="form-row last">
	  <td height="20">&nbsp;</td>
	  <td></td>
	  <td>&nbsp;</td>
	  <td>- Dokter Spesialis Gizi</td>
  </tr>
	
  <tr>
    <td class="title">&nbsp;</td>
    <td class="title">&nbsp;</td>
    <td class="title">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr height="20" style='height:15.0pt'>
		<td height="20" class="xl63403" style='height:15.0pt'></td>
		<td class="xl63403"></td>
		<td class="xl63403"></td>
		<td class="xl63403"></td>
	</tr>
	<tr height="20" style='height:15.0pt'>
		<td height="20" class="xl63403" style='height:15.0pt'></td>
		<td class="xl66403" colspan=2>Medan, <?=date('d')." ".getBulan(date('m'))." ".date('Y')?></td>
		<td class="xl63403"></td>
	</tr>
	<tr height="20" style='height:15.0pt'>
		<td height="20" class="xl63403" style='height:15.0pt'></td>
		<td class="xl66403"></td>
		<td class="xl63403"></td>
		<td class="xl63403"></td>
	</tr>
	<tr height="20" style='height:15.0pt'>
		<td height="20" class="xl63403" style='height:15.0pt'></td>
		<td class="xl66403">Ahli Gizi :</td>
		<td class="xl63403"></td>
		<td class="xl63403"></td>
	</tr>
	<tr height="20" style='height:15.0pt'>
		<td height="20" class="xl63403" style='height:15.0pt'></td>
		<td class="xl66403"></td>
		<td class="xl63403"></td>
		<td class="xl63403"></td>
	</tr>
	<tr height="20" style='height:15.0pt'>
		<td height="20" class="xl63403" style='height:15.0pt'></td>
		<td class="xl66403"></td>
		<td class="xl63403"></td>
		<td class="xl63403"></td>
	</tr>
	<tr height="20" style='height:15.0pt'>
		<td height="20" class="xl63403" style='height:15.0pt'></td>
		<td class="xl66403"></td>
		<td class="xl63403"></td>
		<td class="xl63403"></td>
	</tr>
	<tr height="20" style='height:15.0pt'>
		<td height="20" class="xl63403" style='height:15.0pt'></td>
		<td class="xl66403"></td>
		<td class="xl63403"></td>
		<td class="xl63403"></td>
	</tr>
	<tr height="20" style='height:15.0pt'>
		<td height="20" class="xl63403" style='height:15.0pt'></td>
		<td class="xl92403">( ____________________________ )</td>
		<td class="xl63403"></td>
		<td class="xl63403"></td>
	</tr>
	<tr height="20" style='height:15.0pt'>
		<td height="20" class="xl63403" style='height:15.0pt'></td>
		<td class="xl92403">Tanda tangan &amp; Nama Jelas</td>
		<td class="xl63403"></td>
		<td class="xl63403"></td>
	</tr>
  
  <tr id="tombol">
    <td colspan="4" align="center"><?php if($_REQUEST['report']!=1){?><a href="<?php echo $BASE_URL.'&act=edit'; ?>">Ubah</a><?php }?>
	<a href="#" onclick="cetak1()">Print</a></td>
  </tr>
</table>

</body>
</html>
