<?php
session_start();
include("../../sesi.php");
if($_POST['isExcel']=='yes'){
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="form_RL5.1.xls"');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cara Bayar Pasien Berdasarkan Tempat Layanan</title>
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
		//$waktu = " AND (DATE(b_kunjungan.tgl_pulang) = '$tglAwal2' OR DATE(b_pelayanan.tgl_krs) = '$tglAwal2') ";
		$waktu = " AND b_pelayanan.tgl = '$tglAwal2' ";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
	}
	else if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];
		$thn = $_POST['cmbThn'];
		//$waktu = "  AND ((month(b_kunjungan.tgl_pulang) = '$bln' and year(b_kunjungan.tgl_pulang) = '$thn') OR  (month(b_pelayanan.tgl_krs) = '$bln' and year(b_pelayanan.tgl_krs) = '$thn')) ";
		$waktu = " AND month(b_pelayanan.tgl) = '$bln' and year(b_pelayanan.tgl) = '$thn' ";
		$Periode = "Bulan $arrBln[$bln] Tahun $thn";
	}
	else{
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		//echo $arrBln[$tglAwal[1]];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		//$waktu = "  and ((DATE(b_kunjungan.tgl_pulang) between '$tglAwal2' and '$tglAkhir2') OR (DATE(b_pelayanan.tgl_krs) between '$tglAwal2' and '$tglAkhir2')) ";
		$waktu = " AND b_pelayanan.tgl between '$tglAwal2' and '$tglAkhir2' ";
		
		$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	}
	
	$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayanan']."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
	
	$sqlKso = "SELECT id,nama from b_ms_kso where id = '".$_REQUEST['StatusPas']."'";
	$rsKso = mysql_query($sqlKso);
	$rwKso = mysql_fetch_array($rsKso);
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);

?>
<table width="800" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
  </tr>
  <tr>
    <td align="center" height="70" valign="top" style="font-size:14px; text-transform:uppercase"><b>Laporan Cara Bayar Pasien <?php echo $rwKso['nama'];?><br />Berdasarkan Tempat Layanan <?php if($rwUnit2['nama']=="") echo 'Semua'; else echo $rwUnit2['nama'] ?><br /><?php echo $Periode;?></b></td>
  </tr>
    <tr><td align="right">Yang Mencetak :&nbsp;<b><?php echo $rwPeg['nama'];?></b>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Tgl Cetak:&nbsp;<?php echo $date_now.'&nbsp;Jam:&nbsp;'.$jam;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
  	<td>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
			<tr>
				<td>&nbsp;</td>
				<td colspan="3">&nbsp;JUMLAH/CARA BAYAR PASIEN</td>
			  </tr>
			  <tr>
				<td width="100" height="28" style="border-bottom:1px solid;">&nbsp;TEMPAT LAYANAN</td>
				<?php
					$fKso = '';
					// hafiz - edit field agar jumlah balance
					$semuaTmpLayanan = [];
					$query = mysql_query("SELECT id, nama FROM b_ms_unit WHERE aktif=1 AND parent_id='".$_REQUEST['JnsLayanan']."' ORDER BY nama");

					if($_REQUEST['StatusPas'] <> 0){
						$fKso = " and b_pelayanan.kso_id = '".$_REQUEST['StatusPas']."'";
					}
					// ========================
					if($_REQUEST['TmpLayanan']==0) {
						while(($row =  mysql_fetch_assoc($query))) {
							$semuaTmpLayanan[] = $row['id'];
						}
						// $imploded_arr = implode("','",$semuaTmpLayanan);
						$fTmp = " b_pelayanan.unit_id IN('".implode("','",$semuaTmpLayanan)."') ";
						// $fTmp = " b_pelayanan.jenis_layanan = '".$_REQUEST['JnsLayanan']."' ";
					}
					else {
						$fTmp = " b_pelayanan.unit_id = '".$_REQUEST['TmpLayanan']."' ";
					}
					$sqlCM = "SELECT b_ms_kso.id, b_ms_kso.nama FROM b_kunjungan 
							INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
							INNER JOIN b_ms_kso ON b_ms_kso.id = b_pelayanan.kso_id
							WHERE $fTmp $waktu $fKso
							GROUP BY b_pelayanan.kso_id";
					$rsCM = mysql_query($sqlCM);
					$col = 0;
					while($rwCM = mysql_fetch_array($rsCM)) {
						$col++;
						?>
				<td width="80" style="border-left:1px solid; border-top:1px solid; text-align:right; border-bottom:1px solid;"><?php echo $rwCM['nama'];?>&nbsp;</td>
				  <?php
				}mysql_free_result($rsCM);
				?>
				<td width="80" style="border-bottom:1px solid; border-left:1px solid; border-right:1px solid; border-top:1px solid; text-align:right;">TOTAL&nbsp;</td>
			  </tr>
				<?php
					$sqlAK = "SELECT b_ms_unit.id, b_ms_unit.nama FROM b_kunjungan 
							INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
							INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id
							WHERE $fTmp $waktu $fKso
							GROUP BY b_ms_unit.id";
					$rsAK = mysql_query($sqlAK);
					$ttlTot = 0;
					while($rwAK = mysql_fetch_array($rsAK)) {
						$tot=0;
				?>
			  <tr>
				<td style="border-left:1px solid; border-bottom:1px solid;" height="20">&nbsp;<?php echo $rwAK['nama'] ?></td>
				<?php
					$kso = " and b_ms_kso.kso_id = '".$rwAK['kso_id']."'";
					$rsCM = mysql_query($sqlCM);
					$j = 0;
					while($rwCM = mysql_fetch_array($rsCM)) {
						$sqlJml = "SELECT COUNT(id) AS jml
								FROM
								(SELECT b_pelayanan.id
								FROM b_pelayanan
								  inner join b_kunjungan
								    on b_pelayanan.kunjungan_id = b_kunjungan.id
								WHERE b_pelayanan.unit_id = '".$rwAK['id']."' $waktu and b_pelayanan.kso_id = '".$rwCM['id']."') AS st1";
						$rsJml = mysql_query($sqlJml);
						$rwJml = mysql_fetch_array($rsJml);
						$tot = $tot+$rwJml['jml'];
						$jml[$j] += $rwJml['jml'];
						$j++;
						?>
				  <td style="border-left:1px solid; border-bottom:1px solid; text-align:right;">&nbsp;<?php if($rwJml['jml']=="") echo 0; else echo $rwJml['jml'];?>&nbsp;</td>
						<?php
					}mysql_free_result($rsCM);
					$ttlTot += $tot;
					?>
				  <td style="border-left:1px solid; border-bottom:1px solid; text-align:right; border-right:1px solid;"><?php echo $tot;?>&nbsp;</td>
				</tr>
				  <?php
				}mysql_free_result($rsAK);
					?>
				<tr>
				  <td style="border-left:1px solid; text-align:right; border-bottom:1px solid;" height="20">Total&nbsp;</td>
				  <?php
				  for($i=0; $i<$col; $i++){
					?>
				  <td style="border-left:1px solid; text-align:right; border-bottom:1px solid;" height="20"><?php echo $jml[$i]?>&nbsp;</td>
					<?php
			
				  }
				  ?>
				  <td style="border-left:1px solid; text-align:right; border-bottom:1px solid; border-right:1px solid;"><?php echo $ttlTot;?>&nbsp;</td>
				</tr>
		</table>
	</td>
  </tr>
	<tr><td height="30">&nbsp;</td></tr>
	<tr id="trTombol">
        <td class="noline" align="center">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>        </td>
    </tr>
	<tr><td height="30">&nbsp;</td></tr>
</table>
</body>
</html>
<?php
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