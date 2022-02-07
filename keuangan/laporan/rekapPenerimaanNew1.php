<?php
	include('../sesi.php');
	$excell = $_REQUEST['excell'];
	if ($excell=="1"){
		header("Content-type: application/vnd.ms-excel");
		header('Content-Disposition: attachment; filename="Lap Pengajuan Klaim.xls"');		
	}
	
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
		$waktuF = "p.TGL between '$tglAwal2' and '$tglAkhir2' ";
		//$waktu2 = "$dbkeuangan.k_transaksi.tgl between '$tglAwal2' and '$tglAkhir2' ";
		//$waktuL = "AND k.tgl between '$tglAwal2' and '$tglAkhir2' ";
        
        $Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
    }
	/*for($i = 2000; $i < 2009; $i++) {
		echo "$i: ", cal_days_in_month(CAL_GREGORIAN, 2, $i), "\n";
	}*/
	
	$IdTransBilling=38;
	$IdTransFarmasi=39;
	
	$fIdTrans=" AND (t.id_trans=$IdTransBilling OR t.id_trans=$IdTransFarmasi)";
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
	
	$ptitle="Rekap Penerimaan Billing + Farmasi";
	$lblTotalP="TOTAL PENERIMAAN BILLING + FARMASI";
	$fFarmasi="";
	if ($isFarmasi=="0"){
		$ptitle="Rekap Penerimaan Billing";
		$lblTotalP="TOTAL PENERIMAAN BILLING";
		$fFarmasi=" AND t.isFarmasi<>2";
	}elseif ($isFarmasi=="1"){
		$ptitle="Rekap Penerimaan Farmasi";
		$lblTotalP="TOTAL PENERIMAAN FARMASI";
		$fFarmasi=" AND t.isFarmasi=2";
	}
	
	if ($isPavilyun=="" && $isFarmasi=="") $tipe=="all";

	$kso = $_REQUEST['cmbKsoRep'];
	$qKso = "";
	if($kso==0){
		$fKso = "SEMUA";
		$qKso = "SELECT DISTINCT
					  kso.id,
					  kso.nama
					FROM $dbkeuangan.k_transaksi t
					  INNER JOIN $dbbilling.b_ms_kso kso
						ON t.kso_id = kso.id
					WHERE 1=1 $waktu
						AND t.tipe_trans = '1'
						$fPav
						$fFarmasi
						$fIdTrans
					ORDER BY kso_id";
	}else{
		$qKso = "SELECT $dbbilling.b_ms_kso.id, $dbbilling.b_ms_kso.nama FROM $dbbilling.b_ms_kso
WHERE $dbbilling.b_ms_kso.id = '".$kso."'";
		/*$qKso = "SELECT DISTINCT
					  kso.id,
					  kso.nama
					FROM $dbkeuangan.k_transaksi t
					  INNER JOIN $dbbilling.b_ms_kso kso
						ON t.kso_id = kso.id
					WHERE t.tgl BETWEEN '$tglAwal2'
						AND '$tglAkhir2'
						AND t.tipe_trans = '1'
						AND kso.id='$kso'
						$fIdTrans";*/
	}
	//echo $qKso.";<br>";
	$sKso = mysql_query($qKso);
?>
<title>.: <?php echo $ptitle; ?> :.</title>
<table border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
    <tr>
        <td><b><?=$pemkabRS;?><br><?=$namaRS;?><br><?=$alamatRS;?><br>Telepon <?=$tlpRS;?></b></td>
    </tr>
    <tr>
        <td style="font-size:14px; height:70px; text-transform:uppercase; text-align:center; font-weight:bold;" valign="top"><?php echo $ptitle;?><br /><?php echo $Periode;?></td>
    </tr>
	<tr>
		<td>
			<table border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
				
				<tr style="text-align:center; font-weight:bold">
				  <td width="30" style="border-top:1px solid #000000; border-right:1px solid #000000; border-left:1px solid #000000; border-bottom:1px solid #000000;">NO</td>
				  	<td width="250" style="border-top:1px solid #000000; border-bottom:1px solid; border-right:1px solid;">UNIT PELAYANAN</td>
					<td width="100" style="border-top:1px solid #000000; border-bottom:1px solid #000000; border-right:1px solid;">TARIP PERDA</td>
				    <td width="100" style="border-top:1px solid #000000; border-bottom:1px solid #000000; border-right:1px solid;">BIAYA PASIEN</td>
				    <td width="100" style="border-top:1px solid #000000; border-bottom:1px solid #000000; border-right:1px solid;">TARIP KSO</td>
				    <td width="100" style="border-top:1px solid #000000; border-bottom:1px solid #000000; border-right:1px solid;">IUR BIAYA</td>
				    <td width="100" style="border-top:1px solid #000000; border-bottom:1px solid #000000; border-right:1px solid;">SELISIH</td>
				</tr>
				<tr style="text-align:center; font-weight:bold">
				  	<td style="border-bottom:1px solid #000000; border-right:1px solid #000000; border-left:1px solid #000000;">1</td>
					<td style="border-bottom:1px solid #000000; border-right:1px solid #000000;">2</td>
				    <td width="100" style="border-bottom:1px solid #000000; border-right:1px solid;">3</td>
				    <td width="100" style="border-bottom:1px solid #000000; border-right:1px solid;">4</td>
				    <td width="100" style="border-bottom:1px solid #000000; border-right:1px solid;">5</td>
				    <td width="100" style="border-bottom:1px solid #000000; border-right:1px solid;">6</td>
				    <td width="100" style="border-bottom:1px solid #000000; border-right:1px solid;">7</td>
				</tr>
                <?php 
				$GrandTot1=0;
				$GrandTot2=0;
				$GrandTot3=0;
				$GrandTot4=0;
				$GrandTot5=0;
				while ($wKso = mysql_fetch_array($sKso)){
					$qKso = " AND t.kso_id='".$wKso["id"]."'";
				?>
				<tr bgcolor="#4F71F9">
				  <td colspan="2" style="border-left:1px solid #000000; border-right:1px solid #000000; font-weight:bold; text-decoration:underline;font-size:12px">&nbsp;&nbsp;<?php echo $wKso["nama"]; ?>&nbsp;</td>
				  <td style="border-right:1px solid #000000;">&nbsp;</td>
				  <td style="border-right:1px solid #000000;">&nbsp;</td>
				  <td style="border-right:1px solid #000000;">&nbsp;</td>
				  <td style="border-right:1px solid #000000;">&nbsp;</td>
				  <td style="border-right:1px solid #000000;">&nbsp;</td>
			    </tr>
					<?php 
                    $sql="SELECT * FROM $dbbilling.b_ms_unit mu WHERE mu.level=1 AND mu.kategori=2";
                    $rsJPel=mysql_query($sql);
					$SubTot1=0;
					$SubTot2=0;
					$SubTot3=0;
					$SubTot4=0;
					$SubTot5=0;
                    while($rwJPel=mysql_fetch_array($rsJPel)){
                    ?>
				<tr>
				 	<td colspan="2" bgcolor="#FF7777" style="border-left:1px solid #000000; border-right:1px solid #000000; padding-left:50px; font-weight:bold; text-decoration:underline;">&nbsp;<?php echo $rwJPel["nama"]; ?></td>
					<td width="100" style="border-right:1px solid #000000;">&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000;">&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000;">&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000;">&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000;">&nbsp;</td>
				</tr>
						<?php 
                        $sql="SELECT * FROM $dbbilling.b_ms_unit mu WHERE mu.parent_id='".$rwJPel["id"]."' AND mu.aktif=1 ORDER BY mu.nama";
                        $rsUnit=mysql_query($sql);
                        $j=0;
                        $TotPerJPel1=0;
                        $TotPerJPel2=0;
                        $TotPerJPel3=0;
                        $TotPerJPel4=0;
                        $TotPerJPel5=0;
                        while($rwUnit=mysql_fetch_array($rsUnit)){
                            $j++;
                            $sql="SELECT DISTINCT
									  IFNULL(SUM(t.nilai_sim),0) AS biayaRS,
									  IFNULL(SUM(t.nilai_hpp),0) AS biayaKSO,
									  IFNULL(SUM(t.nilai),0) AS biayaPx
									FROM $dbkeuangan.k_transaksi t
									WHERE 1=1 $waktu
										AND t.tipe_trans = '1'
										$qKso
										AND t.unit_id_billing='".$rwUnit["id"]."'
										$fPav
										$fFarmasi
										$fIdTrans";
                            $rsTind=mysql_query($sql);
                            $rwTind=mysql_fetch_array($rsTind);
                            $biayaRS=$rwTind["biayaRS"];
							if ($wKso["id"]==1){
								$biayaKSO=0;
								$biayaPx=$biayaRS;
								$biayaPx1=0;
							}else{
								$biayaKSO=$rwTind["biayaKSO"];
								$biayaPx1=$rwTind["biayaPx"];
								$biayaPx=0;
							}
							
                            $selisih=$biayaRS-($biayaKSO+$biayaPx+$biayaPx1);
                            
                            $TotPerJPel1+=$biayaRS;
                            $TotPerJPel2+=$biayaPx;
                            $TotPerJPel3+=$biayaKSO;
                            $TotPerJPel4+=$biayaPx1;
                            $TotPerJPel5+=$selisih;
                        ?>
				<tr>
				  	<td style="border-left:1px solid #000000; border-right:1px solid #000000;; text-align:center"><?php echo $j; ?></td>
					<td style="border-right:1px solid #000000; text-transform:uppercase">&nbsp;<?php echo $rwUnit["nama"]; ?></td>
					<td width="100" style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($biayaRS,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($biayaPx,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($biayaKSO,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($biayaPx1,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($selisih,0,",","."); ?>&nbsp;</td>
				</tr>
						<?php 
                        }
                        ?>
				<tr style="font-weight:bold;">
				  	<td style="border-left:1px solid #000000; border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;JUMLAH</td>
					<td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($TotPerJPel1,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($TotPerJPel2,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($TotPerJPel3,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($TotPerJPel4,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($TotPerJPel5,0,",","."); ?>&nbsp;</td>
				</tr>
					<?php 
                        $SubTot1+=$TotPerJPel1;
                        $SubTot2+=$TotPerJPel2;
                        $SubTot3+=$TotPerJPel3;
                        $SubTot4+=$TotPerJPel4;
                        $SubTot5+=$TotPerJPel5;
                    }
                    ?>
                <?php 
				//if ($isFarmasi=="0" || $isFarmasi==""){
				?>
				<tr>
				 	<td colspan="2" bgcolor="#FF7777" style="border-left:1px solid #000000; border-right:1px solid #000000; padding-left:50px; font-weight:bold; text-decoration:underline;">&nbsp;PENUNJANG LAINNYA</td>
					<td width="100" style="border-right:1px solid #000000;">&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000;">&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000;">&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000;">&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000;">&nbsp;</td>
				</tr>
                <?php 
				$j=0;
				$sTotLain2=0;
				if ($isFarmasi=="0" || $isFarmasi==""){
					$sql="SELECT * FROM k_ms_transaksi WHERE tipe=1 AND jenisLay=1";
					$rsLain2=mysql_query($sql);
					//$sTotLain2=0;
					//$j=0;
					while ($rwLain2=mysql_fetch_array($rsLain2)){
						$j++;
						if ($wKso["id"]==1){
							$sql="SELECT IFNULL(SUM(t.nilai),0) AS nilai FROM k_transaksi t WHERE t.id_trans='".$rwLain2["id"]."' $waktu $fPav";
							$rsnLain2=mysql_query($sql);
							$rwnLain2=mysql_fetch_array($rsnLain2);
							$nLain2=$rwnLain2["nilai"];
						}else{
							$nLain2=0;
						}
						
						$sTotLain2+=$nLain2;
				?>
				<tr>
				  	<td style="border-left:1px solid #000000; border-right:1px solid #000000;; text-align:center"><?php echo $j; ?></td>
					<td style="border-right:1px solid #000000; text-transform:uppercase">&nbsp;<?php echo $rwLain2["nama"]; ?></td>
					<td width="100" style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($nLain2,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($nLain2,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; text-align:right;">0&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; text-align:right;">0&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; text-align:right;">0&nbsp;</td>
				</tr>
                <?php 
					}
					$SubTot1+=$sTotLain2;
					$SubTot2+=$sTotLain2;
				}
				?>
                <?php 
				//echo "isFarmasi=$isFarmasi<br>";
				if ($isFarmasi=="1" || $isFarmasi==""){
					$sql="SELECT
							  IFNULL(SUM(t.nilai),0) AS nFarmasi,
							  IFNULL(SUM(t.nilai_sim),0) AS nFarmasi_sim,
							  IFNULL(SUM(t.nilai_hpp),0) AS nFarmasi_hpp
							FROM k_transaksi t
							WHERE 1=1 $waktu
								AND t.tipe_trans = '1'
								$fIdTrans $fFarmasi
								AND t.unit_id_billing = 0
								$qKso";
					$rsFarm=mysql_query($sql);
					$rwFarm=mysql_fetch_array($rsFarm);
					$nFarm=$rwFarm["nFarmasi_sim"];
					$j++;
					
					$sTotLain2+=$nFarm;
					$SubTot1+=$nFarm;
					$SubTot2+=$nFarm;
				?>
				<tr>
				  	<td style="border-left:1px solid #000000; border-right:1px solid #000000;; text-align:center"><?php echo $j; ?></td>
					<td style="border-right:1px solid #000000; text-transform:uppercase">&nbsp;FARMASI</td>
					<td width="100" style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($nFarm,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($nFarm,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; text-align:right;">0&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; text-align:right;">0&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; text-align:right;">0&nbsp;</td>
				</tr>
                <?php 
				}
				?>
				<tr style="font-weight:bold;">
				  	<td style="border-left:1px solid #000000; border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;JUMLAH</td>
					<td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($sTotLain2,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($sTotLain2,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;">0&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;">0&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;">0&nbsp;</td>
				</tr>
                <?php 
				//}
				?>
				<tr style="font-weight:bold;">
				  	<td style="border-left:1px solid #000000; border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;SUB TOTAL</td>
					<td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($SubTot1,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($SubTot2,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($SubTot3,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($SubTot4,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($SubTot5,0,",","."); ?>&nbsp;</td>
				</tr>
				<?php 
					$GrandTot1+=$SubTot1;
					$GrandTot2+=$SubTot2;
					$GrandTot3+=$SubTot3;
					$GrandTot4+=$SubTot4;
					$GrandTot5+=$SubTot5;
                }
                ?>
				<tr style="font-weight:bold;">
                  <td style="border-left:1px solid #000000; border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;</td>
				  <td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;text-transform:uppercase;">&nbsp;<?php echo $lblTotalP; ?></td>
				  <td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($GrandTot1,0,",","."); ?>&nbsp;</td>
				  <td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($GrandTot2,0,",","."); ?>&nbsp;</td>
				  <td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($GrandTot3,0,",","."); ?>&nbsp;</td>
				  <td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($GrandTot4,0,",","."); ?>&nbsp;</td>
				  <td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($GrandTot5,0,",","."); ?>&nbsp;</td>
			  </tr>
              <?php 
			  if ($tipe=="all"){
			  ?>
				<tr style="font-weight:bold;" bgcolor="#4F71F9">
				  <td colspan="2" style="border-left:1px solid #000000; border-right:1px solid #000000; font-weight:bold; text-decoration:underline;font-size:12px">&nbsp;&nbsp;Pendapatan Lain - Lain&nbsp;</td>
				  <td style="border-right:1px solid #000000; text-align:right;">&nbsp;</td>
				  <td style="border-right:1px solid #000000; text-align:right;">&nbsp;</td>
				  <td style="border-right:1px solid #000000; text-align:right;">&nbsp;</td>
				  <td style="border-right:1px solid #000000; text-align:right;">&nbsp;</td>
				  <td style="border-right:1px solid #000000; text-align:right;">&nbsp;</td>
			  	</tr>
                <?php 
				$sql="SELECT * FROM k_ms_transaksi WHERE tipe=1 AND jenisLay<>1 AND aktif=1";
				$rsLain2=mysql_query($sql);
				$sTotLain2=0;
				$j=0;
				while ($rwLain2=mysql_fetch_array($rsLain2)){
					$j++;
					$sql="SELECT IFNULL(SUM(t.nilai),0) AS nilai FROM k_transaksi t WHERE t.id_trans='".$rwLain2["id"]."' $waktuL $fPav";
					$rsnLain2=mysql_query($sql);
					$rwnLain2=mysql_fetch_array($rsnLain2);
					$sTotLain2+=$rwnLain2["nilai"];
				?>
				<tr>
				  	<td style="border-left:1px solid #000000; border-right:1px solid #000000;; text-align:center"><?php echo $j; ?></td>
					<td style="border-right:1px solid #000000; text-transform:uppercase">&nbsp;<?php echo $rwLain2["nama"]; ?></td>
					<td width="100" style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($rwnLain2["nilai"],0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($rwnLain2["nilai"],0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; text-align:right;">&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; text-align:right;">&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; text-align:right;">&nbsp;</td>
				</tr>
                <?php 
				}
				$GrandTot1+=$sTotLain2;
				$GrandTot2+=$sTotLain2;
				?>
				<tr style="font-weight:bold;">
				  	<td style="border-left:1px solid #000000; border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;TOTAL PENDAPATAN LAIN-LAIN</td>
					<td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($sTotLain2,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($sTotLain2,0,",","."); ?>&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;">&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;">&nbsp;</td>
				    <td width="100" style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;">&nbsp;</td>
				</tr>
				<tr style="font-weight:bold;">
                  <td style="border-left:1px solid #000000; border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;</td>
				  <td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;GRAND TOTAL</td>
				  <td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($GrandTot1,0,",","."); ?>&nbsp;</td>
				  <td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($GrandTot2,0,",","."); ?>&nbsp;</td>
				  <td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($GrandTot3,0,",","."); ?>&nbsp;</td>
				  <td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($GrandTot4,0,",","."); ?>&nbsp;</td>
				  <td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($GrandTot5,0,",","."); ?>&nbsp;</td>
			  </tr>
              <?php 
			  }
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