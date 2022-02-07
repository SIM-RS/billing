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
<table width="700" border="0" style="border-collapse:collapse; font:12px arial">
  <tr>
    <td><table width="100%" border="0" style="border-collapse:collapse">
      <tr>
        <td width="9%" rowspan="3" style="border-bottom:2px solid #000000"><img src="logo-bakti-husada.jpg" width="55" height="60" /></td>
        <td width="59%" height="18"><span class="style1">Formulir RL 5.4 </span></td>
        <td width="32%" rowspan="3" style="border-bottom:2px solid #000000"><img src="pojok.png" /></td>
      </tr>
	  <tr>
        <td height="18" ><span class="style1">Daftar 10 Besar Penyakit </span></td>
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
        <td colspan="3"><strong><?=$Periode?>
        </strong></td>
        </tr>
      
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="1" style="border-collapse:collapse">
      <tr>
        <td width="10%" rowspan="2"><div align="center"><strong>No. Urut </strong></div></td>
        <td width="10%" rowspan="2"><div align="center"><strong>KODE ICD 10 </strong></div></td>
        <td width="40%" rowspan="2"><div align="center"><strong>DESKRIPSI</strong></div></td>
        <td colspan="2" width="10%"><div align="center"><strong>KASUS BARU MENURUT JENIS KELAMIN</strong></div></td>
        <td width="10%" rowspan="2"><div align="center"><strong>Jumlah Kasus Baru (4+5) </strong></div></td>
        <td width="10%" rowspan="2"><div align="center"><strong>Jumlah Kunjungan </strong></div></td>
        </tr>
      <tr>
        <td width="10%"><div align="center"><strong>Laki-Laki</strong></div></td>
        <td width="10%"><div align="center"><strong>Perempuan</strong></div></td>
        </tr>
      <tr bgcolor="#CCCCCC">
        <td><div align="center"><strong>1</strong></div></td>
        <td><div align="center"><strong>2</strong></div></td>
        <td><div align="center"><strong>3</strong></div></td>
        <td><div align="center"><strong>4</strong></div></td>
        <td><div align="center"><strong>5</strong></div></td>
        <td><div align="center"><strong>6</strong></div></td>
        <td><div align="center"><strong>7</strong></div></td>
        </tr>
<?php
			
$sql="SELECT 
b_diagnosa.diagnosa_id id,
b_ms_diagnosa.kode kode,
b_ms_diagnosa.nama nama,
SUM(IF(b_ms_pasien.sex = 'L' AND b_diagnosa.kasus_baru=1, 1, 0)) cow,
SUM(IF(b_ms_pasien.sex = 'P' AND b_diagnosa.kasus_baru=1, 1, 0)) cew,
COUNT(DISTINCT b_pelayanan.pasien_id) AS jml
FROM b_ms_diagnosa
INNER JOIN b_diagnosa ON b_ms_diagnosa.id = b_diagnosa.ms_diagnosa_id
INNER JOIN b_pelayanan ON b_pelayanan.id = b_diagnosa.pelayanan_id
INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id
INNER JOIN b_ms_pasien ON b_ms_pasien.id=b_pelayanan.pasien_id
WHERE  b_diagnosa.primer=1 $fUnit $waktu GROUP BY b_ms_diagnosa.id
ORDER BY jml DESC, nama LIMIT 10";
$hasil = mysql_query($sql); //echo $sql;
$no = 1;
while($data=mysql_fetch_array($hasil))
{
?>		
      <tr>
        <td><div align="center"><?=$no;?></div></td>
        <td><div align="center">
          <?=$data['kode'];?>
        </div></td>
        <td><?=$data['nama'];?></td>
        <td>
          <div align="center">
            <?=$data['cow'];?>
            </div></td>
        <td>
          <div align="center">
            <?=$data['cew'];?>
            </div></td>
		<?php
		$tot = $data['cow']+$data['cew'];
		?>
        <td>
          <div align="center">
            <?=$tot;?>
            </div></td>
        <td>
          <div align="center">
            <?=$data['jml'];?>
            </div></td>
        </tr>
<?php
$no++;
}
?>
      
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