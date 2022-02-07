<?php
session_start();
include("../../sesi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Laporan Pasien Batal Berkunjung</title>
</head>

<body>
<?php
	include("../../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');

	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$waktu = $_POST['cmbWaktu'];
	if($waktu == 'Harian'){
		$tglAwal = explode('-',$_REQUEST['tglAwal2']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$waktu = " and bp.tgl = '$tglAwal2' ";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
	}
	else if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];
		$thn = $_POST['cmbThn'];
		$waktu = " and month(bp.tgl) = '$bln' and year(bp.tgl) = '$thn' ";
		$Periode = "Bulan $arrBln[$bln] Tahun $thn";
	}
	else{
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		//echo $arrBln[$tglAwal[1]];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = " and bp.tgl between '$tglAwal2' and '$tglAkhir2' ";
		
		$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	}
	
	$sqlUnit1 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['JnsLayanan']."'";
	$rsUnit1 = mysql_query($sqlUnit1);
	$rwUnit1 = mysql_fetch_array($rsUnit1);
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);
	
	$stsPas=$_REQUEST['StatusPas'];
	if($stsPas != 0) {
		$fKso = " AND b_kunjungan.kso_id = $stsPas ";
		$qJnsLay=mysql_query("select nama from b_ms_kso where id=".$stsPas);
		$rwJnsLay=mysql_fetch_array($qJnsLay);
	}
	
	if($_REQUEST['TmpLayanan']==0){		
		$fUnit = " bp.jenis_layanan = '".$_REQUEST['JnsLayanan']."'";
		$tmpNama = "SEMUA";
	}else{
		$fUnit = " bp.unit_id = '".$_REQUEST['TmpLayanan']."' ";
		$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayanan']."'";
		$rsUnit2 = mysql_query($sqlUnit2);
		$rwUnit2 = mysql_fetch_array($rsUnit2);
		$tmpNama = $rwUnit2['nama'];
	}
?>
<table width="800" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td colspan="5"><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
  </tr>
  <tr>
    <td colspan="12" align="center" height="70" valign="top" style="font-size:14px; text-transform:uppercase"><b>Laporan  Pasien BATAL BERKUNJUNG <?php echo $rwUnit1['nama'] ?> - <?php echo $tmpNama; ?><br /><?php echo $Periode;?></b></td>
  </tr>
  <tr>
    <td height="30" colspan="3"><b>Penjamin Pasien: <?php if($stsPas==0) echo 'Semua'; else echo $rwJnsLay['nama'];?></b></td>
    <td height="30" colspan="2" align="right">Yang Mencetak :&nbsp;<b><?php echo $rwPeg['nama'];?></b>&nbsp;</td>
  </tr>
  <tr height="30">
    <td width="5%" height="28" style="border-top:1px solid; border-bottom:1px solid;">&nbsp;No</td>
    <td width="10%" style="border-top:1px solid; border-bottom:1px solid;">&nbsp;No RM</td>
    <td colspan="2" style="border-top:1px solid; border-bottom:1px solid;">&nbsp;Nama</td>
    <td colspan="2" style="border-top:1px solid; border-bottom:1px solid;">&nbsp;Jenis Kelamin</td>
    <td colspan="2" style="border-top:1px solid; border-bottom:1px solid;">&nbsp;Penjamin</td>
     <td colspan="2" style="border-top:1px solid; border-bottom:1px solid;">&nbsp;Tanggal Berkunjung</td>
    <td width="20%" align="right" style="border-top:1px solid; border-bottom:1px solid;">Unit Tujuan&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <?php
		if($_REQUEST['StatusPas']!=0)
			$fKso = " AND bp.kso_id = ".$_REQUEST['StatusPas'];
		
		$sqlDiag = "SELECT bmp.no_rm, bmp.nama, bmp.sex, bmk.nama AS nm_kso, bp.tgl, bmu.nama AS nm_unit  FROM b_pelayanan bp
				INNER JOIN b_ms_pasien bmp ON bp.pasien_id = bmp.id
				INNER JOIN b_ms_unit bmu ON bp.unit_id = bmu.id
				INNER JOIN b_ms_kso bmk ON bp.kso_id = bmk.id
				WHERE batal = 1 and $fUnit $fKso $waktu";
		$rsDiag = mysql_query($sqlDiag);
		$no = 1;
		//echo $sqlDiag;
		while($rwDiag = mysql_fetch_array($rsDiag))
		{
  ?>
  <tr>
  	<td>&nbsp;<?php echo $no; ?></td>
	<td>&nbsp;<?php echo $rwDiag['no_rm']; ?></td>
	<td colspan="2" style="text-transform:uppercase">&nbsp;<?php echo $rwDiag['nama']; ?></td>
    <td colspan="2" style="text-transform:uppercase">&nbsp;<?php echo $rwDiag['sex']; ?></td>
    <td colspan="2" style="text-transform:uppercase">&nbsp;<?php echo $rwDiag['nm_kso']; ?></td>
    <td colspan="2" style="text-transform:uppercase">&nbsp;<?php echo $rwDiag['tgl']; ?></td>
    <td align="right" style="padding-right:10px"><?php echo $rwDiag['nm_unit']; ?>&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <?php
  		 $no++;
	}mysql_free_result($rsDiag);
  ?>
  <tr>
  	<td style="border-bottom:1px solid;">&nbsp;</td>
	<td style="border-bottom:1px solid;">&nbsp;</td>
	<td style="border-bottom:1px solid;">&nbsp;</td>
	<td style="border-bottom:1px solid;">&nbsp;</td>
	<td style="border-bottom:1px solid;">&nbsp;</td>
    <td style="border-bottom:1px solid;">&nbsp;</td>
	<td style="border-bottom:1px solid;">&nbsp;</td>
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
	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td colspan="10" align="right">Tgl Cetak:&nbsp;<?php echo $date_now.'&nbsp;Jam:&nbsp;'.$jam;?>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td colspan="10" align="right">Yang Mencetak</td>
  </tr>
  <tr>
  	<td colspan="12" height="50" valign="bottom" align="center">&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td colspan="10" align="right"><b><?php echo $rwPeg['nama'];?></b>&nbsp;</td>
  </tr>
  <tr id="trTombol">
        <td class="noline" align="center" colspan="12">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>        </td>
    </tr>
</table>
</body>
<?php
	mysql_free_result($rsUnit1);
	// mysql_free_result($rsUnit2);
	mysql_free_result($rsPeg);
	mysql_close($konek);
?>
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