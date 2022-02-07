<?php 
include '../sesi.php';
include '../koneksi/konek.php'; 
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
    header('Content-Disposition: attachment; filename="Laporan_aset_tetap'.$_POST['fname'].'.xls"');
   }else if(($_REQUEST['jenislap'])=='WORD'){
       header('Content-type: application/msword');
    header('Content-Disposition: attachment; filename="Laporan_aset_tetap'.$_POST['fname'].'.doc"');
    
}
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../theme/report.css" rel="stylesheet" type="text/css" />
<title>.: Laporan ASET TETAP LAINYA :.</title>
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
<table width="1156" align="center" cellpadding="0" cellspacing="0">
<tr>
	<td align="center" style="font-size:large">KARTU INVENTARIS BARANG (KIB) E<br />
    ASET TETAP LAINYA</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
</table>
<table align="center">
<tr>
<td>
<table width="46%">
<tr>
	<?php 
$sqldirek=mysql_query("select * from as_setting");
$r=mysql_fetch_array($sqldirek);
?>
	<td>No. Kode Lokasi</td>
    <td>:</td>
	<td width="75%"><?php echo $r['kodedepartemen']?></td>
</tr>
<tr>
	<td width="22%">Nama Unit</td>
	<td width="3%">:</td>
	<td><?php  echo $r['namadepartemen']?></td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
</table>


<table width="1156" align="center" border="1" cellpadding="1" cellspacing="0">
<tr style="background-color:white">
	<td width="34" rowspan="3" align="center" class="judulheaderkiri">No Urut</td>
	<td width="167" rowspan="3" align="center" class="isiheader">Jenis Barang / Nama Barang</td>
</tr>
<tr style="background-color:white">
	<td colspan="2" align="center" class="isiheader">Nomor</td>
	<td colspan="2" align="center" class="isiheader">Buku/Perpustakaan</td>
	<td colspan="3" align="center" class="isiheader">Barang Bercorak Kesenian/Budaya</td>
	<td colspan="2" align="center" class="isiheader">Hewan/Ternak dan Tumbuhan</td>
	<td rowspan="2" align="center" class="isiheader">Jumlah</td>
	<td rowspan="2" align="center" class="isiheader">Tahun Cetak/Pembalian</td>
	<td rowspan="2" align="center" class="isiheader">Asal Usul Cara Perolehan</td>
	<td rowspan="2" align="center" class="isiheader">Nilai Awal (Rp)</td>
	<td colspan="2" align="center" class="isiheader">MUTASI/PERUBAHAN</td>
	<td rowspan="2" align="center" class="isiheader">Nilai Akhir (Rp)</td>
	<td rowspan="2" align="center" class="isiheader">Ket</td>
</tr>
<tr style="background-color:white">
	<td width="51" align="center" class="subisiheader">Kode Barang</td>
	<td width="63" align="center" class="subisiheader">Register</td>
	<td width="63" align="center" class="subisiheader">Judul/Pencipta</td>
	<td width="62" align="center" class="subisiheader">Spesifikasi</td>
	<td width="63" align="center" class="subisiheader">Asal Daerah</td>
	<td width="76" align="center" class="subisiheader">Pencipta</td>
	<td width="62" align="center" class="subisiheader">Bahan</td>
	<td width="76" align="center" class="subisiheader">Jenis</td>
	<td width="62" align="center" class="subisiheader">Ukuran</td>
	<td width="62" align="center" class="subisiheader">Berkurang (Rp)</td>
	<td width="62" align="center" class="subisiheader">Bertambah (Rp)</td>
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
	<td align="center" class="isi">13</td>
	<td align="center" class="isi">14</td>
	<td align="center" class="isi">15</td>
	<td align="center" class="isi">16</td>
	<td align="center" class="isi">17</td>
	<td align="center" class="isi">18</td>
	<td align="center" class="isi">19</td>
</tr>
	<?php 
	$kdunit = $_REQUEST['kdunit'];
	$i=1;
	$jdlbk = "-";
	$spek = "-";
	$asldaerah = "-";
	$pecipta = "-";
	$bahan = "-";
	$jenis = "-";
	$ukuran = "-";
	$jumlah = "-";
	$thn = "-";
	$asl = "-";
	$harga = "-";
	$ket ="-";
	$query = "SELECT *
FROM (SELECT buku_judul,t.thn_pengadaan,l.namalokasi,l.kodelokasi,l.idlokasi,u.idunit,u.namaunit,t.harga_perolehan, buku_pengarang, buku_spek, seni_asal, seni_pencipta, seni_bahan, jenis, ukuran,t.noseri, t.idseri, b.kodebarang,b.namabarang, u.kodeunit
FROM kib05 k
INNER JOIN as_seri2 t ON t.idseri = k.idseri
INNER JOIN as_ms_barang b ON b.idbarang = t.idbarang
INNER JOIN as_ms_unit u ON u.idunit = t.ms_idunit
LEFT JOIN as_lokasi l ON l.idlokasi = t.ms_idlokasi
WHERE LEFT( b.kodebarang, 2 ) = '05' and b.tipe=1 AND t.isaktif = 1 
) AS q1";
$rs = mysql_query($query);
                           
	while($row=mysql_fetch_array($rs)){
	$jdlbk = $row["buku_judul"];
	$spek = $row["buku_spek"];
	$asldaerah = $row["seni_asal"];
	$pecipta = $row["seni_pencipta"];
	$bahan = $row["seni_bahan"];
	$jenis = $row["jenis"];
	$ukuran = $row["ukuran"];
	$jumlah = "-";
	$thn = $row["thn_pengadaan"];
	$asl = $row["asalusul"];
	$harga = $row["harga_perolehan"];
	$ket =$row["ket"];
	$hrg = mysql_query("select awal_nilai from tutup_buku where barang_id='".$row['idbarang']."' AND bln='12' and thn='".($tgl11[2]-1)."'");
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
	<td class="isi"><?php echo $row['namabarang'] ?></td>
	<td align="center" class="isi"><?php echo $row['kodebarang'] ?></td>
	<td align="center" class="isi"><?php echo $row['noseri'] ?></td>
	<td align="center" class="isi"><?php echo $jdlbk; ?></td>
	<td align="center" class="isi"><?php echo $spek; ?></td>
	<td align="center" class="isi"><?php echo $asldaerah; ?></td>
	<td align="center" class="isi"><?php echo $pecipta; ?></td>
	<td align="center" class="isi"><?php echo $bahan; ?></td>
	<td align="center" class="isi"><?php echo $jenis; ?></td>
	<td align="center" class="isi"><?php echo $ukuran; ?></td>
	<td align="center" class="isi"><?php echo $jumlah; ?></td>
	<td align="center" class="isi"><?php echo $thn; ?></td>
	<td align="center" class="isi"><?php echo $asl; ?></td>
	<td align="right" class="isi"><?php echo number_format($hargaAwal,0,',','.'); ?></td>
	<td align="right" class="isi"><?php if($hargaAwal>$hargaAkhir) echo number_format($hargaAkhir-$hargaAwal,0,'.','.'); else echo '0'; ?></td>
	<td align="right" class="isi"><?php if($hargaAwal<$hargaAkhir) echo number_format($hargaAkhir-$hargaAwal,0,'.','.'); else echo '0'; ?></td>
	<td align="right" class="isi"><?php echo number_format($hargaAkhir,0,',','.'); ?></td>
	<td align="center" class="isi"><?php echo $ket; ?></td>
</tr>
<?php 
$i++;
}
?>
</table>
</td>
</tr>
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
$sqldirek=mysql_query("select * from as_setting");
$t=mysql_fetch_array($sqldirek);
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
