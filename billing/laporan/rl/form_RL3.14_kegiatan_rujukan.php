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
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = " and b_pelayanan.tgl between '$tglAwal2' and '$tglAkhir2' ";
		
		$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	}
	
	$qKso = "SELECT id, nama FROM b_ms_kso WHERE id = '".$_REQUEST['StatusPas']."'";
	$rsKso = mysql_query($qKso);
	$rwKso = mysql_fetch_array($rsKso);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>RL 3.14</title>
</head>
<body>
<center>
<table width="943" style="border-collapse:collapse;border:1px solid #000">
  <tr>
    <th width="15" scope="col">&nbsp;</th>
    <th width="26" scope="col">&nbsp;</th>
    <th width="96" scope="col">&nbsp;</th>
    <th width="18" scope="col">&nbsp;</th>
    <th width="54" scope="col">&nbsp;</th>
    <th width="54" scope="col">&nbsp;</th>
    <th width="54" scope="col">&nbsp;</th>
    <th width="113" scope="col">&nbsp;</th>
    <th width="96" scope="col">&nbsp;</th>
    <th width="53" scope="col">&nbsp;</th>
    <th width="53" scope="col">&nbsp;</th>
    <th width="53" scope="col">&nbsp;</th>
    <th width="53" scope="col">&nbsp;</th>
    <th width="53" scope="col">&nbsp;</th>
    <th width="61" scope="col">&nbsp;</th>
    <th width="23" scope="col">&nbsp;</th>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="7" rowspan="2"><div align="center"><strong>KEGIATAN RUJUKAN</strong></div></td>
    <td colspan="7" rowspan="2" style="border:#000 1px solid;border-collapse:collapse;">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="16" style="border-top:1px solid #000">&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><strong>Kode RS</strong></td>
    <td><strong>:</strong></td>
    <td colspan="4">&nbsp;<?php echo $kodeRS; ?></td>
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
    <td>&nbsp;</td>
    <td colspan="2"><strong>Nama RS</strong></td>
    <td><strong>:</strong></td>
    <td colspan="4">&nbsp;<?php echo $namaRS; ?></td>
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
  	<td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="7"><strong><?php echo $Periode; ?></strong></td>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
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
    <td>&nbsp;</td>
    <td colspan="14" rowspan="12"><table width="1215" border="1" style="border-collapse:collapse;">
      <tr>
        <th width="39" rowspan="2" scope="col">NO</th>
        <th width="151" rowspan="2" scope="col">JENIS SPESIALISASI</th>
        <th colspan="6" scope="col">RUJUKAN</th>
        <th colspan="3" scope="col">DIRUJUK</th>
        </tr>
      <tr>
        <th width="137" scope="col">DITERIMA DARI PUSKESMAS</th>
        <th width="133" scope="col">DITERIMA DARI<br />
          FASILITAS KES. LAIN</th>
        <th width="77" scope="col">DITERIMA DARI RS. LAIN</th>
        <th width="97" scope="col">DIKEMBALIKAN KE PUSKESMAS</th>
        <th width="101" scope="col">DIKEMBALIKAN KE FASILITAS KES. LAIN</th>
        <th width="74" scope="col">DIKEMBAIKAN KE RS ASAL</th>
        <th width="135" scope="col">PASIEN RUJUKAN</th>
        <th width="97" scope="col">PASIEN DATANG SENDIRI</th>
        <th width="104" scope="col">DITERIMA KEMBALI</th>
        </tr>
      <tr>
        <td bgcolor="#CCCCCC"><div align="center">1</div></td>
        <td bgcolor="#CCCCCC"><div align="center">2</div></td>
        <td bgcolor="#CCCCCC"><div align="center">3</div></td>
        <td bgcolor="#CCCCCC"><div align="center">4</div></td>
        <td bgcolor="#CCCCCC"><div align="center">5</div></td>
        <td bgcolor="#CCCCCC"><div align="center">6</div></td>
        <td bgcolor="#CCCCCC"><div align="center">7</div></td>
        <td bgcolor="#CCCCCC"><div align="center">8</div></td>
        <td bgcolor="#CCCCCC"><div align="center">9</div></td>
        <td bgcolor="#CCCCCC"><div align="center">10</div></td>
        <td bgcolor="#CCCCCC"><div align="center">11</div></td>
        </tr>
      <?php
	  	if($_REQUEST['cmbTempatLayanan']!=0){
			$qTmp = "SELECT b_ms_unit.id, b_ms_unit.nama FROM b_ms_unit 
							WHERE b_ms_unit.id = '".$_REQUEST['cmbTempatLayanan']."'";
			$rsTmp = mysql_query($qTmp);
		}else{
			$qTmp = "SELECT b_ms_unit.id, b_ms_unit.nama FROM b_ms_unit 
							WHERE b_ms_unit.inap = '".$_REQUEST['cmbJenisLayanan']."' and aktif=1 and kategori=2 and level=2 order by nama";
			$rsTmp = mysql_query($qTmp);
		}
		
		$no=0;
		$tTerPus=0;
		$tTerFaskes=0;
		$tTerRS=0;
		$tKemPus=0;
		$tKemFaskes=0;
		$tKemRSPus=0;
		while($rwUnit=mysql_fetch_array($rsTmp)){
			$no++;
	  ?>
      <tr>
        <td><div align="center"><?php echo $no; ?></div></td>
        <td><?php echo $rwUnit['nama']; ?></td>
        <?php		
		$qJml = "SELECT 
IF(diterima_pus=0,'',diterima_pus) AS diterima_pus,
IF(diterima_faskes=0,'',diterima_faskes) AS diterima_faskes,
IF(diterima_rs=0,'',diterima_rs) AS diterima_rs,
IF(dikembalikan_pus=0,'',dikembalikan_pus) AS dikembalikan_pus,
IF(dikembalikan_faskes=0,'',dikembalikan_faskes) AS dikembalikan_faskes,
IF(dikembalikan_rs=0,'',dikembalikan_rs) AS dikembalikan_rs
FROM 
(SELECT 
  SUM(IF(b_kunjungan.asal_kunjungan = 11,1,0)) AS diterima_pus,
  SUM(IF(b_kunjungan.asal_kunjungan IN (3,7,8,10,12),1,0)) AS diterima_faskes,
  SUM(IF(b_kunjungan.asal_kunjungan = 13,1,0)) AS diterima_rs,
  SUM(IF(b_kunjungan.asal_kunjungan = 0,1,0)) AS dikembalikan_pus,
  SUM(IF(b_kunjungan.asal_kunjungan = 0,1,0)) AS dikembalikan_faskes,
  SUM(IF(b_kunjungan.asal_kunjungan = 0,1,0)) AS dikembalikan_rs
FROM
  b_kunjungan 
  INNER JOIN b_pelayanan 
    ON b_pelayanan.kunjungan_id = b_kunjungan.id 
WHERE b_pelayanan.unit_id = '".$rwUnit['id']."' $fKso $waktu) as gab";
		//echo $qJml."<br>";
		$rsJml = mysql_query($qJml);
		$rwJml = mysql_fetch_array($rsJml);
		
		$tTerPus=$tTerPus+$rwJml['diterima_pus'];
		$tTerFaskes=$tTerFaskes+$rwJml['diterima_faskes'];
		$tTerRS=$tTerRS+$rwJml['diterima_rs'];
		$tKemPus=$tKemPus+$rwJml['dikembalikan_pus'];
		$tKemFaskes=$tKemFaskes+$rwJml['dikembalikan_faskes'];
		$tKemRSPus=$tKemRSPus+$rwJml['dikembalikan_rs'];
		?>
        <td align="center"><?php echo $rwJml['diterima_pus']; ?></td>
        <td align="center"><?php echo $rwJml['diterima_faskes']; ?></td>
        <td align="center"><?php echo $rwJml['diterima_rs']; ?></td>
        <td align="center"><?php echo $rwJml['dikembalikan_pus']; ?></td>
        <td align="center"><?php echo $rwJml['dikembalikan_faskes']; ?></td>
        <td align="center"><?php echo $rwJml['dikembalikan_rs']; ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
        <?php
		}
		?>
      <tr>
        <td><div align="center">&nbsp;</div></td>
        <td>TOTAL</td>
        <td bgcolor="#999999" align="center"><?php echo $tTerPus; ?></td>
        <td bgcolor="#999999" align="center"><?php echo $tTerFaskes; ?></td>
        <td bgcolor="#999999" align="center"><?php echo $tTerRS; ?></td>
        <td bgcolor="#999999" align="center"><?php echo $tKemPus; ?></td>
        <td bgcolor="#999999" align="center"><?php echo $tKemFaskes; ?></td>
        <td bgcolor="#999999" align="center"><?php echo $tKemRSPus; ?></td>
        <td bgcolor="#999999" align="center">&nbsp;</td>
        <td bgcolor="#999999" align="center">&nbsp;</td>
        <td bgcolor="#999999">&nbsp;</td>
        </tr>
    </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</center>
</body>
</html>