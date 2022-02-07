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
    header('Content-Disposition: attachment; filename="Laporan_kib_jalan'.$_POST['fname'].'.xls"');
   }else if(($_REQUEST['jenislap'])=='WORD'){
       header('Content-type: application/msword');
    header('Content-Disposition: attachment; filename="Laporan_kib_jalan'.$_POST['fname'].'.doc"');
    
}
include '../koneksi/konek.php';  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../theme/report.css" rel="stylesheet" type="text/css" />
<title>.: Laporan KIB JALAN :.</title>
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

<table width="1156" align="center" border="0" cellpadding="1" cellspacing="0">
<tr>
	<td align="center" style="font-size:large">KARTU INVENTARIS BARANG (KIB)<br />
    JALAN,IRIGASI DAN JARINGAN</td>
</tr>

<tr>
	<td>&nbsp;</td>
</tr>

</table>
<table align="center">
<tr>
<td>
<table width="45%">
<tr>
	<?php 
$sqldirek=mysql_query("select * from as_setting");
$r=mysql_fetch_array($sqldirek);
?>
	<td>No. Kode Lokasi</td>
    <td>:</td>
	<td width="76%"><?php echo $r['kodedepartemen']?></td>
</tr>
<tr>
<td width="22%">Nama Unit</td>
<td width="2%">:</td>
<td><?php  echo $r['namadepartemen']?></td>
</tr>

<tr>
	<td>&nbsp;</td>
</tr>
</table>
<table width="1156" align="center" cellpadding="0" cellspacing="0">
<tr>
	<td width="34" rowspan="3" align="center" class="judulheaderkiri">No Urut</td>
	<td width="167" rowspan="3" align="center" class="isiheader">Jenis Barang / Nama Barang</td>
</tr>
<tr>
	<td colspan="2" align="center" class="isiheader">Nomor</td>
	<td width="66" rowspan="2" align="center" class="isiheader">Konstruksi</td>
	<td width="52" rowspan="2" align="center" class="isiheader">Panjang (KM)</td>
	<td width="40" rowspan="2" align="center" class="isiheader">Lebar (M)</td>
	<td width="51" rowspan="2" align="center" class="isiheader">Luas (M2)</td>
	<td colspan="2" align="center" class="isiheader">Dokumen</td>
	<td width="81" rowspan="2" align="center" class="isiheader">Status Tanah</td>
	<td width="79" rowspan="2" align="center" class="isiheader">Nomor Kode Tanah</td>
	<td width="109" rowspan="2" align="center" class="isiheader">Asal - Usul</td>
	<td width="77" rowspan="2" align="center" class="isiheader">Nilai Awal</td>
	<td rowspan="1" colspan="2" align="center" class="isiheader">Mutasi / Perubahan</td>
	<td width="89"  rowspan="2" align="center" class="isiheader">Nilai Akhir</td>
	<td width="116" rowspan="2" align="center" class="isiheader">Kondisi (B, KB, RB)</td>
</tr>
<tr>
	<td width="51" align="center" class="subisiheader">Kode Barang</td>
	<td width="63" align="center" class="subisiheader">Register</td>
	<td width="76" align="center" class="subisiheader">Tanggal</td>
	<td width="62" align="center" class="subisiheader">Nomor</td>
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
	<td align="center" class="isi">14</td>
	<td align="center" class="isi">15</td>
	<td align="center" class="isi">16</td>
	<td align="center" class="isi">17</td>
	<td align="center" class="isi">18</td>
</tr>
	<?php 
	$i=1;
	$sqlselect="SELECT s.idseri,namabarang,kodebarang,ms_idunit,kodeunit,namaunit,ms_idlokasi,s.idbarang,noseri,s.asalusul,s.harga_perolehan,kode_tanah,panjang,lebar,k.luas,alamat,konstruksi,dok_tgl,dok_no,kondisi,ket,status_tanah FROM as_seri2 s
  LEFT JOIN kib04 k
    ON s.idseri = k.idseri
  INNER JOIN as_ms_barang b
    ON s.idbarang = b.idbarang
  LEFT JOIN as_lokasi l
    ON s.ms_idlokasi = l.idlokasi
  LEFT JOIN as_ms_unit u
    ON s.ms_idunit = u.idunit
   WHERE LEFT(b.kodebarang,2) = '04' and b.tipe=1 AND s.isaktif = 1";
	$rs=mysql_query($sqlselect);
	while($row=mysql_fetch_array($rs)){
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
<td align="center" class="isikiri"><?php echo $i ?></td>
	<td class="isi"><?php echo $row['namabarang'] ?></td>
	<td align="center" class="isi"><?php echo $row['kodebarang'] ?></td>
	<td align="center" class="isi"><?php echo $row['noseri'] ?></td>
	<td align="center" class="isi"><?php echo $row['konstruksi'] ?></td>
	<td align="center" class="isi"><?php echo $row['panjang'] ?></td>
	<td align="center" class="isi"><?php echo $row['lebar'] ?></td>
	<td align="center" class="isi"><?php echo $row['luas'] ?></td>
	<td align="center" class="isi"><?php echo $row['dok_tgl'] ?></td>
	<td align="center" class="isi"><?php echo $row['dok_no'] ?></td>
	<td align="center" class="isi"><?php echo $row['status_tanah'] ?></td>
	<td align="center" class="isi"><?php echo $row['kode_tanah'] ?></td>
	<td align="center" class="isi"><?php echo $row['asalusul'] ?></td>
	<td align="center" class="isi"><?php echo number_format($hrgAwal,0,',','.') ?></td>
	<td align="center" class="isi"><?php if($hargaAwal>$hargaAkhir) echo number_format($hargaAkhir-$hargaAwal,0,',','.');else echo '0'; ?></td>
	<td align="center" class="isi"><?php if($hargaAwal<$hargaAkhir) echo number_format($hargaAkhir-$hargaAwal,0,',','.');else echo '0';?></td>
	<td align="center" class="isi"><?php echo number_format($hargaAkhir,0,',','.'); ?></td>
	<td align="center" class="isi"><?php echo $row['kondisi'] ?></td>
</tr>
<?php 
$i++;
}
?>
<tr>
	<td colspan="13" class="isikiri" align="center" style="font:17px bold;">Total</td>
	<td align="center" class="isi"><?php echo number_format($ttl,0,',','.')  ?></td>
	<td class="isi">&nbsp;</td>
	<td class="isi">&nbsp;</td>
	<td class="isi" align="center"><?php echo number_format($ttlAkhir,0,',','.') ?></td>
	<td class="isi">&nbsp;</td>
</tr>
</table>
</td>
</tr>
</table>
<table width="1156" align="center">
<tr>
	<td colspan="4"><br /></td>
</tr>
<tr>
	<td width="845">&nbsp;</td>
	<td width="180" align="center" style="text-decoration:underline"><strong><?=$kotaRS;?>, <?php echo indonesian_date(); ?></strong></td>
	<td width="126">&nbsp;</td>
	<td width="129">&nbsp;</td>
</tr>
<tr>
	<td width="845">&nbsp;</td>
	<td width="180" align="center"><strong>Direktur</strong></td>
	<td width="126">&nbsp;</td>
	<td width="129">&nbsp;</td>
</tr>
<tr>
	<td colspan="4"><p>&nbsp;</p>
    <p>&nbsp;</p></td>
</tr>
<?php 
$sqldirek=mysql_query("select dir_nama, dir_nip from as_setting");
$r=mysql_fetch_array($sqldirek);
?>
<tr>
	<td width="845">&nbsp;</td>
	<td width="180" align="center"  style="text-decoration:underline; vertical-align:top"><?php echo $r['dir_nama'] ?></td>
	<td width="126">&nbsp;</td>
	<td width="129">&nbsp;</td>
</tr>

<tr>
	<td width="845">&nbsp;</td>
	<td width="180" align="center">NIP.
<?php echo $r['dir_nip'] ?></td>
	<td width="126">&nbsp;</td>
	<td width="129">&nbsp;</td>
</tr></table>
</body>
</html>
