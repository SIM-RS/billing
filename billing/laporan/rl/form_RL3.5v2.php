<?php
session_start();
include("../../sesi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Laporan Kegiatan Perinatologi</title>
</head>

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

?>
<table width="900" border="0" cellpadding="0" cellspacing="0" style="font:12px tahoma">
  <tr>
    <td width="10%" rowspan="2" style="border-bottom:2px solid #000000"><div align="center"><img src="logo-bakti-husada.jpg" width="55" height="70" /></div></td>
    <td height="30" ><strong>Formulir RL 3.5 </strong></td>
    <td width="40%" rowspan="2"style="border-bottom:2px solid #000000"><div align="center"><img src="pojok.png" width="246" height="60" /></div></td>
  </tr>
  <tr>
    <td width="50%" style="border-bottom:2px solid #000000" ><strong>KEGIATAN PERINATOLOGI</strong></td>
  </tr>
   
  <tr>
    <td height="28"><strong>Kode RS</strong></td>
    <td>: <strong><?php echo $kodeRS;?></strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="25"><strong>Nama RS</strong></td>
    <td>: <strong><?php echo $namaRS;?></strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="24" colspan="2"><strong><?php echo $Periode;?></strong></td>
    <td>&nbsp;</td>
  </tr>
  
   <tr>
     <td colspan="3"><table width="100%" border="1" style="border-collapse:collapse;">
       <tr align="center">
         <td width="5%" rowspan="3"><strong>NO</strong></td>
         <td width="30%" rowspan="3"><strong>JENIS KEGIATAN</strong></td>
         <td colspan="8"><strong>RUJUKAN</strong></td>
         <td  rowspan="2" colspan="2"><strong>NON RUJUKAN</strong></td>
         <td width="6%" rowspan="3"><strong>DIRUJUK</strong></td>
       </tr>
       <tr align="center">
         <td colspan="6"><strong>MEDIS</strong></td>
         <td colspan="2"><strong>NON MEDIS</strong></td>
       </tr>
       <tr align="center">
         <td width="6%"><strong>RUMAH</br>
          SAKIT</strong></td>
         <td width="6%"><strong>BIDAN</strong></td>
         <td width="6%"><strong>PUSKES</br>
          MAS</strong></td>
         <td width="6%"><strong>FASKES</br>
          LAINNYA</strong></td>
         <td width="6%"><strong>Jumlah</br>
          Mati</strong></td>
         <td width="6%"><strong>Jumlah</br>
          Total</strong></td>
         <td width="6%"><strong>Jumlah</br>
          Mati</strong></td>
         <td width="6%"><strong>Jumlah</br>
          Total</strong></td>
         <td width="6%"><strong>Jumlah</br>
          Mati</strong></td>
         <td width="6%"><strong>Jumlah</br>
          Total</strong></td>
       </tr>
       
       <tr align="center" bgcolor="#CCCCCC">
         <td><strong>1</strong></td>
         <td><strong>2</strong></td>
         <td><strong>3</strong></td>
         <td><strong>4</strong></td>
         <td><strong>5</strong></td>
         <td><strong>6</strong></td>
         <td><strong>7</strong></td>
         <td><strong>8</strong></td>
         <td><strong>9</strong></td>
         <td><strong>10</strong></td>
         <td><strong>11</strong></td>
         <td><strong>12</strong></td>
         <td><strong>13</strong></td>
       </tr>
		<?php
/*$query="SELECT 
  b_ms_tindakan.nama tindakan,
  COUNT(DISTINCT b_pelayanan.pasien_id) jml 
FROM
  b_pelayanan 
  INNER JOIN b_kunjungan 
    ON b_kunjungan.id = b_pelayanan.kunjungan_id 
  INNER JOIN b_tindakan 
    ON b_tindakan.pelayanan_id = b_pelayanan.id 
  INNER JOIN b_ms_tindakan_kelas 
    ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id 
  INNER JOIN b_ms_tindakan 
    ON b_ms_tindakan.id = b_ms_tindakan_kelas.ms_tindakan_id 
  INNER JOIN b_ms_tindakan_unit 
    ON b_ms_tindakan_unit.ms_tindakan_kelas_id = b_ms_tindakan_kelas.id 
WHERE b_ms_tindakan_unit.ms_unit_id = 12 $waktu
GROUP BY b_ms_tindakan.nama";*/

$query="SELECT 
  b_ms_kia.id,
  b_ms_kia.jenis,
  SUM(IF( b_ms_asal_rujukan.id=13, 1,0)) rs_lain,
  SUM(IF( b_ms_asal_rujukan.id=1, 1,0)) bidan,   
  SUM(IF( b_ms_asal_rujukan.id=11, 1,0)) puskesmas,  
  SUM(IF( b_ms_asal_rujukan.id IN (2,4,6),1,0)) medis_lain,
  SUM(IF( b_ms_asal_rujukan.id IN (3,9),1,0)) lain,
  SUM(IF( b_ms_asal_rujukan.id IN (5,7,8,10,12),1,0)) non_rujuk,
  SUM(IF( b_pasien_keluar.cara_keluar = 'Dirujuk',1,0)) dirujuk
FROM b_kia
    INNER JOIN b_ms_kia 
      ON b_ms_kia.id=b_kia.ms_kia_id 
    INNER JOIN b_kunjungan 
      ON b_kia.kunjungan_id = b_kunjungan.id 
    INNER JOIN b_pelayanan 
      ON b_kia.pelayanan_id = b_pelayanan.id 
    INNER JOIN b_ms_asal_rujukan 
      ON b_ms_asal_rujukan.id = b_kunjungan.asal_kunjungan 
    INNER JOIN b_pasien_keluar 
      ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
 WHERE b_kunjungan.jenis_kunjungan=1 $waktu";
$hasil = mysql_query($query);
$no = 1;
while($data=mysql_fetch_array($hasil))
{
?>		 
		 <tr>
         <td align="center"><?=$no;?></td>
         <td><?=$data['jenis'];?> </td>
         <td><div align="center"><?=$data['rs'];?></div></td>
         <td><div align="center"><?=$data['bidan'];?></div></td>
         <td><div align="center"><?=$data['puskesmas'];?></div></td>
         <td><div align="center"><?=$data['medis_lain'];?></div></td>
         <td><div align="center"></div></td>
		 <?php
		 $jml_rujuk=$data['rs']+$data['bidan']+$data['puskesmas']+$data['medis_lain'];
		 ?>
         <td><div align="center"><?=$jml_rujuk?></div></td>
         <td><div align="center"></div></td>
         <td><div align="center"><?=$data['lain'];?></div></td>
         <td><div align="center"></div></td>
         <td><div align="center"><?=$data['non_rujuk'];?></div></td>
         <td><div align="center"><?=$data['dirujuk'];?></div></td>
       </tr>
	   <?php
	   $no++;
	   $tot_rs=$data['rs']+$tot_rs;
	   $tot_bidan=$data['bidan']+$tot_bidan;
	   $tot_pus=$data['puskesmas']+$tot_pus;
	   $tot_mlain=$data['medis_lain']+$tot_mlain;
	   $tot_jml=$jml_rujuk+$tot_jml;
	   $tot_lain=$data['lain']+$tot_lain;
	   $tot_nonrujuk=$data['non_rujuk']+$tot_nonrujuk;
	   $tot_dirujuk=$data['dirujuk']+$tot_dirujuk;
	   	   
	   }
	   ?>
	   <tr>
         <td colspan="2" align="center"><strong>Total</strong></td>
         <td bgcolor="#999999"><div align="center">
<?=$tot_rs?></div></td>
         <td bgcolor="#999999"><div align="center">
           <?=$tot_bidan?>
         </div></td>
         <td bgcolor="#999999"><div align="center">
           <?=$tot_pus?>
         </div></td>
         <td bgcolor="#999999"><div align="center">
           <?=$tot_mlain?>
         </div></td>
         <td bgcolor="#999999"><div align="center"></div></td>
         <td bgcolor="#999999"><div align="center">
           <?=$tot_jml?>
         </div></td>
         <td bgcolor="#999999"><div align="center"></div></td>
         <td bgcolor="#999999"><div align="center">
           <?=$tot_lain?>
         </div></td>
         <td bgcolor="#999999"><div align="center"></div></td>
         <td bgcolor="#999999"><div align="center">
           <?=$tot_nonrujuk?></div></td>
         <td bgcolor="#999999"><div align="center">
           <?=$tot_dirujuk?>
         </div></td>
       </tr>
     </table></td>
   </tr>
    <tr id="trTombol">
      <td class="noline" align="center" colspan="3">&nbsp;</td>
    </tr>
    <tr id="trTombol">
                <td class="noline" align="center" colspan="3">
                    <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));" />
                    <input id="btnTutup" type="button" value="Tutup" onClick="window.close();" />                </td>
    </tr>
</table>

</body>
        <script type="text/JavaScript">

        function cetak(tombol){
            tombol.style.visibility='collapse';           
           
            if(tombol.style.visibility=='collapse'){
               
                /*try{
			mulaiPrint();
		}
		catch(e){*/
			window.print();
			//window.close();
		//}
                    
            }
        }
        </script>
</html>