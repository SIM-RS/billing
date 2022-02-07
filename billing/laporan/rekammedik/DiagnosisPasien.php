<?php
include("../../sesi.php");

if($_POST['isExcel']=='yes'){
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="DiagnosisPasien.xls"');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Diagnosis Pasien</title>
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
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);
	
	$sqlKso = "SELECT id,nama from b_ms_kso where id = '".$_REQUEST['StatusPas']."'";
	$rsKso = mysql_query($sqlKso);
	$rwKso = mysql_fetch_array($rsKso);
?>
<table width="800" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td colspan="4"><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
  </tr>
  <tr>
    <td colspan="4" align="center" height="70" valign="top" style="font-size:14px; text-transform:uppercase"><b>Laporan Diagnosis Pasien <?php echo $rwUnit1['nama'] ?> -  <?php if($rwUnit2['nama']=="") echo 'Semua'; else echo $rwUnit2['nama'] ?><br /><?php echo $Periode;?></b></td>
  </tr>
  <tr><td colspan="4" height="30"><b>Penjamin Pasien: <?php if($rwKso['id']==0) echo "Semua"; else echo $rwKso['nama'];?></b></td>
  <tr style="font-weight:bold;">
    <td width="5%" height="28" style="font-size:12px; border-top:1px solid; border-bottom:1px solid;">&nbsp;No</td>
    <td width="10%" style="font-size:12px; border-top:1px solid; border-bottom:1px solid;">&nbsp;ICD X</td>
    <td width="65%" style="font-size:12px; border-top:1px solid; border-bottom:1px solid;">&nbsp;Diagnosis</td>
    <td width="20%" style="font-size:12px; border-top:1px solid; border-bottom:1px solid;">Jumlah&nbsp;</td>
  </tr>
   <?php
  		if($_REQUEST['StatusPas']!=0)
			$fKso = " AND b_kunjungan.kso_id = ".$_REQUEST['StatusPas'];
		if($_REQUEST['TmpLayanan']==0){
			$fUnit = " b_pelayanan.jenis_layanan = '".$_REQUEST['JnsLayanan']."'";
		}else{
			$fUnit = " b_pelayanan.unit_id = '".$_REQUEST['TmpLayanan']."' ";
		}
		
		/* echo $sqlDiag = "SELECT b_ms_diagnosa.nama, b_ms_diagnosa.kode,
					COUNT(DISTINCT b_pelayanan.pasien_id) AS jml
					FROM b_ms_diagnosa
					INNER JOIN b_diagnosa_rm ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id
					INNER JOIN b_pelayanan ON b_pelayanan.id = b_diagnosa_rm.pelayanan_id
					INNER JOIN b_kunjungan ON b_kunjungan.id = b_pelayanan.kunjungan_id
					WHERE $fUnit $fKso $waktu  AND b_diagnosa_rm.primer=1 GROUP BY b_ms_diagnosa.id
					ORDER BY jml DESC"; */
					
		/* $sqlDiag = "SELECT 
					  t2.kode_rm kode,
					  GROUP_CONCAT(t2.nama SEPARATOR '<br/>- ') nama,
					  SUM(jml) jml 
					FROM
					  (
					  SELECT t1.m_d_rm, t1.kode_rm, IFNULL(t1.nama_dokter,t1.m_dokter) nama, COUNT(t1.m_d_rm) jml 
					  FROM
						(SELECT 
							dr.ms_diagnosa_id m_d_rm,
							d.diagnosa_id id_d_dokter,
							d.ms_diagnosa_id m_d_dokter,
							md_rm.kode kode_rm,
							d.diagnosa_manual m_dokter,
							md_dokter.nama nama_dokter
						  FROM
							b_diagnosa_rm dr 
							INNER JOIN b_diagnosa d 
							  ON d.diagnosa_id = dr.diagnosa_id 
							LEFT JOIN b_ms_diagnosa md_rm 
							  ON md_rm.id = dr.ms_diagnosa_id 
							LEFT JOIN b_ms_diagnosa md_dokter 
							  ON md_dokter.id = d.ms_diagnosa_id 
							INNER JOIN b_pelayanan 
							  ON b_pelayanan.id = dr.pelayanan_id 
							INNER JOIN b_kunjungan 
							  ON b_kunjungan.id = b_pelayanan.kunjungan_id 
						  WHERE $fUnit $fKso $waktu
							AND dr.primer = 1 
						  GROUP BY dr.ms_diagnosa_id, b_pelayanan.pasien_id
						  ORDER BY dr.ms_diagnosa_id) t1
						GROUP BY t1.m_d_rm,
							t1.m_dokter,
							t1.nama_dokter					  
					  ) AS t2
					GROUP BY t2.m_d_rm
					ORDER BY jml DESC"; */
					
		$sqlDiag = "SELECT 
					  t1.kode_rm kode,
					  CONCAT_WS('<br/> - ', GROUP_CONCAT(t1.nama_dokter SEPARATOR '<br/> - '),
											GROUP_CONCAT(t1.m_dokter SEPARATOR '<br/> - ')) nama,
					  SUM(jml) jml 
					FROM
					  (SELECT 
						dr.ms_diagnosa_id m_d_rm,
						d.diagnosa_id id_d_dokter,
						d.ms_diagnosa_id m_d_dokter,
						md_rm.kode kode_rm,
						d.diagnosa_manual m_dokter,
						md_dokter.nama nama_dokter,
						COUNT(DISTINCT b_pelayanan.pasien_id) jml  
					  FROM
						b_diagnosa_rm dr 
						INNER JOIN b_diagnosa d 
						  ON d.diagnosa_id = dr.diagnosa_id 
						LEFT JOIN b_ms_diagnosa md_rm 
						  ON md_rm.id = dr.ms_diagnosa_id 
						LEFT JOIN b_ms_diagnosa md_dokter 
						  ON md_dokter.id = d.ms_diagnosa_id 
						INNER JOIN b_pelayanan
						  ON b_pelayanan.id = dr.pelayanan_id 
						INNER JOIN b_kunjungan
						  ON b_kunjungan.id = b_pelayanan.kunjungan_id 
					  WHERE $fUnit $fKso $waktu 
						AND dr.primer = 1 
					  GROUP BY dr.ms_diagnosa_id,
						d.diagnosa_manual,
						md_dokter.nama 
					  ORDER BY m_d_rm) AS t1 
					GROUP BY t1.m_d_rm
					ORDER BY jml DESC";
		$rsDiag = mysql_query($sqlDiag);
		$no = 1;
		//echo $sqlDiag;
		while($rwDiag = mysql_fetch_array($rsDiag))
		{
  ?>
  <tr>
  	<td style="font-size:11px;" valign="top">&nbsp;<?php echo $no; ?></td>
	<td style="font-size:11px;" valign="top">&nbsp;<?php echo $rwDiag['kode']; ?></td>
	<td style="font-size:11px; text-transform:uppercase"><?php echo " - ".$rwDiag['nama']; ?></td>
	<td style="font-size:11px; text-align:right; padding-right:120px;" valign="top">&nbsp;<?php echo $rwDiag['jml']; ?></td>
  </tr>
  <?php
  		 $no++;
	}
  ?>
  <tr>
  	<td style="border-bottom:1px solid;">&nbsp;</td>
	<td style="border-bottom:1px solid;">&nbsp;</td>
	<td style="border-bottom:1px solid;">&nbsp;</td>
	<td style="border-bottom:1px solid;">&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td colspan="2" align="right">Tgl Cetak:&nbsp;<?=$date_now.'&nbsp;Jam:&nbsp;'.$jam;?></td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td colspan="2" align="right">Yang Mencetak</td>
  </tr>
   <tr id="trTombol">
        <td class="noline" align="center" colspan="4" height="50" valign="bottom">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>        </td>
    </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td colspan="2" align="right"><b><?php echo $rwPeg['nama'];?></b></td>
  </tr>
</table>
</body>
</html>
<script type="text/JavaScript">

/* try{	
formatF4();
}catch(e){
window.location='../../addon/jsprintsetup.xpi';
} */
    function cetak(tombol){
        tombol.style.visibility='hidden';
        if(tombol.style.visibility=='hidden'){
		/* try{
			mulaiPrint();
		}
		catch(e){
			window.print();
		} */
		window.print();
		window.close();
        }
    }
</script>