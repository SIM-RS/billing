<?php
session_start();
include("../../sesi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title></head>

<body>
<?php
include ("../../koneksi/konek.php");
//====================================

    $jnsLay = $_REQUEST['cmbJenisLayanan'];
    $tmpLay = $_REQUEST['cmbTempatLayanan'];

    $sqlUnit = "SELECT id,nama FROM b_ms_unit WHERE id = '".$tmpLay."'";
    $rsUnit = mysql_query($sqlUnit);
    $rwUnit = mysql_fetch_array($rsUnit);

	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	//$waktu = $_POST['cmbWaktu'];
	$waktu = 'Bulanan';
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
	
/*	if($_REQUEST['cmbJenisLayanan']==0){
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
*/
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font:12px tahoma">
  <tr>
    <td width="10%" height="20">&nbsp;</td>
    <td width="50%" height="20"><p>Formulir RL 3.7 <?=$Periode?> </p>
      <p>KEGIATAN RADIOLOGI </p></td>
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
    <td>: <input width="200" style="background:#CCCCCC"></input></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Nama RS</td>
    <td>: <input width="200" style="background:#CCCCCC"></input></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Tahun</td>
    <td>: <input width="200" style="background:#CCCCCC"></input></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
   <tr>
    <td colspan="3"><table width="100%" border="1">
	  <tr align="center">
        <td width="10%">NO</td>
        <td width="50%">JENIS KEGIATAN</td>
        <td width="40%">JUMLAH</td>
      </tr>
      <tr align="center" bgcolor="#CCCCCC">
        <td>1</td>
		<td>2</td>
		<td>3</td>
		</tr>
      <tr>
        <td colspan="3" align="left">RADIODIAGNOSTIK</td>
        </tr>
      <tr>
        <td align="center">1</td>
        <td>Foto tanpa bahan kontras</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td align="center">2</td>
        <td>Foto dengan bahan kontras</td>
        <td>&nbsp;</td>
        </tr>
	  <tr>
        <td align="center">3</td>
        <td>Foto dengan rol film </td>
        <td>&nbsp;</td>
        </tr>
	  <tr>
        <td align="center">4</td>
        <td>Flouroskopi </td>
        <td>&nbsp;</td>
        </tr>
		<tr>
        <td align="center">5</td>
        <td>Foto Gigi :</td>
        <td>&nbsp;</td>
        </tr>
		<tr>
        <td align="center">6</td>
        <td>C.T. Scan :</td>
        <td>&nbsp;</td>
        </tr>
		<tr>
        <td align="center">7</td>
        <td>Lymphografi</td>
        <td>&nbsp;</td>
        </tr>
		<tr>
        <td align="center">8</td>
        <td> Angiograpi</td>
        <td>&nbsp;</td>
        </tr>
		<tr>
        <td align="center">9</td>
        <td>Lain-Lain </td>
        <td>&nbsp;</td>
        </tr>
		<tr>
        <td colspan="3" align="left">RADIOTHERAPI</td>
        </tr>
		<tr>
        <td align="center">1</td>
        <td>Jumlah Kegiatan Radiotherapi</td>
        <td>&nbsp;</td>
        </tr>
		<tr>
        <td align="center">2</td>
        <td>Lain-Lain</td>
        <td>&nbsp;</td>
        </tr>
		<tr>
		  <td colspan="3" align="left">KEDOKTERAN NUKLIR</td>
	    </tr>
		<tr>
		  <td align="center">1</td>
		  <td>Jumlah Kegiatan Diagnostik</td>
		  <td>&nbsp;</td>
	    </tr>
		<tr>
		  <td align="center">2</td>
		  <td>Jumlah Kegiatan Therapi</td>
		  <td>&nbsp;</td>
	    </tr>
		<tr>
		  <td align="center">3</td>
		  <td>Lain-Lain</td>
		  <td>&nbsp;</td>
	    </tr>
		<tr>
		  <td colspan="3" align="left">IMAGING/PENCITRAAN</td>
	    </tr>
		<tr>
		  <td align="center">1</td>
		  <td>USG</td>
		  <td>&nbsp;</td>
	    </tr>
		<tr>
        <td align="center">2</td>
        <td>MRI</td>
        <td>&nbsp;</td>
        </tr>
		<tr>
        <td align="center">3</td>
        <td>Lain-lain</td>
        <td>&nbsp;</td>
        </tr>
	  <tr>
        <td align="center">99</td>
        <td>Total </td>
        <td bgcolor="#999999">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
  </table>
</body>
</html>
