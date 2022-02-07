<?php
session_start();
include("../../sesi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cara Keluar Pasien Berdasarkan Penujamin Pasien</title>
</head>

<?php
	include("../../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	
	$waktu = $_POST['cmbWaktu'];
	if($waktu == 'Harian'){
		$tglAwal = explode('-',$_REQUEST['tglAwal2']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$waktu = " and k.tgl = '$tglAwal2' ";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
	}
	else if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];
		$thn = $_POST['cmbThn'];
		$waktu = " and month(k.tgl) = '$bln' and year(k.tgl) = '$thn' ";
		$Periode = "Bulan $arrBln[$bln] Tahun $thn";
	}
	else{
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		//echo $arrBln[$tglAwal[1]];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = " and k.tgl between '$tglAwal2' and '$tglAkhir2' ";
		
		$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	}
	
	$sqlUnit1 = "SELECT id,nama,kode FROM b_ms_unit WHERE id = '".$_REQUEST['JnsLayanan']."'";
	$rsUnit1 = mysql_query($sqlUnit1);
	$rwUnit1 = mysql_fetch_array($rsUnit1);
	
	if($_REQUEST['TmpLayanan'] != "0"){
		$fUnit = "pl.unit_id = '".$_REQUEST['TmpLayanan']."'";
		$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayanan']."'";
		$rsUnit2 = mysql_query($sqlUnit2);
		$rwUnit2 = mysql_fetch_array($rsUnit2);
		$tmpNama = $rwUnit2['nama'];
	} else {
		$fUnit = "pl.jenis_layanan = '".$_REQUEST['JnsLayanan']."'";
		$tmpNama = "SEMUA";
	}
	
	$sqlKso = "SELECT id,nama from b_ms_kso where id = '".$_REQUEST['StatusPas']."'";
	$rsKso = mysql_query($sqlKso);
	$rwKso = mysql_fetch_array($rsKso);
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);

?>
<body>
<table width="800" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td colspan="3"><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
  </tr>
  <tr>
    <td colspan="3" align="center" height="70" valign="top" style="font-size:14px; text-transform:uppercase"><b>Laporan Cara Keluar Pasien Berdasarkan Penjamin Pasien<br />Jenis Layanan <?php echo $rwUnit1['nama'];?>&nbsp;Tempat Layanan <?php echo $tmpNama;?><br /><?php echo $Periode;?></b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="right">Yang Mencetak :&nbsp;<b><?php echo $rwPeg['nama'];?></b>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="right">Tanggal Cetak :&nbsp;<?php echo $date_now;?> Jam : <?php echo $jam;?>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  	<td colspan="3">
		<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:11px">
			<tr>
				<td>&nbsp;</td>
				<td colspan="2">&nbsp;JUMLAH/CARA KELUAR</td>
			  </tr>
			  <tr>
				<td width="100" height="28">&nbsp;STATUS PASIEN</td>
				<?php
					$qck = "SELECT pk.cara_keluar, k.kso_id
							FROM b_pasien_keluar pk
							INNER JOIN b_pelayanan pl ON pl.id = pk.pelayanan_id
							INNER JOIN b_kunjungan k ON k.id = pl.kunjungan_id
							WHERE $fUnit $waktu
							GROUP BY pk.cara_keluar";
					$rsck = mysql_query($qck);
					$col = 0;
					while($rwck = mysql_fetch_array($rsck))
					{
						$col++;
				?>
				<td width="80" style="border-left:1px solid; border-top:1px solid; text-align:right;"><?php echo $rwck['cara_keluar'];?>&nbsp;</td>
				<?php } ?>
				<td width="80" style="border-left:1px solid; border-top:1px solid; text-align:right; border-right:1px solid;">TOTAL&nbsp;</td>
			  </tr>
			  <?php
						
				$stsPas=$_REQUEST['StatusPas'];
				if($stsPas == 0) {
					$qSt = "SELECT kso.id, kso.nama
							FROM b_ms_kso kso
							INNER JOIN b_kunjungan k ON kso.id = k.kso_id
							INNER JOIN b_pelayanan pl ON pl.kunjungan_id = k.id
							INNER JOIN b_pasien_keluar pk ON pk.pelayanan_id = pl.id
							WHERE $fUnit $waktu
							GROUP BY kso.nama";
					$rsSt = mysql_query($qSt);
				}else{
					$qSt = "SELECT id, nama FROM b_ms_kso WHERE id = '".$stsPas."'";
					$rsSt = mysql_query($qSt);
				}
					$ttlTot = 0;
					while($rwSt = mysql_fetch_array($rsSt))
					{
						$tot = 0;
			  ?>
			  <tr>
				<td style="border-left:1px solid; border-top:1px solid;" height="20">&nbsp;<?php echo $rwSt['nama'];?></td>
				<?php
					$rsck = mysql_query($qck);
					$j = 0;
					while($rwck=mysql_fetch_array($rsck))
					{
						$qJml = "SELECT COUNT(pl.pasien_id) AS jml
								FROM b_pasien_keluar pk
								INNER JOIN b_pelayanan pl ON pl.id = pk.pelayanan_id
								INNER JOIN b_kunjungan k ON k.id = pl.kunjungan_id
								WHERE $fUnit
								  AND pk.cara_keluar = '".$rwck['cara_keluar']."' 
								  AND k.kso_id = '".$rwSt['id']."' $waktu";
						$rsJml = mysql_query($qJml);
						$rwJml = mysql_fetch_array($rsJml);
						$tot = $tot + $rwJml['jml'];
						$jml[$j] += $rwJml['jml'];
						$j++;
				?>
				<td style="border-left:1px solid; border-top:1px solid; text-align:right;"><?php if($rwJml['jml']=="") echo 0; else echo $rwJml['jml'];?>&nbsp;</td>
				<?php
					}
					mysql_free_result($rsck);
					$ttlTot += $tot;
				?>
				<td style="border-left:1px solid; border-top:1px solid; text-align:right; border-right:1px solid;"><?php echo $tot;?>&nbsp;</td>
			  </tr>
			  <?php
					}
					mysql_free_result($rsSt);
			  ?>
			  <tr>
				<td style="border-left:1px solid; border-top:1px solid; text-align:right; border-bottom:1px solid;" height="20">Total&nbsp;</td>
				<?php
					for($i=0; $i<$col; $i++){
				?>
				<td style="border-left:1px solid; border-top:1px solid; text-align:right; border-bottom:1px solid;"><?php echo $jml[$i];?>&nbsp;</td>
				<?php
					}
				?>
				<td style="border-left:1px solid; border-top:1px solid; text-align:right; border-bottom:1px solid; border-right:1px solid;"><?php echo $ttlTot;?>&nbsp;</td>
			  </tr>
		</table>
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr id="trTombol">
        <td colspan="3" class="noline" align="center">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>        </td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php
	mysql_free_result($rsUnit1);
	mysql_free_result($rsKso);
	mysql_free_result($rsPeg);
	mysql_close($konek);
?>
</body>
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
