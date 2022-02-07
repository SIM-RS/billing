<?php
	include('../sesi.php');
	include('../koneksi/konek.php');
	//================================ PARAMETER ================================
	$wkttgl=gmdate('d/m/Y',mktime(date('H')+7));
	$wktnow=gmdate('H:i:s',mktime(date('H')+7));
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'Nopember','12'=>'Desember');
	$kso = $_REQUEST['cmbKsoRep'];
	$waktu = $_REQUEST['cmbWaktu'];
	$cwaktu=$waktu;
	//===========================================================================
	
	if($waktu == 'Harian'){
        $tglAwal = explode('-',$_REQUEST['tglAwal2']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$tglAkhir2 = $tglAwal2;
        $waktu = " AND DATE(k.tgl_pulang) = '$tglAwal2' ";
        
        $Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
    }else if($waktu == 'Bulanan'){
        $bln = $_REQUEST['cmbBln'];
        $thn = $_REQUEST['cmbThn'];
		$cbln = ($bln<10)?"0".$bln:$bln;
        //$waktu = "month(t.tgl) = '$bln' AND year(t.tgl) = '$thn' ";
		$tglAwal2 = "$thn-$cbln-01";
		$tglAkhir2 = "$thn-$cbln-".cal_days_in_month(CAL_GREGORIAN, $bln, $thn);
		$waktu = " AND DATE(k.tgl_pulang) between '$tglAwal2' and '$tglAkhir2' ";
		
        $Periode = "Bulan $arrBln[$cbln] Tahun $thn";
		//$tglAkhir2="$thn-$cbln-".cal_days_in_month(CAL_GREGORIAN, $bln, $thn);
		//$tglAwal2="$thn-$cbln-01";
    }else{
        $tglAwal = explode('-',$_REQUEST['tglAwal']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        //echo $_REQUEST['tglAkhir'];
        $tglAkhir = explode('-',$_REQUEST['tglAkhir']);
        $tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
        $waktu = " AND DATE(k.tgl_pulang) between '$tglAwal2' and '$tglAkhir2' ";
        
        $Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
    }
	
	if($kso == 0){
		$fkso = "SEMUA";
		$nKso = $fkso = "";
	} else {
		$fkso = " AND kso_id = '{$kso}'";
		$qKso = "SELECT billing.b_ms_kso.id, billing.b_ms_kso.nama FROM billing.b_ms_kso
			WHERE billing.b_ms_kso.id = '".$kso."'";
		$sKso = mysql_query($qKso);
		$dKso = mysql_fetch_array($sKso);
		$nKso = "PENJAMIN : ".$dKso['nama']."<br />";
	}
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Rekap Biaya Perawatan dan Piutang</title>
	<style type="text/css">
		body{ margin:0px; padding:0px; font-family:Arial; font-size:12px; line-height:1.3em; }
		#container{ width:1280px; margin:10px auto; padding:0px; display:block; }
		#title{ width:100%; display:block; margin-bottom:3px; text-align:left; font-weight:bold; font-size:14px; }
		.isian{ border-collapse: collapse; margin-bottom: 10px; }
		.isian td, .isian th{ padding:5px; border:1px solid #000; }
		.isian th{ background:#E1E1E1; }
		.isian .noborder{ border:0px; }
		#des{ font-size:12px; }
		#signature{ float:right; width:300px; display:block; text-align:center; margin-bottom: 40px; }
	</style>
	<script type="text/javascript">
		function cetak(id){
			document.getElementById('cetakID').style.display="none";
			if(!window.print()){
				document.getElementById('cetakID').style.display="inline";
			}
		}
		
		function cetakExcell(){
			//window.location.href = 'lap_bkm.php?id=<?php echo $idBKM; ?>&isExcel=1';
		}
	</script>
</head>
<body>
	<center>
		<span id="cetakID" style="float:left; position:fixed; width:100%; display:block; left:0px; bottom:0px; background:#0084FF; padding:5px;"><button id="btCetak" type="button" name="btCetak" onclick="cetak()">Cetak Rekap Biaya Perawatan dan Piutang</button></span>
	</center>
	<div id="container">	
		<section style="margin-bottom:20px;">
			<b><?php echo $namaRS; ?><br><?php echo $alamatRS; ?><br>Telepon <?php echo $tlpRS; ?></b>
		</section>
		<header id="title">
			<center style="text-transform:uppercase; line-height:1.25em;">
				Rekap Biaya Perawatan dan Piutang<br />
				<?php echo $nKso; ?>
				<?php echo $Periode; ?><br />
				<br />
			</center>
			<span id="des"></span>
		</header>
		<section id="detail">
			<table class="isian" width="100%">
				<tr>
					<th width="10px">NO</th>
					<!--th width="80px">TANGGAL KUNJUNGAN</th>
					<th width="80px">NO RM</th>
					<th >NAMA</th-->
					<th width="120">KSO</th>
					<th width="120">KUNJUNGAN AWAL</th>
					<th width="100px">TARIF PERDA</th>
					<th width="100px">BIAYA PASIEN</th>
					<th width="100px">BIAYA KSO</th>
					<th width="100px">IUR BAYAR</th>
					<th width="100px">SELISIH</th>
					<th width="100px">BAYAR KSO</th>
					<th width="100px">PIUTANG PASIEN</th>
					<th width="100px">PIUTANG KSO</th>
				</tr>
				<?php
					$sql = "SELECT *
							FROM (SELECT
									  k.id, pas.no_rm, pas.nama AS pasien, kso.nama kso,
									  mu.nama unit, DATE_FORMAT(kp.tglK,'%d-%m-%Y') AS tgl,
									  DATE_FORMAT(kp.tglP,'%d-%m-%Y') AS tgl_p, kp.biayaRS,
									  kp.biayaPasien, kp.biayaKSO, kp.bayarPasien, kp.piutangPasien
									FROM k_piutang kp
									  INNER JOIN $dbbilling.b_kunjungan k
										ON kp.kunjungan_id = k.id
									  INNER JOIN $dbbilling.b_ms_pasien pas
										ON k.pasien_id = pas.id
									  INNER JOIN $dbbilling.b_ms_kso kso
										ON k.kso_id = kso.id
									  INNER JOIN $dbbilling.b_ms_unit mu
										ON k.unit_id = mu.id
									WHERE 0 = 0 {$waktu} {$fkso}
									  AND kp.tipe=0) tx
							ORDER BY tx.tgl, tx.id";
					$sql="SELECT 
							  id,pasien_id,DATE_FORMAT(tgl,'%d-%m-%Y') AS tgl,
							  no_rm, nama, unit_awal, kso_id, nmkso, SUM(biaya) biaya, SUM(biaya_kso) biaya_kso,
							  SUM(biaya_pasien) biaya_pasien, SUM(bayar) bayar, SUM(bayar_kso) bayar_kso, SUM(bayar_pasien) bayar_pasien,
							  IFNULL(SUM(bayarKSO),0) bayarKSO
							FROM
							(SELECT 
								k.id, k.pasien_id, k.tgl, mp.no_rm, mp.nama, mu.nama AS unit_awal, t.id idTind, t.kso_id,
								kso.nama AS nmkso, t.qty*t.biaya biaya, t.qty*t.biaya_kso biaya_kso, t.qty*t.biaya_pasien biaya_pasien, t.bayar,
								t.bayar_kso, t.bayar_pasien, jj.total as bayarKSO
							FROM $dbbilling.b_kunjungan k
							  INNER JOIN $dbbilling.b_ms_pasien mp ON k.pasien_id = mp.id
							  INNER JOIN $dbbilling.b_ms_unit mu ON k.unit_id = mu.id
							  INNER JOIN $dbbilling.b_pelayanan p ON k.id = p.kunjungan_id
							  INNER JOIN $dbbilling.b_tindakan t ON p.id = t.pelayanan_id
							  INNER JOIN $dbbilling.b_ms_kso kso ON t.kso_id = kso.id
							  LEFT JOIN (SELECT ktd.kunjungan_id, SUM(ktd.nilai_terima) total
									FROM k_klaim_terima kt
									INNER JOIN k_klaim_terima_detail ktd ON ktd.klaim_terima_id = kt.id
									WHERE ktd.kunjungan_id <> 0
									GROUP BY ktd.kunjungan_id) jj
								ON jj.kunjungan_id = k.id
							WHERE k.pulang = 1 {$waktu} /* AND DATE(k.tgl_pulang) = '$tgl' */
							UNION
							SELECT
								k.id, k.pasien_id, k.tgl, mp.no_rm, mp.nama, mu.nama AS unit_awal, t.id idTind, t.kso_id, kso.nama AS nmkso,
							  IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)))*t.tarip, (IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)))*t.tarip)    biaya,
							  IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)))*t.beban_kso, (IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)))*t.beban_kso)    biaya_kso,
							  IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)))*t.beban_pasien, (IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)))*t.beban_pasien)    biaya_pasien,
							  t.bayar, t.bayar_kso, t.bayar_pasien, jj.total as bayarKSO
							FROM $dbbilling.b_kunjungan k
							  INNER JOIN $dbbilling.b_ms_pasien mp ON k.pasien_id = mp.id
							  INNER JOIN $dbbilling.b_ms_unit mu ON k.unit_id = mu.id
							  INNER JOIN $dbbilling.b_pelayanan p ON k.id = p.kunjungan_id
							  INNER JOIN $dbbilling.b_tindakan_kamar t ON p.id = t.pelayanan_id
							  INNER JOIN $dbbilling.b_ms_kso kso ON t.kso_id = kso.id
							  LEFT JOIN (SELECT ktd.kunjungan_id, SUM(ktd.nilai_terima) total
									FROM k_klaim_terima kt
									INNER JOIN k_klaim_terima_detail ktd ON ktd.klaim_terima_id = kt.id
									WHERE ktd.kunjungan_id <> 0
									GROUP BY ktd.kunjungan_id) jj
								ON jj.kunjungan_id = k.id
							WHERE k.pulang = 1 {$waktu} /* AND DATE(k.tgl_pulang) = '$tgl' */
							UNION
							SELECT
								k.id, k.pasien_id, k.tgl, mp.no_rm, mp.nama, mu.nama AS unit_awal, t.id idTind, kso.id AS kso_id, kso.nama AS nmkso,
								SUM(IF(t.KRONIS=0,(t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_SATUAN,0))    biaya,
								SUM(IF(t.KRONIS=0,(t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_KSO,0))    biaya_kso,
								SUM(IF(t.KRONIS=0,(t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_PX,0))    biaya_pasien,
								(SELECT IFNULL(SUM(TOTAL_HARGA),0) FROM $dbapotek.a_kredit_utang 
									WHERE NORM=mp.no_rm AND FK_NO_PENJUALAN=t.NO_PENJUALAN AND UNIT_ID=t.UNIT_ID) bayar, 
								0 bayarKso,
								(SELECT IFNULL(SUM(TOTAL_HARGA),0) FROM $dbapotek.a_kredit_utang 
									WHERE NORM=mp.no_rm AND FK_NO_PENJUALAN=t.NO_PENJUALAN AND UNIT_ID=t.UNIT_ID) bayar_pasien, 
								jj.total as bayarKSO
							FROM $dbbilling.b_kunjungan k
							  INNER JOIN $dbbilling.b_ms_pasien mp ON k.pasien_id = mp.id
							  INNER JOIN $dbbilling.b_ms_unit mu ON k.unit_id = mu.id
							  INNER JOIN $dbbilling.b_pelayanan p ON k.id = p.kunjungan_id
							  INNER JOIN $dbapotek.a_penjualan t ON p.id = t.NO_KUNJUNGAN
							  INNER JOIN $dbapotek.a_mitra m ON t.KSO_ID = m.IDMITRA
							  INNER JOIN $dbbilling.b_ms_kso kso ON m.kso_id_billing = kso.id
							  LEFT JOIN (SELECT ktd.kunjungan_id, SUM(ktd.nilai_terima) total
									FROM k_klaim_terima kt
									INNER JOIN k_klaim_terima_detail ktd ON ktd.klaim_terima_id = kt.id
									WHERE ktd.kunjungan_id <> 0
									GROUP BY ktd.kunjungan_id) jj
								ON jj.kunjungan_id = k.id
							WHERE k.pulang = 1 {$waktu} /* AND DATE(k.tgl_pulang) = '$tgl' */
							GROUP BY k.id,kso.id,t.UNIT_ID,t.NO_KUNJUNGAN,t.NO_PENJUALAN) AS gab
							WHERE 1=1 {$fkso}
							GROUP BY gab.kso_id
							ORDER BY gab.kso_id";
					// echo $sql;
					$query = mysql_query($sql) or die(mysql_error());
					if($query && mysql_affected_rows() > 0){
						$i = 1;
						$grandtotal = array();
						$tmpKso = '';
						$subtotal = array();
						while ($rows=mysql_fetch_array($query)) {
							/* $tPerda=$rows["biayaRS"];
							$tKSO=$rows["biayaKSO"];
							$tPx=$rows["biayaPasien"];
							//$tBayarPx=$rows["bayarPasien"]+$rows["bayarKamarPasien"];
							$tPiutangPx=$tPx-$tBayarPx; */
							
							/* if($rows["nmkso"] != $tmpKSO){
								if($i > 1){
									echo "<tr>
											<td align='right' colspan='6'>SubTotal</td>
											<td align='right'>".number_format($subtotal['perda'],0,",",".")."</td>
											<td align='right'>".number_format($subtotal['px'],0,",",".")."</td>
											<td align='right'>".number_format($subtotal['kso'],0,",",".")."</td>
											<td align='right'>".number_format($subtotal['iur'],0,",",".")."</td>
											<td align='right'>(".number_format(abs($subtotal['selisih']),0,",",".").")</td>
											<td align='right'>".number_format($subtotal['bayarKSO'],0,",",".")."</td>
											<td align='right'>".number_format($subtotal['piutangPx'],0,",",".")."</td>
											<td align='right'>".number_format($subtotal['piutangKSO'],0,",",".")."</td>
										</tr>";
								}
								echo "<tr>
									<td colspan='14' style='color:blue; font-weight:bold;'>".$rows["nmkso"]."</td>
								</tr>";
								
								$i = 1;
								$tmpKSO = $rows["nmkso"];
								$subtotal = array();
							} */
							
							$tPerda=$rows["biaya"];
							$tKSO=$rows["biaya_kso"];
							if ($rows["kso_id"]==1){
								$tPx=$rows["biaya_pasien"];
								$tIur=0;
							}else{
								$tPx=0;
								$tIur=$rows["biaya_pasien"];
							}
							$tSelisih=$tPerda-($tKSO+$tPx+$tIur);
							$stSelisih=number_format($tSelisih,0,",",".");
							if ($tSelisih<0){
								$stSelisih="(".number_format(abs($tSelisih),0,",",".").")";
							}
							
							$piutangPx = ($tPx+$tIur)-$tBayarPx;
							$bayarKSO = $rows['bayarKSO'];
							$piutangKSO = $tKSO-$bayarKSO;
							
							echo "<tr>
									<td align='center'>".$i++."</td>
									<!--td align='center'>".$rows["tgl"]."</td>
									<td align='center'>".$rows["no_rm"]."</td>
									<td>".$rows["nama"]."</td-->
									<td>".$rows["nmkso"]."</td>
									<td>".$rows["unit_awal"]."</td>
									<td align='right'>".number_format($tPerda,0,",",".")."</td>
									<td align='right'>".number_format($tPx,0,",",".")."</td>
									<td align='right'>".number_format($tKSO,0,",",".")."</td>
									<td align='right'>".number_format($tIur,0,",",".")."</td>
									<td align='right'>".$stSelisih."</td>
									<td align='right'>".number_format($bayarKSO,0,",",".")."</td>
									<td align='right'>".number_format($piutangPx,0,",",".")."</td>
									<td align='right'>".number_format($piutangKSO,0,",",".")."</td>
								</tr>";
							
							/* $subtotal['perda'] += $tPerda;
							$subtotal['px'] += $tPx;
							$subtotal['kso'] += $tKSO;
							$subtotal['iur'] += $tIur;
							$subtotal['selisih'] += $tSelisih;
							$subtotal['bayarKSO'] += $bayarKSO;
							$subtotal['piutangPx'] += $piutangPx;
							$subtotal['piutangKSO'] += $piutangKSO; */
							
							$grandtotal['perda'] += $tPerda;
							$grandtotal['px'] += $tPx;
							$grandtotal['kso'] += $tKSO;
							$grandtotal['iur'] += $tBayarPx;
							$grandtotal['selisih'] += $tSelisih;
							$grandtotal['bayarKSO'] += $bayarKSO;
							$grandtotal['piutangPx'] += $piutangPx;
							$grandtotal['piutangKSO'] += $piutangKSO;
						}
					} else {
						echo "<tr>
							<td colspan='14' align='center' style='font-weight:bold; font-size:14px; padding:10px;'>Tidak Ada Data dalam Periode ini.</td>
						</tr>";
					}
					/* echo "<tr>
							<td align='right' colspan='6'>SubTotal</td>
							<td align='right'>".number_format($subtotal['perda'],0,",",".")."</td>
							<td align='right'>".number_format($subtotal['px'],0,",",".")."</td>
							<td align='right'>".number_format($subtotal['kso'],0,",",".")."</td>
							<td align='right'>".number_format($subtotal['iur'],0,",",".")."</td>
							<td align='right'>(".number_format(abs($subtotal['selisih']),0,",",".").")</td>
							<td align='right'>".number_format($subtotal['bayarKSO'],0,",",".")."</td>
							<td align='right'>".number_format($subtotal['piutangPx'],0,",",".")."</td>
							<td align='right'>".number_format($subtotal['piutangKSO'],0,",",".")."</td>
						</tr>"; */
					echo "<tr style='font-weight:bold;'>
							<td align='right' colspan='3'>Total</td>
							<td align='right'>".number_format($grandtotal['perda'],0,",",".")."</td>
							<td align='right'>".number_format($grandtotal['px'],0,",",".")."</td>
							<td align='right'>".number_format($grandtotal['kso'],0,",",".")."</td>
							<td align='right'>".number_format($grandtotal['iur'],0,",",".")."</td>
							<td align='right'>(".number_format(abs($grandtotal['selisih']),0,",",".").")</td>
							<td align='right'>".number_format($grandtotal['bayarKSO'],0,",",".")."</td>
							<td align='right'>".number_format($grandtotal['piutangPx'],0,",",".")."</td>
							<td align='right'>".number_format($grandtotal['piutangKSO'],0,",",".")."</td>
						</tr>";
				?>
			</table>
			<div id="signature">
				<p><?php echo $kotaRS; ?>, <?=$wkttgl.' '.$wktnow;?></p>
			</div>
		</section>
</body>
</html>