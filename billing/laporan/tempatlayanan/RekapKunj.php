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
	$fUnit = " pl.unit_id = ".$_REQUEST['TmpLayanan'];
	$tmpNama = $rwTmpLay['nama'];
}else{
	$fUnit = " pl.jenis_layanan = ".$_REQUEST['JnsLayanan'];
	$tmpNama = "SEMUA";
}

$stsPas=$_REQUEST['StatusPas'];
if($stsPas != 0) {
    $fKso = " AND k.kso_id = $stsPas ";
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
		<td height="70" valign="top" style="text-align:center; font-weight:bold; font-size:14px; text-transform:uppercase">rekapitulasi kunjungan <?php echo $tmpNama;?><br><?php echo $Periode;?></td>
	</tr>
	<tr>
		<td>
			<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
				<tr style="font-size:12px; font-weight:bold; height:30">
					<td width="20%" style="border-top:1px solid; border-bottom:1px solid; text-align:center;">Penjamin Pasien</td>
					<td width="25%" style="border-top:1px solid; border-bottom:1px solid; text-align:center;">Jenis Layanan</td>
					<td width="25%" style="border-top:1px solid; border-bottom:1px solid; text-align:center;">Tempat Layanan Asal</td>
					<td width="15%" style="border-top:1px solid; border-bottom:1px solid; text-align:center;">Jumlah Pasien</td>
					<td width="15%" style="border-top:1px solid; border-bottom:1px solid; text-align:center;">Biaya</td>
				</tr>
				<?php
						$qKso = "SELECT kso.nama, kso.id FROM b_ms_kso kso
								INNER JOIN b_kunjungan k ON k.kso_id = kso.id
								INNER JOIN b_pelayanan pl ON pl.kunjungan_id = k.id
								LEFT JOIN b_tindakan t on t.pelayanan_id = pl.id
								WHERE $fUnit $waktu $fKso
								GROUP BY kso.nama";
						$rsKso = mysql_query($qKso);
						$totJml = 0;
						$total = 0;
						while($rwKso = mysql_fetch_array($rsKso))
						{
				?>
				<tr>
					<td colspan="3" style="text-transform:uppercase; text-decoration:underline;">&nbsp;<b><?php echo $rwKso['nama'];?></b></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<?php 
						$qJns = "SELECT up.nama AS nama_parent, up.id AS id_parent, pl.unit_id
								FROM b_kunjungan k
								INNER JOIN b_pelayanan pl ON pl.kunjungan_id = k.id
								INNER JOIN b_ms_unit u ON pl.unit_id_asal = u.id
								INNER JOIN b_ms_unit up ON u.parent_id = up.id
								LEFT JOIN b_tindakan t ON t.pelayanan_id = pl.id
								WHERE $fUnit $waktu 
								AND k.kso_id = '".$rwKso['id']."'
								GROUP BY up.nama";
						$rsJns = mysql_query($qJns);
						while($rwJns = mysql_fetch_array($rsJns))
						{
				?>
				<tr>
					<td>&nbsp;</td>
					<td colspan="2" style="text-transform:uppercase;">&nbsp;<?php echo $rwJns['nama_parent'];?></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<?php
						$qAsal = "SELECT t1.nama as nama_asal, COUNT(t1.id) AS jml, 
						   		SUM(t1.biaya) AS biaya 
								FROM (SELECT u.nama, k.id, SUM(t.biaya) AS biaya 
								FROM b_pelayanan pl 
								INNER JOIN b_kunjungan k ON pl.kunjungan_id= k.id 
								INNER JOIN b_ms_unit u ON pl.unit_id_asal = u.id 
								INNER JOIN b_ms_unit un ON un.id = pl.unit_id
								INNER JOIN b_ms_kso kso ON k.kso_id = kso.id 
								LEFT JOIN b_tindakan t ON t.pelayanan_id = pl.id 
								WHERE un.id = '".$rwJns['unit_id']."' 
								AND u.parent_id = '".$rwJns['id_parent']."' 
								$waktu AND k.kso_id = '".$rwKso['id']."' GROUP BY k.id) AS t1
								GROUP BY t1.nama";
						$rsAsal = mysql_query($qAsal);
						$sub = 0;
						$jml = 0;
						while($rwAsal = mysql_fetch_array($rsAsal))
						{
				?>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td style="text-transform:uppercase;">&nbsp;<?php echo $rwAsal['nama_asal'];?></td>
					<td style="text-align:right; padding-right:25px;"><?php echo $rwAsal['jml'];?></td>
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
					<td style="border-top:1px solid;">&nbsp;Subtotal</td>
					<td style="border-top:1px solid; text-align:right; padding-right:25px;"><?php echo $sub;?></td>
					<td style="border-top:1px solid; text-align:right"><?php echo number_format($jml,0,",",".");?>&nbsp;&nbsp;&nbsp;</td>
				</tr>
				<tr><td colspan="5"></tr>
				<?php
						}
							
						}
				?>
				<tr style="font-weight:bold">
					<td height="30" style="border-top:1px solid; border-bottom:1px solid;">&nbsp;</td>
					<td style="border-top:1px solid; border-bottom:1px solid;">&nbsp;</td>
					<td style="border-top:1px solid; border-bottom:1px solid;">&nbsp;<b>Total</b></td>
					<td style="border-top:1px solid; border-bottom:1px solid; text-align:right; padding-right:25px;"><b><?php echo $totJml?></b></td>
					<td style="border-top:1px solid; border-bottom:1px solid; text-align:right"><b><?php echo number_format($total,0,",",".")?></b>&nbsp;&nbsp;&nbsp;</td>
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
		<td style="text-align:right; text-transform:uppercase;"><b><?php echo $rwPeg['nama'];?></b>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><tr id="trTombol">
        <td class="noline" align="center">
        <?php 
            if($_POST['export']!='excel'){
         ?>
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
         <?php 
            }
         ?>
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