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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Data Inventaris</title>
</head>
<style>
.farahjdkiri{
border-left:1px solid;
border-right:1px solid;
border-top:1px solid;
border-bottom:1px solid;
}
.farahjdisi{
border-right:1px solid;
border-top:1px solid;
border-bottom:1px solid;
}
.farahjdsub{
border-bottom:1px solid;
border-right:1px solid;
}
.farahisikiri1{
border-bottom:1px solid;
border-left:1px solid;
border-right:1px solid;
}
.farahisi1{
border-bottom:1px solid;
border-right:1px solid;
}
.farahisikiri{
border-bottom:2px dotted;
border-left:1px solid;
border-right:1px solid;
}
.farahisi{
border-bottom:2px dotted;
border-right:1px solid;
}
</style>
<body>
<?php
$qlokasi = mysql_query("select namalokasi from as_lokasi where idlokasi = '".$_REQUEST['lokasi']."'");
$dlokasi = mysql_fetch_array($qlokasi);
$qunit = mysql_query("select namaunit from as_ms_unit where idunit = '".$_REQUEST['unit']."'");
$dunit = mysql_fetch_array($qunit);
?>
<table width="1034" align="center" cellpadding="0" cellspacing="0" >
<tr><td colspan="3" align="center" style="font-size:19px;"><b>KARTU INVENTARIS RUANGAN<b></td></tr>
<tr><td width="25%">Kode/Nama Unit</td><td width="1%">:</td><td align="left">&nbsp;<?=$dunit[0];?></td></tr>
<tr><td>Kode/Nama Lokasi</td><td>:</td><td align="left">&nbsp;<?=$dlokasi[0];?></td></tr>
</table>
<table width="1034" align="center" cellpadding="0" cellspacing="0" >
<tr style="background-color:#999999">
	<td width="65" rowspan="1" align="center" class="farahjdkiri">No</td>	
	<td width="210" rowspan="1" align="center" class="farahjdisi">Kode Barang</td>	
	<td width="101" rowspan="1" align="center" class="farahjdisi">No Seri</td>
	<td width="210" rowspan="1" align="center" class="farahjdisi">Nama Barang</td>
	<td width="95" rowspan="1" align="center" class="farahjdisi">Tahun Pengadaan</td>
	<td width="141" rowspan="1" align="center" class="farahjdisi">Asal Usul Cara Perolehan</td>
	<td width="210" rowspan="1" align="center" class="farahjdisi">Kondisi Barang</td>
</tr>
<tr>
	<td align="center" class="farahisikiri1">1</td>
	<td align="center" class="farahisi1">2</td>
	<td align="center" class="farahisi1">3</td>
	<td align="center" class="farahisi1">4</td>
	<td align="center" class="farahisi1">5</td>
	<td align="center" class="farahisi1">6</td>
	<td align="center" class="farahisi1">7</td>
</tr>
<?php 
$no=1;
$sql = "SELECT * FROM as_seri2 s INNER JOIN as_ms_barang br ON s.idbarang = br.idbarang
					LEFT JOIN kib01 a on a.idseri = s.idseri
					LEFT JOIN kib02 b on b.idseri = s.idseri
					LEFT JOIN kib03 c on c.idseri = s.idseri
					LEFT JOIN kib04 d on d.idseri = s.idseri
					LEFT JOIN kib05 e on e.idseri = s.idseri
					LEFT JOIN kib06 f on f.idseri = s.idseri
		WHERE s.ms_idunit='".$_REQUEST['unit']."' ".(($_REQUEST['lokasi']=='')?" ":" AND s.ms_idlokasi = '".$_REQUEST['lokasi']."'");
		$rs=mysql_query($sql);
		while($row=mysql_fetch_array($rs)){
?>
<tr>
	<td align="center" class="farahisikiri1"><?=$no;?></td>
	<td align="center" class="farahisi1"><?=$row["kodebarang"];?></td>
	<td align="center" class="farahisi1"><?=str_pad($row["noseri"], 4, "0", STR_PAD_LEFT);?></td>
	<td align="center" class="farahisi1"><?=$row["namabarang"];?></td>
	<td align="center" class="farahisi1"><?=$row["thn_pengadaan"];?></td>
	<td align="center" class="farahisi1"><?=$row["asalusul"];?></td>
	<td align="center" class="farahisi1"><?=$row["kondisi"];?></td>
</tr>
<?php 
$no++;
}
?>
</table>
<table width="1034" align="center" cellpadding="0" cellspacing="0" >
<tr>
	<td><br /></td>
</tr>
<tr>
	<td width="515" align="center"><strong>Pengurus Barang</strong></td>
	<td width="517" align="center" style="text-decoration:underline"><strong><?=$kotaRS;?>, <?php echo indonesian_date() ?></strong></td>
<tr>
	<td>&nbsp;</td>
	<td align="center"><strong>Penanggung Jawab</strong></td>
</tr>
</tr>
	<td>&nbsp;</td>
	<td align="center"><p>&nbsp;</p>
	 </td>
</tr>
<tr>
	<td align="center"><hr style="width:150px;"/></td>
	<td align="center"><hr style="width:150px;"/></td>
</tr>
<tr>
	<td align="center" colspan="2"><p><strong>Mengetahui <br />
    Direktur</strong></p>
    <p>&nbsp;</p></td>
</tr>
<tr>
	<td colspan="2" align="center"><hr style="width:150px" /></td>
</tr>
<!--tr><td colspan="3" align="right" style="font-size:19px;">
<table width="30%" summary="" border="0" >
<tr><td>&nbsp;</td></tr>
<tr><td align="center">Sidorajo,<? echo indonesian_date ();?> </td></tr>
<tr><td align="center">Pengurus barang</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td></td></tr>
<tr><td align="center">________________</td></tr>
</table>
</td></tr-->
</table>
</body>
</html>
