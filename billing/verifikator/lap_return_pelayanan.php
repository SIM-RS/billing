<?php
session_start();
include("../sesi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Return Pelayanan</title>
</head>

<body>
<table width="900" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
	<tr>
		<td><b><?=$pemkabRS?><br><?=$namaRS?><br><?=$alamatRS?><br>Telepon <?=$tlpRS?></b></td>
	</tr>
    <tr>
    	<td align="center">&nbsp;</td>
    </tr>
    <tr>
    	<td align="center" style="font-weight:bold; font-size:16px">RETURN PELAYANAN</td>
    </tr>
    <tr>
    	<td align="center">&nbsp;</td>
    </tr>
   </table>
   <?php
   include("../koneksi/konek.php");
    $jnsRwt = $_REQUEST['jnsRwt'];
	$idKunj = $_REQUEST['idKunj'];
	//$jnsRwt = '1';
	//$idKunj = '454350';
    $sql = "SELECT DISTINCT 
		  p.id,
		  p.no_rm,
		  p.nama,
		  p.alamat,
		  p.rt,
		  p.rw,
		  w.nama AS desa,
		  i.nama AS kec,
		  l.nama AS kab,
		  p.tgl_lahir,
		  p.sex,
		  k.tgl,
		  k.umur_thn,
		  n.nama AS unit,
		  k.id AS kunjungan_id,
		  k.verifikasi,
		  k.note_verifikasi,
		  r.tgl_return,
		  r.no_return 
		FROM
		  b_ms_pasien p 
		  INNER JOIN b_kunjungan k 
			ON k.pasien_id = p.id 
		  LEFT JOIN b_ms_wilayah w 
			ON w.id = p.desa_id 
		  LEFT JOIN b_ms_wilayah i 
			ON i.id = p.kec_id 
		  LEFT JOIN b_ms_wilayah l 
			ON l.id = p.kab_id 
		  LEFT JOIN b_ms_unit n 
			ON n.id = k.unit_id 
		  INNER JOIN b_bayar b 
			ON b.kunjungan_id = k.id 
		  INNER JOIN b_bayar_tindakan bt 
			ON bt.bayar_id = b.id 
		  INNER JOIN b_return r 
			ON r.bayar_tindakan_id = bt.id where k.id='$idKunj'";
		$kueri = mysql_query($sql);
		$data=mysql_fetch_array($kueri);
   ?>
   <table width="900" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
	<tr>
		<td width="100">No. Return</td>
        <td>:&nbsp;<?php echo $data['no_return']; ?></td>
	</tr>
    <tr>
		<td>Tanggal</td>
        <td>:&nbsp;<?php echo $data['tgl_return']; ?></td>
	</tr>
    <tr>
		<td>No RM</td>
        <td>:&nbsp;<?php echo $data['no_rm']; ?></td>
	</tr>
    <tr>
		<td>Nama Pasien</td>
        <td>:&nbsp;<?php echo $data['nama']; ?></td>
	</tr>
 	<tr>
		<td>&nbsp;</td>
	</tr>
   </table>
<table width="900" cellspacing="0" cellpadding="0">
  <tr>
    <td width="30" style="border-left:1px solid; border-bottom:1px solid; border-top:1px solid; border-right:1px solid; text-align:center; font-size:12px; font-weight:bold;">No</td>
    <td width="120" style=" border-top:1px solid; border-bottom:1px solid; border-right:1px solid; text-align:center; font-size:12px; font-weight:bold;">Jenis Layanan</td>
    
    <td width="120" style=" border-top:1px solid; border-bottom:1px solid; border-right:1px solid; text-align:center; font-size:12px; font-weight:bold;">Tempat Layanan</td>
    <td width="70" style=" border-top:1px solid; border-bottom:1px solid; border-right:1px solid; text-align:center; font-size:12px; font-weight:bold;">Tanggal</td>
    <td style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid; text-align:center; font-size:12px; font-weight:bold;">Tindakan</td>
    <td width="80" style=" border-top:1px solid; border-bottom:1px solid; border-right:1px solid; text-align:center; font-size:12px; font-weight:bold;">Kelas</td>
    <td width="50" style=" border-top:1px solid; border-bottom:1px solid; border-right:1px solid; text-align:center; font-size:12px; font-weight:bold;">Jumlah</td>
    <td width="50" style=" border-top:1px solid; border-bottom:1px solid; border-right:1px solid; text-align:center; font-size:12px; font-weight:bold;">Tarif RS</td>
    <td width="50" style=" border-top:1px solid; border-bottom:1px solid; border-right:1px solid; text-align:center; font-size:12px; font-weight:bold;">Tarif KSO</td>
    <td width="50" style=" border-top:1px solid; border-bottom:1px solid; border-right:1px solid; text-align:center; font-size:12px; font-weight:bold;">Iur Bayar</td>
    <td width="50" style=" border-top:1px solid; border-bottom:1px solid; border-right:1px solid; text-align:center; font-size:12px; font-weight:bold;">Bayar Pasien</td>
  </tr>
  <?php
	if($jnsRwt=='3'){
$sql = "SELECT tbl1.* FROM (SELECT 
	  p.jenis_kunjungan,
	  t.id,
	  bt.id AS bayar_tindakan_id,
	  t.pelayanan_id,
	  n.nama AS jenis,
	  p.unit_id,
	  mu.parent_id,
	  mu.nama AS unit,
	  t.tgl,
	  t.qty AS jumlah,
	  t.biaya,
	  t.biaya_kso,
	  t.biaya_pasien,
	  t.bayar_pasien,
	  bt.nilai AS bayar_tindakan,
	  mt.nama AS tindakan,
      mk.nama AS kelas  
	FROM
	  b_pelayanan p 
	  INNER JOIN b_ms_unit mu 
		ON p.unit_id = mu.id 
	  INNER JOIN b_tindakan t 
		ON p.id = t.pelayanan_id 
	  LEFT JOIN b_ms_unit n 
		ON n.id = mu.parent_id 
	  INNER JOIN b_ms_tindakan_kelas tk 
		ON tk.id = t.ms_tindakan_kelas_id 
	  INNER JOIN b_ms_tindakan mt 
		ON mt.id = tk.ms_tindakan_id 
	  INNER JOIN b_ms_kelas mk 
		ON mk.id = tk.ms_kelas_id 
	  INNER JOIN b_bayar_tindakan bt 
		ON bt.tindakan_id = t.id
	WHERE p.kunjungan_id = '$idKunj' 
	  AND p.jenis_kunjungan = 3 
	  AND bt.tipe = 0
	UNION
	SELECT 
	  p.jenis_kunjungan,
	  t.id,
	  bt.id AS bayar_tindakan_id,
	  t.pelayanan_id,
	  n.nama AS jenis,
	  p.unit_id,
	  mu.parent_id,
	  mu.nama AS unit,
	  t.tgl_in AS tgl,
	  t.qty AS jumlah,
	  t.tarip AS biaya,
	  t.beban_kso AS biaya_kso,
	  t.beban_pasien AS biaya_pasien,
	  t.bayar_pasien,
	  bt.nilai AS bayar_tindakan,
	  mt.nama AS tindakan,
  	  mk.nama AS kelas 
	FROM
	  b_pelayanan p 
	  INNER JOIN b_ms_unit mu 
		ON p.unit_id = mu.id 
	  INNER JOIN b_tindakan_kamar t 
		ON p.id = t.pelayanan_id 
	  LEFT JOIN b_ms_unit n 
		ON n.id = mu.parent_id 
	  INNER JOIN b_ms_kamar tk 
		ON tk.id = t.kamar_id 
	  INNER JOIN b_bayar_tindakan bt 
		ON bt.tindakan_id = t.id
	  INNER JOIN b_tindakan ti 
    	ON ti.id = bt.tindakan_id 
  	  INNER JOIN b_ms_tindakan_kelas btk 
    	ON btk.id = ti.ms_tindakan_kelas_id 
      INNER JOIN b_ms_tindakan mt 
    	ON mt.id = btk.ms_tindakan_id 
  	  INNER JOIN b_ms_kelas mk 
    	ON mk.id = btk.ms_kelas_id  
	WHERE p.kunjungan_id = '$idKunj' 
	  AND p.jenis_kunjungan = 3 
	  AND bt.tipe = 1) AS tbl1 
		  INNER JOIN 
			(SELECT 
			  bayar_tindakan_id 
			FROM
			  b_return) AS tbl2 
			ON tbl1.bayar_tindakan_id = tbl2.bayar_tindakan_id";
}

elseif($jnsRwt=='1' || $jnsRwt=='2'){
	$sql = "SELECT 
	  tbl1.* 
	FROM
	  (SELECT 
		p.jenis_kunjungan,
		t.id,
		bt.id AS bayar_tindakan_id,
		t.pelayanan_id,
		n.nama AS jenis,
		p.unit_id,
		mu.parent_id,
		mu.nama AS unit,
		t.tgl,
		t.qty AS jumlah,
		t.biaya,
		t.biaya_kso,
		t.biaya_pasien,
		t.bayar_pasien,
		bt.nilai AS bayar_tindakan,
		mt.nama AS tindakan,
        mk.nama AS kelas  
	  FROM
		b_pelayanan p 
		INNER JOIN b_ms_unit mu 
		  ON p.unit_id = mu.id 
		INNER JOIN b_tindakan t 
		  ON p.id = t.pelayanan_id 
		LEFT JOIN b_ms_unit n 
		  ON n.id = mu.parent_id 
		INNER JOIN b_ms_tindakan_kelas tk 
		  ON tk.id = t.ms_tindakan_kelas_id 
		INNER JOIN b_ms_tindakan mt 
		  ON mt.id = tk.ms_tindakan_id 
		INNER JOIN b_ms_kelas mk 
		  ON mk.id = tk.ms_kelas_id 
		INNER JOIN b_bayar_tindakan bt 
		  ON bt.tindakan_id = t.id 
	  WHERE p.kunjungan_id = '$idKunj' 
		AND p.jenis_kunjungan = '$jnsRwt' 
		AND bt.tipe = 0) AS tbl1 
	  INNER JOIN 
		(SELECT 
		  bayar_tindakan_id 
		FROM
		  b_return) AS tbl2 
		ON tbl1.bayar_tindakan_id = tbl2.bayar_tindakan_id";
}

		

$kueri=mysql_query($sql);
$no=1;
$jumlah=0;
$total=0;
$kso=0;
$pasien=0;
$tindakan=0;
while($row=mysql_fetch_array($kueri)){
?>
  <tr>
    <td style="border-left:1px solid; border-bottom:1px solid; text-align:center; font-size:10px;"><?php echo $no; ?></td>
    <td style="border-left:1px solid; border-bottom:1px solid; text-align:left; font-size:10px;">&nbsp;<?php echo $row['jenis']; ?></td>
    
    <td style="border-left:1px solid; border-bottom:1px solid; text-align:left; font-size:10px;">&nbsp;<?php echo $row['unit']; ?></td>
    <td style="border-left:1px solid; border-bottom:1px solid; text-align:center; font-size:10px;"><?php echo $row['tgl']; ?></td>
    <td style="border-left:1px solid; border-bottom:1px solid; text-align:left; font-size:10px;">&nbsp;<?php echo $row['tindakan']; ?></td>
    <td style="border-left:1px solid; border-bottom:1px solid; text-align:center; font-size:10px;"><?php echo $row['kelas']; ?></td>
    <td style="border-left:1px solid; border-bottom:1px solid; text-align:right; font-size:10px;"><?php echo $row['jumlah']; ?>&nbsp;</td>
    <td style="border-left:1px solid; border-bottom:1px solid; text-align:right; font-size:10px;"><?php echo number_format($row['biaya'],0,',','.'); ?>&nbsp;</td>
    <td style="border-left:1px solid; border-bottom:1px solid; text-align:right; font-size:10px;"><?php echo number_format($row['biaya_kso'],0,',','.'); ?>&nbsp;</td>
    <td style="border-left:1px solid; border-bottom:1px solid; text-align:right; font-size:10px;"><?php echo number_format($row['biaya_pasien'],0,',','.'); ?>&nbsp;</td>
    <td style="border-left:1px solid; border-bottom:1px solid; border-right:1px solid; text-align:right; font-size:10px;"><?php echo number_format($row['bayar_tindakan'],0,',','.'); ?>&nbsp;</td>
  </tr>
  
  <?php
  $no++;
  $jumlah=$jumlah+$row['jumlah'];
  $total=$total+$row['biaya'];
  $kso=$kso+$row['biaya_kso'];
  $tindakan=$tindakan+$row['biaya_pasien'];
  $pasien=$pasien+$row['bayar_tindakan'];
}
  ?>
  <tr>
    <td colspan="6" align="right">Total :&nbsp;</td>
	<td align="right" style=" font-size:10px;"><?php echo number_format($jumlah,0,',','.'); ?>&nbsp;</td>
    <td align="right" style=" font-size:10px;"><?php echo number_format($total,0,',','.'); ?>&nbsp;</td>
    <td align="right" style=" font-size:10px;"><?php echo number_format($kso,0,',','.'); ?>&nbsp;</td>
    <td align="right" style=" font-size:10px;"><?php echo number_format($tindakan,0,',','.'); ?>&nbsp;</td>
    <td align="right" style=" font-size:10px;"><?php echo number_format($pasien,0,',','.'); ?>&nbsp;</td>
  </tr>
</table>
</body>
</html>