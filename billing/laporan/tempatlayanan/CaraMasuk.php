<?php
session_start();
include("../../sesi.php");
?>
<title>Cara Masuk Pasien Berdasarkan Tempat Layanan</title>
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
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);
	
	$StatusPas=$_REQUEST['StatusPas'];
	if($StatusPas != 0) {
    	$fKso = " AND b_kunjungan.kso_id = $StatusPas ";
	}
	
	if($_REQUEST['TmpLayanan'] != '0'){
		$fUnit = "b_pelayanan.unit_id = '".$_REQUEST['TmpLayanan']."'";
		$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayanan']."'";
		$rsUnit2 = mysql_query($sqlUnit2);
		$rwUnit2 = mysql_fetch_array($rsUnit2);
		$tmpNama = $rwUnit2['nama'];
	} else {
		$fUnit = "b_ms_unit.parent_id = '".$_REQUEST['JnsLayanan']."'";
		$tmpNama = "SEMUA";
	}
?>
<table border="0" cellpadding="0" cellspacing="0" width="700" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
	<tr>
		<td><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
	</tr>
	<tr>
		<td valign="top" height="70" style="text-align:center; font-size:14px; text-transform:uppercase; font-weight:bold;">laporan cara masuk pasien berdasarkan tempat layanan<br><?php echo $Periode;?></td>
	</tr>
	<tr>
		<td align="right">Yang Mencetak :&nbsp;<b><?php echo $rwPeg['nama'];?></b>&nbsp;</td>
	</tr>
	<tr>
		<td align="right">Tgl Cetak:&nbsp;<?php echo $date_now.'&nbsp;Jam:&nbsp;'.$jam;?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
			<table border="0" width="60%" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;" align="center">
				<tr>
					<td width="60%">&nbsp;</td>
					<td width="40%">&nbsp;JUMLAH/TEMPAT LAYANAN</td>
				</tr>
				<tr>
					<td style="border-bottom:1px solid">&nbsp;CARA MASUK</td>
					<td style="text-align:right; padding-right:20px; border-bottom:1px solid; border-top:1px solid; border-left:1px solid; border-right:1px solid;">&nbsp;<?php echo $tmpNama;?></td>
				</tr>
				<?php
					$qAr = "SELECT b_ms_asal_rujukan.id, b_ms_asal_rujukan.nama, COUNT(b_kunjungan.pasien_id) AS jml FROM b_kunjungan
INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
INNER JOIN b_ms_asal_rujukan ON b_ms_asal_rujukan.id = b_kunjungan.asal_kunjungan
INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id
WHERE $fUnit $waktu $fKso
GROUP BY b_kunjungan.asal_kunjungan";
					$rsAr = mysql_query($qAr);
					$jml = 0;
					while($rwAr = mysql_fetch_array($rsAr))
					{
				?>
				<tr>
					<td style="border-left:1px solid; border-bottom:1px solid">&nbsp;<?php echo $rwAr['nama'];?></td>
					<td style="text-align:right; padding-right:20px; border-bottom:1px solid; border-left:1px solid; border-right:1px solid">&nbsp;<?php echo $rwAr['jml'];?></td>
				</tr>
				<?php
						$jml = $jml + $rwAr['jml'];
					}mysql_free_result($rsAr);
				?>
				<tr>
					<td style="border-left:1px solid; border-bottom:1px solid; text-align:right">Total&nbsp;</td>
					<td style="border-bottom:1px solid; border-left:1px solid; border-right:1px solid; text-align:right; padding-right:20px;">&nbsp;<?php echo $jml?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	 <tr id="trTombol">
        <td class="noline" align="center">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>        </td>
    </tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
<?php
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