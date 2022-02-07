<?php
session_start();
include("../../sesi.php");
include ("../../koneksi/konek.php");
//====================================

    $jnsLay = $_REQUEST['cmbJenisLayanan'];
    $tmpLay = $_REQUEST['cmbTempatLayanan'];

    $sqlUnit = "SELECT id,nama FROM b_ms_unit WHERE id = '".$tmpLay."'";
    $rsUnit = mysql_query($sqlUnit);
    $rwUnit = mysql_fetch_array($rsUnit);

	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$waktu = $_POST['cmbWaktu'];
	//$waktu = 'Bulanan';
	if($waktu == 'Harian'){
		$tglAwal = explode('-',$_REQUEST['tglAwal2']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$waktu = " AND b_pelayanan.tgl = '$tglAwal2' ";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
	}
	else if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];
		$thn = $_POST['cmbThn'];
		$waktu = " AND month(b_pelayanan.tgl) = '$bln' and year(b_pelayanan.tgl) = '$thn' ";
		$Periode = "Bulan $arrBln[$bln] Tahun $thn";
	}
	else{
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		//echo $arrBln[$tglAwal[1]];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = " AND b_pelayanan.tgl between '$tglAwal2' and '$tglAkhir2' ";
		
		$tgl1=GregorianToJD($tglAwal[1],$tglAwal[0],$tglAwal[2]);
		$tgl2=GregorianToJD($tglAkhir[1],$tglAkhir[0],$tglAkhir[2]);
		$selisih=$tgl2-$tgl1;
		
		$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	}
	
	if($_REQUEST['cmbJenisLayanan']==0){
		$txtJenis = "Rawat Jalan :";
		if($_REQUEST['cmbTempatLayanan']==0){
			$txtTempat = "Semua";
			$fUnit = " AND b_pelayanan.jenis_kunjungan<>3 ";
		}
		else{
			$txtTempat = $rwUnit['nama'];
			$fUnit = " AND b_pelayanan.unit_id = '".$_REQUEST['cmbTempatLayanan']."'";
		}
	}
	else{
		$txtJenis = "Rawat Inap :";
		if($_REQUEST['cmbTempatLayanan']==0){
			$txtTempat = "Semua";
			$fUnit = " AND b_pelayanan.jenis_kunjungan=3 ";
		}
		else{
			$txtTempat = $rwUnit['nama'];
			$fUnit = " AND b_pelayanan.unit_id = '".$_REQUEST['cmbTempatLayanan']."'";
		}
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Laporan Kegiatan Perinatologi</title></head>

<body>
<table width="73%" border="0" cellpadding="0" cellspacing="0" style="font:12px tahoma">
  <tr>
    <td width="10%" height="20"><img src="logo-bakti-husada.jpg" width="55" height="60" /></td>
    <td width="50%" height="20"><p>Formulir RL 3.5 </p>
      <p>KEGIATAN PERINATOLOGI</p></td>
    <td width="40%" height="20"><table width="100%" border="0">
      <tr>
        <td colspan="4">&nbsp;</td>
        </tr>
      <tr>
	    <td colspan="3" width="10%">&nbsp;</td>
        <td width="30%"><i>Ditjen Bina Upaya Kesehatan</i></td>
        </tr>
      <tr>
	  	<td colspan="3">&nbsp;</td>
        <td><i>Kementrian Kesehatan RI</i></td>
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
         <td width="5%" rowspan="4">NO</td>
         <td width="40%" rowspan="4">JENIS KEGIATAN</td>
         <td width="10%" colspan="8">RUJUKAN</td>
         <td width="10%" rowspan="2" colspan="2">NON RUJUKAN</td>
         <td width="10%" rowspan="4">DIRUJUK</td>
       </tr>
       <tr align="center">
         <td width="9%" colspan="6">MEDIS</td>
         <td width="9%" colspan="2">NON MEDIS</td>
       </tr>
       <tr align="center">
         <td width="7%" rowspan="2">RUMAH</br>SAKIT</td>
         <td width="7%" rowspan="2">BIDAN</td>
         <td width="7%" rowspan="2">PUSKES</br>MAS</td>
         <td width="8%" rowspan="2">FASKES</br>LAINNYA</td>
         <td width="7%" rowspan="2">Jumlah</br>Mati</td>
         <td width="7%" rowspan="2">Jumlah</br>Total</td>
         <td width="7%" rowspan="2">Jumlah</br>Mati</td>
         <td width="7%" rowspan="2">Jumlah</br>Total</td>
         <td width="7%" rowspan="2">Jumlah</br>Mati</td>
         <td width="7%" rowspan="2">Jumlah</br>Total</td>
       </tr>
       <tr align="center">
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
         <td>10</td>
         <td>11</td>
         <td>12</td>
         <td>13</td>
       </tr>
       <tr>
         <td align="center">1</td>
         <td>Bayi Lahir Batin </td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td align="center">1.1</td>
         <td>>= 2500 gram</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td align="center">1.2</td>
         <td>< 2500 gram</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td align="center">2</td>
         <td>Kematian Perintal  </td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
	   <tr>
         <td align="center">2.1</td>
         <td>Kelahiran Mati </td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
	   <tr>
         <td align="center">2.2</td>
         <td>Mati Neonatal &lt; 7 Hari </td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
	   <tr>
         <td align="center">3</td>
         <td>Sebab Kematian Perinatal </td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
	   <tr>
         <td align="center">3.1</td>
         <td>Asphyxia</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
	   <tr>
         <td align="center">3.2</td>
         <td>Trauma Kelahiran </td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
	   <tr>
         <td align="center">3.3</td>
         <td>BBLR</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
	   <tr>
         <td align="center">99</td>
         <td>Total</td>
         <td bgcolor="#999999">&nbsp;</td>
         <td bgcolor="#999999">&nbsp;</td>
         <td bgcolor="#999999">&nbsp;</td>
         <td bgcolor="#999999">&nbsp;</td>
         <td bgcolor="#999999">&nbsp;</td>
         <td bgcolor="#999999">&nbsp;</td>
         <td bgcolor="#999999">&nbsp;</td>
         <td bgcolor="#999999">&nbsp;</td>
         <td bgcolor="#999999">&nbsp;</td>
         <td bgcolor="#999999">&nbsp;</td>
         <td bgcolor="#999999">&nbsp;</td>
       </tr>
     </table></td>
   </tr>
  </table>
</body>
</html>
