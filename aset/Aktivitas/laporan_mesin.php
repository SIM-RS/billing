<?php 
include '../sesi.php';
include '../koneksi/konek.php'; 
if(($_REQUEST['jenislap'])=='XLS'){
    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="Laporan_Mesin'.$_POST['fname'].'.xls"');
  }else if(($_REQUEST['jenislap'])=='WORD'){
    header('Content-type: application/msword');
    header('Content-Disposition: attachment; filename="Laporan_Mesin'.$_POST['fname'].'.doc"');
    
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
<title>.: Laporan KIB 02 PERALATAN & MESIN:.</title>
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

<table align="center" border="0" cellpadding="1" cellspacing="0" width="100%">
<tr>
	<td align="center" style="font-size:large">KARTU INVENTARIS BARANG (KIB) B<br />
    PERALATAN DAN MESIN</td>
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
	<td width="34" rowspan="2" align="center" class="judulheaderkiri">No Urut</td>
	<td width="167" rowspan="2" align="center" class="isiheader">Kode Barang</td>
	<td width="167" rowspan="2" align="center" class="isiheader">Jenis Barang / Nama Barang</td>
	<td width="167" rowspan="2" align="center" class="isiheader">No Register</td>
	<td width="167" rowspan="2" align="center" class="isiheader">Merk/Type</td>
	<td width="167" rowspan="2" align="center" class="isiheader">Ukuran/CC</td>
	<td width="167" rowspan="2" align="center" class="isiheader">Bahan</td>
	<td width="167" rowspan="2" align="center" class="isiheader">Tahun Pembelian</td>

	<td colspan="5" align="center" class="isiheader">Nomor</td>
	<td width="167" rowspan="2" align="center" class="isiheader">Asal Usul Cara Perolehan</td>
	<td width="167" rowspan="2" align="center" class="isiheader">Nilai Awal (Rp)</td>
	<td colspan="2" align="center" class="isiheader">Mutasi Perubahan</td>
	
	<td width="200" rowspan="2" align="center" class="isiheader">Nilai Akhir (Rp)</td>
	<td width="167" rowspan="2" align="center" class="isiheader">Keterangan</td>
</tr>
<tr style="background-color:white">
	<td width="51" align="center" class="subisiheader">Pabrik</td>
	<td width="63" align="center" class="subisiheader">Rangka</td>
	<td width="63" align="center" class="subisiheader">Mesin</td>
	<td width="62" align="center" class="subisiheader">Polisi</td>
	<td width="63" align="center" class="subisiheader">BPKB</td>
	
	<td width="51" align="center" class="subisiheader">Pengurangan (Rp)</td>
	<td width="63" align="center" class="subisiheader">Penambahan (Rp)</td>
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
	$merk = "-";
	$ukuran = "-";
	$bahan = "-";
	$thn = "-";
	$pabrik = "-";
	$rangka = "-";
	$mesin = "-";
	$polisi = "-";
	$bpkb = "-";
	$asal = "-";
	$harga = "-";
	$ket ="-";
	/*$query = "SELECT * FROM as_seri2 seri
                    INNER JOIN as_ms_unit unit ON seri.ms_idunit = unit.idunit
                    INNER JOIN as_ms_barang barang ON seri.idbarang = barang.idbarang
                    INNER JOIN kib02 kib ON seri.idseri = kib.idseri where tipe = 1 and kodebarang like '02%'";*/
	
	$query = "SELECT * FROM as_seri2 seri
                    INNER JOIN as_ms_barang barang ON seri.idbarang = barang.idbarang
                    INNER JOIN kib02 kib ON seri.idseri = kib.idseri where tipe = 1 and kodebarang like '02%'
					ORDER BY barang.kodebarang,seri.noseri";
                            $rs = mysql_query($query);
                            
	while($row=mysql_fetch_array($rs)){
	$merk = $row["merk"];
	$ukuran = $row["ukuran"];
	$bahan = $row["bahan"];
	$thn = $row["thn_pengadaan"];
	$pabrik = $row["no_pabrik"];
	$rangka = $row["no_rangka"];
	$mesin = $row["no_mesin"];
	$polisi = $row["no_polisi"];
	$bpkb = $row["no_bpkb"];
	$asal = $row["asalusul"];
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
	<td class="isi"><?php echo $row['kodebarang'] ?></td>
	<td align="center" class="isi"><?php echo $row['namabarang'] ?></td>
	<td align="center" class="isi"><?php echo str_pad($row['noseri'],4,'0', STR_PAD_LEFT); ?></td>
	<td align="center" class="isi"><?php echo $merk; ?></td>
	<td align="center" class="isi"><?php echo $ukuran; ?></td>
	<td align="center" class="isi"><?php echo $bahan; ?></td>
	<td align="center" class="isi"><?php echo $thn; ?></td>
	<td align="center" class="isi"><?php echo $pabrik; ?></td>
	<td align="center" class="isi"><?php echo $rangka; ?></td>
	<td align="center" class="isi"><?php echo $mesin; ?></td>
	<td align="center" class="isi"><?php echo $polisi; ?></td>
	<td align="center" class="isi"><?php echo $bpkb; ?></td>
	<td align="center" class="isi"><?php echo $asal; ?></td>
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
<tr><td colspan="14">&nbsp;</td><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="14">&nbsp;</td><td colspan="2">&nbsp;</td></tr>
<tr><td>&nbsp;</td><td colspan="3" align="center">Mengetahui,</td><td colspan="10">&nbsp;</td><td colspan="3" align="center" style="font-size:12px;"><?=$kotaRS;?>, <?php echo indonesian_date(); ?> </td></tr>
<tr><td>&nbsp;</td><td colspan="3" align="center">DIREKTUR RSUD</td><td colspan="10">&nbsp;</td><td colspan="3" align="center" style="font-size:12px;">PENGURUS BARANG</td></tr>
<tr><td>&nbsp;</td><td colspan="3" align="center"><?=$tipe_kotaRS;?> <?=$kotaRS;?></td><td colspan="10">&nbsp;</td><td colspan="2">&nbsp;</td></tr>
<?php

?>
<tr><td colspan="4">&nbsp;</td><td colspan="10">&nbsp;</td><td colspan="2">&nbsp;</td></tr>

<tr><td colspan="4">&nbsp;</td><td colspan="10">&nbsp;</td><td colspan="2">&nbsp;</td></tr>

<tr><td colspan="4">&nbsp;</td><td colspan="10">&nbsp;</td><td colspan="2">&nbsp;</td></tr>
<tr><td>&nbsp;</td><td colspan="3" align="center" style="font-size:12px;"><?=$t['dir_nama']; ?></td><td colspan="10">&nbsp;</td><td colspan="3" align="center" style="font-size:12px;"><?=$t['pengurus_nama']; ?></td></tr>
<tr><td>&nbsp;</td><td colspan="3"align="center" style="text-decoration: overline;">NIP. <?php echo $t['dir_nip']; ?></td><td colspan="10">&nbsp;</td><td colspan="3" align="center" style="text-decoration: overline;">NIP. <?php echo $t['pengurus_nip']; ?></td></tr>
</table>

</body>
</html>
