<?php
session_start();
include("../../sesi.php");

if($_POST['isExcel']=='yes'){
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="diagnosaPer.xls"');
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
	
	if($_REQUEST['cmbJenisLayananM']==1){
		$txtJenisLayanan = "RAWAT JALAN";
	}
	else if($_REQUEST['cmbJenisLayananM']==2){
		$txtJenisLayanan = "RAWAT DARURAT";
	}
	else{
		$txtJenisLayanan = "RAWAT INAP";
	}
	
	if($_REQUEST['cmbTempatLayananM']==0){
		$txtTempatLayanan = "SEMUA";
		if($_REQUEST['cmbJenisLayananM']==1){
			$fUnit = " b_pelayanan.jenis_kunjungan=1 ";
		}
		else if($_REQUEST['cmbJenisLayananM']==2){
			$fUnit = " b_pelayanan.jenis_kunjungan=2 ";
		}
		else{
			$txtJenisLayanan = "RAWAT INAP";
			$fUnit = " b_pelayanan.jenis_kunjungan=3 ";
		}
	}
	else{
		$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['cmbTempatLayananM']."'";
		$rsUnit2 = mysql_query($sqlUnit2);
		$rwUnit2 = mysql_fetch_array($rsUnit2);
		$txtTempatLayanan = $rwUnit2['nama'];
		$fUnit = " b_pelayanan.unit_id=".$_REQUEST['cmbTempatLayananM'];
	}
	
	if($_REQUEST['diagnosa_id']==""){
		$fDiag = "";
	}else{
		$fDiag = "AND b_ms_diagnosa.id='".$_REQUEST['diagnosa_id']."'";
	}
?>
<table width="800" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td colspan="4"><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
  </tr>
  <tr>
    <td colspan="4" align="center" height="70" valign="top" style="font-size:14px; text-transform:uppercase"><b>Laporan Diagnosis Pasien <?php echo $txtJenisLayanan; ?> -  <?php echo $txtTempatLayanan; ?><br /><?php echo $Periode;?></b></td>
  </tr>
  <tr><td colspan="4" height="30"><b>Penjamin Pasien: <?php if($rwKso['id']==0) echo "Semua"; else echo $rwKso['nama'];?></b></td>
  <tr style="font-weight:bold; background-color:#66CC00">
    <td width="6%" height="28" style="font-size:12px; border-top:1px solid #FFFFFF; border-bottom:1px solid #FFFFFF; padding-left:10px; border-right:1px solid #FFFFFF;">No</td>
    <td width="10%" style="font-size:12px; border-top:1px solid #FFFFFF; border-bottom:1px solid #FFFFFF; padding-left:10px; border-right:1px solid #FFFFFF;">ICD X</td>
    <td width="74%" style="font-size:12px; border-top:1px solid #FFFFFF; border-bottom:1px solid #FFFFFF; padding-left:10px; border-right:1px solid #FFFFFF;">Diagnosis</td>
    <td width="10%" style="font-size:12px; border-top:1px solid #FFFFFF; border-bottom:1px solid #FFFFFF; padding-right:10px; text-align:right; border-right:1px solid #FFFFFF;">Jumlah</td>
  </tr>
  <?php
  		if($_REQUEST['StatusPas']!=0)
			$fKso = " AND b_pelayanan.kso_id = ".$_REQUEST['StatusPas'];
			
		if($_REQUEST['TmpLayanan']==0){
			//$fUnit = " b_pelayanan.jenis_layanan = '".$_REQUEST['JnsLayanan']."'";
		}else{
			//$fUnit = " b_pelayanan.unit_id = '".$_REQUEST['TmpLayanan']."' ";
		}
  		
		$qU = "SELECT b_ms_unit.id, b_ms_unit.nama FROM b_pelayanan
				INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id
				INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id=b_diagnosa_rm.ms_diagnosa_id
				INNER JOIN b_ms_unit ON b_ms_unit.id=b_pelayanan.unit_id
				WHERE $fUnit $fKso $fDiag $waktu AND b_diagnosa_rm.primer=1
				GROUP BY b_pelayanan.unit_id
				ORDER BY b_ms_unit.nama";
		$sU = mysql_query($qU);
		while($wU = mysql_fetch_array($sU)){
  ?>
  <tr>
  	<td colspan="4" height="28" style="padding-left:20px; font-size:12px; font-weight:bold; text-decoration:underline; text-transform:uppercase; color:#660000;"><?php echo $wU['nama']?></td>
  </tr>
   <?php
		
		$sqlDiag = "SELECT b_diagnosa_rm.diagnosa_id, b_ms_diagnosa.id, b_ms_diagnosa.nama, b_ms_diagnosa.kode,
					COUNT(DISTINCT b_pelayanan.pasien_id) AS jml
					FROM b_ms_diagnosa
					INNER JOIN b_diagnosa_rm ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id
					INNER JOIN b_pelayanan ON b_pelayanan.id = b_diagnosa_rm.pelayanan_id
					WHERE b_pelayanan.unit_id='".$wU['id']."' $fKso $fDiag $waktu AND b_diagnosa_rm.primer=1 GROUP BY b_ms_diagnosa.id
					ORDER BY jml DESC";
		$rsDiag = mysql_query($sqlDiag);
		$no = 1;
		$jmlD = 0;
		//echo $sqlDiag;
		while($rwDiag = mysql_fetch_array($rsDiag))
		{
  ?>
  <tr height="20">
  	<td style="font-size:11px; padding-left:10px;"><?php echo $no; ?></td>
	<td style="font-size:11px; padding-left:10px;"><?php echo $rwDiag['kode']; ?></td>
	<td style="font-size:11px; text-transform:uppercase; padding-left:10px;"><?php echo $rwDiag['nama']; ?></td>
	<td style="font-size:11px; text-align:right; padding-right:30px;"><?php echo $rwDiag['jml']; ?></td>
  </tr>
  <?php
  		 $no++;
		 $jmlD = $jmlD + $rwDiag['jml'];
		}
	?>
	<tr>
		<td colspan="3">&nbsp;</td>
		<td style="text-align:right; padding-right:30px; color:#0000FF; font-weight:bold; background-color:#CCCCCC" height="25"><?php echo $jmlD;?></td>
	</tr>
	<?php
	}
  ?>
  <tr>
  	<td style="border-bottom:1px solid #66CC00; ">&nbsp;</td>
	<td style="border-bottom:1px solid #66CC00;">&nbsp;</td>
	<td style="border-bottom:1px solid #66CC00;">&nbsp;</td>
	<td style="border-bottom:1px solid #66CC00;">&nbsp;</td>
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