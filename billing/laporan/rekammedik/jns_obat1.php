<?
include("../../sesi.php");
?>
<title>.: Jenis Obat Yang Dipergunakan Pada Pasien Gangguan Mental Dan Perilaku Akibat Penggunaan Napza Menurut Pekerjaannya :.</title>
<?php
    include ("../../koneksi/konek.php");
    $arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$tribulan = $_POST['cmbTri'];
	$thn = $_POST['cmbThnTri'];
	if($tribulan==1){
		$tri = "januari - maret $thn";
		$waktu = "AND (MONTH(b_diagnosa_rm.tgl) BETWEEN '01' AND '03') AND YEAR(b_diagnosa_rm.tgl)='$thn'";
	}else if($tribulan==2){
		$tri = "april - juni $thn";
		$waktu = "AND (MONTH(b_diagnosa_rm.tgl) BETWEEN '04' AND '06') AND YEAR(b_diagnosa_rm.tgl)='$thn'";
	}else if($tribulan==3){
		$tri = "juli - september $thn";
		$waktu = "AND (MONTH(b_diagnosa_rm.tgl) BETWEEN '07' AND '09') AND YEAR(b_diagnosa_rm.tgl)='$thn'";
	}else if($tribulan==4){
		$tri = "oktober - desember $thn";
		$waktu = "AND (MONTH(b_diagnosa_rm.tgl) BETWEEN '10' AND '12') AND YEAR(b_diagnosa_rm.tgl)='$thn'";
	}
    
    $jnsLay = $_REQUEST['JnsLayanan'];
    $tmpLay = $_REQUEST['TmpLayananPsi'];
    
    
    $sqlUnit = "SELECT id,nama FROM b_ms_unit WHERE id = '".$tmpLay."'";
    $rsUnit = mysql_query($sqlUnit);
    $rwUnit = mysql_fetch_array($rsUnit);
?>
<style>
	.jdl{
		border-right:1px solid #FFFFFF;
		border-bottom:1px solid #FFFFFF;
		height:30;
		font-size:12px;
		text-transform:uppercase;
		text-align:center;
	}
</style>
<table width="1200" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
  </tr>
  <tr>
    <td style="text-align:center; font-weight:bold; text-transform:uppercase; font-size:14px;" height="100" valign="top">jenis obat yang dipergunakan pada pasien gangguan mental<br />dan perilaku akibat penggunaan napza<br />menurut pekerjaannya<br />tempat layanan <u><?php echo $rwUnit['nama'];?></u><br />tribulan : <?php echo $tri?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
      <tr style="background-color:#00FF00;">
        <td rowspan="3" class="jdl">no</td>
        <td rowspan="3" class="jdl">jenis obat yang<br />dipergunakan oleh pasien<br />ketergantungan obat</td>
        <td colspan="9" class="jdl">kasus baru</td>
        <td rowspan="3" class="jdl">jml pasien<br />keluar</td>
        <td rowspan="3" class="jdl">jml pasien<br />mati</td>
      </tr>
      <tr>
        <td colspan="9" class="jdl" style="background-color:#00FF00;">menurut pekerjaannya</td>
        </tr>
      <tr>
        <td class="jdl" bgcolor="#FFCCFF">pelajar</td>
        <td class="jdl" bgcolor="#FFCCFF">mahasiswa</td>
        <td class="jdl" bgcolor="#FFCCFF">pendidik</td>
        <td class="jdl" bgcolor="#FFCCFF">pns</td>
        <td class="jdl" bgcolor="#FFCCFF">tni</td>
        <td class="jdl" bgcolor="#FFCCFF">polri</td>
        <td class="jdl" bgcolor="#FFCCFF">wiraswasta/<br />dagang</td>
        <td class="jdl" bgcolor="#FFCCFF">tidak<br />bekerja</td>
        <td class="jdl" bgcolor="#FFCCFF">jumlah</td>
      </tr>
		<?php
				$q1 = "SELECT b_ms_diagnosa.kode, b_ms_diagnosa.nama, SUM(IF(b_ms_pekerjaan.id=12,1,0)) AS pelajar,
						SUM(IF(b_ms_pekerjaan.id=13,1,0)) AS mahasiswa, SUM(IF(b_ms_pekerjaan.id=9,1,0)) AS pns,
						SUM(IF(b_ms_pekerjaan.id=11,1,0)) AS wiraswasta, SUM(IF(b_ms_pekerjaan.id=2,1,0)) AS tidakkerja,
						SUM(IF(b_ms_pekerjaan.id=14,1,0)) AS lain, COUNT(b_diagnosa_rm.pelayanan_id) AS jml
						FROM b_kunjungan 
						INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id 
						INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id
						INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id=b_diagnosa_rm.ms_diagnosa_id
						INNER JOIN b_ms_pekerjaan ON b_ms_pekerjaan.id=b_kunjungan.pekerjaan_id
						INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
						WHERE b_pelayanan.unit_id='".$tmpLay."' AND b_ms_diagnosa.id='4789' $waktu AND b_pasien_keluar.kasus='1'";
				$s1 = mysql_query($q1);
				$w1 = mysql_fetch_array($s1);
		?>
      <tr>
        <td height="22" width="4%" style="text-align:center; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">1</td>
        <td width="16%" style="padding-left:5px; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">Putauw</td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w1['pelajar']==0 || $w1['pelajar']=="") echo "&nbsp;"; else echo $w1['pelajar'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w1['mahasiswa']==0 || $w1['mahasiswa']=="") echo "&nbsp;"; else echo $w1['mahasiswa'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w1['pns']==0 || $w1['pns']=="") echo "&nbsp;"; else echo $w1['pns'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td width="8%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w1['wiraswasta']==0 || $w1['wiraswasta']=="") echo "&nbsp;"; else echo $w1['wiraswasta'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w1['tidakkerja']==0 || $w1['tidakkerja']=="") echo "&nbsp;"; else echo $w1['tidakkerja'];?></td>
        <td width="7%" style="border-right:1px solid #00FF00; text-align:center; border-bottom:1px solid #999999;"><?php if($w1['jml']==0 || $w1['jml']=="") echo "&nbsp;"; else echo $w1['jml'];?></td>
        <td width="8%" style="border-right:1px solid #00FF00; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td width="8%" style="text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
      </tr>
		<?php
				$q2 = "SELECT b_ms_diagnosa.kode, b_ms_diagnosa.nama, SUM(IF(b_ms_pekerjaan.id=12,1,0)) AS pelajar,
						SUM(IF(b_ms_pekerjaan.id=13,1,0)) AS mahasiswa, SUM(IF(b_ms_pekerjaan.id=9,1,0)) AS pns,
						SUM(IF(b_ms_pekerjaan.id=11,1,0)) AS wiraswasta, SUM(IF(b_ms_pekerjaan.id=2,1,0)) AS tidakkerja,
						SUM(IF(b_ms_pekerjaan.id=14,1,0)) AS lain, COUNT(b_diagnosa_rm.pelayanan_id) AS jml
						FROM b_kunjungan 
						INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id 
						INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id
						INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id=b_diagnosa_rm.ms_diagnosa_id
						INNER JOIN b_ms_pekerjaan ON b_ms_pekerjaan.id=b_kunjungan.pekerjaan_id
						INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
						WHERE b_pelayanan.unit_id='".$tmpLay."' AND b_ms_diagnosa.id='4797' $waktu AND b_pasien_keluar.kasus='1'";
				$s2 = mysql_query($q2);
				$w2 = mysql_fetch_array($s2);
		?>
      <tr>
        <td height="22" style="text-align:center; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">2</td>
        <td style="padding-left:5px; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">Sabu - sabu</td>
        <td style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w2['pelajar']==0 || $w2['pelajar']=="") echo "&nbsp;"; else echo $w2['pelajar'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w2['mahasiswa']==0 || $w2['mahasiswa']=="") echo "&nbsp;"; else echo $w2['mahasiswa'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w2['pns']==0 || $w2['pns']=="") echo "&nbsp;"; else echo $w2['pns'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td width="8%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w2['wiraswasta']==0 || $w2['wiraswasta']=="") echo "&nbsp;"; else echo $w2['wiraswasta'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w2['tidakkerja']==0 || $w2['tidakkerja']=="") echo "&nbsp;"; else echo $w2['tidakkerja'];?></td>
        <td style="border-right:1px solid #00FF00; text-align:center; border-bottom:1px solid #999999;"><?php if($w2['jml']==0 || $w2['jml']=="") echo "&nbsp;"; else echo $w2['jml'];?></td>
        <td style="border-right:1px solid #00FF00; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td style="text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
      </tr>
      <tr>
        <td height="22" style="text-align:center; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">3</td>
        <td style="padding-left:5px; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">Ekstasi</td>
        <td style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w2['pelajar']==0 || $w2['pelajar']=="") echo "&nbsp;"; else echo $w2['pelajar'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w2['mahasiswa']==0 || $w2['mahasiswa']=="") echo "&nbsp;"; else echo $w2['mahasiswa'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w2['pns']==0 || $w2['pns']=="") echo "&nbsp;"; else echo $w2['pns'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td width="8%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w2['wiraswasta']==0 || $w2['wiraswasta']=="") echo "&nbsp;"; else echo $w2['wiraswasta'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w2['tidakkerja']==0 || $w2['tidakkerja']=="") echo "&nbsp;"; else echo $w2['tidakkerja'];?></td>
        <td style="border-right:1px solid #00FF00; text-align:center; border-bottom:1px solid #999999;"><?php if($w2['jml']==0 || $w2['jml']=="") echo "&nbsp;"; else echo $w2['jml'];?></td>
        <td style="border-right:1px solid #00FF00; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td style="text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
      </tr>
		<?php
				$q3 = "SELECT b_ms_diagnosa.kode, b_ms_diagnosa.nama, SUM(IF(b_ms_pekerjaan.id=12,1,0)) AS pelajar,
						SUM(IF(b_ms_pekerjaan.id=13,1,0)) AS mahasiswa, SUM(IF(b_ms_pekerjaan.id=9,1,0)) AS pns,
						SUM(IF(b_ms_pekerjaan.id=11,1,0)) AS wiraswasta, SUM(IF(b_ms_pekerjaan.id=2,1,0)) AS tidakkerja,
						SUM(IF(b_ms_pekerjaan.id=14,1,0)) AS lain, COUNT(b_diagnosa_rm.pelayanan_id) AS jml
						FROM b_kunjungan 
						INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id 
						INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id
						INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id=b_diagnosa_rm.ms_diagnosa_id
						INNER JOIN b_ms_pekerjaan ON b_ms_pekerjaan.id=b_kunjungan.pekerjaan_id
						INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
						WHERE b_pelayanan.unit_id='".$tmpLay."' AND b_ms_diagnosa.id='4805' $waktu AND b_pasien_keluar.kasus='1'";
				$s3 = mysql_query($q3);
				$w3 = mysql_fetch_array($s3);
		?>
      <tr>
        <td height="22" style="text-align:center; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">4</td>
        <td style="padding-left:5px; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">Putauw + Sabu</td>
        <td style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w3['pelajar']==0 || $w3['pelajar']=="") echo "&nbsp;"; else echo $w3['pelajar'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w3['mahasiswa']==0 || $w3['mahasiswa']=="") echo "&nbsp;"; else echo $w3['mahasiswa'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w3['pns']==0 || $w3['pns']=="") echo "&nbsp;"; else echo $w3['pns'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td width="8%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w3['wiraswasta']==0 || $w3['wiraswasta']=="") echo "&nbsp;"; else echo $w3['wiraswasta'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w3['tidakkerja']==0 || $w3['tidakkerja']=="") echo "&nbsp;"; else echo $w3['tidakkerja'];?></td>
        <td style="border-right:1px solid #00FF00; text-align:center; border-bottom:1px solid #999999;"><?php if($w3['jml']==0 || $w3['jml']=="") echo "&nbsp;"; else echo $w3['jml'];?></td>
        <td style="border-right:1px solid #00FF00; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td style="text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
      </tr>
      <tr>
        <td height="22" style="text-align:center; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">5</td>
        <td style="padding-left:5px; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">Ganja + Ekstasi</td>
        <td style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w3['pelajar']==0 || $w3['pelajar']=="") echo "&nbsp;"; else echo $w3['pelajar'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w3['mahasiswa']==0 || $w3['mahasiswa']=="") echo "&nbsp;"; else echo $w3['mahasiswa'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w3['pns']==0 || $w3['pns']=="") echo "&nbsp;"; else echo $w3['pns'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td width="8%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w3['wiraswasta']==0 || $w3['wiraswasta']=="") echo "&nbsp;"; else echo $w3['wiraswasta'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w3['tidakkerja']==0 || $w3['tidakkerja']=="") echo "&nbsp;"; else echo $w3['tidakkerja'];?></td>
        <td style="border-right:1px solid #00FF00; text-align:center; border-bottom:1px solid #999999;"><?php if($w3['jml']==0 || $w3['jml']=="") echo "&nbsp;"; else echo $w3['jml'];?></td>
        <td style="border-right:1px solid #00FF00; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td style="text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
      </tr>
      <tr>
        <td height="22" style="text-align:center; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">6</td>
        <td style="padding-left:5px; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">Sabu + Alkohol</td>
        <td style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w3['pelajar']==0 || $w3['pelajar']=="") echo "&nbsp;"; else echo $w3['pelajar'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w3['mahasiswa']==0 || $w3['mahasiswa']=="") echo "&nbsp;"; else echo $w3['mahasiswa'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w3['pns']==0 || $w3['pns']=="") echo "&nbsp;"; else echo $w3['pns'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td width="8%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w3['wiraswasta']==0 || $w3['wiraswasta']=="") echo "&nbsp;"; else echo $w3['wiraswasta'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w3['tidakkerja']==0 || $w3['tidakkerja']=="") echo "&nbsp;"; else echo $w3['tidakkerja'];?></td>
        <td style="border-right:1px solid #00FF00; text-align:center; border-bottom:1px solid #999999;"><?php if($w3['jml']==0 || $w3['jml']=="") echo "&nbsp;"; else echo $w3['jml'];?></td>
        <td style="border-right:1px solid #00FF00; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td style="text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
      </tr>
      <tr>
        <td height="22" style="text-align:center; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">7</td>
        <td style="padding-left:5px; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">Sabu + Ganja</td>
        <td style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w3['pelajar']==0 || $w3['pelajar']=="") echo "&nbsp;"; else echo $w3['pelajar'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w3['mahasiswa']==0 || $w3['mahasiswa']=="") echo "&nbsp;"; else echo $w3['mahasiswa'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w3['pns']==0 || $w3['pns']=="") echo "&nbsp;"; else echo $w3['pns'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td width="8%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w3['wiraswasta']==0 || $w3['wiraswasta']=="") echo "&nbsp;"; else echo $w3['wiraswasta'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w3['tidakkerja']==0 || $w3['tidakkerja']=="") echo "&nbsp;"; else echo $w3['tidakkerja'];?></td>
        <td style="border-right:1px solid #00FF00; text-align:center; border-bottom:1px solid #999999;"><?php if($w3['jml']==0 || $w3['jml']=="") echo "&nbsp;"; else echo $w3['jml'];?></td>
        <td style="border-right:1px solid #00FF00; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td style="text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
      </tr>
      <tr>
        <td height="22" style="text-align:center; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">8</td>
        <td style="padding-left:5px; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">Kecubung</td>
        <td style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td style="border-right:1px solid #00FF00; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td style="border-right:1px solid #00FF00; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td style="text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
      </tr>
		<?php
				$q4 = "SELECT b_ms_diagnosa.kode, b_ms_diagnosa.nama, SUM(IF(b_ms_pekerjaan.id=12,1,0)) AS pelajar,
						SUM(IF(b_ms_pekerjaan.id=13,1,0)) AS mahasiswa, SUM(IF(b_ms_pekerjaan.id=9,1,0)) AS pns,
						SUM(IF(b_ms_pekerjaan.id=11,1,0)) AS wiraswasta, SUM(IF(b_ms_pekerjaan.id=2,1,0)) AS tidakkerja,
						SUM(IF(b_ms_pekerjaan.id=14,1,0)) AS lain, COUNT(b_diagnosa_rm.pelayanan_id) AS jml
						FROM b_kunjungan 
						INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id 
						INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id
						INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id=b_diagnosa_rm.ms_diagnosa_id
						INNER JOIN b_ms_pekerjaan ON b_ms_pekerjaan.id=b_kunjungan.pekerjaan_id
						INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
						WHERE b_pelayanan.unit_id='".$tmpLay."' AND b_ms_diagnosa.id='4791' $waktu AND b_pasien_keluar.kasus='1'";
				$s4 = mysql_query($q4);
				$w4 = mysql_fetch_array($s4);
		?>
      <tr>
        <td height="22" style="text-align:center; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">9</td>
        <td style="padding-left:5px; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">Ganja</td>
        <td style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w4['pelajar']==0 || $w4['pelajar']=="") echo "&nbsp;"; else echo $w4['pelajar'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w4['mahasiswa']==0 || $w4['mahasiswa']=="") echo "&nbsp;"; else echo $w4['mahasiswa'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w4['pns']==0 || $w4['pns']=="") echo "&nbsp;"; else echo $w4['pns'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td width="8%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w4['wiraswasta']==0 || $w4['wiraswasta']=="") echo "&nbsp;"; else echo $w4['wiraswasta'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w4['tidakkerja']==0 || $w4['tidakkerja']=="") echo "&nbsp;"; else echo $w4['tidakkerja'];?></td>
        <td style="border-right:1px solid #00FF00; text-align:center; border-bottom:1px solid #999999;"><?php if($w4['jml']==0 || $w4['jml']=="") echo "&nbsp;"; else echo $w4['jml'];?></td>
        <td style="border-right:1px solid #00FF00; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td style="text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
      </tr>
		<?php
				$q5 = "SELECT b_ms_diagnosa.kode, b_ms_diagnosa.nama, SUM(IF(b_ms_pekerjaan.id=12,1,0)) AS pelajar,
						SUM(IF(b_ms_pekerjaan.id=13,1,0)) AS mahasiswa, SUM(IF(b_ms_pekerjaan.id=9,1,0)) AS pns,
						SUM(IF(b_ms_pekerjaan.id=11,1,0)) AS wiraswasta, SUM(IF(b_ms_pekerjaan.id=2,1,0)) AS tidakkerja,
						SUM(IF(b_ms_pekerjaan.id=14,1,0)) AS lain, COUNT(b_diagnosa_rm.pelayanan_id) AS jml
						FROM b_kunjungan 
						INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id 
						INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id
						INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id=b_diagnosa_rm.ms_diagnosa_id
						INNER JOIN b_ms_pekerjaan ON b_ms_pekerjaan.id=b_kunjungan.pekerjaan_id
						INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
						WHERE b_pelayanan.unit_id='".$tmpLay."' AND b_ms_diagnosa.id='4787' $waktu AND b_pasien_keluar.kasus='1'";
				$s5 = mysql_query($q5);
				$w5 = mysql_fetch_array($s5);
		?>
      <tr>
        <td height="22" style="text-align:center; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">10</td>
        <td style="padding-left:5px; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">Alkohol</td>
        <td style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w5['pelajar']==0 || $w5['pelajar']=="") echo "&nbsp;"; else echo $w5['pelajar'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w5['mahasiswa']==0 || $w5['mahasiswa']=="") echo "&nbsp;"; else echo $w5['mahasiswa'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w5['pns']==0 || $w5['pns']=="") echo "&nbsp;"; else echo $w5['pns'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td width="8%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w5['wiraswasta']==0 || $w5['wiraswasta']=="") echo "&nbsp;"; else echo $w5['wiraswasta'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w5['tidakkerja']==0 || $w5['tidakkerja']=="") echo "&nbsp;"; else echo $w5['tidakkerja'];?></td>
        <td style="border-right:1px solid #00FF00; text-align:center; border-bottom:1px solid #999999;"><?php if($w5['jml']==0 || $w5['jml']=="") echo "&nbsp;"; else echo $w5['jml'];?></td>
        <td style="border-right:1px solid #00FF00; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td style="text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
      </tr>
      <tr>
        <td height="22" style="text-align:center; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">11</td>
        <td style="padding-left:5px; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">Triheksifenidil</td>
        <td style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td style="border-right:1px solid #00FF00; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td style="border-right:1px solid #00FF00; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td style="text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
      </tr>
		<?php
				$q6 = "SELECT b_ms_diagnosa.kode, b_ms_diagnosa.nama, SUM(IF(b_ms_pekerjaan.id=12,1,0)) AS pelajar,
						SUM(IF(b_ms_pekerjaan.id=13,1,0)) AS mahasiswa, SUM(IF(b_ms_pekerjaan.id=9,1,0)) AS pns,
						SUM(IF(b_ms_pekerjaan.id=11,1,0)) AS wiraswasta, SUM(IF(b_ms_pekerjaan.id=2,1,0)) AS tidakkerja,
						SUM(IF(b_ms_pekerjaan.id=14,1,0)) AS lain, COUNT(b_diagnosa_rm.pelayanan_id) AS jml
						FROM b_kunjungan 
						INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id 
						INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id
						INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id=b_diagnosa_rm.ms_diagnosa_id
						INNER JOIN b_ms_pekerjaan ON b_ms_pekerjaan.id=b_kunjungan.pekerjaan_id
						INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
						WHERE b_pelayanan.unit_id='".$tmpLay."' AND b_ms_diagnosa.id='4803' $waktu AND b_pasien_keluar.kasus='1'";
				$s6 = mysql_query($q6);
				$w6 = mysql_fetch_array($s6);
		?>
      <tr>
        <td height="22" style="text-align:center; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">12</td>
        <td style="padding-left:5px; border-right:1px solid #00FF00; border-bottom:1px solid #999999;">LEM</td>
        <td style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w6['pelajar']==0 || $w6['pelajar']=="") echo "&nbsp;"; else echo $w6['pelajar'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w6['mahasiswa']==0 || $w6['mahasiswa']=="") echo "&nbsp;"; else echo $w6['mahasiswa'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w6['pns']==0 || $w6['pns']=="") echo "&nbsp;"; else echo $w6['pns'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td width="8%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w6['wiraswasta']==0 || $w6['wiraswasta']=="") echo "&nbsp;"; else echo $w6['wiraswasta'];?></td>
        <td width="7%" style="border-right:1px solid #FF99FF; text-align:center; border-bottom:1px solid #999999;"><?php if($w6['tidakkerja']==0 || $w6['tidakkerja']=="") echo "&nbsp;"; else echo $w6['tidakkerja'];?></td>
        <td style="border-right:1px solid #00FF00; text-align:center; border-bottom:1px solid #999999;"><?php if($w6['jml']==0 || $w6['jml']=="") echo "&nbsp;"; else echo $w6['jml'];?></td>
        <td style="border-right:1px solid #00FF00; text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
        <td style="text-align:center; border-bottom:1px solid #999999;">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
