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
<title>.: Laporan Kegiatan Pelayanan Pasien :.</title>
<?php
include("../../koneksi/konek.php");
$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');

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
	$fUnit = " AND p.unit_id=".$_REQUEST['TmpLayanan'];
}else
	$fUnit = " AND mu.parent_id=".$_REQUEST['JnsLayanan'];

$stsPas=$_REQUEST['StatusPas'];
if($stsPas != 0) {
    $fKso = " AND t.kso_id = $stsPas ";
    $qJnsLay=mysql_query("select nama from b_ms_kso where id=".$stsPas);
    $rwJnsLay=mysql_fetch_array($qJnsLay);
}

$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
$rsPeg = mysql_query($sqlPeg);
$rwPeg = mysql_fetch_array($rsPeg);
?>
<table border="0" cellpadding="0" cellspacing="0" width="800" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
	<tr>
		<td><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
	</tr>
	<tr>
		<td height="70" valign="top" style="text-align:center; font-size:14px; font-weight:bold; text-transform:uppercase">laporan kegiatan pelayanan pasien <?php echo $rwTmpLay['nama'];?><br /><?php echo $Periode;?></td>
	</tr>
	<tr>
		<td>&nbsp;<b>
		Penjamin Pasien&nbsp;:&nbsp;
                    <?php
                    if($stsPas==0) echo 'Semua';
                    else echo $rwJnsLay['nama'];
                    ?></b></td>
	</tr>
	<tr>
		<td>
			<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
				<tr style="font-size:12px; font-weight:bold;">
					<td height="30" width="20%" style="border-top:1px solid; border-bottom:1px solid;">&nbsp;Kelompok Layanan</td>
					<td width="35%" style="border-top:1px solid; border-bottom:1px solid;">&nbsp;Uraian Layanan</td>
					<td align="right" width="15%" style="border-top:1px solid; border-bottom:1px solid; padding-right:20px;">Tarif Perda</td>
					<td align="right" width="15%" style="border-top:1px solid; border-bottom:1px solid; padding-right:20px;">Jumlah Layanan</td>
					<td align="right" width="15%" style="border-top:1px solid; border-bottom:1px solid; padding-right:20px;">Total</td>
				</tr>
				<?php
						$qLay = "SELECT kt.id, kt.nama FROM b_kunjungan k
								INNER JOIN b_pelayanan pl ON pl.kunjungan_id = k.id
								INNER JOIN b_tindakan t ON t.pelayanan_id = pl.id
								INNER JOIN b_ms_tindakan_kelas tk ON tk.id = t.ms_tindakan_kelas_id
								INNER JOIN b_ms_tindakan mt ON mt.id = tk.ms_tindakan_id 
								INNER JOIN b_ms_kelompok_tindakan kt ON kt.id = mt.kel_tindakan_id
								WHERE pl.unit_id = '".$_REQUEST['TmpLayanan']."' $waktu $fKso
								GROUP BY kt.nama";
						$rsLay = mysql_query($qLay);
							$jmlT = 0;
							$totT = 0;
						while($rwLay = mysql_fetch_array($rsLay))
						{
				?>
				<tr>
					<td colspan="5">&nbsp;<b><?php echo $rwLay['nama'];?></b></td>
				</tr>
				<?php
						$sql = "SELECT mt.id, mt.nama AS layanan, t.biaya, 
								COUNT(pl.pasien_id) AS jml, t.biaya*COUNT(pl.pasien_id) AS total
								FROM b_kunjungan k 
								INNER JOIN b_pelayanan pl ON pl.kunjungan_id = k.id 
								INNER JOIN b_tindakan t ON t.pelayanan_id = pl.id 
								INNER JOIN b_ms_tindakan_kelas tk ON tk.id = t.ms_tindakan_kelas_id 
								INNER JOIN b_ms_tindakan mt ON mt.id = tk.ms_tindakan_id
								INNER JOIN b_ms_kelompok_tindakan kt ON kt.id = mt.kel_tindakan_id
								WHERE kt.id = '".$rwLay['id']."' 
								AND pl.unit_id = '".$_REQUEST['TmpLayanan']."'
								$waktu $fKso
								GROUP BY mt.nama";
						$rs = mysql_query($sql);
						$no=1;
						$jml = 0;
						$tot = 0;
						while($rw = mysql_fetch_array($rs))
						{
							
				?>
				<tr>
					<td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $no;?></td>
					<td style="text-transform:uppercase">&nbsp;<?php echo $rw['layanan']?></td>
					<td align="right" style="padding-right:20px;"><?php echo number_format($rw['biaya'],0,",",".")?></td>
					<td align="right" style="padding-right:20px;">&nbsp;<?php echo $rw['jml']?></td>
					<td style="padding-right:20px; text-align:right"><?php echo number_format($rw['total'],0,",",".");?></td>
				</tr>
				<?php
						$no++;
						$jml = $jml + $rw['jml'];
						$tot = $tot + $rw['total'];
						}
							
						
				?>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td style="border-top:1px solid;">&nbsp;Subtotal</td>
					<td style="border-top:1px solid; text-align:right; padding-right:20px;"><?php echo $jml;?></td>
					<td style="border-top:1px solid; text-align:right; padding-right:20px;"><?php echo number_format($tot,0,",",".");?></td>
				</tr>
				<tr><td colspan="5">&nbsp;</td></tr>
				<?php
						$jmlT = $jmlT + $jml;
						$totT = $totT + $tot;
					}
				?>
				<tr>
					<td height="30" style="border-top:1px solid; border-bottom:1px solid;">&nbsp;</td>
					<td style="border-top:1px solid; border-bottom:1px solid;">&nbsp;</td>
					<td style="border-top:1px solid; border-bottom:1px solid;">&nbsp;<b>Total</b></td>
					<td style="border-top:1px solid; border-bottom:1px solid; text-align:right; padding-right:20px;">&nbsp;<b><?php echo $jmlT;?></b></td>
					<td style="border-top:1px solid; border-bottom:1px solid; text-align:right; padding-right:20px;">&nbsp;<b><?php echo number_format($totT,0,",",".");?></b></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr id="trTombol">
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
    </tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
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