<?php
session_start();
include("../../sesi.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Data Dasar Rumah Sakit</title>
</head>

<body>
<?php
include ("../../koneksi/konek.php");
//====================================

//    $jnsLay = $_REQUEST['cmbJenisLayanan'];
//    $tmpLay = $_REQUEST['cmbTempatLayanan'];

/*    $sqlUnit = "SELECT id,nama FROM b_ms_unit WHERE id = '".$tmpLay."'";
    $rsUnit = mysql_query($sqlUnit);
    $rwUnit = mysql_fetch_array($rsUnit);
*/
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	
$tgl=date('d');
$bln=date('m');
$thn=date('Y');

/*	$waktu = $_POST['cmbWaktu'];
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
			$fUnit = " b_pelayanan.jenis_kunjungan<>3 ";
		}
		else{
			$txtTempat = $rwUnit['nama'];
			$fUnit = " b_pelayanan.unit_id = '".$_REQUEST['cmbTempatLayanan']."'";
		}
	}
	else{
		$txtJenis = "Rawat Inap :";
		if($_REQUEST['cmbTempatLayanan']==0){
			$txtTempat = "Semua";
			$fUnit = " b_pelayanan.jenis_kunjungan=3 ";
		}
		else{
			$txtTempat = $rwUnit['nama'];
			$fUnit = " b_pelayanan.unit_id = '".$_REQUEST['cmbTempatLayanan']."'";
		}
	}
*/
?>
<table width="800" border="0" cellpadding="0" cellspacing="0" style="font:12px tahoma">
  <tr>
    <td width="10%" height="20" style="border-bottom:2px solid #000000"><img src="logo-bakti-husada.jpg" width="55" height="60" /></td>
    <td width="38%" height="20" style="border-bottom:2px solid #000000"align="center"><strong>DATA DASAR RUMAH SAKIT</strong></td>
    <td width="52%" height="20" style="border-bottom:2px solid #000000"><table width="100%" border="0" style="border-collapse:collapse">
      <tr>
        <td colspan="4">&nbsp;</td>
        </tr>
      <tr>
	    <td width="23%">&nbsp;</td>
        <td width="77%" colspan="3" style="border-left:1px solid #000000; border-top:1px solid #000000; border-right:1px solid #000000;"><i> Ditjen Bina Upaya Kesehatan</i></td>
        </tr>
      <tr>
	  	<td>&nbsp;</td>
        <td colspan="3" style="border-left:1px solid #000000; border-bottom:1px solid #000000; border-right:1px solid #000000;"><i> Kementrian Kesehatan RI</i></td>
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
    <td><strong>Tanggal :</strong></td>
    <td><strong>
      <?=$tgl.' '.$arrBln[$bln].' '.$thn?>
    </strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td><strong>1</strong></td>
    <td><strong>Nomor Kode RS</strong></td>
    <td><strong>: 
      <?= $kodeRS?>
    </strong></td>
  </tr>
  <tr>
    <td><strong>2</strong></td>
    <td><strong>Tanggal Registrasi </strong></td>
    <td><strong>: 
      <?= $tglregRS?>
    </strong></td>
  </tr>
  <tr>
    <td><strong>3</strong></td>
    <td><strong>Nama Rumah Sakit (Huruf Kapital) </strong></td>
    <td><strong>: 
      <?= strtoupper($namaRS)?>
    </strong></td>
  </tr>
  <tr>
    <td><strong>4</strong></td>
    <td><strong>Jenis Rumah Sakit</strong></td>
    <td><strong>: <?php echo $jenisRS;?></strong></td>
  </tr>
  <tr>
    <td><strong>5</strong></td>
    <td><strong>Kelas Rumah Sakit</strong></td>
    <td><strong>: <?php echo $kelasRS;?></strong></td>
  </tr>
  <tr>
    <td><strong>6</strong></td>
    <td><strong>Nama Direktur RS</strong></td>
    <td><strong>: <?php echo $direkturRS;?></strong></td>
  </tr>
  <tr>
    <td><strong>7</strong></td>
    <td><strong>Nama Penyelenggara RS</strong></td>
    <td><strong>: 
      <?php $penyelenggaraRS;?>
    </strong></td>
  </tr>
  <tr>
    <td><strong>8</strong></td>
    <td><strong>Alamat / Lokasi RS</strong></td>
    <td><strong>: 
      <?=$alamatRS;?>
    </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>8.1 Kab/Kota</strong></td>
    <td><strong>: 
      <?=$kotaRS;?>
    </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>8.2 Kode Pos </strong></td>
    <td><strong>: 
      <?=$kode_posRS;?>
    </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>8.3 Telepon </strong></td>
    <td><strong>: 
      <?=$tlpRS;?>
    </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>8.4 Fax </strong></td>
    <td><strong>: 
      <?=$faxRS;?>
    </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>8.5 Email </strong></td>
    <td><strong>: 
      <?=$emailRS;?>
    </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>8.6 Nomor Telp Bag. Umum/Humas RS </strong></td>
    <td><strong>: -</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>8.7 Website </strong></td>
    <td><strong>: -</strong></td>
  </tr>
  <tr>
    <td><strong>9</strong></td>
    <td><strong>Luas Rumah Sakit </strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>9.1 Tanah </strong></td>
    <td><strong>: 
      <?=$luas_tnhRS;?>
    </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>9.2 Bangunan </strong></td>
    <td><strong>: 
      <?=$luas_bangunanRS;?>
    </strong></td>
  </tr><tr>
    <td><strong>10</strong></td>
    <td><strong>Surat Izin/Penetapan </strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>10.1 Nomor </strong></td>
    <td><strong>: 
      <?=$ijin_noRS;?>
    </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>10.2 Tanggal </strong></td>
    <td><strong>: 
      <?=$ijin_tglRS;?>
    </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>10.3 Oleh </strong></td>
    <td><strong>: 
      <?=$ijin_olehRS?>
    </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>10.4 Sifat </strong></td>
    <td><strong>: 
      <?=$ijin_sifatRS;?>
    </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>10.5 Masa Berlaku s/d thn </strong></td>
    <td><strong>: - </strong></td>
  </tr>
  <tr>
    <td><strong>11</strong></td>
    <td><strong>Status Penyelenggara Swasta </strong></td>
    <td><strong>: 
      <?=$status_penyelenggaraRS;?>
    </strong></td>
  </tr>
  <tr>
    <td><strong>12</strong></td>
    <td><strong>Akreditasi RS </strong></td>
    <td><strong>: 
      <?=$akreditasiRS;?>
    </strong></td>
  </tr><tr>
    <td>&nbsp;</td>
    <td><strong>12.1 Pentahapan </strong></td>
    <td><strong>: 
      <?=$pentahapanRS;?>
    </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>12.2 Status </strong></td>
    <td><strong>: 
      <?=$akreditasi_stsRS;?>
    </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>12.3 Tanggal </strong></td>
    <td><strong>: 
      <?=$akreditasi_tglRS;?>
    </strong></td>
  </tr><tr>
    <td><strong>13</strong></td>
    <td><strong>Jumlah Tempat Tidur </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>13.1 Perinatalogi </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>13.2 Kelas VVIP </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>13.3 Kelas VIP </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>13.4 Kelas I </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>13.5 Kelas II </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>13.6 Kelas III </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>13.7 ICU </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>13.8 PICU </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>13.9 NICU </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>13.10 HCU </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>13.11 ICCU </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>13.12 Ruang Isolasi </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>13.13 Ruang UGD </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>13.14 Ruang Bersalin </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>13.15 Ruang Operasi </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td><strong>14</strong></td>
    <td><strong>Jumlah Tenaga Medis </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.1 Dokkter Sp.A </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.2 Dokkter Sp.OG</strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.3 Dokter Sp.Pd </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.4 Dokter Sp.B</strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.5 Dokter Sp.Rad </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.6 Dokter Sp.RM </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.7 Dokter Sp.An </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.8 Dokter Sp.JP </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.9 Dokter Sp.M </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.10 Dokter Sp.THT </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.11 Dokter Sp.KJ </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.12 Dokter Sp.P </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.13 Dokter Sp.PK </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.14 Dokter Sp.PD </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.15 Dokter Sp.S </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.16 Dokter Sub Spesialis</strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.17 Dokter Spesialis Lain </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.18 Dokter Umum </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.19 Dokter Gigi </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.20 Dokter Spesialis </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.21 Perawat </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.22 Bidan </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.23 Farmasi </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>14.24 Tenaga Kesehatan Lainnya </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td><strong>15</strong></td>
    <td><strong>Jumlah Tenaga Non Kesehatan </strong></td>
    <td><strong>:</strong></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Telp : Ext </td>
    <td rowspan="6"><table width="100%" border="0">
  <tr>
    <td width="30%"> CP Pengisi </td>
    <td width="40%">&nbsp;</td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr>
    <td> Nama </td>
    <td colspan="2">:</td>
    </tr>
  <tr>
    <td>Jabatan</td>
    <td colspan="2">:</td>
    </tr>
  <tr>
    <td>Email</td>
    <td colspan="2">:</td>
    </tr>
  <tr>
    <td>No Telp </td>
    <td colspan="2">:</td>
    </tr>
  <tr>
    <td>Tanggal</td>
    <td colspan="2">:</td>
    </tr>
</table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Telp / Fax : </td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>

</body>
</html>
