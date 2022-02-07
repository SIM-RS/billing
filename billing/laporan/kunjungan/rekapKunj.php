<?php
	session_start();
	include("../../sesi.php");
?>
<title>Rekapitulasi Kunjungan</title>
<?php
include("../../koneksi/konek.php");
$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
$date_now=gmdate('d-m-Y',mktime(date('H')+7));
$jam = date("G:i");
$waktu = $_POST['cmbWaktu'];
if($waktu == 'Harian'){
	$tglAwal = explode('-',$_REQUEST['tglAwal2']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	$waktu = " AND pl.tgl = '$tglAwal2' ";
	$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
}
else if($waktu == 'Bulanan'){
	$bln = $_POST['cmbBln'];
	$thn = $_POST['cmbThn'];
	$waktu = " AND month(pl.tgl) = '$bln' and year(pl.tgl) = '$thn' ";
	$Periode = "Bulan $arrBln[$bln] Tahun $thn";
}
else{
	$tglAwal = explode('-',$_REQUEST['tglAwal']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	//echo $arrBln[$tglAwal[1]];
	$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
	$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
	$waktu = " AND pl.tgl between '$tglAwal2' and '$tglAkhir2' ";
	
	$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
}
	
	$sqlJnsLay = "SELECT nama FROM b_ms_unit WHERE id = '".$_REQUEST['JnsLayanan']."'";
	$rsJnsLay = mysql_query($sqlJnsLay);
	$rwJnsLay = mysql_fetch_array($rsJnsLay);
	
if($_REQUEST['TmpLayanan']!=0){
	$sqlTmpLay = "SELECT nama FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayanan']."'";
	$rsTmpLay = mysql_query($sqlTmpLay);
	$rwTmpLay = mysql_fetch_array($rsTmpLay);
	$fUnit = " AND pl.unit_id=".$_REQUEST['TmpLayanan'];
}else
	$fUnit = " AND mu.parent_id=".$_REQUEST['JnsLayanan'];

$stsPas=$_REQUEST['StatusPas'];
if($stsPas != 0) {
    $fKso = " AND pl.kso_id = $stsPas ";
    $qJnsLay=mysql_query("select nama from b_ms_kso where id=".$stsPas);
    $rwJnsLay=mysql_fetch_array($qJnsLay);
}

$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
$rsPeg = mysql_query($sqlPeg);
$rwPeg = mysql_fetch_array($rsPeg);
?>
<table border="0" cellpadding="0" cellspacing="0" width="750" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
	<tr>
		<td><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
	</tr>
	<tr>
		<td height="70" valign="top" style="text-align:center; font-weight:bold; font-size:14px; text-transform:uppercase">rekapitulasi kunjungan <?php echo $rwTmpLay['nama'];?><br><?php echo $Periode;?></td>
	</tr>
	<tr>
		<td>
			<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
				<tr style="font-size:12px; font-weight:bold;">
					<td width="20%" height="28" style="border-top:1px solid #9900FF; border-bottom:1px solid #9900FF; text-align:center; text-transform:uppercase;">Penjamin Pasien</td>
					<td width="25%" style="border-top:1px solid #9900FF; border-bottom:1px solid #9900FF; text-align:center; text-transform:uppercase;">Jenis Layanan</td>
					<td width="25%" style="border-top:1px solid #9900FF; border-bottom:1px solid #9900FF; text-align:center; text-transform:uppercase;">Tempat Layanan Asal</td>
					<td width="15%" style="border-top:1px solid #9900FF; border-bottom:1px solid #9900FF; text-align:center; text-transform:uppercase;">Jumlah Pasien</td>
					<td width="15%" style="border-top:1px solid #9900FF; border-bottom:1px solid #9900FF; text-align:center; text-transform:uppercase;">Biaya</td>
				</tr>
				<?php
						$qKso = "SELECT kso.nama, kso.id FROM b_kunjungan k					
								INNER JOIN b_pelayanan pl ON pl.kunjungan_id = k.id
								INNER JOIN b_ms_kso kso ON pl.kso_id = kso.id
								INNER JOIN b_tindakan t on t.pelayanan_id = pl.id
								WHERE pl.unit_id = '".$_REQUEST['TmpLayanan']."' $waktu $fKso
								GROUP BY kso.nama";
						$rsKso = mysql_query($qKso);
						$totJml = 0;
						$total = 0;
						while($rwKso = mysql_fetch_array($rsKso))
						{
				?>
				<tr>
					<td height="25" colspan="3" style="text-decoration:underline; padding-left:20px;"><b><?php echo $rwKso['nama'];?></b></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<?php 
						$qJns = "SELECT up.id AS id_parent, 
								ua.nama AS nama_asal,up.nama AS nama_parent
								FROM b_pelayanan pl
								INNER JOIN b_ms_unit ua ON pl.unit_id_asal = ua.id
								INNER JOIN b_ms_unit up ON ua.parent_id = up.id
								INNER JOIN b_kunjungan k ON pl.kunjungan_id = k.id
								INNER JOIN b_tindakan t ON t.pelayanan_id=pl.id
								WHERE pl.unit_id = '".$_REQUEST['TmpLayanan']."'
								$waktu AND pl.kso_id = '".$rwKso['id']."'
								GROUP BY up.nama";
						$rsJns = mysql_query($qJns);
						while($rwJns = mysql_fetch_array($rsJns))
						{
				?>
				<tr>
					<td>&nbsp;</td>
					<td colspan="2" style="text-transform:uppercase; font-weight:bold; padding-left:20px;"><?php echo $rwJns['nama_parent'];?></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<?php
						$qAsal = "SELECT t.id_parent, t.nama_asal, t.nama_parent, t.nama_sekarang, SUM(t.biaya) as biaya, COUNT(t.pasien_id) as jml
FROM (SELECT up.id AS id_parent, ua.nama AS nama_asal, up.nama AS nama_parent,
u.nama AS nama_sekarang, sum(t.biaya) as biaya, pl.pasien_id FROM b_pelayanan pl 
INNER JOIN b_ms_unit ua ON pl.unit_id_asal = ua.id 
INNER JOIN b_ms_unit up ON ua.parent_id = up.id 
INNER JOIN b_ms_unit u ON pl.unit_id = u.id 
INNER JOIN b_kunjungan k ON pl.kunjungan_id = k.id 
INNER JOIN b_tindakan t ON t.pelayanan_id=pl.id
WHERE ua.parent_id = '".$rwJns['id_parent']."' AND pl.unit_id = '".$_REQUEST['TmpLayanan']."' 
$waktu AND pl.kso_id = '".$rwKso['id']."' GROUP BY pl.pasien_id) AS t
GROUP BY t.nama_asal";
						$rsAsal = mysql_query($qAsal);
						$sub = 0;
						$jml = 0;
						while($rwAsal = mysql_fetch_array($rsAsal))
						{
				?>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td style="text-transform:uppercase; padding-left:20px;"><?php echo $rwAsal['nama_asal'];?></td>
					<td align="center"><?php echo $rwAsal['jml'];?></td>
					<td align="right"><?php echo number_format($rwAsal['biaya'],0,",",".");?>&nbsp;&nbsp;&nbsp;</td>
				</tr>
				<?php
							$sub = $sub + $rwAsal['jml'];
							$jml = $jml + $rwAsal['biaya'];
						}
							$totJml = $totJml + $sub;
							$total = $total + $jml; 
				?>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td style="font-weight:bold; padding-right:10px; text-align:right" height="25">&nbsp;Subtotal</td>
					<td style="border-top:1px solid #FF0000; text-align:center; font-weight:bold;"><?php echo $sub;?></td>
					<td style="border-top:1px solid #FF0000; text-align:right; font-weight:bold;"><?php echo number_format($jml,0,",",".");?>&nbsp;&nbsp;&nbsp;</td>
				</tr>
				<tr><td colspan="5"></tr>
				<?php
						}
							
						}
				?>
				<tr style="font-weight:bold">
					<td height="30" style="border-top:1px solid #006600; border-bottom:1px solid #006600;">&nbsp;</td>
					<td style="border-top:1px solid #006600; border-bottom:1px solid #006600;">&nbsp;</td>
					<td style="border-top:1px solid #006600; border-bottom:1px solid #006600; text-align:right; padding-right:10px;"><b>TOTAL</b></td>
					<td style="border-top:1px solid #006600; border-bottom:1px solid #006600; text-align:center"><b><?php echo $totJml?></b></td>
					<td style="border-top:1px solid #006600; border-bottom:1px solid #006600; text-align:right"><b><?php echo number_format($total,0,",",".")?></b>&nbsp;&nbsp;&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="right">Tgl Cetak: <?php echo $date_now;?>&nbsp;Jam: <?php echo $jam;?></td>
	</tr>
	<tr>
		<td align="right">Yang Mencetak,&nbsp;</td>
	</tr>
	<tr>
		<td height="50">&nbsp;</td>
	</tr>
	<tr>
		<td align="right"><b><?php echo $rwPeg['nama'];?></b>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><tr id="trTombol">
        <td class="noline" align="center">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
        </td>
    </tr></td>
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