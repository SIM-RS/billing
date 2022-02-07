<?php include '../koneksi/konek.php'; 
if(($_REQUEST['formatlap'])=='XLS'){
    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="laporan_barang_milik_daerah_'.$_REQUEST['thn'].'.xls"');
  }else if(($_REQUEST['formatlap'])=='WORD'){
    header('Content-type: application/msword');
    header('Content-Disposition: attachment; filename="laporan_barang_milik_daerah_'.$_REQUEST['thn'].'.doc"');
    
}

date_default_timezone_set("Asia/Jakarta");
$tgl1 = gmdate('d-m-Y',mktime(date('H')+7));
$tgl11 = explode("-",$tgl1);
$tgl = '1 Desember '.$tgl11[2]; 
function indonesian_date ($timestamp = '', $date_format = ' j F Y', $suffix = '') {
	if (trim ($timestamp) == '')
	{
			$timestamp = time ();
	}
	elseif (!ctype_digit ($timestamp))
	{
		$timestamp = strtotime ($timestamp);
	}
	# remove S (st,nd,rd,th) there are no such things in indonesia :p
	$date_format = preg_replace ("/S/", "", $date_format);
	$pattern = array (
		'/Mon[^day]/','/Tue[^sday]/','/Wed[^nesday]/','/Thu[^rsday]/',
		'/Fri[^day]/','/Sat[^urday]/','/Sun[^day]/','/Monday/','/Tuesday/',
		'/Wednesday/','/Thursday/','/Friday/','/Saturday/','/Sunday/',
		'/Jan[^uary]/','/Feb[^ruary]/','/Mar[^ch]/','/Apr[^il]/','/May/',
		'/Jun[^e]/','/Jul[^y]/','/Aug[^ust]/','/Sep[^tember]/','/Oct[^ober]/',
		'/Nov[^ember]/','/Dec[^ember]/','/January/','/February/','/March/',
		'/April/','/June/','/July/','/August/','/September/','/October/',
		'/November/','/December/',
	);
	$replace = array ( 'Sen','Sel','Rab','Kam','Jum','Sab','Min',
		'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu',
		'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des',
		'Januari','Februari','Maret','April','Juni','Juli','Agustus','Sepember',
		'Oktober','November','Desember',
	);
	$date = date ($date_format, $timestamp);
	$date = preg_replace ($pattern, $replace, $date);
	$date = "{$date} {$suffix}";
	return $date;
}	
	$sq = mysql_query("select namadepartemen,kodedepartemen,dir_nama,dir_nip,pengurus_nama,pengurus_nip from as_setting");
$t = mysql_fetch_array($sq);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../theme/report.css" rel="stylesheet" type="text/css" />
<title>.: LAPORAN BARANG MILIK DAERAH TAHUNAN:.</title>
</head>
<style>
.judulheaderkiri{
border-bottom:1px solid;
border-left:1px solid;
border-top:1px solid;
border-right:1px solid;
}
.isiheader{
border-bottom:1px solid;
border-top:1px solid;
border-right:1px solid;
}
.subisiheader{
border-bottom:1px solid;
border-right:1px solid;
}
.isikiri{
border-bottom:1px solid;
border-left:1px solid;
border-right:1px solid;
}
.isi{
border-bottom:1px solid;
border-right:1px solid;
}
</style>
<body>
<table align="center" border="0" cellpadding="1" cellspacing="0" width="100%">
<tr>
	<td align="center" style="font-size:large">LAPORAN BARANG MILIK DAERAH TAHUNAN<br />
    PERIODE TAHUN <?echo $_REQUEST['thn'] ?></td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<table align="center" border="0" cellpadding="1" cellspacing="0" width="100%">
<tr>
	<td width="10%">Kode SKPD</td>
    <td width="1%">:</td>
	<td><?php echo $t['kodedepartemen'];?></td>
</tr>
<tr>
<td>Nama SKPD</td>
<td>:</td>
<td><?php echo $t['namadepartemen'];?></td>
</tr>
</table>
<tr>
	<td>&nbsp;</td>
</tr>

</table>
<table width="1250" cellpadding="1" cellspacing="0" border="0">
<tr style="background-color:white">
	<td width="34" rowspan="3" align="center" class="judulheaderkiri">No Urut</td>
	<td width="75" rowspan="3" align="center" class="isiheader">Kode Barang</td>
	<td width="250" rowspan="3" align="center" class="isiheader">Nama Bidang Barang</td>
	<td width="167" rowspan="2" colspan="2" align="center" class="isiheader">JUMLAH 1 Januari <?echo $_REQUEST['thn'] ?></td>
	<td width="167" align="center" colspan="4" class="isiheader">MUTASI/PERUBAHAN</td>
	<td width="167" rowspan="2" colspan="2" align="center" class="isiheader">JUMLAH 30 Desember <?echo $_REQUEST['thn'] ?></td>
	<td width="167" rowspan="3" align="center" class="isiheader">Keterangan</td>
	
</tr>
<tr style="background-color:white">
	<td width="51" align="center" colspan="2" class="subisiheader">Berkurang</td>
	<td width="63" align="center" colspan="2" class="subisiheader">Bertambah</td>
</tr>
<tr style="background-color:white">
	<td width="51" align="center" class="subisiheader">Barang</td>
	<td width="63" align="center" class="subisiheader">Nilai (Rp)</td>
	<td width="63" align="center" class="subisiheader">Jumlah Barang</td>
	<td width="63" align="center" class="subisiheader">Jumlah Nilai (Rp)</td>
	<td width="63" align="center" class="subisiheader">Jumlah Barang</td>
	<td width="63" align="center" class="subisiheader">Jumlah Nilai (Rp)</td>
	<td width="63" align="center" class="subisiheader">Barang</td>
	<td width="63" align="center" class="subisiheader">Nilai (Rp)</td>
</tr>



<tr style="background-color:white">
	<td align="center" class="isikiri">1</td>
	<td align="center" class="isi">2</td>
	<td align="center" class="isi">3</td>
	<td align="center" class="isi">4</td>
	<td align="center" class="isi">5</td>
	<td align="center" class="isi">6</td>
	<td align="center" class="isi">7</td>
	<td align="center" class="isi">8</td>
	<td align="center" class="isi">9</td>
	<td align="center" class="isi">10</td>
	<td align="center" class="isi">11</td>
	<td align="center" class="isi">12</td>
</tr>
	<?php 
 $sql = "SELECT kodebarang,namabarang,jml,nl FROM
(SELECT kodebarang,namabarang FROM as_ms_barang b WHERE tipe=1 AND LEVEL<=2) T1
LEFT JOIN
(SELECT LEFT(kodebarang,5) kd,COUNT(idseri) AS jml,SUM(nilaibuku) AS nl 
FROM as_ms_barang b INNER JOIN as_seri2 s ON b.idbarang=s.idbarang
WHERE s.isaktif=1 
GROUP BY kd) T2
ON T1.kodebarang=T2.kd ORDER BY kodebarang";
$sqlup = mysql_query($sql);
$jmlnilaiAk = 0;
$jmlAk = 0;
$i=1;
while($row = mysql_fetch_array($sqlup)){
//str_pad($row['noseri'],4,'0', STR_PAD_LEFT);
$nilaiAk += $row['nl'];
$jmlAk += $row['jml'];
	?>
<tr>
<td align="center" class="isikiri" width="34"><?php echo $i ?></td>
	<td class="isi" width="75"><?php echo $row['kodebarang'] ?></td>
	<td align="left" width="200" class="isi"><?php echo $row['namabarang'] ?></td>
	<td align="center" class="isi"><?php echo ""; ?></td>
	<td align="center" class="isi"><?php echo ""; ?></td>
	<td align="center" class="isi"><?php echo ""; ?></td>
	<td align="center" class="isi"><?php echo ""; ?></td>
	<td align="center" class="isi"><?php echo ""; ?></td>
	<td align="center" class="isi"><?php echo ""; ?></td>
	<td align="right" class="isi"><?php if($row['jml']=='') echo "0"; else echo number_format($row['jml'],0,',','.'); ?></td>
	<td align="right" class="isi"><?php if($row['nl']=='') echo "0"; else echo number_format($row['nl'],0,',','.'); ?></td>
	<td align="center" class="isi"><?php echo $polisi; ?></td>
</tr>
<?php 
$i++;
}
?>
<tr><td class="isikiri" colspan="3" align="center">Jumlah</td>
<td class="isi" align="right">0</td>
<td class="isi" align="right">0</td>
<td class="isi" align="right">0</td>
<td class="isi" align="right">0</td>
<td class="isi" align="right">0</td>
<td class="isi" align="right">0</td>
<td class="isi" align="right"><?=number_format($jmlAk,0,',','.');?></td>
<td class="isi" align="right"><?=number_format($nilaiAk,0,',','.');?></td>
<td class="isi" align="right">0</td>
</tr> 
<tr><td colspan="12" >&nbsp;</td></tr>
<tr>
<td align="center" class="judulheaderkiri"><?php echo $i ?></td>
	<td class="isiheader">&nbsp;</td>
	<td align="left" class="isiheader"><?php echo "ASET TETAP DILUAR BELANJA MODAL"; ?></td>
	<td align="center" class="isiheader">&nbsp;</td>
	<td align="center" class="isiheader">&nbsp;</td>
	<td align="center" class="isiheader">&nbsp;</td>
	<td align="center" class="isiheader">&nbsp;</td>
	<td align="center" class="isiheader">&nbsp;</td>
	<td align="center" class="isiheader">&nbsp;</td>
	<td align="right" class="isiheader"><?php if($row['jml']=='') echo "0"; else echo number_format($row['djml'],0,',','.'); ?></td>
	<td align="right" class="isiheader"><?php if($row['nl']=='') echo "0"; else echo number_format($row['dnl'],0,',','.'); ?></td>
	<td align="center" class="isiheader">&nbsp;</td>

</tr>
<tr>
<td align="center" class="isikiri"><?php echo $i+1; ?></td>
	<td class="isi">&nbsp;</td>
	<td align="left" class="isi"><?php echo "BARANG TIDAK DAPAT DIKAPITALISASI"; ?></td>
	<td align="center" class="isi">&nbsp;</td>
	<td align="center" class="isi">&nbsp;</td>
	<td align="center" class="isi">&nbsp;</td>
	<td align="center" class="isi">&nbsp;</td>
	<td align="center" class="isi">&nbsp;</td>
	<td align="center" class="isi">&nbsp;</td>
	<td align="right" class="isi"><?php if($row['jml']=='') echo "0"; else echo number_format($row['jml'],0,',','.'); ?></td>
	<td align="right" class="isi"><?php if($row['nl']=='') echo "0"; else echo number_format($row['nl'],0,',','.'); ?></td>
	<td align="center" class="isi">&nbsp;</td>

</tr>
<tr><td class="isikiri" colspan="3" align="center">Jumlah</td>
<td class="isi" align="right">0</td>
<td class="isi" align="right">0</td>
<td class="isi" align="right">0</td>
<td class="isi" align="right">0</td>
<td class="isi" align="right">0</td>
<td class="isi" align="right">0</td>
<td class="isi" align="right">0</td>
<td class="isi" align="right">0</td>
<td class="isi" align="right">0</td>
</tr> 

<tr><td colspan="6">&nbsp;</td><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="6">&nbsp;</td><td colspan="2">&nbsp;</td></tr>
<tr><td>&nbsp;</td><td colspan="2" align="center">Mengetahui,</td><td colspan="6">&nbsp;</td><td colspan="3" align="center" style="font-size:12px;">Sidoarjo, <?php echo indonesian_date(); ?> </td></tr>
<tr><td>&nbsp;</td><td colspan="2" align="center">DIREKTUR RSUD</td><td colspan="6">&nbsp;</td><td colspan="3" align="center" style="font-size:12px;">PENGURUS BARANG</td></tr>
<tr><td>&nbsp;</td><td colspan="2" align="center">KABUPATEN SIDOARJO</td><td colspan="6">&nbsp;</td><td colspan="2">&nbsp;</td></tr>
<?php

?>
<tr><td colspan="4">&nbsp;</td><td colspan="1">&nbsp;</td><td colspan="2">&nbsp;</td></tr>

<tr><td colspan="4">&nbsp;</td><td colspan="1">&nbsp;</td><td colspan="2">&nbsp;</td></tr>

<tr><td colspan="4">&nbsp;</td><td colspan="1">&nbsp;</td><td colspan="2">&nbsp;</td></tr>
<tr><td>&nbsp;</td><td colspan="2" align="center" style="font-size:12px;"><?=$t['dir_nama']; ?></td><td colspan="6">&nbsp;</td><td colspan="3" align="center" style="font-size:12px;"><?=$t['pengurus_nama']; ?></td></tr>
<tr><td>&nbsp;</td><td colspan="2"align="center" style="text-decoration: overline;">NIP. <?php echo $t['dir_nip']; ?></td><td colspan="6">&nbsp;</td><td colspan="3" align="center" style="text-decoration: overline;">NIP. <?php echo $t['pengurus_nip']; ?></td></tr>
</table>

</body>
</html>
