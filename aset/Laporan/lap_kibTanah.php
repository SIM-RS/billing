<?php 
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
include("../koneksi/konek.php");
if(($_REQUEST['jenislap'])=='XLS'){
     header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="Laporan_kibTanah'.$_POST['fname'].'.xls"');
  }else if(($_REQUEST['jenislap'])=='WORD'){
    header('Content-type: application/msword');
    header('Content-Disposition: attachment; filename="Laporan_kibTanah'.$_POST['fname'].'.doc"');
    
}
$r_formatlap = $_REQUEST['jenislap'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php if($r_formatlap != 'XLS' && $r_formatlap != 'WORD'){ ?>
<link href="../theme/report.css" rel="stylesheet" type="text/css" />
<?php } ?>
<title>.: Laporan KIB TANAH :.</title>
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
<?php if($r_formatlap != 'XLS' && $r_formatlap != 'WORD'){ ?>
<button type="button" id="ctk" name="ctk" onclick="Cetak()" style="cursor:pointer" ><img src="../icon/printer.png" style="vertical-align:middle" />&nbsp;&nbsp;Cetak</button>
<button type="button" id="ttp" name="ttp" onclick="window.close()" style="cursor:pointer"><img src="../icon/del.gif" width="20" height="20" style="vertical-align:middle" />&nbsp;&nbsp;Tutup</button>
<?php } ?>
<table width="1300" align="center" cellpadding="0" cellspacing="0">
<tr>
	<td align="center" colspan="14" style="font:large bold"><strong>KARTU INVENTARIS BARANG (KIB)<br />
	  A. TANAH </strong></td>
</tr>
<tr>
	<td align="center">&nbsp;</td>
</tr>
<table border="0"  width="1287" align="center">
<tr>
<?php 
$sqldirek=mysql_query("select * from as_setting");
$r=mysql_fetch_array($sqldirek);
?>
	<td>No. Kode Lokasi</td>
    <td>:</td>
	<td><?php echo $r['kodedepartemen']?></td>
</tr>
<tr>
<td width="9%">Nama Unit</td>
<td width="1%">:</td>
<td><?php  echo $r['namadepartemen']?></td>
</tr>
</table>
<tr>
	<td colspan="14">&nbsp;</td>
</tr>
<br />
</table>
<table width="1300" align="center" border="1" cellpadding="1" cellspacing="0">
<tr>
	<td width="23" rowspan="3" align="center" class="judulheaderkiri">No</td>
	<td width="112" rowspan="3" align="center" class="isiheader">Jenis Barang/Nama Barang</td>
	<td colspan="2" align="center" class="isiheader">Nomor</td>
	<td width="41" rowspan="3" align="center" class="isiheader">Luas (M2)</td>
	<td width="66" rowspan="3" align="center" class="isiheader">Tahun Pengadaan</td>
	<td width="88" rowspan="3" align="center" class="isiheader">Letak / Alamat</td>
	<td align="center" colspan="3" class="isiheader">Status Tanah</td>
	<td width="88" rowspan="3" align="center" class="isiheader">Penggunaan</td>
	<td width="56" rowspan="3" align="center" class="isiheader">Asal Usul</td>
	<td width="61" rowspan="3"align="center" class="isiheader">Nilai Awal</td>
	<td rowspan="2" colspan="2" align="center" class="isiheader">Mutasi / Perubahan</td>
	<td width="89"  rowspan="3" align="center" class="isiheader">Nilai Akhir</td>
	<td width="172" rowspan="3" align="center" class="isiheader">Keterangan</td>
</tr>
<tr>
	<td width="53" rowspan="2" align="center" class="subisiheader">Kode Barang</td>
	<td width="60" rowspan="2" align="center" class="subisiheader">Register</td>
	<td width="42" rowspan="2" align="center" class="subisiheader">Hak</td>
	<td align="center" colspan="2" class="subisiheader">Sertifikat</td>
</tr>
<tr>
	<td width="65" align="center" class="subisiheader">Tanggal</td>
	<td width="67" align="center" class="subisiheader">Nomor</td>
	<td width="73" align="center" class="subisiheader">Berkurang (Rp)</td>
	<td width="74" align="center" class="subisiheader">Bertambah (Rp)</td>
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
	<td align="center" class="isi">&nbsp;</td>
	<td align="center" class="isi">&nbsp;</td>
	<td align="center" class="isi">14</td>
	<td align="center" class="isi">15</td>
	
</tr>
<?php 
$date=date('d-m-Y');
$thn=explode("-",$date);
$i=1;
if($_REQUEST['kondisi'] != '' && $_REQUEST['kondisi'] != 'ALL'){
	$kondisi = " AND kondisi = '".$_REQUEST['kondisi']."'";
}
	
 $sql ="SELECT s.idseri,u.kodeunit,u.namaunit,s.ms_idunit,s.nilaibuku,s.ms_idlokasi,s.asalusul,s.harga_perolehan,s.idbarang,b.kodebarang,b.namabarang,s.noseri,l.namalokasi,k.alamat,k.luas,k.hak_tanah,k.sertifikat_tgl,k.sertifikat_no,k.penggunaan,s.thn_pengadaan,k.ket
		FROM as_seri2 s INNER JOIN as_ms_barang b ON s.idbarang = b.idbarang
		  LEFT JOIN as_ms_unit u ON s.ms_idunit = u.idunit
		  LEFT JOIN as_lokasi l ON s.ms_idlokasi = l.idlokasi
		  INNER JOIN kib01 k ON s.idseri = k.idseri
		WHERE b.tipe=1 {$kondisi} and LEFT(b.kodebarang,2) = '01' AND s.isaktif = 1";

		$rs=mysql_query($sql);
while($row=mysql_fetch_array($rs)){
$hak=array('HPK'=>'Hak Pakai', 'HPH'=>'Hak Pengelolahan');

$sqlSaldo="select * from tutup_buku where bln='12' and thn='".($thn[2]-1)."'" ;
$rsHrg=mysql_query($sqlSaldo);
$rows=mysql_fetch_array($rsHrg);
$ttl+=$row['awal_nilai'];

$cekHrg=mysql_num_rows($rsHrg);

if($cekHrg >0){
	 $hrgAwal=$rows['awal_nilai'];
}else{
	 $hrgAwal=0;
}
$hargaAkhir=$row['nilaibuku'];
$ttlAkhir+=$hargaAkhir;
?>
<tr>
	<td align="center" class="isikiri"><?php echo $i;     ?></td>
	<td class="isi"><?php echo $row['namabarang'] ?></td>
	<td align="center" class="isi"><?php echo $row['kodebarang'] ?></td>
	<td align="center" class="isi"><?php echo $row['noseri'] ?></td>
	<td align="center" class="isi"><?php echo $row['luas'] ?></td>
	<td align="center" class="isi"><?php echo $row['thn_pengadaan'] ?></td>
	<td class="isi"><?php echo $row['alamat'] ?></td>
	<td align="center" class="isi"><?php echo $hak[$row['hak_tanah']] ?></td>
	<td align="center" class="isi"><?php echo $row['sertifikat_tgl'] ?></td>
	<td align="center" class="isi"><?php echo $row['sertifikat_no'] ?></td>
	<td align="center" class="isi"><?php echo $row['penggunaan'] ?></td>
	<td align="center" class="isi"><?php echo $row['asalusul'] ?></td>
	<td align="center" class="isi"><?php echo number_format($hargaAwal,0,',','.'); ?></td>
	<td align="center" class="isi"><?php  if($hargaAwal>$hargaAkhir) echo number_format($hargaAkhir-$hargaAwal,0,',','.');else echo '0';?></td>
	<td align="center" class="isi"><?php  if($hargaAwal<$hargaAkhir) echo number_format($hargaAkhir-$hargaAwal,0,',','.');else echo '0';?></td>
	<td align="center" class="isi"><?php echo number_format($hargaAkhir,0,',','.'); ?></td>
	<td align="center" class="isi"><?php echo $row['ket'] ?></td>
</tr>
<?php 

$i++;
}
?>
<tr>
	<td colspan="12" class="isikiri" align="center" style="font:17px bold;">Total</td>
	<td align="center" class="isi"><?php echo number_format($ttl,0,',','.')  ?></td>
	<td class="isi">&nbsp;</td>
	<td class="isi">&nbsp;</td>
	<td class="isi" align="center"><?php echo number_format($ttlAkhir,0,',','.') ?></td>
	<td class="isi">&nbsp;</td>
</tr>
</table>
<table width="1300" align="center">
<tr>
	<td colspan="4"><br /></td>
</tr>
<tr>
	<td width="44">&nbsp;</td>
	<td width="228" align="center"><strong>Mengetahui,</strong></td>
	<td width="761">&nbsp;</td>
	<td width="247" align="center"><strong>Sidoarjo, <?php echo indonesian_date(); ?></strong></td>
</tr>
<tr>
	<td width="44">&nbsp;</td>
	<td width="228"align="center"><strong>DIREKTUR RSUD </strong></td>
	<td width="761">&nbsp;</td>
	<td width="247" align="center"><strong>Pengurus Barang</strong></td>
</tr>
<tr>
	<td >&nbsp;</td>
	<td align="center"><strong>KABUPATEN SIDOARJO </strong></td>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td colspan="4"><p>&nbsp;</p>
    <p>&nbsp;</p></td>
</tr>
<?php 
$sqldirek=mysql_query("select * from as_setting");
$r=mysql_fetch_array($sqldirek);
?>
<tr>
	<td width="44">&nbsp;</td>
	<td width="228" align="center"><strong><?php echo $r['dir_nama'] ?></strong></td>
	<td width="761">&nbsp;</td>
	<td width="247" align="center"><strong><?php echo $r['pengurus_nama'] ?></strong></td>
</tr>

<tr>
	<td width="44">&nbsp;</td>
	<td width="228" align="center" style="text-decoration: overline;"><strong>NIP.
    <?php echo $r['dir_nip'] ?></strong></td>
	<td width="761">&nbsp;</td>
	<td width="247" align="center" style="text-decoration: overline;"><strong>NIP.
    <?php echo $r['pengurus_nip'] ?></strong></td>
</tr>
</table>
</body>
</html>
