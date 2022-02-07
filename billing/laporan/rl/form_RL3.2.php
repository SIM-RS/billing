<?php
session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');

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
	
	$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayanan']."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title></head>

<body>
<table width="65%" border="0" cellpadding="0" cellspacing="0" style="font:12px tahoma">
  <tr>
    <td width="10%" height="20"><img src="logo-bakti-husada.jpg" width="55" height="60" /></td>
    <td width="50%" height="20"><p>Formulir RL 3.2 </p>
      <p>KUNJUNGAN RAWAT DARURAT </p></td>
    <td width="40%" height="20"><table width="100%" border="0">
      <tr>
        <td colspan="4">&nbsp;</td>
        </tr>
      <tr>
	    <td>&nbsp;</td>
        <td colspan="3"><i>Ditjen Bina Upaya Kesehatan</i></td>
        </tr>
      <tr>
	  	<td>&nbsp;</td>
        <td colspan="3"><i>Kementrian Kesehatan RI</i></td>
        </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Kode RS</td>
    <td>: <?php echo $kodeRS;?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Nama RS</td>
    <td>: <?php echo $namaRS;?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;<?php echo $Periode;?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
   <tr>
    <td colspan="3"><table width="100%" border="1" style="border-collapse:collapse;">
	  <tr align="center">
        <td width="5%" rowspan="2">NO</td>
        <td width="30%" rowspan="2">JENIS PELAYANAN</td>
        <td width="15%" colspan="2">TOTAL PASIEN</td>
        <td width="25%" colspan="3">TINDAK LANJUT PELAYANAN</td>
        <td width="12%" style="border-bottom:none">MATI DI</td>
        <td width="8%" rowspan="2">DOA</td>
      </tr>
	  <tr align="center">
        <td width="9%">RUJUKAN</td>
		<td width="9%">NON RUJUKAN</td>
		<td width="9%">DIRAWAT</td>
		<td width="9%">DIRUJUK</td>
		<td width="9%">PULANG</td>
		<td width="9%" style="border-top:none">IGD</td>
      </tr>
      <tr align="center" bgcolor="#CCCCCC">
        <td>1</td>
		<td>2</td>
		<td>3</td>
		<td>4</td>
		<td>5</td>
		<td>6</td>
		<td>7</td>
		<td>8</td>
		<td>9</td>
		</tr>
<?php   
		if($_REQUEST['StatusPas']!=0)
			$fKso = " AND b_kunjungan.kso_id = ".$_REQUEST['StatusPas'];
		if($_REQUEST['TmpLayanan']==0){
			
			$fUnit = " b_pelayanan.jenis_layanan = '".$_REQUEST['JnsLayanan']."'";
		}else{
			$fUnit = " b_pelayanan.unit_id = '".$_REQUEST['TmpLayanan']."' ";
		}
		
		$qUn = "SELECT 
				  b_ms_unit.nama nm_unit,
				  b_ms_unit.id id_unit
				FROM
				  b_ms_unit 
				WHERE b_ms_unit.kode LIKE '03%' 
				  AND b_ms_unit.aktif = 1 
				  AND b_ms_unit.islast = 1
				ORDER BY b_ms_unit.nama;";//echo $qUn;
		$qUn2 = mysql_query($qUn);
		$no=1;
		while($wUn = mysql_fetch_array($qUn2))
		{//$fUnit AND
		
?>
      <tr>
        <td align="center"><?=$no;?></td>
        <td><?=$wUn['nm_unit'];?></td>
<?
$jmP="SELECT 
		SUM(b_kunjungan.asal_kunjungan<>3) rujuk,
		SUM(b_kunjungan.asal_kunjungan=3) non_rujuk,
		SUM(b_pelayanan.dilayani=1) dilayani,
		SUM(b_pasien_keluar.cara_keluar='Dirujuk') dirujuk,
		SUM(b_pasien_keluar.cara_keluar<>'Dirujuk') pulang
		FROM
		  b_kunjungan
		INNER JOIN b_pelayanan
			ON b_pelayanan.kunjungan_id=b_kunjungan.id		  
		INNER JOIN b_ms_pasien 
		  ON b_kunjungan.pasien_id=b_ms_pasien.id
		LEFT JOIN b_pasien_keluar
		  ON b_pasien_keluar.kunjungan_id=b_kunjungan.id
		WHERE b_kunjungan.unit_id='".$wUn['id_unit']."' AND b_pelayanan.jenis_kunjungan=2
		;";//echo $jmP;
		$jmPq=mysql_query($jmP);
		$jmlR=0;
		$jmlNR=0;
		$jmlDL=0;
		$jmlDR=0;
		$jmlP=0;
		while($dtjmPq=mysql_fetch_array($jmPq))
		{
?>
        <td align="center"><?=$dtjmPq['rujuk'];?></td>
        <td align="center"><?=$dtjmPq['non_rujuk'];?></td>
        <td align="center"><?=$dtjmPq['dilayani'];?></td>
        <td align="center"><?=$dtjmPq['dirujuk'];?></td>
        <td align="center"><?=$dtjmPq['pulang'];?></td>
        <td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
      </tr>
<?php
$no++;
$jmlR+=$dtjmPq['rujuk'];
$jmlNR+=$dtjmPq['non_rujuk'];
$jmlDL+=$dtjmPq['dilayani'];
$jmlDR+=$dtjmPq['dirujuk'];
$jmlP+=$dtjmPq['pulang'];
}
}
?>
	  <tr style="text-align:center">
        <td colspan="2">TOTAL</td>
        <td bgcolor="#999999"><?=$jmlR?></td>
        <td bgcolor="#999999"><?=$jmlNR?></td>
        <td bgcolor="#999999"><?=$jmlDL?></td>
        <td bgcolor="#999999"><?=$jmlDR?></td>
        <td bgcolor="#999999"><?=$jmlP?></td>
        <td bgcolor="#999999">&nbsp;</td>
        <td bgcolor="#999999">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
  </table>
</body>
</html>
