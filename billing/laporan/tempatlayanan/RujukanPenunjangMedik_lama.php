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
<title>Rujukan Penunjang Medik</title>
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
		$waktu = " and b_pelayanan.tgl = '$tglAwal2' ";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
	}
	else if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];
		$thn = $_POST['cmbThn'];
		$waktu = " and month(b_pelayanan.tgl) = '$bln' and year(b_pelayanan.tgl) = '$thn' ";
		$Periode = "Bulan $arrBln[$bln] Tahun $thn";
	}
	else{
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		//echo $arrBln[$tglAwal[1]];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = " and b_pelayanan.tgl between '$tglAwal2' and '$tglAkhir2' ";
		
		$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	}
	
	$sqlUnit1 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['JnsLayanan']."'";
	$rsUnit1 = mysql_query($sqlUnit1);
	$rwUnit1 = mysql_fetch_array($rsUnit1);
	
if($_REQUEST['TmpLayanan']!='0'){	
	$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayanan']."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
	mysql_free_result($rsUnit2);
	$fUnit=" WHERE tab.unit_id_asal=".$_REQUEST['TmpLayanan'];
}else
	$fUnit=" INNER JOIN b_ms_unit mu ON tab.unit_id_asal=mu.id WHERE mu.parent_id=".$_REQUEST['JnsLayanan'];
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);
	
	$stsPas=$_REQUEST['StatusPas'];
	if($stsPas != 0) {
    	$fKso = " AND b_pelayanan.kso_id = $stsPas ";
	}
?>
<table width="800" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
  </tr>
  <tr>
    <td align="center" height="70" valign="top" style="font-size:14px; text-transform:uppercase"><b>Rujukan Penunjang Medik <?php if($_REQUEST['TmpLayanan']=='0') echo "SEMUA"; echo $rwUnit2['nama'] ?><br /><?php echo $Periode;?></b></td>
  </tr>
  <tr>
    <td height="30" align="right">Yang Mencetak :&nbsp;<b><?php echo $rwPeg['nama']; ?></b>&nbsp;</td>
  </tr>
  <tr>
  	<td>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
			<tr style="font-weight:bold; text-align:center;">
				<td height="30" width="3%" style="border-top:1px solid; border-bottom:1px solid;">&nbsp;No.</td>
				<td width="10%" style="border-top:1px solid; border-bottom:1px solid;">&nbsp;Tanggal</td>
				<td width="15%" style="border-top:1px solid; border-bottom:1px solid;">&nbsp;Asal Rujukan</td>
				<td width="25%" style="border-top:1px solid; border-bottom:1px solid;">&nbsp;Dokter Yg Merujuk</td>
				<td width="7%" style="border-top:1px solid; border-bottom:1px solid;">&nbsp;No. RM</td>
				<td width="27%" style="border-top:1px solid; border-bottom:1px solid;">&nbsp;Nama</td>
				<td width="5%" align="center" style="border-top:1px solid; border-bottom:1px solid;">&nbsp;JK</td>
				<td width="8%" align="center" style="border-top:1px solid; border-bottom:1px solid;">&nbsp;Umur</td>
			  </tr>
			  <?php
				$sqlRuj = "SELECT b_ms_unit.nama AS asal, b_ms_pasien.id, b_ms_pasien.no_rm, b_ms_pasien.nama AS pasien, b_ms_pasien.sex, b_kunjungan.umur_bln, b_kunjungan.umur_thn, b_ms_pegawai.nama AS dokter, DATE_FORMAT(b_pelayanan.tgl,'%d-%m-%Y') AS tgl FROM b_ms_pasien INNER JOIN b_kunjungan ON b_kunjungan.pasien_id = b_ms_pasien.id INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id INNER JOIN b_ms_pegawai ON b_ms_pegawai.id = b_pelayanan.dokter_id INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id_asal WHERE b_pelayanan.unit_id = '".$_REQUEST['TmpLayanan']."' $waktu $fKso GROUP BY b_pelayanan.id ORDER BY b_pelayanan.tgl";	
				$rsRuj = mysql_query($sqlRuj);
				$no = 1;
				while($rwRuj = mysql_fetch_array($rsRuj))
				{
			  ?>  
			  <tr>
				<td style="padding-right:5px; text-align:right;"><?php echo $no; ?></td>
				<td style="text-align:center"><?php echo $rwRuj['tgl'];?></td>
				<td style="text-transform:uppercase">&nbsp;<?php echo $rwRuj['asal'];?></td>
				<td style="text-transform:uppercase">&nbsp;<?php echo $rwRuj['dokter'];?></td>
				<td style="text-align:center"><?php echo $rwRuj['no_rm'];?></td>
				<td style="text-transform:uppercase; padding-left:10px;"><?php echo $rwRuj['pasien'];?></td>
				<td align="center"><?php echo $rwRuj['sex'];?></td>
				<td align="center"><?php echo $rwRuj['umur_thn'].' thn '.$rwRuj['umur_bln'].' bln';?></td>
			  </tr>
			  <?php
					$no++;
				}
				mysql_free_result($rsRuj);
			  ?>
		</table>	</td>
  </tr>
  
  <tr>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
	<td align="right">Tgl Cetak: <?php echo $date_now.'&nbsp;Jam:&nbsp;'.$jam;?></td>
  </tr>
  <tr>
	<td align="right">Yang Mencetak</td>
  </tr>
  <tr>
  	<td height="50">&nbsp;</td>
  </tr>
  <tr>
	<td align="right" style="text-transform:uppercase;"><b><?php echo $rwPeg['nama'];?></b>&nbsp;</td>
  </tr>
  <tr height="30"><td></tr>
  <tr id="trTombol">
        <td class="noline" align="center">
			<?php 
            if($_POST['export']!='excel'){
            ?>
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>        </td>
			<?php 
            }
            ?>
    </tr>
	<tr height="30"><td></tr>
</table>
</body>
<?php
	mysql_free_result($rsUnit1);
	mysql_free_result($rsPeg);
	mysql_close($konek);
?>
</html>
<script type="text/JavaScript">

/* try{	
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