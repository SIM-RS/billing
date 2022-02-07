<?php
session_start();
include("../../sesi.php");

if($_POST['isExcel']=='yes'){
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="kegiatanPelayanan.xls"');
}

?>
<title>.: Laporan Kegiatan Pelayanan Tempat Layanan :.</title>
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
		
	$sqlUnit2 = "SELECT id, nama FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayanan']."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
		
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);
?>

<table width="800" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
	<tr>
		<td><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
	</tr>
	<tr>
		<td style="text-transform:uppercase; font-size:14px; font-weight:bold; text-align:center" height="70" valign="top">Laporan Kegiatan Pelayanan Tempat Layanan<br><?php echo $Periode;?></td>
	</tr>
	<tr>
		<td height="30">&nbsp;<b>Tempat Layanan:&nbsp;<?php if($_REQUEST['TmpLayanan']==0) echo "Semua"; else echo $rwUnit2['nama']?></b><table width="400" align="right" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;"><tr><td valign="top" align="right">Yang Mencetak:&nbsp;<b><?php echo $rwPeg['nama'];?></b></td></tr></table></td>
	</tr>
	<tr>
		<td>
		<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
			<tr style="font-weight:bold">
				<td width="7%" height="30" style="border-bottom:1px solid; border-top:1px solid;">&nbsp;TL</td>
				<td width="55%" style="border-bottom:1px solid; border-top:1px solid;">&nbsp;Kelompok - Uraian Layanan</td>
				<td width="10%" style="border-bottom:1px solid; border-top:1px solid;">&nbsp;Kelas</td>
				<td width="15%" align="right" style="border-bottom:1px solid; border-top:1px solid;">Tarif Perda&nbsp;</td>
				<td width="13%" align="right" style="border-bottom:1px solid; border-top:1px solid;">Jumlah Layanan&nbsp;</td>
			</tr>
			<?php
				if($_REQUEST['TmpLayanan']!=0){
					$fUnit = "b_pelayanan.unit_id = '".$_REQUEST['TmpLayanan']."'";
				}else{
					$fUnit = "b_pelayanan.jenis_layanan = '".$_REQUEST['JnsLayanan']."'";
				}
				if($_REQUEST['StatusPas']!=0)
					$fKso = "AND b_kunjungan.kso_id = '".$_REQUEST['StatusPas']."'";
					
				$qUnit = "SELECT b_ms_unit.id, b_ms_unit.nama FROM b_kunjungan
						INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
						INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
						INNER JOIN b_ms_unit ON b_pelayanan.unit_id = b_ms_unit.id
						WHERE $fUnit $fKso $waktu
						GROUP BY b_ms_unit.id";
				$rsUnit = mysql_query($qUnit);
				$tot = 0;
				while($rwUnit = mysql_fetch_array($rsUnit))
				{
			?>
			<tr>
				<td colspan="5" height="30" valign="bottom" style="font-weight:bold; text-transform:uppercase; text-decoration:underline">&nbsp;<?php echo $rwUnit['nama'];?></td>
			</tr>
			<?php
					$qKel = "SELECT b_ms_kelompok_tindakan.id, b_ms_kelompok_tindakan.nama 
					   FROM b_ms_kelompok_tindakan
						INNER JOIN b_ms_tindakan ON b_ms_tindakan.kel_tindakan_id = b_ms_kelompok_tindakan.id
						INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.ms_tindakan_id = b_ms_tindakan.id
						INNER JOIN b_tindakan ON b_tindakan.ms_tindakan_kelas_id = b_ms_tindakan_kelas.id
						INNER JOIN b_pelayanan ON b_pelayanan.id = b_tindakan.pelayanan_id
						INNER JOIN b_kunjungan ON b_kunjungan.id = b_pelayanan.kunjungan_id
						WHERE b_pelayanan.unit_id = '".$rwUnit['id']."' $waktu $fKso
						GROUP BY b_ms_kelompok_tindakan.id";
					$rsKel = mysql_query($qKel);
					while($rwKel = mysql_fetch_array($rsKel))
					{
			?>
			<tr>
				<td colspan="5" style="text-align:left; padding-left:30px; font-weight:bold; text-transform:uppercase">&nbsp;<?php echo $rwKel['nama']?></td>
			</tr>
			<?php
					$sql = "SELECT b_ms_tindakan.id, b_ms_tindakan.nama, b_ms_kelas.nama AS kelas, b_tindakan.biaya, 
						COUNT(b_tindakan.id) AS jml FROM b_ms_kelompok_tindakan
						INNER JOIN b_ms_tindakan ON b_ms_tindakan.kel_tindakan_id = b_ms_kelompok_tindakan.id
						INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.ms_tindakan_id = b_ms_tindakan.id
						INNER JOIN b_tindakan ON b_tindakan.ms_tindakan_kelas_id = b_ms_tindakan_kelas.id
						INNER JOIN b_pelayanan ON b_pelayanan.id = b_tindakan.pelayanan_id
						INNER JOIN b_kunjungan ON b_kunjungan.id = b_pelayanan.kunjungan_id
						INNER JOIN b_ms_kelas ON b_ms_kelas.id = b_ms_tindakan_kelas.ms_kelas_id
						WHERE b_ms_kelompok_tindakan.id = '".$rwKel['id']."' AND b_pelayanan.unit_id = '".$rwUnit['id']."'
						$waktu $fKso
						GROUP BY b_ms_tindakan.id";
					//echo $sql."<br>";
					$rs = mysql_query($sql);
					$no = 1;
					$sub = 0;
					while($rw = mysql_fetch_array($rs))
					{
			?>
			<tr>
				<td align="right"><?php echo $no;?>&nbsp;</td>
				<td style="padding-left:10px; text-transform:uppercase;">&nbsp;<?php echo $rw['nama'];?></td>
				<td>&nbsp;<?php echo $rw['kelas'];?></td>
				<td align="right"><?php echo number_format($rw['biaya'],0,",",".")?>&nbsp;</td>
				<td align="right"><?php echo $rw['jml']?>&nbsp;</td>
			</tr>
			<?php
				
					$no++;
					$sub = $sub + $rw['jml'];
					}mysql_free_result($rs);
			?>
			<tr style="font-weight:bold">
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="right" style="border-top:1px solid;">Subtotal&nbsp;</td>
				<td style="border-top:1px solid; text-align:right"><?php echo $sub;?>&nbsp;</td>
			</tr>
			<?php 
					$tot = $tot + $sub;
					}mysql_free_result($rsKel);
					}mysql_free_result($rsUnit);
			?>
			<tr height="30" style="font-weight:bold">
				<td style="border-bottom:1px solid; border-top:1px solid;">&nbsp;</td>
				<td style="border-bottom:1px solid; border-top:1px solid;">&nbsp;</td>
				<td align="right" style="border-bottom:1px solid; border-top:1px solid;">&nbsp;</td>
				<td align="right" style="border-bottom:1px solid; border-top:1px solid;">Total&nbsp;</td>
				<td style="border-bottom:1px solid; border-top:1px solid; text-align:right"><?php echo $tot;?>&nbsp;</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="right">Tgl Cetak: <?php echo $date_now.'&nbsp;Jam:&nbsp;'.$jam;?>&nbsp;</td>
	</tr>
	<tr>
		<td align="right" height="50" valign="top">Yang Mencetak,&nbsp;</td>
	</tr>
	<tr>
		<td align="right"><b><?php echo $rwPeg['nama'];?></b>&nbsp;</td>
	</tr>
	<tr id="trTombol">
  	<td align="center" class="noline">
		<input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
        <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>	</td>
  </tr>
</table>
<?php
	mysql_free_result($rsUnit2);
	mysql_free_result($rsPeg);
	mysql_close($konek);
?>
<script type="text/JavaScript">
    function cetak(tombol){
        tombol.style.visibility='hidden';
        if(tombol.style.visibility=='hidden'){
		window.print();
		window.close();
        }
    }
</script>