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
<table width="700" border="0" style="border-collapse:collapse; font:12px arial">
  <tr>
    <td><table width="100%" border="0" style="border-collapse:collapse">
      <tr>
        <td width="9%" rowspan="2" style="border-bottom:2px solid #000000"><img src="logo-bakti-husada.jpg" width="55" height="60" /></td>
        <td width="59%" height="30"><span class="style1">Formulir RL 5.4 </span></td>
        <td width="32%" rowspan="2" style="border-bottom:2px solid #000000"><img src="pojok.png" /></td>
      </tr>
      <tr>
        <td height="30" style="border-bottom:2px solid #000000"><span class="style1">Daftar 10 Besar Penyakit Rawat Jalan </span></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="11%"><strong>Kode RS </strong></td>
        <td width="2%"><strong>:</strong></td>
        <td width="87%">&nbsp;</td>
      </tr>
      <tr>
        <td><strong>Nama RS </strong></td>
        <td><strong>:</strong></td>
        <td><?=$namaRS?></td>
      </tr>
      <tr>
        <td><strong>Bulan</strong></td>
        <td><strong>:</strong></td>
        <td><?=$arrBln[$bln]?></td>
      </tr>
      <tr>
        <td><strong>Tahun</strong></td>
        <td><strong>:</strong></td>
        <td><?=$thn?></td>
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
					if($_REQUEST['StatusPas']!=0)
						$fKso = " AND b_pelayanan.kso_id = ".$_REQUEST['StatusPas'];
					if($_REQUEST['cmbTempatLayananM']==0){
						if($_REQUEST['cmbJenisLayananM']=='0'){
							$fUnit = " b_pelayanan.jenis_kunjungan<>3";
						}
						else if($_REQUEST['cmbJenisLayananM']=='1'){
							$fUnit = " b_pelayanan.jenis_kunjungan=3";
						}
					}else{
						$fUnit = " b_ms_unit.id = '".$_REQUEST['cmbTempatLayananM']."' ";
					}
					
$sql="SELECT 
b_ms_diagnosa.kode kode,
b_ms_diagnosa.nama nama,
SUM(IF(b_ms_pasien.sex='L',1,0)) cow,
SUM(IF(b_ms_pasien.sex='P',1,0)) cew,
((SUM(IF(b_ms_pasien.sex = 'L', 1, 0))) + (SUM(IF(b_ms_pasien.sex = 'P', 1, 0)))) tot,  
SUM(b_kunjungan.id) kunj
FROM b_ms_pasien 
INNER JOIN b_pelayanan  ON b_pelayanan.pasien_id=b_ms_pasien.id
INNER JOIN b_kunjungan ON b_kunjungan.id=b_pelayanan.kunjungan_id
INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id
INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id=b_diagnosa_rm.ms_diagnosa_id
WHERE $fUnit $waktu
GROUP BY b_ms_diagnosa.nama
ORDER BY tot DESC"; //echo $sql;
$hasil = mysql_query($sql);
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
		$jml = $data['cow']+$data['cew'];
		?>
        <td>
          <div align="center">
            <?=$jml;?>
            </div></td>
        <td>
          <div align="center">
            <?=$data['kunj'];?>
            </div></td>
        </tr>
<?php
$no++;
}
?>
      
    </table></td>
  </tr>
</table>

</body>
</html>
