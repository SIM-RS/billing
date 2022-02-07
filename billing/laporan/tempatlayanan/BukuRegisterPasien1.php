<?php
session_start();
include("../../sesi.php");
?>
<?php 
if($_POST['export']=='excel'){
header("Content-type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="Lap Buku Register Pasien.xls"');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php 
if($_POST['export']!='excel'){
?>
<link type="text/css" rel="stylesheet" href="../../theme/print.css">
<?php 
}
?>
<script type="text/javascript" src="../../theme/js/ajax.js"></script>
<script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>
<script type="text/JavaScript" language="JavaScript" src="../../theme/js/formatPrint.js"></script>
<title>Buku Register Pasien</title>
</head>

<body>
<?php
	include("../../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	
	$waktu = $_POST['cmbWaktu'];
	if($waktu == 'Harian'){
		$tglAwal = explode('-',$_REQUEST['tglAwal2']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$waktu = " and pl.tgl = '$tglAwal2' ";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
	}
	else if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];
		$thn = $_POST['cmbThn'];
		$waktu = " and month(pl.tgl) = '$bln' and year(pl.tgl) = '$thn' ";
		$Periode = "Bulan $arrBln[$bln] Tahun $thn";
	}
	else{
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		//echo $arrBln[$tglAwal[1]];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = " and pl.tgl between '$tglAwal2' and '$tglAkhir2' ";
		
		$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	}
	
	$sqlUnit1 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['JnsLayanan']."'";
	$rsUnit1 = mysql_query($sqlUnit1);
	$rwUnit1 = mysql_fetch_array($rsUnit1);
if($_REQUEST['TmpLayanan']!='0'){	
	$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayanan']."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
	$fUnit=" pl.unit_id=".$_REQUEST['TmpLayanan']." ";
}
else{
	$fUnit=" u.parent_id=".$_REQUEST['JnsLayanan']." ";
}
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);
	
	$stsPas=$_REQUEST['StatusPas'];
	if($stsPas != 0) {
    	$fKso = " AND pl.kso_id = $stsPas ";
	}
?>
<table width="1000" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td colspan="11"><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
  </tr>
  <tr>
    <td colspan="11" align="center" height="70" valign="top" style="font-size:14px; text-transform:uppercase">
	<b>Buku Register Pasien <?php echo $rwUnit1['nama'] ?> - <?php if($_REQUEST['TmpLayanan']=='0') echo "SEMUA"; echo $rwUnit2['nama'] ?><br />
      <?php echo $Periode;?></b>    </td>
  </tr>
  <tr>
	<td colspan="5" align="left" height="30">&nbsp;<b>TEMPAT LAYANAN : &nbsp;<?php if($_REQUEST['TmpLayanan']=='0') echo "Semua"; echo $rwUnit2['nama'] ?></b></td>
	<td colspan="6" align="right">Yang Mencetak :&nbsp;<b><?php echo $rwPeg['nama'];?></b>&nbsp;</td>
  </tr>
  <tr style="font-weight:bold">
    <td height="20" width="3%" style="border-bottom:1px solid; border-top:1px solid;">&nbsp;No.</td>
    <td width="6%" style="border-bottom:1px solid; border-top:1px solid; text-align:center;">Tgl Kunjungan</td>
    <td width="6%" style="border-bottom:1px solid; border-top:1px solid; text-align:center;">No. RM</td>
    <td style="border-bottom:1px solid; border-top:1px solid;">&nbsp;Nama Pasien</td>
    <td width="3%" align="center" style="border-bottom:1px solid; border-top:1px solid;">JK</td>
    <td width="8%" align="center" style="border-bottom:1px solid; border-top:1px solid;">Umur</td>
    <td width="15%" style="border-bottom:1px solid; border-top:1px solid;">&nbsp;Alamat</td>
    <td width="5%" style="border-bottom:1px solid; border-top:1px solid;">Kunjungan</td>
    <td width="11%" style="border-bottom:1px solid; border-top:1px solid;">&nbsp;Asal Pasien</td>
    <td width="12%" style="border-bottom:1px solid; border-top:1px solid;">&nbsp;Dokter</td>
    <td width="6%" style="border-bottom:1px solid; border-top:1px solid;">Status Kunjungan</td>
  </tr>
  <?php
	$qK = "SELECT kso.id, kso.nama
		FROM b_kunjungan k
		INNER JOIN b_pelayanan pl on pl.kunjungan_id = k.id
		INNER JOIN b_ms_kso kso ON pl.kso_id = kso.id 
		INNER JOIN b_ms_unit u ON u.id = pl.unit_id
		WHERE $fUnit $waktu $fKso
		GROUP BY kso.id ORDER BY kso.nama";
	$rsK = mysql_query($qK);
	while($rwK = mysql_fetch_array($rsK))
	{
  ?>
  <tr>
	<td colspan="11" height="30" valign="bottom">&nbsp;<b><?php echo $rwK['nama'];?></b></td>
  </tr>
  <?php
 /* query - dicoba ya... */
  
  $sqlPas = "SELECT DATE_FORMAT(k.tgl,'%d/%m/%Y') AS tgl, p.no_rm, p.nama AS pasien, 
p.sex, k.umur_thn,k.umur_bln,
  k.umur_hr, IF(k.isbaru=1,'Baru','Lama') AS kunjungan, p.alamat,
(SELECT nama FROM b_ms_unit WHERE id = pl.unit_id_asal) AS asal,
mp.nama AS dokter,k.pulang,IF(k.pulang=1,'Closed','Blm Closed') AS stsClosed, pl.id, t.ms_tindakan_kelas_id
FROM b_ms_pasien p
INNER JOIN b_kunjungan k ON k.pasien_id = p.id
INNER JOIN b_pelayanan pl ON pl.kunjungan_id = k.id
LEFT JOIN b_tindakan t ON t.pelayanan_id = pl.id
LEFT JOIN b_ms_pegawai mp ON mp.id=t.user_id
INNER JOIN b_ms_unit u ON u.id = pl.unit_id
WHERE $fUnit $waktu and pl.kso_id = '".$rwK['id']."' GROUP BY k.id,pl.id";
	//echo $sqlPas."<br>";
	$rsPas = mysql_query($sqlPas);
	$no = 1;
	while($rwPas = mysql_fetch_array($rsPas))
 	{
		$fcolor="black";
		if ($rwPas["pulang"]==0){
			$fcolor="red";
		}
  ?>
  <tr style="font-size:10px" valign="top">
  	<td>&nbsp;<?php echo $no; ?></td>
	<td align="center"><?php echo $rwPas['tgl'];?></td>
	<td align="center"><?php echo $rwPas['no_rm'];?></td>
	<td style="text-transform:uppercase">&nbsp;<?php echo $rwPas['pasien'];?></td>
	<td align="center">&nbsp;<?php echo $rwPas['sex'];?></td>
	<td align="center">&nbsp;<?php echo $rwPas['umur_thn']."th ".$rwPas['umur_bln']."bln ".$rwPas['umur_hr']."hr";?></td>
	<td style="text-transform:capitalize">&nbsp;<?php echo $rwPas['alamat'];?></td>
	<td>&nbsp;<?php echo $rwPas['kunjungan']; ?></td>
	<td style="text-transform:uppercase">&nbsp;<?php echo $rwPas['asal'];?></td>
	<td valign="top">&nbsp;<?php echo $rwPas['dokter'];?></td>
    <td valign="top" style="color:<?php echo $fcolor; ?>;"><?php echo $rwPas['stsClosed'];?></td>
  </tr>
  <?php
  		 $no++;
	}
	mysql_free_result($rsPas);
	}
	mysql_free_result($rsK);
	mysql_free_result($rsUnit1);
	if($_REQUEST['TmpLayanan']!='0'){
		mysql_free_result($rsUnit2);
	}
	mysql_free_result($rsPeg);
	mysql_close($konek);
  ?>
  <tr><td colspan="11">&nbsp;</td></tr>
  <tr><td colspan="11" style="text-align:right">Tgl Cetak:&nbsp;<?php echo $date_now.'&nbsp;Jam:&nbsp;'.$jam?>&nbsp;</td></tr>
  <tr><td colspan="11" height="50" valign="top" style="text-align:right">Yang Mencetak,&nbsp;</td></tr>
  <tr><td colspan="11" style="text-align:right"><b><?php echo $rwPeg['nama'];?></b>&nbsp;</td></tr>
  <tr id="trTombol">
        <td colspan="11" class="noline" align="center">
			<?php 
            if($_POST['export']!='excel'){
            ?>
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>        </td>
			<?php 
            }
            ?>
    </tr>
  <tr><td colspan="11" height="50">&nbsp;</td></tr>
</table>
</body>
<script type="text/JavaScript">
    /*function cetak(tombol){
        tombol.style.visibility='hidden';
        if(tombol.style.visibility=='hidden'){
		window.print();
		window.close();
        }
    }*/
    
    /* 
        try{
	formatF4();
	}catch(e){
	window.location='../../addon/jsprintsetup.xpi';
	} */
        
        function cetak(tombol){
        tombol.style.visibility='hidden';
        if(tombol.style.visibility=='hidden'){
		/* try{
			mulaiPrint();
		}
		catch(e){
			window.print();
		} */
		window.print();
		window.close();
        }
    }
    
</script>
</html>
