<?php
session_start();
include("../../sesi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {
	font-size: 14px;
	font-weight: bold;
}
-->
</style>
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
	//$waktu = 'Harian';
	if($waktu == 'Harian'){
		$tglAwal = explode('-',$_REQUEST['tglAwal2']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$waktu = " AND b_pelayanan.tgl = '$tglAwal2' ";
		$Periode = "Tanggal ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
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
		
		$Periode = "Periode ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
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
<table width="700" border="0" style="border-collapse:collapse; font:12px arial">
  <tr>
    <td><table width="100%" border="0" style="border-collapse:collapse">
      <tr>
        <td width="9%" rowspan="3" style="border-bottom:2px solid #000000"><img src="logo-bakti-husada.jpg" width="55" height="60" /></td>
        <td width="59%" height="18"><span class="style1">Formulir RL 3.15 </span></td>
        <td width="32%" rowspan="3" style="border-bottom:2px solid #000000"><img src="pojok.png" /></td>
      </tr>
      <tr>
        <td height="18" ><span class="style1">Cara Bayar </span></td>
        </tr>
      <tr>
        <td height="22" style="border-bottom:2px solid #000000"><span class="style1"><?php echo $txtJenis.' '.$txtTempat; ?> </span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="11%"><strong>Kode RS </strong></td>
        <td width="2%"><strong>:</strong></td>
        <td width="87%"><strong><?=$kodeRS?></strong></td>
      </tr>
      <tr>
        <td><strong>Nama RS </strong></td>
        <td><strong>:</strong></td>
        <td><strong><?=$namaRS?></strong></td>
      </tr>
      
      <tr>
        <td colspan="3"><strong><?php echo $Periode; ?></strong></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="1" style="border-collapse:collapse">
      <tr>
        <td width="5%" rowspan="2"><div align="center"><strong>No.  </strong></div></td>
        <td width="35%" rowspan="2"><div align="center"><strong>DESKRIPSI</strong></div></td>
        <td colspan="2"><div align="center"><strong>PASIEN RAWAT INAP </strong></div></td>
        <td width="10%" rowspan="2"><div align="center"><strong>JUMLAH PASIEN RAWAT JALAN </strong></div></td>
        <td colspan="3"><div align="center"><strong>JUMLAH PASIEN RAWAT JALAN </strong></div></td>
        </tr>
      <tr>
        <td width="10%"><div align="center"><strong>JUMLAH PASIEN KELUAR </strong></div></td>
        <td width="10%"><div align="center"><strong>JUMLAH LAMA RAWAT JALAN </strong></div></td>
        <td width="10%"><div align="center"><strong>LABOLATORIUM</strong></div></td>
        <td width="10%"><div align="center"><strong>RADIOLOGI</strong></div></td>
        <td width="10%"><div align="center"><strong>LAIN-LAIN</strong></div></td>
      </tr>
      <tr bgcolor="#CCCCCC">
        <td><div align="center"><strong>1</strong></div></td>
        <td><div align="center"><strong>2</strong></div></td>
        <td><div align="center"><strong>3</strong></div></td>
        <td><div align="center"><strong>4</strong></div></td>
        <td width="10%"><div align="center"><strong>5</strong></div></td>
        <td width="10%"><div align="center"><strong>6</strong></div></td>
        <td width="10%"><div align="center"><strong>7</strong></div></td>
        <td width="10%"><div align="center"><strong>8</strong></div></td>
        </tr>
<?php					

$sql="SELECT DISTINCT b_ms_kso.nama nama, 
SUM(IF(b_ms_unit.inap=1 AND b_kunjungan.pulang=1,1,0)) pulang,
SUM(IF(b_ms_unit.inap=1 AND b_kunjungan.pulang<>1,1,0)) tinggal,
SUM(IF(b_ms_unit.inap=1,1,0)) inap,
SUM(IF(b_ms_unit.inap=0,1,0)) jalan,
SUM(IF(b_ms_unit.inap=0 AND b_ms_unit.parent_id=57,1,0)) lab,
SUM(IF(b_ms_unit.inap=0 AND b_ms_unit.parent_id=60,1,0)) rad,
SUM(IF(b_ms_unit.inap=0 AND b_ms_unit.parent_id NOT IN (57,60),1,0)) lain
FROM b_ms_kso
INNER JOIN b_pelayanan ON b_pelayanan.kso_id=b_ms_kso.id
INNER JOIN b_kunjungan ON b_kunjungan.id=b_pelayanan.kunjungan_id
INNER JOIN b_ms_unit ON b_ms_unit.id=b_kunjungan.unit_id
WHERE b_ms_kso.aktif = 1 $waktu
GROUP BY b_ms_kso.id";
$hasil = mysql_query($sql); //echo $sql;
$no = 1;
while($data=mysql_fetch_array($hasil))
{
?>		
      <tr>
        <td><div align="center">
          <?=$no;?>
        </div></td>
        <td><?=$data['nama'];?></td>
        <td><div align="center">
          <?=$data['pulang'];?>
        </div></td>
        <td><div align="center">
          <?=$data['lama'];?>
        </div></td>
        <td><div align="center">
          <?=$data['jalan'];?>
        </div></td>
        <td><div align="center">
          <?=$data['lab'];?>
        </div></td>
        <td><div align="center">
          <?=$data['rad'];?>
        </div></td>
        <td><div align="center">
          <?=$data['lain'];?>
        </div></td>
      </tr>
<?php
$totpulang = $data['pulang']+$totpulang;
$totlama = $data['lama']+$totlama;
$totjalan = $data['jalan']+$totjalan;
$totlab = $data['lab']+$totlab;
$totrad = $data['rad']+$totrad;
$totlain = $data['lain']+$totlain;
$no++;
}
?>
      <tr>
        <td colspan="2"><strong>TOTAL</strong></td>
        <td bgcolor="#CCCCCC"> <div align="center"><strong>
          <?=$totpulang;?>
        </strong></div></td>
        <td bgcolor="#CCCCCC"> <div align="center"><strong>
          <?=$totlama;?>
        </strong></div></td>
        <td bgcolor="#CCCCCC"> <div align="center"><strong>
          <?=$totjalan;?>
        </strong></div></td>
        <td bgcolor="#CCCCCC"> <div align="center"><strong>
          <?=$totlab;?>
        </strong></div></td>
        <td bgcolor="#CCCCCC"> <div align="center"><strong>
          <?=$totrad;?>
        </strong></div></td>
        <td bgcolor="#CCCCCC"> <div align="center"><strong>
          <?=$totlain;?>
        </strong></div></td>
        </tr>      
    </table></td>
  </tr>
    <tr id="trTombol">
                <td class="noline" align="center">
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
