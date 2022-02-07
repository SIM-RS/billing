<?php 
include '../sesi.php';
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
if(($_REQUEST['jenislap'])=='XLS'){
    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="Laporan_gedung'.$_POST['fname'].'.xls"');
}else if(($_REQUEST['jenislap'])=='WORD'){
	header('Content-type: application/msword');
	header('Content-Disposition: attachment; filename="Laporan_gedung'.$_POST['fname'].'.doc"');
}
include '../koneksi/konek.php';
$sq = mysql_query("select namadepartemen,kodedepartemen,dir_nama,dir_nip,pengurus_nama,pengurus_nip from as_setting");
$t = mysql_fetch_array($sq);
date_default_timezone_set("Asia/Jakarta");
$tgl1 = gmdate('d-m-Y',mktime(date('H')+7));
$tgl11 = explode("-",$tgl1);
  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../theme/report.css" rel="stylesheet" type="text/css" />
<title>.: Laporan KIB Gedubng,Irigasi&amp;Jeringan :.</title>
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
<script language="javascript">
function Cetak(){
	window.print();
}
</script>
<body>

<button type="button" id="ctk" name="ctk" onclick="Cetak()" style="cursor:pointer"><img src="../icon/printer.png" style="vertical-align:middle" />&nbsp;&nbsp;Cetak</button>
<button type="button" id="ttp" name="ttp" onclick="window.close()" style="cursor:pointer"><img src="../icon/del.gif" width="20" height="20" style="vertical-align:middle" />&nbsp;&nbsp;Tutup</button>
<table width="1287" align="center" border="0" cellpadding="1" cellspacing="0">
<tr>
	<td align="center" style="font-size:large">KARTU INVENTARIS BARANG (KIB)<br />
    GEDUNG &amp; BANGUNAN </td>
</tr>
<tr>
	<td align="center">&nbsp;</td>
</tr>
<table border="0" width="1287" align="center" >
<tr>
	<td>No. Kode Lokasi</td>
    <td>:</td>
	<td><?php echo $t['kodedepartemen'];?></td>
</tr>
<tr>
	<td width="10%">Nama Unit</td>
	<td width="1%">:</td>
	<td><?php echo $t['namadepartemen'];?></td>
</tr>
</table>
<tr>
	<td align="center">&nbsp;</td>
</tr>

</table>
<table width="1287" align="center" cellpadding="0" cellspacing="0">
<tr>
	<td width="33" rowspan="2" align="center" class="judulheaderkiri">No Urut</td>
	<td width="123" rowspan="2" align="center" class="isiheader">Jenis Barang/Nama Barang</td>
	<td colspan="2" align="center" class="isiheader">Nomor</td>
	<td width="76" rowspan="2" align="center" class="isiheader">Kondisi Bangunan (B, KB, RB)</td>
	<td colspan="2" align="center" class="isiheader">Kontruksi Bangunan</td>
	<td width="59" rowspan="2" align="center" class="isiheader">Luas Lantai (M2)</td>
	<td width="151" rowspan="2" align="center" class="isiheader">Letak/Lokasi Alamat</td>
	<td colspan="2" align="center" class="isiheader">Dokumen Gedung</td>
	<td width="67" rowspan="2" align="center" class="isiheader">Luas(M2)</td>
	<td width="85" rowspan="2" align="center" class="isiheader">Status Tanah</td>
	<td width="70" rowspan="2" align="center" class="isiheader">Nomor Kode Tanah</td>
	<td width="65" rowspan="2" align="center" class="isiheader">Asal Usul</td>
	<td width="167" rowspan="2" align="center" class="isiheader">Nilai Awal (Rp)</td>
	<td colspan="2" align="center" class="isiheader">Mutasi Perubahan</td>
	
	<td width="200" rowspan="2" align="center" class="isiheader">Nilai Akhir (Rp)</td>
	<td width="96" rowspan="2" align="center" class="isiheader">Keterangan</td>
</tr>
<tr>
	<td width="49" align="center" class="subisiheader">Kode Nomor</td>
	<td width="60" align="center" class="subisiheader">Register</td>
	<td width="67" align="center" class="subisiheader">Bertingkat Tidak</td>
	<td width="62" align="center" class="subisiheader">Beton Tidak</td>
	<td width="74" align="center" class="subisiheader">Tanggal</td>
	<td width="57" align="center" class="subisiheader">Nomor</td>
	
	<td width="51" align="center" class="subisiheader">Pengurangan (Rp)</td>
	<td width="63" align="center" class="subisiheader">Penambahan (Rp)</td>
</tr>
<tr>
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
	<td align="center" class="isi">13</td>
	<td align="center" class="isi">14</td>
	<td align="center" class="isi">15</td>
	<td align="center" class="isi">16</td>
	<td align="center" class="isi">17</td>
	<td align="center" class="isi">18</td>
	<td align="center" class="isi">19</td>
	<td align="center" class="isi">20</td>
</tr>
<?php 
	$i=1;
  $sqlselect="SELECT
  s.idseri,
  s.ms_idunit,
  u.kodeunit,
  u.namaunit,
  s.noseri,
  s.kondisi,
  k.alamat,
  k.bertingkat,
  k.beton,
  k.status_hak,
  k.luas_lantai,
  k.dok_no,
  k.luas_tanah,
  k.kode_tanah,
  s.asalusul,
  b.idbarang,
  s.ms_idlokasi,
  k.dok_tgl,
  k.ket,
  b.kodebarang,
  s.harga_perolehan,s.nilaibuku,
  b.namabarang
FROM as_seri2 s
  INNER JOIN kib03 k
    ON s.idseri = k.idseri
  INNER JOIN as_ms_barang b
    ON s.idbarang = b.idbarang
  LEFT JOIN as_ms_unit u
    ON s.ms_idunit = u.idunit
  LEFT JOIN as_lokasi l
    ON s.ms_idlokasi = l.idlokasi
WHERE LEFT(b.kodebarang,2) = '03'
    and b.tipe=1 AND s.isaktif = 1";
	$rs=mysql_query($sqlselect);
	while($row=mysql_fetch_array($rs)){
	
	$hrg = mysql_query("select awal_nilai from tutup_buku where barang_id='".$row['idbarang']."' and bln='12' and thn='".($tgl11[2]-1)."'");
	$ada = mysql_num_rows($hrg);
	$tmp = mysql_fetch_array($hrg);
	if($ada>0){
		$hargaAwal = $tmp[0];
	}else{
		$hargaAwal = 0;
	}
		$hargaAkhir = $row['nilaibuku'];
	?>
<tr>
	<td align="center" class="isikiri"><?php echo $i ?></td>
	<td  class="isi"><?php echo $row['namabarang'] ?></td>
	<td align="center" class="isi"><?php echo $row['kodebarang'] ?></td>
	<td align="center" class="isi"><?php echo $row['noseri'] ?></td>
	<td align="center" class="isi"><?php echo $row['kondisi'] ?></td>
	<td align="center" class="isi"><?php echo $row['bertingkat'] ?></td>
	<td align="center" class="isi"><?php echo $row['beton'] ?></td>
	<td align="center" class="isi"><?php echo $row['luas_lantai'] ?></td>
	<td class="isi"><?php echo $row['alamat'] ?></td>
	<td align="center" class="isi"><?php echo $row['dok_tgl'] ?></td>
	<td align="center" class="isi"><?php echo $row['dok_no'] ?></td>
	<td align="center" class="isi"><?php echo $row['luas_tanah'] ?></td>
	<td align="center" class="isi"><?php echo $row['status_hak'] ?></td>
	<td align="center" class="isi"><?php echo $row['kode_tanah'] ?></td>
	<td align="center" class="isi"><?php echo $row['asalusul'] ?></td>
	<td align="right" class="isi"><?php echo number_format($hargaAwal,0,',','.'); ?></td>
	<td align="right" class="isi"><?php if($hargaAwal>$hargaAkhir) echo number_format($hargaAkhir-$hargaAwal,0,'.','.'); else echo '0'; ?></td>
	<td align="right" class="isi"><?php if($hargaAwal<$hargaAkhir) echo number_format($hargaAkhir-$hargaAwal,0,'.','.'); else echo '0'; ?></td>
	<td align="right" class="isi"><?php echo number_format($hargaAkhir,0,',','.'); ?></td>
	<td align="center" class="isi"><?php echo $row['ket'] ?></td>
</tr>
<?php 
$i++;
}
?>
</table>
<table width="1287" align="center" border="0">
<tr>
	<td colspan="8"><br /></td>
</tr>
<tr>
	<td width="45" colspan="">&nbsp;</td>
	<td width="180" colspan="" align="center">Mengetahui</td>
	<td width="80" colspan="">&nbsp;</td>
	<td width="180" align="center" style="">&nbsp;</td>
	<td width="126" align="center"><?=$kotaRS;?>, <?php echo indonesian_date(); ?></td>
	<td width="129">&nbsp;</td>
</tr>
<tr>
	<td width="45" colspan="">&nbsp;</td>
	<td width="180" colspan="" align="center">DIEKTUR RSUD</td>
	<td width="80" colspan="">&nbsp;</td>
	<td width="180" align="center" style="text-decoration:underline">&nbsp;</td>
	<td width="126" align="center">PENGURUS BARANG</td>
	<td width="129">&nbsp;</td>
</tr>
<tr>
	<td width="45" colspan="">&nbsp;</td>
	<td width="180" colspan="" align="center"><?=$tipe_kotaRS;?> <?=$kotaRS;?></td>
	<td width="80" colspan=""></td>
	<td width="180" align="center">&nbsp;</td>
	<td width="126">&nbsp;</td>
	<td width="129">&nbsp;</td>
</tr>
<tr>
	<td colspan="8"><p>&nbsp;</p>
    <p>&nbsp;</p></td>
</tr>
<?php 
$sqldirek=mysql_query("select dir_nama, dir_nip from as_setting");
$r=mysql_fetch_array($sqldirek);
?>
<tr>
	<td width="45" align="center" style="text-decoration:underline"></td>
	<td width="45" colspan="" align="center"><?php echo $t['dir_nama']; ?></td>
	<td width="180" colspan="">&nbsp;</td>
	<td width="80" colspan="" align="center"></td>
	<td width="126" align="center"><?php echo $t['pengurus_nama']; ?></td>
	<td width="129">&nbsp;</td>
</tr>

<tr>
	<td width="45" colspan=""></td>
	<td width="180" colspan="" align="center" style="text-decoration: overline;">NIP. <?php echo $t['dir_nip']; ?></td></td>
	<td width="80" colspan="">&nbsp;</td>
	<td width="180" align="center" ></td>
	<td width="126" align="center" style="text-decoration: overline;">NIP. <?php echo $t['pengurus_nip']; ?></td></td>
	<td width="129">&nbsp;</td></tr></table>
</body>
</html>
