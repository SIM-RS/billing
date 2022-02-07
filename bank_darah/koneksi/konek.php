<html>
<head>
	<title>PERMINTAAN DARAH UNTUK TRANFUSI</title>
</head>
<body>
<div align="center">
<?php
$idpel = $_REQUEST['idpel'];
$idkunj = $_REQUEST['idkunj'];
$no_minta =  $_REQUEST['no_minta'];

	include("../koneksi/konek.php");
$sqlcetak = "SELECT
  pu.tgl,
  pu.no_minta,
  pu.sifat_minta,
  pu.tgl_op,
  ps.nama           nama_pasien,
  ps.sex,
  ps.no_rm,
  ps.alamat,
  (SELECT
     nama
   FROM $dbbilling.b_ms_wilayah
   WHERE id = k.desa_id) AS desa,
  (SELECT
     nama
   FROM $dbbilling.b_ms_wilayah
   WHERE id = k.kec_id) AS kec,
  (SELECT
     nama
   FROM $dbbilling.b_ms_wilayah
   WHERE id = k.kab_id) AS kab,
  k.umur_thn,
  kso.nama          nama_kso,
  d.golongan,
  pg.nama        AS dokter,
  u.nama         AS tempat,
  kl.nama        AS nama_kelas
FROM bd_permintaan_unit pu
  INNER JOIN $dbbilling.b_kunjungan k
    ON pu.kunjungan_id = k.id
  INNER JOIN $dbbilling.b_pelayanan p
    ON pu.pelayanan_id = p.id
  LEFT JOIN bd_ms_gol_darah d
    ON pu.gol_darah_id = d.id
  INNER JOIN $dbbilling.b_ms_pasien ps
    ON ps.id = k.pasien_id
  INNER JOIN $dbbilling.b_ms_pegawai pg
    ON pu.dokter_id = pg.id
  INNER JOIN $dbbilling.b_ms_unit u
    ON p.unit_id = u.id
  INNER JOIN $dbbilling.b_ms_kso kso
    ON kso.id = p.kso_id
  INNER JOIN $dbbilling.b_ms_kelas kl
    ON kl.id = p.kelas_id
WHERE pu.pelayanan_id = $idpel
    AND pu.kunjungan_id = $idkunj
	AND pu.no_minta = '$no_minta'
	";
$kuericetak = mysql_query($sqlcetak);
$cetak = mysql_fetch_array($kuericetak);
?>

<table cellspacing="0" cellpadding="0" width="800">
<tr>
<td rowspan="5" width="120">&nbsp;</td>
 <td></td>
 <td width="120">&nbsp;</td>
</tr>
<tr>
 <td align="center" style="font-size:24px">&nbsp;</td>
 <td></td>
</tr>
<tr>
 <td align="center" style="font-size:24px"><b>RUMAH SAKIT UMUM DAERAH TANGERANG</b></td>
 <td></td>
</tr>
<tr>
 <td align="center" style="font-size:24px"><b>INSTALASI BANK DARAH</b></td>
 <td></td>
</tr>
<tr>
 <td align="center" style="font-size:18px">&nbsp;</td>
 <td></td>
</tr>
</table>
<hr style="border:groove">
<table cellspacing="0" cellpadding="0" width="800">
<tr>
	<td style="text-decoration:underline; font-size:18px">PERMINTAAN DARAH UNTUK TRANFUSI</td>
</tr>
<tr>
	<td>- Setiap permintaan darah, harap disertai contoh darah 5 cc, tanpa antikoagulan</td>
</tr>
<tr>
	<td>- Nama dan identitas O.S. Pada formulir dan contoh darahnya harus sama</td>
</tr>
<tr>
	<td height="20"></td>
</tr>
</table>
<table cellspacing="0" cellpadding="0" width="800">
  <tr>
    <td colspan="2">Rumah    Sakit</td>
    <td colspan="2">: RSUD TANGERANG</td>
    <td colspan="3">Bag. <?php echo $cetak['tempat']; ?></td>
    <td width="64">Kelas <?php echo $cetak['nama_kelas']; ?></td>
    <td width="64"></td>
  </tr>
  <tr>
    <td colspan="2">Dokter yang meminta</td>
    <td colspan="3">: <?php echo $cetak['dokter']; ?></td>
    <td width="39"></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td colspan="2">Nama Penderita</td>
    <td colspan="2">: <?php echo $cetak['nama_pasien']; ?></td>
    <td width="114"><?php echo $cetak['sex']; ?></td>
    <td>Umur</td>
    <td><?php echo $cetak['umur_thn']." Thn"; ?></td>
    <td>No.Reg</td>
    <td><?php echo $cetak['no_rm']; ?></td>
  </tr>
  <tr>
    <td colspan="2">Alamat Penderita</td>
    <td colspan="7">: <?php echo $cetak['alamat']." ".$cetak['desa']." ".$cetak['kec']." ".$cetak['kab']; ?></td>
  </tr>
  <tr>
    <td colspan="2">Diagnosa</td>
    <td width="64">:</td>
    <td width="194"></td>
    <td></td>
    <td></td>
    <td colspan="2">Gol. Darah : <?php echo $cetak['golongan']; ?></td>
    <td></td>
  </tr>
  <tr>
  <?php
  $tgl = explode(" ",$cetak["tgl_op"]);
  $jam = explode(":",$tgl[1]);
  ?>
    <td colspan="2">Sifat permintaan</td>
    <td colspan="7">: <?php if($cetak['sifat_minta']==1) echo 'Biasa'; else if($cetak['sifat_minta']==2) echo 'Cito'; else echo 'Persiapan operasi tanggal '.tglSQL($tgl[0]).' jam '.$jam[0].":".$jam[1]." WIB";?></td>
  </tr>
  <tr>
    <td colspan="2">Macam darah yang diminta</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <?php
			$no=1;
			$ctk="SELECT d.darah,pu.qty
FROM bd_ms_darah d
  INNER JOIN bd_permintaan_unit pu
    ON pu.ms_darah_id = d.id
WHERE pu.no_minta = '".$cetak['no_minta']."'";
		$r=mysql_query($ctk);
		while($rows=mysql_fetch_array($r)){ 
?>
  <tr>
    <td width="48" align="center"><?php echo $no;?>.</td>
    <td colspan="4"><?php echo $rows['darah'];?></td>
    <td><?php echo $rows['qty'];?></td>
    <td>Kantong</td>
    <td></td>
    <td></td>
  </tr>
 <?php
$no++;		
}
 ?>
  <tr>
    <td colspan="2">Tranfusi sebelumnya</td>
    <td colspan="2">: Ya / Tidak</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="144">&nbsp;</td>
    <td>&nbsp;&nbsp;Tanggal</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">Reaksi Tranfusi</td>
    <td colspan="2">: Ya / Tidak</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
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
</table>
<table cellspacing="0" cellpadding="0" width="800">
<tr>
 	<td>&nbsp;</td>
 	<td>&nbsp;</td>
   	<td>&nbsp;</td>
    <td style=""><!--Catatan khusus--></td>
	<td align="right" colspan="2">Tangerang, <?php echo date('d-m-Y'); ?></td>
    <td>&nbsp;</td>
</tr>
<tr>
	<td width="30">&nbsp;</td>
    <td width="181" align="center">Petugas yang mengambil</td>
    <td width="47">&nbsp;</td>
    <td width="245" rowspan="3" style="border-left:solid 2px; border-top:solid 2px; border-right:solid 2px;"><div align="justify" style="display:none">Untuk keperluan CITO. Darah diberikan tanpa pemeriksaan HBsAg, HCV & VDRL dan
     tanpa Crossmatch Dokter RS yang meminta.</div></td>
    <td width="50">&nbsp;</td>
    <td width="218" align="center">Dokter yang meminta</td>
    <td width="27">&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td align="center" valign="top">Contoh darah penderita</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center" valign="top">dan stempel Rumah Sakit</td>
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
    <td align="center" style="border-left:solid 2px;border-right:solid 2px;"><!--Menyetujui,--></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td style="border-left:solid 2px;border-right:solid 2px;"><!--&nbsp;--></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td align="center">(.............................)</td>
    <td>&nbsp;</td>
    <td align="center" style="border-left:solid 2px;border-right:solid 2px;"><!--(.............................)--></td>
    <td>&nbsp;</td>
    <td align="center">(.............................)</td>
    <td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td align="center">Nama Terang</td>
    <td>&nbsp;</td>
    <td align="center" style="border-left:solid 2px; border-bottom:solid 2px;border-right:solid 2px;"><!--Nama Terang--></td>
    <td>&nbsp;</td>
    <td align="center">Nama Terang</td>
    <td>&nbsp;</td>
</tr>
</table>
<table width="800" align="center" cellpadding="0" cellspacing="0">
<tr>
	<td colspan="4"><hr style="border:dashed" color="#000000"></td>
</tr>
<tr>
	<td align="center" height="60" valign="top">Penderita Kluarga</td>
	<td align="center" valign="top">Pengendalian RSUD </td>
	<td align="center" valign="top">Pengendalian UTD. PMI </td>
	<td align="center" valign="top">Penerima Darah </td>
</tr>
<tr>
	<td align="center"><hr width="200" color="#000000"></td>
	<td align="center"><hr width="200" color="#000000"></td>
	<td align="center"><hr width="200" color="#000000"></td>
	<td align="center"><hr width="200" color="#000000"></td>
</tr>
<tr>
	<td colspan="4"><hr color="#000000"></td>
</tr>
<?php
$sql ="SELECT
  pn.kode_bag,pm.tgl,gd.golongan
FROM bd_pemakaian pm
  INNER JOIN bd_penerimaan pn
    ON pm.penerimaan_id = pn.id
  INNER JOIN $dbbilling.b_kunjungan k
    ON k.id = pm.kunjungan_id
  INNER JOIN bd_ms_darah d
    ON d.id = pm.ms_darah_id
  INNER JOIN bd_ms_gol_darah gd
    ON gd.id = pm.gol_darah_id
  INNER JOIN bd_ms_rhesus r
    ON r.id = pm.rhesus_id
  INNER JOIN bd_permintaan_unit pu
    ON pu.no_minta = pm.no_minta
WHERE pm.no_minta = '".$cetak['no_minta']."'";
$qkueri = mysql_query($sql);
?>
<tr>
	<td colspan="4">Diisi oleh petugas BANK DARAH</td>
</tr>
<tr>
	<td colspan="4"><hr color="#000000"></td>
</tr>
<tr>
	<td colspan="4">
		<table width="100%" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td valign="top">
			<table width="100%" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td width="13%">Contoh Darah OS </td>
				<td width="7%">:</td>
			</tr>
			<tr>
				<td>Diterima Tgl</td>
				<td>:</td>
			</tr>
			<tr>
				<td style="padding-left:55px">Jam</td>
				<td>:</td>
			</tr>
			<tr>
				<td>Nilai ATD Penerima</td>
				<td>:</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
				<table width="100%" align="center" cellpadding="0" cellspacing="0" border="1">
				<tr>
					<td>ABO</td>
					<td>Rhsus</td>
					<td>Lain2</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				</table>				</td>
			</tr>
			<tr>
				<td colspan="4">Nama ATD Pemeriksaan&nbsp;</td>
			</tr>
			<tr>
				<td colspan="4"><hr color="#000000"></td>
			</tr>
			<tr>
				<td colspan="4">Nama ATD yang mengeluarkan</td>
			</tr>
			<tr>
				<td>Darah</td>
				<td  colspan="4">:</td>
			</tr>
			<tr>
				<td>Tanggal</td>
				<td>:</td>
				<td width="5%">Jam</td>
				<td width="75%">:</td>
			</tr>
			<tr>
				<td colspan="4"><hr color="#000000"></td>
			</tr>
			<tr>
				<td colspan="4">Nama terang / tanda tangan:</td>
				</tr>
			<tr>
				<td>Penerima Darah</td>
			</tr>
			<tr>
				<td height="30" valign="bottom">(..........................)</td>
			</tr>
			</table>
			</td>
			<td valign="top">
			<table width="100%" align="center" cellpadding="0" cellspacing="0" border="1">
			<tr>
				<td>No</td>
				<td>No Kantong Darah</td>
				<td>Tgl. Pengambilan</td>
				<td>Gol</td>
				<td>Hasil Cross</td>
			</tr>
            <?php
			$no = 1;
			while($dctk = mysql_fetch_array($qkueri)){
			?>
			<tr>
				<td>&nbsp;<?php echo $no; ?></td>
				<td>&nbsp;<?php echo $dctk['kode_bag']; ?></td>
				<td>&nbsp;<?php echo tglSQL($dctk['tgl']); ?></td>
				<td align="center"><?php echo $dctk['golongan']; ?></td>
				<td>&nbsp;Compatible</td>
			</tr>
            <?php
			$no++;
			}
			?>
			</table>
			</td>
		</tr>
		<tr>
			<td colspan="2"><hr color="#000000"></td>
		</tr>
		</table>
	</td>
</tr>
</table>
<table cellspacing="0" cellpadding="0" width="800" align="center">
  <tr>
    <td width="161">Telah dikirim</td>
    <td width="192"></td>
    <td width="64">Jumlah</td>
    <td width="89"></td>
    <td width="64"></td>
    <td colspan="3">(&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $no-1; ?>&nbsp;&nbsp;&nbsp;&nbsp;)    kantong darah</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td>Gol. Darah</td>
    <td>:</td>
    <td width="13"></td>
    <td width="70"></td>
    <td width="145"></td>
  </tr>
  <tr>
    <td>Penderita bernama</td>
    <td colspan="2">: <?php echo $cetak['nama_pasien']; ?></td>
    <td>Gol. Darah</td>
    <td>: <?php echo $cetak['golongan']; ?></td>
    <td></td>
    <td colspan="2">No. Reg. <?php echo $cetak['no_rm']; ?></td>
  </tr>
  <tr>
    <td>Dirawat di rumah sakit</td>
    <td colspan="2">: RSUD TANGERANG</td>
    <td>Bag.</td>
    <td colspan="3"> <?php echo $cetak['tempat']; ?></td>
    <td>Kelas <?php echo $cetak['nama_kelas']; ?></td>
  </tr>
  <tr>
    <td>Dokter yang meminta</td>
    <td colspan="2">: <?php echo $cetak['dokter']; ?></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</table>
<table cellspacing="0" cellpadding="0" width="800">
  <tr>
    <td width="32"></td>
    <td width="229"></td>
    <td width="61"></td>
    <td width="222" style="border-left:solid 2px; border-top:solid 2px; border-right:solid 2px;">Hasil reaksi silang :</td>
    <td width="52"></td>
    <td width="161">Tangerang, <?php echo date('d-m-Y'); ?></td>
    <td width="41"></td>
  </tr>
  <tr>
    <td></td>
    <td align="center">Tanda tangan ATD yang memeriksa</td>
    <td></td>
    <td style="border-left:solid 2px;border-right:solid 2px;">- Minor : Incompatible</td>
    <td></td>
    <td align="center">Tanda tangan penerima</td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td style="border-left:solid 2px;border-right:solid 2px;">- D C T : Positif</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td rowspan="2" width="222" style="border-left:solid 2px;border-right:solid 2px;">O.S. Bila ditransfusi    berupa komponen packed Red Cell (PRC).</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="center">(......................................)</td>
    <td></td>
    <td style="border-left:solid 2px;border-right:solid 2px;">(Setuju / Tidak setuju)</td>
    <td></td>
    <td align="center">(......................................)</td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="center">Nama Terang</td>
    <td></td>
    <td style="border-left:solid 2px;border-right:solid 2px;">&nbsp;</td>
    <td></td>
    <td align="center">Nama Terang</td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td align="center" style="border-left:solid 2px;border-right:solid 2px;">(.......................................)</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td align="center" style="border-left:solid 2px;border-right:solid 2px;border-bottom:solid 2px">Tanda Tangan, Nama Terang</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</table>
</div>
</body>
</html>