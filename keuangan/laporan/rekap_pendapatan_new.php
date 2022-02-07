<?php
	include('../sesi.php');
    include("../koneksi/konek.php");
	
    $arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'Nopember','12'=>'Desember');
    $waktu = $_POST['cmbWaktu'];
	//echo $_REQUEST['tglAwal2']."<br>";
	$cwaktu=$waktu;
	
    if($waktu == 'Harian'){
        $tglAwal = explode('-',$_REQUEST['tglAwal2']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$tglAkhir2 = $tglAwal2;
        $waktu = " AND t.tgl_klaim = '$tglAwal2' ";
        $waktuAmbu = " AND t1.tgl_act = '$tglAwal2' ";
        $waktuLain = " AND t.tgl = '$tglAwal2' ";
        $waktuPark = " AND DATE(p.tgl_setor) = '$tglAwal2' ";
		$waktuF = "p.TGL = '$tglAwal2' ";
		//$waktu2 = "$dbkeuangan.k_transaksi.tgl = '$tglAwal2' ";
		//$waktuL = "AND k.tgl = '$tglAwal2' ";
        $Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
    }else if($waktu == 'Bulanan'){
        $bln = $_POST['cmbBln'];
        $thn = $_POST['cmbThn'];
		$cbln = ($bln<10)?"0".$bln:$bln;
        //$waktu = "month(t.tgl) = '$bln' AND year(t.tgl) = '$thn' ";
		$tglAwal2 = "$thn-$cbln-01";
		$tglAkhir2 = "$thn-$cbln-".cal_days_in_month(CAL_GREGORIAN, $bln, $thn);
		$waktu = " AND t.tgl_klaim between '$tglAwal2' and '$tglAkhir2' ";
		$waktuF = "month(p.TGL) = '$bln' AND year(p.TGL) = '$thn' ";
		$waktuAmbu = " AND month(t1.tgl_act) = '$bln' AND year(t1.tgl_act) = '$thn' ";
		$waktuLain = " AND month(t.tgl) = '$bln' AND year(t.tgl) = '$thn' ";
		$waktuPark = " AND month(p.tgl_setor) = '$bln' AND year(p.tgl_setor) = '$thn' ";
		//$waktu2 = "month($dbkeuangan.k_transaksi.tgl) = '$bln' AND year($dbkeuangan.k_transaksi.tgl) = '$thn' ";
		//$waktuL = "AND month(k.tgl) = '$bln' AND year(k.tgl) = '$thn' ";
		//$waktuL = "AND k.tgl between '$tglAwal2' and '$tglAkhir2' ";
        $Periode = "Bulan $arrBln[$cbln] Tahun $thn";
		//$tglAkhir2="$thn-$cbln-".cal_days_in_month(CAL_GREGORIAN, $bln, $thn);
		//$tglAwal2="$thn-$cbln-01";
    }else{
        $tglAwal = explode('-',$_REQUEST['tglAwal']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        //echo $_REQUEST['tglAkhir'];
        $tglAkhir = explode('-',$_REQUEST['tglAkhir']);
        $tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
        $waktu = " AND t.tgl_klaim between '$tglAwal2' and '$tglAkhir2' ";
        $waktuAmbu = " AND t1.tgl_act between '$tglAwal2' and '$tglAkhir2' ";
        $waktuLain = " AND t.tgl between '$tglAwal2' and '$tglAkhir2' ";
        $waktuPark = " AND DATE(p.tgl_setor) between '$tglAwal2' and '$tglAkhir2' ";
		$waktuF = "p.TGL between '$tglAwal2' and '$tglAkhir2' ";
		//$waktu2 = "$dbkeuangan.k_transaksi.tgl between '$tglAwal2' and '$tglAkhir2' ";
		//$waktuL = "AND k.tgl between '$tglAwal2' and '$tglAkhir2' ";
        
        $Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
    }
	/*for($i = 2000; $i < 2009; $i++) {
		echo "$i: ", cal_days_in_month(CAL_GREGORIAN, 2, $i), "\n";
	}*/
	
	$IdTransPiutang=36;
	$IdTransBilling=38;
	$IdTransFarmasi=39;
	
	$fIdTrans=" AND (t.id_trans=$IdTransPiutang OR t.id_trans=$IdTransBilling OR t.id_trans=$IdTransFarmasi)";
	$isPavilyun=$_REQUEST['isPavilyun'];
	$isFarmasi=$_REQUEST['isFarmasi'];
	$tipe=$_REQUEST['tipe'];

	$fPav="";
	$lblPav=" ( RSPM + Pavilyun )";
	if ($isPavilyun=="0"){
		$fPav=" AND t.isPavilyun=0";
		$lblPav=" ( RSPM )";
	}elseif ($isPavilyun=="1"){
		$fPav=" AND t.isPavilyun=1";
		$lblPav=" ( Pavilyun )";
	}
	
	$ptitle="Rekap Pendapatan {$namaRS}".$lblPav;
	$lblTotalP="TOTAL PENDAPATAN BILLING + FARMASI".$lblPav;
	$fFarmasi="";
	
	if ($isFarmasi=="1"){
		$ptitle="Rekap Pendapatan Farmasi".$lblPav;
		$lblTotalP="TOTAL PENDAPATAN FARMASI".$lblPav;
		$fFarmasi=" AND t.isFarmasi=2";
	}elseif ($isFarmasi=="0"){
		$ptitle="Rekap Pendapatan Billing".$lblPav;
		$lblTotalP="TOTAL PENDAPATAN BILLING".$lblPav;
		$fFarmasi=" AND t.isFarmasi<>2";
	}
	
	if ($isPavilyun=="" && $isFarmasi=="") $tipe=="all";
?>
<title>.: <?php echo $ptitle; ?> :.</title>
<style type="text/css">
	#tableMain{
		border-collapse:collapse;
	}
	#tableMain td{
		border:1px solid #000;
		padding:3px;
	}
</style>
<table border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
    <tr>
        <td><b><?=$pemkabRS;?><br><?=$namaRS;?><br><?=$alamatRS;?><br>Telepon <?=$tlpRS;?></b></td>
    </tr>
    <tr>
        <td style="font-size:14px; height:70px; text-transform:uppercase; text-align:center; font-weight:bold;" valign="top"><?php echo $ptitle;?><br /><?php echo $Periode;?></td>
    </tr>
	<tr>
		<td>
			<table id="tableMain" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
				<tr style="text-align:center; font-weight:bold">
					<td width="30" >NO</td>
				  	<td width="250" >UNIT PELAYANAN</td>
					<td width="100" >TARIP PERDA</td>
				    <td width="100" >BIAYA PASIEN</td>
				    <td width="100" >TARIP KSO</td>
				    <td width="100" >IUR BIAYA</td>
				    <td width="100" >SELISIH</td>
				</tr>
				<tr style="text-align:center; font-weight:bold; background:lightgrey;">
				  	<td >1</td>
					<td >2</td>
				    <td width="100" >3</td>
				    <td width="100" >4</td>
				    <td width="100" >5</td>
				    <td width="100" >6</td>
				    <td width="100" >7</td>
				</tr>
				<tr>
					<td colspan="7" style="font-size:12px; font-weight:bold;">Pendapatan Billing + Farmasi</td>
				</tr>
                <?php 
					$GrandTot = array();
					// Get Pendapatan Billing + Farmasi + Ambulance
					/* Query Billing */
					$sBill = "SELECT DISTINCT 
								  IFNULL(SUM(t.nilai_sim), 0) AS nilai_sim,
								  IF(t.kso_id = 1, IFNULL(SUM(t.nilai), 0), 0) AS nilai_px,
								  IF(t.kso_id <> 1, IFNULL(SUM(t.nilai_hpp), 0), 0) AS nilai_hpp,
								  IF(t.kso_id <> 1, IFNULL(SUM(t.nilai), 0), 0) AS nilai_px1,
								  t.kso_id,
								  kso.nama
								FROM k_transaksi t 
								INNER JOIN $dbbilling.b_ms_kso kso
								   ON t.kso_id = kso.id
								WHERE 1 = 1
								  {$waktu}
								  AND t.tipe_trans = '1' AND t.flag = '$flag'
								  {$fIdTrans}
								GROUP BY t.kso_id";
					$qBill = mysql_query($sBill);
					$total = array();
					$no = 1;
					if(mysql_num_rows($qBill) > 0){
						while($dBill = mysql_fetch_array($qBill)){
							/* Query Penunjang Lain */
							$sPenj = "SELECT 
										  IFNULL(SUM(t.nilai), 0) AS nilai_sim, t.kso_id
										FROM k_transaksi t 
										INNER JOIN k_ms_transaksi mt
										   ON mt.id = t.id_trans
										WHERE mt.tipe = 1
										  AND mt.jenisLay = 1 AND t.flag = '$flag'
										  {$waktu}
										  AND t.kso_id = ".$dBill['kso_id'];
							$qPenj = mysql_query($sPenj);
							$totPenjsim = 0;
							if(mysql_num_rows($qPenj) > 0){
								$dPenj = mysql_fetch_array($qPenj);
								$totPenjsim = $dPenj['nilai_sim'];
							}
							
							/* Query Farmasi */
							$sFar = "SELECT 
									  IFNULL(SUM(t.nilai_sim), 0) AS nilai_sim,
									  IFNULL(SUM(t.nilai), 0) AS nilai_px,
									  IFNULL(SUM(t.nilai_hpp), 0) AS nilai_hpp,
									  t.kso_id
									FROM
									  k_transaksi t 
									WHERE 1 = 1 {$waktu}
									  AND t.tipe_trans = '1' AND t.flag = '$flag'
									  {$fIdTrans}
									  AND t.unit_id_billing = 0
									  AND t.kso_id = ".$dBill['kso_id'];
							$qFar = mysql_query($sfar);
							//echo mysql_error();
							$totFarsim = $totFarpx = $totFarhpp = 0;
							if($qFar){
								$dFar = mysql_fetch_array($qFar);
								$totFarsim = $dFar['nilai_sim'];
								$totFarpx = $dFar['nilai_px']; 
								$totFarhpp = $dFar['nilai_hpp'];
							}
							
							/* Query Ambulan untuk KSO UMUM */
							$totAmbusim = 0;
							if($dBill['kso_id'] == '1'){
								$sAmbu = "SELECT SUM(nilai) AS nilai_sim
											FROM (SELECT a.no_bukti, a.nilai, a.tgl_setor tgl_act
												FROM k_ambulan a
												INNER JOIN k_ms_user u
												   ON u.id = a.user_act) t1
											WHERE 0 = 0 AND a.flag = '$flag'
											  {$waktuAmbu}' ";
								$qAmbu = mysql_query($sAmbu);
								if($qAmbu){
									$dAmbu = mysql_fetch_array($qAmbu);
									$totAmbusim = $dAmbu['nilai_sim'];
								}
							}
							
							$nilai_sim = ($dBill['nilai_sim']+$totPenjsim+$totFarsim+$totAmbusim);
							$nilai_px = ($dBill['nilai_px']+$totPenjsim+$totFarpx+$totAmbusim);
							$nilai_hpp = $dBill['nilai_hpp'];
							$nilai_iur = $dBill['nilai_px1'];
							$nilai_selisih = ($dBill['nilai_sim']-($dBill['nilai_hpp']+$dBill['nilai_px']+$dBill['nilai_px1']));
							
							/* Cetal Nilai Pendapatan Billing+Farmasi per KSO */
							echo "<tr>
								<td align='center'>".$no++."</td>
								<td>".$dBill['nama']."</td>
								<td align='right'>".number_format($nilai_sim,2,",",".")."</td>
								<td align='right'>".number_format($nilai_px,2,",",".")."</td>
								<td align='right'>".number_format($nilai_hpp,2,",",".")."</td>
								<td align='right'>".number_format($nilai_iur,2,",",".")."</td>
								<td align='right'>".number_format($nilai_selisih,2,",",".")."</td>
							</tr>";
							
							/* Perhitungan SubTotal Pendapatan Billing+Farmasi */
							$total['nilai_sim']+=$nilai_sim;
							$total['nilai_px']+=$nilai_px;
							$total['nilai_hpp']+=$nilai_hpp;
							$total['nilai_iur']+=$nilai_iur;
							$total['nilai_selisih']+=$nilai_selisih;
						}
					}
					
					/* Perhitungan Grand Total */
					$GrandTot['nilai_sim']		+= $total['nilai_sim'];
					$GrandTot['nilai_px']		+= $total['nilai_px'];
					$GrandTot['nilai_hpp']		+= $total['nilai_hpp'];
					$GrandTot['nilai_iur']		+= $total['nilai_iur'];
					$GrandTot['nilai_selisih']	+= $total['nilai_selisih'];
					
					/* Cetak SubTotal Pendapatan Billing+Farmasi */
					echo "<tr>
							<td align='right' colspan='2'>Sub Total</td>
							<td align='right'>".number_format($total['nilai_sim'],2,",",".")."</td>
							<td align='right'>".number_format($total['nilai_px'],2,",",".")."</td>
							<td align='right'>".number_format($total['nilai_hpp'],2,",",".")."</td>
							<td align='right'>".number_format($total['nilai_iur'],2,",",".")."</td>
							<td align='right'>".number_format($total['nilai_selisih'],2,",",".")."</td>
						</tr>";
				?>
				<tr>
					<td colspan="7" style="font-size:12px; font-weight:bold;">Pendapatan Kerjasama</td>
				</tr>
				<?php
					// Get Pendapatan Kerjasama
					$total2 = array();
					
					echo "<tr>
							<td align='right' colspan='2'>Sub Total</td>
							<td align='right'>".number_format($total2['nilai_sim'],2,",",".")."</td>
							<td align='right'>".number_format($total2['nilai_px'],2,",",".")."</td>
							<td align='right'>".number_format($total2['nilai_hpp'],2,",",".")."</td>
							<td align='right'>".number_format($total2['nilai_iur'],2,",",".")."</td>
							<td align='right'>".number_format($total2['nilai_selisih'],2,",",".")."</td>
						</tr>";
				?>
				<tr>
					<td colspan="7" style="font-size:12px; font-weight:bold;">Pendapatan Lain-Lain</td>
				</tr>
				<?php
					// Get Pendapatan Lain-Lain + Parkir
					$no = 1;
					$total3 = array();
					
					/* Query Pendapatan Lain-Lain */
					$sLain = "SELECT SUM(t.nilai) AS nilai, mt.id, mt.nama
								FROM k_transaksi t
								INNER JOIN k_ms_transaksi mt
								   ON t.id_trans = mt.id 
								WHERE mt.tipe = '1' 
								  {$waktuLain}
								  AND mt.isManual = 1 AND t.flag = '$flag'
								GROUP BY mt.id";
					$qLain = mysql_query($sLain);
					if($qLain){
						$nilai_px = $nilai_sim = 0;
						while($dLain = mysql_fetch_array($qLain)){
							$nilai_px = $nilai_sim = $dLain['nilai'];
							$nilai_hpp = $nilai_iur = $nilai_selisih = 0;
							
							/* Cetak Pendapatan Lain-Lain */
							echo "<tr>
									<td align='center'>".$no++."</td>
									<td>".$dLain['nama']."</td>
									<td align='right'>".number_format($nilai_sim,2,",",".")."</td>
									<td align='right'>".number_format($nilai_px,2,",",".")."</td>
									<td align='right'>".number_format($nilai_hpp,2,",",".")."</td>
									<td align='right'>".number_format($nilai_iur,2,",",".")."</td>
									<td align='right'>".number_format($nilai_selisih,2,",",".")."</td>
								</tr>";
								
							/* Perhitungan SubTotal Pendapatan Lain-Lain */
							$total3['nilai_sim'] +=$nilai_sim;
							$total3['nilai_px']  +=$nilai_px;
							$total3['nilai_hpp'] = $total3['nilai_iur'] = $total3['nilai_selisih'] = 0;
						}
						
						/* $GrandTot['nilai_sim']+=$nilai_sim;
						$GrandTot['nilai_px']+=$nilai_px;
						$GrandTot['nilai_hpp']+=$nilai_hpp;
						$GrandTot['nilai_iur']+=$nilai_iur;
						$GrandTot['nilai_selisih']+=$nilai_selisih; */
					}
						
					/* Query Pendapatan parkir */
					$sPar = "SELECT SUM(p.nilai) AS nilai
							FROM
							  k_parkir p 
							INNER JOIN k_ms_kendaraan k 
							   ON k.id = p.ms_kendaraan_id 
							WHERE 0 = 0 AND p.flag = '$flag'
							  {$waktuPark}";
					$qPar = mysql_query($sPar);
					if($qPar){
						$nilai_px = $nilai_sim = 0;
						$dPar = mysql_fetch_array($qPar);
						$nilai_px = $nilai_sim = $dPar['nilai'];
						$nilai_hpp = $nilai_iur = $nilai_selisih = 0;
						
						/* Perhitungan SubTotal Pendapatan Lain-Lain */
						$total3['nilai_sim']+=$nilai_sim;
						$total3['nilai_px']+=$nilai_px;
						$total3['nilai_hpp'] = $total3['nilai_iur'] = $total3['nilai_selisih'] = 0;
					}
					
					/* Cetak Pendapatan Parkir */
					echo "<tr>
							<td align='center'>".$no++."</td>
							<td>Pendapatan Parkir</td>
							<td align='right'>".number_format($nilai_sim,2,",",".")."</td>
							<td align='right'>".number_format($nilai_px,2,",",".")."</td>
							<td align='right'>".number_format($nilai_hpp,2,",",".")."</td>
							<td align='right'>".number_format($nilai_iur,2,",",".")."</td>
							<td align='right'>".number_format($nilai_selisih,2,",",".")."</td>
						</tr>";
						
					/* Cetak SubTotal Pendapatan Lain-Lain */
					echo "<tr>
							<td align='right' colspan='2'>Sub Total</td>
							<td align='right'>".number_format($total3['nilai_sim'],2,",",".")."</td>
							<td align='right'>".number_format($total3['nilai_px'],2,",",".")."</td>
							<td align='right'>".number_format($total3['nilai_hpp'],2,",",".")."</td>
							<td align='right'>".number_format($total3['nilai_iur'],2,",",".")."</td>
							<td align='right'>".number_format($total3['nilai_selisih'],2,",",".")."</td>
						</tr>";
					
					/* Perhitungan Grand Total */
					$GrandTot['nilai_sim']		+= $total3['nilai_sim'];
					$GrandTot['nilai_px']		+= $total3['nilai_px'];
					$GrandTot['nilai_hpp']		+= $total3['nilai_hpp'];
					$GrandTot['nilai_iur']		+= $total3['nilai_iur'];
					$GrandTot['nilai_selisih']	+= $total3['nilai_selisih'];
					
					/* Cetak Grand Total Pendapatan */
					echo "<tr style='background:lightgrey; font-weight:bold;'>
							<td align='right' colspan='2'>Grand Total</td>
							<td align='right'>".number_format($GrandTot['nilai_sim'],2,",",".")."</td>
							<td align='right'>".number_format($GrandTot['nilai_px'],2,",",".")."</td>
							<td align='right'>".number_format($GrandTot['nilai_hpp'],2,",",".")."</td>
							<td align='right'>".number_format($GrandTot['nilai_iur'],2,",",".")."</td>
							<td align='right'>".number_format($GrandTot['nilai_selisih'],2,",",".")."</td>
						</tr>";
				?>
			</table>
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
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>