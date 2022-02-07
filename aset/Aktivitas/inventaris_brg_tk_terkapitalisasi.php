<?php 
include '../sesi.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>
        alert('Session anda habis atau anda belum login, silakan login ulang.');
        window.location = '/simrs-tangerang/aset/';
        </script>";
}
include '../koneksi/konek.php'; 
$tglAwl=$_REQUEST['tglAwl'];
$t=explode("-",$tglAwl);
$tglAw=$t[2]."-".$t[1]."-".$t[0];
$tglAkhr=$_REQUEST['tglAkhr'];
$tg=explode("-",$tglAkhr);
$tglAk=$tg[2]."-".$tg[1]."-".$tg[0];

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


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Laporan Barang Inventaris Tak Terkapitalisasi :.</title>
</head>
<style>
.judulheaderkiri{
border-bottom:1px solid;
border-left:1px solid;
border-top:1px solid;
border-right:1px solid;
font-size:12px;
font:bold;
}
.isiheader{
border-bottom:1px solid;
border-top:1px solid;
border-right:1px solid;
font-size:12px;
font:bold;
}
.subisiheader{
border-bottom:1px solid;
border-right:1px solid;
font-size:12px;
font:bold;
}
.isikiri{
border-bottom:1px solid;
border-left:1px solid;
border-right:1px solid;
font-size:12px;
}
.isi{
border-bottom:1px solid;
border-right:1px solid;
font-size:12px;
}
</style>
<button type="button" id="ctk" name="ctk" onclick="window.print()" style="cursor:pointer"><img src="../icon/printer.png" style="vertical-align:middle" />&nbsp;&nbsp;Cetak Laporan</button>
<button type="button" id="ttp" name="ttp" style="cursor:pointer" onclick="window.location='daftar_tk_terkapitalisasi.php'"><img src="../icon/del.gif" width="20" height="20" style="vertical-align:middle" />&nbsp;&nbsp;Tutup Laporan</button>
<body>
<table width="1150" align="center" cellpadding="0" cellspacing="0">
<tr>
	<td width="1037" align="center" style="font:Verdana, Arial, Helvetica, sans-serif large bold">DAFTAR PENGADAAN BARANG INVENTARIS YANG TIDAK DAPAT DIKAPITALISASI</td>
</tr>
<tr>
	<td align="center" style="font:Verdana, Arial, Helvetica, sans-serif large bold; text-transform:uppercase;"><?=$namaRS;?></td>
</tr>
<tr>
	<td align="center" style="font:Verdana, Arial, Helvetica, sans-serif large bold"> PERIODE :&nbsp;<?php echo $tglAwl."&nbsp;s/d&nbsp;".$tglAkhr ?></td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td align="center">
		<table width="1204" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td width="31" rowspan="4" align="center" class="judulheaderkiri">No</td>
			<td colspan="2" rowspan="3" align="center" class="isiheader">Jenis barang yang di beli</td>
			<td align="center" colspan="2" class="isiheader">SPK/Perjanjian/Kontrak</td>
			<td align="center" colspan="2" class="isiheader">SP2D</td> 
			<td width="63" rowspan="4" align="center" class="isiheader">Banyaknya Barang</td>
			<td align="center" colspan="5" class="isiheader">Perhitungan biaya perolehan</td>
			<td width="83" rowspan="4" align="center" class="isiheader">Dipergunakan pada unit/dibawah ke / dimutasi ke</td>
			<td width="105" rowspan="4" align="center" class="isiheader">Ket</td>
		</tr>
		<tr>
			<td width="63" rowspan="3" align="center" class="subisiheader">Tanggal</td>
			<td width="105" rowspan="3" align="center" class="subisiheader">Nomor</td>
			<td width="67" rowspan="3" align="center" class="subisiheader">Tanggal</td>
			<td width="58" rowspan="3" align="center" class="subisiheader">Nomor</td>
			<td width="63" rowspan="3" align="center" class="subisiheader">Harga satuan</td>
			<td align="center" colspan="2" class="subisiheader">Kapitalisasi biaya lain</td>
			<td width="85" rowspan="3" align="center" class="subisiheader">Total biaya perolehan (persatuan)</td>
			<td width="65" rowspan="3" align="center" class="subisiheader">Jumlah harga</td>
		</tr>
		<tr>
			<td align="center" colspan="2" class="subisiheader">(Jika ada)</td>
		</tr>
		<tr>
			<td width="74" height="17" align="center" class="subisiheader">Kode brg</td>
			<td width="151" align="center" class="subisiheader">Nama brg</td>
			<td width="61" align="center" class="subisiheader">Nilai</td>
			<td width="74" align="center" class="subisiheader">Uraian</td>
		</tr>
		<tr>
			<td height="18" align="center" class="isikiri">1</td>
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
			<td align="center" class="isi">12=9+(10:8)</td>
			<td align="center" class="isi">13=8x12</td>
			<td align="center" class="isi">14</td>
			<td align="center" class="isi">15</td>
		</tr>
		<?php 
		
		$no=1;
		$sql="SELECT T2.kodebarang,T2.namabarang,T1.* FROM
(SELECT m.barang_id,p.tgl_po,p.no_po,m.jml_msk,m.satuan_unit,m.harga_unit,p.peruntukan FROM as_masuk m INNER JOIN as_po p ON m.po_id=p.id
WHERE DATE(tgl_terima ) BETWEEN '".$tglAw."' AND '".$tglAk."') AS T1
INNER JOIN 
(SELECT idbarang,kodebarang,namabarang,nilai FROM as_ms_barang b, as_kapitalisasi k 
WHERE b.tipe=1 AND b.kodebarang LIKE CONCAT(kode,'%')) AS T2
ON T1.barang_id=T2.idbarang
WHERE T1.harga_unit>=T2.nilai
ORDER BY T2.kodebarang";
$rs=mysql_query($sql);
while($row=mysql_fetch_array($rs)){
//if($row['jml_msk']!=0){
$perolehan=$row['jml_msk']+$row['harga_unit'];
//}

$jml_hrg=$row['jml_msk']*$perolehan;
		?>
		<tr>
			<td class="isikiri" align="center"><?php echo $no ?></td>
			<td class="isi"><?php echo $row['kodebarang'] ?></td>
			<td class="isi"><?php echo $row['namabarang'] ?></td>
			<td class="isi" align="center"><?php echo $row['tgl_po'] ?></td>
			<td class="isi" align="center"><?php echo $row['no_po'] ?></td>
			<td class="isi">&nbsp;</td>
			<td class="isi">&nbsp;</td>
			<td class="isi" align="center"><?php echo $row['jml_msk'] ?></td>
			<td class="isi" align="right"><?php echo number_format($row['harga_unit'],0,',','.') ?></td>
			<td class="isi">&nbsp;</td>
			<td class="isi"><?php echo number_format($row['harga_unit'],0,',','.') ?></td>
			<td class="isi" align="right"><?php echo number_format($perolehan,0,',','.') ?></td>
			<td class="isi" align="right"><?php echo number_format($jml_hrg,0,',','.') ?></td>
			<td class="isi"><?php echo $row['peruntukan'] ?></td>
			<td class="isi">&nbsp;</td>
		</tr>
		<?php 
		$no++;
		}
		?>
		
	  </table>	
	  </td>
</tr>
<tr>
	<td><table width="1204" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="893">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="309"><?=$kotaRS;?>, <?php echo indonesian_date(); ?> </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="309">DIREKTUR RSUD</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="309"><?=$tipe_kotaRS;?> <?=$kotaRS;?></td>
      </tr>
      <tr>
        <td colspan="2" height="60">&nbsp;</td>
      </tr>
      <?php 
			$sqldirek=mysql_query("select dir_nama, dir_nip from as_setting");
			$rf=mysql_fetch_array($sqldirek);
		?>
      <tr>
        <td width="893">&nbsp;</td>
		<td width="309" style="text-decoration:underline; vertical-align:top"><?php echo $rf['dir_nama'] ?></td>
      </tr>
	  <tr>
		<td width="893">&nbsp;</td>
		<td width="309">NIP.<?php echo $rf['dir_nip'] ?></td>
		</tr>
    </table>
	</td>	
</tr>
	
</tr>
</table>
</body>
</html>
