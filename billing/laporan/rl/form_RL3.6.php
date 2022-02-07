<?php
include("../../sesi.php");
include("../../koneksi/konek.php");

	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$waktu = $_POST['cmbWaktu'];
	if($waktu == 'Harian'){
		$tglAwal = explode('-',$_REQUEST['tglAwal2']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$waktu = " and t.tgl = '$tglAwal2' ";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
	}
	else if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];
		$thn = $_POST['cmbThn'];
		$waktu = " and month(t.tgl) = '$bln' and year(t.tgl) = '$thn' ";
		$Periode = "Bulan $arrBln[$bln] Tahun $thn";
	}
	else{
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = " and t.tgl between '$tglAwal2' and '$tglAkhir2' ";
		
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	}
	
	/*
	$qKso = "SELECT id, nama FROM b_ms_kso WHERE id = '".$_REQUEST['StatusPas']."'";
	$rsKso = mysql_query($qKso);
	$rwKso = mysql_fetch_array($rsKso);
	*/
	
		if($_REQUEST['cmbTempatLayanan']!=0){
			$sUnit="select * from b_ms_unit where id=".$_REQUEST['cmbTempatLayanan'];
			$qUnit=mysql_query($sUnit);
			$rwUnit=mysql_fetch_array($qUnit);
			$txtUnit=$rwUnit['nama'];
			$fUnit="AND p.unit_id=".$_REQUEST['cmbTempatLayanan'];
		}else{
			if($_REQUEST['cmbJenisLayanan']==0){
				$txtUnit="RAWAT JALAN - SEMUA";	
				$fUnit="AND p.jenis_kunjungan<>3";
			}
			else{
				$txtUnit="RAWAT INAP - SEMUA";
				$fUnit="AND p.jenis_kunjungan=3";
			}
		}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>RL 3.6</title></head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font:12px tahoma">
  <tr>
    <td width="10%" height="20">&nbsp;</td>
    <td width="50%" height="20"><p>Formulir RL 3.6 </p>
      <p>KEGIATAN PEMBEDAHAN</p></td>
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
    <td>: <input width="400" size="50" style="background:#CCCCCC" value="<?php echo $kodeRS; ?>"></input></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Nama RS</td>
    <td>: <input width="400" size="50" style="background:#CCCCCC" value="<?php echo $namaRS; ?>"></input></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Tempat Layanan</td>
    <td>: <input width="400" size="50" style="background:#CCCCCC" value="<?php echo $txtUnit; ?>"></input></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Periode</td>
    <td>: <input width="400" size="50" style="background:#CCCCCC" value="<?php echo $Periode; ?>"></input></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
   <tr>
    <td colspan="3"><table width="100%" border="1">
	  <tr align="center">
        <td width="3%">NO</td>
        <td width="19%">SPESIALISASI</td>
        <td width="15%">TOTAL</td>
        <td width="15%">KHUSUS</td>
        <td width="15%">BESAR</td>
        <td width="17%">SEDANG</td>
        <td width="16%">KECIL</td>
      </tr>
      <tr align="center" bgcolor="#CCCCCC">
        <td>1</td>
		<td>2</td>
		<td>3</td>
		<td>4</td>
		<td>5</td>
		<td>6</td>
		<td>7</td>
		</tr>
       <?php
	   	$sql="SELECT 
DISTINCT mkt.nama 
FROM b_ms_klasifikasi mk
INNER JOIN b_ms_kelompok_tindakan mkt ON mk.id=mkt.ms_klasifikasi_id
WHERE mk.id IN (36,37,38,39) ORDER BY mkt.nama";
		$queri=mysql_query($sql);
		$no=0;
		$total=0;
		$besar=0;
		$kecil=0;
		$khusus=0;
		$sedang=0;
		while($rows=mysql_fetch_array($queri)){
			$no++;
	   ?>
      <tr>
        <td align="center"><?php echo $no; ?></td>
        <td align="left">&nbsp;<?php echo $rows['nama']; ?></td>
        <?php
		$sOp="SELECT 
		IF(besar=0,'',besar) as besar,
		IF(kecil=0,'',kecil) as kecil,
		IF(khusus=0,'',khusus) as khusus,
		IF(sedang=0,'',sedang) as sedang,
		IF(total=0,'',total) as total 
		FROM
		(SELECT
SUM(IF(mt.klasifikasi_id=36,1,0)) AS besar,
SUM(IF(mt.klasifikasi_id=37,1,0)) AS kecil,
SUM(IF(mt.klasifikasi_id=38,1,0)) AS khusus,
SUM(IF(mt.klasifikasi_id=39,1,0)) AS sedang,
SUM(IF(mt.klasifikasi_id IN (36,37,38,39),1,0)) AS total
FROM b_tindakan t
INNER JOIN b_pelayanan p ON p.id=t.pelayanan_id
INNER JOIN b_ms_tindakan_kelas mtk ON mtk.id=t.ms_tindakan_kelas_id
INNER JOIN b_ms_tindakan mt ON mt.id=mtk.ms_tindakan_id
INNER JOIN b_ms_kelompok_tindakan mkt ON mkt.id=mt.kel_tindakan_id
WHERE mkt.nama='".$rows['nama']."'
$waktu
$fUnit
GROUP BY mkt.nama) AS gab";
//echo $sOp."<br>";
		$qOp=mysql_query($sOp);
		$rwOp=mysql_fetch_array($qOp);
		
		$total=$total+$rwOp['total'];
		$besar=$besar+$rwOp['besar'];
		$kecil=$kecil+$rwOp['kecil'];
		$khusus=$khusus+$rwOp['khusus'];
		$sedang=$sedang+$rwOp['sedang'];
		?>
        <td align="center"><?php echo $rwOp['total']; ?></td>
        <td align="center"><?php echo $rwOp['khusus']; ?></td>
        <td align="center"><?php echo $rwOp['besar']; ?></td>
        <td align="center"><?php echo $rwOp['sedang']; ?></td>
        <td align="center"><?php echo $rwOp['kecil']; ?></td>
        </tr>
        <?php
		}
		?>
	  <tr>
        <td align="center">&nbsp;</td>
        <td align="center">Total </td>
        <td align="center" bgcolor="#999999"><?php echo $total; ?></td>
        <td align="center" bgcolor="#999999"><?php echo $khusus; ?></td>
        <td align="center" bgcolor="#999999"><?php echo $besar; ?></td>
        <td align="center" bgcolor="#999999"><?php echo $sedang; ?></td>
        <td align="center" bgcolor="#999999"><?php echo $kecil; ?></td>
        </tr>
    </table></td>
  </tr>
  </table>
</body>
</html>
