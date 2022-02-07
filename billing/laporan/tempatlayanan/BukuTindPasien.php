<?php
session_start();
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
<title>Buku Tindakan Pasien</title>
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
		//echo $arrBln[$tglAwal[1]];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = " and t.tgl between '$tglAwal2' and '$tglAkhir2' ";
		
		$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	}
	
	$sqlUnit1 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['JnsLayanan']."'";
	$rsUnit1 = mysql_query($sqlUnit1);
	$rwUnit1 = mysql_fetch_array($rsUnit1);
	
if($_REQUEST['TmpLayanan']!='0'){	
	$sqlUnit2 = "SELECT id,nama,inap FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayanan']."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
	$fUnit=" pl.unit_id=".$_REQUEST['TmpLayanan']." ";
}else
	$fUnit=" u.parent_id=".$_REQUEST['JnsLayanan']." ";
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);
	
	$stsPas=$_REQUEST['StatusPas'];
	if($stsPas != 0) {
    	$fKso = " AND pl.kso_id = $stsPas ";
	}
?>
<table width="800" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td colspan="10"><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
  </tr>
  <tr>
    <td colspan="10" align="center" height="70" valign="top" style="font-size:14px; text-transform:uppercase"><b>Buku Tindakan Pasien <?php echo $rwUnit1['nama'] ?> - <?php if($_REQUEST['TmpLayanan']=='0') echo "SEMUA"; echo $rwUnit2['nama'] ?><br /><?php echo $Periode;?></b></td>
  </tr>
  <tr>
    <td colspan="5" height="30" style="font-weight:bold">&nbsp;TEMPAT LAYANAN : &nbsp;<?php if($_REQUEST['TmpLayanan']=='0') echo "Semua"; echo $rwUnit2['nama'] ?></td>
    <td colspan="5" align="right">Yang Mencetak :&nbsp;<b><?php echo $rwPeg['nama'];?></b>&nbsp;</td>
  </tr>
  <tr style="font-weight:bold">
    <td width="3%" style="border-top:1px solid;">&nbsp;No.</td>
    <td width="12%" style="border-top:1px solid;">&nbsp;Tgl Kunjungan</td>
    <td width="6%" style="border-top:1px solid;">&nbsp;No. RM</td>
    <td width="22%" style="border-top:1px solid;">&nbsp;Nama Pasien</td>
    <td width="4%" align="center" style="border-top:1px solid;">JK</td>
    <td width="14%" align="center" style="border-top:1px solid;">Umur</td>
    <td width="9%" style="border-top:1px solid;">&nbsp;</td>
    <td width="10%"  align="right" style="border-top:1px solid; <?php echo ($rwUnit2['inap']==0)?"display:none;":'';?>">&nbsp;</td>
    <td width="10%"  align="right" style="border-top:1px solid;">&nbsp;</td>
    <td width="10%" style="border-top:1px solid;">&nbsp;</td>
  </tr>
  <tr style="font-weight:bold">
    <td style="border-bottom:1px solid;">&nbsp;</td>
    <td style="border-bottom:1px solid;">&nbsp;</td>
    <td style="border-bottom:1px solid;">&nbsp;</td>
    <td colspan="3" style="border-bottom:1px solid;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tindakan</td>
    <td style="border-bottom:1px solid; text-align:right">Tarif&nbsp;</td>
    <td align="right" style="border-bottom:1px solid; <?php echo ($rwUnit2['inap']==0)?"display:none;":'';?>">Tarif Kamar&nbsp;</td>
    <td colspan="2" style="border-bottom:1px solid;">&nbsp;Pelaksana</td>
  </tr>
  <?php
	$qK = "SELECT b_ms_kso.id, b_ms_kso.nama FROM b_ms_kso
		INNER JOIN b_pelayanan pl on pl.kso_id = b_ms_kso.id
		INNER JOIN b_tindakan t ON t.pelayanan_id = pl.id
		INNER JOIN b_ms_unit u ON u.id = pl.unit_id
		WHERE $fUnit $waktu $fKso
		GROUP BY b_ms_kso.id
		ORDER BY b_ms_kso.nama";
	$rsK = mysql_query($qK);
	$tot = 0;
	$tKmr = 0;
	while($rwK = mysql_fetch_array($rsK))
	{
  ?>
  <tr><td colspan="10" height="30" valign="bottom">&nbsp;<b><?php echo $rwK['nama'];?></b></td></tr>
 <?php
  	$sql1 = "SELECT pl.id, DATE_FORMAT(t.tgl,'%d/%m/%Y') AS tgl, p.no_rm, p.nama, p.sex, 
			k.umur_thn,k.umur_bln, k.umur_hr, DATE_FORMAT(pl.tgl,'%d/%m/%Y') AS tglLay, DATE_FORMAT(tk.tgl_in,'%d/%m/%Y') AS mrs
			FROM b_ms_pasien p 
			INNER JOIN b_kunjungan k ON k.pasien_id = p.id 
			INNER JOIN b_pelayanan pl ON pl.kunjungan_id = k.id
			INNER JOIN b_tindakan t ON t.pelayanan_id = pl.id
			LEFT JOIN b_tindakan_kamar tk ON tk.pelayanan_id = pl.id
			INNER JOIN b_ms_unit u ON u.id = pl.unit_id
			WHERE $fUnit $waktu AND pl.kso_id = '".$rwK['id']."'
			GROUP BY k.id";
	$rs1 = mysql_query($sql1);
	$no = 1;
	$sub = 0;
	$sKmr = 0;
	while($rw1 = mysql_fetch_array($rs1))
 	{
  ?>
  <tr style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  	<td style="text-align:center"><?php echo $no;?></td>
  	<td>&nbsp;<?php if($rwUnit2['inap']==1) echo $rw1['mrs']; else echo $rw1['tgl'];?></td>
  	<td>&nbsp;<?php echo $rw1['no_rm'];?></td>
  	<td style="text-transform:uppercase">&nbsp;<?php echo $rw1['nama'];?></td>
  	<td style="text-align:center">&nbsp;<?php echo $rw1['sex'];?></td>
  	<td style="text-align:center">&nbsp;<?php echo $rw1['umur_thn']."th ".$rw1['umur_bln']."bln ".$rw1['umur_hr']."hr";?></td>
  	<td>&nbsp;</td>
  	<td style="<?php echo ($rwUnit2['inap']==0)?"display:none;":'';?>">&nbsp;</td>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  </tr>
  <?php
  		$qKmr = "SELECT t.id, t.kamar, t.qty, t.tarip, t.qty*t.tarip AS jml, t.mrs, t.krs FROM (SELECT b_tindakan_kamar.id, b_tindakan_kamar.nama AS kamar, DATEDIFF(DATE(b_tindakan_kamar.tgl_out),DATE(b_tindakan_kamar.tgl_in)) AS qty, b_tindakan_kamar.tarip, DATE_FORMAT(b_tindakan_kamar.tgl_in, '%d-%m-%Y') AS mrs, DATE_FORMAT(b_tindakan_kamar.tgl_out, '%d-%m-%Y') AS krs FROM b_pelayanan INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id WHERE b_pelayanan.id = '".$rw1['id']."') AS t";
		$rsKmr = mysql_query($qKmr);
		$rwKmr = mysql_fetch_array($rsKmr);
  ?>
  <tr style="font-family:Arial, Helvetica, sans-serif; font-size:11px; <?php echo ($rwUnit2['inap']==0)?"display:none;":'';?>">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4" style="padding-left:20px;"><?php echo $rwKmr['kamar'].'&nbsp;('.$rwKmr['mrs'].'&nbsp;s/d&nbsp;'.$rwKmr['krs'].')';?></td>
    <td style="text-align:right; <?php echo ($rwUnit2['inap']==0)?"display:none;":'';?>"><?php echo number_format($rwKmr['jml'],0,",",".");?>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <?php
		$sKmr = $sKmr + $rwKmr['jml'];
		$sql2 = "SELECT mt.nama,SUM(t.qty) jml,SUM(t.qty*t.biaya) total,(SELECT nama FROM b_ms_pegawai WHERE id=t.user_id) pelaksana FROM b_tindakan t INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id
INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id
WHERE t.pelayanan_id='".$rw1['id']."' $waktu GROUP BY mt.id,t.user_id";
//echo "<br /><br />";
		$rs2 = mysql_query($sql2);
		//echo $sql2."<br>";
		while($rw2 = mysql_fetch_array($rs2))
		{
	?>
  <tr style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td colspan="3" style="padding-left:20px;"><?php echo $rw2['nama'].'&nbsp;['.$rw2['jml'].']';?></td>
  	<td style="text-align:right"><?php echo number_format($rw2['total'],0,",",".");?>&nbsp;</td>
  	<td style="text-align:right; <?php echo ($rwUnit2['inap']==0)?"display:none;":'';?>">&nbsp;</td>
  	<td colspan="2">&nbsp;<?php echo $rw2['pelaksana'];?></td>
  </tr>
 	<?php
		$sub = $sub + $rw2['total'];
		 }mysql_free_result($rs2);
		$no++;
		}mysql_free_result($rs1);
  ?>
    <tr>
      <td colspan="6" style="text-align:right;">Subtotal&nbsp;</td>
      <td style="text-align:right; border-top:1px solid; font-weight:bold;"><?php echo number_format($sub,0,",",".")?>&nbsp;</td>
      <td style="text-align:right; <?php echo ($rwUnit2['inap']==0)?"display:none;":'';?>; border-top:1px solid; font-weight:bold;"><?php echo number_format($sKmr,0,",",".")?>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
	<?php
		$tot = $tot + $sub;
		$tKmr = $tKmr + $sKmr;
		}mysql_free_result($rsK);
	?>
    <tr>
      <td colspan="6" height="28" style="text-align:right; font-weight:bold; border-top:1px solid; border-bottom:1px solid;">Total&nbsp;</td>
      <td style="text-align:right; font-weight:bold; border-top:1px solid; border-bottom:1px solid;"><?php echo number_format($tot,0,",",".")?>&nbsp;</td>
      <td style="text-align:right; font-weight:bold; border-top:1px solid; border-bottom:1px solid; <?php echo ($rwUnit2['inap']==0)?"display:none;":'';?>"><?php echo number_format($tKmr,0,",",".")?>&nbsp;</td>
      <td colspan="2" style="border-top:1px solid; border-bottom:1px solid;">&nbsp;</td>
    </tr>
  <tr>
  	<td colspan="10">&nbsp;</td>
  </tr>
  <tr><td colspan="10" style="text-align:right">Tgl Cetak:&nbsp;<?php echo $date_now.'&nbsp;Jam:&nbsp;'.$jam?>&nbsp;</td></tr>
  <tr><td colspan="10" height="50" valign="top" style="text-align:right">Yang Mencetak,&nbsp;</td></tr>
  <tr><td colspan="10" style="text-align:right"><b><?php echo $rwPeg['nama'];?></b>&nbsp;</td></tr>
  <tr>
  	<td colspan="10">&nbsp;</td>
  </tr>
  <tr id="trTombol">
        <td colspan="10" class="noline" align="center">
			<?php 
            if($_POST['export']!='excel'){
            ?>
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>        </td>
			<?php 
            }
            ?>
    </tr>
  <tr><td colspan="10" height="50">&nbsp;</td></tr>
</table>
</body>
<?php
	//mysql_free_result($rsUnit1);
	//mysql_free_result($rsUnit2);
	//mysql_free_result($rsPeg);
	//mysql_close($konek);
?>
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
</html>
