<?php
session_start();
include("../../sesi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Kunjungan Pasien Berdasarkan Penjamin Pasien</title>
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
	
	if($_REQUEST['TmpLayanan'] != '0'){
		$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayanan']."'";
		$rsUnit2 = mysql_query($sqlUnit2);
		$rwUnit2 = mysql_fetch_array($rsUnit2);
		$tmpNama = $rwUnit2['nama'];
	} else {
		$tmpNama = "SEMUA";
	}
	
	$sqlKso = "SELECT id,nama from b_ms_kso where id = '".$_REQUEST['StatusPas']."'";
	$rsKso = mysql_query($sqlKso);
	$rwKso = mysql_fetch_array($rsKso);
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);
?>
<table width="750" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td colspan="5"><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
  </tr>
  <tr>
    <td colspan="5" align="center" height="70" valign="top" style="font-size:14px; text-transform:uppercase"><b>Laporan Kunjungan Berdasarkan Penjamin Pasien <?php if($rwKso['nama']=="") echo 'Semua'; else echo $rwKso['nama'] ?><br />Jenis Layanan <?php echo $rwUnit1['nama'];?>&nbsp;Tempat Layanan <?php echo $tmpNama;?>
	<br /><?php echo $Periode;?></b></td>
  </tr>
  
  <tr>
    <td colspan="5" align="right" height="30">Yang Mencetak :&nbsp;<b><?php echo $rwPeg['nama'];?></b>&nbsp;</td>
  </tr>
  <tr style="font-family:Arial, Helvetica, sans-serif; font-size:11px; font-size:12px; font-weight:bold;">
    <td width="40%" height="28" style="border-bottom:1px solid; border-top:1px solid;">&nbsp;Status Pasien</td>
    <td width="15%" align="right" style="border-bottom:1px solid; border-top:1px solid;">Kunjungan Baru&nbsp;</td>
    <td width="15%" align="right" style="border-bottom:1px solid; border-top:1px solid;">Kunjungan Lama&nbsp;</td>
    <td width="15%" align="right" style="border-bottom:1px solid; border-top:1px solid;">Jumlah Kunjungan&nbsp;</td>
    <td width="15%" style="border-bottom:1px solid; border-top:1px solid;" align="right">Persentase&nbsp;</td>
  </tr>
  <tr>
  	<td colspan="5" style="text-decoration:underline">&nbsp;<?php echo $tmpNama?></td>
  </tr>
  <?php
		$fKso = '';
		// hafiz - edit field agar jumlah balance
		$semuaTmpLayanan = [];
		$query = mysql_query("SELECT id, nama FROM b_ms_unit WHERE aktif=1 AND parent_id='".$_REQUEST['JnsLayanan']."' ORDER BY nama");

		if($_REQUEST['StatusPas']!=0) {
			$fKso = " AND b_kunjungan.kso_id = ".$_REQUEST['StatusPas'];
		}
		if($_REQUEST['TmpLayanan']==0) {
			while(($row =  mysql_fetch_assoc($query))) {
				$semuaTmpLayanan[] = $row['id'];
			}
			// $imploded_arr = implode("','",$semuaTmpLayanan);
			$fTmp = " b_pelayanan.unit_id IN('".implode("','",$semuaTmpLayanan)."') ";
			// $fTmp = " b_pelayanan.jenis_layanan = '".$_REQUEST['JnsLayanan']."' ";
		}
		else {
			$fTmp = " b_pelayanan.unit_id = '".$_REQUEST['TmpLayanan']."' ";
		}
		$qTot = "SELECT COUNT(b_kunjungan.pasien_id) AS jml FROM b_kunjungan
				INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
				WHERE $fTmp $waktu $fKso ";
			$rsTot = mysql_query($qTot);
			$rwTot = mysql_fetch_array($rsTot);
			
		$sql = "SELECT b_ms_kso.id, b_ms_kso.nama FROM b_kunjungan
			INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
			INNER JOIN b_ms_kso ON b_ms_kso.id = b_kunjungan.kso_id
			WHERE $fTmp $waktu $fKso
			GROUP BY b_ms_kso.id";
		$rs = mysql_query($sql);
		$totLm = 0;
		$totJml = 0;
		$totK = 0;
		$pros = 0;
		$totPros = 0;
		while($rw = mysql_fetch_array($rs))
		{
			$qBr = "SELECT COUNT(b_kunjungan.pasien_id) AS jml FROM b_kunjungan
				INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
				WHERE $fTmp AND b_kunjungan.isbaru = '1' 
				$waktu AND b_kunjungan.kso_id = '".$rw['id']."'
				GROUP BY b_kunjungan.kso_id";
			$rsBr = mysql_query($qBr);
			$rwBr = mysql_fetch_array($rsBr);
			
			$qLm = "SELECT COUNT(b_kunjungan.pasien_id) AS jml FROM b_kunjungan
				INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
				WHERE $fTmp AND b_kunjungan.isbaru = '0'
				$waktu AND b_kunjungan.kso_id = '".$rw['id']."'
				GROUP BY b_kunjungan.kso_id";
			$rsLm = mysql_query($qLm);
			$rwLm = mysql_fetch_array($rsLm);
			
			$qK = "SELECT COUNT(b_kunjungan.pasien_id) AS jml FROM b_kunjungan
				INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
				WHERE $fTmp $waktu AND b_kunjungan.kso_id = '".$rw['id']."'
				GROUP BY b_kunjungan.kso_id";
			$rsK = mysql_query($qK);
			$rwK = mysql_fetch_array($rsK);
					
	/* $totBr = 0;
	$totLm = 0;
	$totJml = 0;
	$totPros = 0;
	$pros = 0;*/
	/* while($row = mysql_fetch_array($rs))
	{
		//$totJml = $totJml + $row['jml'];
		$totK = $totK + $rwK['jml'];
	}  */
	/*$rs=mysql_query($sql);
	while($rw = mysql_fetch_array($rs))
	{ 
		$totBr = $totBr + $rw['jmlBaru'];
		$totLm = $totLm + $rw['jmlLama'];
	/* 	$totBr = $totBr + $rwBr['jml'];
		$totLm = $totLm + $rwLm['jml']; */
		
  ?>
  <tr>
    <td style="padding-left:20px;">&nbsp;<?php echo $rw['nama'];?></td>
    <td style="text-align:center"><?php if($rwBr['jml']==0) echo 0; else echo $rwBr['jml']; ?>&nbsp;</td>
    <td style="text-align:center"><?php if($rwLm['jml']==0) echo 0; else echo $rwLm['jml']; ?>&nbsp;</td>
    <td style="text-align:center"><?php if($rwK['jml']==0) echo 0; else echo $rwK['jml']; ?>&nbsp;</td>
	<?php
		//$totK = $totK + $rwK['jml'];
		//$totBr = $totBr + $rw['jmlBaru'];
		//$totLm = $totLm + $rw['jmlLama'];
		//echo $rwK['jml'].'-'.$totK;
		$pros = number_format(($rwK['jml']/$rwTot['jml'])*100,2,",",".");
		$totPros = number_format(($rwTot['jml']/$rwTot['jml'])*100);
	?>
    <td align="right" style="padding-right:10px;"><?php echo $pros;?></td>
  </tr>
  <?php
		$totBr = $totBr + $rwBr['jml'];
		$totLm = $totLm + $rwLm['jml'];
		$totK = $totK + $rwK['jml'];
	}
	
  ?>
  <tr height="30" style="font-weight:bold;">
  	<td style="border-bottom:1px solid; border-top:1px solid;" align="right">Total&nbsp;</td>
	<td style="border-bottom:1px solid; border-top:1px solid; text-align:center"><?php echo $totBr;?>&nbsp;</td>
	<td style="border-bottom:1px solid; border-top:1px solid; text-align:center"><?php echo $totLm;?>&nbsp;</td>
	<td style="border-bottom:1px solid; border-top:1px solid; text-align:center"><?php echo $totK;?>&nbsp;</td>
	<td style="border-bottom:1px solid; border-top:1px solid;" align="right"><?php echo $totPros;?>&nbsp;%&nbsp;</td>
  </tr>
  <tr>
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
	<td colspan="2" align="right">Tgl Cetak: <?php echo $date_now.'&nbsp;Jam:&nbsp;'.$jam;?><br />Yang Mencetak</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td colspan="2" height="50">&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td colspan="2" align="right"><b><?php echo $rwPeg['nama'];?></b>&nbsp;</td>
  </tr>
  <tr><td colspan="5">&nbsp;</td></tr>
  <tr id="trTombol">
        <td class="noline" align="center" colspan="5">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
        </td>
    </tr>
</table>
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
</body>
</html>