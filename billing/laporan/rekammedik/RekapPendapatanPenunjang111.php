<?
include("../../sesi.php");
?>
<title>.: Laporan Pendapatan dan Jumlah Penderita :.</title>
<?php
    include("../../koneksi/konek.php");
    $date_now=gmdate('d-m-Y',mktime(date('H')+7));
    $jam = date("G:i");
    set_time_limit('5000');
    $arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
    
    $waktu = $_POST['cmbWaktu'];
    if($waktu == 'Harian'){
    	$tglAwal = explode('-',$_REQUEST['tglAwal2']);
    	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
    	$waktu = " and b_tindakan.tgl = '$tglAwal2' ";
    	$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
    }else if($waktu == 'Bulanan'){
    	$bln = $_POST['cmbBln'];
    	$thn = $_POST['cmbThn'];
    	$waktu = " and month(b_tindakan.tgl) = '$bln' and year(b_tindakan.tgl) = '$thn' ";
    	$Periode = "Bulan $arrBln[$bln] Tahun $thn";
    }else{
    	$tglAwal = explode('-',$_REQUEST['tglAwal']);
    	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
    	//echo $arrBln[$tglAwal[1]];
    	$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
    	$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
    	$waktu = " and b_tindakan.tgl between '$tglAwal2' and '$tglAkhir2' ";
    	
    	$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
    }
	
    $jnsLay = $_REQUEST['cmbJnsPenunjang'];
    $tmpLay = $_REQUEST['cmbTmpPenunjang'];
	$asal = $_REQUEST['cmbAsal'];
    $stsPas = $_REQUEST['StatusPas'];
	if($stsPas!=0)
	{
		$fKso = " AND b_tindakan.kso_id = '".$stsPas."'";
	}
	
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
	
	if($asal==0){
		$jns = "b_pelayanan.jenis_kunjungan <> '3'";
	}else{
		$jns = "b_pelayanan.jenis_kunjungan = '3'";
	}
    
	$unit = $_REQUEST['cmbUnit'];
	if($unit==1){ /*poli*/
		$fUnit = "AND b_ms_unit.parent_id='1'";
	}else if($unit==2){ /*lainnya*/
		$fUnit = "AND (b_ms_unit.id = '72' OR b_ms_unit.id = '112' OR b_ms_unit.parent_id<>'50') AND b_ms_unit.parent_id<>'1'";
	}else{ /*semua*/
		$fUnit = "AND (b_ms_unit.id = '72' OR b_ms_unit.id = '112' OR b_ms_unit.parent_id<>'50')";
	}
	
?>
<table width="1200" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
	<tr>
		<td><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
	</tr>
	<tr>
		<td height="70" valign="top" style="font-size:14px; font-weight:bold; text-align:center; text-transform:uppercase;">laporan pendapatan dan jumlah penderita <?php echo $rwUnit2['nama'];?><br>Status Pasien <?php if($stsPas==0) echo "SEMUA"; else echo $rwKso['nama'];?><br /><?php echo $Periode;?></td>
	</tr>
	<tr>
		<td height="30" style="text-transform:uppercase">&nbsp;<b>Asal Tempat Layanan <?php if($asal==0) echo "RAWAT JALAN"; else echo "RAWAT INAP";?></b></td>
	</tr>
	<tr>
		<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:9px;">
				<tr>
					<td rowspan="2" style="text-align:center; border-top:1px solid #000000; border-left:1px solid #000000; border-bottom:1px solid #000000; border-right:1px solid #000000; font-weight:bold;">NO</td>
					<td rowspan="2" style="text-align:center; border-top:1px solid #000000; border-bottom:1px solid #000000; border-right:1px solid #000000; font-weight:bold;">CARA BAYAR</td>
					<?php
							if($asal=='1'){
								$sql = "SELECT b_ms_unit.id, b_ms_unit.nama, b_ms_unit.parent_id FROM b_pelayanan 
									INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
									INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id_asal 
									WHERE $jns AND b_pelayanan.unit_id = '".$tmpLay."' $fKso $waktu 
									AND b_ms_unit.parent_id NOT IN (94,50)
									GROUP BY b_ms_unit.id 
										UNION 
									SELECT b_ms_unit.id, IF(b_ms_unit.parent_id=94,'IPIT','PAVILIUN') AS nama, 
									b_ms_unit.parent_id FROM b_pelayanan 
									INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
									INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id_asal 
									WHERE $jns AND b_pelayanan.unit_id = '".$tmpLay."' $fKso $waktu
									AND b_ms_unit.parent_id IN (94,50) GROUP BY b_ms_unit.parent_id";
							}else{
								$sql = "SELECT b_ms_unit.id, b_ms_unit.nama FROM b_pelayanan
										INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
										INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id_asal
										WHERE $jns AND b_pelayanan.unit_id = '".$tmpLay."' $fUnit $fKso $waktu
										GROUP BY b_ms_unit.id
										ORDER BY b_ms_unit.nama";
							}
							//echo '<br>'.$sql;
							$rs = mysql_query($sql);
							$col = 0;
							while($rw = mysql_fetch_array($rs))
							{
								$col++;
					?>
					<td colspan="2" style="text-align:center; font-size:9px; font-weight:bold; border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;"><?php echo $rw['nama']?></td>
					<?php
							}
					?>
					<td colspan="2" style="text-align:center; font-size:14px; font-weight:bold; border-bottom:1px solid #000000; border-right:1px solid #000000; border-top:1px solid #000000;">&sum;</td>
				</tr>
				<tr>
					<?php
				 		 for($i=0; $i<$col; $i++){
					?>
					<td style="text-align:center; border-bottom:1px solid #000000; border-right:1px solid #000000; font-weight:bold;">PX</td>
					<td style="text-align:center; border-bottom:1px solid #000000; border-right:1px solid #000000; font-weight:bold;">(Rp.)</td>
					<?php
						}
					?>
					<td style="text-align:center; font-weight:bold; border-bottom:1px solid #000000; border-right:1px solid #000000;">PX</td>
					<td style="text-align:center; font-weight:bold; border-bottom:1px solid #000000; border-right:1px solid #000000;">(Rp.)</td>
				</tr>
				<?php
						if($asal=='1'){
							$qSts = "SELECT b_ms_kso.id, b_ms_kso.nama FROM b_kunjungan 
                                INNER JOIN b_pelayanan ON b_kunjungan.id = b_pelayanan.kunjungan_id
                                INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
                                INNER JOIN b_ms_kso ON b_ms_kso.id = b_tindakan.kso_id
                                INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id_asal
                                WHERE $jns AND b_pelayanan.unit_id = '".$tmpLay."' $fKso $waktu
                                GROUP BY b_ms_kso.id
                                ORDER BY b_ms_kso.nama";
						}else{
							$qSts = "SELECT b_ms_kso.id, b_ms_kso.nama FROM b_kunjungan 
                                INNER JOIN b_pelayanan ON b_kunjungan.id = b_pelayanan.kunjungan_id
                                INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
                                INNER JOIN b_ms_kso ON b_ms_kso.id = b_tindakan.kso_id
                                INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id_asal
                                WHERE $jns AND b_pelayanan.unit_id = '".$tmpLay."' $fUnit $fKso $waktu
                                GROUP BY b_ms_kso.id
                                ORDER BY b_ms_kso.nama";
						}
						//echo $qSts."</br>";
						$rsSts = mysql_query($qSts);
						$no = 1;
						while($rwSts = mysql_fetch_array($rsSts))
						{
							$totpx = 0;
							$totrp = 0;
							
				?>
				<tr>
					<td width="5" style="text-align:center; border-left:1px solid #000000; border-bottom:1px solid #000000; border-right:1px solid #000000;"><?php echo $no;?></td>
					<td style="border-bottom:1px solid #000000; border-right:1px solid #000000;">&nbsp;<?php echo $rwSts['nama']?></td>
					<?php
				 			$rs = mysql_query($sql);
							$j=0;
							while($rw = mysql_fetch_array($rs))
							{
								if($rw['parent_id']=='50' || $rw['parent_id']=='94' ){
									$sPrt = "AND b_ms_unit.parent_id='".$rw['parent_id']."'";
								}else{
									$sPrt = "AND b_ms_unit.id='".$rw['id']."'";
								}
								if($rwSts['id']!=1){
    								$sqlQ = "SELECT COUNT(t.id) AS px, SUM(t.biaya_kso) AS rp 
											FROM (SELECT b_pelayanan.id, SUM(b_tindakan.biaya_kso) AS biaya_kso
											FROM b_kunjungan
											INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id
											INNER JOIN b_ms_unit ON b_ms_unit.id=b_pelayanan.unit_id_asal
											INNER JOIN b_tindakan ON b_tindakan.pelayanan_id=b_pelayanan.id
											WHERE $jns $sPrt AND b_tindakan.kso_id='".$rwSts['id']."'
											$waktu AND b_pelayanan.unit_id = '".$tmpLay."'
											GROUP BY b_pelayanan.id) AS t";
								}else{
    								$sqlQ = "SELECT COUNT(t.id) AS px, SUM(t.biaya_pasien) AS rp 
											FROM (SELECT b_pelayanan.id, SUM(b_tindakan.biaya_pasien) AS biaya_pasien
											FROM b_kunjungan
											INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id
											INNER JOIN b_ms_unit ON b_ms_unit.id=b_pelayanan.unit_id_asal
											INNER JOIN b_tindakan ON b_tindakan.pelayanan_id=b_pelayanan.id
											WHERE $jns $sPrt  AND b_tindakan.kso_id='".$rwSts['id']."'
											$waktu AND b_pelayanan.unit_id = '".$tmpLay."'
											GROUP BY b_pelayanan.id) AS t";
								}
                                //echo $sqlQ."<br>";
								$rsQ = mysql_query($sqlQ);
								$rwQ = mysql_fetch_array($rsQ);
								$totpx = $totpx + $rwQ['px'];
								$totrp = $totrp + $rwQ['rp'];
								$px[$j] += $rwQ['px']; 
							 	$rp[$j] += $rwQ['rp'];
								$j++;
						
							 
					?>
					<td style="border-bottom:1px solid #000000; border-right:1px solid #000000; text-align:center" width="25"><?php if($rwQ['px']=="") echo 0; else echo $rwQ['px']; ?></td>
					<td style="border-bottom:1px solid #000000; border-right:1px solid #000000; text-align:right" width="80"><?php if($rwQ['rp']=="") echo 0; else echo number_format($rwQ['rp'],0,",",".");?>&nbsp;</td>
					<?php
							} mysql_free_result($rs);
							$totalpx += $totpx;
							$totalrp += $totrp;
					?>
					<td style="border-bottom:1px solid #000000; border-right:1px solid #000000; text-align:center" width="25"><?php echo $totpx;?></td>
					<td style="border-bottom:1px solid #000000; border-right:1px solid #000000; text-align:right" width="100"><?php echo number_format($totrp,0,",",".");?>&nbsp;</td>
				</tr>
				<?php
						$no++;
						}mysql_free_result($rsSts);
				?>
				<tr>
					<td colspan="2" style="text-align:right; font-weight:bold; border-left:1px solid #000000; border-bottom:1px solid #000000; border-right:1px solid #000000;" height="30">TOTAL&nbsp;</td>
					<?php
				  			for($i=0; $i<$col; $i++){
					?>
					<td style="border-right:1px solid #000000; border-bottom:1px solid #000000; text-align:center; font-weight:bold;"><?php echo $px[$i];?></td>
					<td style="border-right:1px solid #000000; border-bottom:1px solid #000000; text-align:right; font-weight:bold;"><?php echo number_format($rp[$i],0,",",".");?>&nbsp;</td>
					<?php
							}
					?>
					<td style="border-right:1px solid #000000; border-bottom:1px solid #000000; text-align:center; font-weight:bold;"><?php echo $totalpx;?></td>
					<td style="border-right:1px solid #000000; border-bottom:1px solid #000000; text-align:right; font-weight:bold;"><?php echo number_format($totalrp,0,",",".");?>&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
        <td style="text-align:right; height:70" valign="top">Tgl Cetak:&nbsp;<?php echo $date_now.'&nbsp;Jam:&nbsp;'.$jam;?>&nbsp;<br>Yang Mencetak,</td>
    </tr>
    <tr>
        <td style="text-align:right; font-weight:bold; text-transform:uppercase;"><?php echo $rwPeg['nama']?>&nbsp;</td>
    </tr>
    <tr id="trTombol">
        <td class="noline" align="center">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>        </td>
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
function cetak(tombol){
	tombol.style.visibility='hidden';
	if(tombol.style.visibility=='hidden'){
		window.print();
		window.close();
	}
}
</script>