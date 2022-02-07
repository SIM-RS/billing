<?php
session_start();
include("../../sesi.php");
?>
<?php 
if($_POST['export']=='excel'){
header("Content-type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="Lap Buk Realisasi Produksi.xls"');
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
	$tglAwal3 = $tglAwal[2].'-'.($tglAwal[1]-1).'-'.$tglAwal[0];
	$waktu = " AND p.tgl = '$tglAwal2' ";
	$waktu2 = " AND p.tgl = '$tglAwal3' ";
	$waktu_ranap = " AND k.tgl = '$tglAwal2' ";
	$waktu_ranap2 = " AND k.tgl = '$tglAwal3' ";
	
	$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
}
else if($waktu == 'Bulanan'){
	$bln = $_POST['cmbBln'];
	$bln2 = $_POST['cmbBln']-1;
	$thn = $_POST['cmbThn'];
	$thn2 = $_POST['cmbThn'];
	
	if($bln==12){
		$thn2 = $_POST['cmbThn']-1;
		$bln2 = 01;
	}

	$waktu = " AND month(p.tgl) = '$bln' and year(p.tgl) = '$thn' ";
	$waktu2 = " AND p.tgl >= '$thn-01-01' and p.tgl < '$thn-$bln-01' ";
	$waktu_ranap = " AND month(p.tgl_out) = '$bln' and year(p.tgl_out) = '$thn' ";
	$waktu_ranap2 = " AND p.tgl_out >= '$thn-01-01 00:00:00' AND p.tgl_out < '$thn-$bln-01 00:00:00' ";
	$Periode = "Bulan $arrBln[$bln] Tahun $thn";
}
else{
	$tglAwal = explode('-',$_REQUEST['tglAwal']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	//echo $arrBln[$tglAwal[1]];
	$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
	$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
	
	$waktu = " AND k.tgl between '$tglAwal2' and '$tglAkhir2' ";
	$waktu_ranap = " AND k.tgl_in between '$tglAwal2' and '$tglAkhir2' ";
	
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
<table width="858" height="498" border="0" cellpadding="0" cellspacing="0"  style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
	<tr>
		<td><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
	</tr>
	<tr>
		<td height="70" valign="top" style="text-align:center; font-weight:bold; font-size:14px; text-transform:uppercase">REALISASI PRODUKSI <br>
		  <u>RS PRIMA HUSADA CIPTA MANDIRI <?php echo $Periode;?></u></td>
	</tr>
	<tr>
		<td>
			<table border="1" cellpadding="0" cellspacing="0" width="100%" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; border:1px solid; border-collapse:collapse;">
				<tr style="font-size:12px; font-weight:bold; height:30">
				  <td width="5%" rowspan="2" style="text-align:center;">No</td>
					<td width="20%" rowspan="2" style=" text-align:center;">URAIAN</td>
					<td width="11%" rowspan="2" style=" text-align:center;">SATUAN</td>
					<td width="14%" rowspan="2" style="text-align:center;">ANGGARAN TAHUN <?php echo $thn; ?> </td>
					<td colspan="3" style=" text-align:center;">REALISASI</td>
					<td width="14%" rowspan="2" style="text-align:center;">DEVIASI % (7/4) </td>
				</tr>
				<tr style="font-size:12px; font-weight:bold; height:30">
				  <td width="13%" style=" text-align:center;">S.D BULAN LALU </td>
			      <td width="11%" style=" text-align:center;">BULAN INI </td>
			      <td width="12%" style=" text-align:center;">S.D BULAN INI </td>
			  </tr>
				
				<tr align="center" bgcolor="#CCCCCC">
				  <td>1</td>
				  <td>2</td>
				  <td>3</td>
				  <td>4</td>
				  <td>5</td>
				  <td>6</td>
				  <td>7</td>
				  <td>8</td>
			  </tr>
			<?php   
			$no=0;
			$idKUmumRS='2';
			$idKUmumKrakatau='198';
			$idKUmumBICT='197';
			$idKUmum=$idKUmumRS.','.$idKUmumKrakatau.','.$idKUmumBICT;
			$idKSpesialisRS='3,4,5,6,10,11,176,181,182';
			$idKSpesialisKrakatau='209,210,211,212,218';
			$idKSpesialis=$idKSpesialisRS.','.$idKSpesialisKrakatau;
			$idKGigiRS='156';
			$idKGigiKrakatau='193';
			$idKGigi=$idKGigiRS.','.$idKGigiKrakatau;
			$idKTerpaduRS='91';
			$idKTerpadu=$idKTerpaduRS;
			$idKRontgenRS='61,208';
			$idKRontgen=$idKRontgenRS;
			$idKLabRS='58';
			$idKLabKrakatau='216';
			$idKLab=$idKLabRS.','.$idKLabKrakatau;
			$idRIRS='183,184,185,186,71,162,33';
			$idRI=$idRIRS;
			$idAmbulance='122';
			$idLainnya=$idKUmum.','.$idKSpesialis.','.$idKGigi.','.$idKTerpadu.','.$idKRontgen.','.$idKLab.','.$idRI.','.$idAmbulance;
			$kol = Array ( 
							$idKUmum => 'KLINIK UMUM', 
							$idKSpesialis => 'KLINIK SPESIALIS', 
							$idKGigi => 'KLINIK GIGI',
							$idKTerpadu => 'KLINIK TERPADU',
							$idKRontgen => 'RONTGEN',
							$idKLab => 'LABORATORIUM',
							'1' => 'FARMASI',
							$idRI => 'RAWAT INAP',
							$idAmbulance => 'AMBULANCE',
							$idLainnya => 'LAINNYA'
						) ;
			  ?>
  
			  <?php
					foreach($kol as $id=>$col){

						$no++;
						echo "<tr>";
						echo "<td height='20' align='center' >".$no."</td>";
						echo "<td style='font-weight:bold;'>&nbsp;".$col." </td>";
						echo "<td>&nbsp;</td>";
						echo "<td>&nbsp;</td>";
						echo "<td>&nbsp;</td>";
						echo "<td>&nbsp;</td>";
						echo "<td>&nbsp;</td>";
						echo "<td>&nbsp;</td>";
						echo "<tr>";
						
						if($id==$idRI){
							$sql="SELECT t.typePx, t.pas, t.satuan, SUM(t.jumlah) AS jumlah, SUM(t.jumlah2) AS jumlah2 FROM 
								(SELECT
								  p.id,
								  1 AS typePx,
								  p.tgl_in,
								  p.`tgl_out`,
								  '1. Pasien Internal'    pas,
								  'Hari'                  satuan,
								  IF(p.status_out=1,DATEDIFF(p.`tgl_out`,p.`tgl_in`),DATEDIFF(p.`tgl_out`,p.`tgl_in`)+1)    jumlah,
								  '0'                     jumlah2
								FROM b_tindakan_kamar p
								WHERE p.`kso_id` IN(11,14)
									AND p.tgl_out > p.tgl_in    
									$waktu_ranap 
								UNION 
								SELECT
								  p.id,
								  1 AS typePx,
								  p.tgl_in,
								  p.`tgl_out`,
								  '1. Pasien Internal'    pas,
								  'Hari'                  satuan,
								  '0'                     jumlah,
								  IF(p.status_out=1,DATEDIFF(p.`tgl_out`,p.`tgl_in`),DATEDIFF(p.`tgl_out`,p.`tgl_in`)+1)    jumlah2
								FROM b_tindakan_kamar p
								WHERE p.`kso_id` IN(11,14)
									AND p.tgl_out > p.tgl_in
									$waktu_ranap2
								UNION
								SELECT
								  p.id,
								  2 AS typePx,
								  p.tgl_in,
								  p.`tgl_out`,
								  '2. Pasien Eksternal'    pas,
								  'Hari'                  satuan,
								  IF(p.status_out=1,DATEDIFF(p.`tgl_out`,p.`tgl_in`),DATEDIFF(p.`tgl_out`,p.`tgl_in`)+1)    jumlah,
								  '0'                     jumlah2
								FROM b_tindakan_kamar p
								WHERE p.`kso_id` NOT IN (11,14)
									AND p.tgl_out > p.tgl_in    
									$waktu_ranap 
								UNION 
								SELECT
								  p.id,
								  2 AS typePx,
								  p.tgl_in,
								  p.`tgl_out`,
								  '2. Pasien Eksternal'    pas,
								  'Hari'                  satuan,
								  '0'                     jumlah,
								  IF(p.status_out=1,DATEDIFF(p.`tgl_out`,p.`tgl_in`),DATEDIFF(p.`tgl_out`,p.`tgl_in`)+1)    jumlah2
								FROM b_tindakan_kamar p
								WHERE p.`kso_id` NOT IN (11,14)
									AND p.tgl_out > p.tgl_in
									$waktu_ranap2) AS t 
								GROUP BY t.typePx";
						}elseif($id==1){
							$sql="SELECT t1.typePx, t1.pas, t1.satuan, SUM(t1.jumlah) jumlah, SUM(t1.jumlah2) jumlah2 
								FROM (
								SELECT t0.typePx, t0.pas, t0.satuan, COUNT(t0.jumlah) jumlah, '0' jumlah2 
								FROM (
								SELECT 1 AS typePx, '1. Pasien Internal' pas,'Lembar' satuan, p.`NO_PENJUALAN` jumlah 
								FROM $dbapotek.`a_penjualan` p 
								WHERE p.`kso_id` IN (3, 13) $waktu 
								GROUP BY p.no_penjualan,p.`unit_id`, p.TGL 
								UNION 
								SELECT 2 AS typePx, '2. Pasien Eksternal' pas, 'Lembar' satuan, p.`NO_PENJUALAN` jumlah 
								FROM $dbapotek.a_penjualan p 
								WHERE p.`kso_id` NOT IN (3, 13, 0) $waktu 
								GROUP BY p.no_penjualan, p.`unit_id`, p.TGL ) t0 
								GROUP BY t0.typePx 
								UNION 
								SELECT t.typePx, t.pas, t.satuan, '0' jumlah, COUNT(t.jumlah) jumlah2 FROM (
								SELECT 1 AS typePx, '1. Pasien Internal' pas,'Lembar' satuan, p.`NO_PENJUALAN` jumlah 
								FROM $dbapotek.`a_penjualan` p 
								WHERE p.`kso_id` IN (3, 13) $waktu2 
								GROUP BY p.no_penjualan,p.`unit_id`, p.TGL 
								UNION 
								SELECT 2 AS typePx, '2. Pasien Eksternal' pas, 'Lembar' satuan, p.`NO_PENJUALAN` jumlah 
								FROM $dbapotek.a_penjualan p 
								WHERE p.`kso_id` NOT IN (3, 13, 0) $waktu2 
								GROUP BY p.no_penjualan, p.`unit_id`, p.TGL ) t 
								GROUP BY t.typePx) t1 
								GROUP BY t1.typePx";
						}elseif($id==$idLainnya){
							$sql="SELECT t.typePx, t.pas, t.satuan, SUM(t.jumlah) jumlah, SUM(t.jumlah2) jumlah2 
								FROM (
								SELECT 1 AS typePx, '1. Pasien Internal' pas, 'Orang' satuan, COUNT(p.id) jumlah, '0' jumlah2 
								FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id 
								WHERE k.`kso_id` IN (11,14) AND p.unit_id NOT IN ($id) $waktu 
								UNION 
								SELECT 2 AS typePx, '2. Pasien Eksternal' pas, 'Orang' satuan, COUNT(p.id) jumlah, '0' jumlah2 
								FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id 
								WHERE k.`kso_id` NOT IN (11,14) AND p.unit_id NOT IN ($id) $waktu 
								UNION 
								SELECT 1 AS typePx, '1. Pasien Internal' pas, 'Orang' satuan, '0' jumlah, COUNT(p.id) jumlah2 
								FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id 
								WHERE k.`kso_id` IN (11,14) AND p.unit_id NOT IN ($id) $waktu2 
								UNION 
								SELECT 2 AS typePx, '2. Pasien Eksternal' pas, 'Orang' satuan, '0' jumlah,COUNT(p.id) jumlah2 
								FROM b_kunjungan k  INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id
								WHERE k.`kso_id` NOT IN (11,14) AND p.unit_id NOT IN ($id) $waktu2 ) t 
								GROUP BY t.typePx";
						}else{
							$sql="SELECT t.typePx, t.pas, t.satuan, SUM(t.jumlah) jumlah, SUM(t.jumlah2) jumlah2 
								FROM (
								SELECT 1 AS typePx, '1. Pasien Internal' pas, 'Orang' satuan, COUNT(p.id) jumlah, '0' jumlah2 
								FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id 
								WHERE k.`kso_id` IN (11,14) AND p.unit_id IN ($id) $waktu 
								UNION 
								SELECT 2 AS typePx, '2. Pasien Eksternal' pas, 'Orang' satuan, COUNT(p.id) jumlah, '0' jumlah2 
								FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id 
								WHERE k.`kso_id` NOT IN (11,14) AND p.unit_id IN ($id) $waktu 
								UNION 
								SELECT 1 AS typePx, '1. Pasien Internal' pas, 'Orang' satuan, '0' jumlah, COUNT(p.id) jumlah2 
								FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id 
								WHERE k.`kso_id` IN (11,14) AND p.unit_id IN ($id) $waktu2 
								UNION 
								SELECT 2 AS typePx, '2. Pasien Eksternal' pas, 'Orang' satuan, '0' jumlah,COUNT(p.id) jumlah2 
								FROM b_kunjungan k  INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id
								WHERE k.`kso_id` NOT IN (11,14) AND p.unit_id IN ($id) $waktu2 ) t 
								GROUP BY t.typePx";
						 }
						//echo $sql."<br>";
						 
						$sql1 = mysql_query($sql);
						$subtotal =0;
						$subtotal2 =0;
						
						while($sql2 = mysql_fetch_array($sql1)){
							$pas = $sql2['pas'];
							$jumlah = $sql2['jumlah'];
							$jumlah2 = $sql2['jumlah2'];
							$satuan = $sql2['satuan'];
							
							echo "<tr>";
							echo "<td height='20' align='center' ></td>";
							echo "<td >&nbsp;&nbsp;".$pas."</td>";
							echo "<td align='center'>".$satuan."</td>";
							echo "<td align='center'>".'-'."</td>";
							echo "<td align='center'>".number_format($jumlah2,0,",",".")."</td>";
							echo "<td align='center'>".number_format($jumlah,0,",",".")."</td>";
							echo "<td align='center'>".number_format($jumlah2 + $jumlah,0,",",".")."</td>";
							echo "<td>&nbsp;</td>";
							echo "<tr>";
							
							$subtotal +=$jumlah;
							$subtotal2 +=$jumlah2;
							
							$total +=$jumlah;
							$total2 +=$jumlah2;
						}
						
						echo "<tr>";
						echo "<td height='20' align='center' ></td>";
						echo "<td align='right'>Jumlah  &nbsp;&nbsp;</td>";
						echo "<td align='center'></td>";
						echo "<td align='center'></td>";
						echo "<td align='center'>".number_format($subtotal2,0,",",".")."</td>";
						echo "<td align='center'>".number_format($subtotal,0,",",".")."</td>";
						echo "<td align='center'>".number_format($subtotal+$subtotal2,0,",",".")."</td>";
						echo "<td>&nbsp;</td>";
						echo "<tr>";
					
					}
				?>
			<tr>
				  <td height="20" align="center"><?php echo $no+1; ?></td>
				  <td style='font-weight:bold;'>&nbsp; TOTAL PRODUKSI</td>
				  <td></td>
				  <td></td>
				 <td align="center"><?php echo number_format($total2,0,",","."); ?></td>
				  <td align="center"><?php echo number_format($total,0,",","."); ?></td>
				  <td align="center"><?php echo number_format($total+$total2,0,",","."); ?></td>
				  <td>&nbsp;</td>
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