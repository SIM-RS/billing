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
<title>.: Laporan Klaim Jaminan :.</title>
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
	
	$jnsLay = $_REQUEST['JnsLayanan'];
	$tmpLay = $_REQUEST['TmpLayanan'];
	$stsPas = $_REQUEST['StatusPas'];
	
	$sqlUnit1 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$jnsLay."'";
	$rsUnit1 = mysql_query($sqlUnit1);
	$rwUnit1 = mysql_fetch_array($rsUnit1);
	
	$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$tmpLay."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
	
	$sqlKso = "SELECT id,nama from b_ms_kso where id = '".$stsPas."'";
	$rsKso = mysql_query($sqlKso);
	$rwKso = mysql_fetch_array($rsKso);
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);
?>
<table width="800" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
	<tr>
		<td><b><?=$pemkabRS?><br>
			<?=$namaRS?><br>
			<?=$alamatRS?><br>
			Telepon <?=$tlpRS?><br/></b></td>
	</tr>
	<tr>
		<td height="70" valign="top" style="text-align:center; text-transform:uppercase; font-size:14px; font-weight:bold;">laporan klaim jaminan <?php echo $rwUnit1['nama'].'&nbsp;-&nbsp;'.$rwUnit2['nama']?><br><?php echo $Periode;?></td>
	</tr>
	<tr>
		<td height="30"><table width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;"><tr><td style="font-weight:bold;" width="50%">&nbsp;Tempat Layanan:&nbsp;<?php echo $rwUnit2['nama'];?></td><td width="50%" style="text-align:right">Yang Mencetak:&nbsp;<b><?php echo $rwPeg['nama'];?></b>&nbsp;</td></tr></table></td>
	</tr>
	<tr>
		<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
				<tr>
					<td width="13%" height="30" style="border-top:1px solid; border-bottom:1px solid; font-weight:bold;">&nbsp;Status Pasien</td>
					<td width="12%" style="border-top:1px solid; border-bottom:1px solid; font-weight:bold;">&nbsp;Tgl Kunjungan</td>
					<td width="7%" style="border-top:1px solid; border-bottom:1px solid; font-weight:bold;">&nbsp;No. RM</td>
					<td width="13%" style="border-top:1px solid; border-bottom:1px solid; font-weight:bold;">&nbsp;Nama Pasien</td>
					<td width="10%" style="border-top:1px solid; border-bottom:1px solid; font-weight:bold;">&nbsp;Tgl Transaksi</td>
					<td width="25%" style="border-top:1px solid; border-bottom:1px solid; font-weight:bold;">&nbsp;Uraian Layanan</td>
					<td width="10%" align="right" style="border-top:1px solid; border-bottom:1px solid; font-weight:bold;">Tarif Perda&nbsp;</td>
					<td width="10%" align="right" style="border-top:1px solid; border-bottom:1px solid; font-weight:bold;">Jaminan&nbsp;</td>
				</tr>
				<?php
					if($stsPas!=0) $fKso = "AND b_ms_kso.id = '".$stsPas."'";
					
					$qK = "SELECT b_ms_kso.id, b_ms_kso.nama FROM b_kunjungan
						INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
						INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
						INNER JOIN b_ms_kso ON b_ms_kso.id = b_kunjungan.kso_id
						WHERE b_pelayanan.unit_id = '".$tmpLay."' $waktu $fKso
						GROUP BY b_ms_kso.id
						ORDER BY b_ms_kso.nama";
					$rsK = mysql_query($qK);
					$totPerda = 0;
					$totJam = 0;
					while($rwK = mysql_fetch_array($rsK))
					{
				?>
				<tr>
					<td colspan="8" style="font-weight:bold; text-transform:uppercase; text-decoration:underline;">&nbsp;<?php echo $rwK['nama'];?></td>
				</tr>
				<?
					$sql = "SELECT DATE_FORMAT(b_kunjungan.tgl,'%d-%m-%Y') AS tgl,
						b_ms_pasien.no_rm, b_ms_pasien.nama, b_pelayanan.id AS pelayanan_id
						FROM b_ms_pasien
						INNER JOIN b_kunjungan ON b_kunjungan.pasien_id = b_ms_pasien.id
						INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
						INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
						WHERE b_pelayanan.unit_id = '".$tmpLay."' $waktu AND b_kunjungan.kso_id = '".$rwK['id']."'
						GROUP BY b_kunjungan.id";
					$rs = mysql_query($sql);
					$no = 1;
					$SsubPerda = 0;
					$SsubJam = 0;
					while($rw = mysql_fetch_array($rs))
					{
				?>
				<tr>
					<td style="padding-left:20px;"><?php echo $no;?></td>
					<td>&nbsp;<?php echo $rw['tgl'];?></td>
					<td>&nbsp;<?php echo $rw['no_rm'];?></td>
					<td style="text-transform:uppercase" colspan="5">&nbsp;<?php echo $rw['nama'];?></td>
				</tr>
				<?php
					$qTind = "SELECT b_kunjungan.id AS kunjungan_id, b_pelayanan.id AS pelayanan_id, DATE_FORMAT(b_pelayanan.tgl,'%d-%m-%Y') AS tgl,
						b_ms_tindakan.nama, b_tindakan.biaya AS perda, b_tindakan.biaya_kso AS jaminan
						FROM b_kunjungan
						INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
						INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
						INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id
						INNER JOIN b_ms_tindakan ON b_ms_tindakan.id = b_ms_tindakan_kelas.ms_tindakan_id
						WHERE b_pelayanan.id = '".$rw['pelayanan_id']."'";
					$rsTind = mysql_query($qTind);
					$subPerda = 0;
					$subJam = 0;
					while($rwTind = mysql_fetch_array($rsTind))
					{
				?>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;<?php echo $rwTind['tgl']?></td>
					<td>&nbsp;<?php echo $rwTind['nama']?></td>
					<td style="text-align:right; padding-right:10px;"><?php echo number_format($rwTind['perda'],0,",",".")?>&nbsp;</td>
					<td style="text-align:right; padding-right:10px;"><?php echo number_format($rwTind['jaminan'],0,",",".")?>&nbsp;</td>
				</tr>
				<?php
					$subPerda = $subPerda + $rwTind['perda'];
					$subJam = $subJam + $rwTind['jaminan'];
					}mysql_free_result($rsTind);
				?>
				<tr style="font-weight:bold;">
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td style="border-top:1px solid;">&nbsp;Subtotal</td>
					<td style="border-top:1px solid;">&nbsp;</td>
					<td style="border-top:1px solid; text-align:right; padding-right:10px;"><?php echo number_format($subPerda,0,",",".")?>&nbsp;</td>
					<td style="border-top:1px solid; text-align:right; padding-right:10px;"><?php echo number_format($subJam,0,",",".")?>&nbsp;</td>
				</tr>
				<?php
					$no++;
					$SsubPerda = $SsubPerda + $subPerda;
					$SsubJam = $SsubJam + $subJam;					
					}mysql_free_result($rs);
				?>
				<tr style="font-weight:bold;" height="30" valign="top">
					<td style="border-top:1px solid;">&nbsp;Subtotal</td>
					<td style="border-top:1px solid;">&nbsp;</td>
					<td style="border-top:1px solid;">&nbsp;</td>
					<td style="border-top:1px solid;">&nbsp;</td>
					<td style="border-top:1px solid;">&nbsp;</td>
					<td style="border-top:1px solid;">&nbsp;</td>
					<td style="border-top:1px solid; text-align:right; padding-right:10px;"><?php echo number_format($SsubPerda,0,",",".")?>&nbsp;</td>
					<td style="border-top:1px solid; text-align:right; padding-right:10px;"><?php echo number_format($SsubJam,0,",",".")?>&nbsp;</td>
				</tr>
				<?php
					$totPerda = $totPerda + $SsubPerda;
					$totJam = $totJam + $SsubJam;
					}mysql_free_result($rsK);
				?>
				<tr style="font-weight:bold;" height="30">
					<td style="border-top:1px solid; border-bottom:1px solid;">&nbsp;Total</td>
					<td style="border-top:1px solid; border-bottom:1px solid;">&nbsp;</td>
					<td style="border-top:1px solid; border-bottom:1px solid;">&nbsp;</td>
					<td style="border-top:1px solid; border-bottom:1px solid;">&nbsp;</td>
					<td style="border-top:1px solid; border-bottom:1px solid;">&nbsp;</td>
					<td style="border-top:1px solid; border-bottom:1px solid;">&nbsp;</td>
					<td style="border-top:1px solid; border-bottom:1px solid; text-align:right; padding-right:10px;"><?php echo number_format($totPerda,0,",",".")?>&nbsp;</td>
					<td style="border-top:1px solid; border-bottom:1px solid; text-align:right; padding-right:10px;"><?php echo number_format($totJam,0,",",".")?>&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td height="70" valign="top" align="right">Tgl. Cetak:&nbsp;<?php echo $date_now.'&nbsp;Jam:&nbsp;'.$jam;?>&nbsp;<br>Yang Mencetak,</td>
	</tr>
	<tr>
		<td align="right"><b><?php echo $rwPeg['nama'];?></b>&nbsp;</td>
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
</table>
<?php
    mysql_free_result($rsUnit1);
    mysql_free_result($rsUnit2);
    mysql_free_result($rsKso);
    mysql_free_result($rsPeg);
    mysql_close($konek);
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