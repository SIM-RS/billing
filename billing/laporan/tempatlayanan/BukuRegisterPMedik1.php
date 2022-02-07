<?
include("../../sesi.php");
?>
<?php 
if($_POST['export']=='excel'){
header("Content-type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="Lap Buku Register Pasien.xls"');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php 
if($_POST['export']!='excel'){
?>
<link type="text/css" rel="stylesheet" href="../../theme/print.css">
<?php 
}
?>
<script type="text/javascript" src="../../theme/js/ajax.js"></script>
<script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>
<script type="text/JavaScript" language="JavaScript" src="../../theme/js/formatPrint.js"></script>
<title>Buku Register Pasien</title>
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
		$waktu = " and pl.tgl = '$tglAwal2' ";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
	}
	else if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];
		$thn = $_POST['cmbThn'];
		$waktu = " and month(pl.tgl) = '$bln' and year(pl.tgl) = '$thn' ";
		$Periode = "Bulan $arrBln[$bln] Tahun $thn";
	}
	else{
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		//echo $arrBln[$tglAwal[1]];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = " and pl.tgl between '$tglAwal2' and '$tglAkhir2' ";
		
		$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	}
	
	$sqlUnit1 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayMedik']."'";
	$rsUnit1 = mysql_query($sqlUnit1);
	$rwUnit1 = mysql_fetch_array($rsUnit1);
	
	switch ($_REQUEST['JnsKunjMedik']){
		case "1":
			$asalUnit="PASIEN RAWAT JALAN";
			$jKunj="AND pl.jenis_kunjungan=1";
			break;
		case "2":
			$asalUnit="PASIEN RAWAT DARURAT";
			$jKunj="AND pl.jenis_kunjungan=2";
			break;
		case "3":
			$asalUnit="PASIEN RAWAT INAP";
			$jKunj="AND pl.jenis_kunjungan=3";
			break;
	}
	$fUnit=" pl.unit_id=".$_REQUEST['TmpLayMedik']." ";
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);
	
	$stsPas=$_REQUEST['StatusPas'];
	if($stsPas != 0) {
    	$fKso = " AND k.kso_id = $stsPas ";
	}
?>
<table width="900" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td colspan="12"><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
  </tr>
  <tr>
    <td colspan="12" align="center" height="70" valign="top" style="font-size:14px; text-transform:uppercase">
	<b>Buku Register Pasien <?php echo $rwUnit1['nama'] ?><br /><?php echo $asalUnit; ?><br />
      <?php echo $Periode;?></b>    </td>
  </tr>
  <!--tr>
	<td colspan="5" align="left" height="30">&nbsp;</td>
	<td colspan="7" align="right">Yang Mencetak :&nbsp;<b><?php echo $rwPeg['nama'];?></b>&nbsp;</td>
  </tr-->
  <tr style="font-weight:bold">
    <td width="3%" height="20" align="center" style="border-bottom:1px solid; border-top:1px solid;">&nbsp;No.</td>
    <td width="6%" style="border-bottom:1px solid; border-top:1px solid; text-align:center;">Tgl</td>
    <td width="6%" style="border-bottom:1px solid; border-top:1px solid; text-align:center;">No. RM</td>
    <td width="11%" style="border-bottom:1px solid; border-top:1px solid;">&nbsp;Nama Pasien</td>
    <td width="3%" align="center" style="border-bottom:1px solid; border-top:1px solid;">JK</td>
    <td width="3%" align="center" style="border-bottom:1px solid; border-top:1px solid;">Umur</td>
    <td width="17%" style="border-bottom:1px solid; border-top:1px solid;">&nbsp;Alamat</td>
    <td width="4%" align="center" style="border-bottom:1px solid; border-top:1px solid;">L / B</td>
    <td width="13%" align="center" style="border-bottom:1px solid; border-top:1px solid;">&nbsp;&nbsp;Unit Asal</td>
    <td width="13%" style="border-bottom:1px solid; border-top:1px solid;">&nbsp;Tindakan</td>
    <td width="6%" align="center" style="border-bottom:1px solid; border-top:1px solid;">Nilai</td>
    <td width="13%" style="border-bottom:1px solid; border-top:1px solid;">&nbsp;Dokter</td>
  </tr>
  <?php
	$qK = "SELECT kso.id, kso.nama
		FROM b_ms_kso kso inner join b_kunjungan k ON k.kso_id = kso.id
		INNER JOIN b_pelayanan pl on pl.kunjungan_id = k.id
		WHERE $fUnit $jKunj
		$waktu $fKso
		GROUP BY kso.id ORDER BY kso.nama ";
	$rsK = mysql_query($qK);
	$gTot=0;
	while($rwK = mysql_fetch_array($rsK))
	{
  ?>
  <tr>
	<td colspan="12" height="30" valign="bottom">&nbsp;<b><?php echo $rwK['nama'];?></b></td>
  </tr>
  <?php
 /* query - dicoba ya... */
  
  $sqlPas = "SELECT DATE_FORMAT(k.tgl,'%d/%m/%Y') AS tgl, p.no_rm, p.nama AS pasien, 
p.sex, k.umur_thn, IF(k.isbaru=1,'Baru','Lama') AS kunjungan, p.alamat,
(SELECT nama FROM b_ms_unit WHERE id = pl.unit_id_asal) AS asal,
mp.nama AS dokter, pl.id
FROM b_ms_pasien p
INNER JOIN b_kunjungan k ON k.pasien_id = p.id
INNER JOIN b_pelayanan pl ON pl.kunjungan_id = k.id
INNER JOIN b_tindakan t ON t.pelayanan_id = pl.id
LEFT JOIN b_ms_pegawai mp ON mp.id=t.user_id
WHERE $fUnit $jKunj $waktu and k.kso_id = '".$rwK['id']."' GROUP BY k.id,pl.id";
	//echo $sqlPas."<br>";
	$rsPas = mysql_query($sqlPas);
	$no = 1;
	$sTot=0;
	while($rwPas = mysql_fetch_array($rsPas))
 	{
		$sqlTind="SELECT mt.nama,qty*biaya AS nilai FROM b_tindakan t INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id
INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id WHERE t.pelayanan_id='".$rwPas['id']."'";
		$rsTind=mysql_query($sqlTind);
		$nTind="";
		$nilai=0;
		while ($rwTind=mysql_fetch_array($rsTind)){
			$nTind .=$rwTind['nama'].", ";
			$nilai +=$rwTind['nilai'];
		}
		$nTind=substr($nTind,0,strlen($nTind)-2);
		$sTot +=$nilai;
  ?>
  <tr style="font-size:10px" valign="top">
  	<td align="center">&nbsp;<?php echo $no; ?></td>
	<td align="center"><?php echo $rwPas['tgl'];?></td>
	<td align="center"><?php echo $rwPas['no_rm'];?></td>
	<td style="text-transform:uppercase">&nbsp;<?php echo $rwPas['pasien'];?></td>
	<td align="center">&nbsp;<?php echo $rwPas['sex'];?></td>
	<td align="center">&nbsp;<?php echo $rwPas['umur_thn'];?></td>
	<td style="text-transform:capitalize">&nbsp;<?php echo $rwPas['alamat'];?></td>
	<td align="center">&nbsp;<?php echo $rwPas['kunjungan']; ?></td>
	<td align="center" style="text-transform:uppercase">&nbsp;<?php echo $rwPas['asal'];?></td>
	<td valign="top">&nbsp;<?php echo $nTind; ?></td>
	<td align="right" valign="top"><?php echo number_format($nilai,0,",","."); ?>&nbsp;</td>
	<td valign="top">&nbsp;<?php echo $rwPas['dokter'];?></td>
  </tr>
  <?php
  		 $no++;
	}
	mysql_free_result($rsPas);
  ?>
  <tr>
  	<td colspan="10" align="right" style="border-top:1px solid;">Sub Total :&nbsp;</td>
    <td align="right" style="border-top:1px solid;"><?php echo number_format($sTot,0,",","."); ?>&nbsp;</td>
    <td style="border-top:1px solid;">&nbsp;</td>
  </tr>
  <?php
  		$gTot +=$sTot;
	}
	mysql_free_result($rsK);
	mysql_free_result($rsUnit1);
	mysql_free_result($rsPeg);
	mysql_close($konek);
  ?>
  <tr>
  	<td colspan="10" align="right">Grand Total :&nbsp;</td>
    <td align="right"><?php echo number_format($gTot,0,",","."); ?>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr><td colspan="12">&nbsp;</td></tr>
  <tr><td colspan="12" style="text-align:right">Tgl Cetak:&nbsp;<?php echo $date_now.'&nbsp;Jam:&nbsp;'.$jam?>&nbsp;</td></tr>
  <tr><td colspan="12" height="50" valign="top" style="text-align:right">Yang Mencetak,&nbsp;</td></tr>
  <tr><td colspan="12" style="text-align:right"><b><?php echo $rwPeg['nama'];?></b>&nbsp;</td></tr>
  <tr id="trTombol">
        <td colspan="12" class="noline" align="center">
			<?php 
            if($_POST['export']!='excel'){
            ?>
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>        </td>
			<?php 
            }
            ?>
    </tr>
  <tr><td colspan="12" height="50">&nbsp;</td></tr>
</table>
</body>
<script type="text/JavaScript">
    /*function cetak(tombol){
        tombol.style.visibility='hidden';
        if(tombol.style.visibility=='hidden'){
		window.print();
		window.close();
        }
    }*/
    
    /* 
        try{
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
</html>
