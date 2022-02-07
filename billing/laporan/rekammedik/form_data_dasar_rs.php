<?php
session_start();
include("../../sesi.php");
?>
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
	
	$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayanan']."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
	
	$qKso = "SELECT id, nama FROM b_ms_kso WHERE id = '".$_REQUEST['StatusPas']."'";
	$rsKso = mysql_query($qKso);
	$rwKso = mysql_fetch_array($rsKso);
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font:12px tahoma">
  <tr>
    <td width="10%" height="20"><img src="logo-bakti-husada.jpg" width="55" height="60" /></td>
    <td width="50%" height="20" align="center"><strong>DATA DASAR RUMAH SAKIT</strong></td>
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
    <td>Tanggal :</td>
    <td><?=$periode;?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td>1</td>
    <td>Nomor Kode RS</td>
    <td>: <?php ?></td>
  </tr>
  <tr>
    <td>2</td>
    <td>Tanggal Registrasi </td>
    <td>: <?php ?></td>
  </tr>
  <tr>
    <td>3</td>
    <td>Nama Rumah Sakit (Huruf Kapital) </td>
    <td>: <?=$qr1['nama'];?></td>
  </tr>
  <tr>
    <td>4</td>
    <td>Jenis Rumah Sakit</td>
    <td>: <?php ?></td>
  </tr>
  <tr>
    <td>5</td>
    <td>Kelas Rumah Sakit</td>
    <td>: <?php ?></td>
  </tr>
  <tr>
    <td>6</td>
    <td>Nama Direktur RS</td>
    <td>: <?php ?></td>
  </tr>
  <tr>
    <td>7</td>
    <td>Nama Penyelenggara RS</td>
    <td>: <?php ?></td>
  </tr>
  <tr>
    <td>8</td>
    <td>Alamat / Lokasi RS</td>
    <td>: <?=$qr1['alamat'];?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>8.1 Kab/Kota</td>
    <td>: <?=$qr1['kota'];?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>8.2 Kode Pos </td>
    <td>: <?=$qr1['kode_pos'];?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>8.3 Telepon </td>
    <td>: <?=$qr1['no_tlp'];?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>8.4 Fax </td>
    <td>: <?=$qr1['fax'];?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>8.5 Email </td>
    <td>: <?=$qr1['email'];?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>8.6 Nomor Telp Bag. Umum/Humas RS </td>
    <td>: <?=$qr1['no_tlp'];?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>8.7 Website </td>
    <td>: </td>
  </tr>
  <tr>
    <td>9</td>
    <td>Luas Rumah Sakit </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>9.1 Tanah </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>9.2 Bangunan </td>
    <td>:</td>
  </tr><tr>
    <td>10</td>
    <td>Surat Izin/Penetapan </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>10.1 Nomor </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>10.2 Tanggal </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>10.3 Oleh </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>10.4 Sifat </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>10.5 Masa Berlaku s/d thn </td>
    <td>:</td>
  </tr>
  <tr>
    <td>11</td>
    <td>Status Penyelenggara Swasta </td>
    <td>:</td>
  </tr>
  <tr>
    <td>12</td>
    <td>Akreditasi RS </td>
    <td>:</td>
  </tr><tr>
    <td>&nbsp;</td>
    <td>12.1 Pentahapan </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>12.2 Status </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>12.3 Tanggal </td>
    <td>:</td>
  </tr><tr>
    <td>13</td>
    <td>Jumlah Tempat Tidur </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>13.1 Perinatalogi </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>13.2 Kelas VVIP </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>13.3 Kelas VIP </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>13.4 Kelas I </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>13.5 Kelas II </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>13.6 Kelas III </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>13.7 ICU </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>13.8 PICU </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>13.9 NICU </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>13.10 HCU </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>13.11 ICCU </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>13.12 Ruang Isolasi </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>13.13 Ruang UGD </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>13.14 Ruang Bersalin </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>13.15 Ruang Operasi </td>
    <td>:</td>
  </tr>
  <tr>
    <td>14</td>
    <td>Jumlah Tenaga Medis </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>14.1 Dokkter Sp.A </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>14.2 Dokkter Sp.OG</td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>14.3 Dokter Sp.Pd </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>14.4 Dokter Sp.B</td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>14.5 Dokter Sp.Rad </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>14.6 Dokter Sp.RM </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>14.7 Dokter Sp.An </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>14.8 Dokter Sp.JP </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>14.9 Dokter Sp.M </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>14.10 Dokter Sp.THT </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>14.11 Dokter Sp.KJ </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>14.12 Dokter Sp.P </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>14.13 Dokter Sp.PK </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>14.14 Dokter Sp.PD </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>14.15 Dokter Sp.S </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>14.16 Dokter Sub Spesialis</td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>14.17 Dokter Spesialis Lain </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>14.18 Dokter Umum </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>14.19 Dokter Gigi </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>14.20 Dokter Spesialis </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>14.21 Perawat </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>14.22 Bidan </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>14.23 Farmasi </td>
    <td>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>14.24 Tenaga Kesehatan Lainnya </td>
    <td>:</td>
  </tr>
  <tr>
    <td>15</td>
    <td>Jumlah Tenaga Non Kesehatan </td>
    <td>:</td>
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
