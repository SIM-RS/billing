<?php
	include("../sesi.php");
    include("../koneksi/konek.php");
    
    $arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'Nopember','12'=>'Desember');
    $waktu = $_POST['cmbWaktu'];
	//echo $_REQUEST['tglAwal2']."<br>";
	$cwaktu=$waktu;
    if($waktu == 'Harian'){
        $tglAwal = explode('-',$_REQUEST['tglAwal2']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        $waktu = "t.tgl = '$tglAwal2' ";
		$waktu2 = "$dbkeuangan.k_transaksi.tgl = '$tglAwal2' ";
		$waktuL = "AND k_transaksi.tgl = '$tglAwal2' ";
        $Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
    }else if($waktu == 'Bulanan'){
        $bln = $_POST['cmbBln'];
        $thn = $_POST['cmbThn'];
		$cbln = ($bln<10)?"0".$bln:$bln;
        $waktu = "month(t.tgl) = '$bln' AND year(t.tgl) = '$thn' ";
		$waktu2 = "month($dbkeuangan.k_transaksi.tgl) = '$bln' AND year($dbkeuangan.k_transaksi.tgl) = '$thn' ";
		$waktuL = "AND month(k_transaksi.tgl) = '$bln' AND year(k_transaksi.tgl) = '$thn' ";
        $Periode = "Bulan $arrBln[$cbln] Tahun $thn";
		$tglAkhir2="$thn-$cbln-".cal_days_in_month(CAL_GREGORIAN, $bln, $thn);
		$tglAwal2="$thn-$cbln-01";
    }else{
        $tglAwal = explode('-',$_REQUEST['tglAwal']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        //echo $_REQUEST['tglAkhir'];
        $tglAkhir = explode('-',$_REQUEST['tglAkhir']);
        $tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
        $waktu = "t.tgl between '$tglAwal2' and '$tglAkhir2' ";
		$waktu2 = "$dbkeuangan.k_transaksi.tgl between '$tglAwal2' and '$tglAkhir2' ";
		$waktuL = "AND k_transaksi.tgl between '$tglAwal2' and '$tglAkhir2' ";
        
        $Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
    }
	/*for($i = 2000; $i < 2009; $i++) {
		echo "$i: ", cal_days_in_month(CAL_GREGORIAN, 2, $i), "\n";
	}*/
	
	$kso = $_REQUEST['cmbKsoRep'];
	$qKso = "";
	if($kso==0){
		$fKso = "SEMUA";
		$qKso = "SELECT DISTINCT kso.id,kso.nama FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_ms_kso kso ON t.kso_id=kso.id WHERE $waktu ORDER BY kso.id";
		$sKso = mysql_query($qKso);
	}else{
		$qKso = "SELECT $dbbilling.b_ms_kso.id, $dbbilling.b_ms_kso.nama FROM $dbbilling.b_ms_kso
WHERE $dbbilling.b_ms_kso.id = '".$kso."'";
		$sKso = mysql_query($qKso);
	}
?>
<title>.: Rekap Pendapatan Billing :.</title>
<table border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
    <tr>
        <td><b>
          <?=$pemkabRS;?>
          <br />
          <?=$namaRS;?>
          <br />
          <?=$alamatRS;?>
          <br />
Telepon
<?=$tlpRS;?>
        </b></td>
    </tr>
    <tr>
        <td style="font-size:14px; height:70px; text-transform:uppercase; text-align:center; font-weight:bold;" valign="top">rekapitulasi penDAPATan Billing<br /><?php echo $Periode;?></td>
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
                            $sql="SELECT IFNULL(SUM(t.qty*t.biaya),0) AS biayaRS,IFNULL(SUM(t.qty*t.biaya_kso),0) AS biayaKSO,IFNULL(SUM(t.qty*t.biaya_pasien),0) AS biayaPx 
    FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id WHERE $waktu $qKso AND p.unit_id='".$rwUnit["id"]."'";
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
                            
                            if ($rwUnit["inap"]==1){
								if($cwaktu == 'Harian'){
									$sql="SELECT SUM(t1.qty*t1.tarip) biayaRS,SUM(t1.qty*t1.beban_kso) biayaKSO,SUM(t1.qty*t1.beban_pasien) biayaPx
FROM (SELECT t1.id,t1.kunjungan_id,t1.unit_id_asal,
IF(t1.status_out=0,IF(t1.tgl_out IS NULL,1,IF(DATEDIFF(t1.tgl_out,t1.tgl_in)=0,1,IF(DATE(t1.tgl_out)='$tglAwal2',0,1))),
IF(t1.tgl_out IS NULL,1,IF(DATEDIFF(t1.tgl_out,'$tglAwal2')=0,0,1))) AS qty,
t1.tarip,t1.beban_kso,t1.beban_pasien
FROM (SELECT p.id,p.kunjungan_id,p.unit_id_asal,t.tgl_in,IFNULL(t.tgl_out,k.tgl_pulang) AS tgl_out,
t.tarip,t.beban_kso,t.beban_pasien,t.bayar,t.bayar_kso,t.bayar_pasien,t.status_out 
FROM $dbbilling.b_tindakan_kamar t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id
INNER JOIN $dbbilling.b_kunjungan k ON k.id=p.kunjungan_id
WHERE p.unit_id='".$rwUnit["id"]."' AND DATE(t.tgl_in)<='$tglAwal2' AND (DATE(t.tgl_out) >='$tglAwal2' OR t.tgl_out IS NULL) 
AND (DATE(k.tgl_pulang) >='$tglAwal2' OR k.tgl_pulang IS NULL) AND p.kso_id = '".$wKso["id"]."' AND t.aktif=1) AS t1) AS t1";
								}else if($waktu == 'Bulanan'){
                                	$sql="SELECT SUM(t2.qty*t2.tarip) biayaRS,SUM(t2.qty*t2.beban_kso) biayaKSO,SUM(t2.qty*t2.beban_pasien) biayaPx
FROM (SELECT t1.id,t1.kunjungan_id,t1.unit_id_asal,DATEDIFF(t1.tgl_out,t1.tgl_in) AS qty,
t1.tarip,t1.beban_kso,t1.beban_pasien
FROM (SELECT p.id,p.kunjungan_id,p.unit_id_asal,IF(DATE(t.tgl_in)<'$tglAwal2','$tglAwal2',t.tgl_in) tgl_in,
IF((DATE(t.tgl_out)>'$tglAkhir2' OR t.tgl_out IS NULL),DATE_ADD('$tglAkhir2',INTERVAL 1 DAY),
IF((DATEDIFF(t.tgl_out,t.tgl_in)=0 AND t.status_out=0),DATE_ADD(t.tgl_out,INTERVAL 1 DAY),t.tgl_out)) AS tgl_out,
t.tarip,t.beban_kso,t.beban_pasien,t.bayar,t.bayar_kso,t.bayar_pasien,t.status_out 
FROM $dbbilling.b_tindakan_kamar t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id
INNER JOIN $dbbilling.b_kunjungan k ON k.id=p.kunjungan_id
WHERE p.unit_id='".$rwUnit["id"]."' AND DATE(t.tgl_in)<='$tglAkhir2' AND (DATE(t.tgl_out) >='$tglAwal2' OR t.tgl_out IS NULL) 
AND (DATE(k.tgl_pulang) >='$tglAwal2' OR k.tgl_pulang IS NULL) AND p.kso_id = '".$wKso["id"]."' AND t.aktif=1) AS t1) AS t2";
								}else{
                                	$sql="SELECT SUM(t2.qty*t2.tarip) biayaRS,SUM(t2.qty*t2.beban_kso) biayaKSO,SUM(t2.qty*t2.beban_pasien) biayaPx
FROM (SELECT t1.id,t1.kunjungan_id,t1.unit_id_asal,DATEDIFF(t1.tgl_out,t1.tgl_in) AS qty,
t1.tarip,t1.beban_kso,t1.beban_pasien
FROM (SELECT p.id,p.kunjungan_id,p.unit_id_asal,IF(DATE(t.tgl_in)<'$tglAwal2','$tglAwal2',t.tgl_in) tgl_in,
IF((DATE(t.tgl_out)>'$tglAkhir2' OR t.tgl_out IS NULL),DATE_ADD('$tglAkhir2',INTERVAL 1 DAY),
IF((DATEDIFF(t.tgl_out,t.tgl_in)=0 AND t.status_out=0),DATE_ADD(t.tgl_out,INTERVAL 1 DAY),t.tgl_out)) AS tgl_out,
t.tarip,t.beban_kso,t.beban_pasien,t.bayar,t.bayar_kso,t.bayar_pasien,t.status_out 
FROM $dbbilling.b_tindakan_kamar t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id
INNER JOIN $dbbilling.b_kunjungan k ON k.id=p.kunjungan_id
WHERE p.unit_id='".$rwUnit["id"]."' AND DATE(t.tgl_in)<='$tglAkhir2' AND (DATE(t.tgl_out) >='$tglAwal2' OR t.tgl_out IS NULL) 
AND (DATE(k.tgl_pulang) >='$tglAwal2' OR k.tgl_pulang IS NULL) AND p.kso_id = '".$wKso["id"]."' AND t.aktif=1) AS t1) AS t2";
								}
                                $rsKmr=mysql_query($sql);
                                $rwKmr=mysql_fetch_array($rsKmr);
                                $biayaRS+=$rwKmr["biayaRS"];
								if ($wKso["id"]==1){
									$biayaPx+=$rwKmr["biayaRS"];
								}else{
									$biayaKSO+=$rwKmr["biayaKSO"];
									$biayaPx1+=$rwKmr["biayaPx"];
								}
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
				  <td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;GRAND TOTAL</td>
				  <td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($GrandTot1,0,",","."); ?>&nbsp;</td>
				  <td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($GrandTot2,0,",","."); ?>&nbsp;</td>
				  <td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($GrandTot3,0,",","."); ?>&nbsp;</td>
				  <td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($GrandTot4,0,",","."); ?>&nbsp;</td>
				  <td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($GrandTot5,0,",","."); ?>&nbsp;</td>
			  </tr>
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